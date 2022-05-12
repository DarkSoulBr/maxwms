// JavaScript Document

function enviar(){

	new ajax ('cidadealteratransp.php?cidcodigo=' + document.getElementById('cidcodigo').value 
	+ '&transp=' + document.getElementById('nome_transportadora').value
	+ '&prazo=' + document.getElementById('prazo').value
	, {});		

	document.forms[0].listDados.options.length = 0;	

	var novo = document.createElement("option");
	//atribui um ID a esse elemento
	novo.setAttribute("id", "opcoes");
	//atribui um valor
	novo.value = document.getElementById('cidcodigo').value;
	//atribui um texto
	novo.text  = document.getElementById('cidnome').value;
	//finalmente adiciona o novo elemento
	document.forms[0].listDados.options.add(novo);
	
	alert('Transportadora alterada com sucesso!');

}

function apagar(cidcodigo){
	new ajax ('cidadeapaga.php?cidcodigo=' + cidcodigo, {});	
	limpa_form();
}

function valida_form(){
	
	if($("cidnome").value==""){
		alert("Preencha o campo cidade")
		return false;
	}
	else {
		if(document.getElementById('nome_transportadora').value=="")
		{
			alert("Preencha o campo Transportadora!");
			$('consulta_transportadora').focus();			
		}
		else {	
			if(document.getElementById('prazo').value=="")
			{
				alert("Informe o Prazo!");
				$('prazo').focus();			
			}
			else {			
				enviar();
			}	
		}	
	}	
}

function limpa_form(){
	$("acao").value="inserir";		
	document.getElementById("botao-text").innerHTML = "Incluir";
	$("cidcodigo").value="";
	$("cidnome").value="";	
	$("pesquisa").value="";
	$("prazo").value="";
	$("trans").value="";
	document.getElementById("consulta_transportadora").value = '';	
	document.getElementById('nome_transportadora').value = '';
 	document.forms[0].listDados.options.length = 1;
	 if (document.querySelector('#opcoes')){
        idOpcao = document.getElementById("opcoes");
        idOpcao.innerHTML = "Faça a Pesquisa de Cidade";
 	}

	document.forms[0].listestados.options[0].selected = true;
	
	var tabela='<span class="custom-dropdown"><select id="pesquisar_transportadora" name="pesquisar_transportadora" size="1" onchange="setar_transportadora(this);">';
	tabela+="<option value=\"0\">-- Escolha um transportadora --</option>";
    tabela+="</select></span>"
	$("resultado_transportadora").innerHTML=tabela;

}

function limpa_form2(){

	$("acao").value="alterar";	
	document.getElementById("botao-text").innerHTML = "Alterar";
	$("cidcodigo").value="";
	$("cidnome").value="";	
	$("trans").value="";	
	$("prazo").value="";
	document.getElementById("consulta_transportadora").value = '';
	document.getElementById('nome_transportadora').value = '';
	document.forms[0].listestados.options[0].selected = true;		
	
	var tabela='<span class="custom-dropdown"><select id="pesquisar_transportadora" name="pesquisar_transportadora" size="1" onchange="setar_transportadora(this);">';
	tabela+="<option value=\"0\">-- Escolha um transportadora --</option>";
    tabela+="</select></span>"
	$("resultado_transportadora").innerHTML=tabela;

}

function verifica1(){
	if(confirm("Tem certeza que deseja Excluir?\n\t") ){
		apagar($("cidcodigo").value);} 
}

function verifica(){
	if($("cidcodigo").value==""){
	alert("Nenhum Registro Selecionado!");
	}
	else{
		verifica1();} 
}

function pesquisa1(valor) {
	trimjs(valor);
	valor = txt;
	if(valor==""){
		alert("Preencha o campo pesquisa !");
		return false;
	}
	else{
		dadospesquisa(valor);
	}
}

function dadospesquisa(valor) {
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
		 document.forms[0].listDados.options.length = 1;

		 idOpcao  = document.getElementById("opcoes");

	     ajax2.open("POST", "cidadepesquisatransp.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		 
		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";   
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXML(ajax2.responseXML);
			   }
			   else {
			       //caso não seja um arquivo XML emite a mensagem abaixo
				   idOpcao.innerHTML = "Faça a Pesquisa de Cidade";
			   }
            }
         }
		 //passa o parametro
	     var params = "parametro="+valor;
         ajax2.send(params);
      }
   }


function dadospesquisa2(valor) {
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
		 
		 ajax2.open("POST", "cidadepesquisatransp2.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	 
		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {

	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXML2(ajax2.responseXML);
			   }
			   else {
			       //caso não seja um arquivo XML emite a mensagem abaixo

			   }
            }
         }
		 //passa o parametro escolhido
	     var params = "parametro="+valor;
         ajax2.send(params);
      }
   }


