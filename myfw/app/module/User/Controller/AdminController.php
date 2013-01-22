<?php
class User_Controller_AdminController extends Base_Controller_AdminController
{
    public function indexAction()
    {
        $this->_data['pageTitle'] = 'Dashboard';
    }

    public function loginAction()
    {
        if ($this->isPost() && $this->isAjax()) {
            $this->_noRender = true;

            $username = $this->_params['username'];
            $password = $this->_params['password'];

            if ($username == 'admin' && $password == 'admin') {
                $this->_session->regenerateId();
                $this->_session->set('username', 'admin');
                echo json_encode(array('success' => 1));
            } else {
                echo json_encode(array('success' => 0));
            }
        }
    }

    public function logoutAction()
    {
        $this->_noRender = true;
        $this->_session->destroy();
        $this->redirect(array('name' => 'route_admin'));
    }

}