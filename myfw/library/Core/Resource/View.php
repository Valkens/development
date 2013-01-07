<?php
class Core_Resource_View
{
    protected $_options;
    protected $_loader;
    protected $_templateEngine;

    public function __construct()
    {
        $this->_options = Core_Resource_Manager::getOption('view');
        $this->_templateEngine = new Core_TemplateEngine(NULL, $this->_options);

        // Add layout path
        $this->_theme = $this->_options['theme'];

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

    public function getTheme()
    {
        return $this->_templateEngine->getTheme();
    }

    public function render($dir, $file, $data = array())
    {
        $path = APPLICATION_PATH . '/theme';
        // Theme
        $this->_templateEngine->addPath($path . '/' . $this->_templateEngine->getTheme());

        $namespace = '_' . str_replace(array(APPLICATION_PATH, '/'), array('', '_'), $dir) . '_';
        $this->_templateEngine->addPath($path. '/' . $this->_templateEngine->getTheme() . '/'  . $dir, $namespace);

        // Registry filter
        if ($this->_options['minify']) {
            $this->_templateEngine->registryFilter('output',
                                                    array('Core_Helper_View', 'minifyHtml'),
                                                    array('xhtml', 'cssMinifier' => array('Core_Helper_View', 'minifyCss'), 'jsMinifier' => array('Core_Helper_View', 'minifyJs')));
        }

        $this->_templateEngine->setVar($data);
        echo $this->_templateEngine->template('@' . $namespace . '/' . $file)->render();
    }
}