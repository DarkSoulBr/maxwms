<?php

//pega da pasta de instalação
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/_app/Config.inc.php");

//FUNCTION TO SEND EMAIL VIA ZEND MAIL
$path = DIR_ROOT . '/lib';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);
require_once('Zend/Loader/Autoloader.php');

class EnviarEmail {

    public function enviar($destinatario, $assunto, $msg, $bcc = "", $tipo = 6, $modo = 1, $log = "", $anexo = "") {
        
        //Passa a ser fixo 6
        $tipo = 6;

        //Usa os dados da tabela de Parametros
        $sqlmail = "SELECT * FROM parametrosemail WHERE tipo=$tipo LIMIT 1";
        $read = new Read;
        $read->FullRead($sqlmail);

        if ($read->getRowCount() >= 1) {
            $paremail = $read->getResult()[0]['email'];
            $parsenha = $read->getResult()[0]['senha'];
            $parsmtp = $read->getResult()[0]['smtp'];
            $parporta = $read->getResult()[0]['usuario'];
            $smtpuser = $read->getResult()[0]['smtpuser'];
            $smtppass = $read->getResult()[0]['smtppass'];
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

        //if ($modo == 1) {
        if(!$smtpuser) {
            $config = array("auth" => "login", "username" => $paremail, "password" => $parsenha, "port" => $parporta);
        } else {
            $config = array("ssl" => "tls", "auth" => "login", "username" => $smtpuser, "password" => $smtppass, "port" => $parporta);
        }
        $tr = new Zend_Mail_Transport_Smtp($parsmtp, $config);

        Zend_Mail::setDefaultTransport($tr);
        //FUNCTION TO SEND EMAIL VIA ZEND MAIL
        $mail = new Zend_Mail ();
        $mail->setFrom($from, "Workflow Toymania");

        $destinatariox = '';
        foreach ($destinatario as $value) {
            $destinatariox .= $value . ';';
            $mail->addTo($value);
        }
        if (!empty($bcc)) {
            $mail->addBcc($bcc);
        }

        $mail->setSubject($assunto);
        $mail->setBodyHTML($msg);

        $mensagem = strip_tags($msg);

        if ($anexo != '') {
            $at = new Zend_Mime_Part(file_get_contents($anexo));
            $at->filename = basename($anexo);
            $at->disposition = Zend_Mime::DISPOSITION_INLINE;
            $at->encoding = Zend_Mime::ENCODING_BASE64;
            $mail->addAttachment($at);
        }

        $datax = date('d_m_Y_H_i');
        $nomedoarquivo = $log . "_" . $datax . ".txt";

        try {
            $mail->send();
            gerarLogEmail("EMAIL ENCAMINHADO ", $nomedoarquivo, $destinatariox, $from, $assunto, $mensagem, date("Y-m-d H:i:s"));

            return true;
        } catch (Exception $e) {

            gerarLogEmail("NAO FOI POSSIVEL ENVIAR O EMAIL" . $e->getMessage(), $nomedoarquivo, $destinatariox, $from, $assunto, $mensagem, date("Y-m-d H:i:s"));
            return false;
        }
    }

}

function gerarLogEmail($msg, $nomedoarquivo, $destinatarios, $remetente, $assunto, $mensagem, $data) {
    if (!is_dir('/home/delta/email/')) {
        mkdir('/home/delta/email/', 0755);
    }
    $fp = fopen('/home/delta/email/' . $nomedoarquivo, 'a+');
    fwrite($fp, $msg . " EM " . $data . "\n");
    fwrite($fp, "DESTINARARIO(S): " . $destinatarios . "\n");
    fwrite($fp, "REMETENTE: " . $remetente . "\n");
    fwrite($fp, "ASSUNTO: " . $assunto . "\n");
    fwrite($fp, "MENSAGEM: " . strip_tags($mensagem) . "\n\n\n");
    fclose($fp);
}
