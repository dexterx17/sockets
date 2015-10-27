<!DOCTYPE html>
<html>
<head>
	<title>CONSOLA DE SOCKETS</title>
	<script src="<?php echo site_url('js'); ?>/jquery-2.1.4.min.js"></script>
	<!--<script src="<?php echo site_url('js'); ?>/fancywebsocket.js"></script>
	<script src="<?php echo site_url('js'); ?>/socket.js"></script>-->
	<script src="<?php echo site_url('js'); ?>/bootstrap.js"></script>
	<script src="<?php echo site_url('js'); ?>/firebase.js"></script>
	<script src="<?php echo site_url('js'); ?>/RTCPeerConnection-v1.5.js"></script>
	<script src="<?php echo site_url('js'); ?>/broadcast.js"></script>
	<script src="<?php echo site_url('js'); ?>/DetectRTC.js"></script>

    <!-- Bootstrap -->
    <link href="<?php echo site_url('css'); ?>/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<h1>TELEOPERACION</h1>
  <!-- copy this <section> and next <script> -->
            <section class="experiment">                
                <!-- local/remote videos container -->
                <div id="videos-container"></div>
            </section>
	<script src="<?php echo site_url('js'); ?>/streaming.js" type="text/javascript"></script>
</body>
</html>

