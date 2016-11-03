<?php
/**
 * DefaultServicesProvider
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

use Resty\Handler\PhpError;
use Resty\Handler\Error;
use Resty\Handler\NotFound;
use Resty\Handler\NotAllowed;

/**
 * DefaultServicesProvider
 *
 * @category  Resty
 * @package   Resty
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class DefaultServicesProvider
{
    /**
     * Register Slim's default services.
     *
     * @param Container $container A DI container implementing ArrayAccess and container-interop.
     *
     * @return void
     */
    public function register($container)
    {

        $container['errorHandler'] = function ($container) {
            return new Error($container->get('settings')['displayErrorDetails']);
        };
        $container['phpErrorHandler'] = function ($container) {
            return new PhpError($container->get('settings')['displayErrorDetails']);
        };
        $container['notFoundHandler'] = function ($container) {
            return new NotFound($container->get('settings')['displayErrorDetails']);
        };
        $container['notAllowedHandler'] = function ($container) {
            return new NotAllowed($container->get('settings')['displayErrorDetails']);
        };
    }

}
