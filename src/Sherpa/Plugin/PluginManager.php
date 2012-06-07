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

    public function getPlugin($name)
    {
        if (!array_key_exists($name, $this->plugins)) {
            throw new \OutOfBoundsException("Unknown plugin ($name)");
        }

        return $this->plugins[$name];
    }

    public function process(\Iterator $iterator, $rootPath)
    {
        $data = array();

        // Project data
        $data['project'] = array(
            'rootPath' => realpath($rootPath),
        );

        // Items data
        $pathNameOffset = strlen($rootPath);
        foreach ($iterator as $item) {
            $relativeItemPathName = substr($item->getPathName(), $pathNameOffset);

            // Item data
            $data['items'][$relativeItemPathName] = array(
                'accessTime'       => $item->getATime(),
                'modificationTime' => $item->getMTime(),
                'permissions'      => $item->getPerms(),
                'size'             => $item->getSize(),
                'type'             => $item->getType(),
            );

            if ('link' === $item->getType()) {
                $data['linkTarget'] = $item->getLinkTarget();
                $data['realPath']   = $item->getRealPath();
            }

            // Plugins data
            foreach ($this->plugins as $pluginName => $plugin) {
                if (!$plugin->accept($item)) {
                    continue;
                }

                $data['items'][$relativeItemPathName]['plugins'][$pluginName] = $plugin->analyze($item);
            }
        }

        return $data;
    }

    private function instanciatePlugin($name, array $parameters)
    {
        $normalizedName = ucwords(str_replace('_', ' ', $name));
        $className      = "Sherpa\\Plugin\\{$normalizedName}Plugin";
        $plugin         = new $className($parameters);

        return $plugin;
    }
}

