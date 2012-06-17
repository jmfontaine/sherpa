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
namespace Sherpa\Plugin;

class PluginManager
{
    private $plugins = array();

    public function __construct(array $config)
    {
        $this->loadConfig($config);
    }

    public function loadConfig(array $config)
    {
        foreach ($config as $name => $parameters) {
            $this->plugins[$name] = $this->instanciatePlugin($name, (array) $parameters);
        }

        return $this;
    }

    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param $name
     *
     * @return \Sherpa\Plugin\PluginInterface
     * @throws \OutOfBoundsException
     */
    public function getPlugin($name)
    {
        if (!array_key_exists($name, $this->plugins)) {
            throw new \OutOfBoundsException("Unknown plugin ($name)");
        }

        return $this->plugins[$name];
    }

    public function getPlugins()
    {
        return $this->plugins;
    }

    private function instanciatePlugin($name, array $parameters)
    {
        $normalizedName = ucwords(str_replace('_', ' ', $name));
        $className      = "Sherpa\\Plugin\\{$normalizedName}\\{$normalizedName}Plugin";
        $plugin         = new $className($parameters);

        return $plugin;
    }
}

