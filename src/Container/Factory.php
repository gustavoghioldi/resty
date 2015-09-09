<?php
/**
 * Factory.php
 *
 * PHP version 5.5+
 *
 * Copyright (c) 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed
 * with this source code.
 *
 * @category  Resty
 * @package   Resty\Container
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
namespace Resty\Container;

use \Resty\Application;
use \Resty\Environment;

/**
 * Factory.php
 *
 * Factory para crear un container con toda la configuración del proyecto
 *
 * @category  Resty
 * @package   Resty\Container
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class Factory
{
    protected $dependencies = [
        "cache" => '\Resty\Container\Cache',
        "container" => '\Resty\Container\Container'
    ];

    /**
     * Metodo del factory
     *
     * @param \Resty\Application $app Una instancia de Application
     *
     * @return ContainerBuilder
     */
    public function create(Application $app)
    {
        //Si es un modo distinto a producción => por cada request se regenera el container analizando la metada
        if (Environment::PROD === $app->getEnv()) {
            $containerClass = $this->dependencies['cache'];
        } else {
            $containerClass = $this->dependencies['container'];
        }
        $containerFactory = new $containerClass();
        $container = $containerFactory->create($app);
        return $container;
    }
}
