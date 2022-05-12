<?php

/**
 * faz a leitura do arquivo segundo layout OCOREN 3.1
 *
 * Visa obter informação sobre o posicionamento das mercadorias através da transportadora solicitada.
 *
 * A sequencia das variaveis de leitura e seus nomes sao semelhantes ao manual OCOREN - PROCEDA
 */
/*
 * steps
 * 1. estabilishing ftp carrier
 * 2. get OCOREN carrier file ( on test will be read localhost file)
 * 3. read OCOREN file - goal for this moment
 * 4. populate these data on database
 */

require_once('./_app/Config.inc.php');
include_once('include/funcoes/parser.php');
include_once('include/config.php');
require_once("include/funcoes/removeCaracterEspecial.php");

function ocorenReg000($textoLinhaArquivo, $arquivo) {
//registro "000"

    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $remetente = substr($textoLinhaArquivo, 3, 35);
    $destinatario = substr($textoLinhaArquivo, 38, 35);
    $data = substr($textoLinhaArquivo, 73, 6); // DDMMAA
    $hora = substr($textoLinhaArquivo, 79, 4); //HHMM
    $id_intercambio = substr($textoLinhaArquivo, 83, 12);

    $dataYYYYMMDD_hora = "20" . substr($data, 4, 2) . "-" . substr($data, 2, 2) . "-" . substr($data, 0, 2) . " " . substr($hora, 0, 2) . ":" . substr($hora, 2, 2);
    echo $id_registro . "_____" . $remetente . "" . $destinatario . "" . $data . "" . $hora . "" . $id_intercambio . "<br/>";

    $record['remetente'] = trim($remetente);
    $record['destinatario'] = $destinatario;
    $record['data'] = $dataYYYYMMDD_hora;
    $record['id_intercambio'] = trim($id_intercambio);

//$record['nome_arquivo'] = $arquivo;
    $record['nome_arquivo'] = trim(basename($arquivo));

    return $record;
}

function ocorenReg340($textoLinhaArquivo) {
// registro "340"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $id_doc = substr($textoLinhaArquivo, 3, 14); //OCORRDDMMHHMMS
    echo $id_registro . "_____" . $id_doc . "<br/>";

    $record['id_doc'] = $id_doc;
    return $record;
}

function ocorenReg540($textoLinhaArquivo) {
// registro "540"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $id_doc = substr($textoLinhaArquivo, 3, 14); //OCORRDDMMHHMMS
    echo $id_registro . "_____" . $id_doc . "<br/>";

    $record['id_doc'] = $id_doc;
    return $record;
}

function ocorenReg341($textoLinhaArquivo) {
    // registro "341"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $cnpj_trans = substr($textoLinhaArquivo, 3, 14);
    $razaosocial_trans = substr($textoLinhaArquivo, 17, 40);
    echo $id_registro . "_____" . $cnpj_trans . "" . $razaosocial_trans . "<br/>";

    $record['cnpj_trans'] = $cnpj_trans;
    $record['razaosocial_trans'] = $razaosocial_trans;
    return $record;
}

function ocorenReg541($textoLinhaArquivo) {
    // registro "541"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $cnpj_trans = substr($textoLinhaArquivo, 3, 14);
    $razaosocial_trans = substr($textoLinhaArquivo, 17, 50);
    echo $id_registro . "_____" . $cnpj_trans . "" . $razaosocial_trans . "<br/>";

    $record['cnpj_trans'] = $cnpj_trans;
    $record['razaosocial_trans'] = $razaosocial_trans;
    return $record;
}

