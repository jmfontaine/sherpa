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
    /**
     * @var \Sherpa\Plugin\PluginManager Plugin manager
     */
    private $pluginManager;

    /**
     * @var string Path of the project root
     */
    private $projectRootPath;

    /**
     * Class constructor
     *
     * @param string        $itemPath        Path of the item
     * @param PluginManager $pluginManager   Plugin manager
     * @param string        $projectRootPath Path of the project root
     *
     * return void
     */
    public function __construct($itemPath, PluginManager $pluginManager, $projectRootPath)
    {
        parent::__construct($itemPath);

        $this->setPluginManager($pluginManager)
             ->setProjectRootPath($projectRootPath);
    }

    /**
     * Returns content if item is a file
     *
     * @return string          File content
     * @throws \LogicException Thrown if item is not a file
     */
    public function getContent()
    {
        if ('file' !== $this->getType()) {
            throw new \LogicException('Content can only be retrieved for a file');
        }

        return file_get_contents($this->getPathname());
    }

    /**
     * Returns encoding if the item is a file
     *
     * @return mixed           File encoding
     * @throws \LogicException Thrown if item is not a file
     */
    public function getEncoding()
    {
        if ('file' !== $this->getType()) {
            throw new \LogicException('Encoding can only be retrieved for a file');
        }

        return $this->getFileInfo()->file($this->getPathname(), FILEINFO_MIME_ENCODING | FILEINFO_PRESERVE_ATIME);
    }

    /**
     * Returns MIME type if the item is a file
     *
     * @return mixed           File MIME type
     * @throws \LogicException Thrown if item is not a file
     */
    public function getMimeType()
    {
        if ('file' !== $this->getType()) {
            throw new \LogicException('MIME type can only be retrieved for a file');
        }

        return $this->getFileInfo()->file($this->getPathname(), FILEINFO_MIME_TYPE | FILEINFO_PRESERVE_ATIME);
    }

    /**
     * @return string Relative path for the item
     */
    public function getRelativePath()
    {
        $offset = strlen($this->projectRootPath);

        return substr($this->getRealPath(), $offset);
    }

    /**
     * @param string $pluginName Name of the plugin to retrieve data from
     *
     * @return \Sherpa\Plugin\PluginResultInterface Data for the plugin
     */
    public function getPluginData($pluginName)
    {
        return $this->getPluginManager()->getPlugin($pluginName)->getDataForItem($this);
    }

    /**
     * @param string $pluginName Name of the plugin to retrieve
     *
     * @return \Sherpa\Plugin\PluginInterface Plugin
     */
    public function getPlugin($pluginName)
    {
        return $this->getPluginManager()->getPlugin($pluginName);
    }

    /**
     * Returns the registered plugins
     *
     * @return array Registered plugins
     */
    public function getPlugins()
    {
        return $this->getPluginManager()->getPlugins();
    }

    /**
     * Returns itme data as an array
     *
     * @return array Item data
     */
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
            $data['plugins'][$plugin->getCode()] = $plugin->getDataForItem($this);
        }
        return $data;
    }

    /**
     * Returns plugin manager
     *
     * @return \Sherpa\Plugin\PluginManager Plugin manager
     */
    public function getPluginManager()
    {
        return $this->pluginManager;
    }

    /**
     * Defines the plugin manager
     *
     * @param \Sherpa\Plugin\PluginManager $pluginManager Plugin manager
     *
     * @return \Sherpa\SplFileInfo Current instance to allow method call chaining
     */
    protected function setPluginManager(PluginManager $pluginManager)
    {
        $this->pluginManager = $pluginManager;

        return $this;
    }

    /**
     * Returns the path of project root
     *
     * @param string $projectRootPath Path of project root
     *
     * @return \Sherpa\SplFileInfo Current instance to allow method call chaining
     */
    protected function setProjectRootPath($projectRootPath)
    {
        if (!is_string($projectRootPath)) {
            $type = gettype($projectRootPath);
            throw new \InvalidArgumentException("Project root path must be a string. $type given");
        }

        $this->projectRootPath = $projectRootPath;

        return $this;
    }

    /**
     * Returns path of project root
     *
     * @return string Path of project root
     */
    public function getProjectRootPath()
    {
        return $this->projectRootPath;
    }
}
