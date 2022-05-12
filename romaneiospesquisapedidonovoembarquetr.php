<?php

require_once("include/conexao.inc.php");
require_once("include/romaneios.php");

//RECEBE PARÃMETRO


$parametro = trim($_GET["parametro"]);
$parametro2 = trim($_GET["parametro2"]);
$parametro3 = trim($_GET["parametro3"]);

//Se for uma pesquisa por Embarque localiza o Numero do Pedido
if ($parametro2 == 2) {
    $sql = "SELECT pvnumero FROM pvenda WHERE pvembarque = '$parametro'";
    $sql = pg_query($sql);
    $row = pg_num_rows($sql);
    if ($row) {
        $parametro = pg_fetch_result($sql, 0, "pvnumero");
    } else {
        $parametro = 0;
    }
}


$cadastro = new banco($conn, $db);

if ($parametro == '') {
    $parametro = '0';
}

//
//QUERY
$sql = "
       SELECT a.pvnumero,a.pvnumero,b.pvfvolume,b.pvfdatahora,c.clicodigo,c.clirazao 
       ,a.pvtipoped,(select d.notvolumes from notagua d where d.pvnumero = '$parametro' limit 1) as vol
       ,lpad(cast(extract(day from a.pvemissao) as varchar),2,'0')||'/'||
       lpad(cast(extract(month from a.pvemissao) as varchar),2,'0')||'/'||
       EXTRACT(YEAR FROM a.pvemissao) as emissao,a.pvvalor,a.tracodigo,a.pvbloqueio,a.pvbloqueiomsg  	   
        FROM  pvenda a
        left join pvendafinalizado as b on a.pvnumero = b.pvnumero
	left join clientes as c on a.clicodigo= c.clicodigo
	WHERE a.pvnumero = '$parametro'

	ORDER BY a.pvnumero";

//EXECUTA A QUERY

$sql = pg_query($sql);


$row = pg_num_rows($sql);




