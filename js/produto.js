// JavaScript Document 
//window.onload=dadospesquisafornecedor;


var custo1 = 0;
var custo2 = 0;

var custov1 = 0;
var custov2 = 0;

var custol1 = 0;
var custol2 = 0;

var custog1 = 0;
var custog2 = 0;

var carrega_produto = '';

function ver(produto) {

    if (produto != '') {
        carrega_produto = produto;
    }
    dadospesquisafornecedor();
}

function verificacbarras()
{

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

        ajax2.open("POST", "produtoverificaref.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLverificacbarras(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo

                }
            }
        }


        if ($("acao").value == "inserir")
        {
            valor = 0;
            valor2 = document.getElementById('barunidade').value;
            valor3 = document.getElementById('barcaixa').value;
            valor4 = document.getElementById('proref').value;
        } else if ($("acao").value == "alterar")
        {
            valor = document.getElementById('procodigo').value;
            valor2 = document.getElementById('barunidade').value;
            valor3 = document.getElementById('barcaixa').value;
            valor4 = document.getElementById('proref').value;
        }

        var params = "parametro=" + valor + '&parametro2=' + valor2 + '&parametro3=' + valor3 + '&parametro4=' + valor4;

        ajax2.send(params);
    }
}

function processXMLverificacbarras(obj)
{

    valor2 = document.getElementById('barunidade').value;
    valor3 = document.getElementById('barcaixa').value;
    valor4 = document.getElementById('proref').value;

    if (valor2 == '0') {
        valor2 = '';
    }
    if (valor3 == '0') {
        valor3 = '';
    }

    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados
        var item = dataArray[0];
        //contéudo dos campos no arquivo XML
        var baruni = item.getElementsByTagName("baruni")[0].firstChild.nodeValue;
        var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
        var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
        var barcai = item.getElementsByTagName("barcai")[0].firstChild.nodeValue;
        var codigo2 = item.getElementsByTagName("codigo2")[0].firstChild.nodeValue;
        var descricao2 = item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;
        var proref = item.getElementsByTagName("proref")[0].firstChild.nodeValue;
        var codigo3 = item.getElementsByTagName("codigo3")[0].firstChild.nodeValue;
        var descricao3 = item.getElementsByTagName("descricao3")[0].firstChild.nodeValue;

        trimjs(valor2);
        if (txt != '') {
            if (baruni == 1) {
                alert('Codigo de barras já cadastrado para o produto: ' + codigo + ' ' + descricao);
            }
        } else {
            baruni = 0;
        }
        trimjs(valor3);
        if (txt != '') {
            if (barcai == 1) {
                alert('Codigo de barras da caixa já cadastrado para o produto: ' + codigo2 + ' ' + descricao2);
            }
        } else {
            barcai = 0;
        }
        if (proref == 1) {
            alert('Referencia do Fornecedor já cadastrado para o produto: ' + codigo3 + ' ' + descricao3);
        }
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo

    }

    if (baruni == 0 && barcai == 0 && proref == 0) {
        enviar();
    } else {
        $("botao").disabled = false;
        $("botao2").disabled = false;
        $("botao3").disabled = false;
    }

}




function enviar()
{

    var datainicio = $("datainicio").value;
    var datafinal = $("datafinal").value;

    if (document.getElementById("radio21").checked == true) {
        sexo = 'U'
    } else if (document.getElementById("radio22").checked == true) {
        sexo = 'M'
    } else {
        sexo = 'F'
    }

    if (document.getElementById("radio31").checked == true) {
        validade = 'S'
    } else {
        validade = 'N'
    }

    if (document.getElementById("radio41").checked == true) {
        internet = 'S'
    } else {
        internet = 'N'
    }

    if (document.getElementById("radio51").checked == true) {
        ativo = 'S'
    } else {
        ativo = 'N'
    }

    if (document.forms[0].liststatus.options[document.forms[0].liststatus.selectedIndex].value == 1) {
        ativo = 'S'
    } else {
        ativo = 'N'
    }

    if (document.getElementById("radio61").checked == true) {
        consulta = 'S'
    } else {
        consulta = 'N'
    }

    if (document.getElementById("radio71").checked == true) {
        esgotado = 'S'
    } else {
        esgotado = 'N'
    }

    if (document.getElementById("radio81").checked == true) {
        presente = 'S'
    } else {
        presente = 'N'
    }

    if (document.getElementById("radio91").checked == true) {
        sortido = 'S'
    } else {
        sortido = 'N'
    }

    if (document.getElementById("radioicmss").checked == true) {
        proicms = '1'
    } else if (document.getElementById("radioicmsn").checked == true) {
        proicms = '2'
    } else {
        proicms = '3'
    }

    if (document.getElementById("radiosts").checked == true) {
        expvtex = '1'
    } else {
        expvtex = '2'
    }

    if (document.getElementById("radiocompran").checked == true) {
        procompra = '1'
    } else if (document.getElementById("radiocomprap").checked == true) {
        procompra = '2'
    } else {
        procompra = '3'
    }

    //sempre nao
    prosubs = '2'

    master = 0;
    if (document.getElementById("radiosorts").checked == true) {
        tiposort = '1';
    } else if (document.getElementById("radiosortn").checked == true) {
        tiposort = '2';
    } else {
        tiposort = '3';
        master = document.getElementById('sortprocodigo').value;
    }

    valor = document.getElementById('prnome').value;
    if ($("acao").value == "inserir")
    {
        //window.open('produtoinsere.php?prnome=' + document.getElementById('prnome').value +
        new ajax('produtoinsere.php?prnome=' + document.getElementById('prnome').value +
                '&prnome2=' + document.getElementById('prnome2').value +
                '&procod=' + document.getElementById('procod').value +
                '&proref=' + document.getElementById('proref').value +
                '&proemb=' + document.getElementById('proemb').value +
                '&proipi=' + document.getElementById('proipi').value +
                '&promedio=' + document.getElementById('promedio').value +
                '&promaior=' + document.getElementById('promaior').value +
                '&promenor=' + document.getElementById('promenor').value +
                '&promenord=' + document.getElementById('promenord').value +
                '&prominimo=' + document.getElementById('prominimo').value +
                '&proreal=' + document.getElementById('proreal').value +
                '&profinal=' + document.getElementById('profinal').value +
                '&prorealv=' + document.getElementById('prorealv').value +
                '&profinalv=' + document.getElementById('profinalv').value +
                '&proreall=' + document.getElementById('proreall').value +
                '&profinall=' + document.getElementById('profinall').value +
                '&prorealg=' + document.getElementById('prorealg').value +
                '&profinalg=' + document.getElementById('profinalg').value +
                '&prodesc1=' + document.getElementById('prodesc1').value +
                '&prodesc2=' + document.getElementById('prodesc2').value +
                '&prodesc3=' + document.getElementById('prodesc3').value +
                '&proaltura=' + document.getElementById('proaltura').value +
                '&prolargura=' + document.getElementById('prolargura').value +
                '&procompr=' + document.getElementById('procompr').value +
                '&propeso=' + document.getElementById('propeso').value +
                '&properc=' + document.getElementById('properc').value +
                '&proval=' + document.getElementById('proval').value +
                '&proacres=' + document.getElementById('proacres').value +
                '&prodescs=' + document.getElementById('prodescs').value +
                '&procarac=' + document.getElementById('procarac').value +
                '&grucodigo=' + document.forms[0].listgrupos.options[document.forms[0].listgrupos.selectedIndex].value +
                '&subcodigo=' + document.forms[0].listsubgrupos.options[document.forms[0].listsubgrupos.selectedIndex].value +
                '&marcodigo=' + document.forms[0].listmarcas.options[document.forms[0].listmarcas.selectedIndex].value +
                '&sbmcodigo=' + document.forms[0].listsubmarcas.options[document.forms[0].listsubmarcas.selectedIndex].value +
                '&lincodigo=' + document.forms[0].listlinhas.options[document.forms[0].listlinhas.selectedIndex].value +
                '&stpcodigo=' + document.forms[0].liststatus.options[document.forms[0].liststatus.selectedIndex].value +
                '&faicodigo=' + document.forms[0].listfaixas.options[document.forms[0].listfaixas.selectedIndex].value +
                '&corcodigo=' + document.forms[0].listcores.options[document.forms[0].listcores.selectedIndex].value +
                '&medcodigo=' + document.forms[0].listmedidas.options[document.forms[0].listmedidas.selectedIndex].value +
                '&tricodigo=' + document.forms[0].listtributos.options[document.forms[0].listtributos.selectedIndex].value +
                '&trbcodigo=' + document.forms[0].listtributos2.options[document.forms[0].listtributos2.selectedIndex].value +
                '&clacodigo=' + document.forms[0].listfiscais.options[document.forms[0].listfiscais.selectedIndex].value +
                '&prosexo=' + sexo +
                '&provalid=' + validade +
                '&pronet=' + internet +
                '&proativo=' + ativo +
                '&procons=' + consulta +
                '&proesg=' + esgotado +
                '&propresen=' + presente +
                '&prosort=' + sortido +
                '&forcodigo=' + document.forms[0].listfornecedores.options[document.forms[0].listfornecedores.selectedIndex].value +
                '&proaltcx=' + document.getElementById('proaltcx').value +
                '&prolarcx=' + document.getElementById('prolarcx').value +
                '&procomcx=' + document.getElementById('procomcx').value +
                '&procubcx=' + document.getElementById('procubcx').value +
                '&propescx=' + document.getElementById('propescx').value +
                '&barunidade=' + document.getElementById('barunidade').value +
                '&barcaixa=' + document.getElementById('barcaixa').value +
                '&proicms=' + proicms +
                '&procompra=' + procompra +
                '&prosubs=' + prosubs +
                '&expvtex=' + expvtex +
                '&proprocedencia=' + document.forms[0].listprocedencia.options[document.forms[0].listprocedencia.selectedIndex].value +
                '&protpsort=' + tiposort +
                '&prodtinicio=' + datainicio +
                '&prodtfinal=' + datafinal +
                '&promaster=' + master
                , {onComplete: insereproduto});
        //,"_blank");

        /*
         dadospesquisa3(valor);
         
         alert("Registro adicionado com sucesso!\n Com o número: "+document.getElementById('procod').value);
         $('MsgResultado').innerHTML = "Registro adicionado com sucesso!";
         $('MsgResultado2').innerHTML = "Registro adicionado com sucesso!";
         */


    } else if ($("acao").value == "alterar")
    {

        //window.open('produtoaltera.php?prnome=' + document.getElementById('prnome').value +
        new ajax('produtoaltera.php?prnome=' + document.getElementById('prnome').value +
                '&prnome2=' + document.getElementById('prnome2').value +
                "&procodigo=" + document.getElementById('procodigo').value +
                '&procod=' + document.getElementById('procod').value +
                '&proref=' + document.getElementById('proref').value +
                '&proemb=' + document.getElementById('proemb').value +
                '&proipi=' + document.getElementById('proipi').value +
                '&promedio=' + document.getElementById('promedio').value +
                '&promaior=' + document.getElementById('promaior').value +
                '&promenor=' + document.getElementById('promenor').value +
                '&promenord=' + document.getElementById('promenord').value +
                '&prominimo=' + document.getElementById('prominimo').value +
                '&proreal=' + document.getElementById('proreal').value +
                '&profinal=' + document.getElementById('profinal').value +
                '&prorealv=' + document.getElementById('prorealv').value +
                '&profinalv=' + document.getElementById('profinalv').value +
                '&proreall=' + document.getElementById('proreall').value +
                '&profinall=' + document.getElementById('profinall').value +
                '&prorealg=' + document.getElementById('prorealg').value +
                '&profinalg=' + document.getElementById('profinalg').value +
                '&prodesc1=' + document.getElementById('prodesc1').value +
                '&prodesc2=' + document.getElementById('prodesc2').value +
                '&prodesc3=' + document.getElementById('prodesc3').value +
                '&proaltura=' + document.getElementById('proaltura').value +
                '&prolargura=' + document.getElementById('prolargura').value +
                '&procompr=' + document.getElementById('procompr').value +
                '&propeso=' + document.getElementById('propeso').value +
                '&properc=' + document.getElementById('properc').value +
                '&proval=' + document.getElementById('proval').value +
                '&proacres=' + document.getElementById('proacres').value +
                '&prodescs=' + document.getElementById('prodescs').value +
                '&procarac=' + document.getElementById('procarac').value +
                '&grucodigo=' + document.forms[0].listgrupos.options[document.forms[0].listgrupos.selectedIndex].value +
                '&subcodigo=' + document.forms[0].listsubgrupos.options[document.forms[0].listsubgrupos.selectedIndex].value +
                '&marcodigo=' + document.forms[0].listmarcas.options[document.forms[0].listmarcas.selectedIndex].value +
                '&sbmcodigo=' + document.forms[0].listsubmarcas.options[document.forms[0].listsubmarcas.selectedIndex].value +
                '&lincodigo=' + document.forms[0].listlinhas.options[document.forms[0].listlinhas.selectedIndex].value +
                '&stpcodigo=' + document.forms[0].liststatus.options[document.forms[0].liststatus.selectedIndex].value +
                '&faicodigo=' + document.forms[0].listfaixas.options[document.forms[0].listfaixas.selectedIndex].value +
                '&corcodigo=' + document.forms[0].listcores.options[document.forms[0].listcores.selectedIndex].value +
                '&medcodigo=' + document.forms[0].listmedidas.options[document.forms[0].listmedidas.selectedIndex].value +
                '&tricodigo=' + document.forms[0].listtributos.options[document.forms[0].listtributos.selectedIndex].value +
                '&trbcodigo=' + document.forms[0].listtributos2.options[document.forms[0].listtributos2.selectedIndex].value +
                '&clacodigo=' + document.forms[0].listfiscais.options[document.forms[0].listfiscais.selectedIndex].value +
                '&prosexo=' + sexo +
                '&provalid=' + validade +
                '&pronet=' + internet +
                '&proativo=' + ativo +
                '&procons=' + consulta +
                '&proesg=' + esgotado +
                '&propresen=' + presente +
                '&prosort=' + sortido +
                '&forcodigo=' + document.forms[0].listfornecedores.options[document.forms[0].listfornecedores.selectedIndex].value +
                '&proaltcx=' + document.getElementById('proaltcx').value +
                '&prolarcx=' + document.getElementById('prolarcx').value +
                '&procomcx=' + document.getElementById('procomcx').value +
                '&procubcx=' + document.getElementById('procubcx').value +
                '&propescx=' + document.getElementById('propescx').value +
                '&barunidade=' + document.getElementById('barunidade').value +
                '&barcaixa=' + document.getElementById('barcaixa').value +
                '&proicms=' + proicms +
                '&procompra=' + procompra +
                '&prosubs=' + prosubs +
                '&expvtex=' + expvtex +
                '&proprocedencia=' + document.forms[0].listprocedencia.options[document.forms[0].listprocedencia.selectedIndex].value +
                '&protpsort=' + tiposort +
                '&prodtinicio=' + datainicio +
                '&prodtfinal=' + datafinal +
                '&promaster=' + master
                , {});
        //,"_blank");


        $("botao").disabled = false;
        $("botao2").disabled = false;
        $("botao3").disabled = false;

        custo2 = document.getElementById('proreal').value;

        if (custo1 != custo2) {

            //window.open('produtogravalog.php?procodigo=' + document.getElementById('procodigo').value + '&custo1=' + custo1 + '&custo2=' + custo2 + '&flag=1' +
            new ajax('produtogravalogsort.php?procodigo=' + document.getElementById('procodigo').value + '&custo1=' + custo1 + '&custo2=' + custo2 + '&flag=1' +
                    '&usuario=' + usuario
                    , {});
            //,"_blank");
        }


        custov2 = document.getElementById('prorealv').value;
        if (custov1 != custov2) {

            //window.open('produtogravalog.php?procodigo=' + document.getElementById('procodigo').value + '&custo1=' + custov1 + '&custo2=' + custov2 + '&flag=2' +
            new ajax('produtogravalogsort.php?procodigo=' + document.getElementById('procodigo').value + '&custo1=' + custov1 + '&custo2=' + custov2 + '&flag=2' +
                    '&usuario=' + usuario
                    , {});
            //,"_blank");
        }

        custol2 = document.getElementById('proreall').value;
        if (custol1 != custol2) {

            //window.open('produtogravalog.php?procodigo=' + document.getElementById('procodigo').value + '&custo1=' + custov1 + '&custo2=' + custov2 + '&flag=2' +
            new ajax('produtogravalogsort.php?procodigo=' + document.getElementById('procodigo').value + '&custo1=' + custol1 + '&custo2=' + custol2 + '&flag=3' +
                    '&usuario=' + usuario
                    , {});
            //,"_blank");
        }


        custog2 = document.getElementById('prorealg').value;
        if (custog1 != custog2) {

            //window.open('produtogravalog.php?procodigo=' + document.getElementById('procodigo').value + '&custo1=' + custog1 + '&custo2=' + custog2 + '&flag=4' +
            new ajax('produtogravalogsort.php?procodigo=' + document.getElementById('procodigo').value + '&custo1=' + custog1 + '&custo2=' + custog2 + '&flag=4' +
                    '&usuario=' + usuario
                    , {});
            //,"_blank");
        }


        document.forms[0].listDados.options.length = 0;

        var novo = document.createElement("option");
        //atribui um ID a esse elemento
        novo.setAttribute("id", "opcoes");
        //atribui um valor
        novo.value = document.getElementById('procodigo').value;
        //atribui um texto
        novo.text = document.getElementById('prnome').value;
        //finalmente adiciona o novo elemento

        if (document.getElementById("radio1").checked == true) {
            novo.text = document.getElementById('procod').value;
        } else if (document.getElementById("radio2").checked == true) {
            novo.text = document.getElementById('prnome').value;
        } else
        {
            novo.text = document.getElementById('proref').value;
        }
        document.forms[0].listDados.options.add(novo);

        alert("Registro alterado com sucesso!");
        $('MsgResultado').innerHTML = "Registro alterado com sucesso!";
        $('MsgResultado2').innerHTML = "Registro alterado com sucesso!";

        limpa_form();
    }
}

