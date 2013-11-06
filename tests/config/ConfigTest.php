<?php

use Scandio\lmvc\utils\config\Config;

/**
 * Class ConfigTest
 *
 * Tests functionality of Config utils.
 */
class ConfigTest extends PHPUnit_Framework_TestCase
{
    public static function setUpBeforeClass()
    {

    }

    public function testUninitializedConfig()
    {
        # Silent to omit warning and test for empty value
        $this->assertEmpty(Config::get()->modules);
    }

    public function testDefaultValues()
    {
        Config::initialize();

        $this->assertNotEmpty(Config::get()->appPath);
        $this->assertEquals('./', Config::get()->appPath);

        $this->assertNotEmpty(Config::get()->controllers);
        $this->assertSameSize(Config::get()->views, [1]);
    }

    public function testAddingNewLocalConfigValues()
    {
        Config::initialize(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.json');

        $this->assertNotEmpty(Config::get()->dsn);

        $this->assertNotEmpty(Config::get()->username);
        $this->assertEquals('root', Config::get()->username);

        $this->assertTrue(Config::get()->assetpipeline->useFolders);
    }

    public function testOverwritingDefaultConfigValues()
    {
        $this->assertNotEmpty(Config::get()->views);
        $this->assertEquals('./app/views', Config::get()->views[0]);
    }

    public function testMergingConfigFilesByArrayKeys()
    {
        # Ordinary value in config.json
        $this->assertTrue(Config::get()->assetpipeline->useFolders);

        Config::initialize(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config2.json');

        # Overwritten but equal in config2.json
        $this->assertTrue(Config::get()->assetpipeline->useFolders);

        # Check again ordinary value should not be set in current merge algo
        $this->assertEmpty(@Config::get()->assetpipeline->test);
    }
}