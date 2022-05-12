<?php

require('./_app/Config.inc.php');

$codigo = trim($_GET["codigo"]);



$deleta = new Delete;

$deleta->ExeDelete('enderecos', "WHERE esecodigo = :id", 'id=' . $codigo);

if ($deleta->getResult()) {
    $codigo = $deleta->getRowCount();
    $erro = '_';
} else {
    $codigo = 0;
    $erro = $deleta->getErro();
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
