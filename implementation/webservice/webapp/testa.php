<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once './encryptions.php';
$enc = new Encryption();

echo var_dump($_REQUEST);
echo '<br/>'.$enc->decrypt_request($_REQUEST['username']);
?>