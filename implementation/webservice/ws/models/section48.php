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
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Burn",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                $this->victimHospitalized = $formData['object'][$i]['victimHospitalized'];
                $this->medicalEquipmentInSitu = $formData['object'][$i]['medicalEquipmentInSitu'];
                $this->gw714file = $formData['object'][$i]['gw714file'];
                $this->DrNames = $formData['object'][$i]['DrNames'];
                $this->DrCellNumber = $formData['object'][$i]['DrCellNumber'];
                $this->NurseNames = $formData['object'][$i]['NurseNames'];
                $this->NurseCellNumber = $formData['object'][$i]['NurseCellNumber'];
                
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
       
        $h_res = mysql_query("insert into sec48 values(0,".$sceneID.",'$this->victimHospitalized','$this->medicalEquipmentInSitu','$this->gw714file','$this->DrNames','$this->DrCellNumber','$this->NurseNames','$this->NurseCellNumber')");
        if($h_res == FALSE){
            $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
            $this->api->response($this->api->json($error), 400);
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
   