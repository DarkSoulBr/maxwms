<?php

require_once("include/conexao.inc.php");

require_once "include/classes/php_writeexcel/class.writeexcel_workbook.inc.php";
require_once "include/classes/php_writeexcel/class.writeexcel_workbookbig.inc.php";
require_once "include/classes/php_writeexcel/class.writeexcel_worksheet.inc.php";

set_time_limit(0);
ini_set('memory_limit', '-1');

$usuario = $_GET['usuario'];
$romcodigo = $_GET['romcodigo'];

$uploaddir = 'arquivos/' . $usuario . '/';
$destino = $uploaddir;
if (!is_dir($destino)) {
    mkdir($destino, 0755);
}

$arquivo = $destino . 'pedidos_romaneio.xls';

if (file_exists($arquivo)) {
    unlink($arquivo);
}

$fname = tempnam($destino, "");
$workbook = new writeexcel_workbookbig($fname);


# Some common formats
$center = & $workbook->addformat(array('align' => 'center', 'font' => 'Calibri'));
$right = & $workbook->addformat(array('align' => 'right', 'font' => 'Calibri'));
$left = & $workbook->addformat(array('align' => 'left', 'font' => 'Calibri'));
$heading = & $workbook->addformat(array('align' => 'center', 'bold' => 1, 'font' => 'Calibri'));

$num1_format = & $workbook->addformat(array('num_format' => '#,##0.00', 'font' => 'Calibri'));
$num2_format = & $workbook->addformat(array('num_format' => '#,##0', 'font' => 'Calibri'));
$num3_format = & $workbook->addformat(array('num_format' => '#,##0.000', 'font' => 'Calibri'));
$num4_format = & $workbook->addformat(array('num_format' => '#,##0.0000', 'font' => 'Calibri'));

$tot1_format = & $workbook->addformat(array('num_format' => '#,##0.00',
            'fg_color' => 44,
            'pattern' => 1,
            'border' => 1,
            'font' => 'Calibri'));
$tot2_format = & $workbook->addformat(array('num_format' => '#,##0',
            'fg_color' => 44,
            'pattern' => 1,
            'border' => 1,
            'font' => 'Calibri'));

$tot3_format = & $workbook->addformat(array('num_format' => '#,##0.000',
            'fg_color' => 44,
            'pattern' => 1,
            'border' => 1,
            'font' => 'Calibri'));

$tot4_format = & $workbook->addformat(array('num_format' => '#,##0.0000',
            'fg_color' => 44,
            'pattern' => 1,
            'border' => 1,
            'font' => 'Calibri'));


$border1 = & $workbook->addformat(array(
            'fg_color' => 44,
            'pattern' => 1,
            'border' => 1,
            'font' => 'Calibri'
        ));
$border1->set_merge(); # This is the key feature									 

$border = & $workbook->addformat(array(
            'fg_color' => 44,
            'pattern' => 1,
            'border' => 1,
            'font' => 'Calibri'
        ));


$sqlx = "SELECT a.romnumero,a.romano FROM romaneios a where a.romcodigo = {$romcodigo}";

$cadx = pg_query($sqlx);

$rowx = pg_num_rows($cadx);

if ($rowx > 0) {
    $romnumero = trim(pg_fetch_result($cadx, 0, "romnumero"));
    $romano = trim(pg_fetch_result($cadx, 0, "romano"));
    $planilha = $romnumero . "-" . $romano;
} else {
    $planilha = "PEDIDOS";
}
								 
$worksheet1 = & $workbook->addworksheet($planilha);

$worksheet1->set_column(0, 0, 12);
$worksheet1->set_column(1, 1, 12);
$worksheet1->set_column(2, 2, 12);
$worksheet1->set_column(3, 3, 12);
$worksheet1->set_column(4, 4, 50);
$worksheet1->set_column(5, 5, 12);
$worksheet1->set_column(6, 6, 12);
$worksheet1->set_column(7, 7, 12);
$worksheet1->set_column(8, 8, 12);

$worksheet1->write(0, 0, "Pedido", $border1);
$worksheet1->write(0, 1, "Tipo", $border1);
$worksheet1->write(0, 2, "Nota", $border1);
$worksheet1->write(0, 3, "Codigo", $border1);
$worksheet1->write(0, 4, "Cliente", $border1);
$worksheet1->write(0, 5, "M³", $border1);
$worksheet1->write(0, 6, "Volumes", $border1);
$worksheet1->write(0, 7, "Peso", $border1);
$worksheet1->write(0, 8, "Valor", $border1);

