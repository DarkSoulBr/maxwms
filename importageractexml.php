<?php

//RECEBE PARAMETROS
$parametro = trim($_POST["parametro"]);

header('Content-Type: text/html; charset=iso-8859-1');

set_time_limit(0);

echo "<body style='background-color:#ccccb3'>";
echo "<h3>02/04 - Importação de CT-e Autorizado (Alfaness)</h3>";

ini_set("display_errors", 1);
error_reporting(E_ALL);

$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");

ob_implicit_flush(true);

require("verificasemhttps2.php");

include_once '../nfephpnovo/vendor/autoload.php';

require_once('include/conexao.inc.php');

use NFePHP\DA\NFe\Danfe;
use NFePHP\DA\CTe\Dacce;
use NFePHP\DA\Legacy\FilesFolders;

$data = date('dmY');

$diretorio = "/home/delta/cte/Enviado/Autorizados/$data/";
$diretorio_copia = "/home/delta/cte_enviar/";
$diretorio_copia_b = "arquivos/cte/";
$diretorio_copia_c = "/home/delta/cte/Enviado/Autorizados/{$data}_copia/";

if (!is_dir($diretorio_copia_b)) {
    mkdir($diretorio_copia_b, 0755);
}

//Verifica se a pasta já foi criada pelo UNINFE
if (!is_dir($diretorio)) {
    echo "Pasta não encontrada " . $diretorio . " - " . date("d/m/Y H:i:s");
} else {

    if (!is_dir($diretorio_copia_c)) {
        mkdir($diretorio_copia_c, 0755);
    }

    $ponteiro = new RecursiveDirectoryIterator($diretorio);

    foreach (new RecursiveIteratorIterator($ponteiro) as $listar) {

        if (substr($listar, strlen($listar) - 2, strlen($listar)) == '\.' || substr($listar, strlen($listar) - 2, strlen($listar)) == '/.') {
            
        } else if (substr($listar, strlen($listar) - 3, strlen($listar)) == '\..' || substr($listar, strlen($listar) - 2, strlen($listar)) == '/..') {
            
        } else {
            if (substr($listar, strlen($listar) - 4, 4) == ".XML" || substr($listar, strlen($listar) - 4, 4) == ".xml" || substr($listar, strlen($listar) - 4, 4) == ".Xml") {

                $nomeOriginal = $listar->getFilename();

                //print " Arquivo: <a href='$listar'>$listar</a><br>";
                //Só processa se for um arquivo do tipo Processado
                if (strpos($listar, '-procCTe') !== false || strpos($listar, '-procEventoCTe') !== false) {
                    echo "<span style='color:black'>Arquivo: </span><span style='color:blue'><b>{$listar}</b></span><br>";

                    //Comeca a Importacao
                    $nomeOriginal = $listar->getFilename();

                    $listarx = $listar;

                    if (file_exists($listarx)) {

                        #carrega o arquivo XML e retornando um Array
                        $xml = simplexml_load_file($listarx);

                        //Se retornar false não conseguiu ler passa para o próximo
                        if ($xml === false) {
                            echo "<font color='red'>Atencao: arquivo acima inválido!</font><hr>";
                            continue;
                        } else {

                            //Sera necessario verificar se eh um arquivo de CTe, de Cancelamento ou se eh um XML de algum outro formato

                            $tipoArquivo = 0;

                            //0 - Arquivo sem nenhuma informacao				
                            if (!$xml) {
                                echo "<font color='red'>Atencao, arquivo em branco!</font><hr>";
                                $tipoArquivo = 0;
                            }
                            //1 - CTe Processado pelo SEFAZ					
                            else if ($xml->protCTe->infProt->xMotivo != '') {

                                $tipoArquivo = 1;

                                //Monta a Chave 
                                $nfeChave = '';
                                $contador_atributos = 0;
                                foreach ($xml->CTe->infCte[0]->attributes() as $a => $b) {
                                    $contador_atributos++;
                                    if ($contador_atributos == 1) {
                                        $nfeChave = substr($b, 3);
                                    }
                                }

                                $chavenfe = $nfeChave;
                                $cte_numero = str_pad($xml->CTe->infCte->ide->nCT, 9, "0", STR_PAD_LEFT);

                                echo "<font color='green'>CT-e: <b>{$cte_numero}</b></font><br>";
                                echo "<font color='green'>Chave: <b>{$chavenfe}</b></font><br>";
                                echo "<font color='green'>Sefaz: <b>{$xml->protCTe->infProt->xMotivo}</b></font><br>";
                            }
                            //2 - CTe Nao Processado pelo SEFAZ
                            else if ($xml->infCte->ide->nCT != '') {
                                echo "<font color='red'>Atencao, CTe nao processado pelo SEFAZ!</font><hr>";
                                $tipoArquivo = 2;

                                //Monta a Chave 
                                $nfeChave = '';
                                $contador_atributos = 0;
                                foreach ($xml->infCte[0]->attributes() as $a => $b) {
                                    $contador_atributos++;
                                    if ($contador_atributos == 1) {
                                        $nfeChave = substr($b, 3);
                                    }
                                }

                                $chavenfe = $nfeChave;
                                $cte_numero = str_pad($xml->infCte->ide->nCT, 9, "0", STR_PAD_LEFT);
                            }
                            //3 - Arquivo de Evento Processado pelo SEFAZ
                            else if ($xml->retEventoCTe->infEvento->xMotivo != '') {

                                //Verifica se é um Cancelamento ou uma Carta de Correção                                
                                if ($xml->retEventoCTe->infEvento->tpEvento == '110111') {
                                    echo "<font color='blue'>Cancelamento de CTe Processado pelo SEFAZ: <b>{$xml->retEventoCTe->infEvento->xMotivo}</b></font><hr>";

                                    $chaveOri = $xml->eventoCTe->infEvento->chCTe;
                                    $cte_numero = substr($chaveOri, 25, 9);

                                    $tipoArquivo = 3;
                                } else if ($xml->retEventoCTe->infEvento->tpEvento == '110110') {
                                    echo "<font color='blue'>Carta de Correcao de CTe Processada pelo SEFAZ: <b>{$xml->retEventoCTe->infEvento->xMotivo}</b></font><hr>";

                                    $chaveOri = $xml->eventoCTe->infEvento->chCTe;
                                    $cte_numero = substr($chaveOri, 25, 9);

                                    $tipoArquivo = 6;
                                } else {
                                    echo "<font color='red'>Atencao, evento nao suportado!</font><hr>";
                                    $tipoArquivo = 5;
                                }
                            }
                            //4 - Arquivo de Evento nao Processado pelo SEFAZ
                            else if ($xml->infEvento->chCTe != '') {
                                echo "<font color='red'>Atencao, Cancelamento de CTe nao processado pelo SEFAZ!</font><hr>";
                                $tipoArquivo = 4;
                            }
                            //5 - Arquivo XML de nenhum formato esperado.
                            else {
                                echo "<font color='red'>Atencao, tipo de arquivo nao suportado!</font><hr>";
                                $tipoArquivo = 5;
                            }
                        }

                        //Se for um arquivo de CT-e autorizado pelo SEFAZ
                        if ($tipoArquivo == 1) {

                            //Verifica se já foi importado
                            $auxTransportadora = "";
                            $auxRecebto = "";
                            $auxEmitente = "";
                            $auxRemetente = "";
                            $auxDestinatario = "";
                            $auxExiste = 0;

                            $sqlCte = "SELECT cterecebto,cteobsgeral,cteemicnpj,cteemirazao,cteremcnpj,cteremrazao,ctedescnpj,ctedesrazao FROM cte WHERE ctenum = '$cte_numero'";
                            $cadCte = pg_query($sqlCte);
                            $rowCte = pg_num_rows($cadCte);
                            if ($rowCte > 0) {
                                $auxExiste = 1;
                                $auxRecebto = pg_fetch_result($cadCte, 0, "cterecebto");
                                $auxTransportadora = pg_fetch_result($cadCte, 0, "cteobsgeral");
                                $auxEmitente = trim(pg_fetch_result($cadCte, 0, "cteemicnpj")) . ' ' . trim(pg_fetch_result($cadCte, 0, "cteemirazao"));
                                $auxRemetente = trim(pg_fetch_result($cadCte, 0, "cteremcnpj")) . ' ' . trim(pg_fetch_result($cadCte, 0, "cteremrazao"));
                                $auxDestinatario = trim(pg_fetch_result($cadCte, 0, "ctedescnpj")) . ' ' . trim(pg_fetch_result($cadCte, 0, "ctedesrazao"));
                            }

                            if ($auxRecebto == "" && $auxExiste == 1) {

                                $nProt = (string) $xml->protCTe->infProt->nProt;
                                $xMotivo = $xml->protCTe->infProt->xMotivo;
                                $dhRecbto = str_replace('T', ' ', $xml->protCTe->infProt->dhRecbto);
                                if ($dhRecbto == '') {
                                    $dhRecbto = "null";
                                } else {
                                    $dhRecbto = "'$dhRecbto'";
                                }

                                $update = "UPDATE cte SET ctenProt='$nProt',cterecebto=$dhRecbto,ctemotivo='$xMotivo' WHERE ctenum = '$cte_numero'";
                                pg_query($update);

                                $listar1 = $listarx;

                                //Fase 1 - Faz uma copia para a pasta de envio
                                if ($cte_numero == '') {
                                    $cte_numero = 'nao_importado';
                                }

                                //Gera uma segunda copia na pasta do CT-e para o usuario poder visualizar
                                $destino = $diretorio_copia_b . $cte_numero . '/';

                                if (!is_dir($destino)) {
                                    mkdir($destino, 0755);
                                }

                                $copia = $destino . $nomeOriginal;

                                if (file_exists($copia)) {
                                    unlink($copia);
                                }
                                copy($listar1, $copia);

                                //Se existir o PDF apaga
                                $copia2 = $destino . substr($nomeOriginal, 0, strlen($nomeOriginal) - 4) . ".pdf";
                                if (file_exists($copia2)) {
                                    unlink($copia2);
                                }

                                //Atenção : Retirei isso em 03/11 
                                //Gera o PDF do CT-e
                                exibir_dacte($copia, $cte_numero, $copia2);

                                $destino = $diretorio_copia . $cte_numero . '/';

                                if (!is_dir($destino)) {
                                    mkdir($destino, 0755);
                                }

                                $copia = $destino . $nomeOriginal;

                                if (file_exists($copia)) {
                                    unlink($copia);
                                }
                                copy($listar1, $copia);

                                //Se existir o PDF apaga
                                $copia2 = $destino . substr($nomeOriginal, 0, strlen($nomeOriginal) - 4) . ".pdf";
                                if (file_exists($copia2)) {
                                    unlink($copia2);
                                }

                                //Atenção : Retirei isso em 03/11 
                                //Gera o PDF do CT-e
                                exibir_dacte($copia, $cte_numero, $copia2);

                                //Envia e-mail para a Transportadora com a Cópia do CT-e 
                                $auxCNPJ = localizarCNPJ($auxTransportadora);

                                if ($auxCNPJ != "") {

                                    $tracodigo = 0;
                                    $tranguerra = "";
                                    $traemail = "";

                                    

                                    // Envia copia para os usuários cadastrados

                                    $sql_mail = "SELECT anaemail FROM analiseemail";
                                    $sql_mail = pg_query($sql_mail);
                                    $row_mail = pg_num_rows($sql_mail);
                                    if ($row_mail) {
                                        for ($im = 0; $im < $row_mail; $im++) {
                                            if ($traemail == '') {
                                                $traemail = pg_fetch_result($sql_mail, $im, "anaemail");
                                            } else {
                                                $traemail = $traemail . ";" . pg_fetch_result($sql_mail, $im, "anaemail");
                                            }
                                        }
                                    }


                                    //var_dump($copia, $copia2, $cte_numero, $chavenfe, $nProt, $auxEmitente, $auxRemetente, $auxDestinatario, $traemail);
                                    //die;
                                    //Faz a Cópia para a Pasta de Transportadoras
                                    if ($tranguerra != '') {

                                        $copiaFTP = "/home/delta/Transportadoras/alfaness/";
                                        if (!is_dir($copiaFTP)) {
                                            mkdir($copiaFTP, 0755);
                                        }

                                        $pasta = explode(" ", $tranguerra);

                                        $copiaFTP .= "/" . strtolower(trim($pasta[0])) . '/';
                                        if (!is_dir($copiaFTP)) {
                                            mkdir($copiaFTP, 0755);
                                        }

                                        $copia = $copiaFTP . $nomeOriginal;

                                        if (file_exists($copia)) {
                                            unlink($copia);
                                        }
                                        copy($listar1, $copia);

                                        //Se existir o PDF apaga
                                        $copia2 = $copiaFTP . substr($nomeOriginal, 0, strlen($nomeOriginal) - 4) . ".pdf";
                                        if (file_exists($copia2)) {
                                            unlink($copia2);
                                        }

                                        //Gera o PDF do CT-e
                                        exibir_dacte($copia, $cte_numero, $copia2);
                                    }


                                    if ($traemail != '') {
                                        echo "<font color='#990099'><b>Enviando e-mail para " . $tranguerra . " (" . $traemail . ")!</b></font><br>";
                                        //RECOLOCAR
                                        enviaEmail($copia, $copia2, $cte_numero, $chavenfe, $nProt, $auxEmitente, $auxRemetente, $auxDestinatario, $traemail);
                                    }
                                }
                                echo "<font color='green'><b>CT-e importado com sucesso!</b></font><hr>";
                            } else {
                                if ($auxExiste == 1) {
                                    echo "<font color='red'><b>CT-e já importado!</b></font><hr>";
                                } else {
                                    echo "<font color='red'><b>CT-e não encontrado!</b></font><hr>";
                                }
                            }
                        } else if ($tipoArquivo == 3) {

                            $chaveOri = $xml->eventoCTe->infEvento->chCTe;
                            $cte_numero = substr($chaveOri, 25, 9);

                            $nProt = $xml->retEventoCTe->infEvento->nProt;
                            if ($nProt == '') {
                                $nProt = "null";
                            } else {
                                $nProt = "'$nProt '";
                            }

                            $xMotivo = $xml->retEventoCTe->infEvento->xMotivo;
                            $dhRecbto = str_replace('T', ' ', $xml->retEventoCTe->infEvento->dhRegEvento);
                            if ($dhRecbto == '') {
                                $dhRecbto = "null";
                            } else {
                                $dhRecbto = "'$dhRecbto'";
                            }

                            $update = "Update cte set ctecancnProt=$nProt,ctecancrecebto=$dhRecbto,ctecancmotivo='$xMotivo' Where ctenum = '$cte_numero'";
                            pg_query($update);
                        } else if ($tipoArquivo == 6) {

                            $nfeChave = '';
                            $contador_atributos = 0;
                            foreach ($xml->eventoCTe->infEvento[0]->attributes() as $a => $b) {
                                $contador_atributos++;

                                if ($contador_atributos == 1) {
                                    $nfeChave = $b;
                                }
                            }

                            $chavenfe = $nfeChave;

                            $chaveOri = $xml->eventoCTe->infEvento->chCTe;
                            $cte_numero = substr($chaveOri, 25, 9);

                            $nProt = $xml->retEventoCTe->infEvento->nProt;
                            if ($nProt == '') {
                                $nProt = "null";
                            } else {
                                $nProt = "'$nProt '";
                            }

                            $xMotivo = $xml->retEventoCTe->infEvento->xMotivo;
                            $dhRecbto = str_replace('T', ' ', $xml->retEventoCTe->infEvento->dhRegEvento);
                            if ($dhRecbto == '') {
                                $dhRecbto = "null";
                            } else {
                                $dhRecbto = "'$dhRecbto'";
                            }

                            $update = "UPDATE ctecartacorrecao SET cccnProt=$nProt,cccrecebto=$dhRecbto,cccmotivo='$xMotivo' WHERE cccchave = '$chavenfe'";
                            pg_query($update);

                            $listar1 = $listarx;

                            //Fase 1 - Faz uma copia para a pasta de envio
                            if ($cte_numero == '') {
                                $cte_numero = 'nao_importado';
                            }

                            //Gera uma segunda copia na pasta do CT-e para o usuario poder visualizar
                            $destino = $diretorio_copia_b . $cte_numero . '/';

                            if (!is_dir($destino)) {
                                mkdir($destino, 0755);
                            }

                            $copia = $destino . $nomeOriginal;

                            if (file_exists($copia)) {
                                unlink($copia);
                            }
                            copy($listar1, $copia);

                            //Se existir o PDF apaga
                            $copia2 = $destino . substr($nomeOriginal, 0, strlen($nomeOriginal) - 4) . ".pdf";
                            if (file_exists($copia2)) {
                                unlink($copia2);
                            }

                            //Atenção : Retirei isso em 03/11 
                            //Gera o PDF do CT-e
                            exibir_dacce($copia, $cte_numero, $copia2);

                            $destino = $diretorio_copia . $cte_numero . '/';

                            if (!is_dir($destino)) {
                                mkdir($destino, 0755);
                            }

                            $copia = $destino . $nomeOriginal;

                            if (file_exists($copia)) {
                                unlink($copia);
                            }
                            copy($listar1, $copia);

                            //Se existir o PDF apaga
                            $copia2 = $destino . substr($nomeOriginal, 0, strlen($nomeOriginal) - 4) . ".pdf";
                            if (file_exists($copia2)) {
                                unlink($copia2);
                            }

                            //Atenção : Retirei isso em 03/11 
                            //Gera o PDF do CT-e
                            exibir_dacce($copia, $cte_numero, $copia2);
                        }
                    }
                }

                $listar1 = $listar;

                $copia_c = $diretorio_copia_c . $nomeOriginal;

                if (file_exists($copia_c)) {
                    unlink($copia_c);
                }
                copy($listar1, $copia_c);

                $listar2 = substr($listar1, 0, strlen($listar) - 4) . ".imp";

                //Se ja existir um .imp apaga
                if (file_exists($listar2)) {
                    unlink($listar2);
                }
                rename($listar1, $listar2);
            }
        }
    }

    echo "Nenhum CT-e encontrado em " . $diretorio . " - " . date("d/m/Y H:i:s");
}

