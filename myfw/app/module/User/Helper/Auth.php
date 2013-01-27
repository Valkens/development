<?php
class User_Helper_Auth
{
    public static function hasIdentity()
    {
        $session = Core_Session::getInstance();

        if (($session->get('username', 'auth'))
            && ($session->get('user_agent', 'auth') == $_SERVER['HTTP_USER_AGENT'])
            && ($session->get('ip', 'auth') == $_SERVER['REMOTE_ADDR'])
        ) {
            return true;
        }

        return false;
    }

    public static function checkAuth($username, $password)
    {
        $userModel = new User_Model_User();
        $user = $userModel->fetch('*', 'WHERE `username`=:username', array(':username' => $username));

        if ($user) {
            foreach ($userModel->fields as $field) {
                $userModel->{$field} = $user->{$field};
            }

            return ($user->password == sha1($user->salt . $password)) ? $userModel : false;
        }

        return false;
    }

    public static function generatePassword($salt, $password)
    {
        return sha1($salt . $password);
    }

    public static function generateSalt()
    {
        return substr(sha1(mt_rand()), 0, 22);
    }
}