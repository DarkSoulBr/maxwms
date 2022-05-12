// JavaScript Document

var vetorrateio = new Array(100);

for (var i = 0; i < 100; i++) {
    vetorrateio[i] = new Array(4);
}

for (var i = 0; i < 100; i++) {
    vetorrateio[i][0] = '';
    vetorrateio[i][1] = '';
    vetorrateio[i][3] = '';
    vetorrateio[i][4] = '';
}

function dadospesquisa(valor) {

    var valor2 = 1;

    if (document.getElementById("radio1").checked == true) {
        valor2 = 1;
    } else if (document.getElementById("radio2").checked == true) {
        valor2 = 2;
    } else
    {
        valor2 = 3;
    }



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



        ajax2.open("POST", "ctepesquisa.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function () {



            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1) {

            }
            //apÃ³s ser processado - chama funÃ§Ã£o processXML que vai varrer os dados
            if (ajax2.readyState == 4) {
                if (ajax2.responseXML) {

                    processXML(ajax2.responseXML);
                } else {
                    //caso nÃ£o seja um arquivo XML emite a mensagem abaixo
                    $("ctecodigo").value = "";
                    $("ctecodigo").value = "";
                    $("controle").value = "";
                    $("numero").value = "";
                    $("chave").value = "";
                    $("protocolo").value = "";

                }
            }
        }
        //passa o parametro

        var params = "parametro=" + valor + '&parametro2=' + valor2;

        ajax2.send(params);
    }
}


function processXML(obj) {


    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados



        var item = dataArray[0];
        //contÃ©udo dos campos no arquivo XML  
        var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
        var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
        var descricao2 = item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;

        var descricao3 = item.getElementsByTagName("descricao3")[0].firstChild.nodeValue;
        var descricao4 = item.getElementsByTagName("descricao4")[0].firstChild.nodeValue;
        var descricao5 = item.getElementsByTagName("descricao5")[0].firstChild.nodeValue;

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
        if (txt == '0') {
            txt = '';
        }
        ;
        descricao5 = txt;

        $("ctecodigo").value = codigo;
        $("controle").value = codigo;
        $("numero").value = descricao;
        $("chave").value = descricao2;
        $("protocolo").value = descricao5;

        load_grid($("ctecodigo").value);


    } else {
        //caso o XML volte vazio, printa a mensagem abaixo

        $("ctecodigo").value = "";
        $("ctecodigo").value = "";
        $("controle").value = "";
        $("numero").value = "";
        $("chave").value = "";
        $("protocolo").value = "";


    }
}

function cancelarPedido()
{
    window.open('cartacorrecaocteconsulta.php', "_self");
}

function load_grid(ctenumero) {

    new ajax('cartacorrecaocteconsultapesquisa.php?ctenumero=' + ctenumero, {
        onComplete: imprime_cartas
    });

}

function imprime_cartas(request) {

    var xmldoc = request.responseXML;

    if (xmldoc != null) {

        var tabela = "<table width='1000' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' bgcolor='#CCCCCC'><tr>"
        tabela += "<td width=\"150\" class='borda' bgcolor='#4f5963' bordercolor='#3366CC' align='center'><font color='#FFFFFF'><b>Data</b></font></td>";
        tabela += "<td width=\"50\" class='borda' bgcolor='#4f5963' bordercolor='#3366CC' align='center'><font color='#FFFFFF'><b>Seq</b></font></td>";
        tabela += "<td width=\"150\" class='borda' bgcolor='#4f5963' bordercolor='#3366CC' align='center'><font color='#FFFFFF'><b>Protocolo</b></font></td>";
        tabela += "<td width=\"150\" class='borda' bgcolor='#4f5963' bordercolor='#3366CC' align='center'><font color='#FFFFFF'><b>Recebimento</b></font></td>";
        tabela += "<td width=\"400\" class='borda' bgcolor='#4f5963' bordercolor='#3366CC' align='center'><font color='#FFFFFF'><b>Status</b></font></td>";
        tabela += "<td width=\"50\" class='borda' bgcolor='#4f5963' bordercolor='#3366CC' align='center'><font color='#FFFFFF'><b>PDF</b></font></td>";
        tabela += "<td width=\"50\" class='borda' bgcolor='#4f5963' bordercolor='#3366CC' align='center'><font color='#FFFFFF'><b>XML</b></font></td></tr>";

        var registros = xmldoc.getElementsByTagName('registro');
        for (i = 0; i < registros.length; i++) {
            var itens = registros[i].getElementsByTagName('item');
            tabela += "<tr id=linha" + i + ">";
            tabela += "<td class='borda' align='center'>"
                    + itens[0].firstChild.data + "</td>";
            
            var urlDet = '<a href=javascript:load_itens("' + itens[7].firstChild.data + '") >' + + itens[1].firstChild.data + '</a>';
            tabela += "<td class='borda' align='center'>" + urlDet + "</td>";      

            if (itens[2].firstChild.data == '_') {
                tabela += "<td class='borda' align='center'>&nbsp;</td>";
            } else {
                tabela += "<td class='borda' align='center'>"
                        + itens[2].firstChild.data + "</td>";
            }

            if (itens[3].firstChild.data == '_') {
                tabela += "<td class='borda' align='center'>&nbsp;</td>";
            } else {
                tabela += "<td class='borda' align='center'>"
                        + itens[3].firstChild.data + "</td>";
            }

            if (itens[4].firstChild.data == '_') {
                tabela += "<td class='borda' align='center'>&nbsp;</td>";
            } else {
                tabela += "<td class='borda' align='center'>"
                        + itens[4].firstChild.data + "</td>";
            }


            if (itens[5].firstChild.data == '_') {
                tabela += "<td class='borda' align='center'>&nbsp;</td>";
            } else {
                var urlPDF = '<a href=javascript:gerapdf("' + itens[5].firstChild.data + '") ><img width="16px" src="images/pdf.png" border="0" title="PDF" align="absmiddle"></a>';
                tabela += "<td class='borda' align='center'>" + urlPDF + "</td>";
            }
            if (itens[6].firstChild.data == '_') {
                tabela += "<td class='borda' align='center'>&nbsp;</td>";
            } else {
                var urlXML = '<a href=javascript:geraxml("' + itens[6].firstChild.data + '") ><img width="16px" src="images/xml.png" border="0" title="XML" align="absmiddle"></a>';
                tabela += "<td class='borda' align='center'>" + urlXML + "</td>";
            }

            tabela += "</tr>";

        }

        tabela += "</table>";

        $("resultado").innerHTML = tabela;
        tabela = null;
    } else
        $("resultado").innerHTML = "Nenhuma carta de correção encontrada...";


    $("resultado2").innerHTML = "";

}


