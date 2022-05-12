<?php
/*
if(!$_SERVER['HTTPS']) {
$protocolo = "https://";
header( "Location: ".$protocolo.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']);
}
*/

// Inicia sess�es
session_start();

require_once("include/conexao.inc.php");
require_once("include/banco.php");

// Verifica se existe os dados da sess�o de login
if(!isset($_SESSION["id_usuario"]) || !isset($_SESSION["nome_usuario"]))
{
    // Usu�rio n�o logado! Redireciona para a p�gina de login
    header("Location: login.html");
    exit;
}
else
{
	//Verificar a permiss�o do usu�rio referente �s p�ginas que ele pode acessar
	//Primeiro: pegar o nome da p�gina php que o usu�rio est� tentando acessar.
	//Ex: /dtrade/paginaxx.php
	$paginaUrlFull = $_SERVER['PHP_SELF'];

	//Tratar o endere�o recebido, pegando apenas o nome da p�gina acessada
	//Ex: paginaxx.php
	//Segundo: Divide o nome da p�gina pela /
	$arrayUrlFull = explode("/",$paginaUrlFull);

	//Conta quantas posi��es existem no array
	//Como o count come�a a conta pelo n�mero 1, devemos subtrair 1 para pegar a posi��o correta.
	//A vari�vel $auxUrlFull conter� a posi��o do array referente a p�gina acessada
	$auxUrlFull = count($arrayUrlFull) - 1;

	//Com a posi��o correta do array, pegamos o nome da p�gina acessada.
	$paginaAcessada = $arrayUrlFull[$auxUrlFull];
	
	//Usuario MOR pode acessar qualquer op��o
	if($_SESSION["id_usuario"]==359 || $_SESSION["id_usuario"]==626){
	}
	else {
	if($paginaAcessada=='cte.php'){
	}
    else{
	
	}
	}
}

$popup = $_GET["popup"];
if (!$popup)
{
	$popup = 0;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Tabela</title>
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT= "NO-CACHE">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script src="js/prototype.lite.js"></script>
<script src="js/moo.ajax.js"></script>
<script src="js/geral.js"></script>
<script src="js/validaie.js"></script>
<script src="js/validacnpj.js">
</script><?php if(!$popup){?>
<script src="js/menu.js"></script>
<script language="JavaScript1.2" src="mm_menu.js"></script>
<?php };?>
<noscript>
Habilite o Javascript para visualizar esta p�gina corretamente...
</noscript>
<style>
.borda{border: 1px solid;}
div{font-family: Verdana; font-size: 12px;}
td{font-family: Verdana; font-size: 12px;}
input{font-family: Verdana; font-size: 12px;}
select{font-family: Verdana; font-size: 12px;}
</style>

</head>

</html>