function insereproduto(request) {

    var id_produto = '';

    var xmldoc = request.responseXML;

    if (xmldoc.getElementsByTagName('dados')[0] == null) {
        alert('Problema com a inclusão, favor tentar novamente !');
    } else {

        var dados = xmldoc.getElementsByTagName('dados')[0];

        var xmldoc = request.responseXML;
        var dados = xmldoc.getElementsByTagName('dados')[0];

        if (dados != null)
        {
            var registros = xmldoc.getElementsByTagName('registro');
            for (i = 0; i < registros.length; i++)
            {
                var itens = registros[i].getElementsByTagName('item');
                if (itens[0].firstChild.data == null) {
                } else
                    id_produto = itens[0].firstChild.data;
            }
        }

    }

    if (id_produto != '') {

        alert("Registro adicionado com sucesso!\n Com o número: " + id_produto);
        $('MsgResultado').innerHTML = "Registro adicionado com sucesso!";
        $('MsgResultado2').innerHTML = "Registro adicionado com sucesso!";

        $("procod").value = id_produto;

        var valor = document.getElementById('prnome').value;

        dadospesquisa3(valor);

    }

    $("botao").disabled = false;
    $("botao2").disabled = false;
    $("botao3").disabled = false;

}


function apagar(procodigo)
{
    if (usuario == 359) {
        if (confirm("Atenção, essa opção está disponivel apenas para o Administrador , tem realmente certeza que deseja Excluir?\n\t")) {
            new ajax('produtoapaga.php?procodigo=' + procodigo, {});
            alert("Registro excluído com sucesso!");
            $('MsgResultado').innerHTML = "Registro excluído com sucesso!";
            $('MsgResultado2').innerHTML = "Registro excluído com sucesso!";
            limpa_form();
        }
    } else {
        alert('Atenção, a exclusão de produtos só poderá ser feita pelo Administrador!');
    }
}

function valida_form()
{

    var barcaixa1 = document.getElementById('barcaixa').value;
    var nbarcaixa1 = barcaixa1.length;

    var datainicio = $("datainicio").value;
    var datafinal = $("datafinal").value;

    trimjs(barcaixa1);
    if (txt == '' || txt == '0') {
        nbarcaixa1 = 14;
    }


    if ($("prnome").value == "")
    {
        alert("Preencha o campo Nome do Produto");
        $("prnome").focus();
        return false;
    } else if ($("prnome2").value == "")
    {
        alert("Preencha o campo Descrição do Produto");
        $("prnome2").focus();
        return false;
    } else if (document.forms[0].listfornecedores.options[document.forms[0].listfornecedores.selectedIndex].value == "" || document.forms[0].listfornecedores.options[document.forms[0].listfornecedores.selectedIndex].value == "0")
    {
        alert("Selecione um Fornecedor!");
        return false;
    } else if ($("proref").value == "")
    {
        alert("Preencha o campo Ref.Fornecedor!");
        $("proref").focus();
        return false;
    } else if (document.forms[0].listgrupos.options[document.forms[0].listgrupos.selectedIndex].value == "" || document.forms[0].listgrupos.options[document.forms[0].listgrupos.selectedIndex].value == "0")
    {
        alert("Selecione um Grupo!");
        return false;
    } else if (document.forms[0].listsubgrupos.options[document.forms[0].listsubgrupos.selectedIndex].value == "" || document.forms[0].listsubgrupos.options[document.forms[0].listsubgrupos.selectedIndex].value == "0")
    {
        alert("Selecione um SubGrupo!");
        return false;
    } else if (document.forms[0].listmarcas.options[document.forms[0].listmarcas.selectedIndex].value == "" || document.forms[0].listmarcas.options[document.forms[0].listmarcas.selectedIndex].value == "0")
    {
        alert("Selecione uma Marca!");
        return false;
    } else if (document.forms[0].listsubmarcas.options[document.forms[0].listsubmarcas.selectedIndex].value == "" || document.forms[0].listsubmarcas.options[document.forms[0].listsubmarcas.selectedIndex].value == "0")
    {
        alert("Selecione uma SubMarca!");
        return false;
    } else if (document.forms[0].listlinhas.options[document.forms[0].listlinhas.selectedIndex].value == "" || document.forms[0].listlinhas.options[document.forms[0].listlinhas.selectedIndex].value == "0")
    {
        alert("Selecione uma Linha!");
        return false;
    } else if (document.forms[0].liststatus.options[document.forms[0].liststatus.selectedIndex].value == "" || document.forms[0].liststatus.options[document.forms[0].liststatus.selectedIndex].value == "0")
    {
        alert("Selecione um Status!");
        return false;
    } else if (document.forms[0].listfaixas.options[document.forms[0].listfaixas.selectedIndex].value == "" || document.forms[0].listfaixas.options[document.forms[0].listfaixas.selectedIndex].value == "0")
    {
        alert("Selecione uma Faixa Etária!");
        return false;
    } else if (document.forms[0].listcores.options[document.forms[0].listcores.selectedIndex].value == "" || document.forms[0].listcores.options[document.forms[0].listcores.selectedIndex].value == "0")
    {
        alert("Selecione uma Cor!");
        return false;
    } else if (document.forms[0].listmedidas.options[document.forms[0].listmedidas.selectedIndex].value == "" || document.forms[0].listmedidas.options[document.forms[0].listmedidas.selectedIndex].value == "0")
    {
        alert("Selecione uma Un. Medida!");
        return false;
    } else if ($("proemb").value == "")
    {
        alert("Preencha o campo Embalagem!");
        $("proemb").focus();
        return false;
    } else if (document.forms[0].listtributos.options[document.forms[0].listtributos.selectedIndex].value == "")
    {
        alert("Selecione uma Sit. Tributária!");
        return false;
    } else if (document.forms[0].listtributos2.options[document.forms[0].listtributos2.selectedIndex].value == "")
    {
        alert("Selecione uma Sit. Tributária!");
        return false;
    } else if (document.forms[0].listprocedencia.options[document.forms[0].listprocedencia.selectedIndex].value == "" || document.forms[0].listprocedencia.options[document.forms[0].listprocedencia.selectedIndex].value == "0")
    {
        alert("Selecione uma Procedência!");
        return false;
    } else if (document.forms[0].listfiscais.options[document.forms[0].listfiscais.selectedIndex].value == "" || document.forms[0].listfiscais.options[document.forms[0].listfiscais.selectedIndex].value == "0")
    {
        alert("Selecione uma Cls. Fiscal!");
        return false;
    } else if ($("proipi").value == "")
    {
        alert("Preencha o campo IPI Compra!");
        $("proipi").focus();
        return false;
    } else if (nbarcaixa1 != 14)
    {
        alert("O codigo de barras da caixa deve ter 14 números!");
        $("barcaixa").focus();
        return false;
    } else if (document.getElementById("radiosorte").checked == true && $("sortprocodigo").value == "")
    {
        alert("Produto do Tipo Sortimento, preencha o Produto Master!");
        $("sortpesquisa").focus();
        return false;
    } else if (datainicio.length > 0 && datainicio.length <= 9) {
        alert("Preencha o campo data de Inicio corretamente!\nEx: 01/01/2015");
        document.getElementById('datainicio').focus();
        return false;
    } else if (datafinal.length > 0 && datafinal.length <= 9) {
        alert("Preencha o campo data Final corretamente!\nEx: 01/01/2015");
        document.getElementById('datafinal').focus();
        return false;
    } else
    {
        if ($("proemb").value == "") {
            $("proemb").value = 0;
        }
        ;

        if ($("proipi").value == "") {
            $("proipi").value = 0;
        }
        ;
        if ($("promaior").value == "") {
            $("promaior").value = 0;
        }
        ;
        if ($("promedio").value == "") {
            $("promedio").value = 0;
        }
        ;
        if ($("promenor").value == "") {
            $("promenor").value = 0;
        }
        ;
        if ($("promenord").value == "") {
            $("promenord").value = 0;
        }
        ;
        if ($("prominimo").value == "") {
            $("prominimo").value = 0;
        }
        ;

        if ($("proreal").value == "") {
            $("proreal").value = 0;
        }
        ;
        if ($("profinal").value == "") {
            $("profinal").value = 0;
        }
        ;
        if ($("prorealv").value == "") {
            $("prorealv").value = 0;
        }
        ;
        if ($("profinalv").value == "") {
            $("profinalv").value = 0;
        }
        ;
        if ($("proreall").value == "") {
            $("proreall").value = 0;
        }
        ;
        if ($("profinall").value == "") {
            $("profinall").value = 0;
        }
        ;

        if ($("prorealg").value == "") {
            $("prorealg").value = 0;
        }
        ;
        if ($("profinalg").value == "") {
            $("profinalg").value = 0;
        }
        ;

        if ($("proaltura").value == "") {
            $("proaltura").value = 0;
        }
        ;
        if ($("prolargura").value == "") {
            $("prolargura").value = 0;
        }
        ;
        if ($("procompr").value == "") {
            $("procompr").value = 0;
        }
        ;
        if ($("propeso").value == "") {
            $("propeso").value = 0;
        }
        ;
        if ($("properc").value == "") {
            $("properc").value = 0;
        }
        ;
        if ($("proval").value == "") {
            $("proval").value = 0;
        }
        ;
        if ($("proacres").value == "") {
            $("proacres").value = 0;
        }
        ;
        if ($("proaltcx").value == "") {
            $("proaltcx").value = 0;
        }
        ;
        if ($("prolarcx").value == "") {
            $("prolarcx").value = 0;
        }
        ;
        if ($("procomcx").value == "") {
            $("procomcx").value = 0;
        }
        ;
        if ($("procubcx").value == "") {
            $("procubcx").value = 0;
        }
        ;
        if ($("propescx").value == "") {
            $("propescx").value = 0;
        }
        ;

        $("botao").disabled = true;
        $("botao2").disabled = true;
        $("botao3").disabled = true;

        //alert('vai');
        verificacbarras();
    }
}
function limpa_form()
{
    $("acao").value = "inserir";
    $("botao").value = "Incluir";
    $("prnome").value = "";
    $("prnome2").value = "";
    $("procod").value = "";
    $("procodigo").value = "";
    $("proref").value = "";
    $("proemb").value = "";
    $("proipi").value = "";
    $("proipiven").value = "";
    $("promedio").value = "";
    $("promaior").value = "";
    $("promenor").value = "";
    $("promenord").value = "";
    $("prominimo").value = "";
    $("proaltcx").value = "";
    $("datainicio").value = "";
    $("datafinal").value = "";
    $("precoa").value = "";
    $("precob").value = "";
    $("precoc").value = "";
    $("precod").value = "";
    $("precominimo").value = "";
    $("proreal").value = "";
    $("profinal").value = "";
    $("prorealv").value = "";
    $("profinalv").value = "";
    $("proreall").value = "";
    $("profinall").value = "";

    $("prorealg").value = "";
    $("profinalg").value = "";

    $("prodesc1").value = "";
    $("prodesc2").value = "";
    $("prodesc3").value = "";
    $("proaltura").value = "";
    $("prolargura").value = "";
    $("procompr").value = "";
    $("propeso").value = "";
    $("properc").value = "";
    $("proval").value = "";
    $("proacres").value = "";
    $("prodescs").value = "";
    $("procarac").value = "";
    $("pesquisa").value = "";
    $("prolarcx").value = "";
    $("procomcx").value = "";
    $("procubcx").value = "";
    $("propescx").value = "";
    $("barunidade").value = "";
    $("barcaixa").value = "";

    $("custoa1").value = "";
    $("custoa2").value = "";
    $("custoa3").value = "";
    $("custo1").value = "";
    $("custo2").value = "";
    $("custo3").value = "";
    $("data1").value = "";
    $("data2").value = "";
    $("data3").value = "";
    $("usuario1").value = "";
    $("usuario2").value = "";
    $("usuario3").value = "";

    $("vcustoa1").value = "";
    $("vcustoa2").value = "";
    $("vcustoa3").value = "";
    $("vcusto1").value = "";
    $("vcusto2").value = "";
    $("vcusto3").value = "";
    $("vdata1").value = "";
    $("vdata2").value = "";
    $("vdata3").value = "";
    $("vusuario1").value = "";
    $("vusuario2").value = "";
    $("vusuario3").value = "";

    $("lcustoa1").value = "";
    $("lcustoa2").value = "";
    $("lcustoa3").value = "";
    $("lcusto1").value = "";
    $("lcusto2").value = "";
    $("lcusto3").value = "";
    $("ldata1").value = "";
    $("ldata2").value = "";
    $("ldata3").value = "";
    $("lusuario1").value = "";
    $("lusuario2").value = "";
    $("lusuario3").value = "";

    $("sortprocodigo").value = "";
    $("sortprnome").value = "";
    $("sortprocod").value = "";
    $("sortpesquisa").value = "";

    $("sortradio1").disabled = true;
    $("sortradio2").disabled = true;
    $("sortradio3").disabled = true;
    $("sortpesquisa").disabled = true;
    $("sortbutton").disabled = true;
    $("sortlistDados").disabled = true;

    document.getElementById("radiosorts").checked = true;
    document.getElementById("sortradio1").checked = true;

    document.forms[0].listDados.options.length = 1;
    idOpcao = document.getElementById("opcoes");
    idOpcao.innerHTML = "____________________";


    document.forms[0].sortlistDados.options.length = 1;
    idOpcao = document.getElementById("sortopcoes");
    idOpcao.innerHTML = "____________________";

    document.forms[0].listgrupos.options[0].selected = true;
    document.forms[0].listsubgrupos.options[0].selected = true;
    document.forms[0].listmarcas.options[0].selected = true;
    document.forms[0].listsubmarcas.options[0].selected = true;
    document.forms[0].listlinhas.options[0].selected = true;
    document.forms[0].liststatus.options[0].selected = true;
    document.forms[0].listfaixas.options[0].selected = true;
    document.forms[0].listcores.options[0].selected = true;
    document.forms[0].listmedidas.options[0].selected = true;
    document.forms[0].listtributos.options[0].selected = true;
    document.forms[0].listtributos2.options[0].selected = true;
    document.forms[0].listfiscais.options[0].selected = true;
    document.forms[0].listprocedencia.options[0].selected = true;
    document.getElementById("radio21").checked = true;
    document.getElementById("radio31").checked = true;
    document.getElementById("radio41").checked = true;
    document.getElementById("radio51").checked = true;
    document.getElementById("radio61").checked = true;
    document.getElementById("radio71").checked = true;
    document.getElementById("radio81").checked = true;
    document.getElementById("radio91").checked = true;

    document.getElementById("radioicmss").checked = true;
    document.getElementById("radiocompran").checked = true;

    var img = document.getElementById('imagem');
    img.setAttribute("src", "./produtos/figura0.jpg");

    document.forms[0].listfornecedores.options[0].selected = true;
    dadosfor(document.forms[0].listfornecedores.options[document.forms[0].listfornecedores.selectedIndex].value);

    document.formulario.listmedidas.disabled = false;


}

