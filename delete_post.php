
<!DOCTYPE html>
<html>
<head>
    <title>Delete post</title>
</head>
<body> 
    <h4>Code xóa bài đăng</h4>
    <h5>Không xóa được ảnh bìa, ảnh đại diện, bài được tag</h5>
    <form method="post">
        <h3><a href="https://fb.com/me" target="_blank">Cách lấy token: Ấn vào đây => Ctrl U => Ctrl F => Tìm EAAA... (copy đoạn EAAA dài nhất)</a></h3>
        <input type="text" name="token" placeholder="Nhập token vào đây"><br>
        <input type="number" name="id" placeholder="Nhập ID người dùng (hoặc trang) muốn xóa"><br>
        Xóa hết<input type="radio" name="all" value="1" checked><br>
        Xóa theo thời gian<input type="radio" name="all" value="0"><br>
        Bắt đầu từ ngày nào (có thể để trống nếu muốn xóa hết):<input type="date" name="since""><br>
        Kết thúc đến ngày nào (có thể để trống nếu muốn xóa hết):<input type="date" name="until""><br>
        <button name="ok">OK</button>
    </form>
</body>
</html>
<?php
if(isset($_POST['ok'])){
    ini_set('max_execution_time', 0);
    $token      = $_POST['token'];
    $id_can_xoa = $_POST['id'];
    $option = $_POST['all'];
    if($option==0){
        $since = $_POST['since'];
        $until = $_POST['until'];
        $link  = "https://graph.facebook.com/$id_can_xoa/posts?fields=id,type&limit=100&access_token=$token&since=$since&until=$until";
    }
    else{
       $link = "https://graph.facebook.com/$id_can_xoa/posts?fields=id,type&limit=100&access_token=$token"; 
    }
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
            if($each['type']=="status"){
                $id_lay = $each["id"];
                $link   = "https://graph.facebook.com/$id_lay?method=delete&access_token=$token";
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
                sleep(rand(2,5));
                echo "Đã xóa<br>";
            }
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
