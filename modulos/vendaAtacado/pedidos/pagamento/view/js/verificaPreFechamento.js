/**
 * @author Douglas
 *
 * Verificação dos dados para envio de formulario.
 *
 * Criação    20/03/2010
 * Modificado 20/03/2010
 *
 */

$(function()
{
	
	

	$("#listaPesquisaPedidos").ajaxComplete(function(){
		
		itensPreFechamento = new Array();
		itensPreFechamento.toArray(pedido.preFechamento);
		
		
		

		var docto = pedido.pvnumero;
		if(pedido.tipoPedido.sigla=='E')
		{
		$('#fecdocto').val(docto+'E');
		}
		else
			if(pedido.tipoPedido.sigla=='M')
			{
				$('#fecdocto').val(docto+'M');
			}
			else
				if(pedido.tipoPedido.sigla=='I')
				{
					$('#fecdocto').val(docto+'I');
				}
				else
					if(pedido.tipoPedido.sigla=='T')
					{
						$('#fecdocto').val(docto+'T');
					}
					else
						if(pedido.tipoPedido.sigla=='D')
						{
							$('#fecdocto').val(docto+'D');
						}
						else
							if(pedido.tipoPedido.sigla=='F')
							{
								$('#fecdocto').val(docto+'F');
							}
							else
								if(pedido.tipoPedido.sigla=='Y')
								{
									$('#fecdocto').val(docto+'Y');
								}
								else

									{
									$('#fecdocto').val(docto);
									}



		




	function limpaform()
	{
	  $('#fecdata').val('');
	  $('# listaBandeiraCartao').val('');
	  $('# fecforma').val('');
	  var docto = pedido.pvnumero;
		if(pedido.tipoPedido.sigla=='E')
		{
		$('#fecdocto').val(docto+'E');
		}
		else
			if(pedido.tipoPedido.sigla=='M')
			{
				$('#fecdocto').val(docto+'M');
			}
			else
				if(pedido.tipoPedido.sigla=='I')
				{
					$('#fecdocto').val(docto+'I');
				}
				else
					if(pedido.tipoPedido.sigla=='T')
					{
						$('#fecdocto').val(docto+'T');
					}
					else
						if(pedido.tipoPedido.sigla=='D')
						{
							$('#fecdocto').val(docto+'D');
						}
						else
							if(pedido.tipoPedido.sigla=='F')
							{
								$('#fecdocto').val(docto+'F');
							}
							else
								if(pedido.tipoPedido.sigla=='Y')
								{
									$('#fecdocto').val(docto+'Y');
								}
								else

									{
									$('#fecdocto').val(docto);
									}
	  $('#fecbanco').val('');
	  $('#fecvalor').val('');
	  $('#fecvecto').val('');
	  $('#listaTipoParcelamento').val('');
	  $('#listaTipoDuplicata').val('');
	  $('#listaFormaPagamento').val('');
	  $('#fecagencia').val('');
	  $('#fecempresa').val('');
	  $('#feccaixa').val('');
	  $('#feccartao').val('');
	  $('#fecconta').val('');
	  $('# fecdia').val('');
	}

	function listaParcelaPreFechamento(itensPreFechamento)
	{

		
	var tblFormaPreFechamento = new Array();
	var tblFormaVale = new Array();

	valorParcelaPreFechamento = 0;
	diferencaPreFechamento = 0;

	tblFormaPreFechamento['tabela'] ='<table id="listaPreFechamento">' +
		'<thead>' +
		'<tr>' +
		'<th>Forma Pagto</th>'+
		'<th>Docto</th>'+
		'<th>Valor</th>'+
		'<th>Data</th>'+
		'<th>Vencto</th>'+
		'<th>Banco</th>'+
		'<th>Agencia</th>'+
		'<th>Conta</th>'+
		'<th>Ação</th>'+
		'</tr>' +
		'</thead>' +
		'<tbody>';
		$.each(itensPreFechamento, function (key, value)
		{

		valorParcelaPreFechamento += Number(value.fecvalor);

		hE = "<input type='hidden' id='itemPreFechamento"+value.prefeccodigo+"' value='"+JSON.stringify(value)+"'/>";

		//var fecforma;
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
			if(value.fecforma==110)
			{
				fecforma = "110 - CHEQUE A VISTA";
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

		tblFormaPreFechamento['tabela'] +='<tr>'+
		'<td>'+ fecforma +'</td>'+
		'<td>'+ value.fecdocto +'</td>'+
		'<td>'+ $.mask.string(value.fecvalor, 'decimal') +'</td>'+
		'<td>'+ value.fecdata +'</td>'+
		'<td>'+ value.fecvecto +'</td>'+
		'<td>'+  value.fecbanco +'</td>'+
		'<td>'+ value.fecagencia +'</td>'+
		'<td>'+ value.fecconta +'</td>'+


		"<td><input type='hidden' id='itemPreFechamento"+value.fecdocto+"' value='"+JSON.stringify(value)+"'/>"+hE+"<input type='button' name='btnAlterarParcela' id='"+value.fecdocto+"' style='background: url(imagens/edit.gif); background-repeat: no-repeat; background-position:center center; height: 20px; width: 55px; border:0px;'/>"+
		"<input type='button' name='btnExcluirParcela' id='"+value.fecdocto+"' style='background: url(imagens/delete.gif); background-repeat: no-repeat; background-position:center center; height: 20px; width:65px; border:0px;'/> </td>" +
		"</tr>";
		});
		tblFormaPreFechamento['tabela'] +='</tbody>' +
		'</table>';


		if(pedido.cliente.devolucaoVales!=undefined||pedido.clicod!=null)
		{
			tblFormaVale['vales'] = '<select multiple="multiple" id="listaTipoVale" name="listaTipoVale">';
			tblFormaVale['vales'] += '<option> Nº do Vale |  R$:  Valor </option>';
				$.each(pedido.cliente.devolucaoVales, function (key, value)
				{
					a = '|';
			tblFormaVale['vales'] += '<option value='+ value.numero+a+value.dvnumero+a+value.valor+a+value.vale +'> Nº ' + value.vale + '  | R$: ' + numberToDecimal(value.valor) + '</option>';
				});
			tblFormaVale['vales'] +=   '</select> ';
				}

			 $("#listaTipoVale").change(function () {
		          str = "";
		          $("#listaTipoVale option:selected").each(function () {
		                str = $(this).val();

		              });

		        }).change();


				$('#detalhesFormaVale').html(tblFormaVale['vales']);
				$('#detalhesFormaPreFechamento').html(tblFormaPreFechamento['tabela']);
				$("#listaPreFechamento").ingrid({
					rowSelection:false,
					initialLoad:false,
					paging: false,
					sorting: false,
					colWidths:[120,120,70,70,70,70,70,70,140],
					height: 200
				});

				tmpValotTotal = (pedido.pvvalor-pedido.pvperdesc);
			
				diferencaPreFechamento = (tmpValotTotal-valorParcelaPreFechamento);
				$('#totalpag').val($.mask.string(tmpValotTotal.toFixed(2), 'decimal'));
				$('#somaParcela').val(valorParcelaPreFechamento.toFixed(2), 'decimal');
				$('#diferenca').val($.mask.string(diferencaPreFechamento.toFixed(2), 'decimal'));

				$("input[name='btnExcluirParcela']").click(function()
						{

						var id = $(this).attr('id');
						var jsonText = $("input[id='itemPreFechamento"+id+"']").val();
						deletaParcelaPreFechamento =  eval('(' + jsonText + ')');

						if(deletaParcelaPreFechamento.fecforma=='105')
						{

						$.post('modulos/vendaAtacado/pedidos/pagamento/controller/acoes.php',
							{

			   				//variaveis a ser enviadas metodo POST
			   				baixaVale:deletaParcelaPreFechamento.fecdocto,
			   				clicod: pedido.cliente.clicod,
			   				pvnumero:pedido.pvnumero,
			   				acao:2

			   				},
			   				function(data)
			   				{
			   					
			   					//alert('PREFECHAMENTO EFETUADO COM SUCSSO');
			   					if (Boolean(Number(data.retorno)))
			   					{
			   						
			   					pedido.cliente.devolucaoVales = new Object();
			   					pedido.cliente.devolucaoVales = data.vales;
			   					doctoVale = data.docto;
			   					
			   					pedido.preFechamento = new Object();
			   					pedido.preFechamento = data.preFechamentos;
			   					
			   					
			   			
			   					}
			   					else
			   	   				{
			   	   					
			   						alert('NÃO FOI POSSIVEL DELETAR O VALE');
			   	   				}
			   					
			   				
			   					
			   	   				
			   	   			}, "json");
						
	   					//listaParcelaPreFechamento(itensPreFechamento);
						}
						else
						{
						$.each(itensPreFechamento, function (key, value2)
									{
									if(deletaParcelaPreFechamento.fecdocto!=undefined && value2!=undefined)
									{
										if(deletaParcelaPreFechamento.fecdocto == value2.fecdocto)
										{
													itensPreFechamento.remove(key);
										}
									}



								});
						}
						
							listaParcelaPreFechamento(itensPreFechamento);
							$('#btnExcluirParcela').unbind('click');



						});
				
				$("input[name='btnAlterarParcela']").click(function()
						{
								var id = $(this).attr('id');
								var jsonText = $("input[id='itemPreFechamento"+id+"']").val();
								var parcelaPreFechamento =  eval('(' + jsonText + ')');

								$('#fecdata').val(parcelaPreFechamento.fecdata);
								$('#listaFormaPagamento').val(parcelaPreFechamento.fecforma);
								if(parcelaPreFechamento.fecdocto=='101')
								{
								$('#fecdocto').val(parcelaPreFechamento.fecdocto);
								}
								else
									if(parcelaPreFechamento.fecdocto=='102')
									{
										('#listaBandeiraCartao').val(parcelaPreFechamento.fecdocto);	
									}
									else
										if(parcelaPreFechamento.fecdocto=='103')
										{
											('#feccheque').val(parcelaPreFechamento.fecdocto);	
										}
										else
											if(parcelaPreFechamento.fecdocto=='110')
											{
												('#feccheque').val(parcelaPreFechamento.fecdocto);
											}
								
								$('#fecbanco').val(parcelaPreFechamento.fecbanco);
								$('#fecvalor').val($.mask.string(parcelaPreFechamento.fecvalor, 'decimal'));
								$('#fecvecto').val(parcelaPreFechamento.fecvecto);
								$('#fecdata').val(parcelaPreFechamento.fecdata);
								$('#clicodigo').val(parcelaPreFechamento.clicodigo);
								$('#vencodigo').val(parcelaPreFechamento.vencodigo);
								$('#fectipo').val(parcelaPreFechamento.fectipo);
								$('#fecagencia').val(parcelaPreFechamento.fecagencia);
								$('#fecempresa').val(parcelaPreFechamento.fecempresa);
								$('#feccaixa').val(parcelaPreFechamento.feccaixa);
								$('#feccartao').val(parcelaPreFechamento.feccartao);
								$('#fecconta').val(parcelaPreFechamento.fecconta);
								$('#fecdia').val(parcelaPreFechamento.fecdia);
								$('#fecdocto').val(parcelaPreFechamento.fecdocto);
								
								$("#btnAlteraParcela").click(function()
											{
										$.each(itensPreFechamento, function (key, value2)
												{
												if(parcelaPreFechamento.fecdocto!=undefined && value2!=undefined)
												{
													if(parcelaPreFechamento.fecdocto==value2.fecdocto)
													{
														itensPreFechamento.remove(key);
													}
												}
											});

									var parcelasE = new Object();

									parcelasE.fecdata = $('#fecdata').val();
									parcelasE.pvnumero = pedido.pvnumero;
									parcelasE.fecforma = $('#listaFormaPagamento').val();
									if(parcelasE.fecforma=='101')
									{
									parcelasE.fecdocto = $('#fecdocto').val();
									}
									else
										if(parcelasE.fecforma=='102')
										{
										parcelasE.fecdocto = $('#listaBandeiraCartao').val();
										if(parcelasE.fecdocto=='1')
										{

											parcelasE.fecdocto = 'REDESHOP';

										}
										else
											if(parcelasE.fecdocto=='2')
											{
												//preFechamentoparcela.feccartao = $('#listaBandeiraCartao').val();
												parcelasE.fecdocto = 'REDECARD A VISTA';
											}
											else
												if(parcelasE.fecdocto=='3')
												{
													//preFechamentoparcela.feccartao = $('#listaBandeiraCartao').val();
													parcelasE.fecdocto = 'REDECARD PARCELADO';
												}
												else
													if(parcelasE.fecdocto=='4')
													{
														//preFechamentoparcela.feccartao = $('#listaBandeiraCartao').val();
														parcelasE.fecdocto = 'REDECARD ASS.ARQUIVO';
													}
													else
														if(parcelasE.fecdocto=='5')
														{
															//preFechamentoparcela.feccartao = $('#listaBandeiraCartao').val();
															parcelasE.fecdocto = 'VISA ELECTRON';
														}
														else
															if(parcelasE.fecdocto=='6')
															{
																//preFechamentoparcela.feccartao = $('#listaBandeiraCartao').val();
																parcelasE.fecdocto = 'VISA A VISTA';
															}
															else
																if(parcelasE.fecdocto=='7')
																{
																	//preFechamentoparcela.feccartao = $('#listaBandeiraCartao').val();
																	parcelasE.fecdocto = 'VISA PARCELADO';
																}
																else
																	if(parcelasE.fecdocto=='8')
																	{
																		//preFechamentoparcela.feccartao = $('#listaBandeiraCartao').val();
																		parcelasE.fecdocto = 'VISA ASS.ARQUIVO';
																	}
																	else
																		if(parcelasE.fecdocto=='9')
																		{
																			//preFechamentoparcela.feccartao = $('#listaBandeiraCartao').val();
																			parcelasE.fecdocto = 'AMERICAN EXPRESS';
																		}
																		else
																			if(parcelasE.fecdocto=='10')
																			{
																				//preFechamentoparcela.feccartao = $('#listaBandeiraCartao').val();
																				parcelasE.fecdocto = 'INTERNET VISA';
																			}
																			else
																				if(parcelasE.fecdocto=='11')
																				{
																					//preFechamentoparcela.feccartao = $('#listaBandeiraCartao').val();
																					parcelasE.fecdocto = 'INTERNET MASTER';
																				}
																				else
																					if(parcelasE.fecdocto=='12')
																					{
																						//preFechamentoparcela.feccartao = $('#listaBandeiraCartao').val();
																						parcelasE.fecdocto = 'AMERICAN PARCELADO';
																					}
																					else
																						if(parcelasE.fecdocto=='13')
																						{
																							//preFechamentoparcela.feccartao = $('#listaBandeiraCartao').val();
																							parcelasE.fecdocto = 'INTERNET AMERICAN';
																						}
																						else
																							if(parcelasE.fecdocto=='14')
																							{
																								//preFechamentoparcela.feccartao = $('#listaBandeiraCartao').val();
																								parcelasE.fecdocto = 'INTERNET DINERS';
																							}
																							else
																								if(parcelasE.fecdocto=='15')
																								{
																									//preFechamentoparcela.feccartao = $('#listaBandeiraCartao').val();
																									parcelasE.fecdocto = 'REDECARD ASS.A.PARC';
																								}
																								else
																								{
																									parcelasE.fecdocto = null;
																								}
										}
										else
											if(parcelasE.fecforma=='103')
											{
											parcelasE.fecdocto = $('#feccheque').val();
											}
											else
												if(parcelasE.fecforma=='110')
												{
												parcelasE.fecdocto = $('#feccheque').val();
												}
												else
													{
													parcelasE.fecdocto = $('#fecdocto').val();
													}

									parcelasE.fecbanco = $('#fecbanco').val();
									parcelasE.fecvalor = decimalToNumber($('#fecvalor').val());
									tipoVencimento = $('input[name=opcaoVencimento]:checked').val();
									if(tipoVencimento=='1')
									{
									parcelasE.fecvecto = null;
									parcelasE.fecdia = $('#fecdia').val();
									}
									else
										if(tipoVencimento=='2')
										{
											parcelasE.fecvecto = $('#fecvecto').val();
											parcelasE.fecdia = 0;
										}
									parcelasE.clicodigo = pedido.cliente.clicodigo;
									parcelasE.vencodigo = pedido.vendedor.vencodigo;
									parcelasE.fectipo = $('#fectipo').val();
									parcelasE.fecagencia = $('#fecagencia').val();
									parcelasE.fecempresa = $('#fecempresa').val();
									parcelasE.feccaixa = $('#feccaixa').val();
									parcelasE.feccartao = $('#feccartao').val();
									parcelasE.fecconta = $('#fecconta').val();
									

									itensPreFechamento.push(parcelasE);
									listaParcelaPreFechamento(itensPreFechamento);

									$('#btnAlteraParcela').unbind('click');
									
									limpaform()
											});

						});
	}


	listaParcelaPreFechamento(itensPreFechamento);







$("#btnIncluirParcela").click(function()
						{

							var msg="";
							var forma = $('#listaFormaPagamento').val();

							if(forma == "0")
							{
								msg = "<br /> - SELECIONE A FORMA DE PAGAMENTO";
								alert("SELECIONE A FORMA DE PAGAMENTO");
								$("#retorno").messageBox(msg,false, false);
								return false;
							}
							if(forma=="100" || forma=="111"  || forma=="112")
							{
								if($('#fecvalor').val()==undefined ||$('#fecvalor').val()==null ||$('#fecvalor').val()=="")
								{
									msg = "<br /> - PREEENCHA O VALOR DA PARCELA";
									alert("PREEENCHA O VALOR DA PARCELA");
									$("#retorno").messageBox(msg,false, false);
									return false;
								}

							}
							else
								if(forma=="101")
								{

									if($('#fecvalor').val()==undefined ||$('#fecvalor').val()==null ||$('#fecvalor').val()=="")
									{
										msg = "<br /> - PREEENCHA O VALOR DA PARCELA";
										alert("PREEENCHA O VALOR DA PARCELA");
										$("#retorno").messageBox(msg,false, false);
										return false;
									}
									if($('#fecdocto').val()==undefined ||$('#fecdocto').val()==null ||$('#fecdocto').val()=="")
									{
										msg = "<br /> - PREEENCHA O NUMERO DO DOCUMENTO";
										alert("PREEENCHA O NUMERO DO DOCUMENTO");
										$("#retorno").messageBox(msg,false, false);
										return false;
									}
									if($('#listaTipoDuplicata').val()=="0")
									{
										msg = "<br /> - SELECIONE O TIPO DE DUPLICATA";
										alert("SELECIONE O TIPO DE DUPLICATA");
										$("#retorno").messageBox(msg,false, false);
										return false;
									}

									if($('#fecvecto').val()==undefined ||$('#fecvecto').val()==null ||$('#fecvecto').val()=="")
									{
										msg = "<br /> - PREEENCHA O VENCIMENTO DA DUPLICATA";
										alert("PREEENCHA O VENCIMENTO DA DUPLICATA");
										$("#retorno").messageBox(msg,false, false);
										return false;
									}
									if($('#fecdia').val()==undefined ||$('#fecdia').val()==null ||$('#fecdia').val()=="")
									{
										msg = "<br /> - PREEENCHA O SALTO DA DUPLICATA";
										alert("PREEENCHA O SALTO DA DUPLICATA");
										$("#retorno").messageBox(msg,false, false);
										return false;
									}

								}
								else
									if(forma=="102")
									{
										if($('#fecvalor').val()==0,00 ||$('#fecvalor').val()==0 ||$('#fecvalor').val()=="")
										{
											msg = "<br /> - PREEENCHA O VALOR DA PARCELA";
											alert("PREEENCHA O VALOR DA PARCELA");
											$("#retorno").messageBox(msg,false, false);
											return false;
										}
										if($('#listaTipoParcelamento').val()=="0")
										{
											msg = "<br /> - SELECIONE O TIPO DE PARCELA";
											alert("SELECIONE O TIPO DE PARCELA");
											$("#retorno").messageBox(msg,false, false);
											return false;
										}
										if($('#fecvalor').val()==undefined ||$('#fecvalor').val()==null ||$('#fecvalor').val()=="")
										{
											msg = "<br /> - SELECIONE A BANDEIRA DO CARTÃO";
											alert("SELECIONE A BANDEIRA DO CARTÃO");
											$("#retorno").messageBox(msg,false, false);
											return false;
										}
										if($('#fecvecto').val()==undefined ||$('#fecvecto').val()==null ||$('#fecvecto').val()=="")
										{
											msg = "<br /> - PREEENCHA O VENCIMENTO DA PARCELA DO CARTÃO";
											alert("PREEENCHA O VENCIMENTO DA PARCELA DO CARTÃO");
											$("#retorno").messageBox(msg,false, false);
											return false;
										}
										if($('#fecdia').val()==undefined ||$('#fecdia').val()==null ||$('#fecdia').val()=="")
										{
											msg = "<br /> - PREEENCHA O SALTO DA PARCELA DO CARTÃO";
											alert("PREEENCHA O SALTO DA PARCELA DO CARTÃO");
											$("#retorno").messageBox(msg,false, false);
											return false;
										}
									}
									else
										if(forma=="103")
										{
											if($('#fecvalor').val()==undefined ||$('#fecvalor').val()==null ||$('#fecvalor').val()=="")
											{
												msg = "<br /> - PREEENCHA O VALOR DA PARCELA";
												alert("PREEENCHA O VALOR DA PARCELA");
												$("#retorno").messageBox(msg,false, false);
												return false;
											}
											if($('#feccheque').val()==undefined ||$('#feccheque').val()==null ||$('#feccheque').val()=="")
											{
												msg = "<br /> - PREENCHA O NUMERO DO CHEQUE";
												alert("PREENCHA O NUMERO DO CHEQUE");
												$("#retorno").messageBox(msg,false, false);
												return false;
											}
											if($('#fecbanco').val()==undefined ||$('#fecbanco').val()==null ||$('#fecbanco').val()=="")
											{
												msg = "<br /> - PREENCHA O BANCO";
												alert("PREENCHA O BANCO");
												$("#retorno").messageBox(msg,false, false);
												return false;
											}
											if($('#fecagencia').val()==undefined ||$('#fecagencia').val()==null ||$('#fecagencia').val()=="")
											{
												msg = "<br /> - PREEENCHA A AGENCIA";
												alert("PREEENCHA A AGENCIA");
												$("#retorno").messageBox(msg,false, false);
												return false;
											}
											if($('#fecconta').val()==undefined ||$('#fecconta').val()==null ||$('#fecconta').val()=="")
											{
												msg = "<br /> - PREEENCHA A CONTA";
												alert("PREEENCHA A CONTA");
												$("#retorno").messageBox(msg,false, false);
												return false;
											}
											if($('#fecvecto').val()==undefined ||$('#fecvecto').val()==null ||$('#fecvecto').val()=="")
											{
												msg = "<br /> - PREEENCHA O VENCIMENTO";
												alert("PREEENCHA O VENCIMENTO");
												$("#retorno").messageBox(msg,false, false);
												return false;
											}

											if($('#fecdia').val()==undefined ||$('#fecdia').val()==null ||$('#fecdia').val()=="")
											{
												msg = "<br /> - PREEENCHA O SALTO DA PARCELA";
												alert("PREEENCHA O SALTO DA PARCELA");
												$("#retorno").messageBox(msg,false, false);
												return false;
											}
										}
										else
											if(forma=="104")
											{
												if($('#fecvalor').val()==undefined ||$('#fecvalor').val()==null ||$('#fecvalor').val()=="")
												{
													msg = "<br /> - PREEENCHA O VALOR DA PARCELA";
													alert("PREEENCHA O VALOR DA PARCELA");
													$("#retorno").messageBox(msg,false, false);
													return false;
												}

											}

							var preFechamentoparcela = new Object();

							preFechamentoparcela.fecdata = $('#fecdata').val();
							preFechamentoparcela.pvnumero = pedido.pvnumero;
							preFechamentoparcela.fecforma = $('#listaFormaPagamento').val();
							preFechamentoparcela.fectipoParcela = $('#listaTipoParcelamento').val();
							preFechamentoparcela.tipoDuplicata = $('#listaTipoDuplicata').val();
							
							if($('#listaFormaPagamento').val()== 100 || $('#listaFormaPagamento').val()== 111 || $('#listaFormaPagamento').val()== 112)
							{
								preFechamentoparcela.fecdocto = $('#fecdocto').val();
							}
							else
							if($('#listaFormaPagamento').val()== 101)
							{
								preFechamentoparcela.fecdocto = $('#fecdocto').val();
							}
							else
							if($('#listaFormaPagamento').val()== 102)
							{
								preFechamentoparcela.fecdocto = $('#listaBandeiraCartao').val();
								if(preFechamentoparcela.fecdocto=='1')
								{
									preFechamentoparcela.feccartao = $('#listaBandeiraCartao').val();
									preFechamentoparcela.fecdocto = REDESHOP;

								}
								else
									if(preFechamentoparcela.fecdocto=='2')
									{
										preFechamentoparcela.feccartao = $('#listaBandeiraCartao').val();
										preFechamentoparcela.fecdocto = 'REDECARD A VISTA';
									}
									else
										if(preFechamentoparcela.fecdocto=='3')
										{
											preFechamentoparcela.feccartao = $('#listaBandeiraCartao').val();
											preFechamentoparcela.fecdocto = 'REDECARD PARCELADO';
										}
										else
											if(preFechamentoparcela.fecdocto=='4')
											{
												preFechamentoparcela.feccartao = $('#listaBandeiraCartao').val();
												preFechamentoparcela.fecdocto = 'REDECARD ASS.ARQUIVO';
											}
											else
												if(preFechamentoparcela.fecdocto=='5')
												{
													preFechamentoparcela.feccartao = $('#listaBandeiraCartao').val();
													preFechamentoparcela.fecdocto = 'VISA ELECTRON';
												}
												else
													if(preFechamentoparcela.fecdocto=='6')
													{
														preFechamentoparcela.feccartao = $('#listaBandeiraCartao').val();
														preFechamentoparcela.fecdocto = 'VISA A VISTA';
													}
													else
														if(preFechamentoparcela.fecdocto=='7')
														{
															preFechamentoparcela.feccartao = $('#listaBandeiraCartao').val();
															preFechamentoparcela.fecdocto = 'VISA PARCELADO';
														}
														else
															if(preFechamentoparcela.fecdocto=='8')
															{
																preFechamentoparcela.feccartao = $('#listaBandeiraCartao').val();
																preFechamentoparcela.fecdocto = 'VISA ASS.ARQUIVO';
															}
															else
																if(preFechamentoparcela.fecdocto=='9')
																{
																	preFechamentoparcela.feccartao = $('#listaBandeiraCartao').val();
																	preFechamentoparcela.fecdocto = 'AMERICAN EXPRESS';
																}
																else
																	if(preFechamentoparcela.fecdocto=='10')
																	{
																		preFechamentoparcela.feccartao = $('#listaBandeiraCartao').val();
																		preFechamentoparcela.fecdocto = 'INTERNET VISA';
																	}
																	else
																		if(preFechamentoparcela.fecdocto=='11')
																		{
																			preFechamentoparcela.feccartao = $('#listaBandeiraCartao').val();
																			preFechamentoparcela.fecdocto = 'INTERNET MASTER';
																		}
																		else
																			if(preFechamentoparcela.fecdocto=='12')
																			{
																				preFechamentoparcela.feccartao = $('#listaBandeiraCartao').val();
																				preFechamentoparcela.fecdocto = 'AMERICAN PARCELADO';
																			}
																			else
																				if(preFechamentoparcela.fecdocto=='13')
																				{
																					preFechamentoparcela.feccartao = $('#listaBandeiraCartao').val();
																					preFechamentoparcela.fecdocto = 'INTERNET AMERICAN';
																				}
																				else
																					if(preFechamentoparcela.fecdocto=='14')
																					{
																						preFechamentoparcela.feccartao = $('#listaBandeiraCartao').val();
																						preFechamentoparcela.fecdocto = 'INTERNET DINERS';
																					}
																					else
																						if(preFechamentoparcela.fecdocto=='15')
																						{
																							preFechamentoparcela.feccartao = $('#listaBandeiraCartao').val();
																							preFechamentoparcela.fecdocto = 'REDECARD ASS.A.PARC';
																						}
																						else
																						{
																							preFechamentoparcela.feccartao = null;
																						}
						}
							else
							if($('#listaFormaPagamento').val()== '103')
							{
								preFechamentoparcela.fecdocto = $('#feccheque').val();
							}
							else
							if($('#listaFormaPagamento').val()== '110')
							{
								preFechamentoparcela.fecdocto = $('#feccheque').val();
							}
							else
							if($('#listaFormaPagamento').val()== '104')
							{
								preFechamentoparcela.fecdocto = $('#fecdocto').val();
							}
							else
								if($('#listaFormaPagamento').val()== '105')
								{
									preFechamentoparcela.fecdocto = $('#fecdocto').val();
								}

							preFechamentoparcela.fecbanco = $('#fecbanco').val();
							preFechamentoparcela.fecvalor = $.mask.string($('#fecvalor').val(),'decimal');
							
							tipoVencimento = $('input[name=opcaoVencimento]:checked').val();
							if(tipoVencimento=='1')
							{
							preFechamentoparcela.fecvecto = null;
							preFechamentoparcela.fecdia = $('#fecdia').val();
							}
							else
								if(tipoVencimento=='2')
								{
									preFechamentoparcela.fecvecto = $('#fecvecto').val();
									preFechamentoparcela.fecdia = 0;
								}
							preFechamentoparcela.clicodigo = pedido.cliente.clicodigo;
							preFechamentoparcela.vencodigo = pedido.vendedor.vencodigo;
							preFechamentoparcela.pvnumero = pedido.pvnumero;
							preFechamentoparcela.fectipo = $('#fectipo').val();
							preFechamentoparcela.fecagencia = $('#fecagencia').val();
							preFechamentoparcela.fecempresa = $('#fecempresa').val();
							preFechamentoparcela.feccaixa = $('#feccaixa').val();
							preFechamentoparcela.feccartao = $('#feccartao').val();
							preFechamentoparcela.fecconta = $('#fecconta').val();
						
							$.post('modulos/vendaAtacado/pedidos/pagamento/controller/acoes.php',
								{

				   				//variaveis a ser enviadas metodo POST
								preFechamentoparcela:JSON.stringify(preFechamentoparcela),
				   				acao:3

				   				},
				   				function(data)
				   				{
				   					
				   					//alert('PREFECHAMENTO EFETUADO COM SUCSSO');
				   					if (Boolean(Number(data.retorno)))
				   					{
				   						
				   					pedido.cliente.devolucaoVales = new Object();
				   					pedido.cliente.devolucaoVales = data.vales;
				   					doctoVale = data.docto;
				   					
				   					pedido.preFechamento = new Object();
				   					pedido.preFechamento = data.preFechamentos;
				   					
				   					
				   			
				   					}
				   					else
				   	   				{
				   	   					
				   						alert('NÃO FOI POSSIVEL DELETAR O VALE');
				   	   				}
	
				   	   				
				   	   			}, "json");
							
							
							
//							}
							
							msg = "<br /> - PARCELA EDITADA COM SUCESSO";
							alert('PARCELA EDITADA COM SUCESSO');
							$("#retorno").messageBox(msg,true, true);

							listaParcelaPreFechamento(itensPreFechamento);
							//$('#btnIncluirParcela').unbind('click');
							limpaform();

					});


	});

});
