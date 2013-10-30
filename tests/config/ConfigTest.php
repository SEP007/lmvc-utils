<?php

use Scandio\lmvc\utils\config\Config;

/**
 * Class ConfigTest
 *
 * Tests functionality of Config utils.
 */
class ConfigTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        Config::initialize('config.json');
    }

    public function testDefaultValues()
    {

    }

    public function testAddingNewLocalConfigValues()
    {

    }

    public function testOverwritingDefaultConfigValues()
    {

    }
}