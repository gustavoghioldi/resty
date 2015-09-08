<?php
/**
 * CacheTest
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
 * CacheTest
 *
 * @category  Resty
 * @package   Resty\Tests
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class CacheTest extends PHPUnit_Framework_TestCase
{
    /**
     * Testea el metodo setCacheDir
     *
     * @return [type] [description]
     */
    public function testSetCacheDir()
    {
        $expected = '/tmp';
        $o = new \Resty\Container\Cache();
        $o->setCacheDir($expected);
        $this->assertAttributeEquals($expected, 'cacheDir', $o);
    }
    /**
     * Testea el metodo renderCacheFileFullPath
     *
     * @return void
     */
    public function testRenderCacheFileFullPath()
    {
        $expected = '/tmp/'.\Resty\Container\Cache::CACHE_CLASS_NAME.'.php';
        $o = new \Resty\Container\Cache();
        $o->setCacheDir('/tmp/');

        $ref = new \ReflectionMethod('\Resty\Container\Cache', 'renderCacheFileFullPath');
        $ref->setAccessible(true);

        $this->assertEquals(
            $expected,
            $ref->invoke($o)
        );
    }
    /**
     * Testea el metodo setIsDebug
     *
     * @return void
     */
    public function testSetIsDebug()
    {
        $o = new \Resty\Container\Cache();
        $o->setIsDebug(true);
        $this->assertAttributeEquals(true, 'isDebug', $o);
    }


    public function testCreate()
    {
        $stubApp = $this->getMockBuilder('\Resty\Application')
            ->getMock();
        $stubApp->method('getEnv')
            ->willReturn('dev');
        $stubApp->method('getConfigPath')
            ->willReturn([realpath(__DIR__."/../../Helpers")."/"]);
        $stubApp->method('getRootPath')
            ->willReturn(realpath(__DIR__."/../../Helpers")."/");
        $stubApp->method('getCacheDir')
            ->willReturn("/tmp/");

        $o = new \Resty\Container\Cache();
        $container = $o->create($stubApp);
        $this->assertEquals(
            "Resty",
            $container->getParameter("name")
        );

        $file = '/tmp/'.\Resty\Container\Cache::CACHE_CLASS_NAME.".php";
        $this->assertTrue(file_exists($file));
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
