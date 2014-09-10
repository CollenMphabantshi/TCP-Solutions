<?php

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
class Audit {
    //put your code here
    public static function audit_log($userID,$action) {
        $date = date("Y-m-d");
        $time = time();
        $al_res = mysql_query("insert into audit_log values(0,$userID,'$date','$time','$action')");
    }
}
