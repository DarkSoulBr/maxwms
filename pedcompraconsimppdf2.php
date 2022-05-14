<?php
/**
* Geracao do PDF de Pedidos de Compra
*
* Gera o Arquivo PDF de Pedidos de Compra da Barao 
* Recebe como Parametro o numero do pedido e o tipo de Impressao
*
* @name Compra PDF
* @link pedcompraconsimppdf2.php
* @version 50.3.6
* @since 1.0.0
* @author Luis Ramires <delta.mais@uol.com.br>
* @copyright MaxTrade
* 
* @global integer $_GET["pcnumero"] Numero do Pedido a ser Impresso
* @global integer $_GET["tipo"] Tipo (1 Saldo, 2 Original)
*/

require_once("include/conexao.inc.php");
require_once("include/pedcompraimpressao.php");
require_once("include/config.php");
require('fpdfnew.php');

$pcnumero = trim($_GET["pcnumero"]);
$tipo = trim($_GET["tipo"]);

class PDF extends FPDF {

    function Header() {

        $pcnum = trim($_GET["pcnumero"]);

        $pegar = "SELECT a.localentrega,a.pcempresa    
                    FROM  pcompra a  
                    Where a.pcnumero = '$pcnum'";
        $sql = pg_query($pegar);
        $row = pg_num_rows($sql);
        $localentrega = 3;
        $pcempresa = 1;
        if ($row) {
            $localentrega = pg_fetch_result($sql, 0, "localentrega");
            $pcempresa = pg_fetch_result($sql, 0, "pcempresa");
        }

        if ($pcempresa == 2) {
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

        $this->Cell(60, 4, $data . ' ' . $hora, 0, 0, 'C');

        $this->Cell(0, 4, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 1, 'R');

        $this->Ln(0);

    }


    function Footer() {

        $this->SetY(-15);

        $this->SetFont('Arial', 'I', 8);


    }

}


$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 10);


$pegar = "SELECT a.pcemissao,
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

$sql = pg_query($pegar);

$row = pg_num_rows($sql);

