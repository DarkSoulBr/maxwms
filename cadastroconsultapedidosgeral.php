<?php

require_once("include/conexao.inc.php");

$opcao = $_GET['opcao'];
$nome = $_GET['nome'];

if ($opcao == '1') {
    $strorder = "numpedcli";
    $where = "where numpedcli = '" . $nome . "'";
} else
if ($opcao == '2') {
    $strorder = "nomedest";
    $where = "where nomedest like '%" . $nome . "%'";
}

$sql = "Select pedcodigo,numpedcli,nomedest FROM pedidos {$where} order by {$strorder} asc";

$cad = pg_query($sql);

if (pg_num_rows($cad)) {
    $row = pg_num_rows($cad);

    header("Content-type: application/xml");
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
    $xml .= "<dados>";
    for ($i = 0; $i < $row; $i++) {
        $xml .= "<registro>";

        $codigo = pg_result($cad, $i, "pedcodigo");
        $cod = pg_result($cad, $i, "numpedcli");
        $nome = pg_result($cad, $i, "nomedest");

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
