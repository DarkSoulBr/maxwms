<?php

require('./_app/Config.inc.php');

$pcnumero = trim($_GET["pcnumero"]);

$sql = "SELECT b.notentseqbaixa as baixa, to_char(b.notentdata, 'DD/MM/YYYY') as data, c.procod as codigo,c.prnome as descricao, a.neisaldo as quantidade, a.neipreco as valor
		FROM neitem a,produto c, notaent b
		WHERE b.pcnumero =  $pcnumero
		AND a.procodigo = c.procodigo
		AND a.notentcodigo = b.notentcodigo
		ORDER BY a.neiitem";


$read = new Read;
$read->FullRead($sql);

header("Content-type: application/xml");		
$xml="<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
$xml .= "<dados>";
if ($read->getRowCount() >= 1) {


    $xml .= "<cabecalhob>";
    foreach (array_keys($read->getResult()[0]) as $cabecalho) {
        $xml .= "<campo>" . $cabecalho . "</campo>";
    }
    $xml .= "</cabecalhob>";

    foreach ($read->getResult() as $registros) {
        extract($registros);
        $xml .= "<registrob>";
        $xml .= "<itemb>" . $baixa . "</itemb>";
        $xml .= "<itemb>" . $data . "</itemb>";
        $xml .= "<itemb>" . $codigo . "</itemb>";
        $xml .= "<itemb>" . $descricao . "</itemb>";
        $xml .= "<itemb>" . $quantidade . "</itemb>";
        $xml .= "<itemb>" . number_format($valor, 2, ',', '.') . "</itemb>";
        $xml .= "</registrob>";
    }
}
$xml .= "</dados>";
$read = null;
echo $xml;