echo "<meta HTTP-EQUIV='Refresh' CONTENT='5;URL=importageractexml.php?parametro=1'>";
exit;

function soNumero($str) {
    return preg_replace("/[^0-9]/", "", $str);
}

function exibir_dacte($arquivo, $cte_numero, $arquivo2) {

    $docxml = NFePHP\DA\Legacy\FilesFolders::readFile($arquivo);

    $xml = simplexml_load_string($docxml);
    //$xml = simplexml_load_string($arquivo);
    //Verifica se esta processado
    if ($xml->CTe->infCte->ide->nCT != '') {
        $versao = $xml->CTe->infCte["versao"];
    } else {
        $versao = $xml->infCte["versao"];
    }

    $dacte = new NFePHP\DA\CTe\DacteV3($docxml, 'P', 'A4', '', 'I', '');

    $id = $dacte->montaDACTE();
    $teste = $dacte->printDACTE($arquivo2, 'F');
}

function exibir_dacce($arquivo, $cte_numero, $arquivo2) {

    $docxml = NFePHP\DA\Legacy\FilesFolders::readFile($arquivo);

    $xml = simplexml_load_string($docxml);

    $sql2 = "SELECT a.empcodigo,a.clinguerra,a.clicod,a.clirazao,a.clisuframa,a.clicnpj,a.cliie,a.clirg,a.clicpf,a.cliobs,a.clipessoa
            ,a.clicep,a.cliendereco,a.clibairro,a.clifone,a.clicomplemento,a.cliemail,a.cidcodigoibge,a.clinumero,a.cidcodigo
            ,b.descricao,b.uf        
            FROM  empresa a        
            LEFT JOIN cidades as b on a.cidcodigo = b.cidcodigo 
	    WHERE a.clicod = 1";

    $sql2 = pg_query($sql2);
    $row2 = pg_num_rows($sql2);
    $razao = '';
    $logradouro = '';
    $numero = '';
    $complemento = '';
    $bairro = '';
    $CEP = '';
    $municipio = '';
    $UF = '';
    $telefone = '';
    $email = '';
    if ($row2) {
        $razao = pg_fetch_result($sql2, 0, "clirazao");
        $logradouro = pg_fetch_result($sql2, 0, "cliendereco");
        $numero = pg_fetch_result($sql2, 0, "clinumero");
        $complemento = pg_fetch_result($sql2, 0, "clicomplemento");
        $bairro = pg_fetch_result($sql2, 0, "clibairro");
        $CEP = pg_fetch_result($sql2, 0, "clicep");
        $municipio = pg_fetch_result($sql2, 0, "descricao");
        $UF = pg_fetch_result($sql2, 0, "uf");
        $telefone = pg_fetch_result($sql2, 0, "clifone");
        $email = pg_fetch_result($sql2, 0, "cliemail");
    }

    $aEnd = array(
        'razao' => $razao,
        'logradouro' => $logradouro,
        'numero' => $numero,
        'complemento' => $complemento,
        'bairro' => $bairro,
        'CEP' => substr($CEP, 0, 5) . '-' . substr($CEP, 5, 3),
        'municipio' => $municipio,
        'UF' => $UF,
        'telefone' => $telefone,
        'email' => $email
    );

    $dacce = new NFePHP\DA\CTe\Dacce($docxml, 'L', 'A4', '', 'I', $aEnd);

    $id = $dacce->monta();
    $teste = $dacce->printDACCE($arquivo2, 'F');
}

