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
    
     public function __construct($formData){
	if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Firearm",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank']);
                $this->firearmIOType = $formData['object'][$i]['firearmIOType'];
                $this->signsOfStruggle = $formData['object'][$i]['signsOfStruggle'];
                $this->alcoholBottleAround = $formData['object'][$i]['alcoholBottleAround'];
                $this->drugParaphernalia = $formData['object'][$i]['drugParaphernalia'];
                $this->gunshotWounds = $formData['object'][$i]['gunshotWounds'];
                $this->gunshotWoundsLocation = $formData['object'][$i]['gunshotWoundsLocation'];
                $this->gunshotWoundsArea = $formData['object'][$i]['gunshotWoundsArea'];
                $this->firearmOnScene = $formData['object'][$i]['firearmOnScene'];                
                $this->firearmCalibre = $formData['object'][$i]['firearmCalibre'];              
                    //
                $sceneID = $this->createScene();
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
            
            return null;
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
            
            return null;
        }
    }
}
