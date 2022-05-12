// JavaScript Document
var vetorrateio = new Array(100);

for (var i = 0; i < 100; i++) {
    vetorrateio[i] = new Array(5);
}

for (var i = 0; i < 100; i++) {
    vetorrateio[i][0] = '';
    vetorrateio[i][1] = '';
    vetorrateio[i][2] = '';
    vetorrateio[i][3] = '';
    vetorrateio[i][4] = '';
}

function enviar() {
    var conemb = 0;
    var ocoren = 0;
    var doccob = 0;
    var notfis = 0;
    var retirada = '';
    var tratptolera = 0;

    if (document.getElementById("conemb1").checked == true) {
        conemb = '3.0';
    } else if (document.getElementById("conemb2").checked == true) {
        conemb = '3.1';
    } else if (document.getElementById("conemb3").checked == true) {
        conemb = '5.0';
    }

    if (document.getElementById("ocoren1").checked == true) {
        ocoren = '3.0';
    } else if (document.getElementById("ocoren2").checked == true) {
        ocoren = '3.1';
    } else if (document.getElementById("ocoren3").checked == true) {
        ocoren = '5.0';
    }

    if (document.getElementById("doccob1").checked == true) {
        doccob = '3.0';
    } else if (document.getElementById("doccob2").checked == true) {
        doccob = '3.1';
    } else if (document.getElementById("doccob3").checked == true) {
        doccob = '5.0';
    }

    if (document.getElementById("notfis1").checked == true) {
        notfis = '3.0';
    } else if (document.getElementById("notfis2").checked == true) {
        notfis = '3.1';
    } else if (document.getElementById("notfis3").checked == true) {
        notfis = '5.0';
    }

    if (document.getElementById("radios1").checked == true) {
        retirada = 'S';
    } else {
        retirada = 'N';
    }

    if (document.getElementById("radiotol1").checked == true) {
        tratptolera = 1;
    } else {
        tratptolera = 2;
    }

    valor = document.getElementById('tranguerra').value;

    var campovet01 = "";
    var campovet02 = "";
    var campovet03 = "";

    for (j = 0; j < vetorrateio.length; j++)
    {
        if (vetorrateio[j][0] != '')
        {
            campovet01 = campovet01 + '&contato[]=' + vetorrateio[j][0];
            campovet02 = campovet02 + '&contatoemail[]=' + vetorrateio[j][1];
            campovet03 = campovet03 + '&contatocargo[]=' + vetorrateio[j][2];
        }
    }


    if ($("acao").value == "inserir") {

        new ajax('transportadorinsere.php?tranguerra=' + document.getElementById('tranguerra').value +
                '&trarazao=' + document.getElementById('trarazao').value +
                '&tradatasul=' + document.getElementById('tradatasul').value +
                '&tracep=' + document.getElementById('tracep').value +
                '&traendereco=' + document.getElementById('traendereco').value +
                '&trabairro=' + document.getElementById('trabairro').value +
                '&trafone=' + document.getElementById('trafone').value +
                '&trafax=' + document.getElementById('trafax').value +
                '&traemail=' + document.getElementById('traemail').value +
                '&traobs=' + document.getElementById('traobs').value +
                '&rotcodigo=' + document.forms[0].listrotas.options[document.forms[0].listrotas.selectedIndex].value +
                '&tpfcodigo=' + document.forms[0].listservicos.options[document.forms[0].listservicos.selectedIndex].value +
                '&tracodcidade=' + document.getElementById('tracodcidade').value +
                '&tracnpj=' + document.getElementById('tracnpj').value +
                '&traie=' + document.getElementById('traie').value +
                '&conemb=' + conemb +
                '&ocoren=' + ocoren +
                '&doccob=' + doccob +
                '&notfis=' + notfis +
                '&traretirada=' + retirada +
                '&tratptolera=' + tratptolera +
                '&tratolera=' + document.getElementById('tolera').value +
                '&tracaminho=' + document.getElementById('tracaminho').value + '' + campovet01 + '' + campovet02 + '' + campovet03
                , {onComplete: incluido});


    } else if ($("acao").value == "alterar") {

        new ajax('transportadoraltera.php?tranguerra=' + document.getElementById('tranguerra').value +
                "&tracodigo=" + document.getElementById('tracodigo').value +
                '&trarazao=' + document.getElementById('trarazao').value +
                '&tradatasul=' + document.getElementById('tradatasul').value +
                '&tracep=' + document.getElementById('tracep').value +
                '&traendereco=' + document.getElementById('traendereco').value +
                '&trabairro=' + document.getElementById('trabairro').value +
                '&trafone=' + document.getElementById('trafone').value +
                '&trafax=' + document.getElementById('trafax').value +
                '&traemail=' + document.getElementById('traemail').value +
                '&traobs=' + document.getElementById('traobs').value +
                '&rotcodigo=' + document.forms[0].listrotas.options[document.forms[0].listrotas.selectedIndex].value +
                '&tpfcodigo=' + document.forms[0].listservicos.options[document.forms[0].listservicos.selectedIndex].value +
                '&tracodcidade=' + document.getElementById('tracodcidade').value +
                '&tracnpj=' + document.getElementById('tracnpj').value +
                '&traie=' + document.getElementById('traie').value +
                '&conemb=' + conemb +
                '&ocoren=' + ocoren +
                '&doccob=' + doccob +
                '&notfis=' + notfis +
                '&traretirada=' + retirada +
                '&tratptolera=' + tratptolera +
                '&tratolera=' + document.getElementById('tolera').value +
                '&tracaminho=' + document.getElementById('tracaminho').value + '' + campovet01 + '' + campovet02 + '' + campovet03
                , {});

        document.forms[0].listDados.options.length = 0;

        var novo = document.createElement("option");
        //atribui um ID a esse elemento
        novo.setAttribute("id", "opcoes");
        //atribui um valor
        novo.value = document.getElementById('tracodigo').value;
        //atribui um texto
        novo.text = document.getElementById('tranguerra').value;
        //finalmente adiciona o novo elemento
        document.forms[0].listDados.options.add(novo);

        alert('Alterado com Sucesso !');

    }
}

function incluido(request) {

    var codigo = 0;

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

        }

        if (codigo == 0) {
            alert('Problema com a inclusão, favor tentar novamente !');
            limpa_form();
        } else {
            alert("Incluido com sucesso! Codigo " + codigo + "!");
            limpa_form();
            dadospesquisa3(codigo);
        }

    }

}

