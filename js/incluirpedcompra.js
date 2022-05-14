
var vdesc1 = 0;
var vdesc2 = 0;
var vdesc3 = 0;
var vdesc4 = 0;
var vdesc5 = 0;
var vdesc6 = 0;
var vipi = 0;
var vicm = 0;
var max_novo = 0;


var vet = new Array(700);

for (var i = 0; i < 700; i++) {
    vet[i] = new Array(12);
}

for (var i = 0; i < 700; i++) {
    vet[i][0] = 0;
    vet[i][1] = 0;
    vet[i][2] = 0;
    vet[i][3] = 0;
    vet[i][4] = 0;
    vet[i][5] = 0;
    vet[i][6] = 0;
    vet[i][7] = 0;
    vet[i][8] = 0;
    vet[i][9] = 0;
    vet[i][10] = 0;
    vet[i][11] = 0;
}


nextfield = "pcnumero"; // nome do primeiro campo do site
netscape = "";

ver1 = navigator.appVersion;
len = ver1.length;
for (iln = 0; iln < len; iln++)
    if (ver1.charAt(iln) == "(")
        break;
netscape = (ver1.charAt(iln + 1).toUpperCase() != "C");

var verx = 0;

function keyDown(DnEvents) {
    // ve quando e o netscape ou IE

    if (netscape == true) {
        verx++;
        if (verx == 2) {
            verx = 0;
            return;
        }
    }

    k = (netscape) ? DnEvents.which : window.event.keyCode;
    if (k == 13) { // preciona tecla enter


        if (nextfield == 'opcao') {
            if (document.getElementById("opcao1").checked == true) {
                nextfield = 'opcao1';
            } else if (document.getElementById("opcao2").checked == true) {
                nextfield = 'opcao2';
            } else
            {
                nextfield = 'opcao3';
            }
        }


        if (nextfield == 'radio') {
            if (document.getElementById("radio1").checked == true) {
                nextfield = 'radio1';
            } else
            {
                nextfield = 'radio2';
            }
        }

        if (nextfield == 'radioa') {
            if (document.getElementById("radioa1").checked == true) {
                nextfield = 'radioa1';
            } else if (document.getElementById("radioa2").checked == true) {
                nextfield = 'radioa2';
            } else if (document.getElementById("radioa3").checked == true) {
                nextfield = 'radioa3';
            } else if (document.getElementById("radioa4").checked == true) {
                nextfield = 'radioa4';
            } else
            {
                nextfield = 'radioa5';
            }
        }
        if (nextfield == 'radiob') {
            if (document.getElementById("radiob1").checked == true) {
                nextfield = 'radiob1';
            } else if (document.getElementById("radiob2").checked == true) {
                nextfield = 'radiob2';
            } else
            {
                nextfield = 'radiob3';
            }
        }


        if (nextfield == 'radiodp') {
            if (document.getElementById("radiodp1").checked == true) {
                nextfield = 'radiodp1';
            } else {
                nextfield = 'radiodp2';
            }
        }


        if (nextfield == 'vendax') {
            if (document.getElementById("venda").disabled == false) {
                nextfield = 'venda';
            } else
            {
                nextfield = 'observacao1';
            }
        }
        /*
         if(nextfield=='pvtipo'){
         if( document.getElementById("pvtipo1").checked==true){
         nextfield='pvtipo1';
         }
         else
         {
         nextfield='pvtipo2';
         }
         }						
         if(nextfield=='dia01'){
         if( document.getElementById("dia1").disabled==false){ 
         nextfield='dia1';
         }
         elsef( document.getElementById("parc1").disabled==false)
         {
         nextfield='parc1';
         }
         }						
         */


        if (nextfield == 'done') {
            //alert("viu como funciona?");
            return false;
            //return true; // envia quando termina os campos
        } else {


            // se existem mais campos vai para o proximo
            eval('document.formulario.' + nextfield + '.focus()');
            return false;
        }
    }
}

document.onkeydown = keyDown; // work together to analyze keystrokes
if (netscape)
    document.captureEvents(Event.KEYDOWN | Event.KEYUP);









function limpa_form(valor, valor2, valor3) {

    max_novo = valor3;

    if (valor != 0) {

//tipo 1 aparece o saldo

        if (confirm("Deseja Imprimir?\n\t")) {
            window.open('pedcompraconsimppdf2.php?pcnumero=' + valor +
                    '&tipo=1'
                    , '_blank');

            if (valor2 == 1) {
                alert('Foi incluido o pedido numero ' + valor + ' !');
            }

            limpa_form(0, 0, max_novo);
        } else
        {

            if (valor2 == 1) {
                alert('Foi incluido o pedido numero ' + valor + ' !');
            }

            limpa_form(0, 0, max_novo);
        }

    } else
    {
//Limpar
        document.forms[0].codigo.value = '';
        document.forms[0].pcentrega.value = '';
        document.forms[0].pcchegada.value = '';
        document.forms[0].pcemissao.value = '';

        document.forms[0].codigofornecedor.value = '';
        document.forms[0].fornecedor.value = '';
        document.forms[0].pesquisafornecedor.options.length = 0;

        document.forms[0].radio1.checked = true;
        document.forms[0].comprador.value = '';
        document.forms[0].pcprocesso.value = '';
        document.forms[0].pccontainer.value = '';
        document.forms[0].comissao.value = '';
        document.forms[0].condicao.value = '';
        if (max_novo == 1) {
            document.forms[0].radioa3.checked = true;
        } else {
            document.forms[0].radioa5.checked = true;
        }

        document.forms[0].radiob1.checked = true;

        document.forms[0].observacao1.value = '';
        document.forms[0].observacao2.value = '';
        document.forms[0].observacao3.value = '';

        document.forms[0].observacao4.value = '';
        document.forms[0].observacao5.value = '';

        document.getElementById("radiodp2").checked = true;

        document.forms[0].codigoproduto.value = '';
        document.forms[0].produto.value = '';
        document.forms[0].pesquisaproduto.options.length = 0;

        document.forms[0].percdesc.value = '';
        document.forms[0].pcdesconto.value = '';

        document.forms[0].pctotal.value = '';
        document.forms[0].pctotal2.value = '';

        document.forms[0].quantidade.value = '';

        $("acao").value = "inserir";
        $("botao").value = "Incluir";

        $("importaPedido").disabled = false;

        $("pcnumero").value = "";

        $("resultado").innerHTML = "";

        for (var i = 0; i < 700; i++) {
            vet[i][0] = 0;
            vet[i][1] = 0;
            vet[i][2] = 0;
            vet[i][3] = 0;
            vet[i][4] = 0;
            vet[i][5] = 0;
            vet[i][6] = 0;
            vet[i][7] = 0;
            vet[i][8] = 0;
            vet[i][9] = 0;
            vet[i][10] = 0;
            vet[i][11] = 0;
        }

        $("pvparcelas").value = "";

        $("parc1").value = "";
        $("parc2").value = "";
        $("parc3").value = "";
        $("parc4").value = "";
        $("parc5").value = "";
        $("parc6").value = "";

        $("dia1").value = "";
        $("dia2").value = "";
        $("dia3").value = "";
        $("dia4").value = "";
        $("dia5").value = "";
        $("dia6").value = "";

        $("pvdata1").value = "";
        $("pvdata2").value = "";
        $("pvdata3").value = "";
        $("pvdata4").value = "";
        $("pvdata5").value = "";
        $("pvdata6").value = "";


        $("parc1").disabled = true;
        $("parc2").disabled = true;
        $("parc3").disabled = true;
        $("parc4").disabled = true;
        $("parc5").disabled = true;
        $("parc6").disabled = true;

        $("dia1").disabled = true;
        $("dia2").disabled = true;
        $("dia3").disabled = true;
        $("dia4").disabled = true;
        $("dia5").disabled = true;
        $("dia6").disabled = true;

        $("pvdata1").disabled = true;
        $("pvdata2").disabled = true;
        $("pvdata3").disabled = true;
        $("pvdata4").disabled = true;
        $("pvdata5").disabled = true;
        $("pvdata6").disabled = true;

        document.forms[0].pvtipo1.checked = true;

        document.forms[0].radiob1.checked = true;

        document.getElementById("venda").value = '';
        document.getElementById("venda").disabled = true;


        data = new Date();
        ano = data.getFullYear();
        mes = data.getMonth() + 1;
        dia = data.getDate();

        if (mes < 10) {
            mes = '0' + mes;
        }
        if (dia < 10) {
            dia = '0' + dia;
        }

        $("pcemissao").value = dia + '/' + mes + '/' + ano;



        tipodata(1);

        max();

    }


}


function valida_form() {

    trimjs(document.getElementById('pcemissao').value);
    if (txt == '') {
        alert('Digite a data de emissao!');
        return;
    }

    if (valida_data('pcemissao') == false) {
        return;
    }
    ;

    trimjs(document.getElementById('pcentrega').value);
    if (txt == '') {
        alert('Digite a data de entrega!');
        return;
    }

    if (valida_data('pcentrega') == false) {
        return;
    }
    ;

    //Data da Chegada pode ficar em branco
    trimjs(document.getElementById('pcchegada').value);
    if (txt != '') {
        if (valida_data('pcchegada') == false) {
            //alert('Data de Chegada Inválida!');
            return;
        }
    }

    trimjs(document.forms[0].pesquisafornecedor.value);
    if (txt == '') {
        alert('Selecione o fornecedor!');
        return;
    }

    trimjs(document.getElementById('comissao').value);
    if (txt == '') {
        document.getElementById('comissao').value = 0;
    }

    trimjs(document.getElementById('percdesc').value);
    if (txt == '') {
        document.getElementById('percdesc').value = 0;
    }

    trimjs(document.getElementById('pcdesconto').value);
    if (txt == '') {
        document.getElementById('pcdesconto').value = 0;
    }

    trimjs(document.getElementById('pctotal').value);
    if (txt == '') {
        document.getElementById('pctotal').value = 0;
    }


    for (var i = 0; i < 700; i++) {
        if (vet[i][0] != 0) {

            var campo = cod = 'h' + i;
            if (valida_data(campo) == false) {
                return;
            }
            ;


        }
    }


    parc1 = parseFloat(0 + document.getElementById('parc1').value);
    parc2 = parseFloat(0 + document.getElementById('parc2').value);
    parc3 = parseFloat(0 + document.getElementById('parc3').value);
    parc4 = parseFloat(0 + document.getElementById('parc4').value);
    parc5 = parseFloat(0 + document.getElementById('parc5').value);
    parc6 = parseFloat(0 + document.getElementById('parc6').value);

    parctotal = (parc1 + parc2 + parc3 + parc4 + parc5 + parc6);
    parctotal = (parctotal.toFixed(2));

    pvvalor = parseFloat(0 + document.getElementById('pctotal2').value);
    pvvalor = (pvvalor.toFixed(2));


    if (parctotal != pvvalor) {
        alert('Verifique os valores!');
        return;
    } else
    {




        if (document.getElementById("pvtipo2").checked == true) {

            parc = document.getElementById("pvparcelas").value;

            if (parc >= 1) {
                x = validar_data(document.getElementById('pvdata1').value);
                if (x == false) {
                    alert('Data Inválida !');
                    document.getElementById("pvdata1").focus();
                    return;
                }
            }
            if (parc >= 2) {
                x = validar_data(document.getElementById('pvdata2').value);
                if (x == false) {
                    alert('Data Inválida !');
                    document.getElementById("pvdata2").focus();
                    return;
                }
            }
            if (parc >= 3) {
                x = validar_data(document.getElementById('pvdata3').value);
                if (x == false) {
                    alert('Data Inválida !');
                    document.getElementById("pvdata3").focus();
                    return;
                }
            }
            if (parc >= 4) {
                x = validar_data(document.getElementById('pvdata4').value);
                if (x == false) {
                    alert('Data Inválida !');
                    document.getElementById("pvdata4").focus();
                    return;
                }
            }
            if (parc >= 5) {
                x = validar_data(document.getElementById('pvdata5').value);
                if (x == false) {
                    alert('Data Inválida !');
                    document.getElementById("pvdata5").focus();
                    return;
                }
            }
            if (parc >= 6) {
                x = validar_data(document.getElementById('pvdata6').value);
                if (x == false) {
                    alert('Data Inválida !');
                    document.getElementById("pvdata6").focus();
                    return;
                }
            }

        } else
        {

            x = validar_data(document.getElementById('pvdata1').value);
            if (x == false) {
                document.getElementById('pvdata1').value = '01/01/2001';
            }
            x = validar_data(document.getElementById('pvdata2').value);
            if (x == false) {
                document.getElementById('pvdata2').value = '01/01/2001';
            }
            x = validar_data(document.getElementById('pvdata3').value);
            if (x == false) {
                document.getElementById('pvdata3').value = '01/01/2001';
            }
            x = validar_data(document.getElementById('pvdata4').value);
            if (x == false) {
                document.getElementById('pvdata4').value = '01/01/2001';
            }
            x = validar_data(document.getElementById('pvdata5').value);
            if (x == false) {
                document.getElementById('pvdata5').value = '01/01/2001';
            }
            x = validar_data(document.getElementById('pvdata6').value);
            if (x == false) {
                document.getElementById('pvdata6').value = '01/01/2001';
            }

        }


    }

    enviar(0);
}


