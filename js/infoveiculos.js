var vusuario = 0;
var contador = 0;

// JavaScript Document
function inicia(usucodigo){

	vusuario = usucodigo;		
	
	dadospesquisarodado(0);
			
}

function load_grid_vei(){

	new ajax ('infoveiculoseleciona.php?usucodigo='+ vusuario
        , {onComplete: pesquisar_vei});

}

function pesquisar_vei(){

	$("resultado").innerHTML="";
	
	new ajax ('infoveiculoseleciona.php?usucodigo='+ vusuario
        , {onComplete: imprime_vei});
		
}

function carregando(){	
}

function imprime_vei(request){
	contador = 0;

    limpa_form();
	$("msg").style.visibility="hidden";
	var xmldoc=request.responseXML;
	var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];

	if(cabecalho!=null)
	{
		var campo = cabecalho.getElementsByTagName('campo');
		var tabela="<table class='borda'><tr>"

		tabela+="<td colspan='0'></td>"
		tabela+="<td colspan='1' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Placa</b></font></td>"
		tabela+="<td colspan='1' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Renavan</b></font></td>"					
		tabela+="<td colspan='1' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>UF</b></font></td>"					
		tabela+="<td colspan='1' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Codigo</b></font></td>"					
		tabela+="<td colspan='1' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Proprietario</b></font></td>"					
		tabela+="<td colspan='2' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Controles</b></font></td>"
		tabela+="<td colspan='0'></td>"
		tabela+="</tr>"

		//corpo da tabela
		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++){
			var itens = registros[i].getElementsByTagName('item');
			tabela+="<tr id=linha"+i+">"
			tabela+="<td class='borda2' >"+itens[0].firstChild.data+"</td>";
			tabela+="<td class='borda' >"+itens[1].firstChild.data+"</td>";	
			if(itens[2].firstChild.data=='_'){
				tabela+="<td class='borda' >&nbsp;</td>";			
			}
			else {
				tabela+="<td class='borda' >"+itens[2].firstChild.data+"</td>";			
			}
			if(itens[3].firstChild.data=='_'){
				tabela+="<td class='borda' >&nbsp;</td>";			
			}
			else {
				tabela+="<td class='borda' >"+itens[3].firstChild.data+"</td>";			
			}	
			if(itens[4].firstChild.data=='_'){
				tabela+="<td class='borda' >&nbsp;</td>";			
			}
			else {
				tabela+="<td class='borda' >"+itens[4].firstChild.data+"</td>";			
			}
			if(itens[5].firstChild.data=='_'){
				tabela+="<td class='borda' >&nbsp;</td>";			
			}
			else {
				tabela+="<td class='borda' >"+itens[5].firstChild.data+"</td>";			
			}
			tabela+='<td class="borda" style="cursor: pointer"><img src="imagens/edit.gif" onClick=editar('+itens[0].firstChild.data+')></td>';
			tabela+="<td class='borda' style='cursor: pointer'><img src='imagens/delete.gif' onClick=apagar("+itens[0].firstChild.data+")></td>";
			tabela+="<td class='borda2' >"+itens[0].firstChild.data+"</td>";
			tabela+="</tr>";
			
			contador++;
			
		}

		tabela+="</table>"
		$("resultado").innerHTML=tabela;
		tabela=null;
	}
	else
		$("resultado").innerHTML="Nenhum registro encontrado...";
}

function apagar(codigo){
    new ajax ('infoveiculosapaga.php?codigo=' + codigo
        , {onLoading: carregando, onComplete: load_grid_vei});
}

function editar(codigo){
	//window.open('infoveiculoscarrega.php?parametro='+ codigo , '_blank' );
	new ajax ('infoveiculoscarrega.php?parametro='+ codigo , {onComplete: imprime_dados});	
}

