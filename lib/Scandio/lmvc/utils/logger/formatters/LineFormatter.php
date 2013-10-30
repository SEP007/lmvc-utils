<?php

namespace Scandio\lmvc\modules\logger\formatters;

/**
 * Class FileLogFormatter
 * @package Scandio\lmvc\modules\logger\formatters
 *
 * Formatter for logging into files.
 */
class LineFormatter extends AbstractFormatter
{
    /**
     * Formats a a log request into a single line.
     *
     * TODO:
     *  - Should have a configurable log-format-string int LVCConfig
     *
     * @param array $entry
     * @return string
     */
    public function format($entry)
    {
        $normalized = parent::normalize($entry);

        $logString =
          '[' . date("m.d.y - H:i:s") . ']' .
          ' (' . $normalized['type'] . ')' .
          ' : ' . $normalized[ $this->toJson($normalized['payload']) ] .
          ' - ' . $this->toJson( $normalized['extra'] );

        return $logString;
    }
}