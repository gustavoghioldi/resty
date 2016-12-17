<?php
/**
 * ServerCommand
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

// Resty
use Resty\Command\BaseCommand;
// Symfony - Console
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
// Symfony - Process
use Symfony\Component\Process\ProcessUtils;
use Symfony\Component\Process\PhpExecutableFinder;

/**
 * ServerCommand
 *
 * @category  Resty
 * @package   Resty\Command
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class ServerCommand extends BaseCommand
{
    /**
     * Configura el comando
     * 
     * @return [type] [description]
     */
    protected function configure()
    {
        $this
            ->setName('serve')
            ->setDescription('Serve the application on the PHP development server')
            ->addOption(
                'host',
                null,
                InputOption::VALUE_REQUIRED,
                'Configuración de host. Default: localhost',
                'localhost'
            )
            ->addOption(
                'port',
                null,
                InputOption::VALUE_REQUIRED,
                'Configuración de puerto. Default: localhost',
                '5005'
            )
            ->addOption(
                'target',
                null,
                InputOption::VALUE_REQUIRED,
                'Path del directorio publico. Default: ./public',
                './public'
            );
    }
    /**
     * Ejecuta el comando
     * 
     * @param InputInterface  $input  Instancia
     * @param OutputInterface $output Instancia
     * 
     * @return [type]                  [description]
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $host = $input->getOption('host');
        $port = $input->getOption('port');
        $target = $input->getOption('target');

        $binary = ProcessUtils::escapeArgument((new PhpExecutableFinder)->find(false));

        $output->writeln("Resty development server started on http://{$host}:{$port}");

        $cmd = "{$binary} -S {$host}:{$port} -t {$target}";
        passthru($cmd);
    }
}
