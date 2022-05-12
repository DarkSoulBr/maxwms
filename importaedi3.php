<?php

$flagmenu = 6;
require("verifica.php");

require_once("include/conexao.inc.php");

//Verifica se a opção existe no Cadastros de Opção
$opcao = 'DESTRAVA IMPORTACAO EDI';
$pagina = 'importaedi3.php';
$modulo = 6;  //Utilitarios
$sub = 27;  //Importacao
$usuario = $_SESSION["id_usuario"];


$sql = "Update parametros set usucodigoedi = 0 Where parcodigos = 1 ";
$sql = pg_query($sql);

echo "<center><strong>Registros Destravados! </strong></center>";
echo "<meta HTTP-EQUIV='Refresh' CONTENT='3;URL=maxwms.php?flagmenu=6'>";
exit;
?>
