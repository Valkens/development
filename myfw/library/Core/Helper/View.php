<?php
class Core_Helper_View
{
    public static $theme;
    public static $options;

    public static function generateCss($files)
    {
        require_once LIBRARY_PATH . '/Less/lessc.inc.php';

        $less = new lessc();

        foreach ($files as $key => $file) {
            if (substr($file, 0, 1) != '/') {
                $filePaths[] = BASE_PATH . '/app/theme/' . self::$theme . '/' . $file;
            } else {
                $filePaths[] = BASE_PATH . $file;
            }
        }

        if (self::$options['combineCss']) {
            $fileDate = 0;
            $cachedFile = '';

            foreach ($filePaths as $filePath) {
                $fileDate = max(filemtime($filePath), $fileDate);
                $cachedFile .= $filePath;
            }

            $cachedFile = md5($cachedFile) . '.css';
            $cachedFilePath = BASE_PATH . '/public/cache/' . $cachedFile;
            $cachedFileDate = file_exists($cachedFilePath) ? filemtime($cachedFilePath) : 0;

            if ($cachedFileDate < $fileDate) {
                file_put_contents($cachedFilePath, ''); // Clear file
                $less->setVariables(array(
                    'themeUrl' => "'" . BASE_URL . '/app/theme/' . self::$theme . "'"
                ));

                foreach ($filePaths as $filePath) {
                    $ext = pathinfo($filePath, PATHINFO_EXTENSION);
                    if ($ext == 'less') {
                        file_put_contents($cachedFilePath, $less->compileFile($filePath) . PHP_EOL, FILE_APPEND);
                    } else {
                        file_put_contents($cachedFilePath, file_get_contents($filePath) . PHP_EOL, FILE_APPEND);
                    }
                }

                if (self::$options['minify']) {
                    file_put_contents($cachedFilePath, self::minifyCss(file_get_contents($cachedFilePath)));
                }
            }

            return array(BASE_URL . '/public/cache/' . $cachedFile);
        } else {
            foreach ($filePaths as $key => $filePath) {
                $ext = pathinfo($filePath, PATHINFO_EXTENSION);

                if ($ext == 'less') {
                    $less->setVariables(array(
                        'themeUrl' => "'" . BASE_URL . '/app/theme/' . self::$theme . "'"
                    ));
                    $cachedFile = md5($filePath) . '.css';
                    $cachedFilePath = BASE_PATH . '/public/cache/' . $cachedFile;

                    if (self::$options['minify']) {
                        $less->setFormatter('compressed');
                    }
                    $less->checkedCompile($filePath, $cachedFilePath);

                    $fileLinks[] = BASE_URL . '/public/cache/' . $cachedFile;
                } else {
                    $fileLinks[] = BASE_URL . '/' . trim(str_replace(BASE_PATH, '', $filePath), '/');
                }
            }

            return $fileLinks;
        }
    }

    public static function generateJs($files)
    {
        foreach ($files as $key => $file) {
            if (substr($file, 0, 1) != '/') {
                $filePaths[] = BASE_PATH . '/app/theme/' . self::$theme . '/' . $file;
            } else {
                $filePaths[] = BASE_PATH . $file;
            }
        }

        if (self::$options['combineJs']) {
            $fileDate = 0;
            $cachedFile = '';

            foreach ($filePaths as $filePath) {
                $fileDate = max(filemtime($filePath), $fileDate);
                $cachedFile .= $filePath;
            }

            $cachedFile = md5($cachedFile) . '.js';
            $cachedFilePath = BASE_PATH . '/public/cache/' . $cachedFile;
            $cachedFileDate = file_exists($cachedFilePath) ? filemtime($cachedFilePath) : 0;

            if ($cachedFileDate < $fileDate) {
                file_put_contents($cachedFilePath, ''); // Clear file

                foreach ($filePaths as $filePath) {
                    $ext = pathinfo($filePath, PATHINFO_EXTENSION);
                    file_put_contents($cachedFilePath, file_get_contents($filePath) . ';' . PHP_EOL, FILE_APPEND);
                }

                if (self::$options['minify']) {
                    file_put_contents($cachedFilePath, self::minifyJs(file_get_contents($cachedFilePath)));
                }
            }

            return array(BASE_URL . '/public/cache/' . $cachedFile);
        } else {
            foreach ($filePaths as $filePath) {
                $fileLinks[] = BASE_URL . '/' . trim(str_replace(BASE_PATH, '', $filePath), '/');
            }

            return $fileLinks;
        }
    }

    public static function minifyCss($css)
    {
        require_once BASE_PATH . '/library/Min/lib/Minify/CSS.php';

        return call_user_func(array('Minify_CSS', 'minify'), $css);
    }

    public static function minifyJs($js)
    {
        require_once BASE_PATH . '/library/Min/lib/JsMin.php';

        return call_user_func(array('JsMin', 'minify'), $js);
    }

    public static function minifyHtml($html, $params)
    {
        require_once BASE_PATH . '/library/Min/lib/Minify/HTML.php';

        return call_user_func(array('Minify_HTML', 'minify'), $html, $params);
    }
}