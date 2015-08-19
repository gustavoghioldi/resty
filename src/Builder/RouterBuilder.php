<?php
/**
 * RouterBuilder.php
 *
 * PHP version 5.6+
 *
 * Copyright (c) 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed
 * with this source code.
 *
 * @category  Resty
 * @package   Resty\Builder
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
namespace Resty\Builder;

// Resty
use Resty\Environment;

// Symfony - Routing
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RequestContext;
// Symfony - DependencyInjection
use Symfony\Component\DependencyInjection\Container;
// Symfony - HttpFoundation
use Symfony\Component\HttpFoundation\Request;

/**
 * RouterBuilder
 *
 * Crea una instancia de Router
 *
 * @category  Resty
 * @package   Resty\Builder
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class RouterBuilder implements BuilderInterface
{
    /**
     * Crea una instancia de Router
     * 
     * @param Container $container Una instancia de Container
     * 
     * @return Router
     * @static
     */
    static public function create(Container $container)
    {
        $opts = [];
        //if (false === $container->getParameter("debug")) {
        if (Environment::isProd($container->getParameter("env"))) {
            $opts['cache_dir'] = $container->getParameter('root_path').$container->getParameter('route.cache.path');
        }
        $context = new RequestContext();
        $context->fromRequest(Request::createFromGlobals());
        return new Router(
            $container->get('router_yaml_file_loader'),
            $container->getParameter('route.routes.filename'),
            $opts,
            $context
        );
    }
}
