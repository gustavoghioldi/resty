<?php
/**
 * RainbowJsonSchemaValidator.php
 *
 * PHP version 5.6+
 *
 * Copyright (c) 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed
 * with this source code.
 *
 * @category  Resty
 * @package   Resty\JsonSchema
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
namespace Resty\JsonSchema;

use Resty\JsonSchema\JsonSchemaValidatorInterface;
use Resty\Exceptions\JsonSchemaException;
/**
 * RainbowJsonSchemaValidator
 * 
 * Copyright (c) 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed
 * with this source code.
 *
 * @category  Resty
 * @package   Resty\JsonSchema
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class JsonSchemaValidator implements JsonSchemaValidatorInterface
{
    /**
     * Container
     * @var Container
     */
    protected $validatorClass = null;
    /**
     * Sets the Container.
     *
     * @param string $validatorClass Clase del 
     *
     * @return void
     * @api
     */
    public function setValidatorClass($validatorClass)
    {
        $this->validatorClass = $validatorClass;
    }
    /**
     * Valida el esquema
     *
     * @param string $jsonToValidate   Json a validar
     * @param string $pathToJsonSchema Path al archivo que contiene el esquema json
     * 
     * @return bool
     */
    public function validate($jsonToValidate, $pathToJsonSchema)
    {
        $class = $this->validatorClass;
        $validator = new $class;
        $response = $validator->validate($jsonToValidate, 'file://'.$pathToJsonSchema);

        if (true === $response) {
            //si valida el esquema entonces devuelve ok
            return true;
        }
        //si el esquema no valida => genera una excepcion
        throw new JsonSchemaException($response);
    }
}
