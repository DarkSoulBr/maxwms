<?

require('./_app/Config.inc.php');

$parametro = trim($_POST["parametro"]);

if (($parametro) != 0) {
    $sql = "SELECT a.pracodigo,a.pranome FROM prazo a WHERE a.pracodigo = '$parametro'";
} else {
    $sql = "SELECT a.pracodigo,a.pranome FROM prazo a ORDER BY a.pracodigo";
}

$read = new Read;
$read->FullRead($sql);

if ($read->getRowCount() >= 1) {

    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    foreach ($read->getResult() as $registros) {
        extract($registros);
        $codigo = $pracodigo;
        $descricao = $pranome;
        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao>" . $descricao . "</descricao>\n";
        $xml .= "</dado>\n";
    }
    $xml .= "</dados>\n";
    Header("Content-type: application/xml; charset=iso-8859-1");
}
echo $xml;

