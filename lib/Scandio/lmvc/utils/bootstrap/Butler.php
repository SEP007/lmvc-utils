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
    /**
     * Initialized a set of bootstraps by calling their init-fn
     * by passing in an array of namespaces under which bootstraps reside.
     *
     * @param array|string $namespaces for which bootstraps should be called
     * @return array of instances containing bootstrap-classes
     */
    public static function initialize($namespaces)
    {
        $namespaces     = (array) $namespaces;
        $bootstrapped   = [];

        foreach ($namespaces as $namespace) {
            $bootstrap = $namespace . '\\Bootstrap';

            if (class_exists($bootstrap)) {
                $namespaceLoader = new $bootstrap;

                if($namespaceLoader instanceof BootstrapInterface) {
                    $bootstrapped[] = $namespaceLoader;

                    $namespaceLoader->initialize();
                }
            }
        }

        return $bootstrapped;
    }
}