<?php
class Core_Helper_View
{
    public static $theme;
    public static $options;

    public static function generateCss($files)
    {
        include_once LIBRARY_PATH . '/Less/lessc.inc.php';

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

                file_put_contents($cachedFilePath, (self::$options['minify']) ? self::minifyCss($fileContent) : $fileContent);
            }

            $fileLinks = array(BASE_URL . '/public/cache/' . $cachedFile);
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
        }

        foreach ($fileLinks as $link) {
            echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$link}\" />" . PHP_EOL;
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
                $fileContent = '';

                foreach ($filePaths as $filePath) {
                    $fileContent .= file_get_contents($filePath) . ';';
                }

                file_put_contents($cachedFilePath, (self::$options['minify']) ? self::minifyJs($fileContent) : $fileContent);
            }

            $fileLinks = array(BASE_URL . '/public/cache/' . $cachedFile);
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
        include_once BASE_PATH . '/library/Min/lib/Minify/CSS.php';

        return call_user_func(array('Minify_CSS', 'minify'), $css);
    }

    public static function minifyJs($js)
    {
        include_once BASE_PATH . '/library/Min/lib/JSMin.php';

        return call_user_func(array('JsMin', 'minify'), $js);
    }

    public static function minifyHtml($html, $params)
    {
        include_once BASE_PATH . '/library/Min/lib/Minify/HTML.php';

        return call_user_func(array('Minify_HTML', 'minify'), $html, $params);
    }

    public static function url($routeName, $params = array())
    {
        $registry = Core_Registry::getInstance();
        $router = $registry->get('router');

        echo $router->generate($routeName, $params);
    }

}