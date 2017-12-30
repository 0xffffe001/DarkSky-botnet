<?
	define('URL', 'http://novatek-g30.caviar-russia.ru/0/server.php?key=');
	define('KEY', '955cbc8bc589c81662f288b0a26f24f2');
	define('V', '0.6');

	class Update{
		
		function file_get_contents_curl($url) {
		$ch = curl_init();
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Устанавливаем параметр, чтобы curl возвращал данные, вместо того, чтобы выводить их в браузер.
			curl_setopt($ch, CURLOPT_URL, $url . KEY);
			$data = curl_exec($ch);
			curl_close($ch);
			return $data;
		}
		
		function UpdateDownload(){
			return file_put_contents('../update/update.zip', file_get_contents(URL.KEY.'&download=1'));
		}
		
	}
?>