// JavaScript Document
function enviar() {

    let local1 = 0;
    let local2 = 0;

    if ($("checkbox1").checked) {
        local1 = 1;
    } else {
        local1 = 0;
    }

    if ($("checkbox2").checked) {
        local2 = 1;
    } else {
        local2 = 0;
    }

    var reserva;
    if (document.getElementById("radio1").checked == true) {
        reserva = 'S';
    } else {
        reserva = 'N';
    }
    
    let consultas;
    if (document.getElementById("radiocons1").checked == true) {
        consultas = 'S';
    } else {
        consultas = 'N';
    }
    
    let zerou;
    if (document.getElementById("radiozero1").checked == true) {
        zerou = 'S';
    } else {
        zerou = 'N';
    }

    let empcodigo = 0;

    if (local1 == 1 && local2 == 0) {
        empcodigo = 1;
    } else if (local1 == 0 && local2 == 1) {
        empcodigo = 2;
    } else {
        empcodigo = 3;
    }

    if ($("acao").value == "inserir") {
        new ajax('estoqueinsere.php?etqnome=' + document.getElementById('nome').value + "&reserva=" + reserva + "&empcodigo=" + empcodigo + "&etqsigla=" + document.getElementById('sigla').value + "&consultas=" + consultas + "&zerou=" + zerou, {onComplete: incluido});
    } else if ($("acao").value == "alterar") {
        new ajax('estoquealtera.php?etqnome=' + document.getElementById('nome').value + "&etqcodigo=" + document.getElementById('codigo').value + "&reserva=" + reserva + "&empcodigo=" + empcodigo + "&etqsigla=" + document.getElementById('sigla').value + "&consultas=" + consultas + "&zerou=" + zerou, {onComplete: alterado});
    }

}

function incluido(request) {

    var valor = document.getElementById('nome').value;

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
            novo.value = document.getElementById('codigo').value;
            //atribui um texto
            novo.text = document.getElementById('nome').value;
            //finalmente adiciona o novo elemento
            document.forms[0].listDados.options.add(novo);

            alert("Registro atualizado com sucesso!");
        }

    }

}


function apagar(etqcodigo) {
    new ajax('estoqueapaga.php?etqcodigo=' + etqcodigo, {onComplete: apagado});
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
            alert("Estoque excluído com sucesso!");
            limpa_form();
        }

    }

}

function valida_form() {

    let local1 = 0;
    let local2 = 0;

    if ($("checkbox1").checked) {
        local1 = 1;
    } else {
        local1 = 0;
    }

    if ($("checkbox2").checked) {
        local2 = 1;
    } else {
        local2 = 0;
    }
    
    let zerou;
    if (document.getElementById("radiozero1").checked == true) {
        zerou = 'S';
    } else {
        zerou = 'N';
    }
    
    

    if ($("nome").value == "") {
        alert("Preencha o campo estoque")
        return false;
    } else {
        if (local1 == 0 && local2 == 0) {
            alert("Escolha a Empresa")
            return false;
        } else {
            
            if ($("acao").value == "inserir" && zerou == 'S') {
                alert('Aviso de Estoque Zerado só disponível para estoques 9, 26 e 38!')
                return false;
            } else {
                if(!(document.getElementById('codigo').value==9 || document.getElementById('codigo').value==26 || document.getElementById('codigo').value==38) && $("acao").value == "alterar" && zerou == 'S') {
                    alert('Aviso de Estoque Zerado só disponível para estoques 9, 26 e 38!')
                    return false;
                }
            }
            
            enviar();
        }
    }
}

function limpa_form() {
    $("acao").value = "inserir";
    document.getElementById("botao-text").innerHTML = "Incluir";
    $("codigo").value = "";
    $("nome").value = "";
    $("pesquisa").value = "";
    $("sigla").value = "";
    document.getElementById("radio2").checked = true;
    document.getElementById("radiocons1").checked = true;
    document.getElementById("radiozero2").checked = true;
    $("checkbox2").checked = false;
    $("checkbox1").checked = true;
    document.forms[0].listDados.options.length = 1;
    if (document.querySelector('#opcoes')) {
        idOpcao = document.getElementById("opcoes");
        idOpcao.innerHTML = "Faça a pesquisa do Estoque";
    }
}

function limpa_form2() {
    $("acao").value = "inserir";
    document.getElementById("botao-text").innerHTML = "Incluir";
    $("codigo").value = "";
    $("nome").value = "";
}

