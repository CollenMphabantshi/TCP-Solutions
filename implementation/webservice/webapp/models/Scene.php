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
require_once '../encryptions.php';
require_once './Audit.php';
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
    public $api;
    private $enc;
    public function __construct($_time,$_type,$_date,$_location,$_temperature,$_investigatingOfficerName,$_investigatingOfficerRank
            ,$_investigatingOfficerCellNo,$_firstOfficerOnSceneName,$_firstOfficerOnSceneRank,$api){
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
                $this->enc = new Encryption();
                $this->api = $api;
                $this->case = new Cases(null,null,$this->api);
                $this->sceneVictim = new SceneVictims(null,null, $this->api);
    }
    
    public function createScene() {
        
        if($this->isEmpty())return null;
        
        $scene_res = mysql_query("select * from scene where sceneLocation='$this->location' and (sceneTime='$this->time' and sceneDate='$this->date')");
        
        if(mysql_num_rows($scene_res) <= 0)
        {
            
            $st_res = mysql_query("select * from sceneType where sceneTypeDescription='$this->sceneType'");
            $st_array = mysql_fetch_array($st_res);
            
            $stype = $st_array['sceneTypeID'];
            
            $query = "insert into scene values(0,$stype,'$this->time','$this->date','$this->location','$this->temperature','$this->investigatingOfficerName','$this->investigatingOfficerRank','$this->investigatingOfficerCellNo','$this->firstOfficerOnSceneName','$this->firstOfficerOnSceneRank')"; 
            
            $scene_res = mysql_query($query);
            
             
            $scene_res = mysql_query("select * from scene where sceneLocation='$this->location' and sceneTime='$this->time' and sceneDate='$this->date'");
            $scene_array = mysql_fetch_array($scene_res);

            return $scene_array['sceneID'];
        }else{
            $error = array('status' => "Failed", "msg" => "Request to add scene was denied. Duplication was detected.");
            $this->api->response($this->api->json($error), 400);
        }
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
        if($scene_res === TRUE)
        {
            
            $m_arr = $scene_array;
            Audit::audit_log($this->enc->decrypt_request($_SESSION[$this->enc->md5_encrypt('s_nomor')]), "Requested to view a case. DATA: ".  var_dump($m_arr));
        }
        if(empty($_SESSION[$this->enc->md5_encrypt('s_nomor')]))
        {
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
        }else{
            
           $scene_array['sceneType'] = $this->enc->decrypt_request($scene_array['sceneType']);
           $scene_array['sceneTime'] = $this->enc->decrypt_request($scene_array['sceneTime']);
           $scene_array['sceneDate'] = $this->enc->decrypt_request($scene_array['sceneDate']);
           $scene_array['sceneLocation'] = $this->enc->decrypt_request($scene_array['sceneLocation']);
           $scene_array['sceneTemparature'] = $this->enc->decrypt_request($scene_array['sceneTemparature']);
           $scene_array['sceneInvestigatingOfficerName'] = $this->enc->decrypt_request($scene_array['sceneInvestigatingOfficerName']);
           $scene_array['sceneInvestigatingOfficerRank'] = $this->enc->decrypt_request($scene_array['sceneInvestigatingOfficerRank']);
           $scene_array['sceneInvestigatingOfficerCellNumber'] = $this->enc->decrypt_request($scene_array['sceneInvestigatingOfficerCellNumber']);
           $scene_array['firstOfficerOnSceneName'] = $this->enc->decrypt_request($scene_array['firstOfficerOnSceneName']);
           $scene_array['firstOfficerOnSceneRank'] = $this->enc->decrypt_request($scene_array['firstOfficerOnSceneRank']);
           
           $this->sceneType =  $scene_array['sceneType'];
            $this->time = $scene_array['sceneTime'];
            $this->date = $scene_array['sceneDate'];
            $this->location = $scene_array['sceneLocation'];
            $this->temperature = $scene_array['sceneTemperature'];
            $this->investigatingOfficerName = $scene_array['sceneInvestigatingOfficerName'];
            $this->investigatingOfficerRank = $scene_array['sceneInvestigatingOfficerRank'];
            $this->investigatingOfficerCellNo = $scene_array['investigatingOfficerCellNo'];
            $this->firstOfficerOnSceneName = $scene_array['firstOfficerOnSceneName'];
            $this->firstOfficerOnSceneRank = $scene_array['firstOfficerOnSceneRank'];
        }
        return $scene_array;
    }
    
    
    public function setVictim($sceneID,$victims){
        $this->sceneVictim = new SceneVictims($sceneID,$victims,$this->api);
    }
    
    public function setCase($sceneID,$FOPersonelNumber) {
        $this->case = new Cases($sceneID,$FOPersonelNumber,$this->api);
    }
    
    public function getSceneVictim($sceneID) {
        $this->sceneVictim = new SceneVictims();
        return $this->sceneVictim->getSceneVictims($sceneID);
    }
    
    public function getSceneTypeData($sceneID) {
        
    }
    public function isEmpty() {
        return $this->time === "";
    }
    
}
