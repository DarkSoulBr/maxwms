
// JavaScript Document


//funcao de formatacao de casas decimais
function deci(N) {
    texto = N.toString();
    texto2 = ""
    if (texto.indexOf(',') != -1)
    {
        for (var i = 0; i < texto.length; i++)
        {
            if (texto.charAt(i) == ",")
                texto2 += ".";
            else
                texto2 += texto.charAt(i);
        }
        texto = texto2;
    }


    texto[texto.indexOf(',')] = ".";
    ponto = texto.indexOf('.');
    if (ponto == -1)
    {
        texto += ".00";
        Term = texto
    } else
    {
        texto += "0";
        decimal = ponto + 3;
        Term = texto.substring(0, decimal);
    }
    if (Term == ".0") {
        Term = "0.00";
    }
    if (Term == ".00") {
        Term = "0.00";
    }
    //if (Term == "NaN.00"){ Term = "Erro";}
    return Term;
}


function load_grid() {

    dtinicio = $('dtinicio').value
    dtfinal = $('dtfinal').value


    new ajax('consultaromaneiosdata.php?dtinicio=' + dtinicio
            + '&dtfinal=' + dtfinal
            , {onLoading: carregando, onComplete: imprime});

}

function carregando() {
    $("msg").style.visibility = "visible";
    $("msg").innerHTML = "Processando...";
}

