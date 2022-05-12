/**
 * @author Wellington
 *
 * bloqueio de teclas no maxtrede.
 *
 * Criação    11/03/2010
 * keyCode 112...123 = F1...F12
 * keyCode 13 = <Enter>
 * keyCode 27 = Esc
 *
 */
	var usuario = new Object();

$(function(){
	
	var jsonText = $("#usuario").val();
	usuario = eval('(' + jsonText + ')');
	
});