function ocorenReg342($textoLinhaArquivo, $ocorencod) {
// registro "342"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $cnpj_emissora_nf = substr($textoLinhaArquivo, 3, 14);
    $serie_nf = substr($textoLinhaArquivo, 17, 3);
    $nf = substr($textoLinhaArquivo, 20, 8);
    $cod_entrega = substr($textoLinhaArquivo, 28, 2); // ver tabela ocorencodigos
    $data_ocor = substr($textoLinhaArquivo, 30, 8); // DDMMAAAA
    $hora_ocor = substr($textoLinhaArquivo, 38, 4);
    $obs_entrega = substr($textoLinhaArquivo, 42, 2);  // 01 Devolução/recusa total, 02 = Devolução/recusa parcial, 03 = Aceite/entrega por acordo
    $texto_complementar = substr($textoLinhaArquivo, 44, 70);

//Retira os Caracteres especiais
//$texto_complementar = utf8_decode($texto_complementar);
    $texto_complementar = trim(removeTodosCaracterEspeciais($texto_complementar));
    $textom = convertem($texto_complementar, 1);
    $texto_complementar = $textom;
//$texto_complementar	= trim(removeTodosCaracterEspeciais($textom));

    $dataYYYYMMDD_hora = substr($data_ocor, 4, 4) . "-" . substr($data_ocor, 2, 2) . "-" . substr($data_ocor, 0, 2) . " " . substr($hora_ocor, 0, 2) . ":" . substr($hora_ocor, 2, 2);

    echo $id_registro . "_____" . $cnpj_emissora_nf . "" . $serie_nf
    . $nf . $cod_ocor_entrega . $data_ocor . $hora_ocor
    . $cod_obs_ocor . $texto_complementar . $ocorencod
    . "<br/>";

    $record['cnpj_emissora_nf'] = $cnpj_emissora_nf;
    $record['serie_nf'] = $serie_nf;
    $record['nf'] = $nf;
    $record['cod_entrega'] = $cod_entrega;
    $record['data_ocor'] = $dataYYYYMMDD_hora;
    $record['obs_entrega'] = $obs_entrega;
    $record['texto_complementar'] = $texto_complementar;
    $record['ocorencod'] = $ocorencod;

    //Passa a gravar a data da Edi no registro de Ocorrências
    $sql_aux = "SELECT a.data FROM ocoren a WHERE a.ocorencod='$ocorencod'";
    $cad_aux = pg_query($sql_aux);
    $row_aux = pg_num_rows($cad_aux);
    if ($row_aux) {
        $record['data_edi'] = pg_fetch_result($cad_aux, 0, "data");
    } else {
        $record['data_edi'] = null;
    }

    return $record;
}

function ocorenReg542($textoLinhaArquivo, $ocorencod) {
// registro "542"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $cnpj_emissora_nf = substr($textoLinhaArquivo, 3, 14);
    $serie_nf = substr($textoLinhaArquivo, 17, 3);
    $nf = substr($textoLinhaArquivo, 20, 9);
    $cod_entrega = substr($textoLinhaArquivo, 29, 3); // ver tabela ocorencodigos
    $data_ocor = substr($textoLinhaArquivo, 32, 8); // DDMMAAAA
    $hora_ocor = substr($textoLinhaArquivo, 40, 4);
    $obs_entrega = substr($textoLinhaArquivo, 44, 2);  // 01 Devolução/recusa total, 02 = Devolução/recusa parcial, 03 = Aceite/entrega por acordo
//$texto_complementar = substr($textoLinhaArquivo,44,70);
    $texto_complementar = '';

//Retira os Caracteres especiais
//$texto_complementar = utf8_decode($texto_complementar);
    $texto_complementar = trim(removeTodosCaracterEspeciais($texto_complementar));
    $textom = convertem($texto_complementar, 1);
    $texto_complementar = $textom;
//$texto_complementar	= trim(removeTodosCaracterEspeciais($textom));

    $dataYYYYMMDD_hora = substr($data_ocor, 4, 4) . "-" . substr($data_ocor, 2, 2) . "-" . substr($data_ocor, 0, 2) . " " . substr($hora_ocor, 0, 2) . ":" . substr($hora_ocor, 2, 2);

    echo $id_registro . "_____" . $cnpj_emissora_nf . "" . $serie_nf
    . $nf . $cod_ocor_entrega . $data_ocor . $hora_ocor
    . $cod_obs_ocor . $texto_complementar . $ocorencod
    . "<br/>";

    $record['cnpj_emissora_nf'] = $cnpj_emissora_nf;
    $record['serie_nf'] = $serie_nf;
    $record['nf'] = $nf;
    $record['cod_entrega'] = $cod_entrega;
    $record['data_ocor'] = $dataYYYYMMDD_hora;
    $record['obs_entrega'] = $obs_entrega;
    $record['texto_complementar'] = $texto_complementar;
    $record['ocorencod'] = $ocorencod;

    //Passa a gravar a data da Edi no registro de Ocorrências
    $sql_aux = "SELECT a.data FROM ocoren a WHERE a.ocorencod='$ocorencod'";
    $cad_aux = pg_query($sql_aux);
    $row_aux = pg_num_rows($cad_aux);
    if ($row_aux) {
        $record['data_edi'] = pg_fetch_result($cad_aux, 0, "data");
    } else {
        $record['data_edi'] = null;
    }

    return $record;
}

