// JavaScript Document
//window.onload=dadospesquisaconferente;

//confere=0;
//codigoproduto=0;
//estoque=0;
//pvcconfere=0;

var conini;

var codigo01    =  0;
var descricao01 =  0;
var embalagem01 =  0;
var	pvcconfere01 =  0;
var	codigoproduto01 =  0;
var	estoque01 =  0;

var vet = new Array(100);

for(var i = 0 ; i < 100 ; i++) {
   vet[i] = new Array(2);
}

for(var i = 0 ; i < 100 ; i++) {
       vet[i][0]=0;
       vet[i][1]=0;
}

function ver(vcodigo,vconferente,vseparador,vac02,vsepinicio,vsepfim){

if (vac02=='S'){
   document.forms[0].adm.disabled = true;

   document.forms[0].codigoproduto.disabled = false;
   document.forms[0].produto.disabled = false;
   document.forms[0].pesquisaproduto.disabled = false;
   document.forms[0].botao3.disabled = false;

}
else{
   document.forms[0].adm.disabled = false;

   document.forms[0].codigoproduto.disabled = true;
   document.forms[0].produto.disabled = true;
   document.forms[0].pesquisaproduto.disabled = true;
   
   document.forms[0].botao3.disabled = true;

}

$("sepinicio").value=vsepinicio;
$("sepfim").value=vsepfim;

dadospesquisaconferente();

}

function finaliza(){

         vvolumes=document.getElementById('pvvolumes').value;

         trimjs(vvolumes);

         if (txt==""){
            alert('Digite a quantidade de volumes!');
            document.forms[0].pvvolumes.focus();
         }
         else{
            enviarfinaliza();
         }
}

function enviarfinaliza(){
         
         valor=document.getElementById('pvnumero').value;

		 //window.open('conferenciafinaliza.php?pvnumero=' + document.getElementById('pvnumero').value
		 
         new ajax ('conferenciafinaliza.php?pvnumero=' + document.getElementById('pvnumero').value		 
         + '&conferente=' + document.forms[0].conferente.options[document.forms[0].conferente.selectedIndex].value
         + '&separador=' + document.forms[0].separador.options[document.forms[0].separador.selectedIndex].value
         + '&sepinicio=' +  document.getElementById('sepinicio').value
         + '&sepfim=' +  document.getElementById('sepfim').value
         + '&conini=' + conini		 
         + "&pvvolumes=" + document.getElementById('pvvolumes').value, {});

		 //+ "&pvvolumes=" + document.getElementById('pvvolumes').value, "_blank");

         alert("Pedido Finalizado!");



         //---------Rotina de gtravação na tabela de movestoque-------------
         //Foi Retirado pois a movimentação passa a ser nos pedidos
         /*
         new ajax ('conferenciamovestoque.php?pvnumero='
          + document.getElementById('pvnumero').value, {});
         */
         //-----------------------------------------------------------------




        $("pvnumero").value='';
	$("pvemissao").value='';
	$("clinguerra").value='';
	$("vennguerra").value='';
	$("pvcondcon").value='';
	$("pvobserva").value='';
	$("pvperdesc").value='';
	$("pvvalor").value='';
	$("pvvaldesc").value='';
	$("totalcomdesconto").value='';
	$("pvtipoped").value='';
	$("pvvolumes").value='';
	$("sepinicio").value='';
	$("sepfim").value='';

	document.forms[0].conferente.options[0].selected = true;
	document.forms[0].separador.options[0].selected = true;
        document.forms[0].pvvolumes.disabled = true;

        $("cbarra").value='';
	$("codigoproduto").value='';
        $("produto").value='';
        document.forms[0].pesquisaproduto.options.length = 0;
        var novo = document.createElement("option");
	novo.setAttribute("id", "opcoes");
	novo.value = 0;
        novo.text  = "__________________________________________________";
        document.forms[0].pesquisaproduto.options.add(novo);


	document.forms[0].pvnumero.focus();

        /*
       	if(confirm("Deseja imprimir as etiquetas?\n\t") ){

        window.open('relpedetiqueta2.php?pvnumero=' + valor , '_self');

        }
     * 
         */



}
          
