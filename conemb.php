<?php

/**
 * 
 * Faz a leitura do arquivo segundo layout CONEMB 3.0 e CONEMB 3.1
 * a diferenca é tratada na funcao trataReg322_layout30, quando for lido o CONEMB 3.1
 * Visa obter informação dos conhecimentos emitidos do transporte das mercadorias pela transportadora
 *
 * A sequencia das variaveis de leitura e seus nomes sao semelhantes ao manual CONEMB - PROCEDA
 *
 */
/*
 * steps
 * 1. estabilishing ftp carrier
 * 2. get CONEMB carrier file ( on test will be read localhost file)
 * 3. read CONEMB file - goal for this moment
 * 4. populate these data on database
 *
 *
 *
 * TO-DO!!!!!! Record file name on db
 */
//require_once('include/classes/Conexao.php');
require_once('./_app/Config.inc.php');
include_once('include/funcoes/parser.php');
include_once('include/config.php');

function conembReg000($textoLinhaArquivo, $arquivo) {

    //registro "000"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $remetente = substr($textoLinhaArquivo, 3, 35);
    $destinatario = substr($textoLinhaArquivo, 38, 35);
    $data = substr($textoLinhaArquivo, 73, 6); //DDMMAA
    $hora = substr($textoLinhaArquivo, 79, 4);
    $id_intercambio = substr($textoLinhaArquivo, 83, 12);

    $dataYYYYMMDD_hora = "20" . substr($data, 4, 2) . "-" . substr($data, 2, 2) . "-" . substr($data, 0, 2) . " " . substr($hora, 0, 2) . ":" . substr($hora, 2, 2);

    //echo  $id_registro . "_____" . $remetente . "" . $destinatario . "" . $data . "" . $hora . "" . $id_intercambio . "<br/>";

    $record['remetente'] = trim($remetente);
    $record['destinatario'] = $destinatario;
    $record['data'] = $dataYYYYMMDD_hora;
    $record['id_intercambio'] = trim($id_intercambio);
    //Lers - 21/08/2012
    //Troquei essa parte para mandar o nome do arquivo sem o Path pra não dar erro 
    //$record['nome_arquivo'] = $arquivo;
    $record['nome_arquivo'] = trim(basename($arquivo));

    return $record;
}

function conembReg320($textoLinhaArquivo) {
// registro "320"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $id_doc = substr($textoLinhaArquivo, 3, 14); //CONHEDDMMHHMMS
    //echo  $id_registro . "_____" . $id_doc . "<br/>";

    $record['id_doc'] = $id_doc;
    return $record;
}

function conembReg520($textoLinhaArquivo) {
// registro "520"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $id_doc = substr($textoLinhaArquivo, 3, 14); //CONHEDDMMHHMMS
    //echo  $id_registro . "_____" . $id_doc . "<br/>";

    $record['id_doc'] = $id_doc;
    return $record;
}

function conembReg321($textoLinhaArquivo) {
// registro "321"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $cnpj_trans = substr($textoLinhaArquivo, 3, 14);
    $razaosocial_trans = substr($textoLinhaArquivo, 17, 40);

    //echo  $id_registro . "_____" . $cnpj_trans . "" . $razaosocial_trans . "<br/>";

    $record['cnpj_trans'] = $cnpj_trans;
    $record['razaosocial_trans'] = $razaosocial_trans;
    return $record;
}

function conembReg521($textoLinhaArquivo) {
// registro "521"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $cnpj_trans = substr($textoLinhaArquivo, 3, 14);
    $razaosocial_trans = substr($textoLinhaArquivo, 17, 50);

    //echo  $id_registro . "_____" . $cnpj_trans . "" . $razaosocial_trans . "<br/>";

    $record['cnpj_trans'] = $cnpj_trans;
    $record['razaosocial_trans'] = $razaosocial_trans;
    return $record;
}

