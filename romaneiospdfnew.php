<?php

require_once("include/config.php");
require_once("include/conexao.inc.php");
require_once("include/romaneios.php");
require('fpdfnew.php');

$romcodigo = trim($_GET["romcodigo"]);
$tracodigo = trim($_GET["transp"]);

$temrateio = 0;

//Pega a transportadora escolhida para este romaneio
$sql = "SELECT tranguerra FROM  transportador
              WHERE tracodigo = '$tracodigo'";
$consulta = pg_query($sql);
$row = pg_num_rows($consulta);
if ($row) {
    $transportadora = pg_fetch_result($consulta, 0, "tranguerra");
}

class PDF extends FPDF {

//Page header
    function Header() {

        $romaneio = trim($_GET["romnumero"]);
        $romcarro = trim($_GET["romveiculo"]);
        $romplaca = trim($_GET["romplaca"]);
        $romdata = trim($_GET["romdata"]);
        $romnome = trim($_GET["rommotorista"]);
        $romajudante = trim($_GET["romajudante"]);
        $romsaida = trim($_GET["romsaida"]);
        $romini = trim($_GET["rominicial"]);
        $romfim = trim($_GET["romfinal"]);
        $romtipo = trim($_GET["romtipo"]);
        $romvalor = trim($_GET["romvalor"]);
        $romperc = trim($_GET["rompercentual"]);
        $romlogo = trim($_GET["radioimp"]);
        $forcodigo = (isset($_GET["forn"])) ? $_GET["forn"] : 0;

        $dia = date('d');
        $mes = date('m');
        $ano = date('Y');

        /*
          $sql = "SELECT romaneios.nf, forn.fornguerra FROM romaneios
          LEFT JOIN fornecedor forn ON romaneios.forcodigo = forn.forcodigo
          WHERE romcodigo = '" . $_GET["romcodigo"] . "'";
          $consulta = pg_query($sql);
          $row = pg_num_rows($consulta);
          if ($row) {
          $nf = pg_fetch_result($consulta, 0, "nf");
          $fornguerra = pg_fetch_result($consulta, 0, "fornguerra");
          }
         */


        $this->SetFont('Arial', 'B', 7);
        $this->Cell(66, 19, '', 1, 0, 'C');
        $this->Cell(45, 19, '', 1, 0, 'C');
        $this->Cell(79, 19, '', 1, 0, 'C');
        $this->Cell(1, 2, '', 0, 1, 'C');
        //1a. Linha
        $this->Cell(66, 4, RAZAO_TOY, 0, 0);
        $this->SetFont('Arial', 'B', 13);
        $this->Cell(45, 4, 'R.O.C.E.: ' . $romaneio, 0, 0);
        $this->SetFont('Arial', 'B', 7);
        //$this->Cell(57, 4, 'VEÍCULO: ' . $romplaca . ' - ' . $romcarro, 0, 1);
        $this->Cell(57, 4, 'TRANSPORTADORA: ' . $romcarro, 0, 1);
        //2a. Linha
        $this->Cell(66, 4, 'AVENIDA PAPA JOAO PAULO I, 5627 GUARULHOS SP', 0, 0);
        $this->Cell(45, 4, 'DATA EMISSÃO: ' . $dia . '/' . $mes . '/' . $ano, 0, 0);
        $this->Cell(57, 4, 'MOTORISTA: ' . $romnome, 0, 1);
        //3a. Linha
        $this->Cell(66, 4, 'CNPJ ' . formata_cnpj(CNPJ_TOY) . ' INSC. EST. ' . INSCRICAO_TOY, 0, 0);
        $this->Cell(45, 4, 'DATA DE SAÍDA: ' . $romdata, 0, 0);
        $this->Cell(57, 4, 'AJUDANTE: ' . $romajudante, 0, 1);
        //4a. Linha
        $this->Cell(66, 4, 'FONE: 11 - 2088-7650', 0, 0);
        $this->Cell(45, 4, 'HORA: ' . $romsaida, 0, 0);
        //$this->Cell(57,4,'KM INICIAL: '.$romini.' KM FINAL: _________',0,1);
        $this->Cell(57, 4, 'PLACA: ' . $romini, 0, 1);
//	$this->Cell(30,3,'',0,1,'C');
        //5a. Linha
        /*
          $this->Cell(66, 4, '', 0, 0);
          $this->Cell(45, 4, '', 0, 0);
          $this->SetFont('Arial', 'B', 8.5);
          //$this->Cell(57, 4, 'FORNECEDOR: ' . $fornguerra, 0, 1);
          $this->Cell(57, 4, '', 0, 1);
          //	$this->Cell(30,3,'',0,1,'C');
         * *
         */
        //6a. Linha
        $this->Cell(30, 3, '', 0, 1, 'C');

        if ($romtipo == 1) {
            $frete = $romvalor;
        } else if ($romtipo == 2) {
            $frete = $romperc;
        } else {
            $frete = 0;
        }

        if ($frete > 0) {

            $this->SetFont('Arial', 'B', 5);
            $this->Cell(10, 7, 'PEDIDO', 1, 0, 'C');
            $this->Cell(10, 7, 'NOTA', 1, 0, 'C');
            $this->Cell(52, 7, 'CLIENTE', 1, 0, 'C');
            //$this->Cell(32, 7, 'TRANSPORTADORA', 1, 0, 'C');
            $this->Cell(10, 7, 'M³', 1, 0, 'C');
            $this->Cell(10, 7, 'VOL.', 1, 0, 'C');
            $this->Cell(10, 7, 'PESO', 1, 0, 'C');
            $this->Cell(16, 7, 'VALOR', 1, 0, 'C');
            $this->Cell(10, 7, 'FRETE', 1, 0, 'C');
            $this->Cell(62, 7, 'ASSINATURA DO RECEBEDOR', 1, 1, 'C');
        } else {

            $this->SetFont('Arial', 'B', 5);
            $this->Cell(10, 7, 'PEDIDO', 1, 0, 'C');
            $this->Cell(10, 7, 'NOTA', 1, 0, 'C');
            $this->Cell(52, 7, 'CLIENTE', 1, 0, 'C');
            //$this->Cell(32, 7, 'TRANSPORTADORA', 1, 0, 'C');
            $this->Cell(10, 7, 'M³', 1, 0, 'C');
            $this->Cell(10, 7, 'VOL.', 1, 0, 'C');
            $this->Cell(10, 7, 'PESO', 1, 0, 'C');
            $this->Cell(16, 7, 'VALOR', 1, 0, 'C');
            $this->Cell(72, 7, 'ASSINATURA DO RECEBEDOR', 1, 1, 'C');
        }


        //Line break
        $this->Ln(0);
        //$this->Ln(20);
    }

//Page footer
    function Footer() {
        $romobs = trim($_GET["romobs"]);
        $romemissor = trim($_GET["romemissor"]);

        //Position at 3.5 cm from bottom
        //$this->SetY(-30);
        $this->SetY(-23);
        $this->SetFont('Arial', 'B', 9);

        $this->Cell(190, 23, '', 1, 0);
        $this->Cell(1, 1, '', 0, 1);

        $caracteres = 0;
        $caracteres += strlen($romobs);

        $romobs1 = '';
        $romobs2 = '';
        $romobs3 = '';
        $romobs4 = '';

        $vai = '';

        $contador = 0;

        for ($i = 0; $i < $caracteres; $i++) {

            $contador ++;
            if ($contador > 76) {
                if (substr($romobs, $i, 1) == ' ' || substr($romobs, $i, 1) == '.' || substr($romobs, $i, 1) == ';' || $contador == 86) {
                    $vai = $vai . substr($romobs, $i, 1);
                    if ($romobs1 == '') {
                        $romobs1 = $vai;
                    } else if ($romobs2 == '') {
                        $romobs2 = $vai;
                    } else if ($romobs3 == '') {
                        $romobs3 = $vai;
                    } else if ($romobs4 == '') {
                        $romobs4 = $vai;
                    }
                    $vai = '';
                    $contador = 0;
                } else {
                    $vai = $vai . substr($romobs, $i, 1);
                }
            } else {
                $vai = $vai . substr($romobs, $i, 1);
            }
        }//FECHA FOR

        if ($romobs1 == '') {
            $romobs1 = $vai;
        } else if ($romobs2 == '') {
            $romobs2 = $vai;
        } else if ($romobs3 == '') {
            $romobs3 = $vai;
        } else if ($romobs4 == '') {
            $romobs4 = $vai;
        }

        $this->Cell(23, 5, 'Observações: ', 0, 0);
        $this->Cell(50, 5, $romobs1, 0, 1);
        $this->Cell(23, 5, '', 0, 0);
        $this->Cell(50, 5, $romobs2, 0, 1);
        $this->Cell(23, 5, '', 0, 0);
        $this->Cell(50, 5, $romobs3, 0, 1);
        $this->Cell(23, 5, '', 0, 0);

        if ($romemissor != '') {
            $this->Cell(50, 5, $romobs4, 0, 0);
            $this->SetFont('Arial', 'I', 4);
            $this->Cell(117, 5, 'Emitido por: ' . $romemissor, 0, 1, 'R');
        } else {
            $this->Cell(50, 5, $romobs4, 0, 1);
        }

        //Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        //Page number
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

}

//Instanciation of inherited class
$pdf = new PDF();
//$pdf->FPDF('L','mm','A4');

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 6);

