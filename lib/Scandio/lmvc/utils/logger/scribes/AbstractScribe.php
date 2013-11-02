<?php

namespace Scandio\lmvc\utils\logger\scribes;

use Scandio\lmvc\utils\logger\loggers;
use Scandio\lmvc\utils\logger\interfaces;

abstract class AbstractScribe implements interfaces\ScribeInterface
{
    protected
      $level        = loggers\LogLevel::INFO,
      $formatter    = null;

    abstract public function scribe($message, $context, $level);
    abstract public function initialize($config);

    public function getFormatter()
    {
        return $this->formatter;
    }

    public function setLevel($level)
    {
        $this->level = $level;
    }

    public function getLevel()
    {
        return $this->level;
    }

    protected function _omitMessage($level)
    {
        return loggers\LogLevel::bigger($level, $this->getLevel());
    }

    protected function formatLog($message, $context)
    {
        return $this->getFormatter()->format($message, $context);
    }
} 