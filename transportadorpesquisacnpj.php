<?

//RECEBE PARÃMETRO
$parametro = trim($_POST["parametro"]);
$parametro2 = trim($_POST["parametro2"]);

require_once("include/conexao.inc.php");
require_once("include/clientes.php");
require_once('include/classes/JSON/JSON.php');
require_once('vo/TransportadoraVO.php');
require_once('include/funcoes/parser.php');

$json = new Services_JSON();
$tracnpj = insereMascaraCNPJ($_GET['cnpj']);
// $tracnpj = '10';
$transportadora = new TransportadoraVO( $tracnpj,'tracnpj');


print $json->encode($transportadora);
?>
