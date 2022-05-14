
var vet = new Array(300);
var pos;
var gusuario;

for (var i = 0; i < 300; i++) {
    vet[i] = new Array(3);
}

for (var i = 0; i < 300; i++) {
    vet[i][0] = 0;
    vet[i][1] = 0;
    vet[i][2] = 0;
}

function inicia(usuario) {
    gusuario = usuario;
    document.forms[0].pcnumero.focus();
}


function ver() {

    for (var i = 0; i < 300; i++) {
        vet[i][0] = 0;
        vet[i][1] = 0;
        vet[i][2] = 0;
    }

    ver2();

}

function ver2() {

    var pcnumero = $("pcnumero").value;
    var pcseq = $("pcseq").value;

    if (pcnumero == 0 || pcnumero == '') {
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

            ajax2.open("POST", "pedcomprabaixaatualpesqversaldo.php", true);
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
                            alert("Baixa não encontrada!");
                        }

                        $("fornguerra").value = '';
                        $("comprador").value = '';
                        $("data").value = '';
                        $("datanota").value = '';
                        $("nota").value = '';
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

                        $("notentcodigo").value = '';
                        $("notentserie").value = '';

                        tabela = null;
                        $("resultado").innerHTML = tabela;

                    }
                }
            }

            //passa o parametro

            var params = "parametro=" + pcnumero + '&parametro2=' + pcseq;

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

            var fornguerra = item.getElementsByTagName("fornguerra")[0].firstChild.nodeValue;
            var comprador = item.getElementsByTagName("comprador")[0].firstChild.nodeValue;
            var notentdata = item.getElementsByTagName("notentdata")[0].firstChild.nodeValue;
            var notentemissao = item.getElementsByTagName("notentemissao")[0].firstChild.nodeValue;
            var notentnumero = item.getElementsByTagName("notentnumero")[0].firstChild.nodeValue;
            var notentcpof = item.getElementsByTagName("notentcpof")[0].firstChild.nodeValue;
            var notentvalor = item.getElementsByTagName("notentvalor")[0].firstChild.nodeValue;
            var notentprodutos = item.getElementsByTagName("notentprodutos")[0].firstChild.nodeValue;
            var notenticm = item.getElementsByTagName("notenticm")[0].firstChild.nodeValue;
            var notentbaseicm = item.getElementsByTagName("notentbaseicm")[0].firstChild.nodeValue;
            var notentvaloricm = item.getElementsByTagName("notentvaloricm")[0].firstChild.nodeValue;
            var notentisentas = item.getElementsByTagName("notentisentas")[0].firstChild.nodeValue;
            var notentoutras = item.getElementsByTagName("notentoutras")[0].firstChild.nodeValue;
            var notentbaseipi = item.getElementsByTagName("notentbaseipi")[0].firstChild.nodeValue;
            var notentpercipi = item.getElementsByTagName("notentpercipi")[0].firstChild.nodeValue;
            var notentvaloripi = item.getElementsByTagName("notentvaloripi")[0].firstChild.nodeValue;
            var notentobservacoes = item.getElementsByTagName("notentobservacoes")[0].firstChild.nodeValue;
            var notatualiza = item.getElementsByTagName("notatualiza")[0].firstChild.nodeValue;

            var notentcodigo = item.getElementsByTagName("notentcodigo")[0].firstChild.nodeValue;
            var notentserie = item.getElementsByTagName("notentserie")[0].firstChild.nodeValue;

            var temsaldo = item.getElementsByTagName("temsaldo")[0].firstChild.nodeValue;

            trimjs(fornguerra);
            if (txt == '0') {
                txt = '';
            }
            ;
            fornguerra = txt;
            trimjs(comprador);
            if (txt == '0') {
                txt = '';
            }
            ;
            comprador = txt;
            trimjs(notentdata);
            if (txt == '0') {
                txt = '';
            }
            ;
            notentdata = txt;
            trimjs(notentemissao);
            if (txt == '0') {
                txt = '';
            }
            ;
            notentemissao = txt;
            trimjs(notentnumero);
            if (txt == '0') {
                txt = '';
            }
            ;
            notentnumero = txt;
            trimjs(notentcpof);
            if (txt == '0') {
                txt = '';
            }
            ;
            notentcpof = txt;
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
            trimjs(notenticm);
            if (txt == '0') {
                txt = '';
            }
            ;
            notenticm = txt;
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
            trimjs(notentisentas);
            if (txt == '0') {
                txt = '';
            }
            ;
            notentisentas = txt;
            trimjs(notentoutras);
            if (txt == '0') {
                txt = '';
            }
            ;
            notentoutras = txt;
            trimjs(notentbaseipi);
            if (txt == '0') {
                txt = '';
            }
            ;
            notentbaseipi = txt;
            trimjs(notentpercipi);
            if (txt == '0') {
                txt = '';
            }
            ;
            notentpercipi = txt;
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
            trimjs(notatualiza);
            if (txt == '0') {
                txt = '';
            }
            ;
            notatualiza = txt;

            trimjs(notentcodigo);
            if (txt == '0') {
                txt = '';
            }
            ;
            notentcodigo = txt;
            trimjs(notentserie);
            if (txt == '0') {
                txt = '';
            }
            ;
            notentserie = txt;


            if (notatualiza != '1') {
                alert("Não foi feita a atualização de estoque para esta baixa!");
                document.forms[0].pcnumero.focus();
                $("pcnumero").value = '';
                $("pcseq").value = '';
                $("fornguerra").value = '';
                $("comprador").value = '';
                $("data").value = '';
                $("datanota").value = '';
                $("nota").value = '';
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

                $("notentcodigo").value = '';
                $("notentserie").value = '';

                tabela = null;
                $("resultado").innerHTML = tabela;

            } else {

                if (temsaldo == '0' || gusuario == 359 || gusuario == 728) {

                    if (temsaldo != '0') {
                        alert(temsaldo);
                    }

                    $("fornguerra").value = fornguerra;
                    $("comprador").value = comprador;
                    $("data").value = notentdata;
                    $("datanota").value = notentemissao;
                    $("nota").value = notentnumero;
                    $("cfop").value = notentcpof;
                    $("produtos").value = notentprodutos;
                    $("icm").value = notenticm;
                    $("baseicm").value = notentbaseicm;
                    $("valoricm").value = notentvaloricm;
                    $("isentas").value = notentisentas;
                    $("outras").value = notentoutras;
                    $("baseipi").value = notentbaseipi;
                    $("percipi").value = notentpercipi;
                    $("valoripi").value = notentvaloripi;
                    $("totalnota").value = notentvalor;
                    $("observacoes").value = notentobservacoes;
                    $("notentcodigo").value = notentcodigo;
                    $("notentserie").value = notentserie;

                } else {

                    alert(temsaldo);

                    $("pcnumero").value = '';
                    $("pcseq").value = '';
                    $("fornguerra").value = '';
                    $("comprador").value = '';
                    $("data").value = '';
                    $("datanota").value = '';
                    $("nota").value = '';
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
                    $("notentcodigo").value = '';
                    $("notentserie").value = '';
                    tabela = null;
                    $("resultado").innerHTML = tabela;
                    document.forms[0].pcnumero.focus();

                }


            }

        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo

        if ($("pcnumero").value != '')
        {
            alert("Baixa não encontrada!");
            document.forms[0].pcnumero.focus();
        }

        //$("pcnumero").value='';

        $("fornguerra").value = '';
        $("comprador").value = '';
        $("data").value = '';
        $("datanota").value = '';
        $("nota").value = '';
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

        $("notentcodigo").value = '';
        $("notentserie").value = '';

        tabela = null;
        $("resultado").innerHTML = tabela;




    }

    if ($("notentcodigo").value != '') {
        load_grid($("notentcodigo").value);
    }

}

