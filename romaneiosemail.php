<?php

require_once("include/conexao.inc.php");
require_once("include/romaneios.php");
require("verifica2.php");

//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");
require_once(DIR_ROOT . '/include/classes/JSON/JSON.php');
$json = new Services_JSON();

function logEmail($msg, $nomedoarquivo, $destinatarios, $remetente, $assunto, $mensagem, $data, $reenvio = false) {
    $fp = fopen('/home/delta/pedidos/' . $nomedoarquivo, 'a+');
    fwrite($fp, $msg . " EM " . $data . "\n");
    if ($reenvio) {
        fwrite($fp, "NOVA TENTATIVA DE ENVIO EM 1 HORA.\n");
    }
    fwrite($fp, "DESTINARARIO(S): " . $destinatarios . "\n");
    fwrite($fp, "REMETENTE: " . $remetente . "\n");
    fwrite($fp, "ASSUNTO: " . $assunto . "\n");
    fwrite($fp, "MENSAGEM: " . strip_tags($mensagem) . "\n\n\n");
    fclose($fp);
}

function convertem($term, $tp) {
    if ($tp == "1")
        $palavra = strtr(strtoupper($term), "àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß");
    elseif ($tp == "0")
        $palavra = strtr(strtolower($term), "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß", "àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");
    return $palavra;
}

$romcodigo = $_GET["romcodigo"];
$pvnumero = $_GET["pvnumero"];
$rpvolumes = $_GET["rpvolumes"];

$cadastro = new banco($conn, $db);
//$cadastro->insere("romaneiospedidos","(romcodigo,pvnumero,rpvolumes)","('$romcodigo','$pvnumero','$rpvolumes')");

$mes = date('m');
$dia = date('d');
$ano = date('Y');
$hora = date('H') . date('i');
$data = $mes . '/' . $dia . '/' . $ano . ' ' . $hora;

$sql2 = "SELECT * from pedidosexpedidos where pvnumero = '$pvnumero'";
$sql2 = pg_query($sql2);
$row2 = pg_num_rows($sql2);
if ($row2) {
    
} else {
    //$cadastro->insere("pedidosexpedidos","(pvnumero,pvdatahora)","('$pvnumero','$data')");
}

$pedido = $pvnumero;

$pvtipoped = '';
$clicodigo = 0;

//Localiza o Pedido e Cliente
$sql = "Select pvtipoped,clicodigo FROM pvenda where pvnumero=$pedido ";
$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {
    $pvtipoped = pg_fetch_result($sql, 0, "pvtipoped");
    $clicodigo = pg_fetch_result($sql, 0, "clicodigo");
}

//Não tem mais envio de e-mails 
$pvtipoped = '';