function imprime_dados(request){


	var xmldoc=request.responseXML;
	
	// pega a tag dado
    var dataArray   = xmldoc.getElementsByTagName("dado");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{		

        for(var i = 0 ; i < dataArray.length ; i++)
        {
        	var item = dataArray[i];
			
			// contéudo dos campos no arquivo XML

			
			
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao1 =  item.getElementsByTagName("descricao1")[0].firstChild.nodeValue;
			var descricao2 =  item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;
			var descricao3 =  item.getElementsByTagName("descricao3")[0].firstChild.nodeValue;
			var descricao4 =  item.getElementsByTagName("descricao4")[0].firstChild.nodeValue;
			var descricao5 =  item.getElementsByTagName("descricao5")[0].firstChild.nodeValue;
			var descricao6 =  item.getElementsByTagName("descricao6")[0].firstChild.nodeValue;
			var descricao7 =  item.getElementsByTagName("descricao7")[0].firstChild.nodeValue;
			var descricao8 =  item.getElementsByTagName("descricao8")[0].firstChild.nodeValue;
			var descricao9 =  item.getElementsByTagName("descricao9")[0].firstChild.nodeValue;
			var descricao10 =  item.getElementsByTagName("descricao10")[0].firstChild.nodeValue;
			var descricao11 =  item.getElementsByTagName("descricao11")[0].firstChild.nodeValue;
			var descricao12 =  item.getElementsByTagName("descricao12")[0].firstChild.nodeValue;
			var descricao13 =  item.getElementsByTagName("descricao13")[0].firstChild.nodeValue;
			var descricao14 =  item.getElementsByTagName("descricao14")[0].firstChild.nodeValue;
			var descricao15 =  item.getElementsByTagName("descricao15")[0].firstChild.nodeValue;
			var descricao16 =  item.getElementsByTagName("descricao16")[0].firstChild.nodeValue;
			var descricao17 =  item.getElementsByTagName("descricao17")[0].firstChild.nodeValue;
			var descricao18 =  item.getElementsByTagName("descricao18")[0].firstChild.nodeValue;
			var descricao19 =  item.getElementsByTagName("descricao19")[0].firstChild.nodeValue;
			var descricao20 =  item.getElementsByTagName("descricao20")[0].firstChild.nodeValue;
			var descricao21 =  item.getElementsByTagName("descricao21")[0].firstChild.nodeValue;
			var descricao22 =  item.getElementsByTagName("descricao22")[0].firstChild.nodeValue;

			trimjs(codigo);codigo = txt;
			
			trimjs(descricao1);descricao1 = txt;
			trimjs(descricao2);descricao2 = txt;
			trimjs(descricao3);descricao3 = txt;
			trimjs(descricao4);descricao4 = txt;
			trimjs(descricao5);descricao5 = txt;
			trimjs(descricao6);descricao6 = txt;
			trimjs(descricao7);descricao7 = txt;
			trimjs(descricao8);descricao8 = txt;
			trimjs(descricao9);descricao9 = txt;
			trimjs(descricao10);descricao10 = txt;
			trimjs(descricao11);descricao11 = txt;
			trimjs(descricao12);descricao12 = txt;

			
			trimjs(descricao13);if (txt=='0'){txt='';};descricao13 = txt;
			trimjs(descricao14);if (txt=='0'){txt='';};descricao14 = txt;
			trimjs(descricao15);if (txt=='0'){txt='';};descricao15 = txt;
			trimjs(descricao16);if (txt=='0'){txt='';};descricao16 = txt;
			trimjs(descricao17);if (txt=='0'){txt='';};descricao17 = txt;
			trimjs(descricao18);if (txt=='0'){txt='';};descricao18 = txt;
			trimjs(descricao19);if (txt=='0'){txt='';};descricao19 = txt;
			trimjs(descricao20);if (txt=='0'){txt='';};descricao20 = txt;
			trimjs(descricao21);if (txt=='0'){txt='';};descricao21 = txt;			
			trimjs(descricao22);if (txt=='0'){txt='';};descricao22 = txt;


			if(i==0)
			{
               
			   	$("veicodigo").value=codigo;
				$("veicod").value=codigo;				
				$("veicodint").value=descricao1;
			   
				$("veirenavam").value=descricao2;
				$("veiplaca").value=descricao3;
				$("veitara").value=descricao4;
				$("veicapacidadekg").value=descricao5;
				$("veicapacidademt").value=descricao6;
				
				itemcombo3(descricao7);
				itemcombo4(descricao8);
				itemcombo5(descricao9);
				itemcombo6(descricao10);
				itemcombo7(descricao18);
				
				itemcombo(descricao11);
								
				$("veicpf").value=descricao13;
				$("veicnpj").value=descricao14;
				$("veirntrc").value=descricao15;
				$("veiie").value=descricao16;			
				itemcombo2(descricao17);				
				$("veirazao").value=descricao19;			
				
			    if (descricao20=='1')
				{
					document.getElementById("radio11").checked=true;
					$("veicnpj").disabled = false;
					$("veiie").disabled = false;					
					$("veicpf").value = "";					
					$("veicpf").disabled = true;
				}
				else
				{
					document.getElementById("radio12").checked=true;
					$("veicnpj").disabled = true;
					$("veiie").disabled = true;
					$("veicnpj").value = "";
					$("veiie").value = "";					
					$("veicpf").disabled = false;
				}
				
				document.getElementById("radio11").disabled = false;
				document.getElementById("radio12").disabled = false;

				if(descricao22=='2')
				{		
					document.getElementById("radio32").checked=true;
					$("veirntrc").disabled = false;
					document.forms[0].veitipproprietario.disabled=false;							
					document.forms[0].listestados2.disabled=false;
					$("veirazao").disabled = false;					
				}
				else
				{
					document.getElementById("radio31").checked=true;
					document.getElementById("radio11").checked=true;
					document.getElementById("radio11").disabled=true;
					document.getElementById("radio12").disabled=true;
					$("veicnpj").disabled = true;
					$("veiie").disabled = true;					
					$("veicpf").value = "";
					$("veicnpj").value = "";
					$("veiie").value = "";					
					$("veicpf").disabled = true;
					$("veirntrc").value = "";
					$("veirntrc").disabled = true;					
					document.forms[0].veitipproprietario.disabled=true;		
					document.forms[0].listestados2.disabled=true;
					$("veirazao").value = "";
					$("veirazao").disabled = true;
				}	
				
                //$("acao").value="alterar";
				//$("botao").value="Alterar";
				
			}
		}		
	}
	else
	{
		// caso o XML volte vazio, printa a mensagem abaixo			
	
		$("veicodigo").value="";
		$("veicod").value="";
		$("veicodint").value="";
		$("veirenavam").value="";
		$("veiplaca").value="";
		$("veitara").value="";
		$("veicapacidadekg").value="";
		$("veicapacidademt").value="";
		
		itemcombo3(1);
		itemcombo4(1);
		itemcombo5(1);
		itemcombo6(1);
		itemcombo7(1);
		itemcombo('AC');
		
		itemcombo2('AC');

		document.getElementById("radio31").checked=true;
		document.getElementById("radio11").checked=true;
		document.getElementById("radio11").disabled=true;
		document.getElementById("radio12").disabled=true;
		$("veicnpj").disabled = true;
		$("veiie").disabled = true;	
		$("veicpf").value = "";
		$("veicnpj").value = "";
		$("veiie").value = "";	
		$("veicpf").disabled = true;
		$("veirntrc").value = "";
		$("veirntrc").disabled = true;	
		document.forms[0].veitipproprietario.disabled=true;		
		document.forms[0].listestados2.disabled=true;
		$("veirazao").value = "";
		$("veirazao").disabled = true;
		
		$("acao").value="inserir";
		$("botao").value="Incluir";	
			
	}
		
}

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

	// verifica se o browser tem suporte a ajax
	try {
         ajax3 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    catch(e)
    {
    	try {
            ajax3 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try {
               ajax3 = new XMLHttpRequest();
            }
	        catch(exc) {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax3 = null;
            }
         }
      }
	  // se tiver suporte ajax
	  if(ajax3)
	  {
	
			if ( document.getElementById("radio31").checked==true){
				veiculoempresa = '1'
			}
			else{
				veiculoempresa = '2'
			}

			if ( document.getElementById("radio11").checked==true){
				pessoa = '1'
			}
			else{
				pessoa = '2'
			}
			

			var params = 'veicodint=' + document.getElementById('veicodint').value +
					  '&veicodigo=' + document.getElementById('veicodigo').value +	
					  '&veirenavam=' + document.getElementById('veirenavam').value +
					  '&veiplaca=' + document.getElementById('veiplaca').value +
					  '&veitara=' + document.getElementById('veitara').value +
					  '&veicapacidadekg=' + document.getElementById('veicapacidadekg').value +
					  '&veicapacidademt=' + document.getElementById('veicapacidademt').value +					  
					  '&veitiporodado=' + document.forms[0].veitiporodado.options[document.forms[0].veitiporodado.selectedIndex].value +
					  '&veitipocarroceria=' + document.forms[0].veitipocarroceria.options[document.forms[0].veitipocarroceria.selectedIndex].value +
					  '&veitipoveiculo=' + document.forms[0].veitipoveiculo.options[document.forms[0].veitipoveiculo.selectedIndex].value +
					  '&veitipopropveiculo=' + document.forms[0].veitipopropveiculo.options[document.forms[0].veitipopropveiculo.selectedIndex].value +
					  '&listestados=' + document.forms[0].listestados.options[document.forms[0].listestados.selectedIndex].value +					
					  '&veicnpj=' + document.getElementById('veicnpj').value +                  
					  '&veiie=' + document.getElementById('veiie').value +
					  '&veicpf=' + document.getElementById('veicpf').value +
					  '&veirntrc=' + document.getElementById('veirntrc').value +					  
					  '&veitipproprietario=' + document.forms[0].veitipproprietario.options[document.forms[0].veitipproprietario.selectedIndex].value +
					  '&listestados2=' + document.forms[0].listestados2.options[document.forms[0].listestados2.selectedIndex].value +					  
					  '&veirazao=' + document.getElementById('veirazao').value +    
					  '&veiempresa=' + veiculoempresa +    
					  '&usucodigo='+ vusuario +
					  '&veipessoa=' + pessoa;         						  

			new ajax ('infoveiculosinsere.php?' + params , {onLoading: carregando, onComplete: load_grid_vei});
			
	
	}
}

