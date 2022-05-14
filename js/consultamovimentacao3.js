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
            $("codigoproduto").value = codigo;
            $("produto").value = descricao;


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
                $("codigoproduto").value = codigo;
                $("produto").value = descricao;

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
                        $("codigoproduto").value = '';
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

            $("codigoproduto").value = codigo;
            $("produto").value = txt;
        }

    } else {

        alert("Produto não encontrado!");
        $("codigoproduto").value = '';
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
                        $("codigoproduto").value = '';
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

            $("codigoproduto").value = codigo;
            $("produto").value = txt;
        }

    } else {

        alert("Produto não encontrado!");
        $("codigoproduto").value = '';
        document.forms[0].codigoproduto.focus();

    }

}





function load_grid(codigoproduto, dtinicio, dtfinal, deposito) {

    dtiniciox = dtinicio;

    depositox = deposito;

    //window.open('consultamovimentacaocodprod3.php?codigoproduto=' + codigoproduto +
    new ajax('consultamovimentacaocodprod3.php?codigoproduto=' + codigoproduto +
            '&dtinicio=' + dtinicio +
            '&dtfinal=' + dtfinal +
            '&deposito=' + deposito
            , {onLoading: carregando, onComplete: imprime});
    //, '_blank');

}

function carregando() {
    $("msg").style.visibility = "visible";
    $("msg").innerHTML = "Processando...";
}

