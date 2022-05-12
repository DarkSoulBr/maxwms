var ufibge;

function SomenteNumero(e){
    var tecla=(window.event)?event.keyCode:e.which;   
    if((tecla>47 && tecla<58)) return true;
    else{
    	if (tecla==8 || tecla==0) return true;
	else
		alert("Somente numero para este campo!");
		return false;
    }
}


function Mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}

function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}

function Telefone(v){
    v=v.replace(/\D/g,"")                 
    v=v.replace(/^(\d\d)(\d)/g,"($1)$2") 
    v=v.replace(/(\d{4})(\d)/,"$1-$2")    
    return v
}

function enviar()
{
	valor = document.getElementById('fornguerra').value;	
	if ( document.getElementById("radio11").checked==true){
		pessoa = '1'
	}
	else{
		pessoa = '2'
	}

    if($("acao").value=="inserir")
    {	
		ajax2.open("POST", "clientedepinsere.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{
            if(ajax2.readyState == 4 )
            {
				if(ajax2.responseXML)
				{
			    	processXMLinsere(ajax2.responseXML);
			   	}
			   	else
			   	{
			    	
			   	}
			}
		}

        var params = 'fornguerra=' + document.getElementById('fornguerra').value +
	    		  '&forcod=' + document.getElementById('forcod').value +
           		  '&forrazao=' + document.getElementById('forrazao').value +
                  '&forsuframa=' + document.getElementById('forsuframa').value +
				  '&fornfe=' + document.getElementById('fornfe').value +
				  '&forcnpj=' + document.getElementById('forcnpj').value +
  	        	  '&forie=' + document.getElementById('forie').value +
                  '&forrg=' + document.getElementById('forrg').value +
				  '&forcpf=' + document.getElementById('forcpf').value +
				  '&forobs=' + document.getElementById('forobs').value +				  
				  '&forpessoa=' + pessoa +				  
				  '&fnecep=' + document.getElementById('fnecep').value +
				  '&fneendereco=' + document.getElementById('fneendereco').value +
				  '&fnecomplemento=' + document.getElementById('fnecomplemento').value +
        		  '&fnebairro=' + document.getElementById('fnebairro').value +
        		  '&fnefone=' + document.getElementById('fnefone').value +				  
				  '&fneemail=' + document.getElementById('fneemail').value +
                  '&fnecodcidade=' + document.getElementById('fnecodcidade').value +                  
                  '&fnenumero=' + document.getElementById('fnenumero').value +                  
                  '&cidcodigoibge=' + document.getElementById('cidadeibge').value;          

				  
        ajax2.send(params);	
		//window.open('clienteinsere.php?' + params , '_blank');

	}
	else if($("acao").value=="alterar")
	{			
		//window.open ('clientealtera.php?fornguerra=' + document.getElementById('fornguerra').value +
		new ajax ('clientedepaltera.php?fornguerra=' + document.getElementById('fornguerra').value +
				  "&forcodigo=" + document.getElementById('forcodigo').value +
				  '&forcod=' + document.getElementById('forcod').value +
    		  	  '&forrazao=' + document.getElementById('forrazao').value +
				  '&forsuframa=' + document.getElementById('forsuframa').value +
				  '&fornfe=' + document.getElementById('fornfe').value +
				  '&forcnpj=' + document.getElementById('forcnpj').value +
				  '&forie=' + document.getElementById('forie').value +
				  '&forrg=' + document.getElementById('forrg').value +
				  '&forcpf=' + document.getElementById('forcpf').value +
				  '&forobs=' + document.getElementById('forobs').value +				  
		  		  '&forpessoa=' + pessoa +				  
				  '&fnecep=' + document.getElementById('fnecep').value +
				  '&fneendereco=' + document.getElementById('fneendereco').value +
       		 	  '&fnebairro=' + document.getElementById('fnebairro').value +
       	 		  '&fnefone=' + document.getElementById('fnefone').value +
				  '&fnecomplemento=' + document.getElementById('fnecomplemento').value +
				  '&fneemail=' + document.getElementById('fneemail').value +
                  '&fnecodcidade=' + document.getElementById('fnecodcidade').value +
                  '&fnenumero=' + document.getElementById('fnenumero').value +                  
                  '&cidcodigoibge=' + document.getElementById('cidadeibge').value                  
                  , {});
                  // ,"_blank");

		document.forms[0].listDados.options.length = 0;

		var novo = document.createElement("option");
		// atribui um ID a esse elemento
		novo.setAttribute("id", "opcoes");
		// atribui um valor
		novo.value = document.getElementById('forcodigo').value;
		// atribui um texto
		novo.text  = document.getElementById('fornguerra').value;
		// finalmente adiciona o novo elemento

		if ( document.getElementById("radio1").checked==true){
        	novo.text  = document.getElementById('forcod').value;
		}
		else if ( document.getElementById("radio2").checked==true){
        	novo.text  = document.getElementById('fornguerra').value;
		}
		else if ( document.getElementById("radio3").checked==true){
        	novo.text  = document.getElementById('forrazao').value;
		}
		else if ( document.getElementById("radio4").checked==true){
        	novo.text  = document.getElementById('forcnpj').value;
		}
        else
        {
        	novo.text  = document.getElementById('forcpf').value;
		}

		document.forms[0].listDados.options.add(novo);
    	alert("Registro alterado com sucesso!");
		$('MsgResultado').innerHTML = "Alterado com sucesso!";
		//document.location.reload();
	}
}

