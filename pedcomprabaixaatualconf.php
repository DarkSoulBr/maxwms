<?php

//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");
require_once("include/conexao.inc.php");
require_once("include/pedcomprabaixaatual.php");

function delimitador($variavel, $tamanho, $alinhamento, $preenchimento) {
    if ($tamanho < 10 && $alinhamento == 'R' && $preenchimento == '0')
        $strtam = "%0" . $tamanho . "s";
    else if ($tamanho < 10 && $alinhamento == 'L' && $preenchimento == '0')
        $strtam = "%-0" . $tamanho . "s";
    else if ($tamanho < 10 && $alinhamento == 'R' && $preenchimento == ' ')
        $strtam = "%" . $tamanho . "s";
    else if ($tamanho < 10 && $alinhamento == 'L' && $preenchimento == ' ')
        $strtam = "%-" . $tamanho . "s";

    if ($tamanho >= 10 && $alinhamento == 'R' && $preenchimento == '0')
        $strtam = "%0" . $tamanho . "s";
    else if ($tamanho >= 10 && $alinhamento == 'L' && $preenchimento == '0')
        $strtam = "%-0" . $tamanho . "s";
    else if ($tamanho >= 10 && $alinhamento == 'R' && $preenchimento == ' ')
        $strtam = "%" . $tamanho . "s";
    else if ($tamanho >= 10 && $alinhamento == 'L' && $preenchimento == ' ')
        $strtam = "%-" . $tamanho . "s";

    $var = substr(sprintf($strtam, $variavel), 0, $tamanho);
    return $var;
}

