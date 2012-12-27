<?php
class Core_Resource_View
{
    protected $_options;
    protected $_loader;
    protected $_templateEngine;
    public $viewPath;

    public function __construct()
    {
        $this->_options = Core_Resource_Manager::getOption('view');
        $this->_templateEngine = new Core_TemplateEngine(null, $this->_options);

        // Add layout path
        $this->viewPath = APPLICATION_PATH . '/theme/' . $this->_options['theme'];
        $this->_templateEngine->addPath($this->viewPath);

        // Delete all cache file
        if (!$this->_options['combineCss']) {
            Core_Helper_File::deleteAllFile(BASE_PATH . '/public/cache', 'css');
        }
        if (!$this->_options['combineJs']) {
            Core_Helper_File::deleteAllFile(BASE_PATH . '/public/cache', 'js');
        }
    }

    public function setTheme($theme)
    {
        $this->_templateEngine->setTheme($theme);
    }

    public function render($dir, $file, $data = array())
    {
        $namespace = str_replace(array(APPLICATION_PATH, '/'), array('', '_'), $dir) . '_';
        $this->_templateEngine->addPath($dir, $namespace);

        // Registry filter
        if ($this->_options['minify']) {
            $this->_templateEngine->registryFilter('output',
                                                    array('Core_Helper_View', 'minifyHtml'),
                                                    array('xhtml', 'cssMinifier' => array('Core_Helper_View', 'minifyCss'), 'jsMinifier' => array('Core_Helper_View', 'minifyJs')));
        }

        echo $this->_templateEngine->template('@' . $namespace . '/' . $file, $data)->render();
    }
}