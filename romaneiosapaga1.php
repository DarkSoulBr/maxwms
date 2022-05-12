<?php

require_once("include/conexao.inc.php");
require_once("include/romaneios.php");

$romcodigo = $_GET["romcodigo"];

$usucodigo = $_GET["usucodigo"];
if ($usucodigo == '') {
    $usucodigo = 0;
}

$cadastro = new banco($conn, $db);

$sql = "SELECT pvnumero FROM romaneiospedidos WHERE romcodigo = {$romcodigo}";
$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {

    for ($i = 0; $i < $row; $i++) {
        $pvnumero = pg_fetch_result($sql, $i, "pvnumero");

        $dataLog = date('Y-m-d H:i:s');
        $cadastro->insere("logromaneiosgeral", "(lgrdata,usucodigo,romcodigo,pvnumero,operacao)", "('$dataLog','$usucodigo','$romcodigo','$pvnumero',12)");
    }
}


$cadastro->apaga1("romaneiospedidos", "$romcodigo");


pg_close($conn);
exit();
?>
