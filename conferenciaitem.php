<?php

require_once("include/conexao.inc.php");
require_once("include/conferencia.php");

//RECEBE PARÃMETRO

$parametro = trim($_POST["parametro"]);

$cadastro = new banco($conn,$db);

  $sql = "SELECT a.pvnumero FROM pvendaconfere a
  Where a.pvnumero = '$parametro'
  ORDER BY a.pvnumero";


//EXECUTA A QUERY
$sql = pg_query($sql);

$row = pg_num_rows($sql);

//VERIFICA SE VOLTOU ALGO
if($row) {
   $row = $row+1;
   $xml  = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
   $xml .= "<dados>\n";
   $xml .= "<dado>\n";
   $xml .= "<row>".$row."</row>\n";
   $xml .= "</dado>\n";
   $xml.= "</dados>\n";
   Header("Content-type: application/xml; charset=iso-8859-1");
}
else{
   $xml  = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
   $xml .= "<dados>\n";
   $xml .= "<dado>\n";
   $xml .= "<row>"."1"."</row>\n";
   $xml .= "</dado>\n";
   $xml.= "</dados>\n";
   Header("Content-type: application/xml; charset=iso-8859-1");

}


//PRINTA O RESULTADO
echo $xml;
?>
