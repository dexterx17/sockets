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
				<p><b>Información General</b></p>
					
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


			<div class="col-lg-2">
				<div class="panel panel-default">
					<div class="panel-heading">
						Dirección 	IP
					</div>
					<div class="panel-body" id='ip'>	
					
					</div>
				</div>
			</div>

				<div class="col-lg-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						 	Tiempo
					</div>
					<div class="panel-body" id='tiempo'>	
					
					</div>
				</div>
			</div>


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


							<div class="col-lg-2">
								<div class="panel panel-default">
									<div class="panel-heading">
										Dirección 	IP
									</div>
									<div class="panel-body" id='ip1'>	
									
									</div>
								</div>
							</div>
									<div class="col-lg-3">
								<div class="panel panel-default">
									<div class="panel-heading">
										 	Tiempo
									</div>
									<div class="panel-body" id='tiempo1'>	
									
									</div>
								</div>
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
	<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Silla
			</div>
			<div class="panel-body" id='silla'>	

<TABLE >
	<TR>
		<TD>TTYS</TD> <TD><input type=" text" name="ttys" id ='ttys' value="" placeholder="ttys " class="ttys"></text></TD>  <TD>Estado</TD> <TD><input type=" text" name="estadoT" id = 'estadoT'
		value="" placeholder="Estado TTY " class="estadoT"></text>	</TD>

	</TR>
	<TR>
		<TD>Silla</TD> <TD><input type=" text" id='txtsilla' name="txtsilla" value="" placeholder="Silla " class="txtsilla"></text></TD>  <TD>Estado</TD> <TD><input type=" text" name="txtEstadoSilla" id ='txtEstadoSilla' value="" placeholder="Estado Silla" class="txtEstadoSilla"></text>	</TD>
	</TR>
		<TR>
		<TD>Video</TD> <TD><input type=" text" id = 'video' name="video" value="" placeholder="Video " class="video"></text></TD>  <TD>Estado</TD> <TD><input type=" text" name="estadoV" value="" placeholder="Estado Video" class="estadoV"></text>	</TD>
	</TR>
	
	
		</TABLE>




						</div>
					</div>
				</div>


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
			<br>	


	

		</div>
	</div>
</div>

</body>
</html>