<?php
error_reporting (E_ALL ^ E_WARNING);
$fn = "file.txt"; 
$file = fopen($fn, "a+"); 
ftruncate($file,0);
fclose($file);

header('Location: home.php');

?>