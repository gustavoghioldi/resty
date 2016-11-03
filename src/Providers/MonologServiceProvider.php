<?php
/**
 * MonologServiceProvider
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
use Monolog\Logger;
/**
 * MonologServiceProvider
 *
 * @category  Resty
 * @package   Resty\Providers
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class MonologServiceProvider implements ServiceProviderInterface
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

        $loggerConfig = $container->get('monolog');
        $loggers = new LoggerCollection;

        foreach ($loggerConfig as $channel => $channelConfig) {

            $logger = new Logger($channel);

            foreach ($channelConfig as $handlerConfig) {
                extract($handlerConfig);
                $logger->pushHandler(
                    new $handler(
                        $config['output'],
                        $level
                    )
                );
            }

            $loggers->set($channel, $logger);
        }

        $container['logger'] = $loggers;


    }
}
