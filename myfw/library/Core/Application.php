<?php
class Core_Application
{
    private static $_application;
    protected $_environment = null;
    protected $_options = array();
    protected $_router;

    public static function getInstance($environment = null, $options = null)
    {
        if (self::$_application == null) {
            self::$_application = new Core_Application();

            include_once LIBRARY_PATH . '/Core/Loader.php';

            // Registry auto loader
            spl_autoload_register(array(new Core_Loader($options), 'autoload'));

            self::$_application->_environment = $environment;
            self::$_application->_setOptions($options);
            self::$_application->_setExceptionHandler();
        }

        return self::$_application;
    }

    public function getRouter()
    {
        return $this->_router;
    }

    public function run()
    {
        $subDir = '/' . ltrim(str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace('\\','/', BASE_PATH)), '/');
        $basePath = ($subDir == '/') ? '' : $subDir;

        // Set Router
        $this->_router = new Core_Router();
        $this->_router->setBasePath($basePath);
        $this->_getRoutes();

        $match = $this->_router->match();
        if ($match) {
            $controllerClass = $match['target']['module'] . '_Controller_' . $match['target']['controller'] . 'Controller';
        } else {
            throw new Exception('Page not found', 404);
        }

        // Create controller
        $controller = new $controllerClass(array(
            'module' => $match['target']['module'],
            'controller' => $match['target']['controller'],
            'action' => $match['target']['action'],
            'params' => isset($match['params']) ? array_merge($match['params'], $_REQUEST) : array()
        ));
        $controller->dispatch();
    }

    protected function _setOptions($options)
    {
        $this->_options = $options;

        foreach ($this->_options as $key => $val) {
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