<?php
class Core_Helper_View
{
    public static $theme;
    public static $options;

    public static function addCss($files)
    {
        include_once LIBRARY_PATH . '/Less/lessc.inc.php';

        $less = new lessc();

        foreach ($files as $key => $file) {
            if (substr($file, 0, 1) != '/') {
                $filePaths[] = APPLICATION_PATH . '/theme/' . self::$theme . '/' . $file;
            } else {
                $filePaths[] = BASE_PATH . $file;
            }
        }

        if (self::$options['combineCss']) {
            $fileDate = 0;
            $cacheFile = '';

            foreach ($filePaths as $filePath) {
                $fileDate = max(filemtime($filePath), $fileDate);
                $cacheFile .= $filePath;
            }

            $cacheFile = md5($cacheFile) . '.css';
            $cacheFilePath = BASE_PATH . '/public/cache/' . $cacheFile;
            $cacheFileDate = file_exists($cacheFilePath) ? filemtime($cacheFilePath) : 0;

            if ($cacheFileDate < $fileDate) {
                $fileContent = '';
                $less->setVariables(array(
                    'themeUrl' => "'" . BASE_URL . '/app/theme/' . self::$theme . "'",
                    'publicUrl' => "'" . BASE_URL . '/public' . "'"
                ));

                foreach ($filePaths as $filePath) {
                    $ext = pathinfo($filePath, PATHINFO_EXTENSION);
                    if ($ext == 'less') {
                        $fileContent .= $less->compileFile($filePath) . PHP_EOL;
                    } else {
                        $fileContent .= file_get_contents($filePath) . PHP_EOL;
                    }
                }

                file_put_contents($cacheFilePath, (self::$options['minify']) ? self::minifyCss($fileContent) : $fileContent);
            }

            $fileLinks = array(BASE_URL . '/public/cache/' . $cacheFile);
        } else {
            foreach ($filePaths as $key => $filePath) {
                $ext = pathinfo($filePath, PATHINFO_EXTENSION);

                if ($ext == 'less') {
                    $less->setVariables(array(
                        'themeUrl' => "'" . BASE_URL . '/app/theme/' . self::$theme . "'"
                    ));
                    $cacheFile = md5($filePath) . '.css';
                    $cacheFilePath = BASE_PATH . '/public/cache/' . $cacheFile;

                    $less->checkedCompile($filePath, $cacheFilePath);

                    $fileLinks[] = BASE_URL . '/public/cache/' . $cacheFile;
                } else {
                    $fileLinks[] = BASE_URL . '/' . trim(str_replace(BASE_PATH, '', $filePath), '/');
                }
            }
        }

        foreach ($fileLinks as $link) {
            echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$link}\" />" . PHP_EOL;
        }
    }

    public static function addJs($files)
    {
        foreach ($files as $key => $file) {
            if (substr($file, 0, 1) != '/') {
                $filePaths[] = APPLICATION_PATH . '/theme/' . self::$theme . '/' . $file;
            } else {
                $filePaths[] = BASE_PATH . $file;
            }
        }

        if (self::$options['combineJs']) {
            $fileDate = 0;
            $cacheFile = '';

            foreach ($filePaths as $filePath) {
                $fileDate = max(filemtime($filePath), $fileDate);
                $cacheFile .= $filePath;
            }

            $cacheFile = md5($cacheFile) . '.js';
            $cacheFilePath = BASE_PATH . '/public/cache/' . $cacheFile;
            $cacheFileDate = file_exists($cacheFilePath) ? filemtime($cacheFilePath) : 0;

            if ($cacheFileDate < $fileDate) {
                $fileContent = '';

                foreach ($filePaths as $filePath) {
                    $fileContent .= file_get_contents($filePath) . ';';
                }

                file_put_contents($cacheFilePath, (self::$options['minify']) ? self::minifyJs($fileContent) : $fileContent);
            }

            $fileLinks = array(BASE_URL . '/public/cache/' . $cacheFile);
        } else {
            foreach ($filePaths as $filePath) {
                $fileLinks[] = BASE_URL . '/' . trim(str_replace(BASE_PATH, '', $filePath), '/');
            }
        }

        foreach ($fileLinks as $link) {
            echo "<script type=\"text/javascript\" src=\"{$link}\"></script>" . PHP_EOL;
        }
    }

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

    /* View Helpers */
    public static function url($routeName, $params = array())
    {
        return Core_Application::getInstance()->getRouter()->generate($routeName, $params);
    }

}