function formatar($string, $tipo = "") {
    $string = preg_replace("[^0-9]", "", $string);
    if (!$tipo) {
        switch (strlen($string)) {
            case 10: $tipo = 'fone';
                break;
            case 8: $tipo = 'cep';
                break;
            case 11: $tipo = 'cpf';
                break;
            case 14: $tipo = 'cnpj';
                break;
        }
    }
    switch ($tipo) {
        case 'fone':
            $string = '(' . substr($string, 0, 2) . ') ' . substr($string, 2, 4) .
                    '-' . substr($string, 6);
            break;
        case 'cep':
            $string = substr($string, 0, 5) . '-' . substr($string, 5, 3);
            break;
        case 'cpf':
            $string = substr($string, 0, 3) . '.' . substr($string, 3, 3) .
                    '.' . substr($string, 6, 3) . '-' . substr($string, 9, 2);
            break;
        case 'cnpj':
            $string = substr($string, 0, 2) . '.' . substr($string, 2, 3) .
                    '.' . substr($string, 5, 3) . '/' .
                    substr($string, 8, 4) . '-' . substr($string, 12, 2);
            break;
        case 'rg':
            $string = substr($string, 0, 2) . '.' . substr($string, 2, 3) .
                    '.' . substr($string, 5, 3);
            break;
    }
    return $string;
}