function dadospesquisa3(valor) {
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
		 document.forms[0].listDados.options.length = 1;
	     
		 idOpcao  = document.getElementById("opcoes");
		 
	     ajax2.open("POST", "cidadepesquisatransp3.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		 
		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";   
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXML(ajax2.responseXML);
			   }
			   else {
			       //caso não seja um arquivo XML emite a mensagem abaixo
				   idOpcao.innerHTML = "Faça a Pesquisa de Cidade";
			   }
            }
         }
		 //passa o parametro escolhido
	     var params = "parametro="+valor;
         ajax2.send(params);
      }
   }
   


   function processXML(obj){


      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");
      
	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados

	document.forms[0].listDados.options.length = 0;	

         for(var i = 0 ; i < dataArray.length ; i++) {
            var item = dataArray[i];
			//contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var descricao2 =  item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;		
			var descricao3 =  item.getElementsByTagName("descricao3")[0].firstChild.nodeValue;		
			var descricao4 =  item.getElementsByTagName("descricao4")[0].firstChild.nodeValue;
			var descricao5 =  item.getElementsByTagName("descricao5")[0].firstChild.nodeValue;
			
			trimjs(codigo);
       		codigo = txt;
			trimjs(descricao);
			descricao  = txt;
			trimjs(descricao2);
			descricao2 = txt;	
			
			trimjs(descricao4);
			descricao4 = txt;	
			trimjs(descricao5);
			descricao5 = txt;	
				        
			//cria um novo option dinamicamente  
			var novo = document.createElement("option");
			    //atribui um ID a esse elemento
			    novo.setAttribute("id", "opcoes");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].listDados.options.add(novo);

			if(i==0){
			
				$("cidcodigo").value=codigo;
				$("cidnome").value=descricao;
				$("prazo").value=descricao5;
				
				document.getElementById("opcao_transportadora1").checked = true;
				
				if(descricao3=='0'){
					$("trans").value='';
					document.getElementById("consulta_transportadora").value = '';
					document.getElementById('nome_transportadora').value = '';
					
					var tabela='<span class="custom-dropdown"><select id="pesquisar_transportadora" name="pesquisar_transportadora" size="1" onchange="setar_transportadora(this);">';
					tabela+="<option value=\"0\">-- Escolha um transportadora --</option>";
					tabela+="</select></span>"
					$("resultado_transportadora").innerHTML=tabela;
					
				}
				else {
					$("trans").value=descricao3+' '+descricao4;
					document.getElementById("consulta_transportadora").value = descricao3;
					vertransportadora();
				}	
				
				$("acao").value="alterar";	
				document.getElementById("botao-text").innerHTML = "Alterar";
				
				itemcombo(descricao2);

			}

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo

		$("cidcodigo").value="";
		$("cidnome").value="";
		$("trans").value="";	
		$("prazo").value="";	
		document.getElementById("consulta_transportadora").value = '';	
		document.getElementById('nome_transportadora').value = '';
		$("acao").value="alterar";	
		document.getElementById("botao-text").innerHTML = "Alterar";

		idOpcao.innerHTML = "Faça a Pesquisa de Cidade";

	  }	  
   }



   function processXML2(obj){
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");
      
	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados
         for(var i = 0 ; i < dataArray.length ; i++) {
            var item = dataArray[i];
		//contéudo dos campos no arquivo XML
		var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
		var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
		var descricao2 =  item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;
		var descricao3 =  item.getElementsByTagName("descricao3")[0].firstChild.nodeValue;
		var descricao4 =  item.getElementsByTagName("descricao4")[0].firstChild.nodeValue;
		var descricao5 =  item.getElementsByTagName("descricao5")[0].firstChild.nodeValue;		

		trimjs(codigo);
	    codigo = txt;
		trimjs(descricao);
		descricao  = txt;
		trimjs(descricao2);
		descricao2 = txt;	
		trimjs(descricao4);
		descricao4 = txt;	
		trimjs(descricao5);
		descricao5 = txt;	
		
	    $("cidcodigo").value=codigo;
		$("cidnome").value=descricao;
		$("prazo").value=descricao5;
		
		document.getElementById("opcao_transportadora1").checked = true;
		
		if(descricao3=='0'){
			$("trans").value='';
			document.getElementById("consulta_transportadora").value = '';
			document.getElementById('nome_transportadora').value = '';
			
			var tabela='<span class="custom-dropdown"><select id="pesquisar_transportadora" name="pesquisar_transportadora" size="1" onchange="setar_transportadora(this);">';
			tabela+="<option value=\"0\">-- Escolha um transportadora --</option>";
			tabela+="</select></span>"
			$("resultado_transportadora").innerHTML=tabela;
			
		}
		else {
			$("trans").value=descricao3+' '+descricao4;
			document.getElementById("consulta_transportadora").value = descricao3;
			vertransportadora();
		}
		
						
		$("acao").value="alterar";	
		document.getElementById("botao-text").innerHTML = "Alterar";

		itemcombo(descricao2);
		
		
		

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo

				$("cidcodigo").value="";
				$("cidnome").value="";
				$("trans").value="";	
				$("prazo").value="";	
				document.getElementById("consulta_transportadora").value = '';	
				document.getElementById('nome_transportadora').value = '';
				$("acao").value="alterar";	
				document.getElementById("botao-text").innerHTML = "Alterar";
				
				var tabela='<span class="custom-dropdown"><select id="pesquisar_transportadora" name="pesquisar_transportadora" size="1" onchange="setar_transportadora(this);">';
				tabela+="<option value=\"0\">-- Escolha um transportadora --</option>";
				tabela+="</select></span>"
				$("resultado_transportadora").innerHTML=tabela;
				
				

	  }	  
   }  




