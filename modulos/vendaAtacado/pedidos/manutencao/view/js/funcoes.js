/**
 * @author Wellington
 *
 * funções publicas para a pagina da view.
 *
 * Criação    23/12/2009
 *
 */
	var itensPedido = new Array();
	var itensPedidoEmpenho = new Array();
	var itemPedido = new Object();
	var itemPedidoEmpenho = new Object();
	var tiposPedido = new Array();
	var estoqueAtivo = new Object();
	var allEstoques = new Array();

	var valorUnitItem = 0;
	var valorTotalItem = 0;
	var valorTotalItemEmpenho = 0;
	var qtdTotalItem = 0;
	var qtdTotalItemEmpenho = 0;
	var tabela = 'C';
	var ordemItem = 0;
	var percentualDesconto = 0;
	var valorDesconto = 0;
	var subtotal = 0;
	var totalPagar = 0;
	var totalPago = 0;

function getEstoques(item, itemEmpenho, tipoPedido)
{
	
	if (!item)
	{
		item = new Object();
		item = clone(itemEmpenho);
		itemEmpenho = new Object();
	}
	else if (!itemEmpenho)
	{
		itemEmpenho = new Object();
	}
	
	if (!itensPedido.length)
	{
		estoqueAtivo = new Object();
	}
	
	tabela = item.pvitippr;

	var titulo = "PROCESSANDO, PRODUTO "+item.produto.procod+"...";
	var mensagem = "AGUARDE CARREGANDO ESTOQUES.";
	$("#retorno").messageBoxModal(titulo, mensagem);
	
	produto = new Object();
	produto = clone(item.produto);
	
	var codHtml = "<p>Codigo: "+item.produto.procod+"<br>" +
	"Produto: "+item.produto.prnome+"<br>" +
	"Tabela: <input type='radio' name='opcaoTabela' id='opcaoTabela' value='A'> A" +
	"<input type='radio' name='opcaoTabela' id='opcaoTabela' value='B'> B" +
	"<input type='radio' name='opcaoTabela' id='opcaoTabela' value='C'> C<br>" +
	"Valor Unit: <input type='text' name='valorUnitItem' id='valorUnitItem' size='10' value='"+$.mask.string(Number(item.pvipreco).toFixed(2), 'decimal')+"'><br>" +
	"Qtda Total: <span id='qtdTotalItem'>"+$.mask.string(0, 'decimal')+"</span><br>" +
	"Valor Total: <span id='valorTotalItem'>"+$.mask.string(0, 'decimal')+"</span></p>";
	
	//declara variaveis recuperando valores
	var pesquisa = new Object();
	pesquisa.tipoPedido = tipoPedido.sigla;
	pesquisa.codigoProduto = item.produto.procodigo;

	//Envia os dados via metodo post
	$.post('modulos/vendaAtacado/pedidos/manutencao/controller/getEstoquesItem.php',
	{
		//variaveis a ser enviadas metodo POST
		tipoPedido:pesquisa.tipoPedido,
		codigoProduto:pesquisa.codigoProduto
	},
	function(data)
	{
		if (Boolean(Number(data.retorno)))
		{
			allEstoques = data.estoques;
					
				codHtml += "<form id='formEstoquesItem' name='formEstoquesItem' method='post' action='#'>" +
						"<table id='listaEstoques'>" +
							"<thead>" +
								"<tr>" +
									"<th>Estoque</th>" +
									"<th>Saldo Inicial</th>" +
									"<th>Qtda</th>" +
									"<th>Saldo Final</th>" +
								"</tr>" +
							"</thead>" +
							"<tbody>";
				
			$.each(allEstoques, function (key, value)
			{
				var disabled = "";
				if (!Number(value.estqtd))
				{
					if (Number(value.estoque.etqcodigo) != EMPENHO)
					{
						if (Number(value.estoque.etqcodigo) != PENDENTES)
						{
							disabled = " disabled='disabled'";
						}
					}
				}
				
				if (tipoPedido.codigo == ABASTECIMENTO)
				{	
					if (pedido.estoqueOrigem.etqcodigo != value.estoque.etqcodigo)
					{
						disabled = " disabled='disabled'";
					}
				}
				else
				{
					if (estoqueAtivo.etqcodigo != undefined)
					{
						if (value.estoque.etqcodigo != estoqueAtivo.etqcodigo)
						{
							if (Number(value.estoque.etqcodigo) != EMPENHO)
							{
								if (Number(value.estoque.etqcodigo) != PENDENTES)
								{
									disabled = " disabled='disabled'";
								}
							}
						}
					}
				}
				
				if (tipoPedido.codigo == RESERVA)
				{	
					if (Number(value.estoque.etqcodigo) == EMPENHO)
					{
						disabled = " disabled='disabled'";
					}
				}
				
				codHtml += "<tr>" +
				"<td>"+ value.estoque.etqnome +"<></td>" +
				"<td><input name='saldoInicial' id='si"+ value.estoque.etqcodigo +"' type='text' size='8' value='"+$.mask.string(value.estqtd, 'integer')+"' readonly='readonly'></td>" +
				"<td><input name='codEstoque' id='cod"+ value.estoque.etqcodigo +"' type='hidden' value='0'><input name='qtdItem' id='"+ value.estoque.etqcodigo +"' type='text' size='8' value='0'"+ disabled +"></td>" +
				"<td><input name='saldoFinal' id='sf"+ value.estoque.etqcodigo +"' type='text' size='8' value='"+$.mask.string(value.estqtd, 'integer')+"' readonly='readonly'></td>" +
				"</tr>";
			});
			
			codHtml += 	"</tbody>" +
					"</table><form>";
						
			$('#estoquesItem').html(codHtml);
			
			$('#estoquesItem').dialog("open");
			
			$("#listaEstoques").ingrid(
			{
				rowSelection:false,
				initialLoad:false,
				paging: false,
				sorting: false,
				colWidths:[400,100,100,100],
				height: 350
			});
			
			$.each(allEstoques, function (key, value)
			{
				var id = value.estoque.etqcodigo;
				
				$("input[id='si"+id+"']").integer();
				$("input[id='"+id+"']").integerPositive();
				$("input[id='sf"+id+"']").integer();
				
				var isMax = false;
				if (item.estoques != undefined)
				{
					$.each(item.estoques, function (key, value)
					{
						if (value.estoqueAtual.estoque.etqcodigo == id)
						{
							var iValor = Number(toInt($("input[id='si"+id+"']").val()));
							var sValor = iValor - Number(value.pvieqtd);
							
							if (pedido.pvnumero != undefined)
							{
								sValor = (iValor + Number(value.pvieqtd)) - Number(value.pvieqtd);
								
								if (Number(value.estoqueAtual.estoque.etqcodigo) != EMPENHO)
								{
									if (Number(value.estoqueAtual.estoque.etqcodigo) != PENDENTES)
									{
										$("input[id='"+id+"']")
										.valorMaximo(iValor, value.pvieqtd)
										.valorMinimo(item.qtdReserva)
										.change(function(){
											var iValor = Number(toInt($(this).val()));
											var siValor = Number(toInt($("input[id='si"+id+"']").val()));
											var sfValor = siValor + (Number(value.pvieqtd) - iValor);									
											$("input[id='sf"+id+"']").val($.mask.string(sfValor, 'integer'));
										});
										
										isMax = true;
									}
								}
							}

							if (Number(value.pvieqtd))
							{
								$("input[id='"+id+"']").attr("disabled","");
							}
							
							$("input[id='cod"+id+"']").val(value.pviecodigo);
							$("input[id='"+id+"']").val($.mask.string(value.pvieqtd, 'integer'));	
							$("input[id='sf"+id+"']").val($.mask.string(sValor, 'integer'));
						}
					});
				}

				if (!isMax)
				{
					if (Number(value.estoque.etqcodigo) != EMPENHO)
					{
						if (Number(value.estoque.etqcodigo) != PENDENTES)
						{
							$("input[id='"+id+"']").valorMaximo(value.estqtd, 0);
						}
					}
				}
				
				if (itemEmpenho.estoques != undefined)
				{
					$.each(itemEmpenho.estoques, function (key, value)
					{
						if (value.estoqueAtual.estoque.etqcodigo == id)
						{
							$("input[id='cod"+id+"']").val(value.pviecodigo);
							$("input[id='"+id+"']").val($.mask.string(value.pvieqtd, 'integer'));
							var iValor = Number(toInt($("input[id='si"+id+"']").val()));
							var sValor = iValor - Number(value.pvieqtd);	
							$("input[id='sf"+id+"']").val($.mask.string(sValor, 'integer'));
						}
					});
				}
			});
			
			qtdTotalItem = 0;
			qtdTotalItemEmpenho = 0;
			valorTotalItem = 0;
			valorTotalItemEmpenho = 0;
			
			if (typeof item.estoques == 'object')
			{
				if (item.estoques.length > 0)
				{	
					$("input[name='opcaoTabela']").each(function()
					{
						if ($(this).val() == item.pvitippr) 
						{
							$(this).attr("checked","checked");
						}
					});
					
					valorTotalItem += (item.pvisaldo * item.pvipreco);
					qtdTotalItem += Number(item.pvisaldo);
				}
			}
			
			if (typeof itemEmpenho.estoques == 'object')
			{
				if (itemEmpenho.estoques.length > 0)
				{	
					if (item.estoques.length <= 0)
					{
						$("input[name='opcaoTabela']").each(function()
						{
							if ($(this).val() == itemEmpenho.pvitippr) 
							{
								$(this).attr("checked","checked");
							}
						});
					}
					
					valorTotalItemEmpenho += (itemEmpenho.pvisaldo * itemEmpenho.pvipreco);
					qtdTotalItemEmpenho += Number(itemEmpenho.pvisaldo);
				}
			}
					
			$("#qtdTotalItem").text($.mask.string((qtdTotalItem+qtdTotalItemEmpenho), 'integer'));
			$("#valorTotalItem").text($.mask.string((valorTotalItem+valorTotalItemEmpenho).toFixed(2), 'decimal'));
			
			$("input[name='opcaoTabela']").val([item.pvitippr]);
						
			$("#valorUnitItem").change(function()
			{
				valorUnitItem = decimalToNumber($("#valorUnitItem").val());
				
				if (valorUnitItem < item.produto.tabelaValores[tabela])
				{
					if (usuario.tipoAcessos)
					{
						if (!usuario.tipoAcessos[102])
						{
							alerta("PERMISSOES DE USUARIO", "PERMISSAO NEGADA PARA ATRIBUIR VALOR ABAIXO DA TABELA.");
							$("#valorUnitItem").val($.mask.string(item.produto.tabelaValores[tabela].toFixed(2), 'decimal'));
						}
					}
					else
					{
						alerta("PERMISSOES DE USUARIO", "PERMISSAO NEGADA PARA ATRIBUIR VALOR ABAIXO DA TABELA.");
						$("#valorUnitItem").val($.mask.string(item.produto.tabelaValores[tabela].toFixed(2), 'decimal'));
					}
				}
				else if (valorUnitItem > item.produto.tabelaValores[tabela])
				{
					if (usuario.tipoAcessos)
					{
						if (!usuario.tipoAcessos[116])
						{
							alerta("PERMISSOES DE USUARIO", "PERMISSAO NEGADA PARA ATRIBUIR VALOR MAIOR QUE A TABELA.");
							$("#valorUnitItem").val($.mask.string(item.produto.tabelaValores[tabela].toFixed(2), 'decimal'));
						}
					}
					else
					{
						alerta("PERMISSOES DE USUARIO", "PERMISSAO NEGADA PARA ATRIBUIR VALOR MAIOR QUE A TABELA.");
						$("#valorUnitItem").val($.mask.string(item.produto.tabelaValores[tabela].toFixed(2), 'decimal'));
					}
				}
								
				valorTotalItem = (qtdTotalItem * valorUnitItem);
				valorTotalItemEmpenho = (qtdTotalItemEmpenho * valorUnitItem);
				
				$("#qtdTotalItem").text($.mask.string((qtdTotalItem+qtdTotalItemEmpenho), 'integer'));
				$("#valorTotalItem").text($.mask.string((valorTotalItem+valorTotalItemEmpenho).toFixed(2), 'decimal'));
				item.pvipreco = valorUnitItem;
				itemEmpenho.pvipreco = valorUnitItem;
			});
				
			$("input[name='qtdItem']").keyup(function()
			{
				var id = $(this).attr('id');
				var qtdValor = Number(toInt($(this).val()));
				var iValor = Number(toInt($("input[id='si"+id+"']").val()));
				var sValor = "";
				valorUnitItem = decimalToNumber($("#valorUnitItem").val());
				var qtdApropriada = 0;
				
				if (!qtdValor)
				{
					$(this).val('0');
					if (Number(id) != EMPENHO)
					{
						if (Number(id) != PENDENTES)
						{
							if (!itensPedido.length)
							{
								estoqueAtivo = new Object();
							}
						}
					}
				}
				else
				{
					if (Number(id) != EMPENHO)
					{
						if (Number(id) != PENDENTES)
						{
							estoqueAtivo.etqcodigo = id;
						}
					}
				}
				
				if (item.estoques != undefined && pedido.pvnumero != undefined)
				{
					$.each(item.estoques, function (key, value)
					{
						if (value.estoqueAtual.estoque.etqcodigo == id)
						{
							qtdApropriada = Number(value.pvieqtd);
						}
					});
				}
				
				sValor = (iValor + qtdApropriada) - qtdValor;

				$("input[id='sf"+id+"']").val($.mask.string(sValor, 'integer'));
				
				calculaValorTotalItem();
			})
			.change(function()
			{	
				calculaValorTotalItem();
			});
			
			$("input[name='opcaoTabela']").change(function()
			{	
				tabela = $("input[name='opcaoTabela']:checked").val();
				$("#valorUnitItem").val($.mask.string(item.produto.tabelaValores[tabela].toFixed(2), 'decimal'));
				valorUnitItem = Number(item.produto.tabelaValores[tabela]);
				
				item.pvipreco = valorUnitItem;
				itemEmpenho.pvipreco = valorUnitItem;
				
				valorTotalItem = (qtdTotalItem * valorUnitItem);
				valorTotalItemEmpenho = (qtdTotalItemEmpenho * valorUnitItem);
				$("#valorTotalItem").text($.mask.string((valorTotalItem+valorTotalItemEmpenho).toFixed(2), 'decimal'));
			});
				
			valorUnitItem = decimalToNumber($("#valorUnitItem").val());
			$("#valorUnitItem").moeda();
			
			$.unblockUI();
	}
    else
    {
    	$("#retorno").messageBox(data.mensagem,data.retorno,true);
    }
	
	itemPedido = clone(item);
		
	},"json");
	
		$('#estoquesItem').attr('title','Incluir no Pedido');
		
		$('#estoquesItem').dialog({
			autoOpen: false,
			position: ['center','top'],
			width: 750,
			height: 640,
			modal:true,
			buttons: 
			{
				"Ok": function() 
				{
					
					itemPedido.pvipreco = valorUnitItem;
					itemPedidoEmpenho.pvipreco = valorUnitItem;
					listaItensPedido(itemPedido, itemPedidoEmpenho, false);
					limpaPesquisaProdutos();	
					if(Number(tipoPedido.codigo) != ABASTECIMENTO)
					{
						if(Number(tipoPedido.codigo) != DEVOLUCAO)
						{
							calculaTotais(subtotal, totalMattel, percentualDesconto);
							calculaLimite(cliente);
						}
					}
					$("#txtPesquisaProdutos").focus();
					
					$(this).dialog("close");
				}, 
				"Cancel": function() 
				{
					$("#txtPesquisaProdutos").focus();
					$(this).dialog("close");
				}
			},
			close: function(ev, ui)
			{
				$(this).dialog("destroy");
			}
		});
}

