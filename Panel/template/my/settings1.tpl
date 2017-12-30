
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    Глобальные настройки
                </div>
                <div class="panel-body">
                	<div class="col-md-6">
                		<form method="post">
								<div class="form-group">
									<label for="input2">Доменное имя:</label>
									<input type="text" class="form-control input-sm" id="input2" name="domain" value="{domen}">
								</div>
								<div class="form-group">
									<label for="input2">Путь к шаблону:</label>
									<input type="text" class="form-control input-sm" id="input2" name="template" value="{template}">
								</div>
								<div class="form-group">
									<label for="input2">Пароль к панели:</label>
									<input type="password" class="form-control input-sm" id="input2" value="*****">
								</div>
								<div class="form-group">
									<label for="input3">Язык панели:</label>
									<select class="form-control input-sm" name="lang">
										<option value="0">Русский</option>
								  </select>
								</div>
								<div class="form-group">
									<label for="input3">ЧПУ:</label>
									<select class="form-control input-sm" name="chpu">
										<option value="0">Включено</option>
										<option value="1">Выключено</option>
								  </select>
								</div>
														
								<div class="form-group">
									<button class="btn btn-success btn-sm"  type="submit">Сохранить</button>
								</div>
								
						</div>
					</form>
               </div>
	</div>


<script>
	
	var htaccess = '{ht}';

	if(htaccess == '0'){
		$('select[name="chpu"] option[value="0"]').prop('selected', true);
	} else {
		$('select[name="chpu"] option[value="0"]').prop('selected', true);
	}
	
	//$('#saveconfig').click(function(){
		//SaveSettings();
	//});
</script>