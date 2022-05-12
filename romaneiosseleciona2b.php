<?php

require_once("include/conexao.inc.php");
require_once("include/romaneios.php");

$cadastro = new banco($conn, $db);
$pesquisa = $_GET["pesquisa"];

$pesquisa = "      " . $pesquisa;

$pesquisa1 = trim(substr($pesquisa, -12, 7));
$pesquisa2 = substr($pesquisa, -4, 4);

//$data=$cadastro->seleciona2("$pesquisa1","$pesquisa2");



$sql = "SELECT a.rompedcodigo,
	a.pvnumero,
	c.clirazao,
	a.rpvolumes,
	lpad(cast(extract(day from b.pvemissao) as varchar),2,'0')||'/'|| lpad(cast(extract(month from b.pvemissao) as varchar),2,'0')||'/'|| EXTRACT(YEAR FROM b.pvemissao) as emissao,a.romcodigo,c.clicodigo

	,b.pvvalor
	,b.pvtipoped

	FROM romaneiospedidos a,romaneios d, pvenda b
	LEft Join clientes as c on c.clicodigo = b.clicodigo
	WHERE d.romnumero = '$pesquisa1'
	AND d.romano = '$pesquisa2'
	AND a.pvnumero = b.pvnumero
	AND d.romcodigo = a.romcodigo
	order by a.pvnumero";


$data = pg_query($sql);




//se encontrar registros
if (pg_num_rows($data)) {
    header("Content-type: application/xml");

    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

    //preenchimento da Array com o nome dos campos
    for ($i = 0; $i < pg_num_fields($data); $i++) {
        $campos[$i] = pg_field_name($data, $i);
    }

    $xml .= "<dados>";
    $xml .= "<cabecalho>";

    //cabecalho da tabela
    for ($i = 0; $i < sizeof($campos); $i++) {
        $xml .= "<campo>" . $campos[$i] . "</campo>";
    }

    $xml .= "</cabecalho>";

    $row = pg_num_rows($data);
    for ($i = 0; $i < $row; $i++) {

        $rompedcodigo = pg_fetch_result($data, $i, "rompedcodigo");
        $pvnumero = pg_fetch_result($data, $i, "pvnumero");
        $clirazao = pg_fetch_result($data, $i, "clirazao");
        $rpvolumes = pg_fetch_result($data, $i, "rpvolumes");
        $emissao = pg_fetch_result($data, $i, "emissao");
        $romcodigo = pg_fetch_result($data, $i, "romcodigo");
        $clicodigo = pg_fetch_result($data, $i, "clicodigo");
        $pvvalor = pg_fetch_result($data, $i, "pvvalor");
        $pvtipoped = pg_fetch_result($data, $i, "pvtipoped");


        if (trim($rompedcodigo) == "") {
            $rompedcodigo = "0";
        }
        if (trim($pvnumero) == "") {
            $pvnumero = "0";
        }
        if (trim($clirazao) == "") {
            $clirazao = "0";
        }
        if (trim($rpvolumes) == "") {
            $rpvolumes = "0";
        }
        if (trim($emissao) == "") {
            $emissao = "0";
        }
        if (trim($clicodigo) == "") {
            $clicodigo = "0";
        }
        if (trim($pvvalor) == "") {
            $pvvalor = "0";
        }
        if (trim($pvtipoped) == "") {
            $pvtipoped = "0";
        }


        $xml .= "<registro>";
        $xml .= "<item>" . $rompedcodigo . "</item>";
        $xml .= "<item>" . $pvnumero . "</item>";
        $xml .= "<item>" . $clirazao . "</item>";
        $xml .= "<item>" . $rpvolumes . "</item>";
        $xml .= "<item>" . $emissao . "</item>";
        $xml .= "<item>" . $romcodigo . "</item>";
        $xml .= "<item>" . $clicodigo . "</item>";





        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if ($pvtipoped != 'S') {
            //Faz um novo Select para as Notas do Deposito   
            $pegar2 = "Select a.notnumero as notnumero,a.quantidade as notvolumes,a.notvalor as notvalor,a.tracodigo as tracodigo,b.tranguerra as tranguerra, b.traendereco as traendereco 
					FROM notadep a,transportador b
					WHERE a.pvnumero = $pvnumero
					AND a.tracodigo = b.tracodigo					
					UNION Select c.notnumero as notnumero,c.quantidade as notvolumes,c.notvalor as notvalor,c.tracodigo as tracodigo,d.tranguerra as tranguerra, d.traendereco as traendereco	
					FROM notagua c,transportador d
					WHERE c.pvnumero = $pvnumero
					AND c.tracodigo = d.tracodigo					
					order by notnumero";
        } else {
            //Faz um novo Select para as Notas do Deposito   
            $pegar2 = "Select c.notnumero as notnumero,c.quantidade as notvolumes,c.notvalor as notvalor,c.tracodigo as tracodigo,d.tranguerra as tranguerra, d.traendereco as traendereco,g.clicod,g.clirazao,e.cleendereco,e.clenumero 
					FROM transportador d,nguatransf y,notagua c 
					left join clientes as g on c.clicodigo= g.clicodigo
					left join cliefat as e on c.clicodigo= e.clicodigo				
					WHERE c.notnumero = y.notnumero
					and y.pvnumero = $pvnumero
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
            $pvvalor = $ntvalnot;
        }

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





        $xml .= "<item>" . $pvvalor . "</item>";
        $xml .= "</registro>";
    }



    //fim da tabela
    $xml .= "</dados>";
}

echo $xml;
pg_close($conn);
exit();
?>