function limpa_form2()
{
    $("acao").value = "inserir";
    $("botao").value = "Incluir";
    $("procodigo").value = "";
    $("prnome").value = "";
    $("prnome2").value = "";
    $("procod").value = "";
    $("proref").value = "";
    $("proemb").value = "";
    $("proipi").value = "";
    $("proipiven").value = "";
    $("promedio").value = "";
    $("promaior").value = "";
    $("promenor").value = "";
    $("promenord").value = "";
    $("prominimo").value = "";
    $("datainicio").value = "";
    $("datafinal").value = "";
    $("precoa").value = "";
    $("precob").value = "";
    $("precoc").value = "";
    $("precod").value = "";
    $("precominimo").value = "";
    $("proreal").value = "";
    $("profinal").value = "";
    $("prorealv").value = "";
    $("profinalv").value = "";
    $("proreall").value = "";
    $("profinall").value = "";

    $("prorealg").value = "";
    $("profinalg").value = "";

    $("prodesc1").value = "";
    $("prodesc2").value = "";
    $("prodesc3").value = "";
    $("proaltura").value = "";
    $("prolargura").value = "";
    $("procompr").value = "";
    $("propeso").value = "";
    $("properc").value = "";
    $("proval").value = "";
    $("proacres").value = "";
    $("prodescs").value = "";
    $("procarac").value = "";
    $("proaltcx").value = "";
    $("prolarcx").value = "";
    $("procomcx").value = "";
    $("procubcx").value = "";
    $("propescx").value = "";
    $("barunidade").value = "";
    $("barcaixa").value = "";

    $("custoa1").value = "";
    $("custoa2").value = "";
    $("custoa3").value = "";
    $("custo1").value = "";
    $("custo2").value = "";
    $("custo3").value = "";
    $("data1").value = "";
    $("data2").value = "";
    $("data3").value = "";
    $("usuario1").value = "";
    $("usuario2").value = "";
    $("usuario3").value = "";

    $("vcustoa1").value = "";
    $("vcustoa2").value = "";
    $("vcustoa3").value = "";
    $("vcusto1").value = "";
    $("vcusto2").value = "";
    $("vcusto3").value = "";
    $("vdata1").value = "";
    $("vdata2").value = "";
    $("vdata3").value = "";
    $("vusuario1").value = "";
    $("vusuario2").value = "";
    $("vusuario3").value = "";

    $("lcustoa1").value = "";
    $("lcustoa2").value = "";
    $("lcustoa3").value = "";
    $("lcusto1").value = "";
    $("lcusto2").value = "";
    $("lcusto3").value = "";
    $("ldata1").value = "";
    $("ldata2").value = "";
    $("ldata3").value = "";
    $("lusuario1").value = "";
    $("lusuario2").value = "";
    $("lusuario3").value = "";

    $("sortprocodigo").value = "";
    $("sortprnome").value = "";
    $("sortprocod").value = "";

    $("sortpesquisa").value = "";

    $("sortradio1").disabled = true;
    $("sortradio2").disabled = true;
    $("sortradio3").disabled = true;
    $("sortpesquisa").disabled = true;
    $("sortbutton").disabled = true;
    $("sortlistDados").disabled = true;

    document.forms[0].sortlistDados.options.length = 1;
    idOpcao = document.getElementById("sortopcoes");
    idOpcao.innerHTML = "____________________";

    document.getElementById("radiosorts").checked = true;
    document.getElementById("sortradio1").checked = true;


    document.forms[0].listgrupos.options[0].selected = true;
    document.forms[0].listsubgrupos.options[0].selected = true;
    document.forms[0].listmarcas.options[0].selected = true;
    document.forms[0].listsubmarcas.options[0].selected = true;
    document.forms[0].listlinhas.options[0].selected = true;
    document.forms[0].liststatus.options[0].selected = true;
    document.forms[0].listfaixas.options[0].selected = true;
    document.forms[0].listcores.options[0].selected = true;
    document.forms[0].listmedidas.options[0].selected = true;
    document.forms[0].listtributos.options[0].selected = true;
    document.forms[0].listtributos2.options[0].selected = true;
    document.forms[0].listfiscais.options[0].selected = true;
    document.forms[0].listprocedencia.options[0].selected = true;
    document.getElementById("radio21").checked = true;
    document.getElementById("radio31").checked = true;
    document.getElementById("radio41").checked = true;
    document.getElementById("radio51").checked = true;
    document.getElementById("radio61").checked = true;
    document.getElementById("radio71").checked = true;
    document.getElementById("radio81").checked = true;
    document.getElementById("radio91").checked = true;
    document.getElementById("radioicmss").checked = true;
    document.getElementById("radiocompran").checked = true;
    document.forms[0].listfornecedores.options[0].selected = true;

    var img = document.getElementById('imagem');
    img.setAttribute("src", "./produtos/figura0.jpg");

    document.formulario.listmedidas.disabled = false;
}

function verifica1()
{
    if (confirm("Tem certeza que deseja Excluir?\n\t")) {
        apagar($("procodigo").value);
    }
}

function verifica()
{
    if ($("procodigo").value == "")
    {
        alert("Nenhum Registro Selecionado!");
    } else
    {
        verifica1();
    }
}

