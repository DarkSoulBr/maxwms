/**
 * @author Douglas
 *
 * Validação de dados ao envio de formulario de Liberacao de Pedido.
 *
 * Criação    05/02/2010
 * Modificado 05/02/2010
 *
 */
$(function(){
	
	//Validar formulario ao clicar botao, ver crud
	$("#formAlteraNumero").validate({
		rules: 
		{
		enderecoCliente: 
			{
				required: true
						
			},
			numeroEnderecoCliente: 
			{
				required: true,
				maxlength: 5
				
			},
			cepEnderecoCliente: 
			{
				required: true
				
			},
			bairroEnderecoCliente:
			{
				required:true
			}
		
		},
		messages: 
		{
			enderecoCliente: 
			{
					required: "Campo Obrigatorio!"
			},
			numeroEnderecoCliente: 
			{
					required: "Campo Obrigatorio!"
			},
			cepEnderecoCliente: 
			{
					required: "Campo Obrigatorio!"
			},
			bairroEnderecoCliente: 
			{
					required: "Campo Obrigatorio!"
			}
		}
	});
	
	$('#numeroEnderecoCliente').codigo();
	$('#cepEnderecoCliente').codigo();
	

 });