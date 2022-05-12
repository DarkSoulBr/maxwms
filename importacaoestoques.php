<?php

require_once('./_app/Config.inc.php');
require_once('./include/config.php');

ob_implicit_flush(true);

$apiurl = WMS_APIURL;

$endpoint = "/stocks";

$destino = "/home/teltex/stocks/";

if (!is_dir($destino)) {
    mkdir($destino, 0755);
}

$destino = "/home/teltex/stocks/" . date('Ymd') . "/";

if (!is_dir($destino)) {
    mkdir($destino, 0755);
}

$nomeArquivo = $destino . "stocks_" . date("Ymd_Hi") . ".csv";

if (file_exists($nomeArquivo)) {
    unlink($nomeArquivo);
}
$arquivo = fopen("$nomeArquivo", "x+");



$estoques = [
    "CGCCLIWMS" => trim(TELTEX_CNPJ)
];

$build = [
    "CORPEM_ERP_ESTOQUE" => $estoques
];

$data_string = json_encode($build);

$data_string = str_replace("\/", "/", $data_string);

$ch = curl_init($apiurl);

curl_setopt($ch, CURLOPT_POST, true);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 600);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array_merge($build, $api)));
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
//curl_setopt($ch, CURLOPT_HTTPHEADER, []);
/*
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/json')
  );
 * 
 */
$callback = curl_exec($ch);

$info = curl_getinfo($ch);

$retorno = json_decode(utf8_encode($callback));


if (isset($retorno->CORPEM_WS_ERRO)) {
    $mensagem = utf8_decode($retorno->CORPEM_WS_ERRO);
    
    $linha = $mensagem;
    fputs($arquivo, "$linha\r\n");
    
} else if (isset($retorno->CORPEM_ERP_ESTOQUE->PRODUTOS)) {
    
    $deleta = new Delete;
    $deleta->ExeDelete('estoques', "WHERE estcodigo > :id", 'id=0');
    
    $linha = 'CD;FT;QC;QB;QF';
    fputs($arquivo, "$linha\r\n");
    
    foreach ($retorno->CORPEM_ERP_ESTOQUE->PRODUTOS as $value) {            
        
        echo $value->CD . ' ' . $value->FT  . ' ' . $value->QC . ' ' . $value->QB . ' ' . $value->QF . '<hr>';       
        
        $Dados = [
            'cd' => $value->CD,
            'ft' => $value->FT,
            'qc' => $value->QC,
            'qb' => $value->QB,
            'qf' => $value->QF,
            'estdata' => date('Y-m-d H:i:s')
        ];

        $Cadastra = new Create;
        $Cadastra->ExeCreate('estoques', 'estoques_estcodigo_seq', $Dados);
        
        $linha = "{$value->CD};{$value->FT};{$value->QC};{$value->QB};$value->QF";
        fputs($arquivo, "$linha\r\n");
        
    }
    
    //var_dump($retorno->CCORPEM_ERP_ESTOQUE);

    //Gravar as Informações
} else {
    $mensagem = 'Não foi possível ler o retorno da API';
    
    $linha = $mensagem;
    fputs($arquivo, "$linha\r\n");
}


curl_close($ch);



fclose($arquivo);

echo "Fim de Processamento<hr>";

