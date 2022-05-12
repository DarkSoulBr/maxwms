<?php

require_once("include/conexao.inc.php");

$parametro = $_GET['parametro'];

$sql = "Select a.ctechave, a.ctenProt, a.cterecebto, a.ctemotivo";
$sql .= " from cte a ";
$sql .= " Where a.ctenumero = '$parametro'";

$sql = pg_query($sql);
$row = pg_num_rows($sql);

$ctechave = "";
$ctenProt = "";
$cterecebto = "";
$ctemotivo = "";

if ($row) {

    $ctechave = trim(pg_fetch_result($sql, 0, "ctechave"));
    $ctenProt = trim(pg_fetch_result($sql, 0, "ctenProt"));
    $cterecebto = trim(pg_fetch_result($sql, 0, "cterecebto"));
    $ctemotivo = trim(pg_fetch_result($sql, 0, "ctemotivo"));
}


if ($ctechave == '') {
    $ctechave = '_';
}
if ($ctenProt == '') {
    $ctenProt = '_';
}
if ($cterecebto == '') {
    $cterecebto = '_';
} else {
    $cterecebto = substr($cterecebto, 8, 2) . "/" . substr($cterecebto, 5, 2) . "/" . substr($cterecebto, 0, 4);
}
if ($ctemotivo == '') {
    $ctemotivo = '_';
}

header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
$xml .= "<dados>";
$xml .= "<registro>";
$xml .= "<item>" . $ctechave . "</item>";
$xml .= "<item>" . $ctenProt . "</item>";
$xml .= "<item>" . $cterecebto . "</item>";
$xml .= "<item>" . strtoupper($ctemotivo) . "</item>";
$xml .= "</registro>";
$xml .= "</dados>";

echo $xml;
pg_close($conn);
exit();


