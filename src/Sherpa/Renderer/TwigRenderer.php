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

use Sherpa\FileSystem;
use Sherpa\Report\Report;
use Sherpa\Twig\Loader\Filesystem as FilesystemLoader;

class TwigRenderer extends AbstractRenderer
{
    private $cache = false;

    private $charset = 'utf-8';

    private $debug = false;

    private $strictVariables = false;

    private $theme = 'unity';

    public function render(Report $report)
    {
        $sherpaThemesDirectory = realpath(__DIR__ . '/../../../themes');
        $theme                 = $this->getTheme();
        $themeDirectory        = $sherpaThemesDirectory . '/' . $theme;

        $loader = new FilesystemLoader();
        $loader->addThemePath($sherpaThemesDirectory)
               ->addPluginPath(realpath(__DIR__ . '/../Plugin/'));

        $twig   = new \Twig_Environment($loader, array(
            'cache'            => $this->getCache(),
            'charset'          => $this->getCharset(),
            'debug'            => $this->getDebug(),
            'strict_variables' => $this->getStrictVariables(),
        ));
        $twig->addExtension(new \Sherpa\Twig\Extension\Core());

        if ($this->getDebug()) {
            $twig->addExtension(new \Twig_Extension_Debug());
        }

        $destinationDirectory = $this->getDestination();

        $this->prepareDestinationDirectory($destinationDirectory);
        $this->renderTemplates($twig, $report, $theme, $destinationDirectory);
        $this->copyAssets($themeDirectory, $destinationDirectory);
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

    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    public function getTheme()
    {
        return $this->theme;
    }

    public function setDebug($debug)
    {
        $this->debug = $debug;

        return $this;
    }

    public function getDebug()
    {
        return $this->debug;
    }

    protected function prepareDestinationDirectory($path)
    {
        $fileSystem = new FileSystem();

        // Empty destination directory if it exists…
        if (file_exists($path)) {
            $fileSystem->emptyDirectory($path);
        } else {
            // …otherwise create it
            mkdir($path);
        }
    }

    protected function renderTemplates(\Twig_Environment $twig, Report $report, $theme, $destinationDirectory)
    {
        // Main pages
        $templates = array(
            "theme/$theme/configuration.twig" => 'configuration.html',
            "theme/$theme/items.twig"         => 'items.html',
            "theme/$theme/plugins.twig"       => 'plugins.html',
            "theme/$theme/project.twig"       => 'index.html',
        );
        foreach ($templates as $templateName => $destinationName) {
            $this->renderTemplate(
                $twig,
                array('report' => $report),
                $templateName,
                $destinationDirectory . '/' . $destinationName
            );
        }

        // Items pages
        foreach ($report->getItems() as $item) {
            $destinationName = 'item-' . md5($item->getRealPath()) . '.html';
            $this->renderTemplate(
                $twig,
                array('item' => $item),
                "theme/$theme/item.twig",
                $destinationDirectory . '/' . $destinationName
            );
        }

        // Plugins pages
        foreach ($report->getPlugins()->getPluginManager()->getPlugins() as $plugin) {
            $destinationName = 'plugin-' . $plugin->getCode() . '.html';
            $this->renderTemplate(
                $twig,
                array('plugin' => $plugin),
                "theme/$theme/plugin.twig",
                $destinationDirectory . '/' . $destinationName
            );
        }
    }

    protected function renderTemplate(\Twig_Environment $twig, array $context, $templateName, $destinationPath)
    {
        $html = $twig->render($templateName, $context);
        file_put_contents($destinationPath, $html);

        return $this;
    }

        protected function copyAssets($themeDirectory, $destinationDirectory)
    {
        if (!file_exists($themeDirectory . '/assets')) {
            return;
        }

        $fileSystem = new FileSystem();
        $fileSystem->copyDirectory($themeDirectory . '/assets', $destinationDirectory . '/assets');
    }
}
