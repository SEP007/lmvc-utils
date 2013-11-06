<?php

namespace Scandio\lmvc\utils\bootstrap;

/**
 * Class Bootstrap
 * @package Scandio\lmvc\utils\bootstrap
 */
abstract class Bootstrap implements BootstrapInterface
{
    /**
     * Will be called by Butler whenever a namespace under which
     * this boostrap resides shall be initialized.
     *
     * @return void
     */
    public abstract function initialize();

    /**
     * Returns the the namespace of the Boostrap being called.
     *
     * @return string
     */
    public static function getNamespace()
    {
        $reflector = new \ReflectionClass(get_called_class());
        return $reflector->getNamespaceName();
    }

    /**
     * Returns the path of the Bootstrap at hand.
     *
     * @return string
     */
    public static function getPath()
    {
        $reflector = new \ReflectionClass(get_called_class());
        return dirname($reflector->getFileName());
    }
}