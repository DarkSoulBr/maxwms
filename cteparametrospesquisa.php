<?php

require_once("include/conexao.inc.php");
require_once("include/banco.php");

//RECEBE PARĂMETRO
$parametro = trim($_REQUEST["parametro"]);
$parametro2 = trim($_REQUEST["parametro2"]);

$cadastro = new banco($conn, $db);


$sql = "SELECT parambiente,parversao,parcodigos,ctesegnome,ctesegapolice,cterntrc,cteperservico FROM  parametros";
$sql = $sql . " WHERE parcod = '$parametro'";


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
        $parcodigos = pg_fetch_result($sql, $i, "parcodigos");
        $parambiente = pg_fetch_result($sql, $i, "parambiente");
        $parversao = pg_fetch_result($sql, $i, "parversao");
        $ctesegnome = pg_fetch_result($sql, $i, "ctesegnome");
        $ctesegapolice = pg_fetch_result($sql, $i, "ctesegapolice");
        $cterntrc = pg_fetch_result($sql, $i, "cterntrc");
        $cteperservico = pg_fetch_result($sql, $i, "cteperservico");

        if (trim($parcodigos) == "") {
            $parcodigos = "0";
        }
        if (trim($parambiente) == "") {
            $parambiente = "0";
        }
        if (trim($parversao) == "") {
            $parversao = "0";
        }
        if (trim($ctesegnome) == "") {
            $ctesegnome = "0";
        }
        if (trim($ctesegapolice) == "") {
            $ctesegapolice = "0";
        }
        if (trim($cterntrc) == "") {
            $cterntrc = "0";
        }
        if (trim($cteperservico) == "") {
            $cteperservico = "0";
        }

        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $parcodigos . "</codigo>\n";
        $xml .= "<descricao>" . $parambiente . "</descricao>\n";
        $xml .= "<descricao2>" . $parversao . "</descricao2>\n";
        $xml .= "<descricao3>" . $ctesegnome . "</descricao3>\n";
        $xml .= "<descricao4>" . $ctesegapolice . "</descricao4>\n";
        $xml .= "<descricao5>" . $cterntrc . "</descricao5>\n";
        $xml .= "<descricao6>" . $cteperservico . "</descricao6>\n";

        $xml .= "</dado>\n";

        //Inclui na Tabela Temporaria o seguro
        $usucodigo = $parametro2;
        $codservico = '0';
        $servico = $ctesegnome;
        $valor = '0';
        $grupo = '5';
        $apolice = $ctesegapolice;
        $averbacao = '';

        $cadastro = new banco($conn, $db);

        $cadastro->insere("infoseguro", "(usucodigo,segnome,segvalor,rescodigo,segapolice,segaverbacao)", "('$usucodigo','$servico','$valor','$grupo','$apolice','$averbacao')");
    }//FECHA FOR
    $xml .= "</dados>\n";

    //CABEÇALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>