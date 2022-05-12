<?php

require_once('./_app/Config.inc.php');

$usuario = $_GET["usuario"];
$opcao = $_GET["opcao"];

$retorno = 'S';

header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
$xml .= "<dados>";
$xml .= "<registro>";
$xml .= "<item>{$retorno}</item>";
$xml .= "</registro>";
$xml .= "</dados>";

echo $xml;
