<?php
/**
* Pesquisa de Codigo Interno Fornecedor
*
* Programa que busca o Codigo Interno do Fornecedor na Base de Dados 
* a partir do Codigo e retorna um XML com o Código Interno do Fornecedor
*
* @name Fornecedor Search
* @link fornecedorpesquisacodigo.php
* @version 50.3.6
* @since 1.0.0
* @author Luis Ramires <delta.mais@uol.com.br>
* @copyright MaxTrade
*
* @global integer $_POST['parametro'] Código do Fornecedor 
*/

//RECEBE PARAMETRO                     
$parametro = trim($_POST["parametro"]);

require_once("include/conexao.inc.php");

$sql = "
	SELECT forcodigo as cod,forcod as codigo,forrazao as descricao
        FROM  fornecedor 
	WHERE forcod = '$parametro'
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
        $xml .= "<dado>\n";
        $xml .= "<cod>" . $cod . "</cod>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao>" . $descricao . "</descricao>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABECALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO  
echo $xml;
?>
