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

function env(usuario) {


    var codigo = document.getElementById('ctecodigo').value;

    var erro = 0;
    if (codigo == "")
    {
        alert("Escolha o CT-e!");
        erro = 1;
    } else {

        var campovet01 = '';
        var campovet02 = '';
        var campovet03 = '';
        var campovet04 = '';

        for (j = 0; j < vetorrateio.length; j++)
        {
            if (vetorrateio[j][0] != '')
            {
                campovet01 = campovet01 + '&grupo[]=' + vetorrateio[j][0];
                campovet02 = campovet02 + '&campo[]=' + vetorrateio[j][1];
                campovet03 = campovet03 + '&item[]=' + vetorrateio[j][2];
                campovet04 = campovet04 + '&valor[]=' + vetorrateio[j][3];
            }
        }
        
        if(campovet01=='') {
            alert("Digite pelo menos um evento!");
            erro = 1;
        }

    }

    if (erro == 0) {
       
         new ajax('cartacorrecaoctexml.php?ctecodigo=' + document.getElementById('ctecodigo').value         
         + '&usuario=' + usuario
         + campovet01
         + campovet02
         + campovet03
         + campovet04
         , {onComplete: limpa_form});
        
    }

}


function limpa_form() {

    alert("XML de Carta de Correção gerada com sucesso!");
    window.open('cartacorrecaocte.php', "_self");

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

        var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
        var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
        var descricao2 = item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;

        var descricao3 = item.getElementsByTagName("descricao3")[0].firstChild.nodeValue;
        var descricao4 = item.getElementsByTagName("descricao4")[0].firstChild.nodeValue;
        var descricao5 = item.getElementsByTagName("descricao5")[0].firstChild.nodeValue;
        var descricao6 = item.getElementsByTagName("descricao6")[0].firstChild.nodeValue;

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
        
        if(descricao6==0) {

            $("ctecodigo").value = codigo;
            $("controle").value = codigo;
            $("numero").value = descricao;
            $("chave").value = descricao2;
            $("protocolo").value = descricao5;
            
        } else {
            
            alert('Carta de Correção já lançada para este CT-e!');
            
            $("ctecodigo").value = "";
            $("ctecodigo").value = "";
            $("controle").value = "";
            $("numero").value = "";
            $("chave").value = "";
            $("protocolo").value = "";
            
        }


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


function incluinotacli()
{

    var codigo = document.getElementById('ctecodigo').value;
    var grupo = document.getElementById("grupo").value;
    var campo = document.getElementById("campo").value;
    var item = document.getElementById("item").value;
    var obs = document.getElementById("observacoes").value;

    var erro = 0;
    if (codigo == "")
    {
        alert("Escolha o CT-e!");
        erro = 1;
        return false;
    } else if (grupo == "")
    {
        alert("Digite o Grupo!");
        erro = 1;
        return false;
    } else if (campo == "") {
        alert("Digite o Campo!");
        erro = 1;
        return false;
    } else if (item == '') {
        alert("Digite o Item!");
        erro = 1;
        return false;
    } else if (obs == '') {
        alert("Digite o Valor!");
        erro = 1;
        return false;
    }
    if (erro == 0) {

        registros = 0;
        registroexistente = 0;
        for (j = 0; j < vetorrateio.length; j++)
        {
            if (vetorrateio[j][0] != '')
            {
                //testa se nota já existe
                if (vetorrateio[j][0] == grupo && vetorrateio[j][1] == campo && vetorrateio[j][2] == item)
                    registroexistente++;

                //conta a quantidade de registros existentes no vetor
                registros = j;
            }
        }

        if (registroexistente > 0) {
            alert("Evento já Lançado!");
        } else {

            //pega o valor total de registros no vetor e soma mais um
            registros++;

            //Atribui os dados do produto para o vetor
            vetorrateio[registros][0] = grupo;
            vetorrateio[registros][1] = campo;
            vetorrateio[registros][2] = item;
            vetorrateio[registros][3] = obs;

            $("grupo").value = '';
            $("campo").value = '';
            $("item").value = '';
            $("observacoes").value = '';

            document.forms[0].listtipos.options[0].selected = true;

            montahtmlnotacli();

        }
    }

}

function montahtmlnotacli()
{

    var gridproduto2 = '<table border="1" bordercolor="C0C0C0" cellpadding="0" cellspacing="0" width="650" align="center"><tr bgcolor="#4f5963">';
    gridproduto2 += '<td align="center" width="100"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><b>Grupo</b></font></td>';
    gridproduto2 += '<td align="center" width="100"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><b>Campo</b></font></td>';
    gridproduto2 += '<td align="center" width="100"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><b>Item</b></font></td>';
    gridproduto2 += '<td align="center" width="200"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><b>Valor</b></font></td>';
    gridproduto2 += '<td align="center" width="100"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><b>Ação</b></font></td>';
    gridproduto2 += '</tr>';

    var j = 0;

    for (j = 0; j < vetorrateio.length; j++)
    {
        if (vetorrateio[j][0] != '')
        {
            gridproduto2 += '<tr bgcolor="#FFFFFF">';
            gridproduto2 += '<td align="center" width="100">' + vetorrateio[j][0] + '</td>';
            gridproduto2 += '<td align="center" width="100">' + vetorrateio[j][1] + '</td>';
            gridproduto2 += '<td align="center" width="100">' + vetorrateio[j][2] + '</td>';
            gridproduto2 += '<td align="center" width="250">' + vetorrateio[j][3] + '</td>';
            gridproduto2 += '<td align="center" width="100" style="font-size:10px;"><a href="javascript:excluirnotacli(' + j + ');" style="text-decoration:none; color:#000000;"><img src="images/trash.png" border="0" title="Excluir" align="absmiddle">Excluir</a></td>';
            gridproduto2 += '</tr>';
        }
    }
    if (j == 0)
    {
        gridproduto2 += '<tr bgcolor="#FFFFFF">';
        gridproduto2 += '<td align="center" colspan="7" width="393">Nenhum Evento Adicionado!</td>';
        gridproduto2 += '</tr>';
    }
    gridproduto2 += '</table>';

    $("gridproduto2").innerHTML = gridproduto2;
    $("gridprodutomsg2").innerHTML = "";

}

function excluirnotacli(produto)
{

    j = produto;

    vetorrateio[j][0] = '';
    vetorrateio[j][1] = '';
    vetorrateio[j][2] = '';
    vetorrateio[j][3] = '';

    montahtmlnotacli();

}


function cancelarPedido()
{
    window.open('cartacorrecaocte.php', "_self");
}

function dadospesquisatipo(valor)
{
    //verifica se o browser tem suporte a ajax
    try {
        ajax2fiscal = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (e) {
        try {
            ajax2fiscal = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (ex) {
            try {
                ajax2fiscal = new XMLHttpRequest();
            } catch (exc) {
                alert("Esse browser não tem recursos para uso do Ajax");
                ajax2fiscal = null;
            }
        }
    }
    //se tiver suporte ajax
    if (ajax2fiscal) {
        //deixa apenas o elemento 1 no option, os outros são excluídos
        document.forms[0].listtipos.options.length = 1;

        idOpcao = document.getElementById("opcoes11");

        ajax2fiscal.open("POST", "cartapesquisatipo.php", true);
        ajax2fiscal.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2fiscal.onreadystatechange = function () {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2fiscal.readyState == 1) {
                idOpcao.innerHTML = "Carregando...!";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if (ajax2fiscal.readyState == 4) {
                if (ajax2fiscal.responseXML) {
                    processXMLtipo(ajax2fiscal.responseXML);
                } else {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "____________________";
                }
            }
        }
        //passa o parametro
        var params = "parametro=" + valor;
        ajax2fiscal.send(params);
    }
}

function processXMLtipo(obj)
{
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados

        document.forms[0].listtipos.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
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
            novo.setAttribute("id", "opcoes11");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto
            novo.text = descricao;
            //finalmente adiciona o novo elemento
            document.forms[0].listtipos.options.add(novo);
        }
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo
        idOpcao.innerHTML = "____________________";
    }
    //dadospesquisatributo1(0);	 	  
}


function dadostipos(valor)
{

    if (valor > 0) {

        //verifica se o browser tem suporte a ajax
        try {
            ajax2fiscal = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (e) {
            try {
                ajax2fiscal = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (ex) {
                try {
                    ajax2fiscal = new XMLHttpRequest();
                } catch (exc) {
                    alert("Esse browser não tem recursos para uso do Ajax");
                    ajax2fiscal = null;
                }
            }
        }
        //se tiver suporte ajax
        if (ajax2fiscal) {
            //deixa apenas o elemento 1 no option, os outros são excluídos

            ajax2fiscal.open("POST", "cartapesquisatipo.php", true);
            ajax2fiscal.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            ajax2fiscal.onreadystatechange = function () {
                //enquanto estiver processando...emite a msg de carregando
                if (ajax2fiscal.readyState == 1) {
                }
                //após ser processado - chama função processXML que vai varrer os dados
                if (ajax2fiscal.readyState == 4) {
                    if (ajax2fiscal.responseXML) {
                        processXMLdados(ajax2fiscal.responseXML);
                    } else {
                        //caso não seja um arquivo XML emite a mensagem abaixo

                    }
                }
            }
            //passa o parametro
            var params = "parametro=" + valor;
            ajax2fiscal.send(params);
        }
    }
}

function processXMLdados(obj)
{
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
            var grupo = item.getElementsByTagName("grupo")[0].firstChild.nodeValue;
            var campo = item.getElementsByTagName("campo")[0].firstChild.nodeValue;
            var item = item.getElementsByTagName("item")[0].firstChild.nodeValue;

            if (grupo == '_') {
                $("grupo").value = '';
                $("campo").value = '';
                $("item").value = '';
            } else {
                $("grupo").value = grupo;
                $("campo").value = campo;
                $("item").value = item;
            }

        }
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo
        $("grupo").value = '';
        $("campo").value = '';
        $("item").value = '';
    }
}