<?php

require_once ( "include/conexao.inc.php" );
require_once ( "include/banco.php" );

$atual = date("Y-m-d");

$veicodint = trim($_POST ["veicodint"]);
$veirenavam = trim($_POST ["veirenavam"]);
$veiplaca = trim($_POST ["veiplaca"]);
$veitara = trim($_POST ["veitara"]);
$veicapacidadekg = trim($_POST ["veicapacidadekg"]);
$veicapacidademt = trim($_POST ["veicapacidademt"]);
$veitiporodado = trim($_POST ["veitiporodado"]);
$veitipocarroceria = trim($_POST ["veitipocarroceria"]);
$veitipoveiculo = trim($_POST ["veitipoveiculo"]);
$veitipopropveiculo = trim($_POST ["veitipopropveiculo"]);
$listestados = trim($_POST ["listestados"]);
$veicnpj = trim($_POST ["veicnpj"]);
$veiie = trim($_POST ["veiie"]);
$veicpf = trim($_POST ["veicpf"]);
$veirg = trim($_POST ["veirg"]);
$veirntrc = trim($_POST ["veirntrc"]);
$veitipproprietario = trim($_POST ["veitipproprietario"]);
$listestados2 = trim($_POST ["listestados2"]);
$veirazao = trim($_POST ["veirazao"]);
$veipessoa = trim($_POST ["veipessoa"]);
$veiempresa = trim($_POST ["veiempresa"]);

if ($veicodint == "") {
    $veicodint = 0;
}
if ($veitara == "") {
    $veitara = 0;
}
if ($veicapacidadekg == "") {
    $veicapacidadekg = 0;
}
if ($veicapacidademt == "") {
    $veicapacidademt = 0;
}


$cadastro = new banco($conn, $db);

$sql = "SELECT max(a.veicodigo) as codigo FROM veiculoscte a";
$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {
    $codigo = (pg_fetch_result($sql, 0, "codigo") + 1);
}


$cadastro->insere("veiculoscte", "(veicodigo,veicod,veirenavam,veiplaca,veitara,veicapacidadekg,veicapacidadem3,veitprodado,veitpcarroceria,veitpveiculo,veipropveiculo,veiuf,veicnpj,veiie,veicpf,veirg,veirntrc,veitpproprietario,veipropuf,veirazao,veipessoa,veiempresa)",
        "($codigo,'$veicodint','$veirenavam','$veiplaca',$veitara,$veicapacidadekg,$veicapacidademt,$veitiporodado,$veitipocarroceria,$veitipoveiculo,$veitipopropveiculo,'$listestados','$veicnpj','$veiie','$veicpf','$veirg','$veirntrc',$veitipproprietario,'$listestados2','$veirazao','$veipessoa','$veiempresa')");


$j = 0;
for ($i = 0; $i < 2; $i++) {
    $sql = "
    SELECT veicodigo From veiculoscte 
    Where veicodigo = $codigo";

    $sql = pg_query($sql);
    $row = pg_num_rows($sql);
    $i = 0;
    $j++;
    if ($row) {
        $i = 2;
    }
}



pg_close($conn);

$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
$xml .= "<dados>\n";
$xml .= "<dado>\n";
$xml .= "<veicod>" . $codigo . "</veicod>\n";
$xml .= "</dado>\n";
$xml .= "</dados>\n";

Header("Content-type: application/xml; charset=iso-8859-1");

echo $xml;

//exit ( );
?>