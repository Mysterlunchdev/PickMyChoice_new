<?php
require_once '../models/common_model.php';
require_once '../helpers/DefaultResponse.php';
$common_model = new Common_Mdl();
include_once ('../lib/resize-class.php');
$dr = new DefaultResponse();
$json = file_get_contents('php://input');
$json_decode = json_decode($json);
$categories = NULL;
$api_token = NULL;
$user_id = NULL;
if(isset($_POST['type']) && !empty($_POST['type']))
{
    $post_type = $_POST['type'];
    $api_token = $_POST['token'];
    $user_id = $_POST['user_id'];
}
else
{
    $post_type=$json_decode->type;
    $api_token=$json_decode->token;
    $user_id=$json_decode->user_id;
}

if($api_token!='' && $user_id!='')
{
if($post_type=='adpost')
{
    $user_id=$json_decode->user_id;
    $cat_id=$json_decode->category_id;
    $sub_cat=$json_decode->sub_cat_id;
    $title=$json_decode->title;
    $description=$json_decode->description;
    $city_id=$json_decode->city_id;
    $neighbourhood=$json_decode->neighbourhood;
    $contact=$json_decode->contact_name;
    $mobile=$json_decode->mobile_no;
    $price=$json_decode->price;
    
    $ad_id = $json_decode->ad_id;
    if($user_id!='' && $cat_id!='' && $title!='' && $description!='' && $ad_id!='')
    {
        //common fields
        $common_model->title     = $title;
        $common_model->desc      = $description;
        $common_model->city      = $city_id;
        $common_model->neighbourhood = $neighbourhood;
        $common_model->name      = $contact;
        $common_model->mobile    = $mobile;
        $common_model->category  = $cat_id;
        $common_model->sub_cat   = $sub_cat;
        $common_model->userid    = $user_id;
        $common_model->ad_code   = rand(1000,999999);
        $common_model->price     = $price; 
        
        //vehicle fields
         $common_model->brand_id  = $json_decode->brand_id;
         $common_model->model     = $json_decode->model;
         $common_model->variants  = $json_decode->variants;
         $common_model->year      = $json_decode->year;
         $common_model->transmission = $json_decode->transmission;
         $common_model->steering     = $json_decode->steering;
         $common_model->fuel         = $json_decode->fuel;
         $common_model->km           = $json_decode->km;
             
        //job fields
        $common_model->salary_period = $json_decode->salary_period;
        $common_model->position_type = $json_decode->position_type;
        $common_model->salary_from   = $json_decode->salary_from;
        $common_model->salary_to     = $json_decode->salary_to;
        
        $common_model->add_id = $ad_id;
        
        $insert_id=$common_model->add_post();
        $breadth=$json_decode->breadth;
        $length=$json_decode->length;
        if($ad_id!='' && $breadth!='' && $length!='')
        {
        $common_model->breadth       = $json_decode->breadth;
        $common_model->length        = $json_decode->length;
        $common_model->area          = $json_decode->area;
        $common_model->facing        = $json_decode->facing;
        $common_model->listed_by     = $json_decode->listed_by;
        $common_model->type          = $json_decode->apartment_type;
        $common_model->rooms         = $json_decode->rooms;
        $common_model->bathrooms     = $json_decode->bathrooms;
        $common_model->construction_status = $json_decode->construction_status;
        $common_model->furnished     = $json_decode->furnished;
        $common_model->car_parking   = $json_decode->car_parking;
        $common_model->add_post_id   = $ad_id;
        $insert_id=$common_model->insert_property();
        }
        $respo1["status"] = true; 
 	    $respo1["msg"]    = 'successfully added';
 	    $respo1['errorCode'] = 700;
    }
    else
    {
        $respo1["status"] = false; 
	    $respo1["msg"]    = 'Send All Mandatory Fields';
	    $respo1['errorCode'] = 703;
	}
	echo json_encode($respo1);
}
if($post_type=='addpost_image')
{
    if(isset($_POST) && !empty($_POST))
    {
        $user_id = $_POST['user_id'];
        
        if(isset($user_id) && !empty($user_id))
        {
            $post_id = $_POST['ad_id'];
            if(isset($post_id) && !empty($post_id))
            {
                if(isset($_FILES['image']) && !empty($_FILES['image']['name']))
                {
                    
                        $allowed_extensions = array("image/png", "image/jpg", "image/jpeg");

             			if (!in_array($_FILES["image"]["type"], $allowed_extensions)) 
             			{
             				$errocode = $dr->getOK();
            		        $msg = 'Invalid image';
            		        $status = false;
            		        $res = '';
            		
                    		$dr->setErrorCode($errocode);
                        	$dr->setMsg($msg);
                        	$dr->setStatus($status);
                        	$dr->setCustomRsp('api_token', $api_token);
                        	echo $dr->getResponse();
             			} 
             			else 
             			{
             			    
             				$fname = $_FILES['image']['name'];
             				$larageUploadDir = "../../assets/ad_post_images/large_images/";
             				$mediumUploadDir = "../../assets/ad_post_images/big_images/";
             				$smallUploadDir = "../../assets/ad_post_images/small_images/";
             				$rand = rand(10, 9999);
             				$filename1 = explode('.', $fname);
             				
             				
            
            
             				$large_filename = 'large_' . $rand . time() . '.' . $filename1[1];
             				$big_filename = 'big_' . $rand . time() . '.' . $filename1[1];
             				$small_filename = 'small_' . $rand . time() . '.' . $filename1[1];
            
             				$image_type = $_FILES["image"]["type"];
            
            
             				$bigadd = $larageUploadDir . "$large_filename";
             				$mediumadd = $mediumUploadDir . "$large_filename";
             				$smalladd = $smallUploadDir . "$small_filename";
             				copy($_FILES['image']['tmp_name'], $bigadd);
             				copy($_FILES['image']['tmp_name'], $mediumadd);
             				copy($_FILES['image']['tmp_name'], $smalladd);
             				
             				
             			    $insert_image = $common_model->insert_ad_image($user_id,$post_id,$big_filename,$small_filename,$large_filename,$big_filename);
                            
             			}
             		
        	 
                    	 if($insert_image)
                    	 {
                    	     $errocode = $dr->getOK();
                		     $msg = 'image inserted successfully';
                		     $status = true;
                		     $res = '';
                		     
                		     $dr->setErrorCode($errocode);
                	         $dr->setMsg($msg);
                	         $dr->setStatus($status);
                	         $dr->setCustomRsp('ad_id', $post_id);
                	         $dr->setCustomRsp('api_token', $api_token);
                	         echo $dr->getResponse();
                    	 }
                }
                else
                {
                    $errocode = $dr->getOK();
    		        $msg = 'Image should not empty';
    		        $status = false;
    		        $res = '';
    		
            		$dr->setErrorCode($errocode);
                	$dr->setMsg($msg);
                	$dr->setStatus($status);
                	$dr->setCustomRsp('api_token', $api_token);
                	echo $dr->getResponse();
                }
            }
            else
            {
                $ads_id = $common_model->insert_empty_ad($user_id);
                
                if(isset($_FILES['image']) && !empty($_FILES['image']['name']))
                {
                    
                        $allowed_extensions = array("image/png", "image/jpg", "image/jpeg");

             			if (!in_array($_FILES["image"]["type"], $allowed_extensions)) 
             			{
             				$errocode = $dr->getOK();
            		        $msg = 'Invalid image';
            		        $status = false;
            		        $res = '';
            		
                    		$dr->setErrorCode($errocode);
                        	$dr->setMsg($msg);
                        	$dr->setStatus($status);
                        	$dr->setCustomRsp('api_token', $api_token);
                        	echo $dr->getResponse();
             			} 
             			else 
             			{
             			    
             				$fname = $_FILES['image']['name'];
             				$larageUploadDir = "../../assets/ad_post_images/large_images/";
             				$mediumUploadDir = "../../assets/ad_post_images/big_images/";
             				$smallUploadDir = "../../assets/ad_post_images/small_images/";
             				$rand = rand(10, 9999);
             				$filename1 = explode('.', $fname);
             				
             				
            
            
             				$large_filename = 'large_' . $rand . time() . '.' . $filename1[1];
             				$big_filename = 'big_' . $rand . time() . '.' . $filename1[1];
             				$small_filename = 'small_' . $rand . time() . '.' . $filename1[1];
            
             				$image_type = $_FILES["image"]["type"];
            
            
             				$bigadd = $larageUploadDir . "$large_filename";
             				$mediumadd = $mediumUploadDir . "$large_filename";
             				$smalladd = $smallUploadDir . "$small_filename";
             				copy($_FILES['image']['tmp_name'], $bigadd);
             				copy($_FILES['image']['tmp_name'], $mediumadd);
             				copy($_FILES['image']['tmp_name'], $smalladd);
             				
             				
             			    $insert_image = $common_model->insert_ad_image($user_id,$post_id,$big_filename,$small_filename,$large_filename,$big_filename);
                            
             			}
             		
        	 
                    	 if($insert_image)
                    	 {
                    	     $errocode = $dr->getOK();
                		     $msg = 'image inserted successfully';
                		     $status = true;
                		     $res = '';
                		     
                		     $dr->setErrorCode($errocode);
                	         $dr->setMsg($msg);
                	         $dr->setStatus($status);
                	         $dr->setCustomRsp('ad_id', $ads_id);
                	         $dr->setCustomRsp('api_token', $api_token);
                	         echo $dr->getResponse();
                    	 }
                }
                else
                {
                    $errocode = $dr->getOK();
    		        $msg = 'Image should not empty';
    		        $status = false;
    		        $res = '';
    		
            		$dr->setErrorCode($errocode);
                	$dr->setMsg($msg);
                	$dr->setStatus($status);
                	$dr->setCustomRsp('api_token', $api_token);
                	echo $dr->getResponse();
                }
            }
        }
        else
        {
            $errocode = $dr->getOK();
    		$msg = 'User id should not empty';
    		$status = false;
    		$res = '';
    		
    		$dr->setErrorCode($errocode);
        	$dr->setMsg($msg);
        	$dr->setStatus($status);
        	$dr->setCustomRsp('api_token', $api_token);
        	echo $dr->getResponse();
        }
    }
}

if($post_type=='category')
{
	$categories = $common_model->fetch_main_categories();

	if(count($categories)>0)
	{
		$errocode = $dr->getOK();
		$msg = 'categories found';
		$status = true;
		$res = '';
	}
	else
	{
		$errocode = $dr->getOK();
		$msg = 'categories not found';
		$status = false;
		$res = '';
	}

	$dr->setErrorCode($errocode);
	$dr->setMsg($msg);
	$dr->setStatus($status);
	$dr->setCustomRsp('categories', $categories);
	$dr->setCustomRsp('api_token', $api_token);
	echo $dr->getResponse();
}
elseif($post_type=='sub_category')
{
	$cat_id = $json_decode->category_id;
	$subcategories = $common_model->fetch_sub_cat_by_catid($cat_id);

	if(!empty($subcategories))
	{
		$errocode = $dr->getOK();
		$msg = 'Sub categories found';
		$status = true;
		$res = '';
	}
	else
	{
		$errocode = $dr->getOK();
		$msg = 'Sub categories not found';
		$status = false;
		$res = '';
	}

	$dr->setErrorCode($errocode);
	$dr->setMsg($msg);
	$dr->setStatus($status);
	$dr->setCustomRsp('subcategories', $subcategories);
	$dr->setCustomRsp('api_token', $api_token);
	echo $dr->getResponse();
}
elseif($post_type=='recent_ads')
{
	$recent_ads = $common_model->fetch_recent_added_data();
    $user_id = $json_decode->user_id;
    
    $respo1["recent_ads"] = array();
    if(!empty($recent_ads))
    {
       for($i=0;$i<count($recent_ads);$i++)
       {
          $respo = array();
          $adid  = $recent_ads[$i]['ad_id'];
          
          $isadded=false;
          if($user_id!='')
          {
          $isadded=$common_model->isaddedtowishlist($user_id,$adid);
          }
          
          $ad_image = $common_model->fetch_ad_image($recent_ads[$i]['ad_id']);
       	  $respo['ad_id']         = $recent_ads[$i]['ad_id'];
       	  $respo['title']         = $recent_ads[$i]['title'];
       	  $respo['price']         = $recent_ads[$i]['price'];
       	  $respo['neighbourhood'] = $recent_ads[$i]['neighbourhood'];
       	  $respo['city']          = $recent_ads[$i]['city'];
       	  $respo['ad_code']       = $recent_ads[$i]['ad_code'];
       	  $respo['views']         = $recent_ads[$i]['views'];
       	  $respo['user_id']       = $recent_ads[$i]['id'];
       	  $respo['user_name']     = $recent_ads[$i]['name'];
       	  $respo['user_email']    = $recent_ads[$i]['email'];
       	  $respo['user_mobile']   = $recent_ads[$i]['mobile'];

       	  if($recent_ads[$i]['state_name']=='')
       	  {
       	  	$respo['state']   = '';
       	  }
       	  else
       	  {
       	  	$respo['state']   = $recent_ads[$i]['state_name'];
       	  }
       	  
       	  if(!empty($ad_image))
       	  {
       	  	$respo['image']   = baseurl.'assets/ad_post_images/big_images/'.$recent_ads[0]['attachment'];
       	  }
       	  else
       	  {
       	    $respo['image']='';
       	  }
       	  if($isadded==true)
       	  {
       	      $respo['iswishlist']=true;
       	  }
       	  else
       	  {
       	      $respo['iswishlist']=false;
       	  }
       	  array_push($respo1["recent_ads"], $respo);
       }
	    $respo1["status"] = true; 
	    $respo1["msg"]    = 'Recent ads found';
	    $respo1['errorCode'] = 700;
    }
    else
	{
		$respo1["status"] = false; 
	    $respo1["msg"]    = 'Recent ads data not found';
	    $respo1['errorCode'] = 703;
	}
	echo json_encode($respo1);
}
elseif($post_type=='wishlist')
{
	$user_id = $json_decode->user_id;
	$wishlist = $common_model->fetch_user_wishlist_by_id($user_id);
	$respo1["wishlist"] = array();
    if(!empty($wishlist))
    {
       for($i=0;$i<count($wishlist);$i++)
       {
          $respo = array();
          $ad_image = $common_model->fetch_ad_image($wishlist[$i]['addid']);
          $respo['wishlist_id']   = $wishlist[$i]['wishlistid'];
       	  $respo['ad_id']         = $wishlist[$i]['addid'];
       	  $respo['ad_code']       = $wishlist[$i]['ad_code'];
       	  $respo['ad_user_id']    = $wishlist[$i]['adduser'];
       	  $respo['username']      = $wishlist[$i]['uname'];
       	  $respo['mobile']        = $wishlist[$i]['umobile'];
       	  $respo['title']         = $wishlist[$i]['title'];
       	  $respo['descrption']    = $wishlist[$i]['description'];
       	  $respo['price']         = $wishlist[$i]['price'];
       	  if($wishlist[$i]['city']!='')
       	  {
       	     $respo['city'] = $wishlist[$i]['city'];
       	  }
       	  else
       	  {
       	     $respo['city'] ='';
       	  }
       	  if($wishlist[$i]['neighbourhood']!='')
       	  {
       	     $respo['neighbourhood']= $wishlist[$i]['neighbourhood'];
       	  }
       	  else
       	  {
       	     $respo['neighbourhood']='';
       	  }
       	  
       	
       	  if(!empty($ad_image))
       	  {
       	  	$respo['image']   = baseurl.'assets/ad_post_images/small_images/'.$ad_image[0]['small_image'];
       	  }
       	  else
       	  {
       	    $respo['image']='';
       	  }
       	  array_push($respo1["wishlist"], $respo);
       }

       	$respo1["status"] = true; 
	    $respo1["msg"]    = 'wishlist result';
	    $respo1['errorCode'] = 700;
    }
    else
	{
		$respo1["status"] = false; 
	    $respo1["msg"]    = 'wishlist is empty';
	    $respo1['errorCode'] = 703;
	}
	echo json_encode($respo1);
}
elseif($post_type=='user_ads')
{
	$user_id = $json_decode->user_id;
	$published_ads = $common_model->fetch_user_published_ads($user_id);
	
	$respo1["published_ads"] = array();
    if(!empty($published_ads))
    {
       for($i=0;$i<count($published_ads);$i++)
       {
          $respo = array();
          $ad_image = $common_model->fetch_ad_image($published_ads[$i]['addid']);
          $adid=$published_ads[$i]['addid'];
          $isadded=false;
          if($user_id!='')
          {
          $isadded=$common_model->isaddedtowishlist($user_id,$adid);
          }
       	  $respo['ad_id']         = $published_ads[$i]['addid'];
       	  $respo['ad_code']     = $published_ads[$i]['ad_code'];
       	  $respo['ad_user_id']  = $published_ads[$i]['adduser'];
       	  $respo['title']         = $published_ads[$i]['title'];
       	  $respo['descrption']    = $published_ads[$i]['description'];
       	  $respo['price']         = $published_ads[$i]['price'];
       	  if($published_ads[$i]['city']!='')
       	  {
       	     $respo['city'] = $published_ads[$i]['city'];
       	  }
       	  else
       	  {
       	     $respo['city'] ='';
       	  }
       	  if($wishlist[$i]['neighbourhood']!='')
       	  {
       	     $respo['neighbourhood']= $published_ads[$i]['neighbourhood'];
       	  }
       	  else
       	  {
       	     $respo['neighbourhood']='';
       	  }
       	  
       	
       	  if(!empty($ad_image))
       	  {
       	  	$respo['image']   = baseurl.'assets/ad_post_images/small_images/'.$ad_image[0]['small_image'];
       	  }
       	  else
       	  {
       	    $respo['image']='';
       	  }
       	  $respo['iswishlist']=$isadded;
       	  array_push($respo1["published_ads"], $respo);
       }

       	$respo1["status"] = true; 
	    $respo1["msg"]    = 'published ads result';
	    $respo1['errorCode'] = 700;
    }
    else
	{
		$respo1["status"] = false; 
	    $respo1["msg"]    = 'published ads is empty';
	    $respo1['errorCode'] = 703;
	}
	echo json_encode($respo1);
	
}
elseif($post_type=='edit_profile')
{
    $user_id = $json_decode->user_id;

    $name   = $json_decode->name;
    $about  = $json_decode->about;
    $mobile = $json_decode->mobile;
    $email  = $json_decode->email;
    $city   = $json_decode->city;
    $location   = $json_decode->location;
    $address   = $json_decode->address;

    $check_mobile_exist = $common_model->check_mobile_exist_edit($mobile,$user_id);
    if(!empty($check_mobile_exist))
    {
    	$errocode = $dr->getOK();
		$msg = 'mobile number already exist';
		$status = false;
		$res = '';
    }
    else
    {
    	$update = $common_model->update_userdata($name,$email,$mobile,$about,$user_id,$city,$location,$address);
    	if($update)
    	{
    		$errocode = $dr->getOK();
    		$msg = 'updated successfully';
    		$status = true;
    		$res = '';
    	}
    }

	$dr->setErrorCode($errocode);
	$dr->setMsg($msg);
	$dr->setStatus($status);
	//$dr->setCustomRsp('published_ads', $published_ads);
	$dr->setCustomRsp('api_token', $api_token);
	echo $dr->getResponse();
}
elseif($post_type=='view_ad')
{
    $ad_id = $json_decode->ad_id;

    $ad_data = $common_model->fetch_ad_details($ad_id);
   
    if(!empty($ad_data))
	{
		$errocode = $dr->getOK();
		$msg = 'ad found';
		$status = true;
		$res = '';
	}
	else
	{
		$errocode = $dr->getOK();
		$msg = 'Ad data not found';
		$status = false;
		$res = '';
	}

	$dr->setErrorCode($errocode);
	$dr->setMsg($msg);
	$dr->setStatus($status);
	$dr->setCustomRsp('ad_data', $ad_data);
	$dr->setCustomRsp('api_token', $api_token);
	echo $dr->getResponse();
}
elseif($post_type=='related_ads')
{
    $ad_id = $json_decode->ad_id;
    $user_id = $json_decode->user_id;
    $ad_data = $common_model->fetch_related_ads($ad_id);
    $user_id = $json_decode->user_id;
    
	$respo1["ad_data"] = array();
    if(!empty($ad_data))
    {
       for($i=0;$i<count($ad_data);$i++)
       {
          $respo = array();
          $adid  = $ad_data[$i]['ad_id'];
          
          $isadded=false;
          if($user_id!='')
          {
          $isadded=$common_model->isaddedtowishlist($user_id,$adid);
          }
          
          $ad_image = $common_model->fetch_ad_image($ad_data[$i]['ad_id']);
       	  $respo['id']            = $ad_data[$i]['ad_id'];
       	  $respo['title']         = $ad_data[$i]['title'];
       	  $respo['price']         = $ad_data[$i]['price'];
       	  $respo['neighbourhood'] = $ad_data[$i]['neighbourhood'];
       	  $respo['city']          = $ad_data[$i]['city'];
       	  $respo['ad_code']       = $ad_data[$i]['ad_code'];
       	  $respo['user_id']       = $ad_data[$i]['id'];
       	  $respo['user_name']     = $ad_data[$i]['name'];
       	  $respo['user_email']    = $ad_data[$i]['email'];
       	  $respo['user_mobile']   = $ad_data[$i]['mobile'];

       	  if($ad_data[$i]['state_name']=='')
       	  {
       	  	$respo['state']   = '';
       	  }
       	  else
       	  {
       	  	$respo['state']   = $ad_data[$i]['state_name'];
       	  }
       	  
       	  if(!empty($ad_image))
       	  {
       	  	$respo['image']   = baseurl.'assets/ad_post_images/big_images/'.$ad_image[0]['attachment'];
       	  }
       	  else
       	  {
       	    $respo['image']='';
       	  }
       	  if($isadded==true)
       	  {
       	      $respo['iswishlist']=true;
       	  }
       	  else
       	  {
       	      $respo['iswishlist']=false;
       	  }
       	  
       	  array_push($respo1["ad_data"], $respo);
       }
       	$respo1["status"] = true; 
	    $respo1["msg"]    = 'Related ads found';
	    $respo1['errorCode'] = 700;
    }
    else
	{
		$respo1["status"] = false; 
	    $respo1["msg"]    = 'Related ads data not found';
	    $respo1['errorCode'] = 703;
	}
	echo json_encode($respo1);
}
elseif($post_type=='seller_profile')
{
    $seller_id = $json_decode->seller_id;
    $data = $common_model->fetch_seller_details($seller_id);
    if(!empty($data))
	{
		$errocode = $dr->getOK();
		$msg = 'seller data found';
		$status = true;
		$res = '';
	}
	else
	{
		$errocode = $dr->getUSERNOTFOUND();
		$msg = 'seller data not found';
		$status = false;
		$res = '';
	}

	$dr->setErrorCode($errocode);
	$dr->setMsg($msg);
	$dr->setStatus($status);
	$dr->setCustomRsp('data', $data);
//	$dr->setCustomRsp('api_token', $api_token);
	echo $dr->getResponse();
}
elseif($post_type=='get_profile')
{
    $seller_id = $json_decode->user_id;
    $data = $common_model->fetch_user_details($seller_id);
    $respo1["profile"] = array();
    if(!empty($data))
    {
       for($i=0;$i<count($data);$i++)
       {
          $respo = array();
          //$ad_image = $common_model->fetch_ad_image($published_ads[$i]['addid']);
       	  $respo['id']       = $data[$i]['id'];
       	  $respo['name']     = $data[$i]['name'];
       	  if($data[$i]['last_name']!='')
       	  {
       	     $respo['last_name'] = $data[$i]['last_name'];
       	  }
       	  else
       	  {
       	     $respo['last_name'] ='';
       	  }
       	  if($data[$i]['profile_uniqueid']!='')
       	  {
       	     $respo['uniqueid'] = $data[$i]['profile_uniqueid'];
       	  }
       	  else
       	  {
       	     $respo['uniqueid'] ='';
       	  }
       	  
       	  $respo['email']  = $data[$i]['email'];
       	  $respo['email_verified'] = $data[$i]['email_verified'];
       	  $respo['mobile']  = $data[$i]['mobile'];
       	  $respo['mobile_verified']= $data[$i]['mobile_verified'];
    
       	  if($data[$i]['city']!='')
       	  {
       	     $respo['city'] = $data[$i]['city'];
       	  }
       	  else
       	  {
       	     $respo['city'] ='';
       	  }
       	  if($data[$i]['address']!='')
       	  {
       	     $respo['address'] = $data[$i]['address'];
       	  }
       	  else
       	  {
       	     $respo['address'] ='';
       	  }
       	  if($data[$i]['about']!='')
       	  {
       	     $respo['about'] = $data[$i]['about'];
       	  }
       	  else
       	  {
       	     $respo['about'] ='';
       	  }
       	  
       	  if(!empty($data[$i]['attachment']))
       	  {
       	  	$respo['image']   = baseurl.'assets/user_profile/'.$data[0]['attachment'];
       	  }
       	  else
       	  {
       	    $respo['image']='';
       	  }
       	  
       	  if(!empty($data[$i]['fb_id']))
       	  {
       	      $respo['fb_connected']='yes';
       	  }
       	  else
       	  {
       	      $respo['fb_connected']='no';
       	  }
       	  
       	  if(!empty($data[$i]['gplus_id']))
       	  {
       	      $respo['gplus_connected']='yes';
       	  }
       	  else
       	  {
       	      $respo['gplus_connected']='no';
       	  }
       	  
       	  array_push($respo1["profile"], $respo);
       }

       	$respo1["status"] = true; 
	    $respo1["msg"]    = 'profile result';
	    $respo1['errorCode'] = 700;
    }
    else
	{
		$respo1["status"] = false; 
	    $respo1["msg"]    = 'User Not Available';
	    $respo1['errorCode'] = 703;
	}
	echo json_encode($respo1);
}
elseif($post_type=='trending')
{
    $tren_ad_data = $common_model->fetch_trending_ads();
    $user_id = $json_decode->user_id;
	$respo1["trending_ad_data"] = array();
    if(!empty($tren_ad_data))
    {
       for($i=0;$i<count($tren_ad_data);$i++)
       {
          $respo = array();
          $adid  = $tren_ad_data[$i]['ad_id'];
          
          $isadded=false;
          if($user_id!='')
          {
          $isadded=$common_model->isaddedtowishlist($user_id,$adid);
          }
          
          $ad_image = $common_model->fetch_ad_image($tren_ad_data[$i]['ad_id']);
       	  $respo['ad_id']         = $tren_ad_data[$i]['ad_id'];
       	  $respo['title']         = $tren_ad_data[$i]['title'];
       	  $respo['price']         = $tren_ad_data[$i]['price'];
       	  $respo['neighbourhood'] = $tren_ad_data[$i]['neighbourhood'];
       	  $respo['city']          = $tren_ad_data[$i]['city'];
       	  $respo['ad_code']       = $tren_ad_data[$i]['ad_code'];
       	  $respo['user_id']       = $tren_ad_data[$i]['id'];
       	  $respo['user_name']     = $tren_ad_data[$i]['name'];
       	  $respo['user_email']    = $tren_ad_data[$i]['email'];
       	  $respo['user_mobile']   = $tren_ad_data[$i]['mobile'];

       	  if($tren_ad_data[$i]['state_name']=='')
       	  {
       	  	$respo['state']   = '';
       	  }
       	  else
       	  {
       	  	$respo['state']   = $tren_ad_data[$i]['state_name'];
       	  }
       	  
       	  if(!empty($ad_image))
       	  {
       	  	$respo['image']   = baseurl.'assets/ad_post_images/big_images/'.$ad_image[0]['attachment'];
       	  }
       	  else
       	  {
       	    $respo['image']='';
       	  }
       	  if($isadded==true)
       	  {
       	      $respo['iswishlist']=true;
       	  }
       	  else
       	  {
       	      $respo['iswishlist']=false;
       	  }
       	  
       	  array_push($respo1["trending_ad_data"], $respo);
       }

       	$respo1["status"] = true; 
	    $respo1["msg"]    = 'Trending ads found';
	    $respo1['errorCode'] = 700;
    }
    else
	{
		$respo1["status"] = false; 
	    $respo1["msg"]    = 'Trending ads data not found';
	    $respo1['errorCode'] = 703;
	}

	echo json_encode($respo1);
}
elseif($post_type=='sub_cat_product')
{
	$cat_id     = $json_decode->cat_id;
	$sub_cat_id = $json_decode->sub_cat_id;
    $user_id    = $json_decode->user_id;
    
    $ad_data = $common_model->fetch_sub_cat_product_ads($cat_id,$sub_cat_id);
    $respo1["ad_data"] = array();
    if(!empty($ad_data))
    {
       
       for($i=0;$i<count($ad_data);$i++)
       {
          $respo = array();
          $adid=$ad_data[$i]['ad_id'];
          $isadded=false;
          if($user_id!='')
          {
          $isadded=$common_model->isaddedtowishlist($user_id,$adid);
          }
          $ad_image = $common_model->fetch_ad_image($ad_data[$i]['ad_id']);

       	  $respo['ad_id']         = $ad_data[$i]['ad_id'];
       	  $respo['title']         = $ad_data[$i]['title'];
       	  $respo['price']         = $ad_data[$i]['price'];
       	  $respo['neighbourhood'] = $ad_data[$i]['neighbourhood'];
       	  $respo['city']          = $ad_data[$i]['city'];
       	  $respo['ad_code']       = $ad_data[$i]['ad_code'];
       	  $respo['user_name']     = $ad_data[$i]['name'];
       	  $respo['user_email']    = $ad_data[$i]['email'];
       	  $respo['user_mobile']   = $ad_data[$i]['mobile'];

       	  if($ad_data[$i]['state_name']=='')
       	  {
       	  	$respo['state']   = '';
       	  }
       	  else
       	  {
       	  	$respo['state']   = $ad_data[$i]['state_name'];
       	  }

       	  if(!empty($ad_image))
       	  {
       	  	$respo['image']   = baseurl.'assets/ad_post_images/small_images/'.$ad_image[0]['small_image'];
       	  }
       	  else
       	  {
       	    $respo['image']='';
       	  }
       	  if($isadded==true)
       	  {
       	      $respo['iswishlist']=true;
       	  }
       	  else
       	  {
       	      $respo['iswishlist']=false;
       	  }
       	  array_push($respo1["ad_data"], $respo);
       }

        $respo1["status"] = true; 
	    $respo1["msg"]    = 'ads data found';
	    $respo1['errorCode'] = 700;
    }
    else
	{
		$respo1["status"] = false; 
	    $respo1["msg"]    = 'ads data not found';
	    $respo1['errorCode'] = 703;
	}

	echo json_encode($respo1);
}
 elseif($post_type=='add_to_wishlist')
 {
 	$user_id     = $json_decode->user_id;
 	$ad_id       = $json_decode->ad_id;

     $add_to_wishlist = $common_model->add_to_wish($user_id,$ad_id);
     if(!empty($add_to_wishlist))
     {
        $respo1["status"] = true; 
 	    $respo1["msg"]    = 'successfully added';
 	    $respo1['errorCode'] = 700;
     }
     else
 	{
 		$respo1["status"] = false; 
	    $respo1["msg"]    = 'failed to add';
 	    $respo1['errorCode'] = 703;
 	}
 	echo json_encode($respo1);
}
elseif($post_type=='remove_wishlist')
{
 	 $common_model->user_id     = $json_decode->user_id;
 	 $common_model->ad_id       = $json_decode->ad_id;
     $add_to_wishlist = $common_model->remove_from_wish();
     
     if(!empty($add_to_wishlist))
     {
        $respo1["status"] = true; 
 	    $respo1["msg"]    = 'successfully removed';
 	    $respo1['errorCode'] = 700;
     }
     else
 	 {
 		$respo1["status"] = false; 
	    $respo1["msg"]    = 'failed to remove';
 	    $respo1['errorCode'] = 703;
 	 }
 	echo json_encode($respo1);
}
elseif($post_type=='table')
{
 	 $table    = $json_decode->table;
 	 $ref_id   = $json_decode->ref_id;
 	 $tid      = $json_decode->id;
 	 $refid='';
 	 $id='';
 	 $idfield='';
 	 $reffield='';
 	 $fields='';
 	 if($table!='')
 	 {
 	     if($ref_id!='')
 	     {
 	         $refid=$ref_id;
 	     }
 	     if($tid!='')
 	     {
 	         $id=$tid;
 	     }
 	     if($table=='district')
 	     {
 	         $fields='id,district_name';
 	         $idfield='id';
 	         $data = $common_model->fetch_table_data($table,$fields,$id,$refid,$idfield,$reffield);
 	     }
         if($table=='apartment_type')
 	     {
 	         $fields='id,name';
 	         $idfield='id';
 	         $data = $common_model->fetch_table_data($table,$fields,$id,$refid,$idfield,$reffield);
 	     }
 	     if($table=='brand')
 	     {
 	         $fields='id,name';
 	         $idfield='id';
 	         $reffield='category_id';
 	         $data = $common_model->fetch_table_data($table,$fields,$id,$refid,$idfield,$reffield);
 	     }
 	     if($table=='model')
 	     {
 	         $fields='id,model_name';
 	         $idfield='id';
 	         $reffield='brand_id';
 	         $data = $common_model->fetch_table_data($table,$fields,$id,$refid,$idfield,$reffield);
 	     }
 	     if($table=='variants')
 	     {
 	         $fields='id,variant_name';
 	         $idfield='id';
 	         $reffield='model_id';
 	         $data = $common_model->fetch_table_data($table,$fields,$id,$refid,$idfield,$reffield);
 	     }
 	     
 	     if($table=='facing_type')
 	     {
 	         $fields='id,name';
 	         $idfield='id';
 	         $reffield='';
 	         $data = $common_model->fetch_table_data($table,$fields,$id,$refid,$idfield,$reffield);
 	     }
 	     if($table=='position_type')
 	     {
 	         $fields='id,name';
 	         $idfield='id';
 	         $reffield='';
 	         $data = $common_model->fetch_table_data($table,$fields,$id,$refid,$idfield,$reffield);
 	     }
 	     if($table=='salary_period')
 	     {
 	         $fields='id,name';
 	         $idfield='id';
 	         $reffield='';
 	         $data = $common_model->fetch_table_data($table,$fields,$id,$refid,$idfield,$reffield);
 	     }
 	     if($table=='manufactured_year')
 	     {
 	         $fields='id,name';   
 	         for($y=1990;$y<=date('Y');$y++)
 	         {
 	             $data[] = array("id"=>$y,"name"=>$y);
 	         }
 	         
 	         
 	     }
 	     if($table=='transmission')
 	     {
 	         $fields='id,name';   
 	         $tra = array('automatic','manual');
 	         
 	         foreach($tra as $t)
 	         {
 	             $data[] = array("id"=>$t,"name"=>$t);
 	         }
 	     }
 	     if($table=='steerning_wheel')
 	     {
 	         $fields='id,name';   
 	         $tra = array('left','right');
 	         
 	         foreach($tra as $t)
 	         {
 	             $data[] = array("id"=>$t,"name"=>$t);
 	         }
 	     }
 	     if($table=='fuel')
 	     {
 	         $fields='id,name';   
 	         $tra = array('diesel','electric','petrol');
 	         
 	         foreach($tra as $t)
 	         {
 	             $data[] = array("id"=>$t,"name"=>$t);
 	         }
 	     }
 	     if($table=='city')
 	     {
 	        
 	         $fields='id,district_name';
 	         $idfield='id';
 	         $reffield='';
 	         $data = $common_model->fetch_table_data('district',$fields,$id,$refid,$idfield,$reffield);
 	     }
 	     
 	     if($table=='listed_by')
 	     {
 	         $fields='id,name';   
 	         $tra = array('builder','dealer','owner');
 	         
 	         foreach($tra as $t)
 	         {
 	             $data[] = array("id"=>$t,"name"=>$t);
 	         }
 	     }
 	     
 	     if($table=='no_of_rooms' || $table=='bathrooms' || $table=='bedrooms')
 	     {
 	         $fields='id,name';   
 	         $tra = array('1','2','3','+4');
 	         
 	         foreach($tra as $t)
 	         {
 	             $data[] = array("id"=>$t,"name"=>$t);
 	         }
 	     }
 	     
 	     if($table=='furnished')
 	     {
 	         $fields='id,name';   
 	         $tra = array('furnished','semifurnished','unfurnished');
 	         
 	         foreach($tra as $t)
 	         {
 	             $data[] = array("id"=>$t,"name"=>$t);
 	         }
 	     }
 	     
 	     if($table=='contructionstatus')
 	     {
 	         $fields='id,name';   
 	         $tra = array('newlaunch','readytomove','underconstruction');
 	         
 	         foreach($tra as $t)
 	         {
 	             $data[] = array("id"=>$t,"name"=>$t);
 	         }
 	     }
 	     
 	     if($table=='car_parking')
 	     {
 	         $fields='id,name';   
 	         $tra = array('0','1','2','3','4');
 	         
 	         foreach($tra as $t)
 	         {
 	             $data[] = array("id"=>$t,"name"=>$t);
 	         }
 	     }
 	     
 	     
 	     
 	     if($fields!='')
 	     {
 	         $farr=explode(',',$fields);
 	         $f1=$farr[0];
 	         $f2=$farr[1];
 	     }
 	     
 	    $respo1["table_data"] = array();
        if(!empty($data))
        {
           for($i=0;$i<count($data);$i++)
           {
              $respo = array();
              $respo['id']   = $data[$i][$f1];
           	  $respo['name'] = $data[$i][$f2];
           	  array_push($respo1["table_data"], $respo);
           }
        }
        $respo1["status"] = true; 
 	    $respo1["msg"]    = 'Table Result';
 	    $respo1['errorCode'] = 700;
 	 }
     else
     {
        $respo1["status"] = false; 
 	    $respo1["msg"]    = 'Send table name';
 	    $respo1['errorCode'] = 703;
     }
 	echo json_encode($respo1);
}
// elseif($post_type=='add_post')
// {
// 	$cat     = $json_decode->category;
// 	$sub_cat = $json_decode->sub_category;
// }
elseif($post_type=='ad_view')
{
	$ad_id     = $json_decode->ad_id;
    $ad_data   = $common_model->fetch_ad_view_details($ad_id);
    $user_id   = $json_decode->user_id;
    $respo1 = array();

    if(!empty($ad_data)>0)
    {
    	for($b=0;$b<count($ad_data);$b++)
    	{
    	   $isadded=false;
           if($user_id!='')
           {
           $isadded=$common_model->isaddedtowishlist($user_id,$ad_id);
           }
           $respo1["user_id"]     = $ad_data[$b]['user_id'];
           $respo1["user_name"]   = $ad_data[$b]['user_name'];
           $respo1["user_email"]  = $ad_data[$b]['user_email'];
           $respo1["user_mobile"] = $ad_data[$b]['user_mobile'];
           $respo1["ad_id"]       = $ad_data[$b]['ad_id'];
           $respo1["title"]       = $ad_data[$b]['title'];
           $respo1["description"] = $ad_data[$b]['description'];
           $respo1["ad_code"]     = $ad_data[$b]['ad_code'];
           $respo1["price"]       = $ad_data[$b]['price'];
           // $respo1['neighbourhood']    = $ad_data[$b]['neighbourhood'];

           if($ad_data[$b]['city_name']=='')
           {
           	$respo1['city']   = '';
           }
           else
           {
           	$respo1['city']   = $ad_data[$b]['city_name'];
           }

           if($ad_data[$b]['neighbourhood']=='')
           {
           	$respo1['neighbourhood']   = '';
           }
           else
           {
           	$respo1['neighbourhood']   = $ad_data[$b]['neighbourhood'];
           }
           $respo1["iswishlist"]       = $isadded;
    	}

    $cat_name =  $ad_data[0]['cat_name'];
    if(strtolower($cat_name)=='commercial vehicles')
    {
    	$adData = $common_model->fetch_ad_data_by_name($cat_name,$ad_id);

    	if(count($adData)>0)
    	{
    		$respo1['details'] = array();
    		for($a=0;$a<count($adData);$a++)
    		{
    			$data=array();
    			if($adData[$a]['brandname']!='')
    			{
    				$data['key']='brand';
    				$data['value']=$adData[$a]['brandname'];
    				array_push($respo1['details'], $data);
    			}
    			if($adData[$a]['model_name']!='')
    			{
    				$data['key']='model';
    				$data['value']=$adData[$a]['model_name'];
    				array_push($respo1['details'], $data);
    			}
    			if($adData[$a]['variant_name']!='')
    			{
    				$data['key']='variant';
    				$data['value']=$adData[$a]['variant_name'];
    				array_push($respo1['details'], $data);
    			}
    			if($adData[$a]['year']!='')
    			{
    				$data['key']='manufacture_year';
    				$data['value']=$adData[$a]['year'];
    				array_push($respo1['details'], $data);
    			}
    			if($adData[$a]['transmission']!='')
    			{
    				$data['key']='transmission';
    				$data['value']=$adData[$a]['transmission'];
    				array_push($respo1['details'], $data);
    			}
    			if($adData[$a]['steering_wheel']!='')
    			{
    				$data['key']='steering_wheel';
    				$data['value']=$adData[$a]['steering_wheel'];
    				array_push($respo1['details'], $data);
    			}
    			if($adData[$a]['fuel']!='')
    			{
    				$data['key']='fuel';
    				$data['value']=$adData[$a]['fuel'];
    				array_push($respo1['details'], $data);
    			}
    			if($adData[$a]['km_driven']!='')
    			{
    				$data['key']='km_driven';
    				$data['value']=$adData[$a]['km_driven'];
    				array_push($respo1['details'], $data);
    			}
    		}
    	}
    }
    elseif(strtolower($cat_name)=='cars for sale')
    {
    	$adData = $common_model->fetch_ad_data_by_name($cat_name,$ad_id);

    	if(count($adData)>0)
    	{
    		$respo1['details'] = array();
    		for($a=0;$a<count($adData);$a++)
    		{
    			$data=array();
    			if($adData[$a]['brandname']!='')
    			{
    				$data['key']='brand';
    				$data['value']=$adData[$a]['brandname'];
    				array_push($respo1['details'], $data);
    			}
    			if($adData[$a]['model_name']!='')
    			{
    				$data['key']='model';
    				$data['value']=$adData[$a]['model_name'];
    				array_push($respo1['details'], $data);
    			}
    			if($adData[$a]['variant_name']!='')
    			{
    				$data['key']='variant';
    				$data['value']=$adData[$a]['variant_name'];
    				array_push($respo1['details'], $data);
    			}
    			if($adData[$a]['year']!='')
    			{
    				$data['key']='manufacture_year';
    				$data['value']=$adData[$a]['year'];
    				array_push($respo1['details'], $data);
    			}
    			if($adData[$a]['transmission']!='')
    			{
    				$data['key']='transmission';
    				$data['value']=$adData[$a]['transmission'];
    				array_push($respo1['details'], $data);
    			}
    			if($adData[$a]['steering_wheel']!='')
    			{
    				$data['key']='steering_wheel';
    				$data['value']=$adData[$a]['steering_wheel'];
    				array_push($respo1['details'], $data);
    			}
    			if($adData[$a]['fuel']!='')
    			{
    				$data['key']='fuel';
    				$data['value']=$adData[$a]['fuel'];
    				array_push($respo1['details'], $data);
    			}
    			if($adData[$a]['km_driven']!='')
    			{
    				$data['key']='km_driven';
    				$data['value']=$adData[$a]['km_driven'];
    				array_push($respo1['details'], $data);
    			}
    		}
    	}
    }
    elseif(strtolower($cat_name)=='mobile phones')
    {
    	$adData = $common_model->fetch_ad_data_by_name($cat_name,$ad_id);
    	if(count($adData)>0)
    	{
    		$respo1['details'] = array();
    		for($a=0;$a<count($adData);$a++)
    		{
    			$data=array();
    			if($adData[$a]['brandname']!='')
    			{
    				$data['key']='brand';
    				$data['value']=$adData[$a]['brandname'];
    				array_push($respo1['details'], $data);
    			}

    			if(isset($ad_data[0]['type']) && $adad_dataData[0]['type']!='')
    			{
    				$data['key']='type';
    				$data['value']=$ad_data[0]['type'];
    				array_push($respo1['details'], $data);
    			}
    		}
    	}
    }
    elseif(strtolower($cat_name)=='house for rent' || strtolower($cat_name)=='shops & offices for sale' || strtolower($cat_name)=='land for sale' || strtolower($cat_name)=='shops & offices for rent' || strtolower($cat_name)=='house for sale')
    {
    	$adData = $common_model->fetch_ad_data_by_name($cat_name,$ad_id);

      if(count($adData)>0)
      {
        $respo1['details'] = array();
        for($a=0;$a<count($adData);$a++)
        {
          $data=array();
          if($adData[$a]['facing']!='')
          {
            $data['key']='facing';
            $data['value']=$adData[$a]['facing'];
            array_push($respo1['details'], $data);
          }
          if($adData[$a]['aprt_name']!='')
          {
            $data['key']='aprt_name';
            $data['value']=$adData[$a]['aprt_name'];
            array_push($respo1['details'], $data);
          }
          if($adData[$a]['bedrooms']!='')
          {
            $data['key']='bedrooms';
            $data['value']=$adData[$a]['bedrooms'];
            array_push($respo1['details'], $data);
          }
          if($adData[$a]['bathrooms']!='')
          {
            $data['key']='bathrooms';
            $data['value']=$adData[$a]['bathrooms'];
            array_push($respo1['details'], $data);
          }
          if($adData[$a]['furnishing']!='')
          {
            $data['key']='furnishing';
            $data['value']=$adData[$a]['furnishing'];
            array_push($respo1['details'], $data);
          }
          if($adData[$a]['super_buildup_area']!='')
          {
            $data['key']='super_buildup_area';
            $data['value']=$adData[$a]['super_buildup_area'];
            array_push($respo1['details'], $data);
          }
          if($adData[$a]['carpet_area']!='')
          {
            $data['key']='carpet_area';
            $data['value']=$adData[$a]['carpet_area'];
            array_push($respo1['details'], $data);
          }
          if($adData[$a]['maintanance']!='')
          {
            $data['key']='maintanance';
            $data['value']=$adData[$a]['maintanance'];
            array_push($respo1['details'], $data);
          }
          if($adData[$a]['total_floors']!='')
          {
            $data['key']='total_floors';
            $data['value']=$adData[$a]['total_floors'];
            array_push($respo1['details'], $data);
          }
          if($adData[$a]['floor_no']!='')
          {
            $data['key']='floor_no';
            $data['value']=$adData[$a]['floor_no'];
            array_push($respo1['details'], $data);
          }
          if($adData[$a]['car_parking']!='')
          {
            $data['key']='car_parking';
            $data['value']=$adData[$a]['car_parking'];
            array_push($respo1['details'], $data);
          }
          if($adData[$a]['type']!='')
          {
            $data['key']='type';
            $data['value']=$adData[$a]['type'];
            array_push($respo1['details'], $data);
          }
          if($adData[$a]['project_name']!='')
          {
            $data['key']='project_name';
            $data['value']=$adData[$a]['project_name'];
            array_push($respo1['details'], $data);
          }
          if($adData[$a]['bachelers_allowed']!='')
          {
            $data['key']='bachelers_allowed';
            $data['value']=$adData[$a]['bachelers_allowed'];
            array_push($respo1['details'], $data);
          }
          if($adData[$a]['plot_area']!='')
          {
            $data['key']='plot_area';
            $data['value']=$adData[$a]['plot_area'];
            array_push($respo1['details'], $data);
          }
          if($adData[$a]['length']!='')
          {
            $data['key']='length';
            $data['value']=$adData[$a]['length'];
            array_push($respo1['details'], $data);
          }
          if($adData[$a]['breadth']!='')
          {
            $data['key']='breadth';
            $data['value']=$adData[$a]['breadth'];
            array_push($respo1['details'], $data);
          }
          if($adData[$a]['meals_included']!='')
          {
            $data['key']='meals_included';
            $data['value']=$adData[$a]['meals_included'];
            array_push($respo1['details'], $data);
          }
        }
      }

    }

    $get_images = $common_model->fetch_ad_view_images($ad_id);

    if(count($get_images)>0)
    {
       $respo1['images'] = array();
       $data_img['path'] = array();

       for($img=0;$img<count($get_images);$img++)
       {
         $data_img['path'] = baseurl.'assets/ad_post_images/big_images/'.$get_images[$img]['attachment'];
          array_push($respo1['images'], $data_img);
       }
   }


    $respo1["status"] = true; 
    $respo1["msg"]    = 'ads data found';
    $respo1['errorCode'] = 700;

	echo json_encode($respo1);
}
else
{
    $respo1["status"] = true; 
    $respo1["msg"]    = 'ads data not found';
    $respo1['errorCode'] = 700;

    echo json_encode($respo1);
}
}
elseif($post_type=='my_ads')
{
	$user_id = $json_decode->user_id;
	$wishlist = $common_model->fetch_user_ads($user_id);
	$respo1["ads"] = array();
    if(!empty($wishlist))
    {
       for($i=0;$i<count($wishlist);$i++)
       {
          $respo = array();
          $ad_image = $common_model->fetch_ad_image($wishlist[$i]['addid']);
       	  $respo['ad_id']         = $wishlist[$i]['addid'];
       	  $respo['ad_code']     = $wishlist[$i]['ad_code'];
       	  $respo['title']         = $wishlist[$i]['title'];
       	  $respo['descrption']    = $wishlist[$i]['description'];
       	  $respo['from_date']     = '2020-09-01';
       	  $respo['to_date']       = '2020-09-05';
       	  $respo['views']         = 0;
       	  $respo['likes']         = 0;
       	  
       	  if($wishlist[$i]['city']!='')
       	  {
       	     $respo['city'] = $wishlist[$i]['city'];
       	  }
       	  else
       	  {
       	     $respo['city'] ='';
       	  }
       	  if($wishlist[$i]['price']!='')
       	  {
       	     $respo['price']         = $wishlist[$i]['price'];
       	  }
       	  else
       	  {
       	     $respo['price'] ='';
       	  }
       	  if($wishlist[$i]['neighbourhood']!='')
       	  {
       	     $respo['neighbourhood']= $wishlist[$i]['neighbourhood'];
       	  }
       	  else
       	  {
       	     $respo['neighbourhood']='';
       	  }
       	  
       	
       	  if(!empty($ad_image))
       	  {
       	  	$respo['image']   = baseurl.'assets/ad_post_images/small_images/'.$ad_image[0]['small_image'];
       	  }
       	  else
       	  {
       	    $respo['image']='';
       	  }
       	  array_push($respo1["ads"], $respo);
       }

       	$respo1["status"] = true; 
	    $respo1["msg"]    = 'ads result';
	    $respo1['errorCode'] = 700;
    }
    else
	{
		$respo1["status"] = false; 
	    $respo1["msg"]    = 'ads is empty';
	    $respo1['errorCode'] = 703;
	}
	echo json_encode($respo1);
}
elseif($post_type=='edit_profile_pic')
{
    $user_id = $_POST['user_id'];
    if($user_id!="")
    {
        if(isset($_FILES['file']) && !empty($_FILES['file']))
        {
        	$name = $_FILES['file']['name'];
        	$size = $_FILES['file']['size'];
        	$file_type = $_FILES['file']['type'];
        	$tmp_name = $_FILES['file']['tmp_name'];
        
        	if(($file_type == "image/gif") || ($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png"))
        	{
        		$file_name = rand(1000,9999).'_'.time().'_'.$name;
        		if(move_uploaded_file($tmp_name, '../../assets/user_profile/'.$file_name))
        		{
        		  $get_attach = $common_model->fetch_user_details($user_id);
        		  if($get_attach[0]['attachment']!="")
        		  {
        		  	if(file_exists('../../assets/user_profile/'.$get_attach[0]['attachment']))
        		  	{
        		  		unlink('../../assets/user_profile/'.$get_attach[0]['attachment']);
        		  	}
        		  }
        		  
        
        		  $updatestatus = $common_model->update_profile_pic($file_name,$user_id);
        		  if($updatestatus)
        		  {
        		  	$errocode = $dr->getOK();
        		    $msg = baseurl.'assets/user_profile/'.$file_name;
        		    $status = true;
        		    $res = '';
        		  }
        		}
        	}
        	else
        	{
        		$errocode = $dr->getOK();
        		$msg = 'Invalid image type';
        		$status = false;
        		$res = '';
        	}
        }
    }
    else
    {
        $errocode = $dr->getOK();
        $msg = 'user id should not empty';
        $status = false;
        $res = '';
    }

	$dr->setErrorCode($errocode);
	$dr->setMsg($msg);
	$dr->setStatus($status);
	//$dr->setCustomRsp('published_ads', $published_ads);
	$dr->setCustomRsp('api_token', $api_token);
	echo $dr->getResponse();
}
elseif($post_type=='delete_profile_pic')
{
    $user_id = $json_decode->user_id;
    if($user_id!="")
    { 
    	$get_attach = $common_model->fetch_user_details($user_id);
    	if($get_attach[0]['attachment']!="")
    	{
    		if(file_exists('../../assets/user_profile/'.$get_attach[0]['attachment']))
    		{
    			unlink('../../assets/user_profile/'.$get_attach[0]['attachment']);
    		}
    	}
    	$delete_pic = $common_model->delete_user_pic($user_id);
    	if($delete_pic)
    	{
    		$errocode = $dr->getOK();
            $msg = 'Profile pic removed successfully';
            $status = true;
            $res = '';
    	}
    }
    else
    {
        $errocode = $dr->getOK();
        $msg = 'user id should not empty';
        $status = false;
        $res = '';
    }
    
    $dr->setErrorCode($errocode);
	$dr->setMsg($msg);
	$dr->setStatus($status);
	//$dr->setCustomRsp('published_ads', $published_ads);
	$dr->setCustomRsp('api_token', $api_token);
	echo $dr->getResponse();
}
elseif($post_type=='adpost_update')
{
    $user_id=$json_decode->user_id;
    $cat_id=$json_decode->category_id;
    $sub_cat=$json_decode->sub_cat_id;
    $title=$json_decode->title;
    $description=$json_decode->description;
    $city_id=$json_decode->city_id;
    $neighbourhood=$json_decode->neighbourhood;
    $contact=$json_decode->contact_name;
    $mobile=$json_decode->mobile_no;
    $price=$json_decode->price;
    
    $ad_id = $json_decode->ad_id;
    if($user_id!='' && $cat_id!='' && $title!='' && $description!='' && $ad_id!='')
    {
        //common fields
        $common_model->title     = $title;
        $common_model->desc      = $description;
        $common_model->city      = $city_id;
        $common_model->neighbourhood = $neighbourhood;
        $common_model->name      = $contact;
        $common_model->mobile    = $mobile;
        $common_model->category  = $cat_id;
        $common_model->sub_cat   = $sub_cat;
        $common_model->userid    = $user_id;
        $common_model->ad_code   = rand(1000,999999);
        $common_model->price     = $price; 
        
        //vehicle fields
         $common_model->brand_id  = $json_decode->brand_id;
         $common_model->model     = $json_decode->model;
         $common_model->variants  = $json_decode->variants;
         $common_model->year      = $json_decode->year;
         $common_model->transmission = $json_decode->transmission;
         $common_model->steering     = $json_decode->steering;
         $common_model->fuel         = $json_decode->fuel;
         $common_model->km           = $json_decode->km;
             
        //job fields
        $common_model->salary_period = $json_decode->salary_period;
        $common_model->position_type = $json_decode->position_type;
        $common_model->salary_from   = $json_decode->salary_from;
        $common_model->salary_to     = $json_decode->salary_to;
        
        $common_model->add_id = $ad_id;
        
        $insert_id=$common_model->add_post();
        $breadth=$json_decode->breadth;
        $length=$json_decode->length;
        if($ad_id!='' && $breadth!='' && $length!='')
        {
        $common_model->breadth       = $json_decode->breadth;
        $common_model->length        = $json_decode->length;
        $common_model->area          = $json_decode->area;
        $common_model->facing        = $json_decode->facing;
        $common_model->listed_by     = $json_decode->listed_by;
        $common_model->type          = $json_decode->apartment_type;
        $common_model->rooms         = $json_decode->rooms;
        $common_model->bathrooms     = $json_decode->bathrooms;
        $common_model->construction_status = $json_decode->construction_status;
        $common_model->furnished     = $json_decode->furnished;
        $common_model->car_parking   = $json_decode->car_parking;
        $common_model->add_post_id   = $ad_id;
        $insert_id=$common_model->property_update();
        }
        $respo1["status"] = true; 
 	    $respo1["msg"]    = 'successfully updated';
 	    $respo1['errorCode'] = 700;
    }
    else
    {
        $respo1["status"] = false; 
	    $respo1["msg"]    = 'Send All Mandatory Fields';
	    $respo1['errorCode'] = 703;
	}
	echo json_encode($respo1);
}
elseif($post_type=='change_password')
{
    $user_id = $json_decode->user_id;
    $old_password = $json_decode->old_password;
    $new_password = $json_decode->new_password;
    
    if($user_id!="" && $old_password!="" && $new_password!="")
    {
        $check_old_password = $common_model->check_old_passowrd($user_id,$old_password);
        
        if(count($check_old_password)>0)
        {
            $update_password = $common_model->update_passowrd($user_id,$new_password);
            
            if($update_password)
            {
                $respo1["status"] = true; 
 	            $respo1["msg"]    = 'password updated successfully';
 	            $respo1['errorCode'] = 700;
            }
        }
        else
        {
            $respo1["status"] = false; 
	        $respo1["msg"]    = 'old password is incorrect';
	        $respo1['errorCode'] = 703;
        }
    }
    else
    {
        $respo1["status"] = false; 
	    $respo1["msg"]    = 'Send All Mandatory Fields';
	    $respo1['errorCode'] = 703;
    }
    echo json_encode($respo1);
}
elseif($post_type=='connect_social')
{
    $user_id = $json_decode->user_id;
    $flag    = $json_decode->flag;
    $id      = $json_decode->id;
    $email   = $json_decode->email;
    
    if($user_id!='' && $flag!='' && $id!='')
    {
        $check_user_exist = $common_model->check_user_exist($user_id);
        
        if(count($check_user_exist)>0)
        {
            if($flag=='fb')
            {
                $update_social_id = $common_model->update_social_id('fb_id',$id,$user_id,$email);
            }
            elseif($flag=='gplus')
            {
                $update_social_id = $common_model->update_social_id('gplus_id',$id,$user_id,$email);
            }
            
            if($update_social_id)
            {
                $respo1["status"] = true; 
	              $respo1["msg"]    = $flag.' connected';
	              $respo1['errorCode'] = 700;
            }
        }
        else
        {
            $respo1["status"] = false; 
	          $respo1["msg"]    = 'Invalid user id';
	          $respo1['errorCode'] = 703;
        }
    }
    else
    {
        $respo1["status"] = false; 
	      $respo1["msg"]    = 'Send All Mandatory Fields';
	      $respo1['errorCode'] = 703;
    }
    echo json_encode($respo1);
}
elseif($post_type=='chat_list')
{
    $user_id = $json_decode->user_id;
    $flag    = $json_decode->flag;
    if($user_id!='')
    {
        $result = $common_model->fetch_chat_users($user_id);
        echo json_encode($result);
    }
    else
    {
        $respo1["chat_users"] = array();
        $respo1["status"] = false; 
	      $respo1["msg"]    = 'Send All Mandatory Fields';
	      $respo1['errorCode'] = 703;
	      echo json_encode($respo1);
    }
}
elseif($post_type=='chat_info')
{
    $user_id = $json_decode->user_id;
    $to_user_id = $json_decode->to_user_id;
    $flag    = $json_decode->flag;
    $pg      = $json_decode->page;
    if($pg=='0' || $pg=='')
    {
        $pg=0;
    }
    if($user_id!='' && $to_user_id!='')
    {
        $result = $common_model->fetch_chat_data($to_user_id,$user_id,$pg);
        echo json_encode($result);
    }
    else
    {
        $respo1["chat_info"] = array();
        $respo1["status"] = false; 
	      $respo1["msg"]    = 'Send All Mandatory Fields';
	      $respo1['errorCode'] = 703;
	      echo json_encode($respo1);
    }
}
else if($post_type=='chat_insert')
{
    $user_id = $_POST['user_id'];
    $to_user_id = $_POST['to_user_id'];
    $msg    = $_POST['message'];
    
    if($user_id!='' && $to_user_id!='')
    {
        $small_filename='';
        if(isset($_FILES['image']) && !empty($_FILES['image']['name']))
        {
            
                $allowed_extensions = array("image/png", "image/jpg", "image/jpeg");
     			if (!in_array($_FILES["image"]["type"], $allowed_extensions)) 
     			{
     			} 
     			else 
     			{
     				$fname = $_FILES['image']['name'];
     				$smallUploadDir = "../../assets/user_chat/";
     				$rand = rand(10, 9999);
     				$filename1 = explode('.', $fname);
     				$small_filename = 'file_' . $rand . time() . '.' . $filename1[1];
    
     				$image_type = $_FILES["image"]["type"];
     				$smalladd = $smallUploadDir . "$small_filename";
     				copy($_FILES['image']['tmp_name'], $smalladd);
     			}
        }
        $result = $common_model->chat_insert($user_id,$to_user_id,$msg,$small_filename);
        echo json_encode($result);
    }
    else
    {
        $respo1["chat_info"] = array();
        $respo1["status"] = false; 
	      $respo1["msg"]    = 'Send All Mandatory Fields';
	      $respo1['errorCode'] = 703;
	      echo json_encode($respo1);
    }
}
elseif($post_type=='search_result')
{
	$keyword     = $json_decode->keyword;
    $user_id    = $json_decode->user_id;
    
    $ad_data = $common_model->fetch_search_products($keyword);
    $respo1["ad_data"] = array();
    if(!empty($ad_data))
    {
       
       for($i=0;$i<count($ad_data);$i++)
       {
          $respo = array();
          $adid=$ad_data[$i]['ad_id'];
          $isadded=false;
          if($user_id!='')
          {
          $isadded=$common_model->isaddedtowishlist($user_id,$adid);
          }
          $ad_image = $common_model->fetch_ad_image($ad_data[$i]['ad_id']);

       	  $respo['ad_id']         = $ad_data[$i]['ad_id'];
       	  $respo['title']         = $ad_data[$i]['title'];
       	  $respo['price']         = $ad_data[$i]['price'];
       	  $respo['neighbourhood'] = $ad_data[$i]['neighbourhood'];
       	  $respo['city']          = $ad_data[$i]['city'];
       	  $respo['ad_code']       = $ad_data[$i]['ad_code'];
       	  $respo['user_name']     = $ad_data[$i]['name'];
       	  $respo['user_email']    = $ad_data[$i]['email'];
       	  $respo['user_mobile']   = $ad_data[$i]['mobile'];

       	  if($ad_data[$i]['state_name']=='')
       	  {
       	  	$respo['state']   = '';
       	  }
       	  else
       	  {
       	  	$respo['state']   = $ad_data[$i]['state_name'];
       	  }

       	  if(!empty($ad_image))
       	  {
       	  	$respo['image']   = baseurl.'assets/ad_post_images/small_images/'.$ad_image[0]['small_image'];
       	  }
       	  else
       	  {
       	    $respo['image']='';
       	  }
       	  if($isadded==true)
       	  {
       	      $respo['iswishlist']=true;
       	  }
       	  else
       	  {
       	      $respo['iswishlist']=false;
       	  }
       	  array_push($respo1["ad_data"], $respo);
       }

        $respo1["status"] = true; 
	    $respo1["msg"]    = 'ads data found';
	    $respo1['errorCode'] = 700;
    }
    else
	{
		  $respo1["status"] = false; 
	    $respo1["msg"]    = 'ads data not found';
	    $respo1['errorCode'] = 703;
	}

	echo json_encode($respo1);
}
}
else
{
      $respo1["status"] = false; 
      $respo1["msg"]    = 'Send All Mandatory Fields.';
      $respo1['errorCode'] = 703;
}
?>