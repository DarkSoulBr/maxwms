<?php

require('./_app/Config.inc.php');

$veicodigo = trim($_GET["veicodigo"]);

//Verifica se tem algum romaneio cadastrado com o Veículo
$read = new Read;
$read->FullRead("SELECT count(*) as romaneios FROM romaneios WHERE romveiculo = {$veicodigo}");
$romaneios = 0;
if ($read->getRowCount() >= 1) {
    $romaneios = $read->getResult()[0]['romaneios'];
}
$read = null;

if ($romaneios == 0) {

    $deleta = new Delete;

    $deleta->ExeDelete('veiculos', "WHERE veicodigo = :id", 'id=' . $veicodigo);

    if ($deleta->getResult()) {
        $codigo = $deleta->getRowCount();
        $erro = '_';
    } else {
        $codigo = 0;
        $erro = $deleta->getErro();
    }
} else {
    $codigo = 0;
    $erro = utf8_encode("Existe(m) {$romaneios} romaneio(s) cadastrado(s) com esse Veículo! Você não pode Excluir!");
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
