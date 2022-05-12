<?php

require_once("include/conexao.inc.php");
require_once("include/transportador.php");

$tranguerra = trim($_GET["tranguerra"]);
$trarazao = trim($_GET["trarazao"]);
$tradatasul = trim($_GET["tradatasul"]);
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

$cadastro = new banco($conn, $db);

$sql = "SELECT max(tracodigo) as codigo FROM transportador";

$sql = pg_query($sql);

$row = pg_num_rows($sql);

$codigo = (pg_fetch_result($sql, 0, "codigo") + 1);

if ($tradatasul == '' || $tradatasul == '0') {
    $tradatasul = $codigo;
}

$dia = date('d');
$mes = date('m');
$ano = date('Y');
$atual = date("Y-m-d H:i:s") . '-03';
$atualSemGMT = date("Y-m-d H:i:s");


$cadastro->insere("transportador",
        "(tranguerra,trarazao,tracep,traendereco,trabairro,trafone,trafax,traemail,traobs,cidcodigo,tracodigo,rotcodigo,tpfcodigo,tracnpj,traie,doccobvers,ocorenvers,conembvers,notfisvers,diredi,dtinc,dtalt,datcodigo,traretirada,tratptolera,tratolera)",
        "('$tranguerra','$trarazao','$tracep','$traendereco','$trabairro','$trafone','$trafax','$traemail','$traobs','$tracodcidade','$codigo','$rotcodigo','$tpfcodigo','$tracnpj' ,'$traie' ,'$doccobvers' ,'$ocorenvers','$conembvers','$notfisvers','$diredi','$atualSemGMT','$atualSemGMT','$tradatasul','$traretirada','$tratptolera','$tratolera')");

//Localiza o Codigo Criado
$tracodigo = 0;

//Localiza a o pedido para ter o número
$b = 0;
while ($b < 1000) {
    $sql = "Select tracodigo from transportador where dtinc='$atualSemGMT' and tranguerra='$tranguerra'";
    $sql = pg_query($sql);
    $row = pg_num_rows($sql);
    if ($row) {
        $tracodigo = pg_fetch_result($sql, 0, "tracodigo");
        $b = 1000;
    } else {
        $b++;
    }
}

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


header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

$xml = "<dados>
		<registro>
		<item>" . $tracodigo . "</item>		
		</registro>
		</dados>";
echo $xml;
