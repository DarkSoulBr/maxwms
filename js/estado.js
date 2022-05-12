// JavaScript Document

function enviar(){

	valor = document.getElementById('estnome').value;

	if($("acao").value=="inserir"){
		new ajax ('estadoinsere.php?estsigla=' + document.getElementById('estsigla').value 
		+ '&estnome=' + document.getElementById('estnome').value
		+ '&esticms2=' + document.getElementById('esticms2').value
		+ '&esticms3=' + document.getElementById('esticms3').value
		+ '&estnfe=' + document.getElementById('estnfe').value
		+ '&esticms=' + document.getElementById('esticms').value, {});	

	limpa_form();
	dadospesquisa3(valor);

}
	else if($("acao").value=="alterar"){
		new ajax ('estadoaltera.php?estsigla=' + document.getElementById('estsigla').value
		+ '&estnome=' + document.getElementById('estnome').value
		+ "&estcodigo=" + document.getElementById('estcodigo').value
		+ '&esticms2=' + document.getElementById('esticms2').value
		+ '&esticms3=' + document.getElementById('esticms3').value
		+ '&estnfe=' + document.getElementById('estnfe').value
		+ '&esticms=' + document.getElementById('esticms').value, {});		


	document.forms[0].listDados.options.length = 0;	
    	         	
	var novo = document.createElement("option");
	//atribui um ID a esse elemento
	novo.setAttribute("id", "opcoes");
	//atribui um valor
	novo.value = document.getElementById('estcodigo').value;
	//atribui um texto
	novo.text  = document.getElementById('estnome').value;
	//finalmente adiciona o novo elemento
	document.forms[0].listDados.options.add(novo);

}
}

function apagar(estcodigo){
	new ajax ('estadoapaga.php?estcodigo=' + estcodigo, {});	
	limpa_form();
}

function valida_form(){


	if($("estsigla").value==""){
		alert("Preencha o campo Sigla")
		return false;
	}		
	else if($("estnome").value==""){
		alert("Preencha o campo Estado")
		return false;
	}
	else if($("esticms").value==""){
		alert("Preencha o campo ICMS")
		return false;
	}	
	else if(isNaN($("esticms").value)== true){
		alert("O ICMS deve ser numérico!")
		return false;
	}
	else if($("esticms2").value==""){
		alert("Preencha o campo Aliquota Interna")
		return false;
	}	
	else if(isNaN($("esticms2").value)== true){
		alert("O campo Aliquota Interna deve ser numérico!")
		return false;
	}
	else if($("esticms3").value==""){
		alert("Preencha o campo Percentual de Combate a Pobreza")
		return false;
	}	
	else if(isNaN($("esticms3").value)== true){
		alert("O campo Percentual de Combate a Pobreza deve ser numérico!")
		return false;
	}
	else if($("estnfe").value==""){
		alert("Preencha o campo Percentual de Serviço sobre NFe")
		return false;
	}	
	else if(isNaN($("estnfe").value)== true){
		alert("O campo Percentual de Serviço sobre NFe deve ser numérico!")
		return false;
	}	
	else	
		enviar();
}

function limpa_form(){
	$("acao").value="inserir";		
	document.getElementById("botao-text").innerHTML = "Incluir";
	$("estcodigo").value="";
	$("estsigla").value="";
	$("estnome").value="";	
	$("esticms").value="";	
	$("esticms2").value="";
	$("esticms3").value="";
	$("estnfe").value="";
	$("pesquisa").value="";
 	document.forms[0].listDados.options.length = 1;
	 if (document.querySelector('#opcoes')){
        idOpcao = document.getElementById("opcoes");
        idOpcao.innerHTML = "Faça a Pesquisa de Estado";
 	}  
}

function limpa_form2(){
	$("acao").value="inserir";		
	document.getElementById("botao-text").innerHTML = "Incluir";
	$("estcodigo").value="";
	$("estsigla").value="";
	$("estnome").value="";	
	$("esticms").value="";
	$("esticms2").value="";
	$("esticms3").value="";
	$("estnfe").value="";	
}

function verifica1(){
	if(confirm("Tem certeza que deseja Excluir?") ){
		apagar($("estcodigo").value);} 
}

