/**
 * @author Wellington
 *
 * CRUD - ações jquery para insert, delete, update e select.
 *
 * Criação    04/11/2009
 * Modificado 11/01/2010
 *
 *	PARA ACAO USE verifique o aquivo config.js lib/jquery/max;
 *		1 -> INSERT
 *		2 -> SELECT
 *		3 -> UPDATE
 *		4 -> DELETE
 */

$(function()
{	
	$("input[name='botao']").click(function()
	{
		var idBotao = $(this).val();		
		var pesquisa = $('#pesquisa').val();
		var titulo = "";
		var mensagem = "";
		var msg = "";
		var jsonText = "";
		
		switch(idBotao)
		{
			case BOTAO_APROPRIAR:
				
				$(this).attr("disabled","disabled");
				
				//mensagens para verificação dos campos
				var msg ="NECESSARIO INFORMAR O(S) CAMPO(S) ABAIXO PARA APROPRIAR ESTOQUE:<br>";

				if(!$('#formTipoPedido').validate().form())
				{
					msg += "<br><b> - TIPO DE PEDIDO</b>";
				}

				switch (Number(pedido.tipoPedido.codigo))
				{
					case ABASTECIMENTO:
						if(!$('#formEstoqueOrigem').validate().form())
						{
							msg += "<br><b> - ESTOQUE DE ORIGEM</b>"; 
						}

						if(!$('#formEstoqueDestino').validate().form())
						{
							msg += "<br><b> - ESTOQUE DE DESTINO</b>";
						}
						break;

					case DEVOLUCAO:
						if(!$('#formResultadoFornecedores').validate().form())
						{
							msg += "<br><b> - FORNECEDOR</b>";
						}
						if(!$('#formResultadoTransportadoras').validate().form())
						{
							msg += "<br><b> - TRANSPORTADORA</b>";
						}
						break;
						
					default:
						if(!$('#formResultadoClientes').validate().form())
						{
							msg += "<br><b> - CLIENTE</b>";
						}
						if(!$('#formResultadoVendedores').validate().form())
						{
							msg += "<br><b> - VENDEDOR</b>";
						}
						
						if(!$('#formCondicoesComerciais').validate().form())
						{
							msg += "<br><b> - CONDICAO COMERCIAL</b>";
						}
						if(!$('#formResultadoTransportadoras').validate().form())
						{
							msg += "<br><b> - TRANSPORTADORA</b>";
						}
						break;
				}

				if (!itensPedido.length)
				{
					if (!itensPedidoEmpenho.length)
					{
						msg += "<br><b> - PRODUTO(S)</b>";
					}
				}
				
				var isInserir = false;
				if($('#formTipoPedido').validate().form() && (itensPedido.length > 0 || itensPedidoEmpenho.length > 0))
				{
					
					switch (Number(pedido.tipoPedido.codigo))
					{
						case ABASTECIMENTO:
							if($('#formEstoqueOrigem').validate().form() && $('#formEstoqueDestino').validate().form())
							{
								isInserir = true;
							}
							break;
							
						case DEVOLUCAO:
							if($('#formResultadoFornecedores').validate().form() && $('#formResultadoTransportadoras').validate().form())
							{
								isInserir = true;
							}
							break;
							
						default:
							if($('#formResultadoClientes').validate().form() && $('#formResultadoVendedores').validate().form() && $('#formCondicoesComerciais').validate().form() && $('#formResultadoTransportadoras').validate().form())
							{
								isInserir = true;
							}
							break;
					}
				}
				
				
				if (isInserir)
				{
					titulo = "PROCESSANDO, AGUARDE...";
					mensagem = "EXECUTANDO APROPRIACAO DE ESTOQUE.";
					
					$("#retorno").messageBoxModal(titulo, mensagem);
					
					var tipoLocal = 0;
					if (itensPedido.length)
					{
						tipoLocal = Number(itensPedido[0].estoques[0].estoqueAtual.estoque.estoqueFisico.etqfcodigo) == VIX ? 2 : 1;
					}
					else if (itensPedidoEmpenho.length)
					{
						tipoLocal = Number(itensPedidoEmpenho[0].estoques[0].estoqueAtual.estoque.estoqueFisico.etqfcodigo) == VIX ? 2 : 1;
					}
					
					pedido.pvemissao = new Date();
					pedido.pvvaldesc = valorDesconto;
					pedido.pvperdesc = percentualDesconto;
					pedido.pvvalor = subtotal;
					pedido.pvobserva = $('#txtExcecoes').val();
					pedido.pvencer = 1;
					pedido.pvnewobs = $('#txtObservacao').val();
					pedido.pvlocal = $('#txtLocalEntrega').val();
					pedido.pvtipofrete = Number($("input[name='opcoesTipoFrete']:checked").val());
					pedido.pventrega = new Date().dateBr(($('#dataEntrega').val()));
					pedido.itensPedido = new Array();
					pedido.usuario = usuario;
					pedido.tipolocal = tipoLocal;
					pedido.estoqueFisico = estoqueAtivo.estoqueFisico;
					pedido.pvlibdep = '';
					pedido.pvlibmat = '';
					pedido.pvlibfil = '';
					pedido.pvlibvit = '';
					
					if(pedido.tipoPedido.codigo == DEVOLUCAO || pedido.tipoPedido.codigo == ALMOXERIFADO)
					{
					if(estoqueAtivo.etqcodigo=='3' || estoqueAtivo.etqcodigo=='4' || estoqueAtivo.etqcodigo=='6' || estoqueAtivo.etqcodigo=='9' ||estoqueAtivo.etqcodigo=='13' ||estoqueAtivo.etqcodigo=='14' ||estoqueAtivo.etqcodigo=='15' ||estoqueAtivo.etqcodigo=='16' ||estoqueAtivo.etqcodigo=='18' ||estoqueAtivo.etqcodigo=='19' ||estoqueAtivo.etqcodigo=='20' ||estoqueAtivo.etqcodigo=='23')
					{
						pedido.pvlibdep = '1';	
					}
					if(estoqueAtivo.etqcodigo=='1' || estoqueAtivo.etqcodigo=='22' )
					{
						pedido.pvlibfil = '1';	
					}
					if(estoqueAtivo.etqcodigo=='2' || estoqueAtivo.etqcodigo=='21' )
					{
						pedido.pvlibmat = '1';	
					}
					if(estoqueAtivo.etqcodigo=='11' || estoqueAtivo.etqcodigo=='17' || estoqueAtivo.etqcodigo=='24')
					{
						pedido.pvlibvit = '1';	
					}
						
					}
					
					if (pedido.tipoPedido.codigo == ABASTECIMENTO)
					{
						var data = new Date();
						pedido.pvlibera = data.copy();
						pedido.pvhora = data.format('H:m');
						switch (Number(pedido.estoqueOrigem.estoqueFisico.etqfcodigo))
						{
							case CD:
								pedido.pvlibdep = '1';
								break;
							case MAT:
								pedido.pvlibmat = '1';
								break;
							case FIL:
								pedido.pvlibfil = '1';
								break;
							case VIX:
								pedido.pvlibvit = '1';
								break;
						}
						
					}

					crudExe(INSERT);
					$(this).attr("disabled", "");
				}
				else
				{
					$("#retorno").messageBox(msg, false, true);
					$(this).attr("disabled", "");
				}
				break;
			
			case BOTAO_ALTERAR:
				$('#divPedido').unblock();
				grupoBotoes(0, BOTAO_CONFIRMAR, BOTAO_RESTAURAR, BOTAO_NOVO);
				break;
			
			case BOTAO_CONFIRMAR:
				//mensagens para verificação dos campos
				var msg ="NECESSARIO INFORME O(S) CAMPO(S) ABAIXO PARA ALTERACAO DO PEDIDO:<br>";

				if(!$('#formTipoPedido').validate().form())
				{
					msg += "<br><b> - TIPO DE PEDIDO</b>";
				}

				switch (Number(pedido.tipoPedido.codigo))
				{
					case DEVOLUCAO:
						if(!$('#formResultadoFornecedores').validate().form())
						{
							msg += "<br><b> - FORNECEDOR</b>";
						}
						
						if(!$('#formResultadoTransportadoras').validate().form())
						{
							msg += "<br><b> - TRANSPORTADORA</b>";
						}
						break;
						
					default:
						if(!$('#formResultadoClientes').validate().form())
						{
							msg += "<br><b> - CLIENTE</b>";
						}
						
						if(!$('#formResultadoVendedores').validate().form())
						{
							msg += "<br><b> - VENDEDOR</b>";
						}
						
						if(!$('#formCondicoesComerciais').validate().form())
						{
							msg += "<br><b> - CONDICAO COMERCIAL</b>";
						}
						
						if(!$('#formResultadoTransportadoras').validate().form())
						{
							msg += "<br><b> - TRANSPORTADORA</b>";
						}
						break;
				}

				if (!itensPedido.length)
				{
					if (!itensPedidoEmpenho.length)
					{
						msg += "<br><b> - PRODUTO(S)</b>";
					}
				}
				
				var isAlterar = false;
				if($('#formTipoPedido').validate().form() && itensPedido.length > 0)
				{
					switch (Number(pedido.tipoPedido.codigo))
					{
						case ABASTECIMENTO:
							if($('#formEstoqueOrigem').validate().form() && $('#formEstoqueDestino').validate().form())
							{
								isAlterar = true;
							}
							break;
							
						case DEVOLUCAO:
							if($('#formResultadoFornecedores').validate().form() && $('#formResultadoTransportadoras').validate().form())
							{
								isAlterar = true;
							}
							break;
							
						default:
							if($('#formResultadoClientes').validate().form() && $('#formResultadoVendedores').validate().form() && $('#formCondicoesComerciais').validate().form() && $('#formResultadoTransportadoras').validate().form())
							{
								isAlterar = true;
							}
							break;
					}
				}
				
				if (isAlterar)
				{
					titulo = "PROCESSANDO, AGUARDE...";
					mensagem = "EXECUTANDO ALTERACAO DE PEDIDO.";
					
					$("#retorno").messageBoxModal(titulo, mensagem);
					
					var tipoLocal = 0;
					if (itensPedido.length)
					{
						tipoLocal = Number(itensPedido[0].estoques[0].estoqueAtual.estoque.estoqueFisico.etqfcodigo) == VIX ? 2 : 1;
					}
					else if (itensPedidoEmpenho.length)
					{
						tipoLocal = Number(itensPedidoEmpenho[0].estoques[0].estoqueAtual.estoque.estoqueFisico.etqfcodigo) == VIX ? 2 : 1;
					}

					pedido.pvvaldesc = valorDesconto;
					pedido.pvperdesc = percentualDesconto;
					pedido.pvvalor = subtotal;
					pedido.pvobserva = $('#txtExcecoes').val();
					pedido.pvnewobs = $('#txtObservacao').val();
					pedido.pvlocal = $('#txtLocalEntrega').val();
					pedido.pvtipofrete = Number($("input[name='opcoesTipoFrete']:checked").val());
					pedido.pventrega = new Date().dateBr(($('#dataEntrega').val()));
					pedido.itensPedido = new Array();
					pedido.usuario = usuario;
					pedido.tipolocal = tipoLocal;
					pedido.estoqueFisico = estoqueAtivo.estoqueFisico;
					pedido.pvlibdep = '';
					pedido.pvlibmat = '';
					pedido.pvlibfil = '';
					pedido.pvlibvit = '';
					
					if(pedido.tipoPedido.codigo == DEVOLUCAO || pedido.tipoPedido.codigo == ALMOXERIFADO)
					{
					if(estoqueAtivo.etqcodigo=='3' || estoqueAtivo.etqcodigo=='4' || estoqueAtivo.etqcodigo=='6' || estoqueAtivo.etqcodigo=='9' ||estoqueAtivo.etqcodigo=='13' ||estoqueAtivo.etqcodigo=='14' ||estoqueAtivo.etqcodigo=='15' ||estoqueAtivo.etqcodigo=='16' ||estoqueAtivo.etqcodigo=='18' ||estoqueAtivo.etqcodigo=='19' ||estoqueAtivo.etqcodigo=='20' ||estoqueAtivo.etqcodigo=='23')
					{
						pedido.pvlibdep = '1';	
					}
					if(estoqueAtivo.etqcodigo=='1' || estoqueAtivo.etqcodigo=='22' )
					{
						pedido.pvlibfil = '1';	
					}
					if(estoqueAtivo.etqcodigo=='2' || estoqueAtivo.etqcodigo=='21' )
					{
						pedido.pvlibmat = '1';	
					}
					if(estoqueAtivo.etqcodigo=='11' || estoqueAtivo.etqcodigo=='17' || estoqueAtivo.etqcodigo=='24')
					{
						pedido.pvlibvit = '1';	
					}
						
					}
					
					if (pedido.tipoPedido.codigo == ABASTECIMENTO)
					{
						var data = new Date();
						pedido.pvlibera = data.copy();
						pedido.pvhora = data.format('H:m');
						switch (Number(pedido.estoqueOrigem.estoqueFisico.etqfcodigo))
						{
							case CD:
								pedido.pvlibdep = '1';
								break;
							case MAT:
								pedido.pvlibmat = '1';
								break;
							case FIL:
								pedido.pvlibfil = '1';
								break;
							case VIX:
								pedido.pvlibvit = '1';
								break;
						}
						
					}
					

					crudExe(UPDATE);
				}
				else
				{
					$("#retorno").messageBox(msg, false, true);
				}
				break;
			
			case BOTAO_RESTAURAR:
				populaCampos(false);
				break;
			
			case BOTAO_EXCLUIR:
				$('#dialog').attr('title','EXCLUIR PEDIDO');
				$('#dialog').html('<p>TEM CERTEZA QUE DESEJA EXCLUIR PEDIDO.</p>');
				
				pedido.usuario = usuario;
				
				$('#dialog').dialog({
					autoOpen: true,
					width: 600,
					modal: true,
					buttons: 
					{
						"Ok": function()
						{
							$(this).dialog("close");
							
							titulo = "PROCESSANDO, AGUARDE...";
							mensagem = "EXECUTANDO EXCLUSAO DO PEDIDO.";
							
							$("#retorno").messageBoxModal(titulo, mensagem);
							
							crudExe(DELETE);
						},
						"Cancel": function()
						{
							$(this).dialog("close");
						}
					},
					close: function(ev, ui)
					{
						$(this).dialog("destroy");
					}
				});
				break;
			
			case BOTAO_PESQUISAR:
				if($('#formPesquisa').validate().form())
				{
					usuario.login = pesquisa;
					crudExe(SELECT);
				}
				break;
			
			case BOTAO_NOVO:
				if (pedido.usuario.codigo == usuario.codigo)
				{
					travaPedido(false);
				}
				limpaPesquisaPedidos();
				
				$('#divPedido').unblock();
				
			case BOTAO_LIMPAR:
				pedido = new Object();
				pedidoEmpenho = new Object();
				novoForm();
				break;
				
			case BOTAO_SALVAR:
				var ped = new Object();

				ped.tipoPedido = pedido.tipoPedido.sigla+" - "+pedido.tipoPedido.descricao;
				
				if(estoqueAtivo.etqcodigo != undefined){
					ped.estoqueAtivo = estoqueAtivo.etqcodigo;
				}
				
				if(pedido.condicaoComercial){
					ped.condicaoComercial = pedido.condicaoComercial.descricao;
				}
				
				if(pedido.estoqueOrigem){
					ped.estoqueOrigem = pedido.estoqueOrigem.etqcodigo;
				}
				
				if(pedido.estoqueDestino){
					ped.estoqueDestino = pedido.estoqueDestino.etqcodigo;
				}
				
				if(pedido.cliente){
					ped.cliente = pedido.cliente.clicod;
				}
				
				if(pedido.vendedor){
					ped.vendedor = pedido.vendedor.vencodigo;
				}
				
				if(pedido.transportadora){
					ped.transportadora = pedido.transportadora.tracodigo;
				}
				
				if(pedido.fornecedor){
					ped.fornecedor = pedido.fornecedor.forcod;
				}
				
				ped.itensPedido = new Array();
				
				$.each(itensPedido, function (key, value)
				{
					var item = new Object();
					item.procod = value.produto.procod;
					item.pvisaldo = value.pvisaldo;
					item.pvitippr = value.pvitippr;
					item.pvipreco = value.pvipreco;
					
					ped.itensPedido.push(item);
				});
				
				if (itensPedido.length > 0)
				{
					window.open("newPedidoExcel.php?pedido="+JSON.stringify(ped), "JANELA", "height = 300, width = 400");
				}
				break;
				
			case BOTAO_ABRIR:
				importarPedido();
				break;
		}
	});
	
	
	$("#destravarPedido").click(function()
			{ 
		window.open('pedvendadestrava.php?pvnumero='+pedido.pvnumero, 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');
		
				});
	
	$("#edicaoSimples").click(function()
			{ 
		//window.open('alterarpvendasimples.php.php?pvnumero='+pedido.pvnumero, 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');
		window.open('alterarpvendasimples.php', 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');
		
				});
	
	
	//eventos click disparar btn
	$('#btn1s').click(function()
	{
	    $('#btn1').live('click',function(){});
	});
	
	$('#btn2s').click(function()
	{
	    $('#btn2').live('click',function(){});
	});
	
	$('#btn3s').click(function()
	{
	    $('#btn3').live('click',function(){});
	});
	
	$('#btn4s').click(function()
	{
	    $('#btn4').live('click',function(){});
	});
	
	$('#importarPedido').click(function()
	{
		importarPedido();
	});
 });