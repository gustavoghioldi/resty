<?php
/**
 * ControllerBase.php
 *
 * PHP version 5.6+
 *
 * Copyright (c) 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed
 * with this source code.
 *
 * @category  Resty
 * @package   Resty\Controller
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
namespace Resty\Controller;

//DependencyInjection
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * ControllerBase
 *
 * Clase base para todos los controllers
 *
 * @category  Resty
 * @package   Resty\Controller
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class ControllerBase implements ContainerAwareInterface
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
     * @return self
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        return $this;
    }
}
