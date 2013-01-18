<?php
class Base_Controller_CkfinderController extends Core_Controller
{
    public function connectAction()
    {
        $this->_noRender = true;

        require_once APPLICATION_PATH . '/theme/admin/js/ckfinder/core/connector/php/connector.php';
    }
}