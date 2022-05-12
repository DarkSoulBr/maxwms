<?php
if ($_SERVER['HTTPS'] || $_SERVER["HTTPS"] == "on") {
    $protocolo = "http://";
    header("Location: " . $protocolo . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME']);
}

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
<title>:: CTe ::</title>
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
<body><?php if(!$popup){?>
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

<?php if($flagmenu==1 || $flagmenu==2 || $flagmenu==3 || $flagmenu==4 || $flagmenu==5 || $flagmenu==6 || $flagmenu==7 || $flagmenu==8 || $flagmenu==9){}
else {
   $flagmenu=3;
}?>

<script language="JavaScript1.2">mmLoadMenus(<?php echo $flagmenu ?>);</script>
<?php if($flagmenu==1){ ?>
<img name="menu" src="images/menucompras.gif" width="674" height="50" border="0" usemap="#m_menu" alt=""><map name="m_menu">
<?}else if($flagmenu==2){?>
<img name="menu" src="images/menufaturamento.gif" width="674" height="50" border="0" usemap="#m_menu" alt=""><map name="m_menu">
<?}else if($flagmenu==3){?>
<img name="menu" src="images/menulogistica.gif" width="674" height="50" border="0" usemap="#m_menu" alt=""><map name="m_menu">
<?}else if($flagmenu==4){?>
<img name="menu" src="images/menucadastros.gif" width="674" height="50" border="0" usemap="#m_menu" alt=""><map name="m_menu">
<?}else if($flagmenu==5){?>
<img name="menu" src="images/menuestoque.gif" width="674" height="50" border="0" usemap="#m_menu" alt=""><map name="m_menu">
<?}else if($flagmenu==6){?>
<img name="menu" src="images/menuutil.gif" width="674" height="50" border="0" usemap="#m_menu" alt=""><map name="m_menu">
<?}else if($flagmenu==7){?>
<img name="menu" src="images/menucaixa.gif" width="674" height="50" border="0" usemap="#m_menu" alt=""><map name="m_menu">
<?}else if($flagmenu==8){?>
<img name="menu" src="images/menuvarejo.gif" width="674" height="50" border="0" usemap="#m_menu" alt=""><map name="m_menu">
<?}else if($flagmenu==9){?>
<img name="menu" src="images/menuatacado.gif" width="674" height="50" border="0" usemap="#m_menu" alt=""><map name="m_menu">
<?}else {?>
<img name="menu" src="images/menudeposito.gif" width="674" height="50" border="0" usemap="#m_menu" alt=""><map name="m_menu">
<?}?>
<area shape="rect" coords="473,15,562,33" href="#" alt="" onMouseOut="MM_startTimeout();"  onClick="MM_showMenu(window.mm_menu_0517152555_0,473,33,null,'menu');"  >
<area shape="rect" coords="383,15,472,33" href="#" alt="" onMouseOut="MM_startTimeout();"  onClick="MM_showMenu(window.mm_menu_0517152554_0,383,33,null,'menu');"  >
<area shape="rect" coords="293,15,382,33" href="#" alt="" onMouseOut="MM_startTimeout();"  onClick="MM_showMenu(window.mm_menu_0517152553_0,293,33,null,'menu');"  >
<area shape="rect" coords="203,15,292,33" href="#" alt="" onMouseOut="MM_startTimeout();"  onClick="MM_showMenu(window.mm_menu_0517152552_0,203,33,null,'menu');"  >
<area shape="poly" coords="116,15,206,15,206,33,116,33,116,15" href="#" alt="" onMouseOut="MM_startTimeout();"  onClick="MM_showMenu(window.mm_menu_0314111426_0,116,33,null,'menu');"  >
<area shape="rect" coords="27,15,116,33" href="#" alt="" onMouseOut="MM_startTimeout();"  onClick="MM_showMenu(window.mm_menu_0108112640_0,27,33,null,'menu');"  >


</map>
<?php };?>
<div>
<Center>
</Center>
</div>
<br>
</body>
</html>

