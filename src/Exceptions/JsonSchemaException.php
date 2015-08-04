<?php
/**
 * JsonSchemaException.php
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
 * JsonSchemaException
 *
 * @category  Resty
 * @package   Resty\Exceptions
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class JsonSchemaException extends \Exception
{
    const MSG = "Invalid Json Schema";
    protected $customMessage = '';
    /**
     * Custom construct
     * 
     * @param string          $message   Mensaje
     * @param integer         $code      Código de error
     * @param \Exception|null $exception Excepción previa
     */
    public function __construct($message = '', $code = 0, \Exception $exception = null)
    {
        $this->setCustomMessage($message);
        parent::__construct(static::MSG, $code, $exception);
    }
    /**
     * Setea mensaje de error
     * 
     * @param string|array $message Mensajes de error
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
}
