<?php

require_once("include/conexao.inc.php");
require_once("include/aberturainventario.php");

set_time_limit(0);

$cadastro = new banco($conn, $db);
$invdata = trim($_GET["invdata"]);
$contagem = trim($_GET["contagem"]);
$contagem2 = trim($_GET["contagem2"]);
$contagem3 = trim($_GET["contagem3"]);
$invdata2 = trim($_GET["invdata2"]);
$estoque = trim($_GET["estoque"]);

$aux = explode("/", $invdata);
$invdata = $aux[2] . '-' . $aux[1] . '-' . $aux[0] . ' 00:00:00-03';


$aux = explode("/", $invdata2);
$invdata2 = $aux[2] . '-' . $aux[1] . '-' . $aux[0] . ' 00:00:00-03';

$status = '0';

//Verifica se a Contagem na data está encerrada
$sql = "Select * from inventariocontagem Where invdata = '" . $invdata . "'";
$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {

    //Recolocar
    $sql = "UPDATE inventariocontagem SET invstatus=1 Where invdata = '" . $invdata . "'";
    pg_query($sql);

    //Zera o Invatual do Inventario Selecionado	
    $sql = "Update inventario set invatual=0 WHERE estcodigo = '$estoque' and invdata = '$invdata2'";
    pg_query($sql);

    //Looping será em Todos os Produtos
    $sql2 = "
	SELECT procodigo,procod FROM produto order by procodigo";

    //Processa os itens	
    /*
      $sql2 = "
      SELECT procodigo,sum (quantidade) as estoque
      FROM inventariocontagemsetorproduto where invdata = '$invdata' and concodigo = $contagem group by procodigo";
     */

    //EXECUTA A QUERY
    $sql2 = pg_query($sql2);

    $row2 = pg_num_rows($sql2);

    $seq = 0;

    if ($row2) {

        for ($j = 0; $j < $row2; $j++) {

            $procodigo = pg_fetch_result($sql2, $j, "procodigo");
            $procod = pg_fetch_result($sql2, $j, "procod");

            //Contagem 1

            $sql3 = "
			SELECT sum (quantidade) as estoque 
			FROM inventariocontagemsetorproduto where procodigo = " . $procodigo . " and invdata = '$invdata' and concodigo = $contagem";

            //EXECUTA A QUERY
            $sql3 = pg_query($sql3);

            $row3 = pg_num_rows($sql3);

            $quantidade = '';

            if ($row3) {
                $quantidade = pg_fetch_result($sql3, 0, "estoque");
            }


            //Contagem 2			
            $sql3 = "
			SELECT sum (quantidade) as estoque 
			FROM inventariocontagemsetorproduto where procodigo = " . $procodigo . " and invdata = '$invdata' and concodigo = $contagem2";

            //EXECUTA A QUERY
            $sql3 = pg_query($sql3);

            $row3 = pg_num_rows($sql3);

            $quantidade2 = '';

            if ($row3) {
                $quantidade2 = pg_fetch_result($sql3, 0, "estoque");
            }

            //Contagem 3			
            $sql3 = "
			SELECT sum (quantidade) as estoque 
			FROM inventariocontagemsetorproduto where procodigo = " . $procodigo . " and invdata = '$invdata' and concodigo = $contagem3";

            //EXECUTA A QUERY
            $sql3 = pg_query($sql3);

            $row3 = pg_num_rows($sql3);

            $quantidade3 = '';

            if ($row3) {
                $quantidade3 = pg_fetch_result($sql3, 0, "estoque");
            }


            if ($quantidade != '' || $quantidade2 != '' || $quantidade3 != '') {

                //echo $procod.' '.$quantidade . ' ' . $quantidade2. ' ' . $quantidade3;
                //echo '<br>';			

                $saldo = '';

                //Sem a terceira Contagem 
                if ($quantidade3 == '') {

                    //Situacao 1 : Quantidade 1 = 2 
                    if ($quantidade == $quantidade2) {
                        $saldo = $quantidade;
                    } else {
                        //Situacao 2 : Usa a Contagem 2 se nao for branco
                        if ($quantidade2 != '') {
                            $saldo = $quantidade2;
                        } else {
                            $saldo = $quantidade;
                        }
                    }
                }
                //Sem a Segunda Contagem
                else if ($quantidade2 == '') {

                    //Situacao 1 : Quantidade 1 = 3 
                    if ($quantidade == $quantidade3) {
                        $saldo = $quantidade;
                    } else {
                        //Situacao 2 : Usa a Contagem 3 se nao for branco
                        if ($quantidade3 != '') {
                            $saldo = $quantidade3;
                        } else {
                            $saldo = $quantidade;
                        }
                    }
                }
                //Sem a Primeira Contagem
                else if ($quantidade == '') {

                    //Situacao 1 : Quantidade 2 = 3 
                    if ($quantidade2 == $quantidade3) {
                        $saldo = $quantidade2;
                    } else {
                        //Situacao 2 : Usa a Contagem 3 se nao for branco
                        if ($quantidade3 != '') {
                            $saldo = $quantidade3;
                        } else {
                            $saldo = $quantidade2;
                        }
                    }
                }
                //Todas estão Preenchidas
                else {

                    //Situacao 1 : Quantidade 1 = 2 
                    if ($quantidade == $quantidade2) {
                        $saldo = $quantidade;
                    }
                    //Situacao 2 : Quantidade 1 = 3 
                    else if ($quantidade == $quantidade3) {
                        $saldo = $quantidade;
                    }
                    //Situacao 3 : Quantidade 2 = 3
                    else if ($quantidade2 == $quantidade3) {
                        $saldo = $quantidade2;
                    }
                    //Situacao 3 : Usa a Contagem Final
                    else {
                        $saldo = $quantidade3;
                    }
                }

                if ($saldo != '') {

                    //$seq = $seq + 1;
                    //echo $seq . ' ' .$procod.' '.$saldo;
                    //echo '<br>';				

                    $sql3 = "Select * from inventario Where procodigo = $procodigo";
                    $sql3 = $sql3 . " and estcodigo = '$estoque' ";
                    $sql3 = $sql3 . " and invdata = '$invdata2' ";

                    $sql3 = pg_query($sql3);
                    $row3 = pg_num_rows($sql3);
                    if ($row3) {

                        $sql4 = "Update inventario set invatual=$saldo ";
                        $sql4 = $sql4 . " Where procodigo = $procodigo";
                        $sql4 = $sql4 . " and estcodigo = '$estoque' ";
                        $sql4 = $sql4 . " and invdata = '$invdata2' ";
                        //echo $sql;
                        //echo '<br>';
                        pg_query($sql4);
                    } else {

                        $sql4 = "Insert into inventario (procodigo,";
                        $sql4 = $sql4 . "estcodigo,";
                        $sql4 = $sql4 . "invdata,invatual,invantigo) Values (";
                        $sql4 = $sql4 . "$procodigo,";
                        $sql4 = $sql4 . "'$estoque',";
                        $sql4 = $sql4 . "'$invdata2',$saldo,0)";
                        //echo $sql;
                        //echo '<br>';
                        pg_query($sql4);
                    }
                }
            }
        }
    }
}


header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";


$xml = "<dadosinv>
<registroinv>
<iteminv>";

$xml .= $status;

$xml .= "</iteminv>
</registroinv>
</dadosinv>";

echo $xml;

pg_close($conn);
exit();
?>