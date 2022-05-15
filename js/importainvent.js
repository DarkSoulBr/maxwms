// JavaScript Document
function imprimirconsulta(){

	var dataini 			= document.getElementById('dataini').value;
	var estoque 				= document.getElementById('estoque').value;

	var erro = 0;

	if(dataini.length<=9)
	{
		alert("Preencha o campo data corretamente!\nEx: 01/01/2001");
		document.getElementById('dataini').focus();
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
	//new ajax('importainventconf.php?dataini='+dataini+'&estoque='+estoque, {onLoading: carregandolista, onComplete: imprimelista});
    window.open('importainventconf.php?dataini='+dataini+'&estoque='+estoque , '_self');

	
}

function carregandolista(){
	$("msg").style.visibility="visible";
	$("msg").innerHTML="Processando...";
	$("resultado").innerHTML="";
}

function imprimelista(request)
{
	alert("Exclusão de Log efetuada com sucesso!");
	$("msg").innerHTML="<br>";
	$("resultado").innerHTML="Exclusão de Log efetuada com sucesso!";
}

function formata_data(obj)
{
	obj.value = obj.value.replace( "//", "/" );
	tam = obj.value;
	
	if (tam.length == 2 || tam.length == 5)
		obj.value = obj.value + "/";
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