function valida_form(tipo)
{
	var erro = 0;

	if($("fornguerra").value=="")
	{
		alert("Preencha o campo Nome de Guerra");
		$("fornguerra").focus();
		erro = 1;
	}

	else if($("forrazao").value=="")
		{
			alert("Preencha o campo Razão Social");
			$("forrazao").focus();
			erro = 1;
		}
		else if($("radio11").checked == true && $('forcnpj').value=='')
				{
					alert("Preencha o campo CNPJ corretamente!");
					$('forcnpj').focus();
					erro = 1;
				}
				else if($("radio11").checked == true && validar($('forcnpj'))==false)
					{
						// O alert é dado dentro da função
						erro = 1;
					}
					else if($("radio12").checked == true && $('forcpf').value=='')
						{
							alert("Preencha o campo CPF corretamente!");
							$('forcpf').focus();
							erro = 1;
						}
						else if($("radio12").checked == true && validar2($('forcpf'))==false)
							{
								// O alert é dado dentro da função
								erro = 1;
							}							
							else if($('fnecep').value == '')
								{
									alert("Preencha o campo CEP corretamente!");
									$('fnecep').focus();
									erro = 1;
								}
								else if($('fnenumero').value == '')
									{
										alert("Preencha o campo Numero corretamente!");
										$('fnenumero').focus();
										erro = 1;
									}
									else if(document.getElementById('cidadeibge').value == '0' || document.getElementById('cidadeibge').value == '')
										{
											alert("Selecione uma CIDADE IBGE!");
											$('cidadeibge').focus();
											erro = 1;
										}

    if($("fnecodcidade").value=="") {$("fnecodcidade").value=0;};
    
    if(erro==0)
    verificacnpjcpf();
}

function verificacnpjcpf()
{

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
	 
     ajax2.open("POST", "clientedepverificacnpjcpf.php", true);
	 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	 
	 ajax2.onreadystatechange = function() {
        if(ajax2.readyState == 4 ) {
		   if(ajax2.responseXML) {
		      processXMLverificacnpjcpf(ajax2.responseXML);				  
		   }
		   else {
		       //caso não seja um arquivo XML emite a mensagem abaixo
			   
		   }
        }
     }
	 
	var pessoa = 0;
	var cnpj = '';
	var cpf = '';
	 
	if ( document.getElementById("radio11").checked==true){
		pessoa = '1';
		cnpj = document.getElementById('forcnpj').value;
	}
	else{
		pessoa = '2';
		cpf = document.getElementById('forcpf').value;
	}
	
    if($("acao").value=="inserir")
    {
		valor = 0;
   	    valor2 = pessoa;
   	    valor3 = cnpj;
		valor4 = cpf;	
	}
	else if($("acao").value=="alterar")
	{
		valor = document.getElementById('forcodigo').value;
   	    valor2 = pessoa;
   	    valor3 = cnpj;
		valor4 = cpf;	
	}	 
	 
	var params = "parametro="+valor+'&parametro2='+valor2+'&parametro3='+valor3+'&parametro4='+valor4;
	 
	 ajax2.send(params);
  }
}

function processXMLverificacnpjcpf(obj)
{
	 
	//pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");
	
	var erro = 1;
      
	//total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		//percorre o arquivo XML paara extrair os dados
		var item = dataArray[0];
		//contéudo dos campos no arquivo XML
		
		var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
		var descricao    =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
		
		if (codigo!='0'){
			alert('CNPJ/CPF já cadastrado para o cliente: '+codigo+' '+descricao);			
		}
		else {
			erro = 0;
		}
		
	}
	else
	{
	    //caso o XML volte vazio, printa a mensagem abaixo

	}
	
	if (erro==0){
	   enviar();	   	   
	}	

}

function limpa_form(tipo)
{
	cep1="";
	$("acao").value="inserir";
	document.getElementById("botao-text").innerHTML = "Incluir";
	$("fornguerra").value="";
    $("forcod").value="";
    $("forcodigo").value="";
	$("forrazao").value="";
	$("forsuframa").value="";
	$("fornfe").value="";
	$("forcnpj").value="";
	$("forie").value="";
	$("forrg").value="";
	$("forcpf").value="";
	$("forobs").value="";	
	$("pesquisa").value="";	
	$("forcnpj").disabled = false;
	$("forie").disabled = false;
	$("forrg").value = "";
	$("forcpf").value = "";
	$("forrg").disabled = true;
	$("forcpf").disabled = true;
	document.getElementById("radio11").checked=true;
	document.getElementById("radio11").disabled = false;		
	document.getElementById("radio12").disabled = false;		
	document.getElementById("radio11").checked=true;
	document.forms[0].listDados.options.length = 1;
	if (document.querySelector('#opcoes')){
        idOpcao = document.getElementById("opcoes");
        idOpcao.innerHTML = "Faça a Pesquisa de Campo";
 	}
	$("fnecep").value="";
	$("fneendereco").value="";
	$("fnecomplemento").value="";
	$("fnebairro").value="";
	$("fnecidade").value="";
	$("fneuf").value="";
    $("fnefone").value="";	
	$("fneemail").value="";	
	$("fnenumero").value="";
	$("fnecodcidade").value="";	
	codigo_fornecedor(tipo);
}

function limpa_form2()
{
    cep1="";
	$("acao").value="inserir";
	document.getElementById("botao-text").innerHTML = "Incluir";
	$("forcodigo").value="";
    $("fornguerra").value="";
	$("forcod").value="";
	$("forrazao").value="";
	$("forsuframa").value="";
	$("fornfe").value="";
	$("forcnpj").value="";
	$("forie").value="";
	$("forrg").value="";
	$("forcpf").value="";
	$("forobs").value="";	
	$("forcnpj").disabled = false;
	$("forie").disabled = false;
	$("forrg").value = "";
	$("forcpf").value = "";
	$("forrg").disabled = true;
	$("forcpf").disabled = true;
	document.getElementById("radio11").checked=true;
	document.getElementById("radio11").disabled = false;		
	document.getElementById("radio12").disabled = false;
	document.getElementById("radio11").checked=true;	
	$("fnecep").value="";
	$("fneendereco").value="";
	$("fnecomplemento").value="";
    $("fnebairro").value="";
    $("fnecidade").value="";
    $("fneuf").value="";
    $("fnefone").value="";	
	$("fneemail").value="";	
	$("fnenumero").value="";
	$("pesquisa").value="";
    $("fnecodcidade").value="";  

}

function verifica()
{
	if($("forcodigo").value=="")
	{
		alert("Nenhum Registro Selecionado!");
	}
	else
	{
    	verifica1();
	}
}

