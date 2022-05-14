<?php

require_once("include/conexao.inc.php");
require_once("include/consultamovimentacao2.php");

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



$dtiniciox = trim($_GET["dtinicio"]);
$dtfinalx = trim($_GET["dtfinal"]);

$codigoprodutox = trim($_GET["codigoproduto"]);
$produtox = trim($_GET["produto"]);

$deposito = trim($_GET["deposito"]);
$deposito2 = trim($_GET["deposito2"]);

$cadastro = new banco($conn, $db);
$data = $cadastro->selecionanovo($codigoproduto, $dtinicio, $dtfinal, $deposito);

//se encontrar registros
if (pg_num_rows($data)) {




    header("Content-type: " . "application/vnd.ms-excel");
    header("Content-disposition: attachment; filename=movimentacao.xls");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

    $report_names = "Users listing";

    echo "<html>" . "\r\n";
    echo "<head><title>" . $report_names . "</title><meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel\"></head>" . "\r\n";
    echo "<body><table border=\"1\">" . "\r\n";



    echo "<tr bgcolor=\"#CCCCCC\">";
    echo "<td colspan=9 ><center><b>CENTRO ATACADISTA BARÃO</b></center></td>";
    echo "</tr>" . "\r\n";



    $dia = date('d');
    $mes = date('m');
    $ano = date('Y');
    $hor = date('H');
    $min = date('i');


    echo "<tr bgcolor=\"#CCCCCC\">";
    echo "<td colspan=9  width=900 ><center><b>Movimentação de Estoque " . $dia . '/' . $mes . '/' . $ano . ' ' . $hor . ':' . $min . "</b></center></td>";
    echo "</tr>" . "\r\n";

    echo "<tr bgcolor=\"#CCCCCC\">";
    echo "<td colspan=9 ><center><b>De: " . $dtiniciox . " Até: " . $dtfinalx . " - " . $deposito2 . "</b></center></td>";
    echo "</tr>" . "\r\n";

    echo "<tr bgcolor=\"#CCCCCC\">";
    echo "<td colspan=9 ><center><b>Prduto: " . $codigoprodutox . "  " . $produtox . "</b></center></td>";
    echo "</tr>" . "\r\n";



    //preenchimento da Array com o nome dos campos
    for ($i = 0; $i < pg_num_fields($data); $i++) {
        $campos[$i] = pg_field_name($data, $i);
    }

    echo "<tr bgcolor=\"#CCCCCC\">";
    echo "<td><b>Pedido</b></td>";

    echo "<td><b>NFe</b></td>";
    echo "<td><b>Local</b></td>";
    echo "<td><b>Emissao</b></td>";

    echo "<td><b>Data</b></td>";
    echo "<td><b>Entrada</b></td>";
    echo "<td><b>Saida</b></td>";
    echo "<td><b>Valor</b></td>";
    echo "<td><b>Saldo</b></td>";
    echo "</tr>" . "\r\n";

    $primeiro = 0;
    $saldo = 0;
    //corpo da tabela
    while ($row = pg_fetch_object($data)) {

        $dtdata = substr($row->{$campos[1]}, 6, 4) . substr($row->{$campos[1]}, 3, 2) . substr($row->{$campos[1]}, 0, 2);


        if ($dtdata >= $dtinicioy) {

            if ($primeiro == 0) {

                echo "<tr bgcolor=\"#CCCCCC\">";
                echo "<td>Saldo Inicial</td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td>" . $dtinicioz . "</td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td>" . $saldo . "</td>";
                echo "</tr>" . "\r\n";
            }
            $primeiro = 1;
            for ($i = 0; $i < sizeof($campos); $i++) {

                if ($i != 4) {



                    if ($i == 0) {

                        echo "<tr bgcolor=\"#CCCCCC\">";

                        if ($row->{$campos[4]} == 1) {
                            echo "<td>Inventário</td>";

                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td></td>";
                        } else if ($row->{$campos[4]} == 2) {



                            $pedido = $row->{$campos[0]};
                            $nota = '';
                            $local = '';

                            $emissao = '';

                            if ($deposito == 26) {
                                //Verifica se existem notas para o Pedido			
                                $sql2 = "Select notnumero,notemissao from notagua where pvnumero = $pedido";
                                $cad2 = pg_query($sql2);
                                $row2 = pg_num_rows($cad2);
                                if ($row2 > 0) {
                                    $nota = pg_fetch_result($cad2, 0, "notnumero");
                                    $emissao = pg_fetch_result($cad2, 0, "notemissao");
                                    //Mascara data
                                    $auxe = explode(" ", $emissao);
                                    $aux1e = explode("-", $auxe[0]);
                                    $emissao = $aux1e[2] . '/' . $aux1e[1] . '/' . $aux1e[0];
                                    $local = "GRU";
                                }
                            }

                            if ($deposito == 9) {
                                //Verifica se existem notas para o Pedido			
                                $sql2 = "Select notnumero,notemissao from notadep where pvnumero = $pedido";
                                $cad2 = pg_query($sql2);
                                $row2 = pg_num_rows($cad2);
                                if ($row2 > 0) {
                                    $nota = pg_fetch_result($cad2, 0, "notnumero");
                                    $emissao = pg_fetch_result($cad2, 0, "notemissao");
                                    //Mascara data
                                    $auxe = explode(" ", $emissao);
                                    $aux1e = explode("-", $auxe[0]);
                                    $emissao = $aux1e[2] . '/' . $aux1e[1] . '/' . $aux1e[0];
                                    $local = "GRE";
                                }
                            }

                            if ($deposito == 11) {
                                $sql2 = "Select notnumero,notemissao from notavit where pvnumero = $pedido";
                                $cad2 = pg_query($sql2);
                                $row2 = pg_num_rows($cad2);
                                if ($row2 > 0) {
                                    $nota = pg_fetch_result($cad2, 0, "notnumero");
                                    $emissao = pg_fetch_result($cad2, 0, "notemissao");
                                    //Mascara data
                                    $auxe = explode(" ", $emissao);
                                    $aux1e = explode("-", $auxe[0]);
                                    $emissao = $aux1e[2] . '/' . $aux1e[1] . '/' . $aux1e[0];
                                    $local = "VIX";
                                }
                            }

                            if ($deposito == 2) {
                                $sql2 = "Select notnumero,notemissao from notamat where pvnumero = $pedido";
                                $cad2 = pg_query($sql2);
                                $row2 = pg_num_rows($cad2);
                                if ($row2 > 0) {
                                    $nota = pg_fetch_result($cad2, 0, "notnumero");
                                    $emissao = pg_fetch_result($cad2, 0, "notemissao");
                                    //Mascara data
                                    $auxe = explode(" ", $emissao);
                                    $aux1e = explode("-", $auxe[0]);
                                    $emissao = $aux1e[2] . '/' . $aux1e[1] . '/' . $aux1e[0];
                                    $local = "MAT";
                                }
                            }

                            if ($deposito == 1 || $deposito == 38) {

                                $sql2 = "Select notnumero,notemissao from notafil where pvnumero = $pedido";
                                $cad2 = pg_query($sql2);
                                $row2 = pg_num_rows($cad2);
                                if ($row2 > 0) {
                                    $nota = pg_fetch_result($cad2, 0, "notnumero");
                                    $emissao = pg_fetch_result($cad2, 0, "notemissao");
                                    //Mascara data
                                    $auxe = explode(" ", $emissao);
                                    $aux1e = explode("-", $auxe[0]);
                                    $emissao = $aux1e[2] . '/' . $aux1e[1] . '/' . $aux1e[0];
                                    $local = "FUN";
                                }
                            }

                            echo "<td>" . $row->{$campos[$i]} . ' ' . $row->{$campos[5]} . "</td>";

                            echo "<td>" . $nota . "</td>";
                            echo "<td>" . $local . "</td>";
                            echo "<td>" . $emissao . "</td>";
                        }
                        //Localiza as Notas para lançamentos de Pedidos de Vendas
                        else if ($row->{$campos[4]} == 3) {

                            //Verifica se é um Lancamento de Compras
                            $compra = trim($row->{$campos[0]});

                            $ped = '';
                            $seq = '';
                            $vai = '';

                            $caracteres = 0;
                            $caracteres += strlen($compra);

                            for ($ix = 0; $ix < $caracteres; $ix++) {
                                if (substr($compra, $ix, 1) == '-') {
                                    $ped = $vai;
                                    $vai = '';
                                } else {
                                    $vai = $vai . substr($compra, $ix, 1);
                                }
                            }
                            $seq = $vai;

                            if ($ped != '' && $seq != '') {

                                if ($seq == 'ND') {
                                    echo "<td>" . $row->{$campos[$i]} . ' ' . $row->{$campos[5]} . "</td>";
                                    echo "<td></td>";
                                    echo "<td></td>";
                                    echo "<td></td>";
                                } else {

                                    //Localiza e Nota de Entrada								
                                    $sql2 = "Select notentnumero,deposito from notaent where pcnumero = $ped and notentseqbaixa = $seq";
                                    $cad2 = pg_query($sql2);
                                    $row2 = pg_num_rows($cad2);
                                    if ($row2 > 0) {
                                        $nota = pg_fetch_result($cad2, 0, "notentnumero");
                                        $deposito = pg_fetch_result($cad2, 0, "deposito");
                                        if ($deposito == 1) {
                                            $local = "FIL";
                                        } else if ($deposito == 2) {
                                            $local = "MAT";
                                        } else if ($deposito == 11) {
                                            $local = "VIX";
                                        } else {
                                            $local = "GRU";
                                        }

                                        echo "<td>" . $row->{$campos[$i]} . ' ' . $row->{$campos[5]} . "</td>";
                                        echo "<td>" . $nota . "</td>";
                                        echo "<td></td>";
                                        echo "<td></td>";
                                    } else {
                                        echo "<td>" . $row->{$campos[$i]} . ' ' . $row->{$campos[5]} . "</td>";
                                        echo "<td></td>";
                                        echo "<td></td>";
                                        echo "<td></td>";
                                    }
                                }
                            } else {
                                echo "<td>" . $row->{$campos[$i]} . ' ' . $row->{$campos[5]} . "</td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                            }
                        } else {

                            echo "<td>" . $row->{$campos[$i]} . ' ' . $row->{$campos[5]} . "</td>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td></td>";
                        }
                    } else if (($i > 0) and ( $i < 2)) {
                        echo "<td>" . $row->{$campos[$i]} . "</td>";
                    } else if ($i == 2) {

                        if ($row->{$campos[4]} == 2) {

                            echo "<td></td>";
                            echo "<td>" . $row->{$campos[$i]} . "</td>";
                        } else if ($row->{$campos[4]} == 4) {
                            echo "<td></td>";
                            echo "<td>" . $row->{$campos[$i]} . "</td>";
                        } else {
                            echo "<td>" . $row->{$campos[$i]} . "</td>";
                            echo "<td></td>";
                        }
                    } else if ($i == 3) {
                        echo "<td align='right'>&nbsp;" . number_format($row->{$campos[$i]}, 2, ',', '') . "</td>";
                    }
                } else if ($i == 4) {
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

                    echo "<td>" . $saldo . "</td>";
                }
            }
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
}

//$pdf->Output();


echo "</table></body></html>" . "\r\n";

pg_close($conn);
//echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=consultanotacangua.php'>";
exit();
?>
