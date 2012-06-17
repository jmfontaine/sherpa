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

use Sherpa\Plugin\AbstractPlugin;
use Sherpa\Plugin\PluginResult;
use Sherpa\SplFileInfo;
use Symfony\Component\Process\Process;

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

    public function analyze(SplFileInfo $item)
    {
        $command = 'ohcount -i ' . escapeshellarg($item->getPathname());
        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException('Could not run Ohcount plugin on item ' . $item->getPathname());
        }
        $data = $this->parseLineCountOutput($process->getOutput());

        return new PluginResult($data);
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

    private function parseLineCountOutput($output)
    {
        $data  = array();
        $lines = explode(PHP_EOL, $output);
        $count = count($lines);

        for ($i = 4; $i < $count - 1; $i++) {
            preg_match('/^([a-z]*)\s*(\d*)\s*(\d*)\s*[\d.%]*\s*(\d*).*$/', $lines[$i], $matches);

            $data[] = array(
                'language'           => $matches[1],
                'linesOfCode'        => $matches[2],
                'commentLinesOfCode' => $matches[3],
                'blankLines'         => $matches[4],
            );
        }

        return $data;
    }
}

