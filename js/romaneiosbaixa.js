
var pedtexto;
var vtexto2 = 0;
var pedobs;
var verprimeira = 0;

var pedidoalt = 0;

var vet = new Array(500);

for (var i = 0; i < 500; i++) {
    vet[i] = new Array(9);
}

for (var i = 0; i < 500; i++) {
    vet[i][0] = 0;
    vet[i][1] = 0;
    vet[i][2] = "";
    vet[i][3] = "";
    vet[i][4] = "";
    vet[i][5] = "";
    vet[i][6] = "";
    vet[i][7] = "";
    vet[i][8] = "";
    vet[i][9] = 0;
}

function sugere() {

    var mydate = new Date();
    var dia = mydate.getDate();
    var mes = mydate.getMonth();
    mes = (mes + 1);
    var ano = mydate.getFullYear();
    if (mes < 10) {
        mes = '0' + mes
    }
    if (dia < 10) {
        dia = '0' + dia
    }

    $("baixa").value = dia + '/' + mes + '/' + ano;
    $("pvnumero2").value = ano;

}


function X() {

    var var1 = '';
    var var2 = '';


    for (var i = 0; i < 500; i++) {
        vet[i][9] = 0;
        vet[i][5] = "";
        vet[i][6] = "";
        vet[i][7] = "";
    }



    $("pvnumero").value = $("pvnumero1").value + '/' + $("pvnumero2").value;

    trimjs($("pvnumero1").value);
    var1 = txt;
    trimjs($("pvnumero2").value);
    var2 = txt;

    if (var1 != '') {
        if (var2 != '') {
            carrega_romaneio($("pvnumero").value);
        }
    }

}


function carregando() {
    $("msg").style.visibility = "visible";
    $("msg").innerHTML = "Processando...";
}

function ok() {

    new ajax('exportaromaneiosnum.php?romcodigo=' + document.getElementById('romcodigo').value
            + '&romnumeroano=' + document.getElementById('pvnumero').value
            , {onComplete: oklimpar});


}
function oklimpar() {

    //tabela=null;
    //$("resultado").innerHTML=tabela;
    //$("msg").style.visibility="hidden";
    limpa_form();


}

function load_gridpedido() {

    var campovet = ""
    var campovet2 = ""


    for (i = 0; i < 500; i++) {
        if (vet[i][0] != 0) {
            if (campovet == "") {
                campovet = campovet + 'c[]=' + vet[i][0]
                campovet2 = campovet2 + 'd[]=' + vet[i][1]



            } else {
                campovet = campovet + '&c[]=' + vet[i][0]
                campovet2 = campovet2 + '&d[]=' + vet[i][1]



            }
        }
    }

    //alert(campovet+' '+campovet2);


    new ajax('romaneiosselecionabaixa2.php?pesquisa='
            + document.getElementById('pvnumero').value
            + '&' + campovet
            + '&' + campovet2
            , {onLoading: carregando, onComplete: pesquisarpedido});



    /*
     window.open('romaneiosselecionabaixa.php?pesquisa='
     + document.getElementById('pvnumero').value
     + '&' + campovet
     + '&' + campovet2
     , '_blank');	
     */


}

function pesquisarpedido() {

    var campovet = ""
    var campovet2 = ""

    for (i = 0; i < 500; i++) {
        if (vet[i][0] != 0) {
            if (campovet == "") {
                campovet = campovet + 'c[]=' + vet[i][0]
                campovet2 = campovet2 + 'd[]=' + vet[i][1]
            } else {
                campovet = campovet + '&c[]=' + vet[i][0]
                campovet2 = campovet2 + '&d[]=' + vet[i][1]
            }
        }
    }

    new ajax('romaneiosselecionabaixa2.php?pesquisa='
            + document.getElementById('pvnumero').value
            + '&' + campovet
            + '&' + campovet2
            , {onLoading: carregando, onComplete: imprimepedido});


    //  window.open('romaneiosselecionabaixa2.php?pesquisa='
    //   + document.getElementById('pvnumero').value
    //   + '&' + campovet
    //   + '&' + campovet2
    //  , '_blank');



}