//Se for Abastecimento, Devolução ou Conserto não gera o e-mail
if ($pvtipoped == 'S' || $pvtipoped == 'D' || $pvtipoped == 'C' || $pvtipoped == '') {
    
} else {

    //Usa os dados da tabela de Parametros
    $sqlmail = "Select * from parametrosemail where tipo=6 LIMIT 1";
    //$sqlmail = "Select * from parametrosemail where tipo=1 LIMIT 1";
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

    $nomedoarquivo = "expedicao$pvnumero.txt";
    $acao = "1";
    $id = "'";

    $destinatarios = '';
    $remetente = $from;
    $assunto = '';
    $mensagem = '';

    $data = date("Y-m-d");
    $aux = getdate();
    $data = substr($data, 0, 10) . ' ' . $aux['hours'] . ':' . $aux['minutes'] . ":" . $aux['seconds'] . '-03';

    $path = DIR_ROOT . '/lib';
    set_include_path(get_include_path() . PATH_SEPARATOR . $path);
    require_once("Zend/Loader/Autoloader.php");

    $autoloader = Zend_Loader_Autoloader::getInstance();
    $autoloader->setFallbackAutoloader(true);


    $data = date("d/m/Y H:i:s");

    //configura para envio de email
    if (!$smtpuser) {
        $config = array("auth" => "login", "username" => $paremail, "password" => $parsenha, "port" => $parporta);
    } else {
        $config = array("ssl" => "tls", "auth" => "login", "username" => $smtpuser, "password" => $smtppass, "port" => $parporta);
    }
    $tr = new Zend_Mail_Transport_Smtp($parsmtp, $config);

    Zend_Mail::setDefaultTransport($tr);
    //funcao para envio de email - Zend_Mail
    $mail = new Zend_Mail();

    //$mail->setFrom ($remetente, "Workflow MAXTrade");
    $mail->setFrom($remetente, "Workflow Toymania");

    $email = '';

    if ($clicodigo != 0) {

        $sql = "Select cleemail FROM cliefat where clicodigo=$clicodigo ";
        $sql = pg_query($sql);
        $row = pg_num_rows($sql);
        if ($row) {

            $email = pg_fetch_result($sql, 0, "cleemail");
        }
    }

    if ($email != '') {

        $texto = $email;

        $mails = explode(";", $texto);

        foreach ($mails as $value) {

            if (trim($value)) {

                $mail->addTo(trim(strtolower($value)));
                $destinatarios .= trim(strtolower($value));
            }
        }

        $msg1 = "PEDIDO " . $pvnumero . " ENCAMINHADO PARA EXPEDICAO";

        $msg .= "<br /><b>" . nl2br($msg1) . "</b>";
        $msg = str_replace('_', '', $msg);
        $mail->setSubject($msg1);

        $msg .= "<br /><br /><h5>" . $data . '</ h5>';

        $msg = '';

        $msg .= "
		
		<html xmlns:v='urn:schemas-microsoft-com:vml'
		xmlns:o='urn:schemas-microsoft-com:office:office'
		xmlns:w='urn:schemas-microsoft-com:office:word'
		xmlns:m='http://schemas.microsoft.com/office/2004/12/omml'
		xmlns='http://www.w3.org/TR/REC-html40'>

		<head>
		<meta http-equiv=Content-Type content='text/html; charset=windows-1252'>
		<meta name=ProgId content=Word.Document>
		<meta name=Generator content='Microsoft Word 14'>
		<meta name=Originator content='Microsoft Word 14'>
		<link rel=File-List href='teste_arquivos/filelist.xml'>
		<link rel=Edit-Time-Data href='teste_arquivos/editdata.mso'>

		<link rel=themeData href='teste_arquivos/themedata.thmx'>
		<link rel=colorSchemeMapping href='teste_arquivos/colorschememapping.xml'>

		<style>

		</style>
		
		</head>

		<body lang=PT-BR link=blue vlink=purple style='tab-interval:35.4pt'>

		<div class=WordSection1>

		<p class=MsoNormal style='mso-layout-grid-align:none;text-autospace:none'><span
		style='mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-family:
		Calibri;color:black'><o:p>&nbsp;</o:p></span></p>

		<p class=MsoNormal><o:p>&nbsp;</o:p></p>

		<p class=MsoNormal><o:p>&nbsp;</o:p></p>

		<p class=MsoNormal><o:p>&nbsp;</o:p></p>

		<table class=MsoNormalTable border=1 cellspacing=1 cellpadding=0 width=1160
		 style='width:870.0pt;mso-cellspacing:.7pt;background:#CCCCCC;border:outset #999999 1.0pt;
		 mso-border-alt:outset #999999 .75pt;mso-yfti-tbllook:1184'>
		 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>	 
		  <td width=50 style='width:37.5pt;border:inset #3366CC 1.0pt;mso-border-alt:
		  inset #3366CC .75pt;background:#3366CC;padding:.75pt .75pt .75pt .75pt'>
		  <p class=MsoNormal align=center style='text-align:center'><b><span
		  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
		  'Times New Roman';color:white;mso-fareast-language:PT-BR'>Pedido</span></b><span
		  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
		  'Times New Roman';mso-fareast-language:PT-BR'><o:p></o:p></span></p>
		  </td>
		  <td width=70 style='width:52.5pt;border:inset #3366CC 1.0pt;mso-border-alt:
		  inset #3366CC .75pt;background:#3366CC;padding:.75pt .75pt .75pt .75pt'>
		  <p class=MsoNormal align=center style='text-align:center'><b><span
		  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
		  'Times New Roman';color:white;mso-fareast-language:PT-BR'>Local</span></b><span
		  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
		  'Times New Roman';mso-fareast-language:PT-BR'><o:p></o:p></span></p>
		  </td>
		  <td width=280 style='width:210.0pt;border:inset #3366CC 1.0pt;mso-border-alt:
		  inset #3366CC .75pt;background:#3366CC;padding:.75pt .75pt .75pt .75pt'>
		  <p class=MsoNormal align=center style='text-align:center'><b><span
		  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
		  'Times New Roman';color:white;mso-fareast-language:PT-BR'>Razão Social</span></b><span
		  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
		  'Times New Roman';mso-fareast-language:PT-BR'><o:p></o:p></span></p>
		  </td>
		  <td width=480 style='width:360.0pt;border:inset #3366CC 1.0pt;mso-border-alt:
		  inset #3366CC .75pt;background:#3366CC;padding:.75pt .75pt .75pt .75pt'>
		  <p class=MsoNormal align=center style='text-align:center'><b><span
		  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
		  'Times New Roman';color:white;mso-fareast-language:PT-BR'>Status</span></b><span
		  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
		  'Times New Roman';mso-fareast-language:PT-BR'><o:p></o:p></span></p>
		  </td>
		  <td width=150 style='width:112.5pt;border:inset #3366CC 1.0pt;mso-border-alt:
		  inset #3366CC .75pt;background:#3366CC;padding:.75pt .75pt .75pt .75pt'>
		  <p class=MsoNormal align=center style='text-align:center'><b><span
		  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
		  'Times New Roman';color:white;mso-fareast-language:PT-BR'>Data</span></b><span
		  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
		  'Times New Roman';mso-fareast-language:PT-BR'><o:p></o:p></span></p>
		  </td>	  
		 </tr>";


        $clicnpj = '';

        //Vou localizar o CNPJ do Cliente
        $sql = "Select clicnpj FROM clientes where clicodigo=" . $clicodigo;
        $cad = pg_query($sql);
        $row = pg_num_rows($cad);
        if ($row > 0) {
            $clicnpj = pg_fetch_result($cad, 0, "clicnpj");
        }

        $sql = "Select distinct pvenda.pvnumero as pedido, pvenda.pvtipoped as tipo, pvenda.pvvalor as valor, pvenda.pvvaldesc as valordesc, pvenda.pvemissao as emissao, pvenda.pvencer2 as status, vendedor.vencodigo as vendedorcodigo, vendedor.vennguerra as vendedornguerra, clientes.clirazao as clientenome, clientes.clicod, pvenda.pvlibera
		FROM pvenda
		left join clientes on pvenda.clicodigo = clientes.clicodigo
		left join vendedor on pvenda.vencodigo=vendedor.vencodigo
		where pvenda.pvnumero=" . $pedido . " order by pvenda.pvnumero asc";

        $auxdatainicio = '2000-01-01 00:00:00';
        $auxdatafim = '2100-01-01 00:00:00';

        $cad = pg_query($sql);

        $row = pg_num_rows($cad);

        $valor = 0;

        $k;

        $cor = '#FFF8C6';

        for ($i = 0; $i < $row; $i++) {

            $dataliberacao = '';

            $pedido = pg_fetch_result($cad, $i, "pedido");
            $clientenome = pg_fetch_result($cad, $i, "clientenome");

            if ($pedido == '') {
                $pedido = '0';
            }
            if ($clientenome == '') {
                $clientenome = '0';
            }

            $cor = '#7FFF00';

            $dataliberacao = '';
            //Data da Liberação
            $sql2 = "Select pvlibera from pvenda where pvnumero = $pedido and (pvlibera between '$auxdatainicio' and '$auxdatafim')";
            $cad2 = pg_query($sql2);
            $row2 = pg_num_rows($cad2);
            if ($row2 > 0) {
                $data = pg_fetch_result($cad2, 0, "pvlibera");
                $dataliberacao = $data;
            }

            $nfg = 0;
            $trg = '';

            //A. Verifica se existe nota em guarulhos para o pedido em qualquer data
            $sql2 = "Select cast(a.notnumero as integer) as notnumero,a.notemissao,t.trarazao from notagua a Left Join transportador as t on a.tracodigo = t.tracodigo where a.pvnumero = $pedido";
            $cad2 = pg_query($sql2);
            $row2 = pg_num_rows($cad2);
            if ($row2 > 0) {
                $data = pg_fetch_result($cad2, 0, "notemissao");
                $nfg = pg_fetch_result($cad2, 0, "notnumero");
                $trg = pg_fetch_result($cad2, 0, "trarazao");
            }

            $nfv = 0;
            $trv = '';

            //B. Verifica se existe nota em vix para o pedido em qualquer data
            $sql2 = "Select cast(a.notnumero as integer) as notnumero,a.notemissao,t.trarazao from notavit a Left Join transportador as t on a.tracodigo = t.tracodigo where a.pvnumero = $pedido";
            $cad2 = pg_query($sql2);
            $row2 = pg_num_rows($cad2);
            if ($row2 > 0) {
                $data = pg_fetch_result($cad2, 0, "notemissao");
                $nfv = pg_fetch_result($cad2, 0, "notnumero");
                $trv = pg_fetch_result($cad2, 0, "trarazao");
            }

            $primeiro = 0;

            //0.Verifica na Tabela de Romaneios se Foi Entregue Guarulhos
            $sql2 = "Select b.romdata,b.romrecebedor from romaneiospedidos b where b.pvnumero = $pedido and (b.romdata between '$auxdatainicio' and '$auxdatafim')";

            $cad2 = pg_query($sql2);
            $row2 = pg_num_rows($cad2);
            if ($row2 > 0) {
                $data = pg_fetch_result($cad2, 0, "romdata");
                $recebedor = pg_fetch_result($cad2, 0, "romrecebedor");
                $status = "ENTREGA RECEBIDA POR " . $recebedor;

                if ($primeiro == 0) {
                    $k++;

                    $msg .= "<tr style='mso-yfti-irow:1'>				  
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:chartreuse;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $pedido . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:chartreuse;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>TRANSPORTADORA<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:chartreuse;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $clientenome . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:chartreuse;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $status . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:chartreuse;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4) . substr($data, 10, 6) . "<o:p></o:p></span></p>
					  </td>				  
					 </tr>";

                    $primeiro = 1;
                } else {
                    $msg .= "<tr style='mso-yfti-irow:1'>				  
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:chartreuse;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>&nbsp;<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:chartreuse;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>TRANSPORTADORA<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:chartreuse;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>&nbsp;<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:chartreuse;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $status . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:chartreuse;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4) . substr($data, 10, 6) . "<o:p></o:p></span></p>
					  </td>				  
					 </tr>";
                }
            }

            //0.Verifica na Tabela de Romaneios se Foi Entregue Vix
            $sql2 = "Select b.romdata,b.romrecebedor from romaneiospedidosvit b where b.pvnumero = $pedido and (b.romdata between '$auxdatainicio' and '$auxdatafim')";

            $cad2 = pg_query($sql2);
            $row2 = pg_num_rows($cad2);
            if ($row2 > 0) {
                $data = pg_fetch_result($cad2, 0, "romdata");
                $recebedor = pg_fetch_result($cad2, 0, "romrecebedor");
                $status = "ENTREGA RECEBIDA POR " . $recebedor;

                if ($primeiro == 0) {
                    $k++;

                    $msg .= "<tr style='mso-yfti-irow:1'>				  
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:chartreuse;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $pedido . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:chartreuse;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>TRANSPORTADORA<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:chartreuse;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $clientenome . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:chartreuse;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $status . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:chartreuse;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4) . substr($data, 10, 6) . "<o:p></o:p></span></p>
					  </td>				  
					 </tr>";

                    $primeiro = 1;
                } else {
                    $msg .= "<tr style='mso-yfti-irow:1'>				  
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:chartreuse;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>&nbsp;<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:chartreuse;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>TRANSPORTADORA<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:chartreuse;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>&nbsp;<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:chartreuse;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $status . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:chartreuse;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4) . substr($data, 10, 6) . "<o:p></o:p></span></p>
					  </td>				  
					 </tr>";
                }
            }


            $cor = '#6495ED';

            //G. Verifica se está em algum romaneio de Guarulhos
            $sql2 = "Select a.romdata from romaneios a,romaneiospedidos b where b.pvnumero = $pedido and a.romcodigo = b.romcodigo and (a.romdata between '$auxdatainicio' and '$auxdatafim')";

            $cad2 = pg_query($sql2);
            $row2 = pg_num_rows($cad2);
            if ($row2 > 0) {
                $data = pg_fetch_result($cad2, 0, "romdata");
                $status = "ENCAMINHADO PARA EXPEDIÇÃO";

                if ($primeiro == 0) {
                    $k++;
                    $msg .= "<tr style='mso-yfti-irow:1'>				  
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $pedido . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>LOGISTICA<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $clientenome . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $status . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4) . substr($data, 10, 6) . "<o:p></o:p></span></p>
					  </td>				  
					 </tr>";

                    $primeiro = 1;
                } else {
                    $msg .= "<tr style='mso-yfti-irow:1'>				  
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>&nbsp;<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>LOGISTICA<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>&nbsp;<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $status . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4) . substr($data, 10, 6) . "<o:p></o:p></span></p>
					  </td>				  
					 </tr>";
                }
            }

            //H. Verifica se está em algum romaneio de Vix
            $sql2 = "Select a.romdata from romaneiosvit a,romaneiospedidosvit b where b.pvnumero = $pedido and a.romcodigovit = b.romcodigo and (a.romdata between '$auxdatainicio' and '$auxdatafim')";

            $cad2 = pg_query($sql2);
            $row2 = pg_num_rows($cad2);
            if ($row2 > 0) {
                $data = pg_fetch_result($cad2, 0, "romdata");
                $status = "ENCAMINHADO PARA EXPEDIÇÃO";

                if ($primeiro == 0) {
                    $k++;
                    $msg .= "<tr style='mso-yfti-irow:1'>				  
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $pedido . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>LOGISTICA<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $clientenome . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $status . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4) . substr($data, 10, 6) . "<o:p></o:p></span></p>
					  </td>				  
					 </tr>";

                    $primeiro = 1;
                } else {
                    $msg .= "<tr style='mso-yfti-irow:1'>				  
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>&nbsp;<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>LOGISTICA<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>&nbsp;<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $status . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4) . substr($data, 10, 6) . "<o:p></o:p></span></p>
					  </td>				  
					 </tr>";
                }
            }


            //I. Se tiver data de Liberação mas sem nota emitida 
            if ($dataliberacao != '' && $nfg == 0 && $nfv == 0) {
                $data = $dataliberacao;
                $status = "AGUARDANDO EMISSÃO DE NF";
                if ($primeiro == 0) {
                    $k++;
                    $msg .= "<tr style='mso-yfti-irow:1'>				  
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $pedido . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>LOGISTICA<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $clientenome . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $status . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4) . substr($data, 10, 6) . "<o:p></o:p></span></p>
					  </td>				  
					 </tr>";

                    $primeiro = 1;
                } else {
                    $msg .= "<tr style='mso-yfti-irow:1'>				  
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>&nbsp;<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>LOGISTICA<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>&nbsp;<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $status . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4) . substr($data, 10, 6) . "<o:p></o:p></span></p>
					  </td>				  
					 </tr>";
                }
            }

            $nfg = 0;
            $trg = '';

            //J. Verifica se existe nota em guarulhos para o pedido
            $sql2 = "Select cast(a.notnumero as integer) as notnumero,a.notemissao,t.trarazao from notagua a Left Join transportador as t on a.tracodigo = t.tracodigo where a.pvnumero = $pedido and (a.notemissao between '$auxdatainicio' and '$auxdatafim')";
            $cad2 = pg_query($sql2);
            $row2 = pg_num_rows($cad2);
            if ($row2 > 0) {
                $data = pg_fetch_result($cad2, 0, "notemissao");
                $nfg = pg_fetch_result($cad2, 0, "notnumero");
                $trg = pg_fetch_result($cad2, 0, "trarazao");
                $status = "EMISSÃO DA NF " . $nfg;

                if ($primeiro == 0) {
                    $k++;
                    $msg .= "<tr style='mso-yfti-irow:1'>				  
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $pedido . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>LOGISTICA<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $clientenome . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $status . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4) . substr($data, 10, 6) . "<o:p></o:p></span></p>
					  </td>				  
					 </tr>";

                    $primeiro = 1;
                } else {
                    $msg .= "<tr style='mso-yfti-irow:1'>				  
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>&nbsp;<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>LOGISTICA<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>&nbsp;<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $status . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4) . substr($data, 10, 6) . "<o:p></o:p></span></p>
					  </td>				  
					 </tr>";
                }
            }

            $nfv = 0;
            $trv = '';

            //K. Verifica se existe nota em vix para o pedido
            $sql2 = "Select cast(a.notnumero as integer) as notnumero,a.notemissao,t.trarazao from notavit a Left Join transportador as t on a.tracodigo = t.tracodigo where a.pvnumero = $pedido and (a.notemissao between '$auxdatainicio' and '$auxdatafim')";
            $cad2 = pg_query($sql2);
            $row2 = pg_num_rows($cad2);
            if ($row2 > 0) {
                $data = pg_fetch_result($cad2, 0, "notemissao");
                $nfv = pg_fetch_result($cad2, 0, "notnumero");
                $trv = pg_fetch_result($cad2, 0, "trarazao");
                $status = "EMISSÃO DA NF " . $nfv;

                if ($primeiro == 0) {
                    $k++;
                    $msg .= "<tr style='mso-yfti-irow:1'>				  
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $pedido . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>LOGISTICA<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $clientenome . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $status . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4) . substr($data, 10, 6) . "<o:p></o:p></span></p>
					  </td>				  
					 </tr>";

                    $primeiro = 1;
                } else {
                    $msg .= "<tr style='mso-yfti-irow:1'>				  
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>&nbsp;<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>LOGISTICA<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>&nbsp;<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $status . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:cornflowerblue;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4) . substr($data, 10, 6) . "<o:p></o:p></span></p>
					  </td>				  
					 </tr>";
                }
            }

            //$cor = '#FA8072';

            $cor = '#FFA500';

            //L. Verifica se o pedido está Liberado
            $sql2 = "Select pvlibera from pvenda where pvnumero = $pedido and (pvlibera between '$auxdatainicio' and '$auxdatafim')";
            $cad2 = pg_query($sql2);
            $row2 = pg_num_rows($cad2);
            if ($row2 > 0) {
                $data = pg_fetch_result($cad2, 0, "pvlibera");
                $dataliberacao = $data;
                $status = "LIBERADO PARA PRODUÇÃO";

                if ($primeiro == 0) {
                    $k++;
                    $msg .= "<tr style='mso-yfti-irow:1'>				  
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $pedido . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>ADMINISTRATIVO<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $clientenome . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $status . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4) . substr($data, 10, 6) . "<o:p></o:p></span></p>
					  </td>				  
					 </tr>";

                    $primeiro = 1;
                } else {
                    $msg .= "<tr style='mso-yfti-irow:1'>				  
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>&nbsp;<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>ADMINISTRATIVO<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>&nbsp;<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $status . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4) . substr($data, 10, 6) . "<o:p></o:p></span></p>
					  </td>				  
					 </tr>";
                }
            }

            //M. Verifica se o pedido está análise no administrativo
            $sql2 = "Select pvliberanegado from pvenda where pvnumero = $pedido and (pvliberanegado between '$auxdatainicio' and '$auxdatafim')";
            $cad2 = pg_query($sql2);
            $row2 = pg_num_rows($cad2);
            if ($row2 > 0) {
                $data = pg_fetch_result($cad2, 0, "pvliberanegado");
                $status = "RETORNO PARA ANÁLISE ADMINISTRATIVO";

                if ($primeiro == 0) {
                    $k++;
                    $msg .= "<tr style='mso-yfti-irow:1'>				  
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $pedido . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>ADMINISTRATIVO<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $clientenome . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $status . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4) . substr($data, 10, 6) . "<o:p></o:p></span></p>
					  </td>				  
					 </tr>";

                    $primeiro = 1;
                } else {
                    $msg .= "<tr style='mso-yfti-irow:1'>				  
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>&nbsp;<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>ADMINISTRATIVO<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>&nbsp;<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $status . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4) . substr($data, 10, 6) . "<o:p></o:p></span></p>
					  </td>				  
					 </tr>";
                }
            }

            //N. Verifica se o pedido está pendente em análise no filtro
            $sql2 = "Select pvliberapendente from pvenda where pvnumero = $pedido and (pvliberapendente between '$auxdatainicio' and '$auxdatafim')";
            $cad2 = pg_query($sql2);
            $row2 = pg_num_rows($cad2);
            if ($row2 > 0) {
                $data = pg_fetch_result($cad2, 0, "pvliberapendente");
                $status = "PENDENTE EM ANÁLISE DE CREDITO";

                if ($primeiro == 0) {
                    $k++;
                    $msg .= "<tr style='mso-yfti-irow:1'>				  
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $pedido . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>ADMINISTRATIVO<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $clientenome . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $status . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4) . substr($data, 10, 6) . "<o:p></o:p></span></p>
					  </td>				  
					 </tr>";

                    $primeiro = 1;
                } else {
                    $msg .= "<tr style='mso-yfti-irow:1'>				  
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>&nbsp;<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>ADMINISTRATIVO<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>&nbsp;<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $status . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4) . substr($data, 10, 6) . "<o:p></o:p></span></p>
					  </td>				  
					 </tr>";
                }
            }

            //O. Verifica se o envio para financeiro está no filtro
            $sql2 = "Select pvliberafinanceiro from pvenda where pvnumero = $pedido and (pvliberafinanceiro between '$auxdatainicio' and '$auxdatafim')";
            $cad2 = pg_query($sql2);
            $row2 = pg_num_rows($cad2);
            if ($row2 > 0) {
                $data = pg_fetch_result($cad2, 0, "pvliberafinanceiro");
                $status = "EM ANALISE DE CRÉDITO";

                if ($primeiro == 0) {
                    $k++;
                    $msg .= "<tr style='mso-yfti-irow:1'>				  
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $pedido . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>ADMINISTRATIVO<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $clientenome . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $status . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4) . substr($data, 10, 6) . "<o:p></o:p></span></p>
					  </td>				  
					 </tr>";

                    $primeiro = 1;
                } else {
                    $msg .= "<tr style='mso-yfti-irow:1'>				  
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>&nbsp;<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>ADMINISTRATIVO<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>&nbsp;<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $status . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4) . substr($data, 10, 6) . "<o:p></o:p></span></p>
					  </td>				  
					 </tr>";
                }
            }

            //69091
            //65451
            //P. Faz uma verificação se a emissão do pedido está no filtro:
            $sql2 = "Select pvemissao from pvenda where pvnumero = $pedido and (pvemissao between '$auxdatainicio' and '$auxdatafim')";
            $cad2 = pg_query($sql2);
            $row2 = pg_num_rows($cad2);
            if ($row2 > 0) {
                $data = pg_fetch_result($cad2, 0, "pvemissao");
                $status = "ANÁLISE ADMINISTRATIVO";

                if ($primeiro == 0) {
                    $k++;
                    $msg .= "<tr style='mso-yfti-irow:1'>				  
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $pedido . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>ADMINISTRATIVO<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $clientenome . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $status . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4) . substr($data, 10, 6) . "<o:p></o:p></span></p>
					  </td>				  
					 </tr>";

                    $primeiro = 1;
                } else {
                    $msg .= "<tr style='mso-yfti-irow:1'>				  
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>&nbsp;<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>ADMINISTRATIVO<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>&nbsp;<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . $status . "<o:p></o:p></span></p>
					  </td>
					  <td style='border:inset #999999 1.0pt;mso-border-alt:inset #999999 .75pt;
					  background:orange;padding:.75pt .75pt .75pt .75pt'>
					  <p class=MsoNormal align=center style='text-align:center'><span
					  style='font-size:12.0pt;font-family:'Times New Roman','serif';mso-fareast-font-family:
					  'Times New Roman';mso-fareast-language:PT-BR'>" . substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4) . substr($data, 10, 6) . "<o:p></o:p></span></p>
					  </td>				  
					 </tr>";
                }
            }
        }

        $msg .= "
		</table>
		<p class=MsoNormal><o:p>&nbsp;</o:p></p>
		</div>
		</body>
		</html>
		";

        $mail->setBodyHTML($msg);


        try {
            $mail->send();

            logEmail("EMAIL ENCAMINHADO ", $nomedoarquivo, $texto, $remetente, $assunto, $mensagem, date("Y-m-d H:i:s"));
            //print true;
        } catch (Exception $e) {

            //print false;

            logEmail("NAO FOI POSSIVEL ENVIAR O EMAIL" . $e->getMessage(), $nomedoarquivo, $texto, $remetente, $assunto, $mensagem, date("Y-m-d H:i:s"), true);
        }
    }
}


pg_close($conn);
exit();
?>
