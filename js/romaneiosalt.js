// JavaScript Document

var vet = new Array(500);

for (var i = 0; i < 500; i++) {
    vet[i] = new Array(3);
}

for (var i = 0; i < 500; i++) {
    vet[i][0] = 0;
    vet[i][1] = "";
    vet[i][2] = "";
    vet[i][3] = "";
    vet[i][4] = 0;
    vet[i][5] = 0;
}


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

var foc = 0;

var carrega = 0;

var mensagem = 0;

var acessoPedido = 0;
var acessoConferido = 0;

function verificarAcesso(usucodigo)
{
    new ajax('verificaacessoopcao.php?usuario=' + usucodigo + '&opcao=03.04.01', {onComplete: imprime_veracesso});
}

function imprime_veracesso(request)
{



    var xmldoc = request.responseXML;

    if (xmldoc != null)
    {
        var dados = xmldoc.getElementsByTagName('dados')[0];

        //Acesso para desconto entre 5 e 10%
        var registros = xmldoc.getElementsByTagName('registro');
        for (i = 0; i < registros.length; i++)
        {
            var itens = registros[i].getElementsByTagName('item');
            if (itens[0].firstChild.data != null)
            {
                if (itens[0].firstChild.data == 'S') {
                    acessoPedido = 1;
                }
            }
        }
    }

}

function verificarAcessoConferencia(usucodigo)
{
    new ajax('verificaacessonaoconferido.php?usuario=' + usucodigo + '&opcao=03.04.02', {onComplete: imprime_veracesso_conferencia});
}

function imprime_veracesso_conferencia(request)
{

    var xmldoc = request.responseXML;

    if (xmldoc != null)
    {
        var registros = xmldoc.getElementsByTagName('registro');
        for (i = 0; i < registros.length; i++)
        {
            var itens = registros[i].getElementsByTagName('item');
            if (itens[0].firstChild.data != null)
            {
                if (itens[0].firstChild.data == 'S') {
                    acessoConferido = 1;
                } else if (itens[0].firstChild.data == 'X') {
                    acessoConferido = 2;
                } else {
                    acessoConferido = 0;
                }
            }
        }
    }

}

function Z() {
    document.forms[0].pvnumero2.focus();
}


