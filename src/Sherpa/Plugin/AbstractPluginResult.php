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

use Sherpa\SplFileInfo;

class AbstractPluginResult
{
    private $item;

    public function __construct(SplFileInfo $item)
    {
        $this->setItem($item);
    }

    public function setItem(SplFileInfo $item)
    {
        $this->item = $item;
        return $this;
    }

    /**
     * @return \Sherpa\SplFileInfo
     */
    public function getItem()
    {
        return $this->item;
    }
}
