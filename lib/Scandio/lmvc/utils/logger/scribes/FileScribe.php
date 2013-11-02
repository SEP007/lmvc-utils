<?php

namespace Scandio\lmvc\utils\logger\scribes;

class FileScribe extends AbstractScribe
{
    private
        $_logPath = null;

    public function scribe($message, $context, $level)
    {
        if ( !$this->_omitMessage($level) ) {
            $this->_write(
                $this->getFormatter()->format($message, $context)
            );
        }
    }

    private function _write($message)
    {

    }

    public function initialize($config)
    {
        $this->_logPath = $config->path;
        $this->setLevel($config->level);
    }
}