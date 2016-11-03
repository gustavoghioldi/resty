<?php
/**
 * NotFound
 *
 * PHP version 7+
 *
 * Copyright (c) 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * @category  Resty
 * @package   Resty\Handler
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
namespace Resty\Handler;

use Resty\ErrorMessage;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Body;

/**
 * NotFound
 *
 * @category  Resty
 * @package   Resty\Handler
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class NotAllowed
{
    protected $displayErrorDetails;

    /**
     * Constructor
     *
     * @param bool $displayErrorDetails Set to true to display full details
     */
    public function __construct($displayErrorDetails = false)
    {
        $this->displayErrorDetails = (bool) $displayErrorDetails;
    }

    /**
     * Invoca la respuesta
     * 
     * @param ServerRequestInterface $request  Instancia de ServerRequestInterface
     * @param ResponseInterface      $response Instancia de ResponseInterface
     * @param array                  $methods  Array de metodos http disponibles
     * 
     * @return mixed
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $methods = [])
    {
        $output = $this->render($request, $methods);

        $body = new Body(fopen('php://temp', 'r+'));
        $body->write($output);

        return $response
            ->withStatus(405)
            ->withHeader('Content-type', 'application/json')
            ->withBody($body);
    }

    /**
     * Renderiza el mensaje de error
     * 
     * @param ServerRequestInterface $request Instancia de Request
     * @param array                  $methods Array de metodos http disponibles
     * 
     * @return string
     */
    protected function render(ServerRequestInterface $request, array $methods) 
    {
        $message = new ErrorMessage();
        $message->append(
            'Method not allowed',
            'Request => '.$request->getMethod().":".$request->getUri()->__toString()
            .'. Method not allowed. Must be one of '.implode(", ", $methods),
            405
        );
        return json_encode($message, JSON_PRETTY_PRINT);
    }
}
