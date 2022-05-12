<?php

if (isset($_SERVER['HTTPS'])) {
    $protocolo = "http://";
    header("Location: " . $protocolo . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME']);
}

// Inicia sess�es

session_start();

// Verifica se existe os dados da sess�o de login
if(!isset($_SESSION["id_usuario"]) || !isset($_SESSION["nome_usuario"]))
{
    // Usu�rio n�o logado! Redireciona para a p�gina de login
    header("Location: login.html");
    exit;
}
?>
