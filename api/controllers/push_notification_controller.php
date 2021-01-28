<?php
require_once '../models/common_model.php';
require_once '../helpers/DefaultResponse.php';
$common_model = new Common_Mdl();
$dr = new DefaultResponse();
$user_id=$_GET['user_id'];
$flag=$_GET['flag'];
$message=$_GET['notification'];
if($flag!='' && $user_id!='')
{
        $login_details = $common_model->fetch_user_details($user_id);
        if(!empty($login_details)) 
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
            $mobile = $login_details[0]['mobile'];
            $name = $login_details[0]['name'];
            $user_code = $login_details[0]['user_code'];
            $target = $login_details[0]['fcm_token'];
            $address = $login_details[0]['address'];
            $did = $login_details[0]['device_id'];
            
            //$data = array();
            //$data['title'] = 'Verification';
            //$data['flag']= '1';
             
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
            $result = curl_exec($ch);
            if($result)
            {
                $common_model->insert_notification($user_id,$title,$message);
            }
            if ($result === FALSE) 
            {
            	die('FCM Send Error: ' . curl_error($ch));
            }
            curl_close($ch);
                        
            $msg = 'Sent';
            $status = true;
            $respo1['status']=$status;
            $respo1['msg']=$msg;
            $respo1['errorCode']=700;
            echo json_encode($respo1);
        }
        else 
        {
            $errocode = $dr->getUSERNOTFOUND();
            $msg = 'Invalid User';
            $status = false;
            $respo1['status']=$status;
            $respo1['msg']=$msg;
            $respo1['errorCode']=$errocode;
            echo json_encode($respo1);
        }
        
    }
    else
    {
            $errocode = $dr->getUSERNOTFOUND();
            $msg = 'Invalid User';
            $status = false;
            $respo1['status']=$status;
            $respo1['msg']=$msg;
            $respo1['errorCode']=$errocode;
            echo json_encode($respo1);
    }
?>