<?php

namespace Scandio\lmvc\modules\logger\scribes;

use Scandio\lmvc\modules\logger\loggers;
use Scandio\lmvc\modules\logger\interfaces;

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