function valida_form(tipo)
{
	var erro = 0;

	
	if($("veicodint").value=="")
	{
		alert("Preencha o campo Codigo Interno");
		$("veicodint").focus();
		erro = 1;
	}
	else if($("veirenavam").value=="")
	{
		alert("Preencha o campo Renavam");
		$("veirenavam").focus();
		erro = 1;
	}
	else if($("veiplaca").value=="")
	{
		alert("Preencha o campo Placa");
		$("veiplaca").focus();
		erro = 1;
	}
	else if(contador==4 || contador>4){
		alert("Atenção, limite máximo de 4 veículos!");		
		erro = 1;
	}
	    
    if(erro==0)
	enviar();
	
}

function limpa_form(tipo)
{
	$("acao").value="inserir";
	$("botao").value="Incluir";
	
	$("veicodigo").value="";
	$("veicod").value="";
	$("veicodint").value="";
	$("veirenavam").value="";
	$("veiplaca").value="";
	$("veitara").value="";
	$("veicapacidadekg").value="";
	$("veicapacidademt").value="";
	
	itemcombo3(1);
	itemcombo4(1);
	itemcombo5(1);
	itemcombo6(1);
	itemcombo7(1);
	itemcombo('AC');

	itemcombo2('AC');

	document.getElementById("radio31").checked=true;
	document.getElementById("radio11").checked=true;
	document.getElementById("radio11").disabled=true;
	document.getElementById("radio12").disabled=true;
	$("veicnpj").disabled = true;
	$("veiie").disabled = true;	
	$("veicpf").value = "";
	$("veicnpj").value = "";
	$("veiie").value = "";	
	$("veicpf").disabled = true;
	$("veirntrc").value = "";
	$("veirntrc").disabled = true;
	document.forms[0].veitipproprietario.disabled=true;
	document.forms[0].listestados2.disabled=true;
	$("veirazao").value = "";
	$("veirazao").disabled = true;

	document.forms[0].listDados.options.length = 1;
	idOpcao  = document.getElementById("opcoes");
	idOpcao.innerHTML = "____________________";		
	
	
	
}

function limpa_form2()
{
	$("acao").value="inserir";
	$("botao").value="Incluir";

	$("veicodigo").value="";
	$("veicod").value="";
	$("veicodint").value="";
	$("veirenavam").value="";
	$("veiplaca").value="";
	$("veitara").value="";
	$("veicapacidadekg").value="";
	$("veicapacidademt").value="";
	
	itemcombo3(1);
	itemcombo4(1);
	itemcombo5(1);
	itemcombo6(1);
	itemcombo7(1);
	itemcombo('AC');	

	itemcombo2('AC');

	document.getElementById("radio31").checked=true;
	document.getElementById("radio11").checked=true;
	document.getElementById("radio11").disabled=true;
	document.getElementById("radio12").disabled=true;
	$("veicnpj").disabled = true;
	$("veiie").disabled = true;	
	$("veicpf").value = "";
	$("veicnpj").value = "";
	$("veiie").value = "";	
	$("veicpf").disabled = true;
	$("veirntrc").value = "";
	$("veirntrc").disabled = true;
	document.forms[0].veitipproprietario.disabled=true;			
	document.forms[0].listestados2.disabled=true;
	$("veirazao").value = "";
	$("veirazao").disabled = true;
	
	

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

		ajax2.open("POST", "veiculosctepesquisa.php", true);
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
				   	idOpcao.innerHTML = "____________________";
				   	alert("Nenhum Registro encontrado!");					
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
		else{
                 valor2 = "3";
        }
        var params = "parametro="+valor+'&parametro2='+valor2;

       // if(valor!="")		
        ajax2.send(params);
		//window.open("clientepesquisa.php?" + params);
	}
}

