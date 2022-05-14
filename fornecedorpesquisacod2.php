<?php
/**
* Pesquisa de Fornecedores
*
* Programa que busca dados do Fornecedor na Base de Dados 
* a partir do Codigo Interno e retorna um XML com os dados
*
* @name Fornecedor Search
* @link fornecedorpesquisacod2.php
* @version 50.3.6
* @since 1.0.0
* @author Luis Ramires <delta.mais@uol.com.br>
* @copyright MaxTrade
* @global integer $_POST["parametro"] Codigo Interno do Fornecedor
*/
                 
$parametro = trim($_POST["parametro"]);

require_once("include/conexao.inc.php");

$sql = "
	SELECT forcodigo as cod,forcod as codigo,forrazao as descricao,fornguerra as descricao2
        FROM  fornecedor 
	WHERE forcodigo = '$parametro'
        ";


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
        $cod = pg_fetch_result($sql, $i, "cod");
        $codigo = pg_fetch_result($sql, $i, "codigo");
        $descricao = pg_fetch_result($sql, $i, "descricao");
        $descricao2 = pg_fetch_result($sql, $i, "descricao2");
        $xml .= "<dado>\n";
        $xml .= "<cod>" . $cod . "</cod>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao>" . $descricao . "</descricao>\n";
        $xml .= "<descricao2>" . $descricao2 . "</descricao2>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO  
echo $xml;

