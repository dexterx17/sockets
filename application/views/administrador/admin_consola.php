<!DOCTYPE html>
<html>
<head>
	<title>TELEOPERACION - Admin Consola</title>
	<script src="<?php echo site_url('js'); ?>/jquery-2.1.4.min.js"></script>
	<script src="<?php echo site_url('js'); ?>/jquery-2.1.4.min.js"></script>
	<script src="<?php echo site_url('js'); ?>/fancywebsocket.js"></script>
	<script src="<?php echo site_url('js'); ?>/socket.js"></script>
	<script src="<?php echo site_url('js'); ?>/bootstrap.js"></script>

    <!-- Bootstrap -->
    <link href="<?php echo site_url('css'); ?>/bootstrap.min.css" rel="stylesheet">
    <link rel="canonical" href="http://themes.getbootstrap.com/products/dashboard" >
	 <!-- Video -->
		<script src="<?php echo site_url('js'); ?>/firebase.js"></script>
	<script src="<?php echo site_url('js'); ?>/RTCPeerConnection-v1.5.js"></script>
	<script src="<?php echo site_url('js'); ?>/broadcast.js"></script>
	<script src="<?php echo site_url('js'); ?>/DetectRTC.js"></script>

</head>
<body>
<h2>Administracion</h2>
				


<input type="button" value="Conectar" id="btnConectar" >	<input type="button" value="Desconectar" id="btnDesconectar">


<br>


<br>


		
<input type="text" name="txtenvio" id ='txtenvio' placeholder="Ingrese código de terminal linux">  <input type="button" value="ejecutar"id="btnejecutar" >


<br>
<br>
<textarea type=" text" name="txtconsola" id="txtconsola" rows="6" cols="50" class="texto1"></textarea>
		
</body>
</html>