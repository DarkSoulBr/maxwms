/**
 * @author Douglas
 *
 * Verificação dos dados para envio de formulario.
 *
 * Criação    20/03/2010
 * Modificado 20/03/2010
 *
 */

$(function()
{
	      $("#btnEditarPedido").click(function()
			{

                            var novoStatus = $("#listaStatus").val();
                            $.post('modulos/vendaAtacado/pedidos/manutencao/controller/acoes.php',
                                                {
                                                        //variaveis a ser enviadas metodo POST
                                                        pvnumero:pedido.pvnumero,
                                                        usucodigo:usuario.codigo,
                                                        novoStatus:novoStatus,
                                                        acao:27
                                                },
                                                function(data)
                                                {
                                                    clean();
                                                    alert(data.mensagem);

                                                },"json");
                                                
                        });
});
