<?php

require_once("include/conexao.inc.php");
require_once("include/transportador.php");
require_once("include/funcoes/removeCaracterEspecial.php");

//------------- variáveis -----------------// 
$flag = $_GET["flag"];

//---------- instancia o objeto -----------//
$cadastro = new banco($conn, $db);

//---- Cabeçalho para a geração do xml ----//
header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

if ($flag == "IncluirContato") {
    $nome = $_GET["nome"];
    $email = $_GET["email"];
    $cargo = $_GET["cargo"];

    $nome = trim(removeTodosCaracterEspeciais($nome));
    //$email 		= trim(removeTodosCaracterEspeciais($email));
    $cargo = trim(removeTodosCaracterEspeciais($cargo));

    if ($nome == '') {
        $nome = '_';
    }
    if ($email == '') {
        $email = '_';
    }
    if ($cargo == '') {
        $cargo = '_';
    }

    $xml = "<dados>
	<registro>
		<item>" . $nome . "</item>		
		<item>" . $email . "</item>		
		<item>" . $cargo . "</item>				
	</registro>
	</dados>";
    echo $xml;
    pg_close($conn);
    exit();
}

if ($flag == "AlterarContato") {
    $nome = $_GET["nome"];
    $email = $_GET["email"];
    $cargo = $_GET["cargo"];
    $posicao = $_GET["posicao"];

    $nome = trim(removeTodosCaracterEspeciais($nome));
    //$email 		= trim(removeTodosCaracterEspeciais($email));
    $cargo = trim(removeTodosCaracterEspeciais($cargo));

    if ($nome == '') {
        $nome = '_';
    }
    if ($email == '') {
        $email = '_';
    }
    if ($cargo == '') {
        $cargo = '_';
    }

    $xml = "<dados>
	<registro>
		<item>" . $nome . "</item>		
		<item>" . $email . "</item>		
		<item>" . $cargo . "</item>				
		<item>" . $posicao . "</item>		
	</registro>
	</dados>";
    echo $xml;
    pg_close($conn);
    exit();
}

if ($flag == "PesquisarContato") {
    $tracodigo = $_GET["tracodigo"];

    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    $sql = "Select * from transportadorcontato WHERE tracodigo = '$tracodigo'";
    //EXECUTA A QUERY
    $sql = pg_query($sql);
    $row = pg_num_rows($sql);
    //VERIFICA SE VOLTOU ALGO
    if ($row) {

        //PERCORRE ARRAY
        for ($i = 0; $i < $row; $i++) {

            $nome = pg_fetch_result($sql, $i, "tranome");
            $email = pg_fetch_result($sql, $i, "traemail");
            $cargo = pg_fetch_result($sql, $i, "tracargo");

            if ($cargo == '') {
                $cargo = '_';
            }

            $xml = $xml . "<registro>
					<item>" . $nome . "</item>		
					<item>" . $email . "</item>		
					<item>" . $cargo . "</item>				
					<item>" . $posicao . "</item>		
					</registro>";
        }
    }

    $xml .= "</dados>";

    echo $xml;
    pg_close($conn);
    exit();
}
?>