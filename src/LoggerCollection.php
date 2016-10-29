<?php
/**
 * LoggerCollection
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

use Slim\Collection;

/**
 * LoggerCollection
 *
 * @category  Resty
 * @package   Resty
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class LoggerCollection extends Collection
{
    protected $default = 'default';

    /**
     * Setea la key del logger por defecto
     * 
     * @param string $default Nombre del logger
     *
     * @return LoggerCollection
     */
    public function setDefaultLogger(string $default): LoggerCollection
    {
        $this->default = $default;
        return $this;
    }
    /**
     * Invoca al logger por defecto
     * 
     * @param string $method Nombre del metodo
     * @param array  $args   Argumentos dle metodo
     * 
     * @return bool
     */
    public function __call($method, $args) 
    {
        $logger = $this->get($this->default);
        if ($logger != null) {
            return $logger->$method($args[0]??'', $args[1]??[]);
        }
        return true;
    }
}
