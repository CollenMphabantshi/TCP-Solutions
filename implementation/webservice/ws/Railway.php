<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Railway
 *
 * @author BANCHI
 */
class railwayParameters{
    
    private $railwayID;
    private $sceneID;
    private $sceneOfInjury;
    private $victimType;
    private $railwayType;
    
    public  $railwayCases;
    private $caseObj;
    private $victimsObj;
    private $sceneObj;
    
    public function __construct() {
        
    }
    
}
class Railway extends Scene{
    //put your code here
    public $paraObj ;
    public $paraObjAll;
    
    
    
     public function __construct($formData,$api){
        $this->api = $api;
	$paraObj = new railwayParameters();
        $paraObjAll =new railwayParameters();
        
        $railwayCases = array();
        
        if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Burn",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                $this->sceneOfInjury = $formData['object'][$i]['sceneOfInjury'];
                $this->victimType = $formData['object'][$i]['victimType'];
                $this->railwayType = $formData['object'][$i]['railwayType'];
                
               $sceneID = $this->createScene();
                 if($sceneID == NULL){
                     $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                     $this->api->response($this->api->json($error), 400);
                 }
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
                $this->addRailway($sceneID);
            }
            
            
        }
    }
     public function addRailway($sceneID) {
       
        $h_res = mysql_query("insert into railway values(0,".$sceneID.",'$this->sceneOfInjury','$this->victimType','$this->railwayType')");
        if($h_res == FALSE){
            $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    
    public function getAllRailwayCases() {
        $query ="SELECT * FROM railway;";

        $result = mysql_query($query);
       
       while($info = mysql_fetch_array($result))
            {
                $paraObjAll->railwayCases[] = $this->getRailwayCases($info['railwayID']);
               
            }
            
            return $paraObjAll;
        
    }
    
    public function getRailwayCases($id) {
        $query ="SELECT * FROM railway WHERE railwayID=".$id.";";

        $result = mysql_query($query);
        
        while($info = mysql_fetch_array($result))
            {
                        
                        $paraObj->railwayID = $info['railwayID'];
                        $paraObj->sceneID = $info['sceneID'];
                        $paraObj->sceneOfInjury = $info['sceneOfInjury'];
                        $paraObj->victimType = $info['victimType'];
                        $paraObj->railwayType = $info['railwayType'];
                        $paraObj->weatherCondition = $info['weatherCondition'];
                        
                        
                        //get scene related data
                        $scene = $this->getSceneByID($paraObj->sceneID);
                        $paraObj-> sceneObj =  $scene;

                        //get case related data
                        $caseInstance = new Cases($paraObj->sceneID, null);
                        $case = $caseInstance->getCaseByScene($paraObj->sceneID);
                        $paraObj-> caseObj = $case ; 
                        


                        //get victims of the scene
                       $sceneVictims = new SceneVictims($paraObj->sceneID, null);
                       $sceneVictimsObj = $sceneVictims->getSceneVictims($paraObj->sceneID);
                       $paraObj-> victimsObj = $sceneVictimsObj;

                       }

        
            return $paraObj;
    }
    
    
        
    
}
