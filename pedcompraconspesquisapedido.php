<?php

require('./_app/Config.inc.php');

$pcnumero = trim($_GET["pcnumero"]);

$sql = "SELECT c.procod as codigo,c.prnome as descricao,(a.pcisaldo) as estoque,a.pcipreco as preco
                FROM pcitem a,produto c
                Where a.pcnumero = $pcnumero
                and a.procodigo = c.procodigo
                order by a.pcicodigo";


$read = new Read;
$read->FullRead($sql);

if ($read->getRowCount() >= 1) {

    header("Content-type: application/xml");
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

    $xml .= "<dados>";
    $xml .= "<cabecalho>";
    foreach (array_keys($read->getResult()[0]) as $cabecalho) {
        $xml .= "<campo>" . $cabecalho . "</campo>";
    }
    $xml .= "</cabecalho>";

    foreach ($read->getResult() as $registros) {
        extract($registros);

        $xml .= "<registro>";
        $xml .= "<item>" . $codigo . "</item>";
        $xml .= "<item>" . $descricao . "</item>";
        $xml .= "<item>" . $estoque . "</item>";
        $xml .= "<item>" . number_format($preco, 2, ',', '.') . "</item>";

        $xml .= "</registro>";
    }

    $xml .= "</dados>";
}
$read = null;
echo $xml;
