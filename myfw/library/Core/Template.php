<?php
class Core_Template
{
    public $engine;
    public $cacheFile;
    public $varsGlobal;
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
        extract($varsLocal);

        ob_start();

        try {
            include $this->cacheFile;
        } catch (Exception $e) {
            ob_end_clean();
            throw $e;
        }

        $result = ob_get_contents();

        foreach ($this->engine->registryFilters as $key => $val) {
            if ($key == 'output') {
                $result = call_user_func($val[0], $result, $val[1]);
            }
        }

        ob_end_clean();

        if ($this->inheritFrom !== NULL) {
            $this->inheritFrom->inheritBlocks = $this->inheritBlocks;
            $this->inheritFrom->render();
        }

        echo $result;
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
        call_user_func_array('Core_Helper_View::' . $method, $args);
    }

}