function dadospesquisa(valor)
{
	$('MsgResultado').innerHTML = "Processando...";	
	// verifica se o browser tem suporte a ajax
	try {
         ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    catch(e)
    {
    	try {
            ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try {
               ajax2 = new XMLHttpRequest();
            }
	        catch(exc) {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
         }
      }
	  // se tiver suporte ajax
	  if(ajax2)
	  {
	  	// deixa apenas o elemento 1 no option, os outros são excluídos
		document.forms[0].listDados.options.length = 1;

		idOpcao  = document.getElementById("opcoes");

		ajax2.open("POST", "clientedeppesquisa.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{
			// enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";
	        }
			// após ser processado - chama função processXML que vai varrer os
			// dados
            if(ajax2.readyState == 4 )
            {
				if(ajax2.responseXML)
				{
			    	processXML(ajax2.responseXML);
			   	}
			   	else
			   	{
			    	// caso não seja um arquivo XML emite a mensagem abaixo
					idOpcao.innerHTML = "Faça a Pesquisa de Campo";
				   	alert("Nenhum Registro encontrado!");
					$('MsgResultado').innerHTML = "Nenhum Registro encontrado!";					
			   	}
			}
		}
		// passa o parametro
   		if ( document.getElementById("radio1").checked==true){
                 valor2 = "1";
        }
		else if ( document.getElementById("radio2").checked==true){
                 valor2 = "2";
        }
		else if ( document.getElementById("radio3").checked==true){
                 valor2 = "3";
        }
		else if ( document.getElementById("radio4").checked==true){
                 valor2 = "4";
        }
        else{
                 valor2 = "5";
        }
        var params = "parametro="+valor+'&parametro2='+valor2;

        if(valor!="")		
        ajax2.send(params);
		//window.open("clientepesquisa.php?" + params);
	}
}

function dadospesquisa2(valor)
{
	$('MsgResultado').innerHTML = "Processando...";	
	// verifica se o browser tem suporte a ajax
	try {
         ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    catch(e)
    {
    	try{
        	ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try{
				ajax2 = new XMLHttpRequest();
            }
	        catch(exc)
	        {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
		}
	}
	// se tiver suporte ajax
	if(ajax2)
	{
		ajax2.open("POST", "clientedeppesquisa2.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{
        	// enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
		    }
			// após ser processado - chama função processXML que vai varrer os
			// dados
        	if(ajax2.readyState == 4 )
        	{
				if(ajax2.responseXML) {
					processXML2(ajax2.responseXML);
				}
				else {
					// caso não seja um arquivo XML emite a mensagem abaixo
		   		}
			}
		}
		// passa o parametro escolhido
		var params = "parametro="+valor;
    	ajax2.send(params);
   	}
}

function dadospesquisa3(valor)
{
	$('MsgResultado').innerHTML = "Processando...";	
	// verifica se o browser tem suporte a ajax
	try {
         ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
	}
    catch(e)
    {
    	try {
        	ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try {
               ajax2 = new XMLHttpRequest();
            }
	        catch(exc) {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
		}
	}
	// se tiver suporte ajax
	if(ajax2)
	{
		// deixa apenas o elemento 1 no option, os outros são excluídos
		document.forms[0].listDados.options.length = 1;

		idOpcao  = document.getElementById("opcoes");

	    ajax2.open("POST", "clientedeppesquisa3.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{
        	// enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";
	        }
			// após ser processado - chama função processXML que vai varrer os
			// dados
            if(ajax2.readyState == 4 )
            {
				if(ajax2.responseXML) {
			      processXML3(ajax2.responseXML);
			   	}
			   	else {
			       	// caso não seja um arquivo XML emite a mensagem abaixo
				   	idOpcao.innerHTML = "Faça a Pesquisa de Campo";
				   	alert("Nenhum Registro encontrado!");
					$('MsgResultado').innerHTML = "Nenhum Registro encontrado!";					
			   	}
			}
		}
		// passa o parametro escolhido
	    var params = "parametro="+valor;
        ajax2.send(params);
	}
}

function processXML(obj)
{
	// pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados

		document.forms[0].listDados.options.length = 0;

        for(var i = 0 ; i < dataArray.length ; i++)
        {
        	var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var descricaob =  item.getElementsByTagName("descricaob")[0].firstChild.nodeValue;
			var descricaoc =  item.getElementsByTagName("descricaoc")[0].firstChild.nodeValue;
			var descricaod =  item.getElementsByTagName("descricaod")[0].firstChild.nodeValue;
			var descricaoe =  item.getElementsByTagName("descricaoe")[0].firstChild.nodeValue;
			var descricaof =  item.getElementsByTagName("descricaof")[0].firstChild.nodeValue;
			var descricaog =  item.getElementsByTagName("descricaog")[0].firstChild.nodeValue;
			var descricaoh =  item.getElementsByTagName("descricaoh")[0].firstChild.nodeValue;
			var descricaoi =  item.getElementsByTagName("descricaoi")[0].firstChild.nodeValue;			
			var descricaoib =  item.getElementsByTagName("descricaoib")[0].firstChild.nodeValue;			
			var descricaou =  item.getElementsByTagName("descricaou")[0].firstChild.nodeValue;
            var descricao2a =  item.getElementsByTagName("descricao2a")[0].firstChild.nodeValue;
            var descricao2b =  item.getElementsByTagName("descricao2b")[0].firstChild.nodeValue;
			var descricao2c =  item.getElementsByTagName("descricao2c")[0].firstChild.nodeValue;
			var descricao2d =  item.getElementsByTagName("descricao2d")[0].firstChild.nodeValue;
			var descricao2e =  item.getElementsByTagName("descricao2e")[0].firstChild.nodeValue;
			var descricao2f =  item.getElementsByTagName("descricao2f")[0].firstChild.nodeValue;
			
            var descricaov =  item.getElementsByTagName("descricaov")[0].firstChild.nodeValue;
			var descricaox =  item.getElementsByTagName("descricaox")[0].firstChild.nodeValue;
			var descricaoz =  item.getElementsByTagName("descricaoz")[0].firstChild.nodeValue;
			var cidadeibge =  item.getElementsByTagName("cidadeibge")[0].firstChild.nodeValue;						
            var fnenumero =  item.getElementsByTagName("fnenumero")[0].firstChild.nodeValue;
			var fornfe =  item.getElementsByTagName("fornfe")[0].firstChild.nodeValue;
			

			trimjs(codigo);        	codigo = txt;
			trimjs(descricao);if (txt=='0'){txt='';};descricao = txt;
			trimjs(descricaob);if (txt=='0'){txt='';};descricaob = txt;
			trimjs(descricaoc);if (txt=='0'){txt='';};descricaoc = txt;
			trimjs(descricaod);if (txt=='0'){txt='';};descricaod = txt;
			trimjs(descricaoe);if (txt=='0'){txt='';};descricaoe = txt;
			trimjs(descricaof);if (txt=='0'){txt='';};descricaof = txt;
			trimjs(descricaog);if (txt=='0'){txt='';};descricaog = txt;
			trimjs(descricaoh);if (txt=='0'){txt='';};descricaoh = txt;
			trimjs(descricaoi);if (txt=='0'){txt='';};descricaoi = txt;			
			trimjs(descricaoib);if (txt=='0'){txt='';};descricaoib = txt;			
			trimjs(descricaou);if (txt=='0'){txt='';};descricaou = txt;
			trimjs(descricao2a);if (txt=='0'){txt='';};descricao2a = txt;
			trimjs(descricao2b);if (txt=='0'){txt='';};descricao2b = txt;
			trimjs(descricao2c);if (txt=='0'){txt='';};descricao2c = txt;
			trimjs(descricao2d);if (txt=='0'){txt='';};descricao2d = txt;
			trimjs(descricao2e);if (txt=='0'){txt='';};descricao2e = txt;
			trimjs(descricao2f);if (txt=='0'){txt='';};descricao2f = txt;
      		trimjs(descricaov);if (txt=='0'){txt='';};descricaov = txt;
         	trimjs(descricaox);if (txt=='0'){txt='';};descricaox = txt;
			trimjs(descricaoz);if (txt=='0'){txt='';};descricaoz = txt;			
			trimjs(cidadeibge);if (txt=='0'){txt='';};cidadeibge = txt;			
			trimjs(fnenumero);if (txt=='0'){txt='';};fnenumero = txt;
			trimjs(fornfe);fornfe = txt;
			
			// cria um novo option dinamicamente
			var novo = document.createElement("option");
			// atribui um ID a esse elemento
			novo.setAttribute("id", "opcoes");
			// atribui um valor
			novo.value = codigo;
			// atribui um texto
			if ( document.getElementById("radio1").checked==true){
            	novo.text  = descricaob;
			}
			else if ( document.getElementById("radio2").checked==true){
            	novo.text  = descricao;
			}
			else if ( document.getElementById("radio3").checked==true){
				novo.text  = descricaoc;
			}
    		else if ( document.getElementById("radio4").checked==true){
				novo.text  = descricaoe;
			}
            else
            {
				novo.text  = descricaoh;
			}
			// finalmente adiciona o novo elemento
			document.forms[0].listDados.options.add(novo);

			if(i==0)
			{
                cep1=descricao2a;

				$("forcodigo").value=codigo;
				$("fornguerra").value=descricao;
				$("forcod").value=descricaob;
				$("forrazao").value=descricaoc;
				$("forsuframa").value=descricaod;
				$("forcnpj").value=descricaoe;
				$("forie").value=descricaof;
				$("forrg").value=descricaog;
				$("forcpf").value=descricaoh;
				$("forobs").value=descricaoi;				
			    if (descricaou=='1')
			    {
                    document.getElementById("radio11").checked=true;
					$("forcnpj").disabled=false;
					$("forie").disabled=false;
					$("forrg").disabled=true;
					$("forcpf").disabled=true;
				}
                else
                {
                    document.getElementById("radio12").checked=true;
					$("forcnpj").disabled=true;
					$("forie").disabled=true;
					$("forrg").disabled=false;
					$("forcpf").disabled=false;
				}
				$("fnecep").value=descricao2a;
				$("fneendereco").value=descricao2b;
				$("fnebairro").value=descricao2c;
				$("fnefone").value=descricao2d;
				$("fnecomplemento").value=descricao2e;
				$("fneemail").value=descricao2f;

                $("fnecodcidade").value=descricaov;
				$("fnecidade").value=descricaox;
				$("fneuf").value=descricaoz;
				
				$("fnenumero").value=fnenumero;				
				$("fornfe").value=fornfe;				
										
				document.getElementById("radio11").disabled = false;		
				document.getElementById("radio12").disabled = false;
			
				if( document.getElementById("radio11").checked==true)
				{
					$("forcnpj").disabled = false;
					$("forie").disabled = false;
					$("forrg").value = "";
					$("forcpf").value = "";
					$("forrg").disabled = true;
					$("forcpf").disabled = true;
				}
				else
				{
					$("forcnpj").disabled = true;
					$("forie").disabled = true;
					$("forcnpj").value = "";
					$("forie").value = "";
					$("forrg").disabled = false;
					$("forcpf").disabled = false;
				}
				document.getElementById("radio11").disabled = false;
				document.getElementById("radio12").disabled = false;					
				$("forobs").disabled = false;					
								 
				ufibge = descricaoib;
				// dadospesquisaibgerep(descricaoz);
				window.setTimeout("dadospesquisaibgerep('"+descricaoz+"')", 1000);
				// window.setTimeout("seleciona_ufibge()", 1000);
				
                $("acao").value="alterar";
				document.getElementById("botao-text").innerHTML = "Alterar";
				
			}
		}
		$('MsgResultado').innerHTML = "";		
	}
	else
	{
		// caso o XML volte vazio, printa a mensagem abaixo
       	cep1="";        
		$("forcodigo").value="";
		$("fornguerra").value="";
		$("forcod").value="";
		$("forrazao").value="";
		$("forsuframa").value="";
		$("fornfe").value="";
		$("forcnpj").value="";
		$("forie").value="";
		$("forrg").value="";
		$("forcpf").value="";
		$("forobs").value="";		
		$("fnecep").value="";
		$("fneendereco").value="";
		$("fnebairro").value="";
		$("fnefone").value="";
		$("fnecomplemento").value="";
		$("fneemail").value="";		
		$("acao").value="inserir";
		document.getElementById("botao-text").innerHTML = "Incluir";
		document.getElementById("radio11").checked=true;
        document.getElementById("radios2").checked=true;
		idOpcao  = document.getElementById("opcoes");
		idOpcao.innerHTML = "Faça a Pesquisa de Campo";	
		$('MsgResultado').innerHTML = "";		
	}
}

function processXML2(obj)
{
	// pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados
        for(var i = 0 ; i < dataArray.length ; i++)
        {
        	var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var descricaob =  item.getElementsByTagName("descricaob")[0].firstChild.nodeValue;
			var descricaoc =  item.getElementsByTagName("descricaoc")[0].firstChild.nodeValue;
			var descricaod =  item.getElementsByTagName("descricaod")[0].firstChild.nodeValue;
			var descricaoe =  item.getElementsByTagName("descricaoe")[0].firstChild.nodeValue;
			var descricaof =  item.getElementsByTagName("descricaof")[0].firstChild.nodeValue;
			var descricaog =  item.getElementsByTagName("descricaog")[0].firstChild.nodeValue;
			var descricaoh =  item.getElementsByTagName("descricaoh")[0].firstChild.nodeValue;
			var descricaoi =  item.getElementsByTagName("descricaoi")[0].firstChild.nodeValue;			
			var descricaou =  item.getElementsByTagName("descricaou")[0].firstChild.nodeValue;
            var descricao2a =  item.getElementsByTagName("descricao2a")[0].firstChild.nodeValue;
            var descricao2b =  item.getElementsByTagName("descricao2b")[0].firstChild.nodeValue;
			var descricao2c =  item.getElementsByTagName("descricao2c")[0].firstChild.nodeValue;
			var descricao2d =  item.getElementsByTagName("descricao2d")[0].firstChild.nodeValue;
			var descricao2e =  item.getElementsByTagName("descricao2e")[0].firstChild.nodeValue;
			var descricao2f =  item.getElementsByTagName("descricao2f")[0].firstChild.nodeValue;
			var descricaov =  item.getElementsByTagName("descricaov")[0].firstChild.nodeValue;
			var descricaox =  item.getElementsByTagName("descricaox")[0].firstChild.nodeValue;
			var descricaoz =  item.getElementsByTagName("descricaoz")[0].firstChild.nodeValue;
			var fornfe =  item.getElementsByTagName("fornfe")[0].firstChild.nodeValue;

            cep1=descricao2a;
            
			trimjs(codigo);        	codigo = txt;
			trimjs(descricao);if (txt=='0'){txt='';};descricao = txt;
			trimjs(descricaob);if (txt=='0'){txt='';};descricaob = txt;
			trimjs(descricaoc);if (txt=='0'){txt='';};descricaoc = txt;
			trimjs(descricaod);if (txt=='0'){txt='';};descricaod = txt;
			trimjs(descricaoe);if (txt=='0'){txt='';};descricaoe = txt;
			trimjs(descricaof);if (txt=='0'){txt='';};descricaof = txt;
			trimjs(descricaog);if (txt=='0'){txt='';};descricaog = txt;
			trimjs(descricaoh);if (txt=='0'){txt='';};descricaoh = txt;
			trimjs(descricaoi);if (txt=='0'){txt='';};descricaoi = txt;			
			trimjs(descricaou);if (txt=='0'){txt='';};descricaou = txt;
			trimjs(descricao2a);if (txt=='0'){txt='';};descricao2a = txt;
			trimjs(descricao2b);if (txt=='0'){txt='';};descricao2b = txt;
			trimjs(descricao2c);if (txt=='0'){txt='';};descricao2c = txt;
			trimjs(descricao2d);if (txt=='0'){txt='';};descricao2d = txt;
			trimjs(descricao2e);if (txt=='0'){txt='';};descricao2e = txt;
			trimjs(descricao2f);if (txt=='0'){txt='';};descricao2f = txt;
      		trimjs(descricaov);if (txt=='0'){txt='';};descricaov = txt;
         	trimjs(descricaox);if (txt=='0'){txt='';};descricaox = txt;
			trimjs(descricaoz);if (txt=='0'){txt='';};descricaoz = txt;
			trimjs(fornfe);fornfe = txt;

			$("forcodigo").value=codigo;
			$("fornguerra").value=descricao;
			$("forcod").value=descricaob;
			$("forrazao").value=descricaoc;
			$("forsuframa").value=descricaod;
			$("forcnpj").value=descricaoe;
			$("forie").value=descricaof;
			$("forrg").value=descricaog;
			$("forcpf").value=descricaoh;
			$("forobs").value=descricaoi;
			if (descricaou=='1')
			{
            	document.getElementById("radio11").checked=true;
				$("forcnpj").disabled=false;
				$("forie").disabled=false;
				$("forrg").disabled=true;
				$("forcpf").disabled=true;
			}
            else
            {
            	document.getElementById("radio12").checked=true;
				$("forcnpj").disabled=true;
				$("forie").disabled=true;
				$("forrg").disabled=false;
				$("forcpf").disabled=false;
			}
			$("fnecep").value=descricao2a;
			$("fneendereco").value=descricao2b;
			$("fnebairro").value=descricao2c;
			$("fnefone").value=descricao2d;
			$("fnecomplemento").value=descricao2e;
			$("fneemail").value=descricao2f;
			
            
	        $("fnecodcidade").value=descricaov;
			$("fnecidade").value=descricaox;
			$("fneuf").value=descricaoz;
			$("fornfe").value=fornfe;	
									
			document.getElementById("radio11").disabled = false;		
			document.getElementById("radio12").disabled = false;
		
			if( document.getElementById("radio11").checked==true)
			{
				$("forcnpj").disabled = false;
				$("forie").disabled = false;
				$("forrg").value = "";
				$("forcpf").value = "";
				$("forrg").disabled = true;
				$("forcpf").disabled = true;
			}
			else
			{
				$("forcnpj").disabled = true;
				$("forie").disabled = true;
				$("forcnpj").value = "";
				$("forie").value = "";
				$("forrg").disabled = false;
				$("forcpf").disabled = false;
			}
			document.getElementById("radio11").disabled = false;
			document.getElementById("radio12").disabled = false;				
			$("forobs").disabled = false;				
			
		}
		$('MsgResultado').innerHTML = "";		
	}
	else
	{
		// caso o XML volte vazio, printa a mensagem abaixo
        cep1="";        
		$("forcodigo").value="";
		$("fornguerra").value="";
		$("forcod").value="";
		$("forrazao").value="";
		$("forsuframa").value="";
		$("fornfe").value="";
		$("forcnpj").value="";
		$("forie").value="";
		$("forrg").value="";
		$("forcpf").value="";
		$("forobs").value="";		
		document.getElementById("radio11").checked=true;
		document.getElementById("radios2").checked=true;
		$("acao").value="inserir";
		document.getElementById("botao-text").innerHTML = "Incluir";		
		$('MsgResultado').innerHTML = "";		
	}
}

