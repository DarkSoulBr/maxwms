<?php

require('fpdfnew.php');
require('./_app/Config.inc.php');
require_once("include/config.php");

$pcnumero = trim($_GET["pcnumero"]);
$tipo = trim($_GET["tipo"]);

class PDF extends FPDF {

//Page header
    function Header() {

        $pcnum = trim($_GET["pcnumero"]);

        $sql = "SELECT a.localentrega,a.pcempresa FROM pcompra a WHERE a.pcnumero = '$pcnum'";
        $read = new Read;
        $read->FullRead($sql);
        $localentrega = 3;
        $pcempresa = 1;
        if ($read->getRowCount() >= 1) {
            $localentrega = $read->getResult()[0]['localentrega'];
            $pcempresa = $read->getResult()[0]['pcempresa'];
        }
        $read = null;
        
        if($pcempresa==2) {
            $codest = 38;
            $localentrega = 6;
        } else {
            if ($localentrega == 1) {
                $codest = 1;
            } else if ($localentrega == 2) {
                $codest = 2;
            } else if ($localentrega == 3) {
                $codest = 9;
            } else if ($localentrega == 4) {
                $codest = 11;
            } else if ($localentrega == 5) {
                $codest = 26;
            }
        }

        $sql = "SELECT a.etqnome FROM estoque a WHERE a.etqcodigo = '$codest'";
        $read = new Read;
        $read->FullRead($sql);
        $nomestoque = '';
        if ($read->getRowCount() >= 1) {
            $nomestoque = $read->getResult()[0]['etqnome'];
        }
        $read = null;

        $data = date('d') . '/' . date('m') . '/' . date('y');
        $hora = date('H') . ':' . date('i');

        $this->SetFont('Arial', 'B', 9);

        $this->SetFont('Arial', 'B', 9);
        $this->Cell(100, 4, 'CENTRO ATACADISTA BARAO - ' . $nomestoque, 0, 0, 'L');

        $this->Cell(60, 4, $data . ' ' . $hora, 0, 0, 'C');

        $this->Cell(0, 4, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 1, 'R');

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
//     $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
    }

}

//Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 10);


$sql = "SELECT a.pcemissao,
  b.fornguerra,b.forrazao,
  d.fneendereco,
  e.descricao,e.uf,
  b.forcnpj,b.forie,
  d.fnefone,
  a.comprador,
  a.condicao,
  a.observacao1,
  a.observacao2,
  a.observacao3,
  a.observacao4,
  a.observacao5,
  a.tipoped,
  a.localentrega,
  a.pcempresa,
  a.comissao

  FROM  pcompra a
  LEft Join fornecedor as b on a.forcodigo = b.forcodigo
  LEft Join forecom as d on b.forcodigo = d.forcodigo
  LEft Join cidades as e on d.cidcodigo = e.cidcodigo
  Where a.pcnumero = '$pcnumero'";

$read2 = new Read;
$read2->FullRead($sql);

