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

interface PluginInterface
{
    public function accept(SplFileInfo $item);

    public function getCode();

    public function getDataForItem(SplFileInfo $item);

    public function getName();

    public function getVersion();

    public function loadConfig(array $config);
}

