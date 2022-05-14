// JavaScript Document
function load_grid() {
	var dtinicio = document.getElementById("dtinicio").value;
	var dtfinal = document.getElementById("dtfinal").value;

	if (dtinicio.length <= 9) {
		alert("Preencha o campo data corretamente!\nEx: 01/01/2018");
		document.getElementById('dtinicio').focus();
	} else if (dtfinal.length <= 9) {
		alert("Preencha o campo data corretamente!\nEx: 01/01/2018");
		document.getElementById('dtfinal').focus();
	} else {
		new ajax('consultapedbaixadodata.php?dtinicio=' + dtinicio + '&dtfinal=' + dtfinal, { onComplete: imprime });
		//window.open ('consultapedbaixadodata.php?dtinicio=' + dtinicio + '&dtfinal=' + dtfinal , '_blank');
	}

}

function abre(n, b) {

	window.open('pedcompraimppdf.php?pcnumero=' + n
		+ '&pcseq=' + b
		, 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');

}

function imprime(request) {

	$("resultado").innerHTML = "";
	var xmldoc = request.responseXML;
	var totvolumes = 0;

	var dados = xmldoc.getElementsByTagName('dados')[0];

	var registros = xmldoc.getElementsByTagName('registro');

	if (dados != null) {

		let resultado = "<div class='limiter'>"
		resultado += "<div class='container-table100'>"
		resultado += "<div class='wrap-table100'>"
		resultado += "<div class='table-max'>"
		resultado += "<div class='row-max header'>"
		resultado += "<div class='cell-max'>Número</div>"
		resultado += "<div class='cell-max'>Baixa</div>"
		resultado += "<div class='cell-max'>Emissão</div>"
		resultado += "<div class='cell-max'>Baixa</div>"
		resultado += "<div class='cell-max'>Codigo</div>"
		resultado += "<div class='cell-max'>Fornecedor</div>"
		resultado += "<div class='cell-max'>Comprador</div>"
		resultado += "<div class='cell-max'>Volumes</div>"
		resultado += "<div class='cell-max'>Nota</div>"
		resultado += "<div class='cell-max'>Emissão</div>"
		resultado += "<div class='cell-max'>Estoque</div>"
		resultado += "</div>"

		var registros = xmldoc.getElementsByTagName('registro');
		for (i = 0; i < registros.length; i++) {
			var itens = registros[i].getElementsByTagName('item');

			resultado += "<div class='row-max'>"
			resultado += "<div class='cell-max' data-title='Pedido'>" + itens[0].firstChild.data + "</div>"
			resultado += "<div class='cell-max' data-title='Baixa'>" + itens[1].firstChild.data + "</div>"
			resultado += "<div class='cell-max' data-title='Emissão'>" + itens[2].firstChild.data + "</div>"
			resultado += "<div class='cell-max' data-title='Baixa'>" + itens[3].firstChild.data + "</div>"
			resultado += "<div class='cell-max' data-title='Codigo'>" + itens[4].firstChild.data + "</div>"
			resultado += "<div class='cell-max' data-title='Fornecedor'>" + itens[5].firstChild.data + "</div>"
			resultado += "<div class='cell-max' data-title='Comprador'>" + itens[6].firstChild.data + "</div>"
			resultado += "<div class='cell-max' data-title='Volumes'>" + itens[7].firstChild.data + "</div>"
			resultado += "<div class='cell-max' data-title='Nota'>" + itens[8].firstChild.data + "</div>"
			resultado += "<div class='cell-max' data-title='Emissão'>" + itens[9].firstChild.data + "</div>"
			resultado += "<div class='cell-max' data-title='Estoque'>" + itens[10].firstChild.data + "</div>"
			resultado += "</div>"

			totvolumes = totvolumes + Math.round(itens[7].firstChild.data);

		}

		resultado += "<div class='row-max header'>"
		resultado += "<div class='cell-max' data-title='Pedido'> &nbsp; </div>"
		resultado += "<div class='cell-max' data-title='Baixa'> &nbsp; </div>"
		resultado += "<div class='cell-max' data-title='Emissão'> &nbsp; </div>"
		resultado += "<div class='cell-max' data-title='Baixa'> &nbsp; </div>"
		resultado += "<div class='cell-max' data-title='Codigo'>&nbsp; </div>"
		resultado += "<div class='cell-max' data-title='Fornecedor'> Volumes </div>"
		resultado += "<div class='cell-max' data-title='Comprador'>&nbsp; </div>"
		resultado += "<div class='cell-max' data-title='Volumes'>" + totvolumes + "</div>"
		resultado += "<div class='cell-max' data-title='Nota'>&nbsp; </div>"
		resultado += "<div class='cell-max' data-title='Emissão'>&nbsp; </div>"
		resultado += "<div class='cell-max' data-title='Estoque'>&nbsp; </div>"
		resultado += "</div>"

		resultado += "</div>"
		resultado += "</div>"
		resultado += "</div>"
		resultado += "</div>"

		$("resultado").innerHTML = resultado;

		$("resultado2").innerHTML = "Total de Volumes: " + totvolumes;

	} else {

		$("resultado").innerHTML = "Nenhum registro encontrado...";
		$("resultado2").innerHTML = "";

	}

}



function imprimepdf() {

	var dtinicio = document.getElementById("dtinicio").value;
	var dtfinal = document.getElementById("dtfinal").value;

	if (dtinicio.length <= 9) {
		alert("Preencha o campo data corretamente!\nEx: 01/01/2018");
		document.getElementById('dtinicio').focus();
	} else if (dtfinal.length <= 9) {
		alert("Preencha o campo data corretamente!\nEx: 01/01/2018");
		document.getElementById('dtfinal').focus();
	} else {
		window.open('consultapedbaixadoimppdf.php?dtinicio=' + dtinicio
			+ '&dtfinal=' + dtfinal
			, 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');

	}

}