function dadospesquisa(valor)
{
    $('MsgResultado').innerHTML = "Processando...";
    $('MsgResultado2').innerHTML = "Processando...";

    var img = document.getElementById('imagem');
    img.setAttribute("src", "./produtos/figura0.jpg");

    //$('listmedidas').disabled=true;
    //$("#listmedidas").setAttribute ("disabled", "true");
    //document.forms[4].listmedidas.disabled = true;

    //verifica se o browser tem suporte a ajax
    try {
        ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (e)
    {
        try {
            ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (ex)
        {
            try {
                ajax2 = new XMLHttpRequest();
            } catch (exc)
            {
                alert("Esse browser não tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    //se tiver suporte ajax
    if (ajax2)
    {
        //deixa apenas o elemento 1 no option, os outros são excluídos
        document.forms[0].listDados.options.length = 1;

        idOpcao = document.getElementById("opcoes");

        ajax2.open("POST", "produtopesquisa.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML) {
                    processXML(ajax2.responseXML);
                } else
                {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "____________________";
                }
            }
        }
        //passa o parametro
        if (document.getElementById("radio1").checked == true) {
            valor2 = "1";
        } else if (document.getElementById("radio2").checked == true) {
            valor2 = "2";
        } else
        {
            valor2 = "3";
        }
        var params = "parametro=" + valor + '&parametro2=' + valor2;

        if (valor != "")
            ajax2.send(params);
        else
        {
            $('MsgResultado').innerHTML = "";
            $('MsgResultado2').innerHTML = "";
        }
    }
}

function dadospesquisa2(valor)
{

    $('MsgResultado').innerHTML = "Processando...";
    $('MsgResultado2').innerHTML = "Processando...";

    var img = document.getElementById('imagem');
    img.setAttribute("src", "./produtos/figura0.jpg");

    //verifica se o browser tem suporte a ajax
    try {
        ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (e)
    {
        try {
            ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (ex)
        {
            try {
                ajax2 = new XMLHttpRequest();
            } catch (exc)
            {
                alert("Esse browser não tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    //se tiver suporte ajax
    if (ajax2)
    {
        ajax2.open("POST", "produtopesquisa2.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXML2(ajax2.responseXML);
                } else
                {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                }
            }
        }
        //passa o parametro escolhido
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function dadospesquisa3(valor)
{
    $('MsgResultado').innerHTML = "Processando...";
    $('MsgResultado2').innerHTML = "Processando...";
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
    if (ajax2)
    {
        //deixa apenas o elemento 1 no option, os outros são excluídos
        document.forms[0].listDados.options.length = 1;

        idOpcao = document.getElementById("opcoes");

        ajax2.open("POST", "produtopesquisa3.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXML3(ajax2.responseXML);
                } else
                {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "____________________";
                }
            }
        }
        //passa o parametro escolhido
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXML(obj)
{

    custo1 = 0;
    custov1 = 0;
    custol1 = 0;

    custog1 = 0;

    if (usuario == 359 || usuario == 728) {
        document.formulario.listmedidas.disabled = false;
    } else {
        document.formulario.listmedidas.disabled = true;
    }

    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados

        document.forms[0].listDados.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
            var descricao2 = item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;
            var descricaob = item.getElementsByTagName("descricaob")[0].firstChild.nodeValue;
            var descricaod = item.getElementsByTagName("descricaod")[0].firstChild.nodeValue;
            var descricaoe = item.getElementsByTagName("descricaoe")[0].firstChild.nodeValue;
            var descricaof = item.getElementsByTagName("descricaof")[0].firstChild.nodeValue;
            var descricaog = item.getElementsByTagName("descricaog")[0].firstChild.nodeValue;
            var descricaoh = item.getElementsByTagName("descricaoh")[0].firstChild.nodeValue;
            var descricaoi = item.getElementsByTagName("descricaoi")[0].firstChild.nodeValue;
            var descricaoid = item.getElementsByTagName("descricaoid")[0].firstChild.nodeValue;
            var descricaoj = item.getElementsByTagName("descricaoj")[0].firstChild.nodeValue;
            var descricaok = item.getElementsByTagName("descricaok")[0].firstChild.nodeValue;
            var descricaol = item.getElementsByTagName("descricaol")[0].firstChild.nodeValue;
            var descricaom = item.getElementsByTagName("descricaom")[0].firstChild.nodeValue;
            var descricaon = item.getElementsByTagName("descricaon")[0].firstChild.nodeValue;
            var descricaoo = item.getElementsByTagName("descricaoo")[0].firstChild.nodeValue;
            var descricaop = item.getElementsByTagName("descricaop")[0].firstChild.nodeValue;
            var descricaoq = item.getElementsByTagName("descricaoq")[0].firstChild.nodeValue;
            var descricaor = item.getElementsByTagName("descricaor")[0].firstChild.nodeValue;
            var descricaos = item.getElementsByTagName("descricaos")[0].firstChild.nodeValue;
            var descricaot = item.getElementsByTagName("descricaot")[0].firstChild.nodeValue;
            var descricaou = item.getElementsByTagName("descricaou")[0].firstChild.nodeValue;
            var descricaov = item.getElementsByTagName("descricaov")[0].firstChild.nodeValue;
            var descricaox = item.getElementsByTagName("descricaox")[0].firstChild.nodeValue;
            var descricaoz = item.getElementsByTagName("descricaoz")[0].firstChild.nodeValue;

            var codigo1 = item.getElementsByTagName("codigo1")[0].firstChild.nodeValue;
            var codigo2 = item.getElementsByTagName("codigo2")[0].firstChild.nodeValue;
            var codigo3 = item.getElementsByTagName("codigo3")[0].firstChild.nodeValue;
            var codigo4 = item.getElementsByTagName("codigo4")[0].firstChild.nodeValue;
            var codigo5 = item.getElementsByTagName("codigo5")[0].firstChild.nodeValue;
            var codigo6 = item.getElementsByTagName("codigo6")[0].firstChild.nodeValue;
            var codigo7 = item.getElementsByTagName("codigo7")[0].firstChild.nodeValue;
            var codigocor = item.getElementsByTagName("codigocor")[0].firstChild.nodeValue;
            var codigo8 = item.getElementsByTagName("codigo8")[0].firstChild.nodeValue;
            var codigo9 = item.getElementsByTagName("codigo9")[0].firstChild.nodeValue;
            var codigo10 = item.getElementsByTagName("codigo10")[0].firstChild.nodeValue;
            var codigo11 = item.getElementsByTagName("codigo11")[0].firstChild.nodeValue;
            var opcao1 = item.getElementsByTagName("opcao1")[0].firstChild.nodeValue;
            var opcao2 = item.getElementsByTagName("opcao2")[0].firstChild.nodeValue;
            var opcao3 = item.getElementsByTagName("opcao3")[0].firstChild.nodeValue;
            var opcao4 = item.getElementsByTagName("opcao4")[0].firstChild.nodeValue;
            var opcao5 = item.getElementsByTagName("opcao5")[0].firstChild.nodeValue;
            var opcao6 = item.getElementsByTagName("opcao6")[0].firstChild.nodeValue;
            var opcao7 = item.getElementsByTagName("opcao7")[0].firstChild.nodeValue;
            var opcao8 = item.getElementsByTagName("opcao8")[0].firstChild.nodeValue;
            var codigo12 = item.getElementsByTagName("codigo12")[0].firstChild.nodeValue;
            var descra = item.getElementsByTagName("descra")[0].firstChild.nodeValue;
            var descrb = item.getElementsByTagName("descrb")[0].firstChild.nodeValue;
            var descrc = item.getElementsByTagName("descrc")[0].firstChild.nodeValue;
            var descrcx = item.getElementsByTagName("descrcx")[0].firstChild.nodeValue;
            var descrd = item.getElementsByTagName("descrd")[0].firstChild.nodeValue;
            var descre = item.getElementsByTagName("descre")[0].firstChild.nodeValue;
            var descrf = item.getElementsByTagName("descrf")[0].firstChild.nodeValue;

            var proicms = item.getElementsByTagName("proicms")[0].firstChild.nodeValue;
            var procompra = item.getElementsByTagName("procompra")[0].firstChild.nodeValue;
            var prosubs = item.getElementsByTagName("prosubs")[0].firstChild.nodeValue;
            var expvtex = item.getElementsByTagName("expvtex")[0].firstChild.nodeValue;

            var proprocedencia = item.getElementsByTagName("proprocedencia")[0].firstChild.nodeValue;
            var prorealv = item.getElementsByTagName("prorealv")[0].firstChild.nodeValue;
            var profinalv = item.getElementsByTagName("profinalv")[0].firstChild.nodeValue;
            var proreall = item.getElementsByTagName("proreall")[0].firstChild.nodeValue;
            var profinall = item.getElementsByTagName("profinall")[0].firstChild.nodeValue;

            var prorealg = item.getElementsByTagName("prorealg")[0].firstChild.nodeValue;
            var profinalg = item.getElementsByTagName("profinalg")[0].firstChild.nodeValue;

            var protpsort = item.getElementsByTagName("protpsort")[0].firstChild.nodeValue;
            var promaster = item.getElementsByTagName("promaster")[0].firstChild.nodeValue;
            var mastercod = item.getElementsByTagName("mastercod")[0].firstChild.nodeValue;
            var masternom = item.getElementsByTagName("masternom")[0].firstChild.nodeValue;

            var proprecad = item.getElementsByTagName("proprecad")[0].firstChild.nodeValue;
            var prodtinicio = item.getElementsByTagName("prodtinicio")[0].firstChild.nodeValue;
            var prodtfinal = item.getElementsByTagName("prodtfinal")[0].firstChild.nodeValue;

            var vala1 = item.getElementsByTagName("vala1")[0].firstChild.nodeValue;
            var vala2 = item.getElementsByTagName("vala2")[0].firstChild.nodeValue;
            var vala3 = item.getElementsByTagName("vala3")[0].firstChild.nodeValue;
            var val1 = item.getElementsByTagName("val1")[0].firstChild.nodeValue;
            var val2 = item.getElementsByTagName("val2")[0].firstChild.nodeValue;
            var val3 = item.getElementsByTagName("val3")[0].firstChild.nodeValue;
            var data1 = item.getElementsByTagName("data1")[0].firstChild.nodeValue;
            var data2 = item.getElementsByTagName("data2")[0].firstChild.nodeValue;
            var data3 = item.getElementsByTagName("data3")[0].firstChild.nodeValue;
            var usunome1 = item.getElementsByTagName("usunome1")[0].firstChild.nodeValue;
            var usunome2 = item.getElementsByTagName("usunome2")[0].firstChild.nodeValue;
            var usunome3 = item.getElementsByTagName("usunome3")[0].firstChild.nodeValue;

            var vvala1 = item.getElementsByTagName("vvala1")[0].firstChild.nodeValue;
            var vvala2 = item.getElementsByTagName("vvala2")[0].firstChild.nodeValue;
            var vvala3 = item.getElementsByTagName("vvala3")[0].firstChild.nodeValue;
            var vval1 = item.getElementsByTagName("vval1")[0].firstChild.nodeValue;
            var vval2 = item.getElementsByTagName("vval2")[0].firstChild.nodeValue;
            var vval3 = item.getElementsByTagName("vval3")[0].firstChild.nodeValue;
            var vdata1 = item.getElementsByTagName("vdata1")[0].firstChild.nodeValue;
            var vdata2 = item.getElementsByTagName("vdata2")[0].firstChild.nodeValue;
            var vdata3 = item.getElementsByTagName("vdata3")[0].firstChild.nodeValue;
            var vusunome1 = item.getElementsByTagName("vusunome1")[0].firstChild.nodeValue;
            var vusunome2 = item.getElementsByTagName("vusunome2")[0].firstChild.nodeValue;
            var vusunome3 = item.getElementsByTagName("vusunome3")[0].firstChild.nodeValue;

            var lvala1 = item.getElementsByTagName("lvala1")[0].firstChild.nodeValue;
            var lvala2 = item.getElementsByTagName("lvala2")[0].firstChild.nodeValue;
            var lvala3 = item.getElementsByTagName("lvala3")[0].firstChild.nodeValue;
            var lval1 = item.getElementsByTagName("lval1")[0].firstChild.nodeValue;
            var lval2 = item.getElementsByTagName("lval2")[0].firstChild.nodeValue;
            var lval3 = item.getElementsByTagName("lval3")[0].firstChild.nodeValue;
            var ldata1 = item.getElementsByTagName("ldata1")[0].firstChild.nodeValue;
            var ldata2 = item.getElementsByTagName("ldata2")[0].firstChild.nodeValue;
            var ldata3 = item.getElementsByTagName("ldata3")[0].firstChild.nodeValue;
            var lusunome1 = item.getElementsByTagName("lusunome1")[0].firstChild.nodeValue;
            var lusunome2 = item.getElementsByTagName("lusunome2")[0].firstChild.nodeValue;
            var lusunome3 = item.getElementsByTagName("lusunome3")[0].firstChild.nodeValue;


            var gvala1 = item.getElementsByTagName("gvala1")[0].firstChild.nodeValue;
            var gvala2 = item.getElementsByTagName("gvala2")[0].firstChild.nodeValue;
            var gvala3 = item.getElementsByTagName("gvala3")[0].firstChild.nodeValue;
            var gval1 = item.getElementsByTagName("gval1")[0].firstChild.nodeValue;
            var gval2 = item.getElementsByTagName("gval2")[0].firstChild.nodeValue;
            var gval3 = item.getElementsByTagName("gval3")[0].firstChild.nodeValue;
            var gdata1 = item.getElementsByTagName("gdata1")[0].firstChild.nodeValue;
            var gdata2 = item.getElementsByTagName("gdata2")[0].firstChild.nodeValue;
            var gdata3 = item.getElementsByTagName("gdata3")[0].firstChild.nodeValue;
            var gusunome1 = item.getElementsByTagName("gusunome1")[0].firstChild.nodeValue;
            var gusunome2 = item.getElementsByTagName("gusunome2")[0].firstChild.nodeValue;
            var gusunome3 = item.getElementsByTagName("gusunome3")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;
            trimjs(descricao2);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao2 = txt;
            trimjs(descricaob);
            descricaob = txt;
            trimjs(descricaod);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaod = txt;
            trimjs(descricaoe);
            descricaoe = txt;
            trimjs(descricaof);
            descricaof = txt;
            trimjs(descricaog);
            descricaog = txt;
            trimjs(descricaoh);
            descricaoh = txt;
            trimjs(descricaoi);
            descricaoi = txt;
            trimjs(descricaoid);
            descricaoid = txt;
            trimjs(descricaoj);
            descricaoj = txt;
            trimjs(descricaok);
            descricaok = txt;
            trimjs(descricaol);
            descricaol = txt;
            trimjs(descricaom);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaom = txt;
            trimjs(descricaon);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaon = txt;
            trimjs(descricaoo);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoo = txt;
            trimjs(descricaop);
            descricaop = txt;
            trimjs(descricaoq);
            descricaoq = txt;
            trimjs(descricaor);
            descricaor = txt;
            trimjs(descricaos);
            descricaos = txt;
            trimjs(descricaot);
            descricaot = txt;
            trimjs(descricaou);
            descricaou = txt;
            trimjs(descricaov);
            descricaov = txt;
            trimjs(descricaox);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaox = txt;
            trimjs(descricaoz);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoz = txt;
            trimjs(codigo1);
            codigo1 = txt;
            trimjs(codigo2);
            codigo2 = txt;
            trimjs(codigo3);
            codigo3 = txt;
            trimjs(codigo4);
            codigo4 = txt;
            trimjs(codigo5);
            codigo5 = txt;
            trimjs(codigo6);
            codigo6 = txt;
            trimjs(codigo7);
            codigo7 = txt;
            trimjs(codigocor);
            codigocor = txt;
            trimjs(codigo8);
            codigo8 = txt;
            trimjs(codigo9);
            codigo9 = txt;
            trimjs(codigo10);
            codigo10 = txt;
            trimjs(codigo11);
            codigo11 = txt;
            trimjs(codigo12);
            codigo12 = txt;
            trimjs(opcao1);
            opcao1 = txt;
            trimjs(opcao2);
            opcao2 = txt;
            trimjs(opcao3);
            opcao3 = txt;
            trimjs(opcao4);
            opcao4 = txt;
            trimjs(opcao5);
            opcao5 = txt;
            trimjs(opcao6);
            opcao6 = txt;
            trimjs(opcao7);
            opcao7 = txt;
            trimjs(opcao8);
            opcao8 = txt;
            trimjs(descra);
            descra = txt;
            trimjs(descrb);
            descrb = txt;
            trimjs(descrc);
            descrc = txt;
            trimjs(descrcx);
            descrcx = txt;
            trimjs(descrd);
            descrd = txt;
            trimjs(descre);
            descre = txt;
            trimjs(descrf);
            descrf = txt;

            trimjs(proicms);
            proicms = txt;
            trimjs(procompra);
            procompra = txt;
            trimjs(prosubs);
            prosubs = txt;
            trimjs(expvtex);
            expvtex = txt;

            trimjs(prorealv);
            prorealv = txt;
            trimjs(profinalv);
            profinalv = txt;
            trimjs(proreall);
            proreall = txt;
            trimjs(profinall);
            profinall = txt;

            trimjs(prorealg);
            prorealg = txt;
            trimjs(profinalg);
            profinalg = txt;

            trimjs(proprocedencia);
            if (txt == '0') {
                txt = '1';
            }
            ;
            proprocedencia = txt;

            trimjs(prodtinicio);
            if (txt == '0') {
                txt = '';
            }
            ;
            prodtinicio = txt;
            trimjs(prodtfinal);
            if (txt == '0') {
                txt = '';
            }
            ;
            prodtfinal = txt;


            trimjs(vala1);
            if (txt == '0') {
                txt = '';
            }
            ;
            vala1 = txt;
            trimjs(vala2);
            if (txt == '0') {
                txt = '';
            }
            ;
            vala2 = txt;
            trimjs(vala3);
            if (txt == '0') {
                txt = '';
            }
            ;
            vala3 = txt;
            trimjs(val1);
            if (txt == '0') {
                txt = '';
            }
            ;
            val1 = txt;
            trimjs(val2);
            if (txt == '0') {
                txt = '';
            }
            ;
            val2 = txt;
            trimjs(val3);
            if (txt == '0') {
                txt = '';
            }
            ;
            val3 = txt;
            trimjs(data1);
            if (txt == '0') {
                txt = '';
            }
            ;
            data1 = txt;
            trimjs(data2);
            if (txt == '0') {
                txt = '';
            }
            ;
            data2 = txt;
            trimjs(data3);
            if (txt == '0') {
                txt = '';
            }
            ;
            data3 = txt;
            trimjs(usunome1);
            if (txt == '0') {
                txt = '';
            }
            ;
            usunome1 = txt;
            trimjs(usunome2);
            if (txt == '0') {
                txt = '';
            }
            ;
            usunome2 = txt;
            trimjs(usunome3);
            if (txt == '0') {
                txt = '';
            }
            ;
            usunome3 = txt;

            trimjs(vvala1);
            if (txt == '0') {
                txt = '';
            }
            ;
            vvala1 = txt;
            trimjs(vvala2);
            if (txt == '0') {
                txt = '';
            }
            ;
            vvala2 = txt;
            trimjs(vvala3);
            if (txt == '0') {
                txt = '';
            }
            ;
            vvala3 = txt;
            trimjs(vval1);
            if (txt == '0') {
                txt = '';
            }
            ;
            vval1 = txt;
            trimjs(vval2);
            if (txt == '0') {
                txt = '';
            }
            ;
            vval2 = txt;
            trimjs(vval3);
            if (txt == '0') {
                txt = '';
            }
            ;
            vval3 = txt;
            trimjs(vdata1);
            if (txt == '0') {
                txt = '';
            }
            ;
            vdata1 = txt;
            trimjs(vdata2);
            if (txt == '0') {
                txt = '';
            }
            ;
            vdata2 = txt;
            trimjs(vdata3);
            if (txt == '0') {
                txt = '';
            }
            ;
            vdata3 = txt;
            trimjs(vusunome1);
            if (txt == '0') {
                txt = '';
            }
            ;
            vusunome1 = txt;
            trimjs(vusunome2);
            if (txt == '0') {
                txt = '';
            }
            ;
            vusunome2 = txt;
            trimjs(vusunome3);
            if (txt == '0') {
                txt = '';
            }
            ;
            vusunome3 = txt;

            trimjs(lvala1);
            if (txt == '0') {
                txt = '';
            }
            ;
            lvala1 = txt;
            trimjs(lvala2);
            if (txt == '0') {
                txt = '';
            }
            ;
            lvala2 = txt;
            trimjs(lvala3);
            if (txt == '0') {
                txt = '';
            }
            ;
            lvala3 = txt;
            trimjs(lval1);
            if (txt == '0') {
                txt = '';
            }
            ;
            lval1 = txt;
            trimjs(lval2);
            if (txt == '0') {
                txt = '';
            }
            ;
            lval2 = txt;
            trimjs(lval3);
            if (txt == '0') {
                txt = '';
            }
            ;
            lval3 = txt;
            trimjs(ldata1);
            if (txt == '0') {
                txt = '';
            }
            ;
            ldata1 = txt;
            trimjs(ldata2);
            if (txt == '0') {
                txt = '';
            }
            ;
            ldata2 = txt;
            trimjs(ldata3);
            if (txt == '0') {
                txt = '';
            }
            ;
            ldata3 = txt;
            trimjs(lusunome1);
            if (txt == '0') {
                txt = '';
            }
            ;
            lusunome1 = txt;
            trimjs(lusunome2);
            if (txt == '0') {
                txt = '';
            }
            ;
            lusunome2 = txt;
            trimjs(lusunome3);
            if (txt == '0') {
                txt = '';
            }
            ;
            lusunome3 = txt;


            trimjs(gvala1);
            if (txt == '0') {
                txt = '';
            }
            ;
            gvala1 = txt;
            trimjs(gvala2);
            if (txt == '0') {
                txt = '';
            }
            ;
            gvala2 = txt;
            trimjs(gvala3);
            if (txt == '0') {
                txt = '';
            }
            ;
            gvala3 = txt;
            trimjs(gval1);
            if (txt == '0') {
                txt = '';
            }
            ;
            gval1 = txt;
            trimjs(gval2);
            if (txt == '0') {
                txt = '';
            }
            ;
            gval2 = txt;
            trimjs(gval3);
            if (txt == '0') {
                txt = '';
            }
            ;
            gval3 = txt;
            trimjs(gdata1);
            if (txt == '0') {
                txt = '';
            }
            ;
            gdata1 = txt;
            trimjs(gdata2);
            if (txt == '0') {
                txt = '';
            }
            ;
            gdata2 = txt;
            trimjs(gdata3);
            if (txt == '0') {
                txt = '';
            }
            ;
            gdata3 = txt;
            trimjs(gusunome1);
            if (txt == '0') {
                txt = '';
            }
            ;
            gusunome1 = txt;
            trimjs(gusunome2);
            if (txt == '0') {
                txt = '';
            }
            ;
            gusunome2 = txt;
            trimjs(gusunome3);
            if (txt == '0') {
                txt = '';
            }
            ;
            gusunome3 = txt;


            //cria um novo option dinamicamente
            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto

            if (document.getElementById("radio1").checked == true) {
                novo.text = descricaob + ' ' + descricao;
            } else if (document.getElementById("radio2").checked == true) {
                novo.text = descricaob + ' ' + descricao;
            } else {
                novo.text = descricaod + ' ' + descricao;
            }

            //finalmente adiciona o novo elemento
            document.forms[0].listDados.options.add(novo);

            if (i == 0)
            {

                //Se for Pre-Cadastro libera a alteracao da Unidade
                if (proprecad == 1) {
                    document.formulario.listmedidas.disabled = false;
                }

                $("procodigo").value = codigo;
                $("prnome").value = descricao;
                $("prnome2").value = descricao2;
                $("procod").value = descricaob;
                $("proref").value = descricaod;
                $("proemb").value = descricaoe;
                $("proipi").value = descricaof;
                $("promedio").value = descricaog;
                $("promaior").value = descricaoh;
                $("promenor").value = descricaoi;
                $("promenord").value = descricaoid;
                $("prominimo").value = descricaoj;
                $("proreal").value = descricaok;
                custo1 = descricaok;
                $("profinal").value = descricaol;
                $("prorealv").value = prorealv;
                custov1 = prorealv;
                $("profinalv").value = profinalv;
                $("proreall").value = proreall;
                custol1 = proreall;

                $("profinalg").value = profinalg;
                $("prorealg").value = prorealg;
                custog1 = prorealg;

                $("profinall").value = profinall;
                $("prodesc1").value = descricaom;
                $("prodesc2").value = descricaon;
                $("prodesc3").value = descricaoo;
                $("proaltura").value = descricaop;
                $("prolargura").value = descricaoq;
                $("procompr").value = descricaor;
                $("propeso").value = descricaos;
                $("properc").value = descricaot;
                $("proval").value = descricaou;
                $("proacres").value = descricaov;
                $("prodescs").value = descricaox;
                $("procarac").value = descricaoz;

                $("datainicio").value = prodtinicio;
                $("datafinal").value = prodtfinal;

                //itemcombosubgrupo(codigo2);
                //itemcombolinha(codigo5);

                itemcombomarca(codigo3);
                itemcombosubmarca(codigo4);
                itemcombostatus(codigo6);
                itemcombofaixa(codigo7);
                itemcombocores(codigocor);
                itemcombomedida(codigo8);
                itemcombotributo1(codigo9);
                itemcombotributo2(codigo10);
                itemcombofiscal(codigo11);
                itemcomboproprocedencia(proprocedencia);

                if (opcao1 == 'U') {
                    document.getElementById("radio21").checked = true;
                } else if (opcao1 == 'M') {
                    document.getElementById("radio22").checked = true;
                } else {
                    document.getElementById("radio23").checked = true;
                }
                if (opcao2 == 'S') {
                    document.getElementById("radio31").checked = true;
                } else {
                    document.getElementById("radio32").checked = true;
                }
                if (opcao3 == 'S') {
                    document.getElementById("radio41").checked = true;
                } else {
                    document.getElementById("radio42").checked = true;
                }
                if (opcao4 == 'S') {
                    document.getElementById("radio51").checked = true;
                } else {
                    document.getElementById("radio52").checked = true;
                }
                if (opcao5 == 'S') {
                    document.getElementById("radio61").checked = true;
                } else {
                    document.getElementById("radio62").checked = true;
                }
                if (opcao6 == 'S') {
                    document.getElementById("radio71").checked = true;
                } else {
                    document.getElementById("radio72").checked = true;
                }
                if (opcao7 == 'S') {
                    document.getElementById("radio81").checked = true;
                } else {
                    document.getElementById("radio82").checked = true;
                }
                if (opcao8 == 'S') {
                    document.getElementById("radio91").checked = true;
                } else {
                    document.getElementById("radio92").checked = true;
                }

                if (proicms == '2') {
                    document.getElementById("radioicmsn").checked = true;
                } else if (proicms == '3') {
                    document.getElementById("radioicmse").checked = true;
                } else {
                    document.getElementById("radioicmss").checked = true;
                }

                if (expvtex == '1') {
                    document.getElementById("radiosts").checked = true;
                } else {
                    document.getElementById("radiostn").checked = true;
                }

                if (procompra == '2') {
                    document.getElementById("radiocomprap").checked = true;
                } else if (procompra == '3') {
                    document.getElementById("radiocomprac").checked = true;
                } else {
                    document.getElementById("radiocompran").checked = true;
                }

                itemcombofornecedor(codigo12);
                $("proaltcx").value = descra;
                $("prolarcx").value = descrb;
                $("procomcx").value = descrc;
                $("procubcx").value = descrcx;
                $("propescx").value = descrd;
                $("barunidade").value = descre;
                $("barcaixa").value = descrf;
                calculapreco($("proreal").value, $("promedio").value, $("promaior").value, $("promenor").value, $("prominimo").value, $("promenord").value);
                dadosfiscal(codigo11);

                $("custoa1").value = vala1;
                $("custoa2").value = vala2;
                $("custoa3").value = vala3;
                $("custo1").value = val1;
                $("custo2").value = val2;
                $("custo3").value = val3;
                $("data1").value = data1;
                $("data2").value = data2;
                $("data3").value = data3;
                $("usuario1").value = usunome1;
                $("usuario2").value = usunome2;
                $("usuario3").value = usunome3;

                $("vcustoa1").value = vvala1;
                $("vcustoa2").value = vvala2;
                $("vcustoa3").value = vvala3;
                $("vcusto1").value = vval1;
                $("vcusto2").value = vval2;
                $("vcusto3").value = vval3;
                $("vdata1").value = vdata1;
                $("vdata2").value = vdata2;
                $("vdata3").value = vdata3;
                $("vusuario1").value = vusunome1;
                $("vusuario2").value = vusunome2;
                $("vusuario3").value = vusunome3;

                $("lcustoa1").value = lvala1;
                $("lcustoa2").value = lvala2;
                $("lcustoa3").value = lvala3;
                $("lcusto1").value = lval1;
                $("lcusto2").value = lval2;
                $("lcusto3").value = lval3;
                $("ldata1").value = ldata1;
                $("ldata2").value = ldata2;
                $("ldata3").value = ldata3;
                $("lusuario1").value = lusunome1;
                $("lusuario2").value = lusunome2;
                $("lusuario3").value = lusunome3;


                $("gcustoa1").value = gvala1;
                $("gcustoa2").value = gvala2;
                $("gcustoa3").value = gvala3;
                $("gcusto1").value = gval1;
                $("gcusto2").value = gval2;
                $("gcusto3").value = gval3;
                $("gdata1").value = gdata1;
                $("gdata2").value = gdata2;
                $("gdata3").value = gdata3;
                $("gusuario1").value = gusunome1;
                $("gusuario2").value = gusunome2;
                $("gusuario3").value = gusunome3;


                if (protpsort == '1') {
                    document.getElementById("radiosorts").checked = true;
                    promaster == '0';
                } else if (protpsort == '2') {
                    document.getElementById("radiosortn").checked = true;
                    promaster == '0';
                } else if (protpsort == '3') {
                    document.getElementById("radiosorte").checked = true;
                }

                if (promaster == '0') {

                    $("sortprocodigo").value = "";
                    $("sortprnome").value = "";
                    $("sortprocod").value = "";
                    $("sortpesquisa").value = "";

                    $("sortradio1").disabled = true;
                    $("sortradio2").disabled = true;
                    $("sortradio3").disabled = true;
                    $("sortpesquisa").disabled = true;
                    $("sortbutton").disabled = true;
                    $("sortlistDados").disabled = true;

                    document.getElementById("sortradio1").checked = true;

                    document.forms[0].sortlistDados.options.length = 1;
                    idOpcao = document.getElementById("sortopcoes");
                    idOpcao.innerHTML = "____________________";

                } else {

                    $("sortprocodigo").value = promaster;
                    $("sortprnome").value = masternom;
                    $("sortprocod").value = mastercod;
                    $("sortpesquisa").value = "";

                    $("sortradio1").disabled = false;
                    $("sortradio2").disabled = false;
                    $("sortradio3").disabled = false;
                    $("sortpesquisa").disabled = false;
                    $("sortbutton").disabled = false;
                    $("sortlistDados").disabled = false;

                    document.getElementById("sortradio1").checked = true;

                    document.forms[0].sortlistDados.options.length = 1;
                    idOpcao = document.getElementById("sortopcoes");
                    idOpcao.innerHTML = "____________________";

                }

                mostrarimagem(descricaob, descricaoo, 1, codigo1, codigo2, codigo5);

                //itemcombogrupo(codigo1,codigo2,codigo5);

                $("acao").value = "alterar";
                $("botao").value = "Alterar";
            }
        }
        $('MsgResultado').innerHTML = "";
        $('MsgResultado2').innerHTML = "";
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo
        $("procodigo").value = "";
        $("prnome").value = "";
        $("prnome2").value = "";
        $("procod").value = "";
        $("proref").value = "";
        $("proemb").value = "";
        $("proipi").value = "";
        $("datainicio").value = "";
        $("datafinal").value = "";
        $("promedio").value = "";
        $("promaior").value = "";
        $("promenor").value = "";
        $("promenord").value = "";
        $("prominimo").value = "";
        $("proreal").value = "";
        $("profinal").value = "";
        $("prorealv").value = "";
        $("profinalv").value = "";
        $("proreall").value = "";
        $("profinall").value = "";

        $("prorealg").value = "";
        $("profinalg").value = "";

        $("prodesc1").value = "";
        $("prodesc2").value = "";
        $("prodesc3").value = "";
        $("proaltura").value = "";
        $("prolargura").value = "";
        $("procompr").value = "";
        $("propeso").value = "";
        $("properc").value = "";
        $("proval").value = "";
        $("proacres").value = "";
        $("prodescs").value = "";
        $("procarac").value = "";
        $("proaltcx").value = "";
        $("prolarcx").value = "";
        $("procomcx").value = "";
        $("procubcx").value = "";
        $("propescx").value = "";
        $("barunidade").value = "";
        $("barcaixa").value = "";

        $("custoa1").value = "";
        $("custoa2").value = "";
        $("custoa3").value = "";
        $("custo1").value = "";
        $("custo2").value = "";
        $("custo3").value = "";
        $("data1").value = "";
        $("data2").value = "";
        $("data3").value = "";
        $("usuario1").value = "";
        $("usuario2").value = "";
        $("usuario3").value = "";

        $("vcustoa1").value = "";
        $("vcustoa2").value = "";
        $("vcustoa3").value = "";
        $("vcusto1").value = "";
        $("vcusto2").value = "";
        $("vcusto3").value = "";
        $("vdata1").value = "";
        $("vdata2").value = "";
        $("vdata3").value = "";
        $("vusuario1").value = "";
        $("vusuario2").value = "";
        $("vusuario3").value = "";

        $("lcustoa1").value = "";
        $("lcustoa2").value = "";
        $("lcustoa3").value = "";
        $("lcusto1").value = "";
        $("lcusto2").value = "";
        $("lcusto3").value = "";
        $("ldata1").value = "";
        $("ldata2").value = "";
        $("ldata3").value = "";
        $("lusuario1").value = "";
        $("lusuario2").value = "";
        $("lusuario3").value = "";

        $("gcustoa1").value = "";
        $("gcustoa2").value = "";
        $("gcustoa3").value = "";
        $("gcusto1").value = "";
        $("gcusto2").value = "";
        $("gcusto3").value = "";
        $("gdata1").value = "";
        $("gdata2").value = "";
        $("gdata3").value = "";
        $("gusuario1").value = "";
        $("gusuario2").value = "";
        $("gusuario3").value = "";


        $("acao").value = "inserir";
        $("botao").value = "Incluir";

        idOpcao.innerHTML = "____________________";

        var img = document.getElementById('imagem');
        img.setAttribute("src", "./produtos/figura0.jpg");

        $('MsgResultado').innerHTML = "";
        $('MsgResultado2').innerHTML = "";
    }
}

function processXML2(obj)
{

    custo1 = 0;
    custov1 = 0;
    custol1 = 0;

    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados
        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
            var descricao2 = item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;
            var descricaob = item.getElementsByTagName("descricaob")[0].firstChild.nodeValue;
            var descricaod = item.getElementsByTagName("descricaod")[0].firstChild.nodeValue;
            var descricaoe = item.getElementsByTagName("descricaoe")[0].firstChild.nodeValue;
            var descricaof = item.getElementsByTagName("descricaof")[0].firstChild.nodeValue;
            var descricaog = item.getElementsByTagName("descricaog")[0].firstChild.nodeValue;
            var descricaoh = item.getElementsByTagName("descricaoh")[0].firstChild.nodeValue;
            var descricaoi = item.getElementsByTagName("descricaoi")[0].firstChild.nodeValue;
            var descricaoid = item.getElementsByTagName("descricaoid")[0].firstChild.nodeValue;
            var descricaoj = item.getElementsByTagName("descricaoj")[0].firstChild.nodeValue;
            var descricaok = item.getElementsByTagName("descricaok")[0].firstChild.nodeValue;
            var descricaol = item.getElementsByTagName("descricaol")[0].firstChild.nodeValue;
            var descricaom = item.getElementsByTagName("descricaom")[0].firstChild.nodeValue;
            var descricaon = item.getElementsByTagName("descricaon")[0].firstChild.nodeValue;
            var descricaoo = item.getElementsByTagName("descricaoo")[0].firstChild.nodeValue;
            var descricaop = item.getElementsByTagName("descricaop")[0].firstChild.nodeValue;
            var descricaoq = item.getElementsByTagName("descricaoq")[0].firstChild.nodeValue;
            var descricaor = item.getElementsByTagName("descricaor")[0].firstChild.nodeValue;
            var descricaos = item.getElementsByTagName("descricaos")[0].firstChild.nodeValue;
            var descricaot = item.getElementsByTagName("descricaot")[0].firstChild.nodeValue;
            var descricaou = item.getElementsByTagName("descricaou")[0].firstChild.nodeValue;
            var descricaov = item.getElementsByTagName("descricaov")[0].firstChild.nodeValue;
            var descricaox = item.getElementsByTagName("descricaox")[0].firstChild.nodeValue;
            var descricaoz = item.getElementsByTagName("descricaoz")[0].firstChild.nodeValue;

            var codigo1 = item.getElementsByTagName("codigo1")[0].firstChild.nodeValue;
            var codigo2 = item.getElementsByTagName("codigo2")[0].firstChild.nodeValue;
            var codigo3 = item.getElementsByTagName("codigo3")[0].firstChild.nodeValue;
            var codigo4 = item.getElementsByTagName("codigo4")[0].firstChild.nodeValue;
            var codigo5 = item.getElementsByTagName("codigo5")[0].firstChild.nodeValue;
            var codigo6 = item.getElementsByTagName("codigo6")[0].firstChild.nodeValue;
            var codigo7 = item.getElementsByTagName("codigo7")[0].firstChild.nodeValue;
            var codigocor = item.getElementsByTagName("codigocor")[0].firstChild.nodeValue;
            var codigo8 = item.getElementsByTagName("codigo8")[0].firstChild.nodeValue;
            var codigo9 = item.getElementsByTagName("codigo9")[0].firstChild.nodeValue;
            var codigo10 = item.getElementsByTagName("codigo10")[0].firstChild.nodeValue;
            var codigo11 = item.getElementsByTagName("codigo11")[0].firstChild.nodeValue;
            var opcao1 = item.getElementsByTagName("opcao1")[0].firstChild.nodeValue;
            var opcao2 = item.getElementsByTagName("opcao2")[0].firstChild.nodeValue;
            var opcao3 = item.getElementsByTagName("opcao3")[0].firstChild.nodeValue;
            var opcao4 = item.getElementsByTagName("opcao4")[0].firstChild.nodeValue;
            var opcao5 = item.getElementsByTagName("opcao5")[0].firstChild.nodeValue;
            var opcao6 = item.getElementsByTagName("opcao6")[0].firstChild.nodeValue;
            var opcao7 = item.getElementsByTagName("opcao7")[0].firstChild.nodeValue;
            var opcao8 = item.getElementsByTagName("opcao8")[0].firstChild.nodeValue;
            var codigo12 = item.getElementsByTagName("codigo12")[0].firstChild.nodeValue;
            var descra = item.getElementsByTagName("descra")[0].firstChild.nodeValue;
            var descrb = item.getElementsByTagName("descrb")[0].firstChild.nodeValue;
            var descrc = item.getElementsByTagName("descrc")[0].firstChild.nodeValue;
            var descrcx = item.getElementsByTagName("descrcx")[0].firstChild.nodeValue;
            var descrd = item.getElementsByTagName("descrd")[0].firstChild.nodeValue;
            var descre = item.getElementsByTagName("descre")[0].firstChild.nodeValue;
            var descrf = item.getElementsByTagName("descrf")[0].firstChild.nodeValue;

            var proicms = item.getElementsByTagName("proicms")[0].firstChild.nodeValue;
            var procompra = item.getElementsByTagName("procompra")[0].firstChild.nodeValue;
            var prosubs = item.getElementsByTagName("prosubs")[0].firstChild.nodeValue;
            var expvtex = item.getElementsByTagName("expvtex")[0].firstChild.nodeValue;
            var prorealv = item.getElementsByTagName("prorealv")[0].firstChild.nodeValue;
            var profinalv = item.getElementsByTagName("profinalv")[0].firstChild.nodeValue;
            var proreall = item.getElementsByTagName("proreall")[0].firstChild.nodeValue;
            var profinall = item.getElementsByTagName("profinall")[0].firstChild.nodeValue;

            var prorealg = item.getElementsByTagName("prorealg")[0].firstChild.nodeValue;
            var profinalg = item.getElementsByTagName("profinalg")[0].firstChild.nodeValue;

            var protpsort = item.getElementsByTagName("protpsort")[0].firstChild.nodeValue;
            var promaster = item.getElementsByTagName("promaster")[0].firstChild.nodeValue;
            var mastercod = item.getElementsByTagName("mastercod")[0].firstChild.nodeValue;
            var masternom = item.getElementsByTagName("masternom")[0].firstChild.nodeValue;

            var proprocedencia = item.getElementsByTagName("proprocedencia")[0].firstChild.nodeValue;

            var vala1 = item.getElementsByTagName("vala1")[0].firstChild.nodeValue;
            var vala2 = item.getElementsByTagName("vala2")[0].firstChild.nodeValue;
            var vala3 = item.getElementsByTagName("vala3")[0].firstChild.nodeValue;
            var val1 = item.getElementsByTagName("val1")[0].firstChild.nodeValue;
            var val2 = item.getElementsByTagName("val2")[0].firstChild.nodeValue;
            var val3 = item.getElementsByTagName("val3")[0].firstChild.nodeValue;
            var data1 = item.getElementsByTagName("data1")[0].firstChild.nodeValue;
            var data2 = item.getElementsByTagName("data2")[0].firstChild.nodeValue;
            var data3 = item.getElementsByTagName("data3")[0].firstChild.nodeValue;
            var usunome1 = item.getElementsByTagName("usunome1")[0].firstChild.nodeValue;
            var usunome2 = item.getElementsByTagName("usunome2")[0].firstChild.nodeValue;
            var usunome3 = item.getElementsByTagName("usunome3")[0].firstChild.nodeValue;

            var prodtinicio = item.getElementsByTagName("prodtinicio")[0].firstChild.nodeValue;
            var prodtfinal = item.getElementsByTagName("prodtfinal")[0].firstChild.nodeValue;

            var vvala1 = item.getElementsByTagName("vvala1")[0].firstChild.nodeValue;
            var vvala2 = item.getElementsByTagName("vvala2")[0].firstChild.nodeValue;
            var vvala3 = item.getElementsByTagName("vvala3")[0].firstChild.nodeValue;
            var vval1 = item.getElementsByTagName("vval1")[0].firstChild.nodeValue;
            var vval2 = item.getElementsByTagName("vval2")[0].firstChild.nodeValue;
            var vval3 = item.getElementsByTagName("vval3")[0].firstChild.nodeValue;
            var vdata1 = item.getElementsByTagName("vdata1")[0].firstChild.nodeValue;
            var vdata2 = item.getElementsByTagName("vdata2")[0].firstChild.nodeValue;
            var vdata3 = item.getElementsByTagName("vdata3")[0].firstChild.nodeValue;
            var vusunome1 = item.getElementsByTagName("vusunome1")[0].firstChild.nodeValue;
            var vusunome2 = item.getElementsByTagName("vusunome2")[0].firstChild.nodeValue;
            var vusunome3 = item.getElementsByTagName("vusunome3")[0].firstChild.nodeValue;

            var lvala1 = item.getElementsByTagName("lvala1")[0].firstChild.nodeValue;
            var lvala2 = item.getElementsByTagName("lvala2")[0].firstChild.nodeValue;
            var lvala3 = item.getElementsByTagName("lvala3")[0].firstChild.nodeValue;
            var lval1 = item.getElementsByTagName("lval1")[0].firstChild.nodeValue;
            var lval2 = item.getElementsByTagName("lval2")[0].firstChild.nodeValue;
            var lval3 = item.getElementsByTagName("lval3")[0].firstChild.nodeValue;
            var ldata1 = item.getElementsByTagName("ldata1")[0].firstChild.nodeValue;
            var ldata2 = item.getElementsByTagName("ldata2")[0].firstChild.nodeValue;
            var ldata3 = item.getElementsByTagName("ldata3")[0].firstChild.nodeValue;
            var lusunome1 = item.getElementsByTagName("lusunome1")[0].firstChild.nodeValue;
            var lusunome2 = item.getElementsByTagName("lusunome2")[0].firstChild.nodeValue;
            var lusunome3 = item.getElementsByTagName("lusunome3")[0].firstChild.nodeValue;

            var gvala1 = item.getElementsByTagName("gvala1")[0].firstChild.nodeValue;
            var gvala2 = item.getElementsByTagName("gvala2")[0].firstChild.nodeValue;
            var gvala3 = item.getElementsByTagName("gvala3")[0].firstChild.nodeValue;
            var gval1 = item.getElementsByTagName("gval1")[0].firstChild.nodeValue;
            var gval2 = item.getElementsByTagName("gval2")[0].firstChild.nodeValue;
            var gval3 = item.getElementsByTagName("gval3")[0].firstChild.nodeValue;
            var gdata1 = item.getElementsByTagName("gdata1")[0].firstChild.nodeValue;
            var gdata2 = item.getElementsByTagName("gdata2")[0].firstChild.nodeValue;
            var gdata3 = item.getElementsByTagName("gdata3")[0].firstChild.nodeValue;
            var gusunome1 = item.getElementsByTagName("gusunome1")[0].firstChild.nodeValue;
            var gusunome2 = item.getElementsByTagName("gusunome2")[0].firstChild.nodeValue;
            var gusunome3 = item.getElementsByTagName("gusunome3")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;
            trimjs(descricao2);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao2 = txt;
            trimjs(descricaob);
            descricaob = txt;
            trimjs(descricaod);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaod = txt;
            trimjs(descricaoe);
            descricaoe = txt;
            trimjs(descricaof);
            descricaof = txt;
            trimjs(descricaog);
            descricaog = txt;
            trimjs(descricaoh);
            descricaoh = txt;
            trimjs(descricaoi);
            descricaoi = txt;
            trimjs(descricaoid);
            descricaoid = txt;
            trimjs(descricaoj);
            descricaoj = txt;
            trimjs(descricaok);
            descricaok = txt;
            trimjs(descricaol);
            descricaol = txt;
            trimjs(descricaom);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaom = txt;
            trimjs(descricaon);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaon = txt;
            trimjs(descricaoo);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoo = txt;
            trimjs(descricaop);
            descricaop = txt;
            trimjs(descricaoq);
            descricaoq = txt;
            trimjs(descricaor);
            descricaor = txt;
            trimjs(descricaos);
            descricaos = txt;
            trimjs(descricaot);
            descricaot = txt;
            trimjs(descricaou);
            descricaou = txt;
            trimjs(descricaov);
            descricaov = txt;
            trimjs(descricaox);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaox = txt;
            trimjs(descricaoz);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoz = txt;
            trimjs(codigo1);
            codigo1 = txt;
            trimjs(codigo2);
            codigo2 = txt;
            trimjs(codigo3);
            codigo3 = txt;
            trimjs(codigo4);
            codigo4 = txt;
            trimjs(codigo5);
            codigo5 = txt;
            trimjs(codigo6);
            codigo6 = txt;
            trimjs(codigo7);
            codigo7 = txt;
            trimjs(codigocor);
            codigocor = txt;
            trimjs(codigo8);
            codigo8 = txt;
            trimjs(codigo9);
            codigo9 = txt;
            trimjs(codigo10);
            codigo10 = txt;
            trimjs(codigo11);
            codigo11 = txt;
            trimjs(codigo12);
            codigo12 = txt;
            trimjs(opcao1);
            opcao1 = txt;
            trimjs(opcao2);
            opcao2 = txt;
            trimjs(opcao3);
            opcao3 = txt;
            trimjs(opcao4);
            opcao4 = txt;
            trimjs(opcao5);
            opcao5 = txt;
            trimjs(opcao6);
            opcao6 = txt;
            trimjs(opcao7);
            opcao7 = txt;
            trimjs(opcao8);
            opcao8 = txt;
            trimjs(descra);
            descra = txt;
            trimjs(descrb);
            descrb = txt;
            trimjs(descrc);
            descrc = txt;
            trimjs(descrcx);
            descrcx = txt;
            trimjs(descrd);
            descrd = txt;
            trimjs(descre);
            descre = txt;
            trimjs(descrf);
            descrf = txt;

            trimjs(proicms);
            proicms = txt;
            trimjs(procompra);
            procompra = txt;
            trimjs(prosubs);
            prosubs = txt;
            trimjs(expvtex);
            expvtex = txt;
            trimjs(prorealv);
            prorealv = txt;
            trimjs(profinalv);
            profinalv = txt;
            trimjs(proreall);
            proreall = txt;
            trimjs(profinall);
            profinall = txt;

            trimjs(prorealg);
            prorealg = txt;
            trimjs(profinalg);
            profinalg = txt;

            trimjs(proprocedencia);
            if (txt == '0') {
                txt = '1';
            }
            ;
            proprocedencia = txt;

            trimjs(prodtinicio);
            if (txt == '0') {
                txt = '';
            }
            ;
            prodtinicio = txt;
            trimjs(prodtfinal);
            if (txt == '0') {
                txt = '';
            }
            ;
            prodtfinal = txt;

            trimjs(vala1);
            if (txt == '0') {
                txt = '';
            }
            ;
            vala1 = txt;
            trimjs(vala2);
            if (txt == '0') {
                txt = '';
            }
            ;
            vala2 = txt;
            trimjs(vala3);
            if (txt == '0') {
                txt = '';
            }
            ;
            vala3 = txt;
            trimjs(val1);
            if (txt == '0') {
                txt = '';
            }
            ;
            val1 = txt;
            trimjs(val2);
            if (txt == '0') {
                txt = '';
            }
            ;
            val2 = txt;
            trimjs(val3);
            if (txt == '0') {
                txt = '';
            }
            ;
            val3 = txt;
            trimjs(data1);
            if (txt == '0') {
                txt = '';
            }
            ;
            data1 = txt;
            trimjs(data2);
            if (txt == '0') {
                txt = '';
            }
            ;
            data2 = txt;
            trimjs(data3);
            if (txt == '0') {
                txt = '';
            }
            ;
            data3 = txt;
            trimjs(usunome1);
            if (txt == '0') {
                txt = '';
            }
            ;
            usunome1 = txt;
            trimjs(usunome2);
            if (txt == '0') {
                txt = '';
            }
            ;
            usunome2 = txt;
            trimjs(usunome3);
            if (txt == '0') {
                txt = '';
            }
            ;
            usunome3 = txt;

            trimjs(vvala1);
            if (txt == '0') {
                txt = '';
            }
            ;
            vvala1 = txt;
            trimjs(vvala2);
            if (txt == '0') {
                txt = '';
            }
            ;
            vvala2 = txt;
            trimjs(vvala3);
            if (txt == '0') {
                txt = '';
            }
            ;
            vvala3 = txt;
            trimjs(vval1);
            if (txt == '0') {
                txt = '';
            }
            ;
            vval1 = txt;
            trimjs(vval2);
            if (txt == '0') {
                txt = '';
            }
            ;
            vval2 = txt;
            trimjs(vval3);
            if (txt == '0') {
                txt = '';
            }
            ;
            vval3 = txt;
            trimjs(vdata1);
            if (txt == '0') {
                txt = '';
            }
            ;
            vdata1 = txt;
            trimjs(vdata2);
            if (txt == '0') {
                txt = '';
            }
            ;
            vdata2 = txt;
            trimjs(vdata3);
            if (txt == '0') {
                txt = '';
            }
            ;
            vdata3 = txt;
            trimjs(vusunome1);
            if (txt == '0') {
                txt = '';
            }
            ;
            vusunome1 = txt;
            trimjs(vusunome2);
            if (txt == '0') {
                txt = '';
            }
            ;
            vusunome2 = txt;
            trimjs(vusunome3);
            if (txt == '0') {
                txt = '';
            }
            ;
            vusunome3 = txt;

            trimjs(lvala1);
            if (txt == '0') {
                txt = '';
            }
            ;
            lvala1 = txt;
            trimjs(lvala2);
            if (txt == '0') {
                txt = '';
            }
            ;
            lvala2 = txt;
            trimjs(lvala3);
            if (txt == '0') {
                txt = '';
            }
            ;
            lvala3 = txt;
            trimjs(lval1);
            if (txt == '0') {
                txt = '';
            }
            ;
            lval1 = txt;
            trimjs(lval2);
            if (txt == '0') {
                txt = '';
            }
            ;
            lval2 = txt;
            trimjs(lval3);
            if (txt == '0') {
                txt = '';
            }
            ;
            lval3 = txt;
            trimjs(ldata1);
            if (txt == '0') {
                txt = '';
            }
            ;
            ldata1 = txt;
            trimjs(ldata2);
            if (txt == '0') {
                txt = '';
            }
            ;
            ldata2 = txt;
            trimjs(ldata3);
            if (txt == '0') {
                txt = '';
            }
            ;
            ldata3 = txt;
            trimjs(lusunome1);
            if (txt == '0') {
                txt = '';
            }
            ;
            lusunome1 = txt;
            trimjs(lusunome2);
            if (txt == '0') {
                txt = '';
            }
            ;
            lusunome2 = txt;
            trimjs(lusunome3);
            if (txt == '0') {
                txt = '';
            }
            ;
            lusunome3 = txt;

            trimjs(gvala1);
            if (txt == '0') {
                txt = '';
            }
            ;
            gvala1 = txt;
            trimjs(gvala2);
            if (txt == '0') {
                txt = '';
            }
            ;
            gvala2 = txt;
            trimjs(gvala3);
            if (txt == '0') {
                txt = '';
            }
            ;
            gvala3 = txt;
            trimjs(gval1);
            if (txt == '0') {
                txt = '';
            }
            ;
            gval1 = txt;
            trimjs(gval2);
            if (txt == '0') {
                txt = '';
            }
            ;
            gval2 = txt;
            trimjs(gval3);
            if (txt == '0') {
                txt = '';
            }
            ;
            gval3 = txt;
            trimjs(gdata1);
            if (txt == '0') {
                txt = '';
            }
            ;
            gdata1 = txt;
            trimjs(gdata2);
            if (txt == '0') {
                txt = '';
            }
            ;
            gdata2 = txt;
            trimjs(gdata3);
            if (txt == '0') {
                txt = '';
            }
            ;
            gdata3 = txt;
            trimjs(gusunome1);
            if (txt == '0') {
                txt = '';
            }
            ;
            gusunome1 = txt;
            trimjs(gusunome2);
            if (txt == '0') {
                txt = '';
            }
            ;
            gusunome2 = txt;
            trimjs(gusunome3);
            if (txt == '0') {
                txt = '';
            }
            ;
            gusunome3 = txt;

            $("procodigo").value = codigo;
            $("prnome").value = descricao;
            $("prnome2").value = descricao2;
            $("procod").value = descricaob;
            $("proref").value = descricaod;
            $("proemb").value = descricaoe;
            $("proipi").value = descricaof;
            $("promedio").value = descricaog;
            $("promaior").value = descricaoh;
            $("promenor").value = descricaoi;
            $("promenord").value = descricaoid;
            $("prominimo").value = descricaoj;
            $("proreal").value = descricaok;
            custo1 = descricaok;
            $("profinal").value = descricaol;
            $("prorealv").value = prorealv;
            custov1 = prorealv;
            $("profinalv").value = profinalv;
            $("proreall").value = proreall;
            custol1 = proreall;
            $("profinall").value = profinall;

            $("prorealg").value = prorealg;
            custog1 = prorealg;
            $("profinalg").value = profinalg;

            $("prodesc1").value = descricaom;
            $("prodesc2").value = descricaon;
            $("prodesc3").value = descricaoo;
            $("proaltura").value = descricaop;
            $("prolargura").value = descricaoq;
            $("procompr").value = descricaor;
            $("propeso").value = descricaos;
            $("properc").value = descricaot;
            $("proval").value = descricaou;
            $("proacres").value = descricaov;
            $("prodescs").value = descricaox;
            $("procarac").value = descricaoz;

            $("datainicio").value = prodtinicio;
            $("datafinal").value = prodtfinal;

            //itemcombosubgrupo(codigo2);
            //itemcombolinha(codigo5);				

            itemcombomarca(codigo3);
            itemcombosubmarca(codigo4);

            itemcombostatus(codigo6);
            itemcombofaixa(codigo7);
            itemcombocores(codigocor);
            itemcombomedida(codigo8);
            itemcombotributo1(codigo9);
            itemcombotributo2(codigo10);
            itemcombofiscal(codigo11);
            itemcomboproprocedencia(proprocedencia);

            if (opcao1 == 'U') {
                document.getElementById("radio21").checked = true;
            } else if (opcao1 == 'M') {
                document.getElementById("radio22").checked = true;
            } else {
                document.getElementById("radio23").checked = true;
            }
            if (opcao2 == 'S') {
                document.getElementById("radio31").checked = true;
            } else {
                document.getElementById("radio32").checked = true;
            }
            if (opcao3 == 'S') {
                document.getElementById("radio41").checked = true;
            } else {
                document.getElementById("radio42").checked = true;
            }
            if (opcao4 == 'S') {
                document.getElementById("radio51").checked = true;
            } else {
                document.getElementById("radio52").checked = true;
            }
            if (opcao5 == 'S') {
                document.getElementById("radio61").checked = true;
            } else {
                document.getElementById("radio62").checked = true;
            }
            if (opcao6 == 'S') {
                document.getElementById("radio71").checked = true;
            } else {
                document.getElementById("radio72").checked = true;
            }
            if (opcao7 == 'S') {
                document.getElementById("radio81").checked = true;
            } else {
                document.getElementById("radio82").checked = true;
            }
            if (opcao8 == 'S') {
                document.getElementById("radio91").checked = true;
            } else {
                document.getElementById("radio92").checked = true;
            }

            if (proicms == '2') {
                document.getElementById("radioicmsn").checked = true;
            } else if (proicms == '3') {
                document.getElementById("radioicmse").checked = true;
            } else {
                document.getElementById("radioicmss").checked = true;
            }

            if (expvtex == '1') {
                document.getElementById("radiosts").checked = true;
            } else {
                document.getElementById("radiostn").checked = true;
            }

            if (procompra == '2') {
                document.getElementById("radiocomprap").checked = true;
            } else if (procompra == '3') {
                document.getElementById("radiocomprac").checked = true;
            } else {
                document.getElementById("radiocompran").checked = true;
            }

            itemcombofornecedor(codigo12);
            $("proaltcx").value = descra;
            $("prolarcx").value = descrb;
            $("procomcx").value = descrc;
            $("procubcx").value = descrcx;
            $("propescx").value = descrd;
            if (descre == '0') {
                descre = ''
            }
            $("barunidade").value = descre;
            if (descrf == '0') {
                descrf = ''
            }
            $("barcaixa").value = descrf;
            calculapreco($("proreal").value, $("promedio").value, $("promaior").value, $("promenor").value, $("prominimo").value, $("promenord").value);
            dadosfiscal(codigo11);

            $("custoa1").value = vala1;
            $("custoa2").value = vala2;
            $("custoa3").value = vala3;
            $("custo1").value = val1;
            $("custo2").value = val2;
            $("custo3").value = val3;
            $("data1").value = data1;
            $("data2").value = data2;
            $("data3").value = data3;
            $("usuario1").value = usunome1;
            $("usuario2").value = usunome2;
            $("usuario3").value = usunome3;

            $("vcustoa1").value = vvala1;
            $("vcustoa2").value = vvala2;
            $("vcustoa3").value = vvala3;
            $("vcusto1").value = vval1;
            $("vcusto2").value = vval2;
            $("vcusto3").value = vval3;
            $("vdata1").value = vdata1;
            $("vdata2").value = vdata2;
            $("vdata3").value = vdata3;
            $("vusuario1").value = vusunome1;
            $("vusuario2").value = vusunome2;
            $("vusuario3").value = vusunome3;

            $("lcustoa1").value = lvala1;
            $("lcustoa2").value = lvala2;
            $("lcustoa3").value = lvala3;
            $("lcusto1").value = lval1;
            $("lcusto2").value = lval2;
            $("lcusto3").value = lval3;
            $("ldata1").value = ldata1;
            $("ldata2").value = ldata2;
            $("ldata3").value = ldata3;
            $("lusuario1").value = lusunome1;
            $("lusuario2").value = lusunome2;
            $("lusuario3").value = lusunome3;


            $("gcustoa1").value = gvala1;
            $("gcustoa2").value = gvala2;
            $("gcustoa3").value = gvala3;
            $("gcusto1").value = gval1;
            $("gcusto2").value = gval2;
            $("gcusto3").value = gval3;
            $("gdata1").value = gdata1;
            $("gdata2").value = gdata2;
            $("gdata3").value = gdata3;
            $("gusuario1").value = gusunome1;
            $("gusuario2").value = gusunome2;
            $("gusuario3").value = gusunome3;

            if (protpsort == '1') {
                document.getElementById("radiosorts").checked = true;
                promaster == '0';
            } else if (protpsort == '2') {
                document.getElementById("radiosortn").checked = true;
                promaster == '0';
            } else if (protpsort == '3') {
                document.getElementById("radiosorte").checked = true;
            }

            if (promaster == '0') {

                $("sortprocodigo").value = "";
                $("sortprnome").value = "";
                $("sortprocod").value = "";
                $("sortpesquisa").value = "";

                $("sortradio1").disabled = true;
                $("sortradio2").disabled = true;
                $("sortradio3").disabled = true;
                $("sortpesquisa").disabled = true;
                $("sortbutton").disabled = true;
                $("sortlistDados").disabled = true;

                document.getElementById("sortradio1").checked = true;

                document.forms[0].sortlistDados.options.length = 1;
                idOpcao = document.getElementById("sortopcoes");
                idOpcao.innerHTML = "____________________";

            } else {

                $("sortprocodigo").value = promaster;
                $("sortprnome").value = masternom;
                $("sortprocod").value = mastercod;
                $("sortpesquisa").value = "";

                $("sortradio1").disabled = false;
                $("sortradio2").disabled = false;
                $("sortradio3").disabled = false;
                $("sortpesquisa").disabled = false;
                $("sortbutton").disabled = false;
                $("sortlistDados").disabled = false;

                document.getElementById("sortradio1").checked = true;

                document.forms[0].sortlistDados.options.length = 1;
                idOpcao = document.getElementById("sortopcoes");
                idOpcao.innerHTML = "____________________";

            }

            mostrarimagem(descricaob, descricaoo, 1, codigo1, codigo2, codigo5);

            //itemcombogrupo(codigo1,codigo2,codigo5);


            $("acao").value = "alterar";
            $("botao").value = "Alterar";
        }
        $('MsgResultado').innerHTML = "";
        $('MsgResultado2').innerHTML = "";
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo
        $("procodigo").value = "";
        $("prnome").value = "";
        $("prnome2").value = "";
        $("procod").value = "";
        $("proref").value = "";
        $("proemb").value = "";
        $("proipi").value = "";
        $("datainicio").value = "";
        $("datafinal").value = "";
        $("promedio").value = "";
        $("promaior").value = "";
        $("promenor").value = "";
        $("promenord").value = "";
        $("prominimo").value = "";
        $("proreal").value = "";
        $("profinal").value = "";
        $("prorealv").value = "";
        $("profinalv").value = "";
        $("proreall").value = "";
        $("profinall").value = "";

        $("prorealg").value = "";
        $("profinalg").value = "";

        $("prodesc1").value = "";
        $("prodesc2").value = "";
        $("prodesc3").value = "";
        $("proaltura").value = "";
        $("prolargura").value = "";
        $("procompr").value = "";
        $("propeso").value = "";
        $("properc").value = "";
        $("proval").value = "";
        $("proacres").value = "";
        $("prodescs").value = "";
        $("procarac").value = "";
        $("proaltcx").value = "";
        $("prolarcx").value = "";
        $("procomcx").value = "";
        $("procubcx").value = "";
        $("propescx").value = "";
        $("barunidade").value = "";
        $("barcaixa").value = "";

        $("custoa1").value = "";
        $("custoa2").value = "";
        $("custoa3").value = "";
        $("custo1").value = "";
        $("custo2").value = "";
        $("custo3").value = "";
        $("data1").value = "";
        $("data2").value = "";
        $("data3").value = "";
        $("usuario1").value = "";
        $("usuario2").value = "";
        $("usuario3").value = "";

        $("vcustoa1").value = "";
        $("vcustoa2").value = "";
        $("vcustoa3").value = "";
        $("vcusto1").value = "";
        $("vcusto2").value = "";
        $("vcusto3").value = "";
        $("vdata1").value = "";
        $("vdata2").value = "";
        $("vdata3").value = "";
        $("vusuario1").value = "";
        $("vusuario2").value = "";
        $("vusuario3").value = "";

        $("lcustoa1").value = "";
        $("lcustoa2").value = "";
        $("lcustoa3").value = "";
        $("lcusto1").value = "";
        $("lcusto2").value = "";
        $("lcusto3").value = "";
        $("ldata1").value = "";
        $("ldata2").value = "";
        $("ldata3").value = "";
        $("lusuario1").value = "";
        $("lusuario2").value = "";
        $("lusuario3").value = "";

        $("gcustoa1").value = "";
        $("gcustoa2").value = "";
        $("gcustoa3").value = "";
        $("gcusto1").value = "";
        $("gcusto2").value = "";
        $("gcusto3").value = "";
        $("gdata1").value = "";
        $("gdata2").value = "";
        $("gdata3").value = "";
        $("gusuario1").value = "";
        $("gusuario2").value = "";
        $("gusuario3").value = "";


        $("acao").value = "inserir";
        $("botao").value = "Incluir";

        var img = document.getElementById('imagem');
        img.setAttribute("src", "./produtos/figura0.jpg");

        $('MsgResultado').innerHTML = "";
        $('MsgResultado2').innerHTML = "";
    }
}

function processXML3(obj)
{
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados

        document.forms[0].listDados.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
            var descricaob = item.getElementsByTagName("descricaob")[0].firstChild.nodeValue;
            var descricaod = item.getElementsByTagName("descricaod")[0].firstChild.nodeValue;
            var descre = item.getElementsByTagName("descre")[0].firstChild.nodeValue;
            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;
            trimjs(descricaob);
            descricaob = txt;
            trimjs(descricaod);
            descricaod = txt;
            trimjs(descre);
            descre = txt;

            if (descre == '0') {
                descre = ''
            }

            //cria um novo option dinamicamente
            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto

            if (document.getElementById("radio1").checked == true) {
                novo.text = descricaob;
            } else if (document.getElementById("radio2").checked == true) {
                novo.text = descricao;
            } else {
                novo.text = descricaod;
            }

            //finalmente adiciona o novo elemento
            document.forms[0].listDados.options.add(novo);

            if (i == 0)
            {
                $("procodigo").value = codigo;
                $("barunidade").value = descre;
                $("acao").value = "alterar";
                $("botao").value = "Alterar";
            }
        }
        $('MsgResultado').innerHTML = "";
        $('MsgResultado2').innerHTML = "";
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo
        $("procodigo").value = "";
        $("prnome").value = "";
        $("prnome2").value = "";
        $("procod").value = "";
        $("proref").value = "";
        $("proemb").value = "";
        $("proipi").value = "";
        $("datainicio").value = "";
        $("datafinal").value = "";
        $("promedio").value = "";
        $("promaior").value = "";
        $("promenor").value = "";
        $("promenord").value = "";
        $("prominimo").value = "";
        $("proreal").value = "";
        $("profinal").value = "";
        $("prorealv").value = "";
        $("profinalv").value = "";
        $("proreall").value = "";
        $("profinall").value = "";

        $("prorealg").value = "";
        $("profinalg").value = "";

        $("prodesc1").value = "";
        $("prodesc2").value = "";
        $("prodesc3").value = "";
        $("proaltura").value = "";
        $("prolargura").value = "";
        $("procompr").value = "";
        $("propeso").value = "";
        $("properc").value = "";
        $("proval").value = "";
        $("proacres").value = "";
        $("prodescs").value = "";
        $("procarac").value = "";

        $("custoa1").value = "";
        $("custoa2").value = "";
        $("custoa3").value = "";
        $("custo1").value = "";
        $("custo2").value = "";
        $("custo3").value = "";
        $("data1").value = "";
        $("data2").value = "";
        $("data3").value = "";
        $("usuario1").value = "";
        $("usuario2").value = "";
        $("usuario3").value = "";

        $("vcustoa1").value = "";
        $("vcustoa2").value = "";
        $("vcustoa3").value = "";
        $("vcusto1").value = "";
        $("vcusto2").value = "";
        $("vcusto3").value = "";
        $("vdata1").value = "";
        $("vdata2").value = "";
        $("vdata3").value = "";
        $("vusuario1").value = "";
        $("vusuario2").value = "";
        $("vusuario3").value = "";

        $("lcustoa1").value = "";
        $("lcustoa2").value = "";
        $("lcustoa3").value = "";
        $("lcusto1").value = "";
        $("lcusto2").value = "";
        $("lcusto3").value = "";
        $("ldata1").value = "";
        $("ldata2").value = "";
        $("ldata3").value = "";
        $("lusuario1").value = "";
        $("lusuario2").value = "";
        $("lusuario3").value = "";

        $("acao").value = "inserir";
        $("botao").value = "Incluir";

        idOpcao.innerHTML = "____________________";

        $('MsgResultado').innerHTML = "";
        $('MsgResultado2').innerHTML = "";
    }
}

function dadospesquisamarca(valor)
{
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
        document.forms[0].listmarcas.options.length = 1;

        idOpcao = document.getElementById("opcoes4");

        ajax2.open("POST", "produtopesquisamarcavtex.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLmarca(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "____________________";
                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLmarca(obj)
{
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados

        document.forms[0].listmarcas.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;

            //idOpcao.innerHTML = "";

            //cria um novo option dinamicamente  
            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes4");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto
            novo.text = descricao;
            //finalmente adiciona o novo elemento
            document.forms[0].listmarcas.options.add(novo);
        }
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "____________________";

    }
    dadospesquisasubmarca(0);
}

function itemcombomarca(valor)
{
    y = document.forms[0].listmarcas.options.length;

    for (var i = 0; i < y; i++)
    {
        document.forms[0].listmarcas.options[i].selected = true;
        var l = document.forms[0].listmarcas;
        //var li = l.options[l.selectedIndex].text;
        var li = l.options[l.selectedIndex].value;
        if (li == valor) {
            i = y;
        }
    }
}

function dadospesquisasubmarca(valor)
{
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
        document.forms[0].listsubmarcas.options.length = 1;

        idOpcao = document.getElementById("opcoes5");

        ajax2.open("POST", "produtopesquisasubmarca.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLsubmarca(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "____________________";
                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLsubmarca(obj)
{
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados

        document.forms[0].listsubmarcas.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;

            //idOpcao.innerHTML = "";

            //cria um novo option dinamicamente  
            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes5");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto
            novo.text = descricao;
            //finalmente adiciona o novo elemento
            document.forms[0].listsubmarcas.options.add(novo);
        }
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "____________________";
    }
    //dadospesquisalinha(0);	  
    dadospesquisastatus(0);
}

function itemcombosubmarca(valor)
{
    y = document.forms[0].listsubmarcas.options.length;

    for (var i = 0; i < y; i++) {

        document.forms[0].listsubmarcas.options[i].selected = true;
        var l = document.forms[0].listsubmarcas;
        //var li = l.options[l.selectedIndex].text;
        var li = l.options[l.selectedIndex].value;
        if (li == valor) {
            i = y;
        }
    }
}


function dadospesquisastatus(valor)
{
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
        document.forms[0].liststatus.options.length = 1;

        idOpcao = document.getElementById("opcoes7");

        ajax2.open("POST", "produtopesquisastatus.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLstatus(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "____________________";
                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLstatus(obj)
{
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados

        document.forms[0].liststatus.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;

            //idOpcao.innerHTML = "";

            //cria um novo option dinamicamente  
            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes7");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto
            novo.text = descricao;
            //finalmente adiciona o novo elemento
            document.forms[0].liststatus.options.add(novo);
        }
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "____________________";
    }
    dadospesquisafaixa(0);
}

function itemcombostatus(valor)
{
    y = document.forms[0].liststatus.options.length;

    for (var i = 0; i < y; i++)
    {
        document.forms[0].liststatus.options[i].selected = true;
        var l = document.forms[0].liststatus;
        //var li = l.options[l.selectedIndex].text;
        var li = l.options[l.selectedIndex].value;
        if (li == valor) {
            i = y;
        }
    }
}

function dadospesquisafaixa(valor)
{
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
        document.forms[0].listfaixas.options.length = 1;

        idOpcao = document.getElementById("opcoes8");

        ajax2.open("POST", "produtopesquisafaixa.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLfaixa(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "____________________";
                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLfaixa(obj)
{
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados

        document.forms[0].listfaixas.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;

            //idOpcao.innerHTML = "";

            //cria um novo option dinamicamente  
            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes8");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto
            novo.text = descricao;
            //finalmente adiciona o novo elemento
            document.forms[0].listfaixas.options.add(novo);
        }
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "____________________";
    }
    dadospesquisacores(0);
}

function itemcombofaixa(valor)
{
    y = document.forms[0].listfaixas.options.length;

    for (var i = 0; i < y; i++)
    {
        document.forms[0].listfaixas.options[i].selected = true;
        var l = document.forms[0].listfaixas;
        //var li = l.options[l.selectedIndex].text;
        var li = l.options[l.selectedIndex].value;
        if (li == valor) {
            i = y;
        }
    }
}

function dadospesquisacores(valor)
{
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
        document.forms[0].listcores.options.length = 1;

        idOpcao = document.getElementById("opcoes13");

        ajax2.open("POST", "produtopesquisacores.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLcores(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "____________________";
                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLcores(obj)
{
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados

        document.forms[0].listcores.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;

            //idOpcao.innerHTML = "";

            //cria um novo option dinamicamente  
            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes13");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto
            novo.text = descricao;
            //finalmente adiciona o novo elemento
            document.forms[0].listcores.options.add(novo);
        }
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "____________________";
    }
    dadospesquisamedida(0);
}

function itemcombocores(valor)
{
    y = document.forms[0].listcores.options.length;

    for (var i = 0; i < y; i++)
    {
        document.forms[0].listcores.options[i].selected = true;
        var l = document.forms[0].listcores;
        var li = l.options[l.selectedIndex].value;
        if (li == valor) {
            i = y;
        }
    }
}

function dadospesquisamedida(valor)
{
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
        document.forms[0].listmedidas.options.length = 1;

        idOpcao = document.getElementById("opcoes9");

        ajax2.open("POST", "produtopesquisamedida.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLmedida(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "____________________";
                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLmedida(obj)
{
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados

        document.forms[0].listmedidas.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;

            //idOpcao.innerHTML = "";

            //cria um novo option dinamicamente  
            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes9");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto
            novo.text = descricao;
            //finalmente adiciona o novo elemento
            document.forms[0].listmedidas.options.add(novo);
        }
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "____________________";
    }
    dadospesquisafiscal(0);
}

function itemcombomedida(valor)
{
    y = document.forms[0].listmedidas.options.length;

    for (var i = 0; i < y; i++)
    {
        document.forms[0].listmedidas.options[i].selected = true;
        var l = document.forms[0].listmedidas;
        //var li = l.options[l.selectedIndex].text;
        var li = l.options[l.selectedIndex].value;
        if (li == valor) {
            i = y;
        }
    }
}

function dadospesquisafiscal(valor)
{
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
        document.forms[0].listfiscais.options.length = 1;

        idOpcao = document.getElementById("opcoes11");

        ajax2.open("POST", "produtopesquisafiscal.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLfiscal(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "____________________";
                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLfiscal(obj)
{
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados

        document.forms[0].listfiscais.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;

            //idOpcao.innerHTML = "";

            //cria um novo option dinamicamente  
            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes11");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto
            novo.text = descricao;
            //finalmente adiciona o novo elemento
            document.forms[0].listfiscais.options.add(novo);
        }
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "____________________";
    }
    dadospesquisatributo1(0);
}

function itemcombofiscal(valor)
{
    y = document.forms[0].listfiscais.options.length;

    for (var i = 0; i < y; i++)
    {
        document.forms[0].listfiscais.options[i].selected = true;
        var l = document.forms[0].listfiscais;
        //var li = l.options[l.selectedIndex].text;
        var li = l.options[l.selectedIndex].value;
        if (li == valor) {
            i = y;
        }
    }
}

function dadospesquisatributo2(valor)
{
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
        document.forms[0].listtributos2.options.length = 1;

        idOpcao = document.getElementById("opcoes12");

        ajax2.open("POST", "produtopesquisatributo2.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLtributo2(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "____________________";
                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLtributo2(obj)
{
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados

        document.forms[0].listtributos2.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;

            //idOpcao.innerHTML = "";

            //cria um novo option dinamicamente  
            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes12");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto
            novo.text = descricao;
            //finalmente adiciona o novo elemento
            document.forms[0].listtributos2.options.add(novo);
        }
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "____________________";
    }
    dadospesquisaprocedencia(0);
}

function itemcombotributo2(valor)
{
    y = document.forms[0].listtributos2.options.length;

    for (var i = 0; i < y; i++)
    {
        document.forms[0].listtributos2.options[i].selected = true;
        var l = document.forms[0].listtributos2;
        //var li = l.options[l.selectedIndex].text;
        var li = l.options[l.selectedIndex].value;
        if (li == valor) {
            i = y;
        }
    }
}


function dadospesquisatributo1(valor)
{
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
        document.forms[0].listtributos.options.length = 1;

        idOpcao = document.getElementById("opcoes10");

        ajax2.open("POST", "produtopesquisatributo1.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLtributo1(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "____________________";
                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLtributo1(obj)
{
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados

        document.forms[0].listtributos.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;

            //idOpcao.innerHTML = "";

            //cria um novo option dinamicamente  
            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes10");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto
            novo.text = descricao;
            //finalmente adiciona o novo elemento
            document.forms[0].listtributos.options.add(novo);
        }
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "____________________";
    }
    dadospesquisatributo2(0);
}

function itemcombotributo1(valor)
{
    y = document.forms[0].listtributos.options.length;

    for (var i = 0; i < y; i++)
    {
        document.forms[0].listtributos.options[i].selected = true;
        var l = document.forms[0].listtributos;
        //var li = l.options[l.selectedIndex].text;
        var li = l.options[l.selectedIndex].value;
        if (li == valor) {
            i = y;
        }
    }
}

function dadospesquisafornecedor(valor)
{
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
        document.forms[0].listfornecedores.options.length = 1;

        idOpcao = document.getElementById("opcoes12");

        ajax2.open("POST", "produtopesquisafornecedor.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLfornecedor(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "____________________";
                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLfornecedor(obj)
{
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados

        document.forms[0].listfornecedores.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;

            //idOpcao.innerHTML = "";

            //cria um novo option dinamicamente  
            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes13");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto
            novo.text = descricao;
            //finalmente adiciona o novo elemento
            document.forms[0].listfornecedores.options.add(novo);
        }
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "____________________";
    }

    dadospesquisamarca(0);

}

function itemcombofornecedor(valor)
{
    y = document.forms[0].listfornecedores.options.length;
    for (var i = 0; i < y; i++)
    {
        if (document.forms[0].listfornecedores.options[i].value == valor) {
            document.forms[0].listfornecedores.options[i].selected = true;
            i = y;
        }
    }
    /*
     for(var i = 0 ; i < y ; i++)
     {
     document.forms[0].listfornecedores.options[i].selected = true;
     var l = document.forms[0].listfornecedores;
     //var li = l.options[l.selectedIndex].text;
     var li = l.options[l.selectedIndex].value;
     if(li==valor){
     i=y;
     }
     }
     */
}

function dadosfor(valor)
{
    if ($("acao").value == "inserir")
    {
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
        if (ajax2)
        {
            //deixa apenas o elemento 1 no option, os outros são excluídos

            ajax2.open("POST", "produtopesquisafor.php", true);
            ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            ajax2.onreadystatechange = function ()
            {
                //enquanto estiver processando...emite a msg de carregando
                if (ajax2.readyState == 1) {
                }
                //após ser processado - chama função processXML que vai varrer os dados
                if (ajax2.readyState == 4)
                {
                    if (ajax2.responseXML) {
                        processXMLfor(ajax2.responseXML);
                    } else
                    {
                        //caso não seja um arquivo XML emite a mensagem abaixo
                    }
                }
            }
            //passa o parametro
            var params = "parametro=" + valor;
            ajax2.send(params);
        }
    }
}

function processXMLfor(obj)
{
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao1 = item.getElementsByTagName("descricao1")[0].firstChild.nodeValue;
            var descricao2 = item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;
            var descricao3 = item.getElementsByTagName("descricao3")[0].firstChild.nodeValue;
            var descricao4 = item.getElementsByTagName("descricao4")[0].firstChild.nodeValue;
            var descricao5 = item.getElementsByTagName("descricao5")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao1);
            descricao1 = txt;
            trimjs(descricao2);
            descricao2 = txt;
            trimjs(descricao3);
            descricao3 = txt;
            trimjs(descricao4);
            descricao4 = txt;
            trimjs(descricao5);
            descricao5 = txt;

            $("promaior").value = descricao1;
            $("promedio").value = descricao2;
            $("promenor").value = descricao3;
            $("promenord").value = descricao5;
            $("prominimo").value = descricao4;
        }
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo
        $("promaior").value = 0;
        $("promedio").value = 0;
        $("promenor").value = 0;
        $("promenord").value = 0;
        $("prominimo").value = 0;
    }
    codigo_produto(0);
}

function calculapreco(valor, medio, maior, menor, minimo, menord)
{
    var formula_a = new Number;
    var formula_c = new Number;
    var formula_m = new Number;
    var formula_d = new Number;
    var pa = new Number;
    var pc = new Number;
    var pm = new Number;
    var pd = new Number;
    var aux = new Number;

    formula_a = ((100 - maior) / 100);
    formula_c = ((100 - menor) / 100);
    formula_m = ((minimo / 100) + 1);
    formula_d = ((100 - menord) / 100);

    aux = (medio / 100);
    pb = parseFloat(valor * aux) + parseFloat(valor);
    //pb = round(pb);
    pb = (Math.round(pb * 100)) / 100;
    pa = pb / formula_a;
    pa = (Math.round(pa * 100)) / 100;
    pc = pb * formula_c;
    pc = (Math.round(pc * 100)) / 100;
    pm = valor * formula_m;
    pm = (Math.round(pm * 100)) / 100;

    pd = pb * formula_d;
    pd = (Math.round(pd * 100)) / 100;

    $("precoa").value = pa;
    $("precoc").value = pc;
    $("precod").value = pd;
    $("precob").value = pb;
    $("precominimo").value = pm;

}

function calculaperca(precoa, precob)
{

    var perca = new Number;

    //perca = (precoa * 100 / precob) - 100

    perca = (1 - (precob / precoa)) * 100

    if (perca == 0) {
        perca = 0.01;
    }

    $("promaior").value = perca;

}

function calculapercc(precoc, precob)
{

    var perca = new Number;

    //perca = (precoa * 100 / precob) - 100

    percc = (100 - ((precoc / precob) * 100));

    $("promenor").value = percc;

}


function dadosfiscal(valor)
{
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

        ajax2.open("POST", "produtopesquisafis.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLfis(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo

                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLfis(obj)
{
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao1 = item.getElementsByTagName("descricao1")[0].firstChild.nodeValue;
            var descricao2 = item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao1);
            descricao1 = txt;
            trimjs(descricao2);
            descricao2 = txt;
            $("proipiven").value = descricao2;
        }
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo
        $("proipiven").value = 0;
    }
}

