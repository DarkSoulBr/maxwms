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
				required: "Número do Pedido é obrigatorio!",
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
	//Validação de dados de entrada
	$("#dataLiberacaoPedido").date();
	$("#fecdata").date();
	$("#horaLiberacaoPedido").time();
	
	

 });