function enviar(opc) {

    document.getElementById('botao').disabled = true;
    document.getElementById('botao2').disabled = true;
    document.getElementById('importaPedido').disabled = true;
    
    let titulo = "PROCESSANDO, AGUARDE...";
    let mensagem = "GRAVANDO AS INFORMACOES NA BASE DE DADOS!";

    $a("#retorno").messageBoxModal(titulo, mensagem);

    if (document.getElementById("pvtipo1").checked == true) {
        tipoparcelas = '1'
    } else {
        tipoparcelas = '2'
    }

    //valor = document.getElementById('clinguerra').value;
    if (document.getElementById("radio1").checked == true) {
        radio = 1;
    } else {
        radio = 2;
    }


    if (document.getElementById("radioa1").checked == true) {
        radioa = '1';
    } else if (document.getElementById("radioa2").checked == true) {
        radioa = '2';
    } else if (document.getElementById("radioa3").checked == true) {
        radioa = '3';
    } else if (document.getElementById("radioa4").checked == true) {
        radioa = '4';
    } else if (document.getElementById("radioa5").checked == true) {
        radioa = '5';
    } else {
        radioa = '6';
    }


    if (document.getElementById("radiob1").checked == true) {
        radiob = '1';
    } else if (document.getElementById("radiob2").checked == true) {
        radiob = '2';
    } else {
        radiob = '3';
    }


    var campovet1 = ""
    var campovet2 = ""
    var campovet3 = ""
    var campovet4 = ""
    var campovet5 = ""
    var campovet6 = ""
    var campovet7 = ""
    var campovet8 = ""
    var campovet9 = ""
    var campovet10 = ""

    var total;
    var totalitem;

    total = 0;
    totalitem = 0;

    for (var i = 0; i < 700; i++) {
        if (vet[i][0] != 0) {
            campovet1 = campovet1 + '&a[]=' + vet[i][0];
            campovet2 = campovet2 + '&b[]=0';
            campovet3 = campovet3 + '&c[]=' + vet[i][2];
            campovet4 = campovet4 + '&d[]=' + vet[i][3];
            campovet5 = campovet5 + '&e[]=' + vet[i][4];
            campovet6 = campovet6 + '&f[]=' + vet[i][5];
            campovet7 = campovet7 + '&g[]=' + vet[i][6];
            campovet8 = campovet8 + '&h[]=' + vet[i][7];
            campovet9 = campovet9 + '&i[]=' + vet[i][8];
            campovet10 = campovet10 + '&j[]=' + vet[i][9];



            totalitem = vet[i][2] * vet[i][3];

            total = total + totalitem;		//total dos itens sem os descontos e ipi do item

        }
    }


    total = document.getElementById('pctotal').value;   //total em tela


    if ($("acao").value == "inserir") {

        ajax2.open("POST", "pedcomprainsere.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax2.onreadystatechange = function () {

            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {

            }
            //após ser processado 
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML) {
                    processXMLinclui(ajax2.responseXML);
                }
            }
        }
        var params = 'pcnumero=' + document.getElementById('pcnumero').value
                + '&pcentrega=' + document.getElementById('pcentrega').value
                + '&pcemissao=' + document.getElementById('pcemissao').value
                + '&pcchegada=' + document.getElementById('pcchegada').value
                + '&codigofornecedor=' + document.forms[0].pesquisafornecedor.value

                + '&comprador=' + document.getElementById('comprador').value
                + '&pcprocesso=' + document.getElementById('pcprocesso').value
                + '&pccontainer=' + document.getElementById('pccontainer').value
                + '&comissao=' + document.getElementById('comissao').value
                + '&condicao=' + document.getElementById('condicao').value

                + '&observacao1=' + document.getElementById('observacao1').value
                + '&observacao2=' + document.getElementById('observacao2').value
                + '&observacao3=' + document.getElementById('observacao3').value

                + '&observacao4=' + document.getElementById('observacao4').value
                + '&observacao5=' + document.getElementById('observacao5').value

                + '&percdesc=' + document.getElementById('percdesc').value
                + '&pcdesconto=' + document.getElementById('pcdesconto').value

                + '&radio=' + radio   //Tipo de Valor: radio1		
                + '&radioa=' + radioa   //Local

                + '&radiob=' + radiob

                + '&total=' + total

                + '&opc=' + opc

                + '' + campovet1
                + '' + campovet2
                + '' + campovet3
                + '' + campovet4
                + '' + campovet5
                + '' + campovet6
                + '' + campovet7
                + '' + campovet8
                + '' + campovet9
                + '' + campovet10

                + '&pvparcelas=' + document.getElementById('pvparcelas').value

                + '&dia1=' + document.getElementById('dia1').value
                + '&dia2=' + document.getElementById('dia2').value
                + '&dia3=' + document.getElementById('dia3').value
                + '&dia4=' + document.getElementById('dia4').value
                + '&dia5=' + document.getElementById('dia5').value
                + '&dia6=' + document.getElementById('dia6').value

                + '&pvdata1=' + document.getElementById('pvdata1').value
                + '&pvdata2=' + document.getElementById('pvdata2').value
                + '&pvdata3=' + document.getElementById('pvdata3').value
                + '&pvdata4=' + document.getElementById('pvdata4').value
                + '&pvdata5=' + document.getElementById('pvdata5').value
                + '&pvdata6=' + document.getElementById('pvdata6').value

                + '&parc1=' + document.getElementById('parc1').value
                + '&parc2=' + document.getElementById('parc2').value
                + '&parc3=' + document.getElementById('parc3').value
                + '&parc4=' + document.getElementById('parc4').value
                + '&parc5=' + document.getElementById('parc5').value
                + '&parc6=' + document.getElementById('parc6').value

                + '&tipoparcelas=' + tipoparcelas

                + '&venda=' + document.getElementById('venda').value

                + '&ipi=' + document.getElementById('ipi').value

        ajax2.send(params);


    } else if ($("acao").value == "alterar") {

        ajax2.open("POST", "pedcompraaltera.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax2.onreadystatechange = function () {

            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {

            }
            //após ser processado 
            if (ajax2.readyState == 4)
            {
                teste(opc, document.getElementById('pcnumero').value);
            }
        }
        var params = 'pcnumero=' + document.getElementById('pcnumero').value
                + '&pcentrega=' + document.getElementById('pcentrega').value
                + '&pcemissao=' + document.getElementById('pcemissao').value
                + '&pcchegada=' + document.getElementById('pcchegada').value
                + '&codigofornecedor=' + document.forms[0].pesquisafornecedor.value

                + '&comprador=' + document.getElementById('comprador').value
                + '&pcprocesso=' + document.getElementById('pcprocesso').value
                + '&pccontainer=' + document.getElementById('pccontainer').value
                + '&comissao=' + document.getElementById('comissao').value
                + '&condicao=' + document.getElementById('condicao').value

                + '&observacao1=' + document.getElementById('observacao1').value
                + '&observacao2=' + document.getElementById('observacao2').value
                + '&observacao3=' + document.getElementById('observacao3').value

                + '&observacao4=' + document.getElementById('observacao4').value
                + '&observacao5=' + document.getElementById('observacao5').value

                + '&percdesc=' + document.getElementById('percdesc').value
                + '&pcdesconto=' + document.getElementById('pcdesconto').value

                + '&radio=' + radio   //Tipo de Valor: radio1		
                + '&radioa=' + radioa   //Local

                + '&radiob=' + radiob

                + '&total=' + total

                + '&opc=' + opc

                + '' + campovet1
                + '' + campovet2
                + '' + campovet3
                + '' + campovet4
                + '' + campovet5
                + '' + campovet6
                + '' + campovet7
                + '' + campovet8
                + '' + campovet9
                + '' + campovet10

                + '&pvparcelas=' + document.getElementById('pvparcelas').value

                + '&dia1=' + document.getElementById('dia1').value
                + '&dia2=' + document.getElementById('dia2').value
                + '&dia3=' + document.getElementById('dia3').value
                + '&dia4=' + document.getElementById('dia4').value
                + '&dia5=' + document.getElementById('dia5').value
                + '&dia6=' + document.getElementById('dia6').value

                + '&pvdata1=' + document.getElementById('pvdata1').value
                + '&pvdata2=' + document.getElementById('pvdata2').value
                + '&pvdata3=' + document.getElementById('pvdata3').value
                + '&pvdata4=' + document.getElementById('pvdata4').value
                + '&pvdata5=' + document.getElementById('pvdata5').value
                + '&pvdata6=' + document.getElementById('pvdata6').value

                + '&parc1=' + document.getElementById('parc1').value
                + '&parc2=' + document.getElementById('parc2').value
                + '&parc3=' + document.getElementById('parc3').value
                + '&parc4=' + document.getElementById('parc4').value
                + '&parc5=' + document.getElementById('parc5').value
                + '&parc6=' + document.getElementById('parc6').value

                + '&tipoparcelas=' + tipoparcelas

                + '&venda=' + document.getElementById('venda').value

                + '&ipi=' + document.getElementById('ipi').value

        ajax2.send(params);

    }
}


function processXMLinclui(obj) {
    
    $a.unblockUI();

    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados


        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML

            var pedidocriado = item.getElementsByTagName("pedido")[0].firstChild.nodeValue;

            alert("Atenção, pedido criado com o numero: " + pedidocriado);

            if (confirm("Deseja Imprimir?")) {
                window.open('pedcompraconsimppdf2.php?pcnumero=' + pedidocriado +
                        '&tipo=1'
                        , '_blank');


            }

        }
    }

    window.open('incluirpedcompra.php', '_self');

}

function teste(opc, pcnumero) {

//alert(pcnumero);

    window.open('pedcomprax.php?opc=' + opc + '&pcnumero=' + pcnumero
            , '_self');

}


function sugestao() {

    var opc = 0;

    enviar(opc);

}

