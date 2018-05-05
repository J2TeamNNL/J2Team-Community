<?php
ini_set('max_execution_time', 0);
$token        = "EAAA..."; //token full quyền
$limit        = 3; //chỉnh số bài đăng của muốn lấy
$array_avoid  = ["364997627165697","123"];//id nhóm, trang muốn tránh auto, viết như mình viết, ID đầu là của nhóm J2Team Community
$person_avoid = ["100001518861027","123"]; //id người

$host     = "localhost";
$user     = "root";
$password = "";
$database = "auto";
$con      = mysqli_connect($host, $user, $password, $database);

$links = "https://graph.facebook.com/me/home?order=chronological&limit=$limit&fields=id&access_token=$token";
$curls = curl_init();
curl_setopt_array($curls, array(
	CURLOPT_URL => $links,
	CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false
));
$reply = curl_exec($curls);
curl_close($curls);
$data  = json_decode($reply,JSON_UNESCAPED_UNICODE);
$datas = $data["data"];
foreach($datas as $each){
    $id_person = isset($each["from"]["id"]) ? $each["from"]["id"] : "";
    if(!in_array($id_person,$person_avoid)){
        $id_lay  = $each["id"];
        $split   = explode("_", $id_lay);
        $id_post = $split[0];
        if(!in_array($id_post,$array_avoid)){
            $select = "select `uid` from posts where uid = '$id_lay' limit 1";
            $result = mysqli_query($con,$select);
            $count  = mysqli_num_rows($result);
            if($count==0){
                $all_type    = ["LOVE", "HAHA", "LIKE", "ANGRY", "SAD"];//có 5 trạng thái
                $type        = $all_type[rand(0,4)]; //bạn có thể để random từ 0 -> 4 hoặc để số thay rand()
                $links = "https://graph.facebook.com/$id_lay/reactions?type=$type&method=post&access_token=$token";
                $curls = curl_init();
                curl_setopt_array($curls, array(
                    CURLOPT_URL => $links,
                    CURLOPT_RETURNTRANSFER => false,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false
                ));
                curl_exec($curls);
                curl_close($curls);
                $insert = "insert into posts values('$id_lay')";
                mysqli_query($con,$insert);
            }
        }
    }
}
