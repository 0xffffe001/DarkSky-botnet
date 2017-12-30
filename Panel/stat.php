<?php

include_once('modules/security.php');

	class Stats{
		
		var $file, $col_zap, $a, $ip, $date, $home, $lines, $bot;
		
		function __construct($page){
			$this->sec = new Security('');
			$this->col_zap=4999;  
			$this->a = $_SERVER['HTTP_USER_AGENT'];
			$this->ip = $this->getRealIpAddr();
			$this->date = date("H:i:s d.m.Y");   
			$this->home = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			if($page == 'activation'){ $this->file="log.log"; }
			if($page == 'index'){ $this->file="access-log.log"; }
			$this->lines = file($this->file);
			if (strstr($_SERVER['HTTP_USER_AGENT'], 'YandexBot')) {$this->bot='YandexBot';} //Выявляем поисковых ботов
			elseif (strstr($_SERVER['HTTP_USER_AGENT'], 'Googlebot')) {$this->bot='Googlebot';}
			else { $this->bot=isset($_SERVER['HTTP_USER_AGENT']); }
			
			while(count($this->lines) > $this->col_zap) array_shift($this->lines);
			$this->lines[] = $this->date."|".$this->a."|".$this->ip."|".$this->home."|\r\n";
			file_put_contents($this->file, $this->lines);
		}

		function getRealIpAddr() {
		  if (!empty($_SERVER['HTTP_CLIENT_IP']))       
		  { $ip=$_SERVER['HTTP_CLIENT_IP']; }
		  elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
		  { $ip=$_SERVER['HTTP_X_FORWARDED_FOR']; }
		  else { $ip=$_SERVER['REMOTE_ADDR']; }
		  return $ip;
		}

}
?>