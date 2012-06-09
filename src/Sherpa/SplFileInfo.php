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
    private $fileInfo;

    private $relativePath;

    private $relativePathname;

    public function __construct($filePath, $relativePath, $relativePathname)
    {
        parent::__construct($filePath);

        $this->relativePath     = $relativePath;
        $this->relativePathname = $relativePathname;

        $this->fileInfo = new \finfo();
    }

    public function getContent()
    {
        if ('file' === $this->getType()) {
            return file_get_contents($this->getPathname());
        }

        throw new \LogicException('Content can only be retrieved for a file');
    }

    public function getEncoding()
    {
        return $this->fileInfo->file($this->getPathname(), FILEINFO_MIME_ENCODING | FILEINFO_PRESERVE_ATIME);
    }

    public function getMimeType()
    {
        return $this->fileInfo->file($this->getPathname(), FILEINFO_MIME_TYPE | FILEINFO_PRESERVE_ATIME);
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