function imprimepedido(request)
	{
		
		$("resultado").innerHTML = "";
		var xmldoc = request.responseXML;
	
		var dados = xmldoc.getElementsByTagName('dados')[0];
	
		var registros = xmldoc.getElementsByTagName('registro'); 
		
		let resultado = "<div class='limiter'>" 
		resultado += "<div class='container-table100'>"
		resultado += "<div class='wrap-table100'>"
		resultado += "<div class='table-max'>"
		resultado += "<div class='row-max header'>"
		resultado += "<div class='cell-max'>Codigo</div>"        
		resultado += "<div class='cell-max'>Cliente</div>"        
		resultado += "<div class='cell-max'>Volumes</div>"        
		resultado += "<div class='cell-max'>Emissão</div>" 
		resultado += "<div class='cell-max'>OBS</div>"        
		resultado += "<div class='cell-max'>Baixa</div>"   
		resultado += "<div class='cell-max'>Recebedor</div>"       
		resultado += "<div class='cell-max'>X</div>"    	
		resultado += "</div>"  
		if (dados != null)
		{
			var registros = xmldoc.getElementsByTagName('registro');        
			for (i = 0; i < registros.length; i++)
			{            
				var itens = registros[i].getElementsByTagName('item');
				
				vet[i][0]=itens[0].firstChild.data;
				vet[i][1]=itens[1].firstChild.data;
				vet[i][2]=itens[2].firstChild.data;
				vet[i][3]=itens[3].firstChild.data;
				vet[i][4]=itens[4].firstChild.data;
				vet[i][5]=itens[5].firstChild.data;
				
				if (itens[6].firstChild.data != 0) {
                txt = itens[6].firstChild.data

                txt = txt.substring(8, 10) + '/' + txt.substring(5, 7) + '/' + txt.substring(0, 4);

				} else {
					txt = '.'
				}

				vet[i][6] = txt;
				vet[i][7] = itens[7].firstChild.data;
				vet[i][8] = itens[8].firstChild.data;
			
				resultado += "<div class='row-max'>"
				resultado += "<div class='cell-max' data-title='Codigo'> " + itens[1].firstChild.data + "</div>"
				if (itens[2].firstChild.data!='0'){
					resultado += "<div class='cell-max' data-title='Cliente'>" + itens[2].firstChild.data + "</div>"
				} else {
					resultado += "<div class='cell-max' data-title='Cliente'>&nbsp;</div>"
				}
				resultado += "<div class='cell-max' data-title='Volumes'>" + itens[3].firstChild.data + "</div>"
				resultado += "<div class='cell-max' data-title='Emissão'>" + itens[4].firstChild.data + "</div>"
				
				if (itens[5].firstChild.data != 0) {
					txt = itens[5].firstChild.data
				} else {
					txt = '.'
				}
				resultado += "<div class='cell-max' data-title='OBS'>" + txt + "</div>"
				
				if (itens[6].firstChild.data != 0) {
					txt = itens[6].firstChild.data

					txt = txt.substring(8, 10) + '/' + txt.substring(5, 7) + '/' + txt.substring(0, 4);

				} else {
					txt = '.'
				}
				resultado += "<div class='cell-max' data-title='Baixa'>" + txt + "</div>"
				
				if (itens[7].firstChild.data != 0) {
					txt = itens[7].firstChild.data
				} else {
					txt = '.'
				}
				resultado += "<div class='cell-max' data-title='Recebedor'>" + txt + "</div>"
				
				if (itens[9].firstChild.data==0){
					resultado += "<div class='cell-max' data-title='X' style='cursor: pointer' onClick=editar("+itens[1].firstChild.data+",0) >_</div>"
				}
				else
				{
					resultado += "<div class='cell-max' data-title='X' style='cursor: pointer' onClick=editar("+itens[1].firstChild.data+",1) >X</div>"
				}
				resultado += "</div>"
				
				if(i==0){
					$("romcodigo").value=itens[8].firstChild.data;
				}
				
			}
		}
		
		verprimeira=1;
		
		resultado += "</div>"        
		resultado += "</div>"        
		resultado += "</div>"        
		resultado += "</div>"        
	   
		$("resultado").innerHTML = resultado;
	   
	}



