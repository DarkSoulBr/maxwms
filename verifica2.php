<?php

/*
if(!$_SERVER['HTTPS']) {
$protocolo = "https://";
header( "Location: ".$protocolo.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']);
}
*/

// Inicia sessões

session_start();

// Verifica se existe os dados da sessão de login
if(!isset($_SESSION["id_usuario"]) || !isset($_SESSION["nome_usuario"]))
{
    // Usuário não logado! Redireciona para a página de login
    header("Location: login.html");
    exit;
}
?>
