<?php
class Core_Resource_View
{
    protected $_options;
    protected $_loader;
    protected $_templateEngine;

    public function __construct()
    {
        $this->_options = Core_Resource_Manager::getOption('view');
        $this->_templateEngine = new Core_TemplateEngine(null, $this->_options['options']);

        // Add layout path
        $this->_templateEngine->addPath($this->_options['layoutParams']['dir']);

        // Delete all cache file
        if (!$this->_options['options']['combineCss']) {
            Core_Helper_File::deleteAllFile(BASE_PATH . '/public/css/cache', 'css');
        }
        if (!$this->_options['options']['combineJs']) {
            Core_Helper_File::deleteAllFile(BASE_PATH . '/public/css/cache', 'js');
        }
    }

    public function render($dir, $file, $data = array())
    {
        $namespace = str_replace(array(APPLICATION_PATH, '/'), array('', '_'), $dir) . '_';
        $this->_templateEngine->addPath($dir, $namespace);

        // Registry filter
        if ($this->_options['options']['minify']) {
            $this->_templateEngine->registryFilter('output', array('Core_Helper_View', 'minifyHtml'), array('xhtml', 'cssMinifier' => array('Core_Helper_View', 'minifyCss'), 'jsMinifier' => array('Core_Helper_View', 'minifyJs')));
        }

        echo $this->_templateEngine->template('@' . $namespace . '/' . $file, $data)->render();
    }
}