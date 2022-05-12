<?php

require('./_app/Config.inc.php');

$etqnome = trim($_GET["etqnome"]);
$reserva = trim($_GET["reserva"]);
$consultas = trim($_GET["consultas"]);
$zerou = trim($_GET["zerou"]);
$empcodigo = trim($_GET["empcodigo"]);
$etqsigla = trim($_GET["etqsigla"]);

if ($empcodigo == '') {
    $empcodigo = 1;
}

$Dados = [
    'etqnome' => $etqnome,
    'reserva' => $reserva,
    'consultas' => $consultas,
    'zerou' => $zerou,
    'etqsigla' => $etqsigla,
    'empcodigo' => $empcodigo
];

$Cadastra = new Create;
$Cadastra->ExeCreate('estoque', 'estoque_etqcodigo_seq', $Dados);

if ($Cadastra->getResult()) {
    $codigo = $Cadastra->getResult();
    $erro = '_';
} else {
    $codigo = 0;
    $erro = $Cadastra->getErro();
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
