
//-----------------------------------------------
function load_grid()
{
    
	document.getElementById("botao").disabled = true;

	var invdata = document.getElementById("datainventario").value;

	new ajax('aberturageracontagem.php?invdata='+invdata, {onLoading: carregando, onComplete: imprime});
	//window.open('aberturageracontagem.php?invdata='+invdata, "_blank");
	
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

  	if(itens[0].firstChild.data=="0")
	tabela="Abertura de Contagem realizada com sucesso!";
	if(itens[0].firstChild.data=="1")
	tabela="Erro! Já existe contagem nessa Data!";
  	else if(itens[0].firstChild.data=="2")
	tabela="Erro! Contagem em andamento!";
	
	alert( tabela );
	tabela="";
	
	document.getElementById("botao").disabled = false;
}


function imprimirconsulta(){

	
	var datainventario 			= document.getElementById('datainventario').value;

	var erro = 0;		

	if(datainventario.length<=9)
	{
		alert("Preencha o campo data corretamente!\nEx: 01/01/2001");
		document.getElementById('datainventario').focus();
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


