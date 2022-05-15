// JavaScript Document

function enviar(){

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

	  if(ajax2) {
	        ajax2.open("POST", "setorpesquisaexiste.php", true);
                ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax2.onreadystatechange = function() {
        	if(ajax2.readyState == 1) {
	        }
                if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXMLexiste(ajax2.responseXML);
			   }
			   else {
                             enviar2();
			   }
                 }
         }
             var valor=document.getElementById('codigosetor').value;
             var valor2=0;

             if($("acao").value=="inserir"){
               valor2=0;
             }
             else
             {
               valor2=document.getElementById('setcodigo').value;
             }

	     var params = "parametro="+valor+"&parametro2="+valor2;


         ajax2.send(params);
      }

}


function processXMLexiste(obj){

          var dataArray   = obj.getElementsByTagName("dado");
	  if(dataArray.length > 0) {
             alert("Codigo já cadastrado!");
             return;
          }
	  else {
             enviar2();
	  }
   }



   function enviar2() {
    if($("acao").value=="inserir"){
		new ajax ('setorinsere.php?setor=' + document.getElementById('setor').value + "&codigosetor=" + document.getElementById('codigosetor').value, {onComplete: incluido});
	}
	else if($("acao").value=="alterar"){
		new ajax ('setoraltera.php?setor=' + document.getElementById('setor').value + "&codigosetor=" + document.getElementById('codigosetor').value + "&setcodigo=" + document.getElementById('setcodigo').value, {onComplete: alterado});
	}
}

function incluido(request) {


    var codigo = 0;
    var erro = '';

    var xmldoc = request.responseXML;

    if (xmldoc.getElementsByTagName('dados')[0] == null) {
        alert('Problema com a inclusão, favor tentar novamente !');
    } else {

        var dados = xmldoc.getElementsByTagName('dados')[0];

        var xmldoc = request.responseXML;
        var dados = xmldoc.getElementsByTagName('dados')[0];

        if (dados != null)
        {
            var registros = xmldoc.getElementsByTagName('registro');
            var itens = registros[0].getElementsByTagName('item');
            codigo = itens[0].firstChild.data;
            erro = itens[1].firstChild.data;

        }

        if (codigo == 0) {
            alert("ERRO: " + erro + "!");
            limpa_form();
        } else {
            alert("Incluido com sucesso! Codigo " + codigo + "!");
            limpa_form();
            dadospesquisa3(codigo);
        }

    }

}


function alterado(request) {

    var codigo = 0;
    var erro = '';

    var xmldoc = request.responseXML;

    if (xmldoc.getElementsByTagName('dados')[0] == null) {
        alert('Problema com a alteração, favor tentar novamente !');
    } else {

        var dados = xmldoc.getElementsByTagName('dados')[0];

        var xmldoc = request.responseXML;
        var dados = xmldoc.getElementsByTagName('dados')[0];

        if (dados != null)
        {
            var registros = xmldoc.getElementsByTagName('registro');
            var itens = registros[0].getElementsByTagName('item');
            codigo = itens[0].firstChild.data;
            erro = itens[1].firstChild.data;

        }

        if (codigo == 0) {
            alert("ERRO: " + erro + "!");
            limpa_form();
        } else {
            document.forms[0].listDados.options.length = 0;

            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes");
            //atribui um valor
            novo.value = document.getElementById('setcodigo').value;
            //atribui um texto
            novo.text = document.getElementById('setor').value;
            //finalmente adiciona o novo elemento
            document.forms[0].listDados.options.add(novo);

            alert("Registro atualizado com sucesso!");
        }

    }

}

function apagar(setcodigo){
    new ajax ('setorapaga.php?setcodigo=' + setcodigo, {onComplete: apagado});
	limpa_form();
}

