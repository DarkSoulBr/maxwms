var txt;

var x1;
var x2;
var x3;
var x4;

var cep1;
var cep2;
var cep3;


var texto;
var teclax;

var press;
press = 1;

function numjs(texto) {

    var i;
    i = 0;

    var Resultado = '';

    for (i = 0; i < texto.length; i++)
    {

        if (isNaN(texto.substr(i, 1)) == false) {
            Resultado = Resultado + texto.substr(i, 1);
        }
    }

    Resultado++;

    var string = "" + Resultado;

    txt = string.substr(0, (string.length - 1)) + "-" + string.substr((string.length - 1), (string.length));

}

function trimjs(texto) {

    var i;
    i = 0;

    var String = texto;
    var Resultado = texto;

    if (Resultado.charCodeAt(2 - 1) == '32') {
    }

    while (Resultado.charCodeAt(0) == '32') {
        Resultado = String.substring(i, String.length);
        i++;
    }

    while (Resultado.charCodeAt(Resultado.length - 1) == "32") {
        Resultado = Resultado.substring(0, Resultado.length - 1);
    }

    txt = Resultado;

}



function exemplo()
{

//window.event.which = 89;

    window.event.keyCode = 89;
//window.var_evento.charCode = 89;

//e=window.event
//source=e.target?e.target:e.srcElement

//var tecla = window.event.keyCode;

//var tecla = e.keyCode;

//window.status = "Você pressionou a tecla: " + String.fromCharCode(tecla);
//alert("O Código da tecla pressionada é: " + tecla);

//e.keyCode = 89;

//keyChar.charCodeAt(0) = 89;

//window.charCodeAt = 89;

}


function isnumeric(event) {
    var code;
    if (navigator.appName == "Microsoft Internet Explorer") {
        code = event.keyCode;
    } else { // Netscape
        var keyChar = String.fromCharCode(event.which);
        code = keyChar.charCodeAt(0);
    }
    if (code > 47 && code < 58) { // nmeros
        return true;
    } else {
        if ((code > 64 && code < 91) || // letras A a Z
                (code > 96 && code < 123) || // letras a a z 
                (code == 231) || (code == 199) || //  e 
                (code == 180) || (code == 168) || // '' e ''
                (code > 31 && code < 48) || // pontuaes
                (code > 57 && code < 65) || // pontuaes
                (code > 90 && code < 97) || // pontuaes
                (code > 122 && code < 127))  	// pontuaes
            return false;
        else
            return true;
    }
}




function Tecla(e) {

    if (document.all) // Internet Explorer
        var tecla = event.keyCode;
    else if (document.layers) // Nestcape
        var tecla = e.which;

    if (tecla > 47 && tecla < 58) // 47 58 numeros de 0 a 9  
        return true;
    else
    {
        if (tecla == 8) // backspace
            return true;
        else if (tecla == 44) // se virgula em ponto
            event.keyCode = 46;
        else if (tecla == 46) // ponto
            return true;
        else
            event.keyCode = 0;

    }
}





function maiusculo()
{

    if (navigator.appName == "Microsoft Internet Explorer") {
///Alterar ç para c /// & e

        //var tecla = String.fromCharCode(codigo);

        var codigo = event.keyCode;

        if (codigo == 38) { 	//OK
            event.keyCode = 101; 		//& e
        }

        if (codigo >= 33 && codigo <= 37) { 	//OK
            return true;
        }
        if (codigo >= 39 && codigo <= 96) { 	//OK
            return true;
        }
        if (codigo >= 123 && codigo <= 191) {	//OK
            return true;
        }
        if (codigo >= 97 && codigo <= 122) { 	//minusculas

            codigo = (codigo - 32);
            event.keyCode = codigo;
        }

        if (codigo == 231) {

            event.keyCode = 67; 		//Ç
        }

        if (codigo >= 192 && codigo <= 198) {
            event.keyCode = 65;		//A
        }
        if (codigo == 199) {			//Ç
            event.keyCode = 67;
        }
        if (codigo >= 200 && codigo <= 203) {   //E
            event.keyCode = 69;
        }
        if (codigo >= 204 && codigo <= 207) {   //I
            event.keyCode = 73;
        }
        if (codigo >= 210 && codigo <= 214) {   //O
            event.keyCode = 79;
        }
        if (codigo >= 217 && codigo <= 220) {   //U
            event.keyCode = 85;
        }


        if (codigo >= 224 && codigo <= 230) {
            event.keyCode = 65;		//A
        }
        if (codigo == 231) {			//Ç
            event.keyCode = 199;
        }
        if (codigo >= 232 && codigo <= 235) {   //E
            event.keyCode = 69;
        }
        if (codigo >= 236 && codigo <= 240) {   //I
            event.keyCode = 73;
        }
        if (codigo >= 242 && codigo <= 246) {   //O
            event.keyCode = 79;
        }
        if (codigo >= 249 && codigo <= 252) {   //U
            event.keyCode = 85;
        } else
        {
            var tecla = codigo;
        }

    }

}



