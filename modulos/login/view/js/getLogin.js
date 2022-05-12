

var usuario = new Object();

$(function () {
    $("#btnLogin").click(function ()
    {
        if ($('#formLogin').validate().form())
        {
            var titulo = "VERIFICANDO LOGIN.";
            var mensagem = "PROCESSANDO USUARIO E SENHA PARA ACESSO.";
            $("#retorno").messageBoxModal(titulo, mensagem);

            //pega o valores
            var login = $('#login').val();
            var senha = $('#senha').val();

            //Envia os dados via metodo post
            $.post('modulos/login/controller/acoes.php',
                    {
                        login: login,
                        senha: senha
                    },
                    function (data)
                    {
                        $.unblockUI();

                        $("#retorno").messageBox(data.mensagem, data.retorno, data.retorno);

                        if (Boolean(Number(data.retorno)))
                        {
                            setTimeout("location.href='maxwms.php'", 1000);
                        }
                    }, "json");
        }
    });
});