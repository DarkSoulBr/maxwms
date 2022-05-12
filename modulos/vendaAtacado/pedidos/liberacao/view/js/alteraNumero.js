/**
 * @author Douglas
 *
 * CRUD - ações jquery para alterar numero de endereço.
 *
 * Criação    12/02/2010
 * Modificado 12/02/2010
 *

 */
$(function(){
	
	
	
	
	
		$("#btnAlteraNumero").click(function()
		{	
			if($('#formAlteraNumero').validate().form())
			{
				alteracaoEndereco = new Object();
			
			//declara variaveis recuperando valores
				alteracaoEndereco.cleendereco = $('#enderecoCliente').val();
				alteracaoEndereco.clenumero = $('#numeroEnderecoCliente').val();
				alteracaoEndereco.clecomplemento = $('#complementoEnderecoCliente').val();
				alteracaoEndereco.clebairro = $('#bairroEnderecoCliente').val();
				alteracaoEndereco.clecodigo = $('#codigoEnderecoCliente').val();
				alteracaoEndereco.clecep = $('#cepEnderecoCliente').val();
			
			
			
			//Envia os dados via metodo post
	   		$.post('modulos/vendaAtacado/pedidos/liberacao/controller/acoes.php',
	   				{
	   			alteracaoEndereco:JSON.stringify(alteracaoEndereco),
   				acao:3
	   					
	   				},
	   				function(data)
	   				{
	   					if (Boolean(Number(data.retorno)))
		                {
	   						$("#retorno").messageBox(data.mensagem,data.retorno,true);
	   				    }
		                else
		                {
		              
	   						$("#numeroEnderecoCliente").val(alteracaoEndereco.clenumero);
	   						$("#complementoEnderecoCliente").val(alteracaoEndereco.clecomplemento);
	   						$("#bairroEnderecoCliente").val(alteracaoEndereco.clebairro);
	   						$("#cepEnderecoCliente").val(alteracaoEndereco.clecep);
	   						$("#enderecoCliente").val(alteracaoEndereco.cleendereco);
	   						
							pedido.cliente.enderecoFaturamento.clenumero  = alteracaoEndereco.clenumero;	
							pedido.cliente.enderecoFaturamento.clecomplemento  = alteracaoEndereco.clecomplemento;
							pedido.cliente.enderecoFaturamento.clebairro  = alteracaoEndereco.clebairro;
							pedido.cliente.enderecoFaturamento.clecep  = alteracaoEndereco.clecep;
							pedido.cliente.enderecoFaturamento.cleendereco  = alteracaoEndereco.cleendereco;
							
							
		                	$("#retorno").messageBox(data.mensagem,data.retorno,false);
		                	$('#tblAlteraNumero').hide();
		                }
	   				}, "json");
	   					
			}
			
			
		});
		$('#numeroEnderecoCliente').val('01');
	});