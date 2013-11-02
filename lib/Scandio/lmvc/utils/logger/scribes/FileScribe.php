<?php

namespace Scandio\lmvc\utils\logger\scribes;

class FileScribe extends AbstractScribe
{
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
}