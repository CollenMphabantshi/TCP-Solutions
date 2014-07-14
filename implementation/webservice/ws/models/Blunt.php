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
    
    public function __construct($formData,$api){
        
        if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Hanging",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
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
                    //
                $sceneID = $this->createScene();
                 if($sceneID == NULL){
                     $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                     $this->api->response($this->api->json($error), 400);
                 }
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
                
                if($formData['object'][$i]['victims']['victimInside'] == "yes"){
                    $this->addHanging($sceneID,TRUE,$formData['object'][$i]);
                }else{
                    $this->addHanging($sceneID,FALSE,null);
                }
            }
            
            
        }
        
    }
    
    private function addBlunt($sceneID,$inside,$object) {
        $h_res = mysql_query("insert into blunt values(0,".$sceneID.",'$this->bluntIOType','$this->bluntForceObjectSuspected','$this->bluntForceObjectStillOnScene','$this->signsOfStruggle','$this->alcoholBottleAround','$this->drugParaphernalia','$this->wasCommunityAssult','$this->strangulationSuspected','$this->smotheringSuspected','$this->chockingSuspected')");
        
        if($inside == TRUE){
            $h_res = mysql_query("select bluntID from hanging where sceneID=".$sceneID);
            $bluntID = mysql_result($h_res,0,'bluntID');
            $dl = $object['doorLocked'];
            $wc = $object['windowsClosed'];
            $wb = $object['windowsBroken'];
            $va = $object['victimAlone'];
            $pv = $object['peopleWithVictim'];
            if($va != "yes")
            {
                $hi_res = mysql_query("insert into bluntInside values(0,".$bluntID.",'$dl','$wc','$wb','$va','$pv')");
            }else{
                $hi_res = mysql_query("insert into hanginginside values(0,".$bluntID.",'$dl','$wc','$wb','$va',null)");
            }
        }
    }
    public function getAllBlunts() {
        try{
            
            $h_res = mysql_query("select * from blunt");
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
            
            $error = array('status' => "Failed", "msg" => "Request to get blunt scenes was denied.");
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
