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
    $where = "WHERE a.pedcancela IS NOT NULL ORDER BY a.pedcancela ASC";
} else if ($todos == 1 || $todos == 3) {

    if (isset($_GET['data'])) {
        $filtro = $_GET['data'];
        $filtro = substr($filtro, 6, 4) . '-' . substr($filtro, 3, 2) . '-' . substr($filtro, 0, 2);
    } else {
        //$filtro = date("Y-m-d");        
        $filtro = date("Y-m-d", strtotime('-1 day', strtotime(date("Y-m-d"))));
    }
    $where = "WHERE a.pedcancela >= '{$filtro}' ORDER BY a.pedcancela ASC";
} else if ($todos == 2) {

    $arquivo = fopen("/home/teltex/pedido.csv", "r");

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
                        $where = "WHERE (a.numpedcli = '$codigo'";
                    } else {
                        $where = $where . " OR a.numpedcli = '$codigo'";
                    }
                }
            }
        }
    }
    if ($where != '') {
        $where = $where . ")";
    } else {
        echo utf8_decode("Nenhum pedido no arquivo !");
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
                $where = "WHERE (a.pedcodigo = " . $vetordadospro[$i];
            } else {
                $where = $where . " OR a.pedcodigo=" . $vetordadospro[$i];
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

$destino = "/home/teltex/orders/";

if (!is_dir($destino)) {
    mkdir($destino, 0755);
}

$destino = "/home/teltex/orders/" . date('Ymd') . "/";

if (!is_dir($destino)) {
    mkdir($destino, 0755);
}

$nomeArquivo = $destino . "orders_cancel_" . date("Ymd_Hi") . ".csv";

if (file_exists($nomeArquivo)) {
    unlink($nomeArquivo);
}
$arquivo = fopen("$nomeArquivo", "x+");

$linha = 'Pedido;Nome;Status;Retorno';
fputs($arquivo, "$linha\r\n");

$read = new Read;
$read->FullRead("SELECT a.* FROM pedidos a {$where}");


if ($read->getRowCount() >= 1) {

    $build = "";

    foreach ($read->getResult() as $registros) {

        extract($registros);     
        
        if($pedcancela) {
        
            $pedidos = null;

            $pedidos = [
                "CGCCLIWMS" => $cgccliwms,            
                "NUMPEDCLI" => $numpedcli 
            ];

            $build = [
                "CORPEM_ERP_CANC_PED" => $pedidos            
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

                echo $numpedcli . ' ' . $nomedest . ' ' . $mensagem . '<hr>';

                $linha = "{$numpedcli};{$nomedest};{$mensagem};{$info['http_code']}";
                fputs($arquivo, "$linha\r\n");


            } else {

            }

            curl_close($ch);
            
        } else {
            
            $mensagem = 'Pedido não está Cancelado!';

            echo $numpedcli . ' ' . $nomedest . ' ' . $mensagem . '<hr>';

            $linha = "{$numpedcli};{$nomedest};{$mensagem};{$info['http_code']}";
            fputs($arquivo, "$linha\r\n");
            
        }
        
        
    }
}

$read = null;

fclose($arquivo);

echo "Fim de Processamento<hr>";

