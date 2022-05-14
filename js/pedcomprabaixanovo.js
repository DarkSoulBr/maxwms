
var codvet;

var conini;

var pos = 0;

var xpdf = 0;
var xest = 0;
var xseq = 0;
var notax = 0;
var seriex = 0;

var baixando = 0;

var vet = new Array(700);

for (var i = 0; i < 700; i++) {
    vet[i] = new Array(21);
}

for (var i = 0; i < 700; i++) {
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
}

var codigo;
var dtinicio;
var dtfinal;
var tp;



nextfield = "pcnumero"; // nome do primeiro campo do site
netscape = "";

ver1 = navigator.appVersion;
len = ver1.length;
for (iln = 0; iln < len; iln++)
    if (ver1.charAt(iln) == "(")
        break;
netscape = (ver1.charAt(iln + 1).toUpperCase() != "C");

function focoserie() {
    document.formulario.serie.focus();

}

function keyDown(DnEvents) {
    // ve quando e o netscape ou IE
    k = (netscape) ? DnEvents.which : window.event.keyCode;
    if (k == 13) { // preciona tecla enter


        if (nextfield == 'icm') {
            if (document.getElementById("radioperc2").checked == true) {
                nextfield = 'baseicm';
            }
        }
        if (nextfield == 'percipi') {
            if (document.getElementById("radioperc2").checked == true) {
                nextfield = 'valoripi';
            }
        }


        if (nextfield == 'done') {
            //alert("viu como funciona?");
            return false;
            //return true; // envia quando termina os campos
        } else {


            // se existem mais campos vai para o proximo
            eval('document.formulario.' + nextfield + '.focus()');
            return false;
        }
    }
}

document.onkeydown = keyDown; // work together to analyze keystrokes
if (netscape)
    document.captureEvents(Event.KEYDOWN | Event.KEYUP);





function localizar(valor) {

    var encontrou = 0;

    trimjs(valor);

    if (txt != '') {

        for (var i = 0; i < 700; i++) {
            if (vet[i][5] == valor) {
                $(vet[i][0]).focus();
                document.getElementById("localiza").value = "";
                encontrou = 1;
            }
        }

        if (encontrou == 0) {
            alert("Produto não Encontrado");
            document.getElementById("localiza").value = "";
            document.getElementById("localiza").focus();
        }

    }

}


