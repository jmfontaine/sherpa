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

class RendererManager
{
    private $renderers = array();

    public function __construct(array $config)
    {
        $this->loadConfig($config);
    }

    public function loadConfig(array $config)
    {
        foreach ($config as $name => $parameters) {
            $this->renderers[$name] = $this->instanciateRenderer($name, (array) $parameters);
        }

        return $this;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getRenderer($name)
    {
        if (!array_key_exists($name, $this->renderers)) {
            throw new \OutOfBoundsException("Unknown renderer ($name)");
        }

        return $this->renderers[$name];
    }

    public function render(array $data)
    {
        foreach ($this->renderers as $renderer) {
            $renderer->render($data);
        }
    }

    private function instanciateRenderer($name, array $parameters)
    {
        $normalizedName = ucwords(str_replace('_', ' ', $name));
        $className      = "Sherpa\\Renderer\\{$normalizedName}Renderer";
        $plugin         = new $className($parameters);

        return $plugin;
    }
}

