<?php

namespace Scandio\lmvc\utils\logger\scribes;

use Scandio\lmvc\utils\config\Config;
use Scandio\lmvc\utils\logger\loggers\LogLevel;

class FileScribe extends AbstractScribe
{
    private
        $_logPath       = null,
        $_logFile       = null,
        $_fileObject    = null;

    public function scribe($message, $context, $level)
    {
        if ( !$this->_omitMessage($level) ) {
            $levelName  = '[' . LogLevel::getLevelName($level) . ']';
            $date       = ':(' . date("H:i:s") . ')';
            $formatted  = $this->getFormatter()->format($message, $context);

            $logMessage = $levelName . $date . ' :: ' . $formatted;

            $this->_write($logMessage);
        }
    }

    private function _write($message)
    {
        $this->_fileObject->fwrite($message."\n");
    }

    private function _openStream()
    {
        try {
            $fileName = $this->_logPath . DIRECTORY_SEPARATOR . $this->_logFile;
            $this->_fileObject = new \SplFileObject($fileName, 'a+');
        } catch (\RuntimeException $ex) {
            trigger_error('Logger scribe ' . __CLASS__ . ' could not open its stream.', E_USER_WARNING);
        }
    }

    public function initialize($config)
    {
        parent::initialize($config);

        $this->_logPath = $this->_getLogPath(Config::get()->logger->logRoot, $config->path);
        $this->_logFile = date('d') . '.log';

        $this->setLevel($config->level);

        $this->_openStream();
    }

    private function _getLogPath($root, $scribe)
    {
        $year   = date('Y');
        $month  = date('F');

        $path   =
          $root . DIRECTORY_SEPARATOR . $scribe . DIRECTORY_SEPARATOR .
          $year . DIRECTORY_SEPARATOR . $month;

        if (!is_dir($path)) { mkdir($path, 0777, true); }

        return $path;
    }
}