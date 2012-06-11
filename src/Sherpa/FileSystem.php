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
namespace Sherpa;

class FileSystem
{
    public function copyDirectory($source, $destination)
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($source)
        );

        foreach ($iterator as $item) {
            $relativePath = substr($item->getPathName(), strlen($source) + 1);
            $path         = $destination . '/' . $relativePath;

            if ($item->isFile()) {
                $directory = dirname($path);
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }

                copy($item->getPathName(), $path);
            }
        }
    }

    public function emptyDirectory($path)
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path),
            \RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($iterator as $item) {
            if ($item->isDir()) {
                rmdir($item->__toString());
            } else {
                unlink($item->__toString());
            }
        }

        return $this;
    }

    public function removeDirectory($path)
    {
        $this->emptyDirectory($path);
        rmdir($path);

        return $this;
    }
}
