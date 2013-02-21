<?php
class Core_Session
{
    private static $_session = null;

    public static function getInstance()
    {
        if (self::$_session === null) {
            self::$_session = new Core_Session();
        }

        return self::$_session;
    }

    public function __construct()
    {
        $this->start();
    }

    public function start()
    {
        if (!session_id()) {
            ini_set('session.use_cookies', 'On');
            ini_set('session.use_trans_sid', 'Off');

            session_set_cookie_params(0, '/');
            session_start();
        }
    }

    public function set($key, $value, $namespace = null)
    {
        if ($namespace) {
            $_SESSION[$namespace][$key] = $value;
        } else {
            $_SESSION[$key] = $value;
        }
    }

    public function get($key, $namespace = null)
    {
        if ($namespace) {
            return isset($_SESSION[$namespace][$key]) ? $_SESSION[$namespace][$key] : null;
        } else {
            return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
        }
    }

    public function delete($key, $namespace = null)
    {
        if ($namespace) {
            $_SESSION[$namespace][$key] = null;
        } else {
            $_SESSION[$key] = null;
        }
    }

    public function destroy()
    {
        session_destroy();
    }

    public function regenerateId($delOldSession = false)
    {
        session_regenerate_id($delOldSession);
    }

    public function generateToken($name = 'token', $new = false)
    {
        $token = $this->get($name);
        if (!$token || $new) {
            $token = sha1(uniqid(NULL, TRUE));

            // Store the new token
            $this->set($name, $token);
        }

        return $token;
    }

}