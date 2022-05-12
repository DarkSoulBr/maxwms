<?php

require('./_app/Config.inc.php');

$tracodigo = trim($_GET["tracodigo"]);

//Verifica se tem algum pedido cadastrado com a Transportadora
$read = new Read;
$read->FullRead("SELECT count(*) as pedidos FROM pvenda WHERE tracodigo = {$tracodigo}");
$pedidos = 0;
if ($read->getRowCount() >= 1) {
    $pedidos = $read->getResult()[0]['pedidos'];
}
$read = null;

if ($pedidos == 0) {

    $deleta = new Delete;

    $deleta->ExeDelete('transportador', "WHERE tracodigo = :id", 'id=' . $tracodigo);

    if ($deleta->getResult()) {
        $codigo = $deleta->getRowCount();
        $erro = '_';

        $deleta2 = new Delete;
        $deleta2->ExeDelete('transportadorcontato', "WHERE tracodigo = :id", 'id=' . $tracodigo);
    } else {
        $codigo = 0;
        $erro = $deleta->getErro();
    }
} else {
    $codigo = 0;
    $erro = utf8_encode("Existe(m) {$pedidos} pedidos(s) cadastrado(s) com essa Transportadora! Você não pode Excluir!");
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
