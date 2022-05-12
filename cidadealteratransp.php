<?php
require_once("include/conexao.inc.php");
require_once("include/banco.php");

$cidcodigo=trim($_GET["cidcodigo"]);
$transp=trim($_GET["transp"]);
$prazo=trim($_GET["prazo"]);

$sql="Select * from cidadesfrete Where cidcodigo = '$cidcodigo'";
$sql = pg_query($sql);
$row = pg_num_rows($sql);
if($row) {
	$sql3 = "UPDATE cidadesfrete SET tracodigo='$transp',prazo='$prazo' Where cidcodigo='$cidcodigo'";
	pg_query($sql3);
}
else {
	$sql2 = "INSERT INTO cidadesfrete (cidcodigo,tracodigo,prazo) values ('$cidcodigo','$transp','$prazo')";
	pg_query($sql2);
}

pg_close($conn);
exit();
?>
