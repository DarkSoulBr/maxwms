<?php

require('fpdfnew.php');
require_once("include/conexao.inc.php");
require_once("include/consultamovimentacao3.php");

$codigoproduto = trim($_GET["codigoproduto"]);
$produto = trim($_GET["produto"]);

$dtinicio = trim($_GET["dtinicio"]);
$dtfinal = trim($_GET["dtfinal"]);

$deposito = trim($_GET["deposito"]);
$deposito2 = trim($_GET["deposito2"]);

$dtinicioz = $dtinicio;

$dtinicio = substr($dtinicio, 6, 4) . substr($dtinicio, 3, 2) . substr($dtinicio, 0, 2);
$dtfinal = substr($dtfinal, 6, 4) . substr($dtfinal, 3, 2) . substr($dtfinal, 0, 2);

$dtinicioy = $dtinicio;

class PDF extends FPDF {

    //Page header
    function Header() {

        $dtiniciox = trim($_GET["dtinicio"]);
        $dtfinalx = trim($_GET["dtfinal"]);

        $codigoprodutox = trim($_GET["codigoproduto"]);
        $produtox = trim($_GET["produto"]);

        $deposito = trim($_GET["deposito"]);
        $deposito2 = trim($_GET["deposito2"]);

        $this->SetFont('Arial', 'B', 9);
        $this->Cell(71, 5, 'CENTRO ATACADISTA BARÃO', 0, 0);

        //Arial bold 15
        $this->SetFont('Arial', 'B', 10);

        $dia = date('d');
        $mes = date('m');
        $ano = date('Y');
        $hor = date('H');
        $min = date('i');

        $this->Cell(50, 5, 'Movimentação de Estoque', 0, 0, 'C');
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(70, 5, $dia . '/' . $mes . '/' . $ano . ' ' . $hor . ':' . $min, 0, 1, 'R');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(191, 5, 'De: ' . $dtiniciox . ' Até: ' . $dtfinalx . ' - ' . $deposito2, 0, 1, 'C');
        $this->Cell(191, 5, 'Prduto: ' . $codigoprodutox . '  ' . $produtox, 0, 1, 'C');

        $this->Cell(30, 5, '', 0, 1, 'C');

        //Line break
        $this->Ln(0);
        //$this->Ln(20);
    }

    //Page footer
    function Footer() {
        //Position at 1.5 cm from bottom
        $this->SetY(-10);
        //Arial italic 8

        $this->SetFont('Arial', 'I', 8);

        //Page number
        $this->Cell(0, 10, 'Pagina ' . $this->_X(), 0, 0, 'C');
    }

}

$pdf = new PDF();

$pdf->AliasNbPages();
$pdf->_Yped(0);
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);
$pdf->_Y();
$pdf->_Yped(1);

$cadastro = new banco($conn, $db);
$data = $cadastro->selecionanovo($codigoproduto, $dtinicio, $dtfinal, $deposito);

//se encontrar registros
if (pg_num_rows($data)) {

    //preenchimento da Array com o nome dos campos
    for ($i = 0; $i < pg_num_fields($data); $i++) {
        $campos[$i] = pg_field_name($data, $i);
        //   $pdf->Cell(15,4,''.$campos[$i],0,1,'R');
    }

    $pdf->Cell(30, 4, '', 0, 0, 'C');
    $pdf->Cell(30, 4, '           Data', 0, 0, 'C');
    $pdf->Cell(30, 4, 'Entrada', 0, 0, 'R');
    $pdf->Cell(30, 4, 'Saida', 0, 0, 'R');
    $pdf->Cell(30, 4, 'Saldo', 0, 1, 'R');

    $pdf->SetFont('Arial', 'B', 9);

    $primeiro = 0;
    $saldo = 0;

    $dtdata2 = '';
    $dtdata2x = '';

    $saldodiae = 0;
    $saldodias = 0;
    //corpo da tabela

    while ($row = pg_fetch_object($data)) {

        $dtdata = substr($row->{$campos[1]}, 6, 4) . substr($row->{$campos[1]}, 3, 2) . substr($row->{$campos[1]}, 0, 2);


        if ($dtdata >= $dtinicioy) {

            if ($primeiro == 0) {
                $pdf->Cell(30, 4, 'Saldo Inicial', 0, 0, 'R');
                $pdf->Cell(30, 4, '' . $dtinicioz, 0, 0, 'R');
                $pdf->Cell(30, 4, '', 0, 0, 'R');
                $pdf->Cell(30, 4, '', 0, 0, 'R');
                $pdf->Cell(30, 4, '' . $saldo, 0, 1, 'R');
            }


            if (($dtdata != $dtdata2) and ( $primeiro == 1)) {

                $pdf->Cell(30, 4, '', 0, 0, 'R');
                $pdf->Cell(30, 4, '' . $dtdata2x, 0, 0, 'R');
                $pdf->Cell(30, 4, '' . $saldodiae, 0, 0, 'R');
                $pdf->Cell(30, 4, '' . $saldodias, 0, 0, 'R');
                $pdf->Cell(30, 4, '' . $saldo, 0, 1, 'R');

                $saldodiae = 0;
                $saldodias = 0;
            }

            if ($row->{$campos[4]} == 1) {

                $val = $row->{$campos[2]};
                $saldo = $val;
                $saldodiae = $val;

                $pdf->Cell(30, 4, 'Inventário', 0, 0, 'R');
                $pdf->Cell(30, 4, '' . $row->{$campos[1]}, 0, 0, 'R');
                $pdf->Cell(30, 4, '' . $saldodiae, 0, 0, 'R');
                $pdf->Cell(30, 4, '0', 0, 0, 'R');
                $pdf->Cell(30, 4, '' . $saldo, 0, 1, 'R');

                $saldodiae = 0;
                $saldodias = 0;
            } else if ($row->{$campos[4]} == 2) {

                $val = $row->{$campos[2]};
                $saldo = $saldo - $val;
                $saldodias = $saldodias + $val;
            } else if ($row->{$campos[4]} == 3) {

                $val = $row->{$campos[2]};
                $saldo = $saldo + $val;
                $saldodiae = $saldodiae + $val;
            } else if ($row->{$campos[4]} == 4) {

                $val = $row->{$campos[2]};
                $saldo = $saldo - $val;
                $saldodias = $saldodias + $val;
            }



            $primeiro = 1;

            $dtdata2 = substr($row->{$campos[1]}, 6, 4) . substr($row->{$campos[1]}, 3, 2) . substr($row->{$campos[1]}, 0, 2);
            $dtdata2x = $row->{$campos[1]};
        } else {
            if ($row->{$campos[4]} == 1) {
                $val = intval($row->{$campos[2]});
                $saldo = $val;
            } else if ($row->{$campos[4]} == 2) {
                $val = intval($row->{$campos[2]});
                $saldo = $saldo - $val;
            } else if ($row->{$campos[4]} == 3) {
                $val = intval($row->{$campos[2]});
                $saldo = $saldo + $val;
            } else if ($row->{$campos[4]} == 4) {
                $val = intval($row->{$campos[2]});
                $saldo = $saldo - $val;
            }
        }
    }

    $pdf->Cell(30, 4, '', 0, 0, 'R');
    $pdf->Cell(30, 4, '' . $dtdata2x, 0, 0, 'R');
    $pdf->Cell(30, 4, '' . $saldodiae, 0, 0, 'R');
    $pdf->Cell(30, 4, '' . $saldodias, 0, 0, 'R');
    $pdf->Cell(30, 4, '' . $saldo, 0, 1, 'R');
}

$pdf->Output();
?>
