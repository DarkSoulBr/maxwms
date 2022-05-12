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

$(function(){




	//localizar pedidos
	$("#btnPesquisaPedidos").click(function()
	{
		if($('#formPesquisaPedidos').validate().form())
		{
			var titulo = "Pesquisando Aguarde!";
			var mensagem = "Processando pesquisa, aguarde conclusão!";
			$('#divPesquisaPedido').messageBoxElement(titulo, mensagem);

			var pesquisa = new Object();
			//declara variaveis recuperando valores
			pesquisa.tipoPesquisa = $("input[name='opcoesTipoPesquisaPedidos']:checked").val();
			pesquisa.formaPesquisa = $("input[name='opcoesFormaPesquisaPedidos']:checked").val();
			pesquisa.txtPesquisa = $('#txtPesquisaPedidos').val();
			var acao = 25;

			//Envia os dados via metodo post
	   		$.post('modulos/vendaAtacado/pedidos/manutencao/controller/acoes.php',
			{
				//variaveis a ser enviadas metodo POST
				tipoPesquisa:pesquisa.tipoPesquisa,
				formaPesquisa:pesquisa.formaPesquisa,
				txtPesquisa:pesquisa.txtPesquisa,
				acao:acao
			},
			function(data)
			{
				if (Boolean(Number(data.retorno)))
                {
					$("#retorno").messageBox(data.mensagem,data.retorno,true);

					pedidos = data.pedidos;
					pedido = new Object();

					var opcoes = '';
					$.each(pedidos, function (key, value)
					{
						var pvemissao = value.pvemissao;

								if ( value.cliente.devolucaoVales != null) {
									count = 0;
                                                                        codVales = "";
									$.each(value.cliente.devolucaoVales, function (key2, value2) {
																codVales += "\n                                         " + value2.vale;
																count++;
																		  });
									   if (count > 1) {
																msg = "ATENÇÃO - CLIENTE POSSUE OS VALES: ";

                                                              } else {
                                                                  msg = "ATENÇÃO - CLIENTE POSSUE O VALE: ";
                                                              }
                                                                alert( msg + codVales );
								}

						if (value.tipoPedido.codigo == ABASTECIMENTO)
						{
							var option = '<option value="' + value.pvnumero + '">' + value.pvnumero + ' - '+ value.estoqueOrigem.etqnome + ' >> '+ value.estoqueDestino.etqnome + '</option>';
						}
						else
						if (value.tipoPedido.codigo == DEVOLUCAO)
						{
							var option = '<option value="' + value.pvnumero + '">' + value.pvnumero + ' - '+ value.fornecedor.forrazao + '</option>';
						}
						else
						{
							var option = '<option value="' + value.pvnumero + '">' + value.cliente.clicod + ' - '+ value.cliente.clirazao + '</option>';
						}

						if (!opcoes)
						{
							opcoes = option;

							pedido = value;
						}
						else
						{
							opcoes += option;
						}
					});

					$("#listaPesquisaPedidos").html(opcoes);
					$("#listaPesquisaPedidos").attr('disabled',false);
                }
                else
                {
                	$("#retorno").messageBox(data.mensagem,data.retorno,false);
                }
				$("#divPesquisaPedido").unblock();
			}, "json");
		}
	});

	$('#listaPesquisaPedidos').change(function(){
		pedido = pedidos[$(this).val()];
	});

	$('#dataEmissaoPedidos').change(function(){
		pedido = pedidos[$(this).val()];
	});

	if($('#txtPesquisaPedidos').val())
	{
		$("#btnPesquisaPedidos").trigger('click');
	}
 });