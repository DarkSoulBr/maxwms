/**
 * @author Wellington
 *
 * funções publicas para a pagina da view pesquisa.
 *
 * Criação    17/02/2010
 *
 */
	var transportadoras = new Array();
	var transportadora = new Object();

function limpaPesquisaTransportadoras()
{
	transportadoras = new Array();
	transportadora = new Object();
	
	$('#formPesquisaTransportadoras').validate().resetForm();
	$("input[name='opcoesTipoPesquisaTransportadoras']").val(["tracodigo"]);
	$("input[name='opcoesFormaPesquisaTransportadoras']").val(["2"]);
	$("#txtPesquisaTransportadoras").unsetMask();
	$("#txtPesquisaTransportadoras").val("").codigo();
	
	$('#formResultadoTransportadoras').validate().resetForm();
	$("#listaPesquisaTransportadoras").html("");
	
	$("input[name='opcoesTipoFrete']").val(["1"]);
}