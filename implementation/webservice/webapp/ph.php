<?php
    session_start();
    class PreventHijack{
        public function isValidUser() {
            if(!empty($_SESSION[md5('s_nomor')]) 
                    && ($_SESSION[md5('s_ua')] === md5($_SERVER['HTTP_USER_AGENT'])))
            {
                
                return TRUE;   
            }
            echo session_encode();
            return FALSE;
        }
    }
?>