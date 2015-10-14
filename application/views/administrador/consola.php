<!DOCTYPE html>
<html>
<head>
	<title>CONSOLA DE SOCKETS</title>
	<script src="<?php echo site_url('js'); ?>/jquery-2.1.4.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){

		$('#consola').append('hola taz');
		
	});
	</script>
</head>
<body>

<div id="consola">
	
</div>

<?php 
foreach ($paquete as $key => $value) {
	echo $key.$value; 
}
?>
</body>
</html>