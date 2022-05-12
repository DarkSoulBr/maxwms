/**
 * @author Wellington
 *
 * Validação de dados 
 * Envio de formulario de pesquisa produtos.
 *
 * Criação    18/12/2009
 * Modificado 18/12/2009
 *
 */

$(function(){
	
	// Validar formulario de pesquisa
	$("#formPesquisaTransportadoras").validate({
		rules:
		{
			txtPesquisaTransportadoras: 
			{
				required: true,
				minlength: 1,
				maxlength: 30
			}
		},
		messages: 
		{
			txtPesquisaTransportadoras:
			{
				required: "Campo Obrigatorio!",
				minlength: "Minino 2 caracteres!",
				maxlength: "Ultrapassa o limite de 30 caracteres!"
			}
		}
	});
	
	// Validar formulario de resultado
	$("#formResultadoTransportadoras").validate({
		rules:
		{
			listaPesquisaTransportadoras: 
			{
				required: true
			}
		},
		messages: 
		{
			listaPesquisaTransportadoras:
			{
				required: "Selecionar Campo Obrigatorio! Faça a pesquisa acima para exibir transportadora(s)."
			}
		}
	});
	
	//validação dos dados de entrada
	$("#txtPesquisaTransportadoras").codigo();
	
	$("input[name='opcoesTipoPesquisaTransportadoras']").click(function()
	{
		var id = $("input[name='opcoesTipoPesquisaTransportadoras']:checked").val();
		
		$("#txtPesquisaTransportadoras").unsetMask();
		
		switch(id)
		{
			case "tracodigo":
				$("#txtPesquisaTransportadoras").codigo();
				break;
				
			case "tranguerra":
				$("#txtPesquisaTransportadoras").alfanumerico();
				break;
				
			case "trarazao":
				$("#txtPesquisaTransportadoras").alfanumerico();
				break;
		}
	});
 });
