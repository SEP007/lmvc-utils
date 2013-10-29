<?php

namespace Scandio\lmvc\modules\logger\loggers;

/**
 * Class LogLevel
 * @package Scandio\lmvc\modules\logger\loggers
 *
 * Describes all possible log levels of logger.
 */
class LogLevel
{
    const EMERGENCY = 'emergency';
    const ALERT     = 'alert';
    const CRITICAL  = 'critical';
    const ERROR     = 'error';
    const WARNING   = 'warning';
    const NOTICE    = 'notice';
    const INFO      = 'info';
    const DEBUG     = 'debug';
}