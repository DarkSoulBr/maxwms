// JavaScript Document  
function load_grupo()
{
	new ajax('cadastroconsultagruposrelprodutos.php', {onComplete: imprime_grupo});
}

function imprime_grupo(request)
{
	var xmldoc=request.responseXML;

   	var dados = xmldoc.getElementsByTagName('dados')[0];

   	var contador = '0';
	var tabela="<span class=\"custom-dropdown\"><select id=\"grupo\" name=\"grupo\" multiple style=\"height:150px;width:300px;\" onkeypress=\"insertBeforeSelected('grupo',event,'grupo_selecionados')\">";
	//tabela+='<option value="0">-- Escolha um Grupo --</option>';

    if(dados!=null)
	{
        //corpo da tabela
		var registros = xmldoc.getElementsByTagName('registro');
		//alert(registros.length);
		for(i=0;i<registros.length;i++)
		{
			var itens = registros[i].getElementsByTagName('item');
			tabela+='<option value="'+itens[0].firstChild.data+'">'+itens[0].firstChild.data+' - '+itens[1].firstChild.data+'</option>\n"';
		}
	}
    tabela+="</select>"
	$("resultado2").innerHTML=tabela;
	tabela="";
}

//-----------------------------------------------
function load_subgrupo()
{
	new ajax('cadastroconsultasubgruprodutos.php', {onComplete: imprime_subgrupo});
}

function imprime_subgrupo(request)
{
	var xmldoc=request.responseXML;

   	var dados = xmldoc.getElementsByTagName('dados')[0];

   	var contador = '0';
	var tabela="<select id=\"subgrupo\" name=\"subgrupo\" multiple style=\"height:150px;width:300px;\" onkeypress=\"insertBeforeSelected(subgrupo,event,'subgrupo_selecionados')\">";

    if(dados!=null)
	{
        //corpo da tabela
		var registros = xmldoc.getElementsByTagName('registro');
		//alert(registros.length);
		for(i=0;i<registros.length;i++)
		{
			var itens = registros[i].getElementsByTagName('item');
			tabela+='<option value="'+itens[0].firstChild.data+'">'+itens[0].firstChild.data+' - '+itens[1].firstChild.data+'</option>\n"';
		}
	}
    tabela+="</select>"
	$("resultado3").innerHTML=tabela;
	tabela="";
}
//-----------------------------------------------

//-------------- Fornecedor ---------------------//
function load_grid_fornecedor(){
	var opcaosetada = 0;
	
	if(document.getElementById('opcao1').checked == true)
	opcaosetada = 1;

	if(document.getElementById('opcao2').checked == true)
	opcaosetada = 2;
	
	if(document.getElementById('opcao3').checked == true)
	opcaosetada = 3;

	var strfornecedor = document.getElementById('consulta').value;

	document.getElementById('pesquisa').disabled = false;
	document.getElementById('nome').disabled = false;
	
    new ajax ('cadastroconsultafornecedor2.php?opcao='+opcaosetada+'&consultafornecedor='+strfornecedor, {onLoading: carregando_fornecedor, onComplete: imprime_fornecedor});
}

function carregando_fornecedor(){
	//$("msg5").style.visibility="visible";
	//$("msg5").innerHTML="Processando...";
}

function imprime_fornecedor(request){

	//$("msg5").style.visibility="hidden";
	var xmldoc=request.responseXML;

    var dados = xmldoc.getElementsByTagName('dados')[0];

    var contador = '0';
	var tabela='<span class=\"custom-dropdown\"><select id="pesquisa" name="pesquisa" multiple style="height:150px;width:290px;" onkeypress="insertBeforeSelected(pesquisa,event,\'fornecedor_selecionados\');">';
	//tabela+="<option value=\"0\">-- Escolha um Fornecedor --</option>";
	
    if(dados!=null)
	{
        //corpo da tabela
		var registros = xmldoc.getElementsByTagName('registro');
		//alert(registros.length);
		for(i=0;i<registros.length;i++)
		{
                  
			var itens = registros[i].getElementsByTagName('item');
			//for(j=0;j<itens.length;j++)
			//{
				if(itens[0].firstChild!=null)
				{
               		tabela+='<option value="'+itens[0].firstChild.data+'">'+itens[0].firstChild.data+' '+itens[1].firstChild.data+'</option>\n"';
                }
            //}
		}

	}
    tabela+="</select>"
	$("resultado5").innerHTML=tabela;
    //alert(tabela);
}
//-----------------------------------------------

