<?php

require('./_app/Config.inc.php');

$parametro = trim($_REQUEST["parametro"]);
$parametro2 = trim($_REQUEST["parametro2"]);

//Se for uma Consulta por CNPJ criar duas pesquisas
if ($parametro2 == "4") {

    $cnpj1 = preg_replace("/[^0-9]/", "", $parametro);
    
    if(strlen($cnpj1)>12) {    
        $cnpj2 = mask($cnpj1, '##.###.###/####-##');
    } else if(strlen($cnpj1)>8) {    
        $cnpj2 = mask($cnpj1, '##.###.###/####');
    } else if(strlen($cnpj1)>5) {    
        $cnpj2 = mask($cnpj1, '##.###.###');
    } else if(strlen($cnpj1)>2) {    
        $cnpj2 = mask($cnpj1, '##.###');
    } else {
        $cnpj2 = $cnpj1;
    }
    
}

$sql = "SELECT a.forcodigo,a.fornguerra,a.forcod,a.forrazao,a.forsintegra,a.forcnpj,a.forie,a.forrg,a.forcpf,a.forobs,a.foricms,a.formaior,a.formedio,a.formenor,a.formenord,a.forminimo,a.forbanco,a.foragencia,a.forconta,a.pracodigo,a.stfcodigo,a.tpscodigo,a.forpessoa,a.fpgcodigo,a.forsintegrasn,a.formodo,a.fornacional
        ,b.fnecep,b.fneendereco,b.fnebairro,b.fnefone,b.fnefax,b.fneemail,b.fnecodigo
        ,c.fnfcep,c.fnfendereco,c.fnfbairro,c.fnffone,c.fnffax,c.fnfemail,c.fnfcodigo
        ,b.cidcodigo
        ,d.descricao as descricaocidade,d.uf
        ,c.cidcodigo as cidcodigo2
        ,e.descricao as descricaocidade2
        ,e.uf as uf2
        ,a.fortipo
        ,b.cidcodigoibge
        ,c.cidcodigoibge as cidcodigoibge2
        ,td.tipdespesacodigo as tipodespesa
        ,b.fnenumero
        ,c.fnfnumero 
        ,a.fordat 
        ,a.forvtex  
        ,a.forprodutos   
        ,a.grecodigo  
        FROM  fornecedor a
        LEFT JOIN forecom as b on b.forcodigo = a.forcodigo
        LEFT JOIN  forefab as c on c.forcodigo = a.forcodigo
        LEFT JOIN cidades as d on b.cidcodigo = d.cidcodigo
        LEFT JOIN cidades as e on c.cidcodigo = e.cidcodigo       
        LEFT JOIN tipodespesa as td on a.tipdespesacodigo = td.tipdespesacodigo ";

if ($parametro2 == "1") {
    $sql .= "WHERE cast(a.forcod as varchar) like '$parametro' ORDER BY a.forcod";
} elseif ($parametro2 == "2") {
    $sql .= "WHERE a.fornguerra like '%$parametro%' ORDER BY a.fornguerra";
} elseif ($parametro2 == "3") {
    $sql .= "WHERE a.forrazao like '%$parametro%' ORDER BY a.forrazao";
} elseif ($parametro2 == "4") {
    //$sql .= "WHERE a.forcnpj like '%$parametro%' ORDER BY a.forcnpj";
    $sql .= "WHERE (a.forcnpj like '%{$cnpj1}%' OR a.forcnpj like '%{$cnpj2}%') ORDER BY a.forcnpj";
} elseif ($parametro2 == "6") {
    $sql .= "WHERE a.forcodigo = '$parametro'";
} else {
    $sql .= "WHERE a.forcpf like '%$parametro%' ORDER BY a.forcpf";
}

$read = new Read;
$read->FullRead($sql);