function MostraCombo()
{
    qtdSelect = document.getElementsByTagName("select");
    for (i = 0; i < qtdSelect.length; i++)
    {
        objSelect = qtdSelect[i];
        objSelect.style.visibility = "visible";
    }

//OK
//document.getElementById("X").style.display = "none";
//document.getElementById("X").style.height = "1";
//document.getElementById("X").style.width = "0";
//document.getElementById("X").style.visibility = "hidden";
//OK



//document.getElementById("opcoesx").focus();
//qtdSelect = document.getelementbyid("X");
//for (i = 0; i < qtdSelect.length; i++)
//{
//    objSelect = qtdSelect[i];
    // objSelect.style.visibility = "hidden";
//    document.x.objSelect.setAttribute("size","1");
//   }

}

function EscondeCombo()
{
    qtdSelect = document.getElementsByTagName("select");
    for (i = 0; i < qtdSelect.length; i++)
    {
        objSelect = qtdSelect[i];
        objSelect.style.visibility = "hidden";
    }
}

function valida_data(campo) {
    var date = document.getElementById(campo).value;
    var array_data = new Array;
    var ExpReg = new RegExp("(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}");
    //vetor que contem o dia o mes e o ano
    array_data = date.split("/");
    erro = false;
    //Valido se a data esta no formato dd/mm/yyyy e se o dia tem 2 digitos e esta entre 01 e 31
    //se o mes tem d2 digitos e esta entre 01 e 12 e o ano se tem 4 digitos e esta entre 1000 e 2999
    if (date.search(ExpReg) == -1)
        erro = true;
    //Valido os meses que nao tem 31 dias com execao de fevereiro
    else if (((array_data[1] == 4) || (array_data[1] == 6) || (array_data[1] == 9) || (array_data[1] == 11)) && (array_data[0] > 30))
        erro = true;
    //Valido o mes de fevereiro
    else if (array_data[1] == 2) {
        //Valido ano que nao e bissexto
        if ((array_data[0] > 28) && ((array_data[2] % 4) != 0))
            erro = true;
        //Valido ano bissexto
        if ((array_data[0] > 29) && ((array_data[2] % 4) == 0))
            erro = true;
    }
    if (erro) {
        alert("Data Invalida");
        document.getElementById(campo).focus();
        return false;
    } else {
        return true;
    }
}



function valida_data2(campo) {
    var date = document.getElementById(campo).value;

    trimjs(date);
    if (txt == '') {
        return true;
    }

    var array_data = new Array;
    var ExpReg = new RegExp("(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}");
    //vetor que contem o dia o mes e o ano
    array_data = date.split("/");
    erro = false;
    //Valido se a data esta no formato dd/mm/yyyy e se o dia tem 2 digitos e esta entre 01 e 31
    //se o mes tem d2 digitos e esta entre 01 e 12 e o ano se tem 4 digitos e esta entre 1000 e 2999
    if (date.search(ExpReg) == -1)
        erro = true;
    //Valido os meses que nao tem 31 dias com execao de fevereiro
    else if (((array_data[1] == 4) || (array_data[1] == 6) || (array_data[1] == 9) || (array_data[1] == 11)) && (array_data[0] > 30))
        erro = true;
    //Valido o mes de fevereiro
    else if (array_data[1] == 2) {
        //Valido ano que nao e bissexto
        if ((array_data[0] > 28) && ((array_data[2] % 4) != 0))
            erro = true;
        //Valido ano bissexto
        if ((array_data[0] > 29) && ((array_data[2] % 4) == 0))
            erro = true;
    }
    if (erro) {
        alert("Data Invalida");
        document.getElementById(campo).focus();
        return false;
    } else {
        return true;
    }
}


//OK
//document.getElementById("X").style.display = "yes";
//document.getElementById("X").style.height = "10";
//document.getElementById("X").style.width = "100";
//document.getElementById("X").style.visibility = "visible";
//OK


//qtdSelect = document.getelementbyid("X");
//for (i = 0; i < qtdSelect.length; i++)
//{
//    objSelect = qtdSelect[i];
//objSelect.style.visibility = "visible";
//    objSelect.setAttribute("size","10");
//   }




String.PAD_LEFT = 0;
String.PAD_RIGHT = 1;
String.PAD_BOTH = 2;

