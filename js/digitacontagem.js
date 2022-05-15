var vetordados = new Array(2000);
var embalagem01 =  0;

for(var i = 0 ; i < 2000 ; i++) {
   vetordados[i] = new Array(4);
}

for(var i = 0 ; i < 2000 ; i++) {
       vetordados[i][0]=0;
       vetordados[i][1]=0;
	   vetordados[i][2]=0;       
	   vetordados[i][3]=0;       
}

// JavaScript Document
function ver(){
	dadospesquisacontagem(0);
}

function onPlay(tipo)
{

	if(tipo==1){	
	   document.getElementById("dummyspan").innerHTML = '<embed src="erro.wav" type="audio/wav" hidden="true"></embed>';
	   
	   $('linhaerro1').style.display="";	
	   $('linhaerro2').style.display="";	
	   $('linhaerro3').style.display="";	
	   $('linhaerro4').style.display="";	
	   
	   $("cbarra").value='';
	   document.forms[0].cbarra.focus();
	   
	   
	}   
	else {	
		document.getElementById("dummyspan").innerHTML = '<embed src="ok.wav" type="audio/wav" hidden="true"></embed>';
	   
	   $('linhaerro1').style.display="none";	
	   $('linhaerro2').style.display="none";	
	   $('linhaerro3').style.display="none";	
	   $('linhaerro4').style.display="none";	
	   
	   $("cbarra").value='';
	   document.forms[0].cbarra.focus();
	
	}
   
   
}       
          
function enviar(tipo,tipo2){

	if(tipo=="1"){
	
		var invdata = document.getElementById("pvemissao").value;

		new ajax('digitacontageminsere.php?procodigo=' + codigoproduto + '&invdata='+invdata
			+ '&contagem=' + document.forms[0].conferente.options[document.forms[0].conferente.selectedIndex].value
			+ '&setor=' + document.forms[0].separador.options[document.forms[0].separador.selectedIndex].value	
			+ '&coletor=' + document.forms[0].coletor.options[document.forms[0].coletor.selectedIndex].value	
			+ "&pvcconfere=" + confere 
			, {} );
	

        }
	else{
	
		var invdata = document.getElementById("pvemissao").value;

		new ajax('digitacontagemaltera.php?procodigo=' + codigoproduto + '&invdata='+invdata
			+ '&contagem=' + document.forms[0].conferente.options[document.forms[0].conferente.selectedIndex].value
			+ '&setor=' + document.forms[0].separador.options[document.forms[0].separador.selectedIndex].value	
			+ '&coletor=' + document.forms[0].coletor.options[document.forms[0].coletor.selectedIndex].value	
			+ "&pvcconfere=" + confere 
			, {} );
	
		
    }

    dadositem2b(tipo,tipo2);

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

		ajax2.open("POST", "contagempesquisadata.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function() {

            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {

	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXML(ajax2.responseXML);
			   }
			   else {
					$("pvemissao").value='';					
			   }
            }
         }
		 //passa o parametro
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


         for(var i = 0 ; i < dataArray.length ; i++) {
            var item = dataArray[i];
			//contéudo dos campos no arquivo XML



			var pvemissao =  item.getElementsByTagName("pvemissao")[0].firstChild.nodeValue;
			
			trimjs(pvemissao);if (txt=='0'){txt='';};pvemissao = txt;
			            

			$("pvemissao").value=pvemissao;
			
			if(pvemissao==''){
				alert("Nenhuma Contagem em Andamento!");
			}
			else {			
				//Habilita os Botões
				$("botao").disabled=false;
				$("botao2").disabled=false;
				$("botao3").disabled=false;
				$("botao4").disabled=false;
			}	


		 }
	  }
	  


   }


function dadospesquisacontagem(valor) {


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
		 document.forms[0].conferente.options.length = 1;

		 idOpcao  = document.getElementById("conferente");

 	         ajax2.open("POST", "coletorpesquisacontagemativo.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXMLcontagem(ajax2.responseXML);
			   }
			   else {
			       //caso não seja um arquivo XML emite a mensagem abaixo
				   idOpcao.innerHTML = "____________";
			   }
            }
         }
		 //passa o parametro	
	     var params = "parametro="+valor;
         ajax2.send(params);
      }
   }



   function processXMLcontagem(obj){
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados

	document.forms[0].conferente.options.length = 0;

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
			    novo.setAttribute("id", "conferente");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].conferente.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcao.innerHTML = "____________";

	  }
   dadospesquisasetor(0);
   }





