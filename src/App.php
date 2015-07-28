<?php
/**
 * Resty.php
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
namespace Zendo\Resty;

use Pimple\Container;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\TerminableInterface;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;

use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\Loader\YamlFileLoader;

use Symfony\Component\Config\FileLocator;

use Symfony\Component\EventDispatcher\EventDispatcher;


/**
 * Resty
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
class App  extends Container  implements HttpKernelInterface, TerminableInterface
{
    protected $services = [];
    protected $booted = false;
    public $di = null;
    /**
     * Constructor
     */
    public function __construct($rootPath)
    {
        parent::__construct();

        $app = $this;

        $di = function () use ($rootPath) {
            $configPaths = [
                realpath(__DIR__.'/../config'),
                $rootPath.'/config'
            ];
            error_log($rootPath."/cache/".PHP_EOL, 3, '/tmp/log');

            $builder = new \Zendo\Di\BuilderFromCache();
            $builder->addConfigurationFile($configPaths, ['parameters.yml', 'services.yml'])
                ->addCustomParameters("rootpath", $rootPath)
                ->setCacheDir(rtrim($rootPath, '/')."/cache/")
                ->setIsDebug(true);

            return $builder->get();

        };

        $this->di = $di();

        // logger
        //$app['logger'] = null;

        //routing config
        //$this['route.cache.enabled'] = true;
        //$this['route.cache.path'] = '';

        //$this['route.routes.path'] = [];
        //$this['route.routes.filename'] = 'routes.yml';

        //$this['route.debug'] = false;
        //$this['route.options'] = [];

        /*
        $this['router'] = function () use ($app) {
            $opts = $app['route.options'];
            if ($app['route.cache.enabled']) {
                $opts['cache_dir'] = $app['route.cache.path'];
            }
            $opts['debug'] = $app['route.debug'];
            $router = new Router(
                $app['yamlfileloader'],
                $app['route.routes.filename'],
                $opts,
                null
            );
            return $router;
        };

        $this['yamlfileloader'] = function() use ($app) {
            return new YamlFileLoader(
                new FileLocator($app['route.routes.path'])
            );
        };

        $this['dispatcher'] = function () use ($app) {
            $dispatcher = new EventDispatcher();
            $dispatcher->addSubscriber(
                new RouterListener(
                    $app['router']->getMatcher()
                )
            );
            return $dispatcher;
        };

        $this['resolver'] = function () use ($app) {
            return new ControllerResolver($app['logger']);
        };

        $this['httpkernel'] = function () use ($app) {
            return new HttpKernel(
                $app['dispatcher'],
                $this['resolver']
            );
        };

        foreach ($values as $key => $value) {
            $this[$key] = $value;
        }
        */

    }

    /**
     * Boots all services.
     *
     * This method is automatically called by handle(), but you can use it
     * to boot all service providers when not handling a request.
     */
    public function boot()
    {
        //if (!$this->booted) {
        //    foreach ($this->services as $service) {
        //        $service->boot($this);
        //    }
        //    $this->booted = true;
        //}
    }

    /**
     * Handles the request and delivers the response.
     *
     * @param Request|null $request Request to process
     */
    public function run(Request $request = null)
    {
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
     */
    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        if (!$this->booted) {
            $this->boot();
        }
        $response = $this['httpkernel']->handle($request, $type, $catch);
        return $response;
    }


    /**
     * Terminates a request/response cycle.
     *
     * Should be called after sending the response and before shutting down the kernel.
     *
     * @param Request  $request  A Request instance
     * @param Response $response A Response instance
     */
    public function terminate(Request $request, Response $response)
    {
        $this['httpkernel']->terminate($request, $response);
    }
}
