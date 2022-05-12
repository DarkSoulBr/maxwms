<?php
require_once("include/conexao.inc.php");
require_once("include/romaneios.php");

$romnumeroano=$_POST["romnumeroano"];

$romnumeroano="      ".$romnumeroano;
$romnumero=trim(substr($romnumeroano, -12, 7 ));
$romano=substr($romnumeroano, -4, 4 );

$OK=0;
While($OK==0) {

$sql = "SELECT * FROM  romaneios a
WHERE a.romnumero = '$romnumero' AND
a.romano = '$romano'";
$sql = pg_query($sql);
$row = pg_num_rows($sql);
if($row) {
  $OK=0;
  $romnumero++;
}else {$OK=1;}

}


   $xml  = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
   $xml .= "<dados>\n";

   //PERCORRE ARRAY
      $xml .= "<dado>\n";
      $xml .= "<romnumero>".$romnumero."</romnumero>\n";
      $xml .= "</dado>\n";

   $xml.= "</dados>\n";

   //CABEÇALHO
   Header("Content-type: application/xml; charset=iso-8859-1");


//PRINTA O RESULTADO
echo $xml;
?>