function conembReg322_layout31($textoLinhaArquivo, $conembcod) {

// registro "322"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $filial_emissora_conhecimento = substr($textoLinhaArquivo, 3, 10);
    $serie_conhecimento = substr($textoLinhaArquivo, 13, 5);
    $num_conhecimento = substr($textoLinhaArquivo, 18, 12);
    $emissao = substr($textoLinhaArquivo, 30, 8); // DDMMAAAA
    $emissao = substr($emissao, 4, 4) . "-" . substr($emissao, 2, 2) . "-" . substr($emissao, 0, 2); //DDMMAAAA
    $cond_frete = substr($textoLinhaArquivo, 38, 1); // C = CIF, F = FOB
    $peso_transp = converteEmFloat(substr($textoLinhaArquivo, 39, 7), 2); // 5,2 posicoes
    $total_frete = converteEmFloat(substr($textoLinhaArquivo, 46, 15), 2); // formato 13,2
    $base_calc_icms = converteEmFloat(substr($textoLinhaArquivo, 61, 15), 2); // formato 13,2
    $perc_icms = converteEmFloat(substr($textoLinhaArquivo, 76, 4), 2); // formato 2,2
    $valor_icms = converteEmFloat(substr($textoLinhaArquivo, 80, 15), 2); // formato 13,2
    $valor_frete_pesovol = converteEmFloat(substr($textoLinhaArquivo, 95, 15), 2); // formato 13,2
    $valor_frete = converteEmFloat(substr($textoLinhaArquivo, 110, 15), 2); // formato 13,2
    $valor_sec_cat = converteEmFloat(substr($textoLinhaArquivo, 125, 15), 2); // formato 13,2
    $valor_itr = converteEmFloat(substr($textoLinhaArquivo, 140, 15), 2); // formato 13,2
    $valor_despacho = converteEmFloat(substr($textoLinhaArquivo, 155, 15), 2); // formato 13,2
    $valor_pedagio = converteEmFloat(substr($textoLinhaArquivo, 170, 15), 2); // formato 13,2
    $valor_ademe = converteEmFloat(substr($textoLinhaArquivo, 185, 15), 2); // formato 13,2
    $possui_st = substr($textoLinhaArquivo, 200, 1); // 1 = SIM, 2 = NAO
    $cnpj_emisssor_conhecimento = substr($textoLinhaArquivo, 204, 14);
    $cnpj_embarcadora = substr($textoLinhaArquivo, 218, 14);

//    $nfs = array();
//    $cursorSerie = 232;
//    $cursorNumero = 235;
//    $salto = 11;
//    for($i = 0; $i < 40; $i++) {
//            $arrayMap = array(
//                    "serie" => substr($textoLinhaArquivo,$cursorSerie,3),
//                    "numero" => substr($textoLinhaArquivo,$cursorNumero,8)
//                );
//            $cursorSerie += $salto;
//            $cursorNumero += $salto;
//            $nfs[] = $arrayMap;
//    }
    $nfserie1 = (substr($textoLinhaArquivo, 232, 3) != '   ') ? substr($textoLinhaArquivo, 232, 3) : null;
    $nf1 = (substr($textoLinhaArquivo, 235, 8) != '00000000') ? substr($textoLinhaArquivo, 235, 8) : null;
    $nfserie2 = (substr($textoLinhaArquivo, 243, 3) != '   ') ? substr($textoLinhaArquivo, 243, 3) : null;
    $nf2 = (substr($textoLinhaArquivo, 246, 8) != '00000000') ? substr($textoLinhaArquivo, 246, 8) : null;
    $nfserie3 = (substr($textoLinhaArquivo, 254, 3) != '   ') ? substr($textoLinhaArquivo, 254, 3) : null;
    $nf3 = (substr($textoLinhaArquivo, 257, 8) != '00000000') ? substr($textoLinhaArquivo, 257, 8) : null;
    $nfserie4 = (substr($textoLinhaArquivo, 265, 3) != '   ') ? substr($textoLinhaArquivo, 265, 3) : null;
    $nf4 = (substr($textoLinhaArquivo, 268, 8) != '00000000') ? substr($textoLinhaArquivo, 268, 8) : null;
    $nfserie5 = (substr($textoLinhaArquivo, 276, 3) != '   ') ? substr($textoLinhaArquivo, 276, 3) : null;
    $nf5 = (substr($textoLinhaArquivo, 279, 8) != '00000000') ? substr($textoLinhaArquivo, 279, 8) : null;
    $nfserie6 = (substr($textoLinhaArquivo, 287, 3) != '   ') ? substr($textoLinhaArquivo, 287, 3) : null;
    $nf6 = (substr($textoLinhaArquivo, 290, 8) != '00000000') ? substr($textoLinhaArquivo, 290, 8) : null;
    $nfserie7 = (substr($textoLinhaArquivo, 298, 3) != '   ') ? substr($textoLinhaArquivo, 298, 3) : null;
    $nf7 = (substr($textoLinhaArquivo, 301, 8) != '00000000') ? substr($textoLinhaArquivo, 301, 8) : null;
    $nfserie8 = (substr($textoLinhaArquivo, 309, 3) != '   ') ? substr($textoLinhaArquivo, 309, 3) : null;
    $nf8 = (substr($textoLinhaArquivo, 312, 8) != '00000000') ? substr($textoLinhaArquivo, 312, 8) : null;
    $nfserie9 = (substr($textoLinhaArquivo, 320, 3) != '   ') ? substr($textoLinhaArquivo, 320, 3) : null;
    $nf9 = (substr($textoLinhaArquivo, 323, 8) != '00000000') ? substr($textoLinhaArquivo, 323, 8) : null;
    $nfserie10 = (substr($textoLinhaArquivo, 331, 3) != '   ') ? substr($textoLinhaArquivo, 331, 3) : null;
    $nf10 = (substr($textoLinhaArquivo, 334, 8) != '00000000') ? substr($textoLinhaArquivo, 334, 8) : null;
    $nfserie11 = (substr($textoLinhaArquivo, 342, 3) != '   ') ? substr($textoLinhaArquivo, 342, 3) : null;
    $nf11 = (substr($textoLinhaArquivo, 345, 8) != '00000000') ? substr($textoLinhaArquivo, 345, 8) : null;
    $nfserie12 = (substr($textoLinhaArquivo, 353, 3) != '   ') ? substr($textoLinhaArquivo, 353, 3) : null;
    $nf12 = (substr($textoLinhaArquivo, 356, 8) != '00000000') ? substr($textoLinhaArquivo, 356, 8) : null;
    $nfserie13 = (substr($textoLinhaArquivo, 364, 3) != '   ') ? substr($textoLinhaArquivo, 364, 3) : null;
    $nf13 = (substr($textoLinhaArquivo, 367, 8) != '00000000') ? substr($textoLinhaArquivo, 367, 8) : null;
    $nfserie14 = (substr($textoLinhaArquivo, 375, 3) != '   ') ? substr($textoLinhaArquivo, 375, 3) : null;
    $nf14 = (substr($textoLinhaArquivo, 378, 8) != '00000000') ? substr($textoLinhaArquivo, 378, 8) : null;
    $nfserie15 = (substr($textoLinhaArquivo, 386, 3) != '   ') ? substr($textoLinhaArquivo, 386, 3) : null;
    $nf15 = (substr($textoLinhaArquivo, 389, 8) != '00000000') ? substr($textoLinhaArquivo, 389, 8) : null;
    $nfserie16 = (substr($textoLinhaArquivo, 397, 3) != '   ') ? substr($textoLinhaArquivo, 397, 3) : null;
    $nf16 = (substr($textoLinhaArquivo, 400, 8) != '00000000') ? substr($textoLinhaArquivo, 400, 8) : null;
    $nfserie17 = (substr($textoLinhaArquivo, 408, 3) != '   ') ? substr($textoLinhaArquivo, 408, 3) : null;
    $nf17 = (substr($textoLinhaArquivo, 411, 8) != '00000000') ? substr($textoLinhaArquivo, 411, 8) : null;
    $nfserie18 = (substr($textoLinhaArquivo, 419, 3) != '   ') ? substr($textoLinhaArquivo, 419, 3) : null;
    $nf18 = (substr($textoLinhaArquivo, 422, 8) != '00000000') ? substr($textoLinhaArquivo, 422, 8) : null;
    $nfserie19 = (substr($textoLinhaArquivo, 430, 3) != '   ') ? substr($textoLinhaArquivo, 430, 3) : null;
    $nf19 = (substr($textoLinhaArquivo, 433, 8) != '00000000') ? substr($textoLinhaArquivo, 433, 8) : null;
    $nfserie20 = (substr($textoLinhaArquivo, 441, 3) != '   ') ? substr($textoLinhaArquivo, 441, 3) : null;
    $nf20 = (substr($textoLinhaArquivo, 444, 8) != '00000000') ? substr($textoLinhaArquivo, 444, 8) : null;
    $nfserie21 = (substr($textoLinhaArquivo, 452, 3) != '   ') ? substr($textoLinhaArquivo, 452, 3) : null;
    $nf21 = (substr($textoLinhaArquivo, 455, 8) != '00000000') ? substr($textoLinhaArquivo, 455, 8) : null;
    $nfserie22 = (substr($textoLinhaArquivo, 463, 3) != '   ') ? substr($textoLinhaArquivo, 463, 3) : null;
    $nf22 = (substr($textoLinhaArquivo, 466, 8) != '00000000') ? substr($textoLinhaArquivo, 466, 8) : null;
    $nfserie23 = (substr($textoLinhaArquivo, 474, 3) != '   ') ? substr($textoLinhaArquivo, 474, 3) : null;
    $nf23 = (substr($textoLinhaArquivo, 477, 8) != '00000000') ? substr($textoLinhaArquivo, 477, 8) : null;
    $nfserie24 = (substr($textoLinhaArquivo, 485, 3) != '   ') ? substr($textoLinhaArquivo, 485, 3) : null;
    $nf24 = (substr($textoLinhaArquivo, 488, 8) != '00000000') ? substr($textoLinhaArquivo, 488, 8) : null;
    $nfserie25 = (substr($textoLinhaArquivo, 496, 3) != '   ') ? substr($textoLinhaArquivo, 496, 3) : null;
    $nf25 = (substr($textoLinhaArquivo, 499, 8) != '00000000') ? substr($textoLinhaArquivo, 499, 8) : null;
    $nfserie26 = (substr($textoLinhaArquivo, 507, 3) != '   ') ? substr($textoLinhaArquivo, 507, 3) : null;
    $nf26 = (substr($textoLinhaArquivo, 510, 8) != '00000000') ? substr($textoLinhaArquivo, 510, 8) : null;
    $nfserie27 = (substr($textoLinhaArquivo, 518, 3) != '   ') ? substr($textoLinhaArquivo, 518, 3) : null;
    $nf27 = (substr($textoLinhaArquivo, 521, 8) != '00000000') ? substr($textoLinhaArquivo, 521, 8) : null;
    $nfserie28 = (substr($textoLinhaArquivo, 529, 3) != '   ') ? substr($textoLinhaArquivo, 529, 3) : null;
    $nf28 = (substr($textoLinhaArquivo, 532, 8) != '00000000') ? substr($textoLinhaArquivo, 532, 8) : null;
    $nfserie29 = (substr($textoLinhaArquivo, 540, 3) != '   ') ? substr($textoLinhaArquivo, 540, 3) : null;
    $nf29 = (substr($textoLinhaArquivo, 543, 8) != '00000000') ? substr($textoLinhaArquivo, 543, 8) : null;
    $nfserie30 = (substr($textoLinhaArquivo, 551, 3) != '   ') ? substr($textoLinhaArquivo, 551, 3) : null;
    $nf30 = (substr($textoLinhaArquivo, 554, 8) != '00000000') ? substr($textoLinhaArquivo, 554, 8) : null;
    $nfserie31 = (substr($textoLinhaArquivo, 562, 3) != '   ') ? substr($textoLinhaArquivo, 562, 3) : null;
    $nf31 = (substr($textoLinhaArquivo, 565, 8) != '00000000') ? substr($textoLinhaArquivo, 565, 8) : null;
    $nfserie32 = (substr($textoLinhaArquivo, 573, 3) != '   ') ? substr($textoLinhaArquivo, 573, 3) : null;
    $nf32 = (substr($textoLinhaArquivo, 576, 8) != '00000000') ? substr($textoLinhaArquivo, 576, 8) : null;
    $nfserie33 = (substr($textoLinhaArquivo, 584, 3) != '   ') ? substr($textoLinhaArquivo, 584, 3) : null;
    $nf33 = (substr($textoLinhaArquivo, 587, 8) != '00000000') ? substr($textoLinhaArquivo, 587, 8) : null;
    $nfserie34 = (substr($textoLinhaArquivo, 595, 3) != '   ') ? substr($textoLinhaArquivo, 595, 3) : null;
    $nf34 = (substr($textoLinhaArquivo, 598, 8) != '00000000') ? substr($textoLinhaArquivo, 598, 8) : null;
    $nfserie35 = (substr($textoLinhaArquivo, 606, 3) != '   ') ? substr($textoLinhaArquivo, 606, 3) : null;
    $nf35 = (substr($textoLinhaArquivo, 609, 8) != '00000000') ? substr($textoLinhaArquivo, 609, 8) : null;
    $nfserie36 = (substr($textoLinhaArquivo, 617, 3) != '   ') ? substr($textoLinhaArquivo, 617, 3) : null;
    $nf36 = (substr($textoLinhaArquivo, 620, 8) != '00000000') ? substr($textoLinhaArquivo, 620, 8) : null;
    $nfserie37 = (substr($textoLinhaArquivo, 628, 3) != '   ') ? substr($textoLinhaArquivo, 628, 3) : null;
    $nf37 = (substr($textoLinhaArquivo, 631, 8) != '00000000') ? substr($textoLinhaArquivo, 631, 8) : null;
    $nfserie38 = (substr($textoLinhaArquivo, 639, 3) != '   ') ? substr($textoLinhaArquivo, 639, 3) : null;
    $nf38 = (substr($textoLinhaArquivo, 642, 8) != '00000000') ? substr($textoLinhaArquivo, 642, 8) : null;
    $nfserie39 = (substr($textoLinhaArquivo, 650, 3) != '   ') ? substr($textoLinhaArquivo, 650, 3) : null;
    $nf39 = (substr($textoLinhaArquivo, 653, 8) != '00000000') ? substr($textoLinhaArquivo, 653, 8) : null;
    $nfserie40 = (substr($textoLinhaArquivo, 661, 3) != '   ') ? substr($textoLinhaArquivo, 661, 3) : null;
    $nf40 = (substr($textoLinhaArquivo, 664, 8) != '00000000') ? substr($textoLinhaArquivo, 664, 8) : null;

    $acao_doc = substr($textoLinhaArquivo, 672, 1);
    $tp_conhecimento = substr($textoLinhaArquivo, 673, 1);
    $cfop = substr($textoLinhaArquivo, 675, 5);

    $dataYYYYMMDD = substr($emissao, 4, 4) . "-" . substr($emissao, 2, 2) . "-" . substr($emissao, 0, 2);

    //echo  "nfs";
    //echo  "<pre>";
    // print_r($nfs);
    //echo  "</pre>";
//    echo  $id_registro . "_____" . $filial_emissora_doc . "" . $serie_doc
//    . $num_doc . $emissao . $cond_frete . $peso_transp . $total_frete
//    . $base_calc_icms . $perc_icms . $valor_icms . $valor_frete_pesovol . $valor_frete
//    . $valor_sec_cat . $valor_itr . $valor_despacho . $valor_pedagio . $valor_ademe . $possui_st
//    . $cnpj_emisssor_conhecimento . $cnpj_embarcadora
//    . $acao_doc . $tp_conhecimento . $cfop
//    . "<br/>";

    $dataYYYYMMDD = substr($emissao, 4, 4) . "-" . substr($emissao, 2, 2) . "-" . substr($emissao, 0, 2);

    $record['filial_emissora_conhecimento'] = $filial_emissora_conhecimento;
    $record['serie_conhecimento'] = $serie_conhecimento;
    $record['num_conhecimento'] = $num_conhecimento;
    $record['emissao'] = $emissao; //DDMMAAAA;
    $record['cond_frete'] = $cond_frete;
    $record['peso_transp'] = $peso_transp;
    $record['total_frete'] = $total_frete;
    $record['base_calc_icms'] = $base_calc_icms;
    $record['perc_icms'] = $perc_icms;
    $record['valor_icms'] = $valor_icms;
    $record['valor_frete_pesovol'] = $valor_frete_pesovol;
    $record['valor_frete'] = $valor_frete;
    $record['valor_sec_cat'] = $valor_sec_cat;
    $record['valor_itr'] = $valor_itr;
    $record['valor_despacho'] = $valor_despacho;
    $record['valor_pedagio'] = $valor_pedagio;
    $record['valor_ademe'] = $valor_ademe;
    $record['possui_st'] = $possui_st;
    $record['cnpj_emisssor_conhecimento'] = $cnpj_emisssor_conhecimento;
    $record['cnpj_embarcadora'] = $cnpj_embarcadora;
    $record['nfserie1'] = $nfserie1;
    $record['nf1'] = $nf1;
    $record['nfserie2'] = $nfserie2;
    $record['nf2'] = $nf2;
    $record['nfserie3'] = $nfserie3;
    $record['nf3'] = $nf3;
    $record['nfserie4'] = $nfserie4;
    $record['nf4'] = $nf4;
    $record['nfserie5'] = $nfserie5;
    $record['nf5'] = $nf5;
    $record['nfserie6'] = $nfserie6;
    $record['nf6'] = $nf6;
    $record['nfserie7'] = $nfserie7;
    $record['nf7'] = $nf7;
    $record['nfserie8'] = $nfserie8;
    $record['nf8'] = $nf8;
    $record['nfserie9'] = $nfserie9;
    $record['nf9'] = $nf9;
    $record['nfserie10'] = $nfserie10;
    $record['nf10'] = $nf10;
    $record['nfserie11'] = $nfserie11;
    $record['nf11'] = $nf11;
    $record['nfserie12'] = $nfserie12;
    $record['nf12'] = $nf12;
    $record['nfserie13'] = $nfserie13;
    $record['nf13'] = $nf13;
    $record['nfserie14'] = $nfserie14;
    $record['nf14'] = $nf14;
    $record['nfserie15'] = $nfserie15;
    $record['nf15'] = $nf15;
    $record['nfserie16'] = $nfserie16;
    $record['nf16'] = $nf16;
    $record['nfserie17'] = $nfserie17;
    $record['nf17'] = $nf17;
    $record['nfserie18'] = $nfserie18;
    $record['nf18'] = $nf18;
    $record['nfserie19'] = $nfserie19;
    $record['nf19'] = $nf19;
    $record['nfserie20'] = $nfserie20;
    $record['nf20'] = $nf20;
    $record['nfserie21'] = $nfserie21;
    $record['nf21'] = $nf21;
    $record['nfserie22'] = $nfserie22;
    $record['nf22'] = $nf22;
    $record['nfserie23'] = $nfserie23;
    $record['nf23'] = $nf23;
    $record['nfserie24'] = $nfserie24;
    $record['nf24'] = $nf24;
    $record['nfserie25'] = $nfserie25;
    $record['nf25'] = $nf25;
    $record['nfserie26'] = $nfserie26;
    $record['nf26'] = $nf26;
    $record['nfserie27'] = $nfserie27;
    $record['nf27'] = $nf27;
    $record['nfserie28'] = $nfserie28;
    $record['nf28'] = $nf28;
    $record['nfserie29'] = $nfserie29;
    $record['nf29'] = $nf29;
    $record['nfserie30'] = $nfserie30;
    $record['nf30'] = $nf30;
    $record['nfserie31'] = $nfserie31;
    $record['nf31'] = $nf31;
    $record['nfserie32'] = $nfserie32;
    $record['nf32'] = $nf32;
    $record['nfserie33'] = $nfserie33;
    $record['nf33'] = $nf33;
    $record['nfserie34'] = $nfserie34;
    $record['nf34'] = $nf34;
    $record['nfserie35'] = $nfserie35;
    $record['nf35'] = $nf35;
    $record['nfserie36'] = $nfserie36;
    $record['nf36'] = $nf36;
    $record['nfserie37'] = $nfserie37;
    $record['nf37'] = $nf37;
    $record['nfserie38'] = $nfserie38;
    $record['nf38'] = $nf38;
    $record['nfserie39'] = $nfserie39;
    $record['nf39'] = $nf39;
    $record['nfserie40'] = $nfserie40;
    $record['nf40'] = $nf40;
    $record['acao_doc'] = $acao_doc;
    $record['tp_conhecimento'] = $tp_conhecimento;
    $record['cfop'] = $cfop;
    $record['conembcod'] = $conembcod;


    return $record;
}

