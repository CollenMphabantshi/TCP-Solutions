<?php
    class Encryption{
        
        private $key = 'n53*&^FDBdjk bduyg5%^UDG&E*8k!kn';
        private $saltUnknown;
        private $iv = 'mi349nTHNIndfqnd';
        public function __construct() {
            $this->saltUnknown = "dmC7;d24fqz!9kgwh";
            
            // generate random iv
            
        }

        public function md5_encrypt($param){
            return md5($param.$param.$this->saltUnknown);
            //return md5($param);
        }
        



    public function encrypt_request($req) {
        if($req != NULL)
        {
            $td = mcrypt_module_open('rijndael-128', '', 'cbc', $this->iv);
            mcrypt_generic_init($td, $this->key, $this->iv);
            $newCipher = mcrypt_generic($td, $req);
            mcrypt_generic_deinit($td);
            mcrypt_module_close($td);
            return bin2hex($newCipher);
        }
        return NULL;
    }
    public function decrypt_request($req) {
        if($req != NULL)
        {
            $req = $this->hex2bin($req);
            $td = mcrypt_module_open('rijndael-128', '', 'cbc', $this->iv);
             mcrypt_generic_init($td, $this->key, $this->iv);
            $newClear = mdecrypt_generic($td, $req);
            mcrypt_generic_deinit($td);
            mcrypt_module_close($td);
            return utf8_encode(trim($newClear));
        }
        return NULL;
    }
    
    public function hex2bin($hexData) {
        $binData = '';
        for($i = 0; $i < strlen($hexData);$i+=2)
        {
            $binData .= chr(hexdec(substr($hexData, $i, 2)));
        }
        return $binData;
    }

}
?>
