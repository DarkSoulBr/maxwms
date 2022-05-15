// JavaScript Document  

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
      new ajax ('cadastroconsultacontagem.php', {onComplete: imprime_estoque2});
}

function imprime_estoque2(request)
{
	var xmldoc=request.responseXML;
  	var dados = xmldoc.getElementsByTagName('dados')[0];

  	var tabelax="<span class=\"custom-dropdown\"><select id=\"estoque2\" name=\"estoque2\" size=\"1\"><option value=\"0\">-- Escolha uma Contagem --</option>";

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
	$("resultado4w").innerHTML=tabelax;
	tabelax="";
		
}

function imprelatorioexexcel(){

	var contagem = document.getElementById("estoque").value;
	var contagem2 = document.getElementById("estoque2").value;
	var contagem3 = document.getElementById("estoque4").value;

	var invdata = document.getElementById("pvemissao").value;
	
	if(invdata==''){
		alert( 'Nenhuma contagem em aberto !');
	}
	else if(contagem==0 || contagem==''){
		alert( 'Selecione a contagem 1 !');
	}
	else if(contagem2==0 || contagem2==''){
		alert( 'Selecione a contagem 2 !');
	}
	else if(contagem3==0 || contagem3==''){
		alert( 'Selecione a contagem 3 !');
	}
	else {				
		window.open('relatoriogeracontagemsetorconsolidadoexcel.php?contagem='+contagem+'&contagem2='+contagem2+'&contagem3='+contagem3+'&invdata='+invdata+'&estoque='+estoque, '_blank' );				
	}	
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

   
   
function verificaest() {

	if (document.getElementById("radio1").checked==true){
		
		$("estoque3").disabled = true;
		
	}
	else {
		
		$("estoque3").disabled = false;
	}	
	
}