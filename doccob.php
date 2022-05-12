<?php

/**
 * faz a leitura do arquivo segundo layout DOCCOB 3.0
 *
 * Visa obter informação da Nota Fiscal/Fatura de serviço emitida para a cobrança dos serviços de transporte de carga prestados à Embarcadora
 *
 * A sequencia das variaveis de leitura e seus nomes sao semelhantes ao manual DOCCOB - PROCEDA
 */
/*
 * steps
 * 1. estabilishing ftp carrier
 * 2. get DOCCOB carrier file ( on test will be read localhost file)
 * 3. read DOCCOB file - goal for this moment
 * 4. populate these data on database
 */

require_once('./_app/Config.inc.php');
include_once('include/funcoes/parser.php');
include_once('include/config.php');
require_once("include/funcoes/removeCaracterEspecial.php");

function ValidaData($dat) {
    $data = explode("/", "$dat"); // fatia a string $dat em pedados, usando / como referência
    $d = $data[0];
    $m = $data[1];
    $y = $data[2];

    // verifica se a data é válida!
    // 1 = true (válida)
    // 0 = false (inválida)
    $res = checkdate($m, $d, $y);
    if ($res == 1) {
        echo "data ok!";
    } else {
        echo "data inválida!";
    }
}

function doccobReg000($textoLinhaArquivo, $arquivo) {
    //registro "000"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $remetente = substr($textoLinhaArquivo, 3, 35);    
    $remetente = trim(removeTodosCaracterEspeciais($remetente));   
    $destinatario = substr($textoLinhaArquivo, 38, 35);
    $data = substr($textoLinhaArquivo, 73, 6);
    $hora = substr($textoLinhaArquivo, 79, 4);
    $id_intercambio = substr($textoLinhaArquivo, 83, 12);

    $dataYYYYMMDD_hora = "20" . substr($data, 4, 2) . "-" . substr($data, 2, 2) . "-" . substr($data, 0, 2) . " " . substr($hora, 0, 2) . ":" . substr($hora, 2, 2);

////echo  $id_registro . "_____" . $remetente . "" .$destinatario . "" .$data . "" .$hora . "" .$id_intercambio . "<br/>";

    $record['remetente'] = trim($remetente);
    $record['destinatario'] = $destinatario;
    $record['data'] = $dataYYYYMMDD_hora;
    $record['id_intercambio'] = trim($id_intercambio);

//Lers - 22/08/2012
//Troquei essa parte para mandar o nome do arquivo sem o Path pra não dar erro 
//$record['nome_arquivo'] = $arquivo;
    $record['nome_arquivo'] = trim(basename($arquivo));
    $record['importacao'] = date("Y-m-d H:i:s");

    return $record;
}

function doccobReg350($textoLinhaArquivo) {
// registro "350"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $id_doc = substr($textoLinhaArquivo, 3, 14); //COBRADDMMHHMMS
////echo  $id_registro . "_____" . $id_doc . "<br/>";

    $record['id_doc'] = $id_doc;
    return $record;
}

function doccobReg550($textoLinhaArquivo) {
// registro "550"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $id_doc = substr($textoLinhaArquivo, 3, 14); //COBRADDMMHHMMS
////echo  $id_registro . "_____" . $id_doc . "<br/>";

    $record['id_doc'] = $id_doc;
    return $record;
}

function doccobReg351($textoLinhaArquivo) {
// registro "351"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $cnpj_trans = substr($textoLinhaArquivo, 3, 14);
    $razaosocial_trans = substr($textoLinhaArquivo, 17, 40);

////echo  $id_registro . "_____" . $cnpj_trans . "". $razaosocial_trans  . "<br/>";

    $record['cnpj_trans'] = $cnpj_trans;
    $record['razaosocial_trans'] = $razaosocial_trans;
    return $record;
}

function doccobReg551($textoLinhaArquivo) {
// registro "551"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $cnpj_trans = substr($textoLinhaArquivo, 3, 14);
    $razaosocial_trans = substr($textoLinhaArquivo, 17, 50);
    
    $razaosocial_trans = trim(removeTodosCaracterEspeciais($razaosocial_trans));  


    $record['cnpj_trans'] = $cnpj_trans;
    $record['razaosocial_trans'] = $razaosocial_trans;
    return $record;
}