function dadospesquisaestado(valor) {
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
		 document.forms[0].listestados.options.length = 1;
	     
		 idOpcao  = document.getElementById("opcoes2");
		 
	     ajax2.open("POST", "cidadepesquisaestado.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		 
		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";   
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXMLestado(ajax2.responseXML);
			   }
			   else {
			       //caso não seja um arquivo XML emite a mensagem abaixo
				   idOpcao.innerHTML = "Faça a Pesquisa de Cidade";
			   }
            }
         }
		 //passa o parametro
	     var params = "parametro="+valor;
         ajax2.send(params);
      }
   }



   function processXMLestado(obj){
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");
      
	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados

	document.forms[0].listestados.options.length = 0;	

         for(var i = 0 ; i < dataArray.length ; i++) {
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
				document.forms[0].listestados.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcao.innerHTML = "Faça a Pesquisa de Cidade";

	  }	  
   }



function itemcombo(valor){
	
	y = document.forms[0].listestados.options.length;

	for(var i = 0 ; i < y ; i++) {
	
	    document.forms[0].listestados.options[i].selected = true;
		var l = document.forms[0].listestados;
		//var li = l.options[l.selectedIndex].text;
  		var li = l.options[l.selectedIndex].value;
		if(li==valor){
			i=y;
		}
			
	}
}	


function vertransportadora(){
	if (document.getElementById("consulta_transportadora").value!=''){
	    if(document.getElementById("opcao_transportadora1").checked == true)
	    {
		   load_grid_transportadora();
		}
	}
}

//---------------- transportadora ---------------------------//
function load_grid_transportadora()
{
	var opcaochecada_transportadora = '';
	var consulta_transportadora = '';

	if(document.getElementById("opcao_transportadora1").checked == true)
	opcaochecada_transportadora = "1";

	if(document.getElementById("opcao_transportadora2").checked == true)
	opcaochecada_transportadora = "2";

	if(document.getElementById("opcao_transportadora3").checked == true)
	opcaochecada_transportadora = "3";

	consulta_transportadora = document.getElementById("consulta_transportadora").value;

	document.getElementById('pesquisar_transportadora').disabled = false;
	document.getElementById('nome_transportadora').disabled = false;

    var tabela='<span class="custom-dropdown"><select id="pesquisar_transportadora" name="pesquisar_transportadora" size="1" onchange="setar_transportadora(this);">';
	tabela+="<option value=\"0\">-- Escolha um transportadora --</option>";
    tabela+="</select></span>"
	$("resultado_transportadora").innerHTML=tabela;

	new ajax('consultatransportadoras.php?opcao='+opcaochecada_transportadora+'&consultatransportadora='+consulta_transportadora, {onLoading: carregando_transportadora, onComplete: imprime_transportadora});
}

function carregando_transportadora(){
	$("msg_transportadora").style.visibility="visible";
	$("msg_transportadora").innerHTML="Processando...";
}

function imprime_transportadora(request){

	$("msg_transportadora").style.visibility="hidden";
	var xmldoc=request.responseXML;

    var dados = xmldoc.getElementsByTagName('dados')[0];

    var contador = '0';
	var tabela='<span class="custom-dropdown"><select id="pesquisar_transportadora" name="pesquisar_transportadora" size="1" onchange="setar_transportadora(this);">';
	tabela+="<option value=\"0\">-- Escolha um transportadora --</option>";

    if(dados!=null)
	{
        //corpo da tabela
		var registros = xmldoc.getElementsByTagName('registro');
		//alert(registros.length);
		for(i=0;i<registros.length;i++)
		{
			var itens = registros[i].getElementsByTagName('item');
			if(itens[2].firstChild.data==null)
			{
           		tabela+='<option value="'+itens[0].firstChild.data+'">'+itens[1].firstChild.data+'</option>\n"';
            }
            else tabela+='<option value="'+itens[0].firstChild.data+'">'+itens[1].firstChild.data+' '+itens[2].firstChild.data+'</option>\n"';
		}
	}
    tabela+="</select></span>"
	$("resultado_transportadora").innerHTML=tabela;
	tabela="";

	if (registros.length==1){
		document.getElementById('pesquisar_transportadora').value = itens[0].firstChild.data;
		document.getElementById('nome_transportadora').value = document.getElementById('pesquisar_transportadora').value;
	}
	document.getElementById('pesquisar_transportadora').focus();
    //alert(tabela);
}

function setar_transportadora(obj)
{
	document.getElementById('nome_transportadora').value = obj.value;
}
//-----------------------------------------------------------//

function SomenteNumero(e){
 var tecla=(window.event)?event.keyCode:e.which;
 if((tecla>47 && tecla<58)) return true;
 else{
 if (tecla==8 || tecla==0) return true;
 else  return false;
 }
}