if ($read2->getRowCount() >= 1) {

    foreach ($read2->getResult() as $registros2) {
        extract($registros2);
        $notentdata = $pcemissao;
        
        if($pcempresa==2) {            
            $localentrega = 6;
        }
        
        if ($tipoped == 1) {
            $tipopedido = 'TIPO DE PEDIDO: 1 - COMPRA';
        } else if ($tipoped == 2) {
            $tipopedido = 'TIPO DE PEDIDO: 2 - RETORNO DE CONSERTO';
        } else {
            $tipopedido = 'TIPO DE PEDIDO: 3 - BONIFICAÇÃO';
        }

        $pdf->SetFont('Times', '', 9);

        $pdf->Cell(190, 4, 'PEDIDO NUMERO: ' . $pcnumero . '', 0, 1, 'L');
        $pdf->Cell(190, 4, 'EMISSÃO: ' . substr($notentdata, 8, 2) . '/' . substr($notentdata, 5, 2) . '/' . substr($notentdata, 0, 4) . '  ' . $tipopedido, 0, 1, 'L');

        if ($localentrega == 3) {

            $pdf->Cell(190, 0, '', 1, 1, 'L');
            $pdf->Cell(95, 4, 'FATURAMENTO E ENTREGA:', 0, 0, 'L');
            $pdf->Cell(95, 4, 'COBRANCA:', 0, 1, 'L');
            $pdf->Cell(95, 4, 'CENTRO ATACADISTA BARAO LTDA.', 0, 0, 'L');
            $pdf->Cell(95, 4, 'CENTRO ATACADISTA BARAO LTDA.', 0, 1, 'L');
            $pdf->Cell(95, 4, 'AV. PAPA JOAO PAULO I, 5.627, GALPAO 2', 0, 0, 'L');
            $pdf->Cell(95, 4, 'PRAÇA PADRE MANOEL DA NOBREGA, 28/36 - 5 ANDAR', 0, 1, 'L');
            $pdf->Cell(95, 4, 'BONSUCESSO - GUARULHOS - SP CEP:07170-350', 0, 0, 'L');
            $pdf->Cell(95, 4, 'CENTRO - SAO PAULO - SP CEP:01015-010', 0, 1, 'L');
            $pdf->Cell(95, 4, 'CNPJ:49.329.873/0002-12', 0, 0, 'L');
            //$pdf->Cell(95, 4, 'CNPJ:49.329.873/0002-12', 0, 1, 'L');
            $pdf->Cell(95, 4, 'CNPJ:49.329.873/0005-65', 0, 1, 'L');
            $pdf->Cell(95, 4, 'IE 796.298.971.112', 0, 0, 'L');
            //$pdf->Cell(95, 4, 'IE 796.298.971.112', 0, 1, 'L');
            $pdf->Cell(95, 4, 'IE 336.521.740.111', 0, 1, 'L');

            $pdf->Cell(190, 0, '', 1, 1, 'L');
            $pdf->Cell(190, 4, 'AGENDAR ENTREGA NO TELEFONE : 11.2088-7650 - SETOR DE RECEBIMENTO DE MERCADORIAS', 0, 1, 'L');
            $pdf->Cell(190, 0, '', 1, 1, 'L');
        } else if ($localentrega == 1) {

            $pdf->Cell(190, 0, '', 1, 1, 'L');
            $pdf->Cell(95, 4, 'COBRANCA:', 0, 0, 'L');
            $pdf->Cell(95, 4, 'FATURAMENTO E ENTREGA:', 0, 1, 'L');
            $pdf->Cell(95, 4, 'CENTRO ATACADISTA BARAO LTDA.', 0, 0, 'L');
            $pdf->Cell(95, 4, 'CENTRO ATACADISTA BARAO LTDA.', 0, 1, 'L');
            $pdf->Cell(95, 4, 'PRAÇA PADRE MANOEL DA NOBREGA, 28/36 - 5 ANDAR', 0, 0, 'L');
            $pdf->Cell(95, 4, 'RUA BARAO DE DUPRAT 111', 0, 1, 'L');
            $pdf->Cell(95, 4, 'CENTRO - SAO PAULO - SP CEP:01015-010', 0, 0, 'L');
            $pdf->Cell(95, 4, 'CENTRO - CEP: 01023-001', 0, 1, 'L');
            //$pdf->Cell(95, 4, 'CNPJ:49.329.873/0002-12', 0, 0, 'L');
            $pdf->Cell(95, 4, 'CNPJ:49.329.873/0005-65', 0, 0, 'L');
            $pdf->Cell(95, 4, 'CNPJ:49.329.873/0003-01', 0, 1, 'L');
            //$pdf->Cell(95, 4, 'IE 796.298.971.112', 0, 0, 'L');
            $pdf->Cell(95, 4, 'IE 336.521.740.111', 0, 0, 'L');
            $pdf->Cell(95, 4, 'IE 113.349.285.113', 0, 1, 'L');

            $pdf->Cell(190, 0, '', 1, 1, 'L');
            $pdf->Cell(190, 4, 'HORARIO DE RECEBIMENTO:  SEG. A SEXTA DAS 08:00 AS 12:00  E  13:00 AS 17:00', 0, 1, 'L');
            $pdf->Cell(190, 0, '', 1, 1, 'L');
        } else if ($localentrega == 2) {

            $pdf->Cell(190, 0, '', 1, 1, 'L');
            $pdf->Cell(95, 4, 'COBRANCA:', 0, 0, 'L');
            $pdf->Cell(95, 4, 'FATURAMENTO E ENTREGA:', 0, 1, 'L');
            $pdf->Cell(95, 4, 'CENTRO ATACADISTA BARAO LTDA.', 0, 0, 'L');
            $pdf->Cell(95, 4, 'CENTRO ATACADISTA BARAO LTDA.', 0, 1, 'L');
            $pdf->Cell(95, 4, 'PRAÇA PADRE MANOEL DA NOBREGA, 28/36 - 5 ANDAR', 0, 0, 'L');
            $pdf->Cell(95, 4, 'RUA BARAO DE DUPRAT 351', 0, 1, 'L');
            $pdf->Cell(95, 4, 'CENTRO - SAO PAULO - SP CEP:01015-010', 0, 0, 'L');
            $pdf->Cell(95, 4, 'CENTRO - CEP: 01023-001', 0, 1, 'L');
            //$pdf->Cell(95, 4, 'CNPJ:49.329.873/0002-12', 0, 0, 'L');
            $pdf->Cell(95, 4, 'CNPJ:49.329.873/0001-31', 0, 0, 'L');
            $pdf->Cell(95, 4, 'CNPJ:49.329.873/0001-31', 0, 1, 'L');
            //$pdf->Cell(95, 4, 'IE 796.298.971.112', 0, 0, 'L');
            $pdf->Cell(95, 4, 'IE 109.878.357.111', 0, 0, 'L');
            $pdf->Cell(95, 4, 'IE 109.878.357.111', 0, 1, 'L');

            $pdf->Cell(190, 0, '', 1, 1, 'L');
            $pdf->Cell(190, 4, 'HORARIO DE RECEBIMENTO:  SEG. A SEXTA DAS 08:00 AS 12:00  E  13:00 AS 17:00', 0, 1, 'L');
            $pdf->Cell(190, 0, '', 1, 1, 'L');
        } else if ($localentrega == 4) {

            $pdf->Cell(190, 0, '', 1, 1, 'L');
            $pdf->Cell(95, 4, 'COBRANCA:', 0, 0, 'L');
            $pdf->Cell(95, 4, 'FATURAMENTO E ENTREGA:', 0, 1, 'L');
            $pdf->Cell(95, 4, 'CENTRO ATACADISTA BARAO LTDA.', 0, 0, 'L');
            $pdf->Cell(95, 4, 'CENTRO ATACADISTA BARAO LTDA.', 0, 1, 'L');
            $pdf->Cell(95, 4, 'PRAÇA PADRE MANOEL DA NOBREGA, 28/36 - 5 ANDAR', 0, 0, 'L');
            $pdf->Cell(95, 4, 'AVENIDA CEM 1212 MOD.16 Q 01 SALA 6', 0, 1, 'L');
            $pdf->Cell(95, 4, 'CENTRO - SAO PAULO - SP CEP:01015-010', 0, 0, 'L');
            $pdf->Cell(95, 4, 'TIMS - CEP: 29161-384 - SERRA ES', 0, 1, 'L');
            //$pdf->Cell(95, 4, 'CNPJ:49.329.873/0002-12', 0, 0, 'L');
            $pdf->Cell(95, 4, 'CNPJ:49.329.873/0005-65', 0, 0, 'L');
            $pdf->Cell(95, 4, 'CNPJ:49.329.873/0004-84', 0, 1, 'L');
            //$pdf->Cell(95, 4, 'IE 796.298.971.112', 0, 0, 'L');
            $pdf->Cell(95, 4, 'IE 336.521.740.111', 0, 0, 'L');
            $pdf->Cell(95, 4, 'IE 082.645.95-7', 0, 1, 'L');

            $pdf->Cell(190, 0, '', 1, 1, 'L');
            $pdf->Cell(190, 4, 'AGENDAR ENTREGA NO TELEFONE : (27) 3328-9405 - SETOR DE RECEBIMENTO DE MERCADORIAS', 0, 1, 'L');
            $pdf->Cell(190, 0, '', 1, 1, 'L');
        } else if ($localentrega == 5) {

            $pdf->Cell(190, 0, '', 1, 1, 'L');
            $pdf->Cell(95, 4, 'FATURAMENTO E ENTREGA:', 0, 0, 'L');
            $pdf->Cell(95, 4, 'COBRANCA:', 0, 1, 'L');
            $pdf->Cell(95, 4, 'CENTRO ATACADISTA BARAO LTDA.', 0, 0, 'L');
            $pdf->Cell(95, 4, 'CENTRO ATACADISTA BARAO LTDA.', 0, 1, 'L');
            $pdf->Cell(95, 4, 'AV. PAPA JOAO PAULO I, 5.627, GALPAO 1', 0, 0, 'L');
            $pdf->Cell(95, 4, 'PRAÇA PADRE MANOEL DA NOBREGA, 28/36 - 5 ANDAR', 0, 1, 'L');
            $pdf->Cell(95, 4, 'BONSUCESSO - GUARULHOS - SP CEP:07170-350', 0, 0, 'L');
            $pdf->Cell(95, 4, 'CENTRO - SAO PAULO - SP CEP:01015-010', 0, 1, 'L');
            $pdf->Cell(95, 4, 'CNPJ:49.329.873/0005-65', 0, 0, 'L');
            //$pdf->Cell(95, 4, 'CNPJ:49.329.873/0002-12', 0, 1, 'L');
            $pdf->Cell(95, 4, 'CNPJ:49.329.873/0005-65', 0, 1, 'L');
            $pdf->Cell(95, 4, 'IE 336.521.740.111', 0, 0, 'L');
            //$pdf->Cell(95, 4, 'IE 796.298.971.112', 0, 1, 'L');
            $pdf->Cell(95, 4, 'IE 336.521.740.111', 0, 1, 'L');

            $pdf->Cell(190, 0, '', 1, 1, 'L');
            $pdf->Cell(190, 4, 'AGENDAR ENTREGA NO TELEFONE : 11.2088-7650 - SETOR DE RECEBIMENTO DE MERCADORIAS', 0, 1, 'L');
            $pdf->Cell(190, 0, '', 1, 1, 'L');
        } else if ($localentrega == 6) {

            $pdf->Cell(190, 0, '', 1, 1, 'L');
            $pdf->Cell(95, 4, 'FATURAMENTO E ENTREGA:', 0, 0, 'L');
            $pdf->Cell(95, 4, 'COBRANCA:', 0, 1, 'L');
            $pdf->Cell(95, 4, 'FUN COMERCIO DE BRINQUEDOS LTDA.', 0, 0, 'L');
            $pdf->Cell(95, 4, 'FUN COMERCIO DE BRINQUEDOS LTDA.', 0, 1, 'L');
            $pdf->Cell(95, 4, 'AV. PAPA JOAO PAULO I, 5.627, GALPAO 2', 0, 0, 'L');
            $pdf->Cell(95, 4, 'PRAÇA PADRE MANOEL DA NOBREGA, 28/36 - 5 ANDAR', 0, 1, 'L');
            $pdf->Cell(95, 4, 'VILA AEROPORTO - GUARULHOS - SP CEP:07170-350', 0, 0, 'L');
            $pdf->Cell(95, 4, 'CENTRO - SAO PAULO - SP CEP:01015-010', 0, 1, 'L');
            $pdf->Cell(95, 4, 'CNPJ:20.548.209/0001-00', 0, 0, 'L');
            $pdf->Cell(95, 4, 'CNPJ:20.548.209/0001-00', 0, 1, 'L');
            $pdf->Cell(95, 4, 'IE 796.236.052.111', 0, 0, 'L');
            $pdf->Cell(95, 4, 'IE 796.236.052.111', 0, 1, 'L');

            $pdf->Cell(190, 0, '', 1, 1, 'L');
            $pdf->Cell(190, 4, 'AGENDAR ENTREGA NO TELEFONE : 11.2088-7650 - SETOR DE RECEBIMENTO DE MERCADORIAS', 0, 1, 'L');
            $pdf->Cell(190, 0, '', 1, 1, 'L');
        }

        $pdf->Cell(190, 4, 'Fornecedor: ' . $fornguerra, 0, 1, 'L');
        $pdf->Cell(190, 4, 'Razão: ' . $forrazao, 0, 1, 'L');
        $pdf->Cell(90, 4, 'Endereço: ' . $fneendereco, 0, 0, 'L');
        $pdf->Cell(70, 4, 'Cidade: ' . $descricao, 0, 0, 'L');
        $pdf->Cell(30, 4, 'Estado: ' . $uf, 0, 1, 'L');
        $pdf->Cell(90, 4, 'C.G.C.: ' . $forcnpj, 0, 0, 'L');
        $pdf->Cell(70, 4, 'Inscr. Est.: ' . $forie, 0, 0, 'L');
        $pdf->Cell(30, 4, 'Fone: ' . $fnefone, 0, 1, 'L');

        $pdf->Cell(90, 4, 'Comprador: ' . $comprador, 0, 1, 'L');

        $pdf->Cell(190, 4, 'Cond.Pagto: ' . $condicao, 0, 1, 'L');
        $pdf->Cell(190, 4, 'Observação: ' . $observacao1, 0, 1, 'L');
        $pdf->Cell(190, 4, $observacao2, 0, 1, 'L');

        if (trim($observacao3) <> '') {
            $pdf->Cell(190, 4, $observacao3, 0, 1, 'L');
        }
        if (trim($observacao4) <> '') {
            $pdf->Cell(190, 4, $observacao4, 0, 1, 'L');
        }
        if (trim($observacao5) <> '') {
            $pdf->Cell(190, 4, $observacao5, 0, 1, 'L');
        }

        $pdf->Cell(190, 4, 'PEDIDO NUMERO: ' . $pcnumero, 0, 1, 'R');

        $pdf->SetFont('Times', '', 6);

        if (MAX_NOVO != 3) {
            $pdf->Cell(9, 4, 'Codigo', 1, 0, 'L');
            $pdf->Cell(50, 4, 'Descricao', 1, 0, 'L');
            $pdf->Cell(13, 4, 'Ref.For.', 1, 0, 'L');
            $pdf->Cell(9, 4, 'Qt.Emb.', 1, 0, 'R');
            $pdf->Cell(9, 4, 'Emb.', 1, 0, 'L');
            $pdf->Cell(9, 4, 'Quant.', 1, 0, 'R');
            $pdf->Cell(9, 4, 'Altura', 1, 0, 'R');
            $pdf->Cell(9, 4, 'Largura', 1, 0, 'R');
            $pdf->Cell(9, 4, 'Compr.', 1, 0, 'R');
            $pdf->Cell(17, 4, 'Cod. Barras Uni.', 1, 0, 'R');
            $pdf->Cell(17, 4, 'Cod. Barras Cx.', 1, 0, 'R');
            $pdf->Cell(7, 4, 'UN', 1, 0, 'C');
            $pdf->Cell(10, 4, 'Valor', 1, 0, 'R');
            $pdf->Cell(14, 4, 'Valor Total', 1, 1, 'R');
        } else {
            $pdf->Cell(9, 4, 'Codigo', 1, 0, 'L');
            $pdf->Cell(49, 4, 'Descricao', 1, 0, 'L');
            $pdf->Cell(8, 4, 'Sort.', 1, 0, 'L');
            $pdf->Cell(13, 4, 'Ref.For.', 1, 0, 'L');
            $pdf->Cell(8, 4, 'Qt.Emb.', 1, 0, 'C');
            $pdf->Cell(8, 4, 'Emb.', 1, 0, 'L');
            $pdf->Cell(9, 4, 'Quant.', 1, 0, 'R');
            $pdf->Cell(8, 4, 'Altura', 1, 0, 'R');
            $pdf->Cell(8, 4, 'Largura', 1, 0, 'R');
            $pdf->Cell(8, 4, 'Compr.', 1, 0, 'R');
            $pdf->Cell(16, 4, 'Cod. Barras Uni.', 1, 0, 'R');
            $pdf->Cell(17, 4, 'Cod. Barras Cx.', 1, 0, 'R');
            $pdf->Cell(6, 4, 'UN', 1, 0, 'C');
            $pdf->Cell(10, 4, 'Valor', 1, 0, 'R');
            $pdf->Cell(14, 4, 'Valor Total', 1, 1, 'R');
        }

        $sql = "SELECT c.procodigo,c.procod,c.prnome,c.proref,b.pcisaldo
                    ,b.pcipreco
                    ,b.desc1
                    ,b.desc2
                    ,b.desc3
                    ,b.desc4
                    ,b.ipi
                    ,d.medsigla
                    ,b.pcibaixa
                    ,c.proemb   
                    ,c.proaltcx
                    ,c.prolarcx
                    ,c.procomcx
                    ,e.barcaixa
                    ,e.barunidade 
                    FROM  pcitem b,produto c      
                    LEft Join medidas as d on d.medcodigo = c.medcodigo
                    left join cbarras as e on e.procodigo = c.procodigo 
                    Where b.pcnumero = '$pcnumero'
                    and b.procodigo = c.procodigo
                    order by c.proref";

        $read3 = new Read;
        $read3->FullRead($sql);

        if ($read3->getRowCount() >= 1) {

            $vtotal = 0;
            foreach ($read3->getResult() as $registros3) {
                extract($registros3);
                if ($pcibaixa == '') {
                    $pcibaixa = 0;
                }
                if ($tipo == 1) {
                    $pcisaldo = $pcisaldo - $pcibaixa;
                }

                if ($pcisaldo > 0) {

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

                    if (MAX_NOVO != 3) {

                        $pdf->Cell(9, 4, $procod, 1, 0, 'L');
                        $pdf->Cell(50, 4, $prnome, 1, 0, 'L');
                        $pdf->Cell(13, 4, $proref, 1, 0, 'L');

                        $qtemb = 0;
                        if ($proemb != 0) {
                            $qtemb = round($pcisaldo / $proemb, 2);
                        } else {
                            $qtemb = 0;
                        }

                        $pdf->Cell(9, 4, $qtemb, 1, 0, 'R');
                        $pdf->Cell(9, 4, $proemb, 1, 0, 'R');
                        $pdf->Cell(9, 4, $pcisaldo, 1, 0, 'R');

                        $pdf->Cell(9, 4, $proaltcx, 1, 0, 'R');
                        $pdf->Cell(9, 4, $prolarcx, 1, 0, 'R');
                        $pdf->Cell(9, 4, $procomcx, 1, 0, 'R');

                        $pdf->Cell(17, 4, $barunidade, 1, 0, 'R');
                        $pdf->Cell(17, 4, $barcaixa, 1, 0, 'R');

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
                        $liq = round($liq, 2);

                        $liqx = $liq * 100;
                        $l = strlen($liqx) - 2;
                        $liqx = substr($liqx, 0, $l) . "." . substr($liqx, $l, 2);

                        $pdf->Cell(7, 4, $medsigla, 1, 0, 'C');

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

                        $pdf->Cell(10, 4, $valx, 1, 0, 'R');
                        $vtot = round($valaux * $pcisaldo, 2);

                        $vtotx = $vtot * 100;
                        $l = strlen($vtotx) - 2;
                        $vtotx = substr($vtotx, 0, $l) . "." . substr($vtotx, $l, 2);

                        $pdf->Cell(14, 4, $vtotx, 1, 1, 'R');

                        $vtotal = $vtotal + $vtot;
                    } else {

                        //Verifica se é um item Master
                        $temsortimento = '';

                        $sql4 = "SELECT a.procodigo as sortcodigo,a.procod as sortcod,a.prnome as sortnom,a.proref as sortref,a.proemb as sortemb,d.medsigla as sortmed
                        ,a.proaltura as sortproaltcx
			,a.prolargura as sortprolarcx
			,a.procompr as sortprocomcx
			,e.barcaixa as sortbarcaixa
			,e.barunidade as sortbarunidade 
                        FROM produto a 
			LEFT JOIN medidas as d on a.medcodigo = d.medcodigo 
                        LEFT JOIN cbarras as e on a.procodigo = e.procodigo 
                        where a.promaster = {$procodigo} order by a.procod";
                        $read4 = new Read;
                        $read4->FullRead($sql4);

                        if ($read4->getRowCount() >= 1) {
                            $temsortimento = 'Master';
                        }


                        $pdf->Cell(9, 4, $procod, 1, 0, 'L');
                        $pdf->Cell(49, 4, $prnome, 1, 0, 'L');
                        $pdf->Cell(8, 4, $temsortimento, 1, 0, 'L');
                        if (strlen($proref) > 12) {
                            $pdf->SetFont('Times', '', 5);
                            $pdf->Cell(13, 4, $proref, 1, 0, 'L');
                            $pdf->SetFont('Times', '', 6);
                        } else {
                            $pdf->Cell(13, 4, $proref, 1, 0, 'L');
                        }


                        $qtemb = 0;
                        if ($proemb != 0) {
                            $qtemb = round($pcisaldo / $proemb, 2);
                        } else {
                            $qtemb = 0;
                        }

                        $pdf->Cell(8, 4, $qtemb, 1, 0, 'R');
                        $pdf->Cell(8, 4, $proemb, 1, 0, 'R');
                        $pdf->Cell(9, 4, $pcisaldo, 1, 0, 'R');

                        $pdf->Cell(8, 4, $proaltcx, 1, 0, 'R');
                        $pdf->Cell(8, 4, $prolarcx, 1, 0, 'R');
                        $pdf->Cell(8, 4, $procomcx, 1, 0, 'R');

                        $pdf->Cell(16, 4, $barunidade, 1, 0, 'R');
                        $pdf->Cell(17, 4, $barcaixa, 1, 0, 'R');

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
                        $liq = round($liq, 2);

                        $liqx = $liq * 100;
                        $l = strlen($liqx) - 2;
                        $liqx = substr($liqx, 0, $l) . "." . substr($liqx, $l, 2);

                        $pdf->Cell(6, 4, $medsigla, 1, 0, 'C');

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

                        $pdf->Cell(10, 4, $valx, 1, 0, 'R');
                        $vtot = round($valaux * $pcisaldo, 2);

                        $vtotx = $vtot * 100;
                        $l = strlen($vtotx) - 2;
                        $vtotx = substr($vtotx, 0, $l) . "." . substr($vtotx, $l, 2);

                        $pdf->Cell(14, 4, $vtotx, 1, 1, 'R');

                        $vtotal = $vtotal + $vtot;

                        //Se tiver Sortimentos 
                        foreach ($read4->getResult() as $registros4) {
                            extract($registros4);

                            $pdf->Cell(9, 4, $sortcod, 1, 0, 'L');
                            $pdf->Cell(49, 4, $sortnom, 1, 0, 'L');
                            $pdf->Cell(8, 4, $procod, 1, 0, 'L');
                            if (strlen($sortref) > 12) {
                                $pdf->SetFont('Times', '', 5);
                                $pdf->Cell(13, 4, $sortref, 1, 0, 'L');
                                $pdf->SetFont('Times', '', 6);
                            } else {
                                $pdf->Cell(13, 4, $sortref, 1, 0, 'L');
                            }
                            $pdf->Cell(8, 4, '', 1, 0, 'R');
                            $pdf->Cell(8, 4, $sortemb, 1, 0, 'R');
                            $pdf->Cell(9, 4, '', 1, 0, 'R');

                            $pdf->Cell(8, 4, $sortproaltcx, 1, 0, 'R');
                            $pdf->Cell(8, 4, $sortprolarcx, 1, 0, 'R');
                            $pdf->Cell(8, 4, $sortprocomcx, 1, 0, 'R');

                            $pdf->Cell(16, 4, $sortbarunidade, 1, 0, 'R');
                            $pdf->Cell(17, 4, $sortbarcaixa, 1, 0, 'R');

                            $pdf->Cell(6, 4, $sortmed, 1, 0, 'C');
                            $pdf->Cell(10, 4, '', 1, 0, 'R');
                            $pdf->Cell(14, 4, '', 1, 1, 'R');
                        }
                        $read4 = null;
                    }
                }
            }
        }
        $read3 = null;

        $vtotalx = $vtotal * 100;
        $l = strlen($vtotalx) - 2;
        $vtotalx = substr($vtotalx, 0, $l) . "." . substr($vtotalx, $l, 2);

        $pdf->Cell(191, 4, 'Total Geral:   ' . $vtotalx, 1, 1, 'R');

        $pdf->SetFont('Times', '', 10);

        $pdf->Cell(190, 12, '', 0, 1, 'L');

        $pdf->Cell(95, 4, 'Compras : ________________________', 0, 0, 'L');
        $pdf->Cell(95, 4, 'Vendedor : ________________________', 0, 1, 'R');
    }
}
$read2 = null;
$pdf->Output();
