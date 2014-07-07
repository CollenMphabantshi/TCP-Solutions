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
            
            //get data from scene table
            $query2 ="SELECT * FROM scene WHERE sceneID=".$paraObj->sceneID.";";

            if ( !( $result2 = mysql_query( $query2, $database ) ) )
              {
              print( "Could not execute query!" );
              die( mysql_error() );
              }
            while($info2 = mysql_fetch_array($result2))
            {
            
                        $paraObj->sceneTypeID = $info2['sceneTypeID'];
                        $paraObj->sceneTime = $info2['sceneTime'];
                        $paraObj->sceneDate = $info2['sceneDate'];
                        $paraObj->sceneLocation = $info2['sceneLocation'];
                        $paraObj->sceneTemparature = $info2['sceneTemparature'];
                        $paraObj->sceneInvestigatingOfficerName = $info2['sceneInvestigatingOfficerName'];
                        $paraObj->sceneInvestigatingOfficerRank = $info2['sceneInvestigatingOfficerRank'];
                        $paraObj->sceneInvestigatingOfficerCellNumber = $info2['sceneInvestigatingOfficerCellNumber'];
                        $paraObj->firstOfficerOnSceneName = $info2['firstOfficerOnSceneName'];
                        $paraObj->firstOfficerOnSceneRank = $info2['firstOfficerOnSceneRank'];
                
            }
            return $paraObj;
        
    }
}
    $test = new section48(1);
    //$test->getSection48Case($database,2);
    //print $test->getSection48Case($database,2);
