<?php

require_once("include/conexao.inc.php");
require_once("include/transportador.php");

$tracodigo = trim($_GET["tracodigo"]);
$tranguerra = trim($_GET["tranguerra"]);
$tradatasul = trim($_GET["tradatasul"]);
$trarazao = trim($_GET["trarazao"]);
$tracep = trim($_GET["tracep"]);
$traendereco = trim($_GET["traendereco"]);
$trabairro = trim($_GET["trabairro"]);
$trafone = trim($_GET["trafone"]);
$trafax = trim($_GET["trafax"]);
$traemail = trim($_GET["traemail"]);
$traobs = trim($_GET["traobs"]);
$tracodcidade = trim($_GET["tracodcidade"]);
$rotcodigo = trim($_GET["rotcodigo"]);
$tpfcodigo = trim($_GET["tpfcodigo"]);
$traretirada = trim($_GET["traretirada"]);

$tracnpj = trim($_GET["tracnpj"]);
$traie = trim($_GET["traie"]);

$doccobvers = preg_match("/[0-9]+/", $_GET["doccob"]) ? trim(str_replace(",", ".", $_GET["doccob"])) : '0.0';
$ocorenvers = preg_match("/[0-9]+/", $_GET["ocoren"]) ? trim(str_replace(",", ".", $_GET["ocoren"])) : '0.0';
$conembvers = preg_match("/[0-9]+/", $_GET["conemb"]) ? trim(str_replace(",", ".", $_GET["conemb"])) : '0.0';
$notfisvers = preg_match("/[0-9]+/", $_GET["notfis"]) ? trim(str_replace(",", ".", $_GET["notfis"])) : '0.0';
$diredi = strtolower(trim($_GET["tracaminho"]));

if (isset($_GET["contato"])) {
    $contato = $_GET["contato"];
    $contatoemail = $_GET["contatoemail"];
    $contatocargo = $_GET["contatocargo"];
} else {
    $contato = [];
    $contatoemail = [];
    $contatocargo = [];
}

$tratptolera = trim($_GET['tratptolera']);
$tratolera = trim($_GET['tratolera']);

if ($tratptolera == "") {
    $tratptolera = 1;
}
if ($tratolera == "") {
    $tratolera = 0;
}

$dia = date('d');
$mes = date('m');
$ano = date('Y');
$atual = date("Y-m-d H:i:s") . '-03';
$atualSemGMT = date("Y-m-d H:i:s");


$cadastro = new banco($conn, $db);
$cadastro->altera("transportador", "tranguerra='$tranguerra',trarazao='$trarazao',tracep='$tracep',
        traendereco='$traendereco',trabairro='$trabairro',trafone='$trafone',trafax='$trafax',tpfcodigo='$tpfcodigo',
        traemail='$traemail',traobs='$traobs', cidcodigo='$tracodcidade',rotcodigo='$rotcodigo',tracnpj='$tracnpj',traie='$traie',
        doccobvers = '$doccobvers', ocorenvers = '$ocorenvers', conembvers = '$conembvers', notfisvers = '$notfisvers',
        diredi = '$diredi', dtalt = '$atualSemGMT', datcodigo = '$tradatasul', traretirada = '$traretirada', tratptolera = '$tratptolera', tratolera = '$tratolera'"
        , "$tracodigo");

$sql2 = "Delete from transportadorcontato where tracodigo = '$tracodigo'";
pg_query($sql2);

if (sizeof($contato) > 0) {
    for ($i = 0; $i < sizeof($contato); $i++) {
        if (trim($contato[$i]) != '') {

            $cont = trim($contato[$i]);
            $mail = trim($contatoemail[$i]);
            $carg = trim($contatocargo[$i]);

            $cadastro->insere("transportadorcontato", "(
			tracodigo,tranome,traemail,tracargo)", "('$tracodigo','$cont','$mail','$carg')");
        }
    }
}


pg_close($conn);
exit();
?>
