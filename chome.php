<?php

/*
if(!$_SERVER['HTTPS']) {
$protocolo = "https://";
header( "Location: ".$protocolo.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']);
}
*/

?>
<html>
	<head>
		<title>::MAX TRADE::</title>

		<!-- incluindo scripts globais css -->
		<link rel="stylesheet" type="text/css" media="screen" href="css/estilo.css" />

		<!-- incluindo scripts ui-jquery css -->
		<link rel="stylesheet" type="text/css" media="screen" href="css/ui-jquery/jquery-ui-1.7.2.custom.css" />

		<!-- incluindo scripts globais jquery -->
		<?php include_once('include/jquery.php'); ?>
	</head>

	<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0" onload="history.go(+1)">

		<?php require_once('modulos/clogin/view/login.php'); ?>

	</body>
</html>