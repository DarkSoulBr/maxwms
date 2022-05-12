<?php
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
/*
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
	if($_SESSION["id_usuario"]==359){
	}
	else {
	if($paginaAcessada=='dtrade.php'){
	}
    else{
	//Testar se o usuário possui permissão para visualizar à página.
	$objBanco = new banco($conn,$db);
	$queryUrlAcesso = $objBanco->seleciona("usuariosacessos.tpacodigo","usuariosacessos,tipoacesso,acessospaginas","usuariosacessos.tpacodigo=tipoacesso.tpacodigo and tipoacesso.tpacod=acessospaginas.acpcod and usuariosacessos.usucodigo=".$_SESSION["id_usuario"]." and acessospaginas.acppagina like '".$paginaAcessada."'");

	//Caso o usuário não tenha acesso, será redirecionado, senão continua a execução do sistema
	if(pg_num_rows($queryUrlAcesso)<=0)
	{
		//Mostra a mensagem de Área Restrita por 2 segundos
		print("<center><br><br><b>Acesso Negado!</b></center>");
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='2;URL=dtrade.php?flagmenu=$flagmenu'>";
		//header("Location: login.html");
    	exit;
	}
	}
	}
*/	
	
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Tabela</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script src="js/prototype.lite.js"></script>
<script src="js/moo.ajax.js"></script>
<script src="js/geral.js"></script>

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
<body>
<table width="700">
<tr>
<td width="690">
<div style="width: 100%; height: 74px; margin: 0 auto; background: #000000 url(images/topo2.png);">
<div style="float:left; "><img src="images/topo1.png"></div>
<div style="float:left; text-align:center; width:66%;"><img src="images/topo21.gif"></div>
<div style=" float:right;"><img src="images/topo3.png"></div>
</td>
</tr>
</table>

<div>
<Center>
</Center>
</div>
<br>
</body>
</html>

