<?php
/**
 * FactoryTest
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

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * FactoryTest
 *
 * @category  Resty
 * @package   Resty\Tests
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class FactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * Testea el método create
     *
     * @return void
     */
    public function testCreateNoCache()
    {
        $stubApp = $this->getApplicationStub();
        $stubApp->method('getEnv')
            ->willReturn('dev');
        $factory = new \Resty\Container\Factory();
        $container = $factory->create($stubApp);
        $this->assertInstanceOf('\Symfony\Component\DependencyInjection\ContainerBuilder', $container);
    }
    /**
     * Testea el método create
     *
     * @return void
     */
    public function testCreateCache()
    {
        $stubApp = $this->getApplicationStub();
        $stubApp->method('getEnv')
            ->willReturn(\Resty\Environment::PROD);

        $factory = new \Resty\Container\Factory();
        $container = $factory->create($stubApp);
        $this->assertInstanceOf(\Resty\Container\Cache::CACHE_CLASS_NAME, $container);
    }

    /**
     * Genera un stub de la clase \Resty\Application
     *
     * @return \Resty\Application
     */
    protected function getApplicationStub()
    {
        $stubApp = $this->getMockBuilder('\Resty\Application')
            ->getMock();

        $stubApp->method('getConfigPath')
            ->willReturn([realpath(__DIR__."/../../Helpers")."/"]);
        $stubApp->method('getRootPath')
            ->willReturn(realpath(__DIR__."/../../Helpers")."/");
        $stubApp->method('getCacheDir')
            ->willReturn("/tmp/");
        return $stubApp;
    }

    /**
     * Metodo que se ejecuta antes de comenzar a ejecutar la clase
     *
     * @return void
     */
    public static function setUpBeforeClass()
    {
        //elimina el archivo cache para los tests
        $file = '/tmp/'.\Resty\Container\Cache::CACHE_CLASS_NAME.".php";
        @unlink($file);
    }
    /**
     * Metodo que se ejecuta al finalizar de correr todos los test de la clase
     *
     * @return void
     */
    public static function tearDownAfterClass()
    {
        //elimina el archivo cache para los tests
        $file = '/tmp/'.\Resty\Container\Cache::CACHE_CLASS_NAME.".php";
        @unlink($file);
    }
}
