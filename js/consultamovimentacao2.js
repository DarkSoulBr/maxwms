// JavaScript Document
//window.onload=dadospesquisaconferente;

//confere=0;
//codigoproduto=0;
//estoque=0;
//pvcconfere=0;

var depositox;

dtiniciox = '';

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


function pesquisacodigo(valor) {

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
        ajax2.open("POST", "conferenciapesquisacodigo.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax2.onreadystatechange = function () {
            if (ajax2.readyState == 1) {
            }
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLcodigo(ajax2.responseXML, valor);
                } else {
                }
            }
        }
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}
function processXMLcodigo(obj, valor) {

    var dataArray = obj.getElementsByTagName("dado");
    if (dataArray.length > 0) {

        document.forms[0].pesquisaproduto.options.length = 0;

        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            var cod = item.getElementsByTagName("cod")[0].firstChild.nodeValue;
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
            document.getElementById("codigoproduto").value = codigo;
            document.getElementById("produto").value = descricao;


            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes");
            //atribui um valor
            novo.value = cod;
            //atribui um texto
            novo.text = descricao;
            //finalmente adiciona o novo elemento
            document.forms[0].pesquisaproduto.options.add(novo);


        }
    } else {

    }


}



function pesquisaprodutos(valor) {
    if (valor != "") {

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

            document.forms[0].pesquisaproduto.options.length = 1;
            idOpcao = document.getElementById("pesquisaproduto");

            ajax2.open("POST", "conferenciapesquisaproduto.php", true);
            ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            ajax2.onreadystatechange = function () {
                if (ajax2.readyState == 1) {
                    idOpcao.innerHTML = "Carregando...!";
                }
                if (ajax2.readyState == 4) {
                    if (ajax2.responseXML) {
                        processXMLproduto(ajax2.responseXML, valor);
                    } else {
                        idOpcao.innerHTML = "__________________________________________________";
                    }
                }
            }
            var params = "parametro=" + valor;
            ajax2.send(params);
        }
    }
}

function processXMLproduto(obj, valor) {


    var dataArray = obj.getElementsByTagName("dado");
    if (dataArray.length > 0) {

        document.forms[0].pesquisaproduto.options.length = 0;

        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];

            var cod = item.getElementsByTagName("cod")[0].firstChild.nodeValue;
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes");
            //atribui um valor
            novo.value = cod;
            //atribui um texto
            novo.text = descricao;
            //finalmente adiciona o novo elemento
            document.forms[0].pesquisaproduto.options.add(novo);

            if (i == 0) {
                document.getElementById("codigoproduto").value = codigo;
                document.getElementById("produto").value = descricao;

            }

        }
        if (dataArray.length == 1) {

        }
    } else {

    }


}






function dadospesquisapertence(valor) {

    //verifica se o browser tem suporte a ajax
    trimjs(valor);
    if (txt != '') {

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

            ajax2.open("POST", "consultamovimentacaopesquisacod.php", true);
            ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            ajax2.onreadystatechange = function () {

                //enquanto estiver processando...emite a msg de carregando
                if (ajax2.readyState == 1) {
                }
                //após ser processado - chama função processXML que vai varrer os dados
                if (ajax2.readyState == 4) {
                    if (ajax2.responseXML) {
                        processXMLpertence(ajax2.responseXML);
                    } else {
                        //caso não seja um arquivo XML emite a mensagem abaixo

                        alert("Produto não encontrado!");
                        document.getElementById("codigoproduto").value = '';
                        document.forms[0].codigoproduto.focus();

                    }
                }
            }
            //passa o parametro


            var params = "parametro=" + valor;

            ajax2.send(params);
        }
    }



}




function processXMLpertence(obj) {
    //pega a tag dado
    valor = document.getElementById("codigoproduto").value;

    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {

        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            var codigo = item.getElementsByTagName("procod")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("prnome")[0].firstChild.nodeValue;

            trimjs(descricao);

            document.getElementById("codigoproduto").value = codigo;
            document.getElementById("produto").value = txt;
        }

    } else {

        alert("Produto não encontrado!");
        document.getElementById("codigoproduto").value = '';
        document.forms[0].codigoproduto.focus();

    }

}




