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

use Sherpa\Iterator\ProjectIterator;

class ItemsSection implements ReportSectionInterface, \IteratorAggregate
{
    private $projectIterator;

    public function __construct(ProjectIterator $projectIterator)
    {
        $this->setProjectIterator($projectIterator);
    }

    public function setProjectIterator(ProjectIterator $projectIterator)
    {
        $this->projectIterator = $projectIterator;

        return $this;
    }

    public function getProjectIterator()
    {
        return $this->projectIterator;
    }

    public function getIterator()
    {
        return $this->getProjectIterator();
    }

    public function toArray()
    {
        $data = array();

        foreach ($this->getProjectIterator() as $item) {
            $data[] = $item->toArray();
        }

        return $data;
    }
}
