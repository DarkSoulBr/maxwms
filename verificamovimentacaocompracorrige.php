<?php

require_once("include/conexao.inc.php");
require_once("include/acertoestoque.php");

require("verifica2.php");

$usucodigo = $_SESSION["id_usuario"];

set_time_limit(0);

//RECEBE PARÃMETRO         
//$parametro = trim($_GET["parametro"]);  
//$parametro2 = trim($_GET["parametro2"]);

$parametro = trim($_POST["parametro"]);
$parametro2 = trim($_POST["parametro2"]);

$parametro3 = $parametro . '-' . $parametro2;

$cadastro = new banco($conn, $db);

//Verifica se tem lançamentos Fantasmas

//Faz uma verificação de entradas fantasmas onde apareceu um unico caso de uma entrada sem número de compras

$tabela = 'movestoque' . date('my');
$sql = "SELECT a.movqtd,a.movtipo,a.movdata as ordem,a.movcodigo,a.procodigo,a.codestoque FROM $tabela a WHERE a.movtipo = 3 AND a.pvnumero = ''";

$sql = pg_query($sql);
$row = pg_num_rows($sql);

//VERIFICA SE VOLTOU ALGO
if ($row) {
    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {        
        $movcodigo = pg_fetch_result($sql, $i, "movcodigo");        
        pg_query("DELETE FROM {$tabela} WHERE movcodigo={$movcodigo}");        
    }
    
}


//Verifica qual o ultimo ano que existem tabelas de movimentação
$ano = 22;
$mes = 1;

while (true) {

    $tabela = 'movestoque' . str_pad($mes, 2, '0', STR_PAD_LEFT) . str_pad($ano, 2, '0', STR_PAD_LEFT);

    //Se a tabela não existe sai do Loop
    $cad = pg_query("SELECT relname FROM pg_class WHERE relname = '{$tabela}'");
    if (pg_num_rows($cad) == 0) {
        break;
    }

    $mes ++;
    if ($mes == 13) {
        $mes = 1;
        $ano++;
    }
}
$anofim = $ano;

//Fica em Looping em todos os itens da Baixa de Compras


$sql = "select a.notentnumero,a.deposito,a.notatualiza,b.*,c.procod from notaent a,neitem b,produto c where a.pcnumero = '$parametro' and a.notentseqbaixa = '$parametro2' and a.notentcodigo = b.notentcodigo and b.procodigo = c.procodigo";

$sql = pg_query($sql);
$row = pg_num_rows($sql);

$contador = 0;
$valor = 1;