function pesquisacod(valor) {


    //verifica se o browser tem suporte a ajax
    trimjs(valor);
    if (txt != '') {

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

            ajax2.open("POST", "consultamovimentacaopesquisacod2.php", true);
            ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            ajax2.onreadystatechange = function () {

                //enquanto estiver processando...emite a msg de carregando
                if (ajax2.readyState == 1) {
                }
                //após ser processado - chama função processXML que vai varrer os dados
                if (ajax2.readyState == 4) {
                    if (ajax2.responseXML) {
                        processXMLcod(ajax2.responseXML);
                    } else {
                        //caso não seja um arquivo XML emite a mensagem abaixo

                        alert("Produto não encontrado!");
                        document.getElementById("codigoproduto").value = '';
                        document.forms[0].codigoproduto.focus();

                    }
                }
            }
            //passa o parametro


            var params = "parametro=" + valor;

            ajax2.send(params);
        }
    }



}




function processXMLcod(obj) {
    //pega a tag dado
    valor = document.getElementById("codigoproduto").value;

    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {

        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            var codigo = item.getElementsByTagName("procod")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("prnome")[0].firstChild.nodeValue;

            trimjs(descricao);

            document.getElementById("codigoproduto").value = codigo;
            document.getElementById("produto").value = txt;
        }

    } else {

        alert("Produto não encontrado!");
        document.getElementById("codigoproduto").value = '';
        document.forms[0].codigoproduto.focus();

    }

}


function cons() {

    var codigoproduto = document.getElementById("codigoproduto").value;
    var produto = document.getElementById("produto").value;

    var dtinicio = document.getElementById("dataini").value;

    var dtfinal = document.getElementById("datafim").value;

    var deposito = document.forms[0].deposito.options[document.forms[0].deposito.selectedIndex].value;

    var deposito2 = document.forms[0].deposito.options[document.forms[0].deposito.selectedIndex].text;


    load_grid(codigoproduto, dtinicio, dtfinal, deposito);

}


function load_grid(codigoproduto, dtinicio, dtfinal, deposito) {

    dtiniciox = dtinicio;

    depositox = deposito;

    titulo = "PROCESSANDO, AGUARDE...";
    mensagem = "EXECUTANDO PESQUISA DA MOVIMENTACAO.";

    $("#retorno").messageBoxModal(titulo, mensagem);

    //window.open ('consultamovimentacaocodprod2.php?codigoproduto=' + codigoproduto +
    new ajax('consultamovimentacaocodprod2.php?codigoproduto=' + codigoproduto +
            '&dtinicio=' + dtinicio +
            '&dtfinal=' + dtfinal +
            '&deposito=' + deposito
            , {onLoading: carregando, onComplete: imprime});
    //, '_blank');

}

function carregando() {

}

