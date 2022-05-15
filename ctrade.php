<?php
/*
  if(!$_SERVER['HTTPS']) {
  $protocolo = "https://";
  header( "Location: ".$protocolo.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']);
  }
 */

// Inicia sess�es
session_start();

//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configura��es do servidor
$HTTP_HOST = "http://" . $_SERVER['HTTP_HOST'] . "/$root/";

require_once("include/conexao.inc.php");
require_once("include/banco.php");
require_once("include/config.php");

ini_set('max_execution_time', 0);

$flagmenu = $_GET["flagmenu"];

$painel = 0;

if ($flagmenu == '') {
    $painel = 1;
}

$popup = $_GET["popup"];
if (!$popup) {
    $popup = 0;
}

// Verifica se existe os dados da sess�o de login
if (!isset($_SESSION["id_usuario"]) || !isset($_SESSION["nome_usuario"])) {
    // Usu�rio n�o logado! Redireciona para a p�gina de login
    header("Location: cdefault.php");
    exit;
} else {
    //Verificar a permiss�o do usu�rio referente �s p�ginas que ele pode acessar
    //Primeiro: pegar o nome da p�gina php que o usu�rio est� tentando acessar.
    //Ex: /dtrade/paginaxx.php
    $paginaUrlFull = $_SERVER['PHP_SELF'];

    //Tratar o endere�o recebido, pegando apenas o nome da p�gina acessada
    //Ex: paginaxx.php
    //Segundo: Divide o nome da p�gina pela /
    $arrayUrlFull = explode("/", $paginaUrlFull);

    //Conta quantas posi��es existem no array
    //Como o count come�a a conta pelo n�mero 1, devemos subtrair 1 para pegar a posi��o correta.
    //A vari�vel $auxUrlFull conter� a posi��o do array referente a p�gina acessada
    $auxUrlFull = count($arrayUrlFull) - 1;

    //Com a posi��o correta do array, pegamos o nome da p�gina acessada.
    $paginaAcessada = $arrayUrlFull[$auxUrlFull];
    
    echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=digitacontagem.php'>";
    
}
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
<?php if (!$popup) { ?>
            <title>:: Max Trade :: Vers�o Beta</title>
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            <script src="js/prototype.lite.js"></script>
            <script src="js/moo.ajax.js"></script>
            <script src="js/geral.js"></script>
            <script src="js/menu.js"></script>
            <script language="JavaScript1.2" src="mm_menu.js"></script>
<?php }; ?>

        <!-- incluindo scripts globais jquery -->
<?php include_once('include/css.php'); ?>

        <!-- incluindo scripts globais jquery -->
<?php include_once('include/jquery.php'); ?>
    </head>

    <body onload="history.go(+1)">
        <input type='hidden' name='usuario' id='usuario' value='<? echo $_SESSION['usuario']; ?>'/>
        <input type='hidden' name='HTTP_HOST' id='HTTP_HOST' value='<? echo $HTTP_HOST; ?>'/>

    <tr>
        <td colspan="4"><div align="left">Maxtrade - Coletor</div></td>
    </tr>	

    <tr>
        <td colspan="4"><center>&nbsp;</center></td>
    </tr>	

    <tr>
        <td colspan="4"><a href="conferegru.php" title="Conferencia GRU/VIX" target="_self">Conferencia CD</a></td>
    </tr>
    <tr>
        <td colspan="4"><center>&nbsp;</center></td>
    </tr>	
    <!--tr>
            <td colspan="4"><a href="conferefil.php" title="Conferencia Filial" target="_self">Conferencia Filial</a></td>
    </tr>
    <tr>
            <td colspan="4"><center>&nbsp;</center></td>
    </tr-->		
    <tr>
        <td colspan="4"><a href="conferemat.php" title="Conferencia Matriz" target="_self">Conferencia Matriz</a></td>
    </tr>
    <tr>
        <td colspan="4"><center>&nbsp;</center></td>
    </tr>		
    <tr>
        <td colspan="4"><a href="digitacontagem.php" title="Inventario" target="_self">Inventario</a></td>
    </tr>	
    <tr>
        <td colspan="4"><center>&nbsp;</center></td>
    </tr>	
    <tr>
        <td colspan="4"><a href="cbarrascoletor.php" title="Barras" target="_self">EAN/DUN</a></td>
    </tr>	
    <tr>
        <td colspan="4"><center>&nbsp;</center></td>
    </tr>	
    <tr>
        <td colspan="4"><a href="cubagemcoletor.php" title="Cubagem" target="_self">Cubagem</a></td>
    </tr>	
    <tr>
        <td colspan="4"><center>&nbsp;</center></td>
    </tr>		
    <tr>
        <td colspan="4"><a href="coletorexpedicao.php" title="Expedicao" target="_self">Expedicao</a></td>
    </tr>	
    <tr>
        <td colspan="4"><center>&nbsp;</center></td>
    </tr>	


    <!-- incluindo verificar login e configura�oes no corpo-->
    <script type="text/javascript">
        usuario = new Object();
        usuario = eval('(' + document.getElementById('usuario').value + ')');

        HTTP_ROOT = document.getElementById('HTTP_HOST').value;


        //inclui script de configura��o globais do js
        document.body.appendChild(document.createElement('script')).src = 'lib/jquery/max/config.js';

    </script>
</body>
</html>
