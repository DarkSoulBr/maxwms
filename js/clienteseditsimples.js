// JavaScript Document
nextfield = "pesquisa"; // nome do primeiro campo do site
netscape = "";
var ufibge = 0;
var clirazao;
var clicnpj;
var cliie;
var clecep;
var cleendereco;
var clenumero;
var cidcodigo;
var ibge;
var clefone;
var cleemail;
var cleemailxml;

var auxcidade;
var auxestado;
var auxvencodigo;

ver1 = navigator.appVersion;
len = ver1.length;
for (iln = 0; iln < len; iln++)
    if (ver1.charAt(iln) == "(")
        break;
netscape = (ver1.charAt(iln + 1).toUpperCase() != "C");


var verx = 0;
function keyDown(DnEvents)
{
    // ve quando e o netscape ou IE
    if (netscape == true)
    {
        verx++;
        if (verx == 2) {
            verx = 0;
            return;
        }
    }

    k = (netscape) ? DnEvents.which : window.event.keyCode;
    if (k == 13)
    { // preciona tecla enter
        if (nextfield == 'radio')
        {
            if (document.getElementById("radio1").checked == true)
            {
                nextfield = 'radio1';
            } else if (document.getElementById("radio2").checked == true)
            {
                nextfield = 'radio2';
            } else if (document.getElementById("radio3").checked == true)
            {
                nextfield = 'radio3';
            } else if (document.getElementById("radio4").checked == true)
            {
                nextfield = 'radio4';
            } else if (document.getElementById("radio5").checked == true)
            {
                nextfield = 'radio5';
            } else
            {
                nextfield = 'radio6';
            }
        }

        if (nextfield == 'radiob')
        {
            if (document.getElementById("radiob1").checked == true)
            {
                nextfield = 'radiob1';
            } else
            {
                nextfield = 'radiob2';
            }
        }

        if (nextfield == 'pessoa')
        {
            if (document.getElementById("radiob1").checked == true)
            {
                nextfield = 'clicnpj';
            } else
            {
                nextfield = 'clicpf';
            }
        }

        if (nextfield == 'radiotc')
        {
            if (document.getElementById("radiotc1").checked == true)
            {
                nextfield = 'radiotc1';
            } else
            {
                nextfield = 'radiotc2';
            }
        }

        if (nextfield == 'radioautfat')
        {
            if (document.getElementById("radioautfat1").checked == true)
            {
                nextfield = 'radioautfat1';
            } else if (document.getElementById("radioautfat2").checked == true)
            {
                nextfield = 'radioautfat2';
            } else if (document.getElementById("radioautfat3").checked == true)
            {
                nextfield = 'radioautfat3';
            } else if (document.getElementById("radioautfat4").checked == true)
            {
                nextfield = 'radioautfat4';
            } else if (document.getElementById("radioautfat5").checked == true)
            {
                nextfield = 'radioautfat5';
            } else
            {
                nextfield = 'radioautfat6';
            }
        }

        if (nextfield == 'radioc')
        {
            if (document.getElementById("radioc1").checked == true)
            {
                nextfield = 'radioc1';
            } else
            {
                nextfield = 'radioc2';
            }
        }

        if (nextfield == 'radiod')
        {
            if (document.getElementById("radiod1").checked == true)
            {
                nextfield = 'radiod1';
            } else
            {
                nextfield = 'radiod2';
            }
        }

        if (nextfield == 'radiosex')
        {
            if (document.getElementById("radiosex1").checked == true)
            {
                nextfield = 'radiosex1';
            } else
            {
                nextfield = 'radiosex2';
            }
        }

        if (nextfield == 'radioip')
        {
            if (document.getElementById("radioip1").checked == true)
            {
                nextfield = 'radioip1';
            } else
            {
                nextfield = 'radioip2';
            }
        }

        if (nextfield == 'done')
        {
            // alert("viu como funciona?");
            return false;
            // return true; // envia quando termina os campos
        } else
        {
            // se existem mais campos vai para o proximo
            eval('document.formulario.' + nextfield + '.focus()');
            return false;
        }
    }
}
/*
 * function disableSelection(target){ if (typeof
 * target.onselectstart!="undefined") //IE route
 * target.onselectstart=function(){return false} else if (typeof
 * target.style.MozUserSelect!="undefined") //Firefox route
 * target.style.MozUserSelect="none" else //All other route (ie: Opera)
 * target.onmousedown=function(){return false} target.style.cursor = "default" }
 * disableSelection(document.body);
 */




var message = "Ops! O Bot\u00E3o direito est\u00E1 travado para esta p\u00E1gina.";
function NOclickNN(e) {
    if (document.layers || document.getElementById && !document.all) {
        if (e.which == 2 || e.which == 3) {
            alert(message);
            return false;
        }
    }
}
if (document.layers) {
    document.captureEvents(Event.MOUSEDOWN);
    document.onmousedown = NOclickNN;
}
document.oncontextmenu = new Function("alert(message);return false");




function BloqueiaComando(event) {
    var tecla = String.fromCharCode(event.keyCode).toLowerCase();
    // bloqueia ctrl c,ctrl v, ctrl insert, shift insert
    if ((event.ctrlKey && (tecla == "c" || tecla == "v")) ||
            (event.ctrlKey && event.which == 45) ||
            (event.shiftKey && event.which == 45)) {

        window.event ? event.returnValue = false : event.preventDefault();
        alert('Ops! Neste campo a digita\u00E7\u00E3o \u00E9 obrigat\u00F3ria');
        return false;
    }
}


document.onkeydown = keyDown; // work together to analyze keystrokes
if (netscape)
    document.captureEvents(Event.KEYDOWN | Event.KEYUP);

function validaTel(tel) {
    telefone = "" + tel;
    verifica = telefone.replace(/[^0-9]+/g, "");

    if (verifica.length == 10 || verifica.length == 11) {
        return true
    } else {
        return false;
    }
}

function atualizacorreio()
{
    $auxcep = document.getElementById('clecep').value;

    window.open('cepxcorreio.php?cep=' + $auxcep
            , 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=no, width=700, height=700');


}

function alteracep()
{
    $auxcep = document.getElementById('clecep').value;

    window.open('alteracep.php?cep=' + $auxcep
            , 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=no, width=700, height=700');


}

function fimincluir() {
    alert("Inclu\u00EDdo com sucesso!");
    $("MsgResultado").innerHTML = "Inclu\u00EDdo com sucesso!";
    limpa_form();
}
function fimalterar() {
    alert("Alterado com sucesso!");
    $("MsgResultado").innerHTML = "Alterado com sucesso!";
    limpa_form();
}

function enviar()
{
    valor = document.getElementById('clinguerra').value;
    if (document.getElementById("radiob1").checked == true)
    {
        radiob = 1;
    } else
    {
        radiob = 2;
    }

    if (document.getElementById("radiosex1").checked == true)
    {
        radiosex = '1';
    } else
    {
        radiosex = '2';
    }
    if (document.getElementById("radioip1").checked == true)
    {
        radioip = '1';
    } else
    {
        radioip = '2';
    }

    if (document.getElementById("radiotc1").checked == true)
    {
        radiotc = '1';
    } else
    {
        radiotc = '2';
    }

    if (document.getElementById("radioautfat1").checked == true)
    {
        radioautfat = '1';
    } else if (document.getElementById("radioautfat2").checked == true)
    {
        radioautfat = '2';
    } else if (document.getElementById("radioautfat3").checked == true)
    {
        radioautfat = '3';
    } else if (document.getElementById("radioautfat4").checked == true)
    {
        radioautfat = '4';
    } else if (document.getElementById("radioautfat5").checked == true)
    {
        radioautfat = '5';
    } else
    {
        radioautfat = '6';
    }


    if (document.getElementById("opcaost1").checked == true)
    {
        radiost = '1';
    } else
    {
        radiost = '2';
    }



    if (document.getElementById("opcaocons1").checked == true)
    {
        radiocons = '1';
    } else
    {
        radiocons = '2';
    }


    if (document.getElementById("opcaosimples1").checked == true)
    {
        radiosimples = '1';
    } else if (document.getElementById("opcaosimples2").checked == true)
    {
        radiosimples = '2';
    } else
    {
        if ($("cleuf").value == "SC" || $("cleuf").value == "PR") {
            radiosimples = '0';
        } else
        {
            radiosimples = '2';
        }
    }


    if (document.getElementById("opcaoinativo1").checked == true)
    {
        radioinativo = '1';
    } else if (document.getElementById("opcaoinativo2").checked == true)
    {
        radioinativo = '2';
    }

    var opregime = 0;

    if (document.getElementById("radiosuframa1").checked == true)
    {
        opregime = 1;
    } else if (document.getElementById("radiosuframa2").checked == true)
    {
        opregime = 2;
    } else if (document.getElementById("radiosuframa3").checked == true) {
        opregime = 3;
    }


    if ($("acao").value == "alterar")
    {

        // alert(document.getElementById('cidadeibge').value );

        //window.open ('clientealtera.php?clinguerra=' +
        //document.getElementById('clinguerra').value
        new ajax('clientealtera.php?clinguerra=' + document.getElementById('clinguerra').value
                + "&clicodigo=" + document.getElementById('clicodigo').value
                + "&clidat=" + document.getElementById('clidat').value
                + '&clicod=' + document.getElementById('clicod').value
                + '&clirazao=' + document.getElementById('clirazao').value
                + '&clipais=' + document.getElementById('clipais').value
                + '&clicnpj=' + document.getElementById('clicnpj').value
                + '&cliie=' + document.getElementById('cliie').value
                + '&clirg=' + document.getElementById('clirg').value
                + '&clicpf=' + document.getElementById('clicpf').value
                + '&cliobs=' + document.getElementById('cliobs').value
                + '&clicomerc=' + document.getElementById('clicomerc').value

                + '&clipessoa=' + radiob
                + '&catcodigo=' + document.forms[0].listcategoria.options[document.forms[0].listcategoria.selectedIndex].value
                + '&stccodigo=' + 0 // document.forms[0].liststatcli.options[document.forms[0].liststatcli.selectedIndex].value
                + '&clisuframa=' + document.getElementById('numerosuframa').value
                + '&cliregime=' + opregime
                + '&clecep=' + document.getElementById('clecep').value
                + '&cleendereco=' + document.getElementById('cleendereco').value
                + '&clenumero=' + document.getElementById('clenumero').value
                + '&clecomplemento=' + document.getElementById('clecomplemento').value
                + '&clebairro=' + document.getElementById('clebairro').value
                + '&clefone=' + document.getElementById('clefone').value
                + '&clefax=' + document.getElementById('clefax').value
                + '&cleemail=' + document.getElementById('cleemail').value
                + '&cleemailxml=' + document.getElementById('cleemailxml').value
                + '&clefone2=' + document.getElementById('clefone2').value
                + '&clefone3=' + document.getElementById('clefone3').value

                + '&ccfnome0=' + document.getElementById('ccfnome0').value
                + '&ccffone0=' + document.getElementById('ccffone0').value
                + '&ccfemail0=' + document.getElementById('ccfemail0').value

                + '&ccfnome1=' + document.getElementById('ccfnome1').value
                + '&ccffone1=' + document.getElementById('ccffone1').value
                + '&ccfemail1=' + document.getElementById('ccfemail1').value

                + '&ccfnome2=' + document.getElementById('ccfnome2').value
                + '&ccffone2=' + document.getElementById('ccffone2').value
                + '&ccfemail2=' + document.getElementById('ccfemail2').value

// + '&ccfnome3=' + document.getElementById('ccfnome3').value
// + '&ccffone3=' + document.getElementById('ccffone3').value
// + '&ccfemail3=' + document.getElementById('ccfemail3').value

                + '&clccep=' + document.getElementById('clccep').value
                + '&clcendereco=' + document.getElementById('clcendereco').value
                + '&clcnumero=' + document.getElementById('clcnumero').value
                + '&clccomplemento=' + document.getElementById('clccomplemento').value
                + '&clcbairro=' + document.getElementById('clcbairro').value
                + '&clcfone=' + document.getElementById('clcfone').value
                + '&clcfax=' + document.getElementById('clcfax').value
                + '&clcemail=' + document.getElementById('clcemail').value
                + '&clcfone2=' + document.getElementById('clcfone2').value
                + '&clcfone3=' + document.getElementById('clcfone3').value

                + '&cccnome0=' + document.getElementById('cccnome0').value
                + '&cccfone0=' + document.getElementById('cccfone0').value
                + '&cccemail0=' + document.getElementById('cccemail0').value

                + '&cccnome1=' + document.getElementById('cccnome1').value
                + '&cccfone1=' + document.getElementById('cccfone1').value
                + '&cccemail1=' + document.getElementById('cccemail1').value

// + '&cccnome2=' + document.getElementById('cccnome2').value
// + '&cccfone2=' + document.getElementById('cccfone2').value
// + '&cccemail2=' + document.getElementById('cccemail2').value

// + '&cccnome3=' + document.getElementById('cccnome3').value
// + '&cccfone3=' + document.getElementById('cccfone3').value
// + '&cccemail3=' + document.getElementById('cccemail3').value

                + '&ceecep=' + document.getElementById('ceecep').value
                + '&ceeendereco=' + document.getElementById('ceeendereco').value
                + '&ceenumero=' + document.getElementById('ceenumero').value
                + '&ceecodcidade=' + document.getElementById('ceecodcidade').value
                + '&ceecomplemento=' + document.getElementById('ceecomplemento').value
                + '&ceebairro=' + document.getElementById('ceebairro').value
                + '&ceefone=' + document.getElementById('ceefone').value
                + '&ceefax=' + document.getElementById('ceefax').value
                + '&ceeemail=' + document.getElementById('ceeemail').value
                + '&ceefone2=' + document.getElementById('ceefone2').value
                + '&ceefone3=' + document.getElementById('ceefone3').value

                + '&ccenome0=' + document.getElementById('ccenome0').value
                + '&ccefone0=' + document.getElementById('ccefone0').value
                + '&cceemail0=' + document.getElementById('cceemail0').value

                + '&ccenome1=' + document.getElementById('ccenome1').value
                + '&ccefone1=' + document.getElementById('ccefone1').value
                + '&cceemail1=' + document.getElementById('cceemail1').value

                + '&ccenome2=' + document.getElementById('ccenome2').value
                + '&ccefone2=' + document.getElementById('ccefone2').value
                + '&cceemail2=' + document.getElementById('cceemail2').value

// + '&ccenome3=' + document.getElementById('ccenome3').value
// + '&ccefone3=' + document.getElementById('ccefone3').value
// + '&cceemail3=' + document.getElementById('cceemail3').value

                + '&clecodcidade=' + document.getElementById('clecodcidade').value
                + '&clccodcidade=' + document.getElementById('clccodcidade').value


                + '&tpcliente=' + tpcliente

                + '&clinsocio=' + document.getElementById('clinsocio').value
                + '&clicpfsocio=' + document.getElementById('clicpfsocio').value

                + '&radiosex=' + radiosex
                + '&radioip=' + radioip

// + '&comcep=' + document.getElementById('comcep').value
// + '&comendereco=' + document.getElementById('comendereco').value
// + '&comnumero=' + document.getElementById('comnumero').value
// + '&comcomplemento=' + document.getElementById('comcomplemento').value
// + '&combairro=' + document.getElementById('combairro').value
// + '&comfone=' + document.getElementById('comfone').value
// + '&comfax=' + document.getElementById('comfax').value
// + '&comemail=' + document.getElementById('comemail').value
// + '&comfone2=' + document.getElementById('comfone2').value
// + '&comfone3=' + document.getElementById('comfone3').value

// + '&comcodcidade=' + document.getElementById('comcodcidade').value
                + '&vencodigo=' + document.getElementById('vendedor').value

                + '&clifpagto=' + document.forms[0].listfpagto.options[document.forms[0].listfpagto.selectedIndex].value
                + '&clicanal=' + document.forms[0].listcanal.options[document.forms[0].listcanal.selectedIndex].value
                + '&limitec=' + document.getElementById('limitec').value
                + '&limitec1=' + document.getElementById('limitec1').value
                + '&radioautfat=' + radioautfat
                + '&radiotc=' + radiotc
                + '&cidadeibge=' + document.getElementById('cidadeibge').value
                + '&cidadeibgecob=' + document.getElementById('cidadeibgecob').value
                + '&cidadeibgecee=' + document.getElementById('cidadeibgecee').value
                + '&potencialdecompra=' + document.getElementById('potencialdecompra').value
                + '&limiteproposto=' + document.getElementById('limiteproposto').value

                + '&radiost=' + radiost

                + '&radiosimples=' + radiosimples
                + '&radiocons=' + radiocons
                + '&dataconsimples=' + document.getElementById('dataconsimples').value

                + '&radioinativo=' + radioinativo

                , {onComplete: fimalterar});

        //, '_blank');

        var campos = '';

        if (clirazao != document.getElementById('clirazao').value) {
//                    alert('modificado a Razao Social');
            campos = "Razao Social";
        }
        if (clicnpj != document.getElementById('clicnpj').value) {
//                    alert('modificado a CNPJ');
            if (campos != '') {
                campos += ',';
            }
            campos += 'CNPJ';
        }
        if (cliie != document.getElementById('cliie').value) {
//                    alert('modificado a IE');
            if (campos != '') {
                campos += ',';
            }
            campos += 'IE';
        }
        if (clecep != document.getElementById('clecep').value) {
//                    alert('modificado a CEP FATURAMENTO');
            if (campos != '') {
                campos += ',';
            }
            campos += 'CEP FATURAMENTO';
        }
        if (cleendereco != document.getElementById('cleendereco').value) {
//                    alert('modificado a ENDERECO FATURAMENTO');
            if (campos != '') {
                campos += ',';
            }
            campos += 'ENDERECO FATURAMENTO';
        }
        if (clenumero != document.getElementById('clenumero').value) {
//                    alert('modificado a NUMERO DO ENDERECO FATURAMENTO');
            if (campos != '') {
                campos += ',';
            }
            campos += 'NUMERO DO ENDERECO FATURAMENTO';
        }
        if (cidcodigo != document.getElementById('clecodcidade').value) {
//                    alert('modificado a CIDADE DO ENDERECO FATURAMENTO');
            if (campos != '') {
                campos += ',';
            }
            campos += 'CIDADE DO ENDERECO FATURAMENTO';
        }
        if (ibge != document.getElementById('cidadeibge').value) {
//                    alert('modificado a CIDADE IBGE DO ENDERECO FATURAMENTO');
            if (campos != '') {
                campos += ',';
            }
            campos += 'CIDADE IBGE DO ENDERECO FATURAMENTO';
        }
        if (clefone != document.getElementById('clefone').value) {
//                    alert('modificado a FONE FATURAMENTO');
            if (campos != '') {
                campos += ',';
            }
            campos += 'FONE FATURAMENTO';
        }
        if (cleemail != document.getElementById('cleemail').value) {
//                    alert('modificado a EMAIL FATURAMENTO');
            if (campos != '') {
                campos += ',';
            }
            campos += 'EMAIL FATURAMENTO';
        }


        if (campos != '') {
            new ajax('clientelogaltera.php?clicodigo=' + document.getElementById('clicodigo').value + '&campos=' + campos, {});
        } else {
            new ajax('clientelogaltera.php?clicodigo=' + document.getElementById('clicodigo').value, {});
        }



        document.forms[0].listDados.options.length = 0;

        var novo = document.createElement("option");
        // atribui um ID a esse elemento
        novo.setAttribute("id", "opcoes");
        // atribui um valor
        novo.value = document.getElementById('clicodigo').value;
        // atribui um texto
        // novo.text = document.getElementById('clinguerra').value;

        if (document.getElementById("radio1").checked == true)
        {
            novo.text = document.getElementById('clicod').value;
        } else if (document.getElementById("radio2").checked == true)
        {
            novo.text = document.getElementById('clinguerra').value;
        } else if (document.getElementById("radio3").checked == true)
        {
            novo.text = document.getElementById('clirazao').value;
        } else if (document.getElementById("radio4").checked == true)
        {
            novo.text = document.getElementById('clicnpj').value;
        } else if (document.getElementById("radio5").checked == true)
        {
            novo.text = document.getElementById('clicnpj').value;
        } else
        {
            novo.text = document.getElementById('clicod').value;
        }
        // finalmente adiciona o novo elemento
        document.forms[0].listDados.options.add(novo);

        //alert("Alterado com sucesso!");
        //$("MsgResultado").innerHTML = "Alterado com sucesso!";

        limpa_form();

    }
}

function apagar(clicodigo)
{
    new ajax('clienteapaga.php?clicodigo=' + clicodigo, {});
    alert("Exclu\u00EDdo com sucesso!");
    $("MsgResultado").innerHTML = "ExcluÃ­do com sucesso!";
    limpa_form();
}

function valida_form()
{

    if (document.getElementById('clicod').value == "")
    {
        codigo_cliente(tpcliente);
    }

    var erro = 0;

    if (document.getElementById("radiotipo1").checked == true)
    {
        tpcliente = '1';
    } else
    {
        tpcliente = '2';
    }

    if ($("clinguerra").value == "")
    {
        alert("Preencha o campo Nome de Guerra");
        $("clinguerra").focus();
        erro = 1;
    } else if ($("clirazao").value == "")
    {
        alert("Preencha o campo Raz\u00E3o Social");
        $("clirazao").focus();
        erro = 1;
    } else if ($("radiob1").checked == true && $('clicnpj').value == '')
    {
        alert("Preencha o campo CNPJ corretamente!");
        $('clicnpj').focus();
        erro = 1;
    } else if ($("radiob1").checked == true && validar($('clicnpj')) == false)
    {
        // O alert \u00E9 dado dentro da funÃ§\u00E3o
        erro = 1;
    } else if ($("radiob2").checked == true && $('clicpf').value == '')
    {
        alert("Preencha o campo CPF corretamente!");
        $('clicpf').focus();
        erro = 1;
    } else if ($("radiob2").checked == true && validar2($('clicpf')) == false)
    {
        alert("Preencha o campo CPF corretamente!");
        $('clicpf').focus();
        erro = 1;
    } else if ($("radiob2").checked == true && validar2($('clicpf')) == false)
    {
        // O alert \u00E9 dado dentro da funÃ§\u00E3o
        erro = 1;
    } else if ($('clecep').value == '')
    {
        alert("Preencha o campo CEP corretamente!");
        $('clecep').focus();
        erro = 1;
    } else if ($('cidadeibge').options[$('cidadeibge').selectedIndex].value == '0')
    {
        alert("Selecione uma CIDADE IBGE!");
        $('cidadeibge').focus();
        erro = 1;
    } else if ($('clenumero').value == '')
    {
        alert("Preencha o campo Numero do endere\u00E7o faturamento!");
        $('clenumero').focus();
        erro = 1;
    } else if ($('clefone').value == '')
    {
        alert("Preencha o campo Fone do endere\u00E7o faturamento!");
        $('clefone').focus();
        erro = 1;
    } else if (!validaTel($('clefone').value))
    {
        alert("Fone do endere\u00E7o faturamento precisa estar no formato \'(XX) XXXX-XXXX\' \n" +
                "Caso o telefone tenha menos de 8 d\u00EDgitos, digite zeros a esquerda");
        $('clefone').focus();
        erro = 1;
    } else if ($('cleemail').value == '')
    {
        alert("Preencha o campo Email endere\u00E7o faturamento!");
        $('cleemail').focus();
        erro = 1;
    } else if ($("clinguerra").value == "")
    {
        alert("Preencha o campo Nome de Guerra");
        $("clinguerra").focus();
        erro = 1;
    } else if (document.getElementById("radioc1").checked == true)
    {
        if ($('clccep').value == '')
        {
            alert("Preencha o campo CEP endere\u00E7o cobranÃ§a corretamente!");
            $('clccep').focus();
            erro = 1;
        } else if ($('clcnumero').value == '')
        {
            alert("Preencha o campo Numero endere\u00E7o cobranÃ§a!");
            $('clcnumero').focus();
            erro = 1;
        } else if ($('cidadeibgecob').options[$('cidadeibgecob').selectedIndex].value == '0')
        {
            alert("Selecione uma CIDADE IBGE enderÃ§o de cobranÃ§a!");
            $('cidadeibgecob').focus();
            erro = 1;
        } else if ($('clcfone').value == '')
        {
            alert("Preencha o campo Fone endere\u00E7o cobranÃ§a!");
            $('clcfone').focus();
            erro = 1;
        } else if (!validaTel($('clcfone').value))
        {
            alert("Fone endere\u00E7o cobran�a precisa estar no formato \'(XX) XXXX-XXXX\'\n" +
                    "Caso o telefone tenha menos de 8 d\u00EDgitos, digite zeros a esquerda");
            $('clcfone').focus();
            erro = 1;
        }
    }

    if ($("radiod1").checked == true)
    {
        if ($('ceecep').value == '')
        {
            alert("Preencha o campo CEP endere\u00E7o entrega corretamente!");
            $('ceecep').focus();
            erro = 1;
        } else if ($('ceenumero').value == '')
        {
            alert("Preencha o campo Numero endere\u00E7o entrega!");
            $('ceenumero').focus();
            erro = 1;
        } else if ($('cidadeibgecee').options[$('cidadeibgecee').selectedIndex].value == '0')
        {
            alert("Selecione uma CIDADE IBGE endere\u00E7o entrega!");
            $('cidadeibgecee').focus();
            erro = 1;
        } else if ($('ceefone').value == '')
        {
            alert("Preencha o campo Fone endere\u00E7o entrega!");
            $('ceefone').focus();
            erro = 1;
        } else if (!validaTel($('ceefone').value))
        {
            alert("Fone endere\u00E7o entrega precisa estar no formato \'(XX) XXXX-XXXX\'\n" +
                    "Caso o telefone tenha menos de 8 d\u00EDgitos, digite zeros a esquerda");
            $('ceefone').focus();
            erro = 1;
        }

    }

    if ($("radiob1").checked == true && ($('cliie').value == '')) {
        alert("Preencha o campo Inscri\u00E7\u00E3o Estadual corretamente!");
        $('cliie').focus();
        erro = 1;
    }
// check is cancel validaIE is checked, if true cancel these verification
    else if ($("radiob1").checked == true) {

        if ($('cliie').value.match(/1\.?2\.?3\.?4\.?5\.?6\.?7\.?8\.?9\.?/) ||
                (!$('cliie').value.match(/isent/ig) && !validarIE($('cleuf').value, $('cliie').value))) {

            // check if is 359 or 626


            if ($('cleuf').value == 'AC' && ($('cliie').value.length < 13 || $('cliie').value.length < 17)) {
                alert("Inscri\u00E7\u00E3o Estadual precisa estar no formato \'#############\'." +
                        "\n Caso a inscri\u00E7\u00E3o tenha menos de 13 d\u00EDgitos, digite zeros \u00E0 esquerda");
                $('cliie').focus();
                erro = 1;
            } else if ($('cleuf').value == 'AL' && ($('cliie').value.length < 9 || $('cliie').value.length > 12)) {
                alert("Inscri\u00E7\u00E3o Estadual precisa estar no formato \'#########\'." +
                        "\n Caso a inscri\u00E7\u00E3o tenha menos de 9 d\u00EDgitos, digite zeros \u00E0 esquerda");
                $('cliie').focus();
                erro = 1;
            } else if ($('cleuf').value == 'AP' && ($('cliie').value.length < 9 || $('cliie').value.length > 12)) {
                alert("Inscri\u00E7\u00E3o Estadual precisa estar no formato \'#########\'." +
                        "\n Caso a inscri\u00E7\u00E3o tenha menos de 9 d\u00EDgitos, digite zeros \u00E0 esquerda");
                $('cliie').focus();
                erro = 1;
            } else if ($('cleuf').value == 'AM' && ($('cliie').value.length < 9 || $('cliie').value.length > 12)) {
                alert("Inscri\u00E7\u00E3o Estadual precisa estar no formato \'#########\'." +
                        "\n Caso a inscri\u00E7\u00E3o tenha menos de 9 d\u00EDgitos, digite zeros \u00E0 esquerda");
                $('cliie').focus();
                erro = 1;
            } else if ($('cleuf').value == 'BA' && ($('cliie').value.length < 8 || $('cliie').value.length > 10)) {
                alert("Inscri\u00E7\u00E3o Estadual precisa estar no formato \'#########\'." +
                        "\n Caso a inscri\u00E7\u00E3o tenha menos de 8 d\u00EDgitos, digite zeros \u00E0 esquerda");
                $('cliie').focus();
                erro = 1;
            } else if ($('cleuf').value == 'CE' && ($('cliie').value.length < 9 || $('cliie').value.length > 10)) {
                alert("Inscri\u00E7\u00E3o Estadual precisa estar no formato \'#########\'." +
                        "\n Caso a inscri\u00E7\u00E3o tenha menos de 9 d\u00EDgitos, digite zeros \u00E0 esquerda");
                $('cliie').focus();
                erro = 1;
            } else if ($('cleuf').value == 'DF' && ($('cliie').value.length < 13 || $('cliie').value.length > 15)) {
                alert("Inscri\u00E7\u00E3o Estadual precisa estar no formato \'#############\'." +
                        "\n Caso a inscri\u00E7\u00E3o tenha menos de 13 d\u00EDgitos, digite zeros \u00E0 esquerda");
                $('cliie').focus();
                erro = 1;
            } else if ($('cleuf').value == 'ES' && ($('cliie').value.length < 9 || $('cliie').value.length > 10)) {
                alert("Inscri\u00E7\u00E3o Estadual precisa estar no formato \'#########\'." +
                        "\n Caso a inscri\u00E7\u00E3o tenha menos de 9 d\u00EDgitos, digite zeros \u00E0 esquerda");
                $('cliie').focus();
                erro = 1;
            } else if ($('cleuf').value == 'GO' && ($('cliie').value.length < 9 || $('cliie').value.length > 12)) {
                alert("Inscri\u00E7\u00E3o Estadual precisa estar no formato \'#########\'." +
                        "\n Caso a inscri\u00E7\u00E3o tenha menos de 9 d\u00EDgitos, digite zeros \u00E0 esquerda");
                $('cliie').focus();
                erro = 1;
            } else if ($('cleuf').value == 'MA' && ($('cliie').value.length < 9 || $('cliie').value.length > 10)) {
                alert("Inscri\u00E7\u00E3o Estadual precisa estar no formato \'#########\'." +
                        "\n Caso a inscri\u00E7\u00E3o tenha menos de 9 d\u00EDgitos, digite zeros \u00E0 esquerda");
                $('cliie').focus();
                erro = 1;
            } else if ($('cleuf').value == 'MT' && ($('cliie').value.length < 11 || $('cliie').value.length > 15)) {
                alert("Inscri\u00E7\u00E3o Estadual precisa estar no formato \'###########\'." +
                        "\n Caso a inscri\u00E7\u00E3o tenha menos de 11 d\u00EDgitos, digite zeros \u00E0 esquerda");
                $('cliie').focus();
                erro = 1;
            } else if ($('cleuf').value == 'MS' && ($('cliie').value.length < 10 || $('cliie').value.length > 15)) {
                alert("Inscri\u00E7\u00E3o Estadual precisa estar no formato \'#########\'." +
                        "\n Caso a inscri\u00E7\u00E3o tenha menos de 10 d\u00EDgitos, digite zeros \u00E0 esquerda");
                $('cliie').focus();
                erro = 1;
            } else if ($('cleuf').value == 'MG' && ($('cliie').value.length < 13 || $('cliie').value.length > 16)) {
                alert("Inscri\u00E7\u00E3o Estadual precisa estar no formato \'#############\'." +
                        "\n Caso a inscri\u00E7\u00E3o tenha menos de 13 d\u00EDgitos, digite zeros \u00E0 esquerda");
                $('cliie').focus();
                erro = 1;
            } else if ($('cleuf').value == 'PA' && ($('cliie').value.length < 9 || $('cliie').value.length > 12)) {
                alert("Inscri\u00E7\u00E3o Estadual precisa estar no formato \'#########\'." +
                        "\n Caso a inscri\u00E7\u00E3o tenha menos de 9 d\u00EDgitos, digite zeros \u00E0 esquerda");
                $('cliie').focus();
                erro = 1;
            } else if ($('cleuf').value == 'PB' && ($('cliie').value.length < 9 || $('cliie').value.length > 10)) {
                alert("Inscri\u00E7\u00E3o Estadual precisa estar no formato \'#########\'." +
                        "\n Caso a inscri\u00E7\u00E3o tenha menos de 9 d\u00EDgitos, digite zeros \u00E0 esquerda");
                $('cliie').focus();
                erro = 1;
            } else if ($('cleuf').value == 'PE' && ($('cliie').value.length < 9 || $('cliie').value.length > 18)) {
                alert("Inscri\u00E7\u00E3o Estadual precisa estar no formato \'#########\' ou \'##############\'." +
                        "\n Caso a inscri\u00E7\u00E3o tenha menos de 9 d\u00EDgitos, digite zeros \u00E0 esquerda");
                $('cliie').focus();
                erro = 1;
            } else if ($('cleuf').value == 'PI' && ($('cliie').value.length < 9 || $('cliie').value.length > 10)) {
                alert("Inscri\u00E7\u00E3o Estadual precisa estar no formato \'#########\'." +
                        "\n Caso a inscri\u00E7\u00E3o tenha menos de 9 d\u00EDgitos, digite zeros \u00E0 esquerda");
                $('cliie').focus();
                erro = 1;
            } else if ($('cleuf').value == 'PR' && ($('cliie').value.length < 10 || $('cliie').value.length > 12)) {
                alert("Inscri\u00E7\u00E3o Estadual precisa estar no formato \'##########\'." +
                        "\n Caso a inscri\u00E7\u00E3o tenha menos de 10 d\u00EDgitos, digite zeros \u00E0 esquerda");
                $('cliie').focus();
                erro = 1;
            } else if ($('cleuf').value == 'RJ' && ($('cliie').value.length < 8 || $('cliie').value.length > 11)) {
                alert("Inscri\u00E7\u00E3o Estadual precisa estar no formato \'########\'." +
                        "\n Caso a inscri\u00E7\u00E3o tenha menos de 8 d\u00EDgitos, digite zeros \u00E0 esquerda");
                $('cliie').focus();
                erro = 1;
            } else if ($('cleuf').value == 'RN' && ($('cliie').value.length < 9 || $('cliie').value.length > 14)) {
                alert("Inscri\u00E7\u00E3o Estadual precisa estar no formato \'#########\' ou \'##########\'." +
                        "\n Caso a inscri\u00E7\u00E3o tenha menos de 9 d\u00EDgitos, digite zeros \u00E0 esquerda");
                $('cliie').focus();
                erro = 1;
            } else if ($('cleuf').value == 'RS' && ($('cliie').value.length < 10 || $('cliie').value.length > 12)) {
                alert("Inscri\u00E7\u00E3o Estadual precisa estar no formato \'##########\'." +
                        "\n Caso a inscri\u00E7\u00E3o tenha menos de 10 d\u00EDgitos, digite zeros \u00E0 esquerda");
                $('cliie').focus();
                erro = 1;
            } else if ($('cleuf').value == 'RO' && ($('cliie').value.length < 9 || $('cliie').value.length > 15)) {
                alert("Inscri\u00E7\u00E3o Estadual precisa estar no formato \'#########\' ou \'##############\'." +
                        "\n Caso a inscri\u00E7\u00E3o tenha menos de 9 d\u00EDgitos, digite zeros \u00E0 esquerda");
                $('cliie').focus();
                erro = 1;
            } else if ($('cleuf').value == 'RR' && ($('cliie').value.length < 9 || $('cliie').value.length > 10)) {
                alert("Inscri\u00E7\u00E3o Estadual precisa estar no formato \'#########\'." +
                        "\n Caso a inscri\u00E7\u00E3o tenha menos de 9 d\u00EDgitos, digite zeros \u00E0 esquerda");
                $('cliie').focus();
                erro = 1;
            } else if ($('cleuf').value == 'SC' && ($('cliie').value.length < 9 || $('cliie').value.length > 11)) {
                alert("Inscri\u00E7\u00E3o Estadual precisa estar no formato \'#########\'." +
                        "\n Caso a inscri\u00E7\u00E3o tenha menos de 9 d\u00EDgitos, digite zeros \u00E0 esquerda");
                $('cliie').focus();
                erro = 1;
            } else if ($('cleuf').value == 'SP' && ($('cliie').value.length < 12 || $('cliie').value.length > 15)) {
                alert("Inscri\u00E7\u00E3o Estadual precisa estar no formato \'############\'." +
                        "\n Caso a inscri\u00E7\u00E3o tenha menos de 12 d\u00EDgitos, digite zeros \u00E0 esquerda");
                $('cliie').focus();
                erro = 1;
            } else if ($('cleuf').value == 'SE' && ($('cliie').value.length < 9 || $('cliie').value.length > 10)) {
                alert("Inscri\u00E7\u00E3o Estadual precisa estar no formato \'#########\'." +
                        "\n Caso a inscri\u00E7\u00E3o tenha menos de 9 d\u00EDgitos, digite zeros \u00E0 esquerda");
                $('cliie').focus();
                erro = 1;
            } else if ($('cleuf').value == 'TO' && ($('cliie').value.length < 9 || $('cliie').value.length > 11)) {
                alert("Inscri\u00E7\u00E3o Estadual precisa estar no formato \'###########\' ou \'#########\'." +
                        "\n Caso a inscri\u00E7\u00E3o tenha menos de 9 d\u00EDgitos, digite zeros \u00E0 esquerda");
                $('cliie').focus();
                erro = 1;
            } else {
                alert("Inscri\u00E7\u00E3o Estadual inv\u00E1lida!");
                $('cliie').focus();
                erro = 1;
            }

        }



        if (erro == 1 && permitirLiberacao($("clicodigo").value, $("us").value)) {
            erro = 0;
        }
    }



    if (valida_data2('dataconsimples') == false) {
        $("dataconsimples").focus();
        erro = 1;
    }

    if (document.getElementById("opcaosimples1").checked == true)
    {
        opsimples = 1;
    } else if (document.getElementById("opcaosimples2").checked == true)
    {
        opsimples = 2;
    } else {
        opsimples = 0;
    }

    if ((txt == "") && ($("cleuf").value == "SC") && (opsimples != 0)) {
        alert("Data da Consulta obrigatoria!");
        $('dataconsimples').focus();
        erro = 1;
    }

    if ((txt == "") && ($("cleuf").value == "PR") && (opsimples != 0)) {
        alert("Data da Consulta obrigatoria!");
        $('dataconsimples').focus();
        erro = 1;
    }

    if (erro == 0) {

        if (document.getElementById("opcaosuframa1").checked == true && document.getElementById('numerosuframa').value == '')
        {
            alert("Numero SUFRAMA obrigatorio!");
            $('numerosuframa').focus();
            erro = 1;
        }

    }

    if (erro == 0) {

        var opregime = 0;

        if (document.getElementById("radiosuframa1").checked == true)
        {
            opregime = 1;
        } else if (document.getElementById("radiosuframa2").checked == true)
        {
            opregime = 2;
        } else if (document.getElementById("radiosuframa3").checked == true) {
            opregime = 3;
        }

        if (document.getElementById("opcaosuframa1").checked == true && opregime == 0)
        {
            alert("Regime SUFRAMA obrigatorio!");
            document.getElementById("opcaosuframa1").focus();
            erro = 1;
        }

    }


    if (erro == 0)
    {
        $("MsgResultado").innerHTML = "Processando...";
        window.setTimeout("enviar()", 1800);
        $("botao").setAttribute("disabled", "true");
    }
}

function permitirLiberacao(codigo, us) {

    var acao = 0;
    var msgInc = "Exce��o inclu�da";
    var msgExc = "Exce��o removida";
    var msgFalInc = "Falha na inclus�o da exce��o de IE";
    var msgFalExc = "Falha na exclus�o da exce��o de IE";

    if (us != '359' && us != '728') {
        return false;
    }

    if (confirm("Adicionar IE como exce��o?\n\t"))
    {
        acao = 1;
    }


    if (acao == 0) {
        if (confirm("Remover IE de exce��o?\n\t")) {
            acao = 2;
        }
    }

    if (acao > 0) {
        $a.post('clienteinsereexcp.php',
                {
                    //variaveis a ser enviadas metodo POST
                    codigo: codigo,
                    acao: acao
                },
                function (data)
                {
                    if (data.status) {
                        if (acao == 1) {
                            alert(msgInc);
                            return true;
                        } else if (acao == 2) {
                            alert(msgExc);
                            return true;
                        }
                    } else {
                        if (acao == 1) {
                            alert(msgFalInc);
                        } else if (acao == 2) {
                            alert(msgFalExc);
                        }
                    }
                }, "json");
    }
    return false;
}


function cancelar()
{
    $("pesquisa").value="";
    limpa_form();
}

function limpa_form(tipo)
{
    $("acao").value = "alterar";
    $("botao").value = "Alterar";
    //$("pesquisa").value="";
    $("clicodigo").value = "";
    $("clinguerra").value = "";
    $("clicod").value = "";
    $("clidat").value = "";
    $("clirazao").value = "";
    $("clipais").value = "BRASIL";
    $("clicnpj").value = "";
    $("cliie").value = "";
    $("clirg").value = "";
    $("clicpf").value = "";
    $("cliobs").value = "";
    $("clicomerc").value = "";

    $("resultado").innerHTML = "";


    document.forms[0].listDados.options.length = 1;
    document.getElementById("opcoes").innerHTML = "_";

    document.getElementById("radio1").checked = true;
    document.getElementById("radiob1").checked = true;

    document.forms[0].listcategoria.options[0].selected = true;
    // document.forms[0].liststatcli.options[0].selected = true;

    $("vencodigo").value = "";
    $("cliult").value = "";
    $("clecep").value = "";
    $("cleendereco").value = "";
    $("clebairro").value = "";
    $("clefone").value = "";
    $("clefone2").value = "";
    $("clefone3").value = "";
    $("clefax").value = "";
    $("cleemail").value = "";
    $("cleemailxml").value = "";
    $("ccfnome0").value = "";
    $("ccffone0").value = "";
    $("ccfemail0").value = "";
    $("ccfnome1").value = "";
    $("ccffone1").value = "";
    $("ccfemail1").value = "";
    $("ccfnome2").value = "";
    $("ccffone2").value = "";
    $("ccfemail2").value = "";
// $("ccfnome3").value="";
// $("ccffone3").value="";
// $("ccfemail3").value="";
    $("clccep").value = "";
    $("clcendereco").value = "";
    $("clcnumero").value = "";
    $("clccomplemento").value = "";
    $("clcbairro").value = "";
    $("clcfone").value = "";
    $("clcfone2").value = "";
    $("clcfone3").value = "";
    $("clcfax").value = "";
    $("clcemail").value = "";
    $("cccnome0").value = "";
    $("cccfone0").value = "";
    $("cccemail0").value = "";
    $("cccnome1").value = "";
    $("cccfone1").value = "";
    $("cccemail1").value = "";
// $("cccnome2").value="";
// $("cccfone2").value="";
// $("cccemail2").value="";
// $("cccnome3").value="";
// $("cccfone3").value="";
// $("cccemail3").value="";
    $("ceecep").value = "";
    $("ceeendereco").value = "";
    $("ceenumero").value = "";
    $("ceecomplemento").value = "";
    $("ceebairro").value = "";
    $("ceefone").value = "";
    $("ceefone2").value = "";
    $("ceefone3").value = "";
    $("ceefax").value = "";
    $("ceeemail").value = "";
    $("ccenome0").value = "";
    $("ccefone0").value = "";
    $("cceemail0").value = "";
    $("ccenome1").value = "";
    $("ccefone1").value = "";
    $("cceemail1").value = "";
    $("ccenome2").value = "";
    $("ccefone2").value = "";
    $("cceemail2").value = "";
// $("ccenome3").value="";
// $("ccefone3").value="";
// $("cceemail3").value="";

    $("clecidade").value = "";
    $("cleuf").value = "";
    $("clccidade").value = "";
    $("clcuf").value = "";
    $("ceecidade").value = "";
    $("ceeuf").value = "";

    $("clecodcidade").value = "";
    $("clccodcidade").value = "";
    $("ceecodcidade").value = "";
    $("cidcodigoibge").value = "";
    $("clenumero").value = "";
    $("clecomplemento").value = "";
    $('cidadeibge').innerHTML = '<option  id="cidcodigoibge" value="0">_________________</option>';
    $("cidadeibge").setAttribute("disabled", "true");
    $('cidadeibgecob').innerHTML = '<option  id="cidcodigoibgecob" value="0">_________________</option>';
    $("cidadeibgecob").setAttribute("disabled", "true");
    $('cidadeibgecee').innerHTML = '<option  id="cidcodigoibgecee" value="0">_________________</option>';
    $("cidadeibgecee").setAttribute("disabled", "true");
    //$('clinguerra').innerHTML = '<option  id="opcoescli" value="0">_________________</option>';
    $("potencialdecompra").value = "1.00";
    $("limiteproposto").value = "1.00";
    codigo_cliente(tpcliente);


// $("comcep").value="";
// $("comendereco").value="";
// $("clcomnumero").value="";
// $("clcomcomplemento").value="";
// $("combairro").value="";
// $("comfone").value="";
// $("comfax").value="";
// $("comemail").value="";
// $("comfone2").value="";
// $("comfone3").value="";
// $("comcodcidade").value="";
// $("comcidade").value="";
// $("comuf").value="";
    $("clinsocio").value = "";
    document.getElementById("radiosex1").checked = true;
    document.getElementById("radioip1").checked = true;
    $("clicpfsocio").value = "";

    cep1 = "";
    cep2 = "";
    cep3 = "";
    cep4 = "";
    $("limitec").value = "";
    document.getElementById("radioautfat1").checked = true;
    document.getElementById("radiotc1").checked = true;

    document.getElementById("radiotipo1").checked = true;

    document.getElementById("opcaost1").checked = true;


    document.getElementById("opcaosimples1").checked = false;
    document.getElementById("opcaosimples2").checked = false;
    $("dataconsimples").value = "";

    document.getElementById("opcaocons2").checked = true;

    document.getElementById("opcaosuframa2").checked = true;
    $("numerosuframa").disabled = true;
    $("numerosuframa").value = "";

    $("radiosuframa1").disabled = true;
    $("radiosuframa2").disabled = true;
    $("radiosuframa3").disabled = true;
    $("radiosuframa1").checked = false;
    $("radiosuframa2").checked = false;
    $("radiosuframa3").checked = false;

    document.getElementById("opcaoinativo1").checked = true;
    $("datainativo").value = "";

    document.forms[0].pesquisavendedor.options.length = 0;
    document.getElementById("opcao1").checked = true;
    document.getElementById("pesquisavend").value = '';

    document.getElementById('resultadox').innerHTML = "";


    itemcombo3(1);
    itemcombo4(1);

    document.forms[0].listDados.options.length = 1;
    idOpcao = document.getElementById("opcoes");
    //idOpcao.innerHTML = "";

// idOpcao.innerHTML = "____________________";	
    codigo_cliente(tipo);
    if (tipo > 0) {
    } else {
        $("pesquisa").value = "";
    }

    // if($('cliinc').value=="")
    datadiacampo('cliinc', '');
    $('botao').disabled = false;
}

function excluirEnd1()
{
    if (confirm("Tem certeza que deseja excluir o endereco de cobranca?\n\t"))
    {
        new ajax('clienteexcluiend.php?tabela=cliecob&clicodigo=' + document.getElementById('clicodigo').value, {});
        // alert(document.getElementById('clicodigo').value);
        alert("Excluido com sucesso!");
        $("MsgResultado").innerHTML = "Alterado com sucesso!";

        limpa_form();
    }
}

function excluirEnd2()
{
    if (confirm("Tem certeza que deseja excluir o endereco de entrega?\n\t"))
    {
        new ajax('clienteexcluiend.php?tabela=clieent&clicodigo=' + document.getElementById('clicodigo').value, {});
        // alert(document.getElementById('clicodigo').value);
        alert("Excluido com sucesso!");
        $("MsgResultado").innerHTML = "Alterado com sucesso!";

        limpa_form();
    }
}


function verifica1()
{
    if (confirm("Tem certeza que deseja Excluir?\n\t"))
    {
        apagar($("clicodigo").value);
    }
}



function verifica()
{
    if ($("clicodigo").value == "")
    {
        alert("Nenhum Registro Selecionado!");
    } else
    {
        verifica1();
    }
}





function dadospesquisa(valor)
{
    if (valor !== 0) {
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
                    alert("Esse browser n\u00E3o tem recursos para uso do Ajax");
                    ajax2 = null;
                }
            }
        }
        // se tiver suporte ajax
        if (ajax2)
        {
            $("MsgResultado").innerHTML = "Processando...";

            // deixa apenas o elemento 1 no option, os outros s\u00E3o excluÃ­dos
            document.forms[0].listDados.options.length = 1;
            idOpcao = document.getElementById("opcoes");

            ajax2.open("POST", "clientepesquisa.php", true);
            ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            ajax2.onreadystatechange = function ()
            {
                // enquanto estiver processando...emite a msg de carregando
                if (ajax2.readyState == 1)
                {
                    // idOpcao.innerHTML = "Carregando...!";
                }
                // apÃ³s ser processado - chama funÃ§\u00E3o processXML que vai varrer os
                // dados
                if (ajax2.readyState == 4)
                {
                    if (ajax2.responseXML)
                    {
                        processXML(ajax2.responseXML);
                    } else
                    {
                        // caso n\u00E3o seja um arquivo XML emite a mensagem abaixo
                        idOpcao.innerHTML = "____________________";
                    }
                }
            }
            // passa o parametro

            if (document.getElementById("radio1").checked == true)
            {
                valor2 = "1";
            } else if (document.getElementById("radio2").checked == true)
            {
                valor2 = "2";
            } else if (document.getElementById("radio3").checked == true)
            {
                valor2 = "3";
            } else if (document.getElementById("radio4").checked == true)
            {
                valor2 = "4";
            } else if (document.getElementById("radio5").checked == true)
            {
                valor2 = "5";
            } else
            {
                valor2 = "6";
            }

            if (document.getElementById("opcoesFormaPesquisaClientes2").checked == true)
            {
                valor3 = "2";
            } else if (document.getElementById("opcoesFormaPesquisaClientes1").checked == true)
            {
                valor3 = "1";
            } else if (document.getElementById("opcoesFormaPesquisaClientes0").checked == true)
            {
                valor3 = "0";
            }








            var params = "parametro=" + valor + '&parametro2=' + valor2 + '&tpcliente=' + tpcliente + '&parametro3=' + valor3;
            ajax2.send(params);
        }
    }
}

