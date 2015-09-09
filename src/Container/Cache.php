<?php
/**
 * Cache.php
 *
 * PHP version 5.5+
 *
 * Copyright (c) 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed
 * with this source code.
 *
 * @category  Resty
 * @package   Resty\Container
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
namespace Resty\Container;

use Resty\Application;
use Resty\Container\Factory;
// Symfony - DependencyInjection
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
// Symfony - Config
use Symfony\Component\Config\ConfigCache;

/**
 * Cache.php
 *
 * Factory para crear un container con toda la configuración del proyecto
 *
 * @category  Resty
 * @package   Resty\Container
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2015 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class Cache extends Container
{
    const CACHE_CLASS_NAME = 'RestyDiContainer';
    protected $cacheDir = '/tmp';
    protected $isDebug = false;
    /**
     * Crea una instancia del Container
     *
     * @param Application $app Una instancia de Application
     *
     * @return ContainerBuilder
     */
    public function create(Application $app)
    {
        $this->setCacheDir($app->getCacheDir());
        $file = $this->renderCacheFileFullPath();
        if (false === file_exists($file)) {
            $container = parent::create($app);
            $containerConfigCache = new ConfigCache($file, $this->isDebug);
            if (!$containerConfigCache->isFresh()) {
                //$container->compile();
                $this->createCache($container, $containerConfigCache);
            }
        }
        include_once $file;
        $className = static::CACHE_CLASS_NAME;
        return new $className();
    }
    /**
     * Setea el directorio donde se almacenara el cache del container
     *
     * @param string $cacheDir cache dir
     *
     * @return self
     */
    public function setCacheDir($cacheDir)
    {
        $this->cacheDir = $cacheDir;
        return $this;
    }
    /**
     * Devuelve el path del cache del Container
     *
     * @return string
     */
    protected function renderCacheFileFullPath()
    {
        return $this->cacheDir.static::CACHE_CLASS_NAME.".php";
    }
    /**
     * Set debug mode
     *
     * @param bool $isDebug enable/disable debug mode.
     *
     * @return self
     */
    public function setIsDebug($isDebug)
    {
        $this->isDebug = $isDebug;
        return $this;
    }
    /**
     * Genera y guarda el cache
     *
     * @param ContainerBuilder $containerBuilder     [description]
     * @param ConfigCache      $containerConfigCache [description]
     *
     * @return void
     */
    protected function createCache(ContainerBuilder $containerBuilder, ConfigCache $containerConfigCache)
    {
        $dumper = new PhpDumper($containerBuilder);
        $containerConfigCache->write(
            $dumper->dump(array('class' => static::CACHE_CLASS_NAME)),
            $containerBuilder->getResources()
        );
    }
}
