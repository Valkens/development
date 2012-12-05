<?php
class Core_Loader
{
    protected $_settings;

    public function __construct($settings)
    {
        $this->_settings = $settings;
    }

    public function autoload($class)
    {
        $portions = explode('_', $class);
        $namespace = $portions[0];

        if (!empty($this->_settings['libraries'])) {
            $dir = '';
            if (in_array($namespace, $this->_settings['libraries'])) {
                $dir = LIBRARY_PATH;
            } else {
                $dir = APPLICATION_PATH . '/' . 'module';
            }
        }
        $file = $this->standardiseFile($class);

        $file = str_replace('_', '/', $file);

        include_once $dir . '/' . $file;

        if (!class_exists($class, false) && !interface_exists($class, false)) {
            throw new Exception("File \"$file\" does not exist or class \"$class\" was not found in the file");
        }
    }

    protected function _securityCheck($filename)
    {
        /**
         * Security check
         */
        if (preg_match('/[^a-z0-9\\/\\\\_.:-]/i', $filename)) {
            throw new Exception('Security check: Illegal character in filename');
        }
    }

    public function standardiseFile($file)
    {
        $fileName = ltrim($file, '\\');
        $file      = '';
        $namespace = '';
        if ($lastNsPos = strripos($fileName, '\\')) {
            $namespace = substr($fileName, 0, $lastNsPos);
            $fileName = substr($fileName, $lastNsPos + 1);
            $file      = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $file .= str_replace('_', DIRECTORY_SEPARATOR, $fileName) . '.php';
        return $file;
    }
}