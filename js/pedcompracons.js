var conini;

var vet = new Array(100);

for (var i = 0; i < 100; i++) {
    vet[i] = new Array(2);
}

for (var i = 0; i < 100; i++) {
    vet[i][0] = 0;
    vet[i][1] = 0;
}

var codigo;
var dtinicio;
var dtfinal;
var tp;


function ver(vcodigo, vdtinicio, vdtfinal, vtp) {

    codigo = vcodigo;
    dtinicio = vdtinicio;
    dtfinal = vdtfinal;
    tp = vtp;
    ver2();

}

function ver2() {

    valor = codigo;

    if (valor == 0 || valor == '') {
        document.forms[0].pcnumero.focus();
    } else {

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

            ajax2.open("POST", "pedcompraconspesquisa.php", true);
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
                            alert("Pedido não existe!");
                        }

                        $("pcnumero").value = '';

                        $("pcemissao").value = '';
                        $("fornguerra").value = '';
                        $("comprador").value = '';
                        $("condicao").value = '';
                        $("observacao1").value = '';
                        $("observacao2").value = '';
                        $("observacao3").value = '';
                        $("comissao").value = '';
                        $("total").value = '';
                        $("ipi").value = '';
                        $("desconto").value = '';

                        if ($("pcnumero").value != '') {
                            document.forms[0].pcnumero.focus();
                        }
                    }
                }
            }
            //passa o parametro
            var params = "parametro=" + valor;
            ajax2.send(params);
        }

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

            var pcemissao = item.getElementsByTagName("pcemissao")[0].firstChild.nodeValue;
            var fornguerra = item.getElementsByTagName("fornguerra")[0].firstChild.nodeValue;
            var comprador = item.getElementsByTagName("comprador")[0].firstChild.nodeValue;
            var condicao = item.getElementsByTagName("condicao")[0].firstChild.nodeValue;
            var observacao1 = item.getElementsByTagName("observacao1")[0].firstChild.nodeValue;
            var observacao2 = item.getElementsByTagName("observacao2")[0].firstChild.nodeValue;
            var observacao3 = item.getElementsByTagName("observacao3")[0].firstChild.nodeValue;
            var comissao = item.getElementsByTagName("comissao")[0].firstChild.nodeValue;
            var total = item.getElementsByTagName("total")[0].firstChild.nodeValue;
            var ipi = item.getElementsByTagName("ipi")[0].firstChild.nodeValue;
            var desconto = item.getElementsByTagName("desconto")[0].firstChild.nodeValue;

            trimjs(pcemissao);
            if (txt == '0') {
                txt = '';
            }            
            pcemissao = txt;
            trimjs(fornguerra);
            if (txt == '0') {
                txt = '';
            }           
            fornguerra = txt;
            trimjs(comprador);
            if (txt == '0') {
                txt = '';
            }           
            comprador = txt;
            trimjs(condicao);
            if (txt == '0') {
                txt = '';
            }            
            condicao = txt;
            trimjs(observacao1);
            if (txt == '0') {
                txt = '';
            }            
            observacao1 = txt;
            trimjs(observacao2);
            if (txt == '0') {
                txt = '';
            }            
            observacao2 = txt;
            trimjs(observacao3);
            if (txt == '0') {
                txt = '';
            }            
            observacao3 = txt;
            trimjs(comissao);
            if (txt == '0') {
                txt = '';
            }           
            comissao = txt;
            trimjs(total);
            total = txt;
            trimjs(ipi);
            ipi = txt;
            trimjs(desconto);
            desconto = txt;

            var produtos = (total - desconto);
            produtos = (Math.round(produtos * 100)) / 100;
            produtos = (produtos.format(2, ",", "."));
            //produtos = produtos.pad(14, " ", String.PAD_LEFT);

            total = (Math.round(total * 100)) / 100;
            total = (total.format(2, ",", "."));
            //total = total.pad(14, " ", String.PAD_LEFT);

            desconto = (Math.round(desconto * 100)) / 100;
            desconto = (desconto.format(2, ",", "."));
            //desconto = desconto.pad(14, " ", String.PAD_LEFT);

            ipi = (Math.round(ipi * 100)) / 100;
            ipi = (ipi.format(2, ",", "."));
            //ipi = ipi.pad(14, " ", String.PAD_LEFT);

            $("pcemissao").value = pcemissao;
            $("fornguerra").value = fornguerra;
            $("comprador").value = comprador;
            $("condicao").value = condicao;
            $("observacao1").value = observacao1;
            $("observacao2").value = observacao2;
            $("observacao3").value = observacao3;
            $("comissao").value = comissao;
            $("total").value = produtos;
            $("ipi").value = ipi;
            $("desconto").value = desconto;
            $("produtos").value = total;
            
        }
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo

        if ($("pcnumero").value != '')
        {
            alert("Pedido não existe!");
            document.forms[0].pcnumero.focus();
        }

        $("pcnumero").value = '';

        $("pcemissao").value = '';
        $("fornguerra").value = '';
        $("comprador").value = '';
        $("condicao").value = '';
        $("observacao1").value = '';
        $("observacao2").value = '';
        $("observacao3").value = '';
        $("comissao").value = '';
        $("total").value = '';
        $("ipi").value = '';
        $("desconto").value = '';

        if ($("pcnumero").value != '') {
            document.forms[0].pcnumero.focus();
        }


    }
    load_grid($("pcnumero").value);
}

