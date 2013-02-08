<?php
class Core_Resource_Manager
{
    private static $_resources = array();
    private static $_options = array();

    public static function setOptions($resource, $options = array())
    {
        self::$_options[$resource] = $options;
    }

    public static function getOptions($resource)
    {
        return self::$_options[$resource];
    }

    public static function getResource($resource)
    {
        if (!isset(self::$_resources[$resource])) {
            $class = 'Core_Resource_' . ucfirst($resource);
            self::$_resources[$resource] = new $class;
        }

        return self::$_resources[$resource];
    }
}