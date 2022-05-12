/**
 * @author Wellington
 *
 * funções publicas para a pagina da view.
 *
 * Criação    23/12/2009
 *
 */

function rowAdm(value, tipo, numLinha)
{
	var cidade = "";
	var uf = "";
	var cor = "#77DD98";
	var status = "0";
	
	var dataAtual = new Date();
	var dataSerasaExp = new Date();
	var dataSintegraExp = new Date();
	
	var codHtml = "";
	var txtDataSerasa = '';
	var txtDataSintegra = '';
	var atualizaInterfix = '';
	var liberar = "";
	
	var manutencaoPedido = '<span id="dvManutencao'+value.pvnumero+'"><a href="'+HTTP_ROOT+'dtrade.php?flagmenu=9&pgcodigo=5&popup=1&pvnumero='+value.pvnumero+'" title="MANUTENCAO" tooltip="CLIQUE PARA EFETUAR MANUTEÇÃO DO PEDIDO" class="greybox" id="'+value.pvnumero+'" name="manutencao">EDITAR</a></span>';
	var consultaPedido = '<span id="dvConsultaPedido'+value.cliente.clicod+'"><a href="'+HTTP_ROOT+'pedvendacons2.php?flagmenu=9&popup=1&codped='+value.pvnumero+'" title="CONSULTA PEDIDO" tooltip="CLIQUE PARA REALIZAR CONSULTAR PEDIDO." class="greybox" id="'+value.pvnumero+'" name="consulta">'+value.pvnumero+'</a></span>';
	var analiseCredido = '<span id="dvAnaliseCredito'+value.cliente.clicod+'"><a href="'+HTTP_ROOT+'analisecredclientes.php?popup=1&clicod='+value.cliente.clicod+'" title="ANALISE DE CREDITO" tooltip="CLIQUE PARA VISUALIZAR ANALISE DE CREDITO DO CLIENTE." class="greybox" id="'+value.cliente.clicod+'" name="analiseCredito">ANALISE CREDITO</a></span>';
	var manutencaoCredito = '<span id="dvManutencaoCredito'+value.cliente.clicod+'"><a href="'+HTTP_ROOT+'dtrade.php?flagmenu=9&pgcodigo=6&popup=1&clicod='+value.cliente.clicod+'" title="MANUTENCAO DE CREDITO" tooltip="CLIQUE PARA EFETUAR MANUTEÇÃO DE CREDITO DO CLIENTE." class="greybox" id="'+value.cliente.clicod+'" name="manutencaoCredito">'+$.mask.string(Number(value.cliente.clilimite).toFixed(2), 'decimal')+'</a></span>';
	
	var limiteDisponivel = Number(value.cliente.clilimite) - (Number(value.cliente.getVendasEmAberto.totalVendas)-Number(value.pvvalor));
	
	if (value.cliente.enderecoFaturamento)
	{
		uf = value.cliente.enderecoFaturamento.cidade.uf;
		cidade= value.cliente.enderecoFaturamento.cidade.descricao;
	}
	
	dataSerasaExp = value.cliente.cliserasaexp ? new Date().date(value.cliente.cliserasaexp) : '';
	dataSintegraExp = value.cliente.clisintegra ? new Date().date(value.cliente.clisintegra) : '';
	
	txtDataSerasa = dataSerasaExp ? dataSerasaExp.format("d/m/Y") : '';
	txtDataSintegra = dataSintegraExp ? dataSintegraExp.format("d/m/Y") : '';
	
	switch (tipo)
	{
		case 0:
			cor = '#FA5050';
			status = 'PROIBIDO';
			liberar = '';
			break;
			
		case 1:
			atualizaInterfix = '<span id="dvInterfix'+value.cliente.clicod+'"><a href="'+HTTP_ROOT+'dtrade.php?flagmenu=9&pgcodigo=19&popup=1&clicod='+value.cliente.clicod+'" title="FINANCEIRO INTERFIX" tooltip="CLIQUE PARA ATUALIZAÇÃO FINANCEIRO INTERFIX." class="greybox" id="'+value.cliente.clicod+'" name="interfix">ATUALIZAR</a></span>';

			cor = '#FFFFBB';
			liberar = '<span id="dvFinanceiro'+value.pvnumero+'"><a href="javascript:;" title="ALTERAR SITUACAO" tooltip="CLIQUE PARA ALTERAR SITUACAO DO PEDIDO." id="'+value.pvnumero+'" name="financeiro">FINANCEIRO</a></span>';
			
			if (Number(value.pvvalor) > limiteDisponivel)
			{
				status = 'LIMITE EXCEDIDO';
			}
			else if (!dataSerasaExp || !dataSintegraExp)
			{
				status = atualizaInterfix;
			}
			else
			{
				dataSintegraExp.addMonths(1);
				
				if(dataAtual.getMonthsBetween(dataSerasaExp) < 0)
				{
					status = atualizaInterfix;
					txtDataSerasa = '<a href="javascript:;" tooltip="DATA DA ATUALIZAÇÃO DO FINANCEIRO INTERFIX EXPIRADA!\n CLIQUE EM ATUALIZAR."><font color="red"><b>'+dataSerasaExp.format("d/m/Y")+'<b></font></a>';
				}
				
				if(dataAtual.getMonthsBetween(dataSintegraExp) < 0)
				{
					status = atualizaInterfix;
					txtDataSintegra = '<a href="javascript:;" tooltip="DATA DA ATUALIZAÇÃO DO FINANCEIRO INTERFIX EXPIRADA!\n CLIQUE EM ATUALIZAR."><font color="red"><b>'+dataSintegraExp.format("d/m/Y")+'<b></font></a>';
				}
			}
			break;
			
		default:
			cor = '#77DD98';
			status = 'AUTORIZADO';
			liberar = '<span id="dvLiberado'+value.pvnumero+'"><a href="'+HTTP_ROOT+'dtrade.php?flagmenu=9&pgcodigo=11&popup=1&pvnumero='+value.pvnumero+'" title="LIBERACAO" tooltip="CLIQUE PARA REALIZAR LIBERAÇÃO DO PEDIDO" id="'+value.pvnumero+'" class="greybox" name="liberacao">LIBERAR</a></span>';
			break;
	}

	codHtml += "<tr style='background: "+cor+";' id="+value.pvnumero+">" +
		"<td>"+numLinha+"</td>"+
		"<td>"+value.tipoPedido.sigla+"</td>"+
		"<td>"+consultaPedido+"</td>" +
		"<td><a href='"+HTTP_ROOT+"clientescons.php?popup=1&pvnumero="+value.pvnumero+"&clicod="+value.cliente.clicod+"' title='CONSULTA CLIENTE' tooltip='CLIQUE PARA EFETUAR CONSULTA CLIENTE' class='greybox' id='"+value.cliente.clicod+"' name='cliente'>"+value.cliente.clicod+"</a></td>" +
		"<td><a href='"+HTTP_ROOT+"clientescons.php?popup=1&pvnumero="+value.pvnumero+"&clicod="+value.cliente.clicod+"' title='CONSULTA CLIENTE' tooltip='CLIQUE PARA EFETUAR CONSULTA CLIENTE' class='greybox' id='"+value.cliente.clicod+"' name='cliente'>"+value.cliente.clirazao+"</a></td>" +
		"<td>";
	codHtml += value.cliente.climodo == 2 ? "FIDELIDADE" : "NORMAL";
	codHtml += "</td> <td>";
	codHtml += value.tipolocal == 1 ? "CD" : "VIX";
	codHtml += "</td>"+
		"<td>"+liberar+"</td>" +
		"<td>"+manutencaoPedido+"</td>" +
		"<td>"+cidade+"</td>"+
		"<td>"+uf+"</td>" +
		"<td>"+value.vendedor.vencodigo+" "+value.vendedor.vennguerra+"</td>" +
		"<td>";
	var dataEmissao = new Date().date(value.pvemissao);
	codHtml += dataEmissao.format("d/m/Y H:i:s");
	var totalLiquido = Number(value.pvvalor) - Number(value.pvvaldesc);
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
		"<td>"+liberar+"</td>" +
		"<td>"+manutencaoPedido+"</td>" +
		"<td>"+analiseCredido+"</td>" +
		"<td>"+manutencaoCredito+"</td>" +
		"<td>";
							
	codHtml +=  txtDataSerasa;
	codHtml +="</td>" +
		"<td>";
	codHtml += txtDataSintegra;
	codHtml +="</td>" +
		"<td>";
	codHtml += txtDataSintegra;
	codHtml +="</td>" +
		"<td>"+status+"</td>" +
	"</tr>";
	
	return codHtml;
}