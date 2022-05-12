// JavaScript Document
function imprimirconsulta()
{

    var todosn = document.getElementById("todosn").checked;
    var todosc = document.getElementById("todosc").checked;
    var todosp = document.getElementById("todosp").checked;

    var todos = '';
    var dataini = '';

    var produto = "";

    var erro = 0;


    if (todosc == true)
    {
        todos = '2';

    } else {
        if (todosn == true)
        {
            todos = '1';
            dataini = document.getElementById("dataini").value;


            if (dataini.length <= 9)
            {
                alert("Preencha o campo data corretamente!\nEx: 01/01/2021");
                document.getElementById('dataini').focus();
                erro = 1;
            }

        } else
        {
            if (todosp == true)
            {
                todos = '4';
                produto = "&produto=";

                var tamanho = document.getElementById("produto_selecionados").length;
                if (tamanho > 0)
                {
                    var i = 0;
                    for (i = 0; i < tamanho; i++)
                    {
                        produto += document.getElementById("produto_selecionados").options[i].value + ';';
                    }
                }

                if (tamanho == 0)
                {
                    alert("Escolher pelo menos 1 produto !");
                    erro = 1;
                }
            } else
            {
                todos = '0';
                dataini = '0';
            }
        }
    }

    if (erro == '0') {
        window.open('importacaonfe.php?data=' + dataini + '&todos=' + todos + produto, '_blank');
    }
}

function formata_data(obj)
{
    obj.value = obj.value.replace("//", "/");
    tam = obj.value;

    if (tam.length == 2 || tam.length == 5)
        obj.value = obj.value + "/";
}

function mostrartr()
{

    if (document.getElementById("todoss").checked == true) {
        document.getElementById("lin1").style.display = "none";
        document.getElementById("dataini").value = '';
        document.getElementById("lin7").style.display = "none";
        document.getElementById("lin8").style.display = "none";
        document.getElementById("lin9").style.display = "none";
    } else if (document.getElementById("todosn").checked == true) {
        document.getElementById("lin1").style.display = "";
        document.getElementById("lin7").style.display = "none";
        document.getElementById("lin8").style.display = "none";
        document.getElementById("lin9").style.display = "none";
    } else if (document.getElementById("todosc").checked == true) {
        document.getElementById("lin1").style.display = "none";
        document.getElementById("dataini").value = '';
        document.getElementById("lin7").style.display = "";
        document.getElementById("lin8").style.display = "none";
        document.getElementById("lin9").style.display = "none";
    } else {
        document.getElementById("lin1").style.display = "none";
        document.getElementById("lin7").style.display = "none";
        document.getElementById("lin8").style.display = "";
        document.getElementById("lin9").style.display = "";
    }



}

function formata_data2(documento, data) {



    var ano = parseInt(data.substring(6, 10), 10);
    var mydate = new Date();
    var year = mydate.getFullYear();


    if (validar_data(data.substring(0, 5) + '/' + year)) {

        if (isNaN(ano) == false) {
            if (ano < 2000) {
                ano = ano + 2000;
                documento.value = data.substring(0, 6) + ano;
            }
        } else {

            documento.value = data.substring(0, 5) + '/' + year;

        }

    }

}

function SomenteNumero(e) {
    var tecla = (window.event) ? event.keyCode : e.which;
    if ((tecla > 47 && tecla < 58))
        return true;
    else {
        if (tecla == 8 || tecla == 0)
            return true;
        else
            alert("Somente numero para este campo!");
        return false;
    }
}

function formatar2(mascara, documento)
{
    if (document.getElementById('opcaop2').checked == true) {
        return;
    }

    var i = documento.value.length;
    var saida = mascara.substring(0, 1);
    var texto = mascara.substring(i)

    if (texto.substring(0, 1) != saida)
    {
        documento.value += texto.substring(0, 1);
    }
}

function load_grid_produtos()
{
    var opcaochecada = '';
    var consultapro = '';

    if (document.getElementById("opcaop1").checked == true)
        opcaochecada = "1";

    if (document.getElementById("opcaop2").checked == true)
        opcaochecada = "2";

    consultapro = document.getElementById("consultap").value;

    document.getElementById('pesquisap').disabled = false;
    document.getElementById('produtoc').disabled = false;

    new ajax('cadastroconsultaentradasgeral.php?nome=' + consultapro + '&opcao=' + opcaochecada, {onLoading: carregando, onComplete: imprime_produto});

}

function carregando()
{
    $("msg").style.visibility = "visible";
    $("msg").innerHTML = "Processando...";
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


function insertBeforeSelected2(campo, campo2)
{

    var tamanho = document.getElementById(campo).length;
    var i = 0;
    for (i = 0; i < tamanho; i++)
    {
        //document.getElementById(campo).options[i].selected=true;

        var codigo = document.getElementById(campo).options[i].value;
        var descricao = document.getElementById(campo).options[i].text;

        var valorselecionadox = '';
        var existex = 0;
        var tamanhox = document.getElementById(campo2).length;
        var ix = 0;
        for (ix = 0; ix < tamanhox; ix++)
        {
            var valorselecionadox = document.getElementById(campo2).options[ix].value;

            if (codigo == valorselecionadox)
                existex++;
        }

        if (existex == 0)
        {

            var novo = document.createElement("option");

            //atribui um ID a esse elemento
            novo.setAttribute("id", campo2);

            //novo.setAttribute("selected", "selected");

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


function imprime_produto(request)
{


    $("msg").style.visibility = "hidden";
    var xmldoc = request.responseXML;

    var contador = '0';
    var tabela = '<select id="pesquisap" name="pesquisap" multiple style="height:150px;width:300px;" onkeypress="insertBeforeSelected(pesquisap,event,\'produto_selecionados\');">';

    if (xmldoc != null)
    {
        var dados = xmldoc.getElementsByTagName('dados')[0];

        //corpo da tabela
        var registros = xmldoc.getElementsByTagName('registro');
        //alert(registros.length);
        for (i = 0; i < registros.length; i++)
        {
            var itens = registros[i].getElementsByTagName('item');

            var opcao = itens[1].firstChild.data + ' ' + itens[2].firstChild.data;

            tabela += '<option value="' + itens[0].firstChild.data + '">' + opcao + '</option>\n"';
        }
    }
    tabela += "</select>";
    $("resultado5x").innerHTML = tabela;
    //alert(tabela);
}