function dadospesquisasetor(valor) {


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
		 document.forms[0].separador.options.length = 1;

		 idOpcao  = document.getElementById("separador");

 	         ajax2.open("POST", "coletorpesquisasetor.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXMLsetor(ajax2.responseXML);
			   }
			   else {
			       //caso não seja um arquivo XML emite a mensagem abaixo
				   idOpcao.innerHTML = "____________";
			   }
            }
         }
		 //passa o parametro
	     var params = "parametro="+valor;
         ajax2.send(params);
      }
   }



   function processXMLsetor(obj){
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados

	document.forms[0].separador.options.length = 0;

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
			    novo.setAttribute("id", "separador");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].separador.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcao.innerHTML = "____________";

	  }
   //dadospesquisastatus(0,tipo);

   
	//Localiza a data	
    dadospesquisacoletor(0);
         
}


function dadospesquisacoletor(valor) {


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
		 document.forms[0].coletor.options.length = 1;

		 idOpcao  = document.getElementById("coletor");

 	         ajax2.open("POST", "coletorpesquisacoletor.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXMLcoletor(ajax2.responseXML);
			   }
			   else {
			       //caso não seja um arquivo XML emite a mensagem abaixo
				   idOpcao.innerHTML = "____________";
			   }
            }
         }
		 //passa o parametro
	     var params = "parametro="+valor;
         ajax2.send(params);
      }
   }



   function processXMLcoletor(obj){
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados

	document.forms[0].coletor.options.length = 0;

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
			    novo.setAttribute("id", "coletor");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].coletor.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcao.innerHTML = "____________";

	  }
   //dadospesquisastatus(0,tipo);

   
	//Localiza a data	
    dadospesquisa(0);
         
}



function dadospesquisacbarras(valor) {
      //verifica se o browser tem suporte a ajax
      trimjs(valor);
      if (txt!=''){


       if ((txt.length)<13){

         var tam = txt.length;
         var zer = 13-tam;
         var cba = '';
         for(var i = 0 ; i < zer ; i++) {
            cba=cba+'0'
         }
         txt=cba+txt;
         $("cbarra").value=txt;

         valor=txt;

      }


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

		ajax2.open("POST", "contagempesquisacbarras.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function() {

            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXMLcbarras(ajax2.responseXML);
			   }
			   else {
			       //caso não seja um arquivo XML emite a mensagem abaixo
				   
							   onPlay(1);
								
							   
							   

			   }
            }
         }
		 //passa o parametro
         var params = "parametro="+valor+'&parametro2='+document.getElementById("pvemissao").value+'&parametro3='+document.forms[0].conferente.options[document.forms[0].conferente.selectedIndex].value+'&parametro4='+document.forms[0].separador.options[document.forms[0].separador.selectedIndex].value+'&parametro5='+document.forms[0].coletor.options[document.forms[0].coletor.selectedIndex].value;
			 
             ajax2.send(params);
      }
      }
   }





function processXMLcbarras(obj){
      //pega a tag dado


      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados


        for(var i = 0 ; i < dataArray.length ; i++) {
            var item = dataArray[i];

			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;			
			var embalagem =  item.getElementsByTagName("embalagem")[0].firstChild.nodeValue;
			
			var procod =  item.getElementsByTagName("procod")[0].firstChild.nodeValue;
			var prnome =  item.getElementsByTagName("prnome")[0].firstChild.nodeValue;

            pvcconfere =  item.getElementsByTagName("pvcconfere")[0].firstChild.nodeValue;

      		codigoproduto    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			
			var descricao =  eval(pvcconfere)+eval(embalagem) + 1;
			
			estoque =  descricao;

		}
		
		codigo01    =  0;
		descricao01 =  0;
		embalagem01 =  0;
		pvcconfere01 =  0;
      	codigoproduto01 =  0;
		estoque01 =  0;
		
		if (document.getElementById("radio1").checked==true){
		
			document.getElementById("codigoproduto").value = procod;
			document.getElementById("produto").value = prnome;
			
			document.getElementById("quant").value = embalagem;
			document.forms[0].quant.focus();
			
			codigo01    =  codigo;
			descricao01 =  descricao;
			embalagem01 =  1;
			pvcconfere01 =  pvcconfere;
      		codigoproduto01 =  codigoproduto;
			estoque01 =  estoque;
					
		}
		else{
              
			  if (pvcconfere!=0){
                     k=eval(pvcconfere)+eval(embalagem);
                     
                        confere=eval(pvcconfere)+eval(embalagem);
                        enviar(2,2);    //alteração
                     
              }
              else
             {
                         k=embalagem;
                         
                            confere=embalagem;
                            enviar(1,2);  //inclusao
                         
			 }	
		 }




      }
      	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
		
		 onPlay(1);
					
	    
		 
		 

	  }

         // document.forms[0].cbarra.focus();

   }   
   
   
   

