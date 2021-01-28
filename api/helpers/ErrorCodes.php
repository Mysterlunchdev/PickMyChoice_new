<?php
class ErrorCodes 
{
    private static $OK = 700;
    private static $UNKNOWN_ERROR = 701;
    private static $INVALID_TOKEN = 702;
    private static $USER_NOT_FOUND = 703;
    private static $USERNAME_NOT_FOUND = 704;
    private static $USERPASSWORD_NOT_FOUND=705;
    private static $MANDATORY=706;
    private static $INVALIDFORMTYPE=707;
    private static $INVALID_DATATYPE=708;
    private static $RESULTS_NOT_FOUND=709;
    private static $INVALIDINPUT=710;

    public static function getUNKNOWERROR() {
        return self::$UNKNOWN_ERROR;
    }
    
    public static function getRESULTSNOTFOUND() {
        return self::$RESULTS_NOT_FOUND;
    }
    
     public static function getMANDATORYERROR() {
        return self::$MANDATORY;
    }
     public static function getINVALIDINPUT() {
        return self::$INVALIDINPUT;
    }
    public static function getINVALIDDATATYPE() {
        return self::$INVALID_DATATYPE;
    }
    
    public static function getINVALIDFORMTYPE(){
        return self::$INVALIDFORMTYPE;
    }

    public static function getOK() {
        return self::$OK;
    }

    public static function getINVALIDPAYLOAD() {
        return self::$INVALID_PAYLOAD;
    }

    public static function getTASKCODEERROR() {
        return self::$TASK_CODE_ERROR;
    }

    public static function getINVALIDTOKEN() {
        return self::$INVALID_TOKEN;
    }

    public static function getUSERNOTFOUND() {
        return self::$USER_NOT_FOUND;
    }

    public static function getUSERNAMENOTFOUND() {
        return self::$USERNAME_NOT_FOUND;
    }
     public static function getUSERPASSWORDNOTFOUND() {
        return self::$USERPASSWORD_NOT_FOUND;
    }

    public static function getApiKey($userid) {
        $SITE_KEY='1234';
        $key = md5($SITE_KEY . $userid);
        return hash('sha256', $key);
    }
    
    public static function send_message($target,$message,$flag)
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
            $result = curl_exec($ch);
           
            /*if ($result === FALSE) 
            {
            	die('FCM Send Error: ' . curl_error($ch));
            }*/
            curl_close($ch);
            return true;
    }

}
