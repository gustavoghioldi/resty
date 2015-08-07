<?php
/**
 * RestyBaseException.php
 *
 * PHP version 5.6+
 *
 * Copyright (c) 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed
 * with this source code.
 *
 * @category  Resty
 * @package   Resty\Exceptions
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
namespace Resty\Exceptions;

/**
 * RestyBaseException
 *
 * @category  Resty
 * @package   Resty\Exceptions
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class RestyBaseException extends \Exception
{
    /**
     * Mensaje custom
     * @var string
     */
    protected $customMessage = '';
    /**
     * Código custom
     * @var integer
     */
    protected $customCode = 0;
    /**
     * Setea mensaje de error
     *
     * @param string|array $message Setea mensaje custom
     *
     * @return void
     */
    public function setCustomMessage($message)
    {
        $this->customMessage = $message;
    }
    /**
     * Devuelve el error custom
     *
     * @return string|array
     */
    public function getCustomMessage()
    {
        return $this->customMessage;
    }

    /**
     * Setea código de error custom
     *
     * @param string|array $customCode Codigo de error
     *
     * @return void
     */
    public function setCustomCode($customCode)
    {
        $this->customCode = $customCode;
    }
    /**
     * Devuelve el código de error custom
     *
     * @return string|array
     */
    public function getCustomCode()
    {
        return $this->customCode;
    }
}
