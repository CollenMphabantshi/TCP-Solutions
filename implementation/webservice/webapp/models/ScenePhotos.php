<?php
require_once './connect.php';
require_once '../encryptions.php';
class ScenePhotos{
    private $api;
    public function __construct($api) {
        $this->api = $api;
    }
    public function upload($name,$file,$sceneID) {
        
        if($name !== NULL && $file !== NULL && $sceneID !== NULL){
            $h_res = mysql_query("insert into scenePhotos values(0,$sceneID,'$name','$file')");
            
            if($h_res === FALSE){
                $error = array('status' => "Failed", "msg" => "Request to add photos was denied.");
                $this->api->response($this->api->json($error), 400);
            }
            return true;
            
        }else{
            return false;
        }
    }
}
?>