function processXMLcbarras01(){
            
			embalagem01 = 0;

			var codigo    =  codigo01;
			var descricao =  descricao01;
			var embalagem =  document.getElementById("quant").value;

            var pvcconfere = pvcconfere01;
      		var codigoproduto = codigoproduto01;
			var estoque = estoque01;
			
			document.getElementById("quant").value = "";
			document.getElementById("cbarra").value = "";
		 
            if (pvcconfere!=0){
                    k=eval(pvcconfere)+eval(embalagem);                     
                    confere=eval(pvcconfere)+eval(embalagem);
                    enviar(2,2);    //alteração
                     
            }
            else
            {         
                confere=embalagem;
                enviar(1,2);  //inclusao
                         
			}



}

// JavaScript Document
function dadosverifica4(){

	var invdata = document.getElementById("pvemissao").value;
	
	new ajax('coletorinventariopesquisa.php?invdata='+invdata
	//window.open('coletorinventariopesquisa.php?invdata='+invdata
		+ '&contagem=' + document.forms[0].conferente.options[document.forms[0].conferente.selectedIndex].value
		+ '&setor=' + document.forms[0].separador.options[document.forms[0].separador.selectedIndex].value			
		+ '&coletor=' + document.forms[0].coletor.options[document.forms[0].coletor.selectedIndex].value			
		//, '_blank');
		, {onLoading: carregando, onComplete: imprime});
		
}

function carregando(){
	$("msg").style.visibility="visible";
	$("msg").innerHTML="Processando...";
}

function imprime(request){

	for(var i = 0 ; i < 2000 ; i++) {
	   vetordados[i] = new Array(4);
	}

	for(var i = 0 ; i < 2000 ; i++)
	{
	       vetordados[i][0]=0;
	       vetordados[i][1]=0;
		   vetordados[i][2]=0;	       
		   vetordados[i][3]=0;	       
	}

	$("msg").style.visibility="hidden";
	var xmldoc=request.responseXML;
	
	if(xmldoc!=null)
	{
	
		var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];


//		var campo = cabecalho.getElementsByTagName('campo');
//		var tabela="<table border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' bgcolor='#CCCCCC' ><tr>"
//
//		//cabecalho da tabela
//		for(i=0;i<campo.length;i++){
//			tabela+="<td class='borda'><b>"+campo[i].firstChild.data+"</b></td>";
//		}
//		//tabela+="<td colspan='2' class='borda'><b>Controles</b></td>"
//		tabela+="</tr>"


		var tabela="<table width='750' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' bgcolor='#CCCCCC' ><tr>"
		tabela+="<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Codigo</b></td>";
		tabela+="<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Produto</b></td>";
		tabela+="<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Ref.Forn.</b></td>";
		tabela+="<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>C.Barras</b></td>";
		tabela+="<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Qtd.</b></td>";
		tabela+="<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Ação</b></td>";
		
		//corpo da tabela
		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++){
			var itens = registros[i].getElementsByTagName('item');
			tabela+="<tr id=linha"+i+">"
			
			vetordados[i][0]=itens[0].firstChild.data;
			vetordados[i][1]=itens[1].firstChild.data;
			vetordados[i][2]=itens[2].firstChild.data;
			vetordados[i][3]=itens[3].firstChild.data;			
			
			tabela+="<td class='borda'>"+itens[0].firstChild.data+"</td>";
			tabela+="<td class='borda'>"+itens[1].firstChild.data+"</td>";				
			tabela+="<td class='borda'>"+itens[4].firstChild.data+"</td>";				
			tabela+="<td class='borda'>"+itens[5].firstChild.data+"</td>";				
			tabela+='<td align="center"><input type="text" name="qtde'+i+'" id="qtde'+i+'" value="'+itens[2].firstChild.data+'" size="4" maxlength="10" style="text-align:center;"></td>';					
			tabela+='<td align="center" style="font-size:10px;"><a href="javascript:atualizarproduto('+vetordados[i][3]+',document.formulario.qtde'+i+'.value);" style="text-decoration:none; color:#000000;"><img src="images/btn_atualizar.jpg" border="0" title="Alterar" align="absmiddle"></a></td>';				
			
			tabela+="</tr>";
		}

		tabela+="</table>"


		tabela+="</tr>"

		$("resultado").innerHTML=tabela;
		//$("resultado2").innerHTML=tabela2;
		tabela=null;
	}
	else
		$("resultado").innerHTML="Nenhum registro encontrado...";
}


