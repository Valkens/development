<?php
class Core_Helper_Minify
{
    public static function minifyCss($css)
    {
        include_once LIBRARY_PATH . '/Min/lib/Minify/CSS.php';

        return call_user_func('Minify_CSS::minify', $css);
    }

    public static function minifyJs($js)
    {
        include_once LIBRARY_PATH . '/Min/lib/JSMin.php';

        return call_user_func('JSMin::minify', $js);
    }

}