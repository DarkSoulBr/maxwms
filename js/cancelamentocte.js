// JavaScript Document
 
function env(usuario){
	

	if ($("botao3").value=="Confirma"){
	
		var erro = 0;	

		if (document.getElementById('protocolo').value == ''){
			erro = 1;	
			alert("Preencha o numero do Protocolo!");
		}
		else if (document.getElementById('motivo').value == ''){
			erro = 1;	
			alert("Preencha o Motivo do Cancelamento!");
		}
		else {
			var motivo = document.getElementById('motivo').value;			
			motivo = motivo.trim();			
			if(motivo.length<15){
				erro = 1;	
				alert("Motivo precisa ter no minimo 15 caracteres!");
			}
		}
	 
		if (erro==0){
			//window.open ('cancelamentoctexml.php?protocolo=' + document.getElementById('protocolo').value
			new ajax ('cancelamentoctexml.php?protocolo=' + document.getElementById('protocolo').value
			+ '&motivo=' + document.getElementById('motivo').value 
			+ '&usuario=' + usuario
			+ '&ctecodigo=' + document.getElementById('ctecodigo').value 
			+ '&flagassina=' + 0
			+ '&numero=' + document.getElementById('numero').value 
			+ '&chave=' + document.getElementById('chave').value 
			,{onComplete: limpa_form});
			//, '_blank');
		}
		
			
		
		
	}
	else
	{
		
		new ajax ('cancelamentoctereativaxml.php?ctecodigo=' + document.getElementById('ctecodigo').value 
		+ '&numero=' + document.getElementById('numero').value 
		,{onComplete: limpa_form2});
					
	}				

}


function limpa_form(){

    alert("XML de Cancelamento gerado com sucesso!");
	
	document.getElementById('protocolo').value = '';
	document.getElementById('motivo').value = '';
	
	window.open('cancelamentocte.php' ,'_self');

}


function limpa_form2(){

	alert("Reativacao concluida com sucesso!");
	
	document.getElementById('protocolo').value = '';
	document.getElementById('motivo').value = '';
	
	window.open('cancelamentocte.php' ,'_self');

}


function dadospesquisa(valor) {

	$("protocolo").value='';
	$("motivo").value='';
	$("protocolo").disabled=false;
	$("motivo").disabled=false;
	$("botao3").disabled=false;

	var valor2 = 1;

	if ( document.getElementById("radio1").checked==true){
		valor2 = 1;
	}
	else if ( document.getElementById("radio2").checked==true){
		valor2 = 2;
	}
	else
	{
		valor2 = 3;
	}

	

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
	  
		
	    
		ajax2.open("POST", "ctepesquisa.php", true);
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
					//caso não seja um arquivo XML emite a mensagem abaixo
					$("ctecodigo").value="";
					$("ctecodigo").value="";
					$("controle").value="";
					$("numero").value="";
					$("chave").value="";
									   
			   }
            }
         }
		 //passa o parametro
		 
		 var params = "parametro="+valor+'&parametro2='+valor2;
		 
         ajax2.send(params);
      }
   }


   function processXML(obj){

   
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados

	

            var item = dataArray[0];
			//contéudo dos campos no arquivo XML  
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var descricao2 =  item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;
			
			var descricao3 =  item.getElementsByTagName("descricao3")[0].firstChild.nodeValue;
			var descricao4 =  item.getElementsByTagName("descricao4")[0].firstChild.nodeValue;
			var descricao5 =  item.getElementsByTagName("descricao5")[0].firstChild.nodeValue;

			trimjs(codigo);
	       	codigo = txt;
			trimjs(descricao);
			descricao = txt;
			trimjs(descricao2);
			descricao2 = txt;
			trimjs(descricao3);
			descricao3 = txt;
			trimjs(descricao4);
			descricao4 = txt;
			
			trimjs(descricao5);if (txt=='0'){txt='';};descricao5 = txt;
			
			$("ctecodigo").value=codigo;
			$("controle").value=codigo;
			$("numero").value=descricao;
			$("chave").value=descricao2;
			
			$("protocolo").value=descricao5;
			
			if (descricao3!='X'){
				
				$("protocolo").value=descricao3;
				$("motivo").value=descricao4;
				$("protocolo").disabled=true;
				$("motivo").disabled=true;
				//$("botao3").disabled=true;
				$("botao3").value="Reativar";
				
				
				alert('Cte ja foi Cancelado!');
				
				/*
				if (confirm("Cte ja foi Cancelado! Deseja reativar?"))
				{
					//window.open ('cancelamentoctereativaxml.php?ctecodigo=' + document.getElementById('ctecodigo').value 
					new ajax ('cancelamentoctereativaxml.php?ctecodigo=' + document.getElementById('ctecodigo').value 
					+ '&numero=' + document.getElementById('numero').value 
					,{onComplete: limpa_form2});
					//, '_blank');
				}
				*/
				
				
				
				
			}
			else
			{
			
				$("botao3").value="Confirma";
			
			}
			


	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo

		$("ctecodigo").value="";
		$("ctecodigo").value="";
		$("controle").value="";
		$("numero").value="";
		$("chave").value="";
			

	  }
   }


