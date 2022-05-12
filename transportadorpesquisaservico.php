<?php

require_once("include/conexao.inc.php");

$parametro = (int) trim($_POST["parametro"]);


if (($parametro) != 0) {
    $sql = "SELECT a.tpfcodigo,a.tpfnome
        FROM  tpfrete a 
        WHERE a.tpfcodigo = {$parametro}
	ORDER BY a.tpfcodigo";
} else {
    $sql = "SELECT a.tpfcodigo,a.tpfnome
        FROM  tpfrete a 
	ORDER BY a.tpfcodigo";
}
            
$sql = pg_query($sql);
$row = pg_num_rows($sql);

if ($row) {
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";         
    for ($i = 0; $i < $row; $i++) {
        $codigo = pg_fetch_result($sql, $i, "tpfcodigo");
        $descricao = pg_fetch_result($sql, $i, "tpfnome");
        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao>" . $descricao . "</descricao>\n";
        $xml .= "</dado>\n";
    }
    $xml .= "</dados>\n";
    Header("Content-type: application/xml; charset=iso-8859-1");
}                                           

echo $xml;

