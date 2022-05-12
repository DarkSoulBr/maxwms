/**
 * @author Douglas
 *
 * Valida��o de dados ao envio de formulario de Liberacao de Pedido.
 *
 * Cria��o    05/02/2010
 * Modificado 05/02/2010
 *
 */
$(function(){
	
	 //Validar formulario ao clicar botao, ver crud
	$("#formResultadoPedidos").validate({
		rules: 
		{
		listaPesquisaPedidos: 
			{
				required: true,
				maxlength: 10
				
			}
		},
		messages: 
		{
			listaPesquisaPedidos: 
			{
				required: "N�mero do Pedido � obrigatorio!",
					maxlength: "Ultrapassa o limite de 10 caracteres!"
				
			}
			
		}
	});
	
	//Validar formulario ao clicar botao, ver crud
	$("#formLiberacaoPedido").validate({
		rules: 
		{
		dataLiberacaoPedido: 
			{
				required: true,
				maxlength: 10
				
			},
		horaLiberacaoPedido: 
			{
				required: true,
				maxlength: 10
			},
			dataEmissaoPedido: 
			{
				required: true,
				maxlength: 10
			},
			tipoPedido:
			{
				required:true
			},
			nomeGuerraCliente:
			{
				required:true
			}
			
		},
		messages: 
		{
		dataLiberacaoPedido: 
			{
					required: "Campo Obrigatorio!",
					maxlength: "Ultrapassa o limite de 10 caracteres!"
				
			},
		horaLiberacaoPedido: 
			{
					required: "Campo Obrigatorio!",
					maxlength: "Ultrapassa o limite de 10 caracteres!"
				
			},
			dataEmissaoPedido: 
			{
					required: "Campo Obrigatorio!",
					maxlength: "Ultrapassa o limite de 10 caracteres!"
				
			},
			tipoPedido: 
			{
					required: "Campo Obrigatorio!"
					
				
			},
			nomeGuerraCliente: 
			{
					required: "Campo Obrigatorio!"
					
				
			}
		}
	});
	//Valida��o de dados de entrada
	$("#dataLiberacaoPedido").date();
	$("#fecdata").date();
	$("#horaLiberacaoPedido").time();
	
	

 });