<?php
error_reporting(0);
require 'db.php';
date_default_timezone_set('Asia/Kolkata');
class Common_Mdl {

    var $conn;
    function __construct() {
          $this->db = new DB();
    }
    
    function check_email_exist($email)
    {
        $sql ='SELECT *,u.id as userid FROM user u LEFT JOIN department d ON d.id=u.department_id 
               WHERE 1=1 AND u.email="'.$email.'" and (d.id="3" or d.id="4")';
        return $this->db->executeQuery($sql);
    }
    
    function check_fb_exist($token)
    {
        $sql ='SELECT *,u.id as userid FROM user u LEFT JOIN department d ON d.id=u.department_id 
               WHERE 1=1 AND u.fb_id="'.$token.'" and (d.id="3" or d.id="4")';
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
    function fetch_user_details($user_id)
    {
    $sql   = 'SELECT id,name,user_code,department_id,address,fcm_token,device_id,mobile FROM user WHERE id="'.$user_id.'"';
    $data =  $this->db->executeQuery($sql);
    return $data;
    }
    function insert_notification($user_id,$title,$message)
    {
        $date=date('Y-m-d H:i:s');
        $sql = "insert into notification(user_id,title,message,is_read,is_sent,sent_date,is_recieved,recieved_date,log_date_created) 
        values('$user_id','$title','$message','No','Yes','$date','Yes','$date','$date')";
        return $this->db->getinsertidQuery($sql);
    }
    function fetch_unassigned_service()
    {
        $sql   = 'SELECT id,user_id,code,title,sub_category_id,budget,postal_code,address,date,time FROM task WHERE verified="No"';
        $data =  $this->db->executeQuery($sql);
        return $data;
    }
    function delete_task($user_id,$task_id)
    {
        if($user_id!='' && $task_id!='')
        {
        $sql="delete from task where id='$task_id' and user_id='$user_id'";
        $data =  $this->db->executeQuery($sql);
        return true;
        }
    }
    function update_unassigned_service($id)
    {
        $sql="update task set verified='Yes' where id='$id'";
        //$sql   = 'SELECT id,user_id,code,title,sub_category_id,budget,postal_code,address,date,time FROM task WHERE verified="No"';
        $data =  $this->db->executeQuery($sql);
        return $data;
    }
    function get_vendors_list($ulat,$ulong,$cat_id=NULL)
    {
        $sql   = "SELECT id,mobile,department_id,user_code,name,fcm_token,device_id,
        ( 3959 * acos ( cos ( radians('$ulat') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($ulong) ) + sin ( radians('$ulat') ) * sin( radians( latitude ) ) ) ) AS `distance` 
         FROM `user` where department_id='3' and longitude!='' and latitude!='' and category_id='$cat_id' order by distance";
        $data =  $this->db->executeQuery($sql);
        return $data;
    }
    function assign_service($ref_id,$user_id,$vid,$distance,$date,$time)
    {
        $dt=date('Y-m-d H:i:s');
        $sql1 = 'INSERT INTO `task_assigned`(`task_id`, `user_id`, `vendor_id`, `date`, `time`, `recieve_on`, `distance`) 
            VALUES("'.$ref_id.'","'.$user_id.'","'.$vid.'","'.$date.'","'.$time.'","'.$dt.'",
           "'.$distance.'")';
        $this->db->getinsertidQuery($sql1);
    }
    function fetch_unread_count($user_id)
    {
        $sql = "SELECT count(id) as dbval FROM notification  WHERE is_read='No' and user_id='$user_id'";
        $result =  $this->db->executeQuery($sql);
        return $result[0]['dbval'];
    }
    function fetch_all_notifications($user_id)
    {
        $dt=date('Y-m-d H:i:s');
        $sql = "update notification set is_read='Yes',read_date='$dt' where user_id='$user_id' and is_read='No'";
        $result =  $this->db->executeQuery($sql);
        
        $sqry   = 'SELECT * FROM notification WHERE user_id="'.$user_id.'" order by id desc';
        $data =  $this->db->executeQuery($sqry);
        return $data;
    }
    function fetch_one_column($table,$column,$where)
    {
        $sql = "SELECT $column as dbval FROM $table WHERE $where";
        $result =  $this->db->executeQuery($sql);
        return $result[0]['dbval'];
    }
    function fetch_sms_setting()
    {
    	$sql = 'select * from smssettings where status="Active"';
    	return $this->db->executeQuery($sql);
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

    function fetch_record_count($table,$where)
    {
        $sql = "SELECT count(id) as dbval FROM $table WHERE $where";
        $result =  $this->db->executeQuery($sql);
        return $result[0]['dbval'];
    }
    function fetch_main_categories($limit=NULL)
    {
      $sql = "select id,IFNULL(name,'') as name,IFNULL(attachment,'') as attachment,IFNULL(description,'') as description from category where status='Active' order by priority asc";
      if($limit!='' && $limit!=0)
      {
          $sql.=" limit 0,$limit";
      }
      return $this->db->executeQuery($sql);
    }

    function fetch_main_categories_limit($lstart=NULL,$lend=NULL)
    {
      $sql = "select id,IFNULL(name,'') as name,IFNULL(attachment,'') as attachment,IFNULL(description,'') as description from category where status='Active' order by priority asc";
      if($lstart!='' && $lend!='')
      {
          $sql.=" limit $lstart,$lend";
      }
      return $this->db->executeQuery($sql);
    }
    function fetch_sub_cat_by_catid($id=NULL,$sub_id=NULL,$limit=NULL)
    {
      $sql = "select s.id,s.category_id,s.name as sname,IFNULL(s.description,'') as description,IFNULL(s.instruction,'') as instruction,IFNULL(s.attachment,'') as attachment,c.name as cname,IFNULL(s.big_image,'') as big_image from subcategory s inner join category c
      on s.category_id=c.id where 1=1 ";
      if($id!='')
      {
          $sql.=" and s.category_id='$id'";
      }
      if($sub_id!='')
      {
          $sql.=" and s.id='$sub_id'";
      }
      $sql.=" and s.status='Active' order by s.priority asc";
      if($limit!='' && $limit!=0)
      {
          $sql.=" limit 0,$limit";
      }
      return $this->db->executeQuery($sql);
    }
    function fetch_banners()
    {
      $sql = "select id,IFNULL(type,'') as type,IFNULL(user_type,'') as user_type,IFNULL(file_type,'') as file_type,IFNULL(attachment,'') as attachment,IFNULL(description,'') as description from banner where status='Active' and type='App' order by priority asc";
      return $this->db->executeQuery($sql);
    }

    function fetch_cat_list($keyword)
    {
      $sql = "select s.id as sid,s.category_id as scid,s.name as sname,s.attachment as sattachment,c.id as cid,c.name as cname,
      c.attachment as cattachment from category c inner join subcategory s on c.id=s.category_id where 1=1 and (s.name like '$keyword%' or c.name like '$keyword%') order by sname,cname asc";
      return $this->db->executeQuery($sql);
    }
    function fetch_all_services_data($user_id)
    {
         $sql = "SELECT t.`id` as tid, t.`user_id`, t.`code`, t.`title`, t.`category_id`, t.`sub_category_id`, t.`description`, t.`budget`, t.`postal_code`, t.`city`, t.`address`, t.`land_mark`, t.`date`, t.`time`,
         t.`verified`, t.`status`, t.`log_date_created`, t.`created_by`, t.`log_date_modified`, t.`modified_by`, t.`is_negotiate`,c.`name` as cname,s.`name` as sub_name,s.`attachment` as sattachment FROM `task` t inner join `category` c
         on t.`category_id`=c.`id` inner join subcategory s on t.`sub_category_id`=s.`id` WHERE t.`user_id`='".$user_id."' order by t.`log_date_created` desc";
      return $this->db->executeQuery($sql);
    }
    
    function fetch_all_assigned_data($user_id)
    {
         $sql = "SELECT ta.`id`,ta.`task_id`,ta.`user_id`,ta.`vendor_id`,ta.`date` as assigndate,ta.`time` as assigntime,t.`id` as tid, t.`user_id`, t.`code`, t.`title`, t.`category_id`, t.`sub_category_id`, t.`description`, t.`budget`, t.`postal_code`, t.`city`, t.`address`, t.`land_mark`, t.`date`, t.`time`,
         t.`verified`, t.`status`, t.`log_date_created`, t.`created_by`, t.`log_date_modified`, t.`modified_by`, t.`is_negotiate`,c.`name` as cname,s.`name` as sub_name,s.`attachment` as sattachment FROM `task` t inner join `category` c
         on t.`category_id`=c.`id` inner join subcategory s on t.`sub_category_id`=s.`id` inner join task_assigned ta on t.`id`=ta.`task_id` WHERE ta.`vendor_id`='".$user_id."' order by ta.`id` desc";
      return $this->db->executeQuery($sql);
    }
    
    function fetch_task_status($task_id,$user_id)
    {
        $sql = "select id,user_id,task_id,vendor_id,status,date from task_status where task_id='$task_id' and user_id='$user_id'  order by id desc limit 0,1";
        return $this->db->executeQuery($sql);
    }
    
    function insert_payment()
    {
        $dt=date('Y-m-d H:i:s');
        $sql="insert into task_payment(vendor_id,user_id,task_id,amount,waived_amount,commission,paid_date,payment_status,transaction_no,type,reason,status,log_date_created)
         values('".$this->vendor_id."','".$this->user_id."','".$this->task_id."','".$this->amount."','".$this->waived_amount."','".$this->commission."',
         '".$dt."','".$this->status."','".$this->tr_no."','".$this->paymode."','".$this->reason."','Active','".$dt."')";
         $res=$this->db->getinsertidQuery($sql);
         if($res)
         {
         $sql = 'INSERT INTO `task_status`(`user_id`, `task_id`, `vendor_id`, `date`, `status`, `log_date_created`) 
                VALUES ("'.$this->user_id.'","'.$this->task_id.'","'.$this->vendor_id.'","'.date('Y-m-d H:i:s').'","Paid",
               "'.date('Y-m-d H:i:s').'")';
         return $this->db->getinsertidQuery($sql);
         }
         else
         {
             return true;
         }
         
    }
    
    function fetch_all_payments($user_id)
    {
        $sql="select t.id,t.code,t.title,t.description,t.budget,t.postal_code,t.city,t.address,t.date,t.time,tp.id as tpid,tp.vendor_id,tp.amount,tp.paid_date,tp.payment_status,tp.transaction_no,tp.type
        from task t inner join task_payment tp on t.id=tp.task_id where t.user_id='$user_id'";
        return $this->db->executeQuery($sql);
    }
    
    function fetch_all_transactions($user_id)
    {
        $sql="select * from settlement where user_id='$user_id'";
        return $this->db->executeQuery($sql);
    }
    
    function fetch_vendor_task_status($task_id,$user_id)
    {
        $sql = "select id,user_id,task_id,vendor_id,status,date from task_status where task_id='$task_id' and vendor_id='$user_id'  order by id desc limit 0,1";
        return $this->db->executeQuery($sql);
    }
    
    function fetch_vendor_task_quote($task_id,$user_id)
    {
        $sql = "select id,user_id,task_id,vendor_id,amount,description,status,date from task_quote where task_id='$task_id' and vendor_id='$user_id'  order by id desc limit 0,1";
        return $this->db->executeQuery($sql);
    }
    function fetch_accepted_task_quote($task_id,$user_id)
    {
        $sql = "select id,user_id,task_id,vendor_id,amount,description,status,date from task_quote where task_id='$task_id' and user_id='$user_id' and status='Accepted'  order by id desc limit 0,1";
        return $this->db->executeQuery($sql);
    }
    
    function update_task($user_id,$task_id,$vendor_id)
    {
        $date=date('Y-m-d H:i:s');
        $sqry="insert into task_status(user_id,task_id,vendor_id,status,date,log_date_created,created_by,otp_verified)
        values('$user_id','$task_id','$vendor_id','Started','$date','$date','$vendor_id','Yes')";
        return $this->db->getinsertidQuery($sqry);
    }
    
    function completed_task($user_id,$task_id,$vendor_id)
    {
        $date=date('Y-m-d H:i:s');
        $sqry="insert into task_status(user_id,task_id,vendor_id,status,date,log_date_created,created_by)
        values('$user_id','$task_id','$vendor_id','Completed','$date','$date','$vendor_id')";
        return $this->db->getinsertidQuery($sqry);
    }
    
    function fetch_task_payment($task_id)
    {
         $sql = "select id,user_id,task_id,vendor_id,amount,paid_date,payment_status,reason,transaction_no,type,log_date_created from task_payment where task_id='$task_id' order by id desc limit 0,1";
        return $this->db->executeQuery($sql);
    }
    function fetch_all_quotes($user_id,$task_id)
    {
        $sql = "select q.id,q.user_id,q.task_id,q.vendor_id,q.amount,q.description,q.date,q.status,u.id as uid,u.user_code as code,u.name as uname,u.last_name as lastname,
        u.postcode,u.address,u.city,u.category_id,u.about,u.expert_in_yrs from task_quote q
        inner join user u on q.vendor_id=u.id where q.task_id='$task_id' and q.user_id='$user_id' order by q.id desc";
        return $this->db->executeQuery($sql);
    }
    function fetch_review_count_sum($vendor_id)
    {
        $sql = "SELECT count(*) as cnt,sum(rating) as sum FROM `review` WHERE vendor_id='$vendor_id'";
        return $this->db->executeQuery($sql);
    }
    function fetch_user_wishlist_by_id($user_id)
    {
        $sql = 'select wl.id as wishlistid,ap.id as addid,ap.user_id as adduser,wl.user_id,ap.title,ap.description,ap.price,ap.ad_code,d.district_name as city,
        ap.neighbourhood,u.name as uname,u.mobile as umobile from add_post ap 
        inner join wish_list wl on wl.add_post_id=ap.id inner join user u on ap.user_id=u.id 
        left join district d on d.id=ap.city where wl.user_id="'.$user_id.'" group by ap.id';
        return $this->db->executeQuery($sql);
    }
    function add_expertise($user_id)
    {
        $sql = 'update user set department_id="3",category_id="'.$this->sub_cat.'",expert_in_yrs="'.$this->expyrs.'",about="'.$this->about.'",
        NI_number="'.$this->ni_number.'",motor_status="'.$this->motor_status.'",insurance_status="'.$this->work_insurance.'",
        motor_insurance_status="'.$this->motor_insurance_status.'",motor_licence_status="'.$this->motor_licence_status.'",no_vendor="Yes" 
        where id="'.$user_id.'"';
        $this->db->boolean_executeQuery($sql);
        
        if($this->jobcard!='')
        {
            $sql = 'INSERT INTO `user_upload`(`ref_id`, `type`, `file_type`, `file_name`, `attachment`, `status`, `log_date_created`) 
        VALUES ("'.$this->user_id.'","user","image","Jobcard","'.$this->jobcard.'","Active",
       "'.date('Y-m-d H:i:s').'")';
            $this->db->getinsertidQuery($sql);
        }
        if($this->certificate!='')
        {
            $sql = 'INSERT INTO `user_upload`(`ref_id`, `type`, `file_type`, `file_name`, `attachment`, `status`, `log_date_created`) 
        VALUES ("'.$this->user_id.'","user","image","Certificate","'.$this->certificate.'","Active",
       "'.date('Y-m-d H:i:s').'")';
            $this->db->getinsertidQuery($sql);
        }
        if($this->resproof!='')
        {
            $sql = 'INSERT INTO `user_upload`(`ref_id`, `type`, `file_type`, `file_name`, `attachment`, `status`, `log_date_created`) 
        VALUES ("'.$this->user_id.'","user","image","Residency Proof","'.$this->resproof.'","Active",
       "'.date('Y-m-d H:i:s').'")';
            $this->db->getinsertidQuery($sql);
        }
        return true;
    }
    function get_expertise($user_id)
    {
        $sql="select id,department_id,category_id,expert_in_yrs,about,NI_number,motor_status,insurance_status,motor_insurance_status,motor_licence_status 
        from user where id='$user_id'";
        return $this->db->executeQuery($sql);
    }
    function add_bankdetails($user_id)
    {
        $sql = 'insert into user_bank_details(user_id,person_name,ac_no,short_code,status,log_date_created)
        values("'.$user_id.'","'.$this->holder.'","'.$this->acno.'","'.$this->sort_code.'","Active","'.date('Y-m-d H:i:s').'")';
        return $this->db->boolean_executeQuery($sql);
    }
    function get_bank_details($user_id)
    {
        $sql="select id,person_name,short_code,ac_no from user_bank_details where user_id='$user_id' and status='Active' order by id desc limit 0,1";
        return $this->db->executeQuery($sql);
    }
    function get_login_details_byid($id) 
     {
        $sql = "select id,IFNULL(name,'') as name,IFNULL(last_name,'') as last_name,IFNULL(user_code,'') as user_code,IFNULL(email,'') as email,IFNULL(mobile,'') as mobile,department_id,gender,IFNULL(dob,'') as dob,IFNULL(postcode,'') as postcode,
        IFNULL(address,'') as address,IFNULL(city,'') as city,IFNULL(street,'') as street,IFNULL(profile_photo,'') as profile_photo,IFNULL(fb_id,'') as fb_id,IFNULL(google_id,'') as google_id,IFNULL(about,'') as about,status,mobile_verified,
        log_date_created,no_vendor from user where 1=1 and id='$id' limit 0,1";
        return $this->db->executeQuery($sql);
    }
    
    function update_profile($user_id,$flag)
    {
        if($flag=='personal')
        {
            $sql="update user set email='".$this->email."', postcode='".$this->post_code."',address='".$this->address."',city='".$this->city."',street='".$this->street."'";
            if($this->photo!='')
            {
            $sql.=",profile_photo='".$this->photo."'";
            }
            $sql.=",log_date_modified='".date('Y-m-d H:i:s')."',modified_by='$user_id' where id='$user_id'";
            return $this->db->boolean_executeQuery($sql);
        }
        if($flag=='expertise')
        {
           $sql = 'update user set category_id="'.$this->sub_cat.'",expert_in_yrs="'.$this->expyrs.'",about="'.$this->about.'",
            NI_number="'.$this->ni_number.'",motor_status="'.$this->motor_status.'",insurance_status="'.$this->work_insurance.'",
            motor_insurance_status="'.$this->motor_insurance_status.'",motor_licence_status="'.$this->motor_licence_status.'" 
            where id="'.$user_id.'"';
            $this->db->boolean_executeQuery($sql);
            
            if($this->jobcard!='')
            {
                $sql = 'INSERT INTO `user_upload`(`ref_id`, `type`, `file_type`, `file_name`, `attachment`, `status`, `log_date_created`) 
            VALUES ("'.$this->user_id.'","user","image","Jobcard","'.$this->jobcard.'","Active",
           "'.date('Y-m-d H:i:s').'")';
                $this->db->getinsertidQuery($sql);
            }
            if($this->certificate!='')
            {
                $sql = 'INSERT INTO `user_upload`(`ref_id`, `type`, `file_type`, `file_name`, `attachment`, `status`, `log_date_created`) 
            VALUES ("'.$this->user_id.'","user","image","Certificate","'.$this->certificate.'","Active",
           "'.date('Y-m-d H:i:s').'")';
                $this->db->getinsertidQuery($sql);
            }
            if($this->resproof!='')
            {
                $sql = 'INSERT INTO `user_upload`(`ref_id`, `type`, `file_type`, `file_name`, `attachment`, `status`, `log_date_created`) 
            VALUES ("'.$this->user_id.'","user","image","Residency Proof","'.$this->resproof.'","Active",
           "'.date('Y-m-d H:i:s').'")';
                $this->db->getinsertidQuery($sql);
            }
            return true;
        }
        if($flag=='bank')
        {
            $sql = "update user_bank_details set person_name='".$this->holder."',ac_no='".$this->acno."',short_code='".$this->sort_code."',
            log_date_modified='".date('Y-m-d H:i:s')."',modified_by='".$user_id."' where user_id='$user_id'";
            return $this->db->boolean_executeQuery($sql);
        }
    }
    function get_task_details($task_id)
    {
        $sql="select t.id,t.code,t.title,t.category_id,t.sub_category_id,c.name as cname,c.attachment cphoto,s.name as sname,s.attachment as sphoto
        from task t inner join category c on t.category_id=c.id inner join subcategory s on t.sub_category_id=s.id 
        where 1=1 and t.id='$task_id' order by id desc";
        return $this->db->executeQuery($sql);
    }
    function insert_review()
    {
        $sql = 'insert into review(user_id,vendor_id,task_id,rating,review,status,log_date_created)
        values("'.$this->user_id.'","'.$this->vendor_id.'","'.$this->task_id.'","'.$this->rating.'","'.$this->review.'","Active","'.date('Y-m-d H:i:s').'")';
        return $this->db->boolean_executeQuery($sql);
    }
    function get_vendor_reviews($vendor_id)
    {
        $sql="select r.id,r.vendor_id,r.task_id,r.rating,r.review,r.log_date_created,u.name,u.last_name,u.user_code,u.profile_photo from review r inner join user u on 
        r.user_id=u.id where 1=1 and r.vendor_id='$vendor_id' order by id desc";
        return $this->db->executeQuery($sql);
    }
    function get_vendor_reviews_given($user_id)
    {
        $sql="select r.id,r.vendor_id,r.task_id,r.rating,r.review,r.log_date_created,u.name,u.last_name,u.user_code,u.profile_photo from review r inner join user u on 
        r.vendor_id=u.id where 1=1 and r.user_id='$user_id' order by id desc";
        return $this->db->executeQuery($sql);
    }
    function get_see_reviews($vendor_id,$task_id)
    {
        $sql="select r.id,r.vendor_id,r.task_id,r.rating,r.review,r.log_date_created,u.name,u.last_name,u.user_code,u.profile_photo from review r inner join user u on 
        r.user_id=u.id where 1=1 and r.task_id='$task_id' and r.vendor_id='$vendor_id' order by id desc";
        return $this->db->executeQuery($sql);
    }
    function insert_dispute()
    {
        $sql = 'insert into refund_request(user_id,task_id,type,reason,date,status,log_date_created)
        values("'.$this->user_id.'","'.$this->task_id.'","'.$this->type.'","'.$this->reason.'","'.date('Y-m-d H:i:s').'","Active","'.date('Y-m-d H:i:s').'")';
        return $this->db->boolean_executeQuery($sql);
    }
    
    function update_user_role($user_id)
    {
        $sql = 'UPDATE user SET no_vendor="Yes" WHERE id="'.$user_id.'"';
        return $this->db->boolean_executeQuery($sql);
    }
    function isaddedtowishlist($user_id,$adid)
    {
         $sql = 'SELECT id FROM `wish_list` WHERE user_id="'.$user_id.'" AND add_post_id="'.$adid.'"';
         $data['list_data'] =   $this->db->executeQuery($sql);
         $respo = $data['list_data'];
            if(count($respo)>0)
            {
                return true;
            }
            else 
            {
                return false;
            }
    }
    function fetch_user_published_ads($user_id)
    {
        $sql = 'SELECT ap.id as addid,ap.user_id as adduser,ap.title,ap.description,ap.price,ap.ad_code,d.district_name as city,ap.neighbourhood FROM add_post ap 
        left join district d on d.id=ap.city WHERE ap.user_id="'.$user_id.'" AND ap.status="Yes"';
        return $this->db->executeQuery($sql);
    }

    function check_mobile_exist_edit($mobile,$userid)
    {
        $sql = 'select * from user where mobile="'.$mobile.'" and id!="'.$userid.'" and status="Active"';
        return $this->db->executeQuery($sql);
    }

    function update_userdata($name,$email,$mobile,$about,$user_id,$city,$location,$address)
    {
        $sql = 'update user set name="'.$name.'",email="'.$email.'",mobile="'.$mobile.'",about="'.$about.'",city="'.$city.'",
        location="'.$location.'",address="'.$address.'" where id="'.$user_id.'"';
        return $this->db->boolean_executeQuery($sql);
    }

    function fetch_ad_details($ad_id)
    {
     $sql = 'select c.name from category c left join add_post ap on ap.sub_cat_id=c.id where ap.id="'.$ad_id.'"';
     $ad_cat = $this->db->executeQuery($sql);

    if(!empty($ad_cat))
    {
       if(strtolower($ad_cat[0]['name'])=='commercial vehicles')
       {
           $ad_data = 'select ap.*,ap.id as ad_id,c.* from category c left join add_post ap on ap.sub_cat_id=c.id where ap.id="'.$ad_id.'"';
           return $this->db->executeQuery($ad_data);
       }
       elseif(strtolower($ad_cat[0]['name'])=='cars for sale')
       {
           $ad_data = 'select ap.*,ap.id as ad_id,c.*,b.name as brandname,v.variant_name,m.model_name from category c left join add_post ap on ap.sub_cat_id=c.id left join model m on m.id=ap.model left join brand b on b.id=ap.brand_id left join variants v on v.id=ap.variant where ap.id="'.$ad_id.'"';
           return $this->db->executeQuery($ad_data);
       }
       elseif(strtolower($ad_cat[0]['name'])=='mobile phones')
       {
           $ad_data = 'select ap.*,ap.id as ad_id,c.*,b.name as brandname from category c left join add_post ap on ap.sub_cat_id=c.id left join brand b on b.id=ap.brand_id where ap.id="'.$ad_id.'"';
           return $this->db->executeQuery($ad_data);
       }
       elseif(strtolower($ad_cat[0]['name'])=='house for rent' || strtolower($ad_cat[0]['name'])=='shops & offices for sale' || strtolower($ad_cat[0]['name'])=='land for sale' || strtolower($ad_cat[0]['name'])=='shops & offices for rent' || strtolower($ad_cat[0]['name'])=='house for sale')
       {
           $ad_data = 'select ap.*,ap.id as ad_id,c.*,f.name as facing,at.name as aprt_name ,pd.* from category c left join add_post ap on ap.sub_cat_id=c.id left join property_details pd on pd.add_post_id=ap.id left join facing_type f on f.id=pd.facing_type_id left join apartment_type at on at.id=pd.apartment_type_id where ap.id="'.$ad_id.'"';
           return $this->db->executeQuery($ad_data);
       }
       else
       {
           $ad_data = 'select ap.*,ap.id as ad_id,c.* from category c left join add_post ap on ap.sub_cat_id=c.id where ap.id="'.$ad_id.'"';
           return $this->db->executeQuery($ad_data);
       }
    }
    else
    {
        return array();
    }
}

function fetch_related_ads($ad_id)
{
  $get_sql = 'SELECT category_id FROM `add_post` WHERE id="'.$ad_id.'" AND status="Yes" AND verified="Yes"';
  $data = $this->db->executeQuery($get_sql);

  if(!empty($data))
  {
    $sql = 'SELECT ap.id as ad_id,ap.title,ap.price,ap.neighbourhood,ap.city,ap.ad_code,u.id,u.name,u.email,u.mobile,s.name as state_name,api.attachment FROM add_post ap LEFT JOIN user u ON  u.id=ap.user_id LEFT JOIN state s ON s.id=ap.state LEFT JOIN add_post_images api ON api.add_post_id=ap.id WHERE ap.category_id="'.$data[0]['category_id'].'" AND ap.status="Yes" AND ap.verified="Yes" AND ap.id!="'.$ad_id.'"
    GROUP BY ap.id';
    return $this->db->executeQuery($sql);;
  }
  else
  {
    return array();
  }
}

function fetch_seller_details($user_id)
{
    $sql   = 'SELECT name,last_name,email_verified,mobile_verified,attachment,about FROM user WHERE id="'.$user_id.'"';
    $data['user_data'] =  $this->db->executeQuery($sql);

    $sql1  = 'SELECT id,price,title FROM `add_post` WHERE user_id="'.$user_id.'" AND status="Yes"';
    $data['user_ad_data'] =  $this->db->executeQuery($sql1);

    return $data;
}

function fetch_trending_ads()
{
   $sql = 'SELECT ap.id as ad_id,ap.title,ap.price,ap.neighbourhood,ap.city,ap.ad_code,u.id,u.name,u.email,u.mobile,count(av.id) as views,s.name as state_name,api.attachment FROM add_post ap LEFT JOIN `ads_view` av  ON av.ad_id=ap.id LEFT JOIN user u ON  u.id=ap.user_id LEFT JOIN state s ON s.id=ap.state LEFT JOIN add_post_images api ON api.add_post_id=ap.id WHERE ap.verified="Yes" AND ap.status="Yes" GROUP BY av.ad_id ORDER BY views DESC';
   $data  =  $this->db->executeQuery($sql);
   return $data;
}

  function fetch_sub_cat_product_ads($cat_id,$sub_cat_id)
  {
     $sql = 'SELECT ap.id as ad_id,ap.title,ap.price,ap.neighbourhood,ap.city,ap.ad_code,u.id,u.name,u.email,u.mobile,s.name as state_name FROM add_post ap LEFT JOIN user u ON  u.id=ap.user_id LEFT JOIN state s ON s.id=ap.state WHERE ap.category_id="'.$cat_id.'" AND ap.sub_cat_id="'.$sub_cat_id.'" AND ap.verified="Yes" AND ap.status="Yes"';
     $data  =  $this->db->executeQuery($sql);
     return $data;
  }

  function fetch_search_products($keyword)
  {
     $sql = "SELECT ap.id as ad_id,ap.title,ap.price,ap.neighbourhood,ap.city,ap.ad_code,u.id,u.name,u.email,u.mobile,s.name as state_name 
     FROM add_post ap LEFT JOIN user u ON  u.id=ap.user_id LEFT JOIN state s ON s.id=ap.state left join category c on ap.category_id=c.id 
     WHERE ap.verified='Yes' AND ap.status='Yes' and (ap.title like '%$keyword%' or c.name like '%$keyword%')";
     $data  =  $this->db->executeQuery($sql);
     return $data;
  }


  function fetch_ad_image($ad_id)
  {
     $sql = 'SELECT attachment,small_image FROM add_post_images WHERE add_post_id="'.$ad_id.'" LIMIT 1';
     $data  =  $this->db->executeQuery($sql);
     return $data;
  }

  function add_to_wish($user_id,$ad_id)
  {
    $sql = 'INSERT INTO `wish_list`(`user_id`, `add_post_id`, `status`, `log_date_created`, `created_by`) VALUES ("'.$user_id.'","'.$ad_id.'","Active","'.date('Y-m-d H:i:s').'","'.$user_id.'")';
    return $this->db->getinsertidQuery($sql);
  }

   function remove_from_wish()
   {
     $sql = 'DELETE FROM `wish_list` WHERE user_id="'.$this->user_id.'" AND add_post_id="'.$this->ad_id.'"';
     return $this->db->boolean_executeQuery($sql);
   }

  function fetch_ad_view_details($ad_id)
  {
     $sql = 'select c.name as cat_name,u.id as user_id,u.name as user_name,u.email as user_email,u.mobile as user_mobile,ap.id as ad_id,ap.title as title,ap.description,ap.ad_code,ap.price,s.district_name as city_name,ap.neighbourhood from category c left join add_post ap on ap.sub_cat_id=c.id left join user u on u.id=ap.user_id left join district s on s.id=ap.city where ap.id="'.$ad_id.'"';
     return $this->db->executeQuery($sql);
  }

 function fetch_ad_data_by_name($cat_name,$ad_id)
 {
   if(strtolower($cat_name)=='commercial vehicles')
   {
     $ad_data = 'select c.*,b.name as brandname,v.variant_name,m.model_name,ap.year,ap.transmission,ap.steering_wheel,ap.fuel,ap.km_driven from category c left join add_post ap on ap.sub_cat_id=c.id left join model m on m.id=ap.model left join brand b on b.id=ap.brand_id left join variants v on v.id=ap.variant where ap.id="'.$ad_id.'"';

     return $this->db->executeQuery($ad_data);
   }
   elseif(strtolower($cat_name)=='cars for sale')
   {
     $ad_data = 'select c.*,b.name as brandname,v.variant_name,m.model_name,ap.year,ap.transmission,ap.steering_wheel,ap.fuel,ap.km_driven from category c left join add_post ap on ap.sub_cat_id=c.id left join model m on m.id=ap.model left join brand b on b.id=ap.brand_id left join variants v on v.id=ap.variant where ap.id="'.$ad_id.'"';

     return $this->db->executeQuery($ad_data);
   }
   elseif(strtolower($cat_name)=='mobile phones')
   {
     $ad_data = 'select c.*,b.name as brandname from category c left join add_post ap on ap.sub_cat_id=c.id left join brand b on b.id=ap.brand_id where ap.id="'.$ad_id.'"';
     return $this->db->executeQuery($ad_data);
   }
   elseif(strtolower($cat_name)=='house for rent' || strtolower($cat_name)=='shops & offices for sale' || strtolower($cat_name)=='land for sale' || strtolower($cat_name)=='shops & offices for rent' || strtolower($cat_name)=='house for sale')
   {
     $ad_data = 'select c.*,f.name as facing,at.name as aprt_name ,pd.* from category c left join add_post ap on ap.sub_cat_id=c.id left join property_details pd on pd.add_post_id=ap.id left join facing_type f on f.id=pd.facing_type_id left join apartment_type at on at.id=pd.apartment_type_id where ap.id="'.$ad_id.'"';
     return $this->db->executeQuery($ad_data);
   }
   else
   {
     $sql = 'select c.name as cat_name,u.id as user_id,u.name as user_name,u.email as user_email,u.mobile as user_mobile,ap.id as ad_id,ap.title as title,ap.description,ap.ad_code,ap.price,s.district_name as city_name,ap.neighbourhood from category c left join add_post ap on ap.sub_cat_id=c.id left join user u on u.id=ap.user_id left join district s on s.id=ap.city where ap.id="'.$ad_id.'"';
     return $this->db->executeQuery($sql);
   }
 }

 function fetch_ad_view_images($ad_id)
 {
    $sql = 'SELECT attachment FROM add_post_images WHERE add_post_id="'.$ad_id.'" AND status="Active"';
    return $this->db->executeQuery($sql);
 }
 
 function fetch_table_data($table,$fields,$id=null,$refid=null,$id_column=null,$reffield=null)
 {
    $sql = "SELECT ".$fields." FROM $table WHERE 1=1 and status='Active'";
    if($id!='' && $id_column!='')
    {
        $sql.=" and $id_column='$id'";
    }
    if($refid!='' && $reffield!='')
    {
        $sql.=" and $reffield='$refid'";
    }
    //echo $sql;
    return $this->db->executeQuery($sql);
 }
     function add_task()
     {
         $userid=$this->user_id;
         $dttime=date('Y-m-d H:i:s');
         $sql = 'insert into `task`(`user_id`,`code`,`title`,`category_id`,`sub_category_id`,`description`,`budget`,`is_negotiate`,`postal_code`,`city`,`address`,`land_mark`,
         `date`,`time`,`verified`,`log_date_created`,`created_by`) values("'.$this->user_id.'","'.$this->ad_code.'","'.$this->title.'","'.$this->category.'","'.$this->sub_cat.'",
         "'.$this->desc.'","'.$this->amount.'","'.$this->is_negotiate.'","'.$this->post_code.'","'.$this->city.'","'.$this->address.'","'.$this->landmark.'","'.$this->date.'","'.$this->time.'","No","'.$dttime.'","'.$this->user_id.'")';
         $refid=$this->db->getinsertidQuery($sql);
         
         if($this->attachment!='')
            {
                $sql = 'INSERT INTO `user_upload`(`ref_id`, `type`, `file_type`, `file_name`, `attachment`, `status`, `log_date_created`) 
            VALUES ("'.$refid.'","job","image","Job","'.$this->attachment.'","Active",
           "'.date('Y-m-d H:i:s').'")';
                $this->db->getinsertidQuery($sql);
            }
            
            
            
        return $refid;
     }
      function insert_quote()
      {
        $sql = 'INSERT INTO `task_quote`(`user_id`, `task_id`, `vendor_id`, `amount`, `description`, `date`, `status`, `log_date_created`) 
        VALUES ("'.$this->to_user_id.'","'.$this->task_id.'","'.$this->user_id.'","'.$this->amount.'","'.$this->description.'","'.date('Y-m-d H:i:s').'","Active",
       "'.date('Y-m-d H:i:s').'")';
        return $this->db->getinsertidQuery($sql);
     }
     
     function update_quote()
      {
        $sql = 'UPDATE `task_quote` SET `status`="'.$this->status.'",`log_date_modified`="'.date('Y-m-d H:i:s').'",`modified_by`="'.$this->user_id.'"
         WHERE id="'.$this->quote_id.'"';
        $this->db->boolean_executeQuery($sql);
        if($this->vendor_id!='' && $this->task_id!='')
        {
            $qry=" 1=1 and vendor_id='".$this->vendor_id."' and task_id='".$this->task_id."' and user_id='".$this->user_id."'";
            $id=$this->fetch_one_column('task_status','id',$qry);
            if($id!='')
            {
                $sql = "UPDATE `task_status` SET `status`='".$this->status."',`date`='".date('Y-m-d H:i:s')."',`log_date_modified`='".date('Y-m-d H:i:s')."',
                `modified_by`='".$this->user_id."'  WHERE id='".$id."' and vendor_id='".$this->vendor_id."' and task_id='".$this->task_id."' and user_id='".$this->user_id."'";
                $this->db->boolean_executeQuery($sql);
            }
            else
            {
                $sql = 'INSERT INTO `task_status`(`user_id`, `task_id`, `vendor_id`, `date`, `status`, `log_date_created`) 
                VALUES ("'.$this->user_id.'","'.$this->task_id.'","'.$this->vendor_id.'","'.date('Y-m-d H:i:s').'","'.$this->status.'",
               "'.date('Y-m-d H:i:s').'")';
                return $this->db->getinsertidQuery($sql);
            }
        }
        return true;
     }
     
     function add_image()
     {
        include_once ('../../lib/resize-class.php');
        $allowed_extensions = array("image/png", "image/jpg", "image/jpeg");
 		for($i = 0; $i < sizeof($_FILES['images']['name']); $i++) 
 		{
 			if (!in_array($_FILES["images"]["type"][$i], $allowed_extensions)) 
 			{
 				echo 'error';
 			} 
 			else 
 			{
 				$fname = $_FILES['images']['name'][$i];
 				$larageUploadDir = "../../assets/ad_post_images/large_images/";
 				$mediumUploadDir = "../../assets/ad_post_images/big_images/";
 				$smallUploadDir = "../../assets/ad_post_images/small_images/";
 				$rand = rand(10, 9999);
 				$filename1 = explode('.',$fname);
 				$large_filename = 'large_' . $rand . time() . '.' . $filename1[1];
 				$big_filename = 'big_' . $rand . time() . '.' . $filename1[1];
 				$small_filename = 'small_' . $rand . time() . '.' . $filename1[1];
 				$image_type = $_FILES["images"]["type"][$i];
 				$bigadd = $larageUploadDir . "$large_filename";
 				$mediumadd = $mediumUploadDir . "$large_filename";
 				$smalladd = $smallUploadDir . "$small_filename";
 				copy($_FILES['images']['tmp_name'][$i], $bigadd);
 				copy($_FILES['images']['tmp_name'][$i], $mediumadd);
 				copy($_FILES['images']['tmp_name'][$i], $smalladd);
 				$mediumPath = "../assets/ad_post_images/big_images/" . $big_filename;
 				$smallPath = "../assets/ad_post_images/small_images/" . $small_filename;
 				$resizeObj = new resize($mediumPath);
 				$sizes = getimagesize($mediumPath);
 				copy($_FILES['images']['tmp_name'][$i], $big_filename);
 				if ($image_type == 'image/jpg' || $image_type == 'image/jpeg') 
 				{
 					$original = imagecreatefromjpeg($big_filename);
 				} 
 				else 
 				{
 					$original = imagecreatefrompng($big_filename);
 				}
 				$width = imagesx($original);
 				$height = imagesy($original);
 				if (($width < 804 && $height < 480) && ($width > $height || $width < $height)) 
 				{
 					$square = min($width, $height);
 					$medium = imagecreatetruecolor(804, 480);
 					imagecopyresampled($medium, $original, (804 - $width) / 2, (480 - $height) / 2, 0, 0, $width, $height, $width, $height);
 					if ($image_type == 'image/jpg' || $image_type == 'image/jpeg') 
 					{
 						imagejpeg($medium, $mediumPath);
 					} 
 					else 
 					{
 						imagepng($medium, $mediumPath);
 					}
 				} 
 				else if (($height > $width) || ($width > $height)) 
 				{
 					$square = min($width, $height);
 					$origWidth = $width;
 					$origHeight = $height;

 					$maxWidth = 804;
 					$maxHeight = 480;
                    // Calculate ratio of desired maximum sizes and original sizes.
 					$widthRatio = $maxWidth / $origWidth;
 					$heightRatio = $maxHeight / $origHeight;

                    // Ratio used for calculating new image dimensions.
 					$ratio = min($widthRatio, $heightRatio);

                    // Calculate new image dimensions.
 					$newWidth = round($origWidth * $ratio);
 					if ($origWidth < 804) 
 					{
                    //$newWidth = $origWidth;
 					}
 					$newHeight = $origHeight * $ratio;
 					$square = min($width, $height);
 					$medium = imagecreatetruecolor(804, 480);

 					$heigth_val = (480 - $newHeight) / 2;
 					$width_val = (804 - $newWidth) / 2;

 					imagecopyresampled($medium, $original, $width_val, $heigth_val, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
 					if ($image_type == 'image/jpg' || $image_type == 'image/jpeg') 
 					{
 						imagejpeg($medium, $mediumPath);
 					} 
 					else 
 					{
 						imagepng($medium, $mediumPath);
 					}
 				} 
 				else 
 				{
 					$medium_width = 804;
 					$medium_height = 480;
 					$resizeObj->resizeImage($medium_width, $medium_height, 'exact');
                    //Save image
 					$resizeObj->saveImage($mediumPath, 100);
 				}
 				unlink($big_filename);

               //resize to small 
 				$resizeObj = new resize($smallPath);
 				$sizes = getimagesize($smallPath);
 				$small_width = 255;
 				$small_height = 179;
 				$resizeObj->resizeImage($small_width, $small_height, 'exact');
                //  Save image
 				$resizeObj->saveImage($smallPath, 100);

                //$insertimgs = $sell_model->insert_product_images($insertid,$user_id,$big_filename,$small_filename);
                $sql = 'INSERT INTO `add_post_images`(`add_post_id`, `user_id`, `attachment`, `big_image`, `small_image`, `large_image`, `status`, `log_date_created`, `created_by`) 
                VALUES ("'.$this->add_post_id.'","'.$this->userid.'","'.$big_filename.'","'.$big_filename.'","'.$small_filename.'","'.$big_filename.'","Active","'.date('Y-m-d H:i:s').'","'.$this->userid.'")';
                $this->db->getinsertidQuery($sql);
                
 			}
 		}
 		return true;
     }
     
     function insert_empty_ad($user_id)
     {
         $sql = 'INSERT INTO `add_post`(`user_id`) VALUES ("'.$user_id.'")';
         return $this->db->getinsertidQuery($sql);
     }
     
     function insert_ad_image($user_id,$ads_id,$file,$file_small,$file_large,$file_big)
     {
         $sql = 'INSERT INTO `add_post_images`
         (`add_post_id`, `user_id`, `attachment`, `big_image`, `small_image`, `large_image`, `status`, `log_date_created`, `created_by`)
         VALUES ("'.$ads_id.'","'.$user_id.'","'.$file_big.'","'.$file_big.'","'.$file_small.'","'.$file_big.'","Active","'.date('Y-m-d H:i:s').'","'.$user_id.'")';
         return $this->db->getinsertidQuery($sql);
     }
     function fetch_user_ads($user_id)
    {
        $sql = 'select ap.id as addid,ap.title,ap.description,ap.price,ap.ad_code,d.district_name as city,ap.neighbourhood from add_post ap 
        left join district d on d.id=ap.city where ap.user_id="'.$user_id.'" order by ap.log_date_created desc';
        return $this->db->executeQuery($sql);
    }
    
    function update_profile_pic($file_name,$userid)
    {
        $sql = 'update user set attachment="'.$file_name.'" where id="'.$userid.'"';
        return $this->db->boolean_executeQuery($sql);
    }
    
    function delete_user_pic($user_id)
    {
        $sql = 'update user set attachment="" where id="'.$user_id.'"';
        return $this->db->boolean_executeQuery($sql);
    }
    
    function check_old_passowrd($user_id,$old_password)
    {
        $sql = 'select id from user where password="'.$old_password.'" AND id="'.$user_id.'" and status="Active"';
        return $this->db->executeQuery($sql);
    }
    
    function update_passowrd($user_id,$new_password)
    {
        $sql = 'update user set password="'.$new_password.'" where id="'.$user_id.'" and status="Active"';
        return $this->db->boolean_executeQuery($sql);
    }
    
    function check_user_exist($user_id)
    {
        $sql = 'select id from user where id="'.$user_id.'" and status="Active"';
        return $this->db->executeQuery($sql);
    }
    
    function update_social_id($flag,$id,$user_id,$email)
    {
        $sql = 'update user set '.$flag.'="'.$id.'",email="'.$email.'" where id="'.$user_id.'" and status="Active"';
        return $this->db->boolean_executeQuery($sql);
    }
    function fetch_chat_users($user_id)
    {
          $sql="SELECT m.*, u1.id as sid,u1.name AS sender,u1.last_name as slname,u2.name AS recipient,u2.last_name as rlname,u2.id as rid FROM chat_message m JOIN user u1 ON m.from_user_id=u1.id JOIN user u2 ON m.to_user_id=u2.id WHERE m.chat_message_id IN ( SELECT chat_message_id FROM chat_message WHERE 1=1 and (to_user_id = $user_id OR from_user_id =$user_id)) group by sender ORDER BY m.chat_message_id DESC";
          $result =  $this->db->executeQuery($sql);
          $respo1["chat_users"] = array();
          for($c=0;$c<count($result);$c++)
          {
                $respo = array();
                //return $result1;
                $sid=$result[$c]['sid'];
                if($user_id==$sid)
                {
                    $uid=$result[$c]['rid'];
                $respo['u_id']=$result[$c]['rid'];
                $respo['name']=ucfirst($result[$c]['recipient'].' '.$result[$c]['rlname']);
                }
                else
                {
                    $uid=$result[$c]['sid'];
                 $respo['u_id']=$result[$c]['sid']; 
                 $respo['name']=ucfirst($result[$c]['sender'].' '.$result[$c]['slname']);
                }
               
                if($result[$c]['attachment']!='')
                {
                    $respo['image']=baseurl.'assets/user_profile/'.$result[$c]['attachment'];
                }
                else
                {
                    $respo['image']='';
                }
                $respo['last_msg']=$result[$c]['chat_message'];
                $respo['time']=$this->timeAgo($result[$c]['timestamp']);
                //echo $arrayKey = searchArrayKeyVal("u_id",$uid,$respo1);
                array_push($respo1["chat_users"], $respo);
          }
            $respo1["chat_users"]=super_unique($respo1["chat_users"],'u_id');
            $respo1["status"] = true; 
    	    $respo1["msg"]    = 'Chat Users Result';
    	    $respo1['errorCode'] = 700; 
    	    return $respo1;
      }
        function fetch_chat_data($to_user_id,$from_user_id,$pg)
        {
          $query = "SELECT * FROM chat_message WHERE (from_user_id = '".$from_user_id."' AND to_user_id = '".$to_user_id."') OR (from_user_id = '".$to_user_id."' AND to_user_id = '".$from_user_id."') ORDER BY timestamp ASC";
          if($pg==0)
          {
              $query.=" limit 0,10";
          }
          else
          {
              $cnt=$pg*10;
              $query.=" limit $cnt,10";
          }
          $data =  $this->db->executeQuery($query);
          $respo1["chat_info"] = array();
          $totpages=0;
          $totcnt=count($data);
          if(count($data)>0)
          {
              $totpages=$totcnt/10;
              for($i=0;$i<count($data);$i++)
              {
                $respo = array();
                if($data[$i]["from_user_id"] == $from_user_id)
                {
                  $respo['message']=$data[$i]['chat_message'];
                  if($data[$i]['attachment']!='')
                  {
                   $respo['image']=baseurl.'assets/user_chat/'.$data[$i]['attachment'];
                  }
                  else
                  {
                   $respo['image']='';  
                  }
                  $respo['time']=$this->timeAgo($data[$i]['timestamp']);
                  $respo['display_side']="right";
                  array_push($respo1["chat_info"], $respo);
                }
                else
                {
                  $respo['message']=$data[$i]['chat_message'];
                  if($data[$i]['attachment']!='')
                  {
                   $respo['image']=baseurl.'assets/user_chat/'.$data[$i]['attachment'];
                  }
                  else
                  {
                   $respo['image']='';  
                  }
                  $respo['time']=$this->timeAgo($data[$i]['timestamp']);
                  $respo['display_side']="left";
                  array_push($respo1["chat_info"], $respo);
                }
              }
            
            $status = '';
           
            $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
            $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
        
            $query = "SELECT * FROM login_details WHERE user_id = ".$to_user_id." ORDER BY last_activity DESC LIMIT 1";
            $user_last_activity1 = $this->db->executeQuery($query);
            $user_last_activity = $user_last_activity1[0]['last_activity'];
        
            if($user_last_activity > $current_timestamp)
            {
              $status = '<p>online</p>';
            }
            else
            {
              $status = '<p>Last seen '.$this->timeAgo($user_last_activity).'</p>';
            }
              $sql = "SELECT * FROM user WHERE id= '".$to_user_id."'";
              $result =  $this->db->executeQuery($sql);
              for($c=0;$c<count($result);$c++)
              {
                    $u_id=$result[$c]['id'];
                    $name=ucfirst($result[$c]['name'].' '.$result[$c]['last_name']);
                    if($result[$c]['attachment']!='')
                    {
                        $image=baseurl.'assets/user_profile/'.$result[$c]['attachment'];
                    }
                    else
                    {
                        $image='';
                    }
              }
            $respo1["u_id"] = $u_id;
            $respo1["name"] = $name;
            $respo1["image"] = $image;
            $respo1["last_seen"]=$status;
            $respo1["status"] = true; 
            $respo1["page"] = $pg; 
            $respo1["totpages"]=$totpages;
    	    $respo1["msg"]    = 'Chat Users Result';
    	    $respo1['errorCode'] = 700; 
    	    return $respo1;
          }
          else
          {
          $respo1["status"] = false; 
	      $respo1["msg"]    = 'No Messages';
	      $respo1['errorCode'] = 703;
          return $respo1;
          }
        }
        function chat_insert($from_user_id,$to_user_id,$msg,$filename)
        {
          
          $sql = 'INSERT INTO `chat_message`(`from_user_id`, `to_user_id`, `chat_message`, `timestamp`,`attachment`) 
          VALUES ("'.$from_user_id.'","'.$to_user_id.'","'.$msg.'","'.date('Y-m-d H:i:s').'","'.$filename.'")';
          $this->db->executeQuery($sql);
          $query = "SELECT * FROM chat_message WHERE (from_user_id = '".$from_user_id."' AND to_user_id = '".$to_user_id."') OR (from_user_id = '".$to_user_id."' AND to_user_id = '".$from_user_id."') ORDER BY timestamp ASC limit 0,20";
          $data =  $this->db->executeQuery($query);
          $respo1["chat_info"] = array();
          if(count($data)>0)
          {
              for($i=0;$i<count($data);$i++)
              {
                $respo = array();
                if($data[$i]["from_user_id"] == $from_user_id)
                {
                  $respo['message']=$data[$i]['chat_message'];
                  if($data[$i]['attachment']!='')
                  {
                   $respo['image']=baseurl.'assets/user_chat/'.$data[$i]['attachment'];
                  }
                  else
                  {
                   $respo['image']='';  
                  }
                  $respo['time']=$this->timeAgo($data[$i]['timestamp']);
                  $respo['display_side']="right";
                  array_push($respo1["chat_info"], $respo);
                }
                else
                {
                  $respo['message']=$data[$i]['chat_message'];
                  if($data[$i]['attachment']!='')
                  {
                   $respo['image']=baseurl.'assets/user_chat/'.$data[$i]['attachment'];
                  }
                  else
                  {
                   $respo['image']='';  
                  }
                  $respo['time']=$this->timeAgo($data[$i]['timestamp']);
                  $respo['display_side']="left";
                  array_push($respo1["chat_info"], $respo);
                }
              }
        
            $status = '';
            $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
            $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
        
            $query = "SELECT * FROM login_details WHERE user_id = ".$to_user_id." ORDER BY last_activity DESC LIMIT 1";
            $user_last_activity1 = $this->db->executeQuery($query);
            $user_last_activity = $user_last_activity1[0]['last_activity'];
        
            if($user_last_activity > $current_timestamp)
            {
              $status = '<p>online</p>';
            }
            else
            {
              $status = '<p>Last seen '.$this->timeAgo($user_last_activity).'</p>';
            }
              $sql = "SELECT * FROM user WHERE id= '".$to_user_id."'";
              $result =  $this->db->executeQuery($sql);
              for($c=0;$c<count($result);$c++)
              {
                    $u_id=$result[$c]['id'];
                    $name=ucfirst($result[$c]['name'].' '.$result[$c]['last_name']);
                    if($result[$c]['attachment']!='')
                    {
                        $image=baseurl.'assets/user_profile/'.$result[$c]['attachment'];
                    }
                    else
                    {
                        $image='';
                    }
              }
            $respo1["u_id"] = $u_id;
            $respo1["name"] = $name;
            $respo1["image"] = $image;
            $respo1["last_seen"]=$status;
            $respo1["page"] = 0;
            $respo1["status"] = true; 
    	    $respo1["msg"]    = 'Message Sent';
    	    $respo1['errorCode'] = 700; 
    	    return $respo1;
          }
          return $output;
        }
      function  timeAgo($timestamp)
      {
            $datetime1=new DateTime("now");
            $datetime2=date_create($timestamp);
            $diff=date_diff($datetime1, $datetime2);
            $timemsg='';
            if($diff->y > 0){
                $timemsg = $diff->y .' year'. ($diff->y > 1?"'s":'');
        
            }
            else if($diff->m > 0){
             $timemsg = $diff->m . ' month'. ($diff->m > 1?"'s":'');
            }
            else if($diff->d > 0){
             $timemsg = $diff->d .' day'. ($diff->d > 1?"'s":'');
            }
            else if($diff->h > 0){
             $timemsg = $diff->h .' hour'.($diff->h > 1 ? "'s":'');
            }
            else if($diff->i > 0){
             $timemsg = $diff->i .' min'. ($diff->i > 1?"'s":'');
            }
            else if($diff->s > 0){
             $timemsg = $diff->s .' sec'. ($diff->s > 1?"'s":'');
            }
        
        $timemsg = $timemsg.' ago';
        return $timemsg;
        }
        
/* Function Start Date: 30-12-2020, Written By: Madhavi B, Purpose: For task and image both will add using this function.*/
	function add_task_web()
     {
         $dttime=date('Y-m-d H:i:s');
         $sql = 'insert into `task`(`user_id`,`code`,`title`,`category_id`,`sub_category_id`,`description`,`budget`,`is_negotiate`,`postal_code`,`city`,`address`,`land_mark`,
         `date`,`time`,`verified`,`log_date_created`,`created_by`) values("'.$this->user_id.'","'.$this->ad_code.'","'.$this->title.'","'.$this->category.'","'.$this->sub_cat.'",
         "'.$this->desc.'","'.$this->amount.'","'.$this->is_negotiate.'","'.$this->post_code.'","'.$this->city.'","'.$this->address.'","'.$this->landmark.'","'.$this->date.'","'.$this->time.'","No","'.$dttime.'","'.$this->user_id.'")';
		 
		 
        
		$taskid=$this->db->getinsertidQuery($sql);
		if($taskid!="")
		{
			 $imgsql = 'insert into `user_upload`(`type`,`file_type`,`ref_id`,
			 `file_name`,`attachment`,`status`,`log_date_created`,`created_by`) values("job","image","'.$taskid.'","Job","'.$this->attachment.'","Active","'.$dttime.'","'.$this->user_id.'")';
			 return $this->db->boolean_executeQuery($imgsql);
			 
		}
     }
     
