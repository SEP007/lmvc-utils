<?php

namespace Scandio\lmvc\utils\traits;

/**
 * Class Singleton
 *
 * Singleton trait allowing to continue using __construct.
 */
trait Singleton
{
    # The instance
    private static $instance;

    public static function instance()
    {
        if (!isset(self::$instance)) {
            $reflection     = new \ReflectionClass(__CLASS__);
            self::$instance = $reflection->newInstanceArgs(func_get_args());
        }

        return self::$instance;
    }

    final private function __clone() {
        # Not allowed, possible
    }

    final private function __wakeup() {
        # Not allowed, possible
    }
}