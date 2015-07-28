<?php
/**
 * RouterMatcherBuilder.php
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

use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\DependencyInjection\Container;

/**
 * RouterMatcherBuilder
 *
 * @category  Resty
 * @package   Resty\Builder
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class RouterMatcherBuilder implements BuilderInterface
{
    /**
     * Crea una instancia de Symfony\Component\Routing\Matcher\UrlMatcherInterface
     * 
     * @param Container $container Una instancia de Container
     * 
     * @return Symfony\Component\Routing\Matcher\UrlMatcherInterface
     * @static
     */
    static public function create(Container $container)
    {
        return $container->get('router')->getMatcher();
    }
}
