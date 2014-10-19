<?php
    error_reporting(E_ERROR | E_PARSE);
?>
<?php
    session_start();
    require_once './encryptions.php';
    $enc = new Encryption();
    if(!empty($_SESSION[$enc->md5_encrypt('s_nomor')])){
        if($_SESSION[$enc->md5_encrypt('s_ac')] === $enc->md5_encrypt("1")){
            // Admin page
            
            header("Location: /webapp/ControlPanel.php");
        }else if($_SESSION[$enc->md5_encrypt('s_ac')] === $enc->md5_encrypt("2")){
            // Forensic Practitioner page
            header("Location: /webapp/fpHome.php");
        }else if($_SESSION[$enc->md5_encrypt('s_ac')] === $enc->md5_encrypt("4")){
            // Student page
            header("Location: /webapp/studentHome.php");
        }
        else if($_SESSION[$enc->md5_encrypt('s_ac')] === $enc->md5_encrypt("6")){
            // Both Admin and FP page
            header("Location: /webapp/afpHome.php");
        }else{
            header("Location: /webapp/errorPage.php");
        }
    }else{
    	header("Location: /webapp/errorPage.php");
    }
?>
