// JavaScript Document

function enviar(){

	if ( document.getElementById("radio1").checked==true){
		suframa = 'S';
	}
	else{
		suframa = 'N';
	}

	if($("acao").value=="inserir"){
	
		valor = document.getElementById('cidnome').value;
		new ajax ('cidadeinsere.php?estcodigo=' + document.getElementById('cidcodigo').value +
                 '&cidnome=' + document.getElementById('cidnome').value +
                 '&estcodigo=' + document.forms[0].listestados.options[document.forms[0].listestados.selectedIndex].value +
                 '&cep=' + document.getElementById('cep').value + 
				 '&suframa=' + suframa
                 , {});

		limpa_form();
		dadospesquisa3(valor);

	}
	else if($("acao").value=="alterar"){
		new ajax ('cidadealtera.php?cidcodigo=' + document.getElementById('cidcodigo').value + '&cidnome=' + document.getElementById('cidnome').value + "&cidcodigo=" + document.getElementById('cidcodigo').value + '&estcodigo=' + document.forms[0].listestados.options[document.forms[0].listestados.selectedIndex].value + '&cep=' + document.getElementById('cep').value + '&suframa=' + suframa, {});		


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

}
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
	else	
		enviar();
}

function limpa_form(){
	$("acao").value="inserir";		
	document.getElementById("botao-text").innerHTML = "Incluir";
	$("cidcodigo").value="";
	$("cidnome").value="";	
	$("pesquisa").value="";
	$("cep").value="";
	document.getElementById("radio2").checked=true;
	
 	document.forms[0].listDados.options.length = 1;
	 if (document.querySelector('#opcoes')){
        idOpcao = document.getElementById("opcoes");
        idOpcao.innerHTML = "Faça a Pesquisa de Cidade";
 	}  

	document.forms[0].listestados.options[0].selected = true;

}

function limpa_form2(){
	$("acao").value="inserir";		
	document.getElementById("botao-text").innerHTML = "Incluir";
	$("cidcodigo").value="";
	$("cidnome").value="";	
	$("cep").value="";	
	document.getElementById("radio2").checked=true;
	document.forms[0].listestados.options[0].selected = true;		

}

function verifica1(){
	if(confirm("Tem certeza que deseja Excluir?") ){
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

	     ajax2.open("POST", "cidadepesquisa.php", true);
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
		 
		 ajax2.open("POST", "cidadepesquisa2.php", true);
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
		 
	     ajax2.open("POST", "cidadepesquisa3.php", true);
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
			//266
			var descricao3 =  item.getElementsByTagName("descricao3")[0].firstChild.nodeValue;		
			var descricao7 =  item.getElementsByTagName("descricao7")[0].firstChild.nodeValue;		

			trimjs(codigo);
	       		codigo = txt;
			trimjs(descricao);
			descricao  = txt;
			trimjs(descricao2);
			descricao2 = txt;	
			
			trimjs(descricao7);
			descricao7 = txt;

	         	//idOpcao.innerHTML = "";
			
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
				$("cep").value=descricao3;
				
				if (descricao7=='S'){
				   document.getElementById("radio1").checked=true;				 
				}
				else{
				   document.getElementById("radio2").checked=true;
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
		$("cep").value="";
		document.getElementById("radio2").checked==true;
		
		$("acao").value="inserir";	
		document.getElementById("botao-text").innerHTML = "Incluir";

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
		var descricao7 =  item.getElementsByTagName("descricao7")[0].firstChild.nodeValue;		

		trimjs(codigo);
	       	codigo = txt;
		trimjs(descricao);
		descricao  = txt;
		trimjs(descricao2);
		descricao2 = txt;	
		trimjs(descricao7);
		descricao7 = txt;

		//Carrega os dados
	
	        $("cidcodigo").value=codigo;
		$("cidnome").value=descricao;
		$("cep").value=descricao3;
		
		if (descricao7=='S'){
			document.getElementById("radio1").checked=true;				 
		}
		else{
			document.getElementById("radio2").checked=true;
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
				document.getElementById("radio2").checked==true;
				$("cep").value="";
				$("acao").value="inserir";	
				document.getElementById("botao-text").innerHTML = "Incluir";

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