function delimitador($variavel, $tamanho, $alinhamento, $preenchimento) {
    if ($tamanho < 10 && $alinhamento == 'R' && $preenchimento == '0')
        $strtam = "%0" . $tamanho . "s";
    else if ($tamanho < 10 && $alinhamento == 'L' && $preenchimento == '0')
        $strtam = "%-0" . $tamanho . "s";
    else if ($tamanho < 10 && $alinhamento == 'R' && $preenchimento == ' ')
        $strtam = "%" . $tamanho . "s";
    else if ($tamanho < 10 && $alinhamento == 'L' && $preenchimento == ' ')
        $strtam = "%-" . $tamanho . "s";

    if ($tamanho >= 10 && $alinhamento == 'R' && $preenchimento == '0')
        $strtam = "%0" . $tamanho . "s";
    else if ($tamanho >= 10 && $alinhamento == 'L' && $preenchimento == '0')
        $strtam = "%-0" . $tamanho . "s";
    else if ($tamanho >= 10 && $alinhamento == 'R' && $preenchimento == ' ')
        $strtam = "%" . $tamanho . "s";
    else if ($tamanho >= 10 && $alinhamento == 'L' && $preenchimento == ' ')
        $strtam = "%-" . $tamanho . "s";

    $var = substr(sprintf($strtam, $variavel), 0, $tamanho);
    return $var;
}

