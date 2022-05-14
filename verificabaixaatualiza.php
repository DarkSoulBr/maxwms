<?php

require_once("include/conexao.inc.php");
require("verifica2.php");

$nota = $_GET["pcnumero"];
$pcseq = $_GET["pcseq"];



$sql = "SELECT notatualiza FROM notaent Where pcnumero = $nota and notentseqbaixa = $pcseq ";
$sql = pg_query($sql);
$row = pg_num_rows($sql);

$notatualiza = 0;

if ($row) {
    $notatualiza = pg_fetch_result($sql, 0, "notatualiza");
}

if ($notatualiza == '') {
    $notatualiza = 0;
}


header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
$xml .= "<dados>";

$xml .= "<registro>";
$xml .= "<item>" . $notatualiza . "</item>";
$xml .= "</registro>";

$xml .= "</dados>";

echo $xml;
pg_close($conn);
exit();
?>