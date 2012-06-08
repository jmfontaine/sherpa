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
namespace Sherpa;

class SplFileInfo extends \SplFileInfo
{
    private $relativePath;

    private $relativePathname;

    public function __construct($filePath, $relativePath, $relativePathname)
    {
        parent::__construct($filePath);

        $this->relativePath     = $relativePath;
        $this->relativePathname = $relativePathname;
    }

    public function getRelativePath()
    {
        return $this->relativePath;
    }

    public function getRelativePathname()
    {
        return $this->relativePathname;
    }
}
