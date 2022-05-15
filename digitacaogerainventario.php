<?php

require_once("include/conexao.inc.php");
require_once("include/digitacaoinventario.php");

header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

$registros = new banco($conn, $db);

$flag = $_GET['flag'];

if ($flag == "Datainv") {
    $estoque = $_GET['estoque'];
    $query = $registros->seleciona("max(invdata) as invdata", "inventario", "estcodigo=$estoque LIMIT 1");
    $array = pg_fetch_object($query);

    $aux = explode(" ", $array->invdata);
    $aux2 = explode("-", $aux[0]);
    $dataaux = $aux2[2] . '/' . $aux2[1] . '/' . $aux2[0];

    $xml .= "<dadosdata>";
    $xml .= "<registrodata>";
    $xml .= "<itemdata>" . $dataaux . "</itemdata>";
    $xml .= "</registrodata>";
    $xml .= "</dadosdata>";
}

if ($flag == "Produto") {
    $opcao = $_GET['opcao'];
    $nome = $_GET['nome'];
    $estoque = $_GET['estoque'];

    if ($opcao == '1') {
        $strorder = "cbarras.barunidade";
        $where = "cbarras.barunidade like '" . $nome . "%'";
    } else if ($opcao == '2') {
        $strorder = "produto.procod";
        $where = "produto.procod like '" . $nome . "'";
    } else if ($opcao == '3') {
        $strorder = "produto.prnome";
        $where = "produto.prnome like '%" . $nome . "%'";
    }

    $query = $registros->seleciona("distinct produto.procod as codigo,produto.prnome as nome,cbarras.barunidade as barras, inventario.procodigo as procodigo", "produto left join inventario on inventario.procodigo=produto.procodigo left join cbarras on produto.procodigo=cbarras.procodigo", "$where and inventario.estcodigo=$estoque order by $strorder asc");

    $row = pg_num_rows($query);
    $xml .= "<dadosprod>";
    if ($row > 0) {
        for ($i = 0; $i < $row; $i++) {
            $array = pg_fetch_object($query);

            $xml .= "<registroprod>";

            $xml .= "<itemprod>" . $array->procodigo . "</itemprod>";

            if ($opcao == '1') {
                $xml .= "<itemprod>" . $array->barras . "</itemprod>";
            }

            if ($opcao == '2') {
                $xml .= "<itemprod>" . $array->codigo . "</itemprod>";
            }

            if ($opcao == '3') {
                $xml .= "<itemprod>" . $array->nome . "</itemprod>";
            }
            $xml .= "</registroprod>";
        }
    }
    $xml .= "</dadosprod>";
}

if ($flag == "Listarinventario") {
    $codigo = $_GET['nome'];
    $estoque = $_GET['estoque'];
    $datainv = $_GET['datainv'];

    $aux = explode("/", $datainv);
    $datainv = $aux[2] . '-' . $aux[1] . '-' . $aux[0] . ' 00:00:00-03';

    $query = $registros->seleciona("inventario.invantigo as antigo,inventario.invatual as atual,inventario.invcodigo as invcodigo,produto.procod as codigo,produto.prnome as nome", "inventario left join produto on inventario.procodigo=produto.procodigo", "inventario.procodigo=$codigo and inventario.estcodigo=$estoque and inventario.invdata='$datainv' order by inventario.invcodigo asc");

    $row = pg_num_rows($query);
    if ($row > 0) {
        $xml .= "<dadosinv>";
        for ($i = 0; $i < $row; $i++) {
            $array = pg_fetch_object($query);

            if ($array->antigo == "")
                $array->antigo = "0";

            if ($array->atual == "")
                $array->atual = "0";

            $xml .= "<registroinv>";

            $xml .= "<iteminv>" . $array->codigo . "</iteminv>";
            $xml .= "<iteminv>" . $array->nome . "</iteminv>";
            $xml .= "<iteminv>" . $array->antigo . "</iteminv>";
            $xml .= "<iteminv>" . $array->invcodigo . "</iteminv>";
            $xml .= "<iteminv>" . $array->atual . "</iteminv>";

            $xml .= "</registroinv>";
        }
        $xml .= "</dadosinv>";
    }
}

if ($flag == "Alterarinventario") {
    $invatual = $_GET['invatual'];
    $invcodigo = $_GET['invcodigo'];

    $registros->altera("inventario", "invatual=$invatual", "invcodigo=$invcodigo");

    $xml .= "<dadosalterar>";
    $xml .= "<registroalterar>";
    $xml .= "<itemalterar>OK</itemalterar>";
    $xml .= "</registroalterar>";
    $xml .= "</dadosalterar>";
}

echo $xml;
pg_close($conn);
exit();
?>