function load_grid()
{
	var tamanho = document.getElementById("grupo_selecionados").length;
	var i = 0; var grupo = "&grupo=";

	for(i=0;i<tamanho;i++)
	{
		grupo += document.getElementById("grupo_selecionados").options[i].value+';';
	}
	
	var tamanho = document.getElementById("subgrupo_selecionados").length;
	var i = 0; var subgrupo = "&subgrupo=";

	for(i=0;i<tamanho;i++)
	{
		subgrupo += document.getElementById("subgrupo_selecionados").options[i].value+';';
	}
	
	var tamanho = document.getElementById("fornecedor_selecionados").length;
	var i = 0; var fornecedor = "&fornecedor=";

	for(i=0;i<tamanho;i++)
	{
		fornecedor += document.getElementById("fornecedor_selecionados").options[i].value+';';
	}

	var estoque = document.getElementById("estoque").value;

	window.open('relatoriogeragerenderecos.php?estoque='+estoque+grupo+subgrupo+fornecedor, 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');
}

function carregando()
{
	$("msg").style.visibility="visible";
	$("msg").innerHTML="Processando...";
}

function imprime(request)
{
	$("msg").style.visibility="hidden";
	var xmldoc=request.responseXML;
    var dados = xmldoc.getElementsByTagName('dadosinv')[0];
	var registros = xmldoc.getElementsByTagName('registroinv');
	var itens = registros[0].getElementsByTagName('iteminv');

	if(itens[0].firstChild.data=="11")
	{
		tabela="Erro! Nenhum produto existente para este Grupo!";
		alert(tabela);
	}

	if(itens[0].firstChild.data=="22")
	{
		tabela="Erro! Nenhum produto existente para este SubGrupo!";
		alert(tabela);
	}
	
	if(itens[0].firstChild.data=="33")
	{
		tabela="Erro! Nenhum produto existente para este Fornecedor!";
		alert(tabela);
	}

	if(document.getElementById("lin1").style.display=="")
	addgrupo();

	if(document.getElementById("lin2").style.display=="")
	addsubgrupo();

	$("resultado").innerHTML=tabela;
	tabela="";
}

function load_grid_estoque(){
      new ajax ('cadastroconsultacontagem.php', {onComplete: imprime_estoque});
}

function imprime_estoque(request)
{
	var xmldoc=request.responseXML;
  	var dados = xmldoc.getElementsByTagName('dados')[0];

  	var tabelax="<span class=\"custom-dropdown\"><select id=\"estoque\" name=\"estoque\" size=\"1\"><option value=\"0\">-- Escolha uma Contagem --</option>";

    if(dados!=null)
	{
		contador = '0';

        //corpo da tabela
		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++)
		{
			var itens = registros[i].getElementsByTagName('item');
			for(j=0;j<itens.length;j++)
			{
				if(itens[j].firstChild!=null)
				{
					if(contador=='0')
					{
                		tabelax+="<option value='"+itens[j].firstChild.data+"'>";
                		contador++;
					}
					else
					{
						tabelax+=itens[j].firstChild.data+"</option>";
						contador='0';
					}
                }
                else
                {
                   tabelax+="";
                }
            }
		}
	}
	$("resultado4").innerHTML=tabelax;
	tabelax="";
	
	load_grid_estoque2();
	
}


function load_grid_estoque2(){
      new ajax ('cadastroconsultaestoque.php', {onComplete: imprime_estoque2});
}

