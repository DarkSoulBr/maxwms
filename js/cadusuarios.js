// JavaScript Document 
function enviar() {

    valor = document.getElementById('descricao').value;

    if ($("acao").value == "inserir") {

        new ajax('cadusuariosinsere.php?descricao=' + document.getElementById('descricao').value
                + '&usuario=' + 0
                + '&login=' + document.getElementById('descricao2').value
                + '&senha=' + document.getElementById('descricao3').value
                + '&email=' + document.getElementById('email').value
                , {});

        alert("Incluido com sucesso!");

        limpa_form();
        dadospesquisa3(valor);

    } else if ($("acao").value == "alterar") {
        new ajax('cadusuariosaltera.php?descricao=' + document.getElementById('descricao').value + "&codigo=" + document.getElementById('codigo').value
                + '&usuario=' + 0
                + '&login=' + document.getElementById('descricao2').value
                + '&email=' + document.getElementById('email').value
                , {});

        document.forms[0].listDados.options.length = 0;

        var novo = document.createElement("option");
        //atribui um ID a esse elemento
        novo.setAttribute("id", "opcoes");
        //atribui um valor
        novo.value = document.getElementById('codigo').value;
        //atribui um texto
        novo.text = document.getElementById('descricao').value;
        //finalmente adiciona o novo elemento
        document.forms[0].listDados.options.add(novo);

        alert("Alterado com sucesso!");

    }
}

function apagar(codigo) {
    new ajax('cadusuariosapaga.php?codigo=' + codigo, {});
    limpa_form();
}

function valida_form() {

    if ($("descricao").value == "") {
        alert("Preencha o campo Nome do Usuário")
        return false;
    }

    if ($("descricao2").value == "") {
        alert("Preencha o campo Login")
        return false;
    }

    if ($("email").value == "") {
        alert("Preencha o campo E-Mail")
        return false;
    }

    if ($("acao").value == "inserir") {

        if ($("descricao3").value == "") {
            alert("Preencha o campo Senha")
            return false;
        }

        if ($("descricao3").value == $("descricao4").value) {
        } else {
            alert("Senha não confere")
            return false;
        }

    }


    enviar();

}



function limpa_form() {
    $("acao").value = "inserir";
    document.getElementById("botao-text").innerHTML = "Incluir";
    $("codigo").value = "";
    $("descricao").value = "";

    $("descricao2").value = "";
    $("descricao3").value = "";
    $("descricao4").value = "";
    $("email").value = "";

    $("pesquisa").value = "";

    $("descricao3").disabled = false;
    $("descricao4").disabled = false;

    document.forms[0].listDados.options.length = 1;
    if (document.querySelector('#opcoes')){
        idOpcao = document.getElementById("opcoes");
        idOpcao.innerHTML = "Faça a pesquisa do Usuário";
    }


}

function limpa_form2() {
    $("acao").value = "inserir";
    document.getElementById("botao-text").innerHTML = "Incluir";
    $("codigo").value = "";
    $("descricao").value = "";
    $("descricao2").value = "";
    $("descricao3").value = "";
    $("descricao4").value = "";

    $("descricao3").disabled = false;
    $("descricao4").disabled = false;

    $("email").value = "";


}

function verifica1() {
    if (confirm("Tem certeza que deseja Excluir?\n\t")) {
        apagar($("codigo").value);
    }
}

function verifica() {
    if ($("codigo").value == "") {
        alert("Nenhum Registro Selecionado!");
    } else {
        verifica1();
    }
}


function dadospesquisa(valor) {
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
        document.forms[0].listDados.options.length = 1;

        idOpcao = document.getElementById("opcoes");

        ajax2.open("POST", "cadusuariospesquisa.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {

            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXML(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "Faça a pesquisa do Usuário";
                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}


function dadospesquisa2(valor) {
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

        ajax2.open("POST", "cadusuariospesquisa2.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {

            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXML2(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo

                }
            }
        }
        //passa o parametro escolhido
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}


function dadospesquisa3(valor) {
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
        document.forms[0].listDados.options.length = 1;

        idOpcao = document.getElementById("opcoes");

        ajax2.open("POST", "cadusuariospesquisa3.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXML(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "Faça a pesquisa do Usuário";
                }
            }
        }
        //passa o parametro escolhido
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}



function processXML(obj) {
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados

        document.forms[0].listDados.options.length = 0;

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

            //cria um novo option dinamicamente
            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto
            novo.text = descricao;
            //finalmente adiciona o novo elemento
            document.forms[0].listDados.options.add(novo);

            if (i == 0) {
                $("codigo").value = codigo;
                $("descricao").value = descricao;

                $("descricao2").value = descricao6;
                $("email").value = descricao7;
                $("descricao3").disabled = true;
                $("descricao4").disabled = true;

                $("acao").value = "alterar";
                document.getElementById("botao-text").innerHTML = "Alterar";
            }

        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo

        $("codigo").value = "";
        $("descricao").value = "";
        $("acao").value = "inserir";
        document.getElementById("botao-text").innerHTML = "Incluir";

        idOpcao.innerHTML = "Faça a pesquisa do Usuário";

    }
}


function processXML2(obj) {
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

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;

            $("codigo").value = codigo;
            $("descricao").value = descricao;

            $("descricao2").value = descricao6;
            $("email").value = descricao7;
            $("descricao3").disabled = true;
            $("descricao4").disabled = true;

            $("acao").value = "alterar";
            document.getElementById("botao-text").innerHTML = "Alterar";


        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo

        $("codigo").value = "";
        $("descricao").value = "";
        $("acao").value = "inserir";
        document.getElementById("botao-text").innerHTML = "Incluir";


    }
}


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
