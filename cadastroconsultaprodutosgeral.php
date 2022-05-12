<?php

require_once("include/conexao.inc.php");

$opcao = $_GET['opcao'];
$nome = $_GET['nome'];

if ($opcao == '1') {
    $strorder = "codprod";
    $where = "where codprod like '" . $nome . "%'";
} else
if ($opcao == '2') {
    $strorder = "nomeprod";
    $where = "where nomeprod like '%" . $nome . "%'";
}

$sql = "Select procodigo,codprod,nomeprod FROM produtos {$where} order by {$strorder} asc";
//print($sql); die;

$cad = pg_query($sql);

if (pg_num_rows($cad)) {
    $row = pg_num_rows($cad);

    header("Content-type: application/xml");
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
    $xml .= "<dados>";
    for ($i = 0; $i < $row; $i++) {
        $xml .= "<registro>";

        $codigo = pg_result($cad, $i, "procodigo");
        $cod = pg_result($cad, $i, "codprod");
        $nome = pg_result($cad, $i, "nomeprod");

        $xml .= "<item>" . $codigo . "</item>";
        $xml .= "<item>" . $cod . "</item>";
        $xml .= "<item>" . $nome . "</item>";

        $xml .= "</registro>";
    }
    $xml .= "</dados>";
}
echo $xml;
pg_close($conn);
exit();