function geraxml(arq) {
		
	
    var values = new Array(arq,$("usuario").value);
    var keys = new Array("nome", "usuario");           
                
    openWindowWithPost('downloadxmlcte.php', '', keys, values);
    
}

function gerapdf(arq) {		
	
    window.open(arq, 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');			
    
}

function openWindowWithPost(url, name, keys, values)
{
	
    var winl = (screen.width - 960) / 2;
   
    var newWindow = window.open(url, name, 'status=yes, location=no, toolbar=no, directories=no, height=240,width=440,top=25,left=' + winl + ',scrollbars=yes,resizable=no');

    if (!newWindow)
        return false;

    var html = "";
    html += "<html><head></head><body><form id='formid' method='post' action='" + url + "'>";

    if (keys && values && (keys.length == values.length))
        for (var i = 0; i < keys.length; i++)
            html += "<input type='hidden' name='" + keys[i] + "' value='" + values[i] + "'/>";

    html += "</form><script type='text/javascript'>document.getElementById(\"formid\").submit()</sc" + "ript></body></html>";

    newWindow.document.write(html);
    return newWindow;
}

function load_itens(ctenumero) {

    new ajax('cartacorrecaocteconsultapesquisaitem.php?ctenumero=' + ctenumero, {
        onComplete: imprime_items
    });

}

function imprime_items(request) {

    var xmldoc = request.responseXML;

    if (xmldoc != null) {

        var tabela = "<table width='1000' border='1' cellspacing='1' cellpadding='1' bordercolor='#999999' bgcolor='#CCCCCC'><tr>"
        tabela += "<td width=\"100\" class='borda' bgcolor='#4f5963' bordercolor='#3366CC' align='center'><font color='#FFFFFF'><b>Grupo</b></font></td>";
        tabela += "<td width=\"100\" class='borda' bgcolor='#4f5963' bordercolor='#3366CC' align='center'><font color='#FFFFFF'><b>Campo</b></font></td>";
        tabela += "<td width=\"50\" class='borda' bgcolor='#4f5963' bordercolor='#3366CC' align='center'><font color='#FFFFFF'><b>Item</b></font></td>";
        tabela += "<td width=\"750\" class='borda' bgcolor='#4f5963' bordercolor='#3366CC' align='center'><font color='#FFFFFF'><b>Descrição</b></font></td></tr>";

        var registros = xmldoc.getElementsByTagName('registro');
        for (i = 0; i < registros.length; i++) {
            var itens = registros[i].getElementsByTagName('item');
            tabela += "<tr id=linha" + i + ">";
            tabela += "<td class='borda' align='center'>"
                    + itens[0].firstChild.data + "</td>";
            
            tabela += "<td class='borda' align='center'>"
                    + itens[1].firstChild.data + "</td>";
            
            tabela += "<td class='borda' align='center'>"
                    + itens[2].firstChild.data + "</td>";
            
            tabela += "<td class='borda' align='center'>"
                    + itens[3].firstChild.data + "</td>";            
            

            tabela += "</tr>";

        }

        tabela += "</table>";

        $("resultado2").innerHTML = tabela;
        tabela = null;
    } else
        $("resultado2").innerHTML = "Nenhuma alteração encontrada...";


}