function dadospesquisa2(valor)
{
	
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
		ajax2.open("POST", "veiculosctepesquisa2.php", true);
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

	    ajax2.open("POST", "veiculosctepesquisa3.php", true);
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
				   	idOpcao.innerHTML = "____________________";
				   	alert("Nenhum Registro encontrado!");					
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
			var descricao1 =  item.getElementsByTagName("descricao1")[0].firstChild.nodeValue;
			var descricao2 =  item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;
			var descricao3 =  item.getElementsByTagName("descricao3")[0].firstChild.nodeValue;
			var descricao4 =  item.getElementsByTagName("descricao4")[0].firstChild.nodeValue;
			var descricao5 =  item.getElementsByTagName("descricao5")[0].firstChild.nodeValue;
			var descricao6 =  item.getElementsByTagName("descricao6")[0].firstChild.nodeValue;
			var descricao7 =  item.getElementsByTagName("descricao7")[0].firstChild.nodeValue;
			var descricao8 =  item.getElementsByTagName("descricao8")[0].firstChild.nodeValue;
			var descricao9 =  item.getElementsByTagName("descricao9")[0].firstChild.nodeValue;
			var descricao10 =  item.getElementsByTagName("descricao10")[0].firstChild.nodeValue;
			var descricao11 =  item.getElementsByTagName("descricao11")[0].firstChild.nodeValue;
			var descricao12 =  item.getElementsByTagName("descricao12")[0].firstChild.nodeValue;
			var descricao13 =  item.getElementsByTagName("descricao13")[0].firstChild.nodeValue;
			var descricao14 =  item.getElementsByTagName("descricao14")[0].firstChild.nodeValue;
			var descricao15 =  item.getElementsByTagName("descricao15")[0].firstChild.nodeValue;
			var descricao16 =  item.getElementsByTagName("descricao16")[0].firstChild.nodeValue;
			var descricao17 =  item.getElementsByTagName("descricao17")[0].firstChild.nodeValue;
			var descricao18 =  item.getElementsByTagName("descricao18")[0].firstChild.nodeValue;
			var descricao19 =  item.getElementsByTagName("descricao19")[0].firstChild.nodeValue;
			var descricao20 =  item.getElementsByTagName("descricao20")[0].firstChild.nodeValue;
			var descricao21 =  item.getElementsByTagName("descricao21")[0].firstChild.nodeValue;
			var descricao22 =  item.getElementsByTagName("descricao22")[0].firstChild.nodeValue;

			trimjs(codigo);codigo = txt;
			
			trimjs(descricao1);descricao1 = txt;
			trimjs(descricao2);descricao2 = txt;
			trimjs(descricao3);descricao3 = txt;
			trimjs(descricao4);descricao4 = txt;
			trimjs(descricao5);descricao5 = txt;
			trimjs(descricao6);descricao6 = txt;
			trimjs(descricao7);descricao7 = txt;
			trimjs(descricao8);descricao8 = txt;
			trimjs(descricao9);descricao9 = txt;
			trimjs(descricao10);descricao10 = txt;
			trimjs(descricao11);descricao11 = txt;
			trimjs(descricao12);descricao12 = txt;

			
			trimjs(descricao13);if (txt=='0'){txt='';};descricao13 = txt;
			trimjs(descricao14);if (txt=='0'){txt='';};descricao14 = txt;
			trimjs(descricao15);if (txt=='0'){txt='';};descricao15 = txt;
			trimjs(descricao16);if (txt=='0'){txt='';};descricao16 = txt;
			trimjs(descricao17);if (txt=='0'){txt='';};descricao17 = txt;
			trimjs(descricao18);if (txt=='0'){txt='';};descricao18 = txt;
			trimjs(descricao19);if (txt=='0'){txt='';};descricao19 = txt;
			trimjs(descricao20);if (txt=='0'){txt='';};descricao20 = txt;
			trimjs(descricao21);if (txt=='0'){txt='';};descricao21 = txt;			
			trimjs(descricao22);if (txt=='0'){txt='';};descricao22 = txt;
			

			// cria um novo option dinamicamente
			var novo = document.createElement("option");
			// atribui um ID a esse elemento
			novo.setAttribute("id", "opcoes");
			// atribui um valor
			novo.value = codigo;
			// atribui um texto
			if ( document.getElementById("radio1").checked==true)
			{
            	novo.text  = descricao1;
            }
			else if ( document.getElementById("radio2").checked==true)
			{
            	novo.text  = descricao2;
            }
			else
			{
            	novo.text  = descricao3;
            }
			
			
			// finalmente adiciona o novo elemento
			document.forms[0].listDados.options.add(novo);

			if(i==0)
			{
               

			   	//$("veicodigo").value=codigo;
				//$("veicod").value=codigo;
				
				$("veicodigo").value='';
				$("veicod").value='';
				
				$("veicodint").value=descricao1;
			   
				$("veirenavam").value=descricao2;
				$("veiplaca").value=descricao3;
				$("veitara").value=descricao4;
				$("veicapacidadekg").value=descricao5;
				$("veicapacidademt").value=descricao6;
				
				
				//$("veitprodado").value=descricao7;
				//$("veitpcarroceria").value=descricao8;
				//$("veitpveiculo").value=descricao9;
				//$("veipropveiculo").value=descricao10;
				
				itemcombo3(descricao7);
				itemcombo4(descricao8);
				itemcombo5(descricao9);
				itemcombo6(descricao10);
				itemcombo7(descricao18);
				
				//$("veiuf").value=descricao11;
				
				
				 itemcombo(descricao11);
				
				//$("veitpdoc").value=descricao12;
				
				
				$("veicpf").value=descricao13;
				$("veicnpj").value=descricao14;
				$("veirntrc").value=descricao15;
				$("veiie").value=descricao16;
			//	$("veipropuf").value=descricao17;
			
				itemcombo2(descricao17);
			
				//$("veitpproprietario").value=descricao18;
				
				
				
				$("veirazao").value=descricao19;
			
				
			    if (descricao20=='1')
				{
					document.getElementById("radio11").checked=true;
					$("veicnpj").disabled = false;
					$("veiie").disabled = false;					
					$("veicpf").value = "";					
					$("veicpf").disabled = true;
				}
				else
				{
					document.getElementById("radio12").checked=true;
					$("veicnpj").disabled = true;
					$("veiie").disabled = true;
					$("veicnpj").value = "";
					$("veiie").value = "";					
					$("veicpf").disabled = false;
				}
				
				document.getElementById("radio11").disabled = false;
				document.getElementById("radio12").disabled = false;

				if(descricao22=='2')
				{		
					document.getElementById("radio32").checked=true;
					$("veirntrc").disabled = false;
					document.forms[0].veitipproprietario.disabled=false;							
					document.forms[0].listestados2.disabled=false;
					$("veirazao").disabled = false;					
				}
				else
				{
					document.getElementById("radio31").checked=true;
					document.getElementById("radio11").checked=true;
					document.getElementById("radio11").disabled=true;
					document.getElementById("radio12").disabled=true;
					$("veicnpj").disabled = true;
					$("veiie").disabled = true;					
					$("veicpf").value = "";
					$("veicnpj").value = "";
					$("veiie").value = "";					
					$("veicpf").disabled = true;
					$("veirntrc").value = "";
					$("veirntrc").disabled = true;					
					document.forms[0].veitipproprietario.disabled=true;		
					document.forms[0].listestados2.disabled=true;
					$("veirazao").value = "";
					$("veirazao").disabled = true;
				}	
				
                $("acao").value="alterar";
				$("botao").value="Alterar";
				
			}
		}		
	}
	else
	{
		// caso o XML volte vazio, printa a mensagem abaixo
		
	

	
	$("veicodigo").value="";
	$("veicod").value="";
	$("veicodint").value="";
	$("veirenavam").value="";
	$("veiplaca").value="";
	$("veitara").value="";
	$("veicapacidadekg").value="";
	$("veicapacidademt").value="";
	
	itemcombo3(1);
	itemcombo4(1);
	itemcombo5(1);
	itemcombo6(1);
	itemcombo7(1);
	itemcombo('AC');
	
	itemcombo2('AC');

	document.getElementById("radio31").checked=true;
	document.getElementById("radio11").checked=true;
	document.getElementById("radio11").disabled=true;
	document.getElementById("radio12").disabled=true;
	$("veicnpj").disabled = true;
	$("veiie").disabled = true;	
	$("veicpf").value = "";
	$("veicnpj").value = "";
	$("veiie").value = "";	
	$("veicpf").disabled = true;
	$("veirntrc").value = "";
	$("veirntrc").disabled = true;	
	document.forms[0].veitipproprietario.disabled=true;		
	document.forms[0].listestados2.disabled=true;
	$("veirazao").value = "";
	$("veirazao").disabled = true;
	
	$("acao").value="inserir";
	$("botao").value="Incluir";	
			
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
			
            
			//trimjs(codigo);        	codigo = txt;
			//trimjs(descricao);if (txt=='0'){txt='';};descricao = txt;
			
			
			
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao1 =  item.getElementsByTagName("descricao1")[0].firstChild.nodeValue;
			var descricao2 =  item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;
			var descricao3 =  item.getElementsByTagName("descricao3")[0].firstChild.nodeValue;
			var descricao4 =  item.getElementsByTagName("descricao4")[0].firstChild.nodeValue;
			var descricao5 =  item.getElementsByTagName("descricao5")[0].firstChild.nodeValue;
			var descricao6 =  item.getElementsByTagName("descricao6")[0].firstChild.nodeValue;
			var descricao7 =  item.getElementsByTagName("descricao7")[0].firstChild.nodeValue;
			var descricao8 =  item.getElementsByTagName("descricao8")[0].firstChild.nodeValue;
			var descricao9 =  item.getElementsByTagName("descricao9")[0].firstChild.nodeValue;
			var descricao10 =  item.getElementsByTagName("descricao10")[0].firstChild.nodeValue;
			var descricao11 =  item.getElementsByTagName("descricao11")[0].firstChild.nodeValue;
			var descricao12 =  item.getElementsByTagName("descricao12")[0].firstChild.nodeValue;
			var descricao13 =  item.getElementsByTagName("descricao13")[0].firstChild.nodeValue;
			var descricao14 =  item.getElementsByTagName("descricao14")[0].firstChild.nodeValue;
			var descricao15 =  item.getElementsByTagName("descricao15")[0].firstChild.nodeValue;
			var descricao16 =  item.getElementsByTagName("descricao16")[0].firstChild.nodeValue;
			var descricao17 =  item.getElementsByTagName("descricao17")[0].firstChild.nodeValue;
			var descricao18 =  item.getElementsByTagName("descricao18")[0].firstChild.nodeValue;
			var descricao19 =  item.getElementsByTagName("descricao19")[0].firstChild.nodeValue;
			var descricao20 =  item.getElementsByTagName("descricao20")[0].firstChild.nodeValue;
			var descricao21 =  item.getElementsByTagName("descricao21")[0].firstChild.nodeValue;
			var descricao22 =  item.getElementsByTagName("descricao22")[0].firstChild.nodeValue;

			trimjs(codigo);codigo = txt;
			
			trimjs(descricao1);descricao1 = txt;
			trimjs(descricao2);descricao2 = txt;
			trimjs(descricao3);descricao3 = txt;
			trimjs(descricao4);descricao4 = txt;
			trimjs(descricao5);descricao5 = txt;
			trimjs(descricao6);descricao6 = txt;
			trimjs(descricao7);descricao7 = txt;
			trimjs(descricao8);descricao8 = txt;
			trimjs(descricao9);descricao9 = txt;
			trimjs(descricao10);descricao10 = txt;
			trimjs(descricao11);descricao11 = txt;
			trimjs(descricao12);descricao12 = txt;
			
			trimjs(descricao13);if (txt=='0'){txt='';};descricao13 = txt;
			trimjs(descricao14);if (txt=='0'){txt='';};descricao14 = txt;
			trimjs(descricao15);if (txt=='0'){txt='';};descricao15 = txt;
			trimjs(descricao16);if (txt=='0'){txt='';};descricao16 = txt;
			trimjs(descricao17);if (txt=='0'){txt='';};descricao17 = txt;
			trimjs(descricao18);if (txt=='0'){txt='';};descricao18 = txt;
			trimjs(descricao19);if (txt=='0'){txt='';};descricao19 = txt;
			trimjs(descricao20);if (txt=='0'){txt='';};descricao20 = txt;
			trimjs(descricao21);if (txt=='0'){txt='';};descricao21 = txt;	
			trimjs(descricao22);if (txt=='0'){txt='';};descricao22 = txt;	
			
		
			//$("veicodigo").value=codigo;
			//$("veicod").value=codigo;
			
			$("veicodigo").value='';
			$("veicod").value='';
			
			$("veicodint").value=descricao1;
			$("veirenavam").value=descricao2;
			$("veiplaca").value=descricao3;
			$("veitara").value=descricao4;
			$("veicapacidadekg").value=descricao5;
			$("veicapacidademt").value=descricao6;
			//$("veitprodado").value=descricao7;
			//$("veitpcarroceria").value=descricao8;
			//$("veitpveiculo").value=descricao9;
			//$("veipropveiculo").value=descricao10;
			//$("veiuf").value=descricao11;
			
			itemcombo3(descricao7);
			itemcombo4(descricao8);
			itemcombo5(descricao9);
			itemcombo6(descricao10);
			itemcombo7(descricao18);
							
			itemcombo(descricao11);
			
			//$("veitpdoc").value=descricao12;
			
			$("veicpf").value=descricao13;
			$("veicnpj").value=descricao14;
			$("veirntrc").value=descricao15;
			$("veiie").value=descricao16;
			//	$("veipropuf").value=descricao17;
		
			itemcombo2(descricao17);
		
			//$("veitpproprietario").value=descricao18;
			$("veirazao").value=descricao19;
		
			
				
			    if (descricao20=='1')
				{
					document.getElementById("radio11").checked=true;
					$("veicnpj").disabled = false;
					$("veiie").disabled = false;					
					$("veicpf").value = "";					
					$("veicpf").disabled = true;
				}
				else
				{
					document.getElementById("radio12").checked=true;
					$("veicnpj").disabled = true;
					$("veiie").disabled = true;
					$("veicnpj").value = "";
					$("veiie").value = "";					
					$("veicpf").disabled = false;
				}
		
				
				document.getElementById("radio11").disabled = false;
				document.getElementById("radio12").disabled = false;		
				
				if(descricao22=='2')
				{					
					document.getElementById("radio32").checked=true;
					$("veirntrc").disabled = false;					
					document.forms[0].veitipproprietario.disabled=false;		
					document.forms[0].listestados2.disabled=false;
					$("veirazao").disabled = false;					
				}
				else
				{
					document.getElementById("radio31").checked=true;
					document.getElementById("radio11").checked=true;
					document.getElementById("radio11").disabled=true;
					document.getElementById("radio12").disabled=true;
					$("veicnpj").disabled = true;
					$("veiie").disabled = true;					
					$("veicpf").value = "";
					$("veicnpj").value = "";
					$("veiie").value = "";					
					$("veicpf").disabled = true;
					$("veirntrc").value = "";
					$("veirntrc").disabled = true;					
					document.forms[0].veitipproprietario.disabled=true;		
					document.forms[0].listestados2.disabled=true;
					$("veirazao").value = "";
					$("veirazao").disabled = true;
				}
			
			
		}		
	}
	else
	{
		// caso o XML volte vazio, printa a mensagem abaixo

	
	$("veicodigo").value="";
	$("veicod").value="";
	$("veicodint").value="";
	$("veirenavam").value="";
	$("veiplaca").value="";
	$("veitara").value="";
	$("veicapacidadekg").value="";
	$("veicapacidademt").value="";
	
	itemcombo3(1);
	itemcombo4(1);
	itemcombo5(1);
	itemcombo6(1);
	itemcombo7(1);
	itemcombo('AC');
	
	itemcombo2('AC');

	document.getElementById("radio31").checked=true;
	document.getElementById("radio11").checked=true;
	document.getElementById("radio11").disabled=true;
	document.getElementById("radio12").disabled=true;
	$("veicnpj").disabled = true;
	$("veiie").disabled = true;	
	$("veicpf").value = "";
	$("veicnpj").value = "";
	$("veiie").value = "";	
	$("veicpf").disabled = true;
	$("veirntrc").value = "";
	$("veirntrc").disabled = true;
	document.forms[0].veitipproprietario.disabled=true;
	document.forms[0].listestados2.disabled=true;
	$("veirazao").value = "";
	$("veirazao").disabled = true;
		
	$("acao").value="inserir";
	$("botao").value="Incluir";			
	
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
			var descricao1 =  item.getElementsByTagName("descricao1")[0].firstChild.nodeValue;
			var descricao2 =  item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;
			var descricao3 =  item.getElementsByTagName("descricao3")[0].firstChild.nodeValue;
			var descricao4 =  item.getElementsByTagName("descricao4")[0].firstChild.nodeValue;
			var descricao5 =  item.getElementsByTagName("descricao5")[0].firstChild.nodeValue;
			var descricao6 =  item.getElementsByTagName("descricao6")[0].firstChild.nodeValue;
			var descricao7 =  item.getElementsByTagName("descricao7")[0].firstChild.nodeValue;
			var descricao8 =  item.getElementsByTagName("descricao8")[0].firstChild.nodeValue;
			var descricao9 =  item.getElementsByTagName("descricao9")[0].firstChild.nodeValue;
			var descricao10 =  item.getElementsByTagName("descricao10")[0].firstChild.nodeValue;
			var descricao11 =  item.getElementsByTagName("descricao11")[0].firstChild.nodeValue;
			var descricao12 =  item.getElementsByTagName("descricao12")[0].firstChild.nodeValue;
			var descricao13 =  item.getElementsByTagName("descricao13")[0].firstChild.nodeValue;
			var descricao14 =  item.getElementsByTagName("descricao14")[0].firstChild.nodeValue;
			var descricao15 =  item.getElementsByTagName("descricao15")[0].firstChild.nodeValue;
			var descricao16 =  item.getElementsByTagName("descricao16")[0].firstChild.nodeValue;
			var descricao17 =  item.getElementsByTagName("descricao17")[0].firstChild.nodeValue;
			var descricao18 =  item.getElementsByTagName("descricao18")[0].firstChild.nodeValue;
			var descricao19 =  item.getElementsByTagName("descricao19")[0].firstChild.nodeValue;
			var descricao20 =  item.getElementsByTagName("descricao20")[0].firstChild.nodeValue;
			var descricao21 =  item.getElementsByTagName("descricao21")[0].firstChild.nodeValue;
			var descricao22 =  item.getElementsByTagName("descricao22")[0].firstChild.nodeValue;

			trimjs(codigo);codigo = txt;
			
			trimjs(descricao1);descricao1 = txt;
			trimjs(descricao2);descricao2 = txt;
			trimjs(descricao3);descricao3 = txt;
			trimjs(descricao4);descricao4 = txt;
			trimjs(descricao5);descricao5 = txt;
			trimjs(descricao6);descricao6 = txt;
			trimjs(descricao7);descricao7 = txt;
			trimjs(descricao8);descricao8 = txt;
			trimjs(descricao9);descricao9 = txt;
			trimjs(descricao10);descricao10 = txt;
			trimjs(descricao11);descricao11 = txt;
			trimjs(descricao12);descricao12 = txt;
			
			trimjs(descricao13);if (txt=='0'){txt='';};descricao13 = txt;
			trimjs(descricao14);if (txt=='0'){txt='';};descricao14 = txt;
			trimjs(descricao15);if (txt=='0'){txt='';};descricao15 = txt;
			trimjs(descricao16);if (txt=='0'){txt='';};descricao16 = txt;
			trimjs(descricao17);if (txt=='0'){txt='';};descricao17 = txt;
			trimjs(descricao18);if (txt=='0'){txt='';};descricao18 = txt;
			trimjs(descricao19);if (txt=='0'){txt='';};descricao19 = txt;
			trimjs(descricao20);if (txt=='0'){txt='';};descricao20 = txt;
			trimjs(descricao21);if (txt=='0'){txt='';};descricao21 = txt;
			trimjs(descricao22);if (txt=='0'){txt='';};descricao22 = txt;
						

			// cria um novo option dinamicamente
			var novo = document.createElement("option");
			// atribui um ID a esse elemento
			novo.setAttribute("id", "opcoes");
			// atribui um valor
			novo.value = codigo;
			// atribui um texto
			if ( document.getElementById("radio1").checked==true)
			{
            	novo.text  = descricao1;
            }
			else if ( document.getElementById("radio2").checked==true)
			{
            	novo.text  = descricao2;
            }
			else
			{
            	novo.text  = descricao3;
            }
    		
			// finalmente adiciona o novo elemento
			document.forms[0].listDados.options.add(novo);

			if(i==0)
			{
				//$("veicodigo").value=codigo;
				//$("acao").value="alterar";
				//$("botao").value="Alterar";
			}
		}		
	}
	else
	{
	    // caso o XML volte vazio, printa a mensagem abaixo
		//$("forcodigo").value="";
		
		$("acao").value="inserir";
		$("botao").value="Incluir";
		idOpcao  = document.getElementById("opcoes");
		idOpcao.innerHTML = "____________________";				
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
		ajax2.open("POST", "clientecodpesquisa.php", true);
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
		$("veicnpj").disabled = false;
		$("veiie").disabled = false;		
		$("veicpf").value = "";		
		$("veicpf").disabled = true;
	}
	else
	{
		$("veicnpj").disabled = true;
		$("veiie").disabled = true;
		$("veicnpj").value = "";
		$("veiie").value = "";		
		$("veicpf").disabled = false;
	}
}