function X() {

    var var1 = '';
    var var2 = '';

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

function ver1() {


    $("acao").value = "inserir";
    $("enviarped").value = "incluir";
    $("resultado").innerHTML = "Nenhum registro encontrado...";

    $("msg").style.visibility = "hidden";

    var contaPedidos = 0;

    var tabela = "<table class='borda'><tr>"

    tabela += "<td colspan='0'></td>"
    tabela += "<td colspan='1' class='borda'><b>Codigo1</b></td>"
    tabela += "<td colspan='1' class='borda'><b>Cliente</b></td>"
    tabela += "<td colspan='1' class='borda'><b>Volumes</b></td>"
    tabela += "<td colspan='1' class='borda'><b>Emissão</b></td>"
    tabela += "<td colspan='1' class='borda'><b>Valor</b></td>"
    tabela += "<td colspan='2' class='borda'><b>Controles</b></td>"
    tabela += "<td colspan='0'></td>"
    tabela += "</tr>"



    var totped = 0;
    var totvalped = 0;
    var x = 0;
    var y = 0;
    var z = 0;

    for (i = 0; i < vet.length; i++) {
        if (vet[i][0] != 0) {
            totped++;

            y = vet[i][5];
            x = (Math.round(y * 100)) / 100;

            totvalped = totvalped + x;
        }
    }



    var valorx = 0;
    var percentualx = 0;


    if (document.getElementById("radio1").checked == true) {
        valorx = $("valor").value;
    } else if (document.getElementById("radio2").checked == true) {
        percentualx = $("percentual").value;
        valorx = totvalped * percentualx / 100;
    } else {
        valorx = 0;
    }


    for (i = 0; i < vet.length; i++) {
        if (vet[i][0] != 0) {


            y = vet[i][5];
            x = (Math.round(y * 100)) / 100;

            z = valorx * x / totvalped;
            z = (Math.round(z * 100)) / 100;

            vet[i][4] = z;


            tabela += "<tr id=linha" + i + ">"
            tabela += "<td class='borda2'>" + 0 + "</td>";
            tabela += "<td class='borda'>" + vet[i][0] + "</td>";

            if (vet[i][1] != '') {
                tabela += "<td class='borda'>" + vet[i][1] + "</td>";
            } else {
                tabela += "<td class='borda'>.</td>";

            }
            tabela += "<td class='borda'>" + vet[i][2] + "</td>";
            tabela += "<td class='borda'>" + vet[i][3] + "</td>";

            tabela += "<td class='borda'>" + vet[i][4] + "</td>";

            tabela += "<td class='borda' style='cursor: pointer'><img src='imagens/edit.gif' onClick=editar(" + vet[i][0] + "," + "0" + "," + vet[i][2] + ",'" + vet[i][3] + "','" + vet[i][5] + "')></td>";
            tabela += "<td class='borda' style='cursor: pointer'><img src='imagens/delete.gif' onClick=apagar(" + vet[i][0] + ")></td>";

            tabela += "<td class='borda2'>" + vet[i][0] + "</td>";

            tabela += "</tr>";

            //if(i==0){
            //	$("romcodigo").value=itens[5].firstChild.data;
            //}

            contaPedidos++;

        }
    }

    tabela += "</table>"
    $("resultado").innerHTML = tabela;
    tabela = null;


    if (foc == 1) {
        $("pesquisapedido").value = '';
        $("codigopedido").value = '';
        $("cliente").value = '';
        $("volumespedido").value = '';
        $("valpedido").value = '';
        $("pedidoexpedido").value = '';
        $("pedidoconferido").value = '';


        document.forms[0].pesquisapedido.focus();
        foc = 0;
    }

    if (contaPedidos == 0) {
        $("consulta_transportadora").disabled = false;
        $("listaPesquisaTransp").disabled = false;
    } else {
        $("consulta_transportadora").disabled = true;
        $("listaPesquisaTransp").disabled = true;
    }


}


function apagar(codigo) {

    for (var i = 0; i < 500; i++) {

        if (vet[i][0] == codigo) {
            vet[i][0] = 0;
            vet[i][1] = "";
            vet[i][2] = "";
            vet[i][3] = "";
            vet[i][4] = 0;
            vet[i][5] = 0;
        }


    }

    ver1();

}

function verificapedido() {


    valor = document.getElementById('codigopedido').value;
    valor2 = document.getElementById('cliente').value;
    valor3 = Math.round(document.getElementById('volumespedido').value);
    valor4 = document.getElementById('emissao').value;

    valor5 = 0;
    valor6 = document.getElementById('valpedido').value;

    foc = 1;

    if ($("acao").value == "inserir") {

        var pedidoExpedido = $("pedidoexpedido").value;
        var pedidoConferido = $("pedidoconferido").value;

        var podeContinuar = 0;
        if (pedidoExpedido == 0 && acessoPedido == 1) {
            //alert("Pedido " + valor + " não foi Expedido no Coletor! Usuário com permissão para Continuar.");
            podeContinuar = 1;
        }

        if (pedidoExpedido == 1 || podeContinuar == 1) {

            if (acessoConferido > 0 || pedidoConferido == 1) {

                var j = 0;
                for (var i = 0; i < 500; i++) {

                    if (vet[i][0] == valor) {
                        alert("Pedido já Incluido!");
                        i = 500;
                        j = 1;
                    }

                }

                if (j == 0) {
                    for (var i = 0; i < 500; i++) {

                        if (vet[i][0] == 0) {
                            vet[i][0] = valor;
                            vet[i][1] = valor2;
                            vet[i][2] = valor3;
                            vet[i][3] = valor4;

                            vet[i][4] = valor5;
                            vet[i][5] = valor6;

                            i = 500;

                        }

                    }
                }
            } else {
                alert("Pedido " + valor + " não foi Conferido!");
            }

        } else {
            alert("Pedido " + valor + " não foi Expedido no Coletor!");
        }

    } else if ($("acao").value == "alterar") {

        for (var i = 0; i < 500; i++) {

            if (vet[i][0] == valor) {
                vet[i][1] = valor2;
                vet[i][2] = valor3;
                vet[i][3] = valor4;

                vet[i][4] = valor5;
                vet[i][5] = valor6;

            }

        }

    }


    ver1();

}



function verifica() {

    var num = $("pvnumero").value;
    var num1 = '';

    for (i = num.length; i < 12; i++)
    {
        num1 = num1 + '0'
    }

    num1 = num1 + num;

//alert(num1);

    var numer = num1.substr(0, 7);
    var numano = num1.substr(8, 4);
    var bar = num1.substr(7, 1);

//numer=parseInt(numer);
    numano = parseInt(numano);

//alert(numer);
//alert(bar);
//alert(numano);

    if (bar != '/') {
        alert("Numero do romaneio Inválido!");
        $("button").disabled = false;
        document.getElementById("pvnumero").focus();
    } else if (numer == 0) {
        alert("Numero do romaneio Inválido!");
        $("button").disabled = false;
        document.getElementById("pvnumero").focus();
    } else if (numano == 0) {
        alert("Numero do romaneio Inválido!");
        $("button").disabled = false;
        document.getElementById("pvnumero").focus();
    } else if ($("pvnumero").value == "") {
        alert("Digite o numero do romaneio!");
        $("button").disabled = false;
        document.getElementById("pvnumero").focus();
    } else if (validar_data($("data").value) == false) {
        alert("Data Invalida!");
        $("button").disabled = false;
        document.getElementById("data").focus();
    } else if ($("data").value == "") {
        alert("Digite a data!");
        $("button").disabled = false;
        document.getElementById("data").focus();
    } else if ($("saida").value == "") {
        alert("Digite a saida!");
        $("button").disabled = false;
        document.getElementById("saida").focus();
    } else if ($("motorista").value == "") {
        alert("Digite o Motorista!");
        $("button").disabled = false;
        document.getElementById("motorista").focus();
    }

    // else if($("ajudante").value==""){
    //    alert("Digite o Ajudante!");
    //    document.getElementById("ajudante").focus();
    //}

    else if ($("inicial").value == "") {
        //alert("Digite a KM inicial!");
        alert("Digite a Placa do Veículo!");
        $("button").disabled = false;
        document.getElementById("inicial").focus();
    }
    //else if($("final").value==""){
    //   alert("Digite a KM Final!");
    //   document.getElementById("final").focus();
    //}
    else if ($("valor").value == "") {
        alert("Digite o Valor!");
        $("button").disabled = false;
        document.getElementById("valor").focus();
    } else if ($("percentual").value == "") {
        alert("Digite o percentual!");
        $("button").disabled = false;
        document.getElementById("percentual").focus();
    } else if ($a("#listaPesquisaTransp").val() == "0") {
        alert("Informe a Transportadora!");
        $("button").disabled = false;
        document.getElementById("txtPesquisaTransp").focus();
    } else {
        enviarromaneio();
    }
}



//----------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------

function limpa_form() {
    window.open('romaneiosalt.php', '_self');
}

function limpa_formold() {

    carrega = 0;

    $("acao").value = "Incluir";
    $("enviarped").value = "Incluir";

    $("button").value = 'Salva';

    $("pvnumero").value = "";

    $("pvnumero1").value = "";
    $("pvnumero2").value = "";

    $("romcodigo").value = "0";
    $("data").value = "";
    $("saida").value = "";
    $("motorista").value = "";
    $("emissor").value = "";
    $("ajudante").value = "";
    $("placa").value = "";
    $("inicial").value = "";
    $("final").value = "";
    //radio
    $("valor").value = "";
    $("observacoes").value = "";
    $("pesquisapedido").value = "";
    $("volumespedido").value = "";

    $("data").value = dia + '/' + mes + '/' + ano;

    $("cliente").value = "";

    $a("#listaPesquisaTransp").val("");



    document.getElementById("data").disabled = true;

    document.getElementById("valor").disabled = false;
    document.getElementById("percentual").value = 0;
    document.getElementById("percentual").disabled = true;

    document.getElementById("radio1").checked = true;

    document.forms[0].listveiculos.options.length = 1;
    idOpcao = document.getElementById("opcoesveiculos");
    idOpcao.innerHTML = "____________________";


    $("resultado").innerHTML = "";


    numero_romaneio('0');

    for (var i = 0; i < 500; i++) {
        vet[i][0] = 0;
        vet[i][1] = "";
        vet[i][2] = "";
        vet[i][3] = "";
        vet[i][4] = 0;
        vet[i][5] = 0;
    }


    //  document.forms[0].data.focus();

}

//----------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------
//-------------------------ROTINAS DE INCLUSAO DE PEDIDOS---------------------------------
//----------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------

function carregando() {
    $("msg").style.visibility = "visible";
    $("msg").innerHTML = "Processando...";
}


function dadospesquisapedido(valor) {

    trimjs(valor);

    //Se estiver com o numero em branco nao faz nada	
    if (txt != '') {


        //Verifica se ja escolheu a Transportadora
        if ($a("#listaPesquisaTransp").val() == "0") {
            alert("Informe a Transportadora antes de digitar os pedidos!");

            $("volumespedido").value = "";
            $("codigopedido").value = "";
            $("cliente").value = "";

            $("valpedido").value = "";
            $("pedidoexpedido").value = '';
            $("pedidoconferido").value = '';

            document.getElementById("pesquisapedido").focus();

            $("acao").value = "inserir";
            $("enviarped").value = "incluir";

        } else {

            var tipoPesquisa = 1;

            var codTr = $a("#listaPesquisaTransp").val();

            new ajax('romaneiospesquisapedidonovoembarquetr.php?parametro=' + valor + "&parametro2=" + tipoPesquisa + "&parametro3=" + codTr, {onComplete: imprime_pedido});

        }

    }

}

function imprime_pedido(request)
{


    var xmldoc = request.responseXML;
    if (xmldoc != null)
    {
        var dados = xmldoc.getElementsByTagName('dados')[0];
        var registros = xmldoc.getElementsByTagName('dado');

        var itens = registros[0].getElementsByTagName('item');

        var codigo = itens[0].firstChild.data;
        var erro = itens[10].firstChild.data;

        var bloqueado = itens[12].firstChild.data;

        if (codigo == 0) {

            alert('Pedido não encontrado !');

            $("volumespedido").value = "";
            $("codigopedido").value = "";
            $("cliente").value = "";

            $("valpedido").value = "";
            $("pedidoexpedido").value = '';
            $("pedidoconferido").value = '';

            document.getElementById("pesquisapedido").focus();

            $("acao").value = "inserir";
            $("enviarped").value = "incluir";


        } else if (erro != '_') {

            alert('Pedido pertence a ' + erro + ' não é permitido selecionar para esse Romaneio!');

            $("pesquisapedido").value = "";
            $("volumespedido").value = "";
            $("codigopedido").value = "";
            $("cliente").value = "";

            $("valpedido").value = "";
            $("pedidoexpedido").value = '';
            $("pedidoconferido").value = '';

            document.getElementById("pesquisapedido").focus();

            $("acao").value = "inserir";
            $("enviarped").value = "incluir";


        } else if (bloqueado != '_') {

            alert(bloqueado);

            $("pesquisapedido").value = "";
            $("volumespedido").value = "";
            $("codigopedido").value = "";
            $("cliente").value = "";

            $("valpedido").value = "";
            $("pedidoexpedido").value = '';
            $("pedidoconferido").value = '';

            document.getElementById("pesquisapedido").focus();

            $("acao").value = "inserir";
            $("enviarped").value = "incluir";

        } else {

            var descricao = itens[1].firstChild.data;
            var descricao2 = itens[2].firstChild.data;
            var descricao3 = itens[3].firstChild.data;
            var descricao4 = itens[4].firstChild.data;

            var descricao5 = itens[5].firstChild.data;
            var descricao6 = itens[6].firstChild.data;

            var descricao7 = itens[7].firstChild.data;
            var descricao8 = itens[8].firstChild.data;
            var expedido = itens[9].firstChild.data;
            var conferido = itens[11].firstChild.data;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;
            trimjs(descricao2);
            descricao2 = txt;
            trimjs(descricao3);
            descricao3 = txt;
            trimjs(descricao4);
            descricao4 = txt;

            trimjs(descricao5);
            descricao5 = txt;
            trimjs(descricao6);
            descricao6 = txt;

            trimjs(descricao7);
            descricao7 = txt;
            trimjs(descricao8);
            descricao8 = txt;

            var vol = 0;

            if (descricao5 == 'S') {
                if (descricao2 != '0') {
                    vol = descricao2;
                } else {
                    vol = descricao6;
                }
            } else {
                if (descricao6 != '0') {
                    vol = descricao6;
                } else {
                    vol = descricao2;
                }
            }

            //$("volumespedido").value=descricao2;
            $("volumespedido").value = vol;
            $("codigopedido").value = descricao;
            $("cliente").value = descricao3 + " " + descricao4;
            $("emissao").value = descricao7;

            $("valpedido").value = descricao8;
            $("pedidoexpedido").value = expedido;
            $("pedidoconferido").value = conferido;

            $("acao").value = "inserir";
            $("enviarped").value = "incluir";



        }

    }




}


function enviarpedido() {
    foc = 1;
    if ($("acao").value == "inserir") {

        new ajax('romaneiosinsere.php?romcodigo='
                + document.getElementById('romcodigo').value
                + '&pvnumero='
                + document.getElementById('codigopedido').value
                + '&rpvolumes='
                + document.getElementById('volumespedido').value
                , {onLoading: carregando, onComplete: load_gridpedido});
    } else if ($("acao").value == "alterar") {

        new ajax('romaneiosaltera.php?romcodigo='
                + document.getElementById('romcodigo').value
                + '&pvnumero='
                + document.getElementById('codigopedido').value
                + '&rpvolumes='
                + document.getElementById('volumespedido').value
                , {onLoading: carregando, onComplete: load_gridpedido});
    }
}


function load_gridpedido() {

    new ajax('romaneiosseleciona2b.php?pesquisa='
            + document.getElementById('pvnumero').value
            , {onLoading: carregando, onComplete: pesquisarpedido});
}

function pesquisarpedido() {

    new ajax('romaneiosseleciona2b.php?pesquisa='
            + document.getElementById('pvnumero').value
            , {onLoading: carregando, onComplete: imprimepedido});

    if (foc == 1) {
        $("pesquisapedido").value = '';
        $("codigopedido").value = '';
        $("cliente").value = '';
        $("volumespedido").value = '';

        document.forms[0].pesquisapedido.focus();

        foc = 0;
    }

}



function imprimepedido(request) {

    ///As tres proximas linhas devem ficar nestre ponto pois o mozila
    ///não entende : var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0]; if(cabecalho!=null)

    var contaPedidos = 0;

    $("acao").value = "inserir";
    $("enviarped").value = "incluir";
    $("resultado").innerHTML = "Nenhum registro encontrado...";

    $("msg").style.visibility = "hidden";
    var xmldoc = request.responseXML;
    var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];
    if (cabecalho != null)
    {
        var campo = cabecalho.getElementsByTagName('campo');
        var tabela = "<table class='borda'><tr>"

        //cabecalho da tabela

        //for(i=0;i<campo.length;i++){
        //	tabela+="<td class='borda'><b>"+campo[i].firstChild.data+"</b></td>";
        //}

        //tabela+="<td colspan='0' class='borda'><b>Codigo</b></td>"
        tabela += "<td colspan='0'></td>"
        tabela += "<td colspan='1' class='borda'><b>Codigo</b></td>"
        tabela += "<td colspan='1' class='borda'><b>Cliente</b></td>"
        tabela += "<td colspan='1' class='borda'><b>Volumes</b></td>"
        tabela += "<td colspan='1' class='borda'><b>Emissão</b></td>"
        tabela += "<td colspan='1' class='borda'><b>Valor</b></td>"
        tabela += "<td colspan='2' class='borda'><b>Controles</b></td>"
        tabela += "<td colspan='0'></td>"
        tabela += "</tr>"

        //corpo da tabela
        var registros = xmldoc.getElementsByTagName('registro');




        var totped = 0;
        var totvalped = 0;
        var x = 0;
        var y = 0;
        var z = 0;

        for (i = 0; i < registros.length; i++) {
            var itens = registros[i].getElementsByTagName('item');

            vet[i][5] = itens[7].firstChild.data;
            totped++;
            y = vet[i][5];
            x = (Math.round(y * 100)) / 100;

            totvalped = totvalped + x;

        }



        var valorx = 0;
        var percentualx = 0;


        if (document.getElementById("radio1").checked == true) {
            valorx = $("valor").value;
        } else if (document.getElementById("radio2").checked == true) {
            percentualx = $("percentual").value;
            valorx = totvalped * percentualx / 100;
        } else {
            valorx = 0;
        }






        for (i = 0; i < registros.length; i++) {
            var itens = registros[i].getElementsByTagName('item');


            vet[i][0] = itens[1].firstChild.data;
            vet[i][1] = itens[6].firstChild.data + " " + itens[2].firstChild.data;
            vet[i][2] = itens[3].firstChild.data;
            vet[i][3] = itens[4].firstChild.data;

            vet[i][5] = itens[7].firstChild.data;


            y = vet[i][5];
            x = (Math.round(y * 100)) / 100;

            z = valorx * x / totvalped
            z = (Math.round(z * 100)) / 100;

            vet[i][4] = z;



            tabela += "<tr id=linha" + i + ">"

            //for(j=0;j<itens.length;j++){
            //	if(itens[j].firstChild==null)
            //		tabela+="<td></td>";
            //	else
            //		tabela+="<td>"+itens[j].firstChild.data+"</td>";
            //
            //}

            //tabela+="<td>"+itens[0].firstChild.data+"</td>";
            tabela += "<td class='borda2'>" + itens[0].firstChild.data + "</td>";
            romanu = $("pvnumero1").value;
            romano = $("pvnumero2").value;
            //tabela+="<td class='borda'><a href='pedvendacons4.php?flagmenu=9&codped="+itens[1].firstChild.data+"&romanu="+romanu+"&romano="+romano+"'>"+itens[1].firstChild.data+"</a></td>";
            tabela += "<td class='borda' ><a href=\"javascript:;\" onclick=\"window.open('pedvendacons4.php?flagmenu=9&codped=" + itens[1].firstChild.data + "&romanu=" + romanu + "&romano=" + romano + "','Consulta de Pedido','width=600,height=650');\">" + itens[1].firstChild.data + "</a></td>";

            if (itens[2].firstChild.data != '0') {
                tabela += "<td class='borda'>" + itens[6].firstChild.data + " " + itens[2].firstChild.data + "</td>";
            } else {
                tabela += "<td class='borda'>0 " +
                        "IDO ABASTECIMENTO</td>";

            }
            tabela += "<td class='borda'>" + itens[3].firstChild.data + "</td>";
            tabela += "<td class='borda'>" + itens[4].firstChild.data + "</td>";

            tabela += "<td class='borda'>" + vet[i][4] + "</td>";

            tabela += "<td class='borda' style='cursor: pointer'><img src='imagens/edit.gif' onClick=editar(" + vet[i][0] + "," + "0" + "," + vet[i][2] + ",'" + vet[i][3] + "','" + vet[i][5] + "')></td>";
            tabela += "<td class='borda' style='cursor: pointer'><img src='imagens/delete.gif' onClick=apagar(" + itens[1].firstChild.data + ")></td>";

            tabela += "<td class='borda2'>" + itens[1].firstChild.data + "</td>";

            tabela += "</tr>";

            if (i == 0) {
                $("romcodigo").value = itens[5].firstChild.data;
            }

            contaPedidos++;

        }

        tabela += "</table>"
        $("resultado").innerHTML = tabela;
        tabela = null;
    } else {
        $("resultado").innerHTML = "Nenhum registro encontrado...";
    }

    if (contaPedidos == 0) {
        $("consulta_transportadora").disabled = false;
        $("listaPesquisaTransp").disabled = false;
    } else {
        $("consulta_transportadora").disabled = true;
        $("listaPesquisaTransp").disabled = true;
    }

}



