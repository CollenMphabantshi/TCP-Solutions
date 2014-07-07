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
    
     public function __construct($sceneID = NULL,$victims = NULL){
	if($victims != NULL && $sceneID != NULL){
            for($i = 0; $i < count($victims);$i++){
                $v = new Victims($victims);
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