$worksheet1->freeze_panes(1, 0); # 2 row

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
$totcub = 0;

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
            
            $ntvol = $pvvol;
            $nttrc = $pvtrc;
            $nttrn = $pvtrn;
            $nttre = $pvtre;
            $totvol = $totvol + $pvvol;

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

    $pegar2 = "Select a.notnumero as notnumero,a.quantidade as notvolumes,a.notvalor as notvalor,a.tracodigo as tracodigo,a.cubagem     
					FROM notadep a 
					WHERE a.pvnumero = $pvnumero					
					UNION Select c.notnumero as notnumero,c.quantidade as notvolumes,c.notvalor as notvalor,c.tracodigo as tracodigo,c.cubagem 	
					FROM notagua c
					WHERE c.pvnumero = $pvnumero
					AND c.tipo is null 					
					order by notnumero";


    $cad2 = pg_query($pegar2);
    $row2 = pg_num_rows($cad2);

    $ntvalnot = 0;

    $cubagem = 0;

    //Fica em Looping nas Notas
    for ($i2 = 0; $i2 < $row2; $i2++) {
        if ($i2 == 0) {
            $ntnumero = pg_fetch_result($cad2, $i2, "notnumero");
            
            $ntvol = $pvvol;
            $nttrc = $pvtrc;
            $nttrn = $pvtrn;
            $nttre = $pvtre;
            $totvol = $totvol + $pvvol;

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
                $clirazao = trim($clirazao);
            }
        }

        $ntvalnot = $ntvalnot + pg_fetch_result($cad2, $i2, "notvalor");
        $ntval = pg_fetch_result($cad2, $i2, "notvalor");

        $cubagem = $cubagem + pg_fetch_result($cad2, $i2, "cubagem");
        $totcub = $totcub + pg_fetch_result($cad2, $i2, "cubagem");

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

    if ($i2 == 0) {
        
        
        $ultima++;
        $worksheet1->write($ultima, 0, $pvnumero, $right);
        $worksheet1->write($ultima, 1, $pvtipo, $center);
        $worksheet1->write($ultima, 2, '', $center);
        $worksheet1->write($ultima, 3, $clicod, $right);
        $worksheet1->write($ultima, 4, $clirazao, $left);
        $worksheet1->write($ultima, 5, $cubagem, $num4_format);        
        $worksheet1->write($ultima, 6, $pvvol, $num2_format);
        $worksheet1->write($ultima, 7, $totalpeso, $num3_format);
        $worksheet1->write($ultima, 8, $pvval, $num1_format);        

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
        
        $ultima++;
        $worksheet1->write($ultima, 0, $pvnumero, $right);
        $worksheet1->write($ultima, 1, $pvtipo, $center);
        if ($i2 == 1) {
            $worksheet1->write($ultima, 2, $ntnumero, $right);
        } else {
            $worksheet1->write($ultima, 2, $ntnumero . '/' . $i2, $right);
        }
        $worksheet1->write($ultima, 3, $clicod, $right);
        $worksheet1->write($ultima, 4, $clirazao, $left);
        $worksheet1->write($ultima, 5, $cubagem, $num4_format);        
        $worksheet1->write($ultima, 6, $ntvol, $num2_format);
        $worksheet1->write($ultima, 7, $totalpeso, $num3_format);
        $worksheet1->write($ultima, 8, $ntvalnot, $num1_format);       
        $totqtd = $totqtd + 1;
    }
    $transpm = trim($nttrn);
   
}

$ultima++;
$worksheet1->write($ultima, 0, '', $border);
$worksheet1->write($ultima, 1, '', $border);
$worksheet1->write($ultima, 2, $totqtd, $tot2_format);
$worksheet1->write($ultima, 3, '', $border);
$worksheet1->write($ultima, 4, 'TOTAL', $border);
$worksheet1->write($ultima, 5, $totcub, $tot4_format);        
$worksheet1->write($ultima, 6, $totvol, $tot2_format);
$worksheet1->write($ultima, 7, $totpes, $tot3_format);
$worksheet1->write($ultima, 8, $totval, $tot1_format);       


$workbook->close();

rename($fname, $arquivo);

echo 'Arquivo gerado com Sucesso!';
echo '<br>';
echo '<br>';

echo "<meta HTTP-EQUIV='Refresh' CONTENT='1;URL=downloadpedidosromaneio.php?usuario=$usuario'>";

pg_close($conn);
exit();