function codigo_produto(valor)
{
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
    if (ajax2)
    {
        //deixa apenas o elemento 1 no option, os outros são excluídos

        ajax2.open("POST", "produtocodpesquisa.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXMLcodcli(ajax2.responseXML);
                } else
                {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }

}

function processXMLcodcli(obj)
{
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];

            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            trimjs(codigo);
            if (txt == '1') {
                txt = '1';
            }
            ;
            codigo = txt;

            //Vou retirar isso pois o fonte que faz a pesquisa já vai trazer o código correto
            //numjs(codigo);
            codigo = txt;

            //if(i==0){
            $("procod").value = codigo;
            //}
        }
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo
        $("procod").value = "1";
    }

    dadospesquisagrupo(0);
}

function dadospesquisaprocedencia(valor)
{
    document.forms[0].listprocedencia.options.length = 0;

    var novo = document.createElement("option");
    novo.setAttribute("id", "opcoesproc");
    novo.value = 1;
    novo.text = "1 - Prod. Nacion. Tibutados";
    document.forms[0].listprocedencia.options.add(novo);
    var novo = document.createElement("option");
    novo.setAttribute("id", "opcoesproc");
    novo.value = 2;
    novo.text = "2 - Prod. Nacion. Não Tibutados";
    document.forms[0].listprocedencia.options.add(novo);
    var novo = document.createElement("option");
    novo.setAttribute("id", "opcoesproc");
    novo.value = 3;
    novo.text = "3 - Produtos Isentos";
    document.forms[0].listprocedencia.options.add(novo);
    var novo = document.createElement("option");
    novo.setAttribute("id", "opcoesproc");
    novo.value = 4;
    novo.text = "4 - P. Estrang. Adquir. Merc. Inter.";
    document.forms[0].listprocedencia.options.add(novo);
    var novo = document.createElement("option");
    novo.setAttribute("id", "opcoesproc");
    novo.value = 5;
    novo.text = "5 - P. Estrang. de Impor. Direta";
    document.forms[0].listprocedencia.options.add(novo);
    var novo = document.createElement("option");
    novo.setAttribute("id", "opcoesproc");
    novo.value = 6;
    novo.text = "6 - Produtos com Susp. do IPI";
    document.forms[0].listprocedencia.options.add(novo);
    var novo = document.createElement("option");
    novo.setAttribute("id", "opcoesproc");
    novo.value = 7;
    novo.text = "7 - Outros";
    document.forms[0].listprocedencia.options.add(novo);

    limpa_form()
}

