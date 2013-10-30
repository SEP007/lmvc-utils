<?php

namespace Scandio\lmvc\modules\logger\scribes;

class FileScribe extends AbstractScribe
{
    public function scribe($message, $context, $level)
    {
        if ( !$this->_omitMessage() ) {
            $this->_write(
                $this->getFormatter()->format($message, $context)
            );
        }
    }

    private function _write($message)
    {

    }
}