function dadospesquisa2(valor)
{

    if (document.getElementById("radiotipo1").checked == true)
    {
        tpcliente = '1';
    } else
    {
        tpcliente = '2';
    }


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
                alert("Esse browser n\u00E3o tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    // se tiver suporte ajax
    if (ajax2)
    {
        $("MsgResultado").innerHTML = "Processando...";

        ajax2.open("POST", "clientepesquisa2.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            // enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1)
            {
            }

            // apÃ³s ser processado - chama funÃ§\u00E3o processXML que vai varrer os
            // dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXML2(ajax2.responseXML);
                } else
                {
                    // caso n\u00E3o seja um arquivo XML emite a mensagem abaixo
                }
            }
        }
        // passa o parametro escolhido


        var params = "parametro2=" + valor + '&tpcliente=' + tpcliente;
        ajax2.send(params);
    }
}

function dadospesquisa3(valor)
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
                alert("Esse browser n\u00E3o tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    // se tiver suporte ajax
    if (ajax2)
    {
        $("MsgResultado").innerHTML = "Processando...";

        // deixa apenas o elemento 1 no option, os outros s\u00E3o excluÃ­dos
        document.forms[0].listDados.options.length = 1;

        idOpcao = document.getElementById("opcoes");

        ajax2.open("POST", "clientepesquisa3.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            // enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1)
            {
                idOpcao.innerHTML = "Carregando...!";
            }
            // apÃ³s ser processado - chama funÃ§\u00E3o processXML que vai varrer os
            // dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXML3(ajax2.responseXML);
                } else
                {
                    // caso n\u00E3o seja um arquivo XML emite a mensagem abaixo
                    // idOpcao.innerHTML = "____________________";
                    idOpcao.innerHTML = "_";

                }
            }
        }
        // passa o parametro escolhido
        var params = "parametro=" + valor + '&tpcliente=' + tpcliente;
        ajax2.send(params);
    }
}

