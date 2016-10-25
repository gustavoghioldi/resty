<?php
/**
 * CommandController
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

use Resty\Controller;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\RequestInterface as Request;

/**
 * CommandController
 *
 * @category  Resty
 * @package   Resty
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
abstract class CommandController extends Controller
{
    /**
     * Invoca al comando
     * 
     * @param Request  $req    Instancia de Request
     * @param Response $res    Instancia de Response
     * @param array    $params Parametros de la uri
     * 
     * @return Response
     */
    abstract public function __invoke(Request $req, Response $res, array $params = []):Response;
}
