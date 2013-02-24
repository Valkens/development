<?php
class Core_View_Template
{
    public $engine;
    public $cacheFile = null;
    public $varsGlobal = array();
    public $inheritFrom;
    public $inheritBlocks = array();

    public function __construct($engine, $cacheFile, $varsGlobal = array())
    {
        $this->engine = $engine;
        $this->cacheFile = $cacheFile;
        $this->varsGlobal = $varsGlobal;
    }

    public function setVar($varName, $varValue)
    {
        $this->varsGlobal[$varName] = $varValue;
    }

    public function render()
    {
        extract($this->varsGlobal);

        include $this->cacheFile;

        if ($this->inheritFrom !== NULL) {
            $this->inheritFrom->inheritBlocks = $this->inheritBlocks;
            $this->inheritFrom->render();
        }
    }

    public function inc($template)
    {
        $this->engine->template($template)->render();
    }

    public function inherit($template)
    {
        $this->inheritFrom = $this->engine->template($template);
    }

    public function __call($method, $args)
    {
        $method = ucfirst($method);
        $class = 'Core_View_Helper_' . $method;
        return call_user_func_array("{$class}::{$method}", $args);
    }

    public function widget($name)
    {
        $options = Core_Resource_View::getOptions();

        $path = APPLICATION_PATH . '/theme/' . $options['theme'] . '/widget/' . strtolower($name) . '/controller.php';
        $class = 'Widget_' . strtoupper($name) . '_Controller';

        include_once ($path);

        $instance = new $class;
        $instance->view = Core_Resource_View::getInstance();
        $instance->init();
        $instance->view->render('widget/' . strtolower($name), 'index');
    }

}