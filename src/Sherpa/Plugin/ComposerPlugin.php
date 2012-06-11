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

use Symfony\Component\Process\Process;

class ComposerPlugin extends AbstractPlugin
{
    public function accept(\SplFileInfo $item)
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
        return 'composer';
    }

    public function getName()
    {
        return 'Composer';
    }

    public function getVersion()
    {
        return '0.1-dev';
    }

    public function analyze(\SplFileInfo $item)
    {
        return array(
            'isDefinitionFile' => 'composer.json' === $item->getFilename(),
            'isLockFile'       => 'composer.lock' === $item->getFilename(),
            'isPharFile'       => 'composer.phar' === $item->getFilename(),
        );
    }
}
