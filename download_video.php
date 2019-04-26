<!DOCTYPE html>
<html>
<head>
    <title>Download video Facebook</title>
</head>
<body> 
    <h4>Code tải video Facebook</h4>
    <h3>Nhớ tạo thư mục tên là "download" cùng thư mục với file code này</h3>
    <form method="post">
        <h3><a href="https://fb.com/me" target="_blank">Cách lấy token: Ấn vào đây => Ctrl U => Ctrl F => Tìm EAAA... (copy đoạn EAAA dài nhất)</a></h3>
        <input name="token" placeholder="Nhập token vào đây"><br>
        <input type="number" name="id" placeholder="Nhập ID người dùng (hoặc nhóm, hoặc trang) muốn tải"><br>
        <button name="ok">OK</button>
    </form>
</body>
</html>
<?php
if(isset($_POST['ok'])){
    ini_set('max_execution_time', 0);
    $token = $_POST['token'];
    $id    = $_POST['id'];
    $link  = "https://graph.facebook.com/$id/videos?fields=source&limit=100&access_token=$token"; 
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
        $datas    = $data["data"];
        if(count($datas)==0) break;
        foreach($datas as $each){
            $id    = $each['id'];
            $fp    = fopen("download/$id.mp4", 'w+');
            $links = $each['source'];
            $curls = curl_init();
            curl_setopt_array($curls, array(
                CURLOPT_URL => $links,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_FILE => $fp
            ));
            curl_exec($curls);
            curl_close($curls);
            fclose($fp);
        }
        if(!empty($data["paging"]["next"])){
            $link = $data["paging"]["next"];
        }
        else{
            break;
        }
    }
}

?>