function apagarx(codigo) {

    new ajax('romaneiosapaga.php?codigo=' + codigo
            , {onLoading: carregando, onComplete: load_gridpedido});
}


function editar(texto, texto2, texto3, texto4, texto5) {

    $("pesquisapedido").value = texto;
    $("codigopedido").value = texto;
    $("cliente").value = texto2;
    $("volumespedido").value = texto3;
    $("emissao").value = texto4;

    $("valpedido").value = texto5;

    $("acao").value = "alterar";
    $("enviarped").value = "Alterar";

    document.getElementById("volumespedido").focus();

    dadospesquisapedido2(texto);

}



function verificapedidox() {

    valor = document.getElementById('codigopedido').value;
    valor2 = document.getElementById('romcodigo').value;

    if (valor2 != '0') {

        if ($("acao").value == "inserir") {

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


                ajax2.open("POST", "romaneiospesquisapedido3.php", true);
                ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                ajax2.onreadystatechange = function () {
                    //enquanto estiver processando...emite a msg de carregando
                    if (ajax2.readyState == 1) {

                    }
                    //após ser processado - chama função processXML que vai varrer os dados
                    if (ajax2.readyState == 4) {
                        if (ajax2.responseXML) {
                            processXMLverificapedido(ajax2.responseXML);
                        } else {
                            //caso não seja um arquivo XML emite a mensagem abaixo
                            if (navigator.appName != "Microsoft Internet Explorer") {
                                enviarpedido();
                            }

                        }
                    }
                }
                //passa o parametro escolhido

                var params = "parametro=" + valor + '&parametro2=' + valor2;

                ajax2.send(params);
            }




        } else if ($("acao").value == "alterar") {
            enviarpedido()
        }

    } else
    {
        alert("O Romaneio deve ser gravado antes do lançamento dos pedidos!");
    }

}
function processXMLverificapedido(obj) {
    //pega a tag dado

    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        alert('Pedido já incluido!');
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo
        enviarpedido();
    }
}


//----------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------
//---------------------------ROTINAS DE CONTROLE DE ROMANEIOS-----------------------------
//----------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------


function numero_romaneio(valor) {

    $("data").value = dia + '/' + mes + '/' + ano;

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

        ajax2.open("POST", "romaneionumerosugere.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {

            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {

            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLromaneionumero(ajax2.responseXML, valor);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                    $("pvnumero").value = "";
                    $("pvnumero1").value = "";
                    $("pvnumero2").value = "";

                }
            }
        }
        //passa o parametro

        var params = "parametro=" + valor;
        ajax2.send(params);

    }
}




