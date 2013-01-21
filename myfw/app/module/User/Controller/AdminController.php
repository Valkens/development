<?php
class User_Controller_AdminController extends Base_Controller_AdminController
{
    public function loginAction()
    {
        if ($this->isPost() && $this->isAjax()) {
            $this->_noRender = true;

            $username = $this->_params['username'];
            $password = $this->_params['password'];

            if ($username == 'admin' && $password == 'admin') {
                die(json_encode(array('success' => 1)));
            } else {
                die(json_encode(array('success' => 0)));
            }
        }
    }
}