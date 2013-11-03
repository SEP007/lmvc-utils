<?php

namespace Scandio\lmvc\utils\logger\scribes;

use Scandio\lmvc\utils\config\Config;

class FileScribe extends AbstractScribe
{
    private
        $_logPath       = null,
        $_logFile       = null,
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
            trigger_error('Logger scribe ' . __CLASS__ . ' could not open stream: ' . $this->_logPath . '.', E_USER_WARNING);
        }
    }

    public function initialize($config)
    {
        $this->_logPath = $this->_getLogPath(Config::get()->logger->logRoot, $config->path);
        $this->_logFile = $config->file;

        $this->setLevel($config->level);

        $this->_openStream();
    }

    private function _getLogPath($root, $scribe)
    {
        $year   = date('Y');
        $month  = date('F');
        $day    = date('d');

        return
          $root . DIRECTORY_SEPARATOR . $scribe . DIRECTORY_SEPARATOR .
          $year . DIRECTORY_SEPARATOR . $month . DIRECTORY_SEPARATOR . $day;
    }
}