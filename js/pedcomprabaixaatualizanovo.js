
var vet = new Array(300);
var pos;

for (var i = 0; i < 300; i++) {
    vet[i] = new Array(3);
}

for (var i = 0; i < 300; i++) {
    vet[i][0] = 0;
    vet[i][1] = 0;
    vet[i][2] = 0;
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

    document.getElementById('button').disabled = true;

    var pcnumero = $("pcnumero").value;
    //var pcseq = $("pcseq").value;
    var pcseq = document.forms[0].listsec.options[document.forms[0].listsec.selectedIndex].value;

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

            ajax2.open("POST", "pedcomprabaixaatualpesq.php", true);
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
                        {//alert("Baixa não encontrada!");
                        }
                        $("fornguerra").value = '';
                        $("comprador").value = '';
                        $("deposito").value = '';
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
            var deposito = item.getElementsByTagName("deposito")[0].firstChild.nodeValue;
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
            trimjs(deposito);
            if (txt == '0') {
                txt = '';
            }
            ;
            deposito = txt;
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

            if (notatualiza == '1') {
                alert("Já foi feita a atualização de estoque para esta baixa!");

                limpar();

                /*
                 document.forms[0].pcnumero.focus();
                 $("pcnumero").value = '';
                 //		$("pcseq").value='';
                 
                 document.forms[0].listsec.options.length = 1;
                 idOpcao = document.getElementById("opcoes");
                 idOpcao.innerHTML = "__";
                 
                 $("fornguerra").value = '';
                 $("comprador").value = '';
                 $("deposito").value = '';
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
                 * 
                 */

            } else {

                $("fornguerra").value = fornguerra;
                $("comprador").value = comprador;
                $("deposito").value = deposito;
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

            }

        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo

        if ($("pcnumero").value != '')
        {//alert("Baixa não encontrada!");
            document.forms[0].pcnumero.focus();
        }

        //$("pcnumero").value='';

        $("fornguerra").value = '';
        $("comprador").value = '';
        $("deposito").value = '';
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
    $("button_pesquisa").disabled = true;
    document.forms[0].listsec.disabled = true;

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
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Estoque</b></td>";

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
                } else if (j == 5) {
                    var cod1 = itens[4].firstChild.data;
                    var est = itens[5].firstChild.data;
                    vet[i][2] = est;
                    tabela += "<td class='borda' style='cursor: pointer'><input type='text' id='" + cod1 + "' name='" + cod1 + "' value='" + est + "' size='15' onBlur=editar(" + cod1 + ",this.value" + ");></td>";


                }
            }


            tabela += "</tr>";
        }

        tabela += "</table>"


        tabela += "</tr>"

        $("resultado").innerHTML = tabela;
        //$("resultado2").innerHTML=tabela2;
        tabela = null;

        //Verifica se existe o Registro WMS
        //verificawms();


    } else
    {
        $("resultado").innerHTML = "Nenhum registro encontrado...";
    }


    $a.unblockUI();

    if (pos == 1) {


        $("fornguerra").value = '';
        $("comprador").value = '';
        $("deposito").value = '';
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
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Estoque</b></td>";

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
                } else if (j == 5) {
                    var cod1 = itens[4].firstChild.data;
                    var est = itens[5].firstChild.data;
                    vet[i][2] = est;
                    tabela += "<td class='borda' style='cursor: pointer'><input type='text' id='" + cod1 + "' name='" + cod1 + "' value='" + est + "' size='15' onBlur=editar(" + cod1 + ",this.value" + ");></td>";


                }
            }


            tabela += "</tr>";
        }

        tabela += "</table>"


        tabela += "</tr>"

        $("resultado").innerHTML = tabela;
        //$("resultado2").innerHTML=tabela2;
        tabela = null;

        //Verifica se existe o Registro WMS
        verificawms();


    } else
    {
        $("resultado").innerHTML = "Nenhum registro encontrado...";
    }


    //alert(pos);

    if (pos == 1) {


        $("fornguerra").value = '';
        $("comprador").value = '';
        $("deposito").value = '';
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

function editar(val1, val2) {


    for (var k = 0; k < 300; k++) {
        if (vet[k][0] == val1) {
            vet[k][2] = val2;
            return;
        }


    }


}

function verificawms() {

    //Se for estoque 11 ou 26 vai verificar se existe a Conferencia WMAS	
    if ($("deposito").value == 26 || $("deposito").value == 11 || $("deposito").value == 9) {
        processawms($("notentcodigo").value);
    } else {
        document.getElementById('button').disabled = false;
    }

}

// JavaScript Document
function processawms(nota) {

    new ajax('pedcomprabaixapesquisawms.php?nota=' + nota, {onLoading: carregando, onComplete: confirmawms});
}

function confirmawms(request)
{

    $("msg").style.visibility = "hidden";

    var xmldoc = request.responseXML;
    erro = 0;

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
                erro = itens[0].firstChild.data;
            }
        }

    }

    if (erro == 0) {
        document.getElementById('button').disabled = false;
    } else if (erro == 1) {
        alert("Problema com a nota de Entrada, avise o Administrador!");
        $("fornguerra").value = '';
        $("comprador").value = '';
        $("deposito").value = '';
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
        document.forms[0].listsec.options.length = 1;
        idOpcao = document.getElementById("opcoes");
        idOpcao.innerHTML = "__";
        $("pcnumero").value = '';
        document.forms[0].pcnumero.focus();


        pos = 0;
    } else if (erro == 2) {
        alert("Nota de Entrada sem conferência pelo wms!");
        $("fornguerra").value = '';
        $("comprador").value = '';
        $("deposito").value = '';
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
        document.forms[0].listsec.options.length = 1;
        idOpcao = document.getElementById("opcoes");
        idOpcao.innerHTML = "__";
        $("pcnumero").value = '';
        document.forms[0].pcnumero.focus();

        pos = 0;
    }
    //Erro 3 , é o Divergência sem acesso
    else if (erro == 3) {

        alert("Divergencia entre a Nota de Entrada e a conferência wms!");
        $("fornguerra").value = '';
        $("comprador").value = '';
        $("deposito").value = '';
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
        document.forms[0].listsec.options.length = 1;
        idOpcao = document.getElementById("opcoes");
        idOpcao.innerHTML = "__";
        $("pcnumero").value = '';
        document.forms[0].pcnumero.focus();
        pos = 0;

    } else if (erro == 4) {
        if (confirm("Nota sem conferencia pelo wms, deseja continuar?\n\t"))
        {
            tabela = 'Processando ! aguarde ...';
            $("resultado").innerHTML = tabela;
            cancelar2();
            //Habilita o Botão
            document.getElementById('button').disabled = true;
            document.getElementById('pcnumero').disabled = true;
            document.forms[0].listsec.disabled = true;
        } else {
            $("fornguerra").value = '';
            $("comprador").value = '';
            $("deposito").value = '';
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
            document.forms[0].listsec.options.length = 1;
            idOpcao = document.getElementById("opcoes");
            idOpcao.innerHTML = "__";
            $("pcnumero").value = '';
            document.forms[0].pcnumero.focus();


            pos = 0;
        }
    }
    //Erro 5 - Divergência com Acesso
    else if (erro == 5) {

        if (confirm("Divergencia entre a Nota de Entrada e a conferência wms, deseja continuar?\n\t"))
        {
            tabela = 'Processando ! aguarde ...';
            $("resultado").innerHTML = tabela;
            cancelar2();
            //Habilita o Botão
            document.getElementById('button').disabled = true;
            document.getElementById('pcnumero').disabled = true;
            document.forms[0].listsec.disabled = true;
        } else {
            $("fornguerra").value = '';
            $("comprador").value = '';
            $("deposito").value = '';
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
            document.forms[0].listsec.options.length = 1;
            idOpcao = document.getElementById("opcoes");
            idOpcao.innerHTML = "__";
            $("pcnumero").value = '';
            document.forms[0].pcnumero.focus();
            pos = 0;
        }

    }

}