function ver() {


//Limpar
    document.forms[0].codigo.value = '';
    document.forms[0].pcentrega.value = '';
    document.forms[0].pcemissao.value = '';
    document.forms[0].pcchegada.value = '';

    document.forms[0].codigofornecedor.value = '';
    document.forms[0].fornecedor.value = '';
    document.forms[0].pesquisafornecedor.options.length = 0;

    document.forms[0].radio1.checked = true;
    document.forms[0].comprador.value = '';
    document.forms[0].pcprocesso.value = '';
    document.forms[0].pccontainer.value = '';
    document.forms[0].comissao.value = '';
    document.forms[0].condicao.value = '';
    if (max_novo == 1) {
        document.forms[0].radioa3.checked = true;
    } else {
        document.forms[0].radioa5.checked = true;
    }

    document.forms[0].radiob1.checked = true;

    document.forms[0].observacao1.value = '';
    document.forms[0].observacao2.value = '';
    document.forms[0].observacao3.value = '';

    document.forms[0].observacao4.value = '';
    document.forms[0].observacao5.value = '';

    document.getElementById("radiodp2").checked = true;

    document.forms[0].codigoproduto.value = '';
    document.forms[0].produto.value = '';
    document.forms[0].pesquisaproduto.options.length = 0;

    document.forms[0].percdesc.value = '';
    document.forms[0].pcdesconto.value = '';

    document.forms[0].pctotal.value = '';
    document.forms[0].pctotal2.value = '';

    document.forms[0].quantidade.value = '';

    document.forms[0].radiob1.checked = true;

    document.getElementById("venda").value = '';
    document.getElementById("venda").disabled = true;

    $("resultado").innerHTML = '';

    $("acao").value = "inserir";
    $("botao").value = "Incluir";

    $("pvparcelas").value = "";

    $("parc1").value = "";
    $("parc2").value = "";
    $("parc3").value = "";
    $("parc4").value = "";
    $("parc5").value = "";
    $("parc6").value = "";

    $("dia1").value = "";
    $("dia2").value = "";
    $("dia3").value = "";
    $("dia4").value = "";
    $("dia5").value = "";
    $("dia6").value = "";

    $("pvdata1").value = "";
    $("pvdata2").value = "";
    $("pvdata3").value = "";
    $("pvdata4").value = "";
    $("pvdata5").value = "";
    $("pvdata6").value = "";


    $("parc1").disabled = true;
    $("parc2").disabled = true;
    $("parc3").disabled = true;
    $("parc4").disabled = true;
    $("parc5").disabled = true;
    $("parc6").disabled = true;

    $("dia1").disabled = true;
    $("dia2").disabled = true;
    $("dia3").disabled = true;
    $("dia4").disabled = true;
    $("dia5").disabled = true;
    $("dia6").disabled = true;

    $("pvdata1").disabled = true;
    $("pvdata2").disabled = true;
    $("pvdata3").disabled = true;
    $("pvdata4").disabled = true;
    $("pvdata5").disabled = true;
    $("pvdata6").disabled = true;

    for (var i = 0; i < 700; i++) {
        vet[i][0] = 0;
        vet[i][1] = 0;
        vet[i][2] = 0;
        vet[i][3] = 0;
        vet[i][4] = 0;
        vet[i][5] = 0;
        vet[i][6] = 0;
        vet[i][7] = 0;
        vet[i][8] = 0;
        vet[i][9] = 0;
        vet[i][10] = 0;
        vet[i][11] = 0;
    }

    var pcnumero = document.forms[0].pcnumero.value;

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

        ajax2.open("POST", "pedcomprapesquisa.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {

            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {

            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML) {
                    processXML(ajax2.responseXML);
                } else
                {
                    ///MOZILA
                    if ($("pcnumero").value != '')
                    {

                        //alert("Pedido não existe!");


                    }

                }
            }
        }
        //passa o parametro
        var params = "parametro=" + pcnumero;
        ajax2.send(params);
    }

}


function processXML(obj) {


    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados


        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML

            var pcnumero = item.getElementsByTagName("pcnumero")[0].firstChild.nodeValue;
            var pcemissao = item.getElementsByTagName("pcemissao")[0].firstChild.nodeValue;
            var pcentrega = item.getElementsByTagName("pcentrega")[0].firstChild.nodeValue;
            var pcchegada = item.getElementsByTagName("pcchegada")[0].firstChild.nodeValue;
            var fornguerra = item.getElementsByTagName("fornguerra")[0].firstChild.nodeValue;
            var forcodigo = item.getElementsByTagName("forcodigo")[0].firstChild.nodeValue;
            var forcod = item.getElementsByTagName("forcod")[0].firstChild.nodeValue;
            var comprador = item.getElementsByTagName("comprador")[0].firstChild.nodeValue;
            var pcprocesso = item.getElementsByTagName("pcprocesso")[0].firstChild.nodeValue;
            var pccontainer = item.getElementsByTagName("pccontainers")[0].firstChild.nodeValue;
            var condicao = item.getElementsByTagName("condicao")[0].firstChild.nodeValue;
            var observacao1 = item.getElementsByTagName("observacao1")[0].firstChild.nodeValue;
            var observacao2 = item.getElementsByTagName("observacao2")[0].firstChild.nodeValue;
            var observacao3 = item.getElementsByTagName("observacao3")[0].firstChild.nodeValue;

            var observacao4 = item.getElementsByTagName("observacao4")[0].firstChild.nodeValue;
            var observacao5 = item.getElementsByTagName("observacao5")[0].firstChild.nodeValue;

            var comissao = item.getElementsByTagName("comissao")[0].firstChild.nodeValue;
            //var total =  item.getElementsByTagName("total")[0].firstChild.nodeValue;
            //var ipi =  item.getElementsByTagName("ipi")[0].firstChild.nodeValue;
            var desconto = item.getElementsByTagName("desconto")[0].firstChild.nodeValue;
            var perdesconto = item.getElementsByTagName("perdesconto")[0].firstChild.nodeValue;

            var tipo = item.getElementsByTagName("tipo")[0].firstChild.nodeValue;
            var localentrega = item.getElementsByTagName("localentrega")[0].firstChild.nodeValue;


            var tipoparcelas = item.getElementsByTagName("tipoparcelas")[0].firstChild.nodeValue;
            var parcelas = item.getElementsByTagName("parcelas")[0].firstChild.nodeValue;
            var parcdia1 = item.getElementsByTagName("parcdia1")[0].firstChild.nodeValue;
            var parcdia2 = item.getElementsByTagName("parcdia2")[0].firstChild.nodeValue;
            var parcdia3 = item.getElementsByTagName("parcdia3")[0].firstChild.nodeValue;
            var parcdia4 = item.getElementsByTagName("parcdia4")[0].firstChild.nodeValue;
            var parcdia5 = item.getElementsByTagName("parcdia5")[0].firstChild.nodeValue;
            var parcdia6 = item.getElementsByTagName("parcdia6")[0].firstChild.nodeValue;
            var parcdata1 = item.getElementsByTagName("parcdata1")[0].firstChild.nodeValue;
            var parcdata2 = item.getElementsByTagName("parcdata2")[0].firstChild.nodeValue;
            var parcdata3 = item.getElementsByTagName("parcdata3")[0].firstChild.nodeValue;
            var parcdata4 = item.getElementsByTagName("parcdata4")[0].firstChild.nodeValue;
            var parcdata5 = item.getElementsByTagName("parcdata5")[0].firstChild.nodeValue;
            var parcdata6 = item.getElementsByTagName("parcdata6")[0].firstChild.nodeValue;
            var parcela1 = item.getElementsByTagName("parcela1")[0].firstChild.nodeValue;
            var parcela2 = item.getElementsByTagName("parcela2")[0].firstChild.nodeValue;
            var parcela3 = item.getElementsByTagName("parcela3")[0].firstChild.nodeValue;
            var parcela4 = item.getElementsByTagName("parcela4")[0].firstChild.nodeValue;
            var parcela5 = item.getElementsByTagName("parcela5")[0].firstChild.nodeValue;
            var parcela6 = item.getElementsByTagName("parcela6")[0].firstChild.nodeValue;

            var tipopedido = item.getElementsByTagName("tipoped")[0].firstChild.nodeValue;

            var venda = item.getElementsByTagName("pvnumero")[0].firstChild.nodeValue;
            var pcempresa = item.getElementsByTagName("pcempresa")[0].firstChild.nodeValue;

            if (pcempresa == 2) {
                alert("Pedido pertence a Empresa FUN!");
                limpa_form(0, 0, max_novo);
            } else {

                trimjs(pcnumero);
                if (txt == '0') {
                    txt = '';
                }
                ;
                pcnumero = txt;
                trimjs(pcemissao);
                if (txt == '0') {
                    txt = '';
                }
                ;
                pcemissao = txt;
                trimjs(pcentrega);
                if (txt == '0') {
                    txt = '';
                }
                ;
                pcentrega = txt;
                trimjs(pcchegada);
                if (txt == '0') {
                    txt = '';
                }
                pcchegada = txt;
                trimjs(fornguerra);
                if (txt == '0') {
                    txt = '';
                }
                ;
                fornguerra = txt;
                trimjs(forcodigo);
                if (txt == '0') {
                    txt = '';
                }
                ;
                forcodigo = txt;
                trimjs(forcod);
                if (txt == '0') {
                    txt = '';
                }
                ;
                forcod = txt;
                trimjs(comprador);
                if (txt == '0') {
                    txt = '';
                }
                ;
                comprador = txt;
                trimjs(pcprocesso);
                if (txt == '0') {
                    txt = '';
                }
                pcprocesso = txt;
                trimjs(pccontainer);
                if (txt == '0') {
                    txt = '';
                }
                pccontainer = txt;
                trimjs(condicao);
                if (txt == '0') {
                    txt = '';
                }
                ;
                condicao = txt;
                trimjs(observacao1);
                if (txt == '0') {
                    txt = '';
                }
                ;
                observacao1 = txt;
                trimjs(observacao2);
                if (txt == '0') {
                    txt = '';
                }
                ;
                observacao2 = txt;
                trimjs(observacao3);
                if (txt == '0') {
                    txt = '';
                }
                ;
                observacao3 = txt;

                trimjs(observacao4);
                if (txt == '0') {
                    txt = '';
                }
                ;
                observacao4 = txt;
                trimjs(observacao5);
                if (txt == '0') {
                    txt = '';
                }
                ;
                observacao5 = txt;

                trimjs(comissao);
                if (txt == '0') {
                    txt = '';
                }
                ;
                comissao = txt;
                trimjs(desconto);
                if (txt == '0') {
                    txt = '';
                }
                ;
                desconto = txt;
                trimjs(perdesconto);
                if (txt == '0') {
                    txt = '';
                }
                ;
                perdesconto = txt;

                trimjs(tipoparcelas);
                if (txt == '0') {
                    txt = '';
                }
                ;
                tipoparcelas = txt;
                trimjs(parcelas);
                if (txt == '0') {
                    txt = '';
                }
                ;
                parcelas = txt;
                trimjs(parcdia1);
                if (txt == '0') {
                    txt = '';
                }
                ;
                parcdia1 = txt;
                trimjs(parcdia2);
                if (txt == '0') {
                    txt = '';
                }
                ;
                parcdia2 = txt;
                trimjs(parcdia3);
                if (txt == '0') {
                    txt = '';
                }
                ;
                parcdia3 = txt;
                trimjs(parcdia4);
                if (txt == '0') {
                    txt = '';
                }
                ;
                parcdia4 = txt;
                trimjs(parcdia5);
                if (txt == '0') {
                    txt = '';
                }
                ;
                parcdia5 = txt;
                trimjs(parcdia6);
                if (txt == '0') {
                    txt = '';
                }
                ;
                parcdia6 = txt;
                trimjs(parcdata1);
                if (txt == '0') {
                    txt = '';
                }
                ;
                parcdata1 = txt;
                trimjs(parcdata2);
                if (txt == '0') {
                    txt = '';
                }
                ;
                parcdata2 = txt;
                trimjs(parcdata3);
                if (txt == '0') {
                    txt = '';
                }
                ;
                parcdata3 = txt;
                trimjs(parcdata4);
                if (txt == '0') {
                    txt = '';
                }
                ;
                parcdata4 = txt;
                trimjs(parcdata5);
                if (txt == '0') {
                    txt = '';
                }
                ;
                parcdata5 = txt;
                trimjs(parcdata6);
                if (txt == '0') {
                    txt = '';
                }
                ;
                parcdata6 = txt;
                trimjs(parcela1);
                if (txt == '0') {
                    txt = '';
                }
                ;
                parcela1 = txt;
                trimjs(parcela2);
                if (txt == '0') {
                    txt = '';
                }
                ;
                parcela2 = txt;
                trimjs(parcela3);
                if (txt == '0') {
                    txt = '';
                }
                ;
                parcela3 = txt;
                trimjs(parcela4);
                if (txt == '0') {
                    txt = '';
                }
                ;
                parcela4 = txt;
                trimjs(parcela5);
                if (txt == '0') {
                    txt = '';
                }
                ;
                parcela5 = txt;
                trimjs(parcela6);
                if (txt == '0') {
                    txt = '';
                }
                ;
                parcela6 = txt;

                trimjs(venda);
                if (txt == '0') {
                    txt = '';
                }
                ;
                venda = txt;

                document.forms[0].codigo.value = 0;
                document.forms[0].pcentrega.value = pcentrega;
                document.forms[0].pcemissao.value = pcemissao;
                document.forms[0].pcchegada.value = pcchegada;


                document.getElementById("opcao1").checked = true;
                document.forms[0].codigofornecedor.value = forcod;
                //document.forms[0].fornecedor.value = fornguerra;

                var descricao = forcod + ' ' + fornguerra;

                document.forms[0].pesquisafornecedor.options.length = 0;
                var novo = document.createElement("option");
                novo.setAttribute("id", "opcoes");
                novo.value = forcodigo;
                //novo.text  = fornguerra;
                novo.text = descricao;
                document.forms[0].pesquisafornecedor.options.add(novo);

                //Tipo de Valor: radio1			
                document.forms[0].comprador.value = comprador;
                document.forms[0].pcprocesso.value = pcprocesso;
                document.forms[0].pccontainer.value = pccontainer;
                document.forms[0].comissao.value = comissao;
                document.forms[0].condicao.value = condicao;
                //Local radioa1			
                document.forms[0].observacao1.value = observacao1;
                document.forms[0].observacao2.value = observacao2;
                document.forms[0].observacao3.value = observacao3;

                document.forms[0].observacao4.value = observacao4;
                document.forms[0].observacao5.value = observacao5;

                //codigoproduto
                document.forms[0].percdesc.value = perdesconto;
                document.forms[0].pcdesconto.value = desconto;


                if (tipo == 1) {

                    document.getElementById("radio1").checked = true;
                } else {
                    document.getElementById("radio2").checked = true;
                }


                if (localentrega == 1) {
                    document.getElementById("radioa1").checked = true;
                } else if (localentrega == 2) {
                    document.getElementById("radioa2").checked = true;
                } else if (localentrega == 3) {
                    document.getElementById("radioa3").checked = true;
                } else if (localentrega == 4) {
                    document.getElementById("radioa4").checked = true;
                } else if (localentrega == 5) {
                    document.getElementById("radioa5").checked = true;
                } else {
                    document.getElementById("radioa6").checked = true;
                }

                if (tipopedido == 1) {
                    document.getElementById("radiob1").checked = true;
                } else if (tipopedido == 2) {
                    document.getElementById("radiob2").checked = true;

                    document.getElementById("venda").disabled = false;

                    document.forms[0].venda.value = venda;

                } else {
                    document.getElementById("radiob3").checked = true;

                    document.getElementById("venda").disabled = false;

                    document.forms[0].venda.value = venda;
                }



                $("pvparcelas").value = parcelas;

                if (tipoparcelas == 1) {

                    document.getElementById("pvtipo1").checked = true;

                    $("dia1").style.visibility = "visible";
                    $("dia2").style.visibility = "visible";
                    $("dia3").style.visibility = "visible";
                    $("dia4").style.visibility = "visible";
                    $("dia5").style.visibility = "visible";
                    $("dia6").style.visibility = "visible";

                    $("pvdata1").style.visibility = "hidden";
                    $("pvdata2").style.visibility = "hidden";
                    $("pvdata3").style.visibility = "hidden";
                    $("pvdata4").style.visibility = "hidden";
                    $("pvdata5").style.visibility = "hidden";
                    $("pvdata6").style.visibility = "hidden";

                    if (parcelas >= 1) {
                        $("dia1").value = parcdia1;
                        $("dia1").disabled = false;
                    }
                    if (parcelas >= 2) {
                        $("dia2").value = parcdia2;
                        $("dia2").disabled = false;
                    }
                    if (parcelas >= 3) {
                        $("dia3").value = parcdia3;
                        $("dia3").disabled = false;
                    }
                    if (parcelas >= 4) {
                        $("dia4").value = parcdia4;
                        $("dia4").disabled = false;
                    }
                    if (parcelas >= 5) {
                        $("dia5").value = parcdia5;
                        $("dia5").disabled = false;
                    }
                    if (parcelas >= 6) {
                        $("dia6").value = parcdia6;
                        $("dia6").disabled = false;
                    }

                } else {

                    document.getElementById("pvtipo2").checked = true;

                    $("dia1").style.visibility = "hidden";
                    $("dia2").style.visibility = "hidden";
                    $("dia3").style.visibility = "hidden";
                    $("dia4").style.visibility = "hidden";
                    $("dia5").style.visibility = "hidden";
                    $("dia6").style.visibility = "hidden";

                    $("pvdata1").style.visibility = "visible";
                    $("pvdata2").style.visibility = "visible";
                    $("pvdata3").style.visibility = "visible";
                    $("pvdata4").style.visibility = "visible";
                    $("pvdata5").style.visibility = "visible";
                    $("pvdata6").style.visibility = "visible";

                    if (parcelas >= 1) {
                        $("pvdata1").value = parcdata1;
                        $("pvdata1").disabled = false;
                    }
                    if (parcelas >= 2) {
                        $("pvdata2").value = parcdata2;
                        $("pvdata2").disabled = false;
                    }
                    if (parcelas >= 3) {
                        $("pvdata3").value = parcdata3;
                        $("pvdata3").disabled = false;
                    }
                    if (parcelas >= 4) {
                        $("pvdata4").value = parcdata4;
                        $("pvdata4").disabled = false;
                    }
                    if (parcelas >= 5) {
                        $("pvdata5").value = parcdata5;
                        $("pvdata5").disabled = false;
                    }
                    if (parcelas >= 6) {
                        $("pvdata6").value = parcdata6;
                        $("pvdata6").disabled = false;
                    }

                }

                if (parcelas >= 1) {
                    $("parc1").value = parcela1;
                    $("parc1").disabled = false;
                }
                if (parcelas >= 2) {
                    $("parc2").value = parcela2;
                    $("parc2").disabled = false;
                }
                if (parcelas >= 3) {
                    $("parc3").value = parcela3;
                    $("parc3").disabled = false;
                }
                if (parcelas >= 4) {
                    $("parc4").value = parcela4;
                    $("parc4").disabled = false;
                }
                if (parcelas >= 5) {
                    $("parc5").value = parcela5;
                    $("parc5").disabled = false;
                }
                if (parcelas >= 6) {
                    $("parc6").value = parcela6;
                    $("parc6").disabled = false;
                }


                $("importaPedido").disabled = true;


                $("acao").value = "alterar";
                $("botao").value = "Alterar";

                load_grid($("pcnumero").value);

            }


        }
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo

        if ($("pcnumero").value != '')
        {
            //alert("Pedido não existe!");
            //document.forms[0].pcnumero.focus();
        }




    }

}

