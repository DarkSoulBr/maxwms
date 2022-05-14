<?php

require('./_app/Config.inc.php');

$opcao = $_GET['opcao'];
$consultafornecedor = $_GET['consultafornecedor'];

if ($opcao == '1')
    $where = "forcod=" . $consultafornecedor . " order by forcod";
else if ($opcao == '2')
    $where = "fornguerra like '%" . $consultafornecedor . "%' order by fornguerra";
else if ($opcao == '3')
    $where = "forrazao like '%" . $consultafornecedor . "%' order by forrazao";

$sql = "SELECT forcodigo,forcod,forrazao,fornguerra FROM fornecedor WHERE $where ASC";
$read = new Read;
$read->FullRead($sql);

header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
$xml .= "<dados>";

if ($read->getRowCount() >= 1) {
    

    foreach ($read->getResult() as $registros) {

        extract($registros);

        $xml .= "<registro>";

        $codigo = $forcod;
        if ($opcao == '1' || $opcao == '2') {
            $nomeguerra = $fornguerra;
        } else {
            $nomeguerra = $forrazao;
        }

        $xml .= "<item>" . $forcodigo . "</item>";
        $xml .= "<item>" . $codigo . "</item>";
        $xml .= "<item>" . $nomeguerra . "</item>";

        $xml .= "</registro>";
    }
    
}
$xml .= "</dados>";
$read = null;
echo $xml;

