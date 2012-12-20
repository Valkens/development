<?php
class Core_Application
{
    protected $_environment;
    protected $_options;
    protected $_router;

    public function __construct($environment, $options)
    {
        require_once LIBRARY_PATH . '/' . 'Core/Loader.php';

        // Registry auto loader
        spl_autoload_register(array(new Core_Loader($options), 'autoload'));

        $this->_environment = $environment;
        $this->_setOptions($options);
    }

    protected function _setOptions($options)
    {
        $this->_options = $options;

        foreach ($options as $key => $val) {
            if ($key == 'phpSettings') {
                $this->_setPhpSettings($val);
            } elseif ($key == 'resources') {
                $this->_registryResources($val);
            }
        }
    }

    protected function _setPhpSettings($settings)
    {
        foreach ($settings[$this->_environment] as $key => $value) {
            if ($key == 'error_reporting') {
                error_reporting($value);
                continue;
            }
            ini_set($key, $value);
        }
    }

    protected function _registryResources($resources)
    {
        $resourceManager = Core_Resource_Manager::getInstance();
        foreach ($resources as $resource => $options) {
            $resourceManager::setOption($resource, $options);
        }
    }

    public function run()
    {
        // Set Router
        $subFolder = '/' . ltrim(str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace('\\','/', BASE_PATH)), '/');
        $this->_router = new Core_Router();
        $this->_router->setBasePath($subFolder);
        $this->_getRoutes();

        $match = $this->_router->match();

        if (empty($match)) {
            $controllerClass = 'Default_Controller_ErrorController';
            $match['target']['action'] = 'error404';
        } else {
            $controllerClass = $match['target']['module'] . '_Controller_' . $match['target']['controller'] . 'Controller';
        }

        try {
            $controller = new $controllerClass($this->_options, isset($match['params']) ? $match['params'] : array());

            $this->_dispatch($controller, $match['target']['action']);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    protected function _dispatch($controller, $action)
    {
        $controller->setRouter($this->_router);
        $controller->execute($action);
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