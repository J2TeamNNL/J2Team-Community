<!DOCTYPE html>
<html>
<head>
    <title>Filter Age</title>
</head>
<body> 
    <h4>Code để lọc độ tuổi</h4>
    <form method="post">
        <h3><a href="https://fb.com/me" target="_blank">Cách lấy token: Ấn vào đây => Ctrl U => Ctrl F => Tìm EAAA... (copy đoạn EAAA dài nhất)</a></h3>
        <textarea cols="50" name="token" placeholder="Nhập token vào đây"></textarea><br>
        <textarea cols="50" name="age" placeholder="Nhập độ tuổi muốn lọc"></textarea><br>
        <textarea cols="50" rows="30" name="array_id" placeholder="Nhập ID người dùng, cách nhau bởi 1 dấu xuống dòng (enter - không thừa khoảng trắng)"></textarea>
        <button name="ok">OK</button>
    </form>
</body>
</html>
<?php
if(isset($_POST['ok'])){
    ini_set('max_execution_time', 0);
    $token        = $_POST['token'];
    $age          = $_POST['age'];
    $year_filter  = date('Y')-$age;
    $array_id     = $_POST['array_id'];
    $array_all    = explode(PHP_EOL,$array_id);
    $total_import = count($array_all);
    $page_limit   = 50;
    $num_page     = ceil($total_import/$page_limit);
    $array_lower  = array();
    $array_higher = array();
    $array_null   = array();

    for($page=0; $page<$num_page; $page++) {
        $offset  = $page*$page_limit;
        $fbmaped = array_slice($array_all, $offset, $page_limit);
        $ids     = implode(",", $fbmaped);
        $link    = "https://graph.facebook.com/?ids=$ids&fields=birthday&access_token=$token";
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
            if(!empty($each['birthday']) && strlen($each['birthday'])==10){
                $array = explode('/',$each['birthday']);
                $year = $array[2];
                if($year>$year_filter){
                    $array_lower[] = $each['id'];
                }
                else{
                    $array_higher[] = $each['id'];
                }
            }
            else{
                $array_null[] = $each['id'];
            }
        } 
    }
    $text = implode("\n", $array_lower);
    echo "Nhỏ tuổi hơn:<textarea cols='50' rows='15'>$text</textarea>";
    $text = implode("\n", $array_higher);
    echo "Lớn tuổi hơn:<textarea cols='50' rows='15'>$text</textarea>";
    $text = implode("\n", $array_null);
    echo "Không công khai:<textarea cols='50' rows='15'>$text</textarea><br>";
}
