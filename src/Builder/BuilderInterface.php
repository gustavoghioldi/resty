<?php
/**
 * BuilderInterface.php
 *
 * PHP version 5.5+
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

use Symfony\Component\DependencyInjection\Container;

/**
 * BuilderInterface
 *
 * Interfaz común para todos los factories
 *
 * @category  Resty
 * @package   Resty\Builder
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
interface BuilderInterface
{
    /**
     * Crea una instancia
     * 
     * @param Container $container Una instancia de Container
     * 
     * @return mixed
     * @static
     */
    static public function create(Container $container);
}
