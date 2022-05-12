/**
 * @author Wellington
 *
 * Pesquisa - ação para fazer busca e trazer dados.
 *
 * Criação    03/12/2009
 * Modificado 03/12/2009
 *
 *	
 */
	var pedidos;
	var pedido = new Object();

$(function(){
	
	
	
	
	//localizar pedidos
	$("#btnPesquisaPedidos").click(function()
	{
		if($('#formPesquisaPedidos').validate().form())
		{
			var pesquisa = new Object();
			//declara variaveis recuperando valores
			pesquisa.tipoPesquisa = $("input[name='opcoesTipoPesquisaPedidos']:checked").val();
			pesquisa.formaPesquisa = $("input[name='opcoesFormaPesquisaPedidos']:checked").val();
			pesquisa.txtPesquisa = $('#txtPesquisaPedidos').val();
			var acao = 2;
			
			//Envia os dados via metodo post
	   		$.post('modulos/vendaAtacado/pedidos/manutencao/controller/acoes.php',
	   				{
	   					//variaveis a ser enviadas metodo POST
	   					tipoPesquisa:pesquisa.tipoPesquisa,
	   					formaPesquisa:pesquisa.formaPesquisa,
	   					txtPesquisa:pesquisa.txtPesquisa,
	   					acao:acao
	   				},
	   				function(data)
	   				{
	   					if (Boolean(Number(data.retorno)))
		                {
	   						$('#retorno').html(MENSAGEM_RETORNO_OK.replace('<<mensagem>>', data.mensagem));   						
	   						
	   						pedidos = data.pedidos;
	   						
	   						var opcoes = '';
   							$.each(pedidos, function (key, value)
								{
   								
   								$("#dataEmissaoPedido").val(value.pvemissao);
   								$("#tipoPedido").val(value.tipoPedido.descricao);
   								$("#nomeGuerraCliente").val(value.cliente.clirazao);
   								
   									var pvemissao = value.pvemissao;
   									var option = '<option value="' + value.pvnumero + '">' + value.pvnumero + '</option>';
   									
	   								if (!opcoes)
	   								{
	   									opcoes = option;
	   									pedido = value;
	   								}
	   								else
	   								{
	   									opcoes += option;
	   								}
								});
   							
   							$("#listaPesquisaPedidos").html(opcoes);
   							$("#listaPesquisaPedidos").attr('disabled',false);
   							
   							
   						
		                }
		                else
		                {
		                	$('#retorno').html(MENSAGEM_RETORNO_ATENCAO.replace('<<mensagem>>', data.mensagem));
		                }
	   				}, "json");
		}
	});
	
	$('#listaPesquisaPedidos').change(function(){
		pedido = pedidos[$(this).val()];
	});
	$('#dataEmissaoPedidos').change(function(){
		pedido = pedidos[$(this).val()];
	});


 });