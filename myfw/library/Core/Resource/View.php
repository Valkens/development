<?php
class Core_Resource_View
{
    protected $_data = array();
    protected $_templateEngine;
    protected static $_options;

    public function __construct()
    {
        $this->_templateEngine = new Core_View_TemplateEngine();
        Core_Helper_View::$options = self::$_options;
        $this->setTheme(self::$_options['theme']);
    }

    public static function setOptions($options)
    {
        self::$_options = $options;
    }

    public static function getOptions()
    {
        return self::$_options;
    }

    public function setTheme($theme)
    {
        Core_Helper_View::$theme = $theme;
    }

    public function getTheme()
    {
        return Core_Helper_View::$theme;
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