function enviar(tipo,tipo2){

	if(tipo=="1"){

		new ajax ('conferenciainsere.php?procodigo=' + codigoproduto + "&pvnumero=" + document.getElementById('pvnumero').value + "&pvcestoque=" + estoque + "&pvcconfere=" + confere, {});

        }
	else{
                //alert(codigoproduto);
		new ajax ('conferenciaaltera.php?procodigo=' + codigoproduto + "&pvnumero=" + document.getElementById('pvnumero').value + "&pvcestoque=" + estoque + "&pvcconfere=" + confere, {});
        }


         //dadositem2(document.getElementById('pvnumero').value,tipo2);
         //A função acima não está sendo usada neste ponto, porque o postgre acabou de incluir
         //o item e a pesquisa é feita logo em seguida enquanto o banco ainda não esta atualizado.

         dadositem2b(tipo,tipo2);

         veradm();

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

		ajax2.open("POST", "conferenciapesquisa.php", true);
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
                             
                             
                        ///MOZILA
                        if ($("pvnumero").value!='')
                           {alert("Pedido não existe!");}

       			$("pvemissao").value='';
			$("clinguerra").value='';
			$("vennguerra").value='';
			$("pvcondcon").value='';
			$("pvobserva").value='';
			$("pvperdesc").value='';
			$("pvvalor").value='';
			$("pvvaldesc").value='';
			$("totalcomdesconto").value='';
			$("pvtipoped").value='';
			//$("sepinicio").value='';
			//$("sepfim").value='';

                        if ($("pvnumero").value!=''){
       			document.forms[0].pvnumero.focus();
                        }


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
			var clinguerra =  item.getElementsByTagName("clinguerra")[0].firstChild.nodeValue;
			var vennguerra =  item.getElementsByTagName("vennguerra")[0].firstChild.nodeValue;
			var pvcondcon =  item.getElementsByTagName("pvcondcon")[0].firstChild.nodeValue;
			var pvobserva =  item.getElementsByTagName("pvobserva")[0].firstChild.nodeValue;
			var pvperdesc =  item.getElementsByTagName("pvperdesc")[0].firstChild.nodeValue;
			var pvvalor =  item.getElementsByTagName("pvvalor")[0].firstChild.nodeValue;
			var pvvaldesc =  item.getElementsByTagName("pvvaldesc")[0].firstChild.nodeValue;
			var pvtipoped =  item.getElementsByTagName("pvtipoped")[0].firstChild.nodeValue;
			conini =  item.getElementsByTagName("conini")[0].firstChild.nodeValue;

			trimjs(pvemissao);if (txt=='0'){txt='';};pvemissao = txt;
			trimjs(clinguerra);if (txt=='0'){txt='';};clinguerra = txt;
           		trimjs(vennguerra);if (txt=='0'){txt='';};vennguerra = txt;
                        trimjs(pvcondcon);if (txt=='0'){txt='';};pvcondcon = txt;
			trimjs(pvobserva);if (txt=='0'){txt='';};pvobserva = txt;
           		trimjs(pvperdesc);pvperdesc = txt;
                        trimjs(pvvalor);pvvalor = txt;
			trimjs(pvvaldesc);pvvaldesc = txt;
           		trimjs(pvtipoped);if (txt=='0'){txt='';};pvtipoped = txt;

                        var  totalcomdesconto = (pvvalor - pvvaldesc);
                        totalcomdesconto = (Math.round(totalcomdesconto*100))/100;
                        totalcomdesconto = (totalcomdesconto.format(2, ",", "."));

                        pvperdesc = (Math.round(pvperdesc*100))/100;
                        pvperdesc = (pvperdesc.format(2, ",", "."));

                        pvvalor = (Math.round(pvvalor*100))/100;
                        pvvalor = (pvvalor.format(2, ",", "."));

                        pvvaldesc = (Math.round(pvvaldesc*100))/100;
                        pvvaldesc = (pvvaldesc.format(2, ",", "."));

			$("pvemissao").value=pvemissao;
			$("clinguerra").value=clinguerra;
			$("vennguerra").value=vennguerra;
			$("pvcondcon").value=pvcondcon;
			$("pvobserva").value=pvobserva;
			$("pvperdesc").value=pvperdesc;
			$("pvvalor").value=pvvalor;
			$("pvvaldesc").value=pvvaldesc;
			$("totalcomdesconto").value=totalcomdesconto;
			if(vsepinicio!=''){}
			else{
			$("sepinicio").value='';
            $("sepfim").value='';
			}
						  
			//$("pvtipoped").value=pvtipoped;
			vsepinicio = "";

  if (pvtipoped=='N'){
       $("pvtipoped").value='INTERNO'}
  else if (pvtipoped=='E'){
       $("pvtipoped").value='EXTERNO'}
  else if (pvtipoped=='I'){
       $("pvtipoped").value='INDUSTRIA  '}
  else if (pvtipoped=='M'){
       $("pvtipoped").value='MOSTRUARIO '}
  else if (pvtipoped=='C'){
       $("pvtipoped").value='CONSERTO   '}
  else if (pvtipoped=='D'){
       $("pvtipoped").value='DEVOLUCAO  '}
  else if (pvtipoped=='B'){
       $("pvtipoped").value='BRINDE     '}
  else if (pvtipoped=='X'){
       $("pvtipoped").value='BAIXA      '}
  else if (pvtipoped=='R'){
       $("pvtipoped").value='RESERVA    '}
  else if (pvtipoped=='F'){
       $("pvtipoped").value='BONIFICACAO'}
  else if (pvtipoped=='V'){
       $("pvtipoped").value='VINTE CINCO'}
  else if (pvtipoped=='L'){
       $("pvtipoped").value='LUME TOYS  '}
  else if (pvtipoped=='U'){
       $("pvtipoped").value='MULTIBOX   '}
  else if (pvtipoped=='T'){
       $("pvtipoped").value='TELEMARKET.'}
  else if (pvtipoped=='A'){
       $("pvtipoped").value='DIRETORIA  '}
  else if (pvtipoped=='Y'){
       $("pvtipoped").value='INTERNET   '}
  else if (pvtipoped=='Z'){
       $("pvtipoped").value='ALMOXARIF. '}
  else if (pvtipoped=='S'){
       $("pvtipoped").value='ABASTECIM. '
       
       

       }
  else if (pvtipoped=='K'){
       $("pvtipoped").value='VALE FUNC. '}



if (vconferente!=0){
itemcomboconferente(vconferente);}
else{
document.forms[0].conferente.options[0].selected = true;
}
if (vseparador!=0){
itemcomboseparador(vseparador);}
else{
document.forms[0].separador.options[0].selected = true;
}

vconferente=0;
vseparador=0;



		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo

                        if ($("pvnumero").value!='')
                           {alert("Pedido não existe!");}

       			$("pvemissao").value='';
			$("clinguerra").value='';
			$("vennguerra").value='';
			$("pvcondcon").value='';
			$("pvobserva").value='';
			$("pvperdesc").value='';
			$("pvvalor").value='';
			$("pvvaldesc").value='';
			$("totalcomdesconto").value='';
			$("pvtipoped").value='';

                        if ($("pvnumero").value!=''){
       			document.forms[0].pvnumero.focus();
                        }


	  }


   }



