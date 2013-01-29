<?php
class Core_Helper_Class
{
    public static function getInfo($class)
    {
        $info = explode('_', $class);

        return array(
            'namespace' => $info[0],
            'name'      => array_pop($info)
        );
    }

}