<?php
class Core_Resource_View
{
    private static $_view;
    protected $_data = array();
    protected $_templateEngine;
    protected static $_options;
    public $body = '';

    private function __construct()
    {
        $this->_templateEngine = new Core_View_TemplateEngine();
        $this->setTheme(self::$_options['theme']);
    }

    public static function getInstance()
    {
        if (!self::$_view) {
            self::$_view = new Core_Resource_View();
        }

        return self::$_view;
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
        self::$_options['theme'] = $theme;
    }

    public function getTheme()
    {
        return self::$_options['theme'];
    }

    public function __set($name, $value)
    {
        $this->_data[$name] = $value;
    }

    public function __get($name)
    {
        return isset($this->_data[$name]) ? $this->_data[$name] : null;
    }

    public function setData($data)
    {
        $this->_data = $data;
    }

    public function getData()
    {
        return $this->_data;
    }

    public function render($path, $file)
    {
        $dir = 'theme/' . $this->getTheme();
        $namespace = '_' . str_replace('/', '_', "{$dir}/{$path}") . '_';
        $dir = APPLICATION_PATH . '/' . $dir;

        $this->_templateEngine->addPath($dir);
        $this->_templateEngine->addPath($dir . '/' . $path, $namespace);
        $this->_templateEngine->setVar($this->_data);
        $this->_templateEngine->template('@' . $namespace . '/' . $file)->render();
    }
}