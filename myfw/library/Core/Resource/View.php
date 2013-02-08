<?php
class Core_Resource_View
{
    protected $_options;
    protected $_loader;
    protected $_templateEngine;

    public function __construct()
    {
        $this->_options = Core_Resource_Manager::getOptions('view');
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

    public function render($path, $file, $data = array())
    {
        $dir = APPLICATION_PATH . '/theme/' . $this->getTheme();
        $namespace = '_' . str_replace(array(APPLICATION_PATH, '/'), array('', '_'), $dir) . '_';

        $this->_templateEngine->addPath($dir);
        $this->_templateEngine->addPath($dir . '/' . $path, $namespace);
        $this->_templateEngine->setVar($data);
        $this->_templateEngine->template('@' . $namespace . '/' . $file)->render();
    }
}