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
namespace Sherpa\Renderer;

abstract class AbstractRenderer implements RendererInterface
{
    private $destination = 'php://stdout';

    public function __construct(array $parameters)
    {
        $this->loadParameters($parameters);
    }

    public function loadParameters(array $parameters)
    {
        foreach ($parameters as $parameterName => $parameterValue) {
            $methodName = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $parameterName)));

            if (!method_exists($this, $methodName)) {
                throw new \OutOfBoundsException("Invalid parameter ($parameterName)");
            }

            $this->$methodName($parameterValue);
        }
    }

    public function setDestination($destination)
    {
        $this->destination = $destination;

        return $this;
    }

    public function getDestination($realPath = true)
    {
        $destination = $this->destination;

        if ($realPath) {
            $destination = realPath($destination);

            if (false === $destination) {
                throw new \RuntimeException("Invalid destination path ($this->destination)");
            }
        }

        return $destination;
    }
}