// JavaScript Document
function load_grid(pcnumero) {


    new ajax('pedcomprapesquisaitensnovo.php?pcnumero=' + pcnumero, {onLoading: carregando, onComplete: imprime1});
}

function carregando() {
    $("msg").style.visibility = "visible";
    $("msg").innerHTML = "Processando...";
}


function imprime1(request) {

    $("msg").style.visibility = "hidden";
    var xmldoc = request.responseXML;
    var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];
    if (cabecalho != null)
    {


        var tabela = "<table width='785' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' ><tr>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Codigo</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Produto</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Quantidade</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Custo </b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Desc. 1</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Desc. 2</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Desc. 3</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Desc. 4</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Perc. IPI</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Data Entrega</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Referencia</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Excluir</b></td>";

        //corpo da tabela
        var registros = xmldoc.getElementsByTagName('registro');

        if (registros.length > 500) {
            alert("Atenção, esse pedido já atingiu o limite de 500 itens, quando possível favor transferir os saldos para um novo pedido!");
        }

        for (i = 0; i < registros.length; i++) {
            var itens = registros[i].getElementsByTagName('item');
            tabela += "<tr id=linha" + i + ">"
            for (j = 0; j < itens.length; j++) {

                if (itens[j].firstChild == null)
                    tabela += "<td class='borda'>" + 0 + "</td>";
                else
                if (j == 0) {
                    vet[i][j] = itens[j].firstChild.data;
                    tabela += "<td class='borda'>" + vet[i][j] + "</td>";
                } else if (j == 1) {
                    vet[i][j] = itens[j].firstChild.data;
                    tabela += "<td class='borda'>" + vet[i][j] + "</td>";
                } else if (j == 2) {
                    vet[i][j] = itens[j].firstChild.data;
                    cod = 'a' + i;
                    k = 2;
                    val = vet[i][2];
                    tabela += "<td class='borda' style='cursor: pointer'><input type='text' id='" + cod + "' name='" + cod + "' value='" + val + "' size='8' onBlur='convertField3(this);editar(" + i + "," + k + ",this.value" + ");' onKeyPress='return Tecla(event);'></td>";
                } else if (j == 3) {
                    vet[i][j] = itens[j].firstChild.data;
                    cod = 'b' + i;
                    k = 3;
                    val = vet[i][3];
                    tabela += "<td class='borda' style='cursor: pointer'><input type='text' id='" + cod + "' name='" + cod + "' value='" + val + "' size='8' onBlur='convertField3(this);editar(" + i + "," + k + ",this.value" + ");' onKeyPress='return Tecla(event);'></td>";
                } else if (j == 4) {
                    vet[i][j] = itens[j].firstChild.data;
                    cod = 'c' + i;
                    k = 4;
                    val = vet[i][4];
                    tabela += "<td class='borda' style='cursor: pointer'><input type='text' id='" + cod + "' name='" + cod + "' value='" + val + "' size='8' onBlur='convertField3(this);editar(" + i + "," + k + ",this.value" + ");' onKeyPress='return Tecla(event);'></td>";
                } else if (j == 5) {
                    vet[i][j] = itens[j].firstChild.data;
                    cod = 'd' + i;
                    k = 5;
                    val = vet[i][5];
                    tabela += "<td class='borda' style='cursor: pointer'><input type='text' id='" + cod + "' name='" + cod + "' value='" + val + "' size='8' onBlur='convertField3(this);editar(" + i + "," + k + ",this.value" + ");' onKeyPress='return Tecla(event);'></td>";
                } else if (j == 6) {
                    vet[i][j] = itens[j].firstChild.data;
                    cod = 'e' + i;
                    k = 6;
                    val = vet[i][6];
                    tabela += "<td class='borda' style='cursor: pointer'><input type='text' id='" + cod + "' name='" + cod + "' value='" + val + "' size='8' onBlur='convertField3(this);editar(" + i + "," + k + ",this.value" + ");' onKeyPress='return Tecla(event);' ></td>";
                } else if (j == 7) {
                    vet[i][j] = itens[j].firstChild.data;
                    cod = 'f' + i;
                    k = 7;
                    val = vet[i][7];
                    tabela += "<td class='borda' style='cursor: pointer'><input type='text' id='" + cod + "' name='" + cod + "' value='" + val + "' size='8' onBlur='convertField3(this);editar(" + i + "," + k + ",this.value" + ");' onKeyPress='return Tecla(event);'></td>";
                } else if (j == 8) {
                    vet[i][j] = itens[j].firstChild.data;
                    cod = 'g' + i;
                    k = 8;
                    val = vet[i][8];
                    tabela += "<td class='borda' style='cursor: pointer'><input type='text' id='" + cod + "' name='" + cod + "' value='" + val + "' size='8' onBlur='convertField3(this);editar(" + i + "," + k + ",this.value" + ");' onKeyPress='return Tecla(event);'></td>";
                } else if (j == 9) {
                    vet[i][j] = itens[j].firstChild.data;
                    cod = 'h' + i;
                    k = 9;
                    val = vet[i][9];
                    if (val == 0) {
                        val = "";
                    }
                    tabela += "<td class='borda' style='cursor: pointer'><input type='text' id='" + cod + "' name='" + cod + "' value='" + val + "' size='8' onBlur='dataano(this,this.value);editar(" + i + "," + k + ",this.value" + ");' onKeyPress='formatar(" + '"##/##/####"' + ", this);' ></td>";
                }
                //Campo que informa se tem ou não itens já baixados
                else if (j == 12) {
                    vet[i][11] = itens[j].firstChild.data;
                } else if (j == 11) {
                    vet[i][10] = itens[j].firstChild.data;
                    tabela += "<td class='borda'>" + vet[i][10] + "</td>";
                }

            }


            tabela += "<td class='borda' style='cursor: pointer'><img src='imagens/delete.gif' onClick=apagar('" + vet[i][0] + "')></td>";
            tabela += "</tr>";
        }

        tabela += "</table>"


        tabela += "</tr>"

        $("resultado").innerHTML = tabela;
        //$("resultado2").innerHTML=tabela2;
        tabela = null;

        calc();

    } else
        $("resultado").innerHTML = "Nenhum registro encontrado...";
}




