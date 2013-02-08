<?php
class Core_Controller
{
    protected $_router;
    protected $_request = array();
    protected $_noRender = false;
    protected $_data = array();
    protected $_fileRender;
    protected $_view;

    public function __construct($request)
    {
        $this->_router = Core_Application::getInstance()->getRouter();
        $this->_request = $request;
        $this->_view = Core_Resource_Manager::getResource('view');
        $this->init();
    }

    public function init() {}

    public function getParam($key, $default = null)
    {
        if (isset($this->_request['params'][$key])) {
            return $this->_request['params'][$key];
        }

        return $default;
    }

    public function renderFile($file)
    {
        $this->_fileRender =  $file;
    }

    public function dispatch()
    {
        $actionMethod = $this->_request['action'] . 'Action';

        if (!method_exists($this, $actionMethod)) {
            throw new Exception(sprintf('The required method "%s" does not exist for %s', $actionMethod, get_class($this)));
        }

        $this->$actionMethod();

        // Render
        if (!$this->_noRender) {
            if (!$this->_fileRender) {
                $path = 'module/' . strtolower($this->_request['module']) . '/' . strtolower($this->_request['controller']);
                $this->_view->render($path, $this->_request['action'], $this->_data);
            } else {
                $lastSlashPos = strrpos($this->_fileRender, '/');
                $this->_view->render(substr($this->_fileRender, 0,  $lastSlashPos), substr($this->_fileRender, $lastSlashPos), $this->_data);
            }
        }
    }

    public function redirect($location, $code = 302)
    {
        if (is_array($location)) {
            $url = $this->_router->generate($location['route'], isset($location['params']) ? $location['params'] : array());
        } elseif (is_string($location)) {
            $url = $location;
        } else {
            throw new Exception('Location must be an array or an string.', 500);
        }

        header("Location: $url", true, $code);
        exit();
    }

    public function setContentType($type, $charset='utf-8')
    {
        if (headers_sent())return;

        $extensions = array(
            'html'=>'text/html',
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

    public function getClientIp()
    {
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

    public function isAjax()
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
    }

    public function isPost()
    {
        return ($_SERVER['REQUEST_METHOD'] === 'POST');
    }

    public function isGet()
    {
        return ($_SERVER['REQUEST_METHOD'] === 'GET');
    }

}