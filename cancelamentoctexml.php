<?php

$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");

require_once("include/conexao.inc.php");
require_once("include/banco.php");

$protocolo = trim($_GET["protocolo"]);
$motivo = trim($_GET["motivo"]);
$usuario = $_GET["usuario"];
$ctecodigo = $_GET["ctecodigo"];
$flagassina = $_GET["ass"];

$numero = $_GET["numero"];
$chave = $_GET["chave"];

//$flagassina = 0;


if ($flagassina == 1) {

    //include_once '../nfephp/bootstrap.php';
    //use NFePHP\NFe\ToolsNFe;
    //$nfe = new ToolsNFe('c:/config.json'); 
    /////////////////////////////////////////////////////////////////////
}

$cadastro = new banco($conn, $db);

//ctedata

$data = date("Y-m-d H:i:s");

$fuso = date("P");


$sql = "SELECT parambiente,parversao,parcodigos,ctesegnome,ctesegapolice,cterntrc,cteperservico,ctelayoutversao FROM  parametros";
$sql = $sql . " WHERE parcod = '1'";
$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {
    $parambiente = pg_fetch_result($sql, 0, "parambiente");
    $ctelayoutversao = pg_fetch_result($sql, 0, "ctelayoutversao");
    if (trim($parambiente) == "") {
        $parambiente = "1";
    }
    if (trim($ctelayoutversao) == "") {
        $ctelayoutversao = "1";
    }
}


if ($ctelayoutversao == "1") {
    $versao = '2.00';
} else {
    $versao = '3.00';
}

$sql = "INSERT INTO ctecancelado (ctecprotocolo,ctecmotivo,cteusuario,ctedata,ctenumero,ctenum,ctechaveref) values ('$protocolo','$motivo','$usuario','$data','$ctecodigo','$numero','$chave')";
pg_query($sql);

$name = "/home/delta/cte/" . $chave . "-cte-cancel.xml";

$sql = "Select * FROM cte where ctenumero  = '$ctecodigo'";

$cad = pg_query($sql);

if (pg_num_rows($cad)) {
    $row = pg_num_rows($cad);

    for ($i = 0; $i < $row; $i++) {

        $cteemicnpj = pg_fetch_result($cad, $i, "cteemicnpj");

        $cteemicnpj = str_replace('.', '', $cteemicnpj);
        $cteemicnpj = str_replace('/', '', $cteemicnpj);
        $cteemicnpj = str_replace('-', '', $cteemicnpj);

        $ctechave = pg_fetch_result($cad, $i, "ctechave");
    }
}

$tpEvento = '110111';
$nSeqEvento = '1';
$Id = 'ID' . $tpEvento . $ctechave . str_pad($nSeqEvento, 2, '0', STR_PAD_LEFT);
$cOrgao = '35';

//Passa a gravar a chave de Cancelamento
$update = "Update cte set ctecancdata='$data',ctecancchave='$Id' Where ctenumero  = '$ctecodigo'";
pg_query($update);

$text = '<eventoCTe xmlns="http://www.portalfiscal.inf.br/cte" versao="' . $versao . '">';
$text .= '<infEvento Id="' . $Id . '">';            //Identificador da TAG a ser assinada, a regra de formação do Id é: “ID”+ tpEvento+ chave do CT-e+ nSeqEvento

$text .= '<cOrgao>35</cOrgao>';            //Código do órgão de recepção do Evento. Utilizar a Tabela do IBGE extendida, utilizar 90 para identificar SUFRAMA 
$text .= '<tpAmb>1</tpAmb>';               //1 – Produção 2 – Homologação
$text .= '<CNPJ>' . $cteemicnpj . '</CNPJ>';         //Informar o CNPJ do autor do Evento
$text .= '<chCTe>' . $ctechave . '</chCTe>';         //Chave de Acesso do CT-e vinculado ao Evento
$text .= '<dhEvento>' . substr($data, 0, 10) . 'T' . substr($data, 11, 8) . $fuso . '</dhEvento>';        //Data e hora do evento no formato AAAAMM-DDThh:mm:ss	
//$text.= '<dhEvento>'.substr($data,0,10) . 'T' . substr($data,11,8) .'</dhEvento>';								//Data e hora do evento no formato AAAAMM-DDThh:mm:ss	
$text .= '<tpEvento>' . $tpEvento . '</tpEvento>';       //Tipo do Evento
$text .= '<nSeqEvento>' . $nSeqEvento . '</nSeqEvento>';      //Sequencial do evento para o mesmo tipo de evento. Para maioria dos eventos será 1, nos casos em que possa existir mais de um evento o autor do evento deve numerar de forma sequencial.
$text .= '<detEvento versaoEvento="' . $versao . '">';

$text .= '<evCancCTe>';
$text .= '<descEvento>Cancelamento</descEvento>';
$text .= '<nProt>' . $protocolo . '</nProt>';
$text .= '<xJust>' . $motivo . '</xJust>';
$text .= '</evCancCTe>';

$text .= '</detEvento>';

$text .= '</infEvento>';
$text .= '</eventoCTe>';




$file = fopen($name, 'w');
fwrite($file, $text);
fclose($file);


if ($flagassina == 1) {

    $xml = file_get_contents($nomex);
    $xml = $nfe->assina($xml);


    $arquivoass = $name;

    file_put_contents($arquivoass, $xml);
    chmod($arquivoass, 0777);
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

    enviaEmail($numero, $ctechave, $protocolo, $cteemicnpj, $motivo, $traemail);
}



pg_close($conn);
exit();

function enviaEmail($numeroEmail, $chaveEmail, $protocoloEmail, $emiEmail, $motEmail, $email) {

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

    $nomedoarquivo = "cancela_cte_" . date("d_m_Y_H_i") . ".txt";
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

    $assunto = "Cancelamento de CT-e " . $numeroEmail;

    $mail->setSubject($assunto);

    $msg .= '<p><span style="font-family:tahoma,geneva,sans-serif;">' . "Esta mensagem refere-se ao Conhecimento de Transporte Eletrônico de número " . $numeroEmail . " cancelado em " . date("d/m/Y") . '</span></p>';

    $msg .= '<p><span style="font-family:tahoma,geneva,sans-serif;">' . "Emitente: " . $emiEmail . '</span></p>';
    $msg .= '<p><span style="font-family:tahoma,geneva,sans-serif;">' . "Motivo: " . $motEmail . '</span></p>';

    $msg .= '<p><span style="font-family:tahoma,geneva,sans-serif;">' . "Chave de acesso: CT-e" . $chaveEmail . '</span></p>';
    $msg .= '<p><span style="font-family:tahoma,geneva,sans-serif;">' . "Protocolo: " . $protocoloEmail . '</span></p>';

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