function incluir2(forcod, proref, provalida, stpcodigo) {

    if (provalida == 0) {
        alert('Produto não validado, favor avisar o setor fiscal!');
        return;
    } else if (stpcodigo == 2) {
        alert('Produto FORA DE LINHA!');        
    } else if (stpcodigo == 3) {
        alert('Produto INATIVO!');
        return;
    }

    var forcod2 = document.forms[0].fornecedor.value;

    trimjs(forcod2);
    forcod2 = txt;

    if (forcod2 != '') {
        if (forcod != forcod2) {
            alert('O Item não pertence ao fornecedor selecionado!');
        }
    }

    var codigoproduto = document.forms[0].codigoproduto.value;
    var produto = document.forms[0].produto.value;

    var entrega = document.forms[0].pcentrega.value;

    var profinal = document.forms[0].profinal.value;
    var proipi = document.forms[0].proipi.value;

    var quantidade = document.forms[0].quantidade.value;

    var cod = '';

    for (var i = 0; i < 700; i++) {
        if (vet[i][0] == codigoproduto) {
            alert('Produto já incluido!');
            return;
        }
    }

    var desc01;
    var desc02;
    var desc03;
    var desc04;
    var ipi;
    desc01 = 0;
    desc02 = 0;
    desc03 = 0;
    desc04 = 0;
    ipi = 0;

    desc01 = vdesc1;
    desc02 = vdesc2;
    desc03 = vdesc3;
    desc04 = vdesc4;
    desc05 = vdesc5;
    desc06 = vdesc6;
    ipi = vipi;

    for (var i = 0; i < 700; i++) {
        if (vet[i][0] != 0) {
            desc01 = 0;
            desc02 = 0;
            desc03 = 0;
            desc04 = 0;
            ipi = 0;
            i = 700;
        }
    }


    if (document.getElementById("radiodp1").checked == true) {

        for (var i = 0; i < 700; i++) {
            if (vet[i][0] != 0) {
                desc01 = vet[i][4];
                desc02 = vet[i][5];
                desc03 = vet[i][6];
                desc04 = vet[i][7];
                ipi = vet[i][8];
                i = 700;
            }
        }
    }




    for (var i = 0; i < 700; i++) {
        if (vet[i][0] == 0) {
            vet[i][0] = codigoproduto;
            vet[i][1] = produto;

            if (entrega != '') {
                vet[i][9] = entrega;
            }
            if (profinal != '') {
                vet[i][3] = profinal;
            }

            vet[i][2] = quantidade;

            vet[i][4] = desc01;
            vet[i][5] = desc02;
            vet[i][6] = desc03;
            vet[i][7] = desc04;
            if (proipi != '') {
                vet[i][8] = proipi;
            } else {
                vet[i][8] = ipi;
            }
            vet[i][10] = proref;

            i = 700;
        }
    }

    document.forms[0].codigoproduto.value = '';
    document.forms[0].produto.value = '';
    document.forms[0].pesquisaproduto.options.length = 0;
    document.forms[0].quantidade.value = '';


    document.getElementById("codigoproduto").focus();

    imprime();

}

function imprime() {


    $("msg").style.visibility = "hidden";

    let tabela = "<div class='limiter'>"
    tabela += "<div class='container-table100'>"
    tabela += "<div class='wrap-table100'>"
    tabela += "<div class='table-max'>"
    tabela += "<div class='row-max header'>"
    tabela += "<div class='cell-max'>Codigo</div>"
    tabela += "<div class='cell-max'>Produto</div>"
    tabela += "<div class='cell-max'>Qtde</div>"
    tabela += "<div class='cell-max'>Custo</div>"
    tabela += "<div class='cell-max'>D.1</div>"
    tabela += "<div class='cell-max'>D.2</div>"
    tabela += "<div class='cell-max'>D.3</div>"
    tabela += "<div class='cell-max'>D.4</div>"
    tabela += "<div class='cell-max'>IPI%</div>"
    tabela += "<div class='cell-max'>Entrega</div>"
    tabela += "<div class='cell-max'>Referencia</div>"
    tabela += "<div class='cell-max'>Ação</div>"
    tabela += "</div>"


    for (var i = 0; i < 700; i++) {
        if (vet[i][0] != 0) {

            tabela += "<div class='row-max'>"
            tabela += "<div class='cell-max' data-title='Codigo'>" + vet[i][0] + "</div>"
            tabela += "<div class='cell-max' data-title='Produto'>" + vet[i][1] + "</div>"

            cod = 'a' + i;
            k = 2;
            val = vet[i][2];
            tabela += "<div class='cell-max' data-title='Qtde'>" + "<input type='text' id='" + cod + "' name='" + cod + "' value='" + val + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='8' onBlur='convertField3(this);editar(" + i + "," + k + ",this.value" + ");' onKeyPress='return Tecla(event);'>" + "</div>"
            cod = 'b' + i;
            k = 3;
            val = vet[i][3];
            tabela += "<div class='cell-max' data-title='Custo'>" + "<input type='text' id='" + cod + "' name='" + cod + "' value='" + val + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='8' onBlur='convertField3(this);editar(" + i + "," + k + ",this.value" + ");' onKeyPress='return Tecla(event);'>" + "</div>"
            cod = 'c' + i;
            k = 4;
            val = vet[i][4];
            tabela += "<div class='cell-max' data-title='D.1'>" + "<input type='text' id='" + cod + "' name='" + cod + "' value='" + val + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='8' onBlur='convertField3(this);editar(" + i + "," + k + ",this.value" + ");' onKeyPress='return Tecla(event);'>" + "</div>"
            cod = 'd' + i;
            k = 5;
            val = vet[i][5];
            tabela += "<div class='cell-max' data-title='D.2'>" + "<input type='text' id='" + cod + "' name='" + cod + "' value='" + val + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='8' onBlur='convertField3(this);editar(" + i + "," + k + ",this.value" + ");' onKeyPress='return Tecla(event);'>" + "</div>"
            cod = 'e' + i;
            k = 6;
            val = vet[i][6];
            tabela += "<div class='cell-max' data-title='D.3'>" + "<input type='text' id='" + cod + "' name='" + cod + "' value='" + val + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='8' onBlur='convertField3(this);editar(" + i + "," + k + ",this.value" + ");' onKeyPress='return Tecla(event);'>" + "</div>"
            cod = 'f' + i;
            k = 7;
            val = vet[i][7];
            tabela += "<div class='cell-max' data-title='D.4'>" + "<input type='text' id='" + cod + "' name='" + cod + "' value='" + val + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='8' onBlur='convertField3(this);editar(" + i + "," + k + ",this.value" + ");' onKeyPress='return Tecla(event);'>" + "</div>"
            cod = 'g' + i;
            k = 8;
            val = vet[i][8];
            tabela += "<div class='cell-max' data-title='IPI%'>" + "<input type='text' id='" + cod + "' name='" + cod + "' value='" + val + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='8' onBlur='convertField3(this);editar(" + i + "," + k + ",this.value" + ");' onKeyPress='return Tecla(event);'>" + "</div>"

            cod = 'h' + i;
            k = 9;
            val = vet[i][9];

            if (val == 0) {
                val = "";
            }
            tabela += "<div class='cell-max' data-title='Entrega'>" + "<input type='text' id='" + cod + "' name='" + cod + "' value='" + val + "' style='font-size:12px;text-align:center;BACKGROUND-COLOR: #b3b3ff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;' size='8' onBlur='dataano(this,this.value);editar(" + i + "," + k + ",this.value" + ");' onKeyPress='formatar(" + '"##/##/####"' + ", this);' >" + "</div>"

            tabela += "<div class='cell-max' data-title='Referencia'>" + vet[i][10] + "</div>"

            let tabelaaux = '<a href="javascript:apagar(' + "'" + vet[i][0] + "'" + ');" style="text-decoration:none; color:#000000;">';
            tabelaaux += '<img src="images/alterar2.png" border="0" title="Excluir" align="absmiddle"></a>';


            tabela += "<div class='cell-max' data-title='Ação'>" + tabelaaux + "</div>"
            tabela += "</div>"

        }

    }


    tabela += "</div>"
    tabela += "</div>"
    tabela += "</div>"
    tabela += "</div>"

    $("resultado").innerHTML = tabela;

    tabela = null;

    calc();

}

function imprimenaousamais() {


    $("msg").style.visibility = "hidden";




    var tabela = "<table width='785' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' ><tr>"
    tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Codigo</b></td>";
    tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Produto</b></td>";
    tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Quantidade</b></td>";
    tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Custo </b></td>";
    tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Desc. 1</b></td>";
    tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Desc. 2</b></td>";
    tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Desc. 3</b></td>";
    tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Desc. 4</b></td>";
    tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Perc. IPI</b></td>";
    tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Data Entrega</b></td>";
    tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Referencia</b></td>";
    tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Excluir</b></td>";

    for (var i = 0; i < 700; i++) {
        if (vet[i][0] != 0) {
            tabela += "<tr id=linha" + i + ">"
            tabela += "<td class='borda'>" + vet[i][0] + "</td>";
            tabela += "<td class='borda'>" + vet[i][1] + "</td>";

            cod = 'a' + i;
            k = 2;
            val = vet[i][2];
            tabela += "<td class='borda' style='cursor: pointer'><input type='text' id='" + cod + "' name='" + cod + "' value='" + val + "' size='8' onBlur='convertField3(this);editar(" + i + "," + k + ",this.value" + ");' onKeyPress='return Tecla(event);'></td>";
            cod = 'b' + i;
            k = 3;
            val = vet[i][3];
            tabela += "<td class='borda' style='cursor: pointer'><input type='text' id='" + cod + "' name='" + cod + "' value='" + val + "' size='8' onBlur='convertField3(this);editar(" + i + "," + k + ",this.value" + ");' onKeyPress='return Tecla(event);'></td>";
            cod = 'c' + i;
            k = 4;
            val = vet[i][4];
            tabela += "<td class='borda' style='cursor: pointer'><input type='text' id='" + cod + "' name='" + cod + "' value='" + val + "' size='8' onBlur='convertField3(this);editar(" + i + "," + k + ",this.value" + ");' onKeyPress='return Tecla(event);'></td>";
            cod = 'd' + i;
            k = 5;
            val = vet[i][5];
            tabela += "<td class='borda' style='cursor: pointer'><input type='text' id='" + cod + "' name='" + cod + "' value='" + val + "' size='8' onBlur='convertField3(this);editar(" + i + "," + k + ",this.value" + ");' onKeyPress='return Tecla(event);'></td>";
            cod = 'e' + i;
            k = 6;
            val = vet[i][6];
            tabela += "<td class='borda' style='cursor: pointer'><input type='text' id='" + cod + "' name='" + cod + "' value='" + val + "' size='8' onBlur='convertField3(this);editar(" + i + "," + k + ",this.value" + ");' onKeyPress='return Tecla(event);'></td>";
            cod = 'f' + i;
            k = 7;
            val = vet[i][7];
            tabela += "<td class='borda' style='cursor: pointer'><input type='text' id='" + cod + "' name='" + cod + "' value='" + val + "' size='8' onBlur='convertField3(this);editar(" + i + "," + k + ",this.value" + ");' onKeyPress='return Tecla(event);'></td>";
            cod = 'g' + i;
            k = 8;
            val = vet[i][8];
            tabela += "<td class='borda' style='cursor: pointer'><input type='text' id='" + cod + "' name='" + cod + "' value='" + val + "' size='8' onBlur='convertField3(this);editar(" + i + "," + k + ",this.value" + ");' onKeyPress='return Tecla(event);'></td>";

            cod = 'h' + i;
            k = 9;
            val = vet[i][9];

            if (val == 0) {
                val = "";
            }
            tabela += "<td class='borda' style='cursor: pointer'><input type='text' id='" + cod + "' name='" + cod + "' value='" + val + "' size='8' onBlur='dataano(this,this.value);editar(" + i + "," + k + ",this.value" + ");' onKeyPress='formatar(" + '"##/##/####"' + ", this);' ></td>";

            tabela += "<td class='borda'>" + vet[i][10] + "</td>";

            tabela += "<td class='borda' style='cursor: pointer'><img src='imagens/delete.gif' onClick=apagar('" + vet[i][0] + "')></td>";


            tabela += "</tr>";
        }



    }


    tabela += "</table>"



    $("resultado").innerHTML = tabela;
    //$("resultado2").innerHTML=tabela2;
    tabela = null;

    //$("resultado").innerHTML="Nenhum registro encontrado...";

    calc();

}


