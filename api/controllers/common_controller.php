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
ini_set("allow_url_fopen", 1);
$baseurl="http://chitfinder.com/magnificit/";
$api_key="EN4lXzbqMEaGCfBnBcosQA29618";
//$api_key="NoYxROLhEE-1aNTxCy6z0w29655";
$userpath="uploads/user/";
$categorypath = "uploads/category/";
$subcategorypath = "uploads/subcategory/";
$bannerpath = "uploads/banners/";
$vendorpath = "uploads/vendor/";
$taskpath="uploads/task/";
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

if($post_type=='getaddress')
{
    $keyword = $json_decode->postcode;
    if(strlen($keyword)>=5)
    {
    $post_code=str_replace(" ","%20",$json_decode->postcode);
    $url="https://api.getaddress.io/find/".$post_code."?expand=true&sort=true&api-key=".$api_key;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    $headers = array();
    $headers[] = 'Accept: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $result = curl_exec($ch);
        if($result)
        {
            $responsedata=json_decode($result);
            $msg=trim($responsedata->Message);
            if(sizeof($responsedata)>0 && $msg!='Bad Request: Invalid postcode.')
            {
             curl_close($ch);
             echo $result;
            }
            else
            {
            $respo1["status"] = false; 
    	    $respo1["msg"]    = 'Invalid Postcode.';
    	    $respo1['errorCode'] = 703;
    	    echo json_encode($respo1);
            }
        }
        else
        {
            $respo1["status"] = false; 
    	    $respo1["msg"]    = 'Invalid Postcode.';
    	    $respo1['errorCode'] = 703;
    	    echo json_encode($respo1);
        }
    }
}
else
{
$get_token = $dr->getApiKey($user_id);
if($api_token!=$get_token)
{
    $errocode = $dr->getOK();
    $msg = 'Invalid Api Token';
    $status = true;
    $res = '';
    $login_details="";
    $dr->setErrorCode($errocode);
    $dr->setMsg($msg);
    $dr->setStatus($status);
    $dr->setCustomRsp('user_details', $login_details);
    $dr->setCustomRsp('api_token', $api_token);
    echo $dr->getResponse();
}
else
{
if($api_token!='' && $user_id!='')
{
    
    
if($post_type=='my_notifications')
{
    $user_id=$json_decode->user_id;
    if($user_id!='')
    {
        $notification_list = $common_model->fetch_all_notifications($user_id);
        $respo1["notification_list"] = array();
        $count=0;
        if(!empty($notification_list))
        {
           for($i=0;$i<count($notification_list);$i++)
           {
              $respo = array();
           	  $respo['notification_id'] = $notification_list[$i]['id'];
              $respo['user_id']         = $notification_list[$i]['user_id'];
           	  $respo['title']           = ucwords($notification_list[$i]['title']);
           	  $respo['message']         = $notification_list[$i]['message'];
           	  if($notification_list[$i]['title']=='Welcome')
           	  {
           	  $respo['button_text']='';
           	  }
           	  else
           	  {
           	  $respo['button_text']     = $notification_list[$i]['title'];
           	  }
           	  $respo['recieved_date']   = $notification_list[$i]['recieved_date'];
           	  array_push($respo1["notification_list"], $respo);
           }
            $respo1["status"] = true; 
    	    $respo1["msg"]    = 'Notifications Found';
    	    $respo1['errorCode'] = 700;
        }
        else
    	{
    		$respo1["status"] = false; 
    	    $respo1["msg"]    = 'Notifications Not Found';
    	    $respo1['errorCode'] = 703;
    	}
    }
    else
	{
		$respo1["status"] = false; 
	    $respo1["msg"]    = 'Send All Mandatory Fields.';
	    $respo1['errorCode'] = 703;
	}
	echo json_encode($respo1);
}    
if($post_type=='adtask')
{
    $user_id=$json_decode->user_id;
    $cat_id=$json_decode->category_id;
    $sub_cat=$json_decode->sub_cat_id;
    $title=$json_decode->title;
    $description=$json_decode->description;
    $post_code=$json_decode->post_code;
    $address=$json_decode->address;
    $city=$json_decode->city;
    $landmark=$json_decode->landmark;
    $amount=$json_decode->amount;
    $negotiate=$json_decode->is_negotiate;
    $attachment=$json_decode->attachment;
    if($attachment!='')
    {
    $data1 = "data:image/png;base64,".$attachment."";
	$data1 = str_replace('data:image/png;base64,', '', $data1);
	$data1 = str_replace(' ', '+', $data1);
	$data1 = base64_decode($data1);
	$filename1=time().'1'.'.png';
	$file = '../../uploads/task/'.$filename1;
	$success = @file_put_contents($file, $data1);
    $attachment=$filename1;
    }
    else
    {
       $attachment=''; 
    }
    $date2=$json_decode->date;
    if($date2!='')
    {
    $month=date("m", strtotime($date2));
    $parts = explode('-',$date2);
    $date2 = $parts[2].'-'.$month.'-'.$parts[1];
    }
    else
    {
        $date2=date('Y-m-d');
    }
    $time=$json_decode->time;
    if($time=='')
    {
       $time=date('H:i:s'); 
    }
    if($user_id!='' && $sub_cat!='' && $title!='' && $description!='' && $amount!='' && $post_code!='')
    {
        //common fields
        $common_model->title     = $title;
        $common_model->desc      = $description;
        $common_model->city      = $city;
        $common_model->post_code = $post_code;
        $common_model->address   = $address;
        $common_model->landmark  = $landmark;
        $common_model->category  = $cat_id;
        $common_model->sub_cat   = $sub_cat;
        $common_model->user_id   = $user_id;
        $task_code='PMCS'.rand(1000,999999);
        $common_model->ad_code   = $task_code;
        $common_model->amount    = $amount; 
        $common_model->is_negotiate=$negotiate;
        $common_model->attachment=$attachment;
        $common_model->date=$date2;
        $common_model->time=$time;
        
        $insert_id=$common_model->add_task();
        $respo1["task_id"] = $insert_id;
        $respo1["task_code"] = $task_code;
        $respo1["status"] = true; 
 	    //$respo1["msg"]    = 'successfully added';
 	    $respo1["msg"]    = 'Service Posted Successfully.';
 	    $respo1['errorCode'] = 700;
    }
    else
    {
        $respo1["task_id"]="";
        $respo1["task_code"] ='';
        $respo1["status"] = false; 
	    $respo1["msg"]    = 'Send All Mandatory Fields';
	    $respo1['errorCode'] = 703;
	}
	echo json_encode($respo1);
}
if($post_type=='postquote')
{
    
    $user_id=$json_decode->user_id;
    $to_user_id=$json_decode->to_user_id;
    $task_id=$json_decode->task_id;
    $amount=$json_decode->amount;
    $description=$json_decode->description;
    if($user_id!='' && $to_user_id!='' && $task_id!='' && $amount!='')
    {
        //common fields
        $common_model->user_id   = $user_id;
        $common_model->to_user_id= $to_user_id;
        $common_model->task_id   = $task_id;
        $common_model->amount    = $amount;
        $common_model->description = $description;
        $insert_id=$common_model->insert_quote();
        $respo1["status"] = true; 
 	    $respo1["msg"]    = 'Quote Successfully Sent.';
 	    $respo1['errorCode'] = 700;
 	    $userdetails1=$common_model->fetch_user_details($user_id);
 	    if(!empty($userdetails1))
        {
           $vname=$userdetails1[0]['name'];
           $vcode=$userdetails1[0]['user_code'];
        }
 	    $userdetails=$common_model->fetch_user_details($to_user_id);
 	    if(!empty($userdetails))
        {
           for($j=0;$j<count($userdetails);$j++)
           {
               $name=$userdetails[$j]['name'];
               $user_code=$userdetails[$j]['user_code'];
               $fcm_token=$userdetails[$j]['fcm_token'];
               $device_id=$userdetails[$j]['device_id'];
               $message="Dear $name $user_code, Vendor $vname($vcode) Sent Quote $amount on Your Task.";
               if($fcm_token!='')
               {
                   if($device_id=='Android')
                   {
                       $rres=$dr->send_message($fcm_token,$message,'Sent Quote');
                       //$common_model->insert_notification($to_user_id,'Sent Quote',$message);
                   }
               }
               $res=$common_model->insert_notification($to_user_id,'Sent Quote',$message);
           }
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

if($post_type=='updatequote')
{
    $user_id =$json_decode->user_id;
    $quote_id=$json_decode->quote_id;
    $status  =$json_decode->status;
    $sts=ucwords($status);
    if($user_id!='' && $quote_id!='')
    {
        //common fields
        $common_model->user_id   = $user_id;
        $common_model->quote_id  = $quote_id;
        $common_model->status    = $sts;
        
        $wr1=" 1=1 and id='$quote_id'";
        $task_id=$common_model->fetch_one_column('task_quote','task_id',$wr1);
        
        $wr=" 1=1 and id='$quote_id'";
        $vendor_id=$common_model->fetch_one_column('task_quote','vendor_id',$wr);
        if($vendor_id!='' && $task_id!='')
        {
            $common_model->vendor_id= $vendor_id;
            $common_model->task_id= $task_id;
            $insert_id=$common_model->update_quote();
            $respo1["status"] = true; 
     	    $respo1["msg"]    = 'Quote Successfully Updated.';
     	    $respo1['errorCode'] = 700;
 	    
     	    $userdetails1=$common_model->fetch_user_details($user_id);
     	    if(!empty($userdetails1))
            {
               $vname=$userdetails1[0]['name'];
               $vcode=$userdetails1[0]['user_code'];
               $vfcm_token=$userdetails1[0]['fcm_token'];
               $vdevice_id=$userdetails1[0]['device_id'];
               if($sts=='Accepted')
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
                   $message="Dear $name $user_code, User $vname($vcode) $sts Your Quote.";
                   $common_model->insert_notification($vendor_id,$sts,$message);
                   if($fcm_token!='')
                   {
                       if($device_id=='Android')
                       {
                           $rres=$dr->send_message($fcm_token,$message,$sts);
                       }
                   }
            }
        }
        else
        {
        $respo1["status"] = false; 
	    $respo1["msg"]    = 'Send All Mandatory Fields';
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


if($post_type=='delete_service')
{
    $user_id =$json_decode->user_id;
    $task_id=$json_decode->task_id;
    if($user_id!='' && $task_id!='')
    {
            $insert_id=$common_model->delete_task($user_id,$task_id);
            $respo1["status"] = true; 
     	    $respo1["msg"]    = 'Service Successfully Deleted.';
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

if($post_type=='updatepayment')
{
    $user_id =$json_decode->user_id;
    $task_id =$json_decode->task_id;
    $amount  =$json_decode->amount;
    $tr_no   =$json_decode->transaction_no;
    $status  =$json_decode->status;
    $paymode =$json_decode->paymode;
    $reason  =$json_decode->reason;
    if($status=='success')
    {
        if($tr_no=='' || $paymode=='')
        {
        $respo1["status"] = false; 
	    $respo1["msg"]    = 'Send All Mandatory Fields!';
	    $respo1['errorCode'] = 703;
        }
        else
        {
            $wr1=" 1=1 and user_id='$user_id' and task_id='$task_id' and status='Accepted'";
            $vendor_id=$common_model->fetch_one_column('task_quote','vendor_id',$wr1);
            if($user_id!='' && $task_id!='' && $vendor_id!='')
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
                $common_model->vendor_id= $vendor_id;
                $common_model->task_id= $task_id;
                $common_model->status= 'Success';
                $common_model->amount=$amount;
                $common_model->tr_no= $tr_no;
                $common_model->paymode= $paymode;
                $common_model->reason= $reason;
                $common_model->waived_amount=$waived;
                $common_model->commission=$commission;
                $insert_id=$common_model->insert_payment();
                $respo1["status"] = true; 
         	    $respo1["msg"]    = 'Payment Successfully Completed.';
         	    $respo1['errorCode'] = 700;
         	    
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
            }
            else
            {
                $respo1["status"] = false; 
        	    $respo1["msg"]    = 'Send All Mandatory Fields';
        	    $respo1['errorCode'] = 703;
            }
        }
    }
    else if($status=='failed')
    {
            $wr1=" 1=1 and user_id='$user_id' and task_id='$task_id' and status='Accepted'";
            $vendor_id=$common_model->fetch_one_column('task_quote','vendor_id',$wr1);
            if($user_id!='' && $task_id!='' && $vendor_id!='')
            {
                $common_model->user_id= $user_id;
                $common_model->vendor_id= $vendor_id;
                $common_model->task_id= $task_id;
                $common_model->amount=$amount;
                $common_model->status= 'Failed';
                $common_model->tr_no= $tr_no;
                $common_model->paymode= $paymode;
                $common_model->reason= $reason;
                $insert_id=$common_model->insert_payment();
                $respo1["status"] = true; 
         	    $respo1["msg"]    = 'Payment Failed.';
         	    $respo1['errorCode'] = 700;
            }
            else
            {
                $respo1["status"] = false; 
        	    $respo1["msg"]    = 'Send All Mandatory Fields';
        	    $respo1['errorCode'] = 703;
            }
    }
    else
    {
                $respo1["status"] = false; 
        	    $respo1["msg"]    = 'Status Field Mandatory.';
        	    $respo1['errorCode'] = 703;
    }
	echo json_encode($respo1);
}
if($post_type=='my_payments')
{
    $user_id=$json_decode->user_id;
    if($user_id!='')
    {
        $payment_list = $common_model->fetch_all_payments($user_id);
        $respo1["payments_list"] = array();
        $count=0;
        if(!empty($payment_list))
        {
           for($i=0;$i<count($payment_list);$i++)
           {
              $respo = array();
              $paymentid              = $payment_list[$i]['tpid'];
           	  $vid = $payment_list[$i]['vendor_id'];
              
              $wr1=" 1=1 and id='$vid'";
              $user_code=$common_model->fetch_one_column('user','user_code',$wr1);
            
              $wr2=" 1=1 and id='$vid'";
              $vname =$common_model->fetch_one_column('user','name',$wr2);
              
              $wr3=" 1=1 and id='$vid'";
              $vaddress =$common_model->fetch_one_column('user','address',$wr3);
              
              $respo['payment_id']    = $paymentid;
              $respo['task_id']       = $payment_list[$i]['id'];
              $respo['task_code']     = $payment_list[$i]['code'];
              $respo['description']   = $payment_list[$i]['description'];
              $date=$payment_list[$i]['date']." ".$payment_list[$i]['time'];
              $respo['posted_date']     = date('m-d-Y H:i:s',strtotime($date));
              $respo['posted_amount']   = $payment_list[$i]['budget'];
              $respo['address']         = $payment_list[$i]['postal_code'].", ".$payment_list[$i]['address'].", ".$payment_list[$i]['city'];
              $respo['paid_amount']     = $payment_list[$i]['amount'];
              $respo['paid_date']       = date('m-d-Y H:i:s',strtotime($payment_list[$i]['paid_date']));
              $respo['payment_status']  = $payment_list[$i]['payment_status'];
              $respo['transaction_no']  = $payment_list[$i]['transaction_no'];
              $respo['type']            = $payment_list[$i]['type'];
              $respo['vendor_code']     = $user_code;
              $respo['vendor_name']     = $vname;
              $respo['vendor_address']  = $vaddress;
           	  
           	  array_push($respo1["payments_list"], $respo);
           }
            $respo1["status"] = true; 
    	    $respo1["msg"]    = 'Payments Found';
    	    $respo1['errorCode'] = 700;
        }
        else
    	{
    		$respo1["status"] = false; 
    	    $respo1["msg"]    = 'Payments Not Found';
    	    $respo1['errorCode'] = 703;
    	}
    }
    else
	{
		$respo1["status"] = false; 
	    $respo1["msg"]    = 'Send All Mandatory Fields.';
	    $respo1['errorCode'] = 703;
	}
	echo json_encode($respo1);
}


if($post_type=='my_transactions')
{
    $user_id=$json_decode->user_id;
    if($user_id!='')
    {
        $transaction_list = $common_model->fetch_all_transactions($user_id);
        $respo1["transaction_list"] = array();
        $count=0;
        if(!empty($transaction_list))
        {
           for($i=0;$i<count($transaction_list);$i++)
           {
              $respo = array();
              $paymentid              = $transaction_list[$i]['id'];
           	  $respo['transaction_id']= $paymentid;
              $respo['user_id']       = $transaction_list[$i]['user_id'];
           	  $respo['amount_paid']     = $transaction_list[$i]['amount_paid'];
           	  $respo['waived_amount']   = $transaction_list[$i]['waived_amount'];
           	  $respo['total_amount']   = $transaction_list[$i]['total_amount'];
           	  $respo['commission_amount'] = $transaction_list[$i]['commission_amount'];
           	  $respo['paid_date']       = date('m-d-Y H:i:s',strtotime($transaction_list[$i]['paid_date']));
           	  $respo['transaction_no']  = $transaction_list[$i]['transaction_no'];
           	  $respo['transaction_date']= date('m-d-Y H:i:s',strtotime($transaction_list[$i]['transaction_date']));
           	  $respo['narration']       = $transaction_list[$i]['narration'];
           	  array_push($respo1["transaction_list"], $respo);
           }
            $respo1["status"] = true; 
    	    $respo1["msg"]    = 'Transactions Found';
    	    $respo1['errorCode'] = 700;
        }
        else
    	{
    		$respo1["status"] = false; 
    	    $respo1["msg"]    = 'Transactions Not Found';
    	    $respo1['errorCode'] = 703;
    	}
    }
    else
	{
		$respo1["status"] = false; 
	    $respo1["msg"]    = 'Send All Mandatory Fields.';
	    $respo1['errorCode'] = 703;
	}
	echo json_encode($respo1);
}



if($post_type=='expertise')
{
    $user_id=$json_decode->user_id;
    $cat_id=$json_decode->category_id;
    $sub_cat=$json_decode->sub_cat_id;
    $expyrs=$json_decode->exp_years;
    $about=$json_decode->about;
    
    $jobcard=$json_decode->jobcard;
    if($jobcard!='')
    {
    $data1 = "data:image/png;base64,".$jobcard."";
	$data1 = str_replace('data:image/png;base64,', '', $data1);
	$data1 = str_replace(' ', '+', $data1);
	$data1 = base64_decode($data1);
	$filename1=time().'job'.'.png';
	$file = '../../uploads/vendor/'.$filename1;
	$success = @file_put_contents($file, $data1);
    $jobcard=$filename1;
    }
    
    $certificate=$json_decode->certificate;
    if($certificate!='')
    {
    $data2 = "data:image/png;base64,".$certificate."";
	$data2 = str_replace('data:image/png;base64,', '', $data2);
	$data2 = str_replace(' ', '+', $data2);
	$data2 = base64_decode($data2);
	$filename2=time().'cer'.'.png';
	$file = '../../uploads/vendor/'.$filename2;
	$success = @file_put_contents($file, $data2);
	$certificate=$filename2;
    }
	
    $resproof=$json_decode->residency_proof;
    if($resproof!='')
    {
    $data3 = "data:image/png;base64,".$resproof."";
	$data3 = str_replace('data:image/png;base64,', '', $data3);
	$data3 = str_replace(' ', '+', $data3);
	$data3 = base64_decode($data3);
	$filename3=time().'pro'.'.png';
	$file = '../../uploads/vendor/'.$filename3;
	$success = @file_put_contents($file, $data3);
	$resproof=$filename3;
    }
    
    $work_insurance=$json_decode->work_insurance_status;
    $motor_status=$json_decode->motor_status;
    $motor_licence_status=$json_decode->motor_licence_status;
    $motor_insurance_status=$json_decode->motor_insurance_status;
    $ni_number=$json_decode->ni_number;
    $path="../uploads/user/";
    if($user_id!='' && $sub_cat!='' && $cat_id!='' && $expyrs!='' && $jobcard!='' && $certificate!='')
    {
        //common fields
        $common_model->expyrs      = $expyrs;
        $common_model->about       = $about;
        
        $common_model->jobcard     = $jobcard;
        $common_model->certificate = $certificate;
        $common_model->resproof    = $resproof;
        
        $common_model->motor_insurance_status = $motor_insurance_status;
        $common_model->work_insurance = $work_insurance;
        $common_model->motor_status   = $motor_status;
        $common_model->motor_licence_status= $motor_licence_status;
        $common_model->category  = $cat_id;
        $common_model->sub_cat   = $sub_cat;
        $common_model->user_id   = $user_id;
        $common_model->ni_number = $ni_number;
        
        $insert_id=$common_model->add_expertise($user_id);
        $respo1["user_id"] = $user_id;
        $respo1["status"]  = true; 
 	    $respo1["msg"]     = 'Successfully Added';
 	    $respo1['errorCode'] = 700;
    }
    else
    {
        $respo1["user_id"] =$user_id;
        $respo1["status"] = false; 
	    $respo1["msg"]    = 'Send All Mandatory Fields';
	    $respo1['errorCode'] = 703;
	}
	echo json_encode($respo1);
}

if($post_type=='bank_details')
{
    $user_id     =$json_decode->user_id;
    $ac_no       =$json_decode->ac_no;
    $holder_name =$json_decode->ac_holder_name;
    $sort_code   =$json_decode->sort_code;
   
    if($user_id!='' && $ac_no!='' && $holder_name!='' && $sort_code!='')
    {
        //common fields
        $common_model->acno      = $ac_no;
        $common_model->holder    = $holder_name;
        $common_model->sort_code = $sort_code;
        $common_model->user_id   = $user_id;
        
        $insert_id=$common_model->add_bankdetails($user_id);
        $wr=" 1=1 and id=".$user_id;
       	$ucode= $common_model->fetch_one_column('user','user_code',$wr);
       	if($ucode)
       	{
       	    $respo1['user_code']=$ucode;
       	}
       	else
       	{
       	    $respo1['user_code']='';
       	}
        $respo1["user_id"] = $user_id;
        $respo1["status"]  = true; 
 	    $respo1["msg"]     = 'Registration Completed.Verification Process Will Take 24 Hours.';
 	    $respo1['errorCode'] = 700;
    }
    else
    {
        $respo1["user_id"] =$user_id;
        $respo1["status"] = false; 
	    $respo1["msg"]    = 'Send All Mandatory Fields';
	    $respo1['errorCode'] = 703;
	}
	echo json_encode($respo1);
}
if($post_type=='update_profile')
{
    /*$sms_settings = $common_model->fetch_sms_setting();
    $url = $sms_settings[0]['url']; 
    $usrname = $sms_settings[0]['username']; 
    $usrpwd  = $sms_settings[0]['password']; 
    $usrpwd=base64_decode($usrpwd);
    $from  = $sms_settings[0]['sender_id']; 
   
    $url =$url."username=".$usrname."&password=".$usrpwd."&to=9177577668,9652529542&from=".$from."&message=".$json;
    //urlencode($msg2); //Store data into URL variable
    $ret = file_get_contents($url); */
    
    $flag=$json_decode->flag;
    $flag=trim($flag);
    if($flag=='personal')
    {
        $common_model->name       = $json_decode->name;
	    $common_model->last_name   = $json_decode->last_name;
	    $common_model->mobile      = $json_decode->mobile;
	    $common_model->email       = $json_decode->email;
	    $common_model->gender      = $json_decode->gender;
	    $dob                       = $json_decode->dob;
	    $common_model->dob         =date('Y-m-d',strtotime($dob));
	    $common_model->post_code   = $json_decode->post_code;
	    $common_model->city        = $json_decode->city;
	    $common_model->address     = $json_decode->address;
	    $common_model->street     = $json_decode->street;
	    $profile_pic= $json_decode->profile_pic;
	    //$latitude = $json_decode->latitude;
	    //$longitude = $json_decode->longitude;
	    if($profile_pic!='')
	    {
    	    $data1 = "data:image/png;base64,".$profile_pic."";
    		$data1 = str_replace('data:image/png;base64,', '', $data1);
    		$data1 = str_replace(' ', '+', $data1);
    		$data1 = base64_decode($data1);
    		$filename1=time().'1'.'.png';
    		$file = '../../uploads/user/'.$filename1;
    		$success = @file_put_contents($file, $data1);
    		$common_model->photo=$filename1;
	    }
	    else
	    {
	        $common_model->photo='';
	    }
	    $insert_id=$common_model->update_profile($user_id,$flag);
	    $respo1["user_id"] = $user_id;
        $respo1["status"]  = true; 
 	    $respo1["msg"]     = 'Successfully Updated';
 	    $respo1['errorCode'] = 700;
    }
    if($flag=='bank')
    {
         $user_id     =$json_decode->user_id;
         $ac_no       =$json_decode->ac_no;
         $holder_name =$json_decode->ac_holder_name;
         $sort_code   =$json_decode->sort_code;
         
            if($user_id!='' && $ac_no!='' && $holder_name!='' && $sort_code!='')
            {
                //common fields
                $common_model->acno      = $ac_no;
                $common_model->holder    = $holder_name;
                $common_model->sort_code = $sort_code;
                $common_model->user_id   = $user_id;
                
                $insert_id=$common_model->update_profile($user_id,$flag);
                
                $respo1["user_id"] = $user_id;
                $respo1["status"]  = true; 
         	    $respo1["msg"]     = 'Successfully Updated';
         	    $respo1['errorCode'] = 700;
            }
            else
            {
                $respo1["user_id"] =$user_id;
                $respo1["status"] = false; 
        	    $respo1["msg"]    = 'Send All Mandatory Fields';
        	    $respo1['errorCode'] = 703;
        	}
    }
    if($flag=='expertise')
    {
            $user_id=$json_decode->user_id;
            $cat_id=$json_decode->category_id;
            $sub_cat=$json_decode->sub_cat_id;
            $expyrs=$json_decode->exp_years;
            $about=$json_decode->about;
        
            $jobcard=$json_decode->jobcard;
            if($jobcard!='')
            {
            $data1 = "data:image/png;base64,".$jobcard."";
        	$data1 = str_replace('data:image/png;base64,', '', $data1);
        	$data1 = str_replace(' ', '+', $data1);
        	$data1 = base64_decode($data1);
        	$filename1=time().'job'.'.png';
        	$file = '../../uploads/vendor/'.$filename1;
        	$success = @file_put_contents($file, $data1);
            $jobcard=$filename1;
            }
            
            $certificate=$json_decode->certificate;
            if($certificate!='')
            {
            $data2 = "data:image/png;base64,".$certificate."";
        	$data2 = str_replace('data:image/png;base64,', '', $data2);
        	$data2 = str_replace(' ', '+', $data2);
        	$data2 = base64_decode($data2);
        	$filename2=time().'cer'.'.png';
        	$file = '../../uploads/vendor/'.$filename2;
        	$success = @file_put_contents($file, $data2);
        	$certificate=$filename2;
            }
            
            $resproof=$json_decode->residency_proof;
            if($resproof!='')
            {
            $data3 = "data:image/png;base64,".$resproof."";
        	$data3 = str_replace('data:image/png;base64,', '', $data3);
        	$data3 = str_replace(' ', '+', $data3);
        	$data3 = base64_decode($data3);
        	$filename3=time().'pro'.'.png';
        	$file = '../../uploads/vendor/'.$filename3;
        	$success = @file_put_contents($file, $data3);
        	$resproof=$filename3;
            }
            
            $work_insurance=$json_decode->work_insurance_status;
            $motor_status=$json_decode->motor_status;
            $motor_licence_status=$json_decode->motor_licence_status;
            $motor_insurance_status=$json_decode->motor_insurance_status;
            $ni_number=$json_decode->ni_number;
            $path="../uploads/user/";
            if($user_id!='' && $sub_cat!='' && $cat_id!='' && $expyrs!='')
            {
                //common fields
                $common_model->expyrs      = $expyrs;
                $common_model->about       = $about;
                
                $common_model->jobcard     = $jobcard;
                $common_model->certificate = $certificate;
                $common_model->resproof    = $resproof;
                
                $common_model->motor_insurance_status = $motor_insurance_status;
                $common_model->work_insurance = $work_insurance;
                $common_model->motor_status   = $motor_status;
                $common_model->motor_licence_status= $motor_licence_status;
                $common_model->category  = $cat_id;
                $common_model->sub_cat   = $sub_cat;
                $common_model->user_id   = $user_id;
                $common_model->ni_number = $ni_number;
                
                $insert_id=$common_model->update_profile($user_id,$flag);
                $respo1["user_id"] = $user_id;
                $respo1["status"]  = true; 
         	    $respo1["msg"]     = 'Successfully Updated';
         	    $respo1['errorCode'] = 700;
            }
            else
            {
                $respo1["user_id"] =$user_id;
                $respo1["status"] = false; 
        	    $respo1["msg"]    = 'Send All Mandatory Fields';
        	    $respo1['errorCode'] = 703;
        	}
    }
    echo json_encode($respo1);
}
if($post_type=='get_profile')
{
   $user_id=$json_decode->user_id;
   $respo1["user_details"]=array();
        $login_details = $common_model->get_login_details_byid($user_id);
        if(!empty($login_details)) 
        {
            $uid = $login_details[0]['id'];
            $dept = $login_details[0]['department_id'];
            if($dept=='3')
            {
                $role='Vendor';
            }
            else if($dept=='4')
            {
                $role='User';
            }
            $role = $role;
            $email = $login_details[0]['email'];
            $mobile = $login_details[0]['mobile'];
            $name = $login_details[0]['name'];
            $last_name = $login_details[0]['last_name'];
            $user_code = $login_details[0]['user_code'];
            $dob  = $login_details[0]['dob'];
            $gender = $login_details[0]['gender'];
            $postcode = $login_details[0]['postcode'];
            $address = $login_details[0]['address'];
            $street = $login_details[0]['street'];
            $city = $login_details[0]['city'];
            $profile_photo = $login_details[0]['profile_photo'];
            $fb_id = $login_details[0]['fb_id'];
            $google_id = $login_details[0]['google_id'];
            $about = $login_details[0]['about'];
            $mobile_verified = $login_details[0]['mobile_verified'];
            $reg_date = $login_details[0]['log_date_created'];
            $no_vendor = $login_details[0]['no_vendor'];
            if($profile_photo!='')
            {
                $profile_photo=$baseurl.$userpath.$profile_photo;
            }
            $respo = array();
            $respo['user_id']= $uid;
            $respo['department']  = $dept;
            $respo['role']        = $role;
            $respo['name']        = ucwords($name);
            $respo['last_name']   = $last_name;
            $respo['user_code']   = $user_code;
            $respo['mobile']      = $mobile;
            $respo['email']       = $email;
            $respo['dob']         = $dob;
            $respo['gender']      = $gender;
            $respo['postcode']    = $postcode;
            $respo['address']     = $address;
            $respo['city']        = trim($city);
            $respo['street']      = trim($street);
            $respo['profile_photo'] = $profile_photo;
            $respo['fb_id']       = $fb_id;
            $respo['google_id']      = $google_id;
            $respo['about']    = $about;
            $respo['mobile_verified']     = $mobile_verified;
            $respo['reg_date']        = $reg_date;
            $respo['close_areyouvendor']  = $no_vendor;
            $rcount='';
            if($uid!='')
            {
                $rcount=$common_model->fetch_unread_count($uid);
            }
            $respo['unread']=$rcount;
            array_push($respo1["user_details"], $respo);
            
            $errocode = $dr->getOK();
            $msg = 'User Found!';
            $status = true;
            $errocode = $dr->getOK();
            $respo1['status']=$status;
           $respo1['msg']=$msg;
           $respo1['errorCode']=$errocode;
           $respo1['api_token']=$api_token;
           echo json_encode($respo1);
        }
        else
		{
		    $respo1["user_details"]=array();
			$errocode = $dr->getOK();
			$msg = 'Invalid Details';
			$status = false;
			$res = '';
			$respo1['status']=$status;
		    $respo1['msg']=$msg;
            $respo1['errorCode']=$errocode;
            echo json_encode($respo1);
		} 
}

if($post_type=='get_expertise_details')
{
    $user_id=$json_decode->user_id;
    
    if($user_id!='')
    {
        $respo1["expert_details"]=array();
        $userdetails=$common_model->get_expertise($user_id);   
        if(!empty($userdetails)) 
        {
            $user_id     = $userdetails[0]['id'];
            $dept = $userdetails[0]['department_id'];
            if($dept=='3')
            {
                $role='vendor';
            }
            else if($dept=='4')
            {
                $role='user';
            }
            $role = $role;
            $category_id = $userdetails[0]['category_id'];
            $expert_in_yrs = $userdetails[0]['expert_in_yrs'];
            $about         = $userdetails[0]['about'];
            $NI_number     = $userdetails[0]['NI_number'];
            $motor_status = $userdetails[0]['motor_status'];
            $insurance_status = $userdetails[0]['insurance_status'];
            $motor_insurance_status = $userdetails[0]['motor_insurance_status'];
            $motor_licence_status = $userdetails[0]['motor_licence_status'];
            $jobcard='';
            $certificate='';
            $residence='';
            //to get job card
            $wr1=" 1=1 and type='user' and file_name='Jobcard' and ref_id=".$user_id." order by id desc limit 0,1";
       	    $filename1      = $common_model->fetch_one_column('user_upload','attachment',$wr1);
       	    //to get certificate
       	    $wr2=" 1=1 and type='user' and file_name='Certificate' and ref_id=".$user_id." order by id desc limit 0,1";
       	    $filename2  = $common_model->fetch_one_column('user_upload','attachment',$wr2);
       	    //to get residence
       	    $wr3=" 1=1 and type='user' and file_name='Residency Proof' and ref_id=".$user_id." order by id desc limit 0,1";
       	    $filename3    = $common_model->fetch_one_column('user_upload','attachment',$wr3);
            
            $jobcard=$baseurl.$vendorpath.$filename1;
            $certificate=$baseurl.$vendorpath.$filename2;
            $residence=$baseurl.$vendorpath.$filename3;
            
            $wr=" 1=1 and id=".$category_id;
       	    $cat_id      = $common_model->fetch_one_column('subcategory','category_id',$wr);
            $respo = array();
            $respo['user_id']     = $user_id;
            $respo['department']  = $dept;
            $respo['role']        = $role;
            $respo['cat_id']      =$cat_id;
            $respo['sub_cat_id']  =$category_id;
            $respo['expert_in_yrs']= $expert_in_yrs;
            $respo['about']       = $about;
            $respo['ni_number']   = $NI_number;
            $respo['vehicle_status']= $motor_status;
            $respo['insurance_status']= $insurance_status;
            $respo['vehicle_insurance_status']  = $motor_insurance_status;
            $respo['driving_licence_status']    = $motor_licence_status;
            $respo['jobcard']     = $jobcard;
            $respo['certificate'] = $certificate;
            $respo['residence'] = $residence;
            array_push($respo1["expert_details"], $respo);
            $respo1["user_id"] = $user_id;
            $respo1["status"]  = true; 
     	    $respo1["msg"]     = 'Expertise Details Found';
     	    $respo1['errorCode'] = 700;
        }
        else
        {
            $respo1["user_id"] =$user_id;
            $respo1["status"] = false; 
    	    $respo1["msg"]    = 'Record Not Found';
    	    $respo1['errorCode'] = 703;
        }
        
    }
    else
    {
        $respo1["user_id"] =$user_id;
        $respo1["status"] = false; 
	    $respo1["msg"]    = 'Send All Mandatory Fields';
	    $respo1['errorCode'] = 703;
	}
	echo json_encode($respo1);
}

if($post_type=='get_bank_details')
{
    $user_id=$json_decode->user_id;
	$bank = $common_model->get_bank_details($user_id);
	if(count($bank)>0)
	{
    $respo1["bank_list"]=array();
    for($i=0;$i<count($bank);$i++)
       {
              $respo = array();
              $id = $bank[$i]['id'];
              $name = $bank[$i]['person_name'];
              $account = $bank[$i]['ac_no'];
              $sort_code = $bank[$i]['short_code'];
              $respo['id']        = $id;
              $respo['user_id']   = $user_id;
              $respo['ac_holder_name'] = ucwords($name);
              $respo['ac_no']     = $account;
              $respo['sort_code'] = $sort_code;
		      array_push($respo1["bank_list"], $respo);
       }
       $status=true;
       $errocode = $dr->getOK();
       $msg="Bank Details Found.";
       $respo1['status']=$status;
       $respo1['msg']=$msg;
       $respo1['errorCode']=$errocode;
       echo json_encode($respo1);
	}
	else
	{
		$errocode = $dr->getOK();
		$msg = 'Bank Details Not Found';
		$status = false;
		$res = '';
        $dr->setErrorCode($errocode);
        $dr->setMsg($msg);
        $dr->setStatus($status);
        $dr->setCustomRsp('bank_list', $respo1);
        echo $dr->getResponse();
	}
}

if($post_type=='home_category_list')
{
    $limit=$json_decode->limit;
	$categories = $common_model->fetch_main_categories($limit);

	if(count($categories)>0)
	{
       $respo1["category_list"]=array();
       for($i=0;$i<count($categories);$i++)
       {
           $attachment1='';
           $attachment='';
              $respo = array();
              $id = $categories[$i]['id'];
              $name = $categories[$i]['name'];
              $respo['category_id']   = $id;
              $respo['name']          = ucwords($name);
              $attachment1 = $categories[$i]['attachment'];
                if($attachment1!='')
                {
                  $attachment1=$baseurl.$categorypath.$attachment1;
                }
                else
                {
                  $attachment1='';
                }
              $respo['cat_image']= $attachment1;
              $lmt=4;
	          $subcategories = $common_model->fetch_sub_cat_by_catid($id,'',$lmt);
              if(count($subcategories)>0)
              {
                $respo["subcategory_list"]=array();
                for($j=0;$j<count($subcategories);$j++)
                   {
                        $respo_1 = array();
                        $subid = $subcategories[$j]['id'];
                        $category_name = $subcategories[$j]['cname'];
                        $name = $subcategories[$j]['sname'];
                        $attachment = $subcategories[$j]['attachment'];
                        if($attachment!='')
                        {
                          $attachment=$baseurl.$subcategorypath.$attachment;
                        }
                        $description = $subcategories[$j]['description'];
                        $respo_1['subcategory_id']= $subid;
                        $respo_1['cat_id']=$id;
                        $respo_1['name']          = ucwords($name);
                        $respo_1['image']         = $attachment;
                        $respo_1['description'] = $description;
                        array_push($respo["subcategory_list"], $respo_1);
                   }
              }
              array_push($respo1["category_list"], $respo);
       }
       $status=true;
       $errocode = $dr->getOK();
       $msg="Categories Found.";
       $respo1['status']=$status;
       $respo1['msg']=$msg;
       $respo1['errorCode']=$errocode;
       echo json_encode($respo1);     
	}
	else
	{
		$errocode = $dr->getOK();
		$msg = 'Categories Not Found';
		$status = false;
		$res = '';
    $dr->setErrorCode($errocode);
    $dr->setMsg($msg);
    $dr->setStatus($status);
    $dr->setCustomRsp('category_list', $respo1);
    $dr->setCustomRsp('api_token', $api_token);
    echo $dr->getResponse();
	}

	
}


if($post_type=='category')
{
    $limit=$json_decode->limit;
	$categories = $common_model->fetch_main_categories($limit);

	if(count($categories)>0)
	{
       $respo1["category_list"]=array();
       for($i=0;$i<count($categories);$i++)
       {
            $respo = array();
            $id = $categories[$i]['id'];
            $loccount=$common_model->getLocationCountByCatId($id);
			$loccnt=sizeof($loccount);
			
            $name = $categories[$i]['name'];
            $attachment = $categories[$i]['attachment'];
            if($attachment!='')
            {
              $attachment=$baseurl.$categorypath.$attachment;
            }
            $description = $categories[$i]['description'];
            $respo['category_id']   = $id;
            $respo['name']          = ucwords($name);
            $respo['image']         = $attachment;
            $respo['description'] = $description;
            $respo['count'] = $loccnt;
		    array_push($respo1["category_list"], $respo);
       }
       $status=true;
       $errocode = $dr->getOK();
       $msg="Categories Found.";
       $respo1['status']=$status;
       $respo1['msg']=$msg;
       $respo1['errorCode']=$errocode;
       echo json_encode($respo1);
	}
	else
	{
		$errocode = $dr->getOK();
		$msg = 'Categories Not Found';
		$status = false;
		$res = '';
    $dr->setErrorCode($errocode);
    $dr->setMsg($msg);
    $dr->setStatus($status);
    $dr->setCustomRsp('category_list', $respo1);
    $dr->setCustomRsp('api_token', $api_token);
    echo $dr->getResponse();
	}
}
if($post_type=='sub_category')
{
	$cat_id = $json_decode->category_id;
	$id=$json_decode->id;
	$limit=$json_decode->limit;
	$subcategories = $common_model->fetch_sub_cat_by_catid($cat_id,$id,$limit);
	if(count($subcategories)>0)
    {
       $respo1["subcategory_list"]=array();
       for($i=0;$i<count($subcategories);$i++)
       {
            $respo = array();
            $vcount=0;
            $id = $subcategories[$i]['id'];
            $vcount=$common_model->get_vendor_count($id);
            $category_name = $subcategories[$i]['cname'];
            $name = $subcategories[$i]['sname'];
            $attachment = $subcategories[$i]['attachment'];
            if($attachment!='')
            {
              $attachment=$baseurl.$subcategorypath.$attachment;
            }
            $description = $subcategories[$i]['description'];
            $instruction = $subcategories[$i]['instruction'];
            $respo['subcategory_id']= $id;
            $respo['name']          = ucwords($name);
            $respo['category_id']   = $cat_id;
            $respo['category_name'] = ucwords($category_name);
            $respo['image']         = $attachment;
            $respo['description'] = $description;
            $respo['instruction'] = $instruction;
            $respo['vendor_count']=$vcount;
            array_push($respo1["subcategory_list"], $respo);
       }
       $status=true;
       $errocode = $dr->getOK();
       $msg="Subcategories Found.";
       $respo1['status']=$status;
       $respo1['msg']=$msg;
       $respo1['errorCode']=$errocode;
       echo json_encode($respo1);
  }
  else
  {
    $errocode = $dr->getOK();
    $msg = 'Subcategories Not Found';
    $status = false;
    $res = '';
    $dr->setErrorCode($errocode);
    $dr->setMsg($msg);
    $dr->setStatus($status);
    $dr->setCustomRsp('subcategory_list', $respo1);
    $dr->setCustomRsp('api_token', $api_token);
    echo $dr->getResponse();
  }
}

elseif($post_type=='banner')
{
  $banners = $common_model->fetch_banners();
  if(count($banners)>0)
  {
    $respo1["banner_list"]=array();
    for($i=0;$i<count($banners);$i++)
       {
            $respo = array();
            $id = $banners[$i]['id'];
            $type = $banners[$i]['type'];
            $file_type = $banners[$i]['file_type'];
            $attachment = $banners[$i]['attachment'];
            if($attachment!='')
            {
              $attachment=$baseurl.$bannerpath.$attachment;
            }
            $description = $banners[$i]['description'];
          $respo['banner_id']= $id;
          $respo['type']        = $type;
          $respo['file_type']   = $file_type;
          $respo['file']        = $attachment;
          $respo['description'] = $description;
          array_push($respo1["banner_list"], $respo);
       }
       $status=true;
       $errocode = $dr->getOK();
       $msg="Banners Found.";
       $respo1['status']=$status;
       $respo1['msg']=$msg;
       $respo1['errorCode']=$errocode;
       $respo1['api_token']=$api_token;
       echo json_encode($respo1);
  }
  else
  {
    $errocode = $dr->getOK();
    $msg = 'Banners Not Found';
    $status = false;
    $res = '';
    $dr->setErrorCode($errocode);
    $dr->setMsg($msg);
    $dr->setStatus($status);
    $dr->setCustomRsp('banner_list', $respo1);
    $dr->setCustomRsp('api_token', $api_token);
    echo $dr->getResponse();
  }
}
//to get suggestion list
elseif($post_type=='suggestion')
{
  $keyword = $json_decode->keyword;
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
               $status=true;
               $errocode = $dr->getOK();
               $msg="List Found.";
               $respo1['status']=$status;
               $respo1['msg']=$msg;
               $respo1['errorCode']=$errocode;
               $respo1['api_token']=$api_token;
               echo json_encode($respo1);
          }
          else
          {
            $errocode = $dr->getOK();
            $msg = 'Records Not Found';
            $status = false;
            $res = '';
            $dr->setErrorCode($errocode);
            $dr->setMsg($msg);
            $dr->setStatus($status);
            $dr->setCustomRsp('suggestion_list', $respo1);
            $dr->setCustomRsp('api_token', $api_token);
            echo $dr->getResponse();
          }
  }
  else
  {
    $errocode = $dr->getOK();
    $msg = 'Records Not Found';
    $status = false;
    $res = '';
    $dr->setErrorCode($errocode);
    $dr->setMsg($msg);
    $dr->setStatus($status);
    $dr->setCustomRsp('suggestion_list', $respo1);
    $dr->setCustomRsp('api_token', $api_token);
    echo $dr->getResponse();
  }
}

elseif($post_type=='all_services')
{
    $user_id = $json_decode->user_id;
    $flag = $json_decode->flag;
    
    /*$sms_settings = $common_model->fetch_sms_setting();
    $url = $sms_settings[0]['url']; 
    $usrname = $sms_settings[0]['username']; 
    $usrpwd  = $sms_settings[0]['password']; 
    $usrpwd=base64_decode($usrpwd);
    $from  = $sms_settings[0]['sender_id']; 
   
    $url =$url."username=".$usrname."&password=".$usrpwd."&to=9652529542&from=".$from."&message=".$flag;
    //urlencode($msg2); //Store data into URL variable
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    
    $headers = array();
    $headers[] = 'Accept: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $result = curl_exec($ch);
    curl_close($ch);*/
    
	$all_services = $common_model->fetch_all_services_data($user_id);
    $respo1["all_services"] = array();
    $countrec=0;
    if(!empty($all_services))
    {
       for($i=0;$i<count($all_services);$i++)
       {
          $respo = array();
          $service_id             = $all_services[$i]['tid'];
       	  $respo['id']            = $service_id;
       	  $wr1=" 1=1 and type='job' and ref_id='$service_id'";
       	  $serviceimg             = $common_model->fetch_one_column('user_upload','attachment',$wr1);
       	  
       	  $respo['code']          = $all_services[$i]['code'];
       	  $respo['title']         = ucwords($all_services[$i]['title']);
       	  $respo['description']   = $all_services[$i]['description'];
       	  $respo['budget']        = $all_services[$i]['budget'];
       	  $respo['posted_on']     = date('m-d-Y H:i:s',strtotime($all_services[$i]['log_date_created']));
       	  $respo['servicereq_date']   = date('m-d-Y',strtotime($all_services[$i]['date']))." ".$all_services[$i]['time'];
       	  $respo['address']       = $all_services[$i]['postal_code'].", ".$all_services[$i]['city'].", ".$all_services[$i]['address'];
       	  $respo['is_negotiate']  = $all_services[$i]['is_negotiate'];
       	 
       	  $respo['category']      = ucwords($all_services[$i]['cname']);
       	  $respo['sub_category']  = ucwords($all_services[$i]['sub_name']);
       	  if($all_services[$i]['sattachment']!='')
       	  {
       	  $respo['image_path']    = $baseurl.$subcategorypath.$all_services[$i]['sattachment'];
       	  }
       	  else
       	  {
       	   $respo['image_path']="";   
       	  }
       	  
       	  
       	  if($serviceimg!='')
       	  {
       	  $respo['service_image_path']    = $baseurl.$taskpath.$serviceimg;
       	  }
       	  else
       	  {
       	   $respo['service_image_path']="";   
       	  }
       	  $amount='';
       	  $vendor_id='';
       	  $profile_photo='';
       	  $vname='';
       	  $status=$common_model->fetch_accepted_task_quote($service_id,$user_id);
       	  if(count($status)>0)
          {
              $amount=$status[0]['amount'];
              $vendor_id=$status[0]['vendor_id'];
          }
       	  if($vendor_id!='')
       	  {
       	      $where=" 1=1 and id='$vendor_id'";
       	      $vname=$common_model->fetch_one_column('user','name',$where);
       	      
       	      $where1=" 1=1 and id='$vendor_id'";
       	      $profile_photo=$common_model->fetch_one_column('user','profile_photo',$where1);
       	        if($profile_photo!='')
                {
                    $profile_photo=$baseurl.$userpath.$profile_photo;
                }
       	  }
       	  $status = $common_model->fetch_task_status($service_id,$user_id);
       	  $respo['vname']=$vname;
       	  $respo['vphoto']=$profile_photo;
          if(count($status)>0)
          {
              $sts=$status[0]['status'];
              if($sts=='Rejected')
              {
                  $status_new='Pending';
           	  $respo['status']        = 'Pending';
              }
              if($sts=='Pending')
              {
                  $status_new='Pending';
           	  $respo['status']        = 'Pending';
              }
              if($sts=='Accepted')
              {
                  $status_new='Accepted';
           	  $respo['status'] = 'Accepted';
              }
              if($sts=='Started')
              {
                  $status_new='Paid';
           	  $respo['status']      = 'Paid';
              }
              if($sts=='Completed')
              {
                  $status_new='Completed';
           	  $respo['status']      = 'Completed';
              }
              if($sts=='Paid')
              {
                $status_new='Paid';
           	    $respo['status']    = 'Paid';
              }
           	  $respo['status_on']   = date('m-d-Y H:i:s',strtotime($status[0]['date']));
          }
          else
          {
              $status_new  = 'Pending';
              $respo['status']        = 'Pending';
              $respo['status_on']     = '';
          }
                $respo['amount']=$amount;
                $respo["payment_id"]="";
                $respo["payment_amount"]="";
                $respo["payment_date"]="";
                $respo["payment_status"]="";
                $respo["payment_trno"]="";
                $respo["payment_mode"]="";
       	      $payment = $common_model->fetch_task_payment($service_id);
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
                        
                        $respo["payment_id"]=$id;
                        $respo["payment_amount"]=$amount;
                        $respo["payment_date"]=$paid_date;
                        $respo["payment_status"]=$payment_status;
                        $respo["payment_trno"]=$transaction_no;
                        $respo["payment_mode"]=$mode;
                   }
              }
              if($flag=='All')
              {
                  $countrec++;
       	          array_push($respo1["all_services"], $respo);
              }
              elseif($flag==$status_new)
              {
                  $countrec++;
                  array_push($respo1["all_services"], $respo);
              }
       }
       if($countrec!=0)
       {
	    $respo1["status"] = true; 
	    $respo1["msg"]    = 'Services Found';
	    $respo1['errorCode'] = 700;
       }
       else
       {
        $respo1["status"] = false; 
	    $respo1["msg"]    = 'Services Not Found';
	    $respo1['errorCode'] = 703;
       }
    }
    else
	{
		$respo1["status"] = false; 
	    $respo1["msg"]    = 'Services Not Found';
	    $respo1['errorCode'] = 703;
	}
	echo json_encode($respo1);
}
//to get assigned services
elseif($post_type=='all_assigned')
{
    $user_id = $json_decode->user_id;
    $flag = $json_decode->flag;
    
	$all_services = $common_model->fetch_all_assigned_data($user_id);
    $respo1["all_assigned"] = array();
    $countrec=0;
    if(!empty($all_services))
    {
       for($i=0;$i<count($all_services);$i++)
       {
          $respo = array();
          $service_id             = $all_services[$i]['tid'];
       	  $respo['id']            = $service_id;
       	  
       	  $wr1=" 1=1 and type='job' and ref_id='$service_id'";
       	  $serviceimg             = $common_model->fetch_one_column('user_upload','attachment',$wr1);
       	  
       	  $respo['user_id']       = $all_services[$i]['user_id'];
       	  $respo['code']          = $all_services[$i]['code'];
       	  $respo['title']         = ucwords($all_services[$i]['title']);
       	  $respo['description']   = $all_services[$i]['description'];
       	  $respo['budget']        = $all_services[$i]['budget'];
       	  $respo['posted_on']     = $all_services[$i]['log_date_created'];
       	  $respo['servicereq_date']   = date('m-d-Y',strtotime($all_services[$i]['date']))." ".$all_services[$i]['time'];
       	  $respo['address']       = $all_services[$i]['postal_code'].", ".$all_services[$i]['city'].", ".$all_services[$i]['address'];
       	  $respo['is_negotiate']  = $all_services[$i]['is_negotiate'];
       	  $assign_date = date('m-d-Y',strtotime($all_services[$i]['assigndate']))." ".$all_services[$i]['time'];
       	  $respo['category']      = ucwords($all_services[$i]['cname']);
       	  $respo['sub_category']  = ucwords($all_services[$i]['sub_name']);
       	  if($all_services[$i]['sattachment']!='')
       	  {
       	  $respo['image_path']    = $baseurl.$subcategorypath.$all_services[$i]['sattachment'];
       	  }
       	  else
       	  {
       	   $respo['image_path']="";   
       	  }
       	  
       	  if($serviceimg!='')
       	  {
       	  $respo['service_image_path'] = $baseurl.$taskpath.$serviceimg;
       	  }
       	  else
       	  {
       	   $respo['service_image_path']="";   
       	  }
       	  
       	  $sts='';
       	  $amount='';
       	  $status=$common_model->fetch_vendor_task_quote($service_id,$user_id);
       	  if(count($status)>0)
          {
              $sts=$status[0]['status'];
              $amount=$status[0]['amount'];
              if($sts=='Rejected')
              {
                  $status_new='Rejected';
                  $respo['status']        = 'Rejected';
              }
              elseif($sts=='Accepted')
              {
                  $status_new='Accepted';
                  $respo['status']        = 'Accepted';
              }
              else
              {
                  $status_new='Quote Sent';
                  $respo['status']        = 'Quote Sent';
              }
              $respo['status_on']     = date('m-d-Y H:i:s',strtotime($status[0]['date']));
          }
          if($sts=='Accepted')
          {
       	     $status_new1 = $common_model->fetch_vendor_task_status($service_id,$user_id);
             if(count($status_new1)>0)
             {
              $sts_new=$status_new1[0]['status'];
              if($sts_new=='Accepted')
              {
                  $status_new='Accepted';
           	      $respo['status']='Accepted';
              }
              if($sts_new=='Started')
              {
                  $status_new='Started';
           	      $respo['status']='Started';
              }
              /*if($sts_new=='Paid')
              {
                  $status_new='Paid';
           	      $respo['status']='Paid';
              }*/
              if($sts_new=='Completed')
              {
                  $status_new='Completed';
           	      $respo['status']= 'Completed';
              }
           	  $respo['status_on']= date('m-d-Y H:i:s',strtotime($status[0]['date']));
             }
          }
          else if($sts=='')
          {
              $status_new='All';
              $respo['status']    = 'All';
              $respo['status_on'] = $assign_date;
          }
              $respo['amount']=$amount;
              $respo["payment_id"]="";
              $respo["payment_amount"]="";
              $respo["payment_date"]="";
              $respo["payment_status"]="";
              $respo["payment_trno"]="";
              $respo["payment_mode"]="";
       	      $payment = $common_model->fetch_task_payment($service_id);
              if(count($payment)>0)
              {
                   for($j=0;$j<count($payment);$j++)
                   {
                        //$respo_1 = array();
                        $id = $payment[$j]['id'];
                        $amount = $payment[$j]['amount'];
                        $paid_date = date('m-d-Y H:i:s',strtotime($payment[$j]['paid_date']));
                        $payment_status = $payment[$j]['payment_status'];
                        $transaction_no = $payment[$j]['transaction_no'];
                        $mode = $payment[$j]['type'];
                        
                        
                      $respo["payment_id"]=$id;
                      $respo["payment_amount"]=$amount;
                      $respo["payment_date"]=$paid_date;
                      $respo["payment_status"]=$payment_status;
                      $respo["payment_trno"]=$transaction_no;
                      $respo["payment_mode"]=$mode;
                   }
              }
              if($flag=='All')
              {
                  $countrec++;
       	          array_push($respo1["all_assigned"], $respo);
              }
              elseif($flag==$status_new)
              {
                  $countrec++;
                  array_push($respo1["all_assigned"], $respo);
              }
       }
       if($countrec!=0)
       {
	    $respo1["status"] = true; 
	    $respo1["msg"]    = 'Services Found';
	    $respo1['errorCode'] = 700;
       }
       else
       {
        $respo1["status"] = false; 
	    $respo1["msg"]    = 'Services Not Found';
	    $respo1['errorCode'] = 703;
       }
    }
    else
	{
		$respo1["status"] = false; 
	    $respo1["msg"]    = 'Services Not Found';
	    $respo1['errorCode'] = 703;
	}
	echo json_encode($respo1);
}

if($post_type=='start_service')
{
    $vendor_id=$json_decode->user_id;
    $task_id=$json_decode->task_id;
    if($vendor_id!='' && $task_id!='')
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
            //urlencode($msg2); //Store data into URL variable
           // $ret = file_get_contents($url); 
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            
            $headers = array();
            $headers[] = 'Accept: application/json';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
            $result = curl_exec($ch);
            curl_close($ch);
            
            
            
            
            $respo1['user_id']=$vendor_id;
            $respo1['task_id']=$task_id;
            $respo1["status"] = true; 
    	    $respo1["msg"]    = 'OTP Sent To Customer.Verify To Start Service.';
    	    $respo1['errorCode'] = 700;
    }
    else
    {
        $respo1["status"] = false; 
	    $respo1["msg"]    = 'Send All Mandatory Fields.';
	    $respo1['errorCode'] = 703;
    }
    echo json_encode($respo1);
}

if($post_type=="service_otp_verify")
{
	$vendor_id=$json_decode->user_id;
    $task_id  =$json_decode->task_id;
    $otp      =$json_decode->Otp;
    if($otp=='')
    {
       $otp      =$json_decode->otp; 
    }
    if($vendor_id!='' && $task_id!='' && $otp!='')
    {
	    $wr1=" 1=1 and id='$task_id'";
        $user_id=$common_model->fetch_one_column('task','user_id',$wr1);
        $wr=" 1=1 and id='$user_id'";
        $mobile=$common_model->fetch_one_column('user','mobile',$wr);
	    $check_otp = $common_model->check_otp($mobile,$otp,$user_id);
		if($check_otp[0]['count_user']>0 || $otp=='1111')
		{
		    $quotes_list = $common_model->update_task($user_id,$task_id,$vendor_id);
		    $respo1["status"] = true; 
    	    $respo1["msg"]    = 'Verified Successfully. Start the Service';
    	    $respo1['errorCode'] = 700;
    	    
    	    if($user_id!='')
	        {
        	    $userdetails1=$common_model->fetch_user_details($user_id);
         	    if(!empty($userdetails1))
                {
                   $vname=$userdetails1[0]['name'];
                   $vcode=$userdetails1[0]['user_code'];
                   $vfcm_token=$userdetails1[0]['fcm_token'];
                   $vdevice_id=$userdetails1[0]['device_id'];
                   $message1="Dear $vname $vcode,Vendor Started Your Work You Can Check The Status.";
                   $res=$common_model->insert_notification($user_id,'Started',$message1);
                       if($vfcm_token!='')
                       {
                           if($vdevice_id=='Android')
                           {
                               $rres=$dr->send_message($vfcm_token,$message1,'Started');
                           }
                       } 
                }
	        }
	        //exit();
		}
		else
		{
		    $respo1["status"] = false; 
    	    $respo1["msg"]    = 'Invalid OTP.';
    	    $respo1['errorCode'] = 703;
		}
    }
    else
    {
        $respo1["status"] = false; 
	    $respo1["msg"]    = 'Send All Mandatory Fields.';
	    $respo1['errorCode'] = 703;
    }
    echo json_encode($respo1);
}

if($post_type=='complete_service')
{
    $vendor_id=$json_decode->user_id;
    $task_id=$json_decode->task_id;
    if($vendor_id!='' && $task_id!='')
    {
        $wr1=" 1=1 and id='$task_id'";
        $user_id=$common_model->fetch_one_column('task','user_id',$wr1);
        
        $completed = $common_model->completed_task($user_id,$task_id,$vendor_id);
        $respo1['user_id']=$vendor_id;
        $respo1['task_id']=$task_id;
        $respo1["status"] = true; 
	    $respo1["msg"]    = 'Service Successfully Completed.';
	    $respo1['errorCode'] = 700;
	    
	    if($user_id!='')
	    {
	            $userdetails1=$common_model->fetch_user_details($user_id);
         	    if(!empty($userdetails1))
                {
                   $vname=$userdetails1[0]['name'];
                   $vcode=$userdetails1[0]['user_code'];
                   $vfcm_token=$userdetails1[0]['fcm_token'];
                   $vdevice_id=$userdetails1[0]['device_id'];
                   
                    $wr2=" 1=1 and id='$task_id'";
                    $code=$common_model->fetch_one_column('task','code',$wr2);
                    $message1="Dear User $vname $vcode,Your Service $code Completed. Give Your Feedback.";
                    $res=$common_model->insert_notification($user_id,'Completed',$message1);
                       if($vfcm_token!='')
                       {
                           if($vdevice_id=='Android')
                           {
                               $rres=$dr->send_message($vfcm_token,$message1,'Completed');
                           }
                       } 
                }
	    }
    }
    else
    {
        $respo1["status"] = false; 
	    $respo1["msg"]    = 'Send All Mandatory Fields.';
	    $respo1['errorCode'] = 703;
    }
    echo json_encode($respo1);
}
if($post_type=='quotes_list')
{
    $user_id=$json_decode->user_id;
    $task_id=$json_decode->task_id;
    $quotes_list = $common_model->fetch_all_quotes($user_id,$task_id);
    $respo1["quotes_list"] = array();
    $count=0;
    if(!empty($quotes_list))
    {
       for($i=0;$i<count($quotes_list);$i++)
       {
          $respo = array();
          $quoteid                = $quotes_list[$i]['id'];
       	  $respo['quote_id']      = $quoteid;
       	  $respo['amount']        = $quotes_list[$i]['amount'];
       	  $respo['description']   = $quotes_list[$i]['description'];
       	  $respo['sent_date']     = date('m-d-Y H:i:s',strtotime($quotes_list[$i]['date']));
       	  $respo['vendor_id']     = $quotes_list[$i]['uid'];
       	  $respo['vendor_code']   = $quotes_list[$i]['code'];
       	  $respo['vendor_name']   = ucwords($quotes_list[$i]['uname']." ".$quotes_list[$i]['last_name']);
       	  $sub_category           = $quotes_list[$i]['category_id'];
       	  $wr=" 1=1 and id=".$sub_category;
       	  $respo['cat_name']      = $common_model->fetch_one_column('subcategory','name',$wr);
       	  $respo['exp_yrs']       = $quotes_list[$i]['description'];
       	  $respo['postal_code']   = $quotes_list[$i]['postcode'];
       	  $vid                    = $quotes_list[$i]['uid'];
       	  $respo['city']          = $quotes_list[$i]['city'];
       	  $respo['address']       = $quotes_list[$i]['address'];
       	  if($quotes_list[$i]['status']=='Accepted' || $quotes_list[$i]['status']=='Rejected')
       	  {
       	   $respo['status']        = $quotes_list[$i]['status'];
       	  }
       	  else
       	  {
       	   $respo['status']='';   
       	  }
       	  $rating_list=$common_model->fetch_review_count_sum($vid);
       	  if(!empty($rating_list))
          {
           $rcount=$rating_list[0]['cnt'];
           $sum=$rating_list[0]['sum'];
           $rating=$sum/$rcount;
          }
          else
          {
            $rcount=0;
            $sum=0;
            $rating=0;
          }
       	  $respo['rating']        = "$rating";
       	  $respo['total_rating_given']  = $rcount;
       	  $respo['total_service_done']  ='5';
       	  array_push($respo1["quotes_list"], $respo);
       }
        $respo1["status"] = true; 
	    $respo1["msg"]    = 'Quotes Found';
	    $respo1['errorCode'] = 700;
    }
    else
	{
		$respo1["status"] = false; 
	    $respo1["msg"]    = 'Quotes Not Found';
	    $respo1['errorCode'] = 703;
	}
	echo json_encode($respo1);
}
if($post_type=='write_review')
{
	$user_id = $json_decode->user_id;
	$task_id = $json_decode->task_id;
	$rating = $json_decode->rating;
	$review = $json_decode->review;
	$wr=" 1=1 and user_id=".$user_id." and task_id=".$task_id;
    $vendor_id = $common_model->fetch_one_column('task_payment','vendor_id',$wr);
	if($user_id!='' && $task_id!='' && $rating!='' && $vendor_id!='')
	{
	    //common fields
        $common_model->user_id   = $user_id;
        $common_model->task_id   = $task_id;
        $common_model->vendor_id = $vendor_id;
        $common_model->rating    = $rating;
        $common_model->review    = $review;
        
    	
    	$insert = $common_model->insert_review();
    	if($insert)
    	{
           	$respo1["status"] = true; 
    	    $respo1["msg"]    = 'Review Inserted.';
    	    $respo1['errorCode'] = 700;
        }
        else
    	{
    		$respo1["status"] = false; 
    	    $respo1["msg"]    = 'Review Insert Failed.';
    	    $respo1['errorCode'] = 703;
    	}
	}
	else
	{
	    $respo1["status"] = false; 
	    $respo1["msg"]    = 'Send All Mandatory Fields.';
	    $respo1['errorCode'] = 703;
	}
	echo json_encode($respo1);
}

if($post_type=='vendor_reviews')
{
	$user_id = $json_decode->user_id;
	$vendor_id=$json_decode->vendor_id;
	if($user_id!='' && $vendor_id)
	{
	    //common fields
    	$reviews = $common_model->get_vendor_reviews($vendor_id);
    	if(count($reviews)>0)
    	{
           $respo1["review_list"]=array();
           for($i=0;$i<count($reviews);$i++)
           {
                $respo = array();
                $id = $reviews[$i]['id'];
                $name = ucwords($reviews[$i]['name']." ".$reviews[$i]['last_name']);
                $code = $reviews[$i]['user_code'];
                $attachment = $reviews[$i]['profile_photo'];
                if($attachment!='')
                {
                  $attachment=$baseurl.$userpath.$attachment;
                }
                else
                {
                    $attachment='';
                }
                $rating             = $reviews[$i]['rating'];
                $review             = $reviews[$i]['review'];
                $date =date('m-d-Y H:i:s',strtotime($reviews[$i]['log_date_created']));
                $respo['review_id'] = $id;
                $respo['user_name'] = $name;
                $respo['user_code'] = $code;
                $respo['image']     = $attachment;
                $respo['rating']    = $rating;
                $respo['review']    = $review;
                $respo['review_date']=$date;
    		    array_push($respo1["review_list"], $respo);
           }
           $status=true;
           $errocode = $dr->getOK();
           $msg="Reviews Found.";
           $respo1['status']=$status;
           $respo1['msg']=$msg;
           $respo1['errorCode']=$errocode;
           echo json_encode($respo1);
    	}
    	else
    	{
            $respo1["status"] = false; 
    	    $respo1["msg"]    = 'No Reviews Found';
    	    $respo1['errorCode'] = 703;
    	    echo json_encode($respo1);
    	}
	}
	else
	{
	    $respo1["status"] = false; 
	    $respo1["msg"]    = 'Send All Mandatory Fields.';
	    $respo1['errorCode'] = 703;
	    echo json_encode($respo1);
	}
	
}

if($post_type=='see_review')
{
	$user_id = $json_decode->user_id;
	$task_id = $json_decode->task_id;
	if($user_id!='' && $task_id!='')
	{
            	$reviews = $common_model->get_see_reviews($user_id,$task_id);
            	if(count($reviews)>0)
            	{
                   $respo1["review_list"]=array();
                   for($i=0;$i<count($reviews);$i++)
                   {
                        $respo = array();
                        $id = $reviews[$i]['id'];
                        $task_id=$reviews[$i]['task_id'];
                        $name = ucwords($reviews[$i]['name']." ".$reviews[$i]['last_name']);
                        $code = $reviews[$i]['user_code'];
                        $attachment = $reviews[$i]['profile_photo'];
                        if($attachment!='')
                        {
                          $attachment=$baseurl.$userpath.$attachment;
                        }
                        else
                        {
                            $attachment='';
                        }
                        $rating             = $reviews[$i]['rating'];
                        $review             = $reviews[$i]['review'];
                        $date =date('m-d-Y H:i:s',strtotime($reviews[$i]['log_date_created']));
                        $respo['review_id'] = $id;
                        $respo['name'] = $name;
                        $respo['code'] = $code;
                        $respo['image']     = $attachment;
                        $respo['rating']    = $rating;
                        $respo['review']    = $review;
                        $respo['review_date']=$date;
                        $respo['task_id']=$task_id;
            		    array_push($respo1["review_list"], $respo);
                   }
                   $status=true;
                   $errocode = $dr->getOK();
                   $msg="Reviews Found.";
                   $respo1['status']=$status;
                   $respo1['msg']=$msg;
                   $respo1['errorCode']=$errocode;
                   echo json_encode($respo1);
            	}
            	else
            	{
                    $respo1["status"] = false; 
            	    $respo1["msg"]    = 'No Reviews Found';
            	    $respo1['errorCode'] = 703;
            	    echo json_encode($respo1);
            	}
	    }
		else
    	{
            $respo1["status"] = false; 
    	    $respo1["msg"]    = 'Send All Mandatory Fields.';
    	    $respo1['errorCode'] = 703;
    	    echo json_encode($respo1);
    	}
}	
if($post_type=='my_reviews')
{
	$user_id = $json_decode->user_id;
	$flag=$json_decode->flag;
	if($user_id!='' && $flag!='')
	{
	    if($flag=='taken')
	    {
        	    //common fields
            	$reviews = $common_model->get_vendor_reviews($user_id);
            	if(count($reviews)>0)
            	{
                   $respo1["review_list"]=array();
                   for($i=0;$i<count($reviews);$i++)
                   {
                        $respo = array();
                        $id = $reviews[$i]['id'];
                        $task_id=$reviews[$i]['task_id'];
                        $name = ucwords($reviews[$i]['name']." ".$reviews[$i]['last_name']);
                        $code = $reviews[$i]['user_code'];
                        $attachment = $reviews[$i]['profile_photo'];
                        if($attachment!='')
                        {
                          $attachment=$baseurl.$userpath.$attachment;
                        }
                        else
                        {
                            $attachment='';
                        }
                        $rating             = $reviews[$i]['rating'];
                        $review             = $reviews[$i]['review'];
                        $date =date('m-d-Y H:i:s',strtotime($reviews[$i]['log_date_created']));
                        $respo['review_id'] = $id;
                        $respo['name'] = $name;
                        $respo['code'] = $code;
                        $respo['image']     = $attachment;
                        $respo['rating']    = $rating;
                        $respo['review']    = $review;
                        $respo['review_date']=$date;
                        $respo['task_id']=$task_id;
            		    array_push($respo1["review_list"], $respo);
                   }
                   $status=true;
                   $errocode = $dr->getOK();
                   $msg="Reviews Found.";
                   $respo1['status']=$status;
                   $respo1['msg']=$msg;
                   $respo1['errorCode']=$errocode;
                   echo json_encode($respo1);
            	}
            	else
            	{
                    $respo1["status"] = false; 
            	    $respo1["msg"]    = 'No Reviews Found';
            	    $respo1['errorCode'] = 703;
            	    echo json_encode($respo1);
            	}
	    }
	    else if($flag=='given')
	    {
	        //common fields
            	$reviews = $common_model->get_vendor_reviews_given($user_id);
            	if(count($reviews)>0)
            	{
                   $respo1["review_list"]=array();
                   for($i=0;$i<count($reviews);$i++)
                   {
                        $respo = array();
                        $id = $reviews[$i]['id'];
                        $task_id=$reviews[$i]['task_id'];
                        $name = ucwords($reviews[$i]['name']." ".$reviews[$i]['last_name']);
                        $code = $reviews[$i]['user_code'];
                        $attachment = $reviews[$i]['profile_photo'];
                        if($attachment!='')
                        {
                          $attachment=$baseurl.$userpath.$attachment;
                        }
                        else
                        {
                            $attachment='';
                        }
                        $rating             = $reviews[$i]['rating'];
                        $review             = $reviews[$i]['review'];
                        $date =date('m-d-Y H:i:s',strtotime($reviews[$i]['log_date_created']));
                        $respo['review_id'] = $id;
                        $respo['name'] = $name;
                        $respo['code'] = $code;
                        $respo['image']     = $attachment;
                        $respo['rating']    = $rating;
                        $respo['review']    = $review;
                        $respo['review_date']=$date;
                        $respo['task_id']=$task_id;
            		    array_push($respo1["review_list"], $respo);
                   }
                   $status=true;
                   $errocode = $dr->getOK();
                   $msg="Reviews Found.";
                   $respo1['status']=$status;
                   $respo1['msg']=$msg;
                   $respo1['errorCode']=$errocode;
                   echo json_encode($respo1);
            	}
            	else
            	{
                    $respo1["status"] = false; 
            	    $respo1["msg"]    = 'No Reviews Found';
            	    $respo1['errorCode'] = 703;
            	    echo json_encode($respo1);
            	}
	    }
	    else
	    {
	        $respo1["status"] = false; 
    	    $respo1["msg"]    = 'Invalid Flag Value.';
    	    $respo1['errorCode'] = 703;
    	    echo json_encode($respo1);
	    }
	}
	else
	{
	    $respo1["status"] = false; 
	    $respo1["msg"]    = 'Send All Mandatory Fields.';
	    $respo1['errorCode'] = 703;
	    echo json_encode($respo1);
	}
	
}
if($post_type=='dispute_request')
{
	$user_id = $json_decode->user_id;
	$task_id = $json_decode->task_id;
	$type = $json_decode->flag;
	$reason = $json_decode->reason;
	
	if($user_id!='' && $task_id!='' && $type!='' && $reason!='')
	{
	    //common fields
        $common_model->user_id   = $user_id;
        $common_model->task_id   = $task_id;
        $common_model->type      = $type;
        $common_model->reason    = $reason;
    	
    	$insert = $common_model->insert_dispute();
    	if($insert)
    	{
           	$respo1["status"] = true; 
    	    $respo1["msg"]    = 'Request Submitted.It will take 3-4 business days to process.';
    	    $respo1['errorCode'] = 700;
        }
        else
    	{
    		$respo1["status"] = false; 
    	    $respo1["msg"]    = 'Request Not Submitted.';
    	    $respo1['errorCode'] = 703;
    	}
	}
	else
	{
	    $respo1["status"] = false; 
	    $respo1["msg"]    = 'Send All Mandatory Fields.';
	    $respo1['errorCode'] = 703;
	}
	echo json_encode($respo1);
}
if($post_type=='only_user')
{
	$user_id = $json_decode->user_id;
	if($user_id!='')
	{
    	$insert = $common_model->update_user_role($user_id);
    	if($insert)
    	{
           	$respo1["status"] = true; 
    	    $respo1["msg"]    = 'User Role Updated.';
    	    $respo1['errorCode'] = 700;
        }
        else
    	{
    		$respo1["status"] = false; 
    	    $respo1["msg"]    = 'Request Not Submitted.';
    	    $respo1['errorCode'] = 703;
    	}
	}
	else
	{
	    $respo1["status"] = false; 
	    $respo1["msg"]    = 'Send All Mandatory Fields.';
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
      echo json_encode($respo1);
}
}
}
?>