<?php
/**
 * ContainerTest
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
 * ContainerTest
 *
 * @category  Resty
 * @package   Resty\Tests
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class ContainerTest extends PHPUnit_Framework_TestCase
{
    /**
     * Testea el metodo addFile
     *
     * @return void
     */
    public function testAddFile()
    {
        $expected = ['file1', "file2"];
        $container = new \Resty\Container\Container();
        $container->addFile($expected[0]);
        $container->addFile($expected[1]);
        $this->assertAttributeEquals($expected, 'files', $container);
    }
    /**
     * Testea el metodo addDirectories
     *
     * @return void
     */
    public function testAddDirectories()
    {
        $expected = ['/tmp'];
        $container = new \Resty\Container\Container();
        $container->addDirectories($expected);
        $this->assertAttributeEquals($expected, 'directories', $container);
    }
    /**
     * Testea el metodo addCustomParameters
     *
     * @return void
     */
    public function testAddCustomParameters()
    {
        $expected = [
            'key1' => 'value1',
            'key2' => 'value2'
        ];
        $container = new \Resty\Container\Container();
        foreach ($expected as $k => $v) {
            $container->addCustomParameters($k, $v);
        }
        $this->assertAttributeEquals($expected, 'customParameters', $container);
    }
    /**
     * Testea el metodo loadConfigurationFiles
     *
     * @return void
     */
    public function testLoadConfigurationFilesEmpty()
    {
        $container = new \Resty\Container\Container();
        $ref = new \ReflectionMethod('\Resty\Container\Container', 'loadConfigurationFiles');
        $ref->setAccessible(true);
        $value = $ref->invoke($container, new ContainerBuilder);
        $this->assertNull($value);
    }
    /**
     * Testea el metodo loadConfigurationFiles
     *
     * @return void
     */
    public function testLoadConfigurationFiles()
    {
        $container = new \Resty\Container\Container();
        $container->addDirectories([realpath(__DIR__."/../../Helpers/config")]);
        $container->addFile("config.dev.yml");
        $container->addFile("config.yml");
        $ref = new \ReflectionMethod('\Resty\Container\Container', 'loadConfigurationFiles');
        $ref->setAccessible(true);
        $containerBuilder = new ContainerBuilder;
        $ref->invoke($container, $containerBuilder);
        $this->assertEquals("Resty", $containerBuilder->getParameter("name"));
        $this->assertEquals("Hello World!", $containerBuilder->getParameter("hello"));
    }
    /**
     * Testea el metodo loadCustomParameters
     *
     * @return void
     */
    public function testLoadCustomParameters()
    {
        $container = new \Resty\Container\Container();
        $parameters = [
            'key1' => 'value1',
            'key2' => 'value2'
        ];
        foreach ($parameters as $k => $v) {
            $container->addCustomParameters($k, $v);
        }
        $containerBuilder = new ContainerBuilder;
        $container->loadCustomParameters($containerBuilder);

        foreach ($parameters as $k => $v) {
            $this->assertEquals($v, $containerBuilder->getParameter($k));
        }
    }

    /**
     * Testea el metodo configureContainer
     *
     * @return void
     */
    public function testConfigureContainer()
    {
        $stubApp = $this->getApplicationStub();
        $ref = new \ReflectionMethod('\Resty\Container\Container', 'configureContainer');
        $ref->setAccessible(true);
        $container = new \Resty\Container\Container();
        $ref->invoke($container, $stubApp);
    }
    /**
     * Teste el metodo create
     *
     * @return void
     */
    public function testCreate()
    {
        $stubApp = $this->getApplicationStub();
        $containerFactory = new \Resty\Container\Container();
        $container = $containerFactory->create($stubApp);

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
        $stubApp->method('getEnv')
            ->willReturn('dev');
        $stubApp->method('getConfigPath')
            ->willReturn([realpath(__DIR__."/../../Helpers")."/"]);
        $stubApp->method('getRootPath')
            ->willReturn(realpath(__DIR__."/../../Helpers")."/");
        return $stubApp;
    }
}
