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

use Resty\Exceptions\RestyTraitException;

// Symfony - HttpKernel
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

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
class JsonSchemaException extends BadRequestHttpException
{
    use RestyTraitException;
    const MSG = "Invalid Json Schema";
    const CODE = 100000;
    /**
     * Constructor
     *
     * @method __construct
     *
     * @param  string     $message  Mensaje
     * @param  \Exception $previous Excepcion anterior
     * @param  integer    $code     Código
     */
    public function __construct($message = "", \Exception $previous = null, $code = 0)
    {
        parent::__construct(static::MSG, $previous, static::CODE);
        $this->setDetails($message);
    }
}
