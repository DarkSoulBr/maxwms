<?php

require_once("include/conexao.inc.php");
require_once("include/pedcomprabaixaatual.php");

require("verifica2.php");

$cadastro = new banco($conn, $db);

$nota = $_GET["pcnumero"];
$pcseq = $_GET["pcseq"];

$usuario = $_SESSION["id_usuario"];

$campo1 = $_GET["c"];
$campo2 = $_GET["d"];

$codestoque = 9;

//----VERIFICA QUAL FOI A DATA DA NOTA----------------
$sql = "SELECT notentdata,pcnumero,notentseqbaixa,notentcodigo,deposito FROM notaent Where pcnumero = $nota and notentseqbaixa = $pcseq ";
$sql = pg_query($sql);
$row = pg_num_rows($sql);

if ($row) {
    $pvfdatahora = pg_fetch_result($sql, 0, "notentdata");

    //Cancelamento vai passar a ser pela data atual
    $pvfdatahora = date('Y-m-d');

    $pcnumero = pg_fetch_result($sql, 0, "pcnumero");
    $notentseqbaixa = pg_fetch_result($sql, 0, "notentseqbaixa");

    $notentcodigo = pg_fetch_result($sql, 0, "notentcodigo");

    $codestoque = pg_fetch_result($sql, 0, "deposito");

    $vnumero = $pcnumero . '-' . $notentseqbaixa;
}
//----------------------------------------------------


if (trim($codestoque) == "") {
    $codestoque = 9;
}
//$codestoque=9;

if (sizeof($campo1) > 0) {
    for ($i = 0; $i < sizeof($campo1); $i++) {

        if (trim($campo2[$i]) != '0') {

            $procodigo = $campo1[$i];
            $pvcestoque = $campo2[$i];

            //---atualizar a tabela de estoque

            $sql = "SELECT * From estoqueatual WHERE procodigo = '$procodigo' and codestoque = '$codestoque' ";

            $sql = pg_query($sql);
            $row = pg_num_rows($sql);

            if ($row) {

                $estqtd = pg_fetch_result($sql, 0, "estqtd");
                $estoque = $estqtd - $pvcestoque;

                $sql = "Update estoqueatual set estqtd=$estoque WHERE procodigo = '$procodigo' and codestoque = '$codestoque' ";
                pg_query($sql);

                $estqtd2 = $estqtd;
            } else {
                $estqtd = 0;
                $estoque = $estqtd - $pvcestoque;
                $sql = "Insert into estoqueatual (procodigo,estqtd,codestoque) values ('$procodigo',$estoque,'$codestoque') ";
                pg_query($sql);

                $estqtd2 = $estqtd;
            }

            
            $sql = "SELECT a.pcipreco From pcitem a WHERE a.pcnumero = '$pcnumero'
         AND a.procodigo = '$procodigo'";


            $sql = pg_query($sql);
            $row = pg_num_rows($sql);

            if ($row) {

                $pcipreco = pg_fetch_result($sql, 0, "pcipreco");

                $tabela = 'movestoque' . substr($pvfdatahora, 5, 2) . substr($pvfdatahora, 2, 2);

                $pvfdatahora2 = substr($pvfdatahora, 0, 10) . ' ' . date("H:i:s") . '-03';

                $cadastro->insere($tabela, "(pvnumero,movdata,procodigo,
             movqtd,movvalor,movtipo,codestoque)"
                        , "('$vnumero','$pvfdatahora2','$procodigo',
             '$pvcestoque','$pcipreco','4','$codestoque')");
            }

            //--------------------------------------------------------------------------



            $lgqtipo = 'CANC. BAIXA COMPRA';

            $lgqdata = date('Y-m-d');
            $lgqhora = date('H:i');
            $usucodigo = $usuario;
            $pvcestoque = 0 - $pvcestoque;
            $sql2 = "Insert into logestoque (lgqdata,lgqhora,usucodigo,lgqpedido,procodigo,lgqsaldo,lgqquantidade,lgqestoque,lgqtipo,lgqseq
		 ) values ('$lgqdata','$lgqhora','$usucodigo','$pcnumero','$procodigo',$estqtd2,$pvcestoque,'$codestoque','$lgqtipo',$notentseqbaixa) ";
            pg_query($sql2);

            //echo $sql2;    
        }
    }



    $sql = "SELECT notentcodigo FROM notaent Where pcnumero = $nota and notentseqbaixa = $pcseq ";
    $sql = pg_query($sql);
    $row = pg_num_rows($sql);

    if ($row) {

        $numero = pg_fetch_result($sql, 0, "notentcodigo");
        $cadastro->alteranota("notaent", "notatualiza='',notatualizadata=null", "$numero");
    }
}



pg_close($conn);
exit();
?>
