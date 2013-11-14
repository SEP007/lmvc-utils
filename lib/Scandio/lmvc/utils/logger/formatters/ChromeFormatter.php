<?php

namespace Scandio\lmvc\utils\logger\formatters;

use Scandio\lmvc\utils\logger\traits;
use Scandio\lmvc\utils\logger\loggers\LogLevel;

/**
 * Class ChromeFormatter
 * @package Scandio\lmvc\utils\logger\formatters
 *
 * Formatter for logging with ChromePHP.
 */
class ChromeFormatter extends AbstractFormatter
{
    use traits\LoggerInterpolateTrait;

    # Transformed level strings in DevTool's console
    private $_logLevels = [
        LogLevel::DEBUG     => 'log',
        LogLevel::INFO      => 'info',
        LogLevel::NOTICE    => 'info',
        LogLevel::WARNING   => 'warn',
        LogLevel::ERROR     => 'error',
        LogLevel::CRITICAL  => 'error',
        LogLevel::ALERT     => 'error',
        LogLevel::EMERGENCY => 'error'
    ];

    private
      $_level = null;

    /**
     * Formats a message for the ChromeScribe by normalizing, interpolating
     * it and returning it as an array which correspond to the logger's
     * rows.
     *
     * @param $message to be formatted, may contain placeholders as its to be interpolated
     * @param array $context the variables interpolated into the $message
     *
     * @return array containing rows for ChromeScribe in [lvel, message, backtrace, null]
     */
    public function format($message, $context = [])
    {
        $backtrace = 'UNKNOWN';

        # Normalizes everything in the context
        $normalizedContext = [];
        foreach($context as $key => $unnormalized) {
            $normalizedContext[$key] = $this->toJson($this->normalize($unnormalized));
        }

        # Interpolates the message with the previously normalized context
        $message = $this->_interpolate($message, $normalizedContext, true);

        # Returns an array of columns for the logger
        return [
            isset($this->_logLevels[ $this->_level ]) ?
              $this->_logLevels[ $this->_level ] :
              $this->_level,
            $message,
            $backtrace,
            null
        ];
    }

    /**
     * Sets the log level on this formatter as it needs to know for the format-fn's response.
     *
     * @param $level to be set on instance variable
     */
    public function setLevel($level)
    {
        $this->_level = $level;
    }
}