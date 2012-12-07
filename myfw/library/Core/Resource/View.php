<?php
class Core_Resource_View
{
    protected $_options;
    protected $_loader;
    protected $_templateEngine;

    public function __construct()
    {
        $this->_options = Core_Resource_Manager::getOption('view');
        $this->_templateEngine = new Core_TemplateEngine();

        // Add layout path
        $this->_templateEngine->addPath($this->_options['layoutParams']['dir']);
    }

    public function render($dir, $file, $data = array())
    {
        $namespace = str_replace(array(APPLICATION_PATH, '/'), array('', '_'), $dir) . '_';

        $this->_templateEngine->addPath($dir, $namespace);

        echo $this->_templateEngine->template('@' . $namespace . '/' . $file, $data)->render();
    }
}