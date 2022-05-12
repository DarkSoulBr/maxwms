<?php

//pega da pasta de instalação
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");
//FUNCTION TO SEND EMAIL VIA ZEND MAIL

$path = DIR_ROOT . '/lib';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

require_once('Zend/Loader/Autoloader.php');

class EnviaEmail {

    public function envia($destinatario, $assunto, $msg, $bcc = "") {

        require_once("include/conexao.inc.php");

        //Usa os dados da tabela de Parametros
        $sqlmail = "Select * from parametrosemail where tipo=6 LIMIT 1";
        //$sqlmail = "Select * from parametrosemail where tipo=1 LIMIT 1";
        $cadmail = pg_query($sqlmail);
        if (pg_num_rows($cadmail)) {
            $paremail = pg_result($cadmail, 0, "email");
            $parsenha = pg_result($cadmail, 0, "senha");
            $parsmtp = pg_result($cadmail, 0, "smtp");
            $parporta = pg_result($cadmail, 0, "usuario");
            $smtpuser = pg_result($cadmail, 0, "smtpuser");
            $smtppass = pg_result($cadmail, 0, "smtppass");
        } else {
            $paremail = '';
            $parsenha = '';
            $parsmtp = '';
            $parporta = '';
            $smtpuser = '';
            $smtppass = '';
        }
        $from = $paremail;

        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->setFallbackAutoloader(true);

        if(!$smtpuser) {
            $config = array("auth" => "login", "username" => $paremail, "password" => $parsenha, "port" => $parporta);
        } else {
            $config = array("ssl" => "tls", "auth" => "login", "username" => $smtpuser, "password" => $smtppass, "port" => $parporta);
        }
        //$tr = new Zend_Mail_Transport_Smtp('smtp.toymania.com.br', $config);
        $tr = new Zend_Mail_Transport_Smtp($parsmtp, $config);

        Zend_Mail::setDefaultTransport($tr);
        //FUNCTION TO SEND EMAIL VIA ZEND MAIL
        $mail = new Zend_Mail ();
        //$mail->setFrom("maxtrade@baraodistribuidor.com.br", "Workflow MAXTrade");
        //$mail->setFrom("delta@uol.com.br", "Workflow MAXTrade");
        //$mail->setFrom("workflow@toymania.com.br", "Workflow Toymania");
        $mail->setFrom($from, "Workflow Toymania");

        foreach ($destinatario as $value) {
            $mail->addTo($value);
        }
        if (!empty($bcc)) {
            $mail->addBcc($bcc);
        }

        $mail->setSubject($assunto);
        $mail->setBodyHTML($msg);
        //$mail->send ();
        try {
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function enviaAnexo($destinatario, $assunto, $msg, $anexo) {

        require_once("include/conexao.inc.php");

        //Usa os dados da tabela de Parametros
        $sqlmail = "Select * from parametrosemail where tipo=6 LIMIT 1";
        //$sqlmail = "Select * from parametrosemail where tipo=1 LIMIT 1";
        $cadmail = pg_query($sqlmail);
        if (pg_num_rows($cadmail)) {
            $paremail = pg_result($cadmail, 0, "email");
            $parsenha = pg_result($cadmail, 0, "senha");
            $parsmtp = pg_result($cadmail, 0, "smtp");
            $parporta = pg_result($cadmail, 0, "usuario");
            $smtpuser = pg_result($cadmail, 0, "smtpuser");
            $smtppass = pg_result($cadmail, 0, "smtppass");
        } else {
            $paremail = '';
            $parsenha = '';
            $parsmtp = '';
            $parporta = '';
            $smtpuser = '';
            $smtppass = '';
        }
        $from = $paremail;

        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->setFallbackAutoloader(true);

        if(!$smtpuser) {
            $config = array("auth" => "login", "username" => $paremail, "password" => $parsenha, "port" => $parporta);
        } else {
            $config = array("ssl" => "tls", "auth" => "login", "username" => $smtpuser, "password" => $smtppass, "port" => $parporta);
        }
        //$tr = new Zend_Mail_Transport_Smtp('smtp.toymania.com.br', $config);
        $tr = new Zend_Mail_Transport_Smtp($parsmtp, $config);

        Zend_Mail::setDefaultTransport($tr);
        //FUNCTION TO SEND EMAIL VIA ZEND MAIL
        $mail = new Zend_Mail ();
        //$mail->setFrom("maxtrade@baraodistribuidor.com.br", "Workflow MAXTrade");
        //$mail->setFrom("workflow@toymania.com.br", "Workflow Toymania");
        $mail->setFrom($from, "Workflow Toymania");

        foreach ($destinatario as $value) {
            $mail->addTo($value);
        }
        //$mail->addBcc('fernando.simao@baraodistribuidor.com.br');

        $mail->setSubject($assunto);
        $mail->setBodyHTML($msg);

//        $anexo = '/path/to/a/file';
        $at = new Zend_Mime_Part(file_get_contents($anexo));
        $at->filename = basename($anexo);
        $at->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
        $at->encoding = Zend_Mime::ENCODING_8BIT;

        $mail->addAttachment($at);
        //$mail->send ();

        try {
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}

?>
