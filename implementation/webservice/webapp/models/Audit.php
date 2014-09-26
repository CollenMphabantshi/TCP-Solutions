<?php
try{
    session_start();
}catch(Exception $ex){}
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Audit
 *
 * @author Latitude
 */
require_once './connect.php';
require_once '../encryptions.php';
class Audit {
    //put your code here
    public static function audit_log($userID,$action) {
        try{
            $date = date("Y-m-d");
            $time = date("H:i:s",time());
            $al_res = mysql_query("insert into audit_log values(0,$userID,'$date','$time','$action')");
        }catch(Exception $ex){
            
        }
    }
    
    public function getAuditLog() {
        
        $enc = new Encryption();
        if(!empty($_SESSION[$enc->md5_encrypt('s_nomor')]))
        {
            $a_res = mysql_query("select * from audit_log");
            $arr = array();
            if($a_res !== FALSE)
            {
                while($a = mysql_fetch_array($a_res))
                {
                    if(($u_res = mysql_query("select * from users where userID=".$a['audit_uid'])) !== FALSE)
                    {
                        $a['username'] = mysql_result($u_res, 0, 'userName');
                    }
                    $arr[] = $a;
                }
                return $arr;
            }
            
        }
        return FALSE;
    }
    
    public function findAuditLog($param) {
        
        $enc = new Encryption();
        if(!empty($_SESSION[$enc->md5_encrypt('s_nomor')]))
        {
            $us_res = mysql_query("select * from users where userName LIKE '$param%'");
            $a_res = FALSE;
            if(mysql_num_rows($us_res) > 0)
            {
                
                $a_res = mysql_query("select * from audit_log where audit_uid=".  mysql_result($us_res, 0,'userID'));
            }else{
                
                $a_res = mysql_query("select * from audit_log where audit_date LIKE '$param%'"
                    . " or audit_time LIKE '$param%' or audit_action LIKE '$param%'");
            }
            $arr = array();
            if($a_res !== FALSE)
            {
                while($a = mysql_fetch_array($a_res))
                {
                    if(($u_res = mysql_query("select * from users where userID=".$a['audit_uid'])) !== FALSE)
                    {
                        $a['username'] = mysql_result($u_res, 0, 'userName');
                    }
                    $arr[] = $a;
                }
                return $arr;
            }
            
        }
        return FALSE;
    }
}
