<?php
require_once '../models/common_model.php';
$common_model = new Common_Mdl();
ini_set("allow_url_fopen", 1);


$sms_settings = $common_model->fetch_sms_setting();
$url = $sms_settings[0]['url']; 
$usrname = $sms_settings[0]['username']; 
$usrpwd  = $sms_settings[0]['password']; 
$usrpwd=base64_decode($usrpwd);
$from  = $sms_settings[0]['sender_id']; 

$msg2="Cron Test";
$mobile='9177577668';
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
//if($_GET['type']=='assign_service')
//{
    $list=$common_model->fetch_unassigned_service();
    if(!empty($list))
        {
           for($i=0;$i<count($list);$i++)
           {
               $id=$list[$i]['id'];
               $user_id=$list[$i]['user_id'];
               $postcode=$list[$i]['postal_code'];
               $code=$list[$i]['code'];
               $budget=$list[$i]['budget'];
               $address=$list[$i]['address'];
               $date=$list[$i]['date'];
               $time=$list[$i]['time'];
               $subid=$list[$i]['sub_category_id'];
               if($postcode!='')
               {
                $api_key="EN4lXzbqMEaGCfBnBcosQA29618";
            	//$postcode=$_POST['postcode'];
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
            	if($latitude!='' && $longitude!='')
            	{
            	    $list_vendor=$common_model->get_vendors_list($latitude,$longitude,$subid);
            	    //print_r($list_vendor);
            	    if(!empty($list_vendor))
                    {
                       $resupdate=$common_model->update_unassigned_service($id);
                       for($j=0;$j<count($list_vendor);$j++)
                       {
                           $vid=$list_vendor[$j]['id'];
                           if($vid!=$user_id)
                           {
                               $res=$common_model->assign_service($id,$user_id,$vid,$distance,$date,$time);
                               $mobile=$list_vendor[$j]['mobile'];
                               $ucode=$list_vendor[$j]['user_code'];
                               $name=$list_vendor[$j]['name'];
                               $fcm_token=$list_vendor[$j]['fcm_token'];
                               $device_id=$list_vendor[$j]['device_id'];
                               $distance=$list_vendor[$j]['distance'];
                               $message="Dear $name,$ucode, Assigned One Service Request-$code, Budget $budget at $address on $date, $time";
                               $res=$common_model->insert_notification($vid,'Assigned',$message);
                               if($device_id=='Android' && $fcm_token!='')
                               {
                                   echo send_message($fcm_token,$message,'Assigned');
                               }
                               else
                               {
                                   echo 'Assigned-';
                               }
                           }
                       }
                    }
            	}
               }
               
           }
        }
//}
function send_message($target,$message,$flag)
{
            $url = 'https://fcm.googleapis.com/fcm/send';
            $server_key = 'AAAAs0Blfnc:APA91bEs72lPifdweFw1C-SEHggOrsZZd3yTOx-DKQ1FMm-xQkynKQ56q0Mh1d_3HwSebkPEJ4MxIhCHH5JEBEw473OpS7u7bpNflQ9GAT35K_D143MC6NY6uf_cTyCqlypgnkVJZhG5';
            			
            //$fields = array();
            
            //$target="ecWV664YKnU:APA91bFZ7t9_ZjyAOC_iCFrwQWV4BQ8DrdE1G0NBM2jDIJMLgL826nhUzq3HT6h6fuxlJJgtnpadKWpIpnuCrYcO5gNtOmIfe3eePDSEWXgisLHXWlaAMVJkojCncS0fKxLhbor14hZq";
            //$fields['data'] = $data;
             $dt=date('Y-m-d h:m a');
             $data = array();
             $title=ucwords($flag);
             $data['title'] = ucwords($flag);
             $data['time']= date("d-m-Y h:m a", strtotime($dt));
             $data['is_background']='false';
             $data['body'] = $message;
             $fields['data'] = $data;
             
             $notification= array();
             $notification['body'] = $message;
             $notification['title']= ucwords($flag);
             $notification['icon']='true';
            // $notification['smallIcon']='http://pickmychoice.co.uk/dev505/dynamic/images/logo-icon.png';
             $fields['notification'] = $notification;
            
             $fields['to'] = $target;
            
             $headers = array(
              'Content-Type:application/json',
              'Authorization:key='.$server_key
            );
            			
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            echo $result = curl_exec($ch);
           
            if ($result === FALSE) 
            {
            	die('FCM Send Error: ' . curl_error($ch));
            }
            curl_close($ch);
            
}