//VERIFICA SE VOLTOU ALGO
if ($row) {

    //Vou abrir o Select uma vez apenas
    $sql3 = "";
    for ($ano = 22; $ano < $anofim; $ano++) {
        for ($mes = 1; $mes < 13; $mes++) {
            if ($ano < 10) {
                $anovai = '0' . $ano;
            } else {
                $anovai = $ano;
            }
            if ($mes < 10) {
                $mesvai = '0' . $mes;
            } else {
                $mesvai = $mes;
            }
            $tabela = 'movestoque' . $mesvai . $anovai;

            if ($sql3 == "") {
                $sql3 = "";
            } else {
                $sql3 = $sql3 . "union ";
            }
            $sql3 = $sql3 . "select a.movqtd,a.movtipo,a.movdata as ordem,a.movcodigo,a.procodigo,a.codestoque
						FROM $tabela a 						
						Where a.pvnumero = '$parametro3' AND a.empresa IS NULL ";
        }
    }
    $sql3 = $sql3 . " order by ordem,movcodigo";
  
    $sql3 = pg_query($sql3);
    $row3 = pg_num_rows($sql3);


    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {
        //for($i=0; $i<1000; $i++) {

        $codigoproduto = pg_fetch_result($sql, $i, "procodigo");
        //$pvnumero = pg_fetch_result($sql, $i, "pvnumero");	
        $procod = pg_fetch_result($sql, $i, "procod");
        $deposito = pg_fetch_result($sql, $i, "deposito");

        //Só faz as correçoes se o estoque já estiver atualizado
        $notatualiza = pg_fetch_result($sql, $i, "notatualiza");
        //if($notatualiza==1){
        //for ($estcodigo=1; $estcodigo<100; $estcodigo++) {

        $estcodigo = $deposito;

        $saldoped = pg_fetch_result($sql, $i, "neisaldo");

        if ($saldoped > 0) {

            //Processa as Movimentações do Item para Comparar com o pedido				

            $saldo = 0;

            //VERIFICA SE VOLTOU ALGO
            if ($row3) {

                //PERCORRE ARRAY
                for ($i3 = 0; $i3 < $row3; $i3++) {

                    $movqtd = pg_fetch_result($sql3, $i3, "movqtd");
                    $movtipo = pg_fetch_result($sql3, $i3, "movtipo");
                    $ordem = pg_fetch_result($sql3, $i3, "ordem");
                    $movcodigo = pg_fetch_result($sql3, $i3, "movcodigo");
                    $procodigo = pg_fetch_result($sql3, $i3, "procodigo");
                    $deposito = pg_fetch_result($sql3, $i3, "codestoque");

                    if (trim($movqtd) == "") {
                        $movqtd = "0";
                    }
                    if (trim($movtipo) == "") {
                        $movtipo = "0";
                    }
                    if (trim($movcodigo) == "") {
                        $movcodigo = "0";
                    }
                    if (trim($procodigo) == "") {
                        $procodigo = "0";
                    }
                    if (trim($deposito) == "") {
                        $deposito = "0";
                    }

                    if ($codigoproduto == $procodigo) {
                        if ($estcodigo == $deposito) {

                            if ($movtipo == 1) {
                                $saldo = $movqtd;
                            } else if ($movtipo == 2) {
                                $saldo = $saldo - $movqtd;
                            } else if ($movtipo == 3) {
                                $saldo = $saldo + $movqtd;
                            } else if ($movtipo == 4) {
                                $saldo = $saldo - $movqtd;
                            }
                        }
                    }
                }
            }

            /*
              echo '<br>';
              echo ' '.$parametro3;
              echo ' '.$procod;
              echo ' '.$estcodigo;
              echo ' '.$saldoped;
              echo ' '.$saldo;
             */

            $aux = $saldoped - $saldo;
            if ($aux <> 0) {

                //Se a diferença for maior que zero lança um entrada 
                if ($aux > 0) {

                    //Fase 1 = Atualiza o estoque atual
                    $pvcestoque = $aux;

                    $sql4 = "SELECT * From estoqueatual WHERE procodigo = '$codigoproduto' and codestoque = '$deposito' ";

                    $sql4 = pg_query($sql4);
                    $row4 = pg_num_rows($sql4);

                    if ($row4) {

                        $estqtd = pg_fetch_result($sql4, 0, "estqtd");
                        $estoque = $pvcestoque + $estqtd;

                        $sql5 = "Update estoqueatual set estqtd=$estoque WHERE procodigo = '$codigoproduto' and codestoque = '$deposito' ";
                        pg_query($sql5);

                        $estqtd2 = $estqtd;
                    } else {

                        $sql5 = "Insert into estoqueatual (procodigo,estqtd,codestoque) values ('$procodigo',$pvcestoque,'$deposito') ";
                        pg_query($sql5);

                        $estqtd2 = 0;
                    }

                    //Fase 2 = Atualiza a movimentacao						

                    $pcnumero = $parametro;
                    $notentseqbaixa = $parametro2;

                    $vnumero = $parametro . '-' . $parametro2;

                    $sql6 = "SELECT a.pcipreco From pcitem a WHERE a.pcnumero = '$pcnumero'
						AND a.procodigo = '$codigoproduto'";

                    $sql6 = pg_query($sql6);
                    $row6 = pg_num_rows($sql6);

                    if ($row6) {

                        $pcipreco = pg_fetch_result($sql6, 0, "pcipreco");

                        //Data da atualização será pela data atual

                        $pvfdatahora2 = date("Y-m-d H:i:s") . '-03';

                        $tabela = 'movestoque' . substr($pvfdatahora2, 5, 2) . substr($pvfdatahora2, 2, 2);

                        $cadastro->insere($tabela, "(pvnumero,movdata,procodigo,
							movqtd,movvalor,movtipo,codestoque)"
                                , "('$vnumero','$pvfdatahora2','$codigoproduto',
							'$pvcestoque','$pcipreco','3','$deposito')");
                    }


                    //Fase 3 - Cria o Log
                    //--------------------------------------------------------------------------						
                    $lgqtipo = 'BAIXA COMPRA';

                    $lgqdata = date('Y-m-d');
                    $lgqhora = date('H:i');

                    $sql7 = "Insert into logestoque (lgqdata,lgqhora,usucodigo,lgqpedido,procodigo,lgqsaldo,lgqquantidade,lgqestoque,lgqtipo,lgqseq
						) values ('$lgqdata','$lgqhora','$usucodigo','$pcnumero','$codigoproduto',$estqtd2,$pvcestoque,'$deposito','$lgqtipo',$notentseqbaixa) ";
                    pg_query($sql7);
                }
                //Se a diferença for menor que zero lança uma saida como estorno
                else {

                    //Fase 1 = Atualiza o estoque atual
                    $pvcestoque = ($aux * -1);

                    $sql4 = "SELECT * From estoqueatual WHERE procodigo = '$codigoproduto' and codestoque = '$deposito' ";

                    $sql4 = pg_query($sql4);
                    $row4 = pg_num_rows($sql4);

                    if ($row4) {

                        $estqtd = pg_fetch_result($sql4, 0, "estqtd");
                        $estoque = $estqtd - $pvcestoque;

                        $sql5 = "Update estoqueatual set estqtd=$estoque WHERE procodigo = '$codigoproduto' and codestoque = '$deposito' ";
                        pg_query($sql5);

                        $estqtd2 = $estqtd;
                    } else {

                        $estqtd = 0;
                        $estoque = $estqtd - $pvcestoque;

                        $sql5 = "Insert into estoqueatual (procodigo,estqtd,codestoque) values ('$procodigo',$estoque,'$deposito') ";
                        pg_query($sql5);

                        $estqtd2 = 0;
                    }

                    //Fase 2 = Atualiza a movimentacao						

                    $pcnumero = $parametro;
                    $notentseqbaixa = $parametro2;

                    $vnumero = $parametro . '-' . $parametro2;

                    $sql6 = "SELECT a.pcipreco From pcitem a WHERE a.pcnumero = '$pcnumero'
						AND a.procodigo = '$codigoproduto'";

                    $sql6 = pg_query($sql6);
                    $row6 = pg_num_rows($sql6);

                    if ($row6) {

                        $pcipreco = pg_fetch_result($sql6, 0, "pcipreco");

                        //Data da atualização será pela data atual

                        $pvfdatahora2 = date("Y-m-d H:i:s") . '-03';

                        $tabela = 'movestoque' . substr($pvfdatahora2, 5, 2) . substr($pvfdatahora2, 2, 2);

                        $cadastro->insere($tabela, "(pvnumero,movdata,procodigo,
							movqtd,movvalor,movtipo,codestoque)"
                                , "('$vnumero','$pvfdatahora2','$codigoproduto',
							'$pvcestoque','$pcipreco','4','$deposito')");
                    }


                    //Fase 3 - Cria o Log
                    //--------------------------------------------------------------------------						
                    $lgqtipo = 'CANC. BAIXA COMPRA';

                    $lgqdata = date('Y-m-d');
                    $lgqhora = date('H:i');
                    $pvcestoque = 0 - $pvcestoque;
                    $sql7 = "Insert into logestoque (lgqdata,lgqhora,usucodigo,lgqpedido,procodigo,lgqsaldo,lgqquantidade,lgqestoque,lgqtipo,lgqseq
						) values ('$lgqdata','$lgqhora','$usucodigo','$pcnumero','$codigoproduto',$estqtd2,$pvcestoque,'$deposito','$lgqtipo',$notentseqbaixa) ";
                    pg_query($sql7);
                }

                //$valor=2;
            }
        }

        //}
        //}
    }
}




/*
  echo ' ';
  echo ' ';
  echo '<br>';
  echo 'FINAL DE PROCESSAMENTO!';
 */

$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
$xml .= "<dados>\n";
$xml .= "<valor>" . $valor . "</valor>\n";
$xml .= "</dados>\n";

Header("Content-type: application/xml; charset=iso-8859-1");

pg_close($conn);
//exit();

echo $xml;
?>

