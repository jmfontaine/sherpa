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

class ConfigSection implements ReportSectionInterface, \Iterator
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

    /*
     * \Iterator interface methods
     */

    public function current()
    {
        return current($this->config);
    }

    public function next()
    {
        return next($this->config);
    }

    public function key()
    {
        return key($this->config);
    }

    public function valid()
    {
        $key = key($this->config);

        return $key !== NULL && $key !== FALSE;
    }

    public function rewind()
    {
        reset($this->config);
    }

    public function toArray()
    {
        return $this->config;
    }
}
