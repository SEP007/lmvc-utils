<?php

namespace Scandio\lmvc\utils\bootstrap;

/**
 * Class Butler
 * @package Scandio\lmvc\utils\bootstrap
 *
 * Manages bootstrap files and allows firing/executing them,
 * almost in a command/execute pattern.
 */
class Butler
{
    public static function initialize($namespaces)
    {
        $namespaces = (array) $namespaces;

        foreach ($namespaces as $namespace) {
            $bootstrap = $namespace . '\\Bootstrap';
            if (class_exists($bootstrap)) {
                $namespaceLoader = new $bootstrap;

                if($namespaceLoader instanceof BootstrapInterface) {
                    $namespaceLoader->initialize();
                }
            }
        }
    }
}