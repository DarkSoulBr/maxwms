<?php

require_once("include/conexao.inc.php");
require_once("include/romaneios.php");

//RECEBE PARÃMETRO

$parametro = trim($_POST["parametro"]);


$cadastro = new banco($conn, $db);

//
//QUERY
$sql = "
       SELECT a.pvnumero,a.pvnumero,b.pvfvolume,c.clicodigo,c.clirazao 
       ,a.pvtipoped,(select d.notvolumes from notagua d where d.pvnumero = '$parametro' limit 1) as vol
       ,lpad(cast(extract(day from a.pvemissao) as varchar),2,'0')||'/'||
       lpad(cast(extract(month from a.pvemissao) as varchar),2,'0')||'/'||
       EXTRACT(YEAR FROM a.pvemissao) as emissao
	   
	   ,a.pvvalor
	   
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
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao>" . $descricao . "</descricao>\n";
        $xml .= "<descricao2>" . $descricao2 . "</descricao2>\n";
        $xml .= "<descricao3>" . $descricao3 . "</descricao3>\n";
        $xml .= "<descricao4>" . $descricao4 . "</descricao4>\n";
        $xml .= "<descricao5>" . $descricao5 . "</descricao5>\n";
        $xml .= "<descricao6>" . $descricao6 . "</descricao6>\n";
        $xml .= "<descricao7>" . $descricao7 . "</descricao7>\n";






        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $xml .= "<descricao8>" . $descricao8 . "</descricao8>\n";

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
        $xml .= "<expedido>" . $expedido . "</expedido>\n";


        $xml .= "</dado>\n";
    }//FECHA FOR

    $xml .= "</dados>\n";

    //CABEÇALHO

    Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>
