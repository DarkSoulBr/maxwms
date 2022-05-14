<?php
/**
 * Pesquisa Pedido de Venda 
 *
 * Programa que verifica a existencia do pedido de venda na Base de Dados 
 * e retorna um XML com o numero do pedido ou com um N de nao encontrado
 *
 * @name Venda Search
 * @link pedcomprapesquisavenda.php
 * @version 50.3.6
 * @since 1.0.0
 * @author Luis Ramires <delta.mais@uol.com.br>
 * @copyright MaxTrade
 *
 * @global integer $_POST["parametro"] Numero do Pedido de Venda
 */

require_once("include/conexao.inc.php");

$parametro = trim($_POST["parametro"]);

$sql = "SELECT
  a.pvnumero
  FROM  pvenda a
  Where a.pvnumero = '$parametro'";

//EXECUTA A QUERY
$sql = pg_query($sql);

$row = pg_num_rows($sql);

if ($row) {

    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {

        $pvnumero = pg_fetch_result($sql, $i, "pvnumero");

        if (trim($pvnumero) == "") {
            $pvnumero = "0";
        }


        $xml .= "<dado>\n";
        $xml .= "<pvnumero>" . $pvnumero . "</pvnumero>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABECALHO

    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
else {

    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";
    $xml .= "<dado>\n";
    $xml .= "<pvnumero>N</pvnumero>\n";
    $xml .= "</dado>\n";
    $xml .= "</dados>\n";
    Header("Content-type: application/xml; charset=iso-8859-1");
}


//PRINTA O RESULTADO
echo $xml;

