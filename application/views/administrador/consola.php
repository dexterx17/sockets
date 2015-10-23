<!DOCTYPE html>
<html>
<head>
	<title>CONSOLA DE SOCKETS</title>
	<script src="<?php echo site_url('js'); ?>/jquery-2.1.4.min.js"></script>
	<script src="<?php echo site_url('js'); ?>/jquery-2.1.4.min.js"></script>
	<script src="<?php echo site_url('js'); ?>/fancywebsocket.js"></script>
	<script src="<?php echo site_url('js'); ?>/socket.js"></script>
	<script src="<?php echo site_url('js'); ?>/bootstrap.js"></script>

    <!-- Bootstrap -->
    <link href="<?php echo site_url('css'); ?>/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<h1>TELEOPERACION</h1>
<div class="row text-center" >	
	<input type=" origen" name="origen" value="" placeholder="Origen" class="origen"/>
	<select name="destino" value="" placeholder="destino" class="destino">
	<option value="silla">Silla</option>
	<option value="falcon">Falcon</option>
	<option value="brazo">Brazo</option>
	</select>

	<textarea type=" text" name="texto1" value="" placeholder="Ingrese Texto" class="texto1"></textarea>
	<button type="button" class="button">Enviar</button>

</div>
<div class="row">
	<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Silla
			</div>
			<div class="panel-body" id='silla'>	
			
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Animacion3d
			</div>
			<div class="panel-body" id='animacion'>	
			
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Falcon
			</div>
			<div class="panel-body" id='falcon'>	
			
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Brazo
			</div>
			<div class="panel-body" id='brazo'>	
			
			</div>
		</div>
	</div>
</div>


</body>
</html>