function cancelar() {



    var campopc = "";
    campopc = document.getElementById('pcnumero').value;
    if (campopc == "") {
        return;
    }

    if (confirm("Confirma a atualização de estoque ? Pedido " + document.getElementById('pcnumero').value + "-" + document.forms[0].listsec.options[document.forms[0].listsec.selectedIndex].value)) {
        cancelar2();
    } else {
        return;
    }

}

function cancelar2() {

    $("button").disabled = true;
    $("button2").disabled = true;

    let titulo = "PROCESSANDO, AGUARDE...";
    let mensagem = "ATUALIZANDO ESTOQUE DO PEDIDO!";

    $a("#retorno").messageBoxModal(titulo, mensagem);

    //Verifica se algum usuário já fez a atualização	
    new ajax('verificabaixaatualiza.php?pcnumero=' + document.getElementById('pcnumero').value
            + '&pcseq=' + document.forms[0].listsec.options[document.forms[0].listsec.selectedIndex].value
            , {onComplete: imprime_cancelar2});


}


function imprime_cancelar2(request)
{

    var xmldoc = request.responseXML;

    let jaatualizado = 0;

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
                jaatualizado = itens[0].firstChild.data;
            }
        }

    }

    if (jaatualizado == 1) {
        $a.unblockUI();
        alert("Baixa já atualizada por outro usuário !");
        limpar();
    } else {
        cancelar2ok();
    }

}


function cancelar2ok() {

    var campovet1 = ""
    var campovet2 = ""
    var campovet3 = ""
    var nota = document.getElementById('nota').value;

    for (var i = 0; i < 300; i++) {
        if (vet[i][0] != 0) {
            campovet1 = campovet1 + '&c[]=' + vet[i][0];
            campovet2 = campovet2 + '&d[]=' + vet[i][1];
            campovet3 = campovet3 + '&e[]=' + vet[i][2];
        }
    }

    //alert( campovet3 );

    var usuario = $("usuario").value;

    new ajax('pedcomprabaixaatualconf.php?' + campovet1
            //window.open('pedcomprabaixaatualconf.php?' + campovet1
            + '' + campovet2
            + '' + campovet3
            + '&pcnumero=' + document.getElementById('pcnumero').value
            + '&pcseq=' + document.forms[0].listsec.options[document.forms[0].listsec.selectedIndex].value
            + '&usuario=' + usuario,
            //'_blank');
                    {onComplete: imprimebaixa});



        }

