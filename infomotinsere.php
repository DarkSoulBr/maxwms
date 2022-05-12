<?php
require_once("include/conexao.inc.php");
require_once("include/banco.php");

$usucodigo		=$_GET["usucodigo"];
$codmotorista	=$_GET["codmotorista"];
$motorista		=$_GET["motorista"];
$cpf			=$_GET["cpf"];

$cadastro = new banco($conn,$db);

//VERIFICA SE VOLTOU ALGO
if($codmotorista=='' || $codmotorista=='0') {
	$cadastro->insere("infomotoristas","(usucodigo,infmotnome,infmotcpf)","('$usucodigo','$motorista','$cpf')");	
}
else {
	$cadastro->altera("infomotoristas","usucodigo='$usucodigo',infmotnome='$motorista',infmotcpf='$cpf'","infmotcodigo=$codmotorista"); 
}

pg_close($conn);
exit();
?>