function itemcomboconferente(valor){

	y = document.forms[0].conferente.options.length;

	for(var i = 0 ; i < y ; i++) {

	    document.forms[0].conferente.options[i].selected = true;
		var l = document.forms[0].conferente;
		//var li = l.options[l.selectedIndex].text;
  		var li = l.options[l.selectedIndex].value;
		if(li==valor){
			i=y;
		}

	}
}

function itemcomboseparador(valor){

	y = document.forms[0].separador.options.length;

	for(var i = 0 ; i < y ; i++) {

	    document.forms[0].separador.options[i].selected = true;
		var l = document.forms[0].separador;
		//var li = l.options[l.selectedIndex].text;
  		var li = l.options[l.selectedIndex].value;
		if(li==valor){
			i=y;
		}

	}
}




function dadospesquisaconferente(valor,tipo) {


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

 	         ajax2.open("POST", "conferenciapesquisaconferenteinativo.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXMLconferente(ajax2.responseXML,tipo);
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



   function processXMLconferente(obj,tipo){
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
	    idOpcao.innerHTML = "____________________";

	  }
   dadospesquisaseparador(0,tipo);
   }





function dadospesquisaseparador(valor,tipo) {


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

 	         ajax2.open("POST", "conferenciapesquisaseparadorinativo.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXMLseparador(ajax2.responseXML,tipo);
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



   function processXMLseparador(obj,tipo){
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
	    idOpcao.innerHTML = "____________________";

	  }
   //dadospesquisastatus(0,tipo);

         if(vcodigo!=0){
            $("pvnumero").value=vcodigo;
            dadosverifica(vcodigo);
         }
         else{
         document.forms[0].pvnumero.focus();
         }


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

		ajax2.open("POST", "conferenciapesquisacbarras.php", true);
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

                               alert("Produto não pertence ao pedido!");
                               $("cbarra").value='';
                               document.forms[0].cbarra.focus();

			   }
            }
         }
		 //passa o parametro

	     valor2 = document.getElementById("pvnumero").value;

             if (valor2==''){valor2='0';};

             var params = "parametro="+valor+'&parametro2='+valor2;

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
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var embalagem =  item.getElementsByTagName("embalagem")[0].firstChild.nodeValue;

            pvcconfere =  item.getElementsByTagName("pvcconfere")[0].firstChild.nodeValue;

      		codigoproduto    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			estoque =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

		}
		
		codigo01    =  0;
		descricao01 =  0;
		embalagem01 =  0;
		pvcconfere01 =  0;
      	codigoproduto01 =  0;
		estoque01 =  0;
		
		if (document.getElementById("radio1").checked==true){
		
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
                     if (k<=descricao){
                        confere=eval(pvcconfere)+eval(embalagem);
                        enviar(2,2);    //alteração
                     }
                     else if (k>descricao)
                     {
                        if (eval(pvcconfere)==descricao){
                           alert("Item Liberado!");

                           $("cbarra").value='';
                           $("codigoproduto").value='';
                           $("produto").value='';
                           $("quant").value='';
                           document.forms[0].pesquisaproduto.options.length = 0;
                           var novo = document.createElement("option");
                           novo.setAttribute("id", "opcoes");
                           novo.value = 0;
                           novo.text  = "__________________________________________________";
                           document.forms[0].pesquisaproduto.options.add(novo);

                           document.forms[0].codigoproduto.focus();

                        }
                        else{
                       	   alert("A quantidade não pode ser maior que a do estoque! Estoque:"+ descricao);

                       	   document.forms[0].quant.focus();

                        }
                     }
              }
              else
             {
                         k=embalagem;
                         if (k<=descricao){
                            confere=embalagem;
                            enviar(1,2);  //inclusao
                         }
                         else
                         {
                       	     alert("A quantidade não pode ser maior que a do estoque! Estoque:"+ descricao);
                       	     document.forms[0].quant.focus();

                         }
			 }	
		 }




      }
      	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	     alert("Produto não pertence ao pedido!");
	     $("cbarra").value='';
	     document.forms[0].cbarra.focus();

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
                     if (k<=descricao){
                        confere=eval(pvcconfere)+eval(embalagem);
                        enviar(2,2);    //alteração
                     }
                     else if (k>descricao)
                     {
                        if (eval(pvcconfere)==descricao){
                           alert("Item Liberado!");

                           $("cbarra").value='';
                           $("codigoproduto").value='';
                           $("produto").value='';
                           $("quant").value='';
                           document.forms[0].pesquisaproduto.options.length = 0;
                           var novo = document.createElement("option");
                           novo.setAttribute("id", "opcoes");
                           novo.value = 0;
                           novo.text  = "__________________________________________________";
                           document.forms[0].pesquisaproduto.options.add(novo);

                           document.forms[0].codigoproduto.focus();

                        }
                        else{
                       	   alert("A quantidade não pode ser maior que a do estoque! Estoque:"+ descricao);

                       	   //document.forms[0].quant.focus();
						   document.forms[0].cbarra.focus();

                        }
                     }
              }
              else
             {
                         k=embalagem;
                         if (k<=descricao){
                            confere=embalagem;
                            enviar(1,2);  //inclusao
                         }
                         else
                         {
                       	     alert("A quantidade não pode ser maior que a do estoque! Estoque:"+ descricao);
                       	     //document.forms[0].quant.focus();
						     document.forms[0].cbarra.focus();

                         }
   	     }



}