    function checkMobileExist($mobile)
    {
    	$sql ='SELECT COUNT(*) as count_user FROM user u LEFT JOIN department d ON d.id=u.department_id 
               WHERE 1=1 AND u.mobile="'.$mobile.'" and (d.id="3" or d.id="4")';
    	return $this->db->executeQuery($sql);
    }
    
    function vendorRegister()
    {
        $date=date('Y-m-d H:i:s');
    	$sql = 'insert into user (department_id,name,last_name,user_code,email,mobile,gender,dob,mobile_verified,fb_id,google_id,postcode,address,city,street,profile_photo,status,log_date_created,password,latitude,longitude)values
    	("3","' .$this->firstname. '","' .$this->lastname. '","' . $this->user_code . '","' . $this->email. '","' . $this->mobile . '","' . $this->gender . '","' . $this->dob .'",
    	"No","","","'.$this->post_code.'","'.$this->address.'","'.$this->city.'","'.$this->landmark.'","","Active","'.$date.'","' . $this->password . '","'.$this->lat.'","'.$this->lang.'")';
    	return $this->db->getinsertidQuery($sql);
		
    }
	function getApiKey($userid) {
        $SITE_KEY='1234';
        $key = md5($SITE_KEY . $userid);
        return hash('sha256', $key);
    }
	function updateVendor($user_id)
	{
		$date=date('Y-m-d H:i:s');
		$updatsql='update user set department_id="3",user_code="'.$this->user_code.'",log_date_modified="'.$date.'",modified_by="'.$user_id.'" where id="'.$user_id.'"';
		return $this->db->boolean_executeQuery($updatsql);
	}
	
