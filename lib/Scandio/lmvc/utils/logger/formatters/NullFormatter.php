<?php

namespace Scandio\lmvc\utils\logger\formatters;

use Scandio\lmvc\utils\logger\traits;

/**
 * Class FileLogFormatter
 * @package Scandio\lmvc\utils\logger\formatters
 *
 * Formatter for logging into files.
 */
class NullFormatter extends AbstractFormatter
{
    public function format($message, $context)
    {
        return $message . $context;
    }
}