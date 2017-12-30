       <!-- <div class="panel" style="display: inline-block;width:100%;"> -->
<div class="row row-main" style="margin-left: Auto;margin-right:auto;">
	
        	<div class="col-lg-2 col-sm-2 col-md-3 col-xs-5 bg-primary block-top">
        		<div class="text-right block-content">
     		    <span class="text-block-big">{UsersDay}</span>
     					<div class="text-bottom-block">
     						Добавлено
     					</div>
        		</div> 
      		<span class="ion-top">  <i class="ion-android-contact"></i> </span>
     	   </div>
     
     <div class="col-lg-2 col-sm-2 col-md-3 col-xs-5 bg-success block-top">
        		<div class="text-right block-content">
     		   	<span class="text-block-big">{UsersMidOnline}</span>
     					<div class="text-bottom-block">
							Ср.Отстуков
     					</div>
        		</div> 
                <i class="ion-checkmark ion-top"></i>
     	   </div>
     
   		  <div class="col-lg-2 col-sm-2 col-md-3 col-xs-5 bg-danger block-top">
        		<div class="text-right block-content">
     		   	<span class="text-block-big">{UsersDayBanned}</span>
     					<div class="text-bottom-block">
     						Забанено
     					</div>
        		</div> 
                <i class="ion-minus-circled ion-top"></i>
     	   </div>
		   
		   <div class="col-lg-2 bg-muted block-top col-sm-2 col-md-3 col-xs-5">
        		<div class="text-right block-content">
     		    <span class="text-block-big">N/A</span>
     					<div class="text-bottom-block">
     						Умерших
     					</div>
        		</div> 
                <i class="ion-trash-a ion-top"></i>
     	   </div>
     
       
	</div>
		
		