function imprime_estoque2(request)
{
	var xmldoc=request.responseXML;
  	var dados = xmldoc.getElementsByTagName('dados')[0];

  	var tabelax="<span class=\"custom-dropdown\"><select id=\"estoque2\" name=\"estoque2\" size=\"1\"><option value=\"0\">-- Escolha um Estoque --</option>";

    if(dados!=null)
	{
		contador = '0';

        //corpo da tabela
		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++)
		{
			var itens = registros[i].getElementsByTagName('item');
			for(j=0;j<itens.length;j++)
			{
				if(itens[j].firstChild!=null)
				{
					if(contador=='0')
					{
                		tabelax+="<option value='"+itens[j].firstChild.data+"'>";
                		contador++;
					}
					else
					{
						tabelax+=itens[j].firstChild.data+"</option>";
						contador='0';
					}
                }
                else
                {
                   tabelax+="";
                }
            }
		}
	}
	$("resultado4x").innerHTML=tabelax;
	tabelax="";
	
	load_grid_estoque3();
}

function load_grid_estoque3(){
      new ajax ('cadastroconsultacontagem.php', {onComplete: imprime_estoque3});
}

function imprime_estoque3(request)
{
	var xmldoc=request.responseXML;
  	var dados = xmldoc.getElementsByTagName('dados')[0];

  	var tabelax="<span class=\"custom-dropdown\"><select id=\"estoque3\" name=\"estoque3\" size=\"1\"><option value=\"0\">-- Escolha uma Contagem --</option>";

    if(dados!=null)
	{
		contador = '0';

        //corpo da tabela
		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++)
		{
			var itens = registros[i].getElementsByTagName('item');
			for(j=0;j<itens.length;j++)
			{
				if(itens[j].firstChild!=null)
				{
					if(contador=='0')
					{
                		tabelax+="<option value='"+itens[j].firstChild.data+"'>";
                		contador++;
					}
					else
					{
						tabelax+=itens[j].firstChild.data+"</option>";
						contador='0';
					}
                }
                else
                {
                   tabelax+="";
                }
            }
		}
	}
	$("resultado4w").innerHTML=tabelax;
	tabelax="";
	
	load_grid_estoque4();
}

function load_grid_estoque4(){
      new ajax ('cadastroconsultacontagem.php', {onComplete: imprime_estoque4});
}

function imprime_estoque4(request)
{
	var xmldoc=request.responseXML;
  	var dados = xmldoc.getElementsByTagName('dados')[0];

  	var tabelax="<span class=\"custom-dropdown\"><select id=\"estoque4\" name=\"estoque4\" size=\"1\"><option value=\"0\">-- Escolha uma Contagem --</option>";

    if(dados!=null)
	{
		contador = '0';

        //corpo da tabela
		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++)
		{
			var itens = registros[i].getElementsByTagName('item');
			for(j=0;j<itens.length;j++)
			{
				if(itens[j].firstChild!=null)
				{
					if(contador=='0')
					{
                		tabelax+="<option value='"+itens[j].firstChild.data+"'>";
                		contador++;
					}
					else
					{
						tabelax+=itens[j].firstChild.data+"</option>";
						contador='0';
					}
                }
                else
                {
                   tabelax+="";
                }
            }
		}
	}
	$("resultado4z").innerHTML=tabelax;
	tabelax="";
	
}

//------------ Teste do Enter nos combos --------------------------//
function insertBeforeSelected(obj,objEvent,campo)
{
	if(objEvent.keyCode==13 || objEvent==13)
	{
		//contéudo do item selecionado
		//var codigo    	= obj.options[obj.selectedIndex].value;
		//var descricao 	= obj.options[obj.selectedIndex].text;
		var codigo			= document.getElementById(""+obj).options[document.getElementById(""+obj).selectedIndex].value;
		var descricao		= document.getElementById(""+obj).options[document.getElementById(""+obj).selectedIndex].text;

		//alert("teste: "+document.getElementById(campo).length);

		var valorselecionado = '';
		var existe = 0;
		var tamanho = document.getElementById(campo).length;
		var i = 0;
		for(i=0;i<tamanho;i++)
		{
			var valorselecionado = document.getElementById(campo).options[i].value;

			if(codigo==valorselecionado)
			existe++;
		}

		if(existe==0)
		{
			//cria um novo option dinamicamente
			var novo = document.createElement("option");

			//atribui um ID a esse elemento
		    novo.setAttribute("id", campo);
		    
		    novo.setAttribute("selected", "selected");

		    //atribui um valor
		    novo.value = codigo;

		    //atribui um texto
		    novo.text  = descricao;

		    //finalmente adiciona o novo elemento
			document.getElementById(campo).options.add(novo);
		}
		else
		{
			alert("Item já Selecionado!");
		}
	}
}

