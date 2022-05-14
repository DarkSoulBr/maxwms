<?php

require('./_app/Config.inc.php');

$fornecedor = $_GET['forn'];
$opcao = $_GET['opcao'];
$datainicio = explode("/", $_GET['datainicio']);
$datafim = explode("/", $_GET['datafim']);

$auxdatainicio = $datainicio[2] . '-' . $datainicio[1] . '-' . $datainicio[0] . ' 00:00:00';
$auxdatafim = $datafim[2] . '-' . $datafim[1] . '-' . $datafim[0] . ' 23:59:59';

$where = "";
if ($opcao == 1 || $opcao == 2 || $opcao == 3)
    $where = "and fornecedor.forcodigo=" . $fornecedor;
else
    $where = "and fornecedor.fornguerra like '%'";

$sql = "SELECT distinct notaent.pcnumero as pedido, notaent.notentseqbaixa as seq, pcompra.pcemissao as emissao, notaent.notentdata as baixa, fornecedor.forcod as forncod,fornecedor.fornguerra as fornguerra,fornecedor.forrazao as fornrazao,notaent.notentnumero as numnota
FROM notaent
left join pcompra on notaent.pcnumero = pcompra.pcnumero
left join fornecedor on pcompra.forcodigo = fornecedor.forcodigo
WHERE (notaent.notentdata between '$auxdatainicio' and '$auxdatafim') $where
order by notaent.pcnumero asc";

$read = new Read;
$read->FullRead($sql);

header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
$xml .= "<dadosforn>";

if ($read->getRowCount() >= 1) {

    foreach ($read->getResult() as $registros) {

        extract($registros);

        $xml .= "<registroforn>";


        $fornecedor = "";

        if ($opcao == 1)
            $fornecedor = $forncod;
        else if ($opcao == 2)
            $fornecedor = $fornguerra;
        else if ($opcao == 3)
            $fornecedor = $fornrazao;
        else
            $fornecedor = $fornguerra;

        //Mascara data
        $aux = explode(" ", $emissao);
        $aux1 = explode("-", $aux[0]);
        $emissao = $aux1[2] . '/' . $aux1[1] . '/' . $aux1[0];

        $auxb = explode(" ", $baixa);
        $aux1b = explode("-", $auxb[0]);
        $baixa = $aux1b[2] . '/' . $aux1b[1] . '/' . $aux1b[0];

        $xml .= "<itemforn>" . $pedido . "</itemforn>";
        $xml .= "<itemforn>" . $seq . "</itemforn>";
        $xml .= "<itemforn>" . $emissao . "</itemforn>";
        $xml .= "<itemforn>" . $baixa . "</itemforn>";
        $xml .= "<itemforn>" . $numnota . "</itemforn>";
        $xml .= "<itemforn>" . $fornecedor . "</itemforn>";

        $xml .= "</registroforn>";
    }    
}
$xml .= "</dadosforn>";
$read = null;
echo $xml;
