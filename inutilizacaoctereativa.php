<?php 
require_once("include/conexao.inc.php"); 

$ctecodigo = $_GET["ctecodigo"];
$numero = $_GET["numero"];

$update = "Update cte set ctedatainutiliza=null,ctemotivoinutiliza=null,usucodigoinutiliza=null Where ctenumero  = '$ctecodigo'";
pg_query($update);

pg_close($conn);
exit();
?>