function imppdf() {
    xpdf = 0;
    var pcnumero = $("pcnumero").value;

    /*
    if (confirm("Responde Questionário?")) {

        window.open('pedcomprabaixa2.php?pcnumero=' + pcnumero
                + '&nota=' + notax
                + '&serie=' + seriex
                + '&est=' + xest
                + '&seq=' + xseq
                , '_self');

    } else
    {
    */
        if (confirm("Imprime Baixa?")) {

            window.open('pedcompraimppdf2.php?pcnumero=' + pcnumero
                    + '&nota=' + notax
                    + '&serie=' + seriex
                    , 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');

        }

        /*
        if (xest == 11) {
            window.open('exportapagar3.php?pcnumero=' + pcnumero
                    + '&nota=' + notax
                    + '&serie=' + seriex
                    + '&seq=' + xseq
                    , '_self');
        } else if (xest == 9) {
            window.open('exportapagargre.php?pcnumero=' + pcnumero
                    + '&nota=' + notax
                    + '&serie=' + seriex
                    + '&seq=' + xseq
                    , '_self');
        } else {
            window.open('exportapagar2novo.php?pcnumero=' + pcnumero
                    + '&nota=' + notax
                    + '&serie=' + seriex
                    + '&seq=' + xseq
                    , '_self');
        }
        

    }
    */
   
   window.open('pedcomprabaixanovo.php', '_self');

}

function ver(vcodigo, vdtinicio, vdtfinal, vtp) {

    document.getElementById("radiowms1").checked = true;
    document.getElementById('linhasenha').style.display = "none";
    $("adm").value = '';


    for (var i = 0; i < 700; i++) {
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

    }

    codigo = vcodigo;
    dtinicio = vdtinicio;
    dtfinal = vdtfinal;
    tp = vtp;

    data = new Date();
    ano = data.getFullYear();
    mes = data.getMonth() + 1;
    dia = data.getDate();

    if (mes < 10) {
        mes = '0' + mes;
    }
    if (dia < 10) {
        dia = '0' + dia;
    }

    $("data").value = dia + '/' + mes + '/' + ano;

    $("localiza").value = "";

    $("serie").value = "1";

    $("button").disabled = false;

    dadospesquisapalm(0, 0);

}

function dadospesquisapalm(valor, tipo) {


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

                    processXMLpalm(ajax2.responseXML, tipo);
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



function processXMLpalm(obj, tipo) {
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

    dadospesquisadeposito(0, 0);

}


function dadospesquisadeposito(valor, tipo) {


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
        document.forms[0].deposito.options.length = 1;

        idOpcao = document.getElementById("deposito");


        ajax2.open("POST", "romaneiospesquisadeposito.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {

                    processXMLdeposito(ajax2.responseXML, tipo);
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



function processXMLdeposito(obj, tipo) {
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados



        document.forms[0].deposito.options.length = 0;

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
            novo.setAttribute("id", "deposito");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto
            novo.text = descricao;
            //finalmente adiciona o novo elemento
            document.forms[0].deposito.options.add(novo);

        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "____________________";

    }

    //dadospesquisaveiculo(0,0,valor);
    //if (carrega==0){$("pvnumero1").focus();carrega=1;};

    //ver2();
    dadospesquisatipobaixa();

}




function dadospesquisatipobaixa(valor) {


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
        document.forms[0].tipobaixa.options.length = 1;

        idOpcao = document.getElementById("tipobaixa");


        ajax2.open("POST", "pedbaixapesquisatipobaixa.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {

                    processXMLtipobaixa(ajax2.responseXML);
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



function processXMLtipobaixa(obj) {
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados



        document.forms[0].tipobaixa.options.length = 0;

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
            novo.setAttribute("id", "tipobaixa");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto
            novo.text = descricao;
            //finalmente adiciona o novo elemento
            document.forms[0].tipobaixa.options.add(novo);

        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "____________________";

    }

    dadospesquisafiscal();

}




function ver2() {

    valor = codigo;

    if (codigo == 0 || codigo == '') {
        document.forms[0].pcnumero.focus();
    } else {

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

            ajax2.open("POST", "pedcomprabaixapesquisa.php", true);
            ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            ajax2.onreadystatechange = function () {

                //enquanto estiver processando...emite a msg de carregando
                if (ajax2.readyState == 1) {

                }
                //após ser processado - chama função processXML que vai varrer os dados
                if (ajax2.readyState == 4) {
                    if (ajax2.responseXML) {
                        processXML(ajax2.responseXML);
                    } else {

                        ///MOZILA
                        if ($("pcnumero").value != '')
                        {
                            alert("Pedido não existe!");
                        }

                        $("fornguerra").value = '';
                        $("comprador").value = '';


                    }
                }
            }
            //passa o parametro

            var params = "parametro=" + valor;
            ajax2.send(params);
        }

    }

}


function processXML(obj) {


    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados


        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML


            var pcemissao = item.getElementsByTagName("pcemissao")[0].firstChild.nodeValue;
            var fornguerra = item.getElementsByTagName("fornguerra")[0].firstChild.nodeValue;
            var forcodigo = item.getElementsByTagName("forcodigo")[0].firstChild.nodeValue;
            var comprador = item.getElementsByTagName("comprador")[0].firstChild.nodeValue;
            var condicao = item.getElementsByTagName("condicao")[0].firstChild.nodeValue;
            var observacao1 = item.getElementsByTagName("observacao1")[0].firstChild.nodeValue;
            var observacao2 = item.getElementsByTagName("observacao2")[0].firstChild.nodeValue;
            var observacao3 = item.getElementsByTagName("observacao3")[0].firstChild.nodeValue;
            var comissao = item.getElementsByTagName("comissao")[0].firstChild.nodeValue;
            var total = item.getElementsByTagName("total")[0].firstChild.nodeValue;
            var ipi = item.getElementsByTagName("ipi")[0].firstChild.nodeValue;
            var desconto = item.getElementsByTagName("desconto")[0].firstChild.nodeValue;

            var localentrega = item.getElementsByTagName("localentrega")[0].firstChild.nodeValue;
            var percipi = item.getElementsByTagName("percipi")[0].firstChild.nodeValue;
            var icm = item.getElementsByTagName("icm")[0].firstChild.nodeValue;
            var pcempresa = item.getElementsByTagName("pcempresa")[0].firstChild.nodeValue;

            trimjs(pcemissao);
            if (txt == '0') {
                txt = '';
            }
            ;
            pcemissao = txt;
            trimjs(fornguerra);
            if (txt == '0') {
                txt = '';
            }
            ;
            fornguerra = txt;
            trimjs(forcodigo);
            if (txt == '0') {
                txt = '';
            }
            ;
            forcodigo = txt;
            trimjs(comprador);
            if (txt == '0') {
                txt = '';
            }
            ;
            comprador = txt;
            trimjs(condicao);
            if (txt == '0') {
                txt = '';
            }
            ;
            condicao = txt;
            trimjs(observacao1);
            if (txt == '0') {
                txt = '';
            }
            ;
            observacao1 = txt;
            trimjs(observacao2);
            if (txt == '0') {
                txt = '';
            }
            ;
            observacao2 = txt;
            trimjs(observacao3);
            if (txt == '0') {
                txt = '';
            }
            ;
            observacao3 = txt;
            trimjs(comissao);
            if (txt == '0') {
                txt = '';
            }
            ;
            comissao = txt;
            trimjs(total);
            total = txt;
            trimjs(ipi);
            ipi = txt;
            trimjs(desconto);
            desconto = txt;

            trimjs(localentrega);
            localentrega = txt;
            trimjs(percipi);
            percipi = txt;
            trimjs(icm);
            icm = txt;

            var produtos = (total - desconto);
            produtos = (Math.round(produtos * 100)) / 100;
            produtos = (produtos.format(2, ",", "."));
            produtos = produtos.pad(14, " ", String.PAD_LEFT);

            total = (Math.round(total * 100)) / 100;
            total = (total.format(2, ",", "."));
            total = total.pad(14, " ", String.PAD_LEFT);

            desconto = (Math.round(desconto * 100)) / 100;
            desconto = (desconto.format(2, ",", "."));
            desconto = desconto.pad(14, " ", String.PAD_LEFT);

            ipi = (Math.round(ipi * 100)) / 100;
            ipi = (ipi.format(2, ",", "."));
            ipi = ipi.pad(14, " ", String.PAD_LEFT);

            //$("pcemissao").value=pcemissao;
            $("fornguerra").value = fornguerra;
            $("comprador").value = comprador;
            $("codigo2").value = forcodigo;
            $("icm").value = icm;
            $("percipi").value = percipi;

            //Pedidos da FUN devem cair no estoque 38
            if (pcempresa == 2) {
                itemcombo(38);
                document.forms[0].deposito.disabled = true;
            } else if (localentrega == 1) {
                itemcombo(1);
                document.forms[0].deposito.disabled = true;
            } else if (localentrega == 2)
            {
                itemcombo(2);
                document.forms[0].deposito.disabled = true;
            } else if (localentrega == 4)
            {
                itemcombo(11);
                document.forms[0].deposito.disabled = true;
            } else if (localentrega == 5)
            {
                itemcombo(26);
                document.forms[0].deposito.disabled = true;
            } else
            {
                itemcombo(9);
                document.forms[0].deposito.disabled = false;
            }

        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo

        if ($("pcnumero").value != '')
        {
            alert("Pedido não existe!");
            document.forms[0].pcnumero.focus();
        }

        $("fornguerra").value = '';
        $("comprador").value = '';
        $("codigo2").value = '';


    }

    load_grid($("pcnumero").value);

}




// JavaScript Document
function load_grid(pcnumero) {

    let titulo = "PROCESSANDO, AGUARDE...";
    let mensagem = "EXECUTANDO PESQUISA DE ITENS!";

    $a("#retorno").messageBoxModal(titulo, mensagem);

    new ajax('pedcomprabaixapesquisapedido.php?pcnumero=' + pcnumero, {onLoading: carregando, onComplete: imprime});
}

function carregando() {
    $("msg").style.visibility = "visible";
    $("msg").innerHTML = "Processando...";
}

function imprime(request) {

    $("resultado").innerHTML = "";

    $("msg").style.visibility = "hidden";
    var xmldoc = request.responseXML;
    var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];
    if (cabecalho != null)
    {

        let tabela = "<div class='limiter'>"
        tabela += "<div class='container-table100'>"
        tabela += "<div class='wrap-table150'>"
        tabela += "<div class='table-max'>"
        tabela += "<div class='row-max header'>"
        tabela += "<div class='cell-max'>Codigo</div>"
        tabela += "<div class='cell-max'>Referencia</div>"
        tabela += "<div class='cell-max'>Produto</div>"
        tabela += "<div class='cell-max'>Qtd</div>"
        tabela += "<div class='cell-max'>Preço</div>"
        tabela += "<div class='cell-max'>Baixar</div>"
        tabela += "<div class='cell-max'>Valor</div>"
        tabela += "<div class='cell-max'>ICMS</div>"
        tabela += "<div class='cell-max'>IPI</div>"
        tabela += "<div class='cell-max'>IVA</div>"
        tabela += "<div class='cell-max'>ST</div>"
        tabela += "<div class='cell-max'>Emb</div>"
        tabela += "<div class='cell-max'>EAN</div>"
        tabela += "<div class='cell-max'>DUN</div>"
        tabela += "<div class='cell-max'>Fiscal</div>"
        tabela += "<div class='cell-max'>Baixa</div>"
        tabela += "</div>";

        //corpo da tabela

        var cod = 0;
        var registros = xmldoc.getElementsByTagName('registro');
        for (i = 0; i < registros.length; i++) {
            var itens = registros[i].getElementsByTagName('item');

            var saldo = itens[3].firstChild.data - itens[6].firstChild.data;
            if (saldo != 0) {

                tabela += "<div class='row-max'>"
                for (j = 0; j < itens.length; j++) {
                    if (itens[j].firstChild == null) {
                        tabela += "<div class='cell-max'>" + 0 + "</div>"
                    } else {

                        if (j == 0) {
                            vet[i][5] = itens[j].firstChild.data;
                            tabela += "<div class='cell-max' data-title='Codigo'>" + itens[j].firstChild.data + "</div>";
                        } else if (j == 1) {
                            tabela += "<div class='cell-max' data-title='Referencia'>" + itens[j].firstChild.data + "</div>";
                        } else if (j == 2) {
                            tabela += "<div class='cell-max' data-title='Produto'>" + itens[j].firstChild.data + "</div>";
                        } else if (j == 3) {
                            var saldo = itens[j].firstChild.data - itens[6].firstChild.data;
                            tabela += "<div class='cell-max' data-title='Qtd'>" + saldo + "</div>";
                            vet[i][3] = saldo;
                            vet[i][4] = itens[6].firstChild.data;
                        } else if (j == 4) {

                            var liq = itens[j].firstChild.data
                            var desc1 = itens[7].firstChild.data
                            var desc2 = itens[8].firstChild.data
                            var desc3 = itens[9].firstChild.data
                            var desc4 = itens[10].firstChild.data
                            var ipi = itens[11].firstChild.data
                            var d1 = 0;
                            var d2 = 0;
                            var d3 = 0;
                            var d4 = 0;

                            if (desc1 != 0) {
                                d1 = liq / 100 * desc1;
                            } else {
                                d1 = 0;
                            }
                            liq = liq - d1;
                            if (desc2 != 0) {
                                d2 = liq / 100 * desc2;
                            } else {
                                d2 = 0;
                            }
                            liq = liq - d2;
                            if (desc3 != 0) {
                                d3 = liq / 100 * desc3;
                            } else {
                                d3 = 0;
                            }
                            liq = liq - d3;
                            if (desc4 != 0) {
                                d4 = liq / 100 * desc4;
                            } else {
                                d4 = 0;
                            }
                            liq = liq - d4;
                            var vipi = 0;

                            if (ipi != 0) {
                                vipi = liq / 100 * ipi;
                            }
                            //var val=liq+vipi;
                            var val = liq;

                            val = (Math.round(val * 100)) / 100;

                            vet[i][8] = val;

                            val = (val.format(2, ",", "."));
                            tabela += "<div class='cell-max' data-title='Preço'>" + val + "</div>";

                        } else if (j == 5) {

                            cod = itens[j].firstChild.data;

                            vet[i][0] = cod;
                            vet[i][1] = saldo;
                            vet[i][2] = itens[6].firstChild.data;

                            tabela += "<div class='cell-max' data-title='Baixar'>" + "<input type='text' id='" + cod + "' name='" + cod + "' value='" + saldo + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='4' onBlur='convertField3(this);editar(" + cod + ",this.value," + itens[6].firstChild.data + ");'>" + "</div>"

                            val = vet[i][8];

                            vet[i][20] = val;

                            val = (val.format(2, ".", ","));

                            tabela += "<div class='cell-max' data-title='Valor'>" + "<input type='text' id='val" + cod + "' name='" + cod + "' value='" + val + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='4' onBlur='convertField3(this);editarvalnf(" + cod + ",this.value);'>" + "</div>"

                            if (document.getElementById("radioperc2").checked == true) {
                                tabela += "<div class='cell-max' data-title='ICMS'>" + "<input type='text' id='icm" + cod + "' name='icm" + cod + "' value='0' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='5' onBlur='convertField3(this);editaricm(" + cod + ",this.value);'>" + "</div>"
                                tabela += "<div class='cell-max' data-title='IPI'>" + "<input type='text' id='ipi" + cod + "' name='ipi" + cod + "' value='0' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='5' onBlur='convertField3(this);editaripi(" + cod + ",this.value);'>" + "</div>"

                            } else
                            {
                                tabela += "<div class='cell-max' data-title='ICMS'>" + "<input type='text' id='icm" + cod + "' name='icm" + cod + "' value='0' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='5' onBlur='convertField3(this);editaricm(" + cod + ",this.value);' disabled>" + "</div>"
                                tabela += "<div class='cell-max' data-title='IPI'>" + "<input type='text' id='ipi" + cod + "' name='ipi" + cod + "' value='0' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='5' onBlur='convertField3(this);editaripi(" + cod + ",this.value);' disabled>" + "</div>"
                            }


                            if (itens[21] != undefined) {
                                var iva = itens[21].firstChild.data;
                            } else
                            {
                                var iva = "0";
                            }
                            if (itens[22] != undefined)
                            {
                                var st = itens[22].firstChild.data;
                            } else
                            {
                                var st = "0";
                            }


                            vet[i][18] = iva;
                            vet[i][19] = st;

                            if (document.getElementById("radiost1").checked == true) {
                                tabela += "<div class='cell-max' data-title='IVA'>" + "<input type='text' id='iva" + cod + "' name='iva" + cod + "' value='" + iva + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='5' onBlur='convertField3(this);editariva(" + cod + ",this.value);'>" + "</div>"
                                tabela += "<div class='cell-max' data-title='ST'>" + "<input type='text' id='st" + cod + "' name='st" + cod + "' value='" + st + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='5' onBlur='convertField04(this);editarst(" + cod + ",this.value);'>" + "</div>"
                            } else
                            {
                                tabela += "<div class='cell-max' data-title='IVA'>" + "<input type='text' id='iva" + cod + "' name='iva" + cod + "' value='" + iva + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='5' onBlur='convertField3(this);editariva(" + cod + ",this.value);' disabled>" + "</div>"
                                tabela += "<div class='cell-max' data-title='ST'>" + "<input type='text' id='st" + cod + "' name='st" + cod + "' value='" + st + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='5' onBlur='convertField04(this);editarst(" + cod + ",this.value);' disabled>" + "</div>"
                            }

                        } else if (j == 12) {
                            vet[i][10] = itens[j].firstChild.data;
                        } else if (j == 13) {
                            vet[i][11] = itens[j].firstChild.data;
                        } else if (j == 14) {
                            vet[i][12] = itens[j].firstChild.data;
                        } else if (j == 15) {
                            vet[i][13] = itens[j].firstChild.data;
                        } else if (j == 16) {
                            vet[i][14] = itens[j].firstChild.data;
                            tabela += "<div class='cell-max' data-title='EMB'>" + "<input type='text' id='proemb" + cod + "' name='proemb" + cod + "' value='" + itens[j].firstChild.data + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='5' onBlur='convertField3(this);editar1(" + cod + ",this.value,14);'>" + "</div>"
                        } else if (j == 17) {

                            vet[i][17] = itens[20].firstChild.data;
                            tabela += "<div class='cell-max' data-title='EAN'>" + "<input type='text' id='barunidade" + cod + "' name='barunidade" + cod + "'value='" + itens[20].firstChild.data + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='14' onBlur='convertField3(this);editar1(" + cod + ",this.value,17);'>" + "</div>"

                            vet[i][15] = itens[j].firstChild.data;
                            tabela += "<div class='cell-max' data-title='DUN'>" + "<input type='text' id='barcaixa" + cod + "' name='barcaixa" + cod + "'value='" + itens[j].firstChild.data + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='14' onBlur='convertField3(this);editar1(" + cod + ",this.value,15);'>" + "</div>"

                        } else if (j == 18) {

                            vet[i][16] = itens[19].firstChild.data;
                            tabela += "<div class='cell-max' data-title='Fiscal'>" + "<input type='text' id='cf" + cod + "' name='cf" + cod + " 'value='" + itens[j].firstChild.data + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px; cursor: pointer' size='7' readonly onClick=alteracf(" + cod + ")>" + "</div>"

                            cod = itens[5].firstChild.data;
                            tabela += "<div class='cell-max' data-title='Baixa'><label class='check-container-grid'><input type='checkbox' id='chk" + cod + "' name='chk" + cod + "' onClick=editarbaixa(" + cod + "); ><span class='check-checkmark-grid'></span></label></div>"

                            vet[i][9] = 0;
                        }

                    }

                }
                tabela += "</div>"
            }
        }

        tabela += "</div>"
        tabela += "</div>"
        tabela += "</div>"
        tabela += "</div>"

        $("resultado").innerHTML = tabela;

        tabela = null;
    } else
    {
        $("resultado").innerHTML = "Nenhum registro encontrado...";
    }

    //Habilita todos os botões de manutenção e Desabilita a pesquisa
    document.getElementById('button').disabled = false;
    document.getElementById('button2').disabled = false;
    document.getElementById('button3').disabled = false;
    document.getElementById('button_pesquisa_prod').disabled = false;
    document.getElementById('button_pesquisa').disabled = true;
    document.getElementById('pcnumero').disabled = true;

    $a.unblockUI();

    //alert(pos);

    if (pos == 1) {


        $("data").value = "";
        $("datanota").value = "";
        $("nota").value = "";
        $("cfop").value = 0;
        $("produtos").value = 0;
        $("icm").value = 0;
        $("baseicm").value = 0;
        $("valoricm").value = 0;
        $("isentas").value = 0;
        $("outras").value = 0;
        $("baseipi").value = 0;
        $("percipi").value = 0;
        $("valoripi").value = 0;
        $("totalnota").value = 0;
        $("observacoes").value = "";

        $("localiza").value = "";

        $("outrasipi").value = 0;

        $("cfop2").value = "";
        $("basesubst").value = 0;
        $("valorsubst").value = 0;
        $("perciva").value = 0;

        document.getElementById("radiost2").checked = true;

        document.forms[0].pcnumero.focus();
        pos = 0;
    }

    if (xpdf == 1)
    {
        imppdf();
    }


}

function imprimeold(request) {

    $("resultado").innerHTML = "";

    $("msg").style.visibility = "hidden";
    var xmldoc = request.responseXML;
    var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];
    if (cabecalho != null)
    {


        var tabela = "<table width='715' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' ><tr>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Codigo</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Ref. Forn.</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Produto</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>QTD</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Valor</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Baixa</b></td>"

        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Valor NF</b></td>"

        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>ICM</b></td>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>IPI</b></td>"

        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>IVA</b></td>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>ST</b></td>"
        /*
         tabela+="<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Altura</b></td>"
         tabela+="<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Largura</b></td>"
         tabela+="<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Compr.</b></td>"
         tabela+="<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Peso</b></td>"
         */

        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Emb.</b></td>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Cod. Barras</b></td>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Cod. Bar. Caixa</b></td>"

        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Cl. Fiscal</b></td>"

        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><center><b>.</b></center></td>"

        //corpo da tabela

        var cod = 0;
        var registros = xmldoc.getElementsByTagName('registro');
        for (i = 0; i < registros.length; i++) {
            var itens = registros[i].getElementsByTagName('item');

            //var saldo=itens[2].firstChild.data-itens[5].firstChild.data;
            var saldo = itens[3].firstChild.data - itens[6].firstChild.data;
            if (saldo != 0) {

                tabela += "<tr id=linha" + i + ">"
                for (j = 0; j < itens.length; j++) {
                    if (itens[j].firstChild == null)
                        tabela += "<td class='borda'>" + 0 + "</td>";
                    else
                    if (j == 3) {
                        var saldo = itens[j].firstChild.data - itens[6].firstChild.data;
                        tabela += "<td class='borda' align='right'>&nbsp;" + saldo + "&nbsp;</td>";
                        vet[i][3] = saldo;
                        vet[i][4] = itens[6].firstChild.data;
                    } else if (j == 4) {

                        var liq = itens[j].firstChild.data
                        var desc1 = itens[7].firstChild.data
                        var desc2 = itens[8].firstChild.data
                        var desc3 = itens[9].firstChild.data
                        var desc4 = itens[10].firstChild.data
                        var ipi = itens[11].firstChild.data
                        var d1 = 0;
                        var d2 = 0;
                        var d3 = 0;
                        var d4 = 0;

                        if (desc1 != 0) {
                            d1 = liq / 100 * desc1;
                        } else {
                            d1 = 0;
                        }
                        liq = liq - d1;
                        if (desc2 != 0) {
                            d2 = liq / 100 * desc2;
                        } else {
                            d2 = 0;
                        }
                        liq = liq - d2;
                        if (desc3 != 0) {
                            d3 = liq / 100 * desc3;
                        } else {
                            d3 = 0;
                        }
                        liq = liq - d3;
                        if (desc4 != 0) {
                            d4 = liq / 100 * desc4;
                        } else {
                            d4 = 0;
                        }
                        liq = liq - d4;
                        var vipi = 0;

                        if (ipi != 0) {
                            vipi = liq / 100 * ipi;
                        }
                        //var val=liq+vipi;
                        var val = liq;

                        val = (Math.round(val * 100)) / 100;

                        vet[i][8] = val;

                        val = (val.format(2, ",", "."));

                        tabela += "<td class='borda' align='right'>&nbsp;" + val + "&nbsp;</td>";
                    } else if (j == 5) {

                        cod = itens[j].firstChild.data;

                        vet[i][0] = cod;
                        vet[i][1] = saldo;
                        vet[i][2] = itens[6].firstChild.data;

                        tabela += "<td class='borda' style='cursor: pointer'><input type='text' id='" + cod + "' name='" + cod + "' value='" + saldo + "' size='4' onBlur='convertField3(this);editar(" + cod + ",this.value," + itens[6].firstChild.data + ");'></td>";

                        val = vet[i][8];

                        vet[i][20] = val;

                        val = (val.format(2, ".", ","));
                        tabela += "<td class='borda' style='cursor: pointer'><input type='text' id='" + cod + "' name='" + cod + "' value='" + val + "' size='4' onBlur='convertField3(this);editarvalnf(" + cod + ",this.value);'></td>";

                        if (document.getElementById("radioperc2").checked == true) {
                            tabela += "<td class='borda'><input type='text' id='icm" + cod + "' name='icm" + cod + "' value='0' size='5' onBlur='convertField3(this);editaricm(" + cod + ",this.value);'></td>";
                            tabela += "<td class='borda'><input type='text' id='ipi" + cod + "' name='ipi" + cod + "' value='0' size='5' onBlur='convertField3(this);editaripi(" + cod + ",this.value);'></td>";
                        } else
                        {
                            tabela += "<td class='borda'><input type='text' id='icm" + cod + "' name='icm" + cod + "' value='0' size='5' onBlur='convertField3(this);editaricm(" + cod + ",this.value);' disabled ></td>";
                            tabela += "<td class='borda'><input type='text' id='ipi" + cod + "' name='ipi" + cod + "' value='0' size='5' onBlur='convertField3(this);editaripi(" + cod + ",this.value);' disabled ></td>";
                        }


                        if (itens[21] != undefined) {
                            var iva = itens[21].firstChild.data;
                        } else
                        {
                            var iva = "0";
                        }
                        if (itens[22] != undefined)
                        {
                            var st = itens[22].firstChild.data;
                        } else
                        {
                            var st = "0";
                        }


                        vet[i][18] = iva;
                        vet[i][19] = st;

                        if (document.getElementById("radiost1").checked == true) {
                            tabela += "<td class='borda'><input type='text' id='iva" + cod + "' name='iva" + cod + "' value='" + iva + "' size='5' onBlur='convertField3(this);editariva(" + cod + ",this.value);'  ></td>";
                            tabela += "<td class='borda'><input type='text' id='st" + cod + "' name='st" + cod + "' value='" + st + "' size='5' onBlur='convertField04(this);editarst(" + cod + ",this.value);'  ></td>";
                        } else
                        {
                            tabela += "<td class='borda'><input type='text' id='iva" + cod + "' name='iva" + cod + "' value='" + iva + "' size='5' onBlur='convertField3(this);editariva(" + cod + ",this.value);' disabled ></td>";
                            tabela += "<td class='borda'><input type='text' id='st" + cod + "' name='st" + cod + "' value='" + st + "' size='5' onBlur='convertField04(this);editarst(" + cod + ",this.value);' disabled ></td>";
                        }

                    } else if (j == 0) {
                        tabela += "<td class='borda'>" + itens[j].firstChild.data + "</td>";

                        vet[i][5] = itens[j].firstChild.data;

                    } else if (j == 1) {
                        tabela += "<td class='borda'>" + itens[j].firstChild.data + "</td>";
                    } else if (j == 2) {
                        tabela += "<td class='borda'>" + itens[j].firstChild.data + "</td>";
                    } else if (j == 12) {
                        vet[i][10] = itens[j].firstChild.data;
                        //tabela+="<td class='borda'><input type='text' id='proaltcx"+cod+"' name='proaltcx"+cod+"' value='"+itens[j].firstChild.data+"' size='5' onBlur='convertField3(this);editar1("+cod+",this.value,10);' ></td>";
                    } else if (j == 13) {
                        vet[i][11] = itens[j].firstChild.data;
                        //tabela+="<td class='borda'><input type='text' id='prolarcx"+cod+"' name='prolarcx"+cod+"' value='"+itens[j].firstChild.data+"' size='5' onBlur='convertField3(this);editar1("+cod+",this.value,11);' ></td>";
                    } else if (j == 14) {
                        vet[i][12] = itens[j].firstChild.data;
                        //tabela+="<td class='borda'><input type='text' id='procomcx"+cod+"' name='procomcx"+cod+"' value='"+itens[j].firstChild.data+"' size='5' onBlur='convertField3(this);editar1("+cod+",this.value,12);' ></td>";
                    } else if (j == 15) {
                        vet[i][13] = itens[j].firstChild.data;
                        //tabela+="<td class='borda'><input type='text' id='propescx"+cod+"' name='propescx"+cod+"' value='"+itens[j].firstChild.data+"' size='5' onBlur='convertField3(this);editar1("+cod+",this.value,13);' ></td>";
                    } else if (j == 16) {
                        vet[i][14] = itens[j].firstChild.data;
                        tabela += "<td class='borda'><input type='text' id='proemb" + cod + "' name='proemb" + cod + "' value='" + itens[j].firstChild.data + "' size='5' onBlur='convertField3(this);editar1(" + cod + ",this.value,14);' ></td>";
                    } else if (j == 17) {

                        vet[i][17] = itens[20].firstChild.data;
                        tabela += "<td class='borda'><input type='text' id='barunidade" + cod + "' name='barunidade" + cod + "'value='" + itens[20].firstChild.data + "' size='14' onBlur='convertField3(this);editar1(" + cod + ",this.value,17);' ></td>";

                        vet[i][15] = itens[j].firstChild.data;
                        tabela += "<td class='borda'><input type='text' id='barcaixa" + cod + "' name='barcaixa" + cod + "'value='" + itens[j].firstChild.data + "' size='14' onBlur='convertField3(this);editar1(" + cod + ",this.value,15);' ></td>";
                    } else if (j == 18) {

                        vet[i][16] = itens[19].firstChild.data;
                        tabela += "<td class='borda' ><input type='text' id='cf" + cod + "' name='cf" + cod + " 'value='" + itens[j].firstChild.data + "' size='7'  style='cursor: pointer' readonly onClick=alteracf(" + cod + ") ></td>";

                        cod = itens[5].firstChild.data;
                        tabela += "<td class='borda'><input type='checkbox' id='chk" + cod + "' name='chk" + cod + "' onClick=editarbaixa(" + cod + "); > </td>";
                        vet[i][9] = 0;
                    }

                }



                tabela += "</tr>";
            }
        }

        tabela += "</table>"


        tabela += "</tr>"

        $("resultado").innerHTML = tabela;
        //$("resultado2").innerHTML=tabela2;
        tabela = null;
    } else
    {
        $("resultado").innerHTML = "Nenhum registro encontrado...";
    }


    //alert(pos);

    if (pos == 1) {


        $("data").value = "";
        $("datanota").value = "";
        $("nota").value = "";
        $("cfop").value = 0;
        $("produtos").value = 0;
        $("icm").value = 0;
        $("baseicm").value = 0;
        $("valoricm").value = 0;
        $("isentas").value = 0;
        $("outras").value = 0;
        $("baseipi").value = 0;
        $("percipi").value = 0;
        $("valoripi").value = 0;
        $("totalnota").value = 0;
        $("observacoes").value = "";

        $("localiza").value = "";

        $("outrasipi").value = 0;

        $("cfop2").value = "";
        $("basesubst").value = 0;
        $("valorsubst").value = 0;
        $("perciva").value = 0;

        document.getElementById("radiost2").checked = true;

        document.forms[0].pcnumero.focus();
        pos = 0;
    }

    if (xpdf == 1)
    {
        imppdf();
    }


}

