<?php

namespace Scandio\lmvc\utils\logger\interfaces;

/**
 * Interface ScribeInterface
 * @package Scandio\lmvc\utils\logger\interfaces
 *
 * Interface which every scribe (a worker for a logger) should implement.
 */
interface ScribeInterface
{
    # The scribe's function being called from the Logger upon logging request
    public function scribe($message, $context, $level);

    # A set of functions all implemented in the AbstractScribe as they mostly won't differ
    public function initialize($config);
    public function getFormatter();
    public function setLevel($level);
    public function getLevel();
}