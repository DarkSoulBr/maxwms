// JavaScript Document 

var vartxt = '';
var dataIniciox = '';
var horaIniciox = '';
var dataFimx = '';
var horaFimx = '';
var tpx = '';
var tp2x = '';
var tptx = '';
var tpex = '';
var tpzx = '';
var tplx = '';
var campovet1x = '';
var campovet2x = '';
var campovet3x = '';

var vmax = 0;
var vtplocal;

var vdtinicio;
var vdtfinal;
var vtp;
var liberped = 0;
var modo = 3;
var vercor = 0;
var t = '';
var vfpedido = '';
var nivel = 0;
var opcao1 = 0;
var opcao2 = 0;
var opcao3 = 0;
var opcao4 = 0;
var email = '';
var codigox = 0;
var codx = 0;
var descricaox = 0;
var textox = 0;
var usuario1 = 0;
var pviest011x = 1;
var tipoestoque = 0;
var msg = '';
var finalizar = 0;
var liber = 0;
var liberX = 0;

var vtodos = 0;
var vmarca = 0;

var vtip;

var vet = new Array(500);

for (var i = 0; i < 500; i++) {
    vet[i] = new Array(46);
}

for (var i = 0; i < 500; i++) {
    vet[i][0] = 0;
    vet[i][1] = 0;
    vet[i][2] = 0;
    vet[i][3] = 0;
    vet[i][4] = 0;
    vet[i][5] = 0;
    vet[i][6] = 0;
    vet[i][7] = 0;
    vet[i][8] = 0;
    vet[i][9] = 0;
    vet[i][10] = 0;
    vet[i][11] = 0;
    vet[i][12] = 0;
    vet[i][13] = 0;
    vet[i][14] = 0;
    vet[i][15] = 0;
    vet[i][16] = 0;
    vet[i][17] = 0;
    vet[i][18] = 0;
    vet[i][19] = 0;
    vet[i][20] = 0;
    vet[i][21] = 0;
    vet[i][22] = 0;
    vet[i][23] = 0;
    vet[i][24] = 0;
    vet[i][25] = 0;
    vet[i][26] = 0;
    vet[i][27] = 0;
    vet[i][28] = 0;
    vet[i][29] = 0;
    vet[i][30] = 0;
    vet[i][31] = 0;
    vet[i][32] = 0;
    vet[i][33] = 0;
    vet[i][34] = 0;
    vet[i][35] = 0;
    vet[i][36] = 0;
    vet[i][37] = 0;
    vet[i][38] = 0;
    vet[i][39] = 0;
    vet[i][40] = 0;
    vet[i][41] = 0;
    vet[i][42] = 0;
    vet[i][43] = 0;
    vet[i][44] = 0;
    vet[i][45] = 0;
}



//funcao de formatacao de casas decimais
function deci(N) {
    texto = N.toString();
    texto2 = ""
    if (texto.indexOf(',') != -1)
    {
        for (var i = 0; i < texto.length; i++)
        {
            if (texto.charAt(i) == ",")
                texto2 += ".";
            else
                texto2 += texto.charAt(i);
        }
        texto = texto2;
    }


    texto[texto.indexOf(',')] = ".";
    ponto = texto.indexOf('.');
    if (ponto == -1)
    {
        texto += ".00";
        Term = texto
    } else
    {
        texto += "0";
        decimal = ponto + 3;
        Term = texto.substring(0, decimal);
    }
    if (Term == ".0") {
        Term = "0.00";
    }
    if (Term == ".00") {
        Term = "0.00";
    }
    //if (Term == "NaN.00"){ Term = "Erro";}
    return Term;
}

function inicia(usuario, vartxt1, dataInicio1, horaInicio1, dataFim1, horaFim1, tp1, tp21, tpt1, tpe1, tpz1, tpl1, campovet11, campovet21, campovet31)
{

    vartxt = vartxt1;
    dataIniciox = dataInicio1;
    horaIniciox = horaInicio1;
    dataFimx = dataFim1;
    horaFimx = horaFim1;
    tpx = tp1;
    tp2x = tp21;
    tptx = tpt1;
    tpex = tpe1;
    tpzx = tpz1;
    tplx = tpl1;
    campovet1x = campovet11;
    campovet2x = campovet21;
    campovet3x = campovet31;

    usuario1 = usuario;

    new ajax('admpedidousuario.php?usuario=' + usuario, {onComplete: verificanivel});

}


function verificanivel(request)
{

    nivel = 0;

    var xmldoc = request.responseXML;

    if (xmldoc != null)
    {
        var dados = xmldoc.getElementsByTagName('dados')[0];

        var registros = xmldoc.getElementsByTagName('registro');
        for (i = 0; i < registros.length; i++)
        {
            var itens = registros[i].getElementsByTagName('item');
            if (itens[0].firstChild.data != null)
            {
                nivel = itens[0].firstChild.data;
            }
        }

    }

    load_grid_tipopedido();

}

//------------ Tipo de Pedido -------------------------//
function load_grid_tipopedido_old()
{

    //Como sempre tudo que os antigos programadores Barão fizeram acaba cedo ou tarde gerando problemas
    //Esse formato está carregando o combo corretamente cerca de 80 a 85 % das vezes, porém as vezes não carrega

    tiposPedido = new Array();
    var multiple = $('.populaTipoPedidos').attr('multiple');
    var opcoes = '<option value="">Carregando ...</option>';

    $('.populaTipoPedidos').html(opcoes);

    //Envia os dados via metodo post
    $.post('admpedidotipopedido.php',
            {},
            function (data)
            {
                opcoes = '';

                if (Boolean(Number(data.retorno)))
                {
                    tiposPedido = data.tiposPedido;

                    if (multiple)
                    {
                        opcoes += "<option value=\"\" selected>Todos os Tipos de Pedido</option>";
                    } else
                    {
                        opcoes += "<option value=\"\">Selecione Tipo de Pedido</option>";
                    }

                    $.each(tiposPedido, function (key, value)
                    {
                        //Abastecimento não será processado nessa Consulta
                        if (value.sigla != "xSx")
                        {
                            if (nivel == 8)
                            {
                                if (value.sigla == "E" || value.sigla == "EV" || value.sigla == "ED")
                                {
                                    opcoes += '<option value="' + value.codigo + '">' + value.sigla + ' - ' + value.descricao + '</option>';
                                }
                            } else
                            {

                                opcoes += '<option value="' + value.codigo + '">' + value.sigla + ' - ' + value.descricao + '</option>';
                            }
                        }
                    });
                } else
                {
                    opcoes += '<option value="">Não carregou lista! Contate Admin!</option>';
                }

                $('.populaTipoPedidos').html(opcoes);
            }, "json");

    load_grid_estoque();
}

function load_grid_tipopedido()
{

    new ajax('consultatipopedido.php?opcao=2&consultatipopedido=', {onComplete: imprime_tipopedido});

}

function imprime_tipopedido(request)
{

    var xmldoc = request.responseXML;

    var dados = xmldoc.getElementsByTagName('dados')[0];

    tiposPedido = new Array();
    var multiple = $('.populaTipoPedidos').attr('multiple');
    var opcoes = '<option value="">Carregando ...</option>';

    $('.populaTipoPedidos').html(opcoes);

    opcoes = '';

    if (multiple)
    {
        opcoes += "<option value=\"\" selected>Todos os Tipos de Pedido</option>";
    } else
    {
        opcoes += "<option value=\"\">Selecione Tipo de Pedido</option>";
    }

    if (dados != null)
    {

        var registros = xmldoc.getElementsByTagName('registro');

        for (i = 0; i < registros.length; i++)
        {
            var itens = registros[i].getElementsByTagName('item');

            if (nivel == 8)
            {
                if (itens[0].firstChild.data == 1)
                {
                    opcoes += '<option value="' + itens[0].firstChild.data + '">' + itens[1].firstChild.data + '</option>';
                }
            } else
            {
                opcoes += '<option value="' + itens[0].firstChild.data + '">' + itens[1].firstChild.data + '</option>';
            }

        }
    }

    $('.populaTipoPedidos').html(opcoes);


    load_grid_estoque();
}


function load_grid_estoquex() {

    estoquesFisico = new Array();
    var multiple = $('.populaEstoquesFisico').attr('multiple');
    var opcoes = '<option value="">Carregando ...</option>';

    $('.populaEstoquesFisico').html(opcoes);

    opcoes = '';

    opcoes += "<option value=\"\" selected>Todos os Estoques Fisicos</option>";
    opcoes += '<option value="1">Matriz</option>';
    opcoes += '<option value="2">Filial</option>';
    opcoes += '<option value="3">CD GRU</option>';
    opcoes += '<option value="4">VIX</option>';
    opcoes += '<option value="5">CIVIT</option>';
    opcoes += '<option value="6">GRU-RE</option>';

    $('.populaEstoquesFisico').html(opcoes);


    if (vartxt == 'X') {
        imprimirconsulta();
    }


}


function load_grid_estoque() {

    valor = 0;

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

        ajax2.open("POST", "pesquisavendedor.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {

            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {

                    processXMLestoque(ajax2.responseXML);
                } else {

                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }

}



function processXMLestoque(obj, tipo) {

    estoquesFisico = new Array();
    var multiple = $('.populaEstoquesFisico').attr('multiple');
    var opcoes = '<option value="">Carregando ...</option>';

    $('.populaEstoquesFisico').html(opcoes);


    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados

        opcoes = '';
        opcoes += "<option value=\"\" selected>Todos os Vendedores</option>";

        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
            opcoes += '<option value="' + codigo + '">' + descricao + '</option>';

        }


    } else {


    }

    $('.populaEstoquesFisico').html(opcoes);

    load_grid_transportadora();


}

