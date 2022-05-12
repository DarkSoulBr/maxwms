<?php

require('./_app/Config.inc.php');

$ua = trim($_GET["ua"]);
$bloco = trim($_GET["bloco"]);
$rua = trim($_GET["rua"]);
$nivel = trim($_GET["nivel"]);
$coluna = trim($_GET["coluna"]);
$posicao = trim($_GET["posicao"]);
$codigo = trim($_GET["codigo"]);

$Dados = [
    'ua' => $ua,
    'bloco' => $bloco,
    'rua' => $rua,
    'nivel' => $nivel,
    'coluna' => $coluna,
    'posicao' => $posicao
];

$update = new Update;
$update->ExeUpdate('enderecos', $Dados, "WHERE esecodigo = :id", 'id=' . $codigo);

if ($update->getResult()) {
    $codigo = $update->getRowCount();
    $erro = '_';
} else {
    $codigo = 0;
    $erro = $update->getErro();    
}

header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

$xml = "<dados>
		<registro>
		<item>" . $codigo . "</item>
		<item>" . $erro . "</item>
		</registro>
		</dados>";
echo $xml;
  