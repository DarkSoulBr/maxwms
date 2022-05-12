<?php

require_once("include/conexao.inc.php");
require_once("include/banco.php");

//RECEBE PARÃMETRO
$parametro = trim($_REQUEST["parametro"]);
$parametro2 = trim($_REQUEST["parametro2"]);


$cadastro = new banco($conn, $db);


$sql = "SELECT veicodigo,veicod,veirenavam,veiplaca,veitara,veicapacidadekg,veicapacidadem3,veitprodado,veitpcarroceria,veitpveiculo,
veipropveiculo,veiuf,veitpdoc,veicpf,veicnpj,veirntrc,veiie,veipropuf,veitpproprietario,veirazao,veipessoa,veirg,veiempresa FROM veiculos";


if ($parametro2 == "1") {
    $sql = $sql . " WHERE veicod like '%$parametro%' ORDER BY veicod";
} elseif ($parametro2 == "2") {
    $sql = $sql . " WHERE veirenavam like '%$parametro%' ORDER BY veirenavam";
} else {
    $sql = $sql . " WHERE veiplaca like '%$parametro%' ORDER BY veiplaca";
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


        $codigo = pg_fetch_result($sql, $i, "veicodigo");
        $descricao1 = pg_fetch_result($sql, $i, "veicod");
        $descricao2 = pg_fetch_result($sql, $i, "veirenavam");
        $descricao3 = pg_fetch_result($sql, $i, "veiplaca");
        $descricao4 = pg_fetch_result($sql, $i, "veitara");
        $descricao5 = pg_fetch_result($sql, $i, "veicapacidadekg");
        $descricao6 = pg_fetch_result($sql, $i, "veicapacidadem3");
        $descricao7 = pg_fetch_result($sql, $i, "veitprodado");
        $descricao8 = pg_fetch_result($sql, $i, "veitpcarroceria");
        $descricao9 = pg_fetch_result($sql, $i, "veitpveiculo");
        $descricao10 = pg_fetch_result($sql, $i, "veipropveiculo");
        $descricao11 = pg_fetch_result($sql, $i, "veiuf");
        $descricao12 = pg_fetch_result($sql, $i, "veitpdoc");
        $descricao13 = pg_fetch_result($sql, $i, "veicpf");
        $descricao14 = pg_fetch_result($sql, $i, "veicnpj");
        $descricao15 = pg_fetch_result($sql, $i, "veirntrc");
        $descricao16 = pg_fetch_result($sql, $i, "veiie");
        $descricao17 = pg_fetch_result($sql, $i, "veipropuf");
        $descricao18 = pg_fetch_result($sql, $i, "veitpproprietario");
        $descricao19 = pg_fetch_result($sql, $i, "veirazao");
        $descricao20 = pg_fetch_result($sql, $i, "veipessoa");
        $descricao21 = pg_fetch_result($sql, $i, "veirg");
        $descricao22 = pg_fetch_result($sql, $i, "veiempresa");



        if (trim($codigo) == "") {
            $codigo = "0";
        }
        if (trim($descricao1) == "") {
            $descricao1 = "0";
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
        if (trim($descricao8) == "") {
            $descricao8 = "0";
        }
        if (trim($descricao9) == "") {
            $descricao9 = "0";
        }
        if (trim($descricao10) == "") {
            $descricao10 = "0";
        }
        if (trim($descricao11) == "") {
            $descricao11 = "0";
        }
        if (trim($descricao12) == "") {
            $descricao12 = "0";
        }
        if (trim($descricao13) == "") {
            $descricao13 = "0";
        }
        if (trim($descricao14) == "") {
            $descricao14 = "0";
        }
        if (trim($descricao15) == "") {
            $descricao15 = "0";
        }
        if (trim($descricao16) == "") {
            $descricao16 = "0";
        }
        if (trim($descricao17) == "") {
            $descricao17 = "0";
        }
        if (trim($descricao18) == "") {
            $descricao18 = "0";
        }
        if (trim($descricao19) == "") {
            $descricao19 = "0";
        }
        if (trim($descricao20) == "") {
            $descricao20 = "0";
        }
        if (trim($descricao21) == "") {
            $descricao21 = "0";
        }
        if (trim($descricao22) == "") {
            $descricao22 = "0";
        }


        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao1>" . $descricao1 . "</descricao1>\n";
        $xml .= "<descricao2>" . $descricao2 . "</descricao2>\n";
        $xml .= "<descricao3>" . $descricao3 . "</descricao3>\n";
        $xml .= "<descricao4>" . $descricao4 . "</descricao4>\n";
        $xml .= "<descricao5>" . $descricao5 . "</descricao5>\n";
        $xml .= "<descricao6>" . $descricao6 . "</descricao6>\n";
        $xml .= "<descricao7>" . $descricao7 . "</descricao7>\n";
        $xml .= "<descricao8>" . $descricao8 . "</descricao8>\n";
        $xml .= "<descricao9>" . $descricao9 . "</descricao9>\n";
        $xml .= "<descricao10>" . $descricao10 . "</descricao10>\n";
        $xml .= "<descricao11>" . $descricao11 . "</descricao11>\n";
        $xml .= "<descricao12>" . $descricao12 . "</descricao12>\n";
        $xml .= "<descricao13>" . $descricao13 . "</descricao13>\n";
        $xml .= "<descricao14>" . $descricao14 . "</descricao14>\n";
        $xml .= "<descricao15>" . $descricao15 . "</descricao15>\n";
        $xml .= "<descricao16>" . $descricao16 . "</descricao16>\n";
        $xml .= "<descricao17>" . $descricao17 . "</descricao17>\n";
        $xml .= "<descricao18>" . $descricao18 . "</descricao18>\n";
        $xml .= "<descricao19>" . $descricao19 . "</descricao19>\n";
        $xml .= "<descricao20>" . $descricao20 . "</descricao20>\n";
        $xml .= "<descricao21>" . $descricao21 . "</descricao21>\n";
        $xml .= "<descricao22>" . $descricao22 . "</descricao22>\n";

        $xml .= "</dado>\n";
    }//FECHA FOR
    $xml .= "</dados>\n";

    //CABEÇALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>