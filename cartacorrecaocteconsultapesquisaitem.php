<?php

require_once("include/conexao.inc.php");

$ctenumero = trim($_GET["ctenumero"]);

$pegar = "SELECT * FROM ctecartacorrecaoitem WHERE ccccodigo = '{$ctenumero}'";

$cad = pg_query($pegar);
$row = pg_num_rows($cad);

$xml = '';
if ($row) {

    header("Content-type: application/xml");

    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

    $xml .= "<dados>";

    for ($i = 0; $i < $row; $i++) {
     
        $ccigrupo = pg_fetch_result($cad, $i, "ccigrupo");
        $ccicampo = pg_fetch_result($cad, $i, "ccicampo");
        $cciitem = pg_fetch_result($cad, $i, "cciitem");
        $cciobs = pg_fetch_result($cad, $i, "cciobs");       


        $xml .= "<registro>";
        $xml .= "<item>" . $ccigrupo . "</item>";       
        $xml .= "<item>" . $ccicampo . "</item>";
        $xml .= "<item>" . $cciitem . "</item>";
        $xml .= "<item>" . $cciobs . "</item>";

        $xml .= "</registro>";
    }

    $xml .= "</dados>";
}

echo $xml;
pg_close($conn);
