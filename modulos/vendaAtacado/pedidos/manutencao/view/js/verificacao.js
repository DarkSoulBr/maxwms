/**
 * @author Wellington
 *
 * Verificação dos dados para envio de formulario.
 *
 * Criação    15/12/2009
 * Modificado 15/12/2009
 *
 */
	
$(function(){

	window.onload = function(){
		grupoBotoes(BOTAO_LIMPAR, BOTAO_ABRIR, BOTAO_APROPRIAR, BOTAO_SALVAR);
	};
	
	var dataEmissao = new Date();
	
	//inicia valores ta tela
	$("#dataEmissaoPedido").val($.mask.string(dataEmissao.format('dmY'), 'date'));
	$("#lblSubtotal").text($.mask.string(0, 'decimal'));
	$("#lblValorDesconto").text($.mask.string(0, 'decimal'));
	$("#lblTotalMattel").text($.mask.string(0, 'decimal'));
	$("#lblTotal").text($.mask.string(0, 'decimal'));
	$("#lblLimiteDisponivel").text($.mask.string(0, 'decimal'));
	$("#lblLimiteTotal").text($.mask.string(0, 'decimal'));
	$("#lblDataUltimaCompra").text('--');
	$("#lblSerasa").text('NAO');
	$('#tblFornecedor').hide();
	$('#tblEstoqueOrigem').hide();
	$('#tblEstoqueDestino').hide();
	$("#txtPercentualDesconto").val(0);
	
	$('#tblLimites').hide();
	
	//verificação da pesquisa do Tipo de Pedido
	$('#listaTipoPedidos').focus()
	.blur(function()
	{
		$('#formTipoPedido').validate().form();
		$('#listaTipoPedidos').focus();
	})
	.change(function()
	{		
		pedido.tipoPedido = tiposPedido[$('#listaTipoPedidos').val()];
		hideShowComponente();

		if ($('#formTipoPedido').validate().form())
		{
			$('#formResultadoClientes').validate().form();
			$('#formResultadoFornecedores').validate().form();
			$('#formResultadoVendedores').validate().form();
			$('#formCondicoesComerciais').validate().form();
			
			if ($('#formResultadoProdutos').validate().form())
			{
				$.each(produtos, function (kProduto, vProduto)
				{
					if (vProduto.procodigo == produto.procodigo)
					{
						if(pedido.tipoPedido.codigo == DEVOLUCAO || pedido.tipoPedido.codigo == ABASTECIMENTO || pedido.tipoPedido.codigo == BAIXA || pedido.tipoPedido.codigo == ALMOXERIFADO)
						{
							var lista = new Object();
							if($('#listaEstoqueOrigem').val())
							{
								lista = estoques[$('#listaEstoqueOrigem').val()];
							}
							
							if(lista.etqnome == "VIX")
							{
								produto.tabelaValores.A = Number(produto.profinalv);
								produto.tabelaValores.B = Number(produto.profinalv);
								produto.tabelaValores.C = Number(produto.profinalv);
							}
							else
							{
								produto.tabelaValores.A = Number(produto.profinal);
								produto.tabelaValores.B = Number(produto.profinal);
								produto.tabelaValores.C = Number(produto.profinal);
							}
						}
						else
						{
							produto.tabelaValores.A = Number(vProduto.tabelaValores.A);
							produto.tabelaValores.B = Number(vProduto.tabelaValores.B);
							produto.tabelaValores.C = Number(vProduto.tabelaValores.C);
						}
						
						$("#txtProdutoTabelaA").val($.mask.string(produto.tabelaValores.A.toFixed(2), 'decimal'));
						$("#txtProdutoTabelaB").val($.mask.string(produto.tabelaValores.B.toFixed(2), 'decimal'));
						$("#txtProdutoTabelaC").val($.mask.string(produto.tabelaValores.C.toFixed(2), 'decimal'));
					}
				});
			}
			
			$('#formResultadoTransportadoras').validate().form();
		}
		else
		{
			$("#formResultadoClientes").validate().resetForm();
			$("#formResultadoFornecedores").validate().resetForm();
			$("#formResultadoVendedores").validate().resetForm();
			$('#formCondicoesComerciais').validate().resetForm();
			$('#formResultadoProdutos').validate().resetForm();
			$('#formResultadoTransportadoras').validate().resetForm();
		}
		
		if (pedido.tipoPedido)
		{
			pedido.fecreserva = '0';
			if(pedido.tipoPedido.codigo == RESERVA)
			{
				$('#dialog').attr('title', 'PEDIDO RESERVA');
				$('#dialog').html("ESCOLHA FECHAMENTO DO PEDIDO RESERVA.");
				$('#dialog').dialog(
				{
					autoOpen: true,
					closeOnEscape: false,
					modal: true,
					width: 480,
					buttons: 
					{
						"Pedido Mãe": function()
						{
							$(this).dialog("close");
							pedido.fecreserva = '1';
						},
						"Pedido Filhote": function() 
						{
							$(this).dialog("close");
							pedido.fecreserva = '0';
							
						}
					},
					close: function(ev, ui)
					{
						$(this).dialog("destroy");
					}
				});
				//$(".ui-dialog-titlebar-close").css("display", "none");
			}
			
		}
		
		
		$("#txtPesquisaClientes").focus() || $("#txtPesquisaFornecedores").focus();
	});
	
	//verificação de pesquisa clientes
	$("#btnPesquisaClientes").click(function()
	{
		if ($('#formPesquisaClientes').validate().form())
		{
			$("#txtPesquisaVendedores").focus();
		}
		
		$("#listaPesquisaClientes").ajaxComplete(function(e, xhr, settings)
		{
			var value = eval('(' + xhr.responseText + ')');
			if(value.clientes)
			{
				pedido.cliente = cliente;
				verificaPedidoTmp();
				$(this).unbind('ajaxComplete');
			}
		})
		.change(function()
		{
			pedido.cliente = cliente;
			$("#txtPesquisaVendedores").focus();
		});
	});
	
	//verificação de pesquisa fornecedores
	$("#btnPesquisaFornecedores").click(function()
	{
		if ($('#formPesquisaFornecedores').validate().form())
		{
			$("#txtPesquisaVendedores").focus();
		}
		
		$("#listaPesquisaFornecedores").ajaxComplete(function(e, xhr, settings) 
		{				
			var value = eval('(' + xhr.responseText + ')');
			if(value.fornecedores)
			{
				pedido.fornecedor = fornecedor;
				$(this).unbind('ajaxComplete');
			}
		})
		.change(function()
		{
			pedido.fornecedor = fornecedor;
			$("#txtPesquisaVendedores").focus();
		});
	});
	
	//verificação da seleção do estoque origem
	$('#listaEstoqueOrigem').change(function()
	{
		if($('#listaEstoqueOrigem').val())
		{
			pedido.estoqueOrigem = estoques[$('#listaEstoqueOrigem').val()];
			if (pedido.estoqueOrigem != undefined)
			{
				if (pedido.estoqueOrigem.etqcodigo != undefined)
				{
					verificaPedidoTmp();
				}
			}
		}
		else
		{
			pedido.estoqueOrigem = new Object();
		}
	});
	
	//verificação da seleção do estoque destino
	$('#listaEstoqueDestino').change(function()
	{
		if($('#listaEstoqueDestino').val())
		{
			pedido.estoqueDestino = estoques[$('#listaEstoqueDestino').val()];
			if (pedido.estoqueOrigem != undefined)
			{
				if (pedido.estoqueOrigem.etqcodigo != undefined)
				{
					verificaPedidoTmp();
				}
			}
		}
		else
		{
			pedido.estoqueDestino = new Object();
		}
	});
	
//verificação de pesquisa vendedores
	$("#btnPesquisaVendedores").click(function()
	{
		if ($('#formPesquisaVendedores').validate().form())
		{
			$("#listaCondicoesComerciais").focus();
		}
		
		$("#listaPesquisaVendedores").ajaxComplete(function(e, xhr, settings)
		{
			var value = eval('(' + xhr.responseText + ')');
			if(value.vendedores)
			{
				pedido.vendedor = vendedor;
				$(this).unbind('ajaxComplete');
			}
		})
		.change(function()
		{
			$("#listaCondicoesComerciais").focus();
			pedido.vendedor = vendedor;
		});
	});
	
//verificação da Seleção Condições Comerciais
	$("#listaCondicoesComerciais").change(function()
	{
		pedido.condicaoComercial = condicoesComerciais[$(this).val()];
		if ($('#formCondicoesComerciais').validate().form())
		{
			$('#txtCondicoesComerciais').val(pedido.condicaoComercial.descricao);
			$("#txtLocalEntrega").focus();
			
			$('#listaFormaPagamento').val('');
			$('#txtNumeroDocumento').val('');
			$('#txtValorDocumento').val($.mask.string(0, 'decimal'));
			$('#detalhesFormaPagamento').html("");
			
			if (itensPedido.length > 0)
			{
				$("#btnIncluirFormaPagamento").attr("disabled","");
				$("#listaFormaPagamento").attr("disabled","");
				
				if (usuario.tipoAcessos[114] || usuario.tipoAcessos[115])
				{
					if (pedido.condicaoComercial.codigo == 1)
					{
						$('#txtValorDesconto').attr('disabled','');
						$('#txtPercentualDesconto').attr('disabled','');
					}
					else
					{
						$('#txtValorDesconto').attr('disabled','disabled');
						$('#txtPercentualDesconto').attr('disabled','disabled');
						
						$('#txtPercentualDesconto').val($.mask.string(0, 'percentual'));
						$('#txtValorDesconto').val($.mask.string(0, 'decimal'));
					}
				}
			}
			else
			{
				$("#btnIncluirFormaPagamento").attr("disabled","disabled");
				$("#btnIncluirFormaPagamento").attr("disabled","disabled");
				
				$('#txtPercentualDesconto').val($.mask.string(0, 'percentual'));
				$('#txtValorDesconto').val($.mask.string(0, 'decimal'));
			}
		}
		else
		{
			$('#txtCondicoesComerciais').val('');
			$("#listaCondicoesComerciais").focus();
			$("#btnIncluirFormaPagamento").attr("disabled","disabled");
			$("#listaFormaPagamento").attr("disabled","disabled");
		}
	});
	
//verificação de pesquisa produtos
	$("#btnPesquisaProdutos").click(function()
	{
		if ($('#formPesquisaProdutos').validate().form())
		{
			$("#incluirProduto").focus();
		}
	});
	
	$('#listaPesquisaProdutos').change(function()
	{
		$("#incluirProduto").focus();
	});
	
	$("#btnPesquisaProdutos").click(function()
	{
		$("#listaPesquisaProdutos").ajaxComplete(function(e, xhr, settings) 
		{
			var value = eval('(' + xhr.responseText + ')');
			if(value.produtos)
			{
				$.each(value.produtos, function (kProduto, vProduto)
				{
					if (vProduto.procodigo == produto.procodigo)
					{
						if($('#formTipoPedido').validate().form())
						{
							if(pedido.tipoPedido)
							{
								if(pedido.tipoPedido.codigo == DEVOLUCAO || pedido.tipoPedido.codigo == ABASTECIMENTO || pedido.tipoPedido.codigo == BAIXA || pedido.tipoPedido.codigo == ALMOXERIFADO)
								{
									var lista = new Object();
									if($('#listaEstoqueOrigem').val())
									{
										lista = estoques[$('#listaEstoqueOrigem').val()];
									}
									
									if(lista.etqnome=="VIX")
									{
										produto.tabelaValores.A = Number(vProduto.profinalv);
										produto.tabelaValores.B = Number(vProduto.profinalv);
										produto.tabelaValores.C = Number(vProduto.profinalv);
									}
									else
									{
										produto.tabelaValores.A = Number(vProduto.profinal);
										produto.tabelaValores.B = Number(vProduto.profinal);
										produto.tabelaValores.C = Number(vProduto.profinal);
									}
								}
								else
								{
									produto.tabelaValores.A = Number(vProduto.tabelaValores.A);
									produto.tabelaValores.B = Number(vProduto.tabelaValores.B);
									produto.tabelaValores.C = Number(vProduto.tabelaValores.C);
								}
							}
							$("#txtProdutoTabelaA").val($.mask.string(produto.tabelaValores.A.toFixed(2), 'decimal'));
							$("#txtProdutoTabelaB").val($.mask.string(produto.tabelaValores.B.toFixed(2), 'decimal'));
							$("#txtProdutoTabelaC").val($.mask.string(produto.tabelaValores.C.toFixed(2), 'decimal'));
						}
						$(this).unbind('ajaxComplete');
					}
				});
			}
		});
	});
	
	//verificação de pesquisa transportadora
	$("#btnPesquisaTransportadoras").click(function()
	{
		if ($('#formPesquisaTransportadoras').validate().form())
		{
			$("#txtObservacao").focus();
		}
		
		$("#listaPesquisaTransportadoras").ajaxComplete(function(e, xhr, settings)
		{
			var value = eval('(' + xhr.responseText + ')');
			if(value.transportadoras != undefined)
			{
				pedido.transportadora = transportadora;
				$(this).unbind('ajaxComplete');
			}
		})
		.change(function()
		{
			pedido.transportadora = transportadora;
			$("#txtObservacao").focus();
		});
	});
	
	//verificação de pesquisa de pedidos
	$("#btnPesquisaPedidos").click(function()
	{	
		if (pedido.usuario)
		{			
			if (pedido.usuario.codigo == usuario.codigo)
			{
					travaPedido(false);
			}
		}
		
		$("#listaPesquisaPedidos").ajaxComplete(function(e, xhr, settings)
		{				
			var value = eval('(' + xhr.responseText + ')');
			if(value.pedidos)
			{
				novoForm();
				if (pedido.pvnumero)
				{			
					if (pedido.usuario.codigo)
					{
						if (pedido.usuario.codigo != usuario.codigo)
						{
							alerta("PEDIDO TRAVADO", "USUARIO "+ pedido.usuario.nome +" FAZENDO MANUTENCAO NO PEDIDO.");
							pedido.pvsituacao = false;
						}
					}
					else
					{
						travaPedido(true);
					}
				}
				
				populaCampos(false);
				$(this).unbind('ajaxComplete');
			}
		})
		.change(function()
		{
			populaCampos(false);
							
			var msg = "PEDIDO "+pedido.pvnumero;
			
			$("#retorno").messageBox(msg, true, true);
		});
	});
	
	//calcula percentual de desconto recebendo o valor de desconto
	$('#txtValorDesconto').keyup(function()
	{
		if (subtotal)
		{
			$('#txtPercentualDesconto').val($.mask.string(0, 'percentual'));
			valorDesconto = decimalToNumber($('#txtValorDesconto').val());
			
			if (valorDesconto)
			{
				percentualDesconto = calculaDesconto(subtotal, valorDesconto, true);
				
				var percent = numberToDecimal(percentualDesconto.toFixed(6));
				$('#txtPercentualDesconto').val(percent);
				calculaTotais(subtotal, totalMattel, percentualDesconto);
			}
			else
			{
				calculaTotais(subtotal, totalMattel, 0);
			}
		}
	})
	.change(function()
	{
		valorDesconto = decimalToNumber($('#txtValorDesconto').val());
		if (valorDesconto)
		{	
			percentualDesconto = calculaDesconto(subtotal, valorDesconto, true);
			if(percentualDesconto > 10)
			{
				if (usuario.tipoAcessos[101] == undefined)
				{
					alerta("PERMISSOES DE USUARIO", "PERMISSAO NEGADA PARA ATRIBUIR DESCONTOS MAIOR QUE 10%");
					$('#txtPercentualDesconto').val($.mask.string(0, 'percentual'));
					$('#txtValorDesconto').val($.mask.string(0, 'decimal'));
				}
			}
			else if(percentualDesconto > 5 && percentualDesconto <= 10)
			{
				if (usuario.tipoAcessos[115] != undefined)
				{
					if(percentualDesconto > 9)
					{
						alerta("PERMISSOES DE USUARIO", "PERMISSAO NEGADA PARA ATRIBUIR DESCONTOS MAIOR QUE 9%");
						
						$('#txtPercentualDesconto').val($.mask.string(0, 'percentual'));
						$('#txtValorDesconto').val($.mask.string(0, 'decimal'));
					}
				}
				else
				{
					if (usuario.tipoAcessos[100] == undefined && usuario.tipoAcessos[101] == undefined)
					{
						alerta("PERMISSOES DE USUARIO", "PERMISSAO NEGADA PARA ATRIBUIR DESCONTOS MAIOR QUE 5%");
						
						$('#txtPercentualDesconto').val($.mask.string(0, 'percentual'));
						$('#txtValorDesconto').val($.mask.string(0, 'decimal'));
					}
				}
			}
		}
	});
	
	//calcula valor de desconto recebendo o percentual de desconto
	$('#txtPercentualDesconto').keyup(function()
	{	
		if (subtotal)
		{
			percentualDesconto = decimalToNumber($('#txtPercentualDesconto').val());
			
			if (percentualDesconto)
			{	
				valorDesconto = calculaDesconto(subtotal, percentualDesconto, false);
				$('#txtValorDesconto').val($.mask.string(valorDesconto.toFixed(2), 'decimal'));
				calculaTotais(subtotal, totalMattel, percentualDesconto);
			}
			else
			{
				calculaTotais(subtotal, totalMattel, 0);
			}
		}
	})
	.change(function()
	{
		percentualDesconto = decimalToNumber($('#txtPercentualDesconto').val());
		
		if (percentualDesconto)
		{	
			if(percentualDesconto > 10)
			{
				if (usuario.tipoAcessos[101] == undefined)
				{
					alerta("PERMISSOES DE USUARIO", "PERMISSAO NEGADA PARA ATRIBUIR DESCONTOS MAIOR QUE 10%");
					
					$('#txtPercentualDesconto').val($.mask.string(0, 'percentual'));
					$('#txtValorDesconto').val($.mask.string(0, 'decimal'));
				}
			}
			else if(percentualDesconto > 5 && percentualDesconto <= 10)
			{
				if (usuario.tipoAcessos[100] == undefined && usuario.tipoAcessos[101] == undefined)
				{
					alerta("PERMISSOES DE USUARIO", "PERMISSAO NEGADA PARA ATRIBUIR DESCONTOS MAIOR QUE 5%");
					
					$('#txtPercentualDesconto').val($.mask.string(0, 'percentual'));
					$('#txtValorDesconto').val($.mask.string(0, 'decimal'));
				}
			}
		}
	});
	
	$('#linkHistorico').click(function()
	{
		if(pedido.historico != undefined)
		{
			$('#dialog').attr('title','HISTORICO DE ACOES');
			
			var codHtml = "<table id='listaHistorico' border='0' cellpadding='0' cellspacing='0'>"+
			"<tbody>";
			
			$.each(pedido.historico, function (key, value)
			{
				var dataAcao = new Date().date(value.dataAcao);
				var acao = "";
				
				switch(Number(value.acao))
				{
					case INSERT:
						acao = BOTAO_INSERIR;
						break;
					case SELECT:
						acao = BOTAO_PESQUISAR;
						break;
					case UPDATE:
						acao = BOTAO_ALTERAR;
						break;
					case DELETE:
						acao = BOTAO_EXCLUIR;
						break;
				}
				
				codHtml +="<tr>" +
				"<td>"+value.codigo+"</td>" +
				"<td>"+acao+"</td>" +
				"<td>"+value.usuario.codigo+"</td>" +
				"<td>"+value.usuario.nome+"</td>" +
				"<td>"+dataAcao.format('d/m/Y H:i')+"</td>" +
				"</tr>";
			});
			
			codHtml += 	"</tbody></table>";
				
			$('#dialog').html(codHtml);
				
			$('#dialog').dialog({
				autoOpen: true,
				position: ['center','top'],
				width: 750,
				height: 640,
				modal:true,
				buttons: 
				{
					"Fechar": function()
					{
						$(this).dialog("close");
					}
				},
				close: function(ev, ui)
				{
					$(this).dialog("destroy");
				}
			});
			
			$("#listaHistorico").flexigrid(
			{
				height:'auto',
				width: 700,
				height:500,
				striped:false,
				colModel : [
							{display: 'ID', name : 'codigo', width : 40},
							{display: 'AÇÃO', name : 'acao', width : 50},
							{display: 'COD. USUÁRIO', name : 'codusu', width : 100},
							{display: 'USUÁRIO', name : 'usuario', width : 318},
							{display: 'DATA DA AÇÃO', name : 'dataacao', width : 130}
							]
			});
		}
	});
	
	//verificar destrava antes de descarregar pagina e gera arquivo tmp
	// caso não tenha numero do pedido

	$(window).bind("beforeunload", function(e)
	{
		
		if (pedido.usuario != undefined)
		{			
			if (pedido.usuario.codigo == usuario.codigo)
			{
				travaPedido(false);
			}
		}
		
		var isGerar = false;

		if (!pedido.pvnumero)
		{
			if($('#formTipoPedido').validate().form() && itensPedido.length > 0)
			{
				switch (Number(pedido.tipoPedido.codigo))
				{
					case ABASTECIMENTO:
						if($('#formEstoqueOrigem').validate().form() && $('#formEstoqueDestino').validate().form())
						{
							isGerar = true;
						}
						break;
						
					case DEVOLUCAO:
						if($('#formResultadoFornecedores').validate().form())
						{
							isGerar = true;
						}
						break;
						
					default:
						if($('#formResultadoClientes').validate().form())
						{
							isGerar = true;
						}
						break;
				}
			}
		}
		
		if (isGerar)
		{
			pedido.pvemissao = new Date();
			pedido.pvvaldesc = valorDesconto;
			pedido.pvperdesc = percentualDesconto;
			pedido.pvvalor = subtotal;
			pedido.pvobserva = $('#txtExcecoes').val();
			pedido.pvencer = 1;
			pedido.pvnewobs = $('#txtObservacao').val();
			pedido.pvlocal = $('#txtLocalEntrega').val();
			pedido.pvtipofrete = Number($("input[name='opcoesTipoFrete']:checked").val());
			pedido.tipolocal = 1;
			pedido.pvlibdep = '';
			pedido.pvlibmat = '';
			pedido.pvlibfil = '';
			pedido.pvlibvix = '';
			
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
			
			gerarPedidoTmp();
		}
	});

});
