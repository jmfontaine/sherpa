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

use Sherpa\SplFileInfo;

class RecursiveDirectoryIterator extends \RecursiveDirectoryIterator
{
    public function __construct($path, $flags = null)
    {
        if ($flags & (self::CURRENT_AS_PATHNAME | self::CURRENT_AS_SELF)) {
            throw new \RuntimeException('This iterator only support returning current as SplFileInfo.');
        }

        parent::__construct($path, $flags);
    }

    public function current()
    {
        return new SplFileInfo(parent::current()->getPathname(), $this->getSubPath(), $this->getSubPathname());
    }
}