function imprime(request) {

    var inicio = dtiniciox.substring(6, 10) + dtiniciox.substring(3, 5) + dtiniciox.substring(0, 2);

    //alert(inicio);

    $("msg").style.visibility = "hidden";
    var xmldoc = request.responseXML;
    var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];
    if (cabecalho != null)
    {
        
        var tabela = "<div class='limiter'>"
        tabela += "<div class='container-table100'>"
        tabela += "<div class='wrap-table100'>"
        tabela += "<div class='table-max'>"
        tabela += "<div class='row-max header'>"
        tabela += "<div class='cell-max'>Descrição</div>"
        tabela += "<div class='cell-max'>Data</div>"
        tabela += "<div class='cell-max'>Entrada</div>"
        tabela += "<div class='cell-max'>Saída</div>"        
        tabela += "<div class='cell-max'>Saldo</div>"        
        tabela += "</div>"

        //corpo da tabela
        var registros = xmldoc.getElementsByTagName('registro');

        var saldo = 0;
        var saldodiae = 0;
        var saldodias = 0;
        var val = 0;

        var data = '';
        var data2 = '';
        var data2x = '';
        var primeiro = 0;

        for (i = 0; i < registros.length; i++) {
            var itens = registros[i].getElementsByTagName('item');

            data = itens[1].firstChild.data.substring(6, 10) + itens[1].firstChild.data.substring(3, 5) + itens[1].firstChild.data.substring(0, 2);

            if (data >= inicio) {
                if (primeiro == 0) {
                    
                    tabela += "<div class='row-max'>"                    
                    tabela += "<div class='cell-max' data-title='Descrição'>Saldo Inicial</div>"
                    tabela += "<div class='cell-max' data-title='Data'>&nbsp;</div>"
                    tabela += "<div class='cell-max' data-title='Entrada'>&nbsp;</div>"
                    tabela += "<div class='cell-max' data-title='Saída'>&nbsp;</div>"
                    tabela += "<div class='cell-max' data-title='Saldo'>" + saldo + "</div>"
                    tabela += "</div>"

                }

                if ((data != data2) && (primeiro == 1)) {
                    
                    tabela += "<div class='row-max'>"                    
                    tabela += "<div class='cell-max' data-title='Descrição'>&nbsp;</div>"
                    tabela += "<div class='cell-max' data-title='Data'>" + data2x + "</div>"
                    tabela += "<div class='cell-max' data-title='Entrada'>" + saldodiae + "</div>"
                    tabela += "<div class='cell-max' data-title='Saída'>" + saldodias + "</div>"
                    tabela += "<div class='cell-max' data-title='Saldo'>" + saldo + "</div>"
                    tabela += "</div>"

                    saldodiae = 0;
                    saldodias = 0;

                }


                if (itens[4].firstChild.data == 1) {
                    val = parseInt(itens[2].firstChild.data);
                    saldo = val;
                    saldodiae = val;
                    
                    tabela += "<div class='row-max'>"                    
                    tabela += "<div class='cell-max' data-title='Descrição'>Inventário</div>"
                    tabela += "<div class='cell-max' data-title='Data'>" + itens[1].firstChild.data + "</div>"
                    tabela += "<div class='cell-max' data-title='Entrada'>" + saldodiae + "</div>"
                    tabela += "<div class='cell-max' data-title='Saída'>" + 0 + "</div>"
                    tabela += "<div class='cell-max' data-title='Saldo'>" + saldo + "</div>"
                    tabela += "</div>"

                    saldodiae = 0;
                    saldodias = 0;

                } else if (itens[4].firstChild.data == 2) {
                    val = parseInt(itens[2].firstChild.data);
                    saldo = saldo - val;
                    saldodias = saldodias + val;
                } else if (itens[4].firstChild.data == 3) {
                    val = parseInt(itens[2].firstChild.data);
                    saldo = saldo + val;
                    saldodiae = saldodiae + val;
                } else if (itens[4].firstChild.data == 4) {
                    val = parseInt(itens[2].firstChild.data);
                    saldo = saldo - val;
                    saldodias = saldodias + val;
                }


                primeiro = 1;
                data2 = itens[1].firstChild.data.substring(6, 10) + itens[1].firstChild.data.substring(3, 5) + itens[1].firstChild.data.substring(0, 2);
                data2x = itens[1].firstChild.data;
            } else
            {

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
        
        tabela += "<div class='row-max'>"                    
        tabela += "<div class='cell-max' data-title='Descrição'>&nbsp;</div>"
        tabela += "<div class='cell-max' data-title='Data'>" + data2x + "</div>"
        tabela += "<div class='cell-max' data-title='Entrada'>" + saldodiae + "</div>"
        tabela += "<div class='cell-max' data-title='Saída'>" + saldodias + "</div>"
        tabela += "<div class='cell-max' data-title='Saldo'>" + saldo + "</div>"
        tabela += "</div>"

        resultado += "</div>"
        resultado += "</div>"
        resultado += "</div>"
        resultado += "</div>"

        $("resultado").innerHTML = tabela;
        tabela = null;

        //dadospesquisadeposito2(depositox, 0);
    } else
        $("resultado").innerHTML = "Nenhum registro encontrado...";
    
    $a.unblockUI();
}

function consultar() {

    var codigoproduto = document.getElementById("codigoproduto").value;

    var dtinicio = document.getElementById("dtinicio").value;

    var dtfinal = document.getElementById("dtfinal").value;

    var deposito = document.forms[0].deposito.options[document.forms[0].deposito.selectedIndex].value;

    load_grid_novo(codigoproduto, dtinicio, dtfinal, deposito);

}


function load_grid_novo(codigoproduto, dtinicio, dtfinal, deposito) {

    dtiniciox = dtinicio;

    depositox = deposito;

    titulo = "PROCESSANDO, AGUARDE...";
    mensagem = "EXECUTANDO PESQUISA DA MOVIMENTACAO.";

    $a("#retorno").messageBoxModal(titulo, mensagem);
    
    new ajax('consultamovimentacaocodprod3.php?codigoproduto=' + codigoproduto +
            '&dtinicio=' + dtinicio +
            '&dtfinal=' + dtfinal +
            '&deposito=' + deposito
            , {onLoading: carregando, onComplete: imprime});
    

}

function imp() {

    var codigoproduto = $("codigoproduto").value;
    var produto = $("produto").value;
    var dtinicio = $("dtinicio").value;
    var dtfinal = $("dtfinal").value;

    var deposito = document.forms[0].deposito.options[document.forms[0].deposito.selectedIndex].value;

    var deposito2 = document.forms[0].deposito.options[document.forms[0].deposito.selectedIndex].text;

    window.open('consultamovimentacaopdf3.php?codigoproduto=' + codigoproduto
            + '&produto=' + produto
            + '&dtinicio=' + dtinicio
            + '&dtfinal=' + dtfinal
            + '&deposito=' + deposito
            + '&deposito2=' + deposito2
            , 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');


}



function dadospesquisadeposito(valor, tipo) {

    document.getElementById('codigoproduto').focus();

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

function formata_data(obj)
{
    obj.value = obj.value.replace("//", "/");
    tam = obj.value;

    if (tam.length == 2 || tam.length == 5)
        obj.value = obj.value + "/";
}