function apagar(tracodigo) {
    new ajax('transportadorapaga.php?tracodigo=' + tracodigo, {onComplete: apagado});
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
    $a("#msg").hide();
    $a("#altpedi").hide();
    $a("#altpediblk").hide();
    $a("#altpedispc").hide();
    $a("#altpedipst").hide();
    var cnpj = $("tracnpj").value;
    var ie = $("traie").value;
    var datasul = $("tradatasul").value;
    var erro = 0;
    var edicount = 0;
    var nomedeguerra = $("tranguerra").value;

    if ($("tracep").value == "") {
        alert("Preencha o campo CEP")
        return false;
    } else if ($("tranguerra").value == "") {
        alert("Preencha o campo Nome de Guerra")
        return false;
    } else if (cnpj == "") {
        alert("Preencha o campo CNPJ")
        $a("#msg").show().text(" Campo Obrigatório ");
        return false;
    } else if (datasul == "" || datasul == "0") {
        if ($("acao").value == "alterar")
        {
            alert("Código Datasul Obrigatório")
            return false;
        }
    } else if (ie == "" || ie == "0") {
        alert("Preencha o campo I.E.")
        return false;
    }

    nomedeguerra = nomedeguerra.trim();

    if (nomedeguerra.length > 12) {
        alert("Atenção, nome de guerra passou a ter limite de 12 caracteres, favor alterar!")
        return false;
    }


    if ($a("input[name=conemb]:checked").val()) {
        edicount++;
    }
    if ($a("input[name=ocoren]:checked").val()) {
        edicount++;
    }
    if ($a("input[name=doccob]:checked").val()) {
        edicount++;
    }
    if ($a("input[name=notfis]:checked").val()) {
        edicount++;
    }

    if (edicount > 0) {

        if (edicount < 4) {
            $a("#altpedi").show();
            return false;
        }

        /*
         var arquivo = $a("#tracaminho").val();
         
         if(arquivo == ''){
         $a("#altpediblk").show();
         $("tracaminho").focus();
         return false;
         } 
         if(arquivo.match(/\s+/)){
         $a("#altpedispc").show();
         return false;
         } 
         
         
         // Verifica se a pasta existe
         $a.get('transportadorpesquisadir.php',{ 
         arquivo:arquivo
         },
         function(data){
         if(!data) {
         alert("Pasta não existe. Favor contatar o administrador.");
         $a("#altpedipst").show();
         return false;
         }
         },'json');
         */

    }

    if ($("acao").value == "inserir")
    {
        if (datasul == "" || datasul == "0") {
            verificacnpjservico();
        } else {
            verificadatasul();
        }
    } else {
        //enviar();
        verificadatasul();
    }


}

function verificadatasul()
{

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

        ajax2.open("POST", "transportadoraverifica.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLverificadatasul(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo

                }
            }
        }


        if ($("acao").value == "inserir")
        {
            valor = 0;

        } else if ($("acao").value == "alterar")
        {
            valor = document.getElementById('tracodigo').value;
        }

        valor2 = document.getElementById('tradatasul').value;
        valor3 = document.getElementById('tracnpj').value;

        var params = "parametro=" + valor + '&parametro2=' + valor2 + '&parametro3=' + valor3;

        ajax2.send(params);
    }
}

function processXMLverificadatasul(obj)
{

    valor2 = document.getElementById('tradatasul').value;

    if (valor2 == '0') {
        valor2 = '';
    }

    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados
        var item = dataArray[0];
        //contéudo dos campos no arquivo XML
        var baruni = item.getElementsByTagName("baruni")[0].firstChild.nodeValue;
        var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
        var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

        trimjs(valor2);
        if (txt != '') {
            if (baruni == 1) {
                alert('Codigo Datasul já cadastrado para : ' + codigo + ' ' + descricao);
            }
        } else {
            baruni = 0;
        }
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo

    }

    if (baruni == 0) {
        verificacnpjservico();
    }

}

function limpa_form() {

    cep1 = "";

    $("acao").value = "inserir";
    $("botao").value = "Incluir";
    $("tracodigo").value = "";
    $("tranguerra").value = "";
    $("trarazao").value = "";
    $("tradatasul").value = "";
    $("tracep").value = "";

    $("tracidade").value = "";
    $("trauf").value = "";

    $("traendereco").value = "";
    $("trabairro").value = "";
    $("trafone").value = "";
    $("trafax").value = "";
    $("traemail").value = "";
    $("traobs").value = "";
    $("tracodcidade").value = "";
    $("tracnpj").value = "";
    $("traie").value = "";
    $("pesquisa").value = "";
    $("tracaminho").value = "";
    $("tolera").value = "";

    document.forms[0].listDados.options.length = 1;
    idOpcao = document.getElementById("opcoes");
    idOpcao.innerHTML = "____________________";
    document.forms[0].listrotas.options[0].selected = true;
    document.forms[0].listservicos.options[0].selected = true;

    document.getElementById("conemb1").checked = false;
    document.getElementById("conemb2").checked = false;
    document.getElementById("conemb3").checked = false;

    document.getElementById("ocoren1").checked = false;
    document.getElementById("ocoren2").checked = false;
    document.getElementById("ocoren3").checked = false;

    document.getElementById("doccob1").checked = false;
    document.getElementById("doccob2").checked = false;
    document.getElementById("doccob3").checked = false;

    document.getElementById("notfis1").checked = false;
    document.getElementById("notfis2").checked = false;
    document.getElementById("notfis3").checked = false;

    document.getElementById("radios2").checked = true;
    document.getElementById("radiotol1").checked = true;

    for (var i = 0; i < 100; i++) {
        vetorrateio[i][0] = '';
        vetorrateio[i][1] = '';
        vetorrateio[i][2] = '';
        vetorrateio[i][3] = '';
        vetorrateio[i][4] = '';
    }
    montahtmlrateio();

}

function limpa_form2() {

    cep1 = "";

    $("acao").value = "inserir";
    $("botao").value = "Incluir";
    $("tracodigo").value = "";
    $("tranguerra").value = "";
    $("trarazao").value = "";
    $("tradatasul").value = "";
    $("tracep").value = "";
    $("tracidade").value = "";
    $("trauf").value = "";
    $("traendereco").value = "";
    $("trabairro").value = "";
    $("trafone").value = "";
    $("trafax").value = "";
    $("traemail").value = "";
    $("traobs").value = "";
    $("tracodcidade").value = "";
    $("tracnpj").value = "";
    $("traie").value = "";
    $("tracaminho").value = "";
    $("tolera").value = "";

    document.forms[0].listrotas.options[0].selected = true;
    document.forms[0].listservicos.options[0].selected = true;

    document.getElementById("conemb1").checked = false;
    document.getElementById("conemb2").checked = false;
    document.getElementById("conemb3").checked = false;

    document.getElementById("ocoren1").checked = false;
    document.getElementById("ocoren2").checked = false;
    document.getElementById("ocoren3").checked = false;

    document.getElementById("doccob1").checked = false;
    document.getElementById("doccob2").checked = false;
    document.getElementById("doccob3").checked = false;

    document.getElementById("notfis1").checked = false;
    document.getElementById("notfis2").checked = false;
    document.getElementById("notfis3").checked = false;

    document.getElementById("radios2").checked = true;
    document.getElementById("radiotol1").checked = true;

    for (var i = 0; i < 100; i++) {
        vetorrateio[i][0] = '';
        vetorrateio[i][1] = '';
        vetorrateio[i][2] = '';
        vetorrateio[i][3] = '';
        vetorrateio[i][4] = '';
    }
    montahtmlrateio();

}

