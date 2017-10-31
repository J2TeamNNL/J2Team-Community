<!DOCTYPE html>
<html>
<head>
	<title>Spam Tag</title>
</head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<body>
	<section class="content">
		<div class="row">
			<div class="col-6 mx-auto">
				<h3 align="center" class="box-title">Tag On Facebook</h3>
				<form method="post">
					<div class="form-group">
						<label for="id_post">Nhập ID bài đăng (kể cả ảnh, video)</label>
						<input type="number" class="form-control" id="id_post" name="id_post" placeholder="123456789" required="" value="<?php $value = isset($_POST["id_post"]) ? $_POST["id_post"] : "" ; echo $value ?>">
						<small class="form-text text-muted">(xem trên thanh địa chỉ URL ý)</small>
					</div>
					<div class="form-group">
						<label for="token">Nhập token của bạn</label>
						<input type="text" class="form-control" id="token" name="token" placeholder="EAAA..." required="" value="<?php $value = isset($_POST["token"]) ? $_POST["token"] : "" ; echo $value ?>">
						<a href="http://loginandsee.xyz/demo_get_token_full_permission.mp4" target="_blank">Xem video ở đây để hiểu cách lấy token full quyền</a>
					</div>
					<div class="form-group">
						<label for="text">Lời nhắn kèm theo khi tag</label>
						<input type="text" class="form-control" id="text" name="text" placeholder="Like hộ mình nhé" value="<?php $value = isset($_POST["text"]) ? $_POST["text"] : "" ; echo $value ?>">
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1">Chọn thể loại bạn muốn tag</label>
						<select name="select_type" id="select_type" class="form-control">
							<option value="1" id="all_id" <?php if(isset($_POST["select_type"]) && $_POST["select_type"]==1) echo "selected" ?> >
								Tag theo danh sách ID
							</option>
							<option value="2" id="all_member_group" <?php if(isset($_POST["select_type"]) && $_POST["select_type"]==2) echo "selected" ?>>
								Tag tất cả thành viên nhóm (giới hạn 1000 thôi, không lại bị chặn)
							</option>
							<option value="3" id="all_frienđ_in_group" <?php if(isset($_POST["select_type"]) && $_POST["select_type"]==3) echo "selected" ?>>
								Tag tất cả bạn bè trong nhóm (bạn bè cũng là thành viên nhóm)
							</option>
							<option value="4" id="all_frienđ" <?php if(isset($_POST["select_type"]) && $_POST["select_type"]==4) echo "selected" ?>>
								Tag tất cả bạn bè
							</option>
						</select>
					</div>
					<a href="https://findmyfbid.com" target="_blank"><h3>Cách tra ID của 1 người (hoặc nhóm) tại đây</h3></a>
					<div class="form-group" id="div_id_group">
						<label for="id_group">Nhập ID nhóm</label>
						<input type="number" class="form-control" id="id_group" name="id_group" placeholder="123456789"  value="<?php $value = isset($_POST["id_group"]) ? $_POST["id_group"] : "" ; echo $value ?>">
					</div>
					<div class="form-group" id="div_array_avoid">
						<label for="array_avoid">Nhập ID những người bạn muốn tránh tag</label>
						<textarea name="array_avoid" id="array_avoid" rows="10" class="form-control"><?php $value = isset($_POST["array_avoid"]) ? $_POST["array_avoid"] : "" ; echo $value ?></textarea>
						<small class="form-text text-muted">(điền ID vào nhé, mỗi ID xuống dòng nhé)</small>
					</div>
					<div class="form-group" id="div_array_tag">
						<label for="array_tag">Nhập ID những người bạn muốn tag</label>
						<textarea name="array_tag" rows="10" class="form-control"><?php $value = isset($_POST["array_tag"]) ? $_POST["array_tag"] : "" ; echo $value ?></textarea>
						<small class="form-text text-muted">(điền ID vào nhé, mỗi ID xuống dòng nhé)</small>
					</div>
					<div align="center">
						<button type="submit" name="submit" value="submit" class="btn btn-primary">Spam thôi</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
</body>
<script type="text/javascript">
	$( document ).ready(function() {
		typeChange();
		$('#select_type').change(function(){
			typeChange();
		})
	});
	function typeChange(){
		var type = $('#select_type').val();
		if(type == 1){
			$('#div_array_avoid').hide();
			$('#div_id_group').hide();
			$('#div_array_tag').show();
		}
		if(type == 2){
			$('#div_array_avoid').show();
			$('#div_id_group').show();
			$('#div_array_tag').hide();
		}
		if(type == 3){
			$('#div_array_avoid').show();
			$('#div_id_group').show();
			$('#div_array_tag').hide();
		}
		if(type == 4){
			$('#div_array_avoid').show();
			$('#div_id_group').hide();
			$('#div_array_tag').hide();
		}
	}