function imprimepedidoOld(request) {


    ///As tres proximas linhas devem ficar nestre ponto pois o mozila
    ///não entende : var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0]; if(cabecalho!=null)

    $("resultado").innerHTML = "Nenhum registro encontrado...";

    $("msg").style.visibility = "hidden";
    var xmldoc = request.responseXML;
    var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];
    if (cabecalho != null)
    {
        var campo = cabecalho.getElementsByTagName('campo');
        var tabela = "<table class='borda'><tr>"

        //cabecalho da tabela


        tabela += "<td colspan='0'></td>"
        tabela += "<td colspan='1' class='borda'><b>Codigo</b></td>"
        tabela += "<td colspan='1' class='borda'><b>Cliente</b></td>"
        tabela += "<td colspan='1' class='borda'><b>Volumes</b></td>"
        tabela += "<td colspan='1' class='borda'><b>Emissão</b></td>"

        tabela += "<td colspan='1' class='borda'><b>OBS</b></td>"
        tabela += "<td colspan='1' class='borda'><b>Baixa</b></td>"
        tabela += "<td colspan='1' class='borda'><b>Recebedor</b></td>"

        tabela += "<td colspan='1' class='borda'><b>X</b></td>"

        tabela += "<td colspan='0'></td>"

        tabela += "</tr>"

        //corpo da tabela
        var registros = xmldoc.getElementsByTagName('registro');



        for (i = 0; i < registros.length; i++) {


            var itens = registros[i].getElementsByTagName('item');


            vet[i][0] = itens[0].firstChild.data;
            vet[i][1] = itens[1].firstChild.data;
            vet[i][2] = itens[2].firstChild.data;
            vet[i][3] = itens[3].firstChild.data;
            vet[i][4] = itens[4].firstChild.data;
            vet[i][5] = itens[5].firstChild.data;

            if (itens[6].firstChild.data != 0) {
                txt = itens[6].firstChild.data

                txt = txt.substring(8, 10) + '/' + txt.substring(5, 7) + '/' + txt.substring(0, 4);

            } else {
                txt = '.'
            }

            vet[i][6] = txt;
            vet[i][7] = itens[7].firstChild.data;
            vet[i][8] = itens[8].firstChild.data;


            tabela += "<tr id=linha" + i + ">"

            tabela += "<td class='borda2'>" + itens[0].firstChild.data + "</td>";
            tabela += "<td class='borda'>" + itens[1].firstChild.data + "</td>";

            if (itens[2].firstChild.data != '0') {
                tabela += "<td class='borda'>" + itens[2].firstChild.data + "</td>";
            } else {
                tabela += "<td class='borda'>.</td>";
            }

            tabela += "<td class='borda'>" + itens[3].firstChild.data + "</td>";
            tabela += "<td class='borda'>" + itens[4].firstChild.data + "</td>";

            if (itens[5].firstChild.data != 0) {
                txt = itens[5].firstChild.data
            } else {
                txt = '.'
            }
            tabela += "<td class='borda'>" + txt + "</td>";


            if (itens[6].firstChild.data != 0) {
                txt = itens[6].firstChild.data

                txt = txt.substring(8, 10) + '/' + txt.substring(5, 7) + '/' + txt.substring(0, 4);

            } else {
                txt = '.'
            }
            tabela += "<td class='borda'>" + txt + "</td>";


            if (itens[7].firstChild.data != 0) {
                txt = itens[7].firstChild.data
            } else {
                txt = '.'
            }
            tabela += "<td class='borda'>" + txt + "</td>";


            if (itens[9].firstChild.data == 0) {
                tabela += "<td class='borda' style='cursor: pointer' onClick=editar(" + itens[1].firstChild.data + ",0) >_</td>";
            } else
            {
                tabela += "<td class='borda' style='cursor: pointer' onClick=editar(" + itens[1].firstChild.data + ",1) >X</td>";
            }

            tabela += "<td class='borda2'>" + itens[9].firstChild.data + "</td>";  //borda2

            tabela += "</tr>";

            if (i == 0) {
                $("romcodigo").value = itens[8].firstChild.data;
            }

        }

        verprimeira = 1;

        tabela += "</table>"
        $("resultado").innerHTML = tabela;
        tabela = null;
    } else {
        $("resultado").innerHTML = "Nenhum registro encontrado...";
    }



}



