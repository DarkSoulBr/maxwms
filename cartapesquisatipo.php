<?php

$parametro = trim($_POST["parametro"]);

require_once("include/conexao.inc.php");

$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
$xml .= "<dados>\n";

if ($parametro) {
    $sql = "
	SELECT a.* 
        FROM campos a 
	WHERE a.ccecodigo = '$parametro'
	ORDER BY a.ccenome";
} else {
    $sql = " 

	SELECT a.* 
        FROM campos a 
	ORDER BY a.ccenome";

    $codigo = 0;
    $descricao = 'EM BRANCO';
    $xml .= "<dado>\n";
    $xml .= "<codigo>" . $codigo . "</codigo>\n";
    $xml .= "<descricao>" . $descricao . "</descricao>\n";
    $xml .= "<grupo>_</grupo>\n";
    $xml .= "<campo>_</campo>\n";
    $xml .= "<item>_</item>\n";
    $xml .= "</dado>\n";
}

$sql = pg_query($sql);

$row = pg_num_rows($sql);

if ($row) {

    for ($i = 0; $i < $row; $i++) {
        $codigo = pg_fetch_result($sql, $i, "ccecodigo");
        $descricao = pg_fetch_result($sql, $i, "ccenome");
        $grupo = pg_fetch_result($sql, $i, "ccegrupo");
        $campo = pg_fetch_result($sql, $i, "ccecampo");
        $item = pg_fetch_result($sql, $i, "cceitem");
        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao>" . $descricao . "</descricao>\n";
        $xml .= "<grupo>" . $grupo . "</grupo>\n";
        $xml .= "<campo>" . $campo . "</campo>\n";
        $xml .= "<item>" . $item . "</item>\n";
        $xml .= "</dado>\n";
    }
}

$xml .= "</dados>\n";

Header("Content-type: application/xml; charset=iso-8859-1");
echo $xml;