function verificaveiculo(valor)
{
	if( document.getElementById("radio31").checked==true)
	{
		document.getElementById("radio11").checked=true;
		document.getElementById("radio11").disabled=true;
		document.getElementById("radio12").disabled=true;
		$("veicnpj").disabled = true;
		$("veiie").disabled = true;		
		$("veicpf").value = "";
		$("veicnpj").value = "";
		$("veiie").value = "";		
		$("veicpf").disabled = true;
		$("veirntrc").value = "";
		$("veirntrc").disabled = true;		
		document.forms[0].veitipproprietario.disabled=true;		
		document.forms[0].listestados2.disabled=true;
		$("veirazao").value = "";
		$("veirazao").disabled = true;
	}
	else
	{
		document.getElementById("radio11").checked=true;
		document.getElementById("radio11").disabled=false;
		document.getElementById("radio12").disabled=false;
		$("veicnpj").disabled = false;
		$("veiie").disabled = false;		
		$("veicpf").value = "";				
		$("veicpf").disabled = true;		
		$("veirntrc").disabled = false;		
		document.forms[0].veitipproprietario.disabled=false;		
		document.forms[0].listestados2.disabled=false;
		$("veirazao").disabled = false;		
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
	
    if (evt <20 || evt == 44 || evt == 45|| evt == 46 || (evt >47 && evt<58)){return true;} 
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

	//valor = document.getElementById('veicodint').value;

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
			var veicod    =  item.getElementsByTagName("veicod")[0].firstChild.nodeValue;
		
			trimjs(veicod);veicod = txt;
			
			dadospesquisa3(veicod);
			
			$("veicod").value=veicod;
			
			alert("Registro incluído com sucesso!");
			//alert("Registro incluído com sucesso!\nCom o número: "+veicod);			
		}
		
	}
	else
	{
	    // caso o XML volte vazio, printa a mensagem abaixo
	}
}