function load_grid_transportadora() {

    valor = 0;

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

        ajax2.open("POST", "pesquisatransportadora.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {

            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {

                    processXMLtransportadora(ajax2.responseXML);
                } else {

                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }

}



function processXMLtransportadora(obj) {

    transportadoras = new Array();
    var multiple = $('.populaTransportadora').attr('multiple');
    var opcoes = '<option value="">Carregando ...</option>';

    $('.populaTransportadora').html(opcoes);


    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados

        opcoes = '';
        opcoes += "<option value=\"\" selected>Todas as Transportadoras</option>";

        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
            opcoes += '<option value="' + codigo + '">' + descricao + '</option>';

        }


    } else {


    }

    $('.populaTransportadora').html(opcoes);

    if (vartxt == 'X') {
        imprimirconsulta();
    }


}



function imprimirconsulta() {

    $("#accordion h3 a:first").click(function ()
    {
        location.reload(true)
//            window.open('tracking.php?flag=1', '_self');
    });

    var tp = 0;
    var tp2 = 0;
    var tpt = 0;
    var tpe = 0;
    var tpz = 0;
    var tpl = 0;

    if (document.getElementById("radio1").checked == true) {
        tp = 1;
    } else if (document.getElementById("radio2").checked == true) {
        tp = 2;
    } else if (document.getElementById("radio3").checked == true) {
        tp = 3;
    } else if (document.getElementById("radio4").checked == true) {
        tp = 4;
    } else {
        tp = 5;
    }

    if (document.getElementById("radio21").checked == true) {
        tp2 = 1;
    } else if (document.getElementById("radio22").checked == true) {
        tp2 = 2;
    } else {
        tp2 = 3;
    }

    if (document.getElementById("radiot1").checked == true) {
        tpt = 1;
    } else if (document.getElementById("radiot2").checked == true) {
        tpt = 2;
    } else {
        tpt = 3;
    }

    if (document.getElementById("radioe1").checked == true) {
        tpe = 1;
    } else if (document.getElementById("radioe2").checked == true) {
        tpe = 2;
    } else {
        tpe = 3;
    }

    if (document.getElementById("radioz1").checked == true) {
        tpz = 1;
    } else if (document.getElementById("radioz2").checked == true) {
        tpz = 2;
    } else {
        tpz = 3;
    }
    
    if (document.getElementById("radiol1").checked == true) {
        tpl = 1;
    } else if (document.getElementById("radiol2").checked == true) {
        tpl = 2;
    } else {
        tpl = 3;
    }

    modo = 3;

    for (var i = 0; i < 500; i++) {
        vet[i][0] = 0;
        vet[i][1] = 0;
        vet[i][2] = 0;
        vet[i][3] = 0;
        vet[i][4] = 0;
        vet[i][5] = 0;
        vet[i][6] = 0;
        vet[i][7] = 0;
        vet[i][8] = 0;
        vet[i][9] = 0;
        vet[i][10] = 0;
        vet[i][11] = 0;
        vet[i][12] = 0;
        vet[i][13] = 0;
        vet[i][14] = 0;
        vet[i][15] = 0;
        vet[i][16] = 0;
        vet[i][17] = 0;
        vet[i][18] = 0;
        vet[i][19] = 0;
        vet[i][20] = 0;
        vet[i][21] = 0;
        vet[i][22] = 0;
        vet[i][23] = 0;
        vet[i][24] = 0;
        vet[i][25] = 0;
        vet[i][26] = 0;
        vet[i][27] = 0;
        vet[i][28] = 0;
        vet[i][29] = 0;
        vet[i][30] = 0;
        vet[i][31] = 0;
        vet[i][32] = 0;
        vet[i][33] = 0;
        vet[i][34] = 0;
        vet[i][35] = 0;
        vet[i][36] = 0;
        vet[i][37] = 0;
        vet[i][38] = 0;
        vet[i][39] = 0;
        vet[i][40] = 0;
        vet[i][41] = 0;
        vet[i][42] = 0;
        vet[i][43] = 0;
        vet[i][44] = 0;
        vet[i][45] = 0;
    }




    var dataInicio = new Date().dateBr(($('#dataInicio').val()));
    var horaInicio = $('#horaInicio').val();
    var dataFim = new Date().dateBr(($('#dataFim').val()));
    var horaFim = $('#horaFim').val();

    nivelUsuario = nivel;

    dataInicio.setTimes(horaInicio);
    dataFim.setTimes(horaFim);

    var aTipo = new Array();
    var aEstoque = new Array();
    var aTransportadora = new Array();

    var nTipo = 0;
    var nEstoque = 0;
    var nTransportadora = 0;

    var campovet1 = "";
    var campovet2 = "";
    var campovet3 = "";

    $('#listaTipoPedidos option:selected').each(function ()
    {
        if ($(this).val())
        {
            aTipo[nTipo] = $(this).val();
            nTipo = nTipo + 1;

            campovet1 = campovet1 + '&1[]=' + $(this).val();

        }
    });


    $('#listaEstoqueFisico option:selected').each(function ()
    {
        if ($(this).val())
        {
            aEstoque[nEstoque] = $(this).val();
            nEstoque = nEstoque + 1;

            campovet2 = campovet2 + '&2[]=' + $(this).val();

            vtplocal = $(this).val();

        }
    });


    $('#listaTransportadora option:selected').each(function ()
    {
        if ($(this).val())
        {
            aTransportadora[nTransportadora] = $(this).val();
            nTransportadora = nTransportadora + 1;

            campovet3 = campovet3 + '&3[]=' + $(this).val();

            vTransportadora = $(this).val();

        }
    });


    vdtinicio = dataInicio.format("Ymd");
    vdtfinal = dataFim.format("Ymd");
    vtp = tp;

    dataInicio = dataInicio.format("Y-m-d H:i:s");
    dataFim = dataFim.format("Y-m-d H:i:s");


    var dataInicioz = $('#dataInicio').val();
    var dataFimz = $('#dataFim').val();

    dataInicio = dataInicioz.substring(6, 10) + '-' + dataInicioz.substring(3, 5) + '-' + dataInicioz.substring(0, 2) + ' ' + horaInicio;
    dataFim = dataFimz.substring(6, 10) + '-' + dataFimz.substring(3, 5) + '-' + dataFimz.substring(0, 2) + ' ' + horaFim;

    if (nTipo == 0) {
        aTipo[nTipo] = 0;
    }
    if (nEstoque == 0) {
        aEstoque[nEstoque] = 0;
    }
    if (nTransportadora == 0) {
        aTransportadora[nTransportadora] = 0;
    }

    titulo = "PROCESSANDO, AGUARDE...";
    mensagem = "EXECUTANDO PESQUISA DE PEDIDOS LIBERADOS.";

    $("#retorno").messageBoxModal(titulo, mensagem);

    if (vartxt == '') {
        vartxt = 'X';
        dataIniciox = dataInicio;
        horaIniciox = horaInicio
        dataFimx = dataFim;
        horaFimx = horaFim;
        tpx = tp;
        tp2x = tp2;
        tptx = tpt;
        tpex = tpe;
        tpzx = tpz;
        tplx = tpl;
        campovet1x = campovet1;
        campovet2x = campovet2;
        campovet3x = campovet3;


        new ajax('consultapedidosliberadosimpv.php?dataInicio=' + dataInicio + '&horaInicio=' + horaInicio + '&dataFim=' + dataFim + '&horaFim=' + horaFim + '&tp=' + tp + '&tp2=' + tp2 + '&tpt=' + tpt + '&tpe=' + tpe + '&tpz=' + tpz + '&tpl=' + tpl + campovet1 + campovet2 + campovet3, {onLoading: carregando, onComplete: imprime});
        //window.open('consultapedidosliberadosimpv.php?dataInicio='+dataInicio+'&horaInicio='+horaInicio+'&dataFim='+dataFim+'&horaFim='+horaFim +'&tp='+tp +'&tp2='+tp2 +'&tpt='+tpt + campovet1 + campovet2 + campovet3 ,  "_blank");	

    } else
    {

        campovet1x = campovet1x.replace("_", "&");
        campovet1x = campovet1x.replace("_", "&");
        campovet1x = campovet1x.replace("_", "&");
        campovet1x = campovet1x.replace("_", "&");
        campovet1x = campovet1x.replace("_", "&");
        campovet1x = campovet1x.replace("_", "&");
        campovet1x = campovet1x.replace("_", "&");
        campovet1x = campovet1x.replace("_", "&");
        campovet1x = campovet1x.replace("_", "&");
        campovet1x = campovet1x.replace("_", "&");

        campovet2x = campovet2x.replace("_", "&");
        campovet2x = campovet2x.replace("_", "&");
        campovet2x = campovet2x.replace("_", "&");
        campovet2x = campovet2x.replace("_", "&");
        campovet2x = campovet2x.replace("_", "&");
        campovet2x = campovet2x.replace("_", "&");
        campovet2x = campovet2x.replace("_", "&");
        campovet2x = campovet2x.replace("_", "&");
        campovet2x = campovet2x.replace("_", "&");
        campovet2x = campovet2x.replace("_", "&");

        campovet3x = campovet3x.replace("_", "&");
        campovet3x = campovet3x.replace("_", "&");
        campovet3x = campovet3x.replace("_", "&");
        campovet3x = campovet3x.replace("_", "&");
        campovet3x = campovet3x.replace("_", "&");
        campovet3x = campovet3x.replace("_", "&");
        campovet3x = campovet3x.replace("_", "&");
        campovet3x = campovet3x.replace("_", "&");
        campovet3x = campovet3x.replace("_", "&");
        campovet3x = campovet3x.replace("_", "&");


        new ajax('consultapedidosliberadosimpv.php?dataInicio=' + dataIniciox + '&horaInicio=' + horaIniciox + '&dataFim=' + dataFimx + '&horaFim=' + horaFimx + '&tp=' + tpx + '&tp2=' + tp2x + '&tpt=' + tptx + '&tpe=' + tpex + '&tpz=' + tpzx + '&tpl=' + tplx + campovet1x + campovet2x + campovet3x, {onLoading: carregando, onComplete: imprime});

    }


}

