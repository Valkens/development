<?php
class Core_View_TemplateEngine
{
    protected $_paths;
    public $varsUniversal = array();
    public $autoEscape = true;

    public function addPath($path, $namespace = '_theme_')
    {
        if (!is_dir($path)) {
            throw new Exception("Not a directory: $path");
        }

        $this->_paths[$namespace] = rtrim($path, '/');
    }

    public function setVar($varValue) {
        $this->varsUniversal = $varValue;
    }

    public function setAutoEscape($escape = True) {
        $this->autoEscape = $escape;
    }

    public function template($file, $autoEscape = NULL)
    {
        if ($autoEscape === NULL) {
            $autoEscape = $this->autoEscape;
        }

        $namespace = substr(substr($file, 1), 0, strpos($file, '/') - 1);
        $file = str_replace('@' . $namespace . '/', '', $file);

        if (!isset($this->_paths[$namespace])) {
            throw new Exception(sprintf('There are no registered paths for namespace "%s".', $namespace));
        }

        $fpath = $this->_paths[$namespace] . '/' . $file . '.tpl';

        // Check if the template exists.
        if (!is_file($fpath)) {
            throw new Exception("Template not found or not a file: $fpath");
        }

        // Cache template file
        $cacheFile = CACHE_PATH . '/template' . '/' . md5($fpath) . '.php';
        $cacheFileDate = (file_exists($cacheFile)) ? filemtime($cacheFile) : 0;

        if ((filemtime($fpath) > $cacheFileDate)) {
            file_put_contents($cacheFile, $this->compile(file_get_contents($fpath), $autoEscape));
        }

        return new Core_View_Template(
            $this,
            $cacheFile,
            $this->varsUniversal
        );
    }

    private function compile($contents, $autoEscape = true)
    {
        // Parse custom short-hand tags to PHP code.
        $contents = preg_replace(
            array(
                "/{{/",
                "/}}\n/",
                "/}}/",
                "/\[\[/",
                "/\]\]/",
                '/^\s*@(.*)$/m',
                '/{%\s*block\s(.*)\s*%}(.*){%\s*endblock\s*%}/Usm',
            ),
            array(
                $autoEscape ? "<?php echo(htmlspecialchars(" : "<?php echo(",
                $autoEscape ? ")); ?>\n\n" : "); ?>\n\n",
                $autoEscape ? ")); ?>" : "); ?>",
                "<?php ",
                " ?>",
                "<?php \\1 ?>",
                "<?php if (array_key_exists('\\1', \$this->inheritBlocks)) { echo \$this->inheritBlocks['\\1']; } else if (\$this->inheritFrom === NULL) { ?>\\2<?php } else { ob_start(); ?>\\2<?php \$this->inheritBlocks['\\1'] = ob_get_contents(); ob_end_clean(); } ?>",
            ),
            $contents
        );

        return $contents;
    }

}