/**
 * @author Wellington
 *
 * Pesquisa - ação para fazer busca e trazer dados.
 *
 * Criação    02/12/2009
 * Modificado 02/12/2009
 *
 *	
 */

$(function(){
		
	$("#btnPesquisaTransportadoras").click(function()
	{
		if($('#formPesquisaTransportadoras').validate().form())
		{
			var titulo = "PESQUISANDO AGUARDE!";
			var mensagem = "PROCESSANDO PESQUISA, AGUARDE CONCLUCAO!";
			
			$('#divPesquisaTransportadora').messageBoxElement(titulo, mensagem);
			
			var pesquisa = new Object();
			//declara variaveis recuperando valores
			pesquisa.tipoPesquisa = $("input[name='opcoesTipoPesquisaTransportadoras']:checked").val();
			pesquisa.formaPesquisa = $("input[name='opcoesFormaPesquisaTransportadoras']:checked").val();
			pesquisa.txtPesquisa = $('#txtPesquisaTransportadoras').val();
			var acao = 2;
			
			//Envia os dados via metodo post
	   		$.post('modulos/cadastros/diversos/transportadoras/manutencao/controller/acoes.php',
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
					transportadoras = data.transportadoras;
					vendedor = new Object();
					
					mensagem = "TRANSPORTADORA(S) LOCALIZADO(S): "+transportadoras.length;
					
					var opcoes = '';
					$.each(transportadoras, function (key, value)
					{
						var option = '<option value="' + key + '">' + value.tracodigo + ' - ' + value.trarazao + '</option>';
						
						if (!opcoes)
						{
							opcoes = option;
							transportadora = value;
						}
						else
						{
							opcoes += option;
						}
					});
					
					$("#listaPesquisaTransportadoras").html(opcoes);
					$("#formResultadoTransportadoras").validate().resetForm();
                }
                else
                {	
                	$("#txtPesquisaTransportadoras").select();
                	$("#listaPesquisaTransportadoras").html('');
                	mensagem = "NAO FOI POSSIVEL LOCALIZAR TRANSPORTADORA(S).";
                }
				
				$("#retorno").messageBox(mensagem,data.retorno,data.retorno);
				$("#divPesquisaTransportadora").unblock();
				
			}, "json");
		}
	});
	
	$('#listaPesquisaTransportadoras').change(function(){
		transportadora = transportadoras[$(this).val()];
	});
	
	$("#btnNovoTransportadora").click(function()
	{	
		alert("Nova Transportadora");
	});
 });