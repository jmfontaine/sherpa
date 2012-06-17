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

use Sherpa\Plugin\AbstractPluginResult;

class HashPluginResult extends AbstractPluginResult
{
    public function getCrc32()
    {
        return hash('crc32', $this->getItem()->getContent());
    }

    public function getMd5()
    {
        return hash('md5', $this->getItem()->getContent());
    }

    public function getSha1()
    {
        return hash('sha1', $this->getItem()->getContent());
    }
}
