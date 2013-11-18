<?php

use Scandio\lmvc\utils\logger\Logger;
use Scandio\lmvc\utils\config\Config;

class TestLogger extends PHPUnit_Framework_TestCase
{
    private
        $_scribeNamespace = null;

    protected function setUp()
    {
        $this->_rootPath    = dirname(__FILE__) . DIRECTORY_SEPARATOR;

        Config::initialize($this->_rootPath . 'config.json');
        Config::get()->logger->logRoot = dirname($this->_rootPath) . DIRECTORY_SEPARATOR . 'logs';

        Logger::instance()->initialize();

        $this->_scribeNamespace = substr(Config::get()->logger->scribes[0]->namespace, 1);
    }

    public function testInfoLog()
    {
        $outcomes = Logger::instance()->info("Hello World", []);
        $this->assertEquals(33, $outcomes[$this->_scribeNamespace]);

        $outcomes = Logger::instance()->info("Hello {who}", ['who' => 'World']);
        $this->assertEquals(33, $outcomes[$this->_scribeNamespace]);
    }

    public function testEmergencyLog()
    {
        $outcomes = Logger::instance()->emergency("Hello World", []);

        $this->assertEquals(38, $outcomes[$this->_scribeNamespace]);

        $outcomes = Logger::instance()->emergency("Hello {who}", ['who' => 'World']);
        $this->assertEquals(38, $outcomes[$this->_scribeNamespace]);
    }

    public function testAlertLog()
    {
        $outcomes = Logger::instance()->alert("Hello World", []);
        $this->assertEquals(34, $outcomes[$this->_scribeNamespace]);

        $outcomes = Logger::instance()->alert("Hello {who}", ['who' => 'World']);
        $this->assertEquals(34, $outcomes[$this->_scribeNamespace]);
    }

    public function testCriticalLog()
    {
        $outcomes = Logger::instance()->critical("Hello World", []);
        $this->assertEquals(37, $outcomes[$this->_scribeNamespace]);

        $outcomes = Logger::instance()->critical("Hello {who}", ['who' => 'World']);
        $this->assertEquals(37, $outcomes[$this->_scribeNamespace]);
    }

    public function testErrorLog()
    {
        $outcomes = Logger::instance()->error("Hello World", []);
        $this->assertEquals(34, $outcomes[$this->_scribeNamespace]);

        $outcomes = Logger::instance()->error("Hello {who}", ['who' => 'World']);
        $this->assertEquals(34, $outcomes[$this->_scribeNamespace]);
    }

    public function testWarningLog()
    {
        $outcomes = Logger::instance()->warning("Hello World", []);
        $this->assertEquals(36, $outcomes[$this->_scribeNamespace]);

        $outcomes = Logger::instance()->warning("Hello {who}", ['who' => 'World']);
        $this->assertEquals(36, $outcomes[$this->_scribeNamespace]);
    }

    public function testNoticeLog()
    {
        $outcomes = Logger::instance()->notice("Hello World", []);
        $this->assertEquals(35, $outcomes[$this->_scribeNamespace]);

        $outcomes = Logger::instance()->notice("Hello {who}", ['who' => 'World']);
        $this->assertEquals(35, $outcomes[$this->_scribeNamespace]);
    }

    public function testDebugLog()
    {
        $outcomes = Logger::instance()->debug("Hello World", []);
        $this->assertEquals(34, $outcomes[$this->_scribeNamespace]);

        $outcomes = Logger::instance()->debug("Hello {who}", ['who' => 'World']);
        $this->assertEquals(34, $outcomes[$this->_scribeNamespace]);
    }

    public function testRemoveScribe()
    {
        $this->assertTrue(Logger::instance()->removeScribe(Config::get()->logger->scribes[0]->namespace));

        $outcomes = Logger::instance()->debug("Hello World", []);

        $activeScribes = count( Config::get()->logger->scribes );
        $this->assertCount($activeScribes - 1, $outcomes);
    }

    public function testReinitializationOfLogger()
    {
        Logger::instance()->initialize();

        $outcomes = Logger::instance()->debug("Hello World", []);
        $this->assertEquals(34, $outcomes[$this->_scribeNamespace]);
    }

    public function testLogOmitByGlobalLevel()
    {
        $level = Config::get()->logger->level;
        Config::get()->logger->level = 'DEBUG';

        $this->assertFalse(Logger::instance()->warning("Hello {who}", ['who' => 'World']));

        Config::get()->logger->level = $level;
    }

    public function testLogOmitByScribeLevel()
    {
        $level = Config::get()->logger->scribes[0]->level;
        Config::get()->logger->scribes[0]->level = 'DEBUG';

        Logger::instance()->initialize(true);

        $outcomes = Logger::instance()->warning("Hello {who}", ['who' => 'Nobody']);
        $this->assertFalse($outcomes[$this->_scribeNamespace]);

        Config::get()->logger->scribes[0]->level = $level;
        Logger::instance()->initialize(true);
    }
}