<?php
class Core_Resource_View
{
    protected $_options;
    protected $_loader;
    protected $_environment;

    public function __construct()
    {
        $this->_options = Core_Resource_Manager::getOption('view');

        // Setup Twig
        Twig_Autoloader::register();
        $this->_loader = new Twig_Loader_Filesystem($this->_options['layoutParams']['dir']);
        $this->_environment = new Twig_Environment($this->_loader, $this->_options['options']);
    }

    public function render($dir, $file, $data = array())
    {
        $viewNs = 'view' . str_replace(array(APPLICATION_PATH, '/'), array('', '_'), $dir);
        $this->_loader->addPath($dir, $viewNs);

        echo $this->_environment->render('@' . $viewNs . '/' . $file . '.twig', $data);
    }
}