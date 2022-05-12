<?php

require_once("include/conexao.inc.php");
require_once("include/produto.php");

//RECEBE PARÃMETRO
$parametro = trim($_POST["parametro"]);
$parametro2 = trim($_POST["parametro2"]);

/*
  $parametro = '4999-9';
  $parametro2 = '1';
 */

$cadastro = new banco($conn, $db);

//QUERY
if ($parametro2 == "2") {
    $sql = "
       	SELECT a.procodigo,a.prnome,a.prdescr,a.procod,a.proref,a.proemb,a.proipi,a.promedio,a.promaior,a.promenor,a.promenord,a.prominimo,a.proreal,a.profinal,a.prorealv,a.profinalv,a.proreall,a.profinall,a.prodesc1
		,a.prorealg,a.profinalg,a.proactive
		,a.prodesc2,a.primagem as prodesc3,a.proaltura,a.prolargura,a.procompr,a.propeso,a.properc,a.proval,a.proacres,a.prodescs,a.procarac,a.grucodigo,a.subcodigo,a.marcodigo,a.sbmcodigo,a.lincodigo,a.stpcodigo,a.faicodigo,a.corcodigo,a.medcodigo,a.tricodigo,a.trbcodigo,a.clacodigo,a.prosexo,a.provalid,a.pronet,a.proativo,a.procons,a.proesg,a.propresen,a.prosort,a.forcodigo,a.proaltcx,a.prolarcx,a.procomcx,a.procubcx,a.propescx
                ,b.barunidade,b.barcaixa,a.proisento as proicms,a.procompra,a.proprocedencia,a.prosubs,a.provtex,a.proanymarket,a.proexpestoque,a.proexpdatasul,a.protpsort,a.promaster,a.proprecad,a.prodtinicio,a.prodtfinal
                ,a.provalida,c.usunome AS usuvalida 
        FROM  produto a
		LEft Join  cbarras as b on b.procodigo = a.procodigo 
                LEFT JOIN  usuarios as c on c.usucodigo = a.usuvalida 
		WHERE a.prnome like '%$parametro%'
		ORDER BY a.prnome";
} else if ($parametro2 == "3") {
    $sql = "
       	SELECT a.procodigo,a.prnome,a.prdescr,a.procod,a.proref,a.proemb,a.proipi,a.promedio,a.promaior,a.promenor,a.promenord,a.promenord,a.prominimo,a.proreal,a.profinal,a.prorealv,a.profinalv,a.proreall,a.profinall
		,a.prorealg,a.profinalg,a.proactive
		,a.prodesc1,a.prodesc2,a.primagem as prodesc3,a.proaltura,a.prolargura,a.procompr,a.propeso,a.properc,a.proval,a.proacres,a.prodescs,a.procarac,a.grucodigo,a.subcodigo,a.marcodigo,a.sbmcodigo,a.lincodigo,a.stpcodigo,a.faicodigo,a.corcodigo,a.medcodigo,a.tricodigo,a.trbcodigo,a.clacodigo,a.prosexo,a.provalid,a.pronet,a.proativo,a.procons,a.proesg,a.propresen,a.prosort,a.forcodigo,a.proaltcx,a.prolarcx,a.procomcx,a.procubcx,a.propescx
		,b.barunidade,b.barcaixa,a.proisento as proicms,a.procompra,a.proprocedencia,a.prosubs,a.provtex,a.proanymarket,a.proexpestoque,a.proexpdatasul,a.protpsort,a.promaster,a.proprecad,a.prodtinicio,a.prodtfinal
                ,a.provalida,c.usunome AS usuvalida 
        FROM  produto a
		LEft Join  cbarras as b on b.procodigo = a.procodigo 
                LEFT JOIN  usuarios as c on c.usucodigo = a.usuvalida 
		WHERE a.proref like '%$parametro%'
		ORDER BY a.proref";
} else {
    $sql = "
       	SELECT a.procodigo,a.prnome,a.prdescr,a.procod,a.proref,a.proemb,a.proipi,a.promedio,a.promaior,a.promenor,a.promenord,a.prominimo,a.proreal,a.profinal,a.prorealv,a.profinalv,a.proreall,a.profinall
		,a.prorealg,a.profinalg,a.proactive
		,a.prodesc1,a.prodesc2,a.primagem as prodesc3,a.proaltura,a.prolargura,a.procompr,a.propeso,a.properc,a.proval,a.proacres,a.prodescs,a.procarac,a.grucodigo,a.subcodigo,a.marcodigo,a.sbmcodigo,a.lincodigo,a.stpcodigo,a.faicodigo,a.corcodigo,a.medcodigo,a.tricodigo,a.trbcodigo,a.clacodigo,a.prosexo,a.provalid,a.pronet,a.proativo,a.procons,a.proesg,a.propresen,a.prosort,a.forcodigo,a.proaltcx,a.prolarcx,a.procomcx,a.procubcx,a.propescx
	   	,b.barunidade,b.barcaixa,a.proisento as proicms,a.procompra,a.proprocedencia,a.prosubs,a.provtex,a.proanymarket,a.proexpestoque,a.proexpdatasul,a.protpsort,a.promaster,a.proprecad,a.prodtinicio,a.prodtfinal
                ,a.provalida,c.usunome AS usuvalida 
        FROM  produto a
		LEft Join  cbarras as b on b.procodigo = a.procodigo	
                LEFT JOIN  usuarios as c on c.usucodigo = a.usuvalida 
		WHERE a.procod like '%$parametro%'
		ORDER BY a.procod";
}