function alteracf(val1) {

    codvet = val1;

    $("buttoncf").disabled = false;

    for (var k = 0; k < 700; k++) {
        if (vet[k][0] == val1) {
            itemcombofiscal(vet[k][16]);
            k = 700;
        }
    }


    document.forms[0].listfiscais.focus();

}

function verificacf() {
    /*
     for(var k = 0 ; k < 700 ; k++) {
     if (vet[k][0]==codvet){
     vet[k][16]=document.forms[0].listfiscais.options[document.forms[0].listfiscais.selectedIndex].value;
     $("cf"+codvet).value=document.forms[0].listfiscais.options[document.forms[0].listfiscais.selectedIndex].text;
     k=700;
     }
     }
     
     
     $("buttoncf").disabled = true;
     
     if (document.forms[0].listfiscais.options[document.forms[0].listfiscais.selectedIndex].value==4){
     document.getElementById('chk'+codvet).checked = false;
     editarbaixa2(codvet);
     }
     if (document.forms[0].listfiscais.options[document.forms[0].listfiscais.selectedIndex].value==5){
     document.getElementById('chk'+codvet).checked = false;
     editarbaixa2(codvet);
     }
     if (document.forms[0].listfiscais.options[document.forms[0].listfiscais.selectedIndex].value==6){
     document.getElementById('chk'+codvet).checked = false;
     editarbaixa2(codvet);
     }
     */

    for (var k = 0; k < 700; k++) {
        if (vet[k][0] == codvet) {
            vet[k][16] = document.forms[0].listfiscais.options[document.forms[0].listfiscais.selectedIndex].value;
            $("cf" + codvet).value = document.forms[0].listfiscais.options[document.forms[0].listfiscais.selectedIndex].text;
            k = 700;
        }
    }

    $("buttoncf").disabled = true;

}


function editar1(val1, val2, val3) {

    for (var k = 0; k < 700; k++) {
        if (vet[k][0] == val1) {
            vet[k][val3] = val2;
        }
    }

}


function editar(val1, val2, val3) {


    for (var k = 0; k < 700; k++) {
        if (vet[k][0] == val1) {

            //alert(vet[k][1]+' '+vet[k][2]);

            vet[k][1] = val2;
            vet[k][2] = val3;

            //alert(vet[k][1]+' '+vet[k][2]);

        }


    }


}


function editarvalnf(val1, val2) {


    for (var k = 0; k < 700; k++) {
        if (vet[k][0] == val1) {
            vet[k][20] = val2;
        }


    }


}


function editaricm(val1, val2) {

    for (var k = 0; k < 700; k++) {
        if (vet[k][0] == val1) {
            vet[k][6] = val2;
        }
    }
}

function editaripi(val1, val2) {

    for (var k = 0; k < 700; k++) {
        if (vet[k][0] == val1) {
            vet[k][7] = val2;
        }
    }
}

function editariva(val1, val2) {

    for (var k = 0; k < 700; k++) {
        if (vet[k][0] == val1) {
            vet[k][18] = val2;
        }
    }
}

function editarst(val1, val2) {

    for (var k = 0; k < 700; k++) {
        if (vet[k][0] == val1) {
            vet[k][19] = val2;
        }
    }
}

function editarbaixa(val1) {

    val2 = document.getElementById('chk' + val1).checked;

    if (val2 == true) {
        var val3 = 1;
    } else {
        var val3 = 0;
    }

    //alert(val3);

    for (var k = 0; k < 700; k++) {
        if (vet[k][0] == val1) {
            vet[k][9] = val3;
        }
    }

}

function baixa() {

    if (baixando == 1) {
        //   return;
    }
    baixando = 1;

    $("button").disabled = true;
    valor = $("cfop").value;

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

        ajax2.open("POST", "cfoppesquisa.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {

            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                //dOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLcpof(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                    baixando = 0;
                    $("button").disabled = false;
                    alert('CFOP Inválido!');
                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }


}




function processXMLcpof(obj) {
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        baixa1();
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo
        baixando = 0;
        $("button").disabled = false;
        alert('CFOP Inválido!');
    }
}


function baixa1() {

    if (baixando == 1) {
        //   return;
    }
    baixando = 1;

    $("button").disabled = true;
    valor = $("cfop2").value;

    trimjs(valor);

    if (txt == '') {
        baixa2();
    } else {


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

            ajax2.open("POST", "cfoppesquisa.php", true);
            ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            ajax2.onreadystatechange = function () {

                //enquanto estiver processando...emite a msg de carregando
                if (ajax2.readyState == 1) {
                    //dOpcao.innerHTML = "Carregando...!";
                }
                //após ser processado - chama função processXML que vai varrer os dados
                if (ajax2.readyState == 4) {
                    if (ajax2.responseXML) {
                        processXMLcpof1(ajax2.responseXML);
                    } else {
                        //caso não seja um arquivo XML emite a mensagem abaixo
                        baixando = 0;
                        $("button").disabled = false;
                        alert('CFOP Subst. Inválido!');
                    }
                }
            }
            //passa o parametro
            var params = "parametro=" + valor;
            ajax2.send(params);
        }

    }
}




function processXMLcpof1(obj) {
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        baixa2();
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo
        baixando = 0;
        $("button").disabled = false;
        alert('CFOP Subst. Inválido!');
    }
}




function baixa2() {

//   alert(1218);

    continua = 1;

    est = document.forms[0].deposito.options[document.forms[0].deposito.selectedIndex].value;

    for (var k = 0; k < 700; k++) {
        if (vet[k][9] == 1) {

            if (vet[k][16] == '0') {
                continua = 2
            }
            if (vet[k][16] == '241') {
                continua = 2
            }
            if (vet[k][16] == '242') {
                continua = 2
            }


        }
    }

    if (continua == 1) {
        baixa3();
    } else
    {

        baixando = 0;
        $("button").disabled = false;
        alert('A classificação fiscal deve estar cadastrada para os itens baixados!');

    }

}


function baixa3() {

    var n1 = Math.round($("nota").value);
    $("nota").value = n1;
    if ($("nota").value == "NaN") {
        $("nota").value = '';
    }

    if ($("pcnumero").value == "") {
        alert("Preencha o Número do Pedido")
        baixando = 0;
        $("button").disabled = false;
        document.getElementById("pcnumero").focus();
    } else if ($("data").value == "") {
        alert("Preencha a Data")
        baixando = 0;
        $("button").disabled = false;
        document.getElementById("data").focus();
    } else if ($("datanota").value == "") {
        alert("Preencha a Data da Nota")
        baixando = 0;
        $("button").disabled = false;
        document.getElementById("datanota").focus();
    } else if ($("nota").value == "") {
        alert("Preencha o Número da Nota")
        baixando = 0;
        $("button").disabled = false;
        document.getElementById("nota").focus();
    } else {


        var continua = 0;
        for (var k = 0; k < 700; k++) {

            if (vet[k][9] != 0) {

                if (vet[k][0] != 0) {


                    if (vet[k][1] != 0) {
                        continua = 1;
                    }

                }

            }
        }


        if (continua == 0) {
            alert("Selecione os itens que serão baixados!");
            baixando = 0;
            $("button").disabled = false;
            return;
        }

        var erros = '';

        //Verifica se alguma quantidade é maior que o Saldo
        var erro = 0;
        for (var k = 0; k < 700; k++) {
            if (vet[k][9] != 0) {
                if (vet[k][0] != 0) {
                    if (vet[k][1] > vet[k][3]) {
                        erros = erros + vet[k][5] + ' ' + vet[k][3] + ' ' + vet[k][1] + '\n';
                        erro = 1;
                    }
                }
            }
        }

        if (erro == 1) {
            alert("Existem itens com quantidade maior que o Saldo !\n" + erros);
            baixando = 0;
            $("button").disabled = false;
            return;
        }


        verificanumeronota();
    }

}

function verificanumeronota() {

    baixando = 1;

    $("button").disabled = true;

    var cod = document.getElementById('pcnumero').value;
    var nota = document.getElementById('nota').value;
    var serie = document.getElementById('serie').value;

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

        ajax2.open("POST", "notaentpesquisa.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {

            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                //dOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLnotaent(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                    baixando = 0;
                    $("button").disabled = false;
                    alert('Numero da Nota Inválido!');
                }
            }
        }
        //passa o parametro
        var params = "parametro=" + cod + "&parametro2=" + nota + "&parametro3=" + serie;

        //alert( params );
        ajax2.send(params);
    }

}




function processXMLnotaent(obj) {

    var descricao = '0';

    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {

        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];

            descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

        }
    }

    if (descricao == '0') {
        baixafinal();
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo
        baixando = 0;
        $("button").disabled = false;
        alert('Ja existe essa nota na baixa ' + descricao + ' !');
    }
}


function baixafinal() {

    $("button").disabled = true;

    let titulo = "PROCESSANDO, AGUARDE...";
    let mensagem = "GRAVANDO AS INFORMACOES NA BASE DE DADOS!";

    $a("#retorno").messageBoxModal(titulo, mensagem);

    baixando = 0;

    if ($("cfop").value == "") {
        $("cfop").value = 0;
    }

    if ($("produtos").value == "") {
        $("produtos").value = 0;
    }

    if ($("icm").value == "") {
        $("icm").value = 0;
    }

    if ($("baseicm").value == "") {
        $("baseicm").value = 0;
    }

    if ($("valoricm").value == "") {
        $("valoricm").value = 0;
    }

    if ($("isentas").value == "") {
        $("isentas").value = 0;
    }

    if ($("outras").value == "") {
        $("outras").value = 0;
    }

    if ($("baseipi").value == "") {
        $("baseipi").value = 0;
    }

    if ($("percipi").value == "") {
        $("percipi").value = 0;
    }

    if ($("valoripi").value == "") {
        $("valoripi").value = 0;
    }

    if ($("totalnota").value == "") {
        $("totalnota").value = 0;
    }

    if ($("observacoes").value == "") {
        $("observacoes").value = ".";
    }


    if ($("volumes").value == "") {
        $("volumes").value = 0;
    }


    if ($("outrasipi").value == "") {
        $("outrasipi").value = 0;
    }



    if ($("cfop2").value == "") {
        $("cfop2").value = 0;
    }

    if ($("basesubst").value == "") {
        $("basesubst").value = 0;
    }

    if ($("valorsubst").value == "") {
        $("valorsubst").value = 0;
    }

    if ($("perciva").value == "") {
        $("perciva").value = 0;
    }







    pos = 1;



    //----------------------
    var campovet1 = ""
    var campovet2 = ""
    var campovet3 = ""
    var campovet4 = ""
    var campovet5 = ""

    var campovet6 = ""
    var campovet7 = ""
    var campovet8 = ""
    var campovet9 = ""
    var campovet10 = ""
    var campovet11 = ""
    var campovet12 = ""
    var campovet14 = ""
    var campovet15 = ""
    var campovet16 = ""

    var campovet17 = ""


    for (var kk = 0; kk < 700; kk++) {

        if (vet[kk][9] != 0) {
            if (vet[kk][0] != 0) {

                campovet1 = campovet1 + '&c1[]=' + vet[kk][0];
                campovet2 = campovet2 + '&d1[]=' + vet[kk][1];
                campovet3 = campovet3 + '&e1[]=' + vet[kk][2];


                if (document.getElementById("radioperc2").checked == true) {
                    campovet4 = campovet4 + '&f1[]=' + vet[kk][6];
                    campovet5 = campovet5 + '&g1[]=' + vet[kk][7];
                } else
                {
                    campovet4 = campovet4 + '&f1[]=' + document.getElementById('icm').value;
                    campovet5 = campovet5 + '&g1[]=' + document.getElementById('percipi').value;
                }

                campovet6 = campovet6 + '&h1[]=' + vet[kk][10];
                campovet7 = campovet7 + '&i1[]=' + vet[kk][11];
                campovet8 = campovet8 + '&j1[]=' + vet[kk][12];
                campovet9 = campovet9 + '&k1[]=' + vet[kk][13];
                campovet10 = campovet10 + '&l1[]=' + vet[kk][14];
                campovet11 = campovet11 + '&m1[]=' + vet[kk][15];
                campovet12 = campovet12 + '&n1[]=' + vet[kk][16];
                campovet14 = campovet14 + '&o1[]=' + vet[kk][17];

                campovet15 = campovet15 + '&p1[]=' + vet[kk][18];
                campovet16 = campovet16 + '&q1[]=' + vet[kk][19];

                campovet17 = campovet17 + '&r1[]=' + vet[kk][20];

            }
        }

    }
    var cod = document.getElementById('pcnumero').value;



    //----------------------------------
    var cod = document.getElementById('pcnumero').value;
    var nota = document.getElementById('nota').value;
    var serie = document.getElementById('serie').value;

    notax = document.getElementById('nota').value;
    seriex = document.getElementById('serie').value;
    xpdf = 1;
    //------------------------------------



    if (document.getElementById("radiowms1").checked == true) {
        var gerawms = 1;
    } else {
        var gerawms = 2;
    }

    var usuario = $("usuario").value;
    if (usuario == '') {
        usuario = 0
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
    if (ajax2) {

        ajax2.open("POST", "pedcomprabaixainsere.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {

            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {

            }

            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLinclui(ajax2.responseXML, cod);
                }
            }
        }


        var params = 'pcnumero=' + document.getElementById('pcnumero').value
                + '&data=' + document.getElementById('data').value
                + '&datanota=' + document.getElementById('datanota').value
                + '&nota=' + document.getElementById('nota').value
                + '&serie=' + document.getElementById('serie').value
                + '&cfop=' + document.getElementById('cfop').value
                + '&produtos=' + document.getElementById('produtos').value
                + '&icm=' + document.getElementById('icm').value
                + '&baseicm=' + document.getElementById('baseicm').value
                + '&valoricm=' + document.getElementById('valoricm').value
                + '&isentas=' + document.getElementById('isentas').value
                + '&outras=' + document.getElementById('outras').value
                + '&baseipi=' + document.getElementById('baseipi').value
                + '&percipi=' + document.getElementById('percipi').value
                + '&valoripi=' + document.getElementById('valoripi').value
                + '&totalnota=' + document.getElementById('totalnota').value
                + '&observacoes=' + document.getElementById('observacoes').value
                + '&volumes=' + document.getElementById('volumes').value
                + '&outrasipi=' + document.getElementById('outrasipi').value
                + '&gerawms=' + gerawms
                + '&usuario=' + usuario



                + campovet1
                + '' + campovet2
                + '' + campovet3
                + '' + campovet4
                + '' + campovet5

                + '' + campovet6
                + '' + campovet7
                + '' + campovet8
                + '' + campovet9
                + '' + campovet10
                + '' + campovet11
                + '' + campovet12

                + '' + campovet14

                + '' + campovet15
                + '' + campovet16

                + '' + campovet17

                + '&pcnumero1=' + document.getElementById('pcnumero').value
                + '&nota1=' + document.getElementById('nota').value
                + '&serie1=' + document.getElementById('serie').value

                + '&deposito=' + document.forms[0].deposito.options[document.forms[0].deposito.selectedIndex].value

                + '&cfop2=' + document.getElementById('cfop2').value
                + '&basesubst=' + document.getElementById('basesubst').value
                + '&valorsubst=' + document.getElementById('valorsubst').value
                + '&perciva=' + document.getElementById('perciva').value

                + '&tipobaixa=' + document.forms[0].tipobaixa.options[document.forms[0].tipobaixa.selectedIndex].value

        ajax2.send(params);

        //window.open( "pedcomprabaixainsere.php?" + params , "_blank");


    }


}


function processXMLinclui(obj, cod) {
    
    //$a.unblockUI();

    xseq = 0;

    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados

        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            xseq = item.getElementsByTagName("seq")[0].firstChild.nodeValue;
        }


    }

    new ajax('pedcomprabaixaviso.php?pcnumero=' + document.getElementById('pcnumero').value + '&datanota=' + document.getElementById('datanota').value + '&nota1=' + document.getElementById('nota').value, {});
    //window.open( 'pedcomprabaixaviso.php?pcnumero=' + document.getElementById('pcnumero').value + '&datanota=' + document.getElementById('datanota').value + '&nota1=' + document.getElementById('nota').value, "_blank")

    xest = document.forms[0].deposito.options[document.forms[0].deposito.selectedIndex].value;
    ver(cod, 0, 0, 0);

}