function imprimepedido2()
	{
		
		$("resultado").innerHTML = "";
		
		
		let resultado = "<div class='limiter'>" 
		resultado += "<div class='container-table100'>"
		resultado += "<div class='wrap-table100'>"
		resultado += "<div class='table-max'>"
		resultado += "<div class='row-max header'>"
		resultado += "<div class='cell-max'>Codigo</div>"        
		resultado += "<div class='cell-max'>Cliente</div>"        
		resultado += "<div class='cell-max'>Volumes</div>"        
		resultado += "<div class='cell-max'>Emissão</div>" 
		resultado += "<div class='cell-max'>OBS</div>"        
		resultado += "<div class='cell-max'>Baixa</div>"   
		resultado += "<div class='cell-max'>Recebedor</div>"       
		resultado += "<div class='cell-max'>X</div>"    	
		resultado += "</div>"  
		for(var i = 0 ; i < 500 ; i++) {

			if 	(vet[i][0]!=0){			            
			
				resultado += "<div class='row-max'>"
				resultado += "<div class='cell-max' data-title='Codigo'> " + vet[i][1] + "</div>"
				if (vet[i][2]!='0'){
					resultado += "<div class='cell-max' data-title='Cliente'>" + vet[i][2] + "</div>"
				} else {
					resultado += "<div class='cell-max' data-title='Cliente'>&nbsp;</div>"
				}
				resultado += "<div class='cell-max' data-title='Volumes'>" + vet[i][3] + "</div>"
				resultado += "<div class='cell-max' data-title='Emissão'>" + vet[i][4] + "</div>"
				
				if  (vet[i][5]!=0){txt=vet[i][5]}else{txt='.'}
				resultado += "<div class='cell-max' data-title='OBS'>" + txt + "</div>"
				
				if  (vet[i][6]!=0){txt=vet[i][6]}else{txt='.'}
				resultado += "<div class='cell-max' data-title='Baixa'>" + txt + "</div>"
				
				if  (vet[i][7]!=0){txt=vet[i][7]}else{txt='.'}
				resultado += "<div class='cell-max' data-title='Recebedor'>" + txt + "</div>"
				
				if (vet[i][9]==0){
					resultado += "<div class='cell-max' data-title='X' style='cursor: pointer' onClick=editar("+vet[i][1]+",0) >_</div>"
				}
				else
				{
					resultado += "<div class='cell-max' data-title='X' style='cursor: pointer' onClick=editar("+vet[i][1]+",1) >X</div>"
				}
				resultado += "</div>"
				
				if(i==0){
					$("romcodigo").value=vet[i][8];
				}
				
			}
		}
		
		verprimeira=1;
		
		resultado += "</div>"        
		resultado += "</div>"        
		resultado += "</div>"        
		resultado += "</div>"        
	   
		$("resultado").innerHTML = resultado;
	   
	}


