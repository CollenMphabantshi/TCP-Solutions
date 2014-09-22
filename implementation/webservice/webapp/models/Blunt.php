<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Blunt
 *
 * @author BANCHI
 */
class Blunt extends Scene{
    private $bluntIOType;
    private $bluntForceObjectSuspected;
    private $bluntForceObjectStillOnScene;
    private $signsOfStruggle;
    private $alcoholBottleAround;
    private $drugParaphernalia;
    private $wasCommunityAssult;
    private $strangulationSuspected;
    private $smotheringSuspected;
    private $chockingSuspected;
    private $injuriesConcentratedOn;
    private $injuriesMainlyOn;
    
    public function __construct($formData,$api){
        
        if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Blunt force injury/ assault",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
               
                $this->bluntIOType = $formData['object'][$i]['bluntIOType'];
                $this->bluntForceObjectSuspected = $formData['object'][$i]['bluntForceObjectSuspected'];
                $this->bluntForceObjectStillOnScene = $formData['object'][$i]['bluntForceObjectStillOnScene'];
                $this->signsOfStruggle = $formData['object'][$i]['signsOfStruggle'];
                $this->alcoholBottleAround = $formData['object'][$i]['alcoholBottleAround'];
                $this->drugParaphernalia = $formData['object'][$i]['drugParaphernalia'];
                $this->wasCommunityAssult = $formData['object'][$i]['wasCommunityAssult'];
                $this->strangulationSuspected = $formData['object'][$i]['strangulationSuspected'];
                $this->smotheringSuspected = $formData['object'][$i]['smotheringSuspected'];
                $this->chockingSuspected = $formData['object'][$i]['chockingSuspected'];
                $this->injuriesConcentratedOn = $formData['object'][$i]['injuriesConcentratedOn'];
                $this->injuriesMainlyOn = $formData['object'][$i]['injuriesMainlyOn'];
                
                if(count($formData['object'][$i]['victims']) >= 1)
                {
                    $sceneID = $this->createScene();

                    if($sceneID == NULL){
                         $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                         $this->api->response($this->api->json($error), 400);
                     }
                    $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                    $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);

                $enc = new Encryption();
                $vinside = $enc->decrypt_request($formData['object'][$i]['victims'][0]['victimInside']);
                if($vinside === "Yes"){
                        $this->addBlunt($sceneID,TRUE,$formData['object'][$i]);
                    }else{
                        $this->addBlunt($sceneID,FALSE,null);
                    }
                }else {
                    $error = array('status' => "Failed", "msg" => "Request to add blunt case was deied.");
                    $this->api->response($this->api->json($error), 400);
                }
            }
            
            
        }
        
    }
    
    private function addBlunt($sceneID,$inside,$object) {
        $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
        
        $h_res = mysql_query("insert into blunt values(0,".$sceneID.",'$this->bluntIOType','$this->bluntForceObjectSuspected','$this->bluntForceObjectStillOnScene','$this->signsOfStruggle','$this->alcoholBottleAround','$this->drugParaphernalia','$this->wasCommunityAssult','$this->strangulationSuspected','$this->smotheringSuspected','$this->chockingSuspected','$this->injuriesConcentratedOn','$this->injuriesMainlyOn')")
                or $this->api->response($this->api->json($error), 400);
        
        if($inside == TRUE){
            $h_res = mysql_query("select * from blunt where sceneID=".$sceneID) or $this->api->response($this->api->json($error), 400) ;
            $bluntID = mysql_result($h_res,0,'bluntID');
            $enc = new Encryption();
            $dl = $object['doorLocked'];
            $wc = $object['windowsClosed'];
            $wb = $object['windowsBroken'];
            $va = $object['victimAlone'];
            $pv = $object['peopleWithVictim'];
            if($enc->decrypt_request($va) != "yes")
            {
                $hi_res = mysql_query("insert into bluntInside values(0,".$bluntID.",'$dl','$wc','$wb','$va','$pv')") or $this->api->response($this->api->json($error), 400);
            }else{
                $hi_res = mysql_query("insert into bluntinside values(0,".$bluntID.",'$dl','$wc','$wb','$va',null)") or $this->api->response($this->api->json($error), 400);
            }
        }
        $error = array('status' => "Success", "msg" => "Request to add case was successful.");
        $this->api->response($this->api->json($error), 400);
    }
    public function getAllBlunts() {
        try{
            $error = array('status' => "Failed", "msg" => "Request to view cases was denied.");
            $h_res = mysql_query("select * from blunt") or $this->api->response($this->api->json($error), 400);
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
                $h_array['bluntID'] = $array['bluntID'];
                $h_array['sceneID'] = $array['sceneID'];
                $h_array['caseData'] = $this->case->getCaseByScene($h_array['sceneID']);
                $h_array['sceneData'] = $this->getSceneByID($h_array['sceneID']);
                $h_array['bluntIOType'] = $array['bluntIOType'];
                $h_array['bluntForceObjectSuspected'] = $array['bluntForceObjectSuspected'];
                $h_array['bluntForceObjectStillOnScene'] = $array['bluntForceObjectStillOnScene'];
                $h_array['signsOfStruggle'] = $array['signsOfStruggle'];
                $h_array['alcoholBottleAround'] = $array['alcoholBottleAround'];
                $h_array['drugParaphernalia'] = $array['drugParaphernalia'];
                $h_array['wasCommunityAssult'] = $array['wasCommunityAssult'];
                $h_array['strangulationSuspected'] = $array['strangulationSuspected'];
                $h_array['smotheringSuspected'] = $array['smotheringSuspected'];
                $h_array['chockingSuspected'] = $array['chockingSuspected'];
                $h_array['injuriesConcentratedOn'] = $array['injuriesConcentratedOn'];
                $h_array['injuriesMainlyOn'] = $array['injuriesMainlyOn'];
                
                $hi_res = mysql_query("select * from bluntInside where bluntID=".$h_array['bluntID']) or $this->api->response($this->api->json($error), 400);
                if(mysql_num_rows($hi_res) > 0)
                {
                    $hi_array = mysql_fetch_array($hi_res);
                    $h_array['bluntInside'] = $hi_array;
                }else{
                    $h_array['bluntInside'] = NULL;
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
            
            $error = array('status' => "Failed", "msg" => "Request to get blunt scenes was denied.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    
    public function getDataBySceneID($sceneID) {
        try{
            $enc = new Encryption();
            $h_res = mysql_query("select * from blunt where sceneID=".$sceneID);
            $h_array = mysql_fetch_array($h_res);
            $hi_res = mysql_query("select * from bluntinside where bluntID=".$h_array['bluntID']);
                if(mysql_num_rows($hi_res) > 0)
                {
                    $hi_array = mysql_fetch_array($hi_res);
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
                    $h_array['bluntInside'] = $hi_array;
                }else{
                    $h_array['bluntInside'] = NULL;
                }
                $h_array['bluntIOType'] = $enc->decrypt_request($h_array['bluntIOType']);
                $h_array['bluntForceObjectSuspected'] = $enc->decrypt_request($h_array['bluntForceObjectSuspected']);
                $h_array['bluntForceObjectStillOnScene'] = $enc->decrypt_request($h_array['bluntForceObjectStillOnScene']);
                $h_array['wasCommunityAssult'] = $enc->decrypt_request($h_array['wasCommunityAssult']);
                $h_array['signsOfStruggle'] = $enc->decrypt_request($h_array['signsOfStruggle']);
                $h_array['alcoholBottleAround'] = $enc->decrypt_request($h_array['alcoholBottleAround']);
                $h_array['drugParaphernalia'] = $enc->decrypt_request($h_array['drugParaphernalia']);
                $h_array['strangulationSuspected'] = $enc->decrypt_request($h_array['strangulationSuspected']);
                $h_array['smotheringSuspected'] = $enc->decrypt_request($h_array['smotheringSuspected']);
                $h_array['chockingSuspected'] = $enc->decrypt_request($h_array['chockingSuspected']);
                $h_array['injuriesConcentratedOn'] = $enc->decrypt_request($h_array['injuriesConcentratedOn']);
                $h_array['injuriesMainlyOn'] = $enc->decrypt_request($h_array['injuriesMainlyOn']);
            return $h_array;
        } catch (Exception $ex) {
            $error = array('status' => "Failed", "msg" => "No data found.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    public function getBlunt($bluntID) {
        try{
            
            $h_res = mysql_query("select * from blunt where bluntID=".$bluntID);
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
                $h_array['bluntID'] = $array['bluntID'];
                $h_array['sceneID'] = $array['sceneID'];
                $h_array['caseData'] = $this->case->getCaseByScene($h_array['sceneID']);
                $h_array['sceneData'] = $this->getSceneByID($h_array['sceneID']);
                $h_array['bluntIOType'] = $array['bluntIOType'];
                $h_array['bluntForceObjectSuspected'] = $array['bluntForceObjectSuspected'];
                $h_array['bluntForceObjectStillOnScene'] = $array['bluntForceObjectStillOnScene'];
                $h_array['signsOfStruggle'] = $array['signsOfStruggle'];
                $h_array['alcoholBottleAround'] = $array['alcoholBottleAround'];
                $h_array['drugParaphernalia'] = $array['drugParaphernalia'];
                $h_array['wasCommunityAssult'] = $array['wasCommunityAssult'];
                $h_array['strangulationSuspected'] = $array['strangulationSuspected'];
                $h_array['smotheringSuspected'] = $array['smotheringSuspected'];
                $h_array['chockingSuspected'] = $array['chockingSuspected'];
                $h_array['injuriesConcentratedOn'] = $array['injuriesConcentratedOn'];
                $h_array['injuriesMainlyOn'] = $array['injuriesMainlyOn'];
                
                $hi_res = mysql_query("select * from bluntInside where bluntID=".$h_array['bluntID']);
                if(mysql_num_rows($hi_res) > 0)
                {
                    $hi_array = mysql_fetch_array($hi_res);
                    $h_array['bluntInside'] = $hi_array;
                }else{
                    $h_array['bluntInside'] = NULL;
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
            
            $error = array('status' => "Failed", "msg" => "Request to get blunt scene was denied.");
            $this->api->response($this->api->json($error), 400);
        }
    }
}
