/**
 * @author Douglas
 *
 * CRUD - ações jquery para insert, delete, update e select.
 *
 * Criação    05/02/2010
 * Modificado 05/02/2010
 *
 *	PARA ACAO USE verifique o aquivo config.js lib/jquery/max;
 *		1 -> INSERT
 *		2 -> SELECT
 *		3 -> UPDATE
 *		4 -> DELETE
 */
$(function(){
	
	
	
	
	$("#btnLiberacaoPedido").click(function()
	{	
		if($('#formLiberacaoPedido').validate().form())
		{
		pedido = new Object();
		
		//declara variaveis recuperando valores
		pedido.dataEmissaoPedido = $('#dataEmissaoPedido').val();
		pedido.tipoPedido = $('#tipoPedido').val();
		pedido.dataLiberacaoPedido = $('#dataLiberacaoPedido').val();
		pedido.horaLiberacaoPedido = $('#horaLiberacaoPedido').val();
		pedido.urgentePedido = $("input[name='urgentePedido']:checked").val();
		
		//Envia os dados via metodo post
   		$.post('modulos/vendaAtacado/pedidos/liberacao/controller/acoes.php',
   				{
   					//variaveis a ser enviadas metodo POST
   					dataEmissaoPedido:pedido.dataEmissaoPedido,
   					tipoPedido:pesquisa.tipoPedido,
   					dataLiberacaoPedido:pesquisa.dataLiberacaoPedido,
   					horaLiberacaoPedido:pesquisa.horaLiberacaoPedido,
   					urgentePedido:pesquisa.urgentePedido
   					
   				},function(data)
   				{
   					if (Boolean(Number(data.retorno)))
	                {
   						alert(data.retorno);
   						
	                }
   				}, "json");
		}
		
		
	});

});