function confirma(){

      var pvnumero = document.getElementById("pvnumero").value;
      //alert(pvnumero);
      new ajax ('conferenciapesquisapedido.php?pvnumero='+pvnumero , {onComplete: verifica});

     // window.open('http://localhost/dtrade/cadastro/conferenciaconfirma.php?pvnumero='+document.getElementById('pvnumero').value, '_self');

}


function verifica(request){

        var quant1;
        var quant2;
        var verif;

        verif=0;

	var xmldoc=request.responseXML;
	var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];
	if(cabecalho!=null)
	{
		var campo = cabecalho.getElementsByTagName('campo');

		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++){
			var itens = registros[i].getElementsByTagName('item');
				if(itens['2'].firstChild==null)
					quant1=0;

				else{
                                        quant1=(itens['2'].firstChild.data);}

          			if(itens['3'].firstChild==null)
					quant2=0;
				else{
					quant2=(itens['3'].firstChild.data);}

				if (quant1!=quant2) {
                                    verif=1;
                                }

		}

                if (verif==1) {

         //+ '&conferente=' +
         //alert(document.forms[0].conferente.options[document.forms[0].conferente.selectedIndex].value);
         //+ '&separador=' +
         //alert(document.forms[0].separador.options[document.forms[0].separador.selectedIndex].value);

               var si = document.getElementById('sepinicio').value;
               var sf = document.getElementById('sepfim').value;

                   trimjs(si);
                   si = txt;
                   if (si==''){si=0}
                   trimjs(sf);
                   sf = txt;
                   if (sf==''){sf=0}

                   window.open('conferenciaconfirma.php?pvnumero='+document.getElementById('pvnumero').value
                   + '&conferente=' + document.forms[0].conferente.options[document.forms[0].conferente.selectedIndex].value
                   + '&separador=' + document.forms[0].separador.options[document.forms[0].separador.selectedIndex].value
                   + '&sepinicio=' + si
                   + '&sepfim=' + sf
                   + '&conini=' + conini
                   , '_self');


                }
                else{
                   document.forms[0].pvvolumes.disabled = false;
                   document.forms[0].pvvolumes.focus();

                }

	}
	else
		alert("Pedido não existe!");


}



// JavaScript Document
function load_grid(pvnumero){
	new ajax ('conferenciapesquisapedido.php?pvnumero='+pvnumero, {onLoading: carregando, onComplete: imprime});
	//alert('conferenciapesquisapedido.php?pvnumero='+pvnumero, {onLoading: carregando, onComplete: imprime});
}

function carregando(){
	$("msg").style.visibility="visible";
	$("msg").innerHTML="Processando...";
}

function imprime(request)
{
    
    $("resultado").innerHTML = "";
    var xmldoc = request.responseXML;

    var dados = xmldoc.getElementsByTagName('dados')[0];

    var registros = xmldoc.getElementsByTagName('registro'); 
    
    let resultado = "<div class='limiter'>" 
    resultado += "<div class='container-table100'>"
    resultado += "<div class='wrap-table100'>"
    resultado += "<div class='table-max'>"
    resultado += "<div class='row-max header'>"
    resultado += "<div class='cell-max'>Código</div>"        
    resultado += "<div class='cell-max'>Produto</div>"        
    resultado += "<div class='cell-max'>Quantidade</div>"        
    resultado += "<div class='cell-max'>Conferido</div>"   	
    resultado += "</div>"  
    if (dados != null)
    {
        var registros = xmldoc.getElementsByTagName('registro'); 
		
		var ver1 = 0;
        var ver2 = 0;
		
        for (i = 0; i < registros.length; i++)
        {            
            var itens = registros[i].getElementsByTagName('item');
			
			if (itens[2].firstChild == null) {
                ver1 = 0
            } else {
                ver1 = itens[2].firstChild.data
            }
            if (itens[3].firstChild == null) {
                ver2 = 0
            } else {
                ver2 = itens[3].firstChild.data
            }
			
			if (ver1 != ver2) {
				
				resultado += "<div class='row-max'>"
				resultado += "<div class='cell-max' data-title='Código'>" + itens[0].firstChild.data + "</div>"
				resultado += "<div class='cell-max' data-title='Produto'>" + itens[1].firstChild.data + "</div>"
				resultado += "<div class='cell-max' data-title='Quantidade'>" + ver1 + "</div>"
				resultado += "<div class='cell-max' data-title='Conferido'>" + ver2 + "</div>"
				resultado += "</div>"
            }
        }
    }
    resultado += "</div>"        
    resultado += "</div>"        
    resultado += "</div>"        
    resultado += "</div>"        
   
    $("resultado").innerHTML = resultado;
   
}


