<?

	class Security
	{
		var $files, $ip;
		
		function __construct($page){
			if($page=='api'):
				$this->files = '../banned';
			else:
				$this->files = 'banned';
			endif;
			$this->ip = $_SERVER['REMOTE_ADDR'];
			if($this->CheckBan($this->ip)==true):
				header('HTTP/1.0 404 Not Found');
				exit;
			endif;
		}
		
		function NotFound(){
			header('HTTP/1.0 404 Not Found');
			exit;
		}
		
		function MatchName($str){
		$value = $str;
		$str = mb_strlen(preg_replace('/\[^\d]/si', '', $str));
			if($str >1){
				if(preg_match('/(?=.*([a-z].*?[a-z]))(?=.*([A-Z].*?[A-Z]))/', $value)>0){
					return true; } else { return false; }
			} else { return false; }
		}
		
		public function LoadBase(){
			$s = explode('allow from all', file_get_contents($this->files));
			$b = $s[1];
			return trim(preg_replace('~deny from ~', '', $b));
		}
		
		public function AddToBase($str, $reason){
		$str = 'deny from '.$str.' | Reason: '. $reason . '' . "\r\n";
		$filename = $this->files;
			if (is_writable($filename)) {
				if (!$handle = fopen($filename, 'a')) {
					 return false;
					 exit;
				}

				if (fwrite($handle, $str) === FALSE) {
					return false;
					exit;
				}
				fclose($handle);
				return true;
			} else {
				return false;
			}
		}
		
		function CheckIP($str){
			if(filter_var($str, FILTER_VALIDATE_IP)){
				return true;
			} else {
				return false;
			}
		}
		
		function DeleteLine($line){
		$fopen=file($this->files);
		array_splice($fopen, $line, 1);
		$f=fopen($this->files, "w");
		for($i=0;$i<count($fopen);$i++){
				fwrite($f,$fopen[$i]);
		}
		fclose($f);
		return true;
		}
		
		function CheckBan($s) { 
		$filename = $this->files;
		$ars = explode('.', $s);
		$three = $ars[2];
		$two = $ars[1];
		if (strlen($three)==3):
			$three = mb_substr($three, 0, -1);
		else:
			if (strlen($three)==2):
				$three = mb_substr($three, 0, -1);
			else:
				$three = $three . $ars[3];
			endif;
		endif;
		$s = $ars[0].'.'.$ars[1].'.'.$ars[2].'.';
		$line = false; 
			$fh = fopen($filename, 'rb'); 
			for($i = 1; ($t = fgets($fh)) !== false; $i++) { 
				if( strpos($t, $s) !== false ) { 
					$line = $i; 
					break; 
				} 
			} 
			fclose($fh); 
		if(strlen($two)==1):
			$s = $ars[0].'.'.$ars[1].'.*';
				$fh = fopen($filename, 'rb'); 
			for($i = 1; ($t = fgets($fh)) !== false; $i++) { 
				if( strpos($t, $s) !== false ) { 
					$line = $i; 
					break; 
				} 
			} 
			fclose($fh); 
		endif;
		return $line; 
		}
		
		function searchLine($s) { 
		$filename = $this->files;
			$line = false; 
			$fh = fopen($filename, 'rb'); 
			for($i = 1; ($t = fgets($fh)) !== false; $i++) { 
				if( strpos($t, $s) !== false ) { 
					$line = $i; 
					break; 
				} 
			} 
			fclose($fh); 
			return $line; 
		}
		
		function GetSettings(){
			$arr = array();
			$arr = file_get_contents('config/cms.php');
			return $arr;
		}
				
		public function CheckBase(){
			if (is_writable($this->files)) {
				if (!$handle = fopen($this->files, 'a')) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
		
		function HexToString($hex){
		$str = '';
			for ($i=0; $i < strlen($hex)-1; $i+=2){
				$str .= chr(hexdec($hex[$i].$hex[$i+1]));
			}
		return $str;
		}
		
		function StringToHex($string){
			$hex='';
			for ($i=0; $i < strlen($string); $i++){
				$hex .= dechex(ord($string[$i]));
			}
			return $hex;
		}
	}

?>