// JavaScript Document
function load_grid(pcnumero) {
    
    let titulo = "PROCESSANDO, AGUARDE...";
    let mensagem = "EXECUTANDO PESQUISA DE ITENS!";

    $a("#retorno").messageBoxModal(titulo, mensagem);
    
    new ajax('pedcompraconspesquisapedido.php?pcnumero=' + pcnumero, {onLoading: carregando, onComplete: imprime});
}

function carregando() {
    $("msg").style.visibility = "visible";
    $("msg").innerHTML = "Processando...";
}

function imprime(request) {

    $("msg").style.visibility = "hidden";
    var xmldoc = request.responseXML;
    var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];
    if (cabecalho != null)
    {

        let tabela = "<div class='limiter'>"
        tabela += "<div class='container-table100'>"
        tabela += "<div class='wrap-table150'>"
        tabela += "<div class='table-max'>"
        tabela += "<div class='row-max header'>"
        tabela += "<div class='cell-max'>Codigo</div>"
        tabela += "<div class='cell-max'>Produto</div>"
        tabela += "<div class='cell-max'>Qtde</div>"
        tabela += "<div class='cell-max'>Valor</div>"        
        tabela += "</div>";

        //corpo da tabela
        var registros = xmldoc.getElementsByTagName('registro');
        for (i = 0; i < registros.length; i++) {
            var itens = registros[i].getElementsByTagName('item');
            tabela += "<div class='row-max'>"
            
            let valor = ''                               
                            
            tabela += "<div class='cell-max' data-title='Codigo'>" + itens[0].firstChild.data + "</div>";
            tabela += "<div class='cell-max' data-title='Produto'>" + itens[1].firstChild.data + "</div>";
            
            if(itens[2].firstChild == null || itens[2].firstChild.data=='_') {
                valor = '&nbsp;'
            } else {
                valor = itens[2].firstChild.data
            }
            tabela += "<div class='cell-max' data-title='Qtde'>" + valor + "</div>";
            if(itens[3].firstChild == null || itens[3].firstChild.data=='_') {
                valor = '&nbsp;'
            } else {
                valor = itens[3].firstChild.data
            }
            tabela += "<div class='cell-max' data-title='Valor'>" + valor + "</div>";
                    
           
            tabela += "</div>"
        }

        tabela += "</div>"
        tabela += "</div>"
        tabela += "</div>"
        tabela += "</div>"

        $("resultado").innerHTML = tabela;
        
        tabela = null;
    } else
        $("resultado").innerHTML = "Nenhum registro encontrado...";
    
    $a.unblockUI();
}

