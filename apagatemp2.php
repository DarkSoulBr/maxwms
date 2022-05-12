<?php

require_once("include/conexao.inc.php");
require_once("include/banco.php");

//RECEBE PARÃMETRO
$parametro = trim($_REQUEST["parametro"]);
$cte = trim($_REQUEST["cte"]);

$cadastro = new banco($conn, $db);

$sql = "Delete FROM infocarga where usucodigo = $parametro";
pg_query($sql);

$sql = "Delete FROM infocoleta where usucodigo = $parametro";
pg_query($sql);

$sql = "Delete FROM infoduplicata where usucodigo = $parametro";
pg_query($sql);

$sql = "Delete FROM infolacre where usucodigo = $parametro";
pg_query($sql);

$sql = "Delete FROM infomotoristas where usucodigo = $parametro";
pg_query($sql);

$sql = "Delete FROM infopedagio where usucodigo = $parametro";
pg_query($sql);

$sql = "Delete FROM infoseguro where usucodigo = $parametro";
pg_query($sql);

$sql = "Delete FROM infoveiculos where usucodigo = $parametro";
pg_query($sql);

$sql = "Delete FROM nfechave where usucodigo = $parametro";
pg_query($sql);

$sql = "Delete FROM obscontribuinte where usucodigo = $parametro";
pg_query($sql);

$sql = "Delete FROM obsfisco where usucodigo = $parametro";
pg_query($sql);

$sql = "Delete FROM valorservico where usucodigo = $parametro";
pg_query($sql);


$sql = "Select * FROM cteinfocarga where ctenumero = $cte";
pg_query($sql);

$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {

    for ($i = 0; $i < $row; $i++) {

        $cteinfnome = pg_fetch_result($sql, $i, "cteinfnome");
        $medcodigo = pg_fetch_result($sql, $i, "medcodigo");
        $cteinfvalor = pg_fetch_result($sql, $i, "cteinfvalor");

        $sql2 = "Insert into infocarga (usucodigo,infnome,medcodigo,infvalor) values ($parametro,'$cteinfnome',$medcodigo,$cteinfvalor)";
        pg_query($sql2);
    }
}



$sql = "Select * FROM cteinfoseguro where ctenumero = $cte";
pg_query($sql);

$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {

    for ($i = 0; $i < $row; $i++) {

        $ctesegnome = pg_fetch_result($sql, $i, "ctesegnome");
        $ctesegapolice = pg_fetch_result($sql, $i, "ctesegapolice");
        $ctesegaverbacao = pg_fetch_result($sql, $i, "ctesegaverbacao");
        $rescodigo = pg_fetch_result($sql, $i, "rescodigo");
        $ctesegvalor = pg_fetch_result($sql, $i, "ctesegvalor");

        $sql2 = "Insert into infoseguro (usucodigo,segnome,segapolice,segaverbacao,rescodigo,segvalor) values ($parametro,'$ctesegnome',$ctesegapolice,'$ctesegaverbacao',$rescodigo,$ctesegvalor)";

        //echo $sql2;

        pg_query($sql2);
    }
}




$sql = "Select * FROM ctenfechave where ctenumero = $cte";
pg_query($sql);

$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {

    for ($i = 0; $i < $row; $i++) {

        $ctenfenome = pg_fetch_result($sql, $i, "ctenfenome");
        $ctenfepin = pg_fetch_result($sql, $i, "ctenfepin");

        $sql2 = "Insert into nfechave (usucodigo,nfenome,nfepin) values ($parametro,'$ctenfenome','$ctenfepin')";

        

        pg_query($sql2);
    }
}





$sql = "Select * FROM cteinfoduplicata where ctenumero = $cte";
pg_query($sql);

$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {

    for ($i = 0; $i < $row; $i++) {

        $ctedupnome = pg_fetch_result($sql, $i, "ctedupnome");
        $ctedupvalor = pg_fetch_result($sql, $i, "ctedupvalor");
        $ctedupvecto = pg_fetch_result($sql, $i, "ctedupvecto");

        $sql2 = "Insert into infoduplicata (usucodigo,dupnome,dupvalor,dupvecto) values ($parametro,'$ctedupnome','$ctedupvalor','$ctedupvecto')";


        pg_query($sql2);
    }
}