function conembReg322_layout30($textoLinhaArquivo, $conembcod) {

// registro "322"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $filial_emissora_conhecimento = substr($textoLinhaArquivo, 3, 10);
    $serie_conhecimento = substr($textoLinhaArquivo, 13, 5);
    $num_conhecimento = substr($textoLinhaArquivo, 18, 12);
    $emissao = substr($textoLinhaArquivo, 30, 8); //DDMMAAAA
    $emissao = substr($emissao, 4, 4) . "-" . substr($emissao, 2, 2) . "-" . substr($emissao, 0, 2);
    $cond_frete = substr($textoLinhaArquivo, 38, 1);
    $peso_transp = converteEmFloat(substr($textoLinhaArquivo, 39, 7), 2); // formato 5,2
    $total_frete = converteEmFloat(substr($textoLinhaArquivo, 46, 15), 2); // formato 13,2
    $base_calc_icms = converteEmFloat(substr($textoLinhaArquivo, 61, 15), 2); // formato 13,2
    $perc_icms = converteEmFloat(substr($textoLinhaArquivo, 76, 4), 2); // formato 2,2
    $valor_icms = converteEmFloat(substr($textoLinhaArquivo, 80, 15), 2); // formato 13,2
    $valor_frete_pesovol = converteEmFloat(substr($textoLinhaArquivo, 95, 15), 2); // formato 13,2
    $valor_frete = converteEmFloat(substr($textoLinhaArquivo, 110, 15), 2); // formato 13,2
    $valor_sec_cat = converteEmFloat(substr($textoLinhaArquivo, 125, 15), 2); // formato 13,2
    $valor_itr = converteEmFloat(substr($textoLinhaArquivo, 140, 15), 2); //formato 13,2
    $valor_despacho = converteEmFloat(substr($textoLinhaArquivo, 155, 15), 2); // formato 13,2
    $valor_pedagio = converteEmFloat(substr($textoLinhaArquivo, 170, 15), 2); //formato 13,2
    $valor_ademe = converteEmFloat(substr($textoLinhaArquivo, 185, 15), 2); // formato 13,2
    $possui_st = substr($textoLinhaArquivo, 200, 1); // 1 = SIM, 2 = NAO
    $cnpj_emisssor_conhecimento = substr($textoLinhaArquivo, 204, 14);
    $cnpj_embarcadora = substr($textoLinhaArquivo, 218, 14);

//    $nfs = array();
//    $cursorSerie = 232;
//    $cursorNumero = 235;
//    $salto = 11;
//    for($i = 0; $i < 40; $i++) {
//            $arrayMap = array(
//                    "serie" => substr($textoLinhaArquivo,$cursorSerie,3),
//                    "numero" => substr($textoLinhaArquivo,$cursorNumero,8)
//                );
//            $cursorSerie += $salto;
//            $cursorNumero += $salto;
//            $nfs[] = $arrayMap;
//    }

    $nfserie1 = (substr($textoLinhaArquivo, 232, 3) != '   ') ? substr($textoLinhaArquivo, 232, 3) : null;
    $nf1 = (substr($textoLinhaArquivo, 235, 8) != '00000000') ? substr($textoLinhaArquivo, 235, 8) : null;
    $nfserie2 = (substr($textoLinhaArquivo, 243, 3) != '   ') ? substr($textoLinhaArquivo, 243, 3) : null;
    $nf2 = (substr($textoLinhaArquivo, 246, 8) != '00000000') ? substr($textoLinhaArquivo, 246, 8) : null;
    $nfserie3 = (substr($textoLinhaArquivo, 254, 3) != '   ') ? substr($textoLinhaArquivo, 254, 3) : null;
    $nf3 = (substr($textoLinhaArquivo, 257, 8) != '00000000') ? substr($textoLinhaArquivo, 257, 8) : null;
    $nfserie4 = (substr($textoLinhaArquivo, 265, 3) != '   ') ? substr($textoLinhaArquivo, 265, 3) : null;
    $nf4 = (substr($textoLinhaArquivo, 268, 8) != '00000000') ? substr($textoLinhaArquivo, 268, 8) : null;
    $nfserie5 = (substr($textoLinhaArquivo, 276, 3) != '   ') ? substr($textoLinhaArquivo, 276, 3) : null;
    $nf5 = (substr($textoLinhaArquivo, 279, 8) != '00000000') ? substr($textoLinhaArquivo, 279, 8) : null;
    $nfserie6 = (substr($textoLinhaArquivo, 287, 3) != '   ') ? substr($textoLinhaArquivo, 287, 3) : null;
    $nf6 = (substr($textoLinhaArquivo, 290, 8) != '00000000') ? substr($textoLinhaArquivo, 290, 8) : null;
    $nfserie7 = (substr($textoLinhaArquivo, 298, 3) != '   ') ? substr($textoLinhaArquivo, 298, 3) : null;
    $nf7 = (substr($textoLinhaArquivo, 301, 8) != '00000000') ? substr($textoLinhaArquivo, 301, 8) : null;
    $nfserie8 = (substr($textoLinhaArquivo, 309, 3) != '   ') ? substr($textoLinhaArquivo, 309, 3) : null;
    $nf8 = (substr($textoLinhaArquivo, 312, 8) != '00000000') ? substr($textoLinhaArquivo, 312, 8) : null;
    $nfserie9 = (substr($textoLinhaArquivo, 320, 3) != '   ') ? substr($textoLinhaArquivo, 320, 3) : null;
    $nf9 = (substr($textoLinhaArquivo, 323, 8) != '00000000') ? substr($textoLinhaArquivo, 323, 8) : null;
    $nfserie10 = (substr($textoLinhaArquivo, 331, 3) != '   ') ? substr($textoLinhaArquivo, 331, 3) : null;
    $nf10 = (substr($textoLinhaArquivo, 334, 8) != '00000000') ? substr($textoLinhaArquivo, 334, 8) : null;
    $nfserie11 = (substr($textoLinhaArquivo, 342, 3) != '   ') ? substr($textoLinhaArquivo, 342, 3) : null;
    $nf11 = (substr($textoLinhaArquivo, 345, 8) != '00000000') ? substr($textoLinhaArquivo, 345, 8) : null;
    $nfserie12 = (substr($textoLinhaArquivo, 353, 3) != '   ') ? substr($textoLinhaArquivo, 353, 3) : null;
    $nf12 = (substr($textoLinhaArquivo, 356, 8) != '00000000') ? substr($textoLinhaArquivo, 356, 8) : null;
    $nfserie13 = (substr($textoLinhaArquivo, 364, 3) != '   ') ? substr($textoLinhaArquivo, 364, 3) : null;
    $nf13 = (substr($textoLinhaArquivo, 367, 8) != '00000000') ? substr($textoLinhaArquivo, 367, 8) : null;
    $nfserie14 = (substr($textoLinhaArquivo, 375, 3) != '   ') ? substr($textoLinhaArquivo, 375, 3) : null;
    $nf14 = (substr($textoLinhaArquivo, 378, 8) != '00000000') ? substr($textoLinhaArquivo, 378, 8) : null;
    $nfserie15 = (substr($textoLinhaArquivo, 386, 3) != '   ') ? substr($textoLinhaArquivo, 386, 3) : null;
    $nf15 = (substr($textoLinhaArquivo, 389, 8) != '00000000') ? substr($textoLinhaArquivo, 389, 8) : null;
    $nfserie16 = (substr($textoLinhaArquivo, 397, 3) != '   ') ? substr($textoLinhaArquivo, 397, 3) : null;
    $nf16 = (substr($textoLinhaArquivo, 400, 8) != '00000000') ? substr($textoLinhaArquivo, 400, 8) : null;
    $nfserie17 = (substr($textoLinhaArquivo, 408, 3) != '   ') ? substr($textoLinhaArquivo, 408, 3) : null;
    $nf17 = (substr($textoLinhaArquivo, 411, 8) != '00000000') ? substr($textoLinhaArquivo, 411, 8) : null;
    $nfserie18 = (substr($textoLinhaArquivo, 419, 3) != '   ') ? substr($textoLinhaArquivo, 419, 3) : null;
    $nf18 = (substr($textoLinhaArquivo, 422, 8) != '00000000') ? substr($textoLinhaArquivo, 422, 8) : null;
    $nfserie19 = (substr($textoLinhaArquivo, 430, 3) != '   ') ? substr($textoLinhaArquivo, 430, 3) : null;
    $nf19 = (substr($textoLinhaArquivo, 433, 8) != '00000000') ? substr($textoLinhaArquivo, 433, 8) : null;
    $nfserie20 = (substr($textoLinhaArquivo, 441, 3) != '   ') ? substr($textoLinhaArquivo, 441, 3) : null;
    $nf20 = (substr($textoLinhaArquivo, 444, 8) != '00000000') ? substr($textoLinhaArquivo, 444, 8) : null;
    $nfserie21 = (substr($textoLinhaArquivo, 452, 3) != '   ') ? substr($textoLinhaArquivo, 452, 3) : null;
    $nf21 = (substr($textoLinhaArquivo, 455, 8) != '00000000') ? substr($textoLinhaArquivo, 455, 8) : null;
    $nfserie22 = (substr($textoLinhaArquivo, 463, 3) != '   ') ? substr($textoLinhaArquivo, 463, 3) : null;
    $nf22 = (substr($textoLinhaArquivo, 466, 8) != '00000000') ? substr($textoLinhaArquivo, 466, 8) : null;
    $nfserie23 = (substr($textoLinhaArquivo, 474, 3) != '   ') ? substr($textoLinhaArquivo, 474, 3) : null;
    $nf23 = (substr($textoLinhaArquivo, 477, 8) != '00000000') ? substr($textoLinhaArquivo, 477, 8) : null;
    $nfserie24 = (substr($textoLinhaArquivo, 485, 3) != '   ') ? substr($textoLinhaArquivo, 485, 3) : null;
    $nf24 = (substr($textoLinhaArquivo, 488, 8) != '00000000') ? substr($textoLinhaArquivo, 488, 8) : null;
    $nfserie25 = (substr($textoLinhaArquivo, 496, 3) != '   ') ? substr($textoLinhaArquivo, 496, 3) : null;
    $nf25 = (substr($textoLinhaArquivo, 499, 8) != '00000000') ? substr($textoLinhaArquivo, 499, 8) : null;
    $nfserie26 = (substr($textoLinhaArquivo, 507, 3) != '   ') ? substr($textoLinhaArquivo, 507, 3) : null;
    $nf26 = (substr($textoLinhaArquivo, 510, 8) != '00000000') ? substr($textoLinhaArquivo, 510, 8) : null;
    $nfserie27 = (substr($textoLinhaArquivo, 518, 3) != '   ') ? substr($textoLinhaArquivo, 518, 3) : null;
    $nf27 = (substr($textoLinhaArquivo, 521, 8) != '00000000') ? substr($textoLinhaArquivo, 521, 8) : null;
    $nfserie28 = (substr($textoLinhaArquivo, 529, 3) != '   ') ? substr($textoLinhaArquivo, 529, 3) : null;
    $nf28 = (substr($textoLinhaArquivo, 532, 8) != '00000000') ? substr($textoLinhaArquivo, 532, 8) : null;
    $nfserie29 = (substr($textoLinhaArquivo, 540, 3) != '   ') ? substr($textoLinhaArquivo, 540, 3) : null;
    $nf29 = (substr($textoLinhaArquivo, 543, 8) != '00000000') ? substr($textoLinhaArquivo, 543, 8) : null;
    $nfserie30 = (substr($textoLinhaArquivo, 551, 3) != '   ') ? substr($textoLinhaArquivo, 551, 3) : null;
    $nf30 = (substr($textoLinhaArquivo, 554, 8) != '00000000') ? substr($textoLinhaArquivo, 554, 8) : null;
    $nfserie31 = (substr($textoLinhaArquivo, 562, 3) != '   ') ? substr($textoLinhaArquivo, 562, 3) : null;
    $nf31 = (substr($textoLinhaArquivo, 565, 8) != '00000000') ? substr($textoLinhaArquivo, 565, 8) : null;
    $nfserie32 = (substr($textoLinhaArquivo, 573, 3) != '   ') ? substr($textoLinhaArquivo, 573, 3) : null;
    $nf32 = (substr($textoLinhaArquivo, 576, 8) != '00000000') ? substr($textoLinhaArquivo, 576, 8) : null;
    $nfserie33 = (substr($textoLinhaArquivo, 584, 3) != '   ') ? substr($textoLinhaArquivo, 584, 3) : null;
    $nf33 = (substr($textoLinhaArquivo, 587, 8) != '00000000') ? substr($textoLinhaArquivo, 587, 8) : null;
    $nfserie34 = (substr($textoLinhaArquivo, 595, 3) != '   ') ? substr($textoLinhaArquivo, 595, 3) : null;
    $nf34 = (substr($textoLinhaArquivo, 598, 8) != '00000000') ? substr($textoLinhaArquivo, 598, 8) : null;
    $nfserie35 = (substr($textoLinhaArquivo, 606, 3) != '   ') ? substr($textoLinhaArquivo, 606, 3) : null;
    $nf35 = (substr($textoLinhaArquivo, 609, 8) != '00000000') ? substr($textoLinhaArquivo, 609, 8) : null;
    $nfserie36 = (substr($textoLinhaArquivo, 617, 3) != '   ') ? substr($textoLinhaArquivo, 617, 3) : null;
    $nf36 = (substr($textoLinhaArquivo, 620, 8) != '00000000') ? substr($textoLinhaArquivo, 620, 8) : null;
    $nfserie37 = (substr($textoLinhaArquivo, 628, 3) != '   ') ? substr($textoLinhaArquivo, 628, 3) : null;
    $nf37 = (substr($textoLinhaArquivo, 631, 8) != '00000000') ? substr($textoLinhaArquivo, 631, 8) : null;
    $nfserie38 = (substr($textoLinhaArquivo, 639, 3) != '   ') ? substr($textoLinhaArquivo, 639, 3) : null;
    $nf38 = (substr($textoLinhaArquivo, 642, 8) != '00000000') ? substr($textoLinhaArquivo, 642, 8) : null;
    $nfserie39 = (substr($textoLinhaArquivo, 650, 3) != '   ') ? substr($textoLinhaArquivo, 650, 3) : null;
    $nf39 = (substr($textoLinhaArquivo, 653, 8) != '00000000') ? substr($textoLinhaArquivo, 653, 8) : null;
    $nfserie40 = (substr($textoLinhaArquivo, 661, 3) != '   ') ? substr($textoLinhaArquivo, 661, 3) : null;
    $nf40 = (substr($textoLinhaArquivo, 664, 8) != '00000000') ? substr($textoLinhaArquivo, 664, 8) : null;

    $acao_doc = substr($textoLinhaArquivo, 672, 1);
    $tp_conhecimento = substr($textoLinhaArquivo, 673, 1);
    $cfop = substr($textoLinhaArquivo, 674, 4);

    $dataYYYYMMDD = substr($emissao, 4, 4) . "-" . substr($emissao, 2, 2) . "-" . substr($emissao, 0, 2);

    $record['filial_emissora_conhecimento'] = $filial_emissora_conhecimento;
    $record['serie_conhecimento'] = $serie_conhecimento;
    $record['num_conhecimento'] = $num_conhecimento;
    $record['emissao'] = $emissao;
    $record['cond_frete'] = $cond_frete;
    $record['peso_transp'] = $peso_transp;
    $record['total_frete'] = $total_frete;
    $record['base_calc_icms'] = $base_calc_icms;
    $record['perc_icms'] = $perc_icms;
    $record['valor_icms'] = $valor_icms;
    $record['valor_frete_pesovol'] = $valor_frete_pesovol;
    $record['valor_frete'] = $valor_frete;
    $record['valor_sec_cat'] = $valor_sec_cat;
    $record['valor_itr'] = $valor_itr;
    $record['valor_despacho'] = $valor_despacho;
    $record['valor_pedagio'] = $valor_pedagio;
    $record['valor_ademe'] = $valor_ademe;
    $record['possui_st'] = $possui_st;
    $record['cnpj_emisssor_conhecimento'] = $cnpj_emisssor_conhecimento;
    $record['cnpj_embarcadora'] = $cnpj_embarcadora;
    $record['nfserie1'] = $nfserie1;
    $record['nf1'] = $nf1;
    $record['nfserie2'] = $nfserie2;
    $record['nf2'] = $nf2;
    $record['nfserie3'] = $nfserie3;
    $record['nf3'] = $nf3;
    $record['nfserie4'] = $nfserie4;
    $record['nf4'] = $nf4;
    $record['nfserie5'] = $nfserie5;
    $record['nf5'] = $nf5;
    $record['nfserie6'] = $nfserie6;
    $record['nf6'] = $nf6;
    $record['nfserie7'] = $nfserie7;
    $record['nf7'] = $nf7;
    $record['nfserie8'] = $nfserie8;
    $record['nf8'] = $nf8;
    $record['nfserie9'] = $nfserie9;
    $record['nf9'] = $nf9;
    $record['nfserie10'] = $nfserie10;
    $record['nf10'] = $nf10;
    $record['nfserie11'] = $nfserie11;
    $record['nf11'] = $nf11;
    $record['nfserie12'] = $nfserie12;
    $record['nf12'] = $nf12;
    $record['nfserie13'] = $nfserie13;
    $record['nf13'] = $nf13;
    $record['nfserie14'] = $nfserie14;
    $record['nf14'] = $nf14;
    $record['nfserie15'] = $nfserie15;
    $record['nf15'] = $nf15;
    $record['nfserie16'] = $nfserie16;
    $record['nf16'] = $nf16;
    $record['nfserie17'] = $nfserie17;
    $record['nf17'] = $nf17;
    $record['nfserie18'] = $nfserie18;
    $record['nf18'] = $nf18;
    $record['nfserie19'] = $nfserie19;
    $record['nf19'] = $nf19;
    $record['nfserie20'] = $nfserie20;
    $record['nf20'] = $nf20;
    $record['nfserie21'] = $nfserie21;
    $record['nf21'] = $nf21;
    $record['nfserie22'] = $nfserie22;
    $record['nf22'] = $nf22;
    $record['nfserie23'] = $nfserie23;
    $record['nf23'] = $nf23;
    $record['nfserie24'] = $nfserie24;
    $record['nf24'] = $nf24;
    $record['nfserie25'] = $nfserie25;
    $record['nf25'] = $nf25;
    $record['nfserie26'] = $nfserie26;
    $record['nf26'] = $nf26;
    $record['nfserie27'] = $nfserie27;
    $record['nf27'] = $nf27;
    $record['nfserie28'] = $nfserie28;
    $record['nf28'] = $nf28;
    $record['nfserie29'] = $nfserie29;
    $record['nf29'] = $nf29;
    $record['nfserie30'] = $nfserie30;
    $record['nf30'] = $nf30;
    $record['nfserie31'] = $nfserie31;
    $record['nf31'] = $nf31;
    $record['nfserie32'] = $nfserie32;
    $record['nf32'] = $nf32;
    $record['nfserie33'] = $nfserie33;
    $record['nf33'] = $nf33;
    $record['nfserie34'] = $nfserie34;
    $record['nf34'] = $nf34;
    $record['nfserie35'] = $nfserie35;
    $record['nf35'] = $nf35;
    $record['nfserie36'] = $nfserie36;
    $record['nf36'] = $nf36;
    $record['nfserie37'] = $nfserie37;
    $record['nf37'] = $nf37;
    $record['nfserie38'] = $nfserie38;
    $record['nf38'] = $nf38;
    $record['nfserie39'] = $nfserie39;
    $record['nf39'] = $nf39;
    $record['nfserie40'] = $nfserie40;
    $record['nf40'] = $nf40;
    $record['acao_doc'] = $acao_doc;
    $record['tp_conhecimento'] = $tp_conhecimento;
    $record['cfop'] = $cfop;
    $record['conembcod'] = $conembcod;

//    echo  $id_registro . "_____" . $filial_emissora_doc . "" . $serie_doc
// . $num_doc . $emissao . $cond_frete . $peso_transp . $total_frete
// . $base_calc_icms . $perc_icms . $valor_icms . $valor_frete_pesovol . $valor_frete
// . $valor_sec_cat . $valor_itr . $valor_despacho . $valor_pedagio . $valor_ademe . $possui_st
// . $cnpj_emisssor_conhecimento . $cnpj_embarcadora
// . $acao_doc . $tp_conhecimento . $cfop
// . "<br/>";
    return $record;
}

