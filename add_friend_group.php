<!DOCTYPE html>
<html>
<head>
    <title>Add Friend</title>
</head>
<body>
    <h4>Code để kết bạn với 1 nghìn thành viên nhóm</h4>
    <form method="post">
        <textarea cols="50" name="token" placeholder="Nhập token vào đây"></textarea><br>
        <input type=”text” name="id_group" placeholder="Nhập ID nhóm">
        <button name="ok">OK</button>
    </form>
</body>
</html>
<?php
if(isset($_POST['ok'])){
    ini_set('max_execution_time', 0);
    $token    = $_POST['token'];
    $id_group = $_POST['id_group'];
    $link     = "https://graph.facebook.com/$id_group/members?limit=1000&fields=id&access_token=$token";
    $curl     = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $link,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false
    ));
    $reply = curl_exec($curl);
    curl_close($curl);
    $data      = json_decode($reply,JSON_UNESCAPED_UNICODE);
    $data      = $data['data'];
    $array_all = array_column($data, "id");
    foreach ($array_all as $id) {
        $link    = "https://graph.facebook.com/me/friends?method=post&uid=$id&access_token=$token";
        $curl    = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $link,

            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ));
        curl_exec($curl);
        curl_close($curl);
        echo "Đã gửi kết bạn với <a href='https://fb.com/$id' target='_blank'>$id</a><br>";
        sleep(rand(2,10));
    }
}
