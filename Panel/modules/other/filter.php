<?

	class Filter{
		
			function Text($str){
				$str = trim(strip_tags($str));
				$str = stripslashes(htmlspecialchars($str, ENT_QUOTES));
				if(strlen($str) > 0){
					return $str;
				} else {
					return $str;
				}
			}
			
			function CheckDomain($str){
				if (preg_match("/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/",$str)){
					return true; //okay
				} else {
					return false; //bad
				}
			}
			
			// /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/ Domain
		
	}
	
?>