<?php
session_start();
require_once("../config.php"); 
if($_SESSION['login']!=$adminLogin){
	die("It seems you're not logged in anymore. Flushing failed.");
}
$handle = fopen("../compress/compressed.css","w") or die("Can't flush cache of css files");
fclose($handle);
unlink("../compress/compressed.css")  or die("Can't flush cache of css files");
$handle = fopen("../compress/compressed.js","w") or die("Can't flush cache of javascript files");
fclose($handle);
unlink("../compress/compressed.js")  or die("Can't flush cache of javascript files");
echo "yes";
?>