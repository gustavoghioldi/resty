<?php
/**
 * AutomaticSerializerListener.php
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

// Resty - Exceptions
use Resty\Exceptions\InvalidControllerReturnException;

// Symfony - EventDispatcher
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
// Symfony - HttpKernel
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
// Symfony - HttpFoundation
use Symfony\Component\HttpFoundation\Response;
// Symfony - DependencyInjection
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * AutomaticSerializerListener
 *
 * @category  Resty
 * @package   Resty\EventListener
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class AutomaticSerializerListener implements EventSubscriberInterface, ContainerAwareInterface
{
    /**
     * Container
     * @var Container
     */
    protected $container = null;
    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @return void
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Handler para la respuesta del Controller que no devuelve un objeto Response
     *
     * @param GetResponseForControllerResultEvent $event Una instancia de GetResponseForControllerResultEvent
     *
     * @return void
     */
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        //obtiene la respuesta
        $response = $event->getControllerResult();

        //valida que el usuario haya devuelto algun valor en el método del controller
        if (is_null($response)) {
            throw new InvalidControllerReturnException();
        }

        //si es del tipo Response => no se hace nada
        if ($response instanceof Response) {
            return;
        }

        //obtiene el negociador del formato de respuesta
        $negotiator = $this->container->get('negotiatior_format');
        //obtiene el mejor formato
        $best = $negotiator->getBest(
            $event->getRequest()->headers->get('Accept'),
            $this->container->getParameter('negotiatior.format_accept')
        );

        if ($best === null) {
            //Si devuelve nulo es porque la petición pidio un formato de respesta que no es válido
            $event->setResponse(
                new Response(
                    json_encode(["Invalid response type"]),
                    Response::HTTP_NOT_IMPLEMENTED,
                    array('content-type' => 'application/json')
                )
            );
        } else {
            //@TODO: tengo que formatear el resultado al tipo que fue solicitado en el request
            $event->setResponse(
                new Response(
                    json_encode($response),
                    Response::HTTP_OK,
                    array('content-type' => 'application/json')
                )
            );
        }
    }
    /**
     * Suscribe el evento
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::VIEW => array('onKernelView', -10),
        );
    }
}