// JavaScript Document
function load_grid(nota) {

    $("button").disabled = true;
    $("button2").disabled = true;
    $("pcnumero").disabled = true;
    $("pcseq").disabled = true;
    $("button_pesquisa").disabled = true;

    let titulo = "PROCESSANDO, AGUARDE...";
    let mensagem = "EXECUTANDO PESQUISA DE ITENS!";

    $a("#retorno").messageBoxModal(titulo, mensagem);

    new ajax('pedcomprabaixapesquisanota.php?nota=' + nota, {onLoading: carregando, onComplete: imprime});
}

function carregando() {
    $("msg").style.visibility = "visible";
    $("msg").innerHTML = "Processando...";
}

function imprime(request) {



    $("msg").style.visibility = "hidden";
    var xmldoc = request.responseXML;
    var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];
    if (cabecalho != null)
    {

        let tabela = "<div class='limiter'>"
        tabela += "<div class='container-table100'>"
        tabela += "<div class='wrap-table100'>"
        tabela += "<div class='table-max'>"
        tabela += "<div class='row-max header'>"
        tabela += "<div class='cell-max'>Codigo</div>"
        tabela += "<div class='cell-max'>Produto</div>"
        tabela += "<div class='cell-max'>Quantidade</div>"
        tabela += "<div class='cell-max'>Valor</div>"
        tabela += "</div>";

        //corpo da tabela

        var cod = 0;
        var registros = xmldoc.getElementsByTagName('registro');
        for (i = 0; i < registros.length; i++) {
            var itens = registros[i].getElementsByTagName('item');
            tabela += "<div class='row-max'>"

            for (j = 0; j < itens.length; j++) {

                if (itens[j].firstChild == null)
                    tabela += "<div class='cell-max'>" + 0 + "</div>"
                else


                if (j == 2) {
                    tabela += "<div class='cell-max' data-title='Quantidade'>" + itens[j].firstChild.data + "</div>";
                } else if (j == 3) {
                    tabela += "<div class='cell-max' data-title='Valor'>" + itens[j].firstChild.data + "</div>";
                } else if (j == 0) {
                    tabela += "<div class='cell-max' data-title='Codigo'>" + itens[j].firstChild.data + "</div>";
                } else if (j == 1) {
                    tabela += "<div class='cell-max' data-title='Produto'>" + itens[j].firstChild.data + "</div>";
                } else if (j == 4) {
                    var cod = itens[j].firstChild.data;
                    vet[i][0] = cod;
                    var qtd = itens[2].firstChild.data
                    vet[i][1] = qtd;
                }
            }


            tabela += "</div>"
        }

        tabela += "</div>"
        tabela += "</div>"
        tabela += "</div>"
        tabela += "</div>"

        $("resultado").innerHTML = tabela;
        tabela = null;


        $("button").disabled = false;
        $("button2").disabled = false;
    } else
    {
        $("resultado").innerHTML = "Nenhum registro encontrado...";
    }

    $a.unblockUI();

    //alert(pos);

    if (pos == 1) {


        $("fornguerra").value = '';
        $("comprador").value = '';
        $("data").value = '';
        $("datanota").value = '';
        $("nota").value = '';
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

        $("notentcodigo").value = '';
        $("notentserie").value = '';



        document.forms[0].pcnumero.focus();
        pos = 0;
    }


}

