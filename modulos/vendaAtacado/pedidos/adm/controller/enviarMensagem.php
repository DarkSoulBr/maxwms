<?php

/**
 * Enviar mensagem das pendencias de Pedidos.
 *
 * Envia as mensagem de pendencias.
 * Procure na pasta view/js as a??es jquery.
 * Este arquivo segue os padroes estabelecidos no dTrade.
 *
 * @name Pedidos Adm View - Enviar Mensagem
 * @category Pedidos
 * @package modulos/vendaAtacado/pedidos/adm/controller
 * @link modulos/vendaAtacado/pedidos/adm/controller/enviarMensagem.php
 * @version 1.0
 * @since Criado 23/12/2010
 * @author Wellington <wellington@centroatacadista.com.br>
 * @copyright MaxTrade
 */
//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configura??es do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");
require_once(DIR_ROOT . '/include/classes/JSON/JSON.php');
require_once(DIR_ROOT . '/include/funcoes/removeCaracterEspecial.php');

$path = DIR_ROOT . '/lib';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

require_once("Zend/Loader/Autoloader.php");

$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->setFallbackAutoloader(true);

$json = new Services_JSON();

$data = new Zend_Date();

$txtMail = $_POST["txtMail"];
//        $from = trim(strtolower($_POST['from']));
$txtObs = $_POST["txtObs"];
//	$txtObs = removeTodosCaracterEspeciais($_POST["txtObs"]);
$pvnumero = $_POST["pvnumero"];
$from = trim(strtolower($_POST['from']));
$destinatarios = '';
$remetente = $from;
$assunto = '';
$mensagem = '';
$nomedoarquivo = "pedido$pvnumero.txt";

//configura para envio de email
$config = array("auth" => "login", "username" => "maxtrade@baraodistribuidor.com.br", "password" => "centro", "port" => "587");
//$config = array ("auth"=>"login", "username"=>"wellington@centroatacadista.com.br", "password"=>"centro");
$tr = new Zend_Mail_Transport_Smtp('smtp.baraodistribuidor.com.br', $config);

Zend_Mail::setDefaultTransport($tr);
//funcao para envio de email - Zend_Mail
$mail = new Zend_Mail();
$mail->setFrom("maxtrade@baraodistribuidor.com.br", "MAXTrade");

$mails = explode(";", $txtMail);

foreach ($mails as $value) {
    if (trim($value)) {

        $mail->addTo(trim(strtolower($value)));
        $destinatarios .= trim(strtolower($value));
    }
}
$mail->addTo($from);

//	$mail->addTo ('douglas@centroatacadista.com.br');
//	$mail->addTo ('douglascavalini@gmail.com');
//	$msg = "PEDIDO NUMERO $pvnumero CONTEM AS SEGUINTES PENDENCIAS PARA SUA LIBERACAO!";
$msg = "Estamos solicitando ao cliente informacoes para finalizar analise de credito, conforme segue abaixo:";
$msg .= "<br /><br />" . nl2br($txtObs);
$msg .= "<br />Atencao: informamos que o nao envio das solicitacoes apos tres dias o pedido sera negado";
$msg .= "<br /><br /><h5>" . $data->toString('dd MMMM YYYY HH:mm:ss') . '</ h5>';


$mail->setSubject("Administra??o de Pedidos - Pendencias Pedido $pvnumero");
$mail->setBodyHTML($msg);
$assunto .= "Administra??o de Pedidos - Pendencias Pedido $pvnumero";
$mensagem = $txtObs;
$mensagem .= " " . $data->toString('dd MMMM YYYY HH:mm:ss');
try {
    $mail->send();
    $fp = fopen('/home/delta/logpedidos/' . $nomedoarquivo, 'a+');
    //         $fp = fopen('/home/delta/interfix/' . $nomedoarquivo, 'a+');
    fwrite($fp, "EMAIL ENCAMINHADO EM: " . $data->toString('dd MMMM YYYY HH:mm:ss') . "\n");
    fwrite($fp, "DESTINARARIO(S): " . $destinatarios . "\n");
    fwrite($fp, "REMETENTE: " . $remetente . "\n");
    fwrite($fp, "ASSUNTO: " . $assunto . "\n");
    fwrite($fp, "MENSAGEM: " . $mensagem . "\n\n\n");
    fclose($fp);
    print true;
} catch (Exception $e) {
    print false;
}

	

				