function verificaexistenf(valor, valor2, valor3) {
    //verifica se o browser tem suporte a ajax
    //alert('x');

    trimjs(valor);
    if (txt == '') {

    } else {

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

            ajax2.open("POST", "pedcomprabaixapesqnf.php", true);
            ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            ajax2.onreadystatechange = function () {

                //enquanto estiver processando...emite a msg de carregando
                if (ajax2.readyState == 1) {

                }
                //após ser processado - chama função processXML que vai varrer os dados
                if (ajax2.readyState == 4) {
                    if (ajax2.responseXML) {
                        processXMLverificanfimp(ajax2.responseXML, valor);
                    } else {
                        // alert("O Pedido Não Está Finalizado");
                    }
                }
            }
            //passa o parametro
            var params = "parametro=" + valor + '&parametro2=' + valor2 + '&parametro3=' + valor3;

            ajax2.send(params);
        }

    }

}


function processXMLverificanfimp(obj, valor) {

    //alert('Y');

    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados


        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML


            var notnumero = item.getElementsByTagName("notnumero")[0].firstChild.nodeValue;

            if (notnumero == 0) {

            } else
            {
                alert('Nota ' + notnumero + ' ' + $("serie").value + ' já lançada!');
                $("nota").value = '';
                document.getElementById("nota").focus();
            }

        }

    } else {


    }



}


function format(rnum, id) {

    rnum = rnum.replace(",", ".");
    var valor1 = Math.round(rnum * Math.pow(10, 2)) / Math.pow(10, 2);
    var valor2;

    if (valor1 >= 1) {

        valor1 = valor1 * 100;
        valor1 = Math.round(valor1);
        valor1 = valor1.toString();
        valor2 = valor1.substring(0, valor1.length - 2) + '.' + valor1.substring(valor1.length - 2, valor1.length);

        if (valor2 == '.0') {
            valor2 = '0.00'
        }
        if (valor2 == 'N.aN') {
            valor2 = '0.00'
        }

    } else
    {
        valor2 = (valor1.format(2, ".", ","));
    }

    $(id).value = valor2;



}

function formatprod(rnum, id) {

    rnum = rnum.replace(",", ".");
    var valor1 = Math.round(rnum * Math.pow(10, 2)) / Math.pow(10, 2);
    var valor2;

    if (valor1 >= 1) {

        valor1 = valor1 * 100;
        valor1 = Math.round(valor1);
        valor1 = valor1.toString();
        valor2 = valor1.substring(0, valor1.length - 2) + '.' + valor1.substring(valor1.length - 2, valor1.length);

        if (valor2 == '.0') {
            valor2 = '0.00'
        }
        if (valor2 == 'N.aN') {
            valor2 = '0.00'
        }

    } else
    {
        valor2 = (valor1.format(2, ".", ","));
    }

    $(id).value = valor2;
    $("baseicm").value = valor2;
    $("totalnota").value = valor2;

}


function formatbase(rnum, id, perc) {

    rnum = rnum.replace(",", ".");
    var valor1 = Math.round(rnum * Math.pow(10, 2)) / Math.pow(10, 2);
    var valor2;

    if (valor1 >= 1) {

        valor1 = valor1 * 100;
        valor1 = Math.round(valor1);
        valor1 = valor1.toString();
        valor2 = valor1.substring(0, valor1.length - 2) + '.' + valor1.substring(valor1.length - 2, valor1.length);

        if (valor2 == '.0') {
            valor2 = '0.00'
        }
        if (valor2 == 'N.aN') {
            valor2 = '0.00'
        }

    } else
    {
        valor2 = (valor1.format(2, ".", ","));
    }

    $(id).value = valor2;

    //Sugere o ICMS
    rnum = valor2 * perc / 100;

    //rnum = rnum.replace(",",".");

    //alert( rnum );

    valor1 = Math.round(rnum * Math.pow(10, 2)) / Math.pow(10, 2);

    //alert( valor1 );

    if (valor1 >= 1) {

        valor1 = valor1 * 100;
        valor1 = Math.round(valor1);
        valor1 = valor1.toString();
        valor2 = valor1.substring(0, valor1.length - 2) + '.' + valor1.substring(valor1.length - 2, valor1.length);

        if (valor2 == '.0') {
            valor2 = '0.00'
        }
        if (valor2 == 'N.aN') {
            valor2 = '0.00'
        }

    } else
    {
        valor2 = (valor1.format(2, ".", ","));
    }

    $("valoricm").value = valor2;

}

function formatipi(rnum, id, perc) {

    rnum = rnum.replace(",", ".");
    var valor1 = Math.round(rnum * Math.pow(10, 2)) / Math.pow(10, 2);
    var valor2;

    if (valor1 >= 1) {

        valor1 = valor1 * 100;
        valor1 = Math.round(valor1);
        valor1 = valor1.toString();
        valor2 = valor1.substring(0, valor1.length - 2) + '.' + valor1.substring(valor1.length - 2, valor1.length);

        if (valor2 == '.0') {
            valor2 = '0.00'
        }
        if (valor2 == 'N.aN') {
            valor2 = '0.00'
        }

    } else
    {
        valor2 = (valor1.format(2, ".", ","));
    }

    $(id).value = valor2;

    //Sugere o ICMS
    rnum = valor2 * perc / 100;

    if (rnum > 0) {

        //rnum = rnum.replace(",",".");

        //alert( rnum );

        valor1 = Math.round(rnum * Math.pow(10, 2)) / Math.pow(10, 2);

        //alert( valor1 );

        if (valor1 >= 1) {

            valor1 = valor1 * 100;
            valor1 = Math.round(valor1);
            valor1 = valor1.toString();
            valor2 = valor1.substring(0, valor1.length - 2) + '.' + valor1.substring(valor1.length - 2, valor1.length);

            if (valor2 == '.0') {
                valor2 = '0.00'
            }
            if (valor2 == 'N.aN') {
                valor2 = '0.00'
            }

        } else
        {
            valor2 = (valor1.format(2, ".", ","));
        }

        $("valoripi").value = valor2;
    }



    var valoripi = $("valoripi").value;
    valoripi = (Math.round(valoripi * 100)) / 100;

    var tot3 = $("baseipi").value;
    tot3 = (Math.round(tot3 * 100)) / 100;

    var totalnota = tot3 + valoripi;

    totalnota = Math.round(totalnota * Math.pow(10, 2)) / Math.pow(10, 2);

    $("totalnota").value = totalnota;



}

function total1() {

    var valoripi = $("valoripi").value;
    valoripi = (Math.round(valoripi * 100)) / 100;

    var tot3 = $("baseipi").value;
    tot3 = (Math.round(tot3 * 100)) / 100;

    var totalnota = tot3 + valoripi;

    totalnota = Math.round(totalnota * Math.pow(10, 2)) / Math.pow(10, 2);

    $("totalnota").value = totalnota;



}


function todos() {


    if (confirm("Tem certeza que quer baixa total ?")) {

        for (var k = 0; k < 700; k++) {
            if (vet[k][0] != 0) {

                /* continua = 1;
                 
                 if (vet[k][10]=='0'){continua = 2}
                 if (vet[k][11]=='0'){continua = 2}
                 if (vet[k][12]=='0'){continua = 2}
                 if (vet[k][13]=='0'){continua = 2}
                 
                 if (vet[k][16]=='0'){continua = 2}
                 if (vet[k][16]=='4'){continua = 2}
                 if (vet[k][16]=='5'){continua = 2}
                 if (vet[k][16]=='6'){continua = 2}
                 
                 if (continua==1) {
                 */
                $(vet[k][0]).value = vet[k][3];

                vet[k][1] = vet[k][3];
                vet[k][2] = vet[k][4];


                vet[k][9] = 1;

                document.getElementById('chk' + vet[k][0]).checked = true;

                //}


            }
        }


    }




}



function verifica1() {

    $("radiob1").disabled = false;
    $("radiob2").disabled = false;
    $("radioc1").disabled = false;
    $("radioc2").disabled = false;
    $("radiod1").disabled = false;
    $("radiod2").disabled = false;
    $("radioe1").disabled = false;
    $("radioe2").disabled = false;
    $("radiof1").disabled = false;
    $("radiof2").disabled = false;
    $("radiog1").disabled = false;
    $("radiog2").disabled = false;
    $("radioh1").disabled = false;
    $("radioh2").disabled = false;
    $("radioi1").disabled = false;
    $("radioi2").disabled = false;
    $("radioj1").disabled = false;
    $("radioj2").disabled = false;
    $("radiok1").disabled = false;
    $("radiok2").disabled = false;
    $("radiol1").disabled = false;
    $("radiol2").disabled = false;
    $("radiom1").disabled = false;
    $("radiom2").disabled = false;
    $("radion1").disabled = false;
    $("radion2").disabled = false;
    $("radioo1").disabled = false;
    $("radioo2").disabled = false;
    $("radiop1").disabled = false;
    $("radiop2").disabled = false;
    $("radioq1").disabled = false;
    $("radioq2").disabled = false;
    $("radior1").disabled = false;
    $("radior2").disabled = false;
    $("radios1").disabled = false;
    $("radios2").disabled = false;
    $("radiot1").disabled = false;
    $("radiot2").disabled = false;
    $("radiou1").disabled = false;
    $("radiou2").disabled = false;
    $("radiov1").disabled = false;
    $("radiov2").disabled = false;
    $("radiow1").disabled = false;
    $("radiow2").disabled = false;
    $("radiox1").disabled = false;
    $("radiox2").disabled = false;

}


function verifica2() {

    $("radiob1").disabled = true;
    $("radiob2").disabled = true;
    $("radioc1").disabled = true;
    $("radioc2").disabled = true;
    $("radiod1").disabled = true;
    $("radiod2").disabled = true;
    $("radioe1").disabled = true;
    $("radioe2").disabled = true;
    $("radiof1").disabled = true;
    $("radiof2").disabled = true;
    $("radiog1").disabled = true;
    $("radiog2").disabled = true;
    $("radioh1").disabled = true;
    $("radioh2").disabled = true;
    $("radioi1").disabled = true;
    $("radioi2").disabled = true;
    $("radioj1").disabled = true;
    $("radioj2").disabled = true;
    $("radiok1").disabled = true;
    $("radiok2").disabled = true;
    $("radiol1").disabled = true;
    $("radiol2").disabled = true;
    $("radiom1").disabled = true;
    $("radiom2").disabled = true;
    $("radion1").disabled = true;
    $("radion2").disabled = true;
    $("radioo1").disabled = true;
    $("radioo2").disabled = true;
    $("radiop1").disabled = true;
    $("radiop2").disabled = true;
    $("radioq1").disabled = true;
    $("radioq2").disabled = true;
    $("radior1").disabled = true;
    $("radior2").disabled = true;
    $("radios1").disabled = true;
    $("radios2").disabled = true;
    $("radiot1").disabled = true;
    $("radiot2").disabled = true;
    $("radiou1").disabled = true;
    $("radiou2").disabled = true;
    $("radiov1").disabled = true;
    $("radiov2").disabled = true;
    $("radiow1").disabled = true;
    $("radiow2").disabled = true;
    $("radiox1").disabled = true;
    $("radiox2").disabled = true;
}



function verificaperc1() {
    //$("icm").disabled = false;
    //$("percipi").disabled = false;

    for (var k = 0; k < 700; k++) {
        if (vet[k][0] != 0) {

            $("ipi" + vet[k][0]).value = 0;
            $("icm" + vet[k][0]).value = 0;
            $("ipi" + vet[k][0]).disabled = true;
            $("icm" + vet[k][0]).disabled = true;

        }
    }

}


function verificaperc2() {

    //$("icm").value = 0;
    //$("percipi").value = 0;
    //$("icm").disabled = true;
    //$("percipi").disabled = true;

    for (var k = 0; k < 700; k++) {
        if (vet[k][0] != 0) {

            $("ipi" + vet[k][0]).disabled = false;
            $("icm" + vet[k][0]).disabled = false;

        }
    }

}

function sugeretotal(valor) {

    $("baseipi").value = valor;

}



function verificapalm() {
    if (confirm("Importar pedidos do Palm?")) {
        //importa_palm();
        dadospesquisapalm2(document.forms[0].palm.options[document.forms[0].palm.selectedIndex].value);
    }
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




function importa_palm(palm, pasta) {


    //Cria objeto para manipulacao de arquivos no cliente.
    var fso = new ActiveXObject("Scripting.FileSystemObject");

    if (fso.FileExists("Z:\\exprec.txt")) {
        fso.DeleteFile("Z:\\exprec.txt");
    }


    //Verifica a nao existencia do arquivo responsavel pela impressao na impressora bematech.
    if (!(fso.FileExists("c:\\temp\\r" + palm + ".bat"))) {
        //Cria o arquivo imprime.bat, escreve o comando responsavel pela impressao e fecha o arquivo.
        var b = fso.CreateTextFile("c:\\temp\\r" + palm + ".bat", true);
        b.WriteLine('copy "C:\\ARQUIVOS DE PROGRAMAS\\PALM\\' + pasta + '\\BACKUP\\Rece_TLocation.pdb" "C:\\TEMP\\Rece_TLocation.pdb"');
        b.WriteLine('copy "C:\\ARQUIVOS DE PROGRAMAS\\PALM\\' + pasta + '\\BACKUP\\Rece_TItem.pdb" "C:\\TEMP\\Rece_TItem.pdb"');
        b.WriteLine("C:\\TEMP\\RECEBEB.EXE");
        b.WriteLine("copy C:\\TEMP\\exprec.txt Z:\\");
        b.Close();
    } //if

    //Cria um objeto para execucao de um programa no computador do cliente.
    var WshShell = new ActiveXObject("WScript.Shell");
    //Executa o arquivo responsavel pela impressao do arquivo imprime.prn.

    var oExec = WshShell.Exec("c:\\temp\\r" + palm + ".bat");

    //Vou chamar uma Funcao que vai chamar o form pelo ajax e vai retornar uma variavel com os pedidos

    importaexpedicao(1);

    //alert(palm+pasta);


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

        ajax2.open("POST", "pedcomprabaixaimp.php", true);
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
            var pedido = item.getElementsByTagName("pedido")[0].firstChild.nodeValue;
            var produto = item.getElementsByTagName("produto")[0].firstChild.nodeValue;
            var quantidade = item.getElementsByTagName("quantidade")[0].firstChild.nodeValue;

            var tipo = item.getElementsByTagName("tipo")[0].firstChild.nodeValue;

            var propemb = item.getElementsByTagName("propemb")[0].firstChild.nodeValue;
            var barcaixa = item.getElementsByTagName("barcaixa")[0].firstChild.nodeValue;


            trimjs(pedido);
            pedido = txt;
            trimjs(produto);
            produto = txt;
            trimjs(quantidade);
            quantidade = txt;

            trimjs(tipo);
            tipo = txt;

            trimjs(propemb);
            propemb = txt;
            trimjs(barcaixa);
            barcaixa = txt;


            quantidade = Math.round(quantidade);

            if (pedido == $("pcnumero").value) {

                if (tipo == '1') {

                    if (quantidade != 0) {


                        for (var k = 0; k < 700; k++) {
                            if (vet[k][0] == produto) {

                                vet[k][1] = quantidade;

                                $(vet[k][0]).value = quantidade;
                                vet[k][9] = 1;
                                document.getElementById('chk' + vet[k][0]).checked = true;

                                propemb = Math.round(propemb);
                                vet[k][14] = propemb;
                                $('proemb' + vet[k][0]).value = propemb;

                                vet[k][15] = barcaixa;
                                $('barcaixa' + vet[k][0]).value = barcaixa;



                            }

                        }
                    }

                }


            }


        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo
    }




}



function itemcombo(valor) {

    y = document.forms[0].deposito.options.length;

    for (var i = 0; i < y; i++) {

        document.forms[0].deposito.options[i].selected = true;
        var l = document.forms[0].deposito;
        //var li = l.options[l.selectedIndex].text;
        var li = l.options[l.selectedIndex].value;
        if (li == valor) {
            i = y;
        }

    }
}







function dadospesquisafiscal(valor) {
    //verifica se o browser tem suporte a ajax

    // alert(valor2);

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

        document.forms[0].listfiscais.options.length = 0;

        idOpcao = document.getElementById("opcoes11");

        ajax2.open("POST", "produtopesquisafiscal.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                //idOpcao.innerHTML = "Carregando...!";   
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



function processXMLfiscal(obj) {
    //pega a tag dado

    i2 = 0;

    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados

        document.forms[0].listfiscais.options.length = 0;

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
            novo.setAttribute("id", "opcoes11");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto
            novo.text = descricao;
            //finalmente adiciona o novo elemento
            document.forms[0].listfiscais.options.add(novo);

        }


    } else {
        //caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "____________________";

    }

    ver2();

}

