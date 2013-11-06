<?php

namespace Scandio\lmvc\utils\logger\interfaces;

/**
 * Interface FormatterInterface
 * @package Scandio\lmvc\utils\logger\interfaces
 *
 * An interface for log formatters which all should be able
 * to format a log entry.
 */
interface FormatterInterface
{
    # To be implemented by concrete formatter to format $message within $context
    public function format($message, $context);
}