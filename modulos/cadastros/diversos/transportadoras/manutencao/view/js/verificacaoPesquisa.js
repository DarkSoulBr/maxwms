/**
 * @author Wellington
 *
 * Verifica��o de dados 
 * Envio de formulario de pesquisa produtos.
 *
 * Cria��o    18/12/2009
 * Modificado 18/12/2009
 *
 */

$(function(){
	
	$("input[name='opcoesTipoPesquisaTransportadoras']").click(function()
	{
		$("#txtPesquisaTransportadoras").val('');
		$("#txtPesquisaTransportadoras").focus();
	});
	
	$("input[name='opcoesFormaPesquisaTransportadoras']").click(function()
	{
		$("#txtPesquisaTransportadoras").select();
	});
	
 });