function processXMLromaneionumero(obj, valor) {
    //pega a tag dado

    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado

    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados


        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];


            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("numero")[0].firstChild.nodeValue;
            var numero1 = item.getElementsByTagName("numero1")[0].firstChild.nodeValue;
            var numero2 = item.getElementsByTagName("numero2")[0].firstChild.nodeValue;

            trimjs(codigo);
            if (txt == '1') {
                txt = '1';
            }
            ;
            codigo = txt;

            $("pvnumero").value = '';
            $("pvnumero1").value = '';
            $("pvnumero2").value = numero2;

        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo

        $("pvnumero").value = "";
        $("pvnumero1").value = "";
        $("pvnumero2").value = "";

    }

    dadospesquisaveiculo(0, 0, valor);

}


function dadospesquisapalm(valor, tipo, valor2) {


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
        document.forms[0].palm.options.length = 1;

        idOpcao = document.getElementById("palm");


        ajax2.open("POST", "romaneiospesquisapalm.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {

                    processXMLpalm(ajax2.responseXML, tipo, valor2);
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



function processXMLpalm(obj, tipo, valor2) {
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados



        document.forms[0].palm.options.length = 0;

        for (var i = 0; i < dataArray.length; i++) {
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
            novo.setAttribute("id", "palm");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto
            novo.text = descricao;
            //finalmente adiciona o novo elemento
            document.forms[0].palm.options.add(novo);

        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "____________________";

    }

    //dadospesquisaveiculo(0,0,valor);



    if (valor2 > 0) {
        carrega_romaneio_cod(valor2);
    } else {
        if (carrega == 0) {
            $("pvnumero1").focus();
            carrega = 1;
        }
        ;
    }

}




function dadospesquisaveiculo(valor, tipo, valor2) {

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
        document.forms[0].listveiculos.options.length = 1;

        idOpcao = document.getElementById("opcoesveiculos");

        ajax2.open("POST", "romaneiospesquisaveiculos.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLveiculos(ajax2.responseXML, tipo, valor2);
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



function processXMLveiculos(obj, tipo, valor2) {
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados

        document.forms[0].listveiculos.options.length = 0;

        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var modelo = item.getElementsByTagName("modelo")[0].firstChild.nodeValue;
            var placa = item.getElementsByTagName("placa")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(modelo);
            modelo = txt;
            trimjs(placa);
            placa = txt;

            //idOpcao.innerHTML = "";

            //cria um novo option dinamicamente
            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoesveiculos");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto
            novo.text = modelo;
            //finalmente adiciona o novo elemento
            document.forms[0].listveiculos.options.add(novo);

            if (i == 0) {
                $("placa").value = placa;

                var codigo1 = codigo;
            }


        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "____________________";

    }

    dadospesquisaveiculo2(codigo1, 0, valor2);

}



function dadospesquisaveiculo2(valor, tipo, valor2) {


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

        ajax2.open("POST", "romaneiospesquisaveiculos.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLveiculos2(ajax2.responseXML, tipo, valor2);
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



function processXMLveiculos2(obj, tipo, valor2) {
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados


        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var placa = item.getElementsByTagName("placa")[0].firstChild.nodeValue;
            var romfinal = item.getElementsByTagName("romfinal")[0].firstChild.nodeValue;
            trimjs(placa);
            placa = txt;
            trimjs(romfinal);
            romfinal = txt;

            if (i == 0) {
                //Na alteracao nao cou sugerir pra nao perder 
                //$("placa").value = placa;
                //$("inicial").value = romfinal;
                //$("inicial").value = placa;
            }

        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo

    }

    //if (valor2!=0){


    dadospesquisapalm(0, 0, valor2);

    //}
}

function enviarromaneio() {

    if ($("romcodigo").value == "0") {
        alert("Romaneio Inválido!")
    } else {

        //Coloca mensagem para evitar que o usuário fique clicando no botão
        titulo = "PROCESSANDO, AGUARDE...";
        mensagem = "EXECUTANDO ALTERACAO DE ROMANEIO.";

        $a("#retorno").messageBoxModal(titulo, mensagem);

        if (document.getElementById("radio1").checked == true) {
            radio = 1;
        } else if (document.getElementById("radio2").checked == true) {
            radio = 2;
        } else {
            radio = 3;
        }

        var campovet01 = '';
        var campovet02 = '';

        for (i = 0; i < vet.length; i++) {
            if (vet[i][0] != 0) {
                campovet01 = campovet01 + '&pvnumero[]=' + vet[i][0];
                campovet02 = campovet02 + '&rpvolumes[]=' + vet[i][2];
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
            ajax2.open("POST", "romaneiosalteracao.php", true);
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

        var usuario = $("usuario").value;
        if (usuario == '') {
            usuario = 0
        }

        //window.open('incluirgerapvenda2.php?flag=InserirOrcamento'
        var params = 'romcodigo=' + document.getElementById('romcodigo').value
                + '&romveiculo=' + document.forms[0].listveiculos.options[document.forms[0].listveiculos.selectedIndex].value
                + '&romsaida=' + document.getElementById('saida').value
                + '&rommotorista=' + document.getElementById('motorista').value
                + '&romajudante=' + document.getElementById('ajudante').value
                + '&rominicial=' + document.getElementById('inicial').value
                + '&romfinal=' + document.getElementById('final').value
                + '&romtipofrete=' + radio
                + '&romobservacao=' + document.getElementById('observacoes').value
                + '&romvalor=' + document.getElementById('valor').value
                + '&rompercentual=' + document.getElementById('percentual').value
                + '&transp=' + $a("#listaPesquisaTransp").val()
                + '&usucodigo=' + usuario
                + '' + campovet01
                + '' + campovet02

        //alert(params);

        ajax2.send(params);


    }

}

function processXMLinclui(obj, valor) {

    var retorno = 0;

    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados


        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            retorno = item.getElementsByTagName("retorno")[0].firstChild.nodeValue;


        }


    }

    if (retorno == 1) {
        enviaemail();
    } else {
        alert('Erro na alteração do Romaneio!')
    }

}

function enviaemail() {


    for (i = 0; i < vet.length; i++) {
        if (vet[i][0] != 0) {

            new ajax('romaneiosemail.php?romcodigo='
                    + document.getElementById('romcodigo').value
                    + '&pvnumero='
                    + vet[i][0]
                    + '&rpvolumes='
                    + vet[i][2]
                    , {});

        }
    }

    expromnum();

}

function  expromnum() {

    $a.unblockUI();
    $("button").disabled = false;

    /*
    new ajax('exportaromaneiosnum.php?romcodigo=' + document.getElementById('romcodigo').value
            + '&romnumeroano=' + document.getElementById('pvnumero').value
            , {});
    */

    if (mensagem == 1) {
        alert('O romaneio foi gravado com o número ' + document.getElementById('pvnumero').value + '!');
    }

    //Chama a geração de Notfis que passa a ser automatica e obrigatoria a pedido do usuario
    verificanotauto(document.getElementById('romcodigo').value);
}

function carrega_romaneio(valor) {

    $("acao").value = "Incluir";
    $("enviarped").value = "Incluir";
    $("button").value = 'Salva';
    $("romcodigo").value = "0";
    $("data").value = "";
    $("saida").value = "";
    $("motorista").value = "";
    $("emissor").value = "";
    $("ajudante").value = "";
    $("placa").value = "";
    $("inicial").value = "";
    $("final").value = "";
    $("valor").value = "";
    $("observacoes").value = "";
    $("pesquisapedido").value = "";
    $("volumespedido").value = "";
    $("data").value = dia + '/' + mes + '/' + ano;
    $("cliente").value = "";
    document.getElementById("valor").disabled = false;
    document.getElementById("percentual").value = 0;
    document.getElementById("percentual").disabled = true;
    document.getElementById("radio1").checked = true;

    for (var i = 0; i < 500; i++) {
        vet[i][0] = 0;
        vet[i][1] = "";
        vet[i][2] = "";
        vet[i][3] = "";

        vet[i][4] = 0;
        vet[i][5] = 0;

    }
    tabela = null;
    $("resultado").innerHTML = tabela;

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

        ajax2.open("POST", "romaneiosseleciona.php", true);
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

                    alert('Romaneio não encontrado');
                    limpa_form();
                    //$("romcodigo").value="0";
                    //$("button").value='Salvar';
                    //dadospesquisaveiculo(0,0);

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

            var romveiculo = item.getElementsByTagName("romveiculo")[0].firstChild.nodeValue;
            var romdata = item.getElementsByTagName("romdata")[0].firstChild.nodeValue;
            var romsaida = item.getElementsByTagName("romsaida")[0].firstChild.nodeValue;
            var rommotorista = item.getElementsByTagName("rommotorista")[0].firstChild.nodeValue;
            var romemissor = item.getElementsByTagName("romemissor")[0].firstChild.nodeValue;
            var romajudante = item.getElementsByTagName("romajudante")[0].firstChild.nodeValue;
            var rominicial = item.getElementsByTagName("rominicial")[0].firstChild.nodeValue;
            var romfinal = item.getElementsByTagName("romfinal")[0].firstChild.nodeValue;
            var romtipofrete = item.getElementsByTagName("romtipofrete")[0].firstChild.nodeValue;
            var romobservacao = item.getElementsByTagName("romobservacao")[0].firstChild.nodeValue;
            var romvalor = item.getElementsByTagName("romvalor")[0].firstChild.nodeValue;
            var rompercentual = item.getElementsByTagName("rompercentual")[0].firstChild.nodeValue;
            var transp = item.getElementsByTagName("transp")[0].firstChild.nodeValue;

            //document.getElementById("data").disabled = false;
            //document.forms[0].data.focus();


            trimjs(codigo);
            codigo = txt;

            trimjs(romveiculo);
            romveiculo = txt;
            trimjs(romdata);
            romdata = txt;
            trimjs(romsaida);
            romsaida = txt;
            trimjs(rommotorista);
            rommotorista = txt;
            trimjs(romemissor);
            if (txt == '0') {
                txt = '';
            }
            romemissor = txt;
            trimjs(romajudante);
            romajudante = txt;
            trimjs(rominicial);
            rominicial = txt;
            trimjs(romfinal);
            romfinal = txt;
            trimjs(romtipofrete);
            romtipofrete = txt;
            trimjs(romobservacao);
            if (txt == '0') {
                txt = '';
            }
            ;
            romobservacao = txt;

            trimjs(romvalor);
            romvalor = txt;
            trimjs(rompercentual);
            rompercentual = txt;

            if (i == 0) {
                $("romcodigo").value = codigo;
                $("data").value = romdata;
                $("saida").value = romsaida;
                $("motorista").value = rommotorista;
                $("emissor").value = romemissor;
                $("ajudante").value = romajudante;
                $("inicial").value = rominicial;
                $("final").value = romfinal;
                //$("tipofrete").value=romtipofrete;
                $("observacoes").value = romobservacao;

                $("txtPesquisaTransp").value = transp;
                pesquisaTransportadora();

                $a("#listaPesquisaTransp").val(transp);

                if (romtipofrete == '1') {
                    document.getElementById("radio1").checked = true;
                    $("valor").value = romvalor;
                    $("percentual").value = 0;
                    document.getElementById("valor").disabled = false;
                    document.getElementById("percentual").disabled = true;
                } else if (romtipofrete == '2') {
                    document.getElementById("radio2").checked = true;
                    $("valor").value = 0;
                    $("percentual").value = rompercentual;
                    document.getElementById("valor").disabled = true;
                    document.getElementById("percentual").disabled = false;
                } else {
                    document.getElementById("radio3").checked = true;
                    $("valor").value = 0;
                    $("percentual").value = 0;
                    document.getElementById("valor").disabled = true;
                    document.getElementById("percentual").disabled = true;
                }

                itemcombo(romveiculo);

                $("button").value = 'Altera';

            }



            load_gridpedido();

        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo

        alert('Romaneio não encontrado');

        limpa_form();

        //$("romcodigo").value="0";
        //$("button").value='Salvar';

        //dadospesquisaveiculo(0,0);

    }

}




function itemcombo(valor) {

    y = document.forms[0].listveiculos.options.length;

    for (var i = 0; i < y; i++) {

        document.forms[0].listveiculos.options[i].selected = true;
        var l = document.forms[0].listveiculos;
        //var li = l.options[l.selectedIndex].text;
        var li = l.options[l.selectedIndex].value;
        if (li == valor) {
            i = y;
        }

    }
}


function opcao(valor) {

    if (valor == '1') {
        document.getElementById("valor").disabled = false;
        document.getElementById("percentual").value = 0;
        document.getElementById("percentual").disabled = true;
    } else if (valor == '2') {
        document.getElementById("valor").value = 0;
        document.getElementById("valor").disabled = true;
        document.getElementById("percentual").disabled = false;
    } else {
        document.getElementById("valor").value = 0;
        document.getElementById("percentual").value = 0;
        document.getElementById("valor").disabled = true;
        document.getElementById("percentual").disabled = true;
    }

    ver1();

}


function excluir(romcodigo) {

    var usuario = $("usuario").value;
    if (usuario == '') {
        usuario = 0
    }

    new ajax('romaneiosapaga2.php?romcodigo=' + romcodigo + '&usuario=' + usuario, {onComplete: limpa_form});

}

function verifica1(romcodigo) {

    if (confirm("Tem certeza que deseja Excluir?\n\t")) {
        excluir(romcodigo);
    }
}

function verificapalm(romcodigo) {
    if (confirm("Importar pedidos do Palm?\n\t")) {
        //importa_palm();
        dadospesquisapalm2(document.forms[0].palm.options[document.forms[0].palm.selectedIndex].value);
    }
}


function verificaimp(romcodigo) {

    //Verifica se gravou
    if (romcodigo == 0) {
        alert("Salvar o romaneio antes de imprimir !");
    } else
    {

        if (confirm("Confirma Impressão?\n\t")) {

            //Retira a opção de Geração do arquivo NOTFIS
            /*
             $a.get('geraNOTFIS.php',
             {
             romnumero:document.getElementById('pvnumero').value,
             romdata:document.getElementById('data').value,
             transp:$a("#listaPesquisaTransp option:selected").text()
             },
             function(data){
             //
             //                               if(data.retorno){
             //
             //                                   alert("SENDING NOTFIS...");
             //                               }
             
             }, "json");
             */


            if (document.getElementById("radio1").checked == true) {
                tipo = 1;
            } else if (document.getElementById("radio2").checked == true) {
                tipo = 2;
            } else {
                tipo = 3;
            }


            radioimp = 2;
            window.open('romaneiospdfnew.php?romcodigo=' + romcodigo +
                    '&romnumero=' + document.getElementById('pvnumero').value +
                    '&romdata=' + document.getElementById('data').value +
                    '&rommotorista=' + document.getElementById('motorista').value +
                    '&romajudante=' + document.getElementById('ajudante').value +
                    '&romsaida=' + document.getElementById('saida').value +
                    '&rominicial=' + document.getElementById('inicial').value +
                    '&romfinal=' + document.getElementById('final').value +
                    '&romplaca=' + document.getElementById('placa').value +
                    '&romobs=' + document.getElementById('observacoes').value +
                    '&romveiculo=' + document.forms[0].listveiculos.options[document.forms[0].listveiculos.selectedIndex].text +
                    '&romtipo=' + tipo +
                    '&romvalor=' + document.getElementById('valor').value +
                    '&rompercentual=' + document.getElementById('percentual').value +
                    '&radioimp=' + radioimp +
                    '&romemissor=' + document.getElementById('emissor').value +
                    '&transp=' + $a("#listaPesquisaTransp").val()
                    , 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');


        }
    }
}



function dadospesquisapedido2(valor) {
    //verifica se o browser tem suporte a ajax

    //trimjs(valor);
    //if (txt!=''){
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

        ajax2.open("POST", "romaneiospesquisapedido.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {

            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {

            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLpedido2(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo


                    //Mozilla


                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }

    //  }
}


function processXMLpedido2(obj) {
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados


        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
            var descricao2 = item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;
            var descricao3 = item.getElementsByTagName("descricao3")[0].firstChild.nodeValue;
            var descricao4 = item.getElementsByTagName("descricao4")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;
            trimjs(descricao2);
            descricao2 = txt;

            trimjs(descricao3);
            descricao3 = txt;
            trimjs(descricao4);
            descricao4 = txt;

            $("cliente").value = descricao3 + " " + descricao4;

        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo

    }
}













function dadospesquisaveiculovalidar(valor) {

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

        ajax2.open("POST", "romaneiospesquisaveiculosvalidar.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLveiculosvalidar(ajax2.responseXML, valor);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo

                    dadospesquisaveiculo2(valor, 0);
                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}



function processXMLveiculosvalidar(obj, valor) {
    //pega a tag dado



    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados



        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var rombaixa = item.getElementsByTagName("rombaixa")[0].firstChild.nodeValue;
            var veivalidar = item.getElementsByTagName("veivalidar")[0].firstChild.nodeValue;
            var romnumero = item.getElementsByTagName("romnumero")[0].firstChild.nodeValue;
            var romano = item.getElementsByTagName("romano")[0].firstChild.nodeValue;

            trimjs(rombaixa);
            rombaixa = txt;
            trimjs(veivalidar);
            veivalidar = txt;
            trimjs(romnumero);
            romnumero = txt;
            trimjs(romano);
            romano = txt;


            if (i == 0) {

                var roma = romnumero + '/' + romano
                //alert(roma);
                //alert($("pvnumero").value);

                if (roma != $("pvnumero").value) {

                    if (veivalidar == 'S') {
                        if (rombaixa == '0') {
                            alert("Veiculo não pode ser selecionado!");

                        }
                    }
                }
            }


        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo

    }

    dadospesquisaveiculo2(valor, 0);

}








function dadospesquisaveiculovalidar2(valor) {

    $("button").disabled = true;

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

        ajax2.open("POST", "romaneiospesquisaveiculosvalidar.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {


                //idOpcao.innerHTML = "Carregando...!";

            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLveiculosvalidar2(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                    verifica();
                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}



function processXMLveiculosvalidar2(obj) {
    //pega a tag dado

    var per = 0;
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados


        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var rombaixa = item.getElementsByTagName("rombaixa")[0].firstChild.nodeValue;
            var veivalidar = item.getElementsByTagName("veivalidar")[0].firstChild.nodeValue;
            var romnumero = item.getElementsByTagName("romnumero")[0].firstChild.nodeValue;
            var romano = item.getElementsByTagName("romano")[0].firstChild.nodeValue;

            trimjs(rombaixa);
            rombaixa = txt;
            trimjs(veivalidar);
            veivalidar = txt;
            trimjs(romnumero);
            romnumero = txt;
            trimjs(romano);
            romano = txt;


            if (i == 0) {

                var roma = romnumero + '/' + romano
                //alert(roma);
                //alert($("pvnumero").value);

                if (roma != $("pvnumero").value) {

                    if (veivalidar == 'S') {
                        if (rombaixa == '0') {
                            alert("Veiculo não pode ser selecionado!");
                            $("button").disabled = false;
                            document.getElementById("listveiculos").focus();
                            per = 1;
                        }
                    }
                }
            }


        }
        if (per == 0) {
            verifica();
        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo
        verifica();
    }

}




function importa_palm_original() {

    //Cria objeto para manipulacao de arquivos no cliente.
    var fso = new ActiveXObject("Scripting.FileSystemObject");

    if (fso.FileExists("Z:\\expvol.txt")) {
        fso.DeleteFile("Z:\\expvol.txt");
    }

    //Verifica a nao existencia do arquivo responsavel pela impressao na impressora bematech.
    if (!(fso.FileExists("c:\\temp\\imppvol.bat"))) {
        //Cria o arquivo imprime.bat, escreve o comando responsavel pela impressao e fecha o arquivo.
        var b = fso.CreateTextFile("c:\\temp\\imppvol.bat", true);
        b.WriteLine('copy "C:\\ARQUIVOS DE PROGRAMAS\\PALM\\CENTRO\\BACKUP\\Expe_TPedido.pdb" "C:\\TEMP\\Expe_TPedido.pdb"');
        b.WriteLine('copy "C:\\ARQUIVOS DE PROGRAMAS\\PALM\\CENTRO\\BACKUP\\Expe_TVolume.pdb" "C:\\TEMP\\Expe_TVolume.pdb"');
        b.WriteLine("C:\\TEMP\\EXPEDEB.EXE");
        //b.WriteLine("delete Z:\\expped.txt");
        b.WriteLine("copy C:\\TEMP\\expvol.txt Z:\\");
        b.Close();
    } //if

    //Cria um objeto para execucao de um programa no computador do cliente.
    var WshShell = new ActiveXObject("WScript.Shell");
    //Executa o arquivo responsavel pela impressao do arquivo imprime.prn.
    var oExec = WshShell.Exec("c:\\temp\\imppvol.bat");
    //var oExec = WshShell.Exec("c:\\temp\\confere.exe");

    //Vou chamar uma Funcao que vai chamar o form pelo ajax e vai retornar uma variavel com os pedidos
    importaexpedicao(1);


} //Fim do



function importa_palm(palm, pasta) {



    //Cria objeto para manipulacao de arquivos no cliente.
    var fso = new ActiveXObject("Scripting.FileSystemObject");

    if (fso.FileExists("Z:\\expvol.txt")) {
        fso.DeleteFile("Z:\\expvol.txt");
    }


    //Verifica a nao existencia do arquivo responsavel pela impressao na impressora bematech.
    //if ( !(fso.FileExists("c:\\temp\\imppvol.bat")) ) {
    if (!(fso.FileExists("c:\\temp\\c" + palm + ".bat"))) {
        //Cria o arquivo imprime.bat, escreve o comando responsavel pela impressao e fecha o arquivo.
        //var b = fso.CreateTextFile("c:\\temp\\imppvol.bat", true);
        var b = fso.CreateTextFile("c:\\temp\\c" + palm + ".bat", true);
        //b.WriteLine('copy "C:\\ARQUIVOS DE PROGRAMAS\\PALM\\CENTRO\\BACKUP\\Expe_TPedido.pdb" "C:\\TEMP\\Expe_TPedido.pdb"');
        //b.WriteLine('copy "C:\\ARQUIVOS DE PROGRAMAS\\PALM\\CENTRO\\BACKUP\\Expe_TVolume.pdb" "C:\\TEMP\\Expe_TVolume.pdb"');
        b.WriteLine('copy "C:\\ARQUIVOS DE PROGRAMAS\\PALM\\' + pasta + '\\BACKUP\\Expe_TPedido.pdb" "C:\\TEMP\\Expe_TPedido.pdb"');
        b.WriteLine('copy "C:\\ARQUIVOS DE PROGRAMAS\\PALM\\' + pasta + '\\BACKUP\\Expe_TVolume.pdb" "C:\\TEMP\\Expe_TVolume.pdb"');
        b.WriteLine("C:\\TEMP\\EXPEDEB.EXE");
        //b.WriteLine("delete Z:\\expped.txt");
        b.WriteLine("copy C:\\TEMP\\expvol.txt Z:\\");
        b.Close();
    } //if

    //Cria um objeto para execucao de um programa no computador do cliente.
    var WshShell = new ActiveXObject("WScript.Shell");
    //Executa o arquivo responsavel pela impressao do arquivo imprime.prn.
    //var oExec = WshShell.Exec("c:\\temp\\imppvol.bat");
    var oExec = WshShell.Exec("c:\\temp\\c" + palm + ".bat");
    //var oExec = WshShell.Exec("c:\\temp\\confere.exe");

    //Vou chamar uma Funcao que vai chamar o form pelo ajax e vai retornar uma variavel com os pedidos
    //importaexpedicao(1);



    //Vou colocar uma espera para dar tempo do activex chamar o bat 
    $("buttonpalm").disabled = true;
    setTimeout("importaexpedicao(1)", "7000");

}






function importaexpedicao(valor) {

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

        ajax2.open("POST", "palmexpedicaoimporta.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {

            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {

            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLExp(ajax2.responseXML);
                } else {
                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }

}


function processXMLExp(obj) {

    var mensagem = "";

    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados
        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
            var descricao2 = item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;
            var descricao3 = item.getElementsByTagName("descricao3")[0].firstChild.nodeValue;
            var descricao4 = item.getElementsByTagName("descricao4")[0].firstChild.nodeValue;
            var descricao5 = item.getElementsByTagName("descricao5")[0].firstChild.nodeValue;
            var descricao6 = item.getElementsByTagName("descricao6")[0].firstChild.nodeValue;
            var descricao7 = item.getElementsByTagName("descricao7")[0].firstChild.nodeValue;
            var descricao8 = item.getElementsByTagName("descricao8")[0].firstChild.nodeValue;

            var descricao9 = item.getElementsByTagName("descricao9")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;
            trimjs(descricao2);
            descricao2 = txt;
            trimjs(descricao3);
            descricao3 = txt;
            trimjs(descricao4);
            descricao4 = txt;
            trimjs(descricao5);
            descricao5 = txt;
            trimjs(descricao6);
            descricao6 = txt;
            trimjs(descricao7);
            descricao7 = txt;
            trimjs(descricao8);
            descricao8 = txt;

            trimjs(descricao9);
            descricao9 = txt;


            if (descricao8 == 0) {

                var vol = 0;

                if (descricao5 == 'S') {
                    if (descricao2 != '0') {
                        vol = descricao2;
                    } else {
                        vol = descricao6;
                    }
                } else {
                    if (descricao6 != '0') {
                        vol = descricao6;
                    } else {
                        vol = descricao2;
                    }
                }

                valor = descricao;
                valor2 = descricao3 + " " + descricao4;
                valor3 = vol;
                valor4 = descricao7;

                valor5 = descricao9;

                foc = 1;

                var j = 0;
                for (var i2 = 0; i2 < 500; i2++) {

                    if (vet[i2][0] == valor) {
                        alert("Pedido já Incluido!");
                        //alert(valor);
                        i2 = 500;
                        j = 1;
                    }

                }

                if (j == 0) {




                    var totped = 0;
                    var totvalped = 0;
                    var x = 0;
                    var y = 0;
                    var z = 0;

                    for (i2 = 0; i2 < vet.length; i2++) {
                        if (vet[i2][0] != 0) {
                            totped++;

                            y = vet[i2][5];
                            x = (Math.round(y * 100)) / 100;

                            totvalped = totvalped + x;
                        }
                    }


                    var valorx = 0;
                    var percentualx = 0;


                    if (document.getElementById("radio1").checked == true) {
                        valorx = $("valor").value;
                    } else if (document.getElementById("radio2").checked == true) {
                        percentualx = $("percentual").value;
                        valorx = totvalped * percentualx / 100;
                    } else {
                        valorx = 0;
                    }






                    for (var i2 = 0; i2 < 500; i2++) {

                        if (vet[i2][0] == 0) {
                            vet[i2][0] = valor;
                            vet[i2][1] = valor2;
                            vet[i2][2] = valor3;
                            vet[i2][3] = valor4;

                            vet[i2][5] = valor5;


                            ///////
                            y = vet[i2][5];
                            x = (Math.round(y * 100)) / 100;

                            z = valorx * x / totvalped
                            z = (Math.round(z * 100)) / 100;

                            vet[i2][4] = z;
                            ////////			  


                            i2 = 500;

                        }

                    }
                }

                ver1();


            }///para descricao8=0
            else
            {

                ///para descricao8<>0

                mensagem = mensagem + " " + descricao8;

            }

        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo
    }

    $("buttonpalm").disabled = false;

    if (mensagem != "") {
        alert("Pedido(s) incluidos em outro(s) romaneio(s): " + mensagem);
    }
    /*
     window.open('palmexpedicaoimporta.php', '_blank');
     */



}


function dadospesquisapalm2(valor) {


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


        ajax2.open("POST", "conferenciapesquisapalm2.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {

            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLpalm2(ajax2.responseXML);
                } else {

                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}



function processXMLpalm2(obj) {
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados


        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
            var descricao2 = item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;
            trimjs(descricao2);
            descricao2 = txt;

            importa_palm(descricao, descricao2);

        }
    } else {

    }

}



function verificaacesso() {


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


        ajax2.open("POST", "romaneiospesquisaacesso.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {

            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLacesso(ajax2.responseXML);
                } else {

                }
            }
        }
        //passa o parametro
        var valor = 0;
        var params = "parametro=" + valor;
        ajax2.send(params);

    }

}


function processXMLacesso(obj) {


    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados


        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML

            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;

            if (codigo == 1) {
                verificapedido();
            } else
            {
                alert('Acesso Negado !');
            }
        }
    } else {

    }

}