function processXML3(obj)
{
	// pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados
		document.forms[0].listDados.options.length = 0;

		for(var i = 0 ; i < dataArray.length ; i++)
		{
        	var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var descricaob =  item.getElementsByTagName("descricaob")[0].firstChild.nodeValue;
			var descricaoc =  item.getElementsByTagName("descricaoc")[0].firstChild.nodeValue;
			var descricaoe =  item.getElementsByTagName("descricaoe")[0].firstChild.nodeValue;
			var descricaoh =  item.getElementsByTagName("descricaoh")[0].firstChild.nodeValue;

			trimjs(codigo);
	       	codigo = txt;
			trimjs(descricao);
			descricao = txt;
			trimjs(descricaob);
			descricaob = txt;
			trimjs(descricaoc);
			descricaoc = txt;
			trimjs(descricaoe);
			descricaoe = txt;
			trimjs(descricaoh);
			descricaoh = txt;

			// cria um novo option dinamicamente
			var novo = document.createElement("option");
			// atribui um ID a esse elemento
			novo.setAttribute("id", "opcoes");
			// atribui um valor
			novo.value = codigo;
			// atribui um texto
			if ( document.getElementById("radio1").checked==true)
			{
            	novo.text  = descricaob;
            }
			else if ( document.getElementById("radio2").checked==true)
			{
            	novo.text  = descricao;
            }
			else if ( document.getElementById("radio3").checked==true)
			{
            	novo.text  = descricaoc;
            }
    		else if ( document.getElementById("radio4").checked==true)
    		{
            	novo.text  = descricaoe;
            }
            else
            {
            	novo.text  = descricaoh;
            }
			// finalmente adiciona o novo elemento
			document.forms[0].listDados.options.add(novo);

			if(i==0)
			{
				$("forcodigo").value=codigo;
				$("acao").value="alterar";
				document.getElementById("botao-text").innerHTML = "Alterar";
			}
		}
		$('MsgResultado').innerHTML = "";		
	}
	else
	{
	    // caso o XML volte vazio, printa a mensagem abaixo
		$("forcodigo").value="";
		$("fornguerra").value="";
		$("forcod").value="";
		$("forrazao").value="";
		$("forsuframa").value="";
		$("fornfe").value="";
		$("forcnpj").value="";
		$("forie").value="";
		$("forrg").value="";
		$("forcpf").value="";
		$("forobs").value="";		
		$("acao").value="inserir";
		document.getElementById("botao-text").innerHTML = "Incluir";
		idOpcao  = document.getElementById("opcoes");
		idOpcao.innerHTML = "Faça a Pesquisa de Campo";	
		$('MsgResultado').innerHTML = "";		
	}
}

