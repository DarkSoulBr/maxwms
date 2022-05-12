<?php

require_once("include/conexao.inc.php");

$opcao = $_GET['opcao'];
$consultatipopedido = $_GET['consultatipopedido'];

if ($opcao == '1') {
    $where = "tipsigla like '" . $consultatipopedido . "%'";
    $order = "tipsigla";
} else if ($opcao == '2') {
    $where = "tipdescricao like '" . $consultatipopedido . "%'";
    $order = "tipdescricao";
}

$sql = "Select tipcodigo,tipsigla,tipdescricao FROM tipoped where $where order by $order asc";

$cad = pg_query($sql);

if (pg_num_rows($cad)) {

    $row = pg_num_rows($cad);

    header("Content-type: application/xml");
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
    $xml .= "<dados>";
    for ($i = 0; $i < $row; $i++) {

        $xml .= "<registro>";

        $codigo = pg_fetch_result($cad, $i, "tipcodigo");
        $xml .= "<item>" . $codigo . "</item>";

        $tipsigla = pg_fetch_result($cad, $i, "tipsigla");
        $tipdescricao = pg_fetch_result($cad, $i, "tipdescricao");
        $xml .= "<item>" . $tipsigla . " " . $tipdescricao . "</item>";


        $xml .= "</registro>";
    }
    $xml .= "</dados>";
}
echo $xml;
pg_close($conn);
exit();
?>
