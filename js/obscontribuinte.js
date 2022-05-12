var vusuario = 0;

// JavaScript Document
function inicia(usucodigo){

	vusuario = usucodigo;	
   	new ajax ('obscontribuinteseleciona.php?usucodigo='+ vusuario 
        , {onComplete: imprime_serv});
		
}

function imprime_serv(request){

    limpa_form();
	$("msg").style.visibility="hidden";
	var xmldoc=request.responseXML;
	var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];

	if(cabecalho!=null)
	{
		var campo = cabecalho.getElementsByTagName('campo');
		var tabela="<table class='borda'><tr>"

		tabela+="<td colspan='0'></td>"
		tabela+="<td colspan='1' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Identificador</b></font></td>"
		tabela+="<td colspan='1' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Observacao</b></font></td>"			
		tabela+="<td colspan='2' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Controles</b></font></td>"
		tabela+="<td colspan='0'></td>"
		tabela+="</tr>"

		//corpo da tabela
		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++){
			var itens = registros[i].getElementsByTagName('item');
			
			var aux_obs = itens[2].firstChild.data;
			aux_obs = aux_obs.substring(0, 40);
			
			tabela+="<tr id=linha"+i+">"
			tabela+="<td class='borda2' >"+itens[0].firstChild.data+"</td>";
			tabela+="<td class='borda' >"+itens[1].firstChild.data+"</td>";	
			tabela+="<td class='borda' >"+aux_obs+"</td>";			
			tabela+='<td class="borda" style="cursor: pointer"><img src="imagens/edit.gif" onClick=editar('+itens[0].firstChild.data+')></td>';
			tabela+="<td class='borda' style='cursor: pointer'><img src='imagens/delete.gif' onClick=apagar("+itens[0].firstChild.data+")></td>";
			tabela+="<td class='borda2' >"+itens[0].firstChild.data+"</td>";
			tabela+="</tr>";
		}

		tabela+="</table>"
		$("resultado").innerHTML=tabela;
		tabela=null;
	}
	else
		$("resultado").innerHTML="Nenhum registro encontrado...";
}

function load_grid_serv(){

	new ajax ('obscontribuinteseleciona.php?usucodigo='+ vusuario
        , {onComplete: pesquisar_serv});

}

function pesquisar_serv(){

	$("resultado").innerHTML="";
	
	new ajax ('obscontribuinteseleciona.php?usucodigo='+ vusuario
        , {onComplete: imprime_serv});
		
}

function enviar(){

	var codservico = document.getElementById('codservico').value;	
	var servico = document.getElementById('servico').value;
	var obsgeral = document.getElementById('obsgeral').value;	
		
	var erro = 0;

	if(servico=='')
	{
		alert("Digite o Identificador!");		
		erro = 1;
	}
	else if(obsgeral=='')
		{
			alert("Digite a Observação!");			
			erro = 1;
		}		 
		
	
	//Grava os Servicos
	if(erro=='0'){	
	
		//window.open ('obscontribuinteinsere.php?usucodigo='+ vusuario
		new ajax ('obscontribuinteinsere.php?usucodigo='+ vusuario		
		+ '&codservico='+ codservico
        + '&servico='+ servico
		+ '&obsgeral=' + obsgeral			
		, {onLoading: carregando, onComplete: load_grid_serv});
		//, '_blank');
        
	}
	
}


function apagar(codigo){
    new ajax ('obscontribuinteapaga.php?codigo=' + codigo
        , {onLoading: carregando, onComplete: load_grid_serv});
}

function editar(codigo){

	new ajax ('obscontribuintecarrega.php?parametro='+ codigo 
        , {onComplete: imprime_dados});
	
}

function limpa_form(){
	
	$("codservico").value="";
	$("servico").value="";
	$("obsgeral").value="";
		
}

function carregando(){	
}

function imprime_dados(request){

	var xmldoc=request.responseXML;
	var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];

	if(cabecalho!=null)
	{
		var campo = cabecalho.getElementsByTagName('campo');		

		//corpo da tabela
		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++){
		
			var itens = registros[i].getElementsByTagName('item');
				
			$("codservico").value=itens[0].firstChild.data;			
			$("servico").value=itens[1].firstChild.data;
			$("obsgeral").value=itens[2].firstChild.data;	
						
		}		
	}
	else {
		$("codservico").value="";			
		$("servico").value="";			
		$("obsgeral").value="";		
	}
		
}
   