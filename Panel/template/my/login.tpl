<legend>
	<h4 class="text-center" style="margin-bottom:30px;">Авторизация</h4>
</legend>



<div class="form-horizontal login-form">

<fieldset>
<form action="../application/api.php" method="get">
<input type="hidden" id="type" name="type" value="login">
<input type="hidden" name="form" value="1">

<div class="form-group">
  <label class="col-md-4 control-label" for="login">Login:</label>  
  <div class="col-md-4">
    <input id="emai" name="login" type="text" placeholder="Введите логин" class="form-control input-sm">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="pass">Pass:</label>
  <div class="col-md-4">
    <input id="pass" name="password" type="password" placeholder="Введите пароль" class="form-control input-sm">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="auth"></label>
  <div class="col-md-8">
    <button id="auth" class="btn btn-success btn-sm">Войти</button>
  </div>
</div>
</form>
</fieldset>
</div>

<script>
$('.main-container').find('.col-md-10:eq(0)').width('100%');
</script>
