<?php
function get_curl_response($urllink,$postdata){
$url="http://chitfinder.com/magnificit/api/controllers/".$urllink;
//$url="http://localhost/M/magnificit/Latest/dynamic/api/controllers/".$urllink;
    $url=  trim($url);
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
  $result = curl_exec($ch);
  if (curl_errno($ch))
        echo 'curl error : ' . curl_error($ch);
  return $result;
curl_close($ch);
}
    ?>