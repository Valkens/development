<?php
class Core_TemplateEngine
{
    protected $_paths;
    public $varsUniversal = array();
    public $options = array();
    public $registryFilters = array();
    public $autoEscape = true;
    public $cache = array();
    public $theme;

    public function __construct($options = array())
    {
        $this->options = $options;
        $this->theme = $options['theme'];
    }

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

        $fpath = $this->_paths[$namespace] . '/' . trim($file, '/') . '.tpl';

        // Check if the template exists.
        if (!is_file($fpath)) {
            throw new Exception("Template not found or not a file: $fpath");
        }

        // Cache template file
        $cachePath = CACHE_PATH . '/template';
        if (!file_exists($cachePath)) mkdir($cachePath, 777);
        $cacheFile = $cachePath . '/' . md5($fpath) . '.php';
        $cacheFileDate = (file_exists($cacheFile)) ? filemtime($cacheFile) : 0;

        if ((filemtime($fpath) > $cacheFileDate)) {
            $content = $this->compile(file_get_contents($fpath), $autoEscape);
            file_put_contents($cacheFile, $content);
        } else {
            $content = file_get_contents($cacheFile);
        }

        // Set view helper
        Core_Helper_View::$options = $this->options;
        Core_Helper_View::$theme = $this->theme;

        // Load the base or translated template.
        $template = new Core_Template(
            $this,
            $fpath,
            $content,
            $this->varsUniversal
        );


        return $template;
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
                "/\]\]/\n?",
                '/^\s*@(.*)$/m',
                '/\[:\s*block\s(.*)\s*:\](.*)\[:\s*endblock\s*:\]/Usm',
            ),
            array(
                $autoEscape ? "<?php echo(htmlspecialchars(" : "<?php echo(",
                $autoEscape ? ")); ?>\n\n" : "); ?>\n\n",
                $autoEscape ? ")); ?>" : "); ?>",
                "<?php ",
                " ?>",
                "<?php \\1 ;?>",
                "<?php if (array_key_exists('\\1', \$this->inheritBlocks)) { echo \$this->inheritBlocks['\\1']; } else if (\$this->inheritFrom === NULL) { ?>\\2<?php } else { ob_start(); ?>\\2<?php \$this->inheritBlocks['\\1'] = ob_get_contents(); ob_end_clean(); } ?>",
            ),
            $contents
        );

        return $contents;
    }

    public function registryFilter($type, $callback, $params)
    {
        $this->registryFilters[$type] = array($callback, $params);
    }

}