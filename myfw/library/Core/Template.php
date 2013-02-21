<?php
class Core_Template
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

    public function setVar($varName, $varValue) {
        $this->varsGlobal[$varName] = $varValue;
    }

    public function render($varsLocal = array()) {
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
        return call_user_func_array('Core_Helper_View::' . $method, $args);
    }

}