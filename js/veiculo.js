// JavaScript Document
function enviar() {

    valor = document.getElementById('veiplaca').value;

    if (document.getElementById("radio1").checked == true) {
        radio = 1;
    } else {
        radio = 2;
    }

    if (document.getElementById("radiov1").checked == true) {
        radiov = 'S';
    } else {
        radiov = 'N';
    }

    if ($("acao").value == "inserir") {

        new ajax('veiculoinsere.php?veiplaca=' + document.getElementById('veiplaca').value
                + '&veiano=' + document.getElementById('veiano').value
                + '&veimodelo=' + document.getElementById('veimodelo').value
                + '&veicor=' + document.getElementById('veicor').value
                + '&veichassis=' + document.getElementById('veichassis').value
                + '&veitipo=' + radio
                + '&veivalidar=' + radiov
                , {});

        limpa_form();
        dadospesquisa3(valor);

    } else if ($("acao").value == "alterar") {
        new ajax('veiculoaltera.php?veiplaca=' + document.getElementById('veiplaca').value + "&veicodigo=" + document.getElementById('veicodigo').value

                + '&veiano=' + document.getElementById('veiano').value
                + '&veimodelo=' + document.getElementById('veimodelo').value
                + '&veicor=' + document.getElementById('veicor').value
                + '&veichassis=' + document.getElementById('veichassis').value
                + '&veitipo=' + radio
                + '&veivalidar=' + radiov
                , {});


        document.forms[0].listDados.options.length = 0;

        var novo = document.createElement("option");
        //atribui um ID a esse elemento
        novo.setAttribute("id", "opcoes");
        //atribui um valor
        novo.value = document.getElementById('veicodigo').value;
        //atribui um texto
        novo.text = document.getElementById('veiplaca').value;
        //finalmente adiciona o novo elemento
        document.forms[0].listDados.options.add(novo);
        
        alert('Alterado com Sucesso!');

    }
}

function apagar(veicodigo) {
    new ajax('veiculoapaga.php?veicodigo=' + veicodigo, {onComplete: apagado});
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
            alert("Veiculo excluído com sucesso!");
            limpa_form();
        }

    }

}

function valida_form() {

    erro = 0;

    if ($("veiplaca").value == "") {
        alert("Preencha o campo placa do veiculo !")
        erro = 1;
    } else {
        if ($("veiano").value == "") {
            alert("Preencha o campo ano do veiculo !")
            erro = 1;
        } else {
            if ($("veimodelo").value == "") {
                alert("Preencha o campo modelo do veiculo !")
                erro = 1;
            }
        }
    }

    if (erro == 0) {
        enviar();
    }

}

function limpa_form() {
    $("acao").value = "inserir";
    document.getElementById("botao-text").innerHTML = "Incluir";
    $("veicodigo").value = "";
    $("veiplaca").value = "";

    $("veiano").value = "";
    $("veimodelo").value = "";
    $("veicor").value = "";
    $("veichassis").value = "";
    document.getElementById("radio1").checked = true;

    document.getElementById("radiov2").checked = true;

    $("pesquisa").value = "";
    document.forms[0].listDados.options.length = 1;
    if (document.querySelector('#opcoes')){
        idOpcao = document.getElementById("opcoes");
        idOpcao.innerHTML = "Faça a Pesquisa da Placa";
    }
}

function limpa_form2() {
    $("acao").value = "inserir";
    document.getElementById("botao-text").innerHTML = "Incluir";
    $("veicodigo").value = "";
    $("veiplaca").value = "";

    $("veiano").value = "";
    $("veimodelo").value = "";
    $("veicor").value = "";
    $("veichassis").value = "";
    document.getElementById("radio1").checked = true;

    document.getElementById("radiov2").checked = true;

}

function verifica1() {
    if (confirm("Tem certeza que deseja Excluir?\n\t")) {
        apagar($("veicodigo").value);
    }
}

function verifica() {
    if ($("veicodigo").value == "") {
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

        ajax2.open("POST", "veiculopesquisa.php", true);
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
                    idOpcao.innerHTML = "Faça a Pesquisa da Placa";
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

        ajax2.open("POST", "veiculopesquisa2.php", true);
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

        ajax2.open("POST", "veiculopesquisa3.php", true);
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
                    idOpcao.innerHTML = "Faça a Pesquisa da Placa";
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
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao = txt;
            trimjs(descricao2);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao2 = txt;
            trimjs(descricao3);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao3 = txt;
            trimjs(descricao4);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao4 = txt;
            trimjs(descricao5);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao5 = txt;
            trimjs(descricao6);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao6 = txt;
            trimjs(descricao7);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao7 = txt;

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
                $("veicodigo").value = codigo;
                $("veiplaca").value = descricao;

                $("veiano").value = descricao2;
                $("veimodelo").value = descricao3;
                $("veicor").value = descricao4;
                $("veichassis").value = descricao5;

                if (descricao6 == '1') {
                    document.getElementById("radio1").checked = true;
                } else {
                    document.getElementById("radio2").checked = true;
                }

                if (descricao7 == 'S') {
                    document.getElementById("radiov1").checked = true;
                } else {
                    document.getElementById("radiov2").checked = true;
                }


                $("acao").value = "alterar";
                document.getElementById("botao-text").innerHTML = "Alterar";
            }

        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo

        $("veicodigo").value = "";
        $("veiplaca").value = "";

        $("veiano").value = "";
        $("veimodelo").value = "";
        $("veicor").value = "";
        $("veichassis").value = "";
        document.getElementById("radio1").checked = true;

        document.getElementById("radiov2").checked = true;

        $("acao").value = "inserir";
        document.getElementById("botao-text").innerHTML = "Incluir";

        idOpcao.innerHTML = "Faça a Pesquisa da Placa";

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
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao = txt;
            trimjs(descricao2);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao2 = txt;
            trimjs(descricao3);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao3 = txt;
            trimjs(descricao4);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao4 = txt;
            trimjs(descricao5);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao5 = txt;
            trimjs(descricao6);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao6 = txt;
            trimjs(descricao7);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao7 = txt;

            $("veicodigo").value = codigo;
            $("veiplaca").value = descricao;

            $("veiano").value = descricao2;
            $("veimodelo").value = descricao3;
            $("veicor").value = descricao4;
            $("veichassis").value = descricao5;

            if (descricao6 == '1') {
                document.getElementById("radio1").checked = true;
            } else {
                document.getElementById("radio2").checked = true;
            }

            if (descricao7 == 'S') {
                document.getElementById("radiov1").checked = true;
            } else {
                document.getElementById("radiov2").checked = true;
            }


            $("acao").value = "alterar";
            document.getElementById("botao-text").innerHTML = "Alterar";


        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo

        $("veicodigo").value = "";
        $("veiplaca").value = "";

        $("veiano").value = "";
        $("veimodelo").value = "";
        $("veicor").value = "";
        $("veichassis").value = "";
        document.getElementById("radio1").checked = true;

        document.getElementById("radiov2").checked = true;

        $("acao").value = "inserir";
        document.getElementById("botao-text").innerHTML = "Incluir";

    }
}

