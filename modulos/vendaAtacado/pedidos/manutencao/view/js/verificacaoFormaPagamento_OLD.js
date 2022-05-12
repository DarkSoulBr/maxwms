/**
 * @author Wellington
 *
 * Verificação dos dados para envio de formulario.
 *
 * Criação    15/12/2009
 * Modificado 15/12/2009
 *
 */

$(function()
{
	var dataAtual = new Date();
	var stringDate = dataAtual.format('dmY');
	jsTxt = new Object();
	var tblFormaPagamento = new Array();
	//condicaoComercialPrefechamento = new Object();
	result = '0.000';
	valorDuplicata = '0';
	$('#listaCondicoesComerciais').hide();
	//verificação das formas de pagamento

	$('input[name=opcaoVencimento]').click(function()
	{
		var id = $('input[name=opcaoVencimento]:checked').val();
		$('#formFormaPagamento').validate().resetForm();
		switch(id)
		{
			case '1':
				$('#divOpcaoVencimento').html('<input name="txtDiasVencimento" id="txtDiasVencimento" type="text" size="4" maxlength="3">');
				$('#txtDiasVencimento').attr('disabled','');
				$('#txtDataVencimento').attr('disabled','disabled');
				$('#txtDiasVencimento').val('');
				$('#txtDataVencimento').val($.mask.string(stringDate, 'date'));
				$('#txtDiasVencimento').focus();
				break;

			case '2':
				$('#divOpcaoVencimento').html('<input name="txtDataVencimento" id="txtDataVencimento" type="text" size="12" disabled="disabled">');
				$('#txtDiasVencimento').attr('disabled','disabled');
				$('#txtDataVencimento').attr('disabled','');
				$('#txtDiasVencimento').val('');
				$('#txtDataVencimento').val($.mask.string(stringDate, 'date'));
				$('#txtDataVencimento').focus();
				break;
		}
	});

	pedidoValor='0';

	$("#listaPesquisaPedidos").ajaxComplete(function()
			{


                /*
		if(pedido.cliente.clifat=='3')
		{
			alert('CLIENTE COM CREDITO PROIBIDO. ENTRE EM CONTATO COM O FINANCEIRO');
		$('#formFormaPagamento').hide();
		$('#btnLiberacaoPedido').attr('disabled','disabled');
		}else
			if(pedido.cliente.clifat!='3')
		{
			$('#formFormaPagamento').show();
			$('#btnLiberacaoPedido').attr('disabled','');
		}*/

		if(pedido.tipoPedido.sigla=='R'  && pedido.fecreserva=='1')
		{

			$('#dialog').attr('title','FECHAMENTO DE PEDIDO');

			var mensagem = "PEDIDO DO TIPO RESERVA COM FECHAMENTO NO MAE: NAO PRECISA DE PREFECHAMENTO";

			var html = '<p>'+
			'<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>'+
			mensagem;

			$('#dialog').html(html);

			$('#dialog').dialog(
			{
				autoOpen: true,
				modal: true,
				width: 480,
				buttons:
				{


					"FECHAR": function()
					{
						$(this).dialog("close");
					}
				},
				close: function(ev, ui)
				{
					$(this).dialog("destroy");
				}
			});

		}

	//pedidoValor = (pedido.pvvalor-pedido.pvvaldesc);
		 if(pedido.tipoPedido.sigla=='I' && pedido.pvvinculo!=null)
		 {
			 pedidoValor = (pedido.pvvalor-pedido.pvvaldesc);
		 }else{
			 $.each(pedido.itensPedido, function (key, value)
						{
				 if(value.pedidoVendaItemEstoque.pviest011 > '0')
				 {
					 estoqueOrigem = "VIX";
				 }else
				 {
					 estoqueOrigem = "SP";
				 }

						});
			/*
			if(pedido.itensPedido[0].estoques[0].estoqueAtual.estoque.etqcodigo=='11' || pedido.itensPedido[0].estoques[0].estoqueAtual.estoque.etqcodigo=='17' || pedido.itensPedido[0].estoques[0].estoqueAtual.estoque.etqcodigo=='24')
			{
				estoqueOrigem = "VIX";
			}else{
				estoqueOrigem = "SP";

			}*/
		estoqueDestino = pedido.cliente.enderecoFaturamento.cidade.uf;

		if((estoqueOrigem=="SP" && estoqueDestino=="BA") || (estoqueOrigem=="SP" && estoqueDestino=="MG") || (estoqueOrigem=="SP" && estoqueDestino=="RS"))
		{
			pedidoValor = (pedido.pvvalor-pedido.pvvaldesc) + pedido.calculoSt.substituicao;
		}else
			if((estoqueOrigem=="SP" && estoqueDestino=="SC") || (estoqueOrigem=="SP" && estoqueDestino=="RJ"))
			{
				pedidoValor = (pedido.pvvalor-pedido.pvvaldesc);
			}else
			if((estoqueOrigem=="ES" && estoqueDestino=="BA") || (estoqueOrigem=="ES" && estoqueDestino=="MG") || (estoqueOrigem=="ES" && estoqueDestino=="SC") || (estoqueOrigem=="ES" && estoqueDestino=="RJ") || (estoqueOrigem=="ES" && estoqueDestino=="RS"))
		{
			pedidoValor = (pedido.pvvalor-pedido.pvvaldesc);
		}else{
			pedidoValor = (pedido.pvvalor-pedido.pvvaldesc);
		}
		 }


		//$pedido->itensPedido[0]->estoques[0]->estoqueAtual->estoque->etqcodigo=='11' OR $pedido->itensPedido[0]->estoques[0]->estoqueAtual->estoque->etqcodigo=='17' OR $pedido->itensPedido[0]->estoques[0]->estoqueAtual->estoque->etqcodigo=='24')
		//pedidoValor = (pedido.calculoSt.notavalor);
		valorPedidoSemSt = pedido.pvvalor-pedido.pvvaldesc;

	$('#txtValorSt').val($.mask.string(parseFloat(pedido.calculoSt.substituicao).toFixed(2), 'decimal'));
	$('#txtValorPedidoSemSt').val($.mask.string(parseFloat(valorPedidoSemSt).toFixed(2), 'decimal'));

        totalValorPreFechamento = 0;
                                        if (pedido.preFechamento !== undefined && pedido.preFechamento !== null && pedido.preFechamento !== "") {
                                                                                 $.each(pedido.preFechamento, function (key, value) {
                                                                                                if (value.fecforma != '100' && value.fecforma != '102' && value.fecforma != '105' && value.fecforma != '106'  && value.fecforma != '111' && value.fecforma != '112') {
                                                                                                        totalValorPreFechamento += Number(value.fecvalor);

                                                                                                }
                                                                                 });

                                        }

//        limiteDisponivel = Number(pedido.cliente.clilimite) - Number(pedido.cliente.vendasEmAberto.totalVendas)-Number(totalValorPreFechamento);
        limiteDisponivel = Number(pedido.cliente.clilimite) - Number(pedido.cliente.vendasEmAberto.cobrancaAberto)-Number(totalValorPreFechamento);
        $('#lblTotalLimiteDisponivel').text(parseFloat(limiteDisponivel).toFixed(2));

	$("#btnIncluirFormaPagamento").attr('disabled','');
	tblFormaPagamento['tabela'] ='<table id="listaParcelas">' +
								 '<thead>' +
								 '<tr>' +
								 '<th>Forma Pagto</th>'+
								 '<th>Docto</th>'+
								 '<th>Valor</th>'+
								 '<th>Data</th>'+
								 '<th>Vencto</th>'+
								 '<th>Dias</th>'+
								 '<th>Banco</th>'+
								 '<th>Agencia</th>'+
								 '<th>Conta</v>'+
								 '<th>Ação</th>'+
								 '</tr>'+
								 '</thead>' +
								 '<tbody>';
	$.each(pedido.preFechamento, function (key, value)
			{

		hE = '<input type="hidden" id=pedido.preFechamento'+value.prefeccodigo+' value='+JSON.stringify(value)+'/>';


		if(value.fecforma==100)
		{
			fecforma = "100 - A VISTA";
		}
		else
			if(value.fecforma==101)
			{
				fecforma = "101 - DUPLICATAS";
			}
		else
			if(value.fecforma==102)
			{
				fecforma = "102 - CARTÃO";
			}
		else
			if(value.fecforma==103)
			{
				fecforma = "103 - CHEQUE PRE";
			}
		else
			if(value.fecforma==104)
			{
				fecforma = "104 - ORDEM PAGTO";
			}
		else
			if(value.fecforma==105)
			{
				fecforma = "105 - VALES";
			}
		else
			if(value.fecforma==106)
			{
				fecforma = "106 - BRINDES";
			}
		else
			if(value.fecforma==111)
			{
				fecforma = "111 - DESCONTOS COMERCIAIS";
			}
		else
			if(value.fecforma==112)
			{
				fecforma = "112 - DESCONTOS FINANCEIRO";
			}


		else
            if(value.fecforma==110)
            {
                fecforma = "110 - CHEQUE A VISTA";
            }
		if(value.fecvecto==null || value.fecvecto==0)
		{
			value.fecvecto= 0;
		}else
			if(value.fecdia==null || value.fecdia==0)
			{
				value.fecdia= 0;
			}
		if(value.fecbanco=="" ||value.fecbanco==null)
		{
			value.fecbanco='0';
		}

		if(value.fecconta=="" ||value.fecconta==null)
		{
			value.fecconta='0';
		}

		if(value.fecagencia=="" ||value.fecagencia==null)
		{
			value.fecagencia='0';
		}
		if(value.fecdocto=="" ||value.fecdocto==null)
		{
			value.fecdocto='0';
		}
		cont = pedido.preFechamento.length;
		for(i=1; i<cont; i++)
		{
		}
	tblFormaPagamento['tabela'] +='<tr style="background-color: white">' +
								  '<td>'+ fecforma +'</td><td>';

								  if(value.fecforma!='102')
								  {
									  if(value.fecforma!='105')
									  {
									  tblFormaPagamento['tabela'] +='<input type="text" name="fecdocto" id="fecdocto'+value.prefeccodigo+'" value="'+value.fecdocto+'" size="10">';
									  }
									  else
										  if(value.fecforma=='105')
										  {
											  tblFormaPagamento['tabela'] +='<input type="text" name="fecdocto" id="fecdocto'+value.prefeccodigo+'" value="'+value.fecdocto+'" size="10" disabled>';
										  }
								  }
								  else
									  if(value.fecforma=='102')
									  {

//$('#listaBandeirasCartoes'+i+'').populaBandeirasCartoes();
//   $('#listaBandeirasCartoes'+i+'').populaBandeirasCartoes();  selected where value = value.fecforma
//   PEGAR O fecforma selecionado $('#selectBox option[value=C]').attr('selected', 'selected');

//        $("#fecdocto"+value.prefeccodigo +"option[value="+value.feccartao+"]").attr('selected', 'selected');

										  tblFormaPagamento['tabela'] +='<select id="fecdocto'+value.prefeccodigo+'" name="fecdocto">';

                                                                                //altera para selecionado o cartao selecionado no prefechamento
                                                                                var opt = $("#listaBandeirasCartoesBase option:selected");
                                                                                var html2 = $("<div>").append(opt.clone()).html();
                                                                                html2 = html2.replace(' selected="selected"', '');
                                                                                opt.replaceWith(html2);

                                                                                opt = $("#listaBandeirasCartoesBase option[value="+value.feccartao+"]");
                                                                                html3 = $("<div>").append(opt.clone()).html();
                                                                                html3 = html3.replace(/\>/, ' selected="selected">');
                                                                                opt.replaceWith(html3);

                                                                                tblFormaPagamento['tabela'] += $('#listaBandeirasCartoesBase').html();


//  $("#fecdocto375330 [value=6]").attr('selected', 'selected');
//var select = document.getElementById("listaBandeirasCartoesBase");

//                                                                                  $("#listaBandeirasCartoesBase [value=6]").attr('selected', 'selected');

//$('#listaBandeirasCartoesBase option').clone().appendTo("#fecdocto"+value.prefeccodigo);
//$('.hello').clone().appendTo('.goodbye');



//										 '<option value="0"> SELECIONE O CARTAO </option>';
//											 if(value.feccartao==1)
//											 {
//
//
//												 tblFormaPagamento['tabela'] += '<option value="1" selected="selected"> REDESHOP </option>'+
//												 '<option value="2"> REDECARD A VISTA </option>'+
//												 '<option value="3"> REDECARD PARCELADO </option>'+
//												 '<option value="4"> REDECARD ASS.ARQUIVO </option>'+
//												 '<option value="5"> VISA ELECTRON </option>'+
//												 '<option value="10"> INTERNET VISA </option>'+
//												 '<option value="6"> VISA A VISTA </option>'+
//												 '<option value="15"> REDECARD ASS.A.PARC </option>'+
//												 '<option value="7"> VISA PARCELADO </option>'+
//												 '<option value="14"> INTERNET DINERS </option>'+
//												 '<option value="13"> INTERNET AMERICAN </option>'+
//												 '<option value="12"> AMERICAN PARCELADO </option>'+
//												 '<option value="11"> INTERNET MASTER </option>'+
//												 '<option value="9"> AMERICAN EXPRESS </option>'+
//												 '<option value="8"> VISA ASS.ARQUIVO </option>';
//											 }else
//												if(value.feccartao==2)
//{
//													 tblFormaPagamento['tabela'] +='<option value="2"  selected="selected"> REDECARD A VISTA </option>';
//													 tblFormaPagamento['tabela'] +='<option value="1"> REDESHOP </option>'+
//
//														 '<option value="3"> REDECARD PARCELADO </option>'+
//														 '<option value="4"> REDECARD ASS.ARQUIVO </option>'+
//														 '<option value="5"> VISA ELECTRON </option>'+
//														 '<option value="10"> INTERNET VISA </option>'+
//														 '<option value="6"> VISA A VISTA </option>'+
//														 '<option value="15"> REDECARD ASS.A.PARC </option>'+
//														 '<option value="7"> VISA PARCELADO </option>'+
//														 '<option value="14"> INTERNET DINERS </option>'+
//														 '<option value="13"> INTERNET AMERICAN </option>'+
//														 '<option value="12"> AMERICAN PARCELADO </option>'+
//														 '<option value="11"> INTERNET MASTER </option>'+
//														 '<option value="9"> AMERICAN EXPRESS </option>'+
//														 '<option value="8"> VISA ASS.ARQUIVO </option>';
//											 }else
//											  if(value.feccartao==3)
//{
//												  tblFormaPagamento['tabela'] +='<option value="3"  selected="selected"> REDECARD PARCELADO </option>'+
//													'<option value="1"> REDESHOP </option>'+
//													 '<option value="2"> REDECARD A VISTA </option>'+
//
//													 '<option value="4"> REDECARD ASS.ARQUIVO </option>'+
//													 '<option value="5"> VISA ELECTRON </option>'+
//													 '<option value="10"> INTERNET VISA </option>'+
//													 '<option value="6"> VISA A VISTA </option>'+
//													 '<option value="15"> REDECARD ASS.A.PARC </option>'+
//													 '<option value="7"> VISA PARCELADO </option>'+
//													 '<option value="14"> INTERNET DINERS </option>'+
//													 '<option value="13"> INTERNET AMERICAN </option>'+
//													 '<option value="12"> AMERICAN PARCELADO </option>'+
//													 '<option value="11"> INTERNET MASTER </option>'+
//													 '<option value="9"> AMERICAN EXPRESS </option>'+
//													 '<option value="8"> VISA ASS.ARQUIVO </option>';
//											 }else
//											 if(value.feccartao==4)
//{
//												 tblFormaPagamento['tabela'] +='<option value="4"  selected="selected"> REDECARD ASS.ARQUIVO </option>'+
//													'<option value="1"> REDESHOP </option>'+
//													 '<option value="2"> REDECARD A VISTA </option>'+
//													 '<option value="3"> REDECARD PARCELADO </option>'+
//
//													 '<option value="5"> VISA ELECTRON </option>'+
//													 '<option value="10"> INTERNET VISA </option>'+
//													 '<option value="6"> VISA A VISTA </option>'+
//													 '<option value="15"> REDECARD ASS.A.PARC </option>'+
//													 '<option value="7"> VISA PARCELADO </option>'+
//													 '<option value="14"> INTERNET DINERS </option>'+
//													 '<option value="13"> INTERNET AMERICAN </option>'+
//													 '<option value="12"> AMERICAN PARCELADO </option>'+
//													 '<option value="11"> INTERNET MASTER </option>'+
//													 '<option value="9"> AMERICAN EXPRESS </option>'+
//													 '<option value="8"> VISA ASS.ARQUIVO </option>';
//											 }else
//											  if(value.feccartao==5)
//{
//												  tblFormaPagamento['tabela'] +='<option value="5"  selected="selected"> VISA ELECTRON </option>'+
//													'<option value="1"> REDESHOP </option>'+
//													 '<option value="2"> REDECARD A VISTA </option>'+
//													 '<option value="3"> REDECARD PARCELADO </option>'+
//													 '<option value="4"> REDECARD ASS.ARQUIVO </option>'+
//
//													 '<option value="10"> INTERNET VISA </option>'+
//													 '<option value="6"> VISA A VISTA </option>'+
//													 '<option value="15"> REDECARD ASS.A.PARC </option>'+
//													 '<option value="7"> VISA PARCELADO </option>'+
//													 '<option value="14"> INTERNET DINERS </option>'+
//													 '<option value="13"> INTERNET AMERICAN </option>'+
//													 '<option value="12"> AMERICAN PARCELADO </option>'+
//													 '<option value="11"> INTERNET MASTER </option>'+
//													 '<option value="9"> AMERICAN EXPRESS </option>'+
//													 '<option value="8"> VISA ASS.ARQUIVO </option>';
//											 }else
//											  if(value.feccartao==10)
//											  {
//												  tblFormaPagamento['tabela'] +='<option value="10"  selected="selected"> INTERNET VISA </option>'+
//													'<option value="1"> REDESHOP </option>'+
//													 '<option value="2"> REDECARD A VISTA </option>'+
//													 '<option value="3"> REDECARD PARCELADO </option>'+
//													 '<option value="4"> REDECARD ASS.ARQUIVO </option>'+
//													 '<option value="5"> VISA ELECTRON </option>'+
//
//													 '<option value="6"> VISA A VISTA </option>'+
//													 '<option value="15"> REDECARD ASS.A.PARC </option>'+
//													 '<option value="7"> VISA PARCELADO </option>'+
//													 '<option value="14"> INTERNET DINERS </option>'+
//													 '<option value="13"> INTERNET AMERICAN </option>'+
//													 '<option value="12"> AMERICAN PARCELADO </option>'+
//													 '<option value="11"> INTERNET MASTER </option>'+
//													 '<option value="9"> AMERICAN EXPRESS </option>'+
//													 '<option value="8"> VISA ASS.ARQUIVO </option>';
//											 }else
//											 if(value.feccartao==6)
//											 {
//												 tblFormaPagamento['tabela'] +='<option value="6"  selected="selected"> VISA A VISTA </option>'+
//													'<option value="1"> REDESHOP </option>'+
//													 '<option value="2"> REDECARD A VISTA </option>'+
//													 '<option value="3"> REDECARD PARCELADO </option>'+
//													 '<option value="4"> REDECARD ASS.ARQUIVO </option>'+
//													 '<option value="5"> VISA ELECTRON </option>'+
//													 '<option value="10"> INTERNET VISA </option>'+
//
//													 '<option value="15"> REDECARD ASS.A.PARC </option>'+
//													 '<option value="7"> VISA PARCELADO </option>'+
//													 '<option value="14"> INTERNET DINERS </option>'+
//													 '<option value="13"> INTERNET AMERICAN </option>'+
//													 '<option value="12"> AMERICAN PARCELADO </option>'+
//													 '<option value="11"> INTERNET MASTER </option>'+
//													 '<option value="9"> AMERICAN EXPRESS </option>'+
//													 '<option value="8"> VISA ASS.ARQUIVO </option>';
//											 }else
//											 if(value.feccartao==15)
//											 {
//												 tblFormaPagamento['tabela'] +='<option value="15"  selected="selected"> REDECARD ASS.A.PARC </option>'+
//													'<option value="1"> REDESHOP </option>'+
//													 '<option value="2"> REDECARD A VISTA </option>'+
//													 '<option value="3"> REDECARD PARCELADO </option>'+
//													 '<option value="4"> REDECARD ASS.ARQUIVO </option>'+
//													 '<option value="5"> VISA ELECTRON </option>'+
//													 '<option value="10"> INTERNET VISA </option>'+
//													 '<option value="6"> VISA A VISTA </option>'+
//
//													 '<option value="7"> VISA PARCELADO </option>'+
//													 '<option value="14"> INTERNET DINERS </option>'+
//													 '<option value="13"> INTERNET AMERICAN </option>'+
//													 '<option value="12"> AMERICAN PARCELADO </option>'+
//													 '<option value="11"> INTERNET MASTER </option>'+
//													 '<option value="9"> AMERICAN EXPRESS </option>'+
//													 '<option value="8"> VISA ASS.ARQUIVO </option>';
//											 }else
//											 if(value.feccartao==7)
//											 {
//												 tblFormaPagamento['tabela'] +='<option value="7"  selected="selected"> VISA PARCELADO </option>'+
//													'<option value="1"> REDESHOP </option>'+
//													 '<option value="2"> REDECARD A VISTA </option>'+
//													 '<option value="3"> REDECARD PARCELADO </option>'+
//													 '<option value="4"> REDECARD ASS.ARQUIVO </option>'+
//													 '<option value="5"> VISA ELECTRON </option>'+
//													 '<option value="10"> INTERNET VISA </option>'+
//													 '<option value="6"> VISA A VISTA </option>'+
//													 '<option value="15"> REDECARD ASS.A.PARC </option>'+
//
//													 '<option value="14"> INTERNET DINERS </option>'+
//													 '<option value="13"> INTERNET AMERICAN </option>'+
//													 '<option value="12"> AMERICAN PARCELADO </option>'+
//													 '<option value="11"> INTERNET MASTER </option>'+
//													 '<option value="9"> AMERICAN EXPRESS </option>'+
//													 '<option value="8"> VISA ASS.ARQUIVO </option>';
//											  }else
//												if(value.feccartao==14)
//												{
//													 tblFormaPagamento['tabela'] +='<option value="14"  selected="selected"> INTERNET DINERS </option>'+
//														'<option value="1"> REDESHOP </option>'+
//														 '<option value="2"> REDECARD A VISTA </option>'+
//														 '<option value="3"> REDECARD PARCELADO </option>'+
//														 '<option value="4"> REDECARD ASS.ARQUIVO </option>'+
//														 '<option value="5"> VISA ELECTRON </option>'+
//														 '<option value="10"> INTERNET VISA </option>'+
//														 '<option value="6"> VISA A VISTA </option>'+
//														 '<option value="15"> REDECARD ASS.A.PARC </option>'+
//														 '<option value="7"> VISA PARCELADO </option>'+
//
//														 '<option value="13"> INTERNET AMERICAN </option>'+
//														 '<option value="12"> AMERICAN PARCELADO </option>'+
//														 '<option value="11"> INTERNET MASTER </option>'+
//														 '<option value="9"> AMERICAN EXPRESS </option>'+
//														 '<option value="8"> VISA ASS.ARQUIVO </option>';
//											 }else
//											 if(value.feccartao==13)
//											 {
//												 tblFormaPagamento['tabela'] +='<option value="13"  selected="selected"> INTERNET AMERICAN </option>'+
//													'<option value="1"> REDESHOP </option>'+
//													 '<option value="2"> REDECARD A VISTA </option>'+
//													 '<option value="3"> REDECARD PARCELADO </option>'+
//													 '<option value="4"> REDECARD ASS.ARQUIVO </option>'+
//													 '<option value="5"> VISA ELECTRON </option>'+
//													 '<option value="10"> INTERNET VISA </option>'+
//													 '<option value="6"> VISA A VISTA </option>'+
//													 '<option value="15"> REDECARD ASS.A.PARC </option>'+
//													 '<option value="7"> VISA PARCELADO </option>'+
//													 '<option value="14"> INTERNET DINERS </option>'+
//
//													 '<option value="12"> AMERICAN PARCELADO </option>'+
//													 '<option value="11"> INTERNET MASTER </option>'+
//													 '<option value="9"> AMERICAN EXPRESS </option>'+
//													 '<option value="8"> VISA ASS.ARQUIVO </option>';
//											 }else
//											 if(value.feccartao==12)
//{
//												 tblFormaPagamento['tabela'] +='<option value="12"  selected="selected"> AMERICAN PARCELADO </option>'+
//													'<option value="1"> REDESHOP </option>'+
//													 '<option value="2"> REDECARD A VISTA </option>'+
//													 '<option value="3"> REDECARD PARCELADO </option>'+
//													 '<option value="4"> REDECARD ASS.ARQUIVO </option>'+
//													 '<option value="5"> VISA ELECTRON </option>'+
//													 '<option value="10"> INTERNET VISA </option>'+
//													 '<option value="6"> VISA A VISTA </option>'+
//													 '<option value="15"> REDECARD ASS.A.PARC </option>'+
//													 '<option value="7"> VISA PARCELADO </option>'+
//													 '<option value="14"> INTERNET DINERS </option>'+
//													 '<option value="13"> INTERNET AMERICAN </option>'+
//
//													 '<option value="11"> INTERNET MASTER </option>'+
//													 '<option value="9"> AMERICAN EXPRESS </option>'+
//													 '<option value="8"> VISA ASS.ARQUIVO </option>';
//											 }else
//											 if(value.feccartao==11)
//{
//												 tblFormaPagamento['tabela'] +='<option value="11"  selected="selected"> INTERNET MASTER </option>'+
//													'<option value="1"> REDESHOP </option>'+
//													 '<option value="2"> REDECARD A VISTA </option>'+
//													 '<option value="3"> REDECARD PARCELADO </option>'+
//													 '<option value="4"> REDECARD ASS.ARQUIVO </option>'+
//													 '<option value="5"> VISA ELECTRON </option>'+
//													 '<option value="10"> INTERNET VISA </option>'+
//													 '<option value="6"> VISA A VISTA </option>'+
//													 '<option value="15"> REDECARD ASS.A.PARC </option>'+
//													 '<option value="7"> VISA PARCELADO </option>'+
//													 '<option value="14"> INTERNET DINERS </option>'+
//													 '<option value="13"> INTERNET AMERICAN </option>'+
//													 '<option value="12"> AMERICAN PARCELADO </option>'+
//
//													 '<option value="9"> AMERICAN EXPRESS </option>'+
//													 '<option value="8"> VISA ASS.ARQUIVO </option>';
//											 }else
//											 if(value.feccartao==9)
//{
//												 tblFormaPagamento['tabela'] +='<option value="9"  selected="selected"> AMERICAN EXPRESS </option>'+
//													'<option value="1"> REDESHOP </option>'+
//													 '<option value="2"> REDECARD A VISTA </option>'+
//													 '<option value="3"> REDECARD PARCELADO </option>'+
//													 '<option value="4"> REDECARD ASS.ARQUIVO </option>'+
//													 '<option value="5"> VISA ELECTRON </option>'+
//													 '<option value="10"> INTERNET VISA </option>'+
//													 '<option value="6"> VISA A VISTA </option>'+
//													 '<option value="15"> REDECARD ASS.A.PARC </option>'+
//													 '<option value="7"> VISA PARCELADO </option>'+
//													 '<option value="14"> INTERNET DINERS </option>'+
//													 '<option value="13"> INTERNET AMERICAN </option>'+
//													 '<option value="12"> AMERICAN PARCELADO </option>'+
//													 '<option value="11"> INTERNET MASTER </option>'+
//
//													 '<option value="8"> VISA ASS.ARQUIVO </option>';
//											 }else
//											 if(value.feccartao==8)
//{
//												 tblFormaPagamento['tabela'] +='<option value="8" selected="selected"> VISA ASS.ARQUIVO </option>'+
//													'<option value="1"> REDESHOP </option>'+
//													 '<option value="2"> REDECARD A VISTA </option>'+
//													 '<option value="3"> REDECARD PARCELADO </option>'+
//													 '<option value="4"> REDECARD ASS.ARQUIVO </option>'+
//													 '<option value="5"> VISA ELECTRON </option>'+
//													 '<option value="10"> INTERNET VISA </option>'+
//													 '<option value="6"> VISA A VISTA </option>'+
//													 '<option value="15"> REDECARD ASS.A.PARC </option>'+
//													 '<option value="7"> VISA PARCELADO </option>'+
//													 '<option value="14"> INTERNET DINERS </option>'+
//													 '<option value="13"> INTERNET AMERICAN </option>'+
//													 '<option value="12"> AMERICAN PARCELADO </option>'+
//													 '<option value="11"> INTERNET MASTER </option>'+
//													 '<option value="9"> AMERICAN EXPRESS </option>';
//											 }
												tblFormaPagamento['tabela'] += '</select>';

									  }
								  tblFormaPagamento['tabela'] +='</td><td>';
								  if(value.fecforma!=105)
								  {
									  tblFormaPagamento['tabela'] +='<input type="text" name="fecvalor" id="fecvalor'+value.prefeccodigo+'" value="'+value.fecvalor+'" size="10">';
								  }
								  else
									  if(value.fecforma==105)
									  {

										  tblFormaPagamento['tabela'] +='<input type="text" name="fecvalor" id="fecvalor'+value.prefeccodigo+'" value="'+value.fecvalor+'" size="10" disabled>';
									  }
								  	tblFormaPagamento['tabela'] +='</td>'+
																  '<td><input type="text" name="fecdata"   size="12" id="fecdata'+value.prefeccodigo+'" value="'+value.fecdata+'" size="10"></td>'+
																  '<td><input type="text" name="fecvecto"   size="12" id="fecvecto'+value.prefeccodigo+'" value="'+value.fecvecto+'" size="10"></td>'+
																  '<td><input type="text" name="fecdia" size="3" maxlength="3"  id="fecdia'+value.prefeccodigo+'" value="'+value.fecdia+'" size="10"></td>'+
																  '<td><input type="text" name="fecbanco" size="3" maxlength="3"  id="fecbanco'+value.prefeccodigo+'" value="'+value.fecbanco+'" size="10"></td>'+
																  '<td><input type="text" name="fecagencia"size="7" maxlength="7"  id="fecagencia'+value.prefeccodigo+'" value="'+value.fecagencia +'" size="10"></td>'+
																  '<td><input type="text" name="fecconta" size="7" maxlength="10" id="fecconta'+value.prefeccodigo+'" value="'+value.fecconta+'" size="10"></td>'+

																  "<td><input type='hidden' id='itemPreFechamento"+value.prefeccodigo+"' value='"+JSON.stringify(value)+"'/>"+hE+"<input type='button' name='btnAlterarParcela' id='"+value.prefeccodigo+"' style='background: url(imagens/edit.gif); background-repeat: no-repeat; background-position:center center; height: 20px; width: 55px; border:1px;  border-color:black' /><input type='button' name='btnExcluirParcela' id='"+value.prefeccodigo+"' style='background: url(imagens/delete.gif); background-repeat: no-repeat; background-position:center center; height: 20px; width:65px; border:1px;'/> </td>" +
																	"</tr>";
			});
 	tblFormaPagamento['tabela'] +='</table>';


 	$('#detalhesFormaPagamento').html(tblFormaPagamento['tabela']);


	$("#listaParcelas").ingrid({
		rowSelection:false,
		initialLoad:false,
		paging: false,
		sorting: false,
		colWidths:[100,190,80,90,90,40,45,60,60,130],
		height: 150
	});



 	$("input[name='btnExcluirParcela']").click(function()
			{




 		$("#btnIncluirFormaPagamento").attr('disabled','');
 		var id = $(this).attr('id');
 		var jsonText = $("input[id='itemPreFechamento"+id+"']").val();
		var parcelaPreFechamento =  eval('(' + jsonText + ')');


		$.post('modulos/vendaAtacado/pedidos/manutencao/controller/acoes.php',
				{

   				//variaveis a ser enviadas metodo POST
				prefeccodigo:parcelaPreFechamento.prefeccodigo,
   				fecdocto:parcelaPreFechamento.fecdocto,
   				clicodigo: parcelaPreFechamento.clicodigo,
   				pvnumero:parcelaPreFechamento.pvnumero,
   				fecforma:parcelaPreFechamento.fecforma,
   				acao:11

   				},
   				function(data)
   				{
   					//alert('PREFECHAMENTO EFETUADO COM SUCSSO');

   					if (Boolean(Number(data.retorno)))
   					{
   						//alert(data.mensagem);
   						pedido.cliente.devolucaoVales = new Object();
	   					pedido.cliente.devolucaoVales = data.vales;

	   					pedido.preFechamento = new Object();
	   					pedido.preFechamento = data.preFechamentos;

	   					itemFormaPagamento.formaPagamento = new Object();
	   					formaPagamento = new Object();


	   					 pedido.TotalValorPreFechamento = data.total;
	   					//diferenca = pedidoValor-pedido.TotalValorPreFechamento;

	   				$("#lblTotalPagar").text(pedidoValor.toFixed(2));
	   				$("#lblTotalPago").text(pedido.TotalValorPreFechamento);
	   				diferenca = $("#lblTotalPagar").text() - $("#lblTotalPago").text();
	   				$("#lblDiferencaPagar").text(diferenca.toFixed(2));

//					limiteDisponivel = pedido.cliente.clilimite - pedido.cliente.vendasEmAberto-pedido.TotalValorPreFechamento;
//	   				$("#lblTotalLimiteDisponivel").text(Number(limiteDisponivel));


	   				if(parseFloat(diferenca).toFixed(2)=='0.00' || parseFloat(diferenca).toFixed(2)=='0' || parseFloat(diferenca).toFixed(2)=='-0.00' || parseFloat(diferenca).toFixed(2)=='-0')
	   				{
	   					msg = "PREFECHAMENTO REALIZADO COM SUCESSO";
	   					alert('PREFECHAMENTO REALIZADO COM SUCESSO');
					   	$("#retorno").messageBox(msg,true, true);
					   	$("#btnIncluirFormaPagamento").attr('disabled','disabled');
	   				}

	   				if(parseFloat(diferenca).toFixed(2)< '0.00' || parseFloat(diferenca).toFixed(2)< '0')
	   				{
	   				 	$("#btnIncluirFormaPagamento").attr('disabled','disabled');
	   				}

   					}
   					else
   	   				{

   						alert('FALHA NA EXCLUSAO DA PARCELA');
	   					msg = "FALHA NA EXCLUSAO DA PARCELA";
	   				   	$("#retorno").messageBox(msg,true, true);


   	   				}
   			}, "json");
			});

 	$("input[name='btnAlterarParcela']").click(function()
			{
 		$("#btnIncluirFormaPagamento").attr('disabled','');
 		var id = $(this).attr('id');
 		var jsonText = $("input[id='itemPreFechamento"+id+"']").val();
		var parcelaPreFechamento =  eval('(' + jsonText + ')');

		$.each(pedido.preFechamento, function (key, value)
				{
		if(parcelaPreFechamento.prefeccodigo==value.prefeccodigo)
		{


			itemFormaPagamento = new Object();
							if(parcelaPreFechamento.fecforma==102)
							{

                                                                itemFormaPagamento.feccartao = $("#fecdocto"+value.prefeccodigo+" option:selected").val();
                                                                itemFormaPagamento.fecdocto =  $("#fecdocto"+value.prefeccodigo+" option:selected").text();
//
//
//alert( " itemFormaPagamento.feccartao: "+itemFormaPagamento.feccartao+
//"\n itemFormaPagamento.numeroDocumento: "+ itemFormaPagamento.numeroDocumento
//);
//							if($('#fecdocto'+value.prefeccodigo).val()==1)
//										{
//											itemFormaPagamento.feccartao = '1';
//											itemFormaPagamento.fecdocto = 'REDESHOP';
//
//										}
//										else
//											if($('#fecdocto'+value.prefeccodigo).val()==2)
//											{
//												itemFormaPagamento.feccartao = '2';
//												itemFormaPagamento.fecdocto = 'REDECARD A VISTA';
//											}
//											else
//												if($('#fecdocto'+value.prefeccodigo).val()==3)
//												{
//													itemFormaPagamento.feccartao = '3';
//													itemFormaPagamento.fecdocto = 'REDECARD PARCELADO';
//												}
//												else
//													if($('#fecdocto'+value.prefeccodigo).val()==4)
//													{
//														itemFormaPagamento.feccartao = '4';
//														itemFormaPagamento.fecdocto = 'REDECARD ASS.ARQUIVO';
//													}
//													else
//														if($('#fecdocto'+value.prefeccodigo).val()==5)
//														{
//															itemFormaPagamento.feccartao = '5';
//															itemFormaPagamento.fecdocto = 'VISA ELECTRON';
//														}
//														else
//															if($('#fecdocto'+value.prefeccodigo).val()==6)
//															{
//																itemFormaPagamento.feccartao = '6';
//																itemFormaPagamento.fecdocto = 'VISA A VISTA';
//															}
//															else
//																if($('#fecdocto'+value.prefeccodigo).val()==7)
//																{
//																	itemFormaPagamento.feccartao = '7';
//																	itemFormaPagamento.fecdocto = 'VISA PARCELADO';
//																}
//																else
//																	if($('#fecdocto'+value.prefeccodigo).val()==8)
//																	{
//																		itemFormaPagamento.feccartao = '8';
//																		itemFormaPagamento.fecdocto = 'VISA ASS.ARQUIVO';
//																	}
//																	else
//																		if($('#fecdocto'+value.prefeccodigo).val()==9)
//																		{
//																			itemFormaPagamento.feccartao = '9';
//																			itemFormaPagamento.fecdocto = 'AMERICAN EXPRESS';
//																		}
//																		else
//																			if($('#fecdocto'+value.prefeccodigo).val()==10)
//																			{
//																				itemFormaPagamento.feccartao = '10';
//																				itemFormaPagamento.fecdocto = 'INTERNET VISA';
//																			}
//																			else
//																				if($('#fecdocto'+value.prefeccodigo).val()==11)
//																				{
//																					itemFormaPagamento.feccartao = '11';
//																					itemFormaPagamento.fecdocto = 'INTERNET MASTER';
//																				}
//																				else
//																					if($('#fecdocto'+value.prefeccodigo).val()==12)
//																					{
//																						itemFormaPagamento.feccartao = '12';
//																						itemFormaPagamento.fecdocto = 'AMERICAN PARCELADO';
//																					}
//																					else
//																						if($('#fecdocto'+value.prefeccodigo).val()==13)
//																						{
//																						itemFormaPagamento.feccartao = '13';
//																							itemFormaPagamento.fecdocto = 'INTERNET AMERICAN';
//																						}
//																						else
//																							if($('#fecdocto'+value.prefeccodigo).val()==14)
//																							{
//																								itemFormaPagamento.feccartao = '14';
//																								itemFormaPagamento.fecdocto = 'INTERNET DINERS';
//																							}
//																							else
//																								if($('#fecdocto'+value.prefeccodigo).val()==15)
//																								{
//																									itemFormaPagamento.feccartao = '15';
//																									itemFormaPagamento.fecdocto = 'REDECARD ASS.A.PARC';
//																								}

			}
							else
								if(parcelaPreFechamento.fecforma!=102)
								{

			itemFormaPagamento.fecdocto = $('#fecdocto'+value.prefeccodigo).val();
			itemFormaPagamento.feccartao = parcelaPreFechamento.feccartao;
								}

			itemFormaPagamento.fecvalor = $('#fecvalor'+value.prefeccodigo).val();
			itemFormaPagamento.fecdata =  $('#fecdata'+value.prefeccodigo).val();
			itemFormaPagamento.fecvecto = $('#fecvecto'+value.prefeccodigo).val();
			itemFormaPagamento.fecdia = $('#fecdia'+value.prefeccodigo).val();
			itemFormaPagamento.fecbanco = $('#fecbanco'+value.prefeccodigo).val();
			itemFormaPagamento.fecagencia = $('#fecagencia'+value.prefeccodigo).val();
			itemFormaPagamento.fecconta =  $('#fecconta'+value.fecconta).val();
			itemFormaPagamento.pvnumero = parcelaPreFechamento.pvnumero;
			itemFormaPagamento.fecforma = parcelaPreFechamento.fecforma;
			itemFormaPagamento.clicodigo = parcelaPreFechamento.clicodigo;
			itemFormaPagamento.vencodigo = parcelaPreFechamento.vencodigo;
			itemFormaPagamento.fectipo = parcelaPreFechamento.fectipo;
			itemFormaPagamento.fecempresa = parcelaPreFechamento.fecempresa;
			itemFormaPagamento.prefeccodigo = parcelaPreFechamento.prefeccodigo;
			itemFormaPagamento.feccaixa = parcelaPreFechamento.feccaixa;

		//alert(jsonText);
		$.post('modulos/vendaAtacado/pedidos/manutencao/controller/acoes.php',
				{

   				//variaveis a ser enviadas metodo POST
				itemFormaPagamento:JSON.stringify(itemFormaPagamento),
   				acao:12

   				},
   				function(data)
   				{
   					//alert('PREFECHAMENTO EFETUADO COM SUCSSO');
   					if (Boolean(Number(data.retorno)))
   					{
   						alert('FALHA NA EXCLUSAO DA PARCELA');
	   					msg = "FALHA NA EXCLUSAO DA PARCELA";
	   				   	$("#retorno").messageBox(msg,true, true);

   					}
   					else
   	   				{

   						pedido.preFechamento = new Object();
   						pedido.preFechamento = data.preFechamentos.preFechamentos;

   						pedido.cliente.devolucaoVales = new Object();
	   					pedido.cliente.devolucaoVales = data.vales.vales;

	   					itemFormaPagamento.formaPagamento = new Object();
	   					formaPagamento = new Object();


   						$("#retorno").messageBox(data.preFechamentos.mensagem,true,true);


   						pedido.TotalValorPreFechamento = data.preFechamentos.total;

	   				$("#lblTotalPagar").text(pedidoValor.toFixed(2));
	   				$("#lblTotalPago").text(pedido.TotalValorPreFechamento);
	   				//diferenca = pedidoValor.toFixed(2)-pedido.TotalValorPreFechamento;
	   				diferenca = $("#lblTotalPagar").text() - $("#lblTotalPago").text();
	   				$("#lblDiferencaPagar").text(parseFloat(diferenca).toFixed(2));

//					limiteDisponivel = pedido.cliente.clilimite - pedido.cliente.vendasEmAberto-pedido.TotalValorPreFechamento;
//	   				$("#lblTotalLimiteDisponivel").text(Number(limiteDisponivel));



	   				if(parseFloat(diferenca).toFixed(2)=='0.00' || parseFloat(diferenca).toFixed(2)=='0' || parseFloat(diferenca).toFixed(2)=='-0.00' || parseFloat(diferenca).toFixed(2)=='-0')
	   				{
	   					msg = "PREFECHAMENTO REALIZADO COM SUCESSO";
	   					alert('PREFECHAMENTO REALIZADO COM SUCESSO');
					   	$("#retorno").messageBox(msg,true, true);
						$("#btnIncluirFormaPagamento").attr('disabled','disabled');
	   				}

	   				if(Number(diferenca).toFixed(2)!='0' && Number(diferenca).toFixed(2)!='0.00')
	   				{
	   					msg = "VALOR PAGO NAO CONFERE COM O VALOR DO PEDIDO";
					    alert('VALOR PAGO NAO CONFERE COM O VALOR DO PEDIDO');
					   	$("#retorno").messageBox(msg,false, false);
						$("#btnIncluirFormaPagamento").attr('disabled','disabled');
	   				}
	   				if(parseFloat(diferenca).toFixed(2)< '0.00' || parseFloat(diferenca).toFixed(2)< '0')
	   				{
	   				 	$("#btnIncluirFormaPagamento").attr('disabled','disabled');
	   				}

   	   				}
   			}, "json");

				}
			});
			});

    });




	$('#listaFormaPagamento').change(function()
	{



		if(condicaoComercialPreFechamento.parcela==undefined ||condicaoComercialPreFechamento.parcela==null)
		{
		tmpCondicaoComercial = pedido.condicaoComercial;
		}
		else
		{
			tmpCondicaoComercial = condicaoComercialPreFechamento;
		}

		var jsonText = $("#listaFormaPagamento").val();

		if (Boolean(jsonText))
		{

			formaPagamento = eval('(' + jsonText + ')');
			id = Number(formaPagamento.pagcodigo);

			//$('#txtNumeroDocumento').val('');
			//$('#txtValorSt').val($.mask.string(parseFloat(pedido.calculoSt.substituicao).toFixed(2), 'decimal'));
			$('#txtValorDocumento').val($.mask.string(0, 'decimal'));
			$('#detalhesFormaPagamento').html("");


			$("#lblTotalPagar").text(pedidoValor.toFixed(2));
			$("#lblTotalPago").text(pedido.TotalValorPreFechamento);
			diferenca = pedidoValor-pedido.TotalValorPreFechamento;
			$("#lblDiferencaPagar").text(parseFloat(diferenca).toFixed(2));

//			limiteDisponivel = pedido.cliente.clilimite - pedido.cliente.vendasEmAberto-pedido.TotalValorPreFechamento;
//			$('#lblTotalLimiteDisponivel').text($.mask.string(parseFloat(limiteDisponivel).toFixed(2), 'decimal'));





			tblFormaPagamento['duplicata'] = '<table border="0" cellpadding="0" cellspacing="0">'+
												'<tr>'+
													'<td width="170">Tipo:</td>'+
													'<td>'+
														'<select id="listaTipoDuplicata" name="listaTipoDuplicata">'+
															'<option value="1">Selecione Tipo Duplicata</option>'+
															'<option value="0">Normal</option>'+
															'<option value="CAR">Carteira</option>'+
														'</select>'+
													'</td>'+
												'</tr>'+
											  '</table>';
			tblFormaPagamento['duplicata'] += '<br /><br />';
			tblFormaPagamento['duplicata'] += '<br /><br /><table border="1" cellpadding="0" cellspacing="0" width="600">'+
												'<tr>'+

												'<td>Forma Pagto</td><td>Num. Doc.</td><td>Banco</td><td>	Agência</td><td>	Conta</td><td>Valor</td><td>Vencimento</td><td>Data Vencto</td>'+
												'</tr>';
			//informações da conta (Banco, Ag. C/C)

				//informações da conta (Banco, Ag. C/C)
				for (i = 1; i <= tmpCondicaoComercial.parcela; i++)
                                                {
                                                        if (i == 1)
                                                        {
                                                        var	salto = Number(tmpCondicaoComercial.inicial);
                                                        }
                                                        else
                                                        {
                                                                salto = salto + Number(tmpCondicaoComercial.salto);
                                                        }

                                                var venc = salto;
                                                if(pedido.tipoPedido.auxiliadocumento==0)
                                                {
                                                        if(pedido.vendedor.venlocal!="" ||pedido.vendedor.venlocal!=null ||pedido.vendedor.venlocal!=undefined)
                                                        {
                                                        letraParcela = pedido.vendedor.venlocal;
                                                        }
                                                        else
                                                        {
                                                                letraParcela = "M";
                                                        }
                                                }
                                                else
                                                {
                                                        letraParcela = pedido.tipoPedido.auxiliadocumento;
                                                }

                                                var doc = pedido.pvnumero+letraParcela;
                                                var dataVencimentoDuplicata = new Date();
                                                dataVencimentoDuplicata.addDays(venc);
                                                var txtdataVencimentoDuplicata = dataVencimentoDuplicata.format('d/m/Y');
                                                //$("input[name*='txtdataVencimentoDuplicata']").val(txtdataVencimentoDuplicata);

                                                valParcela2 = diferenca/tmpCondicaoComercial.parcela;
                                                totalDiferenca = valParcela2.toFixed(2) * tmpCondicaoComercial.parcela;
                                                tt =   (pedidoValor.toFixed(2) - totalDiferenca.toFixed(2))-$('#lblTotalVales').text().replace(/,/ig, '.');
                                                result = Math.round(tt*100)/100;


                                                $("input[name*='parcelaDuplicata1']").hide();
                                                  if(result!='0.000')
                                                  {
                                                         valorD = (valParcela2 + result).toFixed(2);
                                                         //alert(valorDuplicata);

                                                  }

                                                tblFormaPagamento['duplicata'] += '<tr>'+
                                                                                                                  '<td>'+ formaPagamento.pagcodigo+''+ formaPagamento.pagdescricao +'</td>'+
                                                                                                                  '<td><input type="type" name="txtDocumentoDuplicata" id="txtDocumentoDuplicata" value="' + doc + '" size="10"></td>'+
                                                                                                                  '<td>. </td>'+
                                                                                                                  '<td>.</td>'+
                                                                                                                  '<td>. </td>';
                                                tblFormaPagamento['duplicata'] +=  '<td>R$ <input type="text" name="txtParcelaDuplicata'+i+'" id="txtParcelaDuplicata'+i+'" size="12">  </td>';

                                                tblFormaPagamento['duplicata'] += '<td><input type="text" name="txtVencimentoDuplicata'+i+'" id="txtVencimentoDuplicata'+i+'" value="'+ venc +'"  size="12"></td>'+
                                                                                                                  '<td><input name="txtDataVencimentoDuplicata'+i+'" id="txtDataVencimentoDuplicata'+i+'" value="'+ txtdataVencimentoDuplicata +'" type="text" size="10"></td>'+
                                                                                                                  '</tr>';
                                }
				tblFormaPagamento['duplicata'] +='</table>';




			//opção de selecionar o tipo de parcelamento
			tblFormaPagamento['cartao'] = '<br />';
			tblFormaPagamento['cartao'] += '<table border="0" cellpadding="0" cellspacing="0">'+
													'<tr>'+
														'<td width="170" height="25">Tipo:</td>'+
														'<td>'+
															'<select id="listaTipoParcelamento" name="listaTipoParcelamento">'+
																'<option value="0">Selecione Tipo Parcela</option>'+
																'<option value="1">A Vista (Gera uma parcela)</option>'+
																'<option value="2">Parcelado (Cond. Comerciais)</option>'+
															'</select> '+
														'</td>'+
													'</tr>'+

												'</table>';
			tblFormaPagamento['cartao'] += '<br /><br />';
			tblFormaPagamento['cartao'] += '<br /><br /><table border="1" cellpadding="0" cellspacing="0" width="600">'+
												 '<tr>'+
												 '<td>Forma Pagto</td><td>Num. Doc.</td><td>Valor</td><td>Vencimento</td><td>Data Vencto</td>'+
												 '</tr>';

												//informações da conta (Banco, Ag. C/C)
												for (i = 1; i <= tmpCondicaoComercial.parcela; i++)
												{

													if (i == 1)
													{
														salto = Number(tmpCondicaoComercial.inicial);
													}
													else
													{
														salto = salto + Number(tmpCondicaoComercial.salto);
													}
												venc = salto;
												if(pedido.tipoPedido.auxiliadocumento==0)
												{
													if(pedido.vendedor.venlocal!="" ||pedido.vendedor.venlocal!=null ||pedido.vendedor.venlocal!=undefined)
													{
													letraParcela = pedido.vendedor.venlocal;
													}
													else
													{
														letraParcela = "M";
													}
												}
												else
												{
													letraParcela = pedido.tipoPedido.auxiliadocumento;
												}

												doc = pedido.pvnumero+letraParcela;
												var dataVencimentoCartao = new Date();
												dataVencimentoCartao.addDays(venc);
												var txtdataVencimentoCartao = dataVencimentoCartao.format('d/m/Y');

												valParcela2 = diferenca/tmpCondicaoComercial.parcela;
												totalDiferenca = valParcela2.toFixed(2) * tmpCondicaoComercial.parcela;
												tt =   pedidoValor.toFixed(2) - totalDiferenca.toFixed(2);
												result = Math.round(tt*100)/100;

												  if(result!='0.000')
												  {
													 valorDuplicata = (valParcela2 + result).toFixed(2);
													 //alert(valorDuplicata);

												  }


			tblFormaPagamento['cartao'] += '<tr>'+
 												 '<td>'+ formaPagamento.pagcodigo+''+ formaPagamento.pagdescricao +'</td>'+
 												 '<td><select id="listaBandeirasCartoes'+i+'" name="listaBandeirasCartoes'+i+'">';

 			tblFormaPagamento['cartao'] +=  			 '<option value="0"> SELECIONE O CARTAO </option>'+
 												 '<option value="1"> REDESHOP </option>'+
 												 '<option value="2"> REDECARD A VISTA </option>'+
 												 '<option value="3"> REDECARD PARCELADO </option>'+
 												 '<option value="4"> REDECARD ASS.ARQUIVO </option>'+
 												 '<option value="5"> VISA ELECTRON </option>'+
 												 '<option value="10"> INTERNET VISA </option>'+
 												 '<option value="6"> VISA A VISTA </option>'+
 												 '<option value="15"> REDECARD ASS.A.PARC </option>'+
 												 '<option value="7"> VISA PARCELADO </option>'+
 												 '<option value="14"> INTERNET DINERS </option>'+
 												 '<option value="13"> INTERNET AMERICAN </option>'+
 												 '<option value="12"> AMERICAN PARCELADO </option>'+
 												 '<option value="11"> INTERNET MASTER </option>'+
 												 '<option value="9"> AMERICAN EXPRESS </option>'+
 												 '<option value="8"> VISA ASS.ARQUIVO </option>';

//                                 var opt = $("#listaBandeirasCartoesBase option:selected");
//                                                                                var html2 = $("<div>").append(opt.clone()).html();
//                                                                                html2 = html2.replace(' selected="selected"', '');
//                                                                                opt.replaceWith(html2);
//
//                                                                                opt = $("#listaBandeirasCartoesBase option[value="+value.feccartao+"]");
//                                                                                html3 = $("<div>").append(opt.clone()).html();
//                                                                                html3 = html3.replace(/\>/, ' selected="selected">');
//                                                                                opt.replaceWith(html3);

                                                                              
//                                tblFormaPagamento['cartao'] += $('#listaBandeirasCartoesBase').html();
                                tblFormaPagamento['cartao'] +=  		 '</select></td>';

				tblFormaPagamento['cartao'] +=   '<td> R$ <input type="text" name="txtParcelaCartao'+i+'" id="txtParcelaCartao'+i+'" size="10"></td>';


			tblFormaPagamento['cartao'] += '<td><input type="text" name="txtVencimentoCartao'+i+'" id="txtDiaVencimentoCartao'+i+'" value="'+ venc +'" size="10"> </td>'+
 												'<td><input name="txtdataVencimentoCartao'+i+'" id="txtdataVencimentoCartao'+i+'" value="'+ txtdataVencimentoCartao +'" type="text" size="10"></td>'+
											 	 '</tr>';
												 }
			tblFormaPagamento['cartao'] +='</table>';

				/////////////////////////////////////////////////////////////////////

			tblFormaPagamento['ordem'] = '<br /><br />';
			tblFormaPagamento['ordem'] += '<table border="1" cellpadding="0" cellspacing="0" width="600">'+
													'<tr>'+
													'<td>Forma Pagto</td><td>Num. Doc.</td><td>Banco</td><td>	Agência</td><td>	Conta</td><td>Valor</td><td>Vencimento</td><td>Data Vencto</td>'+
													'</tr>';
													//informações da conta (Banco, Ag. C/C)

													if (i == 1)
													{
													salto = Number(tmpCondicaoComercial.inicial);
													}
													else
													{
													salto = salto + Number(tmpCondicaoComercial.salto);
													}
													venc = salto;
													if(pedido.tipoPedido.auxiliadocumento==0)
													{
														if(pedido.vendedor.venlocal!="" ||pedido.vendedor.venlocal!=null ||pedido.vendedor.venlocal!=undefined)
														{
															letraParcela = pedido.vendedor.venlocal;
														}
														else
														{
															letraParcela = "M";
														}
													}
													else
													{
														letraParcela = pedido.tipoPedido.auxiliadocumento;
													}

													 doc = pedido.pvnumero+letraParcela;
													$('#txtDocumentoOrderPagamento').val('#txtValorDocumento');
			tblFormaPagamento['ordem'] += '<tr>'+
										 			'<td>'+ formaPagamento.pagcodigo+'</td>'+
										 			'<td><input type="text" name="txtDocumentoOrderPagamento" id="txtDocumentoOrderPagamento" size="10"></td>'+
										 			'<td>.</td>'+
										 			'<td>.</td>'+
										 			'<td> .</td>'+
										 			'<td> R$ <input type="text" name="valorOrderPagamento" id="valorOrderPagamento" value="'+ $.mask.string(diferenca.toFixed(2), 'decimal') +'"  size="12"></td>'+
										 			'<td><input type="text" name="txtVencimentoOrdemPagamento" id="txtVencimentoOrdemPagamento" size="10"> </td>'+
										 			'<td><input name="opcaoVencimento" id="opcaoVencimento" type="radio" value="2" checked>Data'+
										 			'</td>'+
													'</tr>';
			 tblFormaPagamento['ordem'] +='</table>';


			///////////////////////////////////////////////////////////////////////////////////////////////////
			 tblFormaPagamento['conta']= '<br />';
			//informações da conta (Banco, Ag. C/C)
			for (i = 1; i <= tmpCondicaoComercial.parcela; i++)
			{
				if (i == 1)
				{
					salto = Number(tmpCondicaoComercial.inicial);
				}
				else
				{
					salto = salto + Number(tmpCondicaoComercial.salto);
				}
			venc = salto;
			var dataVencimentoCheque = new Date();
			dataVencimentoCheque.addDays(salto);
			var dataVencimentoChequesPre = dataVencimentoCheque.format('d/m/Y');

			valParcela2 = diferenca/tmpCondicaoComercial.parcela;
			totalDiferenca = valParcela2.toFixed(2) * tmpCondicaoComercial.parcela;
			tt =   pedidoValor.toFixed(2) - totalDiferenca.toFixed(2);
			result = Math.round(tt*100)/100;

			  if(result!='0.000')
			  {
				 valorDuplicata = (valParcela2 + result).toFixed(2);
				 //alert(valorDuplicata);

			  }

			  tblFormaPagamento['conta']+= '<hr size="1"><h4>Folha '+i+'</h4><table border="0" cellpadding="0" cellspacing="0"> '+
					'<tr> '+
						'<td width="170" height="25">Numero Cheque:</td> '+
						'<td width="140" colspan="5"><input name="txtNumeroDocFolha'+i+'" id="txtNumeroDocFolha'+i+'"  type="text" size="22"> Data:<input name="txtDataFolha'+i+'" id="txtDataFolha" value="'+ dataVencimentoChequesPre +'" type="text" size="10"> Salto:<input name="txtSaltoFolha'+i+'" id="txtSaltoFolha'+i+'" value="'+ venc +'"type="text" size="3"></td> '+
					'</tr> '+
					'<tr> '+
						'<td width="170" height="25">Valor Cheque:</td> ';

							  tblFormaPagamento['conta'] +=   '<td width="140" colspan="5"><input name="txtValorDocFolha'+i+'" id="txtValorDocFolha'+i+'" type="text"></td> ';


						 tblFormaPagamento['conta'] += '</tr> '+
					'<tr> '+
						'<td height="25"></td> '+
						'<td width="60" height="25">Banco:</td> '+
						'<td width="100"><input name="txtNumeroBanco'+i+'" id="txtNumeroBanco'+i+'" type="text" size="10"></td> '+
						'<td width="60">Agencia:</td> '+
						'<td width="100"><input name="txtNumeroAgencia'+i+'" id="txtNumeroAgencia'+i+'" type="text" size="10"></td> '+
						'<td width="60">Conta:</td> '+
						'<td width="100"><input name="txtNumeroConta'+i+'" id="txtNumeroConta'+i+'" type="text" size="10"></td> '+
					'</tr> '+
				'</table>';


			}
					tblFormaPagamento['conta'] += '<hr size="1">';



			//opção de selecionar o tipo de vale
					tblFormaPagamento['vales'] = '<table border="0" cellpadding="0" cellspacing="0">'+
												 '<tr>'+
												 '<td width="170">Vales:</td>'+
												 '<td>';
				if(pedido.cliente.devolucaoVales!=undefined||pedido.clicod!=null)
				{
				tblFormaPagamento['vales'] += '<select multiple="multiple" id="listaTipoVale" name="listaTipoVale">';
				tblFormaPagamento['vales'] += '<option> Nº do Vale |  R$:  Valor </option>';
						$.each(pedido.cliente.devolucaoVales, function (key, value)
						{
							a = '|';
							if(value.devolucaototal=='1')
							{
								tblFormaPagamento['vales'] += '<option value='+ value.numero+a+value.dvnumero+a+value.valorpedido+a+value.vale +'> Nº ' + value.vale + '  | R$: ' + numberToDecimal(value.valorpedido) + '</option>';
							}else{
				tblFormaPagamento['vales'] += '<option value='+ value.numero+a+value.dvnumero+a+value.valor+a+value.vale +'> Nº ' + value.vale + '  | R$: ' + numberToDecimal(value.valor) + '</option>';
							}
						});
				tblFormaPagamento['vales'] +=   '</select> ';
						}
				tblFormaPagamento['vales'] +=   '</td><td> Segure a tecla Ctrl Para selecionar mais de Vale </td>'+
											'</tr>'+
											'</table>';
				$("#txtValorDocumento").val($.mask.string(0, 'decimal'));
				$('#txtNumeroDocumento').val('');
	//			$('#lblTotalLimiteDisponivel').val($.mask.string(parseFloat(pedido.cliente.clilimite).toFixed(2), 'decimal'));



				//tmpValor = $("#lblDiferencaPagar").text() == 0 ? ($.mask.string(toInt2(pedido.pvvalor), 'decimal')) : ($(toInt2($("#lblDiferencaPagar").text()),'decimal'));
				//tpmvalor = pedido.pvvalor;
				//alert(tmpValor);
				valParcela = 0;

				if(pedido.tipoPedido.tipsigla == 'V' || pedido.tipoPedido.tipsigla=='BF')
				{
					fecempresa='2';
				}
				else
				{
					fecempresa='1';
				}

				switch(id)
				{
				case A_VISTA:

					$('#detalhesFormaPagamento').html(tblFormaPagamento['ordem']);
					$('#txtNumeroDocumento').val(pedido.pvnumero);
					$('#txtValorDocumento').val($.mask.string(diferenca.toFixed(2), 'decimal'));
					$("#txtVencimentoOrdemPagamento").val($.mask.string(stringDate, 'date'));
					$('#txtValorSt').val($.mask.string(parseFloat(pedido.calculoSt.substituicao).toFixed(2), 'decimal'));
					$('#txtValorPedidoSemSt').val($.mask.string(parseFloat(valorPedidoSemSt).toFixed(2), 'decimal'));

					totalValorPreFechamento = 0;
                                        if (pedido.preFechamento !== undefined && pedido.preFechamento !== null && pedido.preFechamento !== "") {
                                                                                 $.each(pedido.preFechamento, function (key, value) {
                                                                                                if (value.fecforma != '100' && value.fecforma != '102' && value.fecforma != '105' && value.fecforma != '106'  && value.fecforma != '111' && value.fecforma != '112' ) {
                                                                                                        totalValorPreFechamento += Number(value.fecvalor);

                                                                                                }
                                                                                 });

                                        }

                                   //     limiteDisponivel = Number(pedido.cliente.clilimite) - Number(pedido.cliente.vendasEmAberto.totalVendas)-Number(totalValorPreFechamento);
                                        limiteDisponivel = Number(pedido.cliente.clilimite) - Number(pedido.cliente.vendasEmAberto.cobrancaAberto)-Number(totalValorPreFechamento);
                                        $('#lblTotalLimiteDisponivel').text(parseFloat(limiteDisponivel).toFixed(2));
				break;
				case BRINDE:

					$('#detalhesFormaPagamento').html(tblFormaPagamento['ordem']);
					$('#txtNumeroDocumento').val(pedido.pvnumero);
					$('#txtValorDocumento').val($.mask.string(diferenca.toFixed(2), 'decimal'));
					$("#txtVencimentoOrdemPagamento").val($.mask.string(stringDate, 'date'));
					$('#txtValorSt').val($.mask.string(parseFloat(pedido.calculoSt.substituicao).toFixed(2), 'decimal'));
					$('#txtValorPedidoSemSt').val($.mask.string(parseFloat(valorPedidoSemSt).toFixed(2), 'decimal'));

					totalValorPreFechamento = 0;
                                        if (pedido.preFechamento !== undefined && pedido.preFechamento !== null && pedido.preFechamento !== "") {
                                                                                 $.each(pedido.preFechamento, function (key, value) {
                                                                                                if (value.fecforma != '100' && value.fecforma != '102' && value.fecforma != '105' && value.fecforma != '106'  && value.fecforma != '111' && value.fecforma != '112' ) {
                                                                                                        totalValorPreFechamento += Number(value.fecvalor);

                                                                                                }
                                                                                 });

                                        }

                                   //     limiteDisponivel = Number(pedido.cliente.clilimite) - Number(pedido.cliente.vendasEmAberto.totalVendas)-Number(totalValorPreFechamento);
                                        limiteDisponivel = Number(pedido.cliente.clilimite) - Number(pedido.cliente.vendasEmAberto.cobrancaAberto)-Number(totalValorPreFechamento);
                                        $('#lblTotalLimiteDisponivel').text(parseFloat(limiteDisponivel).toFixed(2));
				break;
				case DESCONTOS_COMERCIAIS:

					$('#detalhesFormaPagamento').html(tblFormaPagamento['ordem']);
					$('#txtNumeroDocumento').val(pedido.pvnumero);
					$('#txtValorDocumento').val($.mask.string(diferenca.toFixed(2), 'decimal'));
					$("#txtVencimentoOrdemPagamento").val($.mask.string(stringDate, 'date'));
					$('#txtValorSt').val($.mask.string(parseFloat(pedido.calculoSt.substituicao).toFixed(2), 'decimal'));
					$('#txtValorPedidoSemSt').val($.mask.string(parseFloat(valorPedidoSemSt).toFixed(2), 'decimal'));

					totalValorPreFechamento = 0;
                                        if (pedido.preFechamento !== undefined && pedido.preFechamento !== null && pedido.preFechamento !== "") {
                                                                                 $.each(pedido.preFechamento, function (key, value) {
                                                                                                if (value.fecforma != '100' && value.fecforma != '102' && value.fecforma != '105' && value.fecforma != '106'  && value.fecforma != '111' && value.fecforma != '112' ) {
                                                                                                        totalValorPreFechamento += Number(value.fecvalor);

                                                                                                }
                                                                                 });

                                        }

                                   //     limiteDisponivel = Number(pedido.cliente.clilimite) - Number(pedido.cliente.vendasEmAberto.totalVendas)-Number(totalValorPreFechamento);
                                        limiteDisponivel = Number(pedido.cliente.clilimite) - Number(pedido.cliente.vendasEmAberto.cobrancaAberto)-Number(totalValorPreFechamento);
                                        $('#lblTotalLimiteDisponivel').text(parseFloat(limiteDisponivel).toFixed(2));
				break;
				case DESCONTOS_FINANCEIRO:

					$('#detalhesFormaPagamento').html(tblFormaPagamento['ordem']);
					$('#txtNumeroDocumento').val(pedido.pvnumero);
					$('#txtValorDocumento').val($.mask.string(diferenca.toFixed(2), 'decimal'));
					$("#txtVencimentoOrdemPagamento").val($.mask.string(stringDate, 'date'));
					$('#txtValorSt').val($.mask.string(parseFloat(pedido.calculoSt.substituicao).toFixed(2), 'decimal'));
					$('#txtValorPedidoSemSt').val($.mask.string(parseFloat(valorPedidoSemSt).toFixed(2), 'decimal'));

					totalValorPreFechamento = 0;
                                        if (pedido.preFechamento !== undefined && pedido.preFechamento !== null && pedido.preFechamento !== "") {
                                                                                 $.each(pedido.preFechamento, function (key, value) {
                                                                                                if (value.fecforma != '100' && value.fecforma != '102' && value.fecforma != '105' && value.fecforma != '106'   && value.fecforma != '111' && value.fecforma != '112' ) {
                                                                                                        totalValorPreFechamento += Number(value.fecvalor);

                                                                                                }
                                                                                 });

                                        }

                                   //     limiteDisponivel = Number(pedido.cliente.clilimite) - Number(pedido.cliente.vendasEmAberto.totalVendas)-Number(totalValorPreFechamento);
                                        limiteDisponivel = Number(pedido.cliente.clilimite) - Number(pedido.cliente.vendasEmAberto.cobrancaAberto)-Number(totalValorPreFechamento);
                                        $('#lblTotalLimiteDisponivel').text(parseFloat(limiteDisponivel).toFixed(2));
				break;

				case DUPLICATAS:
					$('#txtNumeroDocumento').attr('disabled','');
					$('#txtNumeroDocumento').val(pedido.pvnumero);
					$('#detalhesFormaPagamento').html(tblFormaPagamento['duplicata']);
					$('#listaTipoDuplicata').focus();
					valParcela = (diferenca/tmpCondicaoComercial.parcela);
					$("input[name*='txtParcelaDuplicata']").val($.mask.string(valParcela.toFixed(2), 'decimal'));
                                        diferencaParcelamento = valParcela.toFixed(2) * tmpCondicaoComercial.parcela;

                                             if ( pedidoValor !== diferencaParcelamento.toFixed(2)) {
                                                    valParcelaTmp = Number( valParcela.toFixed(2) );
                                                    diferencaTmp = Number( diferenca.toFixed(2) );
                                                    diferencaParcelamentoTmp = Number( diferencaParcelamento.toFixed(2) );

                                                              ultimaparcela = valParcelaTmp+(diferencaTmp - diferencaParcelamentoTmp);
                                                        $("input[name*='txtParcelaDuplicata"+tmpCondicaoComercial.parcela+"']").val($.mask.string(ultimaparcela.toFixed(2), 'decimal'));
                                                }

					$('#txtValorSt').val($.mask.string(parseFloat(pedido.calculoSt.substituicao).toFixed(2), 'decimal'));
					$('#txtValorPedidoSemSt').val($.mask.string(parseFloat(valorPedidoSemSt).toFixed(2), 'decimal'));
	//				$('#lblTotalLimiteDisponivel').val($.mask.string(parseFloat(pedido.cliente.clilimite).toFixed(2), 'decimal'));
                                        totalValorPreFechamento = 0;
                                        if (pedido.preFechamento !== undefined && pedido.preFechamento !== null && pedido.preFechamento !== "") {
                                                                                 $.each(pedido.preFechamento, function (key, value) {
                                                                                                if (value.fecforma != '100' && value.fecforma != '102' && value.fecforma != '105' && value.fecforma != '106'   && value.fecforma != '111' && value.fecforma != '112') {
                                                                                                        totalValorPreFechamento += Number(value.fecvalor);

                                                                                                }
                                                                                 });

                                        } else {
                                            totalValorPreFechamento = pedidoValor;
                                        }
                               //         limiteDisponivel = Number(pedido.cliente.clilimite) - Number(pedido.cliente.vendasEmAberto.totalVendas)-Number(totalValorPreFechamento);
                                        limiteDisponivel = Number(pedido.cliente.clilimite) - Number(pedido.cliente.vendasEmAberto.cobrancaAberto)-Number(totalValorPreFechamento);
                                        $('#lblTotalLimiteDisponivel').text(parseFloat(limiteDisponivel).toFixed(2));







				break;

				case CARTAO:
					$('#txtNumeroDocumento').attr('disabled','');
					$('#txtNumeroDocumento').val(pedido.pvnumero);
					$('#detalhesFormaPagamento').html(tblFormaPagamento['cartao']);
					valParcela = (diferenca/tmpCondicaoComercial.parcela);
					$("input[name*='txtParcelaCartao']").val($.mask.string(valParcela.toFixed(2), 'decimal'));
                                        diferencaParcelamento = valParcela.toFixed(2) * tmpCondicaoComercial.parcela;

                                                if ( pedidoValor !== diferencaParcelamento.toFixed(2)) {
                                                    valParcelaTmp = Number( valParcela.toFixed(2) );
                                                    diferencaTmp = Number( diferenca.toFixed(2) );
                                                    diferencaParcelamentoTmp = Number( diferencaParcelamento.toFixed(2) );

//                                                              ultimaparcela = valParcela.toFixed(2)+(diferenca.toFixed(2) - diferencaParcelamento.toFixed(2));
                                                              ultimaparcela = valParcelaTmp+(diferencaTmp - diferencaParcelamentoTmp);
                                                            $("input[name*='txtParcelaCartao"+tmpCondicaoComercial.parcela+"']").val($.mask.string(ultimaparcela.toFixed(2), 'decimal'));
                                            }

                                        $('#txtValorSt').val($.mask.string(parseFloat(pedido.calculoSt.substituicao).toFixed(2), 'decimal'));
					$('#txtValorPedidoSemSt').val($.mask.string(parseFloat(valorPedidoSemSt).toFixed(2), 'decimal'));
                                        totalValorPreFechamento = 0;
                                        if (pedido.preFechamento !== undefined && pedido.preFechamento !== null && pedido.preFechamento !== "") {
                                                                                 $.each(pedido.preFechamento, function (key, value) {
                                                                                                if (value.fecforma != '100' && value.fecforma != '102' && value.fecforma != '105' && value.fecforma != '106'   && value.fecforma != '111' && value.fecforma != '112') {
                                                                                                        totalValorPreFechamento += Number(value.fecvalor);

                                                                                                }
                                                                                 });

                                        }

                                  //      limiteDisponivel = Number(pedido.cliente.clilimite) - Number(pedido.cliente.vendasEmAberto.totalVendas)-Number(totalValorPreFechamento);
                                        limiteDisponivel = Number(pedido.cliente.clilimite) - Number(pedido.cliente.vendasEmAberto.cobrancaAberto)-Number(totalValorPreFechamento);
                                        $('#lblTotalLimiteDisponivel').text(parseFloat(limiteDisponivel).toFixed(2));
				break;


				case CHEQUE_PRE:
					$('#detalhesFormaPagamento').html(tblFormaPagamento['conta']);
					$('#txtNumeroDocumento').val(pedido.pvnumero+pedido.tipoPedido.auxiliadocumento);
					$('#txtValorDocumento').attr('disabled','');
					$('#txtNumeroDocFolha1').focus();
					valParcela = (diferenca/tmpCondicaoComercial.parcela);
					$("input[name*='txtValorDocFolha']").val($.mask.string(valParcela.toFixed(2), 'decimal'));
                                        diferencaParcelamento = valParcela.toFixed(2) * tmpCondicaoComercial.parcela;

                                                if ( pedidoValor !== diferencaParcelamento.toFixed(2)) {
                                                    valParcelaTmp = Number( valParcela.toFixed(2) );
                                                    diferencaTmp = Number( diferenca.toFixed(2) );
                                                    diferencaParcelamentoTmp = Number( diferencaParcelamento.toFixed(2) );

//                                                              ultimaparcela = valParcela.toFixed(2)+(diferenca.toFixed(2) - diferencaParcelamento.toFixed(2));
                                                              ultimaparcela = valParcelaTmp+(diferencaTmp - diferencaParcelamentoTmp);
                                                            $("input[name*='txtValorDocFolha"+tmpCondicaoComercial.parcela+"']").val($.mask.string(ultimaparcela.toFixed(2), 'decimal'));
                                                }

                                        $('#txtValorSt').val($.mask.string(parseFloat(pedido.calculoSt.substituicao).toFixed(2), 'decimal'));
					$('#txtValorPedidoSemSt').val($.mask.string(parseFloat(valorPedidoSemSt).toFixed(2), 'decimal'));
                                        totalValorPreFechamento = 0;
                                        if (pedido.preFechamento !== undefined && pedido.preFechamento !== null && pedido.preFechamento !== "") {
                                                                                 $.each(pedido.preFechamento, function (key, value) {
                                                                                                if (value.fecforma != '100' && value.fecforma != '102' && value.fecforma != '105' && value.fecforma != '106'  && value.fecforma != '111' && value.fecforma != '112') {
                                                                                                        totalValorPreFechamento += Number(value.fecvalor);

                                                                                                }
                                                                                 });

                                        } else {
                                            totalValorPreFechamento = pedidoValor;
                                        }
                                 //       limiteDisponivel = Number(pedido.cliente.clilimite) - Number(pedido.cliente.vendasEmAberto.totalVendas)-Number(totalValorPreFechamento);
                                        limiteDisponivel = Number(pedido.cliente.clilimite) - Number(pedido.cliente.vendasEmAberto.cobrancaAberto)-Number(totalValorPreFechamento);
                                        $('#lblTotalLimiteDisponivel').text(parseFloat(limiteDisponivel).toFixed(2));
				break;

				case CHEQUE_A_VISTA:
					$('#detalhesFormaPagamento').html(tblFormaPagamento['conta']);
					$('#txtNumeroDocumento').val(pedido.pvnumero+pedido.tipoPedido.auxiliadocumento);
					$('#txtValorDocumento').attr('disabled','');
					$('#txtNumeroDocFolha1').focus();
					valParcela = (diferenca/tmpCondicaoComercial.parcela);
					$("input[name*='txtValorDocFolha']").val($.mask.string(valParcela.toFixed(2), 'decimal'));
                                        diferencaParcelamento = valParcela.toFixed(2) * tmpCondicaoComercial.parcela;

                                                if ( pedidoValor !== diferencaParcelamento.toFixed(2)) {
                                                            valParcelaTmp = Number( valParcela.toFixed(2) );
                                                            diferencaTmp = Number( diferenca.toFixed(2) );
                                                            diferencaParcelamentoTmp = Number( diferencaParcelamento.toFixed(2) );

//                                                              ultimaparcela = valParcela.toFixed(2)+(diferenca.toFixed(2) - diferencaParcelamento.toFixed(2));
                                                              ultimaparcela = valParcelaTmp+(diferencaTmp - diferencaParcelamentoTmp);
                                                            $("input[name*='txtValorDocFolha"+tmpCondicaoComercial.parcela+"']").val($.mask.string(ultimaparcela.toFixed(2), 'decimal'));
                                                }

                                        $('#txtValorSt').val($.mask.string(parseFloat(pedido.calculoSt.substituicao).toFixed(2), 'decimal'));
					$('#txtValorPedidoSemSt').val($.mask.string(parseFloat(valorPedidoSemSt).toFixed(2), 'decimal'));
                                        totalValorPreFechamento = 0;
                                        if (pedido.preFechamento !== undefined && pedido.preFechamento !== null && pedido.preFechamento !== "") {
                                                                                 $.each(pedido.preFechamento, function (key, value) {
                                                                                                if (value.fecforma != '100' && value.fecforma != '102' && value.fecforma != '105'  && value.fecforma != '106'  && value.fecforma != '111' && value.fecforma != '112') {
                                                                                                        totalValorPreFechamento += Number(value.fecvalor);

                                                                                                }
                                                                                 });

                                        } else {
                                            totalValorPreFechamento = pedidoValor;
                                        }
                                 //       limiteDisponivel = Number(pedido.cliente.clilimite) - Number(pedido.cliente.vendasEmAberto.totalVendas)-Number(totalValorPreFechamento);
                                        limiteDisponivel = Number(pedido.cliente.clilimite) - Number(pedido.cliente.vendasEmAberto.cobrancaAberto)-Number(totalValorPreFechamento);
                                        $('#lblTotalLimiteDisponivel').text(parseFloat(limiteDisponivel).toFixed(2));
				break;
				case ORDEM_PAGAMENTO:
					$('#detalhesFormaPagamento').html(tblFormaPagamento['ordem']);
					$('#txtNumeroDocumento').val('');
					$('#txtValorDocumento').val($.mask.string(diferenca.toFixed(2), 'decimal'));
					$("#txtVencimentoOrdemPagamento").val($.mask.string(stringDate, 'date'));
					$('#txtValorSt').val($.mask.string(parseFloat(pedido.calculoSt.substituicao).toFixed(2), 'decimal'));
					$('#txtValorPedidoSemSt').val($.mask.string(parseFloat(valorPedidoSemSt).toFixed(2), 'decimal'));
                                        totalValorPreFechamento = 0;
                                        if (pedido.preFechamento !== undefined && pedido.preFechamento !== null && pedido.preFechamento !== "") {
                                                                                 $.each(pedido.preFechamento, function (key, value) {
                                                                                                if (value.fecforma != '100' && value.fecforma != '102' && value.fecforma != '105'  && value.fecforma != '106'  && value.fecforma != '111' && value.fecforma != '112') {
                                                                                                        totalValorPreFechamento += Number(value.fecvalor);

                                                                                                }
                                                                                 });

                                        } else {
                                            totalValorPreFechamento = pedidoValor;
                                        }
                                //        limiteDisponivel = Number(pedido.cliente.clilimite) - Number(pedido.cliente.vendasEmAberto.totalVendas)-Number(totalValorPreFechamento);
                                        limiteDisponivel = Number(pedido.cliente.clilimite) - Number(pedido.cliente.vendasEmAberto.cobrancaAberto)-Number(totalValorPreFechamento);
                                        $('#lblTotalLimiteDisponivel').text(parseFloat(limiteDisponivel).toFixed(2));
				break;

				case VALES:
					$('#txtNumeroDocumento').attr('disabled','disabled');
					$('#txtValorDocumento').val($.mask.string(0,'decimal'));
					$('#detalhesFormaPagamento').html(tblFormaPagamento['vales']);
					$('#txtValorSt').val($.mask.string(parseFloat(pedido.calculoSt.substituicao).toFixed(2), 'decimal'));
					$('#txtValorPedidoSemSt').val($.mask.string(parseFloat(valorPedidoSemSt).toFixed(2), 'decimal'));
					$('#listaTipoVale').focus();
					$("#listaTipoVale").change(function ()
					{
				    str = '';
				    jsTxt = 0;
				    jsTxt = $('#listaTipoVale').val();
				    for(i=0; i<jsTxt.length; i++)
				    {
				    novoArray =  jsTxt[i].split("|");
				    str -= Number(novoArray[2]);
				    }
				    $("#lblTotalVales").text($.mask.string(str.toFixed(2), 'decimal'));
//					$('#lblTotalLimiteDisponivel').val($.mask.string(parseFloat(pedido.cliente.clilimite).toFixed(2), 'decimal'));

				    }).trigger('change');
				break;




			}


			}
			else
			{
				$('#txtNumeroDocumento').attr('','').val('');
				$('#txtValorDocumento').attr('disabled','').val($.mask.string(parseFloat(pedidoValor).toFixed(2), 'decimal'));
				$('#detalhesFormaPagamento').html("");
				$('#txtValorSt').val($.mask.string(parseFloat(pedido.calculoSt.substituicao).toFixed(2), 'decimal'));
//				$('#lblTotalLimiteDisponivel').val($.mask.string(parseFloat(pedido.cliente.clilimite).toFixed(2), 'decimal'));
                                        totalValorPreFechamento = 0;
                                        if (pedido.preFechamento !== undefined && pedido.preFechamento !== null && pedido.preFechamento !== "") {
                                                                                 $.each(pedido.preFechamento, function (key, value) {
                                                                                                if (value.fecforma != '100' && value.fecforma != '102' && value.fecforma != '105' && value.fecforma != '106'   && value.fecforma != '111' && value.fecforma != '112' ) {
                                                                                                        totalValorPreFechamento += Number(value.fecvalor);

                                                                                                }
                                                                                 });

                                        } else {
                                            totalValorPreFechamento = pedidoValor;
                                        }
                                  //      limiteDisponivel = Number(pedido.cliente.clilimite) - Number(pedido.cliente.vendasEmAberto.totalVendas)-Number(totalValorPreFechamento);
                                        limiteDisponivel = Number(pedido.cliente.clilimite) - Number(pedido.cliente.vendasEmAberto.cobrancaAberto)-Number(totalValorPreFechamento);
                                        $('#lblTotalLimiteDisponivel').text(parseFloat(limiteDisponivel).toFixed(2));
			}


		});
		$('#txtNumeroDocumento').keyup(function()
			{
				$("input[name*='txtDocumentoOrderPagamento']").val($("#txtNumeroDocumento").val());
			});

		$("#listaPesquisaPedidos").ajaxComplete(function()
			{
			$("#btnIncluirFormaPagamento").attr('disabled','');



		$("#lblTotalPagar").text(pedidoValor.toFixed(2));
		$("#lblTotalPago").text(pedido.TotalValorPreFechamento);
		diferenca = pedidoValor-pedido.TotalValorPreFechamento;
		$("#lblDiferencaPagar").text(diferenca.toFixed(2));

//alert("pedido.cliente.vendasEmAberto:" + pedido.cliente.vendasEmAberto.totalVendas + "\n"+"totalValorPreFechamento:" + totalValorPreFechamento.toFixed(2));
	                                            totalValorPreFechamento = 0;
                                        if (pedido.preFechamento !== undefined && pedido.preFechamento !== null && pedido.preFechamento !== "") {
                                                                                 $.each(pedido.preFechamento, function (key, value) {
                                                                                                if (value.fecforma != '100' && value.fecforma != '102' && value.fecforma != '105'  && value.fecforma != '106'  && value.fecforma != '111' && value.fecforma != '112') {
                                                                                                        totalValorPreFechamento += Number(value.fecvalor);

                                                                                                }
                                                                                 });

                                        } else {
                                            totalValorPreFechamento = pedidoValor;
                                        }
                          //              limiteDisponivel = Number(pedido.cliente.clilimite) - Number(pedido.cliente.vendasEmAberto.totalVendas)-Number(totalValorPreFechamento);
                                        limiteDisponivel = Number(pedido.cliente.clilimite) - Number(pedido.cliente.vendasEmAberto.cobrancaAberto)-Number(totalValorPreFechamento);
                                        $('#lblTotalLimiteDisponivel').text(parseFloat(limiteDisponivel).toFixed(2));


		if(diferenca.toFixed(2)=='0.00' ||diferenca.toFixed(2)=='0' || diferenca.toFixed(2)=='-0.00' || diferenca.toFixed(2)=='-0')
			{
				msg = "PREFECHAMENTO REALIZADO COM SUCESSO";
				alert('PREFECHAMENTO REALIZADO COM SUCESSO');
				$("#retorno").messageBox(msg,true, true);
				$("#btnIncluirFormaPagamento").attr('disabled','disabled');
			}

		if(diferenca.toFixed(2)< '0.00' ||diferenca.toFixed(2)< '0')
			{
			 	$("#btnIncluirFormaPagamento").attr('disabled','disabled');
			}

			});



		$("#btnAlterarFormaPreFechamentoPagamento").click(function()
				{
					$('#txtParcelaCartao').attr('disabled','');
					$('#listaCondicoesComerciais').show();
					$('#txtCondicoesComerciais').hide();

			    	// jsonText2 = $("#listaCondicoesComerciais").val();
			    	// condicaoComercialPreFechamento = eval('(' + jsonText2 + ')');
				});


		$("#listaCondicoesComerciais").change(function()
				{

			 jsonText2 = $("#listaCondicoesComerciais").val();
	    	 codigoCM = eval('(' + jsonText2 + ')');
				});


		$("#btnRecalcularParcelas").click(function()
				{


	    	 $.each(condicoesComerciais, function (key, value)
	    				{
	    		 if(codigoCM == key)
	    		 {
	    			 condicaoComercialPreFechamento.codigo = value.codigo;
	    			 condicaoComercialPreFechamento.descricao = value.descricao;
	    			 condicaoComercialPreFechamento.inicial = value.inicial;
	    			 condicaoComercialPreFechamento.parcela = value.parcela;
	    			 condicaoComercialPreFechamento.salto = value.salto;

	    			 pedido.condicaoComercial = new Object();
	    			 pedido.condicaoComercial.codigo = value.codigo;
	    			 pedido.condicaoComercial.descricao = value.descricao;
	    			 pedido.condicaoComercial.inicial = value.inicial;
	    			 pedido.condicaoComercial.parcela = value.parcela;
	    			 pedido.condicaoComercial.salto = value.salto;


	    		 }
	    				});

	    	 alteraCondcom = new Object();
	    	 alteraCondcom.pvcondcom = condicaoComercialPreFechamento.codigo;
	    	 alteraCondcom.pvnumero = pedido.pvnumero;


	    		$.post('modulos/vendaAtacado/pedidos/manutencao/controller/acoes.php',
	    				{

	    				//variaveis a ser enviadas metodo POST
	    			pvcondcon:condicaoComercialPreFechamento.codigo,
	    			pvnumero:alteraCondcom.pvnumero,
	    			acao:6

	    				},
	    				function(data)
	    				{
	    					if (Boolean(Number(data.retorno)))
	    					{
	    						//alert('1');
	    						//pedido.preFechamento = new Object();
	    						//$("#retorno").messageBox(data.mensagem,data.retorno,true);
	    						$("#lblTotalPagar").text(Number(pedidoValor).toFixed(2));
	    						$("#lblTotalPago").text(0);
	    						//diferenca = pedidoValor-pedido.TotalValorPreFechamento;
	    						diferenca = $("#lblTotalPagar").text() - $("#lblTotalPago").text();
	    						$("#lblDiferencaPagar").text(Number(diferenca));

                                                                                                totalValorPreFechamento = 0;
                                                                                                if (pedido.preFechamento !== undefined && pedido.preFechamento !== null && pedido.preFechamento !== "") {
                                                                                                                                         $.each(pedido.preFechamento, function (key, value) {
                                                                                                                                                        if (value.fecforma != '100' && value.fecforma != '102' && value.fecforma != '105' && value.fecforma != '106'   && value.fecforma != '111' && value.fecforma != '112') {
                                                                                                                                                                totalValorPreFechamento += Number(value.fecvalor);

                                                                                                                                                        }
                                                                                                                                         });

                                                                                                } else {
                                                                                                    totalValorPreFechamento = pedidoValor;
                                                                                                }
                                                                                       //         limiteDisponivel = Number(pedido.cliente.clilimite) - Number(pedido.cliente.vendasEmAberto.totalVendas)-Number(totalValorPreFechamento);
                                                                                                limiteDisponivel = Number(pedido.cliente.clilimite) - Number(pedido.cliente.vendasEmAberto.cobrancaAberto)-Number(totalValorPreFechamento);
                                                                                                $('#lblTotalLimiteDisponivel').text(parseFloat(limiteDisponivel).toFixed(2));

	    				    }
	    					else
	    					{
	    						//alert('0');
	    						pedido.preFechamento = new Object();
	    						$("#retorno").messageBox(data.mensagem,data.retorno,false);

	    						$("#lblTotalPagar").text(pedidoValor.toFixed(2));
	    						$("#lblTotalPago").text(0);
	    						diferenca = pedidoValor-pedido.TotalValorPreFechamento;
	    						//diferenca = 0;
	    						$("#lblDiferencaPagar").text(Number(diferenca));


	    					}
	    					$.unblockUI();
	    				}, "json");

				});
				});
				function limpaFormFormaPagamento()
				{
					$("#txtValorDocumento").val($("#lblDiferencaPagar").text());
					$("#listaFormaPagamento").val('');
					$('#detalhesFormaPagamento').html('');
					$('#txtNumeroDocumento').val('');

					$('#formFormaPagamento').validate().resetForm();
				}
