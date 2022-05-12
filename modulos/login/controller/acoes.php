<?php

// Inicia sessões
session_start();

//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");
require_once('LoginController.php');


if (isset($_POST["login"])) {
    $login = addslashes(trim(strtoupper($_POST["login"])));
} else {
    $login = '';
}

if (isset($_POST["senha"])) {
    // Recupera a senha, a criptografando em MD5    
    if (!empty($_POST["senha"])) {
        $senha = trim(md5($_POST["senha"]));
    } else {
        $senha = trim($_POST["senha"]);
    }
} else {
    $senha = '';
}

$control = new LoginController();
$retorno = $control->verificarLogin($login, $senha);

print json_encode($retorno);
