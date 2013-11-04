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
     */
    public static function initialize($configFile = null)
    {
        if (!is_null($configFile) && file_exists($configFile)) {
            $overwrite = json_decode(file_get_contents($configFile));
            self::$config = (array) self::$config;

            foreach (array_keys((array) $overwrite) as $entry) {
                if (!isset(self::$config->$entry)) {
                    self::$config[$entry] = $overwrite->$entry;
                }
            }

            self::$config = (object) self::$config;
        }
    }
}