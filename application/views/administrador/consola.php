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

	 <!-- Video -->
		<script src="<?php echo site_url('js'); ?>/firebase.js"></script>
	<script src="<?php echo site_url('js'); ?>/RTCPeerConnection-v1.5.js"></script>
	<script src="<?php echo site_url('js'); ?>/broadcast.js"></script>
	<script src="<?php echo site_url('js'); ?>/DetectRTC.js"></script>
	<style type="text/css">
body{
	//background-image: url("fondo.jpg");
}
</style>


</head>
<body  >
<h1><center><b>TELEOPERACIÓN BILATERAL DE MÚLTIPLES MANIPULADORES MÓVILES</b></center></h1>
	<br>	
	<br>	
<div class="row text-center" >	
	<div class="panel panel-default">
			<div class="panel-heading">
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
</div>
</div>

<div class="row text-center" id = "cliente" class ="row">

</div>
<br>	

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
				Administrador
			</div>
			<div class="panel-body" id='admin'>	
			
			</div>
		</div>
	</div>
</div>
<br>	

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
<br>	

<div class="row">
	<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Streaming
	
		
			</div>
			<div class="panel-body" id='streaming'>	
			<section class="experiment"> 
        <div id="videos-container"></div>
    </section>
	<script src="<?php echo site_url('js'); ?>/streaming.js" type="text/javascript"></script>
			</div>
		</div>
	</div>
	
	<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Consola
			</div>
			<div class="panel-body" id='consola'>	
			
			</div>
		</div>
	</div>
</div>

</body>
</html>