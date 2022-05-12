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
			//var tipoStatusLiberacao = $("input[type=radio][name=opcaoTipoPesquisa]:checked").val();
			
			titulo = "PROCESSANDO, AGUARDE...";
			mensagem = "EXECUTANDO PESQUISA DE ESTACIONAMENTO.";
			
			$("#retorno").messageBoxModal(titulo, mensagem);
			
			dataInicio.setTimes(horaInicio);
			dataFim.setTimes(horaFim);
			nivelUsuario = Number(usuario.nivel);
			
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
			/*
			var aLiberacao = new Array();
			$('#listaTipoLiberacao option:selected').each(function()
			{
				if($(this).val())
				{
					aLiberacao.push(tiposLiberacao[$(this).val()].idpvencer2);
				}
			});*/
			
			
			
			$.post('modulos/vendaAtacado/pedidos/adm/controller/getEstacionamento.php',
			{
				//variaveis a ser enviadas metodo POST
				
				dataInicio:dataInicio.format("Y-m-d H:i:s"),
				dataFim:dataFim.format("Y-m-d H:i:s"),
				aTipo:JSON.stringify(aTipo),
				aEstoque:JSON.stringify(aEstoque),
				//aLiberacao:JSON.stringify(aLiberacao),
				nivelUsuario:nivelUsuario,
				//tipoStatusLiberacao:tipoStatusLiberacao,
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
					totalRows = Number(data.rows);
				
					$.each(data.aEstacionamento, function (key, value)
					{
						
						
						var cidade = "";
						var uf = "";
						
						
						var cor = "#77DD98";
						//var cor2 = "#CCCCCC";
						var cor2 = "#FF1493";
						var cor3 = "#9370DB";
							
						
						var status = "AUTORIZADO";
						var status2 = "PENDENTE";
						var status3 = "NEGADO";
						var status4 = "NAO AUTORIZADO";
					
						var tipoStatus = 0;	
						
						
						var dataSerasaExp = value.cliente.cliserasaexp ? new Date().date(value.cliente.cliserasaexp) : '';
						var dataSintegraExp = value.cliente.clisintegra ? new Date().date(value.cliente.clisintegra) : '';
						valP = Number(value.pvvalor);
						valPDesc = Number(value.pvvaldesc);
						valorPedido = valP - valPDesc;
						var txtDataSerasa = '';
						var txtDataSintegra = '';
						if(usuario.nivel=='1')
						{
						var situacao = '<a href="'+HTTP_ROOT+'dtrade.php?flagmenu=9&pgcodigo=11&popup=1&pvnumero='+value.pvnumero+'" title="LIBERACAO" tooltip="CLIQUE PARA REALIZAR LIBERAÇÃO DO PEDIDO" id="'+value.pvnumero+'" class="greybox" name="liberacao">LIBERAR</a>';
						}else if(usuario.nivel=='2')
						{
							var situacao = '<a href="#" title="LIBERACAO" tooltip="CLIQUE PARA REALIZAR LIBERAÇÃO DO PEDIDO" id="'+value.pvnumero+'" name="liberacao1" valprefechamento="'+Number(value.valorPreFechamento).toFixed(2) +'" valorpedido="'+valorPedido.toFixed(2)+'">LIBERAR</a>';
						}
						var liberarFinanceiro = '<a href="javascript:;" title="ALTERAR SITUACAO" tooltip="CLIQUE PARA ALTERAR SITUACAO DO PEDIDO." id="'+value.pvnumero+'" prefechamento="'+value.prefechamento+'" name="financeiro">FINANCEIRO</a>';
						var status4 = '<a href="javascript:;" title="ALTERAR SITUACAO" tooltip="CLIQUE PARA ALTERAR SITUACAO DO PEDIDO." id="'+value.pvnumero+'" name="financeiro">NAO AUTORIZADO</a>';
						var observacaoFinanceiro = '';
						if(value.obsfinanceiro!=undefined || value.obsfinanceiro!=null)
						{
							observacaoFinanceiro = value.obsfinanceiro;
						}
						var manutencaoPedido = '<a href="'+HTTP_ROOT+'alterarpvendanovo.php?pvnumero='+value.pvnumero+'" title="MANUTENCAO" tooltip="CLIQUE PARA EFETUAR MANUTEÇÃO DO PEDIDO" class="greybox" id="'+value.pvnumero+'" name="manutencao">EDITAR</a> - <a href="'+HTTP_ROOT+'alterarpvendasimples.php?flagmenu=9&pgcodigo=16&pvnumero='+value.pvnumero+'&popup=1" title="MANUTENCAO" tooltip="CLIQUE PARA EFETUAR ALTERAÇÃO SIMPLES DO PEDIDO" class="greybox" id="'+value.pvnumero+'" name="manutencao">SIMPLES</a>';
						var consultaPedido = '<a href="'+HTTP_ROOT+'pedvendacons2.php?flagmenu=9&popup=1&codped='+value.pvnumero+'" title="CONSULTA PEDIDO" tooltip="CLIQUE PARA REALIZAR CONSULTAR PEDIDO." class="greybox" id="'+value.pvnumero+'" name="consulta">'+value.pvnumero+'</a>';
						var analiseCredido = '<a href="'+HTTP_ROOT+'analisecredclientessimples.php?popup=1&clicod='+value.cliente.clicod+'" title="ANALISE DE CREDITO" tooltip="CLIQUE PARA VISUALIZAR ANALISE DE CREDITO DO CLIENTE." class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'" name="analiseCredito">ANALISE CREDITO</a>';
						var manutencaoCredito = '<a href="'+HTTP_ROOT+'dtrade.php?flagmenu=9&pgcodigo=6&popup=1&clicod='+value.cliente.clicod+'" title="MANUTENCAO DE CREDITO" tooltip="CLIQUE PARA EFETUAR MANUTEÇÃO DE CREDITO DO CLIENTE." class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'" name="manutencaoCredito">'+$.mask.string(Number(value.cliente.clilimite).toFixed(2), 'decimal')+'</a>';
						var manutencaoCredito2 = '<a href="'+HTTP_ROOT+'dtrade.php?flagmenu=9&pgcodigo=6&popup=1&clicod='+value.cliente.clicod+'" title="MANUTENCAO DE CREDITO" tooltip="CLIQUE PARA EFETUAR MANUTEÇÃO DE CREDITO DO CLIENTE." class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'" name="manutencaoCredito">MANUTENCAO CREDITO</a>';
						//var atualizaInterfix = '<a href="'+HTTP_ROOT+'dtrade.php?flagmenu=9&pgcodigo=19&popup=1&clicod='+value.cliente.clicod+'" title="FINANCEIRO INTERFIX" tooltip="CLIQUE PARA ATUALIZAÇÃO FINANCEIRO INTERFIX." class="greybox" id="'+value.cliente.clicod+'" name="interfix">ATUALIZAR</a>';
						var atualizaInterfix = '<a href="'+HTTP_ROOT+'dtrade.php?flagmenu=9&pgcodigo=6&popup=1&clicod='+value.cliente.clicod+'" title="MANUTENCAO DE CREDITO" tooltip="CLIQUE PARA EFETUAR MANUTEÇÃO DE CREDITO DO CLIENTE." class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'" name="manutencaoCredito">ATUALIZAR</a>';
						
						
						var limiteDisponivel = Number(value.cliente.clilimite) - (Number(value.cliente.vendasEmAberto.totalVendas)-Number(value.pvvalor));
						var totalLiquido = Number(value.pvvalor) - Number(value.pvvaldesc);
						
						if(usuario.nivel == "1")
						{
						var dataEmissao = new Date().date(value.pvemissao);
						
						}else if(usuario.nivel == "2")
						{
						var dataEmissao = new Date().date(value.pvliberafinanceiro);
						}
						
						if (value.cliente.enderecoFaturamento)
						{
							uf = value.cliente.enderecoFaturamento.cidade.uf;
							cidade= value.cliente.enderecoFaturamento.cidade.descricao;
						}
						
						if(value.condicaoComercial.codigo != 1)
						{
							/*
							if (Number(value.pvencer) == 3)
							{
								cor = '#FFFFBB';
								status = 'EM ANALISE';
								situacao = liberarFinanceiro;
								tipoStatus = 2;
							//}
							//else
							//{*/
								if (Number(value.cliente.clifat) == 1)
								{
									txtDataSerasa = dataSerasaExp ? dataSerasaExp.format("d/m/Y") : '';
									cor = '#FFFFBB';
									status = 'SOMENTE A VISTA';
									situacao = liberarFinanceiro;
									tipoStatus = 0;
									//txtDataSerasa = dataSerasaExp.format("d/m/Y");
								}else
								
								if (Number(value.cliente.clifat) == 3)
								{
									txtDataSerasa = dataSerasaExp ? dataSerasaExp.format("d/m/Y") : '';
									//alert(value.cliente.clifat);
									cor = '#FA5050';
									status = 'PROIBIDO';
									situacao = liberarFinanceiro;
									tipoStatus = 0;
									//txtDataSerasa = dataSerasaExp.format("d/m/Y");
								}else
								
								if (Number(value.cliente.clifat) == 4)
								{
									txtDataSerasa = dataSerasaExp ? dataSerasaExp.format("d/m/Y") : '';
									cor = '#FA5050';
									status = 'PROIBIDO MATEL';
									situacao = liberarFinanceiro;
									tipoStatus = 0;
									///txtDataSerasa = dataSerasaExp.format("d/m/Y");
								}
								else
								{	
									
									if (!dataSerasaExp)
									{
										cor = '#FFFFBB';
										status = atualizaInterfix;
										situacao = liberarFinanceiro;
										tipoStatus = 0;
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
											tipoStatus = 0;
										}
										
										if (dataAtual.getMonthsBetween(dataSerasaExp) < 0)
										{
											cor = '#FFFFBB';
											status = atualizaInterfix;
											situacao = liberarFinanceiro;
											tipoStatus = 0;
											
											txtDataSerasa = '<a href="javascript:;" tooltip="DATA DA ATUALIZAÇÃO DO SERASA EXPIRADA!\n CLIQUE EM ATUALIZAR."><font color="red"><b>'+dataSerasaExp.format("d/m/Y")+'<b></font></a>';
										}
										
								
									}
									
									
									
									
							
								}
							//}
						}
						
						var isPrint = false;
						if(usuario.nivel == "2" && (value.pvencer2== "3" || value.pvencer2=="4"))
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
							
							if(usuario.nivel=='1')
							{
							
							
							if(value.pvencer2=='4'){
							codHtml += "<tr style='background: "+cor2+";' id="+value.pvnumero+">";
						}else if(value.pvencer2=='5'){
							codHtml += "<tr style='background: "+cor3+";' id="+value.pvnumero+">";
						}else{
							codHtml += "<tr style='background: "+cor+";' id="+value.pvnumero+">";
						}
							codHtml += "<td>"+(++numLinha)+"</td>"+
								"<td>"+value.tipoPedido.sigla+"</td>"+
								"<td><span id='dvConsultaPedido"+value.pvnumero+"'>"+consultaPedido+"</span></td>" +
								"<td><a href='"+HTTP_ROOT+"clientescons.php?popup=1&pvnumero="+value.pvnumero+"&clicod="+value.cliente.clicod+"' title='CONSULTA CLIENTE' tooltip='CLIQUE PARA EFETUAR CONSULTA CLIENTE' class='greybox' id='"+value.cliente.clicod+"' name='cliente'>"+value.cliente.clicod+"</a></td>" +
								"<td><a href='"+HTTP_ROOT+"clientescons.php?popup=1&pvnumero="+value.pvnumero+"&clicod="+value.cliente.clicod+"' title='CONSULTA CLIENTE' tooltip='CLIQUE PARA EFETUAR CONSULTA CLIENTE' class='greybox' id='"+value.cliente.clicod+"' name='cliente'>"+value.cliente.clirazao+"</a></td>" +
								"<td>";
							codHtml += value.cliente.climodo == 2 ? "FIDELIDADE" : "NORMAL";
							codHtml += "</td> <td>";
							codHtml += value.tipolocal == 1 ? "CD" : "VIX";
							codHtml += "</td>";
						 if(value.pvencer2=='3' && value.pvfinanceiro=='0'){
							 codHtml += "<td><span id='dvSituacao"+value.pvnumero+"'>"+liberarFinanceiro+"</span></td>";
						 }else{
							 codHtml += "<td><span id='dvSituacao"+value.pvnumero+"'>"+situacao+"</span></td>";
							 
						 }
						 codHtml +="<td><span id='dvManutencao"+value.pvnumero+"'>"+manutencaoPedido+"</span></td>" +
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
								"<td><span id='dvAnaliseCredito"+value.pvnumero+"'>"+manutencaoCredito2+"</span></td>" +
								"<td><span id='dvLimite"+value.pvnumero+"'>"+manutencaoCredito+"</span></td>" ;
								
													
							codHtml +=   "<td><span id='dvSerasa"+value.pvnumero+"'>"+txtDataSerasa+"</span></td>";
							codHtml +=   "<td><span id='dvSintegra"+value.pvnumero+"'>"+txtDataSintegra+"</span></td>";
							codHtml +=   "<td><span id='dvSintegra"+value.pvnumero+"'>"+txtDataSintegra+"</span></td>";
							
						
							
							if(value.pvencer2=='4'){
								codHtml +="<td><span id='dvStatus"+value.pvnumero+"'>"+status2+"</span></td>" ;
							}else if(value.pvencer2=='5'){
								codHtml +="<td><span id='dvStatus"+value.pvnumero+"'>"+status3+"</span></td>" ;
							}else {
								codHtml +="<td><span id='dvStatus"+value.pvnumero+"'>"+status+"</span></td>" ;
							}
							codHtml +="<td><span id='obs"+value.pvnumero+"'>"+observacaoFinanceiro+"</span></td>" ;
							
							"</tr>";
							}else
								if(usuario.nivel=='2')
								{
								
								
								if(value.pvencer2=='4'){
									codHtml += "<tr style='background: "+cor2+";' id="+value.pvnumero+">";
								}else if(value.pvencer2=='5'){
									codHtml += "<tr style='background: "+cor3+";' id="+value.pvnumero+">";
								}else{
									codHtml += "<tr style='background: "+cor+";' id="+value.pvnumero+">";
								}
									codHtml += "<td>"+(++numLinha)+"</td>"+
										"<td>"+value.tipoPedido.sigla+"</td>"+
										"<td><span id='dvConsultaPedido"+value.pvnumero+"'>"+consultaPedido+"</span></td>" +
										"<td><a href='"+HTTP_ROOT+"clientescons.php?popup=1&pvnumero="+value.pvnumero+"&clicod="+value.cliente.clicod+"' title='CONSULTA CLIENTE' tooltip='CLIQUE PARA EFETUAR CONSULTA CLIENTE' class='greybox' id='"+value.cliente.clicod+"' name='cliente'>"+value.cliente.clicod+"</a></td>" +
										"<td><a href='"+HTTP_ROOT+"clientescons.php?popup=1&pvnumero="+value.pvnumero+"&clicod="+value.cliente.clicod+"' title='CONSULTA CLIENTE' tooltip='CLIQUE PARA EFETUAR CONSULTA CLIENTE' class='greybox' id='"+value.cliente.clicod+"' name='cliente'>"+value.cliente.clirazao+"</a></td>";

																	 if(value.pvencer2=='3' && value.pvfinanceiro=='0'){
									 codHtml += "<td><span id='dvSituacao"+value.pvnumero+"'>"+liberarFinanceiro+"</span></td>";
								 }else{
									 codHtml += "<td><span id='dvSituacao"+value.pvnumero+"'>"+situacao+"</span></td>";
									 
								 }
								 	 codHtml += "<td><span id='dvAnaliseCredito"+value.pvnumero+"'>"+analiseCredido+"</span></td>" +
								 	 		
									 		"<td><span id='dvLimite"+value.pvnumero+"'>"+manutencaoCredito+"</span></td>" +
									 		"<td><span id='dvAnaliseCredito"+value.pvnumero+"'>"+manutencaoCredito2+"</span></td>";
												codHtml +=   "<td><span id='dvSerasa"+value.pvnumero+"'>"+txtDataSerasa+"</span></td>";
											
									if(value.pvencer2=='4'){
										codHtml +="<td><span id='dvStatus"+value.pvnumero+"'>"+status2+"</span></td>" ;
									}else if(value.pvencer2=='5'){
										codHtml +="<td><span id='dvStatus"+value.pvnumero+"'>"+status3+"</span></td>" ;
									}else {
										codHtml +="<td><span id='dvStatus"+value.pvnumero+"'>"+status+"</span></td>" ;
									}
									
									codHtml +="<td>";
									codHtml += value.cliente.climodo == 2 ? "FIDELIDADE" : "NORMAL";
									codHtml += "</td>";
								 							
									codHtml +="<td><span id='dvSintegra"+value.pvnumero+"'>"+txtDataSintegra+"</span></td>";
									codHtml +="<td><span id='dvSintegra"+value.pvnumero+"'>"+txtDataSintegra+"</span></td>";
									codHtml +="<td>"+value.condicaoComercial.descricao+"</td>";
									codHtml +="<td>"+uf+"</td>";
									codHtml +="<td>"+value.vendedor.vencodigo+" "+value.vendedor.vennguerra+"</td>";
												
									codHtml += "<td>"+dataEmissao.format("d/m/Y H:i:s")+"</td>" +
								 
								
									
										"</tr>";
							}
						}
					});
					
					codHtml += 	"</tbody></table>";
				
					$('#tblResultado').html(codHtml);
					
					$("#accordion").accordion( "activate" , 1);
					
					width = (screen.width - (((screen.width * 5)/100)*2));

					if(usuario.nivel=='1')
					{
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
									{display: 'MANUTENCAO CREDITO', name : 'manutencao', width : 120, align: 'center'},
									{display: 'LIMITE', name : 'limite_cliente', width : 100, align: 'center'},
									{display: 'SERASA', name : 'serasa', width : 100, align: 'center'},
									{display: 'SINTEGRA', name : 'sintegra', width : 100, align: 'center'},
									{display: 'RECEITA', name : 'receita', width : 100, align: 'center'},
									{display: 'STATUS FINANC', name : 'status', width : 120, align: 'center'},
									{display: 'OBS', name : 'obs', width : 120, align: 'center'}
									]
					});
					
					}else
						if(usuario.nivel=='2')
					{
					
						$("#tblResultado").flexigrid(
								{
									width: width,
									height:300,
									striped:false,
									colModel : [
									            {display: '', name : 'canal', width : 40, align: 'center'},
												{display: 'CANAL', name : 'canal', width : 40, align: 'center'},
												{display: 'PEDIDO', name : 'pedido', width : 50, align: 'center'},
												{display: 'COD.CLI.', name : 'cod_cliente', width : 60, align: 'center'},
												{display: 'RAZAO SOCIAL', name : 'razao_social', width : 250, align: 'left'},
												{display: 'SITUACAO', name : 'situacao', width : 90, align: 'center'},
												{display: 'ANALISE CREDITO', name : 'manutencao', width : 120, align: 'center'},
												{display: 'LIMITE', name : 'limite_cliente', width : 100, align: 'center'},
												{display: 'MANUTENCAO CREDITO', name : 'manutencao', width : 120, align: 'center'},
												{display: 'SERASA', name : 'serasa', width : 100, align: 'center'},
												{display: 'STATUS FINANC', name : 'status', width : 120, align: 'center'},
												{display: 'CLIENTE', name : 'tipo_cliente', width : 100, align: 'center'},
												{display: 'SINTEGRA', name : 'sintegra', width : 100, align: 'center'},
												{display: 'RECEITA', name : 'receita', width : 100, align: 'center'},
												{display: 'COND. COM.', name : 'condicao_com', width : 100, align: 'center'},
												{display: 'UF', name : 'estado', width : 30, align: 'center'},
												{display: 'COD/VEND.', name : 'vendedor', width : 130, align: 'center'},
												{display: 'EMISSAO/HORA', name : 'data_emissao', width : 150, align: 'center'}
												 
												
												
												
												
												
												
												
												]
								});
						
					}
					
					$('a[name=liberacao1]').click(function()
							{
						var id = $(this).attr("id");
						var valprefe = $(this).attr("valprefechamento");
						var valorped = $(this).attr("valorpedido");
						
						
										
						if(valorped != valprefe)
						{
							
							var msgprefec = "<br> - VALOR DO PEDIDO NAO CONFERE COM O VALOR DO PREFECHAMENTO";
							alert('VALOR DO PEDIDO NAO CONFERE COM O VALOR DO PREFECHAMENTO');
							$("#retorno").messageBox(msgprefec,false, false);
							return false;					
						}
						
						$.post('modulos/vendaAtacado/pedidos/adm/controller/acoes.php',
								{
									//variaveis a ser enviadas metodo POST
									id2:id,
									acao:9
									 
								},	
								function(data)
								{
									if (Boolean(data.retorno))
									{
										alert(data.mensagem);
										
										$("#"+id).attr("style", "background: #4682B4");
										$("#"+id).hide();
									}
									else{
										alert(data.mensagem);
									}
								},'json');
						$("#"+id).attr("style", "background: #4682B4");
						$("#"+id).hide();													
							});
					
					$('a[name=financeiro]').click(function()
					{
						
						
						
						var id = $(this).attr("id");
						prefechamento = $(this).attr("prefechamento");
						
						
						$.post('modulos/vendaAtacado/pedidos/adm/controller/acoes.php',
								{
									//variaveis a ser enviadas metodo POST
									id:id,
									acao:1
									 
								},	
								function(data)
								{
									prefechamento = data;
									
									
									if(prefechamento=='0')
									{
										$('#dialog').attr('title','PEDIDO SEM PREFECHAMENTO');
										
										var mensagem = "PEDIDO SEM PREFECHAMENTO NAO PODERA IR PARA O FINANCEIRO";
										
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
										
									}else{
									$('#dialog').attr('title','SITUACAO PEDIDO');
									
									var mensagem = "DESEJA ALTERAR A SITUACAO DO PEDIDO PARA...";
									
									var html = '<p>'+
									'<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>'+
									mensagem+
									'</p><form id="formSituacao" name="formSituacao" method="post" action="#">';
									
									if(usuario.nivel == "2")
									{
										html += '<input align="middle" type="radio" checked="checked" value="4" id="pendentes" name="opcoesSituacao">PENDENTE'+
										'<input align="middle" type="radio" value="5" id="negado" name="opcoesSituacao">NEGADO'+
										'<input align="middle" type="radio" value="22" id="negado" name="opcoesSituacao">AUTORIZAR';
										html += '<textarea name="txtObsSituacao" id="txtObsSituacao" cols="70" rows="3"></textarea>'+
										 '</form><h5>OBS.: INFORME O MOTIVO DA ALTERACAO DA SITUACAO DO PEDIDO.<h5>';
									}
									else
									{
										html += '<input align="middle" type="radio" checked="checked" value="3" id="liberarFinanceiro" name="opcoesSituacao">LIBERAR FINANCEIRO';
									}
									
									
									
									
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
										
												if($("#formSituacao").validate(
													{
														rules:{txtObsSituacao:{required: true}},
														messages:{txtObsSituacao:{required: "Obrigatório o preenchimento do campo observação."}}
													}).form())
												{
													$.post('modulos/vendaAtacado/pedidos/adm/controller/alteraSituacao.php',
													{
														//variaveis a ser enviadas metodo POST
														pvnumero:id,
														situacao:$("input[name='opcoesSituacao']:checked").val(),
														observacao:$("#txtObsSituacao").val()
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
																$("#"+id).attr("style", "background: #FF1493");
																$("#dvStatus"+id).html("PENDENTE");
																$("#dvManutencao"+id).show();
															}
															else if($("input[name='opcoesSituacao']:checked").val() == 5)
															{
																//$("#"+id).attr("style", "background: #FA5050");
																//$("#dvStatus"+id).html("NEGADO");
																//$("#dvManutencao"+id).hide();
																$("#"+id).hide();
															}
															else if($("input[name='opcoesSituacao']:checked").val() == 22)
															{
																$("#"+id).attr("style", "background: #77DD98");
																$("#dvSituacao"+id).html('<a href="javascript:;"   title="LIBERACAO '+id+'" tooltip="CLIQUE PARA REALIZAR LIBERAÇÃO DO PEDIDO '+id+'" id="'+id+'" name="liberacao3">LIBERAR</a>');
																$("#dvStatus"+id).html("AUTORIZADO");
																$("#dvManutencao"+id).show();
																
																$('a[name=liberacao3]').click(function()
																		{
																	var id = $(this).attr("id");
																	
																	
																	$.post('modulos/vendaAtacado/pedidos/adm/controller/acoes.php',
																			{
																				//variaveis a ser enviadas metodo POST
																				id2:id,
																				acao:9
																				 
																			},	
																			function(data)
																			{
																				if (Boolean(data.retorno))
																				{
																					alert(data.mensagem);
																					$("#"+id).attr("style", "background: #4682B4");
																					$("#"+id).hide();
																				}
																				else{
																					alert(data.mensagem);
																				}
																			},'json');
																	$("#"+id).attr("style", "background: #4682B4");
																	$("#"+id).hide();														
																		});
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
									}
									
								},'json');
						

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
				    pvnumero = 	$(this).attr("pvnumero");
				    
				    
				    
					var callback = function()
					{
						var usucodigo = null;
						
						if (tipo == "manutencao" || tipo == "liberacao" || tipo == "manutencaoCredito") 
						{
							
							if(tipo == "manutencaoCredito")
							{
								id = pvnumero;
							}
							
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
								
								if(tipo == "manutencaoCredito")
								{
									
								var dataSerasaExp = data.estacionamento.cliente.cliserasaexp ? new Date().date(data.estacionamento.cliente.cliserasaexp) : '';
								txtDataSerasa = dataSerasaExp ? dataSerasaExp.format("d/m/Y") : '';
																
								//alert(data.estacionamento.cliente.cliserasaexp);
									$("#dvSerasa"+id).html(txtDataSerasa);
									$("#dvLimite"+id).html($.mask.string(Number(data.estacionamento.cliente.clilimite).toFixed(2), 'decimal'));
									
									
									if(Number(data.estacionamento.cliente.clifat) == 3)
										{
																	
										$("#"+id).attr("style", "background: #FA5050");
										$("#dvStatus"+id).html("PROIBIDO");
										$("#dvSituacao"+id).html('<a href="dtrade.php?flagmenu=9&pgcodigo=6&popup=1&clicod='+data.estacionamento.cliente.clicod+'"  title="MANUTENÇÃO DE CRÉDITO" tooltip="CLIQUE PARA REALIZAR MANUTENÇÃO DE CRÉDITO" target="_blank">PROIBIDO MATTEL</a>');
										$("#dvManutencao"+id).html("");
										$("#dvLimite"+id).html('<a href="dtrade.php?flagmenu=9&pgcodigo=6&popup=1&clicod='+data.estacionamento.cliente.clicod+'"  title="MANUTENÇÃO DE CRÉDITO" tooltip="CLIQUE PARA REALIZAR MANUTENÇÃO DE CRÉDITO" target="_blank">'+$.mask.string(Number(data.estacionamento.cliente.clilimite).toFixed(2), 'decimal')+'</a>');
										$("#dvSerasa"+id).html(txtDataSerasa);
										
										}else
									
									if(Number(data.estacionamento.cliente.clifat) == 4)
									{
										$("#"+id).attr("style", "background: #FA5050");
										$("#dvStatus"+id).html("PROIBIDO MATTEL");
										$("#dvSituacao"+id).html('<a href="dtrade.php?flagmenu=9&pgcodigo=6&popup=1&clicod='+data.estacionamento.cliente.clicod+'"  title="MANUTENÇÃO DE CRÉDITO" tooltip="CLIQUE PARA REALIZAR MANUTENÇÃO DE CRÉDITO" target="_blank">PROIBIDO MATTEL</a>');
										$("#dvManutencao"+id).html("");
										$("#dvLimite"+id).html('<a href="dtrade.php?flagmenu=9&pgcodigo=6&popup=1&clicod='+data.estacionamento.cliente.clicod+'"  title="MANUTENÇÃO DE CRÉDITO" tooltip="CLIQUE PARA REALIZAR MANUTENÇÃO DE CRÉDITO" target="_blank">'+$.mask.string(Number(data.estacionamento.cliente.clilimite).toFixed(2), 'decimal')+'</a>');
										$("#dvSerasa"+id).html(txtDataSerasa);
									}else
										
									if (dataAtual.getMonthsBetween(dataSerasaExp) > 0 && (Number(data.estacionamento.pvvalor) < limiteDisponivel) && (Number(data.estacionamento.cliente.clifat) != 3 || Number(data.estacionamento.cliente.clifat) != 4))
									{
										
										//$("#"+id).attr("style", "background: #77DD98");
										$("#"+id).attr("style", "background: #FFA500");
										$("#dvLimite"+id).html('<a href="dtrade.php?flagmenu=9&pgcodigo=6&popup=1&clicod='+data.estacionamento.cliente.clicod+'"  title="MANUTENÇÃO DE CRÉDITO" tooltip="CLIQUE PARA REALIZAR MANUTENÇÃO DE CRÉDITO">'+$.mask.string(Number(data.estacionamento.cliente.clilimite).toFixed(2), 'decimal')+'</a>');
										//$("#dvSituacao"+id).html('<a href="dtrade.php?flagmenu=9&pgcodigo=11&popup=1&pvnumero='+id+'"  title="LIBERACAO" tooltip="CLIQUE PARA REALIZAR LIBERAÇÃO DO PEDIDO" target="_blank">LIBERAR</a>');
										$("#dvStatus"+id).html('<a href="javascript:;" title="ALTERAR SITUACAO" tooltip="CLIQUE PARA ALTERAR SITUACAO DO PEDIDO." id="'+id+'" name="naoAnalisado">NAO ANALISADO</a>');			
										//$("#dvStatus"+id).html("AUTORIZADO");	
										
										
										
										
										$('a[name=naoAnalisado]').click(function()
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
														'<input align="middle" type="radio" value="5" id="negado" name="opcoesSituacao">NEGADO'+
														'<input align="middle" type="radio" value="22" id="negado" name="opcoesSituacao">AUTORIZAR';
														html += '<textarea name="txtObsSituacao" id="txtObsSituacao" cols="70" rows="3"></textarea>'+
														'</form><h5>OBS.: INFORME O MOTIVO DA ALTERACAO DA SITUACAO DO PEDIDO.<h5>';
													}
													else
													{
														html += '<input align="middle" type="radio" checked="checked" value="3" id="liberarFinanceiro" name="opcoesSituacao">LIBERAR FINANCEIRO';
													}
													
													
													
													
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
														
																/*if($("#formSituacao").validate(
																	{
																		rules:{txtObsSituacao:{required: true}},
																		messages:{txtObsSituacao:{required: "Obrigatório o preenchimento do campo observação."}}
																	}).form())*/
																{
																	$.post('modulos/vendaAtacado/pedidos/adm/controller/alteraSituacao.php',
																	{
																		//variaveis a ser enviadas metodo POST
																		pvnumero:id,
																		situacao:$("input[name='opcoesSituacao']:checked").val(),
																		observacao:$("#txtObsSituacao").val()
																	},
																	function(data)
																	{
																		if (Boolean(data.retorno))
																		{
																			if($("input[name='opcoesSituacao']:checked").val() == 22)
																			{
																				
																		 																			
																			
																			
																				
																				
																				$("#"+id).attr("style", "background: #77DD98");
																				//$("#dvSituacao"+id).html('<a href="dtrade.php?flagmenu=9&pgcodigo=11&popup=1&pvnumero='+id+'"  title="LIBERACAO" tooltip="CLIQUE PARA REALIZAR LIBERAÇÃO DO PEDIDO" target="_blank">LIBERAR</a>');
																				$("#dvSituacao"+id).html('<a href="javascript:;"   title="LIBERACAO '+id+'" tooltip="CLIQUE PARA REALIZAR LIBERAÇÃO DO PEDIDO" id="'+id+'"  name="liberacao2">LIBERAR</a>');
																				$("#dvStatus"+id).html("AUTORIZADO");	
																				
																				
																				$('a[name=liberacao2]').click(function()
																						{
																					var id = $(this).attr("id");
																					
																					var valprefe = $(this).attr("valprefechamento");
																					var valorped = $(this).attr("valorpedido");
																					
																					
																									
																					if(valorped != valprefe)
																					{
																						
																						var msgprefec = "<br> - VALOR DO PEDIDO NAO CONFERE COM O VALOR DO PREFECHAMENTO";
																						alert('VALOR DO PEDIDO NAO CONFERE COM O VALOR DO PREFECHAMENTO');
																						$("#retorno").messageBox(msgprefec,false, false);
																						return false;					
																					}
																					
																					
																					$.post('modulos/vendaAtacado/pedidos/adm/controller/acoes.php',
																							{
																								//variaveis a ser enviadas metodo POST
																								id2:id,
																								acao:9
																								 
																							},	
																							function(data)
																							{
																								if (Boolean(data.retorno))
																								{
																									alert(data.mensagem);
																									$("#"+id).attr("style", "background: #4682B4");
																									$("#"+id).hide();
																								}
																								else{
																									alert(data.mensagem);
																								}
																							},'json');
																					$("#"+id).attr("style", "background: #4682B4");
																					$("#"+id).hide();														
																						});
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
			
			
			
	
				
		
			
			
			
			
		}
	});
});
