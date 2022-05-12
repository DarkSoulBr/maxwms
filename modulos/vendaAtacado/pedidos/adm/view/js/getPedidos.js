$(function(){

    //localizar pedidos
    $("#btnPesquisaPedidos").click(function()
    {

        if ($("#listaPesquisaClientes").val() == null){
            return false;
        }
        //		if($('#formPesquisaPedidos').validate().form())
        //		{
        var titulo = "Pesquisando Aguarde!";
        var mensagem = "<em> Processando pesquisa, aguarde conclusão!</em>";
//        $('#msgPesqPedido').messageBoxElement(titulo, mensagem);
        var gerarMsgErro = false;

        $("#msgPesqPedido").show();
        var pesquisa = new Object();
        //declara variaveis recuperando valores
        pesquisa.tipoPesquisa = 'pvnumero';
        pesquisa.formaPesquisa = '2';
        pesquisa.txtPesquisa = $('#clipedido').val();
        var acao = 25;

        //Envia os dados via metodo post
        $.post('modulos/vendaAtacado/pedidos/manutencao/controller/acoes.php',
        {
            //variaveis a ser enviadas metodo POST
            tipoPesquisa:pesquisa.tipoPesquisa,
            formaPesquisa:pesquisa.formaPesquisa,
            txtPesquisa:pesquisa.txtPesquisa,
            acao:acao
        },
        function(data)
        {

            $("#msgPesqPedido").hide();

            if (Boolean(Number(data.retorno)))
            {
                $("#retorno").messageBox(data.mensagem,data.retorno,true);

                pedidos = data.pedidos;
                pedido = new Object();

                var opcoes = '';
                var possuiItens = false;

                $.each(pedidos, function (key, value)
                {

                        if( cliente.clicod  != value.cliente.clicod ){
                               mensagem = 'PEDIDO NÃO PERTENCE A ESTE CLIENTE.<br/> - SELECIONE OUTRO PEDIDO';
//                                $("#retorno").messageBox(mensagem,null,null);
//                                $("clipedido").focus();
//                                return false;
                                     gerarMsgErro = true;
                         }
                        if( cliente.sac != null ) {
//                             $.each(cliente.sac.sac_item.itensPedido, function (key, itensPedido) {
                             $.each(value.cliente.sac, function (key, valueSac) {

                                 if(possuiItens){ return false; }
                                 
                                 if(valueSac.sac_item != 'undefined' && valueSac.sac_item != null){
                                        if(valueSac.sac_item.itensPedido != 'undefined' && valueSac.sac_item.itensPedido != null){
                                            $.each(valueSac.sac_item.itensPedido, function (key, valueItem){
                                 
                                                    if ( (valueItem.SacItem.pvnumero == $("#clipedido").val())){
                                                            if(valueItem.SacItem.saccodigo != $("#saccodigo").val() ){
                                                                mensagem = 'ESTE PEDIDO ENCONTRA-SE NO CHAMADO DE NÚMERO '+valueSac.saccodigo+'.<br/> - SELECIONE OUTRO PEDIDO';
                                                                gerarMsgErro = true;
                                                                possuiItens = true;
                                                                return false;
                                                            }
                                                    }

                                                });
                                            }
                                        }
                                });
                            }
                            
                    if(gerarMsgErro) {
                                        $("#retorno").messageBox(mensagem,null,null);
                                        $("clipedido").focus();
                                        return false;
                    }


                    var pvemissao = value.pvemissao;
                    var html = '<h5>OBS.: SELECIONE OS ITENS E CLIQUE EM OK PARA INCLUIR AO CHAMADO. </h5>';
                    var tabelaItensInicio =
                    "<table  width='530' cellspacing='0' cellpadding='0' bordercolor='C0C0C0' border='1'>"+
                    "<tbody >"+
                    "<tbody id='gridProdutoPedido' name='gridProdutoPedido'>"+
                    "<tr bgcolor='#3366CC'  >"+
                    "<td align='center' width='50' height='20'>"+
                    "<font  color='#FFFFFF'><b>Pedido</b></font></td>"+
                    "<td align='center' width='50' height='20'>"+
                    "<font  color='#FFFFFF'><b>Código</b></font></td>"+
                    "<td width='140'  align='center'><font  color='#FFFFFF'><b>Produto</b></font></td>"+
                    "<td align='center' width='50'><font  color='#FFFFFF'><b>Qtd</b></font></td>"+
                    "<td align='center' width='50'><font  color='#FFFFFF'><b>Preço</b></font></td>"+
                    "<td align='center' width='50'><font  color='#FFFFFF'><b>Total</b></font></td>"+
                    "<td align='center' width='120' ><font  color='#FFFFFF'><b>Local de Faturamento</b></font></td>"+
                    "<td align='center' width='50' nowrap='nowrap'><font  color='#FFFFFF'><b>Qtd na Ocorrência</b></font></td>"+
                    "<td align='center' width='120' ><font  color='#FFFFFF'><b>Responsável</b></font></td>"+
                    "<td align='center' width='120'><font  color='#FFFFFF'><b>Observação</b></font></td>"+
                    "<td align='center' width='10'><input type='checkbox' class='selectAllProd'></td></tr>";

                    var tabelaItensFim = "</tbody></table>";

                    var countProd = 0;
                    var estoque = '';
                    var tabelaItens = '';
                    var tabItensTeste = '';
                    var tabelaItensCorpo = '';
                    var tabelaItensCorpoSemPedidoA ='';
                    var tabelaItensCorpoSemPedidoB ='';

                    $.each(value.itensPedido, function (key, valueItem)
                    {

                        if( valueItem.pedidoVendaItemEstoque.pviest026 != '' && valueItem.pedidoVendaItemEstoque.pviest026 != null ) {
                            estoque = 'GUARULHOS';
                        } else if( valueItem.pedidoVendaItemEstoque.pviest09 != ''  && valueItem.pedidoVendaItemEstoque.pviest09 != null ) {
                            estoque = 'VL. GUILHERME';
                        } else if( valueItem.pedidoVendaItemEstoque.pviest09 != ''  && valueItem.pedidoVendaItemEstoque.pviest09 != null ) {
                            estoque = 'VIX';
                        } else if( valueItem.pedidoVendaItemEstoque.pviest01 != '' && valueItem.pedidoVendaItemEstoque.pviest01 != null ) {
                            estoque = 'FILIAL';
                        } else if( valueItem.pedidoVendaItemEstoque.pviest02 != '' && valueItem.pedidoVendaItemEstoque.pviest02 != null) {
                            estoque = 'MATRIZ';
                        }

                        qtdItem = Number(valueItem.pvisaldo);
                        precoItem = $.mask.string(parseFloat(valueItem.pvipreco).toFixed(2), "decimal");
                        totalItemTmp = valueItem.pvisaldo * valueItem.pvipreco;
                        totalItem = $.mask.string(parseFloat(totalItemTmp).toFixed(2), 'decimal');

                        itemResp = (valueItem.SacItem.sacitresponsavel != null)? valueItem.SacItem.sacitresponsavel:"";
                        itemObs = (valueItem.SacItem.sacitresponsavel != null)? valueItem.SacItem.sacitobs:"";
                        qtdProd = (valueItem.SacItem.sacitqtd != null)? valueItem.SacItem.sacitqtd:"";

                        if (countProd % 2==0){
                            corFundo = "#FFFFFF";
                        } else {
                            corFundo = "#EEEEEE";
                        }
                        
                        tabelaItens += "<tr class='bodyProduto' bgcolor='"+corFundo+"'>";
//                        tabelaItens += "<td align='center' height='32' ' id='produtoPedido"+value.pvnumero+"_"+countProd+"'>"+value.pvnumero+"</td>";
                        tabelaItens += "<td align='center' height='32' id='produtoPedido"+value.pvnumero+"_"+countProd+"'>"+
                                                     "<a href='pedvendacons2.php?codped="+value.pvnumero+"' target='_blank' >"+value.pvnumero+"</a></td>";
                        tabelaItens += "<td align='center' height='32' '>"+valueItem.produto.procod+
                                                    "<input type='hidden' name='prodcod"+value.pvnumero+"' id='prodcod"+value.pvnumero+"_"+countProd+"' value='"+valueItem.produto.procodigo+"' ></td>"+
                                                    "<td width='140'>"+valueItem.produto.prnome+"</td>"+
                                                    "<td align='center'  width='50'>"+qtdItem+"</td>"+
                                                    "<td align='center'  width='50'>"+precoItem+"</td>"+
                                                    "<td align='right'  width='50'>"+totalItem+"</td>"+
                                                    "<td align='center' width='120'>"+estoque+"</td>";

                        //                                     tabelaItens += "<td align='center' > <input name='prodqtd"+value.pvnumero+"' style='width:20px;'  id='prodqtd"+value.pvnumero+"' type='text' value='0' size='20' style='text-align:center;' /></td>";
                        tabelaItens += "<td align='center' width='50'> <select name='prodqtd"+value.pvnumero+"_"+countProd+"' id='prodqtd"+value.pvnumero+"_"+countProd+"'   style='text-align:center;width:50px;height:21px' >";

                        // deixa o radio box selecionado.
                        for (i = 0; i <= qtdItem; i++) {
                            tabelaItens += (i == Number(qtdProd))? "<option value='"+i+"' selected>"+i+"</option>":"<option value='"+i+"'>"+i+"</option>";
                        }
                        tabelaItens += "</select></td>";
                        tabelaItens += "<td align='center' > <input name='prodresp"+value.pvnumero+"_"+countProd+"'  id='prodresp"+value.pvnumero+"_"+countProd+"' type='text' value='"+itemResp+"'  style='text-align:center;width:120px' /></td>"+
                        "<td align='center' > <input name='prodobs"+value.pvnumero+"_"+countProd+"'  id='prodobs"+value.pvnumero+"_"+countProd+"' type='text' value='"+itemObs+"'  style='text-align:center;width:120px' /></td>"+
                        "<td align='center'> <input type='checkbox' name='prodcount"+value.pvnumero+"_"+countProd+"' id='prodcount"+value.pvnumero+"_"+countProd+"'";

                        if((itemResp != '') || (itemObs != '') ) {
                            tabelaItens +="checked class='selectProd' ></td></tr>";
                        } else {
                            tabelaItens +=" class='selectProd' ></td></tr>";
                        }
                        countProd++;

                    });

                    html +=tabelaItensInicio+tabelaItens+tabelaItensFim;

                    $('#retornoLiberacao').attr('title','ITENS  - PEDIDO '+value.pvnumero+' - '+value.cliente.clirazao);
                    $('#retornoLiberacao').html(html);

                    $('#retornoLiberacao').dialog(
                    {
                        autoOpen: true,
                        modal: true,
                        width: 800,
                        buttons:
                        {
                            "OK": function()
                            {

                                var counter = 0;

                                //<img src='imagens/delete.gif'>
                                $("#tableproduto").show();
                                //$('#gridproduto').append(tabItensTeste);
                                $("input:checkbox:checked").each(function() {
                                        counter++;
                                            var cloneTest = $(this).parent().parent().clone().end().appendTo('#gridproduto');
                                    });
                                $(this).dialog("close");

//                                $("#tableproduto").find(".")
                            }

                        },
                        close: function(ev, ui)
                        {
                            $(this).dialog("destroy");
                        }
                    });
                    
                    
                });
            }
            else
            {
                $("#retorno").messageBox(data.mensagem,data.retorno,false);
            }
            
        }, "json");

    //		}
    });

//	$('#listaPesquisaPedidos').change(function(){
//		pedido = pedidos[$(this).val()];
//	});
//
//	$('#dataEmissaoPedidos').change(function(){
//		pedido = pedidos[$(this).val()];
//	});
//
//	if($('#txtPesquisaPedidos').val())
//	{
//		$("#btnPesquisaPedidos").trigger('click');
//	}
});