function numero_romaneioX(valor) {

    $("data").value = dia + '/' + mes + '/' + ano;

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

        ajax2.open("POST", "romaneionumerosugere.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {

            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {

            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLromaneionumeroX(ajax2.responseXML, valor);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                    $("pvnumero").value = "";
                    $("pvnumero1").value = "";
                    $("pvnumero2").value = "";

                    //erro


                }
            }
        }
        //passa o parametro

        var params = "parametro=" + valor;
        ajax2.send(params);

    }
}




function processXMLromaneionumeroX(obj, valor) {
    //pega a tag dado

    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado

    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados


        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];


            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("numero")[0].firstChild.nodeValue;
            var numero1 = item.getElementsByTagName("numero1")[0].firstChild.nodeValue;
            var numero2 = item.getElementsByTagName("numero2")[0].firstChild.nodeValue;

            trimjs(codigo);
            if (txt == '1') {
                txt = '1';
            }
            ;
            codigo = txt;


            /*
             if($("pvnumero1").value==numero1){
             if($("pvnumero2").value==numero2){
             $("pvnumero").value=codigo;
             return;
             }
             }
             */



            X();

            //Dá a mensagem
            //sugere o correto


        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo

        $("pvnumero").value = "";
        $("pvnumero1").value = "";
        $("pvnumero2").value = "";

        //erro

    }



}


