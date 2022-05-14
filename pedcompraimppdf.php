<?php

require('fpdfnew.php');
require('./_app/Config.inc.php');
require_once("include/config.php");

$pcnumero = trim($_GET["pcnumero"]);
$pcseq = trim($_GET["pcseq"]);

class PDF extends FPDF {

//Page header
    function Header() {

        $pcnum = trim($_GET["pcnumero"]);
        $pcbai = trim($_GET["pcseq"]);

        $sql = "SELECT c.deposito FROM notaent c WHERE c.pcnumero = '$pcnum' AND c.notentseqbaixa = '$pcbai'";
        $read = new Read;
        $read->FullRead($sql);
        if ($read->getRowCount() >= 1) {
            $codest = $read->getResult()[0]['deposito'];
        }
        $read = null;
        $sql = "SELECT a.etqnome FROM estoque a WHERE a.etqcodigo = '$codest'";
        $read = new Read;
        $read->FullRead($sql);
        if ($read->getRowCount() >= 1) {
            $nomestoque = $read->getResult()[0]['etqnome'];
        }
        $read = null;
        $data = date('d') . '/' . date('m') . '/' . date('y');
        $hora = date('H') . ':' . date('i');

        $this->SetFont('Arial', 'B', 9);
        $this->Cell(100, 4, 'CENTRO ATACADISTA BARAO - ' . $nomestoque, 0, 0, 'L');

        $this->Cell(110, 4, $data . ' ' . $hora, 0, 0, 'C');

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
$pdf = new PDF('l');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 10);


$sql = "SELECT c.notentnumero,c.notentdata,
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
  a.localentrega,
  a.comissao,
  a.pcempresa,
  c.notentobservacoes,
  c.notentcodigo,
  c.notatualiza,
  b.forcodigo