function itemcombofiscal(valor) {

    y = document.forms[0].listfiscais.options.length;

    for (var i = 0; i < y; i++) {

        document.forms[0].listfiscais.options[i].selected = true;
        var l = document.forms[0].listfiscais;
        //var li = l.options[l.selectedIndex].text;
        var li = l.options[l.selectedIndex].value;
        if (li == valor) {
            i = y;
        }

    }
}



function prereceb() {

    pcnumero = $("pcnumero").value;

    new ajax('pedcomprabaixapesquisapre.php?pcnumero=' + pcnumero, {onLoading: carregando, onComplete: imprimex});
}


function imprimex(request) {


    $("msg").style.visibility = "hidden";
    var xmldoc = request.responseXML;

    if (xmldoc == null) {
        alert('Pré-Recebimento não Cadastrado!')
    }

    var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];
    if (cabecalho != null)
    {
        prereceb1();
    } else
    {
        alert('Pré-Recebimento não Cadastrado!')
    }


}



function prereceb1() {

    pcnumero = $("pcnumero").value;

    new ajax('pedcomprabaixapesquisapre1.php?pcnumero=' + pcnumero, {onLoading: carregando, onComplete: imprime1});
}


function imprime1(request) {

    $("resultado").innerHTML = '';

    $("msg").style.visibility = "hidden";
    var xmldoc = request.responseXML;

    if (xmldoc == null) {
        prereceb2();
    }

    var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];
    if (cabecalho != null)
    {


        var tabela = "<table width='715' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' ><tr>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Codigo</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Ref. Forn.</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Produto</b></td>";

        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Embalagem</b></td>"

        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Emb. Pre-Receb.</b></td>"

        //corpo da tabela

        var cod = 0;
        var registros = xmldoc.getElementsByTagName('registro');
        for (i = 0; i < registros.length; i++) {
            var itens = registros[i].getElementsByTagName('item');


            tabela += "<tr id=linha" + i + ">"
            for (j = 0; j < itens.length; j++) {
                if (itens[j].firstChild == null)
                    tabela += "<td class='borda'>" + 0 + "</td>";
                else
                    tabela += "<td class='borda'>" + itens[j].firstChild.data + "</td>";
            }



            tabela += "</tr>";

        }


        tabela += "<tr>";
        tabela += "<td colspan='5'><Center><input name='button4' type='button' id='button4' onClick='prereceb2()' value='CONFIRMA'>";
        tabela += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        tabela += "<input name='button5' type='button' id='button5' onClick='limpar()' value='CANCELA'>";
        tabela += "</Center></td>";
        tabela += "</tr>";

        tabela += "</table>";




        $("resultado").innerHTML = tabela;

        tabela = null;


    } else
    {
        $("resultado").innerHTML = '';
        prereceb2();
    }


}



function prereceb2() {

    pcnumero = $("pcnumero").value;

    new ajax('pedcomprabaixapesquisapre2.php?pcnumero=' + pcnumero, {onLoading: carregando, onComplete: imprime2});
}


function imprime2(request) {

    $("resultado").innerHTML = '';

    $("msg").style.visibility = "hidden";
    var xmldoc = request.responseXML;

    if (xmldoc == null) {
        prereceb3();
    }

    var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];
    if (cabecalho != null)
    {


        var tabela = "<table width='715' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' ><tr>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Codigo</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Ref. Forn.</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Produto</b></td>";

        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Cod Barras Caixa</b></td>"

        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Cod Barras Cx. Pre-Receb.</b></td>"

        //corpo da tabela

        var cod = 0;
        var registros = xmldoc.getElementsByTagName('registro');
        for (i = 0; i < registros.length; i++) {
            var itens = registros[i].getElementsByTagName('item');


            tabela += "<tr id=linha" + i + ">"
            for (j = 0; j < itens.length; j++) {
                if (itens[j].firstChild == null)
                    tabela += "<td class='borda'>" + 0 + "</td>";
                else
                    tabela += "<td class='borda'>" + itens[j].firstChild.data + "</td>";
            }



            tabela += "</tr>";

        }


        tabela += "<tr>";
        tabela += "<td colspan='5'><Center><input name='button4' type='button' id='button4' onClick='prereceb3()' value='CONFIRMA'>";
        tabela += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        tabela += "<input name='button5' type='button' id='button5' onClick='limpar()' value='CANCELA'>";
        tabela += "</Center></td>";
        tabela += "</tr>";

        tabela += "</table>";




        $("resultado").innerHTML = tabela;

        tabela = null;


    } else
    {
        $("resultado").innerHTML = '';
        prereceb3();
    }


}


function prereceb3() {

    pcnumero = $("pcnumero").value;

    new ajax('pedcomprabaixapesquisapre3.php?pcnumero=' + pcnumero, {onLoading: carregando, onComplete: imprime3});
}


function imprime3(request) {

    $("resultado").innerHTML = '';

    $("msg").style.visibility = "hidden";
    var xmldoc = request.responseXML;

    if (xmldoc == null) {
        prereceb4();
    }

    var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];
    if (cabecalho != null)
    {


        var tabela = "<table width='715' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' ><tr>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Codigo</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Ref. Forn.</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Produto</b></td>";

        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Cod Barras Peça</b></td>"

        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Cod Barras Peça Pre-Receb.</b></td>"

        //corpo da tabela

        var cod = 0;
        var registros = xmldoc.getElementsByTagName('registro');
        for (i = 0; i < registros.length; i++) {
            var itens = registros[i].getElementsByTagName('item');


            tabela += "<tr id=linha" + i + ">"
            for (j = 0; j < itens.length; j++) {
                if (itens[j].firstChild == null)
                    tabela += "<td class='borda'>" + 0 + "</td>";
                else
                    tabela += "<td class='borda'>" + itens[j].firstChild.data + "</td>";
            }



            tabela += "</tr>";

        }


        tabela += "<tr>";
        tabela += "<td colspan='5'><Center><input name='button4' type='button' id='button4' onClick='prereceb4()' value='CONFIRMA'>";
        tabela += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        tabela += "<input name='button5' type='button' id='button5' onClick='limpar()' value='CANCELA'>";
        tabela += "</Center></td>";
        tabela += "</tr>";

        tabela += "</table>";




        $("resultado").innerHTML = tabela;

        tabela = null;


    } else
    {
        $("resultado").innerHTML = '';
        prereceb4();
    }


}



function prereceb4() {

    pcnumero = $("pcnumero").value;

    new ajax('pedcomprabaixapesquisapre4.php?pcnumero=' + pcnumero, {onLoading: carregando, onComplete: imprime4});
}


function imprime4(request) {

    $("resultado").innerHTML = '';

    $("msg").style.visibility = "hidden";
    var xmldoc = request.responseXML;

    if (xmldoc == null) {
        prereceb5();
    }

    var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];
    if (cabecalho != null)
    {


        var tabela = "<table width='715' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' ><tr>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Codigo</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Ref. Forn.</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Produto</b></td>";

        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Altura</b></td>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Largura</b></td>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Comprimento</b></td>"

        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Altura</b></td>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Largura</b></td>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Comprimento</b></td>"

        //corpo da tabela

        var cod = 0;
        var registros = xmldoc.getElementsByTagName('registro');
        for (i = 0; i < registros.length; i++) {
            var itens = registros[i].getElementsByTagName('item');


            tabela += "<tr id=linha" + i + ">"
            for (j = 0; j < itens.length; j++) {
                if (itens[j].firstChild == null)
                    tabela += "<td class='borda'>" + 0 + "</td>";
                else
                    tabela += "<td class='borda'>" + itens[j].firstChild.data + "</td>";
            }



            tabela += "</tr>";

        }


        tabela += "<tr>";
        tabela += "<td colspan='9'><Center><input name='button4' type='button' id='button4' onClick='prereceb5()' value='CONFIRMA'>";
        tabela += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        tabela += "<input name='button5' type='button' id='button5' onClick='limpar()' value='CANCELA'>";
        tabela += "</Center></td>";
        tabela += "</tr>";

        tabela += "</table>";




        $("resultado").innerHTML = tabela;

        tabela = null;


    } else
    {
        $("resultado").innerHTML = '';
        prereceb5();
    }


}


function prereceb5() {

    pcnumero = $("pcnumero").value;

    new ajax('pedcomprabaixapesquisapedido2.php?pcnumero=' + pcnumero, {onLoading: carregando, onComplete: imprime6});
}


function imprime6(request) {



    $("msg").style.visibility = "hidden";
    var xmldoc = request.responseXML;
    var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];
    if (cabecalho != null)
    {


        var tabela = "<table width='715' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' ><tr>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Codigo</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Ref. Forn.</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Produto</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>QTD</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Valor</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Baixa</b></td>"

        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Valor NF</b></td>"

        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>ICM</b></td>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>IPI</b></td>"

        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>IVA</b></td>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>ST</b></td>"

        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Altura</b></td>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Largura</b></td>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Compr.</b></td>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Peso</b></td>"

        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Emb.</b></td>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Cod. Barras</b></td>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Cod. Bar. Caixa</b></td>"

        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Cl. Fiscal</b></td>"

        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><center><b>.</b></center></td>"

        //corpo da tabela

        var cod = 0;
        var registros = xmldoc.getElementsByTagName('registro');
        for (i = 0; i < registros.length; i++) {
            var itens = registros[i].getElementsByTagName('item');

            var saldo = itens[2].firstChild.data - itens[5].firstChild.data;
            if (saldo != 0) {

                tabela += "<tr id=linha" + i + ">"
                for (j = 0; j < itens.length; j++) {
                    if (itens[j].firstChild == null)
                        tabela += "<td class='borda'>" + 0 + "</td>";
                    else

                    if (j == 3) {
                        var saldo = itens[j].firstChild.data - itens[6].firstChild.data;
                        tabela += "<td class='borda' align='right'>&nbsp;" + saldo + "&nbsp;</td>";
                        vet[i][3] = saldo;
                        vet[i][4] = itens[6].firstChild.data;
                    } else if (j == 4) {

                        var liq = itens[j].firstChild.data
                        var desc1 = itens[7].firstChild.data
                        var desc2 = itens[8].firstChild.data
                        var desc3 = itens[9].firstChild.data
                        var desc4 = itens[10].firstChild.data
                        var ipi = itens[11].firstChild.data
                        var d1 = 0;
                        var d2 = 0;
                        var d3 = 0;
                        var d4 = 0;

                        if (desc1 != 0) {
                            d1 = liq / 100 * desc1;
                        } else {
                            d1 = 0;
                        }
                        liq = liq - d1;
                        if (desc2 != 0) {
                            d2 = liq / 100 * desc2;
                        } else {
                            d2 = 0;
                        }
                        liq = liq - d2;
                        if (desc3 != 0) {
                            d3 = liq / 100 * desc3;
                        } else {
                            d3 = 0;
                        }
                        liq = liq - d3;
                        if (desc4 != 0) {
                            d4 = liq / 100 * desc4;
                        } else {
                            d4 = 0;
                        }
                        liq = liq - d4;
                        var vipi = 0;

                        if (ipi != 0) {
                            vipi = liq / 100 * ipi;
                        }
                        var val = liq + vipi;

                        val = (Math.round(val * 100)) / 100;

                        vet[i][8] = val;

                        val = (val.format(2, ",", "."));

                        tabela += "<td class='borda' align='right'>&nbsp;" + val + "&nbsp;</td>";
                    } else if (j == 5) {

                        cod = itens[j].firstChild.data;

                        vet[i][0] = cod;

                        vet[i][2] = itens[6].firstChild.data;



                        if (itens[30].firstChild.data != 'X') {
                            vet[i][1] = itens[30].firstChild.data;
                            tabela += "<td class='borda' style='cursor: pointer'><input type='text' id='" + cod + "' name='" + cod + "' value='" + itens[30].firstChild.data + "' size='4' onBlur='convertField3(this);editar(" + cod + ",this.value," + itens[6].firstChild.data + ");'></td>";
                        } else {
                            vet[i][1] = saldo;
                            tabela += "<td class='borda' style='cursor: pointer'><input type='text' id='" + cod + "' name='" + cod + "' value='" + saldo + "' size='4' onBlur='convertField3(this);editar(" + cod + ",this.value," + itens[6].firstChild.data + ");'></td>";
                        }



                        val = vet[i][8];

                        vet[i][20] = val;

                        val = (val.format(2, ".", ","));
                        tabela += "<td class='borda' style='cursor: pointer'><input type='text' id='" + cod + "' name='" + cod + "' value='" + val + "' size='4' onBlur='convertField3(this);editarvalnf(" + cod + ",this.value);'></td>";


                        if (document.getElementById("radioperc2").checked == true) {
                            tabela += "<td class='borda'><input type='text' id='icm" + cod + "' name='icm" + cod + "' value='0' size='5' onBlur='convertField3(this);editaricm(" + cod + ",this.value);'></td>";
                            tabela += "<td class='borda'><input type='text' id='ipi" + cod + "' name='ipi" + cod + "' value='0' size='5' onBlur='convertField3(this);editaripi(" + cod + ",this.value);'></td>";
                        } else
                        {
                            tabela += "<td class='borda'><input type='text' id='icm" + cod + "' name='icm" + cod + "' value='0' size='5' onBlur='convertField3(this);editaricm(" + cod + ",this.value);' disabled ></td>";
                            tabela += "<td class='borda'><input type='text' id='ipi" + cod + "' name='ipi" + cod + "' value='0' size='5' onBlur='convertField3(this);editaripi(" + cod + ",this.value);' disabled ></td>";
                        }


                        var iva = itens[21].firstChild.data;
                        var st = itens[22].firstChild.data;

                        vet[i][18] = iva;
                        vet[i][19] = st;

                        if (document.getElementById("radiost1").checked == true) {
                            tabela += "<td class='borda'><input type='text' id='iva" + cod + "' name='iva" + cod + "' value='" + iva + "' size='5' onBlur='convertField3(this);editariva(" + cod + ",this.value);'  ></td>";
                            tabela += "<td class='borda'><input type='text' id='st" + cod + "' name='st" + cod + "' value='" + st + "' size='5' onBlur='convertField04(this);editarst(" + cod + ",this.value);'  ></td>";
                        } else
                        {
                            tabela += "<td class='borda'><input type='text' id='iva" + cod + "' name='iva" + cod + "' value='" + iva + "' size='5' onBlur='convertField3(this);editariva(" + cod + ",this.value);' disabled ></td>";
                            tabela += "<td class='borda'><input type='text' id='st" + cod + "' name='st" + cod + "' value='" + st + "' size='5' onBlur='convertField04(this);editarst(" + cod + ",this.value);' disabled ></td>";
                        }


                    } else if (j == 0) {
                        tabela += "<td class='borda'>" + itens[j].firstChild.data + "</td>";

                        vet[i][5] = itens[j].firstChild.data;

                    } else if (j == 1) {
                        tabela += "<td class='borda'>" + itens[j].firstChild.data + "</td>";
                    } else if (j == 2) {
                        tabela += "<td class='borda'>" + itens[j].firstChild.data + "</td>";
                    } else if (j == 12) {

                        if (itens[21].firstChild.data == 'X') {
                            vet[i][10] = itens[j].firstChild.data;
                            tabela += "<td class='borda'><input type='text' id='proaltcx" + cod + "' name='proaltcx" + cod + "' value='" + itens[j].firstChild.data + "' size='5' onBlur='convertField3(this);editar1(" + cod + ",this.value,10);' ></td>";
                        } else {
                            vet[i][10] = itens[21].firstChild.data;
                            tabela += "<td class='borda'><input type='text' id='proaltcx" + cod + "' name='proaltcx" + cod + "' value='" + itens[21].firstChild.data + "' size='5' onBlur='convertField3(this);editar1(" + cod + ",this.value,10);' ></td>";
                        }
                    } else if (j == 13) {
                        if (itens[22].firstChild.data == 'X') {
                            vet[i][11] = itens[j].firstChild.data;
                            tabela += "<td class='borda'><input type='text' id='prolarcx" + cod + "' name='prolarcx" + cod + "' value='" + itens[j].firstChild.data + "' size='5' onBlur='convertField3(this);editar1(" + cod + ",this.value,11);' ></td>";
                        } else {
                            vet[i][11] = itens[22].firstChild.data;
                            tabela += "<td class='borda'><input type='text' id='prolarcx" + cod + "' name='prolarcx" + cod + "' value='" + itens[22].firstChild.data + "' size='5' onBlur='convertField3(this);editar1(" + cod + ",this.value,11);' ></td>";
                        }

                    } else if (j == 14) {
                        if (itens[23].firstChild.data == 'X') {
                            vet[i][12] = itens[j].firstChild.data;
                            tabela += "<td class='borda'><input type='text' id='procomcx" + cod + "' name='procomcx" + cod + "' value='" + itens[j].firstChild.data + "' size='5' onBlur='convertField3(this);editar1(" + cod + ",this.value,12);' ></td>";
                        } else {
                            vet[i][12] = itens[23].firstChild.data;
                            tabela += "<td class='borda'><input type='text' id='procomcx" + cod + "' name='procomcx" + cod + "' value='" + itens[23].firstChild.data + "' size='5' onBlur='convertField3(this);editar1(" + cod + ",this.value,12);' ></td>";
                        }
                    } else if (j == 15) {
                        if (itens[24].firstChild.data == 'X') {
                            vet[i][13] = itens[j].firstChild.data;
                            tabela += "<td class='borda'><input type='text' id='propescx" + cod + "' name='propescx" + cod + "' value='" + itens[j].firstChild.data + "' size='5' onBlur='convertField3(this);editar1(" + cod + ",this.value,13);' ></td>";
                        } else {
                            vet[i][13] = itens[24].firstChild.data;
                            tabela += "<td class='borda'><input type='text' id='propescx" + cod + "' name='propescx" + cod + "' value='" + itens[24].firstChild.data + "' size='5' onBlur='convertField3(this);editar1(" + cod + ",this.value,13);' ></td>";
                        }
                    } else if (j == 16) {
                        if (itens[25].firstChild.data == 'X') {
                            vet[i][14] = itens[j].firstChild.data;
                            tabela += "<td class='borda'><input type='text' id='proemb" + cod + "' name='proemb" + cod + "' value='" + itens[j].firstChild.data + "' size='5' onBlur='convertField3(this);editar1(" + cod + ",this.value,14);' ></td>";
                        } else {
                            vet[i][14] = itens[25].firstChild.data;
                            tabela += "<td class='borda'><input type='text' id='proemb" + cod + "' name='proemb" + cod + "' value='" + itens[25].firstChild.data + "' size='5' onBlur='convertField3(this);editar1(" + cod + ",this.value,14);' ></td>";
                        }
                    } else if (j == 17) {
                        if (itens[29].firstChild.data == 'X') {
                            vet[i][17] = itens[20].firstChild.data;
                            tabela += "<td class='borda'><input type='text' id='barunidade" + cod + "' name='barunidade" + cod + "'value='" + itens[20].firstChild.data + "' size='14' onBlur='convertField3(this);editar1(" + cod + ",this.value,17);' ></td>";
                        } else {
                            vet[i][17] = itens[29].firstChild.data;
                            tabela += "<td class='borda'><input type='text' id='barunidade" + cod + "' name='barunidade" + cod + "'value='" + itens[29].firstChild.data + "' size='14' onBlur='convertField3(this);editar1(" + cod + ",this.value,17);' ></td>";
                        }

                        if (itens[26].firstChild.data == 'X') {
                            vet[i][15] = itens[j].firstChild.data;
                            tabela += "<td class='borda'><input type='text' id='barcaixa" + cod + "' name='barcaixa" + cod + "'value='" + itens[j].firstChild.data + "' size='14' onBlur='convertField3(this);editar1(" + cod + ",this.value,15);' ></td>";
                        } else {
                            vet[i][15] = itens[26].firstChild.data;
                            tabela += "<td class='borda'><input type='text' id='barcaixa" + cod + "' name='barcaixa" + cod + "'value='" + itens[26].firstChild.data + "' size='14' onBlur='convertField3(this);editar1(" + cod + ",this.value,15);' ></td>";
                        }

                    } else if (j == 18) {
                        if (itens[27].firstChild.data == 'X') {
                            vet[i][16] = itens[19].firstChild.data;
                            tabela += "<td class='borda' ><input type='text' id='cf" + cod + "' name='cf" + cod + " 'value='" + itens[j].firstChild.data + "' size='7'  style='cursor: pointer' readonly onClick=alteracf(" + cod + ") ></td>";
                        } else {
                            vet[i][16] = itens[28].firstChild.data;
                            tabela += "<td class='borda' ><input type='text' id='cf" + cod + "' name='cf" + cod + " 'value='" + itens[27].firstChild.data + "' size='7'  style='cursor: pointer' readonly onClick=alteracf(" + cod + ") ></td>";
                        }

                        if (itens[30].firstChild.data == '1') {
                            cod = itens[5].firstChild.data;
                            tabela += "<td class='borda'><input type='checkbox' id='chk" + cod + "' name='chk" + cod + "' onClick=editarbaixa(" + cod + "); checked=true> </td>";
                            vet[i][9] = 1;
                        } else {
                            cod = itens[5].firstChild.data;
                            tabela += "<td class='borda'><input type='checkbox' id='chk" + cod + "' name='chk" + cod + "' onClick=editarbaixa(" + cod + "); > </td>";
                            vet[i][9] = 0;
                        }

                    }

                }



                tabela += "</tr>";
            }
        }

        tabela += "</table>"


        tabela += "</tr>"

        $("resultado").innerHTML = tabela;
        //$("resultado2").innerHTML=tabela2;
        tabela = null;
    } else
    {
        $("resultado").innerHTML = "Nenhum registro encontrado...";
    }


    //alert(pos);

    if (pos == 1) {


        $("data").value = "";
        $("datanota").value = "";
        $("nota").value = "";
        $("cfop").value = 0;
        $("produtos").value = 0;
        $("icm").value = 0;
        $("baseicm").value = 0;
        $("valoricm").value = 0;
        $("isentas").value = 0;
        $("outras").value = 0;
        $("baseipi").value = 0;
        $("percipi").value = 0;
        $("valoripi").value = 0;
        $("totalnota").value = 0;
        $("observacoes").value = "";

        $("localiza").value = "";

        $("outrasipi").value = 0;

        $("cfop2").value = "";
        $("basesubst").value = 0;
        $("valorsubst").value = 0;
        $("perciva").value = 0;

        document.getElementById("radiost2").checked = true;


        document.forms[0].pcnumero.focus();
        pos = 0;
    }

    if (xpdf == 1)
    {
        imppdf();
    }



}

