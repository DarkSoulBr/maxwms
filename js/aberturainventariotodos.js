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

function load_grupo()
{
    new ajax('cadastroconsultagruposrelprodutos.php', {onComplete: imprime_grupo});
}

function imprime_grupo(request)
{
    var xmldoc = request.responseXML;

    var dados = xmldoc.getElementsByTagName('dados')[0];

    var contador = '0';
    var tabela = "<span class=\"custom-dropdown-multiple\"><select id=\"grupo\" name=\"grupo\" multiple style=\"height:150px;width:300px;\" onkeypress=\"insertBeforeSelected(this,event,'grupo_selecionados')\">";
    //tabela+='<option value="0">-- Escolha um Grupo --</option>';

    if (dados != null)
    {
        //corpo da tabela
        var registros = xmldoc.getElementsByTagName('registro');
        //alert(registros.length);
        for (i = 0; i < registros.length; i++)
        {
            var itens = registros[i].getElementsByTagName('item');
            tabela += '<option value="' + itens[0].firstChild.data + '">' + itens[0].firstChild.data + ' - ' + itens[1].firstChild.data + '</option>\n"';
        }
    }
    tabela += "</select></span>"
    $("resultado2").innerHTML = tabela;
    tabela = "";
}

//-----------------------------------------------
function load_subgrupo()
{
    new ajax('cadastroconsultasubgruprodutos.php', {onComplete: imprime_subgrupo});
}

function imprime_subgrupo(request)
{
    var xmldoc = request.responseXML;

    var dados = xmldoc.getElementsByTagName('dados')[0];

    var contador = '0';
    var tabela = "<span class=\"custom-dropdown-multiple\"><select id=\"subgrupo\" name=\"subgrupo\" multiple style=\"height:150px;width:300px;\" onkeypress=\"insertBeforeSelected(this,event,'subgrupo_selecionados')\">";

    if (dados != null)
    {
        //corpo da tabela
        var registros = xmldoc.getElementsByTagName('registro');
        //alert(registros.length);
        for (i = 0; i < registros.length; i++)
        {
            var itens = registros[i].getElementsByTagName('item');
            tabela += '<option value="' + itens[0].firstChild.data + '">' + itens[0].firstChild.data + ' - ' + itens[1].firstChild.data + '</option>\n"';
        }
    }
    tabela += "</select></span>"
    $("resultado3").innerHTML = tabela;
    tabela = "";
}
//-----------------------------------------------
function load_grid()
{

    //----------------------
    var campovet1 = ""

    for (var kk = 0; kk < 100; kk++) {
        if (vet[kk][0] != 0) {
            if (vet[kk][1] != 0) {
                campovet1 = campovet1 + '&c1[]=' + vet[kk][0];
            }
        }
    }

    document.getElementById("botao").disabled = true;

    var tamanho = document.getElementById("grupo_selecionados").length;
    var i = 0;
    var grupo = "&grupo=";

    for (i = 0; i < tamanho; i++)
    {
        grupo += document.getElementById("grupo_selecionados").options[i].value + ';';
    }

    var tamanho = document.getElementById("subgrupo_selecionados").length;
    var i = 0;
    var subgrupo = "&subgrupo=";

    for (i = 0; i < tamanho; i++)
    {
        subgrupo += document.getElementById("subgrupo_selecionados").options[i].value + ';';
    }

    //var estoque = document.getElementById("estoque").value;
    var invdata = document.getElementById("datainventario").value;

    var estoque_atual = 0;

    if (document.getElementById("estoqueatual01").checked == true)
    {
        estoque_atual = 1;
    } else
    {
        estoque_atual = 2;
    }

    new ajax('aberturagerainventariotodos.php?invdata=' + invdata + '&estoque_atual=' + estoque_atual + campovet1 + grupo + subgrupo + '' + campovet1, {onLoading: carregando, onComplete: imprime});


}

function carregando()
{
    $("msg").style.visibility = "visible";
    $("msg").innerHTML = "Processando...";
}