String.prototype.pad = function (size, pad, side) {
    var str = this, append = "", size = (size - str.length);
    var pad = ((pad != null) ? pad : " ");
    if ((typeof size != "number") || ((typeof pad != "string") || (pad == ""))) {
        throw new Error("Wrong parameters for String.pad() method.");
    }
    if (side == String.PAD_BOTH) {
        str = str.pad((Math.floor(size / 2) + str.length), pad, String.PAD_LEFT);
        return str.pad((Math.ceil(size / 2) + str.length), pad, String.PAD_RIGHT);
    }
    while ((size -= pad.length) > 0) {
        append += pad;
    }
    append += pad.substr(0, (size + pad.length));
    return ((side == String.PAD_LEFT) ? append.concat(str) : str.concat(append));
}

Number.prototype.format = function (d_len, d_pt, t_pt) {
    var d_len = d_len || 0;
    var d_pt = d_pt || ".";
    var t_pt = t_pt || ",";
    if ((typeof d_len != "number")
            || (typeof d_pt != "string")
            || (typeof t_pt != "string")) {
        throw new Error("wrong parameters for method 'String.pad()'.");
    }
    var integer = "", decimal = "";
    var n = new String(this).split(/\./), i_len = n[0].length, i = 0;
    if (d_len > 0) {
        n[1] = (typeof n[1] != "undefined") ? n[1].substr(0, d_len) : "";
        decimal = d_pt.concat(n[1].pad(d_len, "0", String.PAD_RIGHT));
    }
    while (i_len > 0) {
        if ((++i % 3 == 1) && (i_len != n[0].length)) {
            integer = t_pt.concat(integer);
        }
        integer = n[0].substr(--i_len, 1).concat(integer);
    }
    return (integer + decimal);
}

function formatar(mascara, documento) {

    var i = documento.value.length;
    var saida = mascara.substring(0, 1);
    var texto = mascara.substring(i)

    if (texto.substring(0, 1) != saida) {
        documento.value += texto.substring(0, 1);
    }

}


function convertField(field) {

    var texto = field.value;
    var letra;
    var codigo;
    var saida = '';


    for (i = 0; i < texto.length; i++)
    {

        letra = texto.substring(i, i + 1);


        codigo = letra.charCodeAt(0)


        if (codigo == 38) { 	//OK
            codigo = 101; 		//& e
        }

        if (codigo >= 97 && codigo <= 122) { 	//minusculas

            codigo = (codigo - 32);
        }

        if (codigo == 231) {

            codigo = 67; 		//Ç
        }

        if (codigo >= 192 && codigo <= 198) {
            codigo = 65;		//A
        }
        if (codigo == 199) {			//Ç
            codigo = 67;
        }
        if (codigo >= 200 && codigo <= 203) {   //E
            codigo = 69;
        }
        if (codigo >= 204 && codigo <= 207) {   //I
            codigo = 73;
        }
        if (codigo >= 210 && codigo <= 214) {   //O
            codigo = 79;
        }
        if (codigo >= 217 && codigo <= 220) {   //U
            codigo = 85;
        }


        if (codigo >= 224 && codigo <= 230) {
            codigo = 65;		//A
        }
        if (codigo == 231) {			//Ç
            codigo = 199;
        }
        if (codigo >= 232 && codigo <= 235) {   //E
            codigo = 69;
        }
        if (codigo >= 236 && codigo <= 240) {   //I
            codigo = 73;
        }
        if (codigo >= 242 && codigo <= 246) {   //O
            codigo = 79;
        }
        if (codigo >= 249 && codigo <= 252) {   //U
            codigo = 85;
        }


        letra = String.fromCharCode(codigo);

        saida = saida + letra

    }

    field.value = saida;

}