function processXML(obj)
{

    auxcidade = '';
    auxestado = '';
    auxvencodigo = '';

    // pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    // total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        document.forms[0].listcanal.options[document.forms[0].listcanal.length - 1] = null;
        document.forms[0].listlocal.options[document.forms[0].listlocal.length - 1] = null;

        var novocanal = document.createElement("option");
        novocanal.setAttribute("id", "opcoes5");
        novocanal.value = 0;
        //	    novo.text  = "Escolha";
        novocanal.text = "";
        document.forms[0].listcanal.options.add(novocanal);

        var novolocal = document.createElement("option");
        novolocal.setAttribute("id", "opcoes6");
        novolocal.value = 0;
        //	    novo.text  = "Escolha";
        novolocal.text = "";
        document.forms[0].listcanal.options.add(novolocal);



        // percorre o arquivo XML paara extrair os dados
        document.forms[0].listDados.options.length = 0;
        var estoque = '';

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];

            // cont\u00E9udo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
            var parametro2 = item.getElementsByTagName("parametro2")[0].firstChild.nodeValue;

            if (parametro2 == "4")
            {
                var descricaoxz = item.getElementsByTagName("razaocnpj")[0].firstChild.nodeValue;
            } else
            {
                var descricaoxz = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
            }

            var descricaob = item.getElementsByTagName("descricaob")[0].firstChild.nodeValue;
            var clidat = item.getElementsByTagName("clidat")[0].firstChild.nodeValue;
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

            var descricao2a = item.getElementsByTagName("descricao2a")[0].firstChild.nodeValue;
            var descricao2b = item.getElementsByTagName("descricao2b")[0].firstChild.nodeValue;
            var descricao2c = item.getElementsByTagName("descricao2c")[0].firstChild.nodeValue;
            var descricao2d = item.getElementsByTagName("descricao2d")[0].firstChild.nodeValue;
            var descricao2e = item.getElementsByTagName("descricao2e")[0].firstChild.nodeValue;
            var descricao2f = item.getElementsByTagName("descricao2f")[0].firstChild.nodeValue;
            var cleemailxml = item.getElementsByTagName("cleemailxml")[0].firstChild.nodeValue;
            var descricao2g = item.getElementsByTagName("descricao2g")[0].firstChild.nodeValue;
            var descricao2h = item.getElementsByTagName("descricao2h")[0].firstChild.nodeValue;
            var descricao2i = item.getElementsByTagName("descricao2i")[0].firstChild.nodeValue;
            var descricao2j = item.getElementsByTagName("descricao2j")[0].firstChild.nodeValue;

            var descricao3a0 = item.getElementsByTagName("descricao3a0")[0].firstChild.nodeValue;
            var descricao3b0 = item.getElementsByTagName("descricao3b0")[0].firstChild.nodeValue;
            var descricao3d0 = item.getElementsByTagName("descricao3d0")[0].firstChild.nodeValue;
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
            var descricao6g = item.getElementsByTagName("descricao6g")[0].firstChild.nodeValue;
            var descricao6h = item.getElementsByTagName("descricao6h")[0].firstChild.nodeValue;
            var descricao6i = item.getElementsByTagName("descricao6i")[0].firstChild.nodeValue;
            var descricao6j = item.getElementsByTagName("descricao6j")[0].firstChild.nodeValue;

            var descricao7a0 = item.getElementsByTagName("descricao7a0")[0].firstChild.nodeValue;
            var descricao7b0 = item.getElementsByTagName("descricao7b0")[0].firstChild.nodeValue;
            var descricao7d0 = item.getElementsByTagName("descricao7d0")[0].firstChild.nodeValue;
            var descricao7a = item.getElementsByTagName("descricao7a")[0].firstChild.nodeValue;
            var descricao7b = item.getElementsByTagName("descricao7b")[0].firstChild.nodeValue;
            var descricao7d = item.getElementsByTagName("descricao7d")[0].firstChild.nodeValue;
            var descricao8a = item.getElementsByTagName("descricao8a")[0].firstChild.nodeValue;
            var descricao8b = item.getElementsByTagName("descricao8b")[0].firstChild.nodeValue;
            var descricao8d = item.getElementsByTagName("descricao8d")[0].firstChild.nodeValue;
            var descricao9a = item.getElementsByTagName("descricao9a")[0].firstChild.nodeValue;
            var descricao9b = item.getElementsByTagName("descricao9b")[0].firstChild.nodeValue;
            var descricao9d = item.getElementsByTagName("descricao9d")[0].firstChild.nodeValue;

            var descricao10a = item.getElementsByTagName("descricao10a")[0].firstChild.nodeValue;
            var descricao10b = item.getElementsByTagName("descricao10b")[0].firstChild.nodeValue;
            var descricao10c = item.getElementsByTagName("descricao10c")[0].firstChild.nodeValue;
            var descricao10d = item.getElementsByTagName("descricao10d")[0].firstChild.nodeValue;
            var descricao10e = item.getElementsByTagName("descricao10e")[0].firstChild.nodeValue;
            var descricao10f = item.getElementsByTagName("descricao10f")[0].firstChild.nodeValue;
            var descricao10g = item.getElementsByTagName("descricao10g")[0].firstChild.nodeValue;
            var descricao10h = item.getElementsByTagName("descricao10h")[0].firstChild.nodeValue;
            var descricao10i = item.getElementsByTagName("descricao10i")[0].firstChild.nodeValue;
            var descricao10j = item.getElementsByTagName("descricao10j")[0].firstChild.nodeValue;

            var descricao11a0 = item.getElementsByTagName("descricao11a0")[0].firstChild.nodeValue;
            var descricao11b0 = item.getElementsByTagName("descricao11b0")[0].firstChild.nodeValue;
            var descricao11d0 = item.getElementsByTagName("descricao11d0")[0].firstChild.nodeValue;
            var descricao11a = item.getElementsByTagName("descricao11a")[0].firstChild.nodeValue;
            var descricao11b = item.getElementsByTagName("descricao11b")[0].firstChild.nodeValue;
            var descricao11d = item.getElementsByTagName("descricao11d")[0].firstChild.nodeValue;
            var descricao12a = item.getElementsByTagName("descricao12a")[0].firstChild.nodeValue;
            var descricao12b = item.getElementsByTagName("descricao12b")[0].firstChild.nodeValue;
            var descricao12d = item.getElementsByTagName("descricao12d")[0].firstChild.nodeValue;
            var descricao14a = item.getElementsByTagName("descricao14a")[0].firstChild.nodeValue;
            var descricao14b = item.getElementsByTagName("descricao14b")[0].firstChild.nodeValue;
            var descricao14d = item.getElementsByTagName("descricao14d")[0].firstChild.nodeValue;

            var descricaon = item.getElementsByTagName("descricaon")[0].firstChild.nodeValue;
            var descricaoo = item.getElementsByTagName("descricaoo")[0].firstChild.nodeValue;
            var descricaop = item.getElementsByTagName("descricaop")[0].firstChild.nodeValue;

            var descricaon2 = item.getElementsByTagName("descricaon2")[0].firstChild.nodeValue;
            var descricaoo2 = item.getElementsByTagName("descricaoo2")[0].firstChild.nodeValue;
            var descricaop2 = item.getElementsByTagName("descricaop2")[0].firstChild.nodeValue;

            var descricaon3 = item.getElementsByTagName("descricaon3")[0].firstChild.nodeValue;
            var descricaoo3 = item.getElementsByTagName("descricaoo3")[0].firstChild.nodeValue;
            var descricaop3 = item.getElementsByTagName("descricaop3")[0].firstChild.nodeValue;

            var descricaoq = item.getElementsByTagName("descricaoq")[0].firstChild.nodeValue;
            var descricaor = item.getElementsByTagName("descricaor")[0].firstChild.nodeValue;

            var xclitipo = item.getElementsByTagName("clitipo")[0].firstChild.nodeValue;

            var des1 = item.getElementsByTagName("des1")[0].firstChild.nodeValue;
            var des2 = item.getElementsByTagName("des2")[0].firstChild.nodeValue;
            var des3 = item.getElementsByTagName("des3")[0].firstChild.nodeValue;
            var des4 = item.getElementsByTagName("des4")[0].firstChild.nodeValue;
            var des5 = item.getElementsByTagName("des5")[0].firstChild.nodeValue;
            var des6 = item.getElementsByTagName("des6")[0].firstChild.nodeValue;
            var des7 = item.getElementsByTagName("des7")[0].firstChild.nodeValue;
            var des8 = item.getElementsByTagName("des8")[0].firstChild.nodeValue;
            var des9 = item.getElementsByTagName("des9")[0].firstChild.nodeValue;
            var des10 = item.getElementsByTagName("des10")[0].firstChild.nodeValue;
            var des11 = item.getElementsByTagName("des11")[0].firstChild.nodeValue;
            var des12 = item.getElementsByTagName("des12")[0].firstChild.nodeValue;
            var des13 = item.getElementsByTagName("des13")[0].firstChild.nodeValue;
            var des14 = item.getElementsByTagName("des14")[0].firstChild.nodeValue;
            var des15 = item.getElementsByTagName("des15")[0].firstChild.nodeValue;
            var des16 = item.getElementsByTagName("des16")[0].firstChild.nodeValue;
            var des17 = item.getElementsByTagName("des17")[0].firstChild.nodeValue;
            var des18 = item.getElementsByTagName("des18")[0].firstChild.nodeValue;

            var clifpagto = item.getElementsByTagName("clifpagto")[0].firstChild.nodeValue;
            var clicanal = item.getElementsByTagName("clicanal")[0].firstChild.nodeValue;

            var clilimite = item.getElementsByTagName("clilimite")[0].firstChild.nodeValue;
            var climodo = item.getElementsByTagName("climodo")[0].firstChild.nodeValue;
            var clifat = item.getElementsByTagName("clifat")[0].firstChild.nodeValue;
            var clifin = item.getElementsByTagName("clifin")[0].firstChild.nodeValue;

            var vencodigo = item.getElementsByTagName("vencodigo")[0].firstChild.nodeValue;

            var cliinc = item.getElementsByTagName("cliinc")[0].firstChild.nodeValue;

            var descricaoib = item.getElementsByTagName("descricaoib")[0].firstChild.nodeValue;
            var cidadeibge = item.getElementsByTagName("cidadeibge")[0].firstChild.nodeValue;

            var descricaoibcob = item.getElementsByTagName("descricaoibcob")[0].firstChild.nodeValue;
            var cidadeibgecob = item.getElementsByTagName("cidadeibgecob")[0].firstChild.nodeValue;

            var descricaoibcee = item.getElementsByTagName("descricaoibcee")[0].firstChild.nodeValue;
            var cidadeibgecee = item.getElementsByTagName("cidadeibgecee")[0].firstChild.nodeValue;

            var potencialdecompra = item.getElementsByTagName("potencialdecompra")[0].firstChild.nodeValue;
            var limiteproposto = item.getElementsByTagName("limiteproposto")[0].firstChild.nodeValue;

            var clidatavalida = item.getElementsByTagName("clidatavalida")[0].firstChild.nodeValue;
            var usuvalida = item.getElementsByTagName("usuvalida")[0].firstChild.nodeValue;

            if (item.getElementsByTagName("pvtipoped")[0] != undefined &&
                    item.getElementsByTagName("pvtipoped")[0] != '' &&
                    item.getElementsByTagName("pvtipoped")[0] != null) {
                var pvtipoped = item.getElementsByTagName("pvtipoped")[0].firstChild.nodeValue;

                var pviest01 = item.getElementsByTagName('pviest01')[0].firstChild.nodeValue;
                var pviest02 = item.getElementsByTagName('pviest02')[0].firstChild.nodeValue;
                var pviest03 = item.getElementsByTagName('pviest03')[0].firstChild.nodeValue;
                var pviest04 = item.getElementsByTagName('pviest04')[0].firstChild.nodeValue;
                var pviest05 = item.getElementsByTagName('pviest05')[0].firstChild.nodeValue;
                var pviest06 = item.getElementsByTagName('pviest06')[0].firstChild.nodeValue;
                var pviest07 = item.getElementsByTagName('pviest07')[0].firstChild.nodeValue;
                var pviest08 = item.getElementsByTagName('pviest08')[0].firstChild.nodeValue;
                var pviest09 = item.getElementsByTagName('pviest09')[0].firstChild.nodeValue;

                var pviest010 = item.getElementsByTagName('pviest010')[0].firstChild.nodeValue;
                var pviest011 = item.getElementsByTagName('pviest011')[0].firstChild.nodeValue;
                var pviest012 = item.getElementsByTagName('pviest012')[0].firstChild.nodeValue;
                var pviest013 = item.getElementsByTagName('pviest013')[0].firstChild.nodeValue;
                var pviest014 = item.getElementsByTagName('pviest014')[0].firstChild.nodeValue;
                var pviest015 = item.getElementsByTagName('pviest015')[0].firstChild.nodeValue;
                var pviest016 = item.getElementsByTagName('pviest016')[0].firstChild.nodeValue;
                var pviest017 = item.getElementsByTagName('pviest017')[0].firstChild.nodeValue;
                var pviest018 = item.getElementsByTagName('pviest018')[0].firstChild.nodeValue;
                var pviest019 = item.getElementsByTagName('pviest019')[0].firstChild.nodeValue;

                var pviest020 = item.getElementsByTagName('pviest020')[0].firstChild.nodeValue;
                var pviest021 = item.getElementsByTagName('pviest021')[0].firstChild.nodeValue;
                var pviest022 = item.getElementsByTagName('pviest022')[0].firstChild.nodeValue;
                var pviest023 = item.getElementsByTagName('pviest023')[0].firstChild.nodeValue;
                var pviest024 = item.getElementsByTagName('pviest024')[0].firstChild.nodeValue;
                var pviest025 = item.getElementsByTagName('pviest025')[0].firstChild.nodeValue;
                var pviest026 = item.getElementsByTagName('pviest026')[0].firstChild.nodeValue;
                var pviest027 = item.getElementsByTagName('pviest027')[0].firstChild.nodeValue;
                var pviest028 = item.getElementsByTagName('pviest028')[0].firstChild.nodeValue;
                var pviest029 = item.getElementsByTagName('pviest029')[0].firstChild.nodeValue;

                var pviest030 = item.getElementsByTagName('pviest030')[0].firstChild.nodeValue;
                var pviest031 = item.getElementsByTagName('pviest031')[0].firstChild.nodeValue;
                var pviest032 = item.getElementsByTagName('pviest032')[0].firstChild.nodeValue;
                var pviest033 = item.getElementsByTagName('pviest033')[0].firstChild.nodeValue;
                var pviest034 = item.getElementsByTagName('pviest034')[0].firstChild.nodeValue;
                var pviest035 = item.getElementsByTagName('pviest035')[0].firstChild.nodeValue;
                var pviest036 = item.getElementsByTagName('pviest036')[0].firstChild.nodeValue;
                var pviest037 = item.getElementsByTagName('pviest037')[0].firstChild.nodeValue;
                var pviest038 = item.getElementsByTagName('pviest038')[0].firstChild.nodeValue;
                var pviest039 = item.getElementsByTagName('pviest039')[0].firstChild.nodeValue;

                var pviest040 = item.getElementsByTagName('pviest040')[0].firstChild.nodeValue;
                var pviest041 = item.getElementsByTagName('pviest041')[0].firstChild.nodeValue;
                var pviest042 = item.getElementsByTagName('pviest042')[0].firstChild.nodeValue;
                var pviest043 = item.getElementsByTagName('pviest043')[0].firstChild.nodeValue;
                var pviest044 = item.getElementsByTagName('pviest044')[0].firstChild.nodeValue;
                var pviest045 = item.getElementsByTagName('pviest045')[0].firstChild.nodeValue;
                var pviest046 = item.getElementsByTagName('pviest046')[0].firstChild.nodeValue;
                var pviest047 = item.getElementsByTagName('pviest047')[0].firstChild.nodeValue;
                var pviest048 = item.getElementsByTagName('pviest048')[0].firstChild.nodeValue;
                var pviest049 = item.getElementsByTagName('pviest049')[0].firstChild.nodeValue;

                var pviest050 = item.getElementsByTagName('pviest050')[0].firstChild.nodeValue;
                var pviest051 = item.getElementsByTagName('pviest051')[0].firstChild.nodeValue;
                var pviest052 = item.getElementsByTagName('pviest052')[0].firstChild.nodeValue;
                var pviest053 = item.getElementsByTagName('pviest053')[0].firstChild.nodeValue;
                var pviest054 = item.getElementsByTagName('pviest054')[0].firstChild.nodeValue;
                var pviest055 = item.getElementsByTagName('pviest055')[0].firstChild.nodeValue;
                var pviest056 = item.getElementsByTagName('pviest056')[0].firstChild.nodeValue;
                var pviest057 = item.getElementsByTagName('pviest057')[0].firstChild.nodeValue;
                var pviest058 = item.getElementsByTagName('pviest058')[0].firstChild.nodeValue;
                var pviest059 = item.getElementsByTagName('pviest059')[0].firstChild.nodeValue;

                var pviest060 = item.getElementsByTagName('pviest060')[0].firstChild.nodeValue;
                var pviest061 = item.getElementsByTagName('pviest061')[0].firstChild.nodeValue;
                var pviest062 = item.getElementsByTagName('pviest062')[0].firstChild.nodeValue;
                var pviest063 = item.getElementsByTagName('pviest063')[0].firstChild.nodeValue;
                var pviest064 = item.getElementsByTagName('pviest064')[0].firstChild.nodeValue;
                var pviest065 = item.getElementsByTagName('pviest065')[0].firstChild.nodeValue;
                var pviest066 = item.getElementsByTagName('pviest066')[0].firstChild.nodeValue;
                var pviest067 = item.getElementsByTagName('pviest067')[0].firstChild.nodeValue;
                var pviest068 = item.getElementsByTagName('pviest068')[0].firstChild.nodeValue;
                var pviest069 = item.getElementsByTagName('pviest069')[0].firstChild.nodeValue;

                var pviest070 = item.getElementsByTagName('pviest070')[0].firstChild.nodeValue;
                var pviest071 = item.getElementsByTagName('pviest071')[0].firstChild.nodeValue;
                var pviest072 = item.getElementsByTagName('pviest072')[0].firstChild.nodeValue;
                var pviest073 = item.getElementsByTagName('pviest073')[0].firstChild.nodeValue;
                var pviest074 = item.getElementsByTagName('pviest074')[0].firstChild.nodeValue;
                var pviest075 = item.getElementsByTagName('pviest075')[0].firstChild.nodeValue;
                var pviest076 = item.getElementsByTagName('pviest076')[0].firstChild.nodeValue;
                var pviest077 = item.getElementsByTagName('pviest077')[0].firstChild.nodeValue;
                var pviest078 = item.getElementsByTagName('pviest078')[0].firstChild.nodeValue;
                var pviest079 = item.getElementsByTagName('pviest079')[0].firstChild.nodeValue;

                var pviest080 = item.getElementsByTagName('pviest080')[0].firstChild.nodeValue;
                var pviest081 = item.getElementsByTagName('pviest081')[0].firstChild.nodeValue;
                var pviest082 = item.getElementsByTagName('pviest082')[0].firstChild.nodeValue;
                var pviest083 = item.getElementsByTagName('pviest083')[0].firstChild.nodeValue;
                var pviest084 = item.getElementsByTagName('pviest084')[0].firstChild.nodeValue;
                var pviest085 = item.getElementsByTagName('pviest085')[0].firstChild.nodeValue;
                var pviest086 = item.getElementsByTagName('pviest086')[0].firstChild.nodeValue;
                var pviest087 = item.getElementsByTagName('pviest087')[0].firstChild.nodeValue;
                var pviest088 = item.getElementsByTagName('pviest088')[0].firstChild.nodeValue;
                var pviest089 = item.getElementsByTagName('pviest089')[0].firstChild.nodeValue;

                var pviest090 = item.getElementsByTagName('pviest090')[0].firstChild.nodeValue;
                var pviest091 = item.getElementsByTagName('pviest091')[0].firstChild.nodeValue;
                var pviest092 = item.getElementsByTagName('pviest092')[0].firstChild.nodeValue;
                var pviest093 = item.getElementsByTagName('pviest093')[0].firstChild.nodeValue;
                var pviest094 = item.getElementsByTagName('pviest094')[0].firstChild.nodeValue;
                var pviest095 = item.getElementsByTagName('pviest095')[0].firstChild.nodeValue;
                var pviest096 = item.getElementsByTagName('pviest096')[0].firstChild.nodeValue;
                var pviest097 = item.getElementsByTagName('pviest097')[0].firstChild.nodeValue;
                var pviest098 = item.getElementsByTagName('pviest098')[0].firstChild.nodeValue;
                var pviest099 = item.getElementsByTagName('pviest099')[0].firstChild.nodeValue;


                if (pviest01 !== '0') {
                    estoque = 'FILIAL';
                } else if (pviest02 !== '0') {
                    estoque = 'MATRIZ';
                } else if (pviest09 !== '0') {
                    estoque = 'CD VILA GUILHERME';
                } else if (pviest011 !== '0') {
                    estoque = 'VIX';
                } else if (pviest026 !== '0') {
                    estoque = 'CD GUARULHOS';
                }



                var codigovendedor = item.getElementsByTagName("codigovendedor")[0].firstChild.nodeValue;
                var vennguerra = item.getElementsByTagName("vennguerra")[0].firstChild.nodeValue;
            }

            receitaNumero = item.getElementsByTagName("receitaNumero")[0].firstChild.nodeValue;
            receitaComplemento = item.getElementsByTagName("receitaComplemento")[0].firstChild.nodeValue;
            receitaCep = item.getElementsByTagName("receitaCep")[0].firstChild.nodeValue;
            receitaBairro = item.getElementsByTagName("receitaBairro")[0].firstChild.nodeValue;
            receitaUf = item.getElementsByTagName("receitaUf")[0].firstChild.nodeValue;
            receitaLogradouro = item.getElementsByTagName("receitaLogradouro")[0].firstChild.nodeValue;
            receitaCidade = item.getElementsByTagName("receitaCidade")[0].firstChild.nodeValue;
            sintegraNumero = item.getElementsByTagName("sintegraNumero")[0].firstChild.nodeValue;
            sintegraComplemento = item.getElementsByTagName("sintegraComplemento")[0].firstChild.nodeValue;
            sintegraCep = item.getElementsByTagName("sintegraCep")[0].firstChild.nodeValue;
            sintegraBairro = item.getElementsByTagName("sintegraBairro")[0].firstChild.nodeValue;
            sintegraUf = item.getElementsByTagName("sintegraUf")[0].firstChild.nodeValue;
            sintegraLogradouro = item.getElementsByTagName("sintegraLogradouro")[0].firstChild.nodeValue;
            sintegraCidade = item.getElementsByTagName("sintegraCidade")[0].firstChild.nodeValue;
            portador = item.getElementsByTagName("portador")[0].firstChild.nodeValue;

            var logcredito = ' anterior ' + item.getElementsByTagName("lgclimite")[0].firstChild.nodeValue;
            logcredito += ' - alterado em ' + item.getElementsByTagName("lgcdata")[0].firstChild.nodeValue;
            logcredito += ' por ' + item.getElementsByTagName("usulogin")[0].firstChild.nodeValue + '.';

            var clist = item.getElementsByTagName("clist")[0].firstChild.nodeValue;

            item.getElementsByTagName("usunome")[0].firstChild.nodeValue;
            trimjs(codigo);
            codigo = txt;


            var clioptsimples = item.getElementsByTagName("clioptsimples")[0].firstChild.nodeValue;

            var cliconsig = item.getElementsByTagName("cliconsig")[0].firstChild.nodeValue;

            var dataconsimples = item.getElementsByTagName("dataconsimples")[0].firstChild.nodeValue;

            if (dataconsimples != '0') {
                $("dataconsimples").value = dataconsimples;
            } else {
                $("dataconsimples").value = '';
            }


            var clioptinativo = item.getElementsByTagName("clioptinativo")[0].firstChild.nodeValue;
            var datainativo = item.getElementsByTagName("datainativo")[0].firstChild.nodeValue;

            var clisuframa = item.getElementsByTagName("clisuframa")[0].firstChild.nodeValue;
            var cliregime = item.getElementsByTagName("cliregime")[0].firstChild.nodeValue;
            if (clisuframa != '0') {
                document.getElementById("opcaosuframa1").checked = true;
                $("numerosuframa").disabled = false;
                $("numerosuframa").value = clisuframa;
                $("radiosuframa1").disabled = false;
                $("radiosuframa2").disabled = false;
                $("radiosuframa3").disabled = false;
                if (cliregime == '1') {
                    document.getElementById("radiosuframa1").checked = true;
                } else if (cliregime == '2') {
                    document.getElementById("radiosuframa2").checked = true;
                } else if (cliregime == '3') {
                    document.getElementById("radiosuframa3").checked = true;
                } else {
                    $("radiosuframa1").checked = false;
                    $("radiosuframa2").checked = false;
                    $("radiosuframa3").checked = false;
                }

            } else {
                document.getElementById("opcaosuframa2").checked = true;
                $("numerosuframa").disabled = true;
                $("numerosuframa").value = "";
                $("radiosuframa1").disabled = true;
                $("radiosuframa2").disabled = true;
                $("radiosuframa3").disabled = true;
                $("radiosuframa1").checked = false;
                $("radiosuframa2").checked = false;
                $("radiosuframa3").checked = false;
            }


            /*
             alert(datainativo);
             
             if (clioptinativo=='t')
             {
             document.getElementById("opcaoinativo2").checked=true;
             }
             else 
             {
             document.getElementById("opcaoinativo1").checked=true;
             }
             
             if (datainativo != '0'){
             $("datainativo").value=datainativo;
             }
             else{
             $("datainativo").value='';
             }
             */


            trimjs(descricaob);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaob = txt;
            trimjs(clidat);
            if (txt == '0') {
                txt = '';
            }
            ;
            clidat = txt;
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
            trimjs(cleemailxml);
            if (txt == '0') {
                txt = '';
            }
            ;
            cleemailxml = txt;
            trimjs(descricao2g);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao2g = txt;
            trimjs(descricao2h);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao2h = txt;
            //trimjs(descricao2i);if (txt=='0'){txt='';};descricao2i = txt;
            trimjs(descricao2j);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao2j = txt;

            trimjs(descricao3a0);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao3a0 = txt;
            trimjs(descricao3b0);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao3b0 = txt;
            trimjs(descricao3d0);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao3d0 = txt;

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
            trimjs(descricao6g);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao6g = txt;
            trimjs(descricao6h);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao6h = txt;
            trimjs(descricao6i);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao6i = txt;
            trimjs(descricao6j);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao6j = txt;

            trimjs(descricao7a0);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao7a0 = txt;
            trimjs(descricao7b0);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao7b0 = txt;
            trimjs(descricao7d0);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao7d0 = txt;

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

            trimjs(descricao10a);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao10a = txt;
            trimjs(descricao10b);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao10b = txt;
            trimjs(descricao10c);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao10c = txt;
            trimjs(descricao10d);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao10d = txt;
            trimjs(descricao10e);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao10e = txt;
            trimjs(descricao10f);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao10f = txt;
            trimjs(descricao10g);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao10g = txt;
            trimjs(descricao10h);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao10h = txt;
            trimjs(descricao10i);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao10i = txt;
            trimjs(descricao10j);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao10j = txt;

            trimjs(descricao11a0);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao11a0 = txt;
            trimjs(descricao11b0);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao11b0 = txt;
            trimjs(descricao11d0);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao11d0 = txt;
            trimjs(descricao11a);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao11a = txt;
            trimjs(descricao11b);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao11b = txt;
            trimjs(descricao11d);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao11d = txt;

            trimjs(descricao12a);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao12a = txt;
            trimjs(descricao12b);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao12b = txt;
            trimjs(descricao12d);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao12d = txt;

            trimjs(descricao14a);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao14a = txt;
            trimjs(descricao14b);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao14b = txt;
            trimjs(descricao14d);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao14d = txt;

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

            trimjs(descricaon2);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaon2 = txt;
            trimjs(descricaoo2);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoo2 = txt;
            trimjs(descricaop2);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaop2 = txt;

            trimjs(descricaon3);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaon3 = txt;
            trimjs(descricaoo3);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoo3 = txt;
            trimjs(descricaop3);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaop3 = txt;

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

            trimjs(des1);
            if (txt == '0') {
                txt = '';
            }
            ;
            des1 = txt;
            trimjs(des2);
            if (txt == '0') {
                txt = '';
            }
            ;
            des2 = txt;
            trimjs(des3);
            if (txt == '0') {
                txt = '';
            }
            ;
            des3 = txt;
            trimjs(des4);
            if (txt == '0') {
                txt = '';
            }
            ;
            des4 = txt;
            trimjs(des5);
            if (txt == '0') {
                txt = '';
            }
            ;
            des5 = txt;
            trimjs(des6);
            if (txt == '0') {
                txt = '';
            }
            ;
            des6 = txt;
            trimjs(des7);
            if (txt == '0') {
                txt = '';
            }
            ;
            des7 = txt;
            trimjs(des8);
            if (txt == '0') {
                txt = '';
            }
            ;
            des8 = txt;
            trimjs(des9);
            if (txt == '0') {
                txt = '';
            }
            ;
            des9 = txt;
            trimjs(des10);
            if (txt == '0') {
                txt = '';
            }
            ;
            des10 = txt;
            trimjs(des11);
            if (txt == '0') {
                txt = '';
            }
            ;
            des11 = txt;
            trimjs(des12);
            if (txt == '0') {
                txt = '';
            }
            ;
            des12 = txt;
            trimjs(des13);
            if (txt == '0') {
                txt = '';
            }
            ;
            des13 = txt;
            trimjs(des14);
            if (txt == '0') {
                txt = '';
            }
            ;
            des14 = txt;
            trimjs(des15);
            if (txt == '0') {
                txt = '';
            }
            ;
            des15 = txt;
            trimjs(des16);
            if (txt == '0') {
                txt = '';
            }
            ;
            des16 = txt;
            trimjs(des17);
            if (txt == '0') {
                txt = '';
            }
            ;
            des17 = txt;
            trimjs(des18);
            if (txt == '0') {
                txt = '';
            }
            ;
            des18 = txt;

            trimjs(clifpagto);
            if (txt == '0') {
                txt = '';
            }
            ;
            clifpagto = txt;
            trimjs(clicanal);
            if (txt == '0') {
                txt = '';
            }
            ;
            clicanal = txt;

            // trimjs(clilimite);if (txt=='0'){txt='';};clilimite = txt;
            trimjs(climodo);
            if (txt == '0') {
                txt = '';
            }
            ;
            climodo = txt;
            trimjs(clifat);
            if (txt == '0') {
                txt = '';
            }
            ;
            clifat = txt;
            trimjs(clifin);
            if (txt == '0') {
                txt = '';
            }
            ;
            clifin = txt;

            trimjs(vencodigo);
            if (txt == '0') {
                txt = '';
            }
            ;
            vencodigo = txt;
            trimjs(cliinc);
            if (txt == '0') {
                txt = '';
            }
            ;
            cliinc = txt;

            trimjs(xclitipo);
            if (txt == '0') {
                txt = '1';
            }
            ;
            xclitipo = txt;

            trimjs(descricaoib);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoib = txt;
            trimjs(cidadeibge);
            if (txt == '0') {
                txt = '';
            }
            ;
            cidadeibge = txt;

            trimjs(descricaoibcob);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoibcob = txt;
            trimjs(cidadeibgecob);
            if (txt == '0') {
                txt = '';
            }
            ;
            cidadeibgecob = txt;

            trimjs(descricaoibcee);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoibcee = txt;
            trimjs(cidadeibgecee);
            if (txt == '0') {
                txt = '';
            }
            ;
            cidadeibgecee = txt;


            trimjs(receitaNumero);
            if (txt == '') {
                txt = '0';
            }
            ;
            receitaNumero = txt;
            trimjs(receitaComplemento);
            if (txt == '') {
                txt = '0';
            }
            ;
            receitaComplemento = txt;
            trimjs(receitaCep);
            if (txt == '') {
                txt = '0';
            }
            ;
            receitaCep = txt;
            trimjs(receitaBairro);
            if (txt == '') {
                txt = '0';
            }
            ;
            receitaBairro = txt;
            trimjs(receitaUf);
            if (txt == '') {
                txt = '0';
            }
            ;
            receitaUf = txt;
            trimjs(receitaLogradouro);
            if (txt == '') {
                txt = '0';
            }
            ;
            receitaLogradouro = txt;
            trimjs(receitaCidade);
            if (txt == '') {
                txt = '0';
            }
            ;
            receitaCidade = txt;
            trimjs(portador);
            if (txt == '') {
                txt = '0';
            }
            ;
            portador = txt;

            trimjs(clist);
            if (txt == '') {
                txt = '1';
            }
            ;
            clist = txt;

            // trimjs(sintegraNumero);if (txt==''){txt='0';};sintegraNumero =
            // txt;
            // trimjs(sintegraComplemento);if
            // (txt==''){txt='0';};sintegraComplemento = txt;
            // trimjs(sintegraCep);if (txt==''){txt='0';};sintegraCep = txt;
            // trimjs(sintegraBairro);if (txt==''){txt='0';};sintegraBairro =
            // txt;
            // trimjs(sintegraUf);if (txt==''){txt='0';};sintegraUf = txt;
            // trimjs(sintegraLogradouro);if
            // (txt==''){txt='0';};sintegraLogradouro = txt;
            // trimjs(sintegraCidade);if (txt==''){txt='0';};sintegraCidade =
            // txt;



            document.getElementById('cidadeibge').innerHTML = '<option  id="cidcodigoibge" value=' + descricaoib + '>' + cidadeibge + '</option>';
            document.getElementById('cidadeibgecob').innerHTML = '<option  id="cidcodigoibgecob" value=' + descricaoibcob + '>' + cidadeibgecob + '</option>';
            document.getElementById('cidadeibgecee').innerHTML = '<option  id="cidcodigoibgecee" value=' + descricaoibcee + '>' + cidadeibgecee + '</option>';
            $("potencialdecompra").value = potencialdecompra;
            $("limiteproposto").value = limiteproposto;

            if (clidatavalida != '0') {


                $("valDados").innerHTML = "Validado em " + clidatavalida;
                //+" por "+usunome;
                if (usuvalida != '0') {
                    $("valDados").innerHTML += " por " + usuvalida;
                }
                //                                                               else {
                //                                                                    $("valDados").value += "usuario sem nome cadastrado";
                //                                                               }
            } else {
                $("valDados").innerHTML = "Dados n&atilde;o validados!";
            }
            if (i == 0)
            {
                cep1 = descricao2a;
                cep2 = descricao6a;
                cep3 = descricao10a;
                cep4 = '';

                $("clicodigo").value = codigo;
                $("clinguerra").value = descricao;
                $("clicod").value = descricaob;
                $("clidat").value = clidat;
                $("clirazao").value = descricaoc;
                $("clipais").value = descricaod;
                $("clicnpj").value = descricaoe;
                $("cliie").value = descricaof;
                $("clirg").value = descricaog;
                $("clicpf").value = descricaoh;
                $("cliobs").value = descricaoi;
                $("clicomerc").value = descricaoj;

                if (descricaok == '1')
                {
                    document.getElementById("radiob1").checked = true;
                    $("clicnpj").disabled = false;
                    $("cliie").disabled = false;
                    $("clirg").disabled = true;
                    $("clicpf").disabled = true;
                } else
                {
                    document.getElementById("radiob2").checked = true;
                    $("clicnpj").disabled = true;
                    $("cliie").disabled = true;
                    $("clirg").disabled = false;
                    $("clicpf").disabled = false;
                }

                $("clecep").value = descricao2a;
                $("cleendereco").value = descricao2b;
                $("clebairro").value = descricao2c;
                $("clefone").value = descricao2d;
                $("clefax").value = descricao2e;
                $("cleemail").value = descricao2f;
                $("cleemailxml").value = cleemailxml;
                $("clefone2").value = descricao2g;
                $("clefone3").value = descricao2h;
                $("clenumero").value = descricao2i;
                $("clecomplemento").value = descricao2j;
                $("portador").value = portador;
                $("ccfnome0").value = descricao3a0;
                $("ccffone0").value = descricao3b0;
                $("ccfemail0").value = descricao3d0;

                $("ccfnome1").value = descricao3a;
                $("ccffone1").value = descricao3b;
                $("ccfemail1").value = descricao3d;

                $("ccfnome2").value = descricao4a;
                $("ccffone2").value = descricao4b;
                $("ccfemail2").value = descricao4d;

// $("ccfnome3").value=descricao5a;
// $("ccffone3").value=descricao5b;
// $("ccfemail3").value=descricao5d;

                $("clccep").value = descricao6a;
                $("clcendereco").value = descricao6b;
                $("clcbairro").value = descricao6c;
                $("clcfone").value = descricao6d;
                $("clcfax").value = descricao6e;
                $("clcemail").value = descricao6f;
                $("clcfone2").value = descricao6g;
                $("clcfone3").value = descricao6h;
                $("clcnumero").value = descricao6i;
                $("clccomplemento").value = descricao6j;
                $('cidadeibge').innerHTML = '<option  id="cidcodigoibge" value=' + descricaoib + '>' + cidadeibge + '</option>';
                $('cidadeibgecob').innerHTML = '<option  id="cidcodigoibge" value=' + descricaoibcob + '>' + cidadeibgecob + '</option>';
                $('cidadeibgecee').innerHTML = '<option  id="cidcodigoibge" value=' + descricaoibcee + '>' + cidadeibgecee + '</option>';
                $("cccnome0").value = descricao7a0;
                $("cccfone0").value = descricao7b0;
                $("cccemail0").value = descricao7d0;

                $("cccnome1").value = descricao7a;
                $("cccfone1").value = descricao7b;
                $("cccemail1").value = descricao7d;

// $("cccnome2").value=descricao8a;
// $("cccfone2").value=descricao8b;
// $("cccemail2").value=descricao8d;
                $("ceenumero").value = descricao10i;
                $("ceecomplemento").value = descricao10j;

// $("cccnome3").value=descricao9a;
// $("cccfone3").value=descricao9b;
// $("cccemail3").value=descricao9d;

                if (descricao6a == '')
                {
                    document.getElementById("radioc1").checked = false;
                    document.getElementById("radioc2").checked = true;
                } else
                {
                    document.getElementById("radioc1").checked = true;
                    document.getElementById("radioc2").checked = false;
                }

                $("ceecep").value = descricao10a;
                $("ceeendereco").value = descricao10b;
                $("ceebairro").value = descricao10c;
                $("ceefone").value = descricao10d;
                $("ceefax").value = descricao10e;
                $("ceeemail").value = descricao10f;
                $("ceefone2").value = descricao10g;
                $("ceefone3").value = descricao10h;

                $("ccenome0").value = descricao11a0;
                $("ccefone0").value = descricao11b0;
                $("cceemail0").value = descricao11d0;

                $("ccenome1").value = descricao11a;
                $("ccefone1").value = descricao11b;
                $("cceemail1").value = descricao11d;

                $("ccenome2").value = descricao12a;
                $("ccefone2").value = descricao12b;
                $("cceemail2").value = descricao12d;

// $("ccenome3").value=descricao14a;
// $("ccefone3").value=descricao14b;
// $("cceemail3").value=descricao14d;

                if (descricao10a == '')
                {
                    document.getElementById("radiod1").checked = false;
                    document.getElementById("radiod2").checked = true;
                } else
                {
                    document.getElementById("radiod1").checked = true;
                    document.getElementById("radiod2").checked = false;
                }


                itemcombo(descricaol);
                // itemcombo2(descricaom);

                $("clecodcidade").value = descricaon;
                $("clecidade").value = descricaoo;
                $("cleuf").value = descricaop;



                document.getElementById("opcaosimples1").checked = false;
                document.getElementById("opcaosimples2").checked = false;

                if (clioptsimples == 't')
                {
                    document.getElementById("opcaosimples1").checked = true;
                } else if (clioptsimples == 'f')
                {
                    document.getElementById("opcaosimples2").checked = true;
                } else {
                    if (descricaop == 'SC' || descricaop == 'PR') {

                    } else {
                        document.getElementById("opcaosimples2").checked = true;
                    }
                }


                if (cliconsig == 't')
                {
                    document.getElementById("opcaocons1").checked = true;
                } else
                {
                    document.getElementById("opcaocons2").checked = true;
                }

                if (clioptinativo == 't')
                {
                    document.getElementById("opcaoinativo2").checked = true;
                } else
                {
                    document.getElementById("opcaoinativo1").checked = true;
                }

                if (datainativo != '0') {
                    $("datainativo").value = datainativo;
                } else {
                    $("datainativo").value = '';
                }


                $("clccodcidade").value = descricaon2;
                $("clccidade").value = descricaoo2;
                $("clcuf").value = descricaop2;

                $("ceecodcidade").value = descricaon3;
                $("ceecidade").value = descricaoo3;
                $("ceeuf").value = descricaop3;

// $("comcep").value=des1;
// $("comendereco").value=des2;
// $("combairro").value=des3;
// / $("comfone").value=des4;
// $("comfax").value=des5;
// $("comemail").value=des6;
// / $("comfone2").value=des8;
// $("comfone3").value=des9;

// $("comcodcidade").value=des14;
// $("comcidade").value=des15;
// $("comuf").value=des16;
// $("clcomnumero").value=des17;
// $("clcomcomplemento").value=des18;

                $("clinsocio").value = des10;


                if (des11 == '1')
                {
                    document.getElementById("radiosex1").checked = true;
                } else
                {
                    document.getElementById("radiosex2").checked = true;
                }

                if (des12 == '1')
                {
                    document.getElementById("radioip1").checked = true;
                } else
                {
                    document.getElementById("radioip2").checked = true;
                }

                $("clicpfsocio").value = des13;

                itemcombo3(clifpagto);
                itemcombo4(clicanal);

                $("limitec").value = clilimite;
                $("limitec1").value = clilimite;
                document.getElementById('alteracaoLimite').innerHTML = '<i>' + logcredito + '</i>';


                if (clifat == '1')
                {
                    document.getElementById("radioautfat1").checked = true;
                } else if (clifat == '2')
                {
                    document.getElementById("radioautfat2").checked = true;
                } else if (clifat == '3')
                {
                    document.getElementById("radioautfat3").checked = true;
                } else if (clifat == '4')
                {
                    document.getElementById("radioautfat4").checked = true;
                } else if (clifat == '5')
                {
                    document.getElementById("radioautfat5").checked = true;
                } else
                {
                    document.getElementById("radioautfat6").checked = true;
                }

                if (climodo == '1')
                {
                    document.getElementById("radiotc1").checked = true;
                } else
                {
                    document.getElementById("radiotc2").checked = true;
                }
                $("cliinc").value = cliinc;

                if (xclitipo == '1')
                {
                    document.getElementById("radiotipo1").checked = true;
                } else
                {
                    document.getElementById("radiotipo2").checked = true;
                }

                document.getElementById("pesquisavend").value = vencodigo;

                if (clist == '1')
                {
                    document.getElementById("opcaost1").checked = true;
                } else
                {
                    document.getElementById("opcaost2").checked = true;
                }

                document.getElementById('resultadox').innerHTML = "";

//				pesquisav(vencodigo);

                //alert( descricaop );
                //alert( descricaoib );

                //dadospesquisaibge( descricaop , descricaoib );

                // $("botao").setAttribute ("disabled", "true");

//				$("acao").value="alterar";
//				$("botao").value="Alterar";
                auxcidade = descricaoib;
                auxestado = descricaop;
                auxvencodigo = vencodigo;

                ufibge = descricaoib;

                window.setTimeout("seleciona_ufibge()", 1000);
            }

            var novo = document.createElement("option");
            novo.setAttribute("id", "opcoes");
            novo.value = codigo;
            novo.text = descricaoxz;

            document.forms[0].listDados.options.add(novo);
        }
        if (estoque != '') {
            pesquisaCanalVenda(pvtipoped);
            pesquisaLocalVenda(estoque);
        }

        $("MsgResultado").innerHTML = "OK";
        $("resultado").innerHTML = "";
        load_grid($("clicodigo").value);
        load_grid_grupo($("clicodigo").value);

        //pesquisaVendedor(codigovendedor,vennguerra);





    } else
    {
        $("MsgResultado").innerHTML = "Nenhum registro encontrado!";

        // caso o XML volte vazio, printa a mensagem abaixo
        $("acao").value = "alterar";
        $("botao").value = "Alterar";

        $("clicodigo").value = "";
        $("clinguerra").value = "";
        $("clicod").value = "";
        $("clidat").value = "";
        $("clirazao").value = "";
        $("clipais").value = "";
        $("clicnpj").value = "";
        $("cliie").value = "";
        $("clirg").value = "";
        $("clicpf").value = "";
        $("cliobs").value = "";
        $("clicomerc").value = "";

        $("vencodigo").value = "";
        $("cliult").value = "";

        document.getElementById('resultadox').innerHTML = "";

        document.getElementById("radiob1").checked = true;

        document.forms[0].listcategoria.options[0].selected = true;
        // document.forms[0].liststatcli.options[0].selected = true;

        $("clecep").value = "";
        $("cleendereco").value = "";
        $("clebairro").value = "";
        $("clefone").value = "";
        $("clefax").value = "";
        $("cleemail").value = "";
        $("cleemailxml").value = "";
        $("clefone2").value = "";
        $("clefone3").value = "";
        $("ccfnome0").value = "";
        $("ccffone0").value = "";
        $("ccfemail0").value = "";
        $("ccfnome1").value = "";
        $("ccffone1").value = "";
        $("ccfemail1").value = "";
        $("ccfnome2").value = "";
        $("ccffone2").value = "";
        $("ccfemail2").value = "";
// $("ccfnome3").value="";
// $("ccffone3").value="";
// $("ccfemail3").value="";
        $("clccep").value = "";
        $("clcendereco").value = "";
        $("clcbairro").value = "";
        $("clcfone").value = "";
        $("clcfax").value = "";
        $("clcemail").value = "";
        $("clcfone2").value = "";
        $("clcfone3").value = "";
        $("cccnome0").value = "";
        $("cccfone0").value = "";
        $("cccemail0").value = "";
        $("cccnome1").value = "";
        $("cccfone1").value = "";
        $("cccemail1").value = "";
// $("cccnome2").value="";
// $("cccfone2").value="";
// $("cccemail2").value="";
// $("cccnome3").value="";
// $("cccfone3").value="";
// $("cccemail3").value="";
        $("ceecep").value = "";
        $("ceeendereco").value = "";
        $("ceebairro").value = "";
        $("ceefone").value = "";
        $("ceefone2").value = "";
        $("ceefone3").value = "";
        $("ceefax").value = "";
        $("ceeemail").value = "";
        $("ccenome0").value = "";
        $("ccefone0").value = "";
        $("cceemail0").value = "";
        $("ccenome1").value = "";
        $("ccefone1").value = "";
        $("cceemail1").value = "";
        $("ccenome2").value = "";
        $("ccefone2").value = "";
        $("cceemail2").value = "";
// $("ccenome3").value="";
// $("ccefone3").value="";
// $("cceemail3").value="";

        $("clecodcidade").value = "";
        $("clccodcidade").value = "";
        $("ceecodcidade").value = "";
        $("cidcodigoibge").value = "";

// $("comcep").value="";
// $("comendereco").value="";
// $("combairro").value="";
// $("comfone").value="";
// $("comfax").value="";
// $("comemail").value="";
// $("comfone2").value="";
// $("comfone3").value="";
// $("comcodcidade").value="";
// $("comcidade").value="";
// $("comuf").value="";
// $("clinsocio").value="";
        document.getElementById("radiosex1").checked = true;
        document.getElementById("radioip1").checked = true;
        $("clicpfsocio").value = "";

        cep1 = "";
        cep2 = "";
        cep3 = "";
        cep4 = "";

        $("limitec").value = "";
        $("limitec1").value = "";
        document.getElementById("radioautfat1").checked = true;
        document.getElementById("radiotc1").checked = true;

        document.getElementById("opcaost1").checked = true;

        document.getElementById("opcaoinativo1").checked = true;
        $("datainativo").value = "";

        itemcombo3(1);
        itemcombo4(1);
        idOpcao.innerHTML = "_";
        // idOpcao.innerHTML = "____________________";

        codigo_cliente();

        // if($('cliinc').value=="")
        datadiacampo('cliinc', '');

        document.forms[0].pesquisavendedor.options.length = 0;
        document.getElementById("opcao1").checked = true;
        document.getElementById("pesquisavend").value = '';

    }


    clirazao = descricaoc;
    clicnpj = descricaoe;
    cliie = descricaof;
    clecep = descricao2a;
    cleendereco = descricao2b;
    clenumero = descricao2i;
    cidcodigo = descricaon;
    ibge = descricaoib;
    clefone = descricao2d;
    cleemail = descricao2f;
    cleemailxml = cleemailxml;

