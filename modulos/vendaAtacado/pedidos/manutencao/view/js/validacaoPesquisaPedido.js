/**
 * @author Douglas
 *
 * Valida��o de dados ao envio de formulario.
 *
 * Cria��o    04/02/2010
 * Modificado 04/02/2010
 *
 */

$(function(){
	

// Validar formulario de pesquisa
	$("#formPesquisaPedidos").validate({
		rules:
		{
			txtPesquisaPedidos: 
			{
				required: true,
				minlength: 1,
				maxlength: 25
			}
		},
		messages: 
		{
			txtPesquisaPedidos:
			{
				required: "Campo Obrigatorio!",
				minlength: "Minino 4 caracteres!",
				maxlength: "Ultrapassa o limite de 25 caracteres!"
			}
		}
	});
	
	// Validar formulario de pesquisa
	$("#formResultadoPedidos").validate({
		rules:
		{
			listaPesquisaPedidos: 
			{
				required: true
			}
		},
		messages: 
		{
			listaPesquisaPedidos:
			{
			required: "Selecionar Campo Obrigatorio! Fa�a a pesquisa acima para exibir pedidos."
			}
		}
	});
	
	//valida��o dos dados de entrada
	$("#txtPesquisaPedidos").codigo();
	
	$("input[name='opcoesTipoPesquisaPedidos']").click(function()
	{
		var id = $("input[name='opcoesTipoPesquisaPedidos']:checked").val();
		
		$("#txtPesquisaPedidos").unsetMask();
		
		switch(id)
		{
			case "pvnumero":
				$("#txtPesquisaPedidos").codigo();
				break;
				
			case "vencodigo":
				$("#txtPesquisaPedidos").codigo();
				break;
				
			case "clicodigo":
				$("#txtPesquisaPedidos").codigo();
				break;
			
			case "tracodigo":
				$("#txtPesquisaPedidos").codigo();
				break;
				
			case "pvemissao":
				$("#txtPesquisaPedidos").date();
				break;
		}
	});
	
 });