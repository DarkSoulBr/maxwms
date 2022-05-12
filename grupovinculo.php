<?php

require_once("include/conexao.inc.php");
require_once("include/clientesvinculados.php");

$cadastro = new banco($conn, $db);
$pesquisa = $_GET["pesquisa"];

$sql = "SELECT c.clvnome FROM clientes a 
inner join vinccli b on a.clicodigo = b.clicodigo 
inner join clivinc c on b.vlccodigo = c.clvcodigo
where a.clicodigo = '$pesquisa'
order by a.clirazao";

$cad = pg_query($sql);

//$pesquisa2 = 0;
//if($cad) {
//    $pesquisa2 = pg_fetch_result($cad, 0, "vlccodigo");
//}	

$data = $cad;

//se encontrar registros
if (pg_num_rows($data)) {
    header("Content-type: application/xml");

    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

    //preenchimento da Array com o nome dos campos
    for ($i = 0; $i < pg_num_fields($data); $i++) {
        $campos[$i] = pg_field_name($data, $i);
    }

    $xml .= "<dadosgrupovinculado>";
    $xml .= "<cabecalho>";

    //cabecalho da tabela
    for ($i = 0; $i < sizeof($campos); $i++) {
        $xml .= "<campogrupovinculado>" . $campos[$i] . "</campogrupovinculado>";
    }

    $xml .= "</cabecalho>";

    //corpo da tabela
    while ($row = pg_fetch_object($data)) {
        $xml .= "<registrogrupovinculado>";
        for ($i = 0; $i < sizeof($campos); $i++) {

            if (trim($row->{$campos[$i]}) == "") {
                $xml .= "<itemgrupovinculado>" . "_" . "</itemgrupovinculado>";
            } else {
                $xml .= "<itemgrupovinculado>" . $row->{$campos[$i]} . "</itemgrupovinculado>";
            }
        }
        $xml .= "</registrogrupovinculado>";
    }

    //fim da tabela
    $xml .= "</dadosgrupovinculado>";
}

echo $xml;
pg_close($conn);
exit();
//
//
//
////RECEBE PARÂMETRO
//
//$pesquisa=$_GET["pesquisa"];
//
//require_once("include/conexao.inc.php");
//
////QUERY
//
//		$sql = "SELECT c.clvnome, a.clicod, a.clirazao FROM clientes a 
//inner join vinccli b on a.clicodigo = b.clicodigo 
//inner join clivinc c on b.vlccodigo = c.clvcodigo
//where a.clicod = '$pesquisa'
//order by a.clirazao;"
//	
//	
//		
//	//EXECUTA A QUERY
//	
//	$row = pg_num_rows($sql);
//
//	//VERIFICA SE VOLTOU ALGO
//	if($row)
//	{
//		//XML
//		$xml  = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"\n";
//		$xml .= "<dadosib>\n";
//
//		//PERCORRE ARRAY
//		for($i=0; $i<$row; $i++)
//		{
//			$codestado	 = pg_fetch_result($sql, $i, "codestado");
//			$codcidade	 = pg_fetch_result($sql, $i, "codcidade");
//			$cidadeibge	 = pg_fetch_result($sql, $i, "cidadeibge");
//
//			$aux = $codestado . $codcidade;
//
//			$xml	.= "<dadoib>\n";
//			$xml	.= "<codigoib>".$aux."</codigoib>\n";
//			$xml	.= "<cidadeib>".$cidadeibge."</cidadeib>\n";
//			$xml 	.= "</dadoib>\n";
//
//		}//FECHA FOR
//		$xml		.= "</dadosib>\n";
//
//		//CABEÇALHO
//		Header("Content-type: application/xml; charset=iso-8859-1");
//	}//FECHA IF (row)
//
//	//PRINTA O RESULTADO
//	echo $xml;
//}
?>