//   alert (
//clirazao
//+"\n"+ clicnpj
//+"\n"+ cliie
//+"\n"+ clecep
//+"\n"+ cleendereco
//+"\n"+ clenumero
//+"\n"+ cidcodigo
//+"\n"+ ibge
//+"\n"+ clefone
//+"\n"+ cleemail
//
//);




    document.forms[0].pesquisavendedor.options.length = 0;
    document.getElementById("opcao1").checked = true;
    document.getElementById("pesquisavend").value = '';

    if (auxvencodigo != '') {
        document.getElementById("pesquisavend").value = auxvencodigo;
        pesquisacodigovennew(auxvencodigo);
    } else {
        if (auxestado != '') {
            dadospesquisaibge(auxestado, auxcidade);
        }
    }

}

function processXML2(obj)
{

    auxcidade = '';
    auxestado = '';
    auxvencodigo = '';

    // pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");
    var estoque = '';

    // total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        // percorre o arquivo XML paara extrair os dados
        document.forms[0].listDados.options.length = 0;

        document.forms[0].listcanal.options[document.forms[0].listcanal.length - 1] = null;
        document.forms[0].listlocal.options[document.forms[0].listlocal.length - 1] = null;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];

            // cont\u00E9udo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
            var descricaob = item.getElementsByTagName("descricaob")[0].firstChild.nodeValue;
            var clidat = item.getElementsByTagName("clidat")[0].firstChild.nodeValue;
            var parametro2 = item.getElementsByTagName("parametro2")[0].firstChild.nodeValue;
            if (parametro2 == "4")
            {
                var descricaoxz = item.getElementsByTagName("razaocnpj")[0].firstChild.nodeValue;
            } else if (parametro2 != "4" || parametro2 == null)
            {
                var descricaoxz = item.getElementsByTagName("descricaoc")[0].firstChild.nodeValue;
            }
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

            var descricao2a = item.getElementsByTagName("descricao2a")[0].firstChild.nodeValue;
            var descricao2b = item.getElementsByTagName("descricao2b")[0].firstChild.nodeValue;
            var descricao2c = item.getElementsByTagName("descricao2c")[0].firstChild.nodeValue;
            var descricao2d = item.getElementsByTagName("descricao2d")[0].firstChild.nodeValue;
            var descricao2e = item.getElementsByTagName("descricao2e")[0].firstChild.nodeValue;
            var descricao2f = item.getElementsByTagName("descricao2f")[0].firstChild.nodeValue;
            var cleemailxml = item.getElementsByTagName("cleemailxml")[0].firstChild.nodeValue;
            var descricao2g = item.getElementsByTagName("descricao2g")[0].firstChild.nodeValue;
            var descricao2h = item.getElementsByTagName("descricao2h")[0].firstChild.nodeValue;
            var descricao2i = item.getElementsByTagName("descricao2i")[0].firstChild.nodeValue;
            var descricao2j = item.getElementsByTagName("descricao2j")[0].firstChild.nodeValue;

            var descricao3a0 = item.getElementsByTagName("descricao3a0")[0].firstChild.nodeValue;
            var descricao3b0 = item.getElementsByTagName("descricao3b0")[0].firstChild.nodeValue;
            var descricao3d0 = item.getElementsByTagName("descricao3d0")[0].firstChild.nodeValue;
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
            var descricao6g = item.getElementsByTagName("descricao6g")[0].firstChild.nodeValue;
            var descricao6h = item.getElementsByTagName("descricao6h")[0].firstChild.nodeValue;
            var descricao6i = item.getElementsByTagName("descricao6i")[0].firstChild.nodeValue;
            var descricao6j = item.getElementsByTagName("descricao6j")[0].firstChild.nodeValue;

            var descricao7a0 = item.getElementsByTagName("descricao7a0")[0].firstChild.nodeValue;
            var descricao7b0 = item.getElementsByTagName("descricao7b0")[0].firstChild.nodeValue;
            var descricao7d0 = item.getElementsByTagName("descricao7d0")[0].firstChild.nodeValue;
            var descricao7a = item.getElementsByTagName("descricao7a")[0].firstChild.nodeValue;
            var descricao7b = item.getElementsByTagName("descricao7b")[0].firstChild.nodeValue;
            var descricao7d = item.getElementsByTagName("descricao7d")[0].firstChild.nodeValue;
            var descricao8a = item.getElementsByTagName("descricao8a")[0].firstChild.nodeValue;
            var descricao8b = item.getElementsByTagName("descricao8b")[0].firstChild.nodeValue;
            var descricao8d = item.getElementsByTagName("descricao8d")[0].firstChild.nodeValue;
            var descricao9a = item.getElementsByTagName("descricao9a")[0].firstChild.nodeValue;
            var descricao9b = item.getElementsByTagName("descricao9b")[0].firstChild.nodeValue;
            var descricao9d = item.getElementsByTagName("descricao9d")[0].firstChild.nodeValue;

            var descricao10a = item.getElementsByTagName("descricao10a")[0].firstChild.nodeValue;
            var descricao10b = item.getElementsByTagName("descricao10b")[0].firstChild.nodeValue;
            var descricao10c = item.getElementsByTagName("descricao10c")[0].firstChild.nodeValue;
            var descricao10d = item.getElementsByTagName("descricao10d")[0].firstChild.nodeValue;
            var descricao10e = item.getElementsByTagName("descricao10e")[0].firstChild.nodeValue;
            var descricao10f = item.getElementsByTagName("descricao10f")[0].firstChild.nodeValue;
            var descricao10g = item.getElementsByTagName("descricao10g")[0].firstChild.nodeValue;
            var descricao10h = item.getElementsByTagName("descricao10h")[0].firstChild.nodeValue;
            var descricao10i = item.getElementsByTagName("descricao10i")[0].firstChild.nodeValue;
            var descricao10j = item.getElementsByTagName("descricao10j")[0].firstChild.nodeValue;

            var descricao11a0 = item.getElementsByTagName("descricao11a0")[0].firstChild.nodeValue;
            var descricao11b0 = item.getElementsByTagName("descricao11b0")[0].firstChild.nodeValue;
            var descricao11d0 = item.getElementsByTagName("descricao11d0")[0].firstChild.nodeValue;
            var descricao11a = item.getElementsByTagName("descricao11a")[0].firstChild.nodeValue;
            var descricao11b = item.getElementsByTagName("descricao11b")[0].firstChild.nodeValue;
            var descricao11d = item.getElementsByTagName("descricao11d")[0].firstChild.nodeValue;
            var descricao12a = item.getElementsByTagName("descricao12a")[0].firstChild.nodeValue;
            var descricao12b = item.getElementsByTagName("descricao12b")[0].firstChild.nodeValue;
            var descricao12d = item.getElementsByTagName("descricao12d")[0].firstChild.nodeValue;
            var descricao14a = item.getElementsByTagName("descricao14a")[0].firstChild.nodeValue;
            var descricao14b = item.getElementsByTagName("descricao14b")[0].firstChild.nodeValue;
            var descricao14d = item.getElementsByTagName("descricao14d")[0].firstChild.nodeValue;

            var descricaon = item.getElementsByTagName("descricaon")[0].firstChild.nodeValue;
            var descricaoo = item.getElementsByTagName("descricaoo")[0].firstChild.nodeValue;
            var descricaop = item.getElementsByTagName("descricaop")[0].firstChild.nodeValue;

            var descricaon2 = item.getElementsByTagName("descricaon2")[0].firstChild.nodeValue;
            var descricaoo2 = item.getElementsByTagName("descricaoo2")[0].firstChild.nodeValue;
            var descricaop2 = item.getElementsByTagName("descricaop2")[0].firstChild.nodeValue;

            var descricaon3 = item.getElementsByTagName("descricaon3")[0].firstChild.nodeValue;
            var descricaoo3 = item.getElementsByTagName("descricaoo3")[0].firstChild.nodeValue;
            var descricaop3 = item.getElementsByTagName("descricaop3")[0].firstChild.nodeValue;

            var descricaoq = item.getElementsByTagName("descricaoq")[0].firstChild.nodeValue;
            var descricaor = item.getElementsByTagName("descricaor")[0].firstChild.nodeValue;

            var xclitipo = item.getElementsByTagName("clitipo")[0].firstChild.nodeValue;

            var des1 = item.getElementsByTagName("des1")[0].firstChild.nodeValue;
            var des2 = item.getElementsByTagName("des2")[0].firstChild.nodeValue;
            var des3 = item.getElementsByTagName("des3")[0].firstChild.nodeValue;
            var des4 = item.getElementsByTagName("des4")[0].firstChild.nodeValue;
            var des5 = item.getElementsByTagName("des5")[0].firstChild.nodeValue;
            var des6 = item.getElementsByTagName("des6")[0].firstChild.nodeValue;
            var des7 = item.getElementsByTagName("des7")[0].firstChild.nodeValue;
            var des8 = item.getElementsByTagName("des8")[0].firstChild.nodeValue;
            var des9 = item.getElementsByTagName("des9")[0].firstChild.nodeValue;
            var des10 = item.getElementsByTagName("des10")[0].firstChild.nodeValue;
            var des11 = item.getElementsByTagName("des11")[0].firstChild.nodeValue;
            var des12 = item.getElementsByTagName("des12")[0].firstChild.nodeValue;
            var des13 = item.getElementsByTagName("des13")[0].firstChild.nodeValue;
            var des14 = item.getElementsByTagName("des14")[0].firstChild.nodeValue;
            var des15 = item.getElementsByTagName("des15")[0].firstChild.nodeValue;
            var des16 = item.getElementsByTagName("des16")[0].firstChild.nodeValue;
            var des17 = item.getElementsByTagName("des17")[0].firstChild.nodeValue;
            var des18 = item.getElementsByTagName("des18")[0].firstChild.nodeValue;

            var clifpagto = item.getElementsByTagName("clifpagto")[0].firstChild.nodeValue;
            var clicanal = item.getElementsByTagName("clicanal")[0].firstChild.nodeValue;

            var clilimite = item.getElementsByTagName("clilimite")[0].firstChild.nodeValue;
            var climodo = item.getElementsByTagName("climodo")[0].firstChild.nodeValue;
            var clifat = item.getElementsByTagName("clifat")[0].firstChild.nodeValue;
            var clifin = item.getElementsByTagName("clifin")[0].firstChild.nodeValue;

            var vencodigo = item.getElementsByTagName("vencodigo")[0].firstChild.nodeValue;
            var cliinc = item.getElementsByTagName("cliinc")[0].firstChild.nodeValue;

            var descricaoib = item.getElementsByTagName("descricaoib")[0].firstChild.nodeValue;
            var cidadeibge = item.getElementsByTagName("cidadeibge")[0].firstChild.nodeValue;

            var descricaoibcob = item.getElementsByTagName("descricaoibcob")[0].firstChild.nodeValue;
            var cidadeibgecob = item.getElementsByTagName("cidadeibgecob")[0].firstChild.nodeValue;

            var descricaoibcee = item.getElementsByTagName("descricaoibcee")[0].firstChild.nodeValue;
            var cidadeibgecee = item.getElementsByTagName("cidadeibgecee")[0].firstChild.nodeValue;

            var potencialdecompra = item.getElementsByTagName("potencialdecompra")[0].firstChild.nodeValue;
            var limiteproposto = item.getElementsByTagName("limiteproposto")[0].firstChild.nodeValue;

            var clidatavalida = item.getElementsByTagName("clidatavalida")[0].firstChild.nodeValue;
            var usuvalida = item.getElementsByTagName("usuvalida")[0].firstChild.nodeValue;

            if (item.getElementsByTagName("pvtipoped")[0] != undefined &&
                    item.getElementsByTagName("pvtipoped")[0] != '' &&
                    item.getElementsByTagName("pvtipoped")[0] != null) {

                var pvtipoped = item.getElementsByTagName("pvtipoped")[0].firstChild.nodeValue;

                var pviest01 = item.getElementsByTagName('pviest01')[0].firstChild.nodeValue;
                var pviest02 = item.getElementsByTagName('pviest02')[0].firstChild.nodeValue;
                var pviest03 = item.getElementsByTagName('pviest03')[0].firstChild.nodeValue;
                var pviest04 = item.getElementsByTagName('pviest04')[0].firstChild.nodeValue;
                var pviest05 = item.getElementsByTagName('pviest05')[0].firstChild.nodeValue;
                var pviest06 = item.getElementsByTagName('pviest06')[0].firstChild.nodeValue;
                var pviest07 = item.getElementsByTagName('pviest07')[0].firstChild.nodeValue;
                var pviest08 = item.getElementsByTagName('pviest08')[0].firstChild.nodeValue;
                var pviest09 = item.getElementsByTagName('pviest09')[0].firstChild.nodeValue;

                var pviest010 = item.getElementsByTagName('pviest010')[0].firstChild.nodeValue;
                var pviest011 = item.getElementsByTagName('pviest011')[0].firstChild.nodeValue;
                var pviest012 = item.getElementsByTagName('pviest012')[0].firstChild.nodeValue;
                var pviest013 = item.getElementsByTagName('pviest013')[0].firstChild.nodeValue;
                var pviest014 = item.getElementsByTagName('pviest014')[0].firstChild.nodeValue;
                var pviest015 = item.getElementsByTagName('pviest015')[0].firstChild.nodeValue;
                var pviest016 = item.getElementsByTagName('pviest016')[0].firstChild.nodeValue;
                var pviest017 = item.getElementsByTagName('pviest017')[0].firstChild.nodeValue;
                var pviest018 = item.getElementsByTagName('pviest018')[0].firstChild.nodeValue;
                var pviest019 = item.getElementsByTagName('pviest019')[0].firstChild.nodeValue;

                var pviest020 = item.getElementsByTagName('pviest020')[0].firstChild.nodeValue;
                var pviest021 = item.getElementsByTagName('pviest021')[0].firstChild.nodeValue;
                var pviest022 = item.getElementsByTagName('pviest022')[0].firstChild.nodeValue;
                var pviest023 = item.getElementsByTagName('pviest023')[0].firstChild.nodeValue;
                var pviest024 = item.getElementsByTagName('pviest024')[0].firstChild.nodeValue;
                var pviest025 = item.getElementsByTagName('pviest025')[0].firstChild.nodeValue;
                var pviest026 = item.getElementsByTagName('pviest026')[0].firstChild.nodeValue;
                var pviest027 = item.getElementsByTagName('pviest027')[0].firstChild.nodeValue;
                var pviest028 = item.getElementsByTagName('pviest028')[0].firstChild.nodeValue;
                var pviest029 = item.getElementsByTagName('pviest029')[0].firstChild.nodeValue;

                var pviest030 = item.getElementsByTagName('pviest030')[0].firstChild.nodeValue;
                var pviest031 = item.getElementsByTagName('pviest031')[0].firstChild.nodeValue;
                var pviest032 = item.getElementsByTagName('pviest032')[0].firstChild.nodeValue;
                var pviest033 = item.getElementsByTagName('pviest033')[0].firstChild.nodeValue;
                var pviest034 = item.getElementsByTagName('pviest034')[0].firstChild.nodeValue;
                var pviest035 = item.getElementsByTagName('pviest035')[0].firstChild.nodeValue;
                var pviest036 = item.getElementsByTagName('pviest036')[0].firstChild.nodeValue;
                var pviest037 = item.getElementsByTagName('pviest037')[0].firstChild.nodeValue;
                var pviest038 = item.getElementsByTagName('pviest038')[0].firstChild.nodeValue;
                var pviest039 = item.getElementsByTagName('pviest039')[0].firstChild.nodeValue;

                var pviest040 = item.getElementsByTagName('pviest040')[0].firstChild.nodeValue;
                var pviest041 = item.getElementsByTagName('pviest041')[0].firstChild.nodeValue;
                var pviest042 = item.getElementsByTagName('pviest042')[0].firstChild.nodeValue;
                var pviest043 = item.getElementsByTagName('pviest043')[0].firstChild.nodeValue;
                var pviest044 = item.getElementsByTagName('pviest044')[0].firstChild.nodeValue;
                var pviest045 = item.getElementsByTagName('pviest045')[0].firstChild.nodeValue;
                var pviest046 = item.getElementsByTagName('pviest046')[0].firstChild.nodeValue;
                var pviest047 = item.getElementsByTagName('pviest047')[0].firstChild.nodeValue;
                var pviest048 = item.getElementsByTagName('pviest048')[0].firstChild.nodeValue;
                var pviest049 = item.getElementsByTagName('pviest049')[0].firstChild.nodeValue;

                var pviest050 = item.getElementsByTagName('pviest050')[0].firstChild.nodeValue;
                var pviest051 = item.getElementsByTagName('pviest051')[0].firstChild.nodeValue;
                var pviest052 = item.getElementsByTagName('pviest052')[0].firstChild.nodeValue;
                var pviest053 = item.getElementsByTagName('pviest053')[0].firstChild.nodeValue;
                var pviest054 = item.getElementsByTagName('pviest054')[0].firstChild.nodeValue;
                var pviest055 = item.getElementsByTagName('pviest055')[0].firstChild.nodeValue;
                var pviest056 = item.getElementsByTagName('pviest056')[0].firstChild.nodeValue;
                var pviest057 = item.getElementsByTagName('pviest057')[0].firstChild.nodeValue;
                var pviest058 = item.getElementsByTagName('pviest058')[0].firstChild.nodeValue;
                var pviest059 = item.getElementsByTagName('pviest059')[0].firstChild.nodeValue;

                var pviest060 = item.getElementsByTagName('pviest060')[0].firstChild.nodeValue;
                var pviest061 = item.getElementsByTagName('pviest061')[0].firstChild.nodeValue;
                var pviest062 = item.getElementsByTagName('pviest062')[0].firstChild.nodeValue;
                var pviest063 = item.getElementsByTagName('pviest063')[0].firstChild.nodeValue;
                var pviest064 = item.getElementsByTagName('pviest064')[0].firstChild.nodeValue;
                var pviest065 = item.getElementsByTagName('pviest065')[0].firstChild.nodeValue;
                var pviest066 = item.getElementsByTagName('pviest066')[0].firstChild.nodeValue;
                var pviest067 = item.getElementsByTagName('pviest067')[0].firstChild.nodeValue;
                var pviest068 = item.getElementsByTagName('pviest068')[0].firstChild.nodeValue;
                var pviest069 = item.getElementsByTagName('pviest069')[0].firstChild.nodeValue;

                var pviest070 = item.getElementsByTagName('pviest070')[0].firstChild.nodeValue;
                var pviest071 = item.getElementsByTagName('pviest071')[0].firstChild.nodeValue;
                var pviest072 = item.getElementsByTagName('pviest072')[0].firstChild.nodeValue;
                var pviest073 = item.getElementsByTagName('pviest073')[0].firstChild.nodeValue;
                var pviest074 = item.getElementsByTagName('pviest074')[0].firstChild.nodeValue;
                var pviest075 = item.getElementsByTagName('pviest075')[0].firstChild.nodeValue;
                var pviest076 = item.getElementsByTagName('pviest076')[0].firstChild.nodeValue;
                var pviest077 = item.getElementsByTagName('pviest077')[0].firstChild.nodeValue;
                var pviest078 = item.getElementsByTagName('pviest078')[0].firstChild.nodeValue;
                var pviest079 = item.getElementsByTagName('pviest079')[0].firstChild.nodeValue;

                var pviest080 = item.getElementsByTagName('pviest080')[0].firstChild.nodeValue;
                var pviest081 = item.getElementsByTagName('pviest081')[0].firstChild.nodeValue;
                var pviest082 = item.getElementsByTagName('pviest082')[0].firstChild.nodeValue;
                var pviest083 = item.getElementsByTagName('pviest083')[0].firstChild.nodeValue;
                var pviest084 = item.getElementsByTagName('pviest084')[0].firstChild.nodeValue;
                var pviest085 = item.getElementsByTagName('pviest085')[0].firstChild.nodeValue;
                var pviest086 = item.getElementsByTagName('pviest086')[0].firstChild.nodeValue;
                var pviest087 = item.getElementsByTagName('pviest087')[0].firstChild.nodeValue;
                var pviest088 = item.getElementsByTagName('pviest088')[0].firstChild.nodeValue;
                var pviest089 = item.getElementsByTagName('pviest089')[0].firstChild.nodeValue;

                var pviest090 = item.getElementsByTagName('pviest090')[0].firstChild.nodeValue;
                var pviest091 = item.getElementsByTagName('pviest091')[0].firstChild.nodeValue;
                var pviest092 = item.getElementsByTagName('pviest092')[0].firstChild.nodeValue;
                var pviest093 = item.getElementsByTagName('pviest093')[0].firstChild.nodeValue;
                var pviest094 = item.getElementsByTagName('pviest094')[0].firstChild.nodeValue;
                var pviest095 = item.getElementsByTagName('pviest095')[0].firstChild.nodeValue;
                var pviest096 = item.getElementsByTagName('pviest096')[0].firstChild.nodeValue;
                var pviest097 = item.getElementsByTagName('pviest097')[0].firstChild.nodeValue;
                var pviest098 = item.getElementsByTagName('pviest098')[0].firstChild.nodeValue;
                var pviest099 = item.getElementsByTagName('pviest099')[0].firstChild.nodeValue;


                if (pviest01 !== '0') {
                    estoque = 'FILIAL';
                } else if (pviest02 !== '0') {
                    estoque = 'MATRIZ';
                } else if (pviest09 !== '0') {
                    estoque = 'CD VILA GUILHERME';
                } else if (pviest011 !== '0') {
                    estoque = 'VIX';
                } else if (pviest026 !== '0') {
                    estoque = 'CD GUARULHOS';
                }



                var codigovendedor = item.getElementsByTagName("codigovendedor")[0].firstChild.nodeValue;
                var vennguerra = item.getElementsByTagName("vennguerra")[0].firstChild.nodeValue;
            }

            var razaocnpj = item.getElementsByTagName("razaocnpj")[0].firstChild.nodeValue;
            var parametro2 = item.getElementsByTagName("parametro2")[0].firstChild.nodeValue;

            var receitaNumero = item.getElementsByTagName("receitaNumero")[0].firstChild.nodeValue;
            var receitaComplemento = item.getElementsByTagName("receitaComplemento")[0].firstChild.nodeValue;
            var receitaCep = item.getElementsByTagName("receitaCep")[0].firstChild.nodeValue;
            var receitaBairro = item.getElementsByTagName("receitaBairro")[0].firstChild.nodeValue;
            var receitaUf = item.getElementsByTagName("receitaUf")[0].firstChild.nodeValue;
            var receitaLogradouro = item.getElementsByTagName("receitaLogradouro")[0].firstChild.nodeValue;
            var receitaCidade = item.getElementsByTagName("receitaCidade")[0].firstChild.nodeValue;
            var sintegraNumero = item.getElementsByTagName("sintegraNumero")[0].firstChild.nodeValue;
            var sintegraComplemento = item.getElementsByTagName("sintegraComplemento")[0].firstChild.nodeValue;
            var sintegraCep = item.getElementsByTagName("sintegraCep")[0].firstChild.nodeValue;
            var sintegraBairro = item.getElementsByTagName("sintegraBairro")[0].firstChild.nodeValue;
            var sintegraUf = item.getElementsByTagName("sintegraUf")[0].firstChild.nodeValue;
            var sintegraLogradouro = item.getElementsByTagName("sintegraLogradouro")[0].firstChild.nodeValue;
            var sintegraCidade = item.getElementsByTagName("sintegraCidade")[0].firstChild.nodeValue;

            var logcredito = ' anterior ' + item.getElementsByTagName("lgclimite")[0].firstChild.nodeValue;
            logcredito += ' - alterado em ' + item.getElementsByTagName("lgcdata")[0].firstChild.nodeValue;
            logcredito += ' por ' + item.getElementsByTagName("usulogin")[0].firstChild.nodeValue + '.';

            var clist = item.getElementsByTagName("clist")[0].firstChild.nodeValue;


            var clioptsimples = item.getElementsByTagName("clioptsimples")[0].firstChild.nodeValue;

            var cliconsig = item.getElementsByTagName("cliconsig")[0].firstChild.nodeValue;

            var dataconsimples = item.getElementsByTagName("dataconsimples")[0].firstChild.nodeValue;

            if (dataconsimples != '0') {
                $("dataconsimples").value = dataconsimples;
            } else {
                $("dataconsimples").value = '';
            }

            var clisuframa = item.getElementsByTagName("clisuframa")[0].firstChild.nodeValue;
            var cliregime = item.getElementsByTagName("cliregime")[0].firstChild.nodeValue;
            if (clisuframa != '0') {
                document.getElementById("opcaosuframa1").checked = true;
                $("numerosuframa").disabled = false;
                $("numerosuframa").value = clisuframa;
                $("radiosuframa1").disabled = false;
                $("radiosuframa2").disabled = false;
                $("radiosuframa3").disabled = false;
                if (cliregime == '1') {
                    document.getElementById("radiosuframa1").checked = true;
                } else if (cliregime == '2') {
                    document.getElementById("radiosuframa2").checked = true;
                } else if (cliregime == '3') {
                    document.getElementById("radiosuframa3").checked = true;
                } else {
                    $("radiosuframa1").checked = false;
                    $("radiosuframa2").checked = false;
                    $("radiosuframa3").checked = false;
                }

            } else {
                document.getElementById("opcaosuframa2").checked = true;
                $("numerosuframa").disabled = true;
                $("numerosuframa").value = "";
                $("radiosuframa1").disabled = true;
                $("radiosuframa2").disabled = true;
                $("radiosuframa3").disabled = true;
                $("radiosuframa1").checked = false;
                $("radiosuframa2").checked = false;
                $("radiosuframa3").checked = false;
            }

            var clioptinativo = item.getElementsByTagName("clioptinativo")[0].firstChild.nodeValue;
            var datainativo = item.getElementsByTagName("datainativo")[0].firstChild.nodeValue;

            if (clioptinativo == 't')
            {
                document.getElementById("opcaoinativo2").checked = true;
            } else
            {
                document.getElementById("opcaoinativo1").checked = true;
            }

            if (datainativo != '0') {
                $("datainativo").value = datainativo;
            } else {
                $("datainativo").value = '';
            }


            item.getElementsByTagName("usunome")[0].firstChild.nodeValue;
            trimjs(codigo);
            codigo = txt;
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
            trimjs(clidat);
            if (txt == '0') {
                txt = '';
            }
            ;
            clidat = txt;
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
            trimjs(cleemailxml);
            if (txt == '0') {
                txt = '';
            }
            ;
            cleemailxml = txt;
            trimjs(descricao2g);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao2g = txt;
            trimjs(descricao2h);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao2h = txt;
            trimjs(descricao2i);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao2i = txt;
            trimjs(descricao2j);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao2j = txt;

            trimjs(descricao3a0);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao3a0 = txt;
            trimjs(descricao3b0);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao3b0 = txt;
            trimjs(descricao3d0);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao3d0 = txt;

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
            trimjs(descricao6g);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao6g = txt;
            trimjs(descricao6h);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao6h = txt;
            trimjs(descricao6i);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao6i = txt;
            trimjs(descricao6j);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao6j = txt;

            trimjs(descricao7a0);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao7a0 = txt;
            trimjs(descricao7b0);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao7b0 = txt;
            trimjs(descricao7d0);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao7d0 = txt;

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

            trimjs(descricao10a);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao10a = txt;
            trimjs(descricao10b);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao10b = txt;
            trimjs(descricao10c);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao10c = txt;
            trimjs(descricao10d);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao10d = txt;
            trimjs(descricao10e);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao10e = txt;
            trimjs(descricao10f);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao10f = txt;
            trimjs(descricao10g);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao10g = txt;
            trimjs(descricao10h);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao10h = txt;
            trimjs(descricao10i);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao10i = txt;
            trimjs(descricao10j);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao10j = txt;

            trimjs(descricao11a0);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao11a0 = txt;
            trimjs(descricao11b0);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao11b0 = txt;
            trimjs(descricao11d0);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao11d0 = txt;
            trimjs(descricao11a);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao11a = txt;
            trimjs(descricao11b);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao11b = txt;
            trimjs(descricao11d);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao11d = txt;

            trimjs(descricao12a);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao12a = txt;
            trimjs(descricao12b);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao12b = txt;
            trimjs(descricao12d);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao12d = txt;

            trimjs(descricao14a);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao14a = txt;
            trimjs(descricao14b);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao14b = txt;
            trimjs(descricao14d);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricao14d = txt;

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

            trimjs(descricaon2);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaon2 = txt;
            trimjs(descricaoo2);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoo2 = txt;
            trimjs(descricaop2);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaop2 = txt;

            trimjs(descricaon3);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaon3 = txt;
            trimjs(descricaoo3);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaoo3 = txt;
            trimjs(descricaop3);
            if (txt == '0') {
                txt = '';
            }
            ;
            descricaop3 = txt;

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

            trimjs(des1);
            if (txt == '0') {
                txt = '';
            }
            ;
            des1 = txt;
            trimjs(des2);
            if (txt == '0') {
                txt = '';
            }
            ;
            des2 = txt;
            trimjs(des3);
            if (txt == '0') {
                txt = '';
            }
            ;
            des3 = txt;
            trimjs(des4);
            if (txt == '0') {
                txt = '';
            }
            ;
            des4 = txt;
            trimjs(des5);
            if (txt == '0') {
                txt = '';
            }
            ;
            des5 = txt;
            trimjs(des6);
            if (txt == '0') {
                txt = '';
            }
            ;
            des6 = txt;
            trimjs(des7);
            if (txt == '0') {
                txt = '';
            }
            ;
            des7 = txt;
            trimjs(des8);
            if (txt == '0') {
                txt = '';
            }
            ;
            des8 = txt;
            trimjs(des9);
            if (txt == '0') {
                txt = '';
            }
            ;
            des9 = txt;
            trimjs(des10);
            if (txt == '0') {
                txt = '';
            }
            ;
            des10 = txt;
            trimjs(des11);
            if (txt == '0') {
                txt = '';
            }
            ;
            des11 = txt;
            trimjs(des12);
            if (txt == '0') {
                txt = '';
            }
            ;
            des12 = txt;
            trimjs(des13);
            if (txt == '0') {
                txt = '';
            }
            ;
            des13 = txt;
            trimjs(des14);
            if (txt == '0') {
                txt = '';
            }
            ;
            des14 = txt;
            trimjs(des15);
            if (txt == '0') {
                txt = '';
            }
            ;
            des15 = txt;
            trimjs(des16);
            if (txt == '0') {
                txt = '';
            }
            ;
            des16 = txt;
            trimjs(des17);
            if (txt == '0') {
                txt = '';
            }
            ;
            des17 = txt;
            trimjs(des18);
            if (txt == '0') {
                txt = '';
            }
            ;
            des18 = txt;

            trimjs(clifpagto);
            if (txt == '0') {
                txt = '';
            }
            ;
            clifpagto = txt;
            trimjs(clicanal);
            if (txt == '0') {
                txt = '';
            }
            ;
            clicanal = txt;

            // trimjs(clilimite);if (txt=='0'){txt='';};clilimite = txt;
            trimjs(climodo);
            if (txt == '0') {
                txt = '';
            }
            ;
            climodo = txt;
            trimjs(clifat);
            if (txt == '0') {
                txt = '';
            }
            ;
            clifat = txt;
            trimjs(clifin);
            if (txt == '0') {
                txt = '';
            }
            ;
            clifin = txt;

            trimjs(vencodigo);
            if (txt == '0') {
                txt = '';
            }
            ;
            vencodigo = txt;
            trimjs(cliinc);
            if (txt == '0') {
                txt = '';
            }
            ;
            cliinc = txt;

            trimjs(xclitipo);
            if (txt == '0') {
                txt = '1';
            }
            ;
            xclitipo = txt;

            trimjs(descricaoib);
            if (txt == '') {
                txt = '0';
            }
            ;
            descricaoib = txt;
            trimjs(cidadeibge);
            if (txt == '') {
                txt = '0';
            }
            ;
            cidadeibge = txt;

            trimjs(descricaoibcob);
            if (txt == '') {
                txt = '0';
            }
            ;
            descricaoibcob = txt;
            trimjs(cidadeibgecob);
            if (txt == '') {
                txt = '0';
            }
            ;
            cidadeibgecob = txt;

            trimjs(descricaoibcee);
            if (txt == '') {
                txt = '0';
            }
            ;
            descricaoibcee = txt;
            trimjs(cidadeibgecee);
            if (txt == '') {
                txt = '0';
            }
            ;
            cidadeibgecee = txt;

            trimjs(receitaNumero);
            if (txt == '') {
                txt = '0';
            }
            ;
            receitaNumero = txt;
            trimjs(receitaComplemento);
            if (txt == '') {
                txt = '0';
            }
            ;
            receitaComplemento = txt;
            trimjs(receitaCep);
            if (txt == '') {
                txt = '0';
            }
            ;
            receitaCep = txt;
            trimjs(receitaBairro);
            if (txt == '') {
                txt = '0';
            }
            ;
            receitaBairro = txt;
            trimjs(receitaUf);
            if (txt == '') {
                txt = '0';
            }
            ;
            receitaUf = txt;
            trimjs(receitaLogradouro);
            if (txt == '') {
                txt = '0';
            }
            ;
            receitaLogradouro = txt;
            trimjs(receitaCidade);
            if (txt == '') {
                txt = '0';
            }
            ;
            receitaCidade = txt;
            trimjs(sintegraNumero);
            if (txt == '') {
                txt = '0';
            }
            ;
            sintegraNumero = txt;
            trimjs(sintegraComplemento);
            if (txt == '') {
                txt = '0';
            }
            ;
            sintegraComplemento = txt;
            trimjs(sintegraCep);
            if (txt == '') {
                txt = '0';
            }
            ;
            sintegraCep = txt;
            trimjs(sintegraBairro);
            if (txt == '') {
                txt = '0';
            }
            ;
            sintegraBairro = txt;
            trimjs(sintegraUf);
            if (txt == '') {
                txt = '0';
            }
            ;
            sintegraUf = txt;
            trimjs(sintegraLogradouro);
            if (txt == '') {
                txt = '0';
            }
            ;
            sintegraLogradouro = txt;
            trimjs(sintegraCidade);
            if (txt == '') {
                txt = '0';
            }
            ;
            sintegraCidade = txt;

            trimjs(clist);
            if (txt == '') {
                txt = '1';
            }
            ;
            clist = txt;

            document.getElementById('cidadeibge').innerHTML = '<option  id="cidcodigoibge" value=' + descricaoib + '>' + cidadeibge + '</option>';
            document.getElementById('cidadeibgecob').innerHTML = '<option  id="cidcodigoibgecob" value=' + descricaoibcob + '>' + cidadeibgecob + '</option>';
            document.getElementById('cidadeibgecee').innerHTML = '<option  id="cidcodigoibgecee" value=' + descricaoibcee + '>' + cidadeibgecee + '</option>';
            $("potencialdecompra").value = potencialdecompra;
            $("limiteproposto").value = limiteproposto;

            if (clidatavalida != '0') {


                $("valDados").innerHTML = "Validado em " + clidatavalida;
                //+" por "+usunome;
                if (usuvalida != '0') {
                    $("valDados").innerHTML += " por " + usuvalida;
                }
                //                                                               else {
                //                                                                    $("valDados").value += "usuario sem nome cadastrado";
                //                                                               }
            } else {
                $("valDados").innerHTML = "Dados n&atilde;o validados!";
            }
            if (i == 0)
            {
                cep1 = descricao2a;
                cep2 = descricao6a;
                cep3 = descricao10a;
                cep4 = '';

                $("clicodigo").value = codigo;
                $("clinguerra").value = descricao;
                $("clicod").value = descricaob;
                $("clidat").value = clidat;
                $("clirazao").value = descricaoc;
                $("clipais").value = descricaod;
                $("clicnpj").value = descricaoe;
                $("cliie").value = descricaof;
                $("clirg").value = descricaog;
                $("clicpf").value = descricaoh;
                $("cliobs").value = descricaoi;
                $("clicomerc").value = descricaoj;

                if (descricaok == '1')
                {
                    document.getElementById("radiob1").checked = true;
                    $("clicnpj").disabled = false;
                    $("cliie").disabled = false;
                    $("clirg").disabled = true;
                    $("clicpf").disabled = true;
                } else
                {
                    document.getElementById("radiob2").checked = true;
                    $("clicnpj").disabled = true;
                    $("cliie").disabled = true;
                    $("clirg").disabled = false;
                    $("clicpf").disabled = false;
                }

                $("clecep").value = descricao2a;
                $("cleendereco").value = descricao2b;
                $("clebairro").value = descricao2c;
                $("clefone").value = descricao2d;
                $("clefax").value = descricao2e;
                $("cleemail").value = descricao2f;
                $("cleemailxml").value = cleemailxml;
                $("clefone2").value = descricao2g;
                $("clefone3").value = descricao2h;
                $("clenumero").value = descricao2i;
                $("clecomplemento").value = descricao2j;

                $("ccfnome0").value = descricao3a0;
                $("ccffone0").value = descricao3b0;
                $("ccfemail0").value = descricao3d0;

                $("ccfnome1").value = descricao3a;
                $("ccffone1").value = descricao3b;
                $("ccfemail1").value = descricao3d;

                $("ccfnome2").value = descricao4a;
                $("ccffone2").value = descricao4b;
                $("ccfemail2").value = descricao4d;

// $("ccfnome3").value=descricao5a;
// $("ccffone3").value=descricao5b;
// $("ccfemail3").value=descricao5d;

                $("clccep").value = descricao6a;
                $("clcendereco").value = descricao6b;
                $("clcbairro").value = descricao6c;
                $("clcfone").value = descricao6d;
                $("clcfax").value = descricao6e;
                $("clcemail").value = descricao6f;
                $("clcfone2").value = descricao6g;
                $("clcfone3").value = descricao6h;
                $("clcnumero").value = descricao6i;
                $("clccomplemento").value = descricao6j;
                $('cidadeibge').innerHTML = '<option  id="cidcodigoibge" value=' + descricaoib + '>' + cidadeibge + '</option>';
                $('cidadeibgecob').innerHTML = '<option  id="cidcodigoibge" value=' + descricaoibcob + '>' + cidadeibgecob + '</option>';
                $('cidadeibgecee').innerHTML = '<option  id="cidcodigoibge" value=' + descricaoibcee + '>' + cidadeibgecee + '</option>';
                $("cccnome0").value = descricao7a0;
                $("cccfone0").value = descricao7b0;
                $("cccemail0").value = descricao7d0;

                $("cccnome1").value = descricao7a;
                $("cccfone1").value = descricao7b;
                $("cccemail1").value = descricao7d;

// $("cccnome2").value=descricao8a;
// $("cccfone2").value=descricao8b;
// $("cccemail2").value=descricao8d;
                $("ceenumero").value = descricao10i;
                $("ceecomplemento").value = descricao10j;

// $("cccnome3").value=descricao9a;
// $("cccfone3").value=descricao9b;
// $("cccemail3").value=descricao9d;

                if (descricao6a + descricao6b + descricao6c +
                        descricao6d + descricao6e + descricao6f +
                        descricao6g + descricao6h + descricao6i + descricao6j +
                        descricao7a0 + descricao7b0 + descricao7d0 +
                        descricao7a + descricao7b + descricao7d +
                        descricao8a + descricao8b + descricao8d +
                        descricao9a + descricao9b + descricao9d == '')
                {
                    document.getElementById("radioc1").checked = false;
                    document.getElementById("radioc2").checked = true;
                } else
                {
                    document.getElementById("radioc1").checked = true;
                    $("excluirend1").disabled = false;
                    document.getElementById("radioc2").checked = false;
                }

                $("ceecep").value = descricao10a;
                $("ceeendereco").value = descricao10b;
                $("ceebairro").value = descricao10c;
                $("ceefone").value = descricao10d;
                $("ceefax").value = descricao10e;
                $("ceeemail").value = descricao10f;
                $("ceefone2").value = descricao10g;
                $("ceefone3").value = descricao10h;

                $("ccenome0").value = descricao11a0;
                $("ccefone0").value = descricao11b0;
                $("cceemail0").value = descricao11d0;

                $("ccenome1").value = descricao11a;
                $("ccefone1").value = descricao11b;
                $("cceemail1").value = descricao11d;

                $("ccenome2").value = descricao12a;
                $("ccefone2").value = descricao12b;
                $("cceemail2").value = descricao12d;

// $("ccenome3").value=descricao14a;
// $("ccefone3").value=descricao14b;
// $("cceemail3").value=descricao14d;

                if (descricao10a + descricao10b + descricao10c +
                        descricao10d + descricao10e + descricao10f +
                        descricao10g + descricao10h + descricao10i + descricao10j +
                        descricao11a0 + descricao11b0 + descricao11d0 +
                        descricao11a + descricao11b + descricao11d +
                        descricao12a + descricao12b + descricao12d +
                        descricao14a + descricao14b + descricao14d == '')
                {
                    document.getElementById("radiod1").checked = false;
                    document.getElementById("radiod2").checked = true;
                } else
                {
                    document.getElementById("radiod1").checked = true;
                    $("excluirend2").disabled = false;
                    document.getElementById("radiod2").checked = false;
                }

                itemcombo(descricaol);
                // itemcombo2(descricaom);

                $("clecodcidade").value = descricaon;
                $("clecidade").value = descricaoo;
                $("cleuf").value = descricaop;

                document.getElementById("opcaosimples1").checked = false;
                document.getElementById("opcaosimples2").checked = false;

                if (clioptsimples == 't')
                {
                    document.getElementById("opcaosimples1").checked = true;
                } else if (clioptsimples == 'f')
                {
                    document.getElementById("opcaosimples2").checked = true;
                } else {
                    if (descricaop == 'SC' || descricaop == 'PR') {

                    } else {
                        document.getElementById("opcaosimples2").checked = true;
                    }
                }

                if (cliconsig == 't')
                {
                    document.getElementById("opcaocons1").checked = true;
                } else
                {
                    document.getElementById("opcaocons2").checked = true;
                }

                if (clioptinativo == 't')
                {
                    document.getElementById("opcaoinativo2").checked = true;
                } else
                {
                    document.getElementById("opcaoinativo1").checked = true;
                }

                if (datainativo != '0') {
                    $("datainativo").value = datainativo;
                } else {
                    $("datainativo").value = '';
                }

                document.getElementById('resultadox').innerHTML = "";

                $("clccodcidade").value = descricaon2;
                $("clccidade").value = descricaoo2;
                $("clcuf").value = descricaop2;

                $("ceecodcidade").value = descricaon3;
                $("ceecidade").value = descricaoo3;
                $("ceeuf").value = descricaop3;

// $("comcep").value=des1;
// $("comendereco").value=des2;
// $("combairro").value=des3;
// / $("comfone").value=des4;
// $("comfax").value=des5;
// $("comemail").value=des6;
// / $("comfone2").value=des8;
// $("comfone3").value=des9;

// $("comcodcidade").value=des14;
// $("comcidade").value=des15;
// $("comuf").value=des16;
// $("clcomnumero").value=des17;
// $("clcomcomplemento").value=des18;

                $("clinsocio").value = des10;


                if (des11 == '1')
                {
                    document.getElementById("radiosex1").checked = true;
                } else
                {
                    document.getElementById("radiosex2").checked = true;
                }

                if (des12 == '1')
                {
                    document.getElementById("radioip1").checked = true;
                } else
                {
                    document.getElementById("radioip2").checked = true;
                }

                $("clicpfsocio").value = des13;

                itemcombo3(clifpagto);
                itemcombo4(clicanal);

                $("limitec").value = clilimite;
                $("limitec1").value = clilimite;
                document.getElementById('alteracaoLimite').innerHTML = '<i>' + logcredito + '</i>';


                if (clifat == '1')
                {
                    document.getElementById("radioautfat1").checked = true;
                } else if (clifat == '2')
                {
                    document.getElementById("radioautfat2").checked = true;
                } else if (clifat == '3')
                {
                    document.getElementById("radioautfat3").checked = true;
                } else if (clifat == '4')
                {
                    document.getElementById("radioautfat4").checked = true;
                } else if (clifat == '5')
                {
                    document.getElementById("radioautfat5").checked = true;
                } else
                {
                    document.getElementById("radioautfat6").checked = true;
                }

                if (climodo == '1')
                {
                    document.getElementById("radiotc1").checked = true;
                } else
                {
                    document.getElementById("radiotc2").checked = true;
                }
                $("cliinc").value = cliinc;

                if (xclitipo == '1')
                {
                    document.getElementById("radiotipo1").checked = true;
                } else
                {
                    document.getElementById("radiotipo2").checked = true;
                }

                document.getElementById("pesquisavend").value = vencodigo;

                if (clist == '1')
                {
                    document.getElementById("opcaost1").checked = true;
                } else
                {
                    document.getElementById("opcaost2").checked = true;
                }





//				pesquisav(vencodigo);

                //dadospesquisaibge(descricaop,descricaoib);

                auxcidade = descricaoib;
                auxestado = descricaop;
                auxvencodigo = vencodigo;

                // $("botao").setAttribute ("disabled", "true");
                $("acao").value = "alterar";
                $("botao").value = "Alterar";

                ufibge = descricaoib;
                window.setTimeout("seleciona_ufibge()", 1000);
            }

            var novo = document.createElement("option");
            novo.setAttribute("id", "opcoes");
            novo.value = codigo;
            novo.text = descricaoc;
            document.forms[0].listDados.options.add(novo);
        }

        if (estoque != '') {
            pesquisaCanalVenda(pvtipoped);
            pesquisaLocalVenda(estoque);
        }

        $("MsgResultado").innerHTML = "OK";
        $("resultado").innerHTML = "";
        load_grid($("clicodigo").value);
        load_grid_grupo($("clicodigo").value);




    } else
    {
        $("MsgResultado").innerHTML = "Nenhum registro encontrado!";

        // caso o XML volte vazio, printa a mensagem abaixo
        $("acao").value = "alterar";
        $("botao").value = "Alterar";

        $("clicodigo").value = "";
        $("clinguerra").value = "";
        $("clicod").value = "";
        $("clidat").value = "";
        $("clirazao").value = "";
        $("clipais").value = "";
        $("clicnpj").value = "";
        $("cliie").value = "";
        $("clirg").value = "";
        $("clicpf").value = "";
        $("cliobs").value = "";
        $("clicomerc").value = "";

        $("vencodigo").value = "";
        $("cliult").value = "";

        document.getElementById("radiob1").checked = true;

        document.forms[0].listcategoria.options[0].selected = true;
        // document.forms[0].liststatcli.options[0].selected = true;

        $("clecep").value = "";
        $("cleendereco").value = "";
        $("clebairro").value = "";
        $("clefone").value = "";
        $("clefax").value = "";
        $("cleemail").value = "";
        $("clefone2").value = "";
        $("clefone3").value = "";
        $("ccfnome0").value = "";
        $("ccffone0").value = "";
        $("ccfemail0").value = "";
        $("ccfnome1").value = "";
        $("ccffone1").value = "";
        $("ccfemail1").value = "";
        $("ccfnome2").value = "";
        $("ccffone2").value = "";
        $("ccfemail2").value = "";
// $("ccfnome3").value="";
// $("ccffone3").value="";
// $("ccfemail3").value="";
        $("clccep").value = "";
        $("clcendereco").value = "";
        $("clcbairro").value = "";
        $("clcfone").value = "";
        $("clcfax").value = "";
        $("clcemail").value = "";
        $("clcfone2").value = "";
        $("clcfone3").value = "";
        $("cccnome0").value = "";
        $("cccfone0").value = "";
        $("cccemail0").value = "";
        $("cccnome1").value = "";
        $("cccfone1").value = "";
        $("cccemail1").value = "";
// $("cccnome2").value="";
// $("cccfone2").value="";
// $("cccemail2").value="";
// $("cccnome3").value="";
// $("cccfone3").value="";
// $("cccemail3").value="";
        $("ceecep").value = "";
        $("ceeendereco").value = "";
        $("ceebairro").value = "";
        $("ceefone").value = "";
        $("ceefone2").value = "";
        $("ceefone3").value = "";
        $("ceefax").value = "";
        $("ceeemail").value = "";
        $("ccenome0").value = "";
        $("ccefone0").value = "";
        $("cceemail0").value = "";
        $("ccenome1").value = "";
        $("ccefone1").value = "";
        $("cceemail1").value = "";
        $("ccenome2").value = "";
        $("ccefone2").value = "";
        $("cceemail2").value = "";
// $("ccenome3").value="";
// $("ccefone3").value="";
// $("cceemail3").value="";

        $("clecodcidade").value = "";
        $("clccodcidade").value = "";
        $("ceecodcidade").value = "";
        $("cidcodigoibge").value = "";

        document.getElementById('resultadox').innerHTML = "";

// $("comcep").value="";
// $("comendereco").value="";
// $("combairro").value="";
// $("comfone").value="";
// $("comfax").value="";
// $("comemail").value="";
// $("comfone2").value="";
// $("comfone3").value="";
// $("comcodcidade").value="";
// $("comcidade").value="";
// $("comuf").value="";
// $("clinsocio").value="";
        document.getElementById("radiosex1").checked = true;
        document.getElementById("radioip1").checked = true;
        $("clicpfsocio").value = "";

        cep1 = "";
        cep2 = "";
        cep3 = "";
        cep4 = "";

        $("limitec").value = "";
        $("limitec1").value = "";
        document.getElementById("radioautfat1").checked = true;
        document.getElementById("radiotc1").checked = true;

        document.getElementById("opcaost1").checked = true;

        document.getElementById("opcaoinativo1").checked = true;
        $("datainativo").value = "";

        itemcombo3(1);
        itemcombo4(1);
        idOpcao.innerHTML = "_";
// idOpcao.innerHTML = "____________________";

        codigo_cliente();

        // if($('cliinc').value=="")
        datadiacampo('cliinc', '');
    }

    clirazao = descricaoc;
    clicnpj = descricaoe;
    cliie = descricaof;
    clecep = descricao2a;
    cleendereco = descricao2b;
    clenumero = descricao2i;
    cidcodigo = descricaon;
    ibge = descricaoib;
    clefone = descricao2d;
    cleemail = descricao2f;
    cleemailxml = cleemailxml;



    document.forms[0].pesquisavendedor.options.length = 0;
    document.getElementById("opcao1").checked = true;
    document.getElementById("pesquisavend").value = '';

    if (auxvencodigo != '') {
        document.getElementById("pesquisavend").value = auxvencodigo;
        pesquisacodigovennew(auxvencodigo);
    } else {
        if (auxestado != '') {
            dadospesquisaibge(auxestado, auxcidade);
        }
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

            // cont\u00E9udo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
            var descricaob = item.getElementsByTagName("descricaob")[0].firstChild.nodeValue;
            var descricaoc = item.getElementsByTagName("descricaoc")[0].firstChild.nodeValue;
            var descricaod = item.getElementsByTagName("descricaod")[0].firstChild.nodeValue;
            var descricaoe = item.getElementsByTagName("descricaoe")[0].firstChild.nodeValue;
            var descricaof = item.getElementsByTagName("descricaof")[0].firstChild.nodeValue;
            var descricaog = item.getElementsByTagName("descricaog")[0].firstChild.nodeValue;
            var descricaoh = item.getElementsByTagName("descricaoh")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;
            trimjs(descricaob);
            descricaob = txt;
            trimjs(descricaoc);
            descricaoc = txt;
            trimjs(descricaod);
            descricaod = txt;
            trimjs(descricaoe);
            descricaoe = txt;
            trimjs(descricaof);
            descricaof = txt;
            trimjs(descricaog);
            descricaog = txt;
            trimjs(descricaoh);
            descricaoh = txt;

            // cria um novo option dinamicamente
            var novo = document.createElement("option");
            // atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes");
            // atribui um valor
            novo.value = codigo;
            // atribui um texto

            $("clicod").value = descricaob;

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
            } else if (document.getElementById("radio5").checked == true)
            {
                novo.text = descricaoh;
            } else
            {
                novo.text = descricaob;
            }

            // finalmente adiciona o novo elemento
            document.forms[0].listDados.options.add(novo);

            if (i == 0)
            {
                $("clicodigo").value = codigo;

                $("acao").value = "alterar";
                $("botao").value = "Alterar";
            }
        }
        $("MsgResultado").innerHTML = "";
    } else
    {
        $("MsgResultado").innerHTML = "Nenhum registro encontrado!";

        // caso o XML volte vazio, printa a mensagem abaixo
        $("acao").value = "alterar";
        $("botao").value = "Alterar";

        $("clicodigo").value = "";
        $("clinguerra").value = "";
        $("clicod").value = "";
        $("clidat").value = "";
        $("clirazao").value = "";
        $("clipais").value = "";
        $("clicnpj").value = "";
        $("cliie").value = "";
        $("clirg").value = "";
        $("clicpf").value = "";
        $("cliobs").value = "";
        $("clicomerc").value = "";

        $("vencodigo").value = "";
        $("cliult").value = "";

        document.getElementById("radiob1").checked = true;

        document.forms[0].listcategoria.options[0].selected = true;
        // document.forms[0].liststatcli.options[0].selected = true;

        $("clecep").value = "";
        $("cleendereco").value = "";
        $("clebairro").value = "";
        $("clefone").value = "";
        $("clefax").value = "";
        $("cleemail").value = "";
        $("ccfnome1").value = "";
        $("ccffone1").value = "";
        $("ccfdepto1").value = "";
        $("ccfemail1").value = "";
        $("ccfnome2").value = "";
        $("ccffone2").value = "";
        $("ccfdepto2").value = "";
        $("ccfemail2").value = "";
// $("ccfnome3").value="";
// $("ccffone3").value="";
        $("ccfdepto3").value = "";
// $("ccfemail3").value="";
        $("clccep").value = "";
        $("clcendereco").value = "";
        $("clcbairro").value = "";
        $("clcfone").value = "";
        $("clcfax").value = "";
        $("clcemail").value = "";
        $("cccnome1").value = "";
        $("cccfone1").value = "";
        $("cccdepto1").value = "";
        $("cccemail1").value = "";
// $("cccnome2").value="";
// $("cccfone2").value="";
        $("cccdepto2").value = "";
// $("cccemail2").value="";
// $("cccnome3").value="";
// $("cccfone3").value="";
        $("cccdepto3").value = "";
// $("cccemail3").value="";
        $("ceecep").value = "";
        $("ceeendereco").value = "";
        $("ceebairro").value = "";
        $("ceefone").value = "";
        $("ceefax").value = "";
        $("ceeemail").value = "";
        $("ccenome1").value = "";
        $("ccefone1").value = "";
        $("ccedepto1").value = "";
        $("cceemail1").value = "";
        $("ccenome2").value = "";
        $("ccefone2").value = "";
        $("ccedepto2").value = "";
        $("cceemail2").value = "";
// $("ccenome3").value="";
// $("ccefone3").value="";
        $("ccedepto3").value = "";
// $("cceemail3").value="";

        $("clecodcidade").value = "";
        $("clccodcidade").value = "";
        $("ceecodcidade").value = "";
        $("cidcodigoibge").value = "";

        document.getElementById('resultadox').innerHTML = "";

// $("comcep").value="";
// $("comendereco").value="";
// $("combairro").value="";
// $("comfone").value="";
// $("comfax").value="";
// $("comemail").value="";
// $("comfone2").value="";
// $("comfone3").value="";
// $("comcodcidade").value="";
// $("comcidade").value="";
// $("comuf").value="";
        $("clinsocio").value = "";
        document.getElementById("radiosex1").checked = true;
        document.getElementById("radioip1").checked = true;
        $("clicpfsocio").value = "";

        cep1 = "";
        cep2 = "";
        cep3 = "";
        cep4 = "";

        $("limitec").value = "";
        document.getElementById("radioautfat1").checked = true;
        document.getElementById("radiotc1").checked = true;

        document.getElementById("opcaoinativo1").checked = true;
        $("datainativo").value = "";

        itemcombo3(1);
        itemcombo4(1);
        idOpcao.innerHTML = "_";
// idOpcao.innerHTML = "____________________";

        codigo_cliente();

        // if($('cliinc').value=="")
        datadiacampo('cliinc', '');
    }
}

