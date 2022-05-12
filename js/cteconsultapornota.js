// JavaScript Document  
function pesquisar(nfe){




	nfe = "000000000" + nfe;

	var nfe1 = nfe.substring(nfe.length - 9, nfe.length);

	document.getElementById("nfe").value=nfe1;

	//window.open('cteconsultapornotapesquisa.php?nfe='+nfe, '_blank');
	
	new ajax('cteconsultapornotapesquisa.php?nfe='+nfe1, {onComplete: imprime});

	
}



function imprime(request){

	

	var xmldoc=request.responseXML;

    var dados = xmldoc.getElementsByTagName('dados')[0];

	if(dados!=null) 
	{
		
		var registros = xmldoc.getElementsByTagName('registro');
		var itens = registros[0].getElementsByTagName('item');
		
		
		if (itens[0].firstChild.data==0){
			alert('Nenhum registro foi enciontrado!');
			document.getElementById("ctenumero").value='';
			document.getElementById("cte").value='';
			document.getElementById("emissao").value='';
		}
		else
		{
			document.getElementById("ctenumero").value=itens[0].firstChild.data;
			document.getElementById("cte").value=itens[1].firstChild.data;
			document.getElementById("emissao").value=itens[2].firstChild.data;
		}	
		
	}
	else
	{
		
		document.getElementById("ctenumero").value='';
		document.getElementById("cte").value='';
		document.getElementById("emissao").value='';
	}	
	
		
}

function manutencao(){

	if (document.getElementById("ctenumero").value==''){
		alert('Nehum CTe selecionado!');
	}
	else
	{
		window.open('alterarcte.php?numcte='+document.getElementById("ctenumero").value, '_self');
	}	

}

