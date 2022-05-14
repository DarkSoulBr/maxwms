

function imprimir() {

    var pcnumero = $("pcnumero").value;
    //var pcseq = $("pcseq").value;
    var pcseq = document.forms[0].listsec.options[document.forms[0].listsec.selectedIndex].value;

    window.open('pedcompraimppdf.php?pcnumero=' + pcnumero
            + '&pcseq=' + pcseq
            , 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');

    /*        
    if (confirm("Imprime Questionário?\n\t")) {

        window.open('pedcompraimppdfquest.php?pcnumero=' + pcnumero
                + '&pcseq=' + pcseq
                , 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');

    }
     * 
     */

}



function ver() {

    var pcnumero = $("pcnumero").value;
    //var pcseq = $("pcseq").value;
    var pcseq = document.forms[0].listsec.options[document.forms[0].listsec.selectedIndex].value;

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

        ajax2.open("POST", "pedcomprabaixacancpesq.php", true);
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

                }
            }
        }

        //passa o parametro

        var params = "parametro=" + pcnumero + '&parametro2=' + pcseq;

        ajax2.send(params);

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

            imprimir();

        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo

        if ($("pcnumero").value != '')
        {
            alert("Baixa não encontrada!");
            document.forms[0].pcnumero.focus();
        }


    }



}




function ver2() {

    var pcnumero = $("pcnumero").value;

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

        ajax2.open("POST", "pedcomprabaixacancpesq2.php", true);
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
            ;
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

        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "__";
        {
            alert("Baixa não encontrada!");
        }
    }



}



function excel() {

    var pcnumero = $("pcnumero").value;
    //var pcseq = $("pcseq").value;
    var pcseq = document.forms[0].listsec.options[document.forms[0].listsec.selectedIndex].value;

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

        ajax2.open("POST", "pedcomprabaixacancpesq.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {

            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {

            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processaXMLExcel(ajax2.responseXML);
                } else {

                    ///MOZILA
                    if ($("pcnumero").value != '')
                    {
                        alert("Baixa não encontrada!");
                    }

                }
            }
        }

        //passa o parametro

        var params = "parametro=" + pcnumero + '&parametro2=' + pcseq;

        ajax2.send(params);

    }

}


function processaXMLExcel(obj) {


    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados


        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML

            geraexcel();

        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo

        if ($("pcnumero").value != '')
        {
            alert("Baixa não encontrada!");
            document.forms[0].pcnumero.focus();
        }


    }



}

function geraexcel() {

    var pcnumero = $("pcnumero").value;
    var pcseq = document.forms[0].listsec.options[document.forms[0].listsec.selectedIndex].value;

    window.open('relatoriogerabaixaexcel.php?pcnumero=' + pcnumero + '&pcseq=' + pcseq, 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');
 

}   