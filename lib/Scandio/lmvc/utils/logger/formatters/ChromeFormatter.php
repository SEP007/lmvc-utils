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

    public function format($message, $context = [])
    {
        $backtrace = 'UNKNOWN';

        $normalizedContext = [];

        foreach($context as $key => $unnormalized) {
            $normalizedContext[$key] = $this->toJson($this->normalize($unnormalized));
        }

        $message = $this->_interpolate($message, $normalizedContext);

        return [
            $message,
            $backtrace,
            $this->logLevels[$this->_level],
        ];
    }

    public function setLevel($level)
    {
        $this->_level = $level;
    }
}