if ($read->getRowCount() >= 1) {

    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    foreach ($read->getResult() as $registros) {
        extract($registros);

        $codigo = $forcodigo;
        $descricao = $fornguerra;
        $descricaob = $forcod;
        $descricaoc = $forrazao;
        $descricaod = $forsintegra;
        if ($descricaod <> "") {
            $descricaod = substr($descricaod, 8, 2) . '/' . substr($descricaod, 5, 2) . '/' . substr($descricaod, 0, 4);
        }
        $descricaoe = $forcnpj;
        $descricaof = $forie;
        $descricaog = $forrg;
        $descricaoh = $forcpf;
        $descricaoi = $forobs;
        $descricaoj = $foricms;
        $descricaok = $formaior;
        $descricaol = $formedio;
        $descricaom = $formenor;
        $descricaomd = $formenord;
        $descricaon = $forminimo;
        $descricaoo = $forbanco;
        $descricaop = $foragencia;
        $descricaoq = $forconta;
        $descricaor = $pracodigo;
        $tipdespesacodigo = $tipodespesa;
        $descricaos = $stfcodigo;
        $descricaot = $tpscodigo;
        $descricaou = $forpessoa;
        $descricao2a = $fnecep;
        $descricao2b = $fneendereco;
        $fnenumero = $fnenumero;
        $descricao2c = $fnebairro;
        $descricao2d = $fnefone;
        $descricao2e = $fnefax;
        $descricao2f = $fneemail;
        $fnecodigo = $fnecodigo;
        $codigocanal = $grecodigo;
        
        if (is_null($codigocanal) || trim($codigocanal) == "") {
            $codigocanal = 1;
        }

        $codigoa = $fpgcodigo;
        $descricaoaa = $forsintegrasn;
        $descricaoab = $formodo;
        $descricaoac = $fornacional;

        $fortipo = $fortipo;

        if ($fordat == null || trim($fordat) == "") {
            $fordat = 0;
        }
        if ($forvtex == null || trim($forvtex) == "") {
            $forvtex = 0;
        }
        if ($forprodutos == null || trim($forprodutos) == "") {
            $forprodutos = 2;
        }

        if (trim($fnecodigo) == "") {
            $fnecodigo = "0";
        }

        $sql2 = "SELECT fccnome,fccfone,fccemail FROM forccom WHERE fnecodigo = '$fnecodigo' ORDER BY fcccodigo";
        $read2 = new Read;
        $read2->FullRead($sql2);
        if ($read2->getRowCount() >= 1) {
            $a = -1;
            foreach ($read2->getResult() as $registros2) {
                extract($registros2);
                $a++;
                if ($a == 0) {
                    $descricao3a = $fccnome;
                    $descricao3b = $fccfone;
                    $descricao3d = $fccemail;
                } else if ($a == 1) {
                    $descricao4a = $fccnome;
                    $descricao4b = $fccfone;
                    $descricao4d = $fccemail;
                } else if ($a == 2) {
                    $descricao5a = $fccnome;
                    $descricao5b = $fccfone;
                    $descricao5d = $fccemail;
                }
            }
        } else {
            $descricao3a = "0";
            $descricao3b = "0";
            $descricao3d = "0";
            $descricao4a = "0";
            $descricao4b = "0";
            $descricao4d = "0";
            $descricao5a = "0";
            $descricao5b = "0";
            $descricao5d = "0";
        }
        $descricao6a = $fnfcep;
        $descricao6b = $fnfendereco;
        $fnfnumero = $fnfnumero;
        $descricao6c = $fnfbairro;
        $descricao6d = $fnffone;
        $descricao6e = $fnffax;
        $descricao6f = $fnfemail;
        $fnfcodigo = $fnfcodigo;
        if (trim($fnfcodigo) == "") {
            $fnfcodigo = "0";
        }

        $sql2 = "SELECT fcfnome,fcffone,fcfemail FROM forcfab WHERE fnfcodigo = '$fnfcodigo' ORDER BY fcfcodigo";
        $read2 = new Read;
        $read2->FullRead($sql2);
        if ($read2->getRowCount() >= 1) {
            $a = -1;
            foreach ($read2->getResult() as $registros2) {
                extract($registros2);
                $a++;
                if ($a == 0) {
                    $descricao7a = $fcfnome;
                    $descricao7b = $fcffone;
                    $descricao7d = $fcfemail;
                } else if ($a == 1) {
                    $descricao8a = $fcfnome;
                    $descricao8b = $fcffone;
                    $descricao8d = $fcfemail;
                } else if ($a == 2) {
                    $descricao9a = $fcfnome;
                    $descricao9b = $fcffone;
                    $descricao9d = $fcfemail;
                }
            }
        } else {
            $descricao7a = "0";
            $descricao7b = "0";
            $descricao7d = "0";
            $descricao8a = "0";
            $descricao8a = "0";
            $descricao8d = "0";
            $descricao9a = "0";
            $descricao9b = "0";
            $descricao9d = "0";
        }

        $descricaov = $cidcodigo;
        $descricaox = $descricaocidade;
        $descricaoz = $uf;

        $descricaov2 = $cidcodigo2;
        $descricaox2 = $descricaocidade2;
        $descricaoz2 = $uf2;

        $cidcodigoibge = $cidcodigoibge;
        $cidcodigoibge2 = $cidcodigoibge2;

        if (trim($codigo) == "") {
            $codigo = "0";
        }
        if (trim($descricao) == "") {
            $descricao = "0";
        }
        if (trim($descricaob) == "") {
            $descricaob = "0";
        }
        if (trim($descricaoc) == "") {
            $descricaoc = "0";
        }
        if (trim($descricaod) == "") {
            $descricaod = "0";
        }
        if (trim($descricaoe) == "") {
            $descricaoe = "0";
        }
        if (trim($descricaof) == "") {
            $descricaof = "0";
        }
        if (trim($descricaog) == "") {
            $descricaog = "0";
        }
        if (trim($descricaoh) == "") {
            $descricaoh = "0";
        }
        if (trim($descricaoi) == "") {
            $descricaoi = "0";
        }
        if (trim($descricaoj) == "") {
            $descricaoj = "0";
        }
        if (trim($descricaok) == "") {
            $descricaok = "0";
        }
        if (trim($descricaol) == "") {
            $descricaol = "0";
        }
        if (trim($descricaom) == "") {
            $descricaom = "0";
        }
        if (trim($descricaomd) == "") {
            $descricaomd = "0";
        }
        if (trim($descricaon) == "") {
            $descricaon = "0";
        }
        if (trim($descricaoo) == "") {
            $descricaoo = "0";
        }
        if (trim($descricaop) == "") {
            $descricaop = "0";
        }
        if (trim($descricaoq) == "") {
            $descricaoq = "0";
        }
        if (trim($descricaor) == "") {
            $descricaor = "0";
        }
        if (trim($descricaos) == "") {
            $descricaos = "0";
        }
        if (trim($descricaot) == "") {
            $descricaot = "0";
        }
        if (trim($descricaou) == "") {
            $descricaou = "0";
        }
        if (trim($descricao2a) == "") {
            $descricao2a = "0";
        }
        if (trim($descricao2b) == "") {
            $descricao2b = "0";
        }
        if (trim($descricao2c) == "") {
            $descricao2c = "0";
        }
        if (trim($descricao2d) == "") {
            $descricao2d = "0";
        }
        if (trim($descricao2e) == "") {
            $descricao2e = "0";
        }
        if (trim($descricao2f) == "") {
            $descricao2f = "0";
        }
        if (trim($descricao3a) == "") {
            $descricao3a = "0";
        }
        if (trim($descricao3b) == "") {
            $descricao3b = "0";
        }
        if (trim($descricao3d) == "") {
            $descricao3d = "0";
        }
        if (trim($descricao4a) == "") {
            $descricao4a = "0";
        }
        if (trim($descricao4b) == "") {
            $descricao4b = "0";
        }
        if (trim($descricao4d) == "") {
            $descricao4d = "0";
        }
        if (trim($descricao5a) == "") {
            $descricao5a = "0";
        }
        if (trim($descricao5b) == "") {
            $descricao5b = "0";
        }
        if (trim($descricao5d) == "") {
            $descricao5d = "0";
        }
        if (trim($descricao6a) == "") {
            $descricao6a = "0";
        }
        if (trim($descricao6b) == "") {
            $descricao6b = "0";
        }
        if (trim($descricao6c) == "") {
            $descricao6c = "0";
        }
        if (trim($descricao6d) == "") {
            $descricao6d = "0";
        }
        if (trim($descricao6e) == "") {
            $descricao6e = "0";
        }
        if (trim($descricao6f) == "") {
            $descricao6f = "0";
        }
        if (trim($descricao7a) == "") {
            $descricao7a = "0";
        }
        if (trim($descricao7b) == "") {
            $descricao7b = "0";
        }
        if (trim($descricao7d) == "") {
            $descricao7d = "0";
        }
        if (trim($descricao8a) == "") {
            $descricao8a = "0";
        }
        if (trim($descricao8b) == "") {
            $descricao8b = "0";
        }
        if (trim($descricao8d) == "") {
            $descricao8d = "0";
        }
        if (trim($descricao9a) == "") {
            $descricao9a = "0";
        }
        if (trim($descricao9b) == "") {
            $descricao9b = "0";
        }
        if (trim($descricao9d) == "") {
            $descricao9d = "0";
        }

        if (trim($descricaov) == "") {
            $descricaov = "0";
        }
        if (trim($descricaox) == "") {
            $descricaox = "0";
        }
        if (trim($descricaoz) == "") {
            $descricaoz = "0";
        }

        if (trim($descricaov2) == "") {
            $descricaov2 = "0";
        }
        if (trim($descricaox2) == "") {
            $descricaox2 = "0";
        }
        if (trim($descricaoz2) == "") {
            $descricaoz2 = "0";
        }

        if (trim($descricaoaa) == "") {
            $descricaoaa = "0";
        }
        if (trim($codigoa) == "") {
            $codigoa = "0";
        }
        if (trim($tipdespesacodigo) == "") {
            $tipdespesacodigo = "0";
        }
        if (trim($descricaoab) == "") {
            $descricaoab = "1";
        }
        if (trim($descricaoac) == "") {
            $descricaoac = "1";
        }

        if (trim($fortipo) == "") {
            $fortipo = "1";
        }

        if (trim($cidcodigoibge) == "") {
            $cidcodigoibge = "0";
        }
        if (trim($cidcodigoibge2) == "") {
            $cidcodigoibge2 = "0";
        }
        if (trim($fnenumero) == "") {
            $fnenumero = "0";
        }
        if (trim($fnfnumero) == "") {
            $fnfnumero = "0";
        }

        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<fordat>" . $fordat . "</fordat>\n";
        $xml .= "<forvtex>" . $forvtex . "</forvtex>\n";
        $xml .= "<forprodutos>" . $forprodutos . "</forprodutos>\n";
        $xml .= "<descricao>" . $descricao . "</descricao>\n";
        $xml .= "<descricaob>" . $descricaob . "</descricaob>\n";
        $xml .= "<descricaoc>" . $descricaoc . "</descricaoc>\n";
        $xml .= "<descricaod>" . $descricaod . "</descricaod>\n";
        $xml .= "<descricaoe>" . $descricaoe . "</descricaoe>\n";
        $xml .= "<descricaof>" . $descricaof . "</descricaof>\n";
        $xml .= "<descricaog>" . $descricaog . "</descricaog>\n";
        $xml .= "<descricaoh>" . $descricaoh . "</descricaoh>\n";
        $xml .= "<descricaoi>" . $descricaoi . "</descricaoi>\n";
        $xml .= "<descricaoj>" . $descricaoj . "</descricaoj>\n";
        $xml .= "<descricaok>" . $descricaok . "</descricaok>\n";
        $xml .= "<descricaol>" . $descricaol . "</descricaol>\n";
        $xml .= "<descricaom>" . $descricaom . "</descricaom>\n";
        $xml .= "<descricaomd>" . $descricaomd . "</descricaomd>\n";
        $xml .= "<descricaon>" . $descricaon . "</descricaon>\n";
        $xml .= "<descricaoo>" . $descricaoo . "</descricaoo>\n";
        $xml .= "<descricaop>" . $descricaop . "</descricaop>\n";
        $xml .= "<descricaoq>" . $descricaoq . "</descricaoq>\n";
        $xml .= "<descricaor>" . $descricaor . "</descricaor>\n";
        $xml .= "<tipdespesacodigo>" . $tipdespesacodigo . "</tipdespesacodigo>\n";
        $xml .= "<descricaos>" . $descricaos . "</descricaos>\n";
        $xml .= "<codigocanal>" . $codigocanal . "</codigocanal>\n";
        $xml .= "<descricaot>" . $descricaot . "</descricaot>\n";
        $xml .= "<descricaou>" . $descricaou . "</descricaou>\n";
        $xml .= "<descricao2a>" . $descricao2a . "</descricao2a>\n";
        $xml .= "<descricao2b>" . $descricao2b . "</descricao2b>\n";
        $xml .= "<descricao2c>" . $descricao2c . "</descricao2c>\n";
        $xml .= "<descricao2d>" . $descricao2d . "</descricao2d>\n";
        $xml .= "<descricao2e>" . $descricao2e . "</descricao2e>\n";
        $xml .= "<descricao2f>" . $descricao2f . "</descricao2f>\n";
        $xml .= "<descricao3a>" . $descricao3a . "</descricao3a>\n";
        $xml .= "<descricao3b>" . $descricao3b . "</descricao3b>\n";
        $xml .= "<descricao3d>" . $descricao3d . "</descricao3d>\n";
        $xml .= "<descricao4a>" . $descricao4a . "</descricao4a>\n";
        $xml .= "<descricao4b>" . $descricao4b . "</descricao4b>\n";
        $xml .= "<descricao4d>" . $descricao4d . "</descricao4d>\n";
        $xml .= "<descricao5a>" . $descricao5a . "</descricao5a>\n";
        $xml .= "<descricao5b>" . $descricao5b . "</descricao5b>\n";
        $xml .= "<descricao5d>" . $descricao5d . "</descricao5d>\n";
        $xml .= "<descricao6a>" . $descricao6a . "</descricao6a>\n";
        $xml .= "<descricao6b>" . $descricao6b . "</descricao6b>\n";
        $xml .= "<descricao6c>" . $descricao6c . "</descricao6c>\n";
        $xml .= "<descricao6d>" . $descricao6d . "</descricao6d>\n";
        $xml .= "<descricao6e>" . $descricao6e . "</descricao6e>\n";
        $xml .= "<descricao6f>" . $descricao6f . "</descricao6f>\n";
        $xml .= "<descricao7a>" . $descricao7a . "</descricao7a>\n";
        $xml .= "<descricao7b>" . $descricao7b . "</descricao7b>\n";
        $xml .= "<descricao7d>" . $descricao7d . "</descricao7d>\n";
        $xml .= "<descricao8a>" . $descricao8a . "</descricao8a>\n";
        $xml .= "<descricao8b>" . $descricao8b . "</descricao8b>\n";
        $xml .= "<descricao8d>" . $descricao8d . "</descricao8d>\n";
        $xml .= "<descricao9a>" . $descricao9a . "</descricao9a>\n";
        $xml .= "<descricao9b>" . $descricao9b . "</descricao9b>\n";
        $xml .= "<descricao9d>" . $descricao9d . "</descricao9d>\n";
        $xml .= "<descricaov>" . $descricaov . "</descricaov>\n";
        $xml .= "<descricaox>" . $descricaox . "</descricaox>\n";
        $xml .= "<descricaoz>" . $descricaoz . "</descricaoz>\n";
        $xml .= "<descricaov2>" . $descricaov2 . "</descricaov2>\n";
        $xml .= "<descricaox2>" . $descricaox2 . "</descricaox2>\n";
        $xml .= "<descricaoz2>" . $descricaoz2 . "</descricaoz2>\n";
        $xml .= "<fnenumero>" . $fnenumero . "</fnenumero>\n";
        $xml .= "<fnfnumero>" . $fnfnumero . "</fnfnumero>\n";
        $xml .= "<descricaoaa>" . $descricaoaa . "</descricaoaa>\n";
        $xml .= "<descricaoab>" . $descricaoab . "</descricaoab>\n";
        $xml .= "<descricaoac>" . $descricaoac . "</descricaoac>\n";
        $xml .= "<codigoa>" . $codigoa . "</codigoa>\n";
        $xml .= "<fortipo>" . $fortipo . "</fortipo>\n";
        if ($cidcodigoibge == "")
            $cidcodigoibge = "0";
        $xml .= "<descricaoib>" . $cidcodigoibge . "</descricaoib>\n";

        $auxestado = substr($cidcodigoibge, 0, 2);
        $auxcidade = substr($cidcodigoibge, 2, 5);

        //Busca no nome da cidade do IBGE        
        $sql3 = "SELECT descricao FROM cidadesibge WHERE codestado=$auxestado and codcidade like '$auxcidade'";
        $read3 = new Read;
        $read3->FullRead($sql3);
        $cidadeibge = "";
        if ($read3->getRowCount() >= 1) {
            $cidadeibge = $read3->getResult()[0]['descricao'];
        }

        if ($cidadeibge == "")
            $cidadeibge = "0";

        $xml .= "<cidadeibge>" . $cidadeibge . "</cidadeibge>\n";


        if ($cidcodigoibge2 == "")
            $cidcodigoibge2 = "0";
        $xml .= "<descricaoib2>" . $cidcodigoibge2 . "</descricaoib2>\n";

        $auxestado2 = substr($cidcodigoibge2, 0, 2);
        $auxcidade2 = substr($cidcodigoibge2, 2, 5);

        //Busca no nome da cidade do IBGE
        $sql4 = "SELECT descricao FROM cidadesibge WHERE codestado=$auxestado2 and codcidade like '$auxcidade2'";
        $read4 = new Read;
        $read4->FullRead($sql4);
        $cidadeibge2 = "";
        if ($read4->getRowCount() >= 1) {
            $cidadeibge2 = $read4->getResult()[0]['descricao'];
        }

        if ($cidadeibge2 == "")
            $cidadeibge2 = "0";

        $xml .= "<cidadeibge2>" . $cidadeibge2 . "</cidadeibge2>\n";
        $xml .= "</dado>\n";
    }
    $xml .= "</dados>\n";
    Header("Content-type: application/xml; charset=iso-8859-1");
}
echo $xml;

function mask($val, $mask) {
    $maskared = '';
    $k = 0;
    for ($i = 0; $i <= strlen($mask) - 1; $i++) {
        if ($mask[$i] == '#') {
            if (isset($val[$k]))
                $maskared .= $val[$k++];
        } else {
            if (isset($mask[$i]))
                $maskared .= $mask[$i];
        }
    }
    return $maskared;
}
