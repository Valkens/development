<?php
class Core_View_Helper_Url
{
    public static function url($routeName, $params = null)
    {
        return Core_Application::getInstance()->getRouter()->generate($routeName, $params);
    }
}