function conembReg522($textoLinhaArquivo, $conembcod) {

// registro "522"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $filial_emissora_conhecimento = substr($textoLinhaArquivo, 3, 10);
    $serie_conhecimento = substr($textoLinhaArquivo, 13, 5);
    $num_conhecimento = substr($textoLinhaArquivo, 18, 12);
    $emissao = substr($textoLinhaArquivo, 30, 8); // DDMMAAAA
    $emissao = substr($emissao, 4, 4) . "-" . substr($emissao, 2, 2) . "-" . substr($emissao, 0, 2); //DDMMAAAA
    $cond_frete = substr($textoLinhaArquivo, 38, 1); // C = CIF, F = FOB
    //Valores vao ficar em outro Registro
    /*
      $peso_transp = converteEmFloat(substr($textoLinhaArquivo, 39, 7), 2); // 5,2 posicoes
      $total_frete = converteEmFloat(substr($textoLinhaArquivo, 46, 15), 2); // formato 13,2
      $base_calc_icms = converteEmFloat(substr($textoLinhaArquivo, 61, 15), 2); // formato 13,2
      $perc_icms = converteEmFloat(substr($textoLinhaArquivo, 76, 4), 2); // formato 2,2
      $valor_icms = converteEmFloat(substr($textoLinhaArquivo, 80, 15), 2); // formato 13,2
      $valor_frete_pesovol = converteEmFloat(substr($textoLinhaArquivo, 95, 15), 2); // formato 13,2
      $valor_frete = converteEmFloat(substr($textoLinhaArquivo, 110, 15), 2); // formato 13,2
      $valor_sec_cat = converteEmFloat(substr($textoLinhaArquivo, 125, 15), 2); // formato 13,2
      $valor_itr = converteEmFloat(substr($textoLinhaArquivo, 140, 15), 2); // formato 13,2
      $valor_despacho = converteEmFloat(substr($textoLinhaArquivo, 155, 15), 2); // formato 13,2
      $valor_pedagio = converteEmFloat(substr($textoLinhaArquivo, 170, 15), 2); // formato 13,2
      $valor_ademe = converteEmFloat(substr($textoLinhaArquivo, 185, 15), 2); // formato 13,2
      $possui_st = substr($textoLinhaArquivo, 200, 1); // 1 = SIM, 2 = NAO
     */

    $peso_transp = 0; // 5,2 posicoes
    $total_frete = 0; // formato 13,2
    $base_calc_icms = 0; // formato 13,2
    $perc_icms = 0; // formato 2,2
    $valor_icms = 0; // formato 13,2
    $valor_frete_pesovol = 0; // formato 13,2
    $valor_frete = 0; // formato 13,2
    $valor_sec_cat = 0; // formato 13,2
    $valor_itr = 0; // formato 13,2
    $valor_despacho = 0; // formato 13,2
    $valor_pedagio = 0; // formato 13,2
    $valor_ademe = 0; // formato 13,2
    $possui_st = '2'; // 1 = SIM, 2 = NAO


    $cnpj_emisssor_conhecimento = substr($textoLinhaArquivo, 39, 14);
    $cnpj_embarcadora = substr($textoLinhaArquivo, 53, 14);

    $acao_doc = substr($textoLinhaArquivo, 321, 1);
    $tp_conhecimento = substr($textoLinhaArquivo, 319, 1);
    $cfop = substr($textoLinhaArquivo, 109, 5);

    //Nesse layout Numeros das Notas vem no Registro 524
    $nfserie1 = null;
    $nf1 = null;
    $nfserie2 = null;
    $nf2 = null;
    $nfserie3 = null;
    $nf3 = null;
    $nfserie4 = null;
    $nf4 = null;
    $nfserie5 = null;
    $nf5 = null;
    $nfserie6 = null;
    $nf6 = null;
    $nfserie7 = null;
    $nf7 = null;
    $nfserie8 = null;
    $nf8 = null;
    $nfserie9 = null;
    $nf9 = null;
    $nfserie10 = null;
    $nf10 = null;
    $nfserie11 = null;
    $nf11 = null;
    $nfserie12 = null;
    $nf12 = null;
    $nfserie13 = null;
    $nf13 = null;
    $nfserie14 = null;
    $nf14 = null;
    $nfserie15 = null;
    $nf15 = null;
    $nfserie16 = null;
    $nf16 = null;
    $nfserie17 = null;
    $nf17 = null;
    $nfserie18 = null;
    $nf18 = null;
    $nfserie19 = null;
    $nf19 = null;
    $nfserie20 = null;
    $nf20 = null;
    $nfserie21 = null;
    $nf21 = null;
    $nfserie22 = null;
    $nf22 = null;
    $nfserie23 = null;
    $nf23 = null;
    $nfserie24 = null;
    $nf24 = null;
    $nfserie25 = null;
    $nf25 = null;
    $nfserie26 = null;
    $nf26 = null;
    $nfserie27 = null;
    $nf27 = null;
    $nfserie28 = null;
    $nf28 = null;
    $nfserie29 = null;
    $nf29 = null;
    $nfserie30 = null;
    $nf30 = null;
    $nfserie31 = null;
    $nf31 = null;
    $nfserie32 = null;
    $nf32 = null;
    $nfserie33 = null;
    $nf33 = null;
    $nfserie34 = null;
    $nf34 = null;
    $nfserie35 = null;
    $nf35 = null;
    $nfserie36 = null;
    $nf36 = null;
    $nfserie37 = null;
    $nf37 = null;
    $nfserie38 = null;
    $nf38 = null;
    $nfserie39 = null;
    $nf39 = null;
    $nfserie40 = null;
    $nf40 = null;


    $dataYYYYMMDD = substr($emissao, 4, 4) . "-" . substr($emissao, 2, 2) . "-" . substr($emissao, 0, 2);

    //echo  "nfs";
    //echo  "<pre>";
    // print_r($nfs);
    //echo  "</pre>";
//    echo  $id_registro . "_____" . $filial_emissora_doc . "" . $serie_doc
//    . $num_doc . $emissao . $cond_frete . $peso_transp . $total_frete
//    . $base_calc_icms . $perc_icms . $valor_icms . $valor_frete_pesovol . $valor_frete
//    . $valor_sec_cat . $valor_itr . $valor_despacho . $valor_pedagio . $valor_ademe . $possui_st
//    . $cnpj_emisssor_conhecimento . $cnpj_embarcadora
//    . $acao_doc . $tp_conhecimento . $cfop
//    . "<br/>";

    $dataYYYYMMDD = substr($emissao, 4, 4) . "-" . substr($emissao, 2, 2) . "-" . substr($emissao, 0, 2);

    $record['filial_emissora_conhecimento'] = $filial_emissora_conhecimento;
    $record['serie_conhecimento'] = $serie_conhecimento;
    $record['num_conhecimento'] = $num_conhecimento;
    $record['emissao'] = $emissao; //DDMMAAAA;
    $record['cond_frete'] = $cond_frete;
    $record['peso_transp'] = $peso_transp;
    $record['total_frete'] = $total_frete;
    $record['base_calc_icms'] = $base_calc_icms;
    $record['perc_icms'] = $perc_icms;
    $record['valor_icms'] = $valor_icms;
    $record['valor_frete_pesovol'] = $valor_frete_pesovol;
    $record['valor_frete'] = $valor_frete;
    $record['valor_sec_cat'] = $valor_sec_cat;
    $record['valor_itr'] = $valor_itr;
    $record['valor_despacho'] = $valor_despacho;
    $record['valor_pedagio'] = $valor_pedagio;
    $record['valor_ademe'] = $valor_ademe;
    $record['possui_st'] = $possui_st;
    $record['cnpj_emisssor_conhecimento'] = $cnpj_emisssor_conhecimento;
    $record['cnpj_embarcadora'] = $cnpj_embarcadora;
    $record['nfserie1'] = $nfserie1;
    $record['nf1'] = $nf1;
    $record['nfserie2'] = $nfserie2;
    $record['nf2'] = $nf2;
    $record['nfserie3'] = $nfserie3;
    $record['nf3'] = $nf3;
    $record['nfserie4'] = $nfserie4;
    $record['nf4'] = $nf4;
    $record['nfserie5'] = $nfserie5;
    $record['nf5'] = $nf5;
    $record['nfserie6'] = $nfserie6;
    $record['nf6'] = $nf6;
    $record['nfserie7'] = $nfserie7;
    $record['nf7'] = $nf7;
    $record['nfserie8'] = $nfserie8;
    $record['nf8'] = $nf8;
    $record['nfserie9'] = $nfserie9;
    $record['nf9'] = $nf9;
    $record['nfserie10'] = $nfserie10;
    $record['nf10'] = $nf10;
    $record['nfserie11'] = $nfserie11;
    $record['nf11'] = $nf11;
    $record['nfserie12'] = $nfserie12;
    $record['nf12'] = $nf12;
    $record['nfserie13'] = $nfserie13;
    $record['nf13'] = $nf13;
    $record['nfserie14'] = $nfserie14;
    $record['nf14'] = $nf14;
    $record['nfserie15'] = $nfserie15;
    $record['nf15'] = $nf15;
    $record['nfserie16'] = $nfserie16;
    $record['nf16'] = $nf16;
    $record['nfserie17'] = $nfserie17;
    $record['nf17'] = $nf17;
    $record['nfserie18'] = $nfserie18;
    $record['nf18'] = $nf18;
    $record['nfserie19'] = $nfserie19;
    $record['nf19'] = $nf19;
    $record['nfserie20'] = $nfserie20;
    $record['nf20'] = $nf20;
    $record['nfserie21'] = $nfserie21;
    $record['nf21'] = $nf21;
    $record['nfserie22'] = $nfserie22;
    $record['nf22'] = $nf22;
    $record['nfserie23'] = $nfserie23;
    $record['nf23'] = $nf23;
    $record['nfserie24'] = $nfserie24;
    $record['nf24'] = $nf24;
    $record['nfserie25'] = $nfserie25;
    $record['nf25'] = $nf25;
    $record['nfserie26'] = $nfserie26;
    $record['nf26'] = $nf26;
    $record['nfserie27'] = $nfserie27;
    $record['nf27'] = $nf27;
    $record['nfserie28'] = $nfserie28;
    $record['nf28'] = $nf28;
    $record['nfserie29'] = $nfserie29;
    $record['nf29'] = $nf29;
    $record['nfserie30'] = $nfserie30;
    $record['nf30'] = $nf30;
    $record['nfserie31'] = $nfserie31;
    $record['nf31'] = $nf31;
    $record['nfserie32'] = $nfserie32;
    $record['nf32'] = $nf32;
    $record['nfserie33'] = $nfserie33;
    $record['nf33'] = $nf33;
    $record['nfserie34'] = $nfserie34;
    $record['nf34'] = $nf34;
    $record['nfserie35'] = $nfserie35;
    $record['nf35'] = $nf35;
    $record['nfserie36'] = $nfserie36;
    $record['nf36'] = $nf36;
    $record['nfserie37'] = $nfserie37;
    $record['nf37'] = $nf37;
    $record['nfserie38'] = $nfserie38;
    $record['nf38'] = $nf38;
    $record['nfserie39'] = $nfserie39;
    $record['nf39'] = $nf39;
    $record['nfserie40'] = $nfserie40;
    $record['nf40'] = $nf40;
    $record['acao_doc'] = $acao_doc;
    $record['tp_conhecimento'] = $tp_conhecimento;
    $record['cfop'] = $cfop;
    $record['conembcod'] = $conembcod;


    return $record;
}

