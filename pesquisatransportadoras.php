<?php

require('./_app/Config.inc.php');

$opcao = $_GET['opcao'];
$consultatransportadora = $_GET['consultatransportadora'];

if ($opcao == '1')
    $where = "tracodigo=" . $consultatransportadora . " order by tracodigo";
else if ($opcao == '2')
    $where = "tranguerra like '%" . $consultatransportadora . "%' order by tranguerra";
else if ($opcao == '3')
    $where = "trarazao like '%" . $consultatransportadora . "%' order by trarazao";

$sql = "Select tracodigo,trarazao,tranguerra FROM transportador where $where asc";


$read = new Read;
$read->FullRead($sql);

$xml = null;
if ($read->getRowCount() >= 1) {

    header("Content-type: application/xml");
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
    $xml .= "<dados>";
    foreach ($read->getResult() as $total) {

        extract($total);

        $xml .= "<registro>";
        $xml .= "<item>" . $tracodigo . "</item>";
        $xml .= "<item>" . $tranguerra . "</item>";
        $xml .= "</registro>";
    }
    $xml .= "</dados>";
}
$read = null;
echo $xml;