if ($row) {

    for ($i = 0; $i < $row; $i++) {

        $notentdata = pg_fetch_result($sql, $i, "pcemissao");
        $fornguerra = pg_fetch_result($sql, $i, "fornguerra");
        $forrazao = pg_fetch_result($sql, $i, "forrazao");
        $fneendereco = pg_fetch_result($sql, $i, "fneendereco");
        $descricao = pg_fetch_result($sql, $i, "descricao");
        $uf = pg_fetch_result($sql, $i, "uf");
        $forcnpj = pg_fetch_result($sql, $i, "forcnpj");
        $forie = pg_fetch_result($sql, $i, "forie");
        $fnefone = pg_fetch_result($sql, $i, "fnefone");
        $comprador = pg_fetch_result($sql, $i, "comprador");
        $condicao = pg_fetch_result($sql, $i, "condicao");
        $observacao1 = pg_fetch_result($sql, $i, "observacao1");
        $observacao2 = pg_fetch_result($sql, $i, "observacao2");
        $observacao3 = pg_fetch_result($sql, $i, "observacao3");
        $observacao4 = pg_fetch_result($sql, $i, "observacao4");
        $observacao5 = pg_fetch_result($sql, $i, "observacao5");
        $localentrega = pg_fetch_result($sql, $i, "localentrega");
        $pcempresa = pg_fetch_result($sql, $i, "pcempresa");

        if ($pcempresa == 2) {
            $localentrega = 6;
        }

        $comissao = pg_fetch_result($sql, $i, "comissao");
        if ($comissao == 0) {
            $comissao = 100;
        }

        $tipoped = pg_fetch_result($sql, $i, "tipoped");

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
            $pdf->Cell(95, 4, 'CNPJ:49.329.873/0005-65', 0, 1, 'L');
            $pdf->Cell(95, 4, 'IE 796.298.971.112', 0, 0, 'L');
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
            $pdf->Cell(95, 4, 'CNPJ:49.329.873/0005-65', 0, 0, 'L');
            $pdf->Cell(95, 4, 'CNPJ:49.329.873/0003-01', 0, 1, 'L');
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
            $pdf->Cell(95, 4, 'CNPJ:49.329.873/0001-31', 0, 0, 'L');
            $pdf->Cell(95, 4, 'CNPJ:49.329.873/0001-31', 0, 1, 'L');
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
            $pdf->Cell(95, 4, 'CNPJ:49.329.873/0005-65', 0, 0, 'L');
            $pdf->Cell(95, 4, 'CNPJ:49.329.873/0004-84', 0, 1, 'L');
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
            $pdf->Cell(95, 4, 'CNPJ:49.329.873/0005-65', 0, 1, 'L');
            $pdf->Cell(95, 4, 'IE 336.521.740.111', 0, 0, 'L');
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
            $pdf->Cell(9, 4, 'Custo', 1, 0, 'R');
            $pdf->Cell(36, 4, 'Percentual de Desconto', 1, 0, 'C');
            $pdf->Cell(9, 4, 'C.Liqu.', 1, 0, '');
            $pdf->Cell(7, 4, 'IPI', 1, 0, 'C');
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
            $pdf->Cell(9, 4, 'Custo', 1, 0, 'R');
            $pdf->Cell(32, 4, 'Percentual de Desconto', 1, 0, 'C');
            $pdf->Cell(9, 4, 'C.Liqu.', 1, 0, '');
            $pdf->Cell(7, 4, 'IPI', 1, 0, 'C');
            $pdf->Cell(6, 4, 'UN', 1, 0, 'C');
            $pdf->Cell(10, 4, 'Valor', 1, 0, 'R');
            $pdf->Cell(14, 4, 'Valor Total', 1, 1, 'R');
        }

        $pegar = "SELECT c.procodigo,c.procod,c.prnome,c.proref,b.pcisaldo
  ,b.pcipreco
  ,b.desc1
  ,b.desc2
  ,b.desc3
  ,b.desc4
  ,b.ipi
  ,d.medsigla
  ,b.pcibaixa
  ,c.proemb
  ,c.profinal

  FROM  pcitem b,produto c
  LEft Join medidas as d on d.medcodigo = c.medcodigo
  Where b.pcnumero = '$pcnumero'
  and b.procodigo = c.procodigo
  order by c.proref";

        $sql = pg_query($pegar);

        $row = pg_num_rows($sql);

        if ($row) {
            $vtotal = 0;

            for ($i = 0; $i < $row; $i++) {

                $procod = pg_fetch_result($sql, $i, "procod");
                $procodigo = pg_fetch_result($sql, $i, "procodigo");
                $prnome = pg_fetch_result($sql, $i, "prnome");
                $prnome = substr($prnome, 0, 30);
                $proref = pg_fetch_result($sql, $i, "proref");
                $profinal = pg_fetch_result($sql, $i, "profinal");
                $pcisaldo = pg_fetch_result($sql, $i, "pcisaldo");
                $pcibaixa = pg_fetch_result($sql, $i, "pcibaixa");
                if ($pcibaixa == '') {
                    $pcibaixa = 0;
                }
                if ($tipo == 1) {
                    $pcisaldo = $pcisaldo - $pcibaixa;
                }

                if ($pcisaldo > 0) {

                    $pcipreco = pg_fetch_result($sql, $i, "pcipreco");
                    $proemb = pg_fetch_result($sql, $i, "proemb");
                    $desc1 = pg_fetch_result($sql, $i, "desc1");
                    $desc2 = pg_fetch_result($sql, $i, "desc2");
                    $desc3 = pg_fetch_result($sql, $i, "desc3");
                    $desc4 = pg_fetch_result($sql, $i, "desc4");
                    $ipi = pg_fetch_result($sql, $i, "ipi");
                    $medsigla = pg_fetch_result($sql, $i, "medsigla");

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
                        $pdf->Cell(9, 4, $pciprecox, 1, 0, 'R');
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

                        if ($liq > $profinal) {
                            $difer = $liq - $profinal;
                        } else if ($liq < $profinal) {
                            $difer = $profinal - $liq;
                        } else {
                            $difer = 0;
                        }
                        if ($difer > 0.03) {
                            $ast = "*";
                        } else {
                            $ast = " ";
                        }

                        $liqx = $liq * 100;
                        $l = strlen($liqx) - 2;
                        $liqx = substr($liqx, 0, $l) . "." . substr($liqx, $l, 2);

                        $pdf->Cell(9, 4, $liqx . $ast, 1, 0, 'R');
                        $pdf->Cell(7, 4, $ipi, 1, 0, 'R');

                        $pdf->Cell(7, 4, $medsigla, 1, 0, 'C');

                        if ($ipi != 0) {
                            $vipi = ($liqaux * $comissao / 100) / 100 * $ipi;
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


                        $temsortimento = '';

                        $pegar3 = "SELECT a.procodigo,a.procod,a.prnome,a.proref,a.proemb,d.medsigla from produto a 
			LEft Join medidas as d on a.medcodigo = d.medcodigo
                        where a.promaster = {$procodigo} order by a.procod";
                        $cad3 = pg_query($pegar3);
                        $row3 = pg_num_rows($cad3);
                        if ($row3) {
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
                        $pdf->Cell(9, 4, $pciprecox, 1, 0, 'R');
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

                        if ($liq > $profinal) {
                            $difer = $liq - $profinal;
                        } else if ($liq < $profinal) {
                            $difer = $profinal - $liq;
                        } else {
                            $difer = 0;
                        }
                        if ($difer > 0.03) {
                            $ast = "*";
                        } else {
                            $ast = " ";
                        }

                        $liqx = $liq * 100;
                        $l = strlen($liqx) - 2;
                        $liqx = substr($liqx, 0, $l) . "." . substr($liqx, $l, 2);

                        $pdf->Cell(9, 4, $liqx . $ast, 1, 0, 'R');
                        $pdf->Cell(7, 4, $ipi, 1, 0, 'R');

                        $pdf->Cell(6, 4, $medsigla, 1, 0, 'C');

                        if ($ipi != 0) {
                            $vipi = ($liqaux * $comissao / 100) / 100 * $ipi;
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

                        for ($j3 = 0; $j3 < $row3; $j3++) {
                            $sortcod = trim(pg_fetch_result($cad3, $j3, "procod"));
                            $sortnom = trim(pg_fetch_result($cad3, $j3, "prnome"));
                            $sortnom = substr($sortnom, 0, 36);
                            $sortref = trim(pg_fetch_result($cad3, $j3, "proref"));

                            $sortmed = pg_fetch_result($cad3, $j3, "medsigla");
                            $sortemb = trim(pg_fetch_result($cad3, $j3, "proemb"));
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
                            $pdf->Cell(9, 4, '', 1, 0, 'R');
                            $pdf->Cell(8, 4, '', 1, 0, 'R');
                            $pdf->Cell(8, 4, '', 1, 0, 'R');
                            $pdf->Cell(8, 4, '', 1, 0, 'R');
                            $pdf->Cell(8, 4, '', 1, 0, 'R');
                            $pdf->Cell(9, 4, '', 1, 0, 'R');
                            $pdf->Cell(7, 4, '', 1, 0, 'R');
                            $pdf->Cell(6, 4, $sortmed, 1, 0, 'C');
                            $pdf->Cell(10, 4, '', 1, 0, 'R');
                            $pdf->Cell(14, 4, '', 1, 1, 'R');
                        }
                    }
                }
            }
        }



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

$pdf->Output();

