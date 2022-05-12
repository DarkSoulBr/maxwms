// JavaScript Document
function load_gridlista()
{

    dataini = document.getElementById("dataini").value;
    datafim = document.getElementById("datafim").value;

    new ajax('consultageractecancelados.php?dataini=' + dataini + '&datafim=' + datafim, {onLoading: carregandolista, onComplete: imprimelista});
    //window.open ('consultageractecancelados.php?dataini='+dataini+'&datafim='+datafim , '_blank');

}

function carregandolista() {
    $("msg").style.visibility = "visible";
    $("msg").innerHTML = "Processando...";
}


function imprimelista(request)
{

    $("resultado").innerHTML = "";
    var xmldoc = request.responseXML;

    var dados = xmldoc.getElementsByTagName('dadoslista')[0];

    var registros = xmldoc.getElementsByTagName('registrolista');

    let resultado = "<div class='limiter'>"
    resultado += "<div class='container-table100'>"
    resultado += "<div class='wrap-table150'>"
    resultado += "<div class='table-max'>"
    resultado += "<div class='row-max header'>"
    resultado += "<div class='cell-max'>Controle</div>"
    resultado += "<div class='cell-max'>Número</div>"
    resultado += "<div class='cell-max'>Chave</div>"
    resultado += "<div class='cell-max'>Protocolo</div>"
    resultado += "<div class='cell-max'>Motivo</div>"
    resultado += "<div class='cell-max'>Usuário</div>"
    resultado += "<div class='cell-max'>Cancelamento</div>"
    resultado += "</div>"
    if (dados != null)
    {
        var registros = xmldoc.getElementsByTagName('registrolista');
        for (i = 0; i < registros.length; i++)
        {
            var itens = registros[i].getElementsByTagName('itemlista');

            resultado += "<div class='row-max'>"
            resultado += "<div class='cell-max' data-title='Controle'>" + itens[0].firstChild.data + "</div>"
            resultado += "<div class='cell-max' data-title='Número'>" + itens[1].firstChild.data + "</div>"
            resultado += "<div class='cell-max' data-title='Chave'>" + itens[2].firstChild.data + "</div>"
            resultado += "<div class='cell-max' data-title='Protocolo'>" + itens[3].firstChild.data + "</div>"
            resultado += "<div class='cell-max' data-title='Motivo'>" + itens[4].firstChild.data + "</div>"
            resultado += "<div class='cell-max' data-title='Usuário'>" + itens[5].firstChild.data + "</div>"
            resultado += "<div class='cell-max' data-title='Cancelamento'>" + itens[6].firstChild.data + "</div>"
            resultado += "</div>"

        }
    }
    resultado += "</div>"
    resultado += "</div>"
    resultado += "</div>"
    resultado += "</div>"

    $("resultado").innerHTML = resultado;

}

function imprimelistaOld(request)
{

    var dataini = document.getElementById("dataini").value;
    var datafim = document.getElementById("datafim").value;

    $("msg").style.visibility = "hidden";
    $("resultado").innerHTML = "";
    var xmldoc = request.responseXML;

    var dados = xmldoc.getElementsByTagName('dadoslista')[0];

    var tabela = "<table width='900' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' bgcolor='#CCCCCC'><tr>"
    tabela += "<td width='900' class='borda' colspan='7' align='center' valign='middle' height='35'><font color='#000000'><b>Consulta Cte Cancelados</b>";
    tabela += "<br><b>Referência:</b> " + dataini + " a " + datafim + "</font></td></tr><tr>";

    if (dados != null)
    {

        tabela += "<td width=\"30\" class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>CTe Controle</b></font></td>";
        tabela += "<td width=\"30\" class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>CTe Numero</b></font></td>";
        tabela += "<td width=\"30\" class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>Chave</b></font></td>";
        tabela += "<td width=\"30\" class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>Protocolo</b></font></td>";
        tabela += "<td width=\"200\" class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>Motivo</b></font></td>";
        tabela += "<td width=\"30\" class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>Usuário</b></font></td>";
        tabela += "<td width=\"30\" class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='center'><font color='#ffffff'><b>Dt.Cancelamento</b></font></td>";

        //corpo da tabela
        var registros = xmldoc.getElementsByTagName('registrolista');
        for (i = 0; i < registros.length; i++)
        {
            var identificador = 0;
            var itens = registros[i].getElementsByTagName('itemlista');
            tabela += "<tr id=linha" + i + ">"
            for (j = 0; j < itens.length; j++)
            {
                if (itens[j].firstChild != null)
                {
                    if (j == 1) {
                        alinhamento = "align='left'";
                    } else {
                        alinhamento = "align='center'";
                    }

                    tabela += "<td class='borda' " + alinhamento + ">" + itens[j].firstChild.data + "</td>";
                } else
                {
                    tabela += "<td class='borda'>.</td>";
                }
            }
            tabela += "</tr>";
        }
        tabela += "</table><br>";
        $("resultado").innerHTML = tabela;
    } else
    {
        tabela += "<td width='100%'>&nbsp;</td>";
        tabela += "</tr>";
        tabela += "<table width='700' border='0' bgcolor='#FFFFFF'>";
        tabela += "<tr>";
        tabela += "<td width='100%' align='center'><font color='#000000'><b>Nenhum registro encontrado!!</b></font></td>";
        tabela += "</table>";
        $("resultado").innerHTML = tabela;
    }
}

function imprimirconsulta() {

    var dataini = document.getElementById("dataini").value;
    var datafim = document.getElementById("datafim").value;

    var erro = 0;
    if (dataini.length <= 9)
    {
        alert("Preencha o campo data corretamente!\nEx: 01/01/2001");
        document.getElementById('dataini').focus();
        erro = 1;
    } else if (datafim.length <= 9)
    {
        alert("Preencha o campo data corretamente!\nEx: 01/01/2001");
        document.getElementById('datafim').focus();
        erro = 1;
    }


    if (erro == '0')
        load_gridlista();
}

function setar(obj)
{
    document.getElementById('nome').value = obj.value;
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
        document.getElementById('datafim').focus();
}