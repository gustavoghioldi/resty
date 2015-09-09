<?php
/**
 * RestyTraitException.php
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
 * RestyTraitException
 *
 * @category  Resty
 * @package   Resty\Exceptions
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
trait RestyTraitException
{
    /**
     * Detalle de la excepcion
     * @var string
     */
    protected $details = '';
    /**
     * Setea los detalles
     *
     * @param string|array $details Setea mensaje custom
     *
     * @return void
     */
    public function setDetails($details)
    {
        $this->details = $details;
    }
    /**
     * Devuelve los detalles
     *
     * @return string|array
     */
    public function getDetails()
    {
        return $this->details;
    }
}