function conembReg329($textoLinhaArquivo) {
// registro "329"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $tp_transporte = substr($textoLinhaArquivo, 3, 5); // ver tabela
    $valor_total_desp_extras = substr($textoLinhaArquivo, 8, 15);
    $valor_total_iss = converteEmFloat(substr($textoLinhaArquivo, 23, 15), 2); // formato 13,2
    $filial_trans_contratante = substr($textoLinhaArquivo, 38, 10);
    $serie_trans_contratante = substr($textoLinhaArquivo, 48, 5);
    $num_trans_contratante = substr($textoLinhaArquivo, 53, 12);
    $cod_solic_coleta = substr($textoLinhaArquivo, 65, 15);
    $id_doc_transporte = substr($textoLinhaArquivo, 80, 20);
    $id_doc_autorizacao_carregamento = substr($textoLinhaArquivo, 100, 20);

//    echo  $id_registro . "_____" . $tp_transporte . "" . $valor_total_desp_extras
//    . $valor_total_iss . $filial_trans_contratante . $serie_trans_contratante . $numero_trans_contratante
//    . $cod_solic_coleta . $id_doc_transporte . $id_doc_autorizacao_carregamento
//    . "<br/>";

    $record['tp_transporte'] = $tp_transporte;
    $record['valor_total_desp_extras'] = $valor_total_desp_extras;
    $record['valor_total_iss'] = $valor_total_iss;
    $record['filial_trans_contratante'] = $filial_trans_contratante;
    $record['serie_trans_contratante'] = $serie_trans_contratante;
    $record['numero_trans_contratante'] = $numero_trans_contratante;
    $record['cod_solic_coleta'] = $cod_solic_coleta;
    $record['id_doc_transporte'] = $id_doc_transporte;
    $record['id_doc_autorizacao_carregamento'] = $id_doc_autorizacao_carregamento;
    return $record;
}

