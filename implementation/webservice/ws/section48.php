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
    public $sceneTypeID;
    public $sceneTime;
    public $sceneDate;
    public $sceneLocation;
    public $sceneTemparature ;
    public $sceneInvestigatingOfficerName ;
    public $sceneInvestigatingOfficerRank ;
    public $sceneInvestigatingOfficerCellNumber;
    public $firstOfficerOnSceneName ;
    public $firstOfficerOnSceneRank ;
    private $caseNumber;
    //private $sceneID;
    private $FOPersonalNumber;
    

    function __construct() {

    }
 }
class section48 extends Scene{
    
   public $paraObj;
    //put your code here
        
    public function __construct($formData){
        
     
	$paraObj = new parameters();
    }
    
    public function getSection48Case($database,$id) {
        
        $query ="SELECT * FROM sec48 WHERE sec48ID=".$id.";";

         if ( !( $result = mysql_query( $query, $database ) ) )
           {
           print( "Could not execute query!" );
           die( mysql_error() );
           }
        while($info = mysql_fetch_array($result))
            {
            
                /* This part selects main scenes*/
		//print $info['sec48ID']." -- ".$info['sceneID']." -- ".$info['victimHospitalized']." -- ".$info['medicalEquipmentInSitu']." -- ".$info['gw714file']." -- ".$info['DrNames']." -- ".$info['DrCellNumber']." -- ".$info['NurseNames']." -- ".$info['NurseCellNumber']."\n";	
                        $paraObj->sec48ID = $info['sec48ID'];
                        $paraObj->sceneID = $info['sceneID'];
                        $paraObj->victimHospitalized = $info['victimHospitalized'];
                        $paraObj->medicalEquipmentInSitu = $info['medicalEquipmentInSitu'];
                        $paraObj->gw714file = $info['gw714file'];
                        $paraObj->DrNames = $info['DrNames'];
                        $paraObj->DrCellNumber = $info['DrCellNumber'];
                        $paraObj->NurseNames = $info['NurseNames'];
                        $paraObj->NurseCellNumber = $info['NurseCellNumber'];
                
            }
            
            
            $scene = $this->getSceneByID($paraObj->sceneID);
            
            print "tested   ". $scene[0];
            
             $paraObj-> sceneTypeID = $scene[0];
             $paraObj-> sceneTime = $scene[1];
             $paraObj-> sceneDate = $scene[2];
             $paraObj-> sceneLocation = $scene[3];
             $paraObj-> sceneTemparature = $scene[4];
             $paraObj-> sceneInvestigatingOfficerName = $scene[5];
             $paraObj-> sceneInvestigatingOfficerRank = $scene[6];
             $paraObj-> sceneInvestigatingOfficerCellNumber = $scene[7];
             $paraObj-> firstOfficerOnSceneName = $scene[8];
             $paraObj-> firstOfficerOnSceneRank = $scene[9];
             
             /*$case = $this->case->getCaseByScene($paraObj->sceneID);
             
              $paraObj-> caseNumber = $case[0];
              //$paraObj-> sceneID = $case[1];
              $paraObj-> FOPersonalNumber = $case[2];*/
            
            return json_encode($paraObj);
        
    }
}
    $test = new section48();
    //$test->getSection48Case($database,2);
    //print $test->getSection48Case($database,2);
