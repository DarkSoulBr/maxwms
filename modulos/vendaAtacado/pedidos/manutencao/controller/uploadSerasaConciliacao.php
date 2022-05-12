<?php

set_time_limit(0);

//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
if (!$root)
    $root = $arr[1];

//pega as configura??es do servidor	
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");
require_once(DIR_ROOT . '/include/classes/JSON/JSON.php');
require_once(DIR_ROOT . '/include/conexao.inc.php');




$uploaddir = DIR_UPLOADS . '/tmp/';

$data = getdate();
$num = md5($data[0]);
//	$name = substr($num,0,8).".xls";
$name = substr($num, 0, 8) . ".txt";

$file = $uploaddir . basename($name);

$retorno = new stdClass();

$json = new Services_JSON();

$str = '';

$nome = $HTTP_POST_FILES['uploadfile']['name'];


if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) {

    $arquivo = "/home/delta/serasa/" . $nome;
    if (file_exists($arquivo)) {
        unlink($arquivo);
    }

    $arquivo = fopen("$arquivo", "x+");

    $str = file_get_contents($file);

    $final = '';

    $origem = fopen($file, "r");
    //Fica em Loopin para ler o arquivo por completo
    while (!feof($origem)) {

        //se extraio uma linha do arquivo e nao eh false
        if ($linha = fgets($origem)) {

            if (substr($linha, 0, 2) == '00') {
                $final = substr($linha, 44, 8);
            }

            if (substr($linha, 0, 2) == '01') {

                //Código Interno do título de Cobranca
                $aux = (int) trim(substr($linha, 18, 10));

                //Localiza a Baixa
                $sql = "SELECT cobrecebto From cobranca WHERE cobcodigo = $aux";

                $sql = pg_query($sql);
                $row = pg_num_rows($sql);
                if ($row) {
                    $baixa = trim(pg_result($sql, "0", "cobrecebto"));
                    if ($baixa == '') {
                        $baixa = '        ';
                    } else {
                        $baixa = substr($baixa, 0, 4) . substr($baixa, 5, 2) . substr($baixa, 8, 2);

                        //Verifica se a data da baixa é menor que a emissao
                        $emissao = substr($linha, 28, 8);
                        if ($baixa < $emissao) {
                            $baixa = $emissao;
                        }

                        //Se a data da Baixa for maior que a data final deixa em branco
                        if ($final != '') {
                            if ($baixa > $final) {
                                $baixa = '        ';
                            }
                        }
                    }
                } else {
                    $baixa = '        ';
                }

                $linhax = substr($linha, 0, 57) . $baixa . substr($linha, 65, 65);
            } else {
                $linhax = substr($linha, 0, 130);
            }
            fputs($arquivo, "$linhax\r\n");
        }
    }
    fclose($origem);
    fclose($arquivo);

    /*
      $data = date ( "Ymd");
      $str = file_get_contents($file);


      $first = strpos($str, '99999999                                   ');
      $total = strlen($str) - 1;
      $stop = $first - $total;
      //$str = substr_replace($str, '                                           ', $first, $stop);
      $str = substr_replace($str, $data .'                                   ', $first, $stop);

      $middle = round(($total)/2);
      $half = strpos($str, '99999999                                   ',$middle);
      $stop = $half - $total;
      $str = substr_replace($str, $data .'                                   ', $half, $stop);

      $last = strrpos($str, '99999999                                   ');
      $stop = $last - $total;
      $str = substr_replace($str, $data .'                                   ', $last, $stop);

      $str = preg_replace('/                                   9999999                                   /', '                                   ', $str);
      $str = preg_replace('/99999999                                   000000000000000/', '                                           000000000000000', $str);
     */
}


if ($str !== "") {


    /*
      $arquivo = "/home/delta/serasa/".$nome;
      //$nome = "remessa.txt";
      if (file_exists($arquivo)) {
      unlink($arquivo);

      }

      @$newFile = fopen( $arquivo ,'w+');
      @fwrite($newFile,$str);
      @fclose($newFile);
     */





    $retorno->checagem = true;
    //$retorno->mensagem = $nome;
    $retorno->mensagem = "IMPORTACAO DO ARQUIVO CONCILIA REALIZADA.";
} else {
    $retorno->checagem = false;
    $retorno->mensagem = "FALHA NA IMPORTACAO DO ARQUIVO CONCILIA.";
}



unlink($file);

print $json->encode($retorno);
?>