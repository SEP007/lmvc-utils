<?php

namespace Scandio\lmvc\utils\logger;

use Scandio\lmvc\utils\config\Config;
use Scandio\lmvc\utils\logger\interfaces;
use Scandio\lmvc\utils\logger\loggers\LogLevel;
use Scandio\lmvc\traits;

/**
 * Class Logger
 * @package Scandio\lmvc\modules\logger
 *
 * Main logger implementing NullLogger (not needed) but safety fallback.
 */
class Logger extends loggers\NullLogger
{
    use traits\Singleton;

    protected
        $scribes = [];

    public function initialize()
    {
        $scribes = (array) Config::get()->logger->scribes;

        foreach ($scribes as $scribe) {
            $this->addScribe($scribe);
        }
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return null
     */
    public function log($level, $message, array $context = array())
    {
        # Global log level, no scribe should overwrite this. So don't call function on them
        if ( LogLevel::bigger($level) ) { return false; }

        foreach ($this->scribes as $scribe) {
            $scribe->scribe($message, $context, $level);
        }
    }

    /**
     * Adds a scribe to the logger.
     *
     * @param $namespace of scribe used to instantiate it in the process
     * @return bool indicating if adding scribe was successful
     */
    public function addScribe($namespace)
    {
        $scribeInstance = new $namespace;

        if ( $this->_isValidScribe($scribeInstance) ) {
            if (!array_key_exists($namespace, $this->scribes)) {
                $scribeInstance->initialize();

                $this->scribes[$namespace] = $scribeInstance;

                return true;
            }
        } else {
            trigger_error(E_WARNING, 'Tried to register invalid logger scribe with namespace: ' . $namespace);
        }

        return false;
    }

    /**
     * Removes a scribe by namespace (fully qualified to class).
     *
     * @param $namespace of scribe to be removed
     * @return bool indicating if removing scribe was successful
     */
    public function removeScribe($namespace)
    {
        if (array_key_exists($namespace, $this->scribes)) {
            unset($this->scribes[$namespace]);

            return true;
        } else { return false; }
    }

    /**
     * Checks if a given instance of a scribe implements the defined interface
     *
     * @param $scribeInstance instance of scribe to check
     * @return bool indicating of scribe is indeed coded against the interface spec
     */
    private function _isValidScribe($scribeInstance)
    {
        if($scribeInstance instanceof interfaces\ScribeInterface) {
            return true;
        }

        return false;
    }
} 