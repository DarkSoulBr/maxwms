<?php

$flagmenu = 6;
$parametro = $_GET["parametro"];

require("verifica.php");

$usuario = $_SESSION["id_usuario"];

require_once("include/conexao.inc.php");

echo "<center><strong> Processando Notas Fiscais Eletronicas! </strong></center>";
echo "<center><strong> Arquivos devem estar na pasta: </strong></center>";
echo "<br>";
echo "<center><strong> /home/delta/nfe </strong></center>";
echo "<br>";
echo "<meta HTTP-EQUIV='Refresh' CONTENT='5;URL=importageranfe.php'>";
echo "<center><strong><input type='button' id='botao' onClick=window.open('importanfe2.php','_self') value='VOLTAR'></strong></center>";
exit;
?>
