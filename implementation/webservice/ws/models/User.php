<?php
session_start();

require_once './connect.php';
require_once './Validations.inc.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author Latitude
 */
class User {
    //put your code here
    private $userID;
    private $userName;
    private $userPassword;
    private $userFirstname;
    private $userSurname;
    private $userTypeID;
    private $userActive;
    private $salt;
    public $api;
    private $validation;
    
    public function __construct($api,$userName=NULL,$userPassword=NULL,$userFirstname=NULL,$userSurname=NULL,$userTypeID=NULL,$userActive=NULL){
        $this->api = $api;
        $this->validation = new Validations();
        if($userName != null && $userPassword != null && $userFirstname != null && $userSurname != null){
            $this->userName = $userName;
            $arr = $this->validation->createHash($userPassword, 'sha512');
            //$this->userPassword = $arr['hash'];
            $this->userPassword = md5($userPassword);
            $this->salt = $arr['salt'];
            $this->userFirstname = $userFirstname;
            $this->userSurname = $userSurname;
            $this->userTypeID = $userTypeID;
            $this->userActive = $userActive;
            $userID = $this->addUser();
            
            $this->userID = $userID;
        }
    }
    
    public function modifyUser($userName,$userPassword=NULL,$userFirstname=NULL,$userSurname=NULL,$userTypeID=NULL,$userActive=NULL) {
        if($userName != NULL)
        {
            if($userPassword != NULL && $userFirstname != NULL && $userSurname != NULL && $userTypeID > 0 && ($userActive == 0 || $userActive == 1))
            {
                $userPassword = md5($userPassword);
                $u_res = mysql_query("update users set userPassword='$userPassword',userFirstname='$userFirstname',userSurname='$userSurname',userTypeID=$userTypeID,userActive=$userActive where userName='$this->userName'");
                return $u_res;
            }else{
                $error = array('status' => "Failed", "msg" => "Request to modify user was denied.");
                $this->api->response($this->api->json($error), 400);
            }
        }else{
            $error = array('status' => "Failed", "msg" => "Request to modify user was denied.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    private function addUser() {
        
        $u_res = mysql_query("select * from users where userName='$this->userName'");
        if (mysql_num_rows($u_res) <= 0) {
            
            $u_res = mysql_query("insert into users values(0,'$this->userName','$this->userPassword','$this->userFirstname','$this->userSurname',$this->userTypeID,$this->userActive)");
            
            $u_res = mysql_query("select * from users where userName='$this->userName'");
            $u_array = mysql_fetch_array($u_res);
            if($u_array['userID'] != NULL)
            {
                //$u_res = mysql_query("insert into accessMode values(".$u_array['userID'].",'$this->salt')");
                return $u_array['userID'];
            }else{
                $error = array('status' => "Failed", "msg" => "Request to add user was denied.");
                $this->api->response($this->api->json($error), 400);
            }
        }else{
            $error = array('status' => "Failed", "msg" => "Request to add user was denied. Duplication was detected.");
            $this->api->response($this->api->json($error), 400);
        }
        
    }
    
    public function removeUser($userName,$userID) {
        if($userName != NULL)
        {
            $a = mysql_query("update users set userActive=0 where userName='$userName'");
            if($a){
                $error = array('status' => "Success", "msg" => "Request to remove user was successful.");
                $this->api->response($this->api->json($error), 200);
            }else{
                $error = array('status' => "Failed", "msg" => "Request to remove user was denied.");
                $this->api->response($this->api->json($error), 400);
            }
        }else if($userID > 0){
            $a = mysql_query("update users set userActive=0 where userID='$userID'");
            if($a){
                $error = array('status' => "Success", "msg" => "Request to remove user was successful.");
                $this->api->response($this->api->json($error), 200);
            }else{
                $error = array('status' => "Failed", "msg" => "Request to remove user was denied.");
                $this->api->response($this->api->json($error), 400);
            }
        }
        return FALSE;
    }
    
    public function getAllUsers() {
        $u_res = mysql_query("select * from users");
        $r = mysql_num_rows($u_res);
        if($r > 0)
        {
            $u_array = array();
            while(($ua = mysql_fetch_array($u_res))){
                $u_array[] = $ua;
            }
            $u_array['count'] = $r;
            $u_array['rtype'] = "users";
            return $u_array;
        }else{
            $error = array('status' => "Failed", "msg" => "Request to view users was denied.");
            $this->api->response($this->api->json($error), 400);
        }
        
    }
    
    public function getUserByID($userID) {
        $u_res = mysql_query("select * from users where userID=".$userID);
        if(mysql_num_rows($u_res) > 0)
        {
            $u_array = mysql_fetch_array($u_res);
            if($u_array['userID'] != NULL)
            {
                $u_array['count'] = 1;
                $u_array['rtype'] = "users";
                return $u_array;
            }else {
                $error = array('status' => "Failed", "msg" => "Request to get user was denied.");
                $this->api->response($this->api->json($error), 400);
            }
        }else{
            $error = array('status' => "Failed", "msg" => "Request to view users was denied.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    
    public function getUserByUserName($userName) {
        $u_res = mysql_query("select * from users where userName='$userName'");
        if(mysql_num_rows($u_res) > 0)
        {
            $u_array = mysql_fetch_array($u_res);
            if($u_array['userID'] != NULL)
            {
                $u_array['count'] = 1;
                $u_array['rtype'] = "users";
                return $u_array;
            }else {
                $error = array('status' => "Failed", "msg" => "Request to get user was denied.");
                $this->api->response($this->api->json($error), 400);
            }
        }else{
            $error = array('status' => "Failed", "msg" => "Request to view users was denied.");
            $this->api->response($this->api->json($error), 400);
        }
    }

        public function login($userName,$userPassword,$platform){
        if($userName != NULL && $userPassword != NULL && $platform != NULL)
        {
            $this->userName = $userName;
            $this->userPassword = md5($userPassword);
            $error = array('status' => "Failed", "msg" => "Request to login was denied. Invalid username or password.");
            $u_res = mysql_query("select * from users where userName='$this->userName' and userPassword='$this->userPassword'")
                    or $this->api->response($this->api->json($error), 400);
            if(mysql_num_rows($u_res) > 0){
                $u_array = mysql_fetch_array($u_res);
                if($u_array['userActive'] == 1)
                {
                    if($platform == "webapp")
                    {
                        $_SESSION['s_ip'] = $_SERVER['REMOTE_ADDR'];
                        $_SESSION['s_ua'] = $_SERVER['HTTP_USER_AGENT'];
                        $_SESSION['s_id'] = $u_array['userID'];
                    }
                    $error = array('status' => "Success", "msg" => "Request to login was accepted.");
                    $this->api->response($this->api->json($error), 400);
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to login was denied. The User is not active.");
                    $this->api->response($this->api->json($error), 400);
                }
            }else{
                $error = array('status' => "Failed", "msg" => "Request to login was denied. Invalid Password or Username.");
                $this->api->response($this->api->json($error), 400);
            }
        }else {
            $error = array('status' => "Failed", "msg" => "Request to login was denied. Please provide all the required details.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    /*public function login($userName,$userPassword,$platform){
        if($userName != NULL && $userPassword != NULL && $platform != NULL)
        {
            $validation = new Validations();
            $this->userName = $userName;
            $this->userPassword = $userPassword;
            
            $error = array('status' => "Failed", "msg" => "Request to login was denied. Invalid username or password.");
            $am_res = mysql_query("select * from accessMode")
                    or $this->api->response($this->api->json($error), 400);
            while(($arr = mysql_fetch_array($am_res)))
            {
                $uid = $arr['uid'];
                $u_res = mysql_query("select * from users where userID=$uid and userName='$this->userName'");
                
                if(mysql_num_rows($u_res) > 0){
                    $u_array = mysql_fetch_array($u_res);
                    if($this->validation->validateLogin($pass,$u_array['userPassword'], $arr['salt'],'sha512')){
                        if($u_array['userActive'] == 1)
                        {
                            if($platform == "webapp")
                            {
                                $_SESSION['s_ip'] = $_SERVER['REMOTE_ADDR'];
                                $_SESSION['s_ua'] = $_SERVER['HTTP_USER_AGENT'];
                                $_SESSION['s_id'] = $u_array['userID'];
                            }
                            $error = array('status' => "Success", "msg" => "Request to login was accepted.");
                            $this->api->response($this->api->json($error), 400);
                        }else{
                            $error = array('status' => "Failed", "msg" => "Request to login was denied. The User is not active.");
                            $this->api->response($this->api->json($error), 400);
                        }
                    }else{
                        $error = array('status' => "Failed", "msg" => "Request to login was denied.");
                        $this->api->response($this->api->json($error), 400);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to login was denied. Invalid Password or Username.");
                    $this->api->response($this->api->json($error), 400);
                }
            }
        }else {
            $error = array('status' => "Failed", "msg" => "Request to login was denied. Please provide all the required details.");
            $this->api->response($this->api->json($error), 400);
        }
    }*/
    
 public function logout() {
     session_destroy();
     $error = array('status' => "Success", "msg" => "Request to logout was successfull.");
     $this->api->response($this->api->json($error), 200);
 }
    public function getUserID() {
        if($this->userID != NULL)
        {
            return $this->userID;
        }
        else{
            $error = array('status' => "Failed", "msg" => "Request to get user was denied.");
            $this->api->response($this->api->json($error), 400);
        }
    }
}
