<!DOCTYPE html>
<html>
<head>
	<title>Download File From Txt</title>
</head>
<body>
	<form method="post" enctype="multipart/form-data">
		Nhập file txt chứa link ảnh hoặc video (cách nhau xuống dòng) <input type="file" name="file" accept=".txt">
		<br>
		Nhập số dòng muốn bỏ cách (có thể để trống) <input type="number" name="number_line">
		<br>
		Tên thư mục chứa (có thể để trống) <input type="text" name="folder" autocomplete="off">
		<br>
		<button name="button_submit">OK</button>
	</form>
	<?php 
		ini_set('max_execution_time', 0);
		if(isset($_POST['button_submit'])){
			$file        = $_FILES['file'];
			$number_line = empty($_POST['number_line']) ? 0 : $_POST['number_line'];
			$folder      = empty($_POST['folder']) ? '' : $_POST['folder']."/";

			$data  = file_get_contents($file['tmp_name']);
			$array = preg_split( '/\r\n|\r|\n/', $data );
			$array = array_slice($array, $number_line);

			foreach ($array as $key => $each) {
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
	            $key++;
	            echo "Đã tải $key ảnh<br>";
			}
		}
	?>
</body>
</html>
