<?php

require_once("include/conexao.inc.php");

$sql = "Select etqcodigo,etqnome FROM estoque order by etqnome asc";
$cad = pg_query($sql);

header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

if (pg_num_rows($cad)) {
    $row = pg_num_rows($cad);

    $xml .= "<dados>";
    for ($i = 0; $i < $row; $i++) {
        $xml .= "<registro>";

        $codigo = pg_fetch_result($cad, $i, "etqcodigo");
        $descricao = pg_fetch_result($cad, $i, "etqnome");

        $xml .= "<item>" . $codigo . "</item>";
        $xml .= "<item>" . $descricao . "</item>";

        $xml .= "</registro>";
    }
    $xml .= "</dados>";
}
echo $xml;
pg_close($conn);
exit();
?>