function dadospesquisacategoria(valor, tipo)
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
                alert("Esse browser n\u00E3o tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    // se tiver suporte ajax
    if (ajax2)
    {
        // deixa apenas o elemento 1 no option, os outros s\u00E3o excluÃ­dos
        document.forms[0].listcategoria.options.length = 1;

        idOpcao = document.getElementById("opcoes2");

        ajax2.open("POST", "clientepesquisacategoriacod.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            // enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1)
            {
                idOpcao.innerHTML = "Carregando...!";
            }
            // apÃ³s ser processado - chama funÃ§\u00E3o processXML que vai varrer os
            // dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXMLcategoria(ajax2.responseXML, tipo);
                } else
                {
                    // caso n\u00E3o seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "_";
// idOpcao.innerHTML = "____________________";
                }
            }
        }
        // passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLcategoria(obj, tipo)
{
    // pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    // total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        // percorre o arquivo XML paara extrair os dados
        document.forms[0].listcategoria.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            // cont\u00E9udo dos campos no arquivo XML
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
            novo.text = codigo + ' ' + descricao;
            // finalmente adiciona o novo elemento
            document.forms[0].listcategoria.options.add(novo);
        }
    } else
    {
        // caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "_";
// idOpcao.innerHTML = "____________________";
    }

    if ($('cliinc').value == "")
        datadiacampo('cliinc', '');

    // dadospesquisastatcli(0,tipo)
    dadospesquisafpagto(0, tipo);
}

