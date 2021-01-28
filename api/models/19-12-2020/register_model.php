<?php

require 'db.php';

class Register_Mdl {

    var $conn;
    function __construct() {
          $this->db = new DB();
    }

/////// get user login details
    function get_login_details($username, $txtpswd) {
        $sql = "select id,email,mobile,password,name,last_name,profile_uniqueid from user where mobile='$username' and (department_id='4' or department_id='3')";
        return $this->db->executeQuery($sql);
    }
     function get_login_details_byid($id) {
        $sql = "select id,email,mobile,password,name,last_name,profile_uniqueid from user where id='$id' and department_id=21";
        return $this->db->executeQuery($sql);
    }
    function get_flag_details($id, $flag) 
    {
        $sql = "select id,IFNULL(name,'') as name,IFNULL(last_name,'') as last_name,IFNULL(user_code,'') as user_code,IFNULL(email,'') as email,IFNULL(mobile,'') as mobile,department_id,gender,IFNULL(dob,'') as dob,IFNULL(postcode,'') as postcode,
        IFNULL(address,'') as address,IFNULL(street,'') as street,IFNULL(profile_photo,'') as profile_photo,IFNULL(fb_id,'') as fb_id,IFNULL(google_id,'') as google_id,IFNULL(about,'') as about,status,mobile_verified,log_date_created from user where 1=1 ";
        if($flag=='fb')
        {
            $sql.=" and fb_id='$id'";
        }
        else if($flag=='google')
        {
            $sql.=" and google_id='$id'";
        }
        else if($flag=='mobile')
        {
            $sql.= " and mobile='$id'";
        }
        //echo $sql;
        return $this->db->executeQuery($sql);
    }
    function fetch_sms_setting()
    {
    	$sql = 'select * from sms_settings where status="Active"';
    	return $this->db->executeQuery($sql);
    }

    function check_mobile_exist($mobile)
    {
    	$sql ='SELECT COUNT(*) as count_user FROM user u LEFT JOIN department d ON d.id=u.department_id WHERE d.name="user" AND u.mobile="'.$mobile.'" AND u.mobile_verified="Yes"';
    	return $this->db->executeQuery($sql);
    }

    function check_mobile_verified($mobile)
    {
    	$sql ='SELECT COUNT(*) as count_user FROM user u LEFT JOIN department d ON d.id=u.department_id WHERE d.name="user" AND u.mobile="'.$mobile.'" AND u.mobile_verified!="Yes"';
    	return $this->db->executeQuery($sql);
    }

    function register($data,$otp)
    {
    	$sql = 'insert into user (department_id,name,profile_uniqueid,email,mobile,password,mobile_verified,status,log_date_created,otp,fb_id,gplus_id)values
    	("21","' . $data['name'] . '","' . $data['uniq_id'] . '","' . $data['email'] . '","' . $data['mobile'] . '","' . $data['password'] . '","No","Active",
    	"' . $data['date_added'] . '","'.$otp.'","'.$data['fb_id'].'","'.$data['gplus_id'].'")';
    	return $this->db->getinsertidQuery($sql);
    }

    function update_user_otp($mobile,$otp,$user_id)
    {
       $date=date('Y-m-d H:i:s');
       $sql = 'insert into user_otp(user_id,mobile,otp,log_date_created) 
       values("'.$user_id.'","'.$mobile.'","'.$otp.'","'.$date.'")';
       return $this->db->getinsertidQuery($sql);
    }

    function check_otp($mobile,$otp,$user_id)
    {
        $sql ='SELECT COUNT(*) as count_user FROM user_otp WHERE mobile="'.$mobile.'" AND otp="'.$otp.'"
        and user_id="'.$user_id.'"';
        return $this->db->executeQuery($sql);
    }

    function verify_user($mobile,$user_id)
    {
        $sql = 'UPDATE user SET mobile_verified="Yes" WHERE mobile="'.$mobile.'" and user_id="'.$user_id.'"';
        return $this->db->boolean_executeQuery($sql);
    }
    
     function get_user_details($mobile)
    {
        $sql = 'SELECT * FROM user WHERE mobile="'.$mobile.'"';
        return $this->db->executeQuery($sql);
    }
}