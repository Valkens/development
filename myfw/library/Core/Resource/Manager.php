<?php
class Core_Resource_Manager
{
    private static $_resourceManager;
    private static $_resources = array();

    public static function getInstance()
    {
        if (self::$_resourceManager === null) {
            self::$_resourceManager = new Core_Resource_Manager();
        }

        return self::$_resourceManager;
    }

    public static function setOption($resource, $options = array())
    {
        $instance = self::getInstance();
        self::$_resources[$resource]['options'] = $options;
    }

    public static function getOption($resource)
    {
        $instance = self::getInstance();
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