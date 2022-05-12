// JavaScript Document      
function enviar(){


	valor = document.getElementById('tfonome').value;
    if($("acao").value=="inserir"){
		new ajax ('tipoformainsere.php?tfonome=' + document.getElementById('tfonome').value, {});
		limpa_form();
		dadospesquisa3(valor);
	}
	else if($("acao").value=="alterar"){
		new ajax ('tipoformaaltera.php?tfonome=' + document.getElementById('tfonome').value + "&tfocodigo=" + document.getElementById('tfocodigo').value, {});


		document.forms[0].listDados.options.length = 0;

		var novo = document.createElement("option");
		//atribui um ID a esse elemento
		novo.setAttribute("id", "opcoes");
		//atribui um valor
		novo.value = document.getElementById('tfocodigo').value;
		//atribui um texto
		novo.text  = document.getElementById('tfonome').value;
		//finalmente adiciona o novo elemento
		document.forms[0].listDados.options.add(novo);
		
		alert( 'Alterado !' );

	}
}

function apagar(tfocodigo){
    new ajax ('tipoformaapaga.php?tfocodigo=' + tfocodigo, {});
	limpa_form();
}

function valida_form(){

	if($("tfonome").value==""){
		alert("Preencha o campo tipoforma")
		return false;
	}
	else
    	enviar();
}

function limpa_form(){
	$("acao").value="inserir";
	document.getElementById("botao-text").innerHTML = "Incluir";
	$("tfocodigo").value="";
	$("tfonome").value="";
	$("pesquisa").value="";
	document.forms[0].listDados.options.length = 1;
	if (document.querySelector('#opcoes')){
        idOpcao = document.getElementById("opcoes");
        idOpcao.innerHTML = "Faça a Pesquisa de Forma de Emissão";
 	}

}

function limpa_form2(){
	$("acao").value="inserir";
	document.getElementById("botao-text").innerHTML = "Incluir";
	$("tfocodigo").value="";
	$("tfonome").value="";

}

function verifica1(){
	if(confirm("Tem certeza que deseja Excluir?") ){
		apagar($("tfocodigo").value);}
}

function verifica(){
	if($("tfocodigo").value==""){
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

		ajax2.open("POST", "tipoformapesquisa.php", true);
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
				   idOpcao.innerHTML = "Faça a Pesquisa de Forma de Emissão";
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

		 ajax2.open("POST", "tipoformapesquisa2.php", true);
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

	     ajax2.open("POST", "tipoformapesquisa3.php", true);
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
				   idOpcao.innerHTML = "Faça a Pesquisa de Forma de Emissão";
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
				$("tfocodigo").value=codigo;
				$("tfonome").value=descricao;
				
				$("acao").value="alterar";
				document.getElementById("botao-text").innerHTML = "Alterar";
			}

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo

		$("tfocodigo").value="";
		$("tfonome").value="";
		   
		$("acao").value="inserir";
		document.getElementById("botao-text").innerHTML = "Incluir";

		idOpcao.innerHTML = "Faça a Pesquisa de Forma de Emissão";

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


			trimjs(codigo);
			codigo = txt;
			trimjs(descricao);
			descricao = txt;

			$("tfocodigo").value=codigo;
			$("tfonome").value=descricao;
			$("acao").value="alterar";
			document.getElementById("botao-text").innerHTML = "Alterar";


		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo

				$("tfocodigo").value="";
				$("tfonome").value="";
				$("acao").value="inserir";
				document.getElementById("botao-text").innerHTML = "Incluir";

	  }
   }

