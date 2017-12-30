<?
	
	DEFINE('BadRequest','Please, try again later...');
	DEFINE('BadPass','Check login else password!');
	DEFINE('Good', 'Good. You token: ');
	
	include_once('../modules/users.php');
	include_once('../modules/global.php');
	include_once('../modules/security.php');
	
	$sec = new Security('api');
	$user = new Admin;
	$global = new GlobalCore;
	$clear = new Filter;
	
	if(isset($_GET['type'])){
	$method = $_GET['type'];
	
		if($method == 'login'){
			if(isset($_GET['login']) && isset($_GET['password'])){
				if($user->CheckPassword($_GET['login'], $_GET['password']) == true){
				
						if(isset($_GET['form'])=='1'){
							header('Location: ../main/');
						} else {
							echo Good.$_SESSION['token'];
						}
					
				} else {
					echo BadPass;
				}
			}
		}
		
		if($method == 'deleteuser'){
			if($user->Check()){
				if($user->CheckGroup($_SESSION['data']) == 0){
					if(isset($_GET['id'])){
						if ($user->DeleteUser(num($_GET['id']))){
							if(isset($_GET['form']) == '1'){
								header('Location: ../../users/');
							} else {
								echo 'Deleted';
							}
						} else {
							echo 'err deleting';	
						}
					} else {
						echo 'not parsing id';
					}
				} else {
					echo 'access denied';
				}
			}
		}
		if($method == 'exit'){
			$user->UserExit();
			if(isset($_GET['form'])=='1'){
				header('Location: ../');
			} else {
				echo 'ok';
			}
		}
		
		if($method == 'updateconfig'){
			if(isset($_GET['page']) ){
			$page = intval(num($_GET['page']));
				if($page == 1){
					if(isset($_POST['path']) && isset($_POST['domain']) && isset($_POST['lang']) && isset($_POST['chpu']) && isset($_POST['login']) && isset($_POST['pass'])){
						$path = clear($_POST['path']);
						$domain = clear($_POST['domain']);
						$lang = num($_POST['lang']);
						$chpu = num($_POST['chpu']);
						$password = c($_POST['pass']);
						$login = c($_POST['login']);
						if($clear->CheckDomain($domain) == true){
							if($global->UpdateConfig(1, $path, $domain, $lang, $chpu, $login, $password)){
								echo 'ok';
							} else {
								echo 'error mysql';
							}
						} else { echo 'check inputs';}
					}
				} else {
				if($page == 2){
					if(isset($_POST['pages']) && isset($_POST['autocache']) && isset($_POST['autoban']) && isset($_POST['mode']) && isset($_POST['repeat'])){
						$autocache = num($_POST['autocache']);
						$viewcmd = num($_POST['viewcmd']);
						$pages = num($_POST['pages']);
						$autoban = num($_POST['autoban']);
						$mode = $_POST['mode'];
						$repeatban = $_POST['repeat'];
						if($global->UpdateConfig(2, $autocache, $viewcmd, $pages, $autoban, $mode, $repeatban)){
							echo 'ok';
						} else {
							echo 'error mysql';
						}
					}
				} else { echo 'check inputs';}
				}
			}
		}
		
		if($method == 'crypt'){
			if(isset($_GET['method'])){
				if(isset($_GET['encrypt'])){
					$source = $user->clear($_GET['encrypt']);
					echo $sec->StringToHex($source); // шифровка
				} else {
					$source = $user->clear($_GET['decrypt']);
					echo $sec->HexToString($source); // расшифровка 
				}
			} else {
				if(isset($_GET['encrypt'])){
					mb_internal_encoding('utf-8');
					$str = str_replace('type=crypt&encrypt=', '', urldecode($_SERVER['QUERY_STRING']));
					$input_encoding = 'UTF-8';
					$str = strrev(iconv($input_encoding, 'WINDOWS-1251', $str));
					echo base64_encode($str);
					
				}
				
				if(isset($_GET['decrypt'])){
					mb_internal_encoding('utf-8');
					$str = str_replace('type=crypt&decrypt=', '', $_SERVER['QUERY_STRING']);
					$str = base64_decode($str);
					$input_encoding = 'WINDOWS-1251';
					echo strrev(iconv($input_encoding, 'UTF-8', $str)), PHP_EOL;
				}
			}
		}
		
		if($method == 'search'){
			if(isset($_GET['q'])){
				var_dump($global->Search($_GET['q']));
			}
		}
		
	}
	function clear($param){
		  // добавляем слеши перед кавычками, чтобы они стали виде escape-последовательности,
		  // например ' замениться на ', " замениться на " 
		  $param = addslashes($param); 
		  // заменяем все специальные символы эквивалентом 
		  $param = htmlspecialchars ($param); 
		  // отрезаем все ненужные симовлы 
		  //$param = preg_replace("/[^a-z0-9]\//i", "", $param);  
		  return $param;
	}
	
	function c($str){
		$str = addcslashes($str);
		$str = htmlspecialchars($str);
		return preg_replace("/[^a-z0-9]\//i", "", $param); 
	}
	
		function num($param){
		  $param = addslashes($param); 
		  $param = htmlspecialchars ($param); 
		  $param = preg_replace("/[^0-9]/i", "", $param);  
		  return $param;
	}
	

	
?>