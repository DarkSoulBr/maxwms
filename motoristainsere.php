<?php

require_once ( "include/conexao.inc.php" );
require_once ( "include/banco.php" );

$atual = date("Y-m-d");

$forcod = trim($_POST ["forcod"]);
$forrazao = trim($_POST ["forrazao"]);
$forcpf = trim($_POST ["forcpf"]);

$cadastro = new banco($conn, $db);

$sql = "SELECT max(a.motcod) as codigo FROM motoristas a";
$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {
    $codigo = (pg_fetch_result($sql, 0, "codigo") + 1);
    $forcod = $codigo;
}

$cadastro->insere("motoristas", "(motcod,motrazao,motcpf,motinc)", "('$forcod','$forrazao','$forcpf','$atual')");

$j = 0;
for ($i = 0; $i < 2; $i++) {
    $sql = "
    SELECT motcodigo From motoristas 
    Where motcod = $forcod";

    $sql = pg_query($sql);
    $row = pg_num_rows($sql);
    $i = 0;
    $j++;
    if ($row) {
        $i = 2;
    }
}

$forcodigo = pg_fetch_result($sql, "0", "motcodigo");

pg_close($conn);

$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
$xml .= "<dados>\n";
$xml .= "<dado>\n";
$xml .= "<forcod>" . $forcod . "</forcod>\n";
$xml .= "</dado>\n";
$xml .= "</dados>\n";

Header("Content-type: application/xml; charset=iso-8859-1");

echo $xml;

//exit ( );
?>