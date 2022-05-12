<?php

require_once('./_app/Config.inc.php');
require_once('./include/config.php');

ob_implicit_flush(true);

//Verifica o tipo de Solicitacao
//0 - Todos
//1 - Por Data
//2 - Por CSV
//3 - (null) Diário Hoje
//4 - Por Produto

if (isset($_GET['todos'])) {
    $todos = (int) $_GET['todos'];
} else {
    $todos = 3;
}

$where = "";

if ($todos == 0) {
    $where = "WHERE a.nfscodigo > 0 ORDER BY a.nfsdata ASC";
} else if ($todos == 1 || $todos == 3) {

    if (isset($_GET['data'])) {
        $filtro = $_GET['data'];
        $filtro = substr($filtro, 6, 4) . '-' . substr($filtro, 3, 2) . '-' . substr($filtro, 0, 2);
    } else {
        //$filtro = date("Y-m-d");        
        $filtro = date("Y-m-d", strtotime('-1 day', strtotime(date("Y-m-d"))));
    }
    $where = "WHERE a.nfsdata >= '{$filtro}' ORDER BY a.nfsdata ASC";
} else if ($todos == 2) {

    $arquivo = fopen("/home/teltex/nfs.csv", "r");

    //inicio uma variavel para levar a conta das linhas e dos caracteres
    $num_linhas = 0;
    $caracteres = 0;

    //faco um loop para percorrer o arquivo linha a linha ate o final do arquivo
    while (!feof($arquivo)) {

        //se extraio uma linha do arquivo e nao eh false
        if ($linha = fgets($arquivo)) {

            //acumulo uma na variavel número de linhas
            $num_linhas++;
            //acumulo o número de caracteres desta linha
            $caracteres = 0;
            $caracteres += strlen($linha);

            $campo = '';
            $x = 0;
            $vai = '';

            $codigo = '';

            if ($num_linhas > 1) {

                for ($i = 0; $i < $caracteres; $i++) {

                    if (substr($linha, $i, 1) == ';') {
                        $x++;
                        if ($x == 1) {
                            $codigo = $vai;
                        }
                        $vai = '';
                    } else {
                        $vai = $vai . substr($linha, $i, 1);
                    }
                }//FECHA FOR   
                if ($codigo == '') {
                    $codigo = $vai;
                }

                if ($codigo != '') {

                    $codigo = trim($codigo);

                    if ($where == '') {
                        $where = "WHERE (a.numnf = '$codigo'";
                    } else {
                        $where = $where . " OR a.numnf = '$codigo'";
                    }
                }
            }
        }
    }
    if ($where != '') {
        $where = $where . ")";
    } else {
        echo utf8_decode("Nenhuma nota no arquivo !");
        die;
    }
} else if ($todos == 4) {

    if (isset($_GET['produto'])) {
        $produto = $_GET['produto'];
    } else {
        $produto = "";
    }

    if ($produto != "") {

        $auxsproduto = substr_count($produto, ';');
        $auxpro = explode(";", $produto);
        for ($i = 0; $i < $auxsproduto; $i++)
            $produtox[$i] = $auxpro[$i];

        $contaproduto = count($produtox);

        if ($contaproduto != "") {
            $vetorcontadorpro = $contaproduto;
            $vetordadospro = $produtox;
        }

        for ($i = 0; $i < $vetorcontadorpro; $i++) {
            if ($where == '') {
                $where = "WHERE (a.nfscodigo = " . $vetordadospro[$i];
            } else {
                $where = $where . " OR a.nfscodigo=" . $vetordadospro[$i];
            }
        }
        if ($where != '') {
            $where = $where . ")";
        }
    }
} else {
    echo utf8_decode("Opção Inválida !");
    die;
}

$apiurl = WMS_APIURL;

$endpoint = "/orders";

$destino = "/home/teltex/invoice/";

if (!is_dir($destino)) {
    mkdir($destino, 0755);
}

$destino = "/home/teltex/invoice/" . date('Ymd') . "/";

if (!is_dir($destino)) {
    mkdir($destino, 0755);
}

$nomeArquivo = $destino . "invoice_" . date("Ymd_Hi") . ".csv";

if (file_exists($nomeArquivo)) {
    unlink($nomeArquivo);
}
$arquivo = fopen("$nomeArquivo", "x+");

$linha = 'Nota;Emissao;Status;Retorno';
fputs($arquivo, "$linha\r\n");

$read = new Read;
$read->FullRead("SELECT a.* FROM nfsaida a {$where}");


if ($read->getRowCount() >= 1) {

    $build = "";

    foreach ($read->getResult() as $registros) {

        extract($registros);

        //Localiza os Itens

        $itens = null;

        $read2 = new Read;
        $read2->FullRead("SELECT * FROM nfsitens   
                            WHERE nfscodigo = {$nfscodigo}");

        if ($read2->getRowCount() >= 1) {
            foreach ($read2->getResult() as $registros2) {
                extract($registros2);

                $itens[] = [
                    "NUMSEQ" => trim($numseq),
                    "CODPROD" => trim($codprod),
                    "QTPROD" => trim($qtprod)
                ];
            }
        }

        $notas = null;

        if ($dteminf) {
            $dteminf = date('d/m/Y', strtotime($dteminf));
        } else {
            $dteminf = '';
        }

        $notas = [
            "CGCCLIWMS" => trim($cgccliwms),
            "CGCEMINF" => trim($cgceminf),
            "NUMPEDCLI" => trim($numpedcli),
            "NUMNF" => trim($numnf),
            "SERIENF" => trim($serienf),
            "DTEMINF" => trim($dteminf),
            "VLTOTALNF" => trim($vltotalnf),
            "QTVOL" => trim($qtvol),
            "CHAVENF" => trim($chave_nf),
            "ITENS" => $itens
        ];

        $build = [
            "CORPEM_ERP_CONF_NF" => $notas
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
        } else if (isset($retorno->CORPEM_WS_OK)) {
            $mensagem = utf8_decode($retorno->CORPEM_WS_OK);
        } else {
            $mensagem = 'Não foi possível ler o retorno da API';
        }

        echo $numnf . ' ' . $dteminf . ' ' . $mensagem . '<hr>';

        $linha = "{$numnf};{$dteminf};{$mensagem};{$info['http_code']}";
        fputs($arquivo, "$linha\r\n");

        curl_close($ch);
    }
}

$read = null;

fclose($arquivo);

echo "Fim de Processamento<hr>";

