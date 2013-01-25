<?php
class Base_Controller_ErrorController extends Core_Controller
{
    public function errorAction(Exception $e)
    {
        $this->_data['pageTitle'] = $e->getMessage();

        switch ($e->getCode())
        {
            case 404:
                header('HTTP/1.0 404');
                break;

            default:
                header('HTTP/1.0 500');
                $this->_data['pageTitle'] = 'Application error';
                break;
        }

        if (ini_get('display_errors')) {
            $this->_data['exception'] = $e;
        }

        echo $this->_view->render('module/base/error', 'error', $this->_data);
    }
}