<!DOCTYPE html>
<html>
<head>
    <title>Add Friend By Friend</title>
</head>
<body> 
    <h4>Code để kết bạn với toàn bộ bạn bè của những người ở dưới</h4>
    <form method="post">
        <textarea cols="50" name="token" placeholder="Nhập token vào đây"><?php if(isset($_POST['ok'])){ echo $_POST['token']; } ?></textarea><br>
        <textarea cols="50" rows="30" name="array_id" placeholder="Nhập ID người dùng, cách nhau bởi 1 dấu xuống dòng (enter)"><?php if(isset($_POST['ok'])){ echo $_POST['array_id']; }?></textarea><br>
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

    for($page=0; $page<$num_page; $page++) {
        $offset  = $page*$page_limit;
        $fbmaped = array_slice($array_all, $offset, $page_limit);
        $ids     = implode(",", $fbmaped);
        $link    = "https://graph.facebook.com/friends?ids=$ids&fields=id&access_token=$token&limit=5000";
        $curls = curl_init();
        curl_setopt_array($curls, array(
        	CURLOPT_URL => $link,
        	CURLOPT_RETURNTRANSFER => true,
        	CURLOPT_TIMEOUT => 0,
        	CURLOPT_SSL_VERIFYPEER => false,
        	CURLOPT_SSL_VERIFYHOST => false
        ));
        $reply = curl_exec($curls);
        curl_close($curls);
        $data     = json_decode($reply,JSON_UNESCAPED_UNICODE);
        foreach ($data as $each) {
            if(count($each)==0) break;
            $array = array_merge($array,array_column($each["data"],'id'));
        } 
    }
    foreach ($array as $id) {
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
    }
    
}
