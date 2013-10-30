<?php

namespace Scandio\lmvc\modules\logger\interfaces;

/**
 * Interface FormatterInterface
 * @package Scandio\lmvc\modules\logger\interfaces
 *
 * An interface for log formatters which all should be able
 * to format a log entry.
 */
interface FormatterInterface
{
    public function format($message, $context);
}