function calculaValorTotalItem(){
	qtdTotalItem = 0;
	qtdTotalItemEmpenho = 0;
	valorTotalItem = 0;
	valorTotalItemEmpenho = 0;
	
	$("input[name='qtdItem']").each(function(key, value){
		
		var estoque = $(this).attr('id');
		
		if ((estoque == EMPENHO || estoque == PENDENTES) && pedido.tipoPedido.codigo != RESERVA)
		{
			qtdTotalItemEmpenho = Number(qtdTotalItemEmpenho) + Number(toInt(value.value));
		}
		else
		{
			qtdTotalItem = Number(qtdTotalItem) + Number(toInt(value.value));
		}
		
		if (estoqueAtivo.etqcodigo != undefined)
		{
			if (estoque != estoqueAtivo.etqcodigo)
			{
				if (Number(estoque) != EMPENHO)
				{
					if (Number(estoque) != PENDENTES)
					{
						$(this).attr('disabled','disabled');
					}
				}
				else
				{
					if (pedido.tipoPedido.codigo == RESERVA)
					{	
						disabled = " disabled='disabled'";
					}
				}
			}
		}
		else
		{
			var iValor = Number(toInt($("input[id='si"+estoque+"']").val()));
			if (iValor)
			{
				if (pedido.tipoPedido.codigo == RESERVA)
				{
					if (Number(estoque) == EMPENHO)
					{
						disabled = " disabled='disabled'";
					}
					else
					{
						$(this).attr('disabled','');
					}
				}
				else
				{
					$(this).attr('disabled','');
				}
			}
		}
	});
	
	valorTotalItem = (qtdTotalItem * valorUnitItem);
	valorTotalItemEmpenho = (qtdTotalItemEmpenho * valorUnitItem);
	
	$("#qtdTotalItem").text($.mask.string((qtdTotalItem+qtdTotalItemEmpenho), 'integer'));
	$("#valorTotalItem").text($.mask.string((valorTotalItem+valorTotalItemEmpenho).toFixed(2), 'decimal'));
}

