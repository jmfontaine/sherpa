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

use Sherpa\SplFileInfo;

abstract class AbstractPlugin implements PluginInterface
{
    public function __construct(array $config)
    {
        $this->loadConfig($config);
    }

    public function accept(SplFileInfo $item)
    {
        return true;
    }

    public function isInVcsDirectory(SplFileInfo $item)
    {
        // Bazaar
        if (false !== strpos($item->getPathName(), '.bzr/')) {
            return true;
        }

        // CVS
        if (false !== strpos($item->getPathName(), 'CVS/')) {
            return true;
        }

        // Darcs
        if (false !== strpos($item->getPathName(), '_darcs/')) {
            return true;
        }

        // Git
        if (false !== strpos($item->getPathName(), '.git/')) {
            return true;
        }

        // Mercurial
        if (false !== strpos($item->getPathName(), '.hg/')) {
            return true;
        }

        // Monotone
        if (false !== strpos($item->getPathName(), '_MNT/')) {
            return true;
        }

        // Subversion
        if (false !== strpos($item->getPathName(), '.svn/')) {
            return true;
        }

        return false;
    }

    public function loadConfig(array $config)
    {
        // Do nothing
    }
}