function imprimeOld(request){
	$("msg").style.visibility="hidden";
	var xmldoc=request.responseXML;
	var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];
	if(cabecalho!=null)
	{


//		var campo = cabecalho.getElementsByTagName('campo');
//		var tabela="<table border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' bgcolor='#CCCCCC' ><tr>"
//
//		//cabecalho da tabela
//		for(i=0;i<campo.length;i++){
//			tabela+="<td class='borda'><b>"+campo[i].firstChild.data+"</b></td>";
//		}
//		//tabela+="<td colspan='2' class='borda'><b>Controles</b></td>"
//		tabela+="</tr>"


		var tabela="<table width='700' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' bgcolor='#CCCCCC' ><tr>"
		tabela+="<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Codigo</b></td>";
		tabela+="<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Produto</b></td>";
		tabela+="<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Quantidade</b></td>";
		tabela+="<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Conferido</b></td>";

		//corpo da tabela
		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++){
			var itens = registros[i].getElementsByTagName('item');
			tabela+="<tr id=linha"+i+">"
			for(j=0;j<itens.length;j++){
				if(itens[j].firstChild==null)
					tabela+="<td class='borda'>"+0+"</td>";
				else
					tabela+="<td class='borda'>"+itens[j].firstChild.data+"</td>";
			}
			//tabela+="<td style='cursor: pointer'><img src='imagens/edit.gif' onClick=editar($('linha"+i+"').innerHTML)></td>";
			//tabela+="<td style='cursor: pointer'><img src='imagens/delete.gif' onClick=apagar("+itens[0].firstChild.data+")></td>";
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





function dadosverifica(valor) {
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

		ajax2.open("POST", "conferenciaverificaitens.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function() {

            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {

	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXMLverifica(ajax2.responseXML,valor);
			   }
			   else {
                             
                             if (navigator.appName != "Microsoft Internet Explorer") {
                              dadositem(valor);
                             }

			   }
            }
         }
		 //passa o parametro
        var params = "parametro="+valor;
         ajax2.send(params);
     }



   }


   function processXMLverifica(obj,valor){


      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados


         for(var i = 0 ; i < dataArray.length ; i++) {
            var item = dataArray[i];
			//contéudo dos campos no arquivo XML

			var pvnumero =  item.getElementsByTagName("pvnumero")[0].firstChild.nodeValue;
			
			//Não tem itens da Gru/Vix
			if(pvnumero==2){				
				alert("Pedido não tem itens Toymania !");
			}
			//Tem itens da Gru/Vix
			else if(pvnumero==1){
                dadositem(valor);
			}
			//Pedido já finalizado
			else {
				alert("Pedido Finalizado");
			}
			
                        
		 }
	  }
	  else {
	    //caso o XML volte vazio o pedido não esta finalizado


           if (navigator.appName == "Microsoft Internet Explorer") {
              dadositem(valor);
           }

	  }
   }


   function dadositem(valor) {
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
		ajax2.open("POST", "conferenciaitem.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax2.onreadystatechange = function() {
			if(ajax2.readyState == 1) {
	        }
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXMLitem(ajax2.responseXML,valor);
			   }
			   else {
			   }
            }
         }
        var params = "parametro="+valor;
         ajax2.send(params);
      }
   }
   function processXMLitem(obj,valor){
      var dataArray   = obj.getElementsByTagName("dado");
	  if(dataArray.length > 0) {
          for(var i = 0 ; i < dataArray.length ; i++) {
            var item = dataArray[i];
			var row =  item.getElementsByTagName("row")[0].firstChild.nodeValue;
                        $("item").value=row;
                        dadospesquisa(valor);
		 }
	  }
	  else {
	    $("item").value=1;
	    dadospesquisa(valor);
	  }
   }
   function dadositem2(valor,tipo2) {
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
		ajax2.open("POST", "conferenciaitem.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax2.onreadystatechange = function() {
			if(ajax2.readyState == 1) {
	        }
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXMLitem2(ajax2.responseXML,valor,tipo2);
			   }
			   else {
			   }
            }
         }
        var params = "parametro="+valor;
         ajax2.send(params);
      }
   }
   function processXMLitem2(obj,valor,tipo2){
      var dataArray   = obj.getElementsByTagName("dado");
	  if(dataArray.length > 0) {
          for(var i = 0 ; i < dataArray.length ; i++) {
            var item = dataArray[i];
			var row =  item.getElementsByTagName("row")[0].firstChild.nodeValue;
                        $("item").value=row;


		 }
	  }
	  else {
	    $("item").value=1;
	  }

        $("cbarra").value='';
	$("codigoproduto").value='';
        $("produto").value='';
        $("quant").value='';
        document.forms[0].pesquisaproduto.options.length = 0;
        var novo = document.createElement("option");
	novo.setAttribute("id", "opcoes");
	novo.value = 0;
        novo.text  = "__________________________________________________";
        document.forms[0].pesquisaproduto.options.add(novo);

        if(tipo2==1) {
        document.forms[0].codigoproduto.focus();
        }
        else
        {
        document.forms[0].cbarra.focus();
        }
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
        novo.text  = "__________________________________________________";
        document.forms[0].pesquisaproduto.options.add(novo);

        if(tipo2==1) {
        document.forms[0].codigoproduto.focus();
        }
        else
        {
        document.forms[0].cbarra.focus();
        }

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
                           idOpcao.innerHTML = "__________________________________________________";
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

		ajax2.open("POST", "conferenciapesquisaconfirma.php", true);
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

                           alert("Produto não pertence ao pedido!");
	                   $("codigoproduto").value='';
 	                   document.forms[0].codigoproduto.focus();

			   }
            }
         }
		 //passa o parametro

	     valor2 = document.getElementById("pvnumero").value;

             if (valor2==''){valor2='0';};

             var params = "parametro="+valor+'&parametro2='+valor2;

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

		 }

              if (pvcconfere!=0){
                     k=eval(pvcconfere)+eval(embalagem);
                     if (k<=descricao){
                        confere=eval(pvcconfere)+eval(embalagem);
                        enviar(2,1);    //alteração
                     }
                     else if (k>descricao)
                     {
                        if (eval(pvcconfere)==descricao){
                           alert("Item Liberado!");

                           $("cbarra").value='';
                           $("codigoproduto").value='';
                           $("produto").value='';
                           $("quant").value='';
                           document.forms[0].pesquisaproduto.options.length = 0;
                           var novo = document.createElement("option");
                           novo.setAttribute("id", "opcoes");
                           novo.value = 0;
                           novo.text  = "__________________________________________________";
                           document.forms[0].pesquisaproduto.options.add(novo);

                           document.forms[0].codigoproduto.focus();
                           

                        }
                        else{
                       	   alert("A quantidade não pode ser maior que a do estoque! Estoque:"+ descricao);
                       	   
                       	   document.forms[0].quant.focus();

                        }
                     }
              }
              else
             {
                         k=embalagem;
                         if (k<=descricao){
                            confere=embalagem;
                            enviar(1,1);  //inclusao
                         }
                         else
                         {
                       	     alert("A quantidade não pode ser maior que a do estoque! Estoque:"+ descricao);

                       	     document.forms[0].quant.focus();
                         }
   	     }





      }
      	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	     alert("Produto não pertence ao pedido!");
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


