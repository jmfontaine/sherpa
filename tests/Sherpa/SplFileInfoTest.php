<?php
namespace Sherpa\Tests;

use Sherpa\SplFileInfo;
use Sherpa\Test\TestCase;

class SplFileInfoTest extends TestCase
{
    /**
     * @var \Sherpa\SplFileInfo
     */
    protected $splFileInfo;

    public function projectRootPathInvalidFormatProvider()
    {
        return array_merge(
            $this->arrayInvalidFormatValuesProvider(),
            $this->callbacksInvalidFormatValuesProvider(),
            $this->floatInvalidFormatValuesProvider(),
            $this->integerInvalidFormatValuesProvider(),
            $this->miscInvalidFormatValuesProvider()
        );
    }

    public function setUp()
    {
        $projectRootPath = realpath(__DIR__ . '/../_files');
        $itemPath        = $projectRootPath . '/README.txt';
        $pluginManager   = $this->getMock('Sherpa\\Plugin\\PluginManager', array(), array(), '', false);

        $this->splFileInfo = new SplFileInfo($itemPath, $pluginManager, $projectRootPath);
    }


    /**
     * @test
     */
    public function constructor()
    {
        $projectRootPath = realpath(__DIR__ . '/../_files');
        $itemPath        = $projectRootPath . '/README.txt';
        $pluginManager   = $this->getMock('Sherpa\\Plugin\\PluginManager', array(), array(), '', false);
        $splFileInfo     = new SplFileInfo($itemPath, $pluginManager, $projectRootPath);

        $this->assertSame($itemPath, $splFileInfo->getPathname());
        $this->assertSame($projectRootPath, $splFileInfo->getProjectRootPath());
        $this->assertSame($pluginManager, $splFileInfo->getPluginManager());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @dataProvider projectRootPathInvalidFormatProvider
     */
    public function settingAValueWithInvalidFormatAsProjectRootPathThrowsAnException($projectRootPath)
    {
        $pluginManager = $this->getMock('Sherpa\\Plugin\\PluginManager', array(), array(), '', false);

        // Item path must not be built from $projectRootPath
        // since it can be anything, and mostly not string, for this test
        $splFileInfo = new SplFileInfo('', $pluginManager, $projectRootPath);
    }
}
