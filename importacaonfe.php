<?php

require_once('./_app/Config.inc.php');
require_once('./include/config.php');

ob_implicit_flush(true);

//Verifica o tipo de Solicitacao
//0 - Todos
//1 - Por Data
//2 - Por CSV
//3 - (null) Di?rio Hoje
//4 - Por Produto

if (isset($_GET['todos'])) {
    $todos = (int) $_GET['todos'];
} else {
    $todos = 3;
}

$where = "";

if ($todos == 0) {
    $where = "WHERE a.nfecodigo > 0 ORDER BY a.nfedata ASC";
} else if ($todos == 1 || $todos == 3) {

    if (isset($_GET['data'])) {
        $filtro = $_GET['data'];
        $filtro = substr($filtro, 6, 4) . '-' . substr($filtro, 3, 2) . '-' . substr($filtro, 0, 2);
    } else {
        //$filtro = date("Y-m-d");        
        $filtro = date("Y-m-d", strtotime('-1 day', strtotime(date("Y-m-d"))));
    }
    $where = "WHERE a.nfedata >= '{$filtro}' ORDER BY a.nfedata ASC";
} else if ($todos == 2) {

    $arquivo = fopen("/home/teltex/nfe.csv", "r");

    //inicio uma variavel para levar a conta das linhas e dos caracteres
    $num_linhas = 0;
    $caracteres = 0;

    //faco um loop para percorrer o arquivo linha a linha ate o final do arquivo
    while (!feof($arquivo)) {

        //se extraio uma linha do arquivo e nao eh false
        if ($linha = fgets($arquivo)) {

            //acumulo uma na variavel n?mero de linhas
            $num_linhas++;
            //acumulo o n?mero de caracteres desta linha
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
                $where = "WHERE (a.nfecodigo = " . $vetordadospro[$i];
            } else {
                $where = $where . " OR a.nfecodigo=" . $vetordadospro[$i];
            }
        }
        if ($where != '') {
            $where = $where . ")";
        }
    }
} else {
    echo utf8_decode("Op??o Inv?lida !");
    die;
}

$apiurl = WMS_APIURL;

$endpoint = "/orders";

$destino = "/home/teltex/incoming_invoice/";

if (!is_dir($destino)) {
    mkdir($destino, 0755);
}

$destino = "/home/teltex/incoming_invoice/" . date('Ymd') . "/";

if (!is_dir($destino)) {
    mkdir($destino, 0755);
}

$nomeArquivo = $destino . "lack_average_" . date("Ymd_Hi") . ".csv";

if (file_exists($nomeArquivo)) {
    unlink($nomeArquivo);
}
$arquivo = fopen("$nomeArquivo", "x+");

$linha = 'Nota;Emissao;Status;Retorno';
fputs($arquivo, "$linha\r\n");

$read = new Read;
$read->FullRead("SELECT a.* FROM nfentrada a {$where}");


if ($read->getRowCount() >= 1) {

    $build = "";

    foreach ($read->getResult() as $registros) {

        extract($registros);           
        
       
        $notas = [            
            "CHAVENFE" => trim($chavenf)
        ];

        $build = [
            "CORPEM_WMS_FECHA_DE" => $notas            
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
        "CORPEM_WMS_FECHA_DE": {
        "CHAVENFE": "43190394516671000153550020004596081023377806",
        "ITEMS": [
        {
        "NUMSEQ": "1",
        "CODPROD": "5100",
        "QTPROD": "0",
        "QTAVARIA": "0",
        "QTFALTA": "10",
        "LOTFAB": "011949194 *** Falta/Recebimento",
        "DTFAB": "01/01/1970",
        "DTVEN": "01/01/1970"
        },
        {
        "NUMSEQ": "1",
        "CODPROD": "5100",
        "QTPROD": "90",
        "QTAVARIA": "0",
        "QTFALTA": "0",
        "LOTFAB": "lote1",
        "DTFAB": "01/01/2001",
        "DTVEN": "01/01/2020"
        },
        {
        "NUMSEQ": "2",
        "CODPROD": "5101",       
        "QTPROD": "80",
        "QTAVARIA": "0",
        "QTFALTA": "0",
        "LOTFAB": "lote3",
        "DTFAB": "02/02/2002",
        "DTVEN": "02/02/2022"
        },
        {
        "NUMSEQ": "2",
        "CODPROD": "5101",
        "QTPROD": "0",
        "QTAVARIA": "10",
        "QTFALTA": "0",
        "LOTFAB": "lote2",
        "DTFAB": "02/02/2002",
        "DTVEN": "02/02/2022"
        },
        {
        "NUMSEQ": "2",
        "CODPROD": "5101",
        "QTPROD": "0",
        "QTAVARIA": "0",
        "QTFALTA": "10",
        "LOTFAB": "011949195 *** Falta/Recebimento",
        "DTFAB": "01/01/1970",
        "DTVEN": "01/01/1970"
        }
        ]
        }
       }
       ';

         $retorno = json_decode(utf8_encode($callback));   
        
        
        if(isset($retorno->CORPEM_WS_ERRO)) {
            $mensagem = utf8_decode($retorno->CORPEM_WS_ERRO);
        } else if(isset($retorno->CORPEM_WMS_FECHA_DE->CHAVENFE)) {
            
            
            
            $read = new Read;
            $read->FullRead("SELECT * FROM recebto WHERE chave_nfe = '$chavenf'");
            
            if ($read->getRowCount() >= 1){
                $mensagem = 'Falta / Avaria j? Importada !';
            } else { 
                
                $Dados = [
                    'chave_nfe' => $chavenf,
                    'recdata' => date("Y-m-d H:i:s")
                ];

                $Cadastra = new Create;
                $Cadastra->ExeCreate('recebto', 'recebto_reccodigo_seq', $Dados);

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
                    
                    foreach ($retorno->CORPEM_WMS_FECHA_DE->ITEMS as $value) { 
                        
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
                            'reccodigo' => $codigo,
                            'numseq' => $value->NUMSEQ,
                            'codprod' => $value->CODPROD,
                            'qtprod' => $value->QTPROD,
                            'qtavaria' => $value->QTAVARIA,
                            'qtfalta' => $value->QTFALTA,
                            'lotfab' => $value->LOTFAB,
                            'dtfab' => $dtfab,
                            'dtven' => $dtven,
                            'nser' => $value->NSER
                        ];

                        $Cadastra = new Create;
                        $Cadastra->ExeCreate('recitens', 'recitens_recitecodigo_seq', $Dados);

                        //echo $value->NUMSEQ . ' ' . $value->CODPROD . ' ' . $value->QTPROD . ' ' . $value->QTAVARIA . ' ' . $value->QTFALTA . ' ' . $value->LOTFAB . ' ' . $value->DTFAB . ' ' . $value->DTVEN . ' ' . '<br>';

                    }
                }
                
            }
            $read = null;  
            
        } else {            
            $mensagem = 'N?o foi poss?vel ler o retorno da API';
        }
        
        echo $numnf . ' ' . $dteminf . ' ' . $chavenf . ' ' . $mensagem . '<hr>';
            
        $linha = "{$numnf};{$dteminf};{$mensagem};{$info['http_code']}";
        fputs($arquivo, "$linha\r\n");
          
        curl_close($ch);
        
        
    }
}

$read = null;

fclose($arquivo);

echo "Fim de Processamento<hr>";