//EXECUTA A QUERY
$sql = pg_query($sql);

$row = pg_num_rows($sql);

//VERIFICA SE VOLTOU ALGO
if ($row) {

    //ISO-8859-1
    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {
        $codigo = pg_fetch_result($sql, $i, "procodigo");
        $descricao = pg_fetch_result($sql, $i, "prnome");
        $descricao2 = pg_fetch_result($sql, $i, "prdescr");
        $descricaob = pg_fetch_result($sql, $i, "procod");
        $descricaod = pg_fetch_result($sql, $i, "proref");
        $descricaoe = pg_fetch_result($sql, $i, "proemb");
        $descricaof = pg_fetch_result($sql, $i, "proipi");
        $descricaog = pg_fetch_result($sql, $i, "promedio");
        $descricaoh = pg_fetch_result($sql, $i, "promaior");
        $descricaoi = pg_fetch_result($sql, $i, "promenor");
        $descricaoid = pg_fetch_result($sql, $i, "promenord");
        $descricaoj = pg_fetch_result($sql, $i, "prominimo");
        $descricaok = pg_fetch_result($sql, $i, "proreal");
        $descricaol = pg_fetch_result($sql, $i, "profinal");
        $prorealv = pg_fetch_result($sql, $i, "prorealv");
        $profinalv = pg_fetch_result($sql, $i, "profinalv");
        $proreall = pg_fetch_result($sql, $i, "proreall");
        $profinall = pg_fetch_result($sql, $i, "profinall");

        $prorealg = pg_fetch_result($sql, $i, "prorealg");
        $profinalg = pg_fetch_result($sql, $i, "profinalg");

        $descricaom = pg_fetch_result($sql, $i, "prodesc1");
        $descricaon = pg_fetch_result($sql, $i, "prodesc2");
        $descricaoo = pg_fetch_result($sql, $i, "prodesc3");

        $descricaoo = utf8_decode($descricaoo);

        $descricaop = pg_fetch_result($sql, $i, "proaltura");
        $descricaoq = pg_fetch_result($sql, $i, "prolargura");
        $descricaor = pg_fetch_result($sql, $i, "procompr");
        $descricaos = pg_fetch_result($sql, $i, "propeso");
        $descricaot = pg_fetch_result($sql, $i, "properc");
        $descricaou = pg_fetch_result($sql, $i, "proval");
        $descricaov = pg_fetch_result($sql, $i, "proacres");
        $descricaox = pg_fetch_result($sql, $i, "prodescs");
        $descricaoz = pg_fetch_result($sql, $i, "procarac");

        $descricaoz = utf8_decode($descricaoz);

        //Retira o & e # que geram erros na hora de Gravar
        $especiais = array("&", "#");
        $descricaoz = str_replace($especiais, "", $descricaoz);

        $codigo1 = pg_fetch_result($sql, $i, "grucodigo");
        $codigo2 = pg_fetch_result($sql, $i, "subcodigo");
        $codigo3 = pg_fetch_result($sql, $i, "marcodigo");
        $codigo4 = pg_fetch_result($sql, $i, "sbmcodigo");
        $codigo5 = pg_fetch_result($sql, $i, "lincodigo");
        $codigo6 = pg_fetch_result($sql, $i, "stpcodigo");
        $codigo7 = pg_fetch_result($sql, $i, "faicodigo");
        $codigocor = pg_fetch_result($sql, $i, "corcodigo");
        $codigo8 = pg_fetch_result($sql, $i, "medcodigo");
        $codigo9 = pg_fetch_result($sql, $i, "tricodigo");
        $codigo10 = pg_fetch_result($sql, $i, "trbcodigo");
        $codigo11 = pg_fetch_result($sql, $i, "clacodigo");
        $opcao1 = pg_fetch_result($sql, $i, "prosexo");
        $opcao2 = pg_fetch_result($sql, $i, "provalid");
        $opcao3 = pg_fetch_result($sql, $i, "pronet");
        $opcao4 = pg_fetch_result($sql, $i, "proativo");
        $opcao5 = pg_fetch_result($sql, $i, "procons");
        $opcao6 = pg_fetch_result($sql, $i, "proesg");
        $opcao7 = pg_fetch_result($sql, $i, "propresen");
        $opcao8 = pg_fetch_result($sql, $i, "prosort");
        $codigo12 = pg_fetch_result($sql, $i, "forcodigo");
        $descra = pg_fetch_result($sql, $i, "proaltcx");
        $descrb = pg_fetch_result($sql, $i, "prolarcx");
        $descrc = pg_fetch_result($sql, $i, "procomcx");
        $descrcx = pg_fetch_result($sql, $i, "procubcx");
        $descrd = pg_fetch_result($sql, $i, "propescx");
        $descre = pg_fetch_result($sql, $i, "barunidade");
        $descrf = pg_fetch_result($sql, $i, "barcaixa");
        $proicms = pg_fetch_result($sql, $i, "proicms");
        $procompra = pg_fetch_result($sql, $i, "procompra");
        $proprocedencia = pg_fetch_result($sql, $i, "proprocedencia");
        $prosubs = pg_fetch_result($sql, $i, "prosubs");
        $provtex = pg_fetch_result($sql, $i, "provtex");
        $proanymarket = pg_fetch_result($sql, $i, "proanymarket");
        $proexpestoque = pg_fetch_result($sql, $i, "proexpestoque");
        $proexpdatasul = pg_fetch_result($sql, $i, "proexpdatasul");

        $protpsort = pg_fetch_result($sql, $i, "protpsort");
        $promaster = pg_fetch_result($sql, $i, "promaster");

        $proprecad = pg_fetch_result($sql, $i, "proprecad");

        $prodtinicio = pg_fetch_result($sql, $i, "prodtinicio");
        $prodtfinal = pg_fetch_result($sql, $i, "prodtfinal");

        $provalida = pg_fetch_result($sql, $i, "provalida");
        $usuvalida = pg_fetch_result($sql, $i, "usuvalida");
        $proactive = pg_fetch_result($sql, $i, "proactive");

        if (trim($codigo) == "") {
            $codigo = "0";
        }
        if (trim($descricao) == "") {
            $descricao = "0";
        }
        if (trim($descricao2) == "") {
            $descricao2 = "0";
        }
        if (trim($descricaob) == "") {
            $descricaob = "0";
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
        if (trim($descricaoid) == "") {
            $descricaoid = "0";
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
        if (trim($descricaov) == "") {
            $descricaov = "0";
        }
        if (trim($descricaox) == "") {
            $descricaox = "0";
        }
        if (trim($descricaoz) == "") {
            $descricaoz = "0";
        }
        if (trim($codigo1) == "") {
            $codigo1 = "0";
        }
        if (trim($codigo2) == "") {
            $codigo2 = "0";
        }
        if (trim($codigo3) == "") {
            $codigo3 = "0";
        }
        if (trim($codigo4) == "") {
            $codigo4 = "0";
        }
        if (trim($codigo5) == "") {
            $codigo5 = "0";
        }
        if (trim($codigo6) == "") {
            $codigo6 = "0";
        }
        if (trim($codigo7) == "") {
            $codigo7 = "0";
        }
        if (trim($codigocor) == "") {
            $codigocor = "0";
        }
        if (trim($codigo8) == "") {
            $codigo8 = "0";
        }
        if (trim($codigo9) == "") {
            $codigo9 = "0";
        }
        if (trim($codigo10) == "") {
            $codigo10 = "0";
        }
        if (trim($codigo11) == "") {
            $codigo11 = "0";
        }
        if (trim($opcao1) == "") {
            $opcao1 = "0";
        }
        if (trim($opcao2) == "") {
            $opcao2 = "0";
        }
        if (trim($opcao3) == "") {
            $opcao3 = "0";
        }
        if (trim($opcao4) == "") {
            $opcao4 = "0";
        }
        if (trim($opcao5) == "") {
            $opcao5 = "0";
        }
        if (trim($opcao6) == "") {
            $opcao6 = "0";
        }
        if (trim($opcao7) == "") {
            $opcao7 = "0";
        }
        if (trim($opcao8) == "") {
            $opcao8 = "0";
        }
        if (trim($codigo12) == "") {
            $codigo12 = "0";
        }
        if (trim($descra) == "") {
            $descra = "0";
        }
        if (trim($descrb) == "") {
            $descrb = "0";
        }
        if (trim($descrc) == "") {
            $descrc = "0";
        }
        if (trim($descrcx) == "") {
            $descrcx = "0";
        }
        if (trim($descrd) == "") {
            $descrd = "0";
        }
        if (trim($descre) == "") {
            $descre = "0";
        }
        if (trim($descrf) == "") {
            $descrf = "0";
        }
        if (trim($proicms) == "") {
            $proicms = "0";
        }
        if (trim($procompra) == "") {
            $procompra = "0";
        }
        if (trim($prosubs) == "") {
            $prosubs = "0";
        }
        if (trim($provtex) == "") {
            $provtex = "1";
        }
        if (trim($proanymarket) == "") {
            $proanymarket = "1";
        }
        if (trim($proexpestoque) == "") {
            $proexpestoque = "1";
        }
        if (trim($proexpdatasul) == "") {
            $proexpdatasul = "1";
        }
        if (trim($proprocedencia) == "") {
            $proprocedencia = "0";
        }
        if (trim($prorealv) == "") {
            $prorealv = "0";
        }
        if (trim($profinalv) == "") {
            $profinalv = "0";
        }
        if (trim($proreall) == "") {
            $proreall = "0";
        }
        if (trim($profinall) == "") {
            $profinall = "0";
        }

        if (trim($prorealg) == "") {
            $prorealg = "0";
        }
        if (trim($profinalg) == "") {
            $profinalg = "0";
        }

        if (trim($protpsort) == "") {
            $protpsort = "1";
        }
        if (trim($promaster) == "") {
            $promaster = "0";
        }
        if (trim($proprecad) == "") {
            $proprecad = "0";
        }
        if (trim($prodtinicio) == "") {
            $prodtinicio = "0";
        } else {
            $prodtinicio = substr($prodtinicio, 8, 2) . '/' . substr($prodtinicio, 5, 2) . '/' . substr($prodtinicio, 0, 4);
        }
        if (trim($prodtfinal) == "") {
            $prodtfinal = "0";
        } else {
            $prodtfinal = substr($prodtfinal, 8, 2) . '/' . substr($prodtfinal, 5, 2) . '/' . substr($prodtfinal, 0, 4);
        }

       
        $crossbarao = 0;
        

        if ($provalida == "") {
            $provalidacao = "PRODUTO SEM VALIDACAO";
        } else {
            $aux = explode(" ", $provalida);
            $aux1 = explode("-", $aux[0]);
            $provalida = $aux1[2] . '/' . $aux1[1] . '/' . $aux1[0] . ' AS ' . substr($provalida, 11, 5);
            $provalidacao = "PRODUTO VALIDADO POR {$usuvalida} EM {$provalida}";
        }

        if (trim($proactive) == "") {
            $proactive = "0";
        }

        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao>" . $descricao . "</descricao>\n";
        $xml .= "<provalidacao>" . $provalidacao . "</provalidacao>\n";
        $xml .= "<descricao2>" . $descricao2 . "</descricao2>\n";
        $xml .= "<descricaob>" . $descricaob . "</descricaob>\n";
        $xml .= "<descricaod>" . $descricaod . "</descricaod>\n";
        $xml .= "<descricaoe>" . $descricaoe . "</descricaoe>\n";
        $xml .= "<descricaof>" . $descricaof . "</descricaof>\n";
        $xml .= "<descricaog>" . $descricaog . "</descricaog>\n";
        $xml .= "<descricaoh>" . $descricaoh . "</descricaoh>\n";
        $xml .= "<descricaoi>" . $descricaoi . "</descricaoi>\n";
        $xml .= "<descricaoid>" . $descricaoid . "</descricaoid>\n";
        $xml .= "<descricaoj>" . $descricaoj . "</descricaoj>\n";
        $xml .= "<descricaok>" . $descricaok . "</descricaok>\n";
        $xml .= "<descricaol>" . $descricaol . "</descricaol>\n";
        $xml .= "<descricaom>" . $descricaom . "</descricaom>\n";
        $xml .= "<descricaon>" . $descricaon . "</descricaon>\n";
        $xml .= "<descricaoo>" . $descricaoo . "</descricaoo>\n";
        $xml .= "<descricaop>" . $descricaop . "</descricaop>\n";
        $xml .= "<descricaoq>" . $descricaoq . "</descricaoq>\n";
        $xml .= "<descricaor>" . $descricaor . "</descricaor>\n";
        $xml .= "<descricaos>" . $descricaos . "</descricaos>\n";
        $xml .= "<descricaot>" . $descricaot . "</descricaot>\n";
        $xml .= "<descricaou>" . $descricaou . "</descricaou>\n";
        $xml .= "<descricaov>" . $descricaov . "</descricaov>\n";
        $xml .= "<descricaox>" . $descricaox . "</descricaox>\n";
        $xml .= "<descricaoz>" . $descricaoz . "</descricaoz>\n";
        $xml .= "<crossbarao>" . $crossbarao . "</crossbarao>\n";
        $xml .= "<codigo1>" . $codigo1 . "</codigo1>\n";
        $xml .= "<codigo2>" . $codigo2 . "</codigo2>\n";
        $xml .= "<codigo3>" . $codigo3 . "</codigo3>\n";
        $xml .= "<codigo4>" . $codigo4 . "</codigo4>\n";
        $xml .= "<codigo5>" . $codigo5 . "</codigo5>\n";
        $xml .= "<codigo6>" . $codigo6 . "</codigo6>\n";
        $xml .= "<codigo7>" . $codigo7 . "</codigo7>\n";
        $xml .= "<codigocor>" . $codigocor . "</codigocor>\n";
        $xml .= "<codigo8>" . $codigo8 . "</codigo8>\n";
        $xml .= "<codigo9>" . $codigo9 . "</codigo9>\n";
        $xml .= "<codigo10>" . $codigo10 . "</codigo10>\n";
        $xml .= "<codigo11>" . $codigo11 . "</codigo11>\n";
        $xml .= "<opcao1>" . $opcao1 . "</opcao1>\n";
        $xml .= "<opcao2>" . $opcao2 . "</opcao2>\n";
        $xml .= "<opcao3>" . $opcao3 . "</opcao3>\n";
        $xml .= "<opcao4>" . $opcao4 . "</opcao4>\n";
        $xml .= "<opcao5>" . $opcao5 . "</opcao5>\n";
        $xml .= "<opcao6>" . $opcao6 . "</opcao6>\n";
        $xml .= "<opcao7>" . $opcao7 . "</opcao7>\n";
        $xml .= "<opcao8>" . $opcao8 . "</opcao8>\n";
        $xml .= "<codigo12>" . $codigo12 . "</codigo12>\n";
        $xml .= "<descra>" . $descra . "</descra>\n";
        $xml .= "<descrb>" . $descrb . "</descrb>\n";
        $xml .= "<descrc>" . $descrc . "</descrc>\n";
        $xml .= "<descrcx>" . $descrcx . "</descrcx>\n";
        $xml .= "<descrd>" . $descrd . "</descrd>\n";
        $xml .= "<descre>" . $descre . "</descre>\n";
        $xml .= "<descrf>" . $descrf . "</descrf>\n";
        $xml .= "<proicms>" . $proicms . "</proicms>\n";
        $xml .= "<procompra>" . $procompra . "</procompra>\n";
        $xml .= "<proprocedencia>" . $proprocedencia . "</proprocedencia>\n";
        $xml .= "<prosubs>" . $prosubs . "</prosubs>\n";
        $xml .= "<expvtex>" . $provtex . "</expvtex>\n";
        $xml .= "<expany>" . $proanymarket . "</expany>\n";
        $xml .= "<expest>" . $proexpestoque . "</expest>\n";
        $xml .= "<expdat>" . $proexpdatasul . "</expdat>\n";
        $xml .= "<prorealv>" . $prorealv . "</prorealv>\n";
        $xml .= "<profinalv>" . $profinalv . "</profinalv>\n";
        $xml .= "<proreall>" . $proreall . "</proreall>\n";
        $xml .= "<profinall>" . $profinall . "</profinall>\n";

        $xml .= "<prorealg>" . $prorealg . "</prorealg>\n";
        $xml .= "<profinalg>" . $profinalg . "</profinalg>\n";

        $xml .= "<protpsort>" . $protpsort . "</protpsort>\n";
        $xml .= "<promaster>" . $promaster . "</promaster>\n";
        $xml .= "<proprecad>" . $proprecad . "</proprecad>\n";
        $xml .= "<prodtinicio>" . $prodtinicio . "</prodtinicio>\n";
        $xml .= "<prodtfinal>" . $prodtfinal . "</prodtfinal>\n";
        $xml .= "<proactive>" . $proactive . "</proactive>\n";

        $mastercod = '_';
        $masternom = '_';

        if ($promaster != '0') {
            $sql2 = "SELECT procod,prnome FROM produto WHERE procodigo = '$promaster'";
            $sql2 = pg_query($sql2);
            $row2 = pg_num_rows($sql2);
            if ($row2) {
                $mastercod = pg_fetch_result($sql2, 0, "procod");
                $masternom = pg_fetch_result($sql2, 0, "prnome");
            }
        }

        $xml .= "<mastercod>" . $mastercod . "</mastercod>\n";
        $xml .= "<masternom>" . $masternom . "</masternom>\n";
        
        
        $vala1 = "";
        $val1 = "";
        $data1 = "";
        $usunome1 = "";

        $vala2 = "";
        $val2 = "";
        $data2 = "";
        $usunome2 = "";

        $vala3 = "";
        $val3 = "";
        $data3 = "";
        $usunome3 = "";

        $sql2 = "SELECT c.valorant,c.valor,c.data,d.usunome FROM logprecosprod c
		Left Join usuarios as d on d.usucodigo = c.usucodigo
		WHERE c.procodigo = '$codigo' and flag = 1
		
		ORDER BY c.lppcodigo desc";

        $sql2 = pg_query($sql2);
        $row2 = pg_num_rows($sql2);
        if ($row2) {
            for ($i2 = 0; $i2 < $row2; $i2++) {
                if ($i2 == 0) {
                    $vala1 = pg_fetch_result($sql2, $i2, "valorant");
                    $val1 = pg_fetch_result($sql2, $i2, "valor");
                    $data1 = pg_fetch_result($sql2, $i2, "data");
                    $usunome1 = pg_fetch_result($sql2, $i2, "usunome");
                }
                if ($i2 == 1) {
                    $vala2 = pg_fetch_result($sql2, $i2, "valorant");
                    $val2 = pg_fetch_result($sql2, $i2, "valor");
                    $data2 = pg_fetch_result($sql2, $i2, "data");
                    $usunome2 = pg_fetch_result($sql2, $i2, "usunome");
                }
                if ($i2 == 3) {
                    $vala3 = pg_fetch_result($sql2, $i2, "valorant");
                    $val3 = pg_fetch_result($sql2, $i2, "valor");
                    $data3 = pg_fetch_result($sql2, $i2, "data");
                    $usunome3 = pg_fetch_result($sql2, $i2, "usunome");
                }
            }
        }

        if (trim($vala1) == "") {
            $vala1 = "0";
        }
        if (trim($vala2) == "") {
            $vala2 = "0";
        }
        if (trim($vala3) == "") {
            $vala3 = "0";
        }

        if (trim($val1) == "") {
            $val1 = "0";
        }
        if (trim($val2) == "") {
            $val2 = "0";
        }
        if (trim($val3) == "") {
            $val3 = "0";
        }

        if ($data1 != "")
            $data1 = substr($data1, 8, 2) . '/' . substr($data1, 5, 2) . '/' . substr($data1, 0, 4) . ' ' . substr($data1, 10, 9);
        else
            $data1 = "0";

        if ($data2 != "")
            $data2 = substr($data2, 8, 2) . '/' . substr($data2, 5, 2) . '/' . substr($data2, 0, 4) . ' ' . substr($data2, 10, 9);
        else
            $data2 = "0";

        if ($data3 != "")
            $data3 = substr($data3, 8, 2) . '/' . substr($data3, 5, 2) . '/' . substr($data3, 0, 4) . ' ' . substr($data3, 10, 9);
        else
            $data3 = "0";

        if (trim($usunome1) == "") {
            $usunome1 = "0";
        }
        if (trim($usunome2) == "") {
            $usunome2 = "0";
        }
        if (trim($usunome3) == "") {
            $usunome3 = "0";
        }

        $xml .= "<vala1>" . $vala1 . "</vala1>\n";
        $xml .= "<vala2>" . $vala2 . "</vala2>\n";
        $xml .= "<vala3>" . $vala3 . "</vala3>\n";

        $xml .= "<val1>" . $val1 . "</val1>\n";
        $xml .= "<val2>" . $val2 . "</val2>\n";
        $xml .= "<val3>" . $val3 . "</val3>\n";

        $xml .= "<data1>" . $data1 . "</data1>\n";
        $xml .= "<data2>" . $data2 . "</data2>\n";
        $xml .= "<data3>" . $data3 . "</data3>\n";

        $xml .= "<usunome1>" . $usunome1 . "</usunome1>\n";
        $xml .= "<usunome2>" . $usunome2 . "</usunome2>\n";
        $xml .= "<usunome3>" . $usunome3 . "</usunome3>\n";

        $vvala1 = "";
        $vval1 = "";
        $vdata1 = "";
        $vusunome1 = "";

        $vvala2 = "";
        $vval2 = "";
        $vdata2 = "";
        $vusunome2 = "";

        $vvala3 = "";
        $vval3 = "";
        $vdata3 = "";
        $vusunome3 = "";


        $sql2 = "SELECT c.valorant,c.valor,c.data,d.usunome FROM logprecosprod c
		Left Join usuarios as d on d.usucodigo = c.usucodigo
		WHERE c.procodigo = '$codigo' and flag = 2
		
		ORDER BY c.lppcodigo desc";

        $sql2 = pg_query($sql2);
        $row2 = pg_num_rows($sql2);
        if ($row2) {
            for ($i2 = 0; $i2 < $row2; $i2++) {
                if ($i2 == 0) {
                    $vvala1 = pg_fetch_result($sql2, $i2, "valorant");
                    $vval1 = pg_fetch_result($sql2, $i2, "valor");
                    $vdata1 = pg_fetch_result($sql2, $i2, "data");
                    $vusunome1 = pg_fetch_result($sql2, $i2, "usunome");
                }
                if ($i2 == 1) {
                    $vvala2 = pg_fetch_result($sql2, $i2, "valorant");
                    $vval2 = pg_fetch_result($sql2, $i2, "valor");
                    $vdata2 = pg_fetch_result($sql2, $i2, "data");
                    $vusunome2 = pg_fetch_result($sql2, $i2, "usunome");
                }
                if ($i2 == 3) {
                    $vvala3 = pg_fetch_result($sql2, $i2, "valorant");
                    $vval3 = pg_fetch_result($sql2, $i2, "valor");
                    $vdata3 = pg_fetch_result($sql2, $i2, "data");
                    $vusunome3 = pg_fetch_result($sql2, $i2, "usunome");
                }
            }
        }

        if (trim($vvala1) == "") {
            $vvala1 = "0";
        }
        if (trim($vvala2) == "") {
            $vvala2 = "0";
        }
        if (trim($vvala3) == "") {
            $vvala3 = "0";
        }

        if (trim($vval1) == "") {
            $vval1 = "0";
        }
        if (trim($vval2) == "") {
            $vval2 = "0";
        }
        if (trim($vval3) == "") {
            $vval3 = "0";
        }

        if ($vdata1 != "")
            $vdata1 = substr($vdata1, 8, 2) . '/' . substr($vdata1, 5, 2) . '/' . substr($vdata1, 0, 4) . ' ' . substr($vdata1, 10, 9);
        else
            $vdata1 = "0";

        if ($vdata2 != "")
            $vdata2 = substr($vdata2, 8, 2) . '/' . substr($vdata2, 5, 2) . '/' . substr($vdata2, 0, 4) . ' ' . substr($vdata2, 10, 9);
        else
            $vdata2 = "0";

        if ($vdata3 != "")
            $vdata3 = substr($vdata3, 8, 2) . '/' . substr($vdata3, 5, 2) . '/' . substr($vdata3, 0, 4) . ' ' . substr($vdata3, 10, 9);
        else
            $vdata3 = "0";

        if (trim($vusunome1) == "") {
            $vusunome1 = "0";
        }
        if (trim($vusunome2) == "") {
            $vusunome2 = "0";
        }
        if (trim($vusunome3) == "") {
            $vusunome3 = "0";
        }

        $xml .= "<vvala1>" . $vvala1 . "</vvala1>\n";
        $xml .= "<vvala2>" . $vvala2 . "</vvala2>\n";
        $xml .= "<vvala3>" . $vvala3 . "</vvala3>\n";

        $xml .= "<vval1>" . $vval1 . "</vval1>\n";
        $xml .= "<vval2>" . $vval2 . "</vval2>\n";
        $xml .= "<vval3>" . $vval3 . "</vval3>\n";

        $xml .= "<vdata1>" . $vdata1 . "</vdata1>\n";
        $xml .= "<vdata2>" . $vdata2 . "</vdata2>\n";
        $xml .= "<vdata3>" . $vdata3 . "</vdata3>\n";

        $xml .= "<vusunome1>" . $vusunome1 . "</vusunome1>\n";
        $xml .= "<vusunome2>" . $vusunome2 . "</vusunome2>\n";
        $xml .= "<vusunome3>" . $vusunome3 . "</vusunome3>\n";

        $lvala1 = "";
        $lval1 = "";
        $ldata1 = "";
        $lusunome1 = "";

        $lvala2 = "";
        $lval2 = "";
        $ldata2 = "";
        $lusunome2 = "";

        $lvala3 = "";
        $lval3 = "";
        $ldata3 = "";
        $lusunome3 = "";
        

        $sql2 = "SELECT c.valorant,c.valor,c.data,d.usunome FROM logprecosprod c
		Left Join usuarios as d on d.usucodigo = c.usucodigo
		WHERE c.procodigo = '$codigo' and flag = 3
		
		ORDER BY c.lppcodigo desc";

        $sql2 = pg_query($sql2);
        $row2 = pg_num_rows($sql2);
        if ($row2) {
            for ($i2 = 0; $i2 < $row2; $i2++) {
                if ($i2 == 0) {
                    $lvala1 = pg_fetch_result($sql2, $i2, "valorant");
                    $lval1 = pg_fetch_result($sql2, $i2, "valor");
                    $ldata1 = pg_fetch_result($sql2, $i2, "data");
                    $lusunome1 = pg_fetch_result($sql2, $i2, "usunome");
                }
                if ($i2 == 1) {
                    $lvala2 = pg_fetch_result($sql2, $i2, "valorant");
                    $lval2 = pg_fetch_result($sql2, $i2, "valor");
                    $ldata2 = pg_fetch_result($sql2, $i2, "data");
                    $lusunome2 = pg_fetch_result($sql2, $i2, "usunome");
                }
                if ($i2 == 3) {
                    $lvala3 = pg_fetch_result($sql2, $i2, "valorant");
                    $lval3 = pg_fetch_result($sql2, $i2, "valor");
                    $ldata3 = pg_fetch_result($sql2, $i2, "data");
                    $lusunome3 = pg_fetch_result($sql2, $i2, "usunome");
                }
            }
        }

        if (trim($lvala1) == "") {
            $lvala1 = "0";
        }
        if (trim($lvala2) == "") {
            $lvala2 = "0";
        }
        if (trim($lvala3) == "") {
            $lvala3 = "0";
        }

        if (trim($lval1) == "") {
            $lval1 = "0";
        }
        if (trim($lval2) == "") {
            $lval2 = "0";
        }
        if (trim($lval3) == "") {
            $lval3 = "0";
        }

        if ($ldata1 != "")
            $ldata1 = substr($ldata1, 8, 2) . '/' . substr($ldata1, 5, 2) . '/' . substr($ldata1, 0, 4) . ' ' . substr($ldata1, 10, 9);
        else
            $ldata1 = "0";

        if ($ldata2 != "")
            $ldata2 = substr($ldata2, 8, 2) . '/' . substr($ldata2, 5, 2) . '/' . substr($ldata2, 0, 4) . ' ' . substr($ldata2, 10, 9);
        else
            $ldata2 = "0";

        if ($ldata3 != "")
            $ldata3 = substr($ldata3, 8, 2) . '/' . substr($ldata3, 5, 2) . '/' . substr($ldata3, 0, 4) . ' ' . substr($ldata3, 10, 9);
        else
            $ldata3 = "0";

        if (trim($lusunome1) == "") {
            $lusunome1 = "0";
        }
        if (trim($lusunome2) == "") {
            $lusunome2 = "0";
        }
        if (trim($lusunome3) == "") {
            $lusunome3 = "0";
        }

        $xml .= "<lvala1>" . $lvala1 . "</lvala1>\n";
        $xml .= "<lvala2>" . $lvala2 . "</lvala2>\n";
        $xml .= "<lvala3>" . $lvala3 . "</lvala3>\n";

        $xml .= "<lval1>" . $lval1 . "</lval1>\n";
        $xml .= "<lval2>" . $lval2 . "</lval2>\n";
        $xml .= "<lval3>" . $lval3 . "</lval3>\n";

        $xml .= "<ldata1>" . $ldata1 . "</ldata1>\n";
        $xml .= "<ldata2>" . $ldata2 . "</ldata2>\n";
        $xml .= "<ldata3>" . $ldata3 . "</ldata3>\n";

        $xml .= "<lusunome1>" . $lusunome1 . "</lusunome1>\n";
        $xml .= "<lusunome2>" . $lusunome2 . "</lusunome2>\n";
        $xml .= "<lusunome3>" . $lusunome3 . "</lusunome3>\n";


        $gvala1 = "";
        $gval1 = "";
        $gdata1 = "";
        $gusunome1 = "";

        $gvala2 = "";
        $gval2 = "";
        $gdata2 = "";
        $gusunome2 = "";

        $gvala3 = "";
        $gval3 = "";
        $gdata3 = "";
        $gusunome3 = "";




        $sql2 = "SELECT c.valorant,c.valor,c.data,d.usunome FROM logprecosprod c
		Left Join usuarios as d on d.usucodigo = c.usucodigo
		WHERE c.procodigo = '$codigo' and flag = 4
		
		ORDER BY c.lppcodigo desc";

        $sql2 = pg_query($sql2);
        $row2 = pg_num_rows($sql2);
        if ($row2) {
            for ($i2 = 0; $i2 < $row2; $i2++) {
                if ($i2 == 0) {
                    $gvala1 = pg_fetch_result($sql2, $i2, "valorant");
                    $gval1 = pg_fetch_result($sql2, $i2, "valor");
                    $gdata1 = pg_fetch_result($sql2, $i2, "data");
                    $gusunome1 = pg_fetch_result($sql2, $i2, "usunome");
                }
                if ($i2 == 1) {
                    $gvala2 = pg_fetch_result($sql2, $i2, "valorant");
                    $gval2 = pg_fetch_result($sql2, $i2, "valor");
                    $gdata2 = pg_fetch_result($sql2, $i2, "data");
                    $gusunome2 = pg_fetch_result($sql2, $i2, "usunome");
                }
                if ($i2 == 3) {
                    $gvala3 = pg_fetch_result($sql2, $i2, "valorant");
                    $gval3 = pg_fetch_result($sql2, $i2, "valor");
                    $gdata3 = pg_fetch_result($sql2, $i2, "data");
                    $gusunome3 = pg_fetch_result($sql2, $i2, "usunome");
                }
            }
        }

        if (trim($gvala1) == "") {
            $gvala1 = "0";
        }
        if (trim($gvala2) == "") {
            $gvala2 = "0";
        }
        if (trim($gvala3) == "") {
            $gvala3 = "0";
        }

        if (trim($gval1) == "") {
            $gval1 = "0";
        }
        if (trim($gval2) == "") {
            $gval2 = "0";
        }
        if (trim($gval3) == "") {
            $gval3 = "0";
        }

        if ($gdata1 != "")
            $gdata1 = substr($gdata1, 8, 2) . '/' . substr($gdata1, 5, 2) . '/' . substr($gdata1, 0, 4) . ' ' . substr($gdata1, 10, 9);
        else
            $gdata1 = "0";

        if ($gdata2 != "")
            $gdata2 = substr($gdata2, 8, 2) . '/' . substr($gdata2, 5, 2) . '/' . substr($gdata2, 0, 4) . ' ' . substr($gdata2, 10, 9);
        else
            $gdata2 = "0";

        if ($gdata3 != "")
            $gdata3 = substr($gdata3, 8, 2) . '/' . substr($gdata3, 5, 2) . '/' . substr($gdata3, 0, 4) . ' ' . substr($gdata3, 10, 9);
        else
            $gdata3 = "0";

        if (trim($gusunome1) == "") {
            $gusunome1 = "0";
        }
        if (trim($gusunome2) == "") {
            $gusunome2 = "0";
        }
        if (trim($gusunome3) == "") {
            $gusunome3 = "0";
        }

        $xml .= "<gvala1>" . $gvala1 . "</gvala1>\n";
        $xml .= "<gvala2>" . $gvala2 . "</gvala2>\n";
        $xml .= "<gvala3>" . $gvala3 . "</gvala3>\n";

        $xml .= "<gval1>" . $gval1 . "</gval1>\n";
        $xml .= "<gval2>" . $gval2 . "</gval2>\n";
        $xml .= "<gval3>" . $gval3 . "</gval3>\n";

        $xml .= "<gdata1>" . $gdata1 . "</gdata1>\n";
        $xml .= "<gdata2>" . $gdata2 . "</gdata2>\n";
        $xml .= "<gdata3>" . $gdata3 . "</gdata3>\n";

        $xml .= "<gusunome1>" . $gusunome1 . "</gusunome1>\n";
        $xml .= "<gusunome2>" . $gusunome2 . "</gusunome2>\n";
        $xml .= "<gusunome3>" . $gusunome3 . "</gusunome3>\n";






        $xml .= "</dado>\n";
    }//FECHA FOR
    $xml .= "</dados>\n";

    //CABEÇALHO
    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>