function imprime(request)
{

    $("resultado").innerHTML = "";
    var xmldoc = request.responseXML;

    var dados = xmldoc.getElementsByTagName('dados')[0];

    var registros = xmldoc.getElementsByTagName('registro');

    var totromaneios = 0;
    var totpedidos = 0;
    var totcoletor = 0;
    var totvolumes = 0;

    var total = 0;
    var valor = 0;

    let resultado = "<div class='limiter'>"
    resultado += "<div class='container-table100'>"
    resultado += "<div class='wrap-table150'>"
    resultado += "<div class='table-max'>"
    resultado += "<div class='row-max header'>"
    resultado += "<div class='cell-max'>Local</div>"
    resultado += "<div class='cell-max'>Número</div>"
    resultado += "<div class='cell-max'>Emissão</div>"
    resultado += "<div class='cell-max'>Veículo</div>"
    resultado += "<div class='cell-max'>Placa</div>"
    resultado += "<div class='cell-max'>Baixa</div>"
    resultado += "<div class='cell-max'>Pedidos</div>"
    resultado += "<div class='cell-max'>Volumes</div>"
    resultado += "<div class='cell-max'>Valor</div>"
    resultado += "</div>"
    if (dados != null)
    {
        
        
        
        
        var registros = xmldoc.getElementsByTagName('registro');
        for (i = 0; i < registros.length; i++)
        {
            var itens = registros[i].getElementsByTagName('item');

            var rnum = itens[0].firstChild.data;

            //j++;

            trimjs(rnum);

            if (txt == '0') {
                txt = '';
            }
            

            rnum = txt;
            rnum = rnum + '/' + itens[1].firstChild.data;


            var rnum2 = itens[3].firstChild.data;

            //j++;

            trimjs(rnum2);

            if (txt == '0') {
                txt = '';
            }
            

            rnum2 = txt;

            if (itens[4].firstChild.data == '1') {
                rnum2 = rnum2 + ' - PRÓPRIO';
            } else {
                rnum2 = rnum2 + ' - TERCEIROS';
            }
            ;

            if (itens[6].firstChild == null) {
                rnum3 = "__/__/____"
            } else {
                rnum3 = itens[6].firstChild.data;
            }

            if (rnum3 == null) {
                rnum3 = "  /  /  ";
            }

            if (itens[8].firstChild == null) {
                var rnum4 = 0
            } else {
                var rnum4 = itens[8].firstChild.data;
            }
            rnum4 = deci(rnum4);
            totpedidos = totpedidos + parseFloat(rnum4);
            //tabela += "<td class='borda' align='right' >" + itens[8].firstChild.data + "</td>";
            //tabela += "<td class='borda' align='right' >" + itens[12].firstChild.data + "</td>";

            if (itens[9].firstChild == null) {
                var rnum5 = 0;
            } else {
                var rnum5 = itens[9].firstChild.data;
            }
            rnum5 = deci(rnum5);
            totvolumes = totvolumes + parseFloat(rnum5);
            //tabela += "<td class='borda' align='right' >" + itens[9].firstChild.data + "</td>";

            if (itens[11].firstChild == null) {
                valor = 0;
            } else {
                valor = itens[11].firstChild.data;
            }
            //valor = number_format(valor, 2, ',', '.');
            valor = deci(valor);

            total = total + parseFloat(itens[11].firstChild.data);

            resultado += "<div class='row-max'>"
            resultado += "<div class='cell-max' data-title='Local'>" + itens[12].firstChild.data + "</div>"
            resultado += "<div class='cell-max' data-title='Número' style='cursor: pointer' onClick=abre_romaneio(" + itens[7].firstChild.data + ") >" + rnum + "</div>"
            resultado += "<div class='cell-max' data-title='Emissão'>" + itens[2].firstChild.data + "</div>"
            resultado += "<div class='cell-max' data-title='Veículo'>" + rnum2 + "</div>"
            resultado += "<div class='cell-max' data-title='Placa'>" + itens[5].firstChild.data + "</div>"
            resultado += "<div class='cell-max' data-title='Baixa'>" + rnum3 + "</div>"
            if (itens[8].firstChild == null) {
                resultado += "<div class='cell-max' data-title='Pedidos'>&nbsp;</div>"
            } else {
                resultado += "<div class='cell-max' data-title='Pedidos'>" + itens[8].firstChild.data + "</div>"
            }
            if (itens[9].firstChild == null) {
                resultado += "<div class='cell-max' data-title='Volumes'>&nbsp;</div>"
            } else {
                resultado += "<div class='cell-max' data-title='Volumes'>" + itens[9].firstChild.data + "</div>"
            }
            resultado += "<div class='cell-max' data-title='Valor'>" + valor + "</div>"
            resultado += "</div>"

        }

        total = deci(total);

        var qtd = registros.length;

        resultado += "<div class='row-max header'>"
        resultado += "<div class='cell-max' data-title='Local'>&nbsp;</div>"
        resultado += "<div class='cell-max' data-title='Número'>&nbsp;</div>"
        resultado += "<div class='cell-max' data-title='Emissão'>&nbsp;</div>"
        resultado += "<div class='cell-max' data-title='Veículo'>&nbsp;</div>"
        resultado += "<div class='cell-max' data-title='Placa'>&nbsp;</div>"
        resultado += "<div class='cell-max' data-title='Baixa'>Total de Romaneios</div>"
        resultado += "<div class='cell-max' data-title='Pedidos'>Total de Pedidos</div>"
        resultado += "<div class='cell-max' data-title='Volumes'>Total de Volumes</div>"
        resultado += "<div class='cell-max' data-title='Valor'>Total R$</div>"
        resultado += "</div>"

        resultado += "<div class='row-max header'>"
        resultado += "<div class='cell-max' data-title='Local'>&nbsp;</div>"
        resultado += "<div class='cell-max' data-title='Número'>&nbsp;</div>"
        resultado += "<div class='cell-max' data-title='Emissão'>&nbsp;</div>"
        resultado += "<div class='cell-max' data-title='Veículo'>&nbsp;</div>"
        resultado += "<div class='cell-max' data-title='Placa'>&nbsp;</div>"
        resultado += "<div class='cell-max' data-title='Baixa'>" + qtd + "</div>"
        resultado += "<div class='cell-max' data-title='Pedidos'>" + totpedidos + "</div>"
        resultado += "<div class='cell-max' data-title='Volumes'>" + totvolumes + "</div>"
        resultado += "<div class='cell-max' data-title='Valor'>" + total + "</div>"
        resultado += "</div>"
    }
    resultado += "</div>"
    resultado += "</div>"
    resultado += "</div>"
    resultado += "</div>"

    $("resultado").innerHTML = resultado;

}

