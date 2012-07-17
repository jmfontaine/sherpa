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
namespace Sherpa\Test;

class TestCase extends \PHPUnit_Framework_TestCase
{
    public function callbacksInvalidFormatValuesProvider()
    {
        return array(
            //array('stringCallback'),
            array(array('DummyClass', 'callbackMethod')),
            array(array(new \StdClass(), 'callbackMethod')),
            //array('DummyClass::callbackMethod'),
            array(function(){ return false; }),
        );
    }

    public function floatInvalidFormatValuesProvider()
    {
        return array(
            array(1.23),
            array(-1.23),
            array(1.2e3),
            array(-1.2e3),
            array(7E-10),
            array(-7E-10),
        );
    }

    public function integerInvalidFormatValuesProvider()
    {
        return array(
            array(123),
            array(-123),
            array(0123),
            array(-0123),
            array(0x1A),
            array(-0x1A),
            array(0X1A),
            array(-0X1A),
            array(PHP_INT_MAX),
        );
    }

    public function stringInvalidFormatValuesProvider()
    {
        $heredocString = <<<EOS
This
is
a
heredoc
string
EOS;

        $nowdocString = <<<'EOS'
This
is
a
nowdoc
string
EOS;

        return array(
            array('Single quoted string'),
            array("Double quoted string"),
            array($heredocString),
            array($nowdocString),
        );
    }

    public function arrayInvalidFormatValuesProvider()
    {
        return array(
            // Empty array
            array(array()),

            // Indexed array
            array(array('A', 'B', 'C', 'D')),

            // Associative array
            array(array('A' => 'Apple', 'B' => 'Banana', 'C' => 'Cherry', 'D' => 'Date')),

            // Big array
            array(array_fill(0, 10000, 'Dummy')),

            // Nested array
            array(
                array(
                    array('A', 'B', 'C', 'D'),
                    array('A' => 'Apple', 'B' => 'Banana', 'C' => 'Cherry', 'D' => 'Date'),
                )
            ),
        );
    }

    public function miscInvalidFormatValuesProvider()
    {
        return array(
            // Boolean
            array(false),
            array(true),

            // Null
            array(null),

            // Class
            array(new \StdClass()),

            // Resource
            array(fopen('php://stdin', 'r')),
        );
    }
}
