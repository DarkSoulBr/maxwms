<?php   
require_once("include/conexao.inc.php");
require_once("include/conferencia.php");

$procodigo=trim($_GET["procodigo"]);
$invdata=trim($_GET["invdata"]);
$contagem=trim($_GET["contagem"]);
$coletor=trim($_GET["coletor"]);
$setor=trim($_GET["setor"]);
$pvcconfere=trim($_GET["pvcconfere"]);

$aux = explode("/",$invdata);
$invdata = $aux[2].'-'.$aux[1].'-'.$aux[0].' 00:00:00-03';

$cadastro = new banco($conn,$db);

$sql = "UPDATE inventariocontagemsetorproduto SET quantidade=$pvcconfere Where invdata = '" . $invdata . "' and concodigo = $contagem and setcodigo = $setor and procodigo = $procodigo and colcodigo = $coletor";
pg_query($sql);

pg_close($conn);
exit();
?>