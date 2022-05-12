<?php

require_once("include/conexao.inc.php");
require("verifica2.php");
$usuario = $_GET["usuario"];

$where = "usucodigo = " . $usuario;

$codigo1 = 0;

$sql = "Select usunivel FROM usuarios where $where ";
$cad = pg_query($sql);
if (pg_num_rows($cad)) {
    $codigo1 = pg_fetch_result($cad, $i, "usunivel");
}

header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
$xml .= "<dados>";

$xml .= "<registro>";
$xml .= "<item>" . $codigo1 . "</item>";
$xml .= "</registro>";

$xml .= "</dados>";

echo $xml;
pg_close($conn);
exit();
?>