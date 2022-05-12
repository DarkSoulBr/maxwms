/**
 * @author Wellington
 *
 * Validação de dados ao envio de formulario.
 *
 * Criação    23/10/2009
 * Modificado 23/10/2009
 *
 */

$(function(){
	
	var dataAtual = new Date();
	var stringDate = dataAtual.format('dmY');
	var hora = dataAtual.format('H:i');
	
	$("#dataEmissaoPedido").val($.mask.string(stringDate, 'date'));
 
	// Validar formulario ao clicar botao, ver crud
	$("#formTipoPedido").validate({
		rules: 
		{
			listaTipoPedidos: 
			{
				required: true
			}
		},
		messages: 
		{
			listaTipoPedidos: 
			{
				required: "Selecionar Campo Obrigatorio!"
			}
		}
	});
	
	// Validar formulario condicao comercial
	$("#formCondicoesComerciais").validate({
		rules:
		{
			listaCondicoesComerciais: 
			{
				required: true
			}
		},
		messages: 
		{
			listaCondicoesComerciais:
			{
				required: "Selecione Campo Obrigatorio!"
			}
		}
	});
	
	// Validar formulario estoque origem
	$("#formEstoqueOrigem").validate({
		rules:
		{
			listaEstoqueOrigem: 
			{
				required: true
			}
		},
		messages: 
		{
			listaEstoqueOrigem:
			{
				required: "Selecione Campo Obrigatorio!"
			}
		}
	});
	
	// Validar formulario estoque destino
	$("#formEstoqueDestino").validate({
		rules:
		{
			listaEstoqueDestino: 
			{
				required: true
			}
		},
		messages: 
		{
			listaEstoqueDestino:
			{
				required: "Selecione Campo Obrigatorio!"
			}
		}
	});
	
	// validação de dados de entrada
	$("#txtLocalEntrega").alfanumerico();
	$("#txtExcecoes").alfanumerico();
	$("#txtObservacao").alfanumerico();
	$("#txtValorDesconto").moeda();
	$("#txtPercentualDesconto").percentual();
	
	$("#dataEntrega").datepicker({minDate:dataAtual});
 });
