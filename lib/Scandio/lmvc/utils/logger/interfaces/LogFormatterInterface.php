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
    /**
     * Function formatting a log $entry
     *
     * @param  array $entry to be formatted
     *
     * @return mixed The formatted record
     */
    public function format($entry);
}