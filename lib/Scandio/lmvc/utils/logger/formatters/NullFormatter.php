<?php

namespace Scandio\lmvc\utils\logger\formatters;

use Scandio\lmvc\utils\logger\traits;

/**
 * Class FileLogFormatter
 * @package Scandio\lmvc\utils\logger\formatters
 *
 * NullFormatter which prevents just concats $message and the $context.
 */
class NullFormatter extends AbstractFormatter
{
    public function format($message, $context)
    {
        return $message . $context;
    }
}