function itemcomboproprocedencia(valor)
{
    y = document.forms[0].listprocedencia.options.length;

    for (var i = 0; i < y; i++)
    {
        document.forms[0].listprocedencia.options[i].selected = true;
        var l = document.forms[0].listprocedencia;
        //var li = l.options[l.selectedIndex].text;
        var li = l.options[l.selectedIndex].value;
        if (li == valor) {
            i = y;
        }
    }
}

function formatar2(mascara, documento)
{
    if (document.getElementById('radio2').checked == true) {
        return;
    }
    if (document.getElementById('radio3').checked == true) {
        return;
    }

    var i = documento.value.length;
    var saida = mascara.substring(0, 1);
    var texto = mascara.substring(i)

    if (texto.substring(0, 1) != saida) {
        documento.value += texto.substring(0, 1);
    }
}

// Função que permite apenas teclas numéricas 
// Deve ser chamada no evento onKeyPress desta forma 
// return (soNums(event)); 
function soNums(e)
{
    if (document.all) {
        var evt = event.keyCode;
    } else {
        var evt = e.charCode;
    }
    if (evt < 20 || evt == 45 || evt == 46 || (evt > 47 && evt < 58)) {
        return true;
    }
    return false;
}

function calculafator(preco, custo)
{


    var nf = new Number;
    var np = new Number;
    var cs = new Number;

    np = preco;

    cs = custo;


    nf = (np / cs) - 1;
    nf = nf * 100;

    nf = (Math.round(nf * 100000)) / 100000;


    $("promedio").value = nf;

    calculapreco($("proreal").value, $("promedio").value, $("promaior").value, $("promenor").value, $("prominimo").value, $("promenord").value);

}


