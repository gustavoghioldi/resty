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

use Resty\Exceptions\RestyTraitException;
// Symfony - HttpKernel
use Symfony\Component\HttpKernel\Exception\HttpException;

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
class InvalidControllerReturnException extends HttpException
{
    use RestyTraitException;
    const MSG = 'El controlador no devolvio ningún valor o es inválido';
    const CODE = 100002;

    /**
     * Constructor.
     *
     * @param string     $message  The internal exception message
     * @param \Exception $previous The previous exception
     * @param int        $code     The internal exception code
     */
    public function __construct($message = null, \Exception $previous = null, $code = 0)
    {
        parent::__construct(500, static::MSG, $previous, array(), static::CODE);
        $this->setDetails($message);
    }
}