function Atualiza() {

    campovet1x = campovet1x.replace("&", "_");
    campovet1x = campovet1x.replace("&", "_");
    campovet1x = campovet1x.replace("&", "_");
    campovet1x = campovet1x.replace("&", "_");
    campovet1x = campovet1x.replace("&", "_");
    campovet1x = campovet1x.replace("&", "_");
    campovet1x = campovet1x.replace("&", "_");
    campovet1x = campovet1x.replace("&", "_");
    campovet1x = campovet1x.replace("&", "_");
    campovet1x = campovet1x.replace("&", "_");

    campovet2x = campovet2x.replace("&", "_");
    campovet2x = campovet2x.replace("&", "_");
    campovet2x = campovet2x.replace("&", "_");
    campovet2x = campovet2x.replace("&", "_");
    campovet2x = campovet2x.replace("&", "_");
    campovet2x = campovet2x.replace("&", "_");
    campovet2x = campovet2x.replace("&", "_");
    campovet2x = campovet2x.replace("&", "_");
    campovet2x = campovet2x.replace("&", "_");
    campovet2x = campovet2x.replace("&", "_");

    campovet3x = campovet3x.replace("&", "_");
    campovet3x = campovet3x.replace("&", "_");
    campovet3x = campovet3x.replace("&", "_");
    campovet3x = campovet3x.replace("&", "_");
    campovet3x = campovet3x.replace("&", "_");
    campovet3x = campovet3x.replace("&", "_");
    campovet3x = campovet3x.replace("&", "_");
    campovet3x = campovet3x.replace("&", "_");
    campovet3x = campovet3x.replace("&", "_");
    campovet3x = campovet3x.replace("&", "_");

    window.open('consultapedidosliberadosn.php?vartxt=X&dataInicio=' + dataIniciox + '&horaInicio=' + horaIniciox + '&dataFim=' + dataFimx + '&horaFim=' + horaFimx + '&tp=' + tpx + '&tp2=' + tp2x + '&tpt=' + tptx + '&tpe=' + tpex + '&tpz=' + tpzx + '&tpl=' + tplx + '&campovet1=' + campovet1x + '&campovet2=' + campovet2x + '&campovet3=' + campovet3x, '_self');

}



function carregando() {

    document.getElementById('msg').style.visibility = "visible";
    document.getElementById('btnConsultaPedidos').disabled = true;

}

function atualizapedido(npedido) {

    titulo = "PROCESSANDO, AGUARDE...";
    mensagem = "ATUALIZANDO STATUS DO PEDIDO.";

    $("#retorno").messageBoxModal(titulo, mensagem);

    new ajax('admpedidoconsultav.php?npedido=' + npedido, {onLoading: carregando, onComplete: atualizavetor});
    //window.open('admpedidoconsulta.php?npedido='+npedido, '_blank');

}

function atualizavetor(request) {

    var xmldoc = request.responseXML;
    var dados = xmldoc.getElementsByTagName('dados')[0];
    if (dados != null)
    {
        var registros = xmldoc.getElementsByTagName('registro');
        for (i = 0; i < registros.length; i++) {

            var itens = registros[i].getElementsByTagName('item');


            for (i2 = 0; i2 < 500; i2++) {
                if (vet[i2][2] == itens[2].firstChild.data) {
                    //Comeca do 1 para nao alterar a sequencia
                    for (j = 1; j < itens.length; j++) {

                        if (vercor == 1) {
                            vet[i2][j] = itens[j].firstChild.data;
                        } else
                        {
                            if (j == 32) {
                                //if(vet[i2][j]!='#F8F8FF'){
                                //  vet[i2][j]=itens[j].firstChild.data;	
                                //}
                            } else {
                                vet[i2][j] = itens[j].firstChild.data;
                            }
                        }


                    }
                    imprime2();
                }
            }


        }
    }

}

