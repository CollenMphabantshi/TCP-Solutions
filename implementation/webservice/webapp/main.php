<?php
    error_reporting(E_ERROR | E_PARSE);
?>
<?php
    session_start();
    if(!empty($_SESSION[md5('s_nomor')])){
        if($_SESSION[md5('s_ac')] === md5("1")){
            // Admin page
            header("Location: /webapp/controlPanel.php");
        }else if($_SESSION[md5('s_ac')] === md5("2")){
            // Forensic Practitioner page
            header("Location: /webapp/fpHome.php");
        }else if($_SESSION[md5('s_ac')] === md5("6")){
            // Both Admin and FP page
            header("Location: /webapp/afpHome.php");
        }else{
            header("Location: /webapp/errorPage.php");
        }
    }
?>