function dvCalcMod11($key_nfe) {
    $base = 9;
    $result = 0;
    $sum = 0;
    $factor = 2;

    for ($i = strlen($key_nfe); $i > 0; $i--) {
        $numbers[$i] = substr($key_nfe, $i - 1, 1);
        $partial[$i] = $numbers[$i] * $factor;
        $sum += $partial[$i];
        if ($factor == $base) {
            $factor = 1;
        }
        $factor++;
    }

    if ($result == 0) {
        $sum *= 10;
        $digit = $sum % 11;
        if ($digit == 10) {
            $digit = 0;
        }
        return $digit;
    } elseif ($result == 1) {
        $rest = $sum % 11;
        return $rest;
    }
}

function removeTodosCaracterEspeciaisEspaco($text) {
    $palavra = $text;
    if (version_compare(PHP_VERSION, '7.0.0', '<')) {
        $palavra = ereg_replace("[^a-zA-Z0-9]", "", strtr($palavra, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ-", "aaaaeeiooouucAAAAEEIOOOUUC"));
    } else {
        $palavra = preg_replace("[^a-zA-Z0-9]", "", strtr($palavra, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ-", "aaaaeeiooouucAAAAEEIOOOUUC"));
    }
    return $palavra;
}

function localizarCNPJ($string) {

    $tamanho = strlen($string);
    $retorno = "";

    for ($cont = 0; $cont <= $tamanho; $cont++) {
        if (is_numeric(substr($string, $cont, 1)) &&
                is_numeric(substr($string, $cont + 1, 1)) &&
                substr($string, $cont + 2, 1) == '.' &&
                is_numeric(substr($string, $cont + 3, 1)) &&
                is_numeric(substr($string, $cont + 4, 1)) &&
                is_numeric(substr($string, $cont + 5, 1)) &&
                substr($string, $cont + 6, 1) == '.' &&
                is_numeric(substr($string, $cont + 7, 1)) &&
                is_numeric(substr($string, $cont + 8, 1)) &&
                is_numeric(substr($string, $cont + 9, 1)) &&
                substr($string, $cont + 10, 1) == '/' &&
                is_numeric(substr($string, $cont + 11, 1)) &&
                is_numeric(substr($string, $cont + 12, 1)) &&
                is_numeric(substr($string, $cont + 13, 1)) &&
                is_numeric(substr($string, $cont + 14, 1)) &&
                substr($string, $cont + 15, 1) == '-' &&
                is_numeric(substr($string, $cont + 16, 1)) &&
                is_numeric(substr($string, $cont + 17, 1))) {

            $retorno = substr($string, $cont, 18);
            break;
        }
    }
    return $retorno;
}

function enviaEmail($arquivoxml, $arquivopdf, $numeroEmail, $chaveEmail, $protocoloEmail, $emiEmail, $remEmail, $desEmail, $email) {

    //Usa os dados da tabela de Parametros
    $sqlmail = "Select * from parametrosemail LIMIT 1";
    $cadmail = pg_query($sqlmail);
    if (pg_num_rows($cadmail)) {
        $paremail = pg_fetch_result($cadmail, 0, "email");
        $parsenha = pg_fetch_result($cadmail, 0, "senha");
        $parsmtp = pg_fetch_result($cadmail, 0, "smtp");
        $parporta = pg_fetch_result($cadmail, 0, "usuario");
        $smtpuser = pg_fetch_result($cadmail, 0, "smtpuser");
        $smtppass = pg_fetch_result($cadmail, 0, "smtppass");
    } else {
        $paremail = '';
        $parsenha = '';
        $parsmtp = '';
        $parporta = '';
        $smtpuser = '';
        $smtppass = '';
    }
    $from = $paremail;

    $nomedoarquivo = "enviaxml" . date("YmdHis") . ".txt";
    $acao = "1";
    $id = "'";

    $destinatarios = '';
    $remetente = $from;
    $assunto = '';
    $mensagem = '';

    $path = DIR_ROOT . '/lib';
    set_include_path(get_include_path() . PATH_SEPARATOR . $path);
    require_once("Zend/Loader/Autoloader.php");

    $autoloader = Zend_Loader_Autoloader::getInstance();
    $autoloader->setFallbackAutoloader(true);

    $data = date("d/m/Y H:i:s");

    if (!$smtpuser) {
        $config = array("auth" => "login", "username" => $paremail, "password" => $parsenha, "port" => $parporta);
    } else {
        $config = array("ssl" => "tls", "auth" => "login", "username" => $smtpuser, "password" => $smtppass, "port" => $parporta);
    }
    $tr = new Zend_Mail_Transport_Smtp($parsmtp, $config);

    Zend_Mail::setDefaultTransport($tr);
    //funcao para envio de email - Zend_Mail
    $mail = new Zend_Mail();

    $mail->setFrom($remetente, "Alfaness Logística");

    $texto = $email;

    $mails = explode(";", $texto);

    foreach ($mails as $value) {

        if (trim($value)) {

            $mail->addTo(trim(strtolower($value)));
            $destinatarios .= trim(strtolower($value));
        }
    }

    $msg = "";

    $assunto = "CT-e " . $numeroEmail;

    $mail->setSubject($assunto);

    $msg .= '<p><span style="font-family:tahoma,geneva,sans-serif;">' . "Esta mensagem refere-se ao Conhecimento de Transporte Eletrônico de número " . $numeroEmail . " emitido em " . date("d/m/Y") . '</span></p>';

    $msg .= '<p><span style="font-family:tahoma,geneva,sans-serif;">' . "Emitente: " . $emiEmail . '</span></p>';
    $msg .= '<p><span style="font-family:tahoma,geneva,sans-serif;">' . "Remetente: " . $remEmail . '</span></p>';
    $msg .= '<p><span style="font-family:tahoma,geneva,sans-serif;">' . "Destinatário: " . $desEmail . '</span></p>';

    $msg .= '<p><span style="font-family:tahoma,geneva,sans-serif;">' . "Para verificar a autorização da SEFAZ referente ao CT-e acima mencionado, acesse o endereço http://www.cte.fazenda.gov.br/portal/" . '</span></p>';

    $msg .= '<p><span style="font-family:tahoma,geneva,sans-serif;">' . "Chave de acesso: CT-e" . $chaveEmail . '</span></p>';
    $msg .= '<p><span style="font-family:tahoma,geneva,sans-serif;">' . "Protocolo: " . $protocoloEmail . '</span></p>';

    $msg .= '<p><span style="font-family:tahoma,geneva,sans-serif;">' . "Este e-mail foi enviado automaticamente pelo Sistema de Conhecimento de Transporte Eletrônico (CT-e) da ALFANESS LOGISTICA LTDA" . '</span></p>';

    //$msg .= '<p><span style="font-size:11px;"><em><span style="font-family: tahoma,geneva,sans-serif;">' . "Enviado via Maxtrade - www.morsolucoes.com" . '</span></em></span></p>';

    $mail->setBodyHTML($msg);

    $temanexo = 0;
    $tempdf = 0;

    if (file_exists($arquivoxml)) {

        $file = $arquivoxml;

        $at = new Zend_Mime_Part(file_get_contents($file));
        $at->filename = basename($file);
        $at->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
        //$at->encoding = Zend_Mime::ENCODING_8BIT;
        $at->encoding = Zend_Mime::ENCODING_BASE64;

        $mail->addAttachment($at);

        $temanexo = 1;
    }

    if (file_exists($arquivopdf)) {

        $file = $arquivopdf;

        $at = new Zend_Mime_Part(file_get_contents($file));
        $at->filename = basename($file);
        $at->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
        //$at->encoding = Zend_Mime::ENCODING_8BIT;
        $at->encoding = Zend_Mime::ENCODING_BASE64;

        $mail->addAttachment($at);

        $tempdf = 1;
    }


    if ($temanexo == 1 && $tempdf == 1) {
        try {
            $mail->send();
            echo "<font color='#990099'><b>E-mail Encaminhado!</b></font><br>";
            logEmail("EMAIL ENCAMINHADO ", $nomedoarquivo, $texto, $remetente, $assunto, $msg, date("Y-m-d H:i:s"));
        } catch (Exception $e) {
            echo "<font color='#990099'><b>Não foi possivel enviar o e-mail, erro: " . $e->getMessage() . "</b></font><br>";
            logEmail("NAO FOI POSSIVEL ENVIAR O EMAIL" . $e->getMessage(), $nomedoarquivo, $texto, $remetente, $assunto, $msg, date("Y-m-d H:i:s"), true);
        }
    } else {
        echo "<font color='#990099'><b>Não foi possivel anexar os arquivos XML e PDF" . "</b></font><br>";
        logEmail("NAO FOI POSSIVEL ANEXAR OS ARQUIVOS XML E PDF", $nomedoarquivo, $texto, $remetente, $assunto, $msg, date("Y-m-d H:i:s"), true);
    }
}

function logEmail($msg, $nomedoarquivo, $destinatarios, $remetente, $assunto, $mensagem, $data, $reenvio = false) {

    $caminho = '/home/delta/email/';
    if (!is_dir($caminho)) {
        mkdir($caminho, 0755);
    }

    $fp = fopen('/home/delta/email/' . $nomedoarquivo, 'a+');
    fwrite($fp, $msg . " EM " . $data . "\n");
    if ($reenvio) {
        fwrite($fp, "NOVA TENTATIVA DE ENVIO EM 1 HORA.\n");
    }
    fwrite($fp, "DESTINATARIO(S): " . $destinatarios . "\n");
    fwrite($fp, "REMETENTE: " . $remetente . "\n");
    fwrite($fp, "ASSUNTO: " . $assunto . "\n");
    fwrite($fp, "MENSAGEM: " . strip_tags($mensagem) . "\n\n\n");
    fclose($fp);
}
?>

