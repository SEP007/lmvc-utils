<?php

namespace Scandio\lmvc\utils\logger\scribes;

use Scandio\lmvc\utils\logger\loggers;
use Scandio\lmvc\utils\logger\interfaces;
use Scandio\lmvc\utils\logger\formatters;

/**
 * Class AbstractScribe
 * @package Scandio\lmvc\utils\logger\scribes
 *
 * Collects common functionalities within every scribe.
 */
abstract class AbstractScribe implements interfaces\ScribeInterface
{
    protected
      $level        = loggers\LogLevel::INFO,
      $formatter    = null;

    # Will be passed on the more concrete scribe
    abstract public function scribe($message, $context, $level);

    /*
     * Returns the scribe's formatter
     */
    public function getFormatter()
    {
        return $this->formatter;
    }

    /**
     * Sets a log level given as integer or string as a constant defined in LogLevel
     *
     * @param $level to be set
     */
    public function setLevel($level)
    {
        $this->level = is_integer($level) ? $level : loggers\LogLevel::getLevelConstant($level);
    }

    /**
     * Gets the log level of the scribe
     *
     * @return int|string the current log level
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Initializes a scribe with a given $config array. This e.g. set and create the
     * formatter instance and set the level.
     *
     * @param $config to be used during intialization
     */
    public function initialize($config)
    {
        $formatterInstance = new $config->formatter;

        # No valid formatter should be set on scribe
        if ($this->_isValidFormatter($formatterInstance)) {
            $this->_setFormatter($formatterInstance);
        } else {
            # Let user know...
            trigger_error('Tried to register invalid formatter scribe with namespace: ' . $config->formatter . ' falling back to NullFormatter!', E_USER_WARNING);

            # ... and fall back to NullFormatter
            $this->_setFormatter(new formatters\NullFormatter());
        }

        $this->setLevel($config->level);
    }

    /**
     * Determines if a call to a scribe() on a scribe can be omitted by its local level.
     *
     * @param $level the level
     * @return bool indicating if message can be omitted
     */
    protected function _omitMessage($level)
    {
        return loggers\LogLevel::bigger($level, $this->getLevel());
    }

    /**
     * Formats and interpolates a $message with the given $context.
     *
     * @param $message to be formatted
     * @param $context context related to be $message
     * @return mixed the formatters return value
     */
    protected function formatLog($message, $context)
    {
        return $this->getFormatter()->format($message, $context);
    }

    /**
     * Checks if a formatter is a valid formatter by checking against the interface spec.
     *
     * @param $formatterInstance to be checked against interface
     * @return bool indicating outcome
     */
    private function _isValidFormatter($formatterInstance)
    {
        if($formatterInstance instanceof interfaces\FormatterInterface) {
            return true;
        }

        return false;
    }

    private function _setFormatter($formatter)
    {
        $this->formatter = $formatter;
    }
} 