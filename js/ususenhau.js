// JavaScript Document   

function enviar()
{

    //verifica se o browser tem suporte a ajax
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
                alert("Esse browser n?o tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    //se tiver suporte ajax
    if (ajax2)
    {

        ajax2.open("POST", "ususenhaupesquisa.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {

            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1)
            {
            }
            //ap?s ser processado - chama fun??o processXML que vai varrer os dados
            if (ajax2.readyState == 4)
            {

                if (ajax2.responseXML)
                {
                    processXMLx(ajax2.responseXML);
                } else
                {
                    //caso n?o seja um arquivo XML emite a mensagem abaixo
                }
            }
        };
        //passa o parametro escolhido

        var codigo = document.getElementById('codigo').value;
        var descricao3 = document.getElementById('descricao3').value;
        var descricaox = document.getElementById('descricaox').value;

        var params = "codigo=" + codigo + "&descricao3=" + descricao3 + "&descricaox=" + descricaox;
        ajax2.send(params);
    }


}


function processXMLx(obj)
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
            //cont?udo dos campos no arquivo XML

            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;

            if (codigo == 0)
            {
                alert("A senha cadastrada ? a mesma, escolha outra senha!")
                return;
            } else if (codigo == 2)
            {
                alert("Senha atual inv?lida!")
                return;
            } else
            {
                enviar2();
            }


        }
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo

    }
}


function enviar2()
{
    new ajax('ususenhaualtera.php?descricao3=' + document.getElementById('descricao3').value + "&codigo=" + document.getElementById('codigo').value
            , {onComplete: limpar});

    alert("Senha alterada com sucesso!");

    /*
     document.forms[0].listDados.options.length = 0;
     
     var novo = document.createElement("option");
     //atribui um ID a esse elemento
     novo.setAttribute("id", "opcoes");
     //atribui um valor
     novo.value = document.getElementById('codigo').value;
     //atribui um texto
     novo.text  = document.getElementById('descricao').value;
     //finalmente adiciona o novo elemento
     document.forms[0].listDados.options.add(novo);
     */

}

function limpar()
{

    //$("pesquisa").value="";
    //$("codigo").value="";
    //$("descricao").value="";
    //$("descricao2").value="";
    $("descricao3").value = "";
    $("descricao4").value = "";
    $("descricaox").value = "";

    /*
     //deixa apenas o elemento 1 no option, os outros s?o exclu?dos
     document.forms[0].listDados.options.length = 0;
     //cria um novo option dinamicamente
     var novo = document.createElement("option");
     //atribui um ID a esse elemento
     novo.setAttribute("id", "opcoes");
     //atribui um valor
     novo.value = 0;
     //atribui um texto
     novo.text  = "__________________";
     //finalmente adiciona o novo elemento
     document.forms[0].listDados.options.add(novo);
     */

}

function valida_form()
{
    /*
     if($("pesquisa").value==""){
     alert("Preencha o campo LOGIN");
     $("pesquisa").focus();
     return false;
     }
     else
     {
     */

    if ($("descricaox").value == "")
    {
        alert("Preencha o campo Senha Atual");
        $("descricaox").focus();
        return false;
    }


    if ($("descricaox").value == $("descricao3").value)
    {
        alert("Senha nova deve ser diferente da atual!");
        $("descricaox").focus();
        return false;
    }

    if ($("descricao3").value == "")
    {
        alert("Preencha o campo Senha Nova");
        $("descricao3").focus();
        return false;
    } else
    {
        if ($("descricao3").value.length < 3)
        {
            alert("Senha deve conter mais de 3 caracteres");
            $("descricao3").focus();
            return false;
        } else
        {
            if ($("descricao3").value == $("descricao4").value)
            {
                enviar();
                //alert("Senha alterada com sucesso!");
            } else
            {
                alert("Senha n?o confere");
                $("descricao4").focus();
                return false;
            }
        }
    }
//	}
}

function dadospesquisa(valor)
{
    //verifica se o browser tem suporte a ajax
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
                alert("Esse browser n?o tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    //se tiver suporte ajax
    if (ajax2)
    {
        //deixa apenas o elemento 1 no option, os outros s?o exclu?dos
        document.forms[0].listDados.options.length = 1;

        idOpcao = document.getElementById("opcoes");

        ajax2.open("POST", "usuariopesquisa.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1)
            {
                idOpcao.innerHTML = "Carregando...!";
            }
            //ap?s ser processado - chama fun??o processXML que vai varrer os dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXML(ajax2.responseXML);
                } else
                {
                    //caso n?o seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "____________________";
                }
            }
        };
        //passa o parametro
        var params = "parametro=" + valor;

        if (valor != "" || valor != 0)
            ajax2.send(params);
        else
            alert("Preencha o campo LOGIN corretamente!");
    }
}


