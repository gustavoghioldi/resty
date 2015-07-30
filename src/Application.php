<?php
/**
 * Application.php
 *
 * PHP version 5.6+
 *
 * Copyright (c) 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed
 * with this source code.
 *
 * @category  Resty
 * @package   Resty
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
namespace Resty;

// Resty
use Resty\Environment;
use Resty\Exceptions\InvalidEnvironmentException;

// HttpFoundation
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// HttpKernel
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\TerminableInterface;

/**
 * Application
 *
 * @category  Resty
 * @package   Resty
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class Application implements HttpKernelInterface, TerminableInterface
{
    /**
     * Instancia del container
     * @var Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container = null;
    /**
     * Ambiente actual
     * @var string
     */
    protected $env = null;
    /**
     * Directorio cache
     * @var string
     */
    protected $projectCache = 'cache/';

    /**
     * Constructor
     */
    public function __construct()
    {
    }
    /**
     * Setea el ambiente. 
     * 
     * Los valores posibles son:
     *  * Resty\Environment::DEV
     *  * Resty\Environment::TEST
     *  * Resty\Environment::DEV
     *  
     * @param string $env Ambiente
     * 
     * @return self
     */
    public function setEnv($env)
    {
        if (false === Environment::validate($env)) {
            throw new InvalidEnvironmentException("Invalid Environment");
        }
        $this->env = $env;
        return $this;
    }
    /**
     * Crea el Container con todos los archivos de configuracion y genera el cache si el ambiente es producción.
     * Si el ambiente es prod y ya esta cacheado no lo vuelve a generar
     * 
     * @return void
     */
    public function createContainer()
    {
        $rootPath = realpath(__DIR__.'/../../../../').'/';
        // Container
        $builder = new \Zendo\Di\Cache\Builder();
        $builder->addConfigurationFiles(['config.yml', 'config.'.$this->env.'.yml'])
            ->addConfigurationDirectories(
                [
                    $rootPath.'vendor/restyphp/resty/config',
                    $rootPath.'config'
                ]
            )
            ->setCacheDir($rootPath.$this->projectCache)
            ->addCustomParameters('root_path', $rootPath)
            ->addCustomParameters('env', $this->env);

        //Si no es prod => genera la metadata para que ante cualquier cambio de la conf se actualice el cache del container
        //Si es prod => no genera el metadata para optimización
        if (Environment::PROD !== $this->env) {
            $builder->setIsDebug(true);
        }
        
        $this->container = $builder->get();
    }
    /**
     * Devuelve el container
     * 
     * @return Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected function getContainer()
    {
        return $this->container;
    }
    /**
     * Handles the request and delivers the response.
     *
     * @param Request|null $request Request to process
     *
     * @return void
     */
    public function run(Request $request = null)
    {
        // crea el container
        $this->createContainer();

        if (null === $request) {
            $request = Request::createFromGlobals();
        }

        $response = $this->handle($request);
        $response->send();

        $this->terminate($request, $response);
    }
    /**
     * Handles a Request to convert it to a Response.
     *
     * When $catch is true, the implementation must catch all exceptions
     * and do its best to convert them to a Response instance.
     *
     * @param Request $request A Request instance
     * @param int     $type    The type of the request
     *                         (one of HttpKernelInterface::MASTER_REQUEST or HttpKernelInterface::SUB_REQUEST)
     * @param bool    $catch   Whether to catch exceptions or not
     *
     * @return Response A Response instance
     *
     * @throws \Exception When an Exception occurs during processing
     *
     * @api
     */
    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        return $this->container->get("http_kernel")->handle($request, $type, $catch);
    }
    /**
     * Terminates a request/response cycle.
     *
     * Should be called after sending the response and before shutting down the kernel.
     *
     * @param Request  $request  A Request instance
     * @param Response $response A Response instance
     *
     * @return void
     */
    public function terminate(Request $request, Response $response)
    {
        $this->container->get("http_kernel")->terminate($request, $response);
    }
}
