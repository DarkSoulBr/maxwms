<?php

require_once("include/conexao.inc.php");
require_once("include/pedcompracons.php");

//RECEBE PARÃMETRO

$parametro = trim($_POST["parametro"]);
$parametro2 = trim($_POST["parametro2"]);


$dia = date('d');
$mes = date('m');
$ano = date('Y');

$emissao = $dia . '/' . $mes . '/' . $ano;

$dtemissao = $ano . '-' . $mes . '-' . $dia;

$data = substr($emissao, 6, 4) . '/' . substr($emissao, 3, 2) . '/' . substr($emissao, 0, 2);

$tabela = 'movestoque' . substr($data, 5, 2) . substr($data, 2, 2);



$cadastro = new banco($conn, $db);


$sql = "SELECT
  b.forrazao as fornguerra,a.comprador,a.condicao,c.notentdata,
  c.notentemissao,c.notentnumero,c.notentcpof,c.notentvalor,
  c.notentprodutos,c.notenticm,c.notentbaseicm,c.notentvaloricm,
  c.notentisentas,c.notentoutras,c.notentbaseipi,c.notentpercipi,
  c.notentvaloripi,c.notentobservacoes,c.notatualiza,c.notentcodigo,c.notentserie,c.deposito
  FROM  notaent c, pcompra a
  LEft Join fornecedor as b on a.forcodigo = b.forcodigo
  Where c.pcnumero = '$parametro'
  and a.pcnumero = c.pcnumero
  and c.notentseqbaixa = '$parametro2'";


//EXECUTA A QUERY
$sql = pg_query($sql);

$row = pg_num_rows($sql);

