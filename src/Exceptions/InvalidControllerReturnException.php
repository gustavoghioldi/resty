<?php
/**
 * InvalidControllerReturnException.php
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
 * InvalidControllerReturnException
 *
 * Esta excepción se utiliza cuando el controlador devolvio un valor inválido o no devolvio ningún valor
 *
 * @category  Resty
 * @package   Resty\Exceptions
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class InvalidControllerReturnException extends \Exception
{
    protected $customMessage = 'El controlador no devolvio ningún valor o es inválido';

    /**
     * Custom construct
     * 
     * @param string          $message   Mensaje
     * @param integer         $code      Código de error
     * @param \Exception|null $exception Excepción previa
     */
    public function __construct($message = '', $code = 0, \Exception $exception = null)
    {
        $message = $this->customMessage;
        parent::__construct($message, $code, $exception);
    }
}
