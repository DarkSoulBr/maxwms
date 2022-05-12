function env(usuario) {


    if (document.getElementById("botao3").innerHTML == "Confirma") {

        var erro = 0;

        if (document.getElementById('motivo').value == '') {
            erro = 1;
            alert("Preencha o Motivo da Inutilização!");
        }

        if (erro == 0) {
            //window.open ('inutilizacaocteconfirma.php?motivo=' + document.getElementById('motivo').value 
            new ajax('inutilizacaocteconfirma.php?motivo=' + document.getElementById('motivo').value
                    + '&usuario=' + usuario
                    + '&ctecodigo=' + document.getElementById('ctecodigo').value
                    + '&numero=' + document.getElementById('numero').value
                    + '&chave=' + document.getElementById('chave').value
                    , {onComplete: limpa_form});
            //, '_blank');
        }

    } else
    {

        new ajax('inutilizacaoctereativa.php?ctecodigo=' + document.getElementById('ctecodigo').value
                + '&numero=' + document.getElementById('numero').value
                , {onComplete: limpa_form2});

    }

}


function limpa_form() {

    alert("CTe Inutilizado com Sucesso!");
    window.open('inutilizacaocte.php', '_self');

}


function limpa_form2() {

    alert("Reativacao concluida com sucesso!");
    window.open('inutilizacaocte.php', '_self');

}


function dadospesquisa(valor) {


    $("motivo").value = '';
    $("motivo").disabled = false;
    $("botao3").disabled = false;

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

        ajax2.open("POST", "ctepesquisainutiliza.php", true);
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

        $("ctecodigo").value = codigo;
        $("controle").value = codigo;
        $("numero").value = descricao;
        $("chave").value = descricao2;


        if (descricao3 != 'X') {

            $("motivo").value = descricao4;
            $("motivo").disabled = true;
            document.getElementById("botao3").innerHTML = "Reativar";


            alert('Cte ja foi Inutilizado!');

        } else
        {
            document.getElementById("botao-text").innerHTML = "Confirma";

        }



    } else {
        //caso o XML volte vazio, printa a mensagem abaixo

        $("ctecodigo").value = "";
        $("ctecodigo").value = "";
        $("controle").value = "";
        $("numero").value = "";
        $("chave").value = "";


    }
}


