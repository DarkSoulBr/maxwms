<?php

require_once("include/conexao.inc.php");
require_once("include/clientes.php");

$parametro = trim($_POST["parametro"]);
$cadastro = new banco($conn, $db);

$sql = "SELECT max(a.clicod) as codigo FROM  clientes a";

$sql = pg_query($sql);
$row = pg_num_rows($sql);

if ($row) {

    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    for ($i = 0; $i < $row; $i++) {

        $codigo = (pg_fetch_result($sql, $i, "codigo") + 1);
        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "</dado>\n";
    }

    $xml .= "</dados>\n";


    Header("Content-type: application/xml; charset=iso-8859-1");
}
echo $xml;

