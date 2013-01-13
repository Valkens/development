<?php
class Core_TemplateEngine
{
    protected $_paths;
    public $varsUniversal = array();
    public $options = array();
    public $registryFilters = array();
    public $autoEscape = true;
    public $cache = array();
    public $_theme;

    public function __construct($locale = NULL, $options = array())
    {
        $this->locale = $locale;
        $this->options = $options;

        $this->setTheme($options['theme']);
    }

    public function setTheme($theme)
    {
        $this->_theme = $theme;
    }

    public function getTheme()
    {
        return $this->_theme;
    }

    public function addPath($path, $namespace = '_theme_')
    {
        if (!is_dir($path)) {
            throw new Exception("Not a directory: $path");
        }

        $this->_paths[$namespace] = rtrim($path, '/');
    }

    /**
     * @brief Set a universal variable which will available in each template created with this Template instance.
     * @param $varValue (mixed) The value of the variable.
     */
    public function setVar($varValue) {
        $this->varsUniversal = $varValue;
    }

    /**
     * @brief Turn the auto escape on or off. If on, all content rendered using {{ and }} will automatically be escaped with htmlspecialchars().
     * @param $escape (boolean) True of False. If True, auto escaping is turned on (this is the default). If False, it is turned off for templates retrieved with this Template engine.
     * @note Auto escaping can be overridden by passing the $autoEscape option to the template() and templateFromString() methods.
     */
    public function setAutoEscape($escape = True) {
        $this->autoEscape = $escape;
    }

    /**
     * @brief Set the locale for templates.
     * @param $locale (string) The locale for the templates to retrieve. If a file with the suffix noted in $locale is available, it will be returned instead of the default .tpl file.
     */
    public function setLocale($locale) {
        $this->locale = $locale;
    }

    /**
     * @param $path (string) Template path, without the .tpl extension, relative to the templatePath.
     * @param $autoEscape (boolean) Whether to auto escape {{ and }} output with htmlspecialchars()
     * @throw Exception if the template is not exists
     */
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

        // Cache template

        $cachePath = CACHE_PATH . '/template';
        if (!file_exists($cachePath)) mkdir($cachePath, 777);
        $cacheFile = $cachePath . '/' . md5($fpath);

        if (!file_exists($cacheFile)
            || (filemtime($fpath) > filemtime($cacheFile))
        ) {
            $content = $this->compile(file_get_contents($fpath), $autoEscape);
            file_put_contents($cacheFile, $content);
            touch($cacheFile, filemtime($fpath));
        } else {
            $content = file_get_contents($cacheFile);
        }

        // Load the base or translated template.
        $template = new Core_Template(
            $this,
            $fpath,
            $content,
            $this->varsUniversal
        );

        return $template;
    }

    /**
     * @brief Create a Template from a string.
     *
     * Create a Template instance using $contents as the template contents.
     * This severely limited what you can do with the Template. There will be
     * no including from the template, no translations, no caching, etc.
     *
     * @param $contents (string) The template contents.
     * @param $autoEscape (boolean) Whether to auto escape {{ and }} output with htmlspecialchars()
     * @returns (Template) Template class instance.
     */
    public function templateFromString($contents, $autoEscape = Null) {
        if ($autoEscape === Null) {
            $autoEscape = $this->autoEscape;
        }

        // Load the base or translated template.
        $template = new Core_Template(
            NULL,
            "FROM_STRING",
            $this->compile($contents, $autoEscape),
            array()
        );
        return($template);
    }

    /**
     * @brief Compile a template string to PHP code.
     * @param $contents (string) String to compile to PHP code.
     * @param $autoEscape (boolean) Whether to auto escape {{ and }} output with htmlspecialchars()
     * @note This method is used by the Template class itself, and shouldn't be called directly yourself. Use templateFromString() instead.
     */
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
                '/\[:\s*block\s(.*)\s*:\](.*)\[:\s*endblock\s*:\]/Usm',
            ),
            array(
                $autoEscape ? "<?php echo(htmlspecialchars(" : "<?php echo(",
                $autoEscape ? ")); ?>\n\n" : "); ?>\n\n",
                $autoEscape ? ")); ?>" : "); ?>",
                "<?php ",
                " ?>",
                "<?php \\1 ?>",
                "<?php if (array_key_exists('\\1', \$this->inheritBlocks)) { print(\$this->inheritBlocks['\\1']); } else if (\$this->inheritFrom === NULL) { ?>\\2<?php } else { ob_start(); ?>\\2<?php \$this->inheritBlocks['\\1'] = ob_get_contents(); ob_end_clean(); } ?>",
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