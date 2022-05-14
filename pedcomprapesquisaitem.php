<?php
/**
 * Pesquisa Dados de Produtos 
 *
 * Programa que busca Referencia, Validacao e Status do Produto na 
 * Base de Dados e retorna um XML com os dados Referencia, Validacao e Status 
 *
 * @name Produto Search
 * @link pedcomprapesquisaitem.php
 * @version 50.3.6
 * @since 1.0.0
 * @author Luis Ramires <delta.mais@uol.com.br>
 * @copyright MaxTrade
 *
 * @global string $_POST["parametro"] Codigo do Produto
 */
require_once("include/conexao.inc.php");

$parametro = trim($_POST["parametro"]);

$sql = "SELECT b.forcod,a.proref,a.provalida,a.stpcodigo    
  FROM  produto a,fornecedor b Where 
  a.procod = '$parametro'
  and a.forcodigo = b.forcodigo  
  ";

$sql = pg_query($sql);

$row = pg_num_rows($sql);

if ($row) {

    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {

        $forcod = pg_fetch_result($sql, $i, "forcod");
        $proref = pg_fetch_result($sql, $i, "proref");
        $provalida = pg_fetch_result($sql, $i, "provalida");
        $stpcodigo = (int) pg_fetch_result($sql, $i, "stpcodigo");

        if ($provalida == '') {
            $provalida = 0;
        }

        $xml .= "<dado>\n";
        $xml .= "<forcod>" . $forcod . "</forcod>\n";
        $xml .= "<proref>" . $proref . "</proref>\n";
        $xml .= "<provalida>" . $provalida . "</provalida>\n";
        $xml .= "<stpcodigo>" . $stpcodigo . "</stpcodigo>\n";
        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABECALHO

    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;

