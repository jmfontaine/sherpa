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

class ProjectIterator implements \IteratorAggregate
{
    private $path;

    public function __construct($path)
    {
        $this->setPath($path);
    }

    public function getIterator()
    {
        $directoryIterator = new RecursiveDirectoryIterator($this->getPath());

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
}

