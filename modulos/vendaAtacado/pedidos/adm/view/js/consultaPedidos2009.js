/**
 * @author Wellington
 *
 * Verificação dos dados para envio de formulario.
 *
 * Criação    18/05/2010
 *
 */

//var GB_ANIMATION = true;

$(function()
{
	$("#btnConsultaPedidos").click(function()
	{
		if ($("#formEstoqueFisico").validate().form())
		{
			var dataInicio = new Date().dateBr(($('#dataInicio').val()));
			var horaInicio = $('#horaInicio').val();
			var dataFim = new Date().dateBr(($('#dataFim').val()));
			var horaFim = $('#horaFim').val();

			titulo = "PROCESSANDO, AGUARDE...";
			mensagem = "EXECUTANDO PESQUISA DE ESTACIONAMENTO.";

			$("#retorno").messageBoxModal(titulo, mensagem);

			dataInicio.setTimes(horaInicio);
			dataFim.setTimes(horaFim);

			var aTipo = new Array();
			$('#listaTipoPedidos option:selected').each(function()
			{
				if($(this).val())
				{
					aTipo.push(tiposPedido[$(this).val()].sigla);
				}
			});

			var aEstoque = new Array();
			$('#listaEstoqueFisico option:selected').each(function()
			{
				if($(this).val())
				{
					aEstoque.push(estoquesFisico[$(this).val()].etqfcodigo);
				}
			});

			$.post('modulos/vendaAtacado/pedidos/adm/controller/getEstacionamento.php',
			{
				//variaveis a ser enviadas metodo POST
				dataInicio:dataInicio.format("Y-m-d H:i:s"),
				dataFim:dataFim.format("Y-m-d H:i:s"),
				aTipo:JSON.stringify(aTipo),
				aEstoque:JSON.stringify(aEstoque),
				acao:1
			},
			function(data)
			{
				if (Boolean(Number(data.retorno)))
				{
					var dataAtual = new Date();
					var numLinha = 0;

					var codHtml = "<table id='listaEstoques' border='0' cellpadding='0' cellspacing='0'>"+
						"<tbody>";
					resultado = data.aEstacionamento;
					$.each(data.aEstacionamento, function (key, value)
					{
						var cidade = "";
						var uf = "";
						var cor = "#77DD98";
						var status = "AUTORIZADO";
						var tipoStatus = 1;

						var dataSerasaExp = value.cliente.cliserasaexp ? new Date().date(value.cliente.cliserasaexp) : '';
						var dataSintegraExp = value.cliente.clisintegra ? new Date().date(value.cliente.clisintegra) : '';

						var txtDataSerasa = '';
						var txtDataSintegra = '';

						var situacao = '<a href="'+HTTP_ROOT+'dtrade.php?flagmenu=9&pgcodigo=11&popup=1&pvnumero='+value.pvnumero+'" title="LIBERACAO" tooltip="CLIQUE PARA REALIZAR LIBERAÇÃO DO PEDIDO" id="'+value.pvnumero+'" class="greybox" name="liberacao">LIBERAR</a>';
						var liberarFinanceiro = '<a href="javascript:;" title="ALTERAR SITUACAO" tooltip="CLIQUE PARA ALTERAR SITUACAO DO PEDIDO." id="'+value.pvnumero+'" name="financeiro">FINANCEIRO</a>';

						var manutencaoPedido = '<a href="'+HTTP_ROOT+'dtrade.php?flagmenu=9&pgcodigo=5&popup=1&pvnumero='+value.pvnumero+'" title="MANUTENCAO" tooltip="CLIQUE PARA EFETUAR MANUTEÇÃO DO PEDIDO" class="greybox" id="'+value.pvnumero+'" name="manutencao">EDITAR</a> - <a href="'+HTTP_ROOT+'alterarpvendasimples.php?flagmenu=9&pgcodigo=16&pvnumero='+value.pvnumero+'&popup=1" title="MANUTENCAO" tooltip="CLIQUE PARA EFETUAR ALTERAÇÃO SIMPLES DO PEDIDO" class="greybox" id="'+value.pvnumero+'" name="manutencao">SIMPLES</a>';
						var consultaPedido = '<a href="'+HTTP_ROOT+'pedvendacons2.php?flagmenu=9&popup=1&codped='+value.pvnumero+'" title="CONSULTA PEDIDO" tooltip="CLIQUE PARA REALIZAR CONSULTAR PEDIDO." class="greybox" id="'+value.pvnumero+'" name="consulta">'+value.pvnumero+'</a>';
						var analiseCredido = '<a href="'+HTTP_ROOT+'analisecredclientessimples.php?popup=1&clicod='+value.cliente.clicod+'" title="ANALISE DE CREDITO" tooltip="CLIQUE PARA VISUALIZAR ANALISE DE CREDITO DO CLIENTE." class="greybox" id="'+value.cliente.clicod+'" name="analiseCredito">ANALISE CREDITO</a>';
						var manutencaoCredito = '<a href="'+HTTP_ROOT+'dtrade.php?flagmenu=9&pgcodigo=6&popup=1&clicod='+value.cliente.clicod+'" title="MANUTENCAO DE CREDITO" tooltip="CLIQUE PARA EFETUAR MANUTEÇÃO DE CREDITO DO CLIENTE." class="greybox" id="'+value.cliente.clicod+'" name="manutencaoCredito">'+$.mask.string(Number(value.cliente.clilimite).toFixed(2), 'decimal')+'</a>';
						//var atualizaInterfix = '<a href="'+HTTP_ROOT+'dtrade.php?flagmenu=9&pgcodigo=19&popup=1&clicod='+value.cliente.clicod+'" title="FINANCEIRO INTERFIX" tooltip="CLIQUE PARA ATUALIZAÇÃO FINANCEIRO INTERFIX." class="greybox" id="'+value.cliente.clicod+'" name="interfix">ATUALIZAR</a>';
						var atualizaInterfix = '<a href="'+HTTP_ROOT+'dtrade.php?flagmenu=9&pgcodigo=6&popup=1&clicod='+value.cliente.clicod+'" title="MANUTENCAO DE CREDITO" tooltip="CLIQUE PARA EFETUAR MANUTEÇÃO DE CREDITO DO CLIENTE." class="greybox" id="'+value.cliente.clicod+'" name="manutencaoCredito">ATUALIZAR</a>';

						var limiteDisponivel = Number(value.cliente.clilimite) - (Number(value.cliente.vendasEmAberto.totalVendas)-Number(value.pvvalor));
						var totalLiquido = Number(value.pvvalor) - Number(value.pvvaldesc);
						var dataEmissao = new Date().date(value.pvemissao);

						if (value.cliente.enderecoFaturamento)
						{
							uf = value.cliente.enderecoFaturamento.cidade.uf;
							cidade= value.cliente.enderecoFaturamento.cidade.descricao;
						}

						if(value.condicaoComercial.codigo != 1)
						{

							if (Number(value.pvencer) == 3)
							{
								cor = '#FFFFBB';
								status = 'EM ANALISE';
								situacao = liberarFinanceiro;
								tipoStatus = 2;
							}else
								if(Number(value.pvencer) == 3 && Number(value.pvvalor) < limiteDisponivel && dataAtual.getMonthsBetween(dataSerasaExp) > 0)
								{
									cor = '#FFFFBB';
									status = 'LIBERADO';
									situacao = liberarFinanceiro;
									tipoStatus = 2;
								}
							else
							{
								if (Number(value.cliente.clifat) == 3)
								{
									cor = '#FA5050';
									status = 'PROIBIDO';
									situacao = '';
									tipoStatus = 0;
								}
								else
								{

									if (!dataSerasaExp)
									{
										cor = '#FFFFBB';
										status = atualizaInterfix;
										situacao = liberarFinanceiro;
										tipoStatus = 1;
									}
									else
									{
										//dataSintegraExp.addMonths(1);

										txtDataSerasa = dataSerasaExp ? dataSerasaExp.format("d/m/Y") : '';
										//txtDataSintegra = dataSintegraExp ? dataSintegraExp.format("d/m/Y") : '';

										if (Number(value.pvvalor) > limiteDisponivel)
										{
											cor = '#FFFFBB';
											status = 'LIMITE EXCEDIDO';
											situacao = liberarFinanceiro;
											tipoStatus = 1;
										}

										if (dataAtual.getMonthsBetween(dataSerasaExp) < 0)
										{
											cor = '#FFFFBB';
											status = atualizaInterfix;
											situacao = liberarFinanceiro;
											tipoStatus = 0;

											txtDataSerasa = '<a href="javascript:;" tooltip="DATA DA ATUALIZAÇÃO DO FINANCEIRO INTERFIX EXPIRADA!\n CLIQUE EM ATUALIZAR."><font color="red"><b>'+dataSerasaExp.format("d/m/Y")+'<b></font></a>';
										}

										/*
										if (dataAtual.getMonthsBetween(dataSintegraExp) < 0)
										{
											cor = '#FFFFBB';
											status = atualizaInterfix;
											situacao = liberarFinanceiro;
											tipoStatus = 1;

											txtDataSintegra = '<a href="javascript:;" tooltip="DATA DA ATUALIZAÇÃO DO FINANCEIRO INTERFIX EXPIRADA!\n CLIQUE EM ATUALIZAR."><font color="red"><b>'+dataSintegraExp.format("d/m/Y")+'<b></font></a>';
										}
										*/
									}


									/*
									if (!dataSerasaExp || !dataSintegraExp)
									{
										cor = '#FFFFBB';
										status = atualizaInterfix;
										situacao = liberarFinanceiro;
										tipoStatus = 1;
									}
									else
									{
										dataSintegraExp.addMonths(1);

										txtDataSerasa = dataSerasaExp ? dataSerasaExp.format("d/m/Y") : '';
										txtDataSintegra = dataSintegraExp ? dataSintegraExp.format("d/m/Y") : '';

										if (Number(value.pvvalor) > limiteDisponivel)
										{
											cor = '#FFFFBB';
											status = 'LIMITE EXCEDIDO';
											situacao = liberarFinanceiro;
											tipoStatus = 1;
										}

										if (dataAtual.getMonthsBetween(dataSerasaExp) < 0)
										{
											cor = '#FFFFBB';
											status = atualizaInterfix;
											situacao = liberarFinanceiro;
											tipoStatus = 1;

											txtDataSerasa = '<a href="javascript:;" tooltip="DATA DA ATUALIZAÇÃO DO FINANCEIRO INTERFIX EXPIRADA!\n CLIQUE EM ATUALIZAR."><font color="red"><b>'+dataSerasaExp.format("d/m/Y")+'<b></font></a>';
										}

										if (dataAtual.getMonthsBetween(dataSintegraExp) < 0)
										{
											cor = '#FFFFBB';
											status = atualizaInterfix;
											situacao = liberarFinanceiro;
											tipoStatus = 1;

											txtDataSintegra = '<a href="javascript:;" tooltip="DATA DA ATUALIZAÇÃO DO FINANCEIRO INTERFIX EXPIRADA!\n CLIQUE EM ATUALIZAR."><font color="red"><b>'+dataSintegraExp.format("d/m/Y")+'<b></font></a>';
										}
									}*/
								}
							}
						}

						var isPrint = false;
						if(usuario.nivel == "2")
						{
							if(tipoStatus == 2 || tipoStatus == 0)
							{
								isPrint = true;
							}
						}
						else
						{
							if(tipoStatus == 1 || tipoStatus == 0)
							{
								isPrint = true;
							}
						}

						if(isPrint)
						{
							codHtml += "<tr style='background: "+cor+";' id="+value.pvnumero+">" +
								"<td>"+(++numLinha)+"</td>"+
								"<td>"+value.tipoPedido.sigla+"</td>"+
								"<td><span id='dvConsultaPedido"+value.pvnumero+"'>"+consultaPedido+"</span></td>" +
								"<td><a href='"+HTTP_ROOT+"clientescons.php?popup=1&pvnumero="+value.pvnumero+"&clicod="+value.cliente.clicod+"' title='CONSULTA CLIENTE' tooltip='CLIQUE PARA EFETUAR CONSULTA CLIENTE' class='greybox' id='"+value.cliente.clicod+"' name='cliente'>"+value.cliente.clicod+"</a></td>" +
								"<td><a href='"+HTTP_ROOT+"clientescons.php?popup=1&pvnumero="+value.pvnumero+"&clicod="+value.cliente.clicod+"' title='CONSULTA CLIENTE' tooltip='CLIQUE PARA EFETUAR CONSULTA CLIENTE' class='greybox' id='"+value.cliente.clicod+"' name='cliente'>"+value.cliente.clirazao+"</a></td>" +
								"<td>";
							codHtml += value.cliente.climodo == 2 ? "FIDELIDADE" : "NORMAL";
							codHtml += "</td> <td>";
							codHtml += value.tipolocal == 1 ? "CD" : "VIX";
							codHtml += "</td>"+
								"<td><span id='dvSituacao"+value.pvnumero+"'>"+situacao+"</span></td>" +
								"<td><span id='dvManutencao"+value.pvnumero+"'>"+manutencaoPedido+"</span></td>" +
								"<td>"+cidade+"</td>"+
								"<td>"+uf+"</td>" +
								"<td>"+value.vendedor.vencodigo+" "+value.vendedor.vennguerra+"</td>" +
								"<td>";
							codHtml += dataEmissao.format("d/m/Y H:i:s");
							codHtml +="</td>" +
								"<td>"+$.mask.string(Number(value.totalMattel).toFixed(2), 'decimal')+"</td>" +
								"<td>"+$.mask.string(Number(value.totalBarao).toFixed(2), 'decimal')+"</td>" +
								"<td>"+$.mask.string(Number(value.pvvalor).toFixed(2), 'decimal')+"</td>" +
								"<td>"+$.mask.string(Number(value.pvperdesc).toFixed(2), 'decimal')+"</td>" +
								"<td>"+$.mask.string(Number(value.pvvaldesc).toFixed(2), 'decimal')+"</td>" +
								"<td>"+$.mask.string(Number(totalLiquido).toFixed(2), 'decimal')+"</td>" +
								"<td>"+value.condicaoComercial.descricao+"</td>" +
								"<td>";
							codHtml += value.pvtipofrete == 1 ? 'CIF' : 'FOB';
							codHtml +="</td>"+
								"<td>"+value.transportadora.tranguerra+"</td>" +
								"<td><span id='dvAnaliseCredito"+value.pvnumero+"'>"+analiseCredido+"</span></td>" +
								"<td><span id='dvLimite"+value.pvnumero+"'>"+manutencaoCredito+"</span></td>" +
								"<td>";

							codHtml +=  txtDataSerasa;
							codHtml +="</td>" +
								"<td>";
							codHtml += txtDataSintegra;
							codHtml +="</td>" +
								"<td>";
							codHtml += txtDataSintegra;
							codHtml +="</td>" +
								"<td><span id='dvStatus"+value.pvnumero+"'>"+status+"</span></td>" +
							"</tr>";
						}
					});

					codHtml += 	"</tbody></table>";

					$('#tblResultado').html(codHtml);
					$("#accordion").accordion( "activate" , 1);

					width = (screen.width - (((screen.width * 5)/100)*2));

					$("#tblResultado").flexigrid(
					{
						width: width,
						height:400,
						striped:false,
						colModel : [
						            {display: '', name : 'canal', width : 40, align: 'center'},
									{display: 'CANAL', name : 'canal', width : 40, align: 'center'},
									{display: 'PEDIDO', name : 'pedido', width : 50, align: 'center'},
									{display: 'COD.CLI.', name : 'cod_cliente', width : 60, align: 'center'},
									{display: 'RAZAO SOCIAL', name : 'razao_social', width : 250, align: 'left'},
									{display: 'CLIENTE', name : 'tipo_cliente', width : 100, align: 'center'},
									{display: 'LOCAL', name : 'local', width : 40, align: 'center'},
									{display: 'SITUACAO', name : 'situacao', width : 90, align: 'center'},
									{display: 'MANUTENCAO', name : 'manutencao', width : 90, align: 'center'},
									{display: 'CIDADE', name : 'cidade', width : 150, align: 'center'},
									{display: 'UF', name : 'estado', width : 30, align: 'center'},
									{display: 'COD/VEND.', name : 'vendedor', width : 130, align: 'center'},
									{display: 'EMISSAO/HORA', name : 'data_emissao', width : 150, align: 'center'},
									{display: 'MATTEL', name : 'valor_mattel', width : 100, align: 'center'},
									{display: 'BARAO', name : 'valor_barao', width : 100, align: 'center'},
									{display: 'TOTAL', name : 'total', width : 100, align: 'center'},
									{display: 'DESC.%', name : 'desconto_percentual', width : 50, align: 'center'},
									{display: 'DESC.$', name : 'desconto_valor', width : 100, align: 'center'},
									{display: 'TOTAL LIQ.', name : 'total_liquido', width : 100, align: 'center'},
									{display: 'COND. COM.', name : 'condicao_com', width : 100, align: 'center'},
									{display: 'FRETE', name : 'tipo_frete', width : 50, align: 'center'},
									{display: 'TRANSP.', name : 'transportadora', width : 200, align: 'center'},
									{display: 'ANALISE CREDITO', name : 'manutencao', width : 120, align: 'center'},
									{display: 'LIMITE', name : 'limite_cliente', width : 100, align: 'center'},
									{display: 'SERASA', name : 'serasa', width : 100, align: 'center'},
									{display: 'SINTEGRA', name : 'sintegra', width : 100, align: 'center'},
									{display: 'RECEITA', name : 'receita', width : 100, align: 'center'},
									{display: 'STATUS FINANC', name : 'status', width : 120, align: 'center'}
									]
					});

					$('a[name=financeiro]').click(function()
					{
						var id = $(this).attr("id");

						$('#dialog').attr('title','SITUACAO PEDIDO');

						var mensagem = "DESEJA ALTERAR A SITUACAO DO PEDIDO PARA...";

						var html = '<p>'+
						'<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>'+
						mensagem+
						'</p><form id="formSituacao" name="formSituacao" method="post" action="#">';

						if(usuario.nivel == "2")
						{
							html += '<input align="middle" type="radio" checked="checked" value="4" id="pendentes" name="opcoesSituacao">PENDENTE'+
							'<input align="middle" type="radio" value="5" id="negado" name="opcoesSituacao">NEGADO';
						}
						else
						{
							html += '<input align="middle" type="radio" checked="checked" value="3" id="liberarFinanceiro" name="opcoesSituacao">LIBERAR FINANCEIRO';
						}


						//html += '<textarea name="txtObsSituacao" id="txtObsSituacao" cols="70" rows="3"></textarea>'+
						//html += '</form><h5>OBS.: INFORME O MOTIVO DA ALTERACAO DA SITUACAO DO PEDIDO.<h5>';

						$('#dialog').html(html);

						$('#dialog').dialog(
						{
							autoOpen: true,
							modal: true,
							width: 480,
							buttons:
							{
								"Alterar": function()
								{
							/*
									if($("#formSituacao").validate(
										{
											rules:{txtObsSituacao:{required: true}},
											messages:{txtObsSituacao:{required: "Obrigatório o preenchimento do campo observação."}}
										}).form())*/
									{
										$.post('modulos/vendaAtacado/pedidos/adm/controller/alteraSituacao.php',
										{
											//variaveis a ser enviadas metodo POST
											pvnumero:id,
											situacao:$("input[name='opcoesSituacao']:checked").val()
											//observacao:$("#txtObsSituacao").val()
										},
										function(data)
										{
											if (Boolean(data.retorno))
											{
												if($("input[name='opcoesSituacao']:checked").val() == 3)
												{
													$("#"+id).hide();
												}
												else if($("input[name='opcoesSituacao']:checked").val() == 4)
												{
													$("#"+id).attr("style", "background: #CCCCCC");
													$("#dvStatus"+id).html("PENDENTE");
													$("#dvManutencao"+id).show();
												}
												else if($("input[name='opcoesSituacao']:checked").val() == 5)
												{
													$("#"+id).attr("style", "background: #FA5050");
													$("#dvStatus"+id).html("NEGADO");
													$("#dvManutencao"+id).hide();
												}

												$('#dialog').dialog("close");
											}
											else
											{
												$('#dialog').dialog("close");
												alerta("SITUACAO PEDIDO", "NAO FOI POSSIVEL ALTERAR SITUACAO DO PEDIDO.");
											}
										},'json');
									}
								},
								"Cancelar": function()
								{
									$(this).dialog("close");
								}
							},
							close: function(ev, ui)
							{
								$(this).dialog("destroy");
							}
						});
					});

					$('#divResultado a[tooltip]').each(function()
					{
						$(this).qtip(
						{
							content: $(this).attr('tooltip'),
							position:
							{
								corner:
								{
									target: 'topMiddle',
									tooltip: 'bottomMiddle'
		                  		}
							},
							style:
							{
								border:
								{
									width: 1,
									radius: 10
								},
								padding: 5,
								textAlign: 'left',
								tip: true,
								name: 'dark'
							}
						});
					});
				}
				else
				{
					alert(data.mensagem);
				}

				$.unblockUI();

				$("a.greybox").click(function()
				{
					var t = $(this).attr("title") || $(this).attr("text") || $(this).attr("href");
				    var href = $(this).attr("href");
				    var tipo = $(this).attr("name");
				    var id = $(this).attr("id");

					var callback = function()
					{
						var usucodigo = null;

						if (tipo == "manutencao" || tipo == "liberacao")
						{
							//Envia os dados via metodo post
							$.post('modulos/vendaAtacado/pedidos/manutencao/controller/acoes.php',
							{
								//variaveis a ser enviadas metodo POST
								acao:13,
								pvnumero:id,
								usucodigo:usucodigo
							},
							function(data){}, "json");
						}

						//Envia os dados via metodo post
						$.post('modulos/vendaAtacado/pedidos/adm/controller/getPedidoEstacionamento.php',
						{
							pvnumero:id
						},
						function(data)
						{
							if(data.retorno)
							{
								var limiteDisponivel = Number(data.estacionamento.cliente.clilimite) - (Number(data.estacionamento.cliente.vendasEmAberto.totalVendas)-Number(data.estacionamento.pvvalor));

								if(data.estacionamento.pvlibera && data.estacionamento.pvlibera)
								{
									if (Number(data.estacionamento.pvvalor) < limiteDisponivel)
									{
										$("#"+id).attr("style", "background: #87CEFA");
										$("#dvSituacao"+id).html("LIBERADO");
										$("#dvManutencao"+id).html("");
									}
								}
							}
						}, "json");
					};

				    $.GB_show(href,
				    {
				    	height: (document.body.scrollHeight - 80),
				    	width: (document.body.scrollWidth - 30),
				    	animation: true,
				    	overlay_clickable: false,
				    	callback: callback,
				    	caption: t
				    });

				      return false;
				});
			}, "json");



			/*$("a[name='financeiro']").attr('title','Incluir no Pedido');

			$("a[name='financeiro']").dialog({
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
			});*/

		}
	});
});