function carrega_romaneio_cod(valor) {

    $("acao").value = "Incluir";
    $("enviarped").value = "Incluir";
    $("button").value = 'Salva';
    $("romcodigo").value = "0";
    $("data").value = "";
    $("saida").value = "";
    $("motorista").value = "";
    $("emissor").value = "";
    $("ajudante").value = "";
    $("placa").value = "";
    $("inicial").value = "";
    $("final").value = "";
    $("valor").value = "";
    $("observacoes").value = "";
    $("pesquisapedido").value = "";
    $("volumespedido").value = "";
    $("data").value = dia + '/' + mes + '/' + ano;
    $("cliente").value = "";
    document.getElementById("valor").disabled = false;
    document.getElementById("percentual").value = 0;
    document.getElementById("percentual").disabled = true;
    document.getElementById("radio1").checked = true;

    for (var i = 0; i < 500; i++) {
        vet[i][0] = 0;
        vet[i][1] = "";
        vet[i][2] = "";
        vet[i][3] = "";

        vet[i][4] = 0;
        vet[i][5] = 0;

    }
    tabela = null;
    $("resultado").innerHTML = tabela;

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

        ajax2.open("POST", "romaneiosselecionacodint.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {

            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {

            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLromaneiosselecionacodint(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo

                    alert('Romaneio não encontrado!');
                    limpa_form();
                    //$("romcodigo").value="0";
                    //$("button").value='Salvar';
                    //dadospesquisaveiculo(0,0);

                }
            }
        }
        //passa o parametro

        var params = "parametro=" + valor;
        ajax2.send(params);

    }
}

