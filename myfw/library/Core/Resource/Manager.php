<?php
class Core_Resource_Manager
{
    private static $_resources = array();

    public static function setOptions($resource, $options = array())
    {
        self::$_resources[$resource]['options'] = $options;
    }

    public static function getOptions($resource)
    {
        return self::$_resources[$resource]['options'];
    }

    public static function getResource($resource)
    {
        if (!isset(self::$_resources[$resource]['value'])) {
            $class = 'Core_Resource_' . ucfirst($resource);
            self::$_resources[$resource]['value'] = new $class;
        }

        return self::$_resources[$resource]['value'];
    }
}