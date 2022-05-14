<?php

require('fpdfnew.php');
require('./_app/Config.inc.php');

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
        $this->Cell(30, 10, 'Relatório De Pedidos Baixados', 0, 1, 'C');
        $this->Cell(30, 5, '', 0, 1, 'C');




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

$dtiniciox = trim($_GET["dtinicio"]);
$dtfinalx = trim($_GET["dtfinal"]);

$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(187, 5, 'De ' . $dtiniciox . ' Até ' . $dtfinalx, 0, 1, 'C');
$pdf->Cell(187, 5, '', 0, 1, 'C');

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

$pdf->SetFont('Times', 'B', 8);
$pdf->Cell(15, 5, 'Número', 1, 0);
$pdf->Cell(10, 5, 'Baixa', 1, 0);
$pdf->Cell(15, 5, 'Emissão', 1, 0);
$pdf->Cell(15, 5, 'Data Baixa', 1, 0);
$pdf->Cell(67, 5, 'Fornecedor', 1, 0);
$pdf->Cell(20, 5, 'Comprador', 1, 0);
$pdf->Cell(12, 5, 'Volumes', 1, 0);

$pdf->Cell(12, 5, 'Nota', 1, 0);
$pdf->Cell(15, 5, 'Emissão', 1, 0);
$pdf->Cell(6, 5, 'AT', 1, 1);


$pdf->SetFont('Times', 'B', 8);

$tot = 0;

if ($read->getRowCount() >= 1) {

    foreach ($read->getResult() as $registros) {
        extract($registros);



        if (trim($notentvolumes) == "") {
            $notentvolumes = "0";
        }

        if (trim($notatualiza) == "1") {
            $notatualiza = "S";
        } else {
            $notatualiza = "N";
        }

        $tot = $tot + $notentvolumes;

        $pdf->Cell(15, 5, '' . $pcnumero, 1, 0, 'R');
        $pdf->Cell(10, 5, '' . $notentseqbaixa, 1, 0, 'C');
        $pdf->Cell(15, 5, '' . $emissao, 1, 0, 'C');
        $pdf->Cell(15, 5, '' . $baixa, 1, 0, 'C');
        $pdf->SetFont('Times', 'B', 5);
        $pdf->Cell(67, 5, $forcod . '  ' . $forrazao, 1, 0);
        $pdf->Cell(20, 5, '' . $comprador, 1, 0);
        $pdf->SetFont('Times', 'B', 8);
        $pdf->Cell(12, 5, '' . number_format($notentvolumes, 0, ',', '.') . ' ', 1, 0, 'R');

        $pdf->Cell(12, 5, '' . trim($notentnumero) . ' ', 1, 0, 'R');
        $pdf->Cell(15, 5, '' . $notentemissao . ' ', 1, 0, 'L');
        $pdf->Cell(6, 5, '' . $notatualiza . ' ', 1, 1, 'C');
    }

    $pdf->Cell(187, 5, 'Total de Volumes:       ' . number_format($tot, 0, ',', '.') . ' ', 1, 1, 'R');
}
$read = null;
$pdf->Output();

