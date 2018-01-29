<!DOCTYPE html>
<html>
<head>
    <title>Add Friend</title>
</head>
<body>
<form method="post">
    <textarea cols="50" name="token" placeholder="Nhập token vào đây"></textarea><br>
    <textarea cols="50" rows="30" name="array_id" placeholder="Nhập ID người dùng, cách nhau bởi 1 dấu xuống dòng (enter)"></textarea><br>
    <button name="ok">OK</button>
</form>
</body>
</html>
<?php
if(isset($_POST['ok'])){
    ini_set('max_execution_time', 0);
    $token        = $_POST['token'];
    $array_id     = $_POST['array_id'];
    $array_all    = explode(PHP_EOL,$array_id);
    $total_import = count($array_all);
    $page_limit   = 50;
    $num_page     = ceil($total_import/$page_limit);
    $array        = array();

    for($page=0; $page<$numPage; $page++) {
        $offset  = $page*$page_limit;
        $fbmaped = array_slice($array_all, $offset, $page_limit);
        $ids     = implode(",", $fbmaped);
        $link    = "https://graph.facebook.com/friends?ids=$ids&fields=id&access_token=$token";
        $curl    = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "$link",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $data     = json_decode($response,JSON_UNESCAPED_UNICODE);
        if(count($data["data"])==0) break;
        $array    = array_merge($array,$data["data"]);
    }
    foreach ($array as $each) {
        $id = $each['id'];
        $link    = "https://graph.facebook.com/me/friends?uid=$id&access_token=$token";
        $curl    = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "$link",
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => false,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ));
        curl_exec($curl);
        curl_close($curl);
        echo "Đã kết bạn với $id<br>";
        sleep(5);
    }
    
}
