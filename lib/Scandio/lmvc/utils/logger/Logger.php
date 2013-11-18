<?php

namespace Scandio\lmvc\utils\logger;

use Scandio\lmvc\utils\config\Config;
use Scandio\lmvc\utils\logger\interfaces;
use Scandio\lmvc\utils\logger\loggers\LogLevel;
use Scandio\lmvc\utils\traits;

/**
 * Class Logger
 * @package Scandio\lmvc\modules\logger
 *
 * Main logger implementing NullLogger (not needed) but safety fallback.
 */
class Logger extends loggers\AbstractLogger
{
    use traits\Singleton;

    protected
        $scribes = [];

    /**
     * Initializes the logger setting e.g. up the scribes.
     *
     * @param bool $reinitialize if true reinitialization will be performed
     */
    public function initialize($reinitialize = false)
    {
        if ($reinitialize === true) { $this->scribes = []; }

        $scribes = (array) Config::get()->logger->scribes;

        foreach ($scribes as $scribe) {
            $this->addScribe($scribe->namespace, $scribe);
        }
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level int or string which to be logged
     * @param string $message to be logged
     * @param array $context to possibly be interpolated into message
     *
     * @return array the outcome of every single scribe
     */
    public function log($level, $message, array $context = array())
    {
        # Global log level, no scribe should overwrite this. So don't call function on them
        if ( !LogLevel::bigger($level) ) { return false; }

        $outcomes = [];

        # Call on every registered scribe
        foreach ($this->scribes as $scribe) {
            $outcomes[get_class($scribe)] = $scribe->scribe($message, $context, $level);
        }

        return $outcomes;
    }

    /**
     * Adds a scribe to the logger.
     *
     * @param $namespace of scribe used to instantiate it in the process
     * @param @config to be passed into scribe's initialization
     * @return bool indicating if adding scribe was successful
     */
    public function addScribe($namespace, $config)
    {
        $scribeInstance = new $namespace;

        # Only add valid scribes
        if ( $this->_isValidScribe($scribeInstance) ) {
            # ... if not already added
            if (!array_key_exists($namespace, $this->scribes)) {
                $scribeInstance->initialize($config);

                $this->scribes[$namespace] = $scribeInstance;

                return true;
            }
        } else {
            trigger_error('Tried to register invalid logger scribe with namespace: ' . $namespace, E_USER_WARNING);
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
        # Only try removal if key/namespace is registered
        if (array_key_exists($namespace, $this->scribes)) {
            # unsets the scribe by its namespace
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
        # Check given $scribeInstance against namespace
        if($scribeInstance instanceof interfaces\ScribeInterface) {
            return true;
        }

        return false;
    }
} 