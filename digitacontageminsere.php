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

$cadastro->insere("inventariocontagemsetorproduto","(procodigo,invdata,concodigo,setcodigo,quantidade,colcodigo)","('$procodigo','$invdata','$contagem','$setor','$pvcconfere','$coletor')");

pg_close($conn);
exit();
?>