function imprimeOld(request) {

    $("msg").style.visibility = "hidden";
    var xmldoc = request.responseXML;
    var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];
    var totpedidos = 0;
    var totvolumes = 0;

    var total = 0;
    var valor = 0;

    if (cabecalho != null)
    {

        var tabela = "<table width='700' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' bgcolor='#CCCCCC' ><tr>"
        tabela += "<td width='100' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Local</b></td>";
        tabela += "<td width='100' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Número</b></td>";
        tabela += "<td width='100' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Emissão</b></td>";
        tabela += "<td width='250' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Veículo</b></td>";
        tabela += "<td width='125' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Placa</b></td>";
        tabela += "<td width='125' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Baixa</b></td>";
        tabela += "<td width='125' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Pedidos</b></td>";
        tabela += "<td width='125' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Volumes</b></td>";
        tabela += "<td width='125' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Valor</b></td>";

        //corpo da tabela
        var registros = xmldoc.getElementsByTagName('registro');
        for (i = 0; i < registros.length; i++) {
            var itens = registros[i].getElementsByTagName('item');
            tabela += "<tr id=linha" + i + ">"
            tabela += "<td class='borda'>" + itens[12].firstChild.data;
            +"</td>";
            for (j = 0; j < itens.length - 1; j++) {

                if (itens[j].firstChild == null) {

                    if (j == 6) {
                        tabela += "<td class='borda'>" + "__/__/____" + "</td>";
                    } else {
                        tabela += "<td class='borda'>" + 0 + "</td>";
                    }

                } else
                if (j == 0) {

                    var rnum = itens[j].firstChild.data;

                    j++;

                    trimjs(rnum);

                    if (txt == '0') {
                        txt = '';
                    }
                    ;

                    rnum = txt;
                    rnum = rnum + '/' + itens[j].firstChild.data;
                    //
                    tabela += "<td class='borda2' style='cursor: pointer' onClick=abre_romaneio(" + itens[7].firstChild.data + ") >" + rnum + "</td>";

                } else if (j == 3) {

                    var rnum = itens[j].firstChild.data;

                    j++;

                    trimjs(rnum);

                    if (txt == '0') {
                        txt = '';
                    }
                    ;

                    rnum = txt;

                    if (itens[j].firstChild.data == '1') {
                        rnum = rnum + ' - PRÓPRIO';
                    } else {
                        rnum = rnum + ' - TERCEIROS';
                    }
                    ;

                    tabela += "<td class='borda2'>" + rnum + "</td>";
                } else if (j == 6) {

                    var rnum = itens[j].firstChild.data;

                    if (rnum == null) {
                        rnum = "  /  /  ";
                    }

                    tabela += "<td class='borda2'>" + rnum + "</td>";
                } else if (j == 7) {
                    //tabela+="<td class='borda2'>"+itens[j].firstChild.data+"</td>";
                } else if (j == 8) {
                    var rnum = itens[j].firstChild.data;
                    rnum = deci(rnum);
                    totpedidos = totpedidos + parseFloat(rnum);
                    tabela += "<td class='borda' align='right' >" + itens[j].firstChild.data + "</td>";
                } else if (j == 9) {
                    var rnum = itens[j].firstChild.data;
                    rnum = deci(rnum);
                    totvolumes = totvolumes + parseFloat(rnum);
                    tabela += "<td class='borda' align='right' >" + itens[j].firstChild.data + "</td>";
                } else if (j == 10) {
                    //tabela+="<td class='borda2'>"+itens[j].firstChild.data+"</td>";
                } else if (j == 11) {
                    valor = itens[j].firstChild.data;
                    valor = deci(valor);
                    tabela += "<td class='borda' align='right'>" + valor + "</td>";
                } else {
                    tabela += "<td class='borda' >" + itens[j].firstChild.data + "</td>";
                }

            }

            total = total + parseFloat(itens[11].firstChild.data);

            tabela += "</tr>";
        }

        tabela += "</table>"


        tabela += "</tr>"

        var qtd = itens[12].firstChild.data;
        $("qtd").value = qtd;

        $("resultado").innerHTML = tabela;

        $("qtd2").value = totpedidos;
        $("qtd3").value = totvolumes;

        total = deci(total);
        $("qtd4").value = total;

        tabela = null;
    } else
        $("resultado").innerHTML = "Nenhum registro encontrado...";
}

function abre_romaneio(valor) {


    window.open('romaneiosalt.php?valor=' + valor
            , '_blank');

}