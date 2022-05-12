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
	
	// Validar formulario forma de pagamento
	$("#formFormaPagamento").validate({
		rules:
		{
			listaFormaPagamento: 
			{
				required: true
			},
			txtNumeroDocumento: 
			{
				required: true
			},
			
			listaTipoDuplicata: 
			{
				required: true
			},
			listaTipoParcelamento: 
			{
				required: true
			}
		},
		messages: 
		{
			listaFormaPagamento:
			{
				required: "Campo Obrigatorio!"
			},
			txtNumeroDocumento:
			{
				required: "Campo Obrigatorio!"
			},
			
			listaTipoDuplicata: 
			{
				required: "Campo Obrigatorio!"
			},
			listaTipoParcelamento: 
			{
				required: "Campo Obrigatorio!"
			}
		}
	});
	
	//validar dados de entrado
	$('#txtDiasVencimento').dias();
	$('#txtNumeroDocumento').alfanumerico();
	$('#txtValorDocumento').moeda();
	$('#txtVencimentoOrdemPagamento').date();
	$('#valorOrderPagamento').moeda();
	$('#txtVencimentoOrdemPagamento').date();
	
	$("input[name*='fecdia']").numerico();
	$("input[name*='fecvecto']").date();
	$("input[name*='fecvalor']").moeda();
	
	 
	
	$('input[name=opcaoVencimento]').click(function()
	{
		var id = $('input[name=opcaoVencimento]:checked').val();
		
		switch(id)
		{
			case '1':
				$('#txtDiasVencimento').dias();
				break;
			
			case '2':
				$('#txtDataVencimento').date();
				break;
		}
	});
	
	$('#listaFormaPagamento').change(function()
	{

		$('#formFormaPagamento').validate().resetForm();
		
		$('#txtNumeroDocumento').unsetMask();
		$('#txtNumeroDocumento').alfanumerico();	
		
		var id = Number(formaPagamento.pagcodigo);

		switch(id)
		{
			case CHEQUE_PRE:
				$("input[name*='txtNumeroDocFolha']").numerico();
				$("input[name*='txtValorDocFolha']").moeda();
				$("input[name*='txtNumeroBanco']").numerico();
				$("input[name*='txtNumeroAgencia']").numerico();
				$("input[name*='txtNumeroConta']").numerico();
				break;
			case CHEQUE_A_VISTA:
				$("input[name*='txtNumeroDocFolha']").numerico();
				$("input[name*='txtValorDocFolha']").moeda();
				$("input[name*='txtNumeroBanco']").numerico();
				$("input[name*='txtNumeroAgencia']").numerico();
				$("input[name*='txtNumeroConta']").numerico();
				break;
			case ORDEM_PAGAMENTO:
				$("input[name*='txtNumeroDocumento']").alfanumerico();
				break;
			case 102:
				for(i=1;i<=12;i++)
				{
//                                $('#listaBandeirasCartoes'+i+'').populaBandeirasCartoes();
                                $('#listaBandeirasCartoes'+i+'').html($('#listaBandeirasCartoesBase').html());
                                
				}
				$('#txtNumeroDocumento').cartao();
				break;
		}
	});
	
 });
