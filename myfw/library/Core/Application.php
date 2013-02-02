<?php
class Core_Application
{
    protected $_environment;
    protected $_options;
    protected $_router;

    public function __construct($environment, $options)
    {
        include_once LIBRARY_PATH . '/Core/Loader.php';
        include_once LIBRARY_PATH . '/Core/Helper/Class.php';

        // Registry auto loader
        spl_autoload_register(array(new Core_Loader($options), 'autoload'));

        $this->_environment = $environment;
        $this->_setOptions($options);
        $this->_setExceptionHandler();
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

    protected function _setExceptionHandler()
    {
        set_exception_handler(array(new Base_Controller_ErrorController(null), 'errorAction'));
    }

    protected function _registryResources($resources)
    {
        foreach ($resources as $resource => $options) {
            Core_Resource_Manager::setOptions($resource, $options);
        }
    }

    public function run()
    {
        $subDir = '/' . ltrim(str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace('\\','/', BASE_PATH)), '/');
        $basePath = ($subDir == '/') ? '' : $subDir;

        // Set Router
        $this->_router = new Core_Router();
        $this->_router->setBasePath($basePath);
        $this->_getRoutes();

        // Set registry
        $registry = Core_Registry::getInstance();
        $registry->set('router', $this->_router);

        $match = $this->_router->match();
        if ($match) {
            $controllerClass = $match['target']['module'] . '_Controller_' . $match['target']['controller'] . 'Controller';
        } else {
            throw new Exception('Page not found', 404);
        }

        // Set controller
        $controller = new $controllerClass(array(
            'module' => $match['target']['module'],
            'controller' => $match['target']['controller'],
            'action' => $match['target']['action'],
            'params' => isset($match['params']) ? array_merge($match['params'], $_REQUEST) : array()
        ));
        $controller->setRouter($this->_router);
        $controller->dispatch();
    }

    protected function _getRoutes()
    {
        $modules = $this->_options['modules'];

        foreach ($modules as $module) {
            $routeFile = APPLICATION_PATH . '/module/' . $module . '/Route/Route.php';
            if (file_exists($routeFile)) {
                $routes = include_once $routeFile;
                foreach ($routes  as $route) {
                    $this->_router->map($route['method'], $route['route'], $route['target'], $route['name']);
                }
            }
        }
    }

}