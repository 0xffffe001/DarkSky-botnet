            
    <div class="panel panel-default">
                <div class="panel-heading">
					Черные списки
                </div>
                <div class="panel-body">
                	<div class="col-md-6">
						<textarea class="form-control" rows="15" disabled="disabled" style="background:#fff;">{file}</textarea>
					</div>
					<div class="col-md-6 jumbotron jumbotron-fluid" style="padding:15px;">
						<div id="alert" class="alert alert-warning {seccode}" data-alert="alert">
						  <a class="close" href="#">×</a>
						  <b>Ошибка!</b> <span id="fade-info">У вас отсутствует доступ к файлу banned</span>
						</div>
						<form method="post">
							<div class="form-group">
									<label for="input">Добавьте IP в бан-лист:</label>
									<input type="text" class="form-control input-sm" id="input" name="ipblock" placeholder="Например: 127.0.0.1, 127.0.0.1/24, 127.0.0.*, 127.0.*.*">
							</div>
							<div class="form-group">
									<label for="input">Разбанить IP адрес:</label>
									<input type="text" class="form-control input-sm" id="input" name="ipunban" placeholder="Например: 127.0.0.1, 127.0.0.1/24, 127.0.0.*, 127.0.*.*">
							</div>
							<div class="col-md-6" style="padding:0;">
								<div class="form-group">
									<button class="btn btn-danger btn-sm" type="submit">Забанить IP</button>
									<button class="btn btn-primary btn-sm">Разбанить IP</button>
								</div>
							</div>
						</form>
					</div>
              </div>
	</div>

