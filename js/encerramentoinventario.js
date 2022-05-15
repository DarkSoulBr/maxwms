// JavaScript Document
var vet = new Array(100);

for (var i = 0; i < 100; i++) {
    vet[i] = new Array(3);
}

for (var i = 0; i < 100; i++) {
    vet[i][0] = 0;
    vet[i][1] = 0;
    vet[i][2] = 0;
}


//-----------  Estoque  -------------------// 
function load_grid_estoque()
{
    new ajax('encerramentoinventariopesquisaestoque.php', {onLoading: carregando_est, onComplete: imprime_est});
}

function carregando_est() {
    $("msg").style.visibility = "visible";
    $("msg").innerHTML = "Processando...";
}

function imprime_est(request) {
    
    $("resultado").innerHTML = "";
    var xmldoc = request.responseXML;

    var dados = xmldoc.getElementsByTagName('dados');
    
    let resultado = "<div class='limiter'>" 
    resultado += "<div class='container-table100'>"
    resultado += "<div class='wrap-table100'>"
    resultado += "<div class='table-max'>"
    resultado += "<div class='row-max header'>"
    resultado += "<div class='cell-max'>Estoque</div>"        
    resultado += "<div class='cell-max'>Opção</div>"  
    resultado += "</div>"  

    if (dados != null)
    {
        var cod = 0;
        var registros = xmldoc.getElementsByTagName('registro');        
        for (i = 0; i < registros.length; i++)
        {            
            var itens = registros[i].getElementsByTagName('item');
			
            resultado += "<div class='row-max'>"
			for (j = 0; j < itens.length; j++) {
				
				if (itens[j].firstChild == null){
                    resultado += "<div class='cell-max'>&nbsp;</div>"
                } else {
					if (j == 0) {
                        cod = itens[j].firstChild.data;
                        vet[i][0] = itens[j].firstChild.data;
					} else if(j == 1) {
						resultado += "<div class='cell-max' data-title='Estoque'>" + itens[j].firstChild.data + "</div>"
					} else if (j == 2) {
						if (itens[j].firstChild.data == 1) {
                            resultado += "<div class='cell-max' data-title='Opção'><input type='checkbox' id='chk" + cod + "' name='chk" + cod + "' onClick=editarbaixa(" + cod + "); checked ></div>";
                            vet[i][1] = itens[j].firstChild.data;
                        } else {
                            resultado += "<div class='cell-max' data-title='Opção'><input type='checkbox' id='chk" + cod + "' name='chk" + cod + "' onClick=editarbaixa(" + cod + "); ></div>";
                            vet[i][1] = 0;
                        }
						resultado += "</div>"
					}	
				}
			}
        }
    }
    resultado += "</div>"        
    resultado += "</div>"        
    resultado += "</div>"        
    resultado += "</div>"        
   
    $("resultado").innerHTML = resultado;
    
}

function imprime_estOld(request) {

    $("msg").style.visibility = "hidden";
    var xmldoc = request.responseXML;
    var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];
    if (cabecalho != null)
    {


        var tabela = "<table width='500' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' ><tr>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Estoque</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Opção</b></td>";

        //corpo da tabela

        var cod = 0;
        var registros = xmldoc.getElementsByTagName('registro');
        for (i = 0; i < registros.length; i++) {
            var itens = registros[i].getElementsByTagName('item');

            tabela += "<tr id=linha" + i + ">"
            for (j = 0; j < itens.length; j++) {
                if (itens[j].firstChild == null)
                    tabela += "<td class='borda'>" + 0 + "</td>";
                else {

                    if (j == 0) {
                        cod = itens[j].firstChild.data;
                        vet[i][0] = itens[j].firstChild.data;
                    } else if (j == 1) {
                        tabela += "<td class='borda'>" + itens[j].firstChild.data + "</td>";
                    } else if (j == 2) {

                        if (itens[j].firstChild.data == 1) {
                            tabela += "<td class='borda'><input type='checkbox' id='chk" + cod + "' name='chk" + cod + "' onClick=editarbaixa(" + cod + "); checked > </td>";
                            vet[i][1] = itens[j].firstChild.data;
                        } else
                        {
                            tabela += "<td class='borda'><input type='checkbox' id='chk" + cod + "' name='chk" + cod + "' onClick=editarbaixa(" + cod + "); > </td>";
                            vet[i][1] = 0;
                        }


                    }

                }
            }
            tabela += "</tr>";
        }

        tabela += "</table>"


        tabela += "</tr>"

        $("resultado").innerHTML = tabela;

        tabela = null;
    } else
    {
        $("resultado").innerHTML = "Nenhum registro encontrado...";
    }


}

function encerrar()
{
    //var estoque 	= $("estoque").value;
    //var datainv 	= $("datainventario").value;

    var erro = 1;

    for (var kk = 0; kk < 100; kk++) {
        if (vet[kk][0] != 0) {
            if (vet[kk][1] != 0) {
                erro = 0;
            }
        }
    }
    if (erro == 1) {
        alert("Escolha pelo menos um estoque !");
    } else {
        encerrar_grid();
    }
}

//-----------  Alterar Inventário  -------------------//
function encerrar_grid()
{

    document.getElementById("botao").disabled = true;

    //----------------------
    var campovet1 = ""

    for (var kk = 0; kk < 100; kk++) {
        if (vet[kk][0] != 0) {
            if (vet[kk][1] != 0) {
                campovet1 = campovet1 + '&c1[]=' + vet[kk][0];
            }
        }
    }

    //var estoque 	= $("estoque").value;
    //var datainv 	= $("datainventario").value;

    //$("resultado").innerHTML="";

    if (document.getElementById("radioa1").checked == true)
    {
        atualiza = 'S';
    } else
    {
        atualiza = 'N';
    }


    //Esse é o certo
    new ajax('encerramentogerainventario.php?atualiza=' + atualiza + '&flag=Encerrarinventario' + '' + campovet1, {onLoading: carregando, onComplete: imprime_encerrar});
    //window.open('encerramentogerainventario.php?atualiza='+atualiza+'&flag=Encerrarinventario'+''+campovet1 ,'_blank');	

}

function carregando()
{
    $("msg").style.visibility = "visible";
    $("msg").innerHTML = "Processando...";
}

function imprime_encerrar(request)
{
    //$("msg").style.visibility="hidden";
    $("msg").innerHTML = "Encerramento realizado com sucesso!";

    document.getElementById("botao").disabled = false;

}
//-------------------------------------------//

function editarbaixa(val1) {

    val2 = document.getElementById('chk' + val1).checked;

    if (val2 == true) {
        var val3 = 1;
    } else {
        var val3 = 0;
    }

    for (var k = 0; k < 100; k++) {
        if (vet[k][0] == val1) {
            vet[k][1] = val3;
        }
    }

}
