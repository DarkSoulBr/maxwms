// JavaScript Document   
function enviar(){


	valor = document.getElementById('tctnome').value;
    if($("acao").value=="inserir"){
		new ajax ('tipocteinsere.php?tctnome=' + document.getElementById('tctnome').value, {});
		limpa_form();
		dadospesquisa3(valor);
	}
	else if($("acao").value=="alterar"){
		new ajax ('tipoctealtera.php?tctnome=' + document.getElementById('tctnome').value + "&tctcodigo=" + document.getElementById('tctcodigo').value, {});


		document.forms[0].listDados.options.length = 0;

		var novo = document.createElement("option");
		//atribui um ID a esse elemento
		novo.setAttribute("id", "opcoes");
		//atribui um valor
		novo.value = document.getElementById('tctcodigo').value;
		//atribui um texto
		novo.text  = document.getElementById('tctnome').value;
		//finalmente adiciona o novo elemento
		document.forms[0].listDados.options.add(novo);
		
		alert( 'Alterado !' );

	}
}

function apagar(tctcodigo){
    new ajax ('tipocteapaga.php?tctcodigo=' + tctcodigo, {});
	limpa_form();
}

function valida_form(){

	if($("tctnome").value==""){
		alert("Preencha o campo tipocte")
		return false;
	}
	else
    	enviar();
}

function limpa_form(){
	$("acao").value="inserir";
	document.getElementById("botao-text").innerHTML = "Incluir";
	$("tctcodigo").value="";
	$("tctnome").value="";
	$("pesquisa").value="";
	document.forms[0].listDados.options.length = 1;
	if (document.querySelector('#opcoes')){
        idOpcao = document.getElementById("opcoes");
        idOpcao.innerHTML = "Fa�a a Pesquisa de Finalidade";
 	}

}

function limpa_form2(){
	$("acao").value="inserir";
	document.getElementById("botao-text").innerHTML = "Incluir";
	$("tctcodigo").value="";
	$("tctnome").value="";

}

function verifica1(){
	if(confirm("Tem certeza que deseja Excluir?") ){
		apagar($("tctcodigo").value);}
}

function verifica(){
	if($("tctcodigo").value==""){
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
               alert("Esse browser n�o tem recursos para uso do Ajax");
               ajax2 = null;
            }
         }
      }
	  //se tiver suporte ajax
	  if(ajax2) {
	     //deixa apenas o elemento 1 no option, os outros s�o exclu�dos
		 document.forms[0].listDados.options.length = 1;

		 idOpcao  = document.getElementById("opcoes");

		ajax2.open("POST", "tipoctepesquisa.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function() {

            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";
	        }
			//ap�s ser processado - chama fun��o processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXML(ajax2.responseXML);
			   }
			   else {
			       //caso n�o seja um arquivo XML emite a mensagem abaixo
				   idOpcao.innerHTML = "Fa�a a Pesquisa de Finalidade";
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
               alert("Esse browser n�o tem recursos para uso do Ajax");
               ajax2 = null;
            }
         }
      }
	  //se tiver suporte ajax
	  if(ajax2) {

		 ajax2.open("POST", "tipoctepesquisa2.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {

	        }
			//ap�s ser processado - chama fun��o processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXML2(ajax2.responseXML);
			   }
			   else {
			       //caso n�o seja um arquivo XML emite a mensagem abaixo

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
               alert("Esse browser n�o tem recursos para uso do Ajax");
               ajax2 = null;
            }
         }
      }
	  //se tiver suporte ajax
	  if(ajax2) {
	     //deixa apenas o elemento 1 no option, os outros s�o exclu�dos
		 document.forms[0].listDados.options.length = 1;

		 idOpcao  = document.getElementById("opcoes");

	     ajax2.open("POST", "tipoctepesquisa3.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";
	        }
			//ap�s ser processado - chama fun��o processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXML(ajax2.responseXML);
			   }
			   else {
			       //caso n�o seja um arquivo XML emite a mensagem abaixo
				   idOpcao.innerHTML = "Fa�a a Pesquisa de Finalidade";
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
			//cont�udo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;


			trimjs(codigo);
       		codigo = txt;
			trimjs(descricao);
			descricao = txt;

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
				$("tctcodigo").value=codigo;
				$("tctnome").value=descricao;
				
				$("acao").value="alterar";
				document.getElementById("botao-text").innerHTML = "Alterar";
			}

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo

		$("tctcodigo").value="";
		$("tctnome").value="";
		   
		$("acao").value="inserir";
		document.getElementById("botao-text").innerHTML = "Incluir";

		idOpcao.innerHTML = "Fa�a a Pesquisa de Finalidade";

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
			//cont�udo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;


			trimjs(codigo);
			codigo = txt;
			trimjs(descricao);
			descricao = txt;

			$("tctcodigo").value=codigo;
			$("tctnome").value=descricao;
			$("acao").value="alterar";
			document.getElementById("botao-text").innerHTML = "Alterar";


		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo

				$("tctcodigo").value="";
				$("tctnome").value="";
				$("acao").value="inserir";
				document.getElementById("botao-text").innerHTML = "Incluir";

	  }
   }

