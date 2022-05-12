<?php

require_once("include/conexao.inc.php");

//RECEBE PARÃMETRO
$parametro = trim($_POST["parametro"]);
$parametro2 = trim($_POST["parametro2"]);

//QUERY
//SELECT a.procodigo as codigo,(b.pviest026 + b.pviest011 + b.pviest027 + b.pviest024 + b.pviest09) as descricao, '1' as embalagem,d.pvcconfere

$sql = "
SELECT a.procodigo as codigo,b.pvisaldo as descricao, '1' as embalagem,d.pvcconfere
FROM  cbarras a,pvitem b
Left Join pvendaconfere as d on d.procodigo = b.procodigo and d.pvnumero = '$parametro2'
Where a.barunidade = '$parametro'
AND b.pvnumero = '$parametro2'
AND a.procodigo = b.procodigo
ORDER BY a.procodigo";

//EXECUTA A QUERY
$sql = pg_query($sql);

$row = pg_num_rows($sql);

//VERIFICA SE VOLTOU ALGO
if ($row == false) {

    //QUERY
    //SELECT a.procodigo as codigo,(b.pviest026 + b.pviest011 + b.pviest027 + b.pviest024 + b.pviest09) as descricao, c.proemb as embalagem,d.pvcconfere

    $sql = "
    SELECT a.procodigo as codigo,b.pvisaldo as descricao, c.proemb as embalagem,d.pvcconfere
    FROM  cbarras a,pvitem b, produto c
    Left Join pvendaconfere as d on d.procodigo = c.procodigo and d.pvnumero = '$parametro2'
    Where a.barcaixa = '$parametro'
    AND b.pvnumero = '$parametro2'
    AND a.procodigo = b.procodigo
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
        $descricao = pg_fetch_result($sql, $i, "descricao");
        $embalagem = pg_fetch_result($sql, $i, "embalagem");
        $pvcconfere = pg_fetch_result($sql, $i, "pvcconfere");
        if (trim($pvcconfere) == "") {
            $pvcconfere = "0";
        }
        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao>" . $descricao . "</descricao>\n";
        $xml .= "<embalagem>" . $embalagem . "</embalagem>\n";
        $xml .= "<pvcconfere>" . $pvcconfere . "</pvcconfere>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>
