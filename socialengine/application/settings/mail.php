<?php defined('_ENGINE') or die('Access Denied'); return array (
  'class' => 'Zend_Mail_Transport_Smtp',
  'args' => 
  array (
    0 => 'smtp.gmail.com',
    1 => 
    array (
      'port' => 587,
      'ssl' => 'tls',
      'auth' => 'login',
      'username' => 'markzuckerberg.bi@gmail.com',
      'password' => 'thienthantuyet',
    ),
  ),
); ?>