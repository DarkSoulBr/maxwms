<?php
/**
* Pesquisa Custo e IPI de Produtos 
*
* Programa que busca o Custo e o Percentual de IPI na Base de Dados
* e retorna um XML com os dados de Custo e IPI do Item
*
* @name Custo Search
* @link pedcomprapesquisacusto.php
* @version 50.3.6
* @since 1.0.0
* @author Luis Ramires <delta.mais@uol.com.br>
* @copyright MaxTrade
*
* @global string $_POST["parametro"] Campo a ser pesquisado
* @global integer $_POST["parametro2"] Tipo de Pesquisa (1 Codigo, 2 ID, 3 Nome)
*/


require('./_app/Config.inc.php');

$parametro = trim($_POST["parametro"]);
$parametro2 = trim($_POST["parametro2"]);

if ($parametro2 == 1) {
    $sql = "SELECT procodigo as cod,procod as codigo,prnome as descricao,profinal,proipi,0 as probruto FROM produto WHERE procod = '$parametro'";
} else if ($parametro2 == 2) {
    $sql = "SELECT procodigo as cod,procod as codigo,prnome as descricao,profinal,proipi,0 as probruto FROM produto WHERE procodigo = '$parametro'";
} else {
    $sql = "SELECT procodigo as cod,procod as codigo,prnome as descricao,profinal,proipi,0 as probruto FROM produto WHERE prnome LIKE '%$parametro%' ORDER BY prnome";
}

$read = new Read;
$read->FullRead($sql);

if ($read->getRowCount() >= 1) {

    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    foreach ($read->getResult() as $registros) {
        extract($registros);

        if ($probruto > 0) {
            $profinal = $probruto;
        }

        if ($proipi == '') {
            $proipi = 0;
        }

        $xml .= "<dado>\n";
        $xml .= "<cod>" . $cod . "</cod>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao>" . $descricao . "</descricao>\n";
        $xml .= "<profinal>" . $profinal . "</profinal>\n";
        $xml .= "<proipi>" . $proipi . "</proipi>\n";
        $xml .= "</dado>\n";
    }
    $xml .= "</dados>\n";
    Header("Content-type: application/xml; charset=iso-8859-1");
}
echo $xml;
