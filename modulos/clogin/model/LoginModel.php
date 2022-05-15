<?php

//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");
require_once(DIR_ROOT . '/include/classes/Conexao.php');
require_once(DIR_ROOT . '/vo/UsuarioVO.php');


Class LoginModel {
    
    function buscarUsuario($login, $senha) {
        
        $retorno = new stdClass();
        
        if ($login=='') {
            
            $retorno->mensagem = "Digite o Usuario";
            $retorno->retorno = false;
            $retorno->retorno2 = 0;
            
        } else if ($senha=='') {
            
            $retorno->mensagem = "Digite a Senha";
            $retorno->retorno = false;
            $retorno->retorno2 = 0;
            
        } else {

            $sql = "SELECT 
                                            a.uscodigo as id,
                                            a.uslogin as login, 
                                            a.usdescricao as nome,
                                            '0' as nivel,
                                            '0' as empresa,
                                            '0' as local,
                                            '0' as caixa,
                                            '0' as email,
                                            a.ussenha as senha,
                                            '0' as acesso,
                                            '0' as linkcodigo,
                                            '0' as link,
                                    '0' as acesso01,
                                    '0' as acesso02,
                                    '0' as acesso03,
                                    '0' as acesso04
                            FROM 
                                    cadusuarios a
                            WHERE 
                                    uslogin = '" . $login . "'";


            $conexao = new Conexao();
            $db = $conexao->connection();

            $result = $db->GetRow($sql);            

            $user = new UsuarioVO();
            
            if (!$result) {
                //$retorno->mensagem = "NAO FOI POSSIVEL EXECUTAR LOGIN. " . $db->ErrorMsg();
                $retorno->mensagem = "LOGIN INCORRETO, VERIFIQUE O USUARIO E SENHA DIGITADAS";
                $retorno->retorno = false;
            } else {
                $user->codigo = $result['id'];
                $user->login = $result['login'];
                $user->nome = $result['nome'];
                $user->nivel = $result['nivel'];
                $user->empresa = $result['empresa'];
                $user->local = $result['local'];
                $user->caixa = $result['caixa'];
                $user->email = $result['email'];
                $user->senha = $result['senha'];
               
            }

            //verifica senha correta
            if (!strcmp($senha, $user->senha)) {
                $_SESSION["id_usuario"] = $user->codigo;
                $_SESSION["nome_usuario"] = $user->nome;
                $_SESSION["permissao"] = 'S';
               
                $_SESSION["usuario"] = json_encode($user);

                $retorno->mensagem = "LOGIN EFETUADO COM SUCESSO.";
                $retorno->retorno = true;
                $retorno->usuario = $user;
            } else {
                $retorno->mensagem = "LOGIN INCORRETO, VERIFIQUE O USUARIO E SENHA DIGITADAS";
                $retorno->retorno = false;
            }
            
        }

        return $retorno;
    }

}