function editar(a, b, c) {


    vet[a][b] = c;

    calc();

}

function apagar(a) {

    if (confirm("Tem certeza que deseja Excluir o item " + a + " ?")) {

        for (var i = 0; i < 700; i++) {
            if (vet[i][0] == a) {

                if (vet[i][11] == 1) {
                    alert("Este produto já tem baixas lançadas não pode ser excluído !");
                } else {

                    vet[i][0] = 0;
                    vet[i][1] = 0;
                    vet[i][2] = 0;
                    vet[i][3] = 0;
                    vet[i][4] = 0;
                    vet[i][5] = 0;
                    vet[i][6] = 0;
                    vet[i][7] = 0;
                    vet[i][8] = 0;
                    vet[i][9] = 0;
                    vet[i][10] = 0;
                    vet[i][11] = 0;

                }

                i = 700;
            }
        }
        imprime();

    }

}

function pesquisacodigo(valor) {

    trimjs(valor);
    valor = txt;
    if (valor == '') {
        return;
    }

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
        
        ajax2.open("POST", "pedcomprapesquisacusto.php", true);

        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax2.onreadystatechange = function () {
            if (ajax2.readyState == 1) {
            }
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLcodigo(ajax2.responseXML, valor);
                } else {
                    alert('Codigo do Produto não Encontrado!');

                }
            }
        }
        var params = "parametro=" + valor + "&parametro2=1";
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
            var profinal = item.getElementsByTagName("profinal")[0].firstChild.nodeValue;
            var proipi = item.getElementsByTagName("proipi")[0].firstChild.nodeValue;
            $("codigoproduto").value = codigo;
            $("produto").value = descricao;
            $("profinal").value = profinal;
            $("proipi").value = proipi;


            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes");
            //atribui um valor
            novo.value = cod;
            //atribui um texto
            novo.text = descricao;
            //finalmente adiciona o novo elemento
            document.forms[0].pesquisaproduto.options.add(novo);

            //document.forms[0].quant.focus();

        }
    } else {

        alert('Codigo do Produto não Encontrado!');

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

            ajax2.open("POST", "pedcomprapesquisacusto.php", true);

            ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            ajax2.onreadystatechange = function () {
                if (ajax2.readyState == 1) {
                    //idOpcao.innerHTML = "Carregando...!";
                }
                if (ajax2.readyState == 4) {
                    if (ajax2.responseXML) {
                        processXMLproduto(ajax2.responseXML, valor);
                    } else {
                        //idOpcao.innerHTML = "__________________________________________________";
                    }
                }
            }
            var params = "parametro=" + valor + "&parametro2=3";
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
            var profinal = item.getElementsByTagName("profinal")[0].firstChild.nodeValue;
            var proipi = item.getElementsByTagName("proipi")[0].firstChild.nodeValue;

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
                $("profinal").value = profinal;
                $("proipi").value = proipi;

            }

        }
        if (dataArray.length == 1) {
            // document.forms[0].quant.focus();
        }
    } else {

    }


}



function pesquisacod(valor) {

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
        
        ajax2.open("POST", "pedcomprapesquisacusto.php", true);

        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax2.onreadystatechange = function () {
            if (ajax2.readyState == 1) {
            }
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLcod(ajax2.responseXML, valor);
                } else {
                }
            }
        }
        var params = "parametro=" + valor + "&parametro2=2";
        ajax2.send(params);
    }
}
function processXMLcod(obj, valor) {
    var dataArray = obj.getElementsByTagName("dado");
    if (dataArray.length > 0) {
        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
            var profinal = item.getElementsByTagName("profinal")[0].firstChild.nodeValue;
            var proipi = item.getElementsByTagName("proipi")[0].firstChild.nodeValue;
            $("codigoproduto").value = codigo;
            $("produto").value = descricao;
            $("profinal").value = profinal;
            $("proipi").value = proipi;
        }
    } else {

    }
}



function pesquisaf(valor) {


    if (document.getElementById("opcao1").checked == true) {
        pesquisacodigofor(valor);
    } else if (document.getElementById("opcao2").checked == true) {
        pesquisafornecedores2(valor)
    } else {
        pesquisafornecedores(valor)
    }







}



function pesquisacodigofor(valor) {

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
        ajax2.open("POST", "fornecedorpesquisacodigo.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax2.onreadystatechange = function () {
            if (ajax2.readyState == 1) {
            }
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLcodigofor(ajax2.responseXML, valor);
                } else {
                    document.forms[0].pesquisafornecedor.options.length = 0;
                }
            }
        }
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXMLcodigofor(obj, valor) {

    var dataArray = obj.getElementsByTagName("dado");
    if (dataArray.length > 0) {

        document.forms[0].pesquisafornecedor.options.length = 0;

        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            var cod = item.getElementsByTagName("cod")[0].firstChild.nodeValue;
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            //$("codigofornecedor").value=codigo;
            //$("fornecedor").value=descricao;

            $("fornecedor").value = codigo;

            descricao = codigo + ' ' + descricao;

            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes");
            //atribui um valor
            novo.value = cod;
            //atribui um texto
            novo.text = descricao;
            //finalmente adiciona o novo elemento
            document.forms[0].pesquisafornecedor.options.add(novo);


        }
    } else {
        document.forms[0].pesquisafornecedor.options.length = 0;
    }


}



function pesquisafornecedores(valor) {
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

            document.forms[0].pesquisafornecedor.options.length = 1;
            //idOpcao  = document.getElementById("pesquisafornecedor");

            ajax2.open("POST", "fornecedorpesquisarazao.php", true);
            ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            ajax2.onreadystatechange = function () {
                if (ajax2.readyState == 1) {
                    //idOpcao.innerHTML = "Carregando...!";
                }
                if (ajax2.readyState == 4) {
                    if (ajax2.responseXML) {
                        processXMLfornecedor(ajax2.responseXML, valor);
                    } else {
                        document.forms[0].pesquisafornecedor.options.length = 0;
                    }
                }
            }
            var params = "parametro=" + valor;
            ajax2.send(params);
        }
    } else
    {
        document.forms[0].pesquisafornecedor.options.length = 0;
    }

}

function processXMLfornecedor(obj, valor) {


    var dataArray = obj.getElementsByTagName("dado");
    if (dataArray.length > 0) {

        document.forms[0].pesquisafornecedor.options.length = 0;

        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];

            var cod = item.getElementsByTagName("cod")[0].firstChild.nodeValue;
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            descricao = codigo + ' ' + descricao;

            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes");
            //atribui um valor
            novo.value = cod;
            //atribui um texto
            novo.text = descricao;
            //finalmente adiciona o novo elemento
            document.forms[0].pesquisafornecedor.options.add(novo);

            if (i == 0) {
                //$("codigofornecedor").value=codigo;
                //$("fornecedor").value=descricao;
                $("fornecedor").value = codigo;

            }

        }
        if (dataArray.length == 1) {
            //document.forms[0].quant.focus();
        }
    } else {
        document.forms[0].pesquisafornecedor.options.length = 0;
    }


}





function pesquisafornecedores2(valor) {
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

            document.forms[0].pesquisafornecedor.options.length = 1;
            //idOpcao  = document.getElementById("pesquisafornecedor");

            ajax2.open("POST", "fornecedorpesquisaguerra.php", true);
            ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            ajax2.onreadystatechange = function () {
                if (ajax2.readyState == 1) {
                    //idOpcao.innerHTML = "Carregando...!";
                }
                if (ajax2.readyState == 4) {
                    if (ajax2.responseXML) {
                        processXMLfornecedor2(ajax2.responseXML, valor);
                    } else {
                        document.forms[0].pesquisafornecedor.options.length = 0;
                    }
                }
            }
            var params = "parametro=" + valor;
            ajax2.send(params);
        }
    } else
    {
        document.forms[0].pesquisafornecedor.options.length = 0;
    }

}

function processXMLfornecedor2(obj, valor) {


    var dataArray = obj.getElementsByTagName("dado");
    if (dataArray.length > 0) {

        document.forms[0].pesquisafornecedor.options.length = 0;

        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];

            var cod = item.getElementsByTagName("cod")[0].firstChild.nodeValue;
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

            descricao = codigo + ' ' + descricao;

            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes");
            //atribui um valor
            novo.value = cod;
            //atribui um texto
            novo.text = descricao;
            //finalmente adiciona o novo elemento
            document.forms[0].pesquisafornecedor.options.add(novo);

            if (i == 0) {
                //$("codigofornecedor").value=codigo;
                //$("fornecedor").value=descricao;
                $("fornecedor").value = codigo;

            }

        }
        if (dataArray.length == 1) {
            //document.forms[0].quant.focus();
        }
    } else {
        document.forms[0].pesquisafornecedor.options.length = 0;
    }


}




function pesquisacodfor(valor) {

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
        ajax2.open("POST", "fornecedorpesquisacod2.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax2.onreadystatechange = function () {
            if (ajax2.readyState == 1) {
            }
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXMLcodfor(ajax2.responseXML, valor);
                } else {
                }
            }
        }
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}
function processXMLcodfor(obj, valor) {
    var dataArray = obj.getElementsByTagName("dado");
    if (dataArray.length > 0) {
        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
            var descricao2 = item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;

            //$("codigofornecedor").value=codigo;
            //$("fornecedor").value=descricao;

            $("fornecedor").value = codigo;

            if (document.getElementById("opcao1").checked == true) {
                $("codigofornecedor").value = codigo;
            } else if (document.getElementById("opcao2").checked == true) {
                $("codigofornecedor").value = descricao2;
            } else {
                $("codigofornecedor").value = descricao;
            }

            if (document.getElementById("acao").value == 'inserir') {
                dadospesquisa(codigo);
            }

        }
    } else {

    }
}

function calc() {


    var total;
    var totalitem;
    var totalitem2;
    var desc1;
    var desc2;
    var desc3;
    var desc4;
    var ipi;

    var comissao;

    total = 0;
    totalitem = 0;
    totalitem2 = 0;
    desc1 = 0;
    desc2 = 0;
    desc3 = 0;
    desc4 = 0;
    ipi = 0;

    trimjs($("comissao").value);

    if (txt == '') {
        txt = 100
    }
    if (txt == '0') {
        txt = 100
    }

    comissao = txt;

    for (var i = 0; i < 700; i++) {
        if (vet[i][0] != 0) {


            totalitem = vet[i][2] * vet[i][3];

            desc1 = totalitem / 100 * vet[i][4];
            totalitem = totalitem - desc1;
            desc2 = totalitem / 100 * vet[i][5];
            totalitem = totalitem - desc2;
            desc3 = totalitem / 100 * vet[i][6];
            totalitem = totalitem - desc3;
            desc4 = totalitem / 100 * vet[i][7];
            totalitem = totalitem - desc4;

            totalitem2 = totalitem / 100 * comissao;

            ipi = ipi + (totalitem2 / 100 * vet[i][8]);


            totalitem = totalitem + (totalitem2 / 100 * vet[i][8]);

            total = total + totalitem;

        }
    }

    total = (total.toFixed(2));
    $("pctotal").value = total;

    ipi = (ipi.toFixed(2));
    $("ipi").value = ipi;

    calc3();

}


function calc2() {

    var valor;
    var valor2;
    var perc;
    var desc;
    valor = $("pctotal").value;
    perc = $("percdesc").value;
    desc = 0;

    desc = (valor / 100 * perc);
    desc = (desc.toFixed(2));
    $("pcdesconto").value = desc;

    valor2 = valor - desc;

    valor2 = (valor2.toFixed(2));
    $("pctotal2").value = valor2;

}