function mudacfop($cfop, $icms, $ipi) {
    $cNovo = '';

    $cTpIcm = '';
    $cTpIpi = '';

    if ($cfop == '5102') {
        $cNovo = '1102';
    } else if ($cfop == '5100') {
        $cNovo = '1102';
    } else if ($cfop == '6102') {
        $cNovo = '2102';
    } else if ($cfop == '5201') {
        $cNovo = '1202';
    } else if ($cfop == '5202') {
        $cNovo = '1202';
    } else if ($cfop == '6201') {
        $cNovo = '2202';
    } else if ($cfop == '6202') {
        $cNovo = '2202';
    } else if ($cfop == '5915') {
        $cNovo = '1915';
    } else if ($cfop == '6915') {
        $cNovo = '2915';
    } else if ($cfop == '5914') {
        $cNovo = '1914';
    } else if ($cfop == '6914') {
        $cNovo = '2914';
    } else if ($cfop == '5912') {
        $cNovo = '1912';
    } else if ($cfop == '6912') {
        $cNovo = '2912';
    } else if ($cfop == '5910') {
        $cNovo = '1910';
    } else if ($cfop == '6910') {
        $cNovo = '2910';
    } else if ($cfop == '5917') {
        $cNovo = '1917';
    } else if ($cfop == '6917') {
        $cNovo = '2917';
    } else if ($cfop == '5949') {
        $cNovo = '1949';
    } else if ($cfop == '6949') {
        $cNovo = '2949';
    } else if ($cfop == '5101') {
        $cNovo = '1102';
    } else if ($cfop == '6101') {
        $cNovo = '2102';
    } else if ($cfop == '5916') {
        $cNovo = '1916';
    } else if ($cfop == '6916') {
        $cNovo = '2916';
    } else if ($cfop == '5105') {
        $cNovo = '1102';
    } else if ($cfop == '6105') {
        $cNovo = '2202';
    } else if ($cfop == '5152') {
        $cNovo = '1152';
    } else if ($cfop == '5100') {
        $cNovo = '1100';
    } else if ($cfop == '5103') {
        $cNovo = '1103';
    } else if ($cfop == '5106') {
        $cNovo = '1106';
    } else if ($cfop == '6106') {
        $cNovo = '2102';
    } else if ($cfop == '5403') {
        $cNovo = '1403';
    } else if ($cfop == '5405') {
        $cNovo = '1403';
    } else if ($cfop == '5113') {
        $cNovo = '1113';
    } else if (Substr($cfop, 0, 1) == '5') {
        $cNovo = '1' . Substr($cfop, 1, 3);
    }   //Se nao estiver na Lista vou colocar 1 ou 2 na Frente
    else if (Substr($cfop, 0, 1) == '6') {
        $cNovo = '2' . Substr($cfop, 1, 3);
    } else if (trim($cfop) == '') {  //Se for em branco
        $cNovo = '1102';
    } else {
        $cNovo = $cfop;
    }


    if ($cNovo == '1102') {
        if ($icms == 0) {
            $cTpIcm = 'I';
            $cTpIpi = 'O';
            $cNovo = '110201';
        } else {
            if ($ipi == 0) {
                $cNovo = '110202';
                $cTpIcm = 'T';
                $cTpIpi = 'O';
            } else {
                $cNovo = '110203';
                $cTpIcm = 'T';
                $cTpIpi = 'T';
            }
        }
    } else if ($cNovo == '1152') {
        if ($ipi == 0) {
            $cNovo = '115202';
            $cTpIcm = 'T';
            $cTpIpi = 'O';
        } else {
            $cNovo = '115203';
            $cTpIcm = 'T';
            $cTpIpi = 'T';
        }
    } else if ($cNovo == '2152') {
        $cNovo = '215202';
        $cTpIcm = 'T';
        $cTpIpi = 'O';
    } else if ($cNovo == '1202') {
        if ($icms == 0) {
            $cNovo = '120201';
            $cTpIcm = 'I';
            $cTpIpi = 'O';
        } else {
            if ($ipi == 0) {
                $cNovo = '120202';
                $cTpIcm = 'T';
                $cTpIpi = 'O';
            } else {
                $cNovo = '120203';
                $cTpIcm = 'T';
                $cTpIpi = 'T';
            }
        }
    } else if ($cNovo == '1253') {
        $cNovo = '125301';
        $cTpIcm = 'O';
        $cTpIpi = 'O';
    } else if ($cNovo == '1303') {
        $cNovo = '130301';
        $cTpIcm = 'O';
        $cTpIpi = 'O';
    } else if ($cNovo == '1353') {
        if ($icms == 0) {
            $cNovo = '135301';
            $cTpIcm = 'O';
            $cTpIpi = 'I';
        } else {
            if ($icms == 7) {
                $cNovo = '135304';
                $cTpIcm = 'T';
                $cTpIpi = 'I';
            } else {
                $cNovo = '135302';
                $cTpIcm = 'T';
                $cTpIpi = 'I';
            }
        }
    } else if ($cNovo == '1403') {
        if ($icms == 0) {
            $cNovo = '140301';
            $cTpIcm = 'O';
            $cTpIpi = 'O';
        } else {
            if ($ipi == 0) {
                $cNovo = '140302';
                $cTpIcm = 'T';
                $cTpIpi = 'O';
            } else {
                $cNovo = '140303';
                $cTpIcm = 'T';
                $cTpIpi = 'T';
            }
        }
    } else if ($cNovo == '1409') {
        if ($icms == 0) {
            if ($ipi == 0) {
                $cNovo = '140901';
                $cTpIcm = 'O';
                $cTpIpi = 'O';
            } else {
                $cNovo = '140904';
                $cTpIcm = 'O';
                $cTpIpi = 'T';
            }
        } else {
            if ($ipi == 0) {
                $cNovo = '140902';
                $cTpIcm = 'T';
                $cTpIpi = 'O';
            } else {
                $cNovo = '140903';
                $cTpIcm = 'T';
                $cTpIpi = 'T';
            }
        }
    } else if ($cNovo == '1551') {
        $cNovo = '155101';
        $cTpIcm = 'O';
        $cTpIpi = 'O';
    } else if ($cNovo == '1552') {
        $cNovo = '155201';
        $cTpIcm = 'I';
        $cTpIpi = 'I';
    } else if ($cNovo == '1556') {
        $cNovo = '155601';
        $cTpIcm = 'O';
        $cTpIpi = 'O';
    } else if ($cNovo == '1557') {
        $cNovo = '155701';
        $cTpIcm = 'I';
        $cTpIpi = 'I';
    } else if ($cNovo == '1602') {
        $cNovo = '160201';
        $cTpIcm = 'O';
        $cTpIpi = 'O';
    } else if ($cNovo == '1605') {
        $cNovo = '160501';
        $cTpIcm = 'O';
        $cTpIpi = 'O';
    } else if ($cNovo == '1653') {
        $cNovo = '165301';
        $cTpIcm = 'O';
        $cTpIpi = 'O';
    } else if ($cNovo == '1910') {
        if ($icms == 0) {
            $cNovo = '191001';
            $cTpIcm = 'O';
            $cTpIpi = 'O';
        } else {
            if ($ipi == 0) {
                $cNovo = '191002';
                $cTpIcm = 'T';
                $cTpIpi = 'O';
            } else {
                $cNovo = '191003';
                $cTpIcm = 'T';
                $cTpIpi = 'T';
            }
        }
    } else if ($cNovo == '1912') {
        if ($icms == 0) {
            $cNovo = '191201';
            $cTpIcm = 'O';
            $cTpIpi = 'O';
        } else {
            $cNovo = '191202';
            $cTpIcm = 'T';
            $cTpIpi = 'O';
        }
    } else if ($cNovo == '1913') {
        $cNovo = '191302';
        $cTpIcm = 'T';
        $cTpIpi = 'O';
    } else if ($cNovo == '1916') {
        $cNovo = '191601';
        $cTpIcm = 'I';
        $cTpIpi = 'O';
    } else if ($cNovo == '1933') {
        $cNovo = '193301';
        $cTpIcm = 'I';
        $cTpIpi = 'I';
    } else if ($cNovo == '1949') {
        $cNovo = '194901';
        $cTpIcm = 'O';
        $cTpIpi = 'O';
    } else if ($cNovo == '2102') {
        $cNovo = '210201';
        $cTpIcm = 'T';
        $cTpIpi = 'O';
    } else if ($cNovo == '2202') {
        if ($ipi == 0) {
            $cNovo = '220202';
            $cTpIcm = 'T';
            $cTpIpi = 'O';
        } else {
            $cNovo = '220203';
            $cTpIcm = 'T';
            $cTpIpi = 'T';
        }
    } else if ($cNovo == '2303') {
        $cNovo = '230301';
        $cTpIcm = 'O';
        $cTpIpi = 'O';
    } else if ($cNovo == '2353') {
        $cNovo = '235302';
        $cTpIcm = 'T';
        $cTpIpi = 'I';
    } else if ($cNovo == '2556') {
        $cNovo = '255601';
        $cTpIcm = 'O';
        $cTpIpi = 'O';
    } else if ($cNovo == '2910') {
        $cNovo = '291003';
        $cTpIcm = 'T';
        $cTpIpi = 'T';
    } else if ($cNovo == '2949') {
        if ($icms == 0) {
            $cNovo = '294901';
            $cTpIcm = 'O';
            $cTpIpi = 'O';
        } else {
            if ($ipi == 0) {
                $cNovo = '294902';
                $cTpIcm = 'T';
                $cTpIpi = 'O';
            } else {
                $cNovo = '294903';
                $cTpIcm = 'T';
                $cTpIpi = 'T';
            }
        }
    } else {
        $cNovo = $cNovo . '01';
        $cTpIcm = 'T';
        $cTpIpi = 'T';
    }

    $cNovo = $cNovo . $cTpIcm . $cTpIpi;

    return $cNovo;
}

