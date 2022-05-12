<?php

//pega as configuracoes do servidor
require_once('include/conexao.inc.php');
require_once('include/config.php');
require_once('include/classes/EnviaEmail.php');
include_once('conemb.php');
include_once('ocoren.php');
include_once('doccob.php');

$usucodigo = trim($_GET["usuario"]);

if ($usucodigo == '' || $usucodigo == 0) {
    echo 'Erro ao verificar usuário, favor acessar a importação pelo menu do Maxtrade';
    exit();
}

/*
  Verifica se ha novo arquivo
  encaminha esse novo arquivo para o edi correto
  se retorno for true renomeia o arquivo
  se retorno for false envia email de notificacao para o andre
 */

set_time_limit(0);

//$caminho = "/home/delta/edi_toymania/";
$caminho = "/home/delta/Transportadoras/toymania/";
$caminho_2 = "/home/delta/Transportadoras/toymania_2/";

function processaEdiTrans($arquivo) {
    // $tipoEdiTrans = strtolower($arquivo);
    //echo "arquivo: $arquivo<br>";

    if (substr($arquivo, strlen($arquivo) - 2, strlen($arquivo)) == '\.' || substr($arquivo, strlen($arquivo) - 2, strlen($arquivo)) == '/.') {
        return 0;
    } else if (substr($arquivo, strlen($arquivo) - 3, strlen($arquivo)) == '\..' || substr($arquivo, strlen($arquivo) - 2, strlen($arquivo)) == '/..') {
        return 0;
    } else if ((!preg_match("/__imp/", $arquivo)) && (!preg_match("/__err/", $arquivo)) && (!preg_match("/__fdp/", $arquivo)) && (!preg_match("/__dup/", $arquivo))) {

        $str = file_get_contents($arquivo);
        //$str = str_replace(" ","_",$str);
        $filearray = explode("\n", $str);
// echo "beggining for...<br>";
        for ($index = 0; $index < count($filearray); $index++) {

            if (preg_match("/^320CON31/i", $filearray[$index]) || preg_match("/^320CONHE/i", $filearray[$index]) || preg_match("/^520CONHE/i", $filearray[$index]) || preg_match("/^520CON/i", $filearray[$index])) {
                $retornoProcessado = processaConemb($arquivo);
                if ($retornoProcessado) {
                    return 1;
                } else {
                    return 2;
                }
            } else if (preg_match("/^340OCOR/i", $filearray[$index]) || preg_match("/^540OCOR/i", $filearray[$index]) || preg_match("/^540OCO/i", $filearray[$index])) {
                $retornoProcessado = processaOcoren($arquivo);
                if ($retornoProcessado) {
                    return 1;
                } else {
                    return 2;
                }
            } else if (preg_match("/^350COBRA/i", $filearray[$index]) || preg_match("/^550COBRA/i", $filearray[$index]) || preg_match("/^550COB/i", $filearray[$index])) {
                $retornoProcessado = processaDoccob($arquivo);
                // A Partir de 23/03/2021 o retorno do arquivo de cobranca passa a ser numérico
                // 1 - Arquivo Importado
                // 2 - Arquivo com Erro
                // 4 - Arquivo já Importado
                /*
                  if ($retornoProcessado) {
                  return 1;
                  } else {
                  return 2;
                  }
                 * 
                 */
                return $retornoProcessado;
            }
        }
    } else {

        return 0;
    }


    if (!preg_match("/^NOT/", $arquivo)) {
        return 3;
    }
    //echo "<br>arquivo: $arquivo <br> RETORNO retornoProcessado: $retornoProcessado<br>";
    return $retornoProcessado;
}