function consulta_cl()
{

    window.open('clfiscal.php?clacodigo=' + document.forms[0].listfiscais.options[document.forms[0].listfiscais.selectedIndex].value
            , 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=no, width=700, height=550');


}

function verificasort(valor)
{
    if (document.getElementById("radiosorte").checked == true)
    {
        $("sortradio1").disabled = false;
        $("sortradio2").disabled = false;
        $("sortradio3").disabled = false;
        $("sortpesquisa").disabled = false;
        $("sortbutton").disabled = false;
        $("sortlistDados").disabled = false;
    } else
    {
        $("sortradio1").disabled = true;
        $("sortradio2").disabled = true;
        $("sortradio3").disabled = true;
        $("sortpesquisa").disabled = true;
        $("sortbutton").disabled = true;
        $("sortlistDados").disabled = true;

        $("sortprocodigo").value = "";
        $("sortprnome").value = "";
        $("sortprocod").value = "";

        $("sortpesquisa").value = "";

        document.forms[0].sortlistDados.options.length = 1;
        idOpcao = document.getElementById("sortopcoes");
        idOpcao.innerHTML = "____________________";

        document.getElementById("sortradio1").checked = true;

    }
}

function sortdadospesquisa(valor)
{
    $('MsgResultado').innerHTML = "Processando...";
    $('MsgResultado2').innerHTML = "Processando...";
    //$('listmedidas').disabled=true;
    //$("#listmedidas").setAttribute ("disabled", "true");
    //document.forms[4].listmedidas.disabled = true;

    //verifica se o browser tem suporte a ajax
    try {
        ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (e)
    {
        try {
            ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (ex)
        {
            try {
                ajax2 = new XMLHttpRequest();
            } catch (exc)
            {
                alert("Esse browser não tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    //se tiver suporte ajax
    if (ajax2)
    {
        //deixa apenas o elemento 1 no option, os outros são excluídos
        document.forms[0].listDados.options.length = 1;

        idOpcao = document.getElementById("sortopcoes");

        ajax2.open("POST", "produtopesquisa.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML) {
                    sortprocessXML(ajax2.responseXML);
                } else
                {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "____________________";
                }
            }
        }
        //passa o parametro
        if (document.getElementById("sortradio1").checked == true) {
            valor2 = "1";
        } else if (document.getElementById("sortradio2").checked == true) {
            valor2 = "2";
        } else
        {
            valor2 = "3";
        }
        var params = "parametro=" + valor + '&parametro2=' + valor2;

        if (valor != "")
            ajax2.send(params);
        else
        {
            $('MsgResultado').innerHTML = "";
            $('MsgResultado2').innerHTML = "";
        }
    }
}

function sortdadospesquisa2(valor)
{

    $('MsgResultado').innerHTML = "Processando...";
    $('MsgResultado2').innerHTML = "Processando...";
    //verifica se o browser tem suporte a ajax
    try {
        ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (e)
    {
        try {
            ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (ex)
        {
            try {
                ajax2 = new XMLHttpRequest();
            } catch (exc)
            {
                alert("Esse browser não tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    //se tiver suporte ajax
    if (ajax2)
    {
        ajax2.open("POST", "produtopesquisa2.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    sortprocessXML2(ajax2.responseXML);
                } else
                {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                }
            }
        }
        //passa o parametro escolhido
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function sortprocessXML(obj)
{



    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados

        document.forms[0].sortlistDados.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
            var descricaob = item.getElementsByTagName("descricaob")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;
            trimjs(descricaob);
            descricaob = txt;


            //cria um novo option dinamicamente
            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "sortopcoes");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto

            if (document.getElementById("sortradio1").checked == true) {
                novo.text = descricaob + ' ' + descricao;
            } else if (document.getElementById("sortradio2").checked == true) {
                novo.text = descricaob + ' ' + descricao;
            } else {
                novo.text = descricaod + ' ' + descricao;
            }

            //finalmente adiciona o novo elemento
            document.forms[0].sortlistDados.options.add(novo);

            if (i == 0)
            {
                $("sortprocodigo").value = codigo;
                $("sortprnome").value = descricao;
                $("sortprocod").value = descricaob;

            }
        }
        $('MsgResultado').innerHTML = "";
        $('MsgResultado2').innerHTML = "";
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo
        $("sortprocodigo").value = "";
        $("sortprnome").value = "";
        $("sortprocod").value = "";

        idOpcao.innerHTML = "____________________";

        $('MsgResultado').innerHTML = "";
        $('MsgResultado2').innerHTML = "";
    }
}

function sortprocessXML2(obj)
{

    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados
        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
            var descricaob = item.getElementsByTagName("descricaob")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;
            trimjs(descricaob);
            descricaob = txt;

            $("sortprocodigo").value = codigo;
            $("sortprnome").value = descricao;
            $("sortprocod").value = descricaob;

        }
        $('MsgResultado').innerHTML = "";
        $('MsgResultado2').innerHTML = "";
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo
        $("sortprocodigo").value = "";
        $("sortprnome").value = "";
        $("sortprocod").value = "";

        $('MsgResultado').innerHTML = "";
        $('MsgResultado2').innerHTML = "";
    }
}

function sortformatar2(mascara, documento)
{
    if (document.getElementById('sortradio2').checked == true) {
        return;
    }
    if (document.getElementById('sortradio3').checked == true) {
        return;
    }

    var i = documento.value.length;
    var saida = mascara.substring(0, 1);
    var texto = mascara.substring(i)

    if (texto.substring(0, 1) != saida) {
        documento.value += texto.substring(0, 1);
    }
}

function atualizaimagem(endurl)
{

    if (endurl != '') {
        var img = document.getElementById('imagem');
        img.setAttribute("src", "./produtos/figura0.jpg");
        var auxprocod = document.getElementById('procod').value;
        mostrarimagem(auxprocod, endurl, 0, 0, 0, 0);
    }

}

function mostrarimagem(valor, valor2, alt, codigo1, codigo2, codigo5)
{

    //$('MsgResultado').innerHTML = "Processando Imagem...";
    //$('MsgResultado2').innerHTML = "Processando Imagem...";

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
    if (ajax2)
    {

        ajax2.open("POST", "produtoimgver.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXMLarq(ajax2.responseXML, alt, codigo1, codigo2, codigo5);
                } else
                {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                }
            }
        }
        //passa o parametro escolhido
        var params = "parametro=" + valor + "&parametro2=" + valor2;
        ajax2.send(params);
    }
}




function processXMLarq(obj, alt, codigo1, codigo2, codigo5)
{
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados
        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;


            if (codigo == 1) {
                var img = document.getElementById('imagem');
                img.setAttribute("src", "./produtos/" + descricao + ".jpg");
            } else
            {
                var img = document.getElementById('imagem');
                img.setAttribute("src", "./produtos/figura1.jpg");
            }

        }

    } else
    {

        var img = document.getElementById('imagem');
        img.setAttribute("src", "./produtos/figura0.jpg");

    }

    //$('MsgResultado').innerHTML = "";
    //$('MsgResultado2').innerHTML = "";	
    if (alt == 1) {
        itemcombogrupo(codigo1, codigo2, codigo5);
    }

}











function dadospesquisagrupo(valor)
{
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
        document.forms[0].listgrupos.options.length = 1;

        idOpcao = document.getElementById("opcoes2");

        ajax2.open("POST", "produtopesquisagrupovtex.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLgrupo(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "____________________";
                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLgrupo(obj)
{
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados

        document.forms[0].listgrupos.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;

            //idOpcao.innerHTML = "";

            //cria um novo option dinamicamente  
            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes2");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto
            novo.text = descricao;
            //finalmente adiciona o novo elemento
            document.forms[0].listgrupos.options.add(novo);

            if (i == 0) {
                valor = codigo;
            }

        }
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "____________________";
    }

    dadospesquisasubgrupo(valor, 0, 0)

}


function itemcombogrupo(valor, valor2, valor3) {

    y = document.forms[0].listgrupos.options.length;

    for (var i = 0; i < y; i++)
    {
        document.forms[0].listgrupos.options[i].selected = true;
        var l = document.forms[0].listgrupos;
        var li = l.options[l.selectedIndex].value;
        if (li == valor) {
            i = y;

        }
    }


    dadospesquisasubgrupo(valor, valor2, valor3);

}






function dadospesquisasubgrupo(valor, valor2, valor3)
{


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
        document.forms[0].listsubgrupos.options.length = 1;

        idOpcao = document.getElementById("opcoes3");

        ajax2.open("POST", "produtopesquisasubgrupovtex.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLsubgrupo(ajax2.responseXML, valor2, valor3);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "____________________";

                    document.forms[0].listlinhas.options.length = 1;
                    idOpcao = document.getElementById("opcoes6");
                    idOpcao.innerHTML = "____________________";

                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;

        ajax2.send(params);
    }
}

function processXMLsubgrupo(obj, valor2, valor3)
{
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados

        document.forms[0].listsubgrupos.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;

            //idOpcao.innerHTML = "";

            //cria um novo option dinamicamente  
            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes3");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto
            novo.text = descricao;
            //finalmente adiciona o novo elemento
            document.forms[0].listsubgrupos.options.add(novo);

            if (i == 0) {
                var valorX = codigo;
            }

        }
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "____________________";


        document.forms[0].listlinhas.options.length = 1;
        idOpcao = document.getElementById("opcoes6");
        idOpcao.innerHTML = "____________________";



    }


    if (valor2 != 0) {
        itemcombosubgrupo(valor2, valor3);
    } else
    {

        dadospesquisalinha(valorX, 0);

    }

}


