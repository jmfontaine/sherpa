<?php
/**
 * Copyright (c) 2012, Jean-Marc Fontaine
 * All rights reserved.
 *
 * @package Sherpa
 * @author Jean-Marc Fontaine <jm@jmfontaine.net>
 * @copyright 2012 Jean-Marc Fontaine <jm@jmfontaine.net>
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 */
namespace Sherpa\Console\Command;

use Sherpa\Plugin\PluginManager;
use Sherpa\Renderer\RendererManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Parser as YamlParser;

class AnalyzeCommand extends Command
{
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Console\Command.Command::configure()
     */
    protected function configure()
    {
        $this->setName('analyze')
             ->setDescription('Analyzes a piece of code')
             ->setHelp(PHP_EOL . 'Analyzes a piece of code%s' . PHP_EOL)
             ->addOption('config', 'c', InputOption::VALUE_OPTIONAL, 'Path to config file.')
             ->addArgument('path', InputArgument::REQUIRED, 'Piece of code to analyze');
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Console\Command.Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Load configuration file
        $configPath = $input->getOption('config');
        if (null === $configPath) {
            $configPath = $this->getDefaultConfigPath();
        }

        try {
            $config = $this->loadConfig($configPath);
        } catch (Exception $exception) {
            $output->writeln($exception->getMessage());
        }

        $pluginManager = new PluginManager($config['plugins']);
        $path          = $input->getArgument('path');
        $iterator      = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        $data          = $pluginManager->process($iterator, $path);

        $rendererManager = new RendererManager($config['renderers']);
        $rendererManager->render($data);
    }

    protected function getDefaultConfigPath()
    {
        return getcwd() . '/sherpa.yml';
    }

    protected function loadConfig($configPath)
    {
        if (!is_file($configPath) || !is_readable($configPath)) {
            throw new \InvalidArgumentException("Invalid configuration file provided ($configPath)");
        }
        $yaml = file_get_contents($configPath);

        try {
            $yamlParser = new YamlParser();
            $config = $yamlParser->parse($yaml);
        } catch (Exception $exception) {
            throw new \RuntimeException("Invalid configuration file content ($configPath)", null, $exception);
        }

        return $config;
    }
}
