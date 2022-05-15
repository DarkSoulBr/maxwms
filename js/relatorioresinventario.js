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
	var tabela="<span class=\"custom-dropdown-multiple\"><select id=\"grupo\" name=\"grupo\" multiple style=\"height:150px;width:300px;\" onkeypress=\"insertBeforeSelected(this,event,'grupo_selecionados')\">";
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
    tabela+="</select></span>"
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
	var tabela="<span class=\"custom-dropdown-multiple\"><select id=\"subgrupo\" name=\"subgrupo\" multiple style=\"height:150px;width:300px;\" onkeypress=\"insertBeforeSelected(this,event,'subgrupo_selecionados')\">";

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
    tabela+="</select></span>"
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
	$("msg5").style.visibility="visible";
	$("msg5").innerHTML="Processando...";
}

function imprime_fornecedor(request){

	$("msg5").style.visibility="hidden";
	var xmldoc=request.responseXML;

    var dados = xmldoc.getElementsByTagName('dados')[0];

    var contador = '0';
	var tabela='<span class="custom-dropdown"><select id="pesquisa" name="pesquisa" size="1" onchange="setar(this);">';
	tabela+="<option value=\"0\">-- Escolha um Fornecedor --</option>";
	
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
    tabela+="</select></span>"
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

	var nome = document.getElementById("nome").value;
	var estoque = document.getElementById("estoque").value;
	var invdata = document.getElementById("datainventario").value;

	window.open('relatoriogeraresinventario.php?estoque='+estoque+grupo+subgrupo+'&nome='+nome+'&invdata='+invdata, 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');
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
      new ajax ('cadastroconsultaestoque.php', {onComplete: imprime_estoque});
}

function imprime_estoque(request)
{
	var xmldoc=request.responseXML;
  	var dados = xmldoc.getElementsByTagName('dados')[0];

  	var tabelax="<span class=\"custom-dropdown\"><select id=\"estoque\" name=\"estoque\" size=\"1\"><option value=\"0\">-- Escolha um Estoque --</option>";

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
}

//------------ Teste do Enter nos combos --------------------------//
function insertBeforeSelected(obj,objEvent,campo)
{
	if(objEvent.keyCode==13)
	{
		//contéudo do item selecionado
		var codigo    	= obj.options[obj.selectedIndex].value;
		var descricao 	= obj.options[obj.selectedIndex].text;

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

function removeOption(obj,objEvent,campo)
{
    var x=obj
    if(objEvent.keyCode==13 || objEvent.keyCode==46)
	{
    	x.remove(x.selectedIndex);
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

function imprimirconsulta(){

	selecionarTodos("grupo_selecionados");
	selecionarTodos("subgrupo_selecionados");
	$("resultado").innerHTML="";

	var grupo_selecionados 		= document.getElementById("grupo_selecionados").value;
	var subgrupo_selecionados 	= document.getElementById("subgrupo_selecionados").value;
	var datainventario 			= document.getElementById('datainventario').value;
	var estoque 				= document.getElementById('estoque').value;
	var nome 					= document.getElementById('nome').value;

	var erro = 0;

	if(datainventario.length<=9)
	{
		alert("Preencha o campo data corretamente!\nEx: 01/01/2001");
		document.getElementById('datainventario').focus();
		erro = 1;
	}
	else
		if(estoque=="" || estoque=="0")
		{
			alert("Selecione um Estoque!");
			document.getElementById('estoque').focus();
			erro = 1;
		}
		else
			if(grupo_selecionados=="" && subgrupo_selecionados=="" && nome=="")
			{
				alert("Favor escolher ao menos um item para a Abertura de Inventário!");
				document.getElementById('grupo_selecionados').focus();
				erro = 1;
			}

	if(erro=='0')
	load_grid();
}

function formata_data(obj)
{
	obj.value = obj.value.replace( "//", "/" );
	tam = obj.value;
	
	if (tam.length == 2 || tam.length == 5)
		obj.value = obj.value + "/";
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

	//Limpa Fornecedor
	document.getElementById("nome").value="";
	document.getElementById("pesquisa").value="0";
}
