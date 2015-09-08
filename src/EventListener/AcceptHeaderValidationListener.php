<?php
/**
 * AcceptHeaderValidationListener.php
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

// Resty
use Resty\Exceptions\InvalidAcceptHeaderException;
// Symfony - EventDispatcher
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
// Symfony - HttpKernel
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
// Symfony - DependencyInjection
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * AcceptHeaderValidationListener
 *
 * @category  Resty
 * @package   Resty\EventListener
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class AcceptHeaderValidationListener implements EventSubscriberInterface, ContainerAwareInterface
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
     * @param GetResponseEvent $event Una instancia de GetResponseEvent
     *
     * @return void
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $accept = $this->container->getParameter('response.format.accept');
        if (!in_array($request->headers->get('Accept'), $accept)) {
            throw new InvalidAcceptHeaderException(
                "Se recibio: ".$request->headers->get('Accept')." pero se espera alguno de estos valores: ".implode("|", $accept)
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
            KernelEvents::REQUEST => array('onKernelRequest', -10),
        );
    }
}
