<?php
/**
 * Created by PhpStorm.
 * User: Habibzadeh
 * Date: 01/06/2015
 * Time: 03:47 PM
 */
require(dirname(__FILE__).'/inc/config.php');

class ManageDatabase {

    public $MySql;
    public $IsConnected = false;

    public function ManageDatabase(){
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

    public function InsertToDatabase($email,$password){
        $domainName = explode('@',$email);
        if(!isset($domainName[1]))
            return false;
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
        $query = $this->GetQueryString('domains').' WHERE name="'.$domainName[1].'" LIMIT 1';
        $query_result = $this->MySql->query($query);
        if($query_result){
            if($query_result->num_rows > 0){
                $row = $query_result->fetch_row();
                $domain_id = $row[0];
                $query_result->close();
                return $this->InsertEmail($email,$password,$domain_id);
            }
            else{
                $query_result->close();
                $domain_id = $this->InsertDomain($domainName[1]);
                if($domain_id > 0){
                    return $this->InsertEmail($email,$password,$domain_id);
                }
            }
        }
        return false;
    }

    private function InsertDomain($domain){
        $domain = $this->MySql->real_escape_string($domain);
        $insert_query = $this->GetQueryString('insert_domain') . '("' . $domain . '");';
        if($this->IsConnected){
            $result = $this->MySql->query($insert_query);
            if($result){
                $insert_id = $this->MySql->insert_id;
                $this->MySql->commit();
                return $insert_id;
            }
        }
        return 0;
    }

    private function InsertEmail($email,$password,$domain_id){
        $email = $this->MySql->real_escape_string($email);
        $password = $this->MySql->real_escape_string($password);
        $insert_query = $this->GetQueryString('insert_email_part_1') . $domain_id . $this->GetQueryString('insert_email_part_2') . "'" . $password . "'" . $this->GetQueryString('insert_email_part_3') . "'" . $email . "'" . ");" ;
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

    public function CheckForEmailRecord($email){
        $email = $this->MySql->real_escape_string($email);
        $query = $this->GetQueryString('check_email'). '"' . $email . '"';
        $query_result = $this->MySql->query($query);
        if($query_result){
            $row = $query_result->fetch_row();
            $query_result->close();
            return $row[0];
        }
        else{
            return 0;
        }
    }

    public function UpdateEmail($id,$password){
        $password = $this->MySql->real_escape_string($password);
        $query = $this->GetQueryString('update_email_password_part_1') . "'" . $password . "'" . $this->GetQueryString('update_email_password_part_2') . $id . ';';
        $query_result = $this->MySql->query($query);
        if($query_result){
            $this->MySql->commit();
            return true;
        }
        return false;
    }

    public function DeleteEmail($id){
        $query = $this->GetQueryString('delete_email') . $id;
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
            case 'emails':
                return "SELECT virtual_users.id,virtual_users.email FROM virtual_users ORDER BY virtual_users.id;";
                break;
            case 'domains':
                return "SELECT  virtual_domains.id,virtual_domains.name FROM virtual_domains ";
                break;
            case 'delete_email':
                return "DELETE FROM virtual_users WHERE id=";
                break;
            case 'insert_domain':
                return "INSERT INTO virtual_domains (name) VALUES ";
                break;
            case 'insert_email_part_1':
                return "INSERT INTO virtual_users (domain_id, password, email) VALUES(";
                break;
            case 'insert_email_part_2':
                return ",ENCRYPT(";
                break;
            case 'insert_email_part_3':
                return ", CONCAT('$6$', SUBSTRING(SHA(RAND()), -16))),";
                break;
            case 'check_email':
                return "SELECT virtual_users.id,virtual_users.email FROM virtual_users WHERE email=";
                break;
            case 'update_email_password_part_1':
                return "UPDATE virtual_users SET password=ENCRYPT(";
                break;
            case 'update_email_password_part_2':
                return ", CONCAT('$6$', SUBSTRING(SHA(RAND()), -16))) WHERE id=";
                break;
        }
    }
}