$romtipo = trim($_GET["romtipo"]);
$romvalor = trim($_GET["romvalor"]);
$romperc = trim($_GET["rompercentual"]);

if ($romtipo == 1) {
    $vaifrete = $romvalor;
} else if ($romtipo == 2) {
    $vaifrete = $romperc;
} else {
    $vaifrete = 0;
}

if ($vaifrete > 0) {
    $temrateio = 1;
} else {
    $temrateio = 0;
}


$pegar = "Select a.pvnumero,c.clicod,c.clirazao,a.rpvolumes,b.pvvalor,b.pvtipoped,b.tracodigo,e.cleendereco,e.clenumero,(select d.tranguerra from transportador d Where d.tracodigo = b.tracodigo) as transp,(select d.traendereco from transportador d Where d.tracodigo = b.tracodigo) as traendereco
			FROM romaneiospedidos a, pvenda b
			left join clientes as c on b.clicodigo= c.clicodigo
			left join cliefat as e on b.clicodigo= e.clicodigo				
			WHERE a.pvnumero = b.pvnumero
			AND a.romcodigo = $romcodigo	
			order by a.pvnumero";

$cad = pg_query($pegar);

$row = pg_num_rows($cad);

$totval = 0;
$totvol = 0;
$totqtd = 0;
$totind = 0;
$totext = 0;
$totvin = 0;
$totdev = 0;
$totnor = 0;
$totpes = 0;