$sql = "Select * FROM cteinfocoleta where ctenumero = $cte";
pg_query($sql);

$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {

    for ($i = 0; $i < $row; $i++) {

        $ctecolserie = pg_fetch_result($sql, $i, "ctecolserie");
        $ctecolnumero = pg_fetch_result($sql, $i, "ctecolnumero");
        $ctecolemissao = pg_fetch_result($sql, $i, "ctecolemissao");
        $ctecolcnpj = pg_fetch_result($sql, $i, "ctecolcnpj");
        $ctecolie = pg_fetch_result($sql, $i, "ctecolie");
        $ctecoluf = pg_fetch_result($sql, $i, "ctecoluf");
        $ctecolfone = pg_fetch_result($sql, $i, "ctecolfone");
        $ctecolinterno = pg_fetch_result($sql, $i, "ctecolinterno");

        $sql2 = "Insert into infocoleta (usucodigo,colserie,colnumero,colemissao,colcnpj,colie,coluf,colfone,colinterno) ";
        $sql2 .= "values ($parametro,'$ctecolserie','$ctecolnumero','$ctecolemissao','$ctecolcnpj','$ctecolie','$ctecoluf','$ctecolfone','$ctecolinterno')";


        //echo $sql2;


        pg_query($sql2);
    }
}






$sql = "Select * FROM cteinfolacre where ctenumero = $cte";
pg_query($sql);

$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {

    for ($i = 0; $i < $row; $i++) {

        $ctelacnome = pg_fetch_result($sql, $i, "ctelacnome");

        $sql2 = "Insert into infolacre (usucodigo,lacnome) ";
        $sql2 .= "values ($parametro,'$ctelacnome')";

        pg_query($sql2);
    }
}





$sql = "Select * FROM cteinfopedagio where ctenumero = $cte";
pg_query($sql);

$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {

    for ($i = 0; $i < $row; $i++) {

        $ctepednome = pg_fetch_result($sql, $i, "ctepednome");
        $ctepedforne = pg_fetch_result($sql, $i, "ctepedforne");
        $ctepedrespo = pg_fetch_result($sql, $i, "ctepedrespo");
        $ctepedvalor = pg_fetch_result($sql, $i, "ctepedvalor");

        $sql2 = "Insert into infopedagio (usucodigo,pednome,pedforne,pedrespo,pedvalor) ";
        $sql2 .= "values ($parametro,'$ctepednome','$ctepedforne','$ctepedrespo','$ctepedvalor')";

        pg_query($sql2);
    }
}








$sql = "Select * FROM cteinfoveiculos where ctenumero = $cte";
pg_query($sql);