$cadastro = new banco($conn, $db);

$nota = $_GET["pcnumero"];
$pcseq = $_GET["pcseq"];

$usuario = $_GET["usuario"];

$campo1 = $_GET["c"];
$campo2 = $_GET["d"];
$campo3 = $_GET["e"];

header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";


$codestoque = 9;

//----VERIFICA QUAL FOI A DATA DA NOTA----------------
$sql = "SELECT notentdata,pcnumero,notentseqbaixa,notentcodigo,deposito, notentnumero, notentemissao
  FROM notaent Where pcnumero = $nota and notentseqbaixa = $pcseq ";
$sql = pg_query($sql);
$row = pg_num_rows($sql);

if ($row) {
    $pvfdatahora = pg_fetch_result($sql, 0, "notentdata");
    $pcnumero = pg_fetch_result($sql, 0, "pcnumero");
    $notentseqbaixa = pg_fetch_result($sql, 0, "notentseqbaixa");
    $notentcodigo = pg_fetch_result($sql, 0, "notentcodigo");

    $codestoque = pg_fetch_result($sql, 0, "deposito");

    $notentnumero = pg_fetch_result($sql, 0, "notentnumero");
    $notentemissao = pg_fetch_result($sql, 0, "notentemissao");

    $vnumero = $pcnumero . '-' . $notentseqbaixa;
}
//----------------------------------------------------

