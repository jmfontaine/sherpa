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

class PluginResult
{
    private $data = array();

    public function __construct(array $data)
    {
        $this->setData($data);
    }

    function __call($method, $arguments)
    {
        if ('get' === substr($method, 0, 3)) {
            $propertyName = lcfirst(substr($method, 4));
        } else {
            $propertyName = $method;
        }

        if (!array_key_exists($propertyName, $this->data)) {
            throw new \OutOfBoundsException("Invalid method ($method)");
        }

        return $this->data[$propertyName];
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    public function getData()
    {
        return $this->data;
    }
}
