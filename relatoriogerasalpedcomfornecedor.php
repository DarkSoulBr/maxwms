<?php

require('fpdfnew.php');
require_once("include/conexao.inc.php");

class PDF extends FPDF {

    //Page header
    function Header() {
        //Logo
        //$this->Image('logo_pb.png',10,8,33);
        $this->Image('barao.jpg', 10, 8, 50);
        //Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        //Move to the right
        $this->Cell(80);
        //Title
        $this->Cell(30, 10, 'Saldo de Compras por Fornecedor', 0, 1, 'C');
        $this->Cell(30, 5, '', 0, 1, 'C');

        $this->SetFont('Times', 'B', 8);
        $this->Cell(10, 5, 'Pedido', 1, 0);
        $this->Cell(15, 5, 'Emiss�o', 1, 0);
        $this->Cell(12, 5, 'C�digo', 1, 0);
        $this->Cell(75, 5, 'Produto', 1, 0);
        $this->Cell(12, 5, 'Saldo', 1, 0);
        $this->Cell(12, 5, 'Unit�rio', 1, 0);
        $this->Cell(17, 5, 'Total', 1, 0);
        $this->Cell(32, 5, 'Fornecedor', 1, 1);

        //Line break
        $this->Ln(0);
        //$this->Ln(20);
    }

