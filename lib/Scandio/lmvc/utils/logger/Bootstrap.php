<?php

namespace Scandio\lmvc\utils\logger;

use Scandio\lmvc\utils\config\Config;

class Bootstrap extends \Scandio\lmvc\utils\bootstrap\Bootstrap
{
    # Should/Must be called from app's Bootstrap as its the file one
    # knowing the app's root path.
    public static function configure($logRootDirectory = null)
    {
        # Read default config
        #Config::initialize(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.json');

        # Only set the log root directory if really given as parameter
        if ($logRootDirectory !== null) { Config::get()->logger->logRoot = $logRootDirectory; }

        # Intialize the logger
        Logger::instance()->initialize();
    }

    public function initialize()
    {

    }
}