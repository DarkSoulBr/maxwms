var vusuario = 0;

// JavaScript Document
function inicia(usucodigo){

	vusuario = usucodigo;
	
	dadospesquisamedida(0);
	
}

function dadospesquisamedida(valor)
{
  //verifica se o browser tem suporte a ajax
  try {
     ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
  } 
  catch(e) {
     try {
        ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
     }
     catch(ex) {
        try {
           ajax2 = new XMLHttpRequest();
        }
        catch(exc) {
           alert("Esse browser não tem recursos para uso do Ajax");
           ajax2 = null;
        }
     }
  }
  //se tiver suporte ajax
  if(ajax2) {
     //deixa apenas o elemento 1 no option, os outros são excluídos
	 document.forms[0].listgrupos.options.length = 1;
     
	 idOpcao  = document.getElementById("opcoes2");
	 
     ajax2.open("POST", "ctepesquisamedida.php", true);
	 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	 
	 ajax2.onreadystatechange = function() {
        //enquanto estiver processando...emite a msg de carregando
		if(ajax2.readyState == 1) {
		   idOpcao.innerHTML = "Carregando...!";   
        }
		//após ser processado - chama função processXML que vai varrer os dados
        if(ajax2.readyState == 4 ) {
		   if(ajax2.responseXML) {
		      processXMLgrupo(ajax2.responseXML);				  
		   }
		   else {
		       //caso não seja um arquivo XML emite a mensagem abaixo
			   idOpcao.innerHTML = "____________________";
		   }
        }
     }
	 //passa o parametro
     var params = "parametro="+valor;
     ajax2.send(params);
  }
}

function processXMLgrupo(obj)
{
	//pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");
      
	//total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		//percorre o arquivo XML paara extrair os dados

		document.forms[0].listgrupos.options.length = 0;	

        for(var i = 0 ; i < dataArray.length ; i++)
        {
            var item = dataArray[i];
			//contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			
			trimjs(codigo);
       		codigo = txt;
			trimjs(descricao);
			descricao  = txt;

         	//idOpcao.innerHTML = "";
			
			//cria um novo option dinamicamente  
			var novo = document.createElement("option");
		    //atribui um ID a esse elemento
		    novo.setAttribute("id", "opcoes2");
			//atribui um valor
		    novo.value = codigo;
			//atribui um texto
		    novo.text  = descricao;
			//finalmente adiciona o novo elemento
			document.forms[0].listgrupos.options.add(novo);
		}
	}
	else
	{
		//caso o XML volte vazio, printa a mensagem abaixo
	    idOpcao.innerHTML = "____________________";	
	}	 
	
   	new ajax ('infocargaseleciona.php?usucodigo='+ vusuario 
        , {onComplete: imprime_serv});
		
}

function itemcombogrupo(valor)
{
	y = document.forms[0].listgrupos.options.length;

	for(var i = 0 ; i < y ; i++)
	{
	    document.forms[0].listgrupos.options[i].selected = true;
		var l = document.forms[0].listgrupos;
		//var li = l.options[l.selectedIndex].text;
  		var li = l.options[l.selectedIndex].value;
		if(li==valor){
			i=y;
		}
	}
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
		tabela+="<td colspan='1' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Unidade</b></font></td>"
		tabela+="<td colspan='1' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Tipo</b></font></td>"	
		tabela+="<td colspan='1' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Quantidade</b></font></td>"		
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
			tabela+="<td class='borda' >"+itens[2].firstChild.data+"</td>";
			tabela+="<td class='borda' align='right'>"+itens[3].firstChild.data+"</td>";				
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
		var valor1 = Math.round(rnum*Math.pow(10,4))/Math.pow(10,4);
	   	var valor2;
	
	   	if (valor1>=1)
	   	{
		   	valor1 =  valor1*10000;
		   	valor1 = Math.round(valor1);
		   	valor1 =  valor1.toString();
		   	valor2 = valor1.substring(0,valor1.length-4)+'.'+valor1.substring(valor1.length-4,valor1.length);
	
		   	if (valor2=='.0'){valor2='0.0000'}
		   	if (valor2=='N.aN'){valor2='0.0000'}
	   	}
	   	else
	   	{
			valor2 = (valor1.format(2, ".", ","));
	   	}
	   	$(id).value=valor2;
	}
	else if(rnum <= 0)
   	{		
		valor2='0.0000';
	   	$(id).value=valor2;
	}
	
}   



function load_grid_serv(){

	new ajax ('infocargaseleciona.php?usucodigo='+ vusuario
        , {onComplete: pesquisar_serv});

}

function pesquisar_serv(){

	$("resultado").innerHTML="";
	
	new ajax ('infocargaseleciona.php?usucodigo='+ vusuario
        , {onComplete: imprime_serv});
		
}

function enviar(){

	var codservico = document.getElementById('codservico').value;	
	var servico = document.getElementById('servico').value;	
	var valor 	= document.getElementById('valor').value;	
	var grupo = document.forms[0].listgrupos.options[document.forms[0].listgrupos.selectedIndex].value;
	
	var erro = 0;

	if(servico=='')
	{
		alert("Digite o tipo de Medida!");		
		erro = 1;
	}
	else if(valor==0 || valor=='' || valor=='0.0000')
		{
			alert("Digite a Quantidade!");			
			erro = 1;
		}		 
		
	
	//Grava os Servicos
	if(erro=='0'){	
	
		//window.open ('infocargainsere.php?usucodigo='+ vusuario
		new ajax ('infocargainsere.php?usucodigo='+ vusuario		
		+ '&codservico='+ codservico
        + '&servico='+ servico
		+ '&valor=' + valor	
		+ '&grupo=' + grupo		
		, {onLoading: carregando, onComplete: load_grid_serv});
		//, '_blank');
        
	}
	
}


function apagar(codigo){
    new ajax ('infocargaapaga.php?codigo=' + codigo
        , {onLoading: carregando, onComplete: load_grid_serv});
}

function editar(codigo){

	new ajax ('infocargacarrega.php?parametro='+ codigo 
        , {onComplete: imprime_dados});
	
}

function limpa_form(){
	
	$("codservico").value="";
	$("servico").value="";
	$("valor").value="";
	itemcombogrupo(0);
	
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
			itemcombogrupo(itens[1].firstChild.data);	
			$("servico").value=itens[2].firstChild.data;			
			$("valor").value=itens[3].firstChild.data;
			
		}		
	}
	else {
		$("codservico").value="";	
		itemcombogrupo(0);	
		$("servico").value="";			
		$("valor").value="";		
	}
		
}
   