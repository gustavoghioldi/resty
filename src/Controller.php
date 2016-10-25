<?php
/**
 * Controller
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

use Resty\ErrorMessage;
use Slim\Container;
use \Psr\Http\Message\ResponseInterface as Response;
/**
 * Controller
 *
 * @category  Resty
 * @package   Resty
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
abstract class Controller
{
    protected $container = null;

    /**
     * Constructor
     *
     * @param Container $c Instancia de Container
     */
    public function __construct(Container $c)
    {
        $this->container = $c;
    }

    /**
     * Metodo para devolver un error
     * 
     * @param string|array $messages       Mensajes de error
     * @param int          $httpStatusCode Http Code. Default: 500
     * @param string|array $details        Detalles. Default: ''
     * 
     * @return Response
     */
    protected function abort($messages, $httpStatusCode = 500, $details = ''):Response
    {
        if (!($messages instanceof ErrorMessage)) {
            $messages = (new ErrorMessage())->append($messages, $details, $httpStatusCode);
        }
        $response = $this->container['response'];
        return $response->withJson(
            $messages, 
            $httpStatusCode
        );
    }
    /**
     * Mensaje de respuesta
     * 
     * @param string|array $result         Mensajes de error
     * @param int          $httpStatusCode Http Code
     * 
     * @return Response
     */
    protected function ok($result, $httpStatusCode = 200):Response
    {
        $response = $this->container['response'];
        return $response->withJson($result, $httpStatusCode);
    }

    /**
     * Metodo para devolver un 404
     * 
     * @param string|array $messages Mensajes de error
     * @param string|array $details  Detalles. Default: ''
     * 
     * @return Response
     */
    protected function abort404($messages, $details = ''):Response
    {
        return $this->abort($messages, 404, $details);
    }
}
