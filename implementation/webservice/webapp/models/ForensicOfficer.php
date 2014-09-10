<?php
require_once './User.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ForensicOfficer
 *
 * @author Latitude
 */
class ForensicOfficer extends User{
    //put your code here
    private $personalNumber;
    private $cellPhoneNumber;
    
    public function addUser($personelNumber,$userID,$cellphoneNumber) {
        $a_res = mysql_query("insert into forensicOfficer values('$personelNumber',$userID,'$cellphoneNumber')");
        return $a_res;
    }
    
    public function modifyFOUser($formData){
        $a = $this->modifyUser($formData['userName'], $formData['userPassword'], $formData['userFirstname'], $formData['userSurname'], $formData['userTypeID'], $formData['userActive']);        
        if($a)
        {
            $cellNo = $formData['cellphoneNumber'];
            $uname = $formData['userName'];
            return mysql_query("update forensicOfficer set cellphoneNumber='$cellNo' where personelNumber='$uname'");
        }else {
            $error = array('status' => "Failed", "msg" => "Request to modify user was denied.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    
    public function removeUser($userName,$userID) {
        
        return $this->removeUser($userName, $userID);
    }
    
    public function getAllFOs() {
        $s_res = mysql_query("select * from forensicOfficer");
        $r = mysql_num_rows($s_res);
        $tmp = array();
        $s_array = array();
        if($r > 0)
        {
            while($s = mysql_fetch_array($s_res)){
                $userName = $s['personelNumber'];
                $ud = $this->getUserByUserName($userName);
                $s['userData'] = $ud; 
                $tmp[] = $s;   
            }
            $tmp['count'] = $r;
            $tmp['rtype'] = "fo";
            return $tmp;
        }
        
        $error = array('status' => "Failed", "msg" => "Request to view users was denied.");
        $this->api->response($this->api->json($error), 400);
    }
    
    public function getFOByUsername($userID) {
        if($userID != NULL)
        {
            $s_res = mysql_query("select * from forensicOfficer where personelNumber='$userID'");
            $r = mysql_num_rows($s_res);
            $tmp = array();
            $s_array = array();
            if($r > 0)
            {
                
                while($s = mysql_fetch_array($s_res)){
                    $userName = $s['personelNumber'];
                    $ud = $this->getUserByUserName($userName);
                    $s['userData'] = $ud; 
                    $tmp[] = $s;
                }
            
                $tmp['count'] = $r;
                $tmp['rtype'] = "fo";
                return $tmp;
            }
            
        }
        
        $error = array('status' => "Failed", "msg" => "Request to view user was denied.");
        $this->api->response($this->api->json($error), 400);
    }
    
    public function getFOByUserID($userID) {
        
        try {
           
            $s_res = mysql_query("select * from forensicOfficer where userID=".$userID);
             
            $r = mysql_num_rows($s_res);
            $tmp = array();
            $s_array = array();
            
            if($r > 0)
            {
                while($s = mysql_fetch_array($s_res)){
                    $userName = $s['personelNumber'];
                    $ud = $this->getUserByUserName($userName);
                    $s['userData'] = $ud; 
                    $tmp[] = $s;
                }
            
                $tmp['count'] = $r;
                $tmp['rtype'] = "fo";
                return $tmp;
            }
            $error = array('status' => "Failed", "msg" => "Request to view user was denied.");
            $this->api->response($this->api->json($error), 400);
        } catch (Exception $exc) {
           $error = array('status' => "Failed", "msg" => "Request to view user was denied.");
           $this->api->response($this->api->json($error), 400);
        }
    }
}
