<?php

require_once("include/conexao.inc.php");
require_once("include/banco.php");

$cadastro = new banco($conn, $db);

$codigo = $_GET["parametro"];

$sql = "select colcodigo,colserie,colnumero,colemissao,colcnpj,colie,coluf,colfone,colinterno from infocoleta 
where colcodigo=$codigo order by colcodigo";

$sql = pg_query($sql);
$row = pg_num_rows($sql);

//VERIFICA SE VOLTOU ALGO
if ($row) {

    header("Content-type: application/xml");

    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

    $xml .= "<dados>";
    $xml .= "<cabecalho>";
    $xml .= "<campo>codigo</campo>";
    $xml .= "<campo>serie</campo>";
    $xml .= "<campo>numero</campo>";
    $xml .= "<campo>emissao</campo>";
    $xml .= "<campo>cnpj</campo>";
    $xml .= "<campo>ie</campo>";
    $xml .= "<campo>uf</campo>";
    $xml .= "<campo>fone</campo>";
    $xml .= "<campo>interno</campo>";
    $xml .= "</cabecalho>";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {

        $codigo = pg_fetch_result($sql, $i, "colcodigo");
        $serie = pg_fetch_result($sql, $i, "colserie");
        $numero = pg_fetch_result($sql, $i, "colnumero");
        $emissao = pg_fetch_result($sql, $i, "colemissao");
        $cnpj = pg_fetch_result($sql, $i, "colcnpj");
        $ie = pg_fetch_result($sql, $i, "colie");
        $uf = pg_fetch_result($sql, $i, "coluf");
        $fone = pg_fetch_result($sql, $i, "colfone");
        $interno = pg_fetch_result($sql, $i, "colinterno");

        if ($emissao != '') {
            $emissao = substr($emissao, 8, 2) . '/' . substr($emissao, 5, 2) . '/' . substr($emissao, 0, 4);
        }

        if (trim($codigo) == "") {
            $codigo = "0";
        }
        if (trim($serie) == "") {
            $serie = "_";
        }
        if (trim($numero) == "") {
            $numero = "_";
        }
        if (trim($emissao) == "") {
            $emissao = "_";
        }
        if (trim($cnpj) == "") {
            $cnpj = "_";
        }
        if (trim($ie) == "") {
            $ie = "_";
        }
        if (trim($uf) == "") {
            $uf = "_";
        }
        if (trim($fone) == "") {
            $fone = "_";
        }
        if (trim($interno) == "") {
            $interno = "_";
        }

        $xml .= "<registro>";
        $xml .= "<item>" . $codigo . "</item>";
        $xml .= "<item>" . $serie . "</item>";
        $xml .= "<item>" . $numero . "</item>";
        $xml .= "<item>" . $emissao . "</item>";
        $xml .= "<item>" . $cnpj . "</item>";
        $xml .= "<item>" . $ie . "</item>";
        $xml .= "<item>" . $uf . "</item>";
        $xml .= "<item>" . $fone . "</item>";
        $xml .= "<item>" . $interno . "</item>";
        $xml .= "</registro>";
    }//FECHA FOR

    $xml .= "</dados>";
}

echo $xml;
pg_close($conn);
exit();
?>