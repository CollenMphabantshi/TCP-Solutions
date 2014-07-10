<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SharpForceInjury
 *
 * @author BANCHI
 */
class sharpParameters{
    private $sharpID;
    private $sceneID;
    private $sharpIOType;
    private $sharpObjectAtScene;
    private $sharpForceInjuries;
    private $theInjury;
    private $signsOfStruggle;
    private $alcoholBottleAround;
    private $drugParaphernalia;
    
    public  $sharpCases;
    private $caseObj;
    private $victimsObj;
    private $sceneObj;
    
}
class SharpForceInjury extends Scene{
    //put your code here
    public $paraObj ;
    public $paraObjAll;
    
     public function __construct($formData,$api){
        $this->api = $api;
        $paraObj = new sharpParameters();
        $paraObjAll =new sharpParameters();
        
        $sharpCases = array();
        
        if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Burn",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                $this->sharpIOType = $formData['object'][$i]['sharpIOType'];
                $this->sharpObjectAtScene = $formData['object'][$i]['sharpObjectAtScene'];
                $this->sharpForceInjuries = $formData['object'][$i]['sharpForceInjuries'];
                $this->theInjury = $formData['object'][$i]['theInjury'];
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
                    $this->addSharpForceInjury($sceneID,TRUE,$formData['object'][$i]);
                }else{
                    $this->addSharpForceInjury($sceneID,FALSE,null);
                }
            }
            
            
        }
	
    }
    
    public function addSharpForceInjury($sceneID,$inside,$object) {
        
        $h_res = mysql_query("insert into sharp values(0,".$sceneID.",'$this->sharpIOType','$this->sharpObjectAtScene','$this->sharpForceInjuries','$this->theInjury','$this->signsOfStruggle','$this->alcoholBottleAround','$this->drugParaphernalia')");
        if($h_res == FALSE){
            $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
            $this->api->response($this->api->json($error), 400);
        }
        
        if($inside == TRUE){
            $h_res = mysql_query("select sharpID from sharp where sceneID=".$sceneID);
            $sharpID= mysql_result($h_res,0,'sharpID');
            $dl = $object['doorLocked'];
            $wc = $object['windowsClosed'];
            $wb = $object['windowsBroken'];
            $va = $object['victimAlone'];
            $pv = $object['peopleWithVictim'];
            if($va != "yes")
            {
                $hi_res = mysql_query("insert into sharpinside values(0,".$sharpID.",'$dl','$wc','$wb','$va','$pv')");
            }else{
                $hi_res = mysql_query("insert into sharpinside values(0,".$sharpID.",'$dl','$wc','$wb','$va',null)");
            }
        }
        
    }
    
    public function getAllSharpForceInjuryCases() {
        $query ="SELECT * FROM sharp;";

        $result = mysql_query($query);
       
       while($info = mysql_fetch_array($result))
            {
                $paraObjAll->sharpCases [] = $this->getSharpForceInjuryCases($info['gassingID']);
               
            }
            
        return $paraObjAll;
        
    }
    
    public function getSharpForceInjuryCases($id) {
        $query ="SELECT * FROM sharp WHERE sharpID=".$id.";";

        $result = mysql_query($query);
        
        while($info = mysql_fetch_array($result))
            {
                        
                        $paraObj->sharpID = $info['sharpID'];
                        $paraObj->sceneID = $info['sceneID'];
                        $paraObj->sharpIOType = $info['sharpIOType'];
                        $paraObj->sharpObjectAtScene = $info['sharpObjectAtScene'];
                        $paraObj->sharpForceInjuries = $info['sharpForceInjuries'];
                        $paraObj->theInjury = $info['theInjury'];
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

            print $query;
            return $paraObj;
    }
}
