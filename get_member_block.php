<?php
ini_set('max_execution_time', 0);
//token bạn
$token   = "EAAAA";


//điền ID nhóm
$id_nhom = "364997627165697";

//không sửa ở dưới
$link    = "https://graph.facebook.com/$id_nhom/members?fields=id&limit=5000&access_token=$token"; 
$array_member_true = array();
$array_member = array();
while (true) {
    $curl    = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $link,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $data     = json_decode($response,JSON_UNESCAPED_UNICODE);
    $datas = $data["data"];
    foreach($datas as $each){
        array_push($array_member_true,$each['id']);
    }
    if(!empty($data["paging"]["next"])){
        $link = $data["paging"]["next"];
    }
    else{
        break;
    }
}
$total_import = count($array_member_true);
$pageLimit    = 100;
$numPage      = ceil($total_import/$pageLimit);
for($page=0; $page<$numPage; $page++) {
  $offset   = $page*$pageLimit;
  $fbmaped  = array_slice($array_member_true, $offset, $pageLimit);
  $ids      = implode(",", $fbmaped);
  $link     = "https://graph.facebook.com/?fields=id&ids=$ids&access_token=$token";
  $curl    = curl_init();
  curl_setopt_array($curl, array(
      CURLOPT_URL => $link,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_SSL_VERIFYHOST => false
  ));
  $response = curl_exec($curl);
  curl_close($curl);
  $data     = json_decode($response,JSON_UNESCAPED_UNICODE);
  foreach($data as $key => $each){
        array_push($array_member,$key);
    }
}
echo implode('<br>',array_diff($array_member_true,$array_member));