function imprimeold(request) {



    $("msg").style.visibility = "hidden";
    var xmldoc = request.responseXML;
    var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];
    if (cabecalho != null)
    {


        var tabela = "<table width='515' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' bgcolor='#CCCCCC' ><tr>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC' colspan='4' align='center'><b>Original</b></td></tr>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Codigo</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Produto</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Quantidade</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Valor</b></td>";

        //corpo da tabela
        var registros = xmldoc.getElementsByTagName('registro');
        for (i = 0; i < registros.length; i++) {
            var itens = registros[i].getElementsByTagName('item');
            tabela += "<tr id=linha" + i + ">"
            for (j = 0; j < itens.length; j++) {
                if (itens[j].firstChild == null)
                    tabela += "<td class='borda'>" + 0 + "</td>";
                else
                if (j == 2) {
                    tabela += "<td class='borda' align='right'>&nbsp;" + itens[j].firstChild.data + "&nbsp;</td>";
                } else if (j == 3) {
                    tabela += "<td class='borda' align='right'>&nbsp;" + itens[j].firstChild.data + "&nbsp;</td>";
                } else {
                    tabela += "<td class='borda'>" + itens[j].firstChild.data + "</td>";
                }
            }
            tabela += "</tr>";
        }

        tabela += "</table>"


        tabela += "</tr>"

        $("resultado").innerHTML = tabela;
        //$("resultado2").innerHTML=tabela2;
        tabela = null;
    } else
        $("resultado").innerHTML = "Nenhum registro encontrado...";
}