function dadosverifica2(valor) {
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

		ajax2.open("POST", "conferenciaverificaitens.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function() {

            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {

	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXMLverifica2(ajax2.responseXML,valor);
			   }
			   else {

                             if (navigator.appName != "Microsoft Internet Explorer") {
                               confirma();
                             }

			   }
            }
         }
		 //passa o parametro
        var params = "parametro="+valor;
         ajax2.send(params);
     }



   }


   function processXMLverifica2(obj,valor){


      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados


         for(var i = 0 ; i < dataArray.length ; i++) {
            var item = dataArray[i];
			//contéudo dos campos no arquivo XML

			var pvnumero =  item.getElementsByTagName("pvnumero")[0].firstChild.nodeValue;
			
			//Não tem itens da Gru/Vix
			if(pvnumero==2){				
				alert("Pedido não tem itens Gru/Vix !");
			}
			//Tem itens da Gru/Vix
			else if(pvnumero==1){
                confirma();
			}
			//Pedido já finalizado
			else {
				alert("Pedido Finalizado");
			}
			
            
		 }
	  }
	  else {
	    //caso o XML volte vazio o pedido não esta finalizado


           if (navigator.appName == "Microsoft Internet Explorer") {
              confirma();
           }

	  }
   }







function dadosverifica3(valor) {
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

		ajax2.open("POST", "conferenciaverificaitens.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function() {

            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {

	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXMLverifica3(ajax2.responseXML,valor);
			   }
			   else {

                             if (navigator.appName != "Microsoft Internet Explorer") {
                               confirma2();
                             }

			   }
            }
         }
		 //passa o parametro
        var params = "parametro="+valor;
         ajax2.send(params);
     }



   }


function processXMLverifica3(obj,valor){


      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados


         for(var i = 0 ; i < dataArray.length ; i++) {
            var item = dataArray[i];
			//contéudo dos campos no arquivo XML

			var pvnumero =  item.getElementsByTagName("pvnumero")[0].firstChild.nodeValue;
			
			//Não tem itens da Gru/Vix
			if(pvnumero==2){				
				alert("Pedido não tem itens Gru/Vix !");
			}
			//Tem itens da Gru/Vix
			else if(pvnumero==1){
                confirma2();
			}
			//Pedido já finalizado
			else {
				alert("Pedido Finalizado");
			}
			
		 }
	  }
	  else {
	    //caso o XML volte vazio o pedido não esta finalizado


           if (navigator.appName == "Microsoft Internet Explorer") {
              confirma2();
           }

	  }
   }



function confirma2(){

      var pvnumero = document.getElementById("pvnumero").value;
      //alert(pvnumero);
      new ajax ('conferenciapesquisapedido.php?pvnumero='+pvnumero , {onComplete: verifica2});

     // window.open('http://localhost/dtrade/cadastro/conferenciaconfirma.php?pvnumero='+document.getElementById('pvnumero').value, '_self');

}