function dadospesquisa2(valor)
{

    //verifica se o browser tem suporte a ajax
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
                alert("Esse browser n?o tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    //se tiver suporte ajax
    if (ajax2)
    {
        ajax2.open("POST", "usuariopesquisa2.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1)
            {
            }
            //ap?s ser processado - chama fun??o processXML que vai varrer os dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXML2(ajax2.responseXML);
                } else
                {
                    //caso n?o seja um arquivo XML emite a mensagem abaixo
                }
            }
        };
        //passa o parametro escolhido
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function dadospesquisa3(valor)
{
    //verifica se o browser tem suporte a ajax
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
                alert("Esse browser n?o tem recursos para uso do Ajax");
                ajax2 = null;
            }
        }
    }
    //se tiver suporte ajax
    if (ajax2)
    {
        //deixa apenas o elemento 1 no option, os outros s?o exclu?dos
        document.forms[0].listDados.options.length = 1;

        idOpcao = document.getElementById("opcoes");

        ajax2.open("POST", "usuariopesquisa3.php", true);
        ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax2.onreadystatechange = function ()
        {
            //enquanto estiver processando...emite a msg de carregando
            if (ajax2.readyState == 1)
            {
                idOpcao.innerHTML = "Carregando...!";
            }
            //ap?s ser processado - chama fun??o processXML que vai varrer os dados
            if (ajax2.readyState == 4)
            {
                if (ajax2.responseXML)
                {
                    processXML(ajax2.responseXML);
                } else
                {
                    //caso n?o seja um arquivo XML emite a mensagem abaixo
                    idOpcao.innerHTML = "____________________";
                }
            }
        };
        //passa o parametro escolhido
        var params = "parametro=" + valor;
        ajax2.send(params);
    }
}

function processXML(obj)
{
    //pega a tag dado
    var dataArray = obj.getElementsByTagName("dado");

    //total de elementos contidos na tag dado
    if (dataArray.length > 0)
    {
        //percorre o arquivo XML paara extrair os dados

        document.forms[0].listDados.options.length = 0;

        for (var i = 0; i < dataArray.length; i++)
        {
            var item = dataArray[i];
            //cont?udo dos campos no arquivo XML
            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
            var descricao2 = item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;
            var descricao3 = item.getElementsByTagName("descricao3")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;
            trimjs(descricao2);
            descricao2 = txt;
            trimjs(descricao3);
            descricao3 = txt;

            //cria um novo option dinamicamente
            var novo = document.createElement("option");
            //atribui um ID a esse elemento
            novo.setAttribute("id", "opcoes");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto
            novo.text = descricao;
            //finalmente adiciona o novo elemento
            document.forms[0].listDados.options.add(novo);

            if (i == 0)
            {
                $("codigo").value = codigo;
                $("descricao").value = descricao;
                $("descricao2").value = descricao2;
                $("descricao3").value = "";
                $("descricao4").value = "";


            }
        }
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo

        $("codigo").value = "";
        $("descricao").value = "";
        $("descricao2").value = "";
        $("descricao3").value = "";
        $("descricao4").value = "";
        $("acao").value = "inserir";
        $("botao").value = "Incluir";

        idOpcao.innerHTML = "____________________";

        itemcombo(1);
        document.getElementById("radioe1").checked = true;
        document.getElementById("radiol1").checked = true;
    }
}

function processXML2(obj)
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
            //cont?udo dos campos no arquivo XML

            var codigo = item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao = item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
            var descricao2 = item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;
            //var descricao3 =  item.getElementsByTagName("descricao3")[0].firstChild.nodeValue;

            trimjs(codigo);
            codigo = txt;
            trimjs(descricao);
            descricao = txt;
            trimjs(descricao2);
            descricao2 = txt;
            //trimjs(descricao3);
            //descricao3 = txt;

            $("codigo").value = codigo;
            $("descricao").value = descricao;
            $("descricao2").value = descricao2;
            $("descricao3").value = "";
            $("descricao4").value = "";
        }
    } else
    {
        //caso o XML volte vazio, printa a mensagem abaixo
        $("codigo").value = "";
        $("descricao").value = "";
        $("descricao2").value = "";
        $("descricao3").value = "";
        $("descricao4").value = "";
    }
}