function doccobReg352($textoLinhaArquivo, $doccobcod) {
// registro "352"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $filial_emissora_doc = substr($textoLinhaArquivo, 3, 10);
    $tp_doc = substr($textoLinhaArquivo, 13, 1); // 0 = NF FATURA, 1 = ROMANEIO
    $serie_doc = substr($textoLinhaArquivo, 14, 3);
    $num_doc = substr($textoLinhaArquivo, 17, 10); // ver tabela ocoren_desc
    $emissao = substr($textoLinhaArquivo, 27, 8); //DDMMAAAA
    $emissao = substr($emissao, 4, 4) . "-" . substr($emissao, 2, 2) . "-" . substr($emissao, 0, 2); //DDMMAAAA
    $vencimento = substr($textoLinhaArquivo, 35, 8); //DDMMAAAA
    $vencimento = substr($vencimento, 4, 4) . "-" . substr($vencimento, 2, 2) . "-" . substr($vencimento, 0, 2);
    $valor_doc = substr($textoLinhaArquivo, 43, 15); // formato 13.2
    $tp_cobranca = substr($textoLinhaArquivo, 58, 3);
    $valor_total_icms = substr($textoLinhaArquivo, 61, 15); // formato 13.2
    $valor_juros_dia_atraso = substr($textoLinhaArquivo, 76, 15); // formato 13.2
    $limite_pgto_cdesc = substr($textoLinhaArquivo, 91, 8); //DDMMAAAA
    $limite_pgto_cdesc = substr($limite_pgto_cdesc, 4, 4) . "-" . substr($limite_pgto_cdesc, 2, 2) . "-" . substr($limite_pgto_cdesc, 0, 2); //DDMMAAAA
    $valor_desc = substr($textoLinhaArquivo, 99, 15); //formato 13.2
    $nome_banco = substr($textoLinhaArquivo, 114, 35);

    $nome_banco = trim(removeTodosCaracterEspeciais($nome_banco));

    $agencia = substr($textoLinhaArquivo, 149, 4);
    $ag_digverif = substr($textoLinhaArquivo, 153, 1);
    $contacorrente = substr($textoLinhaArquivo, 154, 10);
    $cc_dig_verif = substr($textoLinhaArquivo, 164, 2);
    $acao_doc = substr($textoLinhaArquivo, 166, 1); // I = INCLUIR, E = EXCLUIR/ CANCELAR


    $record['filial_emissora_doc'] = $filial_emissora_doc;
    $record['tp_doc'] = $tp_doc;
    $record['serie_doc'] = $serie_doc;
    $record['num_doc'] = $num_doc;
    $record['emissao'] = $emissao;
    $record['vencimento'] = $vencimento;
    $record['valor_doc'] = $valor_doc;
    $record['tp_cobranca'] = $tp_cobranca;
    $record['valor_total_icms'] = $valor_total_icms;
    $record['valor_juros_dia_atraso'] = $valor_juros_dia_atraso;
    if ($limite_pgto_cdesc == '0000-00-00') {
        $record['limite_pgto_cdesc'] = $vencimento;
    } else {
        $record['limite_pgto_cdesc'] = $limite_pgto_cdesc;
    }
    $record['valor_desc'] = $valor_desc;
    $record['nome_banco'] = $nome_banco;
    $record['agencia'] = $agencia;
    $record['ag_digverif'] = $ag_digverif;
    $record['contacorrente'] = $contacorrente;
    $record['cc_dig_verif'] = $cc_dig_verif;
    $record['acao_doc'] = $acao_doc;
    $record['doccobcod'] = $doccobcod;
    $record['valor_ori'] = $valor_doc;
    return $record;
}

