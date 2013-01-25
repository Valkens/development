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
        $this->_request = $request;
        $this->_initView();
        $this->init();
    }

    public function init() {}

    protected function _initView()
    {
        $this->_view = Core_Resource_Manager::getResource('view');
    }

    public function setRouter($router)
    {
        $this->_router = $router;
    }

    public function setRequest($request)
    {
        $this->_request = $request;
    }

    protected function _render($file)
    {
        $this->_fileRender =  $file;
    }

    public function execute($action)
    {
        if (!method_exists($this, $action . 'Action')) {
            throw new Exception(sprintf('The required method "%s" does not exist for %s', $action, get_class($this)));
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

    public function setContentType($type, $charset='utf-8')
    {
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

}