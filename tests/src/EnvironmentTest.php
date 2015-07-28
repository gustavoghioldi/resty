<?php
/**
 * EnvironmentTest
 *
 * PHP version 5.6+
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
 * EnvironmentTest
 *
 * @category  Resty
 * @package   Resty\Tests
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class EnvironmentTest extends PHPUnit_Framework_TestCase
{
    /**
     * Testea el attr prod
     * 
     * @return void
     */
    public function testAttrsProd()
    {
        $this->assertEquals("prod", \Zendo\Resty\Environment::PROD);
    }
    /**
     * Testea el attr test
     * 
     * @return void
     */
    public function testAttrsTest()
    {
        $this->assertEquals("test", \Zendo\Resty\Environment::TEST);
    }   
    /**
     * Testea el attr dev
     * 
     * @return void
     */
    public function testAttrsDev()
    {
        $this->assertEquals("dev", \Zendo\Resty\Environment::DEV);
    }
    /**
     * Testea el metodo isProd
     *
     * @depends testAttrsProd
     * 
     * @return void
     */
    public function testIsProd()
    {
        $this->assertTrue(\Zendo\Resty\Environment::isProd('prod'));
    }
    /**
     * Testea el metodo isTest
     *
     * @depends testAttrsTest
     * 
     * @return void
     */
    public function testIsTest()
    {
        $this->assertTrue(\Zendo\Resty\Environment::isTest('test'));
    }
    /**
     * Testea el metodo isDev
     *
     * @depends testAttrsDev
     * 
     * @return void
     */
    public function testIsDev()
    {
        $this->assertTrue(\Zendo\Resty\Environment::isDev('dev'));
    }

    /**
     * Testea el metodo validate
     *
     * @depends testAttrsDev
     * @depends testAttrsTest
     * @depends testAttrsProd
     * 
     * @return void
     */
    public function testValidate()
    {
        $this->assertTrue(\Zendo\Resty\Environment::validate('dev'));
    }
}
