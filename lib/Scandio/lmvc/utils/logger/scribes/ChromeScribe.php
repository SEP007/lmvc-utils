<?php

namespace Scandio\lmvc\utils\logger\scribes;

use Scandio\lmvc\utils\config\Config;
use Scandio\lmvc\utils\logger\loggers\LogLevel;

/**
 * Class ChromeScribe
 * @package Scandio\lmvc\utils\logger\scribes
 *
 * File scribe writing log messages into file(s).
 */
class ChromeScribe extends AbstractScribe
{
    private
        $_version           = null,
        $_headersAccepted   = false,
        $_initialized       = false,
        $_headername        = null,
        $_response          = null;

    /**
     * Initializes scribe and should always first initialize the parent (AbstractScribe).
     *
     * @param to $config passed from Logger
     */
    public function initialize($config)
    {
        # Call the parent
        parent::initialize($config);

        $this->setLevel($config->level);
        $this->_headername = $config->headername;
        $this->_version = $config->version;

        $this->_flushResponse();
    }

    public function scribe($message, $context, $level)
    {
        if ( !$this->_omitMessage($level) ) {
            $this->getFormatter()->setLevel($level);

            $this->_response['rows'][] = $this->getFormatter()->format($message, $context);

            $this->_process();

            return true;
        }

        return false;
    }

    private function _process()
    {
        if ($this->_initialized !== true) {
            $this->_headersAccepted = $this->_acceptedByHeaders();
            $this->_response['request_uri'] = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';

            $this->_initialized = true;
        }

        $json = @json_encode($this->_response);
        $data = base64_encode(utf8_encode($json));

        $this->_sendWithHeaders($data);
    }

    private function _flushResponse()
    {
        $this->_response = [
            'version'   => $this->_version,
            'columns'   => ['label', 'log', 'backtrace', 'type'],
            'rows'      => [],
        ];
    }

    private function _acceptedByHeaders()
    {
        return !isset($_SERVER['HTTP_USER_AGENT']) || preg_match('{\bChrome/\d+[\.\d+]*\b}', $_SERVER['HTTP_USER_AGENT']);
    }

    private function _sendWithHeaders($data)
    {
        if ($this->_headersAccepted === true) {
            header(sprintf('%s: %s', $this->_headername, $data));
        }
    }
}