function dadospesquisaestado(valor) {


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
		 document.forms[0].listestados.options.length = 1;
	     
		 idOpcao  = document.getElementById("opcoes2");
		 
	     ajax2.open("POST", "veiculospesquisaestado.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		 
		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";   
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXMLestado(ajax2.responseXML);
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



   function processXMLestado(obj){
   
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");
      
	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados

	document.forms[0].listestados.options.length = 0;	

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
			    novo.setAttribute("id", "opcoes2");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].listestados.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcao.innerHTML = "____________________";

	  }

	  dadospesquisaestado2(0);
		
   }



function itemcombo(valor){

	y = document.forms[0].listestados.options.length;

	for(var i = 0 ; i < y ; i++) {
	
	    document.forms[0].listestados.options[i].selected = true;
		var l = document.forms[0].listestados;
		//var li = l.options[l.selectedIndex].text;
  		var li = l.options[l.selectedIndex].value;
		if(li==valor){
			i=y;
		}
			
	}
}	



function dadospesquisaestado2(valor) {


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
		 document.forms[0].listestados2.options.length = 1;
	     
		 idOpcao  = document.getElementById("opcoes2");
		 
	     ajax2.open("POST", "veiculospesquisaestado.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		 
		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";   
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXMLestado2(ajax2.responseXML);
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



   function processXMLestado2(obj){
   
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");
      
	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados

	document.forms[0].listestados2.options.length = 0;	

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
			    novo.setAttribute("id", "opcoes2");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].listestados2.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcao.innerHTML = "____________________";

	  }	  
	  
		//dadospesquisarodado(0);
		new ajax ('infoveiculoseleciona.php?usucodigo='+ vusuario , {onComplete: imprime_vei});
	
	  
   }



