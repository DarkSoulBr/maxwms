<?php

require_once("include/conexao.inc.php");
require_once("include/pedcompraimpressao.php");
require_once("include/config.php");
require('fpdfnew.php');

$pcnumero = trim($_GET["pcnumero"]);
$nota = trim($_GET["nota"]);
$serie = trim($_GET["serie"]);
$pcseq = 0;

class PDF extends FPDF {

//Page header
    function Header() {

        $pcnum = trim($_GET["pcnumero"]);
        $pcnot = trim($_GET["nota"]);
        $pcser = trim($_GET["serie"]);

        $pegar = "SELECT deposito from notaent 
  Where pcnumero = '$pcnum'
  and notentnumero = '$pcnot'
  and notentserie = '$pcser'
  order by notentseqbaixa desc limit 1";
        $sql = pg_query($pegar);
        $row = pg_num_rows($sql);
        $codest = 26;
        if ($row) {
            $codest = pg_fetch_result($sql, 0, "deposito");
        }
        $pegar = "SELECT a.etqnome 
  FROM  estoque a  
  Where a.etqcodigo = '$codest'";
        $sql = pg_query($pegar);
        $row = pg_num_rows($sql);
        $nomestoque = '';
        if ($row) {
            $nomestoque = pg_fetch_result($sql, 0, "etqnome");
        }

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


$pegarx = "SELECT notentseqbaixa,notentcodigo
  FROM  notaent
  Where pcnumero = '$pcnumero'
  and notentnumero = '$nota'
  and notentserie = '$serie'
  order by notentseqbaixa desc limit 1";

$sqlx = pg_query($pegarx);
$rowx = pg_num_rows($sqlx);

$vy = 0;

for ($vx = 0; $vx == 0; $vx++) {

    $vx = 0;

    if ($rowx) {
        $vx = 1;
        $pcseq = pg_fetch_result($sqlx, 0, "notentseqbaixa");

        $notentcodigo = pg_fetch_result($sqlx, 0, "notentcodigo");
    }

    $vy++;
    if ($vy == 10000) {
        $vx = 1;
    }
}

$pegar = "SELECT c.notentnumero,c.notentdata,
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
  c.notatualiza,
  b.forcodigo

  FROM  notaent c, pcompra a
  LEft Join fornecedor as b on a.forcodigo = b.forcodigo
  LEft Join forecom as d on b.forcodigo = d.forcodigo
  LEft Join cidades as e on d.cidcodigo = e.cidcodigo
  Where c.notentcodigo = '$notentcodigo'
  and a.pcnumero = c.pcnumero";

//   ,c.notentdata,
//  c.notentemissao,c.notentnumero,c.notentcpof,c.notentvalor,
//  c.notentprodutos,c.notenticm,c.notentbaseicm,c.notentvaloricm,
//  c.notentisentas,c.notentoutras,c.notentbaseipi,c.notentpercipi,
//  c.notentvaloripi
//EXECUTA A QUERY

$sql = pg_query($pegar);

$row = pg_num_rows($sql);

if ($row) {

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {

        $notentnumero = pg_fetch_result($sql, $i, "notentnumero");
        $notentdata = pg_fetch_result($sql, $i, "notentdata");
        $fornguerra = pg_fetch_result($sql, $i, "fornguerra");
        $forcodigo = pg_fetch_result($sql, $i, "forcodigo");
        $forrazao = pg_fetch_result($sql, $i, "forrazao");
        $fneendereco = pg_fetch_result($sql, $i, "fneendereco");
        $descricao = pg_fetch_result($sql, $i, "descricao");
        $uf = pg_fetch_result($sql, $i, "uf");
        $forcnpj = pg_fetch_result($sql, $i, "forcnpj");
        $forie = pg_fetch_result($sql, $i, "forie");
        $fnefone = pg_fetch_result($sql, $i, "fnefone");
        $comprador = pg_fetch_result($sql, $i, "comprador");
        $localentrega = pg_fetch_result($sql, $i, "localentrega");
        $condicao = pg_fetch_result($sql, $i, "condicao");
        $observacao1 = pg_fetch_result($sql, $i, "observacao1");
        $observacao2 = pg_fetch_result($sql, $i, "observacao2");
        $observacao3 = pg_fetch_result($sql, $i, "observacao3");
        $observacao4 = pg_fetch_result($sql, $i, "observacao4");
        $observacao5 = pg_fetch_result($sql, $i, "observacao5");
        $notentobservacoes = pg_fetch_result($sql, $i, "notentobservacoes");
        $comissao = pg_fetch_result($sql, $i, "comissao");
        $pcempresa = pg_fetch_result($sql, $i, "pcempresa");
        
        if ($comissao == 0) {
            $comissao = 100;
        }
        
        if($pcempresa==2) {            
            $localentrega = 6;
        }

        $notatualiza = pg_fetch_result($sql, $i, "notatualiza");

        if (trim($notatualiza) == "") {
            $notatualiza = "0";
        }

        if ($notatualiza == '1') {
            $notatual = 'Sim';
        } else {
            $notatual = 'Não';
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


//$pdf->Cell(190,4,'Codigo  Descricao                        Ref.For. Quant.  Custo Percentual de Desconto  C.Liquido IPI   Un   Valor   Valor Total',1,1,'L');


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

        $pegaricm = "SELECT icm
  FROM  condicaopagto
  Where forcodigo = " . $forcodigo;

        //EXECUTA A QUERY
        $sqlicm = pg_query($pegaricm);

        $rowicm = pg_num_rows($sqlicm);

        if ($rowicm) {
            $icmcad = pg_fetch_result($sqlicm, 0, "icm");
        } else {
            $icmcad = '0';
        }

        $pegar = "SELECT c.procodigo,c.procod,c.prnome,c.proref,a.neisaldo

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

        //EXECUTA A QUERY
        $sql = pg_query($pegar);

        $row = pg_num_rows($sql);

        if ($row) {
            $vtotal = 0;
            //PERCORRE ARRAY
            for ($i = 0; $i < $row; $i++) {

                $procodigo = pg_fetch_result($sql, $i, "procodigo");
                $procod = pg_fetch_result($sql, $i, "procod");
                $prnome = pg_fetch_result($sql, $i, "prnome");
                $proemb = pg_fetch_result($sql, $i, "proemb");
                //$prnome = substr($prnome,0,30);
                $proref = pg_fetch_result($sql, $i, "proref");
                $neisaldo = pg_fetch_result($sql, $i, "neisaldo");
                $clanumero = trim(pg_fetch_result($sql, $i, "clanumero"));

                //Valor será o que foi digitado na baixa
                //$pcipreco = pg_fetch_result($sql, $i, "pcipreco");	   
                $pcipreco = pg_fetch_result($sql, $i, "valornf");

                $desc1 = pg_fetch_result($sql, $i, "desc1");
                $desc2 = pg_fetch_result($sql, $i, "desc2");
                $desc3 = pg_fetch_result($sql, $i, "desc3");
                $desc4 = pg_fetch_result($sql, $i, "desc4");

                $proaltura = pg_fetch_result($sql, $i, "proaltura");
                if ($proaltura == '') {
                    $proaltura = 0;
                }
                $prolargura = pg_fetch_result($sql, $i, "prolargura");
                if ($prolargura == '') {
                    $prolargura = 0;
                }
                $procompr = pg_fetch_result($sql, $i, "procompr");
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

                $ipi = pg_fetch_result($sql, $i, "ipi");
                $icm = pg_fetch_result($sql, $i, "neipercicm");
                $medsigla = pg_fetch_result($sql, $i, "medsigla");
                $barunidade = pg_fetch_result($sql, $i, "barunidade");

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

                    $pegar3 = "SELECT a.procodigo,a.procod,a.prnome,a.proref,a.proemb,d.medsigla
                    ,a.proaltura as proaltcx
                    ,a.prolargura as prolarcx
                    ,a.procompr as procomcx
                    ,e.barcaixa
                    ,e.barunidade
                    ,f.clanumero 	
                    from produto a 
                    LEft Join medidas as d on a.medcodigo = d.medcodigo 
                    left join cbarras as e on a.procodigo = e.procodigo 
                    LEFT JOIN clfiscal as f on a.clacodigo = f.clacodigo
                    where a.promaster = $procodigo order by a.procod";
                    $cad3 = pg_query($pegar3);
                    $row3 = pg_num_rows($cad3);
                    if ($row3) {
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

                    //Se tiver Sortimentos 
                    for ($j3 = 0; $j3 < $row3; $j3++) {

                        //Depois - Repete o Master com a Quantidade da Baixa
                        if ($j3 == 0) {

                            //Localiza as Quantidades 
                            $quantidade = 0;
                            $pegar4 = "SELECT neisaldo FROM neitemsort Where notentcodigo = '$notentcodigo' and procodigo=$procodigo";
                            $cad4 = pg_query($pegar4);
                            $row4 = pg_num_rows($cad4);
                            if ($row4) {
                                $quantidade = pg_fetch_result($cad4, 0, "neisaldo");
                            }

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

                        $procodigox = trim(pg_fetch_result($cad3, $j3, "procodigo"));

                        $quantidade = 0;
                        $pegar4 = "SELECT neisaldo FROM neitemsort Where notentcodigo = '$notentcodigo' and procodigo=$procodigox";
                        $cad4 = pg_query($pegar4);
                        $row4 = pg_num_rows($cad4);
                        if ($row4) {
                            $quantidade = pg_fetch_result($cad4, 0, "neisaldo");
                        }

                        $sortcod = trim(pg_fetch_result($cad3, $j3, "procod"));
                        $sortnom = trim(pg_fetch_result($cad3, $j3, "prnome"));
                        $sortref = trim(pg_fetch_result($cad3, $j3, "proref"));
                        if ($sortref == '') {
                            $sortref = trim(pg_fetch_result($cad3, $j3, "prodesc2"));
                        }
                        $sortmed = pg_fetch_result($cad3, $j3, "medsigla");
                        $sortemb = trim(pg_fetch_result($cad3, $j3, "proemb"));

                        $sortclanumero = trim(pg_fetch_result($cad3, $j3, "clanumero"));
                        $sortproaltcx = pg_fetch_result($cad3, $j3, "proaltcx");
                        $sortprolarcx = pg_fetch_result($cad3, $j3, "prolarcx");
                        $sortprocomcx = pg_fetch_result($cad3, $j3, "procomcx");
                        $sortbarcaixa = pg_fetch_result($cad3, $j3, "barcaixa");
                        $sortbarunidade = pg_fetch_result($cad3, $j3, "barunidade");

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
                }
            }
        }



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

$pdf->Output();


