<!DOCTYPE html>
<html>
<head>
	<title>Download File From Txt</title>
</head>
<body>
	<form method="post" enctype="multipart/form-data">
		Nhập file txt chứa link ảnh hoặc video (cách nhau xuống dòng) <input type="file" name="file" accept=".txt">
		<br>
		Tên thư mục chứa (có thể để trống) <input type="text" name="folder">
		<br>
		<button name="button_submit">OK</button>
	</form>
	<?php 
		ini_set('max_execution_time', 0);
		if(isset($_POST['button_submit'])){
			$file = $_FILES['file'];
			$folder = empty($_POST['folder']) ? '' : $_POST['folder']."/";
			$data = file_get_contents($file['tmp_name']);
			$array = explode(PHP_EOL, $data);
			foreach ($array as $each) {
				$name_file = substr($each, strrpos($each, '/') + 1);
				$fp    = fopen ($folder.$name_file , 'w+');
	            $links = $each;
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
		}
	?>
</body>
</html>