function conembReg323($textoLinhaArquivo) {
// registro "355"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $qtd_total_conhecimentos = substr($textoLinhaArquivo, 3, 4);
    $valor_total_conhecimentos = converteEmFloat(substr($textoLinhaArquivo, 7, 15), 2); // formato 13,2
//    echo  $id_registro . "_____" . $qtd_total_conhecimentos . "" . $valor_total_conhecimentos . "<br/>";

    $record['qtd_total_conhecimentos'] = $qtd_total_conhecimentos;
    $record['valor_total_conhecimentos'] = $valor_total_conhecimentos;
    return $record;
}

function conembReg523($textoLinhaArquivo) {

// registro "523"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $peso_transp = converteEmFloat(substr($textoLinhaArquivo, 11, 9), 3); // 6,3 posicoes	
    $peso_cubado = converteEmFloat(substr($textoLinhaArquivo, 20, 10), 4); // 6,4 posicoes	
    $peso_cubagem = converteEmFloat(substr($textoLinhaArquivo, 30, 10), 4); // 6,4 posicoes    
    $total_frete = converteEmFloat(substr($textoLinhaArquivo, 40, 15), 2); // formato 13,2
    $base_calc_icms = converteEmFloat(substr($textoLinhaArquivo, 206, 15), 2); // formato 13,2
    $perc_icms = converteEmFloat(substr($textoLinhaArquivo, 221, 5), 2); // formato 3,2
    $valor_icms = converteEmFloat(substr($textoLinhaArquivo, 226, 15), 2); // formato 13,2
    $valor_frete_pesovol = converteEmFloat(substr($textoLinhaArquivo, 55, 15), 2); // formato 13,2
    $valor_frete = converteEmFloat(substr($textoLinhaArquivo, 70, 15), 2); // formato 13,2
    $valor_sec_cat = converteEmFloat(substr($textoLinhaArquivo, 100, 15), 2); // formato 13,2
    $valor_itr = converteEmFloat(substr($textoLinhaArquivo, 115, 15), 2); // formato 13,2
    $valor_despacho = converteEmFloat(substr($textoLinhaArquivo, 130, 15), 2); // formato 13,2
    $valor_pedagio = converteEmFloat(substr($textoLinhaArquivo, 145, 15), 2); // formato 13,2
    $valor_ademe = converteEmFloat(substr($textoLinhaArquivo, 160, 15), 2); // formato 13,2
    $possui_st = substr($textoLinhaArquivo, 241, 1); // 1 = SIM, 2 = NAO

    $record['peso_transp'] = $peso_transp;
    $record['peso_cubado'] = $peso_cubado;
    $record['peso_cubagem'] = $peso_cubagem;
    $record['total_frete'] = $total_frete;
    $record['base_calc_icms'] = $base_calc_icms;
    $record['perc_icms'] = $perc_icms;
    $record['valor_icms'] = $valor_icms;
    $record['valor_frete_pesovol'] = $valor_frete_pesovol;
    $record['valor_frete'] = $valor_frete;
    $record['valor_sec_cat'] = $valor_sec_cat;
    $record['valor_itr'] = $valor_itr;
    $record['valor_despacho'] = $valor_despacho;
    $record['valor_pedagio'] = $valor_pedagio;
    $record['valor_ademe'] = $valor_ademe;
    $record['possui_st'] = $possui_st;

    return $record;
}

