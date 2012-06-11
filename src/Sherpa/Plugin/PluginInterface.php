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

interface PluginInterface
{
    public function accept(\SplFileInfo $item);

    public function analyze(\SplFileInfo $item);

    public function getCode();

    public function getName();

    public function getVersion();

    public function loadConfig(array $config);
}

