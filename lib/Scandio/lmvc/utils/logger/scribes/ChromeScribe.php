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

        # Sets level, headername and version of client side
        $this->setLevel($config->level);
        $this->_headername = $config->headername;
        $this->_version = $config->version;

        # Empty the response to get a fresh start
        $this->_flushResponse();
    }

    public function scribe($message, $context, $level)
    {
        if ( !$this->_omitMessage($level) ) {
            $this->getFormatter()->setLevel($level);

            # Add the formatted log to the response's rows
            $this->_response['rows'][] = $this->getFormatter()->format($message, $context);

            # ... do some additional work
            $this->_process();

            return true;
        }

        return false;
    }

    public function getResponse()
    {
        return $this->_response;
    }

    private function _process()
    {
        if ($this->_initialized !== true) {
            # Needed for client side: headers and request_uri
            $this->_headersAccepted = $this->_acceptedByHeaders();
            $this->_response['request_uri'] = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';

            $this->_initialized = true;
        }

        # Quietly encode the response to json
        $json = @json_encode($this->_response);
        # Base64 encoding them too
        $data = base64_encode(utf8_encode($json));

        # Now send data with headers
        $this->_sendWithHeaders($data);
    }

    private function _flushResponse()
    {
        # Setup empty structure (to be jsonified and base64 encoded)
        $this->_response = [
            'version'   => $this->_version,
            'columns'   => ['label', 'log', 'backtrace', 'type'],
            'rows'      => [],
        ];
    }

    private function _acceptedByHeaders()
    {
        # Only set work when browser is chrome
        return !isset($_SERVER['HTTP_USER_AGENT']) || preg_match('{\bChrome/\d+[\.\d+]*\b}', $_SERVER['HTTP_USER_AGENT']);
    }

    private function _sendWithHeaders($data)
    {
        # As headers can be not accepted (browser not chrome) this is a noop
        if (!headers_sent() && $this->_headersAccepted === true) {
            header(sprintf('%s: %s', $this->_headername, $data));
        }
    }
}