/**
 * @author Douglas
 *
 * CRUD - ações jquery para update para liberar pedidos.
 *
 * Criação    05/02/2010
 * Modificado 05/02/2010
 *

 */
$(function(){
	msgPvitem="";
	
	
	
	data = new Date();

	$('#tblAlteraNumero').hide();
	
	//alert($.mask.string(tmp, 'date'));
	
	$("#listaPesquisaPedidos").ajaxComplete(function(){
		if($('#formResultadoPedidos').validate().form())
		{
	
				data.date(pedido.pvemissao);
				tmp = data.format('d/m/Y');
				
			$('#dataEmissaoPedido').val(tmp);
			$('#tipoPedido').val(pedido.tipoPedido.descricao);
			$('#nomeGuerraCliente').val(pedido.cliente.clirazao);
			$('#codigoCliente').val(pedido.cliente.clicodigo);
			//$('#txtValorDocumento').val(pedido.pvvalor);
			$('#txtCondicoesComerciais').val(pedido.condicaoComercial.descricao);
			$('#txtNumeroDocumento').val(pedido.pvnumero);
			$('#clifat').val(pedido.cliente.clifat);
			$('#enderecoCliente').val(pedido.cliente.enderecoFaturamento.cleendereco);
			$('#cepEnderecoCliente').val(pedido.cliente.enderecoFaturamento.clecep);
			$('#codigoEnderecoCliente').val(pedido.cliente.enderecoFaturamento.clecodigo);
			$('#bairroEnderecoCliente').val(pedido.cliente.enderecoFaturamento.clebairro);
			$('#numeroEnderecoCliente').val(pedido.cliente.enderecoFaturamento.clenumero);
			$('#complementoEnderecoCliente').val(pedido.cliente.enderecoFaturamento.clecomplemento);
			$('#pvnumero').val(pedido.pvnumero);
			$('#clicodigo').val(pedido.cliente.clicodigo);
			$('#vencodigo').val(pedido.vencodigo);
			//$('#clifat').val(pedido.enderecoFaturamento.clecep);
			//$('#clifat').val(pedido.TotalItensEstoque);
		}
	});
	
	$("#btnLiberacaoPedido").click(function()
	{	
		$("#btnLiberacaoPedido").attr('disabled', 'disabled');
		
		if($('#formLiberacaoPedido').validate().form())
		{
				
			if(pedido.tipoPedido.sigla=='R'){
				
				msg = "<br> - PEDIDO RESERVA NÃO PODE SER LIBERADO";
				alert('PEDIDO RESERVA NÃO PODE SER LIBERADO');
				$("#retorno").messageBox(msg,false, false);
				$("#btnLiberacaoPedido").attr('disabled', 'disabled');
				return false;	
				
			}
			
				//limiteDisponivel = pedido.cliente.clilimite - pedido.cliente.vendasEmAberto.totalVendas;
				
				
				limit = pedido.cliente.clilimite;
				if(pedido.tipoPedido.sigla=='I' && pedido.pvvinculo!=null)
				 {
					 pedidoValor = (pedido.pvvalor-pedido.pvvaldesc);
				 }else{
					 $.each(pedido.itensPedido, function (key, value)
								{
						 if(value.pedidoVendaItemEstoque.pviest011 > '0')
						 {
							 limitvall = (pedido.pvvalor-pedido.pvvaldesc);
						 }else
						 {
							 limitvall = (pedido.calculoSt.notavalor);	
						 }
								});
					
				 }
				

				//limiteDisponivel = Number(pedido.cliente.clilimite) - (Number(pedido.cliente.vendasEmAberto.totalVendas)- Number(limitvall));
				
				var msg="";
				//msg +="NECESSARIO INFORMAR O(S) CAMPO(S) ABAIXO PARA LIBERAR PEDIDO:<br>";
				/*
				if(pedido.TotalItensEstoque==undefined || pedido.TotalItensPedidos==undefined)
				{
					msg += "<br> - PEDIDOS SEM ITENS OU ESTOQUE VAZIO";
					alert('PEDIDOS SEM ITENS OU ESTOQUE VAZIO');
					$("#retorno").messageBox(msg,false, false);
					return false;	
				}
				
				if(pedido.TotalItensEstoque != pedido.TotalItensPedidos)
				{
					 alert('PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR');
					 msg += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR";
					 $("#retorno").messageBox(msg,false, false);
					 return false;
				}*/
				msgPvitem = "";
				
		
				if(pedido.itensPedido==null || pedido.itensPedido==undefined || pedido.itensPedido=="")
				{
					msg += "<br> - PEDIDO COM PROBLEMA NOS ITENS FALE COM O ADMINISTRADOR";
					alert('PEDIDO COM PROBLEMA NOS ITENS FALE COM O ADMINISTRADOR ');
					$("#retorno").messageBox(msg,false, false);
					$("#btnLiberacaoPedido").attr('disabled', '');
					return false;
				}
				
				$.each(pedido.itensPedido, function (key, value)
				{
				
					var pviest01 = Number(value.pedidoVendaItemEstoque.pviest01);
					var pviest02 = Number(value.pedidoVendaItemEstoque.pviest02);
					var pviest03 = Number(value.pedidoVendaItemEstoque.pviest03);
					var pviest04 = Number(value.pedidoVendaItemEstoque.pviest04);
					var pviest05 = Number(value.pedidoVendaItemEstoque.pviest05);
					var pviest06 = Number(value.pedidoVendaItemEstoque.pviest06);
					var pviest07 = Number(value.pedidoVendaItemEstoque.pviest07);
					var pviest08 = Number(value.pedidoVendaItemEstoque.pviest08);
					var pviest09 = Number(value.pedidoVendaItemEstoque.pviest09);
					//var pviest10 = Number(value.pedidoVendaItemEstoque.pviest10);
					var pviest010 = Number(value.pedidoVendaItemEstoque.pviest010);
					var pviest011= Number(value.pedidoVendaItemEstoque.pviest011);
					var pviest012 = Number(value.pedidoVendaItemEstoque.pviest012);
					var pviest013 = Number(value.pedidoVendaItemEstoque.pviest013);
					var pviest014 = Number(value.pedidoVendaItemEstoque.pviest014);
					var pviest015 = Number(value.pedidoVendaItemEstoque.pviest015);
					var pviest016 = Number(value.pedidoVendaItemEstoque.pviest016);
					var pviest017 = Number(value.pedidoVendaItemEstoque.pviest017);
					var pviest018 = Number(value.pedidoVendaItemEstoque.pviest018);
					var pviest019 = Number(value.pedidoVendaItemEstoque.pviest019);
					var pviest020 = Number(value.pedidoVendaItemEstoque.pviest020);
					var pviest021 = Number(value.pedidoVendaItemEstoque.pviest021);
					var pviest022 = Number(value.pedidoVendaItemEstoque.pviest022);
					var pviest023 = Number(value.pedidoVendaItemEstoque.pviest023);
					var pviest024 = Number(value.pedidoVendaItemEstoque.pviest024);
					var pviest025 = Number(value.pedidoVendaItemEstoque.pviest025);
					var pviest026 = Number(value.pedidoVendaItemEstoque.pviest026);
					var pviest027 = Number(value.pedidoVendaItemEstoque.pviest027);
					var pviest028 = Number(value.pedidoVendaItemEstoque.pviest028);
					var pviest029 = Number(value.pedidoVendaItemEstoque.pviest029);
					var pviest030 = Number(value.pedidoVendaItemEstoque.pviest030);
					var pviest031 = Number(value.pedidoVendaItemEstoque.pviest031);
					var pviest032 = Number(value.pedidoVendaItemEstoque.pviest032);
					var pviest033 = Number(value.pedidoVendaItemEstoque.pviest033);
					var pviest034 = Number(value.pedidoVendaItemEstoque.pviest034);
					var pviest035 = Number(value.pedidoVendaItemEstoque.pviest035);
					var pviest036 = Number(value.pedidoVendaItemEstoque.pviest036);
					var pviest037 = Number(value.pedidoVendaItemEstoque.pviest037);
					var pviest038 = Number(value.pedidoVendaItemEstoque.pviest038);
					var pviest039 = Number(value.pedidoVendaItemEstoque.pviest039);
					var pviest040 = Number(value.pedidoVendaItemEstoque.pviest040);
					var pviest041 = Number(value.pedidoVendaItemEstoque.pviest041);
					var pviest042 = Number(value.pedidoVendaItemEstoque.pviest042);
					var pviest043 = Number(value.pedidoVendaItemEstoque.pviest043);
					var pviest044 = Number(value.pedidoVendaItemEstoque.pviest044);
					var pviest045 = Number(value.pedidoVendaItemEstoque.pviest045);
					var pviest046 = Number(value.pedidoVendaItemEstoque.pviest046);
					var pviest047 = Number(value.pedidoVendaItemEstoque.pviest047);
					var pviest048 = Number(value.pedidoVendaItemEstoque.pviest048);
					var pviest049 = Number(value.pedidoVendaItemEstoque.pviest049);
					var pviest050 = Number(value.pedidoVendaItemEstoque.pviest050);
					var pviest051 = Number(value.pedidoVendaItemEstoque.pviest051);
					var pviest052 = Number(value.pedidoVendaItemEstoque.pviest052);
					var pviest053 = Number(value.pedidoVendaItemEstoque.pviest053);
					var pviest054 = Number(value.pedidoVendaItemEstoque.pviest054);
					var pviest055 = Number(value.pedidoVendaItemEstoque.pviest055);
					var pviest056 = Number(value.pedidoVendaItemEstoque.pviest056);
					var pviest057 = Number(value.pedidoVendaItemEstoque.pviest057);
					var pviest058 = Number(value.pedidoVendaItemEstoque.pviest058);
					var pviest059 = Number(value.pedidoVendaItemEstoque.pviest059);
					var pviest060 = Number(value.pedidoVendaItemEstoque.pviest060);
					var pviest061 = Number(value.pedidoVendaItemEstoque.pviest061);
					var pviest062 = Number(value.pedidoVendaItemEstoque.pviest062);
					var pviest063 = Number(value.pedidoVendaItemEstoque.pviest063);
					var pviest064 = Number(value.pedidoVendaItemEstoque.pviest064);
					var pviest065 = Number(value.pedidoVendaItemEstoque.pviest065);
					var pviest066 = Number(value.pedidoVendaItemEstoque.pviest066);
					var pviest067 = Number(value.pedidoVendaItemEstoque.pviest067);
					var pviest068 = Number(value.pedidoVendaItemEstoque.pviest068);
					var pviest069 = Number(value.pedidoVendaItemEstoque.pviest069);
					var pviest070 = Number(value.pedidoVendaItemEstoque.pviest070);
					var pviest071 = Number(value.pedidoVendaItemEstoque.pviest071);
					var pviest072 = Number(value.pedidoVendaItemEstoque.pviest072);
					var pviest073 = Number(value.pedidoVendaItemEstoque.pviest073);
					var pviest074 = Number(value.pedidoVendaItemEstoque.pviest074);
					var pviest075 = Number(value.pedidoVendaItemEstoque.pviest075);
					var pviest076 = Number(value.pedidoVendaItemEstoque.pviest076);
					var pviest077 = Number(value.pedidoVendaItemEstoque.pviest077);
					var pviest078 = Number(value.pedidoVendaItemEstoque.pviest078);
					var pviest079 = Number(value.pedidoVendaItemEstoque.pviest079);
					var pviest080 = Number(value.pedidoVendaItemEstoque.pviest080);
					var pviest081 = Number(value.pedidoVendaItemEstoque.pviest081);
					var pviest082 = Number(value.pedidoVendaItemEstoque.pviest082);
					var pviest083 = Number(value.pedidoVendaItemEstoque.pviest083);
					var pviest084 = Number(value.pedidoVendaItemEstoque.pviest084);
					var pviest085 = Number(value.pedidoVendaItemEstoque.pviest085);
					var pviest086 = Number(value.pedidoVendaItemEstoque.pviest086);
					var pviest087 = Number(value.pedidoVendaItemEstoque.pviest087);
					var pviest088 = Number(value.pedidoVendaItemEstoque.pviest088);
					var pviest089 = Number(value.pedidoVendaItemEstoque.pviest089);
					var pviest090 = Number(value.pedidoVendaItemEstoque.pviest090);
					var pviest091 = Number(value.pedidoVendaItemEstoque.pviest091);
					var pviest092 = Number(value.pedidoVendaItemEstoque.pviest092);
					var pviest093 = Number(value.pedidoVendaItemEstoque.pviest093);
					var pviest094 = Number(value.pedidoVendaItemEstoque.pviest094);
					var pviest095 = Number(value.pedidoVendaItemEstoque.pviest095);
					var pviest096 = Number(value.pedidoVendaItemEstoque.pviest096);
					var pviest097 = Number(value.pedidoVendaItemEstoque.pviest097);
					var pviest098 = Number(value.pedidoVendaItemEstoque.pviest098);
					var pviest099 = Number(value.pedidoVendaItemEstoque.pviest099);
					var pviindustria = Number(value.pedidoVendaItemEstoque.pviindustria);

					var pvisaldo = Number(value.pedidoVendaItemEstoque.pvisaldo);
					var codigo = value.pedidoVendaItemEstoque.pvicodigo;
					var procodigo = value.pedidoVendaItemEstoque.procodigo;
					var preco = value.pedidoVendaItemEstoque.pvipreco;
					var descricao = value.produto.prnome;
					var procod = value.produto.procod;
					
					
					if(preco < 0.02 && preco >=0.01)
					{
						alert("FALHA NO PRECO DO PRODUTO, CODIGO PRODUTO: " + procod + " NOME: " + descricao + " PRECO: " + preco);
						msg += "<br> - FALHA NO PRECO DO PRODUTO,  CODIGO PRODUTO: " + procod + " NOME: " + descricao + " PRECO: " + preco;
						$("#retorno").messageBox(msg,false, false);
						//return false;
					}
					
					
					if(preco==0 || preco==0.00 || preco==null)
					{
						alert("PRODUTO COM PRECO ZERADO, CODIGO PRODUTO: " + procod + " NOME: " + descricao + " PRECO: " + preco);
						 msgPvitem += "<br> - PRODUTO COM PRECO ZERADO,  CODIGO PRODUTO: " + procod + " NOME: " + descricao + " PRECO: " + preco;
						$("#retorno").messageBox(msgPvitem,false, false);
						$("#btnLiberacaoPedido").attr('disabled', '');
						return false;
					}

									if(pviest01 != 0)
										{
												if(pviest01 != pvisaldo)
												{
														alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 01";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}

									if(pviest02 != 0)
										{
												if(pviest02 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 02";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}
										if(pviest03 != 0)
										{
												if(pviest03 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 03";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}

													if(pviest04 != 0)
										{
												if(pviest04 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 04";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}

													if(pviest05 != 0)
										{
												if(pviest05 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 05";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}


												if(pviest06 != 0)
										{
												if(pviest06 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 06";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}

													if(pviest07 != 0)
										{
												if(pviest07 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 07";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}

													if(pviest08 != 0)
										{
												if(pviest08 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 08";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}
												//	if(pviest09 != 0)
													if(pviest026 != 0)
										{
											//	if(pviest09 != pvisaldo)
												if(pviest026 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 09";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}

												/*	if(pviest10 != 0)
										{
												if(pviest10 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 10";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}*/

													if(pviest010 != 0)
										{
												if(pviest010 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 010";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}

													if(pviest011 != 0)
										{
												if(pviest011 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 011";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}

													if(pviest012 != 0)
										{
												if(pviest012 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 012";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}

																if(pviest013 != 0)
										{
												if(pviest013 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 013";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}

																if(pviest014 != 0)
										{
												if(pviest014 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 014";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}

																if(pviest015 != 0)
										{
												if(pviest015 != pvisaldo)
												{
														alert("CODIGO:  " +  codigo );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 015";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}

																if(pviest016 != 0)
										{
												if(pviest016 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 016";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}

																if(pviest017 != 0)
										{
												if(pviest017 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 017";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}

																if(pviest018 != 0)
										{
												if(pviest018 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 018";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}

																if(pviest019 != 0)
										{
												if(pviest019 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 019";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}

																if(pviest020 != 0)
										{
												if(pviest020 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 020";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}

																if(pviest021 != 0)
										{
												if(pviest021 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 021";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}

																if(pviest022 != 0)
										{
												if(pviest022 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 022";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}

																if(pviest023 != 0)
										{
												if(pviest023 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 023";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}

																if(pviest024 != 0)
										{
												if(pviest024 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 024";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}

										if(pviest025 != 0)
										{
												if(pviest025 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 025";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}

															if(pviest026 != 0)
										{
												if(pviest026 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 026";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}

															if(pviest027 != 0)
										{
												if(pviest027 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 027";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}
																		if(pviest028 != 0)
										{
												if(pviest028 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 028";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}
																		if(pviest029 != 0)
										{
												if(pviest029 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 029";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}
																		if(pviest030 != 0)
										{
												if(pviest030 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 030";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}
																		if(pviest031 != 0)
										{
												if(pviest031 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 031";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}
																		if(pviest032 != 0)
										{
												if(pviest032 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 032";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}								if(pviest033 != 0)
										{
												if(pviest033 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 033";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}
																		if(pviest034 != 0)
										{
												if(pviest034 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 034";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}

																		if(pviest035 != 0)
										{
												if(pviest035 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 035";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}
																		if(pviest036 != 0)
										{
												if(pviest036 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 036";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}
																		if(pviest037 != 0)
										{
												if(pviest037 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 037";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}
																		if(pviest038 != 0)
										{
												if(pviest038 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 038";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}
																		if(pviest039 != 0)
										{
												if(pviest039 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 039";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}
																		if(pviest040 != 0)
										{
												if(pviest040 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 040";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest041 != 0)
										{
												if(pviest041 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 041";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}
																		if(pviest042 != 0)
										{
												if(pviest042 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 042";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}
																		if(pviest043 != 0)
										{
												if(pviest043 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 043";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest044 != 0)
										{
												if(pviest044 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 044";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}
																		if(pviest045 != 0)
										{
												if(pviest045 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 045";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}
																		if(pviest046 != 0)
										{
												if(pviest046 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 046";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}

																		if(pviest047 != 0)
										{
												if(pviest047 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 047";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}
																		if(pviest048 != 0)
										{
												if(pviest048 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 048";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}
																		if(pviest049 != 0)
										{
												if(pviest049 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 049";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}
																		if(pviest050 != 0)
										{
												if(pviest050 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 050";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest051 != 0)
										{
												if(pviest051 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 051";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest052 != 0)
										{
												if(pviest052 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 052";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest053 != 0)
										{
												if(pviest053 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 053";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest054 != 0)
										{
												if(pviest054 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 054";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest055 != 0)
										{
												if(pviest055 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 055";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest056 != 0)
										{
												if(pviest056 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 056";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest057 != 0)
										{
												if(pviest057 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 057";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest058 != 0)
										{
												if(pviest058 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 058";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest059 != 0)
										{
												if(pviest059 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 059";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest060 != 0)
										{
												if(pviest060 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 060 ";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest061 != 0)
										{
												if(pviest061 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 061";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest062 != 0)
										{
												if(pviest062 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 062";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest063 != 0)
										{
												if(pviest063 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 063";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest064 != 0)
										{
												if(pviest064 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 064";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest065 != 0)
										{
												if(pviest065 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 065";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest066 != 0)
										{
												if(pviest066 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 066";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest067 != 0)
										{
												if(pviest067 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 067";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest068 != 0)
										{
												if(pviest068 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 068";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest069 != 0)
										{
												if(pviest069 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 069";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest070 != 0)
										{
												if(pviest070 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 070";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest071 != 0)
										{
												if(pviest071 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 071";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest072 != 0)
										{
												if(pviest072 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 072";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest073 != 0)
										{
												if(pviest073 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 073";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest074 != 0)
										{
												if(pviest074 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 074";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest075 != 0)
										{
												if(pviest075 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 075";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest076 != 0)
										{
												if(pviest076 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 076";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest077 != 0)
										{
												if(pviest077 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 077";
														$("#retorno").messageBox(msgPvitem,false, false);
														return false;
												}

										}								if(pviest078 != 0)
										{
												if(pviest078 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 078";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}								if(pviest079 != 0)
										{
												if(pviest079 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 079";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}								if(pviest080 != 0)
										{
												if(pviest080 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 080";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}								if(pviest081 != 0)
										{
												if(pviest081 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 081";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}					
										if(pviest082 != 0)
										{
												if(pviest082 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 082";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}	
										
										if(pviest083 != 0)
										{
												if(pviest083 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 083";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}	
										if(pviest084 != 0)
										{
												if(pviest084 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 084";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}								if(pviest085 != 0)
										{
												if(pviest085 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 085";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}								if(pviest086 != 0)
										{
												if(pviest086 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 086";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}								if(pviest087 != 0)
										{
												if(pviest087 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 087";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}								if(pviest088 != 0)
										{
												if(pviest088 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 088";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}								if(pviest089 != 0)
										{
												if(pviest089 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 089";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}								if(pviest090 != 0)
										{
												if(pviest090 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 090";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}								if(pviest091 != 0)
										{
												if(pviest091 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 091";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}								if(pviest092 != 0)
										{
												if(pviest092 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 092";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}								if(pviest093 != 0)
										{
												if(pviest093 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 093";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}
										if(pviest094 != 0)
										{
												if(pviest094 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 094";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}
										if(pviest095 != 0)
										{
												if(pviest095 != pvisaldo)
												{
														alert("CODIGO:  " +  codigo );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 095";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}
										if(pviest096 != 0)
										{
												if(pviest096 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 096";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}
										if(pviest097 != 0)
										{
												if(pviest097 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 097";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}
										if(pviest098 != 0)
										{
												if(pviest098 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 098";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}
										if(pviest099 != 0)
										{
												if(pviest099 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 099";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}
										if(pviindustria != 0)
										{
												if(pviindustria != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 098";
														$("#retorno").messageBox(msgPvitem,false, false);
														$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}
										
					
					
				});
				
				if(msgPvitem != "")
				{
					 msg += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR";
					$("#retorno").messageBox(msg,false, false);
					$("#btnLiberacaoPedido").attr('disabled', '');
					return false;	
					
				}
				/*
				msgEstoque = "";
				
				 if(pedido.tipoPedido.sigla!='I' && pedido.pvvinculo==null)
				 {
				$.each(pedido.itensPedido, function (key, value)
						{
					$.each(value.pedidoVendaItemEstoque, function (key, value2)
							{
				if(value2.pviest011 < 0)
				{
					msgEstoque += "Estoque".value2.pviecodigo;
					
				}
							});
						});
				if(msgEstoque!="")
				{
				msg += msgEstoque;
				alert(msg);
				$("#retorno").messageBox(msg,false, false);
				return false;
				}
				 }
			
				valorPrefechamento = 0;
				$.each(pedido.preFechamento, function (key, value)
						{
					if(value.fecforma=='101' || value.fecforma=='103')
					{
							valorPrefechamento += Number(value.fecvalor);
					}

						});
				
				if(valorPrefechamento >= pedido.cliente.clilimite)
				{
					msg += "<br> - PARCELAMENTO MAIOR QUE O LIMITE";
					alert('PARCELAMENTO MAIOR QUE O LIMITE');
					$("#retorno").messageBox(msg,false, false);
					return false;
				}*/
				
			if(pedido.pvlibera!=null && pedido.pvhora!=null)
			{
				msg += "<br> - ESTE PEDIDO JA FOI LIBERADO";
				alert('ESTE PEDIDO JA FOI LIBERADO');
				$("#retorno").messageBox(msg,false, false);
				$("#btnLiberacaoPedido").attr('disabled', '');
				return false;
				
			}
				//if(pedido.cliente.cliserasaexp < '2010-03-01')
				//{
				//	msg += "<br> - CLIENTE SÒ EFETUA COMPRA A VISTA OU NO CARTAO";
				//	alert('CLIENTE SÒ EFETUA COMPRA A VISTA OU NO CARTAO');
			    //}
			
			if(pedido.tipoPedido.sigla!='S')
				{
				if(pedido.tipoPedido.sigla!='Z')
					{
					if(pedido.tipoPedido.sigla!='M')
						{
						if(pedido.tipoPedido.sigla!='D')
							{
							if(pedido.tipoPedido.sigla!='F')
								{
								if(pedido.tipoPedido.sigla!='B')
									{
									if(pedido.tipoPedido.sigla!='X')
										{
										if(pedido.tipoPedido.sigla!='EP')
										{
			
			
				
				if(pedido.cliente.enderecoFaturamento.clenumero==undefined ||pedido.cliente.enderecoFaturamento.clenumero==null)
				{
					msg += "<br> - ENDERECO PREENCHIDO DE FORMA INCORRETA";
				    alert('ENDERECO PREENCHIDO DE FORMA INCORRETA');
				    $('#tblAlteraNumero').show();
					$("#retorno").messageBox(msg,false, false);
					return false;
				}
				
				
				if(pedido.cliente.enderecoFaturamento.clecep==undefined || pedido.cliente.enderecoFaturamento.clecep==null)
				{
					msg += "INFORME UM CEP VERDADEIRO";
				    alert('INFORME UM CEP VERDADEIRO');
				    $('#tblAlteraNumero').show();	
					$("#retorno").messageBox(msg,false, false);
					$("#btnLiberacaoPedido").attr('disabled', '');
					return false;
				}
				
				if(pedido.cliente.enderecoFaturamento.cidadeIbge.descricao==null ||pedido.cliente.enderecoFaturamento.cidadeIbge.descricao=="" ||pedido.cliente.enderecoFaturamento.cidadeIbge.descricao==undefined)
				{
					msg += "<br> - CIDADE IBGE NAO ESTA PREENCHIDA";
					alert('CIDADE IBGE NAO ESTA PREENCHIDA');
					$("#retorno").messageBox(msg,false, false);
					$("#btnLiberacaoPedido").attr('disabled', '');
					return false;
				}
				
				if(pedido.fecreserva!='1')
				{
				if(pedido.preFechamento==undefined || pedido.preFechamento==null)
				{
					msg += "<br> - NECESSARIO FAZER O PREFECHAMENTO";
					alert('NECESSARIO FAZER O PREFECHAMENTO');
					$("#retorno").messageBox(msg,false, false);
					$("#btnLiberacaoPedido").attr('disabled', '');
					return false;
				}
				}
				msgPreFec = "";
				
				if(pedido.tipoPedido.sigla!='R')
					{
					if(pedido.tipoPedido.sigla!='I')
						{
				
				$.each(pedido.preFechamento, function (key, value)
				{
				
				if((pedido.cliente.clilimite < pedido.cliente.vendasEmAberto.totalVendas) && value.fecforma=='101')
				{					
				msg += "<br> - FORMA DE PAGAMENTO SOMENTE PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO. NAO ACEITA DUPLICATA";
				alert('FORMA DE PAGAMENTO SOMENTE PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO. NAO ACEITA DUPLICATA');
				$("#retorno").messageBox(msg,false, false);
				msgPreFec +="FORMA SOMENTE PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO";
				return false;
				}
				if((pedido.cliente.clilimite < pedido.cliente.vendasEmAberto.totalVendas) && (value.fecforma=='103' || value.fecforma=='110'))
				{
				msg += "<br> - FORMA DE PAGAMENTO SOMENTE PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO. NAO ACEITA CHEQUE";
				alert('FORMA DE PAGAMENTO SOMENTE PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO. NAO ACEITA CHEQUE');
				$("#retorno").messageBox(msg,false, false);
				msgPreFec +="FORMA SOMENTE PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO";
				return false;
				}
				
				if((pedido.cliente.clilimite < '0'|| pedido.cliente.clilimite==null) && value.fecforma=='101')
				{
					msg += "<br> - FORMA DE PAGAMENTO A VISTA OU COM CARTAO OU ORDEM PAGTO. LIMITE ZERO. NAO ACEITA DUPLICATA";
					alert('FORMA DE PAGAMENTO A VISTA OU COM CARTAO OU ORDEM PAGTO. LIMITE ZERO. NAO ACEITA DUPLICATA');
					$("#retorno").messageBox(msg,false, false);
					msgPreFec +="FORMA SOMENTE PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO";
					return false;
				}
				
				if((pedido.cliente.clilimite<'0'|| pedido.cliente.clilimite==null) && (value.fecforma=='103' || value.fecforma=='110'))
				{
				msg += "<br> - FORMA DE PAGAMENTO SOMENTE PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO. LIMITE ZERO. NAO ACEITA CHEQUE";
				alert('FORMA DE PAGAMENTO SOMENTE PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO. LIMITE ZERO. NAO ACEITA CHEQUE');
				$("#retorno").messageBox(msg,false, false);
				msgPreFec +="FORMA SOMENTE PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO";
				return false;
				}
				if((pedido.cliente.clifat==1 || pedido.cliente.clifat==3) && (value.fecforma=='101'))
				{
					msg += "<br> - CLIENTE SO EFETUA COMPRA A VISTA OU NO CARTAO OU ORDEM PAGTO";
					alert('CLIENTE SO EFETUA COMPRA A VISTA OU NO CARTAO OU ORDEM PAGTO');
					$("#retorno").messageBox(msg,false, false);
					msgPreFec +="FORMA SOMENTE PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO";
					return false;
				}
				
				if((pedido.cliente.clifat==1 || pedido.cliente.clifat==3) && (value.fecforma=='103'))
				{
					msg += "<br> - CLIENTE SO EFETUA COMPRA A VISTA OU NO CARTAO OU ORDEM PAGTO";
					alert('CLIENTE SO EFETUA COMPRA A VISTA OU NO CARTAO OU ORDEM PAGTO');
					$("#retorno").messageBox(msg,false, false);
					msgPreFec +="FORMA SOMENTE PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO";
					return false;
				}
				
				if((pedido.cliente.clifat==1 || pedido.cliente.clifat==3) && (value.fecforma=='101' ||value.fecforma=='103'))
				{
					msg += "<br> - CLIENTE SO EFETUA COMPRA A VISTA OU NO CARTAO OU ORDEM PAGTO";
					alert('CLIENTE SO EFETUA COMPRA A VISTA OU NO CARTAO OU ORDEM PAGTO');
					$("#retorno").messageBox(msg,false, false);
					msgPreFec +="FORMA SOMENTE PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO";
					return false;
				}
				
						
				});
				}
					}
				
				if(msgPreFec!="")
				{
					msg += msgPreFec;
					alert(msg);
					$("#retorno").messageBox(msg,false, false);
					return false;
				}
				
				//alert (pedido.preFechamento.fecforma);
				//if((pedido.cliente.vendasEmAberto) > pedido.cliente.clilimite))
				//{
				//	msg += "<br> - LIMITE MENOR QUE O VALOR DA COMPRA. NAO ACEITA DUPLICATA";
				//	alert('FORMA DE PAGAMENTO A VISTA OU COM CARTAO OU ORDEM PAGTO');
				//	$("#retorno").messageBox(msg,false, false);
				//	return false;
				//}
				
				 if(pedido.tipoPedido.sigla=='I' && pedido.pvvinculo!=null)
				 {
					 valPedido = (pedido.pvvalor-pedido.pvvaldesc);	
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
			estoqueDestino = pedido.cliente.enderecoFaturamento.cidade.uf;
			
			
			if((estoqueOrigem=="SP" && estoqueDestino=="BA") || (estoqueOrigem=="SP" && estoqueDestino=="MG") || (estoqueOrigem=="SP" && estoqueDestino=="RS")
                        || (estoqueOrigem=="SP" && estoqueDestino=="PE"))
			{
				valPedido = (pedido.pvvalor-pedido.pvvaldesc) + pedido.calculoSt.substituicao;
			}else 
				if((estoqueOrigem=="SP" && estoqueDestino=="SC") || (estoqueOrigem=="SP" && estoqueDestino=="RJ"))
				{
					valPedido = (pedido.pvvalor-pedido.pvvaldesc);	
				}else
				if((estoqueOrigem=="ES" && estoqueDestino=="BA") || (estoqueOrigem=="ES" && estoqueDestino=="MG") || (estoqueOrigem=="ES" && estoqueDestino=="SC") || (estoqueOrigem=="ES" && estoqueDestino=="RJ") || (estoqueOrigem=="ES" && estoqueDestino=="RS"))
			{
					valPedido = (pedido.pvvalor-pedido.pvvaldesc);
			}else{
				valPedido = (pedido.pvvalor-pedido.pvvaldesc);
			}
			 }
			
				valPreFechamento = parseFloat(pedido.TotalValorPreFechamento);
				if(pedido.fecreserva!='1')
				{
				if(valPreFechamento.toFixed(2) != valPedido.toFixed(2))
				{
					msg += "<br> - VALOR DO PEDIDO NAO CONFERE COM O VALOR DO PREFECHAMENTO";
					alert('VALOR DO PEDIDO NAO CONFERE COM O VALOR DO PREFECHAMENTO');
					$("#retorno").messageBox(msg,false, false);
					$("#btnLiberacaoPedido").attr('disabled', '');
					return false;					
				}
				}
				
				if(pedido.tipoPedido.sigla!='R')
				{
				if(pedido.tipoPedido.sigla!='I')
					{
				if((pedido.cliente.clilimite < pedido.cliente.vendasEmAberto.totalVendas) && pedido.preFechamento.fecforma=='101')
				{
					msg += "<br> - LIMITE MENOR QUE O VALOR DA COMPRA. NAO ACEITA DUPLICATA";
					alert('FORMA DE PAGAMENTO A VISTA OU COM CARTAO OU ORDEM PAGTO');
					$("#retorno").messageBox(msg,false, false);
					$("#btnLiberacaoPedido").attr('disabled', '');
					return false;
				}
				if((pedido.cliente.clilimite < pedido.cliente.vendasEmAberto.totalVendas) && ( pedido.preFechamento.fecforma=='103' || pedido.preFechamento.fecforma=='110' ))
				{
					msg += "<br> - LIMITE MENOR QUE O VALOR DA COMPRA. NAO ACEITA CHEQUE";
					alert('FORMA DE PAGAMENTO A VISTA OU COM CARTAO OU ORDEM PAGTO');
					$("#retorno").messageBox(msg,false, false);
					$("#btnLiberacaoPedido").attr('disabled', '');
					return false;
				}
				
				if((pedido.cliente.clilimite<'0'|| pedido.cliente.clilimite==null) && pedido.preFechamento.fecforma=='101')
				{
					msg += "<br> - SEM LIMITE. NAO ACEITA DUPLICATA";
					alert('FORMA DE PAGAMENTO A VISTA OU COM CARTAO OU ORDEM PAGTO');
					$("#retorno").messageBox(msg,false, false);
					$("#btnLiberacaoPedido").attr('disabled', '');
					return false;
				}
				if((pedido.cliente.clilimite<'0'|| pedido.cliente.clilimite==null) && (pedido.preFechamento.fecforma=='103'|| pedido.preFechamento.fecforma=='110') )
				{
					msg += "<br> - SEM LIMITE. NAO ACEITA CHEQUE";
					alert('FORMA DE PAGAMENTO A VISTA OU COM CARTAO OU ORDEM PAGTO');
					$("#retorno").messageBox(msg,false, false);
					$("#btnLiberacaoPedido").attr('disabled', '');
					return false;
				}
			
				if((pedido.cliente.clifat==1 || pedido.cliente.clifat==3) && (pedido.preFechamento.fecforma=='101' ||pedido.preFechamento.fecforma=='103'))
				{
					msg += "<br> - CLIENTE SO EFETUA COMPRA A VISTA OU NO CARTAO OU ORDEM PAGTO";
					alert('CLIENTE SO EFETUA COMPRA A VISTA OU NO CARTAO OU ORDEM PAGTO');
					$("#retorno").messageBox(msg,false, false);
					$("#btnLiberacaoPedido").attr('disabled', '');
					return false;
				}
				}
				}
				
				$.each(pedido.itensPedido, function (key, value)
				{
				//alert(value.produto.grupo.grucodigo  + value.produto.grupo.grunome + pedido.cliente.clifat);
				if(pedido.cliente.clifat== 4 && value.produto.grupo.grucodigo == 6)
				{
					msg += "<br> - CLIENTE NAO PODE COMPRAR PRODUTOS MATTEL";
					alert('CLIENTE NAO PODE COMPRAR PRODUTOS MATTEL ');
					$("#retorno").messageBox(msg,false, false);
					$("#btnLiberacaoPedido").attr('disabled', '');
					return false;
				}
				});
				
				
				msgCodB = "";
				$.each(pedido.itensPedido, function (key, value)
				{
					//alert(value.produto.classificacaoFiscal.clanumero);
				if(value.produto.classificacaoFiscal.clanumero==0 || value.produto.classificacaoFiscal.clanumero=="")
				{
					msgCodB += "<br /> - PRODUTO SEM CLASSIFICACAO FISCAL"+ value.clacodigo;
					alert("PRODUTO SEM CLASSIFICACAO FISCAL" + value.produto.classificacaoFiscal.clacodigo);
					$("#retorno").messageBox(msgCodB,false, false);
					$("#btnLiberacaoPedido").attr('disabled', '');
					return false;
				}
				//alert(value.produto.codigoBarra.barunidade);
				if(value.produto.codigoBarra.barunidade==null || value.produto.codigoBarra.barunidade==0 || value.produto.codigoBarra.barunidade=="")
				{
					msgCodB += "<br /> - PRODUTO SEM CODIGO DE BARRA NA UNIDADE"+ value.produto.prnome;
					alert("PRODUTO SEM CODIGO DE BARRA NA UNIDADE" +  value.produto.prnome);
					$("#retorno").messageBox(msgCodB,false, false);
					$("#btnLiberacaoPedido").attr('disabled', '');
					return false;
				}
				//alert(value.produto.codigoBarra.barcaixa);
				//if(value.produto.codigoBarra.barcaixa==null || value.produto.codigoBarra.barcaixa==0 || value.produto.codigoBarra.barcaixa=="")
				//{
				//	msgCodB += "<br /> - PRODUTO SEM CODIGO DE BARRA NA CAIXA"+ value.produto.prnome;
				//	alert("PRODUTO SEM CODIGO DE BARRA NA CAIXA" +  value.produto.prnome);
				///	$("#retorno").messageBox(msgCodB,false, false);
				//	return false;
				//}
				});
				if(msgCodB != "")
				{
					msg += "<br> - PRODUTO SEM CODIGO DE BARRA";
					$("#retorno").messageBox(msg,false, false);
					$("#btnLiberacaoPedido").attr('disabled', '');
					return false;	
					
				}
				
				
				}
										}
									}
								}
							}
						}
					}
				}
				
		pedido2 = new Object();
		
		liberacao = new Array();
		
		pedido2.pvlibdep= null;
		pedido2.pvlibmat= null;
		pedido2.pvlibfil= null;
		pedido2.pvlibvit= null;
		
		if(pedido.tipoPedido.sigla=='S')
		{
			if(pedido.estoqueDestino.estoqueFisico.etqfcodigo==1)
			{
				pedido2.pvlibdep = 1;
			}
			else 
				if(pedido.estoqueDestino.estoqueFisico.etqfcodigo==2)
				{
					pedido2.pvlibmat = 1;
				}
				else
					if(pedido.estoqueDestino.estoqueFisico.etqfcodigo==3)
					{
						pedido2.pvlibfil = 1;
					}
					else
						if(pedido.estoqueDestino.estoqueFisico.etqfcodigo==4)
						{
							pedido2.pvlibvit = 1;
						}
		}
		else
			 if(pedido.tipoPedido.sigla=='I' && pedido.pvvinculo!=null)
			 {
//				 pedido2.pvlibdep = 1;
                                    pedido2.pvlibdep= pedido.pvlibdep;
                                    pedido2.pvlibmat= pedido.pvlibmat;
                                    pedido2.pvlibfil= pedido.pvlibfil;
                                    pedido2.pvlibvit= pedido.pvlibvit;
			 }else
		{
		
					$.each(pedido.itensPedido, function (key, value)
							{
							 if(value.pedidoVendaItemEstoque.pviest01 > '0')
							 {
								 pedido2.pvlibfil = 1;
							 }
							 if(value.pedidoVendaItemEstoque.pviest02 > '0')
							 {
								 pedido2.pvlibmat = 1;
							 }
						//	 if(value.pedidoVendaItemEstoque.pviest09 > '0')
							 if(value.pedidoVendaItemEstoque.pviest026 > '0')
							 {
								 pedido2.pvlibdep = 1;
							 }
							 if(value.pedidoVendaItemEstoque.pviest011 > '0')
							 {
								 pedido2.pvlibvit = 1;
							 }
							});
		}
		
		//declara variaveis recuperando valores
		pedido2.pvemissao =  new Date().dateBr($('#dataEmissaoPedido').val());
		pedido2.pvlibera =  new Date().dateBr($('#dataLiberacaoPedido').val());
		pedido2.pvhora = $('#horaLiberacaoPedido').val();
		pedido2.pvurgente = $("input[name='urgentePedido']:checked").val();
		pedido2.pvnumero = $('#txtNumeroDocumento').val();
		pedido2.usuario = usuario.codigo;
		
		loglibera =  new Object();
		loglibera.usucodigo = usuario.codigo;
		loglibera.clicodigo = pedido.cliente.clicodigo;
		loglibera.lglpedido = pedido.pvnumero;
		loglibera.lgltipo = pedido.tipoPedido.sigla; 
		loglibera.lgldata =  new Date().dateBr($('#dataLiberacaoPedido').val());
		loglibera.lglhora = $('#horaLiberacaoPedido').val();
		
		//Envia os dados via metodo post
   		$.post('modulos/vendaAtacado/pedidos/liberacao/controller/acoes.php',
   				{
   				pedido2:JSON.stringify(pedido2),
   				loglibera:JSON.stringify(loglibera),
   				acao:2
   				},
   				function(data)
   				{
   				if (Boolean(Number(data.retorno)))
   				{
   					
   					if(data.erro==true && data.codigo=='424')
   					{
   					alert(data.retorno);
   					$("#retorno").messageBox(data.mensagem,data.retorno,true);
   					$("#btnLiberacaoPedido").attr('disabled', '');
   					}else{
   						alert('');
   						$('#retornoInterfix').attr('title','Consulta Interfix');
   						$('#retornoInterfix').html(html);
   						
   						$('#retornoInterfix').dialog(
   								{
   									autoOpen: true,
   									modal: true,
   									width: 600,
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
   						
   				}
   				else
   				{
   					if(data.codigo!='424' )
   					{
   					alert(data.mensagem);
   					$("#retorno").messageBox(data.mensagem,data.retorno,true);
   					
   					$("#btnLiberacaoPedido").attr('disabled', '');
   					}else{
   			
alert("1919 mantencao.liberaPedido.js ERRO 424 ");
   						var html = '<h5>OBS.: RESULTADO DETALHADO DO ERRO 424. ';
   						valiii = data.erro.valores;
   						rows = valiii.length;
   						rowsF = (rows/4);
   						html +='<br /><table border="1"><tr><td> COD. PRODUTO </td><td> TABELA  </td><td> PRECO DIGITADO</td><td> PRECO TABELA </td></tr>';
   						for(i=0; i<rowsF;i++)
   								{
   							
   							html +='<tr><td>'+data.erro.valores[rows=rows-1]+'</td><td>'+data.erro.valores[rows=rows-1]+'</td><td>'+Number(data.erro.valores[rows=rows-1]).toFixed(2)+'</td><td>'+ Number(data.erro.valores[rows=rows-1]).toFixed(2)+'</td></tr>';
   							
   								}
   						html +='</table>'+
   						'\n <br /><br />'+
   						'\n DIGITE SUA SENHA PARA LIBERAR O ERRO 424: <input type="password" name="erroFourTwoFour" id="erroFourTwoFour" size"6"> ';
   						
   						
   						
   						$('#retornoLiberacao').attr('title','ATENCAO DIVERGENCIA DE PRECO: ERRO 424');
   						$('#retornoLiberacao').html(html);
   						
   						$('#retornoLiberacao').dialog(
   								{
   									autoOpen: true,
   									modal: true,
   									width: 600,
   									buttons: 
   									{
   										"OK": function() 
   										{
   									
   													
   									
   									
   									pedido2.pvlocal = data.erro.arquivo;
   									pedido2.usuario = usuario.nome;
   									pedido2.pvimpresso = $("#erroFourTwoFour").val();
   									pedido2.pvusulib = usuario.senha;
   									
   								   									
   									$.post('modulos/vendaAtacado/pedidos/liberacao/controller/acoes.php',
   							   				{
   							   				pedido2:JSON.stringify(pedido2),
                                                                                        loglibera:JSON.stringify(loglibera),
   							   				acao:4
   							   				
   							   				},
   							   				function(data)
   							   				{
   							   					
   							   					
   							   					
   							   					if (Boolean(data))
   							   					{
   							   						retorno = data;
   							   						alert(retorno.mensagem);
   							   					$(this).dialog("destroy");
   							   						
   							   				    }
   							   					else
   							   					{
   							   						retorno = data;
   							   					alert(retorno.mensagem);
   							   					$(this).dialog("destroy");
   							   							
   								   						
   							   					}
   							   					$.unblockUI();
   							   				}, "json");
   									$(this).dialog("close");
   									
   										}
   								
   									},
   									close: function(ev, ui)
   									{
   										$(this).dialog("destroy");
   									}
   								});
   					}
   				
   				}
   				$.unblockUI();
   				}, "json");
		
		}
		
	});

});