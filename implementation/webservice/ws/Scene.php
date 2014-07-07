<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Scene
 *
 * @author BANCHI
 */

require_once './connect.php';
class Scene{
    //put your code here
    private $sceneType;
    private $time;
    private $date;
    private $location;
    private $temperature;
    private $investigatingOfficerName;
    private $investigatingOfficerRank;
    private $investigatingOfficerCellNo;
    private $firstOfficerOnSceneName;
    private $firstOfficerOnSceneRank;
    public $case;
    public $sceneVictim;
     
    public function __construct($_time,$_type,$_date,$_location,$_temperature,$_investigatingOfficerName,$_investigatingOfficerRank
            ,$_investigatingOfficerCellNo,$_firstOfficerOnSceneName,$_firstOfficerOnSceneRank){
                if($_time != null && $_type != null && $_firstOfficerOnSceneRank != null)
                {
                    $this->sceneType = $_type;
                    $this->time = $_time;
                    $this->date = $_date;
                    $this->location = $_location;
                    $this->temperature = $_temperature;
                    $this->investigatingOfficerName = $_investigatingOfficerName;
                    $this->investigatingOfficerRank = $_investigatingOfficerRank;
                    $this->investigatingOfficerCellNo = $_investigatingOfficerCellNo;
                    $this->firstOfficerOnSceneName = $_firstOfficerOnSceneName;
                    $this->firstOfficerOnSceneRank = $_firstOfficerOnSceneRank;
                }
                $this->case = new Cases();
                $this->sceneVictim = new SceneVictims();
    }
    
    public function createScene() {
        if($this->isEmpty())return null;
        $st_res = mysql_query("select sceneTypeID from sceneType where sceneTypeDescription='$this->sceneType'");
        $st_array = mysql_fetch_array($st_res);
        
        $query = "insert into scene(sceneType,sceneTime,sceneDate,sceneLocation,sceneTemparature,investigatingOfficerName,investigatingOfficerRank"
                . "investigatingOfficerCellNo,firstOfficerOnSceneName,firstOfficerOnSceneRank) values(".$st_array['sceneTypeID'].","
                . "'$this->time','$this->date','$this->location','$this->temperature','$this->investigatingOfficerName','$this->investigatingOfficerRank','$this->investigatingOfficerCellNo','$this->firstOfficerOnSceneName','$this->firstOfficerOnSceneRank')"; 
        
        $scene_res = mysql_query($query);
        $scene_res = mysql_query("select * from scene where sceneLocation='$this->location'");
        $scene_array = mysql_fetch_array($scene_res);
        
        return $scene_array['sceneID'];
    }
    public function getScene() {
        if($this->isEmpty())return null;
        
        $scene_array = array();
        $scene_array['sceneType'] = $this->sceneType;
        $scene_array['time'] = $this->time;
        $scene_array['date'] = $this->date;
        $scene_array['location'] = $this->location;
        $scene_array['temperature'] = $this->temperature;
        $scene_array['investigatingOfficerName'] = $this->investigatingOfficerName;
        $scene_array['investigatingOfficerRank'] = $this->investigatingOfficerRank;
        $scene_array['investigatingOfficerCellNo'] = $this->investigatingOfficerCellNo;
        $scene_array['firstOfficerOnSceneName'] = $this->firstOfficerOnSceneName;
        $scene_array['firstOfficerOnSceneRank'] = $this->firstOfficerOnSceneRank;
        return $scene_array;
    }
    
    public function getSceneByID($sceneID) {
        //if($this->isEmpty())return null;
        $scene_res = mysql_query("select * from scene where sceneID=".$sceneID);
        $scene_array = mysql_fetch_array($scene_res);
        
        $this->sceneType = $scene_array['sceneType'];
        $this->time = $scene_array['sceneTime'];
        $this->date = $scene_array['sceneDate'];
        $this->location = $scene_array['sceneLocation'];
        $this->temperature = $scene_array['sceneTemperature'];
        $this->investigatingOfficerName = $scene_array['sceneInvestigatingOfficerName'];
        $this->investigatingOfficerRank = $scene_array['sceneInvestigatingOfficerRank'];
        $this->investigatingOfficerCellNo = $scene_array['investigatingOfficerCellNo'];
        $this->firstOfficerOnSceneName = $scene_array['firstOfficerOnSceneName'];
        $this->firstOfficerOnSceneRank = $scene_array['firstOfficerOnSceneRank'];
        return $scene_array;
    }
    
    public function setVictim($sceneID,$victims){
        $this->sceneVictim = new SceneVictims($sceneID,$victims);
    }
    
    public function setCase($sceneID,$FOPersonelNumber) {
        $this->case = new Cases($sceneID,$FOPersonelNumber);
    }
    public function isEmpty() {
        return $this->time == "";
    }
    
}
