<?php
require('./_app/Config.inc.php');

$datainicio = explode("/", $_GET['dtinicio']);
$datafim = explode("/", $_GET['dtfinal']);

$auxdatainicio = $datainicio[2] . '-' . $datainicio[1] . '-' . $datainicio[0] . ' 00:00:00';
$auxdatafim = $datafim[2] . '-' . $datafim[1] . '-' . $datafim[0] . ' 23:59:59';

$sql = "SELECT a.pcnumero
                ,a.notentseqbaixa,
                lpad(cast(extract(day from b.pcemissao) as varchar),2,'0')||'/'||
                lpad(cast(extract(month from b.pcemissao) as varchar),2,'0')||'/'||
                EXTRACT(YEAR FROM b.pcemissao) as emissao,
                lpad(cast(extract(day from a.notentdata) as varchar),2,'0')||'/'||
                lpad(cast(extract(month from a.notentdata) as varchar),2,'0')||'/'||
                EXTRACT(YEAR FROM a.notentdata) as baixa,
                c.forcod
                ,c.fornguerra as forrazao 
                ,b.comprador
                ,a.notentvolumes              
		,a.notentnumero
                ,lpad(cast(extract(day from a.notentemissao) as varchar),2,'0')||'/'||
                lpad(cast(extract(month from a.notentemissao) as varchar),2,'0')||'/'||
                EXTRACT(YEAR FROM a.notentemissao) as notentemissao		
                ,a.notatualiza 
                FROM notaent a,pcompra b,fornecedor c 
                WHERE a.pcnumero = b.pcnumero 
                AND b.forcodigo = c.forcodigo
                AND (a.notentdata between '$auxdatainicio' and '$auxdatafim')                 
                ORDER BY b.pcemissao,a.pcnumero,a.notentseqbaixa";


$read = new Read;
$read->FullRead($sql);

header("Content-type: application/xml");

$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
$xml .= "<dados>";

if ($read->getRowCount() >= 1) {
    
    $xml .= "<cabecalho>";

    $xml .= "<campo>pcnumero</campo>
                <campo>seq</campo>
                <campo>emissao</campo>
                <campo>baixa</campo>
                <campo>forcod</campo>
                <campo>forrazao</campo>
                <campo>comprador</campo>
                <campo>volumes</campo>
                <campo>nota</campo>
                <campo>emissao</campo>                
                <campo>estoque</campo>";

    $xml .= "</cabecalho>";
    foreach ($read->getResult() as $registros) {
        extract($registros);

        $xml .= "<registro>";

        if ($comprador == '') {
            $comprador = '_';
        }
        
        if ($notatualiza == 1) {
            $notatualiza = 'S';
        }
        else {
            $notatualiza = 'N';
        }


        $xml .= "<item>" . $pcnumero . "</item>";
        $xml .= "<item>" . $notentseqbaixa . "</item>";
        $xml .= "<item>" . $emissao . "</item>";
        $xml .= "<item>" . $baixa . "</item>";
        $xml .= "<item>" . $forcod . "</item>";
        $xml .= "<item>" . $forrazao . "</item>";
        $xml .= "<item>" . $comprador . "</item>";
        $xml .= "<item>" . $notentvolumes . "</item>";
        $xml .= "<item>" . $notentnumero . "</item>";
        $xml .= "<item>" . $notentemissao . "</item>";
        $xml .= "<item>" . $notatualiza . "</item>";
        $xml .= "</registro>";
    }
}
$xml .= "</dados>";
$read = null;
echo $xml;