function imprime(request) {

    var inicio = dtiniciox.substring(6, 10) + dtiniciox.substring(3, 5) + dtiniciox.substring(0, 2);


    var xmldoc = request.responseXML;
    var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];
    if (cabecalho != null)
    {

        var tabela = "<table width='716' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' bgcolor='#CCCCCC' ><tr>"
        tabela += "<td width='85' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Pedido</b></td>";
        tabela += "<td width='85' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>NFe</b></td>";
        tabela += "<td width='85' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Local</b></td>";
        tabela += "<td width='81' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Emissao</b></td>";
        tabela += "<td width='81' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Data</b></td>";
        tabela += "<td width='60' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><div align='right'><b>Entrada&nbsp;</b></div></td>";
        tabela += "<td width='60' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><div align='right'><b>Saida&nbsp;</b></div></td>";
        tabela += "<td width='99' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><div align='right'><b>Valor&nbsp;</b></div></td>";
        tabela += "<td width='80' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><div align='right'><b>Saldo&nbsp;</b></div></td>";

        //corpo da tabela
        var registros = xmldoc.getElementsByTagName('registro');

        var saldo = 0;
        var val = 0;

        var data = '';
        var primeiro = 0;

        for (i = 0; i < registros.length; i++) {
            var itens = registros[i].getElementsByTagName('item');

            data = itens[1].firstChild.data.substring(6, 10) + itens[1].firstChild.data.substring(3, 5) + itens[1].firstChild.data.substring(0, 2);

            if (data >= inicio) {
                if (primeiro == 0) {
                    //alert(saldo);
                    tabela += "<tr id=linha" + i + ">";
                    tabela += "<td class='borda'>Saldo Inicial</td>";
                    tabela += "<td class='borda'>&nbsp;</td>";
                    tabela += "<td class='borda'>&nbsp;</td>";
                    tabela += "<td class='borda'>&nbsp;</td>";
                    tabela += "<td class='borda'>" + dtiniciox + "</td>";
                    tabela += "<td class='borda'>&nbsp;</td>";
                    tabela += "<td class='borda'>&nbsp;</td>";
                    tabela += "<td class='borda'>&nbsp;</td>";
                    tabela += "<td class='borda'><div align='right'>" + saldo + "&nbsp;</div></td>";

                }
                primeiro = 1;
                tabela += "<tr id=linha" + i + ">"
                for (j = 0; j < itens.length - 4; j++) {

                    if (itens[j].firstChild == null && j != 5 && itens[4].firstChild.data != 1) {
                        tabela += "<td class='borda'><a href=\"\">" + 0 + "</a></td>";
                    } else {
                        if (j != 4) {
                            if (j == 0) {
                                if (itens[4].firstChild.data == 1) {
                                    tabela += "<td class='borda'>Inventário</td>";
                                } else if (itens[4].firstChild.data != 2) {
                                    //Não tem opção de link para lançamentos da Toymania
                                    tabela += "<td class='borda'>" + itens[j].firstChild.data + "</td>";
                                    
                                    /*
                                    if (itens[10].firstChild.data == 2) {
                                        tabela += "<td class='borda'>" + itens[j].firstChild.data + "</td>";
                                    } else {
                                        if (itens[5].firstChild == null) {
                                            tabela += "<td class='borda'><a href=\"javascript:;\" onclick=\"window.open('pedvendaconsx.php?flagmenu=9&codped=" + itens[j].firstChild.data + "','nome','location=no,scrollbars=yes,directories=yes,status=yes,menubar=yes,toolbar=yes,resizable=yes,fullscreen=yes');\">" + itens[j].firstChild.data + "</a></td>";
                                        } else
                                        {
                                            tabela += "<td class='borda'><a href=\"javascript:;\" onclick=\"window.open('pedvendaconsx.php?flagmenu=9&codped=" + itens[j].firstChild.data + "','nome','location=no,scrollbars=yes,directories=yes,status=yes,menubar=yes,toolbar=yes,resizable=yes,fullscreen=yes');\">" + itens[j].firstChild.data + ' ' + itens[5].firstChild.data + "</a></td>";
                                        }
                                    }
                                     * 
                                     */
                                } else {
                                    
                                    tabela += "<td class='borda'>" + itens[j].firstChild.data + "</td>";
                                    
                                    /*
                                    //Não tem opção de link para lançamentos da Toymania
                                    if (itens[10].firstChild.data != 2) {
                                    
                                        //Se tiver o traço significa que é compras
                                        if (itens[j].firstChild.data.substring(itens[j].firstChild.data.length - 2, itens[j].firstChild.data.length - 1) == '-') {
                                            tabela += "<td class='borda' ><a href=\"javascript:;\" onclick=\"window.open('pedcompraconsbaixa.php?pcnumero=" + itens[j].firstChild.data.substring(0, itens[j].firstChild.data.length - 2) + "&pcseq=" + itens[j].firstChild.data.substring(itens[j].firstChild.data.length - 1, itens[j].firstChild.data.length) + "','Consulta de Pedido','location=no,scrollbars=yes,directories=yes,status=yes,menubar=yes,toolbar=yes,resizable=yes,fullscreen=yes');\">" + itens[j].firstChild.data + "</a></td>";
                                        } else if (itens[j].firstChild.data.substring(itens[j].firstChild.data.length - 3, itens[j].firstChild.data.length - 2) == '-') {
                                            //Se for Nota de Devolucao por enquanto fica sem link
                                            if (itens[j].firstChild.data.substring(itens[j].firstChild.data.length - 2, itens[j].firstChild.data.length) == 'ND') {
                                                tabela += "<td class='borda'>" + itens[j].firstChild.data + "</td>";
                                            } else {
                                                tabela += "<td class='borda' ><a href=\"javascript:;\" onclick=\"window.open('pedcompraconsbaixa.php?pcnumero=" + itens[j].firstChild.data.substring(0, itens[j].firstChild.data.length - 3) + "&pcseq=" + itens[j].firstChild.data.substring(itens[j].firstChild.data.length - 2, itens[j].firstChild.data.length) + "','Consulta de Pedido','location=no,scrollbars=yes,directories=yes,status=yes,menubar=yes,toolbar=yes,resizable=yes,fullscreen=yes');\">" + itens[j].firstChild.data + "</a></td>";
                                            }

                                        } else
                                        {
                                            if (itens[j].firstChild.data == 'AJ.AUTO.') {
                                                tabela += "<td class='borda'>" + itens[j].firstChild.data + "</td>";
                                            } else {
                                                tabela += "<td class='borda' ><a href=\"javascript:;\" onclick=\"window.open('pedvendaconsx.php?flagmenu=9&codped=" + itens[j].firstChild.data + "','nome','location=no,scrollbars=yes,directories=yes,status=yes,menubar=yes,toolbar=yes,resizable=yes,fullscreen=yes');\">" + itens[j].firstChild.data + "</a></td>";
                                            }
                                        }
                                    } else {                                        
                                        tabela += "<td class='borda'>" + itens[j].firstChild.data + "</td>";
                                    }
                                     * 
                                     */

                                }
                            } else if (j > 0 && j < 2) {
                                if (itens[7].firstChild == null) {
                                    tabela += "<td class='borda'>&nbsp;</td>";
                                    tabela += "<td class='borda'>&nbsp;</td>";
                                    tabela += "<td class='borda'>&nbsp;</td>";
                                } else {
                                    
                                    tabela += "<td class='borda'>" + itens[7].firstChild.data + "</td>";
                                    
                                    /*
                                    //So tem opção de link para lançamentos da Toymania
                                    if (itens[10].firstChild.data != 2) {
                                    
                                        if (itens[8].firstChild == null) {
                                            tabela += "<td class='borda'>" + itens[7].firstChild.data + "</td>";
                                        } else if (itens[8].firstChild.data == 'GRU') {
                                            tabela += "<td class='borda' ><a href=\"javascript:;\" onclick=\"notas('" + itens[7].firstChild.data + "','26');\">" + itens[7].firstChild.data + "</a></td>";
                                        } else if (itens[8].firstChild.data == 'GRE') {
                                            tabela += "<td class='borda' ><a href=\"javascript:;\" onclick=\"notas('" + itens[7].firstChild.data + "','9');\">" + itens[7].firstChild.data + "</a></td>";
                                        } else if (itens[8].firstChild.data == 'VIX') {
                                            tabela += "<td class='borda' ><a href=\"javascript:;\" onclick=\"notas('" + itens[7].firstChild.data + "','11');\">" + itens[7].firstChild.data + "</a></td>";
                                        } else if (itens[8].firstChild.data == 'MAT') {
                                            tabela += "<td class='borda' ><a href=\"javascript:;\" onclick=\"notas('" + itens[7].firstChild.data + "','2');\">" + itens[7].firstChild.data + "</a></td>";
                                        } else if (itens[8].firstChild.data == 'FIL') {
                                            tabela += "<td class='borda' ><a href=\"javascript:;\" onclick=\"notas('" + itens[7].firstChild.data + "','1');\">" + itens[7].firstChild.data + "</a></td>";
                                        } else {
                                            tabela += "<td class='borda'>" + itens[7].firstChild.data + "</td>";
                                        }
                                    } else {
                                        tabela += "<td class='borda'>" + itens[7].firstChild.data + "</td>";   
                                    }   
                                     * 
                                     */                                     
                                        
                                    if (itens[8].firstChild == null) {
                                        tabela += "<td class='borda'>&nbsp;</td>";
                                    } else {
                                        tabela += "<td class='borda'>" + itens[8].firstChild.data + "</td>";
                                    }
                                    if (itens[9].firstChild == null) {
                                        tabela += "<td class='borda'>&nbsp;</td>";
                                    } else {
                                        tabela += "<td class='borda'>" + itens[9].firstChild.data + "</td>";
                                    }
                                   
                                    
                                }
                                tabela += "<td class='borda'>" + itens[j].firstChild.data + "</td>";
                            } else if (j == 2) {
                                if (itens[4].firstChild.data == 2) {
                                    tabela += "<td class='borda'><div align='right'>&nbsp;</div></td>";
                                    tabela += "<td class='borda'><div align='right'>" + itens[j].firstChild.data + "&nbsp;</div></td>";
                                } else if (itens[4].firstChild.data == 4) {
                                    tabela += "<td class='borda'><div align='right'>&nbsp;</div></td>";
                                    tabela += "<td class='borda'><div align='right'>" + itens[j].firstChild.data + "&nbsp;</div></td>";
                                } else {
                                    tabela += "<td class='borda'><div align='right'>" + itens[j].firstChild.data + "&nbsp;</div></td>";
                                    tabela += "<td class='borda'><div align='right'>&nbsp;</div></td>";
                                }
                            } else if (j == 3) {
                                var rnum = itens[j].firstChild.data;
                                rnum = deci(rnum);
                                tabela += "<td class='borda'><div align='right'>" + rnum + "&nbsp;</div></td>";
                            }
                            // else{
                            //    tabela+="<td class='borda'><div align='right'>"+itens[j].firstChild.data+"&nbsp;</div></td>";
                            // }
                        } else if (j == 4) {
                            if (itens[4].firstChild.data == 1) {
                                val = parseInt(itens[2].firstChild.data);
                                saldo = val;
                            } else if (itens[4].firstChild.data == 2) {
                                val = parseInt(itens[2].firstChild.data);
                                saldo = saldo - val;
                            } else if (itens[4].firstChild.data == 3) {
                                val = parseInt(itens[2].firstChild.data);
                                saldo = saldo + val;
                            } else if (itens[4].firstChild.data == 4) {
                                val = parseInt(itens[2].firstChild.data);
                                saldo = saldo - val;
                            }

                            tabela += "<td class='borda'><div align='right'>" + saldo + "&nbsp;</div></td>";
                        }
                    }
                }
                tabela += "</tr>";

            } else
            {

                for (j = 0; j < itens.length; j++) {

                    if (j == 4) {
                        if (itens[4].firstChild.data == 1) {
                            val = parseInt(itens[2].firstChild.data);
                            saldo = val;
                        } else if (itens[4].firstChild.data == 2) {
                            val = parseInt(itens[2].firstChild.data);
                            saldo = saldo - val;
                        } else if (itens[4].firstChild.data == 3) {
                            val = parseInt(itens[2].firstChild.data);
                            saldo = saldo + val;
                        } else if (itens[4].firstChild.data == 4) {
                            val = parseInt(itens[2].firstChild.data);
                            saldo = saldo - val;
                        }

                    }

                }


            }

        }

        tabela += "</table>"


        tabela += "</tr>"

        document.getElementById("resultado").innerHTML = tabela;
        tabela = null;

        //dadospesquisadeposito2(depositox,0);

    } else
        document.getElementById("resultado").innerHTML = "Nenhum registro encontrado...";

    $.unblockUI();

}