//Na versão 3.0 o registro abaixo não existe
function ocorenReg343($textoLinhaArquivo) {
// registro "343"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $cnpj_contratante_do_frete = substr($textoLinhaArquivo, 3, 14);
    $filial_transp_contratante = substr($textoLinhaArquivo, 17, 10);
    $serie_transp_contratante = substr($textoLinhaArquivo, 27, 5);
    $num_transp_contratante = substr($textoLinhaArquivo, 32, 12);

    echo $id_registro . "_____<br/>" . $cnpj . "" . $razaosocial . "<br/>";

    $record['cnpj_contratante_do_frete'] = $cnpj_contratante_do_frete;
    $record['filial_transp_contratante'] = $filial_transp_contratante;
    $record['serie_transp_contratante'] = $serie_transp_contratante;
    $record['num_transp_contratante'] = $num_transp_contratante;
    return $record;
}

function ocorenReg543($textoLinhaArquivo) {
// registro "543"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $texto_complementar = substr($textoLinhaArquivo, 3, 70);

//Retira os Caracteres especiais
//$texto_complementar = utf8_decode($texto_complementar);
    $texto_complementar = trim(removeTodosCaracterEspeciais($texto_complementar));
    $textom = convertem($texto_complementar, 1);
    $texto_complementar = $textom;
    $record['texto_complementar'] = $texto_complementar;

    return $record;
}

function ocorenReg545($textoLinhaArquivo) {
// registro "545"
    $id_registro = substr($textoLinhaArquivo, 0, 3);
    $cnpj_contratante_do_frete = substr($textoLinhaArquivo, 3, 14);
    $filial_transp_contratante = substr($textoLinhaArquivo, 31, 10);
    $serie_transp_contratante = substr($textoLinhaArquivo, 41, 5);
    $num_transp_contratante = substr($textoLinhaArquivo, 46, 12);

    echo $id_registro . "_____<br/>" . $cnpj . "" . $razaosocial . "<br/>";

    $record['cnpj_contratante_do_frete'] = $cnpj_contratante_do_frete;
    $record['filial_transp_contratante'] = $filial_transp_contratante;
    $record['serie_transp_contratante'] = $serie_transp_contratante;
    $record['num_transp_contratante'] = $num_transp_contratante;
    return $record;
}

