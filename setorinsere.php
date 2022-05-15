<?php

require('./_app/Config.inc.php');

$setor = trim($_GET["setor"]);
$codigosetor = trim($_GET["codigosetor"]);

$Dados = ['setor' => $setor, 'codigosetor' => $codigosetor];
$Cadastra = new Create;
$Cadastra->ExeCreate('setor', 'setor_setcodigo_seq', $Dados);
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