function limpar() {

    $("pcnumero").value = "";
    $("codigo").value = "";
    $("fornguerra").value = "";
    $("codigo2").value = "";
    $("comprador").value = "";

    $("data").value = "";
    $("datanota").value = "";
    $("nota").value = "";
    $("cfop").value = 0;
    $("produtos").value = 0;
    $("icm").value = 0;
    $("baseicm").value = 0;
    $("valoricm").value = 0;
    $("isentas").value = 0;
    $("outras").value = 0;
    $("baseipi").value = 0;
    $("percipi").value = 0;
    $("valoripi").value = 0;
    $("totalnota").value = 0;
    $("observacoes").value = "";

    $("localiza").value = "";

    $("outrasipi").value = 0;

    $("cfop2").value = "";
    $("basesubst").value = 0;
    $("valorsubst").value = 0;
    $("perciva").value = 0;

    document.getElementById("radiowms1").checked = true;
    document.getElementById('linhasenha').style.display = "none";
    $("adm").value = '';

    document.getElementById("radiost2").checked = true;

    document.forms[0].pcnumero.focus();

    $("resultado").innerHTML = '';
}


function verificast1() {
    $("cfop2").disabled = false;
    $("basesubst").disabled = false;
    $("valorsubst").disabled = false;
    $("perciva").disabled = false;

    for (var k = 0; k < 700; k++) {
        if (vet[k][0] != 0) {
            $("st" + vet[k][0]).value = 'S';
            $("iva" + vet[k][0]).disabled = false;
            $("st" + vet[k][0]).disabled = false;
            vet[k][19] = 'S';
        }
    }

}

function verificast2() {
    $("cfop2").value = 0;
    $("basesubst").value = 0;
    $("valorsubst").value = 0;
    $("perciva").value = 0;
    $("cfop2").disabled = true;
    $("basesubst").disabled = true;
    $("valorsubst").disabled = true;
    $("perciva").disabled = true;

    for (var k = 0; k < 700; k++) {
        if (vet[k][0] != 0) {
            $("iva" + vet[k][0]).value = 0;
            $("st" + vet[k][0]).value = 'N';
            $("iva" + vet[k][0]).disabled = true;
            $("st" + vet[k][0]).disabled = true;
            vet[k][19] = 'N';
        }
    }

}


function convertField04(field) {

    var texto = field.value;
    if (texto == 'S') {
        saida = 'S';
    } else if (texto == 's') {
        saida = 'S';
    } else
    {
        saida = 'N';
    }

    field.value = saida;

}



function alteraiva(valor) {

    for (var k = 0; k < 700; k++) {
        if (vet[k][0] != 0) {
            $("iva" + vet[k][0]).value = valor;
            vet[k][18] = valor;
        }
    }
}


function nfe() {

    pcnumero = $("pcnumero").value;
    nota = $("nota").value;
    serie = $("serie").value;

    if (pcnumero == '')
    {
        alert("Informe o Pedido!");
        document.forms[0].pcnumero.focus();
    } else if (nota == '')
    {
        alert("Informe a Nota!");
        document.forms[0].nota.focus();
    } else if (serie == '')
    {
        alert("Informe a Série!");
        document.forms[0].serie.focus();
    } else {
        vernfe(pcnumero, nota, serie);
    }

}



function vernfe(pcnumero, nota, serie) {

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

        ajax2.open("POST", "pedcomprabaixapesquisanfe.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {

            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {

            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLNFe(ajax2.responseXML, pcnumero);
                } else {
                    ///MOZILA
                    if ($("pcnumero").value != '')
                    {
                        alert("NFe não encontrada!");
                    }

                    $("datanota").value = '';
                    $("cfop").value = '';
                    $("produtos").value = '';
                    $("icm").value = '';
                    $("baseicm").value = '';
                    $("valoricm").value = '';
                    $("isentas").value = '';
                    $("outras").value = '';
                    $("baseipi").value = '';
                    $("percipi").value = '';
                    $("valoripi").value = '';
                    $("totalnota").value = '';
                    $("observacoes").value = '';
                    $("volumes").value = '';
                    $("outrasipi").value = '';
                    $("cfop2").value == "";
                    $("basesubst").value == "";
                    $("valorsubst").value == "";
                    $("perciva").value == "";

                    //tabela=null;
                    //$("resultado").innerHTML=tabela;

                }
            }
        }

        //passa o parametro
        var params = "parametro=" + pcnumero + '&parametro2=' + nota + '&parametro3=' + serie;
        ajax2.send(params);

    }

}


function processXMLNFe(obj, pcnumero) {

    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados


        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML


            var notentemissao = item.getElementsByTagName("notentemissao")[0].firstChild.nodeValue;
            var notentvalor = item.getElementsByTagName("notentvalor")[0].firstChild.nodeValue;
            var notentprodutos = item.getElementsByTagName("notentprodutos")[0].firstChild.nodeValue;
            var notentbaseicm = item.getElementsByTagName("notentbaseicm")[0].firstChild.nodeValue;
            var notentvaloricm = item.getElementsByTagName("notentvaloricm")[0].firstChild.nodeValue;
            var notentvaloripi = item.getElementsByTagName("notentvaloripi")[0].firstChild.nodeValue;
            var notentobservacoes = item.getElementsByTagName("notentobservacoes")[0].firstChild.nodeValue;
            var notentvolumes = item.getElementsByTagName("notentvolumes")[0].firstChild.nodeValue;
            var notbasesubst = item.getElementsByTagName("notbasesubst")[0].firstChild.nodeValue;
            var notvalorsubst = item.getElementsByTagName("notvalorsubst")[0].firstChild.nodeValue;
            var nfecodigo = item.getElementsByTagName("nfecodigo")[0].firstChild.nodeValue;

            trimjs(notentemissao);
            if (txt == '0') {
                txt = '';
            }
            ;
            notentemissao = txt;

            trimjs(notentvalor);
            if (txt == '0') {
                txt = '';
            }
            ;
            notentvalor = txt;
            trimjs(notentprodutos);
            if (txt == '0') {
                txt = '';
            }
            ;
            notentprodutos = txt;

            trimjs(notentbaseicm);
            if (txt == '0') {
                txt = '';
            }
            ;
            notentbaseicm = txt;
            trimjs(notentvaloricm);
            if (txt == '0') {
                txt = '';
            }
            ;
            notentvaloricm = txt;

            trimjs(notentvaloripi);
            if (txt == '0') {
                txt = '';
            }
            ;
            notentvaloripi = txt;
            trimjs(notentobservacoes);
            if (txt == '0') {
                txt = '';
            }
            ;
            notentobservacoes = txt;

            trimjs(notentvolumes);
            if (txt == '0') {
                txt = '';
            }
            ;
            notentvolumes = txt;

            trimjs(notbasesubst);
            if (txt == '0') {
                txt = '';
            }
            ;
            notbasesubst = txt;
            trimjs(notvalorsubst);
            if (txt == '0') {
                txt = '';
            }
            ;
            notvalorsubst = txt;

            trimjs(nfecodigo);
            if (txt == '0') {
                txt = '';
            }
            ;
            nfecodigo = txt;


            $("datanota").value = notentemissao;
            $("produtos").value = notentprodutos;
            $("icm").value = 0;
            $("baseicm").value = notentbaseicm;
            $("valoricm").value = notentvaloricm;
            $("isentas").value = 0;
            $("outras").value = 0;
            $("baseipi").value = 0;
            $("percipi").value = 0;
            $("valoripi").value = notentvaloripi;
            $("totalnota").value = notentvalor;
            $("observacoes").value = "";

            $("volumes").value = notentvolumes;
            $("outrasipi").value = 0;


            if (notbasesubst == '' || notbasesubst == '0') {
                document.getElementById("radiost2").checked = true;
                $("cfop2").value = '';
                $("basesubst").value = '';
                $("valorsubst").value = '';
                $("perciva").value = '';
                $("cfop2").disabled = true;
                $("basesubst").disabled = true;
                $("valorsubst").disabled = true;
                $("perciva").disabled = true;
            } else
            {
                document.getElementById("radiost1").checked = true;
                //$("cfop2").value=notcfopsubs;
                $("basesubst").value = notbasesubst;
                $("valorsubst").value = notvalorsubst;
                //$("perciva").value=notperciva;		
                $("perciva").value = 0;
                $("cfop2").disabled = false;
                $("basesubst").disabled = false;
                $("valorsubst").disabled = false;
                $("perciva").disabled = false;
            }

            //Troca a opção de IPI / ICMS por itens 		
            document.getElementById("radioperc2").checked = true;


            //Processa os itens
            //Zera o vetor 
            for (var i = 0; i < 700; i++) {
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
            }

            let titulo = "PROCESSANDO, AGUARDE...";
            let mensagem = "EXECUTANDO PESQUISA DE ITENS DA NF-E!";

            $a("#retorno").messageBoxModal(titulo, mensagem);

            new ajax('pedcomprabaixapesquisanfeitens.php?pcnumero=' + pcnumero + '&nota=' + nfecodigo, {onLoading: carregando, onComplete: imprimenfe});


        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo
        if ($("pcnumero").value != '')
        {
            alert("NFe não encontrada!");
            document.forms[0].pcnumero.focus();
        }


        $("datanota").value = '';
        $("cfop").value = '';
        $("produtos").value = '';
        $("icm").value = '';
        $("baseicm").value = '';
        $("valoricm").value = '';
        $("isentas").value = '';
        $("outras").value = '';
        $("baseipi").value = '';
        $("percipi").value = '';
        $("valoripi").value = '';
        $("totalnota").value = '';
        $("observacoes").value = '';
        $("volumes").value = '';
        $("outrasipi").value = '';
        $("cfop2").value == "";
        $("basesubst").value == "";
        $("valorsubst").value == "";
        $("perciva").value == "";

    }

    //load_grid($("notentcodigo").value);

}

