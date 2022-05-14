// JavaScript Document
function load_gridgru() {
    var opcaosetada = 0;

    if (document.getElementById('opcao1').checked == true)
        opcaosetada = 1;

    if (document.getElementById('opcao2').checked == true)
        opcaosetada = 2;

    var strgrupo = document.getElementById('consultagrupo').value;

    document.getElementById('pesquisagrupo').disabled = false;
    document.getElementById('grupo').disabled = false;

    new ajax('cadastroconsultagrupo.php?opcao=' + opcaosetada + '&consultagrupo=' + strgrupo, {onLoading: carregandogru, onComplete: imprimegru});
}

function carregandogru() {
    $("msggru").style.visibility = "visible";
    $("msggru").innerHTML = "Processando...";
}

function imprimegru(request) {

    $("msggru").style.visibility = "hidden";
    var xmldoc = request.responseXML;

    var dados = xmldoc.getElementsByTagName('dados')[0];

    var contador = '0';
    var tabela = '<span class="custom-dropdown"><select id="pesquisagrupo" name="pesquisagrupo" size="1" onchange="setargrupo(this);">';
    tabela += "<option value=\"0\">-- Escolha um Grupo --</option>";

    if (dados != null)
    {
        //corpo da tabela
        var registros = xmldoc.getElementsByTagName('registro');
        //alert(registros.length);
        for (i = 0; i < registros.length; i++)
        {

            var itens = registros[i].getElementsByTagName('item');
            for (j = 0; j < itens.length; j++)
            {

                if (itens[j].firstChild != null)
                {
                    tabela += '<option value="' + itens[j].firstChild.data + '">' + itens[j].firstChild.data + '</option>\n"';
                }
            }
        }

    }
    tabela += "</select></span>"
    $("resultadogru").innerHTML = tabela;
    //alert(tabela);
}

function imprimirconsultapedbaicomgrupo() {

    var dataini = document.getElementById('datainigru').value;
    var datafim = document.getElementById('datafimgru').value;
    var gru0 = document.getElementById("gru0").checked;
    var gru1 = document.getElementById("gru1").checked;
    var opcao1 = document.getElementById("opcao1").checked;
    var opcao2 = document.getElementById("opcao2").checked;
    //var opcao3 = document.getElementById("opcao3").checked;
    var consultagrupo = document.getElementById("consultagrupo").value;
    var grupo = document.getElementById("grupo").value;

    var erro = 0;
    if (dataini.length <= 9)
    {
        alert("Preencha o campo data corretamente!\nEx: 01/01/2001");
        document.getElementById('datainigru').focus();
        erro = 1;
    } else if (datafim.length <= 9)
    {
        alert("Preencha o campo data corretamente!\nEx: 01/01/2001");
        document.getElementById('datafimgru').focus();
        erro = 1;
    }

    if (gru1 == true)
    {
        if (grupo == "")
        {
            alert("Escolha um Grupo!!");
            document.getElementById('consultagrupo').focus();
            erro = 1;
        }
    }

    if (opcao1 == true)
        opcao = 1;
    else if (opcao2 == true)
        opcao = 2;
    //else if(opcao3==true)
    //	opcao = 3;

    if (gru0 == true)
    {
        grupo = "";
        opcao = "";
    }

    if (erro == '0')
        window.open('relatoriogerasalpedcomgrupos.php?opcao=' + opcao + '&datainicio=' + dataini + '&datafim=' + datafim + '&gru=' + grupo, 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');
}

function formata_data(obj)
{
    obj.value = obj.value.replace("//", "/");
    tam = obj.value;

    if (tam.length == 2 || tam.length == 5)
        obj.value = obj.value + "/";
}

function pulacampo(obj)
{
    var tam = obj.value;
    if (tam.length == 10)
        document.getElementById('datafimgru').focus();
}

function desabilitargru(campo)
{
    if (campo == '0')
    {
        document.getElementById("opcao1").disabled = true;
        document.getElementById("opcao2").disabled = true;
        //document.getElementById("opcao3").disabled = true;
        document.getElementById('consultagrupo').disabled = true;
        document.getElementById('pesquisar').disabled = true;
        document.getElementById('pesquisagrupo').disabled = true;
        document.getElementById('grupo').disabled = true;
    } else
    {
        document.getElementById("opcao1").disabled = false;
        document.getElementById("opcao2").disabled = false;
        //document.getElementById("opcao3").disabled = false;
        document.getElementById('consultagrupo').disabled = false;
        document.getElementById('grupo').disabled = false;
        document.getElementById('pesquisar').disabled = false;
    }
}

function setargrupo(objgrupo)
{
    document.getElementById('grupo').value = objgrupo.value;
}