function dadositem2b(valor,tipo2) {

        if(valor==1) {
           $("item").value=parseInt($("item").value)+1;
        }

        $("cbarra").value='';
	$("codigoproduto").value='';
        $("produto").value='';
        $("quant").value='';
        document.forms[0].pesquisaproduto.options.length = 0;
        var novo = document.createElement("option");
	novo.setAttribute("id", "opcoes");
	novo.value = 0;
        novo.text  = "____________";
        document.forms[0].pesquisaproduto.options.add(novo);

		onPlay(2);

   }

   function pesquisacodigo(valor) {

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
		ajax2.open("POST", "conferenciapesquisacodigo.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax2.onreadystatechange = function() {
			if(ajax2.readyState == 1) {
	        }
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXMLcodigo(ajax2.responseXML,valor);
			   }
			   else {
			   }
            }
         }
        var params = "parametro="+valor;
         ajax2.send(params);
      }
   }
   function processXMLcodigo(obj,valor){

      var dataArray   = obj.getElementsByTagName("dado");
	  if(dataArray.length > 0) {

           document.forms[0].pesquisaproduto.options.length = 0;

          for(var i = 0 ; i < dataArray.length ; i++) {
            var item = dataArray[i];
                        var cod =  item.getElementsByTagName("cod")[0].firstChild.nodeValue;
			var codigo =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
                        $("codigoproduto").value=codigo;
                        $("produto").value=descricao;


                        var novo = document.createElement("option");
			//atribui um ID a esse elemento
			novo.setAttribute("id", "opcoes");
			//atribui um valor
			novo.value = cod;
			//atribui um texto
                        novo.text  = descricao;
                        //finalmente adiciona o novo elemento
                        document.forms[0].pesquisaproduto.options.add(novo);

                        document.forms[0].quant.focus();

		 }
	  }
	  else {

	  }


   }



   function pesquisaprodutos(valor) {
      if(valor!=""){

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

                document.forms[0].pesquisaproduto.options.length = 1;
                idOpcao  = document.getElementById("pesquisaproduto");

		ajax2.open("POST", "conferenciapesquisaproduto.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax2.onreadystatechange = function() {
			if(ajax2.readyState == 1) {
                        idOpcao.innerHTML = "Carregando...!";
	        }
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXMLproduto(ajax2.responseXML,valor);
			   }
			   else {
                           idOpcao.innerHTML = "____________";
			   }
            }
         }
        var params = "parametro="+valor;
         ajax2.send(params);
      }
   }
   }

   function processXMLproduto(obj,valor){
      

      var dataArray   = obj.getElementsByTagName("dado");
	  if(dataArray.length > 0) {

          document.forms[0].pesquisaproduto.options.length = 0;

          for(var i = 0 ; i < dataArray.length ; i++) {
            var item = dataArray[i];

                        var cod =  item.getElementsByTagName("cod")[0].firstChild.nodeValue;
      			var codigo =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            		var novo = document.createElement("option");
			//atribui um ID a esse elemento
			novo.setAttribute("id", "opcoes");
			//atribui um valor
			novo.value = cod;
			//atribui um texto
                        novo.text  = descricao;
                        //finalmente adiciona o novo elemento
                        document.forms[0].pesquisaproduto.options.add(novo);

			if(i==0){
                           $("codigoproduto").value=codigo;
                           $("produto").value=descricao;
                           
			}

		 }
       	   if(dataArray.length==1){
	   document.forms[0].quant.focus();
           }
	  }
	  else {

	  }


  }




    function pesquisacod(valor) {

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
		ajax2.open("POST", "conferenciapesquisacod.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax2.onreadystatechange = function() {
			if(ajax2.readyState == 1) {
	        }
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXMLcodigo(ajax2.responseXML,valor);
			   }
			   else {
			   }
            }
         }
        var params = "parametro="+valor;
         ajax2.send(params);
      }
   }
   function processXMLcod(obj,valor){
      var dataArray   = obj.getElementsByTagName("dado");
	  if(dataArray.length > 0) {
          for(var i = 0 ; i < dataArray.length ; i++) {
            var item = dataArray[i];
			var codigo =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
                        $("codigoproduto").value=codigo;
                        $("produto").value=descricao;
		 }
	  }
	  else {

	  }
   }




