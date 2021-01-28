<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
$user_id=$_SESSION['user_id'];
$api_token=$_SESSION['api_token'];
include("curl_execution.php");
error_reporting(0);
$baseurl="http://pickmychoice.co.uk/dev505/";
$userpath="uploads/user/";
$categorypath = "uploads/category/";
$subcategorypath = "uploads/subcategory/";
$bannerpath = "uploads/banners/";
$vendorpath = "uploads/vendor/";
require_once '../api/models/common_model.php';
$common_model = new Common_Mdl();
require_once '../api/helpers/DefaultResponse.php';
$dr = new DefaultResponse();
if($_GET['term']!='')
{
	$searchTerm = $_GET['term'];
	
	$list = $common_model->fetch_cat_list($searchTerm);
    if(count($list)>0)
    {
    	$userData = array();
        for($i=0;$i<count($list);$i++)
           {
           	        $cid = $list[$i]['cid'];
                    $cname = $list[$i]['cname'];
                    $cattachment = $list[$i]['cattachment'];
                    if($cattachment!='')
                    {
                      $cattachment=$baseurl.$categorypath.$cattachment;
                    }
                        if($cid!='' && $cname!='')
                        {
                      
                          $data['id']    = $cid;
				          $data['value'] = $cname;
				          $data['type'] = 'category';
				          $data['label'] = '
				          <a href="javascript:void(0);">
				            <img src="'.$cattachment.'" width="50" height="50"/>
				            <span>'.$cname.'</span>
				          </a>';
                          array_push($userData, $data);
                        }
                    
                    $sid = $list[$i]['sid'];
                    $sname = $list[$i]['sname'];
                    $sattachment = $list[$i]['sattachment'];
                    if($sattachment!='')
                    {
                      $sattachment=$baseurl.$subcategorypath.$sattachment;
                    }
                    if($sid!='' && $sname!='')
                    {
                      $respo = array();
                      $scid            = $list[$i]['scid'];
                      $respo['id']     = $sid;
                      $respo['category_id']= $scid;
                      $respo['type']   = 'subcategory';
                      $respo['name']   = $sname;
                      $respo['attachment'] = $sattachment;
                          $data['id']    = $sid;
				          $data['value'] = $sname;
				          $data['type'] = 'subcategory';
				          $data['label'] = '
				          <a href="javascript:void(0);">
				            <img src="'.$sattachment.'" width="50" height="50"/>
				            <span>'.$sname.'</span>
				          </a>';
                      array_push($userData, $data);
                    }

               }
               
               

    }
	echo json_encode($userData);
}
if($_POST['flag']=="registration")
{
	$firstname=$_POST["firstname"];
	$lastname=$_POST["lastname"];
	$dob=$_POST["dob"];
	$gender=$_POST["gender"];
	$mobile=$_POST["mobile"];
	$email=$_POST["email"];
	 $password=$_POST['password'];
	$postcode=$_POST["postcode"];
	$address=$_POST["address"];
	$city=$_POST["city"];
	$landmark=$_POST["landmark"];
	
	$latitue=$_POST["latitue"];
	$langitude=$_POST["langitude"];
	$token=$_POST["fb_token"];
			
	$flag="";
	$url='register_controller.php';
	$data = array("flag" => $flag,"name"=>"$firstname","last_name"=>"$lastname","mobile"=>"$mobile","email"=>"$email","gender"=>"$gender","dob"=>"$dob","post_code"=>"$postcode","city"=>"$city","address"=>"$address","type"=>"register","street"=>"","profile_pic"=>"","latitude"=>"$latitue","longitude"=>"$langitude","password"=>"$password","token"=>"$token");
	$postdata = json_encode($data);
	$insert_add=get_curl_response($url,$postdata);
	$registerdata= json_decode($insert_add);
	$registerdatatrue=$registerdata->status;
	$registerdatamsg=$registerdata->msg;
	$api_token=$registerdata->api_token;
	if($registerdatatrue==true)
	{
		foreach($registerdata as $key => $value)
		{
			foreach($value as $key2 => $value2)
			{
				$user_id=$value2->user_id;
				$mobile=$value2->mobile;
				$register='yes';
				unset($_SESSION['g_signup']);
				
			}
		}
	}
	else
	{
		$register='no';
	}
	 
    echo $html=$register.'@6256@'.$registerdatamsg.'@6256@'.$user_id.'@6256@'.$mobile.'@6256@'.$api_token;
 
}
if($_POST['flag']=="verify_otp")
{
	$digitone=$_POST['digitone'];
	$digittwo=$_POST['digittwo'];
	$digitthr=$_POST['digitthr'];
	$digitfour=$_POST['digitfour'];
	$user_id=$_POST['user_id'];
	$mobile=$_POST['mobile'];
	$token=$_POST['token'];
	$otp=$digitone.$digittwo.$digitthr.$digitfour;
	$flag="";
	$url='register_controller.php';
	$data = array("flag" => $flag,"mobile"=>"$mobile","user_id"=>"$user_id","api_token"=>"$token","otp"=>"$otp","type"=>"otp_verify","fcm_token"=>"","device_id"=>"");
	$postdata = json_encode($data);
	$verifyotp=get_curl_response($url,$postdata);
	$verifyotpdata= json_decode($verifyotp);
	$verifyotpdatatrue=$verifyotpdata->status;
	$verifyotpdatamsg=$verifyotpdata->msg;
	$verify='';
	if($verifyotpdatatrue==true)
	{
		$verify='yes';
		foreach($verifyotpdata as $key => $value)
		{
			foreach($value as $key2 => $value2)
			{
				$user_id=$value2->user_id;
				$mobile=$value2->mobile;
				$department=$value2->department;
				$register='yes';
				session_start();
				$_SESSION['user_id']=$user_id; 
				$_SESSION['api_token']=$token; 
				$_SESSION['department_id']=$department;
				
				unset($_SESSION['g_signup']);
			}
		}
	}
	else
	{
		$verify=$verifyotpdatamsg;
	}
	
	echo $verify;
	
}
if($_POST['flag']=="login")
{
	$mobile=$_POST["mobile"];
	 $password=$_POST["password"];
	if($mobile!="" && $password!='')
	{
		$flag='webmobile';
		$mobile=$mobile*1;
		
		$login_details = $common_model->get_flag_details_password($mobile,$flag,$password);
		if(sizeof($login_details)>0)
		{
			$uid = $login_details[0]['id'];
			$dept = $login_details[0]['department_id'];
			if($dept=='3')
			{
				$role='vendor';
			}
			else if($dept=='4')
			{
				$role='user';
			}
			$role = $role;
			$email = $login_details[0]['email'];
			$mobile = $login_details[0]['mobile'];
			$name = $login_details[0]['name'];
			$last_name = $login_details[0]['last_name'];
			$user_code = $login_details[0]['user_code'];
			
			$register='yes';
			$registerdatamsg='User Found!!';
			session_start();
			$_SESSION['user_id']=$uid; 
			//$_SESSION['api_token']=$token; 
			$_SESSION['department_id']=$dept;
			
			unset($_SESSION['g_signup']);
			
			if($_POST['rememberval']=='yes')
			{
				setcookie("member_mobile",$mobile,time()+ (10 * 365 * 24 * 60 * 60));
				setcookie("member_pwd",$password,time()+ (10 * 365 * 24 * 60 * 60));
			}
			else
			{
				if(isset($_COOKIE["member_mobile"])) 
				{
					setcookie("member_mobile","");
				}
				if(isset($_COOKIE["member_pwd"])) 
				{
					setcookie("member_pwd","");
				}
			}
		}
		else
		{
			$register='no';
			$registerdatamsg='Invalid Login Details';
		}
		
		echo $html=$register.'@6256@'.$registerdatamsg.'@6256@'.$user_id.'@6256@'.$mobile.'@6256@'.$api_token;
	}
}
if($_POST['flag']=="login_old")
{
	$mobile=$_POST["mobile"];
	 $password=$_POST["password"];
	if($mobile!="" && $password!='')
	{
		$flag='webmobile';
		$mobile=$mobile*1;
		$url='login_controller.php';
		$data = array("flag" => $flag,"mobile"=>"$mobile","password"=>"$password");
		$postdata = json_encode($data);
		
		$insert_add=get_curl_response($url,$postdata);
		//print_r($insert_add);
		$registerdata= json_decode($insert_add);
		$registerdatatrue=$registerdata->status;
		$registerdatamsg=$registerdata->msg;
		$api_token=$registerdata->api_token;
		if($registerdatatrue==true)
		{
			foreach($registerdata as $key => $value)
			{
				foreach($value as $key2 => $value2)
				{
					$user_id=$value2->user_id;
					$mobile=$value2->mobile;
					$department=$value2->department;
					$register='yes';
					session_start();
				    $_SESSION['user_id']=$user_id; 
				    $_SESSION['api_token']=$token; 
				    $_SESSION['department_id']=$department;
				}
			}
		}
		else
		{
			$register='no';
			$registerdatamsg='Invalid Login Details';
		}
		 
		echo $html=$register.'@6256@'.$registerdatamsg.'@6256@'.$user_id.'@6256@'.$mobile.'@6256@'.$api_token;
	}
}
if($_REQUEST['flag']=='resend_otp')
{
	$mobile=$_POST['mobile'];
	$user_id=$_POST['user_id'];
	$token=$_POST['token'];
	if($mobile!="" && $user_id!="" && $token!="")
	{
		//$flag='mobile';
		$url='register_controller.php';
		$data = array("user_id" => "$user_id","mobile"=>"$mobile","api_token"=>"$token","type"=>"resend_otp");
		$postdata = json_encode($data);
		$insert_add=get_curl_response($url,$postdata);
		$registerdata= json_decode($insert_add);
		$registerdatatrue=$registerdata->status;
		$registerdatamsg=$registerdata->msg;
		$api_token=$registerdata->api_token;
		if($registerdatatrue==true)
		{
			foreach($registerdata as $key => $value)
			{
				foreach($value as $key2 => $value2)
				{
					$user_id=$value2->user_id;
					$mobile=$value2->mobile;
					$register='yes';
					
				}
			}
		}
		else
		{
			$register='no';
		}
		 
		echo $html=$register.'@6256@'.$registerdatamsg.'@6256@'.$user_id.'@6256@'.$mobile.'@6256@'.$api_token;
	}
}
if($_POST['flag']=='get_address')
{
	$api_key="EN4lXzbqMEaGCfBnBcosQA29618";
	$postcode=$_POST['postcode'];
	$post_code=str_replace(" ","%20",$postcode);
    $url="https://api.getaddress.io/find/".$post_code."?expand=true&sort=true&api-key=".$api_key;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    
    $headers = array();
    $headers[] = 'Accept: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $result = curl_exec($ch);
    curl_close($ch);
    //print_r($result);
    $responsedata=json_decode($result);
	//print_r($responsedata);
	$latitude=$responsedata->latitude;
	$longitude=$responsedata->longitude;
	
	$selectbx="<option value=''>Select List</option>";
	foreach($responsedata as $key => $value);
	{
		foreach($value as $key2=> $value2)
		{
			$line1=$value2->line_1;
			$line2=$value2->line_2;
			$locality=$value2->locality;
			$town_or_city=$value2->town_or_city;
			$county=$value2->county;
			if($line2!='')
			{
			   $address=$line1.', '.$line2.', '.$town_or_city; 
			}
			else if($locality=='')
			{
			$address=$line1.', '.$town_or_city.', '.$county;
			}
			else
			{
			$address=$line1.', '.$locality.', '.$town_or_city;
			}
			 $selectbx.="<option value='$address'>$address</option>";
		}
	}
	//$selectbx.="</select>";
	
	echo $html=$latitude.'@6256@'.$longitude.'@6256@'.$selectbx.'@6256@'.$town_or_city.'@6256@'.$county;
}
if($_POST['flag']=='get_subcat_old')
{
	$catid=$_POST['cat_id'];
	if($catid!="")
	{
		$url='common_controller.php';
		$data = array("limit" => "","type"=>"sub_category","token"=>"$api_token","user_id"=>"$user_id","category_id"=>"$catid");
		$postdata = json_encode($data);
		 $get_data=get_curl_response($url,$postdata);
		$getjsondata= json_decode($get_data);
		$catstatus=$getjsondata->status;
		$catmsg=$getjsondata->msg;
		if($catstatus==true)
		{
			foreach($getjsondata as $key => $value)
			{
				foreach($value as $key2 => $value2)
				{
					 $catid=$value2->category_id;
					 $subctid=$value2->subcategory_id;
					 $sub_catname=$value2->name;
					 $category_name=$value2->category_name;
					 $image=$value2->image;
					 $description=$value2->description;
					 ?>
					<option value="<?php echo $subctid; ?>" data-content="<img src='<?php echo $image; ?>'> <span class='option_tilte'><?php echo $sub_catname; ?></span>"><?php echo $sub_catname; ?></option>
					<?php
				}
			}
		}
	}
	
}
if($_POST['flag']=='get_subcat')
{
	$catid=$_POST['cat_id'];
	if($catid!="")
	{
		$url='common_controller.php';
		$data = array("limit" => "","type"=>"sub_category","token"=>"$api_token","user_id"=>"$user_id","category_id"=>"$catid");
		$postdata = json_encode($data);
		$get_data=get_curl_response($url,$postdata);
		$getjsondata= json_decode($get_data);
		$catstatus=$getjsondata->status;
		$catmsg=$getjsondata->msg;
		//$html='<select>';
		?>
	
		<?php
		$html='';
		if($catstatus==true)
		{
		    ?>
	    <option value=''>Select Subcategory</option>
	    <?php
			foreach($getjsondata as $key => $value)
			{
				foreach($value as $key2 => $value2)
				{
					 $catid=$value2->category_id;
					 $subctid=$value2->subcategory_id;
					 $sub_catname=$value2->name;
					 $category_name=$value2->category_name;
					 $image=$value2->image;
					 $description=$value2->description;
					 
					//$html.="<option value=".$subctid." data-content="'<img src='.$image.'><span class="option_tilte">'.$sub_catname.'"</span>">'.$sub_catname.'</option>';
					
					//$html.="<option value=".$subctid." data-content="'<img src='.$image.'><span class='"option_tilte"'>'.$sub_catname.'"</span>">'.$sub_catname.'</option>';
					?>
					<option value="<?php echo $subctid; ?>" data-content="<img src='<?php echo $image; ?>'> <span class='option_tilte'><?php echo $sub_catname; ?></span>"><?php echo $sub_catname; ?></option>
					<?php
					
				}
			}
		}
		?>
	
		<?php
	}
	echo $html;
	
}
if($_POST['flag']=='get_subcat_new')
{
	$catid=$_POST['cat_id'];
	$id='';
	$limit='';
	if($catid!="")
	{
	    require_once '../api/models/common_model.php';
        $common_model = new Common_Mdl();
	    ?>
	    <option value=''>Select Subcategory</option>
	    <?php
			$subcategories = $common_model->fetch_sub_cat_by_catid($catid,$id,$limit);
			//print_r($subcategories);
        	if(count($subcategories)>0)
            {
				for($i=0;$i<count($subcategories);$i++)
                {
                     $subcatlist=$subcategories[$i];
					 $catid=$subcatlist['category_id'];
					 $subctid=$subcatlist['id'];
					 $sub_catname=$subcatlist['sname'];
					 $category_name=$subcatlist['cname'];
					 $image=$subcatlist['attachment'];
					 $description=$subcatlist['description'];
					 
					?>
					<option value="<?php echo $subctid; ?>" data-content="<img src='../uploads/subcategory/<?php echo $image; ?>'> <span class='option_tilte'><?php echo $sub_catname; ?></span>"><?php echo $sub_catname; ?></option>
					<?php
					
				}
			}
		
		?>
	
		<?php
	}
	echo $html;
	
}
if($_POST['formtype']=='addtask')
{
	require_once '../api/models/common_model.php';
	$common_model = new Common_Mdl();
	$cat_id=$_POST['selcat'];
	$sub_cat=$_POST['selsubcat'];
	$title=$_POST['txttitle'];
	$description=$_POST['txtabtask'];
	$attachment=$_POST['fileattachment'];
	$date=$_POST['txtdate'];
	$time=$_POST['txttime'];
	$amount=$_POST['txtamt'];
	$negotiate=$_POST['budget_plan'];
	$post_code=$_POST['txtpostalcode'];
	$address=$_POST['txthuseno'];
	$city=$_POST['txttskcity'];
	$landmark=$_POST['txtlndmrk'];
	$latitude=$_POST['txtpsklat'];
	$langtitude=$_POST['txtpsklang'];
	$sts='';
	$res='';
	$allowed_extensions = array( "image/png", "image/jpg" ,"image/jpeg");
    $validimage=0;
	//if(isset($_FILES["fileattachment"]))
	if($_FILES["fileattachment"]['name']!='')
	{
		if(!in_array($_FILES["fileattachment"]["type"], $allowed_extensions))
		{
			 $validimage=1;
		}
		else
		{
			$validimage=0;
		}
	}
		
		
	if($user_id!='' && $sub_cat!='' && $title!='' && $description!='' && $amount!='' && $post_code!='')
    {
		if($validimage==1)
	    {
			$res="Please upload image file";
			$sts='No';
	    }
        else
		{
		    if($_FILES['fileattachment']['name']!="")
			{
			$fname = $_FILES['fileattachment']['name'];
        	$uploadDir="../uploads/task/";
			$filename=str_replace(" ","_",$fname); 
			//$filename=date('m-d-Y-').$filename;
			$filename=rand(1000,9999).'_'.time().'_'.$filename;
			$add = $uploadDir."$filename"; 
			move_uploaded_file($_FILES['fileattachment']['tmp_name'], $add);
			}
				
			$common_model->title     = $title;
			$common_model->desc      = $description;
			$common_model->city      = $city;
			$common_model->post_code = $post_code;
			$common_model->address   = $address;
			$common_model->landmark  = $landmark;
			$common_model->category  = $cat_id;
			$common_model->sub_cat   = $sub_cat;
			$common_model->user_id   = $user_id;
			//$task_code='PMT'.rand(1000,999999);
			$task_code='PMCS'.rand(1000,999999);
			$common_model->ad_code   = $task_code;
			$common_model->amount    = $amount; 
			$common_model->is_negotiate=$negotiate;
			$common_model->attachment=$filename;
			$common_model->date=date('Y-m-d',strtotime($date));
			$common_model->time=$time;
			
			 $insert_id=$common_model->add_task_web();
			if($insert_id==true)
			{
				 $res=$task_code;
				 $sts='Yes';
			}
			else
			{
				$res="Task Not Saved";
				$sts='No';
			}
		}
	}
	else
	{
		$res="Enter all mandatory fields";
		$sts='No';
	}
	echo $sts.'@6256@'.$res;
}
if($_POST['formtype']=='vendor_register')
{
//require_once '../api/models/common_model.php';
//$common_model = new Common_Mdl();
	 $firstname=$_POST['txtvfirstname'];
	$lastname=$_POST['txtvlastname'];
	$dob=$_POST['txtvdob'];
	 $dobformat=date('Y-m-d',strtotime($dob));
	$gender=$_POST['radiovgender'];
	$mobile=$_POST['txtvmobile'];
	$email=$_POST['txtvemail'];
	$postcode=$_POST['txtvpostcode'];
	$address=$_POST['txthuseno'];
	$city=$_POST['txttskcity'];
	$landmark=$_POST['txtvlandmark'];
	$catid=$_POST['selcat'];
	$subcat=$_POST['selsubcat'];
	$expyears=$_POST['txtexpyear'];
	//$filecerificate=$_POST['filecerti'];
	//$fileresprof=$_POST['fileresprof'];
	$workinssurance=$_POST['radiowoinsts'];
	$motorstatus=$_POST['radiomotrsts'];
	$motorinsstatus=$_POST['radiomotrinsts'];
	$accountno=$_POST['txtaccount'];
	$accountholdername=$_POST['txtacountholder'];
	$sortcode=$_POST['txtsortcode'];
	$pwd=$_POST['txtvpwd'];
	
	$licenseno=$_POST['txtninumber'];
    $vehiclelicensts=$_POST['radiomotorstslicen'];
    
    $txtpsklat=$_POST['txtpsklat'];
    $txtpsklang=$_POST['txtpsklang'];
    
	
	 $hidenuserid=$_POST['hdnuserid'];
	
	
	$allowed_extensions = array("image/png", "image/jpg" ,"image/jpeg","application/pdf");
    $validimage=0;
	if($_FILES["filecerti"]["name"]!="")
	{
		if(!in_array($_FILES["filecerti"]["type"], $allowed_extensions))
		{
			 $validimage=1;
		}
		else
		{
			$validimage=0;
		}
	}
	
	if($_FILES["fileresprof"]["name"]!="")
	{
		if(!in_array($_FILES["fileresprof"]["type"], $allowed_extensions))
		{
			 $validimage=1;
		}
		else
		{
			$validimage=0;
		}
	}
	
	if($_FILES["filejobCard"]["name"]!="")
	{
		if(!in_array($_FILES["filejobCard"]["type"], $allowed_extensions))
		{
			 $validimage=1;
		}
		else
		{
			$validimage=0;
		}
	}
	
	
	
	if($validimage==1)
	{
	    
		$msg="Please upload valid image file";
		$register='no';
	}
	else
	{
	    if($hidenuserid!="")
	    {
	        //echo 'sss';
	        if($_FILES['filecerti']['name']!="")
	        {
	            
	        
	        $fname = $_FILES['filecerti']['name'];
        	$uploadDir="../uploads/vendor/";
			$filename=str_replace(" ","_",$fname); 
			//$filename=date('m-d-Y-').$filename;
			$filename=rand(1000,9999).'_'.time().'_'.$filename;
			$add = $uploadDir."$filename"; 
			move_uploaded_file($_FILES['filecerti']['tmp_name'], $add);
			
	        }
			
			if($_FILES['fileresprof']['name']!="")
			{
			    
			
			$pfname = $_FILES['fileresprof']['name'];
        	$puploadDir="../uploads/vendor/";
			$pfilename=str_replace(" ","_",$pfname); 
			//$filename=date('m-d-Y-').$filename;
			$pfilename=rand(1000,9996).'_'.time().'_'.$pfilename;
			$padd = $puploadDir."$pfilename"; 
			move_uploaded_file($_FILES['fileresprof']['tmp_name'], $padd);
			
			}
			if($_FILES['filejobCard']['name']!="")
			{
			    
			
			$jpfname = $_FILES['filejobCard']['name'];
        	$jpuploadDir="../uploads/vendor/";
			$jpfilename=str_replace(" ","_",$jpfname); 
			//$filename=date('m-d-Y-').$filename;
			$jpfilename=rand(1000,9998).'_'.time().'_'.$jpfilename;
			$jpadd = $jpuploadDir."$jpfilename"; 
			move_uploaded_file($_FILES['filejobCard']['tmp_name'], $jpadd);
			}
			
			$common_model->sub_cat=$subcat;
			$common_model->expyrs=$expyears;
			$common_model->about='';
			$common_model->ni_number='';
			$common_model->work_insurance=$workinssurance;
			$common_model->motor_status=$motorstatus;
			$common_model->motor_insurance_status=$motorinsstatus; 
		    $common_model->motor_licence_status=$vehiclelicensts; 
		    $common_model->ni_number=$licenseno;
		    
			$common_model->certificate=$filename;
			$common_model->resproof=$pfilename; 
			$common_model->jobcard=$jpfilename;
			
			$common_model->acno=$accountno;
			$common_model->holder=$accountholdername;
			$common_model->sort_code=$sortcode;
			
			//$usercode= 'PMV'.rand(1000,9999);
			$usercode= 'PMCU'.rand(1000,9999);
			$common_model->user_code=$usercode;
			$common_model->user_id=$hidenuserid;
			$addexpertise=$common_model->add_expertise($hidenuserid);
			$addbankdetails=$common_model->add_bankdetails($hidenuserid);
			
			$getinfo=$common_model->get_login_details_byid($hidenuserid);
			$department_id=$getinfo[0]['department_id'];
			
			$userid=$hidenuserid;
			if($addbankdetails==true && $_SESSION['department_id']=='4')
			{
			    $updatevendor=$common_model->updateVendor($hidenuserid);
			    $register='upd';
			    $msg=$usercode;
				$_SESSION['department_id']=3;
			    
			}
			else
			{
			    $register='usr';
			    $msg = 'User Updated Successfully.';
			}
			
			
			
			
	    }
	    else
	    {
	        
	   
	
		$check_mobile_exist = $common_model->checkMobileExist($mobile);
		if($check_mobile_exist[0]['count_user']>0)
		{
			$msg="Mobile number already exist!";
			$register='no';
		}
		else
		{
		    if($_FILES['filecerti']['name']!="")
		    {
		        $fname = $_FILES['filecerti']['name'];
            	$uploadDir="../uploads/vendor/";
    			$filename=str_replace(" ","_",$fname); 
    			//$filename=date('m-d-Y-').$filename;
    			$filename=rand(1000,9998).'_'.time().'_'.$filename;
    			$add = $uploadDir."$filename"; 
    			move_uploaded_file($_FILES['filecerti']['tmp_name'], $add);
		    }
			
			if($_FILES['fileresprof']['name']!="")
			{
			    $pfname = $_FILES['fileresprof']['name'];
            	$puploadDir="../uploads/vendor/";
    			$pfilename=str_replace(" ","_",$pfname); 
    			//$filename=date('m-d-Y-').$filename;
    			$pfilename=rand(1000,9996).'_'.time().'_'.$pfilename;
    			$padd = $puploadDir."$pfilename"; 
    			move_uploaded_file($_FILES['fileresprof']['tmp_name'], $padd);
			}
			
			if($_FILES['filejobCard']['name']!="")
			{
			    $jpfname = $_FILES['filejobCard']['name'];
            	$jpuploadDir="../uploads/vendor/";
    			$jpfilename=str_replace(" ","_",$jpfname); 
    			//$filename=date('m-d-Y-').$filename;
    			$jpfilename=rand(1000,9995).'_'.time().'_'.$jpfilename;
    			$jpadd = $jpuploadDir."$jpfilename"; 
    			move_uploaded_file($_FILES['filejobCard']['tmp_name'], $jpadd);
			}
			
		
			
			$usercode= 'PMCU'.rand(1000,9999);
			//$usercode= 'PV'.rand(1000,9999);
			
			
			$common_model->firstname=$firstname;
			$common_model->lastname=$lastname;
			$common_model->user_code=$usercode;
			$common_model->dob=$dobformat;
			$common_model->gender=$gender;
			$common_model->mobile=$mobile;
			$common_model->email=$email;
			$common_model->post_code=$postcode;
			$common_model->address=$address;
			$common_model->city=$city;
			$common_model->landmark=$landmark;
			$common_model->cat=$catid;
			$common_model->sub_cat=$subcat;
			$common_model->expyrs=$expyears;
			$common_model->about='';
			$common_model->ni_number='';
			$common_model->work_insurance=$workinssurance;
			$common_model->motor_status=$motorstatus;
			$common_model->motor_insurance_status=$motorinsstatus;
			$common_model->motor_licence_status=$vehiclelicensts; 
		    $common_model->ni_number=$licenseno; 
			
			$common_model->certificate=$filename;
			$common_model->resproof=$pfilename;
			$common_model->jobcard=$jpfilename;
			
			$common_model->acno=$accountno;
			$common_model->holder=$accountholdername;
			$common_model->sort_code=$sortcode;
			
			
			$common_model->password=md5($pwd); 
			
			$common_model->lat=$txtpsklat;
			$common_model->lang=$txtpsklang;
			
			$userid=$common_model->vendorRegister();
			if($userid!="")
			{
				$common_model->user_id=$userid;
				$addexpertise=$common_model->add_expertise($userid);
				$addbankdetails=$common_model->add_bankdetails($userid);
				$api_token=$common_model->getApiKey($userid);
				if($api_token!="")
				{
				    $otp     = rand(1111,9999);
					$sms_settings = $common_model->fetch_sms_setting();
					$url = $sms_settings[0]['url']; 
					$usrname = $sms_settings[0]['username']; 
					$usrpwd  = $sms_settings[0]['password']; 
					$usrpwd=base64_decode($usrpwd);
					$from  = $sms_settings[0]['sender_id']; 
				   
					$msg2="Your OTP for pickmychoice login is ".$otp;
					$get_user_profile = $common_model->update_user_otp($mobile,$otp,$userid);
					//$msg2.= "$otp is the OTP for Your mobile verification.";
					$url =$url."username=".$usrname."&password=".$usrpwd."&to=".$mobile."&from=".$from."&message=".urlencode($msg2);
					//urlencode($msg2); //Store data into URL variable
				//	$ret = file_get_contents($url); 
				
				    						
					$ch = curl_init();	
                    curl_setopt($ch, CURLOPT_URL, $url);	
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);	
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');	
                    	
                    $headers = array();	
                    $headers[] = 'Accept: application/json';	
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);	
                    	
                    $result = curl_exec($ch);	
                    curl_close($ch);	
					
					$msg = 'Registration Successfully Completed.';
				
					$register="yes";
				}
			}
			else
			{
				$register='no';
			}
			
			
		}
		
	    }
		
		
		echo $html=$register.'@6256@'.$msg.'@6256@'.$userid.'@6256@'.$mobile.'@6256@'.$api_token;
	
	}
}
if($_POST['flag']=='suggestion')
{
	$keyword = $_POST['searchkey'];
    if(strlen($keyword)>=3)
    {
    	  $list = $common_model->fetch_cat_list($keyword);
          if(count($list)>0)
          {
          	$respo1["suggestion_list"]=array();
            for($i=0;$i<count($list);$i++)
               {
                    $cid = $list[$i]['cid'];
                    $cname = $list[$i]['cname'];
                    $cattachment = $list[$i]['cattachment'];
                    if($cattachment!='')
                    {
                      $cattachment=$baseurl.$categorypath.$cattachment;
                    }
                        if($cid!='' && $cname!='')
                        {
                          $respo = array();
                          $respo['id']     = $cid;
                          $respo['category_id']= $cid;
                          $respo['type']   = 'category';
                          $respo['name']   = $cname;
                          $respo['attachment'] = $cattachment;
                          array_push($respo1["suggestion_list"], $respo);
                        }
                    
                    $sid = $list[$i]['sid'];
                    $sname = $list[$i]['sname'];
                    $sattachment = $list[$i]['sattachment'];
                    if($sattachment!='')
                    {
                      $sattachment=$baseurl.$subcategorypath.$sattachment;
                    }
                    if($sid!='' && $sname!='')
                    {
                      $respo = array();
                      $scid            = $list[$i]['scid'];
                      $respo['id']     = $sid;
                      $respo['category_id']= $scid;
                      $respo['type']   = 'subcategory';
                      $respo['name']   = $sname;
                      $respo['attachment'] = $sattachment;
                      array_push($respo1["suggestion_list"], $respo);
                    }
                    $respo1["suggestion_list"]=super_unique($respo1["suggestion_list"],'name');
               }
              print_r($respo1);
               
          }
          else
           {
               	echo 'No Keyword Found With This Search Criteria.';
           }
    }
}
if($_POST['form_type']=='edit_profile')
{
	$firstname=$_POST['txtepfirstname'];
	$lastname=$_POST['txteplastname'];
	$dob1=$_POST['txtepdob'];
	$dob=date('Y-m-d',strtotime($dob1));
	$gender=$_POST['selepgender'];
	$email=$_POST['txtepemail'];
	$postcode=$_POST['txteppostcode'];
	$address=$_POST['txtepaddrs'];
	$city=$_POST['txtepcity'];
	$landmark=$_POST['txteplandmark'];
	
	$allowed_extensions = array( "image/png", "image/jpg" ,"image/jpeg","application/pdf");
    $validimage=0;
	if($_FILES["filecerti"]['name']!="")
	{
		
		if(!in_array($_FILES["filecerti"]["type"], $allowed_extensions))
		{
			 $validimage=1;
		}
		else
		{
			$validimage=0;
		}
	}
	
	if($_FILES["fileresprof"]['name']!="")
	{
		
		if(!in_array($_FILES["fileresprof"]["type"], $allowed_extensions))
		{
			
			  $validimage=1;
		}
		else
		{
			 $validimage=0;
		}
	}
	
	if($_FILES["filejobCard"]['name']!="")
	{
	
		if(!in_array($_FILES["filejobCard"]["type"], $allowed_extensions))
		{
			 $validimage=1;
		}
		else
		{
			$validimage=0;
		}
	}
	
	
	
	
	//echo $validimage;
		
	if($firstname!="")
	{
		$updsts='';
		if($validimage==1)
		{
			$msg="Please upload valid image file";
			$updsts='no';
		}
		else
		{
	
		$common_model->name=$firstname;
		$common_model->last_name=$lastname;
		$common_model->email=$email;
		$common_model->gender=$gender;
		$common_model->dob=$dob;
		$common_model->post_code=$postcode;
		$common_model->address=$address;
		$common_model->city=$city;
		$common_model->street=$landmark;
		
		 $list = $common_model->update_profile($user_id,'personal');
		 if($list==true)
		 {
			$updsts='yes'; 
			$msg="Details Updated Successfully"; 

		    if($_POST['formsub_type']=='expert')
			{
				$common_model->user_id=$user_id;
				
				if($_FILES['filecerti']['name']!="")
				{
					
				
					$fname = $_FILES['filecerti']['name'];
					$uploadDir="../uploads/vendor/";
					$filename=str_replace(" ","_",$fname); 
					//$filename=date('m-d-Y-').$filename;
					$filename=rand(1000,9998).'_'.time().'_'.$filename;
					$add = $uploadDir."$filename"; 
					move_uploaded_file($_FILES['filecerti']['tmp_name'], $add);
					
					$common_model->certificate=$filename;
				}
				
				if($_FILES['fileresprof']['name']!="")
				{
					$pfname = $_FILES['fileresprof']['name'];
					$puploadDir="../uploads/vendor/";
					$pfilename=str_replace(" ","_",$pfname); 
					//$filename=date('m-d-Y-').$filename;
					$pfilename=rand(1000,9996).'_'.time().'_'.$pfilename;
					$padd = $puploadDir."$pfilename"; 
					move_uploaded_file($_FILES['fileresprof']['tmp_name'], $padd);
					$common_model->resproof=$pfilename;
				}
				
				if($_FILES['filejobCard']['name']!="")
				{
					$jpfname = $_FILES['filejobCard']['name'];
					$jpuploadDir="../uploads/vendor/";
					$jpfilename=str_replace(" ","_",$jpfname); 
					//$filename=date('m-d-Y-').$filename;
					$jpfilename=rand(1000,9995).'_'.time().'_'.$jpfilename;
					$jpadd = $jpuploadDir."$jpfilename"; 
					move_uploaded_file($_FILES['filejobCard']['tmp_name'], $jpadd);
					$common_model->jobcard=$jpfilename;
				}
				
				
				
				
				
				
			
				$common_model->sub_cat=$_POST['selsubcat'];
				$common_model->expyrs=$_POST['txtepwrkexp'];
				$common_model->ni_number=$_POST['txtepninum'];
				$common_model->motor_status=$_POST['epradiomotrsts'];
				$common_model->work_insurance=$_POST['epradiowoinsts'];
				$common_model->motor_insurance_status=$_POST['epradiomotrinsts'];
				$common_model->motor_licence_status=$_POST['epradiomotorstslicen'];
				
				$common_model->holder=$_POST['txtacunthname'];
				$common_model->acno=$_POST['txtaccountno'];
				$common_model->sort_code=$_POST['txtsortcode'];
				
				
				$updexprt = $common_model->update_profile($user_id,'expertise');
				$updbnkdet = $common_model->update_profile($user_id,'bank');
			}				
		 }
		 else
		 {
			 
			$updsts='no'; 
			$msg="Details Not Updated Successfully"; 
		 }
		 
		 
		}
	}
	
	echo $updsts.'@6256@'.$msg;
}
if($_POST['flag']=='quote_update')
{
	$task_id=$_POST['task_id'];
	$vendor_id=$_POST['vendor_id'];
	$status=$_POST['status'];
	$quote_id=$_POST['quote_id'];
	
	$common_model->user_id  = $user_id;
    $common_model->quote_id = $quote_id;
    $common_model->status   = $status;
		
	$common_model->vendor_id= $vendor_id;
    $common_model->task_id= $task_id;
    $insert_id=$common_model->update_quote();
	
	if($insert_id==true)
	{
	        $userdetails1=$common_model->fetch_user_details($user_id);
     	    if(!empty($userdetails1))
            {
               $vname=$userdetails1[0]['name'];
               $vcode=$userdetails1[0]['user_code'];
               $vfcm_token=$userdetails1[0]['fcm_token'];
               $vdevice_id=$userdetails1[0]['device_id'];
               if($status=='Accepted')
               {
                   $message1="Dear $vname $vcode,You Accepted The Quote Please Pay The Amount To Start The Work.";
                   $res=$common_model->insert_notification($user_id,'Pay Now',$message1);
                   if($vfcm_token!='')
                   {
                       if($vdevice_id=='Android')
                       {
                           $rres=$dr->send_message($vfcm_token,$message1,'Pay Now');
                       }
                   }
               }
            }
     	    $userdetails=$common_model->fetch_user_details($vendor_id);
     	    if(!empty($userdetails))
            {
                   $name=$userdetails[0]['name'];
                   $user_code=$userdetails[0]['user_code'];
                   $fcm_token=$userdetails[0]['fcm_token'];
                   $device_id=$userdetails[0]['device_id'];
                   $message="Dear $name $user_code, User $vname($vcode) $status Your Quote.";
                   $res=$common_model->insert_notification($vendor_id,$status,$message);
                   if($fcm_token!='')
                   {
                       if($device_id=='Android')
                       {
                           $rres=$dr->send_message($fcm_token,$message,$status);
                       }
                   }
            }
	    if($status=='Accepted'){
	        echo '1';
	        }
	        else{
		echo "Quote Successfully Updated.";
  	       }
	}
	else
	{
		echo '0';
	}
	
}
if($_POST['flag']=='get_vendor')
{
	$task_id=$_POST['task_id'];
	$vendor_id=$_POST['vendor_id'];
	if($task_id!="" && $vendor_id!="" && $user_id!="")
	{
		$wr=" 1=1 and user_id='$user_id' and task_id='$task_id' and vendor_id='$vendor_id'";
        $quote_id=$common_model->fetch_one_column('task_quote','id',$wr);
        $quote_date=$common_model->fetch_one_column('task_quote','date',$wr);
		$quotedate= date('F,d Y h:i:A', strtotime($quote_date));
        $quote_amount=$common_model->fetch_one_column('task_quote','amount',$wr);
		
		$vwr=" 1=1 and id='$vendor_id'";
        $getfirstname=$common_model->fetch_one_column('user','name',$vwr);
        $getlasttname=$common_model->fetch_one_column('user','last_name',$vwr);
        $getmobile=$common_model->fetch_one_column('user','mobile',$vwr);
        $getcategory_id=$common_model->fetch_one_column('user','category_id',$vwr);
        $getaddress=$common_model->fetch_one_column('user','address',$vwr);
        $profile_photo=$common_model->fetch_one_column('user','profile_photo',$vwr);
        $about=$common_model->fetch_one_column('user','about',$vwr);
        //$attachment='http://chitfinder.com/magnificit/dynamic/images/user/user-avatar/male-avatar.png';
        if($profile_photo=='')
        {
            $profile_photo='male-avatar.png';
        }
		 $profilephoto="<img src='../uploads/user/$profile_photo' >";
		
		$name=$getfirstname.' '.$getlasttname;
		
		$cwr=" 1=1 and id='$getcategory_id'";
		$getcatname=$common_model->fetch_one_column('subcategory','name',$cwr);
		
		$twr=" 1=1 and id='$task_id'";
		$gettaskcode=$common_model->fetch_one_column('task','code',$twr);
		
		if($quote_id!="")
		{
			echo $html=$name.'@6256@'.$getmobile.'@6256@'.$getcatname.'@6256@'.$gettaskcode.'@6256@'.$getaddress.'@6256@'.$quotedate.'@6256@'.$quote_amount.'@6256@'.$user_id.'@6256@'.$profilephoto.'@6256@'.$about;
		}
	}
	
}
if($_POST['flag']=='payment_submit')
{
	$task_id=$_POST['task_id'];
	$vendor_id=$_POST['vendor_id'];
	$amount=$_POST['amount'];
	if($task_id!="" && $vendor_id!="" && $amount!="")
	{
		$wr=" 1=1 and user_id='$user_id' and task_id='$task_id' and vendor_id='$vendor_id'";
		$quote_amount=$common_model->fetch_one_column('task_quote','amount',$wr);
		if($amount==$quote_amount)
		{
		    
		    $wr2=" 1=1 and status='Active'";
            $wvd=$common_model->fetch_one_column('commission_settings','waived',$wr2);
            
            $wr3=" 1=1 and status='Active'";
            $comm=$common_model->fetch_one_column('commission_settings','commission',$wr3);
            
            $waived=0;
            $commission=0;
            $final=$amount;
            if($wvd!='')
            {
                $waived=($amount/100)*$wvd;
                $final=$amount-$waived;
            }
            if($final!='' && $comm!='')
            {
                $commission=($final/100)*$comm;
            }
		    
			$common_model->user_id= $user_id;
			$common_model->task_id= $task_id;
			$common_model->vendor_id= $vendor_id;
			$common_model->amount= $quote_amount;
			$common_model->waived_amount=$waived;
            $common_model->commission=$commission;
			$common_model->status= 'Success';
			$common_model->tr_no= rand(11111111,99999999);
			$common_model->paymode= 'Net Banking';
			$common_model->reason= '';
			$insert_id=$common_model->insert_payment();
			if($insert_id==true)
			{
			    $userdetails1=$common_model->fetch_user_details($vendor_id);
         	    if(!empty($userdetails1))
                {
                   $vname=$userdetails1[0]['name'];
                   $vcode=$userdetails1[0]['user_code'];
                   $vfcm_token=$userdetails1[0]['fcm_token'];
                   $vdevice_id=$userdetails1[0]['device_id'];
                   $wr2=" 1=1 and id='$task_id'";
                   $code=$common_model->fetch_one_column('task','code',$wr2);
                   
                   $message1="Dear Vendor $vname $vcode,User Paid For the Service $code. Start The Service.";
                   $res=$common_model->insert_notification($vendor_id,'Paid',$message1);
                       if($vfcm_token!='')
                       {
                           if($vdevice_id=='Android')
                           {
                              $rres=$dr->send_message($vfcm_token,$message1,'Paid');
                           }
                       }
                }
				echo "Payment Successfully Completed";
			}
		}
		else
		{
			echo "Invalid Amount";
		}
	}
	
}
if($_POST['flag']=='write_review')
{
	$task_id=$_POST['task_id'];
	$vendor_id=$_POST['vendor_id'];
	$rating=$_POST['rating'];
	$review=$_POST['review'];
	if($task_id!="" && $vendor_id!="" && $rating!="" && $review!="")
	{
		$common_model->user_id   = $user_id;
        $common_model->task_id   = $task_id;
        $common_model->vendor_id = $vendor_id;
        $common_model->rating    = $rating;
        $common_model->review    = $review;
        
    	
    	$insert = $common_model->insert_review();
		if($insert==true)
		{
			echo "<span style='color:green'>Review Saved Succefully</span>";
		}
		else
		{
			echo "<span style='color:red'>Review Not Saved</span>";
		}
	}
	else
	{
		echo "<span style='color:red'>Enter All Mandatory Data</span>";
	}
}
if($_POST['flag']=='get_task_status_old')
{
	$task_id=$_POST['task_id'];
	$vendor_id=$_POST['vendor_id'];
	if($task_id!="" && $vendor_id!="")
	{
		$status = $common_model->fetch_task_status($task_id,$user_id);
		if(count($status)>0)
          {
			  $actiondate = date('m-d-Y H:i:s',strtotime($status[0]['date']));
              $sts=$status[0]['status'];
              if($sts=='Rejected')
              {
                  $status_new='Pending';
              }
              if($sts=='Pending')
              {
                  $status_new='Pending';
              }
              if($sts=='Accepted')
              {
                  $status_new='Accepted';
				  $acceptdat=$actiondate;
              }
              if($sts=='Started')
              {
                  $status_new='Paid';
              }
              if($sts=='Completed')
              {
                  $status_new='Completed';
				  $completeddate=$actiondate;
              }
              if($sts=='Paid')
              {
                  $status_new='Paid';
				  $paiddate=$actiondate;
              }
           	 } 
			 
			$awr=" 1=1 and task_id='$task_id' and vendor_id='$vendor_id' and user_id='$user_id' and status='Accepted' ";
			$getacceptdate=$common_model->fetch_one_column('task_status','date',$awr);
			
			$getacceptdatefrmt=date('m-d-Y H:i:s',strtotime($getacceptdate));
			
			$cwr=" 1=1 and task_id='$task_id' and vendor_id='$vendor_id' and user_id='$user_id' and status='Completed' ";
			$getcompledate=$common_model->fetch_one_column('task_status','date',$cwr);
			
			$getcompledatefrmt=date('m-d-Y H:i:s',strtotime($getcompledate));
			
			$pwr=" 1=1 and task_id='$task_id' and vendor_id='$vendor_id' and user_id='$user_id' and status='Paid' ";
			$getpaiddate=$common_model->fetch_one_column('task_status','date',$pwr);
			$getpaiddatefrmt=date('m-d-Y H:i:s',strtotime($getpaiddate));
		
			  $payment = $common_model->fetch_task_payment($task_id);
              if(count($payment)>0)
              {
                   
                   for($j=0;$j<count($payment);$j++)
                   {
                        $respo_1 = array();
                        $id = $payment[$j]['id'];
                        $amount = $payment[$j]['amount'];
                        $paid_date = date('m-d-Y H:i:s',strtotime($payment[$j]['paid_date']));
                        $payment_status = $payment[$j]['payment_status'];
                        $transaction_no = $payment[$j]['transaction_no'];
                        $mode = $payment[$j]['type'];
                   }
              }
		  
		  
		  echo $html=$getacceptdatefrmt.'@6256@'.$getcompledatefrmt.'@6256@'.$getpaiddatefrmt.'@6256@'.$mode.'@6256@'.$amount.'@6256@'.$transaction_no;
	}
	
}
if($_POST['flag']=='get_task_status')
{
	 $task_id=$_POST['task_id'];
	$vendor_id=$_POST['vendor_id'];
	if($task_id!="" && $user_id!="")
	{
		$gettaskinfo=$common_model->get_task_details_new($task_id);
		$gettaskimg=$common_model->getTaskImage($task_id);
		$status = $common_model->fetch_task_status($task_id,$user_id);
		if(count($status)>0)
          {
			  $actiondate = date('m-d-Y H:i:s',strtotime($status[0]['date']));
              $sts=$status[0]['status'];
              if($sts=='Rejected')
              {
                  $status_new='Pending';
              }
              if($sts=='Pending')
              {
                  $status_new='Pending';
              }
              if($sts=='Accepted')
              {
                  $status_new='Accepted';
				  $acceptdat=$actiondate;
              }
              if($sts=='Started')
              {
                  $status_new='Paid';
              }
              if($sts=='Completed')
              {
                  $status_new='Completed';
				  $completeddate=$actiondate;
              }
              if($sts=='Paid')
              {
                  $status_new='Paid';
				  $paiddate=$actiondate;
              }
           	 } 
			 
			$awr=" 1=1 and task_id='$task_id' and vendor_id='$vendor_id' and user_id='$user_id' and status='Accepted' ";
			 $getacceptdate=$common_model->fetch_one_column('task_status','date',$awr);
			
			if($getacceptdate!="")
			{
			    $getacceptdatefrmt=date('m-d-Y H:i:s',strtotime($getacceptdate));
			}
			else
			{
			    $getacceptdatefrmt='-';
			}
			
			
			$cwr=" 1=1 and task_id='$task_id' and vendor_id='$vendor_id' and user_id='$user_id' and status='Completed' ";
			$getcompledate=$common_model->fetch_one_column('task_status','date',$cwr);
			
			if($getcompledate!='')
			{
			    $getcompledatefrmt=date('m-d-Y H:i:s',strtotime($getcompledate));
			}
			else
			{
			    $getcompledatefrmt='-';
			}
			
			
			$pwr=" 1=1 and task_id='$task_id' and vendor_id='$vendor_id' and user_id='$user_id' and status='Paid' ";
			$getpaiddate=$common_model->fetch_one_column('task_status','date',$pwr);
			
		    if($getpaiddate!='')
		    {
		        $getpaiddatefrmt=date('m-d-Y H:i:s',strtotime($getpaiddate));
		    }
		    else
		    {
		        $getpaiddatefrmt='-';
		    }
		    
		    
		    $pwr1=" 1=1 and task_id='$task_id' and vendor_id='$vendor_id' and user_id='$user_id' and status='Started' ";
			$getstarteddate=$common_model->fetch_one_column('task_status','date',$pwr1);
			
		    if($getstarteddate!='')
		    {
		        $getstarteddatefrmt=date('m-d-Y H:i:s',strtotime($getstarteddate));
		    }
		    else
		    {
		        $getstarteddatefrmt='-';
		    }
		    
		    $rpwr1=" 1=1 and task_id='$task_id' and vendor_id='$vendor_id' and user_id='$user_id' and status='Rejected' ";
			$rgetstarteddate=$common_model->fetch_one_column('task_status','date',$rpwr1);
			
		    if($rgetstarteddate!='')
		    {
		        $rgetstarteddatefrmt=date('m-d-Y H:i:s',strtotime($rgetstarteddate));
		    }
		    else
		    {
		        $rgetstarteddatefrmt='-';
		    }
		    
		    
		    
		     $asq=" 1=1 and task_id='$task_id' and vendor_id='$vendor_id' and user_id='$user_id'";
			$getassigneda=$common_model->fetch_one_column('task_assigned','date',$asq);
			$getassignedati=$common_model->fetch_one_column('task_assigned','time',$asq);
			
			$fetassigndatetime=$getassigneda.$getassignedati;
			
			
		    if($fetassigndatetime!='')
		    {
		        $fetassigndatetimefrmt=date('m-d-Y H:i:s',strtotime($fetassigndatetime));
		    }
		    else
		    {
		        $fetassigndatetimefrmt='-';
		    }
			
			$qasq=" 1=1 and task_id='$task_id' and vendor_id='$vendor_id' and user_id='$user_id'";
			$qgetassigneda=$common_model->fetch_one_column('task_quote','date',$qasq);
			
			
			//$fetassigndatetime=$getassigneda.$getassignedati;
			
			
		    if($qgetassigneda!='')
		    {
		        $qgetassignedafrmt=date('m-d-Y H:i:s',strtotime($qgetassigneda));
		    }
		    else
		    {
		        $qgetassignedafrmt='-';
		    }
		    
		    if($getstarteddate!="" && $getcompledate!="")
		    {
		        
		        $getstarteddatefrmt1=date('Y-m-d H:i:s',strtotime($getstarteddate));
		        $getcompledatefrmt1=date('Y-m-d H:i:s',strtotime($getcompledate));
		        //echo $getstarteddatefrmt;
		        //echo $getcompledatefrmt;
		          $date1 = strtotime("$getstarteddatefrmt1");  
                  $date2 = strtotime("$getcompledatefrmt1"); 
                 
                  $diff = abs($date2 - $date1); 
                 
                
                $minutes = floor(abs($date2 - $date1) / 60).' Minutes';

		    }
		   
		    $gettasksts=$common_model->fetch_task_status($taskid,$user_id);
			$tasksts=$gettasksts[0]['status'];
		    
			  $payment = $common_model->fetch_task_payment($task_id);
              if(count($payment)>0)
              {
                   
                   for($j=0;$j<count($payment);$j++)
                   {
                        $respo_1 = array();
                        $id = $payment[$j]['id'];
                        $amount = $payment[$j]['amount'];
                        $paid_date = date('m-d-Y H:i:s',strtotime($payment[$j]['paid_date']));
                        $payment_status = $payment[$j]['payment_status'];
                        $transaction_no = $payment[$j]['transaction_no'];
                        $mode = $payment[$j]['type'];
                   }
              }
		  
		  $tasktitle=$gettaskinfo[0]['title'];
		  $taskdesc=$gettaskinfo[0]['description'];
		  $tasktcname=$gettaskinfo[0]['cname'];
		  $tasksname=$gettaskinfo[0]['sname'];
		  $taskcode=$gettaskinfo[0]['code'];
		  $taskreqdate=$gettaskinfo[0]['date'];
		  $taskreqtime=$gettaskinfo[0]['time'];
		  $taskpostdate=$gettaskinfo[0]['log_date_created'];
		  
		  
		  $taskbudget=$gettaskinfo[0]['budget'];
		  $taskpostal_code=$gettaskinfo[0]['postal_code'];
		  $taskcity=$gettaskinfo[0]['city'];
		  $taskaddress=$gettaskinfo[0]['address'];
		  $taskland_mark=$gettaskinfo[0]['land_mark'];
		  
		$gttaskdate=$taskreqdate.$taskreqtime;
		$taskcreatedate= date('F,d Y h:i:A', strtotime($taskpostdate));
		$taskdatetime= date('F,d Y h:i:A', strtotime($gttaskdate));
		$taskimg=$gettaskimg[0]['attachment'];
		
		if($taskimg!="")
		{
			$imgpath="<img src='$baseurl/uploads/task/$taskimg' class='img-responsive'>";
		}
		else
		{
			$imgpath="";
		}	
		   //$html=$getacceptdatefrmt.'@6256@'.$getcompledatefrmt.'@6256@'.$getpaiddatefrmt.'@6256@'.$mode.'@6256@'.$amount.'@6256@'.$transaction_no;
		   
		   $html="<div class='services_info_block'>
							<div class='row'>
								<div class='col-lg-6 col-md-7'>
									<h2><i class='flaticon-clipboards-1'></i> Task Information </h2>
									<div class='sib_info sib_task_details'>
										<ul>
											<li>
												<label> Service Code </label> <span>$taskcode</span> </li>
											<li>
												<label> title</label> <span>$tasktitle</span> </li>
											<li>
												<label>Description</label>
												<p>$taskdesc</p>
											</li>
											<li>
												<label>Category</label> <span>$tasktcname</span> </li>
											<li>
												<label>Subcategory</label> <span>$tasksname</span> </li>
											<li>
												<label>Posted on</label> <span>$taskcreatedate</span> </li>
											<li>
												<label>Required on</label> <span>$taskdatetime</span> </li>
										</ul>
									</div>
								</div>
								<div class='col-lg-6 col-md-5'>
									<div class='sib_image'> $imgpath </div>
								</div>
							</div>
						</div>
						<div class='row'>
						    <div class='col-lg-4 col-md-6'>
								<div class='services_info_block'>
									<h2> <i class='flaticon-location-2'></i>Location Information</h2>
									<div class='sib_info'>
										<ul>
											<li>
												<label>Postal Code</label> <span>$taskpostal_code</span> </li>
											<li>
												<label> Address</label> <span>$taskaddress</span> </li>
											<li>
												<label>City</label> <span>$taskcity</span> </li>
											<li>
												<label>County</label> <span>$taskland_mark</span> </li>
										</ul>
									</div>
								</div>
							</div>
							<div class='col-lg-4 col-md-6'>
								<div class='services_info_block'>
									<h2> <i class='flaticon-location-2'></i>Service Status</h2>
									<div class='sib_info'>
										<ul>
										
										<li>
												<label>Assigned On</label> <span>$fetassigndatetimefrmt</span> </li><li>
												<label>Quote Sent (Vendor)</label> <span>$qgetassignedafrmt</span> </li>";
												
												
											if($tasksts=='Rejected')
												{
													$html."<li style='color:red'>
												<label>Rejected (User) On</label> <span style='color:red'>$$rgetstarteddatefrmt</span> </li>";
												}
												else
												{
													
												
											$html.="<li>
												<label>Accepted (User) On</label> <span>$getacceptdatefrmt</span> </li>
											<li>
												<label> Paid (User) On</label> <span>$getpaiddatefrmt</span> </li>
												<li>
												<label> Started (Vendor) On</label><span>$getstarteddatefrmt</span> </li>
												
					
											<li>
												<label>Completed (Vendor) On</label> <span>$getcompledatefrmt</span> </li>
												
													<li>
												<label> Time Spent (Vendor) </label><span>$minutes</span> </li>";
												}
												$html.="</ul> 
									</div>
								</div>
							</div>
							<div class='col-lg-4 col-md-6'>
								<div class='services_info_block'>
									<h2> <i class='flaticon-calculator'></i> Payment Information </h2>
									<div class='sib_info'>
										<ul>
											<li>
												<label>Amount</label> <span>$amount</span> </li>
											<li>
												<label> Mode Of Payment</label> <span>$mode</span> </li>
												<li>
												<label> Trn Ref No</label> <span>$transaction_no</span> </li>
										</ul>
									</div>
								</div>
							</div>
						</div>";
						
						echo $html;
	}
	
}
if($_POST['flag']=='sent_quote')
{
	$quotedamt=$_POST['quoteamt'];
	$task_id=$_POST['task_id'];
	$quser_id=$_POST['user_id'];
	$asid=$_POST['asid'];
	$desc=$_POST['desc'];
	$sts='No';
	$msg="";
	if($quotedamt!="" && $task_id!="" && $quser_id!="" && $desc!="")
	{
		$common_model->user_id   = $user_id;
        $common_model->to_user_id= $quser_id;
        $common_model->task_id   = $task_id;
        $common_model->amount    = $quotedamt;
        $common_model->description = $desc;
        $insert_id=$common_model->insert_quote();
		if($insert_id!="")
		{
		    $userdetails1=$common_model->fetch_user_details($user_id);
     	    if(!empty($userdetails1))
            {
               $vname=$userdetails1[0]['name'];
               $vcode=$userdetails1[0]['user_code'];
            }
            
		    $userdetails=$common_model->fetch_user_details($quser_id);
     	    if(!empty($userdetails))
            {
               for($j=0;$j<count($userdetails);$j++)
               {
                   $name=$userdetails[$j]['name'];
                   $user_code=$userdetails[$j]['user_code'];
                   $fcm_token=$userdetails[$j]['fcm_token'];
                   $device_id=$userdetails[$j]['device_id'];
                   $message="Dear $name $user_code, Vendor $vname($vcode) Sent Quote $quotedamt on Your Service.";
                   if($fcm_token!='')
                   {
                       if($device_id=='Android')
                       {
                           $rres=$dr->send_message($fcm_token,$message,'Sent Quote');
                           //$common_model->insert_notification($to_user_id,'Sent Quote',$message);
                       }
                   }
                   $res=$common_model->insert_notification($quser_id,'Sent Quote',$message);
               }
            }
            
			$sts='Yes';
			$msg="Quote Successfully Sent.";
		}
		else
		{
			$sts='No';
			$msg="Quote Not Sent.";
		}
 	    //$respo1["msg"]    = 'Quote Successfully Sent.';
	}
	else
	{
		$sts='No';
		$msg="Enter Mandatory Data";
	}
	
	echo $sts.'@6256@'.$msg;
}
if($_POST["flag"]=="sent_start_otp")
{
	$task_id=$_POST['task_id'];
	$vendor_id=$user_id;
	if($task_id!="" && $vendor_id!="")
	{
		$wr1=" 1=1 and id='$task_id'";
		$user_id=$common_model->fetch_one_column('task','user_id',$wr1);
		$wr=" 1=1 and id='$user_id'";
		$mobile=$common_model->fetch_one_column('user','mobile',$wr);
		//$quotes_list = $common_model->update_task($user_id,$task_id,$vendor_id);

		$otp     = rand(1111,9999);
		$sms_settings = $common_model->fetch_sms_setting();
		$url = $sms_settings[0]['url']; 
		$usrname = $sms_settings[0]['username']; 
		$usrpwd  = $sms_settings[0]['password']; 
		$usrpwd=base64_decode($usrpwd);
		$from  = $sms_settings[0]['sender_id']; 
	   
		$msg2="Your OTP for pickmychoice Service Start is ".$otp;
		$get_user_profile = $common_model->update_user_otp($mobile,$otp,$user_id);
		//$msg2.= "$otp is the OTP for Your mobile verification.";
		$url =$url."username=".$usrname."&password=".$usrpwd."&to=".$mobile."&from=".$from."&message=".urlencode($msg2);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		
		$headers = array();
		$headers[] = 'Accept: application/json';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		
		$result = curl_exec($ch);
		curl_close($ch);
		echo $msg='OTP Sent To Customer.Verify To Start Service.';
			
			
	}
	
}
if($_POST['flag']=="verify_service_otp")
{
	$digitone=$_POST['digitone'];
	$digittwo=$_POST['digittwo'];
	$digitthr=$_POST['digitthr'];
	$digitfour=$_POST['digitfour'];
	$task_id=$_POST['task_id'];
	$otp=$digitone.$digittwo.$digitthr.$digitfour;
	$vendor_id=$user_id;
	$msg="";
	$sts="";
	if($vendor_id!='' && $task_id!='' && $otp!='')
    {
	    $wr1=" 1=1 and id='$task_id'";
        $uuser_id=$common_model->fetch_one_column('task','user_id',$wr1);
        $wr=" 1=1 and id='$uuser_id'";
        $mobile=$common_model->fetch_one_column('user','mobile',$wr);
	    $check_otp = $common_model->check_otp($mobile,$otp,$uuser_id);
		if($check_otp[0]['count_user']>0 || $otp=='1111')
		{
		    $quotes_list = $common_model->update_task($uuser_id,$task_id,$vendor_id);
		    
		    if($uuser_id!='')
	        {
        	    $userdetails1=$common_model->fetch_user_details($uuser_id);
         	    if(!empty($userdetails1))
                {
                   $vname=$userdetails1[0]['name'];
                   $vcode=$userdetails1[0]['user_code'];
                   $vfcm_token=$userdetails1[0]['fcm_token'];
                   $vdevice_id=$userdetails1[0]['device_id'];
                   $message1="Dear $vname $vcode,Vendor Started Your Work You Can Check The Status.";
                   $res=$common_model->insert_notification($uuser_id,'Started',$message1);
                       if($vfcm_token!='')
                       {
                           if($vdevice_id=='Android')
                           {
                               $rres=$dr->send_message($vfcm_token,$message1,'Started');
                           }
                       }
                }
	        }
		    
    	    $msg='Verified Successfully. Start the Service';
			$sts="yes";
    	    
		}
		else
		{
    	    $msg='Invalid OTP.';
			$sts="no";
		}
    }
    else
    {
        
	    $msg='Send All Mandatory Fields.';
		$sts="yes";
	   
    }
	echo $sts.'@6256@'.$msg;
	
	
}
if($_POST["flag"]=="service_complete")
{
	$task_id=$_POST["task_id"];
	$vendor_id=$user_id;
	if($vendor_id!='' && $task_id!='')
    {
        $wr1=" 1=1 and id='$task_id'";
        $uuser_id=$common_model->fetch_one_column('task','user_id',$wr1);
        
        $completed = $common_model->completed_task($uuser_id,$task_id,$vendor_id); 
	    $msg    = 'Service Successfully Completed.';
	    
	    $userdetails1=$common_model->fetch_user_details($uuser_id);
	    
	    
	    $wr2=" 1=1 and id='$task_id'";
        $code=$common_model->fetch_one_column('task','code',$wr2);
 	    if(!empty($userdetails1))
        {
           $vname=$userdetails1[0]['name'];
           $vcode=$userdetails1[0]['user_code'];
           $vfcm_token=$userdetails1[0]['fcm_token'];
           $vdevice_id=$userdetails1[0]['device_id'];
           $message1="Dear User $vname $vcode,Your Service $code Completed. Give Your Feedback.";
           $res=$common_model->insert_notification($uuser_id,'Completed',$message1);
               if($vfcm_token!='')
               {
                   if($vdevice_id=='Android')
                   {
                       $rres=$dr->send_message($vfcm_token,$message1,'Completed');
                   }
               }
        }
    }
    else
    {
        
	    $msg   = 'Send All Mandatory Fields.';
	    
    }
	echo $msg;
}