function listaItensPedido(itemPedido, itemPedidoEmpenho, isDelete)
{
	var codHtmlS = "";
	
	var estoquesItem = new Array();
	var estoquesItemEmpenho = new Array();
	var mensagem = "";
	
	$.each(allEstoques, function (key, value)
	{
		var itemEstoque = new Object();
		itemEstoque.pviecodigo = $("input[id='cod"+value.estoque.etqcodigo+"']").val();
		itemEstoque.estoqueAtual = new Object();
		itemEstoque.estoqueAtual = clone(value);
		itemEstoque.pvieqtd = toInt($("input[id='"+value.estoque.etqcodigo+"']").val());
		itemEstoque.pviedatacadastro = new Date();
		itemEstoque.pviesituacao = true;
		
		if(itemEstoque.pvieqtd > 0)
		{
			if ((value.estoque.etqcodigo == EMPENHO || value.estoque.etqcodigo == PENDENTES) && pedido.tipoPedido.codigo != RESERVA)
			{
				estoquesItemEmpenho.push(itemEstoque);
			}
			else
			{
				estoquesItem.push(itemEstoque);
				if (!estoqueAtivo && (value.estoque.etqcodigo != EMPENHO || value.estoque.etqcodigo != PENDENTES))
				{
					estoqueAtivo = clone(value.estoque);
				}
			}
		}
	});

	if (estoquesItem.length > 0)
	{
		if (!itemPedido)
		{
			itemPedido = new Object();
			
			itemPedido.produto = new Object();
			itemPedido.produto = clone(itemPedidoEmpenho.produto);
			
			itemPedido.pvipreco = Number(itemPedidoEmpenho.pvipreco);
			itemPedido.pvicomis = itemPedidoEmpenho.pvicomis;
			itemPedido.pvidatacadastro = new Date();
			itemPedido.pvisituacao = itemPedidoEmpenho.pvisituacao;
		}
		
		if (!itemPedido.pvitem)
		{
			itemPedido.pvitem = (itensPedido.length + 1);
		}
		
		itemPedido.pvisaldo = qtdTotalItem;
		itemPedido.pvitippr = tabela;
		itemPedido.estoques = estoquesItem;
	}
	
	if (estoquesItemEmpenho.length > 0)
	{
		if (!itemPedidoEmpenho)
		{
			itemPedidoEmpenho = new Object();
			
			itemPedidoEmpenho.produto = new Object();
			itemPedidoEmpenho.produto = clone(itemPedido.produto);
			
			itemPedidoEmpenho.pvipreco = Number(itemPedido.pvipreco);
			itemPedidoEmpenho.pvicomis = itemPedido.pvicomis;
			itemPedidoEmpenho.pvidatacadastro = new Date();
			itemPedidoEmpenho.pvisituacao = itemPedido.pvisituacao;
		}
		
		if (!itemPedidoEmpenho.pvitem)
		{
			itemPedidoEmpenho.pvitem = (itensPedidoEmpenho.length + 1);
		}
		
		itemPedidoEmpenho.pvisaldo = qtdTotalItemEmpenho;
		itemPedidoEmpenho.pvitippr = tabela;
		itemPedidoEmpenho.estoques = estoquesItemEmpenho;
	}
	
	var isNovo = isDelete ? false : true;
	
	if (itemPedido.produto != undefined)
	{
		if (itensPedido.length > 0)
		{
			$.each(itensPedido, function (key, value)
			{
				if (value != undefined)
				{
					if (value.produto.procodigo == itemPedido.produto.procodigo)
					{
						if (isDelete)
						{
							itensPedido.remove(key);
							mensagem = "Produto "+itemPedido.produto.prnome+" removido da lista de pedido.";
							
							if (itensPedidoEmpenho.length > 0)
							{
								$.each(itensPedidoEmpenho, function (key, value)
								{
									if (value.produto.procodigo == itemPedido.produto.procodigo)
									{
										itensPedidoEmpenho.remove(key);
										mensagem += "<br>Produto continha itens Empenho.";
									}
								});
							}
						}
						else
						{
							itensPedido.set(key, itemPedido);
							mensagem = "Produto "+itemPedido.produto.prnome+" alterado na lista do pedido.";			
							
							if (itensPedidoEmpenho.length > 0)
							{
								$.each(itensPedidoEmpenho, function (key, value)
								{
									if (value.produto.procodigo == itemPedido.produto.procodigo)
									{
										mensagem += "<br>Item no empenho ";
										if (estoquesItemEmpenho.length > 0)
										{
											itensPedidoEmpenho.set(key, itemPedidoEmpenho);
											mensagem += "alterado.";
										}
										else
										{
											itensPedidoEmpenho.remove(key);
											mensagem += "removido.";
										}
									}
									else
									{
										if (estoquesItemEmpenho.length > 0)
										{
											itensPedidoEmpenho.push(itemPedidoEmpenho);
											mensagem += "<br>Adcionou item ao empenho.";
										}
									}
								});
							}
							else
							{
								if (estoquesItemEmpenho.length > 0)
								{
									itensPedidoEmpenho.push(itemPedidoEmpenho);
									mensagem += "<br>Adcionou item ao empenho.";
								}
							}
						}
						
						isNovo = false;					
					}
				}
			});
		}
	}
	
	if (itemPedidoEmpenho.produto != undefined)
	{
		if (itensPedidoEmpenho.length > 0)
		{
			$.each(itensPedidoEmpenho, function (keyE, valueE)
			{
				if (valueE.produto.procodigo == itemPedidoEmpenho.produto.procodigo)
				{
					if (isDelete)
					{
						itensPedidoEmpenho.remove(keyE);
						mensagem = "Produto "+itemPedidoEmpenho.produto.prnome+" removido da lista de pedido.";
						mensagem += "<br>Produto continha itens Empenho.";
					}
					else
					{
						itensPedidoEmpenho.set(keyE, itemPedidoEmpenho);
						mensagem = "Produto "+itemPedidoEmpenho.produto.prnome+" alterado na lista do pedido.";
						mensagem += "<br>Adcionou item ao empenho.";
						
						if (itensPedido.length > 0)
						{
							$.each(itensPedido, function (key, value)
							{
								if (value.produto.procodigo == itemPedidoEmpenho.produto.procodigo)
								{
									if (estoquesItem.length > 0)
									{
										itensPedido.set(key, itemPedido);
									}
									else
									{
										itensPedido.remove(key);
									}
								}
								else
								{
									itensPedido.push(itemPedido);
								}
							});
						}
						else
						{
							if (estoquesItem.length > 0)
							{
								itensPedido.push(itemPedido);
							}
						}
	
					}
					
					isNovo = false;					
				}
			});
		}
	}
	
	if (isNovo)
	{
		if (estoquesItem.length > 0)
		{
			itensPedido.push(itemPedido);
			mensagem = "Produto "+itemPedido.produto.prnome+" adicionado na lista do pedido!";
		}
		
		if (estoquesItemEmpenho.length > 0)
		{
			itensPedidoEmpenho.push(itemPedidoEmpenho);
			mensagem = "Produto "+itemPedidoEmpenho.produto.prnome+" adicionado na lista do pedido! " +
					"<br>Produto contem estoque empenho.";
		}
	}	
	
	
	if(itensPedido.length > 0 || itensPedidoEmpenho.length > 0)
	{
		codHtmlS += "<table id=\"listaItensPedidos\">" +
					"<thead>" +
						"<tr>" +
							"<th>Codigo</th>" +
							"<th>Produto</th>" +
							"<th>Qtde Emb.</th>" +
							"<th>Tabela</th>" +
							"<th>Qtde</th>" +
							"<th>Valor Unit.</th>" +
							"<th>Valor Total</th>" +
							"<th>Acao</th>" +
						"</tr>" +
					"</thead>" +
					"<tbody>";
		
		subtotal = 0;
		totalMattel = 0;
		
		var item = new Object();
		if(itensPedido.length > 0)
		{	
			$.each(itensPedido, function (key, value)
			{
				item.codigo = value.produto.procod;
				item.produto = value.produto.prnome;
				item.qtdeEmb = value.produto.proemb;
				item.tabela = value.pvitippr;
				item.qtde = value.pvisaldo;
				item.valorUnit = Number(value.pvipreco);
				
				var hE = "";
				if (itensPedidoEmpenho.length > 0)
				{
					$.each(itensPedidoEmpenho, function (keyE, valueE)
					{		
						if (valueE.produto.procod == value.produto.procod)
						{
							item.qtde += valueE.pvisaldo;
							hE = "<input type='hidden' id='itemPedidoEmpenho"+valueE.produto.procodigo+"' value='"+JSON.stringify(valueE)+"'/>";
						}
					});
				}
				
				item.valorTotal = (item.qtde * item.valorUnit);
				
				var deleteStats = "<input type='button' name='btnExcluirEstoquesItem' id='"+value.produto.procodigo+"' style='background: url(imagens/delete.gif); background-repeat: no-repeat; background-position:center center; height: 20px; width:65px; border:0px;'/>";
				if(value.qtdReserva)
				{
					deleteStats = "";
				}
				
				codHtmlS += "<tr>" +
								"<td>"+ item.codigo +"</td>" +
								"<td>"+ item.produto +"</td>" +
								"<td>"+ item.qtdeEmb +"</td>" +
								"<td>"+ item.tabela +"</td>" +
								"<td>"+ $.mask.string(item.qtde, 'integer') +"</td>" +
								"<td>"+ $.mask.string(item.valorUnit.toFixed(2), 'decimal') +"</td>" +
								"<td>"+ $.mask.string(item.valorTotal.toFixed(2), 'decimal') +"</td>" +
								"<td><input type='hidden' id='itemPedido"+value.produto.procodigo+"' value='"+JSON.stringify(value)+"'/>"+hE+"<input type='button' name='btnAlterarEstoquesItem' id='"+value.produto.procodigo+"' style='background: url(imagens/edit.gif); background-repeat: no-repeat; background-position:center center; height: 20px; width: 55px; border:0px;'/>"+
								deleteStats + " </td>" +
							"</tr>";
			});
		}
		
		
		if(itensPedidoEmpenho.length > 0)
		{
			$.each(itensPedidoEmpenho, function (keyE, valueE)
			{	
				var $isDuplicado = false;
				if (itensPedido.length > 0)
				{
					$.each(itensPedido, function (key, value)
					{		
						if (valueE.produto.procod == value.produto.procod)
						{
							$isDuplicado = true;
						}
					});
				}
				
				if (!$isDuplicado)
				{
					codHtmlS += "<tr>" +
									"<td>"+ valueE.produto.procod +"</td>" +
									"<td>"+ valueE.produto.prnome +"</td>" +
									"<td>"+ valueE.produto.proemb +"</td>" +
									"<td>"+ valueE.pvitippr +"</td>" +
									"<td>"+ $.mask.string(valueE.pvisaldo, 'integer') +"</td>" +
									"<td>"+ $.mask.string(Number(valueE.pvipreco).toFixed(2), 'decimal') +"</td>" +
									"<td>"+ $.mask.string((valueE.pvipreco * valueE.pvisaldo).toFixed(2), 'decimal') +"</td>" +
									"<td><input type='hidden' id='itemPedidoEmpenho"+valueE.produto.procodigo+"' value='"+JSON.stringify(valueE)+"'/><input type='button' name='btnAlterarEstoquesItem' id='"+valueE.produto.procodigo+"' style='background: url(imagens/edit.gif); background-repeat: no-repeat; background-position:center center; height: 20px; width: 55px; border:0px;'/>"+
									"<input type='button' name='btnExcluirEstoquesItem' id='"+valueE.produto.procodigo+"' style='background: url(imagens/delete.gif); background-repeat: no-repeat; background-position:center center; height: 20px; width:65px; border:0px;'/> </td>" +
								"</tr>";
				}
			});
		}

		
		codHtmlS += "</tbody>" +
					"</table>";
		
		$.each(itensPedido, function (key, value)
		{
			if(estoqueAtivo.etqcodigo == undefined && value.estoques[0].estoqueAtual.estoque.etqcodigo != PENDENTES)
			{
				estoqueAtivo = value.estoques[0].estoqueAtual.estoque;
			}
			
			subtotal += value.pvipreco * value.pvisaldo;
			if (value.produto.fornecedor != undefined)
			{
				if (value.produto.fornecedor.forcodigo == MATTEL)
				{
					totalMattel += value.pvipreco * value.pvisaldo;
				}
			}
		});
		
		$.each(itensPedidoEmpenho, function (key, value)
		{
			/*if(estoqueAtivo.etqcodigo == undefined){
				estoqueAtivo = value.estoques[0].estoqueAtual.estoque;
			}*/
			subtotal += value.pvipreco * value.pvisaldo;
			if (value.produto.fornecedor.forcodigo == MATTEL)
			{
				totalMattel += value.pvipreco * value.pvisaldo;
			}
		});
		
		
		if ($('#formCondicoesComerciais').validate().form())
		{
			$("#btnIncluirFormaPagamento").attr("disabled","");
			$("#listaFormaPagamento").attr("disabled","");
		}
		else
		{
			$("#btnIncluirFormaPagamento").attr("disabled","disabled");
			$("#listaFormaPagamento").attr("disabled","disabled");
		}
		
		$('#itensPedido').html(codHtmlS);
		
		$("#listaItensPedidos").ingrid({
			rowSelection:false,
			initialLoad:false,
			paging: false,
			sorting: false,
			colWidths:[60,300,80,60,60,80,80,120],
			height: 350
		});
		
		if (usuario.tipoAcessos)
		{
			if (usuario.tipoAcessos[113] == undefined && usuario.tipoAcessos[114] == undefined && usuario.tipoAcessos[115] == undefined)
			{
				if (usuario.tipoAcessos[113] == undefined && usuario.tipoAcessos[114] == undefined && usuario.tipoAcessos[115] == undefined)
				{
					$('#txtValorDesconto').attr('disabled','');
					$('#txtPercentualDesconto').attr('disabled','');
				}
				else
				{
					if (condicaoComercial.codigo != undefined && (usuario.tipoAcessos[114] != undefined || usuario.tipoAcessos[115] != undefined))
					{
						if(condicaoComercial.codigo == 1)
						{
							$('#txtValorDesconto').attr('disabled','');
							$('#txtPercentualDesconto').attr('disabled','');
						}
					}
				}
			}
		}
		
		
		$("input[name='btnExcluirEstoquesItem']").click(function()
		{
			var id = $(this).attr('id');
			var jsonText = $("input[id='itemPedido"+id+"']").val();
			itemPedido = eval('(' + jsonText + ')');
			jsonText = $("input[id='itemPedidoEmpenho"+id+"']").val();
			itemPedidoEmpenho = eval('(' + jsonText + ')');
			if (itemPedidoEmpenho == undefined)
			{
				itemPedidoEmpenho = new Object();
			}
			listaItensPedido(itemPedido, itemPedidoEmpenho, true);
		});
		
		$("input[name='btnAlterarEstoquesItem']").click(function()
		{	
			if ($('#formTipoPedido').validate().form())
			{
				var id = $(this).attr('id');
				
				var jsonText = $("input[id='itemPedido"+id+"']").val();
				itemPedido = eval('(' + jsonText + ')');
				
				jsonText = $("input[id='itemPedidoEmpenho"+id+"']").val();
				itemPedidoEmpenho = eval('(' + jsonText + ')');
				
				if (itemPedidoEmpenho == undefined)
				{
					itemPedidoEmpenho = new Object();
				}
				
				getEstoques(itemPedido, itemPedidoEmpenho, pedido.tipoPedido);
			}
		});
	}
	else
	{
		var codHtmlS = '<table border="0" cellpadding="0" cellspacing="0" width="100%">'+
						'<tr bgcolor="#FFFFFF">'+
							'<td height="25" width="100%" align="center">'+
							'Nenhum produto foi incluido ao pedido!'+
							'</td>'+
						'</tr>'+
					'</table>';
		
		$('#itensPedido').html(codHtmlS);
		
		$('#txtValorDesconto').attr('disabled','disabled');
		$('#txtPercentualDesconto').attr('disabled','disabled');
	}
	
	
	if (estoquesItem.length > 0)
	{
		mensagem += "<br><br>"+itemPedido.produto.procod+" <i>"+itemPedido.produto.prnome+"</i>";
	}	
	else if (estoquesItemEmpenho.length > 0)
	{
		mensagem += "<br><br>"+itemPedidoEmpenho.produto.procod+" <i>"+itemPedidoEmpenho.produto.prnome+"</i>";
	}	
	
	if (mensagem)
	{
		$("#retorno").messageBox(mensagem, true, true);
	}
	
	calculaTotais(subtotal, totalMattel, percentualDesconto);
}

