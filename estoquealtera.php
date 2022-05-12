<?php

require('./_app/Config.inc.php');

$etqcodigo = trim($_GET["etqcodigo"]);
$etqnome = trim($_GET["etqnome"]);
$reserva = trim($_GET["reserva"]);
$consultas = trim($_GET["consultas"]);
$zerou = trim($_GET["zerou"]);
$empcodigo = trim($_GET["empcodigo"]);
$etqsigla = trim($_GET["etqsigla"]);

if ($empcodigo == '') {
    $empcodigo = 1;
}

$update = new Update;

$Dados = [
    'etqnome' => $etqnome,
    'reserva' => $reserva,
    'consultas' => $consultas,
    'zerou' => $zerou,
    'etqsigla' => $etqsigla,
    'empcodigo' => $empcodigo
];

$update->ExeUpdate('estoque', $Dados, "WHERE etqcodigo = :id", 'id=' . $etqcodigo);

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

