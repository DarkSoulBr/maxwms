<?php

require('./_app/Config.inc.php');

$datainicio = explode("/", $_GET['dtinicio']);
$datafim = explode("/", $_GET['dtfinal']);

$auxdatainicio = $datainicio[2] . '-' . $datainicio[1] . '-' . $datainicio[0] . ' 00:00:00';
$auxdatafim = $datafim[2] . '-' . $datafim[1] . '-' . $datafim[0] . ' 23:59:59';

$sql = "SELECT b.pcnumero,lpad(cast(extract(day from b.pcemissao) as varchar),2,'0')||'/'|| lpad(cast(extract(month from b.pcemissao) as varchar),2,'0')||'/'|| EXTRACT(YEAR FROM b.pcemissao) as emissao,
                c.forcod,c.fornguerra as forrazao,b.comprador,b.localentrega,b.total,b.pcempresa  
                FROM pcompra b,fornecedor c
                WHERE b.forcodigo = c.forcodigo
                AND (b.pcemissao between '$auxdatainicio' and '$auxdatafim') 
                ORDER BY b.pcemissao,b.pcnumero";


$read = new Read;
$read->FullRead($sql);

header("Content-type: application/xml");

$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
$xml .= "<dados>";

if ($read->getRowCount() >= 1) {


    $xml .= "<cabecalho>";

    $xml .= "<campo>pcnumero</campo>
                <campo>emissao</campo>
                <campo>forcod</campo>
                <campo>forrazao</campo>
                <campo>comprador</campo>
                <campo>localentrega</campo>
                <campo>total</campo>";

    $xml .= "</cabecalho>";

    foreach ($read->getResult() as $registros) {
        extract($registros);

        $xml .= "<registro>";

        if ($comprador == '') {
            $comprador = '_';
        }

        if((int) $pcempresa == 2) {
            $entrega = 'FUN';
        } else {
        
            if ($localentrega == 1) {
                $entrega = 'FILIAL';
            } else if ($localentrega == 2) {
                $entrega = 'MATRIZ';
            } else if ($localentrega == 3) {
                $entrega = 'CD-RE';
            } else if ($localentrega == 4) {
                $entrega = 'CD-VIX';
            } else {
                $entrega = 'CD-SP';
            }
            
        }

        $xml .= "<item>" . $pcnumero . "</item>";
        $xml .= "<item>" . $emissao . "</item>";
        $xml .= "<item>" . $forcod . "</item>";
        $xml .= "<item>" . $forrazao . "</item>";
        $xml .= "<item>" . $comprador . "</item>";
        $xml .= "<item>" . $entrega . "</item>";
        $xml .= "<item>" . number_format($total, 2, ',', '.') . "</item>";

        $xml .= "</registro>";
    }
}
$xml .= "</dados>";
$read = null;
echo $xml;
