<?php
class Core_Application
{
    protected $_environment;
    protected $_options;
    protected $_router;

    public function __construct($environment, $options)
    {
        $this->_environment = $environment;
        $this->_setOptions($options);
    }

    protected function _setOptions($options)
    {
        $this->_options = $options;
        if (!empty($options['phpSettings'])) {
            $this->_setPhpSettings($options['phpSettings']);
        }
    }

    protected function _setPhpSettings($settings)
    {
        foreach ($settings[$this->_environment] as $key => $value) {
            ini_set($key, $value);
        }
    }

    public function run()
    {
        require_once LIBRARY_PATH . '/' . 'Core/Loader.php';

        // Registry auto loader
        spl_autoload_register(array(new Core_Loader($this->_options), 'autoload'));

        // Set Router
        $subFolder = '/' . ltrim(str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace('\\','/', BASE_PATH)), '/');
        $this->_router = new Core_Router();
        $this->_router->setBasePath($subFolder);
        $this->_getRoutes();

        print_r($this->_router->match());
    }

    protected function _getRoutes()
    {
        $modules = $this->_options['modules'];

        foreach ($modules as $module) {
            $routeDir = APPLICATION_PATH . '/module/' . $module . '/Route/Route.php';
            if (file_exists($routeDir)) {
                $routes = include_once $routeDir;
                foreach ($routes  as $route) {
                    $this->_router->map($route['method'], $route['route'], $route['target'], $route['name']);
                }
            } else {
                throw new Exception("Route config file of '{$module}'is not found.");
            }
        }
    }
}