function apagado(request) {

	var codigo = 0;
	var erro = '';
 
	var xmldoc = request.responseXML;
 
	if (xmldoc.getElementsByTagName('dados')[0] == null) {
		alert('Problema com a exclusão, favor tentar novamente !');
	} else {
 
		var dados = xmldoc.getElementsByTagName('dados')[0];
 
		var xmldoc = request.responseXML;
		var dados = xmldoc.getElementsByTagName('dados')[0];
 
		if (dados != null)
		{
			var registros = xmldoc.getElementsByTagName('registro');
			var itens = registros[0].getElementsByTagName('item');
			codigo = itens[0].firstChild.data;
			erro = itens[1].firstChild.data;
 
		}
 
		if (codigo == 0) {
			alert("ERRO: " + erro + "!");
			limpa_form();
		} else {            
			alert("Registro excluído com sucesso!");
			limpa_form();
		}
 
	}
 
 }
 
function valida_form(){

	if($("setor").value==""){
		alert("Preencha o campo setor")
		return false;
	}
	else
    	enviar();
}

function limpa_form(){
	$("acao").value="inserir";
	document.getElementById("botao-text").innerHTML = "Incluir";
	$("setcodigo").value="";
	$("setor").value="";
	$("codigosetor").value="";
	$("pesquisa").value="";
	document.forms[0].listDados.options.length = 1;
	if (document.querySelector('#opcoes')){
        idOpcao = document.getElementById("opcoes");
        idOpcao.innerHTML = "Faça a Pesquisa do Setor";
 	}
}

function limpa_form2(){
	$("acao").value="inserir";
	document.getElementById("botao-text").innerHTML = "Incluir";
	$("setcodigo").value="";
	$("setor").value="";
	$("codigosetor").value="";
}

function verifica1(){
	if(confirm("Tem certeza que deseja Excluir?") ){
		apagar($("setcodigo").value);}
}

function verifica(){
	if($("setcodigo").value==""){
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



                  if ( document.getElementById("radio1").checked==true){
                      ajax2.open("POST", "setorpesquisacod.php", true);}
                  else{
                      ajax2.open("POST", "setorpesquisa.php", true);}

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
				   idOpcao.innerHTML = "Faça a Pesquisa do Setor";
			   }
            }
         }
		 //passa o parametro
	     var params = "parametro="+valor + '&parametro2=1';
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

		 ajax2.open("POST", "setorpesquisa.php", true);
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
	     var params = "parametro="+valor + '&parametro2=2';
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

	     ajax2.open("POST", "setorpesquisa.php", true);
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
				   idOpcao.innerHTML = "Faça a Pesquisa do Setor";
			   }
            }
         }
		 //passa o parametro escolhido
	     var params = "parametro="+valor + '&parametro2=2';
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

			trimjs(codigo);codigo = txt;
			trimjs(descricao);descricao = txt;
			trimjs(descricao2);descricao2 = txt;

			//cria um novo option dinamicamente
			var novo = document.createElement("option");
			    //atribui um ID a esse elemento
			    novo.setAttribute("id", "opcoes");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    
                           if ( document.getElementById("radio1").checked==true){
                              novo.text  = descricao2;
                           }
                           else{
                              novo.text  = descricao;
                           }

				//finalmente adiciona o novo elemento
				document.forms[0].listDados.options.add(novo);

			if(i==0){
				$("setcodigo").value=codigo;
				$("setor").value=descricao;
				$("codigosetor").value=descricao2;
				$("acao").value="alterar";
				document.getElementById("botao-text").innerHTML = "Alterar";
			}

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo

		$("setcodigo").value="";
		$("setor").value="";
		$("codigosetor").value="";
		$("acao").value="inserir";
		document.getElementById("botao-text").innerHTML = "Incluir";

		idOpcao.innerHTML = "Faça a Pesquisa do Setor";

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

			$("setcodigo").value=codigo;
			$("setor").value=descricao;
			$("codigosetor").value=descricao2;
			$("acao").value="alterar";
			document.getElementById("botao-text").innerHTML = "Alterar";


		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo

				$("setcodigo").value="";
				$("setor").value="";
				$("codigosetor").value="";
				$("acao").value="inserir";
				document.getElementById("botao-text").innerHTML = "Incluir";

	  }
   }

