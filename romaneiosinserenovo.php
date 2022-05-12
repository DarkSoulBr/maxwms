<?php

require_once("./_app/Config.inc.php");
require_once("include/conexao.inc.php");
require_once("include/romaneios.php");
//require_once('include/classes/PrazoEntrega.php');
require("verifica2.php");

//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");
require_once(DIR_ROOT . '/include/classes/JSON/JSON.php');
$json = new Services_JSON();

$romcodigo = $_REQUEST["romcodigo"];
$usucodigo = $_REQUEST["usucodigo"];

$num = $_REQUEST["pvnumero"];
$vol = $_REQUEST["rpvolumes"];

$cadastro = new banco($conn, $db);

if (sizeof($num) > 0) {
    for ($ix = 0; $ix < sizeof($num); $ix++) {
        if (trim($num[$ix]) != '0') {

            $pvnumero = trim($num[$ix]);
            $rpvolumes = trim($vol[$ix]);
            
            //$Prazo = new PrazoEntrega();
            //$prazoentrega = $Prazo->calcular($pvnumero, 1, $romcodigo);
            
            //$promessaentrega = $Prazo->calcularPromessa($pvnumero);
            //'romprevisao' => $prazoentrega,
            //'rompromessa' => $promessaentrega

            $Dados = [
                'romcodigo' => $romcodigo,
                'pvnumero' => $pvnumero,
                'rpvolumes' => $rpvolumes                
            ];

            $Cadastra = new Create;
            $Cadastra->ExeCreate('romaneiospedidos', 'romaneiospedidos_rompedcodigo_seq', $Dados);

            $dataLog = date('Y-m-d H:i:s');
            $cadastro->insere("logromaneiosgeral", "(lgrdata,usucodigo,romcodigo,pvnumero,operacao)", "('$dataLog','$usucodigo','$romcodigo','$pvnumero',11)");

            $mes = date('m');
            $dia = date('d');
            $ano = date('Y');
            $hora = date('H') . date('i');
            $data = $mes . '/' . $dia . '/' . $ano . ' ' . $hora;

            $sql2 = "SELECT * from pedidosexpedidos where pvnumero = '$pvnumero'";
            $sql2 = pg_query($sql2);
            $row2 = pg_num_rows($sql2);
            if ($row2) {
                
            } else {
                $cadastro->insere("pedidosexpedidos", "(pvnumero,pvdatahora)", "('$pvnumero','$data')");
            }
        }
    }
}

pg_close($conn);

$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
$xml .= "<dados>\n";
$xml .= "<dado>\n";
$xml .= "<pvempenho>" . '1' . "</pvempenho>\n";
$xml .= "</dado>\n";
$xml .= "</dados>\n";
Header("Content-type: application/xml; charset=iso-8859-1");

//PRINTA O RESULTADO
echo $xml;
?>