function verifica2(request){

        var quant1;
        var quant2;
        var verif;

        verif=0;

	var xmldoc=request.responseXML;
	var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];
	if(cabecalho!=null)
	{
		var campo = cabecalho.getElementsByTagName('campo');

		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++){
			var itens = registros[i].getElementsByTagName('item');
				if(itens['2'].firstChild==null)
					quant1=0;

				else{
                                        quant1=(itens['2'].firstChild.data);}

          			if(itens['3'].firstChild==null)
					quant2=0;
				else{
					quant2=(itens['3'].firstChild.data);}

				if (quant1!=quant2) {
                                    verif=1;
                                }

		}

                if (verif==1) {

         //+ '&conferente=' +
         //alert(document.forms[0].conferente.options[document.forms[0].conferente.selectedIndex].value);
         //+ '&separador=' +
         //alert(document.forms[0].separador.options[document.forms[0].separador.selectedIndex].value);

                   var si = document.getElementById('sepinicio').value;
                   var sf = document.getElementById('sepfim').value;

                   trimjs(si);
                   si = txt;
                   if (si==''){si=0}
                   trimjs(sf);
                   sf = txt;
                   if (sf==''){sf=0}

                   window.open('conferenciaconfirma2.php?pvnumero='+document.getElementById('pvnumero').value
                   + '&conferente=' + document.forms[0].conferente.options[document.forms[0].conferente.selectedIndex].value
                   + '&separador=' + document.forms[0].separador.options[document.forms[0].separador.selectedIndex].value
                   + '&sepinicio=' + si
                   + '&sepfim=' + sf
                   + '&conini=' + conini                   
                   , '_self');


                }
                else{
                   alert("Todos os itens estão verificados!");
                   //document.forms[0].pvvolumes.focus();
                }

	}
	else
		alert("Pedido não existe!");


}

// JavaScript Document
function load_grid2(pvnumero){
	new ajax ('conferenciapesquisapedido.php?pvnumero='+pvnumero, {onLoading: carregando, onComplete: imprime2});
	//alert('conferenciapesquisapedido.php?pvnumero='+pvnumero, {onLoading: carregando, onComplete: imprime});
}

function imprime2(request)
{
    
    $("resultado").innerHTML = "";
    var xmldoc = request.responseXML;

    var dados = xmldoc.getElementsByTagName('dados')[0];

    var registros = xmldoc.getElementsByTagName('registro'); 
    
    let resultado = "<div class='limiter'>" 
    resultado += "<div class='container-table100'>"
    resultado += "<div class='wrap-table100'>"
    resultado += "<div class='table-max'>"
    resultado += "<div class='row-max header'>"
    resultado += "<div class='cell-max'>Código</div>"        
    resultado += "<div class='cell-max'>Produto</div>"        
    resultado += "<div class='cell-max'>Quantidade</div>"        
    resultado += "<div class='cell-max'>Conferido</div>"   	
    resultado += "</div>"  
    if (dados != null)
    {
        var registros = xmldoc.getElementsByTagName('registro'); 
		
		var ver1 = 0;
        var ver2 = 0;
		
        for (i = 0; i < registros.length; i++)
        {            
            var itens = registros[i].getElementsByTagName('item');
			
			if (itens[2].firstChild==null){
			  ver1=0}
		    else{
			  ver1=itens[2].firstChild.data}
		    if (itens[3].firstChild==null){
			  ver2=0}
		    else{
			  ver2=itens[3].firstChild.data}
			
			if (ver1 != ver2) {
				
				resultado += "<div class='row-max'>"
				resultado += "<div class='cell-max' data-title='Código'>" + itens[0].firstChild.data + "</div>"
				resultado += "<div class='cell-max' data-title='Produto'>" + itens[1].firstChild.data + "</div>"
				resultado += "<div class='cell-max' data-title='Quantidade'>" + ver1 + "</div>"
                resultado += "<div class='cell-max' data-title='Conferido'>" + ver2 + "</div>"
				resultado += "</div>"
            }
        }
    }
    resultado += "</div>"        
    resultado += "</div>"        
    resultado += "</div>"        
    resultado += "</div>"        
   
    $("resultado").innerHTML = resultado;
   
}

function imprime2Old(request){
	$("msg").style.visibility="hidden";
	var xmldoc=request.responseXML;
	var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];
	if(cabecalho!=null)
	{


//		var campo = cabecalho.getElementsByTagName('campo');
//		var tabela="<table border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' bgcolor='#CCCCCC' ><tr>"
//
//		//cabecalho da tabela
//		for(i=0;i<campo.length;i++){
//			tabela+="<td class='borda'><b>"+campo[i].firstChild.data+"</b></td>";
//		}
//		//tabela+="<td colspan='2' class='borda'><b>Controles</b></td>"
//		tabela+="</tr>"


		var tabela="<table width='700' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' bgcolor='#CCCCCC' ><tr>"
		tabela+="<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Codigo</b></td>";
		tabela+="<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Produto</b></td>";
		tabela+="<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Quantidade</b></td>";
		tabela+="<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Conferido</b></td>";

		//corpo da tabela
		var registros = xmldoc.getElementsByTagName('registro');
		
		var ver1=0;
		var ver2=0;

		for(i=0;i<registros.length;i++){
      	        
                   var itens = registros[i].getElementsByTagName('item');

                   if (itens[2].firstChild==null){
                      ver1=0}
                   else{
                      ver1=itens[2].firstChild.data}
                   if (itens[3].firstChild==null){
                      ver2=0}
                   else{
                      ver2=itens[3].firstChild.data}

                   //alert(ver1);
                   //alert(ver2);

                   if (ver1!=ver2){

			tabela+="<tr id=linha"+i+">"
			for(j=0;j<itens.length;j++){


				if(itens[j].firstChild==null)
					tabela+="<td class='borda'>"+0+"</td>";
				else
					tabela+="<td class='borda'>"+itens[j].firstChild.data+"</td>";

			}
			//tabela+="<td style='cursor: pointer'><img src='imagens/edit.gif' onClick=editar($('linha"+i+"').innerHTML)></td>";
			//tabela+="<td style='cursor: pointer'><img src='imagens/delete.gif' onClick=apagar("+itens[0].firstChild.data+")></td>";
			tabela+="</tr>";
		                 
                    }

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

function veradm(){


   if (document.forms[0].adm.disabled==false){
    document.forms[0].codigoproduto.disabled = true;
    document.forms[0].produto.disabled = true;
    document.forms[0].pesquisaproduto.disabled = true;
   }



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

		ajax2.open("POST", "conferenciapesquisapertence.php", true);
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

                           alert("Produto não pertence ao pedido!");
	                   $("codigoproduto").value='';
 	                   document.forms[0].codigoproduto.focus();

			   }
            }
         }
		 //passa o parametro

	     valor2 = document.getElementById("pvnumero").value;

             if (valor2==''){valor2='0';};

             var params = "parametro="+valor+'&parametro2='+valor2;

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
	     alert("Produto não pertence ao pedido!");
	     $("codigoproduto").value='';
	     document.forms[0].codigoproduto.focus();

	  }

   }



