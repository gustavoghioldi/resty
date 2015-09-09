<?php
/**
 * ApplicationTest
 *
 * PHP version 5.5+
 *
 * Copyright (c) 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed
 * with this source code.
 *
 * @category  Resty
 * @package   Resty\Tests
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
/**
 * ApplicationTest
 *
 * @category  Resty
 * @package   Resty\Tests
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class ApplicationTest extends PHPUnit_Framework_TestCase
{
    /**
     * Testea el metodo setEnv pasando un valor inválido
     *
     * @expectedException \Resty\Exceptions\InvalidEnvironmentException
     * 
     * @return void
     */
    public function testSetEnvException()
    {
        $app = new \Resty\Application();
        $app->setEnv("dummy");
    }
    /**
     * Testea el metodo setEnv
     *
     * @return void
     */
    public function testSetEnv()
    {
        $expected = \Resty\Environment::PROD;
        $app = new \Resty\Application();
        $app->setEnv($expected);
        $this->assertEquals($expected, $app->getEnv());
    }
}