function imprime(request) {


    document.getElementById('msg').style.visibility = "hidden";
    document.getElementById('btnConsultaPedidos').disabled = false;

    $("#accordion").accordion("activate", 1);

    //$("msg").style.visibility="hidden";
    var xmldoc = request.responseXML;

    var dados = xmldoc.getElementsByTagName('dados')[0];

    if (dados != null)
    {



        var width = (screen.width * 0.8);
        var numLinha = 0;

        var codHtml = "<table id='listaAgendamentos' border='0' cellpadding='0' cellspacing='0'>";
        codHtml += "<tbody>";



        //corpo da tabela
        var registros = xmldoc.getElementsByTagName('registro');


        //alert(registros.length);

        vmax = registros.length;

        var contacor = 0;
        var cor = '#FF0000';

        for (i = 0; i < registros.length; i++) {


            var itens = registros[i].getElementsByTagName('item');


            //tabela+="<tr id=linha"+i+">"

            /*
             for(j=0;j<itens.length;j++){
             vet[i][j]=itens[j].firstChild.data;
             }
             
             */

            var codHtmlTmp = '';

            contacor++;
            if (contacor == 1) {
                cor = '#00FF00';
            } else {
                cor = '#7CFC00';
                contacor = 0;
            }

            //Define a cor de acordo com o status
            if (itens[21].firstChild.data == 0) {
                cor = '#FF0000';
            } else {
                //cor = '#BEBEBE';
            }




            var k1 = itens[0].firstChild.data;
            var palmcodigo = itens[1].firstChild.data;
            var pedido = itens[2].firstChild.data;


            var pvtipoped = itens[3].firstChild.data;
            var tpalt = itens[4].firstChild.data;
            var itens1 = itens[5].firstChild.data;
            var conferido = itens[6].firstChild.data;
            var clirazao = itens[7].firstChild.data;
            var pvorigem = itens[8].firstChild.data;
            var pvdestino = itens[9].firstChild.data;
            var valor = itens[10].firstChild.data;
            var data1 = itens[11].firstChild.data;
            var data2 = itens[12].firstChild.data;
            var hora = itens[13].firstChild.data;
            var nota = itens[14].firstChild.data;

            var datanota = itens[15].firstChild.data;

            var usulogin = itens[16].firstChild.data;
            var cidade = itens[17].firstChild.data;
            var estado = itens[18].firstChild.data;
            var tipofrete = itens[19].firstChild.data;
            var transportadora = itens[20].firstChild.data;
            var finalizado = itens[21].firstChild.data;
            var pvimpresso = itens[22].firstChild.data;
            var palm = itens[23].firstChild.data;
            var pvurgente = itens[24].firstChild.data;
            var wms = itens[25].firstChild.data;
            var gerawms = itens[26].firstChild.data;
            var pvnewobs = itens[27].firstChild.data;

            var forrazao = itens[28].firstChild.data;
            var cidadefor = itens[29].firstChild.data;
            var estadofor = itens[30].firstChild.data;

            var pvfaturamento = itens[31].firstChild.data;
            var pvagendamento = itens[32].firstChild.data;
            var pvreagendamento = itens[33].firstChild.data;
            var pvremotivo = itens[34].firstChild.data;

            var pvagendaentrega = itens[35].firstChild.data;
            var pvbonificacao = itens[36].firstChild.data;
            var pvobsentrega = itens[37].firstChild.data;
            var pvinternet = itens[38].firstChild.data;
            var vencodigo = itens[39].firstChild.data;

            var romnumero = itens[40].firstChild.data;
            var romdata = itens[41].firstChild.data;
            var nfecab = itens[42].firstChild.data;
            var logdatasul = itens[43].firstChild.data;
            var prodatasul = itens[44].firstChild.data;

            if (nfecab == 0) {
                nfecab = '';
            }


            codHtml += "<tr style='background: " + cor + ";' id=" + k1 + "><td onClick=abre_txt(" + itens[2].firstChild.data + ") ><span id='dvCliente" + k1 + "' style='cursor: pointer'>" + itens[0].firstChild.data + "</span></td>"

            //codHtml +="<td ><span id='dvCliente"+palmcodigo+"'>"+itens[1].firstChild.data+"</span></td>";

            codHtml += "<td onClick=abre_pedvenda(" + itens[2].firstChild.data + ") ><span id='dvCliente" + pedido + "' style='cursor: pointer'>" + itens[2].firstChild.data + "</span></td>"

            codHtml += "<td ><span id='dvCliente" + itens[42].firstChild.data + "'>" + nfecab + "</span></td>"

            codHtml += "<td ><span id='dvCliente" + pvinternet + "'>" + itens[38].firstChild.data + "</span></td>"

            if (itens[14].firstChild.data == 0) {
                codHtml += "<td ><span id='dvCliente" + nota + "'>&nbsp;</span></td>"
            } else {
                codHtml += "<td ><span id='dvCliente" + nota + "'>" + itens[14].firstChild.data + "</span></td>"
            }

            if (logdatasul == '_') {
                codHtml += "<td ><span id='dvCliente" + logdatasul + "'>&nbsp;</span></td>"
            } else {
                codHtml += "<td ><span id='dvCliente" + logdatasul + "'>" + logdatasul + "</span></td>"
            }

            if (prodatasul == '_') {
                codHtml += "<td ><span id='dvCliente" + prodatasul + "'>&nbsp;</span></td>"
            } else {
                codHtml += "<td ><span id='dvCliente" + prodatasul + "'>" + prodatasul + "</span></td>"
            }

            if (itens[15].firstChild.data == 0) {
                codHtml += "<td ><span id='dvCliente" + datanota + "'>&nbsp;</span></td>"
            } else {
                codHtml += "<td ><span id='dvCliente" + datanota + "'>" + itens[15].firstChild.data + "</span></td>"
            }

            codHtml += "<td ><span id='dvCliente" + vencodigo + "'>" + itens[39].firstChild.data + "</span></td>"


            codHtml += "<td ><span id='dvCliente" + pvtipoped + "'>" + itens[3].firstChild.data + "</span></td>"
            codHtml += "<td ><span id='dvCliente" + tpalt + "'>" + itens[4].firstChild.data + "</span></td>"
            codHtml += "<td ><span id='dvCliente" + itens + "'>" + itens[5].firstChild.data + "</span></td>"


            if (itens[21].firstChild.data == 0) {
                codHtml += "<td style='cursor: pointer' onClick=abre_txtconf(" + itens[2].firstChild.data + ") ><span id='dvCliente" + k1 + "'>" + itens[6].firstChild.data + "</span></td>"
            } else
            {
                codHtml += "<td ><span id='dvCliente" + itens + "'>" + itens[5].firstChild.data + "</span></td>"
            }

            if (itens[3].firstChild.data == 'D') {
                if (itens[28].firstChild.data == 0) {
                    codHtml += "<td ><span id='dvCliente" + forrazao + "'>&nbsp;</span></td>"
                } else {
                    codHtml += "<td ><span id='dvCliente" + forrazao + "'>" + itens[28].firstChild.data + "</span></td>"
                }
            } else {
                if (itens[7].firstChild.data == 0) {
                    codHtml += "<td ><span id='dvCliente" + clirazao + "'>&nbsp;</span></td>"
                } else {
                    codHtml += "<td ><span id='dvCliente" + clirazao + "'>" + itens[7].firstChild.data + "</span></td>"
                }
            }



            if (pvorigem == 0) {
                codHtml += "<td ><span id='dvCliente" + pvorigem + "'>&nbsp;</span></td>"
            } else {
                codHtml += "<td ><span id='dvCliente" + pvorigem + "'>" + itens[8].firstChild.data + "</span></td>"
            }

            if (pvdestino == 0) {
                codHtml += "<td ><span id='dvCliente" + pvdestino + "'>&nbsp;</span></td>"
            } else {
                codHtml += "<td ><span id='dvCliente" + pvdestino + "'>" + itens[9].firstChild.data + "</span></td>"
            }


            //codHtml +="<td ><span id='dvCliente"+valor+"'>"+itens[10].firstChild.data+"</span></td>"
            var rnum = itens[10].firstChild.data;

            rnum = deci(rnum);

            var texto1 = rnum;
            var letra1;
            var codigo1;
            var saida1 = '';

            for (i1 = 0; i1 < texto1.length; i1++)
            {
                letra1 = texto1.substring(i1, i1 + 1);
                codigo1 = letra1.charCodeAt(0)
                if (codigo1 == 46) {
                    codigo1 = 44;
                }
                letra1 = String.fromCharCode(codigo1);
                saida1 = saida1 + letra1
            }

            rnum = saida1;

            var len = (14 - parseInt(rnum.length));

            for (k = 0; k < len; k++) {
                rnum = '&nbsp;' + rnum
            }

            //tabela+="<td class='borda' bgcolor="+$cor+" align='right' >"+rnum+'&nbsp;'+"</td>";
            codHtml += "<td ><span id='dvCliente" + valor + "'>" + rnum + "</span></td>"




            codHtml += "<td ><span id='dvCliente" + data1 + "'>" + itens[11].firstChild.data + "</span></td>"
            codHtml += "<td ><span id='dvCliente" + data2 + "'>" + itens[12].firstChild.data + "</span></td>"
            codHtml += "<td ><span id='dvCliente" + hora + "'>" + itens[13].firstChild.data + "</span></td>"


            //codHtml +="<td ><span id='dvCliente"+datanota+"'>"+itens[15].firstChild.data+"</span></td>"

            trimjs(usulogin);
            if (txt == "0") {
                codHtml += "<td ><span id='dvCliente" + usulogin + "'>&nbsp;</span></td>"
            } else
            {
                codHtml += "<td ><span id='dvCliente" + usulogin + "'>" + itens[16].firstChild.data + "</span></td>"
            }


            if (itens[3].firstChild.data == 'D') {
                codHtml += "<td ><span id='dvCliente" + cidadefor + "'>" + itens[29].firstChild.data + "</span></td>"
                codHtml += "<td ><span id='dvCliente" + estadofor + "'>" + itens[30].firstChild.data + "</span></td>"
            } else {
                codHtml += "<td ><span id='dvCliente" + cidade + "'>" + itens[17].firstChild.data + "</span></td>"
                codHtml += "<td ><span id='dvCliente" + estado + "'>" + itens[18].firstChild.data + "</span></td>"
            }


            codHtml += "<td ><span id='dvCliente" + tipofrete + "'>" + itens[19].firstChild.data + "</span></td>"

            //codHtml +="<td ><span id='dvCliente"+transportadora+"'>"+itens[20].firstChild.data+"</span></td>"

            codHtml += "<td onClick=abre_pedtrans(" + itens[2].firstChild.data + ") ><span id='dvCliente" + transportadora + "' style='cursor: pointer'>" + itens[20].firstChild.data + "</span></td>"


            /*
             codHtml +="<td ><span id='dvCliente"+finalizado+"'>"+itens[20].firstChild.data+"</span></td>"
             codHtml +="<td ><span id='dvCliente"+pvimpresso+"'>"+itens[21].firstChild.data+"</span></td>"
             */
            if (itens[21].firstChild.data == 0) {
                codHtml += "<td ><span id='dvCliente" + k1 + "'>&nbsp;</span></td>"
                codHtml += "<td ><span id='dvCliente" + k1 + "'>" + "N" + "</span></td>"

            } else
            {
                codHtml += "<td ><span id='dvCliente" + k1 + "'>" + "C" + "</span></td>"
                codHtml += "<td ><span id='dvCliente" + k1 + "'>&nbsp;</span></td>"
            }

            if (itens[22].firstChild.data == 0) {
                codHtml += "<td ><span id='dvCliente" + k1 + "'>&nbsp;<input id='H" + i + "' name='H" + i + "' type='hidden' value='" + itens[2].firstChild.data + "'/></span></td>"
            } else
            {
                codHtml += "<td ><span id='dvCliente" + k1 + "'>I<input id='H" + i + "' name='H" + i + "' type='hidden' value='0'/></span></td>"
            }


            //codHtml +="<td ><span id='dvCliente"+palm+"'>"+itens[23].firstChild.data+"</span></td>"  não vai mais ter palm!

            //codHtml +="<td ><span id='dvCliente"+pvurgente+"'>"+itens[23].firstChild.data+"</span></td>"
            if (itens[24].firstChild.data == 1) {
                codHtml += "<td ><span id='dvCliente" + pvurgente + "'>RETIRA</span></td>"
            } else if (itens[24].firstChild.data == 3) {
                codHtml += "<td ><span id='dvCliente" + pvurgente + "'>HOTEL</span></td>"
            } else if (itens[24].firstChild.data == 4) {
                codHtml += "<td ><span id='dvCliente" + pvurgente + "'>AJUSTE FISCAL</span></td>"
            } else if (itens[24].firstChild.data == 5) {
                codHtml += "<td ><span id='dvCliente" + pvurgente + "'>EXTRAVIO</span></td>"
            } else
            {
                codHtml += "<td ><span id='dvCliente" + pvurgente + "'>NÃO</span></td>"
            }


            //codHtml +="<td ><span id='dvCliente"+wms+"'>"+itens[25].firstChild.data+"</span></td>"
            //codHtml +="<td ><span id='dvCliente"+gerawms+"'>"+itens[26].firstChild.data+"</span></td>"

            //Se o campo gerawms for 2 não tem geração do wms por escolha do usuário
            if (itens[26].firstChild == null || itens[26].firstChild.data == 1 || itens[26].firstChild.data == 0) {
                if (itens[25].firstChild == null || itens[25].firstChild.data == 0) {
                    codHtml += "<td style='cursor: pointer' onClick=abre_wmsconf(" + itens[2].firstChild.data + ")>" + "EXPORTAR" + "</td>";
                } else {
                    codHtml += "<td style='cursor: pointer' onClick=abre_wmsconf(" + itens[2].firstChild.data + ")>" + itens[25].firstChild.data + "</td>";
                }
            } else {
                codHtml += "<td >" + "SEM WMS" + "</td>";
            }

            if (itens[27].firstChild.data == 0) {
                codHtml += "<td ><span id='dvCliente" + pvnewobs + "'>&nbsp;</span></td>"
            } else
            {
                codHtml += "<td ><span id='dvCliente" + pvnewobs + "'>" + itens[27].firstChild.data + "</span></td>"
            }


            if (pvfaturamento == '_') {
                codHtml += "<td ><span id='dvCliente" + pvfaturamento + "'>&nbsp;</span></td>"
            } else
            {
                codHtml += "<td ><span id='dvCliente" + pvfaturamento + "'>" + pvfaturamento + "</span></td>"
            }

            codHtml += "<td ><span id='dvCliente" + pvbonificacao + "'>" + pvbonificacao + "</span></td>"

            codHtml += "<td ><span id='dvCliente" + pvagendaentrega + "'>" + pvagendaentrega + "</span></td>"

            if (pvagendamento == '_') {
                codHtml += "<td ><span id='dvCliente" + pvagendamento + "'>&nbsp;</span></td>"
            } else
            {
                codHtml += "<td ><span id='dvCliente" + pvagendamento + "'>" + pvagendamento + "</span></td>"
            }
            if (pvreagendamento == '_') {
                codHtml += "<td ><span id='dvCliente" + pvreagendamento + "'>&nbsp;</span></td>"
            } else
            {
                codHtml += "<td ><span id='dvCliente" + pvreagendamento + "'>" + pvreagendamento + "</span></td>"
            }
            if (pvremotivo == '_') {
                codHtml += "<td ><span id='dvCliente" + pvremotivo + "'>&nbsp;</span></td>"
            } else
            {
                codHtml += "<td ><span id='dvCliente" + pvremotivo + "'>" + pvremotivo + "</span></td>"
            }

            if (pvobsentrega == '_') {
                codHtml += "<td ><span id='dvCliente" + pvobsentrega + "'>&nbsp;</span></td>"
            } else
            {
                codHtml += "<td ><span id='dvCliente" + pvobsentrega + "'>" + pvobsentrega + "</span></td>"
            }


            if (romnumero == '_') {
                codHtml += "<td ><span id='dvCliente" + romnumero + "'>&nbsp;</span></td>"
            } else
            {
                codHtml += "<td ><span id='dvCliente" + romnumero + "'>" + romnumero + "</span></td>"
            }

            if (romdata == '_') {
                codHtml += "<td ><span id='dvCliente" + romdata + "'>&nbsp;</span></td>"
            } else
            {
                codHtml += "<td ><span id='dvCliente" + romdata + "'>" + romdata + "</span></td>"
            }


            //codHtml +="<td ><span id='dvCliente"+k1+"'>"+"_"+"</span></td>"
            if (vtodos == 0) {

                var l = 0;
                for (var k = 0; k < registros.length; k++) {
                    if (vet[k] == itens[2].firstChild.data) {
                        l = 1;
                        k = 100;
                    }
                }
                if (l == 0) {
                    codHtml += "<td onClick=vetor(" + itens[2].firstChild.data + ") ><span id='dvCliente" + k1 + "'><input id='chk" + i + "' name='chk" + i + "' type='checkbox' value='" + itens[2].firstChild.data + "'/></span></td>"
                } else
                {
                    codHtml += "<td onClick=vetor(" + itens[2].firstChild.data + ") ><span id='dvCliente" + k1 + "'><input id='chk" + i + "' name='chk" + i + "' type='checkbox' value='" + itens[2].firstChild.data + "' checked /></span></td>"
                }
            } else
            {
                if (vmarca == 1) {
                    vet[i] = itens[2].firstChild.data;
                    tabela += "<td class='borda' bgcolor=" + $cor + " align='center'  onClick=vetor(" + itens[2].firstChild.data + ")   ><input id='chk" + i + "' name='chk" + i + "' type='checkbox' value='" + itens[2].firstChild.data + "' checked /></td>";
                } else
                {
                    tabela += "<td class='borda'  bgcolor=" + $cor + " align='center'  onClick=vetor(" + itens[2].firstChild.data + ")   ><input id='chk" + i + "' name='chk" + i + "' type='checkbox' value='" + itens[2].firstChild.data + "' /></td>";
                }
            }

            if (codHtmlTmp.length > 1)
            {
                codHtml += "<td  id='detalhar" + numLinha + "' onclick='mostrar(" + numLinha + ");'>+</td>";
            } else {
                codHtml += "<td> </td>";
            }
            codHtml += "</tr>";


            for (z = codHtmlTmp.length; z > 0; z--) {
                count = z - 2;
                if (count < 0) {
                    break;
                }
                codHtml += codHtmlTmp[count];
            }

            numLinha++;

        }

        codHtml += "</tbody></table>";

        vtodos = 0;
        //var qtd    =  vmax;
        //$("qtd").value=qtd;



        $("#accordion").accordion("activate", 1);
        $("#tblResultado").html(codHtml);

        width = (screen.width - (((screen.width * 5) / 100) * 2));

        $("#tblResultado").flexigrid(
                {
                    width: width,
                    height: 400,
                    striped: false,
                    colModel: [
                        {
                            display: '',
                            name: 'seq',
                            width: width * 0.02,
                            align: 'center'
                        },
                        /*{
                         display: 'palmcodigo',
                         name : 'palmcodigo',
                         width : width * 0.05,
                         align: 'center'
                         },
                         */
                        {
                            display: 'Pedido',
                            name: 'pedido',
                            width: width * 0.05,
                            align: 'center'
                        },
                        {
                            display: 'NF-e CAB',
                            name: 'nfecab',
                            width: width * 0.05,
                            align: 'center'
                        },
                        {
                            display: 'Vtex',
                            name: 'vtex',
                            width: width * 0.07,
                            align: 'center'
                        },
                        {
                            display: 'Embarque',
                            name: 'embarque',
                            width: width * 0.07,
                            align: 'center'
                        },
                        {
                            display: 'Log Datasul',
                            name: 'datasul',
                            width: width * 0.44,
                            align: 'center'
                        },
                        {
                            display: 'Produtos Datasul',
                            name: 'prodatasul',
                            width: width * 0.20,
                            align: 'center'
                        },
                        {
                            display: 'NF-e',
                            name: 'nota',
                            width: width * 0.05,
                            align: 'center'
                        },
                        {
                            display: 'Local',
                            name: 'local',
                            width: width * 0.08,
                            align: 'center'
                        },
                        {
                            display: 'TP',
                            name: 'pvtipoped',
                            width: width * 0.02,
                            align: 'center'
                        },
                        {
                            display: 'AL',
                            name: 'tpalt',
                            width: width * 0.02,
                            align: 'center'
                        },
                        {
                            display: 'Itens',
                            name: 'itens',
                            width: width * 0.03,
                            align: 'center'
                        },
                        {
                            display: 'Conf.',
                            name: 'conferido',
                            width: width * 0.03,
                            align: 'center'
                        },
                        {
                            display: 'Cliente',
                            name: 'clirazao',
                            width: width * 0.2,
                            align: 'left'
                        },
                        {
                            display: 'O',
                            name: 'pvorigem',
                            width: width * 0.02,
                            align: 'center'
                        },
                        {
                            display: 'D',
                            name: 'pvdestino',
                            width: width * 0.02,
                            align: 'center'
                        },
                        {
                            display: 'Valor',
                            name: 'valor',
                            width: width * 0.07,
                            align: 'center'
                        },
                        {
                            display: 'Data',
                            name: 'data1',
                            width: width * 0.06,
                            align: 'center'
                        },
                        {
                            display: 'Liberação',
                            name: 'data2',
                            width: width * 0.06,
                            align: 'center'
                        },
                        {
                            display: 'Hora',
                            name: 'hora',
                            width: width * 0.04,
                            align: 'center'
                        },
                        /*
                         {
                         display: 'Nota',
                         name : 'nota',
                         width : width * 0.04,
                         align: 'center'
                         },
                         {
                         display: 'Data',
                         name : 'data3',
                         width : width * 0.06,
                         align: 'center'
                         },
                         */
                        {
                            display: 'Usuario',
                            name: 'usulogin',
                            width: width * 0.05,
                            align: 'center'
                        },
                        {
                            display: 'Cidade',
                            name: 'cidade',
                            width: width * 0.1,
                            align: 'left'
                        },
                        {
                            display: 'UF',
                            name: 'estado',
                            width: width * 0.03,
                            align: 'center'
                        },
                        {
                            display: 'Frete',
                            name: 'tipofrete',
                            width: width * 0.05,
                            align: 'center'
                        },
                        {
                            display: 'Transportador',
                            name: 'transportadora',
                            width: width * 0.1,
                            align: 'left'
                        },

                        {
                            display: 'C',
                            name: 'c',
                            width: width * 0.02,
                            align: 'center'
                        },
                        {
                            display: 'N',
                            name: 'n',
                            width: width * 0.02,
                            align: 'center'
                        },
                        {
                            display: 'I',
                            name: 'i',
                            width: width * 0.02,
                            align: 'center'
                        },
                        /*
                         {
                         display: 'finalizado',
                         name : 'finalizado',
                         width : width * 0.05,
                         align: 'center'
                         },
                         {
                         display: 'pvimpresso',
                         name : 'pvimpresso',
                         width : width * 0.05,
                         align: 'center'
                         },
                         {
                         display: 'Palm',
                         name : 'palm',
                         width : width * 0.05,
                         align: 'center'
                         },
                         */

                        {
                            display: 'Urgente',
                            name: 'pvurgente',
                            width: width * 0.05,
                            align: 'center'
                        },
                        {
                            display: 'Datasul',
                            name: 'wms',
                            width: width * 0.06,
                            align: 'center'
                        },
                        {
                            display: 'Observacao',
                            name: 'observacao',
                            width: width * 0.3,
                            align: 'left'
                        },
                        {
                            display: 'Fat.Desejado',
                            name: 'fatdesejado',
                            width: width * 0.08,
                            align: 'center'
                        },
                        {
                            display: 'Bonificação',
                            name: 'bonificacao',
                            width: width * 0.08,
                            align: 'center'
                        },
                        {
                            display: 'Agendamento',
                            name: 'agendamento',
                            width: width * 0.08,
                            align: 'center'
                        },
                        {
                            display: 'Data Agend.',
                            name: 'dtagendamento',
                            width: width * 0.08,
                            align: 'center'
                        },
                        {
                            display: 'Re-Agend.',
                            name: 'reagendamento',
                            width: width * 0.08,
                            align: 'center'
                        },
                        {
                            display: 'Motivo',
                            name: 'motivo',
                            width: width * 0.2,
                            align: 'left'
                        },
                        {
                            display: 'Observacoes Entrega',
                            name: 'obsentrega',
                            width: width * 0.3,
                            align: 'left'
                        },
                        {
                            display: 'Romaneio',
                            name: 'romaneio',
                            width: width * 0.08,
                            align: 'center'
                        },
                        {
                            display: 'Data',
                            name: 'romdata',
                            width: width * 0.08,
                            align: 'center'
                        },
                        {
                            display: 'IMP',
                            name: 'imp',
                            width: width * 0.02,
                            align: 'center'
                        }

                        /*
                         {
                         display: 'gerawms',
                         name : 'gerawms',
                         width : width * 0.05,
                         align: 'center'
                         }
                         */

                    ],
                    sortname: "seq",
                    sortorder: "asc"

                });


    } else
    {

        $("#accordion").accordion("activate", 1);
        $('#tblResultado').html('');

    }

    //alert('xxx');
    //imprime2();

    trimjs(dataIniciox);

    var dt1 = '';
    var dt2 = '';

    if (txt == '') {
        dt1 = $('#dataInicio').val();
        dt2 = $('#dataFim').val();
    } else
    {

        anoi = dataIniciox.substring(0, 4);
        mesi = dataIniciox.substring(5, 7);
        diai = dataIniciox.substring(8, 10);

        dt1 = diai + '/' + mesi + '/' + anoi;

        anof = dataFimx.substring(0, 4);
        mesf = dataFimx.substring(5, 7);
        diaf = dataFimx.substring(8, 10);

        dt2 = diaf + '/' + mesf + '/' + anof;

    }

    var x = '<strong>PEDIDOS LIBERADOS DE ' + dt1 + ' ATÉ ' + dt2 + '</strong>';
    var y = 'TOTAL DE PEDIDOS: ' + numLinha;

    $('#tblResultado2').html(x);
    $('#tblResultado3').html(y);

    $.unblockUI();


}

