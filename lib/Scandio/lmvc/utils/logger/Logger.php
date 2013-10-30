<?php

namespace Scandio\lmvc\utils\logger;

/**
 * Class Logger
 * @package Scandio\lmvc\modules\logger
 *
 * Main logger implementing NullLogger (not needed) but safety fallback.
 */
class Logger extends loggers\NullLogger
{
    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return null
     */
    public function log($level, $message, array $context = array())
    {

    }
} 