function pesquisacep(valor)
{
	trimjs($("fnecep").value);

	if(cep1!=txt)
	{
    	if(txt!="")
    	{
			// verifica se o browser tem suporte a ajax
	  		try
	  		{
         		ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
      		}
      		catch(e)
      		{
         		try
         		{
            		ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
         		}
	     		catch(ex)
	     		{
            		try
            		{
               			ajax2 = new XMLHttpRequest();
            		}
	        		catch(exc)
	        		{
               			alert("Esse browser não tem recursos para uso do Ajax");
						ajax2 = null;
            		}
         		}
      		}
	  		// se tiver suporte ajax
	  		if(ajax2)
	  		{
				ajax2.open("POST", "ceppesquisa.php", true);
				ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

				ajax2.onreadystatechange = function()
				{
					// enquanto estiver processando...emite a msg de carregando
					if(ajax2.readyState == 1) {
					}
					// após ser processado - chama função processXML que vai
					// varrer os dados
            		if(ajax2.readyState == 4 )
            		{
			   			if(ajax2.responseXML)
			   			{
			      			processXMLCEP(ajax2.responseXML);
			   			}
			   			else
			   			{
			       			// caso não seja um arquivo XML emite a mensagem
							// abaixo
						}
            		}
         		}
				// passa o parametro
         		var params = "parametro="+valor;
         		ajax2.send(params);
      		}
		}
		else
      	{
			$("fnecidade").value="";
      		$("fneuf").value="";
      		$("fnecodcidade").value="";
		}
	}
}

