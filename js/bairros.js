// JavaScript Document

function enviar(){
	if($("acao").value=="inserir"){
	valor = document.getElementById('bairro').value;
	valor2 = document.getElementById('codigocidade').value;

		new ajax ('bairrosinsere.php?nome=' + document.getElementById('bairro').value +
                 //'&codigocidade=' + document.forms[0].listcidades.options[document.forms[0].listcidades.selectedIndex].value
                 '&codigocidade=' + document.getElementById('codigocidade').value

                 , {});



	//limpa_form();

	dadospesquisacod(valor,valor2);

}
	else if($("acao").value=="alterar"){
		new ajax ('bairrosaltera.php?codigo=' + document.getElementById('codigo').value +
                '&nome=' + document.getElementById('bairro').value +
                "&codigocidade=" + document.getElementById('codigocidade').value

                , {});


	document.forms[0].listDados.options.length = 0;

	var novo = document.createElement("option");
	//atribui um ID a esse elemento
	novo.setAttribute("id", "opcoes");
	//atribui um valor
	novo.value = document.getElementById('codigo').value;
	//atribui um texto
	novo.text  = document.getElementById('bairro').value;
	//finalmente adiciona o novo elemento
	document.forms[0].listDados.options.add(novo);

}
}

function apagar(codigo){
        

	new ajax ('bairrosapaga.php?codigo=' + codigo, {});
	limpa_form();
}

function valida_form(){

	if($("bairro").value==""){
		alert("Preencha o campo bairro")
		return false;
	}
	else
		enviar();
}

function limpa_form(){


        //document.forms[0].listcidades.options.length = 1;
	//idOpcao  = document.getElementById("opcoes2");
	//idOpcao.innerHTML = "____________________";

	$("acao").value="inserir";
	$("botao").value="Incluir";

        $("codigo").value="";
	$("bairro").value="";
	$("cidade").value="";
        $("codigocidade").value="";
        $("uf").value="";

	$("pesquisa").value="";

 	document.forms[0].listDados.options.length = 1;
	idOpcao  = document.getElementById("opcoes");
	idOpcao.innerHTML = "____________________";

        document.forms[0].listcidades.options.length = 0;



}

function limpa_form2(){

        //document.forms[0].listcidades.options.length = 1;
	//idOpcao  = document.getElementById("opcoes2");
	//idOpcao.innerHTML = "____________________";

	$("acao").value="inserir";
	$("botao").value="Incluir";

        $("codigo").value="";
	$("bairro").value="";
	$("cidade").value="";
        $("codigocidade").value="";
        $("uf").value="";

	$("pesquisa").value="";


 	document.forms[0].listDados.options.length = 1;
	idOpcao  = document.getElementById("opcoes");
	idOpcao.innerHTML = "____________________";

        document.forms[0].listcidades.options.length = 0;


}

function verifica1(){
	if(confirm("Tem certeza que deseja Excluir?\n\t") ){
		apagar($("codigo").value);}
}

function verifica(){
	if($("codigo").value==""){
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
		 
	     ajax2.open("POST", "bairrospesquisa.php", true);
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
				   idOpcao.innerHTML = "____________________";
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
		 
		 ajax2.open("POST", "bairrospesquisa2.php", true);
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

function dadospesquisa3x(valor) {
	trimjs(valor);
	valor = txt;
	if(valor==""){
		alert("Preencha o campo cidade !");
		return false;
	}
	else{
		dadospesquisa3(valor);
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
		 document.forms[0].listcidades.options.length = 1;

		 idOpcao  = document.getElementById("opcoes2");

	     ajax2.open("POST", "bairroscidadepesquisa.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			  // idOpcao.innerHTML = "Carregando...!";
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXML3(ajax2.responseXML);
			   }
			   else {
			       //caso não seja um arquivo XML emite a mensagem abaixo
				   idOpcao.innerHTML = "____________________";
			   }
            }
         }
		 //passa o parametro escolhido

             var params = "parametro="+valor;
             ajax2.send(params);
      }
   }


