<?php
/**
 * ExceptionListener.php
 *
 * PHP version 5.6+
 *
 * Copyright (c) 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed
 * with this source code.
 *
 * @category  Resty
 * @package   Resty\EventListener
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
namespace Resty\EventListener;

//EventDispatcher
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
//HttpKernel
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
//HttpFoundation
use Symfony\Component\HttpFoundation\Response;

/**
 * ExceptionListener
 *
 * @category  Resty
 * @package   Resty\EventListener
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class ExceptionListener implements EventSubscriberInterface
{
    /**
     * Handler para los errores dentro de workflow de httpkernel
     *
     * @param GetResponseForExceptionEvent $event Una instancia de GetResponseForExceptionEvent
     *
     * @return void
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        $response = new Response();
        $msg = [];

        if ($exception instanceof Resty\Exceptions\RestyBaseException) {
            //Si es una excepción del framework o de alguna que extienda el framework
            //entonces uso el mensaje y código custom
            $msg["exception_msg"] = $exception->getCustomMessage();
            $msg["exception_code"] = $exception->getCustomCode();
            $msg["http_code"] = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        } elseif ($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
            //quita info sensible que no debe ser devuelta
            $msg['exception_msg'] = substr($exception->getMessage(), 0, strpos($exception->getMessage(), ":"));
            $msg['exception_code'] = $exception->getCode();
            $msg["http_code"] = $exception->getStatusCode();
            $response->setStatusCode($exception->getStatusCode());
        } else {
            //para lo demas
            $msg['exception_msg'] = $exception->getMessage();
            $msg['exception_code'] = $exception->getCode();
            if ($exception instanceof HttpExceptionInterface) {
                //si es una excepcion http setea el codigo http correspondiente
                $msg["http_code"] = $exception->getStatusCode();
                $response->setStatusCode($exception->getStatusCode());
                $response->headers->replace($exception->getHeaders());
            } else {
                //cualquier otra cosa => 500
                $msg["http_code"] = Response::HTTP_INTERNAL_SERVER_ERROR;
                $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        /*
        //@TODO tengo que formatear la respta al tipo solicitado
        $msg = [
            "exception" => $exception->getMessage(),
            "exception_msg" => $exception->getCode()
        ];
		//@TODO quitar este if
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
            $msg['msg'] = substr($msg['msg'], 0, strpos($msg['msg'], ":"));
            $msg["http_code"] = $exception->getStatusCode();
            $response->setStatusCode($exception->getStatusCode());
        } else if ($exception instanceof HttpExceptionInterface) {
            $msg["http_code"] = $exception->getStatusCode();
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else if ($exception instanceof \Resty\Exceptions\JsonSchemaException) {
            $msg["details"] = $exception->getCustomMessage();
            $msg["http_code"] = Response::HTTP_INTERNAL_SERVER_ERROR;
        } else {
            $msg["code"] = $exception->getCode();
            $msg["http_code"] = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        */
        $response->setContent(json_encode($msg));
        $response->headers->set('Content-Type', 'application/json');

        $event->setResponse($response);
    }
    /**
     * Suscribe el evento
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::EXCEPTION => array('onKernelException', -10),
        );
    }
}
