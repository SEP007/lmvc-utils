<?php

namespace Scandio\lmvc\modules\logger\traits;

/**
 * Basic Implementation of LoggerAwareInterface
 * not needed as trait will be mixed into most loggers.
 */
trait LoggerInterpolateTrait
{
    /**
     * Interpolates context values into the message placeholders.
     */
    public function interpolate($message, array $context = array())
    {
        // build a replacement array with braces around the context keys
        $replace = array();
        foreach ($context as $key => $val) {
            $replace['{' . $key . '}'] = $val;
        }

        // interpolate replacement values into the message and return
        return strtr($message, $replace);
    }
}