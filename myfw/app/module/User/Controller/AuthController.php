<?php
class User_Controller_AuthController extends Core_Controller
{
    public function authAction()
    {
        $this->_noRender = true;
        $params = $this->_request['params'];
        
        if ($this->isAjax()) {
            $session = Core_Session::getInstance();
            $username = $params['username'];
            $password = $params['password'];

            if ($user = User_Helper_Auth::checkAuth($username, $password)) {
                // Update user login
                $user->last_login_ip = $this->getClientIp();
                $user->last_login = time();
                $user->save();

                $session->regenerateId();
                $session->set('username', $user->username, 'auth');
                $session->set('level', $user->level, 'auth');
                $session->set('user_agent', $_SERVER['HTTP_USER_AGENT'], 'auth');
                $session->set('ip', $_SERVER['REMOTE_ADDR'], 'auth');
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('success' => false));
            }
        }
    }

    public function logoutAction()
    {
        $this->_noRender = true;
        $session = Core_Session::getInstance();
        $session->destroy();
        $this->redirect(array('route' => 'route_admin'));
    }

}