<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>JCrop - exemplo 1</title>
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery.Jcrop.js"></script>
		<link rel="stylesheet" href="css/exemplo.css" type="text/css" />
		<link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css" />
	</head>
	<body>
		
		<?php include( 'bar.php'); ?>
		
		<h1>JCrop - Exemplo 1</h1>
		
		<p><img src="_img/robot.jpg" width="400" height="691" id="imagem" /></p>
		
		<script type="text/javascript">
		$(function(){
			$('#imagem').Jcrop();
		});
		</script>
		
	</body>
</html>