function doccobReg552($textoLinhaArquivo, $doccobcod) {
// registro "552"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $filial_emissora_doc = substr($textoLinhaArquivo, 3, 10);
    $tp_doc = substr($textoLinhaArquivo, 13, 1); // 0 = NF FATURA, 1 = ROMANEIO
    $serie_doc = substr($textoLinhaArquivo, 14, 3);
    $num_doc = substr($textoLinhaArquivo, 17, 10); // ver tabela ocoren_desc
    $emissao = substr($textoLinhaArquivo, 27, 8); //DDMMAAAA
    $emissao = substr($emissao, 4, 4) . "-" . substr($emissao, 2, 2) . "-" . substr($emissao, 0, 2); //DDMMAAAA
    $vencimento = substr($textoLinhaArquivo, 35, 8); //DDMMAAAA
    $vencimento = substr($vencimento, 4, 4) . "-" . substr($vencimento, 2, 2) . "-" . substr($vencimento, 0, 2);
    $valor_doc = substr($textoLinhaArquivo, 43, 15); // formato 13.2
    $tp_cobranca = substr($textoLinhaArquivo, 58, 3);

//$valor_total_icms = substr($textoLinhaArquivo,61,15);// formato 13.2
    $valor_total_icms = '0'; // formato 13.2

    $valor_juros_dia_atraso = substr($textoLinhaArquivo, 65, 15); // formato 13.2
    $limite_pgto_cdesc = substr($textoLinhaArquivo, 80, 8); //DDMMAAAA
    //Se o campo vier em branco vou usar a Data do Vencimento
    if(trim($limite_pgto_cdesc)=='') {
        $limite_pgto_cdesc = $vencimento;
    } else {
        $limite_pgto_cdesc = substr($limite_pgto_cdesc, 4, 4) . "-" . substr($limite_pgto_cdesc, 2, 2) . "-" . substr($limite_pgto_cdesc, 0, 2); //DDMMAAAA 
    }
    $valor_desc = substr($textoLinhaArquivo, 88, 15); //formato 13.2
    $nome_banco = substr($textoLinhaArquivo, 108, 30);
    $nome_banco = trim(removeTodosCaracterEspeciais($nome_banco));
    $agencia = substr($textoLinhaArquivo, 138, 4);
    $ag_digverif = substr($textoLinhaArquivo, 142, 1);
    $contacorrente = substr($textoLinhaArquivo, 143, 10);
    $cc_dig_verif = substr($textoLinhaArquivo, 153, 2);
    $acao_doc = substr($textoLinhaArquivo, 155, 1); // I = INCLUIR, E = EXCLUIR/ CANCELAR

    $record['filial_emissora_doc'] = $filial_emissora_doc;
    $record['tp_doc'] = $tp_doc;
    $record['serie_doc'] = $serie_doc;
    $record['num_doc'] = $num_doc;
    $record['emissao'] = $emissao;
    $record['vencimento'] = $vencimento;
    $record['valor_doc'] = $valor_doc;
    $record['tp_cobranca'] = $tp_cobranca;
    $record['valor_total_icms'] = $valor_total_icms;
    $record['valor_juros_dia_atraso'] = $valor_juros_dia_atraso;
    if ($limite_pgto_cdesc == '0000-00-00') {
        $record['limite_pgto_cdesc'] = $vencimento;
    } else {
        $record['limite_pgto_cdesc'] = $limite_pgto_cdesc;
    }
    $record['valor_desc'] = $valor_desc;
    $record['nome_banco'] = $nome_banco;
    $record['agencia'] = (int) $agencia;
    $record['ag_digverif'] = $ag_digverif;
    $record['contacorrente'] = (int) $contacorrente;
    $record['cc_dig_verif'] = $cc_dig_verif;
    $record['acao_doc'] = $acao_doc;
    $record['doccobcod'] = $doccobcod;
    $record['valor_ori'] = $valor_doc;
    return $record;
}

function doccobReg553($textoLinhaArquivo) {
// registro "553"
    $id_registro = substr($textoLinhaArquivo, 0, 3);

    $valor_total_icms = substr($textoLinhaArquivo, 3, 15); // formato 13.2
    $record['valor_total_icms'] = $valor_total_icms;

    return $record;
}

