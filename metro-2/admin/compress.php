<?php
header('Content-type: text/css');
header('Cache-Control: public');// Enable caching
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT');// Expire in one day

// Set the correct MIME type, because Apache won't set it for us
header("Content-type: text/css");
  ob_start("compress");
  function compress($buffer) {
    /* remove comments */
    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
    /* remove tabs, spaces, newlines, etc. */
    $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
    return $buffer;
  }
	
  /* your css files */
  include('css/main.css');
  include('css/tiles.css');
  ob_end_flush();
?>   