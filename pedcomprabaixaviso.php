<?php

/*
require_once("include/conexao.inc.php");
require_once("include/pedcomprabaixa.php");
require_once("modulos/compras/manutencao/pedidos/controller/PedidoComprasController.php");

$pcnumero=trim($_GET["pcnumero"]);
$datanota=trim($_GET["datanota"]);
$nota1=$_GET["nota1"];

$notentdatanota=substr($datanota, 6, 4).'-'.substr($datanota, 3, 2).'-'.substr($datanota, 0, 2);

$cadastro = new banco($conn,$db);

// ENVIAR NOTIFICACAO DE PRE-BAIXA REALIZADA AOS USUARIOS REGISTRADOS
$notentnumero = $nota1;
$notentemissao = $notentdatanota;

$PedidoComprasController = new PedidoController();
$PedidoComprasController->notificar($pcnumero, $notentnumero, $notentemissao, 3);

pg_close($conn);
exit();
 * 
 */

?>
