<?php
class Core_View_Helper_Js
{
    public static function js($files)
    {
        $options = Core_Resource_View::getOptions();

        foreach ($files as $key => $file) {
            if (substr($file, 0, 1) != '/') {
                $filePaths[] = APPLICATION_PATH . '/theme/' . $options['theme'] . '/' . $file;
            } else {
                $filePaths[] = BASE_PATH . $file;
            }
        }

        if ($options['combineJs']) {
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

                file_put_contents($cacheFilePath, ($options['minify']) ? Core_Helper_Minify::minifyJs($fileContent) : $fileContent);
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

}