//Varre o arquivo ocoren gravando todos os campos dele na base
//Se o insert do primeiro registro for efetuado com sucesso, gravará os demais registros utilizando oocorencod gerado
function processaOcoren($arquivo) {
//    $arquivo = "ocorencab484685132.txt";

    $caminho = dirname($arquivo);
    $str = file_get_contents($arquivo);

    if (substr($str, 0, 3) == 'ï»¿') {
        $str = str_replace("ï»¿", "", $str);
    }

//    $str = str_replace(" ","_",$str);
    $filearray = explode("\n", $str);
    $ocorencod = 0;
    $id_intercambio = '';

    for ($index = 0; $index < count($filearray); $index++) {

        $id_registro = substr($filearray[$index], 0, 3);

        switch ($id_registro) {
            case "000":
                $record = ocorenReg000($filearray[$index], $arquivo);

                $id_intercambio = $record['id_intercambio'];
                $aux_remetente = $record['remetente'];
                $aux_nome_arquivo = $record['nome_arquivo'];

                //Para nao Duplicar vou fazer uma pesquisa pelo id_intercambio, remetente e nome do arquivo
                $sql = "SELECT ocorencod FROM " . TABELA_OCORENCIA_TRANS . " WHERE id_intercambio = '$id_intercambio' and remetente='$aux_remetente' and nome_arquivo='$aux_nome_arquivo'";
                $read = new Read;
                $read->FullRead($sql);

                if ($read->getRowCount() >= 1) {

                    $ocorencod = $read->getResult()[0]['ocorencod'];

                    //Deleta os registros
                    $sql3 = "DELETE FROM " . TABELA_OCORENCIA_TRANS . " WHERE ocorencod = '$ocorencod'";
                    pg_query($sql3);
                    $sql3 = "DELETE FROM " . TABELA_OCORENCIA_REG_342_TRANS . " WHERE ocorencod = '$ocorencod'";
                    pg_query($sql3);
                }

                $Cadastra = new Create;
                $Cadastra->ExeCreate('ocoren', 'ocoren_ocorencod_seq', $record);
                if ($Cadastra->getResult()) {
                    $ocorencod = $Cadastra->getResult();
                } else {
                    return false;
                }
                $Cadastra = null;

                break;
            case "340":
                $record = ocorenReg340($filearray[$index]);
                if ($ocorencod != 0) {
                    $update = new Update;
                    $update->ExeUpdate('ocoren', $record, "WHERE ocorencod = :id", 'id=' . $ocorencod);
                    $update = null;
                }
                break;
            case "540":
                $record = ocorenReg540($filearray[$index]);
                if ($ocorencod != 0) {
                    $update = new Update;
                    $update->ExeUpdate('ocoren', $record, "WHERE ocorencod = :id", 'id=' . $ocorencod);
                    $update = null;
                }
                break;
            case "341":
                $record = ocorenReg341($filearray[$index]);
                if ($ocorencod != 0) {
                    $update = new Update;
                    $update->ExeUpdate('ocoren', $record, "WHERE ocorencod = :id", 'id=' . $ocorencod);
                    $update = null;
                }
                break;
            case "541":
                $record = ocorenReg541($filearray[$index]);
                if ($ocorencod != 0) {
                    $update = new Update;
                    $update->ExeUpdate('ocoren', $record, "WHERE ocorencod = :id", 'id=' . $ocorencod);
                    $update = null;
                }
                break;
            case "342":
                $record = ocorenReg342($filearray[$index], $ocorencod);
                if ($ocorencod != 0) {
                    $Cadastra = new Create;
                    $Cadastra->ExeCreate('ocorenreg342', 'ocorenreg342_ocorenreg342cod_seq', $record);
                    $Cadastra = null;
                }

                $aux_nf = (int) $record['nf'];
                $aux_dt = $record['data_ocor'];
                $aux_hr = substr($record['data_ocor'], 11, 5);
                $aux_oc = (int) $record['cod_entrega'];

                //Se for uma ocorrencia de entrega atualiza a data na tabela de Pedidos
                if ($aux_oc == 1 || $aux_oc == 2 || $aux_oc == 24 || $aux_oc == 25 || $aux_oc == 31) {

                    $sql_aux = "Select a.pvnumero,b.pvdataentrega FROM notagua a,pvenda b					
						where a.pvnumero=b.pvnumero and a.notnumero='$aux_nf'";

                    $cad_aux = pg_query($sql_aux);
                    $row_aux = pg_num_rows($cad_aux);

                    if ($row_aux) {

                        $aux_pv = pg_fetch_result($cad_aux, 0, "pvnumero");
                        $aux_et = pg_fetch_result($cad_aux, 0, "pvdataentrega");

                        //Se data da Entrega nao preeenchida atualiza
                        //if($aux_et==''){
                        $sql2 = "Update pvenda set pvdataentrega='$aux_dt',pvhoraentrega='$aux_hr',pvflagentrega=3 WHERE pvnumero = '$aux_pv'";
                        pg_query($sql2);
                        //}
                    }
                }

                break;
            case "542":
                $record = ocorenReg542($filearray[$index], $ocorencod);
                if ($ocorencod != 0) {
                    $Cadastra = new Create;
                    $Cadastra->ExeCreate('ocorenreg342', 'ocorenreg342_ocorenreg342cod_seq', $record);
                    $Cadastra = null;
                }

                $aux_nf = (int) $record['nf'];
                $aux_dt = $record['data_ocor'];
                $aux_hr = substr($record['data_ocor'], 11, 5);
                $aux_oc = (int) $record['cod_entrega'];

                //Se for uma ocorrencia de entrega atualiza a data na tabela de Pedidos
                if ($aux_oc == 1 || $aux_oc == 2 || $aux_oc == 24 || $aux_oc == 25 || $aux_oc == 31) {

                    $sql_aux = "Select a.pvnumero,b.pvdataentrega FROM notagua a,pvenda b					
						where a.pvnumero=b.pvnumero and a.notnumero='$aux_nf'";

                    $cad_aux = pg_query($sql_aux);
                    $row_aux = pg_num_rows($cad_aux);

                    if ($row_aux) {

                        $aux_pv = pg_fetch_result($cad_aux, 0, "pvnumero");
                        $aux_et = pg_fetch_result($cad_aux, 0, "pvdataentrega");

                        //Se data da Entrega nao preeenchida atualiza
                        //if($aux_et==''){
                        $sql2 = "Update pvenda set pvdataentrega='$aux_dt',pvhoraentrega='$aux_hr',pvflagentrega=3 WHERE pvnumero = '$aux_pv'";
                        pg_query($sql2);
                        //}
                    }
                }

                break;


            case "343":
                $record = ocorenReg343($filearray[$index]);
                if ($ocorencod != 0) {
                    $update = new Update;
                    $update->ExeUpdate('ocoren', $record, "WHERE ocorencod = :id", 'id=' . $ocorencod);
                    $update = null;
                }
                break;
            case "543":

                //Localiza o Codigo Interno que acabou de Incluir no Registro 542			
                $sql = "SELECT max(ocorenreg342cod) AS ocorencod342 FROM " . TABELA_OCORENCIA_REG_342_TRANS . " WHERE ocorencod='$ocorencod'";
                $read = new Read;
                $read->FullRead($sql);

                if ($read->getRowCount() >= 1) {
                    $ocorencod342 = $read->getResult()[0]['ocorencod342'];
                } else {
                    return false;
                }

                $record = ocorenReg543($filearray[$index]);
                if ($ocorencod342 != 0) {
                    $update = new Update;
                    $update->ExeUpdate('ocorenreg342', $record, "WHERE ocorenreg342cod = :id", 'id=' . $ocorencod342);
                    $update = null;
                }

                break;
            case "545":
                $record = ocorenReg545($filearray[$index]);
                if ($ocorencod != 0) {
                    $update = new Update;
                    $update->ExeUpdate('ocoren', $record, "WHERE ocorencod = :id", 'id=' . $ocorencod);
                    $update = null;
                }
                break;
        }
    }
    //Se o ocorencod for diferente de 0 significa que foi realizado o insert com sucesso
    if ($ocorencod != 0) {
        return true;
    }
    return false;
}

function convertem($term, $tp) {
    if ($tp == "1")
        $palavra = strtr(strtoupper($term), "àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß");
    elseif ($tp == "0")
        $palavra = strtr(strtolower($term), "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß", "àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");
    return $palavra;
}