function abre_pedtrans(codped) {

    window.open('alterarpvendatransportadora.php?pvnumero=' + codped
            , 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');

}

function abre_pedvenda(codped) {

    /*
    window.open('pedvendaconsx.php?codped=' + codped
            + '&vdtinicio=' + vdtinicio
            + '&vdtfinal=' + vdtfinal
            + '&vtp=' + vtp
            , 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');
    */


}


function voltar() {

    window.open('consultapedidosliberadosn.php', '_self');

}

function vetor(valor) {

    /*     var ver=0;
     
     for(var i = 0 ; i < 100 ; i++) {
     if (vet[i]==valor){
     vet[i]=0;
     i=100;
     ver=1;
     }
     }
     
     if (ver==0){
     for(var i = 0 ; i < 100 ; i++) {
     if (vet[i]==0){
     vet[i]=valor;
     i=100;
     }
     }
     }
     
     */

    //load_grid(vdtinicio,vdtfinal,vtp);

}



function nimp() {

    for (i = 0; i < vmax; i++) {

        if (document.getElementById('H' + i).value != 0) {
            document.getElementById('chk' + i).checked = true;
        } else {
            document.getElementById('chk' + i).checked = false;
        }


    }
}


function todos() {



    if (vmarca == 0) {
        vmarca = 1;
    } else {
        vmarca = 0;
    }


    for (i = 0; i < vmax; i++) {

        if (vmarca == 1) {
            document.getElementById('chk' + i).checked = true;
        } else {
            document.getElementById('chk' + i).checked = false;
        }

    }


}


function impped() {


    var campovet = ""


    for (i = 0; i < vmax; i++) {

        if (campovet == "") {
            if (document.getElementById('chk' + i).checked == true) {
                campovet = campovet + 'c[]=' + document.getElementById('chk' + i).value
            }
        } else {
            if (document.getElementById('chk' + i).checked == true) {
                campovet = campovet + '&c[]=' + document.getElementById('chk' + i).value
            }
        }

    }

    radioimp = 0;
    valor = 0;

    window.open('relpedidopdf.php?pvnumero=' + valor
            + '&radioimp=' + radioimp
            + '&' + campovet
            , 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');



}

function imprimir(valor) {

    //alert(vmax);

    var campovet = ""

    for (i = 0; i < vmax; i++) {

        if (campovet == "") {
            if (document.getElementById('chk' + i).checked == true) {
                campovet = campovet + 'c[]=' + document.getElementById('chk' + i).value
            }
        } else {
            if (document.getElementById('chk' + i).checked == true) {
                campovet = campovet + '&c[]=' + document.getElementById('chk' + i).value
            }
        }

    }


    radioimp = 0;
    valor = 0;



    //Matriz
    if (vtplocal == 1) {
        window.open('relpedseparatpdfmat.php?pvnumero=' + valor
                + '&radioimp=' + radioimp
                + '&' + campovet
                , 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');
    }
    //Filial
    else if (vtplocal == 2) {
        window.open('relpedseparatpdffil.php?pvnumero=' + valor
                + '&radioimp=' + radioimp
                + '&' + campovet
                , 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');
    }
    //Deposito
    else if (vtplocal == 3) {
        window.open('relpedseparatpdf.php?pvnumero=' + valor
                + '&radioimp=' + radioimp
                + '&' + campovet
                , 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');
    }
    //Vitoria
    else if (vtplocal == 4) {
        window.open('relpedseparatpdfvit.php?pvnumero=' + valor
                + '&radioimp=' + radioimp
                + '&' + campovet
                , 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');
    }
    //Vitoria
    else if (vtplocal == 5) {
        window.open('relpedseparatpdfcivit.php?pvnumero=' + valor
                + '&radioimp=' + radioimp
                + '&' + campovet
                , 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');
    } else
    {
        window.open('relpedseparatpdf.php?pvnumero=' + valor
                + '&radioimp=' + radioimp
                + '&' + campovet
                , 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');
    }


//      for(var i = 0 ; i < 10000 ; i++) {
//          if (vet[i]!=0){
//             alert(vet[i]);
//         }
//      }

}







function abre_txtconf(valor) {



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


        ajax2.open("POST", "pedvendapesquisavia2.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                //idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLconf(ajax2.responseXML, valor);
                } else {
                    //alert(0);  
                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }



}


function processXMLconf(obj, valor) {


    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados

        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;

            var pvlibdep = item.getElementsByTagName("pvlibdep")[0].firstChild.nodeValue;
            var pvlibmat = item.getElementsByTagName("pvlibmat")[0].firstChild.nodeValue;
            var pvlibfil = item.getElementsByTagName("pvlibfil")[0].firstChild.nodeValue;
            var pvlibvit = item.getElementsByTagName("pvlibvit")[0].firstChild.nodeValue;
            var pvlibgre = item.getElementsByTagName("pvlibgre")[0].firstChild.nodeValue;


            if (pvlibdep == '0' && pvlibmat == '0' && pvlibfil == '0' && pvlibvit == '0' && pvlibgre == '0') {
                vtip = 'D';
            } else if (pvlibdep == '1' && pvlibmat == '0' && pvlibfil == '0' && pvlibvit == '0' && pvlibgre == '0') {
                vtip = 'D';
            } else if (pvlibdep == '0' && pvlibmat == '1' && pvlibfil == '0' && pvlibvit == '0' && pvlibgre == '0') {
                vtip = 'M';
            } else if (pvlibdep == '0' && pvlibmat == '0' && pvlibfil == '1' && pvlibvit == '0' && pvlibgre == '0') {
                vtip = 'F';
            } else if (pvlibdep == '0' && pvlibmat == '0' && pvlibfil == '0' && pvlibvit == '1' && pvlibgre == '0') {
                vtip = 'V';
            } else if (pvlibdep == '0' && pvlibmat == '0' && pvlibfil == '0' && pvlibvit == '0' && pvlibgre == '1') {
                vtip = 'G';
            } else if (pvlibdep == '1') {
                vtip = 'D';
            } else if (pvlibmat == '1') {
                vtip = 'M';
            } else if (pvlibfil == '1') {
                vtip = 'F';
            } else if (pvlibvit == '1') {
                vtip = 'V';
            } else if (pvlibgre == '1') {
                vtip = 'G';
            }

            trimjs(codigo);
            codigo = txt;

            /*
             if  (codigo!='0'){
             alert('A via de separação já foi impressa ' + codigo + ' vez(es)!') ;
             }
             */

        }
    } else {
        //alert(0);  
    }

    abre_txt2conf(valor);


}

function abre_txt2conf(valor) {

    radioimp = 0;

    if (vtip == 'D') {
        window.open('conferenciaconsulta.php?pvnumero=' + valor, '_blank');
    } else if (vtip == 'M') {
        window.open('conferenciaconsultamatriz.php?pvnumero=' + valor, '_blank');
    } else if (vtip == 'F') {
        window.open('conferenciaconsultafilial.php?pvnumero=' + valor, '_blank');
    } else if (vtip == 'V') {
        window.open('conferenciaconsulta.php?pvnumero=' + valor, '_blank');
    } else if (vtip == 'G') {
        window.open('conferenciaconsulta.php?pvnumero=' + valor, '_blank');
    }

}







function abre_wmsconf(valor) {


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


        ajax2.open("POST", "pedvendapesquisavianovo.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                //idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLwms(ajax2.responseXML, valor);
                } else {
                    //alert(0);  
                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }



}


function processXMLwms(obj, valor) {



    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados

        for (var i = 0; i < dataArray.length; i++) {



            var item = dataArray[i];

            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var pvlibdep = item.getElementsByTagName("pvlibdep")[0].firstChild.nodeValue;
            var pvlibmat = item.getElementsByTagName("pvlibmat")[0].firstChild.nodeValue;
            var pvlibfil = item.getElementsByTagName("pvlibfil")[0].firstChild.nodeValue;
            var pvlibvit = item.getElementsByTagName("pvlibvit")[0].firstChild.nodeValue;
            var pvlibgre = item.getElementsByTagName("pvlibgre")[0].firstChild.nodeValue;
            var pvlibcivit = item.getElementsByTagName("pvlibcivit")[0].firstChild.nodeValue;

            if (pvlibdep == '0' && pvlibmat == '0' && pvlibfil == '0' && pvlibvit == '0' && pvlibcivit == '0' && pvlibgre == '0') {
                vtip = 'D';
            } else if (pvlibdep == '1' && pvlibmat == '0' && pvlibfil == '0' && pvlibvit == '0' && pvlibcivit == '0' && pvlibgre == '0') {
                vtip = 'D';
            } else if (pvlibdep == '0' && pvlibmat == '1' && pvlibfil == '0' && pvlibvit == '0' && pvlibcivit == '0' && pvlibgre == '0') {
                vtip = 'M';
            } else if (pvlibdep == '0' && pvlibmat == '0' && pvlibfil == '1' && pvlibvit == '0' && pvlibcivit == '0' && pvlibgre == '0') {
                vtip = 'F';
            } else if (pvlibdep == '0' && pvlibmat == '0' && pvlibfil == '0' && pvlibvit == '1' && pvlibcivit == '0' && pvlibgre == '0') {
                vtip = 'V';
            } else if (pvlibdep == '0' && pvlibmat == '0' && pvlibfil == '0' && pvlibvit == '0' && pvlibcivit == '1' && pvlibgre == '0') {
                vtip = 'C';
            } else if (pvlibdep == '0' && pvlibmat == '0' && pvlibfil == '0' && pvlibvit == '0' && pvlibcivit == '0' && pvlibgre == '1') {
                vtip = 'G';
            } else if (pvlibdep == '1') {
                vtip = 'D';
            } else if (pvlibmat == '1') {
                vtip = 'M';
            } else if (pvlibfil == '1') {
                vtip = 'F';
            } else if (pvlibvit == '1') {
                vtip = 'V';
            } else if (pvlibcivit == '1') {
                vtip = 'C';
            } else if (pvlibcigre == '1') {
                vtip = 'G';
            }

        }
    } else {
        //alert(0);  
    }

    abre_wms2conf(valor);


}

function abre_wms2conf(valor) {
    /*
     if (vtip=='D' || vtip=='V' || vtip=='G'){
     new ajax('exportawmspedidos.php?pedido='+valor, {onComplete: verfinaliza});		
     }
     else if (vtip=='M'){
     alert( "Pedidos Matriz sem geração WMS" );
     }
     else if (vtip=='F'){
     alert( "Pedidos Filial sem geração WMS" );		
     }
     else if (vtip=='C'){
     alert( "Pedidos CIVIT sem geração WMS" );		
     }	
     */
    // new ajax('exportawmspedidos.php?pedido='+valor, {onComplete: verfinaliza(valor)});		


    var campovet = ""

    campovet = campovet + 'c[]=' + valor;

    radioimp = 0;
    valor = 0;

    window.open('exportageradatasulpedidovarios.php?pvnumero=' + valor
            + '&radioimp=' + radioimp
            + '&' + campovet
            , '_blank');

}

function verfinaliza(valor) {

    alert("Arquivo WMS gerado !");

    new ajax('exportadatasulpedidos.php?pedido=' + valor, {onComplete: verfinalizaz});

}

function verfinalizaz() {

    alert("Arquivo WMS-Datasul gerado !");

}


function verificapedido(numped) {

    var encontrou = 0;

    trimjs(numped)
    if (txt == "") {

    } else {

        for (i = 0; i < vmax; i++) {

            if (document.getElementById('chk' + i).value == numped) {
                document.getElementById('chk' + i).checked = true;
                encontrou = 1;
            }

        }

        if (encontrou == 0) {
            alert("Pedido: " + numped + " não encontrado!");
        }

        document.getElementById("pedido").value = "";
        document.getElementById("pedido").focus();

    }

}

function excel() {

    var tp = 0;
    var tp2 = 0;
    var tpt = 0;
    var tpe = 0;
    var tpz = 0;
    var tpl = 0;

    if (document.getElementById("radio1").checked == true) {
        tp = 1;
    } else if (document.getElementById("radio2").checked == true) {
        tp = 2;
    } else if (document.getElementById("radio3").checked == true) {
        tp = 3;
    } else if (document.getElementById("radio4").checked == true) {
        tp = 4;
    } else {
        tp = 5;
    }

    if (document.getElementById("radio21").checked == true) {
        tp2 = 1;
    } else if (document.getElementById("radio22").checked == true) {
        tp2 = 2;
    } else {
        tp2 = 3;
    }

    if (document.getElementById("radiot1").checked == true) {
        tpt = 1;
    } else if (document.getElementById("radiot2").checked == true) {
        tpt = 2;
    } else {
        tpt = 3;
    }

    if (document.getElementById("radioe1").checked == true) {
        tpe = 1;
    } else if (document.getElementById("radioe2").checked == true) {
        tpe = 2;
    } else {
        tpe = 3;
    }

    if (document.getElementById("radioz1").checked == true) {
        tpz = 1;
    } else if (document.getElementById("radioz2").checked == true) {
        tpz = 2;
    } else {
        tpz = 3;
    }
    
    if (document.getElementById("radiol1").checked == true) {
        tpl = 1;
    } else if (document.getElementById("radiol2").checked == true) {
        tpl = 2;
    } else {
        tpl = 3;
    }

    modo = 3;

    for (var i = 0; i < 500; i++) {
        vet[i][0] = 0;
        vet[i][1] = 0;
        vet[i][2] = 0;
        vet[i][3] = 0;
        vet[i][4] = 0;
        vet[i][5] = 0;
        vet[i][6] = 0;
        vet[i][7] = 0;
        vet[i][8] = 0;
        vet[i][9] = 0;
        vet[i][10] = 0;
        vet[i][11] = 0;
        vet[i][12] = 0;
        vet[i][13] = 0;
        vet[i][14] = 0;
        vet[i][15] = 0;
        vet[i][16] = 0;
        vet[i][17] = 0;
        vet[i][18] = 0;
        vet[i][19] = 0;
        vet[i][20] = 0;
        vet[i][21] = 0;
        vet[i][22] = 0;
        vet[i][23] = 0;
        vet[i][24] = 0;
        vet[i][25] = 0;
        vet[i][26] = 0;
        vet[i][27] = 0;
        vet[i][28] = 0;
        vet[i][29] = 0;
        vet[i][30] = 0;
        vet[i][31] = 0;
        vet[i][32] = 0;
        vet[i][33] = 0;
        vet[i][34] = 0;
        vet[i][35] = 0;
        vet[i][36] = 0;
        vet[i][37] = 0;
        vet[i][38] = 0;
        vet[i][39] = 0;
        vet[i][40] = 0;
        vet[i][41] = 0;
        vet[i][42] = 0;
        vet[i][43] = 0;
        vet[i][44] = 0;
        vet[i][45] = 0;
    }




    var dataInicio = new Date().dateBr(($('#dataInicio').val()));
    var horaInicio = $('#horaInicio').val();
    var dataFim = new Date().dateBr(($('#dataFim').val()));
    var horaFim = $('#horaFim').val();

    nivelUsuario = nivel;

    dataInicio.setTimes(horaInicio);
    dataFim.setTimes(horaFim);

    var aTipo = new Array();
    var aEstoque = new Array();
    var aTransportadora = new Array();

    var nTipo = 0;
    var nEstoque = 0;
    var nTransportadora = 0;

    var campovet1 = "";
    var campovet2 = "";
    var campovet3 = "";

    $('#listaTipoPedidos option:selected').each(function ()
    {
        if ($(this).val())
        {
            aTipo[nTipo] = $(this).val();
            nTipo = nTipo + 1;

            campovet1 = campovet1 + '&1[]=' + $(this).val();

        }
    });

    $('#listaEstoqueFisico option:selected').each(function ()
    {
        if ($(this).val())
        {
            aEstoque[nEstoque] = $(this).val();
            nEstoque = nEstoque + 1;

            campovet2 = campovet2 + '&2[]=' + $(this).val();

            vtplocal = $(this).val();

        }
    });

    $('#listaTransportadora option:selected').each(function ()
    {
        if ($(this).val())
        {
            aTransportadora[nTransportadora] = $(this).val();
            nTransportadora = nTransportadora + 1;

            campovet3 = campovet3 + '&3[]=' + $(this).val();

            vTransportadora = $(this).val();

        }
    });


    vdtinicio = dataInicio.format("Ymd");
    vdtfinal = dataFim.format("Ymd");
    vtp = tp;

    dataInicio = dataInicio.format("Y-m-d H:i:s");
    dataFim = dataFim.format("Y-m-d H:i:s");

    var dataInicioz = $('#dataInicio').val();
    var dataFimz = $('#dataFim').val();

    dataInicio = dataInicioz.substring(6, 10) + '-' + dataInicioz.substring(3, 5) + '-' + dataInicioz.substring(0, 2) + ' ' + horaInicio;
    dataFim = dataFimz.substring(6, 10) + '-' + dataFimz.substring(3, 5) + '-' + dataFimz.substring(0, 2) + ' ' + horaFim;

    if (nTipo == 0) {
        aTipo[nTipo] = 0;
    }
    if (nEstoque == 0) {
        aEstoque[nEstoque] = 0;
    }
    if (nTransportadora == 0) {
        aTransportadora[nTransportadora] = 0;
    }

    window.open('consultapedidosliberadosexceln.php?dataInicio=' + dataInicio + '&horaInicio=' + horaInicio + '&dataFim=' + dataFim + '&horaFim=' + horaFim + '&tp=' + tp + '&tp2=' + tp2 + '&tpt=' + tpt + '&tpe=' + tpe + '&tpz=' + tpz + '&tpl=' + tpl + campovet1 + campovet2 + campovet3, '_blank');
}


function abre_txt(valor) {



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


        ajax2.open("POST", "pedvendapesquisavianovo.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                //idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLvia(ajax2.responseXML, valor);
                } else {
                    //alert(0);  
                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }



}



function processXMLvia(obj, valor) {


    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados

        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;

            var pvlibdep = item.getElementsByTagName("pvlibdep")[0].firstChild.nodeValue;
            var pvlibmat = item.getElementsByTagName("pvlibmat")[0].firstChild.nodeValue;
            var pvlibfil = item.getElementsByTagName("pvlibfil")[0].firstChild.nodeValue;
            var pvlibvit = item.getElementsByTagName("pvlibvit")[0].firstChild.nodeValue;
            var pvlibgre = item.getElementsByTagName("pvlibgre")[0].firstChild.nodeValue;
            var pvlibcivit = item.getElementsByTagName("pvlibcivit")[0].firstChild.nodeValue;


            if (pvlibdep == '0' && pvlibmat == '0' && pvlibfil == '0' && pvlibvit == '0' && pvlibcivit == '0' && pvlibgre == '0') {
                vtip = 'D';
            } else if (pvlibdep == '1' && pvlibmat == '0' && pvlibfil == '0' && pvlibvit == '0' && pvlibcivit == '0' && pvlibgre == '0') {
                vtip = 'D';
            } else if (pvlibdep == '0' && pvlibmat == '1' && pvlibfil == '0' && pvlibvit == '0' && pvlibcivit == '0' && pvlibgre == '0') {
                vtip = 'M';
            } else if (pvlibdep == '0' && pvlibmat == '0' && pvlibfil == '1' && pvlibvit == '0' && pvlibcivit == '0' && pvlibgre == '0') {
                vtip = 'F';
            } else if (pvlibdep == '0' && pvlibmat == '0' && pvlibfil == '0' && pvlibvit == '1' && pvlibcivit == '0' && pvlibgre == '0') {
                vtip = 'V';
            } else if (pvlibdep == '0' && pvlibmat == '0' && pvlibfil == '0' && pvlibvit == '0' && pvlibcivit == '1' && pvlibgre == '0') {
                vtip = 'C';
            } else if (pvlibdep == '0' && pvlibmat == '0' && pvlibfil == '0' && pvlibvit == '0' && pvlibcivit == '0' && pvlibgre == '1') {
                vtip = 'G';
            } else if (pvlibdep == '1') {
                vtip = 'D';
            } else if (pvlibmat == '1') {
                vtip = 'M';
            } else if (pvlibfil == '1') {
                vtip = 'F';
            } else if (pvlibvit == '1') {
                vtip = 'V';
            } else if (pvlibcivit == '1') {
                vtip = 'C';
            } else if (pvlibgre == '1') {
                vtip = 'G';
            }

            trimjs(codigo);
            codigo = txt;

            if (codigo != '0') {
                alert('A via de separação já foi impressa ' + codigo + ' vez(es)!');
            }

        }
    } else {
        //alert(0);  
    }

    abre_txt2(valor);


}


function abre_txt2(valor) {

    radioimp = 0;

    if (vtip == 'D') {
        window.open('relpedseparapdf.php?pvnumero=' + valor + '&radioimp=' + radioimp, 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');
    } else if (vtip == 'M') {
        window.open('relpedseparapdfmat.php?pvnumero=' + valor + '&radioimp=' + radioimp, 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');
    } else if (vtip == 'F') {
        window.open('relpedseparapdffil.php?pvnumero=' + valor + '&radioimp=' + radioimp, 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');
    } else if (vtip == 'V') {
        window.open('relpedseparapdfvit.php?pvnumero=' + valor + '&radioimp=' + radioimp, 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');
    } else if (vtip == 'D') {
        window.open('relpedseparapdfcivit.php?pvnumero=' + valor + '&radioimp=' + radioimp, 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');
    } else if (vtip == 'G') {
        window.open('relpedseparapdfgre.php?pvnumero=' + valor + '&radioimp=' + radioimp, 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');
    }

}

function gera_datasul() {

    var campovet = ""

    for (i = 0; i < vmax; i++) {

        if (campovet == "") {
            if (document.getElementById('chk' + i).checked == true) {
                campovet = campovet + 'c[]=' + document.getElementById('chk' + i).value
            }
        } else {
            if (document.getElementById('chk' + i).checked == true) {
                campovet = campovet + '&c[]=' + document.getElementById('chk' + i).value
            }
        }

    }

    if (campovet == '') {
        alert('Selecione pelo menos 1 pedido!');
    } else {
        radioimp = 0;
        valor = 0;

        window.open('exportageradatasulpedidovarios.php?pvnumero=' + valor
                + '&radioimp=' + radioimp
                + '&' + campovet
                , '_blank');
    }

}


function cross() {

    var tp = 0;
    var tp2 = 0;
    var tpt = 0;
    var tpe = 0;
    var tpz = 0;
    var tpl = 0;

    if (document.getElementById("radio1").checked == true) {
        tp = 1;
    } else if (document.getElementById("radio2").checked == true) {
        tp = 2;
    } else if (document.getElementById("radio3").checked == true) {
        tp = 3;
    } else if (document.getElementById("radio4").checked == true) {
        tp = 4;
    } else {
        tp = 5;
    }

    if (document.getElementById("radio21").checked == true) {
        tp2 = 1;
    } else if (document.getElementById("radio22").checked == true) {
        tp2 = 2;
    } else {
        tp2 = 3;
    }

    if (document.getElementById("radiot1").checked == true) {
        tpt = 1;
    } else if (document.getElementById("radiot2").checked == true) {
        tpt = 2;
    } else {
        tpt = 3;
    }

    if (document.getElementById("radioe1").checked == true) {
        tpe = 1;
    } else if (document.getElementById("radioe2").checked == true) {
        tpe = 2;
    } else {
        tpe = 3;
    }

    if (document.getElementById("radioz1").checked == true) {
        tpz = 1;
    } else if (document.getElementById("radioz2").checked == true) {
        tpz = 2;
    } else {
        tpz = 3;
    }
    
    if (document.getElementById("radiol1").checked == true) {
        tpl = 1;
    } else if (document.getElementById("radiol2").checked == true) {
        tpl = 2;
    } else {
        tpl = 3;
    }

    modo = 3;

    for (var i = 0; i < 500; i++) {
        vet[i][0] = 0;
        vet[i][1] = 0;
        vet[i][2] = 0;
        vet[i][3] = 0;
        vet[i][4] = 0;
        vet[i][5] = 0;
        vet[i][6] = 0;
        vet[i][7] = 0;
        vet[i][8] = 0;
        vet[i][9] = 0;
        vet[i][10] = 0;
        vet[i][11] = 0;
        vet[i][12] = 0;
        vet[i][13] = 0;
        vet[i][14] = 0;
        vet[i][15] = 0;
        vet[i][16] = 0;
        vet[i][17] = 0;
        vet[i][18] = 0;
        vet[i][19] = 0;
        vet[i][20] = 0;
        vet[i][21] = 0;
        vet[i][22] = 0;
        vet[i][23] = 0;
        vet[i][24] = 0;
        vet[i][25] = 0;
        vet[i][26] = 0;
        vet[i][27] = 0;
        vet[i][28] = 0;
        vet[i][29] = 0;
        vet[i][30] = 0;
        vet[i][31] = 0;
        vet[i][32] = 0;
        vet[i][33] = 0;
        vet[i][34] = 0;
        vet[i][35] = 0;
        vet[i][36] = 0;
        vet[i][37] = 0;
        vet[i][38] = 0;
        vet[i][39] = 0;
        vet[i][40] = 0;
        vet[i][41] = 0;
        vet[i][42] = 0;
        vet[i][43] = 0;
        vet[i][44] = 0;
        vet[i][45] = 0;
    }




    var dataInicio = new Date().dateBr(($('#dataInicio').val()));
    var horaInicio = $('#horaInicio').val();
    var dataFim = new Date().dateBr(($('#dataFim').val()));
    var horaFim = $('#horaFim').val();

    nivelUsuario = nivel;

    dataInicio.setTimes(horaInicio);
    dataFim.setTimes(horaFim);

    var aTipo = new Array();
    var aEstoque = new Array();
    var aTransportadora = new Array();

    var nTipo = 0;
    var nEstoque = 0;
    var nTransportadora = 0;

    var campovet1 = "";
    var campovet2 = "";
    var campovet3 = "";

    $('#listaTipoPedidos option:selected').each(function ()
    {
        if ($(this).val())
        {
            aTipo[nTipo] = $(this).val();
            nTipo = nTipo + 1;

            campovet1 = campovet1 + '&1[]=' + $(this).val();

        }
    });

    $('#listaEstoqueFisico option:selected').each(function ()
    {
        if ($(this).val())
        {
            aEstoque[nEstoque] = $(this).val();
            nEstoque = nEstoque + 1;

            campovet2 = campovet2 + '&2[]=' + $(this).val();

            vtplocal = $(this).val();

        }
    });

    $('#listaTransportadora option:selected').each(function ()
    {
        if ($(this).val())
        {
            aTransportadora[nTransportadora] = $(this).val();
            nTransportadora = nTransportadora + 1;

            campovet3 = campovet3 + '&3[]=' + $(this).val();

            vTransportadora = $(this).val();

        }
    });


    vdtinicio = dataInicio.format("Ymd");
    vdtfinal = dataFim.format("Ymd");
    vtp = tp;

    dataInicio = dataInicio.format("Y-m-d H:i:s");
    dataFim = dataFim.format("Y-m-d H:i:s");

    var dataInicioz = $('#dataInicio').val();
    var dataFimz = $('#dataFim').val();

    dataInicio = dataInicioz.substring(6, 10) + '-' + dataInicioz.substring(3, 5) + '-' + dataInicioz.substring(0, 2) + ' ' + horaInicio;
    dataFim = dataFimz.substring(6, 10) + '-' + dataFimz.substring(3, 5) + '-' + dataFimz.substring(0, 2) + ' ' + horaFim;

    if (nTipo == 0) {
        aTipo[nTipo] = 0;
    }
    if (nEstoque == 0) {
        aEstoque[nEstoque] = 0;
    }
    if (nTransportadora == 0) {
        aTransportadora[nTransportadora] = 0;
    }

    window.open('consultapedidosliberadosexcelcrossn.php?dataInicio=' + dataInicio + '&horaInicio=' + horaInicio + '&dataFim=' + dataFim + '&horaFim=' + horaFim + '&tp=' + tp + '&tp2=' + tp2 + '&tpt=' + tpt + '&tpe=' + tpe + '&tpz=' + tpz + '&tpl=' + tpl + campovet1 + campovet2 + campovet3, '_blank');
}