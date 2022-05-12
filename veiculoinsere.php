<?php

require_once("include/conexao.inc.php");
require_once("include/veiculo.php");

$veiplaca = trim($_GET["veiplaca"]);

$veiano = trim($_GET["veiano"]);
$veimodelo = trim($_GET["veimodelo"]);
$veicor = trim($_GET["veicor"]);
$veichassis = trim($_GET["veichassis"]);
$veitipo = trim($_GET["veitipo"]);

$veivalidar = trim($_GET["veivalidar"]);

$sql = "SELECT max(veicodigo) as codigo FROM veiculos";

$sql = pg_query($sql);

$row = pg_num_rows($sql);

$codigo = (pg_fetch_result($sql, 0, "codigo") + 1);

$cadastro = new banco($conn, $db);

$cadastro->insere("veiculos", "(veiplaca,veiano,veimodelo,veicor,veichassis,veitipo,veicodigo,veivalidar)", "
          ('$veiplaca','$veiano','$veimodelo','$veicor','$veichassis','$veitipo','$codigo','$veivalidar')");

pg_close($conn);
exit();
?>