function processXMLCEP(obj)
{
	// pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados

        for(var i = 0 ; i < dataArray.length ; i++)
        {
        	var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var descricao2 =  item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;
			var descricao3 =  item.getElementsByTagName("descricao3")[0].firstChild.nodeValue;
			var descricao4 =  item.getElementsByTagName("descricao4")[0].firstChild.nodeValue;

			trimjs(codigo);if (txt=='_'){txt='';};codigo = txt;
			trimjs(descricao);if (txt=='_'){txt='';};descricao = txt;
			trimjs(descricao2);if (txt=='_'){txt='';};descricao2 = txt;
			trimjs(descricao3);if (txt=='_'){txt='';};descricao3 = txt;
			trimjs(descricao4);if (txt=='_'){txt='';};descricao4 = txt;

			$("fneendereco").value=descricao3;
			$("fnebairro").value=descricao4.substring(0,30);
            $("fnecidade").value=descricao;
			$("fneuf").value=descricao2;
 	        $("fnecodcidade").value=codigo;
  	        cep1=$("fnecep").value;

  	        // busca cidade ibge
           	dadospesquisaibgerep(descricao2);
		}
	}
	else
	{
		// caso o XML volte vazio, printa a mensagem abaixo
        alert("O CEP não é válido!");
        document.getElementById("fnecep").focus();
	}
}

