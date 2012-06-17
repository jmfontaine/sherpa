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

use Sherpa\Plugin\AbstractPluginResult;
use Symfony\Component\Process\Process;

class OhcountPluginResult extends AbstractPluginResult
{
    public function getLanguages()
    {
        $command = 'ohcount -i ' . escapeshellarg($this->getItem()->getPathname());
        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException('Could not run Ohcount plugin on item ' . $this->getItem()->getPathname());
        }

        return $this->parseLanguagesOutput($process->getOutput());
    }

    public function getLicense()
    {
        $command = 'ohcount -l ' . escapeshellarg($this->getItem()->getPathname());
        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException('Could not run Ohcount plugin on item ' . $this->getItem()->getPathname());
        }

        return $this->parseLicenseOutput($process->getOutput());
    }

    private function parseLanguagesOutput($output)
    {
        $data  = array();
        $lines = explode(PHP_EOL, $output);
        $count = count($lines);

        $languages = array(
            'html' => 'HTML',
            'php'  => 'PHP',
        );

        for ($i = 4; $i < $count - 1; $i++) {
            preg_match('/^([a-z]*)\s*(\d*)\s*(\d*)\s*[\d.%]*\s*(\d*).*$/', $lines[$i], $matches);

            $language = $matches[1];
            if (array_key_exists($language, $languages)) {
                $language = $languages[$matches[1]];
            }

            $data[] = array(
                'name'               => $language,
                'linesOfCode'        => $matches[2],
                'commentLinesOfCode' => $matches[3],
                'blankLines'         => $matches[4],
            );
        }

        return $data;
    }

    private function parseLicenseOutput($output)
    {
        $offset  = strpos($output, ' ');
        $license = substr($output, 0, $offset);

        $licenses = array(
            'bsd' => 'BSD',
        );
        if (array_key_exists($license, $licenses)) {
            $license = $licenses[$license];
        }

        return $license;
    }
}
