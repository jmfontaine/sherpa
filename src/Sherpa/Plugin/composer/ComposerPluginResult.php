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
namespace Sherpa\Plugin\Composer;

use Sherpa\Plugin\AbstractPluginResult;

class ComposerPluginResult extends AbstractPluginResult
{
    public function isDefinitionFile()
    {
        return 'composer.json' === $this->getItem()->getFilename();
    }

    public function isLockFile()
    {
        return 'composer.lock' === $this->getItem()->getFilename();
    }

    public function isPharFile()
    {
        return 'composer.phar' === $this->getItem()->getFilename();
    }
}
