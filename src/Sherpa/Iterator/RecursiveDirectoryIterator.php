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
use Sherpa\SplFileInfo;

class RecursiveDirectoryIterator extends \RecursiveDirectoryIterator
{
    private $pluginManager;

    private $projectRootPath;

    public function __construct($path, PluginManager $pluginManager, $projectRootPath, $flags = null)
    {
        if ($flags & (self::CURRENT_AS_PATHNAME | self::CURRENT_AS_SELF)) {
            throw new \RuntimeException('This iterator only support returning current as SplFileInfo.');
        }

        parent::__construct($path, $flags);

        $this->setPluginManager($pluginManager)
             ->setProjectRootPath($projectRootPath);
    }

    public function current()
    {
        return new SplFileInfo(
            parent::current()->getPathname(),
            $this->getPluginManager(),
            $this->getProjectRootPath()
        );
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

    public function getChildren()
    {
        return new self($this->getPathname(), $this->getPluginManager(), $this->getProjectRootPath());
    }

    public function setProjectRootPath($projectRootPath)
    {
        $this->projectRootPath = $projectRootPath;

        return $this;
    }

    public function getProjectRootPath()
    {
        return $this->projectRootPath;
    }
}

