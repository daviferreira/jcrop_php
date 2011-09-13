<?php
if( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
	include( 'm2brimagem.class.php' );
	$oImg = new m2brimagem( $_POST['img'] );
	if( $oImg->valida() == 'OK' )
	{
		$oImg->posicaoCrop( $_POST['x'], $_POST['y'] );
		$oImg->redimensiona( $_POST['w'], $_POST['h'], 'crop' );
		$oImg->grava( $_POST['img'] );
	}
}
exit;