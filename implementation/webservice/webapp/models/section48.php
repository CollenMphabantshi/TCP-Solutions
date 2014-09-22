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
    
    public $caseObj;
    public $victimsObj;
    public $sceneObj;

    public $secCases;
    

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
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Burn",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                
                $this->paraObjAll->victimHospitalized = $formData['object'][$i]['victimHospitalized'];
                $this->paraObjAll->medicalEquipmentInSitu = $formData['object'][$i]['medicalEquipmentInSitu'];
                $this->paraObjAll->gw7_24file = $formData['object'][$i]['gw7_24file'];
                $this->paraObjAll->DrNames = $formData['object'][$i]['DrNames'];
                $this->paraObjAll->DrCellNumber = $formData['object'][$i]['DrCellNumber'];
                $this->paraObjAll->NurseNames = $formData['object'][$i]['NurseNames'];
                $this->paraObjAll->NurseCellNumber = $formData['object'][$i]['NurseCellNumber'];
                $this->paraObjAll->hospitalName = $formData['object'][$i]['hospitalName'];
                $this->paraObjAll->whoRemovedEquipment = $formData['object'][$i]['whoRemovedEquipment'];
                $this->paraObjAll->gw7_24fileFullyComplete = $formData['object'][$i]['gw7_24fileFullyComplete'];
                $this->paraObjAll->medicalRecords = $formData['object'][$i]['medicalRecords'];
                $this->paraObjAll->importantInfoFromMedicalStuff = $formData['object'][$i]['importantInfoFromMedicalStuff'];
                
               $sceneID = $this->createScene();
                 if($sceneID == NULL){
                     $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                     $this->api->response($this->api->json($error), 400);
                 }
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
                $this->addSection48($sceneID);
            }
            
            
        }
	
    }
    
    public function addSection48($sceneID) {
       
        $h_res = mysql_query("insert into sec48 values(0,"
        .$sceneID.",'$this->paraObjAll->victimHospitalized','$this->paraObjAll->medicalEquipmentInSitu','$this->paraObjAll->gw7_24file','$this->paraObjAll->DrNames','$this->paraObjAll->DrCellNumber','$this->paraObjAll->NurseNames','$this->paraObjAll->NurseCellNumber','$this->paraObjAll->hospitalName','$this->paraObjAll->whoRemovedEquipment','$this->paraObjAll->gw7_24fileFullyComplete','$this->paraObjAll->medicalRecords','$this->paraObjAll->importantInfoFromMedicalStuff')");
        if($h_res == FALSE){
            $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
            $this->api->response($this->api->json($error), 400);
        }
        
    }
    
    public function getAllSection48Cases() {
        $query ="SELECT * FROM sec48";

        $result = mysql_query($query);
       
        while($info = mysql_fetch_array($result))
            {
            $this->paraObjAll->secCases []= $this->getSection48Case($info['sec48ID']);
               
            }
            
            return $this->paraObjAll;
    }
    
    public function getDataBySceneID($sceneID) {
        try{
            $h_res = mysql_query("select * from sec48 where sceneID=".$sceneID);
            return mysql_fetch_array($h_res);
        } catch (Exception $ex) {
            $error = array('status' => "Failed", "msg" => "No data found.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    
    public function getSection48Case($id) {
        
        
        
        $query ="SELECT * FROM sec48 WHERE sec48ID=".$id;

        $result = mysql_query($query);
        
        while($info = mysql_fetch_array($result))
            {
                        
                        $this->paraObj->sec48ID = $info['sec48ID'];
                        $this->paraObj->sceneID = $info['sceneID'];
                        $this->paraObj->victimHospitalized = $info['victimHospitalized'];
                        $this->paraObj->medicalEquipmentInSitu = $info['medicalEquipmentInSitu'];
                        $this->paraObj->gw7_24file = $info['gw7_24file'];
                        $this->paraObj->DrNames = $info['DrNames'];
                        $this->paraObj->DrCellNumber = $info['DrCellNumber'];
                        $this->paraObj->NurseNames = $info['NurseNames'];
                        $this->paraObj->NurseCellNumber = $info['NurseCellNumber'];
                        $this->paraObj->hospitalName = $info['hospitalName'];
                        $this->paraObj->whoRemovedEquipment = $info['whoRemovedEquipment'];
                        $this->paraObj->gw7_24fileFullyComplete = $info['gw7_24fileFullyComplete'];
                        $this->paraObj->medicalRecords = $info['medicalRecords'];
                        $this->paraObj->importantInfoFromMedicalStuff = $info['importantInfoFromMedicalStuff'];
                        
                        
                        //get scene related data
                        $scene = $this->getSceneByID($this->paraObj->sceneID);
                        $this->paraObj->sceneObj =  $scene;
                        

                        //get case related data
                        $case = new Cases($this->paraObj->sceneID, null);
                        $caseObj = $case->getCaseByScene($this->paraObj->sceneID);
                        $this->paraObj->caseObj = $caseObj;

                        //get victims of the scene
                       $sceneVictims = new SceneVictims($this->paraObj->sceneID, null);
                       $sceneVictimsObj = $sceneVictims->getSceneVictims($this->paraObj->sceneID);
                       $this->paraObj->victimsObj = $sceneVictimsObj;

                       }

            return $this->paraObj;
        
    }
}
   