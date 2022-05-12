<?php
/*
if(!$_SERVER['HTTPS']) {
$protocolo = "https://";
header( "Location: ".$protocolo.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']);
}
*/

// Inicia sessões
session_start();

require_once("include/conexao.inc.php");
require_once("include/banco.php");

// Verifica se existe os dados da sessão de login
if(!isset($_SESSION["id_usuario"]) || !isset($_SESSION["nome_usuario"]))
{
    // Usuário não logado! Redireciona para a página de login
    header("Location: login.html");
    exit;
}
else
{
	//Verificar a permissão do usuário referente às páginas que ele pode acessar
	//Primeiro: pegar o nome da página php que o usuário está tentando acessar.
	//Ex: /dtrade/paginaxx.php
	$paginaUrlFull = $_SERVER['PHP_SELF'];

	//Tratar o endereço recebido, pegando apenas o nome da página acessada
	//Ex: paginaxx.php
	//Segundo: Divide o nome da página pela /
	$arrayUrlFull = explode("/",$paginaUrlFull);

	//Conta quantas posições existem no array
	//Como o count começa a conta pelo número 1, devemos subtrair 1 para pegar a posição correta.
	//A variável $auxUrlFull conterá a posição do array referente a página acessada
	$auxUrlFull = count($arrayUrlFull) - 1;

	//Com a posição correta do array, pegamos o nome da página acessada.
	$paginaAcessada = $arrayUrlFull[$auxUrlFull];
	
	//Usuario MOR pode acessar qualquer opção
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
Habilite o Javascript para visualizar esta página corretamente...
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

