<?php
    session_start();
    require_once './encryptions.php';
    
    class PreventHijack{
        private $enc;
        public function __construct() {
            $this->enc = new Encryption();
        }

        public function isValidUser($page) {
            if(!empty($_SESSION[$this->enc->md5_encrypt('s_nomor')]) 
                    && ($_SESSION[$this->enc->md5_encrypt('s_ua')] === $this->enc->md5_encrypt($_SERVER['HTTP_USER_AGENT'])))
            {
                if($page === "admin" && $_SESSION[$this->enc->md5_encrypt('s_ac')] === $this->enc->md5_encrypt("1"))
                {
                    return TRUE;
                }
                else if($page === "fp" && $_SESSION[$this->enc->md5_encrypt('s_ac')] === $this->enc->md5_encrypt("2"))
                {
                    return TRUE;
                }else if($page === "student" && $_SESSION[$this->enc->md5_encrypt('s_ac')] === $this->enc->md5_encrypt("4")){
                    return TRUE;
                }else if($page === "afp" && $_SESSION[$this->enc->md5_encrypt('s_ac')] === $this->enc->md5_encrypt("6")){
                    return TRUE;
                }
            }
            
            return FALSE;
        }
    }
?>