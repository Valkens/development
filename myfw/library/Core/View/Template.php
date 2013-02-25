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
        include_once LIBRARY_PATH . "/Core/View/Helper/{$method}.php";

        return call_user_func_array("Core_View_Helper_{$method}", $args);
    }

    public function widget($name, $params = array())
    {
        $options = Core_Resource_View::getOptions();

        $path = APPLICATION_PATH . '/theme/' . $options['theme'] . '/widget/' . strtolower($name) . '/controller.php';
        $functionName = 'Widget_' . strtoupper($name) . '_Controller';

        include_once ($path);

        $view = call_user_func($functionName, Core_Resource_View::getInstance(), $params);
        $view->render('widget/' . strtolower($name), 'index');
    }

}