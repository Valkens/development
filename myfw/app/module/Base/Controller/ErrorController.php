<?php
class Base_Controller_ErrorController extends Core_Controller
{
    public function errorAction(Exception $e)
    {
        $this->view->pageTitle = $e->getMessage();

        switch ($e->getCode())
        {
            case 404:
                header('HTTP/1.0 404');
                break;

            default:
                header('HTTP/1.0 500');
                $this->view->pageTitle = 'Application error';
                break;
        }

        if (ini_get('display_errors')) {
            $this->view->exception = $e;
        }

        echo $this->view->render('module/base/error', 'error');
    }

}