function removeOption(objEvent,campo)
{
    if(objEvent.keyCode==13 || objEvent.keyCode==46  || objEvent==46)
	{
    	document.getElementById(""+campo).remove(document.getElementById(""+campo).selectedIndex);
	}
	selecionarTodos(campo);
}

function selecionarTodos(campo)
{
	var tamanho = document.getElementById(campo).length;
	var i = 0;
	for(i=0;i<tamanho;i++)
	{
		document.getElementById(campo).options[i].selected=true;
	}
}

function relatorioexexel(){

	selecionarTodos("grupo_selecionados");
	selecionarTodos("subgrupo_selecionados");
	$("resultado").innerHTML="";

	var grupo_selecionados 		= document.getElementById("grupo_selecionados").value;
	var subgrupo_selecionados 	= document.getElementById("subgrupo_selecionados").value;
	var fornecedor_selecionados	= document.getElementById("fornecedor_selecionados").value;
	var estoque 				= document.getElementById('estoque').value;

	var erro = 0;

	if(grupo_selecionados=="" && subgrupo_selecionados=="" && fornecedor_selecionados=="")
	{
		alert("Favor escolher ao menos um item para gerar o relatório!");
		document.getElementById('grupo_selecionados').focus();
		erro = 1;
	}
	else
		if(estoque=="" || estoque=="0")
		{
			alert("Selecione um Estoque!");
			document.getElementById('estoque').focus();
			erro = 1;
		}

	if(erro=='0')
	load_grid();
}

function imprelatorioexexcel(){

	var contagem = document.getElementById("estoque").value;
	var estoque = document.getElementById("estoque2").value;
	var contagem2 = document.getElementById("estoque3").value;
	var contagem3 = document.getElementById("estoque4").value;
	var invdata = document.getElementById("pvemissao").value;
	var invdata2 = document.getElementById("pvemissao2").value;
	
	if(invdata==''){
		alert( 'Nenhuma contagem em aberto !');
	}
	else if(contagem==0 || contagem==''){
		alert( 'Selecione a contagem1 !');
	}
	else if(contagem2==0 || contagem2==''){
		alert( 'Selecione a contagem2 !');
	}
	else if(contagem3==0 || contagem3==''){
		alert( 'Selecione a contagem3 !');
	}
	else if(estoque==0 || estoque==''){
		alert( 'Selecione o estoque !');
	}
	else if(invdata2==''){
		alert( 'Informe a data do Inventário !');
	}
	else {
	
		/*
		window.open('finalizageracontagem.php?invdata='+invdata
				+ '&contagem=' + contagem 
				+ '&contagem2=' + contagem2 
				+ '&contagem3=' + contagem3 
				+ '&invdata2=' + invdata2 
				+ '&estoque=' + estoque 
				, '_blank');
		*/
		
		
		document.getElementById("botao").disabled = true;
		
		new ajax('finalizageracontagem.php?invdata='+invdata
				+ '&contagem=' + contagem 
				+ '&contagem2=' + contagem2 
				+ '&contagem3=' + contagem3 
				+ '&invdata2=' + invdata2 
				+ '&estoque=' + estoque 
				, {onLoading: carregandosetor, onComplete: imprimesetorencerra});
		
		
	}	
}

function carregandosetor()
{
	$("msg").style.visibility="visible";
	$("msg").innerHTML="Processando...";
}

function imprimesetorencerra(request)
{

	document.getElementById("botao").disabled = false;

	$("msg").style.visibility="hidden";
	var xmldoc=request.responseXML;
    var dados = xmldoc.getElementsByTagName('dadosinv')[0];
	var registros = xmldoc.getElementsByTagName('registroinv');
	var itens = registros[0].getElementsByTagName('iteminv');

	tabela="Contagem transferida para o Inventário!";	
	alert( tabela );
	tabela="";	
	
	$("resultado").innerHTML="";
  		
}