function verificasenha(valor) {

        if (valor!=''){

        var texto=valor;var letra;var codigo;var saida = '';
        for (i = 0; i < texto.length; i++)
        {letra=texto.substring(i,i+1);
         codigo=letra.charCodeAt(0)
        if (codigo == 38) {codigo = 101;}
	if (codigo >= 97 && codigo <= 122) {codigo = (codigo - 32);}
	if (codigo == 231) {codigo = 67;}
        if (codigo >= 192 && codigo <= 198) {codigo = 65;}
	if (codigo == 199) {codigo = 67;}
	if (codigo >= 200 && codigo <= 203) {codigo = 69;}
	if (codigo >= 204 && codigo <= 207) {codigo = 73;}
	if (codigo >= 210 && codigo <= 214) {codigo = 79;}
	if (codigo >= 217 && codigo <= 220) {codigo = 85;}
	if (codigo >= 224 && codigo <= 230) {codigo = 65;}
	if (codigo == 231) {codigo = 199;}
	if (codigo >= 232 && codigo <= 235) {codigo = 69;}
	if (codigo >= 236 && codigo <= 240) {codigo = 73;}
	if (codigo >= 242 && codigo <= 246) {codigo = 79;}
	if (codigo >= 249 && codigo <= 252) {codigo = 85;}
        letra=String.fromCharCode(codigo);
        saida=saida+letra}
        valor = saida;
		

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
		ajax2.open("POST", "conferenciaverificasenha.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax2.onreadystatechange = function() {
			if(ajax2.readyState == 1) {
	        }
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXMLverificasenha(ajax2.responseXML,valor);
			   }
			   else {
                             //////MOZILLA

                             document.forms[0].codigoproduto.disabled = true;
                             document.forms[0].produto.disabled = true;
                             document.forms[0].pesquisaproduto.disabled = true;

                             document.forms[0].botao3.disabled = true;

                             alert("Senha Inválida!");
                             document.forms[0].botao2.focus();

			   }
            }
         }
        var params = "parametro="+valor;
         ajax2.send(params);
      }

      }
   }
   function processXMLverificasenha(obj,valor){

        //pega a tag dado
        var dataArray   = obj.getElementsByTagName("dado");
        //total de elementos contidos na tag dado
        if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados

                for(var i = 0 ; i < dataArray.length ; i++) {
                var item = dataArray[i];
			//contéudo dos campos no arquivo XML
  	 	var acesso02    =  item.getElementsByTagName("acesso02")[0].firstChild.nodeValue;

                   if (acesso02=='S'){
                   alert("Digitação Liberada!");

                   $("adm").value='';

                   document.forms[0].codigoproduto.disabled = false;
                   document.forms[0].produto.disabled = false;
                   document.forms[0].pesquisaproduto.disabled = false;
                   
                   document.forms[0].botao3.disabled = false;

                   document.forms[0].codigoproduto.focus();

                   }
                   else
                   {
                   document.forms[0].codigoproduto.disabled = true;
                   document.forms[0].produto.disabled = true;
                   document.forms[0].pesquisaproduto.disabled = true;

                   document.forms[0].botao3.disabled = true;

                   alert("Senha Inválida!");
                   document.forms[0].botao2.focus();
                   }

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
            document.forms[0].codigoproduto.disabled = true;
            document.forms[0].produto.disabled = true;
            document.forms[0].pesquisaproduto.disabled = true;

            document.forms[0].botao3.disabled = true;

            alert("Senha Inválida!");
            document.forms[0].botao2.focus();

	  }

   }


function dadosverifica4(){
    new ajax ('conferenciatodos.php?pvnumero=' + document.getElementById('pvnumero').value , {});
    veradm();
    alert("Itens Verificados!");
    
    if (vac02=='S'){
       document.forms[0].botao3.disabled = false;
    }
    else{
       document.forms[0].botao3.disabled = true;
    }

}


