<?php

//RECEBE PAR?METRO
$parametro = trim($_POST["parametro"]);


require_once("include/conexao.inc.php");
require_once("include/logradouros.php");

$cadastro = new banco($conn, $db);

//QUERY  
//EXECUTA A QUERY
$sql = "

	SELECT a.codigo,a.descricao as nome

	FROM  bairros a
	WHERE a.codigo = '$parametro'
	ORDER BY a.descricao";

$sql = pg_query($sql);
$row = pg_num_rows($sql);


//VERIFICA SE VOLTOU ALGO
if ($row) {
    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    //PERCORRE ARRAY
    for ($i = ($row - 1); $i < $row; $i++) {
        $codigo = pg_fetch_result($sql, $i, "codigo");
        $descricao = pg_fetch_result($sql, $i, "nome");
        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao>" . $descricao . "</descricao>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABE?ALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
else {




    //EXECUTA A QUERY
    $sql = "

	SELECT a.codigo,a.descricao as nome

	FROM  bairros a
	WHERE a.descricao like '%$parametro%'
	ORDER BY a.codigo";

    $sql = pg_query($sql);
    $row = pg_num_rows($sql);


//VERIFICA SE VOLTOU ALGO
    if ($row) {
        //XML
        $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
        $xml .= "<dados>\n";

        //PERCORRE ARRAY
        for ($i = 1; $i < $row; $i++) {
            $codigo = pg_fetch_result($sql, $i, "codigo");
            $descricao = pg_fetch_result($sql, $i, "nome");
            $xml .= "<dado>\n";
            $xml .= "<codigo>" . $codigo . "</codigo>\n";
            $xml .= "<descricao>" . $descricao . "</descricao>\n";
            $xml .= "</dado>\n";
        }//FECHA FOR

        $xml .= "</dados>\n";

        //CABE?ALHO
        Header("Content-type: application/xml; charset=iso-8859-1");
    }//FECHA IF (row)
}

//PRINTA O RESULTADO
echo $xml;
?>
