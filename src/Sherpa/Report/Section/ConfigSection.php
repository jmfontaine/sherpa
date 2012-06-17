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
namespace Sherpa\Report\Section;

class ConfigSection implements ReportSectionInterface, \IteratorAggregate
{
    private $config;

    private $cursor;

    public function __construct(array $config)
    {
        $this->setConfig($config);
    }

    public function setConfig(array $config)
    {
        $this->config = $config;

        return $this;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function toArray()
    {
        return $this->config;
    }

    /*
     * \IteratorAggregate interface method
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->getConfig());
    }
}
