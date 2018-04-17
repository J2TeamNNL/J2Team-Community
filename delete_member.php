<!DOCTYPE html>
<html>
<head>
    <title>Xóa thành viên</title>
</head>
<body> 
    <h4>Xóa thành viên theo ID</h4>
    <form method="post">
        <input type="text" name="id_nhom" placeholder="Nhập ID nhóm">
        <textarea cols="50" name="token" placeholder="Nhập token vào đây"><?php if(isset($_POST['ok'])){ echo $_POST['token']; } ?></textarea><br>
        <textarea cols="50" rows="30" name="array_id" placeholder="Nhập ID thành viên, cách nhau bởi 1 dấu xuống dòng (enter)"><?php if(isset($_POST['ok'])){ echo $_POST['array_id']; }?></textarea><br>
        <button name="ok">OK</button>
    </form>
</body>
</html>
<?php
if(isset($_POST['ok'])){
    ini_set('max_execution_time', 0);
    $token    = $_POST['token'];
    $id_nhom  = $_POST['id_nhom'];
    $array_id = explode(PHP_EOL,$_POST['array_id']);
    foreach($array_id as $each){
        $link   = "https://graph.facebook.com/$id_nhom/members?method=delete&member=$each&access_token=$token";
        $curl   = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $link,
            CURLOPT_RETURNTRANSFER => false,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ));
        curl_exec($curl);
        curl_close($curl);
        sleep(5);
    }
}
