// JavaScript Document
//window.onload=dadospesquisaprazo();

var medio;
var maior;
var menor;
var menord;
var minimo;
var ufibge = '';
var ufibge2 = '';



function SomenteNumero(e) {
    var tecla = (window.event) ? event.keyCode : e.which;
    if ((tecla > 47 && tecla < 58))
        return true;
    else {
        if (tecla == 8 || tecla == 0)
            return true;
        else
            alert("Somente numero para este campo!");
        return false;
    }
}


function Mascara(o, f) {
    v_obj = o
    v_fun = f
    setTimeout("execmascara()", 1)
}

function execmascara() {
    v_obj.value = v_fun(v_obj.value)
}

function Telefone(v) {
    v = v.replace(/\D/g, "")
    v = v.replace(/^(\d\d)(\d)/g, "($1)$2")
    v = v.replace(/(\d{4})(\d)/, "$1-$2")
    return v
}

function enviar()
{

    let produtos = 0;

    valor = document.getElementById('fornguerra').value;

    if (document.getElementById("radioopcao1").checked == true) {
        nacional = '1'
    } else {
        nacional = '2'
    }


    if (document.getElementById("radio11").checked == true) {
        pessoa = '1'
    } else {
        pessoa = '2'
    }

    if (document.getElementById("radios1").disabled == true) {
        sintegra = '2'
    } else
    {
        if (document.getElementById("radios1").checked == true) {
            sintegra = '1'
        } else {
            sintegra = '2'
        }
    }

    if (document.getElementById("radio21").checked == true) {
        modo = '1'
    } else {
        modo = '2'
    }

    if (document.getElementById("radiotipo1").checked == true) {
        tpfornecedor = '1';
    } else if (document.getElementById("radiotipo2").checked == true) {
        tpfornecedor = '2';
    } else {
        tpfornecedor = '3';
    }

    
    if (document.getElementById("radioprod1").checked == true) {
        produtos = 1
    } else {
        produtos = 2
    }

    if ($("acao").value == "inserir")
    {

        ajax2.open("POST", "fornecedorinsere.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXMLinsere(ajax2.responseXML);
                } else
                {
                    // caso não seja um arquivo XML emite a mensagem abaixo
                    //alert('xxx');
                }
            }
        }

        var params = 'fornguerra=' + document.getElementById('fornguerra').value +
                '&forcod=' + document.getElementById('forcod').value +
                '&fordat=' + document.getElementById('fordat').value +
                '&forvtex=' + document.getElementById('forvtex').value +
                '&forprodutos=' + produtos +
                '&forrazao=' + document.getElementById('forrazao').value +
                '&forsintegra=' + document.getElementById('forsintegra').value +
                '&forcnpj=' + document.getElementById('forcnpj').value +
                '&forie=' + document.getElementById('forie').value +
                '&forrg=' + document.getElementById('forrg').value +
                '&forcpf=' + document.getElementById('forcpf').value +
                '&forobs=' + document.getElementById('forobs').value +
                '&foricms=' + document.getElementById('foricms').value +
                '&formaior=' + document.getElementById('formaior').value +
                '&formedio=' + document.getElementById('formedio').value +
                '&formenor=' + document.getElementById('formenor').value +
                '&formenord=' + document.getElementById('formenord').value +
                '&forminimo=' + document.getElementById('forminimo').value +
                '&forbanco=' + document.getElementById('forbanco').value +
                '&foragencia=' + document.getElementById('foragencia').value +
                '&forconta=' + document.getElementById('forconta').value +
                '&pracodigo=' + document.forms[0].listprazos.options[document.forms[0].listprazos.selectedIndex].value +
                '&stfcodigo=' + document.forms[0].liststatus.options[document.forms[0].liststatus.selectedIndex].value +
                '&grecodigo=' + document.forms[0].listcanais.options[document.forms[0].listcanais.selectedIndex].value +
                '&tpscodigo=' + document.forms[0].listservicos.options[document.forms[0].listservicos.selectedIndex].value +
                '&tipdespesacodigo=' + document.forms[0].listdespesas.options[document.forms[0].listdespesas.selectedIndex].value +
                '&forpessoa=' + pessoa +
                '&fpgcodigo=' + document.forms[0].listformas.options[document.forms[0].listformas.selectedIndex].value +
                '&fnecep=' + document.getElementById('fnecep').value +
                '&fneendereco=' + document.getElementById('fneendereco').value +
                '&fnebairro=' + document.getElementById('fnebairro').value +
                '&fnefone=' + document.getElementById('fnefone').value +
                '&fnefax=' + document.getElementById('fnefax').value +
                '&fneemail=' + document.getElementById('fneemail').value +
                '&fccnome1=' + document.getElementById('fccnome1').value +
                '&fccfone1=' + document.getElementById('fccfone1').value +
                '&fccemail1=' + document.getElementById('fccemail1').value +
                '&fccnome2=' + document.getElementById('fccnome2').value +
                '&fccfone2=' + document.getElementById('fccfone2').value +
                '&fccemail2=' + document.getElementById('fccemail2').value +
                '&fccnome3=' + document.getElementById('fccnome3').value +
                '&fccfone3=' + document.getElementById('fccfone3').value +
                '&fccemail3=' + document.getElementById('fccemail3').value +
                '&fnfcep=' + document.getElementById('fnfcep').value +
                '&fnfendereco=' + document.getElementById('fnfendereco').value +
                '&fnfbairro=' + document.getElementById('fnfbairro').value +
                '&fnffone=' + document.getElementById('fnffone').value +
                '&fnffax=' + document.getElementById('fnffax').value +
                '&fnfemail=' + document.getElementById('fnfemail').value +
                '&fcfnome1=' + document.getElementById('fcfnome1').value +
                '&fcffone1=' + document.getElementById('fcffone1').value +
                '&fcfemail1=' + document.getElementById('fcfemail1').value +
                '&fcfnome2=' + document.getElementById('fcfnome2').value +
                '&fcffone2=' + document.getElementById('fcffone2').value +
                '&fcfemail2=' + document.getElementById('fcfemail2').value +
                '&fcfnome3=' + document.getElementById('fcfnome3').value +
                '&fcffone3=' + document.getElementById('fcffone3').value +
                '&fcfemail3=' + document.getElementById('fcfemail3').value +
                '&fnecodcidade=' + document.getElementById('fnecodcidade').value +
                '&fnfcodcidade=' + document.getElementById('fnfcodcidade').value +
                '&fnenumero=' + document.getElementById('fnenumero').value +
                '&fnfnumero=' + document.getElementById('fnfnumero').value +
                '&forsintegrasn=' + sintegra +
                '&formodo=' + modo +
                '&tpfornecedor=' + tpfornecedor +
                '&cidcodigoibge=' + document.getElementById('cidadeibge').value +
                '&cidcodigoibge2=' + document.getElementById('cidadeibge2').value +
                '&fornacional=' + nacional

        ajax2.send(params);


    } else if ($("acao").value == "alterar")
    {

        new ajax('fornecedoraltera.php?fornguerra=' + document.getElementById('fornguerra').value +
                "&forcodigo=" + document.getElementById('forcodigo').value +
                '&forcod=' + document.getElementById('forcod').value +
                '&fordat=' + document.getElementById('fordat').value +
                '&forvtex=' + document.getElementById('forvtex').value +
                '&forprodutos=' + produtos +
                '&forrazao=' + document.getElementById('forrazao').value +
                '&forsintegra=' + document.getElementById('forsintegra').value +
                '&forcnpj=' + document.getElementById('forcnpj').value +
                '&forie=' + document.getElementById('forie').value +
                '&forrg=' + document.getElementById('forrg').value +
                '&forcpf=' + document.getElementById('forcpf').value +
                '&forobs=' + document.getElementById('forobs').value +
                '&foricms=' + document.getElementById('foricms').value +
                '&formaior=' + document.getElementById('formaior').value +
                '&formedio=' + document.getElementById('formedio').value +
                '&formenor=' + document.getElementById('formenor').value +
                '&formenord=' + document.getElementById('formenord').value +
                '&forminimo=' + document.getElementById('forminimo').value +
                '&forbanco=' + document.getElementById('forbanco').value +
                '&foragencia=' + document.getElementById('foragencia').value +
                '&forconta=' + document.getElementById('forconta').value +
                '&pracodigo=' + document.forms[0].listprazos.options[document.forms[0].listprazos.selectedIndex].value +
                '&stfcodigo=' + document.forms[0].liststatus.options[document.forms[0].liststatus.selectedIndex].value +
                '&grecodigo=' + document.forms[0].listcanais.options[document.forms[0].listcanais.selectedIndex].value +
                '&tpscodigo=' + document.forms[0].listservicos.options[document.forms[0].listservicos.selectedIndex].value +
                '&tipdespesacodigo=' + document.forms[0].listdespesas.options[document.forms[0].listdespesas.selectedIndex].value +
                '&forpessoa=' + pessoa +
                '&fpgcodigo=' + document.forms[0].listformas.options[document.forms[0].listformas.selectedIndex].value +
                '&fnecep=' + document.getElementById('fnecep').value +
                '&fneendereco=' + document.getElementById('fneendereco').value +
                '&fnebairro=' + document.getElementById('fnebairro').value +
                '&fnefone=' + document.getElementById('fnefone').value +
                '&fnefax=' + document.getElementById('fnefax').value +
                '&fneemail=' + document.getElementById('fneemail').value +
                '&fccnome1=' + document.getElementById('fccnome1').value +
                '&fccfone1=' + document.getElementById('fccfone1').value +
                '&fccemail1=' + document.getElementById('fccemail1').value +
                '&fccnome2=' + document.getElementById('fccnome2').value +
                '&fccfone2=' + document.getElementById('fccfone2').value +
                '&fccemail2=' + document.getElementById('fccemail2').value +
                '&fccnome3=' + document.getElementById('fccnome3').value +
                '&fccfone3=' + document.getElementById('fccfone3').value +
                '&fccemail3=' + document.getElementById('fccemail3').value +
                '&fnfcep=' + document.getElementById('fnfcep').value +
                '&fnfendereco=' + document.getElementById('fnfendereco').value +
                '&fnfbairro=' + document.getElementById('fnfbairro').value +
                '&fnffone=' + document.getElementById('fnffone').value +
                '&fnffax=' + document.getElementById('fnffax').value +
                '&fnfemail=' + document.getElementById('fnfemail').value +
                '&fcfnome1=' + document.getElementById('fcfnome1').value +
                '&fcffone1=' + document.getElementById('fcffone1').value +
                '&fcfemail1=' + document.getElementById('fcfemail1').value +
                '&fcfnome2=' + document.getElementById('fcfnome2').value +
                '&fcffone2=' + document.getElementById('fcffone2').value +
                '&fcfemail2=' + document.getElementById('fcfemail2').value +
                '&fcfnome3=' + document.getElementById('fcfnome3').value +
                '&fcffone3=' + document.getElementById('fcffone3').value +
                '&fcfemail3=' + document.getElementById('fcfemail3').value +
                '&fnecodcidade=' + document.getElementById('fnecodcidade').value +
                '&fnfcodcidade=' + document.getElementById('fnfcodcidade').value +
                '&fnenumero=' + document.getElementById('fnenumero').value +
                '&fnfnumero=' + document.getElementById('fnfnumero').value +
                '&forsintegrasn=' + sintegra +
                '&formodo=' + modo +
                '&tpfornecedor=' + tpfornecedor +
                '&cidcodigoibge=' + document.getElementById('cidadeibge').value +
                '&cidcodigoibge2=' + document.getElementById('cidadeibge2').value +
                '&fornacional=' + nacional
                , {onComplete: alterado});



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
            // atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes");
            // atribui um valor
            novo.value = document.getElementById('forcodigo').value;
            // atribui um texto
            novo.text = document.getElementById('fornguerra').value;
            // finalmente adiciona o novo elemento

            if (document.getElementById("radio1").checked == true) {
                novo.text = document.getElementById('forcod').value;
            } else if (document.getElementById("radio2").checked == true) {
                novo.text = document.getElementById('fornguerra').value;
            } else if (document.getElementById("radio3").checked == true) {
                novo.text = document.getElementById('forrazao').value;
            } else if (document.getElementById("radio4").checked == true) {
                novo.text = document.getElementById('forcnpj').value;
            } else
            {
                novo.text = document.getElementById('forcpf').value;
            }

            document.forms[0].listDados.options.add(novo);

            alert("Registro alterado com sucesso!");
            $('MsgResultado').innerHTML = "Alterado com sucesso!";
            $('MsgResultado2').innerHTML = "Alterado com sucesso!";

            document.location.reload();
        }

    }

}

