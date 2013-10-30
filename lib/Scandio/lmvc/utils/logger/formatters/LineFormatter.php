<?php

namespace Scandio\lmvc\modules\logger\formatters;

use Scandio\lmvc\modules\logger\traits;

/**
 * Class FileLogFormatter
 * @package Scandio\lmvc\modules\logger\formatters
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
     *
     * @param array $entry
     * @return string
     */
    public function format($message, $context)
    {
        return $this->_interpolate($message, $context);
    }
}