<?php

require_once("include/conexao.inc.php");
require_once("include/setor.php");

//RECEBE PAR?METRO

$parametro = trim($_POST["parametro"]);

$cadastro = new banco($conn, $db);

//
//QUERY

if (trim($parametro != '')) {

    $sql = "
       SELECT a.setcodigo,a.setor,a.codigosetor
        FROM  setor a
	WHERE a.codigosetor = '$parametro'
	ORDER BY a.codigosetor";
} else {
    $sql = "
       SELECT a.setcodigo,a.setor,a.codigosetor
        FROM  setor a
	ORDER BY a.codigosetor";
}


//EXECUTA A QUERY
$sql = pg_query($sql);

$row = pg_num_rows($sql);

//VERIFICA SE VOLTOU ALGO
if ($row) {
    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {
        $codigo = pg_fetch_result($sql, $i, "setcodigo");
        $descricao = pg_fetch_result($sql, $i, "setor");
        $descricao2 = pg_fetch_result($sql, $i, "codigosetor");

        if (trim($codigo) == "") {
            $codigo = "0";
        }
        if (trim($descricao) == "") {
            $descricao = "0";
        }
        if (trim($descricao2) == "") {
            $descricao2 = "0";
        }

        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao>" . $descricao . "</descricao>\n";
        $xml .= "<descricao2>" . $descricao2 . "</descricao2>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABE?ALHO

    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>
