<?php
function Core_View_Helper_Url($routeName, $params = null)
{
    return Core_Application::getInstance()->getRouter()->generate($routeName, $params);
}