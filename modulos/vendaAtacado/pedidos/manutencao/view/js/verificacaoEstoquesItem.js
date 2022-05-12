/**
 * @author Wellington
 *
 * Verificação dos dados para envio de formulario.
 *
 * Criação    06/01/2010
 * Modificado 06/10/2010
 *
 */

$(function()
{
	//verificação estoques item
	/*$("#incluirProduto").click(function()
	{
		var jsonText = $("#listaPesquisaProdutos").val();
		produto = eval('(' + jsonText + ')');
		
		if (itensPedido.length > 0)
		{
			$.each(itensPedido, function (key, value)
			{
				if (value.produto.procodigo == produto.procodigo)
				{
					$('#estoquesItem').dialog("close");
					
					$('#dialog').attr('title','Itens de Estoque')
					.html('<p>Produto ja adicionado na lista de itens!<br> Localize e altere o produto que tentou adicionar na lista de <i>Produtos Incluidos</i>.</p>')
					.dialog({
						autoOpen: false,
						modal: true,
						width: 480,
						buttons: {
							"Ok": function() {
								$(this).dialog("close");
								limpaPesquisaProdutos();
							}
						}
					})
					.dialog("open");
				}
			});
		}
		
		if (itensPedidoEmpenho.length > 0)
		{
			$.each(itensPedidoEmpenho, function (keyE, valueE)
			{
				var isDuplicado = false;
				if (itensPedido.length > 0)
				{
					$.each(itensPedido, function (key, value)
					{		
						if (value.produto.procod == valueE.produto.procod)
						{
							isDuplicado = true;
						}
					});
				}
				
				if (!isDuplicado)
				{
					if (valueE.produto.procodigo == produto.procodigo)
					{
						$('#estoquesItem').dialog("close");
						
						$('#dialog').attr('title','Itens de Estoque')
						.html('<p>Produto ja adicionado na lista de itens!<br> Localize e altere o produto que tentou adicionar na lista de <i>Produtos Incluidos</i>.</p>')
						.dialog({
							autoOpen: false,
							modal: true,
							width: 480,
							buttons: {
								"Ok": function() {
									$(this).dialog("close");
									limpaPesquisaProdutos();
								}
							}
						})
						.dialog("open");
					}
				}
			});
		}
		
	});	*/
});
