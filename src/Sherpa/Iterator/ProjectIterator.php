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
namespace Sherpa\Iterator;

use Sherpa\Plugin\PluginManager;

class ProjectIterator implements \IteratorAggregate
{
    private $path;

    private $pluginManager;

    public function __construct($path, PluginManager $pluginManager)
    {
        $this->setPath($path)
             ->setPluginManager($pluginManager);
    }

    public function getIterator()
    {
        // We must pass path twice since project root path is the same
        // than iterator path for the parent iterator but not for its children
        $directoryIterator = new RecursiveDirectoryIterator(
            $this->getPath(),
            $this->getPluginManager(),
            realpath($this->getPath())
        );

        return new \RecursiveIteratorIterator($directoryIterator);
    }

    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    public function getPath()
    {
        return $this->path;
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
}