function itemcombosubgrupo(valor, valor3) {

    y = document.forms[0].listsubgrupos.options.length;

    for (var i = 0; i < y; i++)
    {
        document.forms[0].listsubgrupos.options[i].selected = true;
        var l = document.forms[0].listsubgrupos;
        //var li = l.options[l.selectedIndex].text;
        var li = l.options[l.selectedIndex].value;
        if (li == valor) {
            i = y;
        }
    }

    if (valor3 != 0) {
        dadospesquisalinha(valor, valor3);
    }

}




function dadospesquisalinha(valor, valor3)
{
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
        document.forms[0].listlinhas.options.length = 1;

        idOpcao = document.getElementById("opcoes6");

        ajax2.open("POST", "produtopesquisalinhavtex2.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLlinha(ajax2.responseXML, valor3);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "____________________";
                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLlinha(obj, valor3)
{
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados

        document.forms[0].listlinhas.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;

            //idOpcao.innerHTML = "";

            //cria um novo option dinamicamente  
            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes6");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto
            novo.text = descricao;
            //finalmente adiciona o novo elemento
            document.forms[0].listlinhas.options.add(novo);
        }
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "____________________";

    }

    if (valor3 != 0) {
        itemcombolinha(valor3);
    }

    if (carrega_produto != '') {
        produto = carrega_produto;
        carrega_produto = '';
        $("pesquisa").value = produto;
        dadospesquisa(produto);
    }

}

function itemcombolinha(valor)
{
    y = document.forms[0].listlinhas.options.length;

    for (var i = 0; i < y; i++)
    {
        document.forms[0].listlinhas.options[i].selected = true;
        var l = document.forms[0].listlinhas;
        //var li = l.options[l.selectedIndex].text;
        var li = l.options[l.selectedIndex].value;
        if (li == valor) {
            i = y;
        }
    }
}

function limpar_produto() {
    window.open('consultaProduto.php', '_self');
}

function vtex_produto() {
    if ($("procodigo").value == "")
    {
        alert("Nenhum Produto Selecionado!");
    } else {

        $a.GB_show('produtovtex.php?codigo=' + $("procodigo").value,
                {
                    //height: (document.body.scrollHeight - 80),
                    //width: (document.body.scrollWidth - 30),

                    height: (800),
                    width: (1100),

                    animation: true,
                    overlay_clickable: false,
                    callback: callback,
                    caption: 'DADOS_VTEX'
                });

        //alert();
        $a('#dialog').dialog("open");

        //window.open('produtovtex.php?codigo=' + $("procodigo").value , '_blank');
    }
}

function  callback()
{

}

function vtex_imagens() {
    if ($("procodigo").value == "")
    {
        alert("Nenhum Produto Selecionado!");
    } else {

        window.open('produtoimgvtex.php?codigo=' + $("procodigo").value, '_blank');
    }
}