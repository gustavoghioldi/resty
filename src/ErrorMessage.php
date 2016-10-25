<?php
/**
 * ErrorMessage
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

/**
 * ErrorMessage
 *
 * @category  Resty
 * @package   Resty
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class ErrorMessage implements \JsonSerializable
{
    protected $errors = [];
    protected $meta = [];
    /**
     * Agrega valores a la metadata del mensaje
     * 
     * @param string $key   Clave
     * @param mixed  $value Valor
     *
     * @return self
     */
    public function addMeta(string $key, $value)
    {
        $this->meta[$key] = $value;
        return $this;
    }

    /**
     * Agrega un mensaje de error
     * 
     * @param string         $title   Título
     * @param string|array   $details Descripción. Default: ''
     * @param int|integer    $status  Http Status. Default: 500
     * @param integer|string $code    Código interno. Default: 0
     * @param array          $extra   Array con valores libres. Default: []
     * 
     * @return self
     */
    public function append(string $title, $details = '', int $status = 500, $code = 0, array $extra = []) 
    {
        $this->errors[] = array_merge(
            [
                'title' => $title,
                'details' => $details,
                'code' => $code,
                'status' => $status
            ],
            $extra
        );
        return $this;
    }

    /**
     * Devuelve el mensaje de error en formato de array
     * 
     * @return array
     */
    protected function render():array
    {
        return array_merge(
            $this->meta,
            ['errors' => $this->errors]
        );
    }

    /**
     * Serializa a Json el objeto
     * 
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->render();
    }
}
