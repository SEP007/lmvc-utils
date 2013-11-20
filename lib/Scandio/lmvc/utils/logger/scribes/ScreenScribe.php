<?php

namespace Scandio\lmvc\utils\logger\scribes;

use Scandio\lmvc\utils\config\Config;
use Scandio\lmvc\utils\logger\loggers\LogLevel;

/**
 * Class ScreenScribe
 * @package Scandio\lmvc\utils\logger\scribes
 *
 * Screen scribe logging into the browser's window.
 */
class ScreenScribe extends AbstractScribe
{
    /**
     * Scribes a message onto the screen if allowed by configured log level.
     *
     * @param $message to be logged
     * @param $context to possibly be interpolated into the $message
     * @param $level under which $message should be logged
     *
     * @return bool outcome depending on scribe's log level
     */
    public function scribe($message, $context, $level)
    {
        if ( !$this->_omitMessage($level) ) {
            $formatted  = $this->getFormatter()->format($message, $context);

            ob_start();
            echo $formatted;
            ob_end_clean();

            return true;
        }

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