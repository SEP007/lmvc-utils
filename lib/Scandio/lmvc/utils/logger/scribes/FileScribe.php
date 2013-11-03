<?php

namespace Scandio\lmvc\utils\logger\scribes;

class FileScribe extends AbstractScribe
{
    private
        $_logPath       = null,
        $_fileObject    = null;

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
        $this->_fileObject->fwrite($message);
    }

    private function _openStream()
    {
        try {
            $this->_fileObject = new \SplFileObject($this->_logPath, 'a');
        } catch (\RuntimeException $ex) {
            trigger_error('Logger scribe ' . __CLASS__ . ' could not open stream: ' . $this->_logPath . '.', E_WARNING);
        }

    }

    public function initialize($config)
    {
        $this->_logPath = $config->path;
        $this->setLevel($config->level);

        $this->_openStream();
    }
}