<?php
/**
 * Logger.php
 *
 * PHP version 5.5+
 *
 * Copyright (c) 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed
 * with this source code.
 *
 * @category  Resty
 * @package   Resty\Logger
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
namespace Resty\Logger;

// Monolog
use Monolog\Logger as MonoLogger;

/**
 * Logger
 *
 * @category  Resty
 * @package   Resty\Logger
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class Logger extends MonoLogger
{
    /**
     * Configura un handler de streaming
     * 
     * @param array $data Configuración del handler
     *                    Los valores del array son
     *                        - handler: clase del handler. Ej \Monolog\Handler\StreamHandler
     *                        - file: Path del archivo donde se almacenaran los logs. Ej: /tmp/logs
     *                        - level: Nivel de error. Los valores posibles son:
     *                            DEBUG, INFO, NOTICE, WARNING, ERROR, CRITICAL, ALERT, EMERGENCY
     *                            
     * @return void
     */
    public function configureStreaming($data)
    {
        $handler = new $data['handler'](
            $data['file'], 
            constant('\Monolog\Logger::'.$data['level'])
        );
        $this->pushHandler($handler);
    }
}