function imprime(request)
{
    $("msg").style.visibility = "hidden";
    var xmldoc = request.responseXML;
    var dados = xmldoc.getElementsByTagName('dadosinv')[0];
    var registros = xmldoc.getElementsByTagName('registroinv');
    var itens = registros[0].getElementsByTagName('iteminv');

    if (itens[0].firstChild.data == "1")
        tabela = "Abertura de Inventário realizada com sucesso!";
    if (itens[0].firstChild.data == "11")
        tabela = "Erro! Nenhum produto existente para este Grupo!";
    else if (itens[0].firstChild.data == "2")
        tabela = "Abertura de Inventário realizada com sucesso!";
    if (itens[0].firstChild.data == "22")
        tabela = "Erro! Nenhum produto existente para este SubGrupo!";
    else if (itens[0].firstChild.data == "3")
        tabela = "Nenhum produto encontrado. Por favor refaça sua busca.";

    if (document.getElementById("lin1").style.display == "")
        addgrupo();

    if (document.getElementById("lin2").style.display == "")
        addsubgrupo();

    //$("resultado").innerHTML=tabela;
    alert(tabela);
    tabela = "";

    document.getElementById("botao").disabled = false;
}

function load_grid_estoque() {

    //new ajax ('cadastroconsultaestoque.php', {onComplete: imprime_estoque});
    new ajax('aberturainventariopesquisaestoque.php', {onLoading: carregando_est, onComplete: imprime_est});

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

                if (itens[j].firstChild == null) {
                    resultado += "<div class='cell-max'>&nbsp;</div>"
                } else {
                    if (j == 0) {
                        cod = itens[j].firstChild.data;
                        vet[i][0] = itens[j].firstChild.data;
                    } else if (j == 1) {
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

function imprime_estoque(request)
{
    var xmldoc = request.responseXML;
    var dados = xmldoc.getElementsByTagName('dados')[0];

    var tabelax = "<span class=\"custom-dropdown-multiple\"><select id=\"estoque\" name=\"estoque\" size=\"1\"><option value=\"0\">-- Escolha um Estoque --</option>";

    if (dados != null)
    {
        contador = '0';

        //corpo da tabela
        var registros = xmldoc.getElementsByTagName('registro');
        for (i = 0; i < registros.length; i++)
        {
            var itens = registros[i].getElementsByTagName('item');
            for (j = 0; j < itens.length; j++)
            {
                if (itens[j].firstChild != null)
                {
                    if (contador == '0')
                    {
                        tabelax += "<option value='" + itens[j].firstChild.data + "'>";
                        contador++;
                    } else
                    {
                        tabelax += itens[j].firstChild.data + "</option>";
                        contador = '0';
                    }
                } else
                {
                    tabelax += "";
                }
            }
        }
    }
    $("resultado4").innerHTML = tabelax;
    tabelax = "";
}

//------------ Teste do Enter nos combos --------------------------//
function insertBeforeSelected(obj, objEvent, campo)
{
    if (objEvent.keyCode == 13 || objEvent == 13)
    {
        //contéudo do item selecionado
        //var codigo    	= obj.options[obj.selectedIndex].value;
        //var descricao 	= obj.options[obj.selectedIndex].text;
        var codigo = document.getElementById("" + obj).options[document.getElementById("" + obj).selectedIndex].value;
        var descricao = document.getElementById("" + obj).options[document.getElementById("" + obj).selectedIndex].text;

        //alert("teste: "+document.getElementById(campo).length);

        var valorselecionado = '';
        var existe = 0;
        var tamanho = document.getElementById(campo).length;
        var i = 0;
        for (i = 0; i < tamanho; i++)
        {
            var valorselecionado = document.getElementById(campo).options[i].value;

            if (codigo == valorselecionado)
                existe++;
        }

        if (existe == 0)
        {
            //cria um novo option dinamicamente
            var novo = document.createElement("option");

            //atribui um ID a esse elemento
            novo.setAttribute("id", campo);

            novo.setAttribute("selected", "selected");

            //atribui um valor
            novo.value = codigo;

            //atribui um texto
            novo.text = descricao;

            //finalmente adiciona o novo elemento
            document.getElementById(campo).options.add(novo);
        } else
        {
            alert("Item já Selecionado!");
        }
    }
}





function insertBeforeSelected2(campo)
{



    var tamanho = document.getElementById("grupo_selecionados").length;
    for (i = 0; i < tamanho; i++)
    {
        document.getElementById("grupo_selecionados").remove(document.getElementById("grupo_selecionados").options[i]);
    }
    document.getElementById("grupo_selecionados").value = "";


    var campo2 = '';

    var tamanho = document.getElementById(campo).length;
    var i = 0;
    for (i = 0; i < tamanho; i++)
    {
        //document.getElementById(campo).options[i].selected=true;

        var codigo = document.getElementById(campo).options[i].value;
        var descricao = document.getElementById(campo).options[i].text;

        var novo = document.createElement("option");

        campo2 = 'grupo_selecionados';

        //atribui um ID a esse elemento
        novo.setAttribute("id", campo2);

        novo.setAttribute("selected", "selected");

        //atribui um valor
        novo.value = codigo;

        //atribui um texto
        novo.text = descricao;

        //Atribui o title (alt) no texto
        novo.title = descricao;

        //finalmente adiciona o novo elemento
        document.getElementById(campo2).options.add(novo);

    }

}



function insertBeforeSelected2b(campo)
{


    var tamanho = document.getElementById("subgrupo_selecionados").length;
    for (i = 0; i < tamanho; i++)
    {
        document.getElementById("subgrupo_selecionados").remove(document.getElementById("subgrupo_selecionados").options[i]);
    }
    document.getElementById("subgrupo_selecionados").value = "";



    var campo2 = '';

    var tamanho = document.getElementById(campo).length;
    var i = 0;
    for (i = 0; i < tamanho; i++)
    {
        //document.getElementById(campo).options[i].selected=true;

        var codigo = document.getElementById(campo).options[i].value;
        var descricao = document.getElementById(campo).options[i].text;

        var novo = document.createElement("option");

        campo2 = 'subgrupo_selecionados';

        //atribui um ID a esse elemento
        novo.setAttribute("id", campo2);

        novo.setAttribute("selected", "selected");

        //atribui um valor
        novo.value = codigo;

        //atribui um texto
        novo.text = descricao;

        //Atribui o title (alt) no texto
        novo.title = descricao;

        //finalmente adiciona o novo elemento
        document.getElementById(campo2).options.add(novo);

    }

}





function removeOption(objEvent, campo)
{
    if (objEvent.keyCode == 13 || objEvent.keyCode == 46 || objEvent == 46)
    {
        document.getElementById("" + campo).remove(document.getElementById("" + campo).selectedIndex);
    }
    selecionarTodos(campo);
}

function selecionarTodos(campo)
{
    var tamanho = document.getElementById(campo).length;
    var i = 0;
    for (i = 0; i < tamanho; i++)
    {
        document.getElementById(campo).options[i].selected = true;
    }
}

function imprimirconsulta() {

    selecionarTodos("grupo_selecionados");
    selecionarTodos("subgrupo_selecionados");
    //$("resultado").innerHTML="";

    var grupo_selecionados = document.getElementById("grupo_selecionados").value;
    var subgrupo_selecionados = document.getElementById("subgrupo_selecionados").value;
    var datainventario = document.getElementById('datainventario').value;
    //var estoque 				= document.getElementById('estoque').value;

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

        if (datainventario.length <= 9)
        {
            alert("Preencha o campo data corretamente!\nEx: 01/01/2001");
            document.getElementById('datainventario').focus();
            erro = 1;
        } else {

            if (grupo_selecionados == "" && subgrupo_selecionados == "")
            {
                alert("Favor escolher ao menos um item para a Abertura de Inventário!");
                document.getElementById('grupo_selecionados').focus();
                erro = 1;
            }
        }

    }

    if (erro == '0')
        load_grid();
}

function formata_data(obj)
{
    obj.value = obj.value.replace("//", "/");
    tam = obj.value;

    if (tam.length == 2 || tam.length == 5)
        obj.value = obj.value + "/";
}

function addgrupo()
{
    if (document.getElementById("lin1").style.display == "none")
    {
        document.getElementById("lin1").style.display = "";
        document.getElementById("lin2").style.display = "none";
    } else
    {
        document.getElementById("lin1").style.display = "none";
        document.getElementById("lin2").style.display = "none";
    }
    limpar_grupo();
    limpar_subgrupo();
}

function addsubgrupo()
{
    if (document.getElementById("lin2").style.display == "none")
    {
        document.getElementById("lin1").style.display = "none";
        document.getElementById("lin2").style.display = "";
    } else
    {
        document.getElementById("lin1").style.display = "none";
        document.getElementById("lin2").style.display = "none";
    }
    limpar_grupo();
    limpar_subgrupo();
}

function limpar_grupo()
{
    var tamanho = document.getElementById("grupo_selecionados").length;
    for (i = 0; i < tamanho; i++)
    {
        document.getElementById("grupo_selecionados").remove(document.getElementById("subgrupo_selecionados").options[i]);
    }
    document.getElementById("grupo_selecionados").value = "";
}

function limpar_subgrupo()
{
    var tamanho = document.getElementById("subgrupo_selecionados").length;
    for (i = 0; i < tamanho; i++)
    {
        //document.getElementById("subgrupo_selecionados").options[i].value="";
        document.getElementById("subgrupo_selecionados").remove(document.getElementById("subgrupo_selecionados").options[i]);
    }
    document.getElementById("subgrupo_selecionados").value = "";
}

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
