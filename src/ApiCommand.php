<?php
/**
 * App
 *
 * PHP version 7+
 *
 * Copyright (c) 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * @category  Resty
 * @package   Resty
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
namespace Resty;

use Slim\Container;
use Symfony\Component\Console\Application;
use Interop\Container\ContainerInterface;

/**
 * Api
 *
 * Clase base para crear una Api
 *
 * @category  Resty
 * @package   Resty
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class ApiCommand
{
    protected $container = null;
    /**
     * Constructor
     *
     * @param array|ContainerInterface $container Instancia de Container o array de configuración. Default: []
     */
    public function __construct($container = [])
    {
        if (is_array($container)) {
            $container = new Container($container);
        }
        if (!$container instanceof ContainerInterface) {
            throw new \InvalidArgumentException('Expected a ContainerInterface');
        }
        $this->container = $container;


        $o = new \Resty\Slim\ServiceProviderMiddleware($this->container);
        $o->setProviders();
    }
    /**
     * Run
     * 
     * @return void
     */
    public function run()
    {
        $cmd = new Application();
        $this->setCommands($cmd);
        return $cmd->run();
    }
    /**
     * Setea los comandos
     * 
     * @param Application $cmd Instancia de Application
     *
     * @return void
     */
    protected function setCommands(Application $cmd)
    {
        $commandBase = array_merge(
            [
                '\Resty\Command\ServerCommand'
            ], 
            $this->container->get("settings")['commands']??[]
        );

        foreach ($commandBase as $command) {
            $cmd->add(
                (new $command)->setContainer($this->container)
            );
        }
    }
}
