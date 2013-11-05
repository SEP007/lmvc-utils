<?php

use Scandio\lmvc\utils\logger\Logger;
use Scandio\lmvc\utils\config\Config;

class TestLogger extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->_rootPath    = dirname(__FILE__) . DIRECTORY_SEPARATOR;

        Config::initialize($this->_rootPath . 'config.json');
        Config::get()->logger->logRoot = dirname($this->_rootPath) . DIRECTORY_SEPARATOR . 'logs';

        Logger::instance()->initialize();
    }

    public function testInfoLog()
    {

    }
}