function imp() {


    var codigoproduto = document.getElementById("codigoproduto").value;
    var produto = document.getElementById("produto").value;

    var dtinicio = document.getElementById("dataini").value;

    var dtfinal = document.getElementById("datafim").value;

    var deposito = document.forms[0].deposito.options[document.forms[0].deposito.selectedIndex].value;

    var deposito2 = document.forms[0].deposito.options[document.forms[0].deposito.selectedIndex].text;


    window.open('consultamovimentacaopdf2.php?codigoproduto=' + codigoproduto
            + '&produto=' + produto
            + '&dtinicio=' + dtinicio
            + '&dtfinal=' + dtfinal
            + '&deposito=' + deposito
            + '&deposito2=' + deposito2
            , 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');


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

}



function dadospesquisadeposito2(valor, tipo) {


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

        ajax2.open("POST", "pesquisadeposito.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {

            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {

                    processXMLdeposito2(ajax2.responseXML, tipo);
                } else {

                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }

}



function processXMLdeposito2(obj, tipo) {
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

            $("resultado0").innerHTML = descricao;

        }
    } else {


    }

}

function notas(notnumero, estoque) {
    var winl = (screen.width - 650) / 2;
    window
            .open(
                    "pedconsnotasconsulta.php?nota=" + notnumero + "&estoque="
                    + estoque,
                    "Notas",
                    'height=540,width=680,top=25,left=' + winl + ',scrollbars=yes,resizable=no');
}





