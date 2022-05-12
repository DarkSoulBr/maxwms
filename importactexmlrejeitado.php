<?php
$flagmenu=2;
$parametro = $_GET["parametro"];

require("verifica.php");

$data = date('dmY');

echo "<center><strong> Processando CTe (Rejeitados)! </strong></center>";
echo "<center><strong> Arquivos devem estar na pasta: </strong></center>";
echo "<br>";
echo "<center><strong> /home/delta/cte/Retorno/ </strong></center>";
echo "<br>";
echo "<meta HTTP-EQUIV='Refresh' CONTENT='5;URL=importageractexmlrejeitado.php'>";
echo "<center><strong><input type='button' id='botao' onClick=window.open('importactexmlrejeitado2.php','_self') value='VOLTAR'></strong></center>";
exit;

