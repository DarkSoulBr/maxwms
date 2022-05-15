// JavaScript Document 
function load_grid()
{
    var opcaosetada = 0;

    var nome = document.getElementById('nome').value;
    var estoque = document.getElementById('estoque').value;
    var datainv = $("datainventario").value;

    //document.write('digitacaogerainventario.php?flag=Listarinventario&nome='+nome+'&estoque='+estoque+'&datainv='+datainv);
    new ajax('digitacaogerainventario.php?flag=Listarinventario&nome=' + nome + '&estoque=' + estoque + '&datainv=' + datainv, {onLoading: carregando, onComplete: imprime});
}

function carregando()
{
    $("msg").style.visibility = "visible";
    $("msg").innerHTML = "Processando...";
}

function imprime(request)
{

    $("resultado").innerHTML = "";
    var xmldoc = request.responseXML;

    var dados = xmldoc.getElementsByTagName('dadosinv')[0];

    var registros = xmldoc.getElementsByTagName('registroinv');

    let resultado = "<form name='formulario_alterar' id='formulario_alterar'><div class='limiter'>"
    resultado += "<div class='container-table100'>"
    resultado += "<div class='wrap-table100'>"
    resultado += "<div class='table-max'>"
    resultado += "<div class='row-max header'>"
    resultado += "<div class='cell-max'>Código</div>"
    resultado += "<div class='cell-max'>Produto</div>"
    resultado += "<div class='cell-max'>Antigo</div>"
    resultado += "<div class='cell-max'>Atual</div>"
    resultado += "</div>"
    if (dados != null)
    {
        var registros = xmldoc.getElementsByTagName('registroinv');
        for (i = 0; i < registros.length; i++)
        {
            var itens = registros[i].getElementsByTagName('iteminv');

            resultado += "<div class='row-max'>"
            resultado += "<div class='cell-max' data-title='Código'>" + itens[0].firstChild.data + "</div>"
            resultado += "<div class='cell-max' data-title='Produto'>" + itens[1].firstChild.data + "</div>"
            resultado += "<div class='cell-max' data-title='Antigo'>" + itens[2].firstChild.data + "</div>"
            resultado += '<div class="cell-max" data-title="Atual"><input type="text" name="invatual" id="invatual" size="6" maxlength="8" value="' + itens[4].firstChild.data + '" style="text-align:right;"><input type="hidden" name="invdodigo" id="invcodigo" value="' + itens[3].firstChild.data + '"></div>'
            resultado += "</div>"

        }
        
        resultado += "<div class='row-max'>"
        resultado += "<div class='cell-max' data-title='Código'>&nbsp;</div>"
        resultado += "<div class='cell-max' data-title='Produto'>&nbsp;</div>"
        resultado += "<div class='cell-max' data-title='Antigo'>&nbsp;</div>"
        resultado += '<div class="cell-max" data-title="Atual"><input type=\"button\" id=\"botao\" value=\"Alterar\" onclick=\"alterar(document.formulario_alterar.invatual.value,document.formulario_alterar.invcodigo.value);\"></div>'
        resultado += "</div>"
        
    }
    resultado += "</div>"
    resultado += "</div>"
    resultado += "</div>"
    resultado += "</div></form>"

    $("resultado").innerHTML = resultado;

}

function imprimeOld(request)
{
    $("msg").style.visibility = "hidden";
    var xmldoc = request.responseXML;

    var dados = xmldoc.getElementsByTagName('dadosinv')[0];

    var tabela = "<form name='formulario_alterar' id='formulario_alterar'><table width='600' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' bgcolor='#CCCCCC'>";
    if (dados != null)
    {
        tabela += "<tr bgcolor='#3366CC'>";
        tabela += "<td class='borda' width='65' align='center'><font color='#FFFFFF' face='Verdana, Arial, Helvetica, sans-serif'><b>Código</b></font></td>";
        tabela += "<td class='borda' width='400'><font color='#FFFFFF' face='Verdana, Arial, Helvetica, sans-serif'><b>Produto</b></font></td>";
        tabela += "<td class='borda' width='65' align='center'><font color='#FFFFFF' face='Verdana, Arial, Helvetica, sans-serif'><b>Antigo</b></font></td>";
        tabela += "<td class='borda' width='70' align='center'><font color='#FFFFFF' face='Verdana, Arial, Helvetica, sans-serif'><b>Atual</b></font></td>";
        tabela += "</tr>";

        var registros = xmldoc.getElementsByTagName('registroinv');
        for (i = 0; i < registros.length; i++)
        {
            var itens = registros[i].getElementsByTagName('iteminv');
            if (itens[0].firstChild != null)
            {
                tabela += "<tr>";
                tabela += "<td class='borda' width='65' align='center'>" + itens[0].firstChild.data + "</td>";
                tabela += "<td class='borda' width='400'>" + itens[1].firstChild.data + "</td>";
                tabela += "<td class='borda' width='65' align='center'>" + itens[2].firstChild.data + "</td>";
                tabela += '<td class="borda" width="70" align="center"><input type="text" name="invatual" id="invatual" size="6" maxlength="8" value="' + itens[4].firstChild.data + '" style="text-align:right;"><input type="hidden" name="invdodigo" id="invcodigo" value="' + itens[3].firstChild.data + '"></td>';
                tabela += "</tr>";
            }
        }

        tabela += "<tr>";
        tabela += "<td colspan=\"4\" height=\"40\" valign=\"middle\" align=\"center\"><input type=\"button\" id=\"botao\" value=\"Alterar\" onclick=\"alterar(document.formulario_alterar.invatual.value,document.formulario_alterar.invcodigo.value);\"></td>";
        tabela += "</tr>";
    } else
    {
        tabela += "<tr>";
        tabela += "<td width='600' align='center'><font color='#000000'><b>Nenhum registro encontrado!!</b></font></td>";
        tabela += "</tr>";
    }

    tabela += "</table></form>";

    $("resultado").innerHTML = tabela;
    tabela = "";
}

