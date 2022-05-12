/**
 * @author Wellington
 *
 * Verifica??o dos dados para envio de formulario.
 *
 * Cria??o    15/12/2009
 * Modificado 15/12/2009
 *
 */

	var itensFormaPagamento = new Array();
	var formaPagamento = new Object();
	var itemFormaPagamento = new Object();
	var condicaoComercialPreFechamento = new Object();
$(function(){



	$("#btnIncluirFormaPagamento").click(function()
	{

            verPrefec = pedido.preFechamento;
            var valPrefec = 0;


            if(verPrefec){
                     $.each(pedido.preFechamento, function (key, value) {
                   //                 if(value.fecforma!=105)  {
                                    if(value.fecforma==101)  {
                                               valPrefec++;
                                          }
                    });
               }

            if (pedido.cliente.clipessoa == '1'  && pedido.tipoPedido.sigla!='D') {
                 dataSintegra = "";
                 dataReceita = "";
                 clisintegrasituacaocadastral = pedido.cliente.clisintegrasituacaocadastral;
                 clireceitasituacaocadastral = pedido.cliente.clireceitasituacaocadastral;
		 clisintegradataultimaconsulta = pedido.cliente.clisintegradataultimaconsulta;
                 clireceitadataultimaconsulta = pedido.cliente.clireceitadataultimaconsulta;
                 cliie = pedido.cliente.cliie;

                                  prazolimite = 0;

                       $.each(pedido.cliente.prazoExpiracao.resultado, function (key, value2){

                                                                        if(value2.pedescricao === 'INTERFIX')
                                                                                {
                                                                                        prazolimite = value2.peprazo;

                                                                                }
                                                                        });

                 limite = new Date();
                 limite = limite.setDate(limite.getDate()-prazolimite);
                 limite = new Date(limite);

//                 limite = new Date();
//                 limite.setDate(limite.getDate()-30);
//                 limite = new Date(limite);

                 interfixNaoConsultado = false;
                 dataReceita  = "";
                 dataSintegra  = "";

//				 alert("pedido.cliente.clisintegradataultimaconsulta: "+pedido.cliente.clisintegradataultimaconsulta +
//				 "\n pedido.cliente.clireceitadataultimaconsulta: "+ pedido.cliente.clireceitadataultimaconsulta );

//				 alert("clisintegradataultimaconsulta: "+clisintegradataultimaconsulta +
//				 "\n clireceitadataultimaconsulta: "+ clireceitadataultimaconsulta );

                 if (cliie.match(/([0-9])/i)) {
                    interfixNaoConsultado = false;
                    if (clisintegradataultimaconsulta != undefined && clisintegradataultimaconsulta != null && clisintegradataultimaconsulta !="" ) {
                        dataSintegra = clisintegradataultimaconsulta;
                        var tokens = dataSintegra.split("-");
                        var tokensSemHora = tokens[2].split(" ");
                        //var novaData = tokens[2]+"-"+tokens[1]+"-" + tokens[0];
                        dataSintegra = new Date (tokens[0],tokens[1],tokensSemHora[0]);
                    //dataSintegra = new Date (""+pedido.cliente.clisintegradataultimaconsulta);

                    } else {
                        interfixNaoConsultado = true;
                    }
                }

                 if (clireceitadataultimaconsulta != undefined && clireceitadataultimaconsulta != null && clireceitadataultimaconsulta !=""){
                                            dataReceita = clireceitadataultimaconsulta;
                                            var tokens2 = dataReceita.split("-");
                                            var tokens2SemHora = tokens2[2].split(" ");
                                            //var novaData2 = tokens2[2]+"-"+tokens2[1]+"-" + tokens2[0];
                                            dataReceita = new Date (tokens2[0],tokens2[1],tokens2SemHora[0]);
                                            //dataReceita = new Date (""+pedido.cliente.clireceitadataultimaconsulta);
                                    }
                                    else {
                                        interfixNaoConsultado = true;
                                    }

//				alert("dataSintegra: "+dataSintegra +"\n dataReceita: "+ dataReceita +"\n limite: "+limite);

//				alert ( dataSintegra < limite ||  dataReceita < limite);

                if (interfixNaoConsultado == true) {

				                msg = "CLIENTE NAO CONSULTADO NO INTERFIX.";
                                                alert('CLIENTE SEM CONSULTA NO INTERFIX');
                                                $("#retorno").messageBox(msg,false, false);
												$("#btnIncluirFormaPagamento").attr('disabled','');
                                                //msgPreFec +="CLIENTE NAO CONSULTADO NO INTERFIX";
                                                return false;

                                            } else if   ( (dataSintegra < limite && cliie.match(/([0-9])/i)) ||  dataReceita < limite ) {
                                                                    msg = "CLIENTE COM CONSULTA INTERFIX EXPIRADA.";
                                                                    alert('CLIENTE COM CONSULTA INTERFIX EXPIRADA');
                                                                    $("#retorno").messageBox(msg,false, false);
																	$("#btnIncluirFormaPagamento").attr('disabled','');
                                                                    //msgPreFec +="CLIENTE COM CONSULTA INTERFIX EXPIRADA";
                                                                    return false;

                                                                }
                                             else if   ( !clireceitasituacaocadastral.match(/ativ/i) ) {
                                                                    msg = "CLIENTE IRREGULAR NA RECEITA.";
                                                                    alert('CLIENTE IRREGULAR NA RECEITA');
                                                                    $("#retorno").messageBox(msg,false, false);
																	$("#btnIncluirFormaPagamento").attr('disabled','');
                                                                    //msgPreFec +="CLIENTE COM CONSULTA INTERFIX EXPIRADA";
                                                                    return false;

                                                                }
                                             else if   (cliie.match(/([0-9])/i) && (clisintegrasituacaocadastral == undefined || clisintegrasituacaocadastral == "" || clisintegrasituacaocadastral == null ||
                                                    clisintegrasituacaocadastral.match('/CANCEL|NAO|BAIXADO|FALH|INAB|IRREG|INAT|INVA|0/i'))
                                                     ) {
                                                                    msg = "CLIENTE IRREGULAR NO SINTEGRA.";
                                                                    alert('CLIENTE IRREGULAR NO SINTEGRA');
                                                                    $("#retorno").messageBox(msg,false, false);
																	$("#btnIncluirFormaPagamento").attr('disabled','');
                                                                    //msgPreFec +="CLIENTE COM CONSULTA INTERFIX EXPIRADA";
                                                                    return false;

                                                                }


            }


		$("#btnIncluirFormaPagamento").attr('disabled','disabled');

		var cont = 0;
		var exe = true;
		$.each(itensFormaPagamento, function (key, value)
		{
			cont ++;
			if (cont > 0)
			{
				exe = false;
			}
		});

		if ($('#formFormaPagamento').validate().form())
		{
			$('#txtValorDocumento').val($('#lblDiferencaPagar').text());

			if (exe)
			{


				itemFormaPagamento = new Object();
				itemFormaPagamento.duplicatas = new Array();
				//itemFormaPagamento.mista = new Array();
				itemFormaPagamento.brinde = new Array();
				itemFormaPagamento.cartao = new Array();
				itemFormaPagamento.chequesPre = new Array();
				itemFormaPagamento.vale = new Array();
				itemFormaPagamento.vale2 = new Array();
				itemFormaPagamento.ordemPagamento = new Object();

				itemFormaPagamento.formaPagamento = formaPagamento;
				itemFormaPagamento.condicaoComercial = tmpCondicaoComercial;
				itemFormaPagamento.numeroDocumento = $('#txtNumeroDocumento').val();
				itemFormaPagamento.valor = decimalToNumber($('#lblTotalPagar').text());
				itemFormaPagamento.pvnumero = pedido.pvnumero;
				itemFormaPagamento.vencodigo = pedido.vendedor.vencodigo;
				itemFormaPagamento.clicodigo = pedido.cliente.clicodigo;
				itemFormaPagamento.fectipo = 'A';
				itemFormaPagamento.valorst = decimalToNumber($('#txtValorSt').val());
				itemFormaPagamento.fecempresa = fecempresa;

				pedidoLibera = new Object();
				pedidoLibera.pvnumero = pedido.pvnumero;
				pedidoLibera.pvlibdep= null;
				pedidoLibera.pvlibmat= null;
				pedidoLibera.pvlibfil= null;
				pedidoLibera.pvlibvit= null;
				if(pedido.tipoPedido.sigla=='S')
				{
					if(pedido.estoqueDestino.estoqueFisico.etqfcodigo==1)
					{
						pedidoLibera.pvlibdep = 1;
					}
					else
						if(pedido.estoqueDestino.estoqueFisico.etqfcodigo==2)
						{
							pedidoLibera.pvlibmat = 1;
						}
						else
							if(pedido.estoqueDestino.estoqueFisico.etqfcodigo==3)
							{
								pedidoLibera.pvlibfil = 1;
							}
							else
								if(pedido.estoqueDestino.estoqueFisico.etqfcodigo==4)
								{
									pedidoLibera.pvlibvit = 1;
								}
				}
				else
					 if(pedido.tipoPedido.sigla=='I' && pedido.pvvinculo!=null)
					 {
						 pedidoLibera.pvlibdep = 1;
					 }else
				{

				$.each(pedido.itensPedido, function (key, value)
				{
				 if(value.pedidoVendaItemEstoque.pviest01 > '0')
				 {
					 pedidoLibera.pvlibfil = 1;
				 }
				 if(value.pedidoVendaItemEstoque.pviest02 > '0')
				 {
					 pedidoLibera.pvlibmat = 1;
				 }
//				 if(value.pedidoVendaItemEstoque.pviest09 > '0')
//				 {
//					 pedidoLibera.pvlibdep = 1;
//				 }
				 if(value.pedidoVendaItemEstoque.pviest011 > '0')
				 {
					 pedidoLibera.pvlibvit = 1;
				 }
                                 
                                 if(value.pedidoVendaItemEstoque.pviest026 > '0')
				 {
					 pedidoLibera.pvlibdep = 1;
				 }
				});

				}




				if($('#opcaoVencimento').val()=='0' || $('#opcaoVencimento').val()==null || $('#opcaoVencimento').val()==undefined)
				{
					msg = "SELECIONE O TIPO DE VENCIMENTO SE ? DIAS OU DATA";
				    alert('SELECIONE O TIPO DE VENCIMENTO SE ? DIAS OU DATA');
				   	$("#retorno").messageBox(msg,false, false);
				   	$("#btnIncluirFormaPagamento").attr('disabled','');
					return false;
				}

				if(itemFormaPagamento.formaPagamento==undefined || itemFormaPagamento.formaPagamento==null ||itemFormaPagamento.formaPagamento=="" ||itemFormaPagamento.formaPagamento=='0')
				{
					msg = "SELECIONE A FORMA DE PAGAMENTO";
				    alert('SELECIONE A FORMA DE PAGAMENTO');
				   	$("#retorno").messageBox(msg,false, false);
				   	$("#btnIncluirFormaPagamento").attr('disabled','');
					return false;

				}

				itemFormaPagamento.tipoVencimento = $('input[name=opcaoVencimento]:checked').val();

				dataPrefechamento = new Date();
				dataPrefechamento.date();
				fecdata = dataPrefechamento.format('Y-m-d');
				itemFormaPagamento.data = fecdata;
				itemFormaPagamento.caixa = 0;

//alert("No formaPgto \n valPrefec: "+valPrefec);

				if(Number(formaPagamento.pagcodigo)== DUPLICATAS)
				{




var contaParcelas = 0;
//						for (i = 1; i <= tmpCondicaoComercial.parcela; i++)
						for (i = 1; i <= (tmpCondicaoComercial.parcela - valPrefec); i++)
						{
//alert("No formaPgto \n valPrefec: "+valPrefec);
							letras = new Array(27);
							letras[0] = '0';
							letras[1] = 'A';
							letras[2] = 'B';
							letras[3] = 'C';
							letras[4] = 'D';
							letras[5] = 'E';
							letras[6] = 'F';
							letras[7] = 'G';
							letras[8] = 'H';
							letras[9] = 'I';
							letras[10] = 'J';
							letras[11] = 'K';
							letras[12] = 'L';
							letras[13] = 'M';
							letras[14] = 'N';
							letras[15] = 'O';
							letras[16] = 'P';
							letras[17] = 'Q';
							letras[18] = 'R';
							letras[19] = 'S';
							letras[20] = 'T';
							letras[21] = 'U';
							letras[22] = 'V';
							letras[23] = 'X';
							letras[24] = 'Y';
							letras[25] = 'Z';

							var duplicata = new Object();
							duplicata.valorParcela = decimalToNumber($('#txtParcelaDuplicata'+i+'').val());
							duplicata.numeroDocumento = $('#txtDocumentoDuplicata').val()+letras[i+valPrefec];
//alert("forma pgto \nvalPrefec"+valPrefec+"\nEscolhido a letra"+letras[i+valPrefec]);
							//duplicata.dataVencimento = $('#txtDataVencimentoDuplicata').val();
							if (i == 1)
							{
								salto = Number(tmpCondicaoComercial.inicial);
							}
							else
							{
                                                                salto += (Number(tmpCondicaoComercial.salto));

							}


							if(itemFormaPagamento.tipoVencimento=='1')
							{
//								duplicata.dataVencimento = null;
                                                                duplicata.dataVencimento =  new Date().dateBr($("input[name*='txtDataVencimentoDuplicata"+i+"']").val());
								duplicata.diasVencimento = ($("input[name*='txtVencimentoDuplicata"+i+"']").val());
							}
							else
							{
								duplicata.dataVencimento =  new Date().dateBr($("input[name*='txtDataVencimentoDuplicata"+i+"']").val());
								duplicata.diasVencimento = 0;
							}

							duplicata.descricaoTipo = $('#listaTipoDuplicata').text();

							if($('#listaTipoDuplicata').val()=='1' || $('#listaTipoDuplicata').val()==null || $('#listaTipoDuplicata').val()=='')
							{
								msg = "SELECIONE O TIPO DE DUPLICATA";
							    alert('SELECIONE O TIPO DE DUPLICATA');
							   	$("#retorno").messageBox(msg,false, false);
							   	$("#btnIncluirFormaPagamento").attr('disabled','');
								return false;
							}							
							
							if(duplicata.valorParcela =='' || duplicata.valorParcela <='0')
							{
								msg = "VALOR DA PARCELA DEVE SER ACIMA DE ZERO";
							    alert('VALOR DA PARCELA DEVE SER ACIMA DE ZERO');
							   	$("#retorno").messageBox(msg,false, false);
							   	$("#btnIncluirFormaPagamento").attr('disabled','');
								return false;
							}
							
							duplicata.fecbanco = $('#listaTipoDuplicata').val();
							itemFormaPagamento.duplicatas.push(duplicata);
contaParcelas++;
//alert("no for do FormaPagamento \n contaParcelas: "+contaParcelas
//+"\n itemFormaPagamento.tipoVencimento: "+itemFormaPagamento.tipoVencimento
//+"\n duplicata.dataVencimento: "+duplicata.dataVencimento
//);
						}
//alert("no formaPgto \n itemFormaPagamento.duplicatas.length:" + itemFormaPagamento.duplicatas.length);
				}

			//	if(Number(formaPagamento.pagcodigo)== MISTA)
				if(Number(formaPagamento.pagcodigo)== 10000000)  //Anulando MISTA
				{

//				for (i = 1; i <= tmpCondicaoComercial.parcela; i++)
				for (i = 1; i <= (tmpCondicaoComercial.parcela - valPrefec); i++)
				{
					letras = new Array(27);
					letras[0] = '0';
					letras[1] = 'A';
					letras[2] = 'B';
					letras[3] = 'C';
					letras[4] = 'D';
					letras[5] = 'E';
					letras[6] = 'F';
					letras[7] = 'G';
					letras[8] = 'H';
					letras[9] = 'I';
					letras[10] = 'J';
					letras[11] = 'K';
					letras[12] = 'L';
					letras[13] = 'M';
					letras[14] = 'N';
					letras[15] = 'O';
					letras[16] = 'P';
					letras[17] = 'Q';
					letras[18] = 'R';
					letras[19] = 'S';
					letras[20] = 'T';
					letras[21] = 'U';
					letras[22] = 'V';
					letras[23] = 'X';
					letras[24] = 'Y';
					letras[25] = 'Z';

					if($('#listaTipoParcelamento2'+i+'').val()=='0' || $('#listaTipoParcelamento2'+i+'').val()==null || $('#listaTipoParcelamento2'+i+'').val()=='')
					{
					msg = "SELECIONE O TIPO DE PAGAMENTO "+i+"? PARCELA";
					alert('SELECIONE O TIPO DE PAGAMENTO '+i+'? PARCELA');
					$("#retorno").messageBox(msg,false, false);
					$("#btnIncluirFormaPagamento").attr('disabled','');
					return false;
					}
						tipoPagamento2 = $('#listaTipoParcelamento2'+i+'').val();

						var mistas = new Object();
						if(tipoPagamento2 == A_VISTA || tipoPagamento2 == BRINDE || tipoPagamento2 == DESCONTOS_COMERCIAIS || tipoPagamento2 == DESCONTOS_FINANCEIRO)
						{
							mistas.fecforma = tipoPagamento2;

							mistas.dataVencimento =  new Date().dateBr($("input[name*='txtDataVencimentoDuplicata"+i+"']").val());
							mistas.diasVencimento = 0;

							mistas.valorParcela = decimalToNumber($('#txtParcelaDuplicata'+i+'').val());
							mistas.numeroDocumento = '';
//							mistas.dias = 0;
							mistas.diasVencimento = 0;
						}
						else if(tipoPagamento2 == DUPLICATAS)
						{
							mistas.fecforma = tipoPagamento2;
							mistas.valorParcela = decimalToNumber($('#txtParcelaDuplicata'+i+'').val());
//							mistas.numeroDocumento = $('#txtDocumentoDuplicata'+i+'').val()+letras[i];
							mistas.numeroDocumento = $('#txtDocumentoDuplicata'+i+'').val()+letras[i+valPrefec];
                                                        						

							if(itemFormaPagamento.tipoVencimento=='1')
							{
								mistas.diasVencimento = ($("input[name*='txtVencimentoDuplicata"+i+"']").val());
								mistas.dataVencimento =  null;
							}
							else
							{
								mistas.diasVencimento = 0;
								mistas.dataVencimento =  new Date().dateBr($("input[name*='txtDataVencimentoDuplicata"+i+"']").val());
							}
							mistas.codigoTipo = $('#listaTipoDuplicata').val();
							mistas.descricaoTipo = $('#listaTipoDuplicata').text();

							if($('#listaTipoDuplicata2'+i+'').val()=='0' || $('#listaTipoDuplicata2'+i+'').val()==null || $('#listaTipoDuplicata2'+i+'').val()=='')
							{
								msg = "SELECIONE O TIPO DE DUPLICATA";
							    alert('SELECIONE O TIPO DE DUPLICATA');
							   	$("#retorno").messageBox(msg,false, false);
							   	$("#btnIncluirFormaPagamento").attr('disabled','');
								return false;
							}
						}
						else if(tipoPagamento2 == CARTAO)
						{
							mistas.fecforma = tipoPagamento2;

							if($('#listaBandeirasCartoes'+i+'').val()=='0' || $('#listaBandeirasCartoes'+i+'').val()==null || $('#listaBandeirasCartoes'+i+'').val()==undefined)
							{
								msg = "SELECIONE A BANDEIRA DO CARTAO NA "+i+"? PARCELA";
							    alert('SELECIONE A BANDEIRA DO CARTAO NA '+i+'? PARCELA');
							   	$("#retorno").messageBox(msg,false, false);
							   	$("#btnIncluirFormaPagamento").attr('disabled','');
								return false;
							}

							mistas.codigoTipo = $('#listaTipoParcelamento'+i+'').val();
							mistas.valorParcela = decimalToNumber($('#txtParcelaDuplicata'+i+'').val());
//							mistas.valorParcela = decimalToNumber($('#txtParcelaCartao'+i+'').val());
							jsonText = $('#listaBandeirasCartoes'+i+'').val();
							jsonTxt = eval('(' + jsonText + ')');
							mistas.numeroDocumento =jsonTxt.carnome;
							mistas.feccartao = jsonTxt.carnumero;
							if(itemFormaPagamento.tipoVencimento=='1')
							{
								mistas.diasVencimento = ($("input[name*='txtVencimentoDuplicata"+i+"']").val());
//								mistas.diasVencimento = ($("input[name*='txtVencimentoCartao"+i+"']").val());
								mistas.dataVencimento =  null;
							}
							else
							{
								mistas.diasVencimento = 0;
								mistas.dataVencimento =  new Date().dateBr($("input[name*='txtDataVencimentoDuplicata"+i+"']").val());
//								mistas.dataVencimento =  new Date().dateBr($("input[name*='txtDataVencimentoCartao"+i+"']").val());
							}
							if($('#listaBandeirasCartoes'+i+'').val()=='0' || $('#listaBandeirasCartoes'+i+'').val()==null || $('#listaBandeirasCartoes'+i+'').val()==undefined)
							{
								msg = "SELECIONE A BANDEIRA DO CARTAO NA "+i+"? PARCELA";
							    alert('SELECIONE A BANDEIRA DO CARTAO NA '+i+'? PARCELA');
							   	$("#retorno").messageBox(msg,false, false);
							   	$("#btnIncluirFormaPagamento").attr('disabled','');
								return false;
							}
							if($('#listaTipoParcelamento'+i+'').val()=='0' || $('#listaTipoParcelamento'+i+'').val()==null || $('#listaTipoParcelamento').val()=='')
							{
							msg = "SELECIONE O TIPO DE PARCELA NA "+i+"? COLUNA";
							alert('SELECIONE O TIPO DE PARCELA '+i+'? COLUNA');
							$("#retorno").messageBox(msg,false, false);
							$("#btnIncluirFormaPagamento").attr('disabled','');
							return false;
							}
						}
						else if(tipoPagamento2 == CHEQUE_PRE)
						{
							mistas.fecforma = tipoPagamento2;
//							mistas.numeroDocumento = $("input[name*='txtNumeroDocFolha"+i+"']").val();
							mistas.numeroDocumento = $("input[name*='txtNumeroDocFolha"+Number(i+valPrefec)+"']").val();
							mistas.valorParcela = decimalToNumber($("input[name*='txtParcelaDuplicata"+i+"']").val());
							mistas.banco = $("input[name*='txtNumeroBanco"+i+"']").val();
							mistas.agencia = $("input[name*='txtNumeroAgencia"+i+"']").val();
							mistas.conta = $("input[name*='txtNumeroConta"+i+"']").val();
							if(itemFormaPagamento.tipoVencimento=='1')
							{
								mistas.diasVencimento = ($("input[name*='txtVencimentoDuplicata"+i+"']").val());
								mistas.dataVencimento =  null;
							}
							else
							{
								mistas.diasVencimento = 0;
								mistas.dataVencimento =  new Date().dateBr($("input[name*='txtDataVencimentoDuplicata"+i+"']").val());
							}

						}
						else if(tipoPagamento2 == CHEQUE_A_VISTA)
						{
							mistas.fecforma = tipoPagamento2;
							mistas.numeroDocumento = $("input[name*='txtNumeroDocFolha"+Number(i+valPrefec)+"']").val();
//							mistas.numeroDocumento = $("input[name*='txtNumeroDocFolha"+i+"']").val();
							mistas.valorParcela = decimalToNumber($("input[name*='txtParcelaDuplicata"+i+"']").val());
							mistas.banco = $("input[name*='txtNumeroBanco"+i+"']").val();
							mistas.agencia = $("input[name*='txtNumeroAgencia"+i+"']").val();
							mistas.conta = $("input[name*='txtNumeroConta"+i+"']").val();
							if(itemFormaPagamento.tipoVencimento=='1')
							{
								mistas.diasVencimento = ($("input[name*='txtVencimentoDuplicata"+i+"']").val());
								mistas.dataVencimento =  null;
							}
							else
							{
								mistas.diasVencimento = 0;
								mistas.dataVencimento =  new Date().dateBr($("input[name*='txtDataVencimentoDuplicata"+i+"']").val());
							}

						}
						else if(tipoPagamento2 == ORDEM_PAGAMENTO)
						{
							mistas.fecforma = tipoPagamento2;
							mistas.valorParcela = decimalToNumber($('#txtParcelaDuplicata'+i+'').val());
//							mistas.numeroDocumento = $('#txtDocumentoDuplicata'+i+'').val();
							mistas.numeroDocumento = $('#txtDocumentoDuplicata'+Number(i+valPrefec)+'').val();
							mistas.dataVencimento =  new Date().dateBr($("input[name*='txtDataVencimentoDuplicata"+i+"']").val());
							mistas.diasVencimento = 0;
						}
						
						itemFormaPagamento.mista.push(mistas);
						}
				}

				if(Number(formaPagamento.pagcodigo)== CARTAO)
				{
				for (i = 1; i <= tmpCondicaoComercial.parcela; i++)
//				for (i = 1; i <= (tmpCondicaoComercial.parcela - valPrefec); i++)
				{  
						var cartaos = new Object();
						cartaos.codigoTipo = $('#listaTipoParcelamento').val();
						cartaos.valorParcela = decimalToNumber($('#txtParcelaCartao'+i+'').val());
						//jsonText = $('#listaBandeirasCartoes'+i+'').val();
						//jsonTxt = eval('(' + jsonText + ')');
						//cartaos.numeroDocumento =jsonTxt.carnome;
						//cartaos.feccartao = jsonTxt.carnumero;

			                                    cartaos.feccartao = $("#listaBandeirasCartoes"+i+"' option:selected").val();
                                                cartaos.numeroDocumento =  $("#listaBandeirasCartoes"+i+"' option:selected").text();

						if(cartaos.feccartao=='' || cartaos.feccartao=='0')
						{
							msg = "SELECIONE A BANDEIRA DO CARTAO";
						    alert('SELECIONE A BANDEIRA DO CARTAO');
						   	$("#retorno").messageBox(msg,false, false);
						   	$("#btnIncluirFormaPagamento").attr('disabled','');
							return false;
						}
/*
							if(cartaos.feccartao=='1')
							{

								cartaos.numeroDocumento = 'REDESHOP';

							}
							else
								if(cartaos.feccartao=='2')
								{

									cartaos.numeroDocumento = 'REDECARD A VISTA';
								}
								else
									if(cartaos.feccartao=='3')
									{

										cartaos.numeroDocumento = 'REDECARD PARCELADO';
									}
									else
										if(cartaos.feccartao=='4')
										{

											cartaos.numeroDocumento = 'REDECARD ASS.ARQUIVO';
										}
										else
											if(cartaos.feccartao=='5')
											{

												cartaos.numeroDocumento = 'VISA ELECTRON';
											}
											else
												if(cartaos.feccartao=='6')
												{

													cartaos.numeroDocumento = 'VISA A VISTA';
												}
												else
													if(cartaos.feccartao=='7')
													{

														cartaos.numeroDocumento = 'VISA PARCELADO';
													}
													else
														if(cartaos.feccartao=='8')
														{

															cartaos.numeroDocumento = 'VISA ASS.ARQUIVO';
														}
														else
															if(cartaos.feccartao=='9')
															{

																cartaos.numeroDocumento = 'AMERICAN EXPRESS';
															}
															else
																if(cartaos.feccartao=='10')
																{

																	cartaos.numeroDocumento = 'INTERNET VISA';
																}
																else
																	if(cartaos.feccartao=='11')
																	{

																		cartaos.numeroDocumento = 'INTERNET MASTER';
																	}
																	else
																		if(cartaos.feccartao=='12')
																		{

																			cartaos.numeroDocumento = 'AMERICAN PARCELADO';
																		}
																		else
																			if(cartaos.feccartao=='13')
																			{

																				cartaos.numeroDocumento = 'INTERNET AMERICAN';
																			}
																			else
																				if(cartaos.feccartao=='14')
																				{

																					cartaos.numeroDocumento = 'INTERNET DINERS';
																				}
																				else
																					if(cartaos.feccartao=='15')
																					{
																						cartaos.numeroDocumento = 'REDECARD ASS.A.PARC';
																					}
*/






						if(itemFormaPagamento.tipoVencimento=='1')
						{
							cartaos.dataVencimento = null;
							cartaos.diasVencimento = $("input[name*='txtVencimentoCartao"+i+"']").val();
                                                           cartaos.dataVencimento = new Date().dateBr($("input[name*='txtdataVencimentoCartao"+i+"']").val());
						}
						else
						{
							cartaos.dataVencimento = new Date().dateBr($("input[name*='txtdataVencimentoCartao"+i+"']").val());
							cartaos.diasVencimento = 0;
						}

						if (i == 1)
						{
							salto = Number(tmpCondicaoComercial.inicial);
						}
						else
						{
                                                        salto += (Number(tmpCondicaoComercial.salto));

						}


						//cartaos.dataVencimento = itemFormaPagamento.dataVencimento.copy();
						//cartaos.dataVencimento.addDays(salto);
						//cartaos.diasVencimento = itemFormaPagamento.dataVencimento.getDaysBetween(cartaos.dataVencimento);
						if($('#listaTipoParcelamento').val()=='0' || $('#listaTipoParcelamento').val()==null || $('#listaTipoParcelamento').val()=='')
						{
							msg = "SELECIONE O TIPO DE PARCELA";
						    alert('SELECIONE O TIPO DE PARCELA');
						   	$("#retorno").messageBox(msg,false, false);
						   	$("#btnIncluirFormaPagamento").attr('disabled','');
							return false;
						}						
						
			//			alert("valPrefec: "+valPrefec);
						
						if( !cartaos.numeroDocumento.match(/REDESHOP|ELECTRON/ig) && cartaos.diasVencimento == '0' ){
							msg = "A QUANTIDADE EM DIAS DEVE SER DIFERENTE DE ZERO";
						    alert('A QUANTIDADE EM DIAS DEVE SER DIFERENTE DE ZERO');
						   	$("#retorno").messageBox(msg,false, false);
						   	$("#btnIncluirFormaPagamento").attr('disabled','');
							return false;
						} 
						
						if( cartaos.valorParcela == '0,00' || cartaos.valorParcela == '0.00' ){
							msg = "O VALOR DA PARCELA DEVE SER DIFERENTE DE ZERO";
						    alert('O VALOR DA PARCELA DEVE SER DIFERENTE DE ZERO');
						   	$("#retorno").messageBox(msg,false, false);
						   	$("#btnIncluirFormaPagamento").attr('disabled','');
							return false;
						} 
		/*				
alert("cartaos.feccartao: "+cartaos.feccartao
+"\n cartaos.numeroDocumento: "+cartaos.numeroDocumento
);						

alert("cartaos.diasVencimento: "+cartaos.diasVencimento);




						if( cartaos.numeroDocumento.match("//i"))
						{
							
						}*/
						
						itemFormaPagamento.cartao.push(cartaos);
						}

				}

				if(Number(formaPagamento.pagcodigo)== CHEQUE_PRE || Number(formaPagamento.pagcodigo)== CHEQUE_A_VISTA)
				{
					

						for (i = 1; i <= tmpCondicaoComercial.parcela; i++)
//						for (i = 1; i <= (tmpCondicaoComercial.parcela - valPrefec); i++)
						{
							chequePre = new Object();

//							chequePre.numeroDocumento = $("input[name*='txtNumeroDocFolha"+i+"']").val();
							chequePre.numeroDocumento = $("input[name*='txtNumeroDocFolha"+Number(i+valPrefec)+"']").val();
							chequePre.valorParcela = decimalToNumber($("#txtValorDocFolha"+i+"").val());
							chequePre.banco = $("input[name*='txtNumeroBanco"+i+"']").val();
							chequePre.agencia = $("input[name*='txtNumeroAgencia"+i+"']").val();
							chequePre.conta = $("input[name*='txtNumeroConta"+i+"']").val();
							
							/*
							if(itemFormaPagamento.tipoVencimento=='1')
							{
							chequePre.dataVencimento =  null;
							chequePre.diasVencimento = $("input[name*='txtSaltoFolha"+i+"']").val();
							}
							else
							*/
							
							chequePre.dataVencimento =  new Date().dateBr($("input[name*='txtDataFolha"+i+"']").val());
							hoje =  new Date().dateBr();
							
							teste = chequePre.dataVencimento.getTime() <= hoje.getTime();
							
							chPreTime = chequePre.dataVencimento.getTime();
							hojeTime = hoje.getTime();
	
							chequePre.diasVencimento = 0;
							
							
							
							
							
						if( Number(formaPagamento.pagcodigo)== CHEQUE_PRE && ( chequePre.dataVencimento.getTime() <= hoje.getTime() )) {
							
								msg = "DATA DO VENCIMENTO DEVE SER POSTERIOR A DATA DE HOJE";
								alert('DATA DO VENCIMENTO DEVE SER POSTERIOR A DATA DE HOJE');
								$("#retorno").messageBox(msg,false, false);
								$("#btnIncluirFormaPagamento").attr('disabled','');
								return false;
							
						}
							
							
					
							
						itemFormaPagamento.chequesPre.push(chequePre);
						}
						

				}

				if(Number(formaPagamento.pagcodigo)==ORDEM_PAGAMENTO)
				{

						var ordem = new Object();
						vencimento = $('#txtVencimentoOrdemPagamento').val();
						vencimento = new Date();
						vencimento.date();
						ordem.vencimento = vencimento.format('Y-m-d');


						ordem.valor = decimalToNumber($('#valorOrderPagamento').val());
						ordem.numeroDocumento = $('#txtDocumentoOrderPagamento').val();
//						ordem.dias = 0;
						ordem.diasVencimento = 0;
						itemFormaPagamento.ordemPagamento= ordem;

				}

				if(Number(formaPagamento.pagcodigo)==A_VISTA || Number(formaPagamento.pagcodigo)==BRINDE || Number(formaPagamento.pagcodigo)==DESCONTOS_COMERCIAIS || Number(formaPagamento.pagcodigo)==DESCONTOS_FINANCEIRO )
				{

						var ordem = new Object();
						vencimento = $('#txtVencimentoOrdemPagamento').val();
						vencimento = new Date();
						vencimento.date();
						ordem.vencimento = vencimento.format('Y-m-d');


						ordem.valor = decimalToNumber($('#valorOrderPagamento').val());
						ordem.numeroDocumento = $('#txtDocumentoOrderPagamento').val();
//						ordem.dias = 0;
						ordem.diasVencimento = 0;
						itemFormaPagamento.ordemPagamento= ordem;

				}

				if(Number(formaPagamento.pagcodigo)== VALES)
				{

						for(i=0; i< jsTxt.length; i++)
						{
							aVale = jsTxt[i].split('|');

							var aNum = aVale[0];
							var aDvnum = aVale[1];
							var aValor = aVale[2];
							var aVale = aVale[3];
							var vales = new Object();

							vales.numero = aNum;
							vales.dvnumero = aDvnum;
							vales.valor = aValor;
							vales.vale = aVale;


							if(itemFormaPagamento.tipoVencimento=='1')
							{
								vales.dataVencimento = null;
								vales.diasVencimento = '1';
							}
							else
							{
								vales.dataVencimento =  new Date().dateBr($('#txtDataVencimento').val());
								vales.diasVencimento = '0';
							}



							itemFormaPagamento.vale.push(vales);


					}
				}






				$("#txtValorDocumento").val($.mask.string(0, 'decimal'));
				$("#listaFormaPagamento").val('');
				//$('#detalhesFormaPagamento').html('');
			}
			else
			{
				$('#dialog').dialog("open");
			}
		}
		
						var usuarioPrefechamento = new Object();
						usuarioPrefechamento.usuario = usuario.codigo;
						usuarioPrefechamento.senha = $('#alteraSalto').val();

		
   		$.post('modulos/vendaAtacado/pedidos/manutencao/controller/acoes.php',
   				{

				
   				//variaveis a ser enviadas metodo POST
   				itemFormaPagamento:JSON.stringify(itemFormaPagamento),
   				pedidoLiberas:JSON.stringify(pedidoLibera),
				usuarioPrefechamento:JSON.stringify(usuarioPrefechamento),
   				acao:5

   				},
   				function(data)
   				{

   					//alert('PREFECHAMENTO EFETUADO COM SUCSSO');
   					if (Boolean(Number(data.retorno)))
   					{
   						//retornando no debaixo
   						//alert('0');
						$('#alteraSalto').val('');
   						pedido.preFechamento = new Object();
   						pedido.preFechamento = data.preFechamentos.preFechamentos;

   						pedido.cliente.devolucaoVales = new Object();
	   					pedido.cliente.devolucaoVales = data.vales.vales;

	   					itemFormaPagamento.formaPagamento = new Object();
	   					formaPagamento = new Object();


   						$("#retorno").messageBox(data.preFechamentos.mensagem,true,true);

   						var tmpValorTotal2 = (pedido.pvvalor - pedido.pvvaldesc);
   						pedido.TotalValorPreFechamento = data.preFechamentos.total;

	   				$("#lblTotalPagar").text(tmpValorTotal2.toFixed(2));
	   				$("#lblTotalPago").text(pedido.TotalValorPreFechamento);
	   				diferenca1 = $("#lblTotalPagar").text() - $("#lblTotalPago").text();
	   				diferenca = Number(diferenca1);
	   				$("#lblDiferencaPagar").text(diferenca.toFixed(2));





                                        totalValorPreFechamento = 0;

                                         $.each(pedido.preFechamento, function (key, value) {
                                                        if (value.fecforma != '100' && value.fecforma != '102' && value.fecforma != '105' && value.fecforma != '106' && value.fecforma != '111' && value.fecforma != '112') {
                                                                totalValorPreFechamento += Number(value.fecvalor);

                                                        }
                                         });


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


   				    }
   					else
   					{


   						//alert('1');
   					//retorno da inclusao do prefechamento
   						pedido.preFechamento = new Object();
   						pedido.preFechamento = data.preFechamentos.preFechamentos;

   						pedido.cliente.devolucaoVales = new Object();
	   					pedido.cliente.devolucaoVales = data.vales.vales;

	   					itemFormaPagamento.formaPagamento = new Object();
	   					formaPagamento = new Object();


   						$("#retorno").messageBox(data.preFechamentos.mensagem,true,true);

   						var tmpValorTotal2 = (pedido.pvvalor - pedido.pvvaldesc);
   						pedido.TotalValorPreFechamento = data.preFechamentos.total;

	   				$("#lblTotalPagar").text(tmpValorTotal2.toFixed(2));
	   				$("#lblTotalPago").text(pedido.TotalValorPreFechamento);
	   				diferenca1 = $("#lblTotalPagar").text() - $("#lblTotalPago").text();
	   				diferenca = Number(diferenca1);
	   				$("#lblDiferencaPagar").text(Number(diferenca1));

                                        totalValorPreFechamento = 0;

                                         $.each(pedido.preFechamento, function (key, value) {
                                                        if (value.fecforma != '100' && value.fecforma != '102' && value.fecforma != '105'  && value.fecforma != '106' && value.fecforma != '111' && value.fecforma != '112') {
                                                                totalValorPreFechamento += Number(value.fecvalor);

                                                        }
                                         });


                                        limiteDisponivel = Number(pedido.cliente.clilimite) - Number(pedido.cliente.vendasEmAberto.cobrancaAberto)-Number(totalValorPreFechamento);
	   				$('#lblTotalLimiteDisponivel').text(parseFloat(limiteDisponivel).toFixed(2));



	   				if(Number(diferenca).toFixed(2)=='0.00' || Number(diferenca).toFixed(2)=='0' || Number(diferenca).toFixed(2)=='-0.00' || Number(diferenca).toFixed(2)=='-0')
	   				{
	   					var msg;
	   					msg = "PREFECHAMENTO REALIZADO COM SUCESSO";
	   					alert('PREFECHAMENTO REALIZADO COM SUCESSO');
					   	$("#retorno").messageBox(msg,true, true);
						$("#btnIncluirFormaPagamento").attr('disabled','disabled');
	   				}

	   				if(Number(diferenca).toFixed(2)< '0.00' || Number(diferenca).toFixed(2)< '0')
	   				{
	   			 	   	$("#retorno").messageBox(msg,true, true);
	   				}


   					}
   					$.unblockUI();
   				}, "json");
	});



});
 