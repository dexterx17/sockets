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
	
	<select name="seleccion" id="seleccion" placeholder="seleccion" class="seleccion">
	<option value="silla">Silla</option>
	<option value="falcon">Falcon</option>
	<option value="brazo">Brazo</option>
	<option value="admin">Administrador</option>
	</select>

	<button type="button" class="seleccionar">Seleccionar</button>
	<textarea type=" text" name="texto1" value="" placeholder="Ingrese Texto" class="texto1"></textarea>
	<select name="destino" id="destino" placeholder="destino" class="destino">

	</select>
	<button type="button" class="button">Enviar</button>

</div>



<div id = "cliente" class ="row">

</div>

<div class="row" >
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