<?php
function Core_View_Helper_Css($files)
{
    include_once LIBRARY_PATH . '/Less/lessc.inc.php';

    $options = Core_Resource_View::getOptions();
    $less = new lessc();

    foreach ($files as $key => $file) {
        if (substr($file, 0, 1) != '/') {
            $filePaths[] = APPLICATION_PATH . '/theme/' . $options['theme'] . '/' . $file;
        } else {
            $filePaths[] = BASE_PATH . $file;
        }
    }

    if ($options['combineCss']) {
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
                'themeUrl' => "'" . BASE_URL . '/app/theme/' . $options['theme'] . "'",
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

            file_put_contents($cacheFilePath, ($options['minify']) ? Core_Helper_Minify::minifyCss($fileContent) : $fileContent);
        }

        $fileLinks = array(BASE_URL . '/public/cache/' . $cacheFile);
    } else {
        foreach ($filePaths as $key => $filePath) {
            $ext = pathinfo($filePath, PATHINFO_EXTENSION);

            if ($ext == 'less') {
                $less->setVariables(array(
                    'themeUrl' => "'" . BASE_URL . '/app/theme/' . $options['theme'] . "'"
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