function itemcombo2(valor){

	y = document.forms[0].listestados2.options.length;

	for(var i = 0 ; i < y ; i++) {
	
	    document.forms[0].listestados2.options[i].selected = true;
		var l = document.forms[0].listestados2
		//var li = l.options[l.selectedIndex].text;
  		var li = l.options[l.selectedIndex].value;
		if(li==valor){
			i=y;
		}
			
	}
}	




function dadospesquisarodado(valor) {

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
		 document.forms[0].veitiporodado.options.length = 1;
	     
		 idOpcao  = document.getElementById("opcoes2");
		 
	     ajax2.open("POST", "veiculospesquisarodado.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		 
		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";   
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXMLrodado(ajax2.responseXML);
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



   function processXMLrodado(obj){

   
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");
      
	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados

		document.forms[0].veitiporodado.options.length = 0;	

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
			    novo.setAttribute("id", "opcoes2");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].veitiporodado.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcao.innerHTML = "____________________";

	  }	  
	  
	  dadospesquisacarroceria(0);
   }


function dadospesquisacarroceria(valor) {

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
		 document.forms[0].veitipocarroceria.options.length = 1;
	     
		 idOpcao  = document.getElementById("opcoes2");
		 
	     ajax2.open("POST", "veiculospesquisacarroceria.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		 
		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";   
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXMLcarroceria(ajax2.responseXML);
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



   function processXMLcarroceria(obj){

   
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");
      
	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados

		document.forms[0].veitipocarroceria.options.length = 0;	

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
			    novo.setAttribute("id", "opcoes2");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].veitipocarroceria.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcao.innerHTML = "____________________";

	  }	  
	  
	  dadospesquisaveiculo(0);
   }




