<?php
require_once './User.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Administrator
 *
 * @author Latitude
 */


class Administrator  extends User{
    //put your code here
    public function __construct($api,$userName=NULL,$userPassword=NULL,$userFirstname=NULL,$userSurname=NULL,$userTypeID=NULL,$userActive=NULL){
        parent::__construct($api, $userName, $userPassword, $userFirstname, $userSurname, $userTypeID, $userActive);
       
    }
    public function addUser($personelNumber,$userID) {
        
        $a_res = mysql_query("insert into administrator values('$personelNumber',$userID)");
        return $a_res;
    }
    
    public function modifyAdminUser($formData) {
        
        $a = $this->modifyUser($formData['userName'], $formData['userPassword'], $formData['userFirstname'], $formData['userSurname'], $formData['userTypeID'], $formData['userActive']);        
        return $a;
    }
    
    public function removeUser($userName,$userID) {
        
        return $this->removeUser($userName, $userID);
    }
    
    public function getAllAdmins() {
        $s_res = mysql_query("select * from administrator");
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
            $tmp['rtype'] = "administrator";
            return $tmp;
        }
        
        $error = array('status' => "Failed", "msg" => "Request to view users was denied.");
        $this->api->response($this->api->json($error), 400);
    }
    
    public function getAdminByUsername($userID) {
        if($userID != NULL)
        {
            $s_res = mysql_query("select * from administrator where personelNumber='$userID'");
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
                $tmp['rtype'] = "administrator";
                return $tmp;
            }
            
        }
        
        $error = array('status' => "Failed", "msg" => "Request to view user was denied.");
        $this->api->response($this->api->json($error), 400);
    }
    
    public function getAdminByUserID($userID) {
        
        try {
           
            $s_res = mysql_query("select * from administrator where userID=".$userID);
             
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
                $tmp['rtype'] = "administrator";
                return $tmp;
            }
            $error = array('status' => "Failed", "msg" => "Request to view user was denied.");
            $this->api->response($this->api->json($error), 400);
        } catch (Exception $exc) {
           $error = array('status' => "Failed", "msg" => "Request to view user was denied.");
           $this->api->response($this->api->json($error), 400);
        }
    }
    
    public function viewAllUsers() {
        return false;
    }
    
    public function viewUser($userID) {
        return false;
    }
    
    public function assignCase($userID) {
        return false;
    }
}

?>