//Será necessario um Primeiro Looping para Calcular o total para poder fazer o Rateio
for ($i = 0; $i < $row; $i++) {

    $pvnumero = pg_fetch_result($cad, $i, "pvnumero");
    $pvtipo = pg_fetch_result($cad, $i, "pvtipoped");
    $clicod = pg_fetch_result($cad, $i, "clicod");
    $clirazao = pg_fetch_result($cad, $i, "clirazao");
    $pvvol = pg_fetch_result($cad, $i, "rpvolumes");
    $pvval = pg_fetch_result($cad, $i, "pvvalor");
    $pvtrc = pg_fetch_result($cad, $i, "tracodigo");
    $pvtrn = pg_fetch_result($cad, $i, "transp");
    $pvtre = pg_fetch_result($cad, $i, "traendereco");
    $cliend = pg_fetch_result($cad, $i, "cleendereco");


    $pegar2 = "Select a.notnumero as notnumero,a.quantidade as notvolumes,a.notvalor as notvalor,a.tracodigo as tracodigo  
					FROM notadep a 
					WHERE a.pvnumero = $pvnumero					
					UNION Select c.notnumero as notnumero,c.quantidade as notvolumes,c.notvalor as notvalor,c.tracodigo as tracodigo	
					FROM notagua c
					WHERE c.pvnumero = $pvnumero
					AND c.tipo is null 					
					order by notnumero";



    $cad2 = pg_query($pegar2);
    $row2 = pg_num_rows($cad2);

    $ntvalnot = 0;

    //Fica em Looping nas Notas
    for ($i2 = 0; $i2 < $row2; $i2++) {
        if ($i2 == 0) {
            $ntnumero = pg_fetch_result($cad2, $i2, "notnumero");
            //$ntvol     = pg_fetch_result($cad2, $i2, "notvolumes");
            //$nttrc     = pg_fetch_result($cad2, $i2, "tracodigo");
            //$nttrn     = pg_fetch_result($cad2, $i2, "tranguerra");
            //$nttre     = pg_fetch_result($cad2, $i2, "traendereco");
            //$totvol    = $totvol + $ntvol;
            $ntvol = $pvvol;
            $nttrc = $pvtrc;
            $nttrn = $pvtrn;
            $nttre = $pvtre;
            $totvol = $totvol + $pvvol;

            /*
              if ($pvtipo == 'S') {
              $clicod = pg_fetch_result($cad2, $i2, "clicod");
              $clirazao = pg_fetch_result($cad2, $i2, "clirazao");
              $cliend = pg_fetch_result($cad2, $i2, "cleendereco");
              $clinum = pg_fetch_result($cad2, $i2, "clenumero");
              if ($clinum == 0 || $clinum == '') {

              } else {
              $cliend = trim($cliend) . ' ' . $clinum;
              }
              $nttre = $cliend;
              $clirazao = trim($clirazao) . " ( " . trim($clicod) . " )";
              }
             * 
             */
        }

        $ntvalnot = $ntvalnot + pg_fetch_result($cad2, $i2, "notvalor");
        $ntval = pg_fetch_result($cad2, $i2, "notvalor");

        $totval = $totval + $ntval;
    }

    if ($i2 == 0) {
        $totval = $totval + $pvval;
    }
}


