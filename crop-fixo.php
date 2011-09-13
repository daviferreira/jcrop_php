<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>JCrop - Crop fixo</title>
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery.Jcrop.js"></script>
		<link rel="stylesheet" href="css/exemplo.css" type="text/css" />
		<link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css" />
	</head>
	<body>
		
		<?php include( 'bar.php'); ?>
		
		<h1>JCrop - Crop fixo</h1>
		
		<?php
			// memory limit (nem todo server aceita)
			ini_set("memory_limit","50M");
			set_time_limit(0);
			
			// processa arquivo
			$imagem		= ( isset( $_FILES['imagem'] ) && is_array( $_FILES['imagem'] ) ) ? $_FILES['imagem'] : NULL;
			$tem_crop	= false;
			$img		= '';
			// valida a imagem enviada
			if( $imagem['tmp_name'] )
			{
				// armazena dimensões da imagem
				$imagesize = getimagesize( $imagem['tmp_name'] );
				
				if( $imagesize !== false )
				{
					// move a imagem para o servidor
					if( move_uploaded_file( $imagem['tmp_name'], $imagem['name'] ) )
					{
						include( 'm2brimagem.class.php' );
						$oImg = new m2brimagem( $imagem['name'] );
						// valida via m2brimagem
						if( $oImg->valida() == 'OK' )
						{
							// redimensiona (opcional, só pra evitar imagens muito grandes)
							$oImg->redimensiona( '500', '', '' );
							// grava nova imagem
							$oImg->grava( $imagem['name'] );
							// novas dimensões da imagem
							$imagesize 	= getimagesize( $imagem['name'] );
							$img		= '<img src="'.$imagem['name'].'" id="jcrop" '.$imagesize[3].' />';
							$preview	= '<img src="'.$imagem['name'].'" id="preview" '.$imagesize[3].' />';
							$tem_crop 	= true;	
						}
					}
				}
			}
		?>
		
		<?php if( $tem_crop === true ): ?>
			<h2 id="tit-jcrop">Recorte a imagem</h2>
			<div id="div-jcrop">
				
				<div id="div-preview">
					<?php echo $preview; ?>
				</div>
				
				<?php echo $img; ?>
				
				<input type="button" value="Salvar" id="btn-crop" />
			</div>
			<div id="debug">
				<p><strong>X</strong> <input type="text" id="x" size="5" disabled /> x <input type="text" id="x2" size="5" disabled /> </p>
				<p><strong>Y</strong> <input type="text" id="y" size="5" disabled /> x <input type="text" id="y2" size="5" disabled /> </p>
				<p><strong>Dimensões</strong> <input type="text" id="h" size="5" disabled /> x <input type="text" id="w" size="5" disabled /></p>
			</div>
			<script type="text/javascript">
				var img = '<?php echo $imagem['name']; ?>';
			
				$(function(){
					$('#jcrop').Jcrop({
						onChange: exibePreview,
						onSelect: exibePreview,
						minSize		: [ 200, 200 ],
						maxSize		: [ 200, 200 ],
						allowResize	: false,
						addClass	: 'custom'
					});
					$('#btn-crop').click(function(){
						$.post( 'crop.php', {
							img:img, 
							x: $('#x').val(), 
							y: $('#y').val(), 
							w: $('#w').val(), 
							h: $('#h').val()
						}, function(){
							$('#div-jcrop').html( '<img src="' + img + '?' + Math.random() + '" width="'+$('#w').val()+'" height="'+$('#h').val()+'" />' );
							$('#debug').hide();
							$('#tit-jcrop').html('Feito!<br /><a href="exemplo2.php">enviar outra imagem</a>');
						});
						return false;
					});
				});
				
				function exibePreview(c)
				{
					var rx = 100 / c.w;
					var ry = 100 / c.h;
				
					$('#preview').css({
						width: Math.round(rx * <?php echo $imagesize[0]; ?>) + 'px',
						height: Math.round(ry * <?php echo $imagesize[1]; ?>) + 'px',
						marginLeft: '-' + Math.round(rx * c.x) + 'px',
						marginTop: '-' + Math.round(ry * c.y) + 'px'
					});
					
					$('#x').val(c.x);
					$('#y').val(c.y);
					$('#x2').val(c.x2);
					$('#y2').val(c.y2);
					$('#w').val(c.w);
					$('#h').val(c.h);
					
				};
			</script>
		<?php else: ?>
			<form name="frm-jcrop" id="frm-jcrop" method="post" action="crop-fixo.php" enctype="multipart/form-data">
				<p>
					<label>Envie uma imagem:</label>
					<input type="file" name="imagem" id="imagem" />
					<input type="submit" value="Enviar" />
				</p>
			</form>
		<?php endif; ?>
		
	</body>
</html>