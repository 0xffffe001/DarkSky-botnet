
            <div class="panel panel-default">
                <div class="panel-heading">
                    Шифрование строк
                </div>
                <div class="panel-body">
                	<div class="col-md-offset-1 col-md-10">
						<p><textarea class="form-control" rows="5" placeholder="Encrypt text" name="encrypt" id="one"></textarea></p>
						<p><textarea class="form-control" rows="5" placeholder="Decrypt text" name="decrypt" id="two"></textarea></p>
						<div class="col-md-6 btn-group" style="padding-left:0;">
							<button class="btn btn-success btn-sm" id="cryptdata1">Encrypt send data</button>
							<button class="btn btn-primary btn-sm" id="cryptdata2">Decrypt send data</button>
							
						</div>
						<div class="col-md-6 btn-group text-right" style="padding-left:0;">
							<div class="col-xs-offset-4">
								<button class="btn btn-success btn-sm" id="hextostr">Encrypt Hex</button>
								<button class="btn btn-primary btn-sm" id="strtohex">Decrypt Hex</button>
							</div>
						</div>
					</div>
               </div>
	</div>


<script>



$('#hextostr').click(function(){
var one = $('#one').text();
var two = $('#two').text();
	$.get( '../application/api.php?type=crypt&method=hextostr&encrypt='+$('#one').val())
  	.done(function( data ) {
		if(data.length > 0){
			if(one.length == 0){
				$('#two').html(data);
			} else {
				alert('Error: please insert your text!'); 
			}
		};
	});
});

$('#strtohex').click(function(){
	$.get( '../application/api.php?type=crypt&method=hextostr&decrypt='+$('#two').val())
  	.done(function( data ) {
		if(data.length > 0){
			$('#one').html('');
			$('#one').html(data);
		};
	});
});

$('#cryptdata1').click(function(){

	$.get( '../application/api.php?type=crypt&encrypt='+$('#one').val())
  	.done(function( data ) {
		if(data.length > 0){
			$('#two').html('');
			$('#two').html(data);
		};
	});
});
$('#cryptdata2').click(function(){
	$.get( "../application/api.php?type=crypt&decrypt="+$('#two').val())
  	.done(function( data ) {
		if(data.length > 0){
			$('#one').html('');
			$('#one').html(data);
		};
	});
});
</script>