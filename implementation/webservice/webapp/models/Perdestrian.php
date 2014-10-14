<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Perdestrian
 *
 * @author BANCHI
 */
class Perdestrian extends Scene{
    //put your code here
    private $perdestrianOutsideType;
    private $hitAndRun;
    private $pedestrianType;
    private $numberOfCarsDroveOverBody;
    private $weatherType;
    private $weatherCondition;
    private $typeOfCar;
    private $anyWitnesses;
    private $bodyMoved;
    private $victimJumped;
    private $anyStrangeCircumstances;
    
      public function __construct($formData,$api){
        $this->api = $api;
        if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Pedestrian vehicle accident",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
               
                $this->perdestrianOutsideType = $formData['object'][$i]['perdestrianOutsideType'];
                $this->hitAndRun = $formData['object'][$i]['hitAndRun'];
                $this->pedestrianType = $formData['object'][$i]['pedestrianType'];
                $this->numberOfCarsDroveOverBody = $formData['object'][$i]['numberOfCarsDroveOverBody'];
                $this->weatherType = $formData['object'][$i]['weatherType'];
                $this->weatherCondition = $formData['object'][$i]['weatherCondition'];
                $this->typeOfCar = $formData['object'][$i]['typeOfCar'];
                $this->anyWitnesses = $formData['object'][$i]['anyWitnesses'];
                $this->bodyMoved = $formData['object'][$i]['bodyMoved'];
                $this->victimJumped = $formData['object'][$i]['victimJumped'];
                $this->anyStrangeCircumstances = $formData['object'][$i]['anyStrangeCircumstances'];
                
                    //
                $sceneID = $this->createScene();
                
                 if($sceneID == NULL){
                     $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                     $this->api->response($this->api->json($error), 400);
                 }
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
				$this->addPedestrian($sceneID);
                
            }
            
            
        }
        
    }
    
    private function addPedestrian($sceneID) {
        
            $h_res = mysql_query("insert into pedestrian values(0,"
            .$sceneID.",'$this->perdestrianOutsideType','$this->hitAndRun','$this->pedestrianType','$this->numberOfCarsDroveOverBody','$this->weatherType','$this->weatherCondition','$this->typeOfCar','$this->anyWitnesses','$this->bodyMoved','$this->victimJumped','$this->anyStrangeCircumstances')");
			
			 if($h_res == FALSE){
            $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    public function getAllPedestrian() {
        try{
            
            $h_res = mysql_query("select * from pedestrian");
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
                $h_array['perdestrianID'] = $array['perdestrianID'];
                $h_array['sceneID'] = $array['sceneID'];
                $h_array['caseData'] = $this->case->getCaseByScene($h_array['sceneID']);
                $h_array['sceneData'] = $this->getSceneByID($h_array['sceneID']);
                $h_array['perdestrianOutsideType'] = $array['perdestrianOutsideType'];
                $h_array['hitAndRun'] = $array['hitAndRun'];
                $h_array['pedestrianType'] = $array['pedestrianType'];
                $h_array['numberOfCarsDroveOverBody'] = $array['numberOfCarsDroveOverBody'];
                $h_array['weatherType'] = $array['weatherType'];
                $h_array['weatherCondition'] = $array['weatherCondition'];
                $h_array['typeOfCar'] = $array['typeOfCar'];
                $h_array['anyWitnesses'] = $array['anyWitnesses'];
                $h_array['bodyMoved'] = $array['bodyMoved'];
                $h_array['victimJumped'] = $array['victimJumped'];
                $h_array['anyStrangeCircumstances'] = $array['anyStrangeCircumstances'];
                
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
            
            $error = array('status' => "Failed", "msg" => "Request to get pedestrian scenes was denied.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    
    public function getDataBySceneID($sceneID) {
        try{
            $enc = new Encryption();
            $h_res = mysql_query("select * from pedestrian where sceneID=".$sceneID);
            $h_array = mysql_fetch_array($h_res);
            
            $h_array['perdestrianOutsideType'] = $enc->decrypt_request($h_array['perdestrianOutsideType']);
                $h_array['hitAndRun'] = $enc->decrypt_request($h_array['hitAndRun']);
                $h_array['pedestrianType'] = $enc->decrypt_request($h_array['pedestrianType']);
                $h_array['numberOfCarsDroveOverBody'] = $enc->decrypt_request($h_array['numberOfCarsDroveOverBody']);
                $h_array['weatherType'] = $enc->decrypt_request($h_array['weatherType']);
                $h_array['weatherCondition'] = $enc->decrypt_request($h_array['weatherCondition']);
                $h_array['typeOfCar'] = $enc->decrypt_request($h_array['typeOfCar']);
                $h_array['anyWitnesses'] = $enc->decrypt_request($h_array['anyWitnesses']);
                $h_array['bodyMoved'] = $enc->decrypt_request($h_array['bodyMoved']);
                $h_array['victimJumped'] = $enc->decrypt_request($h_array['victimJumped']);
                $h_array['anyStrangeCircumstances'] = $enc->decrypt_request($h_array['anyStrangeCircumstances']);
            
            return $h_array;
        } catch (Exception $ex) {
            $error = array('status' => "Failed", "msg" => "No data found.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    
    public function getPedestrian($perdestrianID) {
        try{
            
            $h_res = mysql_query("select * from pedestrian where perdestrianID=".$perdestrianID);
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
                $h_array['perdestrianID'] = $array['perdestrianID'];
                $h_array['sceneID'] = $array['sceneID'];
                $h_array['caseData'] = $this->case->getCaseByScene($h_array['sceneID']);
                $h_array['sceneData'] = $this->getSceneByID($h_array['sceneID']);
                $h_array['perdestrianOutsideType'] = $array['perdestrianOutsideType'];
                $h_array['hitAndRun'] = $array['hitAndRun'];
                $h_array['pedestrianType'] = $array['pedestrianType'];
                $h_array['numberOfCarsDroveOverBody'] = $array['numberOfCarsDroveOverBody'];
                $h_array['weatherType'] = $array['weatherType'];
                $h_array['weatherCondition'] = $array['weatherCondition'];
                $h_array['typeOfCar'] = $array['typeOfCar'];
                $h_array['anyWitnesses'] = $array['anyWitnesses'];
                $h_array['bodyMoved'] = $array['bodyMoved'];
                $h_array['victimJumped'] = $array['victimJumped'];
                $h_array['anyStrangeCircumstances'] = $array['anyStrangeCircumstances'];
                
               
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
            
            $error = array('status' => "Failed", "msg" => "Request to get pedestrian scene was denied.");
            $this->api->response($this->api->json($error), 400);
        }
    }
}
