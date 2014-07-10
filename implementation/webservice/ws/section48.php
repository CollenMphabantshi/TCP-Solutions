<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of section48
 *
 * @author BANCHI
 */
class parameters {
    public $sec48ID;
    public $sceneID;
    public $victimHospitalized;
    public $medicalEquipmentInSitu;
    public $gw714file;
    public $DrNames;
    public $DrCellNumber;
    public $NurseNames;
    public $NurseCellNumber;
    
    private $caseObj;
    private $victimsObj;
    private $sceneObj;

    private $secCases;
    

    function __construct() {

    }
 }
class section48 extends Scene{
    
   public $paraObj;
   public $paraObjAll;
    //put your code here
        
    public function __construct($formData,$api){
     $this->api = $api;
     $paraObj = new parameters();
     
     $paraObjAll =new parameters();
     
     $secCases = array();
     
     
        if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null);
        }else {
            $i = 0;
            $val = new Scene($formData['object'][$i]['sceneTime'],"section48",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank']);
            
            //print $formData['object'][$i]['sceneTime']."  **  "."section48"."  **  ".$formData['object'][$i]['sceneDate']."  **  ".$formData['object'][$i]['sceneLocation']."  **  ".$formData['object'][$i]['sceneTemparature']."  **  ".$formData['object'][$i]['investigatingOfficerName']."  **  ".$formData['object'][$i]['investigatingOfficerRank']."  **  ".$formData['object'][$i]['investigatingOfficerCellNo']."  **  ".$formData['object'][$i]['firstOfficerOnSceneName']."  **  ".$formData['object'][$i]['firstOfficerOnSceneRank'];
            $sceneId = $val->createScene();
            $val->setVictim($sceneId,$formData['object'][$i]['victims']);
            $val->setCase($sceneId, $formData['object'][$i]['FOPersonelNumber']);
            print "\n <br/> scene id :".$sceneId ;
            
        }
	
    }
    
    public function getAllSection48Cases() {
        $query ="SELECT * FROM sec48;";

        $result = mysql_query($query);
       
        while($info = mysql_fetch_array($result))
            {
                $paraObjAll->secCases []= $this->getSection48Case($info['sec48ID']);
               
            }
            
            return $paraObjAll;
    }
    
    public function getSection48Case($id) {
        
        
        
        $query ="SELECT * FROM sec48 WHERE sec48ID=".$id.";";

        $result = mysql_query($query);
        
        while($info = mysql_fetch_array($result))
            {
                        
                        $paraObj->sec48ID = $info['sec48ID'];
                        $paraObj->sceneID = $info['sceneID'];
                        $paraObj->victimHospitalized = $info['victimHospitalized'];
                        $paraObj->medicalEquipmentInSitu = $info['medicalEquipmentInSitu'];
                        $paraObj->gw714file = $info['gw714file'];
                        $paraObj->DrNames = $info['DrNames'];
                        $paraObj->DrCellNumber = $info['DrCellNumber'];
                        $paraObj->NurseNames = $info['NurseNames'];
                        $paraObj->NurseCellNumber = $info['NurseCellNumber'];
                        
                        
                        
                        //get scene related data
                        $scene = $this->getSceneByID($paraObj->sceneID);
                        $paraObj-> sceneObj =  $scene;
                        

                        //get case related data
                        $case = new Cases($paraObj->sceneID, null);
                        $caseObj = $case->getCaseByScene($paraObj->sceneID);
                        $paraObj-> caseObj = $caseObj;

                        //get victims of the scene
                       $sceneVictims = new SceneVictims($paraObj->sceneID, null);
                       $sceneVictimsObj = $sceneVictims->getSceneVictims($paraObj->sceneID);
                       $paraObj-> victimsObj = $sceneVictimsObj;

                       }

            return $paraObj;
        
    }
}
   