if ($row) {

    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {

        $fornguerra = pg_fetch_result($sql, $i, "fornguerra");
        $comprador = pg_fetch_result($sql, $i, "comprador");
        $notentdata = pg_fetch_result($sql, $i, "notentdata");
        $notentemissao = pg_fetch_result($sql, $i, "notentemissao");
        $notentnumero = pg_fetch_result($sql, $i, "notentnumero");
        $notentcpof = pg_fetch_result($sql, $i, "notentcpof");
        $notentvalor = pg_fetch_result($sql, $i, "notentvalor");
        $notentprodutos = pg_fetch_result($sql, $i, "notentprodutos");
        $notenticm = pg_fetch_result($sql, $i, "notenticm");
        $notentbaseicm = pg_fetch_result($sql, $i, "notentbaseicm");
        $notentvaloricm = pg_fetch_result($sql, $i, "notentvaloricm");
        $notentisentas = pg_fetch_result($sql, $i, "notentisentas");
        $notentoutras = pg_fetch_result($sql, $i, "notentoutras");
        $notentbaseipi = pg_fetch_result($sql, $i, "notentbaseipi");
        $notentpercipi = pg_fetch_result($sql, $i, "notentpercipi");
        $notentvaloripi = pg_fetch_result($sql, $i, "notentvaloripi");
        $notentobservacoes = pg_fetch_result($sql, $i, "notentobservacoes");
        $notatualiza = pg_fetch_result($sql, $i, "notatualiza");

        $notentcodigo = pg_fetch_result($sql, $i, "notentcodigo");
        $notentserie = pg_fetch_result($sql, $i, "notentserie");
        $deposito = pg_fetch_result($sql, $i, "deposito");

        if (trim($fornguerra) == "") {
            $fornguerra = "0";
        }
        if (trim($comprador) == "") {
            $comprador = "0";
        }

        if ($notentdata <> "") {
            $notentdata = substr($notentdata, 8, 2) . '/' . substr($notentdata, 5, 2) . '/' . substr($notentdata, 0, 4);
        }
        if ($notentemissao <> "") {
            $notentemissao = substr($notentemissao, 8, 2) . '/' . substr($notentemissao, 5, 2) . '/' . substr($notentemissao, 0, 4);
        }

        if (trim($notentnumero) == "") {
            $notentnumero = "0";
        }
        if (trim($notentcpof) == "") {
            $notentcpof = "0";
        }
        if (trim($notentvalor) == "") {
            $notentvalor = "0";
        }
        if (trim($notentprodutos) == "") {
            $notentprodutos = "0";
        }
        if (trim($notenticm) == "") {
            $notenticm = "0";
        }
        if (trim($notentbaseicm) == "") {
            $notentbaseicm = "0";
        }
        if (trim($notentvaloricm) == "") {
            $notentvaloricm = "0";
        }
        if (trim($notentisentas) == "") {
            $notentisentas = "0";
        }
        if (trim($notentoutras) == "") {
            $notentoutras = "0";
        }
        if (trim($notentbaseipi) == "") {
            $notentbaseipi = "0";
        }
        if (trim($notentpercipi) == "") {
            $notentpercipi = "0";
        }
        if (trim($notentvaloripi) == "") {
            $notentvaloripi = "0";
        }
        if (trim($notentobservacoes) == "") {
            $notentobservacoes = "0";
        }
        if (trim($notatualiza) == "") {
            $notatualiza = "0";
        }

        if (trim($notentcodigo) == "") {
            $notentcodigo = "0";
        }
        if (trim($notentserie) == "") {
            $notentserie = "0";
        }
        if (trim($deposito) == "") {
            $deposito = "26";
        }


        $sqlitem = "SELECT a.neisaldo as estoque,a.procodigo,b.procod 
                FROM neitem a,produto b                
                Where a.notentcodigo = $notentcodigo
				and a.procodigo = b.procodigo
                order by a.neicodigo";


        //EXECUTA A QUERY
        $sqlitem = pg_query($sqlitem);

        $rowitem = pg_num_rows($sqlitem);

        $temsaldo = '0';

        if ($rowitem) {

            for ($iitem = 0; $iitem < $rowitem; $iitem++) {

                $xsaldo = pg_fetch_result($sqlitem, $iitem, "estoque");
                $xprodu = pg_fetch_result($sqlitem, $iitem, "procodigo");
                $xcodpr = pg_fetch_result($sqlitem, $iitem, "procod");

                //Processa a movimentacao				
                //31/08/2011 - Inicio					
                $sqlest = "select a.movqtd,a.movtipo,a.movdata as ordem
								FROM $tabela a			
								Where a.procodigo = '$xprodu'
								and a.codestoque = '$deposito'
								order by ordem,movcodigo";

                $sqlest = pg_query($sqlest);
                $rowest = pg_num_rows($sqlest);

                $saldoest = 0;

                //VERIFICA SE VOLTOU ALGO
                if ($rowest) {

                    //PERCORRE ARRAY
                    for ($iest = 0; $iest < $rowest; $iest++) {

                        $movqtd = pg_fetch_result($sqlest, $iest, "movqtd");
                        $movtipo = pg_fetch_result($sqlest, $iest, "movtipo");

                        if (trim($movqtd) == "") {
                            $movqtd = "0";
                        }
                        if (trim($movtipo) == "") {
                            $movtipo = "0";
                        }

                        if ($movtipo == 1) {
                            $saldoest = $movqtd;
                        } else if ($movtipo == 2) {
                            $saldoest = $saldoest - $movqtd;
                        } else if ($movtipo == 3) {
                            $saldoest = $saldoest + $movqtd;
                        } else if ($movtipo == 4) {
                            $saldoest = $saldoest - $movqtd;
                        }
                    }
                }

                if ($xsaldo > $saldoest) {
                    $temsaldo = 'Estoque ' . $deposito . ' Comprometido, ' . $xcodpr . ' Quantidade : ' . $xsaldo . ' Saldo : ' . $saldoest;
                    $iest = $rowest; //Sai do For Next
                }
            }
        }



        $xml .= "<dado>\n";

        $xml .= "<fornguerra>" . $fornguerra . "</fornguerra>\n";
        $xml .= "<comprador>" . $comprador . "</comprador>\n";
        $xml .= "<notentdata>" . $notentdata . "</notentdata>\n";
        $xml .= "<notentemissao>" . $notentemissao . "</notentemissao>\n";
        $xml .= "<notentnumero>" . $notentnumero . "</notentnumero>\n";
        $xml .= "<notentcpof>" . $notentcpof . "</notentcpof>\n";
        $xml .= "<notentvalor>" . $notentvalor . "</notentvalor>\n";
        $xml .= "<notentprodutos>" . $notentprodutos . "</notentprodutos>\n";
        $xml .= "<notenticm>" . $notenticm . "</notenticm>\n";
        $xml .= "<notentbaseicm>" . $notentbaseicm . "</notentbaseicm>\n";
        $xml .= "<notentvaloricm>" . $notentvaloricm . "</notentvaloricm>\n";
        $xml .= "<notentisentas>" . $notentisentas . "</notentisentas>\n";
        $xml .= "<notentoutras>" . $notentoutras . "</notentoutras>\n";
        $xml .= "<notentbaseipi>" . $notentbaseipi . "</notentbaseipi>\n";
        $xml .= "<notentpercipi>" . $notentpercipi . "</notentpercipi>\n";
        $xml .= "<notentvaloripi>" . $notentvaloripi . "</notentvaloripi>\n";
        $xml .= "<notentobservacoes>" . $notentobservacoes . "</notentobservacoes>\n";
        $xml .= "<notatualiza>" . $notatualiza . "</notatualiza>\n";
        $xml .= "<notentcodigo>" . $notentcodigo . "</notentcodigo>\n";
        $xml .= "<notentserie>" . $notentserie . "</notentserie>\n";
        $xml .= "<temsaldo>" . $temsaldo . "</temsaldo>\n";

        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO

    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>
