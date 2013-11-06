<?php

use Scandio\lmvc\utils\logger\scribes\FileScribe;
use Scandio\lmvc\utils\config\Config;
use Scandio\lmvc\utils\string\StringUtils;

class TestFileScribe extends PHPUnit_Framework_TestCase
{
    private
      $_scribe = null,
      $_rootPath = null;

    protected function setUp()
    {
        $this->_scribe      = new FileScribe();
        $this->_rootPath    = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR;

        Config::initialize($this->_rootPath . 'config.json');
        Config::get()->logger->logRoot = dirname($this->_rootPath) . DIRECTORY_SEPARATOR . 'logs';

        $this->_scribe->initialize(Config::get()->logger->scribes[0]);
    }

    public function testSimpleLogMessage()
    {
        $msg = 'Hello World';
        $this->assertEquals(38, $this->_scribe->scribe($msg, [], "INFO"));
    }

    public function testInterpolatedLogMessage()
    {
        $this->assertEquals(38, $this->_scribe->scribe("Hello {who}", ['who' => 'World'], "INFO"));
    }
}