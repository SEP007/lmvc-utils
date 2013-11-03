<?php

namespace Scandio\lmvc\utils\logger\scribes;

use Scandio\lmvc\utils\config\Config;

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

    public function initialize()
    {
        $config = Config::get()->logger;

        $this->_logPath = $config->logRoot . DIRECTORY_SEPARATOR . $config->scribes->file->path;
        $this->setLevel($config->scribes->file->level);

        $this->_openStream();
    }
}