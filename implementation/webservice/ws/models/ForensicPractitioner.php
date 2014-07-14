<?php
require_once './User.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ForensicPractitioner
 *
 * @author Latitude
 */
class ForensicPractitioner  extends User{
    //put your code here
    private $PersonalNumber;
    private $CellPhoneNumber;
    
    public function addUser($personelNumber,$userID,$cellphoneNumber) {
        $a_res = mysql_query("insert into forensicPractitioner values('$personelNumber',$userID,'$cellphoneNumber')");
        return $a_res;
    }
    
    public function modifyFPUser($formData){
        $a = $this->modifyUser($formData['userName'], $formData['userPassword'], $formData['userFirstname'], $formData['userSurname'], $formData['userTypeID'], $formData['userActive']);        
        if($a)
        {
            $cellNo = $formData['cellphoneNumber'];
            $uname = $formData['userName'];
            return mysql_query("update forensicPractitioner set cellphoneNumber='$cellNo' where personelNumber='$uname'");
        }else {
            $error = array('status' => "Failed", "msg" => "Request to modify user was denied.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    
    public function removeUser($userName,$userID) {
        
        return $this->removeUser($userName, $userID);
    }
    
    public function getAllFPs() {
        $s_res = mysql_query("select * from forensicPractitioner");
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
            $tmp['rtype'] = "fp";
            return $tmp;
        }
        
        $error = array('status' => "Failed", "msg" => "Request to view users was denied.");
        $this->api->response($this->api->json($error), 400);
    }
    
    public function getFPByUsername($userID) {
        if($userID != NULL)
        {
            $s_res = mysql_query("select * from forensicPractitioner where personelNumber='$userID'");
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
                $tmp['rtype'] = "fp";
                return $tmp;
            }
            
        }
        
        $error = array('status' => "Failed", "msg" => "Request to view user was denied.");
        $this->api->response($this->api->json($error), 400);
    }
    
    public function getFPByUserID($userID) {
        
        try {
           
            $s_res = mysql_query("select * from forensicPractitioner where userID=".$userID);
             
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
                $tmp['rtype'] = "fp";
                return $tmp;
            }
            $error = array('status' => "Failed", "msg" => "Request to view user was denied.");
            $this->api->response($this->api->json($error), 400);
        } catch (Exception $exc) {
           $error = array('status' => "Failed", "msg" => "Request to view user was denied.");
           $this->api->response($this->api->json($error), 400);
        }
    }
    
    public function viewAllCases($param) {
        
    }
    
    public function viewCase($param) {
        
    }
    
    public function modifyCase($param) {
        
    }
    
    public function assignDeathRegister($param) {
        
    }
}