function imprimepedido2Old() {




    $("resultado").innerHTML = "Nenhum registro encontrado...";

    $("msg").style.visibility = "hidden";


    var tabela = "<table class='borda'><tr>"
    tabela += "<td colspan='0'></td>"
    tabela += "<td colspan='1' class='borda'><b>Codigo</b></td>"
    tabela += "<td colspan='1' class='borda'><b>Cliente</b></td>"
    tabela += "<td colspan='1' class='borda'><b>Volumes</b></td>"
    tabela += "<td colspan='1' class='borda'><b>Emissão</b></td>"
    tabela += "<td colspan='1' class='borda'><b>OBS</b></td>"
    tabela += "<td colspan='1' class='borda'><b>Baixa</b></td>"
    tabela += "<td colspan='1' class='borda'><b>Recebedor</b></td>"
    tabela += "<td colspan='1' class='borda'><b>X</b></td>"
    tabela += "<td colspan='0'></td>"
    tabela += "</tr>"

    for (var i = 0; i < 500; i++) {


        if (vet[i][0] != 0) {

            tabela += "<tr id=linha" + i + ">"

            tabela += "<td class='borda2'>" + vet[i][0] + "</td>";
            tabela += "<td class='borda'>" + vet[i][1] + "</td>";

            if (vet[i][2] != '0') {
                tabela += "<td class='borda'>" + vet[i][2] + "</td>";
            } else {
                tabela += "<td class='borda'>.</td>";
            }

            tabela += "<td class='borda'>" + vet[i][3] + "</td>";
            tabela += "<td class='borda'>" + vet[i][4] + "</td>";

            if (vet[i][5] != 0) {
                txt = vet[i][5]
            } else {
                txt = '.'
            }
            tabela += "<td class='borda'>" + txt + "</td>";

            if (vet[i][6] != 0) {
                txt = vet[i][6]
            } else {
                txt = '.'
            }
            tabela += "<td class='borda'>" + txt + "</td>";

            if (vet[i][7] != 0) {
                txt = vet[i][7]
            } else {
                txt = '.'
            }
            tabela += "<td class='borda'>" + txt + "</td>";


            if (vet[i][9] == 0) {
                tabela += "<td class='borda' style='cursor: pointer' onClick=editar(" + vet[i][1] + ",0) >_</td>";
            } else
            {
                tabela += "<td class='borda' style='cursor: pointer' onClick=editar(" + vet[i][1] + ",1) >X</td>";
            }

            tabela += "<td class='borda2'>" + vet[i][9] + "</td>";  //borda2

            tabela += "</tr>";

            if (i == 0) {
                $("romcodigo").value = vet[i][8];
            }
        }

    }

    verprimeira = 1;

    tabela += "</table>"
    $("resultado").innerHTML = tabela;
    tabela = null;




}