function calculaTotais(subtotal, totalMattel, percentualDesconto)
{
	$("#lblSubtotal").text($.mask.string(Number(subtotal).toFixed(2), 'decimal'));
	$("#lblTotalMattel").text($.mask.string(Number(totalMattel).toFixed(2), 'decimal'));	
	
	var desconto = calculaDesconto(subtotal, percentualDesconto, false);
	$("#lblValorDesconto").text($.mask.string(desconto.toFixed(2), 'decimal'));
	$("#txtValorDesconto").val($.mask.string(desconto.toFixed(2), 'decimal'));
	valorDesconto = desconto;
	
	var total = subtotal-desconto;
	$("#lblTotal").text($.mask.string(total.toFixed(2), 'decimal'));
	
	$("#lblTotalPagar").text($.mask.string(total.toFixed(2), 'decimal'));
}

function calculaDesconto(subtotal, valor, isPercentual)
{
	var retorno = 0;
	if(isPercentual)
	{
		retorno = (valor*100)/subtotal;
	}
	else
	{
		retorno = (subtotal*valor)/100;
	}
	
	return retorno;
}

function calculaLimite(cliente)
{
	var ano = 0;
	var mes = 0;
	var dia = 0;
	var limite = (cliente.clilimite - cliente.vendasEmAberto);
	
	$("#lblLimiteDisponivel").text($.mask.string(limite.toFixed(2), 'decimal'));
	
	$("#lblLimiteTotal").text($.mask.string(Number(cliente.clilimite).toFixed(2), 'decimal'));
	
	if (cliente.cliult != null)
	{
		ano = cliente.cliult.substr(0,4);
		mes = cliente.cliult.substr(5,2);
		dia = cliente.cliult.substr(8,2);
		
		$("#lblDataUltimaCompra").text($.mask.string(dia+mes+ano, 'date'));
	}
	
	var serasa = "Não";
	if (cliente.cliserasa)
	{
		ano = cliente.cliserasa.substr(0,4);
		mes = cliente.cliserasa.substr(5,2);
		dia = cliente.cliserasa.substr(8,2);
		
		serasa = "Sim ("+ $.mask.string(dia+mes+ano, 'date') +")";
	}
	
	$("#lblSerasa").text();
}

function calculaTotalPago(totalPago, valor)
{
	if (totalPago)
	{
		totalPago = totalPago + valor;
	}
	else
	{
		totalPago = valor;
	}

	return totalPago;
}

function calculaValorParcela(valor, condicaoComercial)
{
	var tmpValor = 0;
	if (pedido.condicaoComercial.parcela > 1)
	{
		tmpValor = (valor/pedido.condicaoComercial.parcela);
	}

	return tmpValor;
}

