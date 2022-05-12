<?php

require_once("include/conexao.inc.php");

$usuario = $_GET["usuario"];
$opcao = $_GET["opcao"];

$where = "usucodigo = " . $usuario;

$codigo = 0;

$sql = "Select tpacodigo FROM tipoacesso where tpacod = '$opcao'";
$cad = pg_query($sql);
if (pg_num_rows($cad)) {
    $codigo = pg_fetch_result($cad, 0, "tpacodigo");
}

header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
$xml .= "<dados>";

/*
  //Verifica se o usuário tem acesso a opção desejada
  $sql = "Select tpacodigo FROM usuariosacessos where $where and tpacodigo = $codigo";
  $cad = pg_query($sql);
  if (pg_num_rows($cad)) {
  $xml .= "<registro>";
  $xml .= "<item>S</item>";
  $xml .= "</registro>";
  } else {
  $xml .= "<registro>";
  $xml .= "<item>N</item>";
  $xml .= "</registro>";
  }
 * 
 */

$xml .= "<registro>";
$xml .= "<item>S</item>";
$xml .= "</registro>";

$xml .= "</dados>";

echo $xml;
pg_close($conn);
exit();
