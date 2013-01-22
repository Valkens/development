<?php
class Core_Controller
{
    protected $_options;
    protected $_router;
    protected $_moduleName;
    protected $_controllerName;
    protected $_params;
    protected $_noRender;
    protected $_data = array();
    protected $_fileRender;
    protected $_view;

    public function __construct($options, $params = array())
    {
        $this->_options = $options;

        $this->_params = array_merge($params, $_REQUEST);

        $classPortion = explode('_', get_class($this));
        $this->_moduleName = $classPortion[0];
        $this->_controllerName = str_replace('Controller', '', $classPortion[2]);

        $this->_view = Core_Resource_Manager::getResource('view');
    }

    public function execute($action, $dispatch = true)
    {
        // Execute action
        if(!method_exists($this, $action . 'Action')) {
            throw new Exception(sprintf('The required method "%s" does not exist for %s', $action, get_class($this)));
        }

        // Call init method first
        if ($dispatch == true && method_exists($this, 'init')) {
            $this->init();
        }

        $actionName = $action . 'Action';
        $this->$actionName();

        if (!$this->_noRender) {
            $dir = 'module/' . strtolower($this->_moduleName) . '/' . strtolower($this->_controllerName);

            if (!$this->_fileRender) {
                $this->_view->render($dir, $action, $this->_data);
            } else {
                $lastSlashPos = strrpos($this->_fileRender, '/');
                $this->_view->render(substr($this->_fileRender, 0,  $lastSlashPos), substr($this->_fileRender, $lastSlashPos), $this->_data);
            }
        }
    }

    protected function _render($file)
    {
        $this->_fileRender =  $file;
    }

    public function forward($target, $params = array())
    {
        if (is_array($target)) {
            $controllerClass = $target['module'] . '_Controller_' . $target['controller'] . 'Controller';
            $controller = new $controllerClass($this->_options, $params);
            $controller->execute(lcfirst($target['action']), false);
        } else {
            array_merge($this->_params, $params);
            $this->execute(lcfirst($target), false);
        }
    }

    public function redirect($location, $code = 302)
    {
        if (is_array($location)) {
            if (isset($location['params'])) {
                $url = $this->_router->generate($location['name'], $location['params']);
            } else {
                $url = $this->_router->generate($location['name']);
            }
        } elseif (is_string($location)) {
            $url = BASE_URL . '/' . $location;
        }

        header("Location: $url", true, $code);
        exit();
    }

    public function setContentType($type, $charset='utf-8') {
        if (headers_sent())return;

        $extensions = array('html'=>'text/html',
            'xml'=>'application/xml',
            'json'=>'application/json',
            'js'=>'application/javascript',
            'css'=>'text/css',
            'rss'=>'application/rss+xml',
            'yaml'=>'text/yaml',
            'atom'=>'application/atom+xml',
            'pdf'=>'application/pdf',
            'text'=>'text/plain',
            'png'=>'image/png',
            'jpg'=>'image/jpeg',
            'gif'=>'image/gif',
            'csv'=>'text/csv'
        );

        if (isset($extensions[$type])) {
            header("Content-Type: {$extensions[$type]}; charset=$charset");
        }
    }

    public function clientIP() {
        if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            return getenv('HTTP_CLIENT_IP');
        } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
            return getenv('HTTP_X_FORWARDED_FOR');
        } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
            return getenv('REMOTE_ADDR');
        } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    public function isAjax(){
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
    }

    public function isPost() {
        return ($_SERVER['REQUEST_METHOD'] === 'POST');
    }

    public function setRouter($router)
    {
        $this->_router = $router;
    }
}