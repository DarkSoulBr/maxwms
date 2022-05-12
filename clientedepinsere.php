<?php

require_once ( "include/conexao.inc.php" );
require_once ( "include/banco.php" );

$atual = date("Y-m-d");
$fornguerra = trim($_POST ["fornguerra"]);
$forcod = trim($_POST ["forcod"]);
$forrazao = trim($_POST ["forrazao"]);
$forsuframa = trim($_POST ["forsuframa"]);
$forcnpj = trim($_POST ["forcnpj"]);
$forie = trim($_POST ["forie"]);
$forrg = trim($_POST ["forrg"]);
$forcpf = trim($_POST ["forcpf"]);
$forobs = trim($_POST ["forobs"]);

$forpessoa = trim($_POST ["forpessoa"]);
$fnecep = trim($_POST ["fnecep"]);
$fneendereco = trim($_POST ["fneendereco"]);
$fnecomplemento = trim($_POST ["fnecomplemento"]);
$fnebairro = trim($_POST ["fnebairro"]);
$fnefone = trim($_POST ["fnefone"]);
$fneemail = trim($_POST ["fneemail"]);
$fnecodcidade = trim($_POST ["fnecodcidade"]);
$cidadeibge = trim($_POST ["cidcodigoibge"]);
$fnenumero = trim($_POST ["fnenumero"]);
$fornfe = trim($_POST ["fornfe"]);
if ($fornfe == '') {
    $fornfe = 0;
}

$cadastro = new banco($conn, $db);

$sql = "SELECT max(a.clicod) as codigo FROM clientesdep a";
$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {
    $codigo = (pg_fetch_result($sql, 0, "codigo") + 1);
    $forcod = $codigo;
}

$cadastro->insere("clientesdep", "(clinguerra,clicod,clirazao,clisuframa,clicnpj,cliie,clirg,clicpf,cliobs,clipessoa,cliinc,clicep,cliendereco,clibairro,clifone,clicomplemento,cliemail,cidcodigo,clinumero,cidcodigoibge,clinfe)", "('$fornguerra','$forcod','$forrazao','$forsuframa','$forcnpj','$forie','$forrg','$forcpf','$forobs','$forpessoa','$atual','$fnecep','$fneendereco','$fnebairro','$fnefone','$fnecomplemento','$fneemail','$fnecodcidade','$fnenumero','$cidadeibge','$fornfe')");

$j = 0;
for ($i = 0; $i < 2; $i++) {
    $sql = "
    SELECT clicodigo From clientesdep 
    Where clicod = $forcod";

    $sql = pg_query($sql);
    $row = pg_num_rows($sql);
    $i = 0;
    $j++;
    if ($row) {
        $i = 2;
    }
}

$forcodigo = pg_fetch_result($sql, "0", "clicodigo");

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