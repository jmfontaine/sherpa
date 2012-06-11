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

class ProjectSection implements ReportSectionInterface
{
    private $path;

    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getRealPath()
    {
        return realpath($this->path);
    }

    public function toArray()
    {
        return array(
            'path'      => $this->getPath(),
            'real_path' => $this->getRealPath(),
        );
    }
}