function carrega_romaneio(valor) {

    for (var i = 0; i < 500; i++) {
        vet[i][0] = 0;
        vet[i][1] = 0;
        vet[i][2] = "";

        vet[i][3] = "";
        vet[i][4] = "";
        vet[i][5] = "";

    }
    verprimeira = 0;

    //verifica se o browser tem suporte a ajax
    try {
        ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (e) {
        try {
            ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (ex) {
            try {
                ajax2 = new XMLHttpRequest();
            } catch (exc) {
                alert("Esse browser não tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    //se tiver suporte ajax
    if (ajax2) {
        //deixa apenas o elemento 1 no option, os outros são excluídos

        ajax2.open("POST", "romaneiosbaixaseleciona.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {

            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {

            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLromaneiosseleciona(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                    //alert("Romaneio não encontrado!");
                    limpa_form();
                }
            }
        }
        //passa o parametro

        var params = "parametro=" + valor;
        ajax2.send(params);

    }
}

function processXMLromaneiosseleciona(obj) {
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados

        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;

            var rombaixa = item.getElementsByTagName("rombaixa")[0].firstChild.nodeValue;
            var romdata = item.getElementsByTagName("romdata")[0].firstChild.nodeValue;


            trimjs(codigo);
            codigo = txt;

            trimjs(rombaixa);
            romveiculo = txt;
            trimjs(romdata);
            romdata = txt;


            if (rombaixa != 0) {
                alert("Romaneio já baixado!");
                limpa_form();
            } else
            {
                if (i == 0) {
                    $("romcodigo").value = codigo;
                    $("data").value = romdata;

                }
                load_gridpedido();
            }
        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo
        //alert("Romaneio não encontrado!");
        limpa_form();

    }

}

function parcf() {

    $("observacao").value = "";
    $("datae").value = "";
    $("recebedor").value = "";

    $("observacao").disabled = "disabled";
    $("datae").disabled = "disabled";
    $("recebedor").disabled = "disabled";

}


function gravaobs() {



    pedobs = $("observacao").value;
    pedbaixa = $("datae").value;
    pedrecebedor = $("recebedor").value;

    trimjs(pedbaixa);
    pedbaixa = txt;
    if (pedbaixa == '') {
        alert("Digite a data da entrega!");
        document.getElementById("datae").focus();
        return;
    }

    trimjs(pedrecebedor);
    pedrecebedor = txt;
    if (pedrecebedor == '') {
        alert("Digite o nome do recebedor!");
        document.getElementById("recebedor").focus();
        return;
    }


    if (document.getElementById("radio2").checked == true) {

        if (pedidoalt == 0) {
            alert("Selecione um item!");
            return;
        }

        $("pedido").value = '';

        editar3(pedidoalt, pedobs, pedbaixa, pedrecebedor);
    } else
    {

        $("pedido").value = '';

        editar4(pedobs, pedbaixa, pedrecebedor);
    }


}


function editar3(texto, pedobs, pedbaixa, pedrecebedor) {




    for (var i = 0; i < 500; i++) {

        if (vet[i][1] == texto) {
            vet[i][9] = 1;
            vet[i][5] = pedobs;
            vet[i][6] = pedbaixa;
            vet[i][7] = pedrecebedor;
        }

    }

    $("observacao").value = "";
    $("datae").value = "";
    $("recebedor").value = "";

    $("observacao").disabled = "disabled";
    $("datae").disabled = "disabled";
    $("recebedor").disabled = "disabled";

    imprimepedido2();


}



function editar4(pedobs, pedbaixa, pedrecebedor) {


    for (var i = 0; i < 500; i++) {

        //alert(vet[i][1]);

        if (vet[i][1] != 0) {
            vet[i][9] = 1;

            vet[i][5] = pedobs;
            vet[i][6] = pedbaixa;
            vet[i][7] = pedrecebedor;

        }

    }

    $("observacao").value = "";
    $("datae").value = "";
    $("recebedor").value = "";

    imprimepedido2();


}


function editar(texto, texto2) {

    if (document.getElementById("radio2").checked == true) {

        editar2(texto, texto2);

    } else
    {
        alert("Selecione Baixa Parcial!");
    }

}

function editar2(texto, texto2) {


    var vcond = 0;
    if (texto2 == 0) {
        vcond = 1;
    } else {

        vcond = 0;

        for (var i = 0; i < 500; i++) {

            if (vet[i][1] == texto) {
                vet[i][9] = vcond;

            }

        }

    }


    $("observacao").value = "";
    $("datae").value = "";
    $("recebedor").value = "";


    if (vcond == 1) {
        pedidoalt = texto;

        $("pedido").value = texto;

        $("observacao").disabled = false;
        $("datae").disabled = false;
        $("recebedor").disabled = false;
        document.getElementById("observacao").focus();

    } else
    {
        pedidoalt = 0;

        $("observacao").disabled = 'disabled';
        $("datae").disabled = 'disabled';
        $("recebedor").disabled = 'disabled';

    }

    if (texto2 != 0) {
        imprimepedido2();
    }



}


function verificaconf(val) {

    $("observacao").disabled = false;
    $("datae").disabled = false;
    $("recebedor").disabled = false;

    for (var i = 0; i < 500; i++) {
        vet[i][1] = 0;
        vet[i][2] = "";

        vet[i][3] = "";
        vet[i][4] = "";

    }

    load_gridpedido();


}



function verificapedido() {

    var contok = 0;

    for (var i = 0; i < 500; i++) {

        if (vet[i][9] != 0) {
            contok = 1;
        }

    }

    if (contok == 0)
    {
        alert("Nenhum pedido selecionado!");
        return;
    }


    if (document.getElementById('baixa').value == "") {
        alert("Digite a Data da Baixa!");
        document.getElementById("baixa").focus();
    } else
    {

        if (valida_data('baixa') == true) {            
            
            /*
            new ajax('romaneiosbaixaaltera.php?romcodigo='
                    + document.getElementById('romcodigo').value
                    + '&baixa='
                    + document.getElementById('baixa').value

                    + '&final='
                    + document.getElementById('final').value

                    , {onLoading: carregando, onComplete: rompedidos});
             * 
             */
            
            rompedidos();
            
            
        }
    }

}


function rompedidos() {

    document.getElementById('enviarped').disabled = true;

    var campovet1 = ""
    var campovet2 = ""
    var campovet3 = ""
    var campovet4 = ""
    var campovet5 = ""

    for (i = 0; i < vet.length; i++) {
        if (vet[i][0] != 0) {
            
            campovet1 = campovet1 + '&c[]=' + vet[i][1]   //pedido
            campovet2 = campovet2 + '&d[]=' + vet[i][9]  //flag
            campovet3 = campovet3 + '&e[]=' + vet[i][5]  //obs
            campovet4 = campovet4 + '&f[]=' + vet[i][6]  //data
            campovet5 = campovet5 + '&g[]=' + vet[i][7]  //receb
            
        }
    }
    
    
    try {
        ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (e) {
        try {
            ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (ex) {
            try {
                ajax2 = new XMLHttpRequest();
            } catch (exc) {
                alert("Esse browser não tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    //se tiver suporte ajax
    if (ajax2)
    {
        ajax2.open("POST", "romaneiosbaixaalterapedidos.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax2.onreadystatechange = function ()
        {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1)
            {

            }
            //após ser processado 
            if (ajax2.readyState == 4)
            {
                //conf(id_pedido);				
                if (ajax2.responseXML) {
                    processXMLinclui(ajax2.responseXML);
                }
            }
        }
    }

    var params = 'romcodigo=' + document.getElementById('romcodigo').value
            + '&romnumeroano=' + document.getElementById('pvnumero').value
            + '&baixa=' + document.getElementById('baixa').value            
            + '&final=' + document.getElementById('final').value          
            + '' + campovet1
            + '' + campovet2
            + '' + campovet3
            + '' + campovet4
            + '' + campovet5
            
    ajax2.send(params);


}


function processXMLinclui(obj) {

    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados


        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            var retorno = item.getElementsByTagName("retorno")[0].firstChild.nodeValue;
            if (retorno > 0) {
                alert("Baixa concluída com sucesso!");                
            }
        }


    } 
    limpa_form()

}

function limpa_form() {

    $("pvnumero").value = "";

    $("pvnumero1").value = "";
    $("pvnumero2").value = "";

    $("romcodigo").value = "0";
    $("data").value = "";
    //$("baixa").value="";
    $("final").value = "";
    document.getElementById("radio1").checked = true;
    $("observacao").value = "";
    $("resultado").innerHTML = "";

    $("observacao").disabled = false;
    $("datae").disabled = false;
    $("recebedor").disabled = false;
    
    document.getElementById('enviarped').disabled = false;

    $("msg").style.visibility = "hidden";



    var mydate = new Date();
    var dia = mydate.getDate();
    var mes = mydate.getMonth();
    mes = (mes + 1);
    var ano = mydate.getFullYear();
    if (mes < 10) {
        mes = '0' + mes
    }
    if (dia < 10) {
        dia = '0' + dia
    }

    $("baixa").value = dia + '/' + mes + '/' + ano;
    $("pvnumero2").value = ano;

    document.getElementById("pvnumero1").focus();

}