function dadospesquisaveiculo(valor) {

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
		 document.forms[0].veitipoveiculo.options.length = 1;
	     
		 idOpcao  = document.getElementById("opcoes2");
		 
	     ajax2.open("POST", "veiculospesquisaveiculo.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		 
		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";   
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXMLveiculo(ajax2.responseXML);
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



   function processXMLveiculo(obj){

   
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");
      
	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados

		document.forms[0].veitipoveiculo.options.length = 0;	

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
			    novo.setAttribute("id", "opcoes2");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].veitipoveiculo.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcao.innerHTML = "____________________";

	  }	  
	  
	  dadospesquisapropveiculo(0);
   }

   

function dadospesquisapropveiculo(valor) {

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
		 document.forms[0].veitipopropveiculo.options.length = 1;
	     
		 idOpcao  = document.getElementById("opcoes2");
		 
	     ajax2.open("POST", "veiculospesquisapropveiculo.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		 
		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";   
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXMLpropveiculo(ajax2.responseXML);
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



   function processXMLpropveiculo(obj){

   
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");
      
	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados

		document.forms[0].veitipopropveiculo.options.length = 0;	

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
			    novo.setAttribute("id", "opcoes2");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].veitipopropveiculo.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcao.innerHTML = "____________________";

	  }	  
	  
	  dadospesquisaproprietario(0);
   }
   
   
   
   function dadospesquisaproprietario(valor) {

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
		 document.forms[0].veitipproprietario.options.length = 1;
	     
		 idOpcao  = document.getElementById("opcoes2");
		 
	     ajax2.open("POST", "veiculospesquisaproprietario.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		 
		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";   
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			      processXMLproprietario(ajax2.responseXML);
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



   function processXMLproprietario(obj){

   
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");
      
	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados

		document.forms[0].veitipproprietario.options.length = 0;	

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
			    novo.setAttribute("id", "opcoes2");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].veitipproprietario.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcao.innerHTML = "____________________";

	  }	  
	  
	  dadospesquisaestado(0);
	  
   }
   
   

function itemcombo3(valor){

	y = document.forms[0].veitiporodado.options.length;

	for(var i = 0 ; i < y ; i++) {
	
	    document.forms[0].veitiporodado.options[i].selected = true;
		var l = document.forms[0].veitiporodado
		//var li = l.options[l.selectedIndex].text;
  		var li = l.options[l.selectedIndex].value;
		if(li==valor){
			i=y;
		}
			
	}
}	
   

function itemcombo4(valor){

	y = document.forms[0].veitipocarroceria.options.length;

	for(var i = 0 ; i < y ; i++) {
	
	    document.forms[0].veitipocarroceria.options[i].selected = true;
		var l = document.forms[0].veitipocarroceria
		//var li = l.options[l.selectedIndex].text;
  		var li = l.options[l.selectedIndex].value;
		if(li==valor){
			i=y;
		}
			
	}
}	   
   
   
function itemcombo5(valor){

	y = document.forms[0].veitipoveiculo.options.length;

	for(var i = 0 ; i < y ; i++) {
	
	    document.forms[0].veitipoveiculo.options[i].selected = true;
		var l = document.forms[0].veitipoveiculo
		//var li = l.options[l.selectedIndex].text;
  		var li = l.options[l.selectedIndex].value;
		if(li==valor){
			i=y;
		}
			
	}
}	     


   
function itemcombo6(valor){

	y = document.forms[0].veitipopropveiculo.options.length;

	for(var i = 0 ; i < y ; i++) {
	
	    document.forms[0].veitipopropveiculo.options[i].selected = true;
		var l = document.forms[0].veitipopropveiculo
		//var li = l.options[l.selectedIndex].text;
  		var li = l.options[l.selectedIndex].value;
		if(li==valor){
			i=y;
		}
			
	}
}	     


function itemcombo7(valor){

	y = document.forms[0].veitipproprietario.options.length;

	for(var i = 0 ; i < y ; i++) {
	
	    document.forms[0].veitipproprietario.options[i].selected = true;
		var l = document.forms[0].veitipproprietario
		//var li = l.options[l.selectedIndex].text;
  		var li = l.options[l.selectedIndex].value;
		if(li==valor){
			i=y;
		}
			
	}
}	    

