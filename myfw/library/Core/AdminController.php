<?php
class Core_AdminController extends Core_Controller
{
    public function init()
    {
        $this->_view->setTheme('admin');

        // Set data
        $this->_data['adminUrl'] = BASE_URL . '/admin';
    }
}