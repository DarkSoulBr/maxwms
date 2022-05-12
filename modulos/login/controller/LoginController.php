<?php

//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");

// inclui o model para acesso busca info no banco
require_once(DIR_ROOT . '/modulos/login/model/LoginModel.php');

Class LoginController {

    var $usuario;

    public function verificarLogin($login, $senha) {
        $this->usuario = new LoginModel();
        return $this->usuario = $this->usuario->buscarUsuario($login, $senha);
    }

}

