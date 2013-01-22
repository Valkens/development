<?php
class Base_Controller_CkfinderController extends Base_Controller_AdminController
{
    public function connectAction()
    {
        $this->_noRender = true;

        require_once APPLICATION_PATH . '/theme/admin/js/ckfinder/core/connector/php/connector.php';
    }

    public function popupAction() {}
}