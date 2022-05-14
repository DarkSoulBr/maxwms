<?php

require('./_app/Config.inc.php');

$pcnumero = trim($_GET["pcnumero"]);

$sql = "SELECT c.procod as codigo,c.prnome as descricao, a.pcisaldo as saldo, a.pcibaixa as baixa, a.pcipreco as preco
                FROM pcitem a,produto c
                WHERE a.pcnumero = $pcnumero
                and a.procodigo = c.procodigo
                and (a.pcisaldo > a.pcibaixa or a.pcibaixa isnull)
                ORDER BY a.pcicodigo";


$read = new Read;
$read->FullRead($sql);

header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
$xml .= "<dados>";
if ($read->getRowCount() >= 1) {


    $xml .= "<cabecalhoa>";
    foreach (array_keys($read->getResult()[0]) as $cabecalho) {
        $xml .= "<campo>" . $cabecalho . "</campo>";
    }
    $xml .= "</cabecalhoa>";

    foreach ($read->getResult() as $registros) {
        extract($registros);

        $auxqtde = $saldo - $baixa;

        $xml .= "<registroa>";
        $xml .= "<itema>" . $codigo . "</itema>";
        $xml .= "<itema>" . $descricao . "</itema>";
        $xml .= "<itema>" . $auxqtde . "</itema>";
        $xml .= "<itema>" . number_format($preco, 2, ',', '.') . "</itema>";

        $xml .= "</registroa>";
    }
}
$xml .= "</dados>";
$read = null;
echo $xml;
