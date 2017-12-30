

function LoginIn(){
	$('.preLoader').addClass('visible').removeClass('hidden');
	$('.login-form').addClass('hidden');
			
			
var method = $('#type').val();
var logins = $('#email').val();
var pass = $('#pass').val();
	$.get( "/0/application/api.php?type="+method+"&login="+logins+"&password="+pass)
  	.done(function( data ) {
		
		window.setTimeout(function () {
					if(data.indexOf('Good') == 0){
		
			window.setTimeout(function () {
				ShowAlert(0, 'Авторизация прошла успешно!');
				window.setTimeout(function () {
					CloseAlert();
				}, 1500);
			}, 300);
			
			window.setTimeout(function () {
				location.href='news/';
			}, 1000);
			
		} else {
			if(data.indexOf('Check') == 0){
				
				window.setTimeout(function () {
					ShowAlert(1, 'Произошла ошибка, проверьте правильность введенных вами данных!');		
					window.setTimeout(function () {
						CloseAlert();
					}, 1500);
							$('.preLoader').addClass('hidden').removeClass('visible');
							$('.login-form').addClass('visible').removeClass('hidden');
				}, 2000);
			}
		}
		}, 5000);
  });
}

function CloseAlert(){
	$("#alert").removeClass('in');
}



function ShowAlert(type, descr) {
		if(type == 0){
			$("#alert").each(function(){
				$(this).removeClass('alert-danger').removeClass('alert-success');
				$(this).addClass('in').addClass('alert-success');
				$(this).find('#fade-type').text('Успех!');
				$(this).find('#fade-info').text(descr);
			});
		}
		if(type == 1){
			$("#alert").each(function(){
				$(this).removeClass('alert-danger').removeClass('alert-success');
				$(this).addClass('in').addClass('alert-danger');
				$(this).find('#fade-type').text('Ошибка!');
				$(this).find('#fade-info').text(descr);
			});
		}
	}
	
	
function SaveSettings(){
	var page = $('#page').val();
	if(page == '1'){
		var path = $('input[name="path"]').val();
		var domain = $('input[name="domain"]').val();
		var lang = $('select[name="lang"] option:selected').val();
		var chpu = $('select[name="chpu"] option:selected').val();
		var clear = $('select[name="clear"] option:selected').val();
		var autoban = ''
		var cmdviewed =  '';
		var pagess = '';
		var access = '';
		var repeat = '';
		
	}
	if(page == '2'){
		var path = '';
		var domain = '';
		var lang = '';
		var chpu = '';
		var cmdviewed =  $('select[name="viewcmd"] option:selected').val();
		var clear = $('select[name="clear"] option:selected').val();
		var pagess = $('#pagess').val();
		var autoban = $('[name="autoban"]').val();
		var access = $('[name="mode"]').val();
		var repeat = $('[name="repeatban"]').val();
		
	}
		$.get( "/0/api/?type=updateconfig&page="+page+"&path=" + path + "&domain=" + domain + "&lang=" + lang + "&chpu=" + chpu + "&autocache=" + clear + "&pages="+pagess+"&autoban="+autoban+"&cmdviewed="+cmdviewed+"&mode="+access+"&repeat="+repeat)
			.done(function( data ) {
				if(data.indexOf('ok') == 0){
					window.setTimeout(function () {
						ShowAlert(0, 'Данные успешно сохранены!');
						window.setTimeout(function () {
							CloseAlert();
						}, 1500);
					}, 300);
				} 
						if(data.indexOf('mysql') == 0){
							window.setTimeout(function () {
								ShowAlert(1, 'Произошла ошибка соеденения к базе данных, свяжитесь с администратором!');
								window.setTimeout(function () {
									CloseAlert();
								}, 1500);
							}, 300);
						}
						if(data.indexOf('check') == 0){
							window.setTimeout(function () {
								ShowAlert(1, 'Проверьте правильность вводимых полей!');
								window.setTimeout(function () {
									CloseAlert();
								}, 1500);
							}, 300);
						}
						if(data.indexOf('missing') == 0){
							window.setTimeout(function () {
								ShowAlert(1, 'Все поля обязательны для ввода!!');
								window.setTimeout(function () {
									CloseAlert();
								}, 1500);
							}, 300);
						}
						
		});
}