function itemcombo(valor)
{
    y = document.forms[0].listcategoria.options.length;

    for (var i = 0; i < y; i++)
    {
        document.forms[0].listcategoria.options[i].selected = true;
        var l = document.forms[0].listcategoria;
        // var li = l.options[l.selectedIndex].text;
        var li = l.options[l.selectedIndex].value;
        if (li == valor)
        {
            i = y;
        }
    }
}


function dadospesquisastatcli(valor, tipo)
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
                alert("Esse browser n\u00E3o tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    // se tiver suporte ajax
    if (ajax2)
    {
        // deixa apenas o elemento 1 no option, os outros s\u00E3o excluÃ­dos
        // document.forms[0].liststatcli.options.length = 1;

        idOpcao = document.getElementById("opcoes3");

        ajax2.open("POST", "clientepesquisastatcli.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            // enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1)
            {
                idOpcao.innerHTML = "Carregando...!";
            }
            // apÃ³s ser processado - chama funÃ§\u00E3o processXML que vai varrer os
            // dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXMLstatcli(ajax2.responseXML, tipo);
                } else
                {
                    // caso n\u00E3o seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "_";
// idOpcao.innerHTML = "____________________";
                }
            }
        }
        // passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}


function processXMLstatcli(obj, tipo)
{
    // pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    // total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        // percorre o arquivo XML paara extrair os dados
        document.forms[0].liststatcli.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            // cont\u00E9udo dos campos no arquivo XML
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
            document.forms[0].liststatcli.options.add(novo);
        }
    } else
    {
        // caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "_";
// idOpcao.innerHTML = "____________________";
    }

    dadospesquisafpagto(0, tipo);
}

function dadospesquisafpagto(valor, tipo)
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
                alert("Esse browser n\u00E3o tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    // se tiver suporte ajax
    if (ajax2)
    {
        // deixa apenas o elemento 1 no option, os outros s\u00E3o excluÃ­dos
        document.forms[0].listfpagto.options.length = 1;

        idOpcao = document.getElementById("opcoes4");

        ajax2.open("POST", "clientepesquisafpagto.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            // enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1)
            {
                idOpcao.innerHTML = "Carregando...!";
            }
            // apÃ³s ser processado - chama funÃ§\u00E3o processXML que vai varrer os
            // dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXMLfpagto(ajax2.responseXML, tipo);
                } else
                {
                    // caso n\u00E3o seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "_";
// idOpcao.innerHTML = "____________________";
                }
            }
        }
        // passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLfpagto(obj, tipo)
{
    // pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    // total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        // percorre o arquivo XML paara extrair os dados
        document.forms[0].listfpagto.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            // cont\u00E9udo dos campos no arquivo XML
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
            document.forms[0].listfpagto.options.add(novo);
        }
    } else
    {
        // caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "____________________";
    }

    dadospesquisacanal(0, tipo);
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
                alert("Esse browser n\u00E3o tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    // se tiver suporte ajax
    if (ajax2)
    {
        // deixa apenas o elemento 1 no option, os outros s\u00E3o excluÃ­dos
        document.forms[0].listcanal.options.length = 1;

        idOpcao = document.getElementById("opcoes5");

        ajax2.open("POST", "clientepesquisacanal.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            // enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1)
            {
                idOpcao.innerHTML = "Carregando...!";
            }
            // apÃ³s ser processado - chama funÃ§\u00E3o processXML que vai varrer os
            // dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXMLcanal(ajax2.responseXML, tipo);
                } else
                {
                    // caso n\u00E3o seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "____________________";
                    limpa_form(tipo);
                }
            }
        };
        // passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);

        if ($('cliinc').value == "")
            $('cliinc').value = day + "/" + month + "/" + year;

    }
}

function processXMLcanal(obj, tipo)
{
    // pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    // total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        // percorre o arquivo XML paara extrair os dados
        document.forms[0].listcanal.options.length = 0;

        var novo = document.createElement("option");
        novo.setAttribute("id", "opcoes5");
        novo.value = 0;
//	    novo.text  = "Escolha";
        novo.text = "";
        document.forms[0].listcanal.options.add(novo);

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            // cont\u00E9udo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;

            // idOpcao.innerHTML = "";
            // cria um novo option dinamicamente
//			var novo = document.createElement("option");
//		    // atribui um ID a esse elemento
//		    novo.setAttribute("id", "opcoes5");
//			// atribui um valor
//		    novo.value = codigo;
//			// atribui um texto
//		    novo.text  = descricao;
//			// finalmente adiciona o novo elemento
//			document.forms[0].listcanal.options.add(novo);
        }
    } else
    {
        // caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "_";
// idOpcao.innerHTML = "____________________";
    }

    limpa_form(tipo);

    if ($('cliinc').value == "")
        $('cliinc').value = day + "/" + month + "/" + year;
}




function pesquisacep(valor)
{
    // if($("acao").value=="inserir"){
    trimjs($("clecep").value);

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
                        alert("Esse browser n\u00E3o tem recursos para uso do Ajax");
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
                    // apÃ³s ser processado - chama funÃ§\u00E3o processXML que vai
                    // varrer os dados
                    if (ajax2.readyState == 4)
                    {
                        if (ajax2.responseXML)
                        {
                            processXMLCEP(ajax2.responseXML);
                        } else
                        {
                            // caso n\u00E3o seja um arquivo XML emite a mensagem
                            // abaixo
                        }
                    }
                }

                // passa o parametro
                var params = "parametro=" + valor;
                ajax2.send(params);
            }
            // }
        } else
        {
            $("clecidade").value = "";
            $("cleuf").value = "";
            $("clecodcidade").value = "";
            $("cidcodigoibge").value = "";
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
            // cont\u00E9udo dos campos no arquivo XML
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

            $("cleendereco").value = descricao3;
            $("clebairro").value = descricao4;
            $("clecidade").value = descricao;
            $("cleuf").value = descricao2;

            $("clecodcidade").value = codigo;
            cep1 = $("clecep").value;

            // busca cidade ibge			
            dadospesquisaibge(descricao2, 0);
        }
    } else
    {
        // caso o XML volte vazio, printa a mensagem abaixo
        alert("O CEP n\u00E3o \u00E9 v\u00E1lido!");
        $("clecep").value = "";
        document.getElementById("clecep").focus();
    }
}

function pesquisacep2(valor)
{
    trimjs($("clccep").value);
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
                        alert("Esse browser n\u00E3o tem recursos para uso do Ajax");
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
                    // apÃ³s ser processado - chama funÃ§\u00E3o processXML que vai
                    // varrer os dados
                    if (ajax2.readyState == 4)
                    {
                        if (ajax2.responseXML)
                        {
                            processXMLCEP2(ajax2.responseXML);
                        } else
                        {
                            // caso n\u00E3o seja um arquivo XML emite a mensagem
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
            $("clccidade").value = "";
            $("clcuf").value = "";
            $("clccodcidade").value = "";
            $("cidcodigoibgecob").value = "";
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
            // cont\u00E9udo dos campos no arquivo XML
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

            $("clcendereco").value = descricao3;
            $("clcbairro").value = descricao4;
            $("clccidade").value = descricao;
            $("clcuf").value = descricao2;

            $("clccodcidade").value = codigo;
            cep2 = $("clccep").value;

            // busca cidade ibge cobranca
            dadospesquisaibgecob(descricao2);
        }
    } else
    {
        // caso o XML volte vazio, printa a mensagem abaixo
        alert("O CEP n\u00E3o \u00E9 v\u00E1lido!");
        document.getElementById("clccep").focus();
    }
}

function pesquisacep3(valor)
{
    trimjs($("ceecep").value);
    if (cep3 != txt)
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
                        alert("Esse browser n\u00E3o tem recursos para uso do Ajax");
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
                    // apÃ³s ser processado - chama funÃ§\u00E3o processXML que vai
                    // varrer os dados
                    if (ajax2.readyState == 4)
                    {
                        if (ajax2.responseXML)
                        {
                            processXMLCEP3(ajax2.responseXML);
                        } else
                        {
                            // caso n\u00E3o seja um arquivo XML emite a mensagem
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
            $("ceecidade").value = "";
            $("ceeuf").value = "";
            $("ceecodcidade").value = "";
        }
    }
}

function processXMLCEP3(obj)
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
            // cont\u00E9udo dos campos no arquivo XML
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

            $("ceeendereco").value = descricao3;
            $("ceebairro").value = descricao4;
            $("ceecidade").value = descricao;
            $("ceeuf").value = descricao2;
            $("ceecodcidade").value = codigo;
            cep3 = $("ceecep").value;
            dadospesquisaibgecee(descricao2);
        }
    } else
    {
        // caso o XML volte vazio, printa a mensagem abaixo
        alert("O CEP n\u00E3o \u00E9 v\u00E1lido!");
        document.getElementById("ceecep").focus();
    }
}

function pesquisacep4(valor)
{
    trimjs($("comcep").value);
    if (cep4 != txt)
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
                        alert("Esse browser n\u00E3o tem recursos para uso do Ajax");
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
                    // apÃ³s ser processado - chama funÃ§\u00E3o processXML que vai
                    // varrer os dados
                    if (ajax2.readyState == 4)
                    {
                        if (ajax2.responseXML)
                        {
                            processXMLCEP4(ajax2.responseXML);
                        } else
                        {
                            // caso n\u00E3o seja um arquivo XML emite a mensagem
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
            $("comcidade").value = "";
            $("comuf").value = "";
            $("comcodcidade").value = "";
        }
    }
}

function processXMLCEP4(obj)
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
            // cont\u00E9udo dos campos no arquivo XML
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

            $("comendereco").value = descricao3;
            $("combairro").value = descricao4;
            $("comcidade").value = descricao;
            $("comuf").value = descricao2;
            $("comcodcidade").value = codigo;
            cep4 = $("comcep").value;
        }
    } else
    {
        // caso o XML volte vazio, printa a mensagem abaixo
        alert("O CEP n\u00E3o \u00E9 v\u00E1lido!");
        document.getElementById("comcep").focus();
    }
}

function codigo_cliente(valor)
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
                alert("Esse browser n\u00E3o tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    // se tiver suporte ajax
    if (ajax2)
    {
        // deixa apenas o elemento 1 no option, os outros s\u00E3o excluÃ­dos
        ajax2.open("POST", "clientecodpesquisa.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax2.onreadystatechange = function ()
        {
            // enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
            }
            // apÃ³s ser processado - chama funÃ§\u00E3o processXML que vai varrer os
            // dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXMLcodcli(ajax2.responseXML);
                } else
                {
                    // caso n\u00E3o seja um arquivo XML emite a mensagem abaixo
                    // processXMLcodcli(ajax2.responseXML);
                }
            }
        }
        // passa o parametro
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLcodcli(obj)
{
    // pega a tag dado
    dataArray = obj.getElementsByTagName("dado");

    // total de elementos contidos na tag dado

    if (dataArray.length > 0)
    {
        // percorre o arquivo XML paara extrair os dados
        for (var i = 0; i < dataArray.length; i++)
        {
            item = dataArray[i];

            // cont\u00E9udo dos campos no arquivo XML
            codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            trimjs(codigo);
            if (txt == '1') {
                txt = '1000001';
            }
            ;
            odigo = txt;

            // if(i==0){
            $("clicod").value = codigo;
            // }
        }
    } else
    {
        // caso o XML volte vazio, printa a mensagem abaixo
        $("clicod").value = "1000001";
    }

    if ($("pesquisa").value)
    {
        dadospesquisa($('pesquisa').value);
    }
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
                alert("Esse browser n\u00E3o tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    // se tiver suporte ajax
    if (ajax2)
    {
        ajax2.open("POST", "clientepesquisaexiste.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax2.onreadystatechange = function ()
        {
            // enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
            }
            // apÃ³s ser processado - chama funÃ§\u00E3o processXML que vai varrer os
            // dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXMLclientepesquisa(ajax2.responseXML, valor);
                } else
                {
                    // caso n\u00E3o seja um arquivo XML emite a mensagem abaixo
                }
            }
        }
        // passa o parametro escolhido

        valor2 = document.getElementById("clicodigo").value;

        if (valor2 == '') {
            valor2 = '0';
        }
        ;

        var params = "parametro=" + valor + '&parametro2=' + valor2;

        ajax2.send(params);
    }
}

function processXMLclientepesquisa(obj, valor)
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
            // cont\u00E9udo dos campos no arquivo XML
            alert("O Codigo " + valor + " j\u00E1 est\u00E1 cadastrado!");
            document.getElementById("clicod").focus();
        }
    } else
    {
        // caso o XML volte vazio, printa a mensagem abaixo
    }
}

function verificapessoa(valor)
{
    if (document.getElementById("radiob1").checked == true)
    {
        $("clicnpj").disabled = false;
        $("cliie").disabled = false;
        $("clirg").value = "";
        $("clicpf").value = "";
        $("clirg").disabled = true;
        $("clicpf").disabled = true;
        $("clirg").setAttribute("style", "BACKGROUND-COLOR:#EBEBE4;COLOR:#660000;FONT-WEIGHT:bold;");
        $("clicpf").setAttribute("style", "BACKGROUND-COLOR:#EBEBE4;COLOR:#660000;FONT-WEIGHT:bold;");
        $("clicnpj").setAttribute("style", "BACKGROUND-COLOR:#d1b3ff;COLOR:#660000;FONT-WEIGHT:bold;");
        $("cliie").setAttribute("style", "BACKGROUND-COLOR:#d1b3ff;COLOR:#660000;FONT-WEIGHT:bold;");
        // $("clirg").setAttribute("disabled","true");
        // $("clicpf").disabled = true;
    } else
    {
        $("clicnpj").disabled = true;
        $("cliie").disabled = true;
        $("clicnpj").value = "";
        $("cliie").value = "";
        $("clirg").disabled = false;
        $("clicpf").disabled = false;
        $("clirg").setAttribute("style", "BACKGROUND-COLOR:#d1b3ff;COLOR:#660000;FONT-WEIGHT:bold;");
        $("clicpf").setAttribute("style", "BACKGROUND-COLOR:#d1b3ff;COLOR:#660000;FONT-WEIGHT:bold;");
        $("clicnpj").setAttribute("style", "BACKGROUND-COLOR:#EBEBE4;COLOR:#660000;FONT-WEIGHT:bold;");
        $("cliie").setAttribute("style", "BACKGROUND-COLOR:#EBEBE4;COLOR:#660000;FONT-WEIGHT:bold;");
    }
}

// JavaScript Document
/*******************************************************************************
 * #################################################################### Assunto =
 * ValidaÃ§\u00E3o de CPF e CNPJ Autor = Marcos Regis Data = 24/01/2006 Vers\u00E3o = 1.0
 * Compatibilidade = Todos os navegadores. Pode ser usado e distribuÃ­do desde
 * que esta linhas sejam mantidas
 * ====------------------------------------------------------------====
 *
 * Funcionamento = O script recebe como parÃ¢metro um objeto por isso deve ser
 * chamado da seguinte forma: E.: no evento onBlur de um campo texto <input
 * name="cpf_cnpj" type="text" size="40" maxlength="18" onBlur="validar(this);">
 * Ao deixar o campo o evento \u00E9 disparado e chama validar() com o argumento
 * "this" que representa o prÃ³prio objeto com todas as propriedades. A partir
 * daÃ­ a funÃ§\u00E3o validar() trata a entrada removendo tudo que n\u00E3o for caracter
 * num\u00E9rico e deixando apenas nÃºmeros, portanto valores escritos sÃ³ com nÃºmeros
 * ou com separadores como '.' ou mesmo espaÃ§os s\u00E3o aceitos ex.: 111222333/44,
 * 111.222.333-44, 111 222 333 44 ser\u00E3o tratadoc como 11122233344 (para CPFs) De
 * certa forma at\u00E9 mesmo valores como 111A222B333C44 ser\u00E1 aceito mas aconselho a
 * usar a funÃ§\u00E3o soNums() que encotra-se aqui mesmo para que o campo sÃ³ aceite
 * caracteres num\u00E9ricos. Para usar a funÃ§\u00E3o soNums() chame-a no evento
 * onKeyPress desta forma onKeyPress="return soNums(event);" ApÃ³s limpar o valor
 * verificamos seu tamanho que deve ser ou 11 ou 14 Se o tamanho n\u00E3o for aceito
 * a funÃ§\u00E3o retorna false e [opcional] mostra uma mensagem de erro. SugestÃµes e
 * coment\u00E1rios marcos_regis@hotmail.com
 * ####################################################################
 ******************************************************************************/

// a funÃ§\u00E3o principal de validaÃ§\u00E3o
function validar(obj)
{ // recebe um objeto
    var s = (obj.value).replace(/\D/g, '');
    var tam = (s).length; // removendo os caracteres n\u00E3o num\u00E9ricos
    if (tam == 0)
    {
        // validando o tamanho
        return true;
    }
    if (!(tam == 14 || tam == 18))
    {
        // validando o tamanho
        alert("'" + s + "' n\u00E3o \u00E9 um CNPJ v\u00E1lido!!"); // tamanho inv\u00E1lido
        obj.focus();
        return false;
    }

// se for CNPJ
    if (tam == 14 || tam == 18)
    {
        if (!validaCNPJ(s))
        { // chama a funÃ§\u00E3o que valida o CNPJ
            alert("'" + s + "' n\u00E3o \u00E9 um CNPJ v\u00E1lido!"); // se quiser mostrar o
            // erro
            obj.select();    // se quiser selecionar o campo enviado
            obj.focus();
            return false;
        }
        processacnpj(s);
        // alert("'"+s+"' \u00E9 um CNPJ v\u00E1lido!" ); // se quiser mostrar que validou
        maskCNPJ(s);    // se validou o CNPJ mascaramos corretamente
        return true;


    }
}
// fim da funcao validar()