function conembReg524($textoLinhaArquivo, $conembcod322) {

// registro "524"
    $id_registro = substr($textoLinhaArquivo, 0, 3);

    //Verifica qual nota vai processar
    $sql = "SELECT nf1,nf2,nf3,nf4,nf5,nf6,nf7,nf8,nf9,nf10,nf11,nf12,nf13,nf14,nf15,nf16,nf17,nf18,nf19,nf20,nf21,nf22,nf23,nf24,nf25,nf26,nf27,nf28,nf29,nf30,nf31,nf32,nf33,nf34,nf35,nf36,nf37,nf38,nf39,nf40 FROM " . TABELA_CONHECIMENTO_TRANS_REG_322 . " WHERE conembreg322cod='$conembcod322'";
    $cad = pg_query($sql);
    $row = pg_num_rows($cad);

    if ($row) {
        $aux1 = trim(pg_fetch_result($cad, 0, "nf1"));
        $aux2 = trim(pg_fetch_result($cad, 0, "nf2"));
        $aux3 = trim(pg_fetch_result($cad, 0, "nf3"));
        $aux4 = trim(pg_fetch_result($cad, 0, "nf4"));
        $aux5 = trim(pg_fetch_result($cad, 0, "nf5"));
        $aux6 = trim(pg_fetch_result($cad, 0, "nf6"));
        $aux7 = trim(pg_fetch_result($cad, 0, "nf7"));
        $aux8 = trim(pg_fetch_result($cad, 0, "nf8"));
        $aux9 = trim(pg_fetch_result($cad, 0, "nf9"));
        $aux10 = trim(pg_fetch_result($cad, 0, "nf10"));
        $aux11 = trim(pg_fetch_result($cad, 0, "nf11"));
        $aux12 = trim(pg_fetch_result($cad, 0, "nf12"));
        $aux13 = trim(pg_fetch_result($cad, 0, "nf13"));
        $aux14 = trim(pg_fetch_result($cad, 0, "nf14"));
        $aux15 = trim(pg_fetch_result($cad, 0, "nf15"));
        $aux16 = trim(pg_fetch_result($cad, 0, "nf16"));
        $aux17 = trim(pg_fetch_result($cad, 0, "nf17"));
        $aux18 = trim(pg_fetch_result($cad, 0, "nf18"));
        $aux19 = trim(pg_fetch_result($cad, 0, "nf19"));
        $aux20 = trim(pg_fetch_result($cad, 0, "nf20"));
        $aux21 = trim(pg_fetch_result($cad, 0, "nf21"));
        $aux22 = trim(pg_fetch_result($cad, 0, "nf22"));
        $aux23 = trim(pg_fetch_result($cad, 0, "nf23"));
        $aux24 = trim(pg_fetch_result($cad, 0, "nf24"));
        $aux25 = trim(pg_fetch_result($cad, 0, "nf25"));
        $aux26 = trim(pg_fetch_result($cad, 0, "nf26"));
        $aux27 = trim(pg_fetch_result($cad, 0, "nf27"));
        $aux28 = trim(pg_fetch_result($cad, 0, "nf28"));
        $aux29 = trim(pg_fetch_result($cad, 0, "nf29"));
        $aux30 = trim(pg_fetch_result($cad, 0, "nf30"));
        $aux31 = trim(pg_fetch_result($cad, 0, "nf31"));
        $aux32 = trim(pg_fetch_result($cad, 0, "nf32"));
        $aux33 = trim(pg_fetch_result($cad, 0, "nf33"));
        $aux34 = trim(pg_fetch_result($cad, 0, "nf34"));
        $aux35 = trim(pg_fetch_result($cad, 0, "nf35"));
        $aux36 = trim(pg_fetch_result($cad, 0, "nf36"));
        $aux37 = trim(pg_fetch_result($cad, 0, "nf37"));
        $aux38 = trim(pg_fetch_result($cad, 0, "nf38"));
        $aux39 = trim(pg_fetch_result($cad, 0, "nf39"));
        $aux40 = trim(pg_fetch_result($cad, 0, "nf40"));
    }

    if ($aux1 == '') {
        $nfserie1 = substr($textoLinhaArquivo, 26, 3);
        $nf1 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie1'] = $nfserie1;
        $record['nf1'] = $nf1;
    } else if ($aux2 == '') {
        $nfserie2 = substr($textoLinhaArquivo, 26, 3);
        $nf2 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie2'] = $nfserie2;
        $record['nf2'] = $nf2;
    } else if ($aux3 == '') {
        $nfserie3 = substr($textoLinhaArquivo, 26, 3);
        $nf3 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie3'] = $nfserie3;
        $record['nf3'] = $nf3;
    } else if ($aux4 == '') {
        $nfserie4 = substr($textoLinhaArquivo, 26, 3);
        $nf4 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie4'] = $nfserie4;
        $record['nf4'] = $nf4;
    } else if ($aux5 == '') {
        $nfserie5 = substr($textoLinhaArquivo, 26, 3);
        $nf5 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie5'] = $nfserie5;
        $record['nf5'] = $nf5;
    } else if ($aux6 == '') {
        $nfserie6 = substr($textoLinhaArquivo, 26, 3);
        $nf6 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie6'] = $nfserie6;
        $record['nf6'] = $nf6;
    } else if ($aux7 == '') {
        $nfserie7 = substr($textoLinhaArquivo, 26, 3);
        $nf7 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie7'] = $nfserie7;
        $record['nf7'] = $nf7;
    } else if ($aux8 == '') {
        $nfserie8 = substr($textoLinhaArquivo, 26, 3);
        $nf8 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie8'] = $nfserie8;
        $record['nf8'] = $nf8;
    } else if ($aux9 == '') {
        $nfserie9 = substr($textoLinhaArquivo, 26, 3);
        $nf9 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie9'] = $nfserie9;
        $record['nf9'] = $nf9;
    } else if ($aux10 == '') {
        $nfserie10 = substr($textoLinhaArquivo, 26, 3);
        $nf10 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie10'] = $nfserie10;
        $record['nf10'] = $nf10;
    } else if ($aux11 == '') {
        $nfserie11 = substr($textoLinhaArquivo, 26, 3);
        $nf11 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie11'] = $nfserie11;
        $record['nf11'] = $nf11;
    } else if ($aux12 == '') {
        $nfserie12 = substr($textoLinhaArquivo, 26, 3);
        $nf12 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie12'] = $nfserie12;
        $record['nf12'] = $nf12;
    } else if ($aux13 == '') {
        $nfserie13 = substr($textoLinhaArquivo, 26, 3);
        $nf13 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie13'] = $nfserie13;
        $record['nf13'] = $nf13;
    } else if ($aux14 == '') {
        $nfserie14 = substr($textoLinhaArquivo, 26, 3);
        $nf14 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie14'] = $nfserie14;
        $record['nf14'] = $nf14;
    } else if ($aux15 == '') {
        $nfserie15 = substr($textoLinhaArquivo, 26, 3);
        $nf15 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie15'] = $nfserie15;
        $record['nf15'] = $nf15;
    } else if ($aux16 == '') {
        $nfserie16 = substr($textoLinhaArquivo, 26, 3);
        $nf16 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie16'] = $nfserie16;
        $record['nf16'] = $nf16;
    } else if ($aux17 == '') {
        $nfserie17 = substr($textoLinhaArquivo, 26, 3);
        $nf17 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie17'] = $nfserie17;
        $record['nf17'] = $nf17;
    } else if ($aux18 == '') {
        $nfserie18 = substr($textoLinhaArquivo, 26, 3);
        $nf18 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie18'] = $nfserie18;
        $record['nf18'] = $nf18;
    } else if ($aux19 == '') {
        $nfserie19 = substr($textoLinhaArquivo, 26, 3);
        $nf19 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie19'] = $nfserie19;
        $record['nf19'] = $nf19;
    } else if ($aux20 == '') {
        $nfserie20 = substr($textoLinhaArquivo, 26, 3);
        $nf20 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie20'] = $nfserie20;
        $record['nf20'] = $nf20;
    } else if ($aux21 == '') {
        $nfserie21 = substr($textoLinhaArquivo, 26, 3);
        $nf21 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie21'] = $nfserie21;
        $record['nf21'] = $nf21;
    } else if ($aux22 == '') {
        $nfserie22 = substr($textoLinhaArquivo, 26, 3);
        $nf22 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie22'] = $nfserie22;
        $record['nf22'] = $nf22;
    } else if ($aux23 == '') {
        $nfserie23 = substr($textoLinhaArquivo, 26, 3);
        $nf23 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie23'] = $nfserie23;
        $record['nf23'] = $nf23;
    } else if ($aux24 == '') {
        $nfserie24 = substr($textoLinhaArquivo, 26, 3);
        $nf24 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie24'] = $nfserie24;
        $record['nf24'] = $nf24;
    } else if ($aux25 == '') {
        $nfserie25 = substr($textoLinhaArquivo, 26, 3);
        $nf25 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie25'] = $nfserie25;
        $record['nf25'] = $nf25;
    } else if ($aux26 == '') {
        $nfserie26 = substr($textoLinhaArquivo, 26, 3);
        $nf26 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie26'] = $nfserie26;
        $record['nf26'] = $nf26;
    } else if ($aux27 == '') {
        $nfserie27 = substr($textoLinhaArquivo, 26, 3);
        $nf27 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie27'] = $nfserie27;
        $record['nf27'] = $nf27;
    } else if ($aux28 == '') {
        $nfserie28 = substr($textoLinhaArquivo, 26, 3);
        $nf28 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie28'] = $nfserie28;
        $record['nf28'] = $nf28;
    } else if ($aux29 == '') {
        $nfserie29 = substr($textoLinhaArquivo, 26, 3);
        $nf29 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie29'] = $nfserie29;
        $record['nf29'] = $nf29;
    } else if ($aux30 == '') {
        $nfserie30 = substr($textoLinhaArquivo, 26, 3);
        $nf30 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie30'] = $nfserie30;
        $record['nf30'] = $nf30;
    } else if ($aux31 == '') {
        $nfserie31 = substr($textoLinhaArquivo, 26, 3);
        $nf31 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie31'] = $nfserie31;
        $record['nf31'] = $nf31;
    } else if ($aux32 == '') {
        $nfserie32 = substr($textoLinhaArquivo, 26, 3);
        $nf32 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie32'] = $nfserie32;
        $record['nf32'] = $nf32;
    } else if ($aux33 == '') {
        $nfserie33 = substr($textoLinhaArquivo, 26, 3);
        $nf33 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie33'] = $nfserie33;
        $record['nf33'] = $nf33;
    } else if ($aux34 == '') {
        $nfserie34 = substr($textoLinhaArquivo, 26, 3);
        $nf34 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie34'] = $nfserie34;
        $record['nf34'] = $nf34;
    } else if ($aux35 == '') {
        $nfserie35 = substr($textoLinhaArquivo, 26, 3);
        $nf35 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie35'] = $nfserie35;
        $record['nf35'] = $nf35;
    } else if ($aux36 == '') {
        $nfserie36 = substr($textoLinhaArquivo, 26, 3);
        $nf36 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie36'] = $nfserie36;
        $record['nf36'] = $nf36;
    } else if ($aux37 == '') {
        $nfserie37 = substr($textoLinhaArquivo, 26, 3);
        $nf37 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie37'] = $nfserie37;
        $record['nf37'] = $nf37;
    } else if ($aux38 == '') {
        $nfserie38 = substr($textoLinhaArquivo, 26, 3);
        $nf38 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie38'] = $nfserie38;
        $record['nf38'] = $nf38;
    } else if ($aux39 == '') {
        $nfserie39 = substr($textoLinhaArquivo, 26, 3);
        $nf39 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie39'] = $nfserie39;
        $record['nf39'] = $nf39;
    } else if ($aux40 == '') {
        $nfserie40 = substr($textoLinhaArquivo, 26, 3);
        $nf40 = substr($textoLinhaArquivo, 17, 9);
        $record['nfserie40'] = $nfserie40;
        $record['nf40'] = $nf40;
    }

    return $record;
}

