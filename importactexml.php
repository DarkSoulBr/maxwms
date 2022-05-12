<?php
$flagmenu=2;
$parametro = $_GET["parametro"];

require("verifica.php");

$data = date('dmY');

echo "<center><strong> Processando CTe (Autorizados)! </strong></center>";
echo "<center><strong> Arquivos devem estar na pasta: </strong></center>";
echo "<br>";
echo "<center><strong> /home/delta/cte/Enviado/Autorizados/$data/ </strong></center>";
echo "<br>";
echo "<meta HTTP-EQUIV='Refresh' CONTENT='5;URL=importageractexml.php'>";
echo "<center><strong><input type='button' id='botao' onClick=window.open('importactexml2.php','_self') value='VOLTAR'></strong></center>";
exit;

