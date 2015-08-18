<?php
/**
 * Environment.php
 *
 * PHP version 5.5+
 *
 * Copyright (c) 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed
 * with this source code.
 *
 * @category  Resty
 * @package   Resty
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
namespace Resty;

/**
 * Environment
 *
 * @category  Resty
 * @package   Resty
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class Environment
{
    /**
     * Ambientes
     * @var string
     */
    const PROD = 'prod';
    const TEST = 'test';
    const DEV = 'dev';
    /**
     * Valida si se encuentra en un ambiente
     *
     * @param string $current ambiente que se quiere validar
     * @param string $is      ambiente contra quien se compara
     *
     * @return bool
     */
    static public function is($current, $is)
    {
        return $current === $is;
    }
    /**
     * Verifica si el ambiente es producción
     * 
     * @param string $current ambiente que se quiere validar
     * 
     * @return boolean
     */
    static public function isProd($current) 
    {
        return static::is($current, static::PROD);
    }
    /**
     * Verifica si el ambiente es desarrollo
     * 
     * @param string $current ambiente que se quiere validar
     * 
     * @return boolean
     */
    static public function isDev($current) 
    {
        return static::is($current, static::DEV);
    }
    /**
     * Verifica si el ambiente es testing
     * 
     * @param string $current ambiente que se quiere validar
     * 
     * @return boolean
     */
    static public function isTest($current) 
    {
        return static::is($current, static::TEST);
    }
    /**
     * Valida que el ambiente es valido
     * 
     * @param string $env ambiente a validar
     * 
     * @return bool
     */
    static public function validate($env)
    {
        return ($env === static::PROD || $env === static::DEV || $env === static::TEST);
    }
}
