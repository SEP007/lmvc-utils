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
        # Make $namespaces and array if passed as string
        $namespaces     = (array) $namespaces;
        $bootstrapped   = [];

        foreach ($namespaces as $namespace) {
            $bootstrap = $namespace . '\\Bootstrap';

            # Only if its a class which exists
            if (class_exists($bootstrap)) {
                $namespaceLoader = new $bootstrap;

                # ... and it implements the interface
                if($namespaceLoader instanceof BootstrapInterface) {
                    $bootstrapped[] = $namespaceLoader;

                    # ... call initialize on the Bootstrap
                    $namespaceLoader->initialize();
                }
            }
        }

        return $bootstrapped;
    }
}