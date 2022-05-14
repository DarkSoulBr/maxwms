<?php

require('./_app/Config.inc.php');

$pcnumero = trim($_GET["pcnumero"]);

$sql = "SELECT c.procod as codigo,c.prnome as descricao, a.pcibaixa as baixa, a.pcipreco as preco
                FROM pcitem a,produto c
                WHERE a.pcnumero = $pcnumero
                AND a.procodigo = c.procodigo
                AND (a.pcibaixa > '0' and not a.pcibaixa isnull)
                ORDER BY a.pcicodigo";


$read = new Read;
$read->FullRead($sql);

header("Content-type: application/xml");
		
$xml="<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
$xml .= "<dados>";
if ($read->getRowCount() >= 1) {


    $xml .= "<cabecalhof>";
    foreach (array_keys($read->getResult()[0]) as $cabecalho) {
        $xml .= "<campo>" . $cabecalho . "</campo>";
    }
    $xml .= "</cabecalhof>";

    foreach ($read->getResult() as $registros) {
        extract($registros);
        $xml .= "<registrof>";
        $xml .= "<itemf>" . $codigo . "</itemf>";
        $xml .= "<itemf>" . $descricao . "</itemf>";
        $xml .= "<itemf>" . $baixa . "</itemf>";
        $xml .= "<itemf>" . number_format($preco, 2, ',', '.') . "</itemf>";

        $xml .= "</registrof>";
    }
}
$xml .= "</dados>";
$read = null;
echo $xml;
