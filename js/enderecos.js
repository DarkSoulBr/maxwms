// JavaScript Document
function enviar() {

    let posicao = 0;
    if (document.getElementById("radio21").checked == true)
    {
        posicao = 1;
    } else {
        posicao = 2;
    }

    let valor = document.getElementById('ua').value;
    if ($("acao").value == "inserir") {
        new ajax('enderecosinsere.php?ua=' + document.getElementById('ua').value +
                '&bloco=' + document.getElementById('bloco').value +
                '&rua=' + document.getElementById('rua').value +
                '&nivel=' + document.getElementById('nivel').value +
                '&coluna=' + document.getElementById('coluna').value +
                '&posicao=' + posicao
                , {onComplete: incluido});



    } else if ($("acao").value == "alterar") {

        new ajax('enderecosaltera.php?ua=' + document.getElementById('ua').value +
                '&bloco=' + document.getElementById('bloco').value +
                '&rua=' + document.getElementById('rua').value +
                '&nivel=' + document.getElementById('nivel').value +
                '&coluna=' + document.getElementById('coluna').value +
                '&posicao=' + posicao +
                "&codigo=" + document.getElementById('id').value
                , {onComplete: alterado});



    }
}

function incluido(request) {


    var codigo = 0;
    var erro = '';

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
            var itens = registros[0].getElementsByTagName('item');
            codigo = itens[0].firstChild.data;
            erro = itens[1].firstChild.data;

        }

        if (codigo == 0) {
            alert("ERRO: " + erro + "!");
            limpa_form();
        } else {
            alert("Incluido com sucesso! Codigo " + codigo + "!");
            limpa_form();
            dadospesquisa3(codigo);
        }

    }

}

function alterado(request) {

    var codigo = 0;
    var erro = '';

    var xmldoc = request.responseXML;

    if (xmldoc.getElementsByTagName('dados')[0] == null) {
        alert('Problema com a alteração, favor tentar novamente !');
    } else {

        var dados = xmldoc.getElementsByTagName('dados')[0];

        var xmldoc = request.responseXML;
        var dados = xmldoc.getElementsByTagName('dados')[0];

        if (dados != null)
        {
            var registros = xmldoc.getElementsByTagName('registro');
            var itens = registros[0].getElementsByTagName('item');
            codigo = itens[0].firstChild.data;
            erro = itens[1].firstChild.data;

        }

        if (codigo == 0) {
            alert("ERRO: " + erro + "!");
            limpa_form();
        } else {
            document.forms[0].listDados.options.length = 0;

            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes");
            //atribui um valor
            novo.value = document.getElementById('id').value;
            //atribui um texto
            novo.text = document.getElementById('ua').value;
            //finalmente adiciona o novo elemento
            document.forms[0].listDados.options.add(novo);

            alert("Registro atualizado com sucesso!");
        }

    }

}

function apagar(codigo) {
    new ajax('enderecosapaga.php?codigo=' + codigo, {onComplete: apagado});
}

function apagado(request) {

    var codigo = 0;
    var erro = '';

    var xmldoc = request.responseXML;

    if (xmldoc.getElementsByTagName('dados')[0] == null) {
        alert('Problema com a exclusão, favor tentar novamente !');
    } else {

        var dados = xmldoc.getElementsByTagName('dados')[0];

        var xmldoc = request.responseXML;
        var dados = xmldoc.getElementsByTagName('dados')[0];

        if (dados != null)
        {
            var registros = xmldoc.getElementsByTagName('registro');
            var itens = registros[0].getElementsByTagName('item');
            codigo = itens[0].firstChild.data;
            erro = itens[1].firstChild.data;

        }

        if (codigo == 0) {
            alert("ERRO: " + erro + "!");
            limpa_form();
        } else {
            alert("Registro excluído com sucesso!");
            limpa_form();
        }

    }

}

function valida_form() {

    if ($("ua").value == "") {
        alert("Preencha o campo UA")
        return false;
    } else
        enviar();
}

function limpa_form() {

    $("acao").value = "inserir";
    document.getElementById("botao-text").innerHTML = "Incluir";
    $("id").value = "";
    $("ua").value = "";
    $("bloco").value = "";
    $("rua").value = "";
    $("nivel").value = "";
    $("coluna").value = "";

    document.getElementById("radio21").checked = true;

    document.forms[0].listDados.options.length = 1;
    idOpcao = document.getElementById("opcoes");
    idOpcao.innerHTML = "Faça a Pesquisa do Endereço";

}

function verifica1() {
    if (confirm("Tem certeza que deseja Excluir?")) {
        apagar($("id").value);
    }
}