function dadospesquisaconfirma() {

if (document.getElementById("radio1").checked==true && embalagem01==1){
   
   
   processXMLcbarras01();

}
else{
 
   if (press==1){

   press=2;

      var valor = document.forms[0].pesquisaproduto.options[document.forms[0].pesquisaproduto.selectedIndex].value

      //verifica se o browser tem suporte a ajax
      trimjs(valor);
      if (txt!=''){

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

		ajax2.open("POST", "coletorpesquisaconfirma.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function() {

            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXMLconfirma(ajax2.responseXML);
			   }
			   else {
			       //caso não seja um arquivo XML emite a mensagem abaixo

                           alert("Produto não encontrado!");
	                   $("codigoproduto").value='';
 	                   document.forms[0].codigoproduto.focus();

			   }
            }
         }
		 //passa o parametro

             //passa o parametro
         var params = "parametro="+valor+'&parametro2='+document.getElementById("pvemissao").value+'&parametro3='+document.forms[0].conferente.options[document.forms[0].conferente.selectedIndex].value+'&parametro4='+document.forms[0].separador.options[document.forms[0].separador.selectedIndex].value+'&parametro5='+document.forms[0].coletor.options[document.forms[0].coletor.selectedIndex].value;

             ajax2.send(params);
      }
      }
      

   }

}

}






   function processXMLconfirma(obj){
      //pega a tag dado


      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados


            for(var i = 0 ; i < dataArray.length ; i++) {
            var item = dataArray[i];

			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

                        var embalagem =  parseInt(document.getElementById("quant").value);

                        pvcconfere =  item.getElementsByTagName("pvcconfere")[0].firstChild.nodeValue;

      			codigoproduto    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			estoque =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			
			descricao = eval(pvcconfere)+eval(embalagem);
			estoque = eval(pvcconfere)+eval(embalagem);

		 }

              if (pvcconfere!=0){
                    k=eval(pvcconfere)+eval(embalagem);                     
                    confere=eval(pvcconfere)+eval(embalagem);
                    enviar(2,1);    //alteração                     
              }
              else
             {
                        k=embalagem;                         
                        confere=embalagem;
                        enviar(1,1);  //inclusao
                        
				}





      }
      	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	     alert("Produto não encontrado!");
	     $("codigoproduto").value='';
	     document.forms[0].codigoproduto.focus();

	  }

   }


function numbersOnly(myfield, e){
   if (myfield.length ==0) myfield.value=0;  
    var key;
    var keychar;
   if (window.event)
 key = window.event.keyCode;
   else if (e)
     key = e.which;
   else
     return true;

    keychar = String.fromCharCode(key);
   if ((key==null) || (key==0) || (key==8) ||  (key==9)|| (key==13)|| (key==27) )
 return true;
   else if ((("0123456789").indexOf(keychar) > -1))
    return true;
    else
 return false;
}

function enterclik(event,campo)
{
     	var k;
	if (navigator.appName == "Microsoft Internet Explorer") {
		k = event.keyCode;
	} else { // Netscape
		var keyChar = String.fromCharCode(event.which);
		k = keyChar.charCodeAt(0);
	}


		if (k == 13) {

                if (campo.value=="Verifica"){
                   dadosverifica3(campo);
                }
                else if (campo.value=="Confirma"){
                   dadosverifica2(campo);
                }
                else if (campo.value=="Incluir"){
                   if (press==1){
                   dadospesquisaconfirma();
                   }

                }


		}

}


function funcaopress(){

   press=1;

}

