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
// Symfony - DependencyInjection
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
// Symfony - Finder
use Symfony\Component\Finder\Finder;
// Symfony - Config
use Symfony\Component\Config\FileLocator;

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
class Container
{
    const CONFIG_FILE_NAME = 'config.yml';
    const CONFIG_FILE_NAME_ENV = 'config.{env}.yml';
    const CONFIG_FOLDER = 'config/';
    protected $files = [];
    protected $directories = [];
    protected $customParameters = [];
    /**
     * Crea una instancia del Container
     *
     * @param Application $app Una instancia de Application
     *
     * @return ContainerBuilder
     */
    public function create(Application $app)
    {
        $this->configureContainer($app);
        $containerBuilder = new ContainerBuilder();
        $this->loadConfigurationFiles($containerBuilder);
        $this->loadCustomParameters($containerBuilder);
        $container->compile();
        return $containerBuilder;
    }
    /**
     * Setea toda la configuración para generar el container
     *
     * @param Application $app Una instancia de Application
     *
     * @return self
     */
    protected function configureContainer(Application $app)
    {
        //archivos de configuracion
        $this->addFile(static::CONFIG_FILE_NAME);
        $this->addFile(str_replace("{env}", $app->getEnv(), static::CONFIG_FILE_NAME_ENV));

        //primero levanta las configuraciones custom (ej providers, modulos)
        $this->addDirectories($app->getConfigPath());

        //luego la configuracion del framework y luego la del proyecto
        $this->addDirectories(
            [
                realpath(__DIR__."/../../").'/'.static::CONFIG_FOLDER,
                $app->getRootPath().static::CONFIG_FOLDER
            ]
        );

        $this->addCustomParameters('root_path', $app->getRootPath());
        $this->addCustomParameters('env', $app->getEnv());
        return $this;
    }
    /**
     * Setea los nombres de los archivos de configuracion a buscar
     *
     * @param string $file Nombre de archivos
     *
     * @return self
     */
    public function addFile($file)
    {
        $this->files[] = $file;
        return $this;
    }
    /**
     * Setea un directorio donde buscar los archivos de configuracion
     *
     * @param array $directories Directorios
     *
     * @return self
     */
    public function addDirectories(array $directories)
    {
        $this->directories = array_merge($this->directories, $directories);
        return $this;
    }
    /**
     * Agrega parametros custom al container
     *
     * @param string $key   Clave del parametro
     * @param mixed  $value Valor del parametro
     *
     * @return self
     */
    public function addCustomParameters($key, $value)
    {
        $this->customParameters[$key] = $value;
        return $this;
    }
    /**
     * Load configuration file into ContainerBuilder
     *
     * @param ContainerBuilder $containerBuilder [description]
     *
     * @return void
     */
    protected function loadConfigurationFiles(ContainerBuilder $containerBuilder)
    {
        if (empty($this->directories) || empty($this->files)) {
            return;
        }
        $finder = new Finder();
        $finder->files()->in($this->directories)->name($this->renderFilesRegex());

        $ymlLoader = new YamlFileLoader($containerBuilder, new FileLocator());

        foreach ($finder as $file) {
            $ymlLoader->load($file->getRealpath());
        }
    }
    /**
     * Genera la expresion regular de todos los archivos que se deben buscar
     *
     * @return string
     */
    protected function renderFilesRegex()
    {
        return '/('.implode("|", $this->files).')/';
    }
    /**
     * Carga los parametros custom
     *
     * @param ContainerBuilder $containerBuilder [description]
     *
     * @return void
     */
    public function loadCustomParameters(ContainerBuilder $containerBuilder)
    {
        foreach ($this->customParameters as $key => $value) {
            $containerBuilder->setParameter($key, $value);
        }
    }
}