function verifica(){
	if($("estcodigo").value==""){
	alert("Nenhum Registro Selecionado!");
	}
	else{
		verifica1();} 
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
		 
	     ajax2.open("POST", "estadopesquisa.php", true);
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
				   idOpcao.innerHTML = "Faça a Pesquisa de Estado";
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
		 
		 ajax2.open("POST", "estadopesquisa2.php", true);
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
		 
	     ajax2.open("POST", "estadopesquisa3.php", true);
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
				   idOpcao.innerHTML = "Faça a Pesquisa de Estado";
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
			var descricao1 =  item.getElementsByTagName("descricao1")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var descricao3 =  item.getElementsByTagName("descricao3")[0].firstChild.nodeValue;
			var descricao4 =  item.getElementsByTagName("descricao4")[0].firstChild.nodeValue;
			var descricao5 =  item.getElementsByTagName("descricao5")[0].firstChild.nodeValue;
			var descricao6 =  item.getElementsByTagName("descricao6")[0].firstChild.nodeValue;
	         	//idOpcao.innerHTML = "";
			

			trimjs(codigo);
	       		codigo = txt;
			trimjs(descricao1);
			descricao1  = txt;
			trimjs(descricao);
			descricao = txt;
			trimjs(descricao3);
			descricao3 = txt;
			trimjs(descricao4);descricao4 = txt;
			trimjs(descricao5);descricao5 = txt;
			trimjs(descricao6);descricao6 = txt;

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
				$("estcodigo").value=codigo;
		 		$("estsigla").value=descricao1;
				$("estnome").value=descricao;
				$("esticms").value=descricao3;
				$("esticms2").value=descricao4;
				$("esticms3").value=descricao5;
				$("estnfe").value=descricao6;
				$("acao").value="alterar";	
				document.getElementById("botao-text").innerHTML = "Alterar";	
			}

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo

		$("estcodigo").value="";
		$("estsigla").value="";
		$("estnome").value="";
		$("esticms").value="";
		$("esticms2").value="";
		$("esticms3").value="";
		$("estnfe").value="";
		$("acao").value="inserir";	
		document.getElementById("botao-text").innerHTML = "Incluir";

		idOpcao.innerHTML = "Faça a Pesquisa de Estado";

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
			var descricao1 =  item.getElementsByTagName("descricao1")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var descricao3 =  item.getElementsByTagName("descricao3")[0].firstChild.nodeValue;
			var descricao4 =  item.getElementsByTagName("descricao4")[0].firstChild.nodeValue;
			var descricao5 =  item.getElementsByTagName("descricao5")[0].firstChild.nodeValue;
			var descricao6 =  item.getElementsByTagName("descricao6")[0].firstChild.nodeValue;


			trimjs(codigo);
	       		codigo = txt;
			trimjs(descricao1);
			descricao1  = txt;
			trimjs(descricao);
			descricao = txt;
			trimjs(descricao3);
			descricao3 = txt;
			trimjs(descricao4);descricao4 = txt;
			trimjs(descricao5);descricao5 = txt;
			trimjs(descricao6);descricao6 = txt;

			
	        idOpcao.innerHTML = "Faça a Pesquisa de Estado";
			
			//cria um novo option dinamicamente  
			var novo = document.createElement("option");
			    //atribui um ID a esse elemento
			    novo.setAttribute("id", "opcoes");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				//document.forms[0].listDados.options.add(novo);

				$("estcodigo").value=codigo;
				$("estsigla").value=descricao1;
				$("estnome").value=descricao;
				$("esticms").value=descricao3;
				$("esticms2").value=descricao4;
				$("esticms3").value=descricao5;
				$("estnfe").value=descricao6;
				$("acao").value="alterar";	
				document.getElementById("botao-text").innerHTML = "Alterar";


		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo

				$("estcodigo").value="";
				$("estsigla").value="";
				$("estnome").value="";
				$("esticms").value="";
				$("esticms2").value="";
				$("esticms3").value="";
				$("estnfe").value="";
				$("acao").value="inserir";	
				document.getElementById("botao-text").innerHTML = "Incluir";	

	  }	  
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
	else if(rnum <= 0)
   	{		
		valor2='0.00';
	   	$(id).value=valor2;
	}
	
}   