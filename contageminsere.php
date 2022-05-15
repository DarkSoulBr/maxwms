<?php

require('./_app/Config.inc.php');

$fpgnome=trim($_GET["fpgnome"]);
$opcao=$_GET["opcao"];

    $Dados = ['contnome' => $fpgnome, 'opcao' => $opcao];
    $Cadastra = new Create;
    $Cadastra->ExeCreate('contagem', 'contagem_contcodigo_seq', $Dados);
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


   