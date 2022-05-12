// JavaScript Document      
function enviar(){


	valor = document.getElementById('cfonome').value;
    if($("acao").value=="inserir"){
		new ajax ('cfopinsere.php?cfonome=' + document.getElementById('cfonome').value + '&cfocod=' + document.getElementById('cfocod').value, {});
		limpa_form();
		dadospesquisa3(valor);
	}
	else if($("acao").value=="alterar"){
		new ajax ('cfopaltera.php?cfonome=' + document.getElementById('cfonome').value + "&cfocodigo=" + document.getElementById('cfocodigo').value + '&cfocod=' + document.getElementById('cfocod').value, {});


		document.forms[0].listDados.options.length = 0;

		var novo = document.createElement("option");
		//atribui um ID a esse elemento
		novo.setAttribute("id", "opcoes");
		//atribui um valor
		novo.value = document.getElementById('cfocodigo').value;
		//atribui um texto
		novo.text  = document.getElementById('cfonome').value;
		//finalmente adiciona o novo elemento
		document.forms[0].listDados.options.add(novo);
		
		alert( 'Alterado !' );

	}
}

function apagar(cfocodigo){
    new ajax ('cfopapaga.php?cfocodigo=' + cfocodigo, {});
	limpa_form();
}

function valida_form(){

	if($("cfonome").value==""){
		alert("Preencha o campo cfop")
		return false;
	}
	else
    	enviar();
}

function limpa_form(){
	$("acao").value="inserir";
	document.getElementById("botao-text").innerHTML = "Incluir";
	$("cfocodigo").value="";
	$("cfocod").value="";
	$("cfonome").value="";
	$("pesquisa").value="";
	document.forms[0].listDados.options.length = 1;
	if (document.querySelector('#opcoes')){
        idOpcao = document.getElementById("opcoes");
        idOpcao.innerHTML = "Faça a Pesquisa de CFOP";
 	}

}

function limpa_form2(){
	$("acao").value="inserir";
	document.getElementById("botao-text").innerHTML = "Incluir";
	$("cfocodigo").value="";
	$("cfocod").value="";
	$("cfonome").value="";

}

function verifica1(){
	if(confirm("Tem certeza que deseja Excluir?") ){
		apagar($("cfocodigo").value);}
}

function verifica(){
	if($("cfocodigo").value==""){
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

		ajax2.open("POST", "cfoppesquisa1.php", true);
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
				   idOpcao.innerHTML = "Faça a Pesquisa de CFOP";
			   }
            }
         }
		 //passa o parametro
		 
		 
		 if ( document.getElementById("radio1").checked==true)
	     {
         	valor2 = "1";
         }
         else {
            valor2 = "2";
         }		 
		 
		 var params = "parametro="+valor+'&parametro2='+valor2;
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

		 ajax2.open("POST", "cfoppesquisa2.php", true);
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

	     ajax2.open("POST", "cfoppesquisa3.php", true);
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
				   idOpcao.innerHTML = "Faça a Pesquisa de CFOP";
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


			trimjs(codigo);
       		codigo = txt;
			trimjs(descricao);
			descricao = txt;
			trimjs(descricao2);
			descricao2 = txt;
			
			 if ( document.getElementById("radio1").checked==true)
			 {
				descricaox = descricao2;
			 }
			 else {
				descricaox = descricao;
			}		 

			//cria um novo option dinamicamente
			var novo = document.createElement("option");
			    //atribui um ID a esse elemento
			    novo.setAttribute("id", "opcoes");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricaox;
				//finalmente adiciona o novo elemento
				document.forms[0].listDados.options.add(novo);

			if(i==0){
				$("cfocodigo").value=codigo;
				$("cfonome").value=descricao;
				$("cfocod").value=descricao2;
				
				$("acao").value="alterar";
				document.getElementById("botao-text").innerHTML = "Alterar";
			}

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo

		$("cfocodigo").value="";
		$("cfonome").value="";
		$("cfocod").value="";
		$("acao").value="inserir";
		document.getElementById("botao-text").innerHTML = "Incluir";

		idOpcao.innerHTML = "Faça a Pesquisa de CFOP";

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


			trimjs(codigo);
			codigo = txt;
			trimjs(descricao);
			descricao = txt;
			trimjs(descricao2);
			descricao2 = txt;

			$("cfocodigo").value=codigo;
			$("cfonome").value=descricao;
			$("cfocod").value=descricao2;
			$("acao").value="alterar";
			document.getElementById("botao-text").innerHTML = "Alterar";


		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo

				$("cfocodigo").value="";
				$("cfonome").value="";
				$("cfocod").value="";
				$("acao").value="inserir";
				document.getElementById("botao-text").innerHTML = "Incluir";

	  }
   }

