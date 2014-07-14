<?php
require_once("Scene.php");

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Gassing
 *
 * @author BANCHI
 */
class gassingParameters{
    private $gassingID;
    private $sceneID;
    private $gassingIOType;
    private $signsOfStruggle;
    private $alcoholBottleAround;
    private $drugParaphernalia;
    
    public  $GassingCases;
    private $caseObj;
    private $victimsObj;
    private $sceneObj;
    
    public function __construct() {
        
    }
}
class Gassing extends Scene{
    //put your code here
    
    public $paraObj ;
    public $paraObjAll;
    
     public function __construct($formData,$api){
        $this->api = $api;
        $paraObj = new gassingParameters();
        $paraObjAll =new gassingParameters();
        
        $GassingCases = array();
        
        if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Burn",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                $this->gassingIOType = $formData['object'][$i]['gassingIOType'];
                $this->signsOfStruggle = $formData['object'][$i]['signsOfStruggle'];
                $this->alcoholBottleAround = $formData['object'][$i]['alcoholBottleAround'];
                $this->drugParaphernalia = $formData['object'][$i]['drugParaphernalia'];
                
               $sceneID = $this->createScene();
                 if($sceneID == NULL){
                     $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                     $this->api->response($this->api->json($error), 400);
                 }
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
                if($formData['object'][$i]['victims']['victimInside'] == "yes"){
                    $this->addGassing($sceneID,TRUE,$formData['object'][$i]);
                }else{
                    $this->addGassing($sceneID,FALSE,null);
                }
            }
            
            
        }
	
    }
    
    public function addGassing($sceneID,$inside,$object) {
        
        $h_res = mysql_query("insert into gassing values(0,".$sceneID.",'$this->gassingIOType','$this->signsOfStruggle','$this->alcoholBottleAround','$this->drugParaphernalia')");
        if($h_res == FALSE){
            $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
            $this->api->response($this->api->json($error), 400);
        }
        
        if($inside == TRUE){
            $h_res = mysql_query("select gassingID from gassing where sceneID=".$sceneID);
            $gassingID = mysql_result($h_res,0,'gassingID');
            $dl = $object['doorLocked'];
            $wc = $object['windowsClosed'];
            $wb = $object['windowsBroken'];
            $va = $object['victimAlone'];
            $pv = $object['peopleWithVictim'];
            $ga = $object['gassingAppliances']; 
            $gau = $object['gassingAppliancesUsed'];
            $gs = $object['gassingSmell'];
            if($va != "yes")
            {
                $hi_res = mysql_query("insert into gassinginside values(0,".$gassingID.",'$dl','$wc','$wb','$va','$pv','$ga','$gau','$gs')");
            }else{
                $hi_res = mysql_query("insert into gassinginside values(0,".$gassingID.",'$dl','$wc','$wb','$va',null','$ga','$gau','$gs)");
            }
        }else{
            
            $h_res = mysql_query("select gassingID from gassing where sceneID=".$sceneID);
            $gassingID = mysql_result($h_res,0,'gassingID');
            $gvc = $object['gassingVictimInCar'];
            $vcd = $object['victimInCarDescription'];
            
           
           $hi_res = mysql_query("insert into gassingoutside values(0,".$gassingID.",'$gvc','$vcd')");
           
            
        }
        
    }
    
    public function getAllGassingCases() {
        $query ="SELECT * FROM gassing;";

        $result = mysql_query($query);
       
       while($info = mysql_fetch_array($result))
            {
                $paraObjAll->GassingCases[] = $this->getElectrocutionLightningCases($info['gassingID']);
               
            }
            
        return $paraObjAll;
        
    }
    
    public function getGassingCases($id) {
        
        $query ="SELECT * FROM gassing WHERE gassingID=".$id.";";

        $result = mysql_query($query);
        
        while($info = mysql_fetch_array($result))
            {
                        
                        $paraObj->gassingID = $info['gassingID'];
                        $paraObj->sceneID = $info['sceneID'];
                        $paraObj->gassingIOType = $info['gassingIOType'];
                        $paraObj->signsOfStruggle = $info['signsOfStruggle'];
                        $paraObj->alcoholBottleAround = $info['alcoholBottleAround'];
                        $paraObj->drugParaphernalia = $info['drugParaphernalia'];
                        
                        
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

            //print $query;
            return $paraObj;
    }
    
}

