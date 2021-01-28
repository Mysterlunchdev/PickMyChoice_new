<?php
//error_reporting(0);
require 'db.php';
date_default_timezone_set('Asia/Kolkata');
class Common_Mdl {

    var $conn;
    function __construct() {
          $this->db = new DB();
    }
    function fetch_main_categories()
    {
      $sql = 'select id,name,attachment,banner from category where parent_id=0 and status="Active"';
      return $this->db->executeQuery($sql);
    }
    function fetch_sub_cat_by_catid($id)
    {
      $sql = 'select id,name,attachment,banner from category where parent_id="'.$id.'" and parent_id!=0 and status="Active"';
      return $this->db->executeQuery($sql);
    }
    function fetch_recent_added_data()
    {
      $sql = 'SELECT ap.id as ad_id,ap.title,ap.price,ap.neighbourhood,ap.city,ap.ad_code,u.id,u.name,u.email,u.mobile,count(av.id) as views,s.name as state_name,api.attachment FROM add_post ap LEFT JOIN `ads_view` av  ON av.ad_id=ap.id LEFT JOIN user u ON  u.id=ap.user_id LEFT JOIN state s ON s.id=ap.state LEFT JOIN add_post_images api ON api.add_post_id=ap.id WHERE ap.verified="Yes" AND ap.status="Yes" GROUP BY ap.category_id order by ap.log_date_created asc';
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
        $sql = 'update user set name="'.$name.'",email="'.$email.'",mobile="'.$mobile.'",about="'.$about.'",city="'.$city.'",location="'.$location.'",address="'.$address.'" where id="'.$user_id.'"';
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
function fetch_user_details($user_id)
{
    $sql   = 'SELECT id,name,last_name,profile_uniqueid,email,email_verified,mobile,mobile_verified,attachment,about,city,address,fb_id,gplus_id FROM user WHERE id="'.$user_id.'"';
    $data =  $this->db->executeQuery($sql);
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
     function add_post()
     {
         $sql = 'UPDATE `add_post` SET `category_id`="'.$this->category.'",`brand_id`="'.$this->brand.'",`title`="'.$this->title.'",`description`="'.$this->desc.'",`year`="'.$this->year.'",`fuel`="'.$this->fuel.'",`km_driven`="'.$this->km_driven.'",`salary_period`="'.$this->salary_period.'",`position_type`="'.$this->position_type.'",`salary_from`="'.$this->salary_from.'",`salary_to`="'.$this->salary_to.'",`verified`="No",`status`="No",`log_date_created`="'.date('Y-m-d H:i:s').'",`created_by`="'.$this->userid.'",`make_an_offer`="No",`ad_code`="'.$this->ad_code.'",`variant`="'.$this->variant.'",`transmission`="'.$this->transmission.'",`mileage`="'.$this->mileage.'",`no_of_owners`="'.$this->no_of_owners.'",`price`="'.$this->price.'",`model`="'.$this->model.'",`steering_wheel`="'.$this->wheel.'",`state`="'.$this->state.'",`city`="'.$this->city.'",`neighbourhood`="'.$this->neighbourhood.'",`name`="'.$this->name.'",`mobile`="'.$this->mobile.'",`sub_cat_id`="'.$this->sub_cat.'",`type`="'.$this->type.'" WHERE `id`="'.$this->add_id.'"';
         return $this->db->boolean_executeQuery($sql);
     }
      function insert_property()
      {
        $sql = 'INSERT INTO `property_details`(`user_id`, `add_post_id`, `facing_type_id`, `bedrooms`, `bathrooms`, `furnishing`, `construction_status`, `listed_by`, 
        `carpet_area`, `car_parking`,`project_name`,`plot_area`,`status`, `log_date_created`, `created_by`,`apartment_type_id`,
        `length`,`breadth`) VALUES ("'.$this->userid.'","'.$this->add_post_id.'","'.$this->facing.'","'.$this->rooms.'","'.$this->bathrooms.'","'.$this->furnished.'",
        "'.$this->construction_status.'","'.$this->listed_by.'","'.$this->area.'",
        "'.$this->car_parking.'","'.$this->projectname.'","'.$this->area.'","Active","'.date('Y-m-d H:i:s').'","'.$this->userid.'","'.$this->type.'",
        "'.$this->length.'","'.$this->breadth.'")';
        return $this->db->getinsertidQuery($sql);
     }
     
     function property_update()
      {
        $sql = 'UPDATE `property_details` SET `user_id`="'.$this->userid.'",`facing_type_id`="'.$this->facing.'",`bedrooms`="'.$this->rooms.'",`bathrooms`="'.$this->bathrooms.'",`furnishing`="'.$this->furnished.'"],`construction_status`="'.$this->construction_status.'",`listed_by`="'.$this->listed_by.'",`carpet_area`="'.$this->area.'",`car_parking`="'.$this->car_parking.'",`type`="'.$this->type.'",`project_name`="'.$this->projectname.'",`plot_area`="'.$this->area.'",`length`="'.$this->length.'",`breadth`="'.$this->breadth.'",`log_date_modified`="'.date('Y-m-d H:i:s').'",`modified_by`="'.$this->userid.'" WHERE add_post_id="'.$this->add_id.'"';
        return $this->db->boolean_executeQuery($sql);
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
}
function super_unique($array,$key)
    {
       $temp_array = [];
       foreach ($array as &$v) {
           if (!isset($temp_array[$v[$key]]))
           $temp_array[$v[$key]] =& $v;
       }
       $array = array_values($temp_array);
       return $array;

    }

?>