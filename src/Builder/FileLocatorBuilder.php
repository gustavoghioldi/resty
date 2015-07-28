<?php
/**
 * FileLocatorBuilder.php
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
namespace Zendo\Resty\Builder;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Container;

/**
 * FileLocatorBuilder
 *
 * Crea una instancia de FileLocator
 *
 * @category  Resty
 * @package   Resty\Builder
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class FileLocatorBuilder implements BuilderInterface
{
    /**
     * Crea una instancia de FileLocator
     * 
     * @param Container $container Una instancia de Container
     * 
     * @return FileLocator
     * @static
     */
    static public function create(Container $container)
    {
        return new FileLocator($container->getParameter('root_path').$container->getParameter('route.routes.path'));
    }
}