$totalrateio = $totval;

if ($romtipo == 1) {
    $totalfrete = $romvalor;
} else if ($romtipo == 2) {
    $totalfrete = $totval * $romperc / 100;
} else {
    $totalfrete = 0;
}

$cad = pg_query($pegar);

$row = pg_num_rows($cad);

$pdf->SetFont('Times', '', 6);

$totval = 0;
$totvol = 0;
$totqtd = 0;
$totind = 0;
$totext = 0;
$totvin = 0;
$totdev = 0;
$totnor = 0;
$totpes = 0;
$totcub = 0;

for ($i = 0; $i < $row; $i++) {

    $pvnumero = pg_fetch_result($cad, $i, "pvnumero");
    $pvtipo = pg_fetch_result($cad, $i, "pvtipoped");
    $clicod = pg_fetch_result($cad, $i, "clicod");
    $clirazao = pg_fetch_result($cad, $i, "clirazao");
    $pvvol = pg_fetch_result($cad, $i, "rpvolumes");
    $pvval = pg_fetch_result($cad, $i, "pvvalor");
    $pvtrc = pg_fetch_result($cad, $i, "tracodigo");
    $pvtrn = pg_fetch_result($cad, $i, "transp");
    $pvtre = pg_fetch_result($cad, $i, "traendereco");
    $cliend = pg_fetch_result($cad, $i, "cleendereco");


    //if ($pvtipo != 'S') {
    $pegar2 = "Select a.notnumero as notnumero,a.quantidade as notvolumes,a.notvalor as notvalor,a.tracodigo as tracodigo,a.cubagem   
					FROM notadep a 
					WHERE a.pvnumero = $pvnumero					
					UNION Select c.notnumero as notnumero,c.quantidade as notvolumes,c.notvalor as notvalor,c.tracodigo as tracodigo,c.cubagem 	
					FROM notagua c
					WHERE c.pvnumero = $pvnumero
					AND c.tipo is null 					
					order by notnumero";
    /*
      } else {
      $pegar2 = "Select c.notnumero as notnumero,c.quantidade as notvolumes,c.notvalor as notvalor,c.tracodigo as tracodigo,g.clicod,g.clirazao,e.cleendereco,e.clenumero
      FROM nguatransf y,notagua c
      left join clientes as g on c.clicodigo= g.clicodigo
      left join cliefat as e on c.clicodigo= e.clicodigo
      WHERE c.notnumero = y.notnumero
      and y.pvnumero = $pvnumero
      order by notnumero";
      }
     * 
     */

    $cad2 = pg_query($pegar2);
    $row2 = pg_num_rows($cad2);

    $ntvalnot = 0;

    $cubagem = 0;

    //Fica em Looping nas Notas
    for ($i2 = 0; $i2 < $row2; $i2++) {
        if ($i2 == 0) {
            $ntnumero = pg_fetch_result($cad2, $i2, "notnumero");
            //$ntvol     = pg_fetch_result($cad2, $i2, "notvolumes");
            //$nttrc     = pg_fetch_result($cad2, $i2, "tracodigo");
            //$nttrn     = pg_fetch_result($cad2, $i2, "tranguerra");
            //$nttre     = pg_fetch_result($cad2, $i2, "traendereco");
            //$totvol    = $totvol + $ntvol;
            $ntvol = $pvvol;
            $nttrc = $pvtrc;
            $nttrn = $pvtrn;
            $nttre = $pvtre;
            $totvol = $totvol + $pvvol;

            /*
              if ($pvtipo == 'S') {
              $clicod = pg_fetch_result($cad2, $i2, "clicod");
              $clirazao = pg_fetch_result($cad2, $i2, "clirazao");
              $cliend = pg_fetch_result($cad2, $i2, "cleendereco");
              $clinum = pg_fetch_result($cad2, $i2, "clenumero");
              if ($clinum == 0 || $clinum == '') {

              } else {
              $cliend = trim($cliend) . ' ' . $clinum;
              }
              $nttre = $cliend;
              $clirazao = trim($clirazao) . " ( " . trim($clicod) . " )";
              }
             * 
             */
        }

        $cubagem = $cubagem + pg_fetch_result($cad2, $i2, "cubagem");
        $totcub = $totcub + pg_fetch_result($cad2, $i2, "cubagem");

        $ntvalnot = $ntvalnot + pg_fetch_result($cad2, $i2, "notvalor");
        $ntval = pg_fetch_result($cad2, $i2, "notvalor");

        $totval = $totval + $ntval;

        if ($pvtipo == "I" || $pvtipo == "M") {
            $totind = $totind + $ntval;
        } else if ($pvtipo == "E") {
            $totext = $totext + $ntval;
        } else if ($pvtipo == "V") {
            $totvin = $totvin + $ntval;
        } else if ($pvtipo == "D" || $pvtipo == "C" || $pvtipo == "A") {
            $totdev = $totdev + $ntval;
        } else {
            $totnor = $totnor + $ntval;
        }
    }


    $totalpeso = 0;

    //Serão processados os itens para calcular o peso
    $pegarpes = "SELECT a.pviest01,a.pviest011,b.procod,b.prnome,b.proemb,b.proref,b.propescx FROM pvitem a,produto b
          Where a.pvnumero = '$pvnumero'
		  And a.procodigo=b.procodigo ";

    $cadpes = pg_query($pegarpes);

    $rowpes = pg_num_rows($cadpes);


    for ($ipes = 0; $ipes < $rowpes; $ipes++) {

        $campo1 = pg_fetch_result($cadpes, $ipes, "pviest01") + pg_fetch_result($cadpes, $ipes, "pviest011");
        $procod = pg_fetch_result($cadpes, $ipes, "procod");
        $prnome = pg_fetch_result($cadpes, $ipes, "prnome");
        $prref = pg_fetch_result($cadpes, $ipes, "proref");
        $premb = pg_fetch_result($cadpes, $ipes, "proemb");
        $prpes = pg_fetch_result($cadpes, $ipes, "propescx");

        if ($premb > 0) {
            $resto = $campo1 % $premb;
            $prret = ($campo1 - $resto) / $premb;

            if ($prret > 0) {

                $totalpeso = $totalpeso + ($prpes * $prret);
                $totpes = $totpes + ($prpes * $prret);
            }
        }
    }

    $pegarpes = "SELECT a.pviest01,a.pviest011,b.procod,b.prnome,b.proemb,b.proref,b.propeso FROM pvitem a,produto b
          Where a.pvnumero = '$pvnumero'
		  And a.procodigo=b.procodigo ";

    $cadpes = pg_query($pegarpes);

    $rowpes = pg_num_rows($cadpes);

    for ($ipes = 0; $ipes < $rowpes; $ipes++) {

        $campo1 = pg_fetch_result($cadpes, $ipes, "pviest01") + pg_fetch_result($cadpes, $ipes, "pviest011");
        $procod = pg_fetch_result($cadpes, $ipes, "procod");
        $prnome = pg_fetch_result($cadpes, $ipes, "prnome");
        $prref = pg_fetch_result($cadpes, $ipes, "proref");
        $premb = pg_fetch_result($cadpes, $ipes, "proemb");
        $prpes = pg_fetch_result($cadpes, $ipes, "propeso");

        if ($premb > 0) {
            $resto = $campo1 % $premb;
            $prret = ($campo1 - $resto) / $premb;
            $prret2 = $campo1 - ($prret * $premb);
        } else {
            $prret = 0;
            $prret2 = $campo1;
        }

        if ($prret2 > 0) {
            $totalpeso = $totalpeso + ($prpes * $prret2);
            $totpes = $totpes + ($prpes * $prret2);
        }
    }

    //Verifica se o Pedido tem o Campo Destinatario Preenchido
    $pegarDestinatario = "SELECT pvdest FROM pvenda Where pvnumero = '$pvnumero'";
    $cadDestinatario = pg_query($pegarDestinatario);
    $rowDestinatario = pg_num_rows($cadDestinatario);
    if ($rowDestinatario) {
        $destinatario = pg_fetch_result($cadDestinatario, 0, "pvdest");
        if ($destinatario != '') {
            $clirazao = $destinatario;
        }
    }

    $pdf->SetFont('Times', '', 6);

    if ($i2 == 0) {
        $pdf->SetFont('Times', '', 6);
        $pdf->Cell(10, 8, '' . $pvnumero . $pvtipo, 1, 0, 'R');
        $pdf->Cell(10, 8, '', 1, 0);
        $pdf->Cell(52, 8, '' . substr($clirazao, 0, 40), 1, 0);

        //$pdf->Cell(10, 8, '' . sprintf("%01.4f", Round($cubagem, 4)), 1, 0, 'R');
        $pdf->Cell(10, 8, '' . number_format($cubagem, 4, ",", "."), 1, 0, 'R');

        $pdf->Cell(10, 8, '' . $pvvol, 1, 0, 'R');
        //$pdf->Cell(10, 8, '' . sprintf("%01.3f", Round($totalpeso, 3)), 1, 0, 'R');
        $pdf->Cell(10, 8, '' . number_format($totalpeso, 3, ",", "."), 1, 0, 'R');
        //$pdf->Cell(16, 8, '' . sprintf("%01.2f", Round($pvval, 2)), 1, 0, 'R');
        $pdf->Cell(16, 8, '' . number_format($pvval, 2, ",", "."), 1, 0, 'R');

        if ($temrateio == 1) {
            //$pdf->Cell(10, 8, '' . sprintf("%01.2f", Round($pvval * $totalfrete / $totalrateio, 2)), 1, 0, 'R');
            $pdf->Cell(10, 8, '' . number_format(($pvval * $totalfrete / $totalrateio), 2, ",", "."), 1, 0, 'R');
            $pdf->Cell(62, 8, '', 1, 1);
        } else {
            $pdf->Cell(72, 8, '', 1, 1);
        }

        $totval = $totval + $pvval;
        $totvol = $totvol + $pvvol;
        $totqtd = $totqtd + 1;

        if ($pvtipo == "I" || $pvtipo == "M") {
            $totind = $totind + $pvval;
        } else if ($pvtipo == "E") {
            $totext = $totext + $pvval;
        } else if ($pvtipo == "V") {
            $totvin = $totvin + $pvval;
        } else if ($pvtipo == "D" || $pvtipo == "C" || $pvtipo == "A") {
            $totdev = $totdev + $pvval;
        } else {
            $totnor = $totnor + $pvval;
        }
    } else {
        $pdf->SetFont('Times', '', 6);
        $pdf->Cell(10, 8, '' . $pvnumero . $pvtipo, 1, 0, 'R');
        if ($i2 == 1) {
            $pdf->Cell(10, 8, '' . $ntnumero, 1, 0, 'R');
        } else {
            $pdf->Cell(10, 8, '' . $ntnumero . '/' . $i2, 1, 0, 'R');
        }

        $pdf->Cell(52, 8, '' . substr($clirazao, 0, 40), 1, 0);

        //$pdf->Cell(10, 8, '' . sprintf("%01.4f", Round($cubagem, 4)), 1, 0, 'R');
        $pdf->Cell(10, 8, '' . number_format($cubagem, 4, ",", "."), 1, 0, 'R');
        $pdf->Cell(10, 8, '' . $ntvol, 1, 0, 'R');
        //$pdf->Cell(10, 8, '' . sprintf("%01.3f", Round($totalpeso, 3)), 1, 0, 'R');
        $pdf->Cell(10, 8, '' . number_format($totalpeso, 3, ",", "."), 1, 0, 'R');
        //$pdf->Cell(16, 8, '' . sprintf("%01.2f", Round($ntvalnot, 2)), 1, 0, 'R');
        $pdf->Cell(16, 8, '' . number_format($ntvalnot, 2, ",", "."), 1, 0, 'R');
        if ($temrateio == 1) {
            //$pdf->Cell(10, 8, '' . sprintf("%01.2f", Round($ntvalnot * $totalfrete / $totalrateio, 2)), 1, 0, 'R');
            $pdf->Cell(10, 8, '' . number_format(($ntvalnot * $totalfrete / $totalrateio), 2, ",", "."), 1, 0, 'R');
            $pdf->SetFont('Times', '', 6);
            $pdf->Cell(62, 8, '', 1, 1);
        } else {
            $pdf->SetFont('Times', '', 6);
            $pdf->Cell(72, 8, '', 1, 1);
        }

        $totqtd = $totqtd + 1;
    }
    $transpm = trim($nttrn);
    //CELL COM ENDEREÇO DE ENTREGA
    /*
      if ($transpm != 'O MESMO') {
      $pdf->Cell(190, 4, 'END: ' . $nttre . '', 1, 2, 'L');
      } else {
      $pdf->Cell(190, 4, 'END: ' . $cliend . '', 1, 2, 'L');
      }

      $pdf->Cell(190, 4, '', 0, 2, 'L');
     */

    //$pdf->Cell(0,10,'Printing line number '.$i,0,1);
}