//Percorre diretorio informado para importar os arquivos de EDI correspondentes
function percorrePastas($caminho, $usucodigo, $caminho_2) {

    // $list = scandir($caminho);
    $rdit = new RecursiveDirectoryIterator($caminho);

    foreach (new RecursiveIteratorIterator($rdit) as $arquivo) {

        //Pra cada arquivo processado vai atualizar a data
        $auxdat = date("Y-m-d H:i:s");
        $sqlpar = "Update parametros set datedi='$auxdat',usucodigoedi = " . $usucodigo . " Where parcodigo = 1 ";
        pg_query($sqlpar);

        //echo $arquivo;

        $processamentoEdi = processaEdiTrans($arquivo);
        
        //Para Unificar a Validação de Faturas se o arquivo cair na 
        //pasta da Toymania faz uma cópia para a pasta da Barão
        //Só pode ter em uma base senão vai entrar num loop infinito
        /*        
        if ($processamentoEdi > 0 && $processamentoEdi < 5) {

            $caminho_cab = "/home/delta/Transportadoras/toymania";
            $caminho_toy = "/home/delta/Transportadoras/barao";

            $aux_file = $arquivo->getFilename();
            $aux_path = $arquivo->getPathname();

            $toy_path = str_replace($caminho_cab, $caminho_toy, $aux_path);
            $toy_path = str_replace($aux_file, '', $toy_path);

            $toy_file = $toy_path . '\\' . $aux_file;

            if (!file_exists($toy_path)) {
                mkdir($toy_path, 0777, true);
            }

            if (!file_exists($toy_file)) {
                copy($arquivo, $toy_file);
            }
        }
         * 
         */
        

        if ($processamentoEdi == 1) {

            $arquivoAux = str_replace("\\", "/", $arquivo);

            $pastas = explode("/", $arquivoAux);

            $destino = $caminho_2;

            if (!is_dir($destino)) {
                mkdir($destino, 0755);
            }

            for ($index = 5; $index < count($pastas) - 1; $index++) {

                $destino .= $pastas[$index] . "/";

                if (!is_dir($destino)) {
                    mkdir($destino, 0755);
                }
            }

            $destino .= $pastas[count($pastas) - 1];


            //$arquivoRenomeado = substr($arquivo, 0, strlen($arquivo) - 4) . "__imp.txt";
            $arquivoRenomeado = substr($destino, 0, strlen($destino) - 4) . "__imp.txt";

            // rename ( $caminho . $arquivo  , $caminho . $arquivoRenomeado );
            //Se ja existir apaga				 
            if (file_exists($arquivoRenomeado)) {
                unlink($arquivoRenomeado);
            }
            rename($arquivo, $arquivoRenomeado);

            //echo "<meta HTTP-EQUIV='Refresh' CONTENT='5;URL=importaedi.php?parametro=1'>";
            echo date("d/m/Y H:i:s");
            $auxdat = date("Y-m-d H:i:s");
            $sqlpar = "Update parametros set datedi='$auxdat',usucodigoedi = " . $usucodigo . " Where parcodigo = 1 ";
            pg_query($sqlpar);

            echo "<meta HTTP-EQUIV='Refresh' CONTENT='5;URL=editrans.php?usuario=$usucodigo'>";
            exit;
        } else if ($processamentoEdi == 2) {

            $arquivoAux = str_replace("\\", "/", $arquivo);

            $pastas = explode("/", $arquivoAux);

            $destino = $caminho_2;

            if (!is_dir($destino)) {
                mkdir($destino, 0755);
            }

            for ($index = 5; $index < count($pastas) - 1; $index++) {

                $destino .= $pastas[$index] . "/";

                if (!is_dir($destino)) {
                    mkdir($destino, 0755);
                }
            }

            $destino .= $pastas[count($pastas) - 1];

            //$arquivoRenomeado = substr($arquivo, 0, strlen($arquivo) - 4) . "__err.txt";
            $arquivoRenomeado = substr($destino, 0, strlen($destino) - 4) . "__err.txt";

            // rename ( $caminho . $arquivo  , $caminho . $arquivoRenomeado );
            //Se ja existir apaga				 
            if (file_exists($arquivoRenomeado)) {
                unlink($arquivoRenomeado);
            }
            rename($arquivo, $arquivoRenomeado);

            //$Mail = new EnviaEmail();
            //$destinatario[] = array("deltamais@uol.com.br");
            //$destinatario[] = array("andre.mor@baraodistribuidor.com.br", "deltamais@uol.com.br");
            // $destinatario[] = array("fernando.simao@baraodistribuidor.com.br");
            //$destinatario[] = array("andre.mor@baraodistribuidor.com.br");
            //$assunto = "Falha ao importar EDI Transportadora - ". date("d/m/Y H:i");
            //$msg = "Falha ao importar o arquivo ".$arquivo;
            //echo "<br>". $msg;
            //print $Mail->envia($destinatario, $assunto, $msg); 
        } else if ($processamentoEdi == 3) {

            $arquivoAux = str_replace("\\", "/", $arquivo);

            $pastas = explode("/", $arquivoAux);

            $destino = $caminho_2;

            if (!is_dir($destino)) {
                mkdir($destino, 0755);
            }

            for ($index = 5; $index < count($pastas) - 1; $index++) {

                $destino .= $pastas[$index] . "/";

                if (!is_dir($destino)) {
                    mkdir($destino, 0755);
                }
            }

            $destino .= $pastas[count($pastas) - 1];

            //$arquivoRenomeado = substr($arquivo, 0, strlen($arquivo) - 4) . "__fdp.txt";
            $arquivoRenomeado = substr($destino, 0, strlen($destino) - 4) . "__fdp.txt";


            // rename ( $caminho . $arquivo  , $caminho . $arquivoRenomeado );
            //Se ja existir apaga				 
            if (file_exists($arquivoRenomeado)) {
                unlink($arquivoRenomeado);
            }
            rename($arquivo, $arquivoRenomeado);
            //$msg = "Falha ao importar o arquivo ".$arquivo;
            //echo "<br>". $msg;
            //print $Mail->envia($destinatario, $assunto, $msg); 
        } else if ($processamentoEdi == 4) {

            $arquivoAux = str_replace("\\", "/", $arquivo);

            $pastas = explode("/", $arquivoAux);

            $destino = $caminho_2;

            if (!is_dir($destino)) {
                mkdir($destino, 0755);
            }

            for ($index = 5; $index < count($pastas) - 1; $index++) {

                $destino .= $pastas[$index] . "/";

                if (!is_dir($destino)) {
                    mkdir($destino, 0755);
                }
            }

            $destino .= $pastas[count($pastas) - 1];

            //$arquivoRenomeado = substr($arquivo, 0, strlen($arquivo) - 4) . "__dup.txt";
            $arquivoRenomeado = substr($destino, 0, strlen($destino) - 4) . "__dup.txt";

            // rename ( $caminho . $arquivo  , $caminho . $arquivoRenomeado );
            //Se ja existir apaga				 
            if (file_exists($arquivoRenomeado)) {
                unlink($arquivoRenomeado);
            }
            rename($arquivo, $arquivoRenomeado);
            //$msg = "Falha ao importar o arquivo ".$arquivo;
            //echo "<br>". $msg;
            //print $Mail->envia($destinatario, $assunto, $msg); 
        }
    }

    echo date("d/m/Y H:i:s");

    $auxdat = date("Y-m-d H:i:s");
    $sqlpar = "Update parametros set datedi='$auxdat',usucodigoedi = " . $usucodigo . " Where parcodigo = 1 ";
    pg_query($sqlpar);

    echo "<meta HTTP-EQUIV='Refresh' CONTENT='5;URL=editrans.php?usuario=$usucodigo'>";

    //echo "<meta HTTP-EQUIV='Refresh' CONTENT='5;URL=importaedi.php?parametro=1'>";
    exit;
}

percorrePastas($caminho, $usucodigo, $caminho_2);
