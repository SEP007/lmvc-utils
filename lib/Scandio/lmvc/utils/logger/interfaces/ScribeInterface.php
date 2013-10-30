<?php

namespace Scandio\lmvc\modules\logger\interfaces;

/**
 * Interface ScribeInterface
 * @package Scandio\lmvc\modules\logger\interfaces
 *
 * Interface which every scribe (a worker for a logger) should implement.
 */
interface ScribeInterface
{
    public function scribe($message, $context, $level);

    public function getFormatter();
    public function setLevel($level);
    public function getLevel();
}