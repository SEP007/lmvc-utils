<?php

namespace Scandio\lmvc\utils\logger\formatters;

use Scandio\lmvc\utils\logger\traits;

/**
 * Class FileLogFormatter
 * @package Scandio\lmvc\utils\logger\formatters
 *
 * Formatter for logging into files.
 */
class LineFormatter extends AbstractFormatter
{
    use traits\LoggerInterpolateTrait;

    /**
     * Formats a a log request into a single line.
     *
     * TODO:
     *  - Should have a configurable log-format-string int LVCConfig
     */
    public function format($message, $context = [])
    {
        $normalizedContext = [];

        foreach($context as $key => $unnormalized) {
            $normalizedContext[$key] = $this->toJson($this->normalize($unnormalized));
        }

        return $this->_interpolate($message, $normalizedContext);
    }
}