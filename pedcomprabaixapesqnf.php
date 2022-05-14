<?php

require_once("include/conexao.inc.php");
require_once("include/pedcomprabaixa.php");

$parametro = trim($_POST["parametro"]);
$parametro2 = trim($_POST["parametro2"]);
$parametro3 = trim($_POST["parametro3"]);

//$parametro = '1000';
//$parametro2 = '712';

$cadastro = new banco($conn, $db);
$sql = "select a,notentnumero,b.forcodigo from notaent a,pcompra b where notentnumero = '$parametro'
       and notentserie = '$parametro3'
       and a.pcnumero = b.pcnumero and b.forcodigo = $parametro2";

$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";
    for ($i = 0; $i < $row; $i++) {
        $notnumero = pg_fetch_result($sql, $i, "notentnumero");
        if (trim($notnumero) == "") {
            $notnumero = "0";
        }
        $xml .= "<dado>\n";
        $xml .= "<notnumero>" . $notnumero . "</notnumero>\n";
        $xml .= "</dado>\n";
    }
    $xml .= "</dados>\n";
    Header("Content-type: application/xml; charset=iso-8859-1");
}
/* else
  {
  $sql = "select notnumero from notacancdep where notnumero = $parametro";
  $sql = pg_query($sql);
  $row = pg_num_rows($sql);
  if($row) {
  $xml  = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
  $xml .= "<dados>\n";
  for($i=0; $i<$row; $i++) {
  $notnumero = pg_fetch_result($sql, $i, "notnumero");
  if (trim($notnumero)==""){$notnumero = "0";}
  $xml .= "<dado>\n";
  $xml .= "<notnumero>".$notnumero."</notnumero>\n";
  $xml .= "</dado>\n";
  }
  $xml.= "</dados>\n";
  Header("Content-type: application/xml; charset=iso-8859-1");
  }
  else
  {

  $xml  = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
  $xml .= "<dados>\n";
  $xml .= "<dado>\n";
  $xml .= "<notnumero>0</notnumero>\n";
  $xml .= "</dado>\n";
  $xml .= "</dados>\n";
  Header("Content-type: application/xml; charset=iso-8859-1");

  }
  }
 */

echo $xml;
?>