function valida_form(tipo)
{
    var erro = 0;

    if ($("fornguerra").value == "")
    {
        alert("Preencha o campo Nome de Guerra");
        $("fornguerra").focus();
        erro = 1;
    } else if ($("forrazao").value == "")
    {
        alert("Preencha o campo Razão Social");
        $("forrazao").focus();
        erro = 1;
    } else if ($("radio11").checked == true && $('forcnpj').value == '' && $("radioopcao1").checked == true)
    {
        alert("Preencha o campo CNPJ corretamente!");
        $('forcnpj').focus();
        erro = 1;
    } else if ($("radio11").checked == true && validar($('forcnpj')) == false)
    {
        // O alert é dado dentro da função
        erro = 1;
    } else if ($("radio12").checked == true && $('forcpf').value == '')
    {
        alert("Preencha o campo CPF corretamente!");
        $('forcpf').focus();
        erro = 1;
    } else if ($("radio12").checked == true && validar2($('forcpf')) == false)
    {
        // O alert é dado dentro da função
        erro = 1;
    } else if ($("forsintegra").value == "")
    {
        if (tipo == 1)
        {
            alert("Preencha o campo sintegra");
            $("forsintegra").focus();
            erro = 1;
        }
    } else if ($('fnecep').value == '')
    {
        alert("Preencha o campo CEP corretamente!");
        $('fnecep').focus();
        erro = 1;
    } else if ($('fnenumero').value == '')
    {
        alert("Preencha o campo Numero corretamente!");
        $('fnenumero').focus();
        erro = 1;
    } else if ($('cidadeibge').options[$('cidadeibge').selectedIndex].value == '0')
    {
        alert("Selecione uma CIDADE IBGE!");
        $('cidadeibge').focus();
        erro = 1;
    }

    if ($("foricms").value == "") {
        $("foricms").value = 0;
    }
    ;
    if ($("formaior").value == "") {
        $("formaior").value = 0;
    }
    ;
    if ($("formedio").value == "") {
        $("formedio").value = 0;
    }
    ;
    if ($("formenor").value == "") {
        $("formenor").value = 0;
    }
    ;
    if ($("formenord").value == "") {
        $("formenord").value = 0;
    }
    ;
    if ($("forminimo").value == "") {
        $("forminimo").value = 0;
    }
    ;

    if ($("fnecodcidade").value == "") {
        $("fnecodcidade").value = 0;
    }
    ;
    if ($("fnfcodcidade").value == "") {
        $("fnfcodcidade").value = 0;
    }
    ;

    if (erro == 0)
        verificacnpjcpf();
}

function verificacnpjcpf()
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

        ajax2.open("POST", "fornecedorverificacnpjcpf.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLverificacnpjcpf(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo

                }
            }
        }

        var pessoa = 0;
        var cnpj = '';
        var cpf = '';

        if (document.getElementById("radio11").checked == true) {
            pessoa = '1';
            cnpj = document.getElementById('forcnpj').value;
        } else {
            pessoa = '2';
            cpf = document.getElementById('forcpf').value;
        }

        if ($("acao").value == "inserir")
        {
            valor = 0;
            valor2 = pessoa;
            valor3 = cnpj;
            valor4 = cpf;
        } else if ($("acao").value == "alterar")
        {
            valor = document.getElementById('forcodigo').value;
            valor2 = pessoa;
            valor3 = cnpj;
            valor4 = cpf;
        }

        var params = "parametro=" + valor + '&parametro2=' + valor2 + '&parametro3=' + valor3 + '&parametro4=' + valor4;

        ajax2.send(params);
    }
}

function processXMLverificacnpjcpf(obj)
{

    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    var erro = 1;

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados
        var item = dataArray[0];
        //contéudo dos campos no arquivo XML

        var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
        var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

        if (codigo != '0') {
            alert('CNPJ/CPF já cadastrado para o fornecedor: ' + codigo + ' ' + descricao);
        } else {
            erro = 0;
        }

    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo

    }

    if (erro == 0) {
        enviar();
        //alert('Enviar');
    }

}

function limpa_form(tipo)
{
    cep1 = "";
    cep2 = "";

    ufibge = '';
    ufibge2 = '';

    $("acao").value = "inserir";
    $("botao").value = "Incluir";
    $("fornguerra").value = "";
    $("fordat").value = "";
    $("forvtex").value = "";

    $("forcod").value = "";
    $("forcodigo").value = "";

    $("forrazao").value = "";
    $("forsintegra").value = "";
    $("forcnpj").value = "";
    $("forie").value = "";
    $("forrg").value = "";
    $("forcpf").value = "";
    $("forobs").value = "";
    $("foricms").value = "";
    $("formaior").value = "";
    $("formedio").value = "";
    $("formenor").value = "";
    $("formenord").value = "";
    $("forminimo").value = "";
    $("forbanco").value = "";
    $("foragencia").value = "";
    $("forconta").value = "";
    $("pesquisa").value = "";
    document.getElementById("radioopcao1").checked = true;
    $("forcnpj").disabled = false;
    $("forie").disabled = false;
    $("forrg").value = "";
    $("forcpf").value = "";
    $("forrg").disabled = true;
    $("forcpf").disabled = true;
    document.getElementById("radio11").checked = true;
    document.getElementById("radio11").disabled = false;
    document.getElementById("radio12").disabled = false;

    document.getElementById("radio11").checked = true;
    document.forms[0].listDados.options.length = 1;
    idOpcao = document.getElementById("opcoes");
    idOpcao.innerHTML = "____________________";
    document.forms[0].listprazos.options[0].selected = true;
    document.forms[0].liststatus.options[0].selected = true;
    document.forms[0].listcanais.options[0].selected = true;
    document.forms[0].listservicos.options[0].selected = true;
    document.forms[0].listformas.options[0].selected = true;
    document.forms[0].listdespesas.options[0].selected = true;
    $("fnecep").value = "";
    $("fneendereco").value = "";
    $("fnebairro").value = "";

    $("fnecidade").value = "";
    $("fneuf").value = "";

    $("fnefone").value = "";
    $("fnefax").value = "";
    $("fneemail").value = "";
    $("fccnome1").value = "";
    $("fccfone1").value = "";
    $("fccemail1").value = "";
    $("fccnome2").value = "";
    $("fccfone2").value = "";
    $("fccemail2").value = "";
    $("fccnome3").value = "";
    $("fccfone3").value = "";
    $("fccemail3").value = "";
    $("fnfcep").value = "";
    $("fnfendereco").value = "";
    $("fnfbairro").value = "";
    $("fnenumero").value = "";
    $("fnfnumero").value = "";

    $("fnfcidade").value = "";
    $("fnfuf").value = "";

    $("fnffone").value = "";
    $("fnffax").value = "";
    $("fnfemail").value = "";
    $("fcfnome1").value = "";
    $("fcffone1").value = "";
    $("fcfemail1").value = "";
    $("fcfnome2").value = "";
    $("fcffone2").value = "";
    $("fcfemail2").value = "";
    $("fcfnome3").value = "";
    $("fcffone3").value = "";
    $("fcfemail3").value = "";

    $("fnecodcidade").value = "";
    $("fnfcodcidade").value = "";

    document.getElementById("radios2").checked = true;
    document.getElementById("radioprod2").checked = true;
    document.getElementById("radio21").checked = true;

    document.getElementById("radiotipo1").checked = true;

    maior = "";
    medio = "";
    menor = "";
    menord = "";
    minimo = "";

    $('cidadeibge').innerHTML = '<option id="cidcodigoibge" value="0">____________________________________</option>';
    document.getElementById("cidadeibge").disabled = true;

    $('cidadeibge2').innerHTML = '<option id="cidcodigoibge2" value="0">____________________________________</option>';
    document.getElementById("cidadeibge2").disabled = true;

    codigo_fornecedor(tipo);
}

function limpa_form2()
{
    cep1 = "";
    cep2 = "";

    ufibge = '';
    ufibge2 = '';

    $("acao").value = "inserir";
    $("botao").value = "Incluir";
    $("forcodigo").value = "";
    $("fornguerra").value = "";
    $("fordat").value = "";
    $("forvtex").value = "";
    $("forcod").value = "";
    $("forrazao").value = "";
    $("forsintegra").value = "";
    $("forcnpj").value = "";
    $("forie").value = "";
    $("forrg").value = "";
    $("forcpf").value = "";
    $("forobs").value = "";
    $("foricms").value = "";
    $("formaior").value = "";
    $("formedio").value = "";
    $("formenor").value = "";
    $("formenord").value = "";
    $("forminimo").value = "";
    $("forbanco").value = "";
    $("foragencia").value = "";
    $("forconta").value = "";
    document.getElementById("radioopcao1").checked = true;
    $("forcnpj").disabled = false;
    $("forie").disabled = false;
    $("forrg").value = "";
    $("forcpf").value = "";
    $("forrg").disabled = true;
    $("forcpf").disabled = true;
    document.getElementById("radio11").checked = true;
    document.getElementById("radio11").disabled = false;
    document.getElementById("radio12").disabled = false;
    document.getElementById("radio11").checked = true;
    document.forms[0].listprazos.options[0].selected = true;
    document.forms[0].liststatus.options[0].selected = true;
    document.forms[0].listcanais.options[0].selected = true;
    document.forms[0].listservicos.options[0].selected = true;
    document.forms[0].listformas.options[0].selected = true;
    document.forms[0].listdespesas.options[0].selected = true;
    $("fnecep").value = "";
    $("fneendereco").value = "";
    $("fnebairro").value = "";

    $("fnecidade").value = "";
    $("fneuf").value = "";

    $("fnefone").value = "";
    $("fnefax").value = "";
    $("fneemail").value = "";
    $("fccnome1").value = "";
    $("fccfone1").value = "";
    $("fccemail1").value = "";
    $("fccnome2").value = "";
    $("fccfone2").value = "";
    $("fccemail2").value = "";
    $("fccnome3").value = "";
    $("fccfone3").value = "";
    $("fccemail3").value = "";
    $("fnfcep").value = "";
    $("fnfendereco").value = "";
    $("fnfbairro").value = "";
    $("fnfnumero").value = "";
    $("fnfnumero").value = "";


    $("fnfcidade").value = "";
    $("fnfuf").value = "";

    $("fnffone").value = "";
    $("fnffax").value = "";
    $("fnfemail").value = "";
    $("fcfnome1").value = "";
    $("fcffone1").value = "";
    $("fcfemail1").value = "";
    $("fcfnome2").value = "";
    $("fcffone2").value = "";
    $("fcfemail2").value = "";
    $("fcfnome3").value = "";
    $("fcffone3").value = "";
    $("fcfemail3").value = "";
    $("pesquisa").value = "";

    $("fnecodcidade").value = "";
    $("fnfcodcidade").value = "";

    document.getElementById("radios2").checked = true;
    document.getElementById("radioprod2").checked = true;
    document.getElementById("radio21").checked = true;

    $('cidadeibge').innerHTML = '<option id="cidcodigoibge" value="0">____________________________________</option>';
    document.getElementById("cidadeibge").disabled = true;

    $('cidadeibge2').innerHTML = '<option id="cidcodigoibge2" value="0">____________________________________</option>';
    document.getElementById("cidadeibge2").disabled = true;

    maior = "";
    medio = "";
    menor = "";
    menord = "";
    minimo = "";
}

