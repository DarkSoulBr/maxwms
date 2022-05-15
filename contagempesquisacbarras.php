<?php

//RECEBE PARÃMETRO
$parametro = trim($_POST["parametro"]);
$invdata = trim($_POST["parametro2"]);
$parametro3 = trim($_POST["parametro3"]);
$parametro4 = trim($_POST["parametro4"]);
$parametro5 = trim($_POST["parametro5"]);

/*
  $parametro = '7899091423200';
  $invdata = '28/05/2015';
  $parametro3 = 3;
  $parametro4 = 1;
  $parametro5 = 1;
 */

$aux = explode("/", $invdata);
$invdata = $aux[2] . '-' . $aux[1] . '-' . $aux[0] . ' 00:00:00-03';

require_once("include/conexao.inc.php");
require_once("include/conferencia.php");

$cadastro = new banco($conn, $db);

//QUERY
$sql = "
SELECT a.procodigo as codigo, '1' as embalagem, d.quantidade, c.procod, c.prnome 
FROM  cbarras a, produto c   
Left Join inventariocontagemsetorproduto as d on d.procodigo = c.procodigo and invdata = '$invdata' and concodigo = $parametro3 and setcodigo = $parametro4 and colcodigo = $parametro5 
Where a.barunidade = '$parametro'
AND a.procodigo = c.procodigo
ORDER BY a.procodigo";

//EXECUTA A QUERY
$sql = pg_query($sql);

$row = pg_num_rows($sql);

//VERIFICA SE VOLTOU ALGO
if ($row == false) {

    //QUERY
    $sql = "
   SELECT a.procodigo as codigo, c.proemb as embalagem, d.quantidade, c.procod, c.prnome 
   FROM  cbarras a, produto c  
	Left Join inventariocontagemsetorproduto as d on d.procodigo = c.procodigo and invdata = '$invdata' and concodigo = $parametro3 and setcodigo = $parametro4 and colcodigo = $parametro5  
	Where a.barcaixa = '$parametro'
	AND a.procodigo = c.procodigo
	ORDER BY a.procodigo";

    //EXECUTA A QUERY
    $sql = pg_query($sql);

    $row = pg_num_rows($sql);
}

if ($row) {

    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {

        $codigo = pg_fetch_result($sql, $i, "codigo");
        $embalagem = pg_fetch_result($sql, $i, "embalagem");
        $pvcconfere = pg_fetch_result($sql, $i, "quantidade");

        $procod = pg_fetch_result($sql, $i, "procod");
        $prnome = pg_fetch_result($sql, $i, "prnome");

        if (trim($pvcconfere) == "") {
            $pvcconfere = "0";
        }

        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<embalagem>" . $embalagem . "</embalagem>\n";
        $xml .= "<pvcconfere>" . $pvcconfere . "</pvcconfere>\n";
        $xml .= "<procod>" . $procod . "</procod>\n";
        $xml .= "<prnome>" . $prnome . "</prnome>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>