	function getCatBySubCatId($id=NULL) 
    {
      $sql = "select id,category_id,IFNULL(name,'') as name,IFNULL(attachment,'') as attachment,IFNULL(description,'') as description from subcategory where id='$id' order by priority asc";
      return $this->db->executeQuery($sql);
    }
    
    function getCatnameById($id=NULL) 
    {
      $sql = "select id,IFNULL(name,'') as name,IFNULL(attachment,'') as attachment,IFNULL(description,'') as description from category where  id='$id' order by priority asc";
      return $this->db->executeQuery($sql);
    }
    
    function getjobcardById($user_id=NULL)
    {
         $sql = "select * from user_upload where file_name='Jobcard' and type='user' and ref_id='$user_id' order by id desc";
        return $this->db->executeQuery($sql);
    }
     function getCerficateById($user_id=NULL)
    {
        $sql = "select * from  user_upload where file_name='Certificate' and type='user' and ref_id='$user_id' order by id desc";
        return $this->db->executeQuery($sql);
    }
    function getResidenseProfById($user_id=NULL)
    {
        $sql = "select * from  user_upload where file_name='Residency Proof' and type='user' and ref_id='$user_id' order by id desc";
        return $this->db->executeQuery($sql);
    }
   
    function get_vendor_count($sid)
    {
    $sql="select count(*) as cnt from user where category_id='$sid' and department_id='3'";
    $result =  $this->db->executeQuery($sql);
    return $result[0]['cnt'];
    }
    
    
    //Developer Madhavi B, Date: 11-01-2021, Start
	function check_mobile_exist($mobile)
    {
    	$sql ='SELECT COUNT(*) as count_user, u.id as userid, u.mobile as umobile FROM user u LEFT JOIN department d ON d.id=u.department_id 
               WHERE 1=1 AND u.mobile="'.$mobile.'" and (d.id="3" or d.id="4")';
    	return $this->db->executeQuery($sql);
    }
    function getBlog($blog_id=null) 
	{
		 $sql ='SELECT  b.id as blogid, b.title,b.description,b.attachment,b.tags,b.category,b.meta_title,b.meta_keywords,b.meta_description,b.views,b.log_date_created as blogdatetime,bc.name as blogcat,bc.id as blogcatid,b.created_by as blogcreatedby FROM blog b INNER JOIN blog_category bc ON b.category=bc.id 
               WHERE 1=1 AND b.status="Active"';
			   if($blog_id!="")
			   {
				   $sql.=' and b.id="'.$blog_id.'"';
			   }
			    $sql.=' order by b.id desc';
			   
    	return $this->db->executeQuery($sql);
	}
    function getBlogComments($blog_id=null)
	{
		 $sql ='SELECT  b.id as blogid, b.title,b.description,b.attachment,b.tags,b.category,b.meta_title,b.meta_keywords,b.meta_description,b.views,b.log_date_created as blogdatetime,bc.comment as comment,bc.id as blogcommentid,bc.log_date_created as commentdate,bc.user_id as bcuserid,bc.name as bcname,bc.email as bcemail FROM blog b INNER JOIN blog_comments bc ON b.id=bc.blog_id 
               WHERE 1=1 AND bc.status="Active" and bc.blog_id="'.$blog_id.'" order by bc.id desc';
			   
    	return $this->db->executeQuery($sql);
	}
	function getPopularBlog($blog_id=null)
	{
		 $sql ='SELECT  b.id as blogid, b.title,b.description,b.attachment,b.tags,b.category,b.meta_title,b.meta_keywords,b.meta_description,b.views,b.log_date_created as blogdatetime,bc.name as blogcat,bc.id as blogcatid FROM blog b INNER JOIN blog_category bc ON b.category=bc.id 
               WHERE 1=1 AND b.status="Active"';
			   if($blog_id!="")
			   {
				   $sql.=' and b.id="'.$blog_id.'"';
			   }
			   $sql.=' order by b.views desc limit 6';
			   
    	return $this->db->executeQuery($sql);
	}
	function getRecentBlog($blog_id=null)
	{
		 $sql ='SELECT  b.id as blogid, b.title,b.description,b.attachment,b.tags,b.category,b.meta_title,b.meta_keywords,b.meta_description,b.views,b.log_date_created as blogdatetime,bc.name as blogcat,bc.id blogcatid FROM blog b INNER JOIN blog_category bc ON b.category=bc.id 
               WHERE 1=1 AND b.status="Active"';
			   if($blog_id!="")
			   {
				   $sql.=' and b.id="'.$blog_id.'"';
			   }
			   $sql.=' order by b.id desc limit 6';
			   
    	return $this->db->executeQuery($sql);
	}
	function getBlogCategories()
	{
		$sql ='SELECT  * from blog_category WHERE 1=1 AND status="Active" order by id desc';
    	return $this->db->executeQuery($sql);
	}
	function getBlogCategoryById($cat_id=null)
	{
		$sql ='SELECT  b.id as blogid, b.title,b.description,b.attachment,b.tags,b.category,b.meta_title,b.meta_keywords,b.meta_description,b.views,b.log_date_created as blogdatetime,bc.name as blogcat,bc.id blogcatid FROM blog b INNER JOIN blog_category bc ON b.category=bc.id 
               WHERE 1=1 AND b.status="Active"';
			   if($cat_id!="")
			   {
				   $sql.=' and bc.id="'.$cat_id.'"';
			   }
			   $sql.=' order by b.id desc';
			   
    	return $this->db->executeQuery($sql);
	}
	function saveBlogComment()
	{
		 $sql = 'INSERT INTO `blog_comments`(`blog_id`, `user_id`, `comment`, `status`, `log_date_created`, `name`, `email`) 
        VALUES ("'.$this->blog_id.'","'.$this->user_id.'","'.$this->comment.'","Inactive","'.date('Y-m-d H:i:s').'","'.$this->name.'","'.$this->email.'")';
        return $this->db->boolean_executeQuery($sql);
	}
	function updateBlogViews($blog_id)
	{
		$sql='update blog set views=views+1 where id="'.$blog_id.'"';
		return $this->db->boolean_executeQuery($sql);
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
    
    function updateServiceDateTime()
	{
		$sql='update task set date="'.$this->task_date.'",time="'.$this->task_time.'",log_date_modified="'.date('Y-m-d H:i:s').'",modified_by="'.$this->user_id.'" where id="'.$this->task_id.'"';
		return $this->db->boolean_executeQuery($sql);
	}
	function get_task_details_new($task_id)
    {
        $sql="select t.id,t.code,t.title,t.category_id,t.sub_category_id,c.name as cname,c.attachment cphoto,s.name as sname,s.attachment as sphoto,t.description,t.budget,t.postal_code,t.city,t.address,t.land_mark,t.date, t.time,
         t.verified, t.status, t.log_date_created, t.created_by, t.log_date_modified, t.modified_by, t.is_negotiate from task t inner join category c on t.category_id=c.id inner join subcategory s on t.sub_category_id=s.id 
        where 1=1 and t.id='$task_id' order by id desc";
        return $this->db->executeQuery($sql);
    }
    function getTaskImage($task_id)
	{
		   $sql="select t.id,t.code,t.title,c.attachment from task t inner join user_upload c on t.id=c.ref_id
        where c.type='job' and  1=1 and t.id='$task_id' and c.ref_id='$task_id' order by id desc";
        return $this->db->executeQuery($sql);
	}
	function getLocationCountByCatId($cat_id)
	{
	     $sql="select * from category c inner join subcategory s on c.id=s.category_id inner join user u on s.id=u.category_id where s.category_id='$cat_id' and u.address!='' group by u.address";
        return $this->db->executeQuery($sql);
	}
	//Developer Madhavi B, Date: 11-01-2021, End
	
	
/* Function End */
}
function super_unique($array,$key)
    {
       $temp_array =array();
       foreach ($array as &$v) {
           if (!isset($temp_array[$v[$key]]))
           $temp_array[$v[$key]] =& $v;
       }
       $array = array_values($temp_array);
       return $array;

    }
    
    
    

?>