function doccobReg353($textoLinhaArquivo, $doccobcod, $aux_fatura) {

    if (trim(substr($textoLinhaArquivo, 45, 8)) == '') {
        $modelo = 1;
    } else {
        $d = substr($textoLinhaArquivo, 45, 2);
        $m = substr($textoLinhaArquivo, 47, 2);
        $y = substr($textoLinhaArquivo, 49, 4);
        ;

        $modelo = checkdate($m, $d, $y);
        /*
          if ($modelo == 1){
          echo "data ok!";
          } else {
          echo "data inválida!";
          }
         */
    }



// registro "353"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $filial_emissora = substr($textoLinhaArquivo, 3, 10);
    $conhecimento_serie = substr($textoLinhaArquivo, 13, 5);
    $conhecimento_num = substr($textoLinhaArquivo, 18, 12);

    if ($modelo == 1) {
        $valor_frete = substr($textoLinhaArquivo, 30, 15);
        $conhecimento_emissao = substr($textoLinhaArquivo, 45, 8); //DDMMAAAA
        if (trim($conhecimento_emissao) == '') {
            $conhecimento_emissao = date('Y-m-d'); //DDMMAAAA
        } else {
            $conhecimento_emissao = substr($conhecimento_emissao, 4, 4) . "-" . substr($conhecimento_emissao, 2, 2) . "-" . substr($conhecimento_emissao, 0, 2); //DDMMAAAA	
        }

        $cnpj_remetente = substr($textoLinhaArquivo, 53, 14);
        $cnpj_destinatario = substr($textoLinhaArquivo, 67, 14);
        $cnpj_emissor_conhecimento = substr($textoLinhaArquivo, 81, 14);
    } else {
        $valor_frete = substr($textoLinhaArquivo, 30, 14);
        $conhecimento_emissao = substr($textoLinhaArquivo, 44, 8); //DDMMAAAA
        if (trim($conhecimento_emissao) == '') {
            $conhecimento_emissao = date('Y-m-d'); //DDMMAAAA
        } else {
            $conhecimento_emissao = substr($conhecimento_emissao, 4, 4) . "-" . substr($conhecimento_emissao, 2, 2) . "-" . substr($conhecimento_emissao, 0, 2); //DDMMAAAA	
        }
        $cnpj_remetente = substr($textoLinhaArquivo, 54, 14);
        $cnpj_destinatario = substr($textoLinhaArquivo, 68, 14);
        $cnpj_emissor_conhecimento = substr($textoLinhaArquivo, 82, 14);
    }

    /*
      echo  $id_registro . "_____" . $filial_emissora . "". $conhecimento_serie
      . $conhecimento_num . $valor_frete . $emissao
      . $cnpj_remetente . $cnpj_destinatario . $cnpj_emissor_conhecimento
      . "<br/>";
     */

//$record['cnpj_trans'] = $cnpj_trans;
    $record['filial_emissora'] = $filial_emissora;
    $record['conhecimento_serie'] = $conhecimento_serie;
    $record['conhecimento_num'] = $conhecimento_num;
    $record['valor_frete'] = $valor_frete;
    $record['conhecimento_emissao'] = $conhecimento_emissao;
    $record['cnpj_remetente'] = $cnpj_remetente;
    $record['cnpj_destinatario'] = $cnpj_destinatario;
    $record['cnpj_emissor_conhecimento'] = $cnpj_emissor_conhecimento;
    $record['doccobcod'] = $doccobcod;
    $record['num_doc'] = $aux_fatura;

    return $record;
}

function doccobReg354($textoLinhaArquivo, $doccobcod, $aux_conhecimento, $aux_fatura) {
// registro "354"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $serie = substr($textoLinhaArquivo, 3, 3);
    $nf = substr($textoLinhaArquivo, 6, 8);
    $nf_emissao = substr($textoLinhaArquivo, 14, 8); // DDMMAAAA
    $nf_emissao = substr($nf_emissao, 4, 4) . "-" . substr($nf_emissao, 2, 2) . "-" . substr($nf_emissao, 0, 2); //DDMMAAAA
    $nf_peso = substr($textoLinhaArquivo, 22, 7);
    $nf_valor_mercadoria = substr($textoLinhaArquivo, 29, 15);
    $nf_cnpj_emissor = substr($textoLinhaArquivo, 44, 14);

////echo  $id_registro . "_____" . $serie . "". $nf  . $nf_emissao
//. $nf_peso . $nf_valor_mercadoria . $nf_cnpj_emissor
//. "<br/>";

    $record['serie'] = $serie;
    $record['nf'] = $nf;
    $record['nf_emissao'] = $nf_emissao;
    $record['nf_peso'] = $nf_peso;
    $record['nf_valor_mercadoria'] = $nf_valor_mercadoria;
    $record['nf_cnpj_emissor'] = $nf_cnpj_emissor;
    $record['doccobcod'] = $doccobcod;
    $record['conhecimento_num'] = $aux_conhecimento; //Vai gravar o Conhecimento do Registro 353 anterior;
    $record['num_doc'] = $aux_fatura; //Vai gravar a Fatura do Registro 352 anterior;

    return $record;
}