function entertab(campo)
{

    nextfield = campo; // nome do primeiro campo do site
    netscape = "";
    ver = navigator.appVersion;
    len = ver.length;
    for (iln = 0; iln < len; iln++)
        if (ver.charAt(iln) == "(")
            break;
    netscape = (ver.charAt(iln + 1).toUpperCase() != "C");

    function keyDown(DnEvents) {
        // ve quando e o netscape ou IE
        k = (netscape) ? DnEvents.which : window.event.keyCode;
        if (k == 13) { // preciona tecla enter
            if (nextfield == 'done') {

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

}






function validar_data(data) {


    var dia = parseInt(data.substring(0, 2), 10);
    var mes = parseInt(data.substring(3, 5), 10);
    var ano = parseInt(data.substring(6, 10), 10);


    if (dia <= 31 && mes <= 12 && ano >= 1000) {
        if (data.substring(0, 1) == '0' && data.substring(1, 2) != '0' ||
                data.substring(0, 1) != '0') {
            if (data.substring(2, 3) == "/") {
                if (data.substring(3, 4) == '0' && data.substring(4, 5) != '0' ||
                        data.substring(3, 4) != '0') {
                    if (data.substring(5, 6) == "/") {
                        if (data.substring(6, 7) == '0' ||
                                data.substring(6, 7) == '' && data.substring(7, 8) != '0') {
                            window.alert('O ano que você digitou não existe!');
                            return false;

                            if (mes == 2) {
                                if ((dia > 0) && (dia <= 29)) {
                                    if (dia == 29) {
                                        if ((ano % 4) == 0) {
                                            return true;
                                        } else {
//window.alert('Este dia não existe, certifique - se de que digitou corretamente!');
                                            return false;
                                        }
                                    }
                                } else {
//window.alert('Este dia não existe, certifique - se de que digitou corretamente!');
                                    return false;
                                }
                            }
                            if ((mes == 4) || (mes == 6) || (mes == 9) || (mes == 11)) {
                                if ((dia > 0) && (dia <= 30)) {
                                    return true;
                                } else {
//window.alert('Este dia não existe, certifique - se de que digitou corretamente!');
                                    return false;
                                }
                            }
                            if ((mes == 1) || (mes == 3) || (mes == 5) || (mes == 7) || (mes == 8) || (mes == 10) || (mes == 12)) {
                                if ((dia > 0) && (dia <= 31)) {
                                    return true;
                                } else {
//window.alert('Este dia não existe, certifique -se de que digitou corretamente!');
                                    return false;
                                }
                            }
                        }
                    } else {
//window.alert('A data foi digitada fora do padrão(dd/mm/aaaa) !');
                        return false;
                    }
                } else {
//window.alert('Você digitou um mês que não existe!');
                    return false;
                }
            } else {
//window.alert('A data foi digitada fora do padrão(dd/mm/aaaa)!');
                return false;
            }
        } else {
//window.alert('Você digitou um dia que não existe!');
            return false;
        }
    } else {
//window.alert('O dia e/ou o mês que você digitou não existe, ou Você digitou fora do padrão (dd/mm/aaaa) !');
        return false;
    }
    return true;
}



function dataano(documento, data) {



    var ano = parseInt(data.substring(6, 10), 10);

    var mydate = new Date();
    var year = mydate.getFullYear();


    if (validar_data(data.substring(0, 5) + '/' + year)) {

        if (isNaN(ano) == false) {
            if (ano < 50) {
                ano = ano + 2000;
                documento.value = data.substring(0, 6) + ano;
            } else if (ano >= 50 && ano < 100) {
                ano = ano + 1900;
                documento.value = data.substring(0, 6) + ano;
            }
        } else {

            documento.value = data.substring(0, 5) + '/' + year;

        }

    }

}




function convertField2(field) {

    var texto = field.value;
    var letra;
    var codigo;
    var saida = '';


    for (i = 0; i < texto.length; i++)
    {

        letra = texto.substring(i, i + 1);


        codigo = letra.charCodeAt(0)


        if (codigo == 44) {
            codigo = 46;
        }


        letra = String.fromCharCode(codigo);

        saida = saida + letra

    }

    field.value = saida;

}


function convertField3(field) {

    var texto = field.value;
    var letra;
    var codigo;
    var saida = '';


    for (i = 0; i < texto.length; i++)
    {

        letra = texto.substring(i, i + 1);


        codigo = letra.charCodeAt(0)


        if (codigo == 44) {
            codigo = 46;
        }


        letra = String.fromCharCode(codigo);

        saida = saida + letra

    }


    if (isNaN(saida) == true) {
        saida = 0;
    }

    field.value = saida;

}

function datadiacampo(campo1, campo2)
{
    var AuxData = new Date();
    var dia = AuxData.getDate();
    var mes = AuxData.getMonth() + 1;
    var ano = AuxData.getFullYear();
    if (dia < 10)
        dia = '0' + dia;
    if (mes < 10)
        mes = '0' + mes;
    var dataDia = dia + '/' + mes + '/' + ano;
    if (campo1 != 'null')
    {
        document.getElementById("" + campo1).value = dataDia;
    }
    if (campo2 != '')
    {
        document.getElementById("" + campo2).value = dataDia;
    }
}


function datadiacampomes(campo1, campo2)
{
    var AuxData = new Date();
    var dia = AuxData.getDate();
    var mes = AuxData.getMonth() + 1;
    var ano = AuxData.getFullYear();
    if (dia < 10)
        dia = '0' + dia;
    if (mes < 10)
        mes = '0' + mes;
    var dataDiaIni = '01/' + mes + '/' + ano;
    var dataDiaFim = dia + '/' + mes + '/' + ano;
    if (campo1 != 'null')
    {
        document.getElementById("" + campo1).value = dataDiaIni;
    }
    if (campo2 != '')
    {
        document.getElementById("" + campo2).value = dataDiaFim;
    }
}
