<?php

namespace Scandio\lmvc\utils\logger\traits;

/**
 * Basic Implementation of LoggerAwareInterface
 * not needed as trait will be mixed into most loggers.
 */
trait LoggerInterpolateTrait
{
    /**
     * Interpolates context values into the message placeholders.
     */
    private function _interpolate($message, array $context = [])
    {
        // build a replacement array with braces around the context keys
        $replace = [];
        $message = (string) $message;

        foreach ($context as $key => $val) {
            $replace['{' . $key . '}'] = $val;
        }

        // interpolate replacement values into the message and return
        return strtr($message, $replace);
    }

    /**
     * Interpolate a message with a context but returns the interpolated
     * sub-parts as an array.
     */
    private function _interpolateAsArray($message, array $context = [])
    {
        // build a replacement array with braces around the context keys
        $replace  = [];
        $matches  = [];
        $messages = [];
        $response = [];

        preg_match_all('/\{([^}]*)\}/', $message, $matches);

        foreach ($matches[0] as $match) {
            $messages[] = $match;
        }

        foreach ($context as $key => $val) {
            $replace['{' . $key . '}'] = $val;
        }

        foreach ($messages as $submessage) {
            $response[] = strstr($submessage, $replace);
        }

        // interpolate replacement values into the message and return
        return $response;
    }
}