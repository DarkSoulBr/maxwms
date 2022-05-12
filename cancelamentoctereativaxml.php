<?php

$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");

require_once("include/conexao.inc.php");
require_once("include/banco.php");

$ctecodigo = $_GET["ctecodigo"];
$numero = $_GET["numero"];

$cadastro = new banco($conn, $db);

$data = date("Y-m-d H:i:s");

$sql = "Delete from ctecancelado where ctenum = '$numero'";
pg_query($sql);

//deleta a data de cancelamento
$update = "Update cte set ctecancdata=null,ctecancchave='' Where ctenumero  = '$ctecodigo'";
pg_query($update);


$sql = "Select * FROM cte where ctenumero  = '$ctecodigo'";

$cad = pg_query($sql);

if (pg_num_rows($cad)) {
    $row = pg_num_rows($cad);

    for ($i = 0; $i < $row; $i++) {

        $cteemicnpj = pg_fetch_result($cad, $i, "cteemicnpj");

        $cteemicnpj = str_replace('.', '', $cteemicnpj);
        $cteemicnpj = str_replace('/', '', $cteemicnpj);
        $cteemicnpj = str_replace('-', '', $cteemicnpj);
    }
}


//Envia e-mail com o Cancelamento para os usuários cadastrados

$traemail = "";

$sql_mail = "SELECT canemail FROM cancelaemail";
$sql_mail = pg_query($sql_mail);
$row_mail = pg_num_rows($sql_mail);
if ($row_mail) {
    for ($im = 0; $im < $row_mail; $im++) {
        if ($traemail == '') {
            $traemail = pg_fetch_result($sql_mail, $im, "canemail");
        } else {
            $traemail = $traemail . ";" . pg_fetch_result($sql_mail, $im, "canemail");
        }
    }
}

if ($traemail != '') {

    enviaEmail($numero, $cteemicnpj, $traemail);
}



pg_close($conn);
exit();

function enviaEmail($numeroEmail, $emiEmail, $email) {

    //Usa os dados da tabela de Parametros
    $sqlmail = "Select * from parametrosemail LIMIT 1";
    $cadmail = pg_query($sqlmail);
    if (pg_num_rows($cadmail)) {
        $paremail = pg_fetch_result($cadmail, 0, "email");
        $parsenha = pg_fetch_result($cadmail, 0, "senha");
        $parsmtp = pg_fetch_result($cadmail, 0, "smtp");
        $parporta = pg_fetch_result($cadmail, 0, "usuario");
        $smtpuser = pg_fetch_result($cadmail, 0, "smtpuser");
        $smtppass = pg_fetch_result($cadmail, 0, "smtppass");
    } else {
        $paremail = '';
        $parsenha = '';
        $parsmtp = '';
        $parporta = '';
        $smtpuser = '';
        $smtppass = '';
    }
    $from = $paremail;

    $nomedoarquivo = "reativa_cte_" . date("d_m_Y_H_i") . ".txt";
    $acao = "1";
    $id = "'";

    $destinatarios = '';
    $remetente = $from;
    $assunto = '';
    $mensagem = '';

    $path = DIR_ROOT . '/lib';
    set_include_path(get_include_path() . PATH_SEPARATOR . $path);
    require_once("Zend/Loader/Autoloader.php");

    $autoloader = Zend_Loader_Autoloader::getInstance();
    $autoloader->setFallbackAutoloader(true);

    $data = date("d/m/Y H:i:s");

    if (!$smtpuser) {
        $config = array("auth" => "login", "username" => $paremail, "password" => $parsenha, "port" => $parporta);
    } else {
        $config = array("ssl" => "tls", "auth" => "login", "username" => $smtpuser, "password" => $smtppass, "port" => $parporta);
    }
    $tr = new Zend_Mail_Transport_Smtp($parsmtp, $config);

    Zend_Mail::setDefaultTransport($tr);
    //funcao para envio de email - Zend_Mail
    $mail = new Zend_Mail();

    $mail->setFrom($remetente, "Alfaness Logística");

    $texto = $email;

    $mails = explode(";", $texto);

    foreach ($mails as $value) {

        if (trim($value)) {

            $mail->addTo(trim(strtolower($value)));
            $destinatarios .= trim(strtolower($value));
        }
    }

    $msg = "";

    $assunto = "Reativação de CT-e " . $numeroEmail;

    $mail->setSubject($assunto);

    $msg .= '<p><span style="font-family:tahoma,geneva,sans-serif;">' . "Esta mensagem refere-se ao Conhecimento de Transporte Eletrônico de número " . $numeroEmail . " reativado em " . date("d/m/Y") . '</span></p>';

    $msg .= '<p><span style="font-family:tahoma,geneva,sans-serif;">' . "Emitente: " . $emiEmail . '</span></p>';


    $mail->setBodyHTML($msg);


    try {
        $mail->send();
        logEmail("EMAIL ENCAMINHADO ", $nomedoarquivo, $texto, $remetente, $assunto, $msg, date("Y-m-d H:i:s"));
    } catch (Exception $e) {
        logEmail("NAO FOI POSSIVEL ENVIAR O EMAIL" . $e->getMessage(), $nomedoarquivo, $texto, $remetente, $assunto, $msg, date("Y-m-d H:i:s"), true);
    }
}

function logEmail($msg, $nomedoarquivo, $destinatarios, $remetente, $assunto, $mensagem, $data, $reenvio = false) {

    $caminho = '/home/delta/email/';
    if (!is_dir($caminho)) {
        mkdir($caminho, 0755);
    }

    $fp = fopen('/home/delta/email/' . $nomedoarquivo, 'a+');
    fwrite($fp, $msg . " EM " . $data . "\n");
    if ($reenvio) {
        fwrite($fp, "NOVA TENTATIVA DE ENVIO EM 1 HORA.\n");
    }
    fwrite($fp, "DESTINATARIO(S): " . $destinatarios . "\n");
    fwrite($fp, "REMETENTE: " . $remetente . "\n");
    fwrite($fp, "ASSUNTO: " . $assunto . "\n");
    fwrite($fp, "MENSAGEM: " . strip_tags($mensagem) . "\n\n\n");
    fclose($fp);
}

?>
