<!DOCTYPE html>
<html>
<head>
    <title>Get ID by link Facebook</title>
</head>
<body> 
    <h4>Code lấy ID theo link Facebook</h4>
    <form method="post">
        <h3><a href="https://fb.com/me" target="_blank">Cách lấy token: Ấn vào đây => Ctrl U => Ctrl F => Tìm EAAA... (copy đoạn EAAA dài nhất)</a></h3>
        <textarea cols="50" name="token" required placeholder="Nhập token vào đây"><?php if(isset($_POST['ok'])) echo $_POST['token'] ?></textarea><br>
        <textarea cols="50" rows="30" name="array_id" required placeholder="Nhập link Facebook, cách nhau bởi 1 dấu xuống dòng (enter - không thừa khoảng trắng)"><?php if(isset($_POST['ok'])) echo $_POST['array_id'] ?></textarea>
        <button name="ok">OK</button>
    </form>
</body>
</html>
<?php
function print_r2($val){
        echo '<pre>';
        print_r($val);
        echo  '</pre>';
}
if(isset($_POST['ok'])){
    ini_set('max_execution_time', 0);
    $token        = $_POST['token'];
    $array_id     = $_POST['array_id'];
    preg_match_all('/(?<=profile\.php\?id\=)(?<id>[0-9]*)|(?:(?<=\.com\/)|(?<=\.me\/)|(?<=\.co\/)|(?<=\.us\/))(?:(?!profile\.php)(?<username>[\w\.\_]*))/', $array_id, $array);
    $array_user_name = array_filter($array['username'], function($value) { return $value !== ''; });
    $array_id        = array_filter($array['id'], function($value) { return $value !== ''; });
    $total_import    = count($array_user_name);
    $page_limit      = 50;
    $num_page        = ceil($total_import/$page_limit);
    $array_new_id    = array();
    for($page=0; $page<$num_page; $page++) {
        $offset  = $page*$page_limit;
        $fbmaped = array_slice($array_user_name, $offset, $page_limit);
        $ids     = implode(",", $fbmaped);
        $link    = "https://graph.facebook.com/?ids=$ids&fields=id&access_token=$token";
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
        foreach ($data as $each) {
            $array_new_id[] = $each['id'];
        } 
    }
    $array_all = array_merge($array_id,$array_new_id);
    $text      = implode("\n",$array_all);
    echo "<textarea cols='50' rows='15'>$text</textarea>";
}
