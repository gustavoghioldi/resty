<?php
/**
 * LoggyServiceProvider
 *
 * PHP version 7+
 *
 * Copyright (c) 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * @category  Resty
 * @package   Resty\Providers
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
namespace Resty\Providers;

use Resty\Api;
use Resty\LoggerCollection;
use Resty\Interfaces\ServiceProviderInterface;
// Loggy
use Mostofreddy\Loggy\Logger;
/**
 * LoggyServiceProvider
 *
 * @category  Resty
 * @package   Resty\Providers
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class LoggyServiceProvider implements ServiceProviderInterface
{
    /**
     * Registra el servicio
     *
     * @param Api $app Instancia de la aplicacion
     *
     * @return void
     */
    public static function register(Api $app)
    {
        $container = $app->getContainer();

        $loggerConfig = $container->get('loggy');
        $loggers = new LoggerCollection;

        foreach ($loggerConfig as $channel => $channelConfig) {
            $handlers = [];
            foreach ($channelConfig as $handlerConfig) {
                extract($handlerConfig);
                $handlers[] = (new $handler($level))->config($config);
            }

            $loggers->set($channel, new Logger($channel, $handlers));
        }

        $container['logger'] = $loggers;
    }
}