function calc3() {

    var valor;
    var valor2;
    var perc;
    var desc;
    valor = $("pctotal").value;
    perc = 0;
    desc = $("pcdesconto").value;
    ;

    if (valor > 0) {

        perc = desc * 100 / valor;
        perc = (perc.toFixed(4));
        $("percdesc").value = perc;
    } else {
        $("percdesc").value = 0;
    }


    valor2 = valor - desc;

    valor2 = (valor2.toFixed(2));
    $("pctotal2").value = valor2;

}

function tipodata(x) {

    if (x == 2) {
        $("dia1").style.visibility = "hidden";
        $("dia2").style.visibility = "hidden";
        $("dia3").style.visibility = "hidden";
        $("dia4").style.visibility = "hidden";
        $("dia5").style.visibility = "hidden";
        $("dia6").style.visibility = "hidden";

        $("pvdata1").style.visibility = "visible";
        $("pvdata2").style.visibility = "visible";
        $("pvdata3").style.visibility = "visible";
        $("pvdata4").style.visibility = "visible";
        $("pvdata5").style.visibility = "visible";
        $("pvdata6").style.visibility = "visible";

    } else
    {
        $("dia1").style.visibility = "visible";
        $("dia2").style.visibility = "visible";
        $("dia3").style.visibility = "visible";
        $("dia4").style.visibility = "visible";
        $("dia5").style.visibility = "visible";
        $("dia6").style.visibility = "visible";

        $("pvdata1").style.visibility = "hidden";
        $("pvdata2").style.visibility = "hidden";
        $("pvdata3").style.visibility = "hidden";
        $("pvdata4").style.visibility = "hidden";
        $("pvdata5").style.visibility = "hidden";
        $("pvdata6").style.visibility = "hidden";

    }




}




function parcelas(parc) {

    if (parc > 6) {
        alert("O número de parcelas não pode ser maior que 6!")
    } else
    {

        $("parc1").disabled = true;
        $("parc2").disabled = true;
        $("parc3").disabled = true;
        $("parc4").disabled = true;
        $("parc5").disabled = true;
        $("parc6").disabled = true;

        $("dia1").disabled = true;
        $("dia2").disabled = true;
        $("dia3").disabled = true;
        $("dia4").disabled = true;
        $("dia5").disabled = true;
        $("dia6").disabled = true;

        $("pvdata1").disabled = true;
        $("pvdata2").disabled = true;
        $("pvdata3").disabled = true;
        $("pvdata4").disabled = true;
        $("pvdata5").disabled = true;
        $("pvdata6").disabled = true;

        if (parc >= 1) {
            $("parc1").disabled = false;
            $("dia1").disabled = false;
            $("pvdata1").disabled = false;
        } else {
            {
                $("parc1").value = '';
                $("dia1").value = '';
                $("pvdata1").value = '';
            }
        }
        if (parc >= 2) {
            $("parc2").disabled = false;
            $("dia2").disabled = false;
            $("pvdata2").disabled = false;
        } else {
            {
                $("parc2").value = '';
                $("dia2").value = '';
                $("pvdata2").value = '';
            }
        }
        if (parc >= 3) {
            $("parc3").disabled = false;
            $("dia3").disabled = false;
            $("pvdata3").disabled = false;
        } else {
            {
                $("parc3").value = '';
                $("dia3").value = '';
                $("pvdata3").value = '';
            }
        }
        if (parc >= 4) {
            $("parc4").disabled = false;
            $("dia4").disabled = false;
            $("pvdata4").disabled = false;
        } else {
            {
                $("parc4").value = '';
                $("dia4").value = '';
                $("pvdata4").value = '';
            }
        }
        if (parc >= 5) {
            $("parc5").disabled = false;
            $("dia5").disabled = false;
            $("pvdata5").disabled = false;
        } else {
            {
                $("parc5").value = '';
                $("dia5").value = '';
                $("pvdata5").value = '';
            }
        }
        if (parc >= 6) {
            $("parc6").disabled = false;
            $("dia6").disabled = false;
            $("pvdata6").disabled = false;
        } else {
            {
                $("parc6").value = '';
                $("dia6").value = '';
                $("pvdata6").value = '';
            }
        }

        var valor = $("pctotal2").value;
        var saida = '';

        for (i = 0; i < valor.length; i++)
        {

            letra = valor.substring(i, i + 1);


            codigo = letra.charCodeAt(0)


            if (codigo == 44) {
                codigo = 46;
            }


            letra = String.fromCharCode(codigo);

            saida = saida + letra

        }

        valor = saida;
        valor = valor * 100;
        var pararcelasx = parseInt(valor / parc);
        var pararcelasy = pararcelasx * parc;
        pararcelasx = pararcelasx / 100;
        var dife = (valor - pararcelasy);

        dife = (Math.round(dife)) / 100;

        var pararcelasx1 = pararcelasx;
        if (dife > 0) {
            pararcelasx1 = pararcelasx + dife;
            pararcelasx1 = pararcelasx1 * 100;
            pararcelasx1 = (Math.round(pararcelasx1)) / 100;
        }


        if (parc >= 1) {
            $("parc1").value = pararcelasx1;
        }
        if (parc >= 2) {
            $("parc2").value = pararcelasx;
        }
        if (parc >= 3) {
            $("parc3").value = pararcelasx;
        }
        if (parc >= 4) {
            $("parc4").value = pararcelasx;
        }
        if (parc >= 5) {
            $("parc5").value = pararcelasx;
        }
        if (parc >= 6) {
            $("parc6").value = pararcelasx;
        }

        if ($("dia1").disabled == false) {
            if ($("dia1").style.visibility == "visible") {
                document.getElementById("dia1").focus();
            }
        }
        if ($("pvdata1").disabled == false) {
            if ($("pvdata1").style.visibility == "visible") {
                document.getElementById("pvdata1").focus();
            }
        }



    }

}
















function max() {


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

        ajax2.open("POST", "pedcomprapesquisamax.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {

            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {

            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML) {
                    processXMLmax(ajax2.responseXML);
                } else
                {
                    ///MOZILA

                    $("pcnumero").value = '1';

                }
            }
        }
        //passa o parametro
        var params = "parametro=0";
        ajax2.send(params);
    }

}


function processXMLmax(obj) {


    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados


        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML

            var pcnumero = item.getElementsByTagName("pcnumero")[0].firstChild.nodeValue;

            trimjs(pcnumero);
            pcnumero = txt;

            pcnumero++;

            $("pcnumero").value = pcnumero;

        }
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo

        $("pcnumero").value = '1';
    }

    document.getElementById("pcemissao").focus();

}




function incluir() {

    var codigoproduto = document.forms[0].codigoproduto.value;

    var quantidade = document.forms[0].quantidade.value;

    trimjs(quantidade);
    if (txt == '') {
        alert('Digite a Quantidade');
        document.getElementById("quantidade").focus();
        return;
    }

    if (txt == '0') {
        alert('Digite a Quantidade');
        $("quantidade").value = '';
        document.getElementById("quantidade").focus();
        return;
    }

    quantidade = Math.round(quantidade);
    $("quantidade").value = quantidade;
    if ($("quantidade").value == "NaN") {
        alert('Quantidade Inválida');
        $("quantidade").value = '';
        document.getElementById("quantidade").focus();
        return;
    }



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

        ajax2.open("POST", "pedcomprapesquisaitem.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {

            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {

            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML) {
                    processXMLitem(ajax2.responseXML);
                } else
                {
                    //MOZILA


                }
            }
        }
        //passa o parametro
        var params = "parametro=" + codigoproduto;
        ajax2.send(params);
    }

}


function processXMLitem(obj) {
    var forcod = 0;
    var proref = '';
    var provalida = 0;
    var stpcodigo = 0;

    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados


        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML

            forcod = item.getElementsByTagName("forcod")[0].firstChild.nodeValue;
            proref = item.getElementsByTagName("proref")[0].firstChild.nodeValue;
            provalida = item.getElementsByTagName("provalida")[0].firstChild.nodeValue;
            stpcodigo = item.getElementsByTagName("stpcodigo")[0].firstChild.nodeValue;

            trimjs(forcod);
            forcod = txt;
            trimjs(proref);
            proref = txt;

        }
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo

    }

    //alert(forcod);

    incluir2(forcod, proref, provalida, stpcodigo);

}





function pvenda(x) {

    if (x == 2 || x == 3) {
        document.getElementById("venda").disabled = false;
    } else
    {
        document.getElementById("venda").value = '';
        document.getElementById("venda").disabled = true;
    }

}




function vervenda() {




    var pvnumero = document.forms[0].venda.value;

    trimjs(pvnumero);

    if (txt == '') {
        return;
    }

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

        ajax2.open("POST", "pedcomprapesquisavenda.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {

            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {

            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML) {
                    processXMLvenda(ajax2.responseXML);
                } else
                {
                    ///MOZILA
                    //alert("Pedido não existe!");

                }
            }
        }
        //passa o parametro
        var params = "parametro=" + pvnumero;
        ajax2.send(params);
    }

}


function processXMLvenda(obj) {


    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {

        //percorre o arquivo XML paara extrair os dados


        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML

            var pvnumero = item.getElementsByTagName("pvnumero")[0].firstChild.nodeValue;

            if (pvnumero == "N") {
                alert('Pedido não encontrado!');
            }



        }

    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo
    }


}

function entrega(a) {

    trimjs(document.getElementById('pcentrega').value);
    if (txt == '') {
        alert('Digite a data de entrega!');
        return;
    }
    if (valida_data('pcentrega') == false) {
        return;
    }
    ;


    if (confirm("Confirma a atualização das datas de entrega?")) {

        for (var i = 0; i < 700; i++) {
            vet[i][9] = txt;
        }
        imprime();

    }

}