function imprimenfe(request) {

    $("resultado").innerHTML = "";

    $("msg").style.visibility = "hidden";
    var xmldoc = request.responseXML;
    var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];
    if (cabecalho != null)
    {

        let tabela = "<div class='limiter'>"
        tabela += "<div class='container-table100'>"
        tabela += "<div class='wrap-table150'>"
        tabela += "<div class='table-max'>"
        tabela += "<div class='row-max header'>"
        tabela += "<div class='cell-max'>Codigo</div>"
        tabela += "<div class='cell-max'>Referencia</div>"
        tabela += "<div class='cell-max'>Produto</div>"
        tabela += "<div class='cell-max'>Qtd</div>"
        tabela += "<div class='cell-max'>Preço</div>"
        tabela += "<div class='cell-max'>Baixar</div>"
        tabela += "<div class='cell-max'>Valor</div>"
        tabela += "<div class='cell-max'>ICMS</div>"
        tabela += "<div class='cell-max'>IPI</div>"
        tabela += "<div class='cell-max'>IVA</div>"
        tabela += "<div class='cell-max'>ST</div>"
        tabela += "<div class='cell-max'>Emb</div>"
        tabela += "<div class='cell-max'>EAN</div>"
        tabela += "<div class='cell-max'>DUN</div>"
        tabela += "<div class='cell-max'>Fiscal</div>"
        tabela += "<div class='cell-max'>Baixa</div>"
        tabela += "</div>";

        //corpo da tabela
        var cfop = '';
        var cfopst = '';
        var picms = 0;
        var piva = 0;
        var bipi = 0;
        var pipi = 0;
        var cod = 0;

        var naoitens = '';

        var registros = xmldoc.getElementsByTagName('registro');
        for (i = 0; i < registros.length; i++) {
            var itens = registros[i].getElementsByTagName('item');

            var existe = itens[5].firstChild.data;

            if (existe != 0) {

                var saldo = itens[3].firstChild.data - itens[6].firstChild.data;
                if (saldo != 0) {

                    tabela += "<div class='row-max'>"
                    for (j = 0; j < itens.length; j++) {

                        if (j < 21) {

                            if (itens[j].firstChild == null) {
                                tabela += "<div class='cell-max'>" + 0 + "</div>"
                            } else {

                                if (j == 0) {
                                    tabela += "<div class='cell-max' data-title='Codigo'>" + itens[j].firstChild.data + "</div>";
                                    vet[i][5] = itens[j].firstChild.data;
                                } else if (j == 1) {
                                    tabela += "<div class='cell-max' data-title='Referencia'>" + itens[j].firstChild.data + "</div>";
                                } else if (j == 2) {
                                    tabela += "<div class='cell-max' data-title='Produto'>" + itens[j].firstChild.data + "</div>";
                                } else if (j == 3) {
                                    var saldo = itens[j].firstChild.data - itens[6].firstChild.data;
                                    tabela += "<div class='cell-max' data-title='Qtd'>" + saldo + "</div>";
                                    vet[i][3] = saldo;
                                    vet[i][4] = itens[6].firstChild.data;
                                } else if (j == 4) {

                                    var liq = itens[j].firstChild.data
                                    var desc1 = itens[7].firstChild.data
                                    var desc2 = itens[8].firstChild.data
                                    var desc3 = itens[9].firstChild.data
                                    var desc4 = itens[10].firstChild.data
                                    var ipi = itens[11].firstChild.data
                                    var d1 = 0;
                                    var d2 = 0;
                                    var d3 = 0;
                                    var d4 = 0;

                                    if (desc1 != 0) {
                                        d1 = liq / 100 * desc1;
                                    } else {
                                        d1 = 0;
                                    }
                                    liq = liq - d1;
                                    if (desc2 != 0) {
                                        d2 = liq / 100 * desc2;
                                    } else {
                                        d2 = 0;
                                    }
                                    liq = liq - d2;
                                    if (desc3 != 0) {
                                        d3 = liq / 100 * desc3;
                                    } else {
                                        d3 = 0;
                                    }
                                    liq = liq - d3;
                                    if (desc4 != 0) {
                                        d4 = liq / 100 * desc4;
                                    } else {
                                        d4 = 0;
                                    }
                                    liq = liq - d4;
                                    var vipi = 0;

                                    if (ipi != 0) {
                                        vipi = liq / 100 * ipi;
                                    }

                                    var val = liq;

                                    val = (Math.round(val * 100)) / 100;

                                    vet[i][8] = val;

                                    val = (val.format(2, ",", "."));

                                    tabela += "<div class='cell-max' data-title='Preço'>" + val + "</div>";
                                } else if (j == 5) {

                                    cod = itens[j].firstChild.data;

                                    vet[i][0] = cod;

                                    //Quantidade passa a ser a quantidade da NFe

                                    vet[i][1] = itens[21].firstChild.data;
                                    vet[i][2] = itens[6].firstChild.data;

                                    tabela += "<div class='cell-max' data-title='Baixar'>" + "<input type='text' id='" + cod + "' name='" + cod + "' value='" + itens[21].firstChild.data + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='4' onBlur='convertField3(this);editar(" + cod + ",this.value," + itens[6].firstChild.data + ");'>" + "</div>"

                                    //Valor passa a vir da Nota

                                    //Por enquanto continua pegando do pedido devido aos descontos


                                    //Valor passa a ser o valor da NFe
                                    if (itens[22].firstChild.data != 0) {
                                        val = itens[22].firstChild.data;
                                    } else {
                                        val = vet[i][8];
                                    }

                                    val = (Math.round(val * 100)) / 100;


                                    vet[i][20] = val;
                                    val = (val.format(2, ".", ","));

                                    //Grava variavel com o CFOP
                                    if (itens[23].firstChild.data != 0 && cfop == '' && itens[27].firstChild.data == 0) {
                                        cfop = itens[23].firstChild.data;
                                    }

                                    //Grava variavel com o CFOP
                                    if (itens[23].firstChild.data != 0 && cfopst == '' && itens[27].firstChild.data != 0) {
                                        cfopst = itens[23].firstChild.data;
                                    }

                                    //Grava variavel com o icms
                                    if (itens[24].firstChild.data != 0 && picms == 0) {
                                        picms = itens[24].firstChild.data;
                                    }
                                    //Grava variavel com o iva
                                    if (itens[27].firstChild.data != 0 && piva == 0) {
                                        piva = itens[27].firstChild.data;
                                    }

                                    //Grava variavel com a base ipi
                                    if (itens[25].firstChild.data != 0) {
                                        var valipi = itens[25].firstChild.data;
                                        valipi = (Math.round(valipi * 100)) / 100;
                                        bipi = bipi + valipi;
                                    }
                                    //Grava variavel com o ipi
                                    if (itens[26].firstChild.data != 0 && pipi == 0) {
                                        pipi = itens[26].firstChild.data;
                                    }

                                    tabela += "<div class='cell-max' data-title='Valor'>" + "<input type='text' id='val" + cod + "' name='" + cod + "' value='" + val + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='4' onBlur='convertField3(this);editarvalnf(" + cod + ",this.value);'>" + "</div>"

                                    //Grava variavel com o icms
                                    var vaiicm = 0;
                                    vaiicm = itens[24].firstChild.data;
                                    vet[i][6] = vaiicm;

                                    //Grava variavel com o ipi
                                    var vaiipi = 0;
                                    vaiipi = itens[26].firstChild.data;
                                    vet[i][7] = vaiipi;

                                    if (document.getElementById("radioperc2").checked == true) {
                                        tabela += "<div class='cell-max' data-title='ICMS'>" + "<input type='text' id='icm" + cod + "' name='icm" + cod + "' value='" + vaiicm + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='5' onBlur='convertField3(this);editaricm(" + cod + ",this.value);'>" + "</div>"
                                        tabela += "<div class='cell-max' data-title='IPI'>" + "<input type='text' id='ipi" + cod + "' name='ipi" + cod + "' value='" + vaiipi + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='5' onBlur='convertField3(this);editaripi(" + cod + ",this.value);'>" + "</div>"
                                    } else
                                    {
                                        tabela += "<div class='cell-max' data-title='ICMS'>" + "<input type='text' id='icm" + cod + "' name='icm" + cod + "' value='" + vaiicm + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='5' onBlur='convertField3(this);editaricm(" + cod + ",this.value);' disabled>" + "</div>"
                                        tabela += "<div class='cell-max' data-title='IPI'>" + "<input type='text' id='ipi" + cod + "' name='ipi" + cod + "' value='" + vaiipi + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='5' onBlur='convertField3(this);editaripi(" + cod + ",this.value);' disabled>" + "</div>"
                                    }

                                    //Grava variavel com o iva
                                    var vaiiva = 0;
                                    vaiiva = itens[27].firstChild.data;

                                    if (vaiiva == 0) {
                                        var iva = 0;
                                        var st = "N";
                                    } else {
                                        var iva = vaiiva;
                                        var st = "S";
                                    }


                                    vet[i][18] = iva;
                                    vet[i][19] = st;

                                    if (document.getElementById("radiost1").checked == true) {
                                        tabela += "<div class='cell-max' data-title='IVA'>" + "<input type='text' id='iva" + cod + "' name='iva" + cod + "' value='" + iva + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='5' onBlur='convertField3(this);editariva(" + cod + ",this.value);'>" + "</div>"
                                        tabela += "<div class='cell-max' data-title='ST'>" + "<input type='text' id='st" + cod + "' name='st" + cod + "' value='" + st + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='5' onBlur='convertField04(this);editarst(" + cod + ",this.value);'>" + "</div>"
                                    } else
                                    {
                                        tabela += "<div class='cell-max' data-title='IVA'>" + "<input type='text' id='iva" + cod + "' name='iva" + cod + "' value='" + iva + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='5' onBlur='convertField3(this);editariva(" + cod + ",this.value);' disabled>" + "</div>"
                                        tabela += "<div class='cell-max' data-title='ST'>" + "<input type='text' id='st" + cod + "' name='st" + cod + "' value='" + st + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='5' onBlur='convertField04(this);editarst(" + cod + ",this.value);' disabled>" + "</div>"
                                    }

                                } else if (j == 12) {
                                    vet[i][10] = itens[j].firstChild.data;
                                } else if (j == 13) {
                                    vet[i][11] = itens[j].firstChild.data;
                                } else if (j == 14) {
                                    vet[i][12] = itens[j].firstChild.data;
                                } else if (j == 15) {
                                    vet[i][13] = itens[j].firstChild.data;
                                } else if (j == 16) {
                                    vet[i][14] = itens[j].firstChild.data;
                                    tabela += "<div class='cell-max' data-title='EMB'>" + "<input type='text' id='proemb" + cod + "' name='proemb" + cod + "' value='" + itens[j].firstChild.data + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='5' onBlur='convertField3(this);editar1(" + cod + ",this.value,14);'>" + "</div>"
                                } else if (j == 17) {

                                    vet[i][17] = itens[20].firstChild.data;
                                    tabela += "<div class='cell-max' data-title='EAN'>" + "<input type='text' id='barunidade" + cod + "' name='barunidade" + cod + "'value='" + itens[20].firstChild.data + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='14' onBlur='convertField3(this);editar1(" + cod + ",this.value,17);'>" + "</div>"

                                    vet[i][15] = itens[j].firstChild.data;
                                    tabela += "<div class='cell-max' data-title='DUN'>" + "<input type='text' id='barcaixa" + cod + "' name='barcaixa" + cod + "'value='" + itens[j].firstChild.data + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='14' onBlur='convertField3(this);editar1(" + cod + ",this.value,15);'>" + "</div>"

                                } else if (j == 18) {

                                    vet[i][16] = itens[19].firstChild.data;
                                    tabela += "<div class='cell-max' data-title='Fiscal'>" + "<input type='text' id='cf" + cod + "' name='cf" + cod + " 'value='" + itens[j].firstChild.data + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px; cursor: pointer' size='7' readonly onClick=alteracf(" + cod + ")>" + "</div>"

                                    cod = itens[5].firstChild.data;

                                    if (itens[21].firstChild.data == 0) {
                                        tabela += "<div class='cell-max' data-title='Baixa'><label class='check-container-grid'><input type='checkbox' id='chk" + cod + "' name='chk" + cod + "' onClick=editarbaixa(" + cod + "); ><span class='check-checkmark-grid'></span></label></div>"
                                        vet[i][9] = 0;
                                    } else {
                                        vet[i][9] = 1;
                                        tabela += "<div class='cell-max' data-title='Baixa'><label class='check-container-grid'><input type='checkbox' id='chk" + cod + "' name='chk" + cod + "' onClick=editarbaixa(" + cod + "); checked><span class='check-checkmark-grid'></span></label></div>"
                                    }

                                }

                            }

                        }

                    }
                    tabela += "</div>"
                }

            }
            //Indica os itens que não estão na nota
            else {

                if (itens[0].firstChild.data == '_') {
                    naoitens = naoitens + itens[1].firstChild.data + ' ' + itens[2].firstChild.data + ' ' + itens[3].firstChild.data + '\n';
                } else {
                    naoitens = naoitens + itens[0].firstChild.data + ' ' + itens[1].firstChild.data + ' ' + itens[2].firstChild.data + ' ' + itens[3].firstChild.data + '\n';
                }

            }
        }

        tabela += "</div>"
        tabela += "</div>"
        tabela += "</div>"
        tabela += "</div>"

        $("resultado").innerHTML = tabela;
        tabela = null;

        //Atualiza o CFOP da Nota		
        $("cfop").value = cfop;
        $("cfop2").value = cfopst;
        if (cfop == '') {
            $("cfop").value = cfopst;
        }

        if (document.getElementById("radiost1").checked == true && cfopst == '') {
            $("cfop2").value = cfop;
        }

        //Atualiza o ICMS
        $("icm").value = picms;
        //Atualiza o IVA
        $("perciva").value = piva;
        //Atualiza o IPI
        bipi = (Math.round(bipi * 100)) / 100;
        $("baseipi").value = bipi;
        $("percipi").value = pipi;

        //Mostra os itens que estão na Nota e não estão no Pedido
        if (naoitens != '') {
            alert('Atencao, existem itens na NFe que não estão lançados no pedido!' + '\n' + '\n' + naoitens + '\n' + 'Não é permitido continuar!' + '\n');
            $("button").disabled = true;
        } else {
            $("button").disabled = false;
        }

    } else
    {
        $("resultado").innerHTML = "Nenhum registro encontrado...";
    }

    $a.unblockUI();

    //alert(pos);

    if (pos == 1) {


        $("data").value = "";
        $("datanota").value = "";
        $("nota").value = "";
        $("cfop").value = 0;
        $("produtos").value = 0;
        $("icm").value = 0;
        $("baseicm").value = 0;
        $("valoricm").value = 0;
        $("isentas").value = 0;
        $("outras").value = 0;
        $("baseipi").value = 0;
        $("percipi").value = 0;
        $("valoripi").value = 0;
        $("totalnota").value = 0;
        $("observacoes").value = "";

        $("localiza").value = "";

        $("outrasipi").value = 0;

        $("cfop2").value = "";
        $("basesubst").value = 0;
        $("valorsubst").value = 0;
        $("perciva").value = 0;

        document.getElementById("radiost2").checked = true;

        document.forms[0].pcnumero.focus();
        pos = 0;
    }

    if (xpdf == 1)
    {
        imppdf();
    }


}

