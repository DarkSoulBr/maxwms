/**
 * @author Wellington
 *
 * Verificação dos dados para envio de formulario.
 *
 * Criação    15/12/2009
 * Modificado 15/12/2009
 *
 */

$(function(){
	
	var dataAtual = new Date();
	var stringDate = dataAtual.format('dmY');
	var hora = dataAtual.format('H:i');
	
	$("#dataLiberacaoPedido").val($.mask.string(stringDate, 'date'));
	$("#fecdata").val($.mask.string(stringDate, 'date'));
	$("#horaLiberacaoPedido").val(hora);
	
});



