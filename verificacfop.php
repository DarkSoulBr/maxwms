<?php

require_once("include/conexao.inc.php");

$cfop = $_GET["cfop"];

$sql = "Select cfonome FROM cfop where cfocod = '$cfop' ";
$cad = pg_query($sql);
$natureza = '_';
if (pg_num_rows($cad)) {
    $natureza = pg_fetch_result($cad, 0, "cfonome");
}

header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
$xml .= "<dados>";
$xml .= "<registro>";
$xml .= "<item>" . $natureza . "</item>";
$xml .= "</registro>";
$xml .= "</dados>";

echo $xml;
pg_close($conn);
exit();
?>