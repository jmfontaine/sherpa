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
namespace Sherpa\Plugin\Hash;

use Sherpa\Plugin\AbstractPlugin;
use Sherpa\Plugin\PluginResult;
use Sherpa\SplFileInfo;

class HashPlugin extends AbstractPlugin
{
    public function accept(SplFileInfo $item)
    {
        if ('file' !== $item->getType()) {
            return false;
        }

        if ($this->isInVcsDirectory($item)) {
            return false;
        }

        return true;
    }

    public function getCode()
    {
        return 'hash';
    }

    public function getName()
    {
        return 'Hash';
    }

    public function getVersion()
    {
        return '0.1-dev';
    }

    public function analyze(SplFileInfo $item)
    {
        $data = array(
            'crc32' => hash('crc32', $item->getContent()),
            'md5'   => hash('md5', $item->getContent()),
            'sha1'  => hash('sha1', $item->getContent()),
        );

        return new PluginResult($data);
    }
}
