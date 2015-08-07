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

use Resty\Exceptions\RestyBaseException;

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
class JsonSchemaException extends RestyBaseException
{
    protected $customMessage = "Invalid Json Schema";
    protected $customCode = 100000;
    /**
     * Constructor
     *
     * @method __construct
     *
     * @param  string     $message  Mensaje
     * @param  integer    $code     Código
     * @param  \Exception $previous Excepcion anterior
     */
    public function __construct($message = "", $code = 0, \Exception $previous = null)
    {
        parent::__construct($this->getCustomMessage(), $code, $previous);
        $this->setCustomMessage($message);
    }
}
