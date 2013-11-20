<?php

use Scandio\lmvc\utils\logger\scribes\ScreenScribe;
use Scandio\lmvc\utils\config\Config;
use Scandio\lmvc\utils\string\StringUtils;

class TestScreenScribe extends PHPUnit_Framework_TestCase
{
    private
      $_scribe = null;

    protected function setUp()
    {
        $this->_scribe = new ScreenScribe();

        $this->_scribe->initialize(Config::get()->logger->scribes[2]);
    }

    public function testSimpleLogMessage()
    {
        $msg = 'Hello World';
        $this->assertTrue($this->_scribe->scribe($msg, [], "INFO"));
    }

    public function testInterpolatedLogMessage()
    {
        $this->assertTrue($this->_scribe->scribe("Hello {who}", ['who' => 'World'], "INFO"));
    }
}