function doccobReg355($textoLinhaArquivo) {
// registro "355"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $qtd_total_doc = substr($textoLinhaArquivo, 3, 4);
    $valor_total_doc = substr($textoLinhaArquivo, 7, 15); // formato 13.2
//echo   $id_registro . "_____" . $qtd_total_doc . "". $valor_total_doc  . "<br/>";

    $record['qtd_total_doc'] = $qtd_total_doc;
    $record['valor_total_doc'] = $valor_total_doc;
    return $record;
}

function doccobReg555($textoLinhaArquivo, $doccobcod, $aux_fatura) {

// registro "555"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $filial_emissora = substr($textoLinhaArquivo, 3, 10);
    $conhecimento_serie = substr($textoLinhaArquivo, 13, 5);
    $conhecimento_num = substr($textoLinhaArquivo, 18, 12);

    $valor_frete = substr($textoLinhaArquivo, 30, 15);
    $conhecimento_emissao = substr($textoLinhaArquivo, 45, 8); //DDMMAAAA
    if (trim($conhecimento_emissao) == '') {
        $conhecimento_emissao = date('Y-m-d'); //DDMMAAAA
    } else {
        $conhecimento_emissao = substr($conhecimento_emissao, 4, 4) . "-" . substr($conhecimento_emissao, 2, 2) . "-" . substr($conhecimento_emissao, 0, 2); //DDMMAAAA	
    }

    $cnpj_remetente = substr($textoLinhaArquivo, 53, 14);
    $cnpj_destinatario = substr($textoLinhaArquivo, 67, 14);
    $cnpj_emissor_conhecimento = substr($textoLinhaArquivo, 81, 14);

//$record['cnpj_trans'] = $cnpj_trans;
    $record['filial_emissora'] = $filial_emissora;
    $record['conhecimento_serie'] = $conhecimento_serie;
    $record['conhecimento_num'] = $conhecimento_num;
    $record['valor_frete'] = $valor_frete;
    $record['conhecimento_emissao'] = $conhecimento_emissao;
    $record['cnpj_remetente'] = $cnpj_remetente;
    $record['cnpj_destinatario'] = $cnpj_destinatario;
    $record['cnpj_emissor_conhecimento'] = $cnpj_emissor_conhecimento;
    $record['doccobcod'] = $doccobcod;
    $record['num_doc'] = $aux_fatura;

    return $record;
}

function doccobReg556($textoLinhaArquivo, $doccobcod, $aux_conhecimento, $aux_fatura) {
// registro "556"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $serie = substr($textoLinhaArquivo, 3, 3);
    $nf = substr($textoLinhaArquivo, 6, 9);
    $nf_emissao = substr($textoLinhaArquivo, 15, 8); // DDMMAAAA
    $nf_emissao = substr($nf_emissao, 4, 4) . "-" . substr($nf_emissao, 2, 2) . "-" . substr($nf_emissao, 0, 2); //DDMMAAAA
    $nf_peso = substr($textoLinhaArquivo, 23, 7);
    $nf_valor_mercadoria = substr($textoLinhaArquivo, 30, 15);
    $nf_cnpj_emissor = substr($textoLinhaArquivo, 45, 14);

////echo  $id_registro . "_____" . $serie . "". $nf  . $nf_emissao
//. $nf_peso . $nf_valor_mercadoria . $nf_cnpj_emissor
//. "<br/>";

    $record['serie'] = $serie;
    $record['nf'] = $nf;
    $record['nf_emissao'] = $nf_emissao;
    $record['nf_peso'] = $nf_peso;
    $record['nf_valor_mercadoria'] = $nf_valor_mercadoria;
    $record['nf_cnpj_emissor'] = $nf_cnpj_emissor;
    $record['doccobcod'] = $doccobcod;
    $record['conhecimento_num'] = $aux_conhecimento; //Vai gravar o Conhecimento do Registro 353 anterior;
    $record['num_doc'] = $aux_fatura; //Vai gravar a Fatura do Registro 352 anterior;

    return $record;
}