function processacnpj(obj)
{
    var s = (obj).replace(/\D/g, '');

    // Valida o CNPJ apenas se pessoa Juridica
    if ($("radiob1").checked == true) {

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
                    alert("Esse browser n\u00E3o tem recursos para uso do Ajax");
                    ajax2 = null;
                }
            }
        }
        // se tiver suporte ajax
        if (ajax2)
        {
            // deixa apenas o elemento 1 no option, os outros s\u00E3o excluÃ­dos

            ajax2.open("POST", "clientepesquisacnpj.php", true);
            ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            ajax2.onreadystatechange = function ()
            {

                // apÃ³s ser processado - chama funÃ§\u00E3o processXML que vai varrer
                // os dados
                if (ajax2.readyState == 4)
                {
                    if (ajax2.responseXML)
                    {
                        $('botao').disabled = true;
                        processXMLcnpj(ajax2.responseXML, s);
                    } else
                    {

                        // processXMLcnpj(ajax2.responseXML,s);
                        // $("MsgResultado").innerHTML = "Processando...";
                        // window.setTimeout("enviar()", 1800);
                        $('botao').disabled = false;

                        return true;
                    }
                }
            }

            valor2 = document.getElementById("clicodigo").value;

            if (valor2 == '') {
                valor2 = '0';
            }
            ;


            var params = "parametro=" + s + '&parametro2=' + valor2;

            ajax2.send(params);
        }

    } else {
        $("MsgResultado").innerHTML = "Processando...";
        window.setTimeout("valida_form()", 1800);
//		window.setTimeout("enviar()", 1800);
    }

}


function processacpf(obj)
{
    var s = (obj).replace(/\D/g, '');

    // Valida o CPF apenas se pessoa Fisica
    if ($("radiob2").checked == true) {

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
                    alert("Esse browser n\u00E3o tem recursos para uso do Ajax");
                    ajax2 = null;
                }
            }
        }
        // se tiver suporte ajax
        if (ajax2)
        {
            // deixa apenas o elemento 1 no option, os outros s\u00E3o excluÃ­dos

            ajax2.open("POST", "clientepesquisacpf.php", true);
            ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            ajax2.onreadystatechange = function ()
            {

                // apÃ³s ser processado - chama funÃ§\u00E3o processXML que vai varrer
                // os dados
                if (ajax2.readyState == 4)
                {
                    if (ajax2.responseXML)
                    {
                        $('botao').disabled = true;
                        processXMLcpf(ajax2.responseXML, s);
                    } else
                    {
                        // processXMLcnpj(ajax2.responseXML,s);
                        // $("MsgResultado").innerHTML = "Processando...";
                        // window.setTimeout("enviar()", 1800);
                        $('botao').disabled = false;
                        return true;
                    }
                }
            }

            valor2 = document.getElementById("clicodigo").value;

            if (valor2 == '') {
                valor2 = '0';
            }
            ;


            var params = "parametro=" + s + '&parametro2=' + valor2;

            ajax2.send(params);
        }

    } else {
        $("MsgResultado").innerHTML = "Processando...";
        window.setTimeout("valida_form()", 1800);
    }

}


function processXMLcpf(obj, valor)
{
    // alert('aqui');
    // pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");
    // total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        // percorre o arquivo XML paara extrair os dados
        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;

            // cont\u00E9udo dos campos no arquivo XML
            if (i == 0)
            {
                alert("CPF " + valor + " j\u00E1 cadastrado para " + codigo + "!");
                $('clicpf').focus();
            }
        }
    }
}


function processXMLcnpj(obj, valor)
{
    // alert('aqui');
    // pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");
    // total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        // percorre o arquivo XML paara extrair os dados
        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;

            // cont\u00E9udo dos campos no arquivo XML
            if (i == 0)
            {
                alert("CNPJ  " + valor + " j\u00E1 cadastrado para " + codigo + "!");
                $('clicnpj').focus();

            }
        }
    }
}


// a funÃ§\u00E3o principal de validaÃ§\u00E3o
function validar2(obj)
{ // recebe um objeto
    var s = (obj.value).replace(/\D/g, '');
    var tam = (s).length; // removendo os caracteres n\u00E3o num\u00E9ricos
    if (tam == 0)
    {
        // validando o tamanho
        return true;
    }
    if (!(tam == 11 || tam == 14))
    {
        // validando o tamanho
        alert("'" + s + "' n\u00E3o \u00E9 um CPF v\u00E1lido!"); // tamanho inv\u00E1lido
        obj.select();
        obj.focus();
        return false;
    }

// se for CPF
    if (tam == 11 || tam == 14)
    {
        if (!validaCPF(s))
        { // chama a funÃ§\u00E3o que valida o CPF
            alert("'" + s + "' n\u00E3o \u00E9 um CPF v\u00E1lido!"); // se quiser mostrar o erro
            obj.select();  // se quiser selecionar o campo em quest\u00E3o
            obj.focus();
            return false;
        }
        if ($("acao").value == "alterar")
        {
            processacpf(s);
            // alert("'"+s+"' \u00E9 um CPF v\u00E1lido!" ); // se quiser mostrar que validou
            maskCPF(s);    // se validou o CPF mascaramos corretamente
            return true;
        }
    }
}


// fim da funcao validar()

// funÃ§\u00E3o que valida CPF
// O algorÃ­timo de validaÃ§\u00E3o de CPF \u00E9 baseado em c\u00E1lculos
// para o dÃ­gito verificador (os dois Ãºltimos)
// n\u00E3o entrarei em detalhes de como funciona
function validaCPF(s)
{
    var c = s.substr(0, 9);
    var dv = s.substr(9, 2);
    var d1 = 0;
    for (var i = 0; i < 9; i++)
    {
        d1 += c.charAt(i) * (10 - i);
    }
    if (d1 == 0)
        return false;
    d1 = 11 - (d1 % 11);
    if (d1 > 9)
        d1 = 0;
    if (dv.charAt(0) != d1)
    {
        return false;
    }
    d1 *= 2;
    for (var i = 0; i < 9; i++)
    {
        d1 += c.charAt(i) * (11 - i);
    }
    d1 = 11 - (d1 % 11);
    if (d1 > 9)
        d1 = 0;
    if (dv.charAt(1) != d1)
    {
        return false;
    }
    return true;
}

// FunÃ§\u00E3o que valida CNPJ
// O algorÃ­timo de validaÃ§\u00E3o de CNPJ \u00E9 baseado em c\u00E1lculos
// para o dÃ­gito verificador (os dois Ãºltimos)
// n\u00E3o entrarei em detalhes de como funciona
function validaCNPJ(CNPJ)
{
    var a = new Array();
    var b = new Number;
    var c = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    for (i = 0; i < 12; i++)
    {
        a[i] = CNPJ.charAt(i);
        b += a[i] * c[i + 1];
    }
    if ((x = b % 11) < 2) {
        a[12] = 0
    } else {
        a[12] = 11 - x
    }
    b = 0;
    for (y = 0; y < 13; y++)
    {
        b += (a[y] * c[y]);
    }
    if ((x = b % 11) < 2) {
        a[13] = 0;
    } else {
        a[13] = 11 - x;
    }
    if ((CNPJ.charAt(12) != a[12]) || (CNPJ.charAt(13) != a[13]))
    {
        return false;
    }
    return true;
}



// Fun??o que permite apenas teclas num?ricas, alfab?ticas
// Deve ser chamada no evento onKeyPress desta forma
// return (alfaNums(event));
function alfaNums(e)
{
    if (document.all) {
        var evt = event.keyCode;
    } else {
        var evt = e.charCode;
    }
    if (evt < 20 || (evt > 47 && evt < 58) || (evt > 64 && evt < 91) || (evt > 96 && evt < 123)) {
        return true;
    }
    return false;
}

// Fun??o que permite apenas teclas num?ricas, alfab?ticas e espa?o
// Deve ser chamada no evento onKeyPress desta forma
// return (alfaNumsEspaco(event));
function alfaNumsEspaco(e)
{
    if (document.all) {
        var evt = event.keyCode;
    } else {
        var evt = e.charCode;
    }
    if (evt < 20 || (evt > 47 && evt < 58) || (evt > 64 && evt < 91) || (evt > 96 && evt < 123) || evt == 32) {
        return true;
    }
    return false;
}

// FunÃ§\u00E3o que permite apenas teclas num\u00E9ricas
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

// funÃ§\u00E3o que mascara o CPF
function maskCPF(CPF)
{
    return CPF.substring(0, 3) + "." + CPF.substring(3, 6) + "." + CPF.substring(6, 9) + "-" + CPF.substring(9, 11);
}

// funÃ§\u00E3o que mascara o CNPJ

function maskCNPJ(CNPJ)
{
    return CNPJ.substring(0, 2) + "." + CNPJ.substring(2, 5) + "." + CNPJ.substring(5, 8) + "/" + CNPJ.substring(8, 12) + "-" + CNPJ.substring(12, 14);
}

function verificacobranca(valor)
{
    if (document.getElementById("radioc1").checked == true)
    {
        $("excluirend1").disabled = false;
        $("clccep").disabled = false;
        $("clcendereco").disabled = false;
        $("clcnumero").disabled = false;
        $("clccomplemento").disabled = false;
        $("clcbairro").disabled = false;
        $("clcfone").disabled = false;
        $("clcfone2").disabled = false;
        $("clcfone3").disabled = false;
        $("clcfax").disabled = false;
        $("clcemail").disabled = false;
        $("cccnome0").disabled = false;
        $("cccfone0").disabled = false;
        $("cccemail0").disabled = false;
        $("cccnome1").disabled = false;
        $("cccfone1").disabled = false;
        $("cccemail1").disabled = false;
// $("cccnome2").disabled = false;
// $("cccfone2").disabled = false;
// $("cccemail2").disabled = false;
// $("cccnome3").disabled = false;
// $("cccfone3").disabled = false;
// $("cccemail3").disabled = false;
    } else
    {
        $("excluirend1").disabled = true;
        $("clccep").disabled = true;
        $("clcendereco").disabled = true;
        $("clcnumero").disabled = true;
        $("clccomplemento").disabled = true;
        $("clcbairro").disabled = true;
        $("clcfone").disabled = true;
        $("clcfone2").disabled = true;
        $("clcfone3").disabled = true;
        $("clcfax").disabled = true;
        $("clcemail").disabled = true;
// $("cccnome0").disabled = true;
// $("cccfone0").disabled = true;
// $("cccemail0").disabled = true;
// $("cccnome1").disabled = true;
// $("cccfone1").disabled = true;
// $("cccemail1").disabled = true;
// $("cccnome2").disabled = true;
// $("cccfone2").disabled = true;
// $("cccemail2").disabled = true;
// $("cccnome3").disabled = true;
// $("cccfone3").disabled = true;
// $("cccemail3").disabled = true;
// $("clccep").value = "";
// $("clcendereco").value = "";
// $("clcnumero").value = "";
// $("clccomplemento").value = "";
// $("clcbairro").value = "";
// $("clccidade").value = "";
// $("clcuf").value = "";
// $("clcfone").value = "";
// $("clcfone2").value = "";
// $("clcfone3").value = "";
// $("clcfax").value = "";
// $("clcemail").value = "";
// $("cccnome0").value = "";
// $("cccfone0").value = "";
// $("cccemail0").value = "";
// $("cccnome1").value = "";
// $("cccfone1").value = "";
// $("cccemail1").value = "";
// $("cccnome2").value = "";
// $("cccfone2").value = "";
// $("cccemail2").value = "";
// $("cccnome3").value = "";
// $("cccfone3").value = "";
// $("cccemail3").value = "";
    }
}

function verificaentrega(valor)
{
    if (document.getElementById("radiod1").checked == true)
    {
        $("excluirend2").disabled = false;
        $("ceecep").disabled = false;
        $("ceeendereco").disabled = false;
        $("ceenumero").disabled = false;
        $("ceecomplemento").disabled = false;
        $("ceebairro").disabled = false;
        $("ceefone").disabled = false;
        $("ceefone2").disabled = false;
        $("ceefone3").disabled = false;
        $("ceefax").disabled = false;
        $("ceeemail").disabled = false;
        // $("ccenome0").disabled = false;
        // $("ccefone0").disabled = false;
        // $("cceemail0").disabled = false;
        // $("ccenome1").disabled = false;
        // $("ccefone1").disabled = false;
        // $("cceemail1").disabled = false;
        // $("ccenome2").disabled = false;
        // $("ccefone2").disabled = false;
        // $("cceemail2").disabled = false;
        // $("ccenome3").disabled = false;
        // $("ccefone3").disabled = false;
        // $("cceemail3").disabled = false;
    } else
    {
        $("excluirend2").disabled = true;
        $("ceecep").disabled = true;
        $("ceeendereco").disabled = true;
        $("ceenumero").disabled = true;
        $("ceecomplemento").disabled = true;
        $("ceebairro").disabled = true;
        $("ceefone").disabled = true;
        $("ceefone2").disabled = true;
        $("ceefone3").disabled = true;
        $("ceefax").disabled = true;
        $("ceeemail").disabled = true;
        // $("ccenome0").disabled = true;
        // $("ccefone0").disabled = true;
        // $("cceemail0").disabled = true;
        // $("ccenome1").disabled = true;
        // $("ccefone1").disabled = true;
        // $("cceemail1").disabled = true;
        // $("ccenome2").disabled = true;
        // $("ccefone2").disabled = true;
        // $("cceemail2").disabled = true;
        // $("ccenome3").disabled = true;
        // $("ccefone3").disabled = true;
        // $("cceemail3").disabled = true;
        // $("ceecep").value = "";
        // $("ceeendereco").value = "";
        // $("ceenumero").value = "";
        // $("ceecomplemento").value = "";
        // $("ceebairro").value = "";
        // $("ceecidade").value = "";
        // $("ceeuf").value = "";
        // $("ceefone").value = "";
        // $("ceefone2").value = "";
        // $("ceefone3").value = "";
        // $("ceefax").value = "";
        // $("ceeemail").value = "";
        // $("ccenome0").value = "";
        // $("ccefone0").value = "";
        // $("cceemail0").value = "";
        // $("ccenome1").value = "";
        // $("ccefone1").value = "";
        // $("cceemail1").value = "";
        // $("ccenome2").value = "";
        // $("ccefone2").value = "";
        // $("cceemail2").value = "";
// $("ccenome3").value = "";
// $("ccefone3").value = "";
// $("cceemail3").value = "";
    }
}

function verificacomplemento(valor)
{
    if (document.getElementById("radioec1").checked == true)
    {
        $("comcep").disabled = false;
        $("comendereco").disabled = false;
        $("comnumero").disabled = false;
        $("comcomplemento").disabled = false;
        $("combairro").disabled = false;
        $("comfone").disabled = false;
        $("comfone2").disabled = false;
        $("comfone3").disabled = false;
        $("comfax").disabled = false;
        $("comemail").disabled = false;
    } else
    {
        $("comcep").disabled = true;
        $("comendereco").disabled = true;
        $("comnumero").disabled = true;
        $("comcomplemento").disabled = true;
        $("combairro").disabled = true;
        $("comfone").disabled = true;
        $("comfone2").disabled = true;
        $("comfone3").disabled = true;
        $("comfax").disabled = true;
        $("comemail").disabled = true;

        $("comcep").value = "";
        $("comendereco").value = "";
        $("comnumero").value = "";
        $("comcomplemento").value = "";
        $("combairro").value = "";
        $("comcidade").value = "";
        $("comuf").value = "";
        $("comfone").value = "";
        $("comfone2").value = "";
        $("comfone3").value = "";
        $("comfax").value = "";
        $("comemail").value = "";
    }
}

function itemcombo3(valor)
{
    y = document.forms[0].listfpagto.options.length;
    for (var i = 0; i < y; i++)
    {
        document.forms[0].listfpagto.options[i].selected = true;
        var l = document.forms[0].listfpagto;
        // var li = l.options[l.selectedIndex].text;
        var li = l.options[l.selectedIndex].value;
        if (li == valor) {
            i = y;
        }

    }
}

function itemcombo4(valor)
{
    y = document.forms[0].listcanal.options.length;
    for (var i = 0; i < y; i++)
    {
        document.forms[0].listcanal.options[i].selected = true;
        var l = document.forms[0].listcanal;
        // var li = l.options[l.selectedIndex].text;
        var li = l.options[l.selectedIndex].value;
        if (li == valor) {
            i = y;
        }
    }
}

function pesquisav(valor)
{
    if (document.getElementById("opcao1").checked == true)
    {
        pesquisacodigoven(valor);

    } else
    {
        pesquisavendedores(valor);
    }
}

function pesquisav2(valor)
{
    pesquisavendedores(valor);
}

function pesquisacodigoven(valor)
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
                alert("Esse browser n\u00E3o tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    if (ajax2 && (valor != '' && valor != undefined && valor != null))
    {
        ajax2.open("POST", "vendedorpesquisacodigo.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax2.onreadystatechange = function ()
        {
            if (ajax2.readyState == 1) {
            }
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXMLcodigoven(ajax2.responseXML, valor);
                } else
                {
                    document.forms[0].pesquisavendedor.options.length = 0;
                }
            }
        }
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLcodigoven(obj, valor)
{


    var dataArray = obj.getElementsByTagName("dado");
    if (dataArray.length > 0)
    {
        document.forms[0].pesquisavendedor.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            var cod = item.getElementsByTagName("cod")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            $("vendedor").value = cod;
            document.getElementById("opcao1").checked = true;

//			pesquisav(cod);

            descricao = cod + ' ' + descricao;

            var novo = document.createElement("option");
            // atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes");
            // atribui um valor
            novo.value = cod;
            // atribui um texto
            novo.text = descricao;
            // finalmente adiciona o novo elemento
            document.forms[0].pesquisavendedor.options.add(novo);
        }
    } else
    {
        document.forms[0].pesquisavendedor.options.length = 0;
    }
}


function pesquisacodigovennew(valor)
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
                alert("Esse browser n\u00E3o tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    if (ajax2 && (valor != '' && valor != undefined && valor != null))
    {
        ajax2.open("POST", "vendedorpesquisacodigo.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax2.onreadystatechange = function ()
        {
            if (ajax2.readyState == 1) {
            }
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXMLcodigovennew(ajax2.responseXML, valor);
                } else
                {
                    document.forms[0].pesquisavendedor.options.length = 0;
                }
            }
        }
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLcodigovennew(obj, valor)
{


    var dataArray = obj.getElementsByTagName("dado");
    if (dataArray.length > 0)
    {
        document.forms[0].pesquisavendedor.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            var cod = item.getElementsByTagName("cod")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            $("vendedor").value = cod;
            document.getElementById("opcao1").checked = true;

//			pesquisav(cod);

            descricao = cod + ' ' + descricao;

            var novo = document.createElement("option");
            // atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes");
            // atribui um valor
            novo.value = cod;
            // atribui um texto
            novo.text = descricao;
            // finalmente adiciona o novo elemento
            document.forms[0].pesquisavendedor.options.add(novo);
        }
    } else
    {
        document.forms[0].pesquisavendedor.options.length = 0;
    }

    if (auxestado != '') {
        dadospesquisaibge(auxestado, auxcidade);
    }


}



function pesquisaVendedor(codigovendedor, vennguerra)
{

    document.forms[0].pesquisavendedor.options.length = 0;


    var cod = (codigovendedor == undefined) ? ' ' : codigovendedor;
    var descricao = (vennguerra == undefined) ? ' ' : vennguerra;
//alert("cod: "+cod+"\n vencodigo:"+codigovendedor);

    $("vendedor").value = cod;
    document.getElementById("opcao1").checked = true;
//			pesquisav(cod);

    descricao = cod + ' ' + descricao;

    var novo = document.createElement("option");
    // atribui um ID a esse elemento
    novo.setAttribute("id", "opcoes");
    // atribui um valor
    novo.value = cod;
    // atribui um texto
    novo.text = descricao;
    // finalmente adiciona o novo elemento
    document.forms[0].pesquisavendedor.options.add(novo);

}

function pesquisaCanalVenda(tipoPedido)
{

    document.forms[0].listcanal.options[document.forms[0].listcanal.length - 1] = null;
//		document.forms[0].pesquisavendedor.options.length = 0;

    var descricao = '';
    var codigo = '0';

    switch (tipoPedido) {
        case 'Z' :
            descricao = 'ALMOXARIFADO';
            break;
        case 'X' :
            descricao = 'BAIXA';
            break;
        case 'BF' :
            descricao = 'BALCAO FILIAL';
            break;
        case 'BM' :
            descricao = 'BALCAO MATRIZ';
            break;
        case 'F' :
            descricao = 'BONIFICACAO';
            break;
        case 'B' :
            descricao = 'BRINDE';
            break;
        case 'D' :
            descricao = 'DEVOLUCAO';
            break;
        case 'A' :
            descricao = 'DIRETORIA';
            break;
        case 'EP' :
            descricao = 'EMPENHO';
            break;
        case 'E' :
            descricao = 'EXTERNO';
            break;
        case 'ED' :
            descricao = 'EXTERNO SP';
            break;
        case 'EV' :
            descricao = 'EXTERNO VIX';
            break;
        case 'I' :
            descricao = 'INDUSTRIA';
            break;
        case 'Y' :
            descricao = 'INTERNET';
            break;
        case 'N' :
            descricao = 'INTERNO';
            break;
        case 'M' :
            descricao = 'MOSTRUARIO';
            break;
        case 'P' :
            descricao = 'PERDA';
            break;
        case 'R' :
            descricao = 'RESERVA';
            break;
        case 'T' :
            descricao = 'TELEMARKETING';
            break;
        case 'V' :
            descricao = 'VINTE E CINCO';
            break;

        default:
            descricao = '';
            break;
    }


    // cria um novo option dinamicamente
    var novo = document.createElement("option");
    // atribui um ID a esse elemento
    novo.setAttribute("id", "opcoes5");
    // atribui um valor
    novo.value = codigo;
    // atribui um texto
    novo.text = descricao;
    // finalmente adiciona o novo elemento
    document.forms[0].listcanal.options.add(novo);
//           document.forms[0].listcanal.options[2].selected = true;
    document.getElementById("opcoes5").selected = true;

}

function pesquisaLocalVenda(estoquePedido)
{

    document.forms[0].listlocal.options[document.forms[0].listlocal.length - 1] = null;
//		document.forms[0].pesquisavendedor.options.length = 0;

    var descricao = estoquePedido;
    var codigo = '0';

    // cria um novo option dinamicamente
    var novo = document.createElement("option");
    // atribui um ID a esse elemento
    novo.setAttribute("id", "opcoes6");
    // atribui um valor
    novo.value = codigo;
    // atribui um texto
    novo.text = descricao;
    // finalmente adiciona o novo elemento
    document.forms[0].listlocal.options.add(novo);
//           document.forms[0].listcanal.options[2].selected = true;
    document.getElementById("opcoes6").selected = true;

}




function pesquisavendedores(valor)
{
    if (valor != "")
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
                    alert("Esse browser n\u00E3o tem recursos para uso do Ajax");
                    ajax2 = null;
                }
            }
        }
        if (ajax2)
        {
            document.forms[0].pesquisavendedor.options.length = 1;

            ajax2.open("POST", "vendedorpesquisarazao.php", true);
            ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            ajax2.onreadystatechange = function ()
            {
                if (ajax2.readyState == 1)
                {
                    // idOpcao.innerHTML = "Carregando...!";
                }
                if (ajax2.readyState == 4)
                {
                    if (ajax2.responseXML)
                    {
                        processXMLvendedor(ajax2.responseXML, valor);
                    } else
                    {
                        document.forms[0].pesquisavendedor.options.length = 0;
                    }
                }
            }
            var params = "parametro=" + valor;
            ajax2.send(params);
        }
    } else
    {
        document.forms[0].pesquisavendedor.options.length = 0;
    }
}

function processXMLvendedor(obj, valor)
{
    var dataArray = obj.getElementsByTagName("dado");
    if (dataArray.length > 0)
    {
        document.forms[0].pesquisavendedor.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];

            var cod = item.getElementsByTagName("cod")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            descricao = cod + ' ' + descricao;

            var novo = document.createElement("option");
            // atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes");
            // atribui um valor
            novo.value = cod;
            // atribui um texto
            novo.text = descricao;
            // finalmente adiciona o novo elemento
            document.forms[0].pesquisavendedor.options.add(novo);

            if (i == 0)
            {
                $("vendedor").value = cod;
            }
        }
        if (dataArray.length == 1)
        {
            // document.forms[0].quant.focus();
        }
    } else
    {
        document.forms[0].pesquisavendedor.options.length = 0;
    }
}

function pesquisacodvend(valor)
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
                alert("Esse browser n\u00E3o tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    if (ajax2)
    {

        ajax2.open("POST", "vendedorpesquisacod2.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax2.onreadystatechange = function ()
        {
            if (ajax2.readyState == 1) {
            }
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXMLcodven(ajax2.responseXML, valor);
                } else {
                }
            }
        }
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLcodven(obj, valor)
{
    var dataArray = obj.getElementsByTagName("dado");
    if (dataArray.length > 0)
    {
        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            var cod = item.getElementsByTagName("cod")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            $("vendedor").value = cod;

            if (document.getElementById("opcao1").checked == true)
            {
                $("pesquisavend").value = cod;
            } else
            {
                $("pesquisavend").value = descricao;
            }
        }
    } else {
    }
}

function vales()
{
    window.open('consultavale.php?clicodigo=' + document.getElementById('clicodigo').value
            + '&clicod=' + document.getElementById('clicod').value
            , 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');
}

function dadospesquisaend(valor)
{
    // alert(valor+" end");
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
                alert("Esse browser n\u00E3o tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    // se tiver suporte ajax
    if (ajax2)
    {
        // deixa apenas o elemento 1 no option, os outros s\u00E3o excluÃ­dos
        document.forms[0].listDadosend.options.length = 1;

        var idOpcaoend = document.getElementById("opcoesend");

        ajax2.open("POST", "logradourostrapesquisa.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            // enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1)
            {
                idOpcaoend.innerHTML = "Carregando...!";
            }
            // apÃ³s ser processado - chama funÃ§\u00E3o processXML que vai varrer os
            // dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXMLend(ajax2.responseXML);
                } else
                {
                    // caso n\u00E3o seja um arquivo XML emite a mensagem abaixo
                    idOpcaoend.innerHTML = "_";
// idOpcaoend.innerHTML = "____________________";
                }
            }
        }
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLend(obj)
{
    // document.forms[0].listcidades.options.length = 0;
    // document.forms[0].listbairros.options.length = 0;
    var dataArray = obj.getElementsByTagName("dado");

    // total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        // percorre o arquivo XML paara extrair os dados
        document.forms[0].listDadosend.options.length = 0;
        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            // cont\u00E9udo dos campos no arquivo XML
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

            // idOpcao.innerHTML = "";

            // cria um novo option dinamicamente
            var novo = document.createElement("option");
            // atribui um ID a esse elemento
            novo.setAttribute("id", "opcoesend");
            // atribui um valor
            novo.value = codigo;
            // atribui um texto
            novo.text = descricao + ' - ' + descricao4 + ' - ' + uf;
            // finalmente adiciona o novo elemento
            document.forms[0].listDadosend.options.add(novo);

            document.forms[0].listDadosend.disabled = false;
            document.forms[0].listDadosend.focus();

            if (i == 0)
            {
                $("endcodigo").value = codigo;
                $("cleendereco").value = descricao;
                $("clebairro").value = descricao2;
                $("clecidade").value = descricao4;
                $("cleuf").value = uf;
                $("clecodcidade").value = descricao5;
                $("clecep").value = cep;
                cep1 = $("clecep").value;

                // busca cidade ibge
                dadospesquisaibge(uf, 0);
            }
        }
    } else
    {
        // caso o XML volte vazio, printa a mensagem abaixo
        // alert("endere\u00E7o n\u00E3o encontrado. Favor refaÃ§a sua busca!");
        // $("endcodigo").value="";
        // $("cleendereco").value="";
        // $("clebairro").value="";
        // $("clecidade").value="";
        // $("cleuf").value="";
        // $("clecodcidade").value="";
        // $("cidcodigoibge").value="";
        // $("clecep").value="";
        $('idOpcaoend').innerHTML = "_";
// $('idOpcaoend').innerHTML = "____________________";
    }
}


function dadospesquisaibge(valor, valor2x)
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
                alert("Esse browser n\u00E3o tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    // se tiver suporte ajax
    if (ajax2)
    {
        // deixa apenas o elemento 1 no option, os outros s\u00E3o excluÃ­dos
        document.forms[0].cidadeibge.options.length = 1;

        var idOpcaoendx = document.getElementById("cidcodigoibge");

        ajax2.open("POST", "cidadesibgenovo.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            // enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1)
            {
                idOpcaoendx.innerHTML = "Carregando...!";
            }
            // apÃ³s ser processado - chama funÃ§\u00E3o processXML que vai varrer os
            // dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXMLibge(ajax2.responseXML, valor2x);
                } else
                {
                    // caso n\u00E3o seja um arquivo XML emite a mensagem abaixo
                    $('cidadeibge').innerHTML = '<option id="cidcodigoibge" value="0">_</option>';
// $('cidadeibge').innerHTML = '<option id="cidcodigoibge"
// value="0">____________________________________</option>';
                }
            }
        }

        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLibge(obj, valor2x)
{

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
            // cont\u00E9udo dos campos no arquivo XML
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

            //if(valor2 == codigoib)
            //document.forms[0].cidadeibge.selected;

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



    if (valor2 != 0) {
        itemcomboibge(valor2x);
    }

}



