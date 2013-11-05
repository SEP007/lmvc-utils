<?php

namespace Scandio\lmvc\utils\logger\scribes;

use Scandio\lmvc\utils\logger\loggers;
use Scandio\lmvc\utils\logger\interfaces;
use Scandio\lmvc\utils\logger\formatters;

abstract class AbstractScribe implements interfaces\ScribeInterface
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
        $this->level = is_integer($level) ? $level : loggers\LogLevel::getLevelConstant($level);
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function initialize($config)
    {
        $formatterInstance = new $config->formatter;

        if ($this->_isValidFormatter($formatterInstance)) {
            $this->_setFormatter($formatterInstance);
        } else {
            trigger_error('Tried to register invalid formatter scribe with namespace: ' . $config->formatter . ' falling back to NullFormatter!', E_USER_WARNING);

            $this->_setFormatter(new formatters\NullFormatter());
        }

        $this->setLevel($config->level);
    }

    protected function _omitMessage($level)
    {
        return loggers\LogLevel::bigger($level, $this->getLevel());
    }

    protected function formatLog($message, $context)
    {
        return $this->getFormatter()->format($message, $context);
    }

    private function _isValidFormatter($formatterInstance)
    {
        if($formatterInstance instanceof interfaces\FormatterInterface) {
            return true;
        }

        return false;
    }

    private function _setFormatter($formatter)
    {
        $this->formatter = $formatter;
    }
} 