function verifica() {
    if ($("id").value == "") {
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

        ajax2.open("POST", "enderecospesquisa.php", true);
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
                    idOpcao.innerHTML = "Faça a Pesquisa do Endereço";
                }
            }
        }
        //passa o parametro
        if (document.getElementById("radio1").checked == true)
        {
            valor2 = "2";
        } else {
            valor2 = "1";
        }


        var params = "parametro=" + valor + '&parametro2=' + valor2;
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

        ajax2.open("POST", "enderecospesquisa.php", true);
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
        var params = "parametro=" + valor + '&parametro2=1';
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

        ajax2.open("POST", "enderecospesquisa.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXML3(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "Faça a Pesquisa do Endereço";
                }
            }
        }
        //passa o parametro escolhido
        var params = "parametro=" + valor + '&parametro2=1';
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
            var ua = item.getElementsByTagName("ua")[0].firstChild.nodeValue;
            var bloco = item.getElementsByTagName("bloco")[0].firstChild.nodeValue;
            var rua = item.getElementsByTagName("rua")[0].firstChild.nodeValue;
            var nivel = item.getElementsByTagName("nivel")[0].firstChild.nodeValue;
            var posicao = item.getElementsByTagName("posicao")[0].firstChild.nodeValue;
            var coluna = item.getElementsByTagName("coluna")[0].firstChild.nodeValue;


            //cria um novo option dinamicamente
            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto


            novo.text = ua;

            //finalmente adiciona o novo elemento
            document.forms[0].listDados.options.add(novo);

            if (i == 0) {


                $("id").value = codigo;
                $("ua").value = ua;
                $("bloco").value = bloco;
                $("rua").value = rua;
                $("nivel").value = nivel;
                $("coluna").value = coluna;

                if (posicao == 1) {
                    document.getElementById("radio21").checked = true;
                } else {
                    document.getElementById("radio22").checked = true;
                }


                $("acao").value = "alterar";
                document.getElementById("botao-text").innerHTML = "Alterar";
            }

        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo

        $("id").value = '';
        $("ua").value = '';
        $("bloco").value = '';
        $("rua").value = '';
        $("nivel").value = '';
        $("coluna").value = '';

        document.getElementById("radio21").checked = true;

        idOpcao.innerHTML = "Faça a Pesquisa do Endereço";

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
            var ua = item.getElementsByTagName("ua")[0].firstChild.nodeValue;
            var bloco = item.getElementsByTagName("bloco")[0].firstChild.nodeValue;
            var rua = item.getElementsByTagName("rua")[0].firstChild.nodeValue;
            var nivel = item.getElementsByTagName("nivel")[0].firstChild.nodeValue;
            var posicao = item.getElementsByTagName("posicao")[0].firstChild.nodeValue;
            var coluna = item.getElementsByTagName("coluna")[0].firstChild.nodeValue;

            $("id").value = codigo;
            $("ua").value = ua;
            $("bloco").value = bloco;
            $("rua").value = rua;
            $("nivel").value = nivel;
            $("coluna").value = coluna;

            if (posicao == 1) {
                document.getElementById("radio21").checked = true;
            } else {
                document.getElementById("radio22").checked = true;
            }

            $("acao").value = "alterar";
            document.getElementById("botao-text").innerHTML = "Alterar";

        }
    } else {

        //caso o XML volte vazio, printa a mensagem abaixo
        $("id").value = '';
        $("ua").value = '';
        $("bloco").value = '';
        $("rua").value = '';
        $("nivel").value = '';
        $("coluna").value = '';

        document.getElementById("radio21").checked = true;

    }
}

function processXML3(obj) {
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
            var ua = item.getElementsByTagName("ua")[0].firstChild.nodeValue;
            var bloco = item.getElementsByTagName("bloco")[0].firstChild.nodeValue;
            var rua = item.getElementsByTagName("rua")[0].firstChild.nodeValue;
            var nivel = item.getElementsByTagName("nivel")[0].firstChild.nodeValue;
            var posicao = item.getElementsByTagName("posicao")[0].firstChild.nodeValue;
            var coluna = item.getElementsByTagName("coluna")[0].firstChild.nodeValue;

            //cria um novo option dinamicamente
            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto

            novo.text = ua;

            //finalmente adiciona o novo elemento
            document.forms[0].listDados.options.add(novo);

            if (i == 0) {
                $("id").value = codigo;
                $("ua").value = ua;
                $("bloco").value = bloco;
                $("rua").value = rua;
                $("nivel").value = nivel;
                $("coluna").value = coluna;

                if (posicao == 1) {
                    document.getElementById("radio21").checked = true;
                } else {
                    document.getElementById("radio22").checked = true;
                }

                $("acao").value = "alterar";
                document.getElementById("botao-text").innerHTML = "Alterar";
            }

        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo

        $("id").value = '';
        $("ua").value = '';
        $("bloco").value = '';
        $("rua").value = '';
        $("nivel").value = '';
        $("coluna").value = '';

        document.getElementById("radio21").checked = true;

        $("acao").value = "inserir";
        document.getElementById("botao-text").innerHTML = "Incluir";

        idOpcao.innerHTML = "Faça a Pesquisa do Endereço";

    }
}
