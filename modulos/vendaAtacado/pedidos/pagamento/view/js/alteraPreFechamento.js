/**
 * @author Wellington
 *
 * Verificação dos dados para envio de formulario.
 *
 * Criação    15/12/2009
 * Modificado 15/12/2009
 *
 */


	itemFormaPagamento = new Object();
	itemFormaPagamento.preFechamento = new Array();
	
$(function(){
	
	//

			$("#btnConfirmaPreFechamento").click(function()
			{
			
						$.each(itensPreFechamento, function (key, value)
						{
						var preFechamentoparcela = new Object();
							
							preFechamentoparcela.fecdata = value.fecdata;
							preFechamentoparcela.pvnumero = pedido.pvnumero;
							preFechamentoparcela.fecforma = value.fecforma;
							preFechamentoparcela.fecdocto = value.fecdocto;
							preFechamentoparcela.fecbanco = value.fecbanco;
							preFechamentoparcela.fecvalor = decimalToNumber(value.fecvalor);
							preFechamentoparcela.fecvecto = value.fecvecto;
							preFechamentoparcela.clicodigo = pedido.cliente.clicodigo;
							preFechamentoparcela.vencodigo = value.fecdata;
							preFechamentoparcela.fectipo = 'A';
							preFechamentoparcela.fecagencia = value.fecagencia;
							preFechamentoparcela.fecempresa = '1';
							preFechamentoparcela.feccaixa = '0';
							preFechamentoparcela.feccartao = value.feccartao;
							preFechamentoparcela.fecconta = value.fecconta;
							preFechamentoparcela.fecdia = value.fecdia;
							
						
								
							itemFormaPagamento.preFechamento.push(preFechamentoparcela);
						
						});
				//alert(itemFormaPagamento.preFechamento[0].pvnumero);
						//alert(itemFormaPagamento);
				$.post('modulos/vendaAtacado/pedidos/pagamento/controller/acoes.php',
						{
		   			
	   				//variaveis a ser enviadas metodo POST
	   				itemFormaPagamento:JSON.stringify(itemFormaPagamento),
	   				acao:1
	   				
	   				},
	   				function(data)
	   				{
	   					
	   					//alert('PREFECHAMENTO EFETUADO COM SUCSSO');
	   					if (Boolean(Number(data.retorno)))
	   					{
	   						itensCobranca = new Array();
	   						itensCobranca.toArray(pedido.cobranca);
	   						$("#retorno").messageBox(data.mensagem,data.retorno,true);
	   					}
	   						else
	   	   					{
	   	   						alert('COBRANÇA EFETUADO COM SUCESSO');
	   	   						msg = 'COBRANÇA EFETUADO COM SUCESSO';
	   	   						$("#retorno").messageBox(msg,true,true);
	   	   					
	   	   					}
	   	   					$.unblockUI();
	   	   				}, "json");
	   			
				
	   			
		});
	


});