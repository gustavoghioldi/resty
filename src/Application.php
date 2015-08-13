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
     * Directorio donde se almacenara el cache
     * Por defecto el proyecto debe tener un directorio que se llama cache en el rootpath y debe tener permisos de escritura
     */
    const CACHE_DIR_DEFAULT = 'cache/';
    const CONFIG_DIR = 'config/';
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
     * RootPath del proyecto
     * @var string
     */
    protected $projectRootPath = '';
    /**
     * Listado de providers
     * @var array
     */
    protected $providers = [];
    /**
     * Paths donde buscar los archivos de configuracion
     * Aca estarán todos los paths que definan lost distintos provider y los custom
     * @var array
     */
    protected $configPaths = [];
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->projectRootPath = realpath(__DIR__.'/../../../../').'/';
        $this->env = \Resty\Environment::DEV;
    }
    /**
     * Devuelve el directorio donde se almacenara el cache
     *
     * @return string
     */
    protected function cacheDir()
    {
        return $this->projectRootPath.static::CACHE_DIR_DEFAULT;
    }
    /**
     * Setea el ambiente.
     *
     * Los valores posibles son:
     *  * Resty\Environment::DEV
     *  * Resty\Environment::TEST
     *  * Resty\Environment::PROD
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
     * Registra un provider
     *
     * @param Object $provider Una instancia del provider
     *
     * @return self
     */
    public function register($provider)
    {
        $this->providers[] = $provider;
        $provider->register($this);
        return $this;
    }
    /**
     * Agrega un path donde buscar las configuraciones
     *
     * @param string $path Path donde hay archivos de configuracion
     *
     * @return void
     */
    public function addConfigPath($path)
    {
        $this->configPaths[] = $path;
        return $this;
    }
    /**
     * Devuelve los nombres de los archivos de configuración que se buscan para armar el container.
     * Solo tiene en cuenta: config.yml y config.{env}.yml
     *
     * @return array
     */
    protected function getConfigFileNames()
    {
        return ['config.yml', 'config.'.$this->env.'.yml'];
    }
    /**
     * Devuelve los paths donde busca el container los archivos de configuración
     *
     * @return array
     */
    protected function getConfigPaths()
    {
        //custom & provider config
        $paths = $this->configPaths;
        //resty config
        $paths[] = realpath(__DIR__.'/../')."/".static::CONFIG_DIR;
        //project config
        $paths[] = $this->projectRootPath."/".static::CONFIG_DIR;
        return $paths;
    }
    /**
     * Crea el Container con todos los archivos de configuracion y genera el cache si el ambiente es producción.
     * Si el ambiente es prod y ya esta cacheado no lo vuelve a generar
     *
     * @return void
     */
    public function createContainer()
    {
        // Container
        $builder = new \Zendo\Di\Cache\Builder();
        $builder->addFiles($this->getConfigFileNames())
            ->addDirectories($this->getConfigPaths())
            ->setCacheDir($this->cacheDir())
            ->addCustomParameters('root_path', $this->projectRootPath)
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