function imprimeold(request) {



    $("msg").style.visibility = "hidden";
    var xmldoc = request.responseXML;
    var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];
    if (cabecalho != null)
    {


        var tabela = "<table width='515' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' ><tr>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Codigo</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Produto</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Quantidade</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Valor</b></td>";

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


                if (j == 2) {
                    tabela += "<td class='borda' align='right'>&nbsp;" + itens[j].firstChild.data + "&nbsp;</td>";
                } else if (j == 3) {
                    tabela += "<td class='borda' align='right'>&nbsp;" + itens[j].firstChild.data + "&nbsp;</td>";
                } else if (j == 0) {
                    tabela += "<td class='borda'>" + itens[j].firstChild.data + "</td>";
                } else if (j == 1) {
                    tabela += "<td class='borda'>" + itens[j].firstChild.data + "</td>";
                } else if (j == 4) {
                    var cod = itens[j].firstChild.data;
                    vet[i][0] = cod;
                    var qtd = itens[2].firstChild.data
                    vet[i][1] = qtd;
                }
            }


            tabela += "</tr>";
        }

        tabela += "</table>"


        tabela += "</tr>"

        $("resultado").innerHTML = tabela;
        //$("resultado2").innerHTML=tabela2;
        tabela = null;

        //Habilita o Botão
        document.getElementById('button').disabled = false;
    } else
    {
        $("resultado").innerHTML = "Nenhum registro encontrado...";
    }


    //alert(pos);

    if (pos == 1) {


        $("fornguerra").value = '';
        $("comprador").value = '';
        $("data").value = '';
        $("datanota").value = '';
        $("nota").value = '';
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

        $("notentcodigo").value = '';
        $("notentserie").value = '';



        document.forms[0].pcnumero.focus();
        pos = 0;
    }


}

function cancelar() {

    var campopc = "";
    campopc = document.getElementById('pcnumero').value;
    if (campopc == "") {
        return;
    }

    if (confirm("Confirma cancelamento da atualização de estoque ? Pedido " + document.getElementById('pcnumero').value + "-" + document.getElementById('pcseq').value)) {
        cancelar2();
        //Habilita o Botão
        document.getElementById('button').disabled = true;

    } else {
        return;
    }

}

function cancelar2() {

    $("button").disabled = true;
    $("button2").disabled = true;
    $("pcnumero").disabled = true;
    $("pcseq").disabled = true;
    $("button_pesquisa").disabled = true;

    let titulo = "PROCESSANDO, AGUARDE...";
    let mensagem = "CANCELANDO A ATUALIZAÇÃO DE ESTOQUE!";

    $a("#retorno").messageBoxModal(titulo, mensagem);

    var campovet1 = ""
    var campovet2 = ""
    var nota = document.getElementById('nota').value;

    for (var i = 0; i < 300; i++) {
        if (vet[i][0] != 0) {
            campovet1 = campovet1 + '&c[]=' + vet[i][0];
            campovet2 = campovet2 + '&d[]=' + vet[i][1];

        }
    }
    new ajax('pedcomprabaixaatcanconf.php?' + campovet1
            //window.open('pedcomprabaixacancconf.php?' + campovet1
            + '' + campovet2
            + '&pcnumero=' + document.getElementById('pcnumero').value
            + '&pcseq=' + document.getElementById('pcseq').value,
            //, '_blank');
                    {onComplete: imprimebaixa()});

        }

function imprimebaixa() {

    /*
     new ajax('pedcomprabaixaatcanimp.php?'
     + '&pcnumero=' + document.getElementById('pcnumero').value
     + '&pcseq=' + document.getElementById('pcseq').value,
     //, '_blank');
     {onComplete: ok()});
     }
     * 
     */

    ok();

}


function ok() {

    $a.unblockUI();


    alert('Cancelamento de atualização confirmado!');
    limpar();

}

function limpar() {
    window.open("pedcomprabaixacancatualnovo.php?", "_self");
}