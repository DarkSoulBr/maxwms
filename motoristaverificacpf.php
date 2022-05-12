<?php

require_once("include/conexao.inc.php");
require_once("include/banco.php");

//RECEBE PARÃMETRO
$clicodigo = trim($_POST["parametro"]);
$cpf = trim($_POST["parametro2"]);

//Criar uma segunda variavel so com os numeros pois existem registros antigos que estao cadastrados dessa forma
$codigo = '0';
$descricao = '0';

if ($cpf == '') {
    
} else {

    $cadastro = new banco($conn, $db);
    if ($clicodigo == 0) {

        $sql = "
			SELECT * FROM  motoristas 
			WHERE motcpf = '$cpf'";
    } else {

        $sql = "
			SELECT * FROM  motoristas
			WHERE motcpf = '$cpf'
			AND motcodigo <> $clicodigo";
    }

    //EXECUTA A QUERY
    $sql = pg_query($sql);
    $row = pg_num_rows($sql);

    //VERIFICA SE VOLTOU ALGO
    if ($row) {
        $codigo = pg_fetch_result($sql, 0, "motcod");
        $descricao = pg_fetch_result($sql, 0, "motrazao");
    }


    if ($codigo == '') {
        $codigo = '0';
    }
    if ($descricao == '') {
        $descricao = '0';
    }
}

//XML
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
$xml .= "<dados>\n";
$xml .= "<dado>\n";
$xml .= "<codigo>" . $codigo . "</codigo>\n";
$xml .= "<descricao>" . $descricao . "</descricao>\n";
$xml .= "</dado>\n";
$xml .= "</dados>\n";

//CABEÇALHO
Header("Content-type: application/xml; charset=iso-8859-1");


//PRINTA O RESULTADO
echo $xml;
?>