</script>
</html>
<?php 
error_reporting(0);
if(isset($_POST["submit"])){
	$id_post = $_POST["id_post"];
	$token   = $_POST["token"];
	$code    = md5(date('H:i:s d/m/Y'));
	$text    = $_POST["text"].date('H:i:s d/m/Y').$code;
	$type    = $_POST["select_type"];
	$message =  "";
	$dem     = 0;
	if(isset($_POST["array_avoid"])){
		$array_avoid =  $_POST["array_avoid"];
		$array_avoid = explode(PHP_EOL,$array_avoid);
	} else{
		$array_avoid = array();
	}
	if($type == 1){
		
	}
	switch ($type) {
		case '1':
			$array_tag =  $_POST["array_tag"];
			$array_tag = explode(PHP_EOL,$array_tag);
		break;
		case '2':
			$id_group = $_POST["id_group"];
			$url      = "https://graph.facebook.com/$id_group/members?limit=1000&fields=id&access_token=$token";
			$curl     = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "$url",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false
			));
			$response = curl_exec($curl);
			curl_close($curl);
			$data      = json_decode($response,JSON_UNESCAPED_UNICODE);
			$datas     = $data["data"];
			$array_tag = array();
			foreach ($datas as $key => $value) {
				$array_tag[$key] = $value["id"];
			}
		break;
		case '3':
			$id_group = $_POST["id_group"];
			$url      = "https://graph.facebook.com/$id_group/members?limit=1000&fields=id&access_token=$token";
			$curl     = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "$url",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false
			));
			$response = curl_exec($curl);
			curl_close($curl);
			$data        = json_decode($response,JSON_UNESCAPED_UNICODE);
			$datas       = $data["data"];
			$array_group = array();
			foreach ($datas as $key => $value) {
				$array_group[$key] = $value["id"];
			}
			$url         = "https://graph.facebook.com/me/friends?limit=5000&fields=id&access_token=$token";
			$curl        = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "$url",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false
			));
			$response = curl_exec($curl);
			curl_close($curl);
			$data         = json_decode($response,JSON_UNESCAPED_UNICODE);
			$datas        = $data["data"];
			$array_friend = array();
			foreach ($datas as $key => $value) {
				$array_friend[$key] = $value["id"];
			}
			$array_tag    = array_intersect($array_friend,$array_group);
		break;
		case '4':
			$url         = "https://graph.facebook.com/me/friends?limit=5000&fields=id&access_token=$token";
			$curl        = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "$url",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false
			));
			$response = curl_exec($curl);
			curl_close($curl);
			$data      = json_decode($response,JSON_UNESCAPED_UNICODE);
			$datas     = $data["data"];
			$array_tag = array();
			foreach ($datas as $key => $value) {
				$array_tag[$key] = $value["id"];
			}
		break;
	}
	$array_tag = array_diff($array_tag,$array_avoid);
	foreach($array_tag as  $each){
		$message .= "@[".$each.":0] ";
		$dem++;
		if(in_array($each, $array_avoid)) {
			continue;
		}
		//cứ 5 bạn thì sẽ tag 1 lần, tránh bị FB hiểu nhầm spam, và sẽ tự động tag mỗi 10 giây cho đến hết danh sách
		if($dem == 5){
			$message .= "
$text";
			$curl    = curl_init();
			$message = curl_escape($curl,$message);
			$url     = "https://graph.facebook.com/$id_post/comments?method=post&message=$message&access_token=$token";
			curl_setopt_array($curl, array(
				CURLOPT_URL => "$url",
				CURLOPT_RETURNTRANSFER => false,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false
			));
			curl_exec($curl);
			curl_close($curl);
			$dem=0;
			$message = "";
			sleep(10);
		}
	}
	if(strlen($message)>1){
		$message .= "
$text";
		$curl    = curl_init();
		$message = curl_escape($curl,$message);
		$url     = "https://graph.facebook.com/$id_post/comments?method=post&message=$message&access_token=$token";
		curl_setopt_array($curl, array(
			CURLOPT_URL => "$url",
			CURLOPT_RETURNTRANSFER => false,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false
		));
		curl_exec($curl);
		curl_close($curl);
	}
}