function imprimebaixa(request) {

    var xmldoc = request.responseXML;

    if (xmldoc.getElementsByTagName('dados')[0] == null) {

        $a.unblockUI();
        alert('Problema com a atualizacao, favor tentar novamente !');
        limpar();

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
                    retorno = itens[0].firstChild.data;
            }
        }
        
        
        ok();
  
        /*
        new ajax('pedcomprabaixaatualimp.php?'
                + '&pcnumero=' + document.getElementById('pcnumero').value
                + '&pcseq=' + document.forms[0].listsec.options[document.forms[0].listsec.selectedIndex].value,
                {onComplete: ok()});
         * 
         */
        

    }






}

function ok() {

    var pcnumero = $("pcnumero").value;
    var pcseq = document.forms[0].listsec.options[document.forms[0].listsec.selectedIndex].value;
    var notax = $("nota").value;
    var seriex = $("notentserie").value;

    let titulo = "PROCESSANDO, AGUARDE...";
    let mensagem = "FAZENDO VERIFICAÇÃO DA MOVIMENTAÇÃO DE ESTOQUE!";

    $a("#retorno").messageBoxModal(titulo, mensagem);  

    dadosverifica(pcnumero, pcseq, notax, seriex);

}

function dadosverifica(pcnumero, pcseq, notax, seriex) {

    continua = 0;

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

        //ajax2.open("POST", "pedcomprabaixaatualizapesqmov.php", true);			
        ajax2.open("POST", "verificamovimentacaocompracorrige.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {

            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {

            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLverifica1(ajax2.responseXML, pcnumero, pcseq, notax, seriex);
                } else {                    
                    $a.unblockUI();
                    alert("Baixa Não Encontrada!");
                    limpar();
                }
            }
        }
        //passa o parametro              
        var params = "parametro=" + pcnumero + "&parametro2=" + pcseq;
        ajax2.send(params);
    }



}


function processXMLverifica1(obj, pcnumero, pcseq, notax, seriex) {

    continua = 0;

    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dados");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados


        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML

            var valor = item.getElementsByTagName("valor")[0].firstChild.nodeValue;

            if (valor == 2) {
                
                $a.unblockUI();
                alert("Baixa com problema na Movimentação! Avisar o Administrador!");
                limpar();
                
                continua = 1;
            }

        }


    } else {
        //caso o XML volte vazio o pedido não esta finalizado
        
        $a.unblockUI();
        alert("Pedido Não Encontrado!");
        limpar();
    }
    
    $a.unblockUI();

    if (continua == 0) {
       
        alert('Estoque Atualizado!');

        if (confirm("Imprime Baixa?\n\t")) {
            window.open('pedcompraimppdf3.php?pcnumero=' + pcnumero
                    + '&nota=' + notax
                    + '&serie=' + seriex
                    , '_blank');

        }
    } 

    limpar();

}



function ver3() {

    var pcnumero = $("pcnumero").value;

    trimjs(pcnumero);

    if (txt == '') {
        return;
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
        //deixa apenas o elemento 1 no option, os outros são excluídos

        document.forms[0].listsec.options.length = 1;
        idOpcao = document.getElementById("opcoes");

        ajax2.open("POST", "pedcomprabaixapesqnaoatual.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {

            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {

                idOpcao.innerHTML = "Carregando...!";

            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXML2(ajax2.responseXML);
                } else {
                    ///MOZILA
                    idOpcao.innerHTML = "__";
                    {
                        alert("Baixa não encontrada!");
                    }
                }
            }
        }

        //passa o parametro

        var params = "parametro=" + pcnumero;

        ajax2.send(params);

    }

}


function processXML2(obj) {


    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados
        document.forms[0].listsec.options.length = 0;

        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML

            var notentseqbaixa = item.getElementsByTagName("notentseqbaixa")[0].firstChild.nodeValue;
            trimjs(notentseqbaixa);
            if (txt == '0') {
                txt = '';
            }
            notentseqbaixa = txt;


            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes");
            //atribui um valor
            novo.value = notentseqbaixa;
            //atribui um texto
            novo.text = notentseqbaixa;

            //finalmente adiciona o novo elemento
            document.forms[0].listsec.options.add(novo);

            document.getElementById('pcnumero').disabled = true;
            document.getElementById('button_baixas').disabled = true;
            document.getElementById('button_pesquisa').disabled = false;

        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "__";
        {
            alert("Baixa não encontrada!");
        }
    }



}


function limpar() {
    window.open("pedcomprabaixaatualizanovo.php?", "_self");
}