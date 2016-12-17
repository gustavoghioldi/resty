<?php
/**
 * BaseCommand
 *
 * PHP version 7+
 *
 * Copyright (c) 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * @category  Resty
 * @package   Resty\Command
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
namespace Resty\Command;

// Slim
use Slim\Container;
// Symfony - console
use Symfony\Component\Console\Command\Command;

/**
 * BaseCommand
 *
 * @category  Resty
 * @package   Resty\Command
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class BaseCommand extends Command
{
    protected $container = null;

    /**
     * Setea instancia de Container
     * 
     * @param Container $c Instancia de Container
     *
     * @return self
     */
    public function setContainer(Container $c)
    {
        $this->container = $c;
        return $this;
    }
}
