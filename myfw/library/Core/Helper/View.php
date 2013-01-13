<?php
class Core_Helper_View
{
    public static function cccJs($files, $options)
    {
        $js_files_date = 0;
        $compressed_js_filename = '';

        // Check app config modify
        $files[] = BASE_PATH . '/app/config/app.php';

        foreach ($files as $file) {
            $js_files_date = max(filemtime($file), $js_files_date);
            $compressed_js_filename .= $file;
        };

        $compressed_js_filename = md5($compressed_js_filename);

        if (!file_exists(BASE_PATH . '/public/cache')) mkdir(BASE_PATH . '/public/cache', 777);
        $compressed_js_path = BASE_PATH . '/public/cache/' . $compressed_js_filename . '.js';
        $compressed_js_file_date = file_exists($compressed_js_path) ? filemtime($compressed_js_path) : 0;

        // aggregate and compress js files content, write new caches files
        if ($js_files_date > $compressed_js_file_date) {
            $content = '';
            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) != 'js') continue;

                if ($options['minify']) {
                    $content .= self::minifyJs(file_get_contents($file));
                } else {
                    $content .= file_get_contents($file);
                }
            }

            file_put_contents($compressed_js_path, $content . "\r\n");
        }

        return BASE_URL . '/public/cache/' . $compressed_js_filename . '.js';
    }

    public static function cccCss($files, $options)
    {
        $css_files_date = 0;
        $compressed_css_filename = '';

        // Check app config modify
        $files[] = BASE_PATH . '/app/config/app.php';

        foreach ($files as $file) {
            $css_files_date = max(filemtime($file), $css_files_date);
            $compressed_css_filename .= $file;
        };

        $compressed_css_filename = md5($compressed_css_filename);

        if (!file_exists(BASE_PATH . '/public/cache')) mkdir(BASE_PATH . '/public/cache', 777);
        $compressed_css_path = BASE_PATH . '/public/cache/' . $compressed_css_filename . '.css';
        $compressed_css_file_date = file_exists($compressed_css_path) ? filemtime($compressed_css_path) : 0;

        // aggregate and compress css files content, write new caches files
        if ($css_files_date > $compressed_css_file_date) {
            $content = '';
            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) != 'css') continue;

                if ($options['minify']) {
                    $content .= self::minifyCss(file_get_contents($file));
                } else {
                    $content .= file_get_contents($file);
                }
            }

            file_put_contents($compressed_css_path, $content . "\r\n");
        }

        return BASE_URL . '/public/cache/' . $compressed_css_filename . '.css';
    }

    public static function minifyHtml($html, $params)
    {
        require_once BASE_PATH . '/library/Min/lib/Minify/HTML.php';

        return call_user_func(array('Minify_HTML', 'minify'), $html, $params);
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