  FROM  notaent c, pcompra a
  LEft Join fornecedor as b on a.forcodigo = b.forcodigo
  LEft Join forecom as d on b.forcodigo = d.forcodigo
  LEft Join cidades as e on d.cidcodigo = e.cidcodigo
  Where c.pcnumero = '$pcnumero'
  and a.pcnumero = c.pcnumero
  and c.notentseqbaixa = '$pcseq'";

$read2 = new Read;
$read2->FullRead($sql);

if ($read2->getRowCount() >= 1) {

    foreach ($read2->getResult() as $registros2) {
        extract($registros2);

        if ($comissao == 0) {
            $comissao = 100;
        }
        if (trim($notatualiza) == "") {
            $notatualiza = "0";
        }
        if ($notatualiza == '1') {
            $notatual = 'Sim';
        } else {
            $notatual = 'Não';
        }
        
        if($pcempresa==2) {            
            $localentrega = 6;
        }

        $pdf->SetFont('Times', '', 9);

        $pdf->Cell(190, 4, 'PEDIDO NUMERO: ' . $pcnumero . '', 0, 1, 'L');
        $pdf->Cell(190, 4, 'BAIXA FISICA: ' . $pcseq . ' - ' . substr($notentdata, 8, 2) . '/' . substr($notentdata, 5, 2) . '/' . substr($notentdata, 0, 4) . ' Atualiza Estoque: ' . $notatual, 0, 1, 'L');


        if ($localentrega == 3) {

            $pdf->Cell(272, 0, '', 1, 1, 'L');
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

            $pdf->Cell(272, 0, '', 1, 1, 'L');
            $pdf->Cell(190, 4, 'AGENDAR ENTREGA NO TELEFONE : 11.2088-7650 - SETOR DE RECEBIMENTO DE MERCADORIAS', 0, 1, 'L');
            $pdf->Cell(272, 0, '', 1, 1, 'L');
        } else if ($localentrega == 1) {

            $pdf->Cell(272, 0, '', 1, 1, 'L');
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

            $pdf->Cell(272, 0, '', 1, 1, 'L');
            $pdf->Cell(190, 4, 'HORARIO DE RECEBIMENTO:  SEG. A SEXTA DAS 08:00 AS 12:00  E  13:00 AS 17:00', 0, 1, 'L');
            $pdf->Cell(272, 0, '', 1, 1, 'L');
        } else if ($localentrega == 2) {

            $pdf->Cell(272, 0, '', 1, 1, 'L');
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

            $pdf->Cell(272, 0, '', 1, 1, 'L');
            $pdf->Cell(190, 4, 'HORARIO DE RECEBIMENTO:  SEG. A SEXTA DAS 08:00 AS 12:00  E  13:00 AS 17:00', 0, 1, 'L');
            $pdf->Cell(272, 0, '', 1, 1, 'L');
        } else if ($localentrega == 4) {

            $pdf->Cell(272, 0, '', 1, 1, 'L');
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

            $pdf->Cell(272, 0, '', 1, 1, 'L');
            $pdf->Cell(190, 4, 'AGENDAR ENTREGA NO TELEFONE : (27) 3328-9405 - SETOR DE RECEBIMENTO DE MERCADORIAS', 0, 1, 'L');
            $pdf->Cell(272, 0, '', 1, 1, 'L');
        } else if ($localentrega == 5) {

            $pdf->Cell(272, 0, '', 1, 1, 'L');
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

            $pdf->Cell(272, 0, '', 1, 1, 'L');
            $pdf->Cell(190, 4, 'AGENDAR ENTREGA NO TELEFONE : 11.2088-7650 - SETOR DE RECEBIMENTO DE MERCADORIAS', 0, 1, 'L');
            $pdf->Cell(272, 0, '', 1, 1, 'L');
        } else if ($localentrega == 6) {

            $pdf->Cell(272, 0, '', 1, 1, 'L');
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

            $pdf->Cell(272, 0, '', 1, 1, 'L');
            $pdf->Cell(190, 4, 'AGENDAR ENTREGA NO TELEFONE : 11.2088-7650 - SETOR DE RECEBIMENTO DE MERCADORIAS', 0, 1, 'L');
            $pdf->Cell(272, 0, '', 1, 1, 'L');
        }

        $pdf->Cell(190, 4, 'Fornecedor: ' . $fornguerra, 0, 1, 'L');
        $pdf->Cell(190, 4, 'Razão: ' . $forrazao, 0, 1, 'L');
        $pdf->Cell(90, 4, 'Endereço: ' . $fneendereco, 0, 0, 'L');
        $pdf->Cell(70, 4, 'Cidade: ' . $descricao, 0, 0, 'L');
        $pdf->Cell(30, 4, 'Estado: ' . $uf, 0, 1, 'L');
        $pdf->Cell(90, 4, 'C.G.C.: ' . $forcnpj, 0, 0, 'L');
        $pdf->Cell(70, 4, 'Inscr. Est.: ' . $forie, 0, 0, 'L');
        $pdf->Cell(30, 4, 'Fone: ' . $fnefone, 0, 1, 'L');

        $pdf->Cell(190, 4, 'Comprador: ' . $comprador, 0, 1, 'L');
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

        $pdf->Cell(272, 4, 'PEDIDO NUMERO: ' . $pcnumero, 0, 1, 'R');

        $pdf->SetFont('Times', '', 7);

        if (MAX_NOVO != 3) {
            $pdf->Cell(10, 4, 'Codigo', 1, 0, 'L');
            $pdf->Cell(88, 4, 'Descricao', 1, 0, 'L');
            $pdf->Cell(7, 4, 'Emb.', 1, 0, 'L');
            $pdf->Cell(5, 4, 'CB', 1, 0, 'L');
            $pdf->Cell(22, 4, 'Ref.For.', 1, 0, 'L');
            $pdf->Cell(22, 4, 'Codigo de Barras', 1, 0, 'L');
            $pdf->Cell(14, 4, 'NCM', 1, 0, 'L');
            $pdf->Cell(8, 4, 'Quant.', 1, 0, 'R');
            $pdf->Cell(8, 4, 'Custo', 1, 0, 'R');
            $pdf->Cell(36, 4, 'Percentual de Desconto', 1, 0, 'C');
            $pdf->Cell(8, 4, 'C.Liq.', 1, 0, '');
            $pdf->Cell(6, 4, 'IPI', 1, 0, 'C');
            $pdf->Cell(6, 4, 'ICF', 1, 0, 'C');
            $pdf->Cell(6, 4, 'ICM', 1, 0, 'C');
            $pdf->Cell(6, 4, 'UN', 1, 0, 'C');
            $pdf->Cell(8, 4, 'Valor', 1, 0, 'R');
            $pdf->Cell(12, 4, 'Val.Total', 1, 1, 'R');
        } else {
            $pdf->Cell(10, 4, 'Codigo', 1, 0, 'L');
            $pdf->Cell(87, 4, 'Descricao', 1, 0, 'L');
            $pdf->Cell(7, 4, 'Emb.', 1, 0, 'L');
            $pdf->Cell(5, 4, 'CB', 1, 0, 'L');
            $pdf->Cell(9, 4, 'Sort.', 1, 0, 'L');
            $pdf->Cell(21, 4, 'Ref.For.', 1, 0, 'L');
            $pdf->Cell(20, 4, 'Codigo de Barras', 1, 0, 'L');
            $pdf->Cell(13, 4, 'NCM', 1, 0, 'L');
            $pdf->Cell(8, 4, 'Quant.', 1, 0, 'R');
            $pdf->Cell(8, 4, 'Custo', 1, 0, 'R');
            $pdf->Cell(32, 4, 'Percentual de Desconto', 1, 0, 'C');
            $pdf->Cell(8, 4, 'C.Liq.', 1, 0, '');
            $pdf->Cell(6, 4, 'IPI', 1, 0, 'C');
            $pdf->Cell(6, 4, 'ICF', 1, 0, 'C');
            $pdf->Cell(6, 4, 'ICM', 1, 0, 'C');
            $pdf->Cell(6, 4, 'UN', 1, 0, 'C');
            $pdf->Cell(8, 4, 'Valor', 1, 0, 'R');
            $pdf->Cell(12, 4, 'Val.Total', 1, 1, 'R');
        }


        $sql = "SELECT icm FROM condicaopagto WHERE forcodigo = " . $forcodigo;

        $read3 = new Read;
        $read3->FullRead($sql);
        if ($read3->getRowCount() >= 1) {
            $icmcad = $read3->getResult()[0]['icm'];
        } else {
            $icmcad = '0';
        }
        $read3 = null;

        $sql = "SELECT c.procodigo,c.procod,c.prnome,c.proref,a.neisaldo 
                ,pcipreco
                ,desc1
                ,desc2
                ,desc3
                ,desc4
                ,neipercicm
                ,neipercipi as ipi
                ,d.medsigla
                ,e.clanumero
                ,f.barunidade
                ,a.valornf
                ,c.proaltcx as proaltura
                ,c.prolarcx as prolargura
                ,c.procomcx as procompr
                ,c.proemb

                FROM  neitem a,pcitem b,produto c
                LEft Join medidas as d on d.medcodigo = c.medcodigo
                LEFT JOIN clfiscal as e on c.clacodigo = e.clacodigo
                LEFT JOIN cbarras as f on c.procodigo = f.procodigo
                Where a.notentcodigo = '$notentcodigo'
                and b.pcnumero = '$pcnumero'
                and a.procodigo = b.procodigo
                and a.procodigo = c.procodigo";

        $read3 = new Read;
        $read3->FullRead($sql);

        if ($read3->getRowCount() >= 1) {

            $vtotal = 0;
            foreach ($read3->getResult() as $registros3) {
                extract($registros3);

                $pcipreco = $valornf;
                if ($proaltura == '') {
                    $proaltura = 0;
                }
                if ($prolargura == '') {
                    $prolargura = 0;
                }
                if ($procompr == '') {
                    $procompr = 0;
                }

                //Descontos serão todos zerados pois o valor virá da nota	   
                $desc1 = 0;
                $desc2 = 0;
                $desc3 = 0;
                $desc4 = 0;

                $desc1x = '0.00';
                $desc2x = '0.00';
                $desc3x = '0.00';
                $desc4x = '0.00';

                $icm = $neipercicm;

                $pciprecox = $pcipreco * 100;
                $l = strlen($pciprecox) - 2;
                $pciprecox = substr($pciprecox, 0, $l) . "." . substr($pciprecox, $l, 2);

                if (MAX_NOVO != 3) {

                    $pdf->Cell(10, 4, $procod, 1, 0, 'L');
                    $pdf->Cell(88, 4, $prnome, 1, 0, 'L');
                    $pdf->Cell(7, 4, $proemb, 1, 0, 'R');
                    if ($proaltura * $prolargura * $procompr == 0) {
                        $pdf->Cell(5, 4, 'N', 1, 0);
                    } else {
                        $pdf->Cell(5, 4, 'S', 1, 0);
                    }
                    $pdf->Cell(22, 4, $proref, 1, 0, 'L');
                    $pdf->Cell(22, 4, $barunidade, 1, 0, 'L');
                    $pdf->Cell(14, 4, $clanumero, 1, 0, 'L');
                    $pdf->Cell(8, 4, $neisaldo, 1, 0, 'R');
                    $pdf->Cell(8, 4, $pciprecox, 1, 0, 'R');
                    $pdf->Cell(9, 4, $desc1x, 1, 0, 'R');
                    $pdf->Cell(9, 4, $desc2x, 1, 0, 'R');
                    $pdf->Cell(9, 4, $desc3x, 1, 0, 'R');
                    $pdf->Cell(9, 4, $desc4x, 1, 0, 'R');

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

                    $pdf->Cell(8, 4, $liqx, 1, 0, 'R');
                    $pdf->Cell(6, 4, $ipi, 1, 0, 'R');

                    $pdf->Cell(6, 4, $icmcad, 1, 0, 'R');
                    $pdf->Cell(6, 4, $icm, 1, 0, 'R');

                    $pdf->Cell(6, 4, $medsigla, 1, 0, 'C');

                    if ($ipi != 0) {
                        $vipi = ($liqaux * $comissao / 100) / 100 * $ipi;
                    } else {
                        $vipi = 0;
                    }
                    $valaux = $liqaux + $vipi;
                    $val = round($liqaux + $vipi, 2);
                    //$val=round($liq+$vipi,2);

                    $valx = $val * 100;
                    $l = strlen($valx) - 2;
                    $valx = substr($valx, 0, $l) . "." . substr($valx, $l, 2);

                    $pdf->Cell(8, 4, $valx, 1, 0, 'R');
                    $vtot = round($valaux * $neisaldo, 2);

                    $vtotx = $vtot * 100;
                    $l = strlen($vtotx) - 2;
                    $vtotx = substr($vtotx, 0, $l) . "." . substr($vtotx, $l, 2);

                    $pdf->Cell(12, 4, $vtotx, 1, 1, 'R');

                    $vtotal = $vtotal + $vtot;
                } else {

                    $temsortimento = '';

                    $sql4 = "SELECT a.procodigo as sortcodigo,a.procod as sortcod,a.prnome as sortnom,a.proref as sortref,a.proemb as sortemb,d.medsigla as sortmed
                    ,a.proaltura as sortproaltcx
                    ,a.prolargura as sortprolarcx
                    ,a.procompr as sortprocomcx
                    ,e.barcaixa as sortbarcaixa
                    ,e.barunidade as sortbarunidade 
                    ,f.clanumero as sortclanumero 
                    FROM produto a 
                    LEFT JOIN medidas as d on a.medcodigo = d.medcodigo 
                    LEFT JOIN cbarras as e on a.procodigo = e.procodigo 
                    LEFT JOIN clfiscal as f on a.clacodigo = f.clacodigo
                    where a.promaster = $procodigo order by a.procod";
                    $read4 = new Read;
                    $read4->FullRead($sql4);
                    if ($read4->getRowCount() >= 1) {
                        $temsortimento = 'Master';
                    }

                    $pdf->Cell(10, 4, $procod, 1, 0, 'L');
                    $pdf->Cell(87, 4, $prnome, 1, 0, 'L');
                    $pdf->Cell(7, 4, $proemb, 1, 0, 'R');
                    if ($proaltura * $prolargura * $procompr == 0) {
                        $pdf->Cell(5, 4, 'N', 1, 0);
                    } else {
                        $pdf->Cell(5, 4, 'S', 1, 0);
                    }
                    $pdf->Cell(9, 4, $temsortimento, 1, 0, 'L');
                    $pdf->Cell(21, 4, $proref, 1, 0, 'L');
                    $pdf->Cell(20, 4, $barunidade, 1, 0, 'L');
                    $pdf->Cell(13, 4, $clanumero, 1, 0, 'L');
                    $pdf->Cell(8, 4, $neisaldo, 1, 0, 'R');
                    $pdf->Cell(8, 4, $pciprecox, 1, 0, 'R');
                    $pdf->Cell(8, 4, $desc1x, 1, 0, 'R');
                    $pdf->Cell(8, 4, $desc2x, 1, 0, 'R');
                    $pdf->Cell(8, 4, $desc3x, 1, 0, 'R');
                    $pdf->Cell(8, 4, $desc4x, 1, 0, 'R');

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

                    $pdf->Cell(8, 4, $liqx, 1, 0, 'R');
                    $pdf->Cell(6, 4, $ipi, 1, 0, 'R');

                    $pdf->Cell(6, 4, $icmcad, 1, 0, 'R');
                    $pdf->Cell(6, 4, $icm, 1, 0, 'R');

                    $pdf->Cell(6, 4, $medsigla, 1, 0, 'C');

                    if ($ipi != 0) {
                        $vipi = ($liqaux * $comissao / 100) / 100 * $ipi;
                    } else {
                        $vipi = 0;
                    }
                    $valaux = $liqaux + $vipi;
                    $val = round($liqaux + $vipi, 2);
                    //$val=round($liq+$vipi,2);

                    $valx = $val * 100;
                    $l = strlen($valx) - 2;
                    $valx = substr($valx, 0, $l) . "." . substr($valx, $l, 2);

                    $pdf->Cell(8, 4, $valx, 1, 0, 'R');
                    $vtot = round($valaux * $neisaldo, 2);

                    $vtotx = $vtot * 100;
                    $l = strlen($vtotx) - 2;
                    $vtotx = substr($vtotx, 0, $l) . "." . substr($vtotx, $l, 2);

                    $pdf->Cell(12, 4, $vtotx, 1, 1, 'R');

                    $vtotal = $vtotal + $vtot;
                    
                    $contador = 0;

                    //Se tiver Sortimentos 
                    foreach ($read4->getResult() as $registros4) {
                        extract($registros4);
                        
                        $contador ++;

                        //Depois - Repete o Master com a Quantidade da Baixa
                        if ($contador == 1) {
                            
                            $quantidade = 0;
                            $sql5 = "SELECT neisaldo FROM neitemsort Where notentcodigo = {$notentcodigo} and procodigo={$procodigo}";

                            $read5 = new Read;
                            $read5->FullRead($sql5);
                            if ($read5->getRowCount() >= 1) {                             
                                $quantidade = $read5->getResult()[0]['neisaldo'];
                            }
                            $read5 = null;
                           

                            if ($quantidade != 0 && $quantidade != $neisaldo) {

                                $pdf->Cell(10, 4, $procod, 1, 0, 'L');
                                $pdf->Cell(87, 4, $prnome, 1, 0, 'L');
                                $pdf->Cell(7, 4, $proemb, 1, 0, 'R');
                                if ($proaltura * $prolargura * $procompr == 0) {
                                    $pdf->Cell(5, 4, 'N', 1, 0);
                                } else {
                                    $pdf->Cell(5, 4, 'S', 1, 0);
                                }
                                $pdf->Cell(9, 4, $procod, 1, 0, 'L');
                                $pdf->Cell(21, 4, $proref, 1, 0, 'L');
                                $pdf->Cell(20, 4, $barunidade, 1, 0, 'L');
                                $pdf->Cell(13, 4, $clanumero, 1, 0, 'L');
                                $pdf->Cell(8, 4, $quantidade, 1, 0, 'R');

                                $pdf->Cell(8, 4, '', 1, 0, 'R');
                                $pdf->Cell(8, 4, '', 1, 0, 'R');
                                $pdf->Cell(8, 4, '', 1, 0, 'R');
                                $pdf->Cell(8, 4, '', 1, 0, 'R');
                                $pdf->Cell(8, 4, '', 1, 0, 'R');


                                $pdf->Cell(8, 4, '', 1, 0, 'R');
                                $pdf->Cell(6, 4, '', 1, 0, 'R');

                                $pdf->Cell(6, 4, '', 1, 0, 'R');
                                $pdf->Cell(6, 4, '', 1, 0, 'R');

                                $pdf->Cell(6, 4, $medsigla, 1, 0, 'C');

                                $pdf->Cell(8, 4, '', 1, 0, 'R');

                                $pdf->Cell(12, 4, '', 1, 1, 'R');
                            }
                            
                        }

                        $quantidade = 0;
                        $sql5 = "SELECT neisaldo FROM neitemsort Where notentcodigo = {$notentcodigo} and procodigo={$sortcodigo}";
                        
                        $read5 = new Read;
                        $read5->FullRead($sql5);
                        if ($read5->getRowCount() >= 1) {                             
                            $quantidade = $read5->getResult()[0]['neisaldo'];
                        }
                        $read5 = null;

                        $pdf->Cell(10, 4, $sortcod, 1, 0, 'L');
                        $pdf->Cell(87, 4, $sortnom, 1, 0, 'L');
                        $pdf->Cell(7, 4, $sortemb, 1, 0, 'R');
                        if ($sortproaltcx * $sortprolarcx * $sortprocomcx == 0) {
                            $pdf->Cell(5, 4, 'N', 1, 0);
                        } else {
                            $pdf->Cell(5, 4, 'S', 1, 0);
                        }

                        $pdf->Cell(9, 4, $procod, 1, 0, 'L');
                        $pdf->Cell(21, 4, $sortref, 1, 0, 'L');
                        $pdf->Cell(20, 4, $sortbarunidade, 1, 0, 'L');

                        //Alterar
                        $pdf->Cell(13, 4, $sortclanumero, 1, 0, 'L');
                        $pdf->Cell(8, 4, $quantidade, 1, 0, 'R');

                        $pdf->Cell(8, 4, '', 1, 0, 'R');
                        $pdf->Cell(8, 4, '', 1, 0, 'R');
                        $pdf->Cell(8, 4, '', 1, 0, 'R');
                        $pdf->Cell(8, 4, '', 1, 0, 'R');
                        $pdf->Cell(8, 4, '', 1, 0, 'R');


                        $pdf->Cell(8, 4, '', 1, 0, 'R');
                        $pdf->Cell(6, 4, '', 1, 0, 'R');

                        $pdf->Cell(6, 4, '', 1, 0, 'R');
                        $pdf->Cell(6, 4, '', 1, 0, 'R');

                        $pdf->Cell(6, 4, $sortmed, 1, 0, 'C');

                        $pdf->Cell(8, 4, '', 1, 0, 'R');

                        $pdf->Cell(12, 4, '', 1, 1, 'R');
                    }
                    $read4 = null;
                }
            }
        }

        $read3 = null;

        $vtotalx = $vtotal * 100;
        $l = strlen($vtotalx) - 2;
        $vtotalx = substr($vtotalx, 0, $l) . "." . substr($vtotalx, $l, 2);

        $pdf->Cell(272, 4, 'Total Geral:   ' . $vtotalx, 1, 1, 'R');

        $pdf->SetFont('Times', '', 10);

        $pdf->Cell(272, 12, '', 0, 1, 'L');

        $pdf->Cell(95, 4, 'Compras : ________________________', 0, 0, 'L');
        $pdf->Cell(178, 4, 'Vendedor : ________________________', 0, 1, 'R');

        $pdf->Cell(190, 4, 'Observações: ' . $notentobservacoes, 0, 1, 'L');
    }
}
$read2 = null;
$pdf->Output();


