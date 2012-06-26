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
namespace Sherpa\Plugin\Ohcount;

use Sherpa\Iterator\ProjectIterator;
use Sherpa\Plugin\AbstractPlugin;
use Sherpa\SplFileInfo;

class OhcountPlugin extends AbstractPlugin
{
    public function accept(SplFileInfo $item)
    {
        if ('file' !== $item->getType()) {
            return false;
        }

        if ($this->isInVcsDirectory($item)) {
            return false;
        }

        return true;
    }

    public function getCode()
    {
        return 'ohcount';
    }

    public function getName()
    {
        return 'Ohcount';
    }

    public function getVersion()
    {
        return '0.1-dev';
    }

    public function getLanguages(ProjectIterator $items)
    {
        $languages = array();

        foreach ($items as $item) {
            foreach ($this->getDataForItem($item)->getLanguages() as $language) {
                if (array_key_exists($language['name'], $languages)) {
                    $languages[$language['name']]['linesOfCode']        += $language['linesOfCode'];
                    $languages[$language['name']]['commentLinesOfCode'] += $language['commentLinesOfCode'];
                    $languages[$language['name']]['blankLines']         += $language['blankLines'];
                } else {
                    $languages[$language['name']] = array(
                        'name'               => $language['name'],
                        'linesOfCode'        => $language['linesOfCode'],
                        'commentLinesOfCode' => $language['commentLinesOfCode'],
                        'blankLines'         => $language['blankLines'],
                    );
                }
            }
        }

        return $languages;
    }
}