    //Page footer
    function Footer() {
        //Position at 1.5 cm from bottom
        $this->SetY(-15);
        //Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        //Page number
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

}

//Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 4);

$fornecedor = $_GET['forn'];
$opcao = $_GET['opcao'];
$datainicio = explode("/", $_GET['datainicio']);
$datafim = explode("/", $_GET['datafim']);

$auxdatainicio = $datainicio[2] . '-' . $datainicio[1] . '-' . $datainicio[0] . ' 00:00:00';
$auxdatafim = $datafim[2] . '-' . $datafim[1] . '-' . $datafim[0] . ' 23:59:59';

$where = "";
if ($opcao == 1)
    $where = "and fornecedor.forcodigo=" . $fornecedor;
else if ($opcao == 2)
    $where = "and fornecedor.forcodigo=" . $fornecedor;
else if ($opcao == 3)
    $where = "and fornecedor.forcodigo=" . $fornecedor;
else
    $where = "and fornecedor.forrazao like '%'";

$sql = "Select distinct pcompra.pcnumero as pedido, pcompra.pcemissao as emissao, produto.procod as codigo,produto.prnome as produto,pcitem.pcisaldo as saldo, pcitem.pcibaixa as baixa, pcitem.pcipreco as unitario
,pcitem.desc1
,pcitem.desc2
,pcitem.desc3
,pcitem.desc4
,pcitem.ipi
,fornecedor.forcod as forcod,fornecedor.fornguerra as fornguerra,fornecedor.forrazao as forrazao
FROM pcompra
left join fornecedor on pcompra.forcodigo = fornecedor.forcodigo
left join pcitem on pcompra.pcnumero=pcitem.pcnumero
left join produto on pcitem.procodigo=produto.procodigo
where (pcompra.pcemissao between '$auxdatainicio' and '$auxdatafim') $where
order by pcompra.pcnumero asc";

$cad = pg_query($sql);

$row = pg_num_rows($cad);

$pdf->SetFont('Times', 'B', 7);

for ($i = 0; $i < $row; $i++) {
    $pedido = pg_fetch_result($cad, $i, "pedido");
    $emissao = pg_fetch_result($cad, $i, "emissao");
    $codigo = pg_fetch_result($cad, $i, "codigo");
    $produto = pg_fetch_result($cad, $i, "produto");
    $saldo = pg_fetch_result($cad, $i, "saldo");
    $baixa = pg_fetch_result($cad, $i, "baixa");
    $unitario = pg_fetch_result($cad, $i, "unitario");

    $pcipreco = pg_fetch_result($cad, $i, "unitario");
    $desc1 = pg_fetch_result($cad, $i, "desc1");
    $desc2 = pg_fetch_result($cad, $i, "desc2");
    $desc3 = pg_fetch_result($cad, $i, "desc3");
    $desc4 = pg_fetch_result($cad, $i, "desc4");
    $ipi = pg_fetch_result($cad, $i, "ipi");

    $pciprecox = $pcipreco * 100;
    $l = strlen($pciprecox) - 2;
    $pciprecox = substr($pciprecox, 0, $l) . "." . substr($pciprecox, $l, 2);

    $desc1x = $desc1 * 100;
    $l = strlen($desc1x) - 2;
    $desc1x = substr($desc1x, 0, $l) . "." . substr($desc1x, $l, 2);
    $desc2x = $desc2 * 100;
    $l = strlen($desc2x) - 2;
    $desc2x = substr($desc2x, 0, $l) . "." . substr($desc2x, $l, 2);
    $desc3x = $desc3 * 100;
    $l = strlen($desc3x) - 2;
    $desc3x = substr($desc3x, 0, $l) . "." . substr($desc3x, $l, 2);
    $desc4x = $desc4 * 100;
    $l = strlen($desc4x) - 2;
    $desc4x = substr($desc4x, 0, $l) . "." . substr($desc4x, $l, 2);

    if ($desc1x == '.0') {
        $desc1x = '0.00';
    }
    if ($desc2x == '.0') {
        $desc2x = '0.00';
    }
    if ($desc3x == '.0') {
        $desc3x = '0.00';
    }
    if ($desc4x == '.0') {
        $desc4x = '0.00';
    }

    $liq = $pcipreco;
    if ($desc1 != 0) {
        $d1 = $liq / 100 * $desc1;
    } else {
        $d1 = 0;
    }
    $liq = $liq - $d1;
    if ($desc2 != 0) {
        $d2 = $liq / 100 * $desc2;
    } else {
        $d2 = 0;
    }
    $liq = $liq - $d2;
    if ($desc3 != 0) {
        $d3 = $liq / 100 * $desc3;
    } else {
        $d3 = 0;
    }
    $liq = $liq - $d3;
    if ($desc4 != 0) {
        $d4 = $liq / 100 * $desc4;
    } else {
        $d4 = 0;
    }
    $liq = $liq - $d4;

    $liqaux = $liq;

    $liqx = $liq * 100;
    $l = strlen($liqx) - 2;
    $liqx = substr($liqx, 0, $l) . "." . substr($liqx, $l, 2);

    if ($ipi != 0) {
        $vipi = $liqaux / 100 * $ipi;
    } else {
        $vipi = 0;
    }
    $valaux = $liqaux + $vipi;
    $val = round($liqaux + $vipi, 2);

    $valx = $val * 100;
    $l = strlen($valx) - 2;
    $valx = substr($valx, 0, $l) . "." . substr($valx, $l, 2);

    $saldo = $saldo - $baixa;
    $total = $saldo * $valaux;

    if ($saldo > 0) {

        $fornecedor = "";

        if ($opcao == 1)
            $fornecedor = pg_fetch_result($cad, $i, "forcod");
        else if ($opcao == 2)
            $fornecedor = pg_fetch_result($cad, $i, "fornguerra");
        else if ($opcao == 3)
            $fornecedor = pg_fetch_result($cad, $i, "forrazao");
        else
            $fornecedor = pg_fetch_result($cad, $i, "fornguerra");

        //Mascara data
        $aux = explode(" ", $emissao);
        $aux1 = explode("-", $aux[0]);
        $emissao = $aux1[2] . '/' . $aux1[1] . '/' . $aux1[0];

        $saldo = number_format($saldo, 2, ",", ".");
        $unitario = number_format($unitario, 2, ",", ".");
        $total = number_format($total, 2, ",", ".");

        $pdf->Cell(10, 5, '' . $pedido, 1, 0);
        $pdf->Cell(15, 5, '' . $emissao, 1, 0);
        $pdf->Cell(12, 5, '' . $codigo, 1, 0);
        $pdf->Cell(75, 5, '' . $produto, 1, 0);
        $pdf->Cell(12, 5, '' . $saldo, 1, 0, 'R');
        $pdf->Cell(12, 5, '' . $valx, 1, 0, 'R');
        $pdf->Cell(17, 5, '' . $total, 1, 0, 'R');
        $pdf->Cell(32, 5, '' . $fornecedor, 1, 1);
        //$pdf->Cell(23,5,'',0,0);
        //Corre��o para n�o gerar uma p�gina em branco no final
        //if($i<$row-1)
        //{
        //Quebra de p�gina
        //	$pdf->AddPage();
        //}
    }
}



$pdf->Output();
?>
