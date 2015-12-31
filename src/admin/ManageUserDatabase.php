<?php
/**
 * Created by PhpStorm.
 * User: Habibzadeh
 * Date: 01/06/2015
 * Time: 03:47 PM
 */
require(dirname(__FILE__).'/inc/config.php');

class ManageUserDatabase {

    public $MySql;
    public $IsConnected = false;

    public function ManageUserDatabase(){
        $this->MySql = new mysqli();
        $this->MySql->connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        if($this->MySql->connect_error){
            $this->IsConnected = false;
            return false;
        }
        else{
            $this->IsConnected = true;
            return true;
        }
    }

    public function CheckForExistingUser($email){
        $email = $this->MySql->real_escape_string($email);
        if(!$this->IsConnected){
            $this->MySql = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
            if($this->MySql->connect_error){
                $this->IsConnected = false;
                return false;
            }
            else{
                $this->IsConnected = true;
            }
        }
        $query = $this->GetQueryString('find_user')."'".$email."' LIMIT 1";
        $query_result = $this->MySql->query($query);
        $user_id = 0;
        if($query_result){
            if($query_result->num_rows > 0){
                $row = $query_result->fetch_row();
                $user_id = $row[0];
            }
            $query_result->close();
        }
        return $user_id;
    }


    public function InsertUser($email,$password,$level){
        $email = $this->MySql->real_escape_string($email);
        $password = $this->MySql->real_escape_string($password);
        $md5_password = md5($password);
        $insert_query = $this->GetQueryString('insert') . "'" . $email . "','" . $md5_password ."'," . $level . ");";
        if($this->IsConnected){
            if($this->MySql->query($insert_query)){
                $insert_id = $this->MySql->insert_id;
                $this->MySql->commit();
                if($insert_id > 0)
                    return true;
            }
        }
        return false;
    }


    public function UpdateUser($id,$password,$level){
        $password = $this->MySql->real_escape_string($password);
        $md5_password = md5($password);
        $query = $this->GetQueryString('update_part_1') . "'" . $md5_password . "'" . $this->GetQueryString('update_part_2') . $level . $this->GetQueryString('update_part_3') . $id . ';';
        $query_result = $this->MySql->query($query);
        if($query_result){
            $this->MySql->commit();
            return true;
        }
        return false;
    }

    public function DeleteUser($id){
        $query = $this->GetQueryString('delete') . $id . ';';
        $query_result = $this->MySql->query($query);
        if($query_result){
            $this->MySql->commit();
            return true;
        }
        return false;
    }

    public function Close(){
        $this->MySql->close();
        $this->IsConnected = false;
    }

    public function GetQueryString($identifier){
        switch($identifier){
            case 'users':
                return "SELECT phpSP_users.primary_key,phpSP_users.user,phpSP_users.userlevel FROM phpSP_users;";
                break;
            case 'find_user':
                return "SELECT phpSP_users.primary_key,phpSP_users.user FROM phpSP_users WHERE user=";
                break;
            case 'insert':
                return "INSERT INTO phpSP_users (user, password, userlevel) VALUES (";
                break;
            case 'delete':
                return "DELETE FROM phpSP_users WHERE primary_key=";
                break;
            case 'update_part_1':
                return "UPDATE phpSP_users SET password=";
                break;
            case 'update_part_2':
                return ",userlevel=";
                break;
            case 'update_part_3':
                return " WHERE primary_key=";
                break;
        }
    }
}
