<?php
class Core_Helper_View
{
    public static function cccJs($files, $options)
    {
        $js_files_date = 0;
        $compressed_js_filename = '';

        foreach ($files as $file) {
            $filePath = BASE_PATH . '/' . $file;
            $js_files_date = max(filemtime($filePath), $js_files_date);
            $compressed_js_filename .= $file;
        };

        $compressed_js_filename = md5($compressed_js_filename);

        $compressed_js_path = BASE_PATH . '/public/js/cache/' . $compressed_js_filename . '.js';
        $compressed_js_file_date = file_exists($compressed_js_path) ? filemtime($compressed_js_path) : 0;

        // aggregate and compress js files content, write new caches files
        if ($js_files_date > $compressed_js_file_date) {
            $content = '';
            foreach ($files as $file) {
                $filePath = BASE_PATH . '/' . $file;

                if ($options['minify']) {
                    $content .= self::minifyJs(file_get_contents($filePath));
                } else {
                    $content .= file_get_contents($filePath);
                }
            }

            file_put_contents($compressed_js_path, $content);
            chmod($compressed_js_path, 0777);
        }

        return BASE_URL . '/public/js/cache/' . $compressed_js_filename . '.js';
    }

    public static function cccCss($files, $options)
    {
        $css_files_date = 0;
        $compressed_css_filename = '';

        foreach ($files as $file) {
            $filePath = BASE_PATH . '/' . $file;
            $css_files_date = max(filemtime($filePath), $css_files_date);
            $compressed_css_filename .= $file;
        };

        $compressed_css_filename = md5($compressed_css_filename);

        $compressed_css_path = BASE_PATH . '/public/css/cache/' . $compressed_css_filename . '.css';
        $compressed_css_file_date = file_exists($compressed_css_path) ? filemtime($compressed_css_path) : 0;

        // aggregate and compress css files content, write new caches files
        if ($css_files_date > $compressed_css_file_date) {
            $content = '';
            foreach ($files as $file) {
                $filePath = BASE_PATH . '/' . $file;
                if ($options['minify']) {
                    $content .= self::minifyCss(file_get_contents($filePath));
                } else {
                    $content .= file_get_contents($filePath);
                }
            }

            file_put_contents($compressed_css_path, $content);
            chmod($compressed_css_path, 0777);
        }

        return BASE_URL . '/public/css/cache/' . $compressed_css_filename . '.css';
    }

    public static function minifyHtml($html)
    {
        require_once BASE_PATH . '/library/Min/lib/Minify/HTML.php';

        return call_user_func(array('Minify_HTML', 'minify'), $html);
    }

    public static function minifyJs($js)
    {
        require_once BASE_PATH . '/library/Min/lib/JsMin.php';

        return call_user_func(array('JsMin', 'minify'), $js);
    }

    public static function minifyCss($css)
    {
        require_once BASE_PATH . '/library/Min/lib/Minify/CSS.php';

        return call_user_func(array('Minify_CSS', 'minify'), $css);
    }
}