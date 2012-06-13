<?php
namespace Sherpa\Twig\Loader;

class Filesystem implements \Twig_LoaderInterface
{
    private $pluginLoader;

    private $themeLoader;

    public function __construct(\Twig_Loader_Filesystem $themeLoader = null,
                                \Twig_Loader_Filesystem $pluginLoader = null)
    {
        if (null === $themeLoader) {
            $themeLoader = new \Twig_Loader_Filesystem(array());
        }
        $this->setThemeLoader($themeLoader);

        if (null === $pluginLoader) {
            $pluginLoader = new \Twig_Loader_Filesystem(array());
        }
        $this->setPluginLoader($pluginLoader);
    }

    /**
     * Gets the source code of a template, given its name.
     *
     * @param string $name The name of the template to load
     *
     * @return string The template source code
     *
     * @throws \Twig_Error_Loader When $name is not found
     */
    function getSource($name)
    {
        $shortName = $this->getDenormalizedTemplateName($name);

        return $this->getLoaderByTemplateName($name)->getSource($shortName);
    }

    /**
     * Gets the cache key to use for the cache for a given template name.
     *
     * @param string $name The name of the template to load
     *
     * @return string The cache key
     *
     * @throws \Twig_Error_Loader When $name is not found
     */
    function getCacheKey($name)
    {
        $shortName = $this->getDenormalizedTemplateName($name);

        return $this->getLoaderByTemplateName($name)->getCacheKey($shortName);
    }

    /**
     * Returns true if the template is still fresh.
     *
     * @param string    $name The template name
     * @param timestamp $time The last modification time of the cached template
     *
     * @return Boolean true if the template is fresh, false otherwise
     *
     * @throws \Twig_Error_Loader When $name is not found
     */
    function isFresh($name, $time)
    {
        $shortName = $this->getDenormalizedTemplateName($name);

        return $this->getLoaderByTemplateName($name)->isFresh($shortName, $time);
    }

    public function setThemeLoader($themeLoader)
    {
        $this->themeLoader = $themeLoader;
        return $this;
    }

    /**
     * @return \Twig_Loader_Filesystem
     */
    public function getThemeLoader()
    {
        return $this->themeLoader;
    }

    public function setPluginLoader($pluginLoader)
    {
        $this->pluginLoader = $pluginLoader;
        return $this;
    }

    /**
     * @return \Twig_Loader_Filesystem
     */
    public function getPluginLoader()
    {
        return $this->pluginLoader;
    }

    public function addThemePath($path)
    {
        $this->getThemeLoader()->addPath($path);

        return $this;
    }

    public function addPluginPath($path)
    {
        $this->getPluginLoader()->addPath($path);

        return $this;
    }

    public function getLoaderByTemplateName($name)
    {
        $parts = explode('/', $name);

        if ('theme' === $parts[0]) {
            return $this->getThemeLoader();
        } elseif ('plugin' === $parts[0]) {
            return $this->getPluginLoader();
        } else {
            throw new \LogicException("Could not determinate loader for template ($name)");
        }
    }

    protected function getDenormalizedTemplateName($name)
    {
        $parts = explode('/', $name);

        if ('theme' === $parts[0]) {
            unset($parts[0]);

            return implode('/', $parts);
        } elseif ('plugin' === $parts[0]) {
            return $parts[1] . '/templates/' . $parts[2];
        } else {
            throw new \LogicException("Could not determinate short name for template ($name)");
        }
    }
}
