<?php

namespace Scandio\lmvc\utils\logger\loggers;

use Scandio\lmvc\utils\config\Config;

/**
 * Class LogLevel
 * @package Scandio\lmvc\utils\logger\loggers
 *
 * Describes all possible log levels of logger and encapsulates related behavior.
 */
class LogLevel
{
    const DEBUG     = 100;
    const INFO      = 200;
    const NOTICE    = 250;
    const WARNING   = 300;
    const WARN      = 300;
    const EMERGENCY = 350;
    const ALERT     = 400;
    const CRITICAL  = 450;
    const ERROR     = 500;

    protected static $levelNames = [
        100 => 'DEBUG',
        200 => 'INFO',
        250 => 'NOTICE',
        300 => 'WARNING',
        350 => 'EMERGENCY',
        400 => 'ALERT',
        450 => 'CRITICAL',
        500 => 'ERROR'
    ];

    /**
     * Returns a log level string identifier by a given integer representation.
     *
     * If integer is not a log level, it will return 'UNDEFINED' as log level name.
     *
     * @param $level integer representing the log level
     * @return string represents the log level as a string
     */
    public static function getLevelName($level)
    {
        # Checks for existence of $level integer and returns it accordingly
        return isset( static::$levelNames[$level] ) ? static::$levelNames[$level] : 'UNDEFINED';
    }

    /**
     * Takes a log level string and returns if logging should happen according to config value.
     *
     * For this, the string (config and given) will be transformed into level constant which is an
     * integer which two will then be compared.
     *
     * @param $level to be checked if its bigger or equals compared to the config level
     * @return bool indicating if logging should be performed
     */
    public static function bigger($level, $config = null)
    {
        $level  = is_integer($level) ? $level : static::getLevelConstant($level);
        $config = is_integer($config) ? $config : static::getLevelConstant(Config::get()->logger->level);

        return ($level >= $config);
    }

    /**
     * Gives the constant representation by a log level's string representation.
     *
     * Note: Returns INT_MAX_VALUE if level is not defined to fallback to logging everything in that case.
     *
     * @param $level string representation of log level
     * @return int|mixed the constant associated with the level's string representation
     */
    public static function getLevelConstant($level)
    {
        # The function needs a string
        if (!is_string($level)) { return PHP_INT_MAX; }

        # Generates the identifier for the constant
        $levelIdentifier = __CLASS__.'::'.strtoupper($level);

        # Returns it when its defined otherwise falls back again to INT_MAX_VALUE
        if ( defined($levelIdentifier) ) {
            return constant($levelIdentifier);
        } else {
            return PHP_INT_MAX;
        }
    }
}