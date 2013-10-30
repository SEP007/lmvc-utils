<?php

namespace Scandio\lmvc\utils\logger;

use Scandio\lmvc\utils\config\Config;

class Bootstrap extends \Scandio\lmvc\utils\bootstrap\Bootstrap
{
    public static function configure()
    {
        Config::initialize(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.json');
    }

    public function initialize()
    {
        $this->configure();
    }
}