<?php

require_once("include/conexao.inc.php");
require_once("include/aberturainventario.php");

$cadastro = new banco($conn, $db);

$invdata = trim($_GET["invdata"]);
$contagem = trim($_GET["contagem"]);
$coletor = trim($_GET["coletor"]);
$setor = trim($_GET["setor"]);

$aux = explode("/", $invdata);
$invdata = $aux[2] . '-' . $aux[1] . '-' . $aux[0] . ' 00:00:00-03';

$arquivo = fopen("/home/delta/contagem.csv", "r");

$cadastro = new banco($conn, $db);

//inicio uma variavel para levar a conta das linhas e dos caracteres
$num_linhas = 0;
$caracteres = 0;
$codigo = '';
$quantidade = '';

//faco um loop para percorrer o arquivo linha a linha ate o final do arquivo
while (!feof($arquivo)) {

    //se extraio uma linha do arquivo e nao eh false
    if ($linha = fgets($arquivo)) {
        //acumulo uma na variavel número de linhas
        $num_linhas++;

        //if($num_linhas>1 && $num_linhas<5){
        if ($num_linhas > 1) {
            //acumulo o número de caracteres desta linha
            $caracteres = 0;
            $caracteres += strlen($linha);

            $campo = '';
            $x = 0;
            $vai = '';

            $codigo = $vai;
            $quantidade = $vai;

            for ($i = 0; $i < $caracteres; $i++) {

                if (substr($linha, $i, 1) == ';') {
                    $x++;
                    if ($x == 1) {
                        $codigo = $vai;
                    } else if ($x == 2) {
                        
                    } else if ($x == 3) {
                        
                    } else if ($x == 4) {
                        $quantidade = $vai;
                    } else if ($x == 5) {
                        
                    }
                    $vai = '';
                } else {
                    $vai = $vai . substr($linha, $i, 1);
                }
            }//FECHA FOR

            if ($codigo != '' && $quantidade != '') {


                //Localiza o Codigo do Produto
                $sql3 = "Select procodigo FROM produto where produto.procod = '$codigo'";
                $cad3 = pg_query($sql3);
                $procodigo = 0;
                if (pg_num_rows($cad3)) {
                    $procodigo = pg_fetch_result($cad3, 0, "procodigo");
                }

                if ($procodigo > 0) {
                    echo $codigo . ' ' . $procodigo . ' ' . $quantidade . '<br>';

                    //Verifica se vai incluir ou alterar
                    $sql3 = "Select * FROM inventariocontagemsetorproduto Where invdata = '" . $invdata . "' and concodigo = $contagem and setcodigo = $setor and procodigo = $procodigo and colcodigo = $coletor";
                    $cad3 = pg_query($sql3);
                    if (pg_num_rows($cad3)) {
                        $sql = "UPDATE inventariocontagemsetorproduto SET quantidade=$quantidade Where invdata = '" . $invdata . "' and concodigo = $contagem and setcodigo = $setor and procodigo = $procodigo and colcodigo = $coletor";
                        pg_query($sql);
                    } else {
                        $cadastro->insere("inventariocontagemsetorproduto", "(procodigo,invdata,concodigo,setcodigo,quantidade,colcodigo)", "('$procodigo','$invdata','$contagem','$setor','$quantidade','$coletor')");
                    }
                }
            }
        }
    }
}


fclose($arquivo);

echo 'Fim de Processamento' . '<br>';

function delimitador($variavel, $tamanho, $alinhamento, $preenchimento) {
    if ($tamanho < 10 && $alinhamento == 'R' && $preenchimento == '0')
        $strtam = "%0" . $tamanho . "s";
    else if ($tamanho < 10 && $alinhamento == 'L' && $preenchimento == '0')
        $strtam = "%-0" . $tamanho . "s";
    else if ($tamanho < 10 && $alinhamento == 'R' && $preenchimento == ' ')
        $strtam = "%" . $tamanho . "s";
    else if ($tamanho < 10 && $alinhamento == 'L' && $preenchimento == ' ')
        $strtam = "%-" . $tamanho . "s";

    if ($tamanho >= 10 && $alinhamento == 'R' && $preenchimento == '0')
        $strtam = "%0" . $tamanho . "s";
    else if ($tamanho >= 10 && $alinhamento == 'L' && $preenchimento == '0')
        $strtam = "%-0" . $tamanho . "s";
    else if ($tamanho >= 10 && $alinhamento == 'R' && $preenchimento == ' ')
        $strtam = "%" . $tamanho . "s";
    else if ($tamanho >= 10 && $alinhamento == 'L' && $preenchimento == ' ')
        $strtam = "%-" . $tamanho . "s";

    $var = substr(sprintf($strtam, $variavel), 0, $tamanho);
    return $var;
}

pg_close($conn);
exit();
?>