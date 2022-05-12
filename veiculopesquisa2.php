<?php

//RECEBE PARÃMETRO                     
$parametro = trim($_POST["parametro"]);

require_once("include/conexao.inc.php");
require_once("include/veiculo.php");

$cadastro = new banco($conn, $db);

$sql = "
       SELECT a.veicodigo,a.veiplaca,a.veiano,a.veimodelo,a.veicor,a.veichassis,a.veitipo,a.veivalidar
        FROM  veiculos a
	WHERE a.veicodigo = '$parametro'
	ORDER BY a.veiplaca";

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
        $codigo = pg_fetch_result($sql, $i, "veicodigo");
        $descricao = pg_fetch_result($sql, $i, "veiplaca");
        $descricao2 = pg_fetch_result($sql, $i, "veiano");
        $descricao3 = pg_fetch_result($sql, $i, "veimodelo");
        $descricao4 = pg_fetch_result($sql, $i, "veicor");
        $descricao5 = pg_fetch_result($sql, $i, "veichassis");
        $descricao6 = pg_fetch_result($sql, $i, "veitipo");
        $descricao7 = pg_fetch_result($sql, $i, "veivalidar");

        if (trim($codigo) == "") {
            $codigo = "0";
        }
        if (trim($descricao) == "") {
            $descricao = "0";
        }
        if (trim($descricao2) == "") {
            $descricao2 = "0";
        }
        if (trim($descricao3) == "") {
            $descricao3 = "0";
        }
        if (trim($descricao4) == "") {
            $descricao4 = "0";
        }
        if (trim($descricao5) == "") {
            $descricao5 = "0";
        }
        if (trim($descricao6) == "") {
            $descricao6 = "0";
        }
        if (trim($descricao7) == "") {
            $descricao7 = "0";
        }

        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao>" . $descricao . "</descricao>\n";
        $xml .= "<descricao2>" . $descricao2 . "</descricao2>\n";
        $xml .= "<descricao3>" . $descricao3 . "</descricao3>\n";
        $xml .= "<descricao4>" . $descricao4 . "</descricao4>\n";
        $xml .= "<descricao5>" . $descricao5 . "</descricao5>\n";
        $xml .= "<descricao6>" . $descricao6 . "</descricao6>\n";
        $xml .= "<descricao7>" . $descricao7 . "</descricao7>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>
