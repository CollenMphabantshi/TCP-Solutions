<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sudc
 *
 * @author BANCHI
 */
class Sudc extends Scene{
    //put your code here
    private $sudcIOType;
    private $signsOfStruggle;
    private $alcoholBottleAround;
    private $drugParaphernalia;
    private $strangulationSuspected;
    private $smotheringSuspected;
    private $chockingSuspected;
    private $sudcAppliances;
    private $wierdSmellInAir;
    
     public function __construct($formData){
	if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Sudc",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank']);
                $this->sudcIOType = $formData['object'][$i]['sudcIOType'];
                $this->signsOfStruggle = $formData['object'][$i]['signsOfStruggle'];
                $this->alcoholBottleAround = $formData['object'][$i]['alcoholBottleAround'];
                $this->drugParaphernalia = $formData['object'][$i]['drugParaphernalia'];
                $this->strangulationSuspected = $formData['object'][$i]['strangulationSuspected'];
                $this->smotheringSuspected = $formData['object'][$i]['smotheringSuspected'];
                $this->chockingSuspected = $formData['object'][$i]['chockingSuspected'];
                $this->sudcAppliances = $formData['object'][$i]['sudcAppliances'];
                $this->wierdSmellInAir = $formData['object'][$i]['wierdSmellInAir'];
                    //
                $sceneID = $this->createScene();
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
                echo "TEST: ".$formData['object'][$i]['victims']['victimInside'];
                if($formData['object'][$i]['victims']['victimInside'] == "yes"){
                    $this->addHanging($sceneID,TRUE,$formData['object'][$i]);
                }else{
                    $this->addHanging($sceneID,FALSE,null);
                }
            }
            
            
        }
        
    }
    
    private function addSudc($sceneID,$inside,$object) {
            $h_res = mysql_query("insert into hanging values(0,".$sceneID.",'$this->hangingIOType','$this->signsOfStruggle','$this->alcoholBottleAround','$this->drugParaphernalia','$this->autoeroticAsphyxia','$this->partialHangingType','$this->completeHanging','$this->ligatureAroundNeck','$this->whoRemovedLigature','$this->ligatureType','$this->strangulationSuspected','$this->smotheringSuspected','$this->chockingSuspected')");

        
        if($inside == TRUE){
            $h_res = mysql_query("select hangingID from hanging where sceneID=".$sceneID);
            $hangingID = mysql_result($h_res,0,'hangingID');
            $dl = $object['doorLocked'];
            $wc = $object['windowsClosed'];
            $wb = $object['windowsBroken'];
            $va = $object['victimAlone'];
            $pv = $object['peopleWithVictim'];
            if($va != "yes")
            {
                $hi_res = mysql_query("insert into hanginginside values(0,".$hangingID.",'$dl','$wc','$wb','$va','$pv')");
            }else{
                $hi_res = mysql_query("insert into hanginginside values(0,".$hangingID.",'$dl','$wc','$wb','$va',null)");
            }
        }
    }
    public function getAllSudc() {
        try{
            
            $h_res = mysql_query("select * from hanging");
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
                $h_array['hangingID'] = $array['hangingID'];
                $h_array['sceneID'] = $array['sceneID'];
                $h_array['caseData'] = $this->case->getCaseByScene($h_array['sceneID']);
                $h_array['sceneData'] = $this->getSceneByID($h_array['sceneID']);
                $h_array['hangingIOType'] = $array['hangingIOType'];
                $h_array['signsOfStruggle'] = $array['signsOfStruggle'];
                $h_array['alcoholBottleAround'] = $array['alcoholBottleAround'];
                $h_array['drugParaphernalia'] = $array['drugParaphernalia'];
                $h_array['autoeroticAsphyxia'] = $array['autoeroticAsphyxia'];
                $h_array['partialHangingType'] = $array['partialHangingType'];
                $h_array['completeHanging'] = $array['completeHanging'];
                $h_array['ligatureAroundNeck'] = $array['ligatureAroundNeck'];
                $h_array['whoRemovedLigature'] = $array['whoRemovedLigature'];
                $h_array['ligatureType'] = $array['ligatureType'];
                $h_array['strangulationSuspected'] = $array['strangulationSuspected'];
                $h_array['smotheringSuspected'] = $array['smotheringSuspected'];
                $h_array['chockingSuspected'] = $array['chockingSuspected'];
                
                $hi_res = mysql_query("select * from hanginginside where hangingID=".$h_array['hangingID']);
                if(mysql_num_rows($hi_res) > 0)
                {
                    $hi_array = mysql_fetch_array($hi_res);
                    $h_array['hangingInside'] = $hi_array;
                }else{
                    $h_array['hangingInside'] = NULL;
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
            
            return null;
        }
    }
    
    public function getSudc($hangingID) {
        try{
            
            $h_res = mysql_query("select * from hanging where hangingID=".$hangingID);
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
                $h_array['hangingID'] = $array['hangingID'];
                $h_array['sceneID'] = $array['sceneID'];
                $h_array['caseData'] = $this->case->getCaseByScene($h_array['sceneID']);
                $h_array['sceneData'] = $this->getSceneByID($h_array['sceneID']);
                $h_array['hangingIOType'] = $array['hangingIOType'];
                $h_array['signsOfStruggle'] = $array['signsOfStruggle'];
                $h_array['alcoholBottleAround'] = $array['alcoholBottleAround'];
                $h_array['drugParaphernalia'] = $array['drugParaphernalia'];
                $h_array['autoeroticAsphyxia'] = $array['autoeroticAsphyxia'];
                $h_array['partialHangingType'] = $array['partialHangingType'];
                $h_array['completeHanging'] = $array['completeHanging'];
                $h_array['ligatureAroundNeck'] = $array['ligatureAroundNeck'];
                $h_array['whoRemovedLigature'] = $array['whoRemovedLigature'];
                $h_array['ligatureType'] = $array['ligatureType'];
                $h_array['strangulationSuspected'] = $array['strangulationSuspected'];
                $h_array['smotheringSuspected'] = $array['smotheringSuspected'];
                $h_array['chockingSuspected'] = $array['chockingSuspected'];
                
                $hi_res = mysql_query("select * from hanginginside where hangingID=".$h_array['hangingID']);
                if(mysql_num_rows($hi_res) > 0)
                {
                    $hi_array = mysql_fetch_array($hi_res);
                    $h_array['hangingInside'] = $hi_array;
                }else{
                    $h_array['hangingInside'] = NULL;
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
            
            return null;
        }
    }
}
