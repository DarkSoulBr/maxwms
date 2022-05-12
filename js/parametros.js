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



function enviar()
{
	versao = document.getElementById('versao').value;	
	if ( document.getElementById("radio1").checked==true){
		ambiente = '1';
	}
	else{
		ambiente = '2';
	}
	
	servico = document.getElementById('servico').value;
	apolice = document.getElementById('apolice').value;
	gerrntrc = document.getElementById('gerrntrc').value;
	perc = document.getElementById('perc').value;
	
	
	if ( document.getElementById("radio01").checked==true){
		versaocte = '1';
	}
	else{
		versaocte = '2';
	}


	if ( document.getElementById("radiox1").checked==true){
		assinacte = '1';
	}
	else{
		assinacte = '2';
	}


    if($("acao").value=="inserir")
    {	
		ajax2.open("POST", "parametrosinsere.php", true);
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

        var params = 'parambiente=' + ambiente +
					 '&servico=' + servico +
					 '&apolice=' + apolice +
					 '&gerrntrc=' + gerrntrc +
					 '&perc=' + perc +	
					 '&versaocte=' + versaocte +
					 '&assinacte=' + assinacte +
					 '&parversao=' + versao; 					 
					 

				  
        ajax2.send(params);	
		//window.open('parametrosinsere.php?' + params , '_blank');

	}
	else if($("acao").value=="alterar")
	{			
		//window.open ('parametrosaltera.php?parambiente=' + ambiente +
		new ajax ('parametrosaltera.php?parambiente=' + ambiente +
                  '&parversao=' + versao +
				  '&servico=' + servico +
				  '&apolice=' + apolice +
				  '&gerrntrc=' + gerrntrc +
				  '&perc=' + perc +	
				  '&versaocte=' + versaocte +
				  '&assinacte=' + assinacte +
				  '&parcodigos=' + document.getElementById('parcod').value             				  
                  , {});
				  
                  //,"_blank");

		
    	alert("Registro alterado com sucesso!");
		$('MsgResultado').innerHTML = "";
		//document.location.reload();
	}
}

function valida_form(tipo)
{
	var erro = 0;
/*
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
	*/	
    
    if(erro==0)
    enviar();
}


function limpa_form(tipo)
{
	
	$("acao").value="inserir";
	$("botao").value="Incluir";
	$("parcod").value="";
    $("versao").value="";
	$("servico").value="";
	$("apolice").value="";
	$("gerrntrc").value="";
	$("perc").value="";
	document.getElementById("radio1").checked=true;
	document.getElementById("radio01").checked=true;
	document.getElementById("radiox1").checked=true;
	
}

function limpa_form2()
{
    
	$("acao").value="inserir";
	$("botao").value="Incluir";
	$("parcod").value="";
    $("versao").value="";
	$("servico").value="";
	$("apolice").value="";
	$("gerrntrc").value="";
	$("perc").value="";
	document.getElementById("radio1").checked=true;
	document.getElementById("radio01").checked=true;
	document.getElementById("radiox1").checked=true;
	
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
		
		ajax2.open("POST", "parametrospesquisa.php", true);
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
				  	   	
					$('MsgResultado').innerHTML = "";										
					limpa_form(0);
					
			   	}
			}
		}
		
		valor2 = "1";        
        var params = "parametro="+valor+'&parametro2='+valor2;

        if(valor!="")		
        ajax2.send(params);
		//window.open("clientepesquisa.php?" + params);
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
	

        for(var i = 0 ; i < dataArray.length ; i++)
        {
        	var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigo   =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao   =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var descricao2 	=  item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;
			var descricao3	=  item.getElementsByTagName("descricao3")[0].firstChild.nodeValue;
			var descricao4 	=  item.getElementsByTagName("descricao4")[0].firstChild.nodeValue;
			var descricao5 	=  item.getElementsByTagName("descricao5")[0].firstChild.nodeValue;
			var descricao6 	=  item.getElementsByTagName("descricao6")[0].firstChild.nodeValue;
			var descricao7 	=  item.getElementsByTagName("descricao7")[0].firstChild.nodeValue;
			var descricao8 	=  item.getElementsByTagName("descricao8")[0].firstChild.nodeValue;
		
			trimjs(descricao);if (txt=='0'){txt='';};descricao = txt;
			trimjs(descricao2);if (txt=='0'){txt='';};descricao2 = txt;
			trimjs(descricao3);if (txt=='0'){txt='';};descricao3 = txt;
			trimjs(descricao4);if (txt=='0'){txt='';};descricao4 = txt;
			trimjs(descricao5);if (txt=='0'){txt='';};descricao5 = txt;
			trimjs(descricao6);if (txt=='0'){txt='';};descricao6 = txt;
			trimjs(descricao7);if (txt=='0'){txt='';};descricao7 = txt;
			trimjs(descricao8);if (txt=='0'){txt='';};descricao8 = txt;

			if(i==0)     
			{
            
				$("parcod").value=codigo;
				
				if (descricao=='1'){
					document.getElementById("radio1").checked=true;
				}
				else
				{
					document.getElementById("radio2").checked=true;
				}
				
				$("versao").value=descricao2;
				$("servico").value=descricao3;
				$("apolice").value=descricao4;
				$("gerrntrc").value=descricao5;
				$("perc").value=descricao6;
				
				if (descricao7=='1'){
					document.getElementById("radio01").checked=true;
				}
				else
				{
					document.getElementById("radio02").checked=true;
				}
				
				if (descricao8=='1'){
					document.getElementById("radiox1").checked=true;
				}
				else
				{
					document.getElementById("radiox2").checked=true;
				}				
				
				
                $("acao").value="alterar";
				$("botao").value="Alterar";
				
			}
		}
		$('MsgResultado').innerHTML = "";		
	}
	else
	{
		// caso o XML volte vazio, printa a mensagem abaixo
           
		//$("forcodigo").value="";
		$("versao").value="";
		$("servico").value="";
		$("apolice").value="";
		$("gerrntrc").value="";
		$("perc").value="";
		document.getElementById("radio01").checked=true;
		document.getElementById("radiox1").checked=true;
	
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


function soNums(e) 
{ 
    if (document.all){var evt=event.keyCode;} 
    else{var evt = e.charCode;} 
    if (evt <20 || (evt >47 && evt<58)){return true;} 
    return false; 
} 

function processXMLinsere(obj)
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
			var parcod    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
		
			trimjs(parcod);
	       	parcod = txt;
			
			//dadospesquisa3(valor);
			
			$("parcod").value=parcod;
			
			alert("Registro incluído com sucesso!");
			$('MsgResultado').innerHTML = "Incluído com sucesso!";
			
			$("acao").value="alterar";
			$("botao").value="Alterar";
			
			$('MsgResultado').innerHTML = "";
			
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