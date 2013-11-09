<?php

namespace Scandio\lmvc\utils\logger\scribes;

use Scandio\lmvc\utils\config\Config;
use Scandio\lmvc\utils\logger\loggers\LogLevel;

/**
 * Class ChromeScribe
 * @package Scandio\lmvc\utils\logger\scribes
 *
 * File scribe writing log messages into file(s).
 */
class ChromeScribe extends AbstractScribe
{
    public function scribe($message, $context, $level)
    {
        return false;
    }

    /**
     * Initializes scribe and should always first initialize the parent (AbstractScribe).
     *
     * @param to $config passed from Logger
     */
    public function initialize($config)
    {
        # Call the parent
        parent::initialize($config);

        $this->setLevel($config->level);
    }
}