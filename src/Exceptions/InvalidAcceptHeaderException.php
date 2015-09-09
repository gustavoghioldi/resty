<?php
/**
 * InvalidAcceptHeaderException.php
 *
 * PHP version 5.5+
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
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * InvalidAcceptHeaderException
 *
 * Esta excepción se lanza cuando el header accept no es válido
 *
 * @category  Resty
 * @package   Resty\Exceptions
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class InvalidAcceptHeaderException extends BadRequestHttpException
{
    use RestyTraitException;
    const MSG = "Invalid Accept Header";
    const CODE = 100004;
    /**
     * Constructor
     *
     * @param string     $message  Mensaje
     * @param \Exception $previous Excepcion anterior
     * @param integer    $code     Código
     */
    public function __construct($message = "", \Exception $previous = null, $code = 0)
    {
        parent::__construct(static::MSG, $previous, static::CODE);
        $this->setDetails($message);
    }
}