function dadospesquisapertence(valor) {

   if (press==1){

      //verifica se o browser tem suporte a ajax
      trimjs(valor);
      if (txt!=''){

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

		ajax2.open("POST", "coletorpesquisapertence.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function() {

            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXMLpertence(ajax2.responseXML);
			   }
			   else {
			       //caso não seja um arquivo XML emite a mensagem abaixo

                       alert("Produto não encontrado !");
	                   $("codigoproduto").value='';
 	                   document.forms[0].codigoproduto.focus();

			   }
            }
         }
		 //passa o parametro

			//passa o parametro
			var params = "parametro="+valor+'&parametro2='+document.getElementById("pvemissao").value+'&parametro3='+document.forms[0].conferente.options[document.forms[0].conferente.selectedIndex].value+'&parametro4='+document.forms[0].separador.options[document.forms[0].separador.selectedIndex].value+'&parametro5='+document.forms[0].coletor.options[document.forms[0].coletor.selectedIndex].value; 

             ajax2.send(params);
      }
      }
      
      
   }


   }




   function processXMLpertence(obj){
      //pega a tag dado
      valor = document.getElementById("codigoproduto").value;

      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
        pesquisacodigo(valor);
      }
      	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	     alert("Produto não encontrado !");
	     $("codigoproduto").value='';
	     document.forms[0].codigoproduto.focus();

	  }

   }



function entertabx(campo)
{


	nextfield = campo; // nome do primeiro campo do site
	netscape = "";
	ver = navigator.appVersion; len = ver.length;
	for(iln = 0; iln < len; iln++) if (ver.charAt(iln) == "(") break;
		netscape = (ver.charAt(iln+1).toUpperCase() != "C");

		function keyDown(DnEvents) {
			// ve quando e o netscape ou IE
			k = (netscape) ? DnEvents.which : window.event.keyCode;
			
			if (k == 13) { // preciona tecla enter
			if (nextfield == 'done') {

				return false;
				//return true; // envia quando termina os campos
			} else {
			
				// se existem mais campos vai para o proximo
				//eval('document.formulario.' + nextfield + '.focus()');
				
				//document.forms[0].pesquisaproduto.focus();
				
				//$("botao2").focus();
				 document.forms[0].codigoproduto.focus();	
				
				return false;
			}
		}
	}

	document.onkeydown = keyDown; // work together to analyze keystrokes
	if (netscape) document.captureEvents(Event.KEYDOWN|Event.KEYUP);

	
}

function dadosverifica1() {

	var invdata = document.getElementById("pvemissao").value;

	new ajax('aberturageracontagemsetor.php?invdata='+invdata
		+ '&contagem=' + document.forms[0].conferente.options[document.forms[0].conferente.selectedIndex].value
        + '&setor=' + document.forms[0].separador.options[document.forms[0].separador.selectedIndex].value	
		, {onLoading: carregandosetor, onComplete: imprimesetor});

}

function carregandosetor()
{
	$("msg").style.visibility="visible";
	$("msg").innerHTML="Processando...";
}

function imprimesetor(request)
{
	$("msg").style.visibility="hidden";
	var xmldoc=request.responseXML;
    var dados = xmldoc.getElementsByTagName('dadosinv')[0];
	var registros = xmldoc.getElementsByTagName('registroinv');
	var itens = registros[0].getElementsByTagName('iteminv');

  	if(itens[0].firstChild.data=="0"){
		dadosverifica1b();
	}
	else if(itens[0].firstChild.data=="2"){	
		tabela="Erro! Essa Contagem está encerrada!";	
		alert( tabela );
		tabela="";		
	}
	else {	
		tabela="Erro! Contagem para esse setor está encerrada!";	
		alert( tabela );
		tabela="";
		
		if(confirm("Deseja re-abrir a contagem desse setor?\n\t") )
		{
			var invdata = document.getElementById("pvemissao").value;

			new ajax('reabregeracontagemsetor.php?invdata='+invdata
				+ '&contagem=' + document.forms[0].conferente.options[document.forms[0].conferente.selectedIndex].value
				+ '&setor=' + document.forms[0].separador.options[document.forms[0].separador.selectedIndex].value	
				, {onLoading: carregandosetor, onComplete: imprimesetorreabre});
				
		}		
		
		
	}	
	
}