function processXMLromaneiosselecionacodint(obj) {
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados

        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;

            var romveiculo = item.getElementsByTagName("romveiculo")[0].firstChild.nodeValue;
            var romdata = item.getElementsByTagName("romdata")[0].firstChild.nodeValue;
            var romsaida = item.getElementsByTagName("romsaida")[0].firstChild.nodeValue;
            var rommotorista = item.getElementsByTagName("rommotorista")[0].firstChild.nodeValue;
            var romemissor = item.getElementsByTagName("romemissor")[0].firstChild.nodeValue;
            var romajudante = item.getElementsByTagName("romajudante")[0].firstChild.nodeValue;
            var rominicial = item.getElementsByTagName("rominicial")[0].firstChild.nodeValue;
            var romfinal = item.getElementsByTagName("romfinal")[0].firstChild.nodeValue;
            var romtipofrete = item.getElementsByTagName("romtipofrete")[0].firstChild.nodeValue;
            var romobservacao = item.getElementsByTagName("romobservacao")[0].firstChild.nodeValue;
            var romvalor = item.getElementsByTagName("romvalor")[0].firstChild.nodeValue;
            var rompercentual = item.getElementsByTagName("rompercentual")[0].firstChild.nodeValue;
            var transp = item.getElementsByTagName("transp")[0].firstChild.nodeValue;
            var romnumero = item.getElementsByTagName("romnumero")[0].firstChild.nodeValue;
            var romano = item.getElementsByTagName("romano")[0].firstChild.nodeValue;

            //document.getElementById("data").disabled = false;
            //document.forms[0].data.focus();


            trimjs(codigo);
            codigo = txt;

            trimjs(romveiculo);
            romveiculo = txt;
            trimjs(romdata);
            romdata = txt;
            trimjs(romnumero);
            romnumero = txt;
            trimjs(romano);
            romano = txt;
            trimjs(romsaida);
            romsaida = txt;
            trimjs(rommotorista);
            rommotorista = txt;
            trimjs(romemissor);
            if (txt == '0') {
                txt = '';
            }
            trimjs(romajudante);
            romajudante = txt;
            trimjs(rominicial);
            rominicial = txt;
            trimjs(romfinal);
            romfinal = txt;
            trimjs(romtipofrete);
            romtipofrete = txt;
            trimjs(romobservacao);
            if (txt == '0') {
                txt = '';
            }
            ;
            romobservacao = txt;

            trimjs(romvalor);
            romvalor = txt;
            trimjs(rompercentual);
            rompercentual = txt;

            if (i == 0) {

                $("pvnumero1").value = romnumero;
                $("pvnumero2").value = romano;
                $("pvnumero").value = $("pvnumero1").value + '/' + $("pvnumero2").value;
                $("romcodigo").value = codigo;
                $("data").value = romdata;
                $("saida").value = romsaida;
                $("motorista").value = rommotorista;
                $("emissor").value = romemissor;
                $("ajudante").value = romajudante;
                $("inicial").value = rominicial;
                $("final").value = romfinal;
                //$("tipofrete").value=romtipofrete;
                $("observacoes").value = romobservacao;

                $("txtPesquisaTransp").value = transp;
                pesquisaTransportadora();

                $a("#listaPesquisaTransp").val(transp);

                if (romtipofrete == '1') {
                    document.getElementById("radio1").checked = true;
                    $("valor").value = romvalor;
                    $("percentual").value = 0;
                    document.getElementById("valor").disabled = false;
                    document.getElementById("percentual").disabled = true;
                } else if (romtipofrete == '2') {
                    document.getElementById("radio2").checked = true;
                    $("valor").value = 0;
                    $("percentual").value = rompercentual;
                    document.getElementById("valor").disabled = true;
                    document.getElementById("percentual").disabled = false;
                } else {
                    document.getElementById("radio3").checked = true;
                    $("valor").value = 0;
                    $("percentual").value = 0;
                    document.getElementById("valor").disabled = true;
                    document.getElementById("percentual").disabled = true;
                }

                itemcombo(romveiculo);

                $("button").value = 'Altera';

            }
            carrega = 1;
            load_gridpedido();

        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo

        alert('Romaneio não encontrado');

        limpa_form();

        //$("romcodigo").value="0";
        //$("button").value='Salvar';

        //dadospesquisaveiculo(0,0);

    }

}

