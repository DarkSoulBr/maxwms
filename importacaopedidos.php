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
    $where = "WHERE a.pedcodigo > 0 ORDER BY a.peddata ASC";
} else if ($todos == 1 || $todos == 3) {

    if (isset($_GET['data'])) {
        $filtro = $_GET['data'];
        $filtro = substr($filtro, 6, 4) . '-' . substr($filtro, 3, 2) . '-' . substr($filtro, 0, 2);
    } else {
        //$filtro = date("Y-m-d");        
        $filtro = date("Y-m-d", strtotime('-1 day', strtotime(date("Y-m-d"))));
    }
    $where = "WHERE a.peddata >= '{$filtro}' ORDER BY a.peddata ASC";
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

$nomeArquivo = $destino . "orders_confirmation_" . date("Ymd_Hi") . ".csv";

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

        
        $pedidos = [
            "CGCCLIWMS" => trim($cgccliwms),   
            "CGCEMINF" => trim($cgceminf),
            "NUMPEDCLI" => trim($numpedcli)
        ];

        $build = [
            "CORPEM_WMS_CONF_SEP" => $pedidos
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
        
         //Retirar isso
            
        $callback = '{
        "CORPEM_WMS_CONF_SEP": {
        "CGCEMINF": "35457333000129",
        "CGCCLIWMS": "35457333000129",
        "NUMPEDCLI": "DC - 3",
        "QTVOL": "2",
        "CGCTRANSP": "",
        "DTFIMCHECK": "26/03/2020",
        "URLRAST": "",
        "ITENS": [
        {
        "NUMSEQ": "1",
        "CODPROD": "5100",
        "QTPROD": "10",
        "QTCONF": "10",
        "LOTFAB": "LAA",
        "DTFAB": "01/01/2020",
        "DTVEN": "01/01/2022"
        },
        {
        "NUMSEQ": "2",
        "CODPROD": "5101",
        "QTPROD": "2",
        "QTCONF": "2",
        "LOTFAB": "b",       
        "DTFAB": "01/01/2020",
        "DTVEN": "01/01/2030"
        }
        ]
        }
       }
       ';
        
        $retorno = json_decode(utf8_encode($callback));   

        if (isset($retorno->CORPEM_WS_ERRO)) {
            $mensagem = utf8_decode($retorno->CORPEM_WS_ERRO);
        } else if (isset($retorno->CORPEM_WMS_CONF_SEP)) {
                                 
            $read = new Read;
            $read->FullRead("SELECT * FROM separacao WHERE NUMPEDCLI = '$numpedcli'");
            
            if ($read->getRowCount() >= 1){
                $mensagem = 'Separação já Importada !';
            } else { 
                
                $Dados = [
                    'cgccliwms' => $cgccliwms,
                    'numpedcli' => $numpedcli,
                    'especie' => $retorno->CORPEM_WMS_CONF_SEP->ESPECIE,
                    'pesovol' => $retorno->CORPEM_WMS_CONF_SEP->PESOVOL,
                    'qtvol' => $retorno->CORPEM_WMS_CONF_SEP->QTVOL,
                    'cgctransp' => $retorno->CORPEM_WMS_CONF_SEP->CGCTRANSP,
                    'sepdata' => date("Y-m-d H:i:s")
                ];

                $Cadastra = new Create;
                $Cadastra->ExeCreate('separacao', 'separacao_sepcodigo_seq', $Dados);

                if ($Cadastra->getResult()) {
                    $codigo = $Cadastra->getResult();
                    $erro = '_';
                } else {
                    $codigo = 0;
                    $erro = $Cadastra->getErro();    
                }
                $Cadastra = null;
                
                if($codigo==0) {
                    $mensagem = $erro;
                } else {                
                    
                    $mensagem = 'OK';
                    
                    foreach ($retorno->CORPEM_WMS_CONF_SEP->ITENS as $value) {
                                              
                        if($value->DTFAB) {
                            $dtfab = date('Y-m-d', strtotime($value->DTFAB));
                        } else {
                            $dtfab = null;
                        }
                        
                        if($value->DTVEN) {
                            $dtven = date('Y-m-d', strtotime($value->DTVEN));
                        } else {
                            $dtven = null;
                        }
                        
                        $Dados = [
                            'sepcodigo' => $codigo,
                            'numseq' => $value->NUMSEQ,
                            'codprod' => $value->CODPROD,
                            'qtprod' => $value->QTPROD,
                            'qtconf' => $value->QTCONF,                            
                            'lotfab' => $value->LOTFAB,
                            'dtfab' => $dtfab,
                            'dtven' => $dtven,
                            'nser' => $value->NSER
                        ];

                        $Cadastra = new Create;
                        $Cadastra->ExeCreate('sepitens', 'sepitens_sepitecodigo_seq', $Dados);

                        //echo $value->NUMSEQ . ' ' . $value->CODPROD . ' ' . $value->QTPROD . ' ' . $value->QTAVARIA . ' ' . $value->QTFALTA . ' ' . $value->LOTFAB . ' ' . $value->DTFAB . ' ' . $value->DTVEN . ' ' . '<br>';

                    }
                }
                
            }
            $read = null;  
            
        } else {
            $mensagem = 'Não foi possível ler o retorno da API';
        }

        echo $numpedcli . ' ' . $nomedest . ' ' . $mensagem . '<hr>';

        $linha = "{$numpedcli};{$nomedest};{$mensagem};{$info['http_code']}";
        fputs($arquivo, "$linha\r\n");

        curl_close($ch);
    }
}

$read = null;

fclose($arquivo);

echo "Fim de Processamento<hr>";

