<?php

require_once("include/conexao.inc.php");

$clicodigo = $_GET['codigo'];

$sql = "SELECT DISTINCT pvenda.pvnumero as pedido, pvenda.pvvalor as valor,
        pvenda.pvvaldesc as valordesc, pvenda.pvvalfrete as valorfrete,
        pvenda.pvemissao as emissao, vendedor.vennguerra as vendedornguerra,
        pvenda.pvorder 
        FROM pvenda 
        LEFT JOIN vendedor on pvenda.vencodigo=vendedor.vencodigo
        WHERE pvenda.clicodigo={$clicodigo} 
        ORDER BY pvenda.pvnumero";

$cad = pg_query($sql);

$row = pg_num_rows($cad);

$geralPedido = 0;
$geralFrete = 0;
$geralTotal = 0;

header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
$xml .= "<dadoslista>";
for ($i = 0; $i < $row; $i++) {

    $xml .= "<registrolista>";

    $pedido = pg_fetch_result($cad, $i, "pedido");
    $order = pg_fetch_result($cad, $i, "pvorder");

    if ($order == '') {
        $order = '_';
    }

    $valor = pg_fetch_result($cad, $i, "valor");
    $valordesc = pg_fetch_result($cad, $i, "valordesc");
    $valorfrete = pg_fetch_result($cad, $i, "valorfrete");

    $emissao = pg_fetch_result($cad, $i, "emissao");

    $vendedornguerra = pg_fetch_result($cad, $i, "vendedornguerra");

    $valor = $valor - $valordesc;
    $total = $valor + $valorfrete;

    $geralPedido += $valor;
    $geralFrete += $valorfrete;
    $geralTotal += $total;

    //Mascara data
    $auxe = explode(" ", $emissao);
    $aux1e = explode("-", $auxe[0]);
    $emissao = $aux1e[2] . '/' . $aux1e[1] . '/' . $aux1e[0];


    $xml .= "<itemlista>" . $pedido . "</itemlista>";
    $xml .= "<itemlista>" . $order . "</itemlista>";
    $xml .= "<itemlista>" . $emissao . "</itemlista>";
    $xml .= "<itemlista>" . $vendedornguerra . "</itemlista>";
    $xml .= "<itemlista>" . number_format($valor, 2, ",", "") . "</itemlista>";
    $xml .= "<itemlista>" . number_format($valorfrete, 2, ",", "") . "</itemlista>";
    $xml .= "<itemlista>" . number_format($total, 2, ",", "") . "</itemlista>";

    $xml .= "</registrolista>";
}

$xml .= "<registrolista>";
$xml .= "<itemlista>_</itemlista>";
$xml .= "<itemlista>_</itemlista>";
$xml .= "<itemlista>_</itemlista>";
$xml .= "<itemlista>_</itemlista>";
$xml .= "<itemlista>" . number_format($geralPedido, 2, ",", "") . "</itemlista>";
$xml .= "<itemlista>" . number_format($geralFrete, 2, ",", "") . "</itemlista>";
$xml .= "<itemlista>" . number_format($geralTotal, 2, ",", "") . "</itemlista>";
$xml .= "</registrolista>";

$xml .= "</dadoslista>";

echo $xml;
pg_close($conn);