function dadosverifica1b(){

	//Desabilita o Setor e Contagem e habilita os dados
	document.forms[0].conferente.disabled=true;
	document.forms[0].separador.disabled=true;
	document.forms[0].coletor.disabled=true;
	
	$("botao").disabled=true;
	
	$("botao2").disabled=false;
	$("botao3").disabled=false;	
	$("botao4").disabled=false;	
	
	//Habilita os Campos da Contagem
	$("radio1").disabled=false;
	$("radio2").disabled=false;
	$("cbarra").disabled=false;
	
	$("codigoproduto").disabled=false;
	$("produto").disabled=false;
	document.forms[0].pesquisaproduto.disabled=false;
	$("quant").disabled=false;
	$("button").disabled=false;	
	
	$("cbarra").value='';
    document.forms[0].cbarra.focus();	

}

function dadosverifica2(){

	//Desabilita o Setor e Contagem e habilita os dados
	document.forms[0].conferente.disabled=false;
	document.forms[0].separador.disabled=false;
	document.forms[0].coletor.disabled=false;
	
	$("botao").disabled=false;	
	$("botao2").disabled=false;
	$("botao3").disabled=false;	
	$("botao4").disabled=false;	
	
	//Habilita os Campos da Contagem
	$("radio1").disabled=true;
	$("radio2").disabled=true;
	$("cbarra").disabled=true;
	
	$("codigoproduto").disabled=true;
	$("produto").disabled=true;
	document.forms[0].pesquisaproduto.disabled=true;
	$("quant").disabled=true;
	$("button").disabled=true;	
	

}


function dadosverifica3() {

	if(confirm("Deseja encerrar a contagem desse setor?\n\t") )
	{
		var invdata = document.getElementById("pvemissao").value;

		new ajax('encerrageracontagemsetor.php?invdata='+invdata
			+ '&contagem=' + document.forms[0].conferente.options[document.forms[0].conferente.selectedIndex].value
			+ '&setor=' + document.forms[0].separador.options[document.forms[0].separador.selectedIndex].value	
			, {onLoading: carregandosetor, onComplete: imprimesetorencerra});
			
	}		

}

function imprimesetorencerra(request)
{
	$("msg").style.visibility="hidden";
	var xmldoc=request.responseXML;
    var dados = xmldoc.getElementsByTagName('dadosinv')[0];
	var registros = xmldoc.getElementsByTagName('registroinv');
	var itens = registros[0].getElementsByTagName('iteminv');

	tabela="Contagem para esse setor encerrada!";	
	alert( tabela );
	tabela="";	
	
	$("resultado").innerHTML="";
  	
	dadosverifica2();
	
}

function imprimesetorreabre(request)
{
	$("msg").style.visibility="hidden";
	var xmldoc=request.responseXML;
    var dados = xmldoc.getElementsByTagName('dadosinv')[0];
	var registros = xmldoc.getElementsByTagName('registroinv');
	var itens = registros[0].getElementsByTagName('iteminv');
	
	$("resultado").innerHTML="";
  	
	dadosverifica1b();
	
}

function entertab(campo)
{


	nextfield = campo; // nome do primeiro campo do site
	netscape = "";
	ver = navigator.appVersion; len = ver.length;
	for(iln = 0; iln < len; iln++) if (ver.charAt(iln) == "(") break;
		netscape = (ver.charAt(iln+1).toUpperCase() != "C");

		function keyDown(DnEvents) {
			// ve quando e o netscape ou IE
			k = (netscape) ? DnEvents.which : window.event.keyCode;
			
			if (k == 13) { // preciona tecla enter
			if (nextfield == 'done') {

				return false;
				//return true; // envia quando termina os campos
			} else {
			
				// se existem mais campos vai para o proximo
				eval('document.formulario.' + nextfield + '.focus()');
				
				//document.forms[0].pesquisaproduto.focus();
				
				
				
				return false;
			}
		}
	}

	document.onkeydown = keyDown; // work together to analyze keystrokes
	if (netscape) document.captureEvents(Event.KEYDOWN|Event.KEYUP);

	
}

function atualizarproduto(codigoproduto,confere)
{		
	
	var invdata = document.getElementById("pvemissao").value;

	new ajax('digitacontagemaltera.php?procodigo=' + codigoproduto + '&invdata='+invdata
			+ '&contagem=' + document.forms[0].conferente.options[document.forms[0].conferente.selectedIndex].value
			+ '&setor=' + document.forms[0].separador.options[document.forms[0].separador.selectedIndex].value	
			+ '&coletor=' + document.forms[0].coletor.options[document.forms[0].coletor.selectedIndex].value	
			+ "&pvcconfere=" + confere 
			, {} );

	alert( 'Quantidade Alterada !' );			
	
}