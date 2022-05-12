<?php

require_once("include/conexao.inc.php");
require_once("include/clientes.php");

//RECEBE PARÃMETRO

$parametro = trim($_POST["parametro"]);

$cadastro = new banco($conn, $db);

//if($parametro=="1"){
$sql = "
       SELECT max(a.forcod) as codigo
       FROM  fornecedor a";

//       WHERE a.forcod < 2000000"
//}
//else if($parametro=="2"){
//       $sql = "
//       SELECT max(a.forcod) as codigo
//       FROM  fornecedor a
//       WHERE a.forcod > 2000000
//       AND a.forcod < 3000000";
//}
//else {
//       $sql = "
//       SELECT max(a.forcod) as codigo
//       FROM  fornecedor a
//       WHERE a.forcod > 3000000";
//
//
//}

$sql = pg_query($sql);

$row = pg_num_rows($sql);

//VERIFICA SE VOLTOU ALGO
if ($row) {

    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {
        $codigo = (pg_fetch_result($sql, $i, "codigo") + 1);

        //if($parametro=="1"){
        //   if ($codigo=='1'){$codigo='1000001';};
        //}
        //else if($parametro=="2"){
        //   if ($codigo=='1'){$codigo='2000001';};
        //}
        //else{
        //   if ($codigo=='1'){$codigo='3000001';};
        //}

        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO

    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>
