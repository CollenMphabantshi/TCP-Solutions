<?php
class Secure{
    
    public function json($data)
    {
        if(is_array($data)){
            return json_encode($data);
        }
    }
    
    public function response($param) {
        die($param);
    }
}

$secure = new Secure();

?>