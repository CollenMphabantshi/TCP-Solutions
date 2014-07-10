<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Suda
 *
 * @author BANCHI
 */
class sudaParameters{
    
    private $sudaID;
    private $sceneID;
    private $sudaIOType;
    private $signsOfStruggle;
    private $alcoholBottleAround;
    private $drugParaphernalia;
    private $strangulationSuspected;
    private $smotheringSuspected;
    private $chockingSuspected;
    private $sudaAppliances;
    private $wierdSmellInAir;
   
    public  $sudaCases;
    public $caseObj;
    public $victimsObj;
    public $sceneObj;
}
class Suda extends Scene{
    
    public $paraObj ;
    public $paraObjAll;
   

    //put your code here
     public function __construct($formData,$api){
        $this->api = $api;
	$paraObj = new sudaParameters();
        $paraObjAll =new sudaParameters();
        
        $sudaCases = array();
        
        if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Burn",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                $this->sudaIOType = $formData['object'][$i]['sudaIOType'];
                $this->signsOfStruggle = $formData['object'][$i]['signsOfStruggle'];
                $this->alcoholBottleAround = $formData['object'][$i]['alcoholBottleAround'];
                $this->drugParaphernalia = $formData['object'][$i]['drugParaphernalia'];
                $this->strangulationSuspected = $formData['object'][$i]['strangulationSuspected'];
                $this->smotheringSuspected = $formData['object'][$i]['smotheringSuspected'];
                $this->chockingSuspected = $formData['object'][$i]['chockingSuspected'];
                $this->sudaAppliances = $formData['object'][$i]['sudaAppliances'];
                $this->wierdSmellInAir = $formData['object'][$i]['wierdSmellInAir'];
                
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
    
    public function addSuda($sceneID,$inside,$object) {
        
        $h_res = mysql_query("insert into suda values(0,".$sceneID.",'$this->sudaIOType','$this->signsOfStruggle','$this->alcoholBottleAround','$this->drugParaphernalia','$this->strangulationSuspected','$this->smotheringSuspected','$this->chockingSuspected','$this->sudaAppliances','$this->wierdSmellInAir')");
        if($h_res == FALSE){
            $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
            $this->api->response($this->api->json($error), 400);
        }
        
        if($inside == TRUE){
            $h_res = mysql_query("select sudaID from suda where sceneID=".$sceneID);
            $sudaID= mysql_result($h_res,0,'sudaID');
            $dl = $object['doorLocked'];
            $wc = $object['windowsClosed'];
            $wb = $object['windowsBroken'];
            $va = $object['victimAlone'];
            $pv = $object['peopleWithVictim'];
            if($va != "yes")
            {
                $hi_res = mysql_query("insert into sudainside values(0,".$sudaID.",'$dl','$wc','$wb','$va','$pv')");
            }else{
                $hi_res = mysql_query("insert into sudainside values(0,".$sudaID.",'$dl','$wc','$wb','$va',null)");
            }
        }
        
    }
    
    public function getAllSudaCases() {
        $query ="SELECT * FROM suda;";

        $result = mysql_query($query);
       
       while($info = mysql_fetch_array($result))
            {
                $paraObjAll->sudaCases[] = $this->getSudaCases($info['sudaID']);
               
            }
            
            return $paraObjAll;
        
    }
    
    public function getSudaCases($id) {
        $query ="SELECT * FROM suda WHERE sudaID=".$id.";";

        $result = mysql_query($query);
        
        while($info = mysql_fetch_array($result))
            {
                        
                        $paraObj->sudaID = $info['sudaID'];
                        $paraObj->sceneID = $info['sceneID'];
                        $paraObj->sudaIOType = $info['sudaIOType'];
                        $paraObj->signsOfStruggle = $info['signsOfStruggle'];
                        $paraObj->alcoholBottleAround = $info['alcoholBottleAround'];
                        $paraObj->drugParaphernalia = $info['drugParaphernalia'];
                        $paraObj->strangulationSuspected = $info['strangulationSuspected'];
                        $paraObj->smotheringSuspected = $info['smotheringSuspected'];
                        $paraObj->chockingSuspected = $info['chockingSuspected'];
                        $paraObj->sudaAppliances = $info['sudaAppliances'];
                        $paraObj->wierdSmellInAir = $info['wierdSmellInAir'];
                        
                        
                        
                        
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