$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {

    for ($i = 0; $i < $row; $i++) {

        $cteveirenavam = pg_fetch_result($sql, $i, "cteveirenavam");
        $cteveiplaca = pg_fetch_result($sql, $i, "cteveiplaca");
        $cteveitara = pg_fetch_result($sql, $i, "cteveitara");
        $cteveicapacidadekg = pg_fetch_result($sql, $i, "cteveicapacidadekg");
        $cteveicapacidadem3 = pg_fetch_result($sql, $i, "cteveicapacidadem3");
        $cteveitprodado = pg_fetch_result($sql, $i, "cteveitprodado");
        $cteveitpcarroceria = pg_fetch_result($sql, $i, "cteveitpcarroceria");
        $cteveitpveiculo = pg_fetch_result($sql, $i, "cteveitpveiculo");
        $cteveipropveiculo = pg_fetch_result($sql, $i, "cteveipropveiculo");
        $cteveiuf = pg_fetch_result($sql, $i, "cteveiuf");
        $cteveitpdoc = pg_fetch_result($sql, $i, "cteveitpdoc");
        $cteveicpf = pg_fetch_result($sql, $i, "cteveicpf");
        $cteveicnpj = pg_fetch_result($sql, $i, "cteveicnpj");
        $cteveirntrc = pg_fetch_result($sql, $i, "cteveirntrc");
        $cteveiie = pg_fetch_result($sql, $i, "cteveiie");
        $cteveipropuf = pg_fetch_result($sql, $i, "cteveipropuf");
        $cteveitpproprietario = pg_fetch_result($sql, $i, "cteveitpproprietario");
        $cteveirazao = pg_fetch_result($sql, $i, "cteveirazao");
        $cteveipessoa = pg_fetch_result($sql, $i, "cteveipessoa");
        $cteveirg = pg_fetch_result($sql, $i, "cteveirg");
        $cteveicod = pg_fetch_result($sql, $i, "cteveicod");
        $cteveiempresa = pg_fetch_result($sql, $i, "cteveiempresa");


        $sql2 = "Insert into infoveiculos (usucodigo,veirenavam,veiplaca,veitara,veicapacidadekg,veicapacidadem3,veitprodado,veitpcarroceria,veitpveiculo,veipropveiculo,veiuf,veitpdoc,veicpf,veicnpj,veirntrc,veiie,veipropuf,veitpproprietario,veirazao,veipessoa,veirg,veicod,veiempresa)";
        $sql2 .= "values ($parametro,'$cteveirenavam','$cteveiplaca','$cteveitara','$cteveicapacidadekg','$cteveicapacidadem3','$cteveitprodado','$cteveitpcarroceria','$cteveitpveiculo','";
        $sql2 .= "$cteveipropveiculo','$cteveiuf','$cteveitpdoc','$cteveicpf','$cteveicnpj','$cteveirntrc','$cteveiie','$cteveipropuf','$cteveitpproprietario','";
        $sql2 .= "$cteveirazao','$cteveipessoa','$cteveirg','$cteveicod','$cteveiempresa')";
        ;

        pg_query($sql2);
    }
}




$sql = "Select * FROM cteinfomotoristas where ctenumero = $cte";
pg_query($sql);

$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {

    for ($i = 0; $i < $row; $i++) {

        $cteinfmotnome = pg_fetch_result($sql, $i, "cteinfmotnome");
        $cteinfmotcpf = pg_fetch_result($sql, $i, "cteinfmotcpf");


        $sql2 = "Insert into infomotoristas (usucodigo,infmotnome,infmotcpf) ";
        $sql2 .= "values ($parametro,'$cteinfmotnome','$cteinfmotcpf')";

        pg_query($sql2);
    }
}



$sql = "Select * FROM cteobscontribuinte where ctenumero = $cte";
pg_query($sql);

$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {

    for ($i = 0; $i < $row; $i++) {

        $cteconnome = pg_fetch_result($sql, $i, "cteconnome");
        $cteconobs = pg_fetch_result($sql, $i, "cteconobs");


        $sql2 = "Insert into obscontribuinte (usucodigo,connome,conobs) ";
        $sql2 .= "values ($parametro,'$cteconnome','$cteconobs')";

        pg_query($sql2);
    }
}




$sql = "Select * FROM cteobsfisco where ctenumero = $cte";
pg_query($sql);

$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {

    for ($i = 0; $i < $row; $i++) {

        $ctefisnome = pg_fetch_result($sql, $i, "ctefisnome");
        $ctefisobs = pg_fetch_result($sql, $i, "ctefisobs");


        $sql2 = "Insert into obsfisco (usucodigo,fisnome,fisobs) ";
        $sql2 .= "values ($parametro,'$ctefisnome','$ctefisobs')";

        pg_query($sql2);
    }
}




$sql = "Select * FROM ctevalorservico where ctenumero = $cte";
pg_query($sql);

$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {

    for ($i = 0; $i < $row; $i++) {

        $ctevalnome = pg_fetch_result($sql, $i, "ctevalnome");
        $ctevalvalor = pg_fetch_result($sql, $i, "ctevalvalor");


        $sql2 = "Insert into valorservico (usucodigo,valnome,valvalor) ";
        $sql2 .= "values ($parametro,'$ctevalnome','$ctevalvalor')";

        pg_query($sql2);
    }
}



//XML
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
$xml .= "<dados>\n";

$xml .= "<dado>\n";
$xml .= "<descricao>1</descricao>\n";
$xml .= "</dado>\n";

$xml .= "</dados>\n";

//CABEÇALHO
Header("Content-type: application/xml; charset=iso-8859-1");


//PRINTA O RESULTADO
echo $xml;
?>