var vusuario = 0;

// JavaScript Document
function inicia(usucodigo){

	vusuario = usucodigo;

	new ajax ('valorservicoseleciona.php?usucodigo='+ usucodigo 
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
		tabela+="<td colspan='1' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Servico</b></font></td>"		
		tabela+="<td colspan='1' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Valor</b></font></td>"		
		tabela+="<td colspan='2' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Controles</b></font></td>"
		tabela+="<td colspan='0'></td>"
		tabela+="</tr>"

		//corpo da tabela
		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++){
			var itens = registros[i].getElementsByTagName('item');
			tabela+="<tr id=linha"+i+">"
			tabela+="<td class='borda2' >"+itens[0].firstChild.data+"</td>";						
			tabela+="<td class='borda' >"+itens[1].firstChild.data+"</td>";
			tabela+="<td class='borda' align='right'>"+itens[2].firstChild.data+"</td>";				
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


function format_val(rnum,id)
{

	if(rnum.indexOf(',')!=-1)
	{
		rnum = rnum.replace(",",".");		
	}
	
	if (isNaN(rnum)==true){
	
		alert("O campo Valor deve ser preenchido corretamente!");
		$(id).value="";
		return;
	}
	
   	if(rnum > 0)
   	{
		var valor1 = Math.round(rnum*Math.pow(10,2))/Math.pow(10,2);
	   	var valor2;
	
	   	if (valor1>=1)
	   	{
		   	valor1 =  valor1*100;
		   	valor1 = Math.round(valor1);
		   	valor1 =  valor1.toString();
		   	valor2 = valor1.substring(0,valor1.length-2)+'.'+valor1.substring(valor1.length-2,valor1.length);
	
		   	if (valor2=='.0'){valor2='0.00'}
		   	if (valor2=='N.aN'){valor2='0.00'}
	   	}
	   	else
	   	{
			valor2 = (valor1.format(2, ".", ","));
	   	}
	   	$(id).value=valor2;
	}
	else if(rnum < 0)
   	{		
		valor2='0.00';
	   	$(id).value='-'+valor2;
	}
	
}   



function load_grid_serv(){

	new ajax ('valorservicoseleciona.php?usucodigo='+ vusuario
        , {onComplete: pesquisar_serv});

}

function pesquisar_serv(){

	$("resultado").innerHTML="";
	
	new ajax ('valorservicoseleciona.php?usucodigo='+ vusuario
        , {onComplete: imprime_serv});
		
}

function enviar(){

	var codservico = document.getElementById('codservico').value;	
	var servico = document.getElementById('servico').value;	
	var valor 	= document.getElementById('valor').value;	
	
	var erro = 0;

	if(servico=='')
	{
		alert("Digite o nome do Servico!");		
		erro = 1;
	}
	else if(valor==0 || valor=='' || valor=='0.00')
		{
			alert("Digite o Valor!");			
			erro = 1;
		}		 
		
	
	//Grava os Servicos
	if(erro=='0'){	
	
		//window.open ('valorservicoinsere.php?usucodigo='+ vusuario
		new ajax ('valorservicoinsere.php?usucodigo='+ vusuario		
		+ '&codservico='+ codservico
        + '&servico='+ servico
		+ '&valor=' + valor		
		, {onLoading: carregando, onComplete: load_grid_serv});
		//, '_blank');
        
	}
	
}


function apagar(codigo){
    new ajax ('valorservicoapaga.php?codigo=' + codigo
        , {onLoading: carregando, onComplete: load_grid_serv});
}

function editar(codigo){

	new ajax ('valorservicocarrega.php?parametro='+ codigo 
        , {onComplete: imprime_dados});
	
}

function limpa_form(){
	
	$("codservico").value="";
	$("servico").value="";
	$("valor").value="";
	
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
			$("valor").value=itens[2].firstChild.data;
			
		}		
	}
	else {
		$("codservico").value="";				
		$("servico").value="";			
		$("valor").value="";		
	}
		
}
   