function verifica1() {
    if (confirm("Tem certeza que deseja Excluir?\n\t")) {
        apagar($("tracodigo").value);
    }
}

function verifica() {
    if ($("tracodigo").value == "") {
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

        ajax2.open("POST", "transportadorpesquisa.php", true);
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
                    idOpcao.innerHTML = "____________________";
                }
            }
        }
        //passa o parametro
        if (document.getElementById("radio1").checked == true) {
            valor2 = "1";
        } else if (document.getElementById("radio2").checked == true) {
            valor2 = "2";
        } else {
            valor2 = "3";
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

        ajax2.open("POST", "transportadorpesquisa2.php", true);
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

        ajax2.open("POST", "transportadorpesquisa2.php", true);
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
                    idOpcao.innerHTML = "____________________";
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
            var descricaob = item.getElementsByTagName("descricaob")[0].firstChild.nodeValue;
            var descricaoc = item.getElementsByTagName("descricaoc")[0].firstChild.nodeValue;
            var descricaod = item.getElementsByTagName("descricaod")[0].firstChild.nodeValue;
            var descricaoe = item.getElementsByTagName("descricaoe")[0].firstChild.nodeValue;
            var descricaof = item.getElementsByTagName("descricaof")[0].firstChild.nodeValue;
            var descricaog = item.getElementsByTagName("descricaog")[0].firstChild.nodeValue;
            var descricaoh = item.getElementsByTagName("descricaoh")[0].firstChild.nodeValue;
            var descricaoi = item.getElementsByTagName("descricaoi")[0].firstChild.nodeValue;
            var descricaoj = item.getElementsByTagName("descricaoj")[0].firstChild.nodeValue;
            var descricaok = item.getElementsByTagName("descricaok")[0].firstChild.nodeValue;
            var descricaol = item.getElementsByTagName("descricaol")[0].firstChild.nodeValue;
            var descricaom = item.getElementsByTagName("descricaom")[0].firstChild.nodeValue;
            var tpfcodigo = item.getElementsByTagName("tpfcodigo")[0].firstChild.nodeValue;
            var tracnpj = item.getElementsByTagName("tracnpj")[0].firstChild.nodeValue;
            var traie = item.getElementsByTagName("traie")[0].firstChild.nodeValue;
            var conemb = item.getElementsByTagName("conemb")[0].firstChild.nodeValue;
            var ocoren = item.getElementsByTagName("ocoren")[0].firstChild.nodeValue;
            var doccob = item.getElementsByTagName("doccob")[0].firstChild.nodeValue;
            var notfis = item.getElementsByTagName("notfis")[0].firstChild.nodeValue;
            var tracaminho = item.getElementsByTagName("tracaminho")[0].firstChild.nodeValue;
            var tradatasul = item.getElementsByTagName("tradatasul")[0].firstChild.nodeValue;
            var traretirada = item.getElementsByTagName("traretirada")[0].firstChild.nodeValue;
            var tratptolera = item.getElementsByTagName("tratptolera")[0].firstChild.nodeValue;
            var tratolera = item.getElementsByTagName("tratolera")[0].firstChild.nodeValue;

            trimjs(codigo);
            if (txt == '0') {
                txt = '';
            }
            codigo = txt;
            trimjs(descricao);
            if (txt == '0') {
                txt = '';
            }
            descricao = txt;
            trimjs(descricaob);
            if (txt == '0') {
                txt = '';
            }
            descricaob = txt;
            trimjs(descricaoc);
            if (txt == '0') {
                txt = '';
            }
            descricaoc = txt;
            trimjs(descricaod);
            if (txt == '0') {
                txt = '';
            }
            descricaod = txt;
            trimjs(descricaoe);
            if (txt == '0') {
                txt = '';
            }
            descricaoe = txt;
            trimjs(descricaof);
            if (txt == '0') {
                txt = '';
            }
            descricaof = txt;
            trimjs(descricaog);
            if (txt == '0') {
                txt = '';
            }
            descricaog = txt;
            trimjs(descricaoh);
            if (txt == '0') {
                txt = '';
            }
            descricaoh = txt;
            trimjs(descricaoi);
            if (txt == '0') {
                txt = '';
            }
            descricaoi = txt;
            trimjs(descricaoj);
            if (txt == '0') {
                txt = '';
            }
            descricaoj = txt;
            trimjs(descricaok);
            if (txt == '0') {
                txt = '';
            }
            descricaok = txt;
            trimjs(descricaol);
            if (txt == '0') {
                txt = '';
            }
            descricaol = txt;
            trimjs(descricaom);
            if (txt == '0') {
                txt = '';
            }
            descricaom = txt;

            trimjs(tracnpj);
            if (txt == '0') {
                txt = '';
            }
            tracnpj = txt;
            trimjs(traie);
            if (txt == '0') {
                txt = '';
            }
            traie = txt;

            trimjs(conemb);
            if (txt == '0') {
                txt = '';
            }
            conemb = txt;
            trimjs(ocoren);
            if (txt == '0') {
                txt = '';
            }
            ocoren = txt;
            trimjs(doccob);
            if (txt == '0') {
                txt = '';
            }
            doccob = txt;
            trimjs(notfis);
            if (txt == '0') {
                txt = '';
            }
            notfis = txt;
            trimjs(tracaminho);
            if (txt == '0') {
                txt = '';
            }
            tracaminho = txt;
            trimjs(tradatasul);
            if (txt == '0') {
                txt = '';
            }
            tradatasul = txt;
            trimjs(traretirada);
            if (txt == '0') {
                txt = 'N';
            }
            traretirada = txt;

            //cria um novo option dinamicamente
            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto
            if (document.getElementById("radio1").checked == true) {
                novo.text = descricao;
            } else {
                novo.text = descricaob;
            }
            document.forms[0].listDados.options.add(novo);
            if (i == 0) {

                cep1 = descricaoc;

                $("tracodigo").value = codigo;
                $("tranguerra").value = descricao;
                $("trarazao").value = descricaob;
                $("tradatasul").value = tradatasul;
                $("tracep").value = descricaoc;
                $("traendereco").value = descricaod;
                $("trabairro").value = descricaoe;
                $("trafone").value = descricaof;
                $("trafax").value = descricaog;
                $("traemail").value = descricaoh;
                $("traobs").value = descricaoi;

                $("tracodcidade").value = descricaoj;
                $("tracidade").value = descricaok;
                $("trauf").value = descricaol;

                $("tracnpj").value = tracnpj;
                $("traie").value = traie;
                $("tracaminho").value = tracaminho;
                $("tolera").value = tratolera;

                if (conemb == '3') {
                    document.getElementById("conemb1").checked = true;
                } else if (conemb == '3.1') {
                    document.getElementById("conemb2").checked = true;
                } else if (conemb == '5') {
                    document.getElementById("conemb3").checked = true;
                } else {
                    document.getElementById("conemb1").checked = false;
                    document.getElementById("conemb2").checked = false;
                    document.getElementById("conemb3").checked = false;
                }

                if (ocoren == '3') {
                    document.getElementById("ocoren1").checked = true;
                } else if (ocoren == '3.1') {
                    document.getElementById("ocoren2").checked = true;
                } else if (ocoren == '5') {
                    document.getElementById("ocoren3").checked = true;
                } else {
                    document.getElementById("ocoren1").checked = false;
                    document.getElementById("ocoren2").checked = false;
                    document.getElementById("ocoren3").checked = false;
                }

                if (doccob == '3') {
                    document.getElementById("doccob1").checked = true;
                } else if (doccob == '3.1') {
                    document.getElementById("doccob2").checked = true;
                } else if (doccob == '5') {
                    document.getElementById("doccob3").checked = true;
                } else {
                    document.getElementById("doccob1").checked = false;
                    document.getElementById("doccob2").checked = false;
                    document.getElementById("doccob3").checked = false;
                }


                if (notfis == '3') {
                    document.getElementById("notfis1").checked = true;
                } else if (notfis == '3.1') {
                    document.getElementById("notfis2").checked = true;
                } else if (notfis == '5') {
                    document.getElementById("notfis3").checked = true;
                } else {
                    document.getElementById("notfis1").checked = false;
                    document.getElementById("notfis2").checked = false;
                    document.getElementById("notfis3").checked = false;
                }

                if (traretirada == 'S') {
                    document.getElementById("radios1").checked = true;
                } else {
                    document.getElementById("radios2").checked = true;
                }

                if (tratptolera == 2) {
                    $("radiotol2").checked = true;
                } else {
                    $("radiotol1").checked = true;
                }

                carrega_contatos(codigo);

                itemcombo(descricaom);
                itemcomboservico(tpfcodigo);

                $("acao").value = "alterar";
                $("botao").value = "Alterar";
            }

        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo

        cep1 = "";

        $("tracodigo").value = "";
        $("tranguerra").value = "";
        $("trarazao").value = "";
        $("tradatasul").value = "";
        $("tracep").value = "";
        $("traendereco").value = "";
        $("trabairro").value = "";
        $("trafone").value = "";
        $("trafax").value = "";
        $("traemail").value = "";
        $("traobs").value = "";

        ("tracodcidade").value = "";
        $("tracidade").value = "";
        $("trauf").value = "";

        $("tracnpj").value = "";
        $("traie").value = "";
        $("tracaminho").value = "";
        $("tolera").value = "";

        document.getElementById("conemb1").checked = false;
        document.getElementById("conemb2").checked = false;
        document.getElementById("conemb3").checked = false;
        document.getElementById("ocoren1").checked = false;
        document.getElementById("ocoren2").checked = false;
        document.getElementById("ocoren3").checked = false;
        document.getElementById("doccob1").checked = false;
        document.getElementById("doccob2").checked = false;
        document.getElementById("doccob3").checked = false;
        document.getElementById("notfis1").checked = false;
        document.getElementById("notfis2").checked = false;
        document.getElementById("notfis3").checked = false;
        document.getElementById("radios2").checked = true;
        document.getElementById("radiotol1").checked = true;

        $("acao").value = "inserir";
        $("botao").value = "Incluir";

        idOpcao.innerHTML = "____________________";

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
            var descricaob = item.getElementsByTagName("descricaob")[0].firstChild.nodeValue;
            var descricaoc = item.getElementsByTagName("descricaoc")[0].firstChild.nodeValue;
            var descricaod = item.getElementsByTagName("descricaod")[0].firstChild.nodeValue;
            var descricaoe = item.getElementsByTagName("descricaoe")[0].firstChild.nodeValue;
            var descricaof = item.getElementsByTagName("descricaof")[0].firstChild.nodeValue;
            var descricaog = item.getElementsByTagName("descricaog")[0].firstChild.nodeValue;
            var descricaoh = item.getElementsByTagName("descricaoh")[0].firstChild.nodeValue;
            var descricaoi = item.getElementsByTagName("descricaoi")[0].firstChild.nodeValue;
            var descricaoj = item.getElementsByTagName("descricaoj")[0].firstChild.nodeValue;
            var descricaok = item.getElementsByTagName("descricaok")[0].firstChild.nodeValue;
            var descricaol = item.getElementsByTagName("descricaol")[0].firstChild.nodeValue;
            var descricaom = item.getElementsByTagName("descricaom")[0].firstChild.nodeValue;
            var tpfcodigo = item.getElementsByTagName("tpfcodigo")[0].firstChild.nodeValue;
            var tracnpj = item.getElementsByTagName("tracnpj")[0].firstChild.nodeValue;
            var traie = item.getElementsByTagName("traie")[0].firstChild.nodeValue;
            var conemb = item.getElementsByTagName("conemb")[0].firstChild.nodeValue;
            var ocoren = item.getElementsByTagName("ocoren")[0].firstChild.nodeValue;
            var doccob = item.getElementsByTagName("doccob")[0].firstChild.nodeValue;
            var notfis = item.getElementsByTagName("notfis")[0].firstChild.nodeValue;
            var tracaminho = item.getElementsByTagName("tracaminho")[0].firstChild.nodeValue;
            var tradatasul = item.getElementsByTagName("tradatasul")[0].firstChild.nodeValue;
            var traretirada = item.getElementsByTagName("traretirada")[0].firstChild.nodeValue;
            var tratptolera = item.getElementsByTagName("tratptolera")[0].firstChild.nodeValue;
            var tratolera = item.getElementsByTagName("tratolera")[0].firstChild.nodeValue;

            cep1 = descricaoc;

            trimjs(codigo);
            if (txt == '0') {
                txt = '';
            }
            codigo = txt;
            trimjs(descricao);
            if (txt == '0') {
                txt = '';
            }
            descricao = txt;
            trimjs(descricaob);
            if (txt == '0') {
                txt = '';
            }
            descricaob = txt;
            trimjs(descricaoc);
            if (txt == '0') {
                txt = '';
            }
            descricaoc = txt;
            trimjs(descricaod);
            if (txt == '0') {
                txt = '';
            }
            descricaod = txt;
            trimjs(descricaoe);
            if (txt == '0') {
                txt = '';
            }
            descricaoe = txt;
            trimjs(descricaof);
            if (txt == '0') {
                txt = '';
            }
            descricaof = txt;
            trimjs(descricaog);
            if (txt == '0') {
                txt = '';
            }
            descricaog = txt;
            trimjs(descricaoh);
            if (txt == '0') {
                txt = '';
            }
            descricaoh = txt;
            trimjs(descricaoi);
            if (txt == '0') {
                txt = '';
            }
            descricaoi = txt;
            trimjs(descricaoj);
            if (txt == '0') {
                txt = '';
            }
            descricaoj = txt;
            trimjs(descricaok);
            if (txt == '0') {
                txt = '';
            }
            descricaok = txt;
            trimjs(descricaol);
            if (txt == '0') {
                txt = '';
            }
            descricaol = txt;
            trimjs(descricaom);
            if (txt == '0') {
                txt = '';
            }
            descricaom = txt;

            trimjs(tracnpj);
            if (txt == '0') {
                txt = '';
            }
            tracnpj = txt;
            trimjs(traie);
            if (txt == '0') {
                txt = '';
            }
            traie = txt;
            trimjs(tracaminho);
            if (txt == '0') {
                txt = '';
            }
            tracaminho = txt;
            trimjs(tradatasul);
            if (txt == '0') {
                txt = '';
            }
            tradatasul = txt;
            trimjs(traretirada);
            if (txt == '0') {
                txt = 'N';
            }
            traretirada = txt;

            trimjs(conemb);
            if (txt == '0') {
                txt = '';
            }
            conemb = txt;
            trimjs(ocoren);
            if (txt == '0') {
                txt = '';
            }
            ocoren = txt;
            trimjs(doccob);
            if (txt == '0') {
                txt = '';
            }
            doccob = txt;
            trimjs(notfis);
            if (txt == '0') {
                txt = '';
            }
            notfis = txt;

            $("tracodigo").value = codigo;
            $("tranguerra").value = descricao;
            $("trarazao").value = descricaob;
            $("tradatasul").value = tradatasul;
            $("tracep").value = descricaoc;
            $("traendereco").value = descricaod;
            $("trabairro").value = descricaoe;
            $("trafone").value = descricaof;
            $("trafax").value = descricaog;
            $("traemail").value = descricaoh;
            $("traobs").value = descricaoi;


            $("tracodcidade").value = descricaoj;
            $("tracidade").value = descricaok;
            $("trauf").value = descricaol;

            $("tracnpj").value = tracnpj;
            $("traie").value = traie;

            $("tracaminho").value = tracaminho;
            $("tolera").value = tratolera;

            if (conemb == '3') {
                document.getElementById("conemb1").checked = true;
            } else if (conemb == '3.1') {
                document.getElementById("conemb2").checked = true;
            } else if (conemb == '5') {
                document.getElementById("conemb3").checked = true;
            } else {
                document.getElementById("conemb1").checked = false;
                document.getElementById("conemb2").checked = false;
                document.getElementById("conemb3").checked = false;
            }

            if (ocoren == '3') {
                document.getElementById("ocoren1").checked = true;
            } else if (ocoren == '3.1') {
                document.getElementById("ocoren2").checked = true;
            } else if (ocoren == '5') {
                document.getElementById("ocoren3").checked = true;
            } else {
                document.getElementById("ocoren1").checked = false;
                document.getElementById("ocoren2").checked = false;
                document.getElementById("ocoren3").checked = false;
            }

            if (doccob == '3') {
                document.getElementById("doccob1").checked = true;
            } else if (doccob == '3.1') {
                document.getElementById("doccob2").checked = true;
            } else if (doccob == '5') {
                document.getElementById("doccob3").checked = true;
            } else {
                document.getElementById("doccob1").checked = false;
                document.getElementById("doccob2").checked = false;
                document.getElementById("doccob3").checked = false;
            }


            if (notfis == '3') {
                document.getElementById("notfis1").checked = true;
            } else if (notfis == '3.1') {
                document.getElementById("notfis2").checked = true;
            } else if (notfis == '5') {
                document.getElementById("notfis3").checked = true;
            } else {
                document.getElementById("notfis1").checked = false;
                document.getElementById("notfis2").checked = false;
                document.getElementById("notfis3").checked = false;
            }

            if (traretirada == 'S') {
                document.getElementById("radios1").checked = true;
            } else {
                document.getElementById("radios2").checked = true;
            }

            if (tratptolera == 2) {
                $("radiotol2").checked = true;
            } else {
                $("radiotol1").checked = true;
            }

            carrega_contatos(codigo);

            itemcombo(descricaom);
            itemcomboservico(tpfcodigo);

            $("acao").value = "alterar";
            $("botao").value = "Alterar";

        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo

        cep1 = "";

        $("tracodigo").value = "";
        $("tranguerra").value = "";
        $("trarazao").value = "";
        $("tradatasul").value = "";
        $("tracep").value = "";
        $("traendereco").value = "";
        $("trabairro").value = "";
        $("trafone").value = "";
        $("trafax").value = "";
        $("traemail").value = "";
        $("traobs").value = "";

        $("tracodcidade").value = "";
        $("tracidade").value = "";
        $("trauf").value = "";

        $("tracnpj").value = "";
        $("traie").value = "";
        $("tolera").value = "";

        document.getElementById("conemb1").checked = false;
        document.getElementById("conemb2").checked = false;
        document.getElementById("conemb3").checked = false;
        document.getElementById("ocoren1").checked = false;
        document.getElementById("ocoren2").checked = false;
        document.getElementById("ocoren3").checked = false;
        document.getElementById("doccob1").checked = false;
        document.getElementById("doccob2").checked = false;
        document.getElementById("doccob3").checked = false;
        document.getElementById("notfis1").checked = false;
        document.getElementById("notfis2").checked = false;
        document.getElementById("notfis3").checked = false;
        document.getElementById("radios2").checked = true;
        document.getElementById("radiotol1").checked = true;

        $("acao").value = "inserir";
        $("botao").value = "Incluir";

    }
}



