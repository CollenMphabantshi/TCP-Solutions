<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Firearm
 *
 * @author BANCHI
 */
class Firearm extends Scene{
    //put your code here
    private $firearmIOType;
    private $signsOfStruggle;
    private $alcoholBottleAround;
    private $drugParaphernalia;
    private $gunshotWounds;
    private $gunshotWoundsLocation;
    private $gunshotWoundsArea;
    private $firearmOnScene;
    private $firearmCalibre;
    private $firedThroughObject;
    private $firearmUsed;
    private $cartridgesFound;
    private $howManyCartridgesFound;
    
     public function __construct($formData,$api){
         $this->api = $api;
	if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Firearm",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                $this->firearmIOType = $formData['object'][$i]['firearmIOType'];
                $this->signsOfStruggle = $formData['object'][$i]['signsOfStruggle'];
                $this->alcoholBottleAround = $formData['object'][$i]['alcoholBottleAround'];
                $this->drugParaphernalia = $formData['object'][$i]['drugParaphernalia'];
                $this->gunshotWounds = $formData['object'][$i]['gunshotWounds'];
                $this->gunshotWoundsLocation = $formData['object'][$i]['gunshotWoundsLocation'];
                $this->gunshotWoundsArea = $formData['object'][$i]['gunshotWoundsArea'];
                $this->firearmOnScene = $formData['object'][$i]['firearmOnScene'];                
                $this->firearmCalibre = $formData['object'][$i]['firearmCalibre'];
                $this->firedThroughObject = $formData['object'][$i]['firedThroughObject'];
                $this->firearmUsed = $formData['object'][$i]['firearmUsed'];
                $this->cartridgesFound = $formData['object'][$i]['cartridgesFound'];
                $this->howManyCartridgesFound = $formData['object'][$i]['howManyCartridgesFound'];
                    //
                $sceneID = $this->createScene();
                 if($sceneID == NULL){
                     $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                     $this->api->response($this->api->json($error), 400);
                 }
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
                echo "TEST: ".$formData['object'][$i]['victims']['victimInside'];
                if($formData['object'][$i]['victims']['victimInside'] == "yes"){
                    $this->addFirearm($sceneID,TRUE,$formData['object'][$i]);
                }else{
                    $this->addFirearm($sceneID,FALSE,null);
                }
            }
            
            
        }
        
    }
    
    private function addFirearm($sceneID,$inside,$object) {
        $f_res = mysql_query("insert into firearm values(0,$sceneID,'$this->firearmIOType','$this->signsOfStruggle','$this->alcoholBottleAround','$this->drugParaphernalia','$this->gunshotWounds','$this->gunshotWoundsLocation','$this->gunshotWoundsArea','$this->firearmOnScene','$this->firearmCalibre','$this->firedThroughObject','$this->firearmUsed','$this->cartridgesFound','$this->howManyCartridgesFound')");
        if($inside == TRUE){
            $h_res = mysql_query("select firearmID from firearm where sceneID=".$sceneID);
            $firearmID = mysql_result($h_res,0,'firearmID');
            $dl = $object['doorLocked'];
            $wc = $object['windowsClosed'];
            $wb = $object['windowsBroken'];
            $va = $object['victimAlone'];
            $pv = $object['peopleWithVictim'];
            if($va != "yes")
            {
                $hi_res = mysql_query("insert into firearmInside values(0,".$firearmID.",'$dl','$wc','$wb','$va','$pv')");
            }else{
                $hi_res = mysql_query("insert into firearmInside values(0,".$firearmID.",'$dl','$wc','$wb','$va',null)");
            }
        }
    }
    public function getAllFirearm() {
        try{
            
            $h_res = mysql_query("select * from firearm");
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
                $h_array['firearmID'] = $array['firearmID'];
                $h_array['sceneID'] = $array['sceneID'];
                $h_array['caseData'] = $this->case->getCaseByScene($h_array['sceneID']);
                $h_array['sceneData'] = $this->getSceneByID($h_array['sceneID']);
                $h_array['firearmIOType'] = $array['firearmIOType'];
                $h_array['signsOfStruggle'] = $array['signsOfStruggle'];
                $h_array['alcoholBottleAround'] = $array['alcoholBottleAround'];
                $h_array['drugParaphernalia'] = $array['drugParaphernalia'];
                $h_array['gunshotWounds'] = $array['gunshotWounds'];
                $h_array['gunshotWoundsLocation'] = $array['gunshotWoundsLocation'];
                $h_array['gunshotWoundsArea'] = $array['gunshotWoundsArea'];
                $h_array['firearmOnScene'] = $array['firearmOnScene'];
                $h_array['firearmCalibre'] = $array['firearmCalibre'];
                $h_array['firedThroughObject'] = $array['firedThroughObject'];
                $h_array['firearmUsed'] = $array['firearmUsed'];
                $h_array['cartridgesFound'] = $array['cartridgesFound'];
                $h_array['howManyCartridgesFound'] = $array['howManyCartridgesFound'];
                
                $hi_res = mysql_query("select * from firearmInside where firearmID=".$h_array['firearmID']);
                if(mysql_num_rows($hi_res) > 0)
                {
                    $hi_array = mysql_fetch_array($hi_res);
                    $h_array['firearmInside'] = $hi_array;
                }else{
                    $h_array['firearmInside'] = NULL;
                }
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
    
    public function getDataBySceneID($sceneID) {
        try{
            $enc = new Encryption();
            $h_res = mysql_query("select * from firearm where sceneID=".$sceneID);
            $h_array = mysql_fetch_array($h_res);
            $hi_res = mysql_query("select * from firearminside where firearmID=".$h_array['firearmID']);
                if(mysql_num_rows($hi_res) > 0)
                {
                    $hi_array = mysql_fetch_array($hi_res);
                    $hi_array['doorLocked'] = $enc->decrypt_request($hi_array['doorLocked']);
                    $hi_array['windowsClosed'] = $enc->decrypt_request($hi_array['windowsClosed']);
                    $hi_array['windowsBroken'] = $enc->decrypt_request($hi_array['windowsBroken']);
                    $hi_array['victimAlone'] = $enc->decrypt_request($hi_array['victimAlone']);
                    if($hi_array['peopleWithVictim'] !== NULL)
                    {
                        $hi_array['peopleWithVictim'] = $enc->decrypt_request($hi_array['peopleWithVictim']);
                    }else{
                        $hi_array['peopleWithVictim'] = "none";
                    }
                    $h_array['firearmInside'] = $hi_array;
                }else{
                    $h_array['firearmInside'] = "null";
                }
                
                $h_array['firearmIOType'] = $enc->decrypt_request($h_array['firearmIOType']);
                $h_array['signsOfStruggle'] = $enc->decrypt_request($h_array['signsOfStruggle']);
                $h_array['alcoholBottleAround'] = $enc->decrypt_request($h_array['alcoholBottleAround']);
                $h_array['drugParaphernalia'] = $enc->decrypt_request($h_array['drugParaphernalia']);
                $h_array['gunshotWounds'] = $enc->decrypt_request($h_array['gunshotWounds']);
                $h_array['gunshotWoundsLocation'] = $enc->decrypt_request($h_array['gunshotWoundsLocation']);
                $h_array['gunshotWoundsArea'] = $enc->decrypt_request($h_array['gunshotWoundsArea']);
                $h_array['firearmOnScene'] = $enc->decrypt_request($h_array['firearmOnScene']);
                $h_array['firearmCalibre'] = $enc->decrypt_request($h_array['firearmCalibre']);
                $h_array['firedThroughObject'] = $enc->decrypt_request($h_array['firedThroughObject']);
                $h_array['firearmUsed'] = $enc->decrypt_request($h_array['firearmUsed']);
                $h_array['cartridgesFound'] = $enc->decrypt_request($h_array['cartridgesFound']);
                $h_array['howManyCartridgesFound'] = $enc->decrypt_request($h_array['howManyCartridgesFound']);
            return $h_array;
        } catch (Exception $ex) {
            $error = array('status' => "Failed", "msg" => "No data found.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    public function getFirearm($firearmID) {
        try{
            
            $h_res = mysql_query("select * from firearm where firearmID=".$firearmID);
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
                $h_array['firearmID'] = $array['firearmID'];
                $h_array['sceneID'] = $array['sceneID'];
                $h_array['caseData'] = $this->case->getCaseByScene($h_array['sceneID']);
                $h_array['sceneData'] = $this->getSceneByID($h_array['sceneID']);
                $h_array['firearmIOType'] = $array['firearmIOType'];
                $h_array['signsOfStruggle'] = $array['signsOfStruggle'];
                $h_array['alcoholBottleAround'] = $array['alcoholBottleAround'];
                $h_array['drugParaphernalia'] = $array['drugParaphernalia'];
                $h_array['gunshotWounds'] = $array['gunshotWounds'];
                $h_array['gunshotWoundsLocation'] = $array['gunshotWoundsLocation'];
                $h_array['gunshotWoundsArea'] = $array['gunshotWoundsArea'];
                $h_array['firearmOnScene'] = $array['firearmOnScene'];
                $h_array['firearmCalibre'] = $array['firearmCalibre'];
                $h_array['firedThroughObject'] = $array['firedThroughObject'];
                $h_array['firearmUsed'] = $array['firearmUsed'];
                $h_array['cartridgesFound'] = $array['cartridgesFound'];
                $h_array['howManyCartridgesFound'] = $array['howManyCartridgesFound'];
                
                $hi_res = mysql_query("select * from firearmInside where firearmID=".$h_array['firearmID']);
                if(mysql_num_rows($hi_res) > 0)
                {
                    $hi_array = mysql_fetch_array($hi_res);
                    $h_array['firearmInside'] = $hi_array;
                }else{
                    $h_array['firearmInside'] = NULL;
                }
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