<div class="panel panel-default">
                <div class="panel-heading"  style="min-height:40px;">
					<div class="col-sm-6 col-xs-6" style="padding-left:0;">
						Список ботов
					</div>
					<div class="col-sm-6 col-xs-6 text-right" style="padding-left:0;">
						Всего: {max_users} жертвы
					</div>
				</div>
                <div class="panel-body">
                	 
                	<div style="position:relative;overflow: auto;">
					<table class="table table-responsive table-bordered text-center" id="table-search">
						<thead style="color:#888;">
							<tr>
								<th class="text-center" style="width: 2%;">#</th>
								<th class="text-center" style="width: 3%;">IP</th>
								<th class="text-center" style="width: 3%;">Имя</th>
								<th class="text-center" style="width: 3.5%;">HWID</th>
								<th class="text-center" style="width: 3%;">Страна</th>
								<th class="text-center" style="width: 3%;">Windows</th>
								<th class="text-center" style="width: 2%;">Админ</th>
								<th class="text-center" style="width:6%">Добав.</th>
								<th class="text-center" style="width:6%">Актив.</th>
								<th class="text-center" style="width: 2%;">Статус</th>
								<th class="text-center" style="width:4%"></th>
							</tr>
						</thead>
						<tbody>
						<?if($user->UsersView($page) > 0):?>
						<?foreach ($user->UsersView($page) as $value):?>
							<?$s = strtolower($value['countrycode']);?>
							<tr>
								<td class="text-center" id="box"><?=$value['id']?></td>
								<td><?if($sec->CheckBan($value['ip'])==false):?>
									<?=$value['ip']?>
									<?if($value['installed_socks'] == '1'):?>
										<?if($value['s4'] !== '0' && $value['s5'] !== '0' && $value['https'] !== '0'):?>
											<div class="btn-group">
												<button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">P</button>
												<ul class="dropdown-menu dropdown-proxy" role="menu">
													<li>Socks4: <?=$value['s4']?></li>
													<li>Socks5: <?=$value['s5']?></li>
													<li>Http/s: <?=$value['https']?></li>
												</ul>
											</div>
										<?endif;?>
									<?endif;?>
									<?else:?>
									<s data-toggle="tooltip" title="Этот IP Адрес забанен!" class="text-danger"><?=$value['ip']?></s>
									<?endif;?>
								</td>
								<td ><?=$value['userpc']?></td>
								<td ><?=$value['hwid']?></td>
								<td><img src="../template/my/img/flags/<?=$s?>.png" data-toggle="tooltip" title="<?=$user->code_to_country($s)?>"></td>
								<td ><?=str_replace('(unknown)', 'Win8-10', $value['os']);?></td>
								<td><?if($value['isadmin'] == 1):?><i class="ion-plus" style="color:green"></i><?else:?><i class="ion-minus" style="color:red;"></i><?endif;?></td>
								<td><span data-toggle="tooltip" title="2017-<?=$global->ExplodeDataMounthDayTime($value['datereg'])?>" ><?=$global->ExplodeDataMounthDayTime($value['datereg'])?></span></td>
								<td><span data-toggle="tooltip" title="2017-<?=$global->ExplodeData(gmdate("m-d H:i", $value['time']))?>" ><?=$global->ExplodeData(gmdate("m-d H:i", $value['time']))?></span></td>
								<td>
								<?$bot_activity = intval($value['time']);
								  $time = time()-900?>
								<?if($bot_activity > $time):?>
									<span class="ion-record" style="color:green;" data-toggle="tooltip" title="Online"></span>
								<?else:?>
									<?if($bot_activity < ($time-86400)):?>
											<span class="text-muted ion-record" data-toggle="tooltip" title="Dead"></span>
									<?else:?>
										<?if($bot_activity > ($time-86400)):?>
											<span class="text-muted ion-record" data-toggle="tooltip" title="Offline"></span>
										<?endif;?>
									<?endif;?>
								<?endif;?>
								</td>
								<td class="option_action">
									<div class="btn-group">
										<a href="user_delete/<?=$value['id']?>" class="option_table text-muted btn-default btn btn-xs" id="delete" data-toggle="tooltip" title="Удалить" onClick="return window.confirm('Вы действительно хотите удалить бота ID: <?=$value['id']?>?');"><i class="text-muted ion-trash-a"></i></a>
										<a href="banned_ip/<?=$value['ip']?>" class="option_table text-muted btn-default btn btn-xs" id="banned" data-toggle="tooltip" title="Забанить IP" <?if($sec->CheckBan($value['ip'])==true):?>  disabled="disabled" <?else:?>  onClick="return window.confirm('Вы действительно хотите забанить IP: <?=$value['ip']?>?');" <?endif;?> ><i class="text-muted ion-android-close"></i></a>
									</div>
								</td>
							</tr>
						<?endforeach;?>
						<?else:?>
							<tr>
								<td colspan="11" class="text-center">
									Информация отсутствует
								</td>
							</tr>
						<?endif;?>
						</tbody>
					</table>
					</div>
					<div class="col-lg-13">
			<div class="col-sm-6 col-xs-4 text-left" style="padding-left:0;">
				<ul class="pagination pagination-sm" id="pagination">
					<?if($user->CheckCountUsers() > 10):?>
						<?for ($i = 1; $i <= $maxbutt; $i++):
						$pg =  intval(isset($_GET['p']));
						
							if($i == $pg-1):
								
							?>
							
							<li class="active">
								<a href="<?=$i-1?>"> 
										<?=$i-1?>
									</a>
							</li>
								
						<?else:?>
							<li>
								<a href="<?=$i-1?>" > 
										<?=$i-1?>
								</a>
							</li>
						<?endif;
						endfor;
					else:?>
					<li  class="active">1</li>
					<?endif;?>
				</ul>
			</div>
			<div class="col-sm-6 col-xs-8 text-right vibisle-count" style="padding-top:5px;">
				<p>Показано от <span id="users">{min_users}</span> до <span id="max_users">{max_users}</span></p>
			</div>
		</div>
					
					
				</div>
				
		</div>
		
		<script src="//rawgithub.com/stidges/jquery-searchable/master/dist/jquery.searchable-1.0.0.min.js"></script>
		
	<script>
		var butt = '{active_button}';
		$('.content').each(function(){
			$(this).find('.panel-body').css('min-height', '300px');
			$(this).removeClass('content');
		});
		
		<!-- $('.pagination li:eq('+(butt)+')').addClass('active');
		 -->
	

 
	$(function () {
		$( '#table-search' ).searchable({
			striped: true,
			searchType: 'fuzzy'});
			
			$( '#searchable-container' ).searchable({
				searchField: '#container-search',
				selector: '.row',
				childSelector: '.col-xs-4',
				show: function( elem ) {
					elem.slideDown(100);
				},
				hide: function( elem ) {
					elem.slideUp( 100 );
				}
			})
    });	
	</script>
	