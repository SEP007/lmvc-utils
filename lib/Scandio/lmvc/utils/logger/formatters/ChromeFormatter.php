<?php

namespace Scandio\lmvc\utils\logger\formatters;

use Scandio\lmvc\utils\logger\traits;

/**
 * Class ChromeFormatter
 * @package Scandio\lmvc\utils\logger\formatters
 *
 * Formatter for logging with ChromePHP.
 */
class ChromeFormatter extends AbstractFormatter
{
    use traits\LoggerInterpolateTrait;

    public function format($message, $context = [])
    {
        
    }
}