function dadospesquisa4(valor) {
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

	     ajax2.open("POST", "bairroscidadepesquisa2.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {

	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXML4(ajax2.responseXML);
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


   function processXML(obj){
      //pega a tag dado
      
      document.forms[0].listcidades.options.length = 0;

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
			var uf =  item.getElementsByTagName("uf")[0].firstChild.nodeValue;

			trimjs(codigo);
	       		codigo = txt;
			trimjs(descricao);
			descricao  = txt;
			trimjs(descricao2);
			descricao2 = txt;
                      	trimjs(descricao3);
			descricao3 = txt;
                   	trimjs(uf);
			uf = txt;

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
				$("codigo").value=codigo;
				$("bairro").value=descricao;
				$("cidade").value=descricao2;
				$("codigocidade").value=descricao3;
				$("uf").value=uf;

				$("acao").value="alterar";
				$("botao").value="Alterar";

				//itemcombo(descricao2);

			}

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo

		$("cidcodigo").value="";
		$("cidnome").value="";
		$("cep").value="";
		$("uf").value="";
		$("acao").value="inserir";
		$("botao").value="Incluir";

		idOpcao.innerHTML = "____________________";

	  }
   }



   function processXML2(obj){
     
     document.forms[0].listcidades.options.length = 0;

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
		var uf =  item.getElementsByTagName("uf")[0].firstChild.nodeValue;

		trimjs(codigo);
	       	codigo = txt;
		trimjs(descricao);
		descricao  = txt;
		trimjs(descricao2);
		descricao2 = txt;
                trimjs(descricao3);
		descricao3 = txt;
                trimjs(uf);
		uf = txt;

		//Carrega os dados


                $("codigo").value=codigo;
		$("bairro").value=descricao;
		$("cidade").value=descricao2;
		$("codigocidade").value=descricao3;
		$("uf").value=uf;

		$("acao").value="alterar";
		$("botao").value="Alterar";


		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo

				$("codigo").value="";
				$("bairro").value="";
				$("cidade").value="";
				$("uf").value="";

				$("acao").value="inserir";
				$("botao").value="Incluir";

	  }
   }





   function processXML3(obj){
   
   
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados

	document.forms[0].listcidades.options.length = 0;
        valor = document.getElementById('codigocidade').value;

         for(var i = 0 ; i < dataArray.length ; i++) {
            var item = dataArray[i];
			//contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var descricao2 =  item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;
			//var descricao3 =  item.getElementsByTagName("descricao3")[0].firstChild.nodeValue;

			trimjs(codigo);
	       		codigo = txt;
			trimjs(descricao);
			descricao  = txt;
			trimjs(descricao2);
			descricao2 = txt;
			
			//cria um novo option dinamicamente
			var novo = document.createElement("option");
			    //atribui um ID a esse elemento
			    novo.setAttribute("id", "opcoes");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao + " (" + descricao2 + ")";
				//finalmente adiciona o novo elemento
				document.forms[0].listcidades.options.add(novo);

                       if(i==0){
			$("cidade").value=descricao;
			$("codigocidade").value=codigo;
			$("uf").value=descricao2;
			
			
			
                       }

		 }


			
			//$("codigocidade").value="";
			//$("uf").value="";

                    //itemcombo(valor);

	  }
	  else {

	  }
   }



function itemcombo(valor){

	y = document.forms[0].listcidades.options.length;

	for(var i = 0 ; i < y ; i++) {

	    document.forms[0].listcidades.options[i].selected = true;
		var l = document.forms[0].listcidades;
  		var li = l.options[l.selectedIndex].value;
		if(li==valor){
			i=y;
		}
		else
                {
                document.forms[0].listcidades.options[0].selected = true;
		}

	}
}




 function processXML4(obj){
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
			//var descricao3 =  item.getElementsByTagName("descricao3")[0].firstChild.nodeValue;

			trimjs(codigo);
	       		codigo = txt;
			trimjs(descricao);
			descricao  = txt;
			trimjs(descricao2);
			descricao2 = txt;
                      	//trimjs(descricao3);
			//descricao3 = txt;

			$("cidade").value=descricao;
			$("codigocidade").value=codigo;
			$("uf").value=descricao2;

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo

		//$("cidcodigo").value="";
		//$("cidnome").value="";
		//$("cep").value="";
		//$("acao").value="inserir";
		//$("botao").value="Incluir";

		//idOpcao.innerHTML = "____________________";

	  }
   }




   function dadospesquisacod(valor,valor2) {
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

	     ajax2.open("POST", "bairrospesquisa3.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXMLcod(ajax2.responseXML);
			   }
			   else {
			       //caso não seja um arquivo XML emite a mensagem abaixo
				   idOpcao.innerHTML = "____________________";
			   }
            }
         }
		 //passa o parametro
             var params = "parametro="+valor+'&parametro2='+valor2;
             ajax2.send(params);
      }
   }


function processXMLcod(obj){
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
			var descricao    =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

			trimjs(codigo);
	       		codigo = txt;
			trimjs(descricao);
	       		descricao = txt;



                 	$("codigo").value=codigo;
                       	$("acao").value="alterar";
			$("botao").value="Alterar";

                        var novo = document.createElement("option");
			//atribui um ID a esse elemento
			novo.setAttribute("id", "opcoes");
			//atribui um valor
			novo.value = codigo;
			//atribui um texto
                        novo.text  = descricao;
                       	//finalmente adiciona o novo elemento
			document.forms[0].listDados.options.add(novo);


		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo

	  }
   }