$pdf->SetFont('Times', '', 9);

$pdf->Cell(20, 8, '' . $totqtd, 1, 0, 'C');
$pdf->Cell(52, 8, 'TOTAL', 1, 0);

//$pdf->Cell(10, 8, 'M³', 1, 0, 'R');
//$pdf->Cell(10, 8, '' . sprintf("%01.4f", Round($totcub, 4)), 1, 0, 'R');
$pdf->Cell(10, 8, '' . number_format($totcub, 4, ",", "."), 1, 0, 'R');
$pdf->Cell(10, 8, '' . $totvol, 1, 0, 'R');
//$pdf->Cell(10, 8, '' . sprintf("%01.0f", Round($totpes, 0)), 1, 0, 'R');
$pdf->Cell(10, 8, '' . number_format($totpes, 0, ",", "."), 1, 0, 'R');
//$pdf->Cell(88, 8, 'R$ ' . sprintf("%01.2f", Round($totval, 2)), 1, 1, 'R');
$pdf->Cell(88, 8, 'R$ ' . number_format($totval, 2, ",", "."), 1, 1, 'R');

if ($romtipo == 1) {
    $frete = $romvalor;
} else if ($romtipo == 2) {
    $frete = $totval * $romperc / 100;
} else {
    $frete = 0;
}

