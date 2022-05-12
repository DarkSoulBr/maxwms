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
    $where = "WHERE a.procodigo > 0 ORDER BY a.prodata ASC";
} else if ($todos == 1 || $todos == 3) {

    if (isset($_GET['data'])) {
        $filtro = $_GET['data'];
        $filtro = substr($filtro, 6, 4) . '-' . substr($filtro, 3, 2) . '-' . substr($filtro, 0, 2);
    } else {
        //$filtro = date("Y-m-d");        
        $filtro = date("Y-m-d", strtotime('-1 day', strtotime(date("Y-m-d"))));
    }
    $where = "WHERE a.prodata >= '{$filtro}' ORDER BY a.prodata ASC";
} else if ($todos == 2) {

    $arquivo = fopen("/home/teltex/produto.csv", "r");

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
                        $where = "WHERE (a.codprod = '$codigo'";
                    } else {
                        $where = $where . " OR a.codprod = '$codigo'";
                    }
                }
            }
        }
    }
    if ($where != '') {
        $where = $where . ")";
    } else {
        echo utf8_decode("Nenhum produto no arquivo !");
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
                $where = "WHERE (a.procodigo = " . $vetordadospro[$i];
            } else {
                $where = $where . " OR a.procodigo=" . $vetordadospro[$i];
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

$endpoint = "/products";

$destino = "/home/teltex/products/";

if (!is_dir($destino)) {
    mkdir($destino, 0755);
}

$destino = "/home/teltex/products/" . date('Ymd') . "/";

if (!is_dir($destino)) {
    mkdir($destino, 0755);
}

$nomeArquivo = $destino . "products_" . date("Ymd_Hi") . ".csv";

if (file_exists($nomeArquivo)) {
    unlink($nomeArquivo);
}
$arquivo = fopen("$nomeArquivo", "x+");

$linha = 'Codigo;Produto;Status;Retorno';
fputs($arquivo, "$linha\r\n");

$read = new Read;
$read->FullRead("SELECT a.* FROM produtos a {$where}");


if ($read->getRowCount() >= 1) {

    $build = "";

    foreach ($read->getResult() as $registros) {

        extract($registros);
        
        //Localiza as Embalagens
        
        $embalagens = null;
        
        $read2 = new Read;
        $read2->FullRead("SELECT * FROM embalagens  
                            WHERE procodigo = {$procodigo}");

        if ($read2->getRowCount() >= 1) {
            foreach ($read2->getResult() as $registros2) {
                extract($registros2);               
                
                $embalagens[] = [
                    "CODUNID" => trim($codunid),
                    "FATOR" => trim($fator),
                    "CODBARRA" => trim($codbarra),
                    "PESOLIQ" => trim($pesoliq),
                    "PESOBRU" => trim($pesobru),
                    "ALT" => trim($alt),
                    "LAR" => trim($lar),
                    "COMP" => trim($comp),
                    "VOL" => trim($vol)
                ];
                
            }
        }
    
        $produtos = null;

        $produtos[] = [
            "CODPROD" => trim($codprod),
            "NOMEPROD" => trim($nomeprod),
            "IWS_ERP" => trim($iws_erp),
            "TPOLRET" => trim($tpolret),
            "IAUTODTVEN" => trim($iautodtven),
            "QTDDPZOVEN" => trim($qtddpzoven),
            "ILOTFAB" => trim($ilotfab),
            "IDTFAB" => trim($idtfab),
            "IDTVEN" => trim($idtven),
            "INSER" => trim($inser),
            "CODFAB" => trim($codfab),
            "NOMEFAB" => trim($nomefab),
            "EMBALAGENS" => $embalagens           
        ];

        $build = [
            "CORPEM_ERP_MERC" => [
                "CGCCLIWMS" => $cgccliwms,
                "PRODUTOS" => $produtos
            ]
        ];
      
        $data_string = json_encode($build);
             
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
        
        if(isset($retorno->CORPEM_WS_ERRO)) {
            $mensagem = utf8_decode($retorno->CORPEM_WS_ERRO);
            
            echo $codprod . ' ' . $nomeprod . ' ' . $mensagem . '<hr>';
            
            $linha = "{$codprod};{$nomeprod};{$mensagem};{$info['http_code']}";
            fputs($arquivo, "$linha\r\n");
            
            
        } else if(isset($retorno->CORPEM_WS_OK)) {
            
            $mensagem = utf8_decode($retorno->CORPEM_WS_OK);
            
            echo $codprod . ' ' . $nomeprod . ' ' . $mensagem . '<hr>';
            
            $linha = "{$codprod};{$nomeprod};{$mensagem};{$info['http_code']}";
            fputs($arquivo, "$linha\r\n");
            
        } else {
            
            $mensagem = 'Não foi possível ler o retorno da API';
            
            echo $codprod . ' ' . $nomeprod . ' ' . $mensagem . '<hr>';
            
            $linha = "{$codprod};{$nomeprod};{$mensagem};{$info['http_code']}";
            fputs($arquivo, "$linha\r\n");
            
        }
          
        curl_close($ch);
        
        
    }
}

$read = null;

fclose($arquivo);

echo "Fim de Processamento<hr>";