function verifica1() {

    $a('#dialog').attr('title', 'EXCLUSÃO : ' + $("nome").value);

    var mensagem = "Tem certeza que deseja Excluir o Estoque " + $("nome").value + "?";

    var html = '<p>' +
            mensagem +
            '</p><form id="formSituacao" name="formSituacao" method="post" action="#">';



    html += '</form>';



    $a('#dialog').html(html);

    $a('#dialog').dialog({
        autoOpen: true,
        width: 500,
        modal: true,
        overlay: {
            background: "white"
        },
        buttons:
                {

                    "Sim": function ()
                    {


                        $a('#dialog').dialog("close");

                        apagar($("codigo").value);


                    },
                    "Não": function ()
                    {
                        $a(this).dialog("close");
                    }

                },
        close: function (ev, ui)
        {
            $a(this).dialog("destroy");



        }


    });

    $a('#dialog').dialog("open");



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

        ajax2.open("POST", "estoquepesquisa.php", true);
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
                    idOpcao.innerHTML = "Faça a pesquisa do Estoque";
                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor + '&parametro2=1';
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

        ajax2.open("POST", "estoquepesquisa.php", true);
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
        var params = "parametro=" + valor + '&parametro2=2';
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

        ajax2.open("POST", "estoquepesquisa.php", true);
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
                    idOpcao.innerHTML = "Faça a pesquisa do Estoque";
                }
            }
        }
        //passa o parametro escolhido
        var params = "parametro=" + valor + '&parametro2=2';
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
            var reserva = item.getElementsByTagName("reserva")[0].firstChild.nodeValue;
            var consultas = item.getElementsByTagName("consultas")[0].firstChild.nodeValue;
            var zerou = item.getElementsByTagName("zerou")[0].firstChild.nodeValue;
            var etqsigla = item.getElementsByTagName("etqsigla")[0].firstChild.nodeValue;
            var empcodigo = item.getElementsByTagName("empcodigo")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;
            trimjs(reserva);
            reserva = txt;
            trimjs(consultas);
            consultas = txt;
            if (etqsigla == '_') {
                etqsigla = '';
            }

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
                $("nome").value = descricao;
                $("sigla").value = etqsigla;
                if (reserva == 'S') {
                    document.getElementById("radio1").checked = true;
                } else {
                    document.getElementById("radio2").checked = true;
                }
                if (consultas == 'S') {
                    document.getElementById("radiocons1").checked = true;
                } else {
                    document.getElementById("radiocons2").checked = true;
                }
                if (zerou == 'S') {
                    document.getElementById("radiozero1").checked = true;
                } else {
                    document.getElementById("radiozero2").checked = true;
                }
                if (empcodigo == 1) {
                    $("checkbox2").checked = false;
                    $("checkbox1").checked = true;
                } else if (empcodigo == 2) {
                    $("checkbox2").checked = true;
                    $("checkbox1").checked = false;
                } else {
                    $("checkbox2").checked = true;
                    $("checkbox1").checked = true;
                }
                $("acao").value = "alterar";
                document.getElementById("botao-text").innerHTML = "Alterar";
            }

        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo

        $("codigo").value = "";
        $("nome").value = "";
        $("sigla").value = "";
        document.getElementById("radio2").checked = true;
        document.getElementById("radiocons1").checked = true;
        document.getElementById("radiozero2").checked = true;
        $("checkbox2").checked = false;
        $("checkbox1").checked = true;
        $("acao").value = "inserir";
        document.getElementById("botao-text").innerHTML = "Incluir";

        idOpcao.innerHTML = "Faça a pesquisa do Estoque";

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
            var reserva = item.getElementsByTagName("reserva")[0].firstChild.nodeValue;
            var consultas = item.getElementsByTagName("consultas")[0].firstChild.nodeValue;
            var zerou = item.getElementsByTagName("zerou")[0].firstChild.nodeValue;
            var etqsigla = item.getElementsByTagName("etqsigla")[0].firstChild.nodeValue;
            var empcodigo = item.getElementsByTagName("empcodigo")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;
            trimjs(reserva);
            reserva = txt;
            trimjs(consultas);
            consultas = txt;
            if (etqsigla == '_') {
                etqsigla = '';
            }

            $("codigo").value = codigo;
            $("nome").value = descricao;
            $("sigla").value = etqsigla;
            if (reserva == 'S') {
                document.getElementById("radio1").checked = true;
            } else {
                document.getElementById("radio2").checked = true;
            }
            if (zerou == 'S') {
                document.getElementById("radiozero1").checked = true;
            } else {
                document.getElementById("radiozero2").checked = true;
            }
            if (consultas == 'S') {
                document.getElementById("radiocons1").checked = true;
            } else {
                document.getElementById("radiocons2").checked = true;
            }
            if (empcodigo == 1) {
                $("checkbox2").checked = false;
                $("checkbox1").checked = true;
            } else if (empcodigo == 2) {
                $("checkbox2").checked = true;
                $("checkbox1").checked = false;
            } else {
                $("checkbox2").checked = true;
                $("checkbox1").checked = true;
            }
            $("acao").value = "alterar";
            document.getElementById("botao-text").innerHTML = "Alterar";


        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo

        $("codigo").value = "";
        $("nome").value = "";
        $("sigla").value = "";
        document.getElementById("radio2").checked = true;
        document.getElementById("radiocons1").checked = true;
        document.getElementById("radiozero2").checked = true;
        $("checkbox2").checked = false;
        $("checkbox1").checked = true;
        $("acao").value = "inserir";
        document.getElementById("botao-text").innerHTML = "Incluir";

    }
}

