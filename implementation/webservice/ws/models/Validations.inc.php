<?php

class Validations {
    public function validateUsername($param) {
        return true;
    }
    
    public function validateLogin($pass, $hashed_pass, $salt, $hash_method = 'sha1') {
        if(function_exists('hash') && in_array($hash_method, hash_algos())) {
            return ($hashed_pass === hash($hash_method, $salt . $pass));
        }
        return ($hashed_pass === sha1($salt . $pass));
    }
    
    public function randomSalt($p_len) {
        $randChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789`~!@#$%^&*()-=_+';
        $randCharsLen = strlen($randChars) - 1;
        $genStr = '';
        for ($i = 0; $i < $p_len; ++$i) {
            $genStr .= $randChars[rand(0, $randCharsLen)];
        }
        return $genStr;
    }
    
    public function createHash($string, $hash_method = 'sha1', $salt_length = 8){
         // generate random salt
        $salt = randomSalt($salt_length);
        if (function_exists('hash') && in_array($hash_method, hash_algos()) ){
            return hash($hash_method, $salt . $string);
        }
        return sha1($salt . $string);
    }
    
}
?>