function formata_data(obj)
{
	obj.value = obj.value.replace( "//", "/" );
	tam = obj.value;
	
	if (tam.length == 2 || tam.length == 5)
		obj.value = obj.value + "/";
}

function formata_data2(documento,data)
{
    var ano = parseInt(data.substring(6,10),10);
    var mydate = new Date();
    var year= mydate.getFullYear();

    if (validar_data(data.substring(0,5)+'/'+year))
    {
    	if (isNaN(ano)==false)
    	{
       		if (ano<2000)
       		{
          		if (ano>1899)
          		{
             		documento.value = data.substring(0,5)+'/'+ano;
          		}
          		else
          		{
          			ano=ano+2000;
          			documento.value = data.substring(0,6)+ano;
          		}
			}
		}
    	else
    	{
			documento.value = data.substring(0,5)+'/'+year;
    	}
	}
}

function setar(obj)
{
	document.getElementById('nome').value = obj.value;
}

function addgrupo()
{
	if(document.getElementById("lin1").style.display=="none")
	{
		document.getElementById("lin1").style.display="";
		document.getElementById("lin2").style.display="none";
		document.getElementById("lin3").style.display="none";
	}
	else
	{
		document.getElementById("lin1").style.display="none";
		document.getElementById("lin2").style.display="none";
		document.getElementById("lin3").style.display="none";
	}
	limparforms();
}

function addsubgrupo()
{
	if(document.getElementById("lin2").style.display=="none")
	{
		document.getElementById("lin1").style.display="none";
		document.getElementById("lin2").style.display="";
		document.getElementById("lin3").style.display="none";
	}
	else
	{
		document.getElementById("lin1").style.display="none";
		document.getElementById("lin2").style.display="none";
		document.getElementById("lin3").style.display="none";
	}
	limparforms();
}

function addfornecedor()
{
	if(document.getElementById("lin3").style.display=="none")
	{
		document.getElementById("lin1").style.display="none";
		document.getElementById("lin2").style.display="none";
		document.getElementById("lin3").style.display="";
	}
	else
	{
		document.getElementById("lin1").style.display="none";
		document.getElementById("lin2").style.display="none";
		document.getElementById("lin3").style.display="none";
	}
	limparforms();
}

function limparforms()
{
	//Limpa grupos
	var tamanho = document.getElementById("grupo_selecionados").length;
	for(i=0;i<tamanho;i++)
	{
		document.getElementById("grupo_selecionados").remove(document.getElementById("subgrupo_selecionados").options[i]);
	}
	document.getElementById("grupo_selecionados").value="";

	//Limpa subgrupos
	var tamanho = document.getElementById("subgrupo_selecionados").length;
	for(i=0;i<tamanho;i++)
	{
		//document.getElementById("subgrupo_selecionados").options[i].value="";
		document.getElementById("subgrupo_selecionados").remove(document.getElementById("subgrupo_selecionados").options[i]);
	}
	document.getElementById("subgrupo_selecionados").value="";

	//Limpa fornecedor
	var tamanho = document.getElementById("fornecedor_selecionados").length;
	for(i=0;i<tamanho;i++)
	{
		document.getElementById("fornecedor_selecionados").remove(document.getElementById("fornecedor_selecionados").options[i]);
	}
	document.getElementById("fornecedor_selecionados").value="";

	//Limpa Fornecedor
	document.getElementById("nome").value="";
	//document.getElementById("pesquisa").value="0";
}

function dadospesquisadata(valor) {
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
			      processXMLdata(ajax2.responseXML);
			   }
			   else {
					$("pvemissao").value='';					
					$("pvemissao2").value='';					
			   }
            }
         }
		 //passa o parametro
        var params = "parametro="+valor;
         ajax2.send(params);
      }

   }


   function processXMLdata(obj){


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
			$("pvemissao2").value=pvemissao;
			
			if(pvemissao==''){
				alert("Nenhuma Contagem em Andamento!");
			}
			else {			
			
				//Pesquisa as Contagens
				load_grid_estoque();
				
			}	


		 }
	  }
	  


   }
