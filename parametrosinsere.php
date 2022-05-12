<?php

require_once ( "include/conexao.inc.php" );
require_once ( "include/banco.php" );

$parambiente = trim($_POST ["parambiente"]);
$parversao = trim($_POST ["parversao"]);
$servico = trim($_POST ["servico"]);
$apolice = trim($_POST ["apolice"]);
$gerrntrc = trim($_POST ["gerrntrc"]);
$perc = trim($_POST ["perc"]);
if ($perc == '') {
    $perc = 0;
}

$versaocte = trim($_POST ["versaocte"]);
$assinacte = trim($_POST ["assinacte"]);

$cadastro = new banco($conn, $db);

$sql = "DELETE FROM parametros";
pg_query($sql);

$sql = "SELECT max(parcod) as codigo FROM parametros a";
$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {
    $codigo = (pg_fetch_result($sql, 0, "codigo") + 1);
}

//$cadastro -> insere ( "parametros" , "(parcod,parambiente,parversao,ctesegnome,ctesegapolice,cterntrc,cteperservico,ctelayoutversao)" , "('$codigo','$parambiente','$parversao','$servico','$apolice','$gerrntrc','$perc','$versaocte')" );
$cadastro->insere("parametros", "(parcod,parambiente,parversao,ctesegnome,ctesegapolice,cterntrc,cteperservico,ctelayoutversao,cteassinatura)", "('$codigo','$parambiente','$parversao','$servico','$apolice','$gerrntrc','$perc','$versaocte','$assinacte')");

$j = 0;
for ($i = 0; $i < 2; $i++) {
    $sql = "
    SELECT parcodigos From parametros 
    Where parcod = $codigo";

    $sql = pg_query($sql);
    $row = pg_num_rows($sql);
    $i = 0;
    $j++;
    if ($row) {
        $i = 2;
    }
}

$parcodigos = pg_fetch_result($sql, "0", "parcodigos");

pg_close($conn);

$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
$xml .= "<dados>\n";
$xml .= "<dado>\n";
$xml .= "<codigo>" . $parcodigos . "</codigo>\n";
$xml .= "</dado>\n";
$xml .= "</dados>\n";

Header("Content-type: application/xml; charset=iso-8859-1");

echo $xml;

//exit ( );
?>