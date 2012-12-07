<?php
class Core_Loader
{
    protected $_options;

    public function __construct($options)
    {
        $this->_options = $options;
    }

    public function autoload($class)
    {
        $portions = explode('_', $class);
        $namespace = $portions[0];

        if (in_array($namespace, $this->_options['libraries'])) {
            $dir = LIBRARY_PATH;
        } else {
            $dir = APPLICATION_PATH . '/' . 'module';
        }

        $file = str_replace('_', '/', $class);

        include_once $dir . '/' . $file . '.php';

        if (!class_exists($class, false) && !interface_exists($class, false)) {
            throw new Exception("File \"$file\" does not exist or class \"$class\" was not found in the file");
        }
    }

    protected function _securityCheck($filename)
    {
        if (preg_match('/[^a-z0-9\\/\\\\_.:-]/i', $filename)) {
            throw new Exception('Security check: Illegal character in filename');
        }
    }
}