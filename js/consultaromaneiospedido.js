
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

		ajax2.open("POST", "consultaromaneiospedidopesquisa.php", true);
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

                  	$("romnumero").value='';
                  	$("romdata").value='';
                  	$("rombaixa").value='';
                  	$("veimodelo").value='';
                  	$("veiplaca").value='';


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
			
			var romnumero =  item.getElementsByTagName("romnumero")[0].firstChild.nodeValue;
			var romdata =  item.getElementsByTagName("romdata")[0].firstChild.nodeValue;
			var romano =  item.getElementsByTagName("romano")[0].firstChild.nodeValue;
			var rombaixa =  item.getElementsByTagName("rombaixa")[0].firstChild.nodeValue;
			var veimodelo =  item.getElementsByTagName("veimodelo")[0].firstChild.nodeValue;
			var veiplaca =  item.getElementsByTagName("veiplaca")[0].firstChild.nodeValue;

			trimjs(pvemissao);if (txt=='0'){txt='';};pvemissao = txt;
			trimjs(clinguerra);if (txt=='0'){txt='';};clinguerra = txt;
			
			trimjs(romnumero);if (txt=='0'){txt='';};romnumero = txt;
                	trimjs(romdata);if (txt=='0'){txt='';};romdata = txt;
                	trimjs(romano);if (txt=='0'){txt='';};romano = txt;
			trimjs(rombaixa);if (txt=='0'){txt='';};rombaixa = txt;
		        trimjs(veimodelo);if (txt=='0'){txt='';};veimodelo = txt;
			trimjs(veiplaca);if (txt=='0'){txt='';};veiplaca = txt;

			$("pvemissao").value=pvemissao;
			$("clinguerra").value=clinguerra;

			$("romnumero").value=romnumero+'/'+romano;
			$("romdata").value=romdata;
			$("rombaixa").value=rombaixa;
			$("veimodelo").value=veimodelo;
			$("veiplaca").value=veiplaca;

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo

                        if ($("pvnumero").value!='')
                           {alert("Pedido não existe!");}

       			$("pvemissao").value='';
			$("clinguerra").value='';
                        if ($("pvnumero").value!=''){
       			document.forms[0].pvnumero.focus();
       			}
       			
          		$("romnumero").value='';
			$("romdata").value='';
			$("rombaixa").value='';
			$("veimodelo").value='';
			$("veiplaca").value='';


	  }


   }

