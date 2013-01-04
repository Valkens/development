<?php
defined('_ENGINE') or die('Access Denied');
return array (
  'default_backend' => 'File',
  'frontend' => 
  array (
    'core' => 
    array (
      'automatic_serialization' => true,
      'cache_id_prefix' => 'Engine4_',
      'lifetime' => '60',
      'caching' => false,
    ),
  ),
  'backend' => 
  array (
    'File' => 
    array (
      'file_locking' => true,
      'cache_dir' => 'D:/localhost/development/socialengine/temporary/cache',
    ),
  ),
  'default_file_path' => 'D:/localhost/development/socialengine/temporary/cache',
); ?>