if ($frete > 0) {

    $pdf->SetFont('Times', 'B', 6);
    $pdf->Cell(30, 3, '', 0, 1, 'C');
    $pdf->Cell(27, 8, 'D.A.I.', 1, 0, 'C');
    $pdf->Cell(27, 8, 'DIRETORIA', 1, 0, 'C');
    $pdf->Cell(27, 8, 'EXTERNO', 1, 0, 'C');
    $pdf->Cell(27, 8, 'MATRIZ', 1, 0, 'C');
    $pdf->Cell(27, 8, 'FILIAL', 1, 0, 'C');
    $pdf->Cell(28, 8, 'TOTAL', 1, 0, 'C');
    $pdf->Cell(27, 8, '% - MERC.', 1, 1, 'C');



    if ($totval == 0) {
        $pdf->Cell(27, 8, 'R$ ' . number_format(0, 2, ",", "."), 1, 0, 'C');
        $pdf->Cell(27, 8, 'R$ ' . number_format(0, 2, ",", "."), 1, 0, 'C');
        $pdf->Cell(27, 8, 'R$ ' . number_format(0, 2, ",", "."), 1, 0, 'C');
        $pdf->Cell(27, 8, 'R$ ' . number_format(0, 2, ",", "."), 1, 0, 'C');
        $pdf->Cell(27, 8, 'R$ ' . number_format(0, 2, ",", "."), 1, 0, 'C');
        $pdf->Cell(28, 8, 'R$ ' . number_format($frete, 2, ",", "."), 1, 0, 'C');
        $pdf->Cell(27, 8, number_format(0, 3, ",", ".") . ' %', 1, 1, 'C');
    } else {
        $pdf->Cell(27, 8, 'R$ ' . number_format($frete * ($totind * 100 / $totval) / 100, 2, ",", "."), 1, 0, 'C');
        $pdf->Cell(27, 8, 'R$ ' . number_format($frete * ($totdev * 100 / $totval) / 100, 2, ",", "."), 1, 0, 'C');
        $pdf->Cell(27, 8, 'R$ ' . number_format($frete * ($totext * 100 / $totval) / 100, 2, ",", "."), 1, 0, 'C');
        $pdf->Cell(27, 8, 'R$ ' . number_format($frete * ($totnor * 100 / $totval) / 100, 2, ",", "."), 1, 0, 'C');
        $pdf->Cell(27, 8, 'R$ ' . number_format($frete * ($totvin * 100 / $totval) / 100, 2, ",", "."), 1, 0, 'C');
        $pdf->Cell(28, 8, 'R$ ' . number_format($frete, 2, ",", "."), 1, 0, 'C');
        $pdf->Cell(27, 8, number_format($frete * 100 / $totval, 3, ",", ".") . ' %', 1, 1, 'C');
    }
}

$pdf->Cell(30, 3, '', 0, 1, 'C');


$pdf->Output();

function formata_cnpj($x) {
    $y = sprintf("%014s", $x); // só inclui esta linha
    $str = preg_replace("/([0-9]{2})([0-9]{3})([0-9]{3})([0-9]{4})([0-9]{2})/", "$1.$2.$3/$4-$5", $y);
    return $str;
}
?>

