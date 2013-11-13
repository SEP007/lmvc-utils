<?php

use Scandio\lmvc\utils\logger\scribes\ChromeScribe;
use Scandio\lmvc\utils\config\Config;
use Scandio\lmvc\utils\string\StringUtils;

class TestChromeScribe extends PHPUnit_Framework_TestCase
{
    private
      $_scribe = null;

    protected function setUp()
    {
        $this->_scribe = new ChromeScribe();
        $this->_scribe->initialize(Config::get()->logger->scribes[1]);
    }

    public function testSimpleLogMessage()
    {
        $msg = 'Hello World';
        $this->assertTrue($this->_scribe->scribe($msg, [], "INFO"));

        $response = $this->_scribe->getResponse();

        $this->assertEquals($response['rows'][0][0], "INFO");
        $this->assertEquals($response['rows'][0][1], $msg);
    }

    public function testInterpolatedLogMessage()
    {
        #$this->assertEquals(38, $this->_scribe->scribe("Hello {who}", ['who' => 'World'], "INFO"));
    }
}