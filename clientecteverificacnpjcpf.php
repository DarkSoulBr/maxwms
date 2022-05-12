<?php

require_once("include/conexao.inc.php");
require_once("include/banco.php");

//RECEBE PARÃMETRO
$clicodigo = trim($_POST["parametro"]);
$pessoa = trim($_POST["parametro2"]);
$cnpj = trim($_POST["parametro3"]);
$cpf = trim($_POST["parametro4"]);

//Criar uma segunda variavel so com os numeros pois existem registros antigos que estao cadastrados dessa forma
//Tira os pontos do ie
$caracteres = 0;
$caracteres += strlen($cnpj);
$vai = '';
$i = 0;
for ($i = 0; $i < $caracteres; $i++) {
    if (is_numeric(substr($cnpj, $i, 1))) {
        $vai = $vai . substr($cnpj, $i, 1);
    }
}
$cnpj2 = $vai;

$codigo = '0';
$descricao = '0';

if ($cnpj == '' && $cpf == '') {
    
} else {

    $cadastro = new banco($conn, $db);
    if ($clicodigo == 0) {
        if ($pessoa == 1) {
            $sql = "
			SELECT * FROM clientescte 
			WHERE (clicnpj = '$cnpj' or clicnpj = '$cnpj2')";
        } else {
            $sql = "
			SELECT * FROM  clientescte 
			WHERE clicpf = '$cpf'";
        }
    } else {
        if ($pessoa == 1) {
            $sql = "
			SELECT * FROM  clientescte 
			WHERE (clicnpj = '$cnpj' or clicnpj = '$cnpj2')
			AND clicodigo <> $clicodigo";
        } else {
            $sql = "
			SELECT * FROM  clientescte 
			WHERE clicpf = '$cpf'
			AND clicodigo <> $clicodigo";
        }
    }

    //EXECUTA A QUERY
    $sql = pg_query($sql);
    $row = pg_num_rows($sql);

    //VERIFICA SE VOLTOU ALGO
    if ($row) {
        $codigo = pg_fetch_result($sql, 0, "clicod");
        $descricao = pg_fetch_result($sql, 0, "clinguerra");
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