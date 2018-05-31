<!DOCTYPE html>
<html>
<head>
    <title>Get ID and Username</title>
</head>
<body> 
    <h4>Code lấy id và username</h4>
    <form method="post">
        <h3><a href="https://fb.com/me" target="_blank">Cách lấy token: Ấn vào đây => Ctrl U => Ctrl F => Tìm EAAA... (copy đoạn EAAA dài nhất)</a></h3>
        <textarea cols="50" name="token" placeholder="Nhập token vào đây"><?php if(isset($_POST['ok'])) echo $_POST['token'] ?></textarea><br>
        <textarea cols="50" rows="30" name="array_id" placeholder="Nhập ID (hoặc username) người dùng, cách nhau bởi 1 dấu xuống dòng (enter - không thừa khoảng trắng)"><?php if(isset($_POST['ok'])) echo $_POST['array_id'] ?></textarea>
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
    $array_male   = array();
    $array_female = array();

    for($page=0; $page<$num_page; $page++) {
        $offset  = $page*$page_limit;
        $fbmaped = array_slice($array_all, $offset, $page_limit);
        $ids     = implode(",", $fbmaped);
        $link    = "https://graph.facebook.com/?ids=$ids&fields=username&access_token=$token";
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
            $array[$each['id']] = $each['username'];
        } 
    }
    $text = "";
    foreach ($array as $id => $username) {
        $text .= "$id: $username\n";
    }
    echo "<textarea cols='50' rows='15'>$text</textarea>";
}
