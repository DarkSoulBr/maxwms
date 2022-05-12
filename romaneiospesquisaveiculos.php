<?php

//RECEBE PARÃMETRO                     
$parametro = trim($_POST["parametro"]);

require_once("include/conexao.inc.php");
require_once("include/romaneios.php");

$cadastro = new banco($conn, $db);

//QUERY

if (($parametro) != 0) {
    $sql = "
	SELECT veicodigo as codigo,veimodelo as modelo,veiplaca as placa
        FROM  veiculos a
	WHERE veicodigo = '$parametro'
	ORDER BY modelo";
} else {
    $sql = "

	SELECT veicodigo as codigo,veimodelo as modelo,veiplaca as placa
        FROM  veiculos a
	ORDER BY modelo";
}

//EXECUTA A QUERY
$sql = pg_query($sql);

$row = pg_num_rows($sql);

//VERIFICA SE VOLTOU ALGO
if ($row) {


    if (($parametro) != 0) {
        $sql2 = "
        	SELECT romfinal
            FROM romaneios a
        	WHERE romveiculo = '$parametro' 
			and romfinal > '0'				
			
        	ORDER BY romano DESC, cast(romnumero as integer) DESC limit 1";

        //EXECUTA A QUERY
        $sql2 = pg_query($sql2);

        $row2 = pg_num_rows($sql2);

        //VERIFICA SE VOLTOU ALGO
        if ($row2) {
            $romfinal = pg_fetch_result($sql2, 0, "romfinal");
            if (trim($romfinal) == "") {
                $romfinal = "0";
            }
        } else {
            $romfinal = 0;
        }
    } else {
        $romfinal = 0;
    }





    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {
        $codigo = pg_fetch_result($sql, $i, "codigo");
        $modelo = pg_fetch_result($sql, $i, "modelo");
        $placa = pg_fetch_result($sql, $i, "placa");

        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<modelo>" . $modelo . "</modelo>\n";
        $xml .= "<placa>" . $placa . "</placa>\n";
        $xml .= "<romfinal>" . $romfinal . "</romfinal>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>
