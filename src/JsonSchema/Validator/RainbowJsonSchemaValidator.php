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
 * @package   Resty\JsonSchema\Validator
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
namespace Resty\JsonSchema\Validator;

use Resty\JsonSchema\JsonSchemaValidatorInterface;
/**
 * RainbowJsonSchemaValidator
 * 
 * Copyright (c) 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed
 * with this source code.
 *
 * @category  Resty
 * @package   Resty\JsonSchema\Validator
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class RainbowJsonSchemaValidator implements JsonSchemaValidatorInterface
{
    protected $cache = null;
    /**
     * Valida el esquema
     *
     * @param string $jsonToValidate   Json a validar
     * @param string $pathToJsonSchema Path al archivo que contiene el esquema json
     * 
     * @return bool|array
     */
    public function validate($jsonToValidate, $pathToJsonSchema)
    {
        // validate
        $validator = new \JsonSchema\Validator();
        $validator->check($jsonToValidate, $this->getSchema($pathToJsonSchema));
        $return = $validator->isValid();

        if (true == $return) {
            return true;
        } else {
            return $validator->getErrors();
        }
    }
    /**
     * Carga y parsea el esquema para luego validar los datos
     * 
     * @param string $pathToJsonSchema Json a validar
     * 
     * @return Schema
     */
    protected function getSchema($pathToJsonSchema)
    {
        $retriever = new \JsonSchema\Uri\UriRetriever;
        return $retriever->retrieve($pathToJsonSchema);
    }
}