if (trim($codestoque) == "") {
    $codestoque = 9;
}
//$codestoque=9;

if (sizeof($campo1) > 0) {

    //Grava o Flag como atualizado
    $sql = "SELECT notentcodigo FROM notaent Where pcnumero = $nota and notentseqbaixa = $pcseq ";
    $sql = pg_query($sql);
    $row = pg_num_rows($sql);

    if ($row) {

        $numero = pg_fetch_result($sql, 0, "notentcodigo");

        $dtatualiza = date("Y-m-d H:i:s") . '-03';

        $cadastro->alteranota("notaent", "notatualiza='1',notatualizadata='$dtatualiza'", "$numero");

        // ENVIAR NOTIFICACAO DE ESTOQUE ATUALIZADO AOS USUARIOS REGISTRADOS
        //$PedidoComprasController = new PedidoController();
        //$PedidoComprasController->notificar($pcnumero, $notentnumero, $notentemissao, 4);
    }

    for ($i = 0; $i < sizeof($campo1); $i++) {

        if (trim($campo2[$i]) != '0') {

            $procodigo = $campo1[$i];
            $pvcestoque = $campo2[$i];
            $estfisico = $campo3[$i];

            if (trim($estfisico) == '') {
                $estfisico = 'INDEFINIDO';
            }

            //---atualizar a tabela de estoque

            $sql = "SELECT * From estoqueatual WHERE procodigo = '$procodigo' and codestoque = '$codestoque' ";          
            $sql = pg_query($sql);
            $row = pg_num_rows($sql);

            if ($row) {

                $estqtd = pg_fetch_result($sql, 0, "estqtd");
                $estoque = $pvcestoque + $estqtd;

                $sql = "Update estoqueatual set estqtd=$estoque WHERE procodigo = '$procodigo' and codestoque = '$codestoque' ";
                pg_query($sql);

                $estqtd2 = $estqtd;
            } else {

                $sql = "Insert into estoqueatual (procodigo,estqtd,codestoque) values ('$procodigo',$pvcestoque,'$codestoque') ";
                pg_query($sql);

                $estqtd2 = 0;
            }


            //----------------------ATUALIZA MOVESTOQUE----------------------------

            $sql = "SELECT a.pcipreco From pcitem a WHERE a.pcnumero = '$pcnumero'
         AND a.procodigo = '$procodigo'";

            $sql = pg_query($sql);
            $row = pg_num_rows($sql);

            if ($row) {

                $pcipreco = pg_fetch_result($sql, 0, "pcipreco");
            } else {

                $pcipreco = 0;
            }

            //Data da atualização será pela data atual

            $pvfdatahora2 = date("Y-m-d H:i:s") . '-03';

            $tabela = 'movestoque' . substr($pvfdatahora2, 5, 2) . substr($pvfdatahora2, 2, 2);

            //$pvfdatahora2=substr($pvfdatahora, 0, 10).' '.date("H:i:s").'-03';

            $cadastro->insere($tabela, "(pvnumero,movdata,procodigo,
             movqtd,movvalor,movtipo,codestoque)"
                    , "('$vnumero','$pvfdatahora2','$procodigo',
             '$pvcestoque','$pcipreco','3','$codestoque')");





            //--------------------------------------------------------------------------


            $lgqtipo = 'BAIXA COMPRA';

            $lgqdata = date('Y-m-d');
            $lgqhora = date('H:i');
            $usucodigo = $usuario;
            $sql2 = "Insert into logestoque (lgqdata,lgqhora,usucodigo,lgqpedido,procodigo,lgqsaldo,lgqquantidade,lgqestoque,lgqtipo,lgqseq
		) values ('$lgqdata','$lgqhora','$usucodigo','$pcnumero','$procodigo',$estqtd2,$pvcestoque,'$codestoque','$lgqtipo',$notentseqbaixa) ";
            pg_query($sql2);

            //echo $sql2;    
        }
    }


}

$xml = "<dados>
<registro>
<item>" . '1' . "</item>
</registro>
</dados>";

echo $xml;

pg_close($conn);
exit();

