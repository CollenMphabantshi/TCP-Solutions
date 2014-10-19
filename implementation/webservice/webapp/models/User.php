<?php
session_start();

require_once './connect.php';
require_once './Validations.inc.php';
require_once '../encryptions.php';
require_once './Audit.php';
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
    private $enc;
    
    public function __construct($api,$userName=NULL,$userPassword=NULL,$userFirstname=NULL,$userSurname=NULL,$userTypeID=NULL,$userActive=NULL){
        $this->api = $api;
        $this->validation = new Validations();
        $this->enc = new Encryption();
        
        if($userName != NULL && $userPassword != NULL && $userFirstname != NULL && $userSurname != NULL){
            $this->userName = $userName;
            //$arr = $this->validation->createHash($userPassword, 'sha512');
            
            //$this->userPassword = $arr['hash'];
            $this->userPassword = $this->enc->md5_encrypt($userPassword);
            
            $this->userFirstname = $userFirstname;
            $this->userSurname = $userSurname;
            $this->userTypeID = $userTypeID;
            $this->userActive = $userActive;
            $userID = $this->add();
            
            $this->userID = $userID;
        }
    }
    
    public function modifyUser($userName,$userPassword=NULL,$userFirstname=NULL,$userSurname=NULL,$userTypeID=NULL,$userActive=NULL) {
        if($userName != NULL)
        {
            if($userPassword != NULL && $userFirstname != NULL && $userSurname != NULL && $userTypeID > 0 && ($userActive == 0 || $userActive == 1))
            {
                $userPassword = $this->enc->md5_encrypt($userPassword);
                $m_res = mysql_query("select * from users where userName='$userName'");
                $m_arr = mysql_fetch_array($m_res);
                $u_res = mysql_query("update users set userPassword='$userPassword',userFirstname='$userFirstname',userSurname='$userSurname',userTypeID=$userTypeID,userActive=$userActive where userName='$this->userName'");
                if($u_res === TRUE)
                {
                    
                    Audit::audit_log($this->enc->decrypt_request($_SESSION[$this->enc->md5_encrypt('s_nomor')]), "Updated users table. OLD DATA: ".  var_dump($m_arr));
                }
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
    public function add() {
        
        $u_res = mysql_query("select * from users where userName='$this->userName'");
        if (mysql_num_rows($u_res) <= 0) {
            
            $u_res = mysql_query("insert into users values(0,'$this->userName','$this->userPassword','$this->userFirstname','$this->userSurname',$this->userTypeID,$this->userActive)");
            
            
            Audit::audit_log($this->enc->decrypt_request($_SESSION[$this->enc->md5_encrypt('s_nomor')]), "Added new user. DATA: ");
            
            if($u_res !== FALSE)
            {
                $u_res2 = mysql_query("select * from users where userName='$this->userName'");
                $u_array = mysql_fetch_array($u_res2);
                //$u_res = mysql_query("insert into accessMode values(".$u_array['userID'].",'$this->salt')");
                
                return $u_array['userID'];
            }else{
                $error = array('status' => "Failed", "msg" => "Request to add user was denied.");
                $this->api->response($this->api->json($error), 400);
            }
        }else{
            $error = array('status' => "Failed", "msg" => "Request to add user was denied. Duplication detected,");
            $this->api->response('', 400);
        }
        
    }
    
    public function removeUser($userID){
        if($userID > 0){
            $m_res = mysql_query("select * from users where userID='$userID'");
            $m_arr = mysql_fetch_array($m_res);
            $a = mysql_query("update users set userActive=0 where userID='$userID'");
            if($a){
                
                Audit::audit_log($this->enc->decrypt_request($_SESSION[$this->enc->md5_encrypt('s_nomor')]), "deactivated a user. DATA: ".  var_dump($m_arr));
                $error = array('status' => "Success", "msg" => "Request to remove user was successful.");
                $this->api->response($this->api->json($error), 200);
            }else{
                $error = array('status' => "Failed", "msg" => "Request to remove user was denied.");
                $this->api->response($this->api->json($error), 400);
            }
        }
        return FALSE;
    }
    
    public function activateUser($userID) {
        if($userID > 0){
            $m_res = mysql_query("select * from users where userID='$userID'");
            $m_arr = mysql_fetch_array($m_res);
            $a = mysql_query("update users set userActive=1 where userID='$userID'");
            if($a){
                
                Audit::audit_log($this->enc->decrypt_request($_SESSION[$this->enc->md5_encrypt('s_nomor')]), "activated a user. DATA: ".  var_dump($m_arr));
                $error = array('status' => "Success", "msg" => "Request to activate user was successful.");
                $this->api->response($this->api->json($error), 200);
            }else{
                $error = array('status' => "Failed", "msg" => "Request to activate user was denied.");
                $this->api->response($this->api->json($error), 400);
            }
        }
        return FALSE;
    }
    public function getAllUsers() {
        $u_res = mysql_query("select * from users order by userID desc");
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
    public function findUsers($param) {
        if(strlen($param) === 0 || $param === NULL) return null;
        
        $u_res = mysql_query("select * from users where userName LIKE '$param%' or userFirstname LIKE '$param%' or userSurname LIKE '$param%' order by userID desc");
        if($u_res !== NULL){
            $arr = array();
            while($u_arr = mysql_fetch_array($u_res)){
                $arr[] = $u_arr;
            }
            if(count($arr) > 0)
            {
                return $arr;
            }
        }
        
        $error = array('status' => "Failed", "msg" => "No result found for ther user: ".$param);
        $this->api->response($this->api->json($error), 400);
    }
    
    public function sortUsers($param) {
        if(strlen($param) === 0 || $param === NULL) return null;
        $u_res = null;
        if($param === "active")
        {
            $u_res = mysql_query("select * from users where userActive=1");
        }else{
            $u_res = mysql_query("select * from users where userActive=0");
        }
        if($u_res !== NULL && $u_res !== FALSE){
            $arr = array();
            while($u_arr = mysql_fetch_array($u_res)){
                $arr[] = $u_arr;
            }
            if(count($arr) > 0)
            {
                return $arr;
            }
        }
        
        $error = array('status' => "Failed", "msg" => "No result found for ther user: ".$param);
        $this->api->response($this->api->json($error), 400);
    }
    
    public function login($userName,$userPassword,$platform){
        if($userName != NULL && $userPassword != NULL && $platform != NULL)
        {
            $this->userName = $userName;
            $this->userPassword = $this->enc->md5_encrypt($userPassword);
            $error = array('status' => "Failed", "msg" => "Request to login was denied. Invalid username or password.");
            
            $u_res = mysql_query("select * from users where userName='$this->userName' and userPassword='$this->userPassword'")
                    or $this->api->response($this->api->json($error), 400);
            if(mysql_num_rows($u_res) > 0){
                $u_array = mysql_fetch_array($u_res);
                if($u_array['userActive'] == 1)
                {
                    
                    if($platform === "webapp")
                    {
                        $_SESSION[$this->enc->md5_encrypt('s_ip')] = $this->enc->md5_encrypt($_SERVER['REMOTE_ADDR']);
                        $_SESSION[$this->enc->md5_encrypt('s_ua')] = $this->enc->md5_encrypt($_SERVER['HTTP_USER_AGENT']);
                        $_SESSION[$this->enc->md5_encrypt('s_nomor')] = $this->enc->encrypt_request($u_array['userID']);
                        $_SESSION[$this->enc->md5_encrypt('s_ac')] = $this->enc->md5_encrypt("".$u_array['userTypeID']);
                        
                        $m_res = $u_array;
                        Audit::audit_log($this->enc->decrypt_request($_SESSION[$this->enc->md5_encrypt('s_nomor')]),
                                "Logged On.");
                        
                        //session_set_cookie_params(60);
                        $error = array('status' => "Success", "msg" => "Request to login was accepted.");
                        $this->api->response($this->api->json($error), 200);
                    }else if($platform === "droid"){
                        // Generate session key for android session
                        
                        $error = array('status' => "Success", "msg" => "Request to login was accepted.", "key" => "sess_key:1");
                        $this->api->response($this->api->json($error), 200);
                    }
                    
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
    
 public function logout() {
     $m_res = $u_array;
     Audit::audit_log($this->enc->decrypt_request($_SESSION[$this->enc->md5_encrypt('s_nomor')]), "Logged Out.");
     session_unset();
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