//VERIFICA SE VOLTOU ALGO
if ($row) {

    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {
        $codigo = pg_fetch_result($sql, $i, "pvnumero");
        $descricao = pg_fetch_result($sql, $i, "pvnumero");
        $descricao2 = pg_fetch_result($sql, $i, "pvfvolume");

        $pvfdatahora = trim(pg_fetch_result($sql, $i, "pvfdatahora"));

        //Sempre 1 Volume
        $descricao2 = 1;

        $descricao3 = pg_fetch_result($sql, $i, "clicodigo");
        $descricao4 = pg_fetch_result($sql, $i, "clirazao");

        $descricao5 = pg_fetch_result($sql, $i, "pvtipoped");
        $descricao6 = pg_fetch_result($sql, $i, "vol");

        //Sempre 1 Volume
        $descricao6 = 1;

        $descricao7 = pg_fetch_result($sql, $i, "emissao");

        $descricao8 = pg_fetch_result($sql, $i, "pvvalor");

        $tracodigo = pg_fetch_result($sql, $i, "tracodigo");

        $pvbloqueio = (int) pg_fetch_result($sql, $i, "pvbloqueio");
        $motivo = pg_fetch_result($sql, $i, "pvbloqueiomsg");

        if ($tracodigo == $parametro3 || $descricao5 == 'S') {
            $erro = '_';
        } else {
            $pegar2 = "SELECT tranguerra FROM transportador WHERE tracodigo = {$tracodigo}";
            $cad2 = pg_query($pegar2);
            $row2 = pg_num_rows($cad2);
            if ($row2) {
                $erro = pg_fetch_result($cad2, 0, "tranguerra");
            } else {
                $erro = $tracodigo;
            }
        }

        if (trim($codigo) == "") {
            $codigo = "0";
        }
        if (trim($descricao) == "") {
            $descricao = "0";
        }
        if (trim($descricao2) == "") {
            $descricao2 = "0";
        }
        if (trim($descricao3) == "") {
            $descricao3 = "0";
        }
        if (trim($descricao4) == "") {
            $descricao4 = "PEDIDO ABASTECIMENTO";
        }

        if (trim($descricao5) == "") {
            $descricao5 = "0";
        }
        if (trim($descricao6) == "") {
            $descricao6 = "0";
        }
        if (trim($descricao7) == "") {
            $descricao7 = "0";
        }

        if (trim($descricao8) == "") {
            $descricao8 = "0";
        }

        //Se estiver zerado vai passar a sugerir como 1
        if (trim($descricao6) == "0") {
            $descricao6 = "1";
        }

        $xml .= "<dado>\n";
        $xml .= "<item>" . $codigo . "</item>\n";
        $xml .= "<item>" . $descricao . "</item>\n";
        $xml .= "<item>" . $descricao2 . "</item>\n";
        $xml .= "<item>" . $descricao3 . "</item>\n";
        $xml .= "<item>" . $descricao4 . "</item>\n";
        $xml .= "<item>" . $descricao5 . "</item>\n";
        $xml .= "<item>" . $descricao6 . "</item>\n";
        $xml .= "<item>" . $descricao7 . "</item>\n";


        if ($descricao5 != 'S') {
            //Faz um novo Select para as Notas do Deposito   
            $pegar2 = "Select a.notnumero as notnumero,a.quantidade as notvolumes,a.notvalor as notvalor,a.tracodigo as tracodigo,b.tranguerra as tranguerra, b.traendereco as traendereco 
					FROM notadep a,transportador b
					WHERE a.pvnumero = $parametro
					AND a.tracodigo = b.tracodigo					
					UNION Select c.notnumero as notnumero,c.quantidade as notvolumes,c.notvalor as notvalor,c.tracodigo as tracodigo,d.tranguerra as tranguerra, d.traendereco as traendereco	
					FROM notagua c,transportador d					
					WHERE c.pvnumero = $parametro
					AND c.tipo is null 
					AND c.tracodigo = d.tracodigo					
					order by notnumero";
        } else {
            //Faz um novo Select para as Notas do Deposito   
            $pegar2 = "Select c.notnumero as notnumero,c.quantidade as notvolumes,c.notvalor as notvalor,c.tracodigo as tracodigo,d.tranguerra as tranguerra, d.traendereco as traendereco,g.clicod,g.clirazao,e.cleendereco,e.clenumero 
					FROM transportador d,nguatransf y,notagua c 
					left join clientes as g on c.clicodigo= g.clicodigo
					left join cliefat as e on c.clicodigo= e.clicodigo				
					WHERE c.notnumero = y.notnumero
					and y.pvnumero = $parametro
					AND c.tracodigo = d.tracodigo					
					order by notnumero";
        }

        $cad2 = pg_query($pegar2);
        $row2 = pg_num_rows($cad2);

        $ntvalnot = 0;
        if ($row2) {
            $ntvalnot = pg_fetch_result($cad2, 0, "notvalor");
        }

        if ($ntvalnot > 0) {
            $descricao8 = $ntvalnot;
        }

        $xml .= "<item>" . $descricao8 . "</item>\n";

        /* Verifica se foi expedido pelo Coletor */
        $pegar2 = "SELECT pvexpedicao FROM coletorexpede 
					WHERE pvnumero = $parametro 
					AND pvexpedicao IS NOT NULL";
        $cad2 = pg_query($pegar2);
        $row2 = pg_num_rows($cad2);
        $expedido = 0;
        if ($row2) {
            $expedido = 1;
        }
        $xml .= "<item>" . $expedido . "</item>\n";
        $xml .= "<item>" . $erro . "</item>\n";

        //1 - Conferido | 2 - Não Conferido
        if ($pvfdatahora) {
            $xml .= "<item>1</item>\n";
        } else {
            $xml .= "<item>0</item>\n";
        }

        if ($pvbloqueio == 1) {
            $xml .= "<item>PEDIDO BLOQUEADO SAC! MOTIVO: " . trim($motivo) . "</item>\n";
        } else {
            $xml .= "<item>_</item>\n";
        }

        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO

    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
else {

    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    $codigo = "0";
    $descricao = "0";
    $descricao2 = "0";
    $descricao3 = "0";
    $descricao4 = "0";
    $descricao5 = "0";
    $descricao6 = "0";
    $descricao7 = "0";
    $descricao8 = "0";
    $expedido = 0;

    $erro = '_';

    $xml .= "<dado>\n";
    $xml .= "<item>" . $codigo . "</item>\n";
    $xml .= "<item>" . $descricao . "</item>\n";
    $xml .= "<item>" . $descricao2 . "</item>\n";
    $xml .= "<item>" . $descricao3 . "</item>\n";
    $xml .= "<item>" . $descricao4 . "</item>\n";
    $xml .= "<item>" . $descricao5 . "</item>\n";
    $xml .= "<item>" . $descricao6 . "</item>\n";
    $xml .= "<item>" . $descricao7 . "</item>\n";
    $xml .= "<item>" . $descricao8 . "</item>\n";
    $xml .= "<item>" . $expedido . "</item>\n";
    $xml .= "<item>" . $erro . "</item>\n";
    $xml .= "<item>0</item>\n";
    $xml .= "<item>_</item>\n";

    $xml .= "</dado>\n";

    $xml .= "</dados>\n";

    //CABEÇALHO

    Header("Content-type: application/xml; charset=iso-8859-1");
}

//PRINTA O RESULTADO
echo $xml;
?>
