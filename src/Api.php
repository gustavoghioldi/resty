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

use Resty\DefaultServicesProvider;
use Slim\App;
use Symfony\Component\Console\Application;

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
class Api extends App
{
    protected $commands = [];
    /**
     * Constructor
     *
     * @param array|ContainerInterface $container Instancia de Container o array de configuración. Default: []
     */
    public function __construct($container = [])
    {
        parent::__construct($container);
        $this->registerDafaultServicesProvider();
    }
    /**
     * Registra los providers de Resty
     * 
     * @return void
     */
    protected function registerDafaultServicesProvider()
    {
        $dsp = new DefaultServicesProvider();
        $dsp->register($this->getContainer());
    }
    /**
     * Ejecuta comando
     * 
     * @return void
     */
    public function runCommand()
    {
        $command = new Application();
        $this->setCommandList($command);
        $command->run();
    }
    /**
     * Setea la lista de comandos a la aplicación
     *
     * @param Aplication $cmd Instancia de la aplicacion comando
     *
     * @return void
     */
    protected function setCommandList(Application $cmd)
    {
        $commandBase = array_merge(
            [
                '\Resty\Command\ServerCommand'
            ],
            $this->commands
        );

        foreach ($commandBase as $command) {
            $cmd->add(new $command);
        }
    }
}