function doccobReg559($textoLinhaArquivo) {
// registro "559"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $qtd_total_doc = substr($textoLinhaArquivo, 3, 4);
    $valor_total_doc = substr($textoLinhaArquivo, 7, 15); // formato 13.2
    $record['qtd_total_doc'] = $qtd_total_doc;
    $record['valor_total_doc'] = $valor_total_doc;
    return $record;
}

//Varre o arquivo doccob gravando todos os campos dele na base
//Se o insert do primeiro registro for efetuado com sucesso, gravará os demais registros utilizando o doccobcod gerado
function processaDoccob($arquivo) {
    echo "ON DOCCOB <br>";
//$arquivo = "doccobcab565684868.txt";
    $caminho = dirname($arquivo);

    $str = file_get_contents($arquivo);
    
    if(substr($str,0,3)=='ï»¿') {
        $str = str_replace("ï»¿","",$str);
    }    
    
//$str = str_replace(" ","_",$str);
    $filearray = explode("\n", $str);
    $doccobcod = 0;
    $id_intercambio = '';
    $aux_conhecimento = 0;
    $aux_fatura = 0;

    for ($index = 0; $index < count($filearray); $index++) {

        $id_registro = substr($filearray[$index], 0, 3);

        switch ($id_registro) {
            case "000":
                $record = doccobReg000($filearray[$index], $arquivo);

                $id_intercambio = $record['id_intercambio'];
                $aux_remetente = $record['remetente'];
                $aux_nome_arquivo = $record['nome_arquivo'];

                //Para nao Duplicar vou fazer uma pesquisa pelo id_intercambio, remetente e nome do arquivo
                $sql = "SELECT doccobcod FROM " . TABELA_COBRANCA_TRANS . " WHERE id_intercambio = '$id_intercambio' and remetente='$aux_remetente' and nome_arquivo='$aux_nome_arquivo'";
                
                $read = new Read;
                $read->FullRead($sql);

                if ($read->getRowCount() >= 1) {				
                    
                    //Se já existe vai retornar 4
                    return 4;                    
                                  
                    //Tirar Isso
                    /*
                    $doccobcod = $read->getResult()[0]['doccobcod'];                 
                    //Deleta os registros				
                    $sql3 = "DELETE FROM " . TABELA_COBRANCA_TRANS . " WHERE doccobcod = '$doccobcod'";
                    pg_query($sql3);
                    $sql3 = "DELETE FROM " . TABELA_COBRANCA_TRANS_REG_352 . " WHERE doccobcod = '$doccobcod'";
                    pg_query($sql3);
                    $sql3 = "DELETE FROM " . TABELA_COBRANCA_TRANS_REG_353 . " WHERE doccobcod = '$doccobcod'";
                    pg_query($sql3);
                    $sql3 = "DELETE FROM " . TABELA_COBRANCA_TRANS_REG_354 . " WHERE doccobcod = '$doccobcod'";
                    pg_query($sql3);                    
                     * 
                     */
                     
                }
                		
                $Cadastra = new Create;
                $Cadastra->ExeCreate('doccob', 'doccob_doccobcod_seq', $record);
                if ($Cadastra->getResult()) {
                    $doccobcod = $Cadastra->getResult();
                } else {
                    return 2;
                }                
                $Cadastra = null;                
                break;
            case "350":
                $record = doccobReg350($filearray[$index]);
                if ($doccobcod != 0) {
                    $update = new Update;
                    $update->ExeUpdate('doccob', $record, "WHERE doccobcod = :id", 'id=' . $doccobcod);
                    $update = null;   
                }
               
                break;
            case "550":
                $record = doccobReg550($filearray[$index]);
                if ($doccobcod != 0) {
                    $update = new Update;
                    $update->ExeUpdate('doccob', $record, "WHERE doccobcod = :id", 'id=' . $doccobcod);
                    $update = null;  
                }
                
                break;
            case "351":
                $record = doccobReg351($filearray[$index]);
                if ($doccobcod != 0) {
                    $update = new Update;
                    $update->ExeUpdate('doccob', $record, "WHERE doccobcod = :id", 'id=' . $doccobcod);
                    $update = null; 
                }
                break;
            case "551":
                $record = doccobReg551($filearray[$index]);
                if ($doccobcod != 0) {
                    $update = new Update;
                    $update->ExeUpdate('doccob', $record, "WHERE doccobcod = :id", 'id=' . $doccobcod);
                    $update = null; 
                }
               
                break;
            case "352":
                $record = doccobReg352($filearray[$index], $doccobcod);
                $aux_fatura = $record['num_doc'];
                if ($doccobcod != 0) {
                    $Cadastra = new Create;
                    $Cadastra->ExeCreate('doccobreg352', 'doccobreg352_doccobreg322cod_seq', $record);                    
                    $Cadastra = null;
                }
                break;
            case "552":
                $record = doccobReg552($filearray[$index], $doccobcod);
                $aux_fatura = $record['num_doc'];
                if ($doccobcod != 0) {
                    $Cadastra = new Create;
                    $Cadastra->ExeCreate('doccobreg352', 'doccobreg352_doccobreg322cod_seq', $record);
                    var_dump($Cadastra);
                    $Cadastra = null;
                }
                die;
                break;
                
               
            case "353":
                $record = doccobReg353($filearray[$index], $doccobcod, $aux_fatura);
                $aux_conhecimento = $record['conhecimento_num'];
                if ($doccobcod != 0) {
                    $Cadastra = new Create;
                    $Cadastra->ExeCreate('doccobreg353', 'doccobreg353_doccobreg353cod_seq', $record);                    
                    $Cadastra = null; 
                }         
                break;
            case "553":
                //Localiza o Codigo Interno que acabou de Incluir no Registro 552
                $sql = "SELECT max(doccobreg322cod) AS doccobcod352 FROM " . TABELA_COBRANCA_TRANS_REG_352 . " WHERE doccobcod='$doccobcod'";
                $read = new Read;
                $read->FullRead($sql);
                if ($read->getRowCount() >= 1) {             
                    $doccobcod352 = $read->getResult()[0]['doccobcod352'];
                } else {            
                    return 2;
                }
                
                $record = doccobReg553($filearray[$index]);
            
                if ($doccobcod352 != 0) {                                        
                    $update = new Update;
                    $update->ExeUpdate('doccobreg352', $record, "WHERE doccobreg322cod = :id", 'id=' . $doccobcod352);                    
                    $update = null;                                        
                }
                break;
            case "354":
                $record = doccobReg354($filearray[$index], $doccobcod, $aux_conhecimento, $aux_fatura);
                if ($doccobcod != 0) {
                    $Cadastra = new Create;
                    $Cadastra->ExeCreate('doccobreg354', 'doccobreg354_doccobreg354cod_seq', $record);                    
                    $Cadastra = null;
                }
                break;
            case "355":
                $record = doccobReg355($filearray[$index]);
                if ($doccobcod != 0) {
                    $update = new Update;
                    $update->ExeUpdate('doccob', $record, "WHERE doccobcod = :id", 'id=' . $doccobcod);                    
                    $update = null;
                }
                break;
            case "555":
                $record = doccobReg555($filearray[$index], $doccobcod, $aux_fatura);
                $aux_conhecimento = $record['conhecimento_num'];
                if ($doccobcod != 0) {
                    $Cadastra = new Create;
                    $Cadastra->ExeCreate('doccobreg353', 'doccobreg353_doccobreg353cod_seq', $record);
                    $Cadastra = null;
                }
                break;
            case "556":
                $record = doccobReg556($filearray[$index], $doccobcod, $aux_conhecimento, $aux_fatura);
                if ($doccobcod != 0) {
                    $Cadastra = new Create;
                    $Cadastra->ExeCreate('doccobreg354', 'doccobreg354_doccobreg354cod_seq', $record);
                    $Cadastra = null; 
                }
                break;
            case "559":
                $record = doccobReg559($filearray[$index]);
                if ($doccobcod != 0) {
                    $update = new Update;
                    $update->ExeUpdate('doccob', $record, "WHERE doccobcod = :id", 'id=' . $doccobcod);
                    $update = null;
                }
                break;
        }
    }

    //Se o doccobcod for diferente de 0 significa que foi realizado o insert com sucesso
    if ($doccobcod != 0) {  
        return 1;
    }	
    return 2;
}