function conembReg524notas($textoLinhaArquivo, $conembcod, $conembcod322) {

    // registro "524"

    $nfserie = substr($textoLinhaArquivo, 26, 3);
    $nf = substr($textoLinhaArquivo, 17, 9);
    $record['conembreg322cod'] = $conembcod322;
    $record['conembcod'] = $conembcod;
    $record['nfserie'] = $nfserie;
    $record['nf'] = $nf;

    return $record;
}

function conembReg529($textoLinhaArquivo) {
// registro "529"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $qtd_total_conhecimentos = substr($textoLinhaArquivo, 3, 4);
    $valor_total_conhecimentos = converteEmFloat(substr($textoLinhaArquivo, 7, 15), 2); // formato 13,2
//    echo  $id_registro . "_____" . $qtd_total_conhecimentos . "" . $valor_total_conhecimentos . "<br/>";

    $record['qtd_total_conhecimentos'] = $qtd_total_conhecimentos;
    $record['valor_total_conhecimentos'] = $valor_total_conhecimentos;
    return $record;
}

//Varre o arquivo conemb gravando todos os campos dele na base
//Se o insert do primeiro registro for efetuado com sucesso, gravará os demais registros utilizando o conembcod gerado
function processaConemb($arquivo) {

    echo "ON CONEMB <br>";

    $caminho = dirname($arquivo);

    $str = file_get_contents($arquivo);

    if (substr($str, 0, 3) == 'ï»¿') {
        $str = str_replace("ï»¿", "", $str);
    }

    //$str = str_replace(" ","_",$str);
    $filearray = explode("\n", $str);
    $conembcod = 0;
    $id_intercambio = '';
    $conembvers = '';
    $cnpj_trans = '';
    
    for ($index = 0; $index < count($filearray); $index++) {

        $id_registro = substr($filearray[$index], 0, 3);

        echo "id_registro: $id_registro <br>";
        switch ($id_registro) {
            case "000":

                $record = conembReg000($filearray[$index], $arquivo);

                $id_intercambio = $record['id_intercambio'];
                $aux_remetente = $record['remetente'];
                $aux_nome_arquivo = $record['nome_arquivo'];

                //Para nao Duplicar vou fazer uma pesquisa pelo id_intercambio, remetente e nome do arquivo
                $sql = "SELECT conembcod FROM " . TABELA_CONHECIMENTO_TRANS . " WHERE id_intercambio = '$id_intercambio' and remetente='$aux_remetente' and nome_arquivo='$aux_nome_arquivo'";
                
                $read = new Read;
                $read->FullRead($sql);

                if ($read->getRowCount() >= 1) {

                    $conembcod = $read->getResult()[0]['conembcod'];
                    
                    //Deleta os registros				
                    $sql3 = "DELETE FROM " . TABELA_CONHECIMENTO_TRANS . " WHERE conembcod = '$conembcod'";
                    pg_query($sql3);
                    $sql3 = "DELETE FROM " . TABELA_CONHECIMENTO_TRANS_REG_322 . " WHERE conembcod = '$conembcod'";
                    pg_query($sql3);
                }

                $Cadastra = new Create;
                $Cadastra->ExeCreate('conemb', 'conemb_conembcod_seq', $record);
                if ($Cadastra->getResult()) {
                    $conembcod = $Cadastra->getResult();
                } else {
                    return false;
                }
                $Cadastra = null;
                
                echo "<pre>";
                print_r($record);
                echo "</pre>";
                break;
            case "320":

                $record = conembReg320($filearray[$index]);
                if ($conembcod != 0) {
                    $update = new Update;
                    $update->ExeUpdate('conemb', $record, "WHERE conembcod = :id", 'id=' . $conembcod);
                    $update = null; 
                }
                echo "<pre>";
                print_r($record);
                echo "</pre>";
                break;

            case "520":
                $record = conembReg520($filearray[$index]);
                if ($conembcod != 0) {
                    $update = new Update;
                    $update->ExeUpdate('conemb', $record, "WHERE conembcod = :id", 'id=' . $conembcod);
                    $update = null;
                }
                echo "<pre>";
                print_r($record);
                echo "</pre>";
                break;

            case "321":
                $record = conembReg321($filearray[$index]);
                if ($conembcod != 0) {
                    $update = new Update;
                    $update->ExeUpdate('conemb', $record, "WHERE conembcod = :id", 'id=' . $conembcod);
                    $update = null;
                }

                $cnpj_trans = insereMascaraCNPJ($record['cnpj_trans']);
                $sql = "SELECT conembvers FROM " . TABELA_TRANSPORTADORAS . " WHERE tracnpj = '$cnpj_trans'";
                
                $read = new Read;
                $read->FullRead($sql);

                if ($read->getRowCount() >= 1) {
                    $conembvers = trim($read->getResult()[0]['conembvers']);                
                    if ($conembvers == '') {
                        $conembvers = '3.1';
                    }
                } else {
                    //echo "<br>VERSAO CONEMB NAO CADASTRADA sql: $sql<br>";
                    $conembvers = '3.1';
                }
                $read = null;

                echo "<pre>";
                print_r($record);
                echo "</pre>";
                break;

            case "521":
                $record = conembReg521($filearray[$index]);
                if ($conembcod != 0) {
                    $update = new Update;
                    $update->ExeUpdate('conemb', $record, "WHERE conembcod = :id", 'id=' . $conembcod);
                    $update = null;
                }

                //Se for regoistro 521 obrigatoriamente sera o layout 5.0
                $conembvers = '5';

                echo "<pre>";
                print_r($record);
                echo "</pre>";
                break;

            case "322":

                if ($conembvers == '3.1') {
                    $record = conembReg322_layout31($filearray[$index], $conembcod);
                } else if (preg_match('/3/', $conembvers)) {

                    $record = conembReg322_layout30($filearray[$index], $conembcod);
                } else {
                    return false;
                }

                if ($conembcod != 0) {

                    $Cadastra = new Create;
                    $Cadastra->ExeCreate('conembreg322', 'conembreg322_conembreg322cod_seq', $record);
                    $Cadastra = null;
                    
                }

                echo "<pre>";
                print_r($record);
                echo "</pre>";
                break;

            case "522":

                $record = conembReg522($filearray[$index], $conembcod);
                if ($conembcod != 0) {
                    $Cadastra = new Create;
                    $Cadastra->ExeCreate('conembreg322', 'conembreg322_conembreg322cod_seq', $record);
                    $Cadastra = null;
                }

                echo "<pre>";
                print_r($record);
                echo "</pre>";

                break;

            case "323":
                $record = conembReg323($filearray[$index]);
                if ($conembcod != 0) {
                    $update = new Update;
                    $update->ExeUpdate('conemb', $record, "WHERE conembcod = :id", 'id=' . $conembcod);
                    $update = null;
                }
                echo "<pre>";
                print_r($record);
                echo "</pre>";
                break;

            case "523":

                //Localiza o Codigo Interno que acabou de Incluir no Registro 522			
                $sql = "SELECT max(conembreg322cod)  AS conembcod322 FROM " . TABELA_CONHECIMENTO_TRANS_REG_322 . " WHERE conembcod='$conembcod'";
                $read = new Read;
                $read->FullRead($sql);

                if ($read->getRowCount() >= 1) {
                    $conembcod322 = $read->getResult()[0]['conembcod322'];
                } else {
                    return false;
                }

                $record = conembReg523($filearray[$index]);
          
                if ($conembcod322 != 0) {
                    $update = new Update;
                    $update->ExeUpdate('conembreg322', $record, "WHERE conembreg322cod = :id", 'id=' . $conembcod322);                    
                    $update = null;
                }
                echo "<pre>";
                print_r($record);
                echo "</pre>";
                break;

            case "524":

                //Localiza o Codigo Interno que acabou de Incluir no Registro 522			
                $sql = "SELECT max(conembreg322cod) AS conembcod322 FROM " . TABELA_CONHECIMENTO_TRANS_REG_322 . " WHERE conembcod='$conembcod'";
                $read = new Read;
                $read->FullRead($sql);

                if ($read->getRowCount() >= 1) {
                    $conembcod322 = $read->getResult()[0]['conembcod322'];
                } else {
                    return false;
                }

                $record = conembReg524($filearray[$index], $conembcod322);

                if ($conembcod322 != 0) {
                    $update = new Update;
                    $update->ExeUpdate('conembreg322', $record, "WHERE conembreg322cod = :id", 'id=' . $conembcod322);
                    $update = null;
                }
                echo "<pre>";
                print_r($record);
                echo "</pre>";
              
                //Grava um registro para Cada Nota
                $record = conembReg524Notas($filearray[$index], $conembcod, $conembcod322);

                $Cadastra = new Create;
                $Cadastra->ExeCreate('conembreg322notas', 'conembreg322notas_conembreg322notascod_seq', $record);
                $Cadastra = null;

                echo "<pre>";
                print_r($record);
                echo "</pre>";
                
                break;                

            case "329":
                $record = conembReg329($filearray[$index]);
                if ($conembcod != 0) {
                    $update = new Update;
                    $update->ExeUpdate('conemb', $record, "WHERE conembcod = :id", 'id=' . $conembcod);
                    $update = null;
                }
                echo "<pre>";
                print_r($record);
                echo "</pre>";
                break;

            case "529":
                $record = conembReg529($filearray[$index]);

                echo $conembcod;

                if ($conembcod != 0) {
                    $update = new Update;
                    $update->ExeUpdate('conemb', $record, "WHERE conembcod = :id", 'id=' . $conembcod);
                    $update = null;
                }
                echo "<pre>";
                print_r($record);
                echo "</pre>";
                break;
        }
    }
    //Se o conembcod for diferente de 0 significa que foi realizado o insert com sucesso
    if ($conembcod != 0) {
        return true;
    }
    return false;
}

