<?php

require 'db.php';

class Register_Mdl {

    var $conn;
    function __construct() {
          $this->db = new DB();
    }

/////// get user login details
    function get_login_details($username, $txtpswd) 
    {
        $sql = "select id,email,mobile,password,name,last_name,profile_uniqueid from user where mobile='$username' and (department_id='4' or department_id='3')";
        return $this->db->executeQuery($sql);
    }
     function get_login_details_byid($id) 
     {
        $sql = "select id,IFNULL(name,'') as name,IFNULL(last_name,'') as last_name,IFNULL(user_code,'') as user_code,IFNULL(email,'') as email,IFNULL(mobile,'') as mobile,department_id,gender,IFNULL(dob,'') as dob,IFNULL(postcode,'') as postcode,
        IFNULL(address,'') as address,IFNULL(city,'') as city,IFNULL(street,'') as street,IFNULL(profile_photo,'') as profile_photo,IFNULL(fb_id,'') as fb_id,IFNULL(google_id,'') as google_id,IFNULL(about,'') as about,status,mobile_verified,log_date_created from user where 1=1 and id='$id'";
        return $this->db->executeQuery($sql);
    }
    function get_flag_details($id, $flag) 
    {
        $sql = "select id,IFNULL(name,'') as name,IFNULL(last_name,'') as last_name,IFNULL(user_code,'') as user_code,IFNULL(email,'') as email,IFNULL(mobile,'') as mobile,department_id,gender,IFNULL(dob,'') as dob,IFNULL(postcode,'') as postcode,
        IFNULL(address,'') as address,IFNULL(street,'') as street,IFNULL(city,'') as city,IFNULL(profile_photo,'') as profile_photo,IFNULL(fb_id,'') as fb_id,IFNULL(google_id,'') as google_id,IFNULL(about,'') as about,status,mobile_verified,
        log_date_created,IFNULL(no_vendor,'') as no_vendor from user where 1=1 ";
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

    function get_flag_details_password($id, $flag,$password) 
    {
        $sql = "select id,IFNULL(name,'') as name,IFNULL(last_name,'') as last_name,IFNULL(user_code,'') as user_code,IFNULL(email,'') as email,IFNULL(mobile,'') as mobile,department_id,gender,IFNULL(dob,'') as dob,IFNULL(postcode,'') as postcode,
        IFNULL(address,'') as address,IFNULL(street,'') as street,IFNULL(city,'') as city,IFNULL(profile_photo,'') as profile_photo,IFNULL(fb_id,'') as fb_id,IFNULL(google_id,'') as google_id,IFNULL(about,'') as about,status,mobile_verified,
        log_date_created,IFNULL(no_vendor,'') as no_vendor from user where 1=1 ";
        if($flag=='webmobile' && $password!='')
        {
            $sql.= " and mobile='$id' and password='$password'";
        }
        //echo $sql;
        return $this->db->executeQuery($sql);
    }
    function fetch_sms_setting()
    {
    	$sql = 'select * from smssettings where status="Active"';
    	return $this->db->executeQuery($sql);
    }
    function fetch_one_column($table,$column,$where)
    {
        $sql = "SELECT $column as dbval FROM $table WHERE $where";
        $result =  $this->db->executeQuery($sql);
        return $result[0]['dbval'];
    }
    function insert_notification($user_id,$title,$message)
    {
        $date=date('Y-m-d H:i:s');
        $sql = "insert into notification(user_id,title,message,is_read,is_sent,sent_date,is_recieved,recieved_date,log_date_created) 
        values('$user_id','$title','$message','No','Yes','$date','Yes','$date','$date')";
        return $this->db->getinsertidQuery($sql);
    }
    function check_mobile_exist($mobile)
    {
    	$sql ='SELECT COUNT(*) as count_user FROM user u LEFT JOIN department d ON d.id=u.department_id 
               WHERE 1=1 AND u.mobile="'.$mobile.'" and (d.id="3" or d.id="4")';
    	return $this->db->executeQuery($sql);
    }   

    function check_email_exist($email)
    {
        $sql ='SELECT COUNT(*) as count_user FROM user u LEFT JOIN department d ON d.id=u.department_id 
               WHERE 1=1 AND u.email="'.$email.'" and (d.id="3" or d.id="4")';
        return $this->db->executeQuery($sql);
    }   


    function check_mobile_verified($mobile)
    {
    	$sql ='SELECT COUNT(*) as count_user FROM user u LEFT JOIN department d ON d.id=u.department_id WHERE d.name="user" AND u.mobile="'.$mobile.'" AND u.mobile_verified!="Yes"';
    	return $this->db->executeQuery($sql);
    }

    function register($data)
    {
        $date=date('Y-m-d H:i:s');
    	$sql = 'insert into user (department_id,name,last_name,user_code,email,mobile,gender,dob,mobile_verified,fb_id,google_id,postcode,address,city,street,profile_photo,status,
    	log_date_created,latitude,longitude,password)values
    	("4","' . $data['name'] . '","' . $data['last_name'] . '","' . $data['user_code'] . '","' . $data['email'] . '","' . $data['mobile'] . '","' . $data['gender'] . '","' . $data['dob'] .'",
    	"No","'.$data['fb_id'].'","'.$data['google_id'].'","'.$data['post_code'].'","'.$data['address'].'","'.$data['city'].'","'.$data['street'].'","'.$data['profile_pic'].'",
    	"Active","'.$date.'","'.$data['latitude'].'","'.$data['longitude'].'","'.$data['password'].'")';
    	return $this->db->getinsertidQuery($sql);
    }

    function insert_access($user_id,$type,$ip,$address,$api_token)
    {
        $date=date('Y-m-d H:i:s');
        $sql = 'insert into access_log_details (user_id,type,browser,ip_address,location,imei_no,token_no,login_time)
        values
        ("'.$user_id.'","'.$type.'","'.$type.'","'.$ip.'","'.$address.'","","'.$api_token.'","'.$date.'")';
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
        $sql = 'UPDATE user SET mobile_verified="Yes" WHERE mobile="'.$mobile.'" and id="'.$user_id.'"';
        return $this->db->boolean_executeQuery($sql);
    }
    function update_fcm($mobile,$user_id,$fcm_token,$device_id)
    {
        $sql = 'UPDATE user SET fcm_token="'.$fcm_token.'",device_id="'.$device_id.'" WHERE mobile="'.$mobile.'" and id="'.$user_id.'"';
        return $this->db->boolean_executeQuery($sql);
    }
     function get_user_details($mobile)
    {
        $sql = 'SELECT * FROM user WHERE mobile="'.$mobile.'"';
        return $this->db->executeQuery($sql);
    }
}