function impped() {

    var pcnumero = $("pcnumero").value;
    if (document.getElementById("radioa1").checked == true) {
        tipo = 1;
    } else {
        tipo = 2;
    }

    if (document.getElementById("radiob1").checked == true) {
        window.open('pedcompraconsimppdf.php?pcnumero=' + pcnumero
                + '&tipo=' + tipo
                , 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');
    } else {
        window.open('pedcompraconsimppdfb.php?pcnumero=' + pcnumero
                + '&tipo=' + tipo
                , 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');
    }


}

function aberto()
{
    erro = 0;
    var pcnumero = $("pcnumero");
    if (pcnumero.value == "" || pcnumero.value == 0)
    {
        alert("Favor, Preencha o campo Pedido!");
        pcnumero.focus();
        erro = 1;
    }

    if (erro == 0)
    {
        load_grid_aberto(pcnumero.value)
    }
}

function load_grid_aberto(pcnumero) {
    
    let titulo = "PROCESSANDO, AGUARDE...";
    let mensagem = "EXECUTANDO PESQUISA DE ITENS!";

    $a("#retorno").messageBoxModal(titulo, mensagem);
    
    new ajax('pedcompraconspesquisapedidoaberto.php?pcnumero=' + pcnumero, {onLoading: carregando_aberto, onComplete: imprime_aberto});
}

function carregando_aberto() {
    $("msg").style.visibility = "visible";
    $("msg").innerHTML = "Processando...";
}

function imprime_aberto(request) {
    
    $("msg").style.visibility = "hidden";
    var xmldoc = request.responseXML;
    var cabecalho = xmldoc.getElementsByTagName('cabecalhoa')[0];
    if (cabecalho != null)
    {
        let tabela = "<div class='limiter'>"
        tabela += "<div class='container-table100'>"
        tabela += "<div class='wrap-table150'>"
        tabela += "<div class='table-max'>"
        tabela += "<div class='row-max header'>"
        tabela += "<div class='cell-max'>Codigo</div>"
        tabela += "<div class='cell-max'>Produto</div>"
        tabela += "<div class='cell-max'>Qtde</div>"
        tabela += "<div class='cell-max'>Valor</div>"        
        tabela += "</div>";

        //corpo da tabela
        var registros = xmldoc.getElementsByTagName('registroa');
        for (i = 0; i < registros.length; i++)
        {
            var itens = registros[i].getElementsByTagName('itema');
            tabela += "<div class='row-max'>"
            
            let valor = ''
        
            tabela += "<div class='cell-max' data-title='Codigo'>" + itens[0].firstChild.data + "</div>";
            tabela += "<div class='cell-max' data-title='Produto'>" + itens[1].firstChild.data + "</div>";
            if(itens[2].firstChild == null || itens[2].firstChild.data=='_') {
                valor = '&nbsp;'
            } else {
                valor = itens[2].firstChild.data
            }
            tabela += "<div class='cell-max' data-title='Qtde'>" + valor + "</div>";
            if(itens[3].firstChild == null || itens[3].firstChild.data=='_') {
                valor = '&nbsp;'
            } else {
                valor = itens[3].firstChild.data
            }
            tabela += "<div class='cell-max' data-title='Valor'>" + valor + "</div>";                     
           
            tabela += "</div>"
        }

        tabela += "</div>"
        tabela += "</div>"
        tabela += "</div>"
        tabela += "</div>"

        $("resultado").innerHTML = tabela;
        
        tabela = null;
    } else
        $("resultado").innerHTML = "Nenhum registro encontrado...";
    
    $a.unblockUI();
}

function imprime_aberto_old(request) {

    var pcnumero = $("pcnumero").value;
    $("msg").style.visibility = "hidden";
    var xmldoc = request.responseXML;
    var cabecalho = xmldoc.getElementsByTagName('cabecalhoa')[0];
    if (cabecalho != null)
    {
        var tabela = "<table width='515' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' bgcolor='#CCCCCC' ><tr>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC' colspan='4' align='center'><b>Aberto</b></td></tr>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Codigo</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Produto</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Quantidade</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Valor</b></td>";

        //corpo da tabela
        var registros = xmldoc.getElementsByTagName('registroa');
        for (i = 0; i < registros.length; i++)
        {
            var itens = registros[i].getElementsByTagName('itema');
            tabela += "<tr id=linha" + i + ">"
            for (j = 0; j < itens.length; j++)
            {
                if (itens[j].firstChild == null)
                    tabela += "<td class='borda'>" + 0 + "</td>";
                else
                if (j == 2)
                {
                    tabela += "<td class='borda' align='right'>&nbsp;" + itens[j].firstChild.data + "&nbsp;</td>";
                } else
                if (j == 3)
                {
                    tabela += "<td class='borda' align='right'>&nbsp;" + itens[j].firstChild.data + "&nbsp;</td>";
                } else
                {
                    tabela += "<td class='borda'>" + itens[j].firstChild.data + "</td>";
                }
            }
            tabela += "</tr>";
        }

        tabela += "</table><br>";
        tabela += "<table width='600' border='0' bgcolor='#FFFFFF'><tr>";
        tabela += "<td colspan='2' valing='top' align='center'><a href=\"javascript:ver(" + pcnumero + ",0,0,0);\"><font color='#000000'><b>&laquo; Voltar</b></font></td>";
        tabela += "</tr>";
        tabela += "</table>";
        $("resultado").innerHTML = tabela;
        //$("resultado2").innerHTML=tabela2;
        tabela = '';
    } else
    {
        var tabela = "<table width='515' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' bgcolor='#CCCCCC' ><tr>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC' colspan='4' align='center'><b>Aberto</b></td></tr>";
        tabela += "<td width='100%'>&nbsp;</td>";
        tabela += "</tr>";
        tabela += "<table width='500' border='0' bgcolor='#FFFFFF'>";
        tabela += "<tr>";
        tabela += "<td width='100%' align='center'><font color='#000000'><b>Nenhum registro encontrado!!</b></font></td>";
        tabela += "</tr>";
        tabela += "<td colspan='2' valing='top' align='center'><a href=\"javascript:ver(" + pcnumero + ",0,0,0);\"><font color='#000000'><b>&laquo; Voltar</b></font></td>";
        tabela += "</tr>";
        tabela += "</table>";
        $("resultado").innerHTML = tabela;
        tabela = '';
    }
}

function faturados()
{
    erro = 0;
    var pcnumero = $("pcnumero");
    if (pcnumero.value == "" || pcnumero.value == 0)
    {
        alert("Favor, Preencha o campo Pedido!");
        pcnumero.focus();
        erro = 1;
    }

    if (erro == 0)
    {
        load_grid_faturados(pcnumero.value)
    }
}

function load_grid_faturados(pcnumero) {
    
    let titulo = "PROCESSANDO, AGUARDE...";
    let mensagem = "EXECUTANDO PESQUISA DE ITENS!";

    $a("#retorno").messageBoxModal(titulo, mensagem);
    
    new ajax('pedcompraconspesquisapedidofaturados.php?pcnumero=' + pcnumero, {onLoading: carregando_faturados, onComplete: imprime_faturados});
}

function carregando_faturados() {
    $("msg").style.visibility = "visible";
    $("msg").innerHTML = "Processando...";
}

function imprime_faturados(request) {
    
    $("msg").style.visibility = "hidden";
    var xmldoc = request.responseXML;
    var cabecalho = xmldoc.getElementsByTagName('cabecalhof')[0];
    if (cabecalho != null)
    {
        let tabela = "<div class='limiter'>"
        tabela += "<div class='container-table100'>"
        tabela += "<div class='wrap-table150'>"
        tabela += "<div class='table-max'>"
        tabela += "<div class='row-max header'>"
        tabela += "<div class='cell-max'>Codigo</div>"
        tabela += "<div class='cell-max'>Produto</div>"
        tabela += "<div class='cell-max'>Qtde</div>"
        tabela += "<div class='cell-max'>Valor</div>"
        tabela += "</div>";

        //corpo da tabela
        var registros = xmldoc.getElementsByTagName('registrof');
        for (i = 0; i < registros.length; i++)
        {
            var itens = registros[i].getElementsByTagName('itemf');
            
            tabela += "<div class='row-max'>"
            
            let valor = ''

            tabela += "<div class='cell-max' data-title='Codigo'>" + itens[0].firstChild.data + "</div>";
            tabela += "<div class='cell-max' data-title='Produto'>" + itens[1].firstChild.data + "</div>";
            if(itens[2].firstChild == null || itens[2].firstChild.data=='_') {
                valor = '&nbsp;'
            } else {
                valor = itens[2].firstChild.data
            }
            tabela += "<div class='cell-max' data-title='Qtde'>" + valor + "</div>";
            if(itens[3].firstChild == null || itens[3].firstChild.data=='_') {
                valor = '&nbsp;'
            } else {
                valor = itens[3].firstChild.data
            }
            tabela += "<div class='cell-max' data-title='Valor'>" + valor + "</div>";
            
            tabela += "</div>"
        }

        tabela += "</div>"
        tabela += "</div>"
        tabela += "</div>"
        tabela += "</div>"

        $("resultado").innerHTML = tabela;
        
        tabela = null;
    } else
        $("resultado").innerHTML = "Nenhum registro encontrado...";
    
    $a.unblockUI();
}

function imprime_faturados_old(request) {

    var pcnumero = $("pcnumero").value;
    $("msg").style.visibility = "hidden";
    var xmldoc = request.responseXML;
    var cabecalho = xmldoc.getElementsByTagName('cabecalhof')[0];
    if (cabecalho != null)
    {
        var tabela = "<table width='515' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' bgcolor='#CCCCCC' ><tr>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC' colspan='4' align='center'><b>Faturados</b></td></tr>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Codigo</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Produto</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Quantidade</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Valor</b></td>";

        //corpo da tabela
        var registros = xmldoc.getElementsByTagName('registrof');
        for (i = 0; i < registros.length; i++)
        {
            var itens = registros[i].getElementsByTagName('itemf');
            tabela += "<tr id=linha" + i + ">"
            for (j = 0; j < itens.length; j++)
            {
                if (itens[j].firstChild == null)
                    tabela += "<td class='borda'>" + 0 + "</td>";
                else
                if (j == 2)
                {
                    tabela += "<td class='borda' align='right'>&nbsp;" + itens[j].firstChild.data + "&nbsp;</td>";
                } else
                if (j == 3)
                {
                    tabela += "<td class='borda' align='right'>&nbsp;" + itens[j].firstChild.data + "&nbsp;</td>";
                } else
                {
                    tabela += "<td class='borda'>" + itens[j].firstChild.data + "</td>";
                }
            }
            tabela += "</tr>";
        }

        tabela += "</table><br>";
        tabela += "<table width='600' border='0' bgcolor='#FFFFFF'><tr>";
        tabela += "<td colspan='2' valing='top' align='center'><a href=\"javascript:ver(" + pcnumero + ",0,0,0);\"><font color='#000000'><b>&laquo; Voltar</b></font></td>";
        tabela += "</tr>";
        tabela += "</table>";
        $("resultado").innerHTML = tabela;
        //$("resultado2").innerHTML=tabela2;
        tabela = '';
    } else
    {
        var tabela = "<table width='515' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' bgcolor='#CCCCCC' ><tr>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC' colspan='4' align='center'><b>Faturados</b></td></tr>";
        tabela += "<td width='100%'>&nbsp;</td>";
        tabela += "</tr>";
        tabela += "<table width='500' border='0' bgcolor='#FFFFFF'>";
        tabela += "<tr>";
        tabela += "<td width='100%' align='center'><font color='#000000'><b>Nenhum registro encontrado!!</b></font></td>";
        tabela += "</tr>";
        tabela += "<td colspan='2' valing='top' align='center'><a href=\"javascript:ver(" + pcnumero + ",0,0,0);\"><font color='#000000'><b>&laquo; Voltar</b></font></td>";
        tabela += "</tr>";
        tabela += "</table>";
        $("resultado").innerHTML = tabela;
        tabela = '';
    }
}

function baixasparciais()
{
    erro = 0;
    var pcnumero = $("pcnumero");
    if (pcnumero.value == "" || pcnumero.value == 0)
    {
        alert("Favor, Preencha o campo Pedido!");
        pcnumero.focus();
        erro = 1;
    }

    if (erro == 0)
    {
        load_grid_baixasparciais(pcnumero.value)
    }
}

function load_grid_baixasparciais(pcnumero) {
    
    let titulo = "PROCESSANDO, AGUARDE...";
    let mensagem = "EXECUTANDO PESQUISA DE ITENS!";

    $a("#retorno").messageBoxModal(titulo, mensagem);
    
    new ajax('pedcomprapesquisapedidobaixasparciais.php?pcnumero=' + pcnumero, {onLoading: carregando_baixasparciais, onComplete: imprime_baixasparciais});
}

function carregando_baixasparciais() {
    $("msg").style.visibility = "visible";
    $("msg").innerHTML = "Processando...";
}

function imprime_baixasparciais(request) {

    $("msg").style.visibility = "hidden";
    var xmldoc = request.responseXML;
    var cabecalho = xmldoc.getElementsByTagName('cabecalhob')[0];
    if (cabecalho != null)
    {
        
        let tabela = "<div class='limiter'>"
        tabela += "<div class='container-table100'>"
        tabela += "<div class='wrap-table150'>"
        tabela += "<div class='table-max'>"
        tabela += "<div class='row-max header'>"
        tabela += "<div class='cell-max'>Codigo</div>"
        tabela += "<div class='cell-max'>Produto</div>"
        tabela += "<div class='cell-max'>Qtde</div>"
        tabela += "<div class='cell-max'>Valor</div>"        
        tabela += "<div class='cell-max'>Data</div>"
        tabela += "<div class='cell-max'>Baixa</div>"
        tabela += "</div>";        
        
        //corpo da tabela
        var registros = xmldoc.getElementsByTagName('registrob');
        for (i = 0; i < registros.length; i++)
        {
            var itens = registros[i].getElementsByTagName('itemb');
            
            tabela += "<div class='row-max'>"
            
            let valor = ''
            
            tabela += "<div class='cell-max' data-title='Codigo'>" + itens[2].firstChild.data + "</div>";
            tabela += "<div class='cell-max' data-title='Produto'>" + itens[3].firstChild.data + "</div>";
            if(itens[4].firstChild == null || itens[4].firstChild.data=='_') {
                valor = '&nbsp;'
            } else {
                valor = itens[4].firstChild.data
            }
            tabela += "<div class='cell-max' data-title='Qtde'>" + valor + "</div>";
            if(itens[5].firstChild == null || itens[5].firstChild.data=='_') {
                valor = '&nbsp;'
            } else {
                valor = itens[5].firstChild.data
            }
            tabela += "<div class='cell-max' data-title='Valor'>" + valor + "</div>";
            
            tabela += "<div class='cell-max' data-title='Data'>" + itens[1].firstChild.data + "</div>";            
            tabela += "<div class='cell-max' data-title='Baixa'>" + itens[0].firstChild.data + "</div>";            
           
            tabela += "</div>"
        }

        tabela += "</div>"
        tabela += "</div>"
        tabela += "</div>"
        tabela += "</div>"

        $("resultado").innerHTML = tabela;
        
        tabela = null;
    } else
        $("resultado").innerHTML = "Nenhum registro encontrado...";
    
    $a.unblockUI();
}

function imprime_baixasparciais_old(request) {

    var pcnumero = $("pcnumero").value;
    $("msg").style.visibility = "hidden";
    var xmldoc = request.responseXML;
    var cabecalho = xmldoc.getElementsByTagName('cabecalhob')[0];
    if (cabecalho != null)
    {
        var tabela = "<table width='515' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' bgcolor='#CCCCCC' ><tr>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC' colspan='6' align='center'><b>Baixas Parciais</b></td></tr>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Baixa</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Data</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Codigo</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Produto</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Quantidade</b></td>";
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><b>Valor</b></td>";

        //corpo da tabela
        var registros = xmldoc.getElementsByTagName('registrob');
        for (i = 0; i < registros.length; i++)
        {
            var itens = registros[i].getElementsByTagName('itemb');
            tabela += "<tr id=linha" + i + ">"
            for (j = 0; j < itens.length; j++)
            {
                if (itens[j].firstChild == null)
                    tabela += "<td class='borda'>" + 0 + "</td>";
                else
                if (j == 5 || j == 4)
                {
                    tabela += "<td class='borda' align='right'>&nbsp;" + itens[j].firstChild.data + "&nbsp;</td>";
                } else
                {
                    tabela += "<td class='borda'>" + itens[j].firstChild.data + "</td>";
                }
            }
            tabela += "</tr>";
        }

        tabela += "</table><br>";
        tabela += "<table width='600' border='0' bgcolor='#FFFFFF'><tr>";
        tabela += "<td colspan='2' valing='top' align='center'><a href=\"javascript:ver(" + pcnumero + ",0,0,0);\"><font color='#000000'><b>&laquo; Voltar</b></font></td>";
        tabela += "</tr>";
        tabela += "</table>";
        $("resultado").innerHTML = tabela;
        //$("resultado2").innerHTML=tabela2;
        tabela = '';
    } else
    {
        var tabela = "<table width='515' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' bgcolor='#CCCCCC' ><tr>"
        tabela += "<td class='borda' bgcolor='#3366CC' bordercolor='#3366CC' colspan='4' align='center'><b>Baixas Parciais</b></td></tr>";
        tabela += "<td width='100%'>&nbsp;</td>";
        tabela += "</tr>";
        tabela += "<table width='500' border='0' bgcolor='#FFFFFF'>";
        tabela += "<tr>";
        tabela += "<td width='100%' align='center'><font color='#000000'><b>Nenhum registro encontrado!!</b></font></td>";
        tabela += "</tr>";
        tabela += "<td colspan='2' valing='top' align='center'><a href=\"javascript:ver(" + pcnumero + ",0,0,0);\"><font color='#000000'><b>&laquo; Voltar</b></font></td>";
        tabela += "</tr>";
        tabela += "</table>";
        $("resultado").innerHTML = tabela;
        tabela = '';
    }
}