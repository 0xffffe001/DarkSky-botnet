<?
// Глобальные настройки //


	class Config {
		
		var $title, $domain, $pathsite, $template, $password, $login, $lang, $chpu, $maxusers, $showcmd, $autoban, $repeatban, $modehidden, $loginauth;
			
		function __construct(){
	
			$arrs = parse_ini_file('settings.ini');
			$this->title = $arrs['title'];	// По Умолчанию (Панель Управления)
			$this->domain = $arrs['domain']; // Доменное имя (полное, т.е. http://site.com/)
			$this->pathsite = $arrs['pathsite'];					 // Если присутствует какая-то папка, в которой находится скрипт (БЕЗ УКАЗАНИЯ ПЕРВОГО СЛЕША!)
			$this->template = $arrs['template'];		  // Путь до вашего шаблона, по умолчанию: template/my/ (БЕЗ УКАЗАНИЯ ПЕРВОГО СЛЕША!)
			$this->login = $arrs['login'];						 // Логин для входа в панель управления
			$this->password = $arrs['password'];			//Пароль для входа в панель управления
			$this->lang = $arrs['lang'];							 // 0 - это Русский
			$this->chpu = $arrs['chpu'];							// 1 - Включить поддержку .htaccess, 0 - выключено
			$this->maxusers = $arrs['maxusers']; 					// Максимальное кол-во для вывода людей на главной странице
			$this->showcmd = $arrs['showcmd']; 						// Показывать статус выполненных команд в разделе с командами
			$this->autoban = $arrs['autoban']; 						// Банить людей, которые пытаются заполучить несанкционированный доступ к файлам (т.е. сканят директории и файлы)
			$this->repeatban = $arrs['repeatban'];					 // Максимальное кол-во неудачных попыток заполучить несанкционированный доступ для выдачи автобана
			$this->modehidden = $arrs['modehidden']; 					// Скрытый режим работы панели, если нет доступных команд для выдачи боту, будет появлятся 404 страница.
			$this->loginauth = $arrs['loginauth'];

		}
		
	
	}
?>