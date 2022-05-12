<?php

require_once("include/conexao.inc.php");
require_once("include/banco.php");

$cadastro = new banco($conn, $db);

$usucodigo = $_GET["usucodigo"];

$sql = "select a.infveicodigo,a.veicod,a.veirenavam,a.veiplaca,a.veiuf,b.tpvnome from infoveiculos a,tipopropveiculo b  
where a.veipropveiculo=b.tpvcodigo and a.usucodigo=$usucodigo order by a.infveicodigo";

$sql = pg_query($sql);
$row = pg_num_rows($sql);

//VERIFICA SE VOLTOU ALGO
if ($row) {

    header("Content-type: application/xml");

    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

    $xml .= "<dados>";
    $xml .= "<cabecalho>";
    $xml .= "<campo>codigo</campo>";
    $xml .= "<campo>placa</campo>";
    $xml .= "<campo>renavan</campo>";
    $xml .= "<campo>uf</campo>";
    $xml .= "<campo>cod</campo>";
    $xml .= "<campo>prop</campo>";
    $xml .= "</cabecalho>";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {

        $codigo = pg_fetch_result($sql, $i, "infveicodigo");
        $placa = pg_fetch_result($sql, $i, "veiplaca");
        $renavan = pg_fetch_result($sql, $i, "veirenavam");
        $uf = pg_fetch_result($sql, $i, "veiuf");
        $cod = pg_fetch_result($sql, $i, "veicod");
        $prop = pg_fetch_result($sql, $i, "tpvnome");

        if (trim($codigo) == "") {
            $codigo = "0";
        }
        if (trim($placa) == "") {
            $placa = "_";
        }
        if (trim($renavan) == "") {
            $renavan = "_";
        }
        if (trim($uf) == "") {
            $uf = "_";
        }
        if (trim($cod) == "") {
            $cod = "_";
        }
        if (trim($prop) == "") {
            $prop = "_";
        }

        $xml .= "<registro>";
        $xml .= "<item>" . $codigo . "</item>";
        $xml .= "<item>" . $placa . "</item>";
        $xml .= "<item>" . $renavan . "</item>";
        $xml .= "<item>" . $uf . "</item>";
        $xml .= "<item>" . $cod . "</item>";
        $xml .= "<item>" . $prop . "</item>";
        $xml .= "</registro>";
    }//FECHA FOR

    $xml .= "</dados>";
}

echo $xml;
pg_close($conn);
exit();
?>