<?php

//RECEBE PARÃMETRO
$dataini = trim($_GET["dataini"]);
$estoque = trim($_GET["estoque"]);

$dataini = substr($dataini, 6, 4) . '-' . substr($dataini, 3, 2) . '-' . substr($dataini, 0, 2);

require("verifica2.php");

require_once("include/conexao.inc.php");
require_once("include/importaportal.php");

$usucodigo = $_SESSION["id_usuario"];

//$diretorio = getcwd();
$diretorio = "/home/delta";

$ponteiro = opendir($diretorio);

$itens = array();
unset($itens);

while ($nome_itens = readdir($ponteiro)) {
    $itens[] = $nome_itens;
}

sort($itens);

$arquivos = array();
unset($arquivos);

$pastas = array();
unset($pastas);

foreach ($itens as $listar) {
    if ($listar != "." && $listar != "..") {
        if (is_dir($listar)) {
            $pastas[] = $listar;
        } else {
            $arquivos[] = $listar;
        }
    }
}

if ($arquivos != "") {
    foreach ($arquivos as $listar) {
        //if (substr($listar,strlen($listar)-4,4)==".TXT" || substr($listar,strlen($listar)-4,4)==".txt")
        //{
        if (substr($listar, strlen($listar) - 8, 8) == "SHOW.CSV" || substr($listar, strlen($listar) - 8, 8) == "show.csv") {

            $sql = "Update inventario set invatual=0 WHERE estcodigo = '$estoque' and invdata = '$dataini'";
            pg_query($sql);

            //echo $sql;

            print " Arquivo: <a href='$listar'>$listar</a><br>";
            //Comeca a Importacao
            //abro o arquivo para leitura

            $listarx = $diretorio . '/' . $listar;

            if (file_exists($listarx)) {
                $arquivo = fopen($listarx, "r");

                $tot_linhas = 0;

                //abre a primeira vez para descobrir o total de Linhas
                while (!feof($arquivo)) {
                    //se extraio uma linha do arquivo e nao eh false
                    if ($linha = fgets($arquivo)) {
                        $tot_linhas++;
                    }
                }
                fclose($arquivo);

                $arquivo = fopen($listarx, "r");

                $cadastro = new banco($conn, $db);

                //inicio uma variavel para levar a conta das linhas e dos caracteres
                $num_linhas = 0;
                $caracteres = 0;
                $codigo = '';

                $grava = 0;
                $pendente = 0;

                //faco um loop para percorrer o arquivo linha a linha ate o final do arquivo
                while (!feof($arquivo)) {
                    //se extraio uma linha do arquivo e nao eh false
                    if ($linha = fgets($arquivo)) {
                        $num_linhas++;
                        //acumulo o número de caracteres desta linha
                        $caracteres = 0;
                        $caracteres += strlen($linha);

                        $campo = '';
                        $x = 0;
                        $vai = '';

                        if ($num_linhas != 1) {
                            for ($i = 0; $i < $caracteres; $i++) {
                                if (substr($linha, $i, 1) == ';') {
                                    $x++;
                                    if ($x == 1) {
                                        $produto = $vai;
                                    } else if ($x == 2) {
                                        
                                    } else if ($x == 3) {
                                        
                                    } else if ($x == 4) {
                                        
                                    }

                                    $vai = '';
                                } else {
                                    $vai = $vai . substr($linha, $i, 1);
                                    $qtd = $vai;
                                }
                            }//FECHA FOR
                            
                            
                            //$sql = "Select procodigo from produto Where procod = '$produto' and (proinativo is null or proinativo = 0)";
                            $sql = "Select procodigo from produto Where procod = '$produto'";
                            $sql = pg_query($sql);
                            $row = pg_num_rows($sql);
                            if ($row) {

                                echo $produto;
                                echo '  ';
                                echo $qtd;
                                echo '<BR>';

                                $prod = pg_fetch_result($sql, 0, "procodigo");


                                $sql = "Select * from inventario Where procodigo = $prod";
                                $sql = $sql . " and estcodigo = $estoque ";
                                $sql = $sql . " and invdata = '$dataini' ";

                                $sql = pg_query($sql);
                                $row = pg_num_rows($sql);
                                if ($row) {

                                    $sql = "Update inventario set invatual=$qtd ";
                                    $sql = $sql . " Where procodigo = $prod";
                                    $sql = $sql . " and estcodigo = $estoque ";
                                    $sql = $sql . " and invdata = '$dataini' ";
                                    //echo $sql;
                                    //echo '<br>';
                                    pg_query($sql);
                                } else {

                                    $sql = "Insert into inventario (procodigo,";
                                    $sql = $sql . "estcodigo,";
                                    $sql = $sql . "invdata,invatual,invantigo) Values (";
                                    $sql = $sql . "$prod,";
                                    $sql = $sql . "'$estoque',";
                                    $sql = $sql . "'$dataini',$qtd,0)";
                                    //echo $sql;
                                    //echo '<br>';
                                    pg_query($sql);
                                }
                            }
                        }
                    }
                }
                fclose($arquivo);

                $listar1 = $listarx;
                $listar2 = $diretorio . '/' . substr($listar, 0, strlen($listar) - 4) . ".imp";

                //Se ja existir um .imp apaga
                if (file_exists($listar2)) {
                    unlink($listar2);
                }
                rename($listar1, $listar2);
            }
            echo "<meta HTTP-EQUIV='Refresh' CONTENT='5;URL=importainvent.php'>";
            exit;
        }
    }
}
//} // Fecha o While que será infinito
echo "<meta HTTP-EQUIV='Refresh' CONTENT='5;URL=importainvent.php'>";
exit;
?>