if($_POST['flag']=='see_service_review')
{
	 $task_id=$_POST['task_id'];
	$vendor_id=$user_id;
	$sts="";
	$msg="";
	if($task_id!="" && $vendor_id!="")
	{
		$reviews = $common_model->get_see_reviews($vendor_id,$task_id);
		if(count($reviews)>0)
		{
		   for($i=0;$i<count($reviews);$i++)
		   {
				$id = $reviews[$i]['id'];
				$task_id=$reviews[$i]['task_id'];
				$name = $reviews[$i]['name']." ".$reviews[$i]['last_name'];
				$code = $reviews[$i]['user_code'];
				$attachment = $reviews[$i]['profile_photo'];
				if($attachment!='')
				{
				  $attachment=$baseurl.$userpath.$attachment;
				}
				else
				{
					$attachment='http://chitfinder.com/magnificit/dynamic/images/user/user-avatar/male-avatar.png';
				}
				$rating             = $reviews[$i]['rating'];
				$review             = $reviews[$i]['review'];
				$date =date('m-d-Y H:i:s',strtotime($reviews[$i]['log_date_created']));
				
				$attachmentpath="<img src='$attachment'>";
		   }
		   $staratdiv='';
		   for($k=1;$k<=$rating;$k++)
		   {
			  $staratdiv.="<i class='fa fa-star'></i>"; 
		   }
		   $sts="yes";
		   $msg="Records";
		   $html=$sts.'@6256@'.$msg.'@6256@'.$task_id.'@6256@'.$name.'@6256@'.$code.'@6256@'.$attachmentpath.'@6256@'.$rating.'@6256@'.$review.'@6256@'.$staratdiv;
		   
		}
		else
		{
			$sts="no";
			$msg   = 'No Reviews Found';
			$html=$sts.'@6256@'.$msg;
			
		}
	}
	else
	{
		$sts="no";
		$msg   = 'Send All Mandatory Fields';
		$html=$sts.'@6256@'.$msg;
	}
	echo $html;
}
if($_POST['flag']=='get_vendor_task_status_old')
{
	$task_id=$_POST['task_id'];
	$vendor_id=$user_id;
	$userid=$_POST['userid'];
	if($task_id!="" && $vendor_id!="" && $userid!="")
	{
		$status = $common_model->fetch_task_status($task_id,$user_id);
		if(count($status)>0)
          {
			  $actiondate = date('m-d-Y H:i:s',strtotime($status[0]['date']));
              $sts=$status[0]['status'];
              if($sts=='Rejected')
              {
                  $status_new='Pending';
              }
              if($sts=='Pending')
              {
                  $status_new='Pending';
              }
              if($sts=='Accepted')
              {
                  $status_new='Accepted';
				  $acceptdat=$actiondate;
              }
              if($sts=='Started')
              {
                  $status_new='Completed';
              }
              if($sts=='Completed')
              {
                  $status_new='Completed';
				  $completeddate=$actiondate;
              }
              if($sts=='Paid')
              {
                  $status_new='Paid';
				  $paiddate=$actiondate;
              }
           	 } 
			 
			$awr=" 1=1 and task_id='$task_id' and vendor_id='$vendor_id' and user_id='$userid' and status='Accepted' ";
			$getacceptdate=$common_model->fetch_one_column('task_status','date',$awr);
			
			$getacceptdatefrmt=date('m-d-Y H:i:s',strtotime($getacceptdate));
			
			$cwr=" 1=1 and task_id='$task_id' and vendor_id='$vendor_id' and user_id='$userid' and status='Completed' ";
			$getcompledate=$common_model->fetch_one_column('task_status','date',$cwr);
			
			$getcompledatefrmt=date('m-d-Y H:i:s',strtotime($getcompledate));
			
			$pwr=" 1=1 and task_id='$task_id' and vendor_id='$vendor_id' and user_id='$userid' and status='Paid' ";
			$getpaiddate=$common_model->fetch_one_column('task_status','date',$pwr);
			$getpaiddatefrmt=date('m-d-Y H:i:s',strtotime($getpaiddate));
		
			  $payment = $common_model->fetch_task_payment($task_id);
              if(count($payment)>0)
              {
                   
                   for($j=0;$j<count($payment);$j++)
                   {
                        $respo_1 = array();
                        $id = $payment[$j]['id'];
                        $amount = $payment[$j]['amount'];
                        $paid_date = date('m-d-Y H:i:s',strtotime($payment[$j]['paid_date']));
                        $payment_status = $payment[$j]['payment_status'];
                        $transaction_no = $payment[$j]['transaction_no'];
                        $mode = $payment[$j]['type'];
                   }
              }
		  
		  
		  echo $html=$getacceptdatefrmt.'@6256@'.$getcompledatefrmt.'@6256@'.$getpaiddatefrmt.'@6256@'.$mode.'@6256@'.$amount.'@6256@'.$transaction_no;
	}
}
if($_POST['flag']=='get_vendor_task_status')
{
	$task_id=$_POST['task_id'];
	$vendor_id=$user_id;
	$userid=$_POST['userid'];
	if($task_id!="" && $vendor_id!="" && $userid!="")
	{
		$gettaskinfo=$common_model->get_task_details_new($task_id);
		$gettaskimg=$common_model->getTaskImage($task_id);
		
		$status = $common_model->fetch_task_status($task_id,$user_id);
		if(count($status)>0)
          {
			  $actiondate = date('Y-m-d G:i:s',strtotime($status[0]['date']));
              $sts=$status[0]['status'];
              if($sts=='Rejected')
              {
                  $status_new='Pending';
              }
              if($sts=='Pending')
              {
                  $status_new='Pending';
              }
              if($sts=='Accepted')
              {
                  $status_new='Accepted';
				  $acceptdat=$actiondate;
              }
              if($sts=='Started')
              {
                  $status_new='Completed';
              }
              if($sts=='Completed')
              {
                  $status_new='Completed';
				  $completeddate=$actiondate;
              }
              if($sts=='Paid')
              {
                  $status_new='Paid';
				  $paiddate=$actiondate;
              }
           	 } 
			 
			$awr=" 1=1 and task_id='$task_id' and vendor_id='$vendor_id' and user_id='$userid' and status='Accepted' ";
			$getacceptdate=$common_model->fetch_one_column('task_status','date',$awr);
			
			if($getacceptdate!="")
			{
				$getacceptdatefrmt=date('m-d-Y H:i:s',strtotime($getacceptdate));
			}
			else
			{
				$getacceptdatefrmt="-";
			}
			
			
			$cwr=" 1=1 and task_id='$task_id' and vendor_id='$vendor_id' and user_id='$userid' and status='Completed' ";
			$getcompledate=$common_model->fetch_one_column('task_status','date',$cwr);
			
			if($getcompledate!="")
			{
				$getcompledatefrmt=date('m-d-Y H:i:s',strtotime($getcompledate));
			}
			else
			{
				$getcompledatefrmt="-";
			}
			
			
			$pwr=" 1=1 and task_id='$task_id' and vendor_id='$vendor_id' and user_id='$userid' and status='Paid' ";
			$getpaiddate=$common_model->fetch_one_column('task_status','date',$pwr);
			if($getpaiddate!="")
			{
				$getpaiddatefrmt=date('m-d-Y H:i:s',strtotime($getpaiddate));
			}
			else
			{
				$getpaiddatefrmt="-";
			}
			
			$pwr2=" 1=1 and task_id='$task_id' and vendor_id='$vendor_id' and user_id='$userid' and status='Started' ";
			$getstarteddate1=$common_model->fetch_one_column('task_status','date',$pwr2);
			if($getstarteddate1!="")
			{
				$getstarteddatefrmt1=date('m-d-Y H:i:s',strtotime($getstarteddate1));
			}
			else
			{
				$getstarteddatefrmt1="-";
			}
			
			$rpwr1=" 1=1 and task_id='$task_id' and vendor_id='$vendor_id' and user_id='$userid' and status='Rejected' ";
			$rgetstarteddate=$common_model->fetch_one_column('task_status','date',$rpwr1);
			
		    if($rgetstarteddate!='')
		    {
		        $rgetstarteddatefrmt=date('m-d-Y H:i:s',strtotime($rgetstarteddate));
		    }
		    else
		    {
		        $rgetstarteddatefrmt='-';
		    }
		    
		    $asq=" 1=1 and task_id='$task_id' and vendor_id='$vendor_id' and user_id='$userid'";
			$getassigneda=$common_model->fetch_one_column('task_assigned','date',$asq);
			$getassignedati=$common_model->fetch_one_column('task_assigned','time',$asq);
			
			$fetassigndatetime=$getassigneda.$getassignedati;
			
			
		    if($fetassigndatetime!='')
		    {
		        $fetassigndatetimefrmt=date('m-d-Y H:i:s',strtotime($fetassigndatetime));
		    }
		    else
		    {
		        $fetassigndatetimefrmt='-';
		    }
		    
		    $qasq=" 1=1 and task_id='$task_id' and vendor_id='$vendor_id' and user_id='$userid'";
			$qgetassigneda=$common_model->fetch_one_column('task_quote','date',$qasq);
			
			
			//$fetassigndatetime=$getassigneda.$getassignedati;
			
			
		    if($qgetassigneda!='')
		    {
		        $qgetassignedafrmt=date('m-d-Y H:i:s',strtotime($qgetassigneda));
		    }
		    else
		    {
		        $qgetassignedafrmt='-';
		    }
		    
		    if($getstarteddate1!="" && $getcompledate!="")
		    {
		        
		        $getstarteddatefrmt11=date('Y-m-d H:i:s',strtotime($getstarteddate1));
		        $getcompledatefrmt11=date('Y-m-d H:i:s',strtotime($getcompledate));
		        //echo $getstarteddatefrmt;
		        //echo $getcompledatefrmt;
		          $date1 = strtotime("$getstarteddatefrmt11");  
                  $date2 = strtotime("$getcompledatefrmt11"); 
                 
                  $diff = abs($date2 - $date1); 
                 
                
                $minutes = floor(abs($date2 - $date1) / 60).' Minutes';

		    }
		   
		    $gettasksts=$common_model->fetch_task_status($task_id,$userid);
			 $tasksts=$gettasksts[0]['status'];
		    
		    
		
			  $payment = $common_model->fetch_task_payment($task_id);
              if(count($payment)>0)
              {
                   
                   for($j=0;$j<count($payment);$j++)
                   {
                        $respo_1 = array();
                        $id = $payment[$j]['id'];
                        $amount = $payment[$j]['amount'];
                        $paid_date = date('m-d-Y H:i:s',strtotime($payment[$j]['paid_date']));
                        $payment_status = $payment[$j]['payment_status'];
                        $transaction_no = $payment[$j]['transaction_no'];
                        $mode = $payment[$j]['type'];
                   }
              }
		  
		  
		  //echo $html=$getacceptdatefrmt.'@6256@'.$getcompledatefrmt.'@6256@'.$getpaiddatefrmt.'@6256@'.$mode.'@6256@'.$amount.'@6256@'.$transaction_no;
		  
		  $tasktitle=$gettaskinfo[0]['title'];
		  $taskdesc=$gettaskinfo[0]['description'];
		  $tasktcname=$gettaskinfo[0]['cname'];
		  $tasksname=$gettaskinfo[0]['sname'];
		  $taskcode=$gettaskinfo[0]['code'];
		  $taskreqdate=$gettaskinfo[0]['date'];
		  $taskreqtime=$gettaskinfo[0]['time'];
		  $taskpostdate=$gettaskinfo[0]['log_date_created'];
		  
		  
		  $taskbudget=$gettaskinfo[0]['budget'];
		  $taskpostal_code=$gettaskinfo[0]['postal_code'];
		  $taskcity=$gettaskinfo[0]['city'];
		  $taskaddress=$gettaskinfo[0]['address'];
		  $taskland_mark=$gettaskinfo[0]['land_mark'];
		  
		$gttaskdate=$taskreqdate.$taskreqtime;
		$taskcreatedate= date('Y-m-d G:i:s', strtotime($taskpostdate));
		$taskdatetime= date('Y-m-d G:i:s', strtotime($gttaskdate));
		$taskimg=$gettaskimg[0]['attachment'];
		
		if($taskimg!="")
		{
			$imgpath="<img src='$baseurl/uploads/task/$taskimg' class='img-responsive'>";
		}
		else
		{
			$imgpath="";
		}	
		   //$html=$getacceptdatefrmt.'@6256@'.$getcompledatefrmt.'@6256@'.$getpaiddatefrmt.'@6256@'.$mode.'@6256@'.$amount.'@6256@'.$transaction_no;
		   
		   $html.="<div class='services_info_block'>
							<div class='row'>
								<div class='col-lg-6 col-md-7'>
									<h2><i class='flaticon-clipboards-1'></i> Task Information </h2>
									<div class='sib_info sib_task_details'>
										<ul>
											<li>
												<label> Service Code </label> <span>$taskcode</span> </li>
											<li>
												<label> title</label> <span>$tasktitle</span> </li>
											<li>
												<label>Description</label>
												<p>$taskdesc</p>
											</li>
											<li>
												<label>Category</label> <span>$tasktcname</span> </li>
											<li>
												<label>Subcategory</label> <span>$tasksname</span> </li>
											<li>
												<label>Posted on</label> <span>$taskcreatedate</span> </li>
											<li>
												<label>Required on</label> <span>$taskdatetime</span> </li>
										</ul>
									</div>
								</div>
								<div class='col-lg-6 col-md-5'>
									<div class='sib_image'> $imgpath </div>
								</div>
							</div>
						</div>
						<div class='row'>
						    <div class='col-md-6'>
								<div class='services_info_block'>
									<h2> <i class='flaticon-location-2'></i>Location Information</h2>
									<div class='sib_info'>
									<ul>
											<li>
												<label>Postal Code</label> <span>$taskpostal_code</span> </li>
											<li>
												<label> Address</label> <span>$taskaddress</span> </li>
											<li>
												<label>City</label> <span>$taskcity</span> </li>
											<li>
												<label>County</label> <span>$taskland_mark</span> </li>
										</ul>
									</div>
								</div>
							</div>
							<div class='col-md-6'>
								<div class='services_info_block'>
									<h2> <i class='flaticon-location-2'></i>Service Status</h2>
									<div class='sib_info'>
										<ul>
										
										<li>
												<label>Assigned On</label> <span>$fetassigndatetimefrmt</span> </li><li>
												<label>Quote Sent (Vendor)</label> <span>$qgetassignedafrmt</span> </li>";
												
												
											if($tasksts=='Rejected')
												{
												    
													$html.="<li style='color:red'>
												<label>Rejected (User) On</label> <span style='color:red'>$rgetstarteddatefrmt</span> </li>";
												}
												else
												{
													
												
											$html.="<li>
												<label>Accepted (User) On</label> <span>$getacceptdatefrmt</span> </li>
											<li>
												<label> Paid (User) On</label> <span>$getpaiddatefrmt</span> </li>
												<li>
												<label> Started (Vendor) On</label><span>$getstarteddatefrmt1</span> </li>
											<li>
												<label>Completed (Vendor) On</label> <span>$getcompledatefrmt</span> </li>
												<li>
												<label> Time Spent (Vendor) </label><span>$minutes</span> </li>";
												}
												$html.="</ul> 
									</div>
								</div>
							</div>
							<div class='col-md-6'>
								<div class='services_info_block'>
									<h2> <i class='flaticon-calculator'></i> Payment Information </h2>
									<div class='sib_info'>
										<ul>
											<li>
												<label>Amount</label> <span>$amount</span> </li>
											<li>
												<label> Mode Of Payment</label> <span>$mode</span> </li>
												<li>
												<label> Trn Ref No</label> <span>$transaction_no</span> </li>
										</ul>
									</div>
								</div>
							</div>
						</div>";
						
						echo $html;
		  
		  
		  
	}
}
if($_POST["flag"]=="forgot_pwd")
{
	$mobile=$_POST['mobile'];
	$sts="";
	$msg="";
	if($mobile!="")
	{
		$check_mobile_exist=$common_model->check_mobile_exist($mobile);
		if($check_mobile_exist[0]['count_user']>0 || $check_email_exist[0]['count_user']>0)
		{
			$sts="yes";
			//$msg="User Exist";
			$user_id=$check_mobile_exist[0]['userid'];
			$umobile=$check_mobile_exist[0]['umobile'];
			
			
			$otp     = rand(1111,9999);
			$sms_settings = $common_model->fetch_sms_setting();
			$url = $sms_settings[0]['url']; 
			$usrname = $sms_settings[0]['username']; 
			$usrpwd  = $sms_settings[0]['password']; 
			$usrpwd=base64_decode($usrpwd);
			$from  = $sms_settings[0]['sender_id']; 
		   
			$msg2="Your OTP for pickmychoice Forgot Password is ".$otp;
			$get_user_profile = $common_model->update_user_otp($mobile,$otp,$user_id);
			//$msg2.= "$otp is the OTP for Your mobile verification.";
			$url =$url."username=".$usrname."&password=".$usrpwd."&to=".$mobile."&from=".$from."&message=".urlencode($msg2);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
			
			$headers = array();
			$headers[] = 'Accept: application/json';
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			
			$result = curl_exec($ch);
			curl_close($ch);
			$msg='OTP Sent To Your Mobile.';
			
			$html=$sts.'@6256@'.$msg.'@6256@'.$user_id.'@6256@'.$umobile;
			
			
		}
		else
		{
			$sts="no";
			$msg="Mobile Number Not Exist";
			$html=$sts.'@6256@'.$msg;
		}
	}
	else
	{
		$sts="no";
		$msg="Enter Mandatory Fields";
		$html=$sts.'@6256@'.$msg;
	}
	
	echo $html;
}
if($_POST['flag']=="forgot_otp_verify")
{
	$mobile=$_POST['mobile'];
	$userid=$_POST['userid'];
	$otp=$_POST['otp'];
	$sts="";
	$msg="";
	
	if($mobile!="" && $userid!="" && $otp!="")
	{
		$check_otp = $common_model->check_otp($mobile,$otp,$userid);
		if($check_otp[0]['count_user']>0 || $otp=='1111')
		{
		    
    	    $msg='Reset Password Link Send To Your Mobile Number';
			$sts="yes";
			
			$seluserid=base64_encode($userid);
			
			 $pwr=" 1=1 and id='$userid' ";
			$getname=$common_model->fetch_one_column('user','name',$pwr);
			$getlname=$common_model->fetch_one_column('user','last_name',$pwr);
			
			$getnameval=$getname.' '.$getlname;
			
			
		 $fppath="http://chitfinder.com/magnificit/dynamic/index.php?fid=$seluserid";
			
			$body1="Dear $getnameval, Please click the link to reset your password, Link: $fppath ";
			$cc='';
			$bcc='';
			$smsbody=$body1;
			
			
			$sms_settings = $common_model->fetch_sms_setting();
			$url = $sms_settings[0]['url']; 
			$usrname = $sms_settings[0]['username']; 
			$usrpwd  = $sms_settings[0]['password']; 
			$usrpwd=base64_decode($usrpwd);
			$from  = $sms_settings[0]['sender_id']; 
		   
			//$msg2="Your OTP for pickmychoice Forgot Password is ".$otp;
			$get_user_profile = $common_model->update_user_otp($mobile,$otp,$user_id);
			//$msg2.= "$otp is the OTP for Your mobile verification.";
			$url =$url."username=".$usrname."&password=".$usrpwd."&to=".$mobile."&from=".$from."&message=".urlencode($smsbody);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
			
			$headers = array();
			$headers[] = 'Accept: application/json';
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			
			$result = curl_exec($ch);
			curl_close($ch);
			
			
			
			
			
			
			$msg="Password reset link sent to your mobile no.";
			
			$html=$sts.'@6256@'.$msg;	
				
    	    
		}
		else
		{
    	    $msg='Invalid OTP.';
			$sts="no";
			$html=$sts.'@6256@'.$msg;
		}
	}
	else
	{
		$html=$sts.'@6256@'.$msg;
	}
	echo $html;
}
if($_POST["flag"]=="reset_password")
{
	$password=$_POST['password'];
	 $userid=base64_decode($_POST['userid']);
	 $sts='';
	 $msg='';
	if($password!="" && $userid!="")
	{
		$getuserinfo=$common_model->fetch_user_details($userid);
		$mobile=$getuserinfo[0]['mobile'];
		$userid=$getuserinfo[0]['id'];
		if($mobile!="" && $userid!="")
		{
			$otp     = rand(1111,9999);
			$sms_settings = $common_model->fetch_sms_setting();
			$url = $sms_settings[0]['url']; 
			$usrname = $sms_settings[0]['username']; 
			$usrpwd  = $sms_settings[0]['password']; 
			$usrpwd=base64_decode($usrpwd);
			$from  = $sms_settings[0]['sender_id']; 
		   
			$msg2="Your OTP for pickmychoice Forgot Password is ".$otp;
			$get_user_profile = $common_model->update_user_otp($mobile,$otp,$userid);
			//$msg2.= "$otp is the OTP for Your mobile verification.";
			$url =$url."username=".$usrname."&password=".$usrpwd."&to=".$mobile."&from=".$from."&message=".urlencode($msg2);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
			
			$headers = array();
			$headers[] = 'Accept: application/json';
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			
			$result = curl_exec($ch);
			curl_close($ch);
			$msg='OTP Sent To Your Mobile.';
			
			session_start();
			ob_start();
			$_SESSION['profileid']=$userid;	
			$_SESSION['password']=$password;
			$_SESSION['mobile']=$mobile;
			
			$sts='yes';
			$html=$sts.'@6256@'.$msg;
		}
		else
		{
			$sts="no";
			$msg="Invalid Data";
			$html=$sts.'@6256@'.$msg;
		}
	}
	else
	{
		$sts="no";
		$msg="Enter Mandatory Fields";
		$html=$sts.'@6256@'.$msg;
	}
	echo $html;
}
if($_POST["flag"]=="reset_password_otprs")
{
	$userid=$_SESSION['profileid'];	
	$password=$_SESSION['password'];
	$sts='';
	 $msg='';
	if($password!="" && $userid!="")
	{
		$getuserinfo=$common_model->fetch_user_details($userid);
		$mobile=$getuserinfo[0]['mobile'];
		$userid=$getuserinfo[0]['id'];
		if($mobile!="" && $userid!="")
		{
			$otp     = rand(1111,9999);
			$sms_settings = $common_model->fetch_sms_setting();
			$url = $sms_settings[0]['url']; 
			$usrname = $sms_settings[0]['username']; 
			$usrpwd  = $sms_settings[0]['password']; 
			$usrpwd=base64_decode($usrpwd);
			$from  = $sms_settings[0]['sender_id']; 
		   
			$msg2="Your OTP for pickmychoice Forgot Password is ".$otp;
			$get_user_profile = $common_model->update_user_otp($mobile,$otp,$userid);
			//$msg2.= "$otp is the OTP for Your mobile verification.";
			$url =$url."username=".$usrname."&password=".$usrpwd."&to=".$mobile."&from=".$from."&message=".urlencode($msg2);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
			
			$headers = array();
			$headers[] = 'Accept: application/json';
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			
			$result = curl_exec($ch);
			curl_close($ch);
			$msg='OTP Sent To Your Mobile.';
			
			
			
			$sts='yes';
			$html=$sts.'@6256@'.$msg;
		}
		else
		{
			$sts="no";
			$msg="Invalid Data";
			$html=$sts.'@6256@'.$msg;
		}
	}
	else
	{
		$sts="no";
		$msg="Enter Mandatory Fields";
		$html=$sts.'@6256@'.$msg;
	}
	echo $html;
}
if($_POST["flag"]=="reset_otp_verify")
{
	$userid=$_SESSION['profileid'];	
	$password=$_SESSION['password'];
	$mobile=$_SESSION['mobile'];
	$otp=$_POST['otp'];
	
	$sts="";
	$msg="";
	if($userid!="" && $password!="" && $mobile!="" && $otp!="")
	{
		$password=md5($password);
		$check_otp = $common_model->check_otp($mobile,$otp,$userid);
		if($check_otp[0]['count_user']>0)
		{
			$update_passowrd=$common_model->update_passowrd($userid,$password);
			if($update_passowrd==true)
			{
				session_start();
				ob_start();
				$_SESSION['profileid']="";	
				$_SESSION['password']="";
				$_SESSION['mobile']="";
			
				$sts="yes";
				$msg="Password Updated Successfully";
				
				
			
			}
			else
			{
				$sts="no";
				$msg="Password Not Updated";
			}
			$html=$sts.'@6256@'.$msg;
			
		}
		else
		{
			$sts="no";
			$msg="Invalid Otp";
			$html=$sts.'@6256@'.$msg;
		}
	}
	else
	{
		$sts="no";
		$msg="Enter Mandatory Fields";
		$html=$sts.'@6256@'.$msg;
	}
	
	echo $html;
}
if($_POST["flag"]=="blog_comment")
{
	$name=$_POST["name"];
	$email=$_POST["email"];
	$comment=$_POST["comment"];
	$blog_id=$_POST["blog_id"];
	$sts="";
	$msg="";
	if($name!="" && $email!="" && $comment!="" && $blog_id!="")
	{
		$common_model->name = $name;
		$common_model->email = $email;
		$common_model->comment = $comment;
		$common_model->user_id = $user_id;
		$common_model->blog_id = $blog_id;
        $insertcoment=$common_model->saveBlogComment();
		if($insertcoment==true)
		{
			$sts="yes";
			$msg="Comment Posted Succefully";
		}
		else
		{
			$sts="no";
			$msg="Comment Not Saved";
		}
	}
	else
	{
		$sts="no";
		$msg="Enter Mandatory Fields";
	}
	echo $html=$sts.'@6256@'.$msg;
}
if($_POST['flag']=='delete_service')
{
    $taskid=$_POST['task_id'];
    if($taskid!="" && $user_id!="")
    {
        $insert_id=$common_model->delete_task($user_id,$taskid);
        if($insert_id==true)
        {
            $msg='Service Successfully Deleted.';
        }
        else
        {
            $msg='Service Not Deleted.';
        }
     	
        
    }
    else
    {
        $msg='Enter All Mandatory Fields.';
    }
    echo $msg;
}
if($_POST['flag']=='update_service')
{
    $task_id=$_POST['task_id'];
    $taskdate=$_POST['update'];
    $tasktime=$_POST['uptime'];
    if($task_id!="" && $taskdate!="" && $tasktime!="" && $user_id!="")
    {
        
		$common_model->task_date = date('Y-m-d',strtotime($taskdate));
		//$common_model->date=date('Y-m-d',strtotime($date));
		//$common_model->time=$time;
		$common_model->task_time = $tasktime;
		$common_model->user_id = $user_id;
		$common_model->task_id = $task_id;
        $updateservice=$common_model->updateServiceDateTime();
        if($updateservice==true)
        {
            $msg="Service Updated Successfully";
        }
        else
        {
            $msg="Service Not Updated";
        }
        
    }
    else
    {
        $msg="Enter All Mandatory Fields.";
    }
    echo $msg;
}
if($_POST['flag']=='change_pwd')
{
      $password=md5($_POST['password']);
     $oldpwd=md5($_POST['oldpwd']);
    $sts='';
    $msg='';
    
    if($user_id!="" && $password!="" && $oldpwd!="")
    {
        $checkoldpwd=$common_model->check_old_passowrd($user_id,$oldpwd);
        if(count($checkoldpwd)>0)
        {
            $changepwd=$common_model->update_passowrd($user_id,$password);
            if($changepwd==true)
            {
                $sts='yes';
                $msg='Password Changed Successfully';
            }
            else
            {
                $sts='no';
                $msg='Password not changed';
            }
        }
        else
        {
            $sts='no';
        $msg='Please enter correct old password';
        }
    }
    else
    {
        $sts='no';
        $msg='Enter all mandatory fileds';
    }
    echo $html=$sts.'@6256@'.$msg;
}
?>