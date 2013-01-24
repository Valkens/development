<?php
class Core_Resource_View
{
    protected $_options;
    protected $_loader;
    protected $_templateEngine;

    public function __construct()
    {
        $this->_options = Core_Resource_Manager::getOption('view');
        $this->_templateEngine = new Core_TemplateEngine($this->_options);
        $this->setTheme($this->_options['theme']);
    }

    public function setTheme($theme)
    {
        $this->_templateEngine->theme = $theme;
    }

    public function getTheme()
    {
        return $this->_templateEngine->theme;
    }

    public function render($dir, $file, $data = array())
    {
        $path = APPLICATION_PATH . '/theme/' . $this->getTheme();

        $this->_templateEngine->addPath($path);
        $namespace = '_' . str_replace(array(APPLICATION_PATH, '/'), array('', '_'), $dir) . '_';
        $this->_templateEngine->addPath($path . '/' . $dir, $namespace);

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