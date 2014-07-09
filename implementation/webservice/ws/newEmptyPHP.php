<?php

class NewClass{
private $sec48ID;
    private $sceneID;
    private $victimHospitalized;
    private $medicalEquipmentInSitu;
    private $gw714file;
    private $DrNames;
    private $DrCellNumber;
    private $NurseNames;
    private $NurseCellNumber;
    public function _construct(){
        while($info = mysql_fetch_array($result))
            {
            
                /* This part selects main scenes*/
		print $info['sec48ID']." -- ".$info['sceneID']." -- ".$info['victimHospitalized']." -- ".$info['medicalEquipmentInSitu']." -- ".$info['gw714file']." -- ".$info['DrNames']." -- ".$info['DrCellNumber']." -- ".$info['NurseNames']." -- ".$info['NurseCellNumber']."\n";	
                $array[0]= $sec48ID = $info['sec48ID'];
                $array[1]=$sceneID = $info['sceneID'];
                $array[2]=$victimHospitalized = $info['victimHospitalized'];
                $array[3]=$medicalEquipmentInSitu = $info['medicalEquipmentInSitu'];
                $array[4]=$gw714file = $info['gw714file'];
                $array[5]=$DrNames = $info['DrNames'];
                $array[6]=$DrCellNumber = $info['DrCellNumber'];
                $array[7]=$NurseNames = $info['NurseNames'];
                $array[8]=$NurseCellNumber = $info['NurseCellNumber'];
                
            }
            return json_encode($array);
    }
}
?>