function dadospesquisaibgecob(valor)
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
                alert("Esse browser n\u00E3o tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    // se tiver suporte ajax
    if (ajax2)
    {
        // deixa apenas o elemento 1 no option, os outros s\u00E3o excluÃ­dos
        document.forms[0].cidadeibgecob.options.length = 1;

        var idOpcaoendx = document.getElementById("cidcodigoibgecob");

        ajax2.open("POST", "cidadesibge.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            // enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1)
            {
                idOpcaoendx.innerHTML = "Carregando...!";
            }
            // apÃ³s ser processado - chama funÃ§\u00E3o processXML que vai varrer os
            // dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXMLibgecob(ajax2.responseXML);
                } else
                {
                    // caso n\u00E3o seja um arquivo XML emite a mensagem abaixo
                    $('cidadeibgecob').innerHTML = '<option id="cidcodigoibgecob" value="0">_</option>';
// $('cidadeibgecob').innerHTML = '<option id="cidcodigoibgecob"
// value="0">____________________________________</option>';
                }
            }
        }
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLibgecob(obj)
{
    // document.forms[0].listcidades.options.length = 0;
    // document.forms[0].listbairros.options.length = 0;
    var dataArray = obj.getElementsByTagName("dadoib");

    // total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        // percorre o arquivo XML paara extrair os dados
        document.forms[0].cidadeibgecob.options.length = 0;
        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            // cont\u00E9udo dos campos no arquivo XML
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
                novo.setAttribute("id", "cidcodigoibgecob");
                // atribui um valor
                novo.value = "0";
                // atribui um texto
                novo.text = "Escolha uma Cidade";
                // finalmente adiciona o novo elemento
                document.forms[0].cidadeibgecob.options.add(novo);
            }

            // cria um novo option dinamicamente
            var novo = document.createElement("option");

            // atribui um ID a esse elemento
            novo.setAttribute("id", "cidcodigoibgecob");
            // atribui um valor
            novo.value = codigoib;
            // atribui um texto
            novo.text = cidadeib;
            // finalmente adiciona o novo elemento
            document.forms[0].cidadeibgecob.options.add(novo);

            document.forms[0].cidadeibgecob.disabled = false;
            // if(ufibge == codigoib)
            // document.forms[0].cidadeibge.selected;
        }
        document.getElementById("cidcodigoibgecob").disabled = false;
    }
    // else
    // {
    // caso o XML volte vazio, printa a mensagem abaixo
    // var cidcodigoibge = document.getElementById("cidcodigoibge");
    // cidcodigoibge.innerHTML = "____________________";
    // document.getElementById("cidcodigoibge").disabled = true;
    // }
}

function dadospesquisaibgecee(valor)
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
                alert("Esse browser n\u00E3o tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    // se tiver suporte ajax
    if (ajax2)
    {
        // deixa apenas o elemento 1 no option, os outros s\u00E3o excluÃ­dos
        document.forms[0].cidadeibgecee.options.length = 1;

        var idOpcaoendx = document.getElementById("cidcodigoibgecee");

        ajax2.open("POST", "cidadesibge.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            // enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1)
            {
                idOpcaoendx.innerHTML = "Carregando...!";
            }
            // apÃ³s ser processado - chama funÃ§\u00E3o processXML que vai varrer os
            // dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXMLibgecee(ajax2.responseXML);
                } else
                {
                    // caso n\u00E3o seja um arquivo XML emite a mensagem abaixo
                    $('cidadeibgecee').innerHTML = '<option id="cidcodigoibgecee" value="0">_</option>';
// $('cidadeibgecee').innerHTML = '<option id="cidcodigoibgecee"
// value="0">____________________________________</option>';
                }
            }
        }
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLibgecee(obj)
{
    // document.forms[0].listcidades.options.length = 0;
    // document.forms[0].listbairros.options.length = 0;
    var dataArray = obj.getElementsByTagName("dadoib");

    // total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        // percorre o arquivo XML paara extrair os dados
        document.forms[0].cidadeibgecee.options.length = 0;
        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            // cont\u00E9udo dos campos no arquivo XML
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
                novo.setAttribute("id", "cidcodigoibgecee");
                // atribui um valor
                novo.value = "0";
                // atribui um texto
                novo.text = "Escolha uma Cidade";
                // finalmente adiciona o novo elemento
                document.forms[0].cidadeibgecob.options.add(novo);
            }

            // cria um novo option dinamicamente
            var novo = document.createElement("option");

            // atribui um ID a esse elemento
            novo.setAttribute("id", "cidcodigoibgecee");
            // atribui um valor
            novo.value = codigoib;
            // atribui um texto
            novo.text = cidadeib;
            // finalmente adiciona o novo elemento
            document.forms[0].cidadeibgecee.options.add(novo);

            document.forms[0].cidadeibgecee.disabled = false;
            // if(ufibge == codigoib)
            // document.forms[0].cidadeibge.selected;
        }
        document.getElementById("cidcodigoibgecee").disabled = false;
    }
    // else
    // {
    // caso o XML volte vazio, printa a mensagem abaixo
    // var cidcodigoibge = document.getElementById("cidcodigoibge");
    // cidcodigoibge.innerHTML = "____________________";
    // document.getElementById("cidcodigoibge").disabled = true;
    // }
}


function dadospesquisaend2(valor)
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
                alert("Esse browser n\u00E3o tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    // se tiver suporte ajax
    if (ajax2)
    {
        ajax2.open("POST", "logradourostrapesquisa2.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            // enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
            }
            // apÃ³s ser processado - chama funÃ§\u00E3o processXML que vai varrer os
            // dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXMLend2(ajax2.responseXML);
                } else
                {
                    // caso n\u00E3o seja um arquivo XML emite a mensagem abaixo
                }
            }
        }
        // passa o parametro escolhido
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLend2(obj)
{
    // document.forms[0].listcidades.options.length = 0;
    // document.forms[0].listbairros.options.length = 0;

    var dataArray = obj.getElementsByTagName("dado");

    // total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        // percorre o arquivo XML paara extrair os dados
        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            // cont\u00E9udo dos campos no arquivo XML

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
            $("cleendereco").value = descricao;
            $("clebairro").value = descricao2;
            $("clecidade").value = descricao4;
            $("cleuf").value = uf;
            $("clecodcidade").value = descricao5;
            $("clecep").value = cep;
            cep1 = $("clecep").value;

            // busca cidade ibge
            dadospesquisaibge(uf);
        }
    } else
    {
        // caso o XML volte vazio, printa a mensagem abaixo
        // $("endcodigo").value="";
        // $("cleendereco").value="";
        // $("clebairro").value="";
        // $("clecidade").value="";
        // $("cleuf").value="";
        // $("clecodcidade").value="";
        // $("clecep").value="";
        // $("cidcodigoibge").value="";
        $('idOpcaoend').innerHTML = "_";
// $('idOpcaoend').innerHTML = "____________________";
    }
}



function desativa()
{
    document.forms[0].listDadosend.disabled = true;
    document.forms[0].listDadosend.options.length = 1;
    document.getElementById("opcoesend").innerHTML = "_";
// document.getElementById("opcoesend").innerHTML = "____________________";
    $("cleendereco").focus();
}

function FormataValor(campo, teclapres) {
    var tammax = 10;
    var NomeForm = 'formulario';

    var tecla = teclapres.keyCode;
    vr = document.forms[NomeForm].elements[campo].value;
    vr = vr.replace("/", "");
    vr = vr.replace("/", "");
    vr = vr.replace(",", "");
    vr = vr.replace(".", "");
    vr = vr.replace(".", "");
    vr = vr.replace(".", "");
    vr = vr.replace(".", "");
    tam = vr.length;

    if (tam < tammax && tecla != 8) {
        tam = vr.length + 1;
    }

    if (tecla == 8) {
        tam = tam - 1;
    }

    if (tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105) {
        if (tam <= 2) {
            document.forms[NomeForm].elements[campo].value = vr;
        }
        if ((tam > 2) && (tam <= 5)) {
            document.forms[NomeForm].elements[campo].value = vr.substr(0, tam - 2) + '.' + vr.substr(tam - 2, tam);
        }
        if ((tam >= 6) && (tam <= 8)) {
            document.forms[NomeForm].elements[campo].value = vr.substr(0, tam - 5) + '' + vr.substr(tam - 5, 3) + '.' + vr.substr(tam - 2, tam);
        }
        if ((tam >= 9) && (tam <= 11)) {
            document.forms[NomeForm].elements[campo].value = vr.substr(0, tam - 8) + '' + vr.substr(tam - 8, 3) + '' + vr.substr(tam - 5, 3) + '.' + vr.substr(tam - 2, tam);
        }
        if ((tam >= 12) && (tam <= 15)) {
            document.forms[NomeForm].elements[campo].value = vr.substr(0, tam - 11) + '' + vr.substr(tam - 11, 3) + '' + vr.substr(tam - 8, 3) + '' + vr.substr(tam - 5, 3) + '.' + vr.substr(tam - 2, tam);
        }
    }
}

function SaltaCampo(campo, teclapres) {
    var NomeForm = 'formulario';
    var tecla = teclapres.keyCode;
    vr = document.forms[NomeForm].elements[campo].value;
    if (tecla == 109 || tecla == 188 || tecla == 110 || tecla == 111 || tecla == 223 || tecla == 108) {
        document.forms[NomeForm].elements[campo].value = vr.substr(0, vr.length - 1);
    } else {
        vr = vr.replace("-", "");
        vr = vr.replace("/", "");
        vr = vr.replace("/", "");
        vr = vr.replace(",", "");
        vr = vr.replace(",", "");
        vr = vr.replace(".", "");
        vr = vr.replace(".", "");
        vr = vr.replace(".", "");
        vr = vr.replace(".", "");
        tam = vr.length;
    }
}

function seleciona_ufibge()
{
    $('cidadeibge').value = ufibge;
    // document.getElementById("cidcodigoibge").value = ufibge;
}

function enderecoReceita()
{
    alert('Endereco' +
            '\n Rua: ' + receitaLogradouro +
            '\n Nº: ' + receitaNumero + ' Complemento: ' + receitaComplemento +
            '\n Bairro: ' + receitaBairro +
            '\n Cidade: ' + receitaCidade + ' - ' + receitaUf +
            '\n CEP: ' + receitaCep);
}


function enderecoSintegra()
{
    alert('Endereco' +
            '\n Rua: ' + sintegraLogradouro +
            '\n Nº: ' + sintegraNumero + ' Complemento: ' + sintegraComplemento +
            '\n Bairro: ' + sintegraBairro +
            '\n Cidade: ' + sintegraCidade + ' - ' + sintegraUf +
            '\n CEP: ' + sintegraCep);
}

function load_grid(clicodigo) {
    new ajax('clientesvinculados.php?pesquisa=' + clicodigo, {onLoading: carregando, onComplete: imprime});
}
function load_grid_grupo(clicodigo) {
    new ajax('grupovinculo.php?pesquisa=' + clicodigo, {onLoading: carregando, onComplete: imprime_grupo});
}

function carregando() {
 
}

function imprime(request) {

    var xmldoc = request.responseXML;
    var cabecalho;
    if (xmldoc != null)
    {
        cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];
        var campo = cabecalho.getElementsByTagName('campo');
        var tabela = "";
        var contador = 0;

        var vinculo = Array();

        var todos_elementos = document.getElementsByTagName('*');
        for (var i = 0; i < todos_elementos.length; i++) {
            var el = todos_elementos[i];
            if (el.className == 'vinculo') {

                el.className = 'vinculo1';
                // vinculo.push(el);
            }
        }
// for (var i=0; i<vinculo.length;i++){
// vinculo.style.backgroundColor = '#EEEEEE';
// }


        // $(".vinculo").css('background-color', '#FF6600');
// $("vinculo").style.background = '#EEEEEE';


        tabela = "<tr ><td>&nbsp;</td><td>&nbsp;</td><td><div align='left'><strong>Codigo</strong></div></td>" +
                "<td nowrap><div align='center'><strong>Cliente Vinculado</strong></div></td></tr>";


// var tabela="<table class='borda' bordercolor='#999999'><tr>"

//
//
// tabela+="<td colspan='1' class='borda' bgcolor='#3366CC'
// bordercolor='#3366CC'><b>Codigo</b></td>"
// tabela+="<td colspan='1' class='borda' bgcolor='#3366CC'
// bordercolor='#3366CC'><b>Cliente Vinculado</b></td>"
// tabela+="</tr>"


        // corpo da tabela
        var cor = "vinculo1";
        var registros = xmldoc.getElementsByTagName('registro');
        for (i = 0; i < registros.length; i++) {
            var itens = registros[i].getElementsByTagName('item');
// if(i%2==0)cor ="vinculo1";
// else cor = "vinculo2";

            tabela += "<tr id=linha" + i + ">"


            tabela += "<td >&nbsp;</td><td>&nbsp;</td><td><div align='left'>" + itens[1].firstChild.data + "</div></td>";
            tabela += "<td colspan='3' ><div align='center'>" + itens[2].firstChild.data + "</div></td>";
// tabela+="<td class='borda' >"+itens[1].firstChild.data+"</td>";
// tabela+="<td class='borda' >"+itens[2].firstChild.data+"</td>";

            tabela += "</tr>";
        }

        // tabela+="</table>"

        $("resultado").innerHTML = tabela;
        tabela = null;
    } else {
        $("resultado").innerHTML = "";
    }
}
function imprime_grupo(request) {


    var xmldoc = request.responseXML;
    var cabecalho;


    if (xmldoc != null) {
        cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];
        var campo = cabecalho.getElementsByTagName('campogrupovinculado');
        var tabela = "";
        var contador = 0;


        // imprime grupo que o cliente pertence
        var cor = "vinculo1";
        var registros = xmldoc.getElementsByTagName('registrogrupovinculado');
        for (i = 0; i < registros.length; i++) {
            var itens = registros[i].getElementsByTagName('itemgrupovinculado');

            tabela = itens[0].firstChild.data;

        }


        $("grupoVinculado").innerHTML = tabela;
        tabela = null;
    } else {
        $("grupoVinculado").innerHTML = "";
    }
}




function MM_openBrWindow(url, nomeJanela, caracteristicas) {
    window.open(url, nomeJanela, caracteristicas);
    return false;
}


function format(rnum, id) {

    rnum = rnum.replace(",", "");
    rnum = rnum.replace(".", "");

    var valor1 = Math.round(rnum * Math.pow(10, 0)) / Math.pow(10, 0);
    var valor2;

    if (valor1 >= 1) {

        valor1 = valor1 * 100;
        valor1 = Math.round(valor1);
        valor1 = valor1.toString();
        //valor2 = valor1.substring(0,valor1.length-2)+'.'+valor1.substring(valor1.length-2,valor1.length);
        valor2 = valor1.substring(0, valor1.length - 2);

        if (valor2 == '.0') {
            valor2 = '0'
        }
        if (valor2 == 'NaN') {
            valor2 = '0'
        }

    } else
    {
        //valor2 = (valor1.format(2, ".", ","));
        valor2 = 0;
    }

    $(id).value = valor2;



}

function itemcomboibge(valor)
{

    y = document.forms[0].cidadeibge.options.length;

    for (var i = 0; i < y; i++)
    {
        document.forms[0].cidadeibge.options[i].selected = true;
        var l = document.forms[0].cidadeibge;
        var li = l.options[l.selectedIndex].value;
        if (li == valor)
        {
            i = y;
        }
    }

    dadospesquisaregiao(valor);

}

function dadospesquisaregiao(valor)
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
                alert("Esse browser n\u00E3o tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }

    // se tiver suporte ajax
    if (ajax2)
    {
        ajax2.open("POST", "ibgepesquisaregiao.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            // enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {
            }
            // após ser processado - chama funç\u00E3o processXML que vai varrer os
            // dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXMLregiao(ajax2.responseXML);
                } else
                {
                    // caso n\u00E3o seja um arquivo XML emite a mensagem abaixo
                }
            }
        }
        // passa o parametro escolhido
        var params = "parametro=" + valor;
        ajax2.send(params);
    }


}

function processXMLregiao(obj)
{

    var dataArray = obj.getElementsByTagName("dado");

    // total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        // percorre o arquivo XML paara extrair os dados
        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            if (codigo == '_') {
                $("regiao").value = '';
            } else {
                $("regiao").value = codigo;
            }

        }
    }

}


function formata_data(obj)
{
    obj.value = obj.value.replace("//", "/");
    tam = obj.value;

    if (tam.length == 2 || tam.length == 5)
        obj.value = obj.value + "/";
}

function verificasuframa(valor)
{
    if (document.getElementById("opcaosuframa1").checked == true)
    {
        $("numerosuframa").disabled = false;
        $("radiosuframa1").disabled = false;
        $("radiosuframa2").disabled = false;
        $("radiosuframa3").disabled = false;
    } else
    {
        $("numerosuframa").value = "";
        $("numerosuframa").disabled = true;
        $("radiosuframa1").disabled = true;
        $("radiosuframa2").disabled = true;
        $("radiosuframa3").disabled = true;
        $("radiosuframa1").checked = false;
        $("radiosuframa2").checked = false;
        $("radiosuframa3").checked = false;
    }
}

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

function load_pedidos()
{
    let clicodigo = document.getElementById('clicodigo').value;

    if (clicodigo == '' || clicodigo == 0) {
        alert('Escolha o Cliente !');
    } else {
        new ajax('consultagerapedidoscliente.php?codigo=' + clicodigo, {onComplete: imprimelista});
    }
}

function imprimelista(request) {

    document.getElementById('resultadox').innerHTML = "";
    var xmldoc = request.responseXML;

    var dados = xmldoc.getElementsByTagName('dadoslista')[0];

    let resultado = "<div class='limiter'>"
    resultado += "<div class='container-table100'>"
    resultado += "<div class='wrap-table100'>"
    resultado += "<div class='table-max'>"
    resultado += "<div class='row-max header'>"
    resultado += "<div class='cell-max'>Pedido</div>"
    resultado += "<div class='cell-max'>Order</div>"
    resultado += "<div class='cell-max'>Data</div>"
    resultado += "<div class='cell-max'>Marktetplace</div>"
    resultado += "<div class='cell-max'>Valor</div>"
    resultado += "<div class='cell-max'>Frete</div>"
    resultado += "<div class='cell-max'>Total</div>"
    resultado += "</div>"
    if (dados != null)
    {
        var registros = xmldoc.getElementsByTagName('registrolista');
        
        let ultima = registros.length - 1;
        
        for (i = 0; i < registros.length; i++)
        {
            var itens = registros[i].getElementsByTagName('itemlista');

            if(i==ultima) {
                resultado += "<div class='row-max header'>"
            } else {
                resultado += "<div class='row-max'>"
            }
                
            if(i==ultima) {
                resultado += "<div class='cell-max' data-title='Pedido'>&nbsp;</div>"    
                resultado += "<div class='cell-max' data-title='Order'>&nbsp;</div>"    
                resultado += "<div class='cell-max' data-title='Data'>&nbsp;</div>"    
                resultado += "<div class='cell-max' data-title='Valor'>&nbsp;</div>"    
            } else {    
                /*
                if(itens[0].firstChild.data>0) {
                    let consultaPedidos = "<a href='pedvendaconsx.php?codped=" + itens[0].firstChild.data + "' style='text-decoration:none;' target=_blank>" + itens[0].firstChild.data + "</a>";                
                    resultado += "<div class='cell-max' data-title='Pedidos'>" + consultaPedidos + "</div>"
                } else {                
                    resultado += "<div class='cell-max' data-title='Pedido'>" + itens[0].firstChild.data + "</div>"    
                }
                 * 
                 */
                
                resultado += "<div class='cell-max' data-title='Pedido'>" + itens[0].firstChild.data + "</div>"  
                resultado += "<div class='cell-max' data-title='Order'>" + itens[1].firstChild.data + "</div>"    
                resultado += "<div class='cell-max' data-title='Data'>" + itens[2].firstChild.data + "</div>"    
                resultado += "<div class='cell-max' data-title='Valor'>" + itens[3].firstChild.data + "</div>"    
            }
            resultado += "<div class='cell-max' data-title='Frete'>" + itens[4].firstChild.data + "</div>"    
            resultado += "<div class='cell-max' data-title='Total'>" + itens[5].firstChild.data + "</div>"    
            resultado += "<div class='cell-max' data-title='Total'>" + itens[6].firstChild.data + "</div>"           
            resultado += "</div>"

        }
    }
    resultado += "</div>"
    resultado += "</div>"
    resultado += "</div>"
    resultado += "</div>"

    document.getElementById('resultadox').innerHTML = resultado;


}

function imprimelistaold(request)
{

    document.getElementById('resultadox').innerHTML = "";
    var xmldoc = request.responseXML;

    var dados = xmldoc.getElementsByTagName('dadoslista')[0];

    var tabela = "<table width='910' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' bgcolor='#CCCCCC'><tr>";

    if (dados != null)
    {
        tabela += "<td width=\"70\" align=\"center\" class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Pedido</b></font></td>";
        tabela += "<td width=\"280\" align=\"left\" class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Order</b></font></td>";
        tabela += "<td width=\"70\" align=\"center\" class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Data</b></font></td>";
        tabela += "<td width=\"220\" class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Market Place</b></font></td>";
        tabela += "<td width=\"90\" align=\"center\" class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Valor</b></font></td>";
        tabela += "<td width=\"90\" align=\"center\" class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Frete</b></font></td>";
        tabela += "<td width=\"90\" align=\"center\" class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Total</b></font></td></tr>";

        //corpo da tabela
        var registros = xmldoc.getElementsByTagName('registrolista');

        let ultimo = (registros.length - 1);

        for (i = 0; i < registros.length; i++)
        {

            var itens = registros[i].getElementsByTagName('itemlista');

            if (i != ultimo) {

                tabela += "<tr id=linha" + i + ">"
                //tabela += "<td align='center' class='borda'><a href='pedvendaconsx.php?codped=" + itens[0].firstChild.data + "' style='text-decoration:none;' target=_blank>" + itens[0].firstChild.data + "</a></td>";
                
                tabela += "<td align='left' class='borda'>" + itens[0].firstChild.data + "</td>";
                tabela += "<td align='left' class='borda'>" + itens[1].firstChild.data + "</td>";
                tabela += "<td align='center' class='borda'>" + itens[2].firstChild.data + "</td>";
                tabela += "<td align='left' class='borda'>" + itens[3].firstChild.data + "</td>";
                tabela += "<td align='right' class='borda'>" + itens[4].firstChild.data + "</td>";
                tabela += "<td align='right' class='borda'>" + itens[5].firstChild.data + "</td>";
                tabela += "<td align='right' class='borda'>" + itens[6].firstChild.data + "</td>";
                tabela += "</tr>";

            } else {

                tabela += "<tr>";
                tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC' colspan='4' align='right' valign='middle'><font color='#ffffff'><b>Total&nbsp;</b></td>";
                tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='right'><font color='#ffffff'><b>" + itens[4].firstChild.data + "</b></td>";
                tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='right'><font color='#ffffff'><b>" + itens[5].firstChild.data + "</b></td>";
                tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC' align='right'><font color='#ffffff'><b>" + itens[6].firstChild.data + "</b></td>";

                tabela += "</tr>";

            }

        }

        tabela += "</table><br>";
        document.getElementById('resultadox').innerHTML = tabela;
    } else
    {
        tabela += "<td width='100%'>&nbsp;</td>";
        tabela += "</tr>";
        tabela += "<table width='700' border='0' bgcolor='#FFFFFF'>";
        tabela += "<tr>";
        tabela += "<td width='100%' align='center'><font color='#000000'><b>Nenhum registro encontrado!!</b></font></td>";
        tabela += "</tr>";
        //tabela+="<tr><td width='100%' align='center'><a href=\"javascript:history.go(0);\"><font color='#000000'><b>&laquo; Voltar</b></font></td>";
        //tabela+="</tr>";
        tabela += "</table>";
        document.getElementById('resultadox').innerHTML = tabela;
    }
}

function load_ocorrencias()
{
    let clicodigo = document.getElementById('clicodigo').value;

    if (clicodigo == '' || clicodigo == 0) {
        alert('Escolha o Cliente !');
    } else {
        new ajax('consultageraocorrenciascliente.php?codigo=' + clicodigo, {onComplete: imprimelistaoc});
    }
}

function imprimelistaoc(request) {

    document.getElementById('resultadox').innerHTML = "";
    var xmldoc = request.responseXML;

    var dados = xmldoc.getElementsByTagName('dadoslista')[0];

    let resultado = "<div class='limiter'>"
    resultado += "<div class='container-table100'>"
    resultado += "<div class='wrap-table100'>"
    resultado += "<div class='table-max'>"
    resultado += "<div class='row-max header'>"
    resultado += "<div class='cell-max'>Numero</div>"
    resultado += "<div class='cell-max'>Departamento</div>"
    resultado += "<div class='cell-max'>Data</div>"
    resultado += "<div class='cell-max'>Situa��o</div>"
    resultado += "<div class='cell-max'>Respostas</div>"
    resultado += "<div class='cell-max'>Pedido</div>"
    resultado += "<div class='cell-max'>Ocorrencia</div>"
    resultado += "</div>"
    if (dados != null)
    {
        var registros = xmldoc.getElementsByTagName('registrolista');
        
        let ultima = registros.length - 1;
        
        for (i = 0; i < registros.length; i++)
        {
            var itens = registros[i].getElementsByTagName('itemlista');

           
            resultado += "<div class='row-max'>"           
         
                
            if(itens[0].firstChild.data>0) {
                let consultaPedidos = "<a href='consultarinteracao.php?pvnumero=" + itens[0].firstChild.data + "' style='text-decoration:none;' target=_blank>" + itens[0].firstChild.data + "</a>";                
                resultado += "<div class='cell-max' data-title='Numero'>" + consultaPedidos + "</div>"
            } else {                
                resultado += "<div class='cell-max' data-title='Numero'>" + itens[0].firstChild.data + "</div>"    
            }

            resultado += "<div class='cell-max' data-title='Departamento'>" + itens[1].firstChild.data + "</div>"    
            resultado += "<div class='cell-max' data-title='Data'>" + itens[2].firstChild.data + "</div>"    
            resultado += "<div class='cell-max' data-title='Situa��o'>" + itens[3].firstChild.data + "</div>"    
            
            resultado += "<div class='cell-max' data-title='Respostas'>" + itens[4].firstChild.data + "</div>"    
            
            /*
            if(itens[5].firstChild.data>0) {
                let consultaPedidos = "<a href='pedvendaconsx.php?codped=" + itens[5].firstChild.data + "' style='text-decoration:none;' target=_blank>" + itens[5].firstChild.data + "</a>";                
                resultado += "<div class='cell-max' data-title='Pedidos'>" + consultaPedidos + "</div>"
            } else {                
                resultado += "<div class='cell-max' data-title='Pedido'>" + itens[5].firstChild.data + "</div>"    
            }
             * 
             */
            
            resultado += "<div class='cell-max' data-title='Pedido'>" + itens[5].firstChild.data + "</div>"    
            
            resultado += "<div class='cell-max' data-title='Ocorrencia'>" + itens[6].firstChild.data + "</div>"           
            resultado += "</div>"

        }
    }
    resultado += "</div>"
    resultado += "</div>"
    resultado += "</div>"
    resultado += "</div>"

    document.getElementById('resultadox').innerHTML = resultado;


}

function imprimelistaocold(request)
{

    document.getElementById('resultadox').innerHTML = "";
    var xmldoc = request.responseXML;

    var dados = xmldoc.getElementsByTagName('dadoslista')[0];

    var tabela = "<table width='910' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' bgcolor='#CCCCCC'><tr>";

    if (dados != null)
    {
        tabela += "<td width=\"60\" align=\"center\" class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Numero</b></font></td>";
        tabela += "<td width=\"120\" align=\"left\" class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Departamento</b></font></td>";
        tabela += "<td width=\"70\" align=\"center\" class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Data</b></font></td>";
        tabela += "<td width=\"90\" class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Situa��o</b></font></td>";
        tabela += "<td width=\"70\" align=\"center\" class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Respostas</b></font></td>";
        tabela += "<td width=\"70\" align=\"center\" class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Pedido</b></font></td>";
        tabela += "<td width=\"430\" align=\"left\" class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Ocorr�ncia</b></font></td></tr>";

        //corpo da tabela
        var registros = xmldoc.getElementsByTagName('registrolista');


        for (i = 0; i < registros.length; i++)
        {

            var itens = registros[i].getElementsByTagName('itemlista');



            tabela += "<tr id=linha" + i + ">"
            tabela += "<td align='center' class='borda'><a href='consultarinteracao.php?pvnumero=" + itens[0].firstChild.data + "' style='text-decoration:none;' target=_blank>" + itens[0].firstChild.data + "</a></td>";
            tabela += "<td align='left' class='borda'>" + itens[1].firstChild.data + "</td>";
            tabela += "<td align='center' class='borda'>" + itens[2].firstChild.data + "</td>";
            tabela += "<td align='left' class='borda'>" + itens[3].firstChild.data + "</td>";
            tabela += "<td align='right' class='borda'>" + itens[4].firstChild.data + "</td>";
            //tabela += "<td align='center' class='borda'><a href='pedvendaconsx.php?codped=" + itens[5].firstChild.data + "' style='text-decoration:none;' target=_blank>" + itens[5].firstChild.data + "</a></td>";            
            tabela += "<td align='left' class='borda'>" + itens[5].firstChild.data + "</td>";
            tabela += "<td align='left' class='borda'>" + itens[6].firstChild.data + "</td>";
            tabela += "</tr>";



        }

        tabela += "</table><br>";
        document.getElementById('resultadox').innerHTML = tabela;
    } else
    {
        tabela += "<td width='100%'>&nbsp;</td>";
        tabela += "</tr>";
        tabela += "<table width='700' border='0' bgcolor='#FFFFFF'>";
        tabela += "<tr>";
        tabela += "<td width='100%' align='center'><font color='#000000'><b>Nenhum registro encontrado!!</b></font></td>";
        tabela += "</tr>";
        //tabela+="<tr><td width='100%' align='center'><a href=\"javascript:history.go(0);\"><font color='#000000'><b>&laquo; Voltar</b></font></td>";
        //tabela+="</tr>";
        tabela += "</table>";
        document.getElementById('resultadox').innerHTML = tabela;
    }
}