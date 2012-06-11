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
namespace Sherpa\Report;

use Sherpa\Iterator\ProjectIterator;
use Sherpa\Plugin\PluginManager;
use Sherpa\Report\Section\ConfigSection;
use Sherpa\Report\Section\ItemsSection;
use Sherpa\Report\Section\PluginsSection;
use Sherpa\Report\Section\ProjectSection;

class Report
{
    private $configSection;

    private $itemsSection;

    private $pluginManager;

    private $pluginsSection;

    private $projectSection;

    private $projectIterator;

    public function __construct(ProjectIterator $projectIterator, PluginManager $pluginManager, array $config,
                                ProjectSection $projectSection = null, ItemsSection $itemsSection = null,
                                PluginsSection $pluginsSection = null, ConfigSection $configSection = null)
    {
        if (null === $projectSection) {
            $projectSection = new ProjectSection();
        }
        if (null === $itemsSection) {
            $itemsSection = new ItemsSection($projectIterator);
        }
        if (null === $pluginsSection) {
            $pluginsSection = new PluginsSection($pluginManager);
        }
        if (null === $configSection) {
            $configSection = new ConfigSection($config);
        }

        $this->setProjectIterator($projectIterator)
             ->setPluginManager($pluginManager)
             ->setProject($projectSection)
             ->setItems($itemsSection)
             ->setPlugins($pluginsSection)
             ->setConfig($configSection);
    }

    /**
     * @return \Sherpa\Report\Section\ItemsSection
     */
    public function getItems()
    {
        return $this->itemsSection;
    }

    protected function setItems(ItemsSection $itemsSection)
    {
        $this->itemsSection = $itemsSection;

        return $this;
    }

    protected function setProjectIterator(ProjectIterator $projectIterator)
    {
        $this->projectIterator = $projectIterator;

        return $this;
    }

    protected function getProjectIterator()
    {
        return $this->projectIterator;
    }

    protected function setPluginManager(PluginManager $pluginManager)
    {
        $this->pluginManager = $pluginManager;

        return $this;
    }

    protected function getPluginManager()
    {
        return $this->pluginManager;
    }

    protected function setProject(ProjectSection $projectSection)
    {
        $this->projectSection = $projectSection;

        return $this;
    }

    /**
     * @return \Sherpa\Report\Section\ProjectSection
     */
    public function getProject()
    {
        return $this->projectSection;
    }

    protected function setPlugins(PluginsSection $pluginsSection)
    {
        $this->pluginsSection = $pluginsSection;

        return $this;
    }

    /**
     * @return \Sherpa\Report\Section\PluginsSection
     */
    public function getPlugins()
    {
        return $this->pluginsSection;
    }

    public function setConfig(ConfigSection $configSection)
    {
        $this->configSection = $configSection;

        return $this;
    }

    public function getConfig()
    {
        return $this->configSection;
    }

    public function toArray()
    {
        return array(
            'config'  => $this->getConfig()->toArray(),
            'items'   => $this->getItems()->toArray(),
            'plugins' => $this->getPlugins()->toArray(),
            'project' => $this->getProject()->toArray(),
        );
    }
}
