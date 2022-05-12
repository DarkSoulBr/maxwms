<?php

require_once("include/conexao.inc.php");
require_once("include/romaneios.php");

$romcodigo = $_GET["romcodigo"];
$usucodigo = $_GET["usuario"];
if($usucodigo=='') {
    $usucodigo = 0;
}

$cadastro = new banco($conn, $db);

$sql = "SELECT romnumero,romano FROM romaneios WHERE romcodigo = '$romcodigo'";
$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {
    $romnumero = trim(pg_fetch_result($sql, 0, "romnumero"));
    $romano = trim(pg_fetch_result($sql, 0, "romano"));
    if (trim($romnumero) == "") {
        $romnumero = "0";
    }
    if (trim($romano) == "") {
        $romano = "0";
    }
}

$dataLog = date('Y-m-d H:i:s');
$cadastro->insere("logromaneiosgeral", "(lgrdata,usucodigo,romcodigo,operacao)", "('$dataLog','$usucodigo','$romcodigo',5)");

$sql = "SELECT pvnumero FROM romaneiospedidos WHERE romcodigo = {$romcodigo}";
$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {

    for ($i = 0; $i < $row; $i++) {
        $pvnumero = pg_fetch_result($sql, $i, "pvnumero");

        $dataLog = date('Y-m-d H:i:s');
        $cadastro->insere("logromaneiosgeral", "(lgrdata,usucodigo,romcodigo,pvnumero,operacao)", "('$dataLog','$usucodigo','$romcodigo','$pvnumero',15)");
    }
}

$cadastro->apaga1("romaneios", "$romcodigo");
$cadastro->apaga1("romaneiospedidos", "$romcodigo");


pg_close($conn);

exit();
?>
