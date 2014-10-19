<?php
require_once("Scene.php");
require_once './ScenePhotos.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IngestionOverdosePoisoning
 *
 * @author BANCHI
 */
class ingestionParameters{
    public $ingestionOverdosePoisoningID;
    public $sceneID;
    public $ingestionOverdosePoisoningIOType;
    public $signsOfStruggle;
    public $alcoholBottleAround;
    public $drugParaphernalia;
    public $suspectedDrug;
    public $suspectedDrugOnScene;
    public $whyIngestionOverdoseSuspected;
    
    public $ingestionCases;
    public $caseObj;
    public $victimsObj;
    public $sceneObj;
    
}
class IngestionOverdosePoisoning extends Scene{
    //put your code here
    public $paraObj ;
    public $paraObjAll;
    public $images;
     public function __construct($formData,$api){
        $this->api = $api;
        $this->paraObj = new ingestionParameters();
        $this->paraObjAll =new ingestionParameters();
        
        $this->paraObjAll->ingestionCases = array();
        
        if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Ingestion/overdose /poisoning",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                $this->paraObjAll->ingestionOverdosePoisoningIOType = $formData['object'][$i]['ingestionOverdosePoisoningIOType'];
                $this->paraObjAll->signsOfStruggle = $formData['object'][$i]['signsOfStruggle'];
                $this->paraObjAll->alcoholBottleAround = $formData['object'][$i]['alcoholBottleAround'];
                $this->paraObjAll->drugParaphernalia = $formData['object'][$i]['drugParaphernalia'];   
                $this->paraObjAll->suspectedDrug = $formData['object'][$i]['suspectedDrug'];
                $this->paraObjAll->suspectedDrugOnScene = $formData['object'][$i]['suspectedDrugOnScene'];
                $this->paraObjAll->whyIngestionOverdoseSuspected = $formData['object'][$i]['whyIngestionOverdoseSuspected'];
                $this->images = $formData['object'][$i]['images'][0];
               $sceneID = $this->createScene();
                 if($sceneID == NULL){
                     $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                     $this->api->response($this->api->json($error), 400);
                 }
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
                
                $enc = new Encryption();
                $vinside = $enc->decrypt_request($formData['object'][$i]['victims'][0]['victimInside']);
                if($vinside === "Yes"){
                    $this->addIngestionOverdosePoisoning($sceneID,TRUE,$formData['object'][$i]);
                }else{
                    $this->addIngestionOverdosePoisoning($sceneID,FALSE,null);
                }
            }
            
            
        }
	
    }
    
    public function addIngestionOverdosePoisoning($sceneID,$inside,$object) {
        $ingestionOverdosePoisoningIOType = $this->paraObjAll->ingestionOverdosePoisoningIOType;
        $signsOfStruggle = $this->paraObjAll->signsOfStruggle;
        $alcoholBottleAround = $this->paraObjAll->alcoholBottleAround;
        $suspectedDrug = $this->paraObjAll->suspectedDrug;
        $suspectedDrugOnScene = $this->paraObjAll->suspectedDrugOnScene;
        $whyIngestionOverdoseSuspected = $this->paraObjAll->whyIngestionOverdoseSuspected;
        
        
        $h_res = mysql_query("insert into ingestionOverdosePoisoning values(0,$sceneID,"
                . "'$ingestionOverdosePoisoningIOType',"
                . "'$signsOfStruggle',"
                . "'$alcoholBottleAround',"
                . "'$drugParaphernalia',"
                . "'$suspectedDrug',"
                . "'$suspectedDrugOnScene',"
                . "'$whyIngestionOverdoseSuspected')");
        
        
        if($h_res === FALSE){
            $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
            $this->api->response($this->api->json($error), 400);
        }
        
        if($inside === TRUE){
            $h_res = mysql_query("select ingestionOverdosePoisoningID from ingestionOverdosePoisoning where sceneID=".$sceneID);
            $ingestionOverdosePoisoningID = mysql_result($h_res,0,'ingestionOverdosePoisoningID');
            $dl = $object['doorLocked'];
            $wc = $object['windowsClosed'];
            $wb = $object['windowsBroken'];
            $va = $object['victimAlone'];
            $pv = $object['peopleWithVictim'];
            
            $enc = new Encryption();
            if($enc->decrypt_request($va) !== "Yes")
            {
                $hi_res = mysql_query("insert into ingestionOverdosePoisoningInside values(0,".$ingestionOverdosePoisoningID.",'$dl','$wc','$wb','$va','$pv')");
            }else{
                $hi_res = mysql_query("insert into ingestionOverdosePoisoningInside values(0,".$ingestionOverdosePoisoningID.",'$dl','$wc','$wb','$va',null)");
            }
        }
        $scenePhoto = new ScenePhotos($this->api);
        
        
        for($i = 0; $i < count($this->images);$i++)
        {
            $scenePhoto->upload($this->images['names'.$i], $this->images['data'.$i], $sceneID);
        }
        $error = array('status' => "Success", "msg" => "Request to create a scene was successful.");
            $this->api->response($this->api->json($error), 200);
        
    }
    
    public function getAllIngestionOverdosePoisoningCases() {
        $query ="SELECT * FROM ingestionoverdosepoisoning";
        $result = mysql_query($query);
       
       while($info = mysql_fetch_array($result))
        {
            $this->paraObjAll->ingestionCases[] = $this->getRailwayCases($info['ingestionOverdosePoisoningID']);
        }
            
        return $this->paraObjAll;
        
    }
    
    public function getDataBySceneID($sceneID) {
        try{
            $enc = new Encryption();
            $h_res = mysql_query("select * from ingestionoverdosepoisoning where sceneID=".$sceneID);
            $h_array = mysql_fetch_array($h_res);
            $hi_res = mysql_query("select * from ingestionoverdosepoisoninginside where ingestionoverdosepoisoningID=".$h_array['ingestionoverdosepoisoningID']);
                if(mysql_num_rows($hi_res) > 0)
                {
                    $hi_array = mysql_fetch_array($hi_res);
                    $hi_array['doorLocked'] = $enc->decrypt_request($hi_array['doorLocked']);
                    $hi_array['windowsClosed'] = $enc->decrypt_request($hi_array['windowsClosed']);
                    $hi_array['windowsBroken'] = $enc->decrypt_request($hi_array['windowsBroken']);
                    $hi_array['victimAlone'] = $enc->decrypt_request($hi_array['victimAlone']);
                    if($hi_array['peopleWithVictim'] !== NULL)
                    {
                        $hi_array['peopleWithVictim'] = $enc->decrypt_request($hi_array['peopleWithVictim']);
                    }else{
                        $hi_array['peopleWithVictim'] = "none";
                    }
                    $h_array['ingestionoverdosepoisoningInside'] = $hi_array;
                }else{
                    $h_array['ingestionoverdosepoisoningInside'] = "null";
                }
                $h_array['ingestionOverdosePoisoningIOType'] = $enc->decrypt_request($h_array['ingestionOverdosePoisoningIOType']);
                $h_array['signsOfStruggle'] = $enc->decrypt_request($h_array['signsOfStruggle']);
                $h_array['alcoholBottleAround'] = $enc->decrypt_request($h_array['alcoholBottleAround']);
                $h_array['drugParaphernalia'] = $enc->decrypt_request($h_array['drugParaphernalia']);
                $h_array['suspectedDrug'] = $enc->decrypt_request($h_array['suspectedDrug']);
                $h_array['suspectedDrugOnScene'] = $enc->decrypt_request($h_array['suspectedDrugOnScene']);
                $h_array['whyIngestionOverdoseSuspected'] = $enc->decrypt_request($h_array['whyIngestionOverdoseSuspected']);
                $sp = new ScenePhotos($this->api);
                $files = $sp->getPhotos($sceneID);
                if($files !== NULL)
                {
                    $h_array['photos'] = $files;
                }else{
                    $h_array['photos'] = "unavailable";
                }
            return $h_array;
        } catch (Exception $ex) {
            $error = array('status' => "Failed", "msg" => "No data found.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    public function getIngestionOverdosePoisoningCases($id) {
        $query ="SELECT * FROM ingestionoverdosepoisoning WHERE ingestionOverdosePoisoningID=".$id;

        $result = mysql_query($query);
        
        while($info = mysql_fetch_array($result))
            {
                        
                        $this->paraObj->ingestionOverdosePoisoningID = $info['ingestionOverdosePoisoningID'];
                        $this->paraObj->sceneID = $info['sceneID'];
                        $this->paraObj->ingestionOverdosePoisoningIOType = $info['ingestionOverdosePoisoningIOType'];
                        $this->paraObj->signsOfStruggle = $info['signsOfStruggle'];
                        $this->paraObj->alcoholBottleAround = $info['alcoholBottleAround'];
                        $this->paraObj->drugParaphernalia = $info['drugParaphernalia'];
                        $this->paraObj->suspectedDrug = $info['suspectedDrug'];
                        $this->paraObj->suspectedDrugOnScene = $info['suspectedDrugOnScene'];
                        $this->paraObj->whyIngestionOverdoseSuspected = $info['whyIngestionOverdoseSuspected'];
                        
                        //get scene related data
                        $scene = $this->getSceneByID($this->paraObj->sceneID);
                        $this->paraObj-> sceneObj =  $scene;

                        //get case related data
                        $caseInstance = new Cases($this->paraObj->sceneID, null);
                        $case = $caseInstance->getCaseByScene($this->paraObj->sceneID);
                        $this->paraObj-> caseObj = $case ; 
                        


                        //get victims of the scene
                       $sceneVictims = new SceneVictims($this->paraObj->sceneID, null);
                       $sceneVictimsObj = $sceneVictims->getSceneVictims($this->paraObj->sceneID);
                       $this->paraObj->victimsObj = $sceneVictimsObj;

             }

        
            return $this->paraObj;
        
    }
}
