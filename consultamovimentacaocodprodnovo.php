<?php

require_once("include/conexao.inc.php");
require_once("include/consultamovimentacao2.php");

$codigoproduto = trim($_GET["codigoproduto"]);

$dtinicio = trim($_GET["dtinicio"]);
$dtfinal = trim($_GET["dtfinal"]);

$deposito = trim($_GET["deposito"]);

$dtinicio = substr($dtinicio, 6, 4) . substr($dtinicio, 3, 2) . substr($dtinicio, 0, 2);
$dtfinal = substr($dtfinal, 6, 4) . substr($dtfinal, 3, 2) . substr($dtfinal, 0, 2);

$cadastro = new banco($conn, $db);
$data = $cadastro->seleciona_novo($codigoproduto, $dtinicio, $dtfinal, $deposito);

//se encontrar registros
if (pg_num_rows($data)) {
    header("Content-type: application/xml");

    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

    //preenchimento da Array com o nome dos campos
    for ($i = 0; $i < pg_num_fields($data); $i++) {
        $campos[$i] = pg_field_name($data, $i);
    }

    $xml .= "<dados>";
    $xml .= "<cabecalho>";

    //cabecalho da tabela
    for ($i = 0; $i < (sizeof($campos) - 2); $i++) {
        $xml .= "<campo>" . $campos[$i] . "</campo>";
    }
    $xml .= "<campo>NFe</campo>";
    $xml .= "<campo>Local</campo>";
    $xml .= "<campo>Emissao</campo>";
    $xml .= "<campo>Empresa</campo>";

    $xml .= "</cabecalho>";

    //corpo da tabela

    while ($row = pg_fetch_object($data)) {

        $xml .= "<registro>";
        for ($i = 0; $i < (sizeof($campos) - 2); $i++) {
            if($i==2) {
                $xml .= "<item>" . (int) $row->{$campos[$i]} . "</item>";
            } else {
                $xml .= "<item>" . $row->{$campos[$i]} . "</item>";
            }
        }
        
        $empresa = (int) $row->{$campos[8]}; 

        //Lançamentos da Toy
        if ($empresa == 2) {
            $xml .= "<item></item>";
            $xml .= "<item></item>";
            $xml .= "<item></item>";
        } else {
        
            //Localiza as Notas para lançamentos de Pedidos de Vendas
            if ($row->{$campos[4]} == 2) {

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

                $xml .= "<item>" . $nota . "</item>";
                $xml .= "<item>" . $local . "</item>";
                $xml .= "<item>" . $emissao . "</item>";
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
                        $xml .= "<item></item>";
                        $xml .= "<item></item>";
                        $xml .= "<item></item>";
                    } else {

                        //Localiza e Nota de Entrada

                        $sql2 = "Select notentnumero,deposito,notentemissao from notaent where pcnumero = $ped and notentseqbaixa = $seq";
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

                            $xml .= "<item>" . $nota . "</item>";
                            //$xml.="<item>".$local."</item>";
                            $xml .= "<item></item>";
                            $xml .= "<item></item>";
                        } else {
                            $xml .= "<item></item>";
                            $xml .= "<item></item>";
                            $xml .= "<item></item>";
                        }
                    }
                } else {
                    $xml .= "<item></item>";
                    $xml .= "<item></item>";
                    $xml .= "<item></item>";
                }
            } else {
                $xml .= "<item></item>";
                $xml .= "<item></item>";
                $xml .= "<item></item>";
            }
        }

        $xml .= "<item>{$empresa}</item>";
        $xml .= "</registro>";
    }

    //fim da tabela
    $xml .= "</dados>";
}

echo $xml;
pg_close($conn);

