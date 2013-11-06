<?php

namespace Scandio\lmvc\utils\logger\scribes;

use Scandio\lmvc\utils\config\Config;
use Scandio\lmvc\utils\logger\loggers\LogLevel;

/**
 * Class FileScribe
 * @package Scandio\lmvc\utils\logger\scribes
 *
 * File scribe writing log messages into file(s).
 */
class FileScribe extends AbstractScribe
{
    private
        $_logPath       = null,
        $_logFile       = null,
        $_fileObject    = null;

    /**
     * Scribes a message into the file if allowed by configured log level.
     *
     * @param $message to be logged
     * @param $context to possibly be interpolated into the $message
     * @param $level under which $message should be logged
     *
     * @return bool|void outcome depending on fwrites outcome
     */
    public function scribe($message, $context, $level)
    {
        if ( !$this->_omitMessage($level) ) {
            # //TODO: Should be replaced with dynamic format string in config
            $levelName  = '[' . LogLevel::getLevelName($level) . ']';
            $date       = ':(' . date("H:i:s") . ')';
            $formatted  = $this->getFormatter()->format($message, $context);

            $logMessage = $levelName . $date . ' :: ' . $formatted;

            # Call internal write function
            return $this->_write($logMessage);
        }

        return false;
    }

    /**
     * Writes line into $_fileObject.
     *
     * @param $message to be logged
     * @return mixed return of fwrite
     */
    private function _write($message)
    {
        return $this->_fileObject->fwrite($message."\n");
    }

    /**
     * Opens the the stream (SplFileObject) to be written into later so
     * stream is open for possibly more calls and is not reopened.
     */
    private function _openStream()
    {
        try {
            # Generates the complete filePath
            $fileName = $this->_logPath . DIRECTORY_SEPARATOR . $this->_logFile;
            $this->_fileObject = new \SplFileObject($fileName, 'a+');
        } catch (\RuntimeException $ex) {
            # File/stream could not be opened
            trigger_error('Logger scribe ' . __CLASS__ . ' could not open its stream.', E_USER_WARNING);
        }
    }

    /**
     * Initializes scribe and should always first initialize the parent (AbstractScribe).
     *
     * @param to $config passed from Logger
     */
    public function initialize($config)
    {
        # Call the parent
        parent::initialize($config);

        # Setup the logPath and logFile name
        $this->_logPath = $this->_getLogPath(Config::get()->logger->logRoot, $config->path);
        $this->_logFile = date('d') . '.log';

        $this->setLevel($config->level);

        $this->_openStream();
    }

    /**
     * Helper function giving the log path based on the log root and the
     * scribe's log path.w
     *
     * @param $root to log fiels
     * @param $scribe s path to logfiles
     *
     * @return string path to which logs will be written
     */
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