function crudExe(acao)
{
	var retorno = false;
	
	//executa insert, select, updete, delete
	if(Boolean(acao))
	{	
		//Envia os dados via metodo post
   		$.post('modulos/vendaAtacado/pedidos/manutencao/controller/acoes.php',
		{
			//variaveis a ser enviadas metodo POST
			acao:acao,
			pedido:JSON.stringify(pedido),
			itensPedido:JSON.stringify(itensPedido)
		},
		function(data)
		{
			var icon = Boolean(data.isFinalizado) ? 'ui-icon-circle-check' : 'ui-icon-alert';
			var mensagem = "";
			
			if (acao == DELETE)
			{
				limpaPesquisaPedidos();
				$('#divPedido').unblock();
				novoForm();
				
				if (Boolean(data.isFinalizado))
				{
					mensagem = "OK PEDIDO "+data.codigo+" EXCLUIDO COM SUCESSO!";
				}
				else
				{
					mensagem = "ATENCAO PEDIDO "+data.codigo+" NAO FOI EXCLUIDO! CONTATE O ADMINISTRADOR!";
				}
				
				var html = '<p>'+
				'<span class="ui-icon '+icon+'" style="float: left; margin-right: .3em;"></span>'+
				mensagem+
				'<h5>OBS.: UMA COPIA DO RESULTADO DETALHADO E ARMAZENADA EM ARQUIVO DE LOG.<h5>';
				
				$('#dialog').attr('title', 'EXCLUSAO DE PEDIDO');
				$('#dialog').html(html);
				
				$('#dialog').dialog(
				{
					autoOpen: true,
					modal: true,
					width: 480,
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
			}
			else
			{
				if(data.codigo!=undefined || data.codigo!=null)
				{
					var pvnumeroimp = data.codigo;
				}
				else
				{
					var pvnumeroimp = pedido.pvnumero;
				}
				
				$('#dialog').attr('title', 'IMPRIMIR PEDIDO');
						
				var mensagemimp = "DESEJA IMPRIMIR PEDIDO.";
				
				$('#dialog').html(mensagemimp);
				$('#dialog').dialog(
				{
					autoOpen: true,
					modal: true,
					width: 480,
					buttons: 
					{
						"Não Imprimir": function() 
						{
							$(this).dialog("close");
						},
						"Imprimir Pedido": function() 
						{
							$(this).dialog("close");
							window.open('relpedidopdf.php?pvnumero=0&radioimp=0&c[]='+pvnumeroimp, 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');
						}
					},
					close: function(ev, ui)
					{
						$(this).dialog("destroy");
						
						var txtLogPedido = "";
						
						if (acao == INSERT)
						{
							if (Boolean(data.isFinalizado))
							{
								mensagem = "OK PEDIDO "+data.codigo+" TIPO "+pedido.tipoPedido.descricao+" INSERIDO COM SUCESSO!";
							}
							else
							{
								if (data.codigo == undefined)
								{
									mensagem = "ATENCAO PEDIDO "+data.codigo+" TIPO "+pedido.tipoPedido.descricao+" NAO FINALIZOU INSERCAO! CONTATE O ADMINISTRADOR!";
								}
								else
								{
									mensagem = "ATENCAO PEDIDO NAO FOI INSERIDO! CONTATE O ADMINISTRADOR!";
								}	
							}
							
							mensagem += "<br><br> SEGUE ABAIXO DETALHES.";							
							if(data.logItensOk.length)
							{
								txtLogPedido += "- ITENS APROPRIADOS CORRETAMENTE: "+data.logItensOk.length+"\n";
								
								$.each(data.logItensOk, function (key, value)
								{
									txtLogPedido += "   "+value +"\n";
								});
							}
							else
							{
								txtLogPedido += "- ATENCAO ITENS NAO APROPRIADOS! CONTATE O ADMINISTRADOR! \n";
							}
							
							if(data.logItensErro.length)
							{
								txtLogPedido += "\n\n";
								
								txtLogPedido += "- ITENS APROPRIADOS PARCIALMENTE: "+data.logItensErro.length+"\n";
								
								$.each(data.logItensErro, function (key, value)
								{
									txtLogPedido += "   "+value +"\n";
								});
							}

							if(itensPedidoEmpenho.length)
							{
								$.each(itensPedidoEmpenho, function (key, value)
								{
									var logItensEp = value.produto.procod+" "+ value.produto.prnome +" QTDE: "+ value.pvisaldo;
									data.logItensEp.push(logItensEp);
								});
							}
							
							if(data.logItensEp.length || itensPedidoEmpenho.length)
							{
								txtLogPedido += "\n\n";
								
								txtLogPedido += "- ITENS PARA EMPENHO: "+data.logItensEp.length+"\n";
								
								$.each(data.logItensEp, function (key, value)
								{
									txtLogPedido += "   "+value +"\n";
								});
							}
						}
						else if (acao == UPDATE)
						{
							if (Boolean(data.isFinalizado))
							{
								mensagem = "OK PEDIDO "+pedido.pvnumero+" TIPO "+pedido.tipoPedido.descricao+" ALTERADO COM SUCESSO!";
							}
							else
							{
								mensagem = "ATENCAO PEDIDO NAO FOI ALTERADO CORRETAMENTE! CONTATE O ADMINISTRADOR!";	
							}
							
							travaPedido(false);
							
							mensagem += "<br><br> SEGUE ABAIXO DETALHES.";
							var isNot = true;
							
							if(data.logItensOk.length)
							{
								txtLogPedido += "- ITENS ALTERADOS CORRETAMENTE: "+data.logItensOk.length+"\n";
								
								$.each(data.logItensOk, function (key, value)
								{
									txtLogPedido += "   "+value +"\n";
								});
								
								isNot = false;
							}
							
							if(data.logItensDel.length)
							{
								txtLogPedido += "- ITENS EXCLUIDOS: "+data.logItensDel.length+"\n";
								
								$.each(data.logItensDel, function (key, value)
								{
									txtLogPedido += "   "+value +"\n";
								});
								
								isNot = false;
							}
							
							if(isNot)
							{
								if(!data.logItensErro.length)
								{
									txtLogPedido += "- NAO HA ITENS ALTERADOS NO PEDIDO! \n";
								}
								else
								{
									txtLogPedido += "- ATENCAO ITENS NAO ALTERADOS! CONTATE O ADMINISTRADOR! \n";
								}
							}
							
							if(data.logItensErro.length)
							{
								txtLogPedido += "\n\n";
								
								txtLogPedido += "- ITENS ALTERADOS PARCIALMENTE: "+data.logItensErro.length+"\n";
								
								$.each(data.logItensErro, function (key, value)
								{
									txtLogPedido += "   "+value +"\n";
								});
							}

							if(data.logItensEp.length)
							{
								txtLogPedido += "\n\n";
								
								txtLogPedido += "- ITENS PARA EMPENHO: "+data.logItensEp.length+"\n";
								
								$.each(data.logItensEp, function (key, value)
								{
									txtLogPedido += "   "+value +"\n";
								});
							}
						}
						
						$('#dialog').attr('title','RETORNO DAS ACOES');
						var html = '<p>'+
						'<span class="ui-icon '+icon+'" style="float: left; margin-right: .3em;"></span>'+
						mensagem+
						'</p><textarea name="txtRetornoApropriaEstoque" id="txtRetornoApropriaEstoque" cols="115" rows="29" readonly="readonly">'+txtLogPedido+'</textarea>'+
						'<h5>OBS.: UMA COPIA DO RESULTADO DETALHADO E ARMAZENADA EM ARQUIVO DE LOG.<h5>';
				
						$('#dialog').html(html);
										
						$('#dialog').dialog(
						{
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
								if (data.itensPedidoEmpenho != undefined)
								{
									if(data.itensPedidoEmpenho.length)
									{																		
										$.each(data.itensPedidoEmpenho, function (_key, _value)
										{
											var repetido = false;
											
											$.each(itensPedidoEmpenho, function (key, value)
											{
												if(_value.produto.procodigo == value.produto.procodigo)
												{
													itensPedidoEmpenho[key].pvisaldo += _value.pvisaldo;
													repetido = true;
												}
											});
											
											if(!repetido)
											{
												itensPedidoEmpenho.push(_value);
											}
										});
									}
								}
								
								$(this).dialog("destroy");

								if(itensPedidoEmpenho.length)
								{
									$('#dialog').attr('title', 'Gerar Pedido Empenho');
									var mensagem = "DESEJA GERAR PEDIDO DO TIPO EMPENHO, SERA GERADO UM NOVO NUMERO DE PEDIDO.";
									$('#dialog').html(mensagem);
										
									$('#dialog').dialog(
									{
										autoOpen: true,
										modal: true,
										width: 480,
										buttons: 
										{
											"Excluir Empenho": function() 
											{
												$(this).dialog("close");
												
												limpaPesquisaPedidos();
												novoForm();
											},
											"Gerar Empenho": function()
											{
												$.each(tiposPedido, function (key, value)
												{
													if (value.codigo == TIPO_EMPENHO)
													{
														pedido.tipoPedido = value;
														return false;
													}
												});
												
												itensPedido = itensPedidoEmpenho;
												itensPedidoEmpenho = new Array();
												
												var titulo = "PROCESSANDO, AGUARDE...";
												var mensagem = "EXECUTANDO PEDIDO EMPENHO.";
												$("#retorno").messageBoxModal(titulo, mensagem);
												
												crudExe(INSERT);
												$('#divPedido').unblock();
												
												$(this).dialog("close");
											}
										},
										close: function(ev, ui)
										{											
											$(this).dialog("destroy");
										}
									});
								}
								else
								{	
									if(acao == UPDATE)
									{
										if(pedido.tipoPedido.sigla != "Z")
										{
											if(pedido.tipoPedido.sigla != "D")	
											{
												window.location="dtrade.php?flagmenu=9&pgcodigo=11&pvnumero="+pedido.pvnumero;
											}
										}	
							   		}
									
									limpaPesquisaPedidos();
									novoForm();
									if(data.fecreserva!=0)
									{
									window.location="dtrade.php?flagmenu=9&pgcodigo=11&pvnumero="+data.codigo;
									}
								}
   							}
						});
					}
				});	
			}
			$.unblockUI();
		}, "json");
	}
	
	return retorno;
}
function crudExe2(acao)
{
	var retorno = false;
	
	//executa insert, select, updete, delete
	if(Boolean(acao))
	{	
		//Envia os dados via metodo post
   		$.post('modulos/vendaAtacado/pedidos/manutencao/controller/acoes.php',
		{
			//variaveis a ser enviadas metodo POST
			acao:acao,
			pvnumeroDel:pedido.pvnumero,
			movestoque:pedido.pvemissao,
			estoque:estoqueAtivo.etqcodigo,
			usuarioDel:usuario.codigo
		},
		function(data)
		{
			var icon = Boolean(data.isFinalizado) ? 'ui-icon-circle-check' : 'ui-icon-alert';
			var mensagem = "";
			
			if (acao == DELETE)
			{
				limpaPesquisaPedidos();
				$('#divPedido').unblock();
				novoForm();
				
				if (Boolean(data.isFinalizado))
				{
					mensagem = "OK PEDIDO "+data.codigo+" EXCLUIDO COM SUCESSO!";
				}
				else
				{
					mensagem = "ATENCAO PEDIDO "+data.codigo+" NAO FOI EXCLUIDO! CONTATE O ADMINISTRADOR!";
				}
				
				var html = '<p>'+
				'<span class="ui-icon '+icon+'" style="float: left; margin-right: .3em;"></span>'+
				mensagem+
				'<h5>OBS.: UMA COPIA DO RESULTADO DETALHADO E ARMAZENADA EM ARQUIVO DE LOG.<h5>';
				
				$('#dialog').attr('title', 'EXCLUSAO DE PEDIDO');
				$('#dialog').html(html);
				
				$('#dialog').dialog(
				{
					autoOpen: true,
					modal: true,
					width: 480,
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
			}
			else
			{
				if(data.codigo!=undefined || data.codigo!=null)
				{
					var pvnumeroimp = data.codigo;
				}
				else
				{
					var pvnumeroimp = pedido.pvnumero;
				}
				
				$('#dialog').attr('title', 'IMPRIMIR PEDIDO');
						
				var mensagemimp = "DESEJA IMPRIMIR PEDIDO.";
				
				$('#dialog').html(mensagemimp);
				$('#dialog').dialog(
				{
					autoOpen: true,
					modal: true,
					width: 480,
					buttons: 
					{
						"Não Imprimir": function() 
						{
							$(this).dialog("close");
						},
						"Imprimir Pedido": function() 
						{
							$(this).dialog("close");
							window.open('relpedidopdf.php?pvnumero=0&radioimp=0&c[]='+pvnumeroimp, 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');
						}
					},
					close: function(ev, ui)
					{
						$(this).dialog("destroy");
						
						var txtLogPedido = "";
						
						if (acao == INSERT)
						{
							if (Boolean(data.isFinalizado))
							{
								mensagem = "OK PEDIDO "+data.codigo+" TIPO "+pedido.tipoPedido.descricao+" INSERIDO COM SUCESSO!";
							}
							else
							{
								if (data.codigo == undefined)
								{
									mensagem = "ATENCAO PEDIDO "+data.codigo+" TIPO "+pedido.tipoPedido.descricao+" NAO FINALIZOU INSERCAO! CONTATE O ADMINISTRADOR!";
								}
								else
								{
									mensagem = "ATENCAO PEDIDO NAO FOI INSERIDO! CONTATE O ADMINISTRADOR!";
								}	
							}
							
							mensagem += "<br><br> SEGUE ABAIXO DETALHES.";							
							if(data.logItensOk.length)
							{
								txtLogPedido += "- ITENS APROPRIADOS CORRETAMENTE: "+data.logItensOk.length+"\n";
								
								$.each(data.logItensOk, function (key, value)
								{
									txtLogPedido += "   "+value +"\n";
								});
							}
							else
							{
								txtLogPedido += "- ATENCAO ITENS NAO APROPRIADOS! CONTATE O ADMINISTRADOR! \n";
							}
							
							if(data.logItensErro.length)
							{
								txtLogPedido += "\n\n";
								
								txtLogPedido += "- ITENS APROPRIADOS PARCIALMENTE: "+data.logItensErro.length+"\n";
								
								$.each(data.logItensErro, function (key, value)
								{
									txtLogPedido += "   "+value +"\n";
								});
							}

							if(itensPedidoEmpenho.length)
							{
								$.each(itensPedidoEmpenho, function (key, value)
								{
									var logItensEp = value.produto.procod+" "+ value.produto.prnome +" QTDE: "+ value.pvisaldo;
									data.logItensEp.push(logItensEp);
								});
							}
							
							if(data.logItensEp.length || itensPedidoEmpenho.length)
							{
								txtLogPedido += "\n\n";
								
								txtLogPedido += "- ITENS PARA EMPENHO: "+data.logItensEp.length+"\n";
								
								$.each(data.logItensEp, function (key, value)
								{
									txtLogPedido += "   "+value +"\n";
								});
							}
						}
						else if (acao == UPDATE)
						{
							if (Boolean(data.isFinalizado))
							{
								mensagem = "OK PEDIDO "+pedido.pvnumero+" TIPO "+pedido.tipoPedido.descricao+" ALTERADO COM SUCESSO!";
							}
							else
							{
								mensagem = "ATENCAO PEDIDO NAO FOI ALTERADO CORRETAMENTE! CONTATE O ADMINISTRADOR!";	
							}
							
							travaPedido(false);
							
							mensagem += "<br><br> SEGUE ABAIXO DETALHES.";
							var isNot = true;
							
							if(data.logItensOk.length)
							{
								txtLogPedido += "- ITENS ALTERADOS CORRETAMENTE: "+data.logItensOk.length+"\n";
								
								$.each(data.logItensOk, function (key, value)
								{
									txtLogPedido += "   "+value +"\n";
								});
								
								isNot = false;
							}
							
							if(data.logItensDel.length)
							{
								txtLogPedido += "- ITENS EXCLUIDOS: "+data.logItensDel.length+"\n";
								
								$.each(data.logItensDel, function (key, value)
								{
									txtLogPedido += "   "+value +"\n";
								});
								
								isNot = false;
							}
							
							if(isNot)
							{
								if(!data.logItensErro.length)
								{
									txtLogPedido += "- NAO HA ITENS ALTERADOS NO PEDIDO! \n";
								}
								else
								{
									txtLogPedido += "- ATENCAO ITENS NAO ALTERADOS! CONTATE O ADMINISTRADOR! \n";
								}
							}
							
							if(data.logItensErro.length)
							{
								txtLogPedido += "\n\n";
								
								txtLogPedido += "- ITENS ALTERADOS PARCIALMENTE: "+data.logItensErro.length+"\n";
								
								$.each(data.logItensErro, function (key, value)
								{
									txtLogPedido += "   "+value +"\n";
								});
							}

							if(data.logItensEp.length)
							{
								txtLogPedido += "\n\n";
								
								txtLogPedido += "- ITENS PARA EMPENHO: "+data.logItensEp.length+"\n";
								
								$.each(data.logItensEp, function (key, value)
								{
									txtLogPedido += "   "+value +"\n";
								});
							}
						}
						
						$('#dialog').attr('title','RETORNO DAS ACOES');
						var html = '<p>'+
						'<span class="ui-icon '+icon+'" style="float: left; margin-right: .3em;"></span>'+
						mensagem+
						'</p><textarea name="txtRetornoApropriaEstoque" id="txtRetornoApropriaEstoque" cols="115" rows="29" readonly="readonly">'+txtLogPedido+'</textarea>'+
						'<h5>OBS.: UMA COPIA DO RESULTADO DETALHADO E ARMAZENADA EM ARQUIVO DE LOG.<h5>';
				
						$('#dialog').html(html);
										
						$('#dialog').dialog(
						{
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
								if (data.itensPedidoEmpenho != undefined)
								{
									if(data.itensPedidoEmpenho.length)
									{																		
										$.each(data.itensPedidoEmpenho, function (_key, _value)
										{
											var repetido = false;
											
											$.each(itensPedidoEmpenho, function (key, value)
											{
												if(_value.produto.procodigo == value.produto.procodigo)
												{
													itensPedidoEmpenho[key].pvisaldo += _value.pvisaldo;
													repetido = true;
												}
											});
											
											if(!repetido)
											{
												itensPedidoEmpenho.push(_value);
											}
										});
									}
								}
								
								$(this).dialog("destroy");

								if(itensPedidoEmpenho.length)
								{
									$('#dialog').attr('title', 'Gerar Pedido Empenho');
									var mensagem = "DESEJA GERAR PEDIDO DO TIPO EMPENHO, SERA GERADO UM NOVO NUMERO DE PEDIDO.";
									$('#dialog').html(mensagem);
										
									$('#dialog').dialog(
									{
										autoOpen: true,
										modal: true,
										width: 480,
										buttons: 
										{
											"Excluir Empenho": function() 
											{
												$(this).dialog("close");
												
												limpaPesquisaPedidos();
												novoForm();
											},
											"Gerar Empenho": function()
											{
												$.each(tiposPedido, function (key, value)
												{
													if (value.codigo == TIPO_EMPENHO)
													{
														pedido.tipoPedido = value;
														return false;
													}
												});
												
												itensPedido = itensPedidoEmpenho;
												itensPedidoEmpenho = new Array();
												
												var titulo = "PROCESSANDO, AGUARDE...";
												var mensagem = "EXECUTANDO PEDIDO EMPENHO.";
												$("#retorno").messageBoxModal(titulo, mensagem);
												
												crudExe(INSERT);
												$('#divPedido').unblock();
												
												$(this).dialog("close");
											}
										},
										close: function(ev, ui)
										{											
											$(this).dialog("destroy");
										}
									});
								}
								else
								{	
									if(acao == UPDATE)
									{
										if(pedido.tipoPedido.sigla != "Z")
										{
											if(pedido.tipoPedido.sigla != "D")	
											{
												window.location="dtrade.php?flagmenu=9&pgcodigo=11&pvnumero="+pedido.pvnumero;
											}
										}	
							   		}
									
									limpaPesquisaPedidos();
									novoForm();
									window.location="dtrade.php?flagmenu=9&pgcodigo=11&pvnumero="+pedido.pvnumero;
								}
   							}
						});
					}
				});	
			}
			$.unblockUI();
		}, "json");
	}
	
	return retorno;
}
/**
 * função para popular o pedido com os dados regastados
 */
function populaCampos(isRecuperar)
{
	var dataEmissao = new Date().date(pedido.pvemissao);
	var option = "";
	totalMattel = 0;
	
	
	$("#dataEmissaoPedido").val($.mask.string(dataEmissao.format('dmY'), 'date'));
	
	if(pedido.pventrega)
	{
		var dataEntrega = new Date().date(pedido.pventrega);
		$("#dataEntrega").val($.mask.string(dataEntrega.format('dmY'), 'date'));
	}
	
	$.each(tiposPedido, function (key, value)
	{
		if (value.codigo == pedido.tipoPedido.codigo)
		{
			$('#listaTipoPedidos').val(key);
			return false;
		}
	});
	
	hideShowComponente();
	
	if(pedido.tipoPedido.codigo == ABASTECIMENTO)
	{
		$.each(estoques, function (key, value)
		{
			if (value.etqcodigo == pedido.estoqueOrigem.etqcodigo)
			{
				$('#listaEstoqueOrigem').val(key);
			}
			else if (value.etqcodigo == pedido.estoqueDestino.etqcodigo)
			{
				$('#listaEstoqueDestino').val(key);
			}
		});
		
		$('#listaTipoPedidos').attr("disabled","disabled");
		$('#listaEstoqueOrigem').attr("disabled","disabled");
		$('#listaEstoqueDestino').attr("disabled","disabled");
	}
	else
	{
		$('#listaTipoPedidos').attr("disabled","");
		$('#listaEstoqueOrigem').attr("disabled","");
		$('#listaEstoqueDestino').attr("disabled","");
		
		if(pedido.tipoPedido.codigo == DEVOLUCAO)
		{
			option = "";
			if (pedido.fornecedor.forcodigo)
			{
				if (pedido.fornecedor.forcodigo)
				{
					option = '<option value="' + pedido.fornecedor.forcodigo + '">'+ pedido.fornecedor.forcodigo +' - '+ pedido.fornecedor.fornguerra +'</option>';
				}
			}
			$("#listaPesquisaFornecedores").append(option);
		}
		else
		{
			option = "";
			if (pedido.cliente.clicodigo)
			{
				option = '<option value="' + pedido.cliente.clicodigo + '">'+ pedido.cliente.clicod +' - '+ pedido.cliente.clirazao +'</option>';
			}
			$("#listaPesquisaClientes").append(option);
		}
		
		option = "";
		if (pedido.vendedor.vencodigo)
		{
			option = '<option value="' + pedido.vendedor.vencodigo + '">'+ pedido.vendedor.vencodigo +' - '+ pedido.vendedor.vennguerra +'</option>';
		}
		$("#listaPesquisaVendedores").append(option);
		
		$.each(condicoesComerciais, function (key, value)
		{
			if (value.codigo == pedido.condicaoComercial.codigo)
			{
				$('#listaCondicoesComerciais').val(key);
				return false;
			}
		});
		
		$("#txtLocalEntrega").val(pedido.pvlocal);
		$("#txtExcecoes").val(pedido.pvobserva);
		$("#txtValorDesconto").val($.mask.string(Number(pedido.pvvaldesc).toFixed(2), 'decimal'));
		$("#txtPercentualDesconto").val(numberToDecimal(pedido.pvperdesc));
	
		valorDesconto = pedido.pvvaldesc;
		percentualDesconto = pedido.pvperdesc;	

		option = "";
		if (pedido.transportadora.tracodigo)
		{
			option = '<option value="' + pedido.transportadora.tracodigo + '">'+ pedido.transportadora.tracodigo +' - '+ pedido.transportadora.trarazao + '</option>';
		}
		$("#listaPesquisaTransportadoras").append(option);
	
		$("input[name='opcoesTipoFrete']").val([pedido.pvtipofrete]);
	}
	
	$("#txtObservacao").val(pedido.pvnewobs);
	
	if (pedido.usuario != null)
	{
		if (pedido.usuario.codigo == null)
		{
			pedido.usuario = usuario;
		}
	}
	
	if (pedido.usuarioCadastroPedido)
	{
		$("#nomeUsuario").text(pedido.usuarioCadastroPedido.nome);
	}
	
	if (pedido.historico)
	{
		var dataAcao = new Date().date(pedido.historico[0].dataAcao);
		$("#usuarioUltimaAlteracao").text(pedido.historico[0].usuario.nome);
		$("#dataUltimaAlteracao").text(dataAcao.format('d/m/Y H:i'));
		if (pedido.pvlibera)
		{
			var dataLibera = new Date().date(pedido.pvlibera);
			if (dataAcao > dataLibera)
			{
				$("#statusAlteracaoLiberado").text('ALTERADO APOS LIBERACAO ('+dataLibera.format('d/m/Y H:i')+')');
			}
		}
	}
	else
	{
		$("#usuarioUltimaAlteracao").text('NAO HA HISTORICO!');
	}
	
	if (pedido.pvvalor)
	{
		subtotal = pedido.pvvalor;
	}
		
	$('#divPedido').blockAlterar();

	if (!isRecuperar)
	{
		grupoBotoes(0, 0, 0, BOTAO_NOVO);
		$("#importarPedido").attr("disabled","disabled");
		
		//popula com os itens do pedido;
		getItens();
	}
	else
	{
		$('#listaTipoPedidos').attr("disabled","");
		$('#listaEstoqueOrigem').attr("disabled","");
		$('#listaEstoqueDestino').attr("disabled","");
		
		listaItensPedido(itemPedido, itemPedidoEmpenho, false);
	}
	
	getFifhotes();
}

function verificaPedidoTmp()
{
	//Envia os dados via metodo post
	$.post('modulos/vendaAtacado/pedidos/manutencao/controller/acoes.php',
	{
		//variaveis a ser enviadas metodo POST
		pedido:JSON.stringify(pedido),
		acao: 8
	},
	function(data)
	{
		if (data.retorno)
		{
			var titulo = "RECUPERASAO DE PEDIDO";
			$('#dialog').attr('title', titulo);
			var mensagem = "<p><b>"+data.mensagem+"</b><br><br>";
			
			switch (Number(data.pedido.tipoPedido.codigo))
			{
				case DEVOLUCAO:
					mensagem += "FORNECEDOR: "+data.pedido.fornecedor.fornguerra;
					break;
					
				case ABASTECIMENTO:
					mensagem += "ABASTECIMENTO: ESTOQUE ORIGEM "+data.pedido.estoqueOrigem.etqcodigo+" ESTOQUE DESTINO "+data.pedido.estoqueDestino.etqcodigo;
					break;
					
				default:
					mensagem += "CLIENTE: "+data.pedido.cliente.clinguerra;
					break;
			}

			
			
			if (data.itensPedido.length)
			{
				mensagem += "</p>"+data.itensPedido.length+" ITENS:<br>";
	
				$.each(data.itensPedido, function (key, value)
				{
					mensagem += "&nbsp;&nbsp;-> <i>"+value.produto.procod+" "+value.produto.prnome+" QTDE "+value.pvisaldo+" Total "+$.mask.string((Number(value.pvisaldo)*Number(value.pvipreco)).toFixed(2), 'decimal')+"</i><br>";
				});
			}
			
			if (data.itensPedidoEmpenho.length)
			{
				mensagem += "</p>"+data.itensPedidoEmpenho.length+" ITENS EMPENHO:<br>";
	
				$.each(data.itensPedidoEmpenho, function (key, value)
				{
					mensagem += "&nbsp;&nbsp;-> <i>"+value.produto.procod+" "+value.produto.prnome+" QTDE "+value.pvisaldo+" Total "+$.mask.string((Number(value.pvisaldo)*Number(value.pvipreco)).toFixed(2), 'decimal')+"</i><br>";
				});
			}
			
			mensagem += "<br><br>TOTAL DO PEDIDO: "+$.mask.string(Number(data.pedido.pvvalor).toFixed(2), 'decimal');
			
			$('#dialog').html(mensagem);
			
			
			
			$('#dialog').dialog({
				autoOpen: true,
				position: ['center','top'],
				modal: true,
				width: 750,
				height: 640,
				buttons: {
					"Restaurar": function()
					{
						pedido = data.pedido;
				
						itensPedido = data.itensPedido;
						itensPedidoEmpenho = data.itensPedidoEmpenho;
						
						populaCampos(true);
						$('#divPedido').unblock();
						var mensagem = "PEDIDO TEMPORARIO RECUPERADO.";
						$("#retorno").messageBox(mensagem,true,false);
						$(this).dialog("close");
						limpaPedidoTmp();
					},
					"Limpar": function()
					{
						$(this).dialog("close");
						limpaPedidoTmp();
					}
				},
				close: function(ev, ui)
				{
					$(this).dialog("destroy");
				}
			});
		}
	},"json");
}

function gerarPedidoTmp()
{
	//Envia os dados via metodo post
	$.post('modulos/vendaAtacado/pedidos/manutencao/controller/acoes.php',
	{
		//variaveis a ser enviadas metodo POST
		pedido:JSON.stringify(pedido),
		itensPedido:JSON.stringify(itensPedido),
		itensPedidoEmpenho:JSON.stringify(itensPedidoEmpenho),
		acao: 10
	},
	function(data)
	{
		var mensagem;
		if (data)
		{
			mensagem = "PEDIDO SALVO EM TEMPORARIOS.";
		}
		else
		{
			mensagem = "NAO E POSSIVEL SALVAR PEDIDO NOS TEMPORARIOS.";
		}
		
		$("#retorno").messageBox(mensagem,true,false);

	},"json");
	
	alert("PEDIDO FECHADO DE FORMA INEXPERADA!");

}

function limpaPedidoTmp()
{
	//Envia os dados via metodo post
	$.post('modulos/vendaAtacado/pedidos/manutencao/controller/acoes.php',
	{
		//variaveis a ser enviadas metodo POST
		pedido:JSON.stringify(pedido),
		acao: 9
	},
	function(data)
	{
		var mensagem;
		
		if (data)
		{
			mensagem = "EXCLUIDO PEDIDO SALVO EM TEMPORARIOS.";
		}
		else
		{
			mensagem = "NAO E POSSIVEL EXCLUIR PEDIDO DOS TEMPORARIOS.";
		}
		
		//$("#retorno").messageBox(mensagem,true,false);
	},"json");
}

function travaPedido(trava)
{
		var usucodigo = null;
		if (trava)
		{
			usucodigo = usuario.codigo;
		}
		
		//Envia os dados via metodo post
		$.post('modulos/vendaAtacado/pedidos/manutencao/controller/acoes.php',
		{
			//variaveis a ser enviadas metodo POST
			acao:13,
			pvnumero:pedido.pvnumero,
			usucodigo:usucodigo
		},
		function(data)
		{
			/* Para exibir mensagem travamento e destravamento do pedido
			 * 
			 var mensagem;
			if (data.retorno)
			{
				mensagem = "USUARIO "+usuario.nome+" FAZENDO MANUTENCAO DO PEDIDO.";
			}
			else
			{
				mensagem = data.mensagem;
			}
			$("#retorno").messageBox(mensagem,true,false);*/
			
		}, "json");
}

function novoForm()
{
	itensPedido = new Array();
	itensPedidoEmpenho = new Array();
	itemPedido = new Object();
	itemPedidoEmpenho = new Object();
	estoqueAtivo = new Object();
	allEstoques = new Array();

	valorUnitItem = 0;
	valorTotalItem = 0;
	valorTotalItemEmpenho = 0;
	qtdTotalItem = 0;
	qtdTotalItemEmpenho = 0;
	tabela = 'C';
	ordemItem = 0;
	percentualDesconto = 0;
	valorDesconto = 0;
	subtotal = 0;
	totalPagar = 0;
	totalPago = 0;
	
	var dataEmissao = new Date();
	$("#dataEmissaoPedido").val($.mask.string(dataEmissao.format('dmY'), 'date'));
	
	$("#importarPedido").attr("disabled","");
	
	if($('#formTipoPedido').validate().form())
	{
		$('#listaTipoPedidos').val("").focus().attr("disabled","");
	}
	
	$('#listaEstoqueOrigem').val("").attr("disabled","");
	$('#listaEstoqueDestino').val("").attr("disabled","");

	limpaPesquisaClientes();
	limpaPesquisaFornecedores();
	limpaPesquisaVendedores();
	
	$("#formCondicoesComerciais").validate().resetForm();
	$("#listaCondicoesComerciais").val("");
	$('#txtLocalEntrega').val("");
	$('#txtExcecoes').val("");
	
	limpaPesquisaProdutos();
	
	var codHtmlS = '<table border="0" cellpadding="0" cellspacing="0" width="100%">'+
		'<tr bgcolor="#FFFFFF">'+
			'<td height="25" width="100%" align="center">'+
			'Nenhum produto foi incluido ao pedido!'+
			'</td>'+
		'</tr>'+
	'</table>';

	$('#itensPedido').html(codHtmlS);
	
	$("#txtValorDesconto").attr("disabled","disabled").val($.mask.string(0, 'decimal'));
	$("#txtPercentualDesconto").attr("disabled","disabled").val($.mask.string(0, 'percentual'));

	limpaPesquisaTransportadoras();
	
	$("#dataEntrega").val("");
	
	$('#txtObservacao').val("");
	
	$("#nomeUsuario").text('');
	$("#usuarioUltimaAlteracao").text('');
	$("#dataUltimaAlteracao").text('');
	$("#statusAlteracaoLiberado").text('');
	
	$("#lblSubtotal").text($.mask.string(0, 'decimal'));
	$("#lblValorDesconto").text($.mask.string(0, 'decimal'));
	$("#lblTotalMattel").text($.mask.string(0, 'decimal'));
	$("#lblTotal").text($.mask.string(0, 'decimal'));
	
	$("#lblLimiteDisponivel").text($.mask.string(0, 'decimal'));
	$("#lblLimiteTotal").text($.mask.string(0, 'decimal'));
	$("#lblDataUltimaCompra").text('--');
	$("#lblSerasa").text('NAO');
	
	hideShowComponente();
	
	grupoBotoes(BOTAO_LIMPAR, BOTAO_ABRIR, BOTAO_APROPRIAR, BOTAO_SALVAR);
}













function importarPedido()
{
	var arquivo = 'arquivos/modelos/pedido.xls';
	
	if (usuario.nivel == VENDAS_EXTERNA)
	{
		arquivo = 'arquivos/modelos/pedidoEx.xls';
	}
	
	$('#dialog').attr('title','ABRIR PEDIDO');
	$('#dialog').html('<p>IMPORTAR PEDIDO NO FORMATO XLS (EXCEL).</p>'+
			'<div id="swfupload-control">'+
			'<p>PERMITIDO ENVIAR 1 ARQUIVO NO FORMA XLS, TAMANHO MAXIMO DO ARQUIVO DE 10MB.</p>'+
			'<input type="button" id="button" />'+
			'<p id="queuestatus" ></p>'+
			'<ol id="log"></ol>'+
			'<p><a href="'+arquivo+'">BAIXE O ARQUIVO MODELO PARA IMPORTACAO DE PEDIDO. </a></p>'+
			'</div>');
	
	$('#dialog').dialog({
		autoOpen: true,
		width: 600,
		modal: true,
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
	
	
	$('#swfupload-control').upload(
	{ 
		fileTypesDescription:"Arquivo do Excel",
		fileTypes:"*.xls",
		fileSizeLimit:"10240",
		uploadUrl: "modulos/vendaAtacado/pedidos/manutencao/controller/uploadPedidoExcel.php",
		buttonImageUrl : 'lib/jquery/js/swfupload/buttons_carregarPedido_114x29.png',
		uploadSuccess : function(event, file, data)
		{
			limpaPesquisaPedidos();
			$('#divPedido').unblock();
			pedido = new Object();
			novoForm();
		
			
			var item = $('#log li#'+file.id);
			item.find('div.progress').css('width', '100%');
			item.find('span.progressvalue').text('100%');
			item.addClass('success').find('p.status').html('IMPORTACAO DE PEDIDO CONCLUIDA!');
			
			var retorno = eval('(' + data + ')');
			pedido = retorno.pedido;
			itensPedido = retorno.itensPedido;
			itensPedidoEmpenho = retorno.itensPedidoEmpenho;
			
			populaCampos(true);
			$('#divPedido').unblock();
			
			$('#dialog').dialog("close");
			
			alerta("IMPORTACAO DE PEDIDO", retorno.mensagem);
		}
	});
}


















function hideShowComponente()
{
	if(pedido.tipoPedido)
	{
		switch (Number(pedido.tipoPedido.codigo))
		{
			case DEVOLUCAO:
				$('#tblCliente').hide();
				$('#tblFornecedor').show();
				$('#tblEstoqueOrigem').hide();
				$('#tblEstoqueDestino').hide();
				$('#tblVendedor').hide();
				$('#tblMaisInformacao').hide();
				$('#tblDesconto').hide();
				$('#tblDescontoTotal').hide();
				break;
				
			case ABASTECIMENTO:
				$('#tblEstoqueOrigem').show();
				$('#tblEstoqueDestino').show();
				$('#tblFornecedor').hide();
				$('#tblCliente').hide();
				$('#tblVendedor').hide();
				$('#tblMaisInformacao').hide();
				$('#tblDesconto').hide();
				$('#tblTransporte').hide();
				$('#tblDescontoTotal').hide();
				break;
				
			default:
				$('#tblCliente').show();
				$('#tblFornecedor').hide();
				$('#tblEstoqueOrigem').hide();
				$('#tblEstoqueDestino').hide();
				$('#tblVendedor').show();
				$('#tblMaisInformacao').show();
				$('#tblDesconto').show();
				$('#tblTransporte').show();
				$('#tblDescontoTotal').show();
				break;
		}
	}
}

function getItens()
{
	var codHtmlS = '<table border="0" cellpadding="0" cellspacing="0" width="100%">'+
		'<tr bgcolor="#FFFFFF">'+
			'<td height="25" width="100%" align="center">'+
			'<img src="imagens/load.gif"> <br> Carregando Itens Pedido! Aguarde...'+
			'</td>'+
		'</tr>'+
	'</table>';

	$('#itensPedido').html(codHtmlS);
	$('#incluirProduto').attr('disabled','disabled');
	
	//estoqueBloqueado = false;
	
	//Envia os dados via metodo post
	$.post('modulos/vendaAtacado/pedidos/manutencao/controller/getItens.php',
	{
		//variaveis a ser enviadas metodo POST
		pvnumero:pedido.pvnumero
	},
	function(data)
	{
		if (data.retorno)
		{
			mensagem = data.itensPedido.length + " ITENS CARREGADOS.";
			itensPedido = data.itensPedido;

			$.each(itensPedido, function (key, value)
			{
				itensPedido[key].estoques = value.estoques;
				$.each(value.estoques, function (keyE, valueE)
				{
					/*if(Number(valueE.estoqueAtual.estoque.etqcodigo) == 9)
					{
						estoqueBloqueado = true;
					}*/

					if (!estoqueAtivo && (valueE.estoqueAtual.estoque.etqcodigo != EMPENHO || valueE.estoqueAtual.estoque.etqcodigo != PENDENTES))
					{
						estoqueAtivo = clone(valueE.estoqueAtual.estoque);
					}
				});
			});

			listaItensPedido(itemPedido, itemPedidoEmpenho, false);
		}
		else
		{
			mensagem = "ITENS NAO FORAM CARREGADOS.";
			itensPedido = new Array();
			
				var codHtmlS = '<table border="0" cellpadding="0" cellspacing="0" width="100%">'+
				'<tr bgcolor="#FFFFFF">'+
					'<td height="25" width="100%" align="center">'+
					'Nenhum produto foi incluido ao pedido!'+
					'</td>'+
				'</tr>'+
			'</table>';
	
			$('#itensPedido').html(codHtmlS);
		}
		
		var dataInventario =  new Date().date(DATA_INVENTARIO);
		var dataEmissao = new Date().date(pedido.pvemissao);
		
		if (dataEmissao < dataInventario)
		{
			if (usuario.acesso.acesso1 && usuario.acesso.acesso2 && usuario.acesso.acesso3)
			{
				grupoBotoes(BOTAO_EXCLUIR, 0, BOTAO_ALTERAR, BOTAO_NOVO);
			}
			else
			{
				grupoBotoes(0, 0, 0, BOTAO_NOVO);
				var titulo = "PEDIDO BLOQUEADO";
				var mensagem = "NAO E POSSIVEL ALTERAR OU CANCELAR PEDIDO ANTERIOR A DATA DO INVENTARIO.";
				alerta(titulo, mensagem);
			}
		}
		else
		{
			if(pedido.pvsituacao && !pedido.pvlibera)
			{
				grupoBotoes(BOTAO_EXCLUIR, 0, BOTAO_ALTERAR, BOTAO_NOVO);
			}
			else
			{
				grupoBotoes(0, 0, 0, BOTAO_NOVO);
				
				var titulo = "";
				var mensagem = "";
				
				if (!pedido.pvsituacao)
				{
					if (pedido.tipoPedido.codigo == TIPO_EMPENHO)
					{
						titulo = "PEDIDO TIPO EMPENHO";
						mensagem = "PEDIDO TIPO EMPENHO NAO PERMITE ALTERAR OU CANCELAR.";
						alerta(titulo, mensagem);
					}
					else
					{
						if (pedido.usuario.codigo == usuario.codigo)
						{
							titulo = "PEDIDO BLOQUEADO";
							mensagem = "A SITUACAO DO PEDIDO NAO PERMITE ALTERAR OU CANCELAR.";
							alerta(titulo, mensagem);
						}
					}
				}
				else if (pedido.pvlibera)
				{
					if (usuario.tipoAcessos)
					{
						if (!usuario.tipoAcessos[118])
						{
							titulo = "PEDIDO LIBERADO";
							mensagem = "USUARIO SEM PERMISSAO PARA ALTERAR PEDIDO LIBERADO.";
							alerta(titulo, mensagem);
						}
						else
						{
							grupoBotoes(BOTAO_EXCLUIR, 0, BOTAO_ALTERAR, BOTAO_NOVO);
						}
					}
					else
					{
						titulo = "PEDIDO LIBERADO";
						mensagem = "USUARIO SEM PERMISSAO PARA ALTERAR PEDIDO LIBERADO.";
						alerta(titulo, mensagem);
					}
				}
			}
		}

		$('#incluirProduto').attr('disabled','');
		
		$("#retorno").messageBox(mensagem,data.retorno,data.retorno);
	}, "json");
}

function getFifhotes()
{
	if (pedido.tipoPedido.codigo == RESERVA)
	{
		//Envia os dados via metodo post
		$.post('modulos/vendaAtacado/pedidos/manutencao/controller/getPedidosFilhos.php',
		{
			//variaveis a ser enviadas metodo POST
			pvnumero:pedido.pvnumero
		},
		function(data)
		{
			if (data.retorno)
			{
				pedidosFilhos = new Array();

				$.each(data.pedidos, function (key, value)
				{
					pedidosFilhos.push(value);
				});
				
				var msg = "PEDIDO RESERVA: "+pedidosFilhos.length+" FILHO(S).";
				$("#retorno").messageBox(msg, true, true);
			}
		},"json");
	}
}