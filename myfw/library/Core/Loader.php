<?php
class Core_Loader
{
    protected $_options;
    protected $_cacheFileName = 'loader.php';
    protected $_cacheFile;
    protected $_cacheIndex = array();

    public function __construct($options)
    {
        $this->_options = $options;

        // Cache
        $this->_cacheFile = CACHE_PATH . '/system/' . $this->_cacheFileName;

        if (file_exists($this->_cacheFile) && trim(file_get_contents($this->_cacheFile))) {
            $this->_cacheIndex = include_once $this->_cacheFile;
        } else {
            file_put_contents($this->_cacheFile, '<?php return array();');
        }
    }

    public function autoload($class)
    {
        if (isset($this->_cacheIndex[$class])) {
            require_once $this->_cacheIndex[$class];
        } else {
            if (!class_exists($class)) { // Multiple class in one file
                $portions = explode('_', $class);
                $namespace = $portions[0];

                if (in_array($namespace, $this->_options['libraries'])) {
                    $dir = LIBRARY_PATH;
                } else {
                    $dir = APPLICATION_PATH . '/' . 'module';
                }

                $file =  $dir . '/' . str_replace('_', '/', $class) . '.php';

                require_once $file;

                // Write cache
                $content = file_get_contents($this->_cacheFile);
                $content = str_replace(');', '', $content);
                $content .= "'{$class}'=>'{$file}',);";

                file_put_contents($this->_cacheFile, $content);
            }
        }
    }
}