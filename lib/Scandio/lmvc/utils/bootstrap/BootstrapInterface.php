<?php

namespace Scandio\lmvc\utils\bootstrap;

/**
 * Interface BootstrapInterface
 * @package Scandio\lmvc\utils\bootstrap
 */
interface BootstrapInterface
{
    /**
     * @return void
     */
    public function initialize();

    /**
     * @return string
     */
    public static function getNamespace();

    /**
     * @return string
     */
    public static function getPath();

} 