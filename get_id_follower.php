<!DOCTYPE html>
<html>
<head>
    <title>Get List Followers</title>
</head>
<body> 
    <h4>Code lấy danh sách theo dõi mình</h4>
    <form method="post">
        <h3><a href="https://fb.com/me" target="_blank">Cách lấy token: Ấn vào đây => Ctrl U => Ctrl F => Tìm EAAA... (copy đoạn EAAA dài nhất)</a></h3>
        <input name="token" placeholder="Nhập token vào đây"><br>
        <button name="ok">OK</button>
    </form>
</body>
</html>
<?php
if(isset($_POST['ok'])){
  ini_set('max_execution_time', 0);
  $token = $_POST["token"];
  $array = array();
  $link  = "https://graph.facebook.com/me/subscribers?fields=id&limit=5000&access_token=$token"; 
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
          array_push($array, $each['id']);
      }
      if(!empty($data["paging"]["next"])){
          $link = $data["paging"]["next"];
      }
      else{
          break;
      }
  }
  $text = implode("\n",$array);
  echo "<textarea cols='50' rows='20'>$text</textarea>";
}