//-----------  Produto  -------------------//
function load_grid_prod() {
    var opcaosetada = 0;
    var strnome = "";
    var strestoque = "";

    if (document.getElementById('opcao1').checked == true)
        opcaosetada = 1;

    if (document.getElementById('opcao2').checked == true)
        opcaosetada = 2;

    if (document.getElementById('opcao3').checked == true)
        opcaosetada = 3;

    strnome = document.getElementById('consulta').value;
    strestoque = document.getElementById('estoque').value;

    document.getElementById('nome').disabled = false;

    new ajax('digitacaogerainventario.php?flag=Produto&opcao=' + opcaosetada + '&nome=' + strnome + '&estoque=' + strestoque, {onLoading: carregandoprod, onComplete: imprimeprod});
}

function carregandoprod() {
    $("msg2").style.visibility = "visible";
    $("msg2").innerHTML = "Processando...";
}

function imprimeprod(request) {

    $("msg2").style.visibility = "hidden";
    var xmldoc = request.responseXML;

    var dados = xmldoc.getElementsByTagName('dadosprod')[0];

    var contador = '0';
    var tabela = '<span class="custom-dropdown"><select id="pesquisa" name="pesquisa" size="1" onchange="setar(this);">';
    tabela += "<option value=\"0\">-- Escolha um Produto --</option>";

    if (dados != null)
    {
        //corpo da tabela
        var registros = xmldoc.getElementsByTagName('registroprod');
        for (i = 0; i < registros.length; i++)
        {
            var itens = registros[i].getElementsByTagName('itemprod');
            tabela += '<option value="' + itens[0].firstChild.data + '">' + itens[1].firstChild.data + '</option>\n"';
        }
    }
    tabela += "</select></span>";
    $("resultado2").innerHTML = tabela;
    tabela = "";
}
//------------------------------------------//

//-----------  Estoque  -------------------//
function load_grid_estoque()
{
    new ajax('cadastroconsultaestoque.php', {onComplete: imprime_estoque});
}

function imprime_estoque(request)
{
    var xmldoc = request.responseXML;
    var dados = xmldoc.getElementsByTagName('dados')[0];

    var tabelax = '<span class="custom-dropdown"><select id="estoque" name="estoque" size="1" onchange="setardata();"><option value="0">-- Escolha um Estoque --</option>';

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
//---------------------------------------------//

//-----------  Setar Data  -------------------//
function setardata()
{
    $("resultado").innerHTML = "";
    var estoque = $("estoque").value;

    if (estoque != "0")
        new ajax('digitacaogerainventario.php?flag=Datainv&estoque=' + estoque, {onComplete: imprime_data});
}

function imprime_data(request)
{
    var xmldoc = request.responseXML;
    var dados = xmldoc.getElementsByTagName('dadosdata')[0];

    var registros = xmldoc.getElementsByTagName('registrodata');
    var itens = registros[0].getElementsByTagName('itemdata');

    if (itens[0].firstChild.data != "//")
    {
        $("datainventario").value = itens[0].firstChild.data;
    } else
    {
        alert("Não existe registros para este ESTOQUE!");
        $("resultado").innerHTML = "Não existe registros para este ESTOQUE!";
        $("datainventario").value = "";
        $("estoque").value = "0";
    }
}
//-------------------------------------------//


function alterar(invatual, invcodigo) {

    var nome = $("nome").value;
    var estoque = $("estoque").value;
    var datainv = $("datainventario").value;

    var erro = 0;
    if (estoque == "0")
    {
        alert("Selecione um ESTOQUE!");
        document.getElementById('estoque').focus();
        erro = 1;
    } else
    if (datainv.length <= 9)
    {
        alert("Erro na Data do Inventário! Este estoque não possui produtos cadastrados.\n Selecione outro Estoque!");
        document.getElementById('estoque').focus();
        erro = 1;
    } else
    if (document.getElementById('nome').disabled == true || document.getElementById('nome').value == "")
    {
        alert("Pesquise um Produto!!");
        document.getElementById('consulta').focus();
        erro = 1;
    }

    if (erro == '0')
        alterar_grid(invatual, invcodigo);
}

//-----------  Alterar Inventário  -------------------//
function alterar_grid(invatual, invcodigo)
{
    $("resultado").innerHTML = "";

    //alert("Atual: "+invatual+" Código: "+invcodigo);
    new ajax('digitacaogerainventario.php?flag=Alterarinventario&invatual=' + invatual + '&invcodigo=' + invcodigo, {onComplete: imprime_alterar});
}

function imprime_alterar(request)
{
    $("resultado").innerHTML = "Alteração realizada com sucesso!";
    $("nome").value = "";
    $("pesquisa").value = "0";
}
//-------------------------------------------//

function setar(obj)
{
    document.getElementById('nome').value = obj.value;
    document.getElementById('nome').disabled = false;
    load_grid();
}