<?php
/**
* Arquivo de a??es da Interface de estacionamento de Pedidos.
*
* Controla as a??es ocorridas na interface chamadas pelo jquery.
* Procure na pasta view/js as a??es jquery.
* Este arquivo segue os padroes estabelecidos no dTrade.
*
* @name Pedidos Adm View - Get Estacionamento
* @category Pedidos
* @package modulos/vendaAtacado/pedidos/adm/controller
* @link modulos/vendaAtacado/pedidos/adm/controller/getEsacionamento.php
* @version 1.0
* @since Criado 19/05/2010
* @author Wellington <wellington@centroatacadista.com.br>
* @copyright MaxTrade
*/
	//pega da pasta de istalacao
	$arr = explode("/", $_SERVER[REQUEST_URI]);
	$root = $arr[1];

	//pega as configura??es do servidor
	require_once($_SERVER[DOCUMENT_ROOT]."/$root/include/config.php");
	require_once(DIR_ROOT.'/include/classes/JSON/JSON.php');
	require_once (DIR_ROOT.'/modulos/vendaAtacado/pedidos/adm/model/EstacionamentoModel.php');
        require_once(DIR_ROOT.'/include/funcoes/removeCaracterEspecial.php');

	$json = new Services_JSON();
	$pvnumero = $_POST["pvnumero"];
	$situacao = $_POST["situacao"];
	$observacao = $_POST["observacao"];
	$txtMail = $_POST['txtMail'];
	$from = trim(strtolower($_POST['from']));
        $nomedoarquivo = "pedido$pvnumero.txt";
	$acao = $_POST['acao'];
	$id = $_POST['id'];
	$msgSelecionadas = explode(",",$_POST['msgSelecionadas']);
        $msgPadrao = '<ul>';
        $destinatarios = '';
        $remetente = $from;
        $assunto = '';
        $mensagem = '';

        $model = new EstacionamentoModel();
	print $json->encode($model->alteraSituacaoPedido($pvnumero, $situacao, $observacao));

	$path = DIR_ROOT.'/lib';
    set_include_path ( get_include_path () . PATH_SEPARATOR . $path );

    require_once("Zend/Loader/Autoloader.php");

   if ($observacao !== 'undefined' && $observacao != '' && $observacao != null) {
    $autoloader = Zend_Loader_Autoloader::getInstance ();
    $autoloader->setFallbackAutoloader ( true );


	$data = date("d/m/Y H:i:s");


	//configura para envio de email
//	$config = array ("auth"=>"login", "username"=>"maxtrade@centroatacadista.com.br", "password"=>"centro10");
	//$config = array ("auth"=>"login", "username"=>"wellington@centroatacadista.com.br", "password"=>"centro");
        $config = array ("auth"=>"login", "username"=>"maxtrade@baraodistribuidor.com.br", "password"=>"centro");
//	$tr = new Zend_Mail_Transport_Smtp ('smtp.terra.com.br', $config);
        $tr = new Zend_Mail_Transport_Smtp ('smtp.baraodistribuidor.com.br', $config);

	Zend_Mail::setDefaultTransport($tr);
	//funcao para envio de email - Zend_Mail
	$mail = new Zend_Mail();
	//$mail->setFrom ("$from", "MAXTrade");
//	$mail->setFrom ( "maxtrade@centroatacadista.com.br", "Maxtrade" );
        $mail->setFrom ("maxtrade@baraodistribuidor.com.br", "MAXTrade");


	$mails = explode(";", $txtMail);

	foreach($mails as $value)
	{

             if(trim($value))
	    {

	        $mail->addTo(trim(strtolower($value)));
                $destinatarios .= trim(strtolower($value));
	    }
//	    if(trim($value))
//	    {
//	        //$mail->addTo(trim($value));
//	        $msg .= (trim($value));
//	    }
	}

         $mail->addTo($from);

         foreach ($msgSelecionadas as $value) {
             switch ($value) {
                 case 1: $msgPadrao .= '<li>Dados Cadastrais</li>';
                     break;
                 case 2: $msgPadrao .= '<li>Boletos | Notas Fiscais</li>';
                     break;
                 case 3: $msgPadrao .= '<li>Carta de Anuencia</li>';
                     break;
                 case 4: $msgPadrao .= '<li>Contrato Social</li>';
                     break;
                 case 5: $msgPadrao .= '<li>Titulos Vencidos</li>';
                     break;
                 case 6: $msgPadrao .= '<li>Excedeu o Prazo para entrega de documento(s)</li>';
                     break;
                 case 7: $msgPadrao .= '<li>Restricoes na praca</li>';
                     break;
                 case 8: $msgPadrao .= '<li>Titulo(s) vencido(s)</li>';
                     break;
                 case 9: $msgPadrao .= '<li>Vinculo(s) com restricoes</li>';
                     break;
                 case 10: $msgPadrao .= '<li>Vinculo(s) com titulo em atraso</li>';
                     break;
                }
         }
	//$mail->addTo ('douglascavalini@gmail.com');
	if($situacao=='4')
	{
//	$msg = "Pedido numero $pvnumero contem as seguintes pendencias para sua liberacao!";
	$msg = "Estamos solicitando ao cliente informacoes para finalizar analise de credito, conforme segue abaixo:";
        $mensagem .= $msg;

            if ( $msgPadrao != '<ul>') {
                    $msg .= "<br />" . $msgPadrao .= '</ul>';
                } else {
                    $msgPadrao = '';
                }

        $msg .= "<br />" . nl2br($observacao);
        $msg = str_replace('_','',$msg);
	$mail->setSubject("Administra??o de Pedidos - Pendencias Pedido $pvnumero");
        $msg .= "<br /><br /><strong>Atencao:</strong> informamos que o nao envio das solicitacoes apos tres dias o pedido sera negado";

            $assunto .= "Administra??o de Pedidos - Pendencias Pedido \n";
	}
	if($situacao=='5')
	{
//		$msg = "Pedido numero $pvnumero foi negado para sua liberacao!";
		$msg = "Pedido numero $pvnumero foi negado pelos seguintes motivos: <br />";
                $mensagem .= $msg;
                if ( $msgPadrao != '<ul>') {
                    $msg .= "<br />" . $msgPadrao .= '</ul>';
                } else {
                    $msgPadrao = '';
                }
                $msg .= "<br />" . nl2br($observacao);
                $msg = str_replace('_','',$msg);
		$mail->setSubject("Administra??o de Pedidos - Pedido $pvnumero negado");
                $assunto .= "Administra??o de Pedidos - Pedido $pvnumero negado\n";
	}
	if($situacao=='22')
	{
		$msg = "Pedido liberado.";
                $mensagem .= $msg;
		$mail->setSubject("Administra??o de Pedidos - Autorizado Pedido $pvnumero");
                $assunto .= "Administra??o de Pedidos - Autorizado Pedido $pvnumero\n";
	}
//	$msg .= "<br /><br />" . nl2br($observacao);
	$msg .= "<br /><br /><h5>" . $data .'</ h5>';
	$mail->setBodyHTML($msg);
        $mensagem .= $msgPadrao . "\n". $observacao;
        $mensagem = str_replace('<li>','    ',$mensagem);




        try {
            $mail->send();
//             $fp = fopen('/home/delta/logpedidos/' . $nomedoarquivo, 'a+');
            $fp = fopen('/home/delta/interfix/' . $nomedoarquivo, 'a+');
             fwrite($fp, "EMAIL ENCAMINHADO EM: ".$data. "\n");
             fwrite($fp, "DESTINARARIO(S): ".$destinatarios. "\n");
             fwrite($fp, "REMETENTE: ".$remetente. "\n");
             fwrite($fp, "ASSUNTO: ".$assunto. "\n");
             fwrite($fp, "MENSAGEM: ". strip_tags($mensagem) . "\n\n\n");
             fclose($fp);

//            print true;
        }catch (Exception $e) {
//            print false;
            $fp = fopen('/home/delta/interfix/' . $nomedoarquivo, 'a+');
             fwrite($fp, "Nao foi possivel enviar o email. Erro: \n". $e->getMessage(). "\n");

             fclose($fp);
        }
//	$mail->send();

	//print true;



}











	if($acao=='1')
	{
	print $json->encode($model->verificaPrefechamento2($id));
	}
	?>