function dadospesquisa(valor) {

    //alert(valor);

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

        ajax2.open("POST", "condicaopagtopesquisa.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {

            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {
                    processXML01(ajax2.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                    //idOpcao.innerHTML = "____________________";

                    vdesc1 = 0;
                    vdesc2 = 0;
                    vdesc3 = 0;
                    vdesc4 = 0;
                    vdesc5 = 0;
                    vdesc6 = 0;
                    vipi = 0;
                    vicm = 0;


                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;

        ajax2.send(params);
    }
}

function processXML01(obj) {

    $("dia1").value = "";
    $("dia2").value = "";
    $("dia3").value = "";
    $("dia4").value = "";
    $("dia5").value = "";
    $("dia6").value = "";

    $("pvdata1").value = "";
    $("pvdata2").value = "";
    $("pvdata3").value = "";
    $("pvdata4").value = "";
    $("pvdata5").value = "";
    $("pvdata6").value = "";

    $("dia1").disabled = true;
    $("dia2").disabled = true;
    $("dia3").disabled = true;
    $("dia4").disabled = true;
    $("dia5").disabled = true;
    $("dia6").disabled = true;

    $("pvdata1").disabled = true;
    $("pvdata2").disabled = true;
    $("pvdata3").disabled = true;
    $("pvdata4").disabled = true;
    $("pvdata5").disabled = true;
    $("pvdata6").disabled = true;

    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados

        //document.forms[0].listDados.options.length = 0;

        for (var i = 0; i < dataArray.length; i++) {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var cpgcodigo = item.getElementsByTagName("cpgcodigo")[0].firstChild.nodeValue;
            var desc1 = item.getElementsByTagName("desc1")[0].firstChild.nodeValue;
            var desc2 = item.getElementsByTagName("desc2")[0].firstChild.nodeValue;
            var desc3 = item.getElementsByTagName("desc3")[0].firstChild.nodeValue;
            var desc4 = item.getElementsByTagName("desc4")[0].firstChild.nodeValue;
            var desc5 = item.getElementsByTagName("desc5")[0].firstChild.nodeValue;
            var desc6 = item.getElementsByTagName("desc6")[0].firstChild.nodeValue;
            var ipi = item.getElementsByTagName("ipi")[0].firstChild.nodeValue;
            var comissao = item.getElementsByTagName("comissao")[0].firstChild.nodeValue;
            var icm = item.getElementsByTagName("icm")[0].firstChild.nodeValue;
            var tipo = item.getElementsByTagName("tipo")[0].firstChild.nodeValue;
            var parcelas = item.getElementsByTagName("parcelas")[0].firstChild.nodeValue;
            var tipoparcelas = item.getElementsByTagName("tipoparcelas")[0].firstChild.nodeValue;
            var parcdata1 = item.getElementsByTagName("parcdata1")[0].firstChild.nodeValue;
            var parcdata2 = item.getElementsByTagName("parcdata2")[0].firstChild.nodeValue;
            var parcdata3 = item.getElementsByTagName("parcdata3")[0].firstChild.nodeValue;
            var parcdata4 = item.getElementsByTagName("parcdata4")[0].firstChild.nodeValue;
            var parcdata5 = item.getElementsByTagName("parcdata5")[0].firstChild.nodeValue;
            var parcdata6 = item.getElementsByTagName("parcdata6")[0].firstChild.nodeValue;
            var parcdia1 = item.getElementsByTagName("parcdia1")[0].firstChild.nodeValue;
            var parcdia2 = item.getElementsByTagName("parcdia2")[0].firstChild.nodeValue;
            var parcdia3 = item.getElementsByTagName("parcdia3")[0].firstChild.nodeValue;
            var parcdia4 = item.getElementsByTagName("parcdia4")[0].firstChild.nodeValue;
            var parcdia5 = item.getElementsByTagName("parcdia5")[0].firstChild.nodeValue;
            var parcdia6 = item.getElementsByTagName("parcdia6")[0].firstChild.nodeValue;

            trimjs(cpgcodigo);
            cpgcodigo = txt;
            trimjs(desc1);
            desc1 = txt;
            trimjs(desc2);
            desc2 = txt;
            trimjs(desc3);
            desc3 = txt;
            trimjs(desc4);
            desc4 = txt;
            trimjs(desc5);
            desc5 = txt;
            trimjs(desc6);
            desc6 = txt;

            trimjs(ipi);
            ipi = txt;
            trimjs(comissao);
            comissao = txt;
            trimjs(icm);
            icm = txt;
            trimjs(tipo);
            tipo = txt;


            trimjs(tipoparcelas);
            if (txt == '0') {
                txt = '';
            }
            ;
            tipoparcelas = txt;
            trimjs(parcelas);
            if (txt == '0') {
                txt = '';
            }
            ;
            parcelas = txt;
            trimjs(parcdia1);
            if (txt == '0') {
                txt = '';
            }
            ;
            parcdia1 = txt;
            trimjs(parcdia2);
            if (txt == '0') {
                txt = '';
            }
            ;
            parcdia2 = txt;
            trimjs(parcdia3);
            if (txt == '0') {
                txt = '';
            }
            ;
            parcdia3 = txt;
            trimjs(parcdia4);
            if (txt == '0') {
                txt = '';
            }
            ;
            parcdia4 = txt;
            trimjs(parcdia5);
            if (txt == '0') {
                txt = '';
            }
            ;
            parcdia5 = txt;
            trimjs(parcdia6);
            if (txt == '0') {
                txt = '';
            }
            ;
            parcdia6 = txt;
            trimjs(parcdata1);
            if (txt == '0') {
                txt = '';
            }
            ;
            parcdata1 = txt;
            trimjs(parcdata2);
            if (txt == '0') {
                txt = '';
            }
            ;
            parcdata2 = txt;
            trimjs(parcdata3);
            if (txt == '0') {
                txt = '';
            }
            ;
            parcdata3 = txt;
            trimjs(parcdata4);
            if (txt == '0') {
                txt = '';
            }
            ;
            parcdata4 = txt;
            trimjs(parcdata5);
            if (txt == '0') {
                txt = '';
            }
            ;
            parcdata5 = txt;
            trimjs(parcdata6);
            if (txt == '0') {
                txt = '';
            }
            ;
            parcdata6 = txt;


            //cria um novo option dinamicamente
            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes");
            //atribui um valor
            novo.value = cpgcodigo;
            //atribui um texto
            //novo.text  = descricao;
            //finalmente adiciona o novo elemento
            //document.forms[0].listDados.options.add(novo);

            if (i == 0) {

                $("codigo").value = cpgcodigo;

                //$("desc1").value=desc1;
                //$("desc2").value=desc2;
                //$("desc3").value=desc3;
                //$("desc4").value=desc4;
                //$("desc5").value=desc5;
                //$("desc6").value=desc6;

                //$("ipi").value=ipi;
                $("comissao").value = comissao;
                //$("icm").value=icm;				


                vdesc1 = desc1;
                vdesc2 = desc2;
                vdesc3 = desc3;
                vdesc4 = desc4;
                vdesc5 = desc5;
                vdesc6 = desc6;
                vipi = ipi;
                vicm = icm;


                if (tipo == 1) {
                    document.getElementById("radiob1").checked = true;
                } else if (tipo == 2) {
                    document.getElementById("radiob2").checked = true;
                } else {
                    document.getElementById("radiob3").checked = true;
                }


                $("pvparcelas").value = parcelas;

                if (tipoparcelas == 1) {

                    document.getElementById("pvtipo1").checked = true;

                    $("dia1").style.visibility = "visible";
                    $("dia2").style.visibility = "visible";
                    $("dia3").style.visibility = "visible";
                    $("dia4").style.visibility = "visible";
                    $("dia5").style.visibility = "visible";
                    $("dia6").style.visibility = "visible";

                    $("pvdata1").style.visibility = "hidden";
                    $("pvdata2").style.visibility = "hidden";
                    $("pvdata3").style.visibility = "hidden";
                    $("pvdata4").style.visibility = "hidden";
                    $("pvdata5").style.visibility = "hidden";
                    $("pvdata6").style.visibility = "hidden";

                    if (parcelas >= 1) {
                        $("dia1").value = parcdia1;
                        $("dia1").disabled = false;
                    }
                    if (parcelas >= 2) {
                        $("dia2").value = parcdia2;
                        $("dia2").disabled = false;
                    }
                    if (parcelas >= 3) {
                        $("dia3").value = parcdia3;
                        $("dia3").disabled = false;
                    }
                    if (parcelas >= 4) {
                        $("dia4").value = parcdia4;
                        $("dia4").disabled = false;
                    }
                    if (parcelas >= 5) {
                        $("dia5").value = parcdia5;
                        $("dia5").disabled = false;
                    }
                    if (parcelas >= 6) {
                        $("dia6").value = parcdia6;
                        $("dia6").disabled = false;
                    }

                } else {

                    document.getElementById("pvtipo2").checked = true;

                    $("dia1").style.visibility = "hidden";
                    $("dia2").style.visibility = "hidden";
                    $("dia3").style.visibility = "hidden";
                    $("dia4").style.visibility = "hidden";
                    $("dia5").style.visibility = "hidden";
                    $("dia6").style.visibility = "hidden";

                    $("pvdata1").style.visibility = "visible";
                    $("pvdata2").style.visibility = "visible";
                    $("pvdata3").style.visibility = "visible";
                    $("pvdata4").style.visibility = "visible";
                    $("pvdata5").style.visibility = "visible";
                    $("pvdata6").style.visibility = "visible";

                    if (parcelas >= 1) {
                        $("pvdata1").value = parcdata1;
                        $("pvdata1").disabled = false;
                    }
                    if (parcelas >= 2) {
                        $("pvdata2").value = parcdata2;
                        $("pvdata2").disabled = false;
                    }
                    if (parcelas >= 3) {
                        $("pvdata3").value = parcdata3;
                        $("pvdata3").disabled = false;
                    }
                    if (parcelas >= 4) {
                        $("pvdata4").value = parcdata4;
                        $("pvdata4").disabled = false;
                    }
                    if (parcelas >= 5) {
                        $("pvdata5").value = parcdata5;
                        $("pvdata5").disabled = false;
                    }
                    if (parcelas >= 6) {
                        $("pvdata6").value = parcdata6;
                        $("pvdata6").disabled = false;
                    }

                }






            }

        }
    } else {

        vdesc1 = 0;
        vdesc2 = 0;
        vdesc3 = 0;
        vdesc4 = 0;
        vdesc5 = 0;
        vdesc6 = 0;
        vipi = 0;
        vicm = 0;

    }
}


function importarPedido()
{

    novaJanela("telauploadarquivoscompras.php", "UPLOAD DE ARQUIVOS")

}


function novaJanela(href, t)
{


    $a.GB_show(href,
            {
                //height: (document.body.scrollHeight - 80),
                //width: (document.body.scrollWidth - 30),

                height: (550),
                width: (1000),

                animation: true,
                overlay_clickable: false,
                callback: callback,
                caption: t
            });


    $a('#dialog').dialog("open");


}

function  callback()
{

    //Chama  a importação
    importarPedidoOK();

}


function importarPedidoOK()
{

    titulo = "PROCESSANDO, AGUARDE...";
    mensagem = "EXECUTANDO IMPORTAÇÃO EXCEL.";

    $a("#retorno").messageBoxModal(titulo, mensagem);

    var usuario = $("usuario").value;
    if (usuario == '') {
        usuario = 0
    }
    new ajax('uploadexcelcompra.php?usuario=' + usuario, {onComplete: importa_pedido});
}

function importa_pedido(request) {

    var data = request.responseText;

    pedido = new Object();
    retorno = eval('(' + data + ')');

    if (retorno.mensagem == 'FALHA NA IMPORTACAO DE PEDIDO') {

        $a.unblockUI();

        alert(retorno.mensagem);
    } else {

        $("importaPedido").disabled = true;

        pedido = retorno.pedido;
        itensPedido = retorno.itensPedido;


        var tipolocal = pedido.tipolocal;

        if (tipolocal == 'VIX') {
            $("radioa4").checked = true;
        } else if (tipolocal == 'LOJA (2)') {
            $("radioa2").checked = true;
        } else if (tipolocal == 'LOJA NOVA (1)') {
            $("radioa1").checked = true;
        } else if (tipolocal == 'CD SP') {
            $("radioa5").checked = true;
        } else {
            $("radioa3").checked = true;
        }


        //Zera antes de importar
        for (var i = 0; i < 700; i++) {
            vet[i][0] = 0;
            vet[i][1] = 0;
            vet[i][2] = 0;
            vet[i][3] = 0;
            vet[i][4] = 0;
            vet[i][5] = 0;
            vet[i][6] = 0;
            vet[i][7] = 0;
            vet[i][8] = 0;
            vet[i][9] = 0;
            vet[i][10] = 0;
            vet[i][11] = 0;
        }


        pro = 0;

        $a.each(itensPedido, function (key, value)
        {



            var procodigo = value.produto.procodigo;

            var procod = value.produto.procod;

            var prodesc = value.produto.prnome;

            var protabela = value.pvitippr;

            var propreco = Math.abs(value.pvipreco).toFixed(2);

            var proqtd = value.pvisaldo;

            var desc1 = Math.abs(value.valDesconto1).toFixed(2);
            var desc2 = Math.abs(value.valDesconto2).toFixed(2);
            var desc3 = Math.abs(value.valDesconto3).toFixed(2);
            var desc4 = Math.abs(value.valDesconto4).toFixed(2);
            var ipi = Math.abs(value.valIpi).toFixed(2);
            //var entrega = value.datEntrega;
            var entrega = $("pcentrega").value;

            //var profor=value.produto.fornecedor.forcodigo;				
            var profor = value.produto.proref;

            var prototal = Math.abs(propreco * proqtd).toFixed(2);

            vet[pro][0] = procod;
            vet[pro][1] = prodesc;
            vet[pro][9] = entrega;
            vet[pro][3] = propreco;
            vet[pro][2] = proqtd;
            vet[pro][4] = desc1;
            vet[pro][5] = desc2;
            vet[pro][6] = desc3;
            vet[pro][7] = desc4;
            vet[pro][8] = ipi;
            vet[pro][10] = profor;
            vet[pro][11] = 0;

            /*
             vetordados[pro][0]=procodigo;
             vetordados[pro][1]=procod;
             vetordados[pro][2]=prodesc;
             vetordados[pro][3]=protabela;
             vetordados[pro][4]=proqtd;
             vetordados[pro][5]=propreco;
             vetordados[pro][6]=prototal;
             vetordados[pro][7]=profor;
             */


            pro = pro + 1;

        });

        imprime();

        $a.unblockUI();

        alert(retorno.mensagem);
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
            return false;
    }
}