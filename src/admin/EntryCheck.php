<?php
/**
 * Created by PhpStorm.
 * User: Habibzadeh
 * Date: 01/06/2015
 * Time: 12:23 PM
 */

class EntryCheck {
    public function CheckEmail($email){
        if(!empty($email) && preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$email)){
            return true;
        }
        else{
            return false;
        }
    }

    public function CheckPassword($password){
        if(isset($password) && !empty($password) && strlen($password) >= 8){
            return true;
        }
        else{
            return false;
        }
    }

    public function CheckForSamePassword($password,$re_password){
        if($password == $re_password && $this->CheckPassword($password) && $this->CheckPassword($re_password)){
            return true;
        }
        else{
            return false;
        }
    }

    public function CheckUserAccessLevel($level){
        if($level <= 0){
            return false;
        }
        else{
            return true;
        }
    }
}