//Refaz o grid de acordo com NFe
function imprimenfeold(request) {




    $("resultado").innerHTML = "";

    $("msg").style.visibility = "hidden";
    var xmldoc = request.responseXML;
    var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];
    if (cabecalho != null)
    {


        var tabela = "<table width='715' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' ><tr>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Codigo</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Ref. Forn.</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Produto</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>QTD</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Valor</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Baixa</b></td>"

        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Valor NF</b></td>"

        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>ICM</b></td>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>IPI</b></td>"

        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>IVA</b></td>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>ST</b></td>"

        /*
         tabela+="<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Altura</b></td>"
         tabela+="<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Largura</b></td>"
         tabela+="<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Compr.</b></td>"
         tabela+="<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Peso</b></td>"
         */

        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Emb.</b></td>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Cod. Barras</b></td>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Cod. Bar. Caixa</b></td>"

        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Cl. Fiscal</b></td>"

        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><center><b>.</b></center></td>"

        //corpo da tabela
        var cfop = '';
        var cfopst = '';
        var picms = 0;
        var piva = 0;
        var bipi = 0;
        var pipi = 0;
        var cod = 0;

        var naoitens = '';

        var registros = xmldoc.getElementsByTagName('registro');
        for (i = 0; i < registros.length; i++) {
            var itens = registros[i].getElementsByTagName('item');

            var existe = itens[5].firstChild.data;

            if (existe != 0) {

                //var saldo=itens[2].firstChild.data-itens[5].firstChild.data;
                var saldo = itens[3].firstChild.data - itens[6].firstChild.data;
                if (saldo != 0) {

                    tabela += "<tr id=linha" + i + ">"
                    for (j = 0; j < itens.length; j++) {

                        if (j < 21) {

                            if (itens[j].firstChild == null)
                                tabela += "<td class='borda'>" + 0 + "</td>";
                            else

                            //Quantidade do Pedido
                            if (j == 3) {
                                var saldo = itens[j].firstChild.data - itens[6].firstChild.data;
                                tabela += "<td class='borda' align='right'>&nbsp;" + saldo + "&nbsp;</td>";
                                vet[i][3] = saldo;
                                vet[i][4] = itens[6].firstChild.data;
                            }
                            //Valor do Pedido

                            else if (j == 4) {

                                var liq = itens[j].firstChild.data
                                var desc1 = itens[7].firstChild.data
                                var desc2 = itens[8].firstChild.data
                                var desc3 = itens[9].firstChild.data
                                var desc4 = itens[10].firstChild.data
                                var ipi = itens[11].firstChild.data
                                var d1 = 0;
                                var d2 = 0;
                                var d3 = 0;
                                var d4 = 0;

                                if (desc1 != 0) {
                                    d1 = liq / 100 * desc1;
                                } else {
                                    d1 = 0;
                                }
                                liq = liq - d1;
                                if (desc2 != 0) {
                                    d2 = liq / 100 * desc2;
                                } else {
                                    d2 = 0;
                                }
                                liq = liq - d2;
                                if (desc3 != 0) {
                                    d3 = liq / 100 * desc3;
                                } else {
                                    d3 = 0;
                                }
                                liq = liq - d3;
                                if (desc4 != 0) {
                                    d4 = liq / 100 * desc4;
                                } else {
                                    d4 = 0;
                                }
                                liq = liq - d4;
                                var vipi = 0;

                                if (ipi != 0) {
                                    vipi = liq / 100 * ipi;
                                }

                                var val = liq;

                                val = (Math.round(val * 100)) / 100;

                                vet[i][8] = val;

                                val = (val.format(2, ",", "."));

                                tabela += "<td class='borda' align='right'>&nbsp;" + val + "&nbsp;</td>";
                            }

                            //Codigo Interno do item do pedido
                            else if (j == 5) {

                                cod = itens[j].firstChild.data;

                                vet[i][0] = cod;

                                //Quantidade passa a ser a quantidade da NFe
                                //vet[i][1]=saldo;
                                vet[i][1] = itens[21].firstChild.data;

                                vet[i][2] = itens[6].firstChild.data;


                                //tabela+="<td class='borda' style='cursor: pointer'><input type='text' id='"+cod+"' name='"+cod+"' value='"+saldo+"' size='4' onBlur='convertField3(this);editar("+cod+",this.value,"+itens[6].firstChild.data+");'></td>";
                                tabela += "<td class='borda' style='cursor: pointer'><input type='text' id='" + cod + "' name='" + cod + "' value='" + itens[21].firstChild.data + "' size='4' onBlur='convertField3(this);editar(" + cod + ",this.value," + itens[6].firstChild.data + ");'></td>";


                                //Valor passa a vir da Nota
                                /*
                                 if(itens[22].firstChild.data==0){
                                 val=vet[i][8];
                                 vet[i][20]=val;												
                                 val = (val.format(2, ".", ","));
                                 }
                                 else {
                                 val=itens[22].firstChild.data;
                                 vet[i][20]=val;										  
                                 }
                                 */
                                //Por enquanto continua pegando do pedido devido aos descontos


                                //Valor passa a ser o valor da NFe
                                if (itens[22].firstChild.data != 0) {
                                    val = itens[22].firstChild.data;
                                } else {
                                    val = vet[i][8];
                                }

                                val = (Math.round(val * 100)) / 100;


                                vet[i][20] = val;
                                val = (val.format(2, ".", ","));

                                //Grava variavel com o CFOP
                                if (itens[23].firstChild.data != 0 && cfop == '' && itens[27].firstChild.data == 0) {
                                    cfop = itens[23].firstChild.data;
                                }

                                //Grava variavel com o CFOP
                                if (itens[23].firstChild.data != 0 && cfopst == '' && itens[27].firstChild.data != 0) {
                                    cfopst = itens[23].firstChild.data;
                                }

                                //Grava variavel com o icms
                                if (itens[24].firstChild.data != 0 && picms == 0) {
                                    picms = itens[24].firstChild.data;
                                }
                                //Grava variavel com o iva
                                if (itens[27].firstChild.data != 0 && piva == 0) {
                                    piva = itens[27].firstChild.data;
                                }

                                //Grava variavel com a base ipi
                                if (itens[25].firstChild.data != 0) {
                                    var valipi = itens[25].firstChild.data;
                                    valipi = (Math.round(valipi * 100)) / 100;
                                    bipi = bipi + valipi;
                                }
                                //Grava variavel com o ipi
                                if (itens[26].firstChild.data != 0 && pipi == 0) {
                                    pipi = itens[26].firstChild.data;
                                }

                                tabela += "<td class='borda' style='cursor: pointer'><input type='text' id='" + cod + "' name='" + cod + "' value='" + val + "' size='4' onBlur='convertField3(this);editarvalnf(" + cod + ",this.value);'></td>";

                                //Grava variavel com o icms
                                var vaiicm = 0;
                                vaiicm = itens[24].firstChild.data;
                                vet[i][6] = vaiicm;

                                //Grava variavel com o ipi
                                var vaiipi = 0;
                                vaiipi = itens[26].firstChild.data;
                                vet[i][7] = vaiipi;

                                if (document.getElementById("radioperc2").checked == true) {
                                    tabela += "<td class='borda'><input type='text' id='icm" + cod + "' name='icm" + cod + "' value='" + vaiicm + "' size='5' onBlur='convertField3(this);editaricm(" + cod + ",this.value);'></td>";
                                    tabela += "<td class='borda'><input type='text' id='ipi" + cod + "' name='ipi" + cod + "' value='" + vaiipi + "' size='5' onBlur='convertField3(this);editaripi(" + cod + ",this.value);'></td>";
                                } else
                                {
                                    tabela += "<td class='borda'><input type='text' id='icm" + cod + "' name='icm" + cod + "' value='" + vaiicm + "' size='5' onBlur='convertField3(this);editaricm(" + cod + ",this.value);' disabled ></td>";
                                    tabela += "<td class='borda'><input type='text' id='ipi" + cod + "' name='ipi" + cod + "' value='" + vaiipi + "' size='5' onBlur='convertField3(this);editaripi(" + cod + ",this.value);' disabled ></td>";
                                }

                                /*
                                 if(itens[21]!=undefined){
                                 var iva=itens[21].firstChild.data;
                                 }
                                 else
                                 {
                                 var iva = "0";
                                 }
                                 if(itens[22]!=undefined)
                                 {
                                 var st=itens[22].firstChild.data;		
                                 }
                                 else
                                 {
                                 var st="0";
                                 }
                                 */

                                //Grava variavel com o iva
                                var vaiiva = 0;
                                vaiiva = itens[27].firstChild.data;

                                if (vaiiva == 0) {
                                    var iva = 0;
                                    var st = "N";
                                } else {
                                    var iva = vaiiva;
                                    var st = "S";
                                }


                                vet[i][18] = iva;
                                vet[i][19] = st;

                                if (document.getElementById("radiost1").checked == true) {
                                    tabela += "<td class='borda'><input type='text' id='iva" + cod + "' name='iva" + cod + "' value='" + iva + "' size='5' onBlur='convertField3(this);editariva(" + cod + ",this.value);'  ></td>";
                                    tabela += "<td class='borda'><input type='text' id='st" + cod + "' name='st" + cod + "' value='" + st + "' size='5' onBlur='convertField04(this);editarst(" + cod + ",this.value);'  ></td>";
                                } else
                                {
                                    tabela += "<td class='borda'><input type='text' id='iva" + cod + "' name='iva" + cod + "' value='" + iva + "' size='5' onBlur='convertField3(this);editariva(" + cod + ",this.value);' disabled ></td>";
                                    tabela += "<td class='borda'><input type='text' id='st" + cod + "' name='st" + cod + "' value='" + st + "' size='5' onBlur='convertField04(this);editarst(" + cod + ",this.value);' disabled ></td>";
                                }

                            } else if (j == 0) {
                                tabela += "<td class='borda'>" + itens[j].firstChild.data + "</td>";

                                vet[i][5] = itens[j].firstChild.data;

                            } else if (j == 1) {
                                tabela += "<td class='borda'>" + itens[j].firstChild.data + "</td>";
                            } else if (j == 2) {
                                tabela += "<td class='borda'>" + itens[j].firstChild.data + "</td>";
                            } else if (j == 12) {
                                vet[i][10] = itens[j].firstChild.data;
                                //tabela+="<td class='borda'><input type='text' id='proaltcx"+cod+"' name='proaltcx"+cod+"' value='"+itens[j].firstChild.data+"' size='5' onBlur='convertField3(this);editar1("+cod+",this.value,10);' ></td>";
                            } else if (j == 13) {
                                vet[i][11] = itens[j].firstChild.data;
                                //tabela+="<td class='borda'><input type='text' id='prolarcx"+cod+"' name='prolarcx"+cod+"' value='"+itens[j].firstChild.data+"' size='5' onBlur='convertField3(this);editar1("+cod+",this.value,11);' ></td>";
                            } else if (j == 14) {
                                vet[i][12] = itens[j].firstChild.data;
                                //tabela+="<td class='borda'><input type='text' id='procomcx"+cod+"' name='procomcx"+cod+"' value='"+itens[j].firstChild.data+"' size='5' onBlur='convertField3(this);editar1("+cod+",this.value,12);' ></td>";
                            } else if (j == 15) {
                                vet[i][13] = itens[j].firstChild.data;
                                //tabela+="<td class='borda'><input type='text' id='propescx"+cod+"' name='propescx"+cod+"' value='"+itens[j].firstChild.data+"' size='5' onBlur='convertField3(this);editar1("+cod+",this.value,13);' ></td>";
                            } else if (j == 16) {
                                vet[i][14] = itens[j].firstChild.data;
                                tabela += "<td class='borda'><input type='text' id='proemb" + cod + "' name='proemb" + cod + "' value='" + itens[j].firstChild.data + "' size='5' onBlur='convertField3(this);editar1(" + cod + ",this.value,14);' ></td>";
                            } else if (j == 17) {

                                vet[i][17] = itens[20].firstChild.data;
                                tabela += "<td class='borda'><input type='text' id='barunidade" + cod + "' name='barunidade" + cod + "'value='" + itens[20].firstChild.data + "' size='14' onBlur='convertField3(this);editar1(" + cod + ",this.value,17);' ></td>";

                                vet[i][15] = itens[j].firstChild.data;
                                tabela += "<td class='borda'><input type='text' id='barcaixa" + cod + "' name='barcaixa" + cod + "'value='" + itens[j].firstChild.data + "' size='14' onBlur='convertField3(this);editar1(" + cod + ",this.value,15);' ></td>";
                            } else if (j == 18) {

                                vet[i][16] = itens[19].firstChild.data;
                                tabela += "<td class='borda' ><input type='text' id='cf" + cod + "' name='cf" + cod + " 'value='" + itens[j].firstChild.data + "' size='7'  style='cursor: pointer' readonly onClick=alteracf(" + cod + ") ></td>";

                                cod = itens[5].firstChild.data;

                                if (itens[21].firstChild.data == 0) {
                                    tabela += "<td class='borda'><input type='checkbox' id='chk" + cod + "' name='chk" + cod + "' onClick=editarbaixa(" + cod + "); > </td>";
                                    vet[i][9] = 0;
                                } else {
                                    vet[i][9] = 1;
                                    tabela += "<td class='borda'><input type='checkbox' id='chk" + cod + "' name='chk" + cod + "' onClick=editarbaixa(" + cod + "); checked> </td>";
                                }



                            }

                        }

                    }


                    tabela += "</tr>";
                }

            }
            //Indica os itens que não estão na nota
            else {

                if (itens[0].firstChild.data == '_') {
                    naoitens = naoitens + itens[1].firstChild.data + ' ' + itens[2].firstChild.data + ' ' + itens[3].firstChild.data + '\n';
                } else {
                    naoitens = naoitens + itens[0].firstChild.data + ' ' + itens[1].firstChild.data + ' ' + itens[2].firstChild.data + ' ' + itens[3].firstChild.data + '\n';
                }

            }
        }

        tabela += "</table>"


        tabela += "</tr>"

        $("resultado").innerHTML = tabela;
        //$("resultado2").innerHTML=tabela2;
        tabela = null;

        //Atualiza o CFOP da Nota		
        $("cfop").value = cfop;
        $("cfop2").value = cfopst;
        if (cfop == '') {
            $("cfop").value = cfopst;
        }

        if (document.getElementById("radiost1").checked == true && cfopst == '') {
            $("cfop2").value = cfop;
        }

        //Atualiza o ICMS
        $("icm").value = picms;
        //Atualiza o IVA
        $("perciva").value = piva;
        //Atualiza o IPI
        bipi = (Math.round(bipi * 100)) / 100;
        $("baseipi").value = bipi;
        $("percipi").value = pipi;

        //Mostra os itens que estão na Nota e não estão no Pedido
        if (naoitens != '') {
            alert('Atencao, existem itens na NFe que não estão lançados no pedido!' + '\n' + '\n' + naoitens + '\n' + 'Não é permitido continuar!' + '\n');
            $("button").disabled = true;
        } else {
            $("button").disabled = false;
        }

    } else
    {
        $("resultado").innerHTML = "Nenhum registro encontrado...";
    }


    //alert(pos);

    if (pos == 1) {


        $("data").value = "";
        $("datanota").value = "";
        $("nota").value = "";
        $("cfop").value = 0;
        $("produtos").value = 0;
        $("icm").value = 0;
        $("baseicm").value = 0;
        $("valoricm").value = 0;
        $("isentas").value = 0;
        $("outras").value = 0;
        $("baseipi").value = 0;
        $("percipi").value = 0;
        $("valoripi").value = 0;
        $("totalnota").value = 0;
        $("observacoes").value = "";

        $("localiza").value = "";

        $("outrasipi").value = 0;

        $("cfop2").value = "";
        $("basesubst").value = 0;
        $("valorsubst").value = 0;
        $("perciva").value = 0;

        document.getElementById("radiost2").checked = true;

        document.forms[0].pcnumero.focus();
        pos = 0;
    }

    if (xpdf == 1)
    {
        imppdf();
    }


}

function verificawms1() {
    document.getElementById('linhasenha').style.display = "none";
}

function verificawms2() {
    document.getElementById('linhasenha').style.display = "";
    $("adm").value = '';
    document.forms[0].adm.focus();
}

function verificasenha(valor) {

    if (valor != '') {

        var texto = valor;
        var letra;
        var codigo;
        var saida = '';
        for (i = 0; i < texto.length; i++)
        {
            letra = texto.substring(i, i + 1);
            codigo = letra.charCodeAt(0)
            if (codigo == 38) {
                codigo = 101;
            }
            if (codigo >= 97 && codigo <= 122) {
                codigo = (codigo - 32);
            }
            if (codigo == 231) {
                codigo = 67;
            }
            if (codigo >= 192 && codigo <= 198) {
                codigo = 65;
            }
            if (codigo == 199) {
                codigo = 67;
            }
            if (codigo >= 200 && codigo <= 203) {
                codigo = 69;
            }
            if (codigo >= 204 && codigo <= 207) {
                codigo = 73;
            }
            if (codigo >= 210 && codigo <= 214) {
                codigo = 79;
            }
            if (codigo >= 217 && codigo <= 220) {
                codigo = 85;
            }
            if (codigo >= 224 && codigo <= 230) {
                codigo = 65;
            }
            if (codigo == 231) {
                codigo = 199;
            }
            if (codigo >= 232 && codigo <= 235) {
                codigo = 69;
            }
            if (codigo >= 236 && codigo <= 240) {
                codigo = 73;
            }
            if (codigo >= 242 && codigo <= 246) {
                codigo = 79;
            }
            if (codigo >= 249 && codigo <= 252) {
                codigo = 85;
            }
            letra = String.fromCharCode(codigo);
            saida = saida + letra
        }
        valor = saida;


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
        if (ajax2) {
            ajax2.open("POST", "wmsverificasenha.php", true);
            ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            ajax2.onreadystatechange = function () {
                if (ajax2.readyState == 1) {
                }
                if (ajax2.readyState == 4) {
                    if (ajax2.responseXML) {
                        processXMLverificasenha(ajax2.responseXML, valor);
                    } else {

                        alert("Senha Inválida!");
                        //Se nao digitar a senha volta o Flag para Sim
                        document.getElementById("radiowms1").checked = true;
                        document.getElementById('linhasenha').style.display = "none";
                        $("adm").value = '';

                    }
                }
            }

            var usuario = $("usuario").value;
            if (usuario == '') {
                usuario = 0
            }

            var params = "parametro=" + valor + "&parametro2=" + usuario;

            ajax2.send(params);
        }

    } else {

        alert("Senha Inválida!");
        //Se nao digitar a senha volta o Flag para Sim
        document.getElementById("radiowms1").checked = true;
        document.getElementById('linhasenha').style.display = "none";
        $("adm").value = '';

    }

}
function processXMLverificasenha(obj, valor) {

    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");
    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados

        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];

            //contéudo dos campos no arquivo XML
            var usunome = item.getElementsByTagName("usunome")[0].firstChild.nodeValue;

            if (usunome != '_') {
                alert("Arquivo WMS não será gerado !");
            } else
            {
                alert("Senha Inválida!");
                //Se nao digitar a senha volta o Flag para Sim
                document.getElementById("radiowms1").checked = true;
                document.getElementById('linhasenha').style.display = "none";
                $("adm").value = '';
            }

        }
    } else {

        alert("Senha Inválida!");
        //Se nao digitar a senha volta o Flag para Sim
        document.getElementById("radiowms1").checked = true;
        document.getElementById('linhasenha').style.display = "none";
        $("adm").value = '';

    }

}

function cancelar() {
    window.open("pedcomprabaixanovo.php?", "_self");
}