function verificanot(romcodigo) {

    //Verifica se gravou
    if (romcodigo == 0) {
        alert("Salvar o romaneio antes de gerar o Arquivo !");
    } else
    {
        //Verifica se transportadora tem o Layout e se todos os Pedidos tem Nota
        verifica_romaneio(romcodigo);
    }

}

function verifica_romaneio(valor) {

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

        ajax2.open("POST", "romaneiosverificanotfis.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {

            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {

            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLromaneiosverifica(ajax2.responseXML);
                } else {

                }
            }
        }
        //passa o parametro

        var params = "parametro=" + valor;
        ajax2.send(params);

    }
}

function processXMLromaneiosverifica(obj) {
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados

        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var romveiculo = item.getElementsByTagName("romveiculo")[0].firstChild.nodeValue;
            var romdata = item.getElementsByTagName("romdata")[0].firstChild.nodeValue;
            var romsaida = item.getElementsByTagName("romsaida")[0].firstChild.nodeValue;
            var rommotorista = item.getElementsByTagName("rommotorista")[0].firstChild.nodeValue;
            var romajudante = item.getElementsByTagName("romajudante")[0].firstChild.nodeValue;
            var rominicial = item.getElementsByTagName("rominicial")[0].firstChild.nodeValue;
            var romfinal = item.getElementsByTagName("romfinal")[0].firstChild.nodeValue;
            var romtipofrete = item.getElementsByTagName("romtipofrete")[0].firstChild.nodeValue;
            var romobservacao = item.getElementsByTagName("romobservacao")[0].firstChild.nodeValue;
            var romvalor = item.getElementsByTagName("romvalor")[0].firstChild.nodeValue;
            var rompercentual = item.getElementsByTagName("rompercentual")[0].firstChild.nodeValue;
            var transp = item.getElementsByTagName("transp")[0].firstChild.nodeValue;
            var notfisvers = item.getElementsByTagName("notfisvers")[0].firstChild.nodeValue;
            var pedidos = item.getElementsByTagName("pedidos")[0].firstChild.nodeValue;

            //Se for Transportadora Loggi não precisa ter Layout Cadastrado
            if ($a("#listaPesquisaTransp").val() == 15 || $a("#listaPesquisaTransp").val() == 11) {
                notfisvers = 5;
            }

            if (notfisvers == 0) {
                alert('Transportadora sem layout NOTFIS cadastrado! Não é possivel gerar o arquivo!');
            } else {
                if (pedidos != '_') {
                    alert(pedidos);
                } else {
                    if (confirm("Confirma geração de arquivos de Integração com Transportadora?\n\t")) {

                        var usuario = $("usuario").value;
                        if (usuario == '') {
                            usuario = 0
                        }

                        window.open('geraNOTFIS.php?romnumero=' + document.getElementById('pvnumero').value + '&usuario=' + usuario + '&romdata=' + document.getElementById('data').value + '&transp=' + $a("#listaPesquisaTransp option:selected").text() + '&codtransp=' + $a("#listaPesquisaTransp").val() + '&email=1', '_blank');

                    }
                }
            }

        }
    } else {
        alert('Problema na geração do arquivo de Integração ocom a Transportadora, favor avisar o administrador!');
    }

}

function verificanotauto(romcodigo) {

    //Verifica se gravou
    if (romcodigo != 0) {
        //Verifica se transportadora tem o Layout e se todos os Pedidos tem Nota
        verifica_romaneio_auto(romcodigo);
    }

}

function verifica_romaneio_auto(valor) {

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

        ajax2.open("POST", "romaneiosverificanotfis.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {

            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {

            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLromaneiosverificaauto(ajax2.responseXML);
                } else {

                }
            }
        }
        //passa o parametro

        var params = "parametro=" + valor;
        ajax2.send(params);

    }
}

function processXMLromaneiosverificaauto(obj) {
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados

        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var romveiculo = item.getElementsByTagName("romveiculo")[0].firstChild.nodeValue;
            var romdata = item.getElementsByTagName("romdata")[0].firstChild.nodeValue;
            var romsaida = item.getElementsByTagName("romsaida")[0].firstChild.nodeValue;
            var rommotorista = item.getElementsByTagName("rommotorista")[0].firstChild.nodeValue;
            var romajudante = item.getElementsByTagName("romajudante")[0].firstChild.nodeValue;
            var rominicial = item.getElementsByTagName("rominicial")[0].firstChild.nodeValue;
            var romfinal = item.getElementsByTagName("romfinal")[0].firstChild.nodeValue;
            var romtipofrete = item.getElementsByTagName("romtipofrete")[0].firstChild.nodeValue;
            var romobservacao = item.getElementsByTagName("romobservacao")[0].firstChild.nodeValue;
            var romvalor = item.getElementsByTagName("romvalor")[0].firstChild.nodeValue;
            var rompercentual = item.getElementsByTagName("rompercentual")[0].firstChild.nodeValue;
            var transp = item.getElementsByTagName("transp")[0].firstChild.nodeValue;
            var notfisvers = item.getElementsByTagName("notfisvers")[0].firstChild.nodeValue;
            var pedidos = item.getElementsByTagName("pedidos")[0].firstChild.nodeValue;

            //Se for Transportadora Loggi não precisa ter Layout Cadastrado
            if ($a("#listaPesquisaTransp").val() == 15 || $a("#listaPesquisaTransp").val() == 11) {
                notfisvers = 5;
            }

            if (notfisvers == 0) {
                alert('Transportadora sem layout NOTFIS cadastrado! Não é possivel gerar o arquivo!');
            } else {
                if (pedidos != '_') {
                    alert(pedidos);
                } else {
                    //if(confirm("Confirma geração de arquivo NotFis Proceda?\n\t") ){		
                    var usuario = $("usuario").value;
                    if (usuario == '') {
                        usuario = 0
                    }
                    window.open('geraNOTFIS.php?romnumero=' + document.getElementById('pvnumero').value + '&usuario=' + usuario + '&romdata=' + document.getElementById('data').value + '&transp=' + $a("#listaPesquisaTransp option:selected").text() + '&codtransp=' + $a("#listaPesquisaTransp").val() + '&email=1', '_blank');
                    //}
                }
            }

        }
    } else {
        alert('Problema na geração do arquivo de Integração com Transportadora, favor avisar o administrador!');
    }

}

function carregalog(romcodigo) {

    var usuario = $("usuario").value;
    if (usuario == '') {
        usuario = 0
    }

    //Verifica se gravou
    if (romcodigo == 0) {
        alert("Escolha um romaneio para consultar o log !");
    } else
    {

        var values = new Array(usuario, romcodigo);
        var keys = new Array("usucodigo", "romcodigo");

        openWindowWithPost('consultalogromaneios.php', '', keys, values);

    }

}

function openWindowWithPost(url, name, keys, values)
{

    var newWindow = window.open(url, name, 'status=yes, location=no, toolbar=no, directories=no, height=440,width=1100,top=100,left=100,scrollbars=yes,resizable=no');

    if (!newWindow)
        return false;

    var html = "";
    html += "<html><head></head><body><form id='formid' method='post' action='" + url + "'>";

    if (keys && values && (keys.length == values.length))
        for (var i = 0; i < keys.length; i++)
            html += "<input type='hidden' name='" + keys[i] + "' value='" + values[i] + "'/>";

    html += "</form><script type='text/javascript'>document.getElementById(\"formid\").submit()</sc" + "ript></body></html>";

    newWindow.document.write(html);
    return newWindow;
}

function verificaexc(romcodigo) {

    //Verifica se gravou
    if (romcodigo == 0) {
        alert("Salvar o romaneio antes de imprimir !");
    } else
    {

        if (confirm("Confirma Geração do Excel?")) {

            let usuario = $("usuario").value;
            if (usuario == '') {
                usuario = 0
            }

            window.open('relatoriogerapedidosromaneios.php?romcodigo=' + romcodigo + '&usuario=' + usuario, '_blank');


        }
    }
}

function pesquisaTransportadora() {

    const tipoPesquisa = jQuery("input[name='opcoesTipoPesquisaTransp']:checked").val();
    const txtPesquisa = jQuery("#txtPesquisaTransp").val();

    new ajax('pesquisatransportadoras.php?opcao=' + tipoPesquisa + '&consultatransportadora=' + txtPesquisa, {onComplete: imprime_transportadora});

}

function imprime_transportadora(request) {

    const xmldoc = request.responseXML;

    let tabela = '<select id="listaPesquisaTransp" name="listaPesquisaTransp" disabled>';

    if (xmldoc != null)
    {

        const dados = xmldoc.getElementsByTagName('dados')[0];
        //corpo da tabela
        var registros = xmldoc.getElementsByTagName('registro');
        //alert(registros.length);
        for (i = 0; i < registros.length; i++)
        {
            var itens = registros[i].getElementsByTagName('item');
            tabela += '<option value="' + itens[0].firstChild.data + '">' + itens[1].firstChild.data + '</option>\n"';
        }
    } else {
        tabela += "<option value=\"0\">TRANSPORTADORA NAO LOCALIZADA</option>";
    }
    tabela += "</select>"
    $("resultado_transportadora").innerHTML = tabela;
    tabela = "";

}