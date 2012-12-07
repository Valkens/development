<?php
class Default_Controller_ErrorController extends Core_Controller
{
    public function error404Action()
    {
        $this->_data['pageTitle'] = 'Page not Found';
        $this->_render('error404');
    }
}