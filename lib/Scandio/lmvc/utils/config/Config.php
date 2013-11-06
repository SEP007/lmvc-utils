<?php

namespace Scandio\lmvc\utils\config;

/**
 * Class Config
 * @package Scandio\lmvc\utils\config;
 */
class Config
{

    /**
     * @var array default configuration to use if a property was not provided
     */
    private static $config = array(
        'appPath' => './',
        'controllers' => array('controllers'),
        'controllerPath' => array(),
        'views' => array('./views/'),
        'viewPath' => array(),
        'modules' => array()
    );

    /**
     * returns the instance of the singleton object
     * use it like Config::get() from outside
     *
     * @static
     * @return object
     */
    public static function get()
    {
        return (object) self::$config;
    }

    /**
     * Merges default configuration of with a json config file
     *
     * @param string|null $configFile path and file name of a valid json config file
     * @param bool $overwrite indicates if newly read values should replace existing ones
     */
    public static function initialize($configFile = null, $overwrite = false)
    {
        if (!is_null($configFile) && file_exists($configFile)) {
            $toBeMerged = json_decode(file_get_contents($configFile));
            self::$config = (array) self::$config;

            foreach (array_keys((array) $toBeMerged) as $entry) {
                # Verbose if for understandability as its not performance relevant
                # - When overwrite demanded, then always replace
                # - Otherwise only replace when not set
                if ($overwrite === true) {
                    self::$config[$entry] = $toBeMerged->$entry;
                } elseif ($overwrite === false && !isset(self::$config->$entry)) {
                    self::$config[$entry] = $toBeMerged->$entry;
                }

            }

            self::$config = (object) self::$config;
        }
    }
}