function dadospesquisa(valor)
{
    $('MsgResultado').innerHTML = "Processando...";
    $('MsgResultado2').innerHTML = "Processando...";
    // verifica se o browser tem suporte a ajax
    try {
        ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (e)
    {
        try {
            ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (ex)
        {
            try {
                ajax2 = new XMLHttpRequest();
            } catch (exc) {
                alert("Esse browser não tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    // se tiver suporte ajax
    if (ajax2)
    {
        // deixa apenas o elemento 1 no option, os outros são excluídos
        document.forms[0].listDados.options.length = 1;

        idOpcao = document.getElementById("opcoes");

        ajax2.open("POST", "fornecedorpesquisa.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            // enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            // após ser processado - chama função processXML que vai varrer os
            // dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXML(ajax2.responseXML);
                } else
                {
                    // caso não seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "____________________";
                    alert("Nenhum Registro encontrado!");
                    limpa_form();
                    $('MsgResultado').innerHTML = "Nenhum Registro encontrado!";
                    $('MsgResultado2').innerHTML = "Nenhum Registro encontrado!";
                }
            }
        }
        // passa o parametro
        if (document.getElementById("radio1").checked == true) {
            valor2 = "1";
        } else if (document.getElementById("radio2").checked == true) {
            valor2 = "2";
        } else if (document.getElementById("radio3").checked == true) {
            valor2 = "3";
        } else if (document.getElementById("radio4").checked == true) {
            valor2 = "4";
        } else {
            valor2 = "5";
        }
        var params = "parametro=" + valor + '&parametro2=' + valor2;

        if (valor != "")
            ajax2.send(params);
    }
}

function dadospesquisa2(valor)
{
    $('MsgResultado').innerHTML = "Processando...";
    $('MsgResultado2').innerHTML = "Processando...";
    // verifica se o browser tem suporte a ajax
    try {
        ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (e)
    {
        try {
            ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (ex)
        {
            try {
                ajax2 = new XMLHttpRequest();
            } catch (exc)
            {
                alert("Esse browser não tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    // se tiver suporte ajax
    if (ajax2)
    {
        ajax2.open("POST", "fornecedorpesquisa.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            // enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
            }
            // após ser processado - chama função processXML que vai varrer os
            // dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML) {
                    processXML2(ajax2.responseXML);
                } else {
                    // caso não seja um arquivo XML emite a mensagem abaixo
                }
            }
        }
        // passa o parametro escolhido
        var params = "parametro=" + valor + '&parametro2=6';
        ajax2.send(params);
    }
}

function dadospesquisa3(valor)
{
    $('MsgResultado').innerHTML = "Processando...";
    $('MsgResultado2').innerHTML = "Processando...";
    // verifica se o browser tem suporte a ajax
    try {
        ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (e)
    {
        try {
            ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (ex)
        {
            try {
                ajax2 = new XMLHttpRequest();
            } catch (exc) {
                alert("Esse browser não tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    // se tiver suporte ajax
    if (ajax2)
    {
        // deixa apenas o elemento 1 no option, os outros são excluídos
        document.forms[0].listDados.options.length = 1;

        idOpcao = document.getElementById("opcoes");

        ajax2.open("POST", "fornecedorpesquisa.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            // enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            // após ser processado - chama função processXML que vai varrer os
            // dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML) {
                    processXML3(ajax2.responseXML);
                } else {
                    // caso não seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "____________________";
                    alert("Nenhum Registro encontrado!");
                    limpa_form();
                    $('MsgResultado').innerHTML = "Nenhum Registro encontrado!";
                    $('MsgResultado2').innerHTML = "Nenhum Registro encontrado!";
                }
            }
        }
        // passa o parametro escolhido
        var params = "parametro=" + valor + '&parametro2=6';
        ajax2.send(params);
    }
}

function processXML(obj)
{
    // pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    // total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        // percorre o arquivo XML paara extrair os dados

        document.forms[0].listDados.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            // contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var fordat = item.getElementsByTagName("fordat")[0].firstChild.nodeValue;
            var forvtex = item.getElementsByTagName("forvtex")[0].firstChild.nodeValue;
            var forprodutos = item.getElementsByTagName("forprodutos")[0].firstChild.nodeValue;
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
            var descricaomd = item.getElementsByTagName("descricaomd")[0].firstChild.nodeValue;
            var descricaon = item.getElementsByTagName("descricaon")[0].firstChild.nodeValue;
            var descricaoo = item.getElementsByTagName("descricaoo")[0].firstChild.nodeValue;
            var descricaop = item.getElementsByTagName("descricaop")[0].firstChild.nodeValue;
            var descricaoq = item.getElementsByTagName("descricaoq")[0].firstChild.nodeValue;
            var descricaor = item.getElementsByTagName("descricaor")[0].firstChild.nodeValue;
            var tipdespesacodigo = item.getElementsByTagName("tipdespesacodigo")[0].firstChild.nodeValue;
            var descricaos = item.getElementsByTagName("descricaos")[0].firstChild.nodeValue;
            var codigocanal = item.getElementsByTagName("codigocanal")[0].firstChild.nodeValue;
            var descricaot = item.getElementsByTagName("descricaot")[0].firstChild.nodeValue;
            var descricaou = item.getElementsByTagName("descricaou")[0].firstChild.nodeValue;
            var descricao2a = item.getElementsByTagName("descricao2a")[0].firstChild.nodeValue;
            var descricao2b = item.getElementsByTagName("descricao2b")[0].firstChild.nodeValue;
            var descricao2c = item.getElementsByTagName("descricao2c")[0].firstChild.nodeValue;
            var descricao2d = item.getElementsByTagName("descricao2d")[0].firstChild.nodeValue;
            var descricao2e = item.getElementsByTagName("descricao2e")[0].firstChild.nodeValue;
            var descricao2f = item.getElementsByTagName("descricao2f")[0].firstChild.nodeValue;
            var descricao3a = item.getElementsByTagName("descricao3a")[0].firstChild.nodeValue;
            var descricao3b = item.getElementsByTagName("descricao3b")[0].firstChild.nodeValue;
            var descricao3d = item.getElementsByTagName("descricao3d")[0].firstChild.nodeValue;
            var descricao4a = item.getElementsByTagName("descricao4a")[0].firstChild.nodeValue;
            var descricao4b = item.getElementsByTagName("descricao4b")[0].firstChild.nodeValue;
            var descricao4d = item.getElementsByTagName("descricao4d")[0].firstChild.nodeValue;
            var descricao5a = item.getElementsByTagName("descricao5a")[0].firstChild.nodeValue;
            var descricao5b = item.getElementsByTagName("descricao5b")[0].firstChild.nodeValue;
            var descricao5d = item.getElementsByTagName("descricao5d")[0].firstChild.nodeValue;
            var descricao6a = item.getElementsByTagName("descricao6a")[0].firstChild.nodeValue;
            var descricao6b = item.getElementsByTagName("descricao6b")[0].firstChild.nodeValue;
            var descricao6c = item.getElementsByTagName("descricao6c")[0].firstChild.nodeValue;
            var descricao6d = item.getElementsByTagName("descricao6d")[0].firstChild.nodeValue;
            var descricao6e = item.getElementsByTagName("descricao6e")[0].firstChild.nodeValue;
            var descricao6f = item.getElementsByTagName("descricao6f")[0].firstChild.nodeValue;
            var descricao7a = item.getElementsByTagName("descricao7a")[0].firstChild.nodeValue;
            var descricao7b = item.getElementsByTagName("descricao7b")[0].firstChild.nodeValue;
            var descricao7d = item.getElementsByTagName("descricao7d")[0].firstChild.nodeValue;
            var descricao8a = item.getElementsByTagName("descricao8a")[0].firstChild.nodeValue;
            var descricao8b = item.getElementsByTagName("descricao8b")[0].firstChild.nodeValue;
            var descricao8d = item.getElementsByTagName("descricao8d")[0].firstChild.nodeValue;
            var descricao9a = item.getElementsByTagName("descricao9a")[0].firstChild.nodeValue;
            var descricao9b = item.getElementsByTagName("descricao9b")[0].firstChild.nodeValue;
            var descricao9d = item.getElementsByTagName("descricao9d")[0].firstChild.nodeValue;

            var descricaov = item.getElementsByTagName("descricaov")[0].firstChild.nodeValue;
            var descricaox = item.getElementsByTagName("descricaox")[0].firstChild.nodeValue;
            var descricaoz = item.getElementsByTagName("descricaoz")[0].firstChild.nodeValue;

            var descricaov2 = item.getElementsByTagName("descricaov2")[0].firstChild.nodeValue;
            var descricaox2 = item.getElementsByTagName("descricaox2")[0].firstChild.nodeValue;
            var descricaoz2 = item.getElementsByTagName("descricaoz2")[0].firstChild.nodeValue;
            var descricaoaa = item.getElementsByTagName("descricaoaa")[0].firstChild.nodeValue;
            var codigoa = item.getElementsByTagName("codigoa")[0].firstChild.nodeValue;
            var descricaoab = item.getElementsByTagName("descricaoab")[0].firstChild.nodeValue;
            var descricaoac = item.getElementsByTagName("descricaoac")[0].firstChild.nodeValue;

            var xfortipo = item.getElementsByTagName("fortipo")[0].firstChild.nodeValue;

            var descricaoib = item.getElementsByTagName("descricaoib")[0].firstChild.nodeValue;
            var descricaoib2 = item.getElementsByTagName("descricaoib2")[0].firstChild.nodeValue;

            var cidadeibge = item.getElementsByTagName("cidadeibge")[0].firstChild.nodeValue;
            var cidadeibge2 = item.getElementsByTagName("cidadeibge2")[0].firstChild.nodeValue;

            var fnenumero = item.getElementsByTagName("fnenumero")[0].firstChild.nodeValue;
            var fnfnumero = item.getElementsByTagName("fnfnumero")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;

            trimjs(fordat);
            if (txt == '0') {
                txt = '';
            }
            fordat = txt;

            trimjs(forvtex);
            if (txt == '0') {
                txt = '';
            }
            forvtex = txt;

            trimjs(descricao);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao = txt;
            trimjs(descricaob);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaob = txt;
            trimjs(descricaoc);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoc = txt;
            trimjs(descricaod);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaod = txt;
            trimjs(descricaoe);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoe = txt;
            trimjs(descricaof);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaof = txt;
            trimjs(descricaog);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaog = txt;
            trimjs(descricaoh);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoh = txt;
            trimjs(descricaoi);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoi = txt;
            trimjs(descricaoj);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoj = txt;
            trimjs(descricaok);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaok = txt;
            trimjs(descricaol);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaol = txt;
            trimjs(descricaom);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaom = txt;
            trimjs(descricaomd);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaomd = txt;
            trimjs(descricaon);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaon = txt;
            trimjs(descricaoo);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoo = txt;
            trimjs(descricaop);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaop = txt;
            trimjs(descricaoq);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoq = txt;
            trimjs(descricaor);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaor = txt;
            trimjs(tipdespesacodigo);
            if (txt == '0') {
                txt = '0';
            }
            ;
            tipdespesacodigo = txt;
            trimjs(descricaos);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaos = txt;
            trimjs(descricaot);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaot = txt;
            trimjs(descricaou);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaou = txt;
            trimjs(descricao2a);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao2a = txt;
            trimjs(descricao2b);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao2b = txt;
            trimjs(descricao2c);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao2c = txt;
            trimjs(descricao2d);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao2d = txt;
            trimjs(descricao2e);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao2e = txt;
            trimjs(descricao2f);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao2f = txt;

            trimjs(descricao3a);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao3a = txt;
            trimjs(descricao3b);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao3b = txt;
            trimjs(descricao3d);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao3d = txt;

            trimjs(descricao4a);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao4a = txt;
            trimjs(descricao4b);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao4b = txt;
            trimjs(descricao4d);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao4d = txt;

            trimjs(descricao5a);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao5a = txt;
            trimjs(descricao5b);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao5b = txt;
            trimjs(descricao5d);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao5d = txt;

            trimjs(descricao6a);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao6a = txt;
            trimjs(descricao6b);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao6b = txt;
            trimjs(descricao6c);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao6c = txt;
            trimjs(descricao6d);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao6d = txt;
            trimjs(descricao6e);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao6e = txt;
            trimjs(descricao6f);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao6f = txt;

            trimjs(descricao7a);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao7a = txt;
            trimjs(descricao7b);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao7b = txt;
            trimjs(descricao7d);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao7d = txt;

            trimjs(descricao8a);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao8a = txt;
            trimjs(descricao8b);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao8b = txt;
            trimjs(descricao8d);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao8d = txt;

            trimjs(descricao9a);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao9a = txt;
            trimjs(descricao9b);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao9b = txt;
            trimjs(descricao9d);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao9d = txt;

            trimjs(descricaov);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaov = txt;
            trimjs(descricaox);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaox = txt;
            trimjs(descricaoz);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoz = txt;


            trimjs(descricaov2);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaov2 = txt;
            trimjs(descricaox2);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaox2 = txt;
            trimjs(descricaoz2);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoz2 = txt;

            trimjs(descricaoaa);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoaa = txt;
            trimjs(codigoa);
            if (txt == '0') {
                txt = '';
            }
            ;
            codigoa = txt;
            trimjs(descricaoab);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoab = txt;
            trimjs(descricaoac);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoac = txt;

            trimjs(xfortipo);
            if (txt == '0') {
                txt = '1';
            }
            ;
            xfortipo = txt;

            trimjs(descricaoib);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoib = txt;
            trimjs(descricaoib2);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoib2 = txt;
            trimjs(cidadeibge);
            if (txt == '0') {
                txt = '';
            }
            ;
            cidadeibge = txt;
            trimjs(cidadeibge2);
            if (txt == '0') {
                txt = '';
            }
            ;
            cidadeibge2 = txt;

            trimjs(fnenumero);
            if (txt == '0') {
                txt = '';
            }
            ;
            fnenumero = txt;
            trimjs(fnfnumero);
            if (txt == '0') {
                txt = '';
            }
            ;
            fnfnumero = txt;


            // cria um novo option dinamicamente
            var novo = document.createElement("option");
            // atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes");
            // atribui um valor
            novo.value = codigo;
            // atribui um texto
            if (document.getElementById("radio1").checked == true) {
                novo.text = descricaob;
            } else if (document.getElementById("radio2").checked == true) {
                novo.text = descricao;
            } else if (document.getElementById("radio3").checked == true) {
                novo.text = descricaoc;
            } else if (document.getElementById("radio4").checked == true) {
                novo.text = descricaoe;
            } else
            {
                novo.text = descricaoh;
            }
            // finalmente adiciona o novo elemento
            document.forms[0].listDados.options.add(novo);

            if (i == 0)
            {
                cep1 = descricao2a;
                cep2 = descricao6a;

                maior = descricaok;
                medio = descricaol;
                menor = descricaom;
                menord = descricaomd;
                minimo = descricaon;

                $("forcodigo").value = codigo;
                $("fordat").value = fordat;
                $("forvtex").value = forvtex;
                $("fornguerra").value = descricao;
                $("forcod").value = descricaob;
                $("forrazao").value = descricaoc;
                $("forsintegra").value = descricaod;
                $("forcnpj").value = descricaoe;
                $("forie").value = descricaof;
                $("forrg").value = descricaog;
                $("forcpf").value = descricaoh;
                $("forobs").value = descricaoi;
                $("foricms").value = descricaoj;
                $("formaior").value = descricaok;
                $("formedio").value = descricaol;
                $("formenor").value = descricaom;
                $("formenord").value = descricaomd;
                $("forminimo").value = descricaon;
                $("forbanco").value = descricaoo;
                $("foragencia").value = descricaop;
                $("forconta").value = descricaoq;
                itemcomboprazo(descricaor);
                itemcombostatus(descricaos);
                itemcombocanais(codigocanal);
                itemcomboservico(descricaot);
                itemcomboforma(codigoa);
                itemcombotipodespesa(tipdespesacodigo);
                if (descricaou == '1')
                {
                    document.getElementById("radio11").checked = true;
                    $("forcnpj").disabled = false;
                    $("forie").disabled = false;
                    $("forrg").disabled = true;
                    $("forcpf").disabled = true;
                } else
                {
                    document.getElementById("radio12").checked = true;
                    $("forcnpj").disabled = true;
                    $("forie").disabled = true;
                    $("forrg").disabled = false;
                    $("forcpf").disabled = false;
                }
                $("fnecep").value = descricao2a;
                $("fneendereco").value = descricao2b;
                $("fnebairro").value = descricao2c;
                $("fnefone").value = descricao2d;
                $("fnefax").value = descricao2e;
                $("fneemail").value = descricao2f;
                $("fnfcep").value = descricao6a;
                $("fnfendereco").value = descricao6b;
                $("fnfbairro").value = descricao6c;
                $("fnffone").value = descricao6d;
                $("fnffax").value = descricao6e;
                $("fnfemail").value = descricao6f;

                $("fccnome1").value = descricao3a;
                $("fccfone1").value = descricao3b;
                $("fccemail1").value = descricao3d;

                $("fccnome2").value = descricao4a;
                $("fccfone2").value = descricao4b;
                $("fccemail2").value = descricao4d;

                $("fccnome3").value = descricao5a;
                $("fccfone3").value = descricao5b;
                $("fccemail3").value = descricao5d;

                $("fcfnome1").value = descricao7a;
                $("fcffone1").value = descricao7b;
                $("fcfemail1").value = descricao7d;

                $("fcfnome2").value = descricao8a;
                $("fcffone2").value = descricao8b;
                $("fcfemail2").value = descricao8d;

                $("fcfnome3").value = descricao9a;
                $("fcffone3").value = descricao9b;
                $("fcfemail3").value = descricao9d;

                $("fnecodcidade").value = descricaov;
                $("fnecidade").value = descricaox;
                $("fneuf").value = descricaoz;

                $("fnenumero").value = fnenumero;
                $("fnfnumero").value = fnfnumero;





                $("fnfcodcidade").value = descricaov2;
                $("fnfcidade").value = descricaox2;
                $("fnfuf").value = descricaoz2;


                if (forprodutos == '1')
                {                    
                    document.getElementById("radioprod1").checked = true;
                } else
                {
                    document.getElementById("radioprod2").checked = true;
                }

                if (descricaoaa == '1')
                {
                    document.getElementById("radios1").checked = true;
                } else
                {
                    document.getElementById("radios2").checked = true;
                }

                //Estrangeiro
                if (descricaoac == '2')
                {
                    document.getElementById("radioopcao2").checked = true;
                    document.getElementById("radio11").checked = true;

                    document.getElementById("radio11").disabled = true;
                    document.getElementById("radio12").disabled = true;

                    $("forcnpj").disabled = true;
                    $("forie").disabled = true;
                    $("forrg").value = "";
                    $("forcpf").value = "";
                    $("forcnpj").value = "";
                    $("forie").value = "";
                    $("forrg").disabled = true;
                    $("forcpf").disabled = true;


                } else {

                    document.getElementById("radioopcao1").checked = true;

                    document.getElementById("radio11").disabled = false;
                    document.getElementById("radio12").disabled = false;

                    if (descricaoab == '1')
                    {
                        document.getElementById("radio21").checked = true;
                        if (document.getElementById("radio11").checked == true)
                        {
                            $("forcnpj").disabled = false;
                            $("forie").disabled = false;
                            $("forrg").value = "";
                            $("forcpf").value = "";
                            $("forrg").disabled = true;
                            $("forcpf").disabled = true;
                        } else
                        {
                            $("forcnpj").disabled = true;
                            $("forie").disabled = true;
                            $("forcnpj").value = "";
                            $("forie").value = "";
                            $("forrg").disabled = false;
                            $("forcpf").disabled = false;
                        }
                        document.getElementById("radio11").disabled = false;
                        document.getElementById("radio12").disabled = false;
                        document.forms[0].listprazos.disabled = false;
                        document.forms[0].liststatus.disabled = false;
                        document.forms[0].listcanais.disabled = false;
                        document.forms[0].listservicos.disabled = false;
                        document.forms[0].listdespesas.disabled = false;
                        $("foricms").disabled = false;
                        $("forobs").disabled = false;
                        $("forbanco").disabled = false;
                        $("foragencia").disabled = false;
                        $("forconta").disabled = false;
                        document.forms[0].listformas.disabled = false;
                    } else
                    {
                        document.getElementById("radio22").checked = true;
                        $("forcnpj").disabled = true;
                        $("forie").disabled = true;
                        $("forcnpj").value = "";
                        $("forie").value = "";
                        $("forrg").disabled = true;
                        $("forcpf").disabled = true;
                        $("forrg").value = "";
                        $("forcpf").value = "";
                        document.getElementById("radio11").disabled = true;
                        document.getElementById("radio12").disabled = true;
                        document.forms[0].listprazos.disabled = true;
                        document.forms[0].liststatus.disabled = true;
                        document.forms[0].listcanais.disabled = true;
                        document.forms[0].listservicos.disabled = true;
                        document.forms[0].listdespesas.disabled = true;
                        $("foricms").disabled = true;
                        $("forobs").disabled = true;
                        $("foricms").value = "";
                        $("forobs").value = "";
                        $("forbanco").disabled = true;
                        $("forbanco").value = "";
                        $("foragencia").disabled = true;
                        $("foragencia").value = "";
                        $("forconta").disabled = true;
                        $("forconta").value = "";
                        document.forms[0].listformas.disabled = true;
                    }
                }

                if (xfortipo == '1')
                {
                    document.getElementById("radiotipo1").checked = true;
                } else if (xfortipo == '2')
                {
                    document.getElementById("radiotipo2").checked = true;
                } else
                {
                    document.getElementById("radiotipo3").checked = true;
                }


                ufibge = descricaoib;
                // dadospesquisaibgerep(descricaoz);
                window.setTimeout("dadospesquisaibgerep('" + descricaoz + "')", 1000);
                // window.setTimeout("seleciona_ufibge()", 1000);

                ufibge2 = descricaoib2;
                dadospesquisaibgefab(descricaoz2);
                // window.setTimeout("seleciona_ufibge2()", 1000);



                $("acao").value = "alterar";
                $("botao").value = "Alterar";





            }
        }
        $('MsgResultado').innerHTML = "";
        $('MsgResultado2').innerHTML = "";
    } else
    {
        // caso o XML volte vazio, printa a mensagem abaixo
        cep1 = "";
        cep2 = "";
        maior = "";
        medio = "";
        menor = "";
        menord = "";
        minimo = "";

        $("forcodigo").value = "";
        $("fornguerra").value = "";
        $("fordat").value = "";
        $("forvtex").value = "";
        $("forcod").value = "";
        $("forrazao").value = "";
        $("forsintegra").value = "";
        $("forcnpj").value = "";
        $("forie").value = "";
        $("forrg").value = "";
        $("forcpf").value = "";
        $("forobs").value = "";
        $("foricms").value = "";
        $("formaior").value = "";
        $("formedio").value = "";
        $("formenor").value = "";
        $("formenord").value = "";
        $("forminimo").value = "";
        $("forbanco").value = "";
        $("foragencia").value = "";
        $("forconta").value = "";
        $("fnecep").value = "";
        $("fneendereco").value = "";
        $("fnebairro").value = "";
        $("fnefone").value = "";
        $("fnefax").value = "";
        $("fneemail").value = "";
        $("fnfcep").value = "";
        $("fnfendereco").value = "";
        $("fnfbairro").value = "";
        $("fnffone").value = "";
        $("fnffax").value = "";
        $("fnfemail").value = "";
        $("acao").value = "inserir";
        $("botao").value = "Incluir";
        document.getElementById("radio11").checked = true;
        document.getElementById("radios2").checked = true;
        document.getElementById("radioprod2").checked = true;
        idOpcao.innerHTML = "____________________";

        $('MsgResultado').innerHTML = "";
        $('MsgResultado2').innerHTML = "";
    }
}

function processXML2(obj)
{
    // pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    // total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        // percorre o arquivo XML paara extrair os dados
        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            // contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var fordat = item.getElementsByTagName("fordat")[0].firstChild.nodeValue;
            var forvtex = item.getElementsByTagName("forvtex")[0].firstChild.nodeValue;
            var forprodutos = item.getElementsByTagName("forprodutos")[0].firstChild.nodeValue;
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
            var descricaomd = item.getElementsByTagName("descricaomd")[0].firstChild.nodeValue;
            var descricaon = item.getElementsByTagName("descricaon")[0].firstChild.nodeValue;
            var descricaoo = item.getElementsByTagName("descricaoo")[0].firstChild.nodeValue;
            var descricaop = item.getElementsByTagName("descricaop")[0].firstChild.nodeValue;
            var descricaoq = item.getElementsByTagName("descricaoq")[0].firstChild.nodeValue;
            var descricaor = item.getElementsByTagName("descricaor")[0].firstChild.nodeValue;
            var tipdespesacodigo = item.getElementsByTagName("tipdespesacodigo")[0].firstChild.nodeValue;
            var descricaos = item.getElementsByTagName("descricaos")[0].firstChild.nodeValue;
            var codigocanal = item.getElementsByTagName("codigocanal")[0].firstChild.nodeValue;
            var descricaot = item.getElementsByTagName("descricaot")[0].firstChild.nodeValue;
            var descricaou = item.getElementsByTagName("descricaou")[0].firstChild.nodeValue;
            var descricao2a = item.getElementsByTagName("descricao2a")[0].firstChild.nodeValue;
            var descricao2b = item.getElementsByTagName("descricao2b")[0].firstChild.nodeValue;
            var descricao2c = item.getElementsByTagName("descricao2c")[0].firstChild.nodeValue;
            var descricao2d = item.getElementsByTagName("descricao2d")[0].firstChild.nodeValue;
            var descricao2e = item.getElementsByTagName("descricao2e")[0].firstChild.nodeValue;
            var descricao2f = item.getElementsByTagName("descricao2f")[0].firstChild.nodeValue;
            var descricao3a = item.getElementsByTagName("descricao3a")[0].firstChild.nodeValue;
            var descricao3b = item.getElementsByTagName("descricao3b")[0].firstChild.nodeValue;
            var descricao3d = item.getElementsByTagName("descricao3d")[0].firstChild.nodeValue;
            var descricao4a = item.getElementsByTagName("descricao4a")[0].firstChild.nodeValue;
            var descricao4b = item.getElementsByTagName("descricao4b")[0].firstChild.nodeValue;
            var descricao4d = item.getElementsByTagName("descricao4d")[0].firstChild.nodeValue;
            var descricao5a = item.getElementsByTagName("descricao5a")[0].firstChild.nodeValue;
            var descricao5b = item.getElementsByTagName("descricao5b")[0].firstChild.nodeValue;
            var descricao5d = item.getElementsByTagName("descricao5d")[0].firstChild.nodeValue;
            var descricao6a = item.getElementsByTagName("descricao6a")[0].firstChild.nodeValue;
            var descricao6b = item.getElementsByTagName("descricao6b")[0].firstChild.nodeValue;
            var descricao6c = item.getElementsByTagName("descricao6c")[0].firstChild.nodeValue;
            var descricao6d = item.getElementsByTagName("descricao6d")[0].firstChild.nodeValue;
            var descricao6e = item.getElementsByTagName("descricao6e")[0].firstChild.nodeValue;
            var descricao6f = item.getElementsByTagName("descricao6f")[0].firstChild.nodeValue;
            var descricao7a = item.getElementsByTagName("descricao7a")[0].firstChild.nodeValue;
            var descricao7b = item.getElementsByTagName("descricao7b")[0].firstChild.nodeValue;
            var descricao7d = item.getElementsByTagName("descricao7d")[0].firstChild.nodeValue;
            var descricao8a = item.getElementsByTagName("descricao8a")[0].firstChild.nodeValue;
            var descricao8b = item.getElementsByTagName("descricao8b")[0].firstChild.nodeValue;
            var descricao8d = item.getElementsByTagName("descricao8d")[0].firstChild.nodeValue;
            var descricao9a = item.getElementsByTagName("descricao9a")[0].firstChild.nodeValue;
            var descricao9b = item.getElementsByTagName("descricao9b")[0].firstChild.nodeValue;
            var descricao9d = item.getElementsByTagName("descricao9d")[0].firstChild.nodeValue;

            var descricaov = item.getElementsByTagName("descricaov")[0].firstChild.nodeValue;
            var descricaox = item.getElementsByTagName("descricaox")[0].firstChild.nodeValue;
            var descricaoz = item.getElementsByTagName("descricaoz")[0].firstChild.nodeValue;

            var descricaov2 = item.getElementsByTagName("descricaov2")[0].firstChild.nodeValue;
            var descricaox2 = item.getElementsByTagName("descricaox2")[0].firstChild.nodeValue;
            var descricaoz2 = item.getElementsByTagName("descricaoz2")[0].firstChild.nodeValue;

            var descricaoaa = item.getElementsByTagName("descricaoaa")[0].firstChild.nodeValue;
            var codigoa = item.getElementsByTagName("codigoa")[0].firstChild.nodeValue;

            var descricaoab = item.getElementsByTagName("descricaoab")[0].firstChild.nodeValue;
            var descricaoac = item.getElementsByTagName("descricaoac")[0].firstChild.nodeValue;

            var fnenumero = item.getElementsByTagName("fnenumero")[0].firstChild.nodeValue;
            var fnfnumero = item.getElementsByTagName("fnfnumero")[0].firstChild.nodeValue;

            var xfortipo = item.getElementsByTagName("fortipo")[0].firstChild.nodeValue;

            var descricaoib = item.getElementsByTagName("descricaoib")[0].firstChild.nodeValue;
            var descricaoib2 = item.getElementsByTagName("descricaoib2")[0].firstChild.nodeValue;

            var cidadeibge = item.getElementsByTagName("cidadeibge")[0].firstChild.nodeValue;
            var cidadeibge2 = item.getElementsByTagName("cidadeibge2")[0].firstChild.nodeValue;

            cep1 = descricao2a;
            cep2 = descricao6a;

            trimjs(codigo);
            codigo = txt;

            trimjs(fordat);
            if (txt == '0') {
                txt = '';
            }
            fordat = txt;

            trimjs(forvtex);
            if (txt == '0') {
                txt = '';
            }
            forvtex = txt;

            trimjs(descricao);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao = txt;
            trimjs(descricaob);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaob = txt;
            trimjs(descricaoc);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoc = txt;
            trimjs(descricaod);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaod = txt;
            trimjs(descricaoe);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoe = txt;
            trimjs(descricaof);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaof = txt;
            trimjs(descricaog);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaog = txt;
            trimjs(descricaoh);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoh = txt;
            trimjs(descricaoi);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoi = txt;
            trimjs(descricaoj);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoj = txt;
            trimjs(descricaok);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaok = txt;
            trimjs(descricaol);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaol = txt;
            trimjs(descricaom);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaom = txt;
            trimjs(descricaomd);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaomd = txt;
            trimjs(descricaon);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaon = txt;
            trimjs(descricaoo);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoo = txt;
            trimjs(descricaop);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaop = txt;
            trimjs(descricaoq);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoq = txt;
            trimjs(descricaor);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaor = txt;
            trimjs(tipdespesacodigo);
            if (txt == '0') {
                txt = '';
            }
            ;
            tipdespesacodigo = txt;
            trimjs(descricaos);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaos = txt;
            trimjs(descricaot);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaot = txt;
            trimjs(descricaou);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaou = txt;
            trimjs(descricao2a);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao2a = txt;
            trimjs(descricao2b);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao2b = txt;
            trimjs(descricao2c);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao2c = txt;
            trimjs(descricao2d);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao2d = txt;
            trimjs(descricao2e);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao2e = txt;
            trimjs(descricao2f);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao2f = txt;

            trimjs(descricao3a);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao3a = txt;
            trimjs(descricao3b);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao3b = txt;
            trimjs(descricao3d);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao3d = txt;

            trimjs(descricao4a);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao4a = txt;
            trimjs(descricao4b);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao4b = txt;
            trimjs(descricao4d);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao4d = txt;

            trimjs(descricao5a);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao5a = txt;
            trimjs(descricao5b);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao5b = txt;
            trimjs(descricao5d);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao5d = txt;

            trimjs(descricao6a);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao6a = txt;
            trimjs(descricao6b);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao6b = txt;
            trimjs(descricao6c);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao6c = txt;
            trimjs(descricao6d);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao6d = txt;
            trimjs(descricao6e);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao6e = txt;
            trimjs(descricao6f);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao6f = txt;

            trimjs(descricao7a);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao7a = txt;
            trimjs(descricao7b);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao7b = txt;
            trimjs(descricao7d);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao7d = txt;

            trimjs(descricao8a);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao8a = txt;
            trimjs(descricao8b);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao8b = txt;
            trimjs(descricao8d);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao8d = txt;

            trimjs(descricao9a);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao9a = txt;
            trimjs(descricao9b);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao9b = txt;
            trimjs(descricao9d);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao9d = txt;

            trimjs(descricaov);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaov = txt;
            trimjs(descricaox);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaox = txt;
            trimjs(descricaoz);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoz = txt;

            trimjs(descricaov2);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaov2 = txt;
            trimjs(descricaox2);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaox2 = txt;
            trimjs(descricaoz2);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoz2 = txt;

            trimjs(descricaoaa);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoaa = txt;
            trimjs(codigoa);
            if (txt == '0') {
                txt = '';
            }
            ;
            codigoa = txt;

            trimjs(descricaoab);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoab = txt;
            trimjs(descricaoac);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoac = txt;

            trimjs(xfortipo);
            if (txt == '0') {
                txt = '1';
            }
            ;
            xfortipo = txt;

            trimjs(descricaoib);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoib = txt;
            trimjs(descricaoib2);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoib2 = txt;
            trimjs(cidadeibge);
            if (txt == '0') {
                txt = '';
            }
            ;
            cidadeibge = txt;
            trimjs(cidadeibge2);
            if (txt == '0') {
                txt = '';
            }
            ;
            cidadeibge2 = txt;

            trimjs(fnenumero);
            if (txt == '0') {
                txt = '';
            }
            fnenumero = txt;
            trimjs(fnfnumero);
            if (txt == '0') {
                txt = '';
            }
            fnfnumero = txt;

            maior = descricaok;
            medio = descricaol;
            menor = descricaom;
            menord = descricaomd;
            minimo = descricaon;

            $("forcodigo").value = codigo;
            $("fordat").value = fordat;
            $("forvtex").value = forvtex;
            $("fornguerra").value = descricao;
            $("forcod").value = descricaob;
            $("forrazao").value = descricaoc;
            $("forsintegra").value = descricaod;
            $("forcnpj").value = descricaoe;
            $("forie").value = descricaof;
            $("forrg").value = descricaog;
            $("forcpf").value = descricaoh;
            $("forobs").value = descricaoi;
            $("foricms").value = descricaoj;
            $("formaior").value = descricaok;
            $("formedio").value = descricaol;
            $("formenor").value = descricaom;
            $("formenord").value = descricaomd;
            $("forminimo").value = descricaon;
            $("forbanco").value = descricaoo;
            $("foragencia").value = descricaop;
            $("forconta").value = descricaoq;
            itemcomboprazo(descricaor);
            itemcombostatus(descricaos);
            itemcombocanais(codigocanal);
            itemcomboservico(descricaot);
            itemcomboforma(codigoa);
            itemcombotipodespesa(tipdespesacodigo);
            if (descricaou == '1')
            {
                document.getElementById("radio11").checked = true;
                $("forcnpj").disabled = false;
                $("forie").disabled = false;
                $("forrg").disabled = true;
                $("forcpf").disabled = true;
            } else
            {
                document.getElementById("radio12").checked = true;
                $("forcnpj").disabled = true;
                $("forie").disabled = true;
                $("forrg").disabled = false;
                $("forcpf").disabled = false;
            }
            $("fnecep").value = descricao2a;
            $("fneendereco").value = descricao2b;
            $("fnebairro").value = descricao2c;
            $("fnefone").value = descricao2d;
            $("fnefax").value = descricao2e;
            $("fneemail").value = descricao2f;
            $("fnfcep").value = descricao6a;
            $("fnfendereco").value = descricao6b;
            $("fnfbairro").value = descricao6c;
            $("fnffone").value = descricao6d;
            $("fnffax").value = descricao6e;
            $("fnfemail").value = descricao6f;

            $("fccnome1").value = descricao3a;
            $("fccfone1").value = descricao3b;
            $("fccemail1").value = descricao3d;

            $("fccnome2").value = descricao4a;
            $("fccfone2").value = descricao4b;
            $("fccemail2").value = descricao4d;

            $("fccnome3").value = descricao5a;
            $("fccfone3").value = descricao5b;
            $("fccemail3").value = descricao5d;

            $("fcfnome1").value = descricao7a;
            $("fcffone1").value = descricao7b;
            $("fcfemail1").value = descricao7d;

            $("fcfnome2").value = descricao8a;
            $("fcffone2").value = descricao8b;
            $("fcfemail2").value = descricao8d;

            $("fcfnome3").value = descricao9a;
            $("fcffone3").value = descricao9b;
            $("fcfemail3").value = descricao9d;

            $("fnecodcidade").value = descricaov;
            $("fnecidade").value = descricaox;
            $("fneuf").value = descricaoz;

            $("fnfcodcidade").value = descricaov2;
            $("fnfcidade").value = descricaox2;
            $("fnfuf").value = descricaoz2;

            $("fnenumero").value = fnenumero;
            $("fnfnumero").value = fnfnumero;

            if (forprodutos == '1')
            {
                document.getElementById("radioprod1").checked = true;
            } else
            {
                document.getElementById("radioprod2").checked = true;
            }

            if (descricaoaa == '1')
            {
                document.getElementById("radios1").checked = true;
            } else
            {
                document.getElementById("radios2").checked = true;
            }



            //Estrangeiro
            if (descricaoac == '2')
            {




                document.getElementById("radioopcao2").checked = true;
                document.getElementById("radio11").checked = true;

                document.getElementById("radio11").disabled = true;
                document.getElementById("radio12").disabled = true;

                $("forcnpj").disabled = true;
                $("forie").disabled = true;
                $("forrg").value = "";
                $("forcpf").value = "";
                $("forcnpj").value = "";
                $("forie").value = "";
                $("forrg").disabled = true;
                $("forcpf").disabled = true;


            } else {

                document.getElementById("radioopcao1").checked = true;

                document.getElementById("radio11").disabled = false;
                document.getElementById("radio12").disabled = false;


                if (descricaoab == '1')
                {
                    document.getElementById("radio21").checked = true;
                    if (document.getElementById("radio11").checked == true)
                    {
                        $("forcnpj").disabled = false;
                        $("forie").disabled = false;
                        $("forrg").value = "";
                        $("forcpf").value = "";
                        $("forrg").disabled = true;
                        $("forcpf").disabled = true;
                    } else
                    {
                        $("forcnpj").disabled = true;
                        $("forie").disabled = true;
                        $("forcnpj").value = "";
                        $("forie").value = "";
                        $("forrg").disabled = false;
                        $("forcpf").disabled = false;
                    }
                    document.getElementById("radio11").disabled = false;
                    document.getElementById("radio12").disabled = false;
                    document.forms[0].listprazos.disabled = false;
                    document.forms[0].liststatus.disabled = false;
                    document.forms[0].listcanais.disabled = false;
                    document.forms[0].listservicos.disabled = false;
                    document.forms[0].listdespesas.disabled = false;
                    $("foricms").disabled = false;
                    $("forobs").disabled = false;
                    $("forbanco").disabled = false;
                    $("foragencia").disabled = false;
                    $("forconta").disabled = false;
                    document.forms[0].listformas.disabled = false;
                } else
                {
                    document.getElementById("radio22").checked = true;
                    $("forcnpj").disabled = true;
                    $("forie").disabled = true;
                    $("forcnpj").value = "";
                    $("forie").value = "";
                    $("forrg").disabled = true;
                    $("forcpf").disabled = true;
                    $("forrg").value = "";
                    $("forcpf").value = "";
                    document.getElementById("radio11").disabled = true;
                    document.getElementById("radio12").disabled = true;
                    document.forms[0].listprazos.disabled = true;
                    document.forms[0].liststatus.disabled = true;
                    document.forms[0].listcanais.disabled = true;
                    document.forms[0].listservicos.disabled = true;
                    document.forms[0].listdespesas.disabled = true;
                    $("foricms").disabled = true;
                    $("forobs").disabled = true;
                    $("foricms").value = "";
                    $("forobs").value = "";
                    $("forbanco").disabled = true;
                    $("forbanco").value = "";
                    $("foragencia").disabled = true;
                    $("foragencia").value = "";
                    $("forconta").disabled = true;
                    $("forconta").value = "";
                    document.forms[0].listformas.disabled = true;
                }
            }

            if (xfortipo == '1')
            {
                document.getElementById("radiotipo1").checked = true;
            } else if (xfortipo == '2')
            {
                document.getElementById("radiotipo2").checked = true;
            } else
            {
                document.getElementById("radiotipo3").checked = true;
            }


            ufibge = descricaoib;
            // dadospesquisaibgerep(descricaoz);
            window.setTimeout("dadospesquisaibgerep('" + descricaoz + "')", 1000);
            // window.setTimeout("seleciona_ufibge()", 1000);

            ufibge2 = descricaoib2;
            dadospesquisaibgefab(descricaoz2);
            // window.setTimeout("seleciona_ufibge2()", 1000);


            $("acao").value = "alterar";
            $("botao").value = "Alterar";
        }
        $('MsgResultado').innerHTML = "";
        $('MsgResultado2').innerHTML = "";
    } else
    {
        // caso o XML volte vazio, printa a mensagem abaixo
        cep1 = "";
        cep2 = "";
        maior = "";
        medio = "";
        menor = "";
        menord = "";
        minimo = "";

        $("forcodigo").value = "";
        $("fordat").value = "";
        $("forvtex").value = "";
        $("fornguerra").value = "";
        $("forcod").value = "";
        $("forrazao").value = "";
        $("forsintegra").value = "";
        $("forcnpj").value = "";
        $("forie").value = "";
        $("forrg").value = "";
        $("forcpf").value = "";
        $("forobs").value = "";
        $("foricms").value = "";
        $("formaior").value = "";
        $("formedio").value = "";
        $("formenor").value = "";
        $("formenord").value = "";
        $("forminimo").value = "";
        $("forbanco").value = "";
        $("foragencia").value = "";
        $("forconta").value = "";
        document.getElementById("radio11").checked = true;
        document.getElementById("radios2").checked = true;
        document.getElementById("radioprod2").checked = true;
        $("acao").value = "inserir";
        $("botao").value = "Incluir";

        $('MsgResultado').innerHTML = "";
        $('MsgResultado2').innerHTML = "";
    }
}

function processXML3(obj)
{
    // pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    // total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        // percorre o arquivo XML paara extrair os dados
        document.forms[0].listDados.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            // contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
            var descricaob = item.getElementsByTagName("descricaob")[0].firstChild.nodeValue;
            var descricaoc = item.getElementsByTagName("descricaoc")[0].firstChild.nodeValue;
            var descricaoe = item.getElementsByTagName("descricaoe")[0].firstChild.nodeValue;
            var descricaoh = item.getElementsByTagName("descricaoh")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;
            trimjs(descricaob);
            descricaob = txt;
            trimjs(descricaoc);
            descricaoc = txt;
            trimjs(descricaoe);
            descricaoe = txt;
            trimjs(descricaoh);
            descricaoh = txt;

            // cria um novo option dinamicamente
            var novo = document.createElement("option");
            // atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes");
            // atribui um valor
            novo.value = codigo;
            // atribui um texto
            if (document.getElementById("radio1").checked == true)
            {
                novo.text = descricaob;
            } else if (document.getElementById("radio2").checked == true)
            {
                novo.text = descricao;
            } else if (document.getElementById("radio3").checked == true)
            {
                novo.text = descricaoc;
            } else if (document.getElementById("radio4").checked == true)
            {
                novo.text = descricaoe;
            } else
            {
                novo.text = descricaoh;
            }
            // finalmente adiciona o novo elemento
            document.forms[0].listDados.options.add(novo);

            if (i == 0)
            {
                $("forcodigo").value = codigo;
                $("acao").value = "alterar";
                $("botao").value = "Alterar";
            }
        }
        $('MsgResultado').innerHTML = "";
        $('MsgResultado2').innerHTML = "";
    } else
    {
        // caso o XML volte vazio, printa a mensagem abaixo
        $("forcodigo").value = "";
        $("fordat").value = "";
        $("forvtex").value = "";
        $("fornguerra").value = "";
        $("forcod").value = "";
        $("forrazao").value = "";
        $("forsintegra").value = "";
        $("forcnpj").value = "";
        $("forie").value = "";
        $("forrg").value = "";
        $("forcpf").value = "";
        $("forobs").value = "";
        $("foricms").value = "";
        $("formaior").value = "";
        $("formedio").value = "";
        $("formenor").value = "";
        $("formenord").value = "";
        $("forminimo").value = "";
        $("forbanco").value = "";
        $("foragencia").value = "";
        $("forconta").value = "";
        $("acao").value = "inserir";
        $("botao").value = "Incluir";
        idOpcao.innerHTML = "____________________";

        $('MsgResultado').innerHTML = "";
        $('MsgResultado2').innerHTML = "";
    }
}

function dadospesquisaprazo(valor, tipo)
{
    // verifica se o browser tem suporte a ajax
    try
    {
        ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (e)
    {
        try
        {
            ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (ex)
        {
            try
            {
                ajax2 = new XMLHttpRequest();
            } catch (exc)
            {
                alert("Esse browser não tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    // se tiver suporte ajax
    if (ajax2)
    {
        // deixa apenas o elemento 1 no option, os outros são excluídos
        document.forms[0].listprazos.options.length = 1;

        idOpcao = document.getElementById("opcoes2");

        ajax2.open("POST", "fornecedorpesquisaprazo.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            // enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            // após ser processado - chama função processXML que vai varrer os
            // dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXMLprazo(ajax2.responseXML, tipo);
                } else
                {
                    // caso não seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "____________________";
                }
            }
        }
        // passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLprazo(obj, tipo)
{
    // pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    // total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        // percorre o arquivo XML paara extrair os dados
        document.forms[0].listprazos.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            // contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;

            // idOpcao.innerHTML = "";

            // cria um novo option dinamicamente
            var novo = document.createElement("option");
            // atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes2");
            // atribui um valor
            novo.value = codigo;
            // atribui um texto
            novo.text = descricao;
            // finalmente adiciona o novo elemento
            document.forms[0].listprazos.options.add(novo);
        }
    } else
    {
        // caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "____________________";
    }
    //dadospesquisastatus(0, tipo);
    dadospesquisacanal(0, tipo);
}

function itemcomboprazo(valor)
{
    y = document.forms[0].listprazos.options.length;
    for (var i = 0; i < y; i++)
    {
        document.forms[0].listprazos.options[i].selected = true;
        var l = document.forms[0].listprazos;
        // var li = l.options[l.selectedIndex].text;
        var li = l.options[l.selectedIndex].value;
        if (li == valor) {
            i = y;
        }
    }
}

function dadospesquisastatus(valor, tipo)
{
    // verifica se o browser tem suporte a ajax
    try
    {
        ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (e)
    {
        try
        {
            ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (ex)
        {
            try
            {
                ajax2 = new XMLHttpRequest();
            } catch (exc)
            {
                alert("Esse browser não tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    // se tiver suporte ajax
    if (ajax2)
    {
        // deixa apenas o elemento 1 no option, os outros são excluídos
        document.forms[0].liststatus.options.length = 1;

        idOpcao = document.getElementById("opcoes3");

        ajax2.open("POST", "fornecedorpesquisastatus.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            // enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            // após ser processado - chama função processXML que vai varrer os
            // dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXMLstatus(ajax2.responseXML, tipo);
                } else
                {
                    // caso não seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "____________________";
                }
            }
        }
        // passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLstatus(obj, tipo)
{
    // pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    // total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        // percorre o arquivo XML paara extrair os dados
        document.forms[0].liststatus.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            // contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;

            // idOpcao.innerHTML = "";

            // cria um novo option dinamicamente
            var novo = document.createElement("option");
            // atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes3");
            // atribui um valor
            novo.value = codigo;
            // atribui um texto
            novo.text = descricao;
            // finalmente adiciona o novo elemento
            document.forms[0].liststatus.options.add(novo);
        }
    } else
    {
        // caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "____________________";
    }
    dadospesquisaservico(0, tipo);
}

function itemcombostatus(valor)
{
    y = document.forms[0].liststatus.options.length;

    for (var i = 0; i < y; i++)
    {
        document.forms[0].liststatus.options[i].selected = true;
        var l = document.forms[0].liststatus;
        // var li = l.options[l.selectedIndex].text;
        var li = l.options[l.selectedIndex].value;
        if (li == valor) {
            i = y;
        }
    }
}


function dadospesquisatipodespesa(valor, tipo)
{
    // verifica se o browser tem suporte a ajax
    try
    {
        ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (e)
    {
        try
        {
            ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (ex)
        {
            try
            {
                ajax2 = new XMLHttpRequest();
            } catch (exc)
            {
                alert("Esse browser não tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    // se tiver suporte ajax
    if (ajax2)
    {
        // deixa apenas o elemento 1 no option, os outros são excluídos
        document.forms[0].listdespesas.options.length = 1;

        idOpcao = document.getElementById("opcoes6");

        ajax2.open("POST", "fornecedorpesquisatipodespesa.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            // enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            // após ser processado - chama função processXML que vai varrer os
            // dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXMLtipodespesa(ajax2.responseXML, tipo);
                } else
                {
                    // caso não seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "_______";
                }
            }
        }
        // passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLtipodespesa(obj, tipo)
{
    // pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    // total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        // percorre o arquivo XML paara extrair os dados
        document.forms[0].listdespesas.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            // contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;

            // idOpcao.innerHTML = "";

            // cria um novo option dinamicamente
            var novo = document.createElement("option");
            // atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes6");
            // atribui um valor
            novo.value = codigo;
            // atribui um texto
            novo.text = descricao;
            // finalmente adiciona o novo elemento
            document.forms[0].listdespesas.options.add(novo);
        }
    } else
    {
        // caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "_______";
    }
    // dadospesquisaservico(0,tipo);
}

function itemcombotipodespesa(valor)
{
    y = document.forms[0].listdespesas.options.length;


    if (valor == '-' || valor == null || valor == "" || valor == 0) {


        var novo = document.createElement("option");
        // atribui um ID a esse elemento
        novo.setAttribute("id", "opcoes6");
        // atribui um valor
        novo.value = 0;
        // atribui um texto
        novo.text = "";
        // finalmente adiciona o novo elemento
        document.forms[0].listdespesas.options.add(novo);

// opcoes6.innerHTML = "_______";
        document.forms[0].listdespesas.options[y].selected = true;

    } else {



        for (var i = 0; i < y; i++)
        {
            document.forms[0].listdespesas.options[i].selected = true;
            var l = document.forms[0].listdespesas;
            // var li = l.options[l.selectedIndex].text;
            var li = l.options[l.selectedIndex].value;
            if (li == valor) {
                i = y;
            }
        }
    }
}


function dadospesquisaservico(valor, tipo)
{
    // verifica se o browser tem suporte a ajax
    try
    {
        ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (e)
    {
        try
        {
            ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (ex)
        {
            try
            {
                ajax2 = new XMLHttpRequest();
            } catch (exc)
            {
                alert("Esse browser não tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    // se tiver suporte ajax
    if (ajax2)
    {
        // deixa apenas o elemento 1 no option, os outros são excluídos
        document.forms[0].listservicos.options.length = 1;

        idOpcao = document.getElementById("opcoes4");

        ajax2.open("POST", "fornecedorpesquisaservicos.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            // enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1)
            {
                idOpcao.innerHTML = "Carregando...!";
            }
            // após ser processado - chama função processXML que vai varrer os
            // dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXMLservico(ajax2.responseXML, tipo);
                } else
                {
                    // caso não seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "____________________";
                }
            }
        }
        // passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLservico(obj, tipo)
{
    // pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");
    // total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        // percorre o arquivo XML paara extrair os dados
        document.forms[0].listservicos.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            // contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;

            // idOpcao.innerHTML = "";

            // cria um novo option dinamicamente
            var novo = document.createElement("option");
            // atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes4");
            // atribui um valor
            novo.value = codigo;
            // atribui um texto
            novo.text = descricao;
            // finalmente adiciona o novo elemento
            document.forms[0].listservicos.options.add(novo);
        }
    } else
    {
        // caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "____________________";
    }
    dadospesquisapagto(0, tipo);
}

function itemcomboservico(valor)
{
    y = document.forms[0].listservicos.options.length;
    for (var i = 0; i < y; i++)
    {
        document.forms[0].listservicos.options[i].selected = true;
        var l = document.forms[0].listservicos;
        // var li = l.options[l.selectedIndex].text;
        var li = l.options[l.selectedIndex].value;
        if (li == valor) {
            i = y;
        }
    }
}

function pesquisacep(valor)
{
    trimjs($("fnecep").value);

    if (cep1 != txt)
    {
        if (txt != "")
        {
            // verifica se o browser tem suporte a ajax
            try
            {
                ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e)
            {
                try
                {
                    ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
                } catch (ex)
                {
                    try
                    {
                        ajax2 = new XMLHttpRequest();
                    } catch (exc)
                    {
                        alert("Esse browser não tem recursos para uso do Ajax");
                        ajax2 = null;
                    }
                }
            }
            // se tiver suporte ajax
            if (ajax2)
            {
                ajax2.open("POST", "ceppesquisa.php", true);
                ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                ajax2.onreadystatechange = function ()
                {
                    // enquanto estiver processando...emite a msg de carregando
                    if (ajax2.readyState == 1) {
                    }
                    // após ser processado - chama função processXML que vai
                    // varrer os dados
                    if (ajax2.readyState == 4)
                    {
                        if (ajax2.responseXML)
                        {
                            processXMLCEP(ajax2.responseXML);
                        } else
                        {
                            // caso não seja um arquivo XML emite a mensagem
                            // abaixo
                        }
                    }
                }
                // passa o parametro
                var params = "parametro=" + valor;
                ajax2.send(params);
            }
        } else
        {
            $("fnecidade").value = "";
            $("fneuf").value = "";
            $("fnecodcidade").value = "";
        }
    }
}

function processXMLCEP(obj)
{
    // pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    // total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        // percorre o arquivo XML paara extrair os dados

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            // contéudo dos campos no arquivo XML
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

            $("fneendereco").value = descricao3;
            $("fnebairro").value = descricao4.substring(0, 30);
            $("fnecidade").value = descricao;
            $("fneuf").value = descricao2;
            $("fnecodcidade").value = codigo;
            cep1 = $("fnecep").value;

            // busca cidade ibge		
            dadospesquisaibgerep(descricao2);
        }
    } else
    {
        // caso o XML volte vazio, printa a mensagem abaixo
        alert("O CEP não é válido!");
        document.getElementById("fnecep").focus();
    }
}

function pesquisacep2(valor)
{
    trimjs($("fnfcep").value);

    if (cep2 != txt)
    {
        if (txt != "")
        {
            // verifica se o browser tem suporte a ajax
            try
            {
                ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e)
            {
                try
                {
                    ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
                } catch (ex)
                {
                    try
                    {
                        ajax2 = new XMLHttpRequest();
                    } catch (exc)
                    {
                        alert("Esse browser não tem recursos para uso do Ajax");
                        ajax2 = null;
                    }
                }
            }
            // se tiver suporte ajax
            if (ajax2)
            {
                ajax2.open("POST", "ceppesquisa.php", true);
                ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                ajax2.onreadystatechange = function ()
                {
                    // enquanto estiver processando...emite a msg de carregando
                    if (ajax2.readyState == 1) {
                    }
                    // após ser processado - chama função processXML que vai
                    // varrer os dados
                    if (ajax2.readyState == 4)
                    {
                        if (ajax2.responseXML)
                        {
                            processXMLCEP2(ajax2.responseXML);
                        } else
                        {
                            // caso não seja um arquivo XML emite a mensagem
                            // abaixo
                        }
                    }
                }
                // passa o parametro
                var params = "parametro=" + valor;
                ajax2.send(params);
            }
        } else
        {
            $("fnfcidade").value = "";
            $("fnfuf").value = "";
            $("fnfcodcidade").value = "";
        }
    }
}

function processXMLCEP2(obj)
{
    // pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    // total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        // percorre o arquivo XML paara extrair os dados
        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            // contéudo dos campos no arquivo XML
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

            $("fnfendereco").value = descricao3;
            $("fnfbairro").value = descricao4.substring(0, 30);
            $("fnfcidade").value = descricao;
            $("fnfuf").value = descricao2;

            $("fnfcodcidade").value = codigo;

            cep2 = $("fnfcep").value;

            dadospesquisaibgefab(descricao2);
        }
    } else
    {
        // caso o XML volte vazio, printa a mensagem abaixo
        alert("O CEP não é válido!");
        document.getElementById("fnfcep").focus();
    }
}

function dadospesquisasintegra(valor)
{
    // verifica se o browser tem suporte a ajax
    if (valida_data('forsintegra') == true)
    {
        try
        {
            ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (e)
        {
            try
            {
                ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (ex)
            {
                try
                {
                    ajax2 = new XMLHttpRequest();
                } catch (exc)
                {
                    alert("Esse browser não tem recursos para uso do Ajax");
                    ajax2 = null;
                }
            }
        }
        // se tiver suporte ajax
    }
}

function codigo_fornecedor(valor)
{
    // verifica se o browser tem suporte a ajax
    try
    {
        ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (e)
    {
        try
        {
            ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (ex)
        {
            try
            {
                ajax2 = new XMLHttpRequest();
            } catch (exc)
            {
                alert("Esse browser não tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    // se tiver suporte ajax
    if (ajax2)
    {
        // deixa apenas o elemento 1 no option, os outros são excluídos
        ajax2.open("POST", "fornecedorcodpesquisa.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            // enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
            }
            // após ser processado - chama função processXML que vai varrer os
            // dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXMLcodfor(ajax2.responseXML);
                } else {
                    // caso não seja um arquivo XML emite a mensagem abaixo
                }
            }
        }
        // passa o parametro

        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLcodfor(obj)
{
    // pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    // total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        // percorre o arquivo XML paara extrair os dados
        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            // contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            trimjs(codigo);
            if (txt == '1') {
                txt = '1';
            }
            ;
            codigo = txt;

            // if(i==0){
            $("forcod").value = codigo;
            // }
        }
    } else
    {
        // caso o XML volte vazio, printa a mensagem abaixo
        $("forcod").value = "1";
    }

    dadospesquisatipodespesa(0, 1);
}

function pesquisaexiste(valor)
{
    // verifica se o browser tem suporte a ajax
    try
    {
        ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (e)
    {
        try
        {
            ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (ex)
        {
            try
            {
                ajax2 = new XMLHttpRequest();
            } catch (exc)
            {
                alert("Esse browser não tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    // se tiver suporte ajax
    if (ajax2)
    {
        ajax2.open("POST", "fornecedorpesquisaexiste.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            // enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
            }
            // após ser processado - chama função processXML que vai varrer os
            // dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXMLfornecedorpesquisa(ajax2.responseXML, valor);
                } else
                {
                    // caso não seja um arquivo XML emite a mensagem abaixo
                }
            }
        }
        // passa o parametro escolhido
        valor2 = document.getElementById("forcodigo").value;
        if (valor2 == '') {
            valor2 = '0';
        }

        var params = "parametro=" + valor + '&parametro2=' + valor2;

        ajax2.send(params);
    }
}

function processXMLfornecedorpesquisa(obj, valor)
{
    // pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    // total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        // percorre o arquivo XML paara extrair os dados
        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            // contéudo dos campos no arquivo XML
            alert("O Codigo " + valor + " já está cadastrado!");
            document.getElementById("forcod").focus();
        }
    } else
    {
        // caso o XML volte vazio, printa a mensagem abaixo
    }
}

function verificapessoa(valor)
{
    if (document.getElementById("radio11").checked == true)
    {
        $("forcnpj").disabled = false;
        $("forie").disabled = false;
        $("forrg").value = "";
        $("forcpf").value = "";
        $("forrg").disabled = true;
        $("forcpf").disabled = true;
    } else
    {
        $("forcnpj").disabled = true;
        $("forie").disabled = true;
        $("forcnpj").value = "";
        $("forie").value = "";
        $("forrg").disabled = false;
        $("forcpf").disabled = false;
    }
}


function verificaopcao(valor)
{
    if (document.getElementById("radioopcao1").checked == true)
    {

        $("forcnpj").disabled = false;
        $("forie").disabled = false;
        $("forrg").value = "";
        $("forcpf").value = "";
        $("forrg").disabled = true;
        $("forcpf").disabled = true;
        document.getElementById("radio11").checked = true;
        document.getElementById("radio11").disabled = false;
        document.getElementById("radio12").disabled = false;

    } else
    {
        $("forcnpj").disabled = true;
        $("forie").disabled = true;
        $("forcnpj").value = "";
        $("forie").value = "";
        $("forrg").disabled = true;
        $("forcpf").disabled = true;
        $("forrg").value = "";
        $("forcpf").value = "";
        document.getElementById("radio11").checked = true;
        document.getElementById("radio11").disabled = true;
        document.getElementById("radio12").disabled = true;

    }
}



// JavaScript Document
/*******************************************************************************
 * #################################################################### Assunto =
 * Validação de CPF e CNPJ Autor = Marcos Regis Data = 24/01/2006 Versão = 1.0
 * Compatibilidade = Todos os navegadores. Pode ser usado e distribuído desde
 * que esta linhas sejam mantidas
 * ====------------------------------------------------------------====
 * 
 * Funcionamento = O script recebe como parâmetro um objeto por isso deve ser
 * chamado da seguinte forma: E.: no evento onBlur de um campo texto <input
 * name="cpf_cnpj" type="text" size="40" maxlength="18" onBlur="validar(this);">
 * Ao deixar o campo o evento é disparado e chama validar() com o argumento
 * "this" que representa o próprio objeto com todas as propriedades. A partir
 * daí a função validar() trata a entrada removendo tudo que não for caracter
 * numérico e deixando apenas números, portanto valores escritos só com números
 * ou com separadores como '.' ou mesmo espaços são aceitos ex.: 111222333/44,
 * 111.222.333-44, 111 222 333 44 serão tratadoc como 11122233344 (para CPFs) De
 * certa forma até mesmo valores como 111A222B333C44 será aceito mas aconselho a
 * usar a função soNums() que encotra-se aqui mesmo para que o campo só aceite
 * caracteres numéricos. Para usar a função soNums() chame-a no evento
 * onKeyPress desta forma onKeyPress="return soNums(event);" Após limpar o valor
 * verificamos seu tamanho que deve ser ou 11 ou 14 Se o tamanho não for aceito
 * a função retorna false e [opcional] mostra uma mensagem de erro. Sugestões e
 * comentários marcos_regis@hotmail.com
 * ####################################################################
 ******************************************************************************/

// a função principal de validação
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

// se for CNPJ
    if (tam == 14) {
        if (!validaCNPJ(s)) { // chama a função que valida o CNPJ
            alert("'" + s + "' Não é um CNPJ válido!"); // se quiser mostrar o
            // erro
            obj.select();    // se quiser selecionar o campo enviado
            obj.focus();
            return false;
        }
        // alert("'"+s+"' É um CNPJ válido!" ); // se quiser mostrar que validou
        obj.value = maskCNPJ(s);    // se validou o CNPJ mascaramos corretamente
        return true;
    }
}
// fim da funcao validar()

// a função principal de validação
function validar2(obj) { // recebe um objeto
    var s = (obj.value).replace(/\D/g, '');
    var tam = (s).length; // removendo os caracteres não numéricos
    if (tam == 0) { // validando o tamanho
        return true;
    }
    if (!(tam == 11)) { // validando o tamanho
        alert("'" + s + "' Não é um CPF válido!"); // tamanho inválido
        obj.focus();
        return false;
    }

// se for CPF
    if (tam == 11) {
        if (!validaCPF(s)) { // chama a função que valida o CPF
            alert("'" + s + "' Não é um CPF válido!"); // se quiser mostrar o erro
            obj.select();  // se quiser selecionar o campo em questão
            obj.focus();
            return false;
        }
        // alert("'"+s+"' É um CPF válido!" ); // se quiser mostrar que validou
        obj.value = maskCPF(s);    // se validou o CPF mascaramos corretamente
        return true;
    }
}
// fim da funcao validar()

// função que valida CPF
// O algorítimo de validação de CPF é baseado em cálculos
// para o dígito verificador (os dois últimos)
// Não entrarei em detalhes de como funciona
function validaCPF(s) {
    var c = s.substr(0, 9);
    var dv = s.substr(9, 2);
    var d1 = 0;
    for (var i = 0; i < 9; i++) {
        d1 += c.charAt(i) * (10 - i);
    }
    if (d1 == 0)
        return false;
    d1 = 11 - (d1 % 11);
    if (d1 > 9)
        d1 = 0;
    if (dv.charAt(0) != d1) {
        return false;
    }
    d1 *= 2;
    for (var i = 0; i < 9; i++) {
        d1 += c.charAt(i) * (11 - i);
    }
    d1 = 11 - (d1 % 11);
    if (d1 > 9)
        d1 = 0;
    if (dv.charAt(1) != d1) {
        return false;
    }
    return true;
}

// Função que valida CNPJ
// O algorítimo de validação de CNPJ é baseado em cálculos
// para o dígito verificador (os dois últimos)
// Não entrarei em detalhes de como funciona
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
    return true;
}

// Função que permite apenas teclas numéricas
// Deve ser chamada no evento onKeyPress desta forma
// return (soNums(event));

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

// função que mascara o CPF
function maskCPF(CPF) {
    return CPF.substring(0, 3) + "." + CPF.substring(3, 6) + "." + CPF.substring(6, 9) + "-" + CPF.substring(9, 11);
}

// função que mascara o CNPJ
function maskCNPJ(CNPJ) {
    return CNPJ.substring(0, 2) + "." + CNPJ.substring(2, 5) + "." + CNPJ.substring(5, 8) + "/" + CNPJ.substring(8, 12) + "-" + CNPJ.substring(12, 14);
}

function dadospesquisapagto(valor, tipo)
{
    // verifica se o browser tem suporte a ajax
    try
    {
        ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (e)
    {
        try
        {
            ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (ex)
        {
            try
            {
                ajax2 = new XMLHttpRequest();
            } catch (exc)
            {
                alert("Esse browser não tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    // se tiver suporte ajax
    if (ajax2)
    {
        // deixa apenas o elemento 1 no option, os outros são excluídos
        document.forms[0].listformas.options.length = 1;

        idOpcao = document.getElementById("opcoes5");

        ajax2.open("POST", "fornecedorpesquisaformas.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            // enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            // após ser processado - chama função processXML que vai varrer os
            // dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML) {
                    processXMLpagto(ajax2.responseXML, tipo);
                } else {
                    // caso não seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "____________________";
                }
            }
        }
        // passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLpagto(obj, tipo)
{
    // pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    // total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        // percorre o arquivo XML paara extrair os dados

        document.forms[0].listformas.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            // contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;

            // idOpcao.innerHTML = "";

            // cria um novo option dinamicamente
            var novo = document.createElement("option");
            // atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes5");
            // atribui um valor
            novo.value = codigo;
            // atribui um texto
            novo.text = descricao;
            // finalmente adiciona o novo elemento
            document.forms[0].listformas.options.add(novo);
        }
    } else
    {
        // caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "____________________";
    }
    codigo_fornecedor(tipo);
}

function itemcomboforma(valor)
{
    y = document.forms[0].listformas.options.length;
    for (var i = 0; i < y; i++)
    {
        document.forms[0].listformas.options[i].selected = true;
        var l = document.forms[0].listformas;
        // var li = l.options[l.selectedIndex].text;
        var li = l.options[l.selectedIndex].value;
        if (li == valor) {
            i = y;
        }
    }
}

function verificamodo(valor)
{
    if (document.getElementById("radio21").checked == true)
    {
        if (document.getElementById("radio11").checked == true)
        {
            $("forcnpj").disabled = false;
            $("forie").disabled = false;
            $("forrg").value = "";
            $("forcpf").value = "";
            $("forrg").disabled = true;
            $("forcpf").disabled = true;
        } else
        {
            $("forcnpj").disabled = true;
            $("forie").disabled = true;
            $("forcnpj").value = "";
            $("forie").value = "";
            $("forrg").disabled = false;
            $("forcpf").disabled = false;
        }
        document.getElementById("radio11").disabled = false;
        document.getElementById("radio12").disabled = false;
        document.forms[0].listprazos.disabled = false;
        document.forms[0].liststatus.disabled = false;
        document.forms[0].listcanais.disabled = false;
        document.forms[0].listservicos.disabled = false;
        $("foricms").disabled = false;
        $("forobs").disabled = false;
        $("forbanco").disabled = false;
        $("foragencia").disabled = false;
        $("forconta").disabled = false;
        document.forms[0].listformas.disabled = false;
    } else
    {
        $("forcnpj").disabled = true;
        $("forie").disabled = true;
        $("forcnpj").value = "";
        $("forie").value = "";
        $("forrg").disabled = true;
        $("forcpf").disabled = true;
        $("forrg").value = "";
        $("forcpf").value = "";
        document.getElementById("radio11").disabled = true;
        document.getElementById("radio12").disabled = true;
        document.forms[0].listprazos.disabled = true;
        document.forms[0].liststatus.disabled = true;
        document.forms[0].listcanais.disabled = true;
        document.forms[0].listservicos.disabled = true;
        $("foricms").disabled = true;
        $("forobs").disabled = true;
        $("foricms").value = "";
        $("forobs").value = "";
        $("forbanco").disabled = true;
        $("forbanco").value = "";
        $("foragencia").disabled = true;
        $("foragencia").value = "";
        $("forconta").disabled = true;
        $("forconta").value = "";
        document.forms[0].listformas.disabled = true;
    }
}

function dadospesquisaibgerep(valor)
{

    // verifica se o browser tem suporte a ajax
    try
    {
        ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (e)
    {
        try
        {
            ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (ex)
        {
            try
            {
                ajax2 = new XMLHttpRequest();
            } catch (exc)
            {
                alert("Esse browser não tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    // se tiver suporte ajax
    if (ajax2)
    {

        // deixa apenas o elemento 1 no option, os outros são excluídos
        document.forms[0].cidadeibge.options.length = 1;

        var idOpcaoendx1 = document.getElementById("cidcodigoibge");

        ajax2.open("POST", "cidadesibge.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            // enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1)
            {
                idOpcaoendx1.innerHTML = "Carregando...!";
            }
            // após ser processado - chama função processXML que vai varrer os
            // dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXMLibgerep(ajax2.responseXML);
                } else
                {
                    // caso não seja um arquivo XML emite a mensagem abaixo
                    $('cidadeibge').innerHTML = '<option id="cidcodigoibge" value="0">____________________________________</option>';
                }
            }
        }
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLibgerep(obj)
{

    var temnocombo = 0;
    // document.forms[0].listcidades.options.length = 0;
    // document.forms[0].listbairros.options.length = 0;
    var dataArray = obj.getElementsByTagName("dadoib");

    // total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        // percorre o arquivo XML paara extrair os dados
        document.forms[0].cidadeibge.options.length = 0;
        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            // contéudo dos campos no arquivo XML
            var codigoib = item.getElementsByTagName("codigoib")[0].firstChild.nodeValue;
            var cidadeib = item.getElementsByTagName("cidadeib")[0].firstChild.nodeValue;

            trimjs(codigoib);
            var codigo = txt;
            trimjs(cidadeib);
            var cidade = txt;

            // idOpcao.innerHTML = "";

            if (i == 0)
            {
                // cria um novo option dinamicamente
                var novo = document.createElement("option");

                // atribui um ID a esse elemento
                novo.setAttribute("id", "cidcodigoibge");
                // atribui um valor
                novo.value = "0";
                // atribui um texto
                novo.text = "Escolha uma Cidade";
                // finalmente adiciona o novo elemento
                document.forms[0].cidadeibge.options.add(novo);

            }

            // cria um novo option dinamicamente
            var novo = document.createElement("option");

            // atribui um ID a esse elemento
            novo.setAttribute("id", "cidcodigoibge");
            // atribui um valor
            novo.value = codigoib;
            // atribui um texto
            novo.text = cidadeib;
            // finalmente adiciona o novo elemento
            document.forms[0].cidadeibge.options.add(novo);
            document.forms[0].cidadeibge.disabled = false;
            // if(ufibge == codigoib)
            // document.forms[0].cidadeibge.selected;

            if (ufibge != "" && (ufibge == codigoib)) {
                temnocombo = 1;
            }

        }

        document.getElementById("cidcodigoibge").disabled = false;
    }
    // else
    // {
    // caso o XML volte vazio, printa a mensagem abaixo
    // var cidcodigoibge = document.getElementById("cidcodigoibge");
    // cidcodigoibge.innerHTML = "____________________";
    // document.getElementById("cidcodigoibge").disabled = true;
    // }

    if (ufibge != "" && temnocombo == 1)
    {
        $('cidadeibge').value = ufibge;
    } else {
        $('cidadeibge').value = 0;
    }

}

function dadospesquisaibgefab(valor1)
{
    // verifica se o browser tem suporte a ajax
    try
    {
        ajax2fab = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (e)
    {
        try
        {
            ajax2fab = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (ex)
        {
            try
            {
                ajax2fab = new XMLHttpRequest();
            } catch (exc)
            {
                alert("Esse browser não tem recursos para uso do Ajax");
                ajax2fab = null;
            }
        }
    }
    // se tiver suporte ajax
    if (ajax2fab)
    {
        // deixa apenas o elemento 1 no option, os outros são excluídos
        document.forms[0].cidadeibge2.options.length = 1;

        var idOpcaoendx2 = document.getElementById("cidcodigoibge2");

        ajax2fab.open("POST", "cidadesibge.php", true);
        ajax2fab.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2fab.onreadystatechange = function ()
        {
            // enquanto estiver processando...emite a msg de carregando
            if (ajax2fab.readyState == 1)
            {
                idOpcaoendx2.innerHTML = "Carregando...!";
            }
            // após ser processado - chama função processXML que vai varrer os
            // dados
            if (ajax2fab.readyState == 4)
            {
                if (ajax2fab.responseXML)
                {
                    processXMLibgefab(ajax2fab.responseXML);
                } else
                {
                    // caso não seja um arquivo XML emite a mensagem abaixo
                    $('cidadeibge2').innerHTML = '<option id="cidcodigoibge2" value="0">_</option>';
// $('cidadeibgecob').innerHTML = '<option id="cidcodigoibgecob"
// value="0">____________________________________</option>';
                }
            }
        }
        var params2 = "parametro=" + valor1;
        ajax2fab.send(params2);
    }
}



function processXMLibgefab(obj)
{

    // document.forms[0].listcidades.options.length = 0;
    // document.forms[0].listbairros.options.length = 0;
    var dataArray = obj.getElementsByTagName("dadoib");

    // total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        // percorre o arquivo XML paara extrair os dados
        document.forms[0].cidadeibge2.options.length = 0;
        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            // contéudo dos campos no arquivo XML
            var codigoib = item.getElementsByTagName("codigoib")[0].firstChild.nodeValue;
            var cidadeib = item.getElementsByTagName("cidadeib")[0].firstChild.nodeValue;

            trimjs(codigoib);
            var codigo = txt;
            trimjs(cidadeib);
            var cidade = txt;

            // idOpcao.innerHTML = "";

            if (i == 0)
            {
                // cria um novo option dinamicamente
                var novo = document.createElement("option");

                // atribui um ID a esse elemento
                novo.setAttribute("id", "cidcodigoibge");
                // atribui um valor
                novo.value = "0";
                // atribui um texto
                novo.text = "Escolha uma Cidade";
                // finalmente adiciona o novo elemento
                document.forms[0].cidadeibge2.options.add(novo);
            }

            // cria um novo option dinamicamente
            var novo = document.createElement("option");

            // atribui um ID a esse elemento
            novo.setAttribute("id", "cidcodigoibge");
            // atribui um valor
            novo.value = codigoib;
            // atribui um texto
            novo.text = cidadeib;
            // finalmente adiciona o novo elemento
            document.forms[0].cidadeibge2.options.add(novo);

            document.forms[0].cidadeibge2.disabled = false;
            // if(ufibge == codigoib)
            // document.forms[0].cidadeibge.selected;
        }
        // document.getElementById("cidcodigoibge2").disabled = false;
    }
    // else
    // {
    // caso o XML volte vazio, printa a mensagem abaixo
    // var cidcodigoibge = document.getElementById("cidcodigoibge");
    // cidcodigoibge.innerHTML = "____________________";
    // document.getElementById("cidcodigoibge").disabled = true;
    // }

    // caso seja uma consulta seleciona caso banco tenha valor
    if (ufibge2 != "")
    {
        $('cidadeibge2').value = ufibge2;
    }
}

/*
 * function seleciona_ufibge() { $('cidadeibge').value = ufibge; //
 * document.getElementById("cidcodigoibge").value = ufibge; } function
 * seleciona_ufibge2() { $('cidadeibge2').value = ufibge2; }
 */

function novaDespesa(url, nomeJanela, caracteristicas) {

    // window.location(url);
    window.open(url, nomeJanela, caracteristicas);
    return false;

}


function processXMLinsere(obj)
{

    // pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    // total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        // percorre o arquivo XML paara extrair os dados
        document.forms[0].listDados.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            // contéudo dos campos no arquivo XML
            var forcod = item.getElementsByTagName("forcod")[0].firstChild.nodeValue;
            var forcodigo = item.getElementsByTagName("forcodigo")[0].firstChild.nodeValue;

            trimjs(forcod);
            forcod = txt;

            dadospesquisa3(forcodigo);

            $("forcod").value = forcod;

            alert("Registro incluído com sucesso!\nCom o número: " + forcod);
            $('MsgResultado').innerHTML = "Incluído com sucesso!";
            $('MsgResultado2').innerHTML = "Incluído com sucesso!";

        }

    } else
    {
        // caso o XML volte vazio, printa a mensagem abaixo
    }
}


function valida_exporta() {

    if ($("acao").value == "inserir")
    {
        alert("Escolha o Fornecedor!");
    } else {
        verifica_toymania();
    }
}


function verifica_toymania()
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

        ajax2.open("POST", "fornecedorverificatoymania.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLverificatoymania(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo

                }
            }
        }


        let valor = document.getElementById('forcodigo').value;

        let params = "parametro=" + valor;

        ajax2.send(params);
    }
}

function processXMLverificatoymania(obj)
{

    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    var erro = 1;

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados
        var item = dataArray[0];
        //contéudo dos campos no arquivo XML

        var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
        var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

        if (codigo != '0') {
            alert(descricao);
        } else {
            erro = 0;
        }

    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo

    }

    if (erro == 0) {

        inserir_toymania();
    }

}

function inserir_toymania()
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

        ajax2.open("POST", "fornecedorinseretoymania.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLinseretoymania(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo

                }
            }
        }


        let valor = document.getElementById('forcodigo').value;

        let params = "parametro=" + valor;

        ajax2.send(params);
    }
}

function processXMLinseretoymania(obj)
{

    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    var erro = 1;

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados
        var item = dataArray[0];
        //contéudo dos campos no arquivo XML

        var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
        var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;


        alert(descricao);


    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo

    }

    limpa_form(1);

}

function dadospesquisacanal(valor, tipo)
{
    // verifica se o browser tem suporte a ajax
    try
    {
        ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (e)
    {
        try
        {
            ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (ex)
        {
            try
            {
                ajax2 = new XMLHttpRequest();
            } catch (exc)
            {
                alert("Esse browser não tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    // se tiver suporte ajax
    if (ajax2)
    {
        // deixa apenas o elemento 1 no option, os outros são excluídos
        document.forms[0].listcanais.options.length = 1;

        idOpcao = document.getElementById("opcoes7");

        ajax2.open("POST", "fornecedorpesquisacanal.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            // enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            // após ser processado - chama função processXML que vai varrer os
            // dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXMLcanais(ajax2.responseXML, tipo);
                } else
                {
                    // caso não seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "____________________";
                }
            }
        }
        // passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLcanais(obj, tipo)
{
    // pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    // total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        // percorre o arquivo XML paara extrair os dados
        document.forms[0].listcanais.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            // contéudo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;

            // idOpcao.innerHTML = "";

            // cria um novo option dinamicamente
            var novo = document.createElement("option");
            // atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes7");
            // atribui um valor
            novo.value = codigo;
            // atribui um texto
            novo.text = descricao;
            // finalmente adiciona o novo elemento
            document.forms[0].listcanais.options.add(novo);
        }
    } else
    {
        // caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "____________________";
    }
    dadospesquisastatus(0, tipo);
}

function itemcombocanais(valor)
{
    y = document.forms[0].listcanais.options.length;

    for (var i = 0; i < y; i++)
    {
        document.forms[0].listcanais.options[i].selected = true;
        var l = document.forms[0].listcanais;
        // var li = l.options[l.selectedIndex].text;
        var li = l.options[l.selectedIndex].value;
        if (li == valor) {
            i = y;
        }
    }
}