function codigo_fornecedor(valor)
{
	// verifica se o browser tem suporte a ajax
	try
	{
    	ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    catch(e)
    {
    	try
    	{
        	ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try
        	{
            	ajax2 = new XMLHttpRequest();
            }
	        catch(exc)
	        {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
		}
	}
	// se tiver suporte ajax
	if(ajax2)
	{
		// deixa apenas o elemento 1 no option, os outros são excluídos
		ajax2.open("POST", "clientedepcodpesquisa.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{
			// enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
	        }
			// após ser processado - chama função processXML que vai varrer os
			// dados
            if(ajax2.readyState == 4 )
            {
				if(ajax2.responseXML)
				{
			    	processXMLcodfor(ajax2.responseXML);
			   	}
			   	else{
			       // caso não seja um arquivo XML emite a mensagem abaixo
				}
			}
		}
		// passa o parametro

        var params = "parametro="+valor;
        ajax2.send(params);
	}
}

function processXMLcodfor(obj)
{
	// pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

	// total de elementos contidos na tag dado
    if(dataArray.length > 0)
    {
		// percorre o arquivo XML paara extrair os dados
        for(var i = 0 ; i < dataArray.length ; i++)
        {
        	var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			trimjs(codigo); if (txt=='1'){txt='1';};	codigo = txt;
			$("forcod").value=codigo;			
		}
	}
	else
	{		
		$("forcod").value="1";
	}
    
}

function verificapessoa(valor)
{
	if( document.getElementById("radio11").checked==true)
	{
		$("forcnpj").disabled = false;
		$("forie").disabled = false;
		$("forrg").value = "";
		$("forcpf").value = "";
		$("forrg").disabled = true;
		$("forcpf").disabled = true;
	}
	else
	{
		$("forcnpj").disabled = true;
		$("forie").disabled = true;
		$("forcnpj").value = "";
		$("forie").value = "";
		$("forrg").disabled = false;
		$("forcpf").disabled = false;
	}
}
  
// JavaScript Document
/*******************************************************************************
 * #################################################################### Assunto =
 * Validação de CPF e CNPJ Autor = Marcos Regis Data = 24/01/2006 Versão = 1.0
 * Compatibilidade = Todos os navegadores. Pode ser usado e distribuído desde
 * que esta linhas sejam mantidas
 * ====------------------------------------------------------------====
 * 
 * Funcionamento = O script recebe como parâmetro um objeto por isso deve ser
 * chamado da seguinte forma: E.: no evento onBlur de um campo texto <input
 * name="cpf_cnpj" type="text" size="40" maxlength="18" onBlur="validar(this);">
 * Ao deixar o campo o evento é disparado e chama validar() com o argumento
 * "this" que representa o próprio objeto com todas as propriedades. A partir
 * daí a função validar() trata a entrada removendo tudo que não for caracter
 * numérico e deixando apenas números, portanto valores escritos só com números
 * ou com separadores como '.' ou mesmo espaços são aceitos ex.: 111222333/44,
 * 111.222.333-44, 111 222 333 44 serão tratadoc como 11122233344 (para CPFs) De
 * certa forma até mesmo valores como 111A222B333C44 será aceito mas aconselho a
 * usar a função soNums() que encotra-se aqui mesmo para que o campo só aceite
 * caracteres numéricos. Para usar a função soNums() chame-a no evento
 * onKeyPress desta forma onKeyPress="return soNums(event);" Após limpar o valor
 * verificamos seu tamanho que deve ser ou 11 ou 14 Se o tamanho não for aceito
 * a função retorna false e [opcional] mostra uma mensagem de erro. Sugestões e
 * comentários marcos_regis@hotmail.com
 * ####################################################################
 ******************************************************************************/ 

// a função principal de validação
function validar(obj) { // recebe um objeto
    var s = (obj.value).replace(/\D/g,''); 
    var tam=(s).length; // removendo os caracteres não numéricos
	if (tam==0){ // validando o tamanho
		return true; 
    } 
    if (!(tam==14)){ // validando o tamanho
        alert("'"+s+"' Não é um CNPJ válido!" ); // tamanho inválido
		obj.focus();
        return false; 
    } 
    
// se for CNPJ
    if (tam==14){ 
        if(!validaCNPJ(s)){ // chama a função que valida o CNPJ
            alert("'"+s+"' Não é um CNPJ válido!" ); // se quiser mostrar o
														// erro
            obj.select();    // se quiser selecionar o campo enviado
			obj.focus();
            return false;             
        } 
        // alert("'"+s+"' É um CNPJ válido!" ); // se quiser mostrar que validou
        obj.value=maskCNPJ(s);    // se validou o CNPJ mascaramos corretamente
        return true; 
    } 
} 
// fim da funcao validar()

// a função principal de validação
function validar2(obj) { // recebe um objeto
    var s = (obj.value).replace(/\D/g,''); 
    var tam=(s).length; // removendo os caracteres não numéricos
	if (tam==0){ // validando o tamanho
		return true; 
    } 
    if (!(tam==11)){ // validando o tamanho
        alert("'"+s+"' Não é um CPF válido!" ); // tamanho inválido
		obj.focus();
        return false; 
    } 
     
// se for CPF
    if (tam==11 ){ 
        if (!validaCPF(s)){ // chama a função que valida o CPF
            alert("'"+s+"' Não é um CPF válido!" ); // se quiser mostrar o erro
            obj.select();  // se quiser selecionar o campo em questão
			obj.focus();
			return false; 
        } 
        // alert("'"+s+"' É um CPF válido!" ); // se quiser mostrar que validou
        obj.value=maskCPF(s);    // se validou o CPF mascaramos corretamente
        return true; 
    } 
} 
// fim da funcao validar()

// função que valida CPF
// O algorítimo de validação de CPF é baseado em cálculos
// para o dígito verificador (os dois últimos)
// Não entrarei em detalhes de como funciona
function validaCPF(s) { 
    var c = s.substr(0,9); 
    var dv = s.substr(9,2); 
    var d1 = 0; 
    for (var i=0; i<9; i++) { 
        d1 += c.charAt(i)*(10-i); 
     } 
    if (d1 == 0) return false; 
    d1 = 11 - (d1 % 11); 
    if (d1 > 9) d1 = 0; 
    if (dv.charAt(0) != d1){ 
        return false; 
    } 
    d1 *= 2; 
    for (var i = 0; i < 9; i++)    { 
         d1 += c.charAt(i)*(11-i); 
    } 
    d1 = 11 - (d1 % 11); 
    if (d1 > 9) d1 = 0; 
    if (dv.charAt(1) != d1){ 
        return false; 
    } 
    return true; 
} 

// Função que valida CNPJ
// O algorítimo de validação de CNPJ é baseado em cálculos
// para o dígito verificador (os dois últimos)
// Não entrarei em detalhes de como funciona
function validaCNPJ(CNPJ) { 
    var a = new Array(); 
    var b = new Number; 
    var c = [6,5,4,3,2,9,8,7,6,5,4,3,2]; 
    for (i=0; i<12; i++){ 
        a[i] = CNPJ.charAt(i); 
        b += a[i] * c[i+1]; 
    } 
    if ((x = b % 11) < 2) { a[12] = 0 } else { a[12] = 11-x } 
    b = 0; 
    for (y=0; y<13; y++) { 
        b += (a[y] * c[y]); 
    } 
    if ((x = b % 11) < 2) { a[13] = 0; } else { a[13] = 11-x; } 
    if ((CNPJ.charAt(12) != a[12]) || (CNPJ.charAt(13) != a[13])){ 
        return false; 
    } 
    return true; 
} 

// Função que permite apenas teclas numéricas
// Deve ser chamada no evento onKeyPress desta forma
// return (soNums(event));

function soNums(e) 
{ 
    if (document.all){var evt=event.keyCode;} 
    else{var evt = e.charCode;} 
    if (evt <20 || (evt >47 && evt<58)){return true;} 
    return false; 
} 

// função que mascara o CPF
function maskCPF(CPF){ 
    return CPF.substring(0,3)+"."+CPF.substring(3,6)+"."+CPF.substring(6,9)+"-"+CPF.substring(9,11); 
} 

// função que mascara o CNPJ
function maskCNPJ(CNPJ){ 
    return CNPJ.substring(0,2)+"."+CNPJ.substring(2,5)+"."+CNPJ.substring(5,8)+"/"+CNPJ.substring(8,12)+"-"+CNPJ.substring(12,14);     
}

function dadospesquisaibgerep(valor)
{
	
	// verifica se o browser tem suporte a ajax
	try
	{
    	ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
	}
    catch(e)
    {
    	try
    	{
        	ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try
        	{
               ajax2 = new XMLHttpRequest();
            }
	        catch(exc)
	        {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
		}
	}
	// se tiver suporte ajax
	if(ajax2)
	{
		
		// deixa apenas o elemento 1 no option, os outros são excluídos
		document.forms[0].cidadeibge.options.length = 1;

		var idOpcaoendx1  = document.getElementById("cidcodigoibge");

        ajax2.open("POST", "cidadesibge.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{
			// enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1)
			{
			   idOpcaoendx1.innerHTML = "Carregando...!";
	        }
			// após ser processado - chama função processXML que vai varrer os
			// dados
            if(ajax2.readyState == 4 )
            {
			   if(ajax2.responseXML)
			   {
			      processXMLibgerep(ajax2.responseXML);
			   }
			   else
			   {
			       // caso não seja um arquivo XML emite a mensagem abaixo
				   $('cidadeibge').innerHTML = '<option id="cidcodigoibge" value="0">____________________________________</option>';
			   }
			}
		}
        var params = "parametro="+valor;
        ajax2.send(params);
	}
}

function processXMLibgerep(obj)
{
	// document.forms[0].listcidades.options.length = 0;
    // document.forms[0].listbairros.options.length = 0;
    var dataArray   = obj.getElementsByTagName("dadoib");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados
		document.forms[0].cidadeibge.options.length = 0;
        for(var i = 0 ; i < dataArray.length ; i++)
        {
            var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigoib  =  item.getElementsByTagName("codigoib")[0].firstChild.nodeValue;
			var cidadeib 	=  item.getElementsByTagName("cidadeib")[0].firstChild.nodeValue;

			trimjs(codigoib);
      		var codigo = txt;
			trimjs(cidadeib);
			var cidade  = txt;

         	// idOpcao.innerHTML = "";
			
			if(i==0)
			{
				// cria um novo option dinamicamente
				var novo = document.createElement("option");
			
				// atribui um ID a esse elemento
			    novo.setAttribute("id", "cidcodigoibge");
				// atribui um valor
			    novo.value = "0";
				// atribui um texto
			    novo.text  = "Escolha uma Cidade";
				// finalmente adiciona o novo elemento
				document.forms[0].cidadeibge.options.add(novo);
			}
			
			// cria um novo option dinamicamente
			var novo = document.createElement("option");

		    // atribui um ID a esse elemento
		    novo.setAttribute("id", "cidcodigoibge");
			// atribui um valor
		    novo.value = codigoib;
			// atribui um texto
		    novo.text  = cidadeib;
			// finalmente adiciona o novo elemento
			document.forms[0].cidadeibge.options.add(novo);

            document.forms[0].cidadeibge.disabled=false;
            // if(ufibge == codigoib)
            // document.forms[0].cidadeibge.selected;
		}
		document.getElementById("cidcodigoibge").disabled = false;
	}
	// else
	// {
		// caso o XML volte vazio, printa a mensagem abaixo
    // var cidcodigoibge = document.getElementById("cidcodigoibge");
	// cidcodigoibge.innerHTML = "____________________";
	// document.getElementById("cidcodigoibge").disabled = true;
	// }
	if(ufibge != "")
	{
	$('cidadeibge').value = ufibge;
	}
}

function processXMLinsere(obj)
{

	valor = document.getElementById('fornguerra').value;

	// pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados
		document.forms[0].listDados.options.length = 0;

		for(var i = 0 ; i < dataArray.length ; i++)
		{
        	var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var forcod    =  item.getElementsByTagName("forcod")[0].firstChild.nodeValue;
		
			trimjs(forcod);
	       	forcod = txt;
			
			dadospesquisa3(valor);
			
			$("forcod").value=forcod;
			
			alert("Registro incluído com sucesso!\nCom o número: "+forcod);
			$('MsgResultado').innerHTML = "Incluído com sucesso!";
		}
		
	}
	else
	{
	    // caso o XML volte vazio, printa a mensagem abaixo
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