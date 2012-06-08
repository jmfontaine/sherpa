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

class TwigRenderer extends AbstractRenderer
{
    private $cache = false;

    private $charset = 'utf-8';

    private $strictVariables = false;

    private $templatePath;

    public function render(array $data)
    {
        $templateDirectory = dirname($this->getTemplatePath());
        $templateFilename  = basename($this->getTemplatePath());

        $loader = new \Twig_Loader_Filesystem($templateDirectory);
        $twig = new \Twig_Environment($loader, array(
            'cache'            => $this->getCache(),
            'charset'          => $this->getCharset(),
            'strict_variables' => $this->getStrictVariables()
        ));

        echo $twig->render($templateFilename, array('data' => $data));
    }

    public function setTemplatePath($templatePath)
    {
        $this->templatePath = $templatePath;

        return $this;
    }

    public function getTemplatePath()
    {
        return $this->templatePath;
    }

    public function setCharset($charset)
    {
        $this->charset = $charset;

        return $this;
    }

    public function getCharset()
    {
        return $this->charset;
    }

    public function setCache($cache)
    {
        $this->cache = $cache;

        return $this;
    }

    public function getCache()
    {
        return $this->cache;
    }

    public function setStrictVariables($strictVariables)
    {
        $this->strictVariables = $strictVariables;

        return $this;
    }

    public function getStrictVariables()
    {
        return $this->strictVariables;
    }
}

