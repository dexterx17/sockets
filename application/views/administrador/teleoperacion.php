<!DOCTYPE html>
<html>
<head>
	<title>Teleoperacion</title>
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


<script language="JavaScript">

function ventanaNueva(documento){	
	window.open(documento,'nuevaVentana','width=500, height=500');
}

function grafica(documento){	
	window.open(documento,'nuevaVentana','width=1000, height=1000');
}

</script>

</head>

<body >

<h1><center><b>TELEOPERACIÓN BILATERAL DE MÚLTIPLES MANIPULADORES MÓVILES</b></center></h1>
	<br>	
	<br>	

<div class="row text-center" >	
	<div class="panel panel-default">
			<div class="panel-heading">
				<p><b>Datos Controlador</b></p>


					<div class="row" >
						<div class="col-lg-2">
						<div class="panel panel-default">
							<div class="panel-heading">
								Cliente Conectado
							</div>
							<div class="panel-body" id='cliente'>	
				
						</div>
					</div>
				</div>
			


				<div class="row">
				<div class="col-lg-2">
					<div class="panel panel-default">
						<div class="panel-heading">
							Datos
						</div>
						<div class="panel-body" id='datos'>	
						
						</div>
					</div>
				</div>

			<div class="col-lg-2">
				<div class="panel panel-default">
					<div class="panel-heading">
						Estado
					</div>
					<div class="panel-body" id='estado'>	
					
					</div>
				</div>
			</div>




				<div class="col-lg-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						 	Datos Motores
					</div>
					<div class="panel-body" id='motor'>	
					
					</div>
				</div>
			</div>

						<div class="col-lg-2">
				<div class="panel panel-default">
					<div class="panel-heading">
						Tiempo Respuesta
					</div>
					<div class="panel-body" id='tiempo'>	
					
					</div>
				</div>
			</div>



		</div>
	</div>
</div>




<div class="row text-center" >	
	<div class="panel panel-default">
			<div class="panel-heading">
				<p><b>Datos Plataforma</b></p>


					<div class="row" >
						<div class="col-lg-2">
						<div class="panel panel-default">
							<div class="panel-heading">
								Cliente Conectado
							</div>
							<div class="panel-body" id='cliente1'>	
				
						</div>
					</div>
				</div>
			


				<div class="row">
				<div class="col-lg-2">
					<div class="panel panel-default">
						<div class="panel-heading">
							Datos
						</div>
						<div class="panel-body" id='datos1'>	
						
						</div>
					</div>
				</div>

			<div class="col-lg-2">
				<div class="panel panel-default">
					<div class="panel-heading">
						Estado
					</div>
					<div class="panel-body" id='estado1'>	
					
					</div>
				</div>
			</div>



				<div class="col-lg-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						 	Datos Motores
					</div>
					<div class="panel-body" id='motor1'>	
					
					</div>
				</div>
			</div>

						<div class="col-lg-2">
				<div class="panel panel-default">
					<div class="panel-heading">
						Tiempo Respuesta
					</div>
					<div class="panel-body" id='tiempo'>	
					
					</div>
				</div>
			</div>


		</div>
	</div>
</div>


<div class="row text-center" >	
	<div class="panel panel-default">
			<div class="panel-heading">
				<p><b>Estado Dispositivos</b></p>

		<div class="col-lg-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						 	Datos 
					</div>
					<div class="panel-body" id='dispositivos'>	
					Plataforma    <center><input type="text" name="interfaz1" id ='interfaz1'>  <input type="text" name="resultado1" id ='resultado1'>  <input type="text" name="status1" id ='status1'> </center>
							
				
				Proceso Plataforma <center>        <input type="text" name="interfaz" id ='interfaz'>  <input type="text" name="resultado" id ='resultado'>  <input type="text" name="status" id ='status'></center>
				  
				<br>	
				<br>	
					
				Video     <center>  <input type="text" name="interfaz2" id ='interfaz2'>  <input type="text" name="resultado2" id ='resultado2'>  <input type="text" name="status2" id ='status2'> </center>
				
				
				Proceso Video    <center><input type="text" name="interfaz3" id ='interfaz3'>  <input type="text" name="resultado3" id ='resultado3'>  <input type="text" name="status3" id ='status3'> </center>



					
					</div>
				</div>
			</div>
				

<div class="row">
				<div class="col-lg-5">
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




		</div>
	</div>
</div>








<br>
<br>
<br>
<div class="row text-center" >	
	<div class="panel panel-default">
			<div class="panel-heading">
			<p><b>Control Clientes </b></p>
				
	<div class="row" >
	<div class="col-lg-8" >
		<div class="panel panel-default">
			<div class="panel-heading">
				Datos de Consola
			</div>
			<div  id='consola' style='height:220px;width:1307px;border:1px solid #ccc;font:16px/26px ;overflow:auto;'>	



						</div>
					</div>
				</div>


						
			<div class="col-lg-2">
				<div class="panel panel-default">
					<div class="panel-heading">
						Panel Administrador
					</div>
					<div class="panel-body" id='admin'>	
				<input type="button" id ='btnAbrir' value="Abrir ventana" onclick="ventanaNueva('<?php echo site_url('index.php/Administrador/consola'); ?> ')"/>

				<input type="button" id ='btn3D' value="Abrir 3D" onclick="grafica('<?php echo site_url('index.php/Administrador/grafica'); ?> ')"/>
					
					</div>
				</div>
			</div>

	

		</div>
	</div>
</div>




</body>
</html>