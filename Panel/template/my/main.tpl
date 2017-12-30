<!DOCTYPE html>
<html>
<head>
	<title>{title}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
	<meta name="googlebot" content="noindex, nofollow"/>
	<meta name="yandex" content="none"/>
	<meta name="robots" content="noindex, nofollow"/>
	
	<link rel="stylesheet" href="{url}/css/bootstrap.min.css">
	<link rel="stylesheet" href="{url}/css/custom.min.css">
	<link rel="stylesheet" href="{url}/css/ionicons.css">
	<style>
		{css}
	</style>

	<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
	<script src="{url}/js/main.js"></script>
</head>
<body>
<?if($user->Check()):?>
<nav class="navbar navbar-default navbar-static-top">
	<div class="container-fluid">

		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="{domain}">
				<i class="ion-android-cloud" style="text-shadow: -2px 0 #19485f, 0 2px #19485f, 2px 0 #19485f, 0 -2px #19485f;color: #e4e3e3;"></i> DarkSky
			</a>
		</div>

		
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">			

				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="{domain}log.log" target="_blank"><i class="ion-forward"></i> Открыть лог файл</a>
					</li>
					<li>
						<a href="#"><i class="ion-information-circled"></i> {ip} {code}</a>
					</li>
					<li class="dropdown ">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
						<i class="ion-gear-a"></i> Управление
						<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="../deletelog/"><i class="ion-trash-b"></i> Удалить лог файл</a></li>
						</ul>
					</li>
					<li>
						<a href="{domain}exit/"><i class="ion-power"></i> Выход</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	
<?else:?>
<div class="logo" style="height:120px;">

</div>
<?endif;?>
	
	<div class="container-fluid main-container">
		{menu}
		
		<div class="col-md-10" style="margin:0;padding: 0">
			<?if($settings==true):?>
			<div class="panel panel-default">
                <div class="panel-heading" style="border-color:transparent;">
					<div class="col-xs-inline">
						<a href="{domain}settings/main/" id="f-menu">
							<i class="glyphicon glyphicon-cog" style="font-size:26px;margin-top: 5px;"></i>
						</a>
					</div>
					<div class="col-xs-inline">
						<a href="{domain}settings/option/" id="l-menu">
							<i class="glyphicon glyphicon-hdd" style="font-size:26px;margin-top: 5px;"></i>
						</a>
					</div>
                </div>
            </div>

			<?endif;?>
				{content}
			
		</div>
	</div>
	
<div id="alert" class="alert fade" data-alert="alert" style="width:300px;float:right;position: fixed;right: 20px;bottom: 20px;">
  <a class="close" href="#">×</a>
  <p><strong id="fade-type"></strong> <span id="fade-info"></span></p>
</div>

	
	<footer class="pull-left footer">
	<hr class="divider">
			<div class="col-md-12">
				<div class="col-xs-6">
					Copyright &COPY; 2017
				</div>
				<div class="col-xs-6">
					Local Time: {time}
				</div>
			</div>
	</footer>
	
	
	<script src="{url}/js/bootstrap.min.js"></script>
	<script src="{url}/js/table.js"></script>
	<script>
		var show = '';
		if(show == '1'){
			window.setTimeout(function () {
			ShowAlert(1, 'Проверьте правильность введённых вами данных.');
			window.setTimeout(function () {
				CloseAlert();
				}, 1500);
			}, 300);
		}
		if(show == '0'){
			window.setTimeout(function () {
			ShowAlert(1, 'Данные успешно сохранены!');
			window.setTimeout(function () {
				CloseAlert();
				}, 1500);
			}, 300);
		}
		
		function windowSize() {
 		 windowHeight = window.innerHeight ? window.innerHeight : $(window).height();
		  windowWidth = window.innerWidth ? window.innerWidth : $(window).width();
		}
		
		windowSize();
		if (windowWidth < 768) {
  			  $('#menus').attr('style', 'margin:0;padding:0;width:100%');
		 }
		
		$(window).resize(function() {
  		windowSize();
			  if (windowWidth < 768) {
  			  $('#menus').attr('style', 'margin:0;padding:0;width:100%');
			  } else {
				$('#menus').removeAttr('style');
			}
		});
	</script>
</body>
</html>