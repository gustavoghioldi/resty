<?php
/**
 * ControllerResolver.php
 *
 * PHP version 5.6+
 *
 * Copyright (c) 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed
 * with this source code.
 *
 * @category  Resty
 * @package   Resty\Controller
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
namespace Zendo\Resty\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolver as BaseControllerResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * ControllerResolver
 *
 * Resuelve la instanciación del controlador
 *
 * @category  Resty
 * @package   Resty\Controller
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class ControllerResolver extends BaseControllerResolver implements ContainerAwareInterface
{
    /**
     * Container
     * @var Container
     */
    protected $container = null;
    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @return void
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    protected function doGetArguments(Request $request, $controller, array $parameters)
    {
        /*
        foreach ($parameters as $param) {
            if ($param->getClass() && $param->getClass()->isInstance($this->app)) {
                $request->attributes->set($param->getName(), $this->app);

                break;
            }
        }
        */
        return parent::doGetArguments($request, $controller, $parameters);
    }

    /**
     * Crea y retorna una instancia del Controllador solicitado. Le setea ademas la instancia del Contenedor
     * 
     * @param string $class A class name
     *
     * @return object
     */
    protected function instantiateController($class)
    {
        return parent::instantiateController($class)->setContainer($this->container);
    }
}
