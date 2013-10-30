<?php

namespace Scandio\lmvc\utils\logger\scribes;

use Scandio\lmvc\utils\logger\loggers;
use Scandio\lmvc\utils\logger\interfaces;

class AbstractScribe implements interfaces\ScribeInterface
{
    protected
      $level        = loggers\LogLevel::INFO,
      $formatter    = null;

    abstract public function scribe($message, $context, $level);

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

    protected function _omitMessage()
    {
        return false;
    }
} 