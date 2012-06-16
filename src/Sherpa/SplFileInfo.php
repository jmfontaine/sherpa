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

use Sherpa\Plugin\PluginManager;

class SplFileInfo extends \SplFileInfo
{
    private $fileInfo;

    private $pluginManager;

    private $projectRootPath;

    public function __construct($filePath, PluginManager $pluginManager, $projectRootPath, \finfo $fileInfo = null)
    {
        parent::__construct($filePath);

        $this->pluginManager   = $pluginManager;
        $this->projectRootPath = $projectRootPath;

        if (null === $fileInfo) {
            $fileInfo = new \finfo();
        }
        $this->fileInfo = $fileInfo;
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
        $offset = strlen($this->projectRootPath);

        return substr($this->getRealPath(), $offset);
    }

    public function getPlugin($pluginName)
    {
        return $this->getPluginManager()->getPlugin($pluginName)->analyze($this);
    }

    public function getPlugins()
    {
        return $this->getPluginManager()->getPlugins();
    }

    public function toArray()
    {
        $data = array(
            'access_time'       => $this->getATime(),
            'basename'          => $this->getBasename(),
            'change_time'       => $this->getCTime(),
            'encoding'          => $this->getEncoding(),
            'extension'         => $this->getExtension(),
            'filename'          => $this->getFilename(),
            'group'             => $this->getGroup(),
            'inode'             => $this->getInode(),
            'mime_type'         => $this->getMimeType(),
            'modification_time' => $this->getMTime(),
            'owner'             => $this->getOwner(),
            'path'              => $this->getPath(),
            'pathname'          => $this->getPathname(),
            'perms'             => $this->getPerms(),
            'relative_path'     => $this->getRelativePath(),
            'size'              => $this->getSize(),
            'type'              => $this->getType(),
        );

        $data['link_target'] = $this->isLink() ? $this->getLinkTarget() : null;

        foreach ($this->getPluginManager()->getPlugins() as $plugin) {
            $data['plugins'][$plugin->getCode()] = $plugin->analyze($this);
        }
        return $data;
    }

    protected function getPluginManager()
    {
        return $this->pluginManager;
    }

    protected function setFileInfo(\finfo $fileInfo)
    {
        $this->fileInfo = $fileInfo;

        return $this;
    }

    protected function setPluginManager(PluginManager $pluginManager)
    {
        $this->pluginManager = $pluginManager;

        return $this;
    }

    protected function setProjectRootPath($projectRootPath)
    {
        $this->projectRootPath = $projectRootPath;

        return $this;
    }

    protected function getProjectRootPath()
    {
        return $this->projectRootPath;
    }
}
