<?php
require_once("Scene.php");
require_once './ScenePhotos.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Aviation
 *
 * @author BANCHI
 */
class Aviation extends Scene{
    //put your code here
    private $aviationOType;
    private $aircraftType;
    private $aircraftNumPeople;
    private $victimType;
    private $victimInfo;
    private $weatherCondition;
    private $weatherType;
    public $images;
     public function __construct($formData,$api){
         $this->api = $api;
         if($formData == NULL)
        {
            parent::__construct(null,null,"","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Aviation accident",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                $this->aviationOType = $formData['object'][$i]['aviationOType'];
                $this->aircraftType = $formData['object'][$i]['aircraftType'];
                $this->aircraftNumPeople = $formData['object'][$i]['aircraftNumPeople'];
                $this->victimType = $formData['object'][$i]['victimType'];
                $this->victimInfo = $formData['object'][$i]['victimInfo'];
                $this->weatherCondition = $formData['object'][$i]['weatherCondition'];
                $this->weatherType = $formData['object'][$i]['weatherType'];
                
				$this->images = $formData['object'][$i]['images'][0];
                $sceneID = $this->createScene();
                 if($sceneID == NULL){
                     $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                     $this->api->response($this->api->json($error), 400);
                 }
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
                $this->addAviation($sceneID);
                
            }
            
            
        }
    }
    private function addAviation($sceneID) {
     
            $h_res = mysql_query("insert into aviation values(0,$sceneID,"
                    . "'$this->aviationOType',"
                    . "'$this->aircraftType',"
                    . "'$this->aircraftNumPeople',"
                    . "'$this->victimType',"
                    . "'$this->victimInfo',"
                    . "'$this->weatherCondition',"
                    . "'$this->weatherType')");
        
            if($h_res === FALSE){
                $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                $this->api->response($this->api->json($error), 400);
            }
        
            $scenePhoto = new ScenePhotos($this->api);
        
        
            for($i = 0; $i < count($this->images);$i++)
            {
                $scenePhoto->upload($this->images['names'.$i], $this->images['data'.$i], $sceneID);
            }
            $error = array('status' => "Success", "msg" => "Request to create a scene was successful.");
            $this->api->response($this->api->json($error), 400);
                
            /*$h_res = mysql_query("select * from aviation where sceneID=".$sceneID);
            $aviationID = mysql_result($h_res,0,'aviationID');*/
            
        
    }
    public function getAllAviation() {
        try{
            
            $h_res = mysql_query("select * from aviation");
            $h_rows = mysql_num_rows($h_res);
            $h_i = 0;
            $sv_i = 0;
            $v_i = 0;
            $h_array = array();
            $f_array = array();
            $final_array = array();
            $sv_array = array();
            while(($array = mysql_fetch_array($h_res)))
            {
                $h_i++;
                $h_array['aviationID'] = $array['aviationID'];
                $h_array['sceneID'] = $array['sceneID'];
                $h_array['caseData'] = $this->case->getCaseByScene($h_array['sceneID']);
                $h_array['sceneData'] = $this->getSceneByID($h_array['sceneID']);
                $h_array['aviationOType'] = $array['aviationOType'];
                $h_array['aircraftType'] = $array['aircraftType'];
                $h_array['aircraftNumPeople'] = $array['aircraftNumPeople'];
                $h_array['weatherCondition'] = $array['weatherCondition'];
                $h_array['weatherType'] = $array['weatherType'];
                          
                $tmp = $this->sceneVictim->getSceneVictims($h_array['sceneID']);
                $v_i = $v_i + count($tmp);
                $sv_array[] = $tmp;
            }
            
            $final_array['victims'] = $sv_array;
            $final_array['objectlist'] = $f_array;
            $final_array['count'] = $h_i;
            $final_array['victimNumber'] = $v_i;
            return $final_array;
        }catch(Exception $ex){
            
            $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    public function getDataBySceneID($sceneID) {
        try{
            $enc = new Encryption();
            $h_res = mysql_query("select * from aviation where sceneID=".$sceneID);
            $h_array = mysql_fetch_array($h_res);
            
            $h_array['aviationOType'] = $enc->decrypt_request($h_array['aviationOType']);
            $h_array['aircraftType'] = $enc->decrypt_request($h_array['aircraftType']);
            $h_array['aircraftNumPeople'] = $enc->decrypt_request($h_array['aircraftNumPeople']);
            $h_array['victimType'] = $enc->decrypt_request($h_array['victimType']);
            $h_array['victimInfo'] = $enc->decrypt_request($h_array['victimInfo']);
            $h_array['weatherCondition'] = $enc->decrypt_request($h_array['weatherCondition']);
            $h_array['weatherType'] = $enc->decrypt_request($h_array['weatherType']);
            $sp = new ScenePhotos($this->api);
                $files = $sp->getPhotos($sceneID);
                if($files !== NULL)
                {
                    $h_array['photos'] = $files;
                }else{
                    $h_array['photos'] = "unavailable";
                }
            return $h_array;
        } catch (Exception $ex) {
            $error = array('status' => "Failed", "msg" => "No data found.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    public function getAviation($aviationID) {
        try{
            
            $h_res = mysql_query("select * from aviation where aviationID=".$aviationID);
            $h_rows = mysql_num_rows($h_res);
            $h_i = 0;
            $sv_i = 0;
            $v_i = 0;
            $h_array = array();
            $f_array = array();
            $final_array = array();
            $sv_array = array();
            while(($array = mysql_fetch_array($h_res)))
            {
                $h_i++;
                $h_array['aviationID'] = $array['aviationID'];
                $h_array['sceneID'] = $array['sceneID'];
                $h_array['caseData'] = $this->case->getCaseByScene($h_array['sceneID']);
                $h_array['sceneData'] = $this->getSceneByID($h_array['sceneID']);
                $h_array['aviationOType'] = $array['aviationOType'];
                $h_array['aircraftType'] = $array['aircraftType'];
                $h_array['aircraftNumPeople'] = $array['aircraftNumPeople'];
                $h_array['victimType'] = $array['victimType'];
                $h_array['victimInfo'] = $array['victimInfo'];
                $h_array['weatherCondition'] = $array['weatherCondition'];
                $h_array['weatherType'] = $array['weatherType'];
                
                
                $f_array[] = $h_array; 
                
                
                $tmp = $this->sceneVictim->getSceneVictims($h_array['sceneID']);
                $v_i = $v_i + count($tmp);
                $sv_array[] = $tmp;
            }
            
            $final_array['victims'] = $sv_array;
            $final_array['objectlist'] = $f_array;
            $final_array['count'] = $h_i;
            $final_array['victimNumber'] = $v_i;
            return $final_array;
        }catch(Exception $ex){
            
            $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
            $this->api->response($this->api->json($error), 400);
        }
    }

}
