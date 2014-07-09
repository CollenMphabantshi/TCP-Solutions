<?php
require_once './connect.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SceneVictims
 *
 * @author BANCHI
 */
class SceneVictims {
    //put your code here
    private $sceneID;
    private $victimID;
    private $api;
     public function __construct($sceneID = NULL,$victims = NULL,$api){
         $this->api = $api;
	if($victims != NULL && $sceneID != NULL){
            $this->sceneID = $sceneID;
            for($i = 0; $i < count($victims);$i++){
                $v = new Victims($victims[$i],$api);
                $this->victimID = $v->addVictim();
                if($this->victimID != null)
                {
                    $this->addSceneVictim();
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add victim was denied. Duplication was detected.");
                    $this->api->response($this->api->json($error), 400);
                }
            }
        }
    }
    
    private function addSceneVictim() {
        $sv_res = mysql_query("insert into sceneVictims values(0,".$this->sceneID.",".$this->victimID.")");
    }
    
    public function getSceneVictims($sceneID) {
        $sv_res = mysql_query("select * from sceneVictims where sceneID=".$sceneID);
        $sv_array = array();
        while(($sv = mysql_fetch_array($sv_res))){
            $victim = new Victims();
            $sv_array[] = $victim->getVictim($sv['victimID']);;
            $sv_i++;
        }
        return $sv_array;
    }
    
    public function getVictimID() {
        return $this->victimID;
    }
}