function excel() {


    var codigoproduto = document.getElementById("codigoproduto").value;
    var produto = document.getElementById("codigoproduto").value;

    var dtinicio = document.getElementById("dataini").value;

    var dtfinal = document.getElementById("datafim").value;

    var deposito = document.forms[0].deposito.options[document.forms[0].deposito.selectedIndex].value;

    var deposito2 = document.forms[0].deposito.options[document.forms[0].deposito.selectedIndex].text;


    window.open('consultamovimentacaoexcel.php?codigoproduto=' + codigoproduto
            + '&produto=' + produto
            + '&dtinicio=' + dtinicio
            + '&dtfinal=' + dtfinal
            + '&deposito=' + deposito
            + '&deposito2=' + deposito2
            , 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');


}

$(function () {

    // Validar formulario ao clicar botao


    var dataHoje = new Date();
    var dataMin;



    $("#dataini").datepicker({changeYear: true,
        onSelect: function (dateText, inst)
        {
            dataMin = new Date().dateBr(dateText);

            $("#datafim").attr("disabled", "");
            $("#datafim").datepicker('destroy');
            $("#datafim").datepicker({changeYear: true});
        }
    })
            ;


    $("#dataini").date();
    $("#dataini").val($.mask.string(dataHoje.format('dmY'), 'date'));



    $("#datafim").attr("disabled", "");
    $("#datafim").date();
    $("#datafim").val($.mask.string(dataHoje.format('dmY'), 'date'));

    $("#datafim").datepicker('destroy');
    $("#datafim").datepicker({changeYear: true});


});


function consultar() {

    var codigoproduto = document.getElementById("codigoproduto").value;
    var produto = document.getElementById("produto").value;

    var dtinicio = document.getElementById("dataini").value;

    var dtfinal = document.getElementById("datafim").value;

    var deposito = document.forms[0].deposito.options[document.forms[0].deposito.selectedIndex].value;

    var deposito2 = document.forms[0].deposito.options[document.forms[0].deposito.selectedIndex].text;


    load_grid_novo(codigoproduto, dtinicio, dtfinal, deposito);

}


function load_grid_novo(codigoproduto, dtinicio, dtfinal, deposito) {

    dtiniciox = dtinicio;

    depositox = deposito;

    titulo = "PROCESSANDO, AGUARDE...";
    mensagem = "EXECUTANDO PESQUISA DA MOVIMENTACAO.";

    $("#retorno").messageBoxModal(titulo, mensagem);


    new ajax('consultamovimentacaocodprodnovo.php?codigoproduto=' + codigoproduto +
            '&dtinicio=' + dtinicio +
            '&dtfinal=' + dtfinal +
            '&deposito=' + deposito
            , {onLoading: carregando, onComplete: imprime});



}


function formatar_fun(documento) {

    var aux = documento.value;
    var mascara = "";
    if(aux.substring(0,1)=='f' || aux.substring(0,1)=='F') {
        mascara = "#####-#";
    } else {
        mascara = "####-#";
    }

    var i = documento.value.length;    
    var saida = mascara.substring(0, 1);
    var texto = mascara.substring(i)

    if (texto.substring(0, 1) != saida) {
        documento.value += texto.substring(0, 1);
    }

}