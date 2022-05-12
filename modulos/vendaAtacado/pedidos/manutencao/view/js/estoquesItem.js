/**
 * @author Wellington
 *
 * Pesquisa - ação para fazer busca e trazer dados.
 *
 * Criação    03/12/2009
 * Modificado 03/12/2009
 *
 *	
 */
	
$(function()
{
	$('#incluirProduto').click(function()
	{
		//mensagens para verificação dos campos
		var msg ="INFORME OS CAMPOS ABAIXO PARA INCLUIR PRODUTO AO PEDIDO:<br>";
		if(!$('#formTipoPedido').validate().form())
		{
			msg += "<br><b> - SELECIONAR TIPO DE PEDIDO</b>"; 
		}
		
		if(pedido.tipoPedido)
		{
			switch (Number(pedido.tipoPedido.codigo))
			{
				case ABASTECIMENTO:
					if(!$('#formEstoqueOrigem').validate().form())
					{
						msg += "<br><b> - SELECIONAR ESTOQUE DE ORIGEM</b>"; 
					}
					
					if(!$('#formEstoqueDestino').validate().form())
					{
						msg += "<br><b> - SELECIONAR ESTOQUE DE DESTINO</b>";
					}
					break;
					
				case DEVOLUCAO:
					if(!$('#formResultadoFornecedores').validate().form())
					{
						msg += "<br><b> - LOCALIZAR FORNECEDOR</b>";
					}
					break;
					
				default:
					if(!$('#formResultadoClientes').validate().form())
					{
						msg += "<br><b> - LOCALIZAR CLIENTE</b>";
					}
					break;
			}
		}

		if(!$('#formResultadoProdutos').validate().form())
		{
			msg += "<br><b> - LOCALIZAR PRODUTO</b>";
		}
		
		//VERIFICA INCLUSAO
		var isIncluir = false;
		if($('#formTipoPedido').validate().form() && $('#formResultadoProdutos').validate().form())
		{
			switch (Number(pedido.tipoPedido.codigo))
			{
				case ABASTECIMENTO:
					if($('#formEstoqueOrigem').validate().form() && $('#formEstoqueDestino').validate().form())
					{
						isIncluir = true;
					}
					break;
					
				case DEVOLUCAO:
					if($('#formResultadoFornecedores').validate().form())
					{
						isIncluir = true;
					}
					break;
					
				default:
					if($('#formResultadoClientes').validate().form())
					{
						isIncluir = true;
					}
					break;
			}
		}
		
		//EXECUTA INCLUIR PRODUTO
		if(isIncluir)
		{
			//verifica se existe o produto para alterar o item
			var isUpdate = false;
			if (itensPedido.length > 0)
			{
				$.each(itensPedido, function (key, value)
				{
					if (value.produto.procodigo == produto.procodigo)
					{
						isUpdate = true;
						itemPedido = value;
					}
				});
			}
			if (itensPedidoEmpenho.length > 0)
			{
				$.each(itensPedidoEmpenho, function (keyE, valueE)
				{
					var isDuplicado = false;
					if (itensPedido.length > 0)
					{
						$.each(itensPedido, function (key, value)
						{		
							if (value.produto.procod == valueE.produto.procod)
							{
								isDuplicado = true;
							}
						});
					}
					
					if (!isDuplicado)
					{
						if (valueE.produto.procodigo == produto.procodigo)
						{
							isUpdate = true;
							itemPedidoEmpenho = valueE;
						}
					}
				});
			}
			
			if (isUpdate)
			{	
				if (itemPedidoEmpenho == undefined)
				{
					itemPedidoEmpenho = new Object();
				}
			}
			else
			{
				valorTotalItem = 0;
				qtdTotalItem = 0;
				valorTotalItemEmpenho = 0;
				qtdTotalItemEmpenho = 0;
				
				tabela = $("input[name='opcoesTabelaPadrao']:checked").val();
				
				itemPedido = new Object();
				itemPedido.pvicodigo = 0;
				itemPedido.pvitem = itensPedido.length + 1;
				itemPedido.produto = produto;
				itemPedido.pvipreco = Number(produto.tabelaValores[tabela]);
				itemPedido.pvisaldo = qtdTotalItem;
				itemPedido.pvicomis = 1;
				itemPedido.pvitippr = tabela;
				itemPedido.estoques = Array();
				itemPedido.pvidatacadastro = new Date();
				itemPedido.pvisituacao = true;
				
				itemPedidoEmpenho = new Object();
				itemPedidoEmpenho.pvicodigo = 0;
				itemPedidoEmpenho.pvitem = itensPedidoEmpenho.length + 1;
				itemPedidoEmpenho.produto = produto;
				itemPedidoEmpenho.pvipreco = Number(produto.tabelaValores[tabela]);
				itemPedidoEmpenho.pvisaldo = qtdTotalItemEmpenho;
				itemPedidoEmpenho.pvicomis = 1;
				itemPedidoEmpenho.pvitippr = tabela;
				itemPedidoEmpenho.estoques = Array();
				itemPedidoEmpenho.pvidatacadastro = new Date();
				itemPedidoEmpenho.pvisituacao = true;
			}
			getEstoques(itemPedido, itemPedidoEmpenho, pedido.tipoPedido);
		}
		else
		{
			$("#retorno").messageBox(msg,false,true);
		}
		
	});
});

