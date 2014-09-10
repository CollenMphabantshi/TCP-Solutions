<?php
require_once './User.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Student
 *
 * @author Latitude
 */
class Student extends User{
    //put your code here
    private $studentNumber;
    private $cellPhoneNumber;
    
    public function addUser($personelNumber,$userID,$cellphoneNumber) {
        $a_res = mysql_query("insert into student values('$personelNumber',$userID,'$cellphoneNumber')");
        return $a_res;
    }
    
    public function modifyStudentUser($formData){
        $a = $this->modifyUser($formData['userName'], $formData['userPassword'], $formData['userFirstname'], $formData['userSurname'], $formData['userTypeID'], $formData['userActive']);        
        if($a)
        {
            $cellNo = $formData['cellphoneNumber'];
            $uname = $formData['userName'];
            return mysql_query("update student set cellphoneNumber='$cellNo' where studentNumber='$uname'");
        }else{
            $error = array('status' => "Failed", "msg" => "Request to modify user was denied.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    
    public function removeUser($userName,$userID) {
        
        return $this->removeUser($userName, $userID);
    }
    
    public function getAllStudents() {
        $s_res = mysql_query("select * from student");
        $r = mysql_num_rows($s_res);
        $tmp = array();
        $s_array = array();
        if($r > 0)
        {
            while($s = mysql_fetch_array($s_res)){
                $userName = $s['studentNumber'];
                $ud = $this->getUserByUserName($userName);
                $s['userData'] = $ud; 
                $tmp[] = $s;   
            }
            $tmp['count'] = $r;
            $tmp['rtype'] = "student";
            return $tmp;
        }
        
        $error = array('status' => "Failed", "msg" => "Request to view users was denied.");
        $this->api->response($this->api->json($error), 400);
    }
    
    public function getStudentByUsername($userID) {
        if($userID != NULL)
        {
            $s_res = mysql_query("select * from student where studentNumber='$userID'");
            $r = mysql_num_rows($s_res);
            $tmp = array();
            $s_array = array();
            if($r > 0)
            {
                
                while($s = mysql_fetch_array($s_res)){
                    $userName = $s['studentNumber'];
                    $ud = $this->getUserByUserName($userName);
                    $s['userData'] = $ud; 
                    $tmp[] = $s;
                }
            
                $tmp['count'] = $r;
                $tmp['rtype'] = "student";
                return $tmp;
            }
            
        }
        
        $error = array('status' => "Failed", "msg" => "Request to view user was denied.");
        $this->api->response($this->api->json($error), 400);
    }
    
    public function getStudentByUserID($userID) {
        
        try {
           
            $s_res = mysql_query("select * from student where userID=".$userID);
             
            $r = mysql_num_rows($s_res);
            $tmp = array();
            $s_array = array();
             
            if($r > 0)
            {
                while($s = mysql_fetch_array($s_res)){
                    $userName = $s['studentNumber'];
                    $ud = $this->getUserByUserName($userName);
                    $s['userData'] = $ud; 
                    $tmp[] = $s;
                }
            
                $tmp['count'] = $r;
                $tmp['rtype'] = "student";
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
