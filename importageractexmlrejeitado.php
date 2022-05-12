<?php

header('Content-Type: text/html; charset=iso-8859-1');

set_time_limit(0);

echo "<body style='background-color:#ccccb3'>";
echo "<h3>01/04 - Importação de CT-e Rejeitado (Alfaness)</h3>";

ini_set("display_errors", 1);
error_reporting(E_ALL);

$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");

ob_implicit_flush(true);

require_once('include/conexao.inc.php');

class FilesystemDateFilter extends RecursiveFilterIterator {

    protected $earliest_date;

    public function __construct(RecursiveIterator $it, $earliest_date) {
        $this->earliest_date = $earliest_date;
        parent::__construct($it);
    }

    public function accept() {
        return (!$this->isFile() || $this->getMTime() >= $this->earliest_date );
    }

    public function getChildren() {
        return new static($this->getInnerIterator()->getChildren(), $this->earliest_date);
    }

}

$data = date('Y-m-d');

$diretorio = "/home/delta/cte/Retorno/";


//Verifica se a pasta já foi criada pelo UNINFE
if (!is_dir($diretorio)) {
    echo "Pasta não encontrada " . $diretorio . " - " . date("d/m/Y H:i:s");
} else {

    $directory = new RecursiveDirectoryIterator($diretorio);
    $filter = new FilesystemDateFilter($directory, strtotime($data));

    foreach (new RecursiveIteratorIterator($filter) as $listar) {

        if (substr($listar, strlen($listar) - 2, strlen($listar)) == '\.' || substr($listar, strlen($listar) - 2, strlen($listar)) == '/.') {
            
        } else if (substr($listar, strlen($listar) - 3, strlen($listar)) == '\..' || substr($listar, strlen($listar) - 2, strlen($listar)) == '/..') {
            
        } else {
            if (substr($listar, strlen($listar) - 4, 4) == ".XML" || substr($listar, strlen($listar) - 4, 4) == ".xml" || substr($listar, strlen($listar) - 4, 4) == ".Xml") {


                //print " Arquivo: <a href='$listar'>$listar</a><br>";
                //Só processa se for um arquivo do tipo Processado
                if (strpos($listar, '-pro-rec') !== false) {
                    echo "<span style='color:black'>Arquivo: </span><span style='color:blue'><b>{$listar}</b></span><br>";

                    //Comeca a Importacao
                    $nomeOriginal = $listar->getFilename();

                    $listarx = $listar;

                    if (file_exists($listarx)) {

                        #carrega o arquivo XML e retornando um Array
                        $xml = simplexml_load_file($listarx);

                        //Se retornar false não conseguiu ler passa para o próximo
                        if ($xml === false) {
                            echo "<font color='red'>Atencao: arquivo acima inválido!</font><hr>";
                            continue;
                        } else {

                            //Sera necessario verificar se eh um arquivo de CTe, de Cancelamento ou se eh um XML de algum outro formato

                            $tipoArquivo = 0;

                            //0 - Arquivo sem nenhuma informacao				
                            if (!$xml) {
                                echo "<font color='red'>Atencao, arquivo em branco!</font><hr>";
                                $tipoArquivo = 0;
                            }
                            //1 - CTe Processado pelo SEFAZ					
                            else if ($xml->protCTe->infProt->xMotivo != '') {


                                $chavenfe = $xml->protCTe->infProt->chCTe;
                                $motivo = utf8_decode($xml->protCTe->infProt->xMotivo);

                                if ($motivo == 'Autorizado o uso do CT-e') {
                                    $tipoArquivo = 2;
                                    echo "<font color='red'>Atencao, CT-e Autorizado sera processado em outra opcao!</font><hr>";
                                } else {
                                    $tipoArquivo = 1;
                                    echo "<font color='green'>Chave: <b>{$chavenfe}</b></font><br>";
                                    echo "<font color='green'>Sefaz: <b>{$motivo}</b></font><br>";
                                }
                            }							
                            //5 - Arquivo XML de nenhum formato esperado.
                            else {
                                echo "<font color='red'>Atencao, tipo de arquivo nao suportado!</font><hr>";
                                $tipoArquivo = 5;
                            }
                        }

                        //Se for um arquivo de CT-e autorizado pelo SEFAZ
                        if ($tipoArquivo == 1) {


                            //Verifica se já foi importado

                            $auxRecebto = "";
                            $auxExiste = 0;

                            $sqlCte = "SELECT cterecebto FROM cte WHERE ctechave = '$chavenfe'";
                            $cadCte = pg_query($sqlCte);
                            $rowCte = pg_num_rows($cadCte);
                            if ($rowCte > 0) {
                                $auxExiste = 1;
                                $auxRecebto = pg_fetch_result($cadCte, 0, "cterecebto");
                            }


                            if ($auxRecebto == "" && $auxExiste == 1) {

                                $xMotivo = removeTodosCaracterEspeciaisEspaco(utf8_decode($xml->protCTe->infProt->xMotivo));

                                $dhRecbto = str_replace('T', ' ', $xml->protCTe->infProt->dhRecbto);
                                if ($dhRecbto == '') {
                                    $dhRecbto = "null";
                                } else {
                                    $dhRecbto = "'$dhRecbto'";
                                }

                                $update = "UPDATE cte SET cterecebto=$dhRecbto,ctemotivo='$xMotivo' WHERE ctechave = '$chavenfe'";
                                pg_query($update);

                                echo "<font color='green'><b>Rejeição de CT-e importada com sucesso!</b></font><hr>";
                            } else {
                                if ($auxExiste == 1) {
                                    echo "<font color='red'><b>CT-e já importado!</b></font><hr>";
                                } else {
                                    echo "<font color='red'><b>CT-e não encontrado!</b></font><hr>";
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    //echo "Nenhum CT-e encontrado em " . $diretorio . " - " . date("d/m/Y H:i:s");
    echo date("d/m/Y H:i:s") . '<hr>';
}


echo "<meta HTTP-EQUIV='Refresh' CONTENT='5;URL=importageractexmlrejeitado.php?parametro=1'>";
exit;

function removeTodosCaracterEspeciaisEspaco($text) {
    $palavra = $text;
    if (version_compare(PHP_VERSION, '7.0.0', '<')) {
        $palavra = ereg_replace("[^a-zA-Z0-9]", "", strtr($palavra, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ-", "aaaaeeiooouucAAAAEEIOOOUUC"));
    } else {
        $palavra = preg_replace("[^a-zA-Z0-9]", "", strtr($palavra, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ-", "aaaaeeiooouucAAAAEEIOOOUUC"));
    }
    return $palavra;
}
