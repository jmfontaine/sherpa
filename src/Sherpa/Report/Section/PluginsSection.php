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
namespace Sherpa\Report\Section;

use Sherpa\Plugin\PluginManager;

class PluginsSection implements ReportSectionInterface
{
    /**
     * @var \Sherpa\Plugin\PluginManager
     */
    private $pluginManager;

    public function __construct(PluginManager $pluginManager)
    {
        $this->setPluginManager($pluginManager);
    }

    public function setPluginManager(PluginManager $pluginManager)
    {
        $this->pluginManager = $pluginManager;

        return $this;
    }

    public function getPluginManager()
    {
        return $this->pluginManager;
    }

    public function getPlugin($name)
    {
        return $this->pluginManager->getPlugin($name);
    }

    public function toArray()
    {
        $data = array();

        foreach ($this->getPluginManager()->getPlugins() as $plugin) {
            $data[] = $plugin->getName();
        }

        return $data;
    }
}
