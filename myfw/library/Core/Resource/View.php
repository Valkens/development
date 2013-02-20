<?php
class Core_Resource_View
{
    protected $_options = array();
    protected $_data = array();
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

    public function __set($name, $value)
    {
        $this->_data[$name] = $value;
    }

    public function __get($name)
    {
        return isset($this->_data[$name]) ? $this->_data[$name] : null;
    }

    public function render($path, $file)
    {
        $dir = 'theme/' . $this->getTheme();
        $namespace = '_' . str_replace('/', '_', $dir) . '_';
        $dir = APPLICATION_PATH . '/' . $dir;

        $this->_templateEngine->addPath($dir);
        $this->_templateEngine->addPath($dir . '/' . $path, $namespace);
        $this->_templateEngine->setVar($this->_data);
        $this->_templateEngine->template('@' . $namespace . '/' . $file)->render();
    }
}