function pesquisacep(valor) {

    trimjs($("tracep").value);

    if (cep1 != txt) {
        if (txt != "") {

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

                ajax2.open("POST", "ceppesquisa.php", true);
                ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                ajax2.onreadystatechange = function () {

                    //enquanto estiver processando...emite a msg de carregando
                    if (ajax2.readyState == 1) {

                    }
                    //após ser processado - chama função processXML que vai varrer os dados
                    if (ajax2.readyState == 4) {
                        if (ajax2.responseXML) {
                            processXMLCEP(ajax2.responseXML);
                        } else {
                            //caso não seja um arquivo XML emite a mensagem abaixo

                        }
                    }
                }

                //passa o parametro
                var params = "parametro=" + valor;
                ajax2.send(params);
            }

        } else
        {

            $("tracidade").value = "";
            $("trauf").value = "";
            $("tracodcidade").value = "";

        }
    }
}




function processXMLCEP(obj) {
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

            trimjs(codigo);
            if (txt == '_') {
                txt = '';
            }
            ;
            codigo = txt;
            trimjs(descricao);
            if (txt == '_') {
                txt = '';
            }
            ;
            descricao = txt;
            trimjs(descricao2);
            if (txt == '_') {
                txt = '';
            }
            ;
            descricao2 = txt;
            trimjs(descricao3);
            if (txt == '_') {
                txt = '';
            }
            ;
            descricao3 = txt;
            trimjs(descricao4);
            if (txt == '_') {
                txt = '';
            }
            ;
            descricao4 = txt;

            $("traendereco").value = descricao3;
            $("trabairro").value = descricao4;
            $("tracidade").value = descricao;
            $("trauf").value = descricao2;

            $("tracodcidade").value = codigo;


            cep1 = $("tracep").value;

        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo

        alert("O CEP não é válido!");
        document.getElementById("tracep").focus();

    }
}

function dadospesquisarota(valor) {
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
        document.forms[0].listrotas.options.length = 1;

        idOpcao = document.getElementById("opcoes2");

        ajax2.open("POST", "transportadorpesquisarota.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLrota(ajax2.responseXML);
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



function processXMLrota(obj) {
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados

        document.forms[0].listrotas.options.length = 0;

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
            novo.setAttribute("id", "opcoes2");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto
            novo.text = descricao;
            //finalmente adiciona o novo elemento
            document.forms[0].listrotas.options.add(novo);

        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "____________________";

    }

    dadospesquisaservico(0);

}


function itemcombo(valor) {

    y = document.forms[0].listrotas.options.length;

    for (var i = 0; i < y; i++) {

        document.forms[0].listrotas.options[i].selected = true;
        var l = document.forms[0].listrotas;
        //var li = l.options[l.selectedIndex].text;
        var li = l.options[l.selectedIndex].value;
        if (li == valor) {
            i = y;
        }

    }
}

function validar(obj) { // recebe um objeto
    var s = (obj.value).replace(/\D/g, '');
    var tam = (s).length; // removendo os caracteres não numéricos
    if (tam == 0) { // validando o tamanho
        return true;
    }
    if (!(tam == 14)) { // validando o tamanho
        alert("'" + s + "' Não é um CNPJ válido!"); // tamanho inválido
        obj.focus();
        return false;
    }

// se for CPF
    if (tam == 11) {
        if (!validaCPF(s)) { // chama a função que valida o CPF
            alert("'" + s + "' Não é um CPF válido!"); // se quiser mostrar o erro
            obj.select();  // se quiser selecionar o campo em questão
            return false;
        }
        alert("'" + s + "' É um CPF válido!"); // se quiser mostrar que validou
        obj.value = maskCPF(s);    // se validou o CPF mascaramos corretamente
        return true;
    }

// se for CNPJ
    if (tam == 14) {
        if (!validaCNPJ(s)) { // chama a função que valida o CNPJ
            alert("'" + s + "' Não é um CNPJ válido!"); // se quiser mostrar o erro
            obj.select();    // se quiser selecionar o campo enviado
            obj.focus();
            return false;
        }
        //alert("'"+s+"' É um CNPJ válido!" ); // se quiser mostrar que validou
        obj.value = maskCNPJ(s);    // se validou o CNPJ mascaramos corretamente
        return true;
    }
}

function validaCNPJ(CNPJ) {
    var a = new Array();
    var b = new Number;
    var c = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    for (i = 0; i < 12; i++) {
        a[i] = CNPJ.charAt(i);
        b += a[i] * c[i + 1];
    }
    if ((x = b % 11) < 2) {
        a[12] = 0
    } else {
        a[12] = 11 - x
    }
    b = 0;
    for (y = 0; y < 13; y++) {
        b += (a[y] * c[y]);
    }
    if ((x = b % 11) < 2) {
        a[13] = 0;
    } else {
        a[13] = 11 - x;
    }
    if ((CNPJ.charAt(12) != a[12]) || (CNPJ.charAt(13) != a[13])) {
        return false;
    }

    $a.get('transportadorpesquisacnpj.php', {
        cnpj: CNPJ
    },
            function (data) {
                if (!data.tracnpj == '') {
                    $a("#msg").show().text(" CNPJ já cadastrado! ");
                    alert("CNPJ já cadastrado!");
                    return false;
                }
            }, 'json');

    return true;
}

function soNums(e)
{
    if (document.all) {
        var evt = event.keyCode;
    } else {
        var evt = e.charCode;
    }
    if (evt < 20 || (evt > 47 && evt < 58)) {
        return true;
    }
    return false;
}

//    função que mascara o CPF 
function maskCPF(CPF) {
    return CPF.substring(0, 3) + "." + CPF.substring(3, 6) + "." + CPF.substring(6, 9) + "-" + CPF.substring(9, 11);
}

//    função que mascara o CNPJ 
function maskCNPJ(CNPJ) {
    return CNPJ.substring(0, 2) + "." + CNPJ.substring(2, 5) + "." + CNPJ.substring(5, 8) + "/" + CNPJ.substring(8, 12) + "-" + CNPJ.substring(12, 14);
}

function dadospesquisaend(valor) {

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
        document.forms[0].listDadosend.options.length = 1;

        idOpcaoend = document.getElementById("opcoesend");

        ajax2.open("POST", "logradourostrapesquisa.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {

            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcaoend.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLend(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                    idOpcaoend.innerHTML = "____________________";
                }
            }
        }
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLend(obj) {

    //document.forms[0].listcidades.options.length = 0;
    //document.forms[0].listbairros.options.length = 0;

    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados

        document.forms[0].listDadosend.options.length = 0;

        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
            var descricao2 = item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;
            var descricao3 = item.getElementsByTagName("descricao3")[0].firstChild.nodeValue;

            var descricao4 = item.getElementsByTagName("descricao4")[0].firstChild.nodeValue;
            var descricao5 = item.getElementsByTagName("descricao5")[0].firstChild.nodeValue;
            var cep = item.getElementsByTagName("cep")[0].firstChild.nodeValue;

            var uf = item.getElementsByTagName("uf")[0].firstChild.nodeValue;


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
            trimjs(cep);
            cep = txt;
            trimjs(uf);
            uf = txt;

            //idOpcao.innerHTML = "";

            //cria um novo option dinamicamente
            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoesend");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto
            novo.text = descricao;
            //finalmente adiciona o novo elemento
            document.forms[0].listDadosend.options.add(novo);

            document.forms[0].listDadosend.disabled = false;
            document.forms[0].listDadosend.focus();

            if (i == 0) {

                $("endcodigo").value = codigo;
                $("traendereco").value = descricao;
                $("trabairro").value = descricao2;
                $("tracidade").value = descricao4;
                $("trauf").value = uf;
                $("tracodcidade").value = descricao5;
                $("tracep").value = cep;
                cep1 = $("tracep").value;

            }


        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo

        $("endcodigo").value = "";
        $("traendereco").value = "";
        $("trabairro").value = "";
        $("tracidade").value = "";
        $("trauf").value = "";
        $("tracodcidade").value = "";
        $("tracep").value = "";

        idOpcaoend.innerHTML = "____________________";

    }
}

function dadospesquisaend2(valor) {


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

        ajax2.open("POST", "logradourostrapesquisa2.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {

            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLend2(ajax2.responseXML);
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

function processXMLend2(obj) {

    //document.forms[0].listcidades.options.length = 0;
    //document.forms[0].listbairros.options.length = 0;

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
            var cep = item.getElementsByTagName("cep")[0].firstChild.nodeValue;
            var uf = item.getElementsByTagName("uf")[0].firstChild.nodeValue;


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
            trimjs(cep);
            cep = txt;
            trimjs(uf);
            uf = txt;


            $("endcodigo").value = codigo;
            $("traendereco").value = descricao;
            $("trabairro").value = descricao2;
            $("tracidade").value = descricao4;
            $("trauf").value = uf;
            $("tracodcidade").value = descricao5;
            $("tracep").value = cep;
            cep1 = $("tracep").value;

        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo

        $("endcodigo").value = "";
        $("traendereco").value = "";
        $("trabairro").value = "";
        $("tracidade").value = "";
        $("trauf").value = "";
        $("tracodcidade").value = "";
        $("tracep").value = "";

    }
}

function desativa() {
    document.forms[0].listDadosend.disabled = true;
    document.forms[0].listDadosend.options.length = 1;
    idOpcaoend = document.getElementById("opcoesend");
    idOpcaoend.innerHTML = "____________________";
    $("traendereco").focus();

}

function incluicontato()
{

    var contato = document.getElementById("tracontato").value;
    var emailcon = document.getElementById("traemailcon").value;
    var cargo = document.getElementById("tracargo").value;

    var erro = 0;
    if (contato == "")
    {
        alert("Informe o nome do Contato!");
        erro = 1;
        return false;
    } else if (emailcon == "")
    {
        alert("Informe o e-mail!");
        erro = 1;
        return false;
    }
    if (erro == 0) {
        new ajax('incluirgeratransportadorcontato.php?flag=IncluirContato&nome=' + contato + '&email=' + emailcon + '&cargo=' + cargo, {onLoading: processandocontato, onComplete: mostracontato});
        //window.open('incluirgeratransportadorcontato.php?flag=IncluirContato&nome='+contato+'&email='+emailcon+'&cargo='+cargo, '_blank');	
    }

}

function processandocontato() {
    $("gridprodutomsg2").innerHTML = "Processando...";
}

function mostracontato(request)
{

    document.getElementById("tracontato").value = '';
    document.getElementById("traemailcon").value = '';
    document.getElementById("tracargo").value = '';

    var tabela = '';

    var xmldoc = request.responseXML;

    var dados = xmldoc.getElementsByTagName('dados')[0];

    var subtotal = 0;

    //corpo da tabela
    var registros = xmldoc.getElementsByTagName('registro');

    var itens = registros[0].getElementsByTagName('item');

    registros = 0;
    registroexistente = 0;
    for (j = 0; j < vetorrateio.length; j++)
    {
        if (vetorrateio[j][0] != '')
        {
            //testa se este produto já existe
            if (vetorrateio[j][0] == itens[0].firstChild.data)
                registroexistente++;

            //conta a quantidade de registros existentes no vetor
            registros = j;
        }
    }

    if (registroexistente > 0) {
        alert("Contato já Lançado!");
    } else {

        //pega o valor total de registros no vetor e soma mais um
        registros++;

        //Atribui os dados do produto para o vetor
        vetorrateio[registros][0] = itens[0].firstChild.data;
        vetorrateio[registros][1] = itens[1].firstChild.data;
        if (itens[2].firstChild.data == '_') {
            vetorrateio[registros][2] = '';
        } else {
            vetorrateio[registros][2] = itens[2].firstChild.data;
        }
        vetorrateio[registros][3] = '';
        vetorrateio[registros][4] = '';

        montahtmlrateio();

    }

}


function montahtmlrateio()
{

    var gridproduto2 = '<table border="1" bordercolor="C0C0C0" cellpadding="0" cellspacing="0" width="980" align="center"><tr bgcolor="#3366CC">';
    gridproduto2 += '<td width="300"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><b>Contato</b></font></td>';
    gridproduto2 += '<td width="300"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><b>Email</b></font></td>';
    gridproduto2 += '<td width="150"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><b>Cargo</b></font></td>';
    gridproduto2 += '<td align="center" width="230"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><b>Ação</b></font></td>';
    gridproduto2 += '</tr>';

    var j = 0;
    var conta = 0;

    for (j = 0; j < vetorrateio.length; j++)
    {
        if (vetorrateio[j][0] != '')
        {
            conta++;
            gridproduto2 += '<tr bgcolor="#FFFFFF">';
            gridproduto2 += "<td align='left' width='300'><input type='text' name='xnome" + j + "' id='xnome" + j + "' value='" + vetorrateio[j][0] + "' size='45' maxlength='50' style='text-align:left;' onBlur='convertField(this);atualizarrateio(" + "document.formulario.xnome" + j + ".value," + "document.formulario.xemail" + j + ".value," + "document.formulario.xcargo" + j + ".value," + j + ");'></td>";
            gridproduto2 += "<td align='left' width='300'><input type='text' name='xemail" + j + "' id='xemail" + j + "' value='" + vetorrateio[j][1] + "' size='45' maxlength='50' style='text-align:left;' onBlur='atualizarrateio(" + "document.formulario.xnome" + j + ".value," + "document.formulario.xemail" + j + ".value," + "document.formulario.xcargo" + j + ".value," + j + ");'></td>";
            gridproduto2 += "<td align='left' width='150'><input type='text' name='xcargo" + j + "' id='xcargo" + j + "' value='" + vetorrateio[j][2] + "' size='20' maxlength='20' style='text-align:left;' onBlur='convertField(this);atualizarrateio(" + "document.formulario.xnome" + j + ".value," + "document.formulario.xemail" + j + ".value," + "document.formulario.xcargo" + j + ".value," + j + ");'></td>";
            gridproduto2 += "<td align='center' width='230' style='font-size:10px;'><a href='javascript:atualizarrateio(" + "document.formulario.xnome" + j + ".value," + "document.formulario.xemail" + j + ".value," + "document.formulario.xcargo" + j + ".value," + j + ");' style='text-decoration:none; color:#000000;'><img src='images/btn_atualizar.jpg' border='0' title='Alterar' align='absmiddle'>Alterar</a> &nbsp;<a href='javascript:excluirrateio(" + j + ");' style='text-decoration:none; color:#000000;'><img src='images/btn_excluir.jpg' border='0' title='Excluir' align='absmiddle'>Excluir</a></td>";

            gridproduto2 += '</tr>';
        }
    }
    gridproduto2 += '</table>';

    if (conta == 0)
    {
        gridproduto2 = '<tr bgcolor="#FFFFFF">';
        gridproduto2 += '<td align="center" colspan="7" width="393">Nenhum contato adicionado</td>';
        gridproduto2 += '</tr>';
    }

    $("gridproduto2").innerHTML = gridproduto2;
    $("gridprodutomsg2").innerHTML = "";

}

function atualizarrateio(valor1, valor2, valor3, posicao)
{
    var erro = 0;

    if (valor1 == '')
    {
        alert("Informar o Contato!");
        erro = 1;
    } else if (valor2 == '')
    {
        alert("Informar o E-mail!");
        erro = 1;
    }


    if (erro == 0)
    {
        new ajax('incluirgeratransportadorcontato.php?flag=AlterarContato&nome=' + valor1 + '&email=' + valor2 + '&cargo=' + valor3 + '&posicao=' + posicao, {onComplete: alterarocontato});
        //alert("Contato alterado!");
    }

}

function alterarocontato(request)
{

    var xmldoc = request.responseXML;
    var dados = xmldoc.getElementsByTagName('dados')[0];
    var registros = xmldoc.getElementsByTagName('registro');
    var itens = registros[0].getElementsByTagName('item');

    var nome = itens[0].firstChild.data;
    var email = itens[1].firstChild.data;
    var cargo = itens[2].firstChild.data;
    var posicao = itens[3].firstChild.data;

    vetorrateio[posicao][0] = nome;
    vetorrateio[posicao][1] = email;
    if (cargo == '_') {
        vetorrateio[posicao][2] = '';
    } else {
        vetorrateio[posicao][2] = cargo;
    }

    montahtmlrateio();

}

function excluirrateio(produto)
{

    j = produto;

    vetorrateio[j][0] = '';
    vetorrateio[j][1] = '';
    vetorrateio[j][2] = '';
    vetorrateio[j][3] = '';
    vetorrateio[j][4] = '';

    montahtmlrateio();

}

function carrega_contatos(tracodigo) {

    for (var i = 0; i < 100; i++) {
        vetorrateio[i][0] = '';
        vetorrateio[i][1] = '';
        vetorrateio[i][2] = '';
        vetorrateio[i][3] = '';
        vetorrateio[i][4] = '';
    }

    new ajax('incluirgeratransportadorcontato.php?flag=PesquisarContato&tracodigo=' + tracodigo, {onComplete: pesquisarocontato});

}

function pesquisarocontato(request) {

    var xmldoc = request.responseXML;
    var dados = xmldoc.getElementsByTagName('dados')[0];
    var registros = xmldoc.getElementsByTagName('registro');

    for (i = 0; i < registros.length; i++)
    {
        var itens = registros[i].getElementsByTagName('item');

        var nome = itens[0].firstChild.data;
        var email = itens[1].firstChild.data;
        var cargo = itens[2].firstChild.data;

        vetorrateio[i][0] = nome;
        vetorrateio[i][1] = email;
        if (cargo == '_') {
            vetorrateio[i][2] = '';
        } else {
            vetorrateio[i][2] = cargo;
        }

    }
    montahtmlrateio();

}

function format(rnum, id)
{
    if (rnum.indexOf(',') != -1)
    {
        rnum = rnum.replace(",", ".");

    }
    if (rnum > 0)
    {
        var valor1 = Math.round(rnum * Math.pow(10, 2)) / Math.pow(10, 2);
        var valor2;

        if (valor1 >= 1)
        {
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

        document.getElementById(id).value = valor2;

    }


    if (isNaN(document.getElementById(id).value)) {

        document.getElementById(id).value = '0.00';

    }


}

function dadospesquisaservico(valor) {
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
        document.forms[0].listservicos.options.length = 1;

        idOpcao = document.getElementById("opcoes3");

        ajax2.open("POST", "transportadorpesquisaservico.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLservico(ajax2.responseXML);
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



function processXMLservico(obj) {
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados

        document.forms[0].listservicos.options.length = 0;

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
            novo.setAttribute("id", "opcoes3");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto
            novo.text = descricao;
            //finalmente adiciona o novo elemento
            document.forms[0].listservicos.options.add(novo);

        }
    } else {
        //caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "____________________";

    }
}


function itemcomboservico(valor) {

    y = document.forms[0].listservicos.options.length;

    for (var i = 0; i < y; i++) {

        document.forms[0].listservicos.options[i].selected = true;
        var l = document.forms[0].listservicos;
        //var li = l.options[l.selectedIndex].text;
        var li = l.options[l.selectedIndex].value;
        if (li == valor) {
            i = y;
        }

    }
}

function verificacnpjservico()
{
    let valor_1 = 0;
    let valor_2 = 0;
    let valor_3 = '';

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

        ajax2.open("POST", "transportadorverificacnpjservico.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLverificacnpjservico(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo

                }
            }
        }


        if ($("acao").value == "inserir")
        {
            valor_1 = 0;
        } else if ($("acao").value == "alterar")
        {
            valor_1 = document.getElementById('tracodigo').value;
        }

        valor_2 = document.forms[0].listservicos.options[document.forms[0].listservicos.selectedIndex].value;
        valor_3 = document.getElementById('tracnpj').value;

        var params = "parametro=" + valor_1 + '&parametro2=' + valor_2 + '&parametro3=' + valor_3;

        ajax2.send(params);
    }
}

function processXMLverificacnpjservico(obj)
{
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    let verifica = 0;

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados
        var item = dataArray[0];
        //contéudo dos campos no arquivo XML
        verifica = item.getElementsByTagName("verifica")[0].firstChild.nodeValue;
        const codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
        const descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

        if (verifica == 1) {
            alert('CNPJ/Tipo de